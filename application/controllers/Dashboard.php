<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		// $this->load->model('Notification_model');
		$this->load->model('Dashboard_model');
	}


	public function index()
	{
		$data['title'] 	 = "Dashboard";
		// Get session data
		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');

		   // Active Job Cards
        $data['active_job_cards'] = $this->Dashboard_model->get_active_job_cards();
		$data['recent_estimations'] = $this->Dashboard_model->get_recent_estimations();
		$data['low_stock_items'] =  $this->Dashboard_model->get_low_stock_items();
		$data['recent_inspections'] =  $this->Dashboard_model->get_recent_inspections();



		$data['main_content'] = 'dashboard.php';
		$this->load->view('includes/template', $data);
	}

	
    // ==============================================
    // 🔸 Function: Get latest notifications
    // ==============================================
    // public function get_notifications()
    // {
    //     $user_id = $this->session->userdata('user_id');
    //     if (!$user_id) {
    //         echo json_encode([]);
    //         return;
    //     }

    //     $notifications = $this->Notification_model->get_user_notifications($user_id);
    //     echo json_encode($notifications);
    // }

    // ==============================================
    // 🔸 Function: Get unread notification count
    // ==============================================
    // public function unread_count()
    // {
    //     $user_id = $this->session->userdata('user_id');
    //     if (!$user_id) {
    //         echo json_encode(['count' => 0]);
    //         return;
    //     }

    //     $count = $this->Notification_model->count_unread($user_id);
    //     echo json_encode(['count' => $count]);
    // }

    // ==============================================
    // 🔸 Function: Mark a notification as read
    // ==============================================
    // public function mark_as_read($msg_id)
    // {
    //     $this->Notification_model->mark_as_read($msg_id);
    // }
}
