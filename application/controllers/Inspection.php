<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inspection extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('upload');
		$this->load->model([
			'Inspection_model',
			'Inspection_view_model',
			'Works_requested_model',
			'Inventory_status_model',
			'Service_model',
			'Customer_model',
			'Vehicle_model'
		]);
	}

	// Create inspection from appointment
	public function create($appointment_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		// Prevent duplicate inspection
		$existing = $this->Inspection_view_model->get_by_appointment($appointment_id);
		if ($existing) {
			// log_message("error","from create");
			// redirect('inspection/view/' . $existing->inspection_id);

			redirect('inspection/edit/' . $existing->inspection_id);
		}

		// Get appointment + customer + vehicle
		$appointment = $this->Inspection_view_model->get_appointment_details($appointment_id);
		if (!$appointment) show_404();

		// Create inspection record (DRAFT)
		$inspection_id = $this->Inspection_view_model->create_inspection([
			'appointment_id'  => $appointment_id,
			'customer_id'     => $appointment->customer_id,
			'vehicle_id'      => $appointment->vehicle_id,
			'inspection_date' => date('Y-m-d'),
			'inspection_time' => date('H:i:s'),
			// 'km_reading'      => $appointment->km ?? 0,
			'status'          => 'Draft'
		]);
		$data['services'] = $this->Service_model->get_active_services();
		// Load masters
		$data['inspection_id'] = $inspection_id;
		$data['appointment']   = $appointment;
		$data['items']         = $this->Inspection_model->get_all_items();
		$data['works']         = $this->Works_requested_model->get_all();
		$data['inventory']     = $this->Inventory_status_model->get_all();
		$data['packages']     = $this->Inspection_model->get_all_packageitems();
		$data['title'] = "Inspection Report";
		$data['main_content'] = 'inspection/create';
		$this->load->view('includes/template', $data);
	}

	// normal Save inspection

	// public function save()
	// {
	// 	$inspection_id = $this->input->post('inspection_id');
	// 	   $create_revision = $this->input->post('create_revision');

	// 	if (!$inspection_id) {
	// 		show_error('Invalid Inspection');
	// 	}

	// 	// 1️⃣ Update main inspection table
	// 	$inspectionData = [
	// 		'km_reading'    => $this->input->post('km_reading'),
	// 		'fuel_level'    => $this->input->post('fuel_level'),
	// 		'remarks'       => $this->input->post('remarks'),
	// 		'status'        => 'Completed',
	// 		'drivername'     => $this->input->post('driver_name'),
	// 		'driverphno' => $this->input->post('driver_mobile'),
	// 		'deliverytime' => $this->input->post('delivery_time'),
	// 		'deliverydate'       => $this->input->post('delivery_date'),
	// 		'techremarks'       => $this->input->post('tecremarks'),
	// 		'inspackage'       => $this->input->post('inspackage'),
	// 	];

	// 	$this->Inspection_model->update_inspection($inspection_id, $inspectionData);

	// 	// 2️⃣ Save Inspection Items (A / C / S)
	// 	if ($this->input->post('item_status')) {
	// 		foreach ($this->input->post('item_status') as $item_id => $status) {
	// 			$this->Inspection_model->save_item_result(
	// 				$inspection_id,
	// 				$item_id,
	// 				$status
	// 			);
	// 		}
	// 	}

	// 	// 3️⃣ Save Services / Description table
	// 	$service_ids     = $this->input->post('service_id') ?? [];
	// 	$custom_services = $this->input->post('custom_service') ?? [];

	// 	$this->Inspection_model->save_inspection_services(
	// 		$inspection_id,
	// 		$service_ids,
	// 		$custom_services
	// 	);

	// 	// 4️⃣ Save Works Requested
	// 	$works = $this->input->post('works_requested') ?? [];
	// 	$this->Inspection_model->save_works_requested($inspection_id, $works);

	// 	// 5️⃣ Save Inventory Status
	// 	$inventory = $this->input->post('inventory_status') ?? [];
	// 	$this->Inspection_model->save_inventory_status($inspection_id, $inventory);

	// 	// inspection photos

	// 	$this->Inspection_model->save_inspection_photos(
	// 		$inspection_id,
	// 		$_FILES['inspection_photos']
	// 	);


	// 	// 6️⃣ Redirect to inspection view / preview
	// 	redirect('inspection/edit/' . $inspection_id);
	// 	// redirect('estimation/create/' . $inspection_id);
	// }
	// save with revision
	// public function save()
	// {
	// 	$inspection_id    = $this->input->post('inspection_id');
	// 	$create_revision  = $this->input->post('create_revision');

	// 	if (!$inspection_id) {
	// 		show_error('Invalid Inspection');
	// 	}

	// 	// Prepare data
	// 	$inspectionData = [
	// 		'km_reading'   => $this->input->post('km_reading'),
	// 		'fuel_level'   => $this->input->post('fuel_level'),
	// 		'remarks'      => $this->input->post('remarks'),
	// 		'status'       => 'Completed',
	// 		'drivername'   => $this->input->post('driver_name'),
	// 		'driverphno'   => $this->input->post('driver_mobile'),
	// 		'deliverytime' => $this->input->post('delivery_time'),
	// 		'deliverydate' => $this->input->post('delivery_date'),
	// 		'techremarks'  => $this->input->post('tecremarks'),
	// 		'inspackage'   => $this->input->post('inspackage'),
	// 		'updated_at'   => date('Y-m-d H:i:s')
	// 	];

	// 	// ============================================================
	// 	// REVISION MODE
	// 	// ============================================================
	// 	if ($create_revision) {
	// 		// 1️⃣ Get original inspection
	// 		$original = $this->Inspection_view_model->get_by_inspection($inspection_id);

	// 		// 2️⃣ Find next revision number
	// 		$next_revision = $this->Inspection_view_model->get_next_revision_no($inspection_id);

	// 		// 3️⃣ Prepare revision data
	// 		$revisionData = array_merge((array)$original, $inspectionData);

	// 		unset($revisionData['inspection_id']); // remove PK

	// 		$revisionData['parent_inspection_id'] = $inspection_id;
	// 		$revisionData['revision_no']          = $next_revision;
	// 		$revisionData['is_revision']         = 1;
	// 		$revisionData['created_at']          = date('Y-m-d H:i:s');

	// 		// 4️⃣ Insert revision
	// 		$new_inspection_id = $this->Inspection_view_model->insert_inspection($revisionData);

	// 		// 5️⃣ Copy child tables
	// 		$this->Inspection_view_model->copy_items($inspection_id, $new_inspection_id);
	// 		$this->Inspection_view_model->copy_services($inspection_id, $new_inspection_id);
	// 		$this->Inspection_view_model->copy_inventory($inspection_id, $new_inspection_id);
	// 		$this->Inspection_view_model->copy_photos($inspection_id, $new_inspection_id);
	// 		$this->Inspection_view_model->copy_damage_marks($inspection_id, $new_inspection_id);

	// 		$inspection_id = $new_inspection_id;
	// 	} else {
	// 		// NORMAL UPDATE
	// 		$this->Inspection_model->update_inspection($inspection_id, $inspectionData);
	// 	}

	// 	// ============================================================
	// 	// SAVE CHILD TABLES (for revision or update)
	// 	// ============================================================

	// 	if ($this->input->post('item_status')) {
	// 		foreach ($this->input->post('item_status') as $item_id => $status) {
	// 			$this->Inspection_model->save_item_result(
	// 				$inspection_id,
	// 				$item_id,
	// 				$status
	// 			);
	// 		}
	// 	}

	// 	$service_ids     = $this->input->post('service_id') ?? [];
	// 	$custom_services = $this->input->post('custom_service') ?? [];

	// 	$this->Inspection_model->save_inspection_services(
	// 		$inspection_id,
	// 		$service_ids,
	// 		$custom_services
	// 	);

	// 	$works = $this->input->post('works_requested') ?? [];
	// 	$this->Inspection_model->save_works_requested($inspection_id, $works);

	// 	$inventory = $this->input->post('inventory_status') ?? [];
	// 	$this->Inspection_model->save_inventory_status($inspection_id, $inventory);

	// 	$this->Inspection_model->save_inspection_photos(
	// 		$inspection_id,
	// 		$_FILES['inspection_photos']
	// 	);

	// 	redirect('inspection/edit/' . $inspection_id);
	// }
public function save()
{
    $inspection_id    = $this->input->post('inspection_id');
    $create_revision  = $this->input->post('create_revision');

    if (!$inspection_id) {
        show_error('Invalid Inspection');
    }

    /* ============================================================
    1️⃣ GET ORIGINAL INSPECTION
    ============================================================ */

    $original = $this->Inspection_view_model
        ->get_by_inspection($inspection_id);

    if (!$original) {
        show_error('Inspection not found');
    }

    /* ============================================================
    2️⃣ PREPARE DATA FROM FORM (POST DATA)
    ============================================================ */

    $inspectionData = [

        'km_reading'   => $this->input->post('km_reading'),
        'fuel_level'   => $this->input->post('fuel_level'),
        'remarks'      => $this->input->post('remarks'),

        'status'       => 'Completed',

        'drivername'   => $this->input->post('driver_name'),
        'driverphno'   => $this->input->post('driver_mobile'),

        'deliverytime' => $this->input->post('delivery_time'),
        'deliverydate' => $this->input->post('delivery_date'),

        'techremarks'  => $this->input->post('tecremarks'),
        'inspackage'   => $this->input->post('inspackage'),

        'updated_at'   => date('Y-m-d H:i:s')

    ];


    /* ============================================================
    3️⃣ REVISION MODE
    ============================================================ */

    if ($create_revision)
    {

        // determine parent
        $parent_id = $original->parent_inspection_id
            ? $original->parent_inspection_id
            : $original->inspection_id;


        // get next revision number
        $max_revision = $this->db
            ->select_max('revision_no')
            ->where("(inspection_id = $parent_id OR parent_inspection_id = $parent_id)")
            ->get('inspections')
            ->row()
            ->revision_no;

        $new_revision_no = ($max_revision !== null)
            ? $max_revision + 1
            : 1;


        // insert NEW inspection revision
        $revisionData = array_merge($inspectionData, [

            'appointment_id' => $original->appointment_id,
            'customer_id'    => $original->customer_id,
            'vehicle_id'     => $original->vehicle_id,

            'parent_inspection_id' => $parent_id,
            'revision_no'          => $new_revision_no,
            'is_revision'          => 1,

            'inspection_date' => date('Y-m-d'),
            'inspection_time' => date('H:i:s'),

            'created_at'      => date('Y-m-d H:i:s')

        ]);


        $this->db->insert('inspections', $revisionData);

        // IMPORTANT: switch to new revision id
        $inspection_id = $this->db->insert_id();

    }
    else
    {

        // NORMAL UPDATE
        $this->Inspection_model
            ->update_inspection($inspection_id, $inspectionData);


        // delete old child rows before saving new ones
        $this->Inspection_model->delete_item_results($inspection_id);
        $this->Inspection_model->delete_services($inspection_id);
        $this->Inspection_model->delete_inventory_status($inspection_id);
        $this->Inspection_model->delete_works_requested($inspection_id);
		$this->Inspection_model->delete_photos($inspection_id);

    }


    /* ============================================================
    4️⃣ SAVE CHILD TABLES (POST DATA ONLY)
    ============================================================ */

    // ITEMS
    if ($this->input->post('item_status'))
    {
        foreach ($this->input->post('item_status') as $item_id => $status)
        {
            $this->Inspection_model->save_item_result(
                $inspection_id,
                $item_id,
                $status
            );
        }
    }


    // SERVICES
    $service_ids     = $this->input->post('service_id') ?? [];
    $custom_services = $this->input->post('custom_service') ?? [];

    $this->Inspection_model->save_inspection_services(
        $inspection_id,
        $service_ids,
        $custom_services
    );


    // WORKS REQUESTED
    $works = $this->input->post('works_requested') ?? [];

    $this->Inspection_model->save_works_requested(
        $inspection_id,
        $works
    );


    // INVENTORY
    $inventory = $this->input->post('inventory_status') ?? [];

    $this->Inspection_model->save_inventory_status(
        $inspection_id,
        $inventory
    );


    // PHOTOS
    if (!empty($_FILES['inspection_photos']['name'][0]))
    {
        $this->Inspection_model->save_inspection_photos(
            $inspection_id,
            $_FILES['inspection_photos']
        );
    }


    /* ============================================================
    5️⃣ REDIRECT
    ============================================================ */

    redirect('inspection/edit/' . $inspection_id);

}
	public function update()
	{
		$inspection_id = $this->input->post('inspection_id');

		if (!$inspection_id) {
			show_error('Invalid Inspection');
		}

		// 1️⃣ Update main inspection table
		$inspectionData = [
			'km_reading'    => $this->input->post('km_reading'),
			'fuel_level'    => $this->input->post('fuel_level'),
			'remarks'       => $this->input->post('remarks'),
			'status'        => 'Completed',
			'drivername'     => $this->input->post('driver_name'),
			'driverphno' => $this->input->post('driver_mobile'),
			'deliverytime' => $this->input->post('delivery_time'),
			'deliverydate'       => $this->input->post('delivery_date'),
			'techremarks'       => $this->input->post('tecremarks'),
			'inspackage'       => $this->input->post('inspackage'),
		];

		$this->Inspection_model->update_inspection($inspection_id, $inspectionData);

		// 2️⃣ Save Inspection Items (A / C / S)
		if ($this->input->post('item_status')) {
			foreach ($this->input->post('item_status') as $item_id => $status) {
				$this->Inspection_model->save_item_result(
					$inspection_id,
					$item_id,
					$status
				);
			}
		}

		// 3️⃣ Save Services / Description table
		$service_ids     = $this->input->post('service_id') ?? [];
		$custom_services = $this->input->post('custom_service') ?? [];

		$this->Inspection_model->save_inspection_services(
			$inspection_id,
			$service_ids,
			$custom_services
		);

		// 4️⃣ Save Works Requested
		$works = $this->input->post('works_requested') ?? [];
		$this->Inspection_model->save_works_requested($inspection_id, $works);

		// 5️⃣ Save Inventory Status
		$inventory = $this->input->post('inventory_status') ?? [];
		$this->Inspection_model->save_inventory_status($inspection_id, $inventory);

		// inspection photos

		$this->Inspection_model->save_inspection_photos(
			$inspection_id,
			$_FILES['inspection_photos']
		);


		// 6️⃣ Redirect to inspection view / preview
		redirect('inspection/edit/' . $inspection_id);
		// redirect('estimation/create/' . $inspection_id);
	}



	public function saveDamageMark()
	{
		$data = json_decode(file_get_contents("php://input"), true);

		$insert = [
			'inspection_id' => $data['inspection_id'],
			'x_coordinate'  => $data['x'],
			'y_coordinate'  => $data['y']
		];

		$this->db->insert('inspection_damage_marks', $insert);

		echo json_encode([
			'id' => $this->db->insert_id()
		]);
	}
	public function deleteDamageMark()
	{
		$data = json_decode(file_get_contents("php://input"), true);

		$this->db->where('id', $data['id'])
			->delete('inspection_damage_marks');

		echo json_encode(['success' => true]);
	}

	public function edit($inspection_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		// Get inspection
		$inspection = $this->Inspection_model->get_by_id($inspection_id);
		// 🔐 Safety check
		if (!$inspection) {
			show_error('Inspection not found', 404);
		}

		// Appointment based inspection
		if (!empty($inspection->appointment_id)) {

			// log_message('error', 'FLOW: Appointment based inspection');
			// log_message('error', 'Appointment ID: ' . $inspection->appointment_id);

			$appointment = $this->Inspection_view_model
				->get_appointment_details($inspection->appointment_id);
			// log_message('error', 'APPOINTMENT DATA: ' . print_r($appointment, true));
			// Extra safety (appointment deleted case)
			if ($appointment) {
				$customer = $this->Customer_model
					->get_customer($appointment->customer_id);
				// log_message('error', 'CUSTOMER DATA: ' . print_r($customer, true));
				$vehicle = $this->Vehicle_model
					->get_vehicle($appointment->vehicle_id);
				// log_message('error', 'VEHICLE DATA: ' . print_r($vehicle, true));
			} else {

				// log_message('error', 'Appointment NOT FOUND for appointment_id: ' . $inspection->appointment_id);
				$customer = null;
				$vehicle  = null;
				$appointment = null;
			}
		} else {
			// log_message('error', 'FLOW: Direct inspection (NO appointment)');

			if (!empty($inspection->customer_id)) {
				// log_message('error', 'Fetching CUSTOMER from inspection: ' . $inspection->customer_id);
				$customer = $this->Customer_model->get_customer($inspection->customer_id);
				// log_message('error', 'CUSTOMER DATA: ' . print_r($customer, true));
			} else {
				// log_message('error', 'Inspection customer_id is EMPTY');
				$customer = null;
			}

			if (!empty($inspection->vehicle_id)) {
				// log_message('error', 'Fetching VEHICLE from inspection: ' . $inspection->vehicle_id);
				$vehicle = $this->Vehicle_model->get_vehicle($inspection->vehicle_id);
				// log_message('error', 'VEHICLE DATA: ' . print_r($vehicle, true));
			} else {
				// log_message('error', 'Inspection vehicle_id is EMPTY');
				$vehicle = null;
			}

			$appointment = null;
		}


		$data['inspection_photos'] = $this->db
			->get_where('inspection_photos', [
				'inspection_id' => $inspection_id
			])->result();

		// Load saved data
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;
		$data['inspection']      = $inspection;
		$data['inspection_id']   = $inspection_id;
		$data['appointment']     = $appointment;

		// Masters
		$data['items']     = $this->Inspection_model->get_all_items();
		$data['works']     = $this->Works_requested_model->get_all();
		$data['inventory'] = $this->Inventory_status_model->get_all();
		$data['services']  = $this->Service_model->get_active_services();
		$data['packages']     = $this->Inspection_model->get_all_packageitems();

		$service_map = [];
		foreach ($data['services'] as $s) {
			$service_map[$s->master_service_id] = $s->service_name;
		}

		$data['service_map'] = $service_map;

		// Saved values
		$data['item_results'] = $this->Inspection_model
			->get_item_results($inspection_id);

		$data['selected_works'] = $this->Inspection_model
			->get_selected_works($inspection_id);

		$data['selected_inventory'] = $this->Inspection_model
			->get_selected_inventory($inspection_id);

		$data['saved_services'] = $this->Inspection_model
			->get_saved_services($inspection_id);

		$data['damage_marks'] = $this->Inspection_model
			->get_damage_marks($inspection_id);

		$data['title'] = "Edit Inspection";
		$data['main_content'] = 'inspection/edit';
		$this->load->view('includes/template', $data);
	}

	public function view($inspection_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		// Get inspection
		$inspection = $this->Inspection_model->get_by_id($inspection_id);
		if (!$inspection) show_404();


		if ($inspection->appointment_id <> "") {
			// Get appointment details
			$appointment = $this->Inspection_view_model
				->get_appointment_details($inspection->appointment_id);

			// Customer & Vehicle from appointment
			$customer = $this->Customer_model
				->get_customer($appointment->customer_id);

			$vehicle = $this->Vehicle_model
				->get_vehicle($appointment->vehicle_id);
		} else {

			// ✅ Direct inspection (NO appointment)

			// Customer from inspection
			$customer = $this->Customer_model
				->get_customer($inspection->customer_id);

			// Vehicle from inspection
			$vehicle = $this->Vehicle_model
				->get_vehicle($inspection->vehicle_id);

			// Appointment is NULL
			$appointment = null;
		}

		// Load saved data
		$data['customer']      = $customer;
		$data['vehicle']      = $vehicle;
		$data['inspection']      = $inspection;
		$data['inspection_id']   = $inspection_id;
		$data['appointment']     = $appointment;

		// Masters
		$data['items']     = $this->Inspection_model->get_all_items();
		$data['works']     = $this->Works_requested_model->get_all();
		$data['inventory'] = $this->Inventory_status_model->get_all();
		$data['services']  = $this->Service_model->get_active_services();
		$data['packages']     = $this->Inspection_model->get_all_packageitems();

		$service_map = [];
		foreach ($data['services'] as $s) {
			$service_map[$s->master_service_id] = $s->service_name;
		}

		$data['service_map'] = $service_map;

		// Saved values
		$data['item_results'] = $this->Inspection_model
			->get_item_results($inspection_id);

		$data['selected_works'] = $this->Inspection_model
			->get_selected_works($inspection_id);

		$data['selected_inventory'] = $this->Inspection_model
			->get_selected_inventory($inspection_id);

		$data['saved_services'] = $this->Inspection_model
			->get_saved_services($inspection_id);

		$data['damage_marks'] = $this->Inspection_model
			->get_damage_marks($inspection_id);

		$data['inspection_photos'] = $this->db
			->get_where('inspection_photos', [
				'inspection_id' => $inspection_id
			])->result();

		// $data['title'] = "View Inspection";
		$data['title'] =
			'Inspection_' .
			($appointment->doc_no ?? ('VIN-' . str_pad($inspection_id, 6, '0', STR_PAD_LEFT))) . '_' .
			preg_replace('/[^A-Za-z0-9\-]/', '_', $appointment->registration_no ?? $vehicle->registration_no ?? '') . '_' .
			preg_replace('/[^A-Za-z0-9\-]/', '_', $appointment->customer_name ?? $customer->name ?? '') . '_' .
			date('d-m-Y');


		$data['main_content'] = 'inspection/view';
		$this->load->view('includes/template', $data);
	}

	/**
	 * Inspection listing page
	 */
	public function index()
	{
		$data['title'] = 'Inspection List';
		$data['customers'] = $this->Customer_model->get_all();
		$data['vehicles']    = $this->Vehicle_model->get_all_vehicles();

		$data['inspections'] = $this->Inspection_model->get_all_inspections();

		$data['main_content'] = 'inspection/list';
		$this->load->view('includes/template', $data);
	}

	/**
	 * Delete inspection
	 */
	public function delete($inspection_id)
	{
		$this->Inspection_model->delete_inspection($inspection_id);
		redirect('inspection');
	}

	public function deletePhoto()
	{
		$data = json_decode(file_get_contents("php://input"), true);
		$photo_id = $data['photo_id'];

		$photo = $this->db
			->get_where('inspection_photos', ['photo_id' => $photo_id])
			->row();

		if ($photo) {

			if (file_exists(FCPATH . $photo->image_path)) {
				unlink(FCPATH . $photo->image_path);
			}

			$this->db->delete('inspection_photos', [
				'photo_id' => $photo_id
			]);

			echo json_encode(['success' => true]);
			return;
		}

		echo json_encode(['success' => false]);
	}
	// =========================== not needed fns =================
	public function chkindex()
	{
		$data['title'] = 'Inspection List';


		$data['main_content'] = 'inspection/chk';
		$this->load->view('includes/template', $data);
	}

	public function check_mobile()
	{
		$mobile = $this->input->post('mobile');

		// Validate mobile
		// if (!preg_match('/^[6-9]\d{9}$/', $mobile)) {
		// 	$this->session->set_flashdata('error', 'Invalid mobile number');
		// 	redirect('inspection');
		// }

		// Check customer
		$customer = $this->Customer_model->getCustomerByMobile($mobile);

		// 🔵 CASE 1: CUSTOMER NOT FOUND
		if (!$customer) {

			$this->session->set_flashdata('walkin_mobile', $mobile);
			$this->session->set_flashdata('show_quick_form', true);
			$this->session->set_flashdata(
				'info',
				'Customer not found. Please add customer details to continue inspection.'
			);

			redirect('inspection'); // listing / dashboard page
		}

		// 🟢 CASE 2: CUSTOMER FOUND
		$vehicles = $this->Vehicle_model->getVehiclesByCustomer($customer->customer_id);

		$this->session->set_flashdata('customer_popup', [
			'customer' => $customer,
			'vehicles' => $vehicles
		]);

		redirect('inspection');
	}

	public function save_walkin_customer()
	{
		$customer_id = $this->Customer_model->create([
			'customer_name' => $this->input->post('name'),
			'mobile'        => $this->input->post('phone')
		]);

		$vehicle_id = $this->Vehicle_model->create([
			'customer_id' => $customer_id,
			'vehicle_no'  => $this->input->post('registration_no'),
			'model'       => $this->input->post('model')
		]);

		redirect('inspection/create?customer_id=' . $customer_id . '&vehicle_id=' . $vehicle_id . '&source=WALKIN');
	}
	// =========================== not needed fns =================
	// ===========================================direct inspection ==================
	public function create_direct()
	{
		$this->load->model('Inspection_model');
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');

		$customer_id = $this->input->post('customer_id');
		$vehicle_id  = $this->input->post('vehicle_id');

		/* ===============================
       1️⃣ CREATE CUSTOMER (IF NEW)
       =============================== */
		if ($customer_id === 'new') {

			$cust_name  = $this->input->post('cust_name');
			$cust_phone = $this->input->post('cust_phone');

			if (!$cust_name || !$cust_phone) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Customer name and phone are required'
				]);
				return;
			}

			$customer_id = $this->Customer_model->create([
				'name' => $cust_name,
				'phone' => $cust_phone,
				'email' => $this->input->post('cust_email'),
				'address' => $this->input->post('cust_address')
			]);
		}

		if (!$customer_id) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Customer required'
			]);
			return;
		}

		/* ===============================
       2️⃣ CREATE VEHICLE (IF NEEDED)
       =============================== */
		if (!$vehicle_id) {

			$plate_no = $this->input->post('plate_no');
			$brand    = $this->input->post('brand');
			$model    = $this->input->post('model');

			if (!$plate_no || !$brand || !$model) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Vehicle details are required'
				]);
				return;
			}

			$vehicle_id = $this->Vehicle_model->create([
				'customer_id' => $customer_id,
				'registration_no'    => $plate_no,
				'brand'       => $brand,
				'model'       => $model,
				'chassis_no'      => $this->input->post('vin_no')
			]);
		}

		/* ===============================
       3️⃣ CREATE INSPECTION
       =============================== */
		$inspection_id = $this->Inspection_model->create([
			'customer_id'     => $customer_id,
			'vehicle_id'      => $vehicle_id,
			'appointment_id'  => NULL, // direct inspection
			'inspection_date' => date('Y-m-d'),
			'status'          => 'IN_PROGRESS'
		]);

		echo json_encode([
			'status' => 'success',
			'inspection_id' => $inspection_id
		]);
	}

	public function get_customer_vehicles()
	{
		$customer_id = $this->input->post('customer_id');

		if (!$customer_id) {
			echo json_encode([]);
			return;
		}

		$vehicles = $this->db
			->select('vehicle_id, registration_no, brand, model, chassis_no')
			->where('customer_id', $customer_id)
			->order_by('vehicle_id', 'DESC')
			->get('vehicles')
			->result();

		echo json_encode($vehicles);
	}

	public function get_by_chassis()
	{
		$chassis = $this->input->post('chassis_no');

		$data = $this->db
			->select('v.*, c.customer_id')
			->from('vehicles v')
			->join('customers c', 'c.customer_id = v.customer_id')
			->where('v.chassis_no', $chassis)
			->get()
			->row();

		echo json_encode($data);
	}

	public function get_by_plateno()
	{
		$plate_no = $this->input->post('plate_no');

		$data = $this->db
			->select('v.*, c.customer_id')
			->from('vehicles v')
			->join('customers c', 'c.customer_id = v.customer_id')
			->where('v.registration_no', $plate_no)
			->get()
			->row();

		echo json_encode($data);
	}
}
