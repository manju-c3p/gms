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
			'SpareParts_model',
			'Employee_model',
			'Quotation_model',
			'Customer_model',
			'Vehicle_model'
		]);
	}

	// private function generate_estimation_no()
	// {
	// 	$year = date('Y');

	// 	$last = $this->db
	// 		->like('estimation_no', "EST-$year-", 'after')
	// 		->order_by('estimation_id', 'DESC')
	// 		->limit(1)
	// 		->get('estimations')
	// 		->row();

	// 	if ($last) {
	// 		$last_no = intval(substr($last->estimation_no, -4));
	// 		$new_no  = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
	// 	} else {
	// 		$new_no = '0001';
	// 	}

	// 	return "EST-$year-$new_no";
	// }
	private function generate_estimation_no($parent_id = null)
	{
		$year = date('Y');

		// NEW ESTIMATION
		if ($parent_id == null) {

			$this->db->like('estimation_no', "EST-$year-", 'after');
			$this->db->not_like('estimation_no', 'REV');
			$this->db->order_by('estimation_id', 'DESC');
			$this->db->limit(1);

			$last = $this->db->get('estimations')->row();

			if ($last) {
				$parts = explode('-', $last->estimation_no);
				$last_no = intval($parts[2]);
				$new_no = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
			} else {
				$new_no = '0001';
			}



			return "EST-$year-$new_no";
		}

		// REVISION
		else {

			// get parent estimation
			$parent = $this->db
				->where('estimation_id', $parent_id)
				->get('estimations')
				->row();

			// always get base estimation number
			$base_est = preg_replace('/-REV-\d+$/', '', $parent->estimation_no);

			// find last revision for this parent
			$this->db->where('parent_estimation_id', $parent_id);
			$this->db->order_by('revision_no', 'DESC');
			$this->db->limit(1);

			$last = $this->db->get('estimations')->row();

			$rev = $last ? $last->revision_no + 1 : 1;

			return $base_est . "-REV-" . $rev;
		}
	}

	public function create($appointment_id)

	{
		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');


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

		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($inspection->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($inspection->vehicle_id);
		$estimation_no = $this->generate_estimation_no();


		// 4️⃣ Create estimation record (DRAFT)
		$estimation_id = $this->Estimation_model->create_estimation([
			'appointment_id'  => $appointment_id,
			'inspection_id'   => $inspection->inspection_id,
			'customer_id'     => $appointment->customer_id,
			'vehicle_id'      => $appointment->vehicle_id,
			'estimation_date' => date('Y-m-d'),
			'estimation_time' => date('H:i:s'),
			'status'          => 'Draft',
			'estimation_no' => $estimation_no
		]);

		// $year = date('Y');

		// // Example: EST-2025-000123
		// $estimation_no = 'EST-' . $year . '-' . str_pad($estimation_id, 6, '0', STR_PAD_LEFT);

		// // Update estimation with number
		// $this->Estimation_model->update_estimation(
		// 	$estimation_id,
		// 	['estimation_no' => $estimation_no]
		// );

		// 5️⃣ Load data for view
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation_no;
		$data['appointment']  = $appointment;
		$data['inspection']   = $inspection;

		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['usedbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Used Parts");
		$data['newbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("New Parts");
		$data['afterbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Aftermarket Parts");

		$data['Newparts'] = $this->SpareParts_model
			->get_parts_by_part_type("New Parts");

		$data['afterparts'] = $this->SpareParts_model
			->get_parts_by_part_type("Aftermarket Parts");
		$data['usedparts'] = $this->SpareParts_model
			->get_parts_by_part_type("Used Parts");

		log_message('error', 'Used Brands: ' . print_r($data['usedbrands'], true));
		log_message('error', 'New Brands: ' . print_r($data['newbrands'], true));
		log_message('error', 'Aftermarket Brands: ' . print_r($data['afterbrands'], true));


		// $data['technicians'] = $this->Employee_model->get_active_technicians();
		$data['kms'] = $inspection->km_reading ?? "";
				
		
			$data['estdate'] = $inspection->deliverytime;
		$data['services_master'] = $this->db->where('status', 'Active')
			->get('services_master')->result();
		// Services from inspection
		$data['services'] = $this->Inspection_model
			->get_saved_services($inspection->inspection_id);

		// Spare parts master
		$data['spare_parts'] = $this->SpareParts_model->get_all_parts();

		$data['title'] = 'Create Estimation';
		$data['main_content'] = 'estimation/create';

		$this->load->view('includes/template', $data);
	}

	public function create_inspection($inspection_id = null)
	{
		$data['username'] = $this->session->userdata('username');
		$data['userid']   = $this->session->userdata('user_id');

		/* ===============================
       1️⃣ Inspection is MANDATORY
       =============================== */
		if (!$inspection_id) {
			show_error('Inspection ID is required to create estimation');
		}

		// $inspection = $this->Inspection_view_model->get_inspection($inspection_id);

		$inspection = $this->Inspection_model->get_by_id($inspection_id);
		if (!$inspection) {
			show_404();
		}

		// get customer and vehicle details

		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($inspection->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($inspection->vehicle_id);

		/* ===============================
       2️⃣ Get appointment (OPTIONAL)
       =============================== */
		$appointment_id = $inspection->appointment_id ?? null;
		$appointment    = null;

		if ($appointment_id) {
			$appointment = $this->Estimation_model
				->get_appointment_details($appointment_id);
		}

		/* ===============================
       3️⃣ Prevent duplicate estimation
       =============================== */
		$existing = $this->Estimation_model
			->get_by_inspection($inspection_id);

		if ($existing) {
			redirect('estimation/edit/' . $existing->estimation_id);
		}

		/* ===============================
       4️⃣ Create estimation (DRAFT)
       =============================== */

		$estimation_no = $this->generate_estimation_no();
		$estimation_id = $this->Estimation_model->create_estimation([
			'inspection_id'   => $inspection_id,
			'appointment_id'  => $appointment_id, // NULL allowed
			'customer_id'     => $inspection->customer_id,
			'vehicle_id'      => $inspection->vehicle_id,
			'estimation_date' => date('Y-m-d'),
			'estimation_time' => date('H:i:s'),
			'status'          => 'Draft',
			'estimation_no' => $estimation_no
		]);

		// $year = date('Y');
		// $estimation_no = 'EST-' . $year . '-' . str_pad($estimation_id, 6, '0', STR_PAD_LEFT);
		// // $estimation_no = 'EST-' . $year . '-' . str_pad($estimation_id, 6, '0', STR_PAD_LEFT);

		// $this->Estimation_model->update_estimation(
		// 	$estimation_id,
		// 	['estimation_no' => $estimation_no]
		// );

		/* ===============================
       5️⃣ Prepare view data
       =============================== */
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation_no;
		$data['inspection']   = $inspection;
		$data['appointment']  = $appointment;
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;

		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();

		$data['usedbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Used Parts");
		$data['newbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("New Parts");
		$data['afterbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Aftermarket Parts");

		$data['Newparts'] = $this->SpareParts_model
			->get_parts_by_part_type("New Parts");

		$data['afterparts'] = $this->SpareParts_model
			->get_parts_by_part_type("Aftermarket Parts");
		$data['usedparts'] = $this->SpareParts_model
			->get_parts_by_part_type("Used Parts");

		$data['kms']     = $inspection->km_reading ?? "";
		$data['estdate'] = $inspection->deliverytime;

		$data['services_master'] = $this->db
			->where('status', 'Active')
			->get('services_master')
			->result();

		// Services selected during inspection
		$data['services'] = $this->Inspection_model
			->get_saved_services($inspection_id);

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
			'discount'        => $this->input->post('tdiscount'),
			'grand_total'     => $this->input->post('grand_total'),
			'status'          => 'Approved',
			'customer_approval'     => $this->input->post('custapproval'),
			'customer_estimated_price'     => $this->input->post('estimatedprice'),
			'est_delivery_date'     => $this->input->post('estdeldate'),
			'est_completion_time'     => $this->input->post('completiontime'),
			'remarks'     => $this->input->post('remarks'),
			'kmin'     => $this->input->post('kmin'),
			'service_discount'     => $this->input->post('service_discount'),
		];

		$this->Estimation_model->update_estimation($estimation_id, $estimationData);

		// ---------------------------
		// 2️⃣ JOB DESCRIPTIONS
		// ---------------------------
		$job_descriptions = $this->input->post('job_description') ?? [];
		$job_amount  = $this->input->post('job_amount') ?? [];
		$sublet_discount  =$this->input->post('sublet_discount');
		$this->Estimation_model->save_job_descriptions($estimation_id, $job_descriptions, $job_amount,$sublet_discount);

		// ---------------------------
		// 3️⃣ PARTS USED
		// ---------------------------
		$this->Estimation_model->save_parts(
			$estimation_id,
			$this->input->post('part_id') ?? [],
			$this->input->post('part_qty') ?? [],
			$this->input->post('unit_price') ?? [],
			$this->input->post('selling_price') ?? [],
			$this->input->post('total_price') ?? [],
			$this->input->post('markup') ?? [],
			$this->input->post('discount') ?? [],
			$this->input->post('discountamt') ?? [],
			$this->input->post('part_type') ?? [],
			$this->input->post('brand_id') ?? [],
			$this->input->post('customer_selected') ?? [],
			$this->input->post('part_warrenty') ?? [],
		);

		// ---------------------------
		// 4️⃣ SERVICES / LABOUR
		// ---------------------------
		$this->Estimation_model->save_services(
			$estimation_id,
			$this->input->post('service_id') ?? [],
			$this->input->post('service_time') ?? [],
			$this->input->post('service_cost') ?? [],
			$this->input->post('total_cost') ?? [],
			$this->input->post('service_discount'),
		);

		// ---------------------------
		// 5️⃣ REDIRECT
		// ---------------------------
		redirect('estimation/edit/' . $estimation_id);
	}

	// public function update()
	// {

	// 	$data['username'] = $this->session->userdata('username');
	// 	$data['userid'] = $this->session->userdata('user_id');
	// 	$estimation_id = $this->input->post('estimation_id');

	// 	if (!$estimation_id) {
	// 		show_error('Invalid Estimation');
	// 	}


	// 	// ---------------------------
	// 	// 1️⃣ SAVE MAIN ESTIMATION
	// 	// ---------------------------
	// 	$estimationData = [
	// 		'subtotal'        => $this->input->post('subtotal'),
	// 		'tax_amount'      => $this->input->post('tax_amount'),
	// 		'discount'        => $this->input->post('tdiscount'),
	// 		'grand_total'     => $this->input->post('grand_total'),
	// 		'status'          => 'Approved',
	// 		'customer_approval'     => $this->input->post('custapproval'),
	// 		'customer_estimated_price'     => $this->input->post('estimatedprice'),
	// 		'est_delivery_date'     => $this->input->post('estdeldate'),
	// 		'est_completion_time'     => $this->input->post('completiontime'),
	// 		'remarks'     => $this->input->post('remarks'),
	// 		'kmin'     => $this->input->post('kmin'),
	// 		'service_discount'     => $this->input->post('service_discount'),
	// 	];

	// 	$this->Estimation_model->update_estimation($estimation_id, $estimationData);

	// 	// ---------------------------
	// 	// 2️⃣ JOB DESCRIPTIONS
	// 	// ---------------------------
	// 	$job_descriptions = $this->input->post('job_description') ?? [];
	// 	$job_amount  = $this->input->post('job_amount') ?? [];
	// 	$this->Estimation_model->save_job_descriptions($estimation_id, $job_descriptions, $job_amount);
	// 	// ---------------------------
	// 	// 3️⃣ PARTS USED
	// 	// ---------------------------
	// 	$this->Estimation_model->save_parts(
	// 		$estimation_id,
	// 		$this->input->post('part_id') ?? [],
	// 		$this->input->post('part_qty') ?? [],
	// 		$this->input->post('unit_price') ?? [],
	// 		$this->input->post('selling_price') ?? [],
	// 		$this->input->post('total_price') ?? [],
	// 		$this->input->post('markup') ?? [],
	// 		$this->input->post('discount') ?? [],
	// 		$this->input->post('discountamt') ?? [],
	// 		$this->input->post('part_type') ?? [],
	// 		$this->input->post('brand_id') ?? [],
	// 		$this->input->post('customer_selected') ?? [],
	// 		$this->input->post('part_warrenty') ?? [],
	// 	);

	// 	// ---------------------------
	// 	// 4️⃣ SERVICES / LABOUR
	// 	// ---------------------------
	// 	$this->Estimation_model->save_services(
	// 		$estimation_id,
	// 		$this->input->post('service_id') ?? [],
	// 		$this->input->post('service_time') ?? [],
	// 		$this->input->post('service_cost') ?? [],
	// 		$this->input->post('total_cost') ?? [],
	// 		$this->input->post('service_discount'),
	// 	);
	// 	// ---------------------------
	// 	// 5️⃣ quotation
	// 	// ---------------------------
	// 	// $custapproval = $this->input->post('custapproval');

	// 	/* ===============================
	// 	CUSTOMER APPROVAL HANDLING
	// 	================================ */
	// 	// if ($custapproval === "APPROVED") {

	// 	// 	1. Update estimation approval status FIRST
	// 	// 	$this->db->where('estimation_id', $estimation_id)
	// 	// 		->update('estimations', [
	// 	// 			'customer_approval' => 'APPROVED',
	// 	// 			'status'            => 'Approved'
	// 	// 		]);

	// 	// 	2. Check if quotation already created (VERY IMPORTANT)
	// 	// 	$existingQuotation = $this->db
	// 	// 		->where('estimation_id', $estimation_id)
	// 	// 		->where('revision_no', 1)
	// 	// 		->get('quotations')
	// 	// 		->row();

	// 	// 	if (!$existingQuotation) {

	// 	// 		3. Create quotation only ONCE
	// 	// 		$quotation_id = $this->Quotation_model
	// 	// 			->create_from_estimation($estimation_id);
	// 	// 	} else {
	// 	// 		$quotation_id = $existingQuotation->quotation_id;
	// 	// 	}

	// 	// 	4. Redirect to quotation
	// 	// 	redirect('quotation/edit/' . $quotation_id);
	// 	// }

	// 	// ---------------------------
	// 	// 5️⃣ REDIRECT
	// 	// ---------------------------
	// 	redirect('estimation/edit/' . $estimation_id);
	// }

	public function update()
	{
		$data['username'] = $this->session->userdata('username');
		$data['userid']   = $this->session->userdata('user_id');

		$estimation_id    = $this->input->post('estimation_id');
		$create_revision  = $this->input->post('create_revision');

		if (!$estimation_id) {
			show_error('Invalid Estimation');
		}

			/* =====================================================
			1️⃣ GET ORIGINAL ESTIMATION
			===================================================== */

		$original = $this->db
			->where('estimation_id', $estimation_id)
			->get('estimations')
			->row();

		if (!$original) {
			show_error('Estimation not found');
		}

		/* =====================================================
			2️⃣ PREPARE ESTIMATION DATA
			===================================================== */

		$estimationData = [

			'subtotal'        => $this->input->post('subtotal'),
			'tax_amount'      => $this->input->post('tax_amount'),
			'discount'        => $this->input->post('tdiscount'),
			'grand_total'     => $this->input->post('grand_total'),

			'status'          =>  $this->input->post('custapproval'),

			'customer_approval' => $this->input->post('custapproval'),
			'customer_estimated_price' => $this->input->post('estimatedprice'),
			'est_delivery_date' => $this->input->post('estdeldate'),
			'est_completion_time' => $this->input->post('completiontime'),

			'remarks'         => $this->input->post('remarks'),
			'kmin'            => $this->input->post('kmin'),
			'service_discount' => $this->input->post('service_discount'),
			'sublet_discount' => $this->input->post('sublet_discount'),
		];

		/* =====================================================
			3️⃣ REVISION LOGIC
			===================================================== */

		if ($create_revision) {

			// determine parent
			$parent_id = $original->parent_estimation_id
				? $original->parent_estimation_id
				: $original->estimation_id;

			$parent_est  = $this->db
				->select('estimation_no')
				->where('estimation_id', $parent_id )
				->get('estimations')
				->row();

				$base_est = $parent_est->estimation_no;

			// get next revision number
			$max_revision = $this->db
				->select_max('revision_no')
				->where("(estimation_id = $parent_id OR parent_estimation_id = $parent_id)")
				->get('estimations')
				->row()
				->revision_no;

			$new_revision_no = ($max_revision !== null)
				? $max_revision + 1
				: 1;


			// mark old revisions not latest
			$this->db->where("(estimation_id = $parent_id OR parent_estimation_id = $parent_id)")
				->update('estimations', ['is_latest' => 0]);


				// get base estimation number
			// $base_est = preg_replace('/-REV-\d+$/', '', $original->estimation_no);

			// create new estimation revision
			$newData = array_merge($estimationData, [

				'appointment_id' => $original->appointment_id,
				'inspection_id'  => $original->inspection_id,
				'customer_id'    => $original->customer_id,
				'vehicle_id'     => $original->vehicle_id,
				'estimation_date'     => $original->estimation_date,

				'parent_estimation_id' => $parent_id,
				'revision_no'          => $new_revision_no,
				'is_latest'            => 1,

				  'estimation_no' => $base_est . '-REV-' . $new_revision_no,

				'created_at'    => date('Y-m-d H:i:s')

			]);


			$this->db->insert('estimations', $newData);

			// IMPORTANT: use new estimation id
			$estimation_id = $this->db->insert_id();
		} else {

			// normal update
			$this->Estimation_model->update_estimation(
				$estimation_id,
				$estimationData
			);

			// delete old child rows before saving updated ones
			// $this->Estimation_model->delete_jobs($estimation_id);
			// $this->Estimation_model->delete_parts($estimation_id);
			// $this->Estimation_model->delete_services($estimation_id);
		}


		/* =====================================================
		4️⃣ SAVE JOB DESCRIPTIONS (POST DATA ONLY)
		===================================================== */

		$this->Estimation_model->save_job_descriptions(
			$estimation_id,
			$this->input->post('job_description') ?? [],
			$this->input->post('job_amount') ?? [],
			$this->input->post('sublet_discount')
		);


		/* =====================================================
		5️⃣ SAVE PARTS (POST DATA ONLY)
		===================================================== */

		$this->Estimation_model->save_parts(
			$estimation_id,
			$this->input->post('part_id') ?? [],
			$this->input->post('part_qty') ?? [],
			$this->input->post('unit_price') ?? [],
			$this->input->post('selling_price') ?? [],
			$this->input->post('total_price') ?? [],
			$this->input->post('markup') ?? [],
			$this->input->post('discount') ?? [],
			$this->input->post('discountamt') ?? [],
			$this->input->post('part_type') ?? [],
			$this->input->post('brand_id') ?? [],
			$this->input->post('customer_selected') ?? [],
			$this->input->post('part_warrenty') ?? []
		);


		/* =====================================================
			6️⃣ SAVE SERVICES (POST DATA ONLY)
			===================================================== */

		$this->Estimation_model->save_services(
			$estimation_id,
			$this->input->post('service_id') ?? [],
			$this->input->post('service_time') ?? [],
			$this->input->post('service_cost') ?? [],
			$this->input->post('total_cost') ?? [],
			$this->input->post('service_discount')
		);


		/* =====================================================
			7️⃣ REDIRECT
			===================================================== */

		redirect('estimation/edit/' . $estimation_id);
	}
	public function edit($estimation_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model->get_estimation_by_id($estimation_id);
		if (!$estimation) show_404();

		// get customer and vehicle details

		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($estimation->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($estimation->vehicle_id);


		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($estimation->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model
			->get_job_descriptions($estimation_id);

		// $parts_used = $this->Estimation_model
		// 	->get_parts($estimation_id);

		$parts_used_new = $this->Estimation_model
			->get_parts_type($estimation_id, "New Parts");

		$parts_used_after = $this->Estimation_model
			->get_parts_type($estimation_id, "Aftermarket Parts");

		$parts_used_used = $this->Estimation_model
			->get_parts_type($estimation_id, "Used Parts");


		$services_used = $this->Estimation_model
			->get_services($estimation_id);

		$inspection = $this->Inspection_view_model->get_by_inspection($estimation->inspection_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['services_master'] = $this->db->where('status', 'Active')
			->get('services_master')
			->result();
		// $data['technicians'] = $this->Employee_model->get_active_technicians();
		$data['kms'] = $inspection->km_reading ?? $estimation->kmin;
		$data['service_discount'] = $estimation->service_discount ?? null;
		$data['sublet_discount'] = $estimation->sublet_discount ?? null;
		$data['estdate'] = $inspection->deliverytime ?? $estimation->est_completion_time;

		$data['usedbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Used Parts");
		$data['newbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("New Parts");
		$data['afterbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Aftermarket Parts");

		$data['Newparts'] = $this->SpareParts_model
			->get_parts_by_part_type("New Parts");

		$data['afterparts'] = $this->SpareParts_model
			->get_parts_by_part_type("Aftermarket Parts");
		$data['usedparts'] = $this->SpareParts_model
			->get_parts_by_part_type("Used Parts");

		// 5️⃣ Send data to view
		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;
		// $data['parts_used']       = $parts_used;
		$data['parts_used_new']       = $parts_used_new;
		$data['parts_used_after']       = $parts_used_after;
		$data['parts_used_used']       = $parts_used_used;
		$data['services_used']    = $services_used;

		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		$data['title'] = 'Edit Estimation';
		$data['main_content'] = 'estimation/edit';

		$this->load->view('includes/template', $data);
	}


	public function get_parts_by_brand()
	{
		$brand_id = $this->input->post('brand_id');

		if (!$brand_id) {
			echo json_encode([]);
			return;
		}

		$this->db->select('part_id, part_name, unit_price');
		$this->db->from('spare_parts');
		$this->db->group_start()
			->where('brand_id IS NULL')
			->or_where('brand_id', $brand_id)
			->group_end();
		$this->db->order_by('part_name', 'ASC');

		$parts = $this->db->get()->result();

		echo json_encode($parts);
	}
	public function get_parts_by_brand_parttype()
	{
		$brand_id = $this->input->post('brand_id');

		if (!$brand_id) {
			echo json_encode([]);
			return;
		}

		$this->db->select('part_id, part_name, unit_price');
		$this->db->from('spare_parts');
		$this->db->group_start()
			->where('brand_id IS NULL')
			->or_where('brand_id', $brand_id)
			->group_end();
		$this->db->order_by('part_name', 'ASC');

		$parts = $this->db->get()->result();

		echo json_encode($parts);
	}


	public function view1($estimation_id)
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

		$inspection = $this->Inspection_view_model->get_by_appointment($estimation->appointment_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts']           = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['services_master'] = $this->Service_model->get_active_services();
		$data['technicians'] = $this->Employee_model->get_active_technicians();

		// 5️⃣ Send data to view
		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;
		$data['parts_used']       = $parts_used;
		$data['services_used']    = $services_used;
		$data['kms'] =  $inspection->km_reading ?? $estimation->kmin;
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		$data['title'] = 'View Estimation';
		$data['main_content'] = 'estimation/view'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}

	public function viewold($estimation_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');

		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model->get_estimation_by_id($estimation_id);
		if (!$estimation) show_404();

		// get customer and vehicle details

		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($estimation->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($estimation->vehicle_id);

		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($estimation->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model
			->get_job_descriptions($estimation_id);

		$total_parts_count = $this->db
			->where('estimation_id', $estimation_id)
			->count_all_results('estimation_parts');


		$parts_used_new = $this->Estimation_model
			->get_parts_type($estimation_id, "New Parts");
		$parts_used_after = $this->Estimation_model
			->get_parts_type($estimation_id, "Aftermarket Parts");

		$parts_used_used = $this->Estimation_model
			->get_parts_type($estimation_id, "Used Parts");



		$services_used = $this->Estimation_model
			->get_services_print($estimation_id);


		$total_job_descriptions = is_array($job_descriptions)
			? count($job_descriptions)
			: count($job_descriptions->result());

		$total_services_used = is_array($services_used)
			? count($services_used)
			: count($services_used->result());

		$inspection = $this->Inspection_view_model->get_by_appointment($estimation->appointment_id);

		// 5️⃣ Send data to view
		$data['kms'] =  $inspection->km_reading ?? $estimation->kmin;

		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;

		$data['total_parts_count']       = $total_parts_count;
		$data['total_job_descriptions']       = $total_job_descriptions;
		$data['total_services_used']       = $total_services_used;

		$data['parts_used_new']       = $parts_used_new;
		$data['parts_used_after']       = $parts_used_after;
		$data['parts_used_used']       = $parts_used_used;
		$data['services_used']    = $services_used;

		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;
		$data['amount_in_words'] = $this->number_to_words($data['estimation']->grand_total);

		$data['title'] =
			'Estimation_' .
			($appointment->doc_no ?? ('VIN-' . str_pad($estimation_id, 6, '0', STR_PAD_LEFT))) . '_' .
			preg_replace('/[^A-Za-z0-9\-]/', '_', $appointment->registration_no ?? $vehicle->registration_no ?? '') . '_' .
			preg_replace('/[^A-Za-z0-9\-]/', '_', $appointment->customer_name ?? $customer->name ?? '') . '_' .
			date('d-m-Y');
		$data['main_content'] = 'estimation/view';

		$this->load->view('includes/template', $data);
	}

	public function view($estimation_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');

		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model->get_estimation_by_id($estimation_id);
		if (!$estimation) show_404();

		// get customer and vehicle details

		// Customer from inspection
		$customer = $this->Customer_model
			->get_customer($estimation->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model
			->get_vehicle($estimation->vehicle_id);

		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($estimation->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model
			->get_job_descriptions($estimation_id);

		$total_parts_count = $this->db
			->where('estimation_id', $estimation_id)
			->count_all_results('estimation_parts');


		$parts_used_new = $this->Estimation_model
			->get_parts_type($estimation_id, "New Parts");
		$parts_used_after = $this->Estimation_model
			->get_parts_type($estimation_id, "Aftermarket Parts");

		$parts_used_used = $this->Estimation_model
			->get_parts_type($estimation_id, "Used Parts");



		$services_used = $this->Estimation_model
			->get_services_print($estimation_id);


		$total_job_descriptions = is_array($job_descriptions)
			? count($job_descriptions)
			: count($job_descriptions->result());

		$total_services_used = is_array($services_used)
			? count($services_used)
			: count($services_used->result());

		$inspection = $this->Inspection_view_model->get_by_appointment($estimation->appointment_id);

		// 5️⃣ Send data to view
		// $data['kms'] = isset($inspection->km_reading) ? $inspection->km_reading : "";
		$data['kms'] = $inspection->km_reading ?? $estimation->kmin;

		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;

		$data['total_parts_count']       = $total_parts_count;
		$data['total_job_descriptions']       = $total_job_descriptions;
		$data['total_services_used']       = $total_services_used;

		$data['parts_used_new']       = $parts_used_new;
		$data['parts_used_after']       = $parts_used_after;
		$data['parts_used_used']       = $parts_used_used;
		$data['services_used']    = $services_used;

		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;
		$data['amount_in_words'] = $this->number_to_words($data['estimation']->grand_total);

		// $data['title'] = 'View Estimation';
		$data['title'] =
			'Estimation_' .
			($appointment->doc_no ?? ('VIN-' . str_pad($estimation_id, 6, '0', STR_PAD_LEFT))) . '_' .
			preg_replace('/[^A-Za-z0-9\-]/', '_', $appointment->registration_no ?? $vehicle->registration_no ?? '') . '_' .
			preg_replace('/[^A-Za-z0-9\-]/', '_', $appointment->customer_name ?? $customer->name ?? '') . '_' .
			date('d-m-Y');
		$data['main_content'] = 'estimation/viewnew';

		$this->load->view('includes/template', $data);
	}

	public function index()
	{
		$data['title'] = 'Estimation List';
		$data['estimations'] = $this->Estimation_model->get_all_estimations();
		$data['customers'] = $this->Customer_model->get_all();
		$data['vehicles']    = $this->Vehicle_model->get_all_vehicles();


		$data['main_content'] = 'estimation/list';
		$this->load->view('includes/template', $data);
	}

	public function delete($estimation_id)
	{
		$this->Estimation_model->delete_estimation($estimation_id);
		redirect('Estimation');
	}

	public function number_to_words($number)
	{
		if ($number == 0) {
			return 'Zero Dirhams Only';
		}

		$no = floor($number);
		$point = round(($number - $no) * 100);

		$digits_1 = [
			'',
			'One',
			'Two',
			'Three',
			'Four',
			'Five',
			'Six',
			'Seven',
			'Eight',
			'Nine',
			'Ten',
			'Eleven',
			'Twelve',
			'Thirteen',
			'Fourteen',
			'Fifteen',
			'Sixteen',
			'Seventeen',
			'Eighteen',
			'Nineteen'
		];

		$digits_2 = [
			'',
			'',
			'Twenty',
			'Thirty',
			'Forty',
			'Fifty',
			'Sixty',
			'Seventy',
			'Eighty',
			'Ninety'
		];

		$digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

		$str = [];
		$i = 0;

		while ($no > 0) {
			$divider = ($i == 2) ? 10 : 100;
			$number_part = $no % $divider;
			$no = floor($no / $divider);

			if ($number_part) {
				$plural = ($number_part > 9 && $i > 0) ? '' : '';
				$hundred = ($i == 1 && !empty($str)) ? ' and ' : '';

				if ($number_part < 20) {
					$str[] = $digits_1[$number_part] . ' ' . $digits[$i] . $plural . $hundred;
				} else {
					$str[] = $digits_2[floor($number_part / 10)] . ' ' .
						$digits_1[$number_part % 10] . ' ' .
						$digits[$i] . $plural . $hundred;
				}
			}

			$i += ($divider == 10) ? 1 : 2;
		}

		$result = implode('', array_reverse($str));

		$paise = '';
		if ($point > 0) {
			if ($point < 20) {
				$paise = $digits_1[$point];
			} else {
				$paise = $digits_2[floor($point / 10)] . ' ' . $digits_1[$point % 10];
			}
		}

		if ($paise) {
			return trim($result) . ' Dirhams and ' . $paise . ' Fils Only';
		}

		return trim($result) . ' Dirhams Only';
	}

	// ==========================================================

	public function create_direct_estimation()
	{
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		$this->load->model('Estimation_model');

		$customer_id = $this->input->post('customer_id');
		$vehicle_id  = $this->input->post('vehicle_id');

		/* ===============================
       1️⃣ CREATE CUSTOMER (IF NEW)
    			=============================== */
		if ($customer_id === 'new') {

			$cust_name  = $this->input->post('cust_name');
			$cust_phone = $this->input->post('cust_phone');

			if (!$cust_name || !$cust_phone) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Customer name and phone are required'
				]);
				return;
			}

			$customer_id = $this->Customer_model->create([
				'name'    => $cust_name,
				'phone'   => $cust_phone,
				'email'   => $this->input->post('cust_email'),
				'address' => $this->input->post('cust_address')
			]);
		}

		if (!$customer_id) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Customer is required'
			]);
			return;
		}

		/* ===============================
       2️⃣ CREATE VEHICLE (IF NEW)
    		=============================== */
		if (!$vehicle_id) {

			$plate_no = $this->input->post('plate_no');
			$brand    = $this->input->post('brand');
			$model    = $this->input->post('model');

			if (!$plate_no || !$brand || !$model) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Vehicle details are required'
				]);
				return;
			}

			$vehicle_id = $this->Vehicle_model->create([
				'customer_id'     => $customer_id,
				'registration_no' => $plate_no,
				'brand'           => $brand,
				'model'           => $model,
				'chassis_no'      => $this->input->post('vin_no')
			]);
		}

		/* ===============================
       3️⃣ CREATE ESTIMATION (DIRECT)
   			 =============================== */
		$estimation_no = $this->generate_estimation_no();
		$estimation_data = [
			'appointment_id'  => NULL,   // 🔥 DIRECT
			'inspection_id'   => NULL,   // 🔥 DIRECT
			'customer_id'     => $customer_id,
			'vehicle_id'      => $vehicle_id,
			// 'estimation_no'   => $this->generate_estimation_no(),
			'estimation_date' => date('Y-m-d'),
			'status'          => 'Draft',
			'created_at'      => date('Y-m-d H:i:s'),
			'estimation_no' => $estimation_no
		];

		$estimation_id = $this->Estimation_model->create_estimation($estimation_data);

		// $year = date('Y');

		// // Example: EST-2025-000123
		// $estimation_no = 'EST-' . $year . '-' . str_pad($estimation_id, 6, '0', STR_PAD_LEFT);

		// // Update estimation with number
		// $this->Estimation_model->update_estimation(
		// 	$estimation_id,
		// 	['estimation_no' => $estimation_no]
		// );

		echo json_encode([
			'status'        => 'success',
			'estimation_id' => $estimation_id
		]);
	}


	public function get_by_chassis()
	{
		$chassis = $this->input->post('chassis_no');

		$data = $this->db
			->select('v.*, c.customer_id')
			->from('vehicles v')
			->join('customers c', 'c.customer_id = v.customer_id')
			->where('v.chassis_no', $chassis)
			->get()
			->row();

		echo json_encode($data);
	}
}
