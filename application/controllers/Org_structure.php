<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Org_structure extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Org_structure_model');
    }

    /* ================= DEPARTMENT ================= */

    public function departments()
    {
        $data['departments'] = $this->Org_structure_model->get_departments();
		$data['title'] = "Employee List";
			$data['main_content'] = 'hr/department_list';
		$this->load->view('includes/template', $data);
       
    }

    public function add_department()
    {
        if($_POST)
        {
            $data = [
                'department_name'=>$this->input->post('department_name'),
                'is_active'=>1
            ];

            $this->Org_structure_model->insert_department($data);

            redirect('org_structure/departments');
        }

        $this->load->view('org_structure/department_form');
    }

    public function edit_department($id)
    {
        if($_POST)
        {
            $data=[
                'department_name'=>$this->input->post('department_name')
            ];

            $this->Org_structure_model->update_department($id,$data);

            redirect('org_structure/departments');
        }

        $data['department']=$this->Org_structure_model->get_department($id);

        $this->load->view('org_structure/department_form',$data);
    }


    /* ================= DESIGNATION ================= */

    public function designations()
    {
        $data['designations']=$this->Org_structure_model->get_designations();

        $this->load->view('org_structure/designation_list',$data);
    }

    public function add_designation()
    {
        if($_POST)
        {
            $data=[
                'department_id'=>$this->input->post('department_id'),
                'designation_name'=>$this->input->post('designation_name'),
                'is_active'=>1
            ];

            $this->Org_structure_model->insert_designation($data);

            redirect('org_structure/designations');
        }

        $data['departments']=$this->Org_structure_model->get_departments();

        $this->load->view('org_structure/designation_form',$data);
    }

    public function edit_designation($id)
    {
        if($_POST)
        {
            $data=[
                'department_id'=>$this->input->post('department_id'),
                'designation_name'=>$this->input->post('designation_name')
            ];

            $this->Org_structure_model->update_designation($id,$data);

            redirect('org_structure/designations');
        }

        $data['designation']=$this->Org_structure_model->get_designation($id);
        $data['departments']=$this->Org_structure_model->get_departments();

        $this->load->view('org_structure/designation_form',$data);
    }

}
