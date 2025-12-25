<?php defined('BASEPATH') or exit('No direct script access allowed');

class Works_requested extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Works_requested_model');
	}

	public function index()
	{
		$data['works'] = $this->Works_requested_model->get_all();
		$data['title'] = "inspection_master List";
		$data['main_content'] = 'works_requested/list';
		$this->load->view('includes/template', $data);
	}

	public function add()
	{
		if ($this->input->post()) {

			$data = [
				'work_name'   => $this->input->post('work_name'),
				'description' => $this->input->post('description')
			];

			$this->Works_requested_model->insert($data);
			redirect('works_requested');
		}
		$data['title'] = "works_requested Add";
		$data['main_content'] = 'works_requested/add';
		$this->load->view('includes/template', $data);
	}

	public function edit($id)
	{
		if ($this->input->post()) {

			$data = [
				'work_name'   => $this->input->post('work_name'),
				'description' => $this->input->post('description')
			];

			$this->Works_requested_model->update($id, $data);
			redirect('works_requested');
		}

		$data['work'] = $this->Works_requested_model->get_by_id($id);

		$data['title'] = "works_requested Add";
		$data['main_content'] = 'works_requested/edit';
		$this->load->view('includes/template', $data);
	}

	public function delete($id)
	{
		$this->Works_requested_model->delete($id);
		redirect('works_requested');
	}
}
