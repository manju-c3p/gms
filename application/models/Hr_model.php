<?php
date_default_timezone_set('Asia/Dubai');

class Hr_model extends CI_Model
{


	/////////////////  allowance & deductions start  ///////////////////
	function add_allowances_data()
	{
		$data = array(
			'allowance_type' => $this->input->post('allowance_type'),
			'allowance_name' => $this->input->post('allowance_name'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),
		);
		$this->db->insert('allowance_master', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'allowance_master', 'sno', $insert_id);
		}
		return $insert_id;
	}

	function update_allowances($id)
	{
		$data = array(
			'allowance_type' => $this->input->post('allowance_type'),
			'allowance_name' => $this->input->post('allowance_name'),
		);
		$this->db->where('sno', $id);
		$this->db->update('allowance_master', $data);
		if ($id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'allowance_master', 'sno', $id);
		}
		return $id;
	}
	function get_allowances_by_id($id)
	{
		$query = $this->db->query("select * from allowance_master where sno='$id'");
		return $query->result();
	}

	function get_allowances_list()
	{
		$query = $this->db->query("SELECT * FROM allowance_master ORDER BY allowance_type, allowance_name");
		return $query->result();
	}


	function delete_allowance($id)
	{
		$this->db->where('sno', $id);
		$this->db->delete('allowance_master');
	}
	/////////////////  employee_leave start  ///////////////////
	function add_employee_leave_data()
	{

		$prifix = 'LV';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'leave_code', 'employee_leave', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$LA_code = $prifix . $digit;

		$data = array(
			'employee_id' => $this->input->post('employee_id'),
			'leave_code' => $LA_code,
			'leave_type' => $this->input->post('ltype_id'),
			'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
			'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
			'reason' => $this->input->post('reason'),
			'replcement' => $this->input->post('replcement'),
			'application_date' => date('Y-m-d', strtotime($this->input->post('application_date'))),
			'outside_contact' => $this->input->post('outside_contact'),
			'joindate_fromlastLeave' => date('Y-m-d', strtotime($this->input->post('last_date'))),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),
		);

		// Check if the record already exists
		$this->db->where('employee_id', $data['employee_id']);
		$this->db->where('start_date', $data['start_date']);
		$this->db->where('end_date', $data['end_date']);
		$query = $this->db->get('employee_leave');

		if ($query->num_rows() > 0) {
			// Record already exists, display flash message
			$this->session->set_flashdata('error', 'Leave record already exists for the selected employee and dates.');
		} else {
			// Record does not exist, insert into the database

			$this->db->insert('employee_leave', $data);
			$insert_id = $this->db->insert_id();
			$query = $insert_id;
		}


		/////////////////// file upload ////////////////////
		if ($query) {
			if ($_FILES["documents"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				for ($i = 0; $i < count($_FILES['documents']["name"]); $i++) {
					if ($_FILES['documents']["name"][$i] != '') {
						$data['file_name'] = $_FILES["documents"]["name"][$i];

						$fname = $_FILES["documents"]["name"][$i];
						$temp = explode(".", $_FILES["documents"]["name"][$i]);
						$extension = end($temp);
						$other_file = '';
						if (($_FILES["documents"]["size"][$i] < 52428800) && in_array($extension, $allowedExts)) {
							if ($_FILES["documents"]["error"][$i] > 0) {
								$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
							} else {
								$timestamp1 = time();
								$file_tmp = $_FILES["documents"]["tmp_name"][$i];
								$other_file = $timestamp1 . "_" . $_FILES['documents']['name'][$i];
								move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);
								$data1 = array(
									'leave_id' => $insert_id,
									'employee_id' => $this->session->userdata('user_id'),
									'document_path' => $other_file,
								);
								$this->db->insert('employee_leave_documents', $data1);
							}
						}
					}
				}
			}
		}
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_leave', 'leave_id', $insert_id);
		/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
		$full_path = $_SERVER['REQUEST_URI'];
		$relative_path = strstr($full_path, 'index.php/');
		if ($relative_path) {
			$relative_path = str_replace('index.php/', '', $relative_path);
		}
		log_message('error', $full_path);
		$segments = explode('/', $relative_path);
		$current_url = '';
		if (isset($segments[0]) && isset($segments[1])) {
			$current_url = $segments[0] . '/' . $segments[1];
		}
		log_message('error', $current_url);
		$created_id = $this->session->userdata('user_id');
		$this->load->helper('log');
		// $notice = add_notification_in_master($query, $current_url, "$LA_code Leave application generate Successfully", "Hr/view_leave_corner_application_list");

		/////////////////////////////////////////end notification manage////////////////////////////////////////////
		/* end notification */
		return $query;
	}

	function update_employee_leave($id)
	{
		$data_leave = array(
			'employee_id' => $this->input->post('employee_id_hidden'),
			'leave_type' => $this->input->post('ltype_id'),
			'start_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
			'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
			'reason' => $this->input->post('reason'),
			'replcement' => $this->input->post('replcement'),
			'application_date' => date('Y-m-d', strtotime($this->input->post('application_date'))),
			'joindate_fromlastLeave' => date('Y-m-d', strtotime($this->input->post('last_date'))),
			'outside_contact' => $this->input->post('outside_contact'),
		);

		$this->db->where('leave_id', $id);
		$this->db->update('employee_leave', $data_leave);

		/////////////////// file upload ////////////////////
		if ($id) {
			if ($_FILES["documents"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				for ($i = 0; $i < count($_FILES['documents']["name"]); $i++) {
					if ($_FILES['documents']["name"][$i] != '') {
						$data['file_name'] = $_FILES["documents"]["name"][$i];

						$fname = $_FILES["documents"]["name"][$i];
						$temp = explode(".", $_FILES["documents"]["name"][$i]);
						$extension = end($temp);
						$other_file = '';
						if (($_FILES["documents"]["size"][$i] < 52428800) && in_array($extension, $allowedExts)) {
							if ($_FILES["documents"]["error"][$i] > 0) {
								$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
							} else {
								$timestamp1 = time();
								$file_tmp = $_FILES["documents"]["tmp_name"][$i];
								$other_file = $timestamp1 . "_" . $_FILES['documents']['name'][$i];
								move_uploaded_file($file_tmp, "/home/webadmin/gen/multiscale/public/uploded_documents/" . $other_file);
								$data1 = array(
									'leave_id' => $id,
									'employee_id' => $this->input->post('employee_id'),
									'document_path' => $other_file,
								);
								$this->db->insert('employee_leave_documents', $data1);
							}
						}
					}
				}
			}
		}
		// Log entry
		if ($id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_leave', 'leave_id', $id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$lv_code = $this->input->post('lv_code');
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "$lv_code Leave application Update Successfully", "Hr/view_leave_corner_application_list");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////
			/* end notification */
		}

		return $id;
	}

	function get_employee_leave_by_id12($id)
	{
		$query = $this->db->query("
					SELECT 
						j.*, u.*,
					u.department_id,u.designation_id,u.mobile,
						u.employee_name AS user_name, 
						plm.use_paid_leave,
						lm.*,
						lm.remark as approve_remark,
						j.end_date as enddate
					FROM employee_leave j
					JOIN employees u ON j.employee_id = u.employee_id
					LEFT JOIN paid_leave_master plm 
						ON j.employee_id = plm.emp_id 
						AND YEAR(plm.p_date) = YEAR(CURDATE())
						LEFT JOIN leave_approval lm 
						ON j.leave_id = lm.approval_leave_id 
					WHERE j.leave_id = '$id'
					ORDER BY j.application_date DESC
				");
		return $query->result();
	}

	function get_employee_leave_by_id($id)
	{
		$query = $this->db->query("
        SELECT 
            j.*, 
            u.*,
            u.department_id,
            u.designation_id,
            u.mobile,
            u.employee_name AS user_name, 
            plm.use_paid_leave,
            lm.*,
            lm.remark as approve_remark,
            j.end_date as enddate,
            lc.category_name AS leave_type_name
        FROM employee_leave j
        JOIN employees u 
            ON j.employee_id = u.employee_id

        LEFT JOIN leave_category lc 
            ON j.leave_type = lc.leave_cat_id   -- ✅ THIS IS THE FIX

        LEFT JOIN paid_leave_master plm 
            ON j.employee_id = plm.emp_id 
            AND YEAR(plm.p_date) = YEAR(CURDATE())

        LEFT JOIN leave_approval lm 
            ON j.leave_id = lm.approval_leave_id 

        WHERE j.leave_id = '$id'
        ORDER BY j.application_date DESC
    ");

		return $query->result();
	}


	function get_employee_leave_approveal_record($id)
	{
		$query = $this->db->query("select  * from leave_approval where approval_leave_id='$id' ");
		return $query->result();
	}

	function get_employee_leave_doc_id($id)
	{
		$query = $this->db->query("select  * from employee_leave_documents  where leave_id='$id' ");
		return $query->result();
	}

	// function get_employee_leave_list()
	// {
	// 	$query = $this->db->query("select  la.*,j.*, u.user_name as name,u.user_id from employee_leave j, leave_approval la, users u where j.employee_id=u.user_id  and la.leave_id=j.leave_id order by application_date desc ");
	// 	return $query->result();
	// }
	public function get_employee_leave_list($user_id = null)
	{
		$this->db->select("
        e.leave_id,
        e.leave_code,
        e.employee_id,
        e.leave_type,       
        e.start_date,
         e.end_date AS e_date,
		 e.application_date,
        e.reason,
        e.outside_contact,
        u.employee_name,
  
        la.leave_status,
        la.admin_md,
        la.hr,
        la.ceo
    ");
		$this->db->from('employee_leave AS e');
		$this->db->join('employees AS u', 'e.employee_id = u.employee_id', 'inner');
		$this->db->join('leave_approval AS la', 'e.leave_id = la.approval_leave_id', 'left');



		$this->db->order_by('e.leave_id', 'DESC');
		return $this->db->get()->result();
	}


	function get_leave_approval_list()
	{
		$query = $this->db->query("select * from leave_approval ");
		return $query->result();
	}

	function delete_leave_application($id)
	{
		$this->db->where('approval_leave_id', $id);
		$this->db->delete('leave_approval');
		$this->db->where('leave_id', $id);
		$this->db->delete('employee_leave');
	}

	function get_leave_approval_details_leave_id($id)
	{
		$query = $this->db->query("select * from leave_approval WHERE approval_leave_id = '$id'");
		return $query->result();
	}

	/////////////////////////approval////////////////////////////////////////////////////

	public function add_approval_leave()
	{
		$leave_id       = $this->input->post('hide_leave_id');
		$employee       = $this->input->post('emp_id');
		$status         = $this->input->post('leave_status');
		$approve_start  = date('Y-m-d', strtotime($this->input->post('approve_start_date')));
		$approve_end    = date('Y-m-d', strtotime($this->input->post('approve_end_date')));
		$total_days     = $this->input->post('approve_total_date');
		$pl_counter     = $this->input->post('use_paid_leave');

		$logged_in_user    = $this->session->userdata('user_id');
		$logged_in_desig   = $this->session->userdata('desig_id'); // 60 = CEO
		$first_level_approver = $this->input->post('approve_admin'); // HOD
		$hr_user           = $this->input->post('approve_hr'); // HR
		$ceo_user          = $this->input->post('approve_ceo'); // CEO from form
		$remark            = $this->input->post('approve_remark');

		// Prepare approval data
		$data = [
			'approved_date'      => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			'leave_status'       => $status,
			'approve_start_date' => $approve_start,
			'approve_end_date'   => $approve_end,
			// 'approve_total_date' => $total_days,
			'remark'             => $remark
		];

		// Set approver field based on logged-in user
		if ($logged_in_user == $first_level_approver) {
			$data['admin_md'] = $first_level_approver;
		} elseif ($logged_in_desig == 60) { // CEO
			$data['ceo'] = $logged_in_user;
		} else {
			$data['hr'] = $hr_user;
		}

		// Check if approval record exists
		$existing = $this->db->get_where('leave_approval', ['approval_leave_id' => $leave_id])->row();

		if ($existing) {
			$this->db->where('approval_leave_id', $leave_id);
			$this->db->update('leave_approval', $data);
			$insert_id = $existing->app_id;
		} else {
			$data['approval_leave_id'] = $leave_id;
			// $data['employee_id']       = $employee;
			$this->db->insert('leave_approval', $data);
			$insert_id = $this->db->insert_id();
		}

		// If leave is approved, adjust paid leave & attendance
		if ($status == 1) {
			$leave_type = $this->input->post('leave_type');

			// Update paid leave transaction
			$query = $this->db->query(
				"SELECT pt.leave_transaction_id 
             FROM paid_leave_master pm 
             JOIN paid_leave_transaction pt ON pm.paid_id = pt.paid_id_master 
             WHERE pm.emp_id = ? AND pt.leave_type_id = ?",
				[$employee, $leave_type]
			);

			if ($query->num_rows() > 0) {
				$leave_transaction_id = $query->row()->leave_transaction_id;
				$update_data = ['use_paid_leave' => $total_days];

				$this->db->where('leave_transaction_id', $leave_transaction_id);
				$this->db->where('leave_type_id', $leave_type);
				$this->db->update('paid_leave_transaction', $update_data);
			}

			// Update employee attendance
			for ($k = 0; $k < $total_days; $k++) {
				$attendance_date = date('Y-m-d', strtotime("$approve_start +$k day"));

				$exists = $this->db->get_where('employee_attendance', [
					'employee_id' => $employee,
					'Attendance_date' => $attendance_date
				])->row();

				if (!$exists) {
					if ($pl_counter > 0) {
						$insert_data = [
							'employee_id'      => $employee,
							'Attendance_date'  => $attendance_date,
							'attendence'       => 'A',
							'use_paid_leave'   => 'PL',
							'type'             => 'M'
						];
						$pl_counter--;
					} else {
						$insert_data = [
							'employee_id'      => $employee,
							'Attendance_date'  => $attendance_date,
							'attendence'       => 'A',
							'use_paid_leave'   => '0',
							'type'             => 'M'
						];
					}
					$this->db->insert('employee_attendance', $insert_data);
				}
			}
		}

		// Log and notification
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			add_log_entry($user_se_id, 2, $page_name[1], 'leave_approval', 'app_id', $insert_id);

			// add_notification($insert_id, $employee, ($status == 1 ? "Leave Approved" : "Leave Rejected"), "Hr/view_leave_corner_application_list");
		}

		return $insert_id;
	}



	public function update_approval_leave()
	{
		$leave_id = $this->input->post('hide_leave_id');

		// Prepare data to be inserted into the leave_approval table
		$data = array(
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			'leave_status' => $this->input->post('leave_status'),
			'approve_start_date' => date('Y-m-d', strtotime($this->input->post('approve_start_date'))),
			'approve_end_date' => date('Y-m-d', strtotime($this->input->post('approve_end_date'))),
			'remark' => $this->input->post('approve_remark'),
			'admin_md' => $this->input->post('approve_admin'),
			'hr' => $this->input->post('approve_hr'),
			'ceo' => $this->input->post('approve_ceo'),
			//'admin_md_sign' => $this->input->post('approve_admin_sign'),
			//'hr_sign' => $this->input->post('approve_hr_sign'),
			// 'hod_sign' => $this->input->post('approve_hod_sign'),
		);

		$this->db->where('approval_leave_id', $leave_id);
		$this->db->update('leave_approval', $data);
		if ($leave_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'leave_approval', 'approval_leave_id', $leave_id);
		}
		return $leave_id;
	}

	public function leave_approval_list()
	{
		$query = $this->db->query("SELECT * FROM leave_approval ORDER BY approved_date DESC ");
		return $query->result();
	}

	public function leave_hr_admin_list()
	{
		$query = $this->db->query("
        SELECT 
            a.*,
            u1.username AS hr_user_name, 
            u1.id AS hr_user_id, 
            u2.username AS admin_md_user_name, 
            u2.id AS admin_md_user_id
        FROM approval_setup a
        JOIN users u1 ON a.approve_hr = u1.id
        JOIN users u2 ON a.approve_admin_md = u2.id and approve_type='Leave'
    ");
		return $query->result();
	}
	public function resignation_hr_admin_list()
	{
		$query = $this->db->query("
        SELECT 
            a.*,
            u1.username AS hr_user_name, 
            u1.id AS hr_user_id, 
            u2.username AS admin_md_user_name, 
            u2.id AS admin_md_user_id
        FROM approval_setup a
        JOIN users u1 ON a.approve_hr = u1.id
        JOIN users u2 ON a.approve_admin_md = u2.id and approve_type='Resignation'
    ");
		return $query->result();
	}
	public function po_hr_admin_list()
	{
		$query = $this->db->query("
        SELECT 
            a.*,
            u1.user_name AS hr_user_name, 
            u1.user_id AS hr_user_id, 
            u2.user_name AS admin_md_user_name, 
            u2.user_id AS admin_md_user_id
        FROM approval_setup a
        JOIN users u1 ON a.approve_hr = u1.user_id
        JOIN users u2 ON a.approve_admin_md = u2.user_id and approve_type='Purchase Order'
    ");
		return $query->result();
	}

	/////////////////  Joining start  ///////////////////
	function add_joining_application_data()
	{
		$prifix = 'JA';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'joining_code	', 'employee_joining', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$JA_code = $prifix . $digit;


		$data = array(
			'employee_id' => $this->input->post('employee_id'),
			'joining_code' => $JA_code,
			'joining_type' => $this->input->post('joining_type'),
			'joining_date' => date('Y-m-d', strtotime($this->input->post('joining_date'))),
			'offer_letter' => $this->input->post('offer_letter'),
			'remark' => $this->input->post('remark'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),
		);
		$this->db->insert('employee_joining', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_joining', 'jid', $insert_id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($insert_id, $current_url, "New Joining Application $JA_code", "Hr/edit_joining_application/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

		}
		return $insert_id;
	}

	function update_joining_application($id)
	{
		$data = array(
			'employee_id' => $this->input->post('employee_id_hidden'),
			'joining_type' => $this->input->post('joining_type'),
			'joining_date' => date('Y-m-d', strtotime($this->input->post('joining_date'))),
			'offer_letter' => $this->input->post('offer_letter'),
			//'created_by'  => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),

		);
		$this->db->where('jid', $id);
		$this->db->update('employee_joining', $data);
		if ($id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_joining', 'jid', $id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$JA_code = $this->input->post('ja_code');
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Updated Joining Application $JA_code", "Hr/edit_joining_application/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

		}
		return $id;
	}
	function get_employee_joining_by_id($id)
	{
		$query = $this->db->query("select j.*,u.*,u.user_name as name ,u.joining_date as jdate,j.joining_date as joind from employee_joining j, users u where j.employee_id=u.user_id AND jid='$id' order by joind desc  ");

		return $query->result();
	}

	function get_employee_joining_list()
	{
		$query = $this->db->query("select j.*, u.user_name as name from employee_joining j, users u where j.employee_id=u.user_id order by joining_date desc ");
		return $query->result();
	}
	function get_joining_new_list()
	{
		$query = $this->db->query("
        SELECT *
        FROM users u
        WHERE u.active = 0
        AND u.user_id NOT IN (
            SELECT employee_id
            FROM employee_joining
        )
        ORDER BY u.user_name
    ");

		return $query->result();
	}




	function delete_joining_application($id)
	{
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 3, $page_name[1], 'employee_joining', 'jid', $id);

		$this->db->where('jid', $id);
		$this->db->delete('employee_joining');
	}

	//////////////////////////////////////////function start resignation application//////////////////

	public function add_resignation()
	{

		$prifix = 'RA';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'resign_code	', 'employee_resignation', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$RA_code = $prifix . $digit;



		$data = array(
			'employee_id' => $this->input->post('employee_id'),
			'resign_code' => $RA_code,
			'resignation_date' => date('Y-m-d', strtotime($this->input->post('resignation_date'))),
			'last_working_date' => date('Y-m-d', strtotime($this->input->post('last_working_date'))),
			'notice_days' => $this->input->post('notice_days'),
			'reason' => $this->input->post('reason'),
		);

		$this->db->insert('employee_resignation', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			if (!empty($_FILES["documents_res"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_res']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_res"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "uploads/resignation/" . $other_file);

							$data1 = array(
								'resig_id' => $insert_id,
								'employee_id' => $this->input->post('employee_id'),
								'document_name' => $this->input->post('document_types')[$key],
								'document_path' => $other_file,
							);
							$this->db->insert('employee_resignation_documents', $data1);
						}
					}
				}
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_resignation', 'resig_id', $insert_id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			// $notice = add_notification_in_master($insert_id, $current_url, "$RA_code Resignation submitted successfully", "Hr/edit_emp_regignation/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////
			/* end notification */
		}
		return $insert_id;
	}

	function update_resigning_application($id)
	{
		$data = array(
			'employee_id' => $this->input->post('employee_id_hidden'),
			'resignation_date' => date('Y-m-d', strtotime($this->input->post('resignation_date'))),
			'last_working_date' => date('Y-m-d', strtotime($this->input->post('last_working_date'))),
			'notice_days' => $this->input->post('notice_days'),
			'reason' => $this->input->post('reason'),
		);

		$this->db->where('resig_id', $id);
		$res = $this->db->update('employee_resignation', $data);


		if ($id) {
			if (!empty($_FILES["documents_res"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_res']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_res"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "uploads/resignation/" . $other_file);

							$data1 = array(
								'resig_id' => $id,
								'employee_id' => $this->input->post('employee_id_hidden'),
								'document_name' => $this->input->post('document_types')[$key],
								'document_path' => $other_file,
							);
							$this->db->insert('employee_resignation_documents', $data1);
						}
					}
				}
			}
		}

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_resignation', 'resig_id', $id);
			$ra_code = $this->input->post('ra_code');
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			// $notice = add_notification_in_master($id, $current_url, "$ra_code Resignation Update successfully", "Hr/edit_emp_regignation/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////
			/* end notification */
			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}


	function get_employee_resignation_list()
	{
		$query = $this->db->query("select r.*, u.employee_name as name from employee_resignation r, employees u where r.employee_id=u.employee_id order by resignation_date desc ");
		return $query->result();
	}



	function get_employee_document_doc_id($id)
	{
		$query = $this->db->query("select  * from employee_resignation_documents  where resig_id='$id' ");
		return $query->result();
	}


	function get_resignation_active_list()
	{
		$query = $this->db->query("
        SELECT *, employee_id
        FROM employees
        WHERE employee_id NOT IN (
            SELECT employee_id
            FROM employee_resignation
        )
        ORDER BY employee_name
    ");
		return $query->result();
	}

	function get_resignation_for_corner()
	{
		$query = $this->db->query("
        SELECT *, user_id
        FROM users
       
     
        ORDER BY user_name
    ");
		return $query->result();
	}

	function get_employee_resigning_by_id($id)
	{
		$query = $this->db->query("SELECT r.*, u.*
								   FROM employee_resignation AS r
								    JOIN employees AS u ON r.employee_id = u.employee_id
								   WHERE resig_id = '$id'
								   ORDER BY r.resignation_date DESC");

		return $query->result();
	}

	function get_employee_experience_certificate($id)
	{
		$query = $this->db->query("select one.*,two.*, three.dept_name, four.designation_name from (select * from employee_resignation  where resig_id='$id'  ORDER BY resignation_date DESC  )as one left join(select * from users )as two on(one.employee_id=two.user_id) left join(select * from department_master )as three on(two.dept_id=three.dept_id) left join(select  * from designation_master)as four on(two.desig_id=four.did) ");
		return $query->result();
	}

	function delete_resignation_application($id)
	{
		$this->db->where('resig_id', $id);
		$this->db->delete('employee_resignation');
	}

	///this is new inseration passport relese data/////////////////////////////////////////////////////

	function add_passport_release()
	{
		$data = array(
			'emp_id' => $this->input->post('user_id'),
			'document_name' => 'passport',
			'status' => 'passport release',
			'document_number' => $this->input->post('doc_no'),
			'issue_date' => date('Y-m-d', strtotime($this->input->post('issue_date'))),
			'expiry_date' => date('Y-m-d', strtotime($this->input->post('exp_date'))),
			'outdate' => date('Y-m-d', strtotime($this->input->post('outdate'))),
			'indate' => date('Y-m-d', strtotime($this->input->post('indate'))),
			'posession' => $this->input->post('location'),
			'reason' => $this->input->post('reason'),
			'remark ' => $this->input->post('remark'),
		);
		$this->db->insert('employee_document_details', $data);
		$insert_id = $this->db->insert_id();
		$passport_relese = $this->input->post('user_id');
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			// $log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_document_details', 'emp_docId', $insert_id);

			// $notice = add_notification($insert_id, $passport_relese, "Passport Release", "Hr/edit_passport_release/$insert_id");
		}
		return $insert_id;
	}

	function update_passport_re($id)
	{
		$data = array(
			'emp_id' => $this->input->post('employee_id_hidden'),
			'document_name' => 'passport',
			'status' => 'passport release',
			'outdate' => date('Y-m-d', strtotime($this->input->post('outdate'))),
			'indate' => date('Y-m-d', strtotime($this->input->post('indate'))),
			'posession' => $this->input->post('location'),
			'reason' => $this->input->post('reason'),
			'remark' => $this->input->post('remark'),
		);

		$this->db->where('emp_docId', $id);
		$res = $this->db->update('employee_document_details', $data);
		$passport_relese = $this->input->post('employee_id_hidden');
		if ($res) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_document_details', 'emp_docId', $id);
			// $notice = add_notification($id, $passport_relese, "Release Passport Updated", "Hr/edit_passport_release/$id");

			return true;
		} else {
			return false;
		}
	}


	function get_passport_release_list()
	{
		$query = $this->db->query("SELECT e.*, u.* FROM employee_document_details AS e JOIN users AS u ON e.emp_id = u.id WHERE e.status = 'passport release' ORDER BY e.emp_docId DESC ");
		return $query->result();
	}
	function get_passport_release_list_by_id($id)
	{
		$query = $this->db->query("SELECT e.*, u.*,e.remark as rem FROM employee_document_details AS e JOIN employees AS u ON e.emp_id = u.employee_id WHERE e.status = 'passport release' AND emp_docId = '$id'ORDER BY e.emp_docId DESC LIMIT 1");
		return $query->result();
	}



	function get_user_record_by_id($id)
	{
		$query = $this->db->query("SELECT u.*, e.* FROM employees u JOIN employee_document_details e ON u.employee_id = e.emp_id WHERE e.emp_docId = '$id' AND document_name ='passport' ORDER BY emp_docId DESC LIMIT 1");
		return $query->result();
	}



	function delete_passport_release($id)
	{
		$this->db->where('emp_docId', $id);
		$this->db->delete('employee_document_details');
	}
	///////////////////////////////////////////start overtime form model /////////////////////////////////

	function add_emp_overtime_data()
	{
		$data = array(
			'employee_id' => $this->input->post('employee_id'),
			'date_ot' => date('Y-m-d', strtotime($this->input->post('overtime_date'))),
			'overtime' => $this->input->post('ot'),
			'remark' => $this->input->post('remark'),

		);

		// Check if a record with the same employee ID and overtime date already exists
		$this->db->where('employee_id', $data['employee_id']);
		$this->db->where('date_ot', $data['date_ot']);
		$query = $this->db->get('employee_overtime');

		if ($query->num_rows() > 0) {
			// Record already exists, display flash message
			$this->session->set_flashdata('error', 'Employee overtime record already exists.');
			return false;
		} else {
			// Record does not exist, insert into the database
			$this->db->insert('employee_overtime', $data);
			$insert_id = $this->db->insert_id();

			if ($insert_id) {
				$user_se_id = $this->session->userdata('user_id');
				$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
				$ci = get_instance();
				$ci->load->helper('log');
				$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_overtime', 'emp_oid', $insert_id);
			}
			return $insert_id;
		}
	}



	function update_emp_overtime($id)
	{
		$data = array(
			'employee_id' => $this->input->post('employee_id_hidden'),
			'date_ot' => date('Y-m-d', strtotime($this->input->post('overtime_date'))),
			'overtime' => $this->input->post('ot'),
			'remark' => $this->input->post('remark'),
		);

		$this->db->where('emp_oid', $id);
		$res = $this->db->update('employee_overtime', $data);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_overtime', 'emp_oid', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}


	function get_emp_overtime_list()
	{
		$query = $this->db->query("select r.*, u.user_name as name from employee_overtime r, users u where r.employee_id=u.user_id order by date_ot desc ");
		return $query->result();
	}

	function get_emp_overtime_by_id($id)
	{
		$query = $this->db->query("SELECT o.*, u.*,o.remark as rem
								   FROM employee_overtime AS o
								   INNER JOIN users AS u ON o.employee_id = u.user_id
								   WHERE emp_oid = '$id'
								   ORDER BY o.date_ot DESC");

		return $query->result();
	}

	function delete_emp_overtime($id)
	{
		$this->db->where('emp_oid', $id);
		$this->db->delete('employee_overtime');
	}
	//////////////////////////////////////start attendance/////////////////////////////////////////////
	// function add_emp_attendance_data()
	// {
	// 	$attendance = $this->input->post('attendance');

	// 	$data = array(
	// 		'employee_id' => $this->input->post('employee_id'),
	// 		'Attendance_date' => date('Y-m-d', strtotime($this->input->post('Attendance_date'))),
	// 		'attendence' => $attendance,
	// 		'remark' => $this->input->post('remark')

	// 	);

	// 	// Check if attendance is present, then add in_time and out_time
	// 	if ($attendance === 'present') {
	// 		$data['in_time'] = $this->input->post('in_time');
	// 		$data['out_time'] = $this->input->post('out_time');
	// 	}

	// 	// Check if a record with the same attendance date and employee ID already exists
	// 	$this->db->where('employee_id', $data['employee_id']);
	// 	$this->db->where('Attendance_date', $data['Attendance_date']);
	// 	$query = $this->db->get('employee_attendance');

	// 	if ($query->num_rows() > 0) {
	// 		// Record already exists, display flash message
	// 		$this->session->set_flashdata('error', 'Employee Attendance record already exists.');
	// 		return false;
	// 	} else {
	// 		// Record does not exist, insert into the database
	// 		$this->db->insert('employee_attendance', $data);
	// 		$insert_id = $this->db->insert_id();

	// 		if ($insert_id) {
	// 			$user_se_id = $this->session->userdata('user_id');
	// 			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
	// 			$ci = get_instance();
	// 			$ci->load->helper('log');
	// 			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_attendance', 'emp_aId', $insert_id);
	// 		}
	// 		return $insert_id;
	// 	}
	// }

	function update_emp_attendance($id)
	{
		$attendance = $this->input->post('attendance');


		$data = array(
			'employee_id' => $this->input->post('employee_id_hidden'),
			'Attendance_date' => date('Y-m-d', strtotime($this->input->post('Attendance_date'))),
			'attendence' => $attendance,
			'remark' => $this->input->post('remark')
		);

		// Check if attendance is present, then add in_time and out_time
		if ($attendance === 'P') {
			$data['in_time'] = $this->input->post('in_time');
			$data['out_time'] = $this->input->post('out_time');
		}

		$this->db->where('emp_aId', $id);
		$res = $this->db->update('employee_attendance', $data);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_attendance', 'emp_aId', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}



	function add_emp_attendance_dataold()
	{
		$checked_users = isset($_POST['checkbox']) ? $_POST['checkbox'] : array();
		$insert_id = null;

		// Check if the required form fields are available
		if (empty($_POST['user_id']) || empty($_POST['in_time']) || empty($_POST['out_time'])) {
			return false;
		}

		foreach ($checked_users as $index => $user_id) {
			// Find the index of the current user_id in the user_id array
			$user_index = array_search($user_id, $_POST['user_id']);

			$data = array(
				'employee_id' => $user_id,
				'Attendance_date' => date('Y-m-d', strtotime($this->input->post('attendance_date'))),
				'attendence' => $this->input->post('attendance'),
				'in_time' => isset($_POST['in_time'][$user_index]) ? $_POST['in_time'][$user_index] : null,
				'out_time' => isset($_POST['out_time'][$user_index]) ? $_POST['out_time'][$user_index] : null,
				'created_by' => $this->session->userdata('user_id'),
				'created_date' => date('Y-m-d H:i:s'),
				'type' => 'M'

			);

			$this->db->insert('employee_attendance', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_attendance', 'emp_aId', $insert_id);
		}

		return $insert_id;
	}
	function add_emp_attendance_data()
	{
		$checked_users = isset($_POST['checkbox']) ? $_POST['checkbox'] : array();

		if (empty($_POST['user_id'])) {
			return false;
		}

		$attendance_date = date('Y-m-d', strtotime($this->input->post('attendance_date')));

		$insert_id = null;

		foreach ($_POST['user_id'] as $index => $user_id) {

			// decide attendance status
			if (in_array($user_id, $checked_users)) {
				$status = $this->input->post('attendance');   // usually 'P'
				$in_time  = isset($_POST['in_time'][$index]) ? $_POST['in_time'][$index] : null;
				$out_time = isset($_POST['out_time'][$index]) ? $_POST['out_time'][$index] : null;
			} else {
				$status = 'A';     // 🔥 ABSENT AUTO
				$in_time = null;
				$out_time = null;
			}

			// prevent duplicate entry same date
			$this->db->where('employee_id', $user_id);
			$this->db->where('Attendance_date', $attendance_date);
			$exists = $this->db->get('employee_attendance')->row();

			if (!$exists) {

				$data = array(
					'employee_id' => $user_id,
					'Attendance_date' => $attendance_date,
					'attendence' => $status,
					'in_time' => $in_time,
					'out_time' => $out_time,
					'created_by' => $this->session->userdata('user_id'),
					'created_date' => date('Y-m-d H:i:s'),
					'type' => 'M'
				);

				$this->db->insert('employee_attendance', $data);
				$insert_id = $this->db->insert_id();
			}
		}

		return $insert_id;
	}


	function get_emp_attendance_list()
	{
		$query = $this->db->query("select r.*,u.employee_code, u.employee_name as name from employee_attendance r, employees u where r.employee_id=u.employee_id order by Attendance_date desc ");
		return $query->result();
	}

	// function get_emp_attendance_list_filter()
	// {
	// 	$from = date('Y-m-d', strtotime($this->input->post('from')));
	// 	$to = date('Y-m-d', strtotime($this->input->post('to')));
	// 	$user_id = $this->input->post('user_id');
	// 	$user_condition = "";

	// 	if ($user_id != "")
	// 		$user_condition = "  ea.employee_id='$user_id' "; {



	// 	$query = $this->db->query("select r.*,u.user_code, u.user_id,u.user_name as name from employee_attendance r, users u where r.employee_id=u.user_id and r.Attendance_date between '$from' and '$to' $user_condition order by r.Attendance_date desc ");


	// 	return $query->result();
	// }
	function get_emp_attendance_list_filter_get_todays_record()
	{
		$today = date('Y-m-d');

		// 	$sql = "
		//     SELECT 
		//         ea.*,
		//         u.id,
		//         u.username AS name,
		//         cr.username AS created_by_user
		//     FROM users u
		//     LEFT JOIN employee_attendance ea
		//         ON ea.employee_id = u.id
		//         AND ea.Attendance_date = ?
		//         AND ea.type != 'I'
		//     LEFT JOIN users cr
		//         ON cr.id = ea.created_by
		//     WHERE u.status = 'Active'
		//     ORDER BY u.username ASC
		// ";
		$sql = "
    SELECT 
        ea.*,
        e.employee_id,
        e.employee_name AS name,
        cr.employee_name AS created_by_user
    FROM employees e
    LEFT JOIN employee_attendance ea
        ON ea.employee_id = e.employee_id
        AND ea.Attendance_date = ?
        AND ea.type != 'I'
    LEFT JOIN employees cr
        ON cr.employee_id = ea.created_by
    WHERE e.status = 'Active'
    ORDER BY e.employee_name ASC
";

		$query = $this->db->query($sql, [$today]);

		return $query->result();
	}

	// function get_emp_attendance_list_filter_get_todays_record()
	// {
	// 	// Get today's date in 'Y-m-d' format
	// 	$today = date('Y-m-d');

	// 	// SQL query for today's records only
	// 	$sql = "
	//     (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//      FROM users u
	//      LEFT JOIN employee_attendance ea
	//        ON ea.employee_id = u.user_id
	//        AND ea.Attendance_date = ?
	//      WHERE ea.type != 'I' AND u.active = 0)

	//     UNION ALL

	//     (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//      FROM users u
	//      LEFT JOIN employee_attendance ea
	//        ON ea.ivms_id = u.ivms_id
	//        AND ea.Attendance_date = ?
	//      WHERE ea.type = 'I' AND u.active = 0)


	// ";

	// 	$query = $this->db->query($sql, [$today, $today]);

	// 	return $query->result();
	// }

	// function get_emp_attendance_list_filter()
	// {
	// 	$from = date('Y-m-d', strtotime($this->input->post('from')));
	// 	$to = date('Y-m-d', strtotime($this->input->post('to')));
	// 	$user_id = $this->input->post('user_id');


	// 	if (!empty($user_id)) {
	// 		// Case 1: Specific user filter applied
	// 		$sql = " ( SELECT ea.*, u.user_code, u.user_id, u.user_name AS name FROM users u LEFT JOIN employee_attendance ea ON ea.employee_id = u.user_id AND ea.Attendance_date BETWEEN ? AND ? WHERE ea.employee_id = ? AND ea.type != 'I' AND u.active = 0) UNION ALL ( SELECT ea.*, u.user_code, u.user_id, u.user_name AS name FROM users u LEFT JOIN employee_attendance ea ON ea.ivms_id = u.ivms_id AND ea.Attendance_date BETWEEN ? AND ? WHERE ea.employee_id = ? AND ea.type = 'I'  AND u.active = 0) ORDER BY Attendance_date DESC ";

	// 		$query = $this->db->query($sql, [$from, $to, $user_id, $from, $to, $user_id]);
	// 	} else {
	// 		// Case 2: No user filter — all users
	// 		$sql = " ( SELECT ea.*, u.user_code, u.user_id, u.user_name AS name FROM users u LEFT JOIN employee_attendance ea ON ea.employee_id = u.user_id AND ea.Attendance_date BETWEEN ? AND ? WHERE ea.type != 'I' AND u.active = 0 ) UNION ALL ( SELECT ea.*, u.user_code, u.user_id, u.user_name AS name FROM users u LEFT JOIN employee_attendance ea ON ea.ivms_id = u.ivms_id AND ea.Attendance_date BETWEEN ? AND ? WHERE ea.type = 'I' AND u.active = 0 ) ORDER BY Attendance_date DESC ";

	// 		$query = $this->db->query($sql, [$from, $to, $from, $to]);
	// 	}

	// 	return $query->result();
	// }



	// function get_emp_attendance_list_filter()
	// {
	// 	$from = date('Y-m-d', strtotime($this->input->post('from')));
	// 	$to = date('Y-m-d', strtotime($this->input->post('to')));
	// 	$user_id = $this->input->post('user_id');
	// 	$attendance_type = $this->input->post('attendance_type');

	// 	// Case 1: Both user_id and attendance_type are selected
	// 	if (!empty($user_id) && !empty($attendance_type)) {

	// 		if ($attendance_type == 'I') {
	// 			// Biometric / IVMS
	// 			$sql = "
	//             SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//             FROM users u
	//             LEFT JOIN employee_attendance ea
	//                 ON ea.ivms_id = u.ivms_id
	//                 AND ea.Attendance_date BETWEEN ? AND ?
	//             WHERE ea.employee_id = ?
	//               AND ea.type = 'I'
	//               AND u.active = 0
	//             ORDER BY ea.Attendance_date DESC
	//         ";
	// 			$params = [$from, $to, $user_id];
	// 		} else {
	// 			// Manual / Onsite
	// 			$sql = "
	//             SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//             FROM users u
	//             LEFT JOIN employee_attendance ea
	//                 ON ea.employee_id = u.user_id
	//                 AND ea.Attendance_date BETWEEN ? AND ?
	//             WHERE ea.employee_id = ?
	//               AND ea.type = ?
	//               AND u.active = 0
	//             ORDER BY ea.Attendance_date DESC
	//         ";
	// 			$params = [$from, $to, $user_id, $attendance_type];
	// 		}
	// 	}
	// 	// Case 2: Only user_id is selected
	// 	elseif (!empty($user_id)) {
	// 		$sql = "
	//         (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//          FROM users u
	//          LEFT JOIN employee_attendance ea
	//              ON ea.employee_id = u.user_id
	//              AND ea.Attendance_date BETWEEN ? AND ?
	//          WHERE ea.employee_id = ?
	//            AND ea.type != 'I'
	//            AND u.active = 0)
	//         UNION ALL
	//         (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//          FROM users u
	//          LEFT JOIN employee_attendance ea
	//              ON ea.ivms_id = u.ivms_id
	//              AND ea.Attendance_date BETWEEN ? AND ?
	//          WHERE ea.employee_id = ?
	//            AND ea.type = 'I'
	//            AND u.active = 0)
	//         ORDER BY Attendance_date DESC
	//     ";
	// 		$params = [$from, $to, $user_id, $from, $to, $user_id];
	// 	}
	// 	// Case 3: Only attendance_type is selected
	// 	elseif (!empty($attendance_type)) {

	// 		if ($attendance_type == 'I') {
	// 			$sql = "
	//             SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//             FROM users u
	//             LEFT JOIN employee_attendance ea
	//                 ON ea.ivms_id = u.ivms_id
	//                 AND ea.Attendance_date BETWEEN ? AND ?
	//             WHERE ea.type = 'I'
	//               AND u.active = 0
	//             ORDER BY ea.Attendance_date DESC
	//         ";
	// 			$params = [$from, $to];
	// 		} else {
	// 			$sql = "
	//             SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//             FROM users u
	//             LEFT JOIN employee_attendance ea
	//                 ON ea.employee_id = u.user_id
	//                 AND ea.Attendance_date BETWEEN ? AND ?
	//             WHERE ea.type = ?
	//               AND u.active = 0
	//             ORDER BY ea.Attendance_date DESC
	//         ";
	// 			$params = [$from, $to, $attendance_type];
	// 		}
	// 	}
	// 	// Case 4: No filters — all users & all types
	// 	else {
	// 		$sql = "
	//         (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//          FROM users u
	//          LEFT JOIN employee_attendance ea
	//              ON ea.employee_id = u.user_id
	//              AND ea.Attendance_date BETWEEN ? AND ?
	//          WHERE ea.type != 'I'
	//            AND u.active = 0)
	//         UNION ALL
	//         (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//          FROM users u
	//          LEFT JOIN employee_attendance ea
	//              ON ea.ivms_id = u.ivms_id
	//              AND ea.Attendance_date BETWEEN ? AND ?
	//          WHERE ea.type = 'I'
	//            AND u.active = 0)
	//         ORDER BY Attendance_date DESC
	//     ";
	// 		$params = [$from, $to, $from, $to];
	// 	}

	// 	$query = $this->db->query($sql, $params);
	// 	return $query->result();
	// }
	function get_emp_attendance_list_filter()
	{
		$from = date('Y-m-d', strtotime($this->input->post('from')));
		$to = date('Y-m-d', strtotime($this->input->post('to')));
		$user_id = $this->input->post('user_id');
		$attendance_type = $this->input->post('attendance_type');

		// CASE 1: both user_id & attendance_type
		if (!empty($user_id) && !empty($attendance_type)) {

			if ($attendance_type == 'I') {

				$sql = "
                SELECT ea.*,  u.employee_id, u.employee_name AS name, NULL AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type = 'I'
                WHERE u.employee_id = ?
                  AND u.status = 'Active'
                ORDER BY ea.Attendance_date DESC
            ";
				$params = [$from, $to, $user_id];
			} else {

				$sql = "
                SELECT ea.*,  u.employee_id, u.employee_name AS name, cr.employee_name AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON ea.employee_id = u.employee_id
                    AND ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type = ?
                LEFT JOIN employees cr
                    ON cr.employee_id = ea.created_by
                WHERE u.employee_id = ?
                  AND u.status = 'Active'
                ORDER BY ea.Attendance_date DESC
            ";
				$params = [$from, $to, $attendance_type, $user_id];
			}
		}

		// CASE 2: Only user_id
		elseif (!empty($user_id)) {

			$sql = "
            (
                SELECT ea.*,  u.employee_id, u.employee_name AS name, cr.employee_name AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON ea.employee_id = u.employee_id
                    AND ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type != 'I'
                LEFT JOIN employees cr
                    ON cr.employee_id = ea.created_by
                WHERE u.employee_id = ?
                  AND u.status = 'Active'
            )
            UNION ALL
            (
                SELECT ea.*,  u.employee_id, u.employee_name AS name, NULL AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type = 'I'
                WHERE u.employee_id = ?
                  AND u.status = 'Active'
            )
            ORDER BY Attendance_date DESC
        ";

			$params = [$from, $to, $user_id, $from, $to, $user_id];
		}

		// CASE 3: only attendance_type
		elseif (!empty($attendance_type)) {

			if ($attendance_type == 'I') {

				$sql = "
                SELECT ea.*,  u.employee_id, u.employee_name AS name, NULL AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON  ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type = 'I'
                WHERE u.status = 'Active'
                ORDER BY ea.Attendance_date DESC
            ";
				$params = [$from, $to];
			} else {

				$sql = "
                SELECT ea.*, u.employee_code, u.employee_id, u.employee_name AS name, cr.employee_name AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON ea.employee_id = u.employee_id
                    AND ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type = ?
                LEFT JOIN employees cr
                    ON cr.employee_id = ea.created_by
                WHERE u.status = 'Active'
                ORDER BY ea.Attendance_date DESC
            ";
				$params = [$from, $to, $attendance_type];
			}
		}

		// CASE 4: no filters
		else {

			$sql = "
            (
                SELECT ea.*, u.employee_code, u.employee_id, u.employee_name AS name, cr.employee_name AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON ea.employee_id = u.employee_id
                    AND ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type != 'I'
                LEFT JOIN employees cr
                    ON cr.employee_id = ea.created_by
                WHERE u.status = 'Active'
            )
            UNION ALL
            (
                SELECT ea.*, u.employee_code, u.employee_id, u.employee_name AS name, NULL AS created_by_user
                FROM employees u
                LEFT JOIN employee_attendance ea
                    ON ea.Attendance_date BETWEEN ? AND ?
                    AND ea.type = 'I'
                WHERE u.status = 'Active'
            )
            ORDER BY Attendance_date DESC
        ";

			$params = [$from, $to, $from, $to];
		}

		return $this->db->query($sql, $params)->result();
	}

	// function get_emp_attendance_list_filter()
	// {
	// 	$from = date('Y-m-d', strtotime($this->input->post('from')));
	// 	$to = date('Y-m-d', strtotime($this->input->post('to')));
	// 	$user_id = $this->input->post('user_id');
	// 	$attendance_type = $this->input->post('attendance_type');

	// 	// ✅ Case 1: Specific User Filter Applied
	// 	if (!empty($user_id)) {

	// 		if ($attendance_type == 'I') {
	// 			// For IVMS (Biometric)
	// 			$sql = "
	//             SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//             FROM users u
	//             LEFT JOIN employee_attendance ea
	//                 ON ea.ivms_id = u.ivms_id
	//                 AND ea.Attendance_date BETWEEN ? AND ?
	//             WHERE ea.employee_id = ?
	//               AND ea.type = 'I'
	//               AND u.active = 0
	//             ORDER BY ea.Attendance_date DESC
	//         ";
	// 			$params = [$from, $to, $user_id];
	// 		} elseif (!empty($attendance_type)) {
	// 			// For Manual or Onsite (type = O / M)
	// 			$sql = "
	//             SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//             FROM users u
	//             LEFT JOIN employee_attendance ea
	//                 ON ea.employee_id = u.user_id
	//                 AND ea.Attendance_date BETWEEN ? AND ?
	//             WHERE ea.employee_id = ?
	//               AND ea.type = ?
	//               AND u.active = 0
	//             ORDER BY ea.Attendance_date DESC
	//         ";
	// 			$params = [$from, $to, $user_id, $attendance_type];
	// 		} else {
	// 			// No specific type selected → fetch all for that user
	// 			$sql = "
	//             SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//             FROM users u
	//             LEFT JOIN employee_attendance ea
	//                 ON ea.employee_id = u.user_id
	//                 AND ea.Attendance_date BETWEEN ? AND ?
	//             WHERE ea.employee_id = ?
	//               AND u.active = 0
	//             ORDER BY ea.Attendance_date DESC
	//         ";
	// 			$params = [$from, $to, $user_id];
	// 		}

	// 		$query = $this->db->query($sql, $params);
	// 	} else {
	// 		// ✅ Case 2: All Users (no user filter)
	// 		$sql = "
	//         (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//          FROM users u
	//          LEFT JOIN employee_attendance ea
	//             ON ea.employee_id = u.user_id
	//             AND ea.Attendance_date BETWEEN ? AND ?
	//          WHERE ea.type != 'I'
	//            AND u.active = 0)
	//         UNION ALL
	//         (SELECT ea.*, u.user_code, u.user_id, u.user_name AS name
	//          FROM users u
	//          LEFT JOIN employee_attendance ea
	//             ON ea.ivms_id = u.ivms_id
	//             AND ea.Attendance_date BETWEEN ? AND ?
	//          WHERE ea.type = 'I'
	//            AND u.active = 0)
	//         ORDER BY Attendance_date DESC
	//     ";
	// 		$query = $this->db->query($sql, [$from, $to, $from, $to]);
	// 	}

	// 	return $query->result();
	// }


	// function get_emp_attendance_by_id($id)
	// {
	// 	$query = $this->db->query("SELECT a.*, u.*,a.remark as rem
	// 							   FROM employee_attendance AS a
	// 							   INNER JOIN users AS u ON a.employee_id = u.user_id
	// 							   WHERE emp_aId = '$id'
	// 							   ORDER BY a.Attendance_date DESC");

	// 	return $query->result();
	// }

	function get_emp_attendance_by_id($id)
	{
		$sql = "
(
    SELECT 
        ea.*,  
        u.id, 
        u.username AS name, 
        ea.remark AS rem
    FROM users u 
    LEFT JOIN employee_attendance ea 
        ON ea.employee_id = u.id 
    WHERE ea.emp_aId = ? 
        AND ea.type != 'I'
)

UNION ALL

(
    SELECT 
        ea.*,  
        u.id, 
        u.username AS name, 
        ea.remark AS rem
    FROM users u 
    LEFT JOIN employee_attendance ea 
        ON ea.employee_id = u.id   -- fixed here
    WHERE ea.emp_aId = ? 
        AND ea.type = 'I'
)

ORDER BY Attendance_date DESC
";
		$query = $this->db->query($sql, [$id, $id]);
		return $query->result();
	}



	function delete_attendance_emp($id)
	{
		$this->db->where('emp_aId', $id);
		$this->db->delete('employee_attendance');
	}



	// function get_emp_attendance()
	// {
	// 	$a_date = date('Y-m-d', strtotime($this->input->post('a_date')));
	// 	$Attendance_date = date('Y-m-d', strtotime($this->input->post('Attendance_date')));

	// 	$query = $this->db->query("SELECT * FROM users WHERE user_id NOT IN (SELECT employee_id FROM employee_attendance WHERE Attendance_date = '$a_date')ORDER BY created_date ASC");

	// 	return $query->result();
	// }

	// function get_emp_attendance()
	// {
	// 	$a_date = date('Y-m-d', strtotime($this->input->post('a_date')));
	// 	$Attendance_date = date('Y-m-d', strtotime($this->input->post('Attendance_date')));

	// 	// $query = $this->db->query("SELECT * FROM users WHERE user_id NOT IN (SELECT employee_id FROM employee_attendance WHERE Attendance_date = '$a_date' and Attendance_date != NULL )ORDER BY created_date ASC");
	// 	$query = $this->db->query("SELECT user_id,user_name,user_code FROM users WHERE user_id NOT IN ( SELECT employee_id FROM employee_attendance WHERE Attendance_date = '$a_date' AND type != 'I' AND employee_id IS NOT NULL ) AND user_id NOT IN ( SELECT u.user_id FROM employee_attendance ea LEFT JOIN users u ON ea.ivms_id = u.ivms_id WHERE ea.Attendance_date = '$a_date' AND ea.type = 'I' AND u.user_id IS NOT NULL ) ORDER BY created_date ASC");
	// 	return $query->result();
	// }

	function get_emp_attendance()
	{
		$a_date_input = $this->input->post('a_date');

		if (!empty($a_date_input)) {
			$a_date = date('Y-m-d', strtotime($a_date_input));
		} else {
			$a_date = date('Y-m-d'); // default to today
		}

		// $sql = "
		//     SELECT u.id, u.username
		//     FROM users u
		//     WHERE u.status = 'Active'
		//     AND u.id NOT IN (
		//         SELECT ea.employee_id
		//         FROM employee_attendance ea
		//         WHERE ea.Attendance_date = ?
		//         AND ea.employee_id IS NOT NULL
		//     )
		//     ORDER BY u.username ASC
		// ";
		$sql = "
    SELECT e.employee_id, e.employee_name
    FROM employees e
    WHERE e.status = 'Active'
    AND e.employee_id NOT IN (
        SELECT ea.employee_id
        FROM employee_attendance ea
        WHERE ea.Attendance_date = ?
        AND ea.employee_id IS NOT NULL
    )
    ORDER BY e.employee_name ASC
";

		$query = $this->db->query($sql, [$a_date]);
		return $query->result();
	}






	function add_emp_attendance_data_copy()
	{
		$attendance = $this->input->post('attendance');

		$data = array(
			'employee_id' => $this->input->post('employee_id'),
			'Attendance_date' => date('Y-m-d', strtotime($this->input->post('Attendance_date'))),
			'attendence' => $attendance,
			'remark' => $this->input->post('remark'),
			'present' => $this->input->post('present'),
			'absent' => $this->input->post('absent')

		);

		// Check if attendance is present, then add in_time and out_time
		if ($attendance === 'present') {
			$data['in_time'] = $this->input->post('in_time');
			$data['out_time'] = $this->input->post('out_time');
		}

		// Check if a record with the same attendance date and employee ID already exists
		$this->db->where('employee_id', $data['employee_id']);
		$this->db->where('Attendance_date', $data['Attendance_date']);
		$query = $this->db->get('employee_attendance');

		if ($query->num_rows() > 0) {
			// Record already exists, display flash message
			$this->session->set_flashdata('error', 'Employee Attendance record already exists.');
			return false;
		} else {
			// Record does not exist, insert into the database
			$this->db->insert('employee_attendance', $data);
			$insert_id = $this->db->insert_id();

			if ($insert_id) {
				$user_se_id = $this->session->userdata('user_id');
				$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
				$ci = get_instance();
				$ci->load->helper('log');
				$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_attendance', 'emp_aId', $insert_id);
			}
			return $insert_id;
		}
	}


	////////////////////////////start vehicle details/////////////////////////////////////////////////


	public function add_vehicle_details()
	{
		$vehicle_name = $this->input->post('vehicle_name');

		// Check if vehicle name already exists
		$exists = $this->db->get_where('vehicle_details', ['vehicle_name' => $vehicle_name])->row();
		if ($exists) {
			return false; // Vehicle name exists, controller will show warning
		}

		$other_file = '';
		if (!empty($_FILES["file_doc"]["name"])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["file_doc"]["name"];
			$temp = explode(".", $fname);
			$extension = strtolower(end($temp));

			if (in_array($extension, $allowedExts) && $_FILES["file_doc"]["size"] < 52428800) {
				if ($_FILES["file_doc"]["error"] == 0) {
					$timestamp1 = time();
					$file_tmp = $_FILES["file_doc"]["tmp_name"];
					$other_file = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);
				} else {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					return false;
				}
			}
		}

		$data = array(
			'vehicle_name'      => $vehicle_name,
			'traffic_no'        => $this->input->post('vehicle_no'),
			'license_expdate'   => date('Y-m-d', strtotime($this->input->post('vl_exp'))),
			'exp_reminder'      => $this->input->post('exp_reminder'),
			'insurance_no'      => $this->input->post('insurance_no'),
			'insurance_date'    => date('Y-m-d', strtotime($this->input->post('insurance_date'))),
			'employee_id'       => $this->input->post('driver_name'),
			'insurance_expdate' => date('Y-m-d', strtotime($this->input->post('insurance_expdate'))),
			'driver_name'       => $this->input->post('driver_name'),

			'vehicle_type'      => $this->input->post('vehicle_type'),
			'remark'            => $this->input->post('remark'),
			'document'          => $other_file,
			'created_by'        => $this->session->userdata('user_id'),
			'created_date'      => date('Y-m-d'),
		);

		$this->db->insert('vehicle_details', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			// Add logs and notifications as before
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			add_log_entry($user_se_id, 1, $page_name[1], 'vehicle_details', 'v_id', $insert_id);

			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) $relative_path = str_replace('index.php/', '', $relative_path);
			$segments = explode('/', $relative_path);
			$current_url = isset($segments[0], $segments[1]) ? $segments[0] . '/' . $segments[1] : '';
			add_notification_in_master($insert_id, $current_url, "Add New Vehicle", "Hr/edit_vehicles/$insert_id");
		}

		return $insert_id;
	}



	function update_vehicle_details($id)
	{
		// Check if file is uploaded
		if (!empty($_FILES["file_doc"]["name"])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["file_doc"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$other_file = '';

			// Validate file size and extension
			if ($_FILES["file_doc"]["size"] < 52428800 && in_array(strtolower($extension), $allowedExts)) {
				if ($_FILES["file_doc"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					return false; // Exit function on upload error
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["file_doc"]["tmp_name"];
					$other_file = $timestamp1 . "_" . $fname;
					$upload_path = "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file;

					// Move uploaded file to destination directory
					if (!move_uploaded_file($file_tmp, $upload_path)) {
						$this->session->set_flashdata('error', 'Failed to move uploaded file');
						return false;
					}
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid file format or exceeds file size limit');
				return false;
			}
		}

		// Prepare data for database update
		$data = array(
			'vehicle_name' => $this->input->post('vehicle_name'),
			'traffic_no' => $this->input->post('vehicle_no'),
			'license_expdate' => date('Y-m-d', strtotime($this->input->post('vl_exp'))),
			'exp_reminder' => $this->input->post('exp_reminder'),
			'remark' => $this->input->post('remark'),
			'insurance_no' => $this->input->post('insurance_no'),
			'insurance_date' => date('Y-m-d', strtotime($this->input->post('insurance_date'))),
			'insurance_expdate' => date('Y-m-d', strtotime($this->input->post('insurance_expdate'))),
			'driver_name' => $this->input->post('driver_name'),
			'vehicle_type' => $this->input->post('vehicle_type'),
			'created_date' => date('Y-m-d'),

		);

		// Add document field to data if uploaded
		if (!empty($other_file)) {
			$data['document'] = $other_file;
		}

		// Perform database update
		$this->db->where('v_id', $id);
		$res = $this->db->update('vehicle_details', $data);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'vehicle_details', 'v_id', $id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Updated Vehicle Details", "Hr/edit_vehicles/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

			return true;
		} else {
			// Handle the case where the update operation fails
			$this->session->set_flashdata('error', 'Failed to update vehicle details');
			return false;
		}
	}


	function get_vehicle_list()
	{
		$query = $this->db->query("SELECT * FROM vehicle_details ORDER BY created_date DESC");
		return $query->result();
	}



	function get_vehicle_details_by_id($id)
	{
		$query = $this->db->query("select * from vehicle_details where v_id = '$id'  order by license_expdate desc ");
		return $query->result();
	}

	function delete_vehicle_data($id)
	{
		$this->db->where('v_id', $id);
		$this->db->delete('vehicle_details');
	}

	////////////////////start corporate file models///////////////////////////////////////////////////

	function add_corporate_file_data()
	{
		$data = array(
			'document_name' => $this->input->post('doc_name'),
			'card_no' => $this->input->post('card_no'),
			'expiry_date' => date('Y-m-d', strtotime($this->input->post('exp_date'))),
			'remark' => $this->input->post('remark'),
			'created_by' => $this->session->userdata('user_id'),
		);
		$this->db->insert('corporate_file', $data);
		$insert_id = $this->db->insert_id();

		/////////////////// file upload ////////////////////
		if ($insert_id) {
			if ($_FILES["documents"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				for ($i = 0; $i < count($_FILES['documents']["name"]); $i++) {
					if ($_FILES['documents']["name"][$i] != '') {
						$data['file_name'] = $_FILES["documents"]["name"][$i];

						$fname = $_FILES["documents"]["name"][$i];
						$temp = explode(".", $_FILES["documents"]["name"][$i]);
						$extension = end($temp);
						$other_file = '';
						if (($_FILES["documents"]["size"][$i] < 52428800) && in_array($extension, $allowedExts)) {
							if ($_FILES["documents"]["error"][$i] > 0) {
								$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
							} else {
								$timestamp1 = time();
								$file_tmp = $_FILES["documents"]["tmp_name"][$i];
								$other_file = $timestamp1 . "_" . $_FILES['documents']['name'][$i];
								move_uploaded_file($file_tmp, "uploads/corporatefiles/" . $other_file);
								$data1 = array(
									'cop_id' => $insert_id,
									'employee_id' => $this->session->userdata('user_id'),
									'document_path' => $other_file,
								);
								$this->db->insert('employee_corporate_documents', $data1);
							}
						}
					}
				}
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'corporate_file', 'cop_id', $insert_id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			// $notice = add_notification_in_master($insert_id, $current_url, "New Corporate File Created ", "Hr/edit_corporate_file/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

		}
		return $insert_id;
	}

	public function update_corporate_file_data($id)
	{
		/* ===============================
       1. UPDATE MAIN CORPORATE FILE
    =============================== */
		$data = array(
			'document_name' => $this->input->post('doc_name'),
			'card_no'       => $this->input->post('card_no'),
			'expiry_date'   => date('Y-m-d', strtotime($this->input->post('exp_date'))),
			'remark'        => $this->input->post('remark'),
		);

		$this->db->where('cop_id', $id);
		$res = $this->db->update('corporate_file', $data);


		/* ===============================
       2. DELETE REMOVED FILES
    =============================== */
		$existing_ids = $this->input->post('existing_files'); // remaining files from UI

		if (!empty($existing_ids)) {

			$this->db->where('cop_id', $id);
			$this->db->where_not_in('doc_id', $existing_ids);
			$files_to_delete = $this->db->get('employee_corporate_documents')->result();

			// delete physical files
			foreach ($files_to_delete as $f) {
				$path = "uploads/corporatefiles/" . $f->document_path;
				if (file_exists($path)) {
					unlink($path);
				}
			}

			// delete from DB
			$this->db->where('cop_id', $id);
			$this->db->where_not_in('doc_id', $existing_ids);
			$this->db->delete('employee_corporate_documents');
		} else {
			// if all files removed
			$files = $this->db->get_where('employee_corporate_documents', ['cop_id' => $id])->result();

			foreach ($files as $f) {
				$path = "uploads/corporatefiles/" . $f->document_path;
				if (file_exists($path)) {
					unlink($path);
				}
			}

			$this->db->delete('employee_corporate_documents', ['cop_id' => $id]);
		}


		/* ===============================
       3. UPLOAD NEW FILES
    =============================== */
		if (!empty($_FILES['documents']['name'][0])) {

			$allowedExts = array("jpeg", "jpg", "png", "doc", "docx", "pdf");

			for ($i = 0; $i < count($_FILES['documents']['name']); $i++) {

				if ($_FILES['documents']['name'][$i] != '') {

					$file_name = $_FILES["documents"]["name"][$i];
					$file_tmp  = $_FILES["documents"]["tmp_name"][$i];
					$file_size = $_FILES["documents"]["size"][$i];

					$temp      = explode(".", $file_name);
					$extension = strtolower(end($temp));

					if ($file_size < 52428800 && in_array($extension, $allowedExts)) {

						if ($_FILES["documents"]["error"][$i] == 0) {

							// unique file name
							$new_file = time() . "_" . uniqid() . "." . $extension;

							// FIXED PATH (important)
							$upload_path = "uploads/corporatefiles/" . $new_file;

							if (move_uploaded_file($file_tmp, $upload_path)) {

								$insert_data = array(
									'cop_id'        => $id,
									'employee_id'   => $this->session->userdata('user_id'),
									'document_path' => $new_file,
								);

								$this->db->insert('employee_corporate_documents', $insert_data);
							}
						}
					}
				}
			}
		}


		/* ===============================
       4. LOG + RESPONSE
    =============================== */
		if ($res) {

			// Log
			$user_se_id = $this->session->userdata('user_id');
			$page_name  = explode('index.php/', $_SERVER['PHP_SELF']);

			$ci = get_instance();
			$ci->load->helper('log');
			add_log_entry($user_se_id, 2, $page_name[1], 'corporate_file', 'cop_id', $id);

			return true;
		} else {
			return false;
		}
	}

	function update_corporate_file_data111($id)
	{
		$data = array(
			'document_name' => $this->input->post('doc_name'),
			'card_no' => $this->input->post('card_no'),
			'expiry_date' => date('Y-m-d', strtotime($this->input->post('exp_date'))),
			'remark' => $this->input->post('remark'),
		);
		$this->db->where('cop_id', $id);
		$res = $this->db->update('corporate_file', $data);

		/////////////////// file upload ////////////////////
		if ($id) {
			if ($_FILES["documents"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				for ($i = 0; $i < count($_FILES['documents']["name"]); $i++) {
					if ($_FILES['documents']["name"][$i] != '') {
						$data['file_name'] = $_FILES["documents"]["name"][$i];

						$fname = $_FILES["documents"]["name"][$i];
						$temp = explode(".", $_FILES["documents"]["name"][$i]);
						$extension = end($temp);
						$other_file = '';
						if (($_FILES["documents"]["size"][$i] < 52428800) && in_array($extension, $allowedExts)) {
							if ($_FILES["documents"]["error"][$i] > 0) {
								$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
							} else {
								$timestamp1 = time();
								$file_tmp = $_FILES["documents"]["tmp_name"][$i];
								$other_file = $timestamp1 . "_" . $_FILES['documents']['name'][$i];
								move_uploaded_file($file_tmp, "uploads/corporatefiles" . $other_file);
								$data1 = array(
									'cop_id' => $id,
									'employee_id' => $this->session->userdata('user_id'),
									'document_path' => $other_file,
								);
								$this->db->insert('employee_corporate_documents', $data1);
							}
						}
					}
				}
			}
		}



		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'corporate_file', 'cop_id', $id);


			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			// $notice = add_notification_in_master($id, $current_url, "Corporate File Updated ", "Hr/edit_corporate_file/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////


			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	function get_corporate_file_list()
	{
		$query = $this->db->query("select * from corporate_file order by expiry_date desc");
		return $query->result();
	}

	function get_corporate_file_id($id)
	{
		$query = $this->db->query("select * from corporate_file where cop_id ='$id' order by expiry_date");
		return $query->result();
	}


	function get_employee_corporate_doc_id($id)
	{
		$query = $this->db->query("select  * from employee_corporate_documents  where cop_id='$id' ");
		return $query->result();
	}

	function delete_corporate_file_data($id)
	{
		$this->db->where('cop_id', $id);
		$this->db->delete('corporate_file');

		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 3, $page_name[1], 'corporate_file', 'cop_id', $id);
	}

	//////////////////////salary structure start///////////////////////////////////////////////////////
	function add_salary_structure()
	{

		$salary_structure_data = array(
			'emp_id' => $this->input->post('employee_id'),
			'effective_date' => date('Y-m-d', strtotime($this->input->post('effctive_date'))),
			'basic_salary' => $this->input->post('bsalary'),
			'total_allowances' => $this->input->post('t_allowance'),
			'total_deductions' => $this->input->post('t_deduction'),
			'gross_salary' => $this->input->post('gross_salary'),
			'remark' => $this->input->post('remark'),
		);

		$this->db->insert('salary_structure', $salary_structure_data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			// Allowance details insertion
			if (isset($_POST['allowance_type'])) {
				for ($i = 0; $i < count($_POST['allowance_type']); $i++) {
					$allowance_data = array(
						'sid' => $insert_id,
						'allowance_id' => $_POST['allowance_type'][$i],
						'amount' => $_POST['a_amount'][$i],
					);
					$this->db->insert('salary_structure_details', $allowance_data);
				}
			}

			// Deduction details insertion
			if (isset($_POST['deduction_type'])) {
				for ($i = 0; $i < count($_POST['deduction_type']); $i++) {
					$deduction_data = array(
						'sid' => $insert_id,
						'allowance_id' => $_POST['deduction_type'][$i],
						'amount' => $_POST['d_amount'][$i],
						'employee_id' => $this->input->post('employee_id'),
					);
					$this->db->insert('salary_structure_details', $deduction_data);
				}
			}

			// Logging
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'salary_structure', 'sid', $insert_id);

			return $insert_id;
		}

		return false; // Return false if insertion fails 
	}
	/////update data
	function update_salary_structure($id)
	{
		$old_date = date('Y-m-d', strtotime($this->input->post('old_date')));
		$new_date = date('Y-m-d', strtotime($this->input->post('effctive_date')));

		if ($old_date == $new_date) {
			$data = array(
				'emp_id' => $this->input->post('employee_id_hidden'),
				'effective_date' => date('Y-m-d', strtotime($this->input->post('old_date'))),
				'basic_salary' => $this->input->post('bsalary'),
				'total_allowances' => $this->input->post('t_allowance'),
				'total_deductions' => $this->input->post('t_deduction'),
				'gross_salary' => $this->input->post('gross_salary'),
				'remark' => $this->input->post('remark'),
			);

			$this->db->where('sid', $id);
			$res = $this->db->update('salary_structure', $data);

			if ($res) {
				$query = $this->db->query("delete from salary_structure_details where sid=$id ");
				// Allowance details insertion
				if (isset($_POST['allowance_type'])) {
					foreach ($_POST['allowance_type'] as $index => $allowance_type) {
						$allowance_data = array(
							'sid' => $id,
							'allowance_id' => $allowance_type,
							'amount' => $_POST['a_amount'][$index],
						);
						$this->db->where(array('sid' => $id, 'allowance_id' => $allowance_type));
						$this->db->insert('salary_structure_details', $allowance_data);
					}
				}

				// Deduction details insertion
				if (isset($_POST['deduction_type'])) {
					foreach ($_POST['deduction_type'] as $index => $deduction_type) {
						$deduction_data = array(
							'sid' => $id,
							'allowance_id' => $deduction_type,
							'amount' => $_POST['d_amount'][$index],
						);
						$this->db->where(array('sid' => $id, 'allowance_id' => $deduction_type));
						$this->db->insert('salary_structure_details', $deduction_data);
					}
				}

				// Logging
				$user_se_id = $this->session->userdata('user_id');
				$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
				$ci = get_instance();
				$ci->load->helper('log');
				$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'salary_structure', 'sid', $id);

				return true;
			} else {
				return false; // Handle the case where the update operation fails
			}
		} else {
			// Insert new record
			$salary_structure_data = array(
				'emp_id' => $this->input->post('employee_id_hidden'),
				'effective_date' => date('Y-m-d', strtotime($this->input->post('effctive_date'))),
				'basic_salary' => $this->input->post('bsalary'),
				'total_allowances' => $this->input->post('t_allowance'),
				'total_deductions' => $this->input->post('t_deduction'),
				'gross_salary' => $this->input->post('gross_salary'),
				'remark' => $this->input->post('remark'),
			);

			$this->db->insert('salary_structure', $salary_structure_data);
			$insert_id = $this->db->insert_id();

			if ($insert_id) {
				// Allowance details insertion
				if (isset($_POST['allowance_type'])) {
					foreach ($_POST['allowance_type'] as $index => $allowance_type) {
						$allowance_data = array(
							'sid' => $insert_id,
							'allowance_id' => $allowance_type,
							'amount' => $_POST['a_amount'][$index],
						);
						$this->db->insert('salary_structure_details', $allowance_data);
					}
				}

				// Deduction details insertion
				if (isset($_POST['deduction_type'])) {
					foreach ($_POST['deduction_type'] as $index => $deduction_type) {
						$deduction_data = array(
							'sid' => $insert_id,
							'allowance_id' => $deduction_type,
							'amount' => $_POST['d_amount'][$index],
						);
						$this->db->insert('salary_structure_details', $deduction_data);
					}
				}

				// Logging
				$user_se_id = $this->session->userdata('user_id');
				$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
				$ci = get_instance();
				$ci->load->helper('log');
				$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'salary_structure', 'sid', $insert_id);

				return $insert_id;
			}

			return false; // Return false if insertion fails  
		}
	}



	function get_salary_structure_list()
	{
		// $query = $this->db->query("select  j.*, u.username as name from salary_structure j, users u where j.emp_id=u.id  order by effective_date desc ");
		$query = $this->db->query("
    SELECT j.*, e.employee_name AS name
    FROM salary_structure j
    JOIN employees e ON j.emp_id = e.employee_id
    ORDER BY j.effective_date DESC
");
		return $query->result();
	}

	function get_salary_allowance_details($id)
	{
		$query = $this->db->query("SELECT d.*, a.* FROM salary_structure_details d JOIN allowance_master a ON d.allowance_id = a.sno WHERE d.sid = $id");
		return $query->result();
	}


	function get_active_basic_salary12()
	{
		$query = $this->db->query("
		    SELECT *, id
		    FROM users
		    WHERE id NOT IN (
		        SELECT emp_id
		        FROM salary_structure
		    )
		    ORDER BY username
		");
		return $query->result();
	}
	function get_active_basic_salary()
	{
		$query = $this->db->query("
        SELECT *
        FROM employees
        WHERE employee_id NOT IN (
            SELECT emp_id
            FROM salary_structure
        )
        ORDER BY employee_name
    ");

		return $query->result();
	}

	function get_salary_structure_by_id($id)
	{
		$query = $this->db->query("SELECT j.*, u.username AS name  ,j.remark As rem
									FROM salary_structure j
									JOIN users u ON j.emp_id = u.id
									WHERE j.sid = $id 
									ORDER BY j.effective_date DESC");
		return $query->result();
	}

	function delete_salary_structure($id)
	{
		// Delete record from the 'salary_structur_details' table
		$this->db->where('sid', $id);
		$this->db->delete('salary_structure_details');

		// Delete record from the 'salary_structure' table
		$this->db->where('sid', $id);
		$this->db->delete('salary_structure');
	}

	////////////////////////////monthly salary////////employee_overtime
	// function get_salary_monthly_by_id($id)

	// {

	// 	$query = $this->db->query("SELECT overtime, date_ot FROM employee_overtime WHERE employee_id = '$id'");
	// 	$result1 = $query->result();
	// 	$totalhour = 0; // Initialize the count

	// 	foreach ($result1 as $row) {

	// 		$totalhour = $totalhour + $row->overtime;
	// 	}
	// 	$query = $this->db->query("SELECT attendence, Attendance_date FROM employee_attendance WHERE employee_id = '$id'");
	// 	$result = $query->result();

	// 	$count = 0; // Initialize the count

	// 	foreach ($result as $row) {
	// 		if ($row->attendence == "present") {
	// 			$count++;
	// 		}
	// 	}
	// 	$query = $this->db->query("SELECT j.*, u.user_name AS name, j.remark AS rem,o.overtime,a.attendence
	//                             FROM salary_structure j
	//                             JOIN users u ON j.emp_id = u.user_id
	//                             LEFT JOIN employee_overtime o ON u.user_id = o.employee_id
	//                             LEFT JOIN employee_attendance a ON u.user_id = a.employee_id
	//                             WHERE j.emp_id = $id 
	//                             ORDER BY j.effective_date DESC 
	//                             ");
	// 	return $query->result();
	// }

	// 	$data['from'] = date('Y-m-d', strtotime($this->input->post('from')));
	// 	$data['to'] = date('Y-m-d', strtotime($this->input->post('to')));
	// 	$cid = $this->input->post('customer_id');
	// 	if ($cid == '')
	// 		  $condition = "";
	// 	else
	// 		  $condition = "and cust_id=$cid";

	// 	$query = $this->db->query("SELECT enquiry_id,enquiry_code,enq_type,enq_date,customer_id,cust_name,client_ref,enq_source FROM enquiry_master e JOIN
	// customer_master c ON e.cust_id = c.customer_id WHERE enq_date BETWEEN '{$data['from']}' AND '{$data['to']}'  $condition ORDER BY enq_date");
	// 	return $query->result();


	function get_salary_structure_data()
	{
		$effective_date = $this->input->post('effective_date');
		$selected_month_year = date('Y-m', strtotime($effective_date));
		$id = $this->input->post('user_id');

		// Additional conditions based on the selected month and year
		$start_date = date('Y-m-01', strtotime($selected_month_year));
		$end_date = date('Y-m-t', strtotime($selected_month_year));
		$days_in_month = date('t', strtotime($selected_month_year));

		$query = $this->db->query("select * from salary_structure where effective_date<='$end_date' order by $end_date desc limit 1");
		return $query->result();
	}
	function get_salary_structure_details($id)
	{
		$query = $this->db->query("select * from salary_structure_details s, allowance_master am where s.allowance_id=am.sno and  s.sid='$id' ");
		return $query->result();
	}

	function get_attendance_details()
	{
		$effective_date = $this->input->post('effective_date');
		$selected_month_year = date('Y-m', strtotime($effective_date));
		$id = $this->input->post('user_id');

		// Additional conditions based on the selected month and year
		$start_date = date('Y-m-01', strtotime($selected_month_year));
		$end_date = date('Y-m-t', strtotime($selected_month_year));
		$days_in_month = date('t', strtotime($selected_month_year));

		//$query = $this->db->query("select count(*)as absentdays from employee_attendance where employee_id = $id and Attendance_date BETWEEN '$start_date' AND '$end_date' and attendence='absent' ");
		$query = $this->db->query("SELECT COUNT(*) AS absentdays 
		FROM employee_attendance 
		WHERE employee_id = ? 
		AND Attendance_date BETWEEN ? AND ? 
		AND attendence = 'absent'", [$id, $start_date, $end_date]);
		return $query->row('absentdays');
	}

	function add_basic_enquiry()
	{
		$basic_enq_data = array(
			'enquiry_id' => '1',
			'budget' => $this->input->post('budget'),
			'privious_spend' => $this->input->post('privious_spend'),
			'buildup_days' => $this->input->post('build_days'),
			'height_restriction' => $this->input->post('height_restriction'),
			'standno' => $this->input->post('stand_no'),
			'hallno' => $this->input->post('hall_no'),
			'plaform_size' => $this->input->post('plaform_size'),
			'side_open' => $this->input->post('side_open'),
			'mezzanine_size' => $this->input->post('mezzanine_size'),
			'Dimensions' => $this->input->post('dimensions'),
			'decker' => $this->input->post('decker'),
			'floorplan' => $this->input->post('floorplan_attached'),
			'other_considerations' => $this->input->post('consideration'),
			'brand_guidelines' => $this->input->post('guidline_attached'),
			'organizer' => $this->input->post('organizer'),
			'other_information' => $this->input->post('info_attached'),
		);

		$this->db->insert('basic_info_enq', $basic_enq_data); // Insert into basic_info_enq table
		$insert_id = $this->db->insert_id();

		if ($insert_id) {

			if (isset($_POST['bid'])) {
				for ($i = 0; $i < count($_POST['bid']); $i++) {
					$basic_info = array(
						'bid' => $_POST['bid'][$i],
						'details' => $_POST['details'][$i],
						'remark' => $_POST['remark'][$i],
					);
					$this->db->insert('basic_enquiry_master', $basic_info); // Insert into basic_enquiry_master table
				}
			}
			// Logging
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'basic_enquiry_master', 'bid', $insert_id);

			return $insert_id;
		}

		return false; // Return false if insertion fails 


	}







	///////////////////////////////employee corner modelleave///////////////

	// function get_employee_leave_corner_list()
	// {
	// 	$current_user_id = $this->session->userdata('user_id');
	// 	$query = $this->db->query("select  j.*, u.user_name as name from employee_leave j, users u where j.employee_id=u.user_id AND j.employee_id='$current_user_id' order by application_date desc ");
	// 	return $query->result();
	// }


	function get_employee_leave_corner_list()
	{
		$current_user_id = $this->session->userdata('user_id');

		$query = $this->db->query("
        SELECT 
            j.*, 
            u.user_name AS name,

            -- All leave_category table fields
            lc.leave_cat_id,
            lc.category_name,
            lc.leave_days,
            lc.remark,
            lc.created_at AS leave_cat_created_at,
            lc.created_by AS leave_cat_created_by

        FROM employee_leave j
        JOIN users u ON j.employee_id = u.user_id
        LEFT JOIN leave_category lc ON j.leave_type = lc.leave_cat_id
        WHERE j.employee_id = ?
        ORDER BY j.application_date DESC
    ", [$current_user_id]);

		return $query->result();
	}

	function get_employee_regignation_corner_list()
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select r.*, u.user_name as name from employee_resignation r, users u where r.employee_id=u.user_id AND r.employee_id='$current_user_id' order by resignation_date desc ");
		return $query->result();
	}

	function add_emp_monthly_salary1()
	{
		$data = array(
			'emp_id' => $this->input->post('empid'),
			'salary_month' => date('Y-m-01', strtotime($this->input->post('effective_date'))),
			'working_days' => $this->input->post('working_days'),
			'leave_days' => $this->input->post('leave_days'),
			'present_days' => $this->input->post('present_days'),
			'paid_leave' => $this->input->post('paid_leave'),
			'payment_days' => $this->input->post('payment_days'),
			'overtime' => $this->input->post('t_overtime'),
			'overtime_amt' => $this->input->post('amt_overtime'),
			'basic_salary' => $this->input->post('basic_salary'),
			'daily_basic' => $this->input->post('daily_basic'),
			'total_allowance' => $this->input->post('total_allowances'),
			'total_deduction' => $this->input->post('total_deduction'),
			'gross_salary' => $this->input->post('gross_salary'),
			'net_salary' => $this->input->post('net_pay'),
			'remark' => $this->input->post('remark'),
			'created_by' => $this->session->userdata('user_id'),
			'created_data' => date('Y-m-d'),
			'salary_advance_taken' => $this->input->post('advance_taken'),
		);
		$this->db->insert('employee_monthly_salary', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			if (isset($_POST['allowance_amt'])) {
				for ($i = 0; $i < count($_POST['allowance_amt']); $i++) {
					$allowance_data = array(
						'sid' => $insert_id,
						'allowance_id' => $_POST['allowance_id'][$i],
						'amount' => $_POST['allowance_amt'][$i],
					);
					$this->db->insert('employee_monthly_salary_details', $allowance_data);
				}
			}

			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_monthly_salary', 'sid', $insert_id);
		}
		return $insert_id;
	}



	function add_emp_monthly_salary13_4()
	{
		$checked_users = isset($_POST['checkbox']) ? $_POST['checkbox'] : array();

		// Check if the required form fields are available
		if (
			empty($_POST['nuser_id']) || empty($_POST['working_days']) || empty($_POST['leave_days']) ||
			empty($_POST['present_days']) || empty($_POST['usep_leave']) || empty($_POST['payment_days']) ||
			empty($_POST['basic_salary']) ||
			empty($_POST['total_allowances']) || empty($_POST['total_deduction']) || empty($_POST['gross_salary']) || empty($_POST['holiday_days']) ||
			empty($_POST['net_pay']) || empty($_POST['remark'])
		) {
			log_message("error", "exiting");
			return false; // Or handle the error accordingly
		}

		$insert_id = null; // Initialize variable

		foreach ($checked_users as $index => $nuser_id) {
			$user_index = array_search($nuser_id, $_POST['nuser_id']);

			$data = array(
				'emp_id' => $nuser_id,
				'salary_month' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
				'working_days' => $_POST['working_days'][$user_index],
				'leave_days' => $_POST['leave_days'][$user_index],
				'present_days' => $_POST['present_days'][$user_index],
				'paid_leave' => $_POST['usep_leave'][$user_index],
				'payment_days' => $_POST['payment_days'][$user_index],
				'company_holiday' => $_POST['holiday_days'][$user_index],
				// 'overtime' => $_POST['t_overtime'][$user_index],
				// 'overtime_amt' => $_POST['amt_overtime'][$user_index],
				'basic_salary' => $_POST['basic_salary'][$user_index],
				'total_allowance' => $_POST['total_allowances'][$user_index],
				'total_deduction' => $_POST['total_deduction'][$user_index],

				// 'extra_allowances' => $_POST['extra_allowances'][$user_index],
				// 'extra_deduction' => $_POST['extra_deduction'][$user_index],

				'gross_salary' => $_POST['gross_salary'][$user_index],
				'net_salary' => $_POST['net_pay'][$user_index],
				'remark' => $_POST['remark'][$user_index],
			);

			$this->db->insert('employee_monthly_salary', $data);
			$insert_id = $this->db->insert_id();

			$q = $this->db->query(" SELECT sd.* FROM salary_structure sm JOIN salary_structure_details sd ON sm.sid = sd.sid WHERE sm.emp_id = $nuser_id ");

			// Insert each allowance into monthly_salary_details
			foreach ($q->result() as $p) {
				$allowance_data = array(
					'sid' => $insert_id,
					'allowance_id' => $p->allowance_id,
					'amount' => $p->amount
				);
				$this->db->insert('employee_monthly_salary_details', $allowance_data);
			}
		}
		/////////////// account entry for po invoice cr to supplier & dr to company /////


		/// debit entry 
		for ($i = 0; $i < count($_POST['inv_debtor']); $i++) {
			$debtor = $_POST['inv_debtor'][$i];
			$dr_amount = $_POST['inv_dr_amount'][$i];
			if ($dr_amount > 0) {
				$data = array(
					// 'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
					'voucher_type' => 'MS',
					/// po invoice  entry
					// 'customer_id' => $this->input->post('supplier_id'),
					'account_id' => $debtor,
					'amount' => $dr_amount,
					'drcr_type' => 'Dr',
					'trans_id' => $insert_id,
					'trans_type' => 'MS',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$vid = $this->db->insert_id();
			}
		}
		//credit entry
		for ($i = 0; $i < count($_POST['inv_creditor']); $i++) {
			$creditor = $_POST['inv_creditor'][$i];
			$cr_amount = $_POST['inv_cr_amount'][$i];
			if ($cr_amount > 0) {
				$data = array(
					// 'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
					'voucher_type' => 'MS',
					/// po invoice  entry
					// 'customer_id' => $this->input->post('supplier_id'),
					'account_id' => $creditor,
					'amount' => $cr_amount,
					'drcr_type' => 'Cr',
					'trans_id' => $insert_id,
					'trans_type' => 'MS',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$vid = $this->db->insert_id();
			}
		}
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			add_log_entry($user_se_id, 1, $page_name[1], 'employee_monthly_salary', 'sid', $insert_id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////

			$effective_date = strtotime($this->input->post('effective_date_hidden'));

			$year = date('Y', $effective_date);      // e.g., 2025
			$month_name = date('F', $effective_date);

			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			// $notice = add_notification_in_master($insert_id, $current_url, "$month_name - $year Salary Generated", "Hr/view_emp_monthly_salary_list");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

		}

		return $insert_id;
	}

	public function add_emp_monthly_salaryold()
	{
		$checked_users = isset($_POST['checkbox']) ? $_POST['checkbox'] : array();
		$all_users     = $_POST['nuser_id'];

		// ✅ If none selected → take all
		$users_to_process = !empty($checked_users) ? $checked_users : $all_users;

		foreach ($users_to_process as $nuser_id) {

			$user_index = array_search($nuser_id, $all_users);

			// =============================
			// 1. INSERT SALARY
			// =============================
			$data = array(
				'emp_id' => $nuser_id,
				'salary_month' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
				'working_days' => $_POST['working_days'][$user_index],
				'leave_days' => $_POST['leave_days'][$user_index],
				'present_days' => $_POST['present_days'][$user_index],
				'paid_leave' => $_POST['usep_leave'][$user_index],
				'payment_days' => $_POST['payment_days'][$user_index],
				'company_holiday' => $_POST['holiday_days'][$user_index],
				'basic_salary' => $_POST['basic_salary'][$user_index],
				'total_allowance' => $_POST['total_allowances'][$user_index],
				'total_deduction' => $_POST['total_deduction'][$user_index],
				'gross_salary' => $_POST['gross_salary'][$user_index],
				'net_salary' => $_POST['net_pay'][$user_index],
				'remark' => $_POST['remark'][$user_index],
			);

			$this->db->insert('employee_monthly_salary', $data);
			$salary_id = $this->db->insert_id();

			// =============================
			// 2. INSERT SALARY DETAILS
			// =============================
			$q = $this->db->query("
            SELECT sd.* 
            FROM salary_structure sm 
            JOIN salary_structure_details sd ON sm.sid = sd.sid 
            WHERE sm.emp_id = $nuser_id
        ");

			foreach ($q->result() as $p) {
				$this->db->insert('employee_monthly_salary_details', [
					'sid' => $salary_id,
					'allowance_id' => $p->allowance_id,
					'amount' => $p->amount
				]);
			}

			// =============================
			// 3. ACCOUNTING ENTRY (PER EMPLOYEE)
			// =============================

			$net_salary = $_POST['net_pay'][$user_index];

			if ($net_salary > 0) {

				// 🔹 Debit (Salary Expense)
				$this->db->insert('voucher_transaction', [
					'voucher_date' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
					'voucher_type' => 'MS',
					'account_id' => $_POST['inv_debtor'][0], // Salary Expense
					'amount' => $net_salary,
					'drcr_type' => 'Dr',
					'trans_id' => $salary_id,
					'trans_type' => 'MS',
					'customer_id' => $nuser_id, // ✅ IMPORTANT
					'recordCreatedBy' => $this->session->userdata('user_id')
				]);

				// 🔹 Credit (Salary Payable)
				$this->db->insert('voucher_transaction', [
					'voucher_date' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
					'voucher_type' => 'MS',
					'account_id' => $_POST['inv_creditor'][0], // Salary Payable
					'amount' => $net_salary,
					'drcr_type' => 'Cr',
					'trans_id' => $salary_id,
					'trans_type' => 'MS',
					'customer_id' => $nuser_id, // ✅ IMPORTANT
					'recordCreatedBy' => $this->session->userdata('user_id')
				]);
			}
		}

		return true;
	}

	// =======================================================
	public function generate_salvoucher_code($prefix)
	{
		$year = date('y');
		$prefix_full = $prefix . '/' . $year . '/';

		$this->db->like('voucher_code', $prefix_full, 'after');
		$this->db->order_by('voucher_code', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('voucher_transaction');

		if ($query->num_rows() > 0) {
			$last_code = $query->row()->voucher_code;
			$last_no = (int) substr($last_code, -5);
			$next_no = $last_no + 1;
		} else {
			$next_no = 1;
		}

		return $prefix_full . str_pad($next_no, 5, '0', STR_PAD_LEFT);
	}



	public function add_emp_monthly_salary()
	{
		$this->db->trans_start();

		$checked_users = isset($_POST['checkbox']) ? $_POST['checkbox'] : [];
		$all_users     = $_POST['nuser_id'];

		$users_to_process = !empty($checked_users) ? $checked_users : $all_users;

		// ✅ Generate ONE voucher for batch
		$voucher_no = $this->generate_salvoucher_code('SAL');

		$salary_date = date('Y-m-01', strtotime($this->input->post('effective_date_hidden')));
		$user_id     = $this->session->userdata('user_id');

		foreach ($users_to_process as $nuser_id) {

			$user_index = array_search($nuser_id, $all_users);

			// =============================
			// 1. INSERT SALARY MASTER
			// =============================
			$data = [
				'emp_id'           => $nuser_id,
				'salary_month'     => $salary_date,
				'working_days'     => $_POST['working_days'][$user_index],
				'leave_days'       => $_POST['leave_days'][$user_index],
				'present_days'     => $_POST['present_days'][$user_index],
				'paid_leave'       => $_POST['usep_leave'][$user_index],
				'payment_days'     => $_POST['payment_days'][$user_index],
				'company_holiday'  => $_POST['holiday_days'][$user_index],
				'basic_salary'     => $_POST['basic_salary'][$user_index],
				'total_allowance'  => $_POST['total_allowances'][$user_index],
				'total_deduction'  => $_POST['total_deduction'][$user_index],
				'gross_salary'     => $_POST['gross_salary'][$user_index],
				'net_salary'       => $_POST['net_pay'][$user_index],
				'remark'           => $_POST['remark'][$user_index],
				'salary_advance_taken' =>  $_POST['advance_taken'][$user_index],
			];

			$this->db->insert('employee_monthly_salary', $data);
			$salary_id = $this->db->insert_id();

			// =============================
			// 2. INSERT SALARY DETAILS
			// =============================
			$q = $this->db->query("
            SELECT sd.* 
            FROM salary_structure sm 
            JOIN salary_structure_details sd ON sm.sid = sd.sid 
            WHERE sm.emp_id = $nuser_id
        ");

			foreach ($q->result() as $p) {
				$this->db->insert('employee_monthly_salary_details', [
					'sid'          => $salary_id,
					'allowance_id' => $p->allowance_id,
					'amount'       => $p->amount
				]);
			}
		}

		// ========================== Accounts Entry =========================

		/// debit entry 
		for ($i = 0; $i < count($_POST['inv_debtor']); $i++) {
			$debtor = $_POST['inv_debtor'][$i];
			$dr_amount = $_POST['inv_dr_amount'][$i];
			if ($dr_amount > 0) {
				$data = array(
					// 'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
					'voucher_type' => 'MS',
					/// po invoice  entry
					// 'customer_id' => $this->input->post('supplier_id'),
					'account_id' => $debtor,
					'amount' => $dr_amount,
					'drcr_type' => 'Dr',
					'trans_id' => $salary_id,
					'trans_type' => 'MS',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$vid = $this->db->insert_id();
			}
		}
		//credit entry
		for ($i = 0; $i < count($_POST['inv_creditor']); $i++) {
			$creditor = $_POST['inv_creditor'][$i];
			$cr_amount = $_POST['inv_cr_amount'][$i];
			if ($cr_amount > 0) {
				$data = array(
					// 'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-01', strtotime($this->input->post('effective_date_hidden'))),
					'voucher_type' => 'MS',
					/// po invoice  entry
					// 'customer_id' => $this->input->post('supplier_id'),
					'account_id' => $creditor,
					'amount' => $cr_amount,
					'drcr_type' => 'Cr',
					'trans_id' => $salary_id,
					'trans_type' => 'MS',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$vid = $this->db->insert_id();
			}
		}
		if ($salary_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			add_log_entry($user_se_id, 1, $page_name[1], 'employee_monthly_salary', 'sid', $salary_id);
		}
		// ==========================================


		$this->db->trans_complete();

		return $this->db->trans_status();
	}


	// ====================================================================


	function get_emp_monthly_salary()
	{
		// $query = $this->db->query("select * from employee_monthly_salary s, users u where s.emp_id=u.user_id order by salary_month  desc");
		$query = $this->db->query("select * from employee_monthly_salary s, employees u where s.emp_id=u.employee_id order by salary_month  desc");
		return $query->result();
	}



	function get_emp_monthly_salary_list($from)
	{
		$from_date = date('Y-m-01', strtotime($from));
		$to_date = date('Y-m-t', strtotime($from_date));

		$data['from'] = $from_date;
		$data['to'] = $to_date;

		// $query = $this->db->query("select one.*, two.account_id from (SELECT s.*, employee_id,u.employee_code, u.employee_name FROM employee_monthly_salary s, employees u WHERE s.emp_id = u.employee_id AND s.salary_month BETWEEN '{$data['from']}' AND '{$data['to']}'  ORDER BY s.salary_month DESC)as one left join(select * from general_ledger where group_no=38)as two on(one.employee_id=two.employee_id)");
		$query = $this->db->query("
			SELECT 
				one.*, 
				two.account_id 

			FROM
			(
				SELECT 
					s.*, 
					u.employee_id,
					u.employee_code, 
					u.employee_name 

				FROM employee_monthly_salary s

				LEFT JOIN employees u 
					ON s.emp_id = u.employee_id

				WHERE s.salary_month BETWEEN '{$data['from']}' AND '{$data['to']}'

				ORDER BY s.salary_month DESC

			) AS one

			LEFT JOIN general_ledger two 
				ON one.employee_id = two.employee_id
		");
		return $query->result();
	}


	function get_emp_monthly_salary_dataoldone()
	{
		// $effective_date_hidden = $this->input->post('effective_date_hidden');
		// $month_year = date('Y-m', strtotime($effective_date_hidden));
		$effective_date = $this->input->post('effective_date');
		$selected_month_year = date('Y-m', strtotime($effective_date));
		$id = $this->input->post('user_id');

		// Additional conditions based on the selected month and year
		$start_date = date('Y-m-01', strtotime($selected_month_year));
		$end_date = date('Y-m-t', strtotime($selected_month_year));

		$year = date('Y', strtotime($effective_date));
		$month = date('m', strtotime($effective_date));



		$query = $this->db->query("
							SELECT 
							one.*,
							one.total_deductions,
							two.username, 
							
							two.id,
							
							dept.department_name,
							
							doc_det.posession,

							COALESCE(six.paid_days, 0) AS paid_days, 
							COALESCE(six.use_paid_leave, 0) AS use_paid_leave,
							COALESCE(nine.totalp_leave, 0) AS totalp_leave,
							COALESCE(five.overtime, 0) AS total_overtime,
							COALESCE(eight.absent_count, 0) AS absent_count,
							COALESCE(five.attendance, 0) AS present_count,
							COALESCE(eleven.compoff_count, 0) AS compoff_count,
							COALESCE(ten.paid_leave_count, 0) AS paid_leave_count
						FROM 
							users AS two 
						LEFT JOIN 
							(SELECT emp_id, gross_salary, basic_salary, total_allowances, total_deductions, effective_date
							FROM salary_structure
							WHERE effective_date IN (
								SELECT MAX(effective_date)
								FROM salary_structure
								GROUP BY emp_id
							)) AS one 
							ON two.id = one.emp_id
						




							LEFT JOIN 
					(SELECT employee_id, sum(attendance) as attendance, sum(overtime) as overtime from (select id as employee_id, count(*) as attendance, sum(if (timestampdiff(minute,in_time,out_time)>600, timestampdiff(minute,in_time,out_time)-600,0)) as overtime from employee_attendance e, users u where  e.type='I' and Attendance_date between '$start_date' AND '$end_date' group by id UNION ALL select employee_id, count(*) as attendance, sum(if (timestampdiff(minute,in_time,out_time)>600, timestampdiff(minute,in_time,out_time)-600,0)) as overtime from employee_attendance where type!='I' and Attendance_date between '$start_date' AND '$end_date' group by employee_id) as total_attendance group by employee_id)as five ON two.id = five.employee_id

						LEFT JOIN 
							(SELECT employee_id, COUNT(attendence) AS absent_count 
							FROM employee_attendance 
							WHERE attendence = 'A' 
							AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
							GROUP BY employee_id) AS eight 
						ON two.id = eight.employee_id 




						LEFT JOIN 
							(SELECT employee_id, COUNT(use_paid_leave) AS paid_leave_count 
							FROM employee_attendance 
							WHERE use_paid_leave = 'PL' 
							AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
							GROUP BY employee_id) AS ten 
						ON two.id = ten.employee_id 
						LEFT JOIN 
							(SELECT employee_id, COUNT(use_paid_leave) AS compoff_count 
							FROM employee_attendance 
							WHERE use_paid_leave = 'CMP' 
							AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
							GROUP BY employee_id) AS eleven 
						ON two.id = eleven.employee_id 


						LEFT JOIN (
								SELECT 
									pm.emp_id, 
									SUM(pt.paid_days) AS paid_days , sum(pt.use_paid_leave) as use_paid_leave
								FROM paid_leave_master pm
								JOIN paid_leave_transaction pt 
									ON pm.paid_id = pt.paid_id_master
								WHERE YEAR(pm.p_date) = $year
								GROUP BY pm.emp_id
							) AS six
								ON two.id = six.emp_id


					LEFT JOIN 
								(SELECT emp_id, SUM(paid_leave) AS totalp_leave 
								FROM employee_monthly_salary 
								GROUP BY emp_id) AS nine 
								ON two.id = nine.emp_id 

					LEFT JOIN 
								(SELECT  department_name,department_id 
								FROM departments 
								group by department_id ) AS dept 
								ON two.department = dept.department_id  

					LEFT JOIN 
								(SELECT  posession,emp_id
								FROM employee_document_details where document_name='visa' 
								GROUP BY emp_id) AS doc_det 
								ON two.id = doc_det.emp_id 


						WHERE 
							two.status ='Active' AND two.id NOT IN (SELECT emp_id FROM employee_monthly_salary WHERE month(salary_month) = '$month' and year(salary_month) = '$year')
						ORDER BY 
							two.id ASC;
						
					");

		return $query->result();
	}

	function get_emp_monthly_salary_data13_4()
	{
		// $effective_date_hidden = $this->input->post('effective_date_hidden');
		// $month_year = date('Y-m', strtotime($effective_date_hidden));
		$effective_date = $this->input->post('effective_date');
		$selected_month_year = date('Y-m', strtotime($effective_date));
		$id = $this->input->post('user_id');

		// Additional conditions based on the selected month and year
		$start_date = date('Y-m-01', strtotime($selected_month_year));
		$end_date = date('Y-m-t', strtotime($selected_month_year));

		$year = date('Y', strtotime($effective_date));
		$month = date('m', strtotime($effective_date));



		$query = $this->db->query("
						SELECT 
							one.*,
							one.total_deductions,
							two.employee_name, 
							two.employee_id,
							two.employee_code,
							dept.department_name,
							doc_det.posession,

							COALESCE(six.paid_days, 0) AS paid_days, 
							COALESCE(six.use_paid_leave, 0) AS use_paid_leave,
							COALESCE(nine.totalp_leave, 0) AS totalp_leave,
							COALESCE(five.overtime, 0) AS total_overtime,
							COALESCE(eight.absent_count, 0) AS absent_count,
							COALESCE(five.attendance, 0) AS present_count,
							COALESCE(eleven.compoff_count, 0) AS compoff_count,
							COALESCE(ten.paid_leave_count, 0) AS paid_leave_count

						FROM employees AS two 

						LEFT JOIN 
							(SELECT emp_id, gross_salary, basic_salary, total_allowances, total_deductions, effective_date
							FROM salary_structure
							WHERE effective_date IN (
								SELECT MAX(effective_date)
								FROM salary_structure
								GROUP BY emp_id
							)) AS one 
						ON two.employee_id = one.emp_id


						LEFT JOIN 
						(
						SELECT employee_id, SUM(attendance) AS attendance, SUM(overtime) AS overtime 
						FROM 
						(
							SELECT employee_id, COUNT(*) AS attendance,
							SUM(IF (TIMESTAMPDIFF(MINUTE,in_time,out_time) > 600,
								TIMESTAMPDIFF(MINUTE,in_time,out_time) - 600,0)) AS overtime
							FROM employee_attendance
							WHERE type='I'
							AND Attendance_date BETWEEN '$start_date' AND '$end_date'
							GROUP BY employee_id

							UNION ALL

							SELECT employee_id, COUNT(*) AS attendance,
							SUM(IF (TIMESTAMPDIFF(MINUTE,in_time,out_time) > 600,
								TIMESTAMPDIFF(MINUTE,in_time,out_time) - 600,0)) AS overtime
							FROM employee_attendance
							WHERE type!='I'
							AND Attendance_date BETWEEN '$start_date' AND '$end_date'
							GROUP BY employee_id

						) AS total_attendance
						GROUP BY employee_id
						) AS five 
						ON two.employee_id = five.employee_id


						LEFT JOIN 
							(SELECT employee_id, COUNT(attendence) AS absent_count 
							FROM employee_attendance 
							WHERE attendence = 'A' 
							AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
							GROUP BY employee_id) AS eight 
						ON two.employee_id = eight.employee_id 


						LEFT JOIN 
							(SELECT employee_id, COUNT(use_paid_leave) AS paid_leave_count 
							FROM employee_attendance 
							WHERE use_paid_leave = 'PL' 
							AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
							GROUP BY employee_id) AS ten 
						ON two.employee_id = ten.employee_id 


						LEFT JOIN 
							(SELECT employee_id, COUNT(use_paid_leave) AS compoff_count 
							FROM employee_attendance 
							WHERE use_paid_leave = 'CMP' 
							AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
							GROUP BY employee_id) AS eleven 
						ON two.employee_id = eleven.employee_id 


						LEFT JOIN (
							SELECT 
								pm.emp_id, 
								SUM(pt.paid_days) AS paid_days,
								SUM(pt.use_paid_leave) AS use_paid_leave
							FROM paid_leave_master pm
							JOIN paid_leave_transaction pt 
								ON pm.paid_id = pt.paid_id_master
							WHERE YEAR(pm.p_date) = $year
							GROUP BY pm.emp_id
						) AS six
						ON two.employee_id = six.emp_id


						LEFT JOIN 
							(SELECT emp_id, SUM(paid_leave) AS totalp_leave 
							FROM employee_monthly_salary 
							GROUP BY emp_id) AS nine 
						ON two.employee_id = nine.emp_id 


						LEFT JOIN 
							(SELECT department_id, department_name 
							FROM departments) AS dept 
						ON two.department_id = dept.department_id  


						LEFT JOIN 
							(SELECT posession, emp_id
							FROM employee_document_details 
							WHERE document_name='visa') AS doc_det 
						ON two.employee_id = doc_det.emp_id 


						WHERE 
						two.status ='Active' 
						AND two.employee_id NOT IN 
						(
							SELECT emp_id 
							FROM employee_monthly_salary 
							WHERE MONTH(salary_month) = '$month' 
							AND YEAR(salary_month) = '$year'
						)

						ORDER BY two.employee_id ASC
						");

		return $query->result();
	}
	public function get_emp_monthly_salary_data()
	{
		$effective_date = $this->input->post('effective_date');

		$selected_month_year = date('Y-m', strtotime($effective_date));

		$start_date = date('Y-m-01', strtotime($selected_month_year));
		$end_date   = date('Y-m-t', strtotime($selected_month_year));

		$year  = date('Y', strtotime($effective_date));
		$month = date('m', strtotime($effective_date));

		$query = $this->db->query("
        SELECT 
            one.*,
            two.employee_name, 
            two.employee_id,
            two.employee_code,
            dept.department_name,
            doc_det.posession,

            COALESCE(six.paid_days, 0) AS paid_days, 
            COALESCE(six.use_paid_leave, 0) AS use_paid_leave,
            COALESCE(nine.totalp_leave, 0) AS totalp_leave,
            COALESCE(five.overtime, 0) AS total_overtime,
            COALESCE(eight.absent_count, 0) AS absent_count,
            COALESCE(five.attendance, 0) AS present_count,
            COALESCE(eleven.compoff_count, 0) AS compoff_count,
            COALESCE(ten.paid_leave_count, 0) AS paid_leave_count

        FROM employees AS two 

        LEFT JOIN 
        (
            SELECT emp_id, gross_salary, basic_salary, total_allowances, total_deductions
            FROM salary_structure
            WHERE effective_date IN (
                SELECT MAX(effective_date)
                FROM salary_structure
                GROUP BY emp_id
            )
        ) AS one 
        ON two.employee_id = one.emp_id

        -- ✅ FINAL ATTENDANCE LOGIC
        LEFT JOIN 
        (
            SELECT 
                employee_id,

                SUM(
                    CASE 
                        WHEN total_minutes >= 420 THEN 1
                        WHEN total_minutes >= 180 THEN 0.5
                        ELSE 0
                    END
                ) AS attendance,

                SUM(
                    CASE 
                        WHEN total_minutes > 420 THEN total_minutes - 420
                        ELSE 0
                    END
                ) AS overtime

            FROM (
                -- 🔥 PER DAY CALCULATION (IMPORTANT)
                SELECT 
                    employee_id,
                    Attendance_date,

                    SUM(
                        CASE 
                            -- ✅ Deduct break ONLY for full-day
                            WHEN TIMESTAMPDIFF(MINUTE, in_time, out_time) >= 420 
                                THEN TIMESTAMPDIFF(MINUTE, in_time, out_time) - 60
                            ELSE TIMESTAMPDIFF(MINUTE, in_time, out_time)
                        END
                    ) AS total_minutes

                FROM employee_attendance
                WHERE Attendance_date BETWEEN '$start_date' AND '$end_date'
                GROUP BY employee_id, Attendance_date

            ) daily

            GROUP BY employee_id
        ) AS five 
        ON two.employee_id = five.employee_id

        LEFT JOIN 
        (
            SELECT employee_id, COUNT(*) AS absent_count 
            FROM employee_attendance 
            WHERE attendence = 'A' 
            AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
            GROUP BY employee_id
        ) AS eight 
        ON two.employee_id = eight.employee_id 

        LEFT JOIN 
        (
            SELECT employee_id, COUNT(*) AS paid_leave_count 
            FROM employee_attendance 
            WHERE use_paid_leave = 'PL' 
            AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
            GROUP BY employee_id
        ) AS ten 
        ON two.employee_id = ten.employee_id 

        LEFT JOIN 
        (
            SELECT employee_id, COUNT(*) AS compoff_count 
            FROM employee_attendance 
            WHERE use_paid_leave = 'CMP' 
            AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
            GROUP BY employee_id
        ) AS eleven 
        ON two.employee_id = eleven.employee_id 

        LEFT JOIN (
            SELECT 
                pm.emp_id, 
                SUM(pt.paid_days) AS paid_days,
                SUM(pt.use_paid_leave) AS use_paid_leave
            FROM paid_leave_master pm
            JOIN paid_leave_transaction pt 
                ON pm.paid_id = pt.paid_id_master
            WHERE YEAR(pm.p_date) = $year
            GROUP BY pm.emp_id
        ) AS six
        ON two.employee_id = six.emp_id

        LEFT JOIN 
        (
            SELECT emp_id, SUM(paid_leave) AS totalp_leave 
            FROM employee_monthly_salary 
            GROUP BY emp_id
        ) AS nine 
        ON two.employee_id = nine.emp_id 

        LEFT JOIN departments AS dept 
        ON two.department_id = dept.department_id  

        LEFT JOIN 
        (
            SELECT posession, emp_id
            FROM employee_document_details 
            WHERE document_name='visa'
        ) AS doc_det 
        ON two.employee_id = doc_det.emp_id 

        WHERE 
            two.status ='Active' 
            AND two.employee_id NOT IN 
            (
                SELECT emp_id 
                FROM employee_monthly_salary 
                WHERE MONTH(salary_month) = '$month' 
                AND YEAR(salary_month) = '$year'
            )

        ORDER BY two.employee_id ASC
    ");

		return $query->result();
	}
	function get_emp_holiday_count()
	{
		$effective_date = $this->input->post('effective_date');
		$selected_month_year = date('Y-m', strtotime($effective_date));

		$start_date = date('Y-m-01', strtotime($selected_month_year));
		$end_date = date('Y-m-t', strtotime($selected_month_year));

		// Query to count the holidays in the specified date range without grouping by holiday name
		$query = $this->db->query("
        SELECT COUNT(*) AS holiday_count
        FROM holiday_master
        WHERE h_date BETWEEN '$start_date' AND '$end_date'");

		// Return the holiday count (result is a single row with the count)
		return $query->row()->holiday_count;
	}



	function delete_emp_salary($sid)
	{
		$query = $this->db->query("delete from employee_monthly_salary where sid='$sid'");

		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 3, $page_name[1], 'employee_monthly_salary', 'sid', $sid);
		return 1;
	}

	function get_approval_setup_list()
	{
		$query = $this->db->query("select * from approval_setup ");
		return $query->result();
	}
	function get_approval_setup_list_by_id($id)
	{
		$query = $this->db->query("select * from approval_setup where approve_id='$id'");
		return $query->result();
	}

	function add_approve_data()
	{
		$data = array(
			'approve_type' => $this->input->post('approve_type'),
			'approve_hr' => $this->input->post('approve_hr'),
			'approve_admin_md' => $this->input->post('approve_admin_md'),
			'created_by' => $this->session->userdata('user_id'),
			'approve_ceo' => $this->input->post('approve_ceo')

		);

		$this->db->insert('approval_setup', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'approval_setup', 'approve_id', $insert_id);
		}
		return $insert_id;
	}
	function update_approve_data($id)
	{
		// print_r($_POST);
		// exit;
		$data = array(
			//'approve_type' => $this->input->post('approve_type'),approve_ceo
			'approve_hr' => $this->input->post('approve_hr'),
			'approve_admin_md' => $this->input->post('approve_admin_md'),
			'approve_ceo' => $this->input->post('approve_ceo')


		);

		$this->db->where('approve_id', $id);
		$res = $this->db->update('approval_setup', $data);

		if ($res) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'approval_setup', 'approve_id', $id);
		}
		return $res;
	}

	function get_employee_monthlypayslip_by_id($sid)
	{
		$query = $this->db->query("select one.*,  two.department_name, three.designation_name from (select e.*, joining_date,employee_name, department_id,designation_id, employee_code, mobile from employee_monthly_salary e, employees u where e.emp_id=u.employee_id and sid=$sid )as one left join(select * from departments)as two on(one.department_id=two.department_id) left join(select * from designations)as three on(one.designation_id=three.designation_id )");
		return $query->result();
	}
	function get_monthly_salary_details($sid)
	{
		$query = $this->db->query("select * from employee_monthly_salary_details s, allowance_master am where s.allowance_id=am.sno and sid=$sid");
		return $query->result();
	}

	//////////////////////////////////////start advance salay////////////////////////////////////////
	function add_advance_salary()
	{

		$prifix = 'AS';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'as_code', 'advance_salary', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$AS_code = $prifix . $digit;

		$data = array(
			'emp_id' => $this->input->post('employee_id'),
			'as_code' => $AS_code,
			'form_date' => date('Y-m-d', strtotime($this->input->post('from_date'))),
			'to_date' => date('Y-m-d', strtotime($this->input->post('to_date'))),
			'deduction_amount' => $this->input->post('deduction_amount'),
			'remark' => $this->input->post('remark'),
		);
		$this->db->insert('advance_salary', $data);
		$insert_id = $this->db->insert_id();

		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'advance_salary', 'as_id', $insert_id);

		return $insert_id;
	}

	function update_advance_salary($id)
	{

		$data = array(
			'emp_id' => $this->input->post('employee_id_hidden'),
			'form_date' => date('Y-m-d', strtotime($this->input->post('from_date'))),
			'to_date' => date('Y-m-d', strtotime($this->input->post('to_date'))),
			'deduction_amount' => $this->input->post('deduction_amount'),
			'remark' => $this->input->post('remark'),
		);

		$this->db->where('as_id', $id);
		$res = $this->db->update('advance_salary', $data);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'advance_salary', 'as_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}



	function get_user_list()
	{
		$query = $this->db->query("select * from users  order by user_name");

		return $query->result();
	}

	function get_advance_salary_list()
	{
		$query = $this->db->query("select * from users u, advance_salary a where a.emp_id=u.user_id order by to_date");
		return $query->result();
	}

	function get_advance_salary_list_by_id($id)
	{
		$query = $this->db->query("select * from advance_salary where  as_id = $id ");
		return $query->result();
	}

	function delete_advance_salary($id)
	{
		$this->db->where('as_id', $id);
		$this->db->delete('advance_salary');
	}
	////////////////////////////////////////////////start paid leave//////////////////////


	public function add_paid_leave_data()
	{

		$prifix = 'PL';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'paid_code	', 'paid_leave_master', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$pl_code = $prifix . $digit;



		$data = array(
			'emp_id' => $this->input->post('employee_id'),
			'paid_code' => $pl_code,
			'p_date' => date('Y-m-d', strtotime($this->input->post('paid_date'))),
			'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),

			// 'paid_days' => $this->input->post('leave_days'),
			// 'use_paid_leave' => $this->input->post('leave_days'),

			'p_remark' => $this->input->post('p_remark'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),
		);

		$this->db->insert('paid_leave_master', $data);
		$insert_id = $this->db->insert_id();

		if (isset($_POST['leave_type_id'])) {

			for ($i = 0; $i < count($_POST['leave_type_id']); $i++) {
				$data = array(
					'paid_id_master' => $insert_id,
					'leave_type_id' => $_POST['leave_type_id'][$i],
					'paid_days' => $_POST['leave_days'][$i],
					'use_paid_leave' => $_POST['leave_days'][$i],

				);
				$this->db->insert('paid_leave_transaction', $data);
			}
		}


		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'paid_leave_master', 'paid_id', $insert_id);
		}
		return $insert_id;
	}

	function update_paid_leave_data($id)
	{
		$data = array(
			'emp_id' => $this->input->post('employee_id_hidden'),
			'p_date' => date('Y-m-d', strtotime($this->input->post('paid_date'))),
			'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),

			// 'paid_days' => $this->input->post('leave_days'),
			// 'use_paid_leave' => $this->input->post('use_leave_days'),

			'p_remark' => $this->input->post('p_remark'),

		);

		$this->db->where('paid_id', $id);
		$res = $this->db->update('paid_leave_master', $data);

		if (isset($_POST['leave_type_id'])) {

			$this->db->query("delete from paid_leave_transaction where paid_id_master=$id");

			for ($i = 0; $i < count($_POST['leave_type_id']); $i++) {
				$data = array(
					'paid_id_master' => $id,
					'leave_type_id' => $_POST['leave_type_id'][$i],
					'paid_days' => $_POST['leave_days'][$i],
					'use_paid_leave' => $_POST['use_leave_days'][$i],

				);
				$this->db->insert('paid_leave_transaction', $data);
			}
		}
		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'paid_leave_master', 'paid_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}


	function get_paid_leave_list()
	{
		$current_year = date('Y');
		// $query = $this->db->query("
		// 	SELECT r.*, e.employee_name AS name
		// 	FROM paid_leave_master r
		// 	JOIN employees e ON r.emp_id = e.employee_id
		// 	WHERE YEAR(r.p_date) = ?
		// 	ORDER BY r.p_date DESC
		// ", [$current_year]);
		$query = $this->db->query("
				SELECT 
					r.*,
					e.employee_name AS name,
					COALESCE(SUM(t.paid_days), 0) AS total_paid_days
				FROM paid_leave_master r
				JOIN employees e 
					ON r.emp_id = e.employee_id
				LEFT JOIN paid_leave_transaction t 
					ON t.paid_id_master = r.paid_id
				WHERE YEAR(r.p_date) = ?
				GROUP BY r.paid_id
				ORDER BY r.p_date DESC
			", [$current_year]);
		return $query->result();
	}

	function filter_paid_leave_list($current_year)
	{
		$query = $this->db->query("select r.*, u.employee_name as name from paid_leave_master r, employees u where r.emp_id=u.employee_id  and YEAR(p_date) = $current_year order by p_date desc ");
		return $query->result();
	}
	function get_paid_leave_by_id($id)
	{
		$query = $this->db->query("SELECT r.*, u.*,r.end_date as p_end_date
								   FROM paid_leave_master AS r
								   INNER JOIN employees AS u ON r.emp_id = u.employee_id
								   WHERE paid_id = '$id'
								   ORDER BY r.p_date DESC");

		return $query->result();
	}
	function get_paid_leave_transaction_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM paid_leave_transaction where paid_id_master = $id");

		return $query->result();
	}

	function get_paid_leave_active_list()
	{
		$current_year = date('Y');

		// $query = $this->db->query("
		// 		SELECT *, id
		// 		FROM users
		// 		WHERE id NOT IN (
		// 			SELECT emp_id
		// 			FROM paid_leave_master
		// 			WHERE YEAR(p_date) = $current_year
		// 		)
		// 		ORDER BY username
		// 	");
		$query = $this->db->query("
				SELECT e.*, e.employee_id
				FROM employees e
				WHERE e.employee_id NOT IN (
					SELECT pl.emp_id
					FROM paid_leave_master pl
					WHERE YEAR(pl.p_date) = ?
				)
				ORDER BY e.employee_name
			", [$current_year]);
		return $query->result();
	}

	function delete_paid_leave($id)
	{
		$this->db->where('paid_id', $id);
		$this->db->delete('paid_leave_master');
	}

	////////////////////////////////////////////////end paid leave///////////////////////
	////////////////////////////////////////////////start holiday data///////////////////////

	public function add_holiday_data()
	{

		$prifix = 'HL';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'holiday_code	', 'holiday_master', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$hl_code = $prifix . $digit;



		$data = array(

			'holiday_code' => $hl_code,
			'holiday_name' => $this->input->post('holiday_name'),
			'h_date' => date('Y-m-d', strtotime($this->input->post('holiday_date'))),
			'holiday_des' => $this->input->post('holl_desc'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),
		);

		$this->db->insert('holiday_master', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'holiday_master', 'holiday_id', $insert_id);
		}
		return $insert_id;
	}

	function update_holiday_data($id)
	{
		$data = array(
			'h_date' => date('Y-m-d', strtotime($this->input->post('holiday_date'))),
			'holiday_des' => $this->input->post('holl_desc'),

		);

		$this->db->where('holiday_id', $id);
		$res = $this->db->update('holiday_master', $data);


		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'holiday_master', 'holiday_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}


	function get_holiday_list()
	{
		$query = $this->db->query("select * from holiday_master  order by h_date desc ");
		return $query->result();
	}
	function get_holiday_list_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM holiday_master WHERE holiday_id = '$id' ORDER BY h_date DESC");

		return $query->result();
	}




	function delete_holiday_data($id)
	{
		$this->db->where('holiday_id', $id);
		$this->db->delete('holiday_master');
	}



	////////////////////////////////////////////////end holiday data ///////////////////////
	////////////////////////////start add data comp off//////////////////////

	public function add_comp_off_data()
	{
		$data = array(

			'emp_reqtype' => 'compensatory_leave',
			'user_id' => $this->input->post('employee_id'),
			'app_date' => date('Y-m-d', strtotime($this->input->post('app_date'))),
			'form_date' => date('Y-m-d', strtotime($this->input->post('work_date'))),
			'to_date' => date('Y-m-d', strtotime($this->input->post('comp_date'))),
			'remark' => $this->input->post('remark'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d')

		);
		$this->db->insert('employee_request_data', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_request_data', 'emp_req_id', $insert_id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($insert_id, $current_url, "Employee has applied for compensatory leave", "Hr/view_emp_request_edit_data/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////


		}
		return $insert_id;
	}
	/////////////////////////////////////end comp off///////////////////
	////////////////////////////////start advance salary////////////////////
	public function add_advance_salary_data()
	{
		$data = array(

			'emp_reqtype' => 'advance_salary',
			'user_id' => $this->input->post('employee_id'),
			'app_date' => date('Y-m-d', strtotime($this->input->post('app_date'))),
			'form_date' => !empty($this->input->post('a_month')) ? date('Y-m-01', strtotime($this->input->post('a_month'))) : null,
			'remark' => $this->input->post('remark'),
			'amount' => $this->input->post('advance_salary'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d')

		);
		$this->db->insert('employee_request_data', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			if (!empty($_FILES["documents_salary"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_salary']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_salary"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);

							$data1 = array(
								'emp_req_id' => $insert_id,
								'document_name' => $this->input->post('document_types_salary')[$key],
								'document_path' => $other_file,
								'created_by' => $this->session->userdata('user_id'),
								'create_date' => date('Y-m-d')
							);
							$this->db->insert('employee_req_documents', $data1);
						}
					}
				}
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_request_data', 'emp_req_id', $insert_id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($insert_id, $current_url, "Employee has applied for Advance Salary", "Hr/view_emp_request_edit_data/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

		}
		return $insert_id;
	}

	/////////////////////////////end advance salary////////////////////////
	////////////////////////////////start allowance////////////////////
	public function add_allowance_data()
	{
		$data = array(

			'emp_reqtype' => 'allowance',
			'user_id' => $this->input->post('employee_id'),
			'allowance_type' => $this->input->post('allowance_id'),
			'app_date' => date('Y-m-d', strtotime($this->input->post('app_date'))),
			'form_date' => date('Y-m-d', strtotime($this->input->post('from_date'))),
			'to_date' => date('Y-m-d', strtotime($this->input->post('to_date'))),
			'amount' => $this->input->post('a_amount'),
			'remark' => $this->input->post('remark'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d')

		);
		$this->db->insert('employee_request_data', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			if (!empty($_FILES["documents_allowance"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_allowance']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_allowance"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);

							$data1 = array(
								'emp_req_id' => $insert_id,
								//'employee_id' => $this->input->post('employee_id'),
								'document_name' => $this->input->post('document_types_allowance')[$key],
								'document_path' => $other_file,
								'created_by' => $this->session->userdata('user_id'),
								'create_date' => date('Y-m-d')
							);
							$this->db->insert('employee_req_documents', $data1);
						}
					}
				}
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_request_data', 'emp_req_id', $insert_id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($insert_id, $current_url, "Employee has applied for Extra Allowance", "Hr/view_emp_request_edit_data/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

		}
		return $insert_id;
	}
	////////////////////////////start add data loan//////////////////////

	public function add_loan_data()
	{
		$data = array(

			'emp_reqtype' => 'loan',
			'user_id' => $this->input->post('employee_id'),
			'app_date' => date('Y-m-d', strtotime($this->input->post('app_date'))),
			'form_date' => !empty($this->input->post('start_date')) ? date('Y-m-01', strtotime($this->input->post('start_date'))) : null,
			'to_date' => !empty($this->input->post('end_date')) ? date('Y-m-t', strtotime($this->input->post('end_date'))) : null,

			'emi_amount' => $this->input->post('emi_amount'),
			'total_month' => $this->input->post('total_month'),

			'amount' => $this->input->post('r_amount'),
			'remark' => $this->input->post('remark'),

			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d')

		);
		$this->db->insert('employee_request_data', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {
			if (!empty($_FILES["documents_loan"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_loan']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_loan"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);

							$data1 = array(
								'emp_req_id' => $insert_id,
								//'employee_id' => $this->input->post('employee_id'),
								'document_name' => $this->input->post('document_types_loan')[$key],
								'document_path' => $other_file,
								'created_by' => $this->session->userdata('user_id'),
								'create_date' => date('Y-m-d')
							);
							$this->db->insert('employee_req_documents', $data1);
						}
					}
				}
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_request_data', 'emp_req_id', $insert_id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($insert_id, $current_url, "Employee has applied for Loan", "Hr/view_emp_request_edit_data/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

		}
		return $insert_id;
	}
	///////////////////////////////end loan data/////////////////////////////



	function get_employee_request_list()
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id AND j.user_id='$current_user_id' order by app_date desc ");
		return $query->result();
	}
	function get_employee_request_list_by($id)
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id AND j.user_id='$current_user_id' and j.emp_req_id=$id order by app_date desc ");
		return $query->result();
	}


	function get_employee_request_list_by_comp($id)
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id AND j.user_id='$current_user_id' and j.emp_req_id=$id and j.emp_reqtype='compensatory_leave' order by app_date desc ");
		return $query->result();
	}
	function get_employee_request_list_by_salary($id)
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id AND j.user_id='$current_user_id' and j.emp_req_id=$id and j.emp_reqtype='advance_salary' order by app_date desc ");
		return $query->result();
	}
	function get_employee_request_list_by_allowance($id)
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id AND j.user_id='$current_user_id' and j.emp_req_id=$id and j.emp_reqtype='allowance' order by app_date desc ");
		return $query->result();
	}
	function get_employee_request_list_by_loan($id)
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id AND j.user_id='$current_user_id' and j.emp_req_id=$id and j.emp_reqtype='loan' order by app_date desc ");
		return $query->result();
	}
	function get_employee_req_advance_doc_id($id)
	{

		$query = $this->db->query("select * from employee_req_documents where emp_req_id=$id  ");
		return $query->result();
	}

	function get_employee_req_allowance_doc_id($id)
	{

		$query = $this->db->query("select * from employee_req_documents where emp_req_id=$id  ");
		return $query->result();
	}

	function get_employee_req_loan_doc_id($id)
	{

		$query = $this->db->query("select * from employee_req_documents where emp_req_id=$id  ");
		return $query->result();
	}



	function get_employee_emp_ad_amount()
	{
		$current_user_id = $this->session->userdata('user_id');
		$query = $this->db->query("select  j.gross_salary from salary_structure j, users u where j.emp_id=u.user_id AND j.emp_id='$current_user_id' ");


		$result = $query->row();

		if ($result) {
			return $result->gross_salary;
		} else {
			return null;
		}
	}

	////////////////////////////////update data  for employee requests
	function update_employee_request_comp_off($id)
	{
		$data = array(
			'emp_reqtype' => 'compensatory_leave',
			'user_id' => $this->input->post('employee_id_hidden'),
			'form_date' => date('Y-m-d', strtotime($this->input->post('work_date'))),
			'to_date' => date('Y-m-d', strtotime($this->input->post('comp_date'))),
			'remark' => $this->input->post('remark'),

		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Employee has Updated for Comp Off", "Hr/view_emp_request_edit_data/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	///////////////////////////////////////////update advance salary///////////////////
	function update_employee_request_advance($id)
	{
		$data = array(
			'user_id' => $this->input->post('employee_id_hidden'),
			'form_date' => !empty($this->input->post('a_month')) ? date('Y-m-01', strtotime($this->input->post('a_month'))) : null,
			'remark' => $this->input->post('remark')
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		if ($res) {
			if (!empty($_FILES["documents_salary"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_salary']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_salary"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);

							$data1 = array(
								'emp_req_id' => $res,
								'document_name' => $this->input->post('document_types_salary')[$key],
								'document_path' => $other_file,
								'created_by' => $this->session->userdata('user_id'),
								'create_date' => date('Y-m-d')
							);
							$this->db->insert('employee_req_documents', $data1);
						}
					}
				}
			}
		}

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Employee has Updated Advance Salary Request", "Hr/view_emp_request_edit_data/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	///////////////////////////////////////start allwance//////////////////////////
	function update_employee_request_allowance($id)
	{
		$data = array(
			'user_id' => $this->input->post('employee_id_hidden'),
			'allowance_type' => $this->input->post('allowance_id'),
			// 'app_date' => date('Y-m-d', strtotime($this->input->post('app_date'))),
			'form_date' => date('Y-m-d', strtotime($this->input->post('from_date'))),
			'to_date' => date('Y-m-d', strtotime($this->input->post('to_date'))),
			'amount' => $this->input->post('a_amount'),
			'remark' => $this->input->post('remark')
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		if ($res) {
			if (!empty($_FILES["documents_allowance"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_allowance']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_allowance"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);

							$data1 = array(
								'emp_req_id' => $res,
								//'employee_id' => $this->input->post('employee_id'),
								'document_name' => $this->input->post('document_types_allowance')[$key],
								'document_path' => $other_file,
								'created_by' => $this->session->userdata('user_id'),
								'create_date' => date('Y-m-d')
							);
							$this->db->insert('employee_req_documents', $data1);
						}
					}
				}
			}
		}

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);


			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Employee has Updated Extra Allowance Request", "Hr/view_emp_request_edit_data/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	///////////////////////////////////////////////////loan////////////////////////////
	function update_employee_request_loan($id)
	{
		$data = array(
			'user_id' => $this->input->post('employee_id_hidden'),
			'form_date' => !empty($this->input->post('start_date')) ? date('Y-m-01', strtotime($this->input->post('start_date'))) : null,
			'to_date' => !empty($this->input->post('end_date')) ? date('Y-m-t', strtotime($this->input->post('end_date'))) : null,

			'emi_amount' => $this->input->post('emi_amount'),
			'total_month' => $this->input->post('total_month'),

			'amount' => $this->input->post('r_amount'),
			'remark' => $this->input->post('remark')
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		if ($res) {
			if (!empty($_FILES["documents_loan"])) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				foreach ($_FILES['documents_loan']["name"] as $key => $filename) {
					if (!empty($filename)) {
						$temp = explode(".", $filename);
						$extension = end($temp);
						if (in_array($extension, $allowedExts)) {
							$timestamp1 = time();
							$file_tmp = $_FILES["documents_loan"]["tmp_name"][$key];
							$other_file = $timestamp1 . "_" . $filename;
							move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);

							$data1 = array(
								'emp_req_id' => $res,
								//'employee_id' => $this->input->post('employee_id'),
								'document_name' => $this->input->post('document_types_loan')[$key],
								'document_path' => $other_file,
								'created_by' => $this->session->userdata('user_id'),
								'create_date' => date('Y-m-d')
							);
							$this->db->insert('employee_req_documents', $data1);
						}
					}
				}
			}
		}

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Employee has Updated Loan Request", "Hr/view_emp_request_edit_data/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	///////////////////////////////////////////////////////////

	function get_employee_request_data_list()
	{

		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id order by app_date desc ");
		return $query->result();
	}


	/////////////////////////////////update employee request by hr/////////////////
	function update_employee_request_comp_off_hr($id)
	{

		$data = array(
			'approved_flag' => $this->input->post('comp_status'),
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			'approved_form_date' => date('Y-m-d', strtotime($this->input->post('a_comp_date'))),
			'approve_remark' => $this->input->post('approve_remark'),
			// 'emi_amount' => '0',
			// 'approved_amount' => 0,
			// 'approved_form_date' => $this->input->post('approve_remark'),
			// 'approved_to_date' => $this->input->post('approve_remark'),
			// 'approve_total_month' => $this->input->post('approve_remark'),
			// 'approve_emi' => $this->input->post('approve_remark'),
		);


		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);


		$status = $this->input->post('comp_status');
		$employee = $this->input->post('employee_id_hidden');
		$approve_compoff_date = date('Y-m-d', strtotime($this->input->post('a_comp_date')));
		if ($status == 1) {
			$insert_data = array(
				'employee_id' => $employee,
				'Attendance_date' => $approve_compoff_date,
				'attendence' => 'A',
				'use_paid_leave' => 'CMP',
				'type' => 'M'
			);
			$this->db->insert('employee_attendance', $insert_data);
		}


		$s = ($status == 1) ? "Approve Comp Off Successfully" : "Rejected Comp Off";


		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////

			$notice = add_notification($id, $employee, "$s", "Hr/view_emp_request_edit/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////
			/* end notification */
			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	///////////////////////////////////////////update advance salary///////////////////
	function update_employee_request_advance_hr($id)
	{
		$data = array(
			'approved_flag' => $this->input->post('advance_status'),
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			'approved_amount' => $this->input->post('approve_advance_salary'),
			'approved_form_date' => !empty($this->input->post('ad_month')) ? date('Y-m-01', strtotime($this->input->post('ad_month'))) : null,
			'approved_to_date' => !empty($this->input->post('ad_month')) ? date('Y-m-t', strtotime($this->input->post('ad_month'))) : null,

			'approve_remark' => $this->input->post('approve_remark'),

		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		$employee = $this->input->post('employee_id_hidden');
		$status = $this->input->post('advance_status');

		$s = ($status == 1) ? "Approve Advance Salary Successfully" : "Advance Salary Rejected";


		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);

			$notice = add_notification($id, $employee, "$s", "Hr/view_emp_request_edit/$id");

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	///////////////////////////////////////start allwance//////////////////////////
	function update_employee_request_allowance_hr($id)
	{
		$data = array(
			'approved_flag' => $this->input->post('allowance_status'),
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			'approved_form_date' => !empty($this->input->post('a_start_month')) ? date('Y-m-01', strtotime($this->input->post('a_start_month'))) : null,
			'approved_to_date' => !empty($this->input->post('a_end_month')) ? date('Y-m-t', strtotime($this->input->post('a_end_month'))) : null,

			'approved_amount' => $this->input->post('approve_amount'),
			'approve_remark' => $this->input->post('approve_remark')
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		$employee = $this->input->post('employee_id_hidden');
		$status = $this->input->post('allowance_status');

		$s = ($status == 1) ? "Approve Extra Allowance Successfully" : "Extra Allowance Rejected";

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);
			$notice = add_notification($id, $employee, "$s", "Hr/view_emp_request_edit/$id");

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	///////////////////////////////////////////////////loan////////////////////////////
	function update_employee_request_loan_hr($id)
	{
		$data = array(
			'approved_flag' => $this->input->post('loan_status'),
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			'approved_form_date' => !empty($this->input->post('a_start_month')) ? date('Y-m-01', strtotime($this->input->post('a_start_month'))) : null,
			'approved_to_date' => !empty($this->input->post('a_end_month')) ? date('Y-m-t', strtotime($this->input->post('a_end_month'))) : null,

			'approve_emi' => $this->input->post('a_emi_amount'),
			'approve_total_month' => $this->input->post('a_total_month'),

			'approved_amount' => $this->input->post('ar_amount'),
			'approve_remark' => $this->input->post('approve_remark')
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		$employee = $this->input->post('employee_id_hidden');
		$status = $this->input->post('loan_status');

		$s = ($status == 1) ? "Approve Loan Successfully" : "Loan Rejected";


		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);
			$notice = add_notification($id, $employee, "$s", "Hr/view_emp_request_edit/$id");

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	//////////////////////start missing attandance approvals///////////////////////////////////////////


	function update_employee_request_attendance_hr($id)
	{
		// print_r($_POST);
		// exit;


		$rec_inTime = $this->input->post('req_in_time');
		$rec_outTime = $this->input->post('req_out_time');


		$data = array(
			'approved_flag' => $this->input->post('attendance_status'),
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			'rec_in_time' => $rec_inTime,
			'rec_out_time' => $rec_outTime,

			'approve_remark' => $this->input->post('approve_remark')
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		$employee = $this->input->post('employee_id_hidden');
		$status = $this->input->post('attendance_status');

		$s = ($status == 1) ? "Approve Mismatch Attendance Successfully" : "Mismatch Attendance Rejected";
		$user_query = $this->db->select('user_id, ivms_id')
			->from('users')
			->where('user_id', $employee)
			->get();

		if ($user_query->num_rows() > 0) {
			$user = $user_query->row();
			$user_id = $user->user_id;
			$ivms_id = $user->ivms_id;

			$request_miss_att_date = date('Y-m-d', strtotime($this->input->post('request_miss_att_date')));

			$data = array(
				'in_time'  => $rec_inTime,
				'out_time' => $rec_outTime
			);
			$this->db->where('Attendance_date', $request_miss_att_date);
			$this->db->where('employee_id', $user_id);
			$this->db->where('ivms_id IS NULL', null, false);
			$res1 = $this->db->update('employee_attendance', $data);

			/////////////////////////////////
			$data1 = array(
				'in_time'  => $rec_inTime,
				'out_time' => $rec_outTime
			);

			$this->db->where('Attendance_date', $request_miss_att_date);
			$this->db->where('ivms_id', $ivms_id);
			$this->db->where('type', 'I');
			$this->db->where('ivms_id IS NOT NULL', null, false);
			$res2 = $this->db->update('employee_attendance', $data1);
		} else {
			echo "Employee not found.";
		}


		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);
			$notice = add_notification($id, $employee, "$s", "Hr/view_emp_request_edit/$id");

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	/////////////////////////////end missing approvals///////////////////////////////////


	////////////////////////////start hr data list///////////
	function get_employee_request_list_by_hr($id)
	{
		$query = $this->db->query("select  j.*, u.user_name as name from employee_request_data j, users u where j.user_id=u.user_id and j.emp_req_id=$id order by app_date desc ");
		return $query->result();
	}
	///////////////////////////////////END/////////////////////////////////////////////////

	/*****
	 * Author : Teena VI
	 * Date : 21/3/2025
	 * Aim : Add / Update and View Workforce requisition Form
	 */

	function add_workforce_requisition_data()
	{

		$prifix = 'W-REQ' . date('y') . '';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'emp_req_code', 'employee_requisition', 11) + 1;
		$digit = sprintf("%1$04d", $num);
		$req_code = $prifix . date('m') . $digit; //echo $req_code.'==='.$digit.'=='.$num;die;
		$data1 = array(
			'emp_req_code' => $req_code,
			'dept_id' => $this->input->post('department'),
			'request_date' => $this->input->post('request_date'),
			'desig_id' => $this->input->post('position_name'),
			'required_date' => $this->input->post('required_date'),
			'emp_type' => $this->input->post('employee_type'),
			'job_desc' => $this->input->post('job_description'),
			'request_type' => $this->input->post('request_type'),
			'education_requirement' => $this->input->post('education'),
			'preferred_qualification' => $this->input->post('qualifications'),
			'roles_responsibilities' => $this->input->post('roles_responsibility'),
			'budgeted_salary' => $this->input->post('budgeted_salary'),
			'budgeted_no' => $this->input->post('budgeted_number'),
			'existing_no' => $this->input->post('existing_number'),
			'vacancy_no' => $this->input->post('vacancies'),
			'requested_by' => $this->input->post('hod_sign'),
			'hr_approval' => $this->input->post('hr_approval'),
			'ceo_approval' => $this->input->post('ceo_approval'),
			'hr_id' => $this->input->post('hr_id'),
			'ceo_id' => $this->input->post('ceo_id'),
			'notes' => $this->input->post('notes'),
			'created_at' => date("Y-m-d H:i:s")
		);
		$this->db->insert('employee_requisition', $data1);

		//print_r($data1);die;
		$insert_id = $this->db->insert_id(); //echo $this->db->last_query();echo 'insert_id - '.$insert_id;die;
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_requisition', 'emp_req_id', $insert_id);

			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($insert_id, $current_url, "$req_code Workforce Requisition Created ", "Hr/edit_workforce_requisition/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////


			return true;
		} else {
			return false;
		}
	}

	function get_all_requisition_details()
	{
		$query = $this->db->query("
			SELECT * 
			FROM employee_requisition AS e 
			LEFT JOIN department_master AS dm ON e.dept_id = dm.dept_id 
			LEFT JOIN designation_master AS la ON e.desig_id = la.did 
			LEFT JOIN users AS u ON u.user_id = e.requested_by 
			ORDER BY e.	created_at DESC
		");

		return $query->result();
	}

	function get_requisition_details_by_id($id)
	{
		$query = $this->db->query("
			SELECT * 
			FROM employee_requisition 
			WHERE emp_req_id = '$id'
		");

		return $query->row();
	}

	function update_workforce_requisition_data()
	{
		$id = $this->input->post('emp_req_id');
		$data1 = array(
			'dept_id' => $this->input->post('department'),
			'request_date' => $this->input->post('request_date'),
			'desig_id' => $this->input->post('position_name'),
			'required_date' => $this->input->post('required_date'),
			'emp_type' => $this->input->post('employee_type'),
			'job_desc' => $this->input->post('job_description'),
			'request_type' => $this->input->post('request_type'),
			'education_requirement' => $this->input->post('education'),
			'preferred_qualification' => $this->input->post('qualifications'),
			'roles_responsibilities' => $this->input->post('roles_responsibility'),
			'budgeted_salary' => $this->input->post('budgeted_salary'),
			'budgeted_no' => $this->input->post('budgeted_number'),
			'existing_no' => $this->input->post('existing_number'),
			'vacancy_no' => $this->input->post('vacancies'),
			'requested_by' => $this->input->post('hod_sign'),
			'hr_approval' => $this->input->post('hr_approval'),
			'ceo_approval' => $this->input->post('ceo_approval'),
			'hr_id' => $this->input->post('hr_id'),
			'ceo_id' => $this->input->post('ceo_id'),
			'notes' => $this->input->post('notes'),
		);
		//print_r($data1);die;
		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_requisition', $data1);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_requisition', 'emp_req_id', $id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Update Workforce Requisition Successfully", "Hr/edit_workforce_requisition/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	function get_requisition_by_id($id)
	{
		$this->db->select('er.*,u.*,dm.*,des_m.*,us.user_name as hr_name,dep_ma.dept_name as hr_dept');
		$this->db->from('employee_requisition er');
		$this->db->join('users u', 'u.user_id = er.requested_by', 'left');
		$this->db->join('users us', 'us.user_id = er.hr_id', 'left');
		$this->db->join('department_master dm', 'dm.dept_id = er.dept_id', 'left');
		$this->db->join('designation_master des_m', 'des_m.did = er.desig_id', 'left');
		$this->db->join('department_master dep_ma', 'dep_ma.dept_id = us.dept_id', 'left');
		$this->db->where('er.emp_req_id', $id);
		$query = $this->db->get(); //echo $this->db->last_query();die;
		return $query->row();
	}


	/*****
	 * Author : Teena VI
	 * Date : 03/4/2025
	 * Aim : Add / Update and View Interview assessment
	 */

	/*****
	 * Author : Teena VI
	 * Date : 03/4/2025
	 * Aim : Add / Update and View Interview assessment
	 */

	function add_interview_data()
	{

		$prifix = 'INT-' . date('y') . '';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'emp_req_code', 'employee_requisition', 8) + 1;
		$digit = sprintf("%1$04d", $num);
		$int_code = $prifix . date('m') . $digit;

		$work_agree = $this->input->post('work_agree') ? "yes" : "no";
		$edu_certificate = $this->input->post('edu_certificate') ? "yes" : "no";
		$exp_certificate = $this->input->post('exp_certificate') ? "yes" : "no";

		$resume = "";
		if ($_FILES["resume"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["resume"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$resume = '';

			if (($_FILES["resume"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
				if ($_FILES["resume"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["resume"]["tmp_name"];
					$resume = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "public/uploded_documents/" . $asset_file); ///home/webadmin/gen/Hundredmedia/public/uploded_documents/
				}
			} else {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			}
		}

		$data1 = array(
			'int_code' => $int_code,
			'emp_req_id' => $this->input->post('form_code'),
			'desig_id' => $this->input->post('position'),
			'interview_date' => $this->input->post('interview_date'),
			'name' => $this->input->post('name'),
			'visa' => $this->input->post('visa'),
			'source' => $this->input->post('source'),
			'eid' => $this->input->post('eid'),
			'eid_expiry' => $this->input->post('eid_expiry'),
			'drive_licence' => $this->input->post('drive_licence'),
			'passport_number' => $this->input->post('passport_number'),
			'pass_expiry' => $this->input->post('pass_expiry'),
			'qualification' => $this->input->post('qualification'),
			'experience' => $this->input->post('experience'),
			'age' => $this->input->post('age'),
			'contact_no' => $this->input->post('contact_no'),
			'notice_period' => $this->input->post('notice_period'),
			'strengths' => $this->input->post('strengths'),
			'job_knowledge' => $this->input->post('job_knowledge'),
			'communication' => $this->input->post('communication'),
			'knowledge' => $this->input->post('knowledge'),
			'confidence' => $this->input->post('confidence'),
			'work_approach' => $this->input->post('work_approach'),
			'cust_orientation' => $this->input->post('cust_orientation'),
			'team_work' => $this->input->post('team_work'),
			'overall_rating' => $this->input->post('overall_rating'),
			'rejection_reason' => $this->input->post('rejection_reason'),
			'recommendation' => $this->input->post('recommendation'),
			'edu_certificate' => $edu_certificate,
			'exp_certificate' => $exp_certificate,
			'expectation' => $this->input->post('expectation'),
			'past_job_likes' => $this->input->post('past_job_likes'),
			'past_job_dislikes' => $this->input->post('past_job_dislikes'),
			'job_fit' => $this->input->post('job_fit'),
			'family' => $this->input->post('family'),
			'work_agree' => $work_agree,
			'current_salary' => $this->input->post('current_salary'),
			'expected_salary' => $this->input->post('expected_salary'),
			'offered_salary' => $this->input->post('offered_salary'),
			'employer_1' => $this->input->post('employer_1'),
			'employer_2' => $this->input->post('employer_2'),
			'desig_1' => $this->input->post('desig_1'),
			'desig_2' => $this->input->post('desig_2'),
			'email_1' => $this->input->post('email_1'),
			'email_2' => $this->input->post('email_2'),
			'questions' => $this->input->post('questions'),
			'dept_id' => $this->input->post('dept_id'),
			'dept_hod_id' => $this->input->post('dept_hod_id'),
			'dept_hod_approval' => $this->input->post('dept_hod_approval'),
			'hr_id' => $this->input->post('hr_id'),
			'hr_approval' => $this->input->post('hr_approval'),
			'shortlisted' => $this->input->post('shortlisted'),
			'resume' => $resume,
			'created_at' => date("Y-m-d H:i:s")
		);
		$this->db->insert('employee_interview', $data1);

		//print_r($data1);die;
		$insert_id = $this->db->insert_id(); //echo $this->db->last_query();echo 'insert_id - '.$insert_id;die;
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_interview', 'int_id', $insert_id);
			return true;
		} else {
			return false;
		}
	}

	function get_all_interview_details()
	{
		$query = $this->db->query("
			 SELECT 
			 ei.*, 
			 er.*, 
			 dm.*, 
			 ei.hr_approval AS h_app, 
			 ei.dept_hod_approval AS hod_app,
			 ei.ceo_approval AS ceo_app
		 FROM employee_interview AS ei
		 LEFT JOIN employee_requisition AS er ON ei.emp_req_id = er.emp_req_id
		 LEFT JOIN designation_master AS dm ON ei.desig_id = dm.did
		 ORDER BY ei.created_at DESC;
		 ");
		return $query->result();
		//LEFT JOIN users AS u ON u.user_id = e.requested_by 
	}
	function get_inetrview_details_by_id($id)
	{
		$query = $this->db->query("
			 SELECT * 
			 FROM employee_interview 
			 WHERE int_id = '$id'
		 ");

		return $query->row();
	}

	function update_interview_data()
	{

		$id = $this->input->post('int_id');
		$work_agree = $this->input->post('work_agree') ? "yes" : "no";
		$edu_certificate = $this->input->post('edu_certificate') ? "yes" : "no";
		$exp_certificate = $this->input->post('exp_certificate') ? "yes" : "no";

		$data1 = array();

		if ($_FILES["resume"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["resume"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);

			if (($_FILES["resume"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
				if ($_FILES["resume"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["resume"]["tmp_name"];
					$data1['resume'] = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "public/uploded_documents/" . $data1['resume']); ///home/webadmin/gen/Hundredmedia/public/uploded_documents/
				}
			} else {
				echo "else";
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			}
		}

		$data1['emp_req_id'] = $this->input->post('form_code');
		$data1['desig_id'] = $this->input->post('position');
		$data1['interview_date'] = $this->input->post('interview_date');
		$data1['name'] = $this->input->post('name');
		$data1['visa'] = $this->input->post('visa');
		$data1['source'] = $this->input->post('source');
		$data1['eid'] = $this->input->post('eid');
		$data1['eid_expiry'] = $this->input->post('eid_expiry');
		$data1['drive_licence'] = $this->input->post('drive_licence');
		$data1['passport_number'] = $this->input->post('passport_number');
		$data1['pass_expiry'] = $this->input->post('pass_expiry');
		$data1['qualification'] = $this->input->post('qualification');
		$data1['experience'] = $this->input->post('experience');
		$data1['age'] = $this->input->post('age');
		$data1['contact_no'] = $this->input->post('contact_no');
		$data1['notice_period'] = $this->input->post('notice_period');
		$data1['strengths'] = $this->input->post('strengths');
		$data1['job_knowledge'] = $this->input->post('job_knowledge');
		$data1['communication'] = $this->input->post('communication');
		$data1['knowledge'] = $this->input->post('knowledge');
		$data1['confidence'] = $this->input->post('confidence');
		$data1['work_approach'] = $this->input->post('work_approach');
		$data1['cust_orientation'] = $this->input->post('cust_orientation');
		$data1['team_work'] = $this->input->post('team_work');
		$data1['overall_rating'] = $this->input->post('overall_rating');
		$data1['rejection_reason'] = $this->input->post('rejection_reason');
		$data1['recommendation'] = $this->input->post('recommendation');
		$data1['edu_certificate'] = $edu_certificate;
		$data1['exp_certificate'] = $exp_certificate;
		$data1['expectation'] = $this->input->post('expectation');
		$data1['past_job_likes'] = $this->input->post('past_job_likes');
		$data1['past_job_dislikes'] = $this->input->post('past_job_dislikes');
		$data1['job_fit'] = $this->input->post('job_fit');
		$data1['family'] = $this->input->post('family');
		$data1['work_agree'] = $work_agree;
		$data1['current_salary'] = $this->input->post('current_salary');
		$data1['expected_salary'] = $this->input->post('expected_salary');
		$data1['offered_salary'] = $this->input->post('offered_salary');
		$data1['employer_1'] = $this->input->post('employer_1');
		$data1['employer_2'] = $this->input->post('employer_2');
		$data1['desig_1'] = $this->input->post('desig_1');
		$data1['desig_2'] = $this->input->post('desig_2');
		$data1['email_1'] = $this->input->post('email_1');
		$data1['email_2'] = $this->input->post('email_2');
		$data1['questions'] = $this->input->post('questions');
		$data1['dept_id'] = $this->input->post('dept_id');
		$data1['dept_hod_id'] = $this->input->post('dept_hod_id');
		$data1['dept_hod_approval'] = $this->input->post('dept_hod_approval');
		$data1['hr_id'] = $this->input->post('hr_id');
		$data1['hr_approval'] = $this->input->post('hr_approval');
		$data1['shortlisted'] = $this->input->post('shortlisted');
		$data1['ceo_id'] = $this->input->post('ceo_id');
		$data1['ceo_approval'] = $this->input->post('ceo_approval');
		$data1['created_at'] = date("Y-m-d H:i:s");

		$this->db->where('int_id', $id);
		$res = $this->db->update('employee_interview', $data1);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_interview', 'int_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	/*****
	 * Author : Teena VI
	 * Date : 10/4/2025
	 * Aim : Add / Update and View Asset handover
	 */

	function add_asset_data()
	{

		$data1 = array(
			'user_id' => $this->input->post('user_id'),
			'user_code' => $this->input->post('user_code'),
			'desig_id' => $this->input->post('desig_id'),
			'dept_id' => $this->input->post('dept_id'),
			'sim_description' => $this->input->post('sim_desc'),
			'sim_serial_number' => $this->input->post('sim_num'),
			'sim_issued' => $this->input->post('sim_issue'),
			'sim_return' => $this->input->post('sim_return'),
			'laptop_description' => $this->input->post('lap_desc'),
			'laptop_serial_number' => $this->input->post('lap_num'),
			'laptop_issued' => $this->input->post('lap_issue'),
			'laptop_return' => $this->input->post('lap_return'),
			'mobile_description' => $this->input->post('mob_desc'),
			'mobile_serial_number' => $this->input->post('mob_num'),
			'mobile_issued' => $this->input->post('mob_issue'),
			'mobile_return' => $this->input->post('mob_return'),
			'vehicle_description' => $this->input->post('veh_desc'),
			'vehicle_serial_number' => $this->input->post('veh_num'),
			'vehicle_issued' => $this->input->post('veh_issue'),
			'vehicle_return' => $this->input->post('veh_return'),
			'other_description' => $this->input->post('oth_desc'),
			'other_serial_number' => $this->input->post('oth_num'),
			'other_issued' => $this->input->post('oth_issue'),
			'other_return' => $this->input->post('oth_return'),
			'created_at' => date("Y-m-d H:i:s")
		);

		$this->db->insert('employee_asset_handover', $data1);


		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_asset_handover', 'asset_id', $insert_id);

			$assate_id = $this->input->post('user_id');
			$notice = add_notification($insert_id, $assate_id, "Asset Handover Successfully", "Hr/edit_asset/$insert_id");

			return true;
		} else {
			return false;
		}
	}

	function get_all_asset_details()
	{
		$query = $this->db->query("
			SELECT asset.*, us.*,dpt.*,dm.*
			FROM employee_asset_handover AS asset
			LEFT JOIN users AS us ON asset.user_id = us.user_id
			LEFT JOIN designation_master AS dm ON asset.desig_id = dm.did
			LEFT JOIN department_master AS dpt ON asset.dept_id = dpt.dept_id
			ORDER BY asset.created_at DESC;
		");
		return $query->result();
	}

	function get_asset_details_by_id($id)
	{
		$query = $this->db->query("
			SELECT * 
			FROM employee_asset_handover 
			WHERE asset_id = '$id'
		");

		return $query->row();
	}

	function update_asset_data()
	{

		$id = $this->input->post('asset_id');

		if ($_FILES["asset_file_upload"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["asset_file_upload"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$asset_file = '';

			if (($_FILES["asset_file_upload"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
				if ($_FILES["asset_file_upload"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["asset_file_upload"]["tmp_name"];
					$asset_file = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "public/uploded_documents/" . $asset_file); ///home/webadmin/gen/Hundredmedia/public/uploded_documents/
				}
			} else {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			}
		}

		$data1 = array(
			'user_id' => $this->input->post('user_id'),
			'user_code' => $this->input->post('user_code'),
			'desig_id' => $this->input->post('desig_id'),
			'dept_id' => $this->input->post('dept_id'),
			'asset_doc_path' => $asset_file,
			'sim_description' => $this->input->post('sim_desc'),
			'sim_serial_number' => $this->input->post('sim_num'),
			'sim_issued' => $this->input->post('sim_issue'),
			'sim_return' => $this->input->post('sim_return'),
			'laptop_description' => $this->input->post('lap_desc'),
			'laptop_serial_number' => $this->input->post('lap_num'),
			'laptop_issued' => $this->input->post('lap_issue'),
			'laptop_return' => $this->input->post('lap_return'),
			'mobile_description' => $this->input->post('mob_desc'),
			'mobile_serial_number' => $this->input->post('mob_num'),
			'mobile_issued' => $this->input->post('mob_issue'),
			'mobile_return' => $this->input->post('mob_return'),
			'vehicle_description' => $this->input->post('veh_desc'),
			'vehicle_serial_number' => $this->input->post('veh_num'),
			'vehicle_issued' => $this->input->post('veh_issue'),
			'vehicle_return' => $this->input->post('veh_return'),
			'other_description' => $this->input->post('oth_desc'),
			'other_serial_number' => $this->input->post('oth_num'),
			'other_issued' => $this->input->post('oth_issue'),
			'other_return' => $this->input->post('oth_return'),
			'emp_signature' => $this->input->post('emp_signature'),
			'emp_signature_date' => date('Y-m-d', strtotime($this->input->post('emp_signature_date'))),
			'dept_head_signature' => $this->input->post('hod_signature'),
			'dept_head_signature_date' => date('Y-m-d', strtotime($this->input->post('hod_signature_date'))),
			'hr_signature' => $this->input->post('hr_signature'),
			'hr_signature_date' => date('Y-m-d', strtotime($this->input->post('hr_signature_date'))),
		);
		//print_r($data1);die;
		$this->db->where('asset_id', $id);
		$res = $this->db->update('employee_asset_handover', $data1);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_asset_handover', 'asset_id', $id);
			$assate_id = $this->input->post('user_id');
			$notice = add_notification($id, $assate_id, "Asset Handover Update Successfully", "Hr/edit_asset/$id");

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	function get_asset_by_id($id)
	{
		$this->db->select('er.*,u.*,dm.*,des_m.*');
		$this->db->from('employee_asset_handover er');
		$this->db->join('users u', 'u.user_id = er.user_id', 'left');
		$this->db->join('department_master dm', 'dm.dept_id = er.dept_id', 'left');
		$this->db->join('designation_master des_m', 'des_m.did = er.desig_id', 'left');
		$this->db->where('er.asset_id', $id);
		$query = $this->db->get(); //echo $this->db->last_query();die;
		return $query->row();
	}

	/*****
	 * Author : Teena VI
	 * Date : 10/4/2025
	 * Aim : Add / Update and View Employee Checklist
	 */

	function add_checklist_data()
	{


		$fields = [
			'application_form' => 'checklist1',
			'interview_form' => 'checklist2',
			'joining_form' => 'checklist3',
			'cv' => 'checklist4',
			'passport_copy' => 'checklist5',
			'photo_copy' => 'checklist6',
			'offer_letter' => 'checklist7',
			'contract_form' => 'checklist8',
			'insurance_form' => 'checklist9',
			'labor_payment_form' => 'checklist10',
			'medical_fit_certificate' => 'checklist11',
			'emirates_id' => 'checklist12',
			'visa_copy' => 'checklist13',
			'iloe_insurance' => 'checklist14',
			'labor_card' => 'checklist15',
			'degree_certificate' => 'checklist16',
			'induction' => 'checklist17',
			'job_description' => 'checklist18',
			'driving_license' => 'checklist19'
		];

		$data1 = [
			'user_id' => $this->input->post('user_id'),
			'created_at' => date("Y-m-d H:i:s")
		];

		// Loop through each field and assign value or 'No'
		foreach ($fields as $dbField => $postKey) {
			$value = $this->input->post($postKey);
			$data1[$dbField] = !empty($value) ? $value : 'no';
		}
		//print_r($data1);die;
		$this->db->insert('employee_checklist', $data1);


		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_checklist', 'check_id', $insert_id);

			$user_code = $this->input->post('user_code');
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($insert_id, $current_url, "$user_code Employee Checklist Generate Successfully", "Hr/edit_checklist/$insert_id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////
			/* end notification */
			return true;
		} else {
			return false;
		}
	}

	function get_all_checklist_details()
	{
		$query = $this->db->query("
			SELECT ec.*, us.*, dpt.*, dm.*
			FROM employee_checklist AS ec
			LEFT JOIN users AS us ON ec.user_id = us.user_id
			LEFT JOIN designation_master AS dm ON us.desig_id = dm.did
			LEFT JOIN department_master AS dpt ON us.dept_id = dpt.dept_id
			ORDER BY ec.created_at DESC;

		");
		return $query->result();
	}

	function get_checklist_details_by_id($id)
	{
		$query = $this->db->query("
			SELECT * 
			FROM employee_checklist 
			WHERE check_id = '$id'
		");

		return $query->row();
	}

	function update_checklist_data()
	{

		$id = $this->input->post('check_id');

		if ($_FILES["checklist_file_upload"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["checklist_file_upload"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$check_file = '';

			if (($_FILES["checklist_file_upload"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
				if ($_FILES["checklist_file_upload"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["checklist_file_upload"]["tmp_name"];
					$check_file = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "public/uploded_documents/" . $check_file); ///home/webadmin/gen/Hundredmedia/public/uploded_documents/
				}
			} else {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			}
		}

		$fields = [
			'application_form' => 'checklist1',
			'interview_form' => 'checklist2',
			'joining_form' => 'checklist3',
			'cv' => 'checklist4',
			'passport_copy' => 'checklist5',
			'photo_copy' => 'checklist6',
			'offer_letter' => 'checklist7',
			'contract_form' => 'checklist8',
			'insurance_form' => 'checklist9',
			'labor_payment_form' => 'checklist10',
			'medical_fit_certificate' => 'checklist11',
			'emirates_id' => 'checklist12',
			'visa_copy' => 'checklist13',
			'iloe_insurance' => 'checklist14',
			'labor_card' => 'checklist15',
			'degree_certificate' => 'checklist16',
			'induction' => 'checklist17',
			'job_description' => 'checklist18',
			'driving_license' => 'checklist19'
		];

		$data1 = [
			'user_id' => $this->input->post('user_id'),
			'checklist_doc_path' => $check_file,
			'created_at' => date("Y-m-d H:i:s")
		];

		// Loop through each field and assign value or 'No'
		foreach ($fields as $dbField => $postKey) {
			$value = $this->input->post($postKey);
			$data1[$dbField] = !empty($value) ? $value : 'no';
		}
		//print_r($data1);die;
		$this->db->where('check_id', $id);
		$res = $this->db->update('employee_checklist', $data1);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_checklist', 'check_id', $id);
			$user_code = $this->input->post('user_code');
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "$user_code Employee Checklist Update Successfully", "Hr/edit_checklist/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////
			/* end notification */
			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	function get_checklist_by_id($id)
	{
		$this->db->select('er.*,u.*,dm.*,des_m.*,int.*,u.desig_id as desig_id,u.dept_id as dept_id');
		$this->db->from('employee_checklist er');
		$this->db->join('users u', 'u.user_id = er.user_id', 'left');
		$this->db->join('department_master dm', 'dm.dept_id = u.dept_id', 'left');
		$this->db->join('designation_master des_m', 'des_m.did = u.desig_id', 'left');
		$this->db->join('employee_interview int', 'int.int_id = u.int_id', 'left');
		$this->db->where('er.check_id', $id);
		$query = $this->db->get(); //echo $this->db->last_query();die;
		return $query->row();
	}

	function get_user_record_by_id_interview($id)
	{
		$query = $this->db->query("
			SELECT * 
			FROM employee_interview 
			WHERE int_id = '$id'
		");
		//echo $this->db->last_query();die;
		return $query->row();
	}

	public function leave_hr_admin_ceo_list()
	{
		$query = $this->db->query("
        SELECT 
            a.*,
            u1.username AS hr_user_name, 
            u1.id AS hr_user_id, 
            u2.username AS admin_md_user_name, 
            u2.id AS admin_md_user_id,
			u3.username AS ceo_user_name, 
            u3.id AS ceo_user_id
        FROM approval_setup a
        JOIN users u1 ON a.approve_hr = u1.id
        JOIN users u2 ON a.approve_admin_md = u2.id
		JOIN users u3 ON a.approve_ceo = u3.id and approve_type='Leave'
    ");
		return $query->result();
	}

	/******
	 * Author: Teena VI
	 * Date : 24-04-2025
	 * Aim : Add/Delete and Edit COMpensatory Leave
	 ***/

	public function item_hr_admin_ceo_list($type)
	{
		$query = $this->db->query("SELECT * FROM approval_setup ap join users u on u.user_id=ap.approve_ceo WHERE approve_type='$type'");
		//echo $this->db->last_query();die;
		return $query->result();
	}

	public function item_hr_list($type)
	{
		$query = $this->db->query("SELECT * FROM approval_setup ap join users u on u.user_id=ap.approve_hr WHERE approve_type='$type'");
		//echo $this->db->last_query();die;
		return $query->result();
	}
	function add_compensatory_data()
	{

		$prifix = 'COMP';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'comp_code', 'employee_compensation_master', 6) + 1;
		$digit = sprintf("%1$04d", $num);
		$compcode = $prifix . $digit;


		$data1 = [
			'emp_id' => $this->input->post('user_id'),
			'comp_code' => $compcode,
			'request_date' => date('Y-m-d', strtotime($this->input->post('requestDate'))),
			'reason_by_head' => $this->input->post('reasonByHead'),
			'total_pending_comp_off' => $this->input->post('totalPending'),
			'hod_approved' => 0,
			'hr_approved' => 0,
			'created_by' => $this->session->userdata('user_id'),
			'created_at' => date("Y-m-d H:i:s")
		];


		$this->db->insert('employee_compensation_master', $data1);


		$insert_id = $this->db->insert_id();
		if ($insert_id) {

			$workedDates = $this->input->post('workedDate');
			$explanations = $this->input->post('explanation');
			$hoursWorked = $this->input->post('hoursWorked');
			$offTakenDates = $this->input->post('offTakenDate');
			$pendingCompOffs = $this->input->post('pendingCompOff');

			if (!empty($workedDates)) {
				$rowCount = count($workedDates); // Assuming all arrays are the same length

				for ($i = 0; $i < $rowCount; $i++) {
					$hasWorkedDate = !empty($workedDates[$i]);
					$hasOffTakenDate = !empty($offTakenDates[$i]);

					// Insert if at least one of worked_date or off_taken_date is present
					if ($hasWorkedDate || $hasOffTakenDate) {
						$data1 = [
							'compensation_id' => $insert_id,
							'worked_date' => $hasWorkedDate ? $workedDates[$i] : null,
							'explanation' => isset($explanations[$i]) ? $explanations[$i] : null,
							'hours_worked' => isset($hoursWorked[$i]) ? $hoursWorked[$i] : null,
							'off_taken_date' => $hasOffTakenDate ? $offTakenDates[$i] : null,
							'pending_comp_off' => isset($pendingCompOffs[$i]) ? $pendingCompOffs[$i] : null,
						];

						$this->db->insert('employee_compensation_entries', $data1);
					}
				}
			}
		} else {
			return false;
		}
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_compensation_master', 'id', $insert_id);
		return true;
	}

	function get_all_compensatory_details()
	{
		$query = $this->db->query("
		SELECT cm.*,u.user_name,u.middle_name,u.last_name FROM employee_compensation_master AS cm left join users as u on cm.emp_id = u.user_id ORDER BY request_date DESC");
		return $query->result();
	}

	function get_compensatory_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM employee_compensation_master  WHERE id='$id'");
		return $query->row();
	}

	function get_compensatory_details_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM employee_compensation_entries WHERE compensation_id ='$id' ORDER BY id ASC");
		return $query->result();
	}

	function update_compensatory_data()
	{

		$id = $this->input->post('comp_id');

		$data1 = [
			'request_date' => date('Y-m-d', strtotime($this->input->post('requestDate'))),
			'reason_by_head' => $this->input->post('reasonByHead'),
			'total_pending_comp_off' => $this->input->post('totalPending'),
			'hod_approved' => $this->input->post('hod'),
			'hr_approved' => $this->input->post('hr'),
		];


		$this->db->where('id', $id);
		$res = $this->db->update('employee_compensation_master', $data1);

		$comp_entry_id = $this->input->post('comp_entry_id');
		$workedDates = $this->input->post('workedDate');
		$explanations = $this->input->post('explanation');
		$hoursWorked = $this->input->post('hoursWorked');
		$offTakenDates = $this->input->post('offTakenDate');
		$pendingCompOffs = $this->input->post('pendingCompOff');

		if (!empty($pendingCompOffs)) {

			$rowCount = count($pendingCompOffs); // Assuming all arrays are the same length

			for ($i = 0; $i < $rowCount; $i++) {
				$hasWorkedDate = !empty($workedDates[$i]);
				$hasOffTakenDate = !empty($offTakenDates[$i]);

				// Insert if at least one of worked_date or off_taken_date is present
				if ($hasWorkedDate || $hasOffTakenDate) {

					$data = [
						'compensation_id' => $id,
						'worked_date' => $hasWorkedDate ? $workedDates[$i] : null,
						'explanation' => isset($explanations[$i]) ? $explanations[$i] : null,
						'hours_worked' => isset($hoursWorked[$i]) ? $hoursWorked[$i] : null,
						'off_taken_date' => $hasOffTakenDate ? $offTakenDates[$i] : null,
						'pending_comp_off' => isset($pendingCompOffs[$i]) ? $pendingCompOffs[$i] : null,
					];

					if (!empty($comp_entry_id[$i])) {
						$this->db->where('id', $comp_entry_id[$i]);
						$res = $this->db->update('employee_compensation_entries', $data);
					} else {
						$this->db->insert('employee_compensation_entries', $data);
					}
				}
			}
		}

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_checklist', 'check_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	/******
	 * Author: Teena VI
	 * Date : 30-04-2025
	 * Aim : Add/Delete and Edit Clearance Data
	 ***/

	function add_clearance_data()
	{

		$prifix = 'CLR';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'clearance_code', 'employee_clearance_master', 5) + 1;
		$digit = sprintf("%1$04d", $num);
		$compcode = $prifix . $digit;

		$status = $this->input->post('status');
		$overall_approval = (in_array(0, $status) || in_array(2, $status)) ? 0 : 1; //0-pending.1-approved

		$data1 = [
			'user_id' => $this->input->post('user_id'),
			'clearance_code' => $compcode,
			'resignation_date' => date('Y-m-d', strtotime($this->input->post('resig_date'))),
			'relieving_date' => date('Y-m-d', strtotime($this->input->post('relieving_date'))),
			'notice_period_in_days' => $this->input->post('notice_period'),
			'overall_approval' => $overall_approval,
			'created_by' => $this->session->userdata('user_id'),
			'created_at' => date("Y-m-d H:i:s")
		];


		$this->db->insert('employee_clearance_master', $data1);


		$insert_id = $this->db->insert_id();
		if ($insert_id) {

			$row_dept_id = $this->input->post('row_dept_id');
			$activity = $this->input->post('activity');
			$status = $this->input->post('status');

			if (!empty($row_dept_id)) {
				$rowCount = count($row_dept_id); // Assuming all arrays are the same length

				for ($i = 0; $i < $rowCount; $i++) {

					$data1 = [
						'clearance_id' => $insert_id,
						'dept_id' => $row_dept_id[$i],
						'activity' => $activity[$i],
						'status' => $status[$i],
					];

					$this->db->insert('employee_clearance_entries', $data1);
				}
			}
		} else {
			return false;
		}
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_clearance_master', 'clearance_id', $insert_id);
		return true;
	}

	function get_all_clearance_details()
	{
		$query = $this->db->query("SELECT cm.*,u.user_name,u.middle_name,u.last_name FROM employee_clearance_master AS cm left join users as u on cm.user_id = u.user_id ORDER BY created_date DESC");
		return $query->result();
	}

	function get_clearance_by_id($id)
	{
		$query = $this->db->query("SELECT 
									cm.*, 
									u.user_name, u.middle_name, u.last_name, u.bdate, u.user_code, 
									u.dept_id, u.desig_id, u.joining_date, 
									d.dept_name, 
									dm.designation_name 
								FROM 
									employee_clearance_master AS cm 
								LEFT JOIN 
									users AS u ON cm.user_id = u.user_id
								LEFT JOIN 
									department_master AS d ON d.dept_id = u.dept_id 
								LEFT JOIN 
									designation_master AS dm ON dm.did = u.desig_id 
								WHERE 
									cm.clearance_id = '$id'");
		return $query->row();
	}

	function get_clearance_details_by_id($id)
	{
		$query = $this->db->query("SELECT ce.*,d.dept_name FROM employee_clearance_entries ce 
									LEFT JOIN 
										department_master AS d ON d.dept_id = ce.dept_id 
									WHERE 
										ce.clearance_id ='$id' ORDER BY ce.clearance_id ASC");
		return $query->result();
	}

	function update_clearance_data()
	{

		$id = $this->input->post('clearance_id');
		$result = $this->get_clearance_details_by_id($id);
		$entry_ids = array();
		$data1 = array();

		foreach ($result as $row) {
			$entry_ids[] = $row->clearance_entry_id;
		}

		// Delete Entries
		$posted_ids = $this->input->post('clearance_entry_id');

		// Find IDs that are in $entry_ids but not in $posted_ids
		$ids_to_delete = array_diff($entry_ids, $posted_ids);

		// Delete those IDs from the database
		if (!empty($ids_to_delete)) {
			foreach ($ids_to_delete as $delete_id) {
				$this->db->where('clearance_entry_id', $delete_id);
				$this->db->delete('employee_clearance_entries'); // Replace with actual table name
			}
		}

		if (!empty($_FILES["clearance_form_upld"]['name'])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			if ($_FILES['clearance_form_upld']["name"] != '' || !empty($_FILES['clearance_form_upld']["name"])) {
				$data['file_name'] = $_FILES["clearance_form_upld"]["name"];

				$fname = $_FILES["clearance_form_upld"]["name"];
				$temp = explode(".", $_FILES["clearance_form_upld"]["name"]);
				$extension = end($temp);
				$other_file = '';
				if (($_FILES["clearance_form_upld"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
					if ($_FILES["clearance_form_upld"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["clearance_form_upld"]["tmp_name"];
						$data1['document_name'] = $timestamp1 . "_" . $_FILES['clearance_form_upld']['name'];
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);
					}
				}
			}
		}

		$status = $this->input->post('status');
		$overall_approval = (in_array(0, $status) || in_array(2, $status)) ? 0 : 1; //0-pending.1-approved
		$data1['resignation_date'] = date('Y-m-d', strtotime($this->input->post('resig_date')));
		$data1['relieving_date'] = date('Y-m-d', strtotime($this->input->post('relieving_date')));
		$data1['notice_period_in_days'] = $this->input->post('notice_period');
		$data1['overall_approval'] = $overall_approval;


		$this->db->where('clearance_id', $id);
		$res = $this->db->update('employee_clearance_master', $data1);

		$clearance_entry_id = $this->input->post('clearance_entry_id');
		$row_dept_id = $this->input->post('row_dept_id');
		$activity = $this->input->post('activity');
		$status = $this->input->post('status');

		if (!empty($row_dept_id)) {

			$rowCount = count($row_dept_id); // Assuming all arrays are the same length

			for ($i = 0; $i < $rowCount; $i++) {

				$data = [
					'clearance_id' => $id,
					'dept_id' => $row_dept_id ? $row_dept_id[$i] : null,
					'activity' => isset($activity[$i]) ? $activity[$i] : null,
					'status' => isset($status[$i]) ? $status[$i] : null,
				];

				if (!empty($clearance_entry_id[$i])) {
					$this->db->where('clearance_entry_id', $clearance_entry_id[$i]);
					$res = $this->db->update('employee_clearance_entries', $data);
				} else {
					$this->db->insert('employee_clearance_entries', $data);
				}
			}
		}


		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_clearance_master', 'clearance_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	/******
	 * Author: Teena VI
	 * Date : 2-05-2025
	 * Aim : Add/Delete and Edit Performance Review Data
	 ***/

	function add_review_data()
	{

		$prifix = 'REV';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'review_code', 'employee_review_master', 5) + 1;
		$digit = sprintf("%1$04d", $num);
		$reviewcode = $prifix . $digit;

		$data1 = [
			'user_id' => $this->input->post('user_id'),
			'review_code' => $reviewcode,
			'review_period_from' => $this->input->post('from_month'),
			'review_period_to' => $this->input->post('to_month'),
			'review_date' => $this->input->post('review_date'),
			'overall_rating' => $this->input->post('overall_rating'),
			'comments' => $this->input->post('comments'),
			'improvements' => $this->input->post('improvements'),
			'goals' => $this->input->post('goals'),
			'self_assessment_good' => $this->input->post('self_assessment_good'),
			'self_assessment_improve' => $this->input->post('self_assessment_improve'),
			'manager_comment' => $this->input->post('manager_comment'),
			'created_by' => $this->session->userdata('user_id'),
			'created_at' => date("Y-m-d H:i:s")
		];

		$this->db->insert('employee_review_master', $data1);

		$insert_id = $this->db->insert_id();
		if ($insert_id) {

			foreach ($_POST as $key => $value) {
				// General Criteria
				if (strpos($key, 'criteria_') === 0 && strpos($key, '_comment') === false && strpos($key, '_label') === false) {
					$index = explode('_', $key)[1];
					$label = $this->input->post("criteria_{$index}_label");
					$rating = $this->input->post("criteria_{$index}");
					$comment = $this->input->post("criteria_{$index}_comment");

					$data = [
						'review_id' => $insert_id,
						'criteria' => $label,
						'rating' => $rating,
						'comments' => $comment,
					];
					$this->db->insert('employee_review_entries', $data);
				}
			}
		} else {
			return false;
		}

		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_review_master', 'review_id', $insert_id);
		return true;
	}

	// function get_all_review_details()
	// {
	// 	$query = $this->db->query("SELECT cm.*,u.user_name,u.middle_name,u.last_name,d.dept_name,dm.designation_name FROM employee_review_master AS cm left join users as u on cm.user_id = u.user_id left join department_master as d on d.dept_id = u.dept_id left join designation_master as dm on dm.did = u.desig_id ORDER BY cm.created_at DESC");
	// 	return $query->result();
	// }
	function get_all_review_details()
	{
		$query = $this->db->query("
        SELECT 
            cm.*, 
            u.user_name, 
            u.middle_name, 
            u.last_name, 
            d.dept_name, 
            dm.designation_name,
            hod.user_name AS created_by_name
        FROM 
            employee_review_master AS cm 
        LEFT JOIN 
            users AS u ON cm.user_id = u.user_id
        LEFT JOIN 
            department_master AS d ON d.dept_id = u.dept_id 
        LEFT JOIN 
            designation_master AS dm ON dm.did = u.desig_id 
        LEFT JOIN 
            users AS hod ON hod.user_id = cm.created_by
        ORDER BY 
            cm.created_at DESC
    ");
		return $query->result();
	}

	// function get_review_by_id($id)
	// {
	// 	$query = $this->db->query("SELECT 
	// 								cm.*, 
	// 								u.user_name, u.middle_name, u.last_name, u.bdate, u.user_code, 
	// 								u.dept_id, u.desig_id, u.joining_date, 
	// 								d.dept_name, 
	// 								dm.designation_name 
	// 							FROM 
	// 								employee_review_master AS cm 
	// 							LEFT JOIN 
	// 								users AS u ON cm.user_id = u.user_id
	// 							LEFT JOIN 
	// 								department_master AS d ON d.dept_id = u.dept_id 
	// 							LEFT JOIN 
	// 								designation_master AS dm ON dm.did = u.desig_id 
	// 							WHERE 
	// 								cm.review_id = '$id'");
	// 	return $query->row();
	// }
	function get_review_by_id($id)
	{
		$query = $this->db->query("
        SELECT 
            cm.*, 
            u.user_name, u.middle_name, u.last_name, u.bdate, u.user_code, 
            u.dept_id, u.desig_id, u.joining_date, 
            d.dept_name, 
            dm.designation_name,
            created_by_user.user_name AS created_by_name
        FROM 
            employee_review_master AS cm 
        LEFT JOIN 
            users AS u ON cm.user_id = u.user_id
        LEFT JOIN 
            department_master AS d ON d.dept_id = u.dept_id 
        LEFT JOIN 
            designation_master AS dm ON dm.did = u.desig_id 
        LEFT JOIN 
            users AS created_by_user ON created_by_user.user_id = cm.created_by
        WHERE 
            cm.review_id = '$id'
    ");
		return $query->row();
	}

	function get_review_details_by_id($id)
	{
		$query = $this->db->query("SELECT ce.* FROM employee_review_entries ce 
									WHERE 
										ce.review_id ='$id' ORDER BY ce.entry_id ASC");
		return $query->result();
	}

	function update_review_data()
	{

		$id = $this->input->post('review_id');
		$result = $this->get_review_details_by_id($id);
		$data1 = array();


		if (!empty($_FILES["review_form_upld"]['name'])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			if ($_FILES['review_form_upld']["name"] != '' || !empty($_FILES['review_form_upld']["name"])) {
				$data['file_name'] = $_FILES["review_form_upld"]["name"];

				$fname = $_FILES["review_form_upld"]["name"];
				$temp = explode(".", $_FILES["review_form_upld"]["name"]);
				$extension = end($temp);
				$other_file = '';
				if (($_FILES["review_form_upld"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
					if ($_FILES["review_form_upld"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["review_form_upld"]["tmp_name"];
						$data1['review_doc_path'] = $timestamp1 . "_" . $_FILES['review_form_upld']['name'];
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);
					}
				}
			}
		}

		$data1['review_period_from'] = $this->input->post('from_month');
		$data1['review_period_to'] = $this->input->post('to_month');
		$data1['review_date'] = date('Y-m-d', strtotime($this->input->post('review_date')));
		$data1['overall_rating'] = $this->input->post('overall_rating');
		$data1['comments'] = $this->input->post('comments');
		$data1['improvements'] = $this->input->post('improvements');
		$data1['goals'] = $this->input->post('goals');
		$data1['self_assessment_good'] = $this->input->post('self_assessment_good');
		$data1['self_assessment_improve'] = $this->input->post('self_assessment_improve');
		$data1['manager_comment'] = $this->input->post('manager_comment');
		$data1['requested_by'] = $this->session->userdata('user_id');
		$data1['hr_approval'] = $this->input->post('hr_approval');
		$data1['ceo_approval'] = $this->input->post('ceo_approval');
		$data1['hr_id'] = $this->input->post('hr_id');
		$data1['ceo_id'] = $this->input->post('ceo_id');

		$this->db->where('review_id', $id);
		$res = $this->db->update('employee_review_master', $data1);

		$review_entry_id = $this->input->post('entry_id');

		if (!empty($review_entry_id)) {

			$rowCount = count($review_entry_id); // Assuming all arrays are the same length

			for ($i = 1; $i <= $rowCount; $i++) {

				$rating = $this->input->post("criteria_{$i}");
				$comment = $this->input->post("criteria_{$i}_comment");
				echo $comment;
				$data = [
					'rating' => $rating,
					'comments' => $comment,
				];

				$this->db->where('entry_id', $review_entry_id[$i]);
				$res = $this->db->update('employee_review_entries', $data);
			}
		}


		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_review_master', 'review_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	/******
	 * Author: Teena VI
	 * Date : 5-05-2025
	 * Aim : Add/Delete and Edit Employment Application
	 ***/

	function add_employment_data()
	{

		$prifix = 'APP';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'emp_app_code', 'employment_application_master', 6) + 1;
		$digit = sprintf("%1$04d", $num);
		$appcode = $prifix . $digit;

		$other_file = '';
		if (!empty($_FILES["profile_pic"]['name'])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			if ($_FILES['profile_pic']["name"] != '' || !empty($_FILES['profile_pic']["name"])) {
				$data['file_name'] = $_FILES["profile_pic"]["name"];

				$fname = $_FILES["profile_pic"]["name"];
				$temp = explode(".", $_FILES["profile_pic"]["name"]);
				$extension = end($temp);

				if (($_FILES["profile_pic"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
					if ($_FILES["profile_pic"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["profile_pic"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $_FILES['profile_pic']['name'];
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);
					}
				}
			}
		}

		$sign_file = '';
		if (!empty($_FILES["emp_sign"]['name'])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			if ($_FILES['emp_sign']["name"] != '' || !empty($_FILES['emp_sign']["name"])) {
				$data['file_name'] = $_FILES["emp_sign"]["name"];

				$fname = $_FILES["emp_sign"]["name"];
				$temp = explode(".", $_FILES["emp_sign"]["name"]);
				$extension = end($temp);

				if (($_FILES["emp_sign"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
					if ($_FILES["emp_sign"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["emp_sign"]["tmp_name"];
						$sign_file = $timestamp1 . "_" . $_FILES['emp_sign']['name'];
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $sign_file);
					}
				}
			}
		}


		$data = [
			'emp_app_code' => $appcode,
			'position_applied' => $this->input->post('desig_id'),
			'application_date' => date('Y-m-d', strtotime($this->input->post('application_date'))),
			'applicant_name' => $this->input->post('applicant_name'),
			'profile_pic' => $other_file,
			'date_of_birth' => $this->input->post('dob'),
			'age' => $this->input->post('age'),
			'contact_number' => $this->input->post('contact_number'),
			'driving_license' => $this->input->post('driving_license'),
			'passport_no' => $this->input->post('passport_no'),
			'passport_expiry' => $this->input->post('passport_expiry'),
			'visa_status' => $this->input->post('visa'),
			'visa_expiry' => $this->input->post('visa_expiry'),
			'eid_no' => $this->input->post('eid_no'),
			'eid_expiry' => $this->input->post('eid_expiry'),
			'reason_change' => $this->input->post('reason_change'),
			'achievements' => $this->input->post('achievements'),
			'notice_period' => $this->input->post('notice_period'),
			'curr_employer' => $this->input->post('curr_employer'),
			'curr_designation' => $this->input->post('curr_designation'),
			'curr_salary' => $this->input->post('curr_salary'),
			'curr_work_from' => $this->input->post('curr_work_from'),
			'curr_work_to' => $this->input->post('curr_work_to'),
			'curr_responsibilities' => $this->input->post('curr_responsibilities'),
			'curr_course' => $this->input->post('curr_course'),
			'curr_medication' => $this->input->post('curr_medication'),
			'candidate_sign' => $sign_file,
			'created_at' => date("Y-m-d H:i:s")
		];


		$this->db->insert('employment_application_master', $data);


		$insert_id = $this->db->insert_id();
		if ($insert_id) {

			$qualification = $this->input->post('qualification');
			$institute = $this->input->post('institute');
			$grade = $this->input->post('grade');
			$month = $this->input->post('passout_month');
			$year = $this->input->post('passout_year');

			if (!empty($qualification)) {
				$rowCount = count($qualification); // Assuming all arrays are the same length

				for ($i = 0; $i < $rowCount; $i++) {
					$data1 = [
						'emp_app_id' => $insert_id,
						'qualification' => $qualification[$i],
						'institute' => $institute[$i],
						'grade' => $grade[$i],
						'passout_month' => $month[$i],
						'passout_year' => $year[$i],
					];

					$this->db->insert('employment_application_education', $data1);
				}
			}

			$name = $this->input->post('name');
			$relationship = $this->input->post('relationship');
			$occupation = $this->input->post('occupation');
			$contact = $this->input->post('contact');

			if (!empty($contact)) {
				$rowCount = count($contact); // Assuming all arrays are the same length

				for ($i = 0; $i < $rowCount; $i++) {
					$data2 = [
						'emp_app_id' => $insert_id,
						'name' => $name[$i],
						'relation' => $relationship[$i],
						'occupation' => $occupation[$i],
						'contact_no' => $contact[$i],
					];

					$this->db->insert('employment_application_family', $data2);
				}
			}

			$company_worked = $this->input->post('company_worked');
			$worked_from = $this->input->post('worked_from');
			$worked_to = $this->input->post('worked_to');
			$position = $this->input->post('position');
			$responsibilities = $this->input->post('responsibilities');

			if (!empty($company_worked)) {
				$rowCount = count($company_worked); // Assuming all arrays are the same length

				for ($i = 0; $i < $rowCount; $i++) {
					$data2 = [
						'emp_app_id' => $insert_id,
						'company_name' => $company_worked[$i],
						'work_from' => $worked_from[$i],
						'work_to' => $worked_to[$i],
						'position' => $position[$i],
						'responsibilities' => $responsibilities[$i],
					];

					$this->db->insert('employment_application_work', $data2);
				}
			}
		} else {
			return false;
		}
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employment_application_master', 'emp_app_id', $insert_id);
		/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
		$full_path = $_SERVER['REQUEST_URI'];
		$relative_path = strstr($full_path, 'index.php/');
		if ($relative_path) {
			$relative_path = str_replace('index.php/', '', $relative_path);
		}
		log_message('error', $full_path);
		$segments = explode('/', $relative_path);
		$current_url = '';
		if (isset($segments[0]) && isset($segments[1])) {
			$current_url = $segments[0] . '/' . $segments[1];
		}
		log_message('error', $current_url);
		$created_id = $this->session->userdata('user_id');
		$this->load->helper('log');
		$notice = add_notification_in_master($insert_id, $current_url, "New Employment Application $appcode", "Hr/edit_employment/$insert_id");

		/////////////////////////////////////////end notification manage////////////////////////////////////////////

		return true;
	}

	function get_all_employment_details()
	{
		$query = $this->db->query("
		SELECT em.* FROM employment_application_master AS em ORDER BY em.application_date DESC");
		return $query->result();
	}

	function get_employment_by_id($id)
	{
		$query = $this->db->query("SELECT em.*,dm.designation_name FROM employment_application_master AS em left join designation_master AS dm ON dm.did = em.position_applied  WHERE emp_app_id='$id'");
		return $query->row();
	}

	function get_employment_work_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM employment_application_work WHERE emp_app_id ='$id' ");
		return $query->result();
	}

	function get_employment_family_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM employment_application_family WHERE emp_app_id ='$id' ");
		return $query->result();
	}

	function get_employment_education_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM employment_application_education WHERE emp_app_id ='$id' ");
		return $query->result();
	}


	function update_employment_data()
	{

		$id = $this->input->post('emp_app_id');
		$data_1 = array();

		if ($_FILES["profile_pic"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			if ($_FILES['profile_pic']["name"] != '' || !empty($_FILES['profile_pic']["name"])) {
				$data['file_name'] = $_FILES["profile_pic"]["name"];

				$fname = $_FILES["profile_pic"]["name"];
				$temp = explode(".", $_FILES["profile_pic"]["name"]);
				$extension = end($temp);

				if (($_FILES["profile_pic"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
					if ($_FILES["profile_pic"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["profile_pic"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $_FILES['profile_pic']['name'];
						$data_1['profile_pic'] = $other_file;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);
					}
				}
			}
		}

		if ($_FILES["emp_sign"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			if ($_FILES['emp_sign']["name"] != '' || !empty($_FILES['emp_sign']["name"])) {
				$data['file_name'] = $_FILES["emp_sign"]["name"];

				$fname = $_FILES["emp_sign"]["name"];
				$temp = explode(".", $_FILES["emp_sign"]["name"]);
				$extension = end($temp);

				if (($_FILES["emp_sign"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
					if ($_FILES["emp_sign"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["emp_sign"]["tmp_name"];
						$sign_file = $timestamp1 . "_" . $_FILES['emp_sign']['name'];
						$data_1['candidate_sign'] = $sign_file;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $sign_file);
					}
				}
			}
		} //echo '$sign_file-'.$sign_file;echo '$profile_pic-'.$other_file;die;

		$ed_ids = array();
		$work_ids = array();
		$result1 = $this->get_employment_work_by_id($id);
		$result2 = $this->get_employment_education_by_id($id);
		foreach ($result1 as $row) {
			$work_ids[] = $row->work_id;
		}
		foreach ($result2 as $row2) {
			$ed_ids[] = $row2->ed_id;
		}

		// Delete Entries
		$posted_ed_id = $this->input->post('ed_id');
		$posted_work_id = $this->input->post('work_id');

		// Find IDs that are in $entry_ids but not in $posted_ids
		$workids_to_delete = array_diff($work_ids, $posted_work_id);
		$edids_to_delete = array_diff($ed_ids, $posted_ed_id);

		// Delete those IDs from the database
		if (!empty($workids_to_delete)) {
			foreach ($workids_to_delete as $delete_id) {
				$this->db->where('work_id', $delete_id);
				$this->db->delete('employment_application_work'); // Replace with actual table name
			}
		}
		// Delete those IDs from the database
		if (!empty($edids_to_delete)) {
			foreach ($edids_to_delete as $delete_id) {
				$this->db->where('ed_id', $delete_id);
				$this->db->delete('employment_application_education'); // Replace with actual table name
			}
		}

		$data_1['position_applied'] = $this->input->post('desig_id');
		$data_1['application_date'] = date('Y-m-d', strtotime($this->input->post('application_date')));
		$data_1['applicant_name'] = $this->input->post('applicant_name');

		$data_1['date_of_birth'] = $this->input->post('dob');
		$data_1['age'] = $this->input->post('age');
		$data_1['contact_number'] = $this->input->post('contact_number');
		$data_1['driving_license'] = $this->input->post('driving_license');
		$data_1['passport_no'] = $this->input->post('passport_no');
		$data_1['passport_expiry'] = $this->input->post('passport_expiry');
		$data_1['visa_status'] = $this->input->post('visa');
		$data_1['visa_expiry'] = $this->input->post('visa_expiry');
		$data_1['eid_no'] = $this->input->post('eid_no');
		$data_1['eid_expiry'] = $this->input->post('eid_expiry');
		$data_1['reason_change'] = $this->input->post('reason_change');
		$data_1['achievements'] = $this->input->post('achievements');
		$data_1['notice_period'] = $this->input->post('notice_period');
		$data_1['curr_employer'] = $this->input->post('curr_employer');
		$data_1['curr_designation'] = $this->input->post('curr_designation');
		$data_1['curr_salary'] = $this->input->post('curr_salary');
		$data_1['curr_work_from'] = $this->input->post('curr_work_from');
		$data_1['curr_work_to'] = $this->input->post('curr_work_to');
		$data_1['curr_responsibilities'] = $this->input->post('curr_responsibilities');
		$data_1['curr_course'] = $this->input->post('curr_course');
		$data_1['curr_medication'] = $this->input->post('curr_medication');
		$data_1['created_at'] = date("Y-m-d H:i:s"); //print_r($data_1);die;

		$this->db->where('emp_app_id', $id);
		$res = $this->db->update('employment_application_master', $data_1);


		$qualification = $this->input->post('qualification');
		$institute = $this->input->post('institute');
		$grade = $this->input->post('grade');
		$month = $this->input->post('passout_month');
		$year = $this->input->post('passout_year');

		if (!empty($qualification)) {
			$rowCount = count($qualification); // Assuming all arrays are the same length

			for ($i = 0; $i < $rowCount; $i++) {

				$data1 = [
					'emp_app_id' => $id,
					'qualification' => $qualification[$i],
					'institute' => $institute[$i],
					'grade' => $grade[$i],
					'passout_month' => $month[$i],
					'passout_year' => $year[$i],
				];
				if (!empty($posted_ed_id[$i])) {
					$this->db->where('ed_id', $posted_ed_id[$i]);
					$res = $this->db->update('employment_application_education', $data1);
				} else {
					$this->db->insert('employment_application_education', $data1);
				}
			}
		}

		$fam_id = $this->input->post('fam_id');
		$name = $this->input->post('name');
		$relationship = $this->input->post('relationship');
		$occupation = $this->input->post('occupation');
		$contact = $this->input->post('contact');

		if (!empty($contact)) {
			$rowCount = count($contact); // Assuming all arrays are the same length

			for ($i = 0; $i < $rowCount; $i++) {
				$data2 = [
					'emp_app_id' => $id,
					'name' => $name[$i],
					'relation' => $relationship[$i],
					'occupation' => $occupation[$i],
					'contact_no' => $contact[$i],
				];

				if (!empty($fam_id[$i])) {
					$this->db->where('fam_id', $fam_id[$i]);
					$res = $this->db->update('employment_application_family', $data2);
				} else {
					$this->db->insert('employment_application_family', $data2);
				}
			}
		}


		$company_worked = $this->input->post('company_worked');
		$worked_from = $this->input->post('worked_from');
		$worked_to = $this->input->post('worked_to');
		$position = $this->input->post('position');
		$responsibilities = $this->input->post('responsibilities');

		if (!empty($company_worked)) {
			$rowCount = count($company_worked); // Assuming all arrays are the same length

			for ($i = 0; $i < $rowCount; $i++) {
				$data3 = [
					'emp_app_id' => $id,
					'company_name' => $company_worked[$i],
					'work_from' => $worked_from[$i],
					'work_to' => $worked_to[$i],
					'position' => $position[$i],
					'responsibilities' => $responsibilities[$i],
				];
				if (!empty($posted_work_id[$i])) {
					$this->db->where('work_id', $posted_work_id[$i]);
					$res = $this->db->update('employment_application_work', $data3);
				} else {
					$this->db->insert('employment_application_work', $data3);
				}
			}
		}

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employment_application_master', 'emp_app_id', $id);
			/////////////////////////////////////notification manage new format/////////////////////////////////////////////////////////
			$full_path = $_SERVER['REQUEST_URI'];
			$relative_path = strstr($full_path, 'index.php/');
			if ($relative_path) {
				$relative_path = str_replace('index.php/', '', $relative_path);
			}
			log_message('error', $full_path);
			$segments = explode('/', $relative_path);
			$current_url = '';
			if (isset($segments[0]) && isset($segments[1])) {
				$current_url = $segments[0] . '/' . $segments[1];
			}
			log_message('error', $current_url);
			$created_id = $this->session->userdata('user_id');
			$this->load->helper('log');
			$notice = add_notification_in_master($id, $current_url, "Update Employment Application Succefully", "Hr/edit_employment/$id");

			/////////////////////////////////////////end notification manage////////////////////////////////////////////

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	/*******
	 * Author : Teena VI
	 * Aim : CReate , Delete ,Edit and Print Vehicle Handover Details
	 * Date : 07/05/2025
	 */

	// function get_driver_list()
	// {
	// 	$query = $this->db->query("SELECT u.user_name,u.middle_name,u.last_name,u.user_id,vd.traffic_no,vd.vehicle_name FROM vehicle_details AS vd inner join users AS u ON vd.employee_id = u.user_id");
	// 	return $query->result();
	// }

	function get_driver_list()
	{
		$query = $this->db->query("
        SELECT vd.v_id, vd.traffic_no, vd.vehicle_name
        FROM vehicle_details vd
        ORDER BY vd.v_id DESC
    ");
		return $query->result();
	}


	function add_vehicle_handover_data()
	{

		$prifix = 'VHO';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'veh_hndovr_id', 'employee_vehicle_handover', 6) + 1;
		$digit = sprintf("%1$04d", $num);
		$code = $prifix . $digit;

		$vehicle_key = $this->input->post('vehicle_key');
		$vehicle_key = !empty($vehicle_key) ? 'yes' : 'no';

		$mulkiya = $this->input->post('mulkiya');
		$mulkiya = !empty($mulkiya) ? 'yes' : 'no';

		$vehicle_logbook = $this->input->post('vehicle_logbook');
		$vehicle_logbook = !empty($vehicle_logbook) ? 'yes' : 'no';
		$data = [
			'veh_hndovr_code' => $code,
			'driver_id' => $this->input->post('user_id'),
			'handover_date' => date('Y-m-d', strtotime($this->input->post('handover_date'))),
			'licence_plate' => $this->input->post('licence_plate'),
			'vehicle_model' => $this->input->post('vehicle_model'),
			'interior' => $this->input->post('interior'),
			'exterior' => $this->input->post('exterior'),
			'pre_damages' => $this->input->post('pre_damages'),
			'comments' => $this->input->post('comments'),
			'vehicle_key' => $vehicle_key,
			'mulkiya' => $mulkiya,
			'vehicle_logbook' => $vehicle_logbook,
			'inspected_by' => $this->input->post('inspected_by'),
			'hr_admin' => $this->input->post('hr_admin'),
			'approval_status' => $this->input->post('hr_approval'),
			'created_by' => $this->session->userdata('user_id'),
			'created_at' => date("Y-m-d H:i:s")
		];

		$this->db->insert('employee_vehicle_handover', $data);


		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_vehicle_handover', 'veh_hndovr_id', $insert_id);

			$driver_id = $this->input->post('user_id');
			$number_plate = $this->input->post('licence_plate');
			$vehicle_model = $this->input->post('vehicle_model');
			$notice = add_notification($insert_id, $driver_id, "$code,$number_plate,$vehicle_model Vehicle Handover Successfully", "Hr/edit_asset/$insert_id");

			return true;
		} else {
			return false;
		}
	}

	function get_all_vehicle_handover_details()
	{
		$query = $this->db->query("
		SELECT vh.*,u.user_name,u.middle_name,u.last_name FROM employee_vehicle_handover AS vh LEFT JOIN users AS u ON vh.driver_id = u.user_id ORDER BY vh.created_at DESC");
		return $query->result();
	}

	function get_vehicle_handover_by_id($id)
	{
		$query = $this->db->query("SELECT vh.*,u.user_name,u.middle_name,u.last_name,ins.user_name AS inspector_name,ins.middle_name AS inspector_middle_name,ins.last_name AS inspector_last_name FROM employee_vehicle_handover AS vh LEFT JOIN users AS u ON vh.driver_id=u.user_id LEFT JOIN users AS ins ON vh.inspected_by=ins.user_id  WHERE veh_hndovr_id='$id'");
		return $query->row();
	}


	function update_vehicle_handover_data()
	{

		$id = $this->input->post('veh_hndovr_id');
		$data_1 = array();

		if ($_FILES["signed_doc"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			if ($_FILES['signed_doc']["name"] != '' || !empty($_FILES['signed_doc']["name"])) {
				$data['file_name'] = $_FILES["signed_doc"]["name"];

				$fname = $_FILES["signed_doc"]["name"];
				$temp = explode(".", $_FILES["signed_doc"]["name"]);
				$extension = end($temp);

				if (($_FILES["signed_doc"]["size"] < 52428800) && in_array($extension, $allowedExts)) {
					if ($_FILES["signed_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["signed_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $_FILES['signed_doc']['name'];
						$data_1['signed_doc'] = $other_file;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $other_file);
					}
				}
			}
		}

		$vehicle_key = $this->input->post('vehicle_key');
		$vehicle_key = !empty($vehicle_key) ? 'yes' : 'no';

		$mulkiya = $this->input->post('mulkiya');
		$mulkiya = !empty($mulkiya) ? 'yes' : 'no';

		$vehicle_logbook = $this->input->post('vehicle_logbook');
		$vehicle_logbook = !empty($vehicle_logbook) ? 'yes' : 'no';

		//$data_1['driver_id'] = $this->input->post('user_id');
		$data_1['handover_date'] = date('Y-m-d', strtotime($this->input->post('handover_date')));
		$data_1['licence_plate'] = $this->input->post('licence_plate');

		$data_1['vehicle_model'] = $this->input->post('vehicle_model');
		$data_1['interior'] = $this->input->post('interior');
		$data_1['exterior'] = $this->input->post('exterior');
		$data_1['pre_damages'] = $this->input->post('pre_damages');
		$data_1['comments'] = $this->input->post('comments');
		$data_1['vehicle_key'] = $vehicle_key;
		$data_1['mulkiya'] = $mulkiya;
		$data_1['vehicle_logbook'] = $vehicle_logbook;
		$data_1['inspected_by'] = $this->input->post('inspected_by');
		$data_1['hr_admin'] = $this->input->post('hr_admin');
		$data_1['approval_status'] = $this->input->post('hr_approval');

		$this->db->where('veh_hndovr_id', $id);
		$res = $this->db->update('employee_vehicle_handover', $data_1);

		if ($res) {
			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_vehicle_handover', 'veh_hndovr_id', $id);

			$driver_id = $this->input->post('driver_id');
			$number_plate = $this->input->post('licence_plate');
			$vehicle_model = $this->input->post('vehicle_model');
			$notice = add_notification($id, $driver_id, "$number_plate,$vehicle_model Vehicle Handover Update Successfully", "Hr/edit_vehicle_handover/$id");

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}

	/*******
	 * Author : Teena VI
	 * Aim : CReate , Delete ,Edit and Print Offer Letter
	 * Date : 08/05/2025
	 */

	// function add_offer_letter_data()
	// {

	// 	$prifix = 'OFR';
	// 	$this->load->model('Setup_model');
	// 	$num = $this->Setup_model->get_next_code($prifix, 'offer_id', 'employee_offer_letter', 6) + 1;
	// 	$digit = sprintf("%1$04d", $num);
	// 	$code = $prifix . $digit;

	// 	$data = [
	// 		'offer_code' => $code,
	// 		'user_name' => $this->input->post('user_name'),
	// 		'desig_id' => $this->input->post('desig_id'),
	// 		'gender' => $this->input->post('gender'),
	// 		'offer_date' => $this->input->post('offer_date'),
	// 		'manager_id' => $this->input->post('manager_id'),
	// 		'employee_address' => $this->input->post('employee_address'),
	// 		'office_address' => $this->input->post('office_address'),
	// 		// 'offer_body' =>$this->input->post('offer_body'),
	// 		// 'incentive_stucture' => $this->input->post('incentive_stucture'),
	// 		// 'other_benefits' => $this->input->post('other_benefits'),
	// 		// 'annexure_b' => $this->input->post('annexure_b'),
	// 		'created_by' => $this->session->userdata('user_id'),
	// 		'created_at' => date("Y-m-d H:i:s")
	// 	];

	// 	$this->db->insert('employee_offer_letter', $data);


	// 	$insert_id = $this->db->insert_id();
	// 	if ($insert_id) {

	// 		$desc = $this->input->post('desc');
	// 		$monthly = $this->input->post('monthly');
	// 		$annual = $this->input->post('annual');

	// 		if (!empty($monthly)) {
	// 			$rowCount = count($monthly); // Assuming all arrays are the same length

	// 			for ($i = 0; $i < $rowCount; $i++) {

	// 				$data1 = [
	// 					'offer_id' => $insert_id,
	// 					'description' => $desc[$i],
	// 					'monthly' => $monthly[$i],
	// 					'annual' => $annual[$i]
	// 				];
	// 				$this->db->insert('employee_offer_salary', $data1);
	// 			}
	// 		}

	// 		$case = $this->input->post('case');
	// 		$salary = $this->input->post('salary');
	// 		$target_1 = $this->input->post('target_1');
	// 		$incentive_2_percent = $this->input->post('incentive_2_percent');
	// 		$target_2 = $this->input->post('target_2');
	// 		$incentive_5_percent = $this->input->post('incentive_5_percent');

	// 		if (!empty($salary)) {
	// 			$rowCount = count($salary); // Assuming all arrays are the same length

	// 			for ($i = 0; $i < $rowCount; $i++) {

	// 				$data2 = [
	// 					'offer_id' => $insert_id,
	// 					'sal_case' => $case[$i],
	// 					'salary' => $salary[$i],
	// 					'target_1' => $target_1[$i],
	// 					'incentive_2_percent' => $incentive_2_percent[$i],
	// 					'target_2' => $target_2[$i],
	// 					'incentive_5_percent' => $incentive_5_percent[$i],
	// 				];
	// 				$this->db->insert('employee_offer_incentive', $data2);
	// 			}
	// 		}

	// 		$user_se_id = $this->session->userdata('user_id');
	// 		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
	// 		$ci = get_instance();
	// 		$ci->load->helper('log');
	// 		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'employee_offer_letter', 'offer_id', $insert_id);
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }
	function add_offer_letter_data()
	{
		$prefix = 'OFR/' . date('y') . '/';

		// Generate Offer Code
		$this->db->select('offer_code');
		$this->db->like('offer_code', $prefix, 'after');
		$this->db->order_by('offer_id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('employee_offer_letter');

		if ($query->num_rows() > 0) {
			$last_code = $query->row()->offer_code;
			$num = (int)substr(strrchr($last_code, '/'), 1) + 1;
		} else {
			$num = 1;
		}
		$digit = sprintf("%04d", $num);
		$code = $prefix . $digit;

		// Main Offer Letter Data
		$data = [
			'offer_code'       => $code,
			'user_name'        => $this->input->post('user_name'),
			'desig_id'         => $this->input->post('desig_id'),
			'gender'           => $this->input->post('gender'),
			'offer_date'       => $this->input->post('offer_date'),
			'manager_id'       => $this->input->post('manager_id'),
			'employee_address' => $this->input->post('employee_address'),
			'office_address'   => $this->input->post('office_address'),
			'created_by'       => $this->session->userdata('user_id'),
			'created_at'       => date("Y-m-d H:i:s")
		];

		$this->db->insert('employee_offer_letter', $data);
		$insert_id = $this->db->insert_id();

		if ($insert_id) {

			// --- Insert Salary Rows ---
			$desc    = $this->input->post('desc');
			$monthly = $this->input->post('monthly');
			$annual  = $this->input->post('annual');

			if (!empty($monthly) && count($monthly) > 0) {
				for ($i = 0; $i < count($monthly); $i++) {
					if (empty($desc[$i]) && empty($monthly[$i]) && empty($annual[$i])) {
						continue; // Skip empty row
					}
					$this->db->insert('employee_offer_salary', [
						'offer_id'    => $insert_id,
						'description' => $desc[$i],
						'monthly'     => $monthly[$i],
						'annual'      => $annual[$i]
					]);
				}
			}

			// --- Insert Incentive Rows ---
			$case               = $this->input->post('case');
			$salary             = $this->input->post('salary');
			$target_1           = $this->input->post('target_1');
			$incentive_3_percent = $this->input->post('incentive_3_percent');
			$target_2           = $this->input->post('target_2');

			if (!empty($salary) && count($salary) > 0) {
				for ($i = 0; $i < count($salary); $i++) {
					if (empty($case[$i]) && empty($salary[$i]) && empty($target_1[$i]) && empty($incentive_3_percent[$i]) && empty($target_2[$i])) {
						continue; // Skip empty row
					}
					$this->db->insert('employee_offer_incentive', [
						'offer_id'          => $insert_id,
						'sal_case'          => $case[$i],
						'salary'            => $salary[$i],
						'target_1'          => $target_1[$i],
						'incentive_3_percent' => $incentive_3_percent[$i],
						'target_2'          => $target_2[$i]
					]);
				}
			}

			// --- Add log entry ---
			$user_se_id = $this->session->userdata('user_id');
			$page_name  = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			add_log_entry($user_se_id, 1, $page_name[1], 'employee_offer_letter', 'offer_id', $insert_id);

			return true;
		} else {
			return false;
		}
	}

	function get_all_offer_letter_details()
	{
		$query = $this->db->query("
		SELECT ol.*,dm.designation_name FROM employee_offer_letter AS ol LEFT JOIN designation_master AS dm ON dm.did = ol.desig_id ORDER BY ol.created_at DESC");
		return $query->result();
	}

	function get_offer_letter_by_id($id)
	{
		$query = $this->db->query("SELECT ol.*,u.user_name AS manager_name,u.middle_name,u.last_name,u.user_code,u.address,ds.designation_name FROM employee_offer_letter AS ol LEFT JOIN users AS u ON ol.manager_id = u.user_id LEFT JOIN designation_master AS ds ON ds.did = ol.desig_id  WHERE offer_id='$id'");
		return $query->row();
	}

	function get_offer_salary_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM employee_offer_salary  WHERE offer_id='$id'");
		return $query->result();
	}

	function get_offer_incentive_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM employee_offer_incentive  WHERE offer_id='$id'");
		return $query->result();
	}


	// function update_offer_letter_data()
	// {

	// 	$id = $this->input->post('offer_id');
	// 	$data_1 = array();

	// 	$salary_ids = array();
	// 	$incent_ids = array();
	// 	$result1 = $this->get_offer_salary_by_id($id);
	// 	$result2 = $this->get_offer_incentive_by_id($id); //print_r($result2);
	// 	foreach ($result1 as $row) {
	// 		$salary_ids[] = $row->salary_id;
	// 	}
	// 	foreach ($result2 as $row2) {
	// 		$incent_ids[] = $row2->incent_id;
	// 	}

	// 	$posted_salary_id = $this->input->post('salary_id');
	// 	$posted_incent_id = $this->input->post('incent_id');

	// 	// Find IDs that are in $entry_ids but not in $posted_ids
	// 	$salaryids_to_delete = array_diff($salary_ids, $posted_salary_id);
	// 	$incentids_to_delete = array_diff($incent_ids, $posted_incent_id);

	// 	// Delete those IDs from the database
	// 	if (!empty($salaryids_to_delete)) {
	// 		foreach ($salaryids_to_delete as $delete_id) {
	// 			$this->db->where('salary_id', $delete_id);
	// 			$this->db->delete('employee_offer_salary'); // Replace with actual table name
	// 		}
	// 	}
	// 	// Delete those IDs from the database
	// 	if (!empty($incentids_to_delete)) {
	// 		foreach ($incentids_to_delete as $delete_id) {
	// 			$this->db->where('incent_id', $delete_id);
	// 			$this->db->delete('employee_offer_incentive'); // Replace with actual table name
	// 		}
	// 	}

	// 	$data_1['user_name'] = $this->input->post('user_name');
	// 	$data_1['desig_id'] = $this->input->post('desig_id');
	// 	$data_1['gender'] = $this->input->post('gender');
	// 	$data_1['offer_date'] = $this->input->post('offer_date');
	// 	$data_1['manager_id'] = $this->input->post('manager_id');
	// 	$data_1['employee_address'] = $this->input->post('employee_address');
	// 	$data_1['office_address'] = $this->input->post('office_address');

	// 	// $data_1['offer_body'] = $this->input->post('offer_body');
	// 	// $data_1['incentive_stucture'] = $this->input->post('incentive_stucture');
	// 	// $data_1['other_benefits'] = $this->input->post('other_benefits');
	// 	// $data_1['annexure_b'] = $this->input->post('annexure_b');

	// 	$this->db->where('offer_id', $id);
	// 	$res = $this->db->update('employee_offer_letter', $data_1); //echo $this->db->last_query();die;

	// 	$desc = $this->input->post('desc');
	// 	$monthly = $this->input->post('monthly');
	// 	$annual = $this->input->post('annual');

	// 	if (!empty($monthly)) {
	// 		$rowCount = count($monthly); // Assuming all arrays are the same length

	// 		for ($i = 0; $i < $rowCount; $i++) {
	// 			$data1 = [
	// 				'offer_id' => $id,
	// 				'description' => $desc[$i],
	// 				'monthly' => $monthly[$i],
	// 				'annual' => $annual[$i]
	// 			];
	// 			if (!empty($posted_salary_id[$i])) {
	// 				$this->db->where('salary_id', $posted_salary_id[$i]);
	// 				$res = $this->db->update('employee_offer_salary', $data1);
	// 			} else {
	// 				$this->db->insert('employee_offer_salary', $data1);
	// 			}
	// 		}
	// 	}

	// 	$case = $this->input->post('case');
	// 	$salary = $this->input->post('salary');
	// 	$target_1 = $this->input->post('target_1');
	// 	$incentive_2_percent = $this->input->post('incentive_2_percent');
	// 	$target_2 = $this->input->post('target_2');
	// 	$incentive_5_percent = $this->input->post('incentive_5_percent');

	// 	if (!empty($salary)) {
	// 		$rowCount = count($salary); // Assuming all arrays are the same length

	// 		for ($i = 0; $i < $rowCount; $i++) {

	// 			$data2 = [
	// 				'offer_id' => $id,
	// 				'sal_case' => $case[$i],
	// 				'salary' => $salary[$i],
	// 				'target_1' => $target_1[$i],
	// 				'incentive_2_percent' => $incentive_2_percent[$i],
	// 				'target_2' => $target_2[$i],
	// 				'incentive_5_percent' => $incentive_5_percent[$i],
	// 			];

	// 			if (!empty($posted_incent_id[$i])) {
	// 				$this->db->where('incent_id', $posted_incent_id[$i]);
	// 				$res = $this->db->update('employee_offer_incentive', $data2);
	// 			} else {
	// 				$this->db->insert('employee_offer_incentive', $data2);
	// 			}
	// 		}
	// 	}

	// 	if ($res) {


	// 		// Log the update operation
	// 		$user_se_id = $this->session->userdata('user_id');
	// 		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
	// 		$ci = get_instance();
	// 		$ci->load->helper('log');
	// 		$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_offer_letter', 'offer_id', $id);

	// 		return true;
	// 	} else {
	// 		// Handle the case where the update operation fails
	// 		return false;
	// 	}
	// }
	function update_offer_letter_data()
	{

		$id = $this->input->post('offer_id');
		$data_1 = array();

		$salary_ids = array();
		$incent_ids = array();
		$result1 = $this->get_offer_salary_by_id($id);
		$result2 = $this->get_offer_incentive_by_id($id); //print_r($result2);
		foreach ($result1 as $row) {
			$salary_ids[] = $row->salary_id;
		}
		foreach ($result2 as $row2) {
			$incent_ids[] = $row2->incent_id;
		}

		$posted_salary_id = $this->input->post('salary_id');
		$posted_incent_id = $this->input->post('incent_id');

		// Find IDs that are in $entry_ids but not in $posted_ids
		$salaryids_to_delete = array_diff($salary_ids, $posted_salary_id);
		$incentids_to_delete = array_diff($incent_ids, $posted_incent_id);

		// Delete those IDs from the database
		if (!empty($salaryids_to_delete)) {
			foreach ($salaryids_to_delete as $delete_id) {
				$this->db->where('salary_id', $delete_id);
				$this->db->delete('employee_offer_salary'); // Replace with actual table name
			}
		}
		// Delete those IDs from the database
		if (!empty($incentids_to_delete)) {
			foreach ($incentids_to_delete as $delete_id) {
				$this->db->where('incent_id', $delete_id);
				$this->db->delete('employee_offer_incentive'); // Replace with actual table name
			}
		}

		$data_1['user_name'] = $this->input->post('user_name');
		$data_1['desig_id'] = $this->input->post('desig_id');
		$data_1['gender'] = $this->input->post('gender');
		$data_1['offer_date'] = $this->input->post('offer_date');
		$data_1['manager_id'] = $this->input->post('manager_id');
		$data_1['employee_address'] = $this->input->post('employee_address');
		$data_1['office_address'] = $this->input->post('office_address');

		// $data_1['offer_body'] = $this->input->post('offer_body');
		// $data_1['incentive_stucture'] = $this->input->post('incentive_stucture');
		// $data_1['other_benefits'] = $this->input->post('other_benefits');
		// $data_1['annexure_b'] = $this->input->post('annexure_b');

		$this->db->where('offer_id', $id);
		$res = $this->db->update('employee_offer_letter', $data_1); //echo $this->db->last_query();die;

		$desc = $this->input->post('desc');
		$monthly = $this->input->post('monthly');
		$annual = $this->input->post('annual');

		if (!empty($monthly)) {
			$rowCount = count($monthly); // Assuming all arrays are the same length

			for ($i = 0; $i < $rowCount; $i++) {
				$data1 = [
					'offer_id' => $id,
					'description' => $desc[$i],
					'monthly' => $monthly[$i],
					'annual' => $annual[$i]
				];
				if (!empty($posted_salary_id[$i])) {
					$this->db->where('salary_id', $posted_salary_id[$i]);
					$res = $this->db->update('employee_offer_salary', $data1);
				} else {
					$this->db->insert('employee_offer_salary', $data1);
				}
			}
		}

		$case = $this->input->post('case');
		$salary = $this->input->post('salary');
		$target_1 = $this->input->post('target_1');
		$incentive_3_percent = $this->input->post('incentive_3_percent');
		$target_2 = $this->input->post('target_2');
		// $incentive_5_percent = $this->input->post('incentive_5_percent');

		if (!empty($salary)) {
			$rowCount = count($salary); // Assuming all arrays are the same length

			for ($i = 0; $i < $rowCount; $i++) {

				$data2 = [
					'offer_id' => $id,
					'sal_case' => $case[$i],
					'salary' => $salary[$i],
					'target_1' => $target_1[$i],
					'incentive_3_percent' => $incentive_3_percent[$i],
					'target_2' => $target_2[$i],
					// 'incentive_5_percent' => $incentive_5_percent[$i],
				];

				if (!empty($posted_incent_id[$i])) {
					$this->db->where('incent_id', $posted_incent_id[$i]);
					$res = $this->db->update('employee_offer_incentive', $data2);
				} else {
					$this->db->insert('employee_offer_incentive', $data2);
				}
			}
		}

		if ($res) {


			// Log the update operation
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_offer_letter', 'offer_id', $id);

			return true;
		} else {
			// Handle the case where the update operation fails
			return false;
		}
	}
	function get_project_payment_approval()
	{

		$query = $this->db->query(" SELECT pm.project_name,pm.project_code,pr.req_id,pr.request_date,pr.total_amount,pr.build_up_date,pr.dismantling_date,pr.remark,pr.subject,pr.approve,pr.p_priority FROM project_payment_request pr  JOIN  project_master pm ON pr.project_id = pm.project_id  ORDER BY pr.request_date DESC");
		return $query->result();
	}

	/**Added by Sneha Kuriakose */

	public function insert_joining_application_form($data)
	{
		if ($this->db->insert('employee_joining_application', $data)) {
			return $this->db->insert_id(); // return the inserted ID on success
		} else {
			return false;
		}
	}
	/**End */

	/*Added by Sneha Kuriakose for HR Reports*/

	public function get_monthly_leave_report($month, $dept_id = null)
	{
		$this->db->select("
        j.*, 
        u.employee_name, u.employee_code, u.department_id , u.designation_id , 
        d.department_name, 
        des.designation_name,
        lm.leave_status,
        lm.remark AS approve_remark
    ");
		$this->db->from('employee_leave j');
		$this->db->join('employees u', 'j.employee_id = u.employee_id ', 'inner');
		$this->db->join('departments d', 'u.department_id  = d.department_id', 'left');
		$this->db->join('designations des', 'u.designation_id  = des.designation_id ', 'left');
		$this->db->join('leave_approval lm', 'j.leave_id = lm.approval_leave_id', 'left');

		// Filter by selected month (on start_date)
		if (!empty($month)) {
			$this->db->where("DATE_FORMAT(j.start_date, '%Y-%m') =", $month);
		}

		// Filter by department if selected
		if (!empty($dept_id)) {
			$this->db->where('u.department_id', $dept_id);
		}

		$this->db->order_by('j.start_date', 'ASC');

		return $this->db->get()->result();
	}


	// public function get_monthly_attendance_summary($from_date, $to_date, $dept_id = '')
	// {
	// 	$this->db->select("
	//     a.*, 
	//     u.user_code, u.user_name, 
	//     d.dept_name, 
	//     des.designation_name
	// ");
	// 	$this->db->from('employee_attendance a');
	// 	$this->db->join('users u', 'a.employee_id = u.user_id');


	// 	$this->db->join('department_master d', 'u.dept_id = d.dept_id', 'left');
	// 	$this->db->join('designation_master des', 'u.desig_id = des.did', 'left');
	// 	$this->db->where('a.Attendance_date >=', $from_date);
	// 	$this->db->where('a.Attendance_date <=', $to_date);

	// 	if (!empty($dept_id)) {
	// 		$this->db->where('u.dept_id', $dept_id);
	// 	}

	// 	$this->db->order_by('a.Attendance_date', 'ASC');
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }
	public function get_monthly_attendance_summary($from_date, $to_date, $dept_id = '')
	{
		$this->db->select("
        a.*, 
        u.employee_code, 
        u.employee_name, 
        d.department_name,
		u.employee_id, 
        des.designation_name
    ");
		$this->db->from('employee_attendance a');

		// Conditional join: use employee_id if not null, otherwise ivms_id
		$this->db->join('employees u', 'u.employee_id  = a.employee_id', 'right');

		$this->db->join('departments d', 'u.department_id  = d.department_id ', 'left');
		$this->db->join('designations des', 'u.designation_id  = des.designation_id ', 'left');

		// Filter by date range
		$this->db->where('a.Attendance_date >=', $from_date);
		$this->db->where('a.Attendance_date <=', $to_date);

		// Optional department filter
		if (!empty($dept_id)) {
			$this->db->where('u.department_id', $dept_id);
		}

		$this->db->order_by('a.Attendance_date', 'ASC');

		$query = $this->db->get();
		return $query->result();
	}



	// public function get_monthly_attendance_summary($from_date, $to_date, $dept_id = '')
	// {
	// 	// Base query using UNION for both employee_id and ivms_id matching
	// 	$sql = "
	//     (SELECT 
	//         ea.*, 
	//         u.user_code, 
	//         u.user_id, 
	//         u.user_name ,
	//         d.dept_name,
	//         des.designation_name
	//     FROM employee_attendance ea
	//     LEFT JOIN users u ON ea.employee_id = u.user_id
	//     LEFT JOIN department_master d ON u.dept_id = d.dept_id
	//     LEFT JOIN designation_master des ON u.desig_id = des.did
	//     WHERE ea.Attendance_date BETWEEN ? AND ?
	//       AND ea.type != 'I')

	//     UNION ALL

	//     (SELECT 
	//         ea.*, 
	//         u.user_code, 
	//         u.user_id, 
	//         u.user_name AS name,
	//         d.dept_name,
	//         des.designation_name
	//     FROM employee_attendance ea
	//     LEFT JOIN users u ON ea.ivms_id = u.ivms_id
	//     LEFT JOIN department_master d ON u.dept_id = d.dept_id
	//     LEFT JOIN designation_master des ON u.desig_id = des.did
	//     WHERE ea.Attendance_date BETWEEN ? AND ?
	//       AND ea.type = 'I')

	//     ORDER BY Attendance_date DESC
	// ";

	// 	// Run the query with bindings for safe parameters
	// 	$query = $this->db->query($sql, array($from_date, $to_date, $from_date, $to_date));

	// 	$results = $query->result_array();

	// 	// Filter by department if provided
	// 	if (!empty($dept_id)) {
	// 		$results = array_filter($results, function ($row) use ($dept_id) {
	// 			return $row['dept_id'] == $dept_id;
	// 		});
	// 	}

	// 	return $results;
	// }



	public function get_monthly_payroll_report($filters)
	{
		// SAFEGUARD: Ensure 'month' filter is present and valid
		if (empty($filters['month']) || !strtotime($filters['month'])) {
			return []; // Exit early with no results
		}

		// Continue if valid month is present
		$month = date('m', strtotime($filters['month']));
		$year = date('Y', strtotime($filters['month']));
		$start_date = date('Y-m-01', strtotime($filters['month']));
		$end_date = date('Y-m-t', strtotime($filters['month']));
		$dept_cond = '';
		$user_cond = '';

		if (!empty($filters['department_id'])) {
			$dept_id = $this->db->escape($filters['department_id']);
			$dept_cond = "AND two.dept_id = $dept_id";
		}

		if (!empty($filters['user_id'])) {
			$user_id = $this->db->escape($filters['user_id']);
			$user_cond = "AND two.user_id = $user_id";
		}

		$query = $this->db->query("
        SELECT 
            one.*,
            one.total_deductions,
            two.user_name, 
            two.user_code,
            two.ot, 
            two.user_id,
            COALESCE(six.paid_days, 0) AS paid_days, 
            COALESCE(nine.totalp_leave, 0) AS totalp_leave,
            COALESCE(seven.total_overtime, 0) AS total_overtime,
            COALESCE(eight.absent_count, 0) AS absent_count,
            COALESCE(five.present_count, 0) AS present_count,
            COALESCE(eleven.compoff_count, 0) AS compoff_count,
            COALESCE(ten.paid_leave_count, 0) AS paid_leave_count
        FROM 
            users AS two 
        LEFT JOIN 
            (SELECT emp_id, gross_salary, basic_salary, total_allowances, total_deductions, effective_date
             FROM salary_structure
             WHERE effective_date IN (
                 SELECT MAX(effective_date)
                 FROM salary_structure
                 GROUP BY emp_id
             )) AS one 
             ON two.user_id = one.emp_id

        LEFT JOIN 
            (SELECT employee_id, COUNT(attendence) AS present_count 
             FROM employee_attendance 
             WHERE attendence = 'P' 
               AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
             GROUP BY employee_id) AS five 
            ON two.user_id = five.employee_id 

        LEFT JOIN 
            (SELECT employee_id, COUNT(attendence) AS absent_count 
             FROM employee_attendance 
             WHERE attendence = 'A' 
               AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
             GROUP BY employee_id) AS eight 
            ON two.user_id = eight.employee_id 

        LEFT JOIN 
            (SELECT employee_id, COUNT(use_paid_leave) AS paid_leave_count 
             FROM employee_attendance 
             WHERE use_paid_leave = 'PL' 
               AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
             GROUP BY employee_id) AS ten 
            ON two.user_id = ten.employee_id 

        LEFT JOIN 
            (SELECT employee_id, COUNT(use_paid_leave) AS compoff_count 
             FROM employee_attendance 
             WHERE use_paid_leave = 'CMP' 
               AND Attendance_date BETWEEN '$start_date' AND '$end_date' 
             GROUP BY employee_id) AS eleven 
            ON two.user_id = eleven.employee_id 

        LEFT JOIN 
            (SELECT emp_id, SUM(paid_days) AS paid_days 
             FROM paid_leave_master 
             WHERE YEAR(p_date) = $year 
             GROUP BY emp_id) AS six 
            ON two.user_id = six.emp_id 

        LEFT JOIN 
            (SELECT employee_id, SUM(overtime) AS total_overtime 
             FROM employee_overtime 
             WHERE date_ot BETWEEN '$start_date' AND '$end_date' 
             GROUP BY employee_id) AS seven 
            ON two.user_id = seven.employee_id 

        LEFT JOIN 
            (SELECT emp_id, SUM(paid_leave) AS totalp_leave 
             FROM employee_monthly_salary 
             GROUP BY emp_id) AS nine 
            ON two.user_id = nine.emp_id 

        WHERE 
            two.active = 0 
            $dept_cond 
            $user_cond 
            AND two.user_id NOT IN (
                SELECT emp_id 
                FROM employee_monthly_salary 
                WHERE MONTH(salary_month) = '$month' 
                  AND YEAR(salary_month) = '$year'
            )
        ORDER BY two.user_id ASC
    ");

		return $query->result();
	}
	/*End*/

	///////////////////////////////suraj/////////////////////////////////

	function get_emp_monthly_salary_for_emp_corner()
	{
		$user_id = $this->session->userdata('user_id');

		$start_date = date('Y') . '-01-01';   // e.g. 2025-01-01 (first day of current year)
		$end_date = date('Y') . '-12-31';     // e.g. 2025-12-31 (last day of current year)

		$data['from'] = $start_date;
		$data['to'] = $end_date;
		$query = $this->db->query("select one.*, two.account_id from (SELECT s.*, user_id,u.user_code, u.user_name FROM employee_monthly_salary s, users u WHERE s.emp_id = u.user_id AND s.emp_id = $user_id AND s.salary_month BETWEEN '{$data['from']}' AND '{$data['to']}'  ORDER BY s.salary_month DESC)as one left join(select * from general_ledger where group_no=38)as two on(one.user_id=two.employee_id)");
		return $query->result();
	}

	function get_emp_monthly_salary_list_get_year_wise($year)
	{
		$user_id = $this->session->userdata('user_id');

		$start_date = $year . '-01-01';
		$end_date = $year . '-12-31';

		$query = $this->db->query("
        SELECT one.*, two.account_id
        FROM (
            SELECT s.*, u.user_id, u.user_code, u.user_name
            FROM employee_monthly_salary s
            JOIN users u ON s.emp_id = u.user_id
            WHERE s.emp_id = $user_id
              AND s.salary_month BETWEEN '$start_date' AND '$end_date'
            ORDER BY s.salary_month DESC
        ) AS one
        LEFT JOIN (
            SELECT * FROM general_ledger WHERE group_no = 38
        ) AS two ON one.user_id = two.employee_id
    ");

		return $query->result();
	}

	////////////////////////////get rec for group Name notification start/////////
	function get_user_list_by_designaton()
	{
		$designation_id = $this->input->post('designation_id');
		if ($designation_id != "") {
			$query = $this->db->query("SELECT * FROM users u JOIN department_master dm ON u.dept_id = dm.dept_id JOIN designation_master dsm ON u.desig_id = dsm.did WHERE dsm.did = $designation_id AND u.active = 0");
		} else {
			$query = $this->db->query("SELECT * FROM users u JOIN department_master dm ON u.dept_id = dm.dept_id JOIN designation_master dsm ON u.desig_id = dsm.did WHERE u.active = 0");
		}

		return $query->result();
	}



	function add_notification_group_data()
	{
		$checked_users = isset($_POST['checkbox']) ? $_POST['checkbox'] : array();
		$insert_id = null;
		$group_id = null;
		// Check if the required form fields are available
		if (empty($_POST['user_id'])) {
			return false;
		}

		$data = [
			'group_name' => $this->input->post('group_name'),
			'design_id' => $this->input->post('designation_id'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date("Y-m-d H:i:s")
		];

		$this->db->insert('notification_group', $data);
		$group_id = $this->db->insert_id();
		foreach ($checked_users as $index => $user_id) {
			$user_index = array_search($user_id, $_POST['user_id']);

			$data = array(
				'user_id' => $user_id,
				'group_master_id' => $group_id,
			);

			$this->db->insert('notification_group_user', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($group_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'notification_group', 'group_id', $group_id);
		}

		return $group_id;
	}

	function get_notification_group_list()
	{

		$query = $this->db->query("SELECT * FROM notification_group order by created_date desc ");
		return $query->result();
	}
	function get_notification_group_list_by_id($id)
	{

		$query = $this->db->query("SELECT * FROM notification_group where group_id = $id order by created_date desc ");
		return $query->result();
	}

	function get_notification_group_data_by_group_user($id)
	{

		$query = $this->db->query("SELECT * FROM notification_group_user gn JOIN users u ON gn.user_id = u.user_id JOIN department_master dm ON u.dept_id = dm.dept_id JOIN designation_master dsm ON u.desig_id = dsm.did WHERE gn.group_master_id = $id AND u.active = 0");



		return $query->result();
	}

	function update_notification_group($id)
	{
		$checked_users = isset($_POST['checkbox']) ? $_POST['checkbox'] : array();
		$insert_id = null;

		// Check if the required form fields are available
		if (empty($_POST['user_id'])) {
			return false;
		}



		$query = $this->db->query("delete from notification_group_user where group_master_id='$id'");


		foreach ($checked_users as $index => $user_id) {

			$user_index = array_search($user_id, $_POST['user_id']);

			$data = array(
				'user_id' => $user_id,
				'group_master_id' => $id,
			);

			$this->db->insert('notification_group_user', $data);
			$insert_id = $this->db->insert_id();
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'notification_group_user', 'group_id', $id);
		}

		return $id;
	}

	function delete_group_wise_data($id)
	{
		$query = $this->db->query("select count(*)as tcnt from notification_group_user where group_master_id='$id'");
		$tcnt = $query->row('tcnt');
		if ($tcnt == 0) {
			$query = $this->db->query("delete from notification_group where group_id='$id'");

			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 3, $page_name[1], 'notification_group', 'group_id', $id);
			return 1;
		} else
			return 0;
	}
	//////////////////////////end//////////////////

	///////////////////////////////////start notification managers//////////////


	function get_notification_manage_list()
	{

		$query = $this->db->query("SELECT * FROM notification_master order by created_date desc ");
		return $query->result();
	}

	function add_notification_manage_data()
	{

		$page_id = $this->input->post('page_name');
		$group_id = $this->input->post('group_id');

		$group_id_str = implode(',', $group_id);

		$data = [
			'group_id' => $group_id_str,
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date("Y-m-d H:i:s")
		];


		$this->db->where('notify_id', $page_id);
		$this->db->update('notification_master', $data);

		if ($group_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'notification_master', 'notify_id', $page_id);
		}

		return $page_id;
	}
	public function get_group_ids_by_notify_id($notify_id)
	{
		$query = $this->db->get_where('notification_master', ['notify_id' => $notify_id]);
		if ($query->num_rows() > 0) {
			return $query->row()->group_id; // comma-separated string
		}
		return null;
	}

	public function get_notification_manage_list_for()
	{
		$query = $this->db->query("SELECT * FROM notification_master ORDER BY created_date DESC");
		$records = $query->result();

		foreach ($records as &$row) {
			$group_ids = explode(',', $row->group_id); // e.g. [1, 5]
			$group_names = [];

			foreach ($group_ids as $gid) {
				$group = $this->db->get_where('notification_group', ['group_id' => trim($gid)])->row();
				if ($group) {
					$group_names[] = $group->group_name;
				}
			}

			// Add new fields to each row object
			$row->group_ids = $group_ids; // for tooltip
			$row->group_names = implode(', ', $group_names);
		}

		return $records;
	}
	function delete_manage_wise_data($id)
	{


		$query = $this->db->query("delete from notification_master where notify_id='$id'");

		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 3, $page_name[1], 'notification_master', 'notify_id', $id);
		return 1;
	}
	////////////////////////////////////////////////////////////////////

	// missmatch report data start by SB

	function get_emp_attendance_mismatch()
	{



		$current_month_start = date('Y-m-d', strtotime('-44 days'));
		$current_month_end = date('Y-m-d');

		$user_se_id = $this->session->userdata('user_id');


		$query = $this->db->query("

	

        SELECT 
            u.id, 
            u.username, 
           
            ea.attendence, 
            ea.in_time, 
            ea.out_time, 
            ea.Attendance_date,
			ea.ivms_id
        FROM users u
        LEFT JOIN employee_attendance ea 
            ON ea.employee_id = u.id
            AND ea.Attendance_date BETWEEN '$current_month_start' AND '$current_month_end'
        WHERE u.id = $user_se_id and ea.type != 'I' AND u.active = 0

		union 

		   SELECT 
            u.id, 
            u.username, 
             
            ea.attendence, 
            ea.in_time, 
            ea.out_time, 
            ea.Attendance_date,
			ea.ivms_id
        FROM users u
        LEFT JOIN employee_attendance ea 
            ON ea.ivms_id = u.ivms_id
            AND ea.Attendance_date BETWEEN '$current_month_start' AND '$current_month_end'
        WHERE u.id = $user_se_id and ea.type = 'I' AND u.active = 0


    ");
		// Return the result set
		return $query->result();
	}

	function get_emp_attendance_mismatch_status()
	{





		$user_se_id = $this->session->userdata('user_id');


		$query = $this->db->query("
 SELECT 
         approved_flag,user_id,form_date,app_date,in_time,out_time
        FROM employee_request_data
        WHERE emp_reqtype = 'attendance_mismatch' and user_id= '$user_se_id' 

    ");
		return $query->result();
	}


	////////////////////////////////start leave category master////////////////////////////


	function add_category_data()
	{
		$data = array(
			'category_name' => $this->input->post('category_name', TRUE),
			'leave_days'    => $this->input->post('leave_days', TRUE),
			'remark'        => $this->input->post('remark', TRUE),
			'created_by' => $this->session->userdata('user_id'),
			'created_at' => date('Y-m-d')
		);
		$insert_id = $this->db->insert('leave_category', $data);
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'leave_category', 'leave_cat_id', $insert_id);
		}
		return $insert_id = $this->db->insert_id();
	}

	function update_category($id)
	{
		$data = array(
			'category_name' => $this->input->post('category_name', TRUE),
			'leave_days'    => $this->input->post('leave_days', TRUE),
			'remark'        => $this->input->post('remark', TRUE),
		);
		$this->db->where('leave_cat_id', $id);
		$this->db->update('leave_category', $data);
		if ($id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'leave_category', 'leave_cat_id', $id);
		}
		return $id;
	}
	function get_leave_category_list()
	{
		$query = $this->db->query("
 SELECT *
       
        FROM leave_category order by leave_cat_id desc 
       

    ");
		return $query->result();
	}

	function get_leave_category_by_id($id)
	{
		$query = $this->db->query("
 SELECT *
       
        FROM leave_category where leave_cat_id = '$id' order by leave_cat_id desc  
       

    ");
		return $query->result();
	}
	/////////////////////////////////////end leave category ////////////////////////////////////////////////


	////////////////////////////sneha code 10 nov 2025//////////////////////////////////////

	public function add_ticket_allowance_data()
	{
		$amount = $this->input->post('net_amount')[0] ?? null;
		$remark = $this->input->post('remarks') ?? '';

		$data = array(
			'emp_reqtype' => 'ticket_allowance',
			'user_id' => $this->input->post('employee_id'),
			'app_date' => date('Y-m-d'),
			'last_ticket_date'  => !empty($this->input->post('last_ticket_date')) ? date('Y-m-d', strtotime($this->input->post('last_ticket_date'))) : null,
			'rejoin_date'       => !empty($this->input->post('rejoin_date')) ? date('Y-m-d', strtotime($this->input->post('rejoin_date'))) : null,
			'visa_expiry_date'  => !empty($this->input->post('visa_expiry_date')) ? date('Y-m-d', strtotime($this->input->post('visa_expiry_date'))) : null,
			'form_date' => !empty($this->input->post('leave_from')) ? date('Y-m-d', strtotime($this->input->post('leave_from'))) : null,
			'to_date' => !empty($this->input->post('leave_to')) ? date('Y-m-d', strtotime($this->input->post('leave_to'))) : null,
			'amount' => $amount,
			'remark' => $remark,
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d')
		);

		$this->db->insert('employee_request_data', $data);
		$insert_id = $this->db->insert_id();

		// Handle uploaded documents if any
		if ($insert_id && !empty($_FILES['documents_ticket']['name'][0])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			foreach ($_FILES['documents_ticket']['name'] as $key => $filename) {
				if (!empty($filename)) {
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if (in_array(strtolower($ext), $allowedExts)) {
						$timestamp = time();
						$file_tmp = $_FILES["documents_ticket"]["tmp_name"][$key];
						$file_name = $timestamp . "_" . $filename;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/Hundredmedia/public/uploded_documents/" . $file_name);

						$data1 = array(
							'emp_req_id' => $insert_id,
							'document_name' => $this->input->post('document_types_ticket')[$key] ?? null,
							'document_path' => $file_name,
							'created_by' => $this->session->userdata('user_id'),
							'create_date' => date('Y-m-d')
						);
						$this->db->insert('employee_req_documents', $data1);
					}
				}
			}
		}

		return $insert_id;
	}
	public function update_employee_request_ticket($id)
	{
		$data = array(
			'user_id' => $this->input->post('employee_id'),
			'form_date' => !empty($this->input->post('last_ticket_date')) ? date('Y-m-d', strtotime($this->input->post('last_ticket_date'))) : null,
			'to_date' => !empty($this->input->post('rejoin_date')) ? date('Y-m-d', strtotime($this->input->post('rejoin_date'))) : null,
			'visa_expiry_date' => !empty($this->input->post('visa_expiry_date')) ? date('Y-m-d', strtotime($this->input->post('visa_expiry_date'))) : null,
			'amount' => $this->input->post('net_amount')[0] ?? null,
			'remark' => $this->input->post('remarks') ?? ''
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		// Handle uploaded documents if any
		if ($res && !empty($_FILES['documents_ticket']['name'][0])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			foreach ($_FILES['documents_ticket']['name'] as $key => $filename) {
				if (!empty($filename)) {
					$ext = pathinfo($filename, PATHINFO_EXTENSION);
					if (in_array(strtolower($ext), $allowedExts)) {
						$timestamp = time();
						$file_tmp = $_FILES["documents_ticket"]["tmp_name"][$key];
						$file_name = $timestamp . "_" . $filename;
						move_uploaded_file($file_tmp, FCPATH . "public/uploded_documents/" . $file_name);

						$data1 = array(
							'emp_req_id' => $id,
							'document_name' => $this->input->post('document_types_ticket')[$key] ?? null,
							'document_path' => $file_name,
							'created_by' => $this->session->userdata('user_id'),
							'create_date' => date('Y-m-d')
						);
						$this->db->insert('employee_req_documents', $data1);
					}
				}
			}
		}

		return $res;
	}

	function get_employee_request_list_by_ticket($id)
	{
		$current_user_id = $this->session->userdata('user_id');

		$query = $this->db->query("
        SELECT 
            j.emp_req_id,
            j.user_id,
            j.app_date,
            j.last_ticket_date,
            j.rejoin_date,
            j.visa_expiry_date,
            j.amount,
            j.remark,
            u.user_name AS name
        FROM employee_request_data j
        JOIN users u ON j.user_id = u.user_id
        WHERE j.user_id = '$current_user_id'
          AND j.emp_req_id = $id
          AND j.emp_reqtype = 'ticket_allowance'
        ORDER BY app_date DESC
    ");

		return $query->result();
	}

	function update_ticket_allowance_hr($id)
	{
		$data = array(
			'approved_flag' => $this->input->post('ticket_status'),
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
			// 'approved_form_date' => !empty($this->input->post('a_start_month')) ? date('Y-m-01', strtotime($this->input->post('a_start_month'))) : null,
			// 'approved_to_date' => !empty($this->input->post('a_end_month')) ? date('Y-m-t', strtotime($this->input->post('a_end_month'))) : null,

			// 'approve_emi' => $this->input->post('a_emi_amount'),
			// 'approve_total_month' => $this->input->post('a_total_month'),

			'approved_amount' => $this->input->post('ar_amount'),
			'approve_remark' => $this->input->post('approve_remark')
		);

		$this->db->where('emp_req_id', $id);
		$res = $this->db->update('employee_request_data', $data);

		$employee = $this->input->post('employee_id_hidden');
		$status = $this->input->post('ticket_status');

		$s = ($status == 1) ? "Annual Ticket Allownace Approved" : "Annual Ticket Allownace Rejected";


		if ($res) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'employee_request_data', 'emp_req_id', $id);
			$notice = add_notification($id, $employee, "$s", "Hr/view_emp_request_edit/$id");

			return true;
		} else {
			return false;
		}
	}
	public function get_pending_leave_request_count($manager_id)
	{
		$this->db->from('employee_leave el');
		$this->db->join('users u', 'el.employee_id = u.user_id', 'inner');
		$this->db->join('leave_approval la', 'la.approval_leave_id = el.leave_id', 'left');
		$this->db->where('u.reporting_mngr', $manager_id);

		$this->db->group_start();
		$this->db->where('la.leave_status', 'Pending');
		$this->db->or_where('la.leave_status IS NULL', null, false); // raw SQL
		$this->db->group_end();

		return $this->db->count_all_results();
	}

	public function get_leave_requests_for_manager($manager_id)
	{
		$first_day = date('Y-m-01');
		$last_day  = date('Y-m-t');

		$query = $this->db->query("
        SELECT el.*, 
               u.user_name,
               lc.category_name AS leave_type_name,
               la.admin_md,
               la.hr AS hr_id,
               la.ceo AS ceo_id,
               la.leave_status,
               -- Compute Manager Status
               CASE 
                   WHEN la.admin_md IS NOT NULL THEN 'Approved'
                   ELSE 'Pending'
               END AS manager_status,
               -- Compute HR Status
               CASE
                   WHEN la.hr IS NOT NULL AND la.leave_status = 2 THEN 'Rejected'
                   WHEN la.hr IS NOT NULL AND la.leave_status = 1 THEN 'Approved'
                   ELSE 'Pending'
               END AS hr_status,
               -- Compute CEO Status
               CASE
                   WHEN la.ceo IS NOT NULL AND la.leave_status = 2 THEN 'Rejected'
                   WHEN la.ceo IS NOT NULL AND la.leave_status = 1 THEN 'Approved'
                   ELSE 'Pending'
               END AS ceo_status
        FROM employee_leave el
        INNER JOIN users u ON el.employee_id = u.user_id
        LEFT JOIN leave_category lc ON el.leave_type = lc.leave_cat_id
        LEFT JOIN leave_approval la ON el.leave_id = la.approval_leave_id
        WHERE u.reporting_mngr = ?
          AND el.start_date <= ? 
          AND el.end_date >= ?
        ORDER BY el.application_date DESC
    ", [$manager_id, $last_day, $first_day]);

		return $query->result();
	}

	public function add_service_request_data()
	{
		// Calculate Grand Total
		$amounts = $this->input->post('net_amount');
		$total_amount = is_array($amounts) ? array_sum($amounts) : 0;

		// Main table insert
		$data = array(
			'emp_reqtype'  => 'service_request',
			'user_id'      => $this->input->post('employee_id'),
			'dept_id'      => $this->input->post('dept_id'),
			'app_date'     => $this->input->post('app_date'),
			'amount'       => $total_amount,
			'project_name'       => $this->input->post('project_name'),
			'urgency'       => $this->input->post('urgency'),
			'created_by'   => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d')
		);

		$this->db->insert('employee_request_data', $data);
		$req_id = $this->db->insert_id();

		// Insert Service Items table
		if ($req_id) {
			$item_names = $this->input->post('item_name');
			$item_purpose = $this->input->post('item_purpose');
			$suppliers = $this->input->post('supplier');
			$net_amount = $this->input->post('net_amount');

			foreach ($item_names as $i => $name) {
				if ($name != '') {
					$itemData = array(
						'req_id'       => $req_id,
						'item_name'    => $name,
						'item_purpose' => $item_purpose[$i],
						'supplier'     => $suppliers[$i],
						'net_amount'   => $net_amount[$i]
					);
					$this->db->insert('service_request', $itemData);
				}
			}
		}

		return $req_id;
	}

	public function update_service_request_data()
	{
		$emp_req_id = $this->input->post('emp_req_id');

		// Update main record
		$data = array(
			'app_date'     => $this->input->post('app_date'),
			'remark'        => $this->input->post('project'),
			'as_code'       => $this->input->post('urgency'),
			'amount'        => $this->input->post('grand_total'),
			'approved_flag' => $this->input->post('status'),
			'approved_date' => date('Y-m-d', strtotime($this->input->post('approve_date'))),
		);

		$this->db->where('emp_req_id', $emp_req_id);
		$this->db->update('employee_request_data', $data);

		$this->db->where('req_id', $emp_req_id);
		$this->db->delete('service_request');
		// Insert new items
		$item_name     = $this->input->post('item_name');
		$item_purpose  = $this->input->post('item_purpose');
		$supplier      = $this->input->post('supplier');
		$net_amount    = $this->input->post('net_amount');

		if (!empty($item_name)) {
			foreach ($item_name as $i => $name) {
				if ($name != '') {
					$itemData = array(
						'req_id'       => $emp_req_id,
						'item_name'    => $name,
						'item_purpose' => $item_purpose[$i] ?? '',
						'supplier'     => $supplier[$i] ?? '',
						'net_amount'   => $net_amount[$i] ?? 0
					);

					$this->db->insert('service_request', $itemData);
				}
			}
		}

		return true;
	}

	public function get_service_request_by_id($id)
	{
		return $this->db->where('emp_req_id', $id)
			->get('employee_request_data')
			->row();
	}
	public function get_user_details($user_id)
	{
		return $this->db->select('users.user_name, department_master.dept_name')
			->from('users')
			->join('department_master', 'department_master.dept_id = users.dept_id', 'left')
			->where('users.user_id', $user_id)
			->get()
			->row();
	}
	public function get_service_request_items($req_id)
	{
		return $this->db->where('req_id', $req_id)
			->get('service_request')
			->result();
	}
	public function get_service_request_for_ceo($id)
	{
		$query = $this->db->query("SELECT j.*, u.user_name, u.dept_name 
        FROM employee_request_data j
        JOIN users u ON j.user_id=u.user_id
        WHERE j.emp_req_id = $id
        AND j.emp_reqtype = 'service_request'");
		return $query->row(); // single row
	}

	//////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////

	public function get_salary_advancesold()
	{
		$this->db->select('a.*, e.employee_name, e.employee_code');
		$this->db->from('employee_salary_advance a');
		$this->db->join('employees e', 'e.employee_id = a.emp_id', 'left');
		$this->db->order_by('a.advance_id', 'desc');
		return $this->db->get()->result();
	}
	public function get_salary_advances()
	{
		$this->db->select('
        a.*, 
        e.employee_name, 
        e.employee_code,
        vt.voucher_code');

		$this->db->from('employee_salary_advance a');

		$this->db->join('employees e', 'e.employee_id = a.emp_id', 'left');

		// Join only one voucher row
		$this->db->join(
			'voucher_transaction vt',
			'vt.trans_id = a.advance_id 
        AND vt.trans_type = "SA"
        AND vt.drcr_type = "Dr"',
			'left'
		);

		$this->db->order_by('a.advance_id', 'desc');

		return $this->db->get()->result();
	}
	public function get_salary_advance_by_id($id)
	{
		return $this->db->where('advance_id', $id)
			->get('employee_salary_advance')
			->row();
	}
	public function get_employee_advance_monthly($emp_id, $start_date, $end_date)
	{
		$this->db->select('IFNULL(SUM(amount),0) as total_advance');
		$this->db->from('employee_salary_advance');
		$this->db->where('emp_id', $emp_id);
		$this->db->where('advance_date >=', $start_date);
		$this->db->where('advance_date <=', $end_date);
		// $this->db->where('status', 'Approved'); // if you use status logic

		$query = $this->db->get();
		return $query->row()->total_advance;
	}

	public function get_salary_advance_by_id_details_old($id)
	{
		$this->db->select('
        sa.*,
        e.employee_name,
        e.employee_code,
        e.mobile,
        e.joining_date,
        e.department_id,
        e.designation_id
    ');

		$this->db->from('employee_salary_advance sa');
		$this->db->join('employees e', 'e.employee_id = sa.emp_id', 'left');

		$this->db->where('sa.advance_id', $id);

		return $this->db->get()->row();
	}

	public function get_salary_advance_by_id_details($id)
	{
		$this->db->select('
        sa.*,
        e.employee_name,
        e.employee_code,
        e.mobile,
        e.joining_date,
        e.department_id,
        e.designation_id,
        vt.voucher_code,
        vt.voucher_date
    ');

		$this->db->from('employee_salary_advance sa');

		$this->db->join(
			'employees e',
			'e.employee_id = sa.emp_id',
			'left'
		);

		$this->db->join(
			'voucher_transaction vt',
			'vt.trans_id = sa.advance_id 
		AND vt.trans_type = "SA"
		AND vt.drcr_type = "Dr"',
			'left'
		);

		$this->db->where('sa.advance_id', $id);

		return $this->db->get()->row();
	}
}
