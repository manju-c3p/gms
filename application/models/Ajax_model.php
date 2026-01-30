<?php
class Ajax_model extends CI_Model
{
	function cancel_record()
	{
		$id = $this->input->post('post_id1');
		$table_name = $this->input->post('table1');
		$attribute = $this->input->post('key_name1');
		$column = $this->input->post('column');
		$value = $this->input->post('value');

		$query = $this->db->query("update $table_name set $column='$value' where $attribute='$id' ");

		$uid = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($uid, 3, $page_name[1], $table_name, $attribute, $id);
		return true;
	}
	function delete_record()
	{
		$table_name = $this->input->post('table_name');
		$attribute = $this->input->post('where_key');
		$id = $this->input->post('where_val');
		$query = $this->db->query("delete from $table_name where $attribute='$id' ");
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	function delete_sales_quotation()
	{
		$quoteID = $this->input->post('quoteID');
		$enq_master_id = $this->input->post('enq_master_id');

		$query = $this->db->query("delete from sales_quotation_transaction where quote_master_id='$quoteID' ");
		$query = $this->db->query("delete from tech_sales_quotation_transaction where tech_quote_master_id='$quoteID' ");
		$query = $this->db->query("delete from tech_sales_quotation_transaction2 where tech_quote_master_id='$quoteID' ");
		$query = $this->db->query("delete from sales_quotation_master where quote_id='$quoteID' ");

		$query = $this->db->query("update enquiry_master set order_status=0  where enquiry_id='$enq_master_id' ");
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	function delete_project_sheet()
	{
		$pcost_ID = $this->input->post('pcost_ID');
		$enq_master_id = $this->input->post('enq_master_id');
		$query = $this->db->query("select count(*)as tcnt from  sales_quotation_master where enq_master_id='$enq_master_id' ");
		$cnt = $query->row('tcnt');
		if($cnt==0)
		{
			$query = $this->db->query("delete from project_costsheet_totals where cs_id='$pcost_ID' ");
			$query = $this->db->query("delete from project_costsheet_transaction where cs_id='$pcost_ID' ");
			$query = $this->db->query("delete from project_costsheet_master where cost_sheet_id='$pcost_ID' ");
			return true;
		}
		else
			return false;
	}
	function delete_cost_sheet()
	{
		$pcost_ID = $this->input->post('pcost_ID');
		$enq_master_id = $this->input->post('enq_master_id');
		$query = $this->db->query("select count(*)as tcnt from  sales_quotation_master where enq_master_id='$enq_master_id' ");
		$cnt = $query->row('tcnt');
		if($cnt==0)
		{
			$query = $this->db->query("delete from cost_sheet_transaction where cost_master_id='$pcost_ID' ");
			$query = $this->db->query("delete from cost_sheet_calculation where cost_master_id='$pcost_ID' ");
			$query = $this->db->query("delete from cost_sheet where cost_sheet_id='$pcost_ID' ");
			return true;
		}
		else
			return false;
	}
	function check_duplicate_exist()
	{
		$table_name = $this->input->post('table_name');
		$attribute = $this->input->post('column_name');
		$id = $this->input->post('post_id');

		$query = $this->db->query("select count(*)as tcnt from  $table_name where $attribute='$id' ");
		return $query->row('tcnt');
	}
	function check_duplicate_exist2()
	{
		$table_name = $this->input->post('table_name');
		$attribute1 = $this->input->post('column_name1');
		$id1 = $this->input->post('post_id1');
		$attribute2 = $this->input->post('column_name2');
		$id2 = $this->input->post('post_id2');

		$query = $this->db->query("select count(*)as tcnt from  $table_name where $attribute1='$id1' and $attribute2='$id2'  ");
		return $query->row('tcnt');
	}

	function check_duplicate_exist3()
	{
		$table_name = $this->input->post('table_name');
		$attribute1 = $this->input->post('column_name1');
		$id1 = $this->input->post('post_id1');
	

		$query = $this->db->query("select count(*)as tcnt from  $table_name where $attribute1='$id1'");
	
		return $query->row('tcnt');

	}


	function check_exist_leave_data()
	{
		$table_name = $this->input->post('table_name');
		$attribute1 = $this->input->post('column_name1');
		$id1 = $this->input->post('post_id1');
		$attribute2 = $this->input->post('column_name2');
		$id2 = $this->input->post('post_id2');
		$attribute3 = $this->input->post('column_name3');
		$id3 = $this->input->post('post_id3');
		$attribute4 = $this->input->post('column_name4');
		$id4 = $this->input->post('post_id4');
		$attribute5 = $this->input->post('column_name5');
		$id5 = $this->input->post('post_id5');

		// Ensure attributes and IDs are properly sanitized before using them in the query to prevent SQL injection

		// Execute the query
		$query = $this->db->query("SELECT COUNT(*) AS tcnt FROM $table_name WHERE $attribute1 = ? AND $attribute2 = ? AND $attribute3 = ? AND $attribute4 = ? AND $attribute5 = ?", array($id1, $id2, $id3, $id4, $id5));

		// Retrieve the count from the query result
		$result = $query->row();
		$count = $result->tcnt;

		return $count;
	}






	function check_duplicate_item_exist()
	{
		$iname = $this->input->post('iname');
		$cat_id = $this->input->post('cat_id');

		$query = $this->db->query("select count(*)as tcnt from  item_master where item_name='$iname' and category_id=$cat_id ");
		return $query->row('tcnt');
	}

	function update_record()
	{
		$table_name = $this->input->post('table1');
		$column = $this->input->post('column');
		$attribute = $this->input->post('key_name1');
		$id = $this->input->post('post_id1');
		$value = $this->input->post('value');
		$query = $this->db->query("update $table_name set $column='$value' where $attribute='$id' ");
		return true;
	}


	function approve_record()
	{
		$approved_by = $this->session->userdata('user_id');
		$table_name = $this->input->post('table');
		$attribute = $this->input->post('key_name');
		$id = $this->input->post('post_id');
		$page_id = $this->input->post('page_id');
		$page_url = $this->input->post('page_url');

		$this->load->model('Setup_model');
		$status = $this->Setup_model->get_status_level($table_name, $attribute, $id);

		$value = $this->input->post('status_value');
		$query = $this->db->query("update $table_name set status=$value where $attribute=$id ");

		$this->Setup_model->add_approval_history($page_id, $id, $approved_by, $status, $page_url);

		return $id;
	}

	function ajax_get_requisition_items()
	{
		$id = implode(',', $this->input->post('req_id'));
		$query = $this->db->query("select * from purchase_requisition_transaction where req_master_id in($id)");
		return $query->result();
	}


	///////////////////ledger record by id
	function get_general_ledger_list_by_id($gn_led)
	{ 
		
		$query = $this->db->query("select  * from general_ledger where account_id='$gn_led'");
		return $query->result();
	}
	public function check_duplicate_exist5()
	{
		$table_name = $this->input->post('table_name');
		$attribute1 = $this->input->post('column_name1');
		$id1 = trim($this->input->post('post_id1'));

		// Sanitize the input
		$id1 = $this->db->escape($id1);

		$query = $this->db->query("SELECT COUNT(*) as tcnt FROM $table_name WHERE $attribute1 = $id1");
		return $query->row('tcnt');
	}
}
