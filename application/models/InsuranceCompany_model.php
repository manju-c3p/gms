<?php
class InsuranceCompany_model extends CI_Model {

    public function add_company($data) {
        return $this->db->insert('insurance_companies', $data);
    }

    public function get_all() {
        return $this->db->order_by('company_name', 'ASC')->get('insurance_companies')->result();
    }

    public function get($company_id) {
        return $this->db->where('company_id', $company_id)->get('insurance_companies')->row();
    }

    public function update_company($company_id, $data) {
        return $this->db->where('company_id', $company_id)->update('insurance_companies', $data);
    }

    public function delete_company($company_id) {
        return $this->db->delete('insurance_companies', ['company_id' => $company_id]);
    }
}

?>
