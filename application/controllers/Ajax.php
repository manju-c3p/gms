<?php
class Ajax extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->is_logged_in();
	}

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if (!isset($is_logged_in) || $is_logged_in != true) {
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';
			die();
		}
	}
	function cancel_record()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->cancel_record();
		if ($res)
			echo 1;
		else
			echo 0;
	}
	function delete_record()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->delete_record();
		if ($res)
			echo 1;
		else
			echo 0;
	}
	function delete_sales_quotation()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->delete_sales_quotation();
		if ($res)
			echo 1;
		else
			echo 0;
	}
	function delete_cost_sheet()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->delete_cost_sheet();
		if ($res)
			echo 1;
		else
			echo 0;
	}
	function delete_project_sheet()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->delete_project_sheet();
		if ($res)
			echo 1;
		else
			echo 0;
	}

	function check_duplicate_exist2()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->check_duplicate_exist2();
		if ($res)
			echo 1;
		else
			echo 0;
	}

	function check_duplicate_exist3()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->check_duplicate_exist3();
		if ($res)
			echo 1;
		else
			echo 0;
	}

	function check_duplicate_exist()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->check_duplicate_exist();
		if ($res)
			echo 1;
		else
			echo 0;
	}
	function check_duplicate_item_exist()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->check_duplicate_item_exist();
		if ($res)
			echo 1;
		else
			echo 0;
	}

	function get_bday_age_calculation()
	{
		$today_date = date('Y-m-d');
		$dob_date = date('Y-m-d', strtotime($this->input->post('bdate')));

		$date1 = date_create($today_date);
		$date2 = date_create($dob_date);

		$diff = date_diff($date1, $date2);
		$y = $diff->format("%y");
		$m = $diff->format("%m");
		$d = $diff->format("%d");

		if ($y >= 18 && $m >= 0 && $d >= 0) {
			echo 1;
		} else if ($today_date == $dob_date) {
			echo 2;
		} else {
			echo 0;
		}
	}

	function ajax_get_enquiry_info()
	{
		$value = array();
		$enq_id = $this->input->post('enq_id');

		$this->load->model('Sales_model');
		$data['records'] = $this->Sales_model->get_enquiry_record_by_id($enq_id);
		foreach ($data['records'] as $row) {
			$value = array('customer_id' => $row->cust_id, 'cust_name' => $row->cust_name, 'cust_code' => $row->cust_code, 'enquiry_code' => $row->enquiry_code, 'enquiry_date' => date('d-m-Y', strtotime($row->enq_date)), 'client_ref' => $row->client_ref, 'revision' => $row->revision, 'project_name' => $row->project_name, 'project_location' => $row->project_location, 'project_subject' => $row->project_subject);
		}
		echo json_encode($value);
	}
	function get_enquiry_items_list()
	{
		$enq_id = $this->input->post('enq_id');
		$version = $this->input->post('rev_version');

		$this->load->model('Sales_model');
		$data['records2'] = $this->Sales_model->get_enquiry_trans_for_feasibility($enq_id, $version);

		$this->load->view('ajax/sales_enq_item_table', $data);
	}
	function get_enquiry_for_cost_sheet()
	{
		$enq_id = $this->input->post('enq_id');
		$version = $this->input->post('rev_version');

		$this->load->model('Sales_model');
		$data['records2'] = $this->Sales_model->get_enquiry_trans_by_id($enq_id, $version);

		$this->load->view('ajax/sales_enq_item_for_costsheet', $data);
	}
	function get_enquiry_items_for_enq()
	{
		$enq_id = $this->input->post('enq_id');
		$version = $this->input->post('rev_version');

		$this->load->model('Sales_model');
		$data['records2'] = $this->Sales_model->get_enquiry_trans_for_quote($enq_id, $version);

		$this->load->view('ajax/sales_enq_items_for_enquiry', $data);
	}
	function get_enquiry_items_for_quote()
	{
		$enq_id = $this->input->post('enq_id');
		$version = $this->input->post('rev_version');

		$this->load->model('Product_model');
		$data['products'] = $this->Product_model->get_product_list();
		$this->load->model('Sales_model');
		$data['records'] = $this->Sales_model->get_enquiry_record_by_id($enq_id);
		$data['records2'] = $this->Sales_model->get_enquiry_trans_for_quote($enq_id, $version);
		$data['trans_records2'] = $this->Sales_model->get_enquiry_trans2_by_id($enq_id, $version);

		$this->load->view('ajax/sales_enq_items_for_quote', $data);
	}

	function get_quote_items_for_allocation()
	{
		$qid = $this->input->post('qid');
		$version = $this->input->post('rev_version');

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_quotation_master_by_id($qid);
		foreach ($data['records1'] as $v) {
			$version = $v->revision;
		}
		$data['records2'] = $this->Sales_model->get_quotation_tr_by_id($qid, $version);

		$this->load->view('ajax/sales_quote_items_for_allocation', $data);
	}
	function ajax_get_quotation_info()
	{
		$qid = $this->input->post('qid');
		$version = $this->input->post('rev_version');

		$this->load->model('Setup_model');
		$data['currency_list'] = $this->Setup_model->get_currency_list();

		$prifix = 'STK' . date('y');

		/*$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'petrostar_ref_no', 'invoice_master', 8) + 1;
		$digit = sprintf("%1$04d", $num);*/
		$data['petrostar_ref_no'] = '';

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_quotation_master_by_id($qid);
		foreach ($data['records1'] as $v) {
			$version = $v->revision;
		}
		$data['records2'] = $this->Sales_model->get_quotation_balance_tr_by_id($qid, $version);
		$data['records3'] = $this->Sales_model->get_quotation2_tr_by_id($qid);

		$this->load->view('ajax/sales_quote_details', $data);
	}
	function ajax_get_cust_accountId_from_quote()
	{
		$qid = $this->input->post('qid');

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_quotation_master_by_id($qid);
		foreach ($data['records1'] as $v) {
			$customer_id = $v->customer_id;
		}

		$this->load->model('Accounts_model');
		$data['accountId'] = $this->Accounts_model->get_cust_account_Id($customer_id);

		echo $data['accountId'];
	}


	public function get_subcategories_by_category()
	{
		$cat_id = $this->input->post('category_id');
		$this->db->where('cid', $cat_id);
		$subs = $this->db->get('costsheet_items')->result();

		echo '<option value="">Select</option>';
		foreach ($subs as $s) {
			echo '<option value="' . $s->cs_item_id . '">' . $s->sub_category_name . '</option>';
		}
	}
	public function get_item_details()
	{
		$sub_id = $this->input->post('sub_id');
		$item = $this->db->where('cs_item_id', $sub_id)->get('costsheet_items')->row();

		echo json_encode([
			'description' => $item->description,
			'unit'        => $item->unit_quantity,
			'unit_price'  => $item->unit_price
		]);
	}


	function ajax_get_copy_quotation_info()
	{
		$qid = $this->input->post('qid');
		$version = $this->input->post('rev_version');

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_quotation_master_by_id($qid);
		foreach ($data['records1'] as $v) {
			$version = $v->revision;
		}
		$data['records2'] = $this->Sales_model->get_quotation_tr_by_id($qid, $version);
		$this->load->view('ajax/sales_quote_details_for_quote', $data);
	}
	function ajax_get_quotation_price()
	{
		$qid = $this->input->post('qid');
		$this->load->model('Sales_model');
		$price = $this->Sales_model->ajax_get_quotation_price($qid);
		echo sprintf("%0.2f", $price);
	}
	function ajax_get_quotation() //sales
	{
		$value = array();
		$id = $this->input->post('post_id');

		$this->load->model('Sales_model');
		$data['records'] = $this->Sales_model->get_quotation_master_by_id($id);
		$jpack_id = '';
		$project_start_date = '';
		$project_end_date = '';
		foreach ($data['records'] as $row) {
			$project_start_date = date('d-M-Y', strtotime($row->project_start_date ?? ''));
			$project_end_date = date('d-M-Y', strtotime($row->project_end_date ?? ''));

			$value = array('customer_id' => $row->customer_id, 'customer_name' => $row->cust_name, 'project_name' => $row->project_name, 'location' => $row->project_location, 'revision' => $row->revision, 'project_start_date' => $project_start_date, 'project_end_date' => $project_end_date, 'quotation_code' => $row->quotation_code, 'quotation_date' => date('d-M-Y', strtotime($row->quotation_date)), 'quot_id' => $row->quote_id, 'enq_master_id' => $row->enq_master_id, 'enquiry_code' => $row->enquiry_code);
		}
		echo json_encode($value);
	}

	function ajax_get_invoice_info()
	{
		$qid = $this->input->post('qid');
		$data['case_no'] = $this->input->post('case_no');

		$version = $this->input->post('rev_version');

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_invoice_master_by_id($qid);
		$data['records2'] = $this->Sales_model->get_invoice_balance_tr_by_id($qid);

		$this->load->view('ajax/sales_invoice_details', $data);
	}
	function ajax_add_case_in_DO()
	{
		$data['case_no'] = $this->input->post('case_no');
		$this->load->view('ajax/sales_invoice_details', $data);
	}
	function get_customer_address()
	{
		$cust_id = $this->input->post('customer_id');

		$this->load->model('Users_model');
		$data['records'] = $this->Users_model->get_customer_by_id($cust_id);
		$data['cp_list'] = $this->Users_model->get_customer_cp_details($cust_id);

		$this->load->view('ajax/customer_address', $data);
	}
	function ajax_get_term_details()
	{
		$value = array();
		$term_id = $this->input->post('term_id');

		$this->load->model('Setup_model');
		$data['records'] = $this->Setup_model->get_terms_details_by_id($term_id);
		foreach ($data['records'] as $row) {
			$value = array('payment_term' => $row->payment_term, 'delivery_term' => $row->delivery_term, 'notes' => $row->notes, 'certificate' => $row->certificate, 'manufacture' => $row->manufacture, 'origin' => $row->origin);
		}
		echo json_encode($value);
	}
	function ajax_get_dc_info()
	{
		$do_id = $this->input->post('do_id');

		$this->load->model('Setup_model');
		$data['packing_list'] = $this->Setup_model->get_packing_type_list();

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_dc_master_by_id($do_id);
		$data['records2'] = $this->Sales_model->get_dc_tr_by_id($do_id);
		$data['records3'] = $this->Sales_model->get_dc_details_by_id($do_id);

		$this->load->view('ajax/do_details', $data);
	}
	function ajax_get_dc_info2()
	{
		$do_id = $this->input->post('do_id');
		$data['case_no'] = $this->input->post('case_no');

		$this->load->model('Setup_model');
		$data['packing_list'] = $this->Setup_model->get_packing_type_list();

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_dc_master_by_id($do_id);
		$data['records2'] = $this->Sales_model->get_dc_tr_by_id($do_id);
		$data['records3'] = $this->Sales_model->get_dc_details_by_id($do_id);

		$this->load->view('ajax/do_details_with_case', $data);
	}
	function ajax_get_quotation_for_po()
	{
		$quotation_id = $this->input->post('qid');
		$version = $this->input->post('rev_version');

		$this->load->model('Purchase_Model');
		$data['records1'] = $this->Purchase_Model->get_pruchase_quotation_by_id($quotation_id);
		foreach ($data['records1'] as $v) {
			$version = $v->revision;
		}
		$data['records2'] = $this->Purchase_Model->get_pruchase_quotation_tr_by_id($quotation_id, $version);
		$this->load->view('ajax/sales_quote_details_for_po', $data);
	}
	function ajax_get_rfq_for_po()
	{
		$qid = $this->input->post('qid');
		$version = 1;

		$prifix = 'BES/LPO/' . date('y') . '/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'po_code', 'purchase_order', 12) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . $digit;

		$this->load->model('Setup_model');
		$data['currency_list'] = $this->Setup_model->get_currency_list();
		$data['vat_percent'] = $this->Setup_model->get_vat_for_calculation();
		$this->load->model('Users_model');
		$data['supplier_records'] = $this->Users_model->get_supplier_list();
		$this->load->model('Product_model');
		$data['products'] = $this->Product_model->get_product_list();

		$this->load->model('Purchase_Model');
		$data['records1'] = $this->Purchase_Model->get_pruchase_quotation_by_id($qid);
		foreach ($data['records1'] as $v) {
			$data['payment_terms'] = $v->payment_terms;
		}
		$data['records2'] = $this->Purchase_Model->get_pruchase_quotation_tr_by_id($qid, $version);

		$this->load->view('ajax/RFQ_details_for_po', $data);
	}
	function ajax_get_rfq_for_quote()
	{
		$qid = $this->input->post('qid');
		$version = 0;

		$prifix = 'STK' . date('y');
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'po_code', 'purchase_order', 8) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . date('m') . $digit;

		$this->load->model('Setup_model');
		$data['currency_list'] = $this->Setup_model->get_currency_list();
		$data['vat_percent'] = $this->Setup_model->get_vat_for_calculation();
		$this->load->model('Users_model');
		$data['supplier_records'] = $this->Users_model->get_supplier_list();
		$this->load->model('Product_model');
		$data['products'] = $this->Product_model->get_product_list();
		$this->load->model('Purchase_Model');
		$data['records1'] = $this->Purchase_Model->get_pruchase_rfq_by_id($qid);
		$data['records2'] = $this->Purchase_Model->get_pruchase_rfq_tr_by_id($qid, $version);

		$this->load->view('ajax/RFQ_details_for_quote', $data);
	}

	function ajax_get_po_for_grn()
	{
		$po_id = $this->input->post('qid');
		$version = 1;

		$prifix = 'GRN' . date('y') . date('m');
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'grn_code', 'GRN_master', 8) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . $digit;

		$this->load->model('Product_model');
		$data['products'] = $this->Product_model->get_product_list();
		$this->load->model('Setup_model');
		$data['currency_list'] = $this->Setup_model->get_currency_list();
		$data['vat_percent'] = $this->Setup_model->get_vat_for_calculation();
		$data['store_records'] = $this->Setup_model->get_warehouse_list();
		$this->load->model('Users_model');
		$data['supplier_records'] = $this->Users_model->get_supplier_list();

		$this->load->model('Purchase_Model');
		$data['records1'] = $this->Purchase_Model->get_po_details_by_id($po_id);
		foreach ($data['records1'] as $v) {
			$version = $v->revision;
		}
		$data['records2'] = $this->Purchase_Model->get_po_items_by_id($po_id, $version);

		$this->load->view('ajax/PO_details_for_GRN.php', $data);
	}

	function ajax_get_supplier_accountId_from_po()
	{
		$po_id = $this->input->post('po_id');

		$this->load->model('Purchase_Model');
		$data['records1'] = $this->Purchase_Model->get_po_details_by_id($po_id);
		foreach ($data['records1'] as $v) {
			$supplier_id = $v->supplier_id;
		}

		$this->load->model('Accounts_model');
		$data['accountId'] = $this->Accounts_model->get_supplier_account_Id($supplier_id);

		echo $data['accountId'];
	}
	function ajax_get_supplier_accountId()
	{
		$supplier_id = $this->input->post('supplier_id');
		$this->load->model('Accounts_model');
		$data['accountId'] = $this->Accounts_model->get_supplier_account_Id($supplier_id);

		echo $data['accountId'];
	}
	function ajax_get_current_stock()
	{
		$value = array();
		$product_id = $this->input->post('product_id');
		$warehouse = 1;

		$this->load->helper('stock_helper');
		$stock = get_product_current_stock($product_id);
		$po_stock = get_po_incoming_stock($product_id);


		$avg_price = sprintf("%0.2f", get_product_last_price($product_id));

		$value = array('stock' => $stock, 'po_stock' => $po_stock, 'avg_price' => $avg_price);

		echo json_encode($value);
	}
	function ajax_get_min_stock_qty()
	{
		$stock_code = $this->input->post('stock_code');
		$warehouse_id = $this->input->post('warehouse_id');

		$this->load->model('Stock_Model');
		$min_qty = $this->Stock_Model->ajax_get_min_stock_qty($stock_code, $warehouse_id);
		echo $min_qty;
	}
	function ajax_get_model_wise_stock_list()
	{
		$product_id = $this->input->post('product_id');
		$warehouse_id = $this->input->post('warehouse');

		$this->load->model('Stock_Model');
		$data['records1'] = $this->Stock_Model->ajax_get_model_wise_stock_list($product_id, $warehouse_id);

		$this->load->view('ajax/DC_stock_issue.php', $data);
	}
	function ajax_add_bill_row_grn()
	{
		$data['rowId'] = $this->input->post('rowId');
		$data['newcnt'] = $this->input->post('newcnt');
		$data['order_code'] = $this->input->post('model_code');
		$this->load->view('ajax/GRN_bill_row.php', $data);
	}
	function get_invoice_amount()
	{
		$value = array();
		$data['invoice_id'] = $this->input->post('invoice_id');

		$this->load->model('Sales_model');
		$data['records1'] = $this->Sales_model->get_invoice_amount($data['invoice_id']);

		foreach ($data['records1'] as $v) {
			$grand_total = $v->grand_total;
			$paid_total = $v->amount;
		}
		$value = array('grand_total' => $grand_total, 'paid_total' => $paid_total, 'balance_total' => $grand_total - $paid_total);

		echo json_encode($value);
	}

	function get_purchase_invoice_amount()
	{
		$value = array();
		$data['invoice_id'] = $this->input->post('invoice_id');

		$this->load->model('Accounts_model');
		$data['records1'] = $this->Accounts_model->get_Purchase_invoice_list_by_id($data['invoice_id']);

		foreach ($data['records1'] as $v) {
			$grand_total = $v->grand_total;
			$paid_total = $v->amount;
		}
		$value = array('grand_total' => $grand_total, 'paid_total' => $paid_total, 'balance_total' => $grand_total - $paid_total);

		// $value = array('grand_total' => $grand_total);

		echo json_encode($value);
	}
	function ajax_get_requisition_items()
	{
		$this->load->model('Product_model');
		$data['products'] = $this->Product_model->get_product_list();

		$this->load->model('Ajax_model');
		$data['trans_records'] = $this->Ajax_model->ajax_get_requisition_items();

		$this->load->view('ajax/requisition_item_table.php', $data);
	}


	function ajax_get_user_info()
	{
		$value = array();
		$id = $this->input->post('user_id');

		$this->load->model('Users_model');
		//$data['records'] = $this->Users_model->get_user_record_by_id($id);
		$data['record1'] = $this->Users_model->get_user_record_by_id_pass($id);
		foreach ($data['record1'] as $row) {
			$document_number = $row->document_number;
			$posession = $row->posession;
			$issue_date = date('d-m-Y', strtotime($row->issue_date));
			$expiry_date = date('d-m-Y', strtotime($row->expiry_date));
		}
		$value = array('document_number' => $document_number, 'posession' => $posession, 'issue_date' => $issue_date, 'expiry_date' => $expiry_date);

		echo json_encode($value);
	}

	function ajax_get_employee_details()
	{
		$value = array();
		$id = $this->input->post('user_id');

		$this->load->model('Users_model');
		$data['record1'] = $this->Users_model->ajax_get_employee_details($id);
		foreach ($data['record1'] as $row) {
			$designation_name = $row->designation_name;
			$dept_name = $row->dept_name;
			$joining_date = date('d-m-Y', strtotime($row->joining_date));
			$resignation_date = date('d-M-Y', strtotime($row->resignation_date));
			$last_working_date = date('d-M-Y', strtotime($row->last_working_date));

			$start_ts = strtotime($row->joining_date);
			$end_ts = strtotime($row->resignation_date);
			$diff = $end_ts - $start_ts;
			$days = (round($diff / 86400)) + 1;
			$no_of_yearmonth = sprintf("%0.2f", $days / 365);

			$basic_salary = $row->basic_salary;
			$total_allowances = $row->total_allowances;
			$total_deductions = $row->total_deductions;
			$dailyBasic = sprintf("%0.2f", $row->basic_salary / 30);
		}
		$value = array('designation_name' => $designation_name, 'dept_name' => $dept_name, 'joining_date' => $joining_date, 'resignation_date' => $resignation_date, 'last_working_date' => $last_working_date, 'basic_salary' => $basic_salary, 'total_allowances' => $total_allowances, 'total_deductions' => $total_deductions, 'gross' => $basic_salary + $total_allowances, 'totaldays' => $days, 'no_of_yearmonth' => $no_of_yearmonth, 'dailyBasic' => $dailyBasic);

		echo json_encode($value);
	}
	function get_customer_account_id()
	{
		$customer_id = $this->input->post('customer_id');

		$this->load->model('Accounts_model');
		$data['accountId'] = $this->Accounts_model->get_customer_account_id($customer_id);

		echo $data['accountId'];
	}
	function get_invoice_list()
	{
		$value = array();
		$account_id = $this->input->post('account_id');

		// log_message('error', 'Account ID: ' . $account_id);

		$data['records1'] = '';
		$this->load->model('Ajax_model');
		$data['record'] = $this->Ajax_model->get_general_ledger_list_by_id($account_id);
		// Log records from Ajax_model
		// log_message('error', 'General Ledger Records: ' . print_r($data['record'], true));

		foreach ($data['record'] as $v) {
			$customer_id = $v->customer_id;

			$this->load->model('Invoice_model');
			$data['records1'] = $this->Invoice_model->get_debt_invoice_list($customer_id, $account_id);

			// Log invoice list
			// log_message('error', 'Debt Invoice List: ' . print_r($data['records1'], true));
		}


		// Final data sent to view
		// log_message('error', 'Final Data Sent To View: ' . print_r($data, true));
		$this->load->view('ajax/inv_list_debtors.php', $data);
	}
	public function get_grn_list()
	{
		$account_id = $this->input->post('supplier_id');
		log_message('error', 'Accountr ID: ' . $account_id);

		if (empty($account_id)) {
			echo "Supplier ID is required.";
			return;
		}

		$this->load->model('Accounts_model');
		$supplier_id = $this->Accounts_model->get_supp_id_from_account_id($account_id);
		log_message('error', 'Supplier ID: ' . $supplier_id);

		if (empty($supplier_id)) {
			echo "No supplier found for this account.";
			return;
		}

		$this->load->model('Purchase_Model');
		$data['records1'] = $this->Purchase_Model->get_grn_master_data($supplier_id, $account_id);

		$this->load->view('ajax/grn_list_payment_entry.php', $data);
	}


	//    function get_grn_list()
	//    {
	// 	$value=array();
	// 	$account_id = $this->input->post('supplier_id');

	// 	$this->load->model('Accounts_model');
	// 	$supplier_id = $this->Accounts_model->get_supp_id_from_account_id($account_id);

	// 	$this->load->model('Sales_model');
	// 	$data['records1']=$this->Sales_model->get_grn_master_data($supplier_id, $account_id);

	// 	$this->load->view('ajax/grn_list_payment_entry.php',$data);
	//   }

	function get_enquiry_controlpanels_list()
	{
		$value = array();
		$enq_id = $this->input->post('enq_id');
		$rev_version = $this->input->post('rev_version');


		$this->load->model('Sales_model');
		$data['records'] = $this->Sales_model->get_enquiry_controlpanels_list($enq_id, $rev_version);
		$data['records1'] = $this->Sales_model->get_cost_sheet_master_by_id();

		$this->load->view('ajax/enquiry_controlpanels_list.php', $data);
	}
	public function check_duplicate_exist5()
	{
		$this->load->model('Ajax_model');
		$res = $this->Ajax_model->check_duplicate_exist5();

		// Echo the count
		echo $res > 0 ? 1 : 0;
	}
	function get_reco_list()
	{
		$value = array();
		$account_id = $this->input->post('account_id');
		$this->load->model('Accounts_model');
		$data['records'] = $this->Accounts_model->get_reco_list($account_id);


		$this->load->view('ajax/reco_list.php', $data);
	}
	/*********************************************************************************************************************/


	function ajax_get_cust_accountId_from_dc()
	{
		// if (!$this->session->userdata('user_id')) {
		//     echo json_encode([
		//         'status' => false,
		//         'message' => 'Session expired'
		//     ]);
		//     exit;
		// }

		$qid = $this->input->post('qid');
		log_message('error', $qid);

		$this->load->model('Quotation_model');
		$records = $this->Quotation_model->get_quotation($qid);

		if (empty($records)) {
			echo json_encode([
				'status' => false,
				'message' => 'Invalid quotation'
			]);
			exit;
		}

		$this->load->model('Accounts_model');

		$accountId = $this->Accounts_model
			->get_cust_account_Id($records->customer_id);


		echo json_encode([
			'status' => true,
			'accountId' => $accountId
		]);
		exit;
	}

	function ajax_get_rfq_info()
	{
		$value = array();
		$rfq_id = $this->input->post('rfq_id');

		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_purchase_rfq_by_id($rfq_id);
		foreach ($data['records'] as $row) {
			$value = array('supplier_id' => $row->supplier_id, 'supplier_code' => $row->supplier_code, 'supplier_name' => $row->supplier_name, 'rfq_created_by' => $row->rfq_created_by, 'project' => $row->project, 'ref' => $row->ref);
		}
		echo json_encode($value);
	}
	function get_rfq_items_for_quote()
	{

		$rfq_id = $this->input->post('rfq_id');
		$this->load->model('Purchase_Model');
		$this->load->model('Setup_model');
		$data['active_units'] = $this->Setup_model->get_active_unit_list();
		$data['records2'] = $this->Purchase_Model->get_purchase_rfq_tr($rfq_id);
		log_message('error', 'RFQ Data: ' . print_r($data['records2'], true));
		$this->load->view('ajax/purchase_rfq_items_for_quote', $data);
	}

	function ajax_get_quote_info()
	{
		$value = array();
		$quotation_id = $this->input->post('quotation_id');

		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_pur_qtn_master_by_id($quotation_id);
		log_message('error', 'RFQ Data: ' . print_r($data['records'], true));
		foreach ($data['records'] as $row) {
			$value = array('supplier_id' => $row->supplier_id, 'supplier_code' => $row->supplier_code, 'supplier_name' => $row->supplier_name, 'subtotal' => $row->subtotal, 'discount_percent' => $row->discount_percent, 'discount' => $row->discount, 'vat_percent' => $row->vat_percent, 'vat_amt' => $row->vat_amt, 'grand_total' => $row->grand_total, 'validity' => $row->validity, 'payment_term' => $row->payment_term, 'general_term' => $row->general_term, 'delivery_term' => $row->delivery_term, 'reference' => $row->reference, 'project' => $row->project);
		}
		echo json_encode($value);
	}

	function get_quote_items_for_po()
	{

		$quotation_id = $this->input->post('quotation_id');
		$this->load->model('Purchase_Model');
		$this->load->model('Setup_model');
		$data['records2'] = $this->Purchase_Model->get_pur_qtn_tr_by_id($quotation_id);
		$data['active_units'] = $this->Setup_model->get_active_unit_list();
		$this->load->view('ajax/purchase_quote_items_for_po', $data);
	}

	function ajax_get_po_info()
	{
		$value = array();
		$po_id = $this->input->post('po_id');

		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_po_master_by_id($po_id);
		log_message('error', 'RFQ Data: ' . print_r($data['records'], true));
		foreach ($data['records'] as $row) {
			$value = array('supplier_id' => $row->supplier_id, 'supplier_code' => $row->supplier_code, 'supplier_name' => $row->supplier_name, 'subtotal' => $row->sub_total, 'discount_percent' => $row->discount_percent, 'discount' => $row->discount, 'vat_percent' => $row->vat_percent, 'vat_amt' => $row->vat_amt, 'grand_total' => $row->grand_total);
		}
		echo json_encode($value);
	}
	function get_po_items_for_grn()
	{
		$po_id = $this->input->post('po_id');
		$this->load->model('Purchase_Model');
		$this->load->model('Setup_model');
		$data['active_units'] = $this->Setup_model->get_active_unit_list();
		$data['records2'] = $this->Purchase_Model->get_po_tr_by_id($po_id);
		log_message('error', 'po Data: ' . print_r($data['records2'], true));

		//  $data['approved_quotations'] = $this->Purchase_Model->get_approved_quotation_list();
		$this->load->view('ajax/purchase_po_items_for_grn', $data);
	}

	function ajax_get_paid_leave_info()
	{
		$value = array();
		$employee_id = $this->input->post('employee_id');
		$ltype_id = $this->input->post('ltype_id');

		$this->load->model('Ajax_model');
		$data['record1'] = $this->Ajax_model->get_paid_leave_type_days($employee_id, $ltype_id);
		foreach ($data['record1'] as $row) {
			$paid_days = $row->paid_days;
			$use_paid_leave = $row->use_paid_leave;
		}
		$value = array('paid_days' => $paid_days, 'use_paid_leave' => $use_paid_leave);

		echo json_encode($value);
	}
	// ===================== purchase return =======================

	public function ajax_get_grn_info()
	{

		$grn_id = $_POST['grn_id'];

		$row = $this->db
			->select('purchase_grn_master.*, supplier_master.supplier_name, supplier_master.supplier_code')
			->from('purchase_grn_master')
			->join('supplier_master', 'supplier_master.supplier_id = purchase_grn_master.supplier_id', 'left')
			->where('purchase_grn_master.grn_id', $grn_id)
			->get()
			->row();

		echo json_encode($row);
	}

	public function get_grn_items_for_return()
	{

		$grn_id = $_POST['grn_id'];

		$data['records2'] = $this->db
			->select('purchase_grn_transaction.*, spare_parts.part_name')
			->from('purchase_grn_transaction')
			->join('spare_parts', 'spare_parts.part_id = purchase_grn_transaction.product_id', 'left')
			->where('purchase_grn_transaction.grn_master_id', $grn_id)
			->get()
			->result();

		// log_message('error', 'records2: ' . print_r($data['records2'], true));

		$data['active_units'] = $this->db
			->get('unit_master')
			->result();
		log_message('error', 'active_units: ' . print_r($data['active_units'], true));

		$this->load->view('ajax/get_grn_items_for_return', $data);
	}
}
