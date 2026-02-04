<?php defined('BASEPATH') or exit('No direct script access allowed');

class Quotation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Quotation_model');
		$this->load->model('Estimation_model');
		$this->load->model('Inspection_view_model');
		$this->load->model('SpareParts_model');
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		$this->load->model('Jobcard_model');
		$this->load->helper('amount');
	}

	/**
	 * Quotation listing page
	 */
	public function index()
	{
		$data['title'] = 'Quotation List';
		$data['quotations'] = $this->Quotation_model->get_all_quotations_with_jobcard();

		$data['main_content'] = 'quotation/list';
		$this->load->view('includes/template', $data);
	}

	/**
	 * Create jobcard from quotation
	 */
	public function create_jobcard($quotation_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		$jobcard_id = $this->Quotation_model->create_jobcard_from_quotation($quotation_id);

		if ($jobcard_id) {
			redirect('jobcard/view/' . $jobcard_id);
		} else {
			show_error('Unable to create job card');
		}
	}


	/* =====================================================
       AUTO CREATE QUOTATION AFTER ESTIMATION APPROVAL
       ===================================================== */
	public function create_from_estimation($estimation_id)
	{

		// 1. Fetch estimation
		$estimation = $this->Estimation_model->get_estimation_by_id($estimation_id);

		if (!$estimation) {
			show_error('Estimation not found');
		}

		// 2. Allow only approved estimation
		if ($estimation->status !== 'Approved') {
			$this->session->set_flashdata(
				'error',
				'Quotation can be created only after customer approval'
			);
			redirect('estimation/view/' . $estimation_id);
		}

		// 3. Create quotation
		$quotation_id = $this->Quotation_model
			->create_from_estimation($estimation_id);

		if (!$quotation_id) {
			show_error('Failed to create quotation');
		}

		// 4. Update estimation status (optional but recommended)
		$this->db
			->where('estimation_id', $estimation_id)
			->update('estimations', [
				'status' => 'Converted'
			]);

		// 5. Redirect to quotation edit page
		redirect('quotation/edit/' . $quotation_id);
	}

	/* =========================
       EDIT QUOTATION PAGE
       ========================= */
	public function edit($quotation_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		$data['quotation'] = $this->Quotation_model->get_quotation($quotation_id);

		if (!$data['quotation']) {
			show_404();
		}
		// log_message('error',)

		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model->get_estimation_by_id($data['quotation']->estimation_id);
		if (!$estimation) show_404();
		// Customer from inspection
		$customer = $this->Customer_model->get_customer($data['quotation']->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model->get_vehicle($data['quotation']->vehicle_id);

		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model->get_appointment_details($data['quotation']->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model->get_job_descriptions($data['quotation']->estimation_id);



		// $parts_used_new = $this->Estimation_model
		// 	->get_parts_type($data['quotation']->estimation_id, "New Parts");

		// $parts_used_after = $this->Estimation_model
		// 	->get_parts_type($data['quotation']->estimation_id, "Aftermarket Parts");

		// $parts_used_used = $this->Estimation_model
		// 	->get_parts_type($data['quotation']->estimation_id, "Used Parts");
		$parts_used_new = $this->Quotation_model->get_parts_type($quotation_id, "New Parts");

		$parts_used_after = $this->Quotation_model->get_parts_type($quotation_id, "Aftermarket Parts");

		$parts_used_used = $this->Quotation_model->get_parts_type($quotation_id, "Used Parts");

		// log_message('error', 'New Parts: ' . print_r($parts_used_new, true));
		// log_message('error', 'Aftermarket Parts: ' . print_r($parts_used_after, true));
		// log_message('error', 'Used Parts: ' . print_r($parts_used_used, true));

		$services_used = $this->Estimation_model->get_services($data['quotation']->estimation_id);

		$inspection = $this->Inspection_view_model->get_by_inspection($data['quotation']->inspection_id);
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['services_master'] = $this->db->where('status', 'Active')
			->get('services_master')->result();
		$data['kms'] = $inspection->km_reading ?? $estimation->kmin;
		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;

		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;

		$data['parts_used_new']       = $parts_used_new;
		$data['parts_used_after']       = $parts_used_after;
		$data['parts_used_used']       = $parts_used_used;

		// log_message('error', 'DATA parts_used_new: ' . print_r($data['parts_used_new'], true));
		// log_message('error', 'DATA parts_used_after: ' . print_r($data['parts_used_after'], true));
		// log_message('error', 'DATA parts_used_used: ' . print_r($data['parts_used_used'], true));

		$data['services_used']    = $services_used;

		$data['usedbrands'] = $this->SpareParts_model->get_brands_by_part_type("Used Parts");
		$data['newbrands'] = $this->SpareParts_model->get_brands_by_part_type("New Parts");
		$data['afterbrands'] = $this->SpareParts_model->get_brands_by_part_type("Aftermarket Parts");

		$data['Newparts'] = $this->SpareParts_model->get_parts_by_part_type("New Parts");

		$data['afterparts'] = $this->SpareParts_model->get_parts_by_part_type("Aftermarket Parts");
		$data['usedparts'] = $this->SpareParts_model->get_parts_by_part_type("Used Parts");


		$data['estimation_id'] = $estimation->estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;


		$data['parts']    = $this->Quotation_model->get_parts($quotation_id);
		$data['services'] = $this->Quotation_model->get_services($quotation_id);

		$data['locked'] = ($data['quotation']->status === 'Approved');

		$data['title'] = 'Quotation Edit';

		// ✅ FIX IS HERE
		$data['main_content'] = 'quotation/edit';

		$this->load->view('includes/template', $data);
	}


	public function edit_by_estimation($estimation_id)
	{
		// 1. Check estimation exists
		$estimation = $this->db
			->where('estimation_id', $estimation_id)
			->get('estimations')
			->row();

		if (!$estimation) {
			show_404();
		}

		// 2. Check if quotation already exists
		$quotation = $this->db
			->where('estimation_id', $estimation_id)
			->where('revision_no', 1)
			->get('quotations')
			->row();

		// 3. If NOT exists → create quotation
		if (!$quotation) {

			// ✅ Customer approval check
			if ($estimation->customer_approval !== 'APPROVED') {

				$this->session->set_flashdata(
					'error',
					'Customer approval is not done yet. Please get approval before creating quotation.'
				);

				redirect('Estimation/edit/' . $estimation_id);
				return;
			}

			// ✅ Spare parts selection check (ONLY if parts exist)
			$total_parts_count = $this->db
				->where('estimation_id', $estimation_id)
				->count_all_results('estimation_parts');

			if ($total_parts_count > 0) {

				$selected_parts_count = $this->db
					->where('estimation_id', $estimation_id)
					->where('selected', 1)
					->count_all_results('estimation_parts');

				if ($selected_parts_count == 0) {

					$this->session->set_flashdata(
						'error',
						'Please select which spare parts are being used before proceeding to quotation.'
					);

					redirect('Estimation/edit/' . $estimation_id);
					return;
				}
			}


			// ✅ Safe to create quotation
			$quotation_id = $this->Quotation_model
				->create_from_estimation($estimation_id);
		} else {
			$quotation_id = $quotation->quotation_id;
		}


		// 4. Redirect to quotation edit page
		redirect('quotation/edit/' . $quotation_id);
	}


	/* =========================
       UPDATE QUOTATION
       ========================= */


	public function update()
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		$quotation_id = $this->input->post('quotation_id');
		$status       = $this->input->post('quotation_status');

		// $this->Quotation_model->update_quotation($quotation_id, [
		// 	'status' => $status
		// ]);

		$post = $this->input->post();

		$this->Quotation_model->update_quotation($quotation_id, [
			'subtotal'    => $post['subtotal'],
			'tax_amount'  => $post['tax_amount'],
			'tdiscount'    => $post['totdiscount'],
			'grand_total' => $post['grand_total'],
			'remarks'     => $post['remarks'],
			'status' => $status,
			'srvice_discount'     => $this->input->post('service_discount'),

			// parts
			'part_id'        => $post['part_id'] ?? null,
			'part_qty'       => $post['part_qty'] ?? null,
			'unit_price'     => $post['unit_price'] ?? null,
			'selling_price'  => $post['selling_price'] ?? null,
			'total_price'    => $post['total_price'] ?? null,
			'discount'       => $post['discount'] ?? null,
			'discountamt'    => $post['discountamt'] ?? null,
			'part_type'      => $post['part_type'] ?? null,
			'customer_selected' => $post['customer_selected'] ?? [],
			'partremarks' => $post['part_warrenty'] ?? [],
			

			// services
			'service_id'     => $post['service_id'],
			'service_time'   => $post['service_time'],
			'service_cost'   => $post['service_cost'],
			'total_cost'     => $post['total_cost']
		]);


		// If approved → create job card
		// If approved → create job card ONLY IF NOT EXISTS
		if ($status === 'Approved') {

			$existing_jobcard = $this->Jobcard_model->get_by_quotation_id($quotation_id);

			if (!$existing_jobcard) {
				$jobcard_id = $this->Jobcard_model->create_from_quotation($quotation_id);
			}
		}


		redirect('quotation/edit/' . $quotation_id);
	}



	public function view($quotation_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		$data['quotation'] = $this->Quotation_model->get_quotation($quotation_id);

		if (!$data['quotation']) {
			show_404();
		}


		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model->get_estimation_by_id($data['quotation']->estimation_id);
		if (!$estimation) show_404();

		// Customer from inspection
		$customer = $this->Customer_model->get_customer($data['quotation']->customer_id);

		// Vehicle from inspection
		$vehicle = $this->Vehicle_model->get_vehicle($data['quotation']->vehicle_id);

		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model->get_appointment_details($data['quotation']->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model->get_job_descriptions($data['quotation']->estimation_id);

		// $parts_used = $this->Estimation_model
		// 	->get_parts($estimation_id);

			$total_parts_count = $this->db
				->where('quotation_id', $quotation_id)
				->count_all_results('quotation_parts');


		$parts_used_new = $this->Quotation_model->get_parts_type($quotation_id, "New Parts");

		$parts_used_after = $this->Quotation_model->get_parts_type($quotation_id, "Aftermarket Parts");

		$parts_used_used = $this->Quotation_model->get_parts_type($quotation_id, "Used Parts");


		$services_used = $this->Quotation_model->get_services($data['quotation']->quotation_id);

		$total_job_descriptions = is_array($job_descriptions)
			? count($job_descriptions)
			: count($job_descriptions->result());

		$total_services_used = is_array($services_used)
			? count($services_used)
			: count($services_used->result());


		$inspection = $this->Inspection_view_model->get_by_appointment($data['quotation']->appointment_id);
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['services_master'] = $this->db->where('status', 'Active')
			->get('services_master')->result();
		$data['kms'] = $estimation->kmin;
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

		$data['estimation_id'] = $estimation->estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;


		$data['parts']    = $this->Quotation_model->get_parts($quotation_id);
		$data['services'] = $this->Quotation_model->get_services($quotation_id);

		$data['locked'] = ($data['quotation']->status === 'Approved');


		// $data['amount_in_words'] = $this->number_to_words_aed($data['estimation']->grand_total);

		$data['title'] = 'View Quotation';
		$data['main_content'] = 'quotation/view';

		$this->load->view('includes/template', $data);
	}


	public function delete($quotation_id)
	{
		$this->Quotation_model->delete_quotation($quotation_id);
		redirect('Quotation');
	}
}
