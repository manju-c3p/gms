<?php



class Accounts extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('Accounts_model');
	}

	function account_group_list()
	{
		$data['title'] = 'Account Group';
		$this->load->model('Accounts_model');
		$data['account_records'] = $this->Accounts_model->get_account_group_list();
		$data['main_content'] = 'accounts/accounts_group.php';
		$this->load->view('includes/template', $data);
	}

	function view_account_group_form()
	{
		$data['title'] = 'Account Group';
		$this->load->model('Accounts_model');
		$data['parent_records'] = $this->Accounts_model->get_account_group_parent();
		$data['section_records'] = $this->Accounts_model->get_account_section();
		$data['main_content'] = 'accounts/add_accounts_group.php';
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
	

	// ========================= general ledger =====================

	function list_general_ledger_account_form()
	{
		$data['title'] = 'General Ledger Account';
		$this->load->model('Accounts_model');
		$data['ledger_records'] = $this->Accounts_model->get_general_ledger_list();
		$data['main_content'] = 'accounts/general_ledger.php';
		$this->load->view('includes/template', $data);
	}

	function view_general_ledger_account_form()
	{
		$data['title'] = 'General Ledger Account';
		$this->load->model('Accounts_model');
		$data['account_records'] = $this->Accounts_model->get_account_group();
		$data['customer_records'] = $this->Accounts_model->get_customer_record();
		// $data['supplier_records'] = $this->Accounts_model->get_supplier_record();
		$data['main_content'] = 'accounts/add_general_ledger.php';
		$this->load->view('includes/template', $data);
	}
}
