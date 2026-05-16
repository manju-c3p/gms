<?php
class Employee_model extends CI_Model
{
	/* =====================================================
       DEPARTMENTS
       ===================================================== */

	// Get all active departments
	public function get_departments()
	{
		return $this->db
			->where('is_active', 1)
			->order_by('department_name', 'ASC')
			->get('departments')
			->result();
	}
	public function get_designations()
	{
		return $this->db
			->where('is_active', 1)
			->order_by('designation_name', 'ASC')
			->get('designations')
			->result();
	}

	// Insert new department
	public function save_department($department_name)
	{
		return $this->db->insert('departments', [
			'department_name' => $department_name
		]);
	}

	/* =====================================================
       DESIGNATIONS
       ===================================================== */

	// Get designations by department
	public function get_designations_by_department($department_id)
	{
		return $this->db
			->where('department_id', $department_id)
			->where('is_active', 1)
			->order_by('designation_name', 'ASC')
			->get('designations')
			->result();
	}

	// Insert new designation
	public function save_designation($department_id, $designation_name)
	{
		return $this->db->insert('designations', [
			'department_id'   => $department_id,
			'designation_name' => $designation_name
		]);
	}

	/* =====================================================
       EMPLOYEES
       ===================================================== */

	// Insert employee (Technician / Advisor / Admin)
	public function save_employee($data)
	{
		/* ===============================
			HANDLE PASSPORT FILE UPLOAD
					=============================== */

		$passport_file = null;

		if (!empty($_FILES['passport_file']['name'])) {
			$config['upload_path']   = './uploads/passports/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['max_size']      = 2048;
			$config['file_name']     = 'passport_' . time();

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('passport_file')) {
				$uploadData = $this->upload->data();
				$passport_file = $uploadData['file_name'];
			}
		}


		/* ===============================
       INSERT INTO EMPLOYEES TABLE
    			=============================== */

		$employeeData = [

			'employee_code'   => $data['employee_code'] ?? null,
			'employee_name'   => $data['employee_name'],
			'mobile'          => $data['mobile'] ?? null,
			'email'           => $data['email'] ?? null,
			'address'         => $data['address'] ?? null,

			'department_id'   => $data['department_id'],
			'designation_id'  => $data['designation_id'],

			'role'            => $data['role'] ?? 'Technician',
			'joining_date'    => $data['joining_date'] ?? null,

			'software_access' => $data['software_access'] ?? 'No',

			'passport_number'           => $data['passport_number'] ?? null,
			'passport_issue_date'      => $data['passport_issue_date'] ?? null,
			'passport_expiry_date'     => $data['passport_expiry_date'] ?? null,
			'passport_location'        => $data['passport_location'] ?? null,
			'passport_expiry_reminder' => $data['passport_expiry_reminder'] ?? null,
			'passport_file'            => $passport_file,

			'status' => 'Active'
		];


		$this->db->insert('employees', $employeeData);

		$employee_id = $this->db->insert_id();

		$ledger_data = [
			'account_name' => $data['employee_name'],
			'group_no'     => 67, // create group like Employee Loan & Advances
			'employee_id'  => $employee_id,
			'opening_balance' => 0,
			'opening_bal_type' => 'Cr'
		];

		$this->db->insert('general_ledger', $ledger_data);
		/* ===============================
       CREATE USER ACCOUNT
    			=============================== */

		if ($employee_id && $data['software_access'] == 'Yes') {
			$nameParts = explode(' ', $data['employee_name'], 2);

			$userData = [

				'employee_id' => $employee_id,

				'first_name' => $nameParts[0],

				'last_name' => $nameParts[1] ?? '',

				'email' => $data['email'],

				'username' => $data['employee_name'], // or employee_code

				// 'password' => password_hash('123456', PASSWORD_DEFAULT),
				'password' => "123456",

				'role' => $data['role'],

				'department' => $data['department_id'],

				'contact_no' => $data['mobile'],

				'status' => 'Active'
			];

			$this->db->insert('users', $userData);
		}


		return $employee_id;
	}

	public function update_employee($employee_id, $data)
	{
		/* ===============================
     		 HANDLE PASSPORT FILE UPLOAD
    		=============================== */

		$passport_file = null;

		if (!empty($_FILES['passport_file']['name'])) {

			$config['upload_path']   = './uploads/passports/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['max_size']      = 2048;
			$config['file_name']     = 'passport_' . time();

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('passport_file')) {

				$uploadData = $this->upload->data();
				$passport_file = $uploadData['file_name'];

				// Delete old passport file
				$old = $this->db->where('employee_id', $employee_id)
					->get('employees')
					->row();

				if (
					!empty($old->passport_file) &&
					file_exists('./uploads/passports/' . $old->passport_file)
				) {

					unlink('./uploads/passports/' . $old->passport_file);
				}
			}
		}

		/* ===============================
       UPDATE EMPLOYEE TABLE
    =============================== */

		$employeeData = [

			'employee_name'   => $data['employee_name'],
			'mobile'          => $data['mobile'] ?? null,
			'email'           => $data['email'] ?? null,
			'address'         => $data['address'] ?? null,

			'department_id'   => $data['department_id'],
			'designation_id'  => $data['designation_id'],

			'role'            => $data['role'] ?? 'Technician',
			'joining_date'    => $data['joining_date'] ?? null,

			'software_access' => $data['software_access'] ?? 'No',

			'passport_number'           => $data['passport_number'] ?? null,
			'passport_issue_date'       => $data['passport_issue_date'] ?? null,
			'passport_expiry_date'      => $data['passport_expiry_date'] ?? null,
			'passport_location'         => $data['passport_location'] ?? null,
			'passport_expiry_reminder'  => $data['passport_expiry_reminder'] ?? null,
		];

		// Only update file if new uploaded
		if ($passport_file) {
			$employeeData['passport_file'] = $passport_file;
		}

		$this->db->where('employee_id', $employee_id);
		$this->db->update('employees', $employeeData);

		// Assume $employee_id already exists (from update, not insert)

		// 1️⃣ Delete existing ledger for this employee
		$this->db->where('employee_id', $employee_id);
		$this->db->delete('general_ledger');

		// 2️⃣ Insert new ledger
		$ledger_data = [
			'account_name'      => $data['employee_name'],
			'group_no'          => 67, // Employee Loan & Advances
			'employee_id'       => $employee_id,
			'opening_balance'   => 0,
			'opening_bal_type'  => 'Cr'
		];

		$this->db->insert('general_ledger', $ledger_data);


		/* ===============================
       HANDLE USER ACCOUNT
    =============================== */

		$existingUser = $this->db->where('employee_id', $employee_id)
			->get('users')
			->row();

		if ($data['software_access'] == 'Yes') {

			$nameParts = explode(' ', $data['employee_name'], 2);

			$userData = [

				'first_name' => $nameParts[0],
				'last_name'  => $nameParts[1] ?? '',
				'email'      => $data['email'],
				'username'   => $data['employee_name'],
				'role'       => $data['role'],
				'department' => $data['department_id'],
				'contact_no' => $data['mobile'],
				'status'     => 'Active'
			];

			if ($existingUser) {

				// Update existing user
				$this->db->where('employee_id', $employee_id);
				$this->db->update('users', $userData);
			} else {

				// Create new user
				$userData['employee_id'] = $employee_id;
				$userData['password'] = "123456";

				$this->db->insert('users', $userData);
			}
		} else {

			// If software access set to No → delete user account
			if ($existingUser) {
				$this->db->where('employee_id', $employee_id);
				$this->db->delete('users');
			}
		}

		return true;
	}

	// Get all employees (for listing)
	public function get_all_employees()
	{
		return $this->db
			->select('e.*, d.department_name, g.designation_name')
			->from('employees e')
			->join('departments d', 'd.department_id = e.department_id')
			->join('designations g', 'g.designation_id = e.designation_id')
			->order_by('e.employee_name', 'ASC')
			->get()
			->result();
	}

	// Get employee by ID (Edit page)
	public function get_employee_by_id($employee_id)
	{
		return $this->db
			->where('employee_id', $employee_id)
			->get('employees')
			->row();
	}

	// Update employee


	// Soft delete / deactivate employee
	public function deactivate_employee($employee_id)
	{
		return $this->db
			->where('employee_id', $employee_id)
			->update('employees', ['status' => 'Inactive']);
	}

	/* =====================================================
       TECHNICIANS (FOR GMS USE)
       ===================================================== */

	// Get only active technicians (Estimation / Job Card)
	public function get_active_technicians()
	{
		return $this->db
			->where('role', 'Technician')
			->where('status', 'Active')
			->order_by('employee_name', 'ASC')
			->get('employees')
			->result();
	}


	public function get_filtered_employees123($filters = [])
	{
		$this->db->select('u.*, d.designation_name, dept.dept_name, ss.basic_salary');
		$this->db->from('users u');
		$this->db->join('designations d', 'u.desig_id = d.did', 'left');
		$this->db->join('departments dept', 'u.dept_id = dept.dept_id', 'left');

		// Join salary_structure
		$this->db->join('salary_structure ss', 'ss.emp_id = u.user_id', 'left');

		// Apply filters
		if (!empty($filters['user_id'])) {
			$this->db->where('u.user_id', $filters['user_id']);
		}
		if (!empty($filters['department_id'])) {
			$this->db->where('u.dept_id', $filters['department_id']);
		}
		if (!empty($filters['designation_id'])) {
			$this->db->where('u.desig_id', $filters['designation_id']);
		}

		return $this->db->get()->result();
	}
	public function get_filtered_employees($filters = [])
	{
		$this->db->select('e.*, d.designation_name, dept.department_name, ss.basic_salary');
		$this->db->from('employees e');

		// Join designations
		$this->db->join('designations d', 'e.designation_id = d.designation_id', 'left');

		// Join departments
		$this->db->join('departments dept', 'e.department_id = dept.department_id', 'left');

		// Join salary_structure
		$this->db->join('salary_structure ss', 'ss.emp_id = e.employee_id', 'left');

		// Apply filters
		if (!empty($filters['user_id'])) {
			$this->db->where('e.employee_id', $filters['user_id']);
		}

		if (!empty($filters['department_id'])) {
			$this->db->where('e.department_id', $filters['department_id']);
		}

		if (!empty($filters['designation_id'])) {
			$this->db->where('e.designation_id', $filters['designation_id']);
		}

		return $this->db->get()->result();
	}

	public function get_user_list_filter($status)
	{
		$status = (int) $status;
		$query = $this->db->query("
        SELECT u.*, d.dept_name
        FROM users u
        JOIN department_master d ON u.dept_id = d.dept_id
        WHERE u.active = ?
        ORDER BY u.user_name", [$status]);
		return $query->result();
	}

	public function get_designations_with_department()
	{
		$this->db->select('
        designations.designation_id,
        designations.designation_name,
        designations.department_id,
        departments.department_name
    ');

		$this->db->from('designations');

		$this->db->join(
			'departments',
			'departments.department_id = designations.department_id',
			'left'
		);

		$this->db->where('designations.is_active', 1);
		$this->db->where('departments.is_active', 1);

		$this->db->order_by('departments.department_name', 'ASC');
		$this->db->order_by('designations.designation_name', 'ASC');

		return $this->db->get()->result();
	}

	public function get_all_employees123()
	{
		$this->db->select('e.*, d.department_name, ds.designation_name');
		$this->db->from('employees e');
		$this->db->join('departments d', 'd.department_id = e.department_id', 'left');
		$this->db->join('designations ds', 'ds.designation_id = e.designation_id', 'left');
		$this->db->order_by('e.employee_id', 'DESC');

		return $this->db->get()->result();
	}

	public function get_employee($id)
	{
		return $this->db->where('employee_id', $id)
			->get('employees')
			->row();
	}

	// public function get_departments()
	// {
	// 	return $this->db->get('departments')->result();
	// }
}
