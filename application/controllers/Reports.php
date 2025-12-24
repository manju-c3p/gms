<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}
	public function daily_jobs()
	{
		$this->load->model('Reports_model');

		$date = $this->input->get('date') ?? date('Y-m-d');

		$data['title'] = 'Daily Job Report';
		$data['date']  = $date;
		$data['jobs']  = $this->Reports_model->get_daily_job_report($date);


		$data['main_content'] = 'reports/daily_jobs';
		$this->load->view('includes/template', $data);
	}
	public function revenue()
	{
		$this->load->model('Reports_model');

		$from = $this->input->get('from') ?? date('Y-m-01');
		$to   = $this->input->get('to') ?? date('Y-m-d');

		$data['title'] = 'Revenue Report';
		$data['from']  = $from;
		$data['to']    = $to;

		$data['reports'] = $this->Reports_model->get_revenue_report($from, $to);

		// Totals
		$data['total_revenue'] = array_sum(array_column($data['reports'], 'grand_total'));
		$data['total_tax']     = array_sum(array_column($data['reports'], 'tax_amount'));



		$data['main_content'] = 'reports/revenue';
		$this->load->view('includes/template', $data);
	}

	public function inventory_usage()
	{
		$this->load->model('Reports_model');

		$from = $this->input->get('from') ?? date('Y-m-01');
		$to   = $this->input->get('to') ?? date('Y-m-d');

		$data['title'] = 'Inventory Usage Report';
		$data['from']  = $from;
		$data['to']    = $to;

		$data['items'] = $this->Reports_model->get_inventory_usage_report($from, $to);


		$data['main_content'] = 'reports/inventory_usage';
		$this->load->view('includes/template', $data);
	}

	public function customer_visits()
{
    $this->load->model('Reports_model');
    $this->load->model('Customer_model');

    $from = $this->input->get('from') ?? date('Y-m-01');
    $to   = $this->input->get('to') ?? date('Y-m-d');
    $customer_id = $this->input->get('customer_id');

    $data['title'] = 'Customer Visit History';
    $data['from']  = $from;
    $data['to']    = $to;

    $data['customers'] = $this->Customer_model->get_all_customers();
    $data['visits'] = $this->Reports_model
                            ->get_customer_visit_history($from, $to, $customer_id);

    
	$data['main_content'] = 'reports/customer_visits';
		$this->load->view('includes/template', $data);
}

}
