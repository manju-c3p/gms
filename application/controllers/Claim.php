<?php
class Claim extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Claim_model');
		$this->load->model('Policy_model');
	}

	// LIST ALL CLAIMS FOR A POLICY
	public function list123($policy_id)
	{
		$data['policy']  = $this->Policy_model->get_policy($policy_id);
		$data['claims']  = $this->Claim_model->get_claims_by_policy($policy_id);
		$data['title'] = "Edit Insurance Policy";
		$data['main_content'] = 'insurance/claim_list';
		$this->load->view('includes/template', $data);
		// $this->load->view('insurance/claim_list', $data);
	}
	public function list()
	{
		// Load all policies
		$policies = $this->Policy_model->get_all_policies_with_vehicle();

		// For each policy, load claims
		foreach ($policies as $p) {
			$p->claims = $this->Claim_model->get_claims_by_policy($p->policy_id);
		}

		$data['policies'] = $policies;

		$data['title'] = "Insurance Claims";
		$data['main_content'] = 'insurance/claim_list';
		$this->load->view('includes/template', $data);
	}


	// ADD FORM
	public function add($policy_id)
	{
		$data['policy'] = $this->Policy_model->get_policy($policy_id);

		$data['title'] = "Insurance Claims";
		$data['main_content'] = 'insurance/claim_add_form';
		$this->load->view('includes/template', $data);
	}

	// SAVE CLAIM
	public function save()
	{
		$policy_id = $this->input->post('policy_id');

		$data = [
			'policy_id'   => $policy_id,
			'claim_date'  => $this->input->post('claim_date'),
			'claim_number' => $this->input->post('claim_number'),
			'description' => $this->input->post('description'),
			'claim_amount' => $this->input->post('claim_amount'),
			'status'      => $this->input->post('status'),
			'notes'       => $this->input->post('notes'),
		];

		// Insert claim
		$claim_id = $this->Claim_model->add_claim($data);

		// 🔹 Load upload library ONCE
		$this->load->library('upload');

		// Handle multiple documents
		if (!empty(array_filter($_FILES['documents']['name']))) {

			$files = $_FILES['documents'];

			for ($i = 0; $i < count($files['name']); $i++) {

				$_FILES['file']['name']     = $files['name'][$i];
				$_FILES['file']['type']     = $files['type'][$i];
				$_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['file']['error']    = $files['error'][$i];
				$_FILES['file']['size']     = $files['size'][$i];

				$config = [
					'upload_path'   => './uploads/claims/',
					'allowed_types' => 'jpg|jpeg|png|pdf',
					'file_name'     => time() . '_' . $files['name'][$i],
				];

				// 🔹 IMPORTANT: initialize config inside loop
				$this->upload->initialize($config);

				if ($this->upload->do_upload('file')) {

					$uploadData = $this->upload->data();

					$this->Claim_model->add_claim_document([
						'claim_id' => $claim_id,
						'document_path' => $uploadData['file_name']
					]);
				}
			}
		}

		$this->session->set_flashdata('success', 'Claim Added Successfully!');
		redirect('claim/list/' . $policy_id);
	}



	// EDIT CLAIM FORM
	public function edit($claim_id)
	{
		$data['claim']     = $this->Claim_model->get_claim($claim_id);
		$data['documents'] = $this->Claim_model->get_claim_documents($claim_id);


		$data['title'] = "Insurance Claims";
		$data['main_content'] = 'insurance/claim_edit_form';
		$this->load->view('includes/template', $data);
	}

	// UPDATE CLAIM
	public function update()
	{
		$claim_id  = $this->input->post('claim_id');
		$policy_id = $this->input->post('policy_id');

		$data = [
			'claim_date'  => $this->input->post('claim_date'),
			'claim_number' => $this->input->post('claim_number'),
			'description' => $this->input->post('description'),
			'claim_amount' => $this->input->post('claim_amount'),
			'status'      => $this->input->post('status'),
			'notes'       => $this->input->post('notes'),
		];

		$this->Claim_model->update_claim($claim_id, $data);

		$this->session->set_flashdata('success', 'Claim Updated Successfully!');
		redirect('claim/edit/' . $claim_id);
	}

	// DELETE CLAIM
	public function delete($claim_id, $policy_id)
	{
		$this->Claim_model->delete_claim($claim_id);

		$this->session->set_flashdata('success', 'Claim Deleted!');
		redirect('claim/list/' . $policy_id);
	}

	public function view($claim_id)
	{
		$data['claim']     = $this->Claim_model->get_claim($claim_id);
		$data['documents'] = $this->Claim_model->get_claim_documents($claim_id);
		$data['title'] = "Insurance Claims";
		$data['main_content'] = 'insurance/claim_view';
		$this->load->view('includes/template', $data);
		
	}
}
