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
		$data['quotation'] = $this->Quotation_model->get_quotation($quotation_id);

		if (!$data['quotation']) {
			show_404();
		}


		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model
			->get_estimation_by_id($data['quotation']->estimation_id);
		if (!$estimation) show_404();

		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($data['quotation']->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model
			->get_job_descriptions($data['quotation']->estimation_id);

		// $parts_used = $this->Estimation_model
		// 	->get_parts($estimation_id);

		$parts_used_new = $this->Estimation_model
			->get_parts_type($data['quotation']->estimation_id, "New Parts");
		log_message('error', 'Parts Used (New): ' . print_r($parts_used_new, true));
		$parts_used_after = $this->Estimation_model
			->get_parts_type($data['quotation']->estimation_id, "Aftermarket Parts");

		$parts_used_used = $this->Estimation_model
			->get_parts_type($data['quotation']->estimation_id, "Used Parts");


		$services_used = $this->Estimation_model
			->get_services($data['quotation']->estimation_id);

		$inspection = $this->Inspection_view_model->get_by_appointment($data['quotation']->appointment_id);
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['services_master'] = $this->db->where('status', 'Active')
			->get('services_master')->result();
		$data['kms'] = $inspection->km_reading;
		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;

		$data['parts_used_new']       = $parts_used_new;
		$data['parts_used_after']       = $parts_used_after;
		$data['parts_used_used']       = $parts_used_used;
		$data['services_used']    = $services_used;

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

				// redirect back (or to estimation list / view)
				redirect('Estimation/edit/' . $estimation_id);
				return;
			}

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
		$quotation_id = $this->input->post('quotation_id');
		$status       = $this->input->post('quotation_status');

		// $this->Quotation_model->update_quotation($quotation_id, [
		// 	'status' => $status
		// ]);

		$post = $this->input->post();

		$this->Quotation_model->update_quotation($quotation_id, [
			'subtotal'    => $post['subtotal'],
			'tax_amount'  => $post['tax_amount'],
			'discount'    => $post['discount'],
			'grand_total' => $post['grand_total'],
			'remarks'     => $post['remarks'],
			'status' => $status,

			// parts
			'part_id'        => $post['part_id'],
			'part_qty'       => $post['part_qty'],
			'unit_price'     => $post['unit_price'],
			'selling_price'  => $post['selling_price'],
			'total_price'    => $post['total_price'],
			'discount'       => $post['discount'],
			'discountamt'    => $post['discountamt'],
			'part_type'      => $post['part_type'],
			'customer_selected' => $post['customer_selected'] ?? [],

			// services
			'service_id'     => $post['service_id'],
			'service_time'   => $post['service_time'],
			'service_cost'   => $post['service_cost'],
			'total_cost'     => $post['total_cost'],
		]);


		// If approved → create job card
		if ($status === 'Approved') {
			redirect('Jobcard/create_from_quotation/' . $quotation_id);
		}

		redirect('quotation/edit/' . $quotation_id);
	}



	public function view($quotation_id)
	{

		
		$data['quotation'] = $this->Quotation_model->get_quotation($quotation_id);

		if (!$data['quotation']) {
			show_404();
		}


		// 1️⃣ Get estimation header
		$estimation = $this->Estimation_model
			->get_estimation_by_id($data['quotation']->estimation_id);
		if (!$estimation) show_404();

		// 2️⃣ Appointment + customer + vehicle
		$appointment = $this->Estimation_model
			->get_appointment_details($data['quotation']->appointment_id);

		// 3️⃣ Sub tables
		$job_descriptions = $this->Estimation_model
			->get_job_descriptions($data['quotation']->estimation_id);

		// $parts_used = $this->Estimation_model
		// 	->get_parts($estimation_id);

		$parts_used_new = $this->Estimation_model
			->get_parts_type($data['quotation']->estimation_id, "New Parts");
		log_message('error', 'Parts Used (New): ' . print_r($parts_used_new, true));
		$parts_used_after = $this->Estimation_model
			->get_parts_type($data['quotation']->estimation_id, "Aftermarket Parts");

		$parts_used_used = $this->Estimation_model
			->get_parts_type($data['quotation']->estimation_id, "Used Parts");


		$services_used = $this->Quotation_model
			->get_services($data['quotation']->quotation_id);

		$inspection = $this->Inspection_view_model->get_by_appointment($data['quotation']->appointment_id);
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['services_master'] = $this->db->where('status', 'Active')
			->get('services_master')->result();
		$data['kms'] = $inspection->km_reading;
		$data['estimation']       = $estimation;
		$data['appointment']      = $appointment;
		$data['job_descriptions'] = $job_descriptions;

		$data['parts_used_new']       = $parts_used_new;
		$data['parts_used_after']       = $parts_used_after;
		$data['parts_used_used']       = $parts_used_used;
		$data['services_used']    = $services_used;

		$data['estimation_id'] = $estimation->estimation_id;
		$data['estimation_no'] = $estimation->estimation_no;


		$data['parts']    = $this->Quotation_model->get_parts($quotation_id);
		$data['services'] = $this->Quotation_model->get_services($quotation_id);

		$data['locked'] = ($data['quotation']->status === 'Approved');

		
		$data['amount_in_words'] = $this->number_to_words123($data['estimation']->grand_total);

		$data['title'] = 'View Quotation';
		$data['main_content'] = 'quotation/view';

		$this->load->view('includes/template', $data);
	}

	public function number_to_words123($number)
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
