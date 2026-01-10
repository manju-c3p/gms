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
        v.registration_no,
        v.brand,
        v.model
    ');
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
        v.registration_no
    ');
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
		$this->db->insert('invoices', $data);
		return $this->db->insert_id();
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
				'total_price' => $s->amount
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
				'total_price' => $p->qty * $p->amount
			]);
		}
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
            sp.part_name
        ')
			->from('quotation_parts qp')
			->join(
				'spare_parts sp',
				'sp.part_id = qp.part_id',
				'left'
			)
			->where('qp.quotation_id', $quotation_id)
			->where('qp.selected', 1)
			->get()
			->result();

		foreach ($parts as $p) {
			$this->db->insert('invoice_items', [
				'invoice_id'  => $invoice_id,
				'item_type'   => 'Part',
				'item_name'   => $p->part_name,
				'quantity'    => $p->qty,
				'unit_price'  => $p->selling_price,
				'total_price' => $p->total_price
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
        IFNULL(SUM(p.amount),0) AS paid_amount
    ');
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
}
