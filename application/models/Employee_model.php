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
            'designation_name'=> $designation_name
        ]);
    }

    /* =====================================================
       EMPLOYEES
       ===================================================== */

    // Insert employee (Technician / Advisor / Admin)
    public function save_employee($data)
    {
        return $this->db->insert('employees', [
            'employee_code'   => $data['employee_code'] ?? null,
            'employee_name'   => $data['employee_name'],
            'mobile'          => $data['mobile'] ?? null,
            'email'           => $data['email'] ?? null,
            'department_id'   => $data['department_id'],
            'designation_id'  => $data['designation_id'],
            'role'            => $data['role'] ?? 'Technician',
            'joining_date'    => $data['joining_date'] ?? null,
            'status'          => 'Active'
        ]);
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
    public function update_employee($employee_id, $data)
    {
        return $this->db
            ->where('employee_id', $employee_id)
            ->update('employees', [
                'employee_name'  => $data['employee_name'],
                'mobile'         => $data['mobile'],
                'email'          => $data['email'],
                'department_id'  => $data['department_id'],
                'designation_id' => $data['designation_id'],
                'role'           => $data['role'],
                'joining_date'   => $data['joining_date'],
                'status'         => $data['status']
            ]);
    }

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
}
