<?php
class Claim_model extends CI_Model
{

	/* Add claim */
	public function add_claim($data)
	{
		$this->db->insert('insurance_claims', $data);
		return $this->db->insert_id();
	}

	/* Add document to claim */
	public function add_claim_document($data)
	{
		return $this->db->insert('insurance_claim_documents', $data);
	}

	/* Get all claims for a policy */
	public function get_claims_by_policy($policy_id)
	{
		return $this->db
			->where('policy_id', $policy_id)
			->order_by('claim_id', 'DESC')
			->get('insurance_claims')
			->result();
	}

	/* Get claim with policy + vehicle info */
	// public function get_claim($claim_id)
	// {
	// 	$this->db->select('insurance_claims.*, 
	//                        vehicle_insurance_policies.policy_number,
	//                        vehicles.registration_no');
	// 	$this->db->from('insurance_claims');
	// 	$this->db->join('vehicle_insurance_policies', 'vehicle_insurance_policies.policy_id = insurance_claims.policy_id');
	// 	$this->db->join('vehicles', 'vehicles.vehicle_id = vehicle_insurance_policies.vehicle_id');
	// 	$this->db->where('claim_id', $claim_id);

	// 	return $this->db->get()->row();
	// }

	public function get_claim($claim_id)
	{
		$this->db->select('insurance_claims.*,

                       vehicle_insurance_policies.policy_number,
                       vehicle_insurance_policies.company_id,

                       vehicles.registration_no,
                       vehicles.brand,
                       vehicles.model,

                       insurance_companies.company_name');

		$this->db->from('insurance_claims');
		$this->db->join(
			'vehicle_insurance_policies',
			'vehicle_insurance_policies.policy_id = insurance_claims.policy_id'
		);

		$this->db->join(
			'vehicles',
			'vehicles.vehicle_id = vehicle_insurance_policies.vehicle_id'
		);

		$this->db->join(
			'insurance_companies',
			'insurance_companies.company_id = vehicle_insurance_policies.company_id'
		);

		$this->db->where('insurance_claims.claim_id', $claim_id);

		return $this->db->get()->row();
	}


	/* Get claim documents */
	public function get_claim_documents($claim_id)
	{
		return $this->db->where('claim_id', $claim_id)->get('insurance_claim_documents')->result();
	}

	/* Update claim */
	public function update_claim($claim_id, $data)
	{
		return $this->db->where('claim_id', $claim_id)->update('insurance_claims', $data);
	}

	/* Delete claim */
	public function delete_claim($claim_id)
	{
		return $this->db->delete('insurance_claims', ['claim_id' => $claim_id]);
	}
}
