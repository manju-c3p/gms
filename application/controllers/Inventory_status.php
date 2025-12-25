<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inventory_status_model');
    }

    public function index()
    {
        $data['statuses'] = $this->Inventory_status_model->get_all();
		$data['title'] = "Inventory_status List";
		$data['main_content'] = 'inventory_status/list';
		$this->load->view('includes/template', $data);
       
    }

    public function add()
    {
        if ($this->input->post()) {

            $data = [
                'status_name' => $this->input->post('status_name'),
                'description' => $this->input->post('description')
            ];

            $this->Inventory_status_model->insert($data);
            redirect('inventory_status');
        }
	$data['title'] = "Inventory_status List";
		$data['main_content'] = 'inventory_status/add';
		$this->load->view('includes/template', $data);
      
    }

    public function edit($id)
    {
        if ($this->input->post()) {

            $data = [
                'status_name' => $this->input->post('status_name'),
                'description' => $this->input->post('description')
            ];

            $this->Inventory_status_model->update($id, $data);
            redirect('inventory_status');
        }

        $data['status'] = $this->Inventory_status_model->get_by_id($id);
		$data['title'] = "Inventory_status List";
		$data['main_content'] = 'inventory_status/edit';
		$this->load->view('includes/template', $data);
       
    }

    public function delete($id)
    {
        $this->Inventory_status_model->delete($id);
        redirect('inventory_status');
    }
}
