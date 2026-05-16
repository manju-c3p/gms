<?php
class Employee extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Employee_model');
	}

	public function add()
	{
		$data['title'] = "Employee";
		$data['departments'] = $this->Employee_model->get_departments();
		$data['main_content'] = 'employee/addemployee';
		$this->load->view('includes/template', $data);
	}

	public function save()
	{
		$this->Employee_model->save_employee($this->input->post());
		redirect('Employee');
	}

	public function index()
	{
			$data['title'] = "Employee List";
		$this->load->model('Employee_model');
		$data['employees'] = $this->Employee_model->get_all_employees();
		$data['main_content'] = 'employee/list';
		$this->load->view('includes/template', $data);
	}

	public function delete($id)
	{
		// Get employee record first
		$employee = $this->db->where('employee_id', $id)
			->get('employees')
			->row();

		if (!$employee) {
			redirect('Employee');
		}

		/* ===============================
			DELETE PASSPORT FILE
			=============================== */

		if (
			!empty($employee->passport_file) &&
			file_exists('./uploads/passports/' . $employee->passport_file)
		) {

			unlink('./uploads/passports/' . $employee->passport_file);
		}

		/* ===============================
			DELETE USER ACCOUNT
			=============================== */

		$this->db->where('employee_id', $id)
			->delete('users');

		/* ===============================
			DELETE EMPLOYEE
			=============================== */

		$this->db->where('employee_id', $id)
			->delete('employees');

		redirect('Employee');
	}

	public function edit($id)

	{
			$data['title'] = "Edit Employee";
		$this->load->model('Employee_model');

		$data['employee'] = $this->Employee_model->get_employee($id);
		$data['departments'] = $this->Employee_model->get_departments();
		$data['designations'] = $this->Employee_model->get_designations_by_department($data['employee']->department_id);
		$data['main_content'] = 'employee/edit';
		$this->load->view('includes/template', $data);
	}

	public function update()
	{
		$employee_id = $this->input->post('employee_id');

		$this->load->model('Employee_model');

		$this->Employee_model->update_employee(
			$employee_id,
			$this->input->post()
		);

		redirect('Employee');
	}
	/* =====================================================
       SAVE DEPARTMENT (AJAX)
       URL: index.php/employee/save_department
       ===================================================== */
	public function save_department()
	{
		$department_name = trim($this->input->post('name'));

		if ($department_name === '') {
			echo json_encode([
				'status' => false,
				'message' => 'Department name is required'
			]);
			return;
		}

		// Optional: prevent duplicates
		$exists = $this->db
			->where('department_name', $department_name)
			->get('departments')
			->row();

		if ($exists) {
			echo json_encode([
				'status' => false,
				'message' => 'Department already exists'
			]);
			return;
		}

		$this->Employee_model->save_department($department_name);

		echo json_encode([
			'status' => true,
			'message' => 'Department added successfully'
		]);
	}

	/* =====================================================
       SAVE DESIGNATION (AJAX)
       URL: index.php/employee/save_designation
       ===================================================== */
	public function save_designation()
	{
		$department_id = $this->input->post('department_id');
		$designation   = trim($this->input->post('name'));

		if (!$department_id || $designation === '') {
			echo json_encode([
				'status' => false,
				'message' => 'Department and designation are required'
			]);
			return;
		}

		// Optional: prevent duplicate designation per department
		$exists = $this->db
			->where('department_id', $department_id)
			->where('designation_name', $designation)
			->get('designations')
			->row();

		if ($exists) {
			echo json_encode([
				'status' => false,
				'message' => 'Designation already exists in this department'
			]);
			return;
		}

		$this->Employee_model->save_designation($department_id, $designation);

		echo json_encode([
			'status' => true,
			'message' => 'Designation added successfully'
		]);
	}

	public function get_designations_by_department()
	{
		$department_id = $this->input->post('department_id');

		if (!$department_id) {
			echo json_encode([]);
			return;
		}

		$designations = $this->Employee_model
			->get_designations_by_department($department_id);

		echo json_encode($designations);
	}
}
