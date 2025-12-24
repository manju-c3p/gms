<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection_master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inspection_model');
    }

    // List page
    public function index()
    {
        $data['items'] = $this->Inspection_model->get_all_items();

		$data['title'] = "inspection_master List";
		$data['main_content'] = 'inspection_master/list';
		$this->load->view('includes/template', $data);
        
    }

    // Add item
    public function add()
    {
        if ($this->input->post()) {

            $data = [
                'item_name' => $this->input->post('item_name'),
                'category'  => $this->input->post('category')
            ];

            $this->Inspection_model->insert_item($data);
            redirect('inspection_master');
        }
$data['title'] = "inspection_master Add";
		$data['main_content'] = 'inspection_master/add';
		$this->load->view('includes/template', $data);
        
    }

    // Edit item
    public function edit($id)
    {
        if ($this->input->post()) {

            $data = [
                'item_name' => $this->input->post('item_name'),
                'category'  => $this->input->post('category')
            ];

            $this->Inspection_model->update_item($id, $data);

            redirect('inspection_master');
        }

        $data['item'] = $this->Inspection_model->get_item($id);

		$data['title'] = "inspection_master Edit";
		$data['main_content'] = 'inspection_master/edit';
		$this->load->view('includes/template', $data);
        
    }

    // Delete item
    public function delete($id)
    {
        $this->Inspection_model->delete_item($id);
        redirect('inspection_master');
    }
}
