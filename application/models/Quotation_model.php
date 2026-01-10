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

		// 2. Prevent duplicate quotation creation
		$exists = $this->db
			->where('estimation_id', $estimation_id)
			->where('revision_no', 1)
			->get('quotations')
			->row();

		if ($exists) {
			return $exists->quotation_id;
		}

		// 3. Generate quotation number
		$quotation_no = $this->generate_quotation_no();

		// 4. Insert quotation (REVISION 1)
		$this->db->insert('quotations', [
			'quotation_no'            => $quotation_no,
			'quotation_date'          => date('Y-m-d'),
			'estimation_id'           => $est->estimation_id,
			'appointment_id'          => $est->appointment_id,
			'inspection_id'           => $est->inspection_id,
			'customer_id'             => $est->customer_id,
			'vehicle_id'              => $est->vehicle_id,
			'subtotal'                => $est->subtotal,
			'tax_amount'              => $est->tax_amount,
			'discount'                => $est->discount,
			'grand_total'             => $est->grand_total,
			'quotation_time'          => $est->estimation_time,
			'est_delivery_date'       => $est->est_delivery_date,
			'est_completion_time'     => $est->est_completion_time,
			'customer_approval'       => $est->customer_approval,
			'customer_estimated_price' => $est->customer_estimated_price,
			'revision_no'             => 1,
			'parent_quotation_id'     => null,
			'status'                  => 'Draft',
			'remarks'                 => $est->remarks,
			'created_at'              => date('Y-m-d H:i:s')
		]);

		$quotation_id = $this->db->insert_id();

		/* ===============================
           COPY PARTS
           =============================== */
		$this->db->query("
            INSERT INTO quotation_parts
            (quotation_id, part_id, qty, unit_price, selling_price, total_price,
             markup_percentage, discount, dis_amount, part_type, brand_id, selected, created_at)
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
                NOW()
            FROM estimation_parts
            WHERE estimation_id = {$estimation_id}
        ");

		/* ===============================
           COPY SERVICES
           =============================== */
		$this->db->query("
            INSERT INTO quotation_services
            (quotation_id, service_id, estimated_time, estimated_cost, total_cost, created_at)
            SELECT
                {$quotation_id},
                service_id,
                estimated_time,
                estimated_cost,
                total_cost,
                NOW()
            FROM estimation_services
            WHERE estimation_id = {$estimation_id}
        ");
		/* ===============================
           COPY job description
           =============================== */
		$this->db->query("
				INSERT INTO quotation_job_descriptions
				(quotation_id, description, employee_id, created_at,amount)
				SELECT
					{$quotation_id},
					description,
					employee_id,
					NOW(),
					amount
				FROM estimation_job_descriptions
				WHERE estimation_id = {$estimation_id}
			");


		return $quotation_id;
	}

	/* =====================================================
       QUOTATION NUMBER GENERATOR
       ===================================================== */
	private function generate_quotation_no()
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

	public function get_quotation($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->get('quotations')
			->row();
	}

	public function get_parts($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->get('quotation_parts')
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

		$headerFields = [
			'status',
			'subtotal',
			'tax_amount',
			'discount',
			'grand_total',
			'remarks',
			'est_delivery_date',
			'est_completion_time',
			'customer_estimated_price'
		];

		$updateData = [];

		foreach ($headerFields as $field) {
			if (isset($data[$field])) {
				$updateData[$field] = $data[$field];
			}
		}

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
					'selected'      => isset($data['customer_selected'])
						&& in_array($pid, $data['customer_selected']) ? 1 : 0
				]);
			}
		}

		/* ===============================
       3. UPDATE SERVICES (OPTIONAL)
       =============================== */

		if (isset($data['service_id']) && is_array($data['service_id'])) {

			$this->db->where('quotation_id', $quotation_id)
				->delete('quotation_services');

			foreach ($data['service_id'] as $i => $sid) {

				if (!$sid) continue;

				$this->db->insert('quotation_services', [
					'quotation_id'  => $quotation_id,
					'service_id'    => $sid,
					'estimated_time' => $data['service_time'][$i] ?? 1,
					'estimated_cost' => $data['service_cost'][$i] ?? 0,
					'total_cost'    => $data['total_cost'][$i]   ?? 0
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
            'created_at'     => date('Y-m-d H:i:s')
        ]);

        return $this->db->insert_id();
    }
}
