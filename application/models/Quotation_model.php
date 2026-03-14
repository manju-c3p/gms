<?php defined('BASEPATH') or exit('No direct script access allowed');

class Quotation_model extends CI_Model
{
	/* =====================================================
       CREATE QUOTATION FROM ESTIMATION (AUTO)
       ===================================================== */
	public function create_from_estimation($estimation_id)
	{
		// 1. Fetch estimation
		$est = $this->db
			->where('estimation_id', $estimation_id)
			->get('estimations')
			->row();

		if (!$est) {
			return false;
		}

		// =====check whether the estimation has a parent estimation id.
		// if exist, check quotation with that estimation id and create a revision of that quotation.
		// If not exist, crete a new quotation==================

		$parent_estid = $est->parent_estimation_id;
		log_message('error', $parent_estid);

		// 2. Check if quotation already exists with parent_estimation_id
		$quotation_parent = $this->db
			->where('estimation_id', $parent_estid)
			->get('quotations')
			->row();
		if ($quotation_parent) {
			log_message('error', 'quote parent');
			$quotation_no_parent = $quotation_parent->quotation_no;
			$quotation_revision_no =  $quotation_parent->revision_no;
			$revisionNo = $quotation_revision_no + 1;
			$parent_quotation_id = $quotation_parent->quotation_id;
			// $new_quoteno = $quotation_no_parent . "-REV-" . $revisionNo;
			// Remove existing REV part if exists
			$base_no = preg_replace('/-REV-\d+$/', '', $quotation_no_parent);

			$new_quoteno = $base_no . "-REV-" . $revisionNo;
		} else {
			log_message('error', 'quote new');
			// 3. Generate quotation number
			$new_quoteno = $this->generate_quotation_no();
			$revisionNo = 0;
			$quotation_no_parent = "";
		}

		// 2. Prevent duplicate quotation creation
		$exists = $this->db
			->where('estimation_id', $estimation_id)
			->where('revision_no', 1)
			->get('quotations')
			->row();

		if ($exists) {
			return $exists->quotation_id;
		}



		// 4. Insert quotation (REVISION 1)
		$this->db->insert('quotations', [
			'quotation_no'            => $new_quoteno,
			'quotation_date'          => date('Y-m-d'),
			'estimation_id'           => $est->estimation_id,
			'appointment_id'          => $est->appointment_id,
			'inspection_id'           => $est->inspection_id,
			'customer_id'             => $est->customer_id,
			'vehicle_id'              => $est->vehicle_id,
			// 'subtotal'                => $est->subtotal,
			// 'tax_amount'              => $est->tax_amount,
			'discount'                => $est->discount,
			// 'grand_total'             => $est->grand_total,
			'quotation_time'          => $est->estimation_time,
			'est_delivery_date'       => $est->est_delivery_date,
			'est_completion_time'     => $est->est_completion_time,
			'customer_approval'       => $est->customer_approval,
			'customer_estimated_price' => $est->customer_estimated_price,
			'revision_no'             => $revisionNo,
			'parent_quotation_id'     => $parent_quotation_id,
			'status'                  => 'Draft',
			'remarks'                 => $est->remarks,
			'created_at'              => date('Y-m-d H:i:s'),
			'srvice_discount'                 => $est->service_discount,
			'sublet_discount'                 => $est->sublet_discount,
		]);

		$quotation_id = $this->db->insert_id();

		/* ===============================
           COPY PARTS
           =============================== */
		$this->db->query("
            INSERT INTO quotation_parts
            (quotation_id, part_id, qty, unit_price, selling_price, total_price,
             markup_percentage, discount, dis_amount, part_type, brand_id, selected, created_at,partremarks)
            SELECT
                {$quotation_id},
                part_id,
                qty,
                unit_price,
                selling_price,
                total_price,
                markup_percentage,
                discount,
                dis_amount,
                part_type,
                brand_id,
                selected,
                NOW(),
				partremarks
            FROM estimation_parts
            WHERE estimation_id = {$estimation_id} and selected = 1
        ");

		/* ===============================
           COPY SERVICES
           =============================== */
		$this->db->query("
            INSERT INTO quotation_services
            (quotation_id, service_id, estimated_time, estimated_cost, total_cost, created_at,discount_percentage,discount_amount,taxable_amount)
            SELECT
                {$quotation_id},
                service_id,
                estimated_time,
                estimated_cost,
                total_cost,
                NOW(),
				discount_percentage,
				discount_amount,
				taxable_amount
            FROM estimation_services
            WHERE estimation_id = {$estimation_id}
        ");
		/* ===============================
           COPY job description
           =============================== */
		$this->db->query("
				INSERT INTO quotation_job_descriptions
				(quotation_id, description, employee_id, created_at,amount,discount_percentage,discount_amount,taxable_amount)
				SELECT
					{$quotation_id},
					description,
					employee_id,
					NOW(),
					amount,
					discount_percentage,
					discount_amount,
					taxable_amount

				FROM estimation_job_descriptions
				WHERE estimation_id = {$estimation_id}
			");


		// ==========================================

		// ===== SUBTOTAL (sum of total_price) =====
		$row = $this->db
			->select('SUM(total_price) as subtotal')
			->where('quotation_id', $quotation_id)
			->where('selected', 1)
			->get('quotation_parts')
			->row();

		$parts_subtotal = (float)($row->subtotal ?? 0);
		// ===== TOTAL DISCOUNT =====
		$row = $this->db
			->select('SUM(dis_amount) as discount')
			->where('quotation_id', $quotation_id)
			->where('selected', 1)
			->get('quotation_parts')
			->row();

		$total_discount = (float)($row->discount ?? 0);
		// ===== SERVICES =====
		$services_total = (float)($this->db
			->select('SUM(total_cost) as total')
			->where('quotation_id', $quotation_id)
			->get('quotation_services')
			->row()->total ?? 0);

		// ===== SUBLET SERVICES =====
		$sublet_total = (float)($this->db
			->select('SUM(amount) as total')
			->where('quotation_id', $quotation_id)
			->get('quotation_job_descriptions')
			->row()->total ?? 0);
		// ===== FINAL TOTALS =====
		$subtotal = $parts_subtotal + $services_total + $sublet_total;

		// discount only from parts
		$discount = $total_discount;

		// taxable amount
		$taxable_amount = $subtotal - $discount;

		// VAT 5%
		$tax_amount = round($taxable_amount * 5 / 100, 2);

		// grand total
		$grand_total = round($taxable_amount + $tax_amount, 2);
		$this->db->where('quotation_id', $quotation_id)->update('quotations', [
			'subtotal'    => round($subtotal, 2),
			'discount'    => round($discount, 2),
			'tax_amount'  => $tax_amount,
			'grand_total' => $grand_total
		]);
		// ==============================================


		return $quotation_id;
	}

	/* =====================================================
       QUOTATION NUMBER GENERATOR
       ===================================================== */
	private function generate_quotation_no12333()
	{
		$year = date('Y');

		$last = $this->db
			->like('quotation_no', "QT-$year-", 'after')
			->order_by('quotation_id', 'DESC')
			->limit(1)
			->get('quotations')
			->row();

		if ($last) {
			$last_no = intval(substr($last->quotation_no, -4));
			$new_no  = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
		} else {
			$new_no = '0001';
		}

		return "QT-$year-$new_no";
	}
	private function generate_quotation_no($parent_id = null)
	{
		$year = date('Y');

		// NEW QUOTATION
		if ($parent_id == null) {

			$this->db->like('quotation_no', "QT-$year-", 'after');
			$this->db->not_like('quotation_no', 'REV');
			$this->db->order_by('quotation_id', 'DESC');
			$this->db->limit(1);

			$last = $this->db->get('quotations')->row();

			if ($last) {
				$parts = explode('-', $last->quotation_no);
				$last_no = intval($parts[2]);
				$new_no = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
			} else {
				$new_no = '0001';
			}

			return "QT-$year-$new_no";
		}

		// REVISION
		else {

			// get parent quotation
			$parent = $this->db
				->where('quotation_id', $parent_id)
				->get('quotations')
				->row();

			// remove revision part if exists
			$base_qt = preg_replace('/-REV-\d+$/', '', $parent->quotation_no);

			// find last revision
			$this->db->where('parent_quotation_id', $parent_id);
			$this->db->order_by('revision_no', 'DESC');
			$this->db->limit(1);

			$last = $this->db->get('quotations')->row();

			$rev = $last ? $last->revision_no + 1 : 1;

			return $base_qt . "-REV-" . $rev;
		}
	}

	public function get_quotation($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->get('quotations')
			->row();
	}

	public function get_parts_type($quotation_id, $parttype)
	{
		return $this->db
			->select('qp.*, sp.part_name')
			->from('quotation_parts qp')
			->join('spare_parts sp', 'sp.part_id = qp.part_id')
			->where('qp.quotation_id', $quotation_id)
			->where('qp.part_type', $parttype)
			->get()
			->result();
	}

	public function get_parts($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->get('quotation_parts')
			->result();
	}

	public function get_job_descriptions($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->get('quotation_job_descriptions')
			->result();
	}

	public function get_services($quotation_id)
	{
		return $this->db
			->select('qs.*, sm.service_name')
			->from('quotation_services qs')
			->join('services_master sm', 'sm.master_service_id = qs.service_id')
			->where('qs.quotation_id', $quotation_id)
			->get()
			->result();
	}

	public function update_quotation($quotation_id, $data = [])
	{
		if (empty($quotation_id)) {
			return false;
		}


		/* ===============================
			1. UPDATE QUOTATION HEADER
			=============================== */

		$updateData = [];

		// Status
		if (isset($data['status'])) {
			$updateData['status'] = $data['status'];
		}

		// Status
		if (isset($data['srvice_discount'])) {
			$updateData['srvice_discount'] = $data['srvice_discount'];
		}


		// Amounts (force numeric safety)
		if (isset($data['subtotal'])) {
			$updateData['subtotal'] = (float) $data['subtotal'];
		}

		if (isset($data['tax_amount'])) {
			$updateData['tax_amount'] = (float) $data['tax_amount'];
		}

		/*
			|--------------------------------------------------------------------------
			| IMPORTANT:
			| Quotation-level discount ONLY
			| Do NOT use item discount array here
			|--------------------------------------------------------------------------
			*/
		if (isset($data['tdiscount'])) {
			$updateData['discount'] = (float) $data['tdiscount'];
		}

		if (isset($data['grand_total'])) {
			$updateData['grand_total'] = (float) $data['grand_total'];
		}

		// Remarks
		if (isset($data['remarks'])) {
			$updateData['remarks'] = $data['remarks'];
		}

		// Dates & extra fields
		if (isset($data['est_delivery_date'])) {
			$updateData['est_delivery_date'] = $data['est_delivery_date'];
		}

		if (isset($data['est_completion_time'])) {
			$updateData['est_completion_time'] = $data['est_completion_time'];
		}

		if (isset($data['customer_estimated_price'])) {
			$updateData['customer_estimated_price'] = (float) $data['customer_estimated_price'];
		}

		// Final update
		if (!empty($updateData)) {
			$this->db->where('quotation_id', $quotation_id)
				->update('quotations', $updateData);
		}


		/* ===============================
       2. UPDATE PARTS (ONLY IF SENT)
       =============================== */

		if (isset($data['part_id']) && is_array($data['part_id'])) {

			// Remove old parts
			$this->db->where('quotation_id', $quotation_id)
				->delete('quotation_parts');

			foreach ($data['part_id'] as $i => $pid) {

				if (!$pid) continue;

				$this->db->insert('quotation_parts', [
					'quotation_id'  => $quotation_id,
					'part_id'       => $pid,
					'qty'           => $data['part_qty'][$i]        ?? 1,
					'unit_price'    => $data['unit_price'][$i]      ?? 0,
					'selling_price' => $data['selling_price'][$i]   ?? 0,
					'total_price'   => $data['total_price'][$i]     ?? 0,
					'discount'      => $data['discount'][$i]        ?? 0,
					'dis_amount'    => $data['discountamt'][$i]     ?? 0,
					'part_type'     => $data['part_type'][$i]       ?? null,
					'selected'      => isset($data['customer_selected']) && in_array($pid, $data['customer_selected']) ? 1 : 0,
					'partremarks'     => $data['partremarks'][$i]       ?? null,

				]);
			}
		}

		/* ===============================
       3. UPDATE SERVICES (OPTIONAL)
       =============================== */

		if (isset($data['service_id']) && is_array($data['service_id'])) {

			$this->db->where('quotation_id', $quotation_id)
				->delete('quotation_services');

			// ✅ STEP 1 — Calculate subtotal
			$subtotal = 0;

			foreach ($data['total_cost'] as $t) {
				$subtotal += (float)$t;
			}

			if ($subtotal <= 0) {
				$subtotal = 1; // prevent division error
			}

			// ✅ Total service discount from quotation header
			$total_discount = isset($data['srvice_discount'])
				? (float)$data['srvice_discount']
				: 0;

			$distributed_discount = 0;
			$last_index = array_key_last($data['service_id']);

			foreach ($data['service_id'] as $i => $sid) {

				if (!$sid) continue;

				$service_total = (float)($data['total_cost'][$i] ?? 0);

				// ✅ Proportional discount
				if ($i == $last_index) {

					// Fix rounding mismatch
					$service_discount = round($total_discount - $distributed_discount, 2);
				} else {

					$service_discount = round(
						($service_total / $subtotal) * $total_discount,
						2
					);

					$distributed_discount += $service_discount;
				}

				// ✅ Discount %
				$discount_percentage = ($service_total > 0)
					? round(($service_discount / $service_total) * 100, 2)
					: 0;

				// ✅ Taxable
				$taxable_amount = round($service_total - $service_discount, 2);

				// ✅ Insert
				$this->db->insert('quotation_services', [
					'quotation_id'        => $quotation_id,
					'service_id'          => $sid,
					'estimated_time'      => $data['service_time'][$i] ?? 1,
					'estimated_cost'      => $data['service_cost'][$i] ?? 0,
					'total_cost'          => $service_total,

					'discount_amount'     => $service_discount,
					'discount_percentage' => $discount_percentage,
					'taxable_amount'      => $taxable_amount
				]);
			}
		}

			/* ===============================
       4. UPDATE sublet SERVICES (OPTIONAL)
       =============================== */

		if (isset($data['job_description']) && is_array($data['job_description'])) {

			$this->db->where('quotation_id', $quotation_id)
				->delete('quotation_job_descriptions');

			// ✅ STEP 1 — Calculate subtotal
			$jsubtotal = 0;

			foreach ($data['job_amount'] as $t) {
				$jsubtotal += (float)$t;
			}

			if ($jsubtotal <= 0) {
				$jsubtotal = 1; // prevent division error
			}

			// ✅ Total service discount from quotation header
			$total_jdiscount = isset($data['sublet_discount'])
				? (float)$data['sublet_discount']
				: 0;

			$distributed_jdiscount = 0;
			$last_jindex = array_key_last($data['job_description']);

			foreach ($data['job_description'] as $i => $sid) {

				if (!$sid) continue;

				$service_jtotal = (float)($data['job_amount'][$i] ?? 0);

				// ✅ Proportional discount
				if ($i == $last_jindex) {

					// Fix rounding mismatch
					$service_jdiscount = round($total_jdiscount - $distributed_jdiscount, 2);
				} else {

					$service_jdiscount = round(
						($service_jtotal / $jsubtotal) * $total_discount,
						2
					);

					$distributed_jdiscount += $service_jdiscount;
				}

				// ✅ Discount %
				$discount_jpercentage = ($service_jtotal > 0)
					? round(($service_jdiscount / $service_jtotal) * 100, 2)
					: 0;

				// ✅ Taxable
				$taxable_jamount = round($service_jtotal - $service_jdiscount, 2);

				// ✅ Insert
				$this->db->insert('quotation_job_descriptions', [
					'quotation_id'        => $quotation_id,
					'description'          => $sid,
					'amount'      => $data['job_amount'][$i] ?? 1,
					'created_at' => date('Y-m-d H:i:s'),
					
					'discount_amount'     => $service_jdiscount,
					'discount_percentage' => $discount_jpercentage,
					'taxable_amount'      => $taxable_jamount
				]);
			}
		}


		

		return true;
	}

	public function get_quotation_details($appointment_id)
	{
		$this->db->select("
        q.*,
           ");
		$this->db->from('quotations q');

		$this->db->where('q.appointment_id', $appointment_id);

		return $this->db->get()->row();
	}

	/**
	 * Get all quotations with customer, vehicle & jobcard info
	 */
	public function get_all_quotations_with_jobcard()
	{
		return $this->db
			->select('
                q.*,

                c.name AS customer_name,
                c.phone AS customer_phone,

                v.registration_no,
                v.brand,
                v.model,

                jc.jobcard_id
            ')
			->from('quotations q')
			->join('customers c', 'c.customer_id = q.customer_id')
			->join('vehicles v', 'v.vehicle_id = q.vehicle_id')
			->join('job_cards jc', 'jc.quotation_id = q.quotation_id', 'left')
			->order_by('q.quotation_date', 'DESC')
			->get()
			->result();
	}
	public function get_all_quotations()
	{
		return $this->db
			->select('
                q.*,

                c.name AS customer_name,
                c.phone AS customer_phone,

                v.registration_no,
                v.brand,
                v.model,

               
            ')
			->from('quotations q')
			->join('customers c', 'c.customer_id = q.customer_id')
			->join('vehicles v', 'v.vehicle_id = q.vehicle_id')

			->order_by('q.quotation_id ', 'DESC')
			->get()
			->result();
	}

	/**
	 * Create jobcard from quotation
	 */
	public function create_jobcard_from_quotation($quotation_id)
	{
		// Prevent duplicate jobcard
		$exists = $this->db->get_where('job_cards', [
			'quotation_id' => $quotation_id
		])->row();

		if ($exists) {
			return $exists->jobcard_id;
		}

		// Get quotation
		$q = $this->db->get_where('quotations', [
			'quotation_id' => $quotation_id,
			'status'       => 'Approved'
		])->row();

		if (!$q) {
			return false;
		}

		$this->load->model('Jobcard_model');
		$jobcard_no = $this->Jobcard_model->generate_jobcard_no_from_model();
		// Insert jobcard
		$this->db->insert('job_cards', [
			'quotation_id'    => $q->quotation_id,
			'estimation_id'   => $q->estimation_id,
			'appointment_id' => $q->appointment_id,
			'customer_id'    => $q->customer_id,
			'vehicle_id'     => $q->vehicle_id,
			'jobcard_date'   => date('Y-m-d'),
			'status'         => 'Pending',
			'created_by'     => $this->session->userdata('user_id') ?? null,
			'created_at'     => date('Y-m-d H:i:s'),
			'jobcard_no' => $jobcard_no
		]);

		return $this->db->insert_id();
	}


	public function delete_quotation($quotation_id)
	{
		$this->db->trans_start();

		// 1. Delete job descriptions
		$this->db->where('quotation_id', $quotation_id)
			->delete('quotation_job_descriptions');

		// 2. Delete quotation parts
		$this->db->where('quotation_id', $quotation_id)
			->delete('quotation_parts');

		// 3. Delete quotation services
		$this->db->where('quotation_id', $quotation_id)
			->delete('quotation_services');

		// 4. Delete child revisions (if any)
		$this->db->where('parent_quotation_id', $quotation_id)
			->delete('quotations');

		// 5. Delete MAIN quotation (LAST)
		$this->db->where('quotation_id', $quotation_id)
			->delete('quotations');

		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	// ===================================


public function get_by_quotation_parentid($quotation_id)
{
    $row = $this->db
        ->select('parent_quotation_id')
        ->where('quotation_id', $quotation_id)
        ->get('quotations')
        ->row();

    return $row ? $row->parent_quotation_id : null;
}
}
