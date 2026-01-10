<?php
class Accounts_model extends CI_Model
{
	//  ==========================Accounts_group ============================

	function get_account_group_list()
	{
		//	$query = $this->db->query("select one.*, two.group_name as parent from (select * from account_group where parent_group!=0 order by group_code)as one left join (select * from account_group)as two on(one.parent_group=two.group_no) ");
		$query = $this->db->query("select  one.*, two.group_name as parent from (select * from account_group  order by group_code)as one left join (select * from account_group)as two on(one.parent_group=two.group_no) order by group_code;");
		return $query->result();
	}


	function get_account_group_parent()
	{
		$query = $this->db->query("select * from account_group where parent_group!=0 ");
		return $query->result();
	}
	function get_account_section()
	{
		$query = $this->db->query("select * from account_group where parent_group=0 ");
		return $query->result();
	}

	function get_pandl_value($sno)
	{
		$query = $this->db->query("select pandl from account_group where group_no='$sno'");
		return $query->row('pandl');
	}

	function add_account_group_addition()
	{
		$parent_group = $this->input->post('p_group');
		$sno = $this->input->post('sec_in_account');
		$PandL = $this->get_pandl_value($sno);
		$account_grp = $this->input->post('ac_group');

		$flag = 0;
		$query = $this->db->query("select * from account_group where group_name = '$account_grp'");

		if ($query->num_rows() >= 1) {
			$flag = 1;
			return $flag;
		}

		if ($parent_group == 0) {
			$parent_group = $this->input->post('sec_in_account');
		} else {
			$parent_group = $this->input->post('p_group');
		}
		$data = array(
			'group_name' => $this->input->post('ac_group'),
			'pandl' => $PandL,
			'sno' => $sno,
			'parent_group' => $parent_group,
			'isdeleteable' => 'Y'
		);
		$this->db->insert('account_group', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$num = $insert_id % 100000;
			$digit = sprintf("%1$08d", $num);
			$group_code = '' . $digit;
			$this->db->query("update account_group set group_code = '$group_code' where group_no = $insert_id");

			// $user_se_id = $this->session->userdata('session_id');
			// $uid = $this->session->userdata('user_id');
			// $page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			// $ci = get_instance();
			// $ci->load->helper('log');
			// $log_msg = add_log_entry($uid, 1, $page_name[1], 'account_group', 'group_no', $insert_id);
			// return $flag;
		}
	}

	// ============================ general ledger ============================
	function get_account_group()
	{

		$query = $this->db->query(" select * from account_group where parent_group!=0 order by group_name asc;");
		return $query->result();
	}
	function get_general_ledger_list()
	{ //general ledger list
		$query = $this->db->query("select a.*,g.group_name from general_ledger a,account_group g where a.group_no = g.group_no order by account_id ");
		return $query->result();
	}

	function get_customer_record()
	{ //in use
		$query = $this->db->query("select customer_id as occupier_id, name as occu_name from customers");
		return $query->result();
	}

	//   function get_supplier_record()
	//   {
	//     $query = $this->db->query("select supp_id,supp_name from supplier_data_entity");
	//     return $query->result();
	//     return true;
	//   }
}
