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
			'Quotation_model'
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
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['usedbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Used Parts");
		$data['newbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("New Parts");
		$data['afterbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Aftermarket Parts");

		log_message('error', 'Used Brands: ' . print_r($data['usedbrands'], true));
		log_message('error', 'New Brands: ' . print_r($data['newbrands'], true));
		log_message('error', 'Aftermarket Brands: ' . print_r($data['afterbrands'], true));


		// $data['technicians'] = $this->Employee_model->get_active_technicians();
		$data['kms'] = $inspection->km_reading;

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
			'status'          => 'Approved',
			'customer_approval'     => $this->input->post('custapproval'),
			'customer_estimated_price'     => $this->input->post('estimatedprice'),
			'est_delivery_date'     => $this->input->post('estdeldate'),
			'est_completion_time'     => $this->input->post('completiontime'),
			'remarks'     => $this->input->post('remarks'),
		];

		$this->Estimation_model->update_estimation($estimation_id, $estimationData);

		// ---------------------------
		// 2️⃣ JOB DESCRIPTIONS
		// ---------------------------
		$job_descriptions = $this->input->post('job_description') ?? [];
		$job_amount  = $this->input->post('job_amount') ?? [];
		$this->Estimation_model->save_job_descriptions($estimation_id, $job_descriptions, $job_amount);

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
		);

		// ---------------------------
		// 4️⃣ SERVICES / LABOUR
		// ---------------------------
		$this->Estimation_model->save_services(
			$estimation_id,
			$this->input->post('service_id') ?? [],
			$this->input->post('service_time') ?? [],
			$this->input->post('service_cost') ?? [],
			$this->input->post('total_cost') ?? []
		);

		// ---------------------------
		// 5️⃣ REDIRECT
		// ---------------------------
		redirect('estimation/edit/' . $estimation_id);
	}

	public function update()
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
			'status'          => 'Approved',
			'customer_approval'     => $this->input->post('custapproval'),
			'customer_estimated_price'     => $this->input->post('estimatedprice'),
			'est_delivery_date'     => $this->input->post('estdeldate'),
			'est_completion_time'     => $this->input->post('completiontime'),
			'remarks'     => $this->input->post('remarks'),
		];

		$this->Estimation_model->update_estimation($estimation_id, $estimationData);

		// ---------------------------
		// 2️⃣ JOB DESCRIPTIONS
		// ---------------------------
		$job_descriptions = $this->input->post('job_description') ?? [];
		$job_amount  = $this->input->post('job_amount') ?? [];
		$this->Estimation_model->save_job_descriptions($estimation_id, $job_descriptions, $job_amount);
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
		);

		// ---------------------------
		// 4️⃣ SERVICES / LABOUR
		// ---------------------------
		$this->Estimation_model->save_services(
			$estimation_id,
			$this->input->post('service_id') ?? [],
			$this->input->post('service_time') ?? [],
			$this->input->post('service_cost') ?? [],
			$this->input->post('total_cost') ?? []
		);
		// ---------------------------
		// 5️⃣ quotation
		// ---------------------------
		// $custapproval = $this->input->post('custapproval');

		/* ===============================
   		CUSTOMER APPROVAL HANDLING
		================================ */
		// if ($custapproval === "APPROVED") {

		// 	1. Update estimation approval status FIRST
		// 	$this->db->where('estimation_id', $estimation_id)
		// 		->update('estimations', [
		// 			'customer_approval' => 'APPROVED',
		// 			'status'            => 'Approved'
		// 		]);

		// 	2. Check if quotation already created (VERY IMPORTANT)
		// 	$existingQuotation = $this->db
		// 		->where('estimation_id', $estimation_id)
		// 		->where('revision_no', 1)
		// 		->get('quotations')
		// 		->row();

		// 	if (!$existingQuotation) {

		// 		3. Create quotation only ONCE
		// 		$quotation_id = $this->Quotation_model
		// 			->create_from_estimation($estimation_id);
		// 	} else {
		// 		$quotation_id = $existingQuotation->quotation_id;
		// 	}

		// 	4. Redirect to quotation
		// 	redirect('quotation/edit/' . $quotation_id);
		// }

		// ---------------------------
		// 5️⃣ REDIRECT
		// ---------------------------
		redirect('estimation/edit/' . $estimation_id);
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

		$inspection = $this->Inspection_view_model->get_by_appointment($estimation->appointment_id);

		// 4️⃣ Masters (dropdown data)
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['services_master'] = $this->db->where('status', 'Active')
						->get('services_master')
			->result();
		// $data['technicians'] = $this->Employee_model->get_active_technicians();
		$data['kms'] = $inspection->km_reading;

		$data['usedbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Used Parts");
		$data['newbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("New Parts");
		$data['afterbrands'] = $this->SpareParts_model
			->get_brands_by_part_type("Aftermarket Parts");

		// 5️⃣ Send data to view
		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;
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
		$data['kms'] = $inspection->km_reading;
		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;

		$data['title'] = 'View Estimation';
		$data['main_content'] = 'estimation/view'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}

	public function view($estimation_id)
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



		$parts_used_new = $this->Estimation_model
			->get_parts_type($estimation_id, "New Parts");
		$parts_used_after = $this->Estimation_model
			->get_parts_type($estimation_id, "Aftermarket Parts");

		$parts_used_used = $this->Estimation_model
			->get_parts_type($estimation_id, "Used Parts");



		$services_used = $this->Estimation_model
			->get_services_print($estimation_id);

		$inspection = $this->Inspection_view_model->get_by_appointment($estimation->appointment_id);

		// 5️⃣ Send data to view
		$data['kms'] = $inspection->km_reading;

		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;

		$data['parts_used_new']       = $parts_used_new;
		$data['parts_used_after']       = $parts_used_after;
		$data['parts_used_used']       = $parts_used_used;
		$data['services_used']    = $services_used;

		$data['estimation_id'] = $estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;
		$data['amount_in_words'] = $this->number_to_words($data['estimation']->grand_total);

		$data['title'] = 'View Estimation';
		$data['main_content'] = 'estimation/view';

		$this->load->view('includes/template', $data);
	}

	public function index()
	{
		$data['title'] = 'Estimation List';
		$data['estimations'] = $this->Estimation_model->get_all_estimations();

		$data['main_content'] = 'estimation/list';
		$this->load->view('includes/template', $data);
	}

	public function delete($estimation_id)
	{
		$this->Estimation_model->delete_estimation($estimation_id);
		redirect('estimation');
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
}
