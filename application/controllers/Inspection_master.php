<?php defined('BASEPATH') or exit('No direct script access allowed');

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

	// =============================================


	// List page
	public function listpackage()
	{
		$data['items'] = $this->Inspection_model->get_all_packageitems();

		$data['title'] = "inspection_Package List";
		$data['main_content'] = 'Inspection_master/list-package';
		$this->load->view('includes/template', $data);
	}

	// Add item
	public function addpackage()
	{
		if ($this->input->post()) {

			$data = [
				'package_name' => $this->input->post('item_name'),
				'created_at' => date('Y-m-d H:i:s')
			];

			$this->Inspection_model->insert_packageitem($data);
			redirect('Inspection_master/listpackage');
		}
		$data['title'] = "inspection_master Add";
		$data['main_content'] = 'Inspection_master/add-package';
		$this->load->view('includes/template', $data);
	}

	// Edit item
	public function editpackage($id)
	{
		if ($this->input->post()) {

			$data = [
				'package_name' => $this->input->post('item_name'),
				'created_at' => date('Y-m-d H:i:s')
			];

			$this->Inspection_model->update_packageitem($id, $data);

			redirect('Inspection_master/listpackage');
		}

		$data['item'] = $this->Inspection_model->get_packageitem($id);

		$data['title'] = "inspection_master Edit";
		$data['main_content'] = 'inspection_master/edit-package';
		$this->load->view('includes/template', $data);
	}

	// Delete item
	public function deletepackage($id)
	{
		$this->Inspection_model->delete_packageitem($id);
		redirect('Inspection_master/listpackage');
	}
}
