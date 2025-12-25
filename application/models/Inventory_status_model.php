<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
}
