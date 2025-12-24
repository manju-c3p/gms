<?php
class Service_model extends CI_Model
{
    // ✅ Get all services
    public function get_all_services()
    {
        return $this->db->order_by('master_service_id', 'DESC')
                        ->get('services_master')
                        ->result();
    }

    // ✅ Insert new service
    public function insert_service($data)
    {
        return $this->db->insert('services_master', $data);
    }

    // ✅ Get single service for edit
    public function get_service($id)
    {
        return $this->db->where('master_service_id', $id)
                        ->get('services_master')
                        ->row();
    }

    // ✅ Update service
    public function update_service($id, $data)
    {
        return $this->db->where('master_service_id', $id)
                        ->update('services_master', $data);
    }

    // ✅ Change status (Enable / Disable)
    public function change_status($id, $status)
    {
        return $this->db->where('master_service_id', $id)
                        ->update('services_master', ['status' => $status]);
    }
}




?>
