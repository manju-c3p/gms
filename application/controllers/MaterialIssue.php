<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MaterialIssue extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('MaterialIssue_model');
		$this->load->model('Jobcard_model');
		$this->load->model('Inventory_status_model');
		// Optional: auth check
		// if (!$this->session->userdata('user_id')) {
		//     redirect('login');
		// }
	}

	/**
	 * Show Material Issue form for a Job Card
	 * URL: materialissue/create/{jobcard_id}
	 */
	public function create($jobcard_id)
	{
		if (empty($jobcard_id)) {
			show_error('Job Card ID is required');
		}

		/* ===============================
           1️⃣ Get Job Card Details
        ================================ */
		$jobcard = $this->Jobcard_model->get_jobcard_with_basic_details($jobcard_id);

		if (!$jobcard) {
			show_error('Job Card not found');
		}

		/* ===============================
           2️⃣ Status validation
        ================================ */
		if ($jobcard->status === 'Completed') {
			$this->session->set_flashdata(
				'error',
				'Material issue is not allowed for completed job cards'
			);
			redirect('jobcard/view/' . $jobcard_id);
		}

		/* ===============================
           3️⃣ Get Job Card Parts
        ================================ */
		$jobcard_parts = $this->MaterialIssue_model
			->get_jobcard_parts_with_issued_qty($jobcard_id);

		/* ===============================
           4️⃣ Prepare data for view
        ================================ */
		$data = [
			'jobcard'        => $jobcard,
			'jobcard_parts'  => $jobcard_parts
		];

		/* ===============================
           5️⃣ Load view
        ================================ */

		$data['title'] = 'jaterial_issue';
		$data['main_content'] = 'material_issue/create'; // SAME PAGE

		$this->load->view('includes/template', $data);
	}

	public function store()
	{
		$this->load->model('MaterialIssue_model');
		$this->load->model('Inventory_status_model');
		$this->load->model('Jobcard_model');

		$jobcard_id = $this->input->post('jobcard_id');
		$part_ids  = $this->input->post('part_id');
		$issue_qty = $this->input->post('issue_qty');
		$remarks   = $this->input->post('remarks');
		$issue_date = $this->input->post('issue_date') ?? date('Y-m-d');

		if (!$jobcard_id) {
			show_error('Invalid Job Card');
		}

		/* ===============================
       1️⃣ JOB CARD VALIDATION
    ================================ */
		$jobcard = $this->Jobcard_model->get_jobcard_by_id($jobcard_id);

		if (!$jobcard || $jobcard->status === 'Completed') {
			$this->session->set_flashdata(
				'error',
				'Material issue not allowed for this job card'
			);
			redirect('materialissue/create/' . $jobcard_id);
		}

		/* ===============================
       2️⃣ COLLECT & FILTER ISSUE ITEMS
    ================================ */
		$issue_items = [];

		foreach ($part_ids as $i => $part_id) {
			$qty = (int)($issue_qty[$i] ?? 0);

			if ($qty > 0) {
				$issue_items[] = [
					'part_id' => $part_id,
					'qty'     => $qty
				];
			}
		}

		if (empty($issue_items)) {
			$this->session->set_flashdata(
				'error',
				'Please enter issue quantity for at least one part'
			);
			redirect('materialissue/create/' . $jobcard_id);
		}

		/* ===============================
       3️⃣ PHASE 1: VALIDATION ONLY
    ================================ */
		foreach ($issue_items as $item) {

			$part_id = $item['part_id'];
			$qty     = $item['qty'];

			// Planned qty check
			$remaining_qty = $this->MaterialIssue_model
				->get_remaining_jobcard_part_qty($jobcard_id, $part_id);

			if ($qty > $remaining_qty) {
				$this->session->set_flashdata(
					'error',
					'Issued quantity exceeds planned quantity'
				);
				redirect('materialissue/create/' . $jobcard_id);
			}

			// Stock availability check
			$available_stock = $this->Inventory_status_model
				->get_available_stock($part_id);

			if ($qty > $available_stock) {
				$this->session->set_flashdata(
					'error',
					'Insufficient stock available for one or more parts'
				);
				redirect('materialissue/create/' . $jobcard_id);
			}
		}

		/* ===============================
       4️⃣ PHASE 2: SAVE (TRANSACTION)
    ================================ */
		$this->db->trans_begin();

		try {

			// 4.1 Create material issue master
			$issue_id = $this->MaterialIssue_model->create_issue([
				'jobcard_id' => $jobcard_id,
				'issue_date' => $issue_date,
				'issued_by'  => $this->session->userdata('user_id'),
				'remarks'    => $remarks
			]);

			$issue_no = 'MI-' . date('Y') . '-' . str_pad($issue_id, 6, '0', STR_PAD_LEFT);
			$this->MaterialIssue_model->update_issue(
				$issue_id,
				['issue_no' => $issue_no]
			);

			// 4.2 Insert items + stock_out
			foreach ($issue_items as $item) {

				$this->MaterialIssue_model->create_issue_item([
					'issue_id'   => $issue_id,
					'jobcard_id' => $jobcard_id,
					'part_id'    => $item['part_id'],
					'issued_qty' => $item['qty']
				]);

				$this->Inventory_status_model->deduct_stock(
					$item['part_id'],
					$item['qty']
				);
			}

			// 4.3 Update job card status
			if ($jobcard->status === 'In Progress') {
				$this->Jobcard_model->update_jobcard(
					$jobcard_id,
					['status' => 'Completed']
				);
			}

			$this->db->trans_commit();

			$this->session->set_flashdata(
				'success',
				'Material issue saved successfully'
			);

			redirect('jobcard/view/' . $jobcard_id);
		} catch (Exception $e) {

			$this->db->trans_rollback();

			log_message('error', 'Material Issue Error: ' . $e->getMessage());

			$this->session->set_flashdata(
				'error',
				'Failed to save material issue'
			);

			redirect('materialissue/create/' . $jobcard_id);
		}
	}
}
