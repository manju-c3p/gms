<?php
class Jobcard_model extends CI_Model {

    // Get all job cards with customer, vehicle & appointment info
    public function get_all_jobcards() 
    {
        $this->db->select("
            job_cards.*,
            customers.name AS customer_name,
            customers.phone,

            vehicles.registration_no,
            vehicles.brand,
            vehicles.model,

            appointments.appointment_date
        ");

        $this->db->from("job_cards");
        $this->db->join("customers", "customers.customer_id = job_cards.customer_id");
        $this->db->join("vehicles", "vehicles.vehicle_id = job_cards.vehicle_id");
        $this->db->join("appointments", "appointments.appointment_id = job_cards.appointment_id", "left");

        $this->db->order_by("job_cards.jobcard_id", "DESC");

        return $this->db->get()->result();
    }

	  public function insert_jobcard($data) {
        $this->db->insert("job_cards", $data);
        return $this->db->insert_id();
    }

    public function insert_service($data) {
        return $this->db->insert("jobcard_services", $data);
    }

    public function insert_part($data) {
        return $this->db->insert("jobcard_parts", $data);
    }

    public function get_all() {
        $this->db->select("
            job_cards.*,
            customers.name AS customer_name,
            vehicles.registration_no
        ");
        $this->db->from("job_cards");
        $this->db->join("customers", "customers.customer_id = job_cards.customer_id");
        $this->db->join("vehicles", "vehicles.vehicle_id = job_cards.vehicle_id");
        $this->db->order_by("job_cards.jobcard_id", "DESC");
        return $this->db->get()->result();
    }


	public function get_jobcard($jobcard_id)
{
    $this->db->select("
        job_cards.*,
        customers.name AS customer_name,
        customers.phone,
        customers.email,
        vehicles.registration_no,
        vehicles.brand,
        vehicles.model,
        vehicles.variant,
        vehicles.year,
        appointments.appointment_date
    ");

    $this->db->from("job_cards");
    $this->db->join("customers", "customers.customer_id = job_cards.customer_id");
    $this->db->join("vehicles", "vehicles.vehicle_id = job_cards.vehicle_id");
    $this->db->join("appointments", "appointments.appointment_id = job_cards.appointment_id", "left");
    $this->db->where("job_cards.jobcard_id", $jobcard_id);

    return $this->db->get()->row();
}
public function get_jobcard_services($jobcard_id)
{
    return $this->db->where("jobcard_id", $jobcard_id)
                    ->get("jobcard_services")
                    ->result();
}

public function get_jobcard_parts($jobcard_id)
{
    $this->db->select("
        jobcard_parts.*,
        spare_parts.part_name
    ");
    $this->db->from("jobcard_parts");
    $this->db->join("spare_parts", "spare_parts.part_id = jobcard_parts.part_id");
    $this->db->where("jobcard_parts.jobcard_id", $jobcard_id);

    return $this->db->get()->result();
}


public function update_jobcard($jobcard_id, $data)
{
    return $this->db->where('jobcard_id', $jobcard_id)->update('job_cards', $data);
}

public function delete_services($jobcard_id)
{
    return $this->db->delete('jobcard_services', ['jobcard_id' => $jobcard_id]);
}

public function add_service($data)
{
    return $this->db->insert('jobcard_services', $data);
}

public function delete_parts($jobcard_id)
{
    return $this->db->delete('jobcard_parts', ['jobcard_id' => $jobcard_id]);
}

public function add_part($data)
{
    return $this->db->insert('jobcard_parts', $data);
}

// AUTO STOCK DEDUCTION
public function reduce_stock($part_id, $qty)
{
    $this->db->insert('stock_out', [
        'part_id'   => $part_id,
        'qty'       => $qty,
        'date_out'  => date('Y-m-d'),
        'created_at'=> date('Y-m-d H:i:s')
    ]);
}

public function get_jobcard_details($jobcard_id)
{
    $this->db->select("
        job_cards.*,
        customers.name AS customer_name,
        customers.phone,
        vehicles.registration_no,
        vehicles.brand,
        vehicles.model
    ");
    $this->db->from("job_cards");
    $this->db->join("customers", "customers.customer_id = job_cards.customer_id");
    $this->db->join("vehicles", "vehicles.vehicle_id = job_cards.vehicle_id");
    $this->db->where("job_cards.jobcard_id", $jobcard_id);

    return $this->db->get()->row();
}

public function get_jobcard_with_details($jobcard_id)
{
    // =========================
    // MAIN JOBCARD DATA
    // =========================
    $this->db->select("job_cards.*, 
                       customers.name AS customer_name, customers.phone AS customer_phone,
                       vehicles.registration_no");
    $this->db->from("job_cards");
    $this->db->join("customers", "customers.customer_id = job_cards.customer_id");
    $this->db->join("vehicles", "vehicles.vehicle_id = job_cards.vehicle_id");
    $this->db->where("job_cards.jobcard_id", $jobcard_id);

    $jobcard = $this->db->get()->row();

    if ($jobcard) {

        // =========================
        // SERVICES
        // =========================
        $jobcard->services = $this->db
            ->get_where('jobcard_services', ['jobcard_id' => $jobcard_id])
            ->result();

        // =========================
        // PARTS + SPARE PART DETAILS ✅✅✅
        // =========================
        $this->db->select("jobcard_parts.*, 
                           spare_parts.part_name, 
                           spare_parts.part_code, 
                           spare_parts.unit_price");
        $this->db->from("jobcard_parts");
        $this->db->join("spare_parts", "spare_parts.part_id = jobcard_parts.part_id");
        $this->db->where("jobcard_parts.jobcard_id", $jobcard_id);

        $jobcard->parts = $this->db->get()->result();
    }

    return $jobcard;
}


public function update_status($jobcard_id, $status)
{
    return $this->db
        ->where('jobcard_id', $jobcard_id)
        ->update('job_cards', [
            'status' => $status
        ]);
}



}
