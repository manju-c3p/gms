<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Inspection_model',
			'Inspection_view_model',
                     'Works_requested_model',
            'Inventory_status_model','Service_model'
        ]);
    }

    // Create inspection from appointment
    public function create($appointment_id)
    {
        // Prevent duplicate inspection
        $existing = $this->Inspection_view_model->get_by_appointment($appointment_id);
        if ($existing) {
            redirect('inspection/view/' . $existing->inspection_id);
        }

        // Get appointment + customer + vehicle
        $appointment = $this->Inspection_view_model->get_appointment_details($appointment_id);
        if (!$appointment) show_404();

        // Create inspection record (DRAFT)
        $inspection_id = $this->Inspection_view_model->create_inspection([
            'appointment_id'  => $appointment_id,
            'customer_id'     => $appointment->customer_id,
            'vehicle_id'      => $appointment->vehicle_id,
            'inspection_date' => date('Y-m-d'),
            'inspection_time' => date('H:i:s'),
            // 'km_reading'      => $appointment->km ?? 0,
            'status'          => 'Draft'
        ]);
$data['services'] = $this->Service_model->get_active_services();
        // Load masters
        $data['inspection_id'] = $inspection_id;
        $data['appointment']   = $appointment;
        $data['items']         = $this->Inspection_model->get_all_items();
        $data['works']         = $this->Works_requested_model->get_all();
        $data['inventory']     = $this->Inventory_status_model->get_all();

		$data['title'] = "Inspection Report";
		$data['main_content'] = 'inspection/create';
		$this->load->view('includes/template', $data);

        
    }

    // Save inspection
    public function save()
    {
        $inspection_id = $this->input->post('inspection_id');

        // Save A/C/S items
        foreach ($this->input->post('item_status') as $item_id => $status) {
            $this->Inspection_view_model->save_item_result($inspection_id, $item_id, $status);
        }

        // Save works requested
        $this->Inspection_view_model->save_works_requested(
            $inspection_id,
            $this->input->post('works_requested') ?? []
        );

        // Save inventory status
        $this->Inspection_view_model->save_inventory_status(
            $inspection_id,
            $this->input->post('inventory_status') ?? []
        );

        // Update inspection main
        $this->Inspection_view_model->update_inspection($inspection_id, [
            'fuel_level' => $this->input->post('fuel_level'),
            'remarks'    => $this->input->post('remarks'),
            'status'     => 'Completed'
        ]);

        redirect('inspection/view/' . $inspection_id);
    }
}
