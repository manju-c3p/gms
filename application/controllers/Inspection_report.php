<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Inspection_report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inspection_report_model');
    }

    public function view($inspection_id)
    {
        $data['header']    = $this->Inspection_report_model->get_inspection_header($inspection_id);
        $data['items']     = $this->Inspection_report_model->get_inspection_items($inspection_id);
        $data['works']     = $this->Inspection_report_model->get_works_requested($inspection_id);
        $data['inventory'] = $this->Inspection_report_model->get_inventory_status($inspection_id);
        $data['marks']     = $this->Inspection_report_model->get_damage_marks($inspection_id);

        $this->load->view('inspection/report', $data);
    }
}
