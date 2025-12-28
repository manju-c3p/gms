<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inspection extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Inspection_model',
			'Inspection_view_model',
			'Works_requested_model',
			'Inventory_status_model',
			'Service_model'
		]);
	}

	// Create inspection from appointment
	public function create($appointment_id)
	{
		// Prevent duplicate inspection
		$existing = $this->Inspection_view_model->get_by_appointment($appointment_id);
		if ($existing) {
			// log_message("error","from create");
			// redirect('inspection/view/' . $existing->inspection_id);

			redirect('inspection/edit/' . $existing->inspection_id);
		}

		// Get appointment + customer + vehicle
		$appointment = $this->Inspection_view_model->get_appointment_details($appointment_id);
		if (!$appointment) show_404();

		// Create inspection record (DRAFT)
		$inspection_id = $this->Inspection_view_model->create_inspection([
			'appointment_id'  => $appointment_id,
			'customer_id'     => $appointment->customer_id,
			'vehicle_id'      => $appointment->vehicle_id,
			'inspection_date' => date('Y-m-d'),
			'inspection_time' => date('H:i:s'),
			// 'km_reading'      => $appointment->km ?? 0,
			'status'          => 'Draft'
		]);
		$data['services'] = $this->Service_model->get_active_services();
		// Load masters
		$data['inspection_id'] = $inspection_id;
		$data['appointment']   = $appointment;
		$data['items']         = $this->Inspection_model->get_all_items();
		$data['works']         = $this->Works_requested_model->get_all();
		$data['inventory']     = $this->Inventory_status_model->get_all();

		$data['title'] = "Inspection Report";
		$data['main_content'] = 'inspection/create';
		$this->load->view('includes/template', $data);
	}

	// Save inspection

	public function save()
	{
		$inspection_id = $this->input->post('inspection_id');

		if (!$inspection_id) {
			show_error('Invalid Inspection');
		}

		// 1️⃣ Update main inspection table
		$inspectionData = [
			'km_reading'    => $this->input->post('km_reading'),
			'fuel_level'    => $this->input->post('fuel_level'),
			'remarks'       => $this->input->post('remarks'),
			'status'        => 'Completed'
		];

		$this->Inspection_model->update_inspection($inspection_id, $inspectionData);

		// 2️⃣ Save Inspection Items (A / C / S)
		if ($this->input->post('item_status')) {
			foreach ($this->input->post('item_status') as $item_id => $status) {
				$this->Inspection_model->save_item_result(
					$inspection_id,
					$item_id,
					$status
				);
			}
		}

		// 3️⃣ Save Services / Description table
		$service_ids     = $this->input->post('service_id') ?? [];
		$custom_services = $this->input->post('custom_service') ?? [];

		$this->Inspection_model->save_inspection_services(
			$inspection_id,
			$service_ids,
			$custom_services
		);

		// 4️⃣ Save Works Requested
		$works = $this->input->post('works_requested') ?? [];
		$this->Inspection_model->save_works_requested($inspection_id, $works);

		// 5️⃣ Save Inventory Status
		$inventory = $this->input->post('inventory_status') ?? [];
		$this->Inspection_model->save_inventory_status($inspection_id, $inventory);

		// 6️⃣ Redirect to inspection view / preview
		redirect('inspection/view/' . $inspection_id);
	}


	public function saveDamageMark()
	{
		$data = json_decode(file_get_contents("php://input"), true);

		$insert = [
			'inspection_id' => $data['inspection_id'],
			'x_coordinate'  => $data['x'],
			'y_coordinate'  => $data['y']
		];

		$this->db->insert('inspection_damage_marks', $insert);

		echo json_encode([
			'id' => $this->db->insert_id()
		]);
	}
	public function deleteDamageMark()
	{
		$data = json_decode(file_get_contents("php://input"), true);

		$this->db->where('id', $data['id'])
			->delete('inspection_damage_marks');

		echo json_encode(['success' => true]);
	}

	public function edit($inspection_id)
	{
		// Get inspection
		$inspection = $this->Inspection_model->get_by_id($inspection_id);
		if (!$inspection) show_404();

		// Get appointment details
		$appointment = $this->Inspection_view_model
			->get_appointment_details($inspection->appointment_id);

		// Load saved data
		$data['inspection']      = $inspection;
		$data['inspection_id']   = $inspection_id;
		$data['appointment']     = $appointment;

		// Masters
		$data['items']     = $this->Inspection_model->get_all_items();
		$data['works']     = $this->Works_requested_model->get_all();
		$data['inventory'] = $this->Inventory_status_model->get_all();
		$data['services']  = $this->Service_model->get_active_services();

		$service_map = [];
		foreach ($data['services'] as $s) {
			$service_map[$s->master_service_id] = $s->service_name;
		}

		$data['service_map'] = $service_map;

		// Saved values
		$data['item_results'] = $this->Inspection_model
			->get_item_results($inspection_id);

		$data['selected_works'] = $this->Inspection_model
			->get_selected_works($inspection_id);

		$data['selected_inventory'] = $this->Inspection_model
			->get_selected_inventory($inspection_id);

		$data['saved_services'] = $this->Inspection_model
			->get_saved_services($inspection_id);

		$data['damage_marks'] = $this->Inspection_model
			->get_damage_marks($inspection_id);

		$data['title'] = "Edit Inspection";
		$data['main_content'] = 'inspection/edit';
		$this->load->view('includes/template', $data);
	}
}
