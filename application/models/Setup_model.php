<?php
class Setup_model extends CI_Model
{

	public function __construct() {}
	// ================================users =============================
	public function add_user_data()
	{
		$data = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'role' => $_POST['role'],
			'department' => $_POST['department'],
			'contact_no' => $_POST['contact_number'],
			'status' => $_POST['status']
		);
		$res = $this->db->insert('users', $data);
		return $res;
	}

	public function get_all_users()
	{
		return $this->db->get('users')->result();
	}

	public function get_user_by_id($user_id)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $user_id);
		$query = $this->db->get()->row_array();
		return $query;
	}

	public function edit_user_data()
	{
		$data = array(
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'email' => $_POST['email'],
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'role' => $_POST['role'],
			'department' => $_POST['department'],
			'contact_no' => $_POST['contact_number'],
			'status' => $_POST['status']
		);
		$this->db->where('id', $_POST['user_id']);
		$res = $this->db->update('users', $data);
		return $res;
	}
	public function delete_user($id)
	{
		return $this->db->where('id', $id)
			->delete('users');
	}


	// ================================users =============================

		function get_next_code($prifix, $column, $table, $sublen)
	{

		$query = $this->db->query("select max(substr($column,$sublen,5))as count from $table where $column like '%$prifix%'");
		return $query->row('count');
	}

	public function get_active_unit_list()
	{
		$this->db->select('*');
		$this->db->from('unit_master');
		$this->db->where('active', 1);
		$query = $this->db->get()->result();
		return $query;
	}

}
