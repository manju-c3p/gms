<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MaterialIssue extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MaterialIssue_model');
        $this->load->model('Jobcard_model');

        // Optional: auth check
        // if (!$this->session->userdata('user_id')) {
        //     redirect('login');
        // }
    }

    /**
     * Show Material Issue form for a Job Card
     * URL: materialissue/create/{jobcard_id}
     */
    public function create($jobcard_id)
    {
        if (empty($jobcard_id)) {
            show_error('Job Card ID is required');
        }

        /* ===============================
           1️⃣ Get Job Card Details
        ================================ */
        $jobcard = $this->Jobcard_model->get_jobcard_with_basic_details($jobcard_id);

        if (!$jobcard) {
            show_error('Job Card not found');
        }

        /* ===============================
           2️⃣ Status validation
        ================================ */
        if ($jobcard->status === 'Completed') {
            $this->session->set_flashdata(
                'error',
                'Material issue is not allowed for completed job cards'
            );
            redirect('jobcard/view/' . $jobcard_id);
        }

        /* ===============================
           3️⃣ Get Job Card Parts
        ================================ */
        $jobcard_parts = $this->MaterialIssue_model
            ->get_jobcard_parts_with_issued_qty($jobcard_id);

        /* ===============================
           4️⃣ Prepare data for view
        ================================ */
        $data = [
            'jobcard'        => $jobcard,
            'jobcard_parts'  => $jobcard_parts
        ];

        /* ===============================
           5️⃣ Load view
        ================================ */

		$data['title'] = 'jaterial_issue';
		$data['main_content'] = 'material_issue/create'; // SAME PAGE

		$this->load->view('includes/template', $data);
       
    }
}
