<?php

// date_default_timezone_set('Asia/Kolkata');

class Accounts extends CI_Controller
{

	function __construct()
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

	function get_account_balance()
	{
		$account_id = $this->input->post('account_id');
		$vdate = date('Y-m-d', strtotime($this->input->post('today')));
		$this->load->model('Accounts_model');
		$res = $this->Accounts_model->get_account_balance($account_id, $vdate);
		echo $res;
	}


	//////////////////////////////// Account group starts ////////////////////////////////

	function view_account_group_form()
	{
		$data['title'] = 'Account Group';
		$this->load->model('Accounts_model');
		$data['parent_records'] = $this->Accounts_model->get_account_group_parent();
		$data['section_records'] = $this->Accounts_model->get_account_section();
		$data['main_content'] = 'Accounts/account_group_addition.php';
		$this->load->view('includes/template', $data);
	}

	function account_group_list()
	{
		$data['title'] = 'Account Group';
		$this->load->model('Accounts_model');
		$data['account_records'] = $this->Accounts_model->get_account_group_list();
		$data['main_content'] = 'Accounts/list_account_group_addition.php';
		$this->load->view('includes/template', $data);
	}

	function add_account_group_records()
	{
		$data['title'] = 'Account Group';
		$this->load->model('Accounts_model');
		$flag = $this->Accounts_model->add_account_group_addition();
		if ($flag == 0) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Accounts/account_group_list');
		} else {
			$this->session->set_flashdata('error', 'Account Name Already Exist');
			redirect('Accounts/account_group_list');
		}
	}

	function edit_account_group_form()
	{
		$data['title'] = 'Account Group';
		$this->load->model('Accounts_model');
		$data['parent_records'] = $this->Accounts_model->get_account_group_parent();
		$data['section_records'] = $this->Accounts_model->get_account_section();
		$data['acc_grp_records'] = $this->Accounts_model->get_account_group_list_by_id();
		$data['main_content'] = 'Accounts/edit_account_group_addition.php';
		$this->load->view('includes/template', $data);
	}

	function update_account_grp_records()
	{
		$data['title'] = 'Account Group';
		$this->load->model('Accounts_model');
		$insert_id = $this->Accounts_model->update_account_group();
		if ($insert_id) {
			$this->session->set_flashdata('success', 'Data Updated successfully');
			redirect('Accounts/account_group_list');
		} else {
			$this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
			redirect('Accounts/account_group_list');
		}
	}

	function delete_group()
	{
		$data['title'] = 'Account Group';
		$id = $this->input->post('post_id');
		$this->load->model('Accounts_model');
		$res = $this->Accounts_model->delete_group_record($id);
		echo $res;
	}

	//////////////////////////////// Account group end ////////////////////////////////

	///////////////////////////// General Ledger Account starts ////////////////////////////

	function view_general_ledger_account_form()
	{
		$data['title'] = 'General Ledger Account';
		$this->load->model('Accounts_model');
		$data['account_records'] = $this->Accounts_model->get_account_group();
		$data['customer_records'] = $this->Accounts_model->get_customer_record();
		$data['supplier_records'] = $this->Accounts_model->get_supplier_record();
		$data['main_content'] = 'Accounts/general_ledger_account.php';
		$this->load->view('includes/template', $data);
	}

	function edit_general_ledger_account_form()
	{
		$data['title'] = 'General Ledger Account';
		$this->load->model('Accounts_model');
		$data['account_records'] = $this->Accounts_model->get_account_group();
		$data['gen_ledger_records'] = $this->Accounts_model->get_general_ledger_list_by_id();
		//	$data['opening_balance'] = $this->Accounts_model->get_opening_balance_by_id();
		$data['main_content'] = 'Accounts/general_ledger_account_edit.php';
		$this->load->view('includes/template', $data);
	}

	function list_general_ledger_account_form()
	{
		$data['title'] = 'General Ledger Account';
		$this->load->model('Accounts_model');
		$data['ledger_records'] = $this->Accounts_model->get_general_ledger_list();
		$data['main_content'] = 'Accounts/general_ledger_account_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_general_ledger_records()
	{
		$data['title'] = 'General Ledger Account';
		$user_id = $this->input->post('ac_name');
		$acc_type = $this->input->post('account_type');
		if ($acc_type == 'OTHER') {
			$account_name = $this->input->post('ac_name');
			$user_id = '';
		} else if ($acc_type == 'CUS') {
			$user_id = $this->input->post('acc_type');
			//	$this->load->helper('finance_helper.php');
			//	$account_name = get_name_record($acc_type,$user_id);
			$account_name = $this->input->post('CUS');
			$customer_id = $this->input->post('CUS');
		} else if ($acc_type == 'SUPP') {
			$user_id = $this->input->post('acc_type');
			$account_name = $this->input->post('SUPP');
		}
		$this->load->model('Accounts_model');
		$insert_id = $this->Accounts_model->add_general_leadger();

		if ($flag == 0) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Accounts/list_general_ledger_account_form');
		} else {
			$this->session->set_flashdata('error', 'Ward No/Name Already Exist');
			redirect('Accounts/list_general_ledger_account_form');
		}
	}

	function update_general_ledger_records()
	{
		$data['title'] = 'General Ledger Account';
		$this->load->model('Accounts_model');
		$insert_id = $this->Accounts_model->update_general_ledger();
		if ($insert_id) {
			$this->session->set_flashdata('success', 'Data Updated successfully');
			redirect('Accounts/list_general_ledger_account_form');
		} else {
			$this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
			redirect('Accounts/list_general_ledger_account_form');
		}
	}

	function delete_ledger_record()
	{
		$data['title'] = 'General Ledger Account';
		$id = $this->input->post('account_id');
		$this->load->model('Accounts_model');
		$res = $this->Accounts_model->delete_ledger($id);
		echo $res;
	}

	function ajax_get_ledger_group()
	{
		$account_id = $this->input->post('account_id');
		$data['type'] = $this->input->post('type');
		$this->load->model('Accounts_model');
		$data['ledger_records'] = $this->Accounts_model->get_general_ledger_by_group_id($account_id);
		$this->load->view('ajax/select_account_ledger', $data);
	}
	/////////////////////// contra_entry_add start  //////////////////////
	function add_contra_entry()
	{ //in use
		$data['title'] = "Add Contra Entry";
		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts();
		$data['credit_records'] = $this->Accounts_model->get_all_general_ledger_accounts();
		$data['main_content'] = 'Accounts/contra_entry_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_contra_entry_details()
	{ //in use
		$data['title'] = "Add Contra Entry";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_contra_entry();
		if ($id != '')
			$this->session->set_flashdata('success', 'Record Successfully Saved');
		redirect('Accounts/list_contra_entry');
	}

	function list_contra_entry()
	{ //in use
		$data['title'] = "Contra Entry List";
		if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}
		$this->load->model('Accounts_model');
		$data['records'] = $this->Accounts_model->get_contra_entry_records($data['from'], $data['to']);
		$data['main_content'] = 'Accounts/contra_entry_list.php';
		$this->load->view('includes/template', $data);
	}
	/////////////////////////////////////////////////////////

	/////////////////////// journal start  //////////////////////
	function journal()
	{ //in use
		$data['title'] = "Add Journal Entry";
		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('Expense', '');
		$data['credit_records'] = $this->Accounts_model->get_general_ledger_accounts('Liabilities', '');
		$data['main_content'] = 'Accounts/journal_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_journal_details()
	{ //in use
		$data['title'] = "Journal";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_journal();
		if ($id != '')
			$this->session->set_flashdata('success', 'Record Successfully Saved');
		redirect('Accounts/view_journal_list');
	}

	function view_journal_list()
	{ //in use
		$data['title'] = "Journal List";
		if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}
		$this->load->model('Accounts_model');
		$data['records'] = $this->Accounts_model->get_journal_records_new($data['from'], $data['to']);
		// log_message('error', 'Journal Records: ' . print_r($data['records'], true));
		$data['main_content'] = 'Accounts/journal_list.php';
		$this->load->view('includes/template', $data);
	}
	/////////////////////////////////////////////////////////


	/////////////////////////////////// Debit Note Start////////////////////////////////////////
	function add_debit_note()
	{ //in use
		$data['title'] = "Debit Note";
		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('Expense', '');
		$data['credit_records'] = $this->Accounts_model->get_general_ledger_accounts('Liabilities', '');
		$data['main_content'] = 'Accounts/debit_note';
		$this->load->view('includes/template', $data);
	}

	function add_debit_note_details()
	{ //in use
		$data['title'] = "Debit Note";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_debit_note();
		if ($id != '')
			$this->session->set_flashdata('success', 'Record Successfully Saved');
		redirect('Accounts/view_debit_note_list');
	}

	function view_debit_note_list()
	{ //in use
		$data['title'] = "Debit Note";
		if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}
		$this->load->model('Accounts_model');
		$data['debit_note'] = $this->Accounts_model->get_debit_note_records($data['from'], $data['to']);
		$data['main_content'] = 'Accounts/debit_note_list';
		$this->load->view('includes/template', $data);
	}

	function edit_debit_note() //in use
	{
		$data['title'] = "Edit Debit Note";
		$this->load->model('Accounts_model');
		$data['debit_note_edit'] = $this->Accounts_model->get_debit_note_records_by_id();
		$data['main_content'] = 'Accounts/edit_debit_note';
		$this->load->view('includes/template', $data);
	}
	function update_debit_note() //in use
	{
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->update_debit_note();
		if ($id) {
			$this->session->set_flashdata('success', 'Data Updated successfully');
			redirect('Accounts/view_debit_note_list');
		} else {
			$this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
			redirect('Accounts/get_edit_debit_note');
		}
	}
	/////////////////////////////////// Debit Note End////////////////////////////////////////

	/////////////////////////////////// Credit Note Start////////////////////////////////////////

	function credit_note()
	{ //in use
		$data['title'] = "Credit Note";
		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('', 'Income');
		$data['credit_records'] = $this->Accounts_model->get_general_ledger_accounts('Assets', '');

		$data['main_content'] = 'Accounts/credit_note';
		$this->load->view('includes/template', $data);
	}
	// =======================================================

	function supplier_advance()
	{ //in use
		$data['title'] = "Supplier Advance";
		$this->load->model('Accounts_model');
		// $data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('', 'Income');
		$data['credit_records'] = $this->Accounts_model->get_general_ledger_accounts('Assets', '');
		$data['sundry_detors_records'] = $this->Accounts_model->get_supplier_account_all();


		$data['main_content'] = 'Accounts/supplier_advance';
		$this->load->view('includes/template', $data);
	}

	function add_supplier_advance()
	{ //in use
		$data['title'] = "Supplier Advance";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_supplier_advance();
		if ($id != '')
			$this->session->set_flashdata('success', 'Record Successfully Saved');
		redirect('Accounts/view_supplier_advance_list');
	}

	function view_supplier_advance_list()
	{ //in use
		$data['title'] = "Supplier Advance";
		if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}
		$this->load->model('Accounts_model');
		$data['credit_note'] = $this->Accounts_model->get_supplier_advance_records($data['from'], $data['to']);
		$data['main_content'] = 'Accounts/supplier_advance_list';
		$this->load->view('includes/template', $data);
	}

	// ===========================================================

	function add_credit_note()
	{ //in use
		$data['title'] = "Credit Note";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_credit_note();
		if ($id != '')
			$this->session->set_flashdata('success', 'Record Successfully Saved');
		redirect('Accounts/view_credit_note_list');
	}

	function view_credit_note_list()
	{ //in use
		$data['title'] = "Credit Note";
		if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}
		$this->load->model('Accounts_model');
		$data['credit_note'] = $this->Accounts_model->get_credit_note_records($data['from'], $data['to']);
		$data['main_content'] = 'Accounts/credit_note_list';
		$this->load->view('includes/template', $data);
	}

	function edit_credit_note() //in use
	{
		$data['title'] = "Credit Note";
		$this->load->model('Accounts_model');
		$data['credit_note_edit'] = $this->Accounts_model->get_credit_note_records_by_id();
		$data['main_content'] = 'Accounts/edit_credit_note';
		$this->load->view('includes/template', $data);
	}
	function update_credit_note() //in use
	{
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->update_credit_note();
		if ($id) {
			$this->session->set_flashdata('success', 'Data Updated successfully');
			redirect('Accounts/view_credit_note_list');
		} else {
			$this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
			redirect('Accounts/get_edit_credit_note');
		}
	}

	/////////////////////////////////// Credit Note End////////////////////////////////////////

	///////////////////////////////Receipt Start////////////////////////////////////
	// function add_receipt()
	// {
	//   // in use
	//   $data['title'] = "Receipt Entry";

	//   $data['ledger_id'] = $this->input->post('occupier_id');
	//   $d1 = date('Y-m-d');
	//   $data['opening_bal'] = '';

	//   $this->load->model('Sales_model');
	//   $data['records'] = $this->Sales_model->get_tax_invoice_list();

	//   $this->load->model('Accounts_model');
	//   $data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('2', '4');
	//   $data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts();
	//   $data['receipt_Creditors'] = $this->Accounts_model->get_general_ledger_accounts('1', '3'); //customer

	//   $data['main_content'] = 'Accounts/receipt_add.php';
	//   $this->load->view('includes/template', $data);
	// }
	function add_receipt()
	{
		// in use
		$data['title'] = "Receipt Entry";

		$data['ledger_id'] = $this->input->post('occupier_id');
		$d1 = date('Y-m-d');
		$data['opening_bal'] = '';

		// $this->load->model('Sales_model');
		// $data['records'] = $this->Sales_model->get_tax_invoice_list();

		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('2', '4');
		//$data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts();
		$data['receipt_Creditors'] = $this->Accounts_model->get_general_ledger_accounts('1', '3'); //customer
		//$data['customer_records'] = $this->Accounts_model->get_customer_record();
		//echo '<pre>';print_r($data);exit;
		$data['main_content'] = 'Accounts/receipt_add.php';
		$this->load->view('includes/template', $data);
	}

	// function add_receipt_details()
	// { // in use
	//   $data['title'] = "Receipt ";
	//   $this->load->model('Accounts_model');
	//   $id = $this->Accounts_model->add_new_receipt();
	//   if ($id != '') {
	//     $this->session->set_flashdata('success', 'Record Successfully Saved');
	//     redirect('accounts/view_receipt_list');
	//   }
	// }


	function add_receipt_details()
	{
		// var_dump($this->input->post('customer_org_id'));
		// echo "<pre>sss"; print_r($_POST); exit;

		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_new_receipt(); // this function uses $_POST data internally

		if ($id != '') {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Accounts/view_receipt_list');
		} else {
			$this->session->set_flashdata('error', 'Failed to save receipt');
			redirect('Accounts/add_receipt');
		}
	}



	function view_receipt_list() // in use
	{
		$data['title'] = "Receipt List";
		$data['header'] = $this->input->post('header');

		if ($this->uri->segment(3)) {
			$data['division_id'] = $this->uri->segment(3);
			$data['from'] = $this->uri->segment(4);
			$data['to'] = $this->uri->segment(5);
		} else if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}

		$this->load->model('Accounts_model');
		$data['receipt'] = $this->Accounts_model->get_receipt_list($data['from'], $data['to']);

		$data['main_content'] = 'Accounts/receipt_list.php';
		$this->load->view('includes/template', $data);
	}
	function edit_receipt() // in use
	{
		$data['title'] = "Receipt Edit";
		$this->load->model('accounts/debit_note');
		$data['receipt_records'] = $this->debit_note->receipt_records_pmc();

		$this->load->model('vehicle/vehicle_model');
		$data['driver_records'] = $this->vehicle_model->get_driver_records();
		$this->load->model('bags/Bags_master_model');
		$data['user_records'] = $this->Bags_master_model->get_user_details();

		$data['main_content'] = 'accounts/edit_receipt';
		$this->load->view('includes/template', $data);
	}

	function get_edit_pmc_receipt_data() // in use
	{
		$data['title'] = "Receipt Edit";
		$data['voucher_id'] = $this->input->post('voucher_id');
		$data['occupier'] = $this->input->post('occupier');
		$data['division_id'] = $this->uri->segment(4);
		$data['from'] = $this->uri->segment(5);
		$data['to'] = $this->uri->segment(6);
		$this->load->model('accounts/debit_note');
		$data['receipt_records'] = $this->debit_note->receipt_records_pmc();

		$this->load->model('vehicle/vehicle_model');
		$data['driver_records'] = $this->vehicle_model->get_driver_records();
		$this->load->model('bags/Bags_master_model');
		$data['user_records'] = $this->Bags_master_model->get_user_details();

		$data['main_content'] = 'accounts/edit_receipt';
		$this->load->view('includes/template', $data);
	}

	function update_pmc_receipt_data()
	{ // in use
		$data['title'] = "Receipt";
		$division_id = trim($this->input->post('division_id'));
		$from = trim($this->input->post('from'));
		$to = trim($this->input->post('to'));

		$this->load->model('accounts/debit_note');
		$id = $this->debit_note->update_receipt();
		if ($id) {
			$this->session->set_flashdata('success', 'Data Updated successfully');
		} else {
			$this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
		}
		redirect("accounts/view_receipt_list/" . $division_id . '/' . $from . '/' . $to);
	}



	function print_receipt()
	{
		// $voucher_code = $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6);
		$segments = array_slice($this->uri->segment_array(), 2);
		$voucher_code = implode('/', $segments);

		// $this->load->model('Setup_model');
		// $data['logo_details'] = $this->Setup_model->get_company_master_list();

		$this->load->model('Accounts_model');
		$data['header'] = $this->Accounts_model->get_receipt_header($voucher_code);
		//  print_r($data['header']); exit;
		$data['details'] = $this->Accounts_model->get_receipt_details($voucher_code);

		if (!$data['header']) {
			show_error("Receipt not found!");
		}

		$this->load->view('Accounts/print/print_receipt', $data);
	}



	///////////////////////////////Payment Start////////////////////////////////////
	// function add_payment()
	// {
	//   // in use
	//   $data['title'] = "Payment Entry";

	//   $data['ledger_id'] = $this->input->post('occupier_id');
	//   $d1 = date('Y-m-d');
	//   $data['opening_bal'] = '';

	//   $this->load->model('Accounts_model');
	//   $data['records'] = $this->Accounts_model->get_Purchase_invoice_list();
	//   $data['account_records'] = $this->Accounts_model->get_account_group_list();

	//   $this->load->model('Accounts_model');
	//   $data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts(); //all ledgers
	//   $data['receipt_Creditors'] = $this->Accounts_model->get_all_general_ledger_accounts(); //bank

	//   $data['main_content'] = 'Accounts/payment_add.php';
	//   $this->load->view('includes/template', $data);
	// }
	function add_payment()
	{
		// in use
		$data['title'] = "Payment Entry";

		$data['ledger_id'] = $this->input->post('occupier_id');
		$d1 = date('Y-m-d');
		$data['opening_bal'] = '';

		$this->load->model('Supplier_model');
		$data['suppliers'] = $this->Supplier_model->get_active_supplier_list(); //customer

		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('2', '4');
		$data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts();
		// $data['receipt_Creditors'] = $this->Accounts_model->get_general_ledger_accounts('1', '3'); //customer
		$data['receipt_Creditors'] = $this->Accounts_model->get_all_general_ledger_accounts();
		$data['main_content'] = 'Accounts/payment_add.php';
		$this->load->view('includes/template', $data);
	}
	function add_payment_details()
	{ // in use
		$data['title'] = "Payment Entry";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_new_payment_data();
		if ($id != '') {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Accounts/view_payment_list');
		}
	}

	function view_payment_list() // in use
	{
		$data['title'] = "Payment List";
		$data['header'] = $this->input->post('header');

		if ($this->uri->segment(3)) {
			$data['division_id'] = $this->uri->segment(3);
			$data['from'] = $this->uri->segment(4);
			$data['to'] = $this->uri->segment(5);
		} else if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}

		$this->load->model('Accounts_model');
		$data['receipt'] = $this->Accounts_model->get_payment_list($data['from'], $data['to']);

		$data['main_content'] = 'Accounts/payment_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_payment() // in use
	{
		$data['title'] = "Payment Edit";
		$this->load->model('accounts/debit_note');
		$data['receipt_records'] = $this->debit_note->receipt_records_pmc();

		$this->load->model('vehicle/vehicle_model');
		$data['driver_records'] = $this->vehicle_model->get_driver_records();
		$this->load->model('bags/Bags_master_model');
		$data['user_records'] = $this->Bags_master_model->get_user_details();

		$data['main_content'] = 'accounts/edit_receipt';
		$this->load->view('includes/template', $data);
	}

	function get_edit_payment_data() // in use
	{
		$data['title'] = "Payment edit";
		$data['voucher_id'] = $this->input->post('voucher_id');
		$data['occupier'] = $this->input->post('occupier');
		$data['division_id'] = $this->uri->segment(4);
		$data['from'] = $this->uri->segment(5);
		$data['to'] = $this->uri->segment(6);
		$this->load->model('accounts/debit_note');
		$data['receipt_records'] = $this->debit_note->receipt_records_pmc();

		$this->load->model('vehicle/vehicle_model');
		$data['driver_records'] = $this->vehicle_model->get_driver_records();
		$this->load->model('bags/Bags_master_model');
		$data['user_records'] = $this->Bags_master_model->get_user_details();

		$data['main_content'] = 'accounts/edit_receipt';
		$this->load->view('includes/template', $data);
	}

	function update_payment_data()
	{ // in use
		$data['title'] = "Payment ";
		$division_id = trim($this->input->post('division_id'));
		$from = trim($this->input->post('from'));
		$to = trim($this->input->post('to'));

		$this->load->model('accounts/debit_note');
		$id = $this->debit_note->update_receipt();
		if ($id) {
			$this->session->set_flashdata('success', 'Data Updated successfully');
		} else {
			$this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
		}
		redirect("accounts/view_receipt_list/" . $division_id . '/' . $from . '/' . $to);
	}

	function print_payment() // in use
	{
		$data['title'] = "Payment Print";
		$data['header'] = $this->input->post('header');
		$this->load->model('Setup_Model');
		$data['logo_details'] = $this->Setup_Model->get_company_master_list();

		$this->load->model('Accounts_model');
		$data['receipt'] = $this->Accounts_model->transport_receipt_records();
		$this->load->view('Accounts/print/print_receipt', $data);
	}
	function delete_trans_entry()
	{
		$voucher_code = $this->input->post('voucher_code');
		$this->load->model('Accounts_model');
		$res = $this->Accounts_model->delete_trans_entry($voucher_code);
		echo $res;
	}
	function view_account_transaction_details()
	{
		$data['title'] = "Transactions Details";
		$voucher_id = $this->uri->segment(3);

		$this->load->model('Accounts_model');
		$data['res'] = $this->Accounts_model->view_account_transaction_details($voucher_id);

		$data['main_content'] = 'Accounts/account_transaction_details.php';
		$this->load->view('includes/template', $data);
	}
	function ajax_get_invoice_list()
	{
		$data['account_id'] = $this->input->post('account_id');

		$this->load->model('Accounts_model');
		$data['res'] = $this->Accounts_model->ajax_get_invoice_list($data['account_id']);
		log_message('error', 'Invoice List: ' . print_r($data['res'], true));
		if (empty($data['res']))
			echo 0;
		else
			$this->load->view('ajax/account_invoice_list.php', $data);
	}
	//////////////////////////////////////////////////////////
	function get_outstanding_balance()
	{
		$account_id = $this->input->post('account_id');
		$from_date1 = date('Y-m-d', strtotime($this->input->post('from_date')));
		$this->load->helper('myopeningbalance');
		$balance = calculate_todays_opening_bal($from_date1, $account_id);
		echo $balance;
	}


	///////////////// Individual ledger /////////////////
	function view_individual_ledger()
	{
		$data['title'] = "Report-Individual Ledger Details";
		// $data['from_date'] = date('01-01-Y');
		// $data['to_date'] = date('31-12-Y');
		$data['from_date'] = date("d-m-Y", strtotime(date("Y-m-01")));

		// $data['from_date'] = date('d-m-Y', strtotime('01-01-' . date('Y')));
		$data['to_date'] = date("d-m-Y", strtotime(date("Y-m-d")));
		//    
		// log_message('error', $data['from_date'] . "," . $data['to_date']);
		$data['account_id'] = "";

		$this->load->model('Accounts_model');
		$data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();

		$data['ledger_transaction_records'] = "";
		// echo "<pre>"; print_r( $data); exit;
		$data['main_content'] = 'reports/account/view_individual_ledger_details';
		$this->load->view('includes/template', $data);
	}
	public function search_individual_ledger_details()
	{
		$data['title'] = "Report - Individual Ledger Details";

		// Account ID from POST or URL segment
		$account_id = $this->input->post('account_id') ?? $this->uri->segment(3);



		$from_date = empty($this->uri->segment(4))
			? $this->input->post('from_date')
			: $this->uri->segment(4);

		$to_date = empty($this->uri->segment(5))
			? $this->input->post('to_date')
			: $this->uri->segment(5);

		// Assign to data array
		$data['account_id'] = $account_id;
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		// Load models
		$this->load->model('Accounts_model');
		$data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();
		$data['ledger_transaction_records'] = $this->Accounts_model->get_ledger_report($account_id, $from_date, $to_date);

		// Load view
		$data['main_content'] = 'reports/account/view_individual_ledger_details';
		$this->load->view('includes/template', $data);
	}

	function print_individual_ledger_account_details()
	{
		$data['title'] = "Report-Individual Ledger Details";

		$data['from_date'] = date('d-m-Y', strtotime($this->input->post('from_date')));;
		$data['to_date'] = date('d-m-Y', strtotime($this->input->post('to_date')));
		$data['account_id'] = $this->input->post('account_id');


		$this->load->model('Accounts_model');
		$data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();

		$data['ledger_transaction_records'] = $this->Accounts_model->get_ledger_report($data['account_id'], $data['from_date'], $data['to_date']);

		$this->load->view('Print/print_individual_ledger_account_details', $data);
	}


	function export_individual_ledger_account_details()
	{
		$data['title'] = "Report-Individual Ledger Details";

		$data['from_date'] = date('d-m-Y', strtotime($this->input->post('from_date')));;
		$data['to_date'] = date('d-m-Y', strtotime($this->input->post('to_date')));
		$data['account_id'] = $this->input->post('account_id');

		// $this->load->model('Setup_model');
		// $data['comapny_records'] = $this->Setup_model->get_company_master_list();

		$this->load->model('Accounts_model');
		$data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();

		$data['ledger_transaction_records'] = $this->Accounts_model->get_ledger_report($data['account_id'], $data['from_date'], $data['to_date']);

		$this->load->view('excel_reports/export_individual_ledger_account_details', $data);
	}
	function get_acc_details()
	{
		$this->load->model('Accounts_model');
		$data['acc_records'] = $this->Accounts_model->get_acc_details();
		$this->load->view('Ajax/get_acc_details', $data);
	}

	function update_transaction_details() // in use
	{
		$data['title'] = "Transactions Details";
		$voucher_id = $this->input->post('voucherid');
		$this->load->model('Accounts_model');
		$data['receipt_records'] = $this->Accounts_model->update_transaction_details();
		//$data['res']=$this->Accounts_model->view_account_transaction_details($voucher_id);

		$data['main_content'] = 'accounts/edit_receipt';
		redirect("Accounts/view_account_transaction_details/$voucher_id");
	}
	function view_balance_sheet11()
	{
		$data['title'] = "Report-Balance Sheet";
		$data['from'] = date('01-01-Y');
		$data['to'] = date('d-m-Y');

		$data['main_content'] = 'reports/account/balance_sheet_list';
		$this->load->view('includes/template', $data);
	}

	function view_balance_sheet()
	{
		$data['title'] = "Balance Sheet";

		$from = $this->input->post('from') ?: date('Y-01-01');
		$to   = $this->input->post('to') ?: date('Y-m-d');

		$data['from'] = date('Y-m-d', strtotime($from));
		$data['to']   = date('Y-m-d', strtotime($to));

		$this->load->model('Accounts_model');

		$tree = $this->Accounts_model->prepare_balance_sheet($to);

		$assets = [];
		$liabilities = [];

		foreach ($tree as $group) {

			if (strtolower(trim($group->group_name)) == 'assets') {
				$assets[] = $group; // ✅ FIX
			}

			if (strtolower(trim($group->group_name)) == 'liabilities') {
				$liabilities[] = $group; // ✅ FIX
			}
		}

		$profit = $this->Accounts_model->get_profit_loss($from, $to);

		foreach ($liabilities as &$group) {
			if (strtolower(trim($group->group_name)) == 'capital account') {
				$group->balance += $profit;
			}
		}

		$data['assets'] = $assets;
		$data['liabilities'] = $liabilities;

		$data['main_content'] = 'Reports/account/balance_sheet_list_new';
		$this->load->view('includes/template', $data);
	}
	function get_balance_sheet()
	{
		$data['title'] = "Report-Balance Sheet";

		$data['from'] = date('d-m-Y', strtotime($this->input->post('from') ?? ''));;
		$data['to'] = date('d-m-Y', strtotime($this->input->post('to') ?? ''));;

		$data['main_content'] = 'reports/account/balance_sheet_list';
		$this->load->view('includes/template', $data);
	}
	function view_profit_and_loss_old()
	{
		$data['title'] = "Report-Profit and Loss";

		$data['from'] = date('01-01-Y');
		$data['to'] = date('d-m-Y');
		$data['main_content'] = 'reports/account/view_profit_loss.php';
		$this->load->view('includes/template', $data);
	}
	function get_profit_and_loss()
	{
		$data['title'] = "Report-Profit and Loss";

		$data['from'] = $this->input->post('from') ?? date("d-m-Y", strtotime(date("Y-m-01")));
		$data['to'] = $this->input->post('to') ?? date("d-m-Y", strtotime(date("Y-m-d")));
		//$data['to']   = $this->input->post('to')   ?? date("Y-m-d");

		$data['main_content'] = 'reports/account/view_profit_loss.php';
		$this->load->view('includes/template', $data);
	}
	///////////////////////////////////////////////////////////////////////////////

	// function outstanding_report()
	// {
	//   $data['title'] = "Outstanding report";
	//   $data['from_date'] = date('01-01-Y');
	//   $data['to_date'] = date('31-12-Y');
	//   $data['account_id'] = "";
	//   $data['request_type'] = "";

	//   $this->load->model('Accounts_model');
	//   $data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();

	//   $data['records'] = "";

	//   $data['main_content'] = 'reports/account/outstanding_report';
	//   $this->load->view('includes/template', $data);
	// }

	// function search_outstanding_report()
	// {
	//   $data['title'] = "Outstanding report";
	//   $data['from_date'] = date('d-m-Y', strtotime($this->input->post('from_date')));   
	//   $data['to_date'] = date('d-m-Y', strtotime($this->input->post('to_date')));
	//   $data['account_id'] = $this->input->post('account_id');
	//   $data['request_type'] = $this->input->post('request_type');


	//   $this->load->model('Accounts_model');
	//   $data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();

	//   $data['records'] = $this->Accounts_model->get_outstanding_report($data['account_id'], $data['from_date'], $data['to_date']);

	//   $data['main_content'] = 'reports/account/outstanding_report';
	//   $this->load->view('includes/template', $data);
	// }

	// function printpayment() 
	// {
	//   $data['title'] = "Payment Print";
	//   $data['header'] = $this->input->post('header');


	// 	$data['voucher_code'] = $this->uri->segment(3) . '/' .$this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) ;
	//   $this->load->model('Setup_model');
	//   $data['logo_details'] = $this->Setup_model->get_company_master_list();

	//   $this->load->model('Accounts_model');
	//   $data['payment'] = $this->Accounts_model->get_payment_records($data['voucher_code']);
	//   //  echo '<pre>';print_r($data);exit;
	//   $this->load->view('Accounts/print/print_payment', $data);
	// }

	public function printpayment()
	{
		$data['title'] = "Payment Print";

		$data['account_id'] = $this->uri->segment(7);
		// $data['voucher_code'] = $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6);
		$data['voucher_code'] = implode('/', array_filter([
			$this->uri->segment(3),
			$this->uri->segment(4),
			$this->uri->segment(5)
		])) . '/';

		$data['voucher_code'] = rtrim($data['voucher_code'], '/');
		log_message("error", $data['voucher_code']);
		$this->load->model('Setup_model');
		$this->load->model('Accounts_model');

		// $data['logo_details'] = $this->Setup_model->get_company_master_list();
		$data['logo_details'] = "";
		// Fetch all voucher_transaction rows for this voucher_code
		$all_voucher_rows = $this->Accounts_model->get_payment_record($data['voucher_code']);
		log_message('error', 'Voucher Rows: ' . print_r($all_voucher_rows, true));
		// Separate header (credit) and details (debits)
		$header = null;
		$payment_details = [];

		foreach ($all_voucher_rows as $row) {
			if ($row->drcr_type === 'Cr') {
				$header = $row; // credit entry as header
			} else if ($row->drcr_type === 'Dr') {
				$payment_details[] = $row; // debit entries as invoice list
			}
		}

		$data['header'] = $header;
		$data['payment_details'] = $payment_details;
		$data['receipt_Creditors'] = $this->Accounts_model->get_account_name_by_id($data['account_id']);

		$this->load->view('Accounts/print/print_payment', $data);
	}
	///////////////////////////////////////////////////////////////////////////////////


	function outstanding_report()
	{

		$data['title'] = "Outstanding report";

		$data['from'] = $this->input->post('from') ?? date("d-m-Y", strtotime(date("Y-m-01")));
		$data['to'] = $this->input->post('to') ?? date("d-m-Y", strtotime(date("Y-m-d")));

		$data['request_type'] = "";
		$data['records'] = "";

		$data['main_content'] = 'reports/account/outstanding_report';
		$this->load->view('includes/template', $data);
	}

	public function search_outstanding_report()
	{
		$from_input = $this->input->post('from') ?: date("d-m-Y");
		$to_input   = $this->input->post('to')   ?: date("d-m-Y");

		$from_ts = strtotime(str_replace('/', '-', $from_input));
		$to_ts   = strtotime(str_replace('/', '-', $to_input));

		$from_date = $from_ts ? date("Y-m-d", $from_ts) : date("Y-m-d");
		$to_date   = $to_ts ? date("Y-m-d", $to_ts) : date("Y-m-d");

		$this->load->model('Accounts_model');

		// ✅ FIXED THIS LINE
		$request_type = $this->input->post('request_type') ?? '';
		$ledger_id = $this->input->post('ledger_id') ?? '';
		log_message('debug', 'Selected Ledger ID: ' . $ledger_id);

		if ($request_type && $ledger_id) {
			if ($request_type == 'Sundry Debtors') {
				$data['records'] = $this->Accounts_model->get_outstanding_report($from_date, $to_date, $ledger_id);
				$data['group_no'] = 30;
			} elseif ($request_type == 'Sundry Creditors') {
				$data['records'] = $this->Accounts_model->get_sundry_creditors_outstanding($from_date, $to_date, $ledger_id);
				$data['group_no'] = 29;
			} else {
				$data['records'] = [];
			}
		} elseif ($request_type) {
			if ($request_type == 'Sundry Debtors') {
				$data['records'] = $this->Accounts_model->get_outstanding_report($from_date, $to_date);
				$data['group_no'] = 30;
			} elseif ($request_type == 'Sundry Creditors') {
				$data['records'] = $this->Accounts_model->get_sundry_creditors_outstanding($from_date, $to_date);
				$data['group_no'] = 29;
			} else {
				$data['records'] = [];
			}
		} else {
			$data['records'] = [];
		}

		$data['title'] = "Outstanding Report";
		$data['from'] = $from_input;
		$data['to'] = $to_input;
		$data['request_type'] = $request_type;
		$data['ledger_id'] = $ledger_id; // Optional: pass to view to retain selection
		if ($request_type == 'Sundry Debtors') {
			$data['ledgers'] = $this->Accounts_model->get_ledgers_by_group(30);
		} elseif ($request_type == 'Sundry Creditors') {
			$data['ledgers'] = $this->Accounts_model->get_ledgers_by_group(29);
		}
		$data['main_content'] = 'reports/account/outstanding_report';
		$this->load->view('includes/template', $data);
	}


	public function search_outstanding_reportsssss()
	{
		$data['title'] = "Outstanding Report";

		// Get voucher date and format
		$voucher_date_raw = $this->input->post('voucher_date');
		$voucher_date = date('Y-m-d', strtotime($voucher_date_raw));
		$data['voucher_date'] = $voucher_date_raw;

		// Get request type (Debtors / Creditors)
		$request_type = $this->input->post('request_type');
		$data['request_type'] = $request_type;

		// Load model
		$this->load->model('Accounts_model');

		// Get report data
		$data['records'] = $this->Accounts_model->get_outstanding_report($voucher_date, $request_type);

		// Load view
		$data['main_content'] = 'reports/account/outstanding_report';
		$this->load->view('includes/template', $data);
	}

	public function search_outstanding_report111()
	{
		$data['title'] = "Outstanding Report";

		// Get and format voucher date
		$voucher_date_raw = $this->input->post('voucher_date');
		$voucher_date = date('Y-m-d', strtotime($voucher_date_raw));
		$data['voucher_date'] = date('d-m-Y', strtotime($voucher_date));  // For display

		// Get request type (Sundry Debtors / Sundry Creditors)
		$request_type = $this->input->post('request_type');
		$data['request_type'] = $request_type;

		// Load models
		$this->load->model('Accounts_model');

		// Get report data
		$data['records'] = $this->Accounts_model->get_outstanding_report($voucher_date, $request_type);

		// You don't need party records unless you're using them in your view
		$data['party_records'] = [];

		// Load view
		$data['main_content'] = 'reports/account/outstanding_report';
		$this->load->view('includes/template', $data);
	}


	function print_outstanding_report()
	{
		$data['title'] = "Outstanding reports";
		$from_date = ($ts = strtotime(str_replace(['/', '.'], '-', $this->input->post('from') ?: $this->input->get('from') ?: date('d-m-Y')))) ? date('Y-m-d', $ts) : date('Y-m-d');
		$to_date   = ($ts = strtotime(str_replace(['/', '.'], '-', $this->input->post('to')   ?: $this->input->get('to')   ?: date('d-m-Y')))) ? date('Y-m-d', $ts) : date('Y-m-d');
		$data['request_type']  = $this->input->post('request_type');



		// $this->load->model('Setup_model');
		// $data['comapny_records'] = $this->Setup_model->get_company_master_list();

		$this->load->model('Accounts_model');


		$request_type = $this->input->post('request_type') ?? '';
		$ledger_id = $this->input->post('ledger_id') ?? '';
		log_message('debug', 'Selected Ledger ID: ' . $ledger_id);

		if ($request_type && $ledger_id) {
			if ($request_type == 'Sundry Debtors') {
				$data['records'] = $this->Accounts_model->get_outstanding_report($from_date, $to_date, $ledger_id);
				$data['group_no'] = 30;
			} elseif ($request_type == 'Sundry Creditors') {
				$data['records'] = $this->Accounts_model->get_sundry_creditors_outstanding($from_date, $to_date, $ledger_id);
				$data['group_no'] = 29;
			} else {
				$data['records'] = [];
			}
		} elseif ($request_type) {
			if ($request_type == 'Sundry Debtors') {
				$data['records'] = $this->Accounts_model->get_outstanding_report($from_date, $to_date);
				$data['group_no'] = 30;
			} elseif ($request_type == 'Sundry Creditors') {
				$data['records'] = $this->Accounts_model->get_sundry_creditors_outstanding($from_date, $to_date);
				$data['group_no'] = 29;
			} else {
				$data['records'] = [];
			}
		} else {
			$data['records'] = [];
		}
		$this->load->view('Print/print_outstanding_report.php', $data);
	}


	function print_outstanding_reportssssss()
	{

		$data['title'] = "Outstanding report";
		$data['voucher_date'] = date('d-m-Y', strtotime($this->input->post('voucher_date')));


		$this->load->model('Setup_model');
		$data['comapny_records'] = $this->Setup_model->get_company_master_list();

		$this->load->model('Accounts_model');
		$data['records'] = $this->Accounts_model->get_outstanding_report($data['voucher_date']);

		// print_r($data['records']);

		$this->load->view('Print/print_outstanding_report.php', $data);
	}



	function export_outstanding_report_details()
	{
		$data['title'] = "Outstanding report";
		// $data['voucher_date'] = date('d-m-Y', strtotime($this->input->post('voucher_date')));

		$from_date = ($ts = strtotime(str_replace(['/', '.'], '-', $this->input->post('from') ?: $this->input->get('from') ?: date('d-m-Y')))) ? date('Y-m-d', $ts) : date('Y-m-d');
		$to_date   = ($ts = strtotime(str_replace(['/', '.'], '-', $this->input->post('to')   ?: $this->input->get('to')   ?: date('d-m-Y')))) ? date('Y-m-d', $ts) : date('Y-m-d');
		$data['request_type']  = $this->input->post('request_type');

		// $this->load->model('Setup_model');
		// $data['comapny_records'] = $this->Setup_model->get_company_master_list();

		$this->load->model('Accounts_model');

		if ($data['request_type'] == 'Sundry Creditors') {
			$data['records'] = $this->Accounts_model->get_sundry_creditors_outstanding($from_date, $to_date);
		} elseif ($data['request_type'] == 'Sundry Debtors') {
			$data['records'] = $this->Accounts_model->get_outstanding_report($from_date, $to_date);
			// echo "<pre>";  print_r($data['records']); 
		} else {
			$data['records'] = [];
		}

		$this->load->view('excel_reports/export_outstanding_report_details', $data);
	}



	function outstanding_report_by_individual_ledger()
	{

		$id = $this->uri->segment('3');
		$data['title'] = "Outstanding Report By Individual Ledger";

		$from_raw = $this->uri->segment(4);
		$to_raw   = $this->uri->segment(5);

		$from_obj = DateTime::createFromFormat('d-m-Y', $from_raw);
		$to_obj   = DateTime::createFromFormat('d-m-Y', $to_raw);

		$from_date = $from_obj ? $from_obj->format('Y-m-d') : date('Y-m-d');
		$to_date   = $to_obj ? $to_obj->format('Y-m-d') : date('Y-m-d');

		$this->load->model('Accounts_model');
		$data['records'] = $this->Accounts_model->get_outstanding_individual_ledger($id, $from_date, $to_date);
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['main_content'] = 'reports/account/outstanding_report_individual_ledger';
		$this->load->view('includes/template', $data);
	}




	/////////////////////// add_bank_reconciliation start  //////////////////////


	function add_bank_reconciliation()
	{
		$data['title'] = 'Bank Reconciliation';
		$data['account_id'] = $this->input->post('account_id');

		$this->load->model('Accounts_model');
		$data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();

		$data['main_content'] = 'Accounts/bank_reconciliation_add.php';
		$this->load->view('includes/template.php', $data);
	}


	function view_bank_reconciliation()
	{
		$data['title'] = 'Bank Reconciliation';
		$this->load->model('Accounts_model');
		$flag = $this->Accounts_model->add_bank_reconciliation_details();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Accounts/add_bank_reconciliation');
		}
	}


	function list_bank_reconciliation()
	{
		$data['title'] = 'Bank Reconciliation List';

		$this->load->model('Accounts_model');
		$data['records'] = $this->Accounts_model->get_bank_reconciliation_list();
		$data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();
		// log_message('error', 'Account Ledgers: ' . print_r($data['records'], true));

		$data['main_content'] = 'Accounts/bank_reconciliation_list.php';
		$this->load->view('includes/template.php', $data);
	}

	function edit_bank_reconciliation()
	{
		$data['title'] = "Bank Reconciliation Edit";
		$id = $this->uri->segment('3');

		$this->load->model('Accounts_model');
		$data['records'] = $this->Accounts_model->get_bank_reconciliation_by_id($id);

		// print_r($data['records']);
		$data['main_content'] = 'Accounts/bank_reconciliation_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_bank_reconciliation()
	{
		$data['title'] = "Bank Reconciliation Edit";
		$id = $this->input->post('reconciliation_id');
		$this->load->model('Accounts_model');
		$res = $this->Accounts_model->update_bank_reconciliation_data($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Accounts/list_bank_reconciliation');
		}
	}
	/////////////////////////////////////////////////////////////////////////////////


	public function group_ledger($group_no, $from, $to)
	{
		$this->load->model('Accounts_model');

		$data['group_name'] = $this->Accounts_model->get_group_name($group_no);
		$data['entries'] = $this->Accounts_model->get_group_ledger_entries($group_no, $from, $to);
		$data['from'] = $from;
		$data['to'] = $to;

		$this->load->view('accounts/group_ledger_view', $data);
	}
	////////////////

	public function drill_balance_sheetw()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Accounts_model');

		// Default date values
		$from_date = $this->input->post('from_date')
			? date('Y-m-d', strtotime($this->input->post('from_date')))
			: ($this->uri->segment(4) ? date('Y-m-d', strtotime($this->uri->segment(4))) : date('Y-m-01'));

		$to_date = $this->input->post('to_date')
			? date('Y-m-d', strtotime($this->input->post('to_date')))
			: ($this->uri->segment(5) ? date('Y-m-d', strtotime($this->uri->segment(5))) : date('Y-m-d'));

		$group_no = $this->input->post('group_no')
			? $this->input->post('group_no')
			: ($this->uri->segment(3) ? $this->uri->segment(3) : '');

		// Always load group list
		$data['groups'] = $this->db->select('group_no, group_name')
			->from('account_group')
			->order_by('group_name', 'ASC')
			->get()
			->result();


		$group_no = $this->input->post('group_no')
			? $this->input->post('group_no')
			: $group_no;

		// Set form inputs for repopulating view
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_no'] = $group_no;
		$action = $this->input->post('action');

		// If group selected and form submitted, fetch data
		$data['balances'] = [];
		if (!empty($group_no)) {
			$data['balances'] = $this->Accounts_model->get_balance_sheet_data($from_date, $to_date, $group_no);
		}

		$data['title'] = 'Report - Balance Sheet';
		$data['main_content'] = 'reports/account/balance_sheet_drill_view';


		$this->load->view('includes/template', $data);
	}
	// Separate print function
	public function balance_sheet_print()
	{
		$this->load->model('Setup_model');
		$this->load->model('Accounts_model');

		// Dates and group from POST (sent by print form)
		$from_date = date('Y-m-d', strtotime($this->input->post('from_date')));
		$to_date = date('Y-m-d', strtotime($this->input->post('to_date')));
		$group_no = $this->input->post('group_no');

		// Company info for header in print
		// $data['company_records'] = $this->Setup_model->get_company_master_list();

		// Pass parameters to model
		$data['balances'] = $this->Accounts_model->get_balance_sheet_data($from_date, $to_date, $group_no);

		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_no'] = $group_no;

		$data['title'] = "Print - Balance Sheet";
		$this->load->view('Print/print_balance_sheet_print', $data);  // Your print view file

		//  $this->load->view('Print/print_balance_sheet_print.php', $data);

	}
	public function balance_sheet_export()
	{
		$this->load->model('Accounts_model');

		$from_date = $this->input->post('from_date') ?? $this->input->get('from_date') ?? date('Y-m-01');
		$to_date = $this->input->post('to_date') ?? $this->input->get('to_date') ?? date('Y-m-d');
		$group_no = $this->input->post('group_no') ?? $this->input->get('group_no');

		//($from_date); exit;

		$balances = [];
		if (!empty($group_no)) {
			$balances = $this->Accounts_model->get_balance_sheet_data($from_date, $to_date, $group_no);
			//  print_r($balances);
		}

		// Export CSV (or you can do Excel with PhpSpreadsheet)
		$filename = "balance_sheet_{$group_no}_" . date('Ymd') . ".csv";

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');

		fputcsv($output, ['Group', 'Ledger', 'Opening Balance', 'Debit', 'Credit', 'Closing Balance']);

		$prev_group = '';
		foreach ($balances as $row) {
			if ($prev_group !== $row->group_name) {
				// Optional: write group name as a separate row or leave blank
				// fputcsv($output, [strtoupper($row->group_name)]);
				$prev_group = $row->group_name;
			}
			fputcsv($output, [
				'',
				$row->account_name,
				number_format($row->opening_balance, 2),
				number_format($row->debit, 2),
				number_format($row->credit, 2),
				number_format($row->closing_balance, 2)
			]);
		}
		fclose($output);
		exit;
	}

	public function balance_sheet_bsg()
	{
		$this->load->helper('form');
		$this->load->model('Accounts_model');

		// Get POST or default dates
		$from_date = $this->input->post('from_date') ? date('Y-m-d', strtotime($this->input->post('from_date'))) : date('Y-m-01');
		$to_date = $this->input->post('to_date') ? date('Y-m-d', strtotime($this->input->post('to_date'))) : date('Y-m-d');
		$group_no = $this->input->post('group_no');

		// Fetch groups for dropdown
		$data['groups'] = $this->db->select('group_no, group_name')
			->from('account_group')
			->order_by('group_name', 'ASC')
			->get()
			->result();

		// Pass form data back to view
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_no'] = $group_no;

		// Get balance sheet data only if group selected
		$data['balances'] = [];
		if ($this->input->method() === 'post' && !empty($group_no)) {
			$data['balances'] = $this->Accounts_model->get_balance_sheet_data($from_date, $to_date, $group_no);
		}
		log_message('error', 'Balance Sheet Data: ' . print_r($data['balances'], true));
		$data['title'] = "Report - Balance Sheet";
		$data['main_content'] = 'reports/account/balance_sheet_drill_view';  // Your view file
		$this->load->view('includes/template', $data);
	}

	private function validate_date($date)
	{
		return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
	}
	public function trial_balance($from_date = null, $to_date = null)
	{
		$this->load->model('Accounts_model');

		// Accept via POST or URL
		$from_date = $this->input->post('from_date') ?? $this->uri->segment(3);
		$to_date   = $this->input->post('to_date') ?? $this->uri->segment(4);

		if (empty($from_date)) $from_date = date('d-m-Y');
		if (empty($to_date))   $to_date = date('d-m-Y');

		// Convert to Y-m-d format for DB queries
		$from = DateTime::createFromFormat('d-m-Y', $from_date);
		$to   = DateTime::createFromFormat('d-m-Y', $to_date);

		if (!$from || !$to) {
			show_error("333Invalid date format.");
		}

		$from_sql = $from->format('Y-m-d');
		$to_sql = $to->format('Y-m-d');

		// Fetch data
		$data['accounts'] = $this->Accounts_model->get_account_trial_balance($from_sql, $to_sql);
		$data['group_totals'] = $this->Accounts_model->get_group_totals($from_sql, $to_sql);

		// For view
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['title'] = 'Trial Balance';
		$data['main_content'] = 'Accounts/trial_balance_view';

		$this->load->view('includes/template', $data);
	}



	public function trial_balance_export()
	{

		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		// $this->load->model('Setup_model');
		$this->load->model('Accounts_model');

		// $comapny_records = $this->Setup_model->get_company_master_list();
		$from = DateTime::createFromFormat('d-m-Y', $from_date)
			?: DateTime::createFromFormat('Y-m-d', $from_date);

		$to = DateTime::createFromFormat('d-m-Y', $to_date)
			?: DateTime::createFromFormat('Y-m-d', $to_date);

		if (!$from || !$to) {
			show_error("Invalid date format in export");
		}

		$from_sql = $from->format('Y-m-d');
		$to_sql   = $to->format('Y-m-d');

		// ✅ pass converted values
		$trial_balance_data = $this->Accounts_model->get_account_trial_balance($from_sql, $to_sql);

		// log_message('error', 'Trial Balance Data: ' . print_r($trial_balance_data, true));
		// Prepare the output headers for Excel
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Trial_Balance_" . date('Ymd') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		// Use the same HTML table output but stripped down to basic styles for Excel
		echo "<table border='1'>";
		echo "<tr><th colspan='4' style='font-size:16px'>Cool Runnings Garage Co LLC</th></tr>";
		echo "<tr><th colspan='4'>Trial Balance</th></tr>";
		echo "<tr><th colspan='4'>Period: " . date('j-M-y', strtotime($from_date)) . " to " . date('j-M-y', strtotime($to_date)) . "</th></tr>";
		echo "<tr>";
		echo "<th>Particulars</th><th></th><th>Debit</th><th>Credit</th>";
		echo "</tr>";

		$current_group = null;
		$group_debit = 0;
		$group_credit = 0;
		$grand_debit = 0;
		$grand_credit = 0;

		foreach ($trial_balance_data as $row) {
			if ($current_group !== null && $current_group !== $row['group_name']) {
				// group total row
				echo "<tr style='font-weight:bold; background:#ccc;'>";
				echo "<td>{$current_group} Total</td><td></td>";
				echo "<td align='right'>" . number_format($group_debit, 2) . "</td>";
				echo "<td align='right'>" . number_format($group_credit, 2) . "</td>";
				echo "</tr>";
				$group_debit = 0;
				$group_credit = 0;
			}
			if ($current_group !== $row['group_name']) {
				// new group header
				echo "<tr style='background:#eee; font-weight:bold;'><td colspan='4'>{$row['group_name']}</td></tr>";
				$current_group = $row['group_name'];
			}

			$group_debit += floatval($row['debit']);
			$group_credit += floatval($row['credit']);
			$grand_debit += floatval($row['debit']);
			$grand_credit += floatval($row['credit']);

			echo "<tr>";
			echo "<td>{$row['account_name']}</td><td></td>";
			echo "<td align='right'>" . (($row['debit'] != 0) ? number_format($row['debit'], 2) : '') . "</td>";
			echo "<td align='right'>" . (($row['credit'] != 0) ? number_format($row['credit'], 2) : '') . "</td>";
			echo "</tr>";
		}
		// last group total
		if ($current_group !== null) {
			echo "<tr style='font-weight:bold; background:#ccc;'>";
			echo "<td>{$current_group} Total</td><td></td>";
			echo "<td align='right'>" . number_format($group_debit, 2) . "</td>";
			echo "<td align='right'>" . number_format($group_credit, 2) . "</td>";
			echo "</tr>";
		}
		// grand total
		echo "<tr style='font-weight:bold; border-top:2px solid black;'>";
		echo "<td>Grand Total</td><td></td>";
		echo "<td align='right'>" . number_format($grand_debit, 2) . "</td>";
		echo "<td align='right'>" . number_format($grand_credit, 2) . "</td>";
		echo "</tr>";

		echo "</table>";
		exit;
	}


	public function trial_balance_print()
	{
		$this->load->model('Accounts_model');
		$this->load->model('Setup_model');

		// Get from GET or POST
		$from_date = $this->input->get('from_date') ?? $this->input->post('from_date');
		$to_date   = $this->input->get('to_date')   ?? $this->input->post('to_date');

		// Fallback to today if empty
		if (empty($from_date)) {
			$from_date = date('d-m-Y');
		}
		if (empty($to_date)) {
			$to_date = date('d-m-Y');
		}

		// Convert to DateTime objects from dd-mm-yyyy format
		$from = DateTime::createFromFormat('d-m-Y', $from_date);
		$to   = DateTime::createFromFormat('d-m-Y', $to_date);

		if (!$from) $from = new DateTime();
		if (!$to)   $to = new DateTime();

		// Format for DB queries
		$from_for_db = $from->format('Y-m-d');
		$to_for_db   = $to->format('Y-m-d');

		// Fetch data using correctly formatted dates
		$data['accounts'] = $this->Accounts_model->get_account_trial_balance($from_for_db, $to_for_db);
		$data['group_totals'] = $this->Accounts_model->get_group_totals($from_for_db, $to_for_db);

		// Pass original input dates for display
		$data['from_date'] = $from->format('d-m-Y');
		$data['to_date'] = $to->format('d-m-Y');

		// $data['comapny_records'] = $this->Setup_model->get_company_master_list();

		$this->load->view('Print/trial_balance_print_view', $data);
	}

	function add_expense()
	{
		// in use
		$data['title'] = "Expense/payment Entry";

		$data['ledger_id'] = $this->input->post('occupier_id');
		$d1 = date('Y-m-d');
		$data['opening_bal'] = '';

		$this->load->model('Accounts_model');
		$data['account_records'] = $this->Accounts_model->get_account_group_list();

		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts(); //all ledgers
		$data['receipt_Creditors'] = $this->Accounts_model->get_all_general_ledger_accounts(); //bank

		$data['main_content'] = 'Accounts/expense_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_expense_details()
	{ // in use
		$data['title'] = "Payment Entry";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_new_payment_data();
		if ($id != '') {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Accounts/view_payment_list');
		}
	}
	/***********************************    End CI Controller*************************************/

	function vat_report()
	{
		$this->load->model('Accounts_model');
		$data['title'] = "VAT report";

		// Set default date range: first day of current month to today
		$data['from_date'] = date('Y-m-01'); // First day of current month
		$data['to_date']   = date('Y-m-d');  // Today's date

		$data['main_content'] = 'reports/account/tax_report';
		$this->load->view('includes/template', $data);
	}
	public function tax_report_details()
	{
		$this->load->model('Accounts_model');
		$this->load->model('Invoice_model');
		$this->load->model('Purchase_Model');

		$from_date   = $this->input->post('from_date');
		$to_date     = $this->input->post('to_date');
		$report_type = $this->input->post('report_type');

		$from_date_db = date('Y-m-d', strtotime($from_date));
		$to_date_db   = date('Y-m-d', strtotime($to_date));

		if ($report_type == 'summary') {
			// $data['sales_records']    = $this->Invoice_model->get_tax_summary($from_date_db, $to_date_db);
			$data['sales_records']    = $this->Invoice_model->get_tax_summary_emirate($from_date_db, $to_date_db);
			$data['purchase_summary'] = $this->Purchase_Model->get_purchase_vat_summary($from_date_db, $to_date_db);
			$data['voucher_summary']  = $this->Accounts_model->get_voucher_vat_summary($from_date_db, $to_date_db);
			$view_file = 'reports/account/tax_report_summary';
		} else {
			$data['sales_records']    = $this->Invoice_model->get_tax_detailed($from_date_db, $to_date_db);
			$data['purchase_records'] = $this->Purchase_Model->get_purchase_vat_details($from_date_db, $to_date_db);
			$data['voucher_records']  = $this->Accounts_model->get_voucher_vat_details($from_date_db, $to_date_db);
			$view_file = 'reports/account/tax_report_detailed';
		}

		$data['from_date']   = $from_date;
		$data['to_date']     = $to_date;
		$data['report_type'] = $report_type;

		if ($this->input->is_ajax_request()) {
			// **Only return the report HTML for AJAX**
			$this->load->view($view_file, $data);
		} else {
			// Normal page load
			$data['title']        = "Tax Report";
			$data['main_content'] = 'reports/account/tax_report';
			$this->load->view('includes/template', $data);
		}
	}

	public function save_expense()
	{
		$this->load->model('Accounts_model');

		$expense_id = $this->Accounts_model->save_expense_master();

		if ($expense_id) {
			$this->Accounts_model->post_expense_voucher($expense_id);

			$this->session->set_flashdata('success', 'Expense Saved Successfully');
		} else {
			$this->session->set_flashdata('error', 'Expense Save Failed');
		}

		redirect('Accounts/expense_list');
	}

	public function expense_entry12()
	{
		// ⭐ Load Expense Ledgers (Direct Expense Group)
		$data['expense_ledgers'] = $this->db
			->select('account_id as ledger_id, account_name as ledger_name')
			->from('general_ledger')
			->where('group_no', 4)   // ⭐ change this ID
			->order_by('account_name', 'asc')
			->get()
			->result();

		// ⭐ Load Suppliers
		$data['suppliers'] = $this->db
			->select('supplier_id, supplier_name')
			->from('supplier_master')
			->order_by('supplier_name', 'asc')
			->get()
			->result();

		// ⭐ Load View
		$data['title']        = "Expense Details";
		$data['main_content'] = 'purchase/expense_entry';
		$this->load->view('includes/template', $data);
		// $this->load->view('purchase/expense_entry', $data);
	}
	public function expense_entry()
	{
		// ⭐ Load Expense Ledgers (Direct + Indirect Expense Groups)
		$this->db->select('account_id as ledger_id, account_name as ledger_name');
		$this->db->from('general_ledger');
		$this->db->where_not_in('group_no', [29, 30]);   // Exclude group_no 29 and 30
		$this->db->order_by('account_name', 'asc');
		$data['expense_ledgers'] = $this->db->get()->result();

		// ⭐ Load Bank Ledgers (Bank Accounts Group)
		// $this->db->select('account_id as ledger_id, account_name as ledger_name');
		// $this->db->from('general_ledger');
		// $this->db->where('group_no', 2);   // ⭐ Example: 2 = Bank Accounts
		// $this->db->order_by('account_name', 'asc');
		// $data['bank_ledgers'] = $this->db->get()->result();


		// ⭐ Load Cash Ledger (Single Row)
		$this->db->select('account_id as ledger_id, account_name as ledger_name');
		$this->db->from('general_ledger');
		$this->db->where('group_no', 21);   // ⭐ Example: 1 = Cash-in-hand
		$data['cash_ledger'] = $this->db->get()->row();


		// ⭐ Load Suppliers (For Credit Expense Future)
		$this->db->select('supplier_id, supplier_name');
		$this->db->from('supplier_master');
		$this->db->order_by('supplier_name', 'asc');
		$data['suppliers'] = $this->db->get()->result();


		// ⭐ Page Load
		$data['title']        = "Expense Entry";
		$data['main_content'] = 'purchase/expense_entry';

		$this->load->view('includes/template', $data);
	}


	public function expense_list()
	{
		$data['expenses'] = $this->db
			->select('e.*, g.account_name as ledger_name, s.supplier_name')
			->from('expense_master e')
			->join('general_ledger g', 'g.account_id = e.ledger_id', 'left')
			->join('supplier_master s', 's.supplier_id = e.supplier_id', 'left')
			->order_by('e.expense_id', 'desc')
			->get()
			->result();
		$data['title']        = "Expense List";
		$data['main_content'] = 'purchase/expense_list';
		$this->load->view('includes/template', $data);
	}
	public function delete_expense($expense_id)
	{
		$this->load->model('Accounts_model');


		$status = $this->Accounts_model->delete_expense_full($expense_id);

		if ($status)
			$this->session->set_flashdata('success', 'Expense Deleted Successfully');
		else
			$this->session->set_flashdata('error', 'Expense Delete Failed');

		redirect('Accounts/expense_list');
	}

	public function edit_expense($expense_id)
	{
		$data['expense'] = $this->db
			->where('expense_id', $expense_id)
			->get('expense_master')
			->row();


		$data['document'] = $this->db
			->where('expense_id', $expense_id)
			->get('expense_documents')
			->row();

		$this->db->select('account_id as ledger_id, account_name as ledger_name');
		$this->db->from('general_ledger');
		$this->db->where_not_in('group_no', [29, 30]);   // Exclude group_no 29 and 30
		$this->db->order_by('account_name', 'asc');
		$data['expense_ledgers'] = $this->db->get()->result();

		$this->db->select('account_id as ledger_id, account_name as ledger_name');
		$this->db->from('general_ledger');
		$this->db->where('group_no', 19);   // ⭐ Example: 2 = Bank Accounts
		$this->db->order_by('account_name', 'asc');
		$data['bank_ledgers'] = $this->db->get()->result();

		if (!$data['expense'])
			redirect('purchase/expense_list');

		$data['title']        = "Expense Edit";
		$data['main_content'] = 'purchase/expense_edit';
		$this->load->view('includes/template', $data);
	}

	public function update_expense($expense_id)
	{
		$this->load->model('Accounts_model');


		$status = $this->Accounts_model->update_expense_full($expense_id);

		if ($status)
			$this->session->set_flashdata('success', 'Expense Updated');
		else
			$this->session->set_flashdata('error', 'Update Failed');

		redirect('Accounts/expense_list');
	}

	public function print_expense($expense_id)
	{
		$data['header'] = $this->db->query("
		SELECT e.*,
		l.account_name,
		b.account_name  as bank_ledger_name,
		s.supplier_name
		FROM expense_master e
		LEFT JOIN general_ledger l ON l.account_id  = e.ledger_id
		LEFT JOIN general_ledger b ON b.account_id  = e.bank_ledger_id
		LEFT JOIN supplier_master s ON s.supplier_id = e.supplier_id
		WHERE e.expense_id = $expense_id
	")->row();

		$data['documents'] = $this->db
			->where('expense_id', $expense_id)
			->get('expense_documents')
			->result();

		$this->load->view('Accounts/print/print_expense', $data);
	}

	public function get_bank_ledgers()
	{
		$this->load->model('Accounts_model');

		$data = $this->Accounts_model->get_bank_ledgers();

		echo json_encode($data);
	}

	// ========================================

	public function test_pnl()
	{
		$this->load->helper('account_helper');

		$from = $this->input->get('from') ?? '2025-04-01';
		$to   = $this->input->get('to') ?? date('Y-m-d');

		$result = get_net_profit_loss($from, $to);

		// 🔹 Log result
		log_message('error', 'P&L Result: ' . print_r($result, true));

		// 🔹 Also show on screen (optional)
		echo "<pre>";
		print_r($result);
		echo "</pre>";
	}
	// ==============================================================
	public function update_customer_ledger_name($customer_id = null)
	{
		if (empty($customer_id)) {
			echo "Customer ID is required";
			return;
		}

		$this->load->model('Accounts_model');

		$new_name = 'Rajvi Parmar';

		$updated = $this->Accounts_model->update_customer_ledger_name($customer_id, $new_name);

		if ($updated) {
			echo "Ledger name updated successfully";
		} else {
			echo "Failed to update ledger name";
		}
	}

	public function repair_customer_ledgers()
	{
		$this->load->model('Accounts_model');

		$this->Accounts_model->repair_customer_ledgers();

		echo "All customer ledger issues fixed successfully.";
	}

	public function fix_supplier_opening_type()
	{
		$this->load->model('Accounts_model');

		$updated = $this->Accounts_model->fix_supplier_opening_type();

		echo $updated . " supplier ledger records updated to CR.";
	}

	// =========================== new payment entry 

	function add_payment_new()
	{
		// in use
		$data['title'] = "Payment Entry";

		$data['ledger_id'] = $this->input->post('occupier_id');
		$d1 = date('Y-m-d');
		$data['opening_bal'] = '';

		$this->load->model('Accounts_model');
		$data['account_records'] = $this->Accounts_model->get_account_group_list();

		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts(); //all ledgers
		$data['receipt_Creditors'] = $this->Accounts_model->get_all_general_ledger_accounts(); //bank

		$data['main_content'] = 'Accounts/payment_add_new.php';
		$this->load->view('includes/template', $data);
	}

	function add_payment_details_new()
	{ // in use
		$data['title'] = "Payment Entry";
		$this->load->model('Accounts_model');
		$id = $this->Accounts_model->add_new_payment();
		if ($id != '') {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('accounts/view_payment_list_new');
		}
	}

	function view_payment_list_new() // in use
	{
		$data['title'] = "Payment List";
		$data['header'] = $this->input->post('header');

		if ($this->uri->segment(3)) {
			$data['division_id'] = $this->uri->segment(3);
			$data['from'] = $this->uri->segment(4);
			$data['to'] = $this->uri->segment(5);
		} else if ($this->input->post('from')) {
			$data['from'] = $this->input->post('from');
			$data['to'] = $this->input->post('to');
		} else {
			$data['from'] = date('Y-m-d');
			$data['to'] = date('Y-m-d');
		}

		$this->load->model('Accounts_model');
		$data['receipt'] = $this->Accounts_model->get_payment_list($data['from'], $data['to']);

		$data['main_content'] = 'Accounts/payment_list_new.php';
		$this->load->view('includes/template', $data);
	}

	function edit_payment_new() // in use
	{
		$data['title'] = "Payment Edit";
		$this->load->model('accounts/debit_note');
		$data['receipt_records'] = $this->debit_note->receipt_records_pmc();

		$this->load->model('vehicle/vehicle_model');
		$data['driver_records'] = $this->vehicle_model->get_driver_records();
		$this->load->model('bags/Bags_master_model');
		$data['user_records'] = $this->Bags_master_model->get_user_details();

		$data['main_content'] = 'accounts/edit_receipt';
		$this->load->view('includes/template', $data);
	}

	function get_edit_payment_data_new() // in use
	{
		$data['title'] = "Payment edit";
		$data['voucher_id'] = $this->input->post('voucher_id');
		$data['occupier'] = $this->input->post('occupier');
		$data['division_id'] = $this->uri->segment(4);
		$data['from'] = $this->uri->segment(5);
		$data['to'] = $this->uri->segment(6);
		$this->load->model('accounts/debit_note');
		$data['receipt_records'] = $this->debit_note->receipt_records_pmc();

		$this->load->model('vehicle/vehicle_model');
		$data['driver_records'] = $this->vehicle_model->get_driver_records();
		$this->load->model('bags/Bags_master_model');
		$data['user_records'] = $this->Bags_master_model->get_user_details();

		$data['main_content'] = 'accounts/edit_receipt';
		$this->load->view('includes/template', $data);
	}

	function update_payment_data_new()
	{ // in use
		$data['title'] = "Payment ";
		$division_id = trim($this->input->post('division_id'));
		$from = trim($this->input->post('from'));
		$to = trim($this->input->post('to'));

		$this->load->model('accounts/debit_note');
		$id = $this->debit_note->update_receipt();
		if ($id) {
			$this->session->set_flashdata('success', 'Data Updated successfully');
		} else {
			$this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
		}
		redirect("accounts/view_receipt_list/" . $division_id . '/' . $from . '/' . $to);
	}

	function print_payment_new() // in use
	{
		$data['title'] = "Payment Print";
		$data['header'] = $this->input->post('header');
		$this->load->model('Setup_Model');
		$data['logo_details'] = $this->Setup_Model->get_company_master_list();

		$this->load->model('Accounts_model');
		$data['receipt'] = $this->Accounts_model->transport_receipt_records();
		$this->load->view('Accounts/print/print_receipt', $data);
	}

	//   ======================voucher code changing function ==========

	public function fix_voucher_code_format()
	{
		$data = $this->db
			->where('voucher_code IS NOT NULL', null, false)
			->get('voucher_transaction')
			->result();

		foreach ($data as $row) {

			$old = $row->voucher_code;
			$parts = explode('/', $old);

			// Default values
			$prefix = '';
			$year   = '';
			$number = '';

			// Detect format and map
			if (strpos($old, 'R/') === 0) {
				// R/26/00008
				$prefix = 'RV';
				$year   = $parts[1] ?? '';
				$number = $parts[2] ?? '';
			} elseif (strpos($old, 'COOL/P/') === 0) {
				// COOL/P/26/00016
				$prefix = 'PV';
				$year   = $parts[2] ?? '';
				$number = $parts[3] ?? '';
			} elseif (strpos($old, 'PVF/C/') === 0) {
				$prefix = 'CN';
				$year   = $parts[2] ?? '';
				$number = $parts[3] ?? '';
			} elseif (strpos($old, 'PVF/D/') === 0) {
				$prefix = 'DN';
				$year   = $parts[2] ?? '';
				$number = $parts[3] ?? '';
			} elseif (strpos($old, 'PVF/J/') === 0) {
				$prefix = 'JV';
				$year   = $parts[2] ?? '';
				$number = $parts[3] ?? '';
			} elseif (strpos($old, 'PVF/N/') === 0) {
				$prefix = 'CE';
				$year   = $parts[2] ?? '';
				$number = $parts[3] ?? '';
			}

			// Skip if not matched properly
			if ($prefix == '' || $year == '' || $number == '') {
				continue;
			}

			// Final format
			$new_code = $prefix . '/' . $year . '/' . str_pad($number, 5, '0', STR_PAD_LEFT);

			// Update DB
			$this->db->where('voucher_id', $row->voucher_id);
			$this->db->update('voucher_transaction', [
				'voucher_code' => $new_code
			]);
		}

		echo "Voucher codes updated successfully";
	}

	public function fix_all_codes11()
	{
		// Tables + column names
		$tables = [
			['table' => 'voucher_transaction', 'column' => 'voucher_code'],

			['table' => 'purchase_order_master', 'column' => 'po_code'],
			['table' => 'purchase_grn_master', 'column' => 'grn_code'],
		];

		foreach ($tables as $t) {

			$data = $this->db
				->where($t['column'] . ' IS NOT NULL', null, false)
				->get($t['table'])
				->result();

			foreach ($data as $row) {

				$old = $row->{$t['column']};
				$parts = explode('/', $old);

				$prefix = '';
				$year   = '';
				$number = '';

				// ✅ PURCHASE ORDER (COOL/POD)
				if (strpos($old, 'COOL/POD/') === 0) {
					$prefix = 'POD';   // your requirement
					$year   = $parts[2] ?? '';
					$number = $parts[3] ?? '';
				}

				// ✅ GRN (COOL/GRN)
				elseif (strpos($old, 'COOL/GRN/') === 0) {
					$prefix = 'GRN';  // keep GRN or change if needed
					$year   = $parts[2] ?? '';
					$number = $parts[3] ?? '';
				}

				// Skip if not matched
				if ($prefix == '' || $year == '' || $number == '') {
					continue;
				}

				// New code
				$new_code = $prefix . '/' . $year . '/' . str_pad($number, 4, '0', STR_PAD_LEFT);

				// Update
				$this->db->where(
					$t['column'] == 'voucher_code' ? 'voucher_id' : ($t['column'] == 'po_code' ? 'po_id' : 'grn_id'),
					$row->{$t['column'] == 'voucher_code' ? 'voucher_id' : ($t['column'] == 'po_code' ? 'po_id' : 'grn_id')}
				);

				$this->db->update($t['table'], [
					$t['column'] => $new_code
				]);
			}
		}

		echo "All codes updated successfully";
	}

	public function fix_grn_codes()
	{
		$rows = $this->db
			->where("grn_code LIKE 'GRN/GRN/%'")
			->get('purchase_grn_master')
			->result();

		foreach ($rows as $row) {

			$old = $row->grn_code;

			// Example: GRN/GRN/0001
			$parts = explode('/', $old);

			if (count($parts) != 3) {
				continue; // skip invalid format
			}

			$number = $parts[2];

			// ✅ Get year from GRN date
			$year = date('y', strtotime($row->grn_date));

			$new_code = 'GRN/' . $year . '/' . $number;

			// ✅ Check duplicate before update
			$exists = $this->db
				->where('grn_code', $new_code)
				->where('grn_id !=', $row->grn_id)
				->get('purchase_grn_master')
				->row();

			if ($exists) {
				// Skip to avoid duplicate crash
				continue;
			}

			// ✅ Update
			$this->db->where('grn_id', $row->grn_id);
			$this->db->update('purchase_grn_master', [
				'grn_code' => $new_code
			]);
		}

		echo "GRN codes updated safely";
	}

	public function fix_po_codes()
	{
		$rows = $this->db
			->where("po_code LIKE 'POD/POD/%'")
			->get('purchase_order_master')
			->result();

		foreach ($rows as $row) {

			$old = $row->po_code;

			// Example: POD/POD/0083
			$parts = explode('/', $old);

			if (count($parts) != 3) {
				continue; // skip invalid format
			}

			$number = $parts[2];

			// ✅ Get year from PO date
			$year = date('y', strtotime($row->po_date));

			$new_code = 'POD/' . $year . '/' . $number;

			// ✅ Prevent duplicate error
			$exists = $this->db
				->where('po_code', $new_code)
				->where('po_id !=', $row->po_id)
				->get('purchase_order_master')
				->row();

			if ($exists) {
				continue; // skip duplicates
			}

			// ✅ Update
			$this->db->where('po_id', $row->po_id);
			$this->db->update('purchase_order_master', [
				'po_code' => $new_code
			]);
		}

		echo "PO codes updated safely";
	}

	public function fix_voucher_codes_safe()
	{
		$rows = $this->db
			->get('voucher_transaction')
			->result();

		foreach ($rows as $row) {

			$update = [];

			/* =========================
           1. FIX VOUCHER CODE
        ========================= */

			if (!empty($row->voucher_code)) {

				// Example: V/26/0274
				if (strpos($row->voucher_code, 'V/') === 0) {

					$parts = explode('/', $row->voucher_code);

					if (count($parts) == 3) {

						$year   = $parts[1];
						$number = $parts[2];

						// Map voucher_type → prefix
						$prefix = '';

						if ($row->voucher_type == 'P') {
							$prefix = 'PV'; // Payment Voucher
						} elseif ($row->voucher_type == 'R') {
							$prefix = 'RV'; // Receipt
						} elseif ($row->voucher_type == 'J') {
							$prefix = 'JV'; // Journal
						} elseif ($row->voucher_type == 'C') {
							$prefix = 'CE'; // Contra
						}

						if ($prefix != '') {
							$new_voucher_code = $prefix . '/' . $year . '/' . $number;

							// Avoid duplicate error
							$exists = $this->db
								->where('voucher_code', $new_voucher_code)
								->where('voucher_id !=', $row->voucher_id)
								->get('voucher_transaction')
								->row();

							if (!$exists) {
								$update['voucher_code'] = $new_voucher_code;
							}
						}
					}
				}
			}

			/* =========================
           2. FIX INVOICE CODE
        ========================= */

			if (!empty($row->invoice_code)) {

				// Example: INV/GRN/0004
				if (strpos($row->invoice_code, 'INV/GRN/') === 0) {

					$parts = explode('/', $row->invoice_code);

					if (count($parts) == 3) {

						$number = $parts[2];

						// Use voucher date year
						$year = date('y', strtotime($row->voucher_date));

						$new_invoice_code = 'GRN/' . $year . '/' . $number;

						// Optional duplicate check
						$exists = $this->db
							->where('invoice_code', $new_invoice_code)
							->where('voucher_id !=', $row->voucher_id)
							->get('voucher_transaction')
							->row();

						if (!$exists) {
							$update['invoice_code'] = $new_invoice_code;
						}
					}
				}
			}

			/* =========================
           UPDATE ONLY IF NEEDED
        ========================= */

			if (!empty($update)) {
				$this->db->where('voucher_id', $row->voucher_id);
				$this->db->update('voucher_transaction', $update);
			}
		}

		echo "Voucher codes fixed safely";
	}

	// ===================== receipt voucher new function =====================


	public function ajax_get_quotation_list()
	{
		$customer_id = $this->input->post('customer_id');

		if (empty($customer_id)) {
			echo '<option value="">No Customer Selected12</option>';
			return;
		}

		$this->load->model('Accounts_model');
		$data['res'] = $this->Accounts_model->ajax_get_quotation_list($customer_id);

		if (empty($data['res'])) {
			echo '<option value="">No Quotations Found</option>';
		} else {
			$this->load->view('ajax/quotation_list', $data);
		}
	}
	// ========================================

	public function create_all_supplier_gl()
	{
		$suppliers = $this->db->get('supplier_master')->result();

		foreach ($suppliers as $sup) {

			$code = !empty($sup->supplier_code)
				? $sup->supplier_code
				: 'SUP' . str_pad($sup->supplier_id, 4, '0', STR_PAD_LEFT);

			$account_name = $sup->supplier_name . ' - Supplier Advance (' . $code . ')';

			$data = [
				'account_name'     => $account_name,
				'group_no'         => 24,
				'supplier_id'      => $sup->supplier_id,
				'opening_balance'  => 0.00,
				'opening_bal_type' => 'Dr',
				'isdeleteable'     => 'N',
				'date'             => date('Y-m-d H:i:s')
			];

			// ✅ smarter check
			$existing = $this->db
				->where('supplier_id', $sup->supplier_id)
				->like('account_name', 'Supplier Advance')
				->get('general_ledger')
				->row();

			if ($existing) {

				// don't overwrite balances if already used
				unset($data['opening_balance']);
				unset($data['opening_bal_type']);

				$this->db->where('account_id', $existing->account_id)
					->update('general_ledger', $data);
			} else {

				// 🔥 extra safety: avoid duplicate by name
				$nameExists = $this->db
					->where('account_name', $account_name)
					->get('general_ledger')
					->row();

				if (!$nameExists) {
					$this->db->insert('general_ledger', $data);
				}
			}
		}

		return true;
	}

	public function view_profit_and_loss()
	{
		$data['title'] = "Report-Profit and Loss";
		$this->load->model('Accounts_model');

		// Default dates (1st day of month → today)
		if (!$this->input->post()) {
			$from = date('Y-m-01');
			$to   = date('Y-m-d');
		} else {
			$from = $this->input->post('from');
			$to   = $this->input->post('to');
		}

		// If still empty (safety)
		if (empty($from)) {
			$from = date('Y-m-01');
		}

		if (empty($to)) {
			$to = date('Y-m-d');
		}

		// Assign to view
		$data['from'] = $from;
		$data['to']   = $to;

		// Get data
		$data['income']  = $this->Accounts_model->get_income($from, $to);
		$data['expense'] = $this->Accounts_model->get_expense($from, $to);

		// Fix totals (important)
		$data['total_income'] = array_sum(array_column($data['income'], 'total'));
		$data['total_expense'] = array_sum(array_map(function ($row) {
			return abs($row->total);
		}, $data['expense']));

		// Net calculation
		$net = $data['total_income'] - $data['total_expense'];

		// Store result properly
		$data['net_profit'] = $net;
		$data['net_label']  = ($net >= 0) ? 'Net Profit' : 'Net Loss';

		// Load view
		$data['main_content'] = 'reports/account/view_profit_loss.php';
		$this->load->view('includes/template', $data);
	}

	public function drilldown()
	{
		$data['title'] = "";
		$this->load->model('Accounts_model');
		$account_id = $this->input->get('account_id');
		$from       = $this->input->get('from');
		$to         = $this->input->get('to');

		// Safety defaults
		if (empty($from)) $from = date('Y-m-01');
		if (empty($to))   $to   = date('Y-m-d');

		$data['from'] = $from;
		$data['to']   = $to;

		$data['ledgers'] = $this->Accounts_model->get_ledger_transactions($account_id, $from, $to);

		$data['main_content'] = 'reports/account/drilldown';
		$this->load->view('includes/template', $data);
	}

	function view_balance_sheet_new()
	{
		$data['title'] = "Balance Sheet";

		$from = $this->input->post('from') ?: date('Y-01-01');
		$to   = $this->input->post('to') ?: date('Y-m-d');

		$data['from'] = date('Y-m-d', strtotime($from));
		$data['to']   = date('Y-m-d', strtotime($to));

		$this->load->model('Accounts_model');

		$tree = $this->Accounts_model->prepare_balance_sheet($to);

		$assets = [];
		$liabilities = [];

		foreach ($tree as $group) {

			if (strtolower(trim($group->group_name)) == 'assets') {
				$assets[] = $group; // ✅ FIX
			}

			if (strtolower(trim($group->group_name)) == 'liabilities') {
				$liabilities[] = $group; // ✅ FIX
			}
		}

		$profit = $this->Accounts_model->get_profit_loss($from, $to);

		foreach ($liabilities as &$group) {
			if (strtolower(trim($group->group_name)) == 'capital account') {
				$group->balance += $profit;
			}
		}

		$data['assets'] = $assets;
		$data['liabilities'] = $liabilities;

		$data['main_content'] = 'Reports/account/balance_sheet_list_new';
		$this->load->view('includes/template', $data);
	}

	public function drilldown_balance_sheet()
	{
		$data['title'] = "";

		$account_id = $this->input->get('account_id');
		$from       = $this->input->get('from');
		$to         = $this->input->get('to');

		// Safety defaults
		if (empty($from)) $from = date('Y-m-01');
		if (empty($to))   $to   = date('Y-m-d');

		$data['from'] = $from;
		$data['to']   = $to;

		$data['ledgers'] = $this->Accounts_model->get_ledger_transactions($account_id, $from, $to);


		$this->load->view('Reports/account/drilldown_table', $data);
	}


	// ===================================monthly salary ======================

	 function payable_salary()
  {
    $data['title'] = "Monthly Salary List";
    $data['from'] = date('M-Y');
    $this->load->model('Hr_model');
    $data['records'] = $this->Hr_model->get_emp_monthly_salary_list($data['from']);
// 	echo "<pre>";
// print_r($data['records']);
// echo "</pre>";
// exit;
    $data['salary_month'] = !empty($this->input->post('from')) 
                        ? date('Y-m', strtotime($this->input->post('from') . '-01')) 
                        : date('Y-m');  // default to current month

    $this->load->model('Accounts_model');
    $data['sundry_detors_records'] = $this->Accounts_model->get_all_general_ledger_accounts();
    $gno = "19,21";
    $data['credit_records'] = $this->Accounts_model->get_bank_cash_ledgers($gno);

    $data['main_content'] = 'Accounts/emp_monthly_salary_list.php';
    $this->load->view('includes/template', $data);
  }

    function add_employee_payment_details()
  {
    $data['title'] = "Monthly Salary List";
    $this->load->model('Accounts_model');
    $id = $this->Accounts_model->add_employee_payment_details();
    if ($id != '') {
      $this->session->set_flashdata('success', 'Record Successfully Saved');
      redirect('accounts/emp_monthly_salary_list');
    }
  }
}
