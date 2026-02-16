<?php
class Invoice_model extends CI_Model
{



	public function get_invoice_full($invoice_id)
	{
		$invoice  = $this->get_invoice($invoice_id);
		$items    = $this->get_invoice_items($invoice_id);
		$payments = $this->get_invoice_payments($invoice_id);

		$paid = 0;
		foreach ($payments as $p) {
			$paid += $p->amount;
		}

		return [
			'invoice' => $invoice,
			'items'   => $items,
			'payments' => $payments,
			'paid'    => $paid,
			'balance' => $invoice->grand_total - $paid
		];
	}

	public function get_invoice_items($invoice_id)
	{
		return $this->db
			->where('invoice_id', $invoice_id)
			->get('invoice_items')
			->result();
	}
	public function get_invoice_payments($invoice_id)
	{
		return $this->db
			->where('invoice_id', $invoice_id)
			->order_by('payment_date', 'ASC')
			->get('invoice_payments')
			->result();
	}


	public function get_invoice($invoice_id)
	{
		$this->db->select('
        i.*,
        c.name AS customer_name,
        c.phone,
		c.trn,c.address,c.emirates,
        v.registration_no,
        v.brand,
        v.model,v.chassis_no');
		$this->db->from('invoices i');
		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id');
		$this->db->join('customers c', 'c.customer_id = j.customer_id');
		$this->db->join('vehicles v', 'v.vehicle_id = j.vehicle_id');
		$this->db->where('i.invoice_id', $invoice_id);

		return $this->db->get()->row();
	}

	public function get_all_invoices()
	{
		$this->db->select('
        i.invoice_id,
        i.invoice_no,
        i.invoice_date,
        i.grand_total,
        i.status,
        c.name,
        v.registration_no');
		$this->db->from('invoices i');
		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id');
		$this->db->join('customers c', 'c.customer_id = j.customer_id');
		$this->db->join('vehicles v', 'v.vehicle_id = j.vehicle_id');
		$this->db->where('j.status', 'Completed');

		$this->db->order_by('i.invoice_id', 'DESC');

		return $this->db->get()->result();
	}
	public function create_invoice($data)
	{


		$type = $data['invoice_type'];
		$invoice_no   = $data['invoice_no'];
		// Pull out extra fields
		$customer_id  = $data['customer_id'] ?? null;
		// ❗ Remove fields NOT in invoices table
		unset($data['customer_id']);


		$this->db->insert('invoices', $data);
		$insertid = $this->db->insert_id();



		if ($type == 'TI') {
			/// unblocking stock//////////////////
			$qqid = $this->input->post('qid');
			// add code for Voucher entry here ///

			$AccountCode = $invoice_no;

			$vdate = $this->input->post('invdate');
			$vtime = date('h:i:s');

			/// debit entry 
			for ($i = 0; $i < count($_POST['inv_debtor']); $i++) {
				$debtor = $_POST['inv_debtor'][$i];
				$dr_amount = $_POST['inv_dr_amount'][$i];
				if ($dr_amount > 0) {
					$data = array(
						'voucher_code' => $AccountCode,
						'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
						'voucher_type' => 'S',  /// Sales invoice  entry
						'customer_id' => $customer_id,
						'account_id' => $debtor,
						'amount' => $dr_amount,
						'drcr_type' => 'Dr',
						//'narration' => $this->input->post('narration'),
						'trans_id' => $insertid,
						'trans_type' => 'S',
						'recordCreatedBy' => $this->session->userdata('user_id'),
						'invoice_code' => $AccountCode,
					);
					$this->db->insert('voucher_transaction', $data);
					$vid = $this->db->insert_id();
				}
			}

			// credit entry
			for ($i = 0; $i < count($_POST['inv_creditor']); $i++) {
				$creditor = $_POST['inv_creditor'][$i];
				$cr_amount = $_POST['inv_cr_amount'][$i];
				if ($cr_amount > 0) {
					$data = array(
						'voucher_code' => $AccountCode,
						'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
						'voucher_type' => 'S',  /// Sales invoice  entry
						'customer_id' => $customer_id,
						'account_id' => $creditor,
						'amount' => $cr_amount,
						'drcr_type' => 'Cr',
						//'narration' => $this->input->post('narration'),
						'trans_id' => $insertid,
						'trans_type' => 'S',
						'recordCreatedBy' => $this->session->userdata('user_id'),
						'invoice_code' => $AccountCode,
					);
					$this->db->insert('voucher_transaction', $data);
					$vid = $this->db->insert_id();
				}
			}

			// if ($vid) {
			// 	$user_se_id = $this->session->userdata('session_id');
			// 	$uid = $this->session->userdata('user_id');
			// 	$page_name = explode('index.php/', $_SERVER['REQUEST_URI']);
			// 	$ci = get_instance();
			// 	$ci->load->helper('log');
			// 	$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $vid);
			// 	return $insertid;
			// }
		}



		return $insertid;
	}

	public function insert_invoice_items123($invoice_id, $jobcard_id)
	{
		// -------- SERVICES --------
		$services = $this->db
			->select('sm.service_name, js.amount')
			->from('jobcard_services js')
			->join('services_master sm', 'sm.master_service_id = js.service_id')
			->where('js.jobcard_id', $jobcard_id)
			->get()->result();

		foreach ($services as $s) {
			$this->db->insert('invoice_items', [
				'invoice_id'  => $invoice_id,
				'item_type'   => 'Service',
				'item_name'   => $s->service_name,
				'quantity'    => 1,
				'unit_price'  => $s->amount,
				'total_price' => $s->amount,
			]);
		}

		// -------- PARTS --------
		$parts = $this->db
			->select('sp.part_name, jp.qty, jp.amount')
			->from('jobcard_parts jp')
			->join('spare_parts sp', 'sp.part_id = jp.part_id')
			->where('jp.jobcard_id', $jobcard_id)
			->get()->result();

		foreach ($parts as $p) {
			$this->db->insert('invoice_items', [
				'invoice_id'  => $invoice_id,
				'item_type'   => 'Part',
				'item_name'   => $p->part_name,
				'quantity'    => $p->qty,
				'unit_price'  => $p->amount,
				'total_price' => $p->qty * $p->amount,
			]);
		}
	}

	public function insert_invoice_items_from_post($invoice_id)
	{

		/* ================= SERVICES ================= */

		$services = $this->input->post('service_name');

		if (!empty($services)) {
			$sid = $this->input->post('service_ids');
			// log_message('error', print_r($sid, true));
			$names      = $this->input->post('service_name');
			$prices     = $this->input->post('service_price');
			$discounts  = $this->input->post('service_discount');

			for ($i = 0; $i < count($names); $i++) {

				$this->db->insert('invoice_items', [

					'invoice_id'  => $invoice_id,
					'source_jobcard_item_id' => $sid[$i],
					'item_type'   => 'Service',
					'item_name'   => $names[$i],
					'quantity'    => 1,
					'unit_price'  => $prices[$i],
					'total_price' => $prices[$i],
					'disamount'   => $discounts[$i] ?? 0
				]);
			}
		}


		/* ================= PARTS ================= */

		$parts = $this->input->post('part_name');

		if (!empty($parts)) {
			$paid = $this->input->post('part_id');
			$names   = $this->input->post('part_name');
			$qty     = $this->input->post('part_qty');
			$price   = $this->input->post('part_price');
			$total   = $this->input->post('part_total');
			$disc    = $this->input->post('part_discount');

			for ($i = 0; $i < count($names); $i++) {

				$this->db->insert('invoice_items', [

					'invoice_id'  => $invoice_id,
					'source_jobcard_item_id' => $paid[$i],
					'item_type'   => 'Part',
					'item_name'   => $names[$i],
					'quantity'    => $qty[$i],
					'unit_price'  => $price[$i],
					'total_price' => $total[$i],
					'disamount'   => $disc[$i] ?? 0
				]);
			}
		}


		/* ================= SUBLET ================= */

		$descs = $this->input->post('desc_name');

		if (!empty($descs)) {
			$deid = $this->input->post('desc_id');
			$names = $this->input->post('desc_name');
			$amt   = $this->input->post('desc_amount');

			for ($i = 0; $i < count($names); $i++) {

				$this->db->insert('invoice_items', [

					'invoice_id'  => $invoice_id,
					'item_type'   => 'Sublet',
					'source_jobcard_item_id' =>$deid[$i],
					'item_name'   => $names[$i],
					'quantity'    => 1,
					'unit_price'  => $amt[$i],
					'total_price' => $amt[$i]
				]);
			}
		}

		return true;
	}


	public function insert_invoice_items($invoice_id, $jobcard_id)
	{
		/* =====================================================
       1. Get quotation_id from jobcard
       ===================================================== */
		$jobcard = $this->db
			->select('quotation_id')
			->from('job_cards')
			->where('jobcard_id', $jobcard_id)
			->get()
			->row();

		if (!$jobcard || !$jobcard->quotation_id) {
			return false;
		}

		$quotation_id = $jobcard->quotation_id;

		/* =====================================================
       2. SERVICES (from quotation_services)
       ===================================================== */
		$services = $this->db
			->select('
            sm.service_name,
            qs.estimated_cost,
            qs.total_cost
        ')
			->from('quotation_services qs')
			->join(
				'services_master sm',
				'sm.master_service_id = qs.service_id',
				'left'
			)
			->where('qs.quotation_id', $quotation_id)
			->get()
			->result();

		foreach ($services as $s) {
			$this->db->insert('invoice_items', [
				'invoice_id'  => $invoice_id,
				'item_type'   => 'Service',
				'item_name'   => $s->service_name,
				'quantity'    => 1,
				'unit_price'  => $s->estimated_cost,
				'total_price' => $s->total_cost
			]);
		}

		/* =====================================================
       3. PARTS (from quotation_parts)
       ===================================================== */
		$parts = $this->db
			->select('
            qp.qty,
            qp.selling_price,
            qp.total_price,
			qp.dis_amount,
            sp.part_name ')
			->from('quotation_parts qp')
			->join(
				'spare_parts sp',
				'sp.part_id = qp.part_id',
				'left'
			)
			->where('qp.quotation_id', $quotation_id)

			->get()
			->result();

		foreach ($parts as $p) {
			$this->db->insert('invoice_items', [
				'invoice_id'  => $invoice_id,
				'item_type'   => 'Part',
				'item_name'   => $p->part_name,
				'quantity'    => $p->qty,
				'unit_price'  => $p->selling_price,
				'total_price' => $p->total_price,
				'disamount' => $p->dis_amount,
			]);
		}

		/* =====================================================
       3. sublet services (from quotation_job_descriptions)
       ===================================================== */
		$parts = $this->db
			->select('
            qjd.description,
            qjd.amount                      
        ')
			->from('quotation_job_descriptions qjd')

			->where('qjd.quotation_id', $quotation_id)

			->get()
			->result();

		foreach ($parts as $p) {
			$this->db->insert('invoice_items', [
				'invoice_id'  => $invoice_id,
				'item_type'   => 'Sublet',
				'item_name'   => $p->description,
				'total_price' => $p->amount,

			]);
		}


		return true;
	}


	public function get_all_invoices_with_payment()
	{
		$this->db->select('
        i.invoice_id,
        i.invoice_no,
        i.invoice_date,
        i.grand_total,
        i.status,
        c.name AS customer_name,
        v.registration_no,
        IFNULL(SUM(p.amount),0) AS paid_amount');
		$this->db->from('invoices i');
		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id');
		$this->db->join('customers c', 'c.customer_id = j.customer_id');
		$this->db->join('vehicles v', 'v.vehicle_id = j.vehicle_id');
		$this->db->join('invoice_payments p', 'p.invoice_id = i.invoice_id', 'left');
		$this->db->group_by('i.invoice_id');
		$this->db->order_by('i.invoice_id', 'DESC');

		return $this->db->get()->result();
	}

	public function insert_payment($data)
	{
		return $this->db->insert('invoice_payments', $data);
	}

	public function update_invoice_payment_status($invoice_id)
	{
		// Total paid amount
		$paid = $this->db->select_sum('amount')
			->where('invoice_id', $invoice_id)
			->get('invoice_payments')
			->row()->amount;

		// Invoice total
		$invoice = $this->db->get_where('invoices', [
			'invoice_id' => $invoice_id
		])->row();

		if (!$invoice) return;

		// Decide status
		if ($paid >= $invoice->grand_total) {
			$status = 'Paid';
		} elseif ($paid > 0) {
			$status = 'Partially Paid';
		} else {
			$status = 'Unpaid';
		}

		// Update
		$this->db->where('invoice_id', $invoice_id)
			->update('invoices', ['status' => $status]);
	}


	// ===============================================================

	public function update_invoice_no($invoice_id, $invoice_no)
	{
		return $this->db
			->where('invoice_id', $invoice_id)
			->update('invoices', ['invoice_no' => $invoice_no]);
	}
	public function has_proforma($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->where('invoice_type', 'Proforma')
			->count_all_results('invoices') > 0;
	}


	function get_debt_invoice_list($id, $account_id)
	{
		// $query = $this->db->query("select one.*, two.paid_amt,two.customer_id from (select * from invoices order by invoice_date desc , invoice_no desc)as one left join(select trans_id, sum(amount)as paid_amt, customer_id from voucher_transaction where cancel=0 and voucher_type='R' and drcr_type='Cr' and account_id=$account_id group by trans_id )as two on(one.invoice_id=two.trans_id) group by invoice_no");
		$query = $this->db->query("select one.*,
		two.paid_amt,
		two.customer_id
			from
			(
				select *
				from invoices where invoice_type='TI'
				order by invoice_date desc, invoice_no desc
			) as one
			left join
			(
				select trans_id,
					customer_id,
					sum(amount) as paid_amt
				from voucher_transaction
				where cancel = 0
				and voucher_type = 'R'
				and drcr_type = 'Cr'
				and account_id = 591
				group by trans_id, customer_id
			) as two
			on one.invoice_id = two.trans_id
			group by one.invoice_no;
			");


		return $query->result();
	}
}
