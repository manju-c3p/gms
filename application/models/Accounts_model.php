<?php date_default_timezone_set('Asia/Kolkata');

class Accounts_model extends CI_Model
{


	function get_account_balance($account_id, $from_date)
	{
		// $query = $this->db->query("select coalesce(two1.opening_sum,0)+coalesce(two.opening,0)as opening_bal from (select r.account_id, Case when opening_bal_type ='Dr' THEN opening_balance ELSE -opening_balance END as opening from general_ledger r where r.account_id='$account_id') as two LEFT JOIN (select account_id,SUM(CASE WHEN drcr_type= 'Cr' THEN amount ELSE (-amount) end) AS opening_sum from voucher_transaction v where cancel=0 and date(v.voucher_date) <= '$from_date' and v.account_id='$account_id' group by account_id) as two1 on (two.account_id=two1.account_id);");
		$query = $this->db->query("SELECT 
						COALESCE(two1.opening_sum,0) + COALESCE(two.opening,0) AS opening_bal 
					FROM 
					(
							SELECT 
							r.account_id, 
							CASE 
								WHEN opening_bal_type ='Dr' THEN opening_balance 
								ELSE -opening_balance 
							END AS opening 
						FROM general_ledger r 
						WHERE r.account_id='$account_id'
					) AS two 
					LEFT JOIN 
					(
						SELECT 
							account_id,
							SUM(
								CASE 
									WHEN drcr_type = 'Dr' THEN amount 
									ELSE -amount 
								END
							) AS opening_sum 
						FROM voucher_transaction v 
						WHERE cancel=0 
						AND DATE(v.voucher_date) <= '$from_date' 
						AND v.account_id='$account_id' 
						GROUP BY account_id
					) AS two1 
					ON (two.account_id=two1.account_id);");

		return $query->row('opening_bal');
	}

	function get_gen_ledger_detors_records()
	{ // General ledger Accounts Name (Customers)

		$query = $this->db->query("select gl.*, ag.group_name from general_ledger gl, account_group ag where gl.group_no=ag.group_no and group_name='Sundry Debtors' order by account_name; ");

		return $query->result();
	}

	function get_gen_ledger_creditors_records()
	{ // General ledger Accounts Name 

		$query = $this->db->query("select gl.*, ag.group_name from general_ledger gl, account_group ag where gl.group_no=ag.group_no and group_name='Sundry Creditors' order by account_name;");

		return $query->result();
	}

	function get_general_ledger_by_group($gname)
	{
		$query = $this->db->query("select account_id, account_name from general_ledger gl,account_group ag where gl.group_no=ag.group_no and group_name='$gname'");
		return $query->result();
	}
	function get_general_ledger_accounts($cond1, $cond2)
	{
		$query = $this->db->query("select account_id, account_name,gl.customer_id from general_ledger gl,account_group ag where gl.group_no=ag.group_no and (sno like '%$cond1%' or sno like '%$cond2%' or sno like '%1%')");
		// echo $this->db->last_query();exit;
		return $query->result();
	}

	function get_all_general_ledger_accounts()
	{
		$query = $this->db->query("select * from general_ledger order by account_name");
		return $query->result();
	}

	function get_supplier_account_all()
	{
		$query = $this->db->query("select * from general_ledger where group_no=29 ");
		return $query->result();
	}

	function get_cust_account_Id($cid)
	{
		$query = $this->db->query("select account_id from general_ledger where group_no=30 and customer_id='$cid'");
		return $query->row('account_id');
	}

	function get_supplier_account_Id($sid)
	{
		$query = $this->db->query("select account_id from general_ledger where group_no=29 and supplier_id='$sid'");
		return $query->row('account_id');
	}
	function view_account_transaction_details($voucher_id)
	{
		$query = $this->db->query("select voucher_code from voucher_transaction where voucher_id=$voucher_id");
		$vcode = $query->row('voucher_code');

		//$query = $this->db->query("select one.*, two.account_name from(select * from  voucher_transaction where voucher_code='$vcode')as one left join(select account_id, account_name from general_ledger)as two on(one.account_id=two.account_id);");
		$query = $this->db->query("SELECT one.*, two.account_name, i.invoice_no FROM (SELECT * FROM voucher_transaction WHERE voucher_code = '$vcode') AS one LEFT JOIN (SELECT account_id, account_name FROM general_ledger) AS two ON one.account_id = two.account_id LEFT JOIN invoices i ON one.trans_id = i.invoice_id;");
		return $query->result();
	}
	////////////////////////////////// Accounts Group Start ///////////////////////////////////
	function get_account_group_list()
	{
		//	$query = $this->db->query("select one.*, two.group_name as parent from (select * from account_group where parent_group!=0 order by group_code)as one left join (select * from account_group)as two on(one.parent_group=two.group_no) ");
		$query = $this->db->query("select  one.*, two.group_name as parent from (select * from account_group  order by group_code)as one left join (select * from account_group)as two on(one.parent_group=two.group_no) order by group_code;");
		return $query->result();
	}

	function get_account_group_list_new()
	{
		//	$query = $this->db->query("select one.*, two.group_name as parent from (select * from account_group where parent_group!=0 order by group_code)as one left join (select * from account_group)as two on(one.parent_group=two.group_no) ");
		$query = $this->db->query("select  one.*, two.group_name as parent from (select * from account_group  order by group_code)as one left join (select * from account_group)as two on(one.parent_group=two.group_no) order by group_code;");
		return $query->result();
	}


	function get_account_group_list_by_id()
	{
		$g_no = $this->uri->segment('3');
		$query = $this->db->query("select  * from account_group where group_no='$g_no'");
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

			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'account_group', 'group_no', $insert_id);
			return $flag;
		}
	}

	function update_account_group()
	{
		$parent_group = $this->input->post('p_group');
		$sno = $this->input->post('sec_in_account');
		$PandL = $this->get_pandl_value($sno);
		if ($parent_group == 0) {
			$parent_group = $this->input->post('sec_in_account');
		} else {
			$parent_group = $this->input->post('p_group');
		}
		$g_id = $this->input->post('ag_id');

		$data = array(
			'group_name' => $this->input->post('ac_group'),
			'pandl' => $PandL,
			'sno' => $sno,
			'parent_group' => $parent_group,
		);
		$this->db->where('group_no', $g_id);
		$this->db->update('account_group', $data);
		$insert_id = $g_id;
		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 2, $page_name[1], 'account_group', 'group_no', $insert_id);
			return $insert_id;
		}
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

	function get_acc_group_record($id)
	{
		$query = $this->db->query("select group_name from account_group where group_no='$id'");
		return $query->row('group_name');
	}


	function delete_group_record($id)
	{
		$group = "group_no :" . $this->get_acc_group_record($id);
		$this->db->where('group_no', $id);
		$res = $this->db->delete('account_group');
		if ($res) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 3, $page_name[1], 'account_group', 'group_no', $id);

			return true;
		} else {
			return false;
		}
	}

	///////////////////////////////// Accounts Group End //////////////////////////////////

	/*------------------------------ General ledger Starts -----------------------------*/
	function get_account_group()
	{
		//	$query = $this->db->query("select * from account_group where parent_group!=0");
		$query = $this->db->query(" select * from account_group where parent_group!=0 order by group_name asc;");
		return $query->result();
	}

	function get_general_ledger_list()
	{ //general ledger list
		$query = $this->db->query("select a.*,g.group_name from general_ledger a,account_group g where a.group_no = g.group_no order by account_id ");
		return $query->result();
	}
	function get_ledger_list()
	{
		//$to_date=$this->input->post('to_date');
		//$from_date=$this->input->post('from_date');
		$query = $this->db->query("select * from ledger_master l,transactions_type t where t.trans_id=l.ledger_type ");
		return $query->result();
	}

	function get_general_ledger_list_by_id()
	{ //general ledger for edit
		$gn_led = $this->uri->segment('3');
		$query = $this->db->query("select  * from general_ledger where account_id='$gn_led'");
		return $query->result();
	}

	function get_opening_balance_by_id()
	{
		$gn_led = $this->uri->segment('3');
		$query = $this->db->query("select * from  voucher_transaction t where t.account_id='$gn_led'");
		return $query->result();
	}

	function get_gl_code_count($group_no)
	{
		$query = $this->db->query("select count(*)+1 as tcount from general_ledger where group_no='$group_no' ");
		return $query->row('tcount');
	}

	function get_customer_record()
	{ //in use
		$query = $this->db->query("select customer_id as occupier_id, name as occu_name from customers");
		return $query->result();
	}

	function get_supplier_record()
	{ // in use
		$query = $this->db->query("select supplier_id,supplier_name from supplier_master");
		return $query->result();
		// return true;
	}

	function get_bank_records()
	{ // in use
		$query = $this->db->query("select account_id,account_name from general_ledger where group_no=5 ");
		return $query->result();
	}

	function get_cash_records()
	{ // in use
		$query = $this->db->query("select account_id,account_name from general_ledger where group_no=6 ");
		return $query->result();
	}

	function add_general_leadger()
	{ //in use
		$account_type = $this->input->post('account_type');
		$ac_group = $this->input->post('ac_group');
		$gl_code = $this->get_gl_code_count($ac_group);

		if ($account_type == 'CUS') {

			$ac_name = $this->input->post('CUS');
			$acc = explode(',', $ac_name);
			$name = $acc[0];
			$id = $acc[1];
			$s_id = "";
		} else if ($account_type == 'SUPP') {
			$sp_name = $this->input->post('SUPP');
			$acc_sp = explode(',', $sp_name);
			$name = $acc_sp[0];
			$s_id = $acc_sp[1];
			$id = "";
		}
		if ($account_type == 'OTHER') {
			$name = $this->input->post('ac_name');
			$id = "";
			$s_id = "";
		}

		$flag = 0;
		$query = $this->db->query("select * from general_ledger where account_name = '$name'");

		if ($query->num_rows() >= 1) {
			$flag = 1;
			return $flag;
		}

		$data = array(
			'gl_code' => $gl_code,
			//	'acc_type_id' => $user_id,
			'customer_id' => $id,
			'supplier_id' => $s_id,
			'account_name' => $name,
			'group_no' => $ac_group,
			'opening_balance' => $this->input->post('opening_bal'),
			'opening_bal_type' => $this->input->post('dr_cr_type'),
			'isdeleteable' => 'Y'
		);
		$this->db->insert('general_ledger', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {

			$num = $insert_id % 100000;
			$yr = date('Y/m');
			$digit = sprintf("%1$06d", $num);
			$ledger_code = $yr . '/' . $digit;
			$this->db->query("update general_ledger set gl_code = '$ledger_code' where account_id = $insert_id");

			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'general_ledger', 'account_id', $insert_id);
			return $flag;
		}
	}

	function update_general_ledger()
	{ //in use
		$account_id = $this->input->post('account_id');

		$data = array(
			'account_name' => $this->input->post('ac_name'),
			'opening_balance' => $this->input->post('opening_bal'),
			'opening_bal_type' => $this->input->post('dr_cr_type'),

		);
		$this->db->where('account_id', $account_id);
		$this->db->update('general_ledger', $data);
		if ($account_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			// $log_msg = add_log_entry($uid, 2, $page_name[1], 'general_ledger', 'account_id', $account_id);
			return $account_id;
		}
	}
	function delete_ledger($id)
	{
		$this->db->where('account_id', $id);
		$this->db->delete('general_ledger');

		$user_se_id = $this->session->userdata('session_id');
		$uid = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		// $log_msg = add_log_entry($uid, 3, $page_name[1], 'general_ledger', 'account_id', $id);
		return true;
	}
	function get_customer_account_id($customer_id)
	{
		$query = $this->db->query("select account_id from general_ledger where customer_id = '$customer_id'");
		return $query->row('account_id');
	}
	function get_account_id_using_name($name)
	{ // from general ledger Accounts Name (TDS, security deposite)
		$query = $this->db->query("select account_id from general_ledger where account_name like '%$name%' and customer_id is null ");
		return $query->row('account_id');
	}
	function get_account_code_count($code, $voucher_type)
	{
		$l1 = strlen($code);
		$query = $this->db->query("select coalesce(MAX(SUBSTR(voucher_code,$l1+1,5)),0)as count from voucher_transaction where voucher_code like '$code%' and voucher_type='$voucher_type' ");
		return $query->row('count');
	}
	function get_account_code_count_for_advance($code, $voucher_type = null)
	{
		$l1 = strlen($code);

		$query = $this->db->query("
        SELECT COALESCE(MAX(CAST(SUBSTR(voucher_code, $l1 + 1) AS UNSIGNED)), 0) AS count
        FROM voucher_transaction
        WHERE voucher_code LIKE '$code%'
    ");

		return $query->row()->count;
	}
	/*--------------------------- General leadger Ends ---------------------------------*/


	//////////////////////////////////////  Contra Entry Start/////////////////////////////
	function add_contra_entry()
	{
		$code_prifix = "CE/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'N')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');

		/// debit entry 
		for ($i = 0; $i < count($_POST['debtor']); $i++) {
			$debtor = $_POST['debtor'][$i];
			$dr_amount = $_POST['dr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'N',
				/// N stands for contra entry
				//'customer_id' => $cust_id,
				'account_id' => $debtor,
				'amount' => $dr_amount,
				'drcr_type' => 'Dr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'N',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		// credit entry
		for ($i = 0; $i < count($_POST['creditor']); $i++) {
			$creditor = $_POST['creditor'][$i];
			$cr_amount = $_POST['cr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'N',
				/// N stands for contra entry
				//'customer_id' => $cust_id,
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'N',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			// $log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			return $insert_id;
		}
	}


	function get_contra_entry_records($from, $to)
	{ //in use
		$from_date = date('Y-01-01', strtotime($from));
		$to_date = date('Y-12-31', strtotime($to));

		$query = $this->db->query("select * from  voucher_transaction where voucher_type='N' and date(voucher_date) between '$from_date' and '$to_date' group by voucher_code order by date(voucher_date) desc, voucher_code desc");
		return $query->result();
	}
	////////////////////////////////////// Contra Entry End//////////////////////////////////

	////////////////////////////////////// Journal Start/////////////////////////////
	function add_journal()
	{
		$code_prifix = "JV/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'J')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');

		/// debit entry 
		for ($i = 0; $i < count($_POST['debtor']); $i++) {
			$debtor = $_POST['debtor'][$i];
			$dr_amount = $_POST['dr_amount'][$i];


			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'J',
				/// J stands for Journal
				//'customer_id' => $cust_id,
				'account_id' => $debtor,
				'amount' => $dr_amount,
				'drcr_type' => 'Dr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'J',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		// credit entry
		for ($i = 0; $i < count($_POST['creditor']); $i++) {
			$creditor = $_POST['creditor'][$i];
			$cr_amount = $_POST['cr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'J',
				/// J stands for Journal
				//'customer_id' => $cust_id,
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'J',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			return $insert_id;
		}
	}


	function get_journal_records($from, $to)
	{ //in use
		$from_date = date('Y-01-01', strtotime($from));
		$to_date = date('Y-12-31', strtotime($to));

		$query = $this->db->query("select * from  voucher_transaction where voucher_type='J' and date(voucher_date) between '$from_date' and '$to_date' group by voucher_code order by date(voucher_date) desc, voucher_code desc");
		return $query->result();
	}

	public function get_journal_records_new($from, $to)
	{
		$from_date = date('Y-01-01', strtotime($from));
		$to_date   = date('Y-12-31', strtotime($to));

		$query = $this->db->query("
        SELECT 
		vt.*,
            vt.voucher_code,
            DATE(vt.voucher_date) as voucher_date,

            GROUP_CONCAT(CASE 
                WHEN vt.drcr_type = 'Dr' 
                THEN am.account_name 
            END SEPARATOR ', ') as dr_accounts,

            GROUP_CONCAT(CASE 
                WHEN vt.drcr_type = 'Cr' 
                THEN am.account_name 
            END SEPARATOR ', ') as cr_accounts,

            MAX(vt.narration) as narration

        FROM voucher_transaction vt
        LEFT JOIN general_ledger am ON am.account_id = vt.account_id

        WHERE vt.voucher_type = 'J'
        AND vt.cancel = 0
        AND DATE(vt.voucher_date) BETWEEN '$from_date' AND '$to_date'

        GROUP BY vt.voucher_code
        ORDER BY vt.voucher_date DESC, vt.voucher_code DESC
    ");

		return $query->result();
	}
	//////////////////////////////////////journal End//////////////////////////////////

	//////////////////////////////////////Debit Note Start/////////////////////////////

	function add_debit_note()
	{
		$code_prifix = "DN/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'D')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');

		/// debit entry 
		for ($i = 0; $i < count($_POST['debtor']); $i++) {
			$debtor = $_POST['debtor'][$i];
			$dr_amount = $_POST['dr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'D',
				/// C stands for debit note
				//'customer_id' => $cust_id,
				'account_id' => $debtor,
				'amount' => $dr_amount,
				'drcr_type' => 'Dr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'D',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		// credit entry
		for ($i = 0; $i < count($_POST['creditor']); $i++) {
			$creditor = $_POST['creditor'][$i];
			$cr_amount = $_POST['cr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'D',
				/// C stands for debit note
				//'customer_id' => $cust_id,
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'D',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			return $insert_id;
		}
	}


	function get_debit_note_records($from, $to)
	{ //in use
		$from_date = date('Y-01-01', strtotime($from));
		$to_date = date('Y-12-31', strtotime($to));

		$query = $this->db->query("select * from  voucher_transaction where voucher_type='D' and date(voucher_date) between '$from_date' and '$to_date' group by voucher_code order by date(voucher_date) desc, voucher_code desc");
		return $query->result();
	}
	//////////////////////////////////////Debit Note End//////////////////////////////////

	function add_supplier_advance()
	{
		$code_prifix = "AD/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'AD')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');

		/// debit entry 
		for ($i = 0; $i < count($_POST['debtor']); $i++) {
			$debtor = $_POST['debtor'][$i];
			$dr_amount = $_POST['dr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'AD',
				/// C stands for Credit note
				//'customer_id' => $cust_id,
				'account_id' => $debtor,
				'amount' => $dr_amount,
				'drcr_type' => 'Dr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'C',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		// credit entry
		for ($i = 0; $i < count($_POST['creditor']); $i++) {
			$creditor = $_POST['creditor'][$i];
			$cr_amount = $_POST['cr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'AD',
				/// C stands for Credit note
				//'customer_id' => $cust_id,
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'C',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}
	}

	function get_supplier_advance_records($from, $to)
	{
		$from_date = date('Y-01-01', strtotime($from));
		$to_date = date('Y-12-31', strtotime($to));

		$query = $this->db->query("select * from  voucher_transaction where voucher_type='AD' and date(voucher_date) between '$from_date' and '$to_date' group by voucher_code order by date(voucher_date) desc, voucher_code desc");
		return $query->result();
	}

	//////////////////////////////////////Credit Note Start/////////////////////////////////

	function add_credit_note()
	{
		$code_prifix = "CN/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'C')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');

		/// debit entry 
		for ($i = 0; $i < count($_POST['debtor']); $i++) {
			$debtor = $_POST['debtor'][$i];
			$dr_amount = $_POST['dr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'C',
				/// C stands for Credit note
				//'customer_id' => $cust_id,
				'account_id' => $debtor,
				'amount' => $dr_amount,
				'drcr_type' => 'Dr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'C',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		// credit entry
		for ($i = 0; $i < count($_POST['creditor']); $i++) {
			$creditor = $_POST['creditor'][$i];
			$cr_amount = $_POST['cr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'C',
				/// C stands for Credit note
				//'customer_id' => $cust_id,
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'C',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			return $insert_id;
		}
	}

	function get_credit_note_records($from, $to)
	{
		$from_date = date('Y-01-01', strtotime($from));
		$to_date = date('Y-12-31', strtotime($to));

		$query = $this->db->query("select * from  voucher_transaction where voucher_type='C' and date(voucher_date) between '$from_date' and '$to_date' group by voucher_code order by date(voucher_date) desc, voucher_code desc");
		return $query->result();
	}
	///////////////////////////////////////Credit note End////////////////////////////////////////

	//////////// Add new receipt ///////////////////  
	// function add_new_receipt() //in use
	// {
	// 	// receipt entry Cr to customer dr to bank/cash

	// 	// var_dump($_POST);
	// 	// exit;
	// 	$code_prifix = "BES/R/".date('y')."/";
	// 	$this->load->model('Accounts_model');
	// 	$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'R')) + 1;
	// 	$digit = sprintf("%1$05d", $num);
	// 	$AccountCode = $code_prifix . $digit;


	// 	$vdate = $this->input->post('v_date');
	// 	$vtime = $this->input->post('vtime');
	// 	$cust_id = $this->input->post('customer_id');
	// 	// receipt entry Cr to customer dr to bank/cash

	// 	/// credit entry 
	// 	for ($i = 0; $i < count($_POST['inv_id']); $i++) {

	// 		//$debtor=$_POST['debtor'][$i];
	// 		$inv_id = $_POST['inv_id'][$i];
	// 		$dr_amount = $this->input->post("dr_amount$inv_id");
	// 		$data = array(
	// 			'voucher_code' => $AccountCode,
	// 			'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
	// 			'voucher_type' => 'R',
	// 			/// R stands for Receipt
	// 			'customer_id' => $cust_id,
	// 			'account_id' => $this->input->post('debtor'),
	// 			'amount' => $dr_amount,
	// 			'drcr_type' => 'Cr',
	// 			'narration' => $this->input->post('narration'),
	// 			'trans_id' => $inv_id,
	// 			'trans_type' => 'R',
	// 		        'transaction_type' => $transaction_type,
	//                             'transaction_no'   => $transaction_no,
	// 			'recordCreatedBy' => $this->session->userdata('user_id')
	// 		);
	// 		$this->db->insert('voucher_transaction', $data);
	// 		$insert_id = $this->db->insert_id();
	// 		$this->db->query("update invoices set paid_amt='paid_amt+$dr_amount' where invoice_id=$inv_id");
	// 	}
	// 	// debit entry
	// 	for ($i = 0; $i < count($_POST['creditor']); $i++) {
	// 		$creditor = $_POST['creditor'][$i];
	// 		$cr_amount = $_POST['cr_amount'][$i];

	// 		$data = array(
	// 			'voucher_code' => $AccountCode,
	// 			'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
	// 			'voucher_type' => 'R',
	// 			/// R stands for Receipt
	// 			'customer_id' => $cust_id,
	// 			'account_id' => $creditor,
	// 			'amount' => $cr_amount,
	// 			'drcr_type' => 'Dr',
	// 			'narration' => $this->input->post('narration'),
	// 			'trans_id' => $inv_id,
	// 			'trans_type' => 'R',
	// 			'transaction_type' => $transaction_type,
	//             'transaction_no'   => $transaction_no,
	// 			'recordCreatedBy' => $this->session->userdata('user_id')
	// 		);
	// 		$this->db->insert('voucher_transaction', $data);
	// 		$insert_id = $this->db->insert_id();
	// 	}

	// 	if ($insert_id) {
	// 		$user_se_id = $this->session->userdata('session_id');
	// 		$uid = $this->session->userdata('user_id');
	// 		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
	// 		$ci = get_instance();
	// 		$ci->load->helper('log');
	// 		$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
	// 		return $insert_id;
	// 	}

	// }

	// 	public function add_new_receipt()
	// {
	//     // Generate Voucher Code (e.g. BES/R/25/00001)
	//     $code_prefix = "BES/R/" . date('y') . "/";
	//     $this->load->model('Accounts_model');
	//     $num = $this->Accounts_model->get_account_code_count($code_prefix, 'R') + 1;
	//     $voucher_code = $code_prefix . sprintf("%05d", $num);

	//     // Get posted data
	//     $vdate = $this->input->post('v_date');
	//     $vtime = $this->input->post('vtime');
	//     $cust_id = $this->input->post('customer_id');
	//     $narration = $this->input->post('narration');
	//     $transaction_type = $this->input->post('transaction_type');
	//     $transaction_no = $this->input->post('transaction_no');
	//     $user_id = $this->session->userdata('user_id');

	//     // =========================
	//     // Insert Credit entries - one per invoice
	//     // =========================
	//     if (!empty($_POST['inv_id'])) {
	//         foreach ($_POST['inv_id'] as $inv_id) {
	//             // Amount input name assumed to be like dr_amount123 if invoice id is 123
	//             $dr_amount = $this->input->post("dr_amount$inv_id");

	//             if (!empty($dr_amount) && $dr_amount > 0) {
	//                 $data_cr = array(
	//                     'voucher_code'     => $voucher_code,
	//                     'voucher_date'     => date('Y-m-d H:i:s', strtotime("$vdate $vtime")),
	//                     'voucher_type'     => 'R',
	//                     'customer_id'      => $cust_id,
	//                     'account_id'       => $this->input->post('debtor'), // Customer A/C
	//                     'amount'           => $dr_amount,
	//                     'drcr_type'        => 'Cr',
	//                     'narration'        => $narration,
	//                     'trans_id'         => $inv_id,  // link invoice id here
	//                     'trans_type'       => 'R',
	//                     'transaction_type' => $transaction_type,
	//                     'transaction_no'   => $transaction_no,
	//                     'recordCreatedBy'  => $user_id
	//                 );

	//                 $this->db->insert('voucher_transaction', $data_cr);
	//                 // Update paid amount in invoice
	//                 $this->db->query("UPDATE invoices SET paid_amt = paid_amt + $dr_amount WHERE invoice_id = $inv_id");
	//             }
	//         }
	//     }

	//     // =========================
	//     // Insert Debit entries - usually payment to bank/cash accounts
	//     // =========================
	//     if (!empty($_POST['creditor'])) {
	//         foreach ($_POST['creditor'] as $key => $creditor_account_id) {
	//             $cr_amount = $_POST['cr_amount'][$key];
	//             if (!empty($cr_amount) && $cr_amount > 0) {
	//                 $data_dr = array(
	//                     'voucher_code'     => $voucher_code,
	//                     'voucher_date'     => date('Y-m-d H:i:s', strtotime("$vdate $vtime")),
	//                     'voucher_type'     => 'R',
	//                     'customer_id'      => $cust_id,
	//                     'account_id'       => $creditor_account_id,  // Bank/Cash A/C
	//                     'amount'           => $cr_amount,
	//                     'drcr_type'        => 'Dr',
	//                     'narration'        => $narration,
	//                     'trans_id'         => NULL,
	//                     'trans_type'       => 'R',
	//                     'transaction_type' => $transaction_type,
	//                     'transaction_no'   => $transaction_no,
	//                     'recordCreatedBy'  => $user_id
	//                 );

	//                 $this->db->insert('voucher_transaction', $data_dr);
	//             }
	//         }
	//     }

	//     // Return the voucher code or insert ID for confirmation
	//     return $voucher_code;
	// }

	public function add_new_receipt123()
	{
		$code_prefix = "RV/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = $this->Accounts_model->get_account_code_count($code_prefix, 'R') + 1;
		$voucher_code = $code_prefix . sprintf("%05d", $num);

		// Get posted data safely
		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');
		$cust_id = $this->input->post('customer_org_id');
		$debtor_account_id = $this->input->post('debtor');
		$narration = $this->input->post('narration');
		$transaction_type = $this->input->post('transaction_type');
		$transaction_no = $this->input->post('transaction_no');
		$user_id = $this->session->userdata('user_id');

		$invoiceIDs = $this->input->post('invoiceID');
		$dr_amounts = $this->input->post('dr_amount');
		$invoice_codes = $this->input->post('invoice_no');

		// Convert date & time to MySQL datetime format
		$voucher_datetime = date('Y-m-d H:i:s', strtotime("$vdate $vtime"));

		// =========================
		// Insert Credit entries - one per invoice
		// =========================
		if (!empty($invoiceIDs) && is_array($invoiceIDs)) {
			foreach ($invoiceIDs as $inv_id) {
				$dr_amount = isset($dr_amounts[$inv_id]) ? (float)$dr_amounts[$inv_id] : 0;
				$invoice_no = isset($invoice_codes[$inv_id]) ? $invoice_codes[$inv_id] : '';

				if ($dr_amount > 0) {
					$data_cr = array(
						'voucher_code'     => $voucher_code,
						'voucher_date'     => $voucher_datetime,
						'voucher_type'     => 'R',
						'customer_id'      => $cust_id,
						'account_id'       => $debtor_account_id,
						'amount'           => $dr_amount,
						'drcr_type'        => 'Cr',
						'narration'        => $narration,
						'trans_id'         => $inv_id,
						'invoice_code'     => $invoice_no,
						'invoice_amount'   => $dr_amount,
						'trans_type'       => 'R',
						'transaction_type' => $transaction_type,
						'transaction_no'   => $transaction_no,
						'recordCreatedBy'  => $user_id
					);

					$this->db->insert('voucher_transaction', $data_cr);

					// Update invoices paid amount safely
					$this->db->set('paid_amt', 'paid_amt + ' . $dr_amount, false);
					$this->db->where('invoice_id', $inv_id);
					$this->db->update('invoices');
				}
			}
		}

		// =========================
		// Insert Debit entries - payment accounts (bank/cash)
		// =========================
		$creditors = $this->input->post('creditor');      // array of account_ids for payment
		$cr_amounts = $this->input->post('cr_amount');    // array of amounts for payment

		if (!empty($creditors) && is_array($creditors)) {
			foreach ($creditors as $key => $creditor_account_id) {
				$cr_amount = isset($cr_amounts[$key]) ? (float)$cr_amounts[$key] : 0;

				if ($cr_amount > 0) {
					$data_dr = array(
						'voucher_code'     => $voucher_code,
						'voucher_date'     => $voucher_datetime,
						'voucher_type'     => 'R',
						'customer_id'      => $cust_id,
						'account_id'       => $creditor_account_id,
						'amount'           => $cr_amount,
						'drcr_type'        => 'Dr',
						'narration'        => $narration,
						'trans_id'         => NULL,
						'trans_type'       => 'R',
						'transaction_type' => $transaction_type,
						'transaction_no'   => $transaction_no,
						'recordCreatedBy'  => $user_id
					);

					$this->db->insert('voucher_transaction', $data_dr);
				}
			}
		}

		return $voucher_code;
	}

	public function add_new_receipt()
	{
		$code_prefix = "RV/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = $this->Accounts_model->get_account_code_count($code_prefix, 'R') + 1;
		$voucher_code = $code_prefix . sprintf("%05d", $num);

		// =========================
		// GET POST DATA
		// =========================
		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');
		$cust_id = $this->input->post('customer_org_id');
		$debtor_account_id = $this->input->post('debtor');
		$narration = $this->input->post('narration');
		$transaction_type = $this->input->post('transaction_type');
		$transaction_no = $this->input->post('transaction_no');
		$user_id = $this->session->userdata('user_id');

		// NEW
		$receipt_mode = $this->input->post('receipt_mode'); // invoice / quotation
		$quotation_id = $this->input->post('quotation_id');

		$invoiceIDs = $this->input->post('invoiceID');
		$dr_amounts = $this->input->post('dr_amount');
		$invoice_codes = $this->input->post('invoice_no');

		$voucher_datetime = date('Y-m-d H:i:s', strtotime("$vdate $vtime"));

		// =====================================================
		// ✅ 1. INVOICE MODE (UNCHANGED - my ORIGINAL CODE)
		// =====================================================
		if ($receipt_mode == 'invoice') {

			if (!empty($invoiceIDs) && is_array($invoiceIDs)) {
				foreach ($invoiceIDs as $inv_id) {

					$dr_amount = isset($dr_amounts[$inv_id]) ? (float)$dr_amounts[$inv_id] : 0;
					$invoice_no = isset($invoice_codes[$inv_id]) ? $invoice_codes[$inv_id] : '';

					if ($dr_amount > 0) {

						$data_cr = array(
							'voucher_code'     => $voucher_code,
							'voucher_date'     => $voucher_datetime,
							'voucher_type'     => 'R',
							'customer_id'      => $cust_id,
							'account_id'       => $debtor_account_id,
							'amount'           => $dr_amount,
							'drcr_type'        => 'Cr',
							'narration'        => $narration,
							'trans_id'         => $inv_id,
							'invoice_code'     => $invoice_no,
							'invoice_amount'   => $dr_amount,
							'trans_type'       => 'R',
							'transaction_type' => $transaction_type,
							'transaction_no'   => $transaction_no,
							'recordCreatedBy'  => $user_id
						);

						$this->db->insert('voucher_transaction', $data_cr);

						// update invoice
						$this->db->set('paid_amt', 'paid_amt + ' . $dr_amount, false);
						$this->db->where('invoice_id', $inv_id);
						$this->db->update('invoices');
					}
				}
			}
		}

		// =====================================================
		// ✅ 2. QUOTATION MODE (NEW)
		// =====================================================
		if ($receipt_mode == 'quotation' && !empty($quotation_id)) {

			// calculate total received (from CR side)
			$creditors = $this->input->post('creditor');
			$cr_amounts = $this->input->post('cr_amount');

			$total_received = 0;

			if (!empty($cr_amounts)) {
				foreach ($cr_amounts as $amt) {
					$total_received += (float)$amt;
				}
			}

			if ($total_received > 0) {

				// Insert ONE customer CR entry (advance)
				$data_cr = array(
					'voucher_code'     => $voucher_code,
					'voucher_date'     => $voucher_datetime,
					'voucher_type'     => 'R',
					'customer_id'      => $cust_id,
					'account_id'       => $debtor_account_id,
					'amount'           => $total_received,
					'drcr_type'        => 'Cr',
					'narration'        => $narration,
					'trans_id'         => $quotation_id, // link to quotation
					'invoice_code'     => 'QT', // optional
					'invoice_amount'   => $total_received,
					'trans_type'       => 'R',
					'transaction_type' => $transaction_type,
					'transaction_no'   => $transaction_no,
					'recordCreatedBy'  => $user_id
				);

				$this->db->insert('voucher_transaction', $data_cr);

				// 🔹 Save mapping in quotation_payments
				$this->db->insert('quotation_payments', [
					'quotation_id'     => $quotation_id,
					'customer_id'      => $cust_id,
					'receipt_id'       => $voucher_code,
					'amount'           => $total_received,
					'adjusted_amount'  => 0
				]);
			}
		}

		// =====================================================
		// ✅ 3. DEBIT ENTRIES (BANK / CASH) — COMMON
		// =====================================================
		$creditors = $this->input->post('creditor');
		$cr_amounts = $this->input->post('cr_amount');

		if (!empty($creditors) && is_array($creditors)) {
			foreach ($creditors as $key => $creditor_account_id) {

				$cr_amount = isset($cr_amounts[$key]) ? (float)$cr_amounts[$key] : 0;

				if ($cr_amount > 0) {

					$data_dr = array(
						'voucher_code'     => $voucher_code,
						'voucher_date'     => $voucher_datetime,
						'voucher_type'     => 'R',
						'customer_id'      => $cust_id,
						'account_id'       => $creditor_account_id,
						'amount'           => $cr_amount,
						'drcr_type'        => 'Dr',
						'narration'        => $narration,
						'trans_id'         => NULL,
						'trans_type'       => 'R',
						'transaction_type' => $transaction_type,
						'transaction_no'   => $transaction_no,
						'recordCreatedBy'  => $user_id
					);

					$this->db->insert('voucher_transaction', $data_dr);
				}
			}
		}

		return $voucher_code;
	}
	function get_receipt_list($from, $to)
	{
		$from_date = date('Y-01-01', strtotime($from));
		$to_date = date('Y-12-31', strtotime($to));

		$query = $this->db->query("select * from  voucher_transaction where voucher_type='R' and date(voucher_date) between '$from_date' and '$to_date' group by voucher_code order by date(voucher_date) desc, voucher_code desc");
		return $query->result();
	}
	//////////////////////////////////////////////////////////

	//////////// Add new Payments ///////////////////
	function add_new_payment() //in use
	{
		$code_prifix = "PV/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'P')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');

		$cust_id = null;
		$supplier_id = $this->input->post('supplier_id');
		$supplier_amt = $this->input->post('supplier_amt');
		/* ===============================
     	  1. FIRST ENTRY (CR SIDE)
   		 =============================== */
		for ($i = 0; $i < count($_POST['first_amount']); $i++) {

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d H:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'P',
				'customer_id' => $supplier_id,
				'account_id' => $_POST['ledger_first_party'][$i],
				'amount' => $_POST['first_amount'][$i],
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				'trans_type' => 'P',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);

			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		/* ===============================
       2. SECOND ENTRY (DR SIDE)
    =============================== */
		if (isset($_POST['second_amount'])) {




			// ✅ Get Supplier Advance Ledger ID
			$adv_ledger = $this->db
				->select('account_id')
				->from('general_ledger')
				->where('account_name', 'Supplier Advance A/c')
				->get()
				->row();

			$SUPPLIER_ADV_LEDGER_ID = $adv_ledger->account_id ?? 0;

			for ($i = 0; $i < count($_POST['second_amount']); $i++) {

				if (isset($_POST['inv'][$i])) {
					$select_invoice = $_POST['inv'][$i];
					$tmp = explode('#', $select_invoice);
					$inv_id = $tmp[0];
					$inv_code =  $tmp[3];
				} else {
					$inv_id = '';
					$inv_code = '';
				}

				$account_id = $_POST['ledger_second_party'][$i];
				$amount = $_POST['second_amount'][$i];
				$group_second_party = $_POST['group_second_party'][$i];

				$data = array(
					'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-d H:i:s', strtotime("$vdate $vtime")),
					'voucher_type' => 'P',
					'customer_id' => $supplier_id, // ✔ now always set
					'account_id' => $account_id,
					'amount' => $amount,
					'drcr_type' => 'Dr',
					'narration' => $this->input->post('narration'),
					'trans_type' => 'P',
					'trans_id' => $inv_id,
					'invoice_code' => $inv_code,
					'invoice_amount' => $amount,
					'recordCreatedBy' => $this->session->userdata('user_id')
				);

				$this->db->insert('voucher_transaction', $data);
				$insert_id = $this->db->insert_id();

				/* ===============================
               3. BILL PAYMENT STATUS UPDATE
            =============================== */
				if ($group_second_party == 30) {

					$ci = get_instance();
					$ci->load->helper('myopeningbalance_helper');

					$paid_amt = get_paid_invoice_amount('customer', $inv_id, $account_id);

					if ($paid_amt >= $amount) {
						// $this->db->query("UPDATE invoice_master SET fully_payment=1 WHERE invoice_id=$inv_id");
					}
				} else if ($group_second_party == 29) {

					$ci = get_instance();
					$ci->load->helper('myopeningbalance_helper');

					// 🔥 adjust advance BEFORE checking full payment
					$advance_used =  $this->adjust_supplier_advance($supplier_id, $amount);

					log_message('debug', 'Advance used: ' . $advance_used);

					$paid_amt = get_paid_invoice_amount('supplier', $inv_id, $account_id);

					if ($paid_amt >= $supplier_amt) {
						// log_message('error', 'GRN Payment Check -> Paid: ' . $paid_amt . ' | Current Amount: ' . $amount . ' | GRN ID: ' . $inv_id);

						// $this->db->query("UPDATE purchase_grn_master SET fully_payment=1 WHERE grn_id=$inv_id");
					}
				}

				/* ===============================
               4. ✅ SUPPLIER ADVANCE INSERT
            =============================== */
				if ($account_id !== $supplier_id && $amount > 0) {

					$this->db->insert('supplier_advances', [
						'supplier_id' => $supplier_id,
						'amount' => $amount,
						'adjusted_amount' => 0,
						'reference_voucher_id' => $insert_id,
						'created_at' => date('Y-m-d H:i:s')
					]);
				}
			}
		}

		/* ===============================
       5. RETURN
    =============================== */
		if ($insert_id) {
			return $insert_id;
		}
	}

	function adjust_supplier_advance($supplier_id, $used_amount)
	{
		$CI = &get_instance();

		$remaining = $used_amount;

		// get advances FIFO
		$advances = $CI->db
			->where('supplier_id', $supplier_id)
			->where('amount > adjusted_amount', null, false)
			->order_by('created_at', 'ASC')
			->get('supplier_advances')
			->result();

		foreach ($advances as $adv) {

			$available = $adv->amount - $adv->adjusted_amount;

			if ($available <= 0) continue;

			$consume = min($available, $remaining);

			// update adjusted_amount
			$CI->db->set('adjusted_amount', 'adjusted_amount + ' . $consume, false)
				->where('id', $adv->id)
				->update('supplier_advances');

			$remaining -= $consume;

			if ($remaining <= 0) break;
		}

		return $used_amount - $remaining; // actual used
	}
	// function add_new_payment() //in use
	// {
	// 	$code_prifix = "PV/" . date('y') . "/";
	// 	$this->load->model('Accounts_model');
	// 	$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'P')) + 1;
	// 	$digit = sprintf("%1$05d", $num);
	// 	$AccountCode = $code_prifix . $digit;

	// 	$vdate = $this->input->post('v_date');
	// 	$vtime = $this->input->post('vtime');

	// 	// ⚠️ FIX: customer_id was undefined in your code
	// 	$cust_id = null;

	// 	/* ===============================
	//    1. FIRST ENTRY (CR SIDE)
	// 	=============================== */
	// 	for ($i = 0; $i < count($_POST['first_amount']); $i++) {

	// 		$data = array(
	// 			'voucher_code' => $AccountCode,
	// 			'voucher_date' => date('Y-m-d H:i:s', strtotime("$vdate $vtime")),
	// 			'voucher_type' => 'P',
	// 			'customer_id' => $cust_id,
	// 			'account_id' => $_POST['ledger_first_party'][$i],
	// 			'amount' => $_POST['first_amount'][$i],
	// 			// 'drcr_type' => $_POST['first_type'][$i],
	// 			'drcr_type' =>'Cr',
	// 			'narration' => $this->input->post('narration'),
	// 			'trans_type' => 'P',
	// 			'recordCreatedBy' => $this->session->userdata('user_id')
	// 		);

	// 		$this->db->insert('voucher_transaction', $data);
	// 		$insert_id = $this->db->insert_id();
	// 	}

	// 	/* ===============================
	//   	 2. SECOND ENTRY (DR SIDE)
	// 	 =============================== */
	// 	if (isset($_POST['second_amount'])) {

	// 		// 🔍 STEP 1: Find supplier (creditor row)
	// 		$supplier_id = null;

	// 		for ($j = 0; $j < count($_POST['ledger_second_party']); $j++) {
	// 			if ($_POST['group_second_party'][$j] == 29) { // 29 = Sundry Creditors
	// 				$supplier_id = $_POST['ledger_second_party'][$j];
	// 				break;
	// 			}
	// 		}

	// 		// 🔍 STEP 2: Get Supplier Advance Ledger ID dynamically
	// 		$adv_ledger = $this->db
	// 			->select('account_id')
	// 			->from('general_ledger') // ⚠️ change if your table name is different
	// 			->where('account_name', 'Supplier Advance A/c')
	// 			->get()
	// 			->row();

	// 		$SUPPLIER_ADV_LEDGER_ID = $adv_ledger->id ?? 0;

	// 		for ($i = 0; $i < count($_POST['second_amount']); $i++) {

	// 			if (isset($_POST['inv'][$i])) {
	// 				$select_invoice = $_POST['inv'][$i];
	// 				$tmp = explode('#', $select_invoice);
	// 				$inv_id = $tmp[0];
	// 			} else {
	// 				$inv_id = '';
	// 			}

	// 			$account_id = $_POST['ledger_second_party'][$i];
	// 			$amount = $_POST['second_amount'][$i];
	// 			$group_second_party = $_POST['group_second_party'][$i];

	// 			$data = array(
	// 				'voucher_code' => $AccountCode,
	// 				'voucher_date' => date('Y-m-d H:i:s', strtotime("$vdate $vtime")),
	// 				'voucher_type' => 'P',
	// 				'customer_id' => $supplier_id,
	// 				'account_id' => $account_id,
	// 				'amount' => $amount,
	// 				// 'drcr_type' => $_POST['second_type'][$i],
	// 				'drcr_type' =>'Dr',
	// 				'narration' => $this->input->post('narration'),
	// 				'trans_type' => 'P',
	// 				'trans_id' => $inv_id,
	// 				'recordCreatedBy' => $this->session->userdata('user_id')
	// 			);

	// 			$this->db->insert('voucher_transaction', $data);
	// 			$insert_id = $this->db->insert_id();

	// 			/* ===============================
	//            3. BILL PAYMENT STATUS UPDATE
	//         =============================== */
	// 			if ($group_second_party == 30) {
	// 				$ci = get_instance();
	// 				$ci->load->helper('myopeningbalance_helper');
	// 				$paid_amt = get_paid_invoice_amount('customer', $inv_id, $account_id);

	// 				if ($paid_amt >= $amount) {
	// 					$this->db->query("UPDATE invoice_master SET fully_payment=1 WHERE invoice_id=$inv_id");
	// 				}
	// 			} else if ($group_second_party == 29) {
	// 				$ci = get_instance();
	// 				$ci->load->helper('myopeningbalance_helper');
	// 				$paid_amt = get_paid_invoice_amount('supplier', $inv_id, $account_id);

	// 				if ($paid_amt >= $amount) {
	// 					$this->db->query("UPDATE purchase_grn_master SET fully_payment=1 WHERE grn_id=$inv_id");
	// 				}
	// 			}

	// 			/* ===============================
	//        	    4. ✅ SUPPLIER ADVANCE INSERT
	//         =============================== */
	// 			if ($account_id == $SUPPLIER_ADV_LEDGER_ID && $amount > 0) {

	// 				if ($supplier_id) {

	// 					$this->db->insert('supplier_advances', [
	// 						'supplier_id' => $supplier_id,
	// 						'amount' => $amount,
	// 						'adjusted_amount' => 0,
	// 						'reference_voucher_id' => $insert_id,
	// 						'created_at' => date('Y-m-d H:i:s')
	// 					]);
	// 				}
	// 			}
	// 		}
	// 	}

	// 	/* ===============================
	//   	 5. LOG ENTRY
	// 	 =============================== */
	// 	if ($insert_id) {

	// 		// $uid = $this->session->userdata('user_id');
	// 		// $page_name = explode('index.php/', $_SERVER['PHP_SELF']);

	// 		// $ci = get_instance();
	// 		// $ci->load->helper('log');

	// 		// add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);

	// 		return $insert_id;
	// 	}
	// }
	function add_new_payment11() //in use
	{
		// receipt entry Cr to customer dr to bank/cash

		$code_prifix = "PV/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'P')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');

		// first entry
		for ($i = 0; $i < count($_POST['first_amount']); $i++) {
			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'P',  /// P stands for Payment
				'customer_id' => $cust_id,
				'account_id' => $_POST['ledger_first_party'][$i],
				'amount' => $_POST['first_amount'][$i],
				'drcr_type' => $_POST['first_type'][$i],
				'narration' => $this->input->post('narration'),
				'trans_type' => 'P',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		// second entry
		if (isset($_POST['second_amount'])) {
			for ($i = 0; $i < count($_POST['second_amount']); $i++) {
				if (isset($_POST['inv'][$i])) {
					$select_invoice = $_POST['inv'][$i];
					$tmp = explode('#', $select_invoice);
					$inv_id = $tmp[0];
				} else {
					$inv_id = '';
				}

				$account_id = $_POST['ledger_second_party'][$i];
				$amount = $_POST['second_amount'][$i];

				$data = array(
					'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
					'voucher_type' => 'P',  /// P stands for Payment
					'customer_id' => $cust_id,
					'account_id' => $account_id,
					'amount' => $amount,
					'drcr_type' => $_POST['second_type'][$i],
					'narration' => $this->input->post('narration'),
					'trans_type' => 'P',
					'trans_id' => $inv_id,
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$insert_id = $this->db->insert_id();

				$group_second_party = $_POST['group_second_party'][$i];




				if ($group_second_party == 30) //debtors group -- customers
				{
					$ci = get_instance();
					$ci->load->helper('myopeningbalance_helper');
					$paid_amt = get_paid_invoice_amount('customer', $inv_id, $account_id);
					if ($paid_amt >= $amount)
						$query = $this->db->query("update invoice_master set fully_payment=1 where invoice_id=$inv_id");
				} else if ($group_second_party == 29) //creditors group -- supplier
				{
					$ci = get_instance();
					$ci->load->helper('myopeningbalance_helper');
					$paid_amt = get_paid_invoice_amount('supplier', $inv_id, $account_id);
					if ($paid_amt >= $amount)
						$query = $this->db->query("update GRN_master set fully_payment=1 where grn_id=$inv_id");
				}
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			return $insert_id;
		}
	}
	// function add_new_payment() //in use
	// {
	// 	// receipt entry Cr to customer dr to bank/cash

	// 	$code_prifix = "PVF/P/" . date('y') . "/";
	// 	$this->load->model('Accounts_model');
	// 	$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'P')) + 1;
	// 	$digit = sprintf("%1$05d", $num);
	// 	$AccountCode = $code_prifix . $digit;

	// 	$vdate = $this->input->post('v_date');
	// 	$vtime = $this->input->post('vtime');
	// 	$inv_id = $this->input->post('invoice_id');
	// 	/// debit entry 
	// 	for ($i = 0; $i < count($_POST['debtor']); $i++) {
	// 		$debtor = $_POST['debtor'][$i];
	// 		$dr_amount = $_POST['dr_amount'][$i];

	// 		$data = array(
	// 			'voucher_code' => $AccountCode,
	// 			'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
	// 			'voucher_type' => 'P',
	// 			/// P stands for Payment
	// 			//'customer_id' => $cust_id,
	// 			'account_id' => $debtor,
	// 			'amount' => $dr_amount,
	// 			'drcr_type' => 'Dr',
	// 			'narration' => $this->input->post('narration'),
	// 			'trans_type' => 'P',
	// 			'trans_id' => $inv_id,
	// 			'recordCreatedBy' => $this->session->userdata('user_id')
	// 		);
	// 		$this->db->insert('voucher_transaction', $data);
	// 		$insert_id = $this->db->insert_id();
	// 	}

	// 	// credit entry
	// 	for ($i = 0; $i < count($_POST['creditor']); $i++) {
	// 		$creditor = $_POST['creditor'][$i];
	// 		$cr_amount = $_POST['cr_amount'][$i];

	// 		$data = array(
	// 			'voucher_code' => $AccountCode,
	// 			'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
	// 			'voucher_type' => 'P',
	// 			/// P stands for Payment
	// 			//'customer_id' => $cust_id,
	// 			'account_id' => $creditor,
	// 			'amount' => $cr_amount,
	// 			'drcr_type' => 'Cr',
	// 			'narration' => $this->input->post('narration'),
	// 			'trans_type' => 'P',
	// 			'trans_id' => $inv_id,
	// 			'recordCreatedBy' => $this->session->userdata('user_id')
	// 		);
	// 		$this->db->insert('voucher_transaction', $data);
	// 		$insert_id = $this->db->insert_id();
	// 	}

	// 	if ($insert_id) {
	// 		$user_se_id = $this->session->userdata('session_id');
	// 		$uid = $this->session->userdata('user_id');
	// 		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
	// 		$ci = get_instance();
	// 		$ci->load->helper('log');
	// 		$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
	// 		return $insert_id;
	// 	}

	// }


	public function add_new_payment_data()
	{
		$code_prifix = "PV/" . date('y') . "/";
		$this->load->model('Accounts_model');

		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'P')) + 1;
		$digit = sprintf("%05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');
		$supplier_id = $this->input->post('debtor');  // Your select supplier input name is "debtor"
		$transaction_type = $this->input->post('transaction_type');
		$transaction_no = $this->input->post('transaction_no');
		$narration = $this->input->post('narration');

		$invoiceIDs = $this->input->post('invoiceID');       // Array of selected invoice IDs
		$dr_amounts = $this->input->post('dr_amount');       // Associative array: invoiceID => amount
		$grn_codes = $this->input->post('grn_code');         // Associative array: invoiceID => invoice code

		// Compose voucher datetime
		$voucher_datetime = date('Y-m-d H:i:s', strtotime("$vdate $vtime"));

		// Insert debit entries (payment details for invoices)
		if (!empty($invoiceIDs) && is_array($invoiceIDs)) {
			foreach ($invoiceIDs as $inv_id) {
				$dr_amount = isset($dr_amounts[$inv_id]) ? $dr_amounts[$inv_id] : 0;
				$invoice_no = isset($grn_codes[$inv_id]) ? $grn_codes[$inv_id] : '';

				if ($dr_amount <= 0) {
					// Skip zero or negative amounts
					continue;
				}

				$data = [
					'voucher_code'      => $AccountCode,
					'voucher_date'      => $voucher_datetime,
					'voucher_type'      => 'P',
					'customer_id'       => $supplier_id,
					'account_id'        => $supplier_id,    // Assuming debtor is the account here; adjust if needed
					'amount'            => $dr_amount,
					'drcr_type'         => 'Dr',
					'narration'         => $narration,
					'trans_id'          => $inv_id,
					'invoice_code'      => $invoice_no,
					'invoice_amount'    => $dr_amount,
					'trans_type'        => 'P',
					'transaction_type'  => $transaction_type,
					'transaction_no'    => $transaction_no,
					'recordCreatedBy'   => $this->session->userdata('user_id')
				];

				$this->db->insert('voucher_transaction', $data);

				// Update paid amount in GRN_master by adding current payment
				// $this->db->set('paid_amt', 'paid_amt + ' . (float)$dr_amount, FALSE)
				// 	->where('grn_id', $inv_id)
				// 	->update('purchase_grn_master');
			}
		}

		// Insert credit entries (creditors/payment source)
		$creditors = $this->input->post('creditor');
		$cr_amounts = $this->input->post('cr_amount');

		if (!empty($creditors) && is_array($creditors)) {
			foreach ($creditors as $key => $creditor_id) {
				$cr_amount = isset($cr_amounts[$key]) ? $cr_amounts[$key] : 0;

				if ($cr_amount <= 0) {
					continue;
				}

				$data = [
					'voucher_code'      => $AccountCode,
					'voucher_date'      => $voucher_datetime,
					'voucher_type'      => 'P',
					'customer_id'       => $supplier_id,
					'account_id'        => $creditor_id,
					'amount'            => $cr_amount,
					'drcr_type'         => 'Cr',
					'narration'         => $narration,
					'trans_id'          => 0,
					'invoice_code'      => '',
					'invoice_amount'    => 0,
					'trans_type'        => 'P',
					'transaction_type'  => $transaction_type,
					'transaction_no'    => $transaction_no,
					'recordCreatedBy'   => $this->session->userdata('user_id')
				];

				$this->db->insert('voucher_transaction', $data);
			}
		}

		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			// $user_id = $this->session->userdata('user_id');
			// $page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			// $ci = get_instance();
			// $ci->load->helper('log');
			// add_log_entry($user_id, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);

			return $insert_id;
		}

		return false;
	}


	function add_new_payment_data1() //in use
	{

		$code_prifix = "BES/P/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'P')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;


		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');
		$supplier_id = $this->input->post('supplier_id');
		$transaction_type = $this->input->post('transaction_type');
		$transaction_no   = $this->input->post('transaction_no');
		/// debit entry 
		for ($i = 0; $i < count($_POST['inv_id']); $i++) {

			$inv_id = $_POST['inv_id'][$i];
			$dr_amount =  $this->input->post("dr_amount$inv_id");
			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'P',
				/// R stands for Receipt
				'customer_id' => $supplier_id,
				'account_id' => $this->input->post('debtor'),
				'amount' => $dr_amount,
				'drcr_type' => 'Dr',
				'narration' => $this->input->post('narration'),
				'trans_id' => $inv_id,
				'trans_type' => 'P',
				'transaction_type' => $transaction_type,
				'transaction_no'   => $transaction_no,
				'recordCreatedBy' => $this->session->userdata('user_id')
			);

			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
			$this->db->query("update GRN_master set paid_amt=$dr_amount where grn_id=$inv_id");
		}

		// debit entry
		for ($i = 0; $i < count($_POST['creditor']); $i++) {
			$creditor = $_POST['creditor'][$i];
			$cr_amount = $_POST['cr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'P',
				/// R stands for Receipt
				'customer_id' => $supplier_id,
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				'trans_id' => $inv_id,
				'trans_type' => 'P',
				'transaction_type' => $transaction_type,
				'transaction_no'   => $transaction_no,

				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			//echo "Callin her2"; exit;

			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			return $insert_id;
		}
	}



	function get_payment_list_old($from, $to)
	{
		$from_date = date('Y-01-01', strtotime($from));
		$to_date = date('Y-12-31', strtotime($to));

		$query = $this->db->query("select * from  voucher_transaction where voucher_type='P' and date(voucher_date) between '$from_date' and '$to_date' group by voucher_code order by date(voucher_date) desc, voucher_code desc");
		return $query->result();
	}

	function get_payment_list($from, $to)
	{
		$from_date = date('Y-01-01', strtotime($from));
		$to_date   = date('Y-12-31', strtotime($to));

		$query = $this->db->query("
        SELECT 
            voucher_transaction.*,
            SUM(
                CASE 
                    WHEN drcr_type = 'Dr' THEN amount 
                    ELSE 0 
                END
            ) AS total_amount

        FROM voucher_transaction

        WHERE voucher_type = 'P'
        AND DATE(voucher_date) BETWEEN '$from_date' AND '$to_date'

        GROUP BY voucher_code

        ORDER BY DATE(voucher_date) DESC, voucher_code DESC
    ");

		return $query->result();
	}


	function delete_trans_entry($voucher_code)
	{
		$query = $this->db->query("update voucher_transaction set cancel=1 where voucher_code='$voucher_code' ");
		return true;
	}

	//////////////////////////////////////////////////////////

	function get_customer_id_using_accountid($account_id)
	{
		$query = $this->db->query("select if(customer_id ,customer_id, supplier_id) as customer_id from general_ledger where account_id = '$account_id'");
		return $query->row('customer_id');
	}

	function update_transaction_details()
	{
		for ($i = 0; $i < count($_POST['amount']); $i++) {

			$amount = $_POST['amount'][$i];
			$voucher_id = $_POST['voucher_id'][$i];

			$data = array(
				'voucher_date' => date('Y-m-d', strtotime($this->input->post('v_date'))),
				'amount' => $amount,
				'narration' => $this->input->post('narration'),
			);
			$this->db->where('voucher_id', $voucher_id);
			$this->db->update('voucher_transaction', $data);
		}
		return true;
	}
	function get_acc_details()
	{
		$type = $this->input->post('type');

		$query = $this->db->query("select one.id, concat(coalesce(two.cust_code,''),' ',one.value)as value from (select gl.account_id as id, gl.gl_code, gl.account_name as value, gl.group_no, gl.customer_id, gl.supplier_id, gl.isdeleteable, gl.opening_balance, gl.opening_bal_type, gl.date, ag.group_name from general_ledger gl, account_group ag  where gl.group_no=ag.group_no and ag.group_no='$type') as one left join (select * from customers) as two on(one.customer_id=two.customer_id)");
		return $query->result();
	}

	// function get_ledger_report($acc_id, $from_date, $to_date)
	// {

	// 	if (empty($acc_id) || empty($from_date) || empty($to_date)) {
	//     return [];
	//     }
	// 	$from_date = date('Y-m-d', strtotime($from_date));
	// 	$to_date = date('Y-m-d', strtotime($to_date));
	// 	$condition = "";

	// 	$query = $this->db->query("select customer_id, supplier_id, group_no from general_ledger where account_id=$acc_id ");
	// 	$res = $query->result();

	// 	foreach ($res as $r) {
	// 		if ($r->group_no == 29) //sundry creditors
	// 		{
	// 			$query = $this->db->query("select one.*, invoice_no as ref_no, invoice_date as invoice_date, po_code as po_code  from(select v.*,g. account_name,g.opening_balance from general_ledger g,voucher_transaction v where g.account_id=$acc_id and v.account_id=g.account_id and date(v.voucher_date) between '$from_date' and '$to_date' and v.cancel=0 $condition order by v.voucher_date, voucher_id)as one  left join(select g.invoice_no,grn_id,g.invoice_date, o.po_code from GRN_master g, purchase_order o where g.po_id=o.po_id)as two on(one.trans_id=two.grn_id) ");
	// 		} else if ($r->group_no == 30) //sundry debitors
	// 		{
	// 			$query = $this->db->query("select one.*, three.invoice_no as ref_no, three.invoice_date as invoice_date, three.po_number as po_code from(select v.*,g. account_name,g.opening_balance from general_ledger g,voucher_transaction v where g.account_id=$acc_id and v.account_id=g.account_id and date(v.voucher_date) between '$from_date' and '$to_date' and v.cancel=0 $condition order by v.voucher_date, voucher_id)as one left join(select * from invoices)as three on(one.trans_id=three.invoice_id)");
	// 		} else //others
	// 		{
	// 			$query = $this->db->query("select one.*, if(one.voucher_type='G',two.invoice_no,three.invoice_no)as ref_no, if(one.voucher_type='G',two.invoice_date,three.invoice_date)as invoice_date, if(one.voucher_type='G',two.po_code, three.po_number)as po_code from(select v.*,g. account_name,g.opening_balance from general_ledger g,voucher_transaction v where g.account_id=$acc_id and v.account_id=g.account_id and date(v.voucher_date) between '$from_date' and '$to_date' and v.cancel=0 $condition order by v.voucher_date, voucher_id)as one  left join(select g.invoice_no,grn_id,g.invoice_date, o.po_code from GRN_master g, purchase_order o where g.po_id=o.po_id)as two on(one.trans_id=two.grn_id) left join(select * from invoices)as three on(one.trans_id=three.invoice_id)");
	// 		}
	// 	}
	// 	return $query->result();

	// }


	function get_ledger_report($acc_id, $from_date, $to_date)
	{
		// log_message('error', 'accid' . $acc_id);
		if (empty($acc_id) || empty($from_date) || empty($to_date)) {
			return [];
		}

		$from_date = date('Y-m-d', strtotime($from_date));
		$to_date = date('Y-m-d', strtotime($to_date));
		$condition = "";

		// Get group info safely
		$query = $this->db->query("SELECT customer_id, supplier_id, group_no FROM general_ledger WHERE account_id = ?", [$acc_id]);
		$res = $query->result();

		if (empty($res)) {
			return [];
		}

		$group_no = $res[0]->group_no;

		// Common base SQL
		$base_sql = "
        SELECT v.*, g.account_name, g.opening_balance
        FROM general_ledger g
        JOIN voucher_transaction v ON v.account_id = g.account_id
        WHERE g.account_id = ?
        AND DATE(v.voucher_date) BETWEEN ? AND ?
        AND v.cancel = 0
        $condition
        ORDER BY v.voucher_date, voucher_id
    ";

		if ($group_no == 29) {
			// Sundry Creditors
			$query = $this->db->query("
            SELECT one.*, two.invoice_no AS ref_no, two.invoice_date, two.po_code
            FROM ($base_sql) AS one
            LEFT JOIN (
                SELECT g.invoice_no, g.grn_id, g.invoice_date, o.po_code
                FROM purchase_grn_master g
                JOIN purchase_order_master o ON g.po_id = o.po_id
            ) AS two ON one.trans_id = two.grn_id
        ", [$acc_id, $from_date, $to_date]);
		} elseif ($group_no == 30) {
			// Sundry Debtors  
			$query = $this->db->query("
            SELECT one.*, three.invoice_no AS ref_no, three.invoice_date, three.po_number AS po_code
            FROM ($base_sql) AS one
            LEFT JOIN invoices AS three ON one.trans_id = three.invoice_id
        ", [$acc_id, $from_date, $to_date]);
		} else {
			// Others
			// 	include when purchase module integratetion
			// 	$query = $this->db->query("
			//     SELECT one.*, 
			//            IF(one.voucher_type = 'G', two.invoice_no, three.invoice_no) AS ref_no,
			//            IF(one.voucher_type = 'G', two.invoice_date, three.invoice_date) AS invoice_date,
			//            IF(one.voucher_type = 'G', two.po_code, three.po_number) AS po_code
			//     FROM ($base_sql) AS one
			//     LEFT JOIN (
			//         SELECT g.invoice_no, g.grn_id, g.invoice_date, o.po_code
			//         FROM GRN_master g
			//         JOIN purchase_order o ON g.po_id = o.po_id
			//     ) AS two ON one.trans_id = two.grn_id
			//     LEFT JOIN invoices AS three ON one.trans_id = three.invoice_id
			// ", [$acc_id, $from_date, $to_date]);
			$query = $this->db->query("
					SELECT one.*, 
						three.invoice_no AS ref_no,
						three.invoice_date AS invoice_date,
						three.po_number AS po_code
					FROM ($base_sql) AS one
					LEFT JOIN invoices AS three 
						ON one.trans_id = three.invoice_id
				", [$acc_id, $from_date, $to_date]);
		}

		return $query->result();
	}

	function get_cust_id_from_account_id($acc_id)
	{
		$query = $this->db->query("select customer_id from general_ledger where account_id=$acc_id and group_no=30");
		return $query->row('customer_id');
	}
	function get_supp_id_from_account_id($acc_id)
	{
		if (empty($acc_id)) {
			return false; // or null, or throw an error
		}

		$query = $this->db->query("select supplier_id from general_ledger where account_id = ? and group_no = 29", array($acc_id));
		return $query->row('supplier_id');
	}



	// function get_invoice_list()
	// {

	// 	$query = $this->db->query("SELECT * FROM invoices i JOIN customers c ON i.customer_id = c.customer_id JOIN sales_quotation_master sm ON i.customer_id = sm.customer_id;");
	// 	return $query->result();
	// }

	function get_Purchase_invoice_list()
	{

		$query = $this->db->query("select grn_code, grn_id, c.supplier_id, supplier_name , grand_total  from GRN_master  e, supplier_master c where e.supplier_id=c.supplier_id  order by invoice_date desc");
		return $query->result();
	}

	function get_Purchase_invoice_list_by_id($id)
	{
		//$query = $this->db->query("SELECT grn_code,grn_id,e.supplier_id,supplier_name,grand_total,COALESCE(two.amount, 0) AS amount FROM GRN_master e JOIN supplier_master c ON e.supplier_id = c.supplier_id LEFT JOIN (SELECT grn_master_id,COALESCE(SUM(total), 0) AS amount FROM GRN_transaction WHERE grn_master_id = $id) AS two ON e.grn_id = two.grn_master_id WHERE grn_id = $id ORDER BY invoice_date DESC");
		$query = $this->db->query("select * from (select grand_total from GRN_master where grn_id='$id')as one left join(select coalesce(sum(amount),0)as amount from voucher_transaction  where voucher_type='P' and trans_id=$id and drcr_type='Cr')as two on(1=1) ");
		return $query->result();
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function get_all_outstanding_report_accounts()
	{
		$query = $this->db->query("select * from voucher_transaction ");
		return $query->result();
	}

	// function get_outstanding_report($account_id,$from_date, $to_date)
	// {
	// 	if ($from_date == '') {
	// 		return;
	// 	}

	// 	$from_date = date('Y-m-d', strtotime($this->input->post('from_date')));
	// 	$to_date= date('Y-m-d', strtotime($this->input->post('to_date')));

	// 	$condition = "";
	// 	$account_id = $this->input->post('account_id');
	// 	if ($account_id != "") {
	// 		$condition = "and account_id=$account_id ";
	// 	}else {
	// 		$condition = "";
	// 	}


	// 	$query = $this->db->query("SELECT * from voucher_transaction where date(voucher_date ) between  '$from_date' AND '$to_date' $condition GROUP BY voucher_code");
	// 	return $query->result();
	// }


	// function get_outstanding_report($voucher_date)
	// {



	// 	$voucher_date= date('Y-m-d', strtotime($this->input->post('voucher_date')));


	// 	$query = $this->db->query("select * from (select one.*, (one.amount-coalesce(two.recevied_amt,0))as due_amount from (select v.account_id, trans_id, voucher_code , voucher_date, amount, 
	// 	name from voucher_transaction v, customers c, general_ledger g where v.customer_id=c.customer_id and v.account_id=g.account_id and g.group_no=30 and DATE (voucher_date)<'$voucher_date' and voucher_type ='S' and cancel=0) as one left join(select trans_id, account_id, coalesce(sum(amount),0)as recevied_amt from voucher_transaction where voucher_type ='R' group by trans_id, account_id) as two on(one.trans_id=two.trans_id and one.account_id=two.account_id)) as three where due_amount>0");
	// 	return $query->result();
	// }

	function get_outstanding_report($from_date, $to_date, $ledger_id = null)
	{
		$params = [$from_date, $to_date];
		$ledger_condition = "";

		if (!empty($ledger_id)) {
			$ledger_condition = " AND g.customer_id = ? ";
			$params[] = $ledger_id;
		}

		$sql = "
        SELECT
            v.account_id,
            g.account_name AS name,
            v.trans_id,
            v.voucher_code,
            v.voucher_date,
            ROUND(SUM(v.amount), 2) AS sum_amt,
            ROUND(COALESCE(SUM(r.received_amt), 0), 2) AS sum_received_amt,
            ROUND(SUM(v.amount) - COALESCE(SUM(r.received_amt), 0), 2) AS sum_due_amt,
            DATEDIFF(CURDATE(), v.voucher_date) AS due_days
        FROM voucher_transaction v
        JOIN general_ledger g ON v.account_id = g.account_id
        LEFT JOIN (
            SELECT trans_id, account_id, SUM(amount) AS received_amt
            FROM voucher_transaction
            WHERE voucher_type = 'R'
            GROUP BY trans_id, account_id
        ) r ON v.trans_id = r.trans_id AND v.account_id = r.account_id
        WHERE
            g.group_no = 30
            AND v.voucher_type = 'S'
            AND v.cancel = 0
            AND DATE(v.voucher_date) BETWEEN ? AND ?
            $ledger_condition
        GROUP BY
            v.account_id, v.trans_id, v.voucher_code, v.voucher_date, g.account_name
        HAVING
            sum_due_amt > 0
        ORDER BY
            v.voucher_date ASC;
    ";

		return $this->db->query($sql, $params)->result();
	}



	function get_sundry_creditors_outstanding($from_date, $to_date, $ledger_id = null)
	{
		$params = [$from_date, $to_date];
		$ledger_condition = "";

		if (!empty($ledger_id)) {
			$ledger_condition = " AND g.supplier_id = ? ";
			$params[] = $ledger_id;
		}

		$sql = "
        SELECT 
            v.account_id, 
            g.account_name, 
            v.trans_id, 
            v.voucher_code, 
            v.voucher_date, 
            SUM(v.amount) AS sum_amt, 
            COALESCE(SUM(paid.paid_amt), 0) AS sum_paid_amt,  
            SUM(v.amount) - COALESCE(SUM(paid.paid_amt), 0) AS sum_due_amt, 
            DATEDIFF(CURDATE(), v.voucher_date) AS due_days
        FROM 
            voucher_transaction v
        JOIN 
            general_ledger g ON v.account_id = g.account_id
        LEFT JOIN (
            SELECT 
                trans_id, 
                account_id, 
                SUM(amount) AS paid_amt
            FROM voucher_transaction
            WHERE voucher_type = 'P'
            GROUP BY trans_id, account_id
        ) AS paid 
            ON v.trans_id = paid.trans_id 
           AND v.account_id = paid.account_id
        WHERE 
            g.group_no = 29
            AND v.voucher_type = 'G'
            AND v.cancel = 0
            AND DATE(v.voucher_date) BETWEEN ? AND ?
            $ledger_condition
        GROUP BY 
            v.account_id, v.trans_id, v.voucher_code, v.voucher_date, g.account_name
        HAVING 
            sum_due_amt > 0
        ORDER BY 
            v.voucher_date;
    ";

		return $this->db->query($sql, $params)->result();
	}

	function get_ledgers_by_group($group_no)
	{
		if ($group_no == 29) {
			$sql = "SELECT supplier_id AS account_id,account_name FROM general_ledger WHERE group_no = 29 ";
		} elseif ($group_no == 30) {
			$sql = " SELECT customer_id AS account_id, account_name FROM general_ledger WHERE group_no = 30 ";
		} else {
			return [];
		}

		$query = $this->db->query($sql);
		return $query->result();
	}


	public function get_outstanding_report111($voucher_date, $request_type)
	{
		$voucher_date = date('Y-m-d', strtotime($voucher_date));

		if ($request_type === 'Sundry Debtors') {
			$group_no = 30;
			$main_voucher_type = 'S';
			$adjust_voucher_type = 'R';
		} elseif ($request_type === 'Sundry Creditors') {
			$group_no = 29;
			$main_voucher_type = 'P';
			$adjust_voucher_type = 'P';
		} else {
			return [];
		}

		$sql = "
        SELECT 
            v.account_id,
            g.account_name,
            v.trans_id,
            v.voucher_code,
            v.voucher_date,
            SUM(v.amount) AS sum_amt,
            SUM(v.amount - COALESCE(paid.received_amt, 0)) AS sum_due_amt
        FROM 
            voucher_transaction v
        JOIN 
            general_ledger g ON v.account_id = g.account_id
        LEFT JOIN 
            (
                SELECT 
                    trans_id, 
                    account_id, 
                    SUM(amount) AS received_amt
                FROM 
                    voucher_transaction
                WHERE 
                    voucher_type = ?
                GROUP BY 
                    trans_id, account_id
            ) AS paid 
            ON v.trans_id = paid.trans_id AND v.account_id = paid.account_id
        WHERE 
            g.group_no = ?
            AND v.voucher_type = ?
            AND v.cancel = 0
            AND DATE(v.voucher_date) < ?
        GROUP BY 
            v.account_id, v.trans_id
        HAVING 
            sum_due_amt > 0
        ORDER BY 
            v.voucher_date
    ";

		$query = $this->db->query($sql, [$adjust_voucher_type, $group_no, $main_voucher_type, $voucher_date]);
		return $query->result();
	}


	// function get_outstanding_individual_ledger($id,$from_date,$to_date)
	// {
	//  $sql = "
	//         SELECT * FROM (
	//             SELECT 
	//                 one.*, 
	//                 (one.amount - COALESCE(two.received_amt, 0)) AS due_amount 
	//             FROM (
	//                 SELECT 
	//                     v.account_id, 
	//                     v.trans_id, 
	//                     v.voucher_code, 
	//                     v.voucher_date, 
	//                     v.amount, 
	//                     c.name 
	//                 FROM 
	//                     voucher_transaction v
	//                 JOIN 
	//                     customers c ON v.customer_id = c.customer_id
	//                 JOIN 
	//                     general_ledger g ON v.account_id = g.account_id
	//                 WHERE 
	//                     g.group_no = 30
	//                     AND v.voucher_type = 'S'
	//                     AND v.cancel = 0
	//                     AND DATE(v.voucher_date) BETWEEN ? AND ?
	//             ) AS one
	//             LEFT JOIN (
	//                 SELECT 
	//                     trans_id, 
	//                     account_id, 
	//                     COALESCE(SUM(amount), 0) AS received_amt 
	//                 FROM 
	//                     voucher_transaction 
	//                 WHERE 
	//                     voucher_type = 'R' 
	//                 GROUP BY 
	//                     trans_id, account_id
	//             ) AS two 
	//             ON (one.trans_id = two.trans_id AND one.account_id = two.account_id)
	//         ) AS three 
	//         WHERE 
	//             due_amount > 0 
	//             AND account_id = ?
	//     ";

	//     $query = $this->db->query($sql, array($from_date, $to_date, $id));
	//     return $query->result();

	// }
	public function get_outstanding_individual_ledger($id, $from_date, $to_date)
	{
		$sql = "
        SELECT * FROM (
            SELECT 
                one.*,
                (one.amount - COALESCE(two.received_amt, 0)) AS due_amount
            FROM (
                SELECT 
                    v.account_id,
                    v.trans_id,
                    v.voucher_code,
                    v.voucher_date,
                    v.amount,
                    g.group_no,
                    CASE 
                        WHEN g.group_no = 30 THEN c.name 
                        WHEN g.group_no = 29 THEN s.supplier_name 
                        ELSE 'Unknown' 
                    END AS party_name
                FROM 
                    voucher_transaction v
                JOIN 
                    general_ledger g ON v.account_id = g.account_id
                LEFT JOIN 
                    customers c ON v.customer_id = c.customer_id
                LEFT JOIN 
                    supplier_master s ON v.account_id = s.supplier_id
                WHERE 
                    v.account_id = ?
                    AND v.cancel = 0
                    AND DATE(v.voucher_date) BETWEEN ? AND ?
                    AND v.voucher_type IN ('S', 'P') -- Sales for Debtors, Purchase for Creditors
            ) AS one
            LEFT JOIN (
                SELECT 
                    trans_id, account_id, SUM(amount) AS received_amt
                FROM 
                    voucher_transaction
                WHERE 
                    voucher_type = 'R' -- Receipt (you can adjust if needed)
                GROUP BY 
                    trans_id, account_id
            ) AS two
            ON (one.trans_id = two.trans_id AND one.account_id = two.account_id)
        ) AS three
        WHERE due_amount > 0
    ";

		$query = $this->db->query($sql, [$id, $from_date, $to_date]);
		return $query->result();
	}


	// public function get_receipt_header($voucher_code) {
	//         $this->db->select('vt.*, cm.name as customer_name, gl.account_name as credit_account_name');
	//         $this->db->from('voucher_transaction vt');
	//         $this->db->join('customers cm', 'cm.customer_id = vt.customer_id', 'left');
	//         $this->db->join('general_ledger gl', 'gl.account_id = vt.account_id', 'left'); // Assuming account_id references credit account
	//         $this->db->where('vt.voucher_code', $voucher_code);
	//         $query = $this->db->get();

	//         return $query->row(); 
	// }
	public function get_receipt_header($voucher_code)
	{
		log_message('error', 'Voucher Code: ' . $voucher_code);

		$this->db->select('
			vt.voucher_code,
			vt.voucher_id,
			vt.voucher_date,
			vt.voucher_type,
			SUM(vt.amount) as amount,
			vt.customer_id,
			cm.name as customer_name,
			vt.transaction_type,
			vt.transaction_no,
			gl.account_name as credit_account_name,
			vt.narration,
			GROUP_CONCAT(cr.invoice_code SEPARATOR ", ") AS invoice_codes,
		
			GROUP_CONCAT(cr.amount SEPARATOR ", ") AS invoice_amounts
		');
		// GROUP_CONCAT(cr.invoice_amount SEPARATOR ", ") AS invoice_amounts
		$this->db->from('voucher_transaction vt');
		$this->db->join('customers cm', 'cm.customer_id = vt.customer_id', 'left');
		$this->db->join('general_ledger gl', 'gl.account_id = vt.account_id', 'left');

		// Join subquery to get Cr rows for same voucher_code
		$this->db->join("(SELECT 
                        voucher_code, 
						voucher_id,
                        invoice_code, 
                        amount 
                    FROM voucher_transaction 
                    WHERE drcr_type = 'Cr') cr", 'cr.voucher_code = vt.voucher_code', 'left');

		$this->db->where('vt.voucher_code', $voucher_code);

		$this->db->where('vt.voucher_type', 'R');
		$this->db->where('vt.drcr_type', 'Dr'); // Only fetch main Debit row for header

		$this->db->group_by('vt.voucher_code, vt.voucher_date, vt.voucher_type, vt.customer_id, cm.name, vt.transaction_type, vt.transaction_no, gl.account_name, vt.narration');
		//   echo $this->db->last_query(); exit;
		return $this->db->get()->row();
	}


	public function get_receipt_invoices($voucher_code)
	{
		$this->db->select('vt.amount, vt.voucher_code, vt.trans_id, vt.customer_id, cm.name as customer_name');
		$this->db->from('voucher_transaction vt');
		$this->db->join('customers cm', 'cm.customer_id = vt.customer_id', 'left'); // ensure LEFT JOIN
		$this->db->where('vt.voucher_code', $voucher_code);
		$this->db->where('vt.voucher_type', 'R');
		$this->db->where('vt.drcr_type', 'Dr');
		$query = $this->db->get();
		return $query->result();
	}


	// public function get_receipt_details($voucher_code) {
	//         $this->db->select('*');
	//         $this->db->from('voucher_transaction'); // Adjust table name to your details table
	//         $this->db->where('voucher_code', $voucher_code);
	//         $query = $this->db->get();

	//         return $query->result();
	//     }
	public function get_receipt_details($voucher_code)
	{
		$this->db->select('
        vt.voucher_code,
        vt.amount,
        cm.name as customer_name,
        im.invoice_no
    ');
		$this->db->from('voucher_transaction vt');
		$this->db->join('customers cm', 'cm.customer_id = vt.customer_id', 'left');
		$this->db->join('invoices im', 'im.invoice_id = vt.trans_id', 'left');
		$this->db->where('vt.voucher_code', $voucher_code);
		$this->db->where('vt.voucher_type', 'R');
		$this->db->where('vt.cancel', 0);

		return $this->db->get()->result();
	}




	function get_receipt_records($id)
	{
		$query = $this->db->query("SELECT a.*, c.*, i.invoice_code FROM voucher_transaction a LEFT JOIN customers c ON a.customer_id = c.customer_id LEFT JOIN invoices i ON a.trans_id = i.invoice_id WHERE a.voucher_code = '$id'; ");
		return $query->result();
	}
	// function get_payment_records($id){
	// 	$query = $this->db->query("SELECT a.*, c.*, i.grn_code FROM voucher_transaction a LEFT JOIN supplier_master c ON a.customer_id = c.supplier_id LEFT JOIN GRN_master i ON a.trans_id = i.grn_id WHERE a.voucher_code = '$id'; ");
	// 	return $query->result();
	// }
	public function get_payment_record($voucher_code)
	{
		$sql = "
        SELECT 
            vt.voucher_id,
            vt.voucher_code,
            vt.voucher_type,
            vt.voucher_date,
            vt.customer_id,
            sm.supplier_name AS particulars,
            vt.amount,
            vt.transaction_type,
            vt.transaction_no,
			vt.narration,
            vt.drcr_type,
            vt.trans_id,
            vt.invoice_code,
            vt.invoice_amount,
			gm.invoice_no,
            gl_cr.account_name AS credit_account_name,
            gl_dr.account_name AS party_name
        FROM voucher_transaction vt
        LEFT JOIN supplier_master sm ON sm.supplier_id = vt.customer_id
        LEFT JOIN general_ledger gl_cr ON vt.account_id = gl_cr.account_id
        LEFT JOIN general_ledger gl_dr ON vt.account_id = gl_dr.account_id
		LEFT JOIN purchase_grn_master gm ON vt.invoice_code = gm.grn_code
        WHERE vt.voucher_code = ? AND vt.voucher_type = 'P'
        ORDER BY vt.drcr_type DESC, vt.voucher_id
    ";

		$query = $this->db->query($sql, [$voucher_code]);
		return $query->result();
	}




	public function add_bank_reconciliation_detailsold()
	{
		$selected_voucher_ids = $this->input->post('inv_id');
		$bank_dates = $this->input->post('bank_date');
		$deposit_amounts = $this->input->post('amount');

		$instrument_date = $this->input->post('voucher_date');
		$instrument_no = $this->input->post('transaction_no');

		if (!empty($selected_voucher_ids)) {
			foreach ($selected_voucher_ids as $index => $voucher_id) {
				$voucher_id = intval($voucher_id);

				$bank_date = isset($bank_dates[$index]) ? $bank_dates[$index] : null;
				$amount_no = isset($deposit_amounts[$index]) ? $deposit_amounts[$index] : null;

				$instrument_date = isset($instrument_date[$index]) ? $instrument_date[$index] : null;
				$instrument_no = isset($instrument_no[$index]) ? $instrument_no[$index] : null;

				$data = [
					'reco' => 1,
					'bank_date' => $bank_date,
					// 'deposit_amount' => $deposit_amount
				];

				$this->db->where('voucher_id', $voucher_id);
				$this->db->update('voucher_transaction', $data);

				$databank = [
					'instrument_no' => $instrument_no,
					'instrument_date' => $instrument_date,
					'amount_no' => $amount_no,
					'instrument_type' => "Dr/Cr",
				];
				$this->db->insert('bank_reconciliation', $databank);
			}
		}

		return true;
	}
	public function add_bank_reconciliation_details1()
	{
		log_message('error', '=== START: add_bank_reconciliation_details ===');

		$selected_voucher_ids = $this->input->post('inv_id');
		$bank_dates = $this->input->post('bank_date');
		$deposit_amounts = $this->input->post('amount');
		$instrument_dates = $this->input->post('voucher_date');
		$instrument_nos = $this->input->post('transaction_no');

		// 🔍 Log full POST data
		log_message('error', 'POST inv_id: ' . print_r($selected_voucher_ids, true));
		log_message('error', 'POST bank_date: ' . print_r($bank_dates, true));
		log_message('error', 'POST amount: ' . print_r($deposit_amounts, true));
		log_message('error', 'POST voucher_date: ' . print_r($instrument_dates, true));
		log_message('error', 'POST transaction_no: ' . print_r($instrument_nos, true));

		if (!empty($selected_voucher_ids)) {

			foreach ($selected_voucher_ids as $index => $voucher_id) {

				log_message('error', "---- LOOP INDEX: $index ----");

				$voucher_id = intval($voucher_id);

				$bank_date = isset($bank_dates[$index]) ? $bank_dates[$index] : null;
				$amount_no = isset($deposit_amounts[$index]) ? $deposit_amounts[$index] : null;
				$instrument_date = isset($instrument_dates[$index]) ? $instrument_dates[$index] : null;
				$instrument_no = isset($instrument_nos[$index]) ? $instrument_nos[$index] : null;

				// 🔍 Log values per row
				log_message('error', "voucher_id: $voucher_id");
				log_message('error', "bank_date: $bank_date");
				log_message('error', "amount_no: $amount_no");
				log_message('error', "instrument_date: $instrument_date");
				log_message('error', "instrument_no: $instrument_no");

				// ✅ Update voucher_transaction
				$data = [
					'reco' => 1,
					'bank_date' => $bank_date,
				];

				$this->db->where('voucher_id', $voucher_id);
				$this->db->update('voucher_transaction', $data);

				log_message('error', 'Update Query: ' . $this->db->last_query());

				if ($this->db->affected_rows() == 0) {
					log_message('error', '⚠️ No rows updated for voucher_id: ' . $voucher_id);
				}

				// ✅ Insert into bank_reconciliation
				$databank = [
					'instrument_no' => $instrument_no,
					'instrument_date' => $instrument_date,
					'amount_no' => $amount_no,
					'instrument_type' => "Dr/Cr",
				];

				$this->db->insert('bank_reconciliation', $databank);

				log_message('error', 'Insert Query: ' . $this->db->last_query());

				if ($this->db->affected_rows() == 0) {
					log_message('error', '❌ Insert failed for voucher_id: ' . $voucher_id);
					log_message('error', 'DB Error: ' . print_r($this->db->error(), true));
				}
			}
		} else {
			log_message('error', '⚠️ No voucher IDs received');
		}

		log_message('error', '=== END: add_bank_reconciliation_details ===');

		return true;
	}
	public function add_bank_reconciliation_details()
	{
		$selected_voucher_ids = $this->input->post('inv_id');

		$bank_dates        = $this->input->post('bank_dates');
		$deposit_amounts   = $this->input->post('deposit_amounts');
		$instrument_dates  = $this->input->post('instrument_dates');
		$instrument_nos    = $this->input->post('instrument_nos');

		if (!empty($selected_voucher_ids)) {

			foreach ($selected_voucher_ids as $voucher_id) {

				$voucher_id = intval($voucher_id);

				// ✅ get values using voucher_id key
				$bank_date       = $bank_dates[$voucher_id] ?? null;
				$amount_no       = $deposit_amounts[$voucher_id] ?? null;
				$instrument_date = $instrument_dates[$voucher_id] ?? null;
				$instrument_no   = $instrument_nos[$voucher_id] ?? null;

				// ✅ Update voucher_transaction
				$this->db->where('voucher_id', $voucher_id);
				$this->db->update('voucher_transaction', [
					'reco' => 1,
					'bank_date' => $bank_date
				]);

				// ✅ Insert into bank_reconciliation
				$this->db->insert('bank_reconciliation', [

					'instrument_no'  => $instrument_no,
					'instrument_date' => $instrument_date,
					'amount_no'      => $amount_no,
					'instrument_type' => 'Dr/Cr'
				]);
			}
		}

		return true; // change as needed
	}

	function update_bank_reconciliation_data($id)
	{
		$data = array(
			'instrument_no' => $this->input->post('instrument_no'),
			'instrument_date' => date('Y-m-d', strtotime($this->input->post('date'))),
			'amount_no' => $this->input->post('amount_no'),
			'instrument_type' => $this->input->post('instrument_type'),
			'remark' => $this->input->post('remark'),
			'created_by'  => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d', strtotime($this->input->post('date'))),

		);

		$this->db->where('reconciliation_id', $id);
		$res = $this->db->update('bank_reconciliation', $data);


		if ($res) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'bank_reconciliation', 'reconciliation_id', $id);

			return true;
		} else {
			return false;
		}
	}





	function get_bank_reconciliation_list()
	{
		$query = $this->db->query("SELECT * FROM bank_reconciliation ORDER BY instrument_no DESC");
		return $query->result();
	}


	function get_bank_reconciliation_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM bank_reconciliation WHERE reconciliation_id = '$id'");
		return $query->result();
	}

	/////////////Balance sheet data

	private function get_child_groups($group_no)
	{
		$groups = [$group_no];

		$this->db->reset_query();   // 🔴 VERY IMPORTANT

		$children = $this->db->select('group_no')
			->from('account_group')
			->where('parent_group', $group_no)
			->get()
			->result();

		foreach ($children as $child) {
			$groups = array_merge($groups, $this->get_child_groups($child->group_no));
		}

		return $groups;
	}
	// public function get_balance_sheet_data($from_date, $to_date, $group_no)
	// {
	//     $this->db->reset_query();  // 🔴 VERY IMPORTANT

	//     $this->db->select("
	//         gl.group_no,
	//         ag.group_name,
	//         gl.account_id,
	//         gl.account_name,
	//         IFNULL(SUM(CASE WHEN vt.voucher_date < '{$from_date}' 
	//             THEN CASE WHEN vt.drcr_type = 'Dr' THEN vt.amount ELSE -vt.amount END 
	//         ELSE 0 END), 0) AS opening_balance,
	//         IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' 
	//             AND vt.drcr_type = 'Dr' THEN vt.amount ELSE 0 END), 0) AS debit,
	//         IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' 
	//             AND vt.drcr_type = 'Cr' THEN vt.amount ELSE 0 END), 0) AS credit,
	//         (
	//             IFNULL(SUM(CASE WHEN vt.voucher_date < '{$from_date}' 
	//                 THEN CASE WHEN vt.drcr_type = 'Dr' THEN vt.amount ELSE -vt.amount END 
	//             ELSE 0 END), 0)
	//             +
	//             IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' 
	//                 AND vt.drcr_type = 'Dr' THEN vt.amount ELSE 0 END), 0)
	//             -
	//             IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' 
	//                 AND vt.drcr_type = 'Cr' THEN vt.amount ELSE 0 END), 0)
	//         ) AS closing_balance");

	//     $this->db->from('general_ledger gl');
	//     $this->db->join('voucher_transaction vt', 'gl.account_id = vt.account_id', 'left');
	//     $this->db->join('account_group ag', 'gl.group_no = ag.group_no', 'left');

	//     $group_list = $this->get_child_groups($group_no);
	//     $this->db->where_in('gl.group_no', $group_list);

	//     $this->db->group_by('gl.account_id');
	//     $this->db->order_by('ag.group_name, gl.account_name');

	//     return $this->db->get()->result();
	// }

	public function get_balance_sheet_data($from_date, $to_date, $group_no)
	{
		// Query to get balances grouped by account group and ledger
		// Adjust table/field names as per your DB schema
		$this->db->select("
        gl.group_no,
        ag.group_name,
        gl.account_id,
        gl.account_name,
        IFNULL(SUM(CASE WHEN vt.voucher_date < '{$from_date}' THEN 
            CASE WHEN vt.drcr_type = 'Dr' THEN vt.amount ELSE -vt.amount END
        ELSE 0 END), 0) AS opening_balance,
        IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' AND vt.drcr_type = 'Dr' THEN vt.amount ELSE 0 END), 0) AS debit,
        IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' AND vt.drcr_type = 'Cr' THEN vt.amount ELSE 0 END), 0) AS credit,
        (
            IFNULL(SUM(CASE WHEN vt.voucher_date < '{$from_date}' THEN 
                CASE WHEN vt.drcr_type = 'Dr' THEN vt.amount ELSE -vt.amount END
            ELSE 0 END), 0)
            +
            IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' AND vt.drcr_type = 'Dr' THEN vt.amount ELSE 0 END), 0)
            -
            IFNULL(SUM(CASE WHEN vt.voucher_date BETWEEN '{$from_date}' AND '{$to_date}' AND vt.drcr_type = 'Cr' THEN vt.amount ELSE 0 END), 0)
        ) AS closing_balance");
		$this->db->from('general_ledger gl');
		$this->db->join('voucher_transaction vt', 'gl.account_id = vt.account_id', 'left');
		$this->db->join('account_group ag', 'gl.group_no = ag.group_no', 'left');
		$this->db->where('gl.group_no', $group_no);
		$this->db->group_by('gl.account_id');
		$this->db->order_by('ag.group_name, gl.account_name');

		$query = $this->db->get();
		print_r('debug', 'Last Query: ' . $this->db->last_query());

		return $query->result();
	}
	public function get_account_name_by_id($account_id)
	{
		$this->db->select('account_name');
		$this->db->from('general_ledger');  // correct table name
		$this->db->where('account_id', $account_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row()->account_name;
		}
		return null;
	}

	function get_reco_list()
	{
		$account_id = $this->input->post('account_id');
		$from = $this->input->post('from_date');
		$to = $this->input->post('to_date');

		$this->db->select('vt.*, gl.account_name');
		$this->db->from('voucher_transaction vt');
		$this->db->join('general_ledger gl', 'vt.customer_id = gl.account_id', 'left');

		$this->db->where_in('vt.voucher_type', ['P', 'R']);
		$this->db->where('vt.account_id', $account_id);

		// Fix: Group the reco condition properly
		$this->db->group_start();
		$this->db->where('vt.reco <>', '1');
		$this->db->or_where('vt.reco IS NULL', null, false);
		$this->db->group_end();

		if (!empty($from) && !empty($to)) {
			$this->db->where('vt.voucher_date >=', $from);
			$this->db->where('vt.voucher_date <=', $to);
		}

		$this->db->order_by('vt.voucher_date', 'DESC');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_account_trial_balance($from_date, $to_date)
	{
		//echo $from_date.''.$to_date; //exit;
		$sql = "
            SELECT 
                ag.group_name,
                gl.account_name,
                SUM(CASE WHEN vt.drcr_type = 'Dr' THEN vt.amount ELSE 0 END) AS debit,
                SUM(CASE WHEN vt.drcr_type = 'Cr' THEN vt.amount ELSE 0 END) AS credit
            FROM voucher_transaction vt
            JOIN general_ledger gl ON gl.account_id = vt.account_id
            LEFT JOIN account_group ag ON ag.group_no = gl.group_no
            WHERE vt.cancel = 0
                AND vt.voucher_date BETWEEN ? AND ?
            GROUP BY vt.account_id, ag.group_name, gl.account_name
            HAVING debit <> 0 OR credit <> 0
            ORDER BY ag.group_name, gl.account_name
        ";
		$query = $this->db->query($sql, [$from_date, $to_date]);
		//echo $this->db->last_query(); exit;
		return $query->result_array();
	}

	public function get_group_totals($from_date, $to_date)
	{
		$sql = "
            SELECT 
                ag.group_name,
                SUM(CASE WHEN vt.drcr_type = 'Dr' THEN vt.amount ELSE 0 END) AS debit,
                SUM(CASE WHEN vt.drcr_type = 'Cr' THEN vt.amount ELSE 0 END) AS credit
            FROM voucher_transaction vt
            JOIN general_ledger gl ON gl.account_id = vt.account_id
            LEFT JOIN account_group ag ON ag.group_no = gl.group_no
            WHERE vt.cancel = 0
                AND vt.voucher_date BETWEEN ? AND ?
            GROUP BY ag.group_name
            ORDER BY ag.group_name
        ";

		$query = $this->db->query($sql, [$from_date, $to_date]);
		//	echo $this->db->last_query(); exit;

		$result = $query->result_array();

		$group_totals = [];
		foreach ($result as $row) {
			$group_totals[$row['group_name']] = $row;
		}
		return $group_totals;
	}



	/*********************************  End CI Model **************************************************/

	public function get_voucher_vat_summary($from_date = null, $to_date = null)
	{
		// VAT Account IDs
		$input_vat_account_id  = 226; // Purchase VAT
		$output_vat_account_id = 228; // Sales VAT

		$this->db->select("
        account_id,
        SUM(CASE 
                WHEN drcr_type = 'Dr' THEN amount 
                ELSE -amount 
            END) AS vat_amount
    ");

		$this->db->from('voucher_transaction');
		$this->db->where_in('account_id', [$input_vat_account_id, $output_vat_account_id]);
		$this->db->where('cancel', 0);

		// ✅ Proper DATETIME filtering
		if (!empty($from_date) && !empty($to_date)) {
			$this->db->where('voucher_date >=', $from_date . ' 00:00:00');
			$this->db->where('voucher_date <=', $to_date . ' 23:59:59');
		}

		$this->db->group_by('account_id');

		$query = $this->db->get();
		$rows  = $query->result();

		// ✅ Log SQL Query
		// log_message('error', 'VAT SQL : ' . $this->db->last_query());

		// Initialize Summary
		$summary = [
			'input'  => ['taxable' => 0, 'vat' => 0, 'total' => 0],
			'output' => ['taxable' => 0, 'vat' => 0, 'total' => 0],
		];

		foreach ($rows as $row) {

			$vat = (float) $row->vat_amount;

			// If VAT negative → make positive for report display
			$vat_display = abs($vat);

			// 5% VAT → taxable = VAT * 20
			$taxable = $vat_display * 20;
			$total   = $taxable + $vat_display;

			if ($row->account_id == $input_vat_account_id) {

				$summary['input'] = [
					'taxable' => round($taxable, 2),
					'vat'     => round($vat_display, 2),
					'total'   => round($total, 2)
				];
			} elseif ($row->account_id == $output_vat_account_id) {

				$summary['output'] = [
					'taxable' => round($taxable, 2),
					'vat'     => round($vat_display, 2),
					'total'   => round($total, 2)
				];
			}
		}

		// ✅ Log Final Result
		// log_message('error', 'VAT SUMMARY RESULT : ' . print_r($summary, true));

		return (object) $summary;
	}


	public function get_voucher_vat_details($from_date = null, $to_date = null)
	{
		// Define VAT account IDs
		$input_vat_account_id  = 226;  // Input VAT (Purchase)
		$output_vat_account_id = 228;  // Output VAT (Sales)

		// Fetch transactions only for VAT accounts
		$this->db->select("
        voucher_id,
        voucher_code,
        voucher_date,
        voucher_type,
        account_id,
        amount");
		$this->db->from('voucher_transaction');
		$this->db->where_in('account_id', [$input_vat_account_id, $output_vat_account_id]);
		$this->db->where('cancel', 0);

		if (!empty($from_date) && !empty($to_date)) {
			$this->db->where('voucher_date >=', $from_date . ' 00:00:00');
			$this->db->where('voucher_date <=', $to_date . ' 23:59:59');
		}

		$this->db->order_by('voucher_date', 'ASC');
		$query = $this->db->get();
		$rows = $query->result();

		// Initialize structure
		$data = [
			'input'  => [],
			'output' => [],
			'totals' => [
				'input_taxable'  => 0,
				'input_vat'      => 0,
				'output_taxable' => 0,
				'output_vat'     => 0,
			]
		];

		// Process each row
		foreach ($rows as $row) {
			$vat      = (float)$row->amount;   // already VAT amount
			$taxable  = $vat * 20;             // for 5% VAT → taxable = VAT × 20
			$total    = $taxable + $vat;

			$entry = (object)[
				'voucher_code'   => $row->voucher_code,
				'voucher_date'   => $row->voucher_date,
				'voucher_type'   => $row->voucher_type,
				'taxable_amount' => round($taxable, 2),
				'vat_amount'     => round($vat, 2),
				'total'          => round($total, 2),
			];

			if ($row->account_id == $input_vat_account_id) {
				// Input VAT (Purchase)
				$data['input'][] = $entry;
				$data['totals']['input_taxable'] += $taxable;
				$data['totals']['input_vat']     += $vat;
			} elseif ($row->account_id == $output_vat_account_id) {
				// Output VAT (Sales)
				$data['output'][] = $entry;
				$data['totals']['output_taxable'] += $taxable;
				$data['totals']['output_vat']     += $vat;
			}
		}

		// Round totals for consistency
		foreach ($data['totals'] as $key => $value) {
			$data['totals'][$key] = round($value, 2);
		}

		return (object)$data;
	}

	// =================================================

	public function post_service_purchase_voucherold($po_id)
	{
		$CI = &get_instance();


		// ⭐ GET PO MASTER
		$po = $CI->db->where('po_id', $po_id)
			->get('purchase_order_master')
			->row();

		if (!$po) return false;

		$supplier_id = $po->supplier_id;
		$vdate       = $po->po_date;
		$grand_total = floatval($po->grand_total);
		$vtime       = date('H:i:s');
		$po_code = $po->po_code;

		// ⭐ GET SERVICE LINES
		$lines = $CI->db->where('po_master_id', $po_id)
			->where('line_type', 'SERVICE')
			->get('purchase_order_transaction')
			->result();

		if (empty($lines)) return false;

		// ⭐ GENERATE VOUCHER CODE
		$supplierledger = $this->db
			->select('account_id')
			->from('general_ledger')
			->where('supplier_id', $supplier_id)
			->get()
			->row();

		$supplierledger = $supplierledger ? $supplierledger->account_id : 0;


		$AccountCode = $po_code;
		$purchaseledger = "1120";
		$inputvatledger = "226";



		$voucher_date = date('Y-m-d H:i:s', strtotime("$vdate $vtime"));

		$total_vat = 0;
		$ledger_totals = [];

		foreach ($lines as $ln) {
			$ledger = $ln->expense_account_id;

			$vat = floatval($ln->service_vat_amt);
			$total = floatval($ln->total);

			$net = $total - $vat;

			$total_vat += $vat;

			if ($ledger) {
				if (!isset($ledger_totals[$ledger]))
					$ledger_totals[$ledger] = 0;

				$ledger_totals[$ledger] += $net;
			}
		}

		// ⭐ 1️⃣ DEBIT EXPENSE LEDGER WISE (GROUPED)
		foreach ($ledger_totals as $ledger_id => $amt) {
			if ($amt <= 0) continue;

			$data = [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $ledger_id,
				'amount'       => $amt,
				'drcr_type'    => 'Dr',
				'trans_id'     => $po_id,
				'trans_type'   => 'PO-SERVICE',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			];

			$CI->db->insert('voucher_transaction', $data);
		}

		// ⭐ 2️⃣ INPUT VAT DEBIT
		if ($total_vat > 0) {
			$input_vat_ledger = INPUT_VAT_LEDGER_ID;

			$data = [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $input_vat_ledger,
				'amount'       => $total_vat,
				'drcr_type'    => 'Dr',
				'trans_id'     => $po_id,
				'trans_type'   => 'PO-SERVICE',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			];

			$CI->db->insert('voucher_transaction', $data);
		}

		// ⭐ 3️⃣ SUPPLIER CREDIT
		$data = [
			'voucher_code' => $AccountCode,
			'voucher_date' => $voucher_date,
			'voucher_type' => 'G',
			'customer_id'  => $supplier_id,
			'account_id'   => $supplier_id,
			'amount'       => $grand_total,
			'drcr_type'    => 'Cr',
			'trans_id'     => $po_id,
			'trans_type'   => 'PO-SERVICE',
			'recordCreatedBy' => $CI->session->userdata('user_id')
		];

		$CI->db->insert('voucher_transaction', $data);

		return true;
	}
	public function post_service_purchase_voucher($po_id)
	{
		$CI = &get_instance();


		// ⭐ GET PO MASTER
		$po = $CI->db->where('po_id', $po_id)
			->get('purchase_order_master')
			->row();

		if (!$po) return false;

		$supplier_id  = $po->supplier_id;
		$vdate        = $po->po_date;
		$grand_total  = floatval($po->grand_total);
		$vat_total    = floatval($po->vat_amt);
		$sub_total    = floatval($po->sub_total);
		$po_code      = $po->po_code;
		$vtime        = date('H:i:s');

		$voucher_date = date('Y-m-d H:i:s', strtotime("$vdate $vtime"));

		// $res = $this->db->where('voucher_code', $AccountCode)
		//     ->delete('voucher_transaction');
		$res = $this->db->where('voucher_code', $po_code)
			->delete('voucher_transaction');
		// ⭐ GET SUPPLIER LEDGER
		$supplierledger = $CI->db
			->select('account_id')
			->where('supplier_id', $supplier_id)
			->get('general_ledger')
			->row('account_id');

		if (!$supplierledger) return false;

		// ⭐ DEFINE LEDGERS (YOU CAN MAKE CONFIG LATER)
		$purchaseledger = 1120;   // Purchase / Sublet Purchase Ledger
		$inputvatledger = 226;    // Input VAT Ledger

		$AccountCode = $po_code;  // Using PO Code as Voucher Code


		/////////////////////////
		// ⭐ 1️⃣ PURCHASE DEBIT
		/////////////////////////
		if ($sub_total > 0) {
			$data = [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $purchaseledger,
				'amount'       => $sub_total,
				'drcr_type'    => 'Dr',
				'trans_id'     => $po_id,
				'trans_type'   => 'PO-SERVICE',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			];

			$CI->db->insert('voucher_transaction', $data);
		}


		/////////////////////////
		// ⭐ 2️⃣ INPUT VAT DEBIT
		/////////////////////////
		if ($vat_total > 0) {
			$data = [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $inputvatledger,
				'amount'       => $vat_total,
				'drcr_type'    => 'Dr',
				'trans_id'     => $po_id,
				'trans_type'   => 'PO-SERVICE',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			];

			$CI->db->insert('voucher_transaction', $data);
		}


		/////////////////////////
		// ⭐ 3️⃣ SUPPLIER CREDIT
		/////////////////////////
		if ($grand_total > 0) {
			$data = [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $supplierledger,
				'amount'       => $grand_total,
				'drcr_type'    => 'Cr',
				'trans_id'     => $po_id,
				'trans_type'   => 'PO-SERVICE',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			];

			$CI->db->insert('voucher_transaction', $data);
		}

		return true;
	}

	public function post_service_purchase_vouche_srn($srn_id)
	{
		$CI = &get_instance();

		// ⭐ GET SRN MASTER
		$srn = $CI->db->where('id', $srn_id)
			->get('service_receipt_master')
			->row();

		if (!$srn) return false;

		$po_id        = $srn->po_id;
		$supplier_id  = $srn->supplier_id;
		$srn_no       = $srn->srn_no;
		$vdate        = $srn->srn_date;
		$grand_total  = floatval($srn->total_amount);

		$vtime        = date('H:i:s');
		$voucher_date = date('Y-m-d H:i:s', strtotime("$vdate $vtime"));

		// ⭐ DELETE OLD ENTRIES (if re-post)
		$CI->db->where('voucher_code', $srn_no)
			->delete('voucher_transaction');

		// ⭐ GET PO (for VAT + subtotal if needed)
		$po = $CI->db->where('po_id', $po_id)
			->get('purchase_order_master')
			->row();

		$sub_total = floatval($po->sub_total);
		$vat_total = floatval($po->vat_amt);

		// ⭐ GET SUPPLIER LEDGER
		$supplierledger = $CI->db
			->select('account_id')
			->where('supplier_id', $supplier_id)
			->get('general_ledger')
			->row('account_id');

		if (!$supplierledger) return false;

		// ⭐ LEDGERS
		$purchaseledger = 1120;
		$inputvatledger = 226;

		$AccountCode = $srn_no; // ✅ NOW SRN BASED

		/////////////////////////
		// 1️⃣ PURCHASE DEBIT
		/////////////////////////
		if ($sub_total > 0) {
			$CI->db->insert('voucher_transaction', [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $purchaseledger,
				'amount'       => $sub_total,
				'drcr_type'    => 'Dr',
				'trans_id'     => $srn_id,
				'trans_type'   => 'SRN',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			]);
		}

		/////////////////////////
		// 2️⃣ INPUT VAT DEBIT
		/////////////////////////
		if ($vat_total > 0) {
			$CI->db->insert('voucher_transaction', [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $inputvatledger,
				'amount'       => $vat_total,
				'drcr_type'    => 'Dr',
				'trans_id'     => $srn_id,
				'trans_type'   => 'SRN',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			]);
		}

		/////////////////////////
		// 3️⃣ SUPPLIER CREDIT
		/////////////////////////
		if ($grand_total > 0) {
			$CI->db->insert('voucher_transaction', [
				'voucher_code' => $AccountCode,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'G',
				'customer_id'  => $supplier_id,
				'account_id'   => $supplierledger,
				'amount'       => $grand_total,
				'drcr_type'    => 'Cr',
				'trans_id'     => $srn_id,
				'trans_type'   => 'SRN',
				'recordCreatedBy' => $CI->session->userdata('user_id')
			]);
		}

		return true;
	}


	public function save_expense_master()
	{
		$prefix = 'EXP/';
		$num = $this->db->like('expense_code', $prefix)
			->from('expense_master')
			->count_all_results() + 1;


		$code = $prefix . date('y') . '/' . sprintf("%04d", $num);



		$bank_ledger_id = NULL;

		if ($this->input->post('payment_mode') == 'BANK') {
			$bank_ledger_id = $this->input->post('bank_ledger_id');
		}
		$data = [
			'expense_code' => $code,
			'expense_date' => $this->input->post('expense_date'),
			'ledger_id'    => $this->input->post('expense_ledger_id'),
			'bank_ledger_id' => $bank_ledger_id,
			'amount'       => $this->input->post('amount'),
			'payment_mode' => $this->input->post('payment_mode'),
			'remarks'      => $this->input->post('remarks'),
			'created_by'   => $this->session->userdata('user_id'),
			'description'   => $this->input->post('desp'),

		];

		$this->db->insert('expense_master', $data);
		$expense_id = $this->db->insert_id();

			

		// ⭐ FILE UPLOAD
		if (!empty($_FILES['expense_doc']['name'])) {
			$file = $_FILES['expense_doc'];

			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$newname = time() . '_' . rand(1000, 9999) . '.' . $ext;

			move_uploaded_file($file['tmp_name'], 'uploads/expenses/' . $newname);

			$doc = [
				'expense_id' => $expense_id,
				'doc_path' => $newname
			];

			$this->db->insert('expense_documents', $doc);
		}

		return $expense_id;
	}

	public function post_expense_voucher($expense_id)
	{
			
		$exp = $this->db->where('expense_id', $expense_id)
			->get('expense_master')
			->row();


		if (!$exp) return false;

		$voucher_code = $exp->expense_code;
		
		$voucher_date = date('Y-m-d H:i:s', strtotime($exp->expense_date . ' ' . date('H:i:s')));

		$expense_ledger = $exp->ledger_id;
		$bank_ledger = $exp->bank_ledger_id;
		$amount = floatval($exp->amount);

		// ⭐ Decide Credit Ledger
		if ($exp->payment_mode == 'CASH')
			$credit_ledger = 23;   // Cash Ledger ID
		elseif ($exp->payment_mode == 'BANK')
			$credit_ledger = $bank_ledger;   // Bank Ledger ID
		else
			$credit_ledger = 0;     // CREDIT (Supplier payable later)


		// ⭐ DEBIT ENTRY
		$data = [
			'voucher_code' => $voucher_code,
			'voucher_date' => $voucher_date,
			'voucher_type' => 'E',
			'account_id' => $expense_ledger,
			'amount' => $amount,
			'drcr_type' => 'Dr',
			'trans_id' => $expense_id,
			'trans_type' => 'EXP',
			'recordCreatedBy' => $this->session->userdata('user_id')
		];

		$this->db->insert('voucher_transaction', $data);
$insert_id = $this->db->insert_id();

		// ⭐ CREDIT ENTRY (Only if not CREDIT mode)
		if ($credit_ledger > 0) {
			$data = [
				'voucher_code' => $voucher_code,
				'voucher_date' => $voucher_date,
				'voucher_type' => 'E',
				'account_id' => $credit_ledger,
				'amount' => $amount,
				'drcr_type' => 'Cr',
				'trans_id' => $expense_id,
				'trans_type' => 'EXP',
				'recordCreatedBy' => $this->session->userdata('user_id')
			];

			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			// return $insert_id;
		}

		return true;
	}
	public function delete_expense_full($expense_id)
	{
		$this->db->trans_begin();

		// ⭐ GET EXPENSE
		$exp = $this->db->where('expense_id', $expense_id)
			->get('expense_master')
			->row();

		if (!$exp)
			return false;

		$voucher_code = $exp->expense_code;

		// ⭐ DELETE VOUCHER ENTRIES
		$this->db->where('voucher_code', $voucher_code)
			->where('trans_type', 'EXP')
			->delete('voucher_transaction');

		// ⭐ DELETE DOCUMENT FILE
		$docs = $this->db->where('expense_id', $expense_id)
			->get('expense_documents')
			->result();

		foreach ($docs as $d) {
			$file = FCPATH . 'uploads/expenses/' . $d->doc_path;
			if (file_exists($file))
				unlink($file);
		}

		// ⭐ DELETE DOCUMENT RECORD
		$this->db->where('expense_id', $expense_id)
			->delete('expense_documents');

		// ⭐ DELETE EXPENSE MASTER
		$this->db->where('expense_id', $expense_id)
			->delete('expense_master');

		// ⭐ TRANSACTION COMPLETE
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}


	public function update_expense_full($expense_id)
	{
		$this->db->trans_begin();


		$exp = $this->db->where('expense_id', $expense_id)
			->get('expense_master')
			->row();

		if (!$exp) return false;

		// ⭐ UPDATE MASTER
		$data = [
			'expense_date' => $this->input->post('expense_date'),
			'description'  => $this->input->post('desp'),
			'ledger_id'    => $this->input->post('expense_ledger_id'),
			'bank_ledger_id' => $this->input->post('bank_ledger_id'),
			'amount'       => $this->input->post('amount'),
			'payment_mode' => $this->input->post('payment_mode'),
			'remarks'      => $this->input->post('remarks')
		];



		$this->db->where('expense_id', $expense_id)
			->update('expense_master', $data);


		// ⭐ DELETE OLD VOUCHER
		$this->db->where('voucher_code', $exp->expense_code)
			->where('trans_type', 'EXP')
			->delete('voucher_transaction');


		// ⭐ REPOST NEW VOUCHER
		$this->post_expense_voucher($expense_id);


		// ⭐ FILE UPLOAD (REPLACE OLD)
		if (!empty($_FILES['expense_doc']['name'])) {
			$old = $this->db->where('expense_id', $expense_id)
				->get('expense_documents')
				->row();

			if ($old) {
				$file = FCPATH . 'uploads/expenses/' . $old->doc_path;
				if (file_exists($file))
					unlink($file);

				$this->db->where('expense_id', $expense_id)
					->delete('expense_documents');
			}

			$ext = pathinfo($_FILES['expense_doc']['name'], PATHINFO_EXTENSION);
			$newname = time() . '_' . rand(1000, 9999) . '.' . $ext;

			move_uploaded_file($_FILES['expense_doc']['tmp_name'], 'uploads/expenses/' . $newname);

			$doc = [
				'expense_id' => $expense_id,
				'doc_path' => $newname
			];

			$this->db->insert('expense_documents', $doc);
		}

if ($expense_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			// return $insert_id;
		}


		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}

	public function get_bank_ledgers()
	{
		$this->db->select('l.account_id,l.account_name');
		$this->db->from('general_ledger l');
		$this->db->join('account_group g', 'g.group_no = l.group_no');
		$this->db->where('g.group_name', 'Bank Accounts');

		return $this->db->get()->result();
	}
	// ===============================================================
	public function update_customer_ledger_name($customer_id, $new_name)
	{
		$account_name = $new_name . ' CUST' . str_pad($customer_id, 4, '0', STR_PAD_LEFT);

		$this->db->where('customer_id', $customer_id);
		return $this->db->update('general_ledger', [
			'account_name' => $account_name
		]);
	}

	public function repair_customer_ledgers()
	{
		$customers = $this->db->get('customers')->result();

		foreach ($customers as $cust) {

			// Expected correct account name
			$correct_name = $cust->name . ' CUST' . str_pad($cust->customer_id, 4, '0', STR_PAD_LEFT);

			// Check if ledger exists
			$ledger = $this->db->where('customer_id', $cust->customer_id)
				->get('general_ledger')
				->row();

			if (!$ledger) {
				// ❌ Missing → CREATE
				$data = [
					'account_name'     => $correct_name,
					'group_no'         => 30,
					'customer_id'      => $cust->customer_id,
					'opening_balance'  => 0.00,
					'opening_bal_type' => 'Dr',
					'isdeleteable'     => 'N',
					'date'             => date('Y-m-d H:i:s')
				];

				$this->db->insert('general_ledger', $data);

				log_message('error', 'Ledger CREATED for customer: ' . $cust->customer_id);
			} else {
				// ⚠️ Exists → CHECK NAME
				if (trim($ledger->account_name) !== trim($correct_name)) {

					$this->db->where('account_id', $ledger->account_id)
						->update('general_ledger', [
							'account_name' => $correct_name
						]);

					log_message('error', 'Ledger UPDATED for customer: ' . $cust->customer_id);
				}
			}
		}

		return true;
	}

	public function fix_supplier_opening_type()
	{
		// Update only supplier ledgers (where supplier_id is not null)
		$this->db->where('supplier_id IS NOT NULL', null, false);
		$this->db->where('opening_bal_type', 'Dr');

		$this->db->update('general_ledger', [
			'opening_bal_type' => 'Cr'
		]);

		return $this->db->affected_rows();
	}

	// ==========================================================


	function get_general_ledger_by_group_id($gid)
	{
		$query = $this->db->query("select account_id, account_name from general_ledger where group_no='$gid'");
		return $query->result();
	}

	function ajax_get_invoice_listold($acc_id)
	{
		$query = $this->db->query("select customer_id, supplier_id, group_no from general_ledger where account_id=$acc_id ");
		$res = $query->result();

		foreach ($res as $r) {
			if ($r->group_no == 29) //sundry creditors
			{
				$id = $r->supplier_id;
				$query = $this->db->query("
							SELECT 
								g.grn_id AS inv_id,
								g.grn_code AS invoice_code,
								g.supplier_id AS uid,
								g.grand_total,
								g.invoice_no AS ref_no,
								g.invoice_date AS invoice_date,
								o.po_code AS po_code,
								'supplier' AS utype
							FROM purchase_grn_master g
							JOIN purchase_order_master o ON g.po_id = o.po_id
							WHERE 
								g.supplier_id = $id
								AND g.fully_payment = 0
								AND g.status = 0
							ORDER BY g.grn_date DESC
						");

				return $query->result();
			} elseif ($r->group_no == 30) //sundry debitors
			{
				$id = $r->customer_id;
				if ($id != '') {
					$query = $this->db->query("select invoice_id as inv_id, invoice_code as invoice_code, customer_id as uid, grand_total, petrostar_ref_no as ref_no, invoice_date as invoice_date, po_number as po_code, 'customer' as utype from invoice_master where inv_type in('TI') and fully_payment=0 and customer_id=$id order by invoice_date desc");
					return $query->result();
				}
			} else {
				$id = $r->customer_id;
				if ($id != '') {
					$query = $this->db->query("select invoice_id as inv_id, invoice_code as invoice_code, customer_id as uid, grand_total, petrostar_ref_no as ref_no, invoice_date as invoice_date, po_number as po_code, 'customer' as utype from invoice_master where inv_type in('TI') and fully_payment=0 and customer_id=$id order by invoice_date desc");
					return $query->result();
				}
			}
		}
	}

	function ajax_get_invoice_list111($acc_id)
	{
		if (empty($acc_id)) {
			return [];
		}

		// ✅ Get ledger info safely
		$query = $this->db->query(
			"SELECT customer_id, supplier_id, group_no 
         FROM general_ledger 
         WHERE account_id = ?",
			[$acc_id]
		);

		$res = $query->row(); // ✅ only one row needed

		if (!$res) {
			return [];
		}

		// ===============================
		// 🔹 SUPPLIER (Sundry Creditors)
		// ===============================
		// if ($res->group_no == 29 && !empty($res->supplier_id)) {

		// 	return $this->db->query("
		//     SELECT 
		//         g.grn_id AS inv_id,
		//         g.grn_code AS invoice_code,
		//         g.supplier_id AS uid,
		//         g.grand_total,
		//         g.invoice_no AS ref_no,
		//         g.invoice_date AS invoice_date,
		//         o.po_code AS po_code,
		//         'supplier' AS utype
		//     FROM purchase_grn_master g
		//     JOIN purchase_order_master o ON g.po_id = o.po_id
		//     WHERE 
		//         g.supplier_id = ?
		//         AND g.fully_payment = 0
		//         AND g.status = 0
		//     ORDER BY g.grn_date DESC
		// ", [$res->supplier_id])->result();
		// }
		if ($res->group_no == 29 && !empty($res->supplier_id)) {

			// 🔹 1. PARTS (GRN based)
			$grn = $this->db->query("
        SELECT 
            g.grn_id AS inv_id,
            g.grn_code AS invoice_code,
            g.supplier_id AS uid,
            g.grand_total AS gtot,
            g.invoice_no AS ref_no,
            g.invoice_date AS invoice_date,
            o.po_code AS po_code,
            'supplier' AS utype,
            'GRN' AS source
        FROM purchase_grn_master g
        JOIN purchase_order_master o ON g.po_id = o.po_id
        WHERE 
            g.supplier_id = ?
            AND g.fully_payment = 0
            AND g.status = 0
    	", [$res->supplier_id])->result();

			// 🔹 2. SERVICE (Direct PO)
			$service_po = $this->db->query("
		    SELECT 
		        p.po_id AS inv_id,
		        p.po_code AS invoice_code,
		        p.supplier_id AS uid,
		        p.grand_total,
		        NULL AS ref_no,
		        p.po_date AS invoice_date,
		        p.po_code AS po_code,
		        'supplier' AS utype,
		        'PO' AS source
		    FROM purchase_order_master p
		    WHERE 
		        p.supplier_id = ?
		        AND p.purchase_type = 'SERVICE'
				
		", [$res->supplier_id])->result();



			// 🔥 Merge both
			$result = array_merge($grn, $service_po);

			// 🔥 Sort by date DESC (important)
			usort($result, function ($a, $b) {
				return strtotime($b->invoice_date) - strtotime($a->invoice_date);
			});

			return $result;
		}

		// ===============================
		// 🔹 CUSTOMER (Debtors + Others)
		// ===============================
		if (!empty($res->customer_id)) {

			return $this->db->query("
            SELECT 
                invoice_id AS inv_id,
                invoice_code AS invoice_code,
                customer_id AS uid,
                grand_total,
                petrostar_ref_no AS ref_no,
                invoice_date AS invoice_date,
                po_number AS po_code,
                'customer' AS utype
            FROM invoice_master
            WHERE 
                inv_type IN ('TI')
                AND fully_payment = 0
                AND customer_id = ?
            ORDER BY invoice_date DESC
        ", [$res->customer_id])->result();
		}

		// ===============================
		// 🔹 FALLBACK
		// ===============================
		return [];
	}
	// =========================================================

	function ajax_get_invoice_list($acc_id)
	{
		if (empty($acc_id)) {
			return [];
		}

		// ✅ Get ledger info
		$query = $this->db->query(
			"SELECT customer_id, supplier_id, group_no 
         FROM general_ledger 
         WHERE account_id = ?",
			[$acc_id]
		);

		$res = $query->row();

		if (!$res) {
			return [];
		}

		// ===============================
		// 🔹 SUPPLIER (Sundry Creditors)
		// ===============================
		if ($res->group_no == 29 && !empty($res->supplier_id)) {

			// 🔹 1. PARTS (GRN)
			$grn = $this->db->query("
            SELECT 
                g.grn_id AS inv_id,
                g.grn_code AS invoice_code,
                g.supplier_id AS uid,
                g.grand_total AS gtot,
                g.invoice_no AS ref_no,
                g.invoice_date AS invoice_date,
                o.po_code AS po_code,
                'supplier' AS utype,
                'GRN' AS source
            FROM purchase_grn_master g
            JOIN purchase_order_master o ON g.po_id = o.po_id
            WHERE 
                g.supplier_id = ?
                AND g.fully_payment = 0
                AND g.status = 0
        ", [$res->supplier_id])->result();


			// 🔹 2. SERVICE → SRN (fixed)
			$service_po = $this->db->query("
            SELECT 
                p.id AS inv_id,
                p.srn_no AS invoice_code,
                p.supplier_id AS uid,
                p.total_amount AS gtot,
                NULL AS ref_no,
                p.srn_date AS invoice_date,
                p.srn_no AS po_code,
                'supplier' AS utype,
                'SRN' AS source
            FROM service_receipt_master p
            WHERE 
                p.supplier_id = ?
                AND p.status != 'cancelled'
        ", [$res->supplier_id])->result();


			// 🔥 Merge both
			$result = array_merge($grn, $service_po);

			// 🔥 Sort by date DESC
			usort($result, function ($a, $b) {
				return strtotime($b->invoice_date) - strtotime($a->invoice_date);
			});

			return $result;
		}

		// ===============================
		// 🔹 CUSTOMER (Debtors)
		// ===============================
		if (!empty($res->customer_id)) {

			return $this->db->query("
            SELECT 
                invoice_id AS inv_id,
                invoice_code AS invoice_code,
                customer_id AS uid,
                grand_total AS gtot,
                petrostar_ref_no AS ref_no,
                invoice_date AS invoice_date,
                po_number AS po_code,
                'customer' AS utype
            FROM invoice_master
            WHERE 
                inv_type IN ('TI')
                AND fully_payment = 0
                AND customer_id = ?
            ORDER BY invoice_date DESC
        ", [$res->customer_id])->result();
		}

		// ===============================
		// 🔹 FALLBACK
		// ===============================
		return [];
	}



	// ==============================================================================


	public function ajax_get_quotation_list($customer_id)
	{
		$query = $this->db->query("
        SELECT 
            q.quotation_id,
            q.quotation_no,
            q.quotation_date,
            q.subtotal,
            
            IFNULL(SUM(qp.amount), 0) AS received_amount,
            
            (q.subtotal - IFNULL(SUM(qp.amount), 0)) AS balance_amount

        FROM quotations q

        LEFT JOIN quotation_payments qp 
            ON qp.quotation_id = q.quotation_id

        WHERE 
            q.customer_id = ?
           AND q.status IN ('Sent','Approved')

        GROUP BY q.quotation_id

        HAVING balance_amount > 0

        ORDER BY q.quotation_date DESC", [$customer_id]);

		return $query->result();
	}


	public function get_income($from, $to)
	{
		return $this->db->query("
        SELECT g.account_id, g.account_name,
        SUM(CASE WHEN v.drcr_type = 'Cr' THEN v.amount ELSE 0 END) -
        SUM(CASE WHEN v.drcr_type = 'Dr' THEN v.amount ELSE 0 END) AS total
        FROM general_ledger g
        JOIN voucher_transaction v ON v.account_id = g.account_id
        WHERE g.group_no IN (SELECT group_no FROM account_group WHERE parent_group = 3)
        AND v.cancel = 0
        AND DATE(v.voucher_date) BETWEEN '$from' AND '$to'
        GROUP BY g.account_id
    ")->result();
	}

	public function get_expense($from, $to)
	{
		return $this->db->query("
        SELECT g.account_id, g.account_name,
        SUM(CASE WHEN v.drcr_type = 'Dr' THEN v.amount ELSE 0 END) -
        SUM(CASE WHEN v.drcr_type = 'Cr' THEN v.amount ELSE 0 END) AS total
        FROM general_ledger g
        JOIN voucher_transaction v ON v.account_id = g.account_id
        WHERE g.group_no IN (SELECT group_no FROM account_group WHERE parent_group = 4)
        AND v.cancel = 0
        AND DATE(v.voucher_date) BETWEEN '$from' AND '$to'
        GROUP BY g.account_id
    ")->result();
	}

	public function get_ledger_transactions1($account_id, $from, $to)
	{
		return $this->db->query("
        SELECT 
            v.voucher_date AS date,
            g.account_name AS ledger_name,
            CASE 
                WHEN v.drcr_type = 'Dr' THEN v.amount
                ELSE -v.amount
            END AS amount
        FROM voucher_transaction v
        JOIN general_ledger g ON g.account_id = v.account_id
        WHERE v.account_id = '$account_id'
        AND v.cancel = 0
        AND DATE(v.voucher_date) BETWEEN '$from' AND '$to'
        ORDER BY v.voucher_date ASC
    ")->result();
	}

	// ==========================bal sheet =====================




	public function prepare_balance_sheet($to_date)
	{
		$rows = $this->get_balance_sheet_raw($to_date);

		$groups = [];

		foreach ($rows as $row) {

			if (!isset($groups[$row->group_no])) {
				$groups[$row->group_no] = (object)[
					'group_no' => $row->group_no,
					'group_name' => $row->group_name,
					'parent_group' => $row->parent_group,
					'root_type' => $row->root_type, // ✅ FIXE
					'balance' => 0,
					'children' => [],
					'ledgers' => []
				];
			}

			if ($row->account_id) {

				$balance = $row->closing_balance; // ✅ USE SQL VALUE

				$groups[$row->group_no]->ledgers[] = (object)[
					'name' => $row->account_name,
					'balance' => $balance,
					'account_id' => $row->account_id
				];

				$groups[$row->group_no]->balance += $balance;
			}
		}

		$tree = $this->build_tree($groups);

		$this->calculate_totals($tree);
		// echo '<pre>';
		// print_r($tree);
		// exit;
		return $tree;
	}


	function get_profit_loss($from_date, $to_date)
	{
		$sql = "
    SELECT 
        SUM(
            CASE 
                WHEN vt.drcr_type = 'Dr' THEN vt.amount 
                ELSE -vt.amount 
            END
        ) AS profit_loss
    FROM voucher_transaction vt
    JOIN general_ledger gl ON gl.account_id = vt.account_id
    JOIN account_group ag ON ag.group_no = gl.group_no
    WHERE ag.pandl = 1
    AND vt.cancel = 0
    AND vt.voucher_date BETWEEN '$from_date' AND '$to_date'
    ";

		return $this->db->query($sql)->row()->profit_loss ?? 0;
	}

	public function get_balance_sheet_raw($to_date)
	{
		$sql = "SELECT 
    ag.group_no,
    ag.group_name,
    root.group_name AS root_type,
    ag.parent_group,
    gl.opening_balance,
    gl.account_id,
    gl.account_name,gl.opening_bal_type,

    COALESCE(vt.trans_balance, 0) AS trans_balance,

    (
        CASE 
            WHEN gl.opening_bal_type = 'Dr' THEN gl.opening_balance
            ELSE -gl.opening_balance
        END
        + COALESCE(vt.trans_balance, 0)
    ) AS closing_balance

FROM account_group ag

LEFT JOIN general_ledger gl 
    ON gl.group_no = ag.group_no
LEFT JOIN account_group root 
    ON root.group_no = (
        CASE 
            WHEN ag.parent_group = 0 THEN ag.group_no
            ELSE ag.parent_group
        END
    )
LEFT JOIN (
    SELECT 
        account_id,
        SUM(
            CASE 
                WHEN drcr_type = 'Dr' THEN amount
                WHEN drcr_type = 'Cr' THEN -amount
            END
        ) AS trans_balance
    FROM voucher_transaction
    WHERE cancel = 0
      AND DATE(voucher_date) <= '$to_date'
    GROUP BY account_id
) vt 
    ON vt.account_id = gl.account_id
WHERE (ag.pandl = 0 OR ag.pandl IS NULL)
-- WHERE (ag.pandl = 0 OR ag.pandl IS NULL)

    ";
		return $this->db->query($sql)->result();
	}

	private function build_tree($groups)
	{
		$tree = [];
		foreach ($groups as $group) {
			if ($group->parent_group == 0) {
				$tree[$group->group_no] = $group;
			} else {
				if ($group->parent_group != 0 && isset($groups[$group->parent_group])) {
					$groups[$group->parent_group]->children[] = $group;
				}
			}
		}
		return array_values($tree);
	}

	private function calculate_totals(&$groups)
	{
		foreach ($groups as &$group) {
			if (!empty($group->children)) {
				$this->calculate_totals($group->children);
				foreach ($group->children as $child) {
					$group->balance += $child->balance;
				}
			}
		}
	}




	public function get_ledger_transactions($account_id, $from, $to)
	{
		return $this->db->query("
        SELECT 
            v.voucher_date AS date,
            g.account_name AS ledger_name,
            CASE 
                WHEN v.drcr_type = 'Dr' THEN v.amount
                ELSE -v.amount
            END AS amount
        FROM voucher_transaction v
        JOIN general_ledger g ON g.account_id = v.account_id
        WHERE v.account_id = '$account_id'
        AND v.cancel = 0
        AND DATE(v.voucher_date) BETWEEN '$from' AND '$to'
        ORDER BY v.voucher_date ASC
    ")->result();
	}

	// ======================================================

	function get_bank_cash_ledgers($gno)
	{
		$query = $this->db->query(" select * from general_ledger where group_no in($gno) order by account_name;");
		return $query->result();
	}

	function add_employee_payment_details()
	{
		// E for salary expence
		// $code_prifix = "PVF/M/" . date('y') . "/";
		$code_prifix = "M/" . date('y') . "/";
		$this->load->model('Accounts_model');
		$num = ($this->Accounts_model->get_account_code_count($code_prifix, 'M')) + 1;
		$digit = sprintf("%1$05d", $num);
		$AccountCode = $code_prifix . $digit;

		$vdate = $this->input->post('v_date');
		$vtime = $this->input->post('vtime');
		$project_id = $this->input->post('project_id');
		$req_id = $this->input->post('req_id');


		/// debit entry 
		for ($i = 0; $i < count($_POST['debtor']); $i++) {
			$debtor = $_POST['debtor'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'M',
				//'customer_id' => $project_id,
				'account_id' => $debtor,
				'amount' => $_POST['dr_amount'][$i],
				'drcr_type' => 'Dr',
				'narration' => $this->input->post('narration'),
				//'trans_id' => $req_id,
				'trans_type' => 'M',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}
		// credit entry
		for ($i = 0; $i < count($_POST['debtor']); $i++) {
			$creditor = $_POST['creditor'][$i];
			$cr_amount = $_POST['cr_amount'][$i];

			$data = array(
				'voucher_code' => $AccountCode,
				'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
				'voucher_type' => 'M',
				//'customer_id' => $project_id,
				'account_id' => $creditor,
				'amount' => $cr_amount,
				'drcr_type' => 'Cr',
				'narration' => $this->input->post('narration'),
				//'trans_id' => $req_id,
				'trans_type' => 'M',
				'recordCreatedBy' => $this->session->userdata('user_id')
			);
			$this->db->insert('voucher_transaction', $data);
			$insert_id = $this->db->insert_id();
		}

		/// debit entry 
		for ($i = 0; $i < count($_POST['checkbox']); $i++) {
			$append_id = $_POST['checkbox'][$i];
			$dr_amount = $this->input->post("loan_amount$append_id");
			$user_id = $this->input->post("user_id$append_id");
			$account_id = $this->input->post("account_id$append_id");
			$montly_id = $this->input->post("sid$append_id");
			$date = date('Y-m-d h:i:s', strtotime("$vdate $vtime"));


			// bank/cash Cr and emp Dr
			if ($dr_amount > 0) {
				$data = array(
					'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
					'voucher_type' => 'M',
					/// N stands for contra entry
					'customer_id' => $user_id,
					'account_id' => $account_id,

					'amount' => $dr_amount,
					'drcr_type' => 'Dr',
					'narration' => 'Monthly Salary',
					'trans_type' => 'M',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$insert_id = $this->db->insert_id();

				$data = array(
					'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
					'voucher_type' => 'M',
					/// N stands for contra entry
					'customer_id' => $user_id,

					'account_id' => $creditor,
					'amount' => $dr_amount,
					'drcr_type' => 'Cr',
					'narration' => 'Monthly Salary',
					'trans_type' => 'M',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$insert_id = $this->db->insert_id();

				// echo $this->db->last_query();
				// echo "<br><br>";

				// if (!$this->db->affected_rows()) {

				// 	echo "<pre>";
				// 	print_r($this->db->error());
				// 	echo "</pre>";
				// }
				$this->load->helper('log');
				$query = $this->db->query("update employee_monthly_salary set account_entry=1 where sid='$montly_id'");
				// $notice = add_notification($insert_id, $user_id, "Account Department $AccountCode Monthly Salary Approve $date", "Accounts/payable_salary_list");
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('session_id');
			$uid = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($uid, 1, $page_name[1], 'voucher_transaction', 'voucher_id', $insert_id);
			return $insert_id;
		}
	}
}
