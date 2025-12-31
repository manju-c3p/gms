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


	// =========================================

	 public function get_all_brands()
    {
        return $this->db->order_by('brand_name','ASC')
                        ->get('vehicle_brands')
                        ->result();
    }

    public function get_models_by_brand($brand_id)
    {
        return $this->db->where('brand_id', $brand_id)
                        ->order_by('model_name','ASC')
                        ->get('vehicle_models')
                        ->result();
    }

    public function save_brand($name)
    {
        $this->db->insert('vehicle_brands', ['brand_name' => $name]);
        return $this->db->insert_id();
    }

    public function save_model($brand_id, $name)
    {
        $this->db->insert('vehicle_models', [
            'brand_id' => $brand_id,
            'model_name' => $name
        ]);
        return $this->db->insert_id();
    }
}


?>
