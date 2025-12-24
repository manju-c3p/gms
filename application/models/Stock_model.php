<?php
class Stock_model extends CI_Model {

    public function stock_in($data) {
        return $this->db->insert('stock_in', $data);
    }

    public function stock_out($data) {
        return $this->db->insert('stock_out', $data);
    }
}


?>
