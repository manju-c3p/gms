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
		redirect('employee/add');
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
