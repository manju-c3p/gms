<?php
class Policy_model extends CI_Model
{

	public function add_policy($data)
	{
		return $this->db->insert('vehicle_insurance_policies', $data);
	}

	public function get_policies_by_vehicle($vehicle_id)
	{
		$this->db->select('vehicle_insurance_policies.*, insurance_companies.company_name');
		$this->db->from('vehicle_insurance_policies');
		$this->db->join('insurance_companies', 'insurance_companies.company_id = vehicle_insurance_policies.company_id');
		$this->db->where('vehicle_insurance_policies.vehicle_id', $vehicle_id);
		$this->db->order_by('policy_id', 'DESC');

		return $this->db->get()->result();
	}

	public function get_policy($policy_id)
	{
		$this->db->select('vehicle_insurance_policies.*,
                       vehicles.registration_no,
                       vehicles.brand,
                       vehicles.model,
                       insurance_companies.company_name');
		$this->db->from('vehicle_insurance_policies');
		$this->db->join('vehicles', 'vehicles.vehicle_id = vehicle_insurance_policies.vehicle_id');
		$this->db->join('insurance_companies', 'insurance_companies.company_id = vehicle_insurance_policies.company_id');
		$this->db->where('policy_id', $policy_id);

		return $this->db->get()->row();
	}


	public function update_policy($policy_id, $data)
	{
		return $this->db->where('policy_id', $policy_id)
			->update('vehicle_insurance_policies', $data);
	}

	public function delete_policy($policy_id)
	{
		return $this->db->delete('vehicle_insurance_policies', ['policy_id' => $policy_id]);
	}

	public function get_all_policies_with_vehicle()
	{
		$this->db->select('vehicle_insurance_policies.*, 
                       vehicles.registration_no,
                       vehicles.brand, vehicles.model,
                       insurance_companies.company_name');
		$this->db->from('vehicle_insurance_policies');
		$this->db->join('vehicles', 'vehicles.vehicle_id = vehicle_insurance_policies.vehicle_id');
		$this->db->join('insurance_companies', 'insurance_companies.company_id = vehicle_insurance_policies.company_id');
		$this->db->order_by('vehicle_insurance_policies.policy_id', 'DESC');

		return $this->db->get()->result();
	}

	public function get_all_policies_flat()
	{
		$this->db->select("
        vehicle_insurance_policies.*,
        vehicles.vehicle_id,
        vehicles.registration_no,
        vehicles.brand,
        vehicles.model,
        insurance_companies.company_name
    ");

		$this->db->from("vehicle_insurance_policies");
		$this->db->join("vehicles", "vehicles.vehicle_id = vehicle_insurance_policies.vehicle_id");
		$this->db->join("insurance_companies", "insurance_companies.company_id = vehicle_insurance_policies.company_id");
		$this->db->order_by("vehicles.registration_no ASC");

		return $this->db->get()->result();
	}



}
