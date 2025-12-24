<?php
class Customer_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}


	// Insert new customer
	public function insert_customer($data)
	{
		$this->db->insert('customers', $data);
		return $this->db->insert_id(); // return customer_id
	}


	// Update existing customer
	public function update_customer($customer_id, $data)
	{
		$this->db->where('customer_id', $customer_id);
		return $this->db->update('customers', $data);
	}

	// Get single customer
	public function get_customer($customer_id)
	{
		return $this->db->where('customer_id', $customer_id)
			->get('customers')
			->row();
	}

	// Get all customers
	public function get_all_customers($search = null)
	{
		if (!empty($search)) {
			$this->db->like('name', $search);
		}

		return $this->db->order_by('customer_id', 'DESC')
			->get('customers')
			->result();
	}


	// Delete customer
	public function delete_customer($customer_id)
	{
		return $this->db->delete('customers', ['customer_id' => $customer_id]);
	}
}
