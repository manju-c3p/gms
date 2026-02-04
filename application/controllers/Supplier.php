<?php

/**

 * supplier add,delete,edit,update

 */

class Supplier extends CI_Controller {	

	public function __construct()
    {
             parent::__construct();
           	//  $this->is_logged_in();
    }		

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	

			die();
			//$this->load->view('login/login_form');
		}		
	}		

///////////////////////////////////////supplier Details Start////////////////////////////////////////////// 

	function add_supplier() {
		$data['title'] = "Supplier Details";
		$this->load->model('supplier/supplier_model');
		$data['supplier_records']=$this->supplier_model->get_records_sort_by_order();	
		$data['record_supplier']=$this->supplier_model->get_supplier_type_list();
		$data['su_id']="";
		$data['main_content'] = 'supplier/add_supplier';
		$this->load->view('includes/template', $data);

	}	
	function view_supplier_list() {
		$this->load->model('supplier/supplier_model');
		$data['record_supplier']=$this->supplier_model->get_supplier();
		$data['main_content'] = 'supplier/supplier_list';
		$this->load->view('includes/template', $data);
	}

	function add_supplier_with_id($su_id) {
		$data['title'] = "Supplier Details";
		$this->load->model('supplier/supplier_model');
		$data['supplier_records']=$this->supplier_model->get_records_sort_by_order();	
		$data['su_id']=$su_id;
		$data['main_content'] = 'supplier/add_supplier';
		$this->load->view('includes/template', $data);
	}	

	function add_supplier_data()
	{
		$data['title'] = "Supplier Details";
		$this->load->model('occupier/occupier_model');
		$group_id = $this->occupier_model->get_group_number('Vendors/Suppliers');
		
		$this->load->model('supplier/supplier_model');
		$flag=$this->supplier_model->add_supplier_record($group_id);
		if($flag == 0)
		{
			$this->session->set_flashdata('success','Record Successfully Saved');
			redirect('supplier/view_supplier_list');
		}	
		else
		{
			$this->session->set_flashdata('warning','Supplier Company Name Already Exist');
			redirect('supplier/add_supplier');		
			//$data['main_content'] = 'pmc/error_insert_message';
			//$this->load->view('includes/template', $data);
		}
	}	

	function edit_supplier()
	{
		$data['title'] = "Supplier Details";
		$id =$this->input->post('sup');
		$this->load->model('supplier/supplier_model');
		$data['supplier_records']=$this->supplier_model->get_records();
		$data['supplier_details']=$this->supplier_model->get_records_by_id($id);
		$data['record_supplier']=$this->supplier_model->get_supplier_type_list();
		$data['su_id']=$id;
		$data['main_content'] = 'supplier/edit_supplier';
		$this->load->view('includes/template', $data);
	}

	function edit_supplier_data()
	{
		$data['title'] = "Supplier Details";
		$this->load->model('supplier/supplier_model');
		$id = $this->supplier_model->update_record_by_id();	
		if($id!='')
		{
			$this->session->set_flashdata('success','Record Successfully Updated');
			redirect('supplier/view_supplier_list');	
		}
	}	
	
	function delete_supplier()
	{
		$id = $this->input->post('post_id');
		$this->load->model('supplier/supplier_model');		
		$this->supplier_model->delete_record($id);
		echo json_encode("success");
	}
	
	
	function view_supplier_type() {
		$data['main_content'] = 'supplier/add_supplier_type_master.php';
		$this->load->view('includes/template', $data);
	}
	
	function view_supplier_type_list() {
		$this->load->model('supplier/supplier_model');
		$data['record_supplier']=$this->supplier_model->get_supplier_type_list();
		$data['main_content'] = 'supplier/supplier_type_list';
		$this->load->view('includes/template', $data);
	}
	
	function edit_supplier_type() {
		$this->load->model('supplier/supplier_model');
		$data['record_supplier']=$this->supplier_model->get_supplier_type_list_id();
		$data['main_content'] = 'supplier/edit_supplier_type';
		$this->load->view('includes/template', $data);
	}
	
	function add_supplier_type() {
		$this->load->model('supplier/supplier_model');
		$id = $this->supplier_model->add_supplier_type();	
		if($id!='') {
			$this->session->set_flashdata('success','Record Successfully Updated');
			redirect('supplier/view_supplier_type_list');	
		}
		else {
			$this->session->set_flashdata('warning','Supplier Company Name Already Exist');
			redirect('supplier/view_supplier_type');		
		}
	}
	
	function update_supplier_type() {
		$this->load->model('supplier/supplier_model');
		$id = $this->supplier_model->update_supplier_type();	
		if($id!='') {
			$this->session->set_flashdata('success','Record Successfully Updated');
			redirect('supplier/view_supplier_type_list');	
		}
		else {
			$this->session->set_flashdata('warning','Supplier Company Name Already Exist');
			redirect('supplier/edit_supplier_type');		
		}
	}
	
	function get_supplier()
	{
		
	$this->load->model('supplier/supplier_model');
	$data['rec'] = $this->supplier_model->get_supplier_records_using_supplier_type();
	$this->load->view('ajax/select_supplier.php',$data);	
		
	}
	
	
//////////////////////////////////////Supplier Details End/////////////////////////////////////////////
	
	
	
}



?>

