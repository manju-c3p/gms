<?php
class Admin_model extends CI_Model
{
	function get_company_master_list()
	{
		$query = $this->db->query("select * from company_master ");
		return $query->result();
	}

		function get_company_bank_list()
	{
		$query = $this->db->query("select * from company_bank_details ");
		return $query->result();
	}
	function get_company_stamp_list()
	{
		$query = $this->db->query("select * from company_stamp_image ");
		return $query->result();
	}

	function update_company_record_by_id()
	{
		$id = 1;
		$data = array(
			'company_name' => $this->input->post('company_name'),
			'company_address' => $this->input->post('company_address'),
			'company_city' => $this->input->post('company_city'),
			'company_state' => 'Maharashtra',
			'company_pincode' => $this->input->post('company_pincode'),
			'company_country' => $this->input->post('company_country'),
			'company_email_id' => $this->input->post('company_email_id'),
			'company_telephone' => $this->input->post('company_telephone'),
			'company_TRN' => $this->input->post('company_trn'),
			'company_website' => $this->input->post('website'),
			'corporate_tax_per' => $this->input->post('corporate_tax'),
			'threshold_value' => $this->input->post('threshold'),
			'excemptions' => $this->input->post('excemption'),


		);
		$this->db->where('company_id', $id);
		$this->db->update('company_master', $data);

		if (isset($_POST['bname'])) {
			for ($i = 0; $i < count($_POST['bname']); $i++) {
				if ($_POST['bname'][$i] != '') {
					$data = array(
						'company_id' => 1,
						'bank_name' => $_POST['bname'][$i],
						'bank_account' => $_POST['bacc'][$i],
						'bank_branch' => $_POST['bbranch'][$i],
						'bank_iban' => $_POST['biban'][$i],
						'bank_swift' => $_POST['bswift'][$i],
					);
					$this->db->insert('company_bank_details', $data);
				}
			}
		}

		if (isset($_POST['bname_old'])) {
			for ($i = 0; $i < count($_POST['bname_old']); $i++) {
				$trans_id = $_POST['trans_id'][$i];
				$data = array(
					'company_id' => 1,
					'bank_name' => $_POST['bname_old'][$i],
					'bank_account' => $_POST['bacc_old'][$i],
					'bank_branch' => $_POST['bbranch_old'][$i],
					'bank_iban' => $_POST['biban_old'][$i],
					'bank_swift' => $_POST['bswift_old'][$i],
				);
				$this->db->where('bid', $trans_id);
				$res = $this->db->update('company_bank_details', $data);
			}
		}

		if (isset($_POST['image_name'])) {
			for ($i = 0; $i < count($_POST['image_name']); $i++) {
				if ($_POST['image_name'][$i] != '') {
					$stamp_image = base64_encode(file_get_contents($_FILES['stamp_image']['tmp_name'][$i]));
					$data = array(
						'company_id' => 1,
						'stamp_name' => $_POST['image_name'][$i],
						'stamp_image' => $stamp_image,
					);
					$this->db->insert('company_stamp_image', $data);
				}
			}
		}


		$insert_id = $this->db->insert_id();
		$uid = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($uid, 2, $page_name[1], 'company_master', 'company_id', $id);
		return $id;
	}


}
