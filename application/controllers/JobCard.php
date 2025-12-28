<?php
// require_once FCPATH . 'vendor/autoload.php';

// use Dompdf\Dompdf;
// use Dompdf\Options;

class Jobcard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Jobcard_model");
		$this->load->model("Appointment_model");
		$this->load->model("SpareParts_model");
		$this->load->model("Service_model");
		$this->load->model("Estimation_model");
	}

	public function create($appointment_id)
	{

		// 1️⃣ Prevent duplicate jobcard
		$existing = $this->Jobcard_model->get_by_appointment($appointment_id);
		if ($existing) {
			redirect('jobcard/edit/' . $existing->jobcard_id);
		}

		// 3️⃣ Get estimation (jobcard MUST come after estimation)
		$estimation = $this->Estimation_model->get_by_appointment($appointment_id);
		if (!$estimation) {
			$this->session->set_flashdata(
				'error',
				'Please complete inspection before creating estimation.'
			);
			redirect('appointment');
		}

		$estimation_id = $estimation->estimation_id;
		// 2️⃣ Get appointment + customer + vehicle
		$appointment = $this->Estimation_model->get_appointment_details($appointment_id);
		if (!$appointment) show_404();

		// 1️⃣ Create Job Card record
		$jobcard_id = $this->Jobcard_model->create_jobcard([
			'estimation_id' => $estimation_id,
			'customer_id'   => $appointment->customer_id,
			'vehicle_id'    => $appointment->vehicle_id,
			'appointment_id' => $appointment->appointment_id,
			'jobcard_date'  => date('Y-m-d'),
			'jobcard_time'  => date('H:i:s'),
			'status'        => 'Pending'
		]);

		// 2️⃣ Generate Job Card No
		$year = date('Y');
		$jobcard_no = 'JC-' . $year . '-' . str_pad($jobcard_id, 6, '0', STR_PAD_LEFT);

		// 3️⃣ Update job card with number
		$this->Jobcard_model->update_jobcard(
			$jobcard_id,
			['jobcard_no' => $jobcard_no]
		);



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




		$data['jobcard_id'] = $jobcard_id;
		$data['jobcard_no'] = $jobcard_no;

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

		$data['title'] = 'job card creation';
		$data['main_content'] = 'jobcard/create'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}

	public function save()
	{
		$jobcard_id = $this->input->post('jobcard_id');

		if (!$jobcard_id) {
			show_error('Invalid Jobcard');
		}

		// ---------------------------
		// 1️⃣ SAVE MAIN ESTIMATION
		// ---------------------------
		$jobcardData = [
			'subtotal'        => $this->input->post('subtotal'),
			'tax_amount'      => $this->input->post('tax_amount'),
			'discount'        => $this->input->post('discount'),
			'grand_total'     => $this->input->post('grand_total'),
			'status'          => 'Pending'
		];

		$this->Jobcard_model->update_jobcard($jobcard_id, $jobcardData);

		// ---------------------------
		// 2️⃣ JOB DESCRIPTIONS
		// ---------------------------
		$job_descriptions = $this->input->post('job_description') ?? [];
		$this->Jobcard_model->save_job_descriptions($jobcard_id, $job_descriptions);

		// ---------------------------
		// 3️⃣ PARTS USED
		// ---------------------------
		$this->Jobcard_model->save_parts(
			$jobcard_id,
			$this->input->post('part_id') ?? [],
			$this->input->post('part_qty') ?? [],
			$this->input->post('part_price') ?? [],
			$this->input->post('sell_price') ?? [],
			$this->input->post('total_price') ?? []
		);

		// ---------------------------
		// 4️⃣ SERVICES / LABOUR
		// ---------------------------
		$this->Jobcard_model->save_services(
			$jobcard_id,
			$this->input->post('service_name') ?? [],
			$this->input->post('service_time') ?? [],
			$this->input->post('service_cost') ?? [],
			$this->input->post('total_cost') ?? []
		);

		// ---------------------------
		// 5️⃣ REDIRECT
		// ---------------------------
		redirect('jobcard/view/' . $jobcard_id);
	}

	public function edit($jobcard_id)
	{
		// 1️⃣ Get estimation header
		$jobcard = $this->Jobcard_model->get_jobcard_by_id($jobcard_id);
		if (!$jobcard) show_404();




		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($jobcard->appointment_id);

		$appointment_id = $appointment->appointment_id;


		// 3️⃣ Get estimation (jobcard MUST come after estimation)
		$estimation = $this->Estimation_model->get_by_appointment($appointment_id);
		if (!$estimation) {
			$this->session->set_flashdata(
				'error',
				'Please complete inspection before creating estimation.'
			);
			redirect('appointment');
		}

		$estimation_id = $estimation->estimation_id;

		// 3️⃣ Sub tables
		$job_descriptions = $this->Jobcard_model
			->get_job_descriptions($jobcard_id);

		$parts_used = $this->Jobcard_model
			->get_parts($jobcard_id);

		$services_used = $this->Jobcard_model
			->get_services($jobcard_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts']           = $this->SpareParts_model->get_all_parts();
		$data['services_master'] = $this->Service_model->get_active_services();

		// 5️⃣ Send data to view
		$data['estimation']       = $jobcard;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;
		$data['parts_used']       = $parts_used;
		$data['services_used']    = $services_used;

		$data['jobcard_id'] = $jobcard_id;
		$data['jobcard_no'] = $jobcard->jobcard_no;
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		$data['title'] = 'Edit Jobcard';
		$data['main_content'] = 'jobcard/create'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}
}
