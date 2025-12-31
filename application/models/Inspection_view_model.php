<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inspection_view_model extends CI_Model
{
    // Appointment + customer + vehicle
    public function get_appointment_details($appointment_id)
    {
        return $this->db
            ->select('a.*, c.name customer_name, c.phone,
                      v.registration_no, v.model,v.variant,v.year, v.vehicle_id')
            ->from('appointments a')
            ->join('customers c','c.customer_id=a.customer_id')
            ->join('vehicles v','v.vehicle_id=a.vehicle_id')
            ->where('a.appointment_id', $appointment_id)
            ->get()->row();
    }

    public function get_by_appointment($appointment_id)
    {
        return $this->db
            ->where('appointment_id', $appointment_id)
            ->get('inspections')->row();
    }

    public function create_inspection($data)
    {
        $this->db->insert('inspections', $data);
        return $this->db->insert_id();
    }

    public function update_inspection($inspection_id, $data)
    {
        return $this->db
            ->where('inspection_id', $inspection_id)
            ->update('inspections', $data);
    }

    public function save_item_result($inspection_id, $item_id, $status)
    {
        $this->db->replace('inspection_item_results', [
            'inspection_id' => $inspection_id,
            'item_id'       => $item_id,
            'status'        => $status
        ]);
    }

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

    public function save_inventory_status($inspection_id, $items)
    {
        $this->db->where('inspection_id', $inspection_id)
                 ->delete('inspection_inventory_status');

        foreach ($items as $inv_id) {
            $this->db->insert('inspection_inventory_status', [
                'inspection_id'        => $inspection_id,
                'inventory_status_id'  => $inv_id
            ]);
        }
    }


}
