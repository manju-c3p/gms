<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vehicle extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function list1()
	{
		$search = $this->input->get('search');
		$data['vehicles'] = $this->Vehicle_model->get_all_vehicles($search);



		$data['title'] = "Vehicles";
		$data['main_content'] = 'vehicle/vehicle_list';
		$this->load->view('includes/template', $data);
	}

	public function listnew()
	{
		// Load all customers
		$customers = $this->Customer_model->get_all_customers();

		// Load vehicles for each customer
		foreach ($customers as $c) {
			$c->vehicles = $this->Vehicle_model->get_vehicles_by_customer($c->customer_id);
		}

		$data['customers'] = $customers;

		$data['title'] = "Vehicles";
		$data['main_content'] = 'vehicle/vehicle_list';
		$this->load->view('includes/template', $data);
	}

	public function list()
	{
		$this->load->model('Vehicle_model');

		$data['rows'] = $this->Vehicle_model->get_all_flat();

		$data['title'] = "Vehicles";
		$data['main_content'] = 'vehicle/vehicle_list_flat';

		$this->load->view('includes/template', $data);
	}
}
