<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	/* -------------------------------
       LIST CUSTOMERS
    --------------------------------*/
	public function index()
	{
		$search = $this->input->get('search');

		$data['customers'] = $this->Customer_model->get_all_customers($search);

		$data['title'] = "Customers";
		$data['main_content'] = 'customer/list_customers';
		$this->load->view('includes/template', $data);
	}

	/* -------------------------------
       SHOW ADD FORM
    --------------------------------*/
	public function add()
	{
		$data['title'] = "Customers";
		$data['main_content'] = 'customer/add_customer';
		$this->load->view('includes/template', $data);
	}

	/* -------------------------------
       SHOW EDIT FORM
    --------------------------------*/
	public function edit($customer_id)
	{
		// Load customer data
		$data['customer'] = $this->Customer_model->get_customer($customer_id);

		// If customer not found
		if (!$data['customer']) {
			$this->session->set_flashdata('error', 'Customer not found!');
			redirect('customer/list');
		}

		// Load vehicles linked with this customer
		$data['vehicles'] = $this->Vehicle_model->get_vehicles_by_customer($customer_id);

		// Load the same form used for add
		// $this->load->view('customer_vehicle_form_edit', $data);

		$data['title'] = "Edit Customers";
		$data['main_content'] = 'customer/customer_vehicle_form_edit';
		$this->load->view('includes/template', $data);
	}


	/* -------------------------------
       SAVE 
    --------------------------------*/
	public function save()
	{
		// 1️⃣ Collect Customer Data
		$customerData = [
			'name'      => $this->input->post('name'),
			'phone'     => $this->input->post('phone'),
			'email'     => $this->input->post('email'),
			'address'   => $this->input->post('address'),
		];

		// 2️⃣ Insert Customer
		$customer_id = $this->Customer_model->insert_customer($customerData);

		// 3️⃣ Get Vehicle Inputs (arrays)
		$reg_no     = $this->input->post('vehicle_registration_no');
		$brand      = $this->input->post('vehicle_brand');
		$model      = $this->input->post('vehicle_model');
		$variant    = $this->input->post('vehicle_variant');
		$year       = $this->input->post('vehicle_year');
		$color      = $this->input->post('vehicle_color');
		$chassis_no = $this->input->post('vehicle_chassis_no');
		$engine_no  = $this->input->post('vehicle_engine_no');

		// 4️⃣ Loop and insert each vehicle
		for ($i = 0; $i < count($reg_no); $i++) {
			if (trim($reg_no[$i]) == "") continue; // skip empty rows

			$vehicleData = [
				'customer_id'    => $customer_id,
				'registration_no' => $reg_no[$i],
				'brand'          => $brand[$i],
				'model'          => $model[$i],
				'variant'        => $variant[$i],
				'year'           => $year[$i],
				'color'          => $color[$i],
				'chassis_no'     => $chassis_no[$i],
				'engine_no'      => $engine_no[$i],
			];

			$this->Vehicle_model->insert_vehicle($vehicleData);
		}

		// 5️⃣ Flash message + redirect
		$this->session->set_flashdata('success', 'Customer and vehicles added successfully!');
		redirect('customer');
	}

	/* -------------------------------
      Update 
    --------------------------------*/
	public function update()
	{
		$customer_id = $this->input->post('customer_id');

		// 1️⃣ UPDATE CUSTOMER
		$customerData = [
			'name'    => $this->input->post('name'),
			'phone'   => $this->input->post('phone'),
			'email'   => $this->input->post('email'),
			'address' => $this->input->post('address'),
		];

		$this->Customer_model->update_customer($customer_id, $customerData);

		// 2️⃣ DELETE VEHICLES (removed from UI)
		$vehiclesToDelete = $this->input->post('vehicles_to_delete');
		log_message('error', 'POST vehicles_to_delete: ' . print_r($this->input->post('vehicles_to_delete'), true));

		if (!empty($vehiclesToDelete)) {
			$deleteArray = json_decode($vehiclesToDelete, true);
			if (is_array($deleteArray)) {
				foreach ($deleteArray as $vid) {
					$this->Vehicle_model->delete_vehicle($vid);
				}
			}
		}

		// 3️⃣ UPDATE EXISTING VEHICLES
		$existing_ids    = $this->input->post('vehicle_id_existing');
		$existing_reg    = $this->input->post('vehicle_registration_no_existing');
		$existing_brand  = $this->input->post('vehicle_brand_existing');
		$existing_model  = $this->input->post('vehicle_model_existing');
		$existing_variant = $this->input->post('vehicle_variant_existing');
		$existing_year   = $this->input->post('vehicle_year_existing');
		$existing_color  = $this->input->post('vehicle_color_existing');
		$existing_chassis = $this->input->post('vehicle_chassis_no_existing');
		$existing_engine = $this->input->post('vehicle_engine_no_existing');

		if (!empty($existing_ids)) {
			for ($i = 0; $i < count($existing_ids); $i++) {

				$vehicleData = [
					'registration_no' => $existing_reg[$i],
					'brand'           => $existing_brand[$i],
					'model'           => $existing_model[$i],
					'variant'         => $existing_variant[$i],
					'year'            => $existing_year[$i],
					'color'           => $existing_color[$i],
					'chassis_no'      => $existing_chassis[$i],
					'engine_no'       => $existing_engine[$i],
				];

				$this->Vehicle_model->update_vehicle($existing_ids[$i], $vehicleData);
			}
		}

		// 4️⃣ INSERT NEW VEHICLES (added in UI)
		$new_reg     = $this->input->post('vehicle_registration_no_new');
		$new_brand   = $this->input->post('vehicle_brand_new');
		$new_model   = $this->input->post('vehicle_model_new');
		$new_variant = $this->input->post('vehicle_variant_new');
		$new_year    = $this->input->post('vehicle_year_new');
		$new_color   = $this->input->post('vehicle_color_new');
		$new_chassis = $this->input->post('vehicle_chassis_no_new');
		$new_engine  = $this->input->post('vehicle_engine_no_new');

		if (!empty($new_reg)) {
			for ($i = 0; $i < count($new_reg); $i++) {

				if (trim($new_reg[$i]) == "") continue; // skip empty rows

				$vehicleData = [
					'customer_id'     => $customer_id,
					'registration_no' => $new_reg[$i],
					'brand'           => $new_brand[$i],
					'model'           => $new_model[$i],
					'variant'         => $new_variant[$i],
					'year'            => $new_year[$i],
					'color'           => $new_color[$i],
					'chassis_no'      => $new_chassis[$i],
					'engine_no'       => $new_engine[$i],
				];

				$this->Vehicle_model->insert_vehicle($vehicleData);
			}
		}

		// 5️⃣ SUCCESS MESSAGE
		$this->session->set_flashdata('success', 'Customer and vehicles updated successfully!');

		redirect('customer');
	}


	/* -------------------------------
       DELETE CUSTOMER
    --------------------------------*/
	public function delete($customer_id)
	{
		$this->Customer_model->delete_customer($customer_id);
		$this->session->set_flashdata('success', 'Customer deleted successfully!');
		redirect('customer');
	}
}
