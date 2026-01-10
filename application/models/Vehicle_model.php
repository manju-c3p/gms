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
	// ===================================brand and model masters =======================================

	/* ===============================
       VEHICLE BRANDS
       =============================== */

	public function get_all_brands()
	{
		return $this->db
			->order_by('brand_name', 'ASC')
			->get('vehicle_brands')
			->result();
	}

	public function get_brand_by_id($brand_id)
	{
		return $this->db
			->where('brand_id', $brand_id)
			->get('vehicle_brands')
			->row();
	}

	public function insert_brand($data)
	{
		return $this->db->insert('vehicle_brands', $data);
	}

	public function update_brand($brand_id, $data)
	{
		return $this->db
			->where('brand_id', $brand_id)
			->update('vehicle_brands', $data);
	}

	public function delete_brand($brand_id)
	{
		return $this->db
			->where('brand_id', $brand_id)
			->delete('vehicle_brands');
	}

	/* ===============================
       VEHICLE MODELS
       =============================== */

	public function get_all_models()
	{
		return $this->db
			->select('vm.*, vb.brand_name')
			->from('vehicle_models vm')
			->join('vehicle_brands vb', 'vb.brand_id = vm.brand_id')
			->order_by('vb.brand_name, vm.model_name')
			->get()
			->result();
	}

	public function get_models_by_brand($brand_id)
	{
		return $this->db
			->where('brand_id', $brand_id)
			->get('vehicle_models')
			->result();
	}

	public function get_models_by_brand_edit($brand_id)
{
    return $this->db
        ->select('model_id, model_name')
        ->from('models')
        ->where('brand_id', $brand_id)
        ->order_by('model_name', 'ASC')
        ->get()
        ->result();
}

	public function get_model_by_id($model_id)
	{
		return $this->db
			->where('model_id', $model_id)
			->get('vehicle_models')
			->row();
	}

	public function insert_model($data)
	{
		return $this->db->insert('vehicle_models', $data);
	}

	public function update_model($model_id, $data)
	{
		return $this->db
			->where('model_id', $model_id)
			->update('vehicle_models', $data);
	}

	public function delete_model($model_id)
	{
		return $this->db
			->where('model_id', $model_id)
			->delete('vehicle_models');
	}
}
