<?php
class SpareParts_model extends CI_Model {

    public function add_part($data) {
        return $this->db->insert('spare_parts', $data);
    }

    public function update_part($part_id, $data) {
        return $this->db->where('part_id', $part_id)->update('spare_parts', $data);
    }

    public function delete_part($part_id) {
        return $this->db->delete('spare_parts', ['part_id' => $part_id]);
    }

    public function get_all_parts() {
        return $this->db->order_by('part_name', 'ASC')->get('spare_parts')->result();
    }

    public function get_part($part_id) {
        return $this->db->where('part_id', $part_id)->get('spare_parts')->row();
    }

    public function get_stock($part_id) {
        $in  = $this->db->select_sum('qty')->where('part_id', $part_id)->get('stock_in')->row()->qty;
        $out = $this->db->select_sum('qty')->where('part_id', $part_id)->get('stock_out')->row()->qty;

        return ($in ?? 0) - ($out ?? 0);
    }
}


?>
