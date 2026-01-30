<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_history_model extends CI_Model
{
	/* ================= LIST ================= */
	public function get_all_invoices()
	{
		return $this->db
			->order_by('billing_date', 'DESC')
			->get('billing_invoices')
			->result();
	}

	/* ================= HEADER ================= */
	public function get_invoice($invoice_id)
	{
		return $this->db
			->where('invoice_id', $invoice_id)
			->get('billing_invoices')
			->row();
	}

	/* ================= ITEMS ================= */
	public function get_invoice_items($invoice_id)
	{
		return $this->db
			->where('invoice_id', $invoice_id)
			->get('billing_invoice_items')
			->result();
	}

	public function get_billing_history($filters = [])
	{
		$this->db->select('bi.*')
			->from('billing_invoices bi');

		if (!empty($filters['customer_name'])) {
			$this->db->like('bi.customer_name', $filters['customer_name']);
		}

		if (!empty($filters['customer_phone'])) {
			$this->db->like('bi.customer_phone', $filters['customer_phone']);
		}

		if (!empty($filters['vin_no'])) {
			$this->db->like('bi.vin_no', $filters['vin_no']);
		}

		if (!empty($filters['plate_no'])) {
			$this->db->like('bi.plate_no', $filters['plate_no']);
		}

		$this->db->order_by('bi.billing_date', 'DESC');

		return $this->db->get()->result();
	}


	public function get_billing_historyold($customer_id = null)
	{
		$this->db
			->select('
            i.invoice_id,
            i.invoice_no AS billing_no,
            i.invoice_date AS billing_date,
            i.grand_total AS total_amount,
            c.name AS customer_name,
            c.phone AS customer_phone,
            v.registration_no AS plate_no
        ')
			->from('invoices i')
			->join('customers c', 'c.customer_id = i.customer_id')
			->join('vehicles v', 'v.vehicle_id = i.vehicle_id');

		if (!empty($customer_id)) {
			$this->db->where('i.customer_id', $customer_id);
		}

		return $this->db->order_by('i.invoice_date', 'DESC')->get()->result();
	}

	public function get_all_invoices_new($customer_id = null, $for_excel = false)
	{
		$this->db->select('
            bi.invoice_id,
            bi.billing_no,
            bi.billing_date,
            bi.total_amount,
            c.name AS customer_name,
            c.phone AS customer_phone,
            v.plate_no
        ');
		$this->db->from('billing_invoice bi');
		$this->db->join('customers c', 'c.customer_id = bi.customer_id', 'left');
		$this->db->join('vehicles v', 'v.vehicle_id = bi.vehicle_id', 'left');

		// ✅ FILTER
		if (!empty($customer_id)) {
			$this->db->where('bi.customer_id', $customer_id);
		}

		$this->db->order_by('bi.billing_date', 'DESC');

		if ($for_excel) {
			return $this->db->get()->result_array();
		}

		return $this->db->get()->result();
	}
	public function get_all_billing_invoices($customer_id = null)
	{
		$this->db->from('billing_invoices');

		if (!empty($customer_id)) {
			$this->db->where('customer_id', $customer_id);
		}

		$this->db->order_by('billing_date', 'DESC');

		return $this->db->get()->result();
	}


	// =====================================

	public function get_billing_history_detailed($filters = [])
	{
		$this->db->select('
		bi.customer_name,
		bi.customer_phone,
		bi.plate_no,
		bi.brand,
		bi.model,
		bi.vin_no,
		bi.billing_date,
		bi.billing_no,
		it.description,
		it.unit_price,
		it.discount,
		it.gross_amount,
		it.vat_amount,
		it.total_amount
	');
		$this->db->from('billing_invoices bi');
		$this->db->join('billing_invoice_items it', 'it.invoice_id = bi.invoice_id');

		if (!empty($filters['customer_name'])) {
			$this->db->like('bi.customer_name', $filters['customer_name']);
		}
		if (!empty($filters['customer_phone'])) {
			$this->db->like('bi.customer_phone', $filters['customer_phone']);
		}
		if (!empty($filters['vin_no'])) {
			$this->db->like('bi.vin_no', $filters['vin_no']);
		}
		if (!empty($filters['plate_no'])) {
			$this->db->like('bi.plate_no', $filters['plate_no']);
		}

		$this->db->order_by('bi.billing_date', 'DESC');

		return $this->db->get()->result();
	}

public function get_billing_history_grouped($filters = [])
{
	$this->db->select('
		bi.*,
		it.description,
		it.unit_price,
		it.discount,
		it.gross_amount,
		it.vat_amount,
		it.total_amount AS item_total
	');
	$this->db->from('billing_invoices bi');
	$this->db->join('billing_invoice_items it', 'it.invoice_id = bi.invoice_id');

	if (!empty($filters['customer_name'])) {
		$this->db->like('bi.customer_name', $filters['customer_name']);
	}
	if (!empty($filters['customer_phone'])) {
		$this->db->like('bi.customer_phone', $filters['customer_phone']);
	}
	if (!empty($filters['vin_no'])) {
		$this->db->like('bi.vin_no', $filters['vin_no']);
	}
	if (!empty($filters['plate_no'])) {
		$this->db->like('bi.plate_no', $filters['plate_no']);
	}

	$this->db->order_by('bi.billing_date', 'ASC');

	$result = $this->db->get()->result();

	// 🔥 GROUP BY INVOICE
	$grouped = [];
	foreach ($result as $row) {
		$grouped[$row->invoice_id]['invoice'] = $row;
		$grouped[$row->invoice_id]['items'][] = $row;
	}

	return $grouped;
}


	// ====================================
}
