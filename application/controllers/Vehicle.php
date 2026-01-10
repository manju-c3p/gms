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
	// =========================================================


	/* ===============================
       BRAND MASTER
       =============================== */

	public function brands()
	{
		$data['brands'] = $this->Vehicle_model->get_all_brands();
		$data['title'] = "Vehicles";
		$data['main_content'] = 'vehicle/brand_list';

		$this->load->view('includes/template', $data);
	
	}

	public function save_brand()
	{
		$brand_id   = $this->input->post('brand_id');
		$brand_name = $this->input->post('brand_name');

		if ($brand_id) {
			$this->Vehicle_model->update_brand($brand_id, [
				'brand_name' => $brand_name
			]);
		} else {
			$this->Vehicle_model->insert_brand([
				'brand_name' => $brand_name
			]);
		}

		redirect('Vehicle/brands');
	}

	public function delete_brand($id)
	{
		$this->Vehicle_model->delete_brand($id);
		redirect('Vehicle/brands');
	}

	/* ===============================
       MODEL MASTER
       =============================== */

	public function models()
	{
		$data['brands'] = $this->Vehicle_model->get_all_brands();
		$data['models'] = $this->Vehicle_model->get_all_models();

			$data['title'] = "Vehicles";
		$data['main_content'] = 'vehicle/model_list';

		$this->load->view('includes/template', $data);
	
	}

	public function save_model()
	{
		$model_id  = $this->input->post('model_id');
		$data = [
			'brand_id'   => $this->input->post('brand_id'),
			'model_name' => $this->input->post('model_name')
		];

		if ($model_id) {
			$this->Vehicle_model->update_model($model_id, $data);
		} else {
			$this->Vehicle_model->insert_model($data);
		}

		redirect('Vehicle/models');
	}

	public function delete_model($id)
	{
		$this->Vehicle_model->delete_model($id);
		redirect('Vehicle/models');
	}
}
