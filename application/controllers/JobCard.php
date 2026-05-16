<?php
require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

use function Complex\log10;

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
		$this->load->model("Inspection_view_model");
		$this->load->model("Quotation_model");
		$this->load->model("Employee_model");
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
	}

	private function generate_jobcard_no()
	{
		$year = date('Y');

		$last = $this->db
			->like('jobcard_no', "JC-$year-", 'after')
			->order_by('jobcard_id', 'DESC')
			// ->order_by("CAST(SUBSTRING_INDEX(jobcard_no,'-',-1) AS UNSIGNED)", "DESC")
			->limit(1)
			->get('job_cards')
			->row();

		if ($last) {
			$last_no = intval(substr($last->jobcard_no, -4));
			$new_no  = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
		} else {
			$new_no = '0001';
		}

		return "JC-$year-$new_no";
	}


	public function create($appointment_id)
	{
		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');

		// 1️⃣ Prevent duplicate jobcard
		$existing = $this->Jobcard_model->get_by_appointment($appointment_id);
		if ($existing) {
			log_message("error", $existing->status);
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

		$inspection = $this->Inspection_view_model->get_by_appointment($appointment_id);

		$estimation_id = $estimation->estimation_id;
		// 2️⃣ Get appointment + customer + vehicle
		$appointment = $this->Estimation_model->get_appointment_details($appointment_id);
		if (!$appointment) show_404();

		$quotation = $this->Quotation_model->get_quotation_details($appointment_id);
		$quotation_id  = $quotation->quotation_id;
		// 1️⃣ Create Job Card record
		$jobcard_no = $this->generate_jobcard_no();

		$jobcard_id = $this->Jobcard_model->create_jobcard([
			'estimation_id' => $estimation_id,
			'customer_id'   => $appointment->customer_id,
			'vehicle_id'    => $appointment->vehicle_id,
			'appointment_id' => $appointment->appointment_id,
			'jobcard_date'  => date('Y-m-d'),
			'jobcard_time'  => date('H:i:s'),
			'status'        => 'Pending',
			'quotation_id'   => $quotation_id,
			'jobcard_no' => $jobcard_no
		]);

		// 2️⃣ Generate Job Card No
		// $year = date('Y');
		// $jobcard_no = 'JC-' . $year . '-' . str_pad($jobcard_id, 6, '0', STR_PAD_LEFT);

		// // 3️⃣ Update job card with number
		// $this->Jobcard_model->update_jobcard(
		// 	$jobcard_id,
		// 	['jobcard_no' => $jobcard_no]
		// );



		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($estimation->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model
			->get_job_descriptions($estimation_id);

		$parts_used = $this->Quotation_model
			->get_parts($quotation_id);

		$services_used = $this->Quotation_model
			->get_services($quotation_id);

		$jobcardstatus = $this->Jobcard_model->get_jobcard_status_by_id($jobcard_id);

		$data['kms'] = $inspection->km_reading ?? null;



		$data['jobcard_id'] = $jobcard_id;
		$data['jobcard_no'] = $jobcard_no;
		$data['jobcardstatus'] = $jobcardstatus;

		// 4️⃣ Masters (dropdown data)
		$data['parts']           = $this->SpareParts_model->get_all_parts();
		$data['services_master'] = $this->Service_model->get_active_services();
		$data['technicians'] = $this->Employee_model->get_active_technicians();
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
		// $jobcardData = [
		// 	'subtotal'        => $this->input->post('subtotal'),
		// 	'tax_amount'      => $this->input->post('tax_amount'),
		// 	'discount'        => $this->input->post('discount'),
		// 	'grand_total'     => $this->input->post('grand_total'),
		// 	'status'          => 'In Progress'
		// ];

		$jobcardData = [

			'status'          => 'In Progress',
			'remarks' => $this->input->post('remarks'),
			'km_in' => $this->input->post('kmin'),
			'expected_delivery_date' => $this->input->post('estdate'),
			'completion_time' => $this->input->post('ctime')
		];

		$this->Jobcard_model->update_jobcard($jobcard_id, $jobcardData);

		// ---------------------------
		// 2️⃣ JOB DESCRIPTIONS
		// ---------------------------
		$job_descriptions = $this->input->post('sublet') ?? [];
		$service_amt = $this->input->post('service_amt') ?? [];
		$this->Jobcard_model->save_job_descriptions($jobcard_id, $job_descriptions, $service_amt);

		// ---------------------------
		// 3️⃣ PARTS USED
		// ---------------------------
		$this->Jobcard_model->save_parts(
			$jobcard_id,
			$this->input->post('part_id') ?? [],
			$this->input->post('part_type') ?? [],
			$this->input->post('part_qty') ?? [],
			$this->input->post('part_sellprice') ?? [],
			$this->input->post('part_sellprice') ?? [],
			$this->input->post('part_totalprice') ?? [],
			$this->input->post('part_disamt') ?? [],

		);

		// ---------------------------
		// 4️⃣ SERVICES / LABOUR
		// ---------------------------
		$this->Jobcard_model->save_services(
			$jobcard_id,
			$this->input->post('service_name') ?? [],
			$this->input->post('technician_id') ?? [],
			$this->input->post('service_amt') ?? [],
		);

		// ---------------------------
		// 5️⃣ REDIRECT
		// ---------------------------
		redirect('jobcard/edit/' . $jobcard_id);
	}

	public function updatejobcard()
	{
		// log_message('error', '--- update_controller called ---');
		// log_message('error', 'POST DATA: ' . print_r($this->input->post(), true));

		$jobcard_id = $this->input->post('jobcard_id');

		if (!$jobcard_id) {
			show_error('Invalid Jobcard');
		}


		$jobcardData = [

			// 'status'          => 'Scheduled',
			'status'          => $this->input->post('status'),
			'remarks' => $this->input->post('remarks'),
			'km_in' => $this->input->post('kmin'),
			'expected_delivery_date' => $this->input->post('estdate'),
			'completion_time' => $this->input->post('ctime'),
			'jobcard_date'=> $this->input->post('jobcard_date')
		];

		$this->Jobcard_model->update_jobcard($jobcard_id, $jobcardData);

		// ---------------------------
		// 4️⃣ SERVICES / LABOUR
		// ---------------------------
		$this->Jobcard_model->update_services(
			$jobcard_id,
			$this->input->post('service_name') ?? [],
			$this->input->post('technician_id') ?? [],
			$this->input->post('service_estcost') ?? [],
			$this->input->post('service_esttime') ?? [],
			$this->input->post('service_amt') ?? [],

		);

		// ---------------------------
		// 4️⃣ parts
		// ---------------------------
		$this->Jobcard_model->update_parts(
			$jobcard_id,
			$this->input->post('part_id') ?? [],
			$this->input->post('part_type') ?? [],
			$this->input->post('part_qty') ?? [],
			$this->input->post('part_sellprice') ?? [],
			$this->input->post('part_sellprice') ?? [],
			$this->input->post('part_totalprice') ?? [],
			$this->input->post('part_disamt') ?? [],

		);
		// ---------------------------
		// 4️⃣ sublet
		// ---------------------------
		$this->Jobcard_model->update_sublet(
			$jobcard_id,
			$this->input->post('sublet') ?? [],
			$this->input->post('jobservice_amt') ?? []

		);

		// ---------------------------
		// 5️⃣ REDIRECT
		// ---------------------------
		redirect('jobcard/edit/' . $jobcard_id);
	}


	public function edit($jobcard_id)
	{
		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		// 1️⃣ Get estimation header
		$jobcard = $this->Jobcard_model->get_jobcard_by_id($jobcard_id);
		if (!$jobcard) show_404();




		// 2️⃣ Appointment + customer + vehicle
		if ($jobcard->appointment_id) {
			$appointment = $this->Estimation_model
				->get_appointment_details($jobcard->appointment_id);

			$appointment_id = $appointment->appointment_id;
			$data['appointment']      = $appointment;
		}
		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($jobcard->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($jobcard->vehicle_id);



		// 3️⃣ Get estimation (jobcard MUST come after estimation)
		if ($jobcard->appointment_id) {
			$estimation = $this->Estimation_model->get_by_appointment($appointment_id);
		} else {
			$estimation = $this->Estimation_model->get_by_estimation($jobcard->estimation_id);
		}
		if (!$estimation) {
			$this->session->set_flashdata(
				'error',
				'Please complete inspection before creating estimation.'
			);
			redirect('appointment');
		}

		$estimation_id = $estimation->estimation_id;
		log_message('error', print_r($jobcard->estimation_id));


		// log_message('error',print_r($inspection));
		// 3️⃣ Sub tables
		$job_descriptions = $this->Jobcard_model
			->get_job_descriptions($jobcard_id);

		$parts_used = $this->Jobcard_model
			->get_parts($jobcard_id);

		$services_used = $this->Jobcard_model->get_services($jobcard_id);

		$jobcardstatus = $this->Jobcard_model->get_jobcard_status_by_id($jobcard_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts']           = $this->SpareParts_model->get_all_parts();
		$data['services_master'] = $this->Service_model->get_active_services();
		$data['technicians'] = $this->Employee_model->get_active_technicians();
		// 5️⃣ Send data to view
		$data['jobcard']       = $jobcard;
		$data['estimation']       = $estimation;
		// 
		$data['job_descriptions'] = $job_descriptions;
		$data['parts_used']       = $parts_used;
		$data['services_used']    = $services_used;
		$data['kms'] = $jobcard->km_in ??  $estimation->kmin;
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;

		$data['jobcard_id'] = $jobcard_id;
		$data['jobcard_no'] = $jobcard->jobcard_no;
		$data['jobcardstatus'] = $jobcardstatus->status;
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		$data['title'] = 'Edit Jobcard';
		$data['main_content'] = 'jobcard/edit'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}

	public function edit_by_quotationold($quotation_id)
	{
		// 1️⃣ Get estimation header
		// 1️⃣ Get jobcard by quotation
		$jobcard = $this->Jobcard_model->get_jobcard_by_qid($quotation_id);
		$appointment_id = null;
		$estimation_id = $jobcard->estimation_id;

		if (!$jobcard) {

			$this->session->set_flashdata(
				'error',
				'Please save the quotation first before opening the jobcard.'
			);

			// Redirect back to quotation edit page
			redirect('quotation/edit/' . $quotation_id);
			return;
		}

		$jobcard_id = $jobcard->jobcard_id;

		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($jobcard->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($jobcard->vehicle_id);


		if ($jobcard->appointment_id !== null) {
			// 2️⃣ Appointment + customer + vehicle
			$appointment = $this->Estimation_model
				->get_appointment_details($jobcard->appointment_id);

			$appointment_id = $appointment->appointment_id;
		}

		// 3️⃣ Get estimation (jobcard MUST come after estimation)
		// $estimation = $this->Estimation_model->get_by_appointment($appointment_id);
		$estimation = $this->Estimation_model->get_estimation_by_id($estimation_id);
		if (!$estimation) {
			$this->session->set_flashdata(
				'error',
				'Please complete inspection before creating estimation.'
			);
			redirect('appointment');
		}

		$estimation_id = $estimation->estimation_id;

		// $inspection = $this->Inspection_view_model->get_by_appointment($appointment_id);
		// $inspection = $this->Inspection_view_model->get_by_inspection($jobcard->inspection_id);
		// 3️⃣ Sub tables
		$job_descriptions = $this->Jobcard_model
			->get_job_descriptions($jobcard_id);

		$parts_used = $this->Jobcard_model
			->get_parts($jobcard_id);

		$services_used = $this->Jobcard_model->get_services($jobcard_id);
		// 
		$jobcardstatus = $this->Jobcard_model->get_jobcard_status_by_id($jobcard_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts']           = $this->SpareParts_model->get_all_parts();
		$data['services_master'] = $this->Service_model->get_active_services();
		$data['technicians'] = $this->Employee_model->get_active_technicians();
		// 5️⃣ Send data to view
		$data['estimation']       = $estimation;
		$data['appointment'] = $appointment ?? null;
		$data['job_descriptions'] = $job_descriptions;
		$data['parts_used']       = $parts_used;
		$data['services_used']    = $services_used;
		$data['kms'] =  $estimation->kmin;
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;

		$data['jobcard_id'] = $jobcard_id;
		$data['jobcard_no'] = $jobcard->jobcard_no;
		$data['jobcardstatus'] = $jobcardstatus->status;
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		$data['title'] = 'Edit Jobcard';
		$data['main_content'] = 'jobcard/create'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}

	public function edit_by_quotation($quotation_id, $estimation_id)
	{
		// 1️⃣ Get estimation header
		// 1️⃣ Get jobcard by quotation
		// 3️⃣ Get estimation (jobcard MUST come after estimation)
		// $estimation = $this->Estimation_model->get_by_appointment($appointment_id);

		// log_message('error', "check this function");
		$estimation = $this->Estimation_model->get_estimation_by_id($estimation_id);
		if (!$estimation) {
			$this->session->set_flashdata(
				'error',
				'Please complete inspection before creating estimation.'
			);
			redirect('appointment');
		}

		$estimation_id = $estimation->estimation_id;
		$parent_estimation_id = $estimation->parent_estimation_id;
		// log_message('error', "check this " . $parent_estimation_id);
		// log_message('error', "estimation_id this " . $estimation_id);

		if (!empty($parent_estimation_id)) {
			$jobcard = $this->Jobcard_model->get_jobcard_by_eid($parent_estimation_id);
		} else {
			$jobcard = $this->Jobcard_model->get_jobcard_by_eid($estimation_id);
		}

		$appointment_id = null;
		

		if (!$jobcard) {
			// ==================if jobcard not created, check quotation is saved or not. if saved create jobcard using quotation and move forward.
			//  otherwise show the save msg
			$quote = $this->Quotation_model->get_quotation($quotation_id);
			if (!$quote) {

				$this->session->set_flashdata(
					'error',
					'Please save the quotation first before opening the jobcard.'
				);
				// Redirect back to quotation edit page
				redirect('quotation/edit/' . $quotation_id);
				return;
			} else {
				$jobcard_id = $this->Quotation_model->create_jobcard_from_quotation($quotation_id);
				$jobcard = $this->Jobcard_model->get_jobcard_by_id($jobcard_id);
			}
		}
		$estimation_id = $jobcard->estimation_id;
		$jobcard_id = $jobcard->jobcard_id;

		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($jobcard->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($jobcard->vehicle_id);


		if ($jobcard->appointment_id !== null) {
			// 2️⃣ Appointment + customer + vehicle
			$appointment = $this->Estimation_model
				->get_appointment_details($jobcard->appointment_id);

			$appointment_id = $appointment->appointment_id;
		}



		// ====================now get the jocard created for parent estimation id  and add extra items or delete items from it======

		$job_descriptions_quotation = $this->Quotation_model
			->get_job_descriptions($quotation_id);

		$parts_used_quotation = $this->Quotation_model
			->get_parts($quotation_id);

		$services_used_quotation = $this->Quotation_model->get_services($quotation_id);



		// $inspection = $this->Inspection_view_model->get_by_appointment($appointment_id);
		// $inspection = $this->Inspection_view_model->get_by_inspection($jobcard->inspection_id);
		// 3️⃣ Sub tables
		$job_descriptions = $this->Jobcard_model
			->get_job_descriptions($jobcard_id);

		$parts_used = $this->Jobcard_model
			->get_parts($jobcard_id);

		$services_used = $this->Jobcard_model->get_services($jobcard_id);

		$jobcardstatus = $this->Jobcard_model->get_jobcard_status_by_id($jobcard_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts']           = $this->SpareParts_model->get_all_parts();
		$data['services_master'] = $this->Service_model->get_active_services();
		$data['technicians'] = $this->Employee_model->get_active_technicians();
		// 5️⃣ Send data to view
		$data['estimation']       = $estimation;
		$data['appointment'] = $appointment ?? null;

		$data['job_descriptions'] = $job_descriptions;
		$data['parts_used']       = $parts_used;
		$data['services_used']    = $services_used;

		$data['job_descriptions_quotation'] = $job_descriptions_quotation;
		$data['parts_used_quotation']       = $parts_used_quotation;
		$data['services_used_quotation']    = $services_used_quotation;


		$data['kms'] =  $estimation->kmin;
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;

		$data['jobcard_id'] = $jobcard_id;
		$data['jobcard_no'] = $jobcard->jobcard_no;
		$data['jobcardstatus'] = $jobcardstatus->status;
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		// ==========================revison procedure starts ======================
		// Convert jobcard services to array indexed by service_id
		$jobcard_services_map = [];
		foreach ($services_used as $js) {
			$jobcard_services_map[$js->service_id] = $js;
		}

		// Convert quotation services to array indexed by service_id
		$quotation_services_map = [];
		foreach ($services_used_quotation as $qs) {
			$quotation_services_map[$qs->service_id] = $qs;
		}

		$data['jobcard_services_map']   = $jobcard_services_map;
		$data['quotation_services_map'] = $quotation_services_map;


		// ==========================revison procedure Ends ======================
		// ========================== PART REVISION PROCEDURE ======================

		// Convert jobcard parts to array indexed by part_id
		$jobcard_parts_map = [];
		foreach ($parts_used as $jp) {
			$jobcard_parts_map[$jp->part_id] = $jp;
		}

		// Convert quotation parts to array indexed by part_id
		$quotation_parts_map = [];
		foreach ($parts_used_quotation as $qp) {
			$quotation_parts_map[$qp->part_id] = $qp;
		}

		$data['jobcard_parts_map']   = $jobcard_parts_map;
		$data['quotation_parts_map'] = $quotation_parts_map;
		// ========================== PART REVISION PROCEDURE ======================

		// ========================== sublet REVISION PROCEDURE ======================

		// Convert jobcard parts to array indexed by part_id
		$jobcard_description_map = [];
		foreach ($job_descriptions as $js) {
			$jobcard_description_map[$js->description] = $js;
		}

		// Convert quotation services to array indexed by service_id
		$quotation_description_map = [];
		foreach ($job_descriptions_quotation as $qs) {
			$quotation_description_map[$qs->description] = $qs;
		}

		$data['jobcard_description_map']   = $jobcard_description_map;
		$data['quotation_description_map'] = $quotation_description_map;
		// ========================== sublet REVISION PROCEDURE ======================

		$data['title'] = 'Edit Jobcard';
		$data['main_content'] = 'jobcard/create'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}



	public function view($jobcard_id)
	{
		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		$data['jobcard']  = $this->Jobcard_model->get_jobcard($jobcard_id);
		$data['services'] = $this->Jobcard_model->get_jobcard_servicesnew($jobcard_id);
		$data['parts']    = $this->Jobcard_model->get_jobcard_parts($jobcard_id);
		$data['technicians'] = $this->Employee_model->get_active_technicians();
		$data['job_descriptions'] = $this->Jobcard_model->get_job_descriptions($jobcard_id);

		$data['title'] = "Job Card #" . $jobcard_id;
		$data['main_content'] = "jobcard/jobcard_view";
		$this->load->view("includes/template", $data);
	}


	public function pdf($jobcard_id)
	{
		// ✅ Load Model FIRST
		$this->load->model('Jobcard_model');

		// ✅ Get Job Card with Full Details
		$jobcard = $this->Jobcard_model->get_jobcard_with_details($jobcard_id);

		if (!$jobcard) {
			show_404();
		}

		// ✅ Load HTML from View
		$data['jobcard'] = $jobcard;
		$html = $this->load->view('jobcard/jobcard_pdf', $data, TRUE);

		// ✅ Dompdf Configuration
		$options = new Options();
		$options->set('isRemoteEnabled', true);

		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		// ✅ Force Download
		$dompdf->stream("jobcard_{$jobcard_id}.pdf", [
			"Attachment" => true
		]);
	}

	public function index()
	{
		$data['title'] = 'Job Cards';
		$data['jobcards'] = $this->Jobcard_model->get_all_jobcards();

		$data['main_content'] = 'jobcard/list';
		$this->load->view('includes/template', $data);
	}

	public function delete($jobcard_id)
	{
		$this->Jobcard_model->delete_jobcard($jobcard_id);
		redirect('jobcard');
	}

	public function timesheet($jobcard_id)
	{
		$data['jobcard'] = $this->Jobcard_model->get_jobcard_basic($jobcard_id);
		$data['descriptions'] = $this->Jobcard_model->get_jobcard_descriptions_with_employee($jobcard_id);
		log_message(
			'Error',
			'Jobcard Descriptions: ' . json_encode($data['descriptions'])
		);

		// status
		$logs = $this->Jobcard_model->get_latest_work_status($jobcard_id);
		$statusMap = [];
		foreach ($logs as $l) {
			$statusMap[$l->jobcard_service_id] = $l->status;
		}

		// NEW: times
		$data['timeMap'] = $this->Jobcard_model->get_jobcard_work_times($jobcard_id);
		$data['statusMap'] = $statusMap;

		$data['title'] = 'Time Sheet';
		$data['main_content'] = 'jobcard/timesheet';
		$this->load->view('includes/template', $data);
	}


	// public function log_work_time1()
	// {
	// 	$data = [
	// 		'jobcard_id' => $this->input->post('jobcard_id'),
	// 		'jobcard_description_id' => $this->input->post('description_id'),
	// 		'employee_id' => $this->input->post('employee_id'),
	// 		'status' => $this->input->post('status'),
	// 		'log_time' => date('Y-m-d H:i:s')
	// 	];

	// 	$this->db->insert('jobcard_work_logs', $data);

	// 	echo json_encode(['status' => 'success']);
	// }


	// public function log_work_time()
	// {
	// 	$jobcard_id = $this->input->post('jobcard_id');
	// 	$description_id = $this->input->post('description_id');
	// 	$employee_id = $this->input->post('employee_id');
	// 	$status = $this->input->post('status');

	// 	// ❌ Prevent START more than once
	// 	if ($status === 'START') {
	// 		$alreadyStarted = $this->db
	// 			->where('jobcard_service_id', $description_id)
	// 			->where('status', 'START')
	// 			->get('jobcard_work_logs')
	// 			->row();

	// 		if ($alreadyStarted) {
	// 			echo json_encode(['status' => 'already_started']);
	// 			return;
	// 		}
	// 	}

	// 	$data = [
	// 		'jobcard_id' => $jobcard_id,
	// 		'jobcard_service_id' => $description_id,
	// 		'employee_id' => $employee_id,
	// 		'status' => $status,
	// 		'log_time' => date('Y-m-d H:i:s')
	// 	];

	// 	$this->db->insert('jobcard_work_logs', $data);

	// 	echo json_encode(['status' => 'success']);
	// }

	public function log_work_time()
	{
		$jobcard_id     = $this->input->post('jobcard_id');
		$service_id     = $this->input->post('description_id'); // jobcard_service_id
		$employee_id    = $this->input->post('employee_id');
		$status         = $this->input->post('status');

		// ❌ Prevent START more than once
		if ($status === 'START') {
			$alreadyStarted = $this->db
				->where('jobcard_service_id', $service_id)
				->where('status', 'START')
				->get('jobcard_work_logs')
				->row();

			if ($alreadyStarted) {
				echo json_encode(['status' => 'already_started']);
				return;
			}


			// 2️⃣ Update jobcard status to Inprogress
			$this->db->where('jobcard_id', $jobcard_id)
				->update('job_cards', [
					'status'     => 'In progress',
					// 'updated_at' => date('Y-m-d H:i:s')
				]);
		}

		// ✅ Insert log
		$this->db->insert('jobcard_work_logs', [
			'jobcard_id'          => $jobcard_id,
			'jobcard_service_id'  => $service_id,
			'employee_id'         => $employee_id,
			'status'              => $status,
			'log_time'            => date('Y-m-d H:i:s')
		]);

		// =====================================================
		// ✅ JOB CARD COMPLETION LOGIC (ONLY ON STOP)
		// =====================================================
		if ($status === 'STOP') {

			// 1️⃣ Total services under this jobcard
			$totalServices = $this->db
				->where('jobcard_id', $jobcard_id)
				->count_all_results('jobcard_services');

			// 2️⃣ Services which have at least ONE STOP log
			$stoppedServices = $this->db
				->select('COUNT(DISTINCT jobcard_service_id) AS total')
				->where('jobcard_id', $jobcard_id)
				->where('status', 'STOP')
				->get('jobcard_work_logs')
				->row()
				->total;

			// 3️⃣ If all services stopped → complete jobcard
			if ($totalServices > 0 && $totalServices == $stoppedServices) {

				$this->db
					->where('jobcard_id', $jobcard_id)
					->update('job_cards', [
						'status'        => 'Finished',
						'completion_time' => date('H:i:s')
					]);
			}
		}

		echo json_encode(['status' => 'success']);
	}



	public function create_from_quotation($quotation_id)
	{

		// 1. Get quotation
		$quotation = $this->Quotation_model->get_quotation($quotation_id);
		if (!$quotation || $quotation->status !== 'Approved') {
			show_error('Quotation not approved');
		}

		// 2. Check if jobcard already exists
		$existing = $this->Jobcard_model->get_by_quotation($quotation_id);
		if ($existing) {
			redirect('jobcard/edit/' . $existing->jobcard_id);
		}

		// 3. Create jobcard

		$jobcard_id = $this->Jobcard_model->create_from_quotation($quotation_id);

		redirect('jobcard/edit/' . $jobcard_id);
	}

	public function list_by_status($status)
	{
		$map = [
			'pending'     => 'Pending',
			'in-progress' => 'In Progress',
			'completed'   => 'Completed'
		];

		$status = strtolower($status);

		if (!isset($map[$status])) {
			show_error('Invalid Job Status');
		}

		$db_status = $map[$status];

		$data['page_title'] = $db_status . ' Job Cards';
		$data['jobcards']   = $this->Jobcard_model->get_jobcards_by_status($db_status);





		$data['title'] = 'job card list';
		$data['main_content'] = 'jobcard/jobcard_status_list'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}
}
