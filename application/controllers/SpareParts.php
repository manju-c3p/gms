<?php
class SpareParts extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('SpareParts_model');
		$this->load->model('Stock_model');
		$this->load->model('Supplier_model');
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
		$data['units'] = $this->Supplier_model->get_units();

		$data['main_content'] = 'inventory/parts_add_form';
		$this->load->view('includes/template', $data);
	}


	public function save()
	{
		$part_name = $this->input->post('part_name');
		$part_type = $this->input->post('parttype');

		// ✅ Check duplicate
		if ($this->SpareParts_model->part_exists($part_name, $part_type)) {

			$this->session->set_flashdata(
				'error',
				'Part already exists with the same type!'
			);
			redirect('SpareParts/add'); // change if your add page differs
			return;
		}

		if (
			$this->input->post('purchase_unit_id')
			== $this->input->post('stock_unit_id')
			&& $this->input->post('qty_per_purchase_unit') != 1
		) {

			// optional warning
		}

		$data = [
			'part_name' => $part_name,
			'part_code' => $this->input->post('part_code'),
			'brand_id' => $this->input->post('brand_id'),
			'vehicle_model_id' => $this->input->post('vehicle_model_id'),
			'unit_price' => $this->input->post('unit_price'),
			'min_stock' => $this->input->post('min_stock'),
			'part_type' => $part_type,
			'warrenty' => $this->input->post('warrenty'),
			'labeling' => $this->input->post('labeling'),

			'purchase_unit_id' => $this->input->post('purchase_unit_id'),
			'stock_unit_id' => $this->input->post('stock_unit_id'),
			'qty_per_purchase_unit' => $this->input->post('qty_per_purchase_unit'),
		];

		$this->SpareParts_model->add_part($data);

		$this->session->set_flashdata('success', 'Part added successfully!');
		redirect('SpareParts');
	}

	// Edit
	public function edit($part_id)
	{

		$data['title'] = "Inventory";
		$data['brands'] = $this->SpareParts_model->get_all_brands();
		$data['part'] = $this->SpareParts_model->get_part($part_id);
		$data['units'] = $this->Supplier_model->get_units();
		$stock = $this->db
			->select('current_stock')
			->where('part_id', $part_id)
			->get('stock_summary')
			->row();

		$data['has_stock'] = ($stock && $stock->current_stock > 0);

		$data['main_content'] = 'inventory/parts_edit_form';
		$this->load->view('includes/template', $data);
	}


	public function update()
	{
		$part_id   = $this->input->post('part_id');
		$part_name = $this->input->post('part_name');
		$part_type = $this->input->post('parttype');

		// ✅ Check duplicate excluding current row
		// if ($this->SpareParts_model->part_exists($part_name, $part_type, $part_id)) {

		// 	$this->session->set_flashdata(
		// 		'error',
		// 		'Another part with the same name and type already exists!'
		// 	);
		// 	redirect('SpareParts/edit/' . $part_id);
		// 	return;
		// }

		$data = [
			'part_name' => $part_name,
			'part_code' => $this->input->post('part_code'),
			'unit_price' => $this->input->post('unit_price'),
			'min_stock' => $this->input->post('min_stock'),
			'part_type' => $part_type,
			'brand_id' => $this->input->post('brand_id'),
			'vehicle_model_id' => $this->input->post('vehicle_model_id'),
			'warrenty' => $this->input->post('warrenty'),
			'labeling' => $this->input->post('labeling'),
			'purchase_unit_id' => $this->input->post('purchase_unit_id'),
			'stock_unit_id' => $this->input->post('stock_unit_id'),
			'qty_per_purchase_unit' => $this->input->post('qty_per_purchase_unit'),
		];

		$this->SpareParts_model->update_part($part_id, $data);

		$this->session->set_flashdata('success', 'Part updated successfully!');
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



	public function get_part()
	{
		$id = $this->input->post('item_id');

		if (!$id) {
			echo json_encode(['error' => 'Missing Item ID']);
			return;
		}

		// fetch part
		echo json_encode($this->SpareParts_model->get_part_rfq($id));
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
			'labeling' => $labelling
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

	public function initialize_opening_stockold()
	{
		$this->db->trans_start();

		$parts = $this->db->get('spare_parts')->result();

		foreach ($parts as $part) {
			$part_id = $part->part_id;
			$stock_unit_id = $part->stock_unit_id;

			/* 1. stock_in */
			$this->db->insert('stock_in', [
				'part_id' => $part_id,
				'qty' => 1,
				'date_in' => date('Y-m-d'),
				'created_at' => date('Y-m-d H:i:s')
			]);

			$stock_in_id = $this->db->insert_id();

			/* 2. stock_ledger */
			$this->db->insert('stock_ledger', [
				'part_id' => $part_id,
				'txn_type' => 'OPENING',
				'qty' => 1,
				'unit_id' => $stock_unit_id,
				'reference_id' => $stock_in_id,
				'reference_no' => 'OPENING-STOCK',
				'remarks' => 'Opening stock initialization',
				'txn_date' => date('Y-m-d H:i:s'),
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id')
			]);

			/* 3. stock_summary */
			$this->db->insert('stock_summary', [
				'part_id' => $part_id,
				'current_stock' => 1,
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}

		$this->db->trans_complete();

		return true;
	}
	public function initialize_opening_stock()
	{
		$this->db->trans_start();

		/* ========= STEP 1: CLEAR OLD STOCK DATA ========= */

		// Disable foreign key checks temporarily (important)
		$this->db->query('SET FOREIGN_KEY_CHECKS = 0');

		$this->db->truncate('stock_in');
		$this->db->truncate('stock_out');
		$this->db->truncate('stock_ledger');
		$this->db->truncate('stock_summary');

		$this->db->query('SET FOREIGN_KEY_CHECKS = 1');


		/* ========= STEP 2: INITIALIZE OPENING STOCK ========= */

		$parts = $this->db->get('spare_parts')->result();

		foreach ($parts as $part) {

			$part_id = $part->part_id;
			$stock_unit_id = $part->stock_unit_id ?: 1;

			/* stock_in */
			$this->db->insert('stock_in', [
				'part_id'    => $part_id,
				'qty'        => 0,
				'date_in'    => date('Y-m-d'),
				'created_at' => date('Y-m-d H:i:s')
			]);

			$stock_in_id = $this->db->insert_id();


			/* stock_ledger */
			$this->db->insert('stock_ledger', [
				'part_id'      => $part_id,
				'txn_type'     => 'OPENING',
				'qty'          => 0,
				'unit_id'      => $stock_unit_id,
				'reference_id' => $stock_in_id,
				'reference_no' => 'OPENING-STOCK',
				'remarks'      => 'Opening stock initialization',
				'txn_date'     => date('Y-m-d H:i:s'),
				'created_at'   => date('Y-m-d H:i:s'),
				'created_by'   => $this->session->userdata('user_id')
			]);


			/* stock_summary */
			$this->db->insert('stock_summary', [
				'part_id'       => $part_id,
				'current_stock' => 0,
				'updated_at'    => date('Y-m-d H:i:s')
			]);
		}

		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}
