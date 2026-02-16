<?php
class Sales_model extends CI_Model
{

	public function __construct()
	{
		$this->load->model('Setup_model');
	}


	public function add_enquiry_data()
	{
		$prefix = 'AV' . date("y") . '-ENQ';
		$num = $this->Setup_model->get_next_code($prefix, 'enquiry_code', 'enquiry_master', 11) + 1;
		$digit = sprintf("%1$05d", $num);
		$enquiry_code = $prefix . $digit;


		$data = array(
			'enquiry_code' => $enquiry_code,
			'enquiry_date' => date('Y-m-d', strtotime($_POST['enquiry_date'])),
			'enquiry_customer' => $_POST['enquiry_customer'],
			'project_name' => $_POST['project_name'],
			'enquiry_scope' => $_POST['enquiry_scope'],
			'sales_person' => $_POST['sales_person'],
			'created_by' => $this->session->userdata('user_id'),
			'last_updated_by' => $this->session->userdata('user_id'),
		);
		$res = $this->db->insert('enquiry_master', $data);
		$enquiry_id = $this->db->insert_id();

		if ($res) {
			$i = 0;
			$maxFileSize = 2 * 1024 * 1024; // 2MB
			$allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
			foreach ($_FILES['enquiry_file']['name'] as $key => $name) {

				$error = $_FILES['enquiry_file']['error'][$key];
				$tmpName = $_FILES['enquiry_file']['tmp_name'][$key];
				$size = $_FILES['enquiry_file']['size'][$key];

				if ($error === UPLOAD_ERR_NO_FILE) {
					continue;
				}

				// General error check
				if ($error !== UPLOAD_ERR_OK) {
					$res = 0;
					break;
				}

				// Validate file size
				if ($size > $maxFileSize) {
					$res = 0;
					break;
				}

				// Validate file extension and MIME type
				$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

				if (!in_array($ext, $allowedExtensions)) {
					echo "Invalid file type: $name ($mimeType)<br>";
					continue;
				}

				// Sanitize file name (remove special characters and spaces)
				$safeName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($name));
				$finalName = uniqid('', true) . '_' . $safeName;
				$destination = FCPATH . 'public/uploaded_documents/enquiry_files/' . $finalName;
				if (move_uploaded_file($_FILES['enquiry_file']['tmp_name'][$key], $destination)) {
					$data = array(
						'enquiry_id' => $enquiry_id,
						'file_title' => $_POST['file_title'][$i],
						'file_path' => $finalName,
					);
					$this->db->insert('enquiry_attachments', $data);

					$res = 1;
					$i++;
					continue;
				} else {
					$res = 0;
					break;
				}
			}
		}

		// add notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_enquiries');
		foreach ($notify_users as $r) {
			$notice = add_notification($enquiry_id, $r, "Enquiry Generated $enquiry_code", "sales/edit_enquiry/$enquiry_id", $this->session->userdata('user_id'));
		}

		return $enquiry_id;
	}

	function get_enquiry_by_status($status)
	{
		$this->db->select('em.*,cm.customer_name');
		$this->db->from('enquiry_master em');
		$this->db->join('customer_master cm', 'em.enquiry_customer=cm.customer_id');
		$this->db->where('enquiry_status', $status);
		$this->db->order_by('enquiry_code', 'DESC');
		$result = $this->db->get()->result();
		return $result;
	}

	/*public function get_all_enquiry_list()
	{
		$this->db->select('em.*,cm.customer_name');
		$this->db->from('enquiry_master em');
		$this->db->join('customer_master cm', 'em.enquiry_customer=cm.customer_id');
		$this->db->order_by('enquiry_code', 'DESC');
		$result = $this->db->get()->result();
		return $result;
	}*/
	public function get_all_enquiry_list($filters = [], $from = '', $to = '')
	{
		$this->db->select('em.*,cm.customer_name');
		$this->db->from('enquiry_master em');
		$this->db->join('customer_master cm', 'em.enquiry_customer=cm.customer_id');
		$this->db->order_by('enquiry_code', 'DESC');
		if (!empty($from) && !empty($to)) {
			$this->db->where('DATE(em.enquiry_date) >=', $from);
			$this->db->where('DATE(em.enquiry_date) <=', $to);
		}

		// 🔹 Apply filters only if provided
		if (!empty($filters) && is_array($filters)) {
			foreach ($filters as $filter) {
				$parts = explode(':', $filter, 2);
				if (count($parts) == 2) {
					$key = strtolower(trim($parts[0]));
					$value = trim($parts[1]);
					if (!empty($value)) {
						switch ($key) {
							case 'enquiry code':
								$this->db->like('em.enquiry_code', $value);
								break;
							case 'project':
								$this->db->like('em.project_name', $value);
								break;
							case 'customer':
								$this->db->like('cm.customer_name', $value);
								break;
							case 'supplier':
								$this->db->like('em.supplier_name', $value);
								break;
						}
					}
				}
			}
		}
		$this->db->order_by('em.enquiry_date', 'DESC');
		$result = $this->db->get()->result();
		return $result;
	}

	public function get_enquiry_by_id($enquiry_id)
	{
		$this->db->select('em.*,cm.*');
		$this->db->from('enquiry_master em');
		$this->db->join('customer_master cm', 'em.enquiry_customer=cm.customer_id');
		$this->db->where('enquiry_id', $enquiry_id);
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function get_enquiry_files($enquiry_id)
	{
		$this->db->select('*');
		$this->db->from('enquiry_attachments ea');
		$this->db->where('enquiry_id', $enquiry_id);
		$result = $this->db->get()->result();
		return $result;
	}

	function update_enquiry_data()
	{

		$res = 0;
		$data = array(
			'enquiry_date' => $_POST['enquiry_date'],
			'enquiry_customer' => $_POST['enquiry_customer'],
			'enquiry_scope' => $_POST['enquiry_scope'],
			'project_name' => $_POST['project_name'],
			'sales_person' => $_POST['requested_by'],
			'last_updated_by' => $this->session->userdata('user_id'),
		);
		$this->db->where('enquiry_id', $_POST['enquiry_id']);
		$res = $this->db->update('enquiry_master', $data);

		if ($res && !empty($_POST['deleted_attachments'])) {
			$deleted_ids_array = explode(',', $_POST['deleted_attachments']);
			foreach ($deleted_ids_array as $attachment) {
				$file_details = $this->db->where('attachment_id', $attachment)->get('enquiry_attachments')->row_array();
				$file = 'public/uploaded_documents/enquiry_files/' . $file_details['file_path'];
				if (file_exists($file)) {
					if (unlink($file)) {
						$res = $this->db->where('attachment_id', $attachment)->delete('enquiry_attachments');
						$res = 1;
					} else {
						$res = 0;
					}
				} else {
					$res = 0;
				}
			}
		}
		if ($res && isset($_POST['file_title'])) {
			if ($_FILES["enquiry_file"]) {
				$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
				for ($i = 0; $i < count($_FILES['enquiry_file']["name"]); $i++) {
					if ($_FILES['enquiry_file']["name"][$i] != '') {
						$file_name = $_FILES["enquiry_file"]["name"][$i];
						$pattern = '/[^a-zA-Z0-9_]/';
						$fname = preg_replace($pattern, '_', $file_name);
						$fname = str_replace(' ', '_', $file_name);
						$temp = explode(".", $fname);
						$extension = end($temp);
						$enquiry_file = '';
						if (($_FILES["enquiry_file"]["size"][$i] < 15728640) && in_array($extension, $allowedExts)) {
							if ($_FILES["enquiry_file"]["error"][$i] > 0) {
								$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
							} else {
								$timestamp1 = time();
								$file_tmp = $_FILES["enquiry_file"]["tmp_name"][$i];
								$enquiry_file = $timestamp1 . "_" . $fname;
								$dest = FCPATH . 'public/uploaded_documents/enquiry_files/' . $enquiry_file;
								move_uploaded_file($file_tmp, $dest);
								$data1 = array(
									'enquiry_id' => $_POST['enquiry_id'],
									'file_title' => $_POST['file_title'][$i],
									'file_path' => $enquiry_file,
								);
								$this->db->insert('enquiry_attachments', $data1);
							}
						}
					}
				}
			}
		}

		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_enquiries');
		$enquiry_id   = $this->input->post('enquiry_id', TRUE);   // TRUE enables XSS filtering
		$enquiry_code = $this->input->post('enquiry_code', TRUE);
		foreach ($notify_users as $r) {
			$notice = add_notification($enquiry_id, $r, "Enquiry Updated {$enquiry_code}", "sales/edit_enquiry/{$enquiry_id}", $this->session->userdata('user_id'));
		}
	}

	function get_enquiry_count($firstDay, $lastDay)
	{
		$res = $this->db->select('count(*) as enquiry_count')->where("created_at BETWEEN '$firstDay' AND '$lastDay'")->get('enquiry_master')->row('enquiry_count');
		return $res;
	}

	//estimation
	public function get_estimation_latest_revisions()
	{
		$this->db->select('em.*,enq.enquiry_code,cm.customer_name,qtn.quotation_approval');
		$this->db->from('estimation_master em');
		$this->db->join(
			'(SELECT estimation_code, MAX(estimation_revision) AS max_revision FROM estimation_master GROUP BY estimation_code) latest',
			'em.estimation_code = latest.estimation_code AND em.estimation_revision = latest.max_revision'
		);
		$this->db->join('sales_quotation_master qtn', 'em.estimation_id = qtn.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'em.enquiry_id = enq.enquiry_id', 'left');
		$this->db->join('customer_master cm', 'enq.enquiry_customer = cm.customer_id', 'left');
		$this->db->order_by('em.estimation_code', 'DESC');
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}

	public function get_estimation_revisions_grouped()
	{
		$revisions = $this->db->from('estimation_master')
			->order_by('estimation_revision', 'DESC')
			->get()
			->result();

		$all_revisions = [];
		foreach ($revisions as $rev) {
			$all_revisions[$rev->estimation_code][] = $rev;
		}

		return $all_revisions;
	}

	/*public function get_all_estimation_list()
	{
		$query = $this->db->query(' SELECT est.*,CASE WHEN est.estimation_revision = latest.max_revision THEN 1 ELSE 0 END AS is_latest,em.*,cm.customer_name FROM estimation_master est
		LEFT JOIN (
			SELECT estimation_code, MAX(estimation_revision) AS max_revision
			FROM estimation_master
			GROUP BY estimation_code
		) latest
      	ON est.estimation_code = latest.estimation_code
		LEFT JOIN enquiry_master em ON est.enquiry_id = em.enquiry_id
		LEFT JOIN customer_master cm ON em.enquiry_customer = cm.customer_id
		order by estimation_code DESC, estimation_revision DESC');
		$result = $query->result_array();

		return $result;
	}*/
	public function get_all_estimation_list($filters = [], $from = '', $to = '')
	{
		// 🔹 Build main query
		$this->db->select("
        est.*,
        CASE 
            WHEN est.estimation_revision = latest.max_revision THEN 1 
            ELSE 0 
        END AS is_latest,
        em.*,
        cm.customer_name
    ", false); // 👈 IMPORTANT: prevent escaping

		$this->db->from('estimation_master est');
		$this->db->join(
			"(SELECT estimation_code, MAX(estimation_revision) AS max_revision
                      FROM estimation_master
                      GROUP BY estimation_code) latest",
			'est.estimation_code = latest.estimation_code',
			'left'
		);
		$this->db->join('enquiry_master em', 'est.enquiry_id = em.enquiry_id', 'left');
		$this->db->join('customer_master cm', 'em.enquiry_customer = cm.customer_id', 'left');

		// 🔹 Date filter
		if (!empty($from) && !empty($to)) {
			$this->db->where('DATE(est.estimation_date) >=', $from);
			$this->db->where('DATE(est.estimation_date) <=', $to);
		}

		// 🔹 Apply filters only if provided
		if (!empty($filters) && is_array($filters)) {
			foreach ($filters as $filter) {
				$parts = explode(':', $filter, 2);
				if (count($parts) == 2) {
					$key = strtolower(trim($parts[0]));
					$value = trim($parts[1]);

					if (!empty($value)) {
						switch ($key) {
							case 'enquiry code':
								$this->db->like('em.enquiry_code', $value);
								break;
							case 'project':
								$this->db->like('em.project_name', $value);
								break;
							case 'customer':
								$this->db->like('cm.customer_name', $value);
								break;
							case 'estimation code':
								$this->db->like('est.estimation_code', $value);
								break;
						}
					}
				}
			}
		}

		// 🔹 Order by estimation code and revision
		$this->db->order_by('est.estimation_code', 'DESC');
		$this->db->order_by('est.estimation_revision', 'DESC');

		return $this->db->get()->result_array();
	}

	public function autosave_estimation()
	{
		$save_status = $_POST['save_status'];
		if ($save_status == 0) {
			$prefix = $prefix = 'AV' . date("y") . '-EST';

			$num = $this->Setup_model->get_next_code($prefix, 'estimation_code', 'estimation_master', 11) + 1;
			$digit = sprintf("%1$05d", $num);
			$estimation_code = $prefix . $digit;

			$data = array(
				'estimation_code' => $estimation_code,
				'estimation_revision' => 0,
				'enquiry_id' => $_POST['enquiry_id'],
				'vat_percent' => $_POST['vat_percent'],
				'grand_total' => $_POST['grand_total'],
				'customer_contact_id' => $_POST['customer_contact'],
				'notes' => $_POST['notes'],
				'currency' => $_POST['currency_id'],
				'payment' => $_POST['payment'],
				'delivery' => $_POST['delivery'],
				'availability' => $_POST['availability'],
				'warranty' => $_POST['warranty'],
				'conditions' => $_POST['conditions'],
				'created_by' => $this->session->userdata('user_id'),
			);
			$this->db->insert('estimation_master', $data);
			$estimation_id = $this->db->insert_id();

			//notification
			$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_estimations');
			foreach ($notify_users as $r) {
				$notice = add_notification($estimation_id, $r, "Estimation Created {$estimation_code}", "sales/edit_estimation/{$estimation_id}/0/1", $this->session->userdata('user_id'));
			}
		} else {
			$estimation_id = $_POST['save_status'];
			$data = array(
				'vat_percent' => $_POST['vat_percent'],
				'grand_total' => $_POST['grand_total'],
				'customer_contact_id' => $_POST['customer_contact'],
				'notes' => $_POST['notes'],
				'currency' => $_POST['currency_id'],
				'payment' => $_POST['payment'],
				'delivery' => $_POST['delivery'],
				'availability' => $_POST['availability'],
				'warranty' => $_POST['warranty'],
				'conditions' => $_POST['conditions'],
				'created_by' => $this->session->userdata('user_id'),
			);
			$this->db->where('estimation_id', $estimation_id);
			$this->db->update('estimation_master', $data);
		}
		$discount2_limit = $this->Setup_model->get_discount_limit();
		$approval = 1;

		$this->db->where('estimation_id', $estimation_id)->delete('estimation_details');

		for ($i = 0; $i < $_POST['row_count']; $i++) {

			if ($_POST['item'][$i] != '') {
				if ($approval && ($_POST['discount1'][$i] > $_POST['discount1_limit'][$i])) {
					$approval = 0;
				}
				if ($approval && ($_POST['discount2'][$i] > $discount2_limit['setting_value'])) {
					$approval = 0;
				}
				$data = array(
					'estimation_id' => $estimation_id,
					'item_category' => $_POST['item_category'][$i],
					'item_id' => $_POST['item'][$i],
					'quantity' => $_POST['quantity'][$i],
					'unit_id' => $_POST['unit'][$i] ?? 0,
					'actual_price'  => $_POST['quote_price'][$i],
					'discount1_percent' => $_POST['discount1'][$i],
					'discount2_percent' => $_POST['discount2'][$i],
					'section_title' => $_POST['section_title'][$i],
				);
				$this->db->insert('estimation_details', $data);
			}
		}

		//update the approval status for estimation
		$this->db->set('approval', $approval);
		$this->db->where('estimation_id', $estimation_id);
		$this->db->update('estimation_master');

		return $estimation_id;
	}

	// public function add_estimation_data(){
	// 	$prefix = $prefix='AV'.date("y").'-EST';
	// 	$this->load->model('Setup_model');
	// 	$num = $this->Setup_model->get_next_code($prefix,'estimation_code','estimation_master',11)+1;
	// 	$digit=sprintf("%1$05d",$num);
	// 	$estimation_code =$prefix.$digit;

	// 	$discount2_limit = $this->Setup_model->get_discount_limit();
	// 	$approval = 1;
	// 	$data=array(
	// 		'estimation_code' => $estimation_code,
	// 		'estimation_revision' => 0,
	// 		'enquiry_id' => $_POST['enquiry_id'],
	// 		'vat_percent' => $_POST['vat_percent'],
	// 		'grand_total' => $_POST['grand_total'],
	// 		'customer_contact_id' => $_POST['customer_contact'],
	// 		'notes' => $_POST['notes'],
	// 		'currency'=> $_POST['currency_id'],
	// 		'payment'=> $_POST['payment'],
	// 		'delivery'=> $_POST['delivery'],
	// 		'availability'=> $_POST['availability'],
	// 		'warranty'=> $_POST['warranty'],
	// 		'conditions'=> $_POST['conditions'],
	// 		'created_by' => $this->session->userdata('user_id'),
	// 	);
	// 	$this->db->insert('estimation_master',$data);
	// 	$estimation_id = $this->db->insert_id();


	// 	for($i=0 ; $i < $_POST['row_count'] ; $i++){

	// 		if($_POST['item'][$i] != ''){
	// 			if($approval && ($_POST['discount1'][$i] > $_POST['discount1_limit'][$i])){
	// 				$approval = 0;
	// 			}
	// 			if($approval && ($_POST['discount2'][$i] > $discount2_limit['setting_value'])){
	// 				$approval = 0;
	// 			}
	// 			$data=array(
	// 				'estimation_id' => $estimation_id,
	// 				'item_id' => $_POST['item'][$i],
	// 				'quantity' => $_POST['quantity'][$i],
	// 				'unit_id' => $_POST['unit'][$i],
	// 				'actual_price'  => $_POST['quote_price'][$i],
	// 				'discount1_percent' => $_POST['discount1'][$i],
	// 				'discount2_percent' => $_POST['discount2'][$i],
	// 				'section_title' => $_POST['section_title'][$i],
	// 			);
	// 			$this->db->insert('estimation_details',$data);
	// 		}

	// 	}

	// 	//update the approval status for estimation
	// 	$this->db->set('approval',$approval);
	// 	$this->db->where('estimation_id',$estimation_id);
	// 	$this->db->update('estimation_master');

	// 	return $estimation_id;
	// }

	public function get_estimation_by_id($estimation_id)
	{
		$this->db->select('est.*,enq.*,cm.customer_name');
		$this->db->from('estimation_master est');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id');
		$this->db->join('customer_master cm', 'enq.enquiry_customer=cm.customer_id');
		$this->db->where('estimation_id', $estimation_id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_estimation_details($estimation_id)
	{
		// subquery for stock_details
		$subquery = "(SELECT product_id, COUNT(*) AS stock_qty
              FROM stock_details
              WHERE status = 0
                AND inv_type = 'Actual Stock'
              GROUP BY product_id) sd";

		$this->db->select('est.*,im.item_id,im.item_code,im.item_type,im.item_brand,im.item_model,im.item_description,im.item_unit,im.c_o_o,im.hs_code,im.	mrp_aed,bm.*,COALESCE(est.item_id, im.item_id) AS item_id,COALESCE(sd.stock_qty, 0) AS current_stock,COALESCE(im.item_model, cim.custom_item_name) AS item_model,COALESCE(im.item_description, cim.custom_item_description) AS item_description');
		$this->db->from('estimation_details est');
		$this->db->join('item_master im', 'est.item_category = 1 and est.item_id=im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'est.item_category = 0 and est.item_id=cim.custom_item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
		$this->db->join($subquery, 'est.item_category = 1 AND est.item_id = sd.product_id', 'left');
		$this->db->where('est.estimation_id', $estimation_id);
		$this->db->order_by('est.detail_id');
		//echo '<pre>'; echo $this->db->get_compiled_select();exit;
		$result = $this->db->get()->result();

		return $result;
	}

	public function delete_estimation_by_id($estimation_id, $enquiry_id)
	{
		$this->db->select('*');
		$this->db->where('estimation_id', $estimation_id);
		$res = $this->db->delete('estimation_details');
		echo $res;
		if ($res) {
			$this->db->select('*');
			$this->db->where('estimation_id', $estimation_id);
			$res = $this->db->delete('estimation_master');
			echo $res;
		}
		if ($res) {
			$this->db->set('enquiry_status', 0);
			$this->db->where('enquiry_id', $enquiry_id);
			$res = $this->db->update('enquiry_master');
			echo $res;
		}
		return $res;
	}

	function update_estimation_data()
	{
		$discount2_limit = $this->Setup_model->get_discount_limit();
		$estimation_id = $_POST['estimation_id'];
		$approval = $_POST['estimation_approval'];
		$res = 0;
		if (!empty($_POST['deleted_details'])) {
			$deleted_details_array = explode(',', $_POST['deleted_details']);
			foreach ($deleted_details_array as $detail) {
				$res = $this->db->where('detail_id', $detail)->delete('estimation_details');
				$res = 1;
			}
		}

		for ($i = 0; $i < $_POST['row_count']; $i++) {
			if (isset($_POST['item'][$i])) {
				$data = array(
					'item_category' => $_POST['item_category'][$i],
					'item_id' => $_POST['item'][$i],
					'quantity' => $_POST['quantity'][$i],
					'unit_id' => $_POST['unit'][$i],
					'actual_price'  => $_POST['quote_price'][$i],
					'discount1_percent' => $_POST['discount1'][$i],
					'discount2_percent' => $_POST['discount2'][$i],
					'section_title' => $_POST['section_title'][$i],
				);


				if (isset($_POST['detail_id'][$i])) {
					if ($approval) {
						$discount_values = $this->db->where('detail_id', $_POST['detail_id'][$i])->get('estimation_details')->row_array();
						if (($discount_values['discount1_percent'] != $_POST['discount1'][$i]) && ($_POST['discount1'][$i] > $_POST['discount1_limit'][$i]))
							$approval = 0;
						else if (($discount_values['discount2_percent'] != $_POST['discount2'][$i]) && $_POST['discount2'][$i] > $discount2_limit['setting_value'])
							$approval = 0;
					}
					$this->db->where('detail_id', $_POST['detail_id'][$i]);
					$res = $this->db->update('estimation_details', $data);
				} else {
					if ($approval && ($_POST['discount1'][$i] > $_POST['discount1_limit'][$i])) {
						$approval = 0;
					}
					if ($approval && ($_POST['discount2'][$i] > $discount2_limit['setting_value'])) {
						$approval = 0;
					}
					$data['estimation_id'] = $_POST['estimation_id'];
					$this->db->insert('estimation_details', $data);
				}
			}
		}
		if ($res) {
			$data = array(
				'vat_percent' => $_POST['vat_percent'],
				'grand_total' => $_POST['grand_total'],
				'customer_contact_id' => $_POST['customer_contact'],
				'notes' => $_POST['notes'],
				'currency' => $_POST['currency_id'],
				'payment' => $_POST['payment'],
				'delivery' => $_POST['delivery'],
				'availability' => $_POST['availability'],
				'warranty' => $_POST['warranty'],
				'conditions' => $_POST['conditions'],
				'approval' => $approval,
			);
			$this->db->where('estimation_id', $_POST['estimation_id']);
			$res = $this->db->update('estimation_master', $data);
		}

		//update the approval of quotation if the estimation update is after quotation approval
		if ($res) {
			$this->db->set('quotation_approval', 0);
			$this->db->where('estimation_id', $_POST['estimation_id']);
			$res = $this->db->update('sales_quotation_master');
		}

		//notification for estimation update
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_estimations');
		$estimation_id = $_POST['estimation_id'];
		$estimation_code = $_POST['estimation_code'];
		foreach ($notify_users as $r) {
			//notification
			if (has_user_privilege('Estimation Approval', $r) && $approval == 0) {
				$notice = add_notification($estimation_id, $r, "Estimation requires Approval {$estimation_code}", "sales/edit_estimation/{$estimation_id}/0/1", $this->session->userdata('user_id'));
			} else {
				$notice = add_notification($estimation_id, $r, "Estimation Updated {$estimation_code}", "sales/edit_estimation/{$estimation_id}/0/1", $this->session->userdata('user_id'));
			}
		}




		return $_POST['estimation_id'];
	}

	function revise_estimation_data()
	{

		$discount2_limit = $this->Setup_model->get_discount_limit();

		$latest_revision = $this->db->select('*')->from('estimation_master')->where('estimation_code', $_POST['estimation_code'])->order_by('estimation_revision', 'desc')->limit(1)->get()->row('estimation_revision');
		$approval = 1;
		$enquiry_id = $_POST['enquiry_id'];
		$res = 0;
		$data = array(
			'estimation_code' => $_POST['estimation_code'],
			'estimation_revision' => $latest_revision + 1,
			'enquiry_id' => $_POST['enquiry_id'],
			'vat_percent' => $_POST['vat_percent'],
			'grand_total' => $_POST['grand_total'],
			'customer_contact_id' => $_POST['customer_contact'],
			'notes' => $_POST['notes'],
			'currency' => $_POST['currency_id'],
			'payment' => $_POST['payment'],
			'delivery' => $_POST['delivery'],
			'availability' => $_POST['availability'],
			'warranty' => $_POST['warranty'],
			'conditions' => $_POST['conditions'],
			'created_by' => $this->session->userdata('user_id'),
		);
		$this->db->insert('estimation_master', $data);
		$estimation_id = $this->db->insert_id();

		if ($estimation_id) {
			for ($i = 0; $i < $_POST['row_count']; $i++) {

				if ($_POST['item'][$i] != '') {

					$data = array(
						'estimation_id' => $estimation_id,
						'item_category' => $_POST['item_category'][$i],
						'item_id' => $_POST['item'][$i],
						'quantity' => $_POST['quantity'][$i],
						'unit_id' => $_POST['unit'][$i],
						'actual_price'  => $_POST['quote_price'][$i],
						'discount1_percent' => $_POST['discount1'][$i],
						'discount2_percent' => $_POST['discount2'][$i],
					);
					if ($_POST['detail_id'][$i] > 0) {
						if ($approval) {
							$discount_values = $this->db->where('detail_id', $_POST['detail_id'][$i])->get('estimation_details')->row_array();
							if (($discount_values['discount1_percent'] != $_POST['discount1'][$i]) && ($_POST['discount1'][$i] > $_POST['discount1_limit'][$i]))
								$approval = 0;
							else if (($discount_values['discount2_percent'] != $_POST['discount2'][$i]) && $_POST['discount2'][$i] > $discount2_limit['setting_value'])
								$approval = 0;
						}
					} else {
						if ($approval && ($_POST['discount1'][$i] > $_POST['discount1_limit'][$i])) {
							$approval = 0;
						}
						if ($approval && ($_POST['discount2'][$i] > $discount2_limit['setting_value'])) {
							$approval = 0;
						}
					}
					$res = $this->db->insert('estimation_details', $data);
				}
			}
		}

		//update estimation approval
		$this->db->set('approval', $approval);
		$this->db->where('estimation_id', $estimation_id);
		$this->db->update('estimation_master');

		//notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_estimations');
		$estimation_code = $_POST['estimation_code'] . '-Rev' . ($latest_revision + 1);
		foreach ($notify_users as $r) {
			if (has_user_privilege('Estimation Approval', $r) && $approval == 0) {
				$notice = add_notification($estimation_id, $r, "Estimation requires Approval {$estimation_code}", "sales/edit_estimation/{$estimation_id}/0/1", $this->session->userdata('user_id'));
			} else {
				$notice = add_notification($estimation_id, $r, "Estimation Revised {$estimation_code}", "sales/edit_estimation/{$estimation_id}/0/1", $this->session->userdata('user_id'));
			}
		}

		return $estimation_id;
	}

	function approve_estimation_data()
	{

		$res = 0;
		$estimation_id = $_POST['estimation_id'];

		$this->db->set('approval', 1);
		$this->db->where('estimation_id', $estimation_id);
		$res = $this->db->update('estimation_master');

		//update the quotation if generated
		if ($res && $_POST['quotation_status'] && $_POST['quoted_estimation_id'] == $estimation_id) {
			$data = array(
				'additional_discount' => $_POST['total_discount2'],
				'vat_percent' => $_POST['vat_percent'],
				'grand_total' => $_POST['grand_total'],
			);
			$this->db->where('estimation_id', $estimation_id);
			$res = $this->db->update('sales_quotation_master', $data);
		}

		//notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_estimations');
		$latest_revision = $this->db->select('*')->from('estimation_master')->where('estimation_code', $_POST['estimation_code'])->order_by('estimation_revision', 'desc')->limit(1)->get()->row('estimation_revision');
		$estimation_code = $_POST['estimation_code'] . '-Rev' . ($latest_revision + 1);

		foreach ($notify_users as $r) {
			$notice = add_notification($estimation_id, $r, "Estimation Approved {$estimation_code}", "sales/edit_estimation/{$estimation_id}/0/1", $this->session->userdata('user_id'));
		}

		if ($res)
			return $estimation_id;
		else
			return $res;
	}

	public function get_quotation_status_for_estimation($estimation_id)
	{
		//checking if quotation is generated for estimation
		$this->db->from('sales_quotation_master');
		$this->db->where('estimation_id', $estimation_id);
		// $this->db->order_by('quotation_revision', 'DESC');
		// $this->db->limit(1);


		$result = $this->db->get()->row_array();

		return $result;
	}

	//quotations
	function add_quotation_data()
	{

		$estimation_code = $_POST['estimation_code'];
		$qtn = $this->db->select('*')->from('sales_quotation_master')->where('estimation_code', $estimation_code)->order_by('quotation_revision', 'DESC')->get()->row_array();
		if ($qtn) {
			$quotation_code = $qtn['quotation_code'];
			$quotation_revision = $qtn['quotation_revision'] + 1;
		} else {
			$prefix = 'AV' . date("y") . '-';
			$num = $this->Setup_model->get_next_code($prefix, 'quotation_code', 'sales_quotation_master', 7) + 1;
			$digit = sprintf("%1$05d", $num);
			$quotation_code = $prefix . $digit;

			$quotation_revision = 0;
		}

		$quotation_date = date('Y-m-d');
		$data = array(
			'quotation_code' => $quotation_code,
			//'quotation_revision' => 0,
			'quotation_revision' => $quotation_revision,
			'quotation_date' => $quotation_date,
			'estimation_id' => $_POST['estimation_id'],
			'estimation_code' => $_POST['estimation_code'],
			'additional_discount' => $_POST['total_discount2'],
			'vat_percent' => $_POST['vat_percent'],
			'validity' => date('Y-m-d', strtotime($quotation_date . ' +15 days')),
			'grand_total' => $_POST['grand_total'],
			'created_by' => $this->session->userdata('user_id'),
			'last_updated_by' => $this->session->userdata('user_id'),
		);
		$res = $this->db->insert('sales_quotation_master', $data);
		$quotation_id = $this->db->insert_id();

		//notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_quotations');
		$qtn_code = $quotation_code . '-Rev' . $quotation_revision;
		foreach ($notify_users as $r) {
			$notice = add_notification($quotation_id, $r, "Quotation Created {$qtn_code}", "sales/edit_quotation/{$quotation_id}/0/1", $this->session->userdata('user_id'));
		}

		return $res;
	}

	function add_direct_quotation_data()
	{


		$prefix = 'AV' . date("y") . '-';
		$num = $this->Setup_model->get_next_code($prefix, 'quotation_code', 'sales_quotation_master', 7) + 1;
		$digit = sprintf("%1$05d", $num);
		$quotation_code = $prefix . $digit;
		$quotation_revision = 0;


		$quotation_date = date('Y-m-d');
		$data = array(
			'quotation_code' => $quotation_code,
			'quotation_revision' => $quotation_revision,
			'quotation_date' => $quotation_date,
			'additional_discount' => $_POST['total_discount2'],
			'vat_percent' => $_POST['vat_percent'],
			'validity' => date('Y-m-d', strtotime($quotation_date . ' +15 days')),
			'grand_total' => $_POST['grand_total'],
			'created_by' => $this->session->userdata('user_id'),
			'last_updated_by' => $this->session->userdata('user_id'),
			'cust_id' => $_POST['enquiry_id'],
			'notes' => $_POST['notes'],
			'currency' => $_POST['currency_id'],
			'payment' => $_POST['payment'],
			'delivery' => $_POST['delivery'],
			'availability' => $_POST['availability'],
			'warranty' => $_POST['warranty'],
			'conditions' => $_POST['conditions'],
			'quotation_approval' => 1,
			'direct_quotation' => 1,
		);
		$res = $this->db->insert('sales_quotation_master', $data);
		$quotation_id = $this->db->insert_id();

		// =========================================
		for ($i = 0; $i < $_POST['row_count']; $i++) {

			if ($_POST['item'][$i] != '') {

				$data = array(
					'quote_id' => $quotation_id,
					'item_category' => $_POST['item_category'][$i],
					'item_id' => $_POST['item'][$i],
					'quantity' => $_POST['quantity'][$i],
					'unit_id' => $_POST['unit'][$i] ?? 0,
					'actual_price'  => $_POST['quote_price'][$i],
					'discount1_percent' => $_POST['discount1'][$i],
					'discount2_percent' => $_POST['discount2'][$i],
					'section_title' => $_POST['section_title'][$i],
				);
				$this->db->insert('sales_quotation_details', $data);
			}
		}


		// ======================================================
		//notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_quotations');
		$qtn_code = $quotation_code . '-Rev' . $quotation_revision;
		foreach ($notify_users as $r) {
			$notice = add_notification($quotation_id, $r, "Quotation Created {$qtn_code}", "sales/edit_quotation/{$quotation_id}/0/1", $this->session->userdata('user_id'));
		}

		return $res;
	}

	function update_direct_quotation_data()
	{

		$quotation_id = $_POST['estimation_code'];

		// ✅ First delete old records for this quotation
		$this->db->where('quote_id', $quotation_id);
		$this->db->delete('sales_quotation_details');

		// ✅ Then insert fresh rows
		for ($i = 0; $i < $_POST['row_count']; $i++) {

			if (!empty($_POST['item'][$i])) {

				$data = array(
					'quote_id'          => $quotation_id,
					'item_category'     => $_POST['item_category'][$i],
					'item_id'           => $_POST['item'][$i],
					'quantity'          => $_POST['quantity'][$i],
					'unit_id'           => $_POST['unit'][$i] ?? 0,
					'actual_price'      => $_POST['quote_price'][$i],
					'discount1_percent' => $_POST['discount1'][$i],
					'discount2_percent' => $_POST['discount2'][$i],
					'section_title'     => $_POST['section_title'][$i],
				);

				$this->db->insert('sales_quotation_details', $data);
			}
		}

		$data = array(
			'vat_percent' => $_POST['vat_percent'],
			'grand_total' => $_POST['grand_total'],
			// 'customer_contact_id' => $_POST['customer_contact'],
			'notes' => $_POST['notes'],
			'currency' => $_POST['currency_id'],
			'payment' => $_POST['payment'],
			'delivery' => $_POST['delivery'],
			'availability' => $_POST['availability'],
			'warranty' => $_POST['warranty'],
			'conditions' => $_POST['conditions'],

		);
		$this->db->where('quotation_id', $quotation_id);
		$res = $this->db->update('sales_quotation_master', $data);
		return $res;
	}

	public function get_quotation_latest_revisions()
	{
		$this->db->select('sqm.*,enq.enquiry_code,cm.customer_name,est.approval');
		$this->db->from('sales_quotation_master sqm');
		$this->db->join(
			'(SELECT estimation_code, MAX(quotation_revision) AS max_revision FROM sales_quotation_master GROUP BY estimation_code) latest',
			'sqm.estimation_code = latest.estimation_code AND sqm.quotation_revision = latest.max_revision'
		);
		$this->db->join('estimation_master est', 'sqm.estimation_id = est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id = enq.enquiry_id', 'left');
		$this->db->join('customer_master cm', 'enq.enquiry_customer = cm.customer_id', 'left');
		$this->db->order_by('sqm.quotation_date', 'DESC');
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}

	public function get_quotation_revisions_grouped()
	{
		$revisions = $this->db->from('sales_quotation_master')
			->order_by('quotation_revision', 'DESC')
			->get()
			->result();

		$all_revisions = [];
		foreach ($revisions as $rev) {
			$all_revisions[$rev->estimation_code][] = $rev;
		}

		return $all_revisions;
	}

	/*public function get_all_quotation_list()
	{
		$this->db->select('sqm.*,sqd.*,enq.enquiry_code,cm.customer_name,cm2.customer_name as cname,est.approval,est.estimation_revision');
		$this->db->from('sales_quotation_master sqm');
		$this->db->join('sales_quotation_details sqd', 'sqm.quotation_id  = sqd.quote_id', 'left');
		$this->db->join('estimation_master est', 'sqm.estimation_id = est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id = enq.enquiry_id', 'left');
		$this->db->join('customer_master cm', 'enq.enquiry_customer = cm.customer_id', 'left');
		$this->db->join('customer_master cm2', 'sqm.cust_id = cm2.customer_id', 'left');
		$this->db->order_by('sqm.quotation_code', 'DESC');
		$this->db->order_by('sqm.quotation_revision', 'DESC');
		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}*/
	public function get_all_quotation_list($filters = [], $from = '', $to = '')
	{
		//print_r($filters);exit();
		$this->db->select('sqm.*, enq.enquiry_code, cm.customer_name, cm2.customer_name as cname, est.approval, est.estimation_revision');
		$this->db->from('sales_quotation_master sqm');
		$this->db->join('estimation_master est', 'sqm.estimation_id = est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id = enq.enquiry_id', 'left');
		$this->db->join('customer_master cm', 'enq.enquiry_customer = cm.customer_id', 'left');
		$this->db->join('customer_master cm2', 'sqm.cust_id = cm2.customer_id', 'left');

		if (!empty($from) && !empty($to)) {
			$this->db->where('DATE(sqm.quotation_date) >=', $from);
			$this->db->where('DATE(sqm.quotation_date) <=', $to);
		}

		// 🔹 Apply filters only if provided
		if (!empty($filters) && is_array($filters)) {
			foreach ($filters as $filter) {
				$parts = explode(':', $filter, 2);
				if (count($parts) == 2) {
					$key = strtolower(trim($parts[0]));
					$value = trim($parts[1]);
					if (!empty($value)) {
						switch ($key) {
							case 'quotation_code':
								$this->db->like('sqm.quotation_code', $value);
								break;
							case 'estimation_code':
								$this->db->like('est.estimation_code', $value);
								break;
							case 'Customer':
								$this->db->like('cm.customer_name', $value);
								break;
							case 'supplier':
								$this->db->like('sm.supplier_name', $value);
								break;
						}
					}
				}
			}
		}
		// 🟢 Sort quotations first, then their variations
		$this->db->order_by('sqm.quotation_code', 'DESC');
		$this->db->order_by('sqm.quotation_revision', 'DESC');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_max_revision($quotation_id)
	{
		$this->db->select('max_revision');
		$this->db->from('sales_quotation_master');
		$this->db->where('quotation_id', $quotation_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->max_revision;
		} else {
			return 0; // return 0 if not found
		}
	}
public function get_quotation_variation_details($quote_id)
	{
		$this->db->select('
        sqd.id,
        sqd.quote_id,
        sqd.item_category,
        sqd.item_id,
        sqd.quantity,
        sqd.unit_id,
        sqd.actual_price,
        sqd.discount1_percent,
        sqd.discount2_percent,
        sqd.section_title,
        im.item_model,
        im.item_description,
        um.unit_name,
        bm.brand_name,
        IFNULL(SUM(sd.quantity), 0) AS current_stock
    ');
		$this->db->from('sales_quotation_details sqd');
		$this->db->join('item_master im', 'sqd.item_category = 1 AND sqd.item_id = im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'sqd.item_category = 0 AND sqd.item_id = cim.custom_item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand = bm.brand_id', 'left');
		$this->db->join('unit_master um', 'sqd.unit_id = um.unit_id', 'left');
		$this->db->join('stock_details sd', "sqd.item_id = sd.product_id AND sd.status = 0 AND sd.inv_type = 'Actual Stock'", 'left');
		$this->db->where('sqd.quote_id', $quote_id);
		$this->db->group_by('sqd.id');
		$this->db->order_by('sqd.id', 'ASC');

		return $this->db->get()->result();
	}

	/*function get_quotation_by_id($quotation_id)
	{

		$this->db->select('sqm.*,em.* ,enq.enquiry_customer,enq.project_name,
		cm.customer_name,cm.customer_address,cm.customer_code,cc.contact_name,cc.contact_phone,cc.contact_email,u.user_name as quotation_by,u2.user_name as enquiry_by,curr.currency_abbr');
		$this->db->from('sales_quotation_master sqm');
		$this->db->join('estimation_master em', 'sqm.estimation_id=em.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'em.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cm', 'enq.enquiry_customer=cm.customer_id', 'left');
		$this->db->join('customer_contact_details cc', 'em.customer_contact_id=cc.contact_id', 'left');
		$this->db->join('currency_master curr', 'em.currency=curr.currency_id', 'left');
		$this->db->join('users u', 'sqm.created_by=u.user_id', 'left');
		$this->db->join('users u2', 'enq.created_by=u2.user_id', 'left');
		$this->db->where('sqm.quotation_id', $quotation_id);
		$result = $this->db->get()->row_array();

		return $result;
	}*/function get_quotation_by_id($quotation_id)
	{

		$this->db->select('sqm.*,em.* ,enq.enquiry_customer,enq.project_name,
		cm.customer_name,cm.customer_address,cm.customer_code,cc.contact_name,cc.contact_phone,cc.contact_email,u.user_name as quotation_by,u2.user_name as enquiry_by,curr.currency_abbr');
		$this->db->from('sales_quotation_master sqm');
		$this->db->join('estimation_master em', 'sqm.estimation_id=em.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'em.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cm', 'enq.enquiry_customer=cm.customer_id', 'left');
		$this->db->join('customer_contact_details cc', 'em.customer_contact_id=cc.contact_id', 'left');
		$this->db->join('currency_master curr', 'em.currency=curr.currency_id', 'left');
		$this->db->join('users u', 'sqm.created_by=u.user_id', 'left');
		$this->db->join('users u2', 'enq.created_by=u2.user_id', 'left');
		$this->db->where('sqm.quotation_id', $quotation_id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_quotation_details($estimation_id)
	{

		$this->db->select('ed.*,sqm.vat_percent,im.*,um.unit_name,bm.brand_name,IFNULL(sum(sd.quantity),0) AS current_stock,COALESCE(ed.item_id, im.item_id) AS item_id,COALESCE(im.item_description, cim.custom_item_description) AS item_description');
		$this->db->from('estimation_details ed');
		$this->db->join('sales_quotation_master sqm', 'ed.estimation_id=sqm.estimation_id', 'left');
		$this->db->join('item_master im', 'ed.item_category = 1 and ed.item_id=im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id=cim.custom_item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id=um.unit_id', 'left');
		$this->db->join('stock_details sd', "ed.item_id=sd.product_id and sd.status=0 and sd.inv_type='Actual Stock'", 'left');
		$this->db->where('ed.estimation_id', $estimation_id);
		$this->db->group_by('ed.item_id');
		$this->db->order_by('ed.detail_id');
		$result = $this->db->get()->result();

		return $result;
	}

	/*function get_direct_quotation_by_id($quotation_id)
	{
		// 
		$this->db->select('sqm.*,cm.*,
		cm.customer_name,cm.customer_address,cm.customer_code,u.user_name as quotation_by,u.user_name as enquiry_by,curr.currency_abbr');
		$this->db->from('sales_quotation_master sqm');

		$this->db->join('customer_master cm', 'sqm.cust_id=cm.customer_id', 'left');
		// $this->db->join('customer_contact_details cc', 'em.customer_contact_id=cc.contact_id', 'left');
		$this->db->join('currency_master curr', 'sqm.currency=curr.currency_id', 'left');
		$this->db->join('users u', 'sqm.created_by=u.user_id', 'left');
		// $this->db->join('users u2', 'enq.created_by=u2.user_id', 'left');
		$this->db->where('sqm.quotation_id', $quotation_id);
		$result = $this->db->get()->row_array();

		return $result;
	}*/
	function get_direct_quotation_by_id($quotation_id)
	{
		$this->db->select('
        sqm.*,
        cm.customer_name,
        cm.customer_code,
        cm.customer_address,
        cm.customer_emirate,
        cm.customer_country,
        cm.customer_trn,
        cm.payment_terms,
        cm.category,
		cm.contact_number,
		cm.customer_email,		
        curr.currency_abbr,
        u.user_name as quotation_by
    ');
		$this->db->from('sales_quotation_master sqm');
		$this->db->join('customer_master cm', 'sqm.cust_id = cm.customer_id', 'left');
		$this->db->join('currency_master curr', 'sqm.currency = curr.currency_id', 'left');
		$this->db->join('users u', 'sqm.created_by = u.user_id', 'left');
		$this->db->where('sqm.quotation_id', $quotation_id);

		return $this->db->get()->row_array();
	}
	public function update_master_revision($old_qtn, $quotation_id)
	{
		// Determine which record to update
		$master_id_to_update = ($old_qtn['quotation_revision'] < 1)
			? $quotation_id
			: $old_qtn['variation_quotation_master_id'];

		// Prepare update data
		$this->db->set('variation_status', 1);
		$this->db->set('last_updated_on', date('Y-m-d H:i:s'));
		$this->db->set('max_revision', 'max_revision + 1', FALSE);
		$this->db->where('quotation_id', $master_id_to_update);
		$this->db->update('sales_quotation_master');
	}

	function get_direct_quotation_details($quote_id)
	{

		$this->db->select('sqd.*,im.*,um.unit_name,bm.*,cim.*,IFNULL(sum(sqd.quantity),0) AS current_stock,COALESCE(sqd.item_id, im.item_id) AS item_id,COALESCE(im.item_description, cim.custom_item_description) AS item_description');
		$this->db->from('sales_quotation_details sqd');
		$this->db->join('sales_quotation_master sqm', 'sqd.quote_id=sqm.quotation_id', 'left');
		$this->db->join('item_master im', 'sqd.item_category = 1 and sqd.item_id=im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'sqd.item_category = 0 and sqd.item_id=cim.custom_item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
		$this->db->join('unit_master um', 'sqd.unit_id=um.unit_id', 'left');
		$this->db->join('stock_details sd', "sqd.item_id=sd.product_id and sd.status=0 and sd.inv_type='Actual Stock'", 'left');
		$this->db->where('sqd.quote_id', $quote_id);
		$this->db->group_by('sqd.item_id');
		$this->db->order_by('sqd.quote_id');
		$result = $this->db->get()->result();

		return $result;
	}

	function get_quotation_details_sectioned($estimation_id)
	{
		$this->db->select('ed.*,im.*,um.unit_name,bm.brand_name,IFNULL(sum(sd.quantity),0) AS current_stock,,COALESCE(ed.item_id, im.item_id) AS item_id,COALESCE(im.item_description, cim.custom_item_description) AS item_description');
		$this->db->from('estimation_details ed');
		$this->db->join('item_master im', 'ed.item_category = 1 and ed.item_id=im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id=cim.custom_item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id=um.unit_id', 'left');
		$this->db->join('stock_details sd', "ed.item_id=sd.product_id and sd.status=0 and sd.inv_type='Actual Stock'", 'left');
		$this->db->where('ed.estimation_id', $estimation_id);
		$this->db->group_by('ed.item_id');
		$this->db->order_by('ed.section_title', 'ASC');
		$result = $this->db->get()->result();

		// Group the results manually
		$grouped = [];
		foreach ($result as $row) {
			$grouped[$row->section_title][] = $row;
		}

		return $grouped;
	}

	function update_quotation_data()
	{
		$quotation_id = $_POST['quotation_id'];
		$estimation_id = $_POST['estimation_id'];

		$data = array(
			'quotation_date' => $_POST['quotation_date'],
			'validity' => $_POST['quotation_validity'],
			'print_coo' => $_POST['print_coo'] ?? 0,
			'print_hsc' => $_POST['print_hsc'] ?? 0,
			'print_stock' => $_POST['print_stock'] ?? 0,
			'print_sections' => $_POST['print_sections'] ?? 0,
			'last_updated_by' => $this->session->userdata('user_id'),
		);
		$this->db->where('quotation_id', $quotation_id);
		$res = $this->db->update('sales_quotation_master', $data);

		$data = array(
			'customer_contact_id' => $_POST['customer_contact'],
			'notes' => $_POST['notes'],
			'payment' => $_POST['payment'],
			'delivery' => $_POST['delivery'],
			'availability' => $_POST['availability'],
			'warranty' => $_POST['warranty'],
			'conditions' => $_POST['conditions'],
		);
		$this->db->where('estimation_id', $_POST['estimation_id']);
		$res = $this->db->update('estimation_master', $data);

		//notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_quotations');
		$qtn_code = $_POST['quotation_code'];
		foreach ($notify_users as $r) {
			$notice = add_notification($quotation_id, $r, "Quotation updated {$qtn_code}", "sales/edit_quotation/{$quotation_id}/0/1", $this->session->userdata('user_id'));
		}
		return $res;
	}

	function revise_quotation_data()
	{

		//revise the quotation if generated

		$estimation_id = $_POST['estimation_id'];
		$current_quotation_revision = $_POST['quotation_revision'];
		$res = 0;

		$data = array(
			'quotation_code' => $_POST['quotation_code'],
			'estimation_id' => $estimation_id,
			'estimation_code' => $_POST['estimation_code'],
			'quotation_revision' => $current_quotation_revision + 1,
			'additional_discount' => $_POST['total_discount2'],
			'vat_percent' => $_POST['vat_percent'],
			'grand_total' => $_POST['grand_total'],
			'validity' => date('Y-m-d', strtotime(date('Y-m-d') . ' +15 days')),
		);
		$res = $this->db->insert('sales_quotation_master', $data);

		//notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_quotations');
		$qtn_code = $quotation_code . '-Rev' . $quotation_revision;
		foreach ($notify_users as $r) {
			$notice = add_notification($quotation_id, $r, "Quotation Created {$qtn_code}", "sales/edit_quotation/{$quotation_id}/0/1", $this->session->userdata('user_id'));
		}

		return $res;
	}

	function approve_quotation_data()
	{
		$quotation_id = $_POST['quotation_id'];
		$quotation_code = $_POST['quotation_code'];
		//setting all other quotation revisions not approvable
		$this->db->set('quotation_approval', '-1')->where('quotation_code', $quotation_code)->where('quotation_id !=', $quotation_id)->update('sales_quotation_master');

		$data = array(
			'quotation_approval' => 1,
			'lpo_date' => $_POST['lpo_date'],
			'lpo_number' => $_POST['lpo_number'],
			'lpo_total' => $_POST['lpo_total'],
			'approval_remarks' => $_POST['approval_remarks'],
			'approved_by' => $_POST['approved_by'],
		);
		$this->db->where('quotation_id', $quotation_id);
		$res = $this->db->update('sales_quotation_master', $data);

		//notification
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_quotations');
		$qtn_code = $_POST['qtn_ref'];
		foreach ($notify_users as $r) {
			$notice = add_notification($quotation_id, $r, "Quotation Approved {$qtn_code}", "sales/edit_quotation/{$quotation_id}/0/1", $this->session->userdata('user_id'));
		}
		return $res;
	}

	function get_approved_quotation_list()
	{
		$this->db->select('qtn.*');
		$this->db->from('sales_quotation_master qtn');
		$this->db->where('quotation_approval', 1);
		$this->db->order_by('qtn.quotation_code', 'DESC');
		$res = $this->db->get()->result();

		return $res;
	}

	//function to check if any of the revisions of a quotation is approved
	function get_quotation_approval_status($estimation_code)
	{
		$this->db->where('estimation_code', $estimation_code);
		$this->db->where('quotation_approval', 1);
		$approval = $this->db->get('sales_quotation_master')->num_rows();

		return $approval;
	}

	function get_quotation_details_for_sales_order($estimation_id)
	{

		// pi Quantity Subquery
		$this->db->select('pd.quotation_detail_id');
		$this->db->select('SUM(CASE WHEN pm.status != -1 AND pd.detail_status != -1 THEN pd.pi_quantity ELSE 0 END) AS pending_quantity');
		$this->db->from('pi_details pd');
		$this->db->join('pi_master pm', 'pd.pi_master_id = pm.pi_id', 'left');
		$this->db->group_by('pd.quotation_detail_id');
		$pi_subquery = $this->db->get_compiled_select();

		// Stock Quantity Subquery
		$this->db->select('product_id');
		$this->db->select('SUM(quantity) AS current_stock');
		$this->db->from('stock_details');
		$this->db->where('status', '0');
		$this->db->where('inv_type', 'Actual Stock');
		$this->db->group_by('product_id');
		$stock_subquery = $this->db->get_compiled_select();

		// Main Query
		$this->db->select('ed.*');
		$this->db->select('COALESCE(ed.item_id, i.item_id) AS item_id,COALESCE(i.item_description, cim.custom_item_description) AS item_description');
		$this->db->select('um.unit_name');
		$this->db->select('(ed.quantity - IFNULL(pd.pending_quantity, 0)) AS pending_quantity');
		$this->db->select('IFNULL(stk.current_stock,0) AS current_stock');

		$this->db->from('estimation_details ed');
		$this->db->join("($pi_subquery) pd", 'ed.detail_id = pd.quotation_detail_id', 'left');
		$this->db->join('item_master i', 'ed.item_category=1 and ed.item_id = i.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id=cim.custom_item_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id = um.unit_id', 'left');
		$this->db->join("($stock_subquery) stk", 'ed.item_id = stk.product_id', 'left');
		$this->db->where('ed.estimation_id', $estimation_id);
		$this->db->group_by('ed.detail_id');

		$result = $this->db->get()->result();

		return $result;
	}


	function cancel_quotation_by_id($quotation_id)
	{
		$this->db->set('quotation_status', -1);
		$this->db->where('quotation_id', $quotation_id);
		$res = $this->db->update('sales_quotation_master');

		return $res;
	}

	function get_quotation_count($firstDay, $lastDay)
	{
		$res = $this->db->select('count(*) as quotation_count')->where("created_at BETWEEN '$firstDay' AND '$lastDay'")->get('sales_quotation_master')->row('quotation_count');
		return $res;
	}

	function get_quotations_by_customer($customer_id)
	{
		$this->db->select('sqm.*');
		$this->db->from('sales_quotation_master sqm');
		$this->db->join('estimation_master est', 'sqm.estimation_id = est.estimation_id');
		$this->db->join('enquiry_master em', 'est.enquiry_id = em.enquiry_id');
		$this->db->where('sqm.quotation_approval', 1);
		$this->db->where('em.enquiry_customer', $customer_id);
		$res = $this->db->get()->result();

		return $res;
	}

	//sales order

	function add_sales_order_data()
	{

		$quotation_id = $_POST['quotation_id'];
		$prefix = 'AVPI#';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prefix, 'pi_code', 'pi_master', 6) + 1;
		$digit = sprintf("%1$05d", $num);
		$pi_code = $prefix . $digit . '_' . date('y');
		$data = array(
			'pi_code' => $pi_code,
			'pi_date' => date('Y-m-d'),
			'quotation_id' => $quotation_id,
			'vat_percent' => $_POST['vat_percent'],
			'total_before_vat' => $_POST['subtotal'] - $_POST['total_discount2'],
			'grand_total' => $_POST['grand_total'],
			'supplier_ref' => $_POST['supplier_ref'],
			'other_ref' => $_POST['other_ref'],
			'dispatch_document_number' => $_POST['dispatch_document_number'],
			'payment_terms' => $_POST['payment_terms'],
			'dispatch_through' => $_POST['dispatch_through'],
			'destination' => $_POST['destination'],
			'delivery_terms' => $_POST['delivery_terms'],
			'created_by' => $this->session->userdata('user_id'),
			'last_updated_by' => $this->session->userdata('user_id'),
		);
		$this->db->insert('pi_master', $data);
		$pi_id = $this->db->insert_id();

		//allocation master entry
		$prefix = 'ALLOC/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prefix, 'allocation_code', 'stock_allocation_master', 7) + 1;
		$digit = sprintf("%1$05d", $num);
		$allocation_code = $prefix . $digit;
		$data = array(
			'allocation_code' => $allocation_code,
			'allocation_date' => date('Y-m-d'),
			'pi_master_id' => $pi_id
		);
		$this->db->insert('stock_allocation_master', $data);
		$allocation_master_id = $this->db->insert_id();

		for ($i = 0; $i < $_POST['row_count']; $i++) {

			if ($_POST['quantity'][$i] > 0) {

				$data = array(
					'pi_master_id' => $pi_id,
					'quotation_detail_id' => $_POST['detail_id'][$i],
					'pi_quantity' => $_POST['quantity'][$i],
				);
				$this->db->insert('pi_details', $data);
				$pi_detail_id = $this->db->insert_id();
				//$pi_detail_id = 1;
				if ($_POST['item_category'][$i] > 0) {
					//allocation from stock
					$allocated_quantity = 0;
					$data = array(
						'allocation_master_id' => $allocation_master_id,
						'pi_detail_id' => $pi_detail_id,
						'allocated_quantity' => $allocated_quantity
					);
					$this->db->insert('stock_allocation_details', $data);
					$allocation_detail_id = $this->db->insert_id();
					if ($_POST['quantity'][$i] > 0) {
						$this->db->select('sd.*,wm.warehouse_priority');
						$this->db->from('stock_details sd');
						$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
						$this->db->where('sd.product_id', $_POST['item_id'][$i]);
						$this->db->where('sd.inv_type', 'Actual Stock');
						$this->db->where('sd.status', 0);
						$this->db->group_start()
							->where('sd.project', 0)
							->or_where('sd.project', $quotation_id)
							->group_end();
						$this->db->order_by('wm.warehouse_priority');
						$this->db->order_by('sd.project', 'DESC');
						$this->db->order_by('stock_date');

						$res = $this->db->get()->result_array();

						if (!empty($res)) {
							$order_quantity = $_POST['quantity'][$i];
							foreach ($res as $row) {

								if ($order_quantity > 0) {
									if ($order_quantity >= $row['quantity']) {
										$order_quantity = $order_quantity - $row['quantity'];
										//update status
										$data = array(
											'status' => 1,
											'allocation_id' => $allocation_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);
										$allocated_quantity += $row['quantity'];

										//insert stock out
										// $stock_out = $row;
										// unset($stock_out['stock_id']);
										// $stock_out['stock_type'] = 'OUT';
										// $stock_out['stock_date'] = date('Y-m-d');
										// $stock_out['status'] = 2;
										// $stock_out['allocation_id'] = $allocation_detail_id;
										// $this->db->insert('stock_details',$stock_out);

									} else if ($row['quantity'] > $order_quantity) {
										$remaining = $row['quantity'] - $order_quantity;

										//update stock status
										$data = array(
											'quantity' => $order_quantity,
											'status' => 1,
											'allocation_id' => $allocation_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);
										$allocated_quantity += $order_quantity;


										//insert remaing stock
										$remaining_stock = $row;
										unset($remaining_stock['stock_id']);
										unset($remaining_stock['warehouse_priority']);
										$remaining_stock['quantity'] = $remaining;
										$this->db->insert('stock_details', $remaining_stock);



										//insert stock out
										// $stock_out = $row;
										// unset($stock_out['stock_id']);
										// $stock_out['stock_type'] = 'OUT';
										// $stock_out['stock_date'] = date('Y-m-d');
										// $stock_out['quantity'] = $order_quantity;
										// $stock_out['status'] = 2;
										// $stock_out['allocation_id'] = $allocation_detail_id;
										// $this->db->insert('stock_details',$stock_out);

										$order_quantity = 0;
									}
								}
							}
						}
					}
					$this->db->set('allocated_quantity', $allocated_quantity)->where('allocation_detail_id', $allocation_detail_id)->update('stock_allocation_details');
				} else {
					$this->load->model('Item_model');

					$components = $this->Item_model->get_custom_item_components($_POST['item_id'][$i]);
					foreach ($components as $comp) {
						//allocation from stock
						$allocated_quantity = 0;
						$data = array(
							'allocation_master_id' => $allocation_master_id,
							'pi_detail_id' => $pi_detail_id,
							'allocated_quantity' => $allocated_quantity
						);
						$this->db->insert('stock_allocation_details', $data);
						$allocation_detail_id = $this->db->insert_id();
						if ($_POST['quantity'][$i] * $comp['component_quantity'] > 0) {
							$this->db->select('sd.*,wm.warehouse_priority');
							$this->db->from('stock_details sd');
							$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
							$this->db->where('sd.product_id', $comp['component_item_id']);
							$this->db->where('sd.inv_type', 'Actual Stock');
							$this->db->where('sd.status', 0);
							$this->db->group_start()
								->where('sd.project', 0)
								->or_where('sd.project', $quotation_id)
								->group_end();
							$this->db->order_by('wm.warehouse_priority');
							$this->db->order_by('sd.project', 'DESC');
							$this->db->order_by('stock_date');

							$res = $this->db->get()->result_array();

							if (!empty($res)) {
								$order_quantity = $_POST['quantity'][$i] * $comp['component_quantity'];
								foreach ($res as $row) {

									if ($order_quantity > 0) {
										if ($order_quantity >= $row['quantity']) {
											$order_quantity = $order_quantity - $row['quantity'];
											//update status
											$data = array(
												'status' => 1,
												'allocation_id' => $allocation_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$allocated_quantity += $row['quantity'];
										} else if ($row['quantity'] > $order_quantity) {
											$remaining = $row['quantity'] - $order_quantity;

											//update stock status
											$data = array(
												'quantity' => $order_quantity,
												'status' => 1,
												'allocation_id' => $allocation_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$allocated_quantity += $order_quantity;


											//insert remaing stock
											$remaining_stock = $row;
											unset($remaining_stock['stock_id']);
											unset($remaining_stock['warehouse_priority']);
											$remaining_stock['quantity'] = $remaining;
											$this->db->insert('stock_details', $remaining_stock);


											$order_quantity = 0;
										}
									}
								}
							}
						}
						$this->db->set('allocated_quantity', $allocated_quantity)->where('allocation_detail_id', $allocation_detail_id)->update('stock_allocation_details');
					}
				}
			}
		}
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_sales_orders');
		foreach ($notify_users as $r) {
			$notice = add_notification($pi_id, $r, "Sales order created {$pi_code}", "sales/edit_sales_order/{$pi_id}/0/1", $this->session->userdata('user_id'));
		}
	}

	function update_sales_order_data2()
	{
		$res = 0;
		$allocation_master_id = $_POST['allocation_id'];
		$quotation_id = $_POST['quotation_id'];


		//free allocated stock
		$stock_deallocation = array('status' => 0, 'allocation_id' => 0);
		for ($i = 0; $i < $_POST['row_count']; $i++) {

			$allocation_detail_id = $_POST['allocation_detail_id'][$i];

			$this->db->where('allocation_id', $allocation_detail_id);
			$this->db->update('stock_details', $stock_deallocation);

			if ($_POST['quantity'][$i] > 0) {

				$allocated_quantity = 0;
				$data = array(
					'pi_quantity' => $_POST['quantity'][$i],
				);
				$this->db->where('pi_detail_id', $_POST['pi_detail_id'][$i]);
				$res = $this->db->update('pi_details', $data);

				$this->db->select('sd.*,wm.warehouse_priority');
				$this->db->from('stock_details sd');
				$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
				$this->db->where('sd.product_id', $_POST['item_id'][$i]);
				$this->db->where('sd.inv_type', 'Actual Stock');
				$this->db->where('sd.status', 0);
				$this->db->group_start()
					->where('sd.project', 0)
					->or_where('sd.project', $quotation_id)
					->group_end();
				$this->db->order_by('wm.warehouse_priority');
				$this->db->order_by('sd.project', 'DESC');
				$this->db->order_by('stock_date');
				$res = $this->db->get()->result_array();

				if (!empty($res)) {
					$order_quantity = $_POST['quantity'][$i];
					foreach ($res as $row) {
						if ($order_quantity > 0) {
							if ($order_quantity >= $row['quantity']) {
								$order_quantity = $order_quantity - $row['quantity'];
								//update status
								$data = array(
									'status' => 1,
									'allocation_id' => $allocation_detail_id,
								);
								$this->db->where('stock_id', $row['stock_id']);
								$this->db->update('stock_details', $data);
								$allocated_quantity += $row['quantity'];
							} else if ($row['quantity'] > $order_quantity) {
								$remaining = $row['quantity'] - $order_quantity;

								//update stock status
								$data = array(
									'quantity' => $order_quantity,
									'status' => 1,
									'allocation_id' => $allocation_detail_id,
								);
								$this->db->where('stock_id', $row['stock_id']);
								$this->db->update('stock_details', $data);
								$allocated_quantity += $order_quantity;


								//insert remaing stock
								$remaining_stock = $row;
								unset($remaining_stock['stock_id']);
								unset($remaining_stock['warehouse_priority']);
								$remaining_stock['quantity'] = $remaining;
								$this->db->insert('stock_details', $remaining_stock);

								$order_quantity = 0;
							}
						}
					}
				}
				$this->db->set('allocated_quantity', $allocated_quantity)->where('allocation_detail_id', $allocation_detail_id)->update('stock_allocation_details');
			} else {
				//delete pi_detail and stock_allocation detail
				$res = $this->db->where('allocation_detail_id', $allocation_detail_id)->delete('stock_allocation_details');
				$res = $this->db->where('pi_detail_id', $_POST['pi_detail_id'][$i])->delete('pi_details');
			}
		}

		$data = array(
			'total_before_vat' => $_POST['subtotal'] - $_POST['total_discount2'],
			'grand_total' => $_POST['grand_total'],
			'supplier_ref' => $_POST['supplier_ref'],
			'other_ref' => $_POST['other_ref'],
			'dispatch_document_number' => $_POST['dispatch_document_number'],
			'payment_terms' => $_POST['payment_terms'],
			'dispatch_through' => $_POST['dispatch_through'],
			'destination' => $_POST['destination'],
			'delivery_terms' => $_POST['delivery_terms'],
			'last_updated_by' => $this->session->userdata('user_id'),
		);
		$this->db->where('pi_id', $_POST['pi_id']);
		$res = $this->db->update('pi_master', $data);



		return $res;
	}

	function update_sales_order_data()
	{
		$res = 0;
		$allocation_master_id = $_POST['allocation_id'];
		$quotation_id = $_POST['quotation_id'];



		for ($i = 0; $i < $_POST['row_count']; $i++) {
			if ($_POST['item_category'][$i] > 0) {
				//free allocated stock
				$stock_deallocation = array('status' => 0, 'allocation_id' => 0);
				$allocation_detail_id = $_POST['allocation_detail_id'][$i];

				$this->db->where('allocation_id', $allocation_detail_id);
				$this->db->update('stock_details', $stock_deallocation);

				if ($_POST['quantity'][$i] > 0) {

					$allocated_quantity = 0;
					$data = array(
						'pi_quantity' => $_POST['quantity'][$i],
					);
					$this->db->where('pi_detail_id', $_POST['pi_detail_id'][$i]);
					$res = $this->db->update('pi_details', $data);

					$this->db->select('sd.*,wm.warehouse_priority');
					$this->db->from('stock_details sd');
					$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
					$this->db->where('sd.product_id', $_POST['item_id'][$i]);
					$this->db->where('sd.inv_type', 'Actual Stock');
					$this->db->where('sd.status', 0);
					$this->db->group_start()
						->where('sd.project', 0)
						->or_where('sd.project', $quotation_id)
						->group_end();
					$this->db->order_by('wm.warehouse_priority');
					$this->db->order_by('sd.project', 'DESC');
					$this->db->order_by('stock_date');
					$res = $this->db->get()->result_array();

					if (!empty($res)) {
						$order_quantity = $_POST['quantity'][$i];
						foreach ($res as $row) {
							if ($order_quantity > 0) {
								if ($order_quantity >= $row['quantity']) {
									$order_quantity = $order_quantity - $row['quantity'];
									//update status
									$data = array(
										'status' => 1,
										'allocation_id' => $allocation_detail_id,
									);
									$this->db->where('stock_id', $row['stock_id']);
									$this->db->update('stock_details', $data);
									$allocated_quantity += $row['quantity'];
								} else if ($row['quantity'] > $order_quantity) {
									$remaining = $row['quantity'] - $order_quantity;

									//update stock status
									$data = array(
										'quantity' => $order_quantity,
										'status' => 1,
										'allocation_id' => $allocation_detail_id,
									);
									$this->db->where('stock_id', $row['stock_id']);
									$this->db->update('stock_details', $data);
									$allocated_quantity += $order_quantity;


									//insert remaing stock
									$remaining_stock = $row;
									unset($remaining_stock['stock_id']);
									unset($remaining_stock['warehouse_priority']);
									$remaining_stock['quantity'] = $remaining;
									$this->db->insert('stock_details', $remaining_stock);

									$order_quantity = 0;
								}
							}
						}
					}
					$this->db->set('allocated_quantity', $allocated_quantity)->where('allocation_detail_id', $allocation_detail_id)->update('stock_allocation_details');
				} else {
					//delete pi_detail and stock_allocation detail
					$res = $this->db->where('allocation_detail_id', $allocation_detail_id)->delete('stock_allocation_details');
					$res = $this->db->where('pi_detail_id', $_POST['pi_detail_id'][$i])->delete('pi_details');
				}
			} else {
				//free allocated stock
				$this->db->select('allocation_detail_id');
				$this->db->where('pi_detail_id', $_POST['pi_detail_id'][$i]);
				$res = $this->db->get('stock_allocation_details')->result_array();
				$allocation_ids = array_column($res, 'allocation_detail_id');

				$stock_deallocation = array('status' => 0, 'allocation_id' => 0);
				$this->db->where_in('allocation_id', $allocation_ids);
				$this->db->update('stock_details', $stock_deallocation);

				$res = $this->db->where_in('allocation_detail_id', $allocation_ids)->delete('stock_allocation_details');

				if ($_POST['quantity'][$i] > 0) {
					$pi_detail_id = $_POST['pi_detail_id'][$i];
					$allocated_quantity = 0;
					$data = array(
						'pi_quantity' => $_POST['quantity'][$i],
					);
					$this->db->where('pi_detail_id', $_POST['pi_detail_id'][$i]);
					$res = $this->db->update('pi_details', $data);

					$this->load->model('Item_model');
					$components = $this->Item_model->get_custom_item_components($_POST['item_id'][$i]);
					foreach ($components as $comp) {

						//allocation from stock
						$allocated_quantity = 0;
						$data = array(
							'allocation_master_id' => $allocation_master_id,
							'pi_detail_id' => $pi_detail_id,
							'allocated_quantity' => $allocated_quantity
						);
						$this->db->insert('stock_allocation_details', $data);
						$allocation_detail_id = $this->db->insert_id();

						if ($_POST['quantity'][$i] * $comp['component_quantity'] > 0) {
							$this->db->select('sd.*,wm.warehouse_priority');
							$this->db->from('stock_details sd');
							$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
							$this->db->where('sd.product_id', $comp['component_item_id']);
							$this->db->where('sd.inv_type', 'Actual Stock');
							$this->db->where('sd.status', 0);
							$this->db->group_start()
								->where('sd.project', 0)
								->or_where('sd.project', $quotation_id)
								->group_end();
							$this->db->order_by('wm.warehouse_priority');
							$this->db->order_by('sd.project', 'DESC');
							$this->db->order_by('stock_date');

							$res = $this->db->get()->result_array();

							if (!empty($res)) {
								$order_quantity = $_POST['quantity'][$i] * $comp['component_quantity'];
								foreach ($res as $row) {

									if ($order_quantity > 0) {
										if ($order_quantity >= $row['quantity']) {
											$order_quantity = $order_quantity - $row['quantity'];
											//update status
											$data = array(
												'status' => 1,
												'allocation_id' => $allocation_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$allocated_quantity += $row['quantity'];
										} else if ($row['quantity'] > $order_quantity) {
											$remaining = $row['quantity'] - $order_quantity;

											//update stock status
											$data = array(
												'quantity' => $order_quantity,
												'status' => 1,
												'allocation_id' => $allocation_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$allocated_quantity += $order_quantity;


											//insert remaing stock
											$remaining_stock = $row;
											unset($remaining_stock['stock_id']);
											unset($remaining_stock['warehouse_priority']);
											$remaining_stock['quantity'] = $remaining;
											$this->db->insert('stock_details', $remaining_stock);


											$order_quantity = 0;
										}
									}
								}
							}
						}
						$this->db->set('allocated_quantity', $allocated_quantity)->where('allocation_detail_id', $allocation_detail_id)->update('stock_allocation_details');
					}
				} else {
					//delete pi_detail and stock_allocation detail
					//$res = $this->db->where_in('allocation_detail_id',$allocation_ids)->delete('stock_allocation_details');
					$res = $this->db->where('pi_detail_id', $_POST['pi_detail_id'][$i])->delete('pi_details');
				}
			}
		}
		if ($res) {
			$data = array(
				'total_before_vat' => $_POST['subtotal'] - $_POST['total_discount2'],
				'grand_total' => $_POST['grand_total'],
				'supplier_ref' => $_POST['supplier_ref'],
				'other_ref' => $_POST['other_ref'],
				'dispatch_document_number' => $_POST['dispatch_document_number'],
				'payment_terms' => $_POST['payment_terms'],
				'dispatch_through' => $_POST['dispatch_through'],
				'destination' => $_POST['destination'],
				'delivery_terms' => $_POST['delivery_terms'],
				'last_updated_by' => $this->session->userdata('user_id'),
			);
			$this->db->where('pi_id', $_POST['pi_id']);
			$res = $this->db->update('pi_master', $data);
		}

		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_sales_orders');
		$pi_id = $_POST['pi_id'];
		$pi_code = $_POST['pi_code'];
		foreach ($notify_users as $r) {
			$notice = add_notification($pi_id, $r, "Sales order updated {$pi_code}", "sales/edit_sales_order/{$pi_id}/0/1", $this->session->userdata('user_id'));
		}
		return $res;
	}

	function get_sales_orders_list($status = '')
	{
		$this->db->select('pi.*,sqm.quotation_code,sqm.quotation_revision,cust.customer_name');
		$this->db->from('pi_master pi');
		$this->db->join('sales_quotation_master sqm', 'pi.quotation_id=sqm.quotation_id');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id');
		if ($status != '')
			$this->db->where('pi.status', $status);
		$this->db->order_by('pi.pi_code', 'DESC');
		$res = $this->db->get()->result_array();

		return $res;
	}

	function get_active_sales_orders_list()
	{
		$this->db->select('pi.*,sqm.quotation_code,sqm.quotation_revision,cust.customer_name');
		$this->db->from('pi_master pi');
		$this->db->join('sales_quotation_master sqm', 'pi.quotation_id=sqm.quotation_id');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id');
		$this->db->where('status >=', 0);
		$this->db->order_by('pi.pi_code', 'DESC');
		$res = $this->db->get()->result_array();

		return $res;
	}

	function get_sales_order_by_id($pi_id)
	{
		$this->db->select('pi.*,cust.*,sam.allocation_id, curr.currency_abbr,curr.abbr2');
		$this->db->from('pi_master pi');
		$this->db->join('stock_allocation_master sam', 'pi.pi_id=sam.pi_master_id', 'left');
		$this->db->join('sales_quotation_master sqm', 'pi.quotation_id=sqm.quotation_id', 'left');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id', 'left');
		$this->db->join('currency_master curr', 'est.currency=curr.currency_id', 'left');
		$this->db->where('pi_id', $pi_id);

		$res = $this->db->get()->row_array();
		return $res;
	}

	function get_pi_details($pi_id)
	{

		$this->db->select('pd.*,sad.*,ed.*,um.unit_name,coalesce(sum(invoice_quantity),0) as invoiced_qty,
		(ed.quantity - (SELECT COALESCE(SUM(pd2.pi_quantity), 0) FROM pi_details pd2 WHERE pd2.quotation_detail_id = pd.quotation_detail_id AND pd2.detail_status >= 0)) AS pending_pi_qty');
		$this->db->select('COALESCE(im.item_model,cim.custom_item_name) AS item_model,COALESCE(im.item_description,cim.custom_item_description) AS item_description');
		$this->db->from('pi_details pd');
		$this->db->join('invoice_details id', 'pd.pi_detail_id=id.pi_detail_id', 'left');
		$this->db->join('stock_allocation_details sad', 'sad.pi_detail_id=pd.pi_detail_id', 'left');
		$this->db->join('estimation_details ed', 'pd.quotation_detail_id=ed.detail_id', 'left');
		$this->db->join('item_master im', 'ed.item_category = 1 and ed.item_id=im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id = cim.custom_item_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id=um.unit_id', 'left');
		$this->db->where('pd.detail_status >=', 0);
		$this->db->where('pd.pi_master_id', $pi_id);
		$this->db->group_by('pd.pi_detail_id');
		$res = $this->db->get()->result();

		return $res;
	}

	function get_pi_details_for_invoice($pi_id, $quotation_id)
	{


		// Invoice Quantity Subquery
		$this->db->select('id.pi_detail_id');
		$this->db->select('SUM(CASE WHEN im.invoice_status != -1 AND id.invoice_detail_status != -1 THEN id.invoice_quantity ELSE 0 END) AS invoiced_qty');
		$this->db->from('invoice_details id');
		$this->db->join('invoice_master im', 'id.invoice_master_id = im.invoice_id', 'left');
		$this->db->group_by('id.pi_detail_id');
		$invoice_subquery = $this->db->get_compiled_select();

		//issued sample quantity
		$this->db->select('sum(sd.quantity) as sampled_qty,sqm.quotation_id,sd.stock_type,sd.stock_id,sd.quantity,sd.status,srd.quotation_detail_id,srd.item_id');
		$this->db->from('stock_details sd');
		$this->db->join('sample_request_details srd', 'sd.request_id = srd.request_detail_id');
		$this->db->join('sample_request_master srm', 'srd.request_master_id = srm.request_id', 'left');
		$this->db->join('sales_quotation_master sqm', 'srm.quotation_id = sqm.quotation_id', 'left');
		$this->db->where('srm.quotation_id', $quotation_id);
		$this->db->where('sd.status', 3);
		$sample_qty_subquery = $this->db->get_compiled_select();

		// Stock Quantity Subquery
		// $this->db->select('sd.product_id');
		// $this->db->select('SUM(quantity) AS current_stock');
		// $this->db->from('stock_details sd');
		// $this->db->join('stock_allocation_details sad','sd.allocation_id = sad.allocation_detail_id','left');
		// $this->db->join('pi_details pd','sad.pi_detail_id = pd.pi_detail_id','left');
		// $this->db->where('sd.stock_type', 'IN');
		// $this->db->where('sd.inv_type', 'Actual Stock');
		// $this->db->group_start()
		// 	->group_start()
		// 		->where('sd.status', '0')
		// 		->group_start()
		// 			->where('sd.project', 0)
		// 			->or_where('sd.project', $quotation_id)
		// 		->group_end()
		// 	->group_end()
		// 	->or_group_start()
		// 		->where('sd.status', '1')
		// 		->where('pd.pi_master_id', $pi_id)
		// 	->group_end()
		// ->group_end();
		// $this->db->group_by('sd.product_id');
		// $stock_subquery = $this->db->get_compiled_select();

		// Main Query
		$this->db->select('pd.*');
		$this->db->select('ed.*');
		$this->db->select('COALESCE(i.item_model,cim.custom_item_name) AS item_model,COALESCE(i.item_description,cim.custom_item_description) AS item_description');
		$this->db->select('um.unit_name, sad.allocated_quantity');
		$this->db->select('(pd.pi_quantity - IFNULL(inv.invoiced_qty, 0)) AS pending_quantity');
		//$this->db->select('IFNULL(stk.current_stock,0) AS current_stock');
		$this->db->select('IFNULL(SUM(sd.quantity),0) AS allocated_stock');
		$this->db->select('IFNULL(sample.sampled_qty,0) AS sample_qty');
		$this->db->from('pi_details pd');
		$this->db->join('stock_allocation_details sad', 'pd.pi_detail_id = sad.pi_detail_id', 'left');
		$this->db->join('estimation_details ed', 'pd.quotation_detail_id = ed.detail_id', 'left');
		$this->db->join('item_master i', 'ed.item_category = 1 and ed.item_id = i.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id = cim.custom_item_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id = um.unit_id', 'left');
		$this->db->join('stock_details sd', 'pd.pi_detail_id = sd.allocation_id', 'left');
		$this->db->join("($invoice_subquery) inv", 'pd.pi_detail_id = inv.pi_detail_id', 'left');
		//$this->db->join("($stock_subquery) stk", 'ed.item_id = stk.product_id', 'left');
		$this->db->join("($sample_qty_subquery) sample", 'pd.quotation_detail_id = sample.quotation_detail_id', 'left');
		$this->db->where('pd.detail_status >=', 0);
		$this->db->where('pd.pi_master_id', $pi_id);
		$this->db->group_by('pd.pi_detail_id');
		$res = $this->db->get()->result();
		foreach ($res as $item) {
			if ($item->item_category > 0) {
				$this->db->select('SUM(quantity) AS current_stock');
				$this->db->from('stock_details sd');
				$this->db->join('stock_allocation_details sad', 'sd.allocation_id = sad.allocation_detail_id', 'left');
				$this->db->join('pi_details pd', 'sad.pi_detail_id = pd.pi_detail_id', 'left');
				$this->db->where('sd.stock_type', 'IN');
				$this->db->where('sd.inv_type', 'Actual Stock');
				$this->db->group_start()
					->group_start()
					->where('sd.status', '0')
					->group_start()
					->where('sd.project', 0)
					->or_where('sd.project', $quotation_id)
					->group_end()
					->group_end()
					->or_group_start()
					->where('sd.status', '1')
					->where('pd.pi_master_id', $pi_id)
					->group_end()
					->group_end();
				$this->db->where('sd.product_id', $item->item_id);
				$stock = $this->db->get()->row('current_stock');
				$item->current_stock = $stock;
			} else {
				$this->load->model('Item_model');
				$components = $this->Item_model->get_custom_item_components($item->item_id);

				$component_stock = [];
				foreach ($components as $c) {
					$this->db->select('SUM(quantity) AS current_stock');
					$this->db->from('stock_details sd');
					$this->db->join('stock_allocation_details sad', 'sd.allocation_id = sad.allocation_detail_id', 'left');
					$this->db->join('pi_details pd', 'sad.pi_detail_id = pd.pi_detail_id', 'left');
					$this->db->where('sd.stock_type', 'IN');
					$this->db->where('sd.inv_type', 'Actual Stock');
					$this->db->group_start()
						->group_start()
						->where('sd.status', '0')
						->group_start()
						->where('sd.project', 0)
						->or_where('sd.project', $quotation_id)
						->group_end()
						->group_end()
						->or_group_start()
						->where('sd.status', '1')
						->where('pd.pi_master_id', $pi_id)
						->group_end()
						->group_end();
					$this->db->where('sd.product_id', $c['component_item_id']);
					$comp_stock = $this->db->get()->row()->current_stock ?? 0;

					$component_stock[] = floor($comp_stock / $c['component_quantity']);
				}


				$item->current_stock = !empty($component_stock) ? min($component_stock) : 0;
			}
		}
		return $res;
	}



	function get_sales_order_status_for_quotation($quotation_id)
	{
		$this->db->select('*');
		$this->db->from('pi_master');
		$this->db->where('status >=', 0);
		$this->db->where('quotation_id', $quotation_id);
		$result = $this->db->get()->result_array();
		if (empty($result)) {
			return ['status' => '0', 'message' => ''];
		} else {
			$invoice_generated = false;
			foreach ($result as $row) {
				$invoices = $this->db->where('pi_id', $row['pi_id'])->get('invoice_master')->result_array();
				if (!empty($invoices)) {
					foreach ($invoices as $inv) {
						if ($inv['invoice_status'] >= 0) {
							$invoice_generated = true;
							break;
						}
					}
				}
			}
			if ($invoice_generated) {
				return ['status' => '1', 'message' => 'Invoice Generated. Return the invoices to change the order'];
			} else {
				return ['status' => '2', 'message' => 'Editing the order will cancel the existing sales order(s).
Do you want to continue?'];
			}
		}
	}

	function get_pi_detail_status($detail_id)
	{
		$this->db->select('im.invoice_status');
		$this->db->from('invoice_details id');
		$this->db->join('invoice_master im', 'id.invoice_master_id=im.invoice_id', 'left');
		$this->db->where('pi_detail_id', $detail_id);
		$res = $this->db->get()->row_array('im.invoice_status');

		return $res;
	}

	function cancel_sales_orders_by_quotation($quotation_id)
	{
		$this->db->set('status', -1);
		$this->db->where('quotation_id', $quotation_id);
		$res = $this->db->update('pi_master');

		return $res;
	}

	//invoices
	function add_invoice_data()
	{
		$quotation_id = $_POST['quotation_id'];

		$prefix = 'AVI#';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prefix, 'invoice_code', 'invoice_master', 5) + 1;
		$digit = sprintf("%1$05d", $num);
		$invoice_code = $prefix . $digit . '_' . date('y');
		$data = array(
			'invoice_code' => $invoice_code,
			'invoice_date' => date('Y-m-d'),
			'pi_id' => $_POST['pi_id'],
			'bank_id' => $_POST['bank'],
			'total_before_vat' => $_POST['subtotal'] - $_POST['total_discount2'],
			'vat_percent' => $_POST['vat_percent'],
			'grand_total' => $_POST['grand_total'],
			'created_by' => $this->session->userdata('user_id'),
			'last_updated_by' => $this->session->userdata('user_id'),
		);
		$res = $this->db->insert('invoice_master', $data);
		$invoice_id = $this->db->insert_id();

		for ($i = 0; $i < $_POST['row_count']; $i++) {

			if ($_POST['quantity'][$i] > 0 || $_POST['sample_quantity'][$i] > 0) {

				$data = array(
					'invoice_master_id' => $invoice_id,
					'pi_detail_id' => $_POST['detail_id'][$i],
					'invoice_quantity' => $_POST['quantity'][$i],
					'sample_quantity' => $_POST['sample_quantity'][$i],
				);
				$this->db->insert('invoice_details', $data);
				$invoice_detail_id = $this->db->insert_id();

				if ($_POST['quantity'][$i] > 0) {
					//stock out the invoiced qty
					$stock_out_qty = $_POST['quantity'][$i];
					if ($_POST['item_category'][$i] > 0) {
						$allocation_details = $this->db->select('*')->from('stock_allocation_details')->where('pi_detail_id', $_POST['detail_id'][$i])->get()->row_array();
						$allocated_quantity = $allocation_details ? $allocation_details['allocated_quantity'] - $allocation_details['issued_quantity'] : 0;


						if ($allocated_quantity > 0) {
							//issue allocated qty
							$issue_qty = $allocated_quantity;
							$issued_quantity = 0;
							if ($stock_out_qty < $issue_qty) {
								$issue_qty = $stock_out_qty;
							}

							$this->db->select('*');
							$this->db->from('stock_details sd');
							$this->db->where('allocation_id', $allocation_details['allocation_detail_id']);
							$issue_stock = $this->db->get()->result_array();

							if (!empty($issue_stock)) {
								foreach ($issue_stock as $row) {
									if ($issue_qty > 0) {
										if ($issue_qty >= $row['quantity']) {
											$issue_qty = $issue_qty - $row['quantity'];
											//update status
											$data = array(
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$issued_quantity += $row['quantity'];

											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											$this->db->insert('stock_details', $stock_out);
										} else if ($row['quantity'] > $issue_qty) {
											$remaining = $row['quantity'] - $issue_qty;

											//update stock status
											$data = array(
												'quantity' => $issue_qty,
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);

											$issued_quantity += $issue_qty;


											//insert remaing stock
											$remaining_stock = $row;
											unset($remaining_stock['stock_id']);
											$remaining_stock['quantity'] = $remaining;
											$this->db->insert('stock_details', $remaining_stock);



											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['quantity'] = $issue_qty;
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											$this->db->insert('stock_details', $stock_out);

											$issue_qty = 0;
										}
									}
								}
							}

							//update allocation details master as allocated
							$this->db->set('issued_quantity', "issued_quantity + {$issued_quantity}", FALSE)->where('allocation_detail_id', $allocation_details['allocation_detail_id'])->update('stock_allocation_details');
						}

						if ($stock_out_qty > $allocated_quantity) {
							$issued_quantity = 0;
							//issue unallocated qty
							$issue_qty = $stock_out_qty - $allocated_quantity;

							$this->db->select('sd.*,wm.warehouse_priority');
							$this->db->from('stock_details sd');
							$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
							$this->db->where('sd.product_id', $_POST['item_id'][$i]);
							$this->db->where('sd.inv_type', 'Actual Stock');
							$this->db->where('sd.status', 0);
							$this->db->group_start()
								->where('sd.project', 0)
								->or_where('sd.project', $quotation_id)
								->group_end();
							$this->db->order_by('wm.warehouse_priority');
							$this->db->order_by('sd.project', 'DESC');
							$this->db->order_by('stock_date');

							$issue_stock = $this->db->get()->result_array();

							if (!empty($issue_stock)) {
								foreach ($issue_stock as $row) {
									if ($issue_qty > 0) {
										if ($issue_qty >= $row['quantity']) {
											$issue_qty = $issue_qty - $row['quantity'];
											//update status
											$data = array(
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$issued_quantity += $row['quantity'];

											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											unset($stock_out['warehouse_priority']);
											$this->db->insert('stock_details', $stock_out);
										} else if ($row['quantity'] > $issue_qty) {
											$remaining = $row['quantity'] - $issue_qty;

											//update stock status
											$data = array(
												'quantity' => $issue_qty,
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);

											$issued_quantity += $issue_qty;


											//insert remaing stock
											$remaining_stock = $row;
											unset($remaining_stock['stock_id']);
											$remaining_stock['quantity'] = $remaining;
											unset($remaining_stock['warehouse_priority']);
											$this->db->insert('stock_details', $remaining_stock);



											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['quantity'] = $issue_qty;
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											unset($stock_out['warehouse_priority']);
											$this->db->insert('stock_details', $stock_out);

											$issue_qty = 0;
										}
									}
								}
							}
						}
					} else {
						$this->load->model('Item_model');
						$components = $this->Item_model->get_custom_item_components($_POST['item_id'][$i]);
						foreach ($components as $c) {
							$issue_qty = $stock_out_qty * $c['component_quantity'];
							$issued_quantity = 0;

							//stock out allocated 
							$this->db->select('sd.*');
							$this->db->from('stock_details sd');
							$this->db->join('stock_allocation_details sad', 'sd.allocation_id = sad.allocation_detail_id');
							$this->db->where('sad.pi_detail_id', $_POST['detail_id'][$i]);
							$this->db->where('sd.product_id', $c['component_item_id']);
							$issue_stock = $this->db->get()->result_array();

							if (!empty($issue_stock)) {
								foreach ($issue_stock as $row) {
									$allocation_detail_id = $row['allocation_id'];
									if ($issue_qty > 0) {
										if ($issue_qty >= $row['quantity']) {
											$issue_qty = $issue_qty - $row['quantity'];
											//update status
											$data = array(
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$issued_quantity += $row['quantity'];

											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											$this->db->insert('stock_details', $stock_out);
										} else if ($row['quantity'] > $issue_qty) {
											$remaining = $row['quantity'] - $issue_qty;

											//update stock status
											$data = array(
												'quantity' => $issue_qty,
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);

											$issued_quantity += $issue_qty;


											//insert remaing stock
											$remaining_stock = $row;
											unset($remaining_stock['stock_id']);
											$remaining_stock['quantity'] = $remaining;
											$this->db->insert('stock_details', $remaining_stock);



											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['quantity'] = $issue_qty;
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											$this->db->insert('stock_details', $stock_out);

											$issue_qty = 0;
										}
									}
								}
							}
							//update allocation details master as allocated
							$this->db->set('issued_quantity', "issued_quantity + {$issued_quantity}", FALSE)->where('allocation_detail_id', $allocation_detail_id)->update('stock_allocation_details');

							//invoicing more than allocated stock
							if ($issue_qty > 0) {
								$this->db->select('sd.*,wm.warehouse_priority');
								$this->db->from('stock_details sd');
								$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
								$this->db->where('sd.product_id', $c['component_item_id']);
								$this->db->where('sd.inv_type', 'Actual Stock');
								$this->db->where('sd.status', 0);
								$this->db->group_start()
									->where('sd.project', 0)
									->or_where('sd.project', $quotation_id)
									->group_end();
								$this->db->order_by('wm.warehouse_priority');
								$this->db->order_by('sd.project', 'DESC');
								$this->db->order_by('stock_date');

								$issue_stock = $this->db->get()->result_array();

								if (!empty($issue_stock)) {
									foreach ($issue_stock as $row) {
										if ($issue_qty > 0) {
											if ($issue_qty >= $row['quantity']) {
												$issue_qty = $issue_qty - $row['quantity'];
												//update status
												$data = array(
													'status' => 2,
													'invoice_id' => $invoice_detail_id,
												);
												$this->db->where('stock_id', $row['stock_id']);
												$this->db->update('stock_details', $data);
												$issued_quantity += $row['quantity'];

												//insert stock out
												$stock_out = $row;
												unset($stock_out['stock_id']);
												$stock_out['stock_type'] = 'OUT';
												$stock_out['stock_date'] = date('Y-m-d');
												$stock_out['status'] = 2;
												$stock_out['invoice_id'] = $invoice_detail_id;
												$stock_out['remark'] = 'Invoice';
												unset($stock_out['warehouse_priority']);
												$this->db->insert('stock_details', $stock_out);
											} else if ($row['quantity'] > $issue_qty) {
												$remaining = $row['quantity'] - $issue_qty;

												//update stock status
												$data = array(
													'quantity' => $issue_qty,
													'status' => 2,
													'invoice_id' => $invoice_detail_id,
												);
												$this->db->where('stock_id', $row['stock_id']);
												$this->db->update('stock_details', $data);

												$issued_quantity += $issue_qty;


												//insert remaing stock
												$remaining_stock = $row;
												unset($remaining_stock['stock_id']);
												$remaining_stock['quantity'] = $remaining;
												unset($remaining_stock['warehouse_priority']);
												$this->db->insert('stock_details', $remaining_stock);



												//insert stock out
												$stock_out = $row;
												unset($stock_out['stock_id']);
												$stock_out['stock_type'] = 'OUT';
												$stock_out['stock_date'] = date('Y-m-d');
												$stock_out['quantity'] = $issue_qty;
												$stock_out['status'] = 2;
												$stock_out['invoice_id'] = $invoice_detail_id;
												$stock_out['remark'] = 'Invoice';
												unset($stock_out['warehouse_priority']);
												$this->db->insert('stock_details', $stock_out);

												$issue_qty = 0;
											}
										}
									}
								}
							}
						}
					}
				}
				if ($_POST['sample_quantity'][$i] > 0) {
					//stock out the invoiced qty
					$stock_out_qty = $_POST['sample_quantity'][$i];
					$this->db->select('sd.*');
					$this->db->from('stock_details sd');
					$this->db->join('sample_request_details srd', 'sd.request_id = srd.request_detail_id', 'left');
					$this->db->where('srd.quotation_detail_id', $_POST['quotation_detail_id'][$i]);
					$this->db->where('sd.status', 3);

					$issue_stock = $this->db->get()->result_array();

					if (!empty($issue_stock)) {
						foreach ($issue_stock as $row) {
							if ($stock_out_qty > 0) {
								if ($stock_out_qty >= $row['quantity']) {
									$stock_out_qty = $stock_out_qty - $row['quantity'];
									//update status
									$data = array(
										'status' => 2,
										'invoice_id' => $invoice_detail_id,
									);
									$this->db->where('stock_id', $row['stock_id']);
									$this->db->update('stock_details', $data);
									$issued_quantity += $row['quantity'];

									//insert stock out
									$stock_out = $row;
									unset($stock_out['stock_id']);
									$stock_out['stock_type'] = 'OUT';
									$stock_out['stock_date'] = date('Y-m-d');
									$stock_out['status'] = 2;
									$stock_out['invoice_id'] = $invoice_detail_id;
									$stock_out['remark'] = 'Invoice';
									$this->db->insert('stock_details', $stock_out);
								} else if ($row['quantity'] > $stock_out_qty) {
									$remaining = $row['quantity'] - $stock_out_qty;

									//update stock status
									$data = array(
										'quantity' => $stock_out_qty,
										'status' => 2,
										'invoice_id' => $invoice_detail_id,
									);
									$this->db->where('stock_id', $row['stock_id']);
									$this->db->update('stock_details', $data);

									$issued_quantity += $stock_out_qty;


									//insert remaing stock
									$remaining_stock = $row;
									unset($remaining_stock['stock_id']);
									$remaining_stock['quantity'] = $remaining;
									$this->db->insert('stock_details', $remaining_stock);



									//insert stock out
									$stock_out = $row;
									unset($stock_out['stock_id']);
									$stock_out['stock_type'] = 'OUT';
									$stock_out['stock_date'] = date('Y-m-d');
									$stock_out['quantity'] = $stock_out_qty;
									$stock_out['status'] = 2;
									$stock_out['invoice_id'] = $invoice_detail_id;
									$stock_out['remark'] = 'Invoice';
									$this->db->insert('stock_details', $stock_out);

									$stock_out_qty = 0;
								}
							}
						}
					}
				}
			}
		}

		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_invoices');

		foreach ($notify_users as $r) {
			$notice = add_notification($invoice_id, $r, "Invoice Created {$invoice_code}", "sales/edit_sales_order/{$invoice_id}", $this->session->userdata('user_id'));
		}
		return $res;
	}

	function update_invoice_data()
	{
		$res = 0;
		$quotation_id = $_POST['quotation_id'];
		for ($i = 0; $i < $_POST['row_count']; $i++) {

			$invoice_detail_id = $_POST['invoice_detail_id'][$i];
			$pi_detail_id = $_POST['pi_detail_id'][$i];

			$issued_quantity = 0;

			//reset stock
			$this->db->where('stock_type', 'OUT');
			$this->db->where('invoice_id', $invoice_detail_id);
			$this->db->delete('stock_details');

			$stock = $this->db->where('stock_type', 'IN')->where('invoice_id', $invoice_detail_id)->get('stock_details')->result_array();
			foreach ($stock as $row) {
				$data = array();
				if ($row['allocation_id'] > 0) {
					$data['status'] = 1;
					if ($_POST['item_category'][$i] > 0)
						$issued_quantity++;
					else {
						$this->db->set('issued_quantity', "issued_quantity - {$row['quantity']}", FALSE)->where('allocation_detail_id', $row['allocation_id'])->update('stock_allocation_details');
					}
				} else {
					$data['status'] = 0;
				}
				$data['invoice_id'] = 0;
				$this->db->where('stock_id', $row['stock_id'])->update('stock_details', $data);
			}

			//deduct issued qty in  allocation details 
			if ($issued_quantity > 0) {
				$this->db->set('issued_quantity', "issued_quantity - {$issued_quantity}", FALSE)->where('pi_detail_id', $pi_detail_id)->update('stock_allocation_details');
			}

			if ($_POST['quantity'][$i] > 0) {
				$data = array(
					'invoice_quantity' => $_POST['quantity'][$i],
				);
				$this->db->where('invoice_detail_id', $invoice_detail_id);
				$this->db->update('invoice_details', $data);

				//stock out the invoiced qty
				$stock_out_qty = $_POST['quantity'][$i];

				if ($_POST['item_category'][$i] > 0) {
					$allocation_details = $this->db->select('*')->from('stock_allocation_details')->where('pi_detail_id', $_POST['detail_id'][$i])->get()->row_array();
					$allocated_quantity = $allocation_details ? $allocation_details['allocated_quantity'] - $allocation_details['issued_quantity'] : 0;


					if ($allocated_quantity > 0) {
						//issue allocated qty
						$issue_qty = $allocated_quantity;
						$issued_quantity = 0;
						if ($stock_out_qty < $issue_qty) {
							$issue_qty = $stock_out_qty;
						}

						$this->db->select('*');
						$this->db->from('stock_details sd');
						$this->db->where('allocation_id', $allocation_details['allocation_detail_id']);
						$issue_stock = $this->db->get()->result_array();

						if (!empty($issue_stock)) {
							foreach ($issue_stock as $row) {
								if ($issue_qty > 0) {
									if ($issue_qty >= $row['quantity']) {
										$issue_qty = $issue_qty - $row['quantity'];
										//update status
										$data = array(
											'status' => 2,
											'invoice_id' => $invoice_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);
										$issued_quantity += $row['quantity'];

										//insert stock out
										$stock_out = $row;
										unset($stock_out['stock_id']);
										$stock_out['stock_type'] = 'OUT';
										$stock_out['stock_date'] = date('Y-m-d');
										$stock_out['status'] = 2;
										$stock_out['invoice_id'] = $invoice_detail_id;
										$stock_out['remark'] = 'Invoice';
										$this->db->insert('stock_details', $stock_out);
									} else if ($row['quantity'] > $issue_qty) {
										$remaining = $row['quantity'] - $issue_qty;

										//update stock status
										$data = array(
											'quantity' => $issue_qty,
											'status' => 2,
											'invoice_id' => $invoice_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);

										$issued_quantity += $issue_qty;


										//insert remaing stock
										$remaining_stock = $row;
										unset($remaining_stock['stock_id']);
										$remaining_stock['quantity'] = $remaining;
										$this->db->insert('stock_details', $remaining_stock);



										//insert stock out
										$stock_out = $row;
										unset($stock_out['stock_id']);
										$stock_out['stock_type'] = 'OUT';
										$stock_out['stock_date'] = date('Y-m-d');
										$stock_out['quantity'] = $issue_qty;
										$stock_out['status'] = 2;
										$stock_out['invoice_id'] = $invoice_detail_id;
										$stock_out['remark'] = 'Invoice';
										$this->db->insert('stock_details', $stock_out);

										$issue_qty = 0;
									}
								}
							}
						}

						//update allocation details master as allocated
						$this->db->set('issued_quantity', "issued_quantity + {$issued_quantity}", FALSE)->where('allocation_detail_id', $allocation_details['allocation_detail_id'])->update('stock_allocation_details');
					}

					if ($stock_out_qty > $allocated_quantity) {
						$issued_quantity = 0;
						//issue unallocated qty
						$issue_qty = $stock_out_qty - $allocated_quantity;

						$this->db->select('sd.*,wm.warehouse_priority');
						$this->db->from('stock_details sd');
						$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
						$this->db->where('sd.product_id', $_POST['item_id'][$i]);
						$this->db->where('sd.inv_type', 'Actual Stock');
						$this->db->where('sd.status', 0);
						$this->db->group_start()
							->where('sd.project', 0)
							->or_where('sd.project', $quotation_id)
							->group_end();
						$this->db->order_by('wm.warehouse_priority');
						$this->db->order_by('sd.project', 'DESC');
						$this->db->order_by('stock_date');

						$issue_stock = $this->db->get()->result_array();

						if (!empty($issue_stock)) {
							foreach ($issue_stock as $row) {
								if ($issue_qty > 0) {
									if ($issue_qty >= $row['quantity']) {
										$issue_qty = $issue_qty - $row['quantity'];
										//update status
										$data = array(
											'status' => 2,
											'invoice_id' => $invoice_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);
										$issued_quantity += $row['quantity'];

										//insert stock out
										$stock_out = $row;
										unset($stock_out['stock_id']);
										$stock_out['stock_type'] = 'OUT';
										$stock_out['stock_date'] = date('Y-m-d');
										$stock_out['status'] = 2;
										$stock_out['invoice_id'] = $invoice_detail_id;
										$stock_out['remark'] = 'Invoice';
										unset($stock_out['warehouse_priority']);
										$this->db->insert('stock_details', $stock_out);
									} else if ($row['quantity'] > $issue_qty) {
										$remaining = $row['quantity'] - $issue_qty;

										//update stock status
										$data = array(
											'quantity' => $issue_qty,
											'status' => 2,
											'invoice_id' => $invoice_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);

										$issued_quantity += $issue_qty;


										//insert remaing stock
										$remaining_stock = $row;
										unset($remaining_stock['stock_id']);
										$remaining_stock['quantity'] = $remaining;
										unset($remaining_stock['warehouse_priority']);
										$this->db->insert('stock_details', $remaining_stock);



										//insert stock out
										$stock_out = $row;
										unset($stock_out['stock_id']);
										$stock_out['stock_type'] = 'OUT';
										$stock_out['stock_date'] = date('Y-m-d');
										$stock_out['quantity'] = $issue_qty;
										$stock_out['status'] = 2;
										$stock_out['invoice_id'] = $invoice_detail_id;
										$stock_out['remark'] = 'Invoice';
										unset($stock_out['warehouse_priority']);
										$this->db->insert('stock_details', $stock_out);

										$issue_qty = 0;
									}
								}
							}
						}
					}
				} else {
					$this->load->model('Item_model');
					$components = $this->Item_model->get_custom_item_components($_POST['item_id'][$i]);
					foreach ($components as $c) {
						$issue_qty = $stock_out_qty * $c['component_quantity'];
						$issued_quantity = 0;

						//stock out allocated 
						$this->db->select('sd.*');
						$this->db->from('stock_details sd');
						$this->db->join('stock_allocation_details sad', 'sd.allocation_id = sad.allocation_detail_id');
						$this->db->where('sad.pi_detail_id', $_POST['pi_detail_id'][$i]);
						$this->db->where('sd.product_id', $c['component_item_id']);
						$issue_stock = $this->db->get()->result_array();

						if (!empty($issue_stock)) {
							foreach ($issue_stock as $row) {
								$allocation_detail_id = $row['allocation_id'];
								if ($issue_qty > 0) {
									if ($issue_qty >= $row['quantity']) {
										$issue_qty = $issue_qty - $row['quantity'];
										//update status
										$data = array(
											'status' => 2,
											'invoice_id' => $invoice_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);
										$issued_quantity += $row['quantity'];

										//insert stock out
										$stock_out = $row;
										unset($stock_out['stock_id']);
										$stock_out['stock_type'] = 'OUT';
										$stock_out['stock_date'] = date('Y-m-d');
										$stock_out['status'] = 2;
										$stock_out['invoice_id'] = $invoice_detail_id;
										$stock_out['remark'] = 'Invoice';
										$this->db->insert('stock_details', $stock_out);
									} else if ($row['quantity'] > $issue_qty) {
										$remaining = $row['quantity'] - $issue_qty;

										//update stock status
										$data = array(
											'quantity' => $issue_qty,
											'status' => 2,
											'invoice_id' => $invoice_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);

										$issued_quantity += $issue_qty;


										//insert remaing stock
										$remaining_stock = $row;
										unset($remaining_stock['stock_id']);
										$remaining_stock['quantity'] = $remaining;
										$this->db->insert('stock_details', $remaining_stock);



										//insert stock out
										$stock_out = $row;
										unset($stock_out['stock_id']);
										$stock_out['stock_type'] = 'OUT';
										$stock_out['stock_date'] = date('Y-m-d');
										$stock_out['quantity'] = $issue_qty;
										$stock_out['status'] = 2;
										$stock_out['invoice_id'] = $invoice_detail_id;
										$stock_out['remark'] = 'Invoice';
										$this->db->insert('stock_details', $stock_out);

										$issue_qty = 0;
									}
								}
							}
						}
						//update allocation details master as allocated
						$this->db->set('issued_quantity', "issued_quantity + {$issued_quantity}", FALSE)->where('allocation_detail_id', $allocation_detail_id)->update('stock_allocation_details');

						//invoicing more than allocated stock
						if ($issue_qty > 0) {
							$this->db->select('sd.*,wm.warehouse_priority');
							$this->db->from('stock_details sd');
							$this->db->join('warehouse_master wm', 'sd.warehouse_id = wm.warehouse_id', 'left');
							$this->db->where('sd.product_id', $c['component_item_id']);
							$this->db->where('sd.inv_type', 'Actual Stock');
							$this->db->where('sd.status', 0);
							$this->db->group_start()
								->where('sd.project', 0)
								->or_where('sd.project', $quotation_id)
								->group_end();
							$this->db->order_by('wm.warehouse_priority');
							$this->db->order_by('sd.project', 'DESC');
							$this->db->order_by('stock_date');

							$issue_stock = $this->db->get()->result_array();

							if (!empty($issue_stock)) {
								foreach ($issue_stock as $row) {
									if ($issue_qty > 0) {
										if ($issue_qty >= $row['quantity']) {
											$issue_qty = $issue_qty - $row['quantity'];
											//update status
											$data = array(
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
											$issued_quantity += $row['quantity'];

											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											unset($stock_out['warehouse_priority']);
											$this->db->insert('stock_details', $stock_out);
										} else if ($row['quantity'] > $issue_qty) {
											$remaining = $row['quantity'] - $issue_qty;

											//update stock status
											$data = array(
												'quantity' => $issue_qty,
												'status' => 2,
												'invoice_id' => $invoice_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);

											$issued_quantity += $issue_qty;


											//insert remaing stock
											$remaining_stock = $row;
											unset($remaining_stock['stock_id']);
											$remaining_stock['quantity'] = $remaining;
											unset($remaining_stock['warehouse_priority']);
											$this->db->insert('stock_details', $remaining_stock);



											//insert stock out
											$stock_out = $row;
											unset($stock_out['stock_id']);
											$stock_out['stock_type'] = 'OUT';
											$stock_out['stock_date'] = date('Y-m-d');
											$stock_out['quantity'] = $issue_qty;
											$stock_out['status'] = 2;
											$stock_out['invoice_id'] = $invoice_detail_id;
											$stock_out['remark'] = 'Invoice';
											unset($stock_out['warehouse_priority']);
											$this->db->insert('stock_details', $stock_out);

											$issue_qty = 0;
										}
									}
								}
							}
						}
					}
				}
			} else {
				//delete inv_detail 
				$res = $this->db->where('invoice_detail_id', $invoice_detail_id)->delete('invoice_details');
			}
		}
		if ($res) {
			$data = array(
				'total_before_vat' => $_POST['subtotal'] - $_POST['total_discount2'],
				'grand_total' => $_POST['grand_total'],
				'supplier_ref' => $_POST['supplier_ref'],
				'other_ref' => $_POST['other_ref'],
				'dispatch_document_number' => $_POST['dispatch_document_number'],
				'payment_terms' => $_POST['payment_terms'],
				'dispatch_through' => $_POST['dispatch_through'],
				'destination' => $_POST['destination'],
				'delivery_terms' => $_POST['delivery_terms'],
			);
			$this->db->where('pi_id', $_POST['pi_id']);
			$res = $this->db->update('pi_master', $data);

			$this->db->set('last_updated_by', $this->session->userdata('user_id'));
			$this->db->where('invoice_id', $_POST['invoice_id']);
			$res = $this->db->update('invoice_master');
		}
		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_invoices');
		$invoice_id = $_POST['invoice_id'];
		$invoice_code = $_POST['invoice_code'];
		foreach ($notify_users as $r) {
			$notice = add_notification($invoice_id, $r, "Invoice Updated {$invoice_code}", "sales/edit_sales_order/{$invoice_id}", $this->session->userdata('user_id'));
		}
		return $res;
	}


	function get_invoices_list($status = '')
	{
		$this->db->select('im.*,pm.pi_code,cust.customer_name');
		$this->db->from('invoice_master im');
		$this->db->join('pi_master pm', 'im.pi_id=pm.pi_id');
		$this->db->join('sales_quotation_master sqm', 'pm.quotation_id=sqm.quotation_id', 'left');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id', 'left');
		if ($status != '') {
			$this->db->where('im.invoice_status', $status);
		}
		$this->db->order_by('im.invoice_code', 'DESC');
		$res = $this->db->get()->result_array();
		return $res;
	}

	function get_invoice_by_id($invoice_id)
	{
		$this->db->select('im.*,im.vat_percent as invoice_vat,est.*,cust.*,pi.*,bank.*,curr.currency_abbr,curr.abbr2');
		$this->db->from('invoice_master im');
		$this->db->join('pi_master pi', 'im.pi_id = pi.pi_id', 'left');
		$this->db->join('sales_quotation_master sqm', 'pi.quotation_id=sqm.quotation_id', 'left');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id', 'left');
		$this->db->join('company_bank_details bank', 'im.bank_id=bank.bid', 'left');
		$this->db->join('currency_master curr', 'est.currency=curr.currency_id', 'left');
		$this->db->where('im.invoice_id', $invoice_id);
		$res = $this->db->get()->row_array();
		return $res;
	}

	function get_invoice_details($invoice_id, $type)
	{

		$this->db->select('id.*,im.*,ed.*,bm.brand_name,um.unit_name,pd.pi_quantity,sad.allocated_quantity,coalesce(sum(delivery_quantity),0) as delivery_qty,
		(pd.pi_quantity - COALESCE((SELECT SUM(id2.invoice_quantity) FROM invoice_details id2 WHERE id2.pi_detail_id = pd.pi_detail_id AND id2.	invoice_detail_status >= 0), 0)) AS pending_invoice_qty,sqm.quotation_id');
		$this->db->select('COALESCE(im.item_model,cim.custom_item_name) AS item_model,COALESCE(im.item_description,cim.custom_item_description) AS item_description');
		$this->db->from('invoice_details id');
		$this->db->join('dn_details dd', 'id.invoice_detail_id=dd.invoice_detail_id', 'left');
		$this->db->join('pi_details pd', 'id.pi_detail_id=pd.pi_detail_id', 'left');
		$this->db->join('stock_allocation_details sad', 'pd.pi_detail_id=sad.pi_detail_id', 'left');
		$this->db->join('estimation_details ed', 'pd.quotation_detail_id=ed.detail_id', 'left');
		$this->db->join('sales_quotation_master sqm', 'ed.estimation_id=sqm.estimation_id', 'left');
		//$this->db->join('item_master im','ed.item_id=im.item_id','left');
		$this->db->join('item_master im', 'ed.item_category = 1 and ed.item_id = im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id = cim.custom_item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id=um.unit_id', 'left');
		if ($type == 1)
			$this->db->where('invoice_detail_status >=', 0);
		$this->db->where('invoice_master_id', $invoice_id);
		$this->db->group_by('id.invoice_detail_id');
		$res = $this->db->get()->result();

		foreach ($res as $item) {
			if ($item->item_category > 0) {
				$this->db->select('SUM(quantity) AS current_stock');
				$this->db->from('stock_details sd');
				$this->db->join('stock_allocation_details sad', 'sd.allocation_id = sad.allocation_detail_id', 'left');
				$this->db->join('pi_details pd', 'sad.pi_detail_id = pd.pi_detail_id', 'left');
				$this->db->where('sd.stock_type', 'IN');
				$this->db->where('sd.inv_type', 'Actual Stock');
				$this->db->group_start()
					->group_start()
					->where('sd.status', '0')
					->group_start()
					->where('sd.project', 0)
					->or_where('sd.project', $item->quotation_id)
					->group_end()
					->group_end()
					->or_group_start()
					->where('sd.status', '2')
					->where('sd.invoice_id', $item->invoice_detail_id)
					->group_end()
					->or_group_start()
					->where('sd.status', '1')
					->where('pd.pi_detail_id', $item->pi_detail_id)
					->group_end()
					->group_end();
				$this->db->where('sd.product_id', $item->item_id);
				$stock = $this->db->get()->row('current_stock');
				$item->current_stock = $stock;
			} else {
				$this->load->model('Item_model');
				$components = $this->Item_model->get_custom_item_components($item->item_id);

				$component_stock = [];
				foreach ($components as $c) {
					$this->db->select('SUM(quantity) AS current_stock');
					$this->db->from('stock_details sd');
					$this->db->join('stock_allocation_details sad', 'sd.allocation_id = sad.allocation_detail_id', 'left');
					$this->db->join('pi_details pd', 'sad.pi_detail_id = pd.pi_detail_id', 'left');
					$this->db->where('sd.stock_type', 'IN');
					$this->db->where('sd.inv_type', 'Actual Stock');
					$this->db->group_start()
						->group_start()
						->where('sd.status', '0')
						->group_start()
						->where('sd.project', 0)
						->or_where('sd.project', $item->quotation_id)
						->group_end()
						->group_end()
						->or_group_start()
						->where('sd.status', '2')
						->where('sd.invoice_id', $item->invoice_detail_id)
						->group_end()
						->or_group_start()
						->where('sd.status', '1')
						->where('pd.pi_detail_id', $item->pi_detail_id)
						->group_end()
						->group_end();
					$this->db->where('sd.product_id', $c['component_item_id']);
					$comp_stock = $this->db->get()->row()->current_stock ?? 0;
					$component_stock[] = floor($comp_stock / $c['component_quantity']);
				}


				$item->current_stock = !empty($component_stock) ? min($component_stock) : 0;
			}
		}
		return $res;
	}

	function get_invoice_details_for_dn($invoice_id)
	{

		$this->db->select('GROUP_CONCAT(sd.serial_number ORDER BY sd.serial_number) AS serial_numbers,sd.invoice_id,SUM(sd.quantity) as invoiced_qty');
		$this->db->from('stock_details sd');
		$this->db->join('invoice_details id', 'sd.invoice_id=id.invoice_detail_id and sd.status = 2 and sd.request_id = 0');
		$this->db->where('sd.stock_type', 'IN');
		$this->db->where('id.invoice_detail_status >=', 0);
		$this->db->where('id.invoice_master_id', $invoice_id);
		$this->db->group_by('id.invoice_detail_id');
		$allocated_query = $this->db->get_compiled_select();

		$this->db->select('GROUP_CONCAT(sd.serial_number ORDER BY sd.serial_number) AS sampled_serials,sd.invoice_id,SUM(sd.quantity) as sampled_qty');
		$this->db->from('stock_details sd');
		$this->db->join('invoice_details id', 'sd.invoice_id=id.invoice_detail_id and sd.status = 2 and sd.request_id != 0');
		$this->db->where('sd.stock_type', 'IN');
		$this->db->where('id.invoice_detail_status >=', 0);
		$this->db->where('id.invoice_master_id', $invoice_id);
		$this->db->group_by('id.invoice_detail_id');
		$sampled_query = $this->db->get_compiled_select();

		$this->db->select('id.*,
		(
        id.invoice_quantity - IFNULL(SUM(
            CASE 
                WHEN dm.dn_status != -1 AND dd.dn_detail_status != -1 
                THEN dd.delivery_quantity 
                ELSE 0 
            END
        	), 0)
    	) AS pending_quantity,sd.*,sample.*,
		 
		ed.*,um.unit_name,bm.brand_name');
		$this->db->select('COALESCE(im.item_type,cim.item_type) AS item_type,COALESCE(im.item_model,cim.custom_item_name) AS item_model,COALESCE(im.item_description,cim.custom_item_description) AS item_description');

		$this->db->from('invoice_details id');
		$this->db->join('dn_details dd', 'id.invoice_detail_id =dd.invoice_detail_id ', 'left');
		$this->db->join('dn_master dm', 'dd.dn_master_id =dm.dn_id', 'left');
		$this->db->join('pi_details pd', 'id.pi_detail_id=pd.pi_detail_id', 'left');
		$this->db->join("($allocated_query) sd", 'sd.invoice_id = id.invoice_detail_id', 'left');
		$this->db->join("($sampled_query) sample", 'sample.invoice_id = id.invoice_detail_id', 'left');
		$this->db->join('estimation_details ed', 'pd.quotation_detail_id=ed.detail_id', 'left');
		$this->db->join('item_master im', 'ed.item_category = 1 and ed.item_id = im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id = cim.custom_item_id', 'left');
		//$this->db->join('item_master i','ed.item_id=i.item_id','left');
		$this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id=um.unit_id', 'left');
		$this->db->where('id.invoice_detail_status >=', 0);
		$this->db->where('id.invoice_master_id', $invoice_id);
		$this->db->group_by('id.invoice_detail_id');


		$res = $this->db->get()->result();
		return $res;
	}


	function cancel_invoice_by_id($invoice_id)
	{
		$this->db->set('invoice_status', -1);
		$this->db->where('invoice_id', $invoice_id);
		$res = $this->db->update('invoice_master');

		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_invoices');
		$invoice_code = $_POST['invoice_code'];
		foreach ($notify_users as $r) {
			$notice = add_notification($invoice_id, $r, "Invoice Cancelled {$invoice_code}", "sales/edit_sales_order/{$invoice_id}", $this->session->userdata('user_id'));
		}

		return $res;
	}

	function get_cancellation_documents_for_invoice($invoice_id)
	{
		$this->db->select('srm.*');
		$this->db->from('sales_return_master srm');
		$this->db->join('dn_master dm', 'srm.dn_id=dm.dn_id', 'left');
		$this->db->join('invoice_master im', 'dm.invoice_id=im.invoice_id', 'left');
		$this->db->where('im.invoice_id', $invoice_id);
		$res = $this->db->get()->result_array();

		return $res;
	}

	function get_invoice_amount($firstDay, $lastDay, $currency)
	{
		$res = $this->db->select('COALESCE(sum(im.total_before_vat),0) as invoice_amount')->from('invoice_master im')->join('pi_master pm', 'im.pi_id=pm.pi_id', 'left')->join('sales_quotation_master sqm', 'pm.quotation_id=sqm.quotation_id', 'left')->join('estimation_master em', 'sqm.estimation_id=em.estimation_id', 'left')->where('em.currency', $currency)->where("im.created_at BETWEEN '$firstDay' AND '$lastDay'")->get()->row('invoice_amount');
		return $res;
	}
	//delivery notes
	function get_delivery_note_list($status = '')
	{
		$this->db->select('dm.*,im.invoice_code,cust.customer_name');
		$this->db->from('dn_master dm');
		$this->db->join('invoice_master im', 'im.invoice_id=dm.invoice_id');
		$this->db->join('pi_master pm', 'im.pi_id=pm.pi_id');
		$this->db->join('sales_quotation_master sqm', 'pm.quotation_id=sqm.quotation_id');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id');
		if ($status != '')
			$this->db->where('dn_status', $status);
		$this->db->order_by('dm.dn_code', 'DESC');
		$res = $this->db->get()->result_array();

		return $res;
	}

	function add_delivery_note_data()
	{

		$prefix = 'AVDN#';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prefix, 'dn_code', 'dn_master', 6) + 1;
		$digit = sprintf("%1$05d", $num);
		$dn_code = $prefix . $digit . '_' . date('y');
		$data = array(
			'dn_code' => $dn_code,
			'dn_date' => date('Y-m-d'),
			'invoice_id' => $_POST['invoice_id'],
			'created_by' => $this->session->userdata('user_id'),
		);
		$res = $this->db->insert('dn_master', $data);
		$dn_id = $this->db->insert_id();


		for ($i = 0; $i < $_POST['row_count']; $i++) {
			$del_qty = $_POST['delivery_quantity'][$i];
			if ($_POST['delivery_quantity'][$i] > 0) {


				$data = array(
					'dn_master_id' => $dn_id,
					'invoice_detail_id' => $_POST['invoice_detail_id'][$i],
					'delivery_quantity' => $_POST['delivery_quantity'][$i],
					'delivery_remarks' => $_POST['remarks'][$i],
				);
				$res = $this->db->insert('dn_details', $data);
				$delivery_detail_id = $this->db->insert_id();
				if ($_POST['item_type'][$i] == 1) {
					$delivered_stock = $_POST['scannedSerials'][$i];
					foreach ($delivered_stock as $serial_no) {
						$data = array('status' => 3, 'dc_id' => $delivery_detail_id);
						$this->db->where('serial_number', $serial_no);
						$res = $this->db->update('stock_details', $data);
					}
				} else {
					if ($_POST['item_category'][$i] > 0) {
						$this->db->select('sd.*');
						$this->db->from('stock_details sd');
						$this->db->where('sd.invoice_id', $_POST['invoice_detail_id'][$i]);
						$this->db->where('sd.status', 2);
						$delivery_stock = $this->db->get()->result_array();

						if (!empty($delivery_stock)) {
							foreach ($delivery_stock as $row) {
								if ($del_qty > 0) {
									if ($del_qty >= $row['quantity']) {
										$del_qty = $del_qty - $row['quantity'];
										//update status
										$data = array(
											'status' => 3,
											'dc_id' => $delivery_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);
									} else if ($row['quantity'] > $del_qty) {
										$remaining = $row['quantity'] - $del_qty;

										//update stock status
										$data = array(
											'quantity' => $del_qty,
											'status' => 3,
											'dc_id' => $delivery_detail_id,
										);
										$this->db->where('stock_id', $row['stock_id']);
										$this->db->update('stock_details', $data);


										//insert remaing stock
										$remaining_stock = $row;
										unset($remaining_stock['stock_id']);
										$remaining_stock['quantity'] = $remaining;
										unset($remaining_stock['warehouse_priority']);
										$this->db->insert('stock_details', $remaining_stock);


										$del_qty = 0;
									}
								}
							}
						}
					} else {
						$this->load->model('Item_model');
						$components = $this->Item_model->get_custom_item_components($_POST['item_id'][$i]);
						foreach ($components as $c) {
							$issue_qty = $del_qty * $c['component_quantity'];

							//stock out allocated 
							$this->db->select('sd.*');
							$this->db->from('stock_details sd');
							$this->db->where('sd.invoice_id', $_POST['invoice_detail_id'][$i]);
							$this->db->where('sd.product_id', $c['component_item_id']);
							$issue_stock = $this->db->get()->result_array();

							if (!empty($issue_stock)) {
								foreach ($issue_stock as $row) {
									if ($issue_qty > 0) {
										if ($issue_qty >= $row['quantity']) {
											$issue_qty = $issue_qty - $row['quantity'];
											//update status
											$data = array(
												'status' => 3,
												'dc_id' => $delivery_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);
										} else if ($row['quantity'] > $issue_qty) {
											$remaining = $row['quantity'] - $issue_qty;

											//update stock status
											$data = array(
												'quantity' => $issue_qty,
												'status' => 3,
												'dc_id' => $delivery_detail_id,
											);
											$this->db->where('stock_id', $row['stock_id']);
											$this->db->update('stock_details', $data);



											//insert remaing stock
											$remaining_stock = $row;
											unset($remaining_stock['stock_id']);
											$remaining_stock['quantity'] = $remaining;
											$this->db->insert('stock_details', $remaining_stock);


											$issue_qty = 0;
										}
									}
								}
							}
						}
					}
				}
			}
		}

		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_delivery_notes');
		foreach ($notify_users as $r) {
			$notice = add_notification($dn_id, $r, "Delivery Note Created {$dn_code}", "sales/edit_sales_order/{$dn_id}", $this->session->userdata('user_id'));
		}

		return $res;
	}

	function get_dn_by_id($dn_id)
	{

		$this->db->select('dm.*,est.*,cust.*,pi.*,im.*');
		$this->db->from('dn_master dm');
		$this->db->join('invoice_master im', 'dm.invoice_id=im.invoice_id', 'left');
		$this->db->join('pi_master pi', 'im.pi_id = pi.pi_id', 'left');
		$this->db->join('sales_quotation_master sqm', 'pi.quotation_id=sqm.quotation_id', 'left');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id', 'left');
		$this->db->where('dm.dn_id', $dn_id);
		$res = $this->db->get()->row_array();
		return $res;
	}

	function get_dn_details($dn_id, $type)
	{

		$subquery = $this->db->select('dc_id, GROUP_CONCAT(serial_number ORDER BY serial_number) AS serial_numbers')
			->from('stock_details')->where('stock_type', 'IN')->where('status', '3')->group_by('dc_id')->get_compiled_select();

		$this->db->select('
			dd.*,
			id.invoice_detail_id,
			pd.pi_detail_id,
			ed.*,
			ed.detail_id,
			bm.brand_name,
			um.unit_name,
			s.serial_numbers
		', FALSE);
		$this->db->select('COALESCE(im.item_type,cim.item_type) AS item_type,COALESCE(im.item_model,cim.custom_item_name) AS item_model,COALESCE(im.item_description,cim.custom_item_description) AS item_description');
		$this->db->from('dn_details dd');

		// Join the subquery for serial numbers
		$this->db->join("($subquery) s", 's.dc_id = dd.dn_detail_id', 'left');

		$this->db->join('invoice_details id', 'dd.invoice_detail_id = id.invoice_detail_id');
		$this->db->join('pi_details pd', 'id.pi_detail_id = pd.pi_detail_id', 'left');
		$this->db->join('estimation_details ed', 'pd.quotation_detail_id = ed.detail_id', 'left');
		$this->db->join('item_master im', 'ed.item_category = 1 and ed.item_id = im.item_id', 'left');
		$this->db->join('custom_item_master cim', 'ed.item_category = 0 and ed.item_id = cim.custom_item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand = bm.brand_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id = um.unit_id', 'left');

		if ($type == 1) {
			$this->db->where('dd.dn_detail_status >=', 0);
		}

		$this->db->where('dd.dn_master_id', $dn_id);

		$res = $this->db->get()->result();

		return $res;
	}

	//sales return
	function get_sales_return_list()
	{
		$this->db->select('sm.*,dm.dn_code,dm.dn_date,im.invoice_code,im.invoice_date,pm.pi_code,pm.grand_total,cust.customer_name');
		$this->db->from('sales_return_master sm');
		$this->db->join('dn_master dm', 'dm.dn_id=sm.dn_id', 'left');
		$this->db->join('invoice_master im', 'im.invoice_id=dm.invoice_id', 'left');
		$this->db->join('pi_master pm', 'im.pi_id=pm.pi_id', 'left');
		$this->db->join('sales_quotation_master sqm', 'pm.quotation_id=sqm.quotation_id', 'left');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id', 'left');
		$res = $this->db->get()->result_array();

		return $res;
	}

	function add_sales_return_data()
	{

		$data = array(
			'return_date' => date('Y-m-d'),
			'dn_id' => $_POST['dn_id'],
			'notes' => $_POST['notes'],
			'approved_technician' => $_POST['technician'],
			'created_by' => $this->session->userdata('user_id'),
		);

		$res = $this->db->insert('sales_return_master', $data);
		$insert_id = $this->db->insert_id();


		$total_return_amount = 0;

		for ($i = 0; $i < $_POST['row_count']; $i++) {

			if ($_POST['return_quantity'][$i] > 0) {
				$return_qty = $_POST['return_quantity'][$i];

				$invoice_detail_id = $_POST['invoice_detail_id'][$i];
				$dn_detail_id = $_POST['dn_detail_id'][$i];
				$pi_detail_id = $_POST['pi_detail_id'][$i];
				$data = array(
					'return_master_id' => $insert_id,
					'dn_detail_id' => $dn_detail_id,
					'return_quantity' => $_POST['return_quantity'][$i],
				);
				$res = $this->db->insert('sales_return_details', $data);
				$return_detail_id = $this->db->insert_id();

				//re-stock the returned items
				if ($_POST['item_type'][$i] == 1) {
					$delivered_stock = $_POST['scannedSerials'][$i];
					foreach ($delivered_stock as $serial_no) {
						//$data=array('status'=>4,'return_id'=>$return_detail_id);
						$data = array('status' => 0, 'return_id' => $return_detail_id);
						$this->db->set($data);
						$this->db->where('serial_number', $serial_no);
						$res = $this->db->update('stock_details', $data);
					}
				} else {
					$this->db->select('sd.*');
					$this->db->from('stock_details sd');
					$this->db->where('sd.dc_id', $_POST['dn_detail_id'][$i]);
					$this->db->where('sd.status', 3);
					$delivered_stock = $this->db->get()->result_array();

					if (!empty($delivered_stock)) {
						foreach ($delivered_stock as $row) {
							if ($return_qty > 0) {
								if ($return_qty >= $row['quantity']) {
									$return_qty = $return_qty - $row['quantity'];
									//update status
									$data = array(
										'status' => 0,
										'return_id' => $return_detail_id,
									);
									$this->db->where('stock_id', $row['stock_id']);
									$this->db->update('stock_details', $data);
								} else if ($row['quantity'] > $return_qty) {
									$remaining = $row['quantity'] - $return_qty;

									//update stock status
									$data = array(
										'quantity' => $return_qty,
										'status' => 0,
										'return_id' => $return_detail_id,
									);
									$this->db->where('stock_id', $row['stock_id']);
									$this->db->update('stock_details', $data);


									//insert remaing stock
									$remaining_stock = $row;
									unset($remaining_stock['stock_id']);
									$remaining_stock['quantity'] = $remaining;
									unset($remaining_stock['warehouse_priority']);
									$this->db->insert('stock_details', $remaining_stock);


									$return_qty = 0;
								}
							}
						}
					}
				}

				$return_amount = $_POST['return_quantity'][$i] * ($_POST['rate'][$i] - ($_POST['rate'][$i] * ($_POST['discount2_percent'][$i] / 100)));
				$total_return_amount += $return_amount;

				//if return qty and delivery qty is same make the detail status as cancelled else reduce the quantity in delivery_details,invoice_details,pi_details
				$this->db->set('dn_detail_status', -1);
				$this->db->where('delivery_quantity', $_POST['return_quantity'][$i]);
				$this->db->where('dn_detail_id', $dn_detail_id);
				$res = $this->db->update('dn_details');
				if ($this->db->affected_rows() == 0) {
					$this->db->set('delivery_quantity', 'delivery_quantity -' . $_POST['return_quantity'][$i], FALSE);
					$this->db->where('dn_detail_id', $dn_detail_id);
					$this->db->update('dn_details');
				}

				$this->db->set('invoice_detail_status', -1);
				$this->db->where('invoice_quantity', $_POST['return_quantity'][$i]);
				$this->db->where('invoice_detail_id', $invoice_detail_id);
				$res = $this->db->update('invoice_details');
				if ($this->db->affected_rows() == 0) {
					$this->db->set('invoice_quantity', 'invoice_quantity -' . $_POST['return_quantity'][$i], FALSE);
					$this->db->where('invoice_detail_id', $invoice_detail_id);
					$res = $this->db->update('invoice_details');
				}

				$this->db->set('detail_status', -1);
				$this->db->where('pi_quantity', $_POST['return_quantity'][$i]);
				$this->db->where('pi_detail_id', $pi_detail_id);
				$res = $this->db->update('pi_details');
				if ($this->db->affected_rows() == 0) {
					$this->db->set('pi_quantity', 'pi_quantity -' . $_POST['return_quantity'][$i], FALSE);
					$this->db->where('pi_detail_id', $pi_detail_id);
					$res = $this->db->update('pi_details');
				}
			}
		}


		if ($res) {
			if ($_POST['grand_total'] > 0) {
				//need to update invoice and pi_master grand_total
				$this->db->set('total_before_vat', 'total_before_vat -' . $total_return_amount, FALSE);
				$this->db->where('invoice_id', $_POST['invoice_id']);
				$res = $this->db->update('invoice_master');

				$this->db->set('total_before_vat', 'total_before_vat -' . $total_return_amount, FALSE);
				$this->db->where('pi_id', $_POST['pi_id']);
				$res = $this->db->update('pi_master');
			} else {

				//to cancel delivery_note,invoice and pi if all items are cancelled
				$this->db->set('dn_status', -1);
				$this->db->set('cancel_remarks', 'Return');
				$this->db->where('dn_id', $_POST['dn_id']);
				$res = $this->db->update('dn_master');

				$this->db->set('total_before_vat', 'total_before_vat -' . $total_return_amount, FALSE);
				$this->db->where('invoice_id', $_POST['invoice_id']);
				$this->db->where('total_before_vat >', $total_return_amount);
				$res = $this->db->update('invoice_master');

				if ($this->db->affected_rows() == 0) {
					$this->db->set('invoice_status', -1);
					$this->db->set('cancel_remarks', 'Return');
					$this->db->where('invoice_id', $_POST['invoice_id']);
					$res = $this->db->update('invoice_master');
				}

				$this->db->set('total_before_vat', 'total_before_vat -' . $total_return_amount, FALSE);
				$this->db->where('pi_id', $_POST['pi_id']);
				$this->db->where('total_before_vat >', $total_return_amount);
				$res = $this->db->update('pi_master');

				if ($this->db->affected_rows() == 0) {
					$this->db->set('status', -1);
					$this->db->where('pi_id', $_POST['pi_id']);
					$res = $this->db->update('pi_master');
				}
			}
		}

		$notify_users = $this->Setup_model->get_users_for_notification('Sales/list_sales_returns');
		$dn_code = $_POST['dn_code'];
		foreach ($notify_users as $r) {
			$notice = add_notification($insert_id, $r, "Sales return Recorded for {$dn_code}", "sales/edit_sales_order/{$insert_id}", $this->session->userdata('user_id'));
		}


		return $res;
	}

	public function get_sales_return_by_id($return_id)
	{
		//$this->db->select('dm.*,est.*,cust.*,pi.*,im.*');
		$this->db->from('sales_return_master srm');
		$this->db->join('dn_master dm', 'dm.dn_id=srm.dn_id', 'left');
		$this->db->join('invoice_master im', 'dm.invoice_id=im.invoice_id', 'left');
		$this->db->join('pi_master pi', 'im.pi_id = pi.pi_id', 'left');
		$this->db->join('sales_quotation_master sqm', 'pi.quotation_id=sqm.quotation_id', 'left');
		$this->db->join('estimation_master est', 'sqm.estimation_id=est.estimation_id', 'left');
		$this->db->join('enquiry_master enq', 'est.enquiry_id=enq.enquiry_id', 'left');
		$this->db->join('customer_master cust', 'enq.enquiry_customer=cust.customer_id', 'left');
		$this->db->where('srm.return_id', $return_id);
		$res = $this->db->get()->row_array();
		return $res;
	}

	function get_return_details($return_id)
	{

		$subquery = $this->db->select('return_id, GROUP_CONCAT(serial_number ORDER BY serial_number) AS serial_numbers')
			->from('stock_details')->where('stock_type', 'IN')->where('status', '0')->group_by('return_id')->get_compiled_select();

		$this->db->select('srd.*,im.*,ed.*,bm.brand_name,um.unit_name,s.serial_numbers');
		$this->db->from('sales_return_details srd');
		$this->db->join("($subquery) s", 's.return_id = srd.return_detail_id', 'left');
		$this->db->join('dn_details dd', 'srd.dn_detail_id=dd.dn_detail_id');
		$this->db->join('invoice_details id', 'dd.invoice_detail_id=id.invoice_detail_id');
		$this->db->join('pi_details pd', 'id.pi_detail_id=pd.pi_detail_id', 'left');
		$this->db->join('estimation_details ed', 'pd.quotation_detail_id=ed.detail_id', 'left');
		$this->db->join('item_master im', 'ed.item_id=im.item_id', 'left');
		$this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
		$this->db->join('unit_master um', 'ed.unit_id=um.unit_id', 'left');
		$this->db->where('return_master_id', $return_id);
		$res = $this->db->get()->result();

		return $res;
	}

	public function get_enquiry_count_by_month($year, $month)
	{
		$this->db->where('YEAR(enquiry_date)', $year);
		$this->db->where('MONTH(enquiry_date)', $month);
		return $this->db->count_all_results('enquiry_master');
	}

	public function get_sales_count_by_month($year, $month)
	{
		$this->db->where('YEAR(pi_date)', $year);
		$this->db->where('MONTH(pi_date)', $month);
		return $this->db->count_all_results('pi_master');
	}
	public function get_last_enquiries($limit = 10)
	{
		$this->db->select('u.user_name, e.enquiry_code, e.enquiry_date, e.enquiry_customer, e.project_name, e.enquiry_status');
		$this->db->from('enquiry_master e');
		$this->db->join('users u', 'u.user_id = e.sales_person', 'inner');
		$this->db->order_by('e.enquiry_date', 'DESC');
		$this->db->limit($limit);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_top_customers($limit = 5)
	{
		$this->db->select('customer_master.customer_name, enquiry_master.enquiry_customer, COUNT(enquiry_master.enquiry_id) as total_enquiries');
		$this->db->from('enquiry_master');
		$this->db->join('customer_master', 'enquiry_master.enquiry_customer = customer_master.customer_id', 'left');
		$this->db->group_by('enquiry_master.enquiry_customer');
		$this->db->order_by('total_enquiries', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_top_sales_customers($limit = 5)
	{
		$this->db->select('customer_master.customer_name, SUM(invoice_master.grand_total) as total_sales');
		$this->db->from('invoice_master');
		$this->db->join('pi_master', 'invoice_master.pi_id = pi_master.pi_id', 'left');
		$this->db->join('customer_master', 'pi_master.customer_id = customer_master.customer_id', 'left');
		$this->db->where('invoice_master.invoice_status', 'confirmed'); // only confirmed invoices
		$this->db->group_by('customer_master.customer_id');
		$this->db->order_by('total_sales', 'DESC');
		$this->db->limit($limit);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_top_customers_by_invoice($limit = 5)
	{
		$this->db->select('c.customer_name, c.customer_code, SUM(i.grand_total) as total_sales');
		$this->db->from('invoice_master i');

		// Join chain
		$this->db->join('pi_master p', 'i.pi_id = p.pi_id', 'inner');
		$this->db->join('sales_quotation_master sq', 'p.quotation_id = sq.quotation_id', 'inner');
		$this->db->join('estimation_master e', 'sq.estimation_id = e.estimation_id', 'inner');
		$this->db->join('enquiry_master enq', 'e.enquiry_id = enq.enquiry_id', 'inner');
		$this->db->join('customer_master c', 'enq.enquiry_customer = c.customer_id', 'inner');

		// Group by customer
		$this->db->group_by('c.customer_id');
		$this->db->order_by('total_sales', 'DESC');
		$this->db->limit($limit);

		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_top_salespersons_by_enquiries($limit = 5)
	{
		$firstDay = (new DateTime('first day of this month'))->format('Y-m-d');
		$lastDay  = (new DateTime('last day of this month'))->format('Y-m-d');

		$this->db->select('u.user_name, e.sales_person as user_id, COUNT(e.enquiry_id) as total_enquiries');
		$this->db->from('enquiry_master e');
		$this->db->join('users u', 'u.user_id = e.sales_person', 'inner');
		$this->db->where('e.enquiry_date >=', $firstDay);
		$this->db->where('e.enquiry_date <=', $lastDay);
		$this->db->group_by('e.sales_person');
		$this->db->order_by('total_enquiries', 'DESC');
		$this->db->limit($limit);

		$query = $this->db->get();
		return $query->result_array();
	}
}
