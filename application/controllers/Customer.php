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
	// public function index()
	// {
	// 	$search = $this->input->get('search');

	// 	$data['customers'] = $this->Customer_model->get_all_customers($search);

	// 	$data['title'] = "Customers";
	// 	$data['main_content'] = 'customer/list_customers';
	// 	$this->load->view('includes/template', $data);
	// }


	public function index()
	{
		$data['customers'] = $this->Customer_model->filter_customers();
		$data['title'] = "Customers";
		$data['main_content'] = 'customer/list_customers';
		$this->load->view('includes/template', $data);
	}

	// 🔴 AJAX FILTER
	public function filter_ajax()
	{
		$filters = [
			'name'  => $this->input->post('name'),
			'phone' => $this->input->post('phone'),
			'plate' => $this->input->post('plate'),
			'vin'   => $this->input->post('vin')
		];

		$data['customers'] = $this->Customer_model->filter_customers($filters);

		$this->load->view('customer/_customer_rows', $data);
	}
	/* -------------------------------
       SHOW ADD FORM
    --------------------------------*/
	public function add()
	{
		$data['title'] = "Customers";
		$data['brands'] = $this->Vehicle_model->get_all_brands();
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
		$data['brands'] = $this->Vehicle_model->get_all_brands();
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
			'trn' => $this->input->post('trn'),
			'emirates' => $this->input->post('emirate'),
		];

		$this->db->trans_start();

		// 2️⃣ Insert Customer
		$customer_id = $this->Customer_model->insert_customer($customerData);

		// 3️⃣ Get Vehicle Inputs (arrays)
		$reg_no     = $this->input->post('vehicle_registration_no');
		$brand_ids  = $this->input->post('brand_id');
		$model_ids  = $this->input->post('model_id');
		$variant    = $this->input->post('vehicle_variant');
		$year       = $this->input->post('vehicle_year');
		$color      = $this->input->post('vehicle_color');
		$chassis_no = $this->input->post('vehicle_chassis_no');
		$engine_no  = $this->input->post('vehicle_engine_no');

		// 4️⃣ Loop and insert each vehicle
		for ($i = 0; $i < count($reg_no); $i++) {
			if (trim($reg_no[$i]) == "") continue; // skip empty rows


			// 🔹 Fetch Brand Name
			$brand = $this->Vehicle_model->get_brand_by_id($brand_ids[$i]);

			// 🔹 Fetch Model Name
			$model = $this->Vehicle_model->get_model_by_id($model_ids[$i]);

			$vehicleData = [
				'customer_id'    => $customer_id,
				'registration_no' => $reg_no[$i],
				// brand
				'brand_id'        => $brand_ids[$i],
				'brand'      => $brand ? $brand->brand_name : null,

				// model
				'model_id'        => $model_ids[$i],
				'model'      => $model ? $model->model_name : null,
				'variant'        => $variant[$i],
				'year'           => $year[$i],
				'color'          => $color[$i],
				'chassis_no'     => $chassis_no[$i],
				'engine_no'      => $engine_no[$i],
			];

			$this->Vehicle_model->insert_vehicle($vehicleData);
		}
		$this->db->trans_complete();
		// 5️⃣ Flash message + redirect
		$this->session->set_flashdata('success', 'Customer and vehicles added successfully!');
		redirect('customer');
	}

	/* -------------------------------
      Update 
    --------------------------------*/
	// public function update()
	// {
	// 	$customer_id = $this->input->post('customer_id');

	// 	// 1️⃣ UPDATE CUSTOMER
	// 	$customerData = [
	// 		'name'    => $this->input->post('name'),
	// 		'phone'   => $this->input->post('phone'),
	// 		'email'   => $this->input->post('email'),
	// 		'address' => $this->input->post('address'),
	// 	];

	// 	$this->Customer_model->update_customer($customer_id, $customerData);

	// 	// 2️⃣ DELETE VEHICLES (removed from UI)
	// 	$vehiclesToDelete = $this->input->post('vehicles_to_delete');
	// 	log_message('error', 'POST vehicles_to_delete: ' . print_r($this->input->post('vehicles_to_delete'), true));

	// 	if (!empty($vehiclesToDelete)) {
	// 		$deleteArray = json_decode($vehiclesToDelete, true);
	// 		if (is_array($deleteArray)) {
	// 			foreach ($deleteArray as $vid) {
	// 				$this->Vehicle_model->delete_vehicle($vid);
	// 			}
	// 		}
	// 	}

	// 	// 3️⃣ UPDATE EXISTING VEHICLES
	// 	$existing_ids    = $this->input->post('vehicle_id_existing');
	// 	$existing_reg    = $this->input->post('vehicle_registration_no_existing');
	// 	$existing_brand  = $this->input->post('vehicle_brand_existing');
	// 	$existing_model  = $this->input->post('vehicle_model_existing');
	// 	$existing_variant = $this->input->post('vehicle_variant_existing');
	// 	$existing_year   = $this->input->post('vehicle_year_existing');
	// 	$existing_color  = $this->input->post('vehicle_color_existing');
	// 	$existing_chassis = $this->input->post('vehicle_chassis_no_existing');
	// 	$existing_engine = $this->input->post('vehicle_engine_no_existing');

	// 	if (!empty($existing_ids)) {
	// 		for ($i = 0; $i < count($existing_ids); $i++) {

	// 			$vehicleData = [
	// 				'registration_no' => $existing_reg[$i],
	// 				'brand'           => $existing_brand[$i],
	// 				'model'           => $existing_model[$i],
	// 				'variant'         => $existing_variant[$i],
	// 				'year'            => $existing_year[$i],
	// 				'color'           => $existing_color[$i],
	// 				'chassis_no'      => $existing_chassis[$i],
	// 				'engine_no'       => $existing_engine[$i],
	// 			];

	// 			$this->Vehicle_model->update_vehicle($existing_ids[$i], $vehicleData);
	// 		}
	// 	}

	// 	// 4️⃣ INSERT NEW VEHICLES (added in UI)
	// 	$new_reg     = $this->input->post('vehicle_registration_no_new');
	// 	$new_brand   = $this->input->post('vehicle_brand_new');
	// 	$new_model   = $this->input->post('vehicle_model_new');
	// 	$new_variant = $this->input->post('vehicle_variant_new');
	// 	$new_year    = $this->input->post('vehicle_year_new');
	// 	$new_color   = $this->input->post('vehicle_color_new');
	// 	$new_chassis = $this->input->post('vehicle_chassis_no_new');
	// 	$new_engine  = $this->input->post('vehicle_engine_no_new');

	// 	if (!empty($new_reg)) {
	// 		for ($i = 0; $i < count($new_reg); $i++) {

	// 			if (trim($new_reg[$i]) == "") continue; // skip empty rows

	// 			$vehicleData = [
	// 				'customer_id'     => $customer_id,
	// 				'registration_no' => $new_reg[$i],
	// 				'brand'           => $new_brand[$i],
	// 				'model'           => $new_model[$i],
	// 				'variant'         => $new_variant[$i],
	// 				'year'            => $new_year[$i],
	// 				'color'           => $new_color[$i],
	// 				'chassis_no'      => $new_chassis[$i],
	// 				'engine_no'       => $new_engine[$i],
	// 			];

	// 			$this->Vehicle_model->insert_vehicle($vehicleData);
	// 		}
	// 	}

	// 	// 5️⃣ SUCCESS MESSAGE
	// 	$this->session->set_flashdata('success', 'Customer and vehicles updated successfully!');

	// 	redirect('customer');
	// }
	public function update()
	{
		$customer_id = $this->input->post('customer_id');

		/* =====================================================
       1️⃣ UPDATE CUSTOMER
       ===================================================== */
		$customerData = [
			'name'    => $this->input->post('name'),
			'phone'   => $this->input->post('phone'),
			'email'   => $this->input->post('email'),
			'address' => $this->input->post('address'),
			'trn' => $this->input->post('trn'),
			'emirates' => $this->input->post('emirate'),
		];

		$this->Customer_model->update_customer($customer_id, $customerData);

		/* =====================================================
       2️⃣ DELETE VEHICLES (REMOVED FROM UI)
       ===================================================== */
		$vehiclesToDelete = $this->input->post('vehicles_to_delete');

		if (!empty($vehiclesToDelete)) {
			$deleteArray = json_decode($vehiclesToDelete, true);
			if (is_array($deleteArray)) {
				foreach ($deleteArray as $vid) {
					$this->Vehicle_model->delete_vehicle($vid);
				}
			}
		}

		/* =====================================================
       3️⃣ UPDATE EXISTING VEHICLES
       ===================================================== */
		$existing_ids     = $this->input->post('vehicle_id_existing');
		$existing_reg     = $this->input->post('vehicle_registration_no_existing');
		$brand_ids_exist  = $this->input->post('brand_id_existing');
		$model_ids_exist  = $this->input->post('model_id_existing');
		$existing_variant = $this->input->post('vehicle_variant_existing');
		$existing_year    = $this->input->post('vehicle_year_existing');
		$existing_color   = $this->input->post('vehicle_color_existing');
		$existing_chassis = $this->input->post('vehicle_chassis_no_existing');
		$existing_engine  = $this->input->post('vehicle_engine_no_existing');

		if (!empty($existing_ids)) {
			for ($i = 0; $i < count($existing_ids); $i++) {

				// Fetch names securely from DB
				$brand = $this->Vehicle_model->get_brand_by_id($brand_ids_exist[$i]);
				$model = $this->Vehicle_model->get_model_by_id($model_ids_exist[$i]);

				$vehicleData = [
					'registration_no' => $existing_reg[$i],

					// Brand
					'brand_id'   => $brand_ids_exist[$i],
					'brand' => $brand ? $brand->brand_name : null,

					// Model
					'model_id'   => $model_ids_exist[$i],
					'model' => $model ? $model->model_name : null,

					'variant'    => $existing_variant[$i],
					'year'       => $existing_year[$i],
					'color'      => $existing_color[$i],
					'chassis_no' => $existing_chassis[$i],
					'engine_no'  => $existing_engine[$i],
				];

				$this->Vehicle_model->update_vehicle($existing_ids[$i], $vehicleData);
			}
		}

		/* =====================================================
       4️⃣ INSERT NEW VEHICLES
       ===================================================== */
		$new_reg     = $this->input->post('vehicle_registration_no_new');
		$brand_ids  = $this->input->post('brand_id_new');
		$model_ids  = $this->input->post('model_id_new');
		$new_variant = $this->input->post('vehicle_variant_new');
		$new_year    = $this->input->post('vehicle_year_new');
		$new_color   = $this->input->post('vehicle_color_new');
		$new_chassis = $this->input->post('vehicle_chassis_no_new');
		$new_engine  = $this->input->post('vehicle_engine_no_new');

		if (!empty($new_reg)) {
			for ($i = 0; $i < count($new_reg); $i++) {

				if (empty($new_reg[$i]) && empty($brand_ids[$i])) {
					continue;
				}

				$brand = $this->Vehicle_model->get_brand_by_id($brand_ids[$i]);
				$model = $this->Vehicle_model->get_model_by_id($model_ids[$i]);

				$vehicleData = [
					'customer_id'     => $customer_id,
					'registration_no' => $new_reg[$i],

					// Brand
					'brand_id'   => $brand_ids[$i],
					'brand' => $brand ? $brand->brand_name : null,

					// Model
					'model_id'   => $model_ids[$i],
					'model' => $model ? $model->model_name : null,

					'variant'    => $new_variant[$i],
					'year'       => $new_year[$i],
					'color'      => $new_color[$i],
					'chassis_no' => $new_chassis[$i],
					'engine_no'  => $new_engine[$i],
				];

				$this->Vehicle_model->insert_vehicle($vehicleData);
			}
		}

		/* =====================================================
       5️⃣ SUCCESS MESSAGE
       ===================================================== */
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
	// ================================================================================

	public function add_spot_popup()
	{
		$data['brands'] = $this->Vehicle_model->get_all_brands();
		$this->load->view('customer/add_customer_spot_popup', $data);
	}

	public function get_models_by_brand($brand_id)
	{
		$this->load->model('Vehicle_model');
		echo json_encode($this->Vehicle_model->get_models_by_brand($brand_id));
	}

	public function get_models_by_brand_edit($brand_id)
	{
		// Safety check
		if (!$brand_id) {
			echo json_encode([]);
			return;
		}

		$models = $this->Vehicle_model->get_models_by_brand($brand_id);

		// VERY IMPORTANT: return JSON only
		header('Content-Type: application/json');
		echo json_encode($models);
	}

	public function save_spot_ajax()
	{
		$this->db->trans_start();

		/* CUSTOMER */
		$customer = [
			'name'    => $this->input->post('name'),
			'phone'   => $this->input->post('phone'),
			'email'   => $this->input->post('email'),
			'address' => $this->input->post('address'),
			'emirates' => $this->input->post('emirate'),
		];
		$this->db->insert('customers', $customer);
		$customer_id = $this->db->insert_id();

		// =========================ledger entry
		$prifix = 'CUST';

		$digit = sprintf("%1$04d", $customer_id);
		$Code = $prifix . $digit;

		$grp_no = 30;
		$data1 = array(
			'account_name' => $this->input->post('name') . ' ' . $Code,
			'group_no' => $grp_no,
			'customer_id' => $customer_id,
			'opening_bal_type' => 'Dr',
		);
		$this->db->insert('general_ledger', $data1);
		// return $this->db->insert_id(); // return customer_id
		// =========================ledger entry
		$brand_id = $this->input->post('brand_id');
		$model_id = $this->input->post('model_id');

		/* Fetch brand name */
		$brand = $this->db
			->get_where('vehicle_brands', ['brand_id' => $brand_id])
			->row();

		/* Fetch model name */
		$model = $this->db
			->get_where('vehicle_models', ['model_id' => $model_id])
			->row();

		/* VEHICLE */
		$vehicle = [
			'customer_id'     => $customer_id,
			'registration_no' => $this->input->post('registration_no'),
			'brand_id'        => $this->input->post('brand_id'),
			'brand'      => $brand ? $brand->brand_name : null,
			'model_id'        => $this->input->post('model_id'),
			'model'      => $model ? $model->model_name : null,

		];

		$this->db->insert('vehicles', $vehicle);
		$vehicle_id = $this->db->insert_id();

		$this->db->trans_complete();

		// echo json_encode([
		// 	'status' => 'success',
		// 	'customer' => [
		// 		'customer_id' => $customer_id,
		// 		'name'  => $customer['name'],
		// 		'phone' => $customer['phone']
		// 	],
		// 	'vehicle' => [
		// 		'vehicle_id' => $vehicle_id,
		// 		'registration_no' => $vehicle['registration_no'],
		// 		'brand' => $vehicle['brand'],
		// 		'model' => $vehicle['model'],
		// 		'chassis_no' => $vehicle['chassis_no'],
		// 		'engine_no' => $vehicle['engine_no']
		// 	]
		// ]);

		echo json_encode([
			'status' => 'success',
			'customer' => [
				'customer_id' => $customer_id,
				'name' => $customer['name'],
				'phone' => $customer['phone']
			],
			'vehicle' => [
				'vehicle_id' => $vehicle_id,
				'registration_no' => $vehicle['registration_no'],
				'brand_name' => $this->db
					->get_where('vehicle_brands', ['brand_id' => $this->input->post('brand_id')])
					->row()->brand_name,
				'model_name' => $this->db
					->get_where('vehicle_models', ['model_id' => $this->input->post('model_id')])
					->row()->model_name,

			]
		]);
		exit;
	}

	// ======================== two functions for direct ledger creation page display and cretaion process =====================
	public function customers_to_ledger()
	{
		$data['title'] = "customers_to_ledger";
		$data['main_content'] = 'customer/customer_list_gl_create';
		$this->load->view('includes/template', $data);
	}


	public function sync_customers_to_ledger()
	{
		$result = $this->Customer_model->sync_customers_to_ledger();

		echo json_encode([
			'status'  => 'success',
			'message' => $result . ' customers added to General Ledger'
		]);
	}
	// ======================function to list customers who is not having ledger account ===
	public function create_customer_ledgers()
	{
	

		$count = $this->Customer_model->create_missing_customer_ledgers();

		echo $count . " customer ledger accounts created.";
	}
	public function check_customers_without_ledger()
	{


		// Get customers without ledger
		$data['customers'] = $this->Customer_model->get_customers_without_ledger();

		// Count
		$data['count'] = count($data['customers']);

		// Load view (recommended)
		// $this->load->view('ledger/customers_without_ledger', $data);

		// OR simple print for testing

		echo "<h3>Customers without ledger: " . $data['count'] . "</h3>";

		if ($data['count'] > 0) {
			echo "<pre>";
			print_r($data['customers']);
			echo "</pre>";
		} else {
			echo "All customers have ledger accounts.";
		}
	}
}
