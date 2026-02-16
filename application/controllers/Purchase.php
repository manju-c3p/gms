<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
        $data['title']='Request For Quotation(RFQ)-Direct';		
			

        $prifix='COOL/RFQ/';		
        $num = $this->Setup_model->get_next_code($prifix,'rfq_code','purchase_rfq',13)+1;
        $digit=sprintf("%1$05d",$num);
        $data['Code'] =$prifix.date('y').'/'.$digit;	
        $data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
	
        $data['active_items'] = $this->SpareParts_model->get_all_parts();
        $data['active_units'] = $this->Setup_model->get_active_unit_list();	
		$data['main_content']='purchase/rfq_direct_add.php';
		$this->load->view('includes/template.php',$data);
        
    }
    function add_direct_rfq_records()
   {    
	   $data['title']='Request For Quotation(RFQ)';
	   $this->load->model('Purchase_Model');
	   $id=$this->Purchase_Model->add_direct_rfq_records();
	   
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
        $data['title']='Request For Quotation(RFQ)';
        $this->load->model('Purchase_Model');
        $data['records']=$this->Purchase_Model->get_RFQ_list();
        $data['main_content']='purchase/rfq_direct_list.php';
        $this->load->view('includes/template.php',$data);
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

            if($data['view_only'] == 0){
                $data['title']='Edit RFQ';
            }else{
                $data['title']='View RFQ';
            }
        $data['active_items'] = $this->SpareParts_model->get_all_parts();
        $data['active_units'] = $this->Setup_model->get_active_unit_list();	
        $data['supplier_records'] = $this->Supplier_model->get_all_supplier_list();
        $data['records1'] = $this->Purchase_Model->get_purchase_rfq_by_id($rfq_id);
        $data['records2'] = $this->Purchase_Model->get_purchase_rfq_tr($rfq_id);
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
  
    $prifix='AVE/SQT/';
    $this->load->model('Setup_model');
    $num = $this->Setup_model->get_next_code($prifix,'quotation_code','purchase_quotation_master',12)+1;
    $digit=sprintf("%1$04d",$num);
    $data['Code'] =$prifix.date("y").'/'.$digit;
    $this->load->model('Purchase_Model');
    $data['records'] = $this->Purchase_Model->get_RFQ_list('direct');
    $this->load->model('Setup_model');
     $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
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
    if(!has_access($user,'Purchase/purchase_quotation_list','E')){
        $data['title'] = 'Access Denied';
        $data['main_content']='errors/access_control.php';
    }
    else{
        $this->load->model('Setup_model');
        $quotation_id = $this->uri->segment('3');
        $data['view_only'] = $this->uri->segment('4');

        if($data['view_only'] == 0){
            $data['title']='Edit Quotation';
        }else{
            $data['title']='View Quotation';
        }
   
    $data['records1'] = $this->Purchase_Model->get_pur_qtn_master_by_id($quotation_id);
    $data['records2'] = $this->Purchase_Model->get_pur_qtn_tr_by_id($quotation_id);
    $data['quote_doc'] = $this->Purchase_Model->get_quote_doc($quotation_id,"Quote File");
    $data['active_units'] = $this->Item_model->get_active_unit_list();
    $data['main_content'] = 'purchase/quotation_edit.php';
     }
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
        if(!has_view_access($user,'Purchase/list_direct_rfq')){
            $data['title'] = 'Access Denied';
            $data['main_content']='errors/access_control.php';
            $this->load->view('includes/template',$data);
        }
        else{
            $quotation_id = $this->uri->segment('3');
            $data['quote_tr'] = $this->Purchase_Model->get_pur_qtn_tr_by_id($quotation_id);	
            $data['quote'] = $this->Purchase_Model->get_pur_qtn_master_by_id($quotation_id);
            $data['comp_details'] = $this->Setup_model->get_company_details();
            $this->load->view('purchase/print/quotation_print.php',$data);
            
            
        }
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
   public function delete_quote_protected() {
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
    $prifix='AVE/POD/';
    $this->load->model('Setup_model');
    $num = $this->Setup_model->get_next_code($prifix,'po_code','purchase_order_master',12)+1;
    $digit=sprintf("%1$04d",$num);
    $data['Code'] =$prifix.date("y").'/'.$digit;
    	
	$data['records']=$this->Purchase_Model->get_quotation_list();
	$this->load->model('Setup_model');

	$data['main_content']='purchase/po_add.php';
	$this->load->view('includes/template.php',$data);
  }
  function add_po_records()
  {    
       $data['title']='Purchase Order';
	   $this->load->model('Purchase_Model');
	   $this->Purchase_Model->add_purchase_order();
	    
	   echo "<script>
            alert('Purchase Order Saved Successfully.');
            window.location.href='" . site_url('Purchase/purchase_order_list') . "';
        </script>";
	   
   }

  function purchase_order_list()
  {
        $data['title']='Purchase Order List';
	    $this->load->model('Purchase_Model');
        $data['records']=$this->Purchase_Model->get_po_list();
	    
	    $data['main_content']='purchase/po_list.php';
	    $this->load->view('includes/template.php',$data);
  }
  function print_po(){
    $user = $this->session->userdata('user_id');
    $data['comp_details'] = $this->Setup_model->get_company_details();
        if(!has_view_access($user,'Purchase/purchase_order_list')){
            $data['title'] = 'Access Denied';
            $data['main_content']='errors/access_control.php';
            $this->load->view('includes/template',$data);
        }
        else{
            $po_id = $this->uri->segment('3');
            $data['po_tr'] = $this->Purchase_Model->get_po_tr_by_id($po_id);	
            $data['po'] = $this->Purchase_Model->get_po_master_by_id($po_id);

            $this->load->view('purchase/print/po_print.php',$data);
            
            
         }
  }
  function approve_po(){
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
    if(!has_access($user,'Purchase/purchase_order_list','E')){
        $data['title'] = 'Access Denied';
        $data['main_content']='errors/access_control.php';
    }
    else{
        $this->load->model('Setup_model');
        $po_id = $this->uri->segment('3');
        $data['view_only'] = $this->uri->segment('4');

        if($data['view_only'] == 0){
            $data['title']='Edit Purchase Order';
        }else{
            $data['title']='View Purchase Order';
        }
   
    $data['records1'] = $this->Purchase_Model->get_po_master_by_id($po_id);
    $data['records2'] = $this->Purchase_Model->get_po_tr_by_id($po_id);
    $data['po_doc']   = $this->Purchase_Model->get_quote_doc($po_id,"PO File");
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['active_units'] = $this->Item_model->get_active_unit_list();
    // echo '<pre>';print_r($data);exit;
   if ($data['records1'][0]->qtn_id == 0) 
    { 
        $data['main_content'] = 'purchase/po_direct_edit.php';
    }else{
        $data['main_content'] = 'purchase/po_edit.php';
    }
    
    //  echo '<pre>';print_r($data);exit;
     }
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
   	$data['title']='Purchase Order-Stock';
    error_reporting(0);

	$this->load->model('Purchase_Model');
	$data['records']=$this->Purchase_Model->get_RFQ_list('direct');	
    $data['active_items'] = $this->Item_model->get_active_item_list();
	$data['active_units'] = $this->Item_model->get_active_unit_list();  
    $this->load->model('Setup_model');
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['reorder_list']=$this->Stock_model->get_reorder_stock_for_PO();
    echo '<pre>';print_r($data);exit;
	$data['main_content']='purchase/po_direct_add.php';
	$this->load->view('includes/template.php',$data);
  }
function add_grn()
  {
    $data['title'] = 'Good Received Note';
    $prifix='AVE/GRN/';
    $this->load->model('Setup_model');
    $num = $this->Setup_model->get_next_code($prifix,'grn_code','purchase_grn_master',12)+1;
    $digit=sprintf("%1$04d",$num);
    $data['Code'] =$prifix.date("y").'/'.$digit;
    $data['warehouse_list'] = $this->Setup_model->get_warehouse_list();
   
	$data['records']=$this->Purchase_Model->get_approved_po_list();
	$this->load->model('Setup_model');
	$data['main_content']='purchase/grn_add.php';
	$this->load->view('includes/template.php',$data);
  }
  function add_grn_records()
  {    
	   $this->Purchase_Model->add_grn_records();	    
	    echo "<script>
        alert('GRN Saved!');
        window.location.href='" . site_url('Purchase/purchase_grn_list') . "';
        </script>";
   }
   function purchase_grn_list(){
        $data['title']='Purchase GRN List';
        $data['records']=$this->Purchase_Model->get_grn_list();	    
	    $data['main_content']='purchase/grn_list.php';
	    $this->load->view('includes/template.php',$data);
   }
   function print_grn(){
    $user = $this->session->userdata('user_id');
     $data['comp_details'] = $this->Setup_model->get_company_details();
        if(!has_view_access($user,'Purchase/purchase_grn_list')){
            $data['title'] = 'Access Denied';
            $data['main_content']='errors/access_control.php';
            $this->load->view('includes/template',$data);
        }
        else{
            $grn_id = $this->uri->segment('3');
            $data['grn_tr'] = $this->Purchase_Model->get_grn_tr_by_id($grn_id);	
            $data['grn'] = $this->Purchase_Model->get_grn_master_by_id($grn_id);
            echo '<pre>';print_r($data);exit;
            $this->load->view('purchase/print/grn_print.php',$data);
            
            
         }
  }
  function print_grn_barcode(){
    $user = $this->session->userdata('user_id');
        if(!has_view_access($user,'Purchase/purchase_grn_list')){
            $data['title'] = 'Access Denied';
            $data['main_content']='errors/access_control.php';
            $this->load->view('includes/template',$data);
        }
        else{
            $grn_id = $this->uri->segment('3');
            $data['grn_tr'] = $this->Purchase_Model->get_grn_tr_by_id($grn_id);	
            $data['grn'] = $this->Purchase_Model->get_grn_master_by_id($grn_id);
            
            $this->load->view('purchase/print/grn_barcode_print.php',$data);
            
            
         }
  }
  function delete_grn()
  {
	$grn_id=$this->input->post('grn_id');
	$this->load->model('Purchase_Model');
	$this->Purchase_Model->delete_grn($grn_id);
      echo "<script>
        alert('GRN Saved!');
        window.location.href='" . site_url('Purchase/purchase_grn_list') . "';
        </script>";
	
  }
  function direct_po(){
    $data['title'] = 'Direct Purchase Order';
  
    $prifix='AVE/POD/';
    $this->load->model('Setup_model');
    $num = $this->Setup_model->get_next_code($prifix,'po_code','purchase_order_master',12)+1;
    $digit=sprintf("%1$04d",$num);
    $data['Code'] =$prifix.date("y").'/'.$digit;
    	
	$data['records']=$this->Purchase_Model->get_quotation_list();
	$this->load->model('Setup_model');
    $this->load->model('Item_model');
    $data['active_items'] = $this->Item_model->get_active_item_list();
	$data['active_units'] = $this->Item_model->get_active_unit_list();  
    	

    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['main_content'] = 'purchase/po_direct_add.php';
    $this->load->view('includes/template.php', $data);
  }

  function direct_quote(){
    $data['title'] = 'Direct Supplier Quote';  
    $prifix='AVE/QTN/';
    $this->load->model('Setup_model');
    $num = $this->Setup_model->get_next_code($prifix,'quotation_code','purchase_quotation_master',12)+1;
    $digit=sprintf("%1$04d",$num);
    $data['Code'] =$prifix.date("y").'/'.$digit;
    	
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
echo $po_id;exit;
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


}
