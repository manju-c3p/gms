<?php
class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		
	}

	function company_details()
	{
		$data['title'] = 'Company Master';

		$data['company_details'] = $this->Admin_model->get_company_master_list();
		$data['bank_details'] = $this->Admin_model->get_company_bank_list();
		$data['stamp_details'] = $this->Admin_model->get_company_stamp_list();

		$data['main_content'] = 'company/company.php';
		$this->load->view('includes/template.php', $data);
	}

	function add_company_records()
	{
		$data['title'] = 'Company Master';
	
		$insert_id = $this->Admin_model->update_company_record_by_id();
		if ($insert_id == 1) {
			$this->session->set_flashdata('success', 'Data Saved Successfully..');
			redirect('Admin/company_details');
		}
	}

}
