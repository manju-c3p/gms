<?php
class Policy extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Policy_model');
		$this->load->model('Vehicle_model');
		$this->load->model('InsuranceCompany_model');
	}

	// List all policies for one vehicle
	public function list1233($vehicle_id)
	{
		$data['vehicle'] = $this->Vehicle_model->get_vehicle($vehicle_id);
		$data['policies'] = $this->Policy_model->get_policies_by_vehicle($vehicle_id);

		$data['title'] = "Insurance Policy list";
		$data['main_content'] = 'insurance/policy_list';
		$this->load->view('includes/template', $data);

		// $this->load->view('insurance/policy_list', $data);
	}
	public function list()
	{
		// Get all vehicles
		$vehicles = $this->Vehicle_model->get_all_vehicles();

		// For each vehicle, fetch its policies
		foreach ($vehicles as $v) {
			$v->policies = $this->Policy_model->get_policies_by_vehicle($v->vehicle_id);
		}

		$data['vehicles'] = $vehicles;

		$data['title'] = "Insurance Policy list";
		$data['main_content'] = 'insurance/policy_list';
		$this->load->view('includes/template', $data);
	}





	// Add policy form
	public function add($vehicle_id)
	{
		$data['vehicle'] = $this->Vehicle_model->get_vehicle($vehicle_id);
		$data['companies'] = $this->InsuranceCompany_model->get_all();

		$data['title'] = "Add Insurance Policy";
		$data['main_content'] = 'insurance/policy_add_form';
		$this->load->view('includes/template', $data);
	}

	// Save policy
	public function save()
	{
		$vehicle_id = $this->input->post('vehicle_id');

		// Upload document
		$fileName = null;
		if (!empty($_FILES['policy_document']['name'])) {
			$config['upload_path'] = './uploads/policies/';
			$config['allowed_types'] = 'pdf|jpg|jpeg|png';
			$config['file_name'] = time() . '_policy';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('policy_document')) {
				$fileName = $this->upload->data('file_name');
			}
		}

		$data = [
			'vehicle_id'       => $vehicle_id,
			'company_id'       => $this->input->post('company_id'),
			'policy_number'    => $this->input->post('policy_number'),
			'start_date'       => $this->input->post('start_date'),
			'expiry_date'      => $this->input->post('expiry_date'),
			'premium_amount'   => $this->input->post('premium_amount'),
			'coverage_details' => $this->input->post('coverage_details'),
			'policy_document'  => $fileName,
			'notes'            => $this->input->post('notes')
		];

		$this->Policy_model->add_policy($data);

		$this->session->set_flashdata('success', 'Policy added successfully!');
		redirect('policy/list/' . $vehicle_id);
	}

	// Edit form
	public function edit($policy_id)
	{
		$data['policy']    = $this->Policy_model->get_policy($policy_id);
		$data['companies'] = $this->InsuranceCompany_model->get_all();

		$data['title'] = "Edit Insurance Policy";
		$data['main_content'] = 'insurance/policy_edit_form';
		$this->load->view('includes/template', $data);
	}

	// Update policy
	public function update()
	{
		$policy_id = $this->input->post('policy_id');
		$vehicle_id = $this->input->post('vehicle_id');

		// Handle new file upload
		$fileName = $this->input->post('existing_file');

		if (!empty($_FILES['policy_document']['name'])) {
			$config['upload_path'] = './uploads/policies/';
			$config['allowed_types'] = 'pdf|jpg|jpeg|png';
			$config['file_name'] = time() . '_policy';

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('policy_document')) {
				$fileName = $this->upload->data('file_name');
			}
		}

		$data = [
			'company_id'       => $this->input->post('company_id'),
			'policy_number'    => $this->input->post('policy_number'),
			'start_date'       => $this->input->post('start_date'),
			'expiry_date'      => $this->input->post('expiry_date'),
			'premium_amount'   => $this->input->post('premium_amount'),
			'coverage_details' => $this->input->post('coverage_details'),
			'policy_document'  => $fileName,
			'notes'            => $this->input->post('notes')
		];

		$this->Policy_model->update_policy($policy_id, $data);

		$this->session->set_flashdata('success', 'Policy updated!');
		redirect('policy/list/' . $vehicle_id);
	}

	// Delete policy
	public function delete($policy_id, $vehicle_id)
	{
		$this->Policy_model->delete_policy($policy_id);

		$this->session->set_flashdata('success', 'Policy deleted!');
		redirect('policy/list/' . $vehicle_id);
	}
}
