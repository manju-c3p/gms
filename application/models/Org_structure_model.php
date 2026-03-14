<?php

class Org_structure_model extends CI_Model
{

/* -------- DEPARTMENTS -------- */

public function get_departments()
{
    return $this->db->get('departments')->result();
}

public function get_department($id)
{
    return $this->db->where('department_id',$id)->get('departments')->row();
}

public function insert_department($data)
{
    return $this->db->insert('departments',$data);
}

public function update_department($id,$data)
{
    $this->db->where('department_id',$id);
    return $this->db->update('departments',$data);
}


/* -------- DESIGNATIONS -------- */

public function get_designations()
{
    $this->db->select('d.*,dp.department_name');
    $this->db->from('designations d');
    $this->db->join('departments dp','dp.department_id=d.department_id');

    return $this->db->get()->result();
}

public function get_designation($id)
{
    return $this->db->where('designation_id',$id)->get('designations')->row();
}

public function insert_designation($data)
{
    return $this->db->insert('designations',$data);
}

public function update_designation($id,$data)
{
    $this->db->where('designation_id',$id);
    return $this->db->update('designations',$data);
}

}
