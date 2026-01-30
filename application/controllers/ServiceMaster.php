<?php

class ServiceMaster extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Service_model');
	}

	// ✅ List Page
	public function index()
	{
		$data['services'] = $this->Service_model->get_all_services();

		$data['title'] = "services";

		$data['main_content'] = "service_master/index";
		$this->load->view("includes/template", $data);
	}

	// ✅ Add Service
	public function store()
	{
		$data = [
			'service_name'   => $this->input->post('service_name'),
			'service_type'   => $this->input->post('service_type'),
			'estimated_cost' => $this->input->post('estimated_cost'),
			'estimated_time' => $this->input->post('estimated_time'),
			'status'         => $this->input->post('status')
		];

		$this->Service_model->insert_service($data);
		redirect('ServiceMaster');
	}

	// ✅ Edit Page
	public function edit($id)
	{
		$data['service'] = $this->Service_model->get_service($id);

		$data['title'] = "services";

		$data['main_content'] = "service_master/edit";
		$this->load->view("includes/template", $data);
	}

	// ✅ Update Service
	public function update($id)
	{
		$data = [
			'service_name'   => $this->input->post('service_name'),
			'service_type'   => $this->input->post('service_type'),
			'estimated_cost' => $this->input->post('estimated_cost'),
			'estimated_time' => $this->input->post('estimated_time'),
			'status'         => $this->input->post('status')
		];

		$this->Service_model->update_service($id, $data);
		redirect('ServiceMaster');
	}

	// ✅ Enable / Disable
	public function toggle_status($id)
	{
		$current = $this->Service_model->get_service($id);
		$new_status = ($current->status == 'Active') ? 'Inactive' : 'Active';

		$this->Service_model->change_status($id, $new_status);
		redirect('ServiceMaster');
	}

	public function save_ajax()
	{
		$service_name = trim($this->input->post('service_name'));

		if ($service_name == '') {
			echo json_encode([
				'status' => 'error',
				'message' => 'Service name required'
			]);
			return;
		}

		// Optional: prevent duplicate services
		$exists = $this->db
			->where('service_name', $service_name)
			->where('status', 'Active')
			->get('services_master')
			->row();

		if ($exists) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Service already exists'
			]);
			return;
		}

		$data = [
			'service_name'   => $service_name,
			'service_type'   => $this->input->post('service_type'),
			'estimated_cost' => $this->input->post('estimated_cost') ?: 0,
			'estimated_time' => $this->input->post('estimated_time') ?: 0,
			'status'         => 'Active',
			'created_at'     => date('Y-m-d H:i:s')
		];

		$this->db->insert('services_master', $data);
		$data['master_service_id'] = $this->db->insert_id();

		echo json_encode([
			'status'  => 'success',
			'service' => $data
		]);
	}
}
