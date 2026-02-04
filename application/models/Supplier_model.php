<?php

class Supplier_model extends CI_Model
{

	function add_new_user()
	{
		$prefix = 'EMP';
		$this->load->model('Setup_model');

		// Get the next code for the user
		$num = $this->Setup_model->get_next_code($prefix, 'user_code', 'users', 4) + 1;

		// Format the number with leading zeros
		$digit = sprintf("%1$04d", $num);

		// Concatenate the prefix and formatted number to form the employee code
		$employee_code = $prefix . $digit;

		// Now you can use $employee_code to insert into the table

		if ($_FILES["user_image"]) {
			$allowedExts = array("jpeg", "jpg", "png");
			$fname = $_FILES["user_image"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$other_file = '';

			if (($_FILES["user_image"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
				if ($_FILES["user_image"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["user_image"]["tmp_name"];
					$other_file = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);
				}
			} else {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			}
		}

		if ($_FILES["offer_letter"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["offer_letter"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$offer_file = '';

			if (($_FILES["offer_letter"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
				if ($_FILES["offer_letter"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["offer_letter"]["tmp_name"];
					$offer_file = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $offer_file);
				}
			} else {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			}
		}

		// Prepare data for insertion 
		$data = array(
			'user_code' => $employee_code,
			'user_name' => $this->input->post('first_name'),
			'email_id' => $this->input->post('company_email'),
			'password' => $this->input->post('password'),
			'contact_no' => $this->input->post('mobile1'),
			'dept_id' => $this->input->post('department'),

			'address' => $this->input->post('address'),
			'city' => $this->input->post('city'),

			'state' => $this->input->post('state'),
			'country' => $this->input->post('country'),
			'gender' => $this->input->post('gender'),
			'bdate' => date('Y-m-d', strtotime($this->input->post('bdate'))),
			'nationality' => $this->input->post('nationality'),
			'maritial_status' => $this->input->post('maritial_status'),
			'pgrade' => $this->input->post('pgrade'),
			'joining_date' => date('Y-m-d', strtotime($this->input->post('joining_date'))),

			'GDRFA_no' => $this->input->post('GDRFA_no'),
			'Tawjeeh_status' => $this->input->post('Tawjeeh_status'),
			'Workmen_Compensation' => $this->input->post('Workmen_Compensation'),
			'simcard' => $this->input->post('simcard'),
			'vehicle' => $this->input->post('vehicle'),
			'laptop' => $this->input->post('laptop'),
			'appointed_by' => $this->input->post('appointed_by'),
			'interviw_by' => $this->input->post('interviw_by'),
			'gratuity' => $this->input->post('gratuity'),
			'salary_withdraw_via' => $this->input->post('salary_withdraw_via'),

			'remark' => $this->input->post('remark'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d H:i'),
			'contact_emirat' => $this->input->post('cp_no'),

			'Transportation_provided' => $this->input->post('Transportation_provided'),
			'Accomodation_provided' => $this->input->post('Accomodation_provided'),
			'p_address' => $this->input->post('p_address'),
			'p_city' => $this->input->post('p_city'),
			'p_state' => $this->input->post('p_state'),
			'p_country' => $this->input->post('p_country'),

			'desig_id' => $this->input->post('desig_id'),

			'user_image_path' => $other_file,
			'offer_letter_path' => $offer_file,
			'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
			'overtime' => $this->input->post('overtime'),
			'ot' => $this->input->post('OT'),
			'start_probation' => date('Y-m-d', strtotime($this->input->post('start_probation'))),
			'end_probation' => date('Y-m-d', strtotime($this->input->post('end_probation'))),
		);

		// Insert data into the database
		$this->db->insert('users', $data);

		// Get the insert ID
		$insert_id = $this->db->insert_id();
		if ($this->input->post('company_email')!='') {
        $data_user = array(
			'employee_id' => $insert_id,
			'login_id' => $this->input->post('company_email'),
			'password'=> $this->input->post('password')

		);
		$this->db->insert('user_login_credential', $data_user);
	}
		//insert passsport
		if ($insert_id) {
			if ($_FILES["passport_doc"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["passport_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["passport_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["passport_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["passport_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);

						$data = array(
							'emp_id'  => $insert_id,
							'document_name' => 'passport',
							'document_number' => $this->input->post('passport_number'),
							'reminder_flag' => $this->input->post('passport_reminder'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('passport_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('passport_expdate'))),
							'posession' => $this->input->post('passport_location'),
							'emp_document_path' => $other_file,

						);
						$this->db->insert('employee_document_details', $data);
						$this->db->insert('employee_main_document', $data);
					}
				}
			}
		}
		// visa details
		if ($insert_id) {
			if ($_FILES["visa_doc"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["visa_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["visa_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["visa_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["visa_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);

						$data = array(
							'emp_id'  => $insert_id,
							'document_name' => 'visa',
							'posession' => $this->input->post('visa'),
							'status' => $this->input->post('visa_stamping'),
							'reminder_flag' => $this->input->post('visa_reminder'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('visa_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('visa_expdate'))),
							'emp_document_path' => $other_file,
						);
						$this->db->insert('employee_document_details', $data);
						$this->db->insert('employee_main_document', $data);
					}
				}
			}
		}
		// laboar insert
		if ($insert_id) {
			if ($_FILES["labor_card_doc"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["labor_card_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["labor_card_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["labor_card_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["labor_card_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);

						$data = array(
							'emp_id'  => $insert_id,
							'document_name' => 'laboar',
							'reminder_flag' => $this->input->post('labor_card_reminder'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('labor_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('labor_expdate'))),
							'emp_document_path' => $other_file,
						);
						$this->db->insert('employee_document_details', $data);
						$this->db->insert('employee_main_document', $data);
					}
				}
			}
		}
		//Emirates insert
		if ($insert_id) {
			if ($_FILES["emirates_id_doc"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["emirates_id_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["emirates_id_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["emirates_id_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["emirates_id_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);

						$data = array(
							'emp_id'  => $insert_id,
							'document_name' => 'emirats',
							'status' => $this->input->post('EmiratesID_status'),
							'reminder_flag' => $this->input->post('emirates_id_reminder'),
							'document_number' => $this->input->post('EmiratesID'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('emirate_issuedate'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('emirate_expdate'))),
							'emp_document_path' => $other_file,
						);
						$this->db->insert('employee_document_details', $data);
						$this->db->insert('employee_main_document', $data);
					}
				}
			}
		}
		//insert Insurance
		if ($insert_id) {
			if ($_FILES["insurance_doc"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["insurance_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["insurance_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["insurance_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["insurance_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);

						$data = array(
							'emp_id'  => $insert_id,
							'document_name' => 'Insurance',
							'document_number' => $this->input->post('insurance_no'),
							'reminder_flag' => $this->input->post('insurance_reminder'),
							'status' => $this->input->post('medical_status'),
							'posession' => $this->input->post('medical_insurance'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('insurance_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('insurance_expdate'))),

							'emp_document_path' => $other_file,

						);
						$this->db->insert('employee_document_details', $data);
						$this->db->insert('employee_main_document', $data);
					}
				}
			}
		}
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'users', 'user_id', $insert_id);
		}
		return $insert_id;
	}
	function update_user_data($user_id)
	{


		if ($_FILES["user_image"]) {
			$allowedExts = array("jpeg", "jpg", "png");
			$fname = $_FILES["user_image"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$other_file = '';

			if (($_FILES["user_image"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
				if ($_FILES["user_image"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["user_image"]["tmp_name"];
					$other_file = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);
					//offer_file
					$query = $this->db->query("update users set user_image_path='$other_file' where user_id=$user_id");
				}
			}
		}

		if ($_FILES["offer_letter"]) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			$fname = $_FILES["offer_letter"]["name"];
			$temp = explode(".", $fname);
			$extension = end($temp);
			$offer_file = '';

			if (($_FILES["offer_letter"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
				if ($_FILES["offer_letter"]["error"] > 0) {
					$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
				} else {
					$timestamp1 = time();
					$file_tmp = $_FILES["offer_letter"]["tmp_name"];
					$offer_file = $timestamp1 . "_" . $fname;
					move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $offer_file);
					$query = $this->db->query("update users set offer_letter_path='$offer_file' where user_id=$user_id");
				}
			} else {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			}
		}

		$data = array(
			'desig_id' => $this->input->post('desig_id'),
			'contact_no' => $this->input->post('mobile1'),
			'address' => $this->input->post('address'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'country' => $this->input->post('country'),
			'nationality' => $this->input->post('nationality'),
			'maritial_status' => $this->input->post('maritial_status'),
			'pgrade' => $this->input->post('pgrade'),
			'joining_date' => date('Y-m-d', strtotime($this->input->post('joining_date'))),
			'end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
			'GDRFA_no' => $this->input->post('GDRFA_no'),
			'Tawjeeh_status' => $this->input->post('Tawjeeh_status'),
			// 'medical_status' => $this->input->post('medical_status'),
			// 'medical_insurance' => $this->input->post('medical_insurance'),
			'Workmen_Compensation' => $this->input->post('Workmen_Compensation'),
			'simcard' => $this->input->post('simcard'),
			'vehicle' => $this->input->post('vehicle'),
			'laptop' => $this->input->post('laptop'),
			'appointed_by' => $this->input->post('appointed_by'),
			'interviw_by' => $this->input->post('interviw_by'),
			'gratuity' => $this->input->post('gratuity'),
			'salary_withdraw_via' => $this->input->post('salary_withdraw_via'),
			//	'document_number' =>$this->input->post('document_number'),
			'Transportation_provided' => $this->input->post('Transportation_provided'),
			'Accomodation_provided' => $this->input->post('Accomodation_provided'),
			'contact_emirat' => $this->input->post('cp_no'),
			'gender' => $this->input->post('gender'),
			'bdate' => date('Y-m-d', strtotime($this->input->post('bdate'))),
			'p_address' => $this->input->post('p_address'),
			'p_city' => $this->input->post('p_city'),
			'p_state' => $this->input->post('p_state'),
			'p_country' => $this->input->post('p_country'),
			'active' => $this->input->post('status'),
			'overtime' => $this->input->post('overtime'),
			'ot' => $this->input->post('OT'),
			'start_probation' => date('Y-m-d', strtotime($this->input->post('start_probation'))),
			'end_probation' => date('Y-m-d', strtotime($this->input->post('end_probation'))),
			//'user_image_path' => $other_file,
			//'offer_letter_path' => $offer_file,
		);
		$this->db->where('user_id', $user_id);
		$res = $this->db->update('users', $data);

		//passport update
		if ($user_id) {
			if ($_FILES["passport_doc"] != '') {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["passport_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["passport_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["passport_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["passport_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);

						$data = array(

							'emp_id'  => $user_id,
							'document_name' => 'passport',
							'document_number' => $this->input->post('passport_number'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('passport_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('passport_expdate'))),
							'posession' => $this->input->post('passport_location'),
							'emp_document_path' => $other_file,
						);

						$res1 = $this->db->insert('employee_document_details', $data);
						$this->db->where('document_name', 'passport');
						$this->db->where('emp_id', $user_id);
						$res1 = $this->db->update('employee_main_document', $data);
					}
				}
			}
		}
		// visa details update
		if ($user_id) {
			if ($_FILES["visa_doc"] != '') {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["visa_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["visa_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["visa_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["visa_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);
						$data = array(
							'emp_id'  => $user_id,
							'document_name' => 'visa',
							'posession' => $this->input->post('visa'),
							'status' => $this->input->post('visa_stamping'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('visa_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('visa_expdate'))),
							'emp_document_path' => $other_file,
						);
						$this->db->insert('employee_document_details', $data);

						$this->db->where('document_name', 'visa');
						$this->db->where('emp_id', $user_id);
						$res1 = $this->db->update('employee_main_document', $data);
					}
				}
			}
		}
		// laboar insert
		if ($user_id) {
			if ($_FILES["labor_card_doc"] != '') {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["labor_card_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["labor_card_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["labor_card_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["labor_card_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);
						$data = array(
							'emp_id'  => $user_id,
							'document_name' => 'laboar',
							'issue_date' => date('Y-m-d', strtotime($this->input->post('labor_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('labor_expdate'))),
							'emp_document_path' => $other_file,
						);
						$this->db->insert('employee_document_details', $data);
						$this->db->where('document_name', 'laboar');
						$this->db->where('emp_id', $user_id);
						$res1 = $this->db->update('employee_main_document', $data);
					}
				}
			}
		}
		//Emirates update
		if ($user_id) {
			if ($_FILES["emirates_id_doc"] != '') {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["emirates_id_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["emirates_id_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["emirates_id_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["emirates_id_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);
						$data = array(
							'emp_id'  => $user_id,
							'document_name' => 'emirats',
							'status' => $this->input->post('EmiratesID_status'),
							'document_number' => $this->input->post('EmiratesID'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('emirate_issuedate'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('emirate_expdate'))),
							'emp_document_path' => $other_file,
						);
						$this->db->insert('employee_document_details', $data);
						$this->db->where('document_name', 'emirats');
						$this->db->where('emp_id', $user_id);
						$res1 = $this->db->update('employee_main_document', $data);
					}
				}
			}
		}

		//insert Update
		if ($user_id) {
			if ($_FILES["insurance_doc"] != '') {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				$fname = $_FILES["insurance_doc"]["name"];
				$temp = explode(".", $fname);
				$extension = end($temp);
				$other_file = '';

				if (($_FILES["insurance_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
					if ($_FILES["insurance_doc"]["error"] > 0) {
						$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
					} else {
						$timestamp1 = time();
						$file_tmp = $_FILES["insurance_doc"]["tmp_name"];
						$other_file = $timestamp1 . "_" . $fname;
						move_uploaded_file($file_tmp, "/home/webadmin/gen/bsg_erp/public/uploded_documents/" . $other_file);
						$data = array(
							'emp_id'  => $user_id,
							'document_name' => 'Insurance',
							'document_number' => $this->input->post('insurance_no'),
							'reminder_flag' => $this->input->post('insurance_reminder'),
							'status' => $this->input->post('medical_status'),
							'posession' => $this->input->post('medical_insurance'),
							'issue_date' => date('Y-m-d', strtotime($this->input->post('insurance_date'))),
							'expiry_date' => date('Y-m-d', strtotime($this->input->post('insurance_expdate'))),

							'emp_document_path' => $other_file,

						);
						$this->db->insert('employee_document_details', $data);
						$this->db->where('document_name', 'Insurance');
						$this->db->where('emp_id', $user_id);
						$res1 = $this->db->update('employee_main_document', $data);
					}
				}
			}
		}

		//salary insert
		// $data = array(
		// 	'emp_id'  => $user_id,
		// 	'gross_salary' => $this->input->post('GSalary'),
		// 	'basic_salary' => $this->input->post('BSalary'),
		// 	//'total_allowances' => $this->input->post('aallowance'),
		// 	//'total_allowances' => $this->input->post('tallowance'),
		// 	//'total_allowances' => $this->input->post('oallowance'),
		// 	//'total_deductions' => $this->input->post('Transportation_provided'),
		// 	//'total_deductions' => $this->input->post('Accomodation_provided'),
		// 	'overtime' => $this->input->post('OT'),

		// 	//'issue_date' => date('Y-m-d', strtotime($this->input->post('labor_date'))),
		// 	//'expiry_date' => date('Y-m-d', strtotime($this->input->post('emirate_expdate'))),
		// );
		// $this->db->insert('salary_structure', $data);

		if ($res) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'users', 'user_id', $user_id);
			return true;
		} else {

			return false;
		}
	}
	function get_user_list()
	{
		$query = $this->db->query("select u.*, d.dept_name from users u, department_master d where u.dept_id=d.dept_id order by user_name");
		return $query->result();
	}

	function get_country_list()
	{
		$query = $this->db->query("select * from country_master");
		return $query->result();
	}

	function get_active_user_list()
	{
		$query = $this->db->query("select u.*, d.dept_name from users u, department_master d where u.dept_id=d.dept_id and active=0 order by user_name");
		return $query->result();
	}

	function get_user_record_by_id($user_id)
	{
		$query = $this->db->query("SELECT * FROM users WHERE user_id = '$user_id'");
		return $query->result();
	}
	function get_user_record_by_id_pass($user_id)
	{
		$query = $this->db->query("SELECT document_number,emp_id,emp_document_path,document_name,reminder_flag, issue_date, expiry_date, posession FROM employee_document_details WHERE emp_id = '$user_id' AND document_name ='passport' ORDER BY emp_docId DESC LIMIT 1");

		return $query->result();
	}
	function get_user_record_by_id_visa($user_id)
	{
		$query = $this->db->query("SELECT issue_date,emp_id,emp_document_path,posession,reminder_flag,document_name,status,expiry_date FROM employee_document_details WHERE emp_id = '$user_id' AND document_name ='visa' ORDER BY emp_docId DESC LIMIT 1");
		return $query->result();
	}
	function get_user_record_by_id_insurance($user_id)
	{
		$query = $this->db->query("SELECT * FROM employee_document_details WHERE emp_id = '$user_id' AND document_name ='Insurance' ORDER BY emp_docId DESC LIMIT 1");
		return $query->result();
	}
	function get_user_record_by_id_labor($user_id)
	{
		$query = $this->db->query("SELECT issue_date,emp_document_path,reminder_flag,expiry_date FROM employee_main_document WHERE emp_id = '$user_id' AND document_name ='laboar' ORDER BY emp_docId DESC LIMIT 1");
		return $query->result();
	}
	function get_user_record_by_id_emirat($user_id)
	{
		$query = $this->db->query("SELECT document_number,issue_date,emp_document_path,reminder_flag,status,expiry_date,emp_id FROM employee_main_document WHERE emp_id = '$user_id' AND document_name ='emirats' ORDER BY emp_docId DESC LIMIT 1");
		return $query->result();
	}
	function get_user_record_by_id_salary($user_id)
	{
		$query = $this->db->query("SELECT gross_salary,basic_salary,overtime FROM salary_structure WHERE emp_id = '$user_id' ORDER BY sid DESC LIMIT 1");
		return $query->result();
	}

	function delete_user_record($user_id)
	{
		// Delete record from the 'users' table
		$this->db->where('user_id', $user_id);
		$this->db->delete('users');

		// Delete record from the 'employee_document_details' table where document_name is 'emirats'
		$this->db->where('emp_id', $user_id);
		$this->db->where('document_name', 'emirats');
		$this->db->order_by('emp_docId', 'DESC');
		$this->db->limit(1);
		$this->db->delete('employee_main_document');

		// Delete record from the 'employee_document_details' table where document_name is 'laboar'
		$this->db->where('emp_id', $user_id);
		$this->db->where('document_name', 'laboar');
		$this->db->order_by('emp_docId', 'DESC');
		$this->db->limit(1);
		$this->db->delete('employee_main_document');

		// Delete record from the 'employee_document_details' table where document_name is 'visa'
		$this->db->where('emp_id', $user_id);
		$this->db->where('document_name', 'visa');
		$this->db->order_by('emp_docId', 'DESC');
		$this->db->limit(1);
		$this->db->delete('employee_main_document');

		// Delete record from the 'employee_document_details' table where document_name is 'passport'
		$this->db->where('emp_id', $user_id);
		$this->db->where('document_name', 'passport');
		$this->db->order_by('emp_docId', 'DESC');
		$this->db->limit(1);
		$this->db->delete('employee_main_document');

		// Delete record from the 'salary_structure' table
		$this->db->where('emp_id', $user_id);
		$this->db->delete('salary_structure');

		// You might not need to return anything here, depending on your use case.
	}

	/////////////////  Customer master start  ///////////////////
	function add_customer_data()
	{
		//$prifix='CM'.date('y');
		$prifix = 'CM';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'cust_code', 'customer_master', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$Code = $prifix . $digit;

		$data = array(
			'cust_code' => $Code,
			'cust_name' => $this->input->post('cust_name'),
			'email_id' => $this->input->post('email'),
			'contact_no' => $this->input->post('contact_no'),
			'trn_no' => $this->input->post('trn_no'),
			'btype' => $this->input->post('btype'),
			'ctype' => $this->input->post('ctype'),
			'billing_address' => $this->input->post('billing_addr1'),
			'billing_city' => $this->input->post('billing_city'),
			'billing_state' => $this->input->post('billing_state'),
			'billing_country' => $this->input->post('billing_country'),
			'billing_po_box' => $this->input->post('billing_po'),

			'shipping_address' => $this->input->post('shipping_addr1'),
			'shipping_city' => $this->input->post('shipping_city'),
			'shipping_state' => $this->input->post('shipping_state'),
			'shipping_country' => $this->input->post('shipping_country'),
			'shipping_po_box' => $this->input->post('shipping_po'),

			//'remark' => $this->input->post('remark'),
			'created_date' => date('Y-m-d H:i:s'),
			'created_by'    => $this->session->userdata('user_id'),
		);
		$this->db->insert('customer_master', $data);
		$insert_id = $this->db->insert_id();

		$grp_no = 30;
		$data1 = array(
			'account_name' => $this->input->post('cust_name') . ' ' . $Code,
			'group_no' => $grp_no,
			'customer_id' => $insert_id,
			'opening_bal_type' => 'Dr',
		);
		$this->db->insert('general_ledger', $data1);
		$ledger_id = $this->db->insert_id();

		if (isset($_POST['cp_name'])) {
			for ($i = 0; $i < count($_POST['cp_name']); $i++) {
				if ($_POST['cp_name'][$i] != '') {
					$data = array(
						'cust_id' => $insert_id,
						'cp_name' => $_POST['cp_name'][$i],
						//'cp_desig' => $_POST['cp_desig'][$i],
						'cp_mobile' => $_POST['cp_mobile'][$i],
						'cp_email' => $_POST['cp_email'][$i],
					);
					$this->db->insert('customer_contact_person', $data);
				}
			}
		}

		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'customer_master', 'customer_id', $insert_id);
		}
		return $insert_id;
	}

	function update_customer_data($id)
	{
		$data = array(
			'cust_name' => $this->input->post('cust_name'),
			'email_id' => $this->input->post('email'),
			'contact_no' => $this->input->post('contact_no'),
			'trn_no' => $this->input->post('trn_no'),
			'btype' => $this->input->post('btype'),
			'ctype' => $this->input->post('ctype'),
			'billing_address' => $this->input->post('billing_addr1'),
			'billing_city' => $this->input->post('billing_city'),
			'billing_state' => $this->input->post('billing_state'),
			'billing_country' => $this->input->post('billing_country'),
			'billing_po_box' => $this->input->post('billing_po'),

			'shipping_address' => $this->input->post('shipping_addr1'),
			'shipping_city' => $this->input->post('shipping_city'),
			'shipping_state' => $this->input->post('shipping_state'),
			'shipping_country' => $this->input->post('shipping_country'),
			'shipping_po_box' => $this->input->post('shipping_po'),

			//'active' => $this->input->post('active'),
		);
		$this->db->where('customer_id', $id);
		$res = $this->db->update('customer_master', $data);

		if (isset($_POST['cp_name'])) {
			for ($i = 0; $i < count($_POST['cp_name']); $i++) {
				if ($_POST['cp_name'][$i] != '') {
					$data = array(
						'cust_id' => $id,
						'cp_name' => $_POST['cp_name'][$i],
						//'cp_desig' => $_POST['cp_desig'][$i],
						'cp_mobile' => $_POST['cp_mobile'][$i],
						'cp_email' => $_POST['cp_email'][$i],
					);
					$this->db->insert('customer_contact_person', $data);
				}
			}
		}
		if (isset($_POST['cp_name_old'])) {
			for ($i = 0; $i < count($_POST['cp_name_old']); $i++) {
				$trans_id = $_POST['trans_id'][$i];
				$data = array(
					'cust_id' => $id,
					'cp_name' => $_POST['cp_name_old'][$i],
					//'cp_desig' => $_POST['cp_desig_old'][$i],
					'cp_mobile' => $_POST['cp_mobile_old'][$i],
					'cp_email' => $_POST['cp_email_old'][$i],
				);
				$this->db->where('cp_id', $trans_id);
				$res = $this->db->update('customer_contact_person', $data);
			}
		}
		if ($res) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'customer_master', 'customer_id', $id);
			return true;
		} else {
			return false;
		}
	}

	function get_customer_by_id($id)
	{
		$query = $this->db->query("select * from customer_master where customer_id='$id'");
		return $query->result();
	}

	function get_customer_cp_details($id)
	{
		$query = $this->db->query("select * from customer_contact_person where cust_id='$id'");
		return $query->result();
	}

	function get_customer_list()
	{
		$query = $this->db->query("select * from customer_master order by cust_name");
		return $query->result();
	}

	function get_active_customer_list()
	{
		$query = $this->db->query("select * from customer_master where active=0 order by cust_name");
		return $query->result();
	}

	/////////////////  Supplier master start  ///////////////////
	function add_supplier_data()
	{
		//$prifix='CM'.date('y');
		$prifix = 'SP';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'supplier_code', 'supplier_master', 3) + 1;
		$digit = sprintf("%1$04d", $num);
		$Code = $prifix . $digit;

		$data = array(
			'supplier_code' => $Code,
			'supplier_name' => $this->input->post('cust_name'),
			'supplier_type' => $this->input->post('stype'),
			'website' => $this->input->post('website'),
			'email_id' => $this->input->post('email'),
			'contact_no' => $this->input->post('contact_no'),
			'trn_no' => $this->input->post('trn_no'),
			'billing_address' => $this->input->post('billing_addr1'),
			'billing_city' => $this->input->post('billing_city'),
			'billing_state' => $this->input->post('billing_state'),
			'billing_country' => $this->input->post('billing_country'),
			'billing_po_box' => $this->input->post('billing_po'),

			'shipping_address' => $this->input->post('shipping_addr1'),
			'shipping_city' => $this->input->post('shipping_city'),
			'shipping_state' => $this->input->post('shipping_state'),
			'shipping_country' => $this->input->post('shipping_country'),
			'shipping_po_box' => $this->input->post('shipping_po'),

			'bank_name' => $this->input->post('bname'),
			'bank_account' => $this->input->post('acc_no'),
			'bank_branch' => $this->input->post('branch'),
			'bank_IBAN' => $this->input->post('iban'),
			'bank_swift' => $this->input->post('swift'),
			'delivery_terms' => $this->input->post('delivery_terms'),

			'intermidiate_Bname' => $this->input->post('int_bname'),
			'intermidiate_Bacc' => $this->input->post('int_acc_no'),
			'intermidiate_Bbranch' => $this->input->post('int_branch'),
			'intermidiate_IBAN' => $this->input->post('int_iban'),
			'intermidiate_swift' => $this->input->post('int_swift'),
			'payment_terms' => $this->input->post('pterms'),
			'delivery_terms' => $this->input->post('delivery_terms'),

			'contact_person' => $this->input->post('cp_name'),
			'contact_person_number' => $this->input->post('cp_mobile'),
			//'remark' => $this->input->post('remark'),
			'created_date' => date('Y-m-d H:i'),
			'created_by'    => $this->session->userdata('user_id'),
		);
		$this->db->insert('supplier_master', $data);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
		
		   $grp_no=29;
		    $data1 = array(
			'account_name' => $this->input->post('cust_name').' '.$Code,
			'group_no' => $grp_no,
			'supplier_id' => $insert_id,
			'opening_bal_type' => 'Dr',
		    );
		    $this->db->insert('general_ledger', $data1);
		    $ledger_id=$this->db->insert_id();
		    
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'supplier_master', 'supplier_id', $insert_id);
		}
		return $insert_id;
	}

	function update_supplier_data($id)
	{
		$data = array(
			'supplier_name' => $this->input->post('cust_name'),
			'email_id' => $this->input->post('email'),
			'contact_no' => $this->input->post('contact_no'),
			'trn_no' => $this->input->post('trn_no'),
			'billing_address' => $this->input->post('billing_addr1'),
			'billing_city' => $this->input->post('billing_city'),
			'billing_state' => $this->input->post('billing_state'),
			'billing_country' => $this->input->post('billing_country'),
			'billing_po_box' => $this->input->post('billing_po'),

			'shipping_address' => $this->input->post('shipping_addr1'),
			'shipping_city' => $this->input->post('shipping_city'),
			'shipping_state' => $this->input->post('shipping_state'),
			'shipping_country' => $this->input->post('shipping_country'),
			'shipping_po_box' => $this->input->post('shipping_po'),


			'bank_name' => $this->input->post('bname'),
			'bank_account' => $this->input->post('acc_no'),
			'bank_branch' => $this->input->post('branch'),
			'bank_IBAN' => $this->input->post('iban'),
			'bank_swift' => $this->input->post('swift'),

			'intermidiate_Bname' => $this->input->post('int_bname'),
			'intermidiate_Bacc' => $this->input->post('int_acc_no'),
			'intermidiate_Bbranch' => $this->input->post('int_branch'),
			'intermidiate_IBAN' => $this->input->post('int_iban'),
			'intermidiate_swift' => $this->input->post('int_swift'),
			'payment_terms' => $this->input->post('pterms'),
			'delivery_terms' => $this->input->post('delivery_terms'),

			'contact_person' => $this->input->post('cp_name'),
			'contact_person_number' => $this->input->post('cp_mobile'),
			'active' => $this->input->post('active'),
		);
		$this->db->where('supplier_id', $id);
		$res=$this->db->update('supplier_master', $data);
		if ($res) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'supplier_master', 'supplier_id', $id);
			return true;
		} else {
			return false;
		}
	}

	function get_supplier_by_id($id)
	{
		$query = $this->db->query("select * from supplier_master where supplier_id='$id'");
		return $query->result();
	}

	function get_supplier_list()
	{
		$query = $this->db->query("select * from supplier_master order by supplier_name");
		return $query->result();
	}

	function get_active_supplier_list()
	{
		$query = $this->db->query("select * from supplier_master where active=0 order by supplier_name");
		return $query->result();
	}

	// start new function
	// function add_employee_desc_details()
	// {
	//$this->db->insert('employee_document_details', $data);
	// }
	function ajax_get_employee_details($user_id)
	{
		$query = $this->db->query("select one.joining_date,user_name, two.dept_name, three.designation_name, four.resignation_date,last_working_date, five.* from (select joining_date,user_name,dept_id,desig_id from users where user_id=$user_id)as one left join(select * from department_master)as two on(one.dept_id=two.dept_id) left join(select * from designation_master)as three on(one.desig_id=three.did) left join(select * from employee_resignation where employee_id=$user_id)as four on(1=1) left join(select * from salary_structure where emp_id=$user_id order by effective_date desc limit 1)as five on(1=1)");
		return $query->result();
	}
}
