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
		$data['Scheduled_job_cards_count'] = $this->Dashboard_model->get_Scheduled_job_cards_count();
		$data['active_job_cards_count'] = $this->Dashboard_model->get_active_job_cards_count();
		$data['InProgress_job_cards_count'] = $this->Dashboard_model->get_inprogress_job_cards_count();
		$data['finished_job_cards_count'] = $this->Dashboard_model->get_finished_job_cards_count();

		// $data['purchase_order_count'] = $this->Dashboard_model->get_purchase_order_count();
		$data['total_purchase_amount'] = $this->Dashboard_model->get_total_purchase_amount();
		$data['parts_po']   = $this->Dashboard_model->get_parts_po_summary();
		$data['service_po'] = $this->Dashboard_model->get_service_po_summary();
		// $data['grn_count'] = $this->Dashboard_model->get_grn_count();
		// $data['purchase_return_count'] = $this->Dashboard_model->get_purchase_return_count();

		$data['customer_count'] = $this->Dashboard_model->get_customers_count();
		$data['vehicles_count'] = $this->Dashboard_model->get_vehicles_count();

		$data['recent_estimations'] = $this->Dashboard_model->get_recent_estimations();
		$data['low_stock_items'] =  $this->Dashboard_model->get_low_stock_items();
		$data['recent_inspections'] =  $this->Dashboard_model->get_recent_inspections();
		$data['jobcardProgress'] = $this->Dashboard_model->get_jobcard_job_completion();
		$data['revenueSummary'] = $this->Dashboard_model->get_revenue_summary();
		$data['total_revenue'] = $this->Dashboard_model->get_total_revenue();
		$data['balances'] = $this->Dashboard_model->get_cash_bank_balances();
		log_message('error', print_r($data['balances'], true));

		// $data['jobcardProgress1'] = $this->Dashboard_model->get_jobcard_job_progress();
		// $data['jobcardReport'] =  $this->Dashboard_model->get_jobcard_time_report();
		// log_message(
		// 	'error',
		// 	'Jobcard Report: ' . print_r($data['jobcardReport'], true)
		// );

		// $data['jobcardReport'] = [
		// 	(object)[
		// 		'jobcard_no'     => 'JC-1001',
		// 		'employee_name'  => 'Ramesh Kumar',
		// 		'worked_hours'   => 4.5,
		// 		'total_jobs'     => 4,
		// 		'completed_jobs' => 1,
		// 		'progress'       => 25
		// 	],
		// 	(object)[
		// 		'jobcard_no'     => 'JC-1002',
		// 		'employee_name'  => 'Suresh Das',
		// 		'worked_hours'   => 7.25,
		// 		'total_jobs'     => 5,
		// 		'completed_jobs' => 3,
		// 		'progress'       => 60
		// 	],
		// 	(object)[
		// 		'jobcard_no'     => 'JC-1003',
		// 		'employee_name'  => 'Arun Singh',
		// 		'worked_hours'   => 10.0,
		// 		'total_jobs'     => 6,
		// 		'completed_jobs' => 6,
		// 		'progress'       => 100
		// 	],
		// ];


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
