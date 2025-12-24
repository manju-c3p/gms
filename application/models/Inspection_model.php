<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
}
