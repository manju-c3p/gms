<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase_Model extends CI_Model
{

	////////////////// RFQ start ///////////////
	function add_direct_rfq_records()
	{

		$this->load->model('Setup_model');

		$prifix = 'RFQ/';
		$num = $this->Setup_model->get_next_code($prifix, 'rfq_code', 'purchase_rfq', 8) + 1;
		$digit = sprintf("%1$05d", $num);
		$Code = $prifix . date('y') . '/' . $digit;

		$data = array(
			'rfq_code' => $this->input->post('rfq_code'),
			'rev_version'  => 1,
			'rfq_date'  	 => date('Y-m-d', strtotime($this->input->post('rfq_date'))),
			'supplier_id'  => $this->input->post('supplier_id'),
			'rfq_type'  	 => 'direct',
			'status'		=>  '0',
			'sales_person' => $this->input->post('user_id'),
			'subject'      => $this->input->post('subject'),
			'project'		 =>	$this->input->post('project'),
			'ref' 		 => $this->input->post('ref'),
			'remark' 	 => $this->input->post('remarks'),
			'created_by'   => $this->session->userdata('user_id'),
		);
		$this->db->insert('purchase_rfq', $data);
		$insert_id = $this->db->insert_id();

		for ($i = 0; $i < count($_POST['description']); $i++) {

			$data = array(
				'rfq_master_id' => $insert_id,
				'rfq_version' => 1,
				'srno'		  => $i + 1,
				'product_id'  => $_POST['item'][$i],
				'prod_desc'   => $_POST['description'][$i],
				// 'brand'		  => $_POST['brand'][$i],
				'purchase_unit_id' 		  => $_POST['purchase_unit_id'][$i],
				'quantity'    => $_POST['quantity'][$i],

			);
			$this->db->insert('purchase_rfq_transaction', $data);
		}
		// if($insert_id)
		// {
		// 	$user_se_id=$this->session->userdata('user_id');
		// 	$page_name=explode('index.php/', $_SERVER['PHP_SELF']);
		// 	$ci = get_instance();
		// 	$ci->load->helper('log');
		// 	$log_msg=add_log_entry($user_se_id,1,$page_name[1],'purchase_rfq','rfq_id',$insert_id);

		// }
		return $insert_id;
	}
	public function update_rfq_records()
	{
		$rfq_id = $this->input->post('rfq_id');
		if (empty($rfq_id)) return false;

		$data = [
			'rfq_date'     => date('Y-m-d', strtotime($this->input->post('rfq_date'))),
			'supplier_id'  => $this->input->post('supplier_id'),
			'sales_person' => $this->input->post('user_id'),
			'subject'      => $this->input->post('subject'),
			'project'      => $this->input->post('project'),
			'ref'          => $this->input->post('ref'),
			'remark'       => $this->input->post('remarks'),
			'created_by'   => $this->session->userdata('user_id'),
			'updated_at'   => date('Y-m-d H:i:s'),
		];

		$this->db->where('rfq_id', $rfq_id);
		$this->db->update('purchase_rfq', $data);

		// delete old items
		$this->db->delete('purchase_rfq_transaction', ['rfq_master_id' => $rfq_id]);

		// insert new items
		$items = $this->input->post('item');
		$descs = $this->input->post('description');
		$brands = $this->input->post('brand');
		$units = $this->input->post('unit');
		$qtys = $this->input->post('quantity');
		log_message('error', print_r($_POST, true));
		if (is_array($items)) {
			foreach ($items as $i => $item_id) {
				if (empty($item_id)) continue; // only skip if item is empty

				$this->db->insert('purchase_rfq_transaction', [
					'rfq_master_id' => $rfq_id,
					'rfq_version'   => 1,
					'product_id'    => $item_id,
					'prod_desc'     => isset($descs[$i]) ? $descs[$i] : '',
					'brand'         => isset($brands[$i]) ? $brands[$i] : '',
					'purchase_unit_id'          => isset($units[$i]) ? $units[$i] : '',
					'quantity'      => isset($qtys[$i]) ? $qtys[$i] : 0,
				]);
			}
		}


		return $rfq_id;
	}


	function delete_rfq($rfq_id)
	{
		$this->db->query("delete from purchase_rfq_transaction where rfq_master_id='$rfq_id'");
		$this->db->query("delete from purchase_rfq where rfq_id='$rfq_id'");

		// $user_se_id=$this->session->userdata('user_id');
		// $page_name=explode('index.php/', $_SERVER['PHP_SELF']);
		// $ci = get_instance();
		// $ci->load->helper('log');
		// $log_msg=add_log_entry($user_se_id,3,$page_name[1],'grn_master','grn_id',$grn_id);
		// return 1;
	}
	function get_RFQ_list()
	{
		$query = $this->db->query("SELECT r.*, em.username AS rfq_created_by, sp.supplier_name FROM purchase_rfq r JOIN users em ON r.created_by = em.id  JOIN supplier_master sp ON r.supplier_id = sp.supplier_id WHERE r.status = 0    ORDER BY rfq_date DESC;");
		//    echo $this->db-> last_query();exit;
		return $query->result();
	}
	function get_quotation_list()
	{
		$query = $this->db->query("select one.* from (select p.*,s.supplier_name from purchase_quotation_master p, supplier_master s where p.supplier_id=s.supplier_id )as one order by quotation_date desc, quotation_id desc;");
		return $query->result();
	}
	function get_purchase_rfq_tr($rfq_id)
	{
		// $query = $this->db->query("SELECT one.*, two.unit_name, three.brand_name FROM ( SELECT r.*,m.item_id, m.item_description, m.item_unit, m.item_code, m.item_model, m.item_brand,m.mrp_aed FROM purchase_rfq_transaction r JOIN item_master m ON r.product_id = m.item_id WHERE r.rfq_master_id = $rfq_id ORDER BY CAST(r.srno AS SIGNED), r.srno ASC ) AS one LEFT JOIN unit_master two ON one.item_unit = two.unit_id LEFT JOIN brand_master three ON one.item_brand = three.brand_id;");
		$query = $this->db->query("
    SELECT
        one.*,
        two.unit_name

    FROM
    (
        SELECT
            r.*,

            sp.part_id            AS item_id,
            sp.part_name          AS item_description,
            sp.purchase_unit_id   AS item_unit,
            sp.part_code          AS item_code,
            sp.vehicle_model_id   AS item_model,
            sp.brand_id           AS item_brand,
            sp.unit_price         AS mrp_aed,
            sp.part_type,
            sp.warrenty,
            sp.labeling

        FROM purchase_rfq_transaction r

        JOIN spare_parts sp
            ON r.product_id = sp.part_id

        WHERE r.rfq_master_id = $rfq_id

        ORDER BY
            CAST(r.srno AS SIGNED),
            r.srno ASC

    ) AS one

    LEFT JOIN unit_master two
        ON one.item_unit = two.unit_id
");


		return $query->result();
	}
	function get_purchase_rfq_by_id($id)
	{
		// $query = $this->db->query("select one.*, three.user_name from (select r.*, em.user_name as rfq_created_by,  s.supplier_name,s.supplier_code, s.billing_address, s.billing_city, s.billing_state, s.billing_po_box, s.billing_country,s.supplier_email, s.contact_number from purchase_rfq r, users em, supplier_master s where r.created_by=em.user_id and r.supplier_id=s.supplier_id and r.status=0 and rfq_id=$id order by r.rfq_date desc)as one left join(select * from enquiry_master)as two on(one.indent_id=two.enquiry_id) left join(select * from users)as three on(one.sales_person=three.user_id) ");
		$query = $this->db->query("
    SELECT one.*, three.username 
    FROM (
        SELECT r.*, 
               em.username AS rfq_created_by,  
               s.supplier_name,
               s.supplier_code, 
               s.billing_address, 
               s.billing_city, 
               s.billing_state, 
               s.billing_po_box, 
               s.billing_country,
               s.email_id, 
               s.contact_no 
        FROM purchase_rfq r
        JOIN users em ON r.created_by = em.id
        JOIN supplier_master s ON r.supplier_id = s.supplier_id
        WHERE r.status = 0 
        AND r.rfq_id = $id
        ORDER BY r.rfq_date DESC
    ) AS one
    LEFT JOIN users AS three 
        ON one.sales_person = three.id
");

		return $query->result();
	}
	function add_purchase_quotation()
	{

		$prifix = 'SQT/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'quotation_code', 'purchase_quotation_master', 8) + 1;
		$digit = sprintf("%1$05d", $num);
		$code = $prifix . date("y") . '/' . $digit;
		$s_id = $this->input->post('supplier_id');
		$data = array(
			'quotation_date' => date('Y-m-d', strtotime($this->input->post('quotation_date'))),
			'revision' => 0,
			'revision_date' => date('Y-m-d', strtotime($this->input->post('quotation_date'))),
			'rfq_master_id' => $this->input->post('rfq_id') ?? 0,
			'quotation_code' => $code,
			'supplier_id' => $s_id,
			'project' => $this->input->post('project'),
			'reference' => $this->input->post('ref_no'),
			'subtotal' => $this->input->post('sub_total'),
			'vat_amt' => $this->input->post('vat_amount'),
			'vat_percent' => $this->input->post('vat_per'),
			// 'discount_percent' =>$this->input->post('discount_per'),
			// 'discount' => $this->input->post('discount_amt'),
			// 'currency_id' => $this->input->post('cid'),
			// 'currency_rate' => $this->input->post('crate'),	 
			'grand_total' => $this->input->post('grand_total'),
			'payment_term' => $this->input->post('payment_terms'),
			'delivery_term' => $this->input->post('delivery_terms'),
			'general_term' => $this->input->post('general_terms'),
			'validity' => $this->input->post('validity'),
			'created_by' => $this->session->userdata('user_id'),
			'approved_by' => $this->input->post('approved_by'),
			'created_date' => date('Y-m-d H:i:s')
		);

		$this->db->insert('purchase_quotation_master', $data);
		$insert_id = $this->db->insert_id();

		$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
		$data['file_name'] = $_FILES["quote_doc"]["name"];
		$temp = explode(".", $_FILES["quote_doc"]["name"]);
		$extension = end($temp);
		if ((!empty($data['file_name'])) && ($_FILES["quote_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
			if ($_FILES["quote_doc"]["error"] > 0) {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			} else {
				$timestamp1 = time();
				$file_tmp = $_FILES["quote_doc"]["tmp_name"];
				$other_file = $timestamp1 . "_" . $_FILES['quote_doc']['name'];

				//move_uploaded_file($file_tmp,"/home/webadmin/gen/avengers_erp/public/uploaded_documents/".$other_file);
				move_uploaded_file($file_tmp, "public/uploaded_documents/" . $other_file);

				$data = array(
					'doc_master_id' => $insert_id,
					'doc_type' => "Quote File",
					'doc_path' =>  $other_file,
				);
				$this->db->insert('purchase_documents', $data);
			}
		}

		if ($insert_id) {

			for ($i = 0; $i < count($_POST['item_id']); $i++) {
				$data = array(
					'qtn_master_id' => $insert_id,
					'product_id' => $_POST['item_id'][$i],
					'desc' => $_POST['item_description'][$i],
					// 'brand' => $_POST['item_brand'][$i],
					'unit_id' => $_POST['item_unit'][$i],
					// 'packing_id' =>$_POST['item_packing'][$i],
					'quantity'  => $_POST['item_quantity'][$i],
					'price'  => $_POST['unit_price'][$i],
					'total'  => $_POST['total_price'][$i],
					'dis_per'  => $_POST['dis_per'][$i],
					'dis_amt'  => $_POST['dis_amt'][$i],
					'dis_per2'  => $_POST['dis_per2'][$i],
					'dis_amt2'  => $_POST['dis_amt2'][$i],
					'unit_price' => $_POST['final_unit_price'][$i],
				);
				$this->db->insert('purchase_qtn_transaction', $data);
				$this->update_supplier_prices($s_id, $_POST['item_id'][$i], $_POST['item_unit'][$i], $_POST['final_unit_price'][$i]);
			}
		}
		return $insert_id;
	}
	function update_supplier_prices($sid, $pcode, $unit, $unit_price)
	{

		$this->db->where('supplier_id', $sid);
		$this->db->where('product_id', $pcode);
		$this->db->where('unit', $unit);
		$qry = $this->db->get('supplier_prices');

		if ($qry->num_rows() > 0) {
			$price_data = array(
				'price' => $unit_price,
			);
			$this->db->where('supplier_id', $sid);
			$this->db->where('product_id', $pcode);
			$this->db->where('unit', $unit);
			$this->db->update('supplier_prices', $price_data);
		} else {
			$price_data = array(
				'supplier_id' => $sid,
				'product_id' => $pcode,
				'unit' => $unit,
				'price' => $unit_price,
			);
			$this->db->insert('supplier_prices', $price_data);
		}
		//updating item master
		// $price_data = array(
		// 	'mrp_aed' => $unit_price,
		// );
		// $this->db->where('item_id', $pcode);
		// $this->db->update('item_master', $price_data);
	}

	//   function get_quotation_list(){
	// 	$query=$this->db->query("select one.* from (select p.*,s.supplier_name from purchase_quotation_master p, supplier_master s where p.supplier_id=s.supplier_id )as one order by quotation_date desc, quotation_id desc; ");
	// 	return $query->result();
	//   }
	function get_pur_qtn_master_by_id($id)
	{
		$query = $this->db->query("SELECT qtn.*, rfq.rfq_id, rfq.rfq_code, rfq.created_by AS rfq_created_by_id, u1.username AS sales_person,  u2.username AS rfq_created_by_name, sm.supplier_code, sm.supplier_name, sm.billing_address, sm.email_id, sm.contact_no FROM purchase_quotation_master qtn LEFT JOIN purchase_rfq rfq ON qtn.rfq_master_id = rfq.rfq_id LEFT JOIN supplier_master sm ON qtn.supplier_id = sm.supplier_id LEFT JOIN users u1 ON u1.id = qtn.created_by  LEFT JOIN users u2 ON u2.id = rfq.created_by  WHERE quotation_id = '$id';;");
		return $query->result();
	}
	function get_pur_qtn_tr_by_id($id)
	{
		$query = $this->db->query("select pqt.*,p.*,u.unit_name from purchase_qtn_transaction pqt left join spare_parts p ON pqt.product_id = p.part_id left join unit_master u ON pqt.unit_id = u.unit_id where qtn_master_id='$id' ");
		$res =  $query->result();
		return $res;
	}
	public function update_purchase_quotation()
	{
		$quotation_id = $this->input->post("quotation_id");

		// Main data update
		$masterData = array(
			'quotation_date' => date('Y-m-d', strtotime($this->input->post('quotation_date'))),
			'project' => $this->input->post('project'),
			'reference' => $this->input->post('ref_no'),
			'subtotal' => $this->input->post('sub_total'),
			'vat_amt' => $this->input->post('vat_amount'),
			'vat_percent' => $this->input->post('vat_per'),
			'grand_total' => $this->input->post('grand_total'),
			'payment_term' => $this->input->post('payment_terms'),
			'delivery_term' => $this->input->post('delivery_terms'),
			'general_term' => $this->input->post('general_terms'),
			'validity' => $this->input->post('validity'),
			'approved_by' => $this->input->post('approved_by'),
		);

		$this->db->where('quotation_id', $quotation_id);
		$res = $this->db->update('purchase_quotation_master', $masterData);

		// Log DB update error
		if (!$res) {
			log_message('error', 'PQ Update FAILED: ' . json_encode($this->db->error()));
			$this->session->set_flashdata('error', 'Failed to update purchase quotation.');
			return redirect('Purchase/purchase_quotation_list');
		}


		/** FILE UPLOAD **/
		if (!empty($_FILES['quote_doc']['name'])) {

			$allowedExts = ["jpeg", "jpg", "png", "doc", "pdf"];
			$fileName = $_FILES['quote_doc']['name'];
			$tmp = explode(".", $fileName);
			$extension = strtolower(end($tmp));

			if ($_FILES["quote_doc"]["size"] > 15728640) {
				$this->session->set_flashdata('error', 'File size exceeds 15MB.');
				log_message('error', 'PQ File Upload FAILED: File too large.');
			} elseif (!in_array($extension, $allowedExts)) {
				$this->session->set_flashdata('error', 'Invalid file format.');
				log_message('error', 'PQ File Upload FAILED: Invalid file extension.');
			} elseif ($_FILES["quote_doc"]["error"] > 0) {
				$this->session->set_flashdata('error', 'Upload error code: ' . $_FILES["quote_doc"]["error"]);
				log_message('error', 'PQ File Upload FAILED: Error code ' . $_FILES["quote_doc"]["error"]);
			} else {

				$timestamp = time();
				$newName = $timestamp . "_" . $fileName;

				if (move_uploaded_file($_FILES["quote_doc"]["tmp_name"], "public/uploaded_documents/" . $newName)) {

					// Delete old file entry
					$this->db->delete('purchase_documents', [
						'doc_master_id' => $quotation_id,
						'doc_type' => 'Quote File'
					]);

					// Insert new file entry
					$fileData = [
						'doc_master_id' => $quotation_id,
						'doc_type' => "Quote File",
						'doc_path' => $newName,
					];

					$this->db->insert('purchase_documents', $fileData);
				} else {
					$this->session->set_flashdata('error', 'Failed to move the uploaded file.');
					log_message('error', 'PQ File Upload FAILED: move_uploaded_file() failed.');
				}
			}
		}


		/** PROCESS ITEM LINES **/
		$item_ids = $this->input->post('item_id');

		if (!empty($item_ids)) {

			// Delete old items
			$this->db->delete('purchase_qtn_transaction', ['qtn_master_id' => $quotation_id]);

			foreach ($item_ids as $i => $item_id) {

				$itemData = array(
					'qtn_master_id' => $quotation_id,
					'product_id' => $item_id,
					'desc' => $_POST['item_description'][$i],

					'unit_id' => $_POST['item_unit'][$i],
					'quantity' => $_POST['item_quantity'][$i],
					'price' => $_POST['unit_price'][$i],
					'total' => $_POST['total_price'][$i],
					'dis_per' => $_POST['dis_per'][$i],
					'dis_amt' => $_POST['dis_amt'][$i],
					'dis_per2' => $_POST['dis_per2'][$i],
					'dis_amt2' => $_POST['dis_amt2'][$i],
					'unit_price' => $_POST['final_unit_price'][$i],
				);

				$this->db->insert('purchase_qtn_transaction', $itemData);
			}
		}

		// SUCCESS MESSAGE
		$this->session->set_flashdata('success', 'Purchase Quotation updated successfully.');
		redirect('Purchase/purchase_quotation_list');
	}

	public function create_revision_purchase_quotation()
	{
		$original_id = $this->input->post('quotation_id');

		$this->db->where('quotation_id', $original_id);
		$original = $this->db->get('purchase_quotation_master')->row_array();

		if (!$original) {
			return false;
		}

		unset($original['quotation_id']); // remove PK for insert
		$original['quotation_date'] = date('Y-m-d', strtotime($this->input->post('quotation_date')));
		$original['project'] = $this->input->post('project');
		$original['reference'] = $this->input->post('ref_no');
		$original['subtotal'] = $this->input->post('sub_total');
		$original['vat_amt'] = $this->input->post('vat_amount');
		$original['vat_percent'] = $this->input->post('vat_per');
		$original['grand_total'] = $this->input->post('grand_total');
		$original['payment_term'] = $this->input->post('payment_terms');
		$original['delivery_term'] = $this->input->post('delivery_terms');
		$original['general_term'] = $this->input->post('general_terms');
		$original['validity'] = $this->input->post('validity');
		$original['quotation_code'] = $this->input->post('quotation_code');

		$original['revision'] = $original['revision'] + 1;
		$original['created_date'] = date('Y-m-d H:i:s');

		$this->db->insert('purchase_quotation_master', $original);
		$new_quotation_id = $this->db->insert_id();

		for ($i = 0; $i < count($_POST['item_id']); $i++) {
			$item = array(
				'qtn_master_id' => $new_quotation_id,

				'product_id' => $_POST['item_id'][$i],
				'desc' => $_POST['item_description'][$i],
				'brand' => $_POST['item_brand'][$i],
				'unit_id' => $_POST['item_unit'][$i],
				'quantity'  => $_POST['item_quantity'][$i],
				'price'  => $_POST['unit_price'][$i],
				'total'  => $_POST['total_price'][$i],
				'dis_per'  => $_POST['dis_per'][$i],
				'dis_amt'  => $_POST['dis_amt'][$i],
				'dis_per2'  => $_POST['dis_per2'][$i],
				'dis_amt2'  => $_POST['dis_amt2'][$i],
				'unit_price' => $_POST['final_unit_price'][$i]
			);
			$this->db->insert('purchase_qtn_transaction', $item);
		}


		$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
		$fileName = $_FILES["quote_doc"]["name"];
		$temp = explode(".", $fileName);
		$extension = end($temp);

		if (!empty($fileName) && ($_FILES["quote_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
			if ($_FILES["quote_doc"]["error"] == 0) {
				$timestamp1 = time();
				$file_tmp = $_FILES["quote_doc"]["tmp_name"];
				$uploaded_file = $timestamp1 . "_" . $fileName;
				move_uploaded_file($file_tmp, "public/uploaded_documents/" . $uploaded_file);

				$doc_data = array(
					'doc_master_id' => $new_quotation_id,
					'doc_type' => "Quote File",
					'doc_path' => $uploaded_file
				);

				$this->db->insert('purchase_documents', $doc_data);
			}
		}

		return $new_quotation_id;
	}

	function delete_quote($quote_id)
	{
		$this->db->query("delete from purchase_qtn_transaction where qtn_master_id='$quote_id'");
		$this->db->query("delete from purchase_quotation_master where quotation_id='$quote_id'");

		// $user_se_id=$this->session->userdata('user_id');
		// $page_name=explode('index.php/', $_SERVER['PHP_SELF']);
		// $ci = get_instance();
		// $ci->load->helper('log');
		// $log_msg=add_log_entry($user_se_id,3,$page_name[1],'grn_master','grn_id',$grn_id);
		// 
	}
	function add_purchase_orderold()
	{
		$prifix = 'POD/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'po_code', 'purchase_order_master', 8) + 1;
		$digit = sprintf("%1$04d", $num);
		$code = $prifix . date("y") . '/' . $digit;


		$data = array(
			'po_code' => $code,
			'po_date' => date('Y-m-d', strtotime($this->input->post('po_date'))),
			'revision_date' => date('Y-m-d', strtotime($this->input->post('po_date'))),
			'qtn_id' => $this->input->post('quotation_id') ?? 0,
			'supplier_ref' => $this->input->post('ref_no'),
			'supplier_id' => $this->input->post('supplier_id'),
			'subject' => $this->input->post('subject'),
			'sub_total' => $this->input->post('sub_total'),
			'vat_amt' => $this->input->post('vat_amount'),
			'vat_percent' => $this->input->post('vat_per'),
			'discount_percent' => $this->input->post('discount_per'),
			'discount' => $this->input->post('discount_amt'),
			'project' => $this->input->post('project'),
			//   'currency_id' => $this->input->post('cid'),
			// added roundoff amount in this field
			'freight_mode' => $this->input->post('freight_mode'),
			'trans_charge' => $this->input->post('transportation_charge'),
			'cust_charge' => $this->input->post('customs_charge'),
			'add_charge' => $this->input->post('other_charge'),
			'grand_total' => $this->input->post('grand_total'),
			'payment_term' => $this->input->post('payment_terms'),
			'delivery_term' => $this->input->post('delivery_terms'),
			'general_term' => $this->input->post('general_terms'),
			'validity' => $this->input->post('validity'),
			'created_by' => $this->session->userdata('user_id'),
			'request_by' => $this->input->post('request_by'),
			'created_date' => date('Y-m-d H:i:s')
		);
		$this->db->insert('purchase_order_master', $data);
		$insert_id = $this->db->insert_id();

		$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");

		$file = $_FILES["po_doc"];

		// Check if file is selected
		if (!empty($file["name"])) {

			// Get filename + extension safely
			$filename   = $file["name"];
			$extension  = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			$filesize   = $file["size"];
			$fileerror  = $file["error"];

			// Validate extension & size (max 15 MB)
			if ($filesize < 15728640 && in_array($extension, $allowedExts)) {

				if ($fileerror === 0) {

					// New file name
					$newname = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $filename);

					// Destination
					$destination = "uploads/podocuments/" . $newname;

					// Move file
					if (move_uploaded_file($file["tmp_name"], $destination)) {

						// Save to DB
						$data = array(
							'doc_master_id' => $insert_id,
							'doc_type'      => "PO File",
							'doc_path'      => $newname,
						);

						$this->db->insert('purchase_documents', $data);
					} else {
						$this->session->set_flashdata('error', 'File upload failed — cannot move file.');
					}
				} else {
					$this->session->set_flashdata('error', 'Upload error — please try again.');
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid file — check size and format.');
			}
		}

		if ($insert_id) {
			for ($i = 0; $i < count($_POST['item_id']); $i++) {
				$data = array(
					'po_master_id' => $insert_id,
					'product_id' => $_POST['item_id'][$i],
					'desc' => $_POST['item_description'][$i],
					// 'brand' => $_POST['item_brand'][$i],
					'unit_id' => $_POST['item_unit'][$i],
					// 'packing_id' =>$_POST['item_packing'][$i],
					'quantity'  => $_POST['item_quantity'][$i],
					'price'  => $_POST['unit_price'][$i],
					'total'  => $_POST['total_price'][$i],
					'dis_per'  => $_POST['dis_per'][$i],
					'dis_amt'  => $_POST['dis_amt'][$i],
					// 'dis_per2'  => $_POST['dis_per2'][$i],
					// 'dis_amt2'  => $_POST['dis_amt2'][$i],
					// 'unit_price' => $_POST['final_unit_price'][$i]
				);

				$this->db->insert('purchase_order_transaction', $data);
			}
		}
		if (!empty($this->input->post('quotation_id'))) {
			$this->db->where('quotation_id', $this->input->post('quotation_id'));
			$this->db->update('purchase_quotation_master', ['po_created' => 1]);
		}

		return $insert_id;
	}
	// ===============================================
	function add_purchase_order()
	{
		$prifix = 'POD/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'po_code', 'purchase_order_master', 8) + 1;
		$digit = sprintf("%1$04d", $num);
		$code = $prifix . date("y") . '/' . $digit;


		$purchase_type_ui = $this->input->post('purchase_type');

		// ⭐ MAP UI VALUE → DB VALUE
		$purchase_type = ($purchase_type_ui == 'Parts') ? 'PARTS' : 'SERVICE';

		// ⭐ GRN CONTROL
		$is_grn_required = ($purchase_type == 'PARTS') ? 1 : 0;

		$data = array(
			'po_code'            => $code,
			'po_date'            => date('Y-m-d', strtotime($this->input->post('po_date'))),
			'revision_date'      => date('Y-m-d', strtotime($this->input->post('po_date'))),
			'supplier_ref'       => $this->input->post('ref_no'),
			'supplier_id'        => $this->input->post('supplier_id'),
			'subject'            => $this->input->post('subject'),
			'purchase_type'      => $purchase_type,
			'is_grn_required'    => $is_grn_required,
			'sub_total'          => $this->input->post('sub_total'),
			'vat_amt'            => $this->input->post('vat_amount'),
			'vat_percent'        => $this->input->post('vat_per'),
			'discount_percent'   => $this->input->post('discount_per'),
			'discount'           => $this->input->post('discount_amt'),
			'project'            => $this->input->post('project'),
			'freight_mode'       => $this->input->post('freight_mode'),
			'trans_charge'       => $this->input->post('transportation_charge'),
			'cust_charge'        => $this->input->post('customs_charge'),
			'add_charge'         => $this->input->post('other_charge'),
			'grand_total'        => $this->input->post('grand_total'),
			'payment_term'       => $this->input->post('payment_terms'),
			'delivery_term'      => $this->input->post('delivery_terms'),
			'general_term'       => $this->input->post('general_terms'),
			'validity'           => $this->input->post('validity'),
			'created_by'         => $this->session->userdata('user_id'),
			'request_by'         => $this->input->post('request_by'),
			'created_date'       => date('Y-m-d H:i:s'),
			'jobcard_id'         => $this->input->post('jobcard_no'),
			'currency_rate' => $this->input->post('roundoff'),
		);

		$this->db->insert('purchase_order_master', $data);
		$po_id = $this->db->insert_id();


		// ⭐ FILE UPLOAD SAME AS YOUR CODE (NO CHANGE)
		if (!empty($_FILES["po_doc"]["name"])) {

			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");

			$filename   = $_FILES["po_doc"]["name"];
			$extension  = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			$filesize   = $_FILES["po_doc"]["size"];

			if ($filesize < 15728640 && in_array($extension, $allowedExts)) {

				$newname = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $filename);
				$destination = "uploads/podocuments/" . $newname;

				if (move_uploaded_file($_FILES["po_doc"]["tmp_name"], $destination)) {

					$doc = array(
						'doc_master_id' => $po_id,
						'doc_type'      => "PO File",
						'doc_path'      => $newname,
					);

					$this->db->insert('purchase_documents', $doc);
				}
			}
		}


		// ⭐ INSERT TRANSACTIONS BASED ON PURCHASE TYPE

		if ($purchase_type == 'PARTS') {
			if (!empty($_POST['item_id'])) {
				foreach ($_POST['item_id'] as $k => $item) {
					if (empty($item)) continue;

					$row = array(
						'po_master_id' => $po_id,
						'line_type'    => 'PART',
						'product_id'   => $item,
						'desc'         => $_POST['item_description'][$k],
						'unit_id'      => $_POST['item_unit'][$k],
						'quantity'     => $_POST['item_quantity'][$k],
						'price'        => $_POST['unit_price'][$k],
						'total'        => $_POST['total_price'][$k],
						'dis_per'      => $_POST['dis_per'][$k],
						'dis_amt'      => $_POST['dis_amt'][$k]
					);

					$this->db->insert('purchase_order_transaction', $row);
				}
			}
		} else {
			// ⭐ SERVICE PURCHASE INSERT
			if (!empty($_POST['service_description'])) {
				foreach ($_POST['service_description'] as $k => $desc) {
					if (empty($desc)) continue;

					$qty   = isset($_POST['service_qty'][$k]) ? floatval($_POST['service_qty'][$k]) : 0;
					$price = isset($_POST['service_price'][$k]) ? floatval($_POST['service_price'][$k]) : 0;
					$dis   = isset($_POST['service_dis'][$k]) ? floatval($_POST['service_dis'][$k]) : 0;
					$vat   = isset($_POST['service_vat'][$k]) ? floatval($_POST['service_vat'][$k]) : 0;


					$amount = $qty * $price;
					$dis_amt = ($amount * $dis) / 100;
					$net = $amount - $dis_amt;
					$vat_amt = ($net * $vat) / 100;

					$row = array(
						'po_master_id'       => $po_id,
						'line_type'          => 'SERVICE',
						'product_id'         => NULL,
						'desc'               => $desc,
						'quantity'           => $qty,
						'price'              => $price,
						'dis_per'            => $dis,
						'dis_amt'            => $dis_amt,
						'total'              => $_POST['service_total'][$k],
						'service_vat_per'    => $vat,
						'service_vat_amt'    => $vat_amt
					);

					$this->db->insert('purchase_order_transaction', $row);
				}
			}

			// ⭐ LATER YOU WILL CALL ACCOUNT POSTING HERE
			// $this->Accounts_model->post_service_purchase_voucher($po_id);
		}


		return $po_id;
	}



	// ==============================================================
	function get_po_list()
	{
		// $query = $this->db->query("select r.*, s.supplier_name,d.doc_path from purchase_order_master r left join purchase_documents d on r.po_id = d.doc_master_id left join supplier_master s on r.supplier_id=s.supplier_id where r.grn_status=0 order by r.po_id desc;");
		$query = $this->db->query("
				SELECT r.*, s.supplier_name, d.doc_path 
				FROM purchase_order_master r 
				LEFT JOIN purchase_documents d 
					ON r.po_id = d.doc_master_id 
				LEFT JOIN supplier_master s 
					ON r.supplier_id = s.supplier_id 
				ORDER BY r.po_id DESC
			");
		return $query->result();
	}
	function get_approved_po_list()
	{
		$query = $this->db->query("select r.*, s.supplier_name from purchase_order_master r, supplier_master s where r.supplier_id=s.supplier_id and r.grn_status=0 and r.po_status=1 order by po_id desc");
		return $query->result();
	}

	function get_approved_po_list_for_grn()
	{
		$query = $this->db->query("select r.*, s.supplier_name from purchase_order_master r, supplier_master s where r.supplier_id=s.supplier_id and r.grn_status=1 and r.po_status=1 order by po_id desc");
		return $query->result();
	}
	function get_po_master_by_id($po_id)
	{
		$query = $this->db->query("select one.*, three.username, qtn.quotation_code from (select po.*,supplier_code, supplier_name,contact_no, s.email_id, billing_address, s.billing_city, s.billing_state, s.billing_po_box, s.billing_country, s.shipping_address, s.shipping_city, s.shipping_po_box, s.shipping_country,s.shipping_state,s.contact_person,s.contact_person_number,s.trn_no from purchase_order_master po, supplier_master s where po.supplier_id=s.supplier_id and po.po_id=$po_id)as one left join(select * from users)as three on(one.created_by=three.id) left join purchase_quotation_master qtn on qtn.quotation_id=one.qtn_id; ");
		return $query->result();
	}



	function get_po_tr_by_id1($po_id)
	{
		// $query = $this->db->query("SELECT tr.*, pm.*, um.unit_name, bm.brand_name FROM purchase_order_transaction tr LEFT JOIN spare_parts pm ON tr.product_id = pm.part_id LEFT JOIN unit_master um ON tr.unit_id = um.unit_id LEFT JOIN brand_master bm ON tr.brand = bm.brand_id WHERE tr.po_master_id = '$po_id';");
		$query = $this->db->query("
			SELECT tr.*, pm.*, um.unit_name
			FROM purchase_order_transaction tr
			LEFT JOIN spare_parts pm ON tr.product_id = pm.part_id
			LEFT JOIN unit_master um ON tr.unit_id = um.unit_id
			WHERE tr.po_master_id = '$po_id'
		");

		return $query->result();
	}

	function get_po_tr_by_id($po_id)
	{
		$query = $this->db->query("
        SELECT 
            tr.*,
            pm.*,
            um.unit_name,
			tr.price as orgprice,
			tr.total as total,

            -- ✅ Total received qty from GRN
            COALESCE(SUM(grn.rec_quantity), 0) AS received_qty,

            -- ✅ Balance qty
            (tr.quantity - COALESCE(SUM(grn.rec_quantity), 0)) AS balance_qty,

			-- ✅ FIX TOTAL BASED ON BALANCE
			((tr.quantity - COALESCE(SUM(grn.rec_quantity), 0)) * tr.price) AS totalold

        FROM purchase_order_transaction tr

        LEFT JOIN spare_parts pm 
            ON tr.product_id = pm.part_id

        LEFT JOIN unit_master um 
            ON tr.unit_id = um.unit_id

        -- 🔥 IMPORTANT JOIN (PO → GRN)
        LEFT JOIN purchase_grn_transaction grn 
            ON grn.product_id = tr.product_id 
            AND grn.grn_master_id IN (
                SELECT grn_id 
                FROM purchase_grn_master grn
                WHERE grn.po_id = tr.po_master_id
            )

        WHERE tr.po_master_id = '$po_id'

				GROUP BY tr.trans_id
			");

		return $query->result();
	}

	// ============================================================
	public function get_po_master($po_id)
	{
		$this->db->select('
        p.*,
        s.supplier_name,
        s.supplier_code,
        j.jobcard_no
    ');

		$this->db->from('purchase_order_master p');
		$this->db->join('supplier_master s', 's.supplier_id = p.supplier_id', 'left');
		$this->db->join('job_cards j', 'j.jobcard_id = p.jobcard_id', 'left');

		$this->db->where('p.po_id', $po_id);
		$this->db->where('p.cancelled', 0);

		return $this->db->get()->row();
	}

	public function get_service_po_details($po_id)
	{
		$this->db->select('
        t.trans_id,
        t.po_master_id,
        t.line_type,
        t.desc,
        t.quantity,
        t.price,
        t.dis_per,
        t.total,
        t.service_vat_per,
        t.service_vat_amt,
        t.expense_account_id
    ');

		$this->db->from('purchase_order_transaction t');
		$this->db->where('t.po_master_id', $po_id);
		$this->db->where('t.line_type', 'SERVICE');

		return $this->db->get()->result();
	}

	// ========================================================================
	function approve_purchase_order($po_id)
	{
		$this->db->where('po_id', $po_id);
		$this->db->update('purchase_order_master', ['po_status' => 1, 'approved_person' => $this->input->post('user_id')]);
		return ($this->db->affected_rows() > 0);
	}
	function update_purchase_order()
	{

		$po_id = $this->input->post('po_id');


		$purchase_type_ui = $this->input->post('purchase_type');
		// ⭐ MAP UI VALUE → DB VALUE
		$purchase_type = ($purchase_type_ui == 'PARTS') ? 'PARTS' : 'SERVICE';

		// ⭐ GRN CONTROL
		$is_grn_required = ($purchase_type == 'PARTS') ? 1 : 0;


		$data = array(

			'po_date' 		=> date('Y-m-d', strtotime($this->input->post('po_date'))),
			'revision_date'	=> date('Y-m-d', strtotime($this->input->post('po_date'))),
			'qtn_id' 			=> $this->input->post('quotation_id'),
			'supplier_ref' 	=> $this->input->post('ref_no'),
			'supplier_id'		=> $this->input->post('supplier_id'),
			'subject' 		=> $this->input->post('subject'),
			'purchase_type'      => $purchase_type,
			'is_grn_required'    => $is_grn_required,
			'sub_total' 		=> $this->input->post('sub_total'),
			'vat_amt' 		=> $this->input->post('vat_amount'),
			'vat_percent' 	=> $this->input->post('vat_per'),
			'discount_percent' => $this->input->post('discount_per'),
			'discount' 		=> $this->input->post('discount_amt'),
			'freight_mode' => $this->input->post('freight_mode'),

			'trans_charge' 	=> $this->input->post('transportation_charge'),
			'cust_charge' 	=> $this->input->post('customs_charge'),
			'add_charge' 		=> $this->input->post('other_charge'),
			'grand_total' 	=> $this->input->post('grand_total'),
			'payment_term' 	=> $this->input->post('payment_terms'),
			'delivery_term' 	=> $this->input->post('delivery_terms'),
			'general_term' 	=> $this->input->post('general_terms'),
			'validity' => $this->input->post('validity'),
			'created_by' 		=> $this->session->userdata('user_id'),
			'request_by' => $this->input->post('request_by'),
			'created_date' 	=> date('Y-m-d H:i:s'),
			'jobcard_id'         => $this->input->post('jobcard_no'),
			'currency_rate' => $this->input->post('roundoff'),
		);

		$this->db->where('po_id', $po_id);
		$res = $this->db->update('purchase_order_master', $data);

		$this->db->select('*');
		$this->db->where('po_master_id', $po_id);
		$res = $this->db->delete('purchase_order_transaction');

		$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
		$data['file_name'] = $_FILES["po_doc"]["name"];
		$temp = explode(".", $_FILES["po_doc"]["name"]);
		$extension = end($temp);
		if ((!empty($data['file_name'])) && ($_FILES["po_doc"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
			if ($_FILES["po_doc"]["error"] > 0) {
				$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
			} else {
				$timestamp1 = time();
				$file_tmp = $_FILES["po_doc"]["tmp_name"];
				$other_file = $timestamp1 . "_" . $_FILES['po_doc']['name'];

				move_uploaded_file($file_tmp, "uploads/podocuments/" . $other_file);

				$data = array(
					'doc_master_id' => $po_id,
					'doc_type'      => "PO File",
					'doc_path' 	  =>  $other_file,
				);
				$this->db->delete('purchase_documents', ['doc_master_id' => $po_id, 'doc_type' => 'PO File']);
				$this->db->insert('purchase_documents', $data);
			}
		}
		// for ($i = 0; $i < count($_POST['item_id']); $i++) {
		// 	$data = array(
		// 		'po_master_id'  => $po_id,
		// 		'product_id' 	=> $_POST['item_id'][$i],
		// 		'desc' 			=> $_POST['item_description'][$i],

		// 		'unit_id' 		=> $_POST['item_unit'][$i],

		// 		'quantity'  	=> $_POST['item_quantity'][$i],
		// 		'price'  		=> $_POST['unit_price'][$i],
		// 		'total'  		=> $_POST['total_price'][$i],
		// 		'dis_per'  		=> $_POST['dis_per'][$i],
		// 		'dis_amt'  		=> $_POST['dis_amt'][$i],

		// 	);

		// 	$this->db->insert('purchase_order_transaction', $data);
		// }

		// ⭐ INSERT TRANSACTIONS BASED ON PURCHASE TYPE

		if ($purchase_type == 'PARTS') {
			if (!empty($_POST['item_id'])) {
				foreach ($_POST['item_id'] as $k => $item) {
					if (empty($item)) continue;

					$row = array(
						'po_master_id' => $po_id,
						'line_type'    => 'PART',
						'product_id'   => $item,
						'desc'         => $item,
						'unit_id'      => $_POST['item_unit'][$k],
						'quantity'     => $_POST['item_quantity'][$k],
						'price'        => $_POST['unit_price'][$k],
						'total'        => $_POST['total_price'][$k],
						'dis_per'      => $_POST['dis_per'][$k],
						'dis_amt'      => $_POST['dis_amt'][$k]
					);

					$this->db->insert('purchase_order_transaction', $row);
				}
			}
		} else {
			// ⭐ SERVICE PURCHASE INSERT
			if (!empty($_POST['service_description'])) {
				foreach ($_POST['service_description'] as $k => $desc) {
					if (empty($desc)) continue;

					$qty   = isset($_POST['service_qty'][$k]) ? floatval($_POST['service_qty'][$k]) : 0;
					$price = isset($_POST['service_price'][$k]) ? floatval($_POST['service_price'][$k]) : 0;
					$dis   = isset($_POST['service_dis'][$k]) ? floatval($_POST['service_dis'][$k]) : 0;
					$vat   = isset($_POST['service_vat'][$k]) ? floatval($_POST['service_vat'][$k]) : 0;


					$amount = $qty * $price;
					$dis_amt = ($amount * $dis) / 100;
					$net = $amount - $dis_amt;
					$vat_amt = ($net * $vat) / 100;

					$row = array(
						'po_master_id'       => $po_id,
						'line_type'          => 'SERVICE',
						'product_id'         => NULL,
						'desc'               => $desc,
						'quantity'           => $qty,
						'price'              => $price,
						'dis_per'            => $dis,
						'dis_amt'            => $dis_amt,
						'total'              => $_POST['service_total'][$k],
						'service_vat_per'    => $vat,
						'service_vat_amt'    => $vat_amt
					);

					$this->db->insert('purchase_order_transaction', $row);
				}
			}

			// ⭐ LATER YOU WILL CALL ACCOUNT POSTING HERE
			// $this->Accounts_model->post_service_purchase_voucher($po_id);
		}

		return $res;
	}
	function get_quote_doc($doc_id, $doc_type)
	{
		$query = $this->db->query("select * from purchase_documents where doc_master_id=$doc_id and doc_type='$doc_type'");
		return $query->result();
	}


	// GRN and stock entry 
	function add_grn_records()
	{

		$po_id = $this->input->post('po_id');
		$data = array(
			'grn_code' 			=> $this->input->post('grn_code'),
			'grn_date'  		=> date('Y-m-d', strtotime($this->input->post('grndate'))),
			'supplier_id' 		=> $this->input->post('supplier_id'),
			// 'invoice_no' =>$this->input->post('invoice_no'),
			// 'invoice_date' =>date('Y-m-d',strtotime($this->input->post('inv_date'))),
			// 'warehouse_id' 		=> $this->input->post('warehouse_id'),
			'po_id'  			=> $po_id,

			'delivery_details'  => $this->input->post('remarks'),
			'sub_total' 		=> $this->input->post('sub_total'),
			'vat_amt' 			=> $this->input->post('vat_amount'),
			'vat_percent' 		=> $this->input->post('vat_per'),
			'discount_percent'  => $this->input->post('discount_per'),
			'discount' 			=> $this->input->post('discount_amt'),
			// 'currency_id' 		=> $this->input->post('cid'),
			'currency_rate' 	=> $this->input->post('roundoff'),
			'grand_total'		=> $this->input->post('grand_total'),
			'created_by'   		=> $this->session->userdata('user_id'),
		);
		$this->db->insert('purchase_grn_master', $data);
		$insert_id = $this->db->insert_id();
		foreach ($_POST["item_id"] as $i => $product_id) {
			$data1 = array(
				'grn_master_id' => $insert_id,
				'srn'           => $i + 1,
				'product_id'    => $product_id,
				'ord_quantity'  => $_POST['item_quantity'][$i],
				'rec_quantity'  => $_POST['rec_quantity'][$i],
				'price'         => $_POST['unit_price'][$i],
				'unit'          => $_POST['item_unit'][$i],
				// 'landing_price' => $_POST['landing_price'][$i],
				'total'         => $_POST['total_price'][$i],

			);

			$this->db->insert('purchase_grn_transaction', $data1);

			$rec_qty = (int)$_POST['rec_quantity'][$i];
			log_message('error', $rec_qty);
			// $serials = isset($_POST['serial'][$i]) ? $_POST['serial'][$i] : [];

			// $serials = isset($_POST['serial']) ? $_POST['serial'] : [];
			$this->load->model('Stock_model');

			/* NEW GMS STOCK INSERT */

			$part_id      = $product_id;
			$purchase_qty = (float)$_POST['rec_quantity'][$i];
			$grn_code     = $this->input->post('grn_code');
			$grn_date     = $this->input->post('grn_date');
			$price        = (float)$_POST['unit_price'][$i];
			$user_id      = $this->session->userdata('user_id');

			$this->Stock_model->add_stock_purchase(
				$part_id,
				$purchase_qty,
				$grn_code,
				$grn_date,
				$price,
				$user_id
			);



			// $this->convert_pending_to_reserved_fifo($product_id, $rec_qty);
		}

		//////////////// account entry for po invoice cr to supplier & dr to company /////
		$AccountCode = $this->input->post('grn_code');
		$vdate = $this->input->post('grndate');
		$vtime = date('h:i:s');

		/// debit entry 
		for ($i = 0; $i < count($_POST['inv_debtor']); $i++) {
			$debtor = $_POST['inv_debtor'][$i];
			$dr_amount = $_POST['inv_dr_amount'][$i];
			if ($dr_amount > 0) {
				$data = array(
					'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
					'voucher_type' => 'G',  /// po invoice  entry
					'customer_id' => $this->input->post('supplier_id'),
					'account_id' => $debtor,
					'amount' => $dr_amount,
					'drcr_type' => 'Dr',
					//'narration' => $this->input->post('narration'),
					'trans_id' => $insert_id,
					'trans_type' => 'G',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$vid = $this->db->insert_id();
			}
		}
		// credit entry
		for ($i = 0; $i < count($_POST['inv_creditor']); $i++) {
			$creditor = $_POST['inv_creditor'][$i];
			$cr_amount = $_POST['inv_cr_amount'][$i];
			if ($cr_amount > 0) {
				$data = array(
					'voucher_code' => $AccountCode,
					'voucher_date' => date('Y-m-d h:i:s', strtotime("$vdate $vtime")),
					'voucher_type' => 'G',  /// po invoice  entry
					'customer_id' => $this->input->post('supplier_id'),
					'account_id' => $creditor,
					'amount' => $cr_amount,
					'drcr_type' => 'Cr',
					//'narration' => $this->input->post('narration'),
					'trans_id' => $insert_id,
					'trans_type' => 'G',
					'recordCreatedBy' => $this->session->userdata('user_id')
				);
				$this->db->insert('voucher_transaction', $data);
				$vid = $this->db->insert_id();
			}
		}


		//////////////// account entry for po invoice cr to supplier & dr to company /////

		// end for loop	              
		$status = $this->input->post('po_status');
		$query = $this->db->query("update purchase_order_master set grn_status=$status,grn_id=$insert_id where po_id=$po_id;");


		// if($insert_id)
		// {
		// 	$user_se_id=$this->session->userdata('user_id');
		// 	$page_name=explode('index.php/', $_SERVER['PHP_SELF']);
		// 	$ci = get_instance();
		// 	$ci->load->helper('log');
		// 	$log_msg=add_log_entry($user_se_id,1,$page_name[1],'grn_master','grn_id',$insert_id);

		// }
		return $insert_id;
	}

	function get_po_details_by_id($po_id)
	{
		$query = $this->db->query("
				SELECT 
					one.*, 
					three.username, 
					three.contact_no
				FROM 
				(
					SELECT 
						po.*, 
					
						s.supplier_name,
						s.contact_no, 
						s.email_id, 
						s.billing_address, 
						s.billing_city, 
						s.billing_state, 
						s.billing_po_box, 
						s.billing_country, 
						s.shipping_address, 
						s.shipping_city, 
						s.shipping_po_box, 
						s.shipping_country,
						s.shipping_state, 
						s.contact_person AS cp_name, 
						s.contact_person_number AS cp_mobile,
						s.created_date AS supplier_date 
					FROM purchase_order_master po
					JOIN supplier_master s 
						ON po.supplier_id = s.supplier_id
					WHERE po.po_id = ?
				) AS one
				LEFT JOIN users AS three 
					ON one.approved_person = three.id
			", [$po_id]);
		return $query->result();
	}


	private function convert_pending_to_reserved_fifo($product_id, $incoming_qty)
	{
		if ($incoming_qty <= 0) return;

		$pendings = $this->db
			->select('stock_id, alloc_qty, allocation_id, stock_date')
			->from('stock_details')
			->where('product_id', $product_id)
			->where('status', -1) // PENDING
			->where('alloc_qty >', 0)
			->order_by('stock_date', 'ASC')
			->get()
			->result();

		foreach ($pendings as $p) {

			if ($incoming_qty <= 0) break;

			$consume = min($incoming_qty, $p->alloc_qty);

			// reduce pending
			$this->db->set('alloc_qty', "alloc_qty - {$consume}", FALSE)
				->where('stock_id', $p->stock_id)
				->update('stock_details');

			// create RESERVED row
			$this->db->insert('stock_details', [
				'status'        => 1, // RESERVED
				'stock_type'    => 'Reserved',
				'allocation_id' => $p->allocation_id,
				'product_id'    => $product_id,
				'alloc_qty'     => $consume,
				'stock_date'    => date('Y-m-d'),
				'year'          => date('Y'),
				'inv_type'      => 'Actual Stock'
			]);

			$incoming_qty -= $consume;
		}
	}



	function get_grn_list()
	{
		$query = $this->db->query("select r.*, s.supplier_name from purchase_grn_master r, supplier_master s where r.supplier_id=s.supplier_id  order by grn_id desc");
		return $query->result();
	}

	function get_srn_list()
	{
		$query = $this->db->query("
        SELECT 
            r.*, 
            s.supplier_name
        FROM service_receipt_master r
        JOIN supplier_master s 
            ON r.supplier_id = s.supplier_id
        ORDER BY r.id DESC
    ");

		return $query->result();
	}
	// ========================================
	function get_srn_tr_by_id($srn_id)
	{
		$query = $this->db->query("
        SELECT 
            d.*,
            t.desc,
            t.price
        FROM service_receipt_details d
        LEFT JOIN purchase_order_transaction t 
            ON d.po_detail_id = t.trans_id
        WHERE d.srn_id = $srn_id
    ");

		return $query->result();
	}
	function get_srn_master_by_id($srn_id)
	{
		$query = $this->db->query("
        SELECT 
            one.*, 
            three.username
        FROM (
            SELECT 
                srn.*, 
                s.supplier_name,
                s.contact_no,
                s.email_id,
                s.contact_person,
                s.contact_person_number,
                s.billing_address
            FROM service_receipt_master srn
            JOIN supplier_master s 
                ON srn.supplier_id = s.supplier_id
            WHERE srn.id = $srn_id
        ) AS one
        LEFT JOIN users AS three 
            ON one.created_by = three.id
    ");

		return $query->result();
	}



	// ===================================================
	function get_grn_master_by_id($grn_id)
	{
		$query = $this->db->query("select one.*, three.username from (select po.*, supplier_name,contact_no, s.email_id, s.contact_person,s.contact_person_number,s.billing_address from purchase_grn_master po, supplier_master s where po.supplier_id=s.supplier_id and po.grn_id=$grn_id)as one left join(select * from users)as three on(one.created_by=three.id); ");
		return $query->result();
	}

	public function get_grn_master_by_id_new($grn_id)
	{
		return $this->db
			->select('purchase_grn_master.*, 
                  supplier_master.supplier_name, 
                  general_ledger.account_id')
			->from('purchase_grn_master')

			->join(
				'supplier_master',
				'supplier_master.supplier_id = purchase_grn_master.supplier_id',
				'left'
			)

			->join(
				'general_ledger',
				'general_ledger.supplier_id = purchase_grn_master.supplier_id',
				'left'
			)

			->where('purchase_grn_master.grn_id', $grn_id)
			->get()
			->row();
	}
	function get_grn_tr_by_id($grn_id)
	{
		// $query = $this->db->query("select * from purchase_grn_transaction tr left join item_master pm on tr.product_id = pm.item_id left join unit_master um on pm.item_unit = um.unit_id  where  grn_master_id=$grn_id ");
		$query = $this->db->query("
			SELECT *
			FROM purchase_grn_transaction tr
			LEFT JOIN spare_parts pm ON tr.product_id = pm.part_id
			LEFT JOIN unit_master um ON pm.purchase_unit_id = um.unit_id
			WHERE grn_master_id = $grn_id
		");
		return $query->result();
	}
	function delete_grn($grn_id)
	{
		$this->db->query("delete from purchase_grn_transaction where grn_master_id='$grn_id'");
		$this->db->query("delete from purchase_grn_master where grn_id='$grn_id'");
		$this->db->query("delete from stock_details where trans_id='$grn_id'");
		$this->db->query("update purchase_order_master set grn_status=0 where grn_id='$grn_id'");
		// $user_se_id=$this->session->userdata('user_id');
		// $page_name=explode('index.php/', $_SERVER['PHP_SELF']);
		// $ci = get_instance();
		// $ci->load->helper('log');
		// $log_msg=add_log_entry($user_se_id,3,$page_name[1],'grn_master','grn_id',$grn_id);
		// return 1;
	}

	function get_quote_summary($firstDay, $lastDay)
	{
		$res = $this->db
			->select('COUNT(*) as total_count, SUM(grand_total) as total_value')
			->where('created_date >=', $firstDay)
			->where('created_date <=', $lastDay)
			->get('purchase_quotation_master')
			->row();

		// Return as an array for easy access
		return [
			'count' => $res->total_count ?? 0,
			'total_value' => $res->total_value ?? 0
		];
	}


	function get_po_summary($firstDay, $lastDay)
	{
		$res = $this->db
			->select('COUNT(*) as total_count, SUM(grand_total) as total_value')
			->where('created_date >=', $firstDay)
			->where('created_date <=', $lastDay)
			->get('purchase_order_master')
			->row();

		// Return as an array for easy access
		return [
			'count' => $res->total_count ?? 0,
			'total_value' => $res->total_value ?? 0
		];
	}
	function get_grn_summary($firstDay, $lastDay)
	{
		$res = $this->db
			->select('COUNT(*) as total_count, SUM(grand_total) as total_value')
			->where('timestamp >=', $firstDay)
			->where('timestamp <=', $lastDay)
			->get('purchase_grn_master')
			->row();

		// Return as an array for easy access
		return [
			'count' => $res->total_count ?? 0,
			'total_value' => $res->total_value ?? 0
		];
	}
	public function get_po_grn_status_summary()
	{
		$sql = "
        SELECT
            -- PO Status Summary
            SUM(CASE WHEN po_status = 0 THEN 1 ELSE 0 END) AS po_pending,
            SUM(CASE WHEN po_status = 1 THEN 1 ELSE 0 END) AS po_active,
            SUM(CASE WHEN cancelled = 1 THEN 1 ELSE 0 END) AS po_cancelled,

            -- GRN Status Summary
            SUM(CASE WHEN grn_status = 1 THEN 1 ELSE 0 END) AS grn_completed,
            SUM(CASE WHEN grn_status = 0 THEN 1 ELSE 0 END) AS grn_partial
        FROM purchase_order_master
    ";

		return $this->db->query($sql)->row_array();
	}
	public function get_last_grn($limit = 10)
	{
		$this->db->select('g.grn_id, g.grn_code, g.rev_version, g.grn_date, g.invoice_no, g.po_id, g.grand_total, g.status,
                       s.supplier_name, s.supplier_code');
		$this->db->from('purchase_grn_master g');
		$this->db->join('supplier_master s', 's.supplier_id = g.supplier_id', 'left');
		$this->db->order_by('g.grn_date', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_latest_stock($limit = 10)
	{
		$this->db->select('s.stock_id, i.item_code, i.item_description, w.warehouse_name, s.quantity, s.price, s.stock_value, s.expirydate');
		$this->db->from('stock_details s');
		$this->db->join('item_master i', 'i.item_id = s.product_id', 'left');
		$this->db->join('warehouse_master w', 'w.warehouse_id = s.warehouse_id', 'left');
		$this->db->order_by('s.stock_date', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result_array();
	}
	/* ----------------------------------------
     * Get PO details (for quotation reset)
     * -------------------------------------- */
	public function get_po_by_id($po_id)
	{
		return $this->db
			->where('po_id', $po_id)
			->get('purchase_order_master')
			->row();
	}

	/* ----------------------------------------
     * Get PO documents
     * -------------------------------------- */
	public function get_po_documents($po_id)
	{
		return $this->db
			->where('doc_master_id', $po_id)
			->where('doc_type', 'PO File')
			->get('purchase_documents')
			->result();
	}

	/* ----------------------------------------
     * Delete PO documents records
     * -------------------------------------- */
	public function delete_po_documents($po_id)
	{
		$this->db->where('doc_master_id', $po_id);
		return $this->db->delete('purchase_documents');
	}

	/* ----------------------------------------
     * Delete PO items
     * -------------------------------------- */
	public function delete_po_items($po_id)
	{
		$this->db->where('po_master_id', $po_id);
		return $this->db->delete('purchase_order_transaction');
	}

	/* ----------------------------------------
     * Delete PO master
     * -------------------------------------- */
	public function delete_po_master($po_id)
	{
		$this->db->where('po_id', $po_id);
		return $this->db->delete('purchase_order_master');
	}

	/* ----------------------------------------
     * Reset quotation PO status
     * -------------------------------------- */
	public function reset_quotation_po_status($quotation_id)
	{
		if (!empty($quotation_id)) {
			$this->db->where('quotation_id', $quotation_id);
			return $this->db->update(
				'purchase_quotation_master',
				['po_created' => 0]
			);
		}
		return false;
	}

	function get_grn_master_dataold($id, $account_id)
	{

		log_message('error', 'Supplier ID from model: ' . $id);
		log_message('error', 'account_id: ' . $account_id);
		$query = $this->db->query("SELECT  one.*, 
					COALESCE(two.paid_amt, 0) AS paid_amt,
					one.grand_total - COALESCE(two.paid_amt, 0) AS pending_amount
				FROM 
					(
						SELECT 
							*, 
							grand_total - COALESCE(paid_amt, 0) AS pending_amount
						FROM 
							purchase_grn_master
						WHERE supplier_id = $id
					) AS one
				LEFT JOIN 
					(
						SELECT 
							trans_id, 
							SUM(amount) AS paid_amt 
						FROM 
							voucher_transaction 
						WHERE 
							cancel = 0 
							AND voucher_type = 'P' 
							AND drcr_type = 'Dr' 
							AND account_id = $account_id 
						GROUP BY trans_id
					) AS two 
					ON one.grn_id = two.trans_id
				WHERE 
					one.pending_amount > 0
				ORDER BY 
					one.grn_date DESC, 
					one.grn_code DESC;
				");
		return $query->result();
	}

	function get_grn_master_data($id, $account_id)
	{
		log_message('error', 'Supplier ID from model: ' . $id);
		log_message('error', 'account_id: ' . $account_id);

		$query = $this->db->query("
        SELECT  
            one.*, 
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.grand_total - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM 
            purchase_grn_master AS one
        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id 
            GROUP BY trans_id
        ) AS two 
        ON one.grn_id = two.trans_id
        WHERE 
            one.supplier_id = $id
            AND (one.grand_total - COALESCE(two.paid_amt, 0)) > 0
        ORDER BY 
            one.grn_date DESC, 
            one.grn_code DESC
    ");

		return $query->result();
	}
	function get_service_po_data($id, $account_id)
	{
		log_message('error', 'Supplier ID from model: ' . $id);
		log_message('error', 'account_id: ' . $account_id);

		$query = $this->db->query("
        SELECT  
            one.*, one.po_code as grn_code, one.po_date as grn_date,
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.grand_total - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM 
            purchase_order_master AS one
        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id 
            GROUP BY trans_id
        ) AS two 
        ON one.po_id = two.trans_id
        WHERE 
            one.supplier_id = $id
            AND one.purchase_type = 'SERVICE'
            AND one.cancelled = 0
            AND (one.grand_total - COALESCE(two.paid_amt, 0)) > 0
        ORDER BY 
            one.po_date DESC, 
            one.po_code DESC
    ");

		return $query->result();
	}



	function get_supplier_pending_docs111($id, $account_id)
	{
		log_message('error', 'Supplier ID from model: ' . $id);
		log_message('error', 'account_id: ' . $account_id);

		$query = $this->db->query("
        SELECT  
            one.grn_id AS ref_id,
            one.grn_code AS ref_code,
            one.grn_date AS ref_date,
            one.supplier_id,
            one.grand_total,
            'GRN' AS type,
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.grand_total - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM purchase_grn_master AS one

        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id
            GROUP BY trans_id
        ) AS two 
        ON one.grn_id = two.trans_id

        WHERE 
            one.supplier_id = $id
            AND (one.grand_total - COALESCE(two.paid_amt, 0)) > 0

        UNION ALL

        SELECT  
            one.po_id AS ref_id,
            one.po_code AS ref_code,
            one.po_date AS ref_date,
            one.supplier_id,
            one.grand_total,
            'SERVICE_PO' AS type,
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.grand_total - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM purchase_order_master AS one

		 

        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id
            GROUP BY trans_id
        ) AS two 
        ON one.po_id = two.trans_id

        WHERE 
            one.supplier_id = $id
            AND one.purchase_type = 'SERVICE'
            AND one.cancelled = 0
            AND (one.grand_total - COALESCE(two.paid_amt, 0)) > 0

        ORDER BY ref_date DESC, ref_code DESC
    ");

		return $query->result();
	}

	function get_supplier_pending_docs11($id, $account_id)
	{
		log_message('error', 'Supplier ID from model: ' . $id);
		log_message('error', 'account_id: ' . $account_id);

		$query = $this->db->query("
        SELECT  
            one.grn_id AS ref_id,
            one.grn_code AS ref_code,
            one.grn_date AS ref_date,
            one.supplier_id,
            one.grand_total,
            'GRN' AS type,
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.grand_total - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM purchase_grn_master AS one

        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id
            GROUP BY trans_id
        ) AS two 
        ON one.grn_id = two.trans_id

        WHERE 
            one.supplier_id = $id
            AND (one.grand_total - COALESCE(two.paid_amt, 0)) > 0

        UNION ALL

        SELECT  
            one.id AS ref_id,
            one.srn_no AS ref_code,
            one.srn_date AS ref_date,
            one.supplier_id,
            one.total_amount AS grand_total,
            'SRN' AS type,
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.total_amount - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM service_receipt_master AS one

        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id
            GROUP BY trans_id
        ) AS two 
        ON one.id = two.trans_id

        WHERE 
            one.supplier_id = $id
            AND one.status != 'cancelled'
            AND (one.total_amount - COALESCE(two.paid_amt, 0)) > 0

        ORDER BY ref_date DESC, ref_code DESC
    ");

		return $query->result();
	}

	function get_supplier_pending_docs10_5($id, $account_id)
	{
		// log_message('error', 'Supplier ID from model: ' . $id);
		// log_message('error', 'account_id: ' . $account_id);

		$query = $this->db->query("
        SELECT  
            one.grn_id AS ref_id,
            one.grn_code AS ref_code,
            one.grn_date AS ref_date,
            one.supplier_id,
            one.grand_total,
            pom.supplier_ref,
            'GRN' AS type,
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.grand_total - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM purchase_grn_master AS one

        LEFT JOIN purchase_order_master AS pom 
            ON pom.po_id = one.po_id

        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id
            GROUP BY trans_id
        ) AS two 
        ON one.grn_id = two.trans_id

        WHERE 
            one.supplier_id = $id
            AND (one.grand_total - COALESCE(two.paid_amt, 0)) > 0

        UNION ALL

        SELECT  
            one.id AS ref_id,
            one.srn_no AS ref_code,
            one.srn_date AS ref_date,
            one.supplier_id,
            one.total_amount AS grand_total,
            pom.supplier_ref,
            'SRN' AS type,
            COALESCE(two.paid_amt, 0) AS paid_amt,
            one.total_amount - COALESCE(two.paid_amt, 0) AS pending_amount
        FROM service_receipt_master AS one

        LEFT JOIN purchase_order_master AS pom 
            ON pom.po_id = one.po_id

        LEFT JOIN 
        (
            SELECT 
                trans_id, 
                SUM(amount) AS paid_amt 
            FROM voucher_transaction 
            WHERE cancel = 0 
            AND voucher_type = 'P' 
            AND drcr_type = 'Dr' 
            AND account_id = $account_id
            GROUP BY trans_id
        ) AS two 
        ON one.id = two.trans_id

        WHERE 
            one.supplier_id = $id
            AND one.status != 'cancelled'
            AND (one.total_amount - COALESCE(two.paid_amt, 0)) > 0

        ORDER BY ref_date DESC, ref_code DESC ");

		return $query->result();
	}


	function get_supplier_pending_docs($id, $account_id)
	{
		$query = $this->db->query("
    SELECT  
        one.grn_id AS ref_id,
        one.grn_code AS ref_code,
        one.grn_date AS ref_date,
        one.supplier_id,

        one.grand_total,

        /* Purchase Return Amount */
        COALESCE(pr.return_amt, 0) AS purchase_return_amount,

        pom.supplier_ref,

        'GRN' AS type,

        COALESCE(two.paid_amt, 0) AS paid_amt,

        (
            (one.grand_total - COALESCE(pr.return_amt, 0))
            - COALESCE(two.paid_amt, 0)
        ) AS pending_amount

    FROM purchase_grn_master AS one

    LEFT JOIN purchase_order_master AS pom 
        ON pom.po_id = one.po_id

    /* Purchase Return Total */
    LEFT JOIN
    (
        SELECT 
            grn_id,
            SUM(grand_total) AS return_amt
        FROM purchase_return
        WHERE status = 1
        GROUP BY grn_id
    ) AS pr
    ON one.grn_id = pr.grn_id

    /* Payment Done */
    LEFT JOIN 
    (
        SELECT 
            trans_id, 
            SUM(amount) AS paid_amt 
        FROM voucher_transaction 
        WHERE cancel = 0 
        AND voucher_type = 'P' 
        AND drcr_type = 'Dr' 
        AND account_id = $account_id
        GROUP BY trans_id
    ) AS two 
    ON one.grn_id = two.trans_id

    WHERE 
        one.supplier_id = $id

        AND (
            (
                one.grand_total - COALESCE(pr.return_amt, 0)
            ) - COALESCE(two.paid_amt, 0)
        ) > 0

    UNION ALL

    SELECT  
        one.id AS ref_id,
        one.srn_no AS ref_code,
        one.srn_date AS ref_date,
        one.supplier_id,

        one.total_amount AS grand_total,

        0 AS purchase_return_amount,

        pom.supplier_ref,

        'SRN' AS type,

        COALESCE(two.paid_amt, 0) AS paid_amt,

        one.total_amount - COALESCE(two.paid_amt, 0) AS pending_amount

    FROM service_receipt_master AS one

    LEFT JOIN purchase_order_master AS pom 
        ON pom.po_id = one.po_id

    LEFT JOIN 
    (
        SELECT 
            trans_id, 
            SUM(amount) AS paid_amt 
        FROM voucher_transaction 
        WHERE cancel = 0 
        AND voucher_type = 'P' 
        AND drcr_type = 'Dr' 
        AND account_id = $account_id
        GROUP BY trans_id
    ) AS two 
    ON one.id = two.trans_id

    WHERE 
        one.supplier_id = $id
        AND one.status != 'cancelled'
        AND (one.total_amount - COALESCE(two.paid_amt, 0)) > 0

    ORDER BY ref_date DESC, ref_code DESC
    ");

		return $query->result();
	}
	// =============================vat report===========================
	public function get_purchase_vat_summary($from_date = null, $to_date = null)
	{
		$this->db->select("
        SUM(sub_total) AS taxable,
        SUM(vat_amt) AS vat,
        SUM(sub_total + vat_amt) AS total");
		$this->db->from('purchase_grn_master');
		//$this->db->where('cancelled', 0); // optional: only if you use this flag

		if (!empty($from_date) && !empty($to_date)) {
			$this->db->where('grn_date >=', $from_date);
			$this->db->where('grn_date <=', $to_date);
		}

		$query = $this->db->get();
		return $query->row(); // single summary row
	}
	public function get_purchase_vat_details($from_date, $to_date)
	{
		$this->db->select("g.grn_code, g.grn_date, g.sub_total AS taxable, g.vat_amt AS vat, 
                       (g.sub_total + g.vat_amt) AS total, g.supplier_id, g.invoice_no, s.supplier_name");
		$this->db->from('purchase_grn_master g');
		$this->db->join('supplier_master s', 'g.supplier_id = s.supplier_id', 'left'); // Left join in case some GRNs have no supplier
		$this->db->where('g.grn_date >=', $from_date);
		$this->db->where('g.grn_date <=', $to_date);
		$this->db->order_by('g.grn_date', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}
}
