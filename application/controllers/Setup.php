<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setup extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//  $this->is_logged_in();
		$this->load->model('Setup_model');
	}
	// ================================users =============================
	public function list_users()
	{
		// $user = $this->session->userdata('user_id');
		// if (!has_view_access($user, 'Setup/list_users')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// } else {
		$data['title'] = 'Users List';
		$data['users'] = $this->Setup_model->get_all_users();
		$data['main_content'] = 'users/list_users.php';
		// }

		$this->load->view('includes/template', $data);
	}
	public function add_user()
	{
		// $user = $this->session->userdata('user_id');
		// if (!has_view_access($user, 'Setup/list_users')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// } else {
		$data['title'] = 'Add Users List';
		$data['main_content'] = 'users/add_user.php';
		// }

		$this->load->view('includes/template', $data);
	}


	public function add_user_data()
	{

		$result = $this->Setup_model->add_user_data();

		if ($result) {
			echo 'Added';
		} else {
			echo 'Not Added';
		}
		redirect('Setup/list_users');
	}

	public function edit_user()
	{
		// $user = $this->session->userdata('user_id');
		// if (!has_access($user, 'Setup/list_users', 'E')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// } else {
		$data['title'] = 'Edit User';
		$user_id = $this->uri->segment('3');
		$data['user'] = $this->Setup_model->get_user_by_id($user_id);

		$data['main_content'] = 'users/edit_user.php';
		// }
		$this->load->view('includes/template', $data);
	}

	public function edit_user_data()
	{
		$result = $this->Setup_model->edit_user_data();

		if ($result) {
			echo 'Updated';
		} else {
			echo 'Not Updated';
		}
		redirect('Setup/list_users');
	}

	public function delete_user($id)
	{
		// Safety: if id is missing or invalid
		if (empty($id) || !is_numeric($id)) {
			$this->session->set_flashdata('error', 'Invalid user ID.');
			return redirect('Setup/list_users');
		}

		// Load model
		$this->load->model('Setup_model');

		// Delete action
		$deleted = $this->Setup_model->delete_user($id);

		if ($deleted) {
			$this->session->set_flashdata('success', 'User deleted successfully.');
		} else {
			$this->session->set_flashdata('error', 'Failed to delete user.');
		}

		return redirect('Setup/list_users');
	}
	// ================================ users =============================


}
