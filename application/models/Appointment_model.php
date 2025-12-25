<?php
class Appointment_model extends CI_Model
{

	public function add($data)
	{
		$this->db->insert('appointments', $data);
    return $this->db->insert_id(); // 👈 return appointment_id
	}

	public function update($id, $data)
	{
		return $this->db->where('appointment_id', $id)
			->update('appointments', $data);
	}

	public function delete($id)
	{
		return $this->db->delete('appointments', ['appointment_id' => $id]);
	}

	public function get_all()
	{
		$this->db->select('appointments.*, customers.name, vehicles.registration_no');
		$this->db->from('appointments');
		$this->db->join('customers', 'customers.customer_id = appointments.customer_id');
		$this->db->join('vehicles', 'vehicles.vehicle_id = appointments.vehicle_id');
		$this->db->order_by('appointment_date', 'DESC');
		return $this->db->get()->result();
	}

	public function get($id)
	{
		$this->db->select('appointments.*, customers.name, vehicles.registration_no');
		$this->db->from('appointments');
		$this->db->join('customers', 'customers.customer_id = appointments.customer_id');
		$this->db->join('vehicles', 'vehicles.vehicle_id = appointments.vehicle_id');
		$this->db->where('appointment_id', $id);
		return $this->db->get()->row();
	}
	public function get_all_appointments()
	{
		$this->db->select("
            appointments.*,
            customers.name AS customer_name,
            vehicles.registration_no
        ");
		$this->db->from("appointments");
		$this->db->join("customers", "customers.customer_id = appointments.customer_id");
		$this->db->join("vehicles", "vehicles.vehicle_id = appointments.vehicle_id");
		$this->db->order_by("appointments.appointment_date", "DESC");

		return $this->db->get()->result();
	}

	//  public function get_appointment($appointment_id)
	// {
	//     $this->db->select("
	//         appointments.*,
	//         customers.name AS customer_name,
	//         vehicles.registration_no
	//     ");
	//     $this->db->from("appointments");
	//     $this->db->join("customers", "customers.customer_id = appointments.customer_id");
	//     $this->db->join("vehicles", "vehicles.vehicle_id = appointments.vehicle_id");
	//     $this->db->where("appointments.appointment_id", $appointment_id);

	//     return $this->db->get()->row();
	// }
	public function get_appointment($appointment_id)
	{
		$this->db->select("
        appointments.*,
        customers.name AS customer_name,
        customers.phone,
        vehicles.registration_no,
        vehicles.brand,
        vehicles.model
    ");
		$this->db->from("appointments");
		$this->db->join("customers", "customers.customer_id = appointments.customer_id");
		$this->db->join("vehicles", "vehicles.vehicle_id = appointments.vehicle_id");
		$this->db->where("appointments.appointment_id", $appointment_id);

		return $this->db->get()->row();
	}


	public function update_appointment($id, $data)
	{
		return $this->db->where("appointment_id", $id)
			->update("appointments", $data);
	}

	// Get appointments happening tomorrow
	public function get_tomorrow_appointments()
	{
		$tomorrow = date('Y-m-d', strtotime('+1 day'));

		$this->db->select("
            appointments.*,
            customers.name AS customer_name,
            customers.phone,
            customers.email,
            vehicles.registration_no
        ");
		$this->db->from("appointments");
		$this->db->join("customers", "customers.customer_id = appointments.customer_id");
		$this->db->join("vehicles", "vehicles.vehicle_id = appointments.vehicle_id");
		$this->db->where("appointment_date", $tomorrow);
		$this->db->where("reminder_sent", 0);

		return $this->db->get()->result();
	}

	// Get today's morning reminders
	public function get_today_appointments()
	{
		$today = date('Y-m-d');

		$this->db->select("
            appointments.*,
            customers.name AS customer_name,
            customers.phone,
            customers.email,
            vehicles.registration_no
        ");
		$this->db->from("appointments");
		$this->db->join("customers", "customers.customer_id = appointments.customer_id");
		$this->db->join("vehicles", "vehicles.vehicle_id = appointments.vehicle_id");
		$this->db->where("appointment_date", $today);
		$this->db->where("reminder_sent", 0);

		return $this->db->get()->result();
	}

	// Mark reminder sent
	public function mark_reminder_sent($appointment_id)
	{
		return $this->db
			->where("appointment_id", $appointment_id)
			->update("appointments", ["reminder_sent" => 1]);
	}

	// Get upcoming / nearby appointments between from_date and to_date
	public function get_upcoming_appointments($from_date, $to_date)
	{
		$this->db->select("
            appointments.*,
            customers.name AS customer_name,
            customers.phone AS customer_phone,
            customers.email AS customer_email,
            vehicles.registration_no
        ");
		$this->db->from('appointments');
		$this->db->join('customers', 'customers.customer_id = appointments.customer_id', 'left');
		$this->db->join('vehicles', 'vehicles.vehicle_id = appointments.vehicle_id', 'left');
		$this->db->where('appointments.appointment_date >=', $from_date);
		$this->db->where('appointments.appointment_date <=', $to_date);
		$this->db->order_by('appointments.appointment_date', 'ASC');
		return $this->db->get()->result();
	}

	public function get_upcoming()
	{
		$today = date('Y-m-d');

		$this->db->select("
        appointments.*,
        customers.name AS customer_name,
        vehicles.registration_no
    ");
		$this->db->from("appointments");
		$this->db->join("customers", "customers.customer_id = appointments.customer_id");
		$this->db->join("vehicles", "vehicles.vehicle_id = appointments.vehicle_id");
		$this->db->where("appointments.appointment_date >=", $today);
		$this->db->order_by("appointments.appointment_date", "ASC");

		return $this->db->get()->result();
	}
}
