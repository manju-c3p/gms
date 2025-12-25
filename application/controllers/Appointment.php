<?php
class Appointment extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Appointment_model');
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
	}

	// List
	public function index()
	{
		$data['appointments'] = $this->Appointment_model->get_all_appointments();
		$data['title'] = "Appointments";
		$data['main_content'] = 'Appointment/appointment_list';
		$this->load->view('includes/template', $data);
	}

	// Add Form
	public function add()
	{
		$data['customers'] = $this->Customer_model->get_all_customers();
		$data['title'] = "Add Appointment";
		$data['main_content'] = 'appointment/add_appointment_form';
		$this->load->view('includes/template', $data);
	}



	// Save
	public function save()
	{
		$data = [
			'customer_id'       => $this->input->post('customer_id'),
			'vehicle_id'        => $this->input->post('vehicle_id'),
			'appointment_date'  => $this->input->post('appointment_date'),
			'appointment_time'  => $this->input->post('appointment_time'),
			'service_type'      => $this->input->post('appointment_type'),
			'notes'             => $this->input->post('notes'),
			'status'            => 'Pending'
		];

		// 👇 get appointment_id from model
		$appointment_id = $this->Appointment_model->add($data);

		// 🔴 Redirect to inspection with appointment_id
		redirect('inspection/create/' . $appointment_id);
	}

	// Edit Form


	public function edit($appointment_id)
	{
		$this->load->model("Customer_model");
		$this->load->model("Vehicle_model");
		$this->load->model("Appointment_model");

		$data['appointment'] = $this->Appointment_model->get_appointment($appointment_id);

		// For dropdowns
		$data['customers'] = $this->Customer_model->get_all_customers();
		$data['vehicles']  = $this->Vehicle_model->get_all_vehicles();

		$data['title'] = "Edit Appointment";
		$data['main_content'] = "appointment/appointment_edit_form";
		$this->load->view("includes/template", $data);
	}

	// Update
	public function update()
	{
		$id = $this->input->post('appointment_id');

		$data = [
			'customer_id'       => $this->input->post('customer_id'),
			'vehicle_id'        => $this->input->post('vehicle_id'),
			'appointment_date'  => $this->input->post('appointment_date'),
			'appointment_time'  => $this->input->post('appointment_time'),
			'service_type'      => $this->input->post('service_type'),
			'notes'             => $this->input->post('notes'),
			'status'            => $this->input->post('status'),
		];

		$this->Appointment_model->update_appointment($id, $data);

		$this->session->set_flashdata("success", "Appointment Updated Successfully");
		redirect("appointment");
	}

	// Delete
	public function delete($id)
	{
		$this->Appointment_model->delete($id);
		$this->session->set_flashdata('success', 'Appointment Deleted!');
		redirect('appointment');
	}

	public function getVehiclesByCustomer($customer_id)
	{
		$this->load->model('Vehicle_model');
		$vehicles = $this->Vehicle_model->get_vehicles_by_customerreg($customer_id);
		echo json_encode($vehicles);
	}

	// ================================================================================================

	public function reminders($days = 15)
	{
		$from = date('Y-m-d');
		$to   = date('Y-m-d', strtotime("+{$days} days"));

		$data['appointments'] = $this->Appointment_model->get_upcoming_appointments($from, $to);
		$data['main_content'] = 'appointment/appointment_reminder';
		$data['title'] = 'Upcoming Appointments & Reminders';
		$this->load->view('includes/template', $data);
	}

	public function send_reminder()
	{
		$appointment_id = $this->input->post('appointment_id');
		if (!$appointment_id) {
			echo json_encode(['status' => 'error', 'message' => 'Missing appointment id']);
			return;
		}

		$appointment = $this->Appointment_model->get_appointment($appointment_id);
		if (!$appointment) {
			echo json_encode(['status' => 'error', 'message' => 'Appointment not found']);
			return;
		}

		// Compose message
		$msg = "Reminder: Dear {$appointment->customer_name}, your vehicle ({$appointment->registration_no}) has an appointment on {$appointment->appointment_date}";
		if (!empty($appointment->appointment_time)) $msg .= " at {$appointment->appointment_time}";
		if (!empty($appointment->service_type)) $msg .= " for {$appointment->service_type}";
		$msg .= ". - Your Garage";

		// Try to send email if email configured
		$sent = false;
		if (!empty($appointment->customer_email)) {
			$this->load->library('email');
			// default config is used; configure in application/config/email.php
			$this->email->from('no-reply@yourgarage.local', 'Your Garage');
			$this->email->to($appointment->customer_email);
			$this->email->subject('Service Appointment Reminder');
			$this->email->message($msg);

			if (@$this->email->send()) {
				$sent = true;
			} else {
				// log email error (optional)
				log_message('error', 'Email send failed: ' . $this->email->print_debugger());
			}
		}

		// TODO: Place to call SMS gateway here if you have one:
		// $sms_sent = $this->sms_lib->send($appointment->customer_phone, $msg);

		// Fallback: if no email, log it and consider 'sent'
		if (!$sent) {
			log_message('info', "Reminder (logged): {$msg} (mobile: {$appointment->customer_phone})");
			$sent = true;
		}

		if ($sent) {
			// Mark reminder time
			$this->Appointment_model->mark_reminder_sent($appointment_id);
			echo json_encode(['status' => 'ok', 'message' => 'Reminder sent']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to send reminder']);
		}
	}

	// AJAX helper to return appointment details (json)
	public function get_details_ajax()
	{
		$appointment_id = $this->input->post('appointment_id');
		$a = $this->Appointment_model->get_appointment($appointment_id);
		if (!$a) {
			echo json_encode(['status' => 'error']);
		} else {
			echo json_encode(['status' => 'ok', 'data' => $a]);
		}
	}
}
