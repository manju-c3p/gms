<?php
class Reports_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
public function get_daily_job_report($date)
{
    $this->db->select('
        jc.jobcard_id,
       
        jc.status,
        jc.jobcard_date,
        c.name AS customer_name,
        v.registration_no,
        v.brand,
        v.model
    ');
    $this->db->from('job_cards jc');
    $this->db->join('customers c', 'c.customer_id = jc.customer_id');
    $this->db->join('vehicles v', 'v.vehicle_id = jc.vehicle_id');
    $this->db->where('DATE(jc.jobcard_date)', $date);
    $this->db->order_by('jc.jobcard_id', 'DESC');

    return $this->db->get()->result();
}
public function get_revenue_report($from_date, $to_date)
{
    $this->db->select('invoice_id,
        invoice_no,
        invoice_date,
        subtotal,
        tax_amount,
        discount_amount,
        grand_total,
        status
    ');
    $this->db->from('invoices');
    $this->db->where('invoice_date >=', $from_date);
    $this->db->where('invoice_date <=', $to_date);
    $this->db->order_by('invoice_date', 'ASC');

    return $this->db->get()->result();
}
public function get_inventory_usage_report($from, $to)
{
    $this->db->select('
        jp.part_item_id ,
        jp.qty,
        jc.jobcard_date,
        sp.part_name,
        sp.part_code,
        jc.jobcard_id,
        c.name AS customer_name,
        v.registration_no
    ');
    $this->db->from('jobcard_parts jp');
    $this->db->join('spare_parts sp', 'sp.part_id = jp.part_id');
    $this->db->join('job_cards jc', 'jc.jobcard_id = jp.jobcard_id');
    $this->db->join('customers c', 'c.customer_id = jc.customer_id');
    $this->db->join('vehicles v', 'v.vehicle_id = jc.vehicle_id');
    $this->db->where('DATE(jc.jobcard_date) >=', $from);
    $this->db->where('DATE(jc.jobcard_date) <=', $to);
    $this->db->order_by('jc.jobcard_date', 'DESC');

    return $this->db->get()->result();
}
public function get_customer_visit_history($from, $to, $customer_id = null)
{
    $this->db->select('
        jc.jobcard_id,
        
        jc.status,
        jc.jobcard_date,
        c.customer_id,
        c.name AS customer_name,
        c.phone,
        v.registration_no,
        v.brand,
        v.model
    ');
    $this->db->from('job_cards jc');
    $this->db->join('customers c', 'c.customer_id = jc.customer_id');
    $this->db->join('vehicles v', 'v.vehicle_id = jc.vehicle_id');
    $this->db->where('DATE(jc.jobcard_date) >=', $from);
    $this->db->where('DATE(jc.jobcard_date) <=', $to);

    if (!empty($customer_id)) {
        $this->db->where('c.customer_id', $customer_id);
    }

    $this->db->order_by('jc.jobcard_date', 'DESC');

    return $this->db->get()->result();
}


}
