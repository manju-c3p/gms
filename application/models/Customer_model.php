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

		$insert_id = $this->db->insert_id();

		$prifix = 'CUST';

		$digit = sprintf("%1$04d", $insert_id);
		$Code = $prifix . $digit;

		$grp_no = 30;
		$data1 = array(
			'account_name' => $this->input->post('name') . ' ' . $Code,
			'group_no' => $grp_no,
			'customer_id' => $insert_id,
			'opening_bal_type' => 'Dr',
		);
		$this->db->insert('general_ledger', $data1);
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

	public function get_all()
	{
		return $this->db->order_by('name')->get('customers')->result();
	}



	// Delete customer
	public function delete_customer($customer_id)
	{
		return $this->db->delete('customers', ['customer_id' => $customer_id]);
	}


	// =================================13-1-2026=================

	public function getCustomerByMobile($mobile)
	{
		return $this->db
			->select('
            c.customer_id,
            c.name,
            c.phone,
            c.email
          
        ')
			->from('customers c')
			->where('c.phone', $mobile)
			// ->where('c.status', 1)           // active customers only
			// ->limit(1)
			->get()
			->row();
	}

	public function create_customer($data)
	{
		$this->db->insert('customers', $data);

			$insert_id = $this->db->insert_id();

		$prifix = 'CUST';

		$digit = sprintf("%1$04d", $insert_id);
		$Code = $prifix . $digit;

		$grp_no = 30;
		$data1 = array(
			'account_name' => $this->input->post('name') . ' ' . $Code,
			'group_no' => $grp_no,
			'customer_id' => $insert_id,
			'opening_bal_type' => 'Dr',
		);
		$this->db->insert('general_ledger', $data1);
		return $this->db->insert_id(); // return customer_id
		
	}

	public function create($data)
	{
		$this->db->insert('customers', $data);

			$insert_id = $this->db->insert_id();

		$prifix = 'CUST';

		$digit = sprintf("%1$04d", $insert_id);
		$Code = $prifix . $digit;

		$grp_no = 30;
		$data1 = array(
			'account_name' => $this->input->post('name') . ' ' . $Code,
			'group_no' => $grp_no,
			'customer_id' => $insert_id,
			'opening_bal_type' => 'Dr',
		);
		$this->db->insert('general_ledger', $data1);
		return $this->db->insert_id(); // return customer_id
	}

	public function filter_customers($filters = [])
	{
		$this->db->select('c.*');
		$this->db->from('customers c');

		// Customer filters
		if (!empty($filters['name'])) {
			$this->db->like('c.name', $filters['name']);
		}

		if (!empty($filters['phone'])) {
			$this->db->like('c.phone', $filters['phone']);
		}

		// Vehicle filters (multiple vehicles safe)
		if (!empty($filters['plate']) || !empty($filters['vin'])) {

			$plate = $filters['plate'] ?? '';
			$vin   = $filters['vin'] ?? '';

			$this->db->where("
				EXISTS (
					SELECT 1 FROM vehicles v
					WHERE v.customer_id = c.customer_id
					" . ($plate ? "AND v.registration_no LIKE '%$plate%'" : "") . "
					" . ($vin ? "AND v.chassis_no LIKE '%$vin%'" : "") . "
				)
			", null, false);
		}

		return $this->db
			->order_by('c.customer_id', 'DESC')
			->get()
			->result();
	}

	public function sync_customers_to_ledger()
	{
		$customers = $this->db->get('customers')->result();
		$count = 0;

		foreach ($customers as $cust) {

			// 🔒 Prevent duplicate ledger creation
			$exists = $this->db->where('customer_id', $cust->customer_id)
				->get('general_ledger')
				->row();

			if ($exists) {
				continue;
			}

			// Generate Code like CUST0001
			$digit = sprintf("%04d", $cust->customer_id);
			$code  = 'CUST' . $digit;

			$data = [
				'account_name'      => $cust->name . ' ' . $code,
				'group_no'          => 30,
				'customer_id'       => $cust->customer_id,
				'opening_balance'   => 0.00,
				'opening_bal_type'  => 'Dr',
				'isdeleteable'      => 'N'
			];

			$this->db->insert('general_ledger', $data);
			$count++;
		}

		return $count;
	}
}
