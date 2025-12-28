<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inspection_model extends CI_Model
{
	private $table = 'inspection_items';

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
		$this->db->where('inspection_id', $inspection_id)
			->delete('inspection_services');

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

}
