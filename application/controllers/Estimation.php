<?php defined('BASEPATH') or exit('No direct script access allowed');

class Estimation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'Inspection_model',
			'Inspection_view_model',
			'Works_requested_model',
			'Inventory_status_model',
			'Service_model',
			'Estimation_model',
			'SpareParts_model'
		]);
	}

	public function create($appointment_id)
	{
		// 1️⃣ Prevent duplicate estimation
		$existing = $this->Estimation_model->get_by_appointment($appointment_id);
		if ($existing) {
			redirect('estimation/edit/' . $existing->estimation_id);
		}

		// 2️⃣ Get appointment + customer + vehicle
		$appointment = $this->Estimation_model->get_appointment_details($appointment_id);
		if (!$appointment) show_404();

		// 3️⃣ Get inspection (Estimation MUST come after inspection)
		$inspection = $this->Inspection_view_model->get_by_appointment($appointment_id);
		if (!$inspection) {
			$this->session->set_flashdata(
				'error',
				'Please complete inspection before creating estimation.'
			);
			redirect('appointment');
		}

		// 4️⃣ Create estimation record (DRAFT)
		$estimation_id = $this->Estimation_model->create_estimation([
			'appointment_id'  => $appointment_id,
			'inspection_id'   => $inspection->inspection_id,
			'customer_id'     => $appointment->customer_id,
			'vehicle_id'      => $appointment->vehicle_id,
			'estimation_date' => date('Y-m-d'),
			'estimation_time' => date('H:i:s'),
			'status'          => 'Draft'
		]);

		$year = date('Y');

		// Example: EST-2025-000123
		$estimation_no = 'EST-' . $year . '-' . str_pad($estimation_id, 6, '0', STR_PAD_LEFT);

		// Update estimation with number
		$this->Estimation_model->update_estimation(
			$estimation_id,
			['estimation_no' => $estimation_no]
		);

		// 5️⃣ Load data for view
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation_no;
		$data['appointment']  = $appointment;
		$data['inspection']   = $inspection;
		$data['parts'] = $this->SpareParts_model->get_all_parts();

		$data['services_master'] = $this->db->where('status', 'Active')
			->where('service_type', 'LABOUR')
			->get('services_master')
			->result();
		// Services from inspection
		$data['services'] = $this->Inspection_model
			->get_saved_services($inspection->inspection_id);

		// Spare parts master
		$data['spare_parts'] = $this->SpareParts_model->get_all_parts();

		$data['title'] = 'Create Estimation';
		$data['main_content'] = 'estimation/create';

		$this->load->view('includes/template', $data);
	}


	public function save()
	{
		$estimation_id = $this->input->post('estimation_id');

		if (!$estimation_id) {
			show_error('Invalid Estimation');
		}

		// ---------------------------
		// 1️⃣ SAVE MAIN ESTIMATION
		// ---------------------------
		$estimationData = [
			'subtotal'        => $this->input->post('subtotal'),
			'tax_amount'      => $this->input->post('tax_amount'),
			'discount'        => $this->input->post('discount'),
			'grand_total'     => $this->input->post('grand_total'),
			'status'          => 'Draft'
		];

		$this->Estimation_model->update_estimation($estimation_id, $estimationData);

		// ---------------------------
		// 2️⃣ JOB DESCRIPTIONS
		// ---------------------------
		$job_descriptions = $this->input->post('job_description') ?? [];
		$this->Estimation_model->save_job_descriptions($estimation_id, $job_descriptions);

		// ---------------------------
		// 3️⃣ PARTS USED
		// ---------------------------
		$this->Estimation_model->save_parts(
			$estimation_id,
			$this->input->post('part_id') ?? [],
			$this->input->post('part_qty') ?? [],
			$this->input->post('part_price') ?? [],
			$this->input->post('sell_price') ?? [],
			$this->input->post('total_price') ?? []
		);

		// ---------------------------
		// 4️⃣ SERVICES / LABOUR
		// ---------------------------
		$this->Estimation_model->save_services(
			$estimation_id,
			$this->input->post('service_name') ?? [],
			$this->input->post('service_time') ?? [],
			$this->input->post('service_cost') ?? [],
			$this->input->post('total_cost') ?? []
		);

		// ---------------------------
		// 5️⃣ REDIRECT
		// ---------------------------
		redirect('estimation/view/' . $estimation_id);
	}

	public function edit($estimation_id)
	{
		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model->get_estimation_by_id($estimation_id);
		if (!$estimation) show_404();

		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($estimation->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model
			->get_job_descriptions($estimation_id);

		$parts_used = $this->Estimation_model
			->get_parts($estimation_id);

		$services_used = $this->Estimation_model
			->get_services($estimation_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts']           = $this->SpareParts_model->get_all_parts();
		$data['services_master'] = $this->Service_model->get_active_services();

		// 5️⃣ Send data to view
		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;
		$data['parts_used']       = $parts_used;
		$data['services_used']    = $services_used;

		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		$data['title'] = 'Edit Estimation';
		$data['main_content'] = 'estimation/create'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}
}
