<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_status_model extends CI_Model
{
	private $table = 'inventory_status_master';

	public function get_all()
	{
		return $this->db
			->where('is_active', 1)
			->order_by('status_name', 'ASC')
			->get($this->table)
			->result();
	}

	public function get_by_id($id)
	{
		return $this->db
			->where('inventory_status_id', $id)
			->get($this->table)
			->row();
	}

	public function insert($data)
	{
		return $this->db->insert($this->table, $data);
	}

	public function update($id, $data)
	{
		return $this->db
			->where('inventory_status_id', $id)
			->update($this->table, $data);
	}

	public function delete($id)
	{
		return $this->db
			->where('inventory_status_id', $id)
			->update($this->table, ['is_active' => 0]);
	}

	// ==================================================


	/* ===============================
       GET AVAILABLE STOCK
    ================================ */
	public function get_available_stock($part_id)
	{
		// Total IN
		$in = $this->db
			->select('IFNULL(SUM(qty),0) AS total_in', false)
			->from('stock_in')
			->where('part_id', $part_id)
			->get()
			->row()
			->total_in;

		// Total OUT
		$out = $this->db
			->select('IFNULL(SUM(qty),0) AS total_out', false)
			->from('stock_out')
			->where('part_id', $part_id)
			->get()
			->row()
			->total_out;

		return (int)$in - (int)$out;
	}

	/* ===============================
       DEDUCT STOCK
    ================================ */
	public function deduct_stock($part_id, $qty)
	{
		return $this->db->insert('stock_out', [
			'part_id'  => $part_id,
			'qty'      => $qty,
			'date_out' => date('Y-m-d'),
			'created_at' => date('Y-m-d H:i:s')
		]);
	}
}
