<?php
class Invoice_model extends CI_Model
{




	public function get_invoice_full($invoice_id)
	{
		$invoice  = $this->get_invoice($invoice_id);

		$services = $this->get_invoice_services($invoice_id);
		$parts    = $this->get_invoice_parts($invoice_id);
		$sublets  = $this->get_invoice_sublets($invoice_id);

		$payments = $this->get_invoice_payments($invoice_id);

		$paid = 0;
		foreach ($payments as $p) {
			$paid += $p->amount;
		}

		return [
			'invoice'  => $invoice,

			'services' => $services,
			'parts'    => $parts,
			'sublets'  => $sublets,

			'payments' => $payments,
			'paid'     => $paid,
			'balance'  => $invoice->grand_total - $paid
		];
	}

	public function get_invoice_fullnew($invoice_id)
	{
		return $this->db
			->select('invoices.*,
                  job_cards.jobcard_no,
                  vehicles.registration_no,
				  customers.customer_id,
                  customers.name,
                  customers.phone')
			->from('invoices')
			->join('job_cards', 'job_cards.jobcard_id=invoices.jobcard_id')
			->join('vehicles', 'vehicles.vehicle_id=job_cards.vehicle_id')
			->join('customers', 'customers.customer_id=job_cards.customer_id')
			->where('invoice_id', $invoice_id)
			->get()->row();
	}
	public function get_invoice_services($invoice_id)
	{
		return $this->db
			->select('
            item_id,
            item_name,
            quantity,
            unit_price,
            total_price
        ')
			->from('invoice_items')
			->where('invoice_id', $invoice_id)
			->where('item_type', 'Service')
			->get()
			->result();
	}
	public function get_invoice_parts($invoice_id)
	{
		return $this->db
			->select('
            ii.item_id,
            ii.item_name,
            ii.quantity,
            ii.unit_price,
            ii.total_price,
            ii.disamount,

            sp.part_code,
            sp.part_name,
            sp.part_type,
            sp.warrenty
        ')
			->from('invoice_items ii')

			->join(
				'spare_parts sp',
				'sp.part_id = ii.source_jobcard_item_id',
				'left'
			)

			->where('ii.invoice_id', $invoice_id)
			->where('ii.item_type', 'Part')

			->get()
			->result();
	}
	public function get_invoice_sublets($invoice_id)
	{
		return $this->db
			->select('
            item_id,
            item_name,
            quantity,
            unit_price,
            total_price
        ')
			->from('invoice_items')
			->where('invoice_id', $invoice_id)
			->where('item_type', 'Sublet')
			->get()
			->result();
	}

	public function get_invoice_items($invoice_id)
	{
		return $this->db
			->where('invoice_id', $invoice_id)
			->get('invoice_items')
			->result();
	}
	// public function get_invoice_payments($invoice_id)
	// {
	// 	return $this->db
	// 		->where('invoice_id', $invoice_id)
	// 		->order_by('payment_date', 'ASC')
	// 		->get('invoice_payments')
	// 		->result();
	// }
	public function get_invoice_payments($invoice_id)
	{
		return $this->db
			->select('voucher_id, voucher_code, voucher_date, amount, payment_type, narration, customer_id')
			->from('voucher_transaction')
			->where('trans_id', $invoice_id)
			->where('voucher_type', 'R')
			->where('drcr_type', 'Cr')
			->where('cancel', 0)
			->order_by('voucher_date', 'ASC')
			->get()
			->result();
	}


	public function get_invoiceold($invoice_id)
	{
		$this->db->select('
        i.*,
        q.quotation_no,
        q.quotation_date,

        c.name AS customer_name,
        c.phone,
        c.trn,
        c.address,
        c.emirates,

        v.registration_no,
        v.brand,
        v.model,
        v.chassis_no,v.year
    ');

		$this->db->from('invoices i');

		// JOIN quotation
		$this->db->join('quotations q', 'q.quotation_id = i.quotation_id', 'left');

		// existing joins
		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id', 'left');
		$this->db->join('customers c', 'c.customer_id = j.customer_id', 'left');
		$this->db->join('vehicles v', 'v.vehicle_id = j.vehicle_id', 'left');

		$this->db->where('i.invoice_id', $invoice_id);

		return $this->db->get()->row();
	}

	public function get_invoice($invoice_id)
	{
		$this->db->select('
        i.*,

        q.quotation_no,
        q.quotation_date,

        j.jobcard_no,
        j.km_in,
        j.jobcard_date,

        c.name AS customer_name,
        c.phone,
        c.trn,
        c.address,
        c.emirates,

        v.registration_no,
        v.brand,
        v.model,
        v.chassis_no,
        v.year ');

		$this->db->from('invoices i');

		// JOIN quotation
		$this->db->join('quotations q', 'q.quotation_id = i.quotation_id', 'left');

		// JOIN jobcard
		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id', 'left');

		// JOIN customer & vehicle via jobcard
		$this->db->join('customers c', 'c.customer_id = j.customer_id', 'left');
		$this->db->join('vehicles v', 'v.vehicle_id = j.vehicle_id', 'left');

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
					'source_jobcard_item_id' => $deid[$i],
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
		$this->db->select("
        i.invoice_id,
        i.invoice_no,
        i.invoice_date,
        i.grand_total,
        i.status,
        c.name AS customer_name,
        v.registration_no,
        IFNULL(SUM(vt.amount),0) AS paid_amount ");

		$this->db->from('invoices i');

		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id', 'left');
		$this->db->join('customers c', 'c.customer_id = j.customer_id', 'left');
		$this->db->join('vehicles v', 'v.vehicle_id = j.vehicle_id', 'left');

		$this->db->join(
			'voucher_transaction vt',
			"vt.invoice_code = i.invoice_no 
        AND vt.drcr_type = 'Cr'
        AND vt.trans_type = 'R'",
			'left'
		);

		$this->db->group_by('i.invoice_id');
		$this->db->order_by('i.invoice_id', 'DESC');

		return $this->db->get()->result();
	}

	public function get_all_invoices_with_paymentold()
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
	function get_debt_invoice_list($customer_id, $account_id)
	{
		$query = $this->db->query("
        SELECT 
            i.invoice_id,
            i.invoice_no,
            i.invoice_date,
			j.customer_id,
            i.grand_total,
		    IFNULL(SUM(v.amount),0) AS paid_amt
        FROM invoices i

        JOIN job_cards j 
            ON j.jobcard_id = i.jobcard_id
            AND j.customer_id = $customer_id

        LEFT JOIN voucher_transaction v 
            ON v.trans_id = i.invoice_id
            AND v.cancel = 0
            AND v.voucher_type = 'R'
            AND v.drcr_type = 'Cr'
            AND v.account_id = $account_id

        WHERE i.invoice_type = 'TI'

        GROUP BY i.invoice_id

        ORDER BY i.invoice_date DESC, i.invoice_no DESC
    ");

		return $query->result();
	}

	function get_debt_invoice_list11($id, $account_id)
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
	// ===============================vat report ===============
	public function get_tax_summary($from_date = null, $to_date = null)
	{
		$this->db->select('
        SUM(subtotal - discount_amount) AS taxable,
        SUM(discount_amount) AS discount,
        SUM(tax_amount) AS vat');

		$this->db->from('invoices');
		//$this->db->where_in('inv_type', ['TI', 'DI']);
		// $this->db->where('cancelled', 0);

		if (!empty($from_date) && !empty($to_date)) {
			$this->db->where('invoice_date >=', $from_date);
			$this->db->where('invoice_date <=', $to_date);
		}

		$query = $this->db->get();
		return $query->row(); // single summary row
	}

	public function get_tax_detailed($from_date = null, $to_date = null)
	{
		// $this->db->select('
		// i.invoice_id,
		// i.invoice_no,
		// i.invoice_date,
		// i.subtotal AS taxable,
		// i.discount_amount AS disamt,
		// i.tax_amount AS vat,
		// c.customer_id,
		// c.name AS customer_name,
		// c.emirates AS emirate');

		$this->db->select('
        i.invoice_id,
        i.invoice_no,
        i.invoice_date,
        (i.subtotal - i.discount_amount) AS taxable,
        i.discount_amount AS disamt,
        i.tax_amount AS vat,
        c.customer_id,
        c.name AS customer_name,
        c.emirates AS emirate');

		$this->db->from('invoices i');

		// ✅ Join Jobcard first
		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id', 'left');

		// ✅ Then Join Customer
		$this->db->join('customers c', 'c.customer_id = j.customer_id', 'left');

		if (!empty($from_date) && !empty($to_date)) {
			$this->db->where('i.invoice_date >=', $from_date);
			$this->db->where('i.invoice_date <=', $to_date);
		}

		$this->db->order_by('c.emirates', 'ASC');
		$this->db->order_by('c.name', 'ASC');
		$this->db->order_by('i.invoice_date', 'ASC');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_tax_summary_emirate($from_date = null, $to_date = null)
	{
		$this->db->select('
		c.emirates,
		SUM(i.subtotal - i.discount_amount) AS taxable,
		SUM(i.discount_amount) AS discount,
		SUM(i.tax_amount) AS vat');

		$this->db->from('invoices i');

		// join jobcard
		$this->db->join('job_cards j', 'j.jobcard_id = i.jobcard_id', 'left');

		// join customer
		$this->db->join('customers c', 'c.customer_id = j.customer_id', 'left');

		// optional filters
		// $this->db->where_in('i.invoice_type', ['TI','DI']);
		// $this->db->where('i.cancelled', 0);

		if (!empty($from_date) && !empty($to_date)) {
			$this->db->where('i.invoice_date >=', $from_date);
			$this->db->where('i.invoice_date <=', $to_date);
		}

		$this->db->group_by('c.emirates');

		$this->db->order_by('c.emirates', 'ASC');

		$query = $this->db->get();
		return $query->result();
	}

	// ======================= edit invoicev================

	public function update_invoice($invoice_id, $data)
	{

		// log_message('error', print_r($_POST, true));
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('invoices', $data);

		// $type = $data['invoice_type'];
		// $invoice_no   = $data['invoice_no'];
		$type = $this->input->post('invoice_type');
		$invoice_no = $this->input->post('invoice_no');
		$customer_id  = $this->input->post('customer_id') ?? null;

		$this->db->where('trans_id', $invoice_id);
		$this->db->delete('voucher_transaction');

		if ($type == 'TI') {

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
						'trans_id' => $invoice_id,
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
						'trans_id' => $invoice_id,
						'trans_type' => 'S',
						'recordCreatedBy' => $this->session->userdata('user_id'),
						'invoice_code' => $AccountCode,
					);
					$this->db->insert('voucher_transaction', $data);
					$vid = $this->db->insert_id();
				}
			}
		}
	}

	public function delete_invoice_items($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('invoice_items');
	}
	public function insert_invoice_item($invoice_id, $item)
	{
		$this->db->insert('invoice_items', [
			'invoice_id' => $invoice_id,
			'item_type' => $item['type'],
			'item_name' => $item['name'],
			'quantity' => $item['qty'],
			'unit_price' => $item['price'],
			'total_price' => $item['total'],
			'disamount' => $item['discount']
		]);
	}

	public function get_invoice_header($invoice_id)
	{
		return $this->db
			->select('invoices.*,
                  jobcards.jobcard_no,
                  jobcards.quotation_id,
                  vehicles.registration_no,
                  customer_master.customer_name,
                  customer_master.phone')
			->from('invoices')
			->join('jobcards', 'jobcards.jobcard_id=invoices.jobcard_id')
			->join('vehicles', 'vehicles.vehicle_id=jobcards.vehicle_id')
			->join('customer_master', 'customer_master.customer_id=jobcards.customer_id')
			->where('invoice_id', $invoice_id)
			->get()->row();
	}

	public function get_invoice_desc($invoice_id)
	{
		return $this->db
			->where('invoice_id', $invoice_id)
			->where('item_type', 'Sublet')
			->get('invoice_items')
			->result();
	}


	// public function get_invoice_items($invoice_id)
	// {
	//     return $this->db
	//         ->where('invoice_id',$invoice_id)
	//         ->get('invoice_items')
	//         ->result();
	// }
	public function update_full_invoice($invoice_id, $header, $services, $parts, $descs, $accounts)
	{
		$this->db->trans_start();

		// 1️⃣ Update Invoice Header
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('invoices', $header);

		// 2️⃣ Delete Old Items
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('invoice_items');

		// 3️⃣ Insert Services
		if ($services) {
			foreach ($services as $k => $id) {
				$this->db->insert('invoice_items', [
					'invoice_id' => $invoice_id,
					'item_type' => 'Service',
					'source_jobcard_item_id' => $id
				]);
			}
		}

		// 4️⃣ Insert Parts
		if ($parts) {
			foreach ($parts as $k => $id) {
				$this->db->insert('invoice_items', [
					'invoice_id' => $invoice_id,
					'item_type' => 'Part',
					'source_jobcard_item_id' => $id
				]);
			}
		}

		// 5️⃣ Insert Sublet
		if ($descs) {
			foreach ($descs as $k => $id) {
				$this->db->insert('invoice_items', [
					'invoice_id' => $invoice_id,
					'item_type' => 'Sublet',
					'source_jobcard_item_id' => $id
				]);
			}
		}

		// 6️⃣ Reverse OLD GL Entry
		$this->db->where('ref_table', 'invoice');
		$this->db->where('ref_id', $invoice_id);
		$this->db->delete('general_ledger');

		// 7️⃣ Post NEW GL
		foreach ($accounts['debit_acc'] as $i => $acc) {
			if (!$acc) continue;

			$this->db->insert('general_ledger', [
				'account_id' => $acc,
				'debit' => $accounts['debit_amt'][$i],
				'credit' => 0,
				'ref_table' => 'invoice',
				'ref_id' => $invoice_id
			]);
		}

		foreach ($accounts['credit_acc'] as $i => $acc) {
			if (!$acc) continue;

			$this->db->insert('general_ledger', [
				'account_id' => $acc,
				'debit' => 0,
				'credit' => $accounts['credit_amt'][$i],
				'ref_table' => 'invoice',
				'ref_id' => $invoice_id
			]);
		}

		$this->db->trans_complete();
	}
}
