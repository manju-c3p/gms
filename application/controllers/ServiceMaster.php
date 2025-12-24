<?php

class ServiceMaster extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Service_model');
    }

    // ✅ List Page
    public function index()
    {
        $data['services'] = $this->Service_model->get_all_services();

				$data['title'] = "services";

		$data['main_content'] = "service_master/index";
		$this->load->view("includes/template", $data);
       
    }

    // ✅ Add Service
    public function store()
    {
        $data = [
            'service_name'   => $this->input->post('service_name'),
            'estimated_cost'=> $this->input->post('estimated_cost'),
            'estimated_time'=> $this->input->post('estimated_time'),
            'status'         => $this->input->post('status')
        ];

        $this->Service_model->insert_service($data);
        redirect('servicemaster');
    }

    // ✅ Edit Page
    public function edit($id)
    {
        $data['service'] = $this->Service_model->get_service($id);

				$data['title'] = "services";

		$data['main_content'] = "service_master/edit";
		$this->load->view("includes/template", $data);
        
    }

    // ✅ Update Service
    public function update($id)
    {
        $data = [
            'service_name'   => $this->input->post('service_name'),
            'estimated_cost'=> $this->input->post('estimated_cost'),
            'estimated_time'=> $this->input->post('estimated_time'),
            'status'         => $this->input->post('status')
        ];

        $this->Service_model->update_service($id, $data);
        redirect('servicemaster');
    }

    // ✅ Enable / Disable
    public function toggle_status($id)
    {
        $current = $this->Service_model->get_service($id);
        $new_status = ($current->status == 'Active') ? 'Inactive' : 'Active';

        $this->Service_model->change_status($id, $new_status);
        redirect('servicemaster');
    }
}
