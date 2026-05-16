<?php
date_default_timezone_set('Asia/Dubai');
class Hr extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// $this->is_logged_in();
	}

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if (!isset($is_logged_in) || $is_logged_in != true) {
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';

			die();
			//$this->load->view('login/login_form');
		}
	}

	///////////////////////////////////////Allowances////////////////////////////////////////////// 

	function add_allowances()
	{
		$data['title'] = "Allowances & Deductions Master";
		$data['main_content'] = 'hr/allowances_deductions_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_allowances_list()
	{
		$data['title'] = "Allowances & Deductions Master List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_allowances_list();
		$data['main_content'] = 'hr/allowances_deductions_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_allowances_data()
	{
		$data['title'] = "Allowances & Deductions Master";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_allowances_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_allowances_list');
		} else {
			$this->session->set_flashdata('warning', 'Supplier Company Name Already Exist');
			redirect('Hr/add_allowances');
		}
	}

	function edit_allowances()
	{
		$data['title'] = "Edit Allowances & Deductions Master";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_allowances_by_id($id);
		$data['main_content'] = 'hr/allowances_deductions_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_allowances()
	{
		$data['title'] = "Allowances & Deductions Master";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_allowances($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_allowances_list');
		}
	}
	function delete_Allowances()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_allowance($id);

		$this->session->set_flashdata('success', 'Record Delete Successfully');
		redirect('Hr/view_allowances_list');
	}
	///////////////////////////////////////Leave application ////////////////////////////////////////////// 

	function add_leave_application()
	{
		$data['title'] = "Leave application";
		$this->load->model('Setup_model');
		$data['user_recordsold'] = $this->Setup_model->get_all_users();

		$this->load->model('Employee_model');
		$data['user_records'] = $this->Employee_model->get_all_employees();

		$this->load->model('Hr_model');
		$data['category'] = $this->Hr_model->get_leave_category_list();

		$data['main_content'] = 'hr/leave_allocation_add.php';
		$this->load->view('includes/template', $data);
	}
	public function view_leave_application_list()
	{
		$data['title'] = "Leave Application";
		$this->load->model('Hr_model');

		$logged_in_user = $this->session->userdata('user_id');
		$user_dept_id = $this->session->userdata('dept_id'); // If you track HR by dept

		// If HR (dept_id = 3), show all; else only employees reporting to this manager
		if ($user_dept_id == 3) {
			$data['records'] = $this->Hr_model->get_employee_leave_list(); // all
		} else {
			$data['records'] = $this->Hr_model->get_employee_leave_list($logged_in_user); // manager only
		}
		$this->load->model('Setup_model');
		$data['record1'] = $this->Hr_model->leave_approval_list();
		$data['record2'] = $this->Setup_model->get_all_users();
		$data['main_content'] = 'hr/leave_allocation_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_leave_application_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_employee_leave_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_leave_application_list');
		} else {
			$this->session->set_flashdata('warning', 'Supplier Company Name Already Exist');
			redirect('Hr/view_leave_application_list');
		}
	}

	public function edit_leave_application()
	{
		$data['title'] = "Edit Leave Application";
		$this->load->model('Hr_model');
		$data['category'] = $this->Hr_model->get_leave_category_list();
		// Get leave ID from URL segment
		$id = $this->uri->segment(3);

		// Load required models
		$this->load->model('Setup_model');
		$this->load->model('Employee_model');
		$this->load->model('Hr_model');

		// Get data for form
		$data['user_records']   = $this->Employee_model->get_all_employees();                    // All users
		$data['records']        = $this->Hr_model->get_employee_leave_by_id($id);          // Leave application record
		$data['file_records']   = $this->Hr_model->get_employee_leave_doc_id($id);         // Uploaded documents
		$data['admin_hr_ceo']   = $this->Hr_model->leave_hr_admin_ceo_list();             // Admin / HR / CEO list
		$data['dept_list']      = $this->Employee_model->get_departments();        // Departments
		$data['desig_list']     = $this->Employee_model->get_designations();              // Designations
		$data['appro']          = $this->Hr_model->get_approval_setup_list();              // Approval setup
		$data['leave_appro']    = $this->Hr_model->get_leave_approval_details_leave_id($id); // Leave approval details
		$data['approval_record'] = $this->Hr_model->get_employee_leave_approveal_record($id); // Previous approval records
		$data['admin_hr']       = $this->Hr_model->leave_hr_admin_list();                  // Admin / HR for approval dropdown

		// Fetch first-level approver (reporting manager) for the employee
		// if (!empty($data['records'])) {
		// 	$employee_id = $data['records'][0]->employee_id;
		// 	$reporting_mgr = $this->Users_model->get_reporting_manager($employee_id);
		// 	$data['first_level_approver'] = $reporting_mgr;
		// } else {
		// 	$data['first_level_approver'] = null;
		// }
		// $data['logged_in_user'] = $this->session->userdata('user_id');

		// Load the view with all data
		$data['main_content'] = 'hr/leave_allocation_edit';
		$this->load->view('includes/template', $data);
	}

	function update_leave_application()
	{
		$data['title'] = "Edit Leave application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_employee_leave($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_leave_application_list');
		}
	}

	function print_leave_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_leave_by_id($id);
		// log_message('error', 'Leave Record: ' . print_r($data['records'], true));
		// $this->load->model('Users_model');
		// $data['record1'] = $this->Users_model->get_user_record_by_id_pass($id);
		$data['record1'] = "";
		$this->load->model('Employee_model');
		$data['dept_list'] = $this->Employee_model->get_departments();
		$data['desig_list'] = $this->Employee_model->get_designations();

		$this->load->view('hr/print/print_leave_application.php', $data);
	}

	function delete_leave_application()
	{

		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_leave_application($id);

		$this->session->set_flashdata('success', 'Record Delete Successfully');
		redirect('Hr/view_leave_application_list');
	}

	//approvalcontroler//////////////////leave_id
	function add_leave_approval()
	{

		$this->load->model('Hr_model');


		$flag = $this->Hr_model->add_approval_leave();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_leave_application_list');
		}
	}

	function update_leave_approval()
	{

		$this->load->model('Hr_model');
		$flag = $this->Hr_model->update_approval_leave();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_leave_application_list');
		}
	}
	///////////////////////////////////////Joining Application////////////////////////////////////////////// 

	function add_joining_application()
	{
		$this->load->model('Hr_model');


		$data['user_records'] = $this->Hr_model->get_joining_new_list();


		$data['title'] = "Joining Application";
		$data['main_content'] = 'hr/joining_allocation_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_joining_application_list()
	{
		$data['title'] = "Joining Application List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_joining_list();
		$data['main_content'] = 'hr/joining_allocation_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_joining_application_data()
	{
		$data['title'] = "Joining Application";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_joining_application_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_joining_application_list');
		} else {
			$this->session->set_flashdata('warning', 'Supplier Company Name Already Exist');
			redirect('Hr/view_joining_application_list');
		}
	}

	function edit_joining_application()
	{
		$data['title'] = "Joining Application Edit";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_joining_by_id($id);

		$data['main_content'] = 'hr/joining_allocation_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_joining_application()
	{
		$data['title'] = "Joining Application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_joining_application($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_joining_application_list');
		}
	}

	function print_joining_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_joining_by_id($id);

		$this->load->model('Users_model');
		$data['record1'] = $this->Users_model->get_user_record_by_id_pass($id);

		$this->load->model('Setup_model');
		$data['dept_list'] = $this->Setup_model->get_active_department_list();

		$this->load->view('hr/print/print_joining_application.php', $data);
	}

	function delete_joining_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_joining_application($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_joining_application_list');
	}
	///////////////////////////////////////salary_structure////////////////////////////////////////////// 

	function add_emp_salary_structure()
	{
		$data['title'] = "Employee Salary Structure";

		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_allowances_list();
		$data['user_records'] = $this->Hr_model->get_active_basic_salary();
		//  print_r($data['user_records']);
		// 		die;
		$data['main_content'] = 'hr/basic_salary_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_salary_structure_list()
	{
		$data['title'] = "Employee Salary List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_salary_structure_list();

		$data['main_content'] = 'hr/basic_salary_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_salary_structure_data()
	{
		$data['title'] = "Add Salary Structure";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_salary_structure();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_salary_structure_list');
		} else {
			$this->session->set_flashdata('warning', 'data Already Exist');
			redirect('Hr/add_allowances');
		}
	}

	function edit_salary_structure()
	{
		$data['title'] = "Edit Salary Structure";
		$id = $this->uri->segment('3');

		$this->load->model('Setup_model');
		$this->load->model('Employee_model');
		$data['user_records1'] = $this->Setup_model->get_all_users();
		$data['user_records'] = $this->Employee_model->get_all_employees();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_salary_structure_by_id($id);
		$data['record1'] = $this->Hr_model->get_allowances_list();
		$data['details'] = $this->Hr_model->get_salary_allowance_details($id);

		// print_r($data['details']);
		// die;
		$data['main_content'] = 'hr/basic_salary_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_salary_structure()
	{
		$data['title'] = "Update Salary Structure";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');
		$data['user_records'] = $this->Setup_model->get_all_users();
		$res = $this->Hr_model->update_salary_structure($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_salary_structure_list');
		}
	}

	function delete_basic_salary()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_salary_structure($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_salary_structure_list');
	}
	///////////////////////////////////////emp_attendance////////////////////////////////////////////// 

	function add_emp_attendance()
	{
		$data['title'] = "Employee Attendance";

		$data['a_date'] = date('d-m-Y');
		$data['Attendance_date'] = $this->input->post('Attendance_date');

		$data['user_id'] = "";

		$this->load->model('Hr_model');
		$data['records1'] = array();

		// $this->load->model('Users_model');
		// $data['records'] = $this->Users_model->get_user_list();
		$data['records'] = array();

		$data['main_content'] = 'hr/employee_attendance_add.php';
		$this->load->view('includes/template', $data);
	}


	function get_emp_attendance()
	{
		$data['title'] = "Employee Attendance";
		$data['Attendance_date'] = $this->input->post('Attendance_date');

		$data['user_id'] = "";
		$data['a_date'] = $this->input->post('a_date');

		if ($data['a_date'] == '') {
			$data['a_date'] = $this->uri->segment('3');
		}

		$this->load->model('Hr_model');
		$data['records1'] = $this->Hr_model->get_emp_attendance();

		$this->load->model('Setup_model');
		$data['recordsold'] = $this->Setup_model->get_all_users();

		$this->load->model('Employee_model');
		$data['records'] = $this->Employee_model->get_all_employees();

		$data['main_content'] = 'hr/employee_attendance_add.php';
		$this->load->view('includes/template', $data);
	}



	function view_emp_attendance_list()
	{

		$data['title'] = "Employee Attendance List";

		$data['from'] = date('Y-01-01');
		$data['to'] = date('Y-m-d');
		$data['user_id'] = "";

		$this->load->model('Hr_model');
		$this->load->model('Employee_model');
		$data['records'] = $this->Hr_model->get_emp_attendance_list_filter_get_todays_record();
		// $data['records2'] = $this->Hr_model->get_emp_attendance();
		$data['records1'] = $this->Employee_model->get_all_employees();

		// Log results
		log_message('error', 'Today Attendance Records: ' . print_r($data['records'], true));
		log_message('error', 'All Attendance Records: ' . print_r($data['records1'], true));
		$data['main_content'] = 'hr/employee_attendance_list.php';
		$this->load->view('includes/template', $data);
	}

	function get_emp_attendance_list()
	{
		$data['title'] = 'Employee Attendance List';

		$data['from'] = $this->input->post('from');
		$data['to'] = $this->input->post('to');

		$data['user_id'] = $this->input->post('user_id');

		$data['attendance_type'] = $this->input->post('attendance_type');

		if ($data['from'] == '') {
			$data['from'] = $this->uri->segment('3');
			$data['to'] = $this->uri->segment('4');
		}

		$this->load->model('Hr_model');
		$this->load->model('Employee_model');
		$data['records'] = $this->Hr_model->get_emp_attendance_list_filter();
		$data['records2'] = $this->Hr_model->get_emp_attendance();
		$data['records1'] = $this->Employee_model->get_all_employees();

		$data['main_content'] = 'hr/employee_attendance_list.php';
		$this->load->view('includes/template', $data);
	}





	function add_emp_attendance_data()
	{
		$data['title'] = "Add Employee Attendance";

		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_emp_attendance_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_attendance_list');
		} else {
			$this->session->set_flashdata('warning', 'Employee Name Already Exist');
			redirect('Hr/add_emp_attendance');
		}
	}

	function edit_emp_attendance()
	{
		$data['title'] = "Edit Employee Attendance";
		$id = $this->uri->segment('3');

		$this->load->model('Setup_model');
		$data['records'] = $this->Setup_model->get_all_users();

		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_emp_attendance_by_id($id);

		$data['main_content'] = 'hr/employee_attendance_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_emp_attendance()
	{
		$data['title'] = "Attendance Data";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_emp_attendance($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_attendance_list');
		}
	}
	function delete_attendance_emp()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_attendance_emp($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_emp_attendance_list');
	}



	///////////////////////////////////////add_emp_overtime////////////////////////////////////////////// 

	function add_emp_overtime()
	{
		$data['title'] = "Employee Overtime";

		$this->load->model('Users_model');
		$data['records'] = $this->Users_model->get_user_list();

		$data['main_content'] = 'hr/employee_overtime_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_emp_overtime_list()
	{
		$data['title'] = "Employee Overtime List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_overtime_list();
		$data['main_content'] = 'hr/emp_overtime_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_overtime_data()
	{
		$data['title'] = "Add Overtime Data";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_emp_overtime_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_overtime_list');
		} else {
			$this->session->set_flashdata('warning', ' Record Already Exist');
			redirect('Hr/add_emp_overtime');
		}
	}

	function edit_emp_overtime()
	{
		$data['title'] = "Edit Employee Overtime";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_emp_overtime_by_id($id);

		$this->load->model('Users_model');
		$data['records'] = $this->Users_model->get_user_list();
		$data['main_content'] = 'hr/emp_overtime_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_emp_overtime()
	{
		$data['title'] = "Supplier Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_emp_overtime($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_overtime_list');
		}
	}
	function delete_overtime_emp()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_emp_overtime($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_emp_overtime_list');
	}
	///////////////////////////////////////add_resignation////////////////////////////////////////////// 

	function add_regignation()
	{
		$data['title'] = "Add Resignaion";

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_resignation_active_list();

		$data['main_content'] = 'hr/resignation_emp_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_emp_regignation_list()
	{
		$data['title'] = "Resignation List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_resignation_list();
		$data['main_content'] = 'hr/resignation_emp_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_regignation_data()
	{
		$data['title'] = "Add resignation";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_resignation();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_regignation_list');
		} else {
			$this->session->set_flashdata('warning', 'Supplier Company Name Already Exist');
			redirect('Hr/add_regignation');
		}
	}

	function edit_emp_regignation()
	{
		$data['title'] = "Edit Resignation";
		$id = $this->uri->segment('3');

		$this->load->model('Employee_model');
		$data['user_records'] = $this->Employee_model->get_all_employees();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_resigning_by_id($id);
		$data['file_records'] = $this->Hr_model->get_employee_document_doc_id($id);
		$data['admin_hr'] = $this->Hr_model->resignation_hr_admin_list();

		$data['main_content'] = 'hr/resignation_emp_edit';
		$this->load->view('includes/template', $data);
	}
	function update_emp_regignation()
	{
		$data['title'] = "Update Resignation";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_resigning_application($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_regignation_list');
		}
	}


	function print_resignation_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_resigning_by_id($id);

		// $this->load->model('Users_model');
		// $data['record1'] = $this->Users_model->get_user_record_by_id_pass($id);

		$this->load->model('Employee_model');
		$data['dept_list'] = $this->Employee_model->get_departments();
		$data['record1'] = $this->Employee_model->get_all_employees($id);
		$this->load->view('hr/print/print_resigning_application.php', $data);
	}

	function delete_resignation_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_resignation_application($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_emp_regignation_list');
	}

	function print_experience_certificate()
	{
		//echo "this is the experience certificate";
		// $this->load->model('Users_model');
		// $data['record1'] = $this->Users_model->get_user_record_by_id_pass();
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_employee_experience_certificate($id);

		// print_r($data['user_records']);
		// exit;
		$this->load->model('Setup_model');
		$data['comapny_records'] = $this->Setup_model->get_company_master_list();

		$this->load->view('hr/print/print_experience_certificate.php', $data);
	}
	///////////////////////////////////////add_passport_release////////////////////////////////////////////// 

	function add_passport_release()
	{
		$data['title'] = "Passport Release";

		$this->load->model('Employee_model');
		$data['records'] = $this->Employee_model->get_all_employees();


		$data['main_content'] = 'hr/passport_relese_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_passport_release_list()
	{
		$data['title'] = "Passport Release List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_passport_release_list();

		$data['main_content'] = 'hr/passport_relese_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_passport_release()
	{
		$data['title'] = "Passport Release Add";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_passport_release();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_passport_release_list');
		} else {
			$this->session->set_flashdata('warning', 'Name Already Exist');
			redirect('Hr/view_passport_release_list');
		}
	}

	function edit_passport_release()
	{
		$data['title'] = "Edit Release Passport";
		$id = $this->uri->segment('3');
		$this->load->model('Employee_model');
		$data['records'] = $this->Employee_model->get_all_employees();
		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_passport_release_list_by_id($id);


		// print_r($data['record1']);
		// die;


		$data['main_content'] = 'hr/passport_release_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_passport_release()
	{
		$data['title'] = "Update_Release Passport";
		$id = $this->input->post('id');

		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_passport_re($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_passport_release_list');
		}
	}

	function print_passport_release()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_passport_release_list_by_id($id);
		$data['records'] = $this->Hr_model->get_user_record_by_id($id);

		$this->load->model('Employee_model');
		$data['dept_list'] = $this->Employee_model->get_departments();

		$this->load->view('hr/print/print_passport_release.php', $data);
	}

	function delete_passport_release()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_passport_release($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_passport_release_list');
	}
	///////////////////////////////////////add_corporate_file////////////////////////////////////////////// 

	function add_corporate_file()
	{
		$data['title'] = "Corporate File";
		$data['main_content'] = 'hr/corporate_file_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_corporate_file_list()
	{
		$data['title'] = "Corporate File List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_corporate_file_list();
		$data['main_content'] = 'hr/corporate_file_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_corporate_file_data()
	{
		$data['title'] = "Corporate File ";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_corporate_file_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_corporate_file_list');
		} else {
			$this->session->set_flashdata('warning', 'Name Already Exist');
			redirect('Hr/add_corporate_file');
		}
	}

	function edit_corporate_file()
	{
		$data['title'] = "Corporate File Edit";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_corporate_file_id($id);
		$data['file_records'] = $this->Hr_model->get_employee_corporate_doc_id($id);
		$data['main_content'] = 'hr/corporate_file_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_corporate_file()
	{
		$data['title'] = "Update Corporate File";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_corporate_file_data($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_corporate_file_list');
		}
	}

	function delete_corporate_file()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_corporate_file_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_corporate_file_list');
	}
	///////////////////////////////////////add_vehicles////////////////////////////////////////////// 

	function add_vehicles()
	{
		$data['title'] = "Vehicle Details";
		$this->load->model('Hr_model');

		$data['user_records'] = $this->Hr_model->get_user_list();
		$data['main_content'] = 'hr/vehicle_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_vehicles_list()
	{
		$data['title'] = "Vehicle Details List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_vehicle_list();
		$data['main_content'] = 'hr/vehicle_details_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_vehicles_details()
	{
		$data['title'] = " Add Vehicle Details";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_vehicle_details();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_vehicles_list');
		} else {
			$this->session->set_flashdata('warning', 'Vehicle Details Name Already Exist');
			redirect('Hr/add_vehicles');
		}
	}

	function edit_vehicles()
	{
		$data['title'] = " Edit Vehicle Details";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_user_list();
		$data['records'] = $this->Hr_model->get_vehicle_details_by_id($id);
		$data['main_content'] = 'hr/vehicle_details_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_vehicles()
	{
		$data['title'] = "Update Vehicle Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_vehicle_details($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_vehicles_list');
		}
	}
	function delete_vehicle_details()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_vehicle_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_vehicles_list');
	}
	///////////////////////////////////////add_monthly_salary////////////////////////////////////////////// 

	function add_monthly_salary()
	{
		$data['title'] = "Monthly Salary";
		$data['effective_date'] = date('M-Y');
		$data['user_id'] = $this->input->post('user_id');
		$this->load->model('Setup_model');
		$data['user_rec'] = $this->Setup_model->get_all_users();

		$this->load->model('Hr_model');
		$data['records'] = array();

		$this->load->model('Accounts_model');
		$data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('Expense', '');
		$data['credit_records'] = $this->Accounts_model->get_general_ledger_accounts('Liabilities', '');

		$data['main_content'] = 'hr/emp_monthly_salary_add.php';
		$this->load->view('includes/template', $data);
	}
	function get_company_off_days($year, $month)
	{
		$start = strtotime("$year-$month-01");
		$end   = strtotime(date("Y-m-t", $start));

		$count = 0;

		for ($date = $start; $date <= $end; $date = strtotime("+1 day", $date)) {

			if (date('N', $date) == 7) { // 7 = Sunday
				$count++;
			}
		}

		return $count;
	}


	function add_monthly_salary_data()
	{
		$data['title'] = "Monthly Salary";
		$effective_date_hidden = $this->input->post('effective_date_hidden');
		$data['user_id'] = $this->input->post('user_id');
		$this->load->model('Setup_model');
		$data['user_rec'] = $this->Setup_model->get_all_users();
		$data['effective_date'] = $this->input->post('effective_date');
		$data['start_date'] = date('Y-m-01', strtotime($data['effective_date']));
		$data['end_date'] = date('Y-m-t', strtotime($data['effective_date']));
		// Extract the month and year from the effective date
		$selected_month_year = date('Y-m', strtotime($data['effective_date']));
		$data['days_in_month'] = date('t', strtotime($selected_month_year));


		$effective_date = $this->input->post('effective_date');


		// Get year & month
		$year  = date('Y', strtotime($effective_date));
		$month = date('m', strtotime($effective_date));

		// Company off days (Sundays)
		$data['compoff_count'] = $this->get_company_off_days($year, $month);


		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_data();
		//$data['records'] = $this->Hr_model->get_emp_monthly_salary_data($start_date, $end_date);

		foreach ($data['records'] as $k => $row) {
			$advance = $this->Hr_model->get_employee_advance_monthly(
				$row->emp_id,
				$data['start_date'],
				$data['end_date']
			);

			$data['records'][$k]->advance_taken = $advance;
		}

		// echo "<pre>";
		// print_r($data['records']);
		// exit;

		$data['holiday_count'] = $this->Hr_model->get_emp_holiday_count();

		$this->load->model('Accounts_model');
		$Salary_payables = 2815;
		$Salary_expense = 2824;
		$data['sundry_detors_records'] = $this->Accounts_model->get_general_ledger_accounts('Expense', '');
		$data['credit_records'] = $this->Accounts_model->get_general_ledger_accounts('Liabilities', '');


		// $data['sundry_accounts1'] = $this->Accounts_model->get_bank_cash_ledgers($Salary_payables);
		// $data['sundry_accounts2'] = $this->Accounts_model->get_bank_cash_ledgers($Salary_expense);

		// print_r($data['h_count']);
		// exit;


		$data['main_content'] = 'hr/emp_monthly_salary_add.php';
		$this->load->view('includes/template', $data);
	}



	function add_emp_monthly_salary()
	{
		$data['title'] = "Add Monthly Salary";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_emp_monthly_salary();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_monthly_salary_list');
		} else {
			$this->session->set_flashdata('warning', 'Name Already Exist');
			redirect('Hr/add_monthly_salary');
		}
	}


	///////////////////////////////////////////end//////////////////data salary///////////


	function get_monthly_salary()
	{
		$data['title'] = "Monthly Salary";
		$data['effective_date'] = $this->input->post('effective_date');
		$data['user_id'] = $this->input->post('user_id');

		if ($data['effective_date'] == '') {
			$data['effective_date'] = $this->uri->segment('3');
		}

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_data();
		$data['absent'] = $this->Hr_model->get_attendance_details();

		$effective_date = $this->input->post('effective_date');
		$selected_month_year = date('Y-m', strtotime($effective_date));
		$start_date = date('Y-m-01', strtotime($selected_month_year));
		$end_date = date('Y-m-t', strtotime($selected_month_year));
		$data['days_in_month'] = date('t', strtotime($selected_month_year));

		if ($data['user_id'] == '')
			$data['record1'] = array();
		else {
			$data['effective_date'] = $this->input->post('effective_date');
			$data['user_id'] = $this->input->post('user_id');

			$effective_date = $this->input->post('effective_date');
			$selected_month_year = date('Y-m', strtotime($effective_date));
			$start_date = date('Y-m-01', strtotime($selected_month_year));
			$end_date = date('Y-m-t', strtotime($selected_month_year));
			$data['days_in_month'] = date('t', strtotime($selected_month_year));

			$this->load->model('Hr_model');
			$data['records'] = $this->Hr_model->get_emp_monthly_salary_data();


			$this->load->model('Hr_model');
			$data['record1'] = $this->Hr_model->get_salary_structure_data();
			foreach ($data['record1'] as $r) {
				$data['record2'] = $this->Hr_model->get_salary_structure_details($r->sid);
			}
			$data['absent'] = $this->Hr_model->get_attendance_details();
		}
		$data['main_content'] = 'hr/emp_monthly_salary_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_emp_monthly_salary()
	{

		$data['title'] = "Monthly Salary List";
		// $data['from'] = $this->input->post('from');
		$data['from'] = date('Y-m', strtotime($this->input->post('from')));

		$data['to'] = ('Y-m-t');


		if ($this->input->post('from') != '') {
			$data['from'] = $this->input->post('from');
		}

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_list($data['from']);
		$data['main_content'] = 'hr/emp_monthly_salary_list.php';
		$this->load->view('includes/template', $data);
	}

	function view_emp_monthly_salary_list()
	{

		$data['title'] = "Monthly Salary List";
		$data['from'] = date('M-Y');
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary();
		$data['main_content'] = 'hr/emp_monthly_salary_list.php';
		$this->load->view('includes/template', $data);
	}





	function edit_emp_monthly_salary()
	{
		$data['title'] = "Edit Monthly Salary";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_by_id($id);
		$data['main_content'] = 'hr/emp_montly_salary_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_emp_monthly_salary()
	{
		$data['title'] = "Supplier Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_emp_monthly_salary($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_monthly_salary_list');
		}
	}
	function print_monthly_payslip()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_monthlypayslip_by_id($id);
		$data['record2'] = $this->Hr_model->get_monthly_salary_details($id);

		$this->load->view('hr/print/print_payslip.php', $data);
	}

	function print_monthly_record()
	{
		$data['from'] = $this->input->post('from');
		$data['to'] = ('Y-m-t');


		if ($this->input->post('from') != '') {
			$data['from'] = $this->input->post('from');
		}

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_list($data['from']);
		$this->load->view('hr/print/print_payslip_record.php', $data);
	}


	function export_monthly_record()
	{

		$data['from'] = $this->input->post('from');
		$data['to'] = ('Y-m-t');


		if ($this->input->post('from') != '') {
			$data['from'] = $this->input->post('from');
		}

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_list($data['from']);

		$this->load->view('hr/print/export_payslip_record.php', $data);
	}
	function delete_emp_monthly_salary_record()
	{
		$sid = $this->input->post('sid');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->delete_emp_salary($sid);
		echo $res;
	}


	public function delete_monthly_salary()
	{
		$sid = $this->input->post('sid');

		if (empty($sid)) {
			echo json_encode(['status' => 'error', 'msg' => 'Invalid ID']);
			return;
		}

		$this->db->trans_start();

		// 🔹 Delete salary details
		$this->db->where('sid', $sid);
		$this->db->delete('employee_monthly_salary_details');

		// 🔹 Delete voucher entries (VERY IMPORTANT)
		$this->db->where('trans_id', $sid);
		$this->db->where('trans_type', 'MS');
		$this->db->delete('voucher_transaction');

		// 🔹 Delete main salary record
		$this->db->where('sid', $sid);
		$this->db->delete('employee_monthly_salary');

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			echo json_encode(['status' => 'error', 'msg' => 'Delete failed']);
		} else {
			echo json_encode(['status' => 'success', 'msg' => 'Salary deleted successfully']);
		}
	}

	////////////////////////////////////////gratuaty-start/////////////////////////////////////////////
	function add_gratuity()
	{
		$data['title'] = "Gratuity Details";

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_allowances_list();

		$data['main_content'] = 'hr/add_gratuity_details.php';
		$this->load->view('includes/template', $data);
	}
	function view_gratuity_list()
	{
		$data['title'] = "Gratuity Details List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_vehicle_list();
		$data['main_content'] = 'hr/gratuity_detail_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_gratuity_details()
	{
		$data['title'] = " Add Gratuity Details";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_vehicle_details();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_gratuity_list');
		} else {
			$this->session->set_flashdata('warning', 'Gratuity Details Name Already Exist');
			redirect('Hr/add_gratuity');
		}
	}

	function edit_gratuity_details()
	{
		$data['title'] = " Edit Gratuity Details";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_vehicle_details_by_id($id);
		$data['main_content'] = 'hr/edit_gratuity_details.php';
		$this->load->view('includes/template', $data);
	}

	function update_gratuity()
	{
		$data['title'] = "Update Gratuity Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_vehicle_details($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_gratuity_list');
		}
	}
	function delete_gratuity_details()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_vehicle_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_gratuity_list');
	}



	///employee_corner
	//////////////////////////////employee corner //////////////////
	/////////////////////////////////leavev///////////////////////////
	function add_leave_corner_application()
	{
		$data['title'] = "Leave application";
		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();

		$this->load->model('Hr_model');
		$data['category'] = $this->Hr_model->get_leave_category_list();

		$data['main_content'] = 'hr/leave_corner_allocation_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_leave_corner_application_list()
	{
		$data['title'] = "Leave application";
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_leave_corner_list();
		// $data['records'] = $this->Hr_model->get_employee_leave_by_id($id);
		$data['record1'] = $this->Hr_model->leave_approval_list();
		$data['main_content'] = 'hr/leave_corner_allocation_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_leave_corner_application_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_employee_leave_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_leave_corner_application_list');
		} else {
			$this->session->set_flashdata('warning', 'employee Company Name Already Exist');
			redirect('Hr/view_leave_corner_application_list');
		}
	}

	function edit_leave_corner_application()
	{
		$data['title'] = "Edit Leave application";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_leave_by_id($id);
		$data['file_records'] = $this->Hr_model->get_employee_leave_doc_id($id);
		$data['category'] = $this->Hr_model->get_leave_category_list();

		$data['main_content'] = 'hr/leave_corner_allocation_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_leave_corner_application()
	{
		$data['title'] = "Edit Leave application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_employee_leave($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_leave_corner_application_list');
		}
	}
	function delete_leave_corner_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_leave_application($id);

		$this->session->set_flashdata('success', 'Record Delete Successfully');
		redirect('Hr/view_leave_corner_application_list');
	}
	////////////////////////////////emd employee leave employee corner//////////////////////
	/// start resigignation///////////


	///////////////////////////////////////add_resignation////////////////////////////////////////////// 

	function add_regignation_corner()
	{
		$data['title'] = "Add Resignaion";

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_resignation_for_corner();

		$data['main_content'] = 'hr/resignation_corner_emp_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_emp_regignation_corner_list()
	{
		$data['title'] = "Resignation List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_regignation_corner_list();
		$data['main_content'] = 'hr/resignation_corner_emp_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_regignation_corner_data()
	{
		$data['title'] = "Add resignation";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_resignation();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_regignation_corner_list');
		} else {
			$this->session->set_flashdata('warning', 'employee  Name Already Exist');
			redirect('Hr/add_regignation_corner');
		}
	}

	function edit_emp_regignation_corner()
	{
		$data['title'] = "Edit Resignation";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_resigning_by_id($id);
		$data['file_records'] = $this->Hr_model->get_employee_document_doc_id($id);

		$data['main_content'] = 'hr/resignation_corner_emp_edit.php';
		$this->load->view('includes/template', $data);
	}
	function update_emp_regignation_corner()
	{
		$data['title'] = "Update Resignation";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_resigning_application($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_regignation_corner_list');
		}
	}
	/////////////////////////////// start approval setp///////////////////////////////////
	function approval_setup()
	{
		$data['title'] = "Approval Setup";

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_approval_setup_list();

		$data['main_content'] = 'hr/approval_setup.php';
		$this->load->view('includes/template', $data);
	}
	function add_approve_data()
	{
		$data['title'] = "Approval Setup";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_approve_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/approval_setup_list');
		} else {
			$this->session->set_flashdata('warning', ' data Already Exist');
			redirect('Hr/approval_setup');
		}
	}

	function approval_setup_list()
	{
		$data['title'] = "Approval Setup List";

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_approval_setup_list();

		$data['main_content'] = 'hr/approval_setup_list.php';
		$this->load->view('includes/template', $data);
	}

	function approval_setup_edit()
	{
		$data['title'] = "Approval Setup Edit";

		$id = $this->uri->segment('3');
		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_approval_setup_list_by_id($id);

		$data['main_content'] = 'hr/approval_setup_edit.php';
		$this->load->view('includes/template', $data);
	}
	function update_approval_data()
	{
		$data['title'] = "Update Approval Setup";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->update_approve_data($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/approval_setup_list');
		} else {
			$this->session->set_flashdata('warning', ' data Already Exist');
			redirect('Hr/approval_setup_list');
		}
	}
	///////////////////////////////////////start Advance Salary//////////////////////////////////////////

	function add_advance_salary()
	{
		$data['title'] = "Advance Salary";

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_user_list();

		$data['main_content'] = 'hr/add_advance_salary.php';
		$this->load->view('includes/template', $data);
	}
	function view_advance_salary_list()
	{
		$data['title'] = "Advance Salary List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_advance_salary_list();
		$data['main_content'] = 'hr/list_advance_salary.php';
		$this->load->view('includes/template', $data);
	}

	function add_advance_salary_details()
	{
		$data['title'] = " Add Advance Salary";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_advance_salary();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_advance_salary_list');
		} else {
			$this->session->set_flashdata('warning', 'Record Already Exist');
			redirect('Hr/add_advance_salary');
		}
	}

	function edit_advance_salary()
	{
		$data['title'] = " Edit Advance Salary ";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_user_list();
		$data['records'] = $this->Hr_model->get_advance_salary_list_by_id($id);
		$data['main_content'] = 'hr/edit_advance_salary.php';
		$this->load->view('includes/template', $data);
	}

	function update_advance_salary()
	{
		$data['title'] = "Update Advance Salary";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_advance_salary($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_advance_salary_list');
		}
	}
	function delete_advance_salary()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_advance_salary($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_advance_salary_list');
	}
	///////////////////////////////////////////End advance salary//////////////////////////////////////////
	/////////////////////////////////start paid_leave////////////////////////////////////

	function paid_leave()
	{
		$data['title'] = "Add Leave Days";

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_paid_leave_active_list();
		$data['category'] = $this->Hr_model->get_leave_category_list();

		$data['main_content'] = 'hr/paid_leave_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_paid_leave_list()
	{
		$data['title'] = "Leave Days List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_paid_leave_list();
		// log_message('error', 'records: ' . print_r($data['records'], true));
		$data['current_year'] = date('Y');

		$data['main_content'] = 'hr/paid_leave_list.php';
		$this->load->view('includes/template', $data);
	}

	function filter_paid_leave_list()
	{
		$data['title'] = "Leave Days List";
		$this->load->model('Hr_model');



		$data['current_year'] = $this->input->post('current_year');


		$data['records'] = $this->Hr_model->filter_paid_leave_list($data['current_year']);
		$data['main_content'] = 'hr/paid_leave_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_paid_leave_data()
	{
		$data['title'] = "Add  Leave Days";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_paid_leave_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_paid_leave_list');
		} else {
			$this->session->set_flashdata('warning', 'Supplier Company Name Already Exist');
			redirect('Hr/paid_leave');
		}
	}

	function edit_paid_leave()
	{
		$data['title'] = "Edit Leave Days";
		$id = $this->uri->segment('3');

		$this->load->model('Setup_model');
		$data['user_recordsold'] = $this->Setup_model->get_all_users();

		$this->load->model('Employee_model');
		$data['user_records'] = $this->Employee_model->get_all_employees();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_paid_leave_by_id($id);
		$data['trans'] = $this->Hr_model->get_paid_leave_transaction_by_id($id);
		$data['category'] = $this->Hr_model->get_leave_category_list();


		$data['main_content'] = 'hr/paid_leave_edit.php';
		$this->load->view('includes/template', $data);
	}
	function update_paid_leave()
	{
		$data['title'] = "Update Leave Days";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_paid_leave_data($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_paid_leave_list');
		}
	}




	function delete_paid_leave()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_paid_leave($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_paid_leave_list');
	}


	/////////////////////////////////////end paidleave//////////////////////////////////
	/////////////////////////////////////start holiday//////////////////////////////////

	function holiday()
	{
		$data['title'] = "Add Holiday Data";



		$data['main_content'] = 'hr/holiday_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_holiday_list()
	{
		$data['title'] = "Holiday Data List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_holiday_list();
		$data['main_content'] = 'hr/holiday_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_holiday_data()
	{
		$data['title'] = "Add Paid Leave";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_holiday_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_holiday_list');
		} else {
			$this->session->set_flashdata('warning', 'Name Already Exist');
			redirect('Hr/holiday');
		}
	}

	function edit_holiday_data()
	{
		$data['title'] = "Edit Holiday Data";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_holiday_list_by_id($id);

		$data['main_content'] = 'hr/holiday_edit.php';
		$this->load->view('includes/template', $data);
	}
	function update_holiday_data()
	{
		$data['title'] = "Update Holiday Data";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_holiday_data($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_holiday_list');
		}
	}




	function delete_holiday_data()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_holiday_data($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_holiday_list');
	}

	public function check_holiday_date()
	{
		$date = $this->input->post('date');
		$this->load->model('Hr_model'); // Load your model
		$exists = $this->Hr_model->check_date_exists($date); // Query your database

		echo json_encode(['exists' => $exists]);
	}


	/////////////////////////////////////end holiday//////////////////////////////////
	////////////////////////////start employee request///////////////////////////////

	function add_emp_req_application()
	{
		$data['title'] = "Employee Request";
		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();

		$this->load->model('Hr_model');
		$data['allowance'] = $this->Hr_model->get_allowances_list();
		$data['gross_salary'] = $this->Hr_model->get_employee_emp_ad_amount();

		$data['main_content'] = 'hr/add_emp_req_application.php';
		$this->load->view('includes/template', $data);
	}

	function add_comp_off_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->add_comp_off_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}
	function add_advance_salary_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->add_advance_salary_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}
	function add_allowance_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');


		$flag = $this->Hr_model->add_allowance_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}
	function add_loan_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->add_loan_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}



	function view_emp_request_list()
	{
		$data['title'] = "Employee Application List ";
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_request_list();
		$data['main_content'] = 'hr/emp_req_application_list.php';
		$this->load->view('includes/template', $data);
	}



	function view_emp_request_edit()
	{
		$data['title'] = "Edit Employee Request ";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_request_list_by($id);

		$data['request'] = !empty($data['records']) ? $data['records'][0] : null;

		$data['allowance'] = $this->Hr_model->get_allowances_list();

		$data['records1'] = $this->Hr_model->get_employee_request_list_by_comp($id);

		$data['records2'] = $this->Hr_model->get_employee_request_list_by_salary($id);
		$data['records3'] = $this->Hr_model->get_employee_request_list_by_allowance($id);
		$data['records4'] = $this->Hr_model->get_employee_request_list_by_loan($id);

		$data['file_records1'] = $this->Hr_model->get_employee_req_advance_doc_id($id);
		$data['file_records2'] = $this->Hr_model->get_employee_req_allowance_doc_id($id);
		$data['file_records3'] = $this->Hr_model->get_employee_req_loan_doc_id($id);

		$data['items'] = $this->Hr_model->get_service_request_items($id);

		$data['main_content'] = 'hr/emp_req_application_edit.php';
		$this->load->view('includes/template', $data);
	}

	////////////////////////////update data/////////////



	function update_comp_off_data()
	{
		$data['title'] = "Comp Off application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employee_request_comp_off($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}
	function update_advance_salary_data()
	{
		$data['title'] = "Advance Salary application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employee_request_advance($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}
	function update_allowance_data()
	{
		$data['title'] = "Extra Allowance application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');


		$flag = $this->Hr_model->update_employee_request_allowance($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}
	function update_loan_data()
	{
		$data['title'] = "Update Loan Request";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employee_request_loan($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_request_list');
		}
	}


	////////////////////////////////start emloyee request handel by hr form start///

	function add_emp_req_data()
	{
		$data['title'] = "Employee Application List";
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_request_data_list();
		$data['main_content'] = 'hr/emp_req_data_list.php';
		$this->load->view('includes/template', $data);
	}
	function add_list_hr()
	{
		$data['title'] = "Employee Application List ";

		redirect('Hr/add_emp_req_data');
	}

	function view_emp_request_edit_data()
	{
		$data['title'] = "Edit Employee Request ";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_request_list_by_hr($id);

		$data['allowance'] = $this->Hr_model->get_allowances_list();
		$data['items'] = $this->Hr_model->get_service_request_items($id);


		// $data['records1'] = $this->Hr_model->get_employee_request_list_by_comp($id);

		// $data['records2'] = $this->Hr_model->get_employee_request_list_by_salary($id);
		// $data['records3'] = $this->Hr_model->get_employee_request_list_by_allowance($id);
		// $data['records4'] = $this->Hr_model->get_employee_request_list_by_loan($id);

		$data['file_records1'] = $this->Hr_model->get_employee_req_advance_doc_id($id);
		$data['file_records2'] = $this->Hr_model->get_employee_req_allowance_doc_id($id);
		$data['file_records3'] = $this->Hr_model->get_employee_req_loan_doc_id($id);

		$data['main_content'] = 'hr/emp_req_data_edit.php';
		$this->load->view('includes/template', $data);
	}


	function update_comp_off_data_hr()
	{
		$data['title'] = "Leave application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employee_request_comp_off_hr($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/add_emp_req_data');
		}
	}
	function update_advance_salary_data_hr()
	{
		$data['title'] = "Leave application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employee_request_advance_hr($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/add_emp_req_data');
		}
	}
	function update_allowance_data_hr()
	{
		$data['title'] = "Leave application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');


		$flag = $this->Hr_model->update_employee_request_allowance_hr($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/add_emp_req_data');
		}
	}
	function update_loan_data_hr()
	{
		$data['title'] = "Update Employee Request";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employee_request_loan_hr($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/add_emp_req_data');
		}
	}

	function update_missing_attendance_data_hr()
	{
		$data['title'] = "Update Employee Request";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employee_request_attendance_hr($id);
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/add_emp_req_data');
		}
	}
	// ///////////////////////////////end employee request////////////////////////////
	/***
	 * Author: Teena VI
	 * Date : 21/3/2025
	 * Aim : Add / Update and View Workforce Requisition
	 */

	function add_workforce_requisition()
	{
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');
		$data['title'] = "Workforce Requisition Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['logged_user_id'] = $this->session->userdata('user_id');
		$data['comp_hr_hod_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Work Requisition Form');
		$data['comp_hr'] = $this->Hr_model->item_hr_list('Work Requisition Form');

		$data['main_content'] = 'hr/workforce_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_workforce_requisition_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_workforce_requisition_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_workforce_requisition');
		}
	}

	function list_workforce_requisition()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Workforce Requisition";
		$data['records'] = $this->Hr_model->get_all_requisition_details();

		$data['main_content'] = 'hr/workforce_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_workforce_requisition()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');
		$data['title'] = "Workforce Requisition Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Hr_model->get_requisition_details_by_id($id);
		$data['user_details'] = $this->Users_model->get_user_record_by_id($this->session->userdata('user_id'));
		$data['comp_hr_hod_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Work Requisition Form');
		$data['comp_hr'] = $this->Hr_model->item_hr_list('Work Requisition Form');


		$data['main_content'] = 'hr/workforce_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_workforce_requisition_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_workforce_requisition_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_workforce_requisition');
		}
	}

	function print_job_desc($id)
	{
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_requisition_by_id($id);
		$data['main_content'] = 'hr/print/print_job_desc.php';
		$this->load->view('hr/print/print_job_desc.php', $data);
	}
	/*******end employee request*****/

	/**
	 * Teena VI
	 * Date : 02/04/2025
	 * Aim : Create / Edit / Delete and Print Interview Assessment Form
	 */
	function add_interview()
	{
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');
		$data['title'] = "Interview Assessment Form";
		$data['work_req_list'] = $this->Hr_model->get_all_requisition_details();
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['comp_hr_hod_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Interview Assessment');
		$data['main_content'] = 'hr/interview_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_interview_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_interview_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_interview');
		}
	}

	function list_interview()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Interview";
		$data['records'] = $this->Hr_model->get_all_interview_details();

		$data['main_content'] = 'hr/interview_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_interview()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');
		$data['title'] = "Workforce Requisition Form";
		$data['work_req_list'] = $this->Hr_model->get_all_requisition_details();
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Hr_model->get_inetrview_details_by_id($id);
		$data['user_details'] = $this->Users_model->get_user_record_by_id($this->session->userdata('user_id'));
		$data['comp_hr_hod_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Interview Assessment');

		$data['comp_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Interview Assessment');
		$data['comp_hr'] = $this->Hr_model->item_hr_list('Interview Assessment');

		$data['main_content'] = 'hr/interview_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_interview_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_interview_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_interview');
		}
	}

	function print_offerletter($id)
	{
		$this->load->model('Users_model');
		$data['records'] = $this->Users_model->get_user_record_by_id_print($id);
		$data['main_content'] = 'hr/print/print_job_offer.php';
		$this->load->view('hr/print/print_job_offer.php', $data);
	}

	function print_joiningform()
	{
		$data['main_content'] = 'hr/print/print_joining_letter.php';
		$this->load->view('hr/print/print_joining_letter.php', $data);
	}

	function print_joiningform_by_userid($id)
	{
		$this->load->model('Users_model');
		$data['records'] = $this->Users_model->get_user_record_by_id_print($id); //print_r($data['records']);die;
		if (!empty($data['records'][0]->user_id)) {
			$manager_id = $data['records'][0]->reporting_mngr;
			$data['manager_details'] = $this->Users_model->get_user_record_by_id($manager_id);
		}
		$data['pass'] = $this->Users_model->get_user_record_by_id_pass($id);
		$data['visa'] = $this->Users_model->get_user_record_by_id_visa($id);
		$data['emirates'] = $this->Users_model->get_user_record_by_id_emirat($id);
		$data['main_content'] = 'hr/print/print_joining_letter.php';
		$this->load->view('hr/print/print_joining_letter.php', $data);
	}

	/******INTERVIEW ASSESSMENT FORM END *****/
	/**
	 * Teena VI
	 * Date : 09/04/2025
	 * Aim : Create / Edit / Delete and Print Handover Form
	 */
	function add_asset()
	{
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$data['title'] = "Create Asset Handover Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['main_content'] = 'hr/asset_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_asset_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_asset_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_asset');
		}
	}

	function list_asset()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Asset HandOver";
		$data['records'] = $this->Hr_model->get_all_asset_details();

		$data['main_content'] = 'hr/asset_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_asset()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');
		$data['title'] = "Edit Asset Handover Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Hr_model->get_asset_details_by_id($id);
		//$data['user_details'] = $this->Users_model->get_user_record_by_id($this->session->userdata('user_id'));

		$data['main_content'] = 'hr/asset_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_asset_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_asset_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_asset');
		}
	}

	public function get_user_details($user_id)
	{

		$this->load->model('Users_model');
		$this->load->model('Hr_model');
		$user_details = $this->Users_model->get_user_record_by_id($user_id);
		$user_passport = $this->Users_model->get_user_record_by_id_pass($user_id);
		$user_emirate = $this->Users_model->get_user_record_by_id_emirat($user_id);
		$user_visa = $this->Users_model->get_user_record_by_id_visa($user_id);

		if (!empty($user_passport)) {
			$pass = $user_passport[0];
			$pass_no = $pass->document_number;
			$pass_expiry = $pass->expiry_date;
		} else {
			$pass_no = '';
			$pass_expiry = '';
		}
		if (!empty($user_emirate)) {
			$emirate = $user_emirate[0];
			$emirate_no = $emirate->document_number;
			$emirate_expiry = $emirate->expiry_date;
		} else {
			$emirate_no = '';
			$emirate_expiry = '';
		}

		if (!empty($user_visa)) {
			$visa = $user_visa[0];
			$visa_no = $visa->posession;
			$visa_expiry = $visa->expiry_date;
		} else {
			$visa_no = '';
			$visa_expiry = '';
		}


		if (!empty($user_details)) {

			$int_id = $user_details[0]->int_id;
			$user_interview = $this->Hr_model->get_user_record_by_id_interview($int_id);
			if (!empty($user_interview)) {
				$inter = $user_interview;
				$inter_date = $inter->interview_date;
			} else {
				$inter_date = '';
			}
			$user = $user_details[0]; // Assuming it's a single result
			$data = [
				'user_code' => $user->user_code,
				'user_name' => $user->user_name,
				'middle_name' => $user->middle_name,
				'last_name' => $user->last_name,
				'dept_id' => $user->dept_id,
				'desig_id' => $user->desig_id,
				'email_id' => $user->email_id,
				'contact_no' => $user->contact_no,
				'bdate' => $user->bdate,
				'emirate_no' => $emirate_no,
				'emirate_expiry' => $emirate_expiry,
				'visa_no' => $visa_no,
				'visa_expiry' => $visa_expiry,
				'passport_no' => $pass_no,
				'passport_expiry' => $pass_expiry,
				'joining_date' => $user->joining_date,
				'reporting_mngr' => $user->reporting_mngr,
				'interview_date' => $inter_date
			];
		} else {
			$data = [
				'user_code' => null,
				'user_name' => null,
				'middle_name' => null,
				'last_name' => null,
				'dept_id' => null,
				'desig_id' => null,
				'email_id' => null,
				'contact_no' => null,
				'bdate' => null,
				'emirate_no' => null,
				'emirate_expiry' => null,
				'visa_no' => null,
				'visa_expiry' => null,
				'passport_no' => null,
				'passport_expiry' => null,
				'joining_date' => null,
				'reporting_mngr' => null,
				'interview_date' => null
			];
		}

		// Return JSON with proper content type
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	function print_asset_form($asset_id)
	{
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_asset_by_id($asset_id); //print_r($data['records']);
		$data['main_content'] = 'hr/print/print_asset_form.php';
		$this->load->view('hr/print/print_asset_form.php', $data);
	}

	/********HandoverAsset form End******* */
	/**
	 * Teena VI
	 * Date : 10/04/2025
	 * Aim : Create / Edit / Delete and Employee Checklist
	 */
	function add_checklist()
	{
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Create Employee Checklist";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['interview_list'] = $this->Hr_model->get_all_interview_details();
		$data['main_content'] = 'hr/checklist_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_checklist_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_checklist_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_checklist');
		}
	}

	function list_checklist()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Checklist";
		$data['records'] = $this->Hr_model->get_all_checklist_details();

		$data['main_content'] = 'hr/checklist_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_checklist()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Edit Employee Checklist";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['interview_list'] = $this->Hr_model->get_all_interview_details();
		$data['record'] = $this->Hr_model->get_checklist_by_id($id);
		echo 'desig-' . $data['record']->desig_id . '-' . 'dept-' . $data['record']->dept_id;
		if (!empty($data['record'])) {
			$data['emirates'] = $this->Users_model->get_user_record_by_id_emirat($data['record']->user_id);
			$data['passport'] = $this->Users_model->get_user_record_by_id_pass($data['record']->user_id);
		}

		$data['main_content'] = 'hr/checklist_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_checklist_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_checklist_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_checklist');
		}
	}

	function print_checklist_form($check_id)
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$data['records'] = $this->Hr_model->get_checklist_by_id($check_id);

		if (!empty($data['records'])) {
			$data['emirates'] = $this->Users_model->get_user_record_by_id_emirat($data['records']->user_id);
			$data['passport'] = $this->Users_model->get_user_record_by_id_pass($data['records']->user_id);
			$data['manager_details'] = $this->Users_model->get_user_record_by_id($data['records']->reporting_mngr);
		}


		$data['main_content'] = 'hr/print/print_checklist_form.php';
		$this->load->view('hr/print/print_checklist_form.php', $data);
	}


	/**
	 * Teena VI
	 * Date : 24/04/2025
	 * Aim : Create / Edit / Delete and Employee Compensatory
	 */
	function add_compensatory()
	{
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Employee Compensatory Off Reimbursement Request";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['comp_hr_hod_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Employee Compensatory Off Reimbursement');
		$data['main_content'] = 'hr/compensatory_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_compensatory_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_compensatory_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_compensatory');
		}
	}

	function list_compensatory()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Compensatory";
		$data['records'] = $this->Hr_model->get_all_compensatory_details();

		$data['main_content'] = 'hr/compensatory_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_compensatory()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Edit Employee Checklist";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['comp_hr_hod_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Employee Compensatory Off Reimbursement');
		$data['record'] = $this->Hr_model->get_compensatory_by_id($id);
		$data['record1'] = $this->Hr_model->get_compensatory_details_by_id($id);

		$data['main_content'] = 'hr/compensatory_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_compensatory_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_compensatory_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_compensatory');
		}
	}


	/**
	 * Teena VI
	 * Date : 28/04/2025
	 * Aim : Create / Edit / Delete and Employee Clearance Form
	 */
	public function add_clearance()
	{
		$this->load->model('Setup_model');
		$this->load->model('Users_model');

		$user_id = $this->session->userdata('user_id');  // get logged-in user id

		$employee_name = '';
		if ($user_id) {
			$employee = $this->Users_model->get_user_by_id($user_id);
			if ($employee) {
				$employee_name = trim($employee->user_name . ' ' . $employee->middle_name . ' ' . $employee->last_name);
			}
		}

		$data['title'] = "Employee Clearance Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();

		$data['employee_name'] = $employee_name;
		$data['user_id'] = $user_id;
		$data['resignation_id'] = '';

		$data['main_content'] = 'hr/clearance_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_clearance_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_clearance_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_clearance');
		}
	}

	function list_clearance()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Clearance";
		$data['records'] = $this->Hr_model->get_all_clearance_details();

		$data['main_content'] = 'hr/clearance_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_clearance()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Edit Employee Clearance Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['record'] = $this->Hr_model->get_clearance_by_id($id);
		$data['record1'] = $this->Hr_model->get_clearance_details_by_id($id);
		if (!empty($data['record'])) {
			$data['emirates'] = $this->Users_model->get_user_record_by_id_emirat($data['record']->user_id);
			$data['passport'] = $this->Users_model->get_user_record_by_id_pass($data['record']->user_id);
			$data['visa'] = $this->Users_model->get_user_record_by_id_visa($data['record']->user_id);
		}

		$data['main_content'] = 'hr/clearance_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_clearance_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_clearance_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_clearance');
		}
	}

	function print_clearance_form($id)
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$data['records'] = $this->Hr_model->get_clearance_by_id($id);
		$data['record1'] = $this->Hr_model->get_clearance_details_by_id($id);

		if (!empty($data['records'])) {
			$data['emirates'] = $this->Users_model->get_user_record_by_id_emirat($data['records']->user_id);
			$data['passport'] = $this->Users_model->get_user_record_by_id_pass($data['records']->user_id);
			$data['visa'] = $this->Users_model->get_user_record_by_id_visa($data['records']->user_id);
			// $data['manager_details'] = $this->Users_model->get_user_record_by_id($data['records']->reporting_mngr);
		}


		$data['main_content'] = 'hr/print/print_clearance_form.php';
		$this->load->view('hr/print/print_clearance_form.php', $data);
	}

	/**
	 * Teena VI
	 * Date : 2/05/2025
	 * Aim : Create / Edit / Delete and Employee Performance Review Form
	 */
	function add_review()
	{
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Employee Performance Review Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['main_content'] = 'hr/review_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_review_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_review_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_review');
		}
	}

	function list_review()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Review";
		$data['records'] = $this->Hr_model->get_all_review_details();

		$data['main_content'] = 'hr/review_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_review()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Edit Employee Performance Review Form";
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['record'] = $this->Hr_model->get_review_by_id($id);
		$data['record1'] = $this->Hr_model->get_review_details_by_id($id);

		$data['comp_hr_hod_ceo'] = $this->Hr_model->item_hr_admin_ceo_list('Performance Review Form');
		$data['comp_hr'] = $this->Hr_model->item_hr_list('Performance Review Form');
		$data['main_content'] = 'hr/review_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_review_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_review_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_review');
		}
	}

	function print_review_form($id)
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$data['records'] = $this->Hr_model->get_review_by_id($id);
		$data['record1'] = $this->Hr_model->get_review_details_by_id($id);

		$data['main_content'] = 'hr/print/print_review_form.php';
		$this->load->view('hr/print/print_review_form.php', $data);
	}

	/**
	 * Teena VI
	 * Date : 05/05/2025   
	 * Aim : Create / Edit / Delete and Employment Application Form
	 */
	function add_employment()
	{
		$this->load->model('Setup_model');

		$data['title'] = "Employment Application Form";
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['main_content'] = 'hr/employment_application_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_employment_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_employment_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_employment');
		}
	}

	function list_employment()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Employment Application Form";
		$data['records'] = $this->Hr_model->get_all_employment_details();

		$data['main_content'] = 'hr/employment_application_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_employment()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Setup_model');
		$this->load->model('Hr_model');

		$data['title'] = "Edit Employee Checklist";
		$data['desig_list'] = $this->Setup_model->get_designation_list();

		$data['record'] = $this->Hr_model->get_employment_by_id($id); //print_r($data['record']);die;
		$data['works'] = $this->Hr_model->get_employment_work_by_id($id);
		$data['family'] = $this->Hr_model->get_employment_family_by_id($id);
		$data['education'] = $this->Hr_model->get_employment_education_by_id($id);

		$data['main_content'] = 'hr/employment_application_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_employment_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_employment_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_employment');
		}
	}

	function print_employment($id)
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');

		$data['record'] = $this->Hr_model->get_employment_by_id($id); //print_r($data['record']);die;
		$data['works'] = $this->Hr_model->get_employment_work_by_id($id);
		$data['family'] = $this->Hr_model->get_employment_family_by_id($id);
		$data['education'] = $this->Hr_model->get_employment_education_by_id($id);

		$data['main_content'] = 'hr/print/print_employment_application.php';
		$this->load->view('hr/print/print_employment_application.php', $data);
	}

	/**
	 * Teena VI
	 * Date : 07/05/2025
	 * Aim : Create / Edit / Delete and Vehicle Handover Form
	 */
	function add_vehicle_handover()
	{
		$this->load->model('Setup_model');
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$data['title'] = "Vehicle Handover Form";
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['drivers'] = $this->Hr_model->get_driver_list();
		$data['main_content'] = 'hr/vehicle_handover_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_vehicle_handover_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_vehicle_handover_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_vehicle_handover');
		}
	}

	function list_vehicle_handover()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Vehicle Handover Details";
		$data['records'] = $this->Hr_model->get_all_vehicle_handover_details();

		$data['main_content'] = 'hr/vehicle_handover_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_vehicle_handover()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');

		$data['title'] = "Edit Vehicle Handover Form";

		$data['user_records'] = $this->Users_model->get_user_list();
		$data['drivers'] = $this->Hr_model->get_driver_list();
		$data['veh_details'] = $this->Hr_model->get_vehicle_handover_by_id($id);

		$data['main_content'] = 'hr/vehicle_handover_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_vehicle_handover_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_vehicle_handover_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_vehicle_handover');
		}
	}


	function print_vehicle_handover($id)
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');

		$data['record'] = $this->Hr_model->get_vehicle_handover_by_id($id);

		$data['main_content'] = 'hr/print/print_vehicle_handover.php';
		$this->load->view('hr/print/print_vehicle_handover.php', $data);
	}

	/**
	 * Teena VI
	 * Date : 08/05/2025
	 * Aim : Create / Edit / Delete and Offer Letter Form
	 */
	function add_offer_letter()
	{
		$this->load->model('Setup_model');
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$data['title'] = "Create Offer Letter";
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();
		$data['main_content'] = 'hr/offer_letter_add.php';
		$this->load->view('includes/template', $data);
	}

	function add_offer_letter_data()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_offer_letter_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/list_offer_letter');
		}
	}

	function list_offer_letter()
	{
		$this->load->model('Hr_model');
		$data['title'] = "List Offer Letter Details";
		$data['records'] = $this->Hr_model->get_all_offer_letter_details();

		$data['main_content'] = 'hr/offer_letter_list.php';
		$this->load->view('includes/template', $data);
	}

	function edit_offer_letter()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Users_model');
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');

		$data['title'] = "Edit Offer Letter";

		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Hr_model->get_offer_letter_by_id($id);
		$data['salary'] = $this->Hr_model->get_offer_salary_by_id($id);
		$data['incentive'] = $this->Hr_model->get_offer_incentive_by_id($id);
		$data['desig_list'] = $this->Setup_model->get_designation_list();

		$data['main_content'] = 'hr/offer_letter_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_offer_letter_data()
	{
		$this->load->model('Hr_model');

		$flag = $this->Hr_model->update_offer_letter_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/list_offer_letter');
		}
	}


	function print_offer_letter($id)
	{
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_offer_letter_by_id($id);
		$data['salary'] = $this->Hr_model->get_offer_salary_by_id($id);
		$data['incentive'] = $this->Hr_model->get_offer_incentive_by_id($id);
		$data['main_content'] = 'hr/print/print_job_offer.php';
		$this->load->view('hr/print/print_job_offer.php', $data);
	}

	/////////////employee corner salary slip  suraj///////////
	public function emp_salary_slip()
	{
		$data['title'] = 'Monthly Salary List';

		$data['from'] = date('Y');



		// if ($this->input->post('from') != '') {
		// 	$data['from'] = $this->input->post('from');
		// }

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_for_emp_corner();

		$data['main_content'] = 'hr/emp_corner_monthly_salary_list.php';
		$this->load->view('includes/template.php', $data);
	}
	function view_emp_year_wise_salary()
	{
		$data['title'] = "Monthly Salary List";

		// Get year from form or use current year
		$year_input = $this->input->post('from');
		$year = !empty($year_input) ? substr($year_input, 0, 4) : date('Y');

		$data['from'] = $year;

		// Load records
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_list_get_year_wise($year);

		$data['main_content'] = 'hr/emp_corner_monthly_salary_list.php';
		$this->load->view('includes/template', $data);
	}

	///////////////////////////////////////add notification group////////////////////////////////////////////// 

	function add_notification_group()
	{
		$data['title'] = "Add Notification Group";

		$data['group_date'] = date('d-m-Y');
		$data['group_name'] = "";
		$data['designation_id'] = "";

		$this->load->model('Setup_model');
		$data['designation_list'] = $this->Setup_model->get_designation_list();

		$data['records'] = array();

		$data['main_content'] = 'hr/notification_group_add.php';
		$this->load->view('includes/template', $data);
	}


	function get_notification_group()
	{
		$data['title'] = "Add Notification Group";



		$data['group_name'] = $this->input->post('group_name');
		$data['group_date'] = $this->input->post('group_date');
		$data['designation_id'] = $this->input->post('designation_id');

		$this->load->model('Setup_model');
		$data['designation_list'] = $this->Setup_model->get_designation_list();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_user_list_by_designaton();

		$data['main_content'] = 'hr/notification_group_add.php';
		$this->load->view('includes/template', $data);
	}



	function view_notification_group_list()
	{

		$data['title'] = "Notification Group List";

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_notification_group_list();



		$data['main_content'] = 'hr/notification_group_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_notification_group_data()
	{
		$data['title'] = "Add Notification Group";

		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_notification_group_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_notification_group_list');
		} else {
			$this->session->set_flashdata('warning', 'Employee Name Already Exist');
			redirect('Hr/add_notification_group');
		}
	}

	function edit_notification_group()
	{
		$data['title'] = "Edit Notification Group";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_notification_group_list_by_id($id);
		$data['record1'] = $this->Hr_model->get_notification_group_data_by_group_user($id);


		$this->load->model('Hr_model');
		$data['record3'] = $this->Hr_model->get_user_list_by_designaton();

		$this->load->model('Setup_model');
		$data['designation_list'] = $this->Setup_model->get_designation_list();

		$data['main_content'] = 'hr/notification_group_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_notification_group()
	{
		$data['title'] = "Update Notification Group";
		$id = $this->input->post('group_id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_notification_group($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_notification_group_list');
		}
	}
	public function delete_notification_group()
	{
		$group_id = $this->input->post('group_id');

		$this->load->model('Hr_model');

		if (!empty($group_id)) {
			$res = $this->Hr_model->delete_group_wise_data($group_id);
			echo $res;
		} else {
			echo 0;
		}
	}

	public function user_list_groupid_wise()
	{
		$id = $this->input->post('group_id');
		$this->load->model('Hr_model');
		$users = $this->Hr_model->get_notification_group_data_by_group_user($id);
		if (!empty($users)) {
			$user_name = array_map(function ($u) {
				return htmlspecialchars($u->user_name);
			}, $users);

			echo implode(', ', $user_name);
		} else {
			echo '<em>No users found</em>';
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////add notification manages////////////////////////////////////////////// 

	function add_notification_manager()
	{
		$data['title'] = "Add Notification manage";



		$this->load->model('Hr_model');
		$data['master'] = $this->Hr_model->get_notification_manage_list();
		$data['group'] = $this->Hr_model->get_notification_group_list();

		$data['main_content'] = 'hr/notification_manage_add.php';
		$this->load->view('includes/template', $data);
	}

	public function view_notification_manage_list()
	{
		$data['title'] = "Notification manage List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_notification_manage_list_for();
		$data['main_content'] = 'hr/notification_manage_list.php';
		$this->load->view('includes/template', $data);
	}


	function add_notification_manage_data()
	{
		$data['title'] = "Add Notification manage";

		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_notification_manage_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_notification_manage_list');
		} else {
			$this->session->set_flashdata('warning', 'Employee Name Already Exist');
			redirect('Hr/add_notification_manager');
		}
	}

	function edit_notification_manage()
	{
		$data['title'] = "Edit Notification manage";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_notification_group_list_by_id($id);
		$data['record1'] = $this->Hr_model->get_notification_group_data_by_group_user($id);

		$this->load->model('Setup_model');
		$data['designation_list'] = $this->Setup_model->get_designation_list();

		$data['main_content'] = 'hr/notification_manage_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_notification_manage()
	{
		$data['title'] = "Update Notification manage";
		$id = $this->input->post('group_id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_notification_group($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_notification_manage_list');
		}
	}
	public function delete_notification_manage()
	{
		$notify_id = $this->input->post('notify_id');

		$this->load->model('Hr_model');

		if (!empty($notify_id)) {
			$res = $this->Hr_model->delete_manage_wise_data($notify_id);
			echo $res;
		} else {
			echo 0;
		}
	}
	public function group_user_details_ajax()
	{
		$group_ids = $this->input->post('group_ids');

		$this->load->model('Hr_model');
		$data = [];

		foreach ($group_ids as $id) {
			$group_result = $this->Hr_model->get_notification_group_list_by_id($id);
			$group_name = !empty($group_result) ? $group_result[0]->group_name : 'Unknown';

			$users = $this->Hr_model->get_notification_group_data_by_group_user($id);
			$user_names = array_map(function ($u) {
				return htmlspecialchars($u->user_name);
			}, $users);

			$data[] = [
				'group_name' => $group_name,
				'user_list' => !empty($user_names) ? implode(', ', $user_names) : 'No users'
			];
		}


		echo json_encode($data);
	}


	public function get_page_wise_groups_ajax()
	{
		$page_id = $this->input->post('page_id');
		$this->load->model('Hr_model');

		// Get group_id (comma separated string like "1,5,6")
		$group_ids_str = $this->Hr_model->get_group_ids_by_notify_id($page_id);

		if ($group_ids_str) {
			$group_ids = explode(',', $group_ids_str); // Convert to array
			echo json_encode(['status' => 'success', 'group_ids' => $group_ids]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No group found']);
		}
	}
	public function user_list_groupid_wise_bulk()
	{
		$group_ids = $this->input->post('group_ids'); // array
		$this->load->model('Hr_model');

		$html = '';

		foreach ($group_ids as $gid) {
			$users = $this->Hr_model->get_notification_group_data_by_group_user($gid);

			if (!empty($users)) {
				$user_names = array_map(function ($u) {
					return htmlspecialchars($u->user_name);
				}, $users);

				$group = $this->db->get_where('notification_group', ['group_id' => $gid])->row();
				$group_name = $group ? $group->group_name : 'Unknown';

				$html .= "<strong><u style='color:red;'>{$group_name}:</u></strong> " . implode(', ', $user_names) . "<br>";
			}
		}

		echo $html ?: '<em>No users found</em>';
	}

	function miss_attendance_report()
	{

		$data['title'] = "Attendance Record for Forty-Five Days";



		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_attendance_mismatch();
		$data['status'] = $this->Hr_model->get_emp_attendance_mismatch_status();


		$data['main_content'] = 'hr/employee_missmatch_attendance_add.php';
		$this->load->view('includes/template', $data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////

	//////////// leave_category   ///////////////////////



	function add_leave_category()
	{
		$data['title'] = 'Leave Category';
		$data['main_content'] = 'hr/add_leave_category.php';
		$this->load->view('includes/template.php', $data);
	}

	function add_category_records()
	{
		$data['title'] = 'Leave Category';
		$this->load->model('Hr_model');
		$insert_id = $this->Hr_model->add_category_data();
		if ($insert_id != '') {
			$this->session->set_flashdata('success', 'Data Saved Successfully..');
			redirect('hr/list_leave_category');
		}
	}

	function list_leave_category()
	{
		$data['title'] = 'Leave Category';
		$this->load->model('Hr_model');
		$data['category'] = $this->Hr_model->get_leave_category_list();

		$data['main_content'] = 'hr/list_leave_category.php';
		$this->load->view('includes/template.php', $data);
	}

	function edit_leave_category()
	{
		$data['title'] = 'Leave Category';
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['category'] = $this->Hr_model->get_leave_category_by_id($id);

		$data['main_content'] = 'hr/edit_leave_category.php';
		$this->load->view('includes/template.php', $data);
	}

	function update_category_records()
	{
		$id = $this->input->post('category_id');
		$this->load->model('Hr_model');
		$insert_id = $this->Hr_model->update_category($id);
		if ($insert_id != '') {
			$this->session->set_flashdata('success', 'Data Updated Successfully..');
			redirect('hr/list_leave_category');
		}
	}
	///////////////end leave category////////////////////

	///////////////sneha code 10 nov 2025/////////////////////////
















	///////////////////////////////////////////////////////////


	//////////////////////////////////////////salary advance functions////////////////////////////////////////////////////////////

	public function salary_advance()
	{
		$data['employees'] = $this->db
			->where('status', 'Active')
			->get('employees')->result();

		$data['cash_bank_ledgers'] = $this->db->query("
		SELECT account_id,account_name 
		FROM general_ledger
		WHERE group_no IN (19,21)")->result();
		$data['title'] = 'Salary Advance';
		$data['main_content'] = 'hr/salary_advance';
		$this->load->view('includes/template', $data);
	}

	public function generate_voucher_code($prefix)
	{
		// Example: SA (Salary Advance), JV, PV etc.

		$year = date('y'); // 26
		$full_prefix = $prefix . '/' . $year . '/';

		// Get last voucher number
		$this->db->like('voucher_code', $full_prefix, 'after');
		$this->db->order_by('voucher_code', 'DESC');
		$this->db->limit(1);

		$query = $this->db->get('voucher_transaction');

		if ($query->num_rows() > 0) {
			$last_code = $query->row()->voucher_code;

			// Extract last number
			$last_number = (int) substr($last_code, -5);
			$next_number = $last_number + 1;
		} else {
			$next_number = 1;
		}

		// Format: 00001
		$number = str_pad($next_number, 5, '0', STR_PAD_LEFT);

		return $full_prefix . $number;
	}

	public function save_salary_advance()
	{
		$emp_id = $this->input->post('emp_id');
		$amount = $this->input->post('amount');
		$date   = $this->input->post('advance_date');
		$ledger = $this->input->post('pay_ledger_id');
		$remarks = $this->input->post('remarks');
		$paymode = $this->input->post('payment_mode');

		$this->db->trans_start();

		/* INSERT ADVANCE TABLE */


		$this->db->insert('employee_salary_advance', [

			'emp_id' => $emp_id,
			'advance_date' => $date,
			'amount' => $amount,
			'balance_amount' => $amount,
			'status' => 'Pending',
			'remarks' => $remarks,
			'created_by' => $_SESSION['user_id'],
			'created_at' => date('Y-m-d H:i:s'),
			'payment_mode' => $paymode,
			'ledger_id' => $ledger

		]);
		$advance_id = $this->db->insert_id();

		/* ACCOUNT VOUCHER ENTRY */

		$voucher_no = $this->generate_voucher_code('SA');

		$emp_acc = $this->db
			->select('account_id, account_name')
			->from('general_ledger')
			->where('employee_id', $emp_id)
			->get()
			->row();

		$emp_acc_id = $emp_acc->account_id ?? '';
		$emp_acc_name = $emp_acc->account_name ?? '';



		// $voucher_no = 'ADV' . time();

		/* Debit Entry - Employee Advance */

		$this->db->insert('voucher_transaction', [

			'voucher_code' => $voucher_no,
			'voucher_date' =>  $date,
			'voucher_type' => 'SA',
			'account_id'   => $emp_acc_id,
			'drcr_type'    => 'Dr',
			'amount'       => $amount,
			'narration' => 'Salary advance to ' . $emp_acc_name . ' on ' . date('d-m-Y', strtotime($date)),
			'trans_id'   => $advance_id,
			'customer_id' => $emp_id,
			'trans_type' => 'SA'

		]);


		/* Credit Entry - Cash / Bank */

		$this->db->insert('voucher_transaction', [

			'voucher_code' => $voucher_no,
			'voucher_date' =>  $date,
			'voucher_type' => 'SA',
			'account_id'   => $ledger,
			'drcr_type'    => 'Cr',
			'amount'       => $amount,
			'narration'    => 'Salary Advance Payment',
			'trans_id'   => $advance_id,
			'customer_id' => $emp_id,
			'trans_type' => 'SA'

		]);



		$this->db->trans_complete();

		redirect('Hr/salary_advance_list');
	}

	public function salary_advance_list()
	{
		$this->load->model('Hr_model');
		$data['advances'] = $this->Hr_model->get_salary_advances();


		// echo "<pre>";
		// print_r($data['advances']);
		// echo "</pre>";
		// exit;
		$data['title'] = 'Salary Advance';
		$data['main_content'] = 'hr/salary_advance_list';
		$this->load->view('includes/template', $data);
	}

	public function delete_salary_advance($id)
	{
		$this->db->where('advance_id', $id);
		$this->db->delete('employee_salary_advance');

		$this->db->where('trans_id', $id);
		$this->db->delete('voucher_transaction');

		redirect('Hr/salary_advance_list');
	}

	public function edit_salary_advance($id)
	{
		$this->load->model('Hr_model');
		$this->load->model('Employee_model');

		$data['advance'] = $this->Hr_model->get_salary_advance_by_id($id);
		$data['employees'] = $this->Employee_model->get_all_employees();
		$data['cash_bank_ledgers'] = $this->db->query("
		SELECT account_id,account_name 
		FROM general_ledger
		WHERE group_no IN (19,21)")->result();


		$data['title'] = 'Salary Advance';
		$data['main_content'] = 'hr/salary_advance_edit';
		$this->load->view('includes/template', $data);
	}

	public function update_salary_advance()
	{
		$id = $this->input->post('advance_id');
		$emp_id = $this->input->post('emp_id');

		$amount = $this->input->post('amount');
		$date   = $this->input->post('advance_date');
		$ledger = $this->input->post('pay_ledger_id');
		$remarks = $this->input->post('remarks');
		$paymode = $this->input->post('payment_mode');

		$data = [
			'emp_id' => $this->input->post('emp_id'),
			'advance_date' => $this->input->post('advance_date'),
			'amount' => $this->input->post('amount'),
			'balance_amount' => $this->input->post('amount'), // simple logic
			'payment_mode' => $this->input->post('payment_mode'),
			'ledger_id' => $this->input->post('pay_ledger_id'),
			'remarks' => $this->input->post('remarks')
		];

		$this->db->where('advance_id', $id);
		$this->db->update('employee_salary_advance', $data);

		$this->db->where('trans_id', $id);
		$this->db->delete('voucher_transaction');

		/* ACCOUNT VOUCHER ENTRY */

		$voucher_no = $this->generate_voucher_code('SA');

		$emp_acc = $this->db
			->select('account_id, account_name')
			->from('general_ledger')
			->where('employee_id', $emp_id)
			->get()
			->row();

		$emp_acc_id = $emp_acc->account_id ?? '';
		$emp_acc_name = $emp_acc->account_name ?? '';
		// $voucher_no = 'ADV' . time();

		/* Debit Entry - Employee Advance */

		$this->db->insert('voucher_transaction', [

			'voucher_code' => $voucher_no,
			'voucher_date' =>  $date,
			'voucher_type' => 'SA',
			'account_id'   => $emp_acc_id,
			'drcr_type'    => 'Dr',
			'amount'       => $amount,
			'narration' => 'Salary advance to ' . $emp_acc_name . ' on ' . date('d-m-Y', strtotime($date)),
			'trans_id'   => $id,
			'customer_id' => $emp_id,
			'trans_type' => 'SA'

		]);


		/* Credit Entry - Cash / Bank */

		$this->db->insert('voucher_transaction', [

			'voucher_code' => $voucher_no,
			'voucher_date' =>  $date,
			'voucher_type' => 'SA',
			'account_id'   => $ledger,
			'drcr_type'    => 'Cr',
			'amount'       => $amount,
			'narration'    => 'Salary Advance Payment',
			'trans_id'   => $id,
			'customer_id' => $emp_id,
			'trans_type' => 'SA'

		]);


		redirect('Hr/salary_advance_list');
	}

	public function print_salary_advance($id)
	{

		$this->load->model('Hr_model');
		$data['advance'] = $this->Hr_model->get_salary_advance_by_id_details($id);
		// $data['title'] = 'Salary Advance';
		// echo "<pre>";
		// print_r($data['advance']);
		// echo "</pre>";
		// exit;
		$this->load->view('hr/print/print_salary_advance', $data);
	}
}
