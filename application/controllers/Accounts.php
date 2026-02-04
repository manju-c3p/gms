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
    redirect('accounts/list_contra_entry');
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
    redirect('accounts/view_journal_list');
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
    $data['records'] = $this->Accounts_model->get_journal_records($data['from'], $data['to']);
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
    redirect('accounts/view_debit_note_list');
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
      redirect('accounts/view_debit_note_list');
    } else {
      $this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
      redirect('accounts/get_edit_debit_note');
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

  function add_credit_note()
  { //in use
    $data['title'] = "Credit Note";
    $this->load->model('Accounts_model');
    $id = $this->Accounts_model->add_credit_note();
    if ($id != '')
      $this->session->set_flashdata('success', 'Record Successfully Saved');
    redirect('accounts/view_credit_note_list');
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
      redirect('accounts/view_credit_note_list');
    } else {
      $this->session->set_flashdata('error', 'Record Not Updated !! Duplicate Entry ');
      redirect('accounts/get_edit_credit_note');
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
    // echo "<pre>sss"; print_r($_POST); exit;
    $this->load->model('Accounts_model');
    $id = $this->Accounts_model->add_new_receipt(); // this function uses $_POST data internally

    if ($id != '') {
      $this->session->set_flashdata('success', 'Record Successfully Saved');
      redirect('accounts/view_receipt_list');
    } else {
      $this->session->set_flashdata('error', 'Failed to save receipt');
      redirect('accounts/add_receipt');
    }
  }


  // function view_receipt_list() // in use
  // {
  //   $data['title'] = "Receipt List";
  //   $data['header'] = $this->input->post('header');

  //   if ($this->uri->segment(3)) {
  //     $data['division_id'] = $this->uri->segment(3);
  //     $data['from'] = $this->uri->segment(4);
  //     $data['to'] = $this->uri->segment(5);
  //   } else if ($this->input->post('from')) {
  //     $data['from'] = $this->input->post('from');
  //     $data['to'] = $this->input->post('to');
  //   } else {
  //     $data['from'] = date('Y-m-d');
  //     $data['to'] = date('Y-m-d');
  //   }

  //   $this->load->model('Accounts_model');
  //   $data['receipt'] = $this->Accounts_model->get_receipt_list($data['from'], $data['to']);

  //   $data['main_content'] = 'Accounts/receipt_list.php';
  //   $this->load->view('includes/template', $data);
  // }
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
    $voucher_code = $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6);

    $this->load->model('Setup_model');
    $data['logo_details'] = $this->Setup_model->get_company_master_list();

    $this->load->model('Accounts_model');
    $data['header'] = $this->Accounts_model->get_receipt_header($voucher_code);
    //  print_r(    $data['header']); exit;
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
    $data['suppliers'] = $this->Supplier_model->get_supplier_list(); //customer

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
      redirect('accounts/view_payment_list');
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

    $data['account_id'] = "";

    $this->load->model('Accounts_model');
    $data['account_ledgers'] = $this->Accounts_model->get_all_general_ledger_accounts();

    $data['ledger_transaction_records'] = "";
    // echo "<pre>"; print_r( $data); exit;
    $data['main_content'] = 'Reports/account/view_individual_ledger_details';
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
    $data['main_content'] = 'Reports/account/view_individual_ledger_details';
    $this->load->view('includes/template', $data);
  }

  function print_individual_ledger_account_details()
  {
    $data['title'] = "Report-Individual Ledger Details";

    $data['from_date'] = date('d-m-Y', strtotime($this->input->post('from_date')));;
    $data['to_date'] = date('d-m-Y', strtotime($this->input->post('to_date')));
    $data['account_id'] = $this->input->post('account_id');

    $this->load->model('Setup_model');
    $data['comapny_records'] = $this->Setup_model->get_company_master_list();

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

    $this->load->model('Setup_model');
    $data['comapny_records'] = $this->Setup_model->get_company_master_list();

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
  function view_balance_sheet()
  {
    $data['title'] = "Report-Balance Sheet";
    $data['from'] = date('01-01-Y');
    $data['to'] = date('d-m-Y');

    $data['main_content'] = 'Reports/account/balance_sheet_list';
    $this->load->view('includes/template', $data);
  }
  function get_balance_sheet()
  {
    $data['title'] = "Report-Balance Sheet";

    $data['from'] = date('d-m-Y', strtotime($this->input->post('from') ?? ''));;
    $data['to'] = date('d-m-Y', strtotime($this->input->post('to') ?? ''));;

    $data['main_content'] = 'Reports/account/balance_sheet_list';
    $this->load->view('includes/template', $data);
  }
  function view_profit_and_loss()
  {
    $data['title'] = "Report-Profit and Loss";

    $data['from'] = date('01-01-Y');
    $data['to'] = date('d-m-Y');
    $data['main_content'] = 'Reports/account/view_profit_loss.php';
    $this->load->view('includes/template', $data);
  }
  function get_profit_and_loss()
  {
    $data['title'] = "Report-Profit and Loss";

    $data['from'] = $this->input->post('from') ?? date("d-m-Y", strtotime(date("Y-m-01")));
    $data['to'] = $this->input->post('to') ?? date("d-m-Y", strtotime(date("Y-m-d")));
    //$data['to']   = $this->input->post('to')   ?? date("Y-m-d");

    $data['main_content'] = 'Reports/account/view_profit_loss.php';
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

  //   $data['main_content'] = 'Reports/account/outstanding_report';
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

  //   $data['main_content'] = 'Reports/account/outstanding_report';
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
    $data['voucher_code'] = $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6);

    $this->load->model('Setup_model');
    $this->load->model('Accounts_model');

    $data['logo_details'] = $this->Setup_model->get_company_master_list();

    // Fetch all voucher_transaction rows for this voucher_code
    $all_voucher_rows = $this->Accounts_model->get_payment_record($data['voucher_code']);

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

    $data['main_content'] = 'Reports/account/outstanding_report';
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
    $data['main_content'] = 'Reports/account/outstanding_report';
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
    $data['main_content'] = 'Reports/account/outstanding_report';
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
    $data['main_content'] = 'Reports/account/outstanding_report';
    $this->load->view('includes/template', $data);
  }


  function print_outstanding_report()
  {
    $data['title'] = "Outstanding reports";
    $from_date = ($ts = strtotime(str_replace(['/', '.'], '-', $this->input->post('from') ?: $this->input->get('from') ?: date('d-m-Y')))) ? date('Y-m-d', $ts) : date('Y-m-d');
    $to_date   = ($ts = strtotime(str_replace(['/', '.'], '-', $this->input->post('to')   ?: $this->input->get('to')   ?: date('d-m-Y')))) ? date('Y-m-d', $ts) : date('Y-m-d');
    $data['request_type']  = $this->input->post('request_type');



    $this->load->model('Setup_model');
    $data['comapny_records'] = $this->Setup_model->get_company_master_list();

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

    $this->load->model('Setup_model');
    $data['comapny_records'] = $this->Setup_model->get_company_master_list();

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
    $data['main_content'] = 'Reports/account/outstanding_report_individual_ledger';
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
    $data['main_content'] = 'Reports/account/balance_sheet_drill_view';


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
    $data['company_records'] = $this->Setup_model->get_company_master_list();

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

    $data['title'] = "Report - Balance Sheet";
    $data['main_content'] = 'Reports/account/balance_sheet_drill_view';  // Your view file
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
      show_error("Invalid date format.");
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
    $this->load->model('Setup_model');
    $this->load->model('Accounts_model');
    $comapny_records = $this->Setup_model->get_company_master_list();
    $trial_balance_data = $this->Accounts_model->get_account_trial_balance($from_date, $to_date);

    // Prepare the output headers for Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Trial_Balance_" . date('Ymd') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Use the same HTML table output but stripped down to basic styles for Excel
    echo "<table border='1'>";
    echo "<tr><th colspan='4' style='font-size:16px'>{$comapny_records[0]->company_name}</th></tr>";
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

    $data['comapny_records'] = $this->Setup_model->get_company_master_list();

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
      redirect('accounts/view_payment_list');
    }
  }
  /***********************************    End CI Controller*************************************/
}
