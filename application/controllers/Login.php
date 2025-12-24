<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
	}

	public function index()
	{
		$this->load->view('login/login');
	}


	// public function verify_login()
	// {

	// 	$username = $this->input->post('username');
	// 	$password = $this->input->post('password');

	// 	log_message('error', 'Login attempt: Username = ' . $username . ', Password = ' . $password);
	// 	$user = $this->db->get_where('users', ['username' => $username])->row();

	// 	if ($user && $password == $user->password) {
	// 		$this->session->set_userdata([
	// 			'user_id' => $user->id,
	// 			'username' => $user->username,
	// 			'role' => $user->role,
	// 			'logged_in' => true
	// 		]);

	// 		// $data['title'] 	 = "Dashboard";
	// 		// // Get session data
	// 		$data['username'] = $this->session->userdata('username');
	// 		$data['userid'] = $this->session->userdata('user_id');
	// 		// $data['main_content'] = 'dashboard.php';
	// 		// $this->load->view('includes/template', $data);
	// 		redirect('dashboard');   // <-- THIS FIXES YOUR ISSUE
    //     return;
	// 	} else {
	// 		$this->session->set_flashdata('error', 'Invalid username or password');
	// 		redirect('Login');
	// 	}
	// }

	public function verify_login()
{
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->db->get_where('users', ['username' => $username])->row();

    if ($user && $password == $user->password) {

        $this->session->set_userdata([
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'logged_in' => true
        ]);

        redirect('dashboard');   // <-- THIS FIXES YOUR ISSUE
        return;
    }

    $this->session->set_flashdata('error', 'Invalid username or password');
    redirect('login');
}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect('Login');
	}
}
