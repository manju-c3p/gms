<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Inspection_report_model extends CI_Model
{
    public function get_inspection_header($inspection_id)
    {
        return $this->db
            ->select('i.*, c.name customer_name, c.phone,
                      v.registration_no, v.vin, v.make, v.model, v.km')
            ->from('inspections i')
            ->join('customers c','c.customer_id=i.customer_id')
            ->join('vehicles v','v.vehicle_id=i.vehicle_id')
            ->where('i.inspection_id', $inspection_id)
            ->get()->row();
    }

    public function get_inspection_items($inspection_id)
    {
        return $this->db
            ->select('im.item_name, ir.status')
            ->from('inspection_item_results ir')
            ->join('inspection_items im','im.item_id=ir.item_id')
            ->where('ir.inspection_id', $inspection_id)
            ->get()->result();
    }

    public function get_works_requested($inspection_id)
    {
        return $this->db
            ->select('wm.work_name')
            ->from('inspection_works_requested iw')
            ->join('works_requested_master wm','wm.work_id=iw.work_id')
            ->where('iw.inspection_id', $inspection_id)
            ->get()->result();
    }

    public function get_inventory_status($inspection_id)
    {
        return $this->db
            ->select('im.status_name')
            ->from('inspection_inventory_status ii')
            ->join('inventory_status_master im','im.inventory_status_id=ii.inventory_status_id')
            ->where('ii.inspection_id', $inspection_id)
            ->get()->result();
    }

    public function get_damage_marks($inspection_id)
    {
        return $this->db
            ->where('inspection_id', $inspection_id)
            ->get('inspection_damage_marks')
            ->result();
    }
}
