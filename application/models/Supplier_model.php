<?php

class Supplier_model extends CI_Model
{



	/////////////////  Supplier master start  ///////////////////
	function get_active_supplier_list()
	{
		$this->db->select('*');
		$this->db->from('supplier_master');
		$query = $this->db->get()->result();
		return $query;
	}


	public function get_all_supplier_list()
	{
		$this->db->select('*');
		$this->db->from('supplier_master');
		$query = $this->db->get()->result();
		return $query;
	}
	function get_delivery_term_list()
	{
		$this->db->select('*');
		$this->db->from('delivery_term_master');
		$query = $this->db->get()->result();
		return $query;
	}

	public function add_supplier_data()
	{
		$data = array(
			'supplier_name' => $_POST['supplier_name'],
			'supplier_code' => $_POST['supplier_code'],
			'email_id' => $_POST['supplier_email'],
			'contact_no' => $_POST['contact_number'],
			'billing_address' => $_POST['supplier_address'],
			'trn_no' => $_POST['trn_no']
		);

		$res = $this->db->insert('supplier_master', $data);
		$supplier_id = $this->db->insert_id();

		if ($res && !empty($_POST['contact_name'])) {

			foreach ($_POST['contact_name'] as $key => $contact_name) {
				if (!empty($contact_name)) {
					$contact_phone = isset($_POST['contact_phone'][$key]) ? $_POST['contact_phone'][$key] : null;
					$contact_email = isset($_POST['contact_email'][$key]) ? $_POST['contact_email'][$key] : null;

					$contact_data = array(
						'supplier_id'   => $supplier_id,
						'contact_name'  => $contact_name,
						'contact_phone' => $contact_phone,
						'contact_email' => $contact_email,
					);
					$this->db->insert('supplier_contact_details', $contact_data);
				}
			}
		}

		return $res;
	}

	//changed the code 

	function delete_supplier($id)
	{

		$this->db->where('supplier_id', $id);
		$this->db->delete('supplier_contact_details');
		$this->db->where('supplier_id', $id);
		$this->db->delete('supplier_master');

		return ($this->db->affected_rows() > 0);
	}


	public function generate_supplier_code()
	{
		$this->db->select('supplier_code');
		$this->db->like('supplier_code', 'SUP', 'after');
		$this->db->order_by('supplier_id', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('supplier_master');

		if ($query->num_rows() > 0) {

			$lastCode = $query->row()->supplier_code;

			// Extract number
			$number = (int) substr($lastCode, 3);

			$number++;

			return 'SUP' . str_pad($number, 4, '0', STR_PAD_LEFT);
		} else {

			return 'SUP0001';
		}
	}

	public function get_supplier($id)
	{
		return $this->db
			->where('supplier_id', $id)
			->get('supplier_master')
			->row();
	}
	public function get_supplier_contacts($supplier_id)
	{
		return $this->db
			->where('supplier_id', $supplier_id)
			->get('supplier_contact_details')
			->result();
	}
	public function update_supplier($id, $data)
	{
		$this->db->where('supplier_id', $id);
		return $this->db->update('supplier_master', $data);
	}
	public function delete_contacts($supplier_id)
	{
		$this->db->where('supplier_id', $supplier_id);
		$this->db->delete('supplier_contact_details');
	}
	public function insert_contacts($contacts)
	{
		return $this->db->insert_batch('supplier_contact_details', $contacts);
	}

	// ===================================

	//place in supplier model 




	function add_units()
	{
		$data = array(
			'unit_name'  => $this->input->post('uname'),
			'unit_abbr'  => $this->input->post('uabbr'),
			//   'unit_type'  => $this->input->post('utype'),
			//   'conversion'  => $this->input->post('cf'),
			//'base_unit'  => $this->input->post('bunit')
		);
		$this->db->insert('unit_master', $data);

		return $insert_id = $this->db->insert_id();
	}



	function get_units()
	{
		$query = $this->db->order_by('unit_id', 'DESC')
			->get('unit_master');
		return $query->result();
	}



	function get_units_by_id($id)
	{
		$this->db->where('unit_id', $id);
		$query = $this->db->get('unit_master');
		return $query->result();
	}

	function update_unit_data($id)
	{
		$data = array(
			'unit_name'  => $this->input->post('uname'),
			'unit_abbr'  => $this->input->post('uabbr'),
			//   'unit_type'  => $this->input->post('utype'),
			//   'conversion'  => $this->input->post('cf'),
			//'base_unit'  => $this->input->post('bunit')
		);
		$this->db->where('unit_id', $id);
		$this->db->update('unit_master', $data);
		return true;
	}
}
