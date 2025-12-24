<?php
require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Jobcard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Jobcard_model");
		$this->load->model("Appointment_model");
		$this->load->model("SpareParts_model");
$this->load->model("Service_model");
	}

	// Job Card Listing
	public function index()
	{
		$data['jobcards'] = $this->Jobcard_model->get_all_jobcards();
		
		$data['title'] = "Job Cards";

		$data['main_content'] = "jobcard/jobcard_list";
		$this->load->view("includes/template", $data);
	}

	public function add()
	{
		$data['appointments'] = $this->Appointment_model->get_upcoming();
		$data['parts'] = $this->SpareParts_model->get_all_parts();
		$data['services_master'] = $this->db->where('status', 'Active')
                                     ->get('services_master')
                                     ->result();
		$data['title'] = "Add Job Card";
		$data['main_content'] = "jobcard/jobcard_add";
		$this->load->view("includes/template", $data);
	}

	public function save()
	{

		// Insert job card
		$jobcard_id = $this->Jobcard_model->insert_jobcard([
			"appointment_id" => $this->input->post("appointment_id"),
			"customer_id"    => $this->input->post("customer_id"),
			"vehicle_id"     => $this->input->post("vehicle_id"),
			"jobcard_date"   => $this->input->post("jobcard_date"),
			"technician"     => $this->input->post("technician"),
			"remarks"        => $this->input->post("remarks")
		]);

		// Insert Services
		$services = $this->input->post("service_name");
		$costs = $this->input->post("service_cost");

		if ($services) {
			for ($i = 0; $i < count($services); $i++) {
				$this->Jobcard_model->insert_service([
					"jobcard_id" => $jobcard_id,
					"service_name" => $services[$i],
					"amount" => $costs[$i]
				]);
			}
		}

		// Insert Parts
		$part_ids = $this->input->post("part_id");
		$qtys = $this->input->post("part_qty");
		$prices = $this->input->post("part_price");

		if ($part_ids) {
			for ($i = 0; $i < count($part_ids); $i++) {
				$this->Jobcard_model->insert_part([
					"jobcard_id" => $jobcard_id,
					"part_id"    => $part_ids[$i],
					"qty"        => $qtys[$i],
					"rate" => $prices[$i],
					"amount" => $qtys[$i] * $prices[$i]
				]);
			}
		}

		$this->session->set_flashdata("success", "Job Card Created Successfully");
		redirect("jobcard");
	}


	public function view($jobcard_id)
	{
		$data['jobcard']  = $this->Jobcard_model->get_jobcard($jobcard_id);
		$data['services'] = $this->Jobcard_model->get_jobcard_services($jobcard_id);
		$data['parts']    = $this->Jobcard_model->get_jobcard_parts($jobcard_id);

		$data['title'] = "Job Card #" . $jobcard_id;
		$data['main_content'] = "jobcard/jobcard_view";
		$this->load->view("includes/template", $data);
	}

	public function edit($jobcard_id)
	{
	

		// Main job card data
		$data['jobcard'] = $this->Jobcard_model->get_jobcard($jobcard_id);

		// Services & Parts inside job card
		$data['services'] = $this->Jobcard_model->get_jobcard_services($jobcard_id);
		$data['parts_used'] = $this->Jobcard_model->get_jobcard_parts($jobcard_id);

		// Appointments list (for dropdown)
		$data['appointments'] = $this->Appointment_model->get_all();

		// Parts list for dropdown
		$data['parts'] = $this->SpareParts_model->get_all_parts();

		$data['title'] = "Edit Job Card";
		$data['main_content'] = "jobcard/jobcard_edit";

		$this->load->view("includes/template", $data);
	}
	public function update()
	{

				// $this->load->model("Jobcard_model");
		$jobcard_id = $this->input->post('jobcard_id');

		// ---------------------------
		// UPDATE MAIN JOB CARD
		// ---------------------------
		$jobcardData = [
			'appointment_id' => $this->input->post('appointment_id'),
			'customer_id'    => $this->input->post('customer_id'),
			'vehicle_id'     => $this->input->post('vehicle_id'),
			'jobcard_date'   => $this->input->post('jobcard_date'),
			'technician'     => $this->input->post('technician'),
			'remarks'        => $this->input->post('remarks'),
		];

		$this->Jobcard_model->update_jobcard($jobcard_id, $jobcardData);

		// ===============================
		// UPDATE SERVICES (Remove → Add)
		// ===============================
		$this->Jobcard_model->delete_services($jobcard_id);

		if (!empty($this->input->post('service_name'))) {

			$services = $this->input->post('service_name');
			$costs    = $this->input->post('service_cost');

			for ($i = 0; $i < count($services); $i++) {
				if (!empty(trim($services[$i]))) {
					$this->Jobcard_model->add_service([
						'jobcard_id'   => $jobcard_id,
						'service_name' => $services[$i],
						'amount' => $costs[$i]
					]);
				}
			}
		}

		// ===============================
		// UPDATE PARTS (Remove → Add)
		// ===============================
		$this->Jobcard_model->delete_parts($jobcard_id);

		if (!empty($this->input->post('part_id'))) {

			$part_ids  = $this->input->post('part_id');
			$qtys      = $this->input->post('part_qty');
			$prices    = $this->input->post('part_price');

			for ($i = 0; $i < count($part_ids); $i++) {

				$pid = $part_ids[$i];
				if (!$pid) continue;

				// Insert part usage
				$this->Jobcard_model->add_part([
					'jobcard_id' => $jobcard_id,
					'part_id'    => $pid,
					'qty'        => $qtys[$i],
					'rate' => $prices[$i],
					'amount'=>$qtys[$i] * $prices[$i]
				]);

				// OPTIONAL: AUTO DEDUCT STOCK
				$this->Jobcard_model->reduce_stock($pid, $qtys[$i]);
			}
		}

		// FINAL RESPONSE
		$this->session->set_flashdata('success', 'Job Card updated successfully!');
		redirect('jobcard');
	}

public function pdf($jobcard_id)
{
    // ✅ Load Model FIRST
    $this->load->model('Jobcard_model');

    // ✅ Get Job Card with Full Details
    $jobcard = $this->Jobcard_model->get_jobcard_with_details($jobcard_id);

    if (!$jobcard) {
        show_404();
    }

    // ✅ Load HTML from View
    $data['jobcard'] = $jobcard;
    $html = $this->load->view('jobcard/jobcard_pdf', $data, TRUE);

    // ✅ Dompdf Configuration
    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // ✅ Force Download
    $dompdf->stream("jobcard_{$jobcard_id}.pdf", [
        "Attachment" => true
    ]);
}
public function update_status($jobcard_id, $status)
{
    $allowed = ['Pending', 'In-Progress', 'Completed'];

    if (!in_array($status, $allowed)) {
        show_error("Invalid Status");
    }

    $this->Jobcard_model->update_status($jobcard_id, $status);

    $this->session->set_flashdata('success', 'Job Card status updated!');
    redirect('jobcard');
}



}
