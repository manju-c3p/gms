<?php


class Supplier extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//  $this->is_logged_in();
		$this->load->model('Supplier_model');
	}

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if (!isset($is_logged_in) || $is_logged_in != true) {
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';

			die();
			//$this->load->view('login/login_form');
		}
	}

	///////////////////////////////////////supplier Details Start////////////////////////////////////////////// 

	public function list_suppliers()
	{
		$user = $this->session->userdata('user_id');
		// if (!has_view_access($user, 'Setup/list_suppliers')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// } else {
		$data['title'] = 'Suppliers List';

		$data['all_suppliers'] = $this->Supplier_model->get_all_supplier_list();

		$data['main_content'] = 'suppliers/list_supplier.php';
		// }

		$this->load->view('includes/template', $data);
	}

	public function add_supplier()
	{
		$user = $this->session->userdata('user_id');
		// if (!has_access($user, 'Setup/list_suppliers', 'A')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// } else {
		$data['title'] = 'Add Supplier';
		$data['supplier_code'] = $this->Supplier_model->generate_supplier_code();

		$data['main_content'] = 'suppliers/add_supplier.php';
		// }

		$this->load->view('includes/template', $data);
	}

	public function add_supplier_data()
	{
		$result = $this->Supplier_model->add_supplier_data();

		if ($result) {
			echo 'Added';
		} else {
			echo 'Not Added';
		}
		redirect('Supplier/list_suppliers');
	}
	public function delete_supplier()
	{
		$sup_id = $this->uri->segment('3');
		$this->Supplier_model->delete_supplier($sup_id);
		redirect('Supplier/list_suppliers');
	}

	public function edit_supplier($supplier_id)
	{
		$data['supplier'] = $this->Supplier_model->get_supplier($supplier_id);
		$data['contacts'] = $this->Supplier_model->get_supplier_contacts($supplier_id);

		$data['title'] = 'Edit Supplier';

		$data['main_content'] = 'suppliers/edit_supplier.php';


		$this->load->view('includes/template', $data);
	}
	public function update_supplier()
	{
		$supplier_id = $this->input->post('supplier_id');

		$email = $this->input->post('supplier_email');
		$email = !empty($email) ? $email : NULL;

		$supplier_data = [
			'supplier_name'   => $this->input->post('supplier_name'),
			'supplier_code' => $this->input->post('supplier_code'),
			'email_id'  => $email,
			'contact_no'  => $this->input->post('contact_number'),
			'billing_address' => $this->input->post('supplier_address'),
			'trn_no'          => $this->input->post('trn_no')
		];

		$this->Supplier_model->update_supplier($supplier_id, $supplier_data);

		// 🔥 Delete old contacts and reinsert (simplest + safest)
		$this->Supplier_model->delete_contacts($supplier_id);

		$names  = $this->input->post('contact_name');
		$phones = $this->input->post('contact_phone');
		$emails = $this->input->post('contact_email');

		if (!empty($names)) {
			$contacts = [];

			for ($i = 0; $i < count($names); $i++) {
				$contacts[] = [
					'supplier_id' => $supplier_id,
					'contact_name' => $names[$i],
					'contact_phone' => $phones[$i],
					'contact_email' => $emails[$i],
				];
			}

			$this->Supplier_model->insert_contacts($contacts);
		}

		redirect('Supplier/list_suppliers');
	}


	//////////////////////////////////////Supplier Details End/////////////////////////////////////////////

	//place in unit Supplier controller

	function add_unit()
	{

		$data['title'] = 'unit Master';

		$data['main_content'] = 'unit_master/add_unit';
		$this->load->view('includes/template.php', $data);
	}

	function add_unit_records()
	{
		$data['title'] = 'Unit Master';
		$insert_id = $this->Supplier_model->add_units();
		if ($insert_id != '') {
			$this->session->set_flashdata('success', 'Data Saved Successfully..');
			redirect('Supplier/view_unit_list');
		}
	}

	function view_unit_list()
	{
		$data['title'] = 'Supplier List';
		$data['units'] = $this->Supplier_model->get_units();
		$data['main_content'] = 'unit_master/unit_list';
		$this->load->view('includes/template', $data);
	}

	function edit_unit()
	{
		$data['title'] = 'Edit Supplier';
		$id = $this->uri->segment('3');

		$data['records'] = $this->Supplier_model->get_units_by_id($id);

		$data['main_content'] = 'unit_master/edit_unit.php';
		$this->load->view('includes/template.php', $data);
	}


	function update_unit_data()
	{
		$data['title'] = 'New Unit';
		$gid = $this->input->post('id');

		$this->Supplier_model->update_unit_data($gid);

		$this->session->set_flashdata('success', 'Data Updated Successfully..');
		redirect('Supplier/view_unit_list');
	}
	// ======================================================================================
	public function repair_supplier_ledgers()
	{
		$suppliers = $this->db->get('supplier_master')->result();

		foreach ($suppliers as $sup) {

			// Expected correct account name
			$correct_name = $sup->supplier_name . ' SUP' . str_pad($sup->supplier_id, 4, '0', STR_PAD_LEFT);

			// Check if ledger exists
			$ledger = $this->db->where('supplier_id', $sup->supplier_id)
				->get('general_ledger')
				->row();

			if (!$ledger) {
				// ❌ Missing → CREATE
				$data = [
					'account_name'     => $correct_name,
					'group_no'         => 29, // Sundry Creditors
					'supplier_id'      => $sup->supplier_id,
					'opening_balance'  => 0.00,
					'opening_bal_type' => 'Cr', // Suppliers usually Credit
					'isdeleteable'     => 'N',
					'date'             => date('Y-m-d H:i:s')
				];

				$this->db->insert('general_ledger', $data);

				log_message('error', 'Ledger CREATED for supplier: ' . $sup->supplier_id);
			} else {
				// ⚠️ Exists → CHECK NAME
				if (trim($ledger->account_name) !== trim($correct_name)) {

					$this->db->where('account_id', $ledger->account_id)
						->update('general_ledger', [
							'account_name' => $correct_name
						]);

					log_message('error', 'Ledger UPDATED for supplier: ' . $sup->supplier_id);
				}
			}
		}

		return true;
	}
}
