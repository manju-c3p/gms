<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vehicle_model extends CI_Model
{

	/* ---------------------------------------------------
        INSERT VEHICLE (single row)
    --------------------------------------------------- */
	public function insert_vehicle($data)
	{
		return $this->db->insert('vehicles', $data);
	}

	/* ---------------------------------------------------
        GET ALL VEHICLES (with optional search)
        - search by reg no, brand, model
        - joins customer to get name
    --------------------------------------------------- */
	public function get_all_vehicles($search = null)
	{
		$this->db->select('vehicles.*, customers.name as customer_name');
		$this->db->from('vehicles');
		$this->db->join('customers', 'customers.customer_id = vehicles.customer_id');

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('vehicles.registration_no', $search);
			$this->db->or_like('vehicles.brand', $search);
			$this->db->or_like('vehicles.model', $search);
			$this->db->group_end();
		}

		$this->db->order_by('vehicles.vehicle_id', 'DESC');
		return $this->db->get()->result();
	}

	/* ---------------------------------------------------
        GET VEHICLES BY CUSTOMER ID
    --------------------------------------------------- */
	public function get_vehicles_by_customer($customer_id)
	{
		return $this->db
			->where('customer_id', $customer_id)
			->order_by('vehicle_id', 'DESC')
			->get('vehicles')
			->result();
	}

	/* ---------------------------------------------------
        GET SINGLE VEHICLE
    --------------------------------------------------- */
	public function get_vehicle($vehicle_id)
	{
		return $this->db
			->where('vehicle_id', $vehicle_id)
			->get('vehicles')
			->row();
	}

	/* ---------------------------------------------------
        UPDATE VEHICLE
    --------------------------------------------------- */
	public function update_vehicle($vehicle_id, $data)
	{
		return $this->db
			->where('vehicle_id', $vehicle_id)
			->update('vehicles', $data);
	}

	/* ---------------------------------------------------
        DELETE VEHICLE
    --------------------------------------------------- */
	public function delete_vehicle($vehicle_id)
	{
		return $this->db->delete('vehicles', ['vehicle_id' => $vehicle_id]);
	}

	public function get_all_flat()
	{
		$this->db->select("
            customers.customer_id,
            customers.name AS customer_name,
            customers.phone,
            vehicles.vehicle_id,
            vehicles.registration_no,
            vehicles.brand,
            vehicles.model,
            vehicles.variant,
            vehicles.year,
            vehicles.color,
            vehicles.chassis_no,
            vehicles.engine_no
        ");
		$this->db->from("customers");
		$this->db->join("vehicles", "vehicles.customer_id = customers.customer_id", "left");
		$this->db->order_by("customers.name ASC");

		return $this->db->get()->result();
	}

	public function get_vehicles_by_customerreg($customer_id)
	{
		return $this->db->where('customer_id', $customer_id)
			->order_by('registration_no')
			->get('vehicles')->result();
	}
}
