<?php

class Advance extends CI_Controller
{

	public function create()
	{

		$this->load->model('Advance_model');
		$this->load->model('Customer_model');
		$this->load->model('Jobcard_model');
		$this->load->model('Quotation_model');

		$data['title'] = 'Advance';
		$data['jobcards'] = $this->Jobcard_model->get_all_jobcards_completed();
		// $data['customers'] = $this->Customer_model->get_all();
		// $data['jobcards'] = $this->Jobcard_model->get_all();
		// $data['quotations'] = $this->Quotation_model->get_all();


		// $advances = $this->Advance_model->get_available_advance($jobcard_id);

		// Pass to view
		// $data['advances'] = $advances;
		$data['main_content'] = 'advance/create';
		$this->load->view('includes/template', $data);
	}

	public function store()
	{
		$data = [
			'receipt_no' => 'ADV-' . time(),
			'receipt_date' => $this->input->post('date'),
			'customer_id' => $this->input->post('customer_id'),
			'jobcard_id' => $this->input->post('jobcard_id'),
			'quotation_id' => $this->input->post('quotation_id'),
			'amount' => $this->input->post('amount'),
			'payment_mode' => $this->input->post('payment_mode'),
			'reference_no' => $this->input->post('reference_no'),
			'notes' => $this->input->post('notes')
		];

		$this->load->model('Advance_model');
		$this->Advance_model->create_advance($data);

		redirect('advance/list');
	}

	public function get_available_advance_custid($customer_id)
	{
		$data = $this->db
			->where('customer_id', $customer_id)
			->where('balance_amount >', 0)
			->get('advance_receipts')
			->result();

		echo json_encode($data);
	}
}
