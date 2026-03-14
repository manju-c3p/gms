<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inspection_model extends CI_Model
{
	private $table = 'inspection_items';
	private $table1 = 'inspection_packages';
	// Get all inspection items
	public function get_all_items()
	{
		return $this->db
			->where('is_active', 1)
			->order_by('item_id', 'ASC')
			->get($this->table)
			->result();
	}

	// Insert new inspection item
	public function insert_item($data)
	{
		return $this->db->insert($this->table, $data);
	}

	// Get item by ID
	public function get_item($id)
	{
		return $this->db
			->where('item_id', $id)
			->get($this->table)
			->row();
	}

	// Update inspection item
	public function update_item($id, $data)
	{
		return $this->db
			->where('item_id', $id)
			->update($this->table, $data);
	}

	// Soft delete
	public function delete_item($id)
	{
		return $this->db
			->where('item_id', $id)
			->update($this->table, ['is_active' => 0]);
	}


	/* ---------------- MAIN INSPECTION ---------------- */

	public function update_inspection($inspection_id, $data)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->update('inspections', $data);
	}

	/* ---------------- INSPECTION ITEMS (A/C/S) ---------------- */

	public function save_item_result($inspection_id, $item_id, $status)
	{
		$this->db->replace('inspection_item_results', [
			'inspection_id' => $inspection_id,
			'item_id'       => $item_id,
			'status'        => $status
		]);
	}

	/* ---------------- SERVICES / DESCRIPTION ---------------- */

	public function save_inspection_services($inspection_id, $service_ids, $custom_services)
	{
		// Clear old services
		// $this->db->where('inspection_id', $inspection_id)
		// 	->delete('inspection_services');

		foreach ($service_ids as $index => $service_id) {

			$data = [
				'inspection_id' => $inspection_id,
				'service_id'    => ($service_id !== 'custom') ? $service_id : null,
				'custom_text'   => ($service_id === 'custom')
					? ($custom_services[$index] ?? '')
					: null
			];

			$this->db->insert('inspection_services', $data);
		}
	}

	/* ---------------- WORKS REQUESTED ---------------- */

	public function save_works_requested($inspection_id, $works)
	{
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_works_requested');

		foreach ($works as $work_id) {
			$this->db->insert('inspection_works_requested', [
				'inspection_id' => $inspection_id,
				'work_id'       => $work_id
			]);
		}
	}

	/* ---------------- INVENTORY STATUS ---------------- */

	public function save_inventory_status($inspection_id, $items)
	{
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_inventory_status');

		foreach ($items as $inv_id) {
			$this->db->insert('inspection_inventory_status', [
				'inspection_id'       => $inspection_id,
				'inventory_status_id' => $inv_id
			]);
		}
	}

	public function get_damage_marks($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->get('inspection_damage_marks')
			->result();
	}
	public function get_by_id($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->get('inspections')
			->row();
	}

	public function get_item_results($inspection_id)
	{
		$results = [];

		$query = $this->db
			->where('inspection_id', $inspection_id)
			->get('inspection_item_results')
			->result();

		foreach ($query as $row) {
			$results[$row->item_id] = $row->status;
		}

		return $results;
	}


	public function get_selected_works($inspection_id)
	{
		return array_column(
			$this->db
				->select('work_id')
				->where('inspection_id', $inspection_id)
				->get('inspection_works_requested')
				->result_array(),
			'work_id'
		);
	}
	public function get_selected_inventory($inspection_id)
	{
		return array_column(
			$this->db
				->select('inventory_status_id')
				->where('inspection_id', $inspection_id)
				->get('inspection_inventory_status')
				->result_array(),
			'inventory_status_id'
		);
	}


	public function get_saved_services($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->get('inspection_services')
			->result();
	}

	/**
	 * Get all inspections with customer & vehicle details
	 */
	public function get_all_inspections()
	{
		return $this->db
			->select('
                i.inspection_id,
                i.inspection_date,
                i.inspection_time,
				i.appointment_id,
                i.status,
                i.km_reading,
                i.fuel_level,
				i.revision_no,
                c.name AS customer_name,
                c.phone AS customer_phone,

                v.registration_no,
                v.brand,
                v.model
            ')
			->from('inspections i')
			->join('customers c', 'c.customer_id = i.customer_id')
			->join('vehicles v', 'v.vehicle_id = i.vehicle_id')
			->order_by('i.created_at', 'DESC')
			->get()
			->result();
	}

	/**
	 * Delete inspection (hard delete for now)
	 */
	public function delete_inspection($inspection_id)
	{
		$this->db->trans_start();

		// 1. Damage marks
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_damage_marks');

		// 2. Inventory status
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_inventory_status');

		// 3. Item results
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_item_results');

		// 4. Photos
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_photos');

		// 5. Services
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_services');

		// 6. Works requested
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_works_requested');

		// 7. MAIN inspection record (LAST)
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspections');

		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	public function delete_damage_marks($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->delete('inspection_damage_marks');
	}
	public function delete_inventory_status($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->delete('inspection_inventory_status');
	}
	public function delete_item_results($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->delete('inspection_item_results');
	}
	public function delete_photos($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->delete('inspection_photos');
	}
	public function delete_services($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->delete('inspection_services');
	}
	public function delete_works_requested($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->delete('inspection_works_requested');
	}
	public function delete_inspection_main($inspection_id)
	{
		return $this->db
			->where('inspection_id', $inspection_id)
			->delete('inspections');
	}

	public function save_inspection_photos($inspection_id, $files)
	{
		// 1. Delete existing DB records (files already handled separately if needed)
		// $this->db->where('inspection_id', $inspection_id)
		// 	->delete('inspection_photos');

		// 2. No new files → stop here
		if (empty($files['name'][0])) {
			return;
		}

		$this->load->library('upload');

		foreach ($files['name'] as $key => $name) {

			$_FILES['photo']['name']     = $files['name'][$key];
			$_FILES['photo']['type']     = $files['type'][$key];
			$_FILES['photo']['tmp_name'] = $files['tmp_name'][$key];
			$_FILES['photo']['error']    = $files['error'][$key];
			$_FILES['photo']['size']     = $files['size'][$key];

			$config = [
				'upload_path'   => './uploads/inspection/',
				'allowed_types' => 'jpg|jpeg|png',
				'encrypt_name'  => TRUE
			];

			$this->upload->initialize($config);

			if ($this->upload->do_upload('photo')) {

				$img = $this->upload->data();

				$this->db->insert('inspection_photos', [
					'inspection_id' => $inspection_id,
					'image_path'    => 'uploads/inspection/' . $img['file_name']
				]);
			}
		}
	}


	// ================================================

	public function get_all_packageitems()
	{
		return $this->db

			->order_by('id', 'ASC')
			->get($this->table1)
			->result();
	}

	public function insert_packageitem($data)
	{
		return $this->db->insert($this->table1, $data);
	}

	public function update_packageitem($id, $data)
	{
		return $this->db
			->where('id', $id)
			->update($this->table1, $data);
	}
	public function delete_packageitem($id)
	{
		return $this->db
			->where('id', $id)
			->delete('inspection_packages');
	}

	public function get_packageitem($id)
	{
		return $this->db
			->where('id', $id)
			->get($this->table1)
			->row();
	}

	public function create($data)
	{
		$this->db->insert('inspections', $data);
		return $this->db->insert_id();
	}
}
