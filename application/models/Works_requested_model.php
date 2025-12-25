<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Works_requested_model extends CI_Model
{
    private $table = 'works_requested_master';

    public function get_all()
    {
        return $this->db
            ->where('is_active', 1)
            ->order_by('work_name', 'ASC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('work_id', $id)
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
            ->where('work_id', $id)
            ->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db
            ->where('work_id', $id)
            ->update($this->table, ['is_active' => 0]);
    }
}
