<?php
class SpareParts extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('SpareParts_model');
		$this->load->model('Stock_model');
	}

	// List
	public function index()
	{
		$parts = $this->SpareParts_model->get_all_parts();

		// attach stock
		foreach ($parts as $p) {
			$p->stock = $this->SpareParts_model->get_stock($p->part_id);
		}

		$data['parts'] = $parts;
		$data['title'] = "Inventory";
		$data['main_content'] = 'inventory/parts_list';
		$this->load->view('includes/template', $data);
	}

	// Add form
	public function add()
	{


		$data['title'] = "Inventory";
		$data['brands'] = $this->SpareParts_model->get_all_brands();

		$data['main_content'] = 'inventory/parts_add_form';
		$this->load->view('includes/template', $data);
	}

	// Save new part
	public function save()
	{
		$data = [
			'part_name' => $this->input->post('part_name'),
			'part_code' => $this->input->post('part_code'),
			'brand_id' => $this->input->post('brand_id'),
			'vehicle_model_id' => $this->input->post('vehicle_model_id'),
			'unit_price' => $this->input->post('unit_price'),
			'min_stock' => $this->input->post('min_stock'),
			'part_type' => $this->input->post('parttype'),
			'warrenty' => $this->input->post('warrenty'),
			'labeling' => $this->input->post('labeling'),
		];

		$this->SpareParts_model->add_part($data);
		redirect('SpareParts');
	}

	// Edit
	public function edit($part_id)
	{

		$data['title'] = "Inventory";
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['part'] = $this->SpareParts_model->get_part($part_id);


		$data['main_content'] = 'inventory/parts_edit_form';
		$this->load->view('includes/template', $data);
	}

	// Update
	public function update()
	{
		$part_id = $this->input->post('part_id');

		$data = [
			'part_name' => $this->input->post('part_name'),
			'part_code' => $this->input->post('part_code'),
			'unit_price' => $this->input->post('unit_price'),
			'min_stock' => $this->input->post('min_stock'),
			'part_type' => $this->input->post('parttype'),
			'brand_id' => $this->input->post('brand_id'),
			'vehicle_model_id' => $this->input->post('vehicle_model_id'),
			'warrenty' => $this->input->post('warrenty'),
			'labeling' => $this->input->post('labeling'),
		];

		$this->SpareParts_model->update_part($part_id, $data);
		redirect('SpareParts');
	}

	// Delete
	public function delete($part_id)
	{
		$this->SpareParts_model->delete_part($part_id);
		redirect('SpareParts');
	}

	// Stock In Screen
	public function stock_in_form($part_id)
	{
		$data['part'] = $this->SpareParts_model->get_part($part_id);

		$data['title'] = "Stock In";
		$data['main_content'] = 'inventory/stock_in_form';
		$this->load->view('includes/template', $data);
	}

	// Save Stock In
	public function stock_in_save()
	{
		$data = [
			'part_id' => $this->input->post('part_id'),
			'qty' => $this->input->post('qty'),
			'date_in' => $this->input->post('date_in'),
		];

		$this->Stock_model->stock_in($data);
		redirect('SpareParts');
	}

	// Stock Out Screen
	public function stock_out_form($part_id)
	{
		$data['part'] = $this->SpareParts_model->get_part($part_id);

		$data['title'] = "Stock In";
		$data['main_content'] = 'inventory/stock_out_form';
		$this->load->view('includes/template', $data);
	}

	// Save Stock Out
	public function stock_out_save()
	{
		$data = [
			'part_id' => $this->input->post('part_id'),
			'qty' => $this->input->post('qty'),
			'date_out' => $this->input->post('date_out'),
		];

		$this->Stock_model->stock_out($data);
		redirect('SpareParts
		');
	}

	public function low_stock()
	{
		$parts = $this->SpareParts_model->get_all_parts();
		$low_stock = [];

		foreach ($parts as $p) {
			$current_stock = $this->SpareParts_model->get_stock($p->part_id);

			if ($current_stock < $p->min_stock) {
				$p->current_stock = $current_stock;
				$low_stock[] = $p;
			}
		}

		$data['low_stock'] = $low_stock;

		$data['title'] = "Low Stock";
		$data['main_content'] = 'inventory/low_stock_list';
		$this->load->view('includes/template', $data);
	}

	// ===============================================

	public function get_models_by_brand($brand_id)
	{

		echo json_encode($this->SpareParts_model->get_models_by_brand($brand_id));
	}

	public function save_brand()
	{

		$this->SpareParts_model->save_brand($this->input->post('name'));
	}

	public function save_model()
	{

		$this->SpareParts_model->save_model(
			$this->input->post('brand_id'),
			$this->input->post('name')
		);
	}


	public function save_ajax()
	{
		$part_name  = trim($this->input->post('part_name'));
		$unit_price = $this->input->post('unit_price');
		$part_type  = $this->input->post('part_type'); // New / After / Used
		$labelling = $this->input->post('labeling'); 

		if ($part_name == '' || $part_type == '') {
			echo json_encode([
				'status' => 'error',
				'message' => 'Part name & type required'
			]);
			return;
		}

		$insertData = [
			'part_name' => $part_name,
			'unit_price' => $unit_price ?: 0,
			'part_type' => $part_type,
			'created_at' => date('Y-m-d H:i:s'),
			'min_stock' => 1,
			'labeling'=>$labelling
		];

		// $opening_qty = (int) $this->input->post('opening_qty');

		$opening_qty = 100;

		$part_id = $this->SpareParts_model->insert_part($insertData, $opening_qty);
		$part    = $this->SpareParts_model->get_part($part_id);

		echo json_encode([
			'status' => 'success',
			'part'   => $part
		]);
	}
}
