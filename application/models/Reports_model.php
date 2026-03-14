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
public function get_revenue_reportold($from_date, $to_date)
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
public function get_revenue_report($from_date, $to_date)
{
    $this->db->select("
        i.invoice_id,
        i.invoice_no,
        i.invoice_date,
        i.subtotal,
        i.tax_amount,
        i.discount_amount,
        i.grand_total,

        IFNULL(SUM(vt.amount),0) AS paid_amount,

        CASE 
            WHEN IFNULL(SUM(vt.amount),0) >= i.grand_total THEN 'Paid'
            WHEN IFNULL(SUM(vt.amount),0) > 0 
                 AND IFNULL(SUM(vt.amount),0) < i.grand_total THEN 'Partially Paid'
            ELSE 'Unpaid'
        END AS payment_status
    ");

    $this->db->from('invoices i');

    $this->db->join(
        'voucher_transaction vt',
        "vt.invoice_code = i.invoice_no 
        AND vt.drcr_type = 'Cr'
        AND vt.trans_type = 'R'
        AND vt.cancel = 0",
        'left'
    );

    $this->db->where('i.invoice_date >=', $from_date);
    $this->db->where('i.invoice_date <=', $to_date);

    $this->db->group_by('i.invoice_id');

    $this->db->order_by('i.invoice_date', 'ASC');

    return $this->db->get()->result();
}
public function get_revenue_report1($from_date, $to_date)
{
    $this->db->select("
        i.invoice_id,
        i.invoice_no,
        i.invoice_date,
        i.subtotal,
        i.tax_amount,
        i.discount_amount,
        i.grand_total,
        i.status,
        IFNULL(SUM(vt.amount),0) AS paid_amount
    ");

    $this->db->from('invoices i');

    $this->db->join(
        'voucher_transaction vt',
        "vt.invoice_code = i.invoice_no 
        AND vt.drcr_type = 'Cr'
        AND vt.trans_type = 'R'
        AND vt.cancel = 0",
        'left'
    );

    $this->db->where('i.invoice_date >=', $from_date);
    $this->db->where('i.invoice_date <=', $to_date);

    $this->db->group_by('i.invoice_id');

    $this->db->order_by('i.invoice_date', 'ASC');

    return $this->db->get()->result();
}
public function get_inventory_usage_report($from, $to)
{
    $this->db->select('
        jp.part_id ,
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

	/////////////////////////////////////purchase reports////////////////////////////
	public function get_rfq_report_records()
	{
		$from = isset($_REQUEST['from_date']) ? date('Y-m-d', strtotime($_REQUEST['from_date'])) : '';
		$to = isset($_REQUEST['to_date']) ? date('Y-m-d', strtotime($_REQUEST['to_date'])) : '';

		// Fail early if no date filters
		if (empty($from) || empty($to)) {
			return [];
		}

		$created_by = isset($_REQUEST['created_by']) ? $_REQUEST['created_by'] : '';
		$supplier_id = isset($_REQUEST['supplier_id']) ? $_REQUEST['supplier_id'] : '';

		$user_condition = '';
		$supplier_condition = '';

		if ($created_by != '') {
			$user_condition = " AND r.created_by = '$created_by'";
		}

		if ($supplier_id != '') {
			$supplier_condition = " AND r.supplier_id = '$supplier_id'";
		}

		$query = $this->db->query("
            SELECT 
                r.rfq_id,
                r.rfq_code,
                r.rfq_date,
                r.rev_version,
                r.supplier_id,
                CONCAT(em.username) AS rfq_created_by,
                supplier_name 
            FROM 
                purchase_rfq r
            JOIN users em ON r.created_by = em.id
            JOIN supplier_master s ON r.supplier_id = s.supplier_id
            WHERE 
                r.rfq_date BETWEEN '$from' AND '$to'
                $user_condition 
                $supplier_condition 
            ORDER BY 
                r.rfq_date DESC
        ");

		return $query->result();
	}
public function get_po_report($from_date, $to_date, $supplier)
{
    $this->db->select('po.po_code, po.po_date, po.grand_total, acc.account_name as supplier_name');
    $this->db->from('purchase_order_master po');
    $this->db->join('general_ledger acc', 'acc.supplier_id = po.supplier_id', 'left');

    if (!empty($from_date)) {
        $this->db->where('po.po_date >=', $from_date);
    }

    if (!empty($to_date)) {
        $this->db->where('po.po_date <=', $to_date);
    }

    if (!empty($supplier)) {
        $this->db->where('po.supplier_id', $supplier);
    }

    return $this->db->get()->result();
}

	function get_po_report_records()
	{
		$from = isset($_REQUEST['from_date']) ? date('Y-m-d', strtotime($_REQUEST['from_date'])) : '';
		$to   = isset($_REQUEST['to_date']) ? date('Y-m-d', strtotime($_REQUEST['to_date'])) : '';

		// Fail early if no date filters
		if (empty($from) || empty($to)) {
			return [];
		}

		$created_by  = isset($_REQUEST['created_by'])  ? $_REQUEST['created_by']  : '';
		$supplier_id = isset($_REQUEST['supplier_id']) ? $_REQUEST['supplier_id'] : '';
		// $brand_id    = isset($_REQUEST['brand_id'])    ? $_REQUEST['brand_id']    : ''; // new brand filter

		// Build query safely with bindings
		$this->db->select('
            r.po_id,
            r.po_code,
            r.po_date,
            em.username as rfq_created_by,
            s.supplier_name,
            r.grand_total,
            r.po_status
        ');
		$this->db->from('purchase_order_master r');
		$this->db->join('users em', 'r.created_by = em.id', 'left');
		$this->db->join('supplier_master s', 'r.supplier_id = s.supplier_id', 'left');

		// If brand filter used, join transaction table
		// if (!empty($brand_id)) {
		// 	$this->db->join('purchase_order_transaction t', 't.po_master_id = r.po_id', 'inner');
		// 	$this->db->where('t.brand', $brand_id);
		// }

		// Apply filters
		$this->db->where('r.po_date >=', $from);
		$this->db->where('r.po_date <=', $to);

		if (!empty($created_by)) {
			$this->db->where('r.created_by', $created_by);
		}

		if (!empty($supplier_id)) {
			$this->db->where('r.supplier_id', $supplier_id);
		}

		$this->db->order_by('r.po_date', 'desc');

		// Avoid duplicate rows if same PO has multiple brands
		if (!empty($brand_id)) {
			$this->db->group_by('r.po_id');
		}

		$query = $this->db->get();
		return $query->result();
	}
	function get_grn_report_records()
	{
		$from = isset($_REQUEST['from_date']) ? date('Y-m-d', strtotime($_REQUEST['from_date'])) : '';
		$to = isset($_REQUEST['to_date']) ? date('Y-m-d', strtotime($_REQUEST['to_date'])) : '';

		// Fail early if no date filters
		if (empty($from) || empty($to)) {
			return [];
		}

		$created_by = isset($_REQUEST['created_by']) ? $_REQUEST['created_by'] : '';
		$supplier_id = isset($_REQUEST['supplier_id']) ? $_REQUEST['supplier_id'] : '';

		$user_condition = '';
		$supplier_condition = '';

		if ($created_by != '') {
			$user_condition = " AND r.created_by = '$created_by'";
		}

		if ($supplier_id != '') {
			$supplier_condition = " AND r.supplier_id = '$supplier_id'";
		}


		$query = $this->db->query("select r.grn_id,r.grn_code,r.grn_date, concat(em.username)as grn_created_by, supplier_name,r.grand_total from purchase_grn_master r, users em, supplier_master s where r.created_by=em.id and r.supplier_id=s.supplier_id and r.grn_date between '$from' and '$to'  $user_condition $supplier_condition order by r.grn_date desc;");
		return $query->result();
	}


}
