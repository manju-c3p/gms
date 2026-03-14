<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchase extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		$this->load->model('Setup_model');
		$this->load->helper('menu_helper');
		$this->load->model('Purchase_Model');
		$this->load->model('SpareParts_model');
		$this->load->model('Stock_model');
		$this->load->model('Supplier_model');
	}
	/////////////////////Direct RFQ Start  ////////////////////////
	function add_direct_rfq()
	{
		$data['title'] = 'Request For Quotation(RFQ)-Direct';


		$prifix = 'COOL/RFQ/';
		$num = $this->Setup_model->get_next_code($prifix, 'rfq_code', 'purchase_rfq', 13) + 1;
		$digit = sprintf("%1$05d", $num);
		$data['Code'] = $prifix . date('y') . '/' . $digit;
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();

		$data['active_items'] = $this->SpareParts_model->get_all_parts();
		$data['active_units'] = $this->Setup_model->get_active_unit_list();
		$data['main_content'] = 'purchase/rfq_direct_add.php';
		$this->load->view('includes/template.php', $data);
	}
	function add_direct_rfq_records()
	{
		$data['title'] = 'Request For Quotation(RFQ)';
		$this->load->model('Purchase_Model');
		$id = $this->Purchase_Model->add_direct_rfq_records();

		if ($id) {
			echo "<script>
                alert('Data Saved Successfully.');
                window.location.href='" . site_url('Purchase/list_direct_rfq') . "';
            </script>";
		} else {
			echo "<script>
                alert('Error! Data not saved.');
                window.location.href='" . site_url('Purchase/add_direct_rfq') . "';
            </script>";
		}
	}

	function list_direct_rfq()
	{
		$data['title'] = 'Request For Quotation(RFQ)';
		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_RFQ_list();
		$data['main_content'] = 'purchase/rfq_direct_list.php';
		$this->load->view('includes/template.php', $data);
	}

	function delete_rfq()
	{
		$rfq_id = $this->uri->segment('3');

		$this->load->model('Purchase_Model');
		$res = $this->Purchase_Model->delete_rfq($rfq_id);
		echo "<script>
                alert('Data Deleted!');
                window.location.href='" . site_url('Purchase/list_direct_rfq') . "';
            </script>";
		// redirect('Purchase/list_direct_rfq');
	}
	function edit_rfq()
	{
		$user = $this->session->userdata('user_id');
		// if(!has_access($user,'Purchase/list_rfq','E')){
		//     $data['title'] = 'Access Denied';
		//     $data['main_content']='errors/access_control.php';
		// }
		// else{
		$this->load->model('Setup_model');
		$rfq_id = $this->uri->segment('3');
		$data['view_only'] = $this->uri->segment('4');

		if ($data['view_only'] == 0) {
			$data['title'] = 'Edit RFQ';
		} else {
			$data['title'] = 'View RFQ';
		}
		$data['active_items'] = $this->SpareParts_model->get_all_parts();
		$data['active_units'] = $this->Setup_model->get_active_unit_list();
		$data['supplier_records'] = $this->Supplier_model->get_all_supplier_list();
		$data['records1'] = $this->Purchase_Model->get_purchase_rfq_by_id($rfq_id);
		$data['records2'] = $this->Purchase_Model->get_purchase_rfq_tr($rfq_id);
		log_message('error', 'RFQ Records2: ' . print_r($data['records2'], true));
		$data['main_content'] = 'purchase/rfq_direct_edit.php';
		// }
		$this->load->view('includes/template.php', $data);
	}
	function update_rfq()
	{
		$this->Purchase_Model->update_rfq_records();
		echo "<script>
        alert('Data Updated Successfully.');
        window.location.href='" . site_url('Purchase/list_direct_rfq') . "';
        </script>";
		// redirect('Purchase/list_direct_rfq');
	}

	///////////// Supplier Quotation
	function add_quote_from_supplier()
	{
		$data['title'] = 'Quote From Supplier';

		$prifix = 'COOL/SQT/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'quotation_code', 'purchase_quotation_master', 13) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . date("y") . '/' . $digit;
		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_RFQ_list('direct');
		$this->load->model('Setup_model');
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['main_content'] = 'purchase/quotation_add.php';
		$this->load->view('includes/template.php', $data);
	}
	function add_purchase_quotation_records()
	{
		$data['title'] = 'Purchase Quotation';
		$this->load->model('Purchase_Model');
		$this->Purchase_Model->add_purchase_quotation();

		echo "<script>
        alert('Purchase Quotation Saved Successfully.');
        window.location.href='" . site_url('Purchase/purchase_quotation_list') . "';
    </script>";
	}

	function purchase_quotation_list()
	{
		$data['title'] = 'Purchase Quotation';
		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_quotation_list();

		$data['main_content'] = 'purchase/quotation_list.php';
		$this->load->view('includes/template.php', $data);
	}
	function edit_quotation()
	{
		$user = $this->session->userdata('user_id');
		// if (!has_access($user, 'Purchase/purchase_quotation_list', 'E')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// } else {
		$this->load->model('Setup_model');
		$quotation_id = $this->uri->segment('3');
		$data['view_only'] = $this->uri->segment('4');

		if ($data['view_only'] == 0) {
			$data['title'] = 'Edit Quotation';
		} else {
			$data['title'] = 'View Quotation';
		}

		$data['records1'] = $this->Purchase_Model->get_pur_qtn_master_by_id($quotation_id);
		$data['records2'] = $this->Purchase_Model->get_pur_qtn_tr_by_id($quotation_id);
		$data['quote_doc'] = $this->Purchase_Model->get_quote_doc($quotation_id, "Quote File");
		$data['active_units'] = $this->Setup_model->get_active_unit_list();
		$data['main_content'] = 'purchase/quotation_edit.php';
		// }
		$this->load->view('includes/template.php', $data);
	}
	function update_purchase_quotation()
	{
		// $create_revision = $_POST['create_revision'];
		// if ($create_revision) {
		//     $this->Purchase_Model->create_revision_purchase_quotation();
		// } else {       
		$update_status = $this->Purchase_Model->update_purchase_quotation();
		// }

		if ($update_status) {
			// Success alert
			echo "<script>
            alert('Purchase Quotation Updated Successfully.');
            window.location.href='" . site_url('Purchase/purchase_quotation_list') . "';
        </script>";
		} else {
			// Failure alert
			echo "<script>
            alert('Update Failed! Please try again.');
            window.history.back();
        </script>";
		}
	}


	function purchase_quotation_details()
	{
		$data['title'] = 'Purchase Quotation';
		$quotation_id = $this->uri->segment('3');
		$version = $this->uri->segment('4');
		$data['edit_flag'] = $this->uri->segment('5');

		$this->load->model('Setup_Model');
		$data['item_records'] = $this->Setup_Model->get_active_item_list();
		$data['unit_records'] = $this->Setup_Model->get_unit_list();
		$data['supplier_records'] = $this->Setup_Model->get_supplier_list();

		$this->load->model('Purchase_Model');
		$data['records1'] = $this->Purchase_Model->get_pruchase_quotation_by_id($quotation_id);
		$data['records2'] = $this->Purchase_Model->get_pruchase_quotation_tr_by_id($quotation_id, $version);
		$data['main_content'] = 'purchase/quotation_details.php';
		$this->load->view('includes/template.php', $data);
	}
	function print_quote()
	{
		$user = $this->session->userdata('user_id');
		// if (!has_view_access($user, 'Purchase/list_direct_rfq')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// 	$this->load->view('includes/template', $data);
		// } else {
		$quotation_id = $this->uri->segment('3');
		$data['quote_tr'] = $this->Purchase_Model->get_pur_qtn_tr_by_id($quotation_id);
		log_message('error', 'Supplier Quote transactions: ' . print_r($data['quote_tr'], true));
		$data['quote'] = $this->Purchase_Model->get_pur_qtn_master_by_id($quotation_id);
		log_message('error', 'Supplier Quote Master: ' . print_r($data['quote'], true));
		// $data['comp_details'] = "";
		$this->load->view('purchase/print/quotation_print.php', $data);
		// }
	}
	function delete_quote($quote_id)
	{
		// $quote_id = $this->uri->segment('3');	
		$this->load->model('Purchase_Model');
		$res = $this->Purchase_Model->delete_quote($quote_id);
		echo "<script>
        alert('Purchase Quotation Deleted Successfully.');
        window.location.href='" . site_url('Purchase/purchase_quotation_list') . "';
    </script>";
	}
	public function delete_quote_protected()
	{
		$quotation_id = $this->input->post('quotation_id');
		$password = $this->input->post('password');
		$correct_password = 'abc123';

		if ($password === $correct_password) {
			$this->load->model('Purchase_model');
			$this->Purchase_model->delete_quote($quotation_id);
			echo "<script>
        alert('Purchase Quotation Deleted Successfully.');
        window.location.href='" . site_url('Purchase/purchase_quotation_list') . "';
        </script>";
		} else {
			echo 'error';
		}
	}
	function accept_purchase_quotation()
	{
		$data['title'] = 'Purchase Quotation';
		$qid = $this->uri->segment('3');
		$version = $this->uri->segment('4');
		$this->load->model('Purchase_Model');
		$this->Purchase_Model->accept_purchase_quotation($qid, $version);

		echo "<script>
            alert('Purchase Quotation Approved.');
            window.location.href='" . site_url('Purchase/purchase_quotation_list') . "';
        </script>";
		redirect('Purchase/purchase_quotation_list');
	}
	///////////////////////////////////////////////////////////////
	function add_purchase_order()
	{
		$data['title'] = 'Purchase Order';
		$prifix = 'COOL/POD/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'po_code', 'purchase_order_master', 13) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . date("y") . '/' . $digit;

		$data['records'] = $this->Purchase_Model->get_quotation_list();
		$this->load->model('Setup_model');

		$data['main_content'] = 'purchase/po_add.php';
		$this->load->view('includes/template.php', $data);
	}
	function add_po_records()
	{
		$data['title'] = 'Purchase Order';
		$this->load->model('Purchase_Model');
		$this->Purchase_Model->add_purchase_order();

		echo "<script>
            alert('Purchase Order Saved Successfully.');
            window.location.href='" . site_url('Purchase/purchase_order_list') . "';
        </script>";
	}

	function purchase_order_list()
	{
		$data['title'] = 'Purchase Order List';
		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_po_list();

		$data['main_content'] = 'purchase/po_list.php';
		$this->load->view('includes/template.php', $data);
	}
	function print_po()
	{
		$user = $this->session->userdata('user_id');
		$data['comp_details'] = "";
		// if (!has_view_access($user, 'Purchase/purchase_order_list')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// 	$this->load->view('includes/template', $data);
		// } else {
		$po_id = $this->uri->segment('3');
		$data['po_tr'] = $this->Purchase_Model->get_po_tr_by_id($po_id);
		$data['po'] = $this->Purchase_Model->get_po_master_by_id($po_id);

		$this->load->view('purchase/print/po_print.php', $data);
		// }
	}
	function approve_po()
	{
		$po_id = $this->uri->segment('3');
		$this->Purchase_Model->approve_purchase_order($po_id);
		echo "<script>
        alert('Purchase Order Approved');
        window.location.href='" . site_url('Purchase/purchase_order_list') . "';
    </script>";
		//redirect('Purchase/purchase_order_list');
	}
	function edit_po()
	{
		$user = $this->session->userdata('user_id');
		// if (!has_access($user, 'Purchase/purchase_order_list', 'E')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// } else {
		$this->load->model('Setup_model');
		$po_id = $this->uri->segment('3');
		$data['view_only'] = $this->uri->segment('4');

		if ($data['view_only'] == 0) {
			$data['title'] = 'Edit Purchase Order';
		} else {
			$data['title'] = 'View Purchase Order';
		}

		$data['records1'] = $this->Purchase_Model->get_po_master_by_id($po_id);
		$data['records2'] = $this->Purchase_Model->get_po_tr_by_id($po_id);
		$data['po_doc']   = $this->Purchase_Model->get_quote_doc($po_id, "PO File");
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['active_units'] = $this->Setup_model->get_active_unit_list();
		// echo '<pre>';print_r($data);exit;
		if ($data['records1'][0]->qtn_id == 0) {
			$data['main_content'] = 'purchase/po_direct_edit.php';
		} else {
			$data['main_content'] = 'purchase/po_edit.php';
		}

		//  echo '<pre>';print_r($data);exit;
		// }
		$this->load->view('includes/template.php', $data);
	}
	function update_purchase_order()
	{
		$this->Purchase_Model->update_purchase_order();
		echo "<script>
        alert('Purchase Order Updated!');
        window.location.href='" . site_url('Purchase/purchase_order_list') . "';
    </script>";
		//redirect('Purchase/purchase_order_list');
	}
	function add_PO_direct_from_reorder()
	{
		$data['title'] = 'Purchase Order-Stock';
		error_reporting(0);

		$this->load->model('Purchase_Model');
		$data['records'] = $this->Purchase_Model->get_RFQ_list('direct');
		$data['active_items'] = $this->Item_model->get_active_item_list();
		$data['active_units'] = $this->Item_model->get_active_unit_list();
		$this->load->model('Setup_model');
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['reorder_list'] = $this->Stock_model->get_reorder_stock_for_PO();
		echo '<pre>';
		print_r($data);
		exit;
		$data['main_content'] = 'purchase/po_direct_add.php';
		$this->load->view('includes/template.php', $data);
	}
	function add_grn()
	{
		$data['title'] = 'Good Received Note';
		$prifix = 'COOL/GRN/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'grn_code', 'purchase_grn_master', 13) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . date("y") . '/' . $digit;
		$data['warehouse_list'] = "";

		$data['records'] = $this->Purchase_Model->get_approved_po_list();
		$this->load->model('Accounts_model');
		$data['sundry_accounts1'] = $this->Accounts_model->get_general_ledger_by_group('Purchase Accounts');
		$data['sundry_accounts2'] = $this->Accounts_model->get_gen_ledger_creditors_records();
		$data['sundry_accounts3'] = $this->Accounts_model->get_all_general_ledger_accounts();


		$data['main_content'] = 'purchase/grn_add.php';
		$this->load->view('includes/template.php', $data);
	}
	function add_grn_records()
	{
		$this->Purchase_Model->add_grn_records();
		echo "<script>
        alert('GRN Saved!');
        window.location.href='" . site_url('Purchase/purchase_grn_list') . "';
        </script>";
	}
	function purchase_grn_list()
	{
		$data['title'] = 'Purchase GRN List';
		$data['records'] = $this->Purchase_Model->get_grn_list();
		$data['main_content'] = 'purchase/grn_list.php';
		$this->load->view('includes/template.php', $data);
	}
	function print_grn()
	{
		$user = $this->session->userdata('user_id');
		$data['comp_details'] = "";
		// if (!has_view_access($user, 'Purchase/purchase_grn_list')) {
		// 	$data['title'] = 'Access Denied';
		// 	$data['main_content'] = 'errors/access_control.php';
		// 	$this->load->view('includes/template', $data);
		// } else {
		$grn_id = $this->uri->segment('3');
		$data['grn_tr'] = $this->Purchase_Model->get_grn_tr_by_id($grn_id);
		$data['grn'] = $this->Purchase_Model->get_grn_master_by_id($grn_id);
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('purchase/print/grn_print.php', $data);
		// }
	}
	function print_grn_barcode()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Purchase/purchase_grn_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
		} else {
			$grn_id = $this->uri->segment('3');
			$data['grn_tr'] = $this->Purchase_Model->get_grn_tr_by_id($grn_id);
			$data['grn'] = $this->Purchase_Model->get_grn_master_by_id($grn_id);

			$this->load->view('purchase/print/grn_barcode_print.php', $data);
		}
	}
	function delete_grn()
	{
		$grn_id = $this->input->post('grn_id');
		$this->load->model('Purchase_Model');
		$this->Purchase_Model->delete_grn($grn_id);
		echo "<script>
        alert('GRN Saved!');
        window.location.href='" . site_url('Purchase/purchase_grn_list') . "';
        </script>";
	}
	function direct_po()
	{
		$data['title'] = 'Direct Purchase Order';

		$prifix = 'COOL/POD/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'po_code', 'purchase_order_master', 13) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . date("y") . '/' . $digit;

		$data['records'] = $this->Purchase_Model->get_quotation_list();
		$this->load->model('Setup_model');

		$data['active_items'] = $this->SpareParts_model->get_all_parts();
		$data['active_units'] = $this->Setup_model->get_active_unit_list();


		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['main_content'] = 'purchase/po_direct_add.php';
		$this->load->view('includes/template.php', $data);
	}

	function direct_quote()
	{
		$data['title'] = 'Direct Supplier Quote';
		$prifix = 'AVE/QTN/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'quotation_code', 'purchase_quotation_master', 12) + 1;
		$digit = sprintf("%1$04d", $num);
		$data['Code'] = $prifix . date("y") . '/' . $digit;

		$this->load->model('Setup_model');
		$this->load->model('Item_model');
		$data['active_items'] = $this->Item_model->get_active_item_list();
		$data['active_units'] = $this->Item_model->get_active_unit_list();

		$data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
		$data['main_content'] = 'purchase/quote_direct_add.php';
		$this->load->view('includes/template.php', $data);
	}

	public function delete_purchase_order($po_id)
	{
		if (empty($po_id)) {
			show_404();
		}
		echo $po_id;
		exit;
		$this->load->model('Purchase_Model');

		// Get PO
		$po = $this->Purchase_Model->get_po_by_id($po_id);
		if (!$po) {
			show_404();
		}

		// Get documents and delete files
		$docs = $this->Purchase_Model->get_po_documents($po_id);
		foreach ($docs as $doc) {
			$file_path = FCPATH . 'public/uploaded_documents/' . $doc->doc_path;
			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}

		// Delete DB records
		$this->Purchase_Model->delete_po_documents($po_id);
		$this->Purchase_Model->delete_po_items($po_id);
		$this->Purchase_Model->reset_quotation_po_status($po->qtn_id);
		$this->Purchase_Model->delete_po_master($po_id);

		$this->session->set_flashdata('success', 'Purchase Order deleted successfully.');
		redirect('Purchase/po_list');
	}

	// ========================================= purchase return =================
	public function add_purchase_return_records()
	{
		$return_code   = $_POST['return_code'];
		$return_date   = $_POST['return_date'];
		$grn_id        = $_POST['grn_id'];
		$supplier_id   = $_POST['supplier_id'];
		$ref_no        = $_POST['ref_no'];

		$sub_total     = $_POST['sub_total'];
		$discount_per  = $_POST['discount_per'];
		$discount_amt  = $_POST['discount_amt'];
		$vat_per       = $_POST['vat_per'];
		$vat_amount    = $_POST['vat_amount'];
		$grand_total   = $_POST['grand_total'];

		$remarks       = $_POST['remarks'];
		$created_by    = $this->session->userdata('user_id');

		// ================= HEADER INSERT =================
		$data = array(
			'return_code'  => $return_code,
			'return_date'  => $return_date,
			'grn_id'       => $grn_id,
			'supplier_id'  => $supplier_id,
			'ref_no'       => $ref_no,
			'sub_total'    => $sub_total,
			'discount_per' => $discount_per,
			'discount_amt' => $discount_amt,
			'vat_per'      => $vat_per,
			'vat_amount'   => $vat_amount,
			'grand_total'  => $grand_total,
			'remarks'      => $remarks,
			'created_by'   => $created_by
		);

		$this->db->insert('purchase_return', $data);
		$return_id = $this->db->insert_id();


		// ================= ITEMS =================

		$item_id       = $_POST['item_id'];
		$grn_item_id   = $_POST['grn_item_id'];
		$unit_id       = $_POST['item_unit'];
		$grn_qty       = $_POST['grn_qty'];
		$returned_qty  = $_POST['returned_qty'];
		$return_qty    = $_POST['return_qty'];
		$unit_price    = $_POST['unit_price'];
		$total         = $_POST['total_price'];

		for ($i = 0; $i < count($item_id); $i++) {

			if ($return_qty[$i] > 0) {

				$item_data = array(
					'return_id'    => $return_id,
					'grn_item_id'  => $grn_item_id[$i],
					'item_id'      => $item_id[$i],
					'unit_id'      => $unit_id[$i],
					'grn_qty'      => $grn_qty[$i],
					'returned_qty' => $returned_qty[$i],
					'return_qty'   => $return_qty[$i],
					'unit_price'   => $unit_price[$i],
					'total'        => $total[$i]
				);

				$this->db->insert('purchase_return_items', $item_data);


				// ================= UPDATE GRN RETURNED QTY =================
				// $this->db->set('returned_qty', 'returned_qty+' . $return_qty[$i], FALSE);
				// $this->db->where('grn_item_id', $grn_item_id[$i]);
				// $this->db->update('grn_items');


				// ================= STOCK OUT =================
				$stock_out = array(
					'part_id'  => $item_id[$i],
					'qty'      => $return_qty[$i],
					'date_out' => $return_date
				);

				$this->db->insert('stock_out', $stock_out);


				// ================= STOCK LEDGER =================
				$ledger = array(
					'part_id'       => $item_id[$i],
					'txn_type'      => 'PURCHASE_RETURN',
					'qty'           => -$return_qty[$i],
					'unit_id'       => $unit_id[$i],
					'reference_id'  => $return_id,
					'reference_no'  => $return_code,
					'remarks'       => 'Purchase Return',
					'txn_date'      => date('Y-m-d H:i:s'),
					'created_by'    => $created_by
				);

				$this->db->insert('stock_ledger', $ledger);


				// ================= UPDATE STOCK SUMMARY =================
				$this->db->set('current_stock', 'current_stock-' . $return_qty[$i], FALSE);
				$this->db->where('part_id', $item_id[$i]);
				$this->db->update('stock_summary');
			}
		}


		// ================= VOUCHER ENTRY =================

		$voucher_no = $return_code;

		/* Supplier Debit */
		$this->db->insert('voucher_transaction', [
			'voucher_code'   => $voucher_no,
			'voucher_date'   => $return_date,
			'voucher_type'   => 'PURCHASE_RETURN',
			'account_id'     => $supplier_id,
			'amount'         => $grand_total,
			'drcr_type'      => 'DR',
			'narration'      => 'Purchase Return',
			'transaction_no' => $return_code
		]);

		/* Purchase Return Credit */
		$purchase_return_account = 1125;

		$this->db->insert('voucher_transaction', [
			'voucher_code'   => $voucher_no,
			'voucher_date'   => $return_date,
			'voucher_type'   => 'PURCHASE_RETURN',
			'account_id'     => $purchase_return_account,
			'amount'         => $sub_total,
			'drcr_type'      => 'CR',
			'narration'      => 'Purchase Return',
			'transaction_no' => $return_code
		]);

		/* VAT Credit */
		if ($vat_amount > 0) {

			$vat_account = 226;

			$this->db->insert('voucher_transaction', [
				'voucher_code'   => $voucher_no,
				'voucher_date'   => $return_date,
				'voucher_type'   => 'PURCHASE_RETURN',
				'account_id'     => $vat_account,
				'amount'         => $vat_amount,
				'drcr_type'      => 'CR',
				'narration'      => 'VAT on Purchase Return',
				'transaction_no' => $return_code
			]);
		}

		redirect('Purchase/purchase_return_list');
	}
	public function add_purchase_return_records11222()
	{
		$return_code   = $_POST['return_code'];
		$return_date   = $_POST['return_date'];
		$grn_id        = $_POST['grn_id'];
		$supplier_id   = $_POST['supplier_id'];
		$ref_no        = $_POST['ref_no'];

		$sub_total     = $_POST['sub_total'];
		$discount_per  = $_POST['discount_per'];
		$discount_amt  = $_POST['discount_amt'];
		$vat_per       = $_POST['vat_per'];
		$vat_amount    = $_POST['vat_amount'];
		$grand_total   = $_POST['grand_total'];

		$remarks       = $_POST['remarks'];
		$created_by    = $this->session->userdata('user_id');

		// ================= HEADER INSERT =================

		$data = array(
			'return_code'  => $return_code,
			'return_date'  => $return_date,
			'grn_id'       => $grn_id,
			'supplier_id'  => $supplier_id,
			'ref_no'       => $ref_no,
			'sub_total'    => $sub_total,
			'discount_per' => $discount_per,
			'discount_amt' => $discount_amt,
			'vat_per'      => $vat_per,
			'vat_amount'   => $vat_amount,
			'grand_total'  => $grand_total,
			'remarks'      => $remarks,
			'created_by'   => $created_by
		);

		$this->db->insert('purchase_return', $data);

		$return_id = $this->db->insert_id();


		// ================= ITEMS INSERT =================

		$item_id       = $_POST['item_id'];
		$grn_item_id   = $_POST['grn_item_id'];
		$unit_id       = $_POST['item_unit'];
		$grn_qty       = $_POST['grn_qty'];
		$returned_qty  = $_POST['returned_qty'];
		$return_qty    = $_POST['return_qty'];
		$unit_price    = $_POST['unit_price'];
		// $dis_per       = $_POST['dis_percentage'];
		// $dis_amt       = $_POST['dis_amount'];
		$total         = $_POST['total_price'];

		for ($i = 0; $i < count($item_id); $i++) {
			if ($return_qty[$i] > 0) {

				$item_data = array(
					'return_id'   => $return_id,
					'grn_item_id' => $grn_item_id[$i],
					'item_id'     => $item_id[$i],
					'unit_id'     => $unit_id[$i],
					'grn_qty'     => $grn_qty[$i],
					'returned_qty' => $returned_qty[$i],
					'return_qty'  => $return_qty[$i],
					'unit_price'  => $unit_price[$i],
					// 'dis_per'     => $dis_per[$i],
					// 'dis_amt'     => $dis_amt[$i],
					'total'       => $total[$i]
				);

				$this->db->insert('purchase_return_items', $item_data);


				// ================= UPDATE GRN RETURNED QTY =================

				// $this->db->set('returned_qty', 'returned_qty+' . $return_qty[$i], FALSE);
				// $this->db->where('grn_item_id', $grn_item_id[$i]);
				// $this->db->update('grn_items');


				// ================= STOCK UPDATE =================

				for ($i = 0; $i < count($item_id); $i++) {

					if ($return_qty[$i] > 0) {

						$item_data = array(
							'return_id'   => $return_id,
							'grn_item_id' => $grn_item_id[$i],
							'item_id'     => $item_id[$i],
							'unit_id'     => $unit_id[$i],
							'grn_qty'     => $grn_qty[$i],
							'returned_qty' => $returned_qty[$i],
							'return_qty'  => $return_qty[$i],
							'unit_price'  => $unit_price[$i],
							'total'       => $total[$i]
						);

						$this->db->insert('purchase_return_items', $item_data);


						// ================= STOCK OUT =================

						$stock_out = array(
							'part_id'  => $item_id[$i],
							'qty'      => $return_qty[$i],
							'date_out' => $return_date
						);

						$this->db->insert('stock_out', $stock_out);


						// ================= STOCK LEDGER =================

						$ledger = array(
							'part_id'       => $item_id[$i],
							'txn_type'      => 'PURCHASE_RETURN',
							'qty'           => -$return_qty[$i],
							'unit_id'       => $unit_id[$i],
							'reference_id'  => $return_id,
							'reference_no'  => $return_code,
							'remarks'       => 'Purchase Return',
							'txn_date'      => date('Y-m-d H:i:s'),
							'created_by'    => $created_by
						);

						$this->db->insert('stock_ledger', $ledger);


						// ================= UPDATE STOCK SUMMARY =================

						$this->db->set('current_stock', 'current_stock-' . $return_qty[$i], FALSE);
						$this->db->where('part_id', $item_id[$i]);
						$this->db->update('stock_summary');
					}
				}
			}
		}



		// ================= VOUCHER ENTRY =================

		$voucher_no = $return_code;

		/* Supplier Debit */

		$this->db->insert('voucher_transaction', [
			'voucher_code'   => $voucher_no,
			'voucher_date'   => $return_date,
			'voucher_type'   => 'PURCHASE_RETURN',
			'account_id'     => $supplier_id,
			'amount'         => $grand_total,
			'drcr_type'      => 'DR',
			'narration'      => 'Purchase Return',
			'transaction_no' => $return_code
		]);


		/* Purchase Return Credit */

		$purchase_return_account = 1125;

		$this->db->insert('voucher_transaction', [
			'voucher_code'   => $voucher_no,
			'voucher_date'   => $return_date,
			'voucher_type'   => 'PURCHASE_RETURN',
			'account_id'     => $purchase_return_account,
			'amount'         => $sub_total,
			'drcr_type'      => 'CR',
			'narration'      => 'Purchase Return',
			'transaction_no' => $return_code
		]);


		/* VAT Credit */

		if ($vat_amount > 0) {

			$vat_account = 226;

			$this->db->insert('voucher_transaction', [
				'voucher_code'   => $voucher_no,
				'voucher_date'   => $return_date,
				'voucher_type'   => 'PURCHASE_RETURN',
				'account_id'     => $vat_account,
				'amount'         => $vat_amount,
				'drcr_type'      => 'CR',
				'narration'      => 'VAT on Purchase Return',
				'transaction_no' => $return_code
			]);
		}


		redirect('Purchase/purchase_return_list');
	}

	public function purchase_return_list()
	{
		$data['records'] = $this->db
			->select('purchase_return.*, supplier_master.supplier_name')
			->from('purchase_return')
			->join('supplier_master', 'supplier_master.supplier_id = purchase_return.supplier_id', 'left')
			->order_by('purchase_return.return_id', 'DESC')
			->get()
			->result();

		$data['title'] = "Purchase Return List";


		$data['main_content'] = 'purchase/purchase_return_list';
		$this->load->view('includes/template.php', $data);
	}

	public function add_purchase_return()
	{

		// Generate Return Code
		$query = $this->db->select('MAX(return_id) as id')->get('purchase_return')->row();

		$next = $query->id + 1;

		$data['Code'] = 'PR-' . date('Y') . '-' . str_pad($next, 4, '0', STR_PAD_LEFT);


		// Load GRN list
		$data['grn_records'] = $this->db
			->select('grn_id, grn_code')
			->from('purchase_grn_master')
			->order_by('grn_id', 'DESC')
			->get()
			->result();


		$data['title'] = "Add Purchase Return";

		$data['main_content'] = 'purchase/purchase_return.php';
		$this->load->view('includes/template.php', $data);
	}

	public function view_purchase_return($return_id)
	{

		$data['username'] = $this->session->userdata('username');
		$data['userid'] = $this->session->userdata('user_id');
		$data['return'] = $this->db
			->select('purchase_return.*, supplier_master.supplier_name')
			->from('purchase_return')
			->join('supplier_master', 'supplier_master.supplier_id=purchase_return.supplier_id', 'left')
			->where('purchase_return.return_id', $return_id)
			->get()
			->row();

		$data['items'] = $this->db
			->select('purchase_return_items.*, spare_parts.part_name')
			->from('purchase_return_items')
			->join('spare_parts', 'spare_parts.part_id=purchase_return_items.item_id', 'left')
			->where('purchase_return_items.return_id', $return_id)
			->get()
			->result();


		$data['title'] = "View Purchase Return";

		$data['main_content'] = 'purchase/view_purchase_return.php';
		$this->load->view('includes/template.php', $data);
	}
}
