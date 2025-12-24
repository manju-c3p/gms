<?php
class InsuranceCompany extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('InsuranceCompany_model');
	}

	public function list()
	{
		$data['companies'] = $this->InsuranceCompany_model->get_all();
		$data['title'] = "Insurance Company List";
		$data['main_content'] = 'insurance/company_list';
		$this->load->view('includes/template', $data);
	}

	public function add()
	{

		$data['title'] = "Add Insurance Company";
		$data['main_content'] = 'insurance/company_add_form';
		$this->load->view('includes/template', $data);
		
	}

	public function save()
	{
		$data = [
			'company_name' => $this->input->post('company_name'),
			'contact_no'   => $this->input->post('contact_no'),
			'email'        => $this->input->post('email'),
			'address'      => $this->input->post('address')
		];

		$this->InsuranceCompany_model->add_company($data);

		$this->session->set_flashdata('success', 'Insurance company added!');
		redirect('insurancecompany/list');
	}

	public function edit($company_id)
	{
		$data['company'] = $this->InsuranceCompany_model->get($company_id);
		$data['title'] = "Edit Insurance Company Details";
		$data['main_content'] = 'insurance/company_edit_form';
		$this->load->view('includes/template', $data);
		
	}

	public function update()
	{
		$company_id = $this->input->post('company_id');

		$data = [
			'company_name' => $this->input->post('company_name'),
			'contact_no'   => $this->input->post('contact_no'),
			'email'        => $this->input->post('email'),
			'address'      => $this->input->post('address')
		];

		$this->InsuranceCompany_model->update_company($company_id, $data);

		$this->session->set_flashdata('success', 'Insurance company updated!');
		redirect('insurancecompany/list');
	}

	public function delete($company_id)
	{
		$this->InsuranceCompany_model->delete_company($company_id);
		$this->session->set_flashdata('success', 'Company deleted!');
		redirect('insurancecompany/list');
	}
}
