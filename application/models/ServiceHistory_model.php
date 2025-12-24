<?php
class ServiceHistory_model extends CI_Model
{
    // ✅ Customer History
    public function get_customer_history($customer_id)
    {
        return $this->db->query("
            SELECT jc.jobcard_id, jc.jobcard_date, jc.status, jc.technician,
                   v.registration_no,
                   IFNULL(SUM(js.amount),0) AS service_total,
                   IFNULL(SUM(jp.qty * jp.rate),0) AS parts_total
            FROM job_cards jc
            LEFT JOIN vehicles v ON v.vehicle_id = jc.vehicle_id
            LEFT JOIN jobcard_services js ON js.jobcard_id = jc.jobcard_id
            LEFT JOIN jobcard_parts jp ON jp.jobcard_id = jc.jobcard_id
            WHERE jc.customer_id = ?
            GROUP BY jc.jobcard_id
            ORDER BY jc.jobcard_date DESC
        ", [$customer_id])->result();
    }

    // ✅ Vehicle History
    public function get_vehicle_history($vehicle_id)
    {
        return $this->db->query("
            SELECT jc.jobcard_id, jc.jobcard_date, jc.status, jc.technician,
                   c.name AS customer_name,
                   IFNULL(SUM(js.amount),0) AS service_total,
                   IFNULL(SUM(jp.qty * jp.rate),0) AS parts_total
            FROM job_cards jc
            LEFT JOIN customers c ON c.customer_id = jc.customer_id
            LEFT JOIN jobcard_services js ON js.jobcard_id = jc.jobcard_id
            LEFT JOIN jobcard_parts jp ON jp.jobcard_id = jc.jobcard_id
            WHERE jc.vehicle_id = ?
            GROUP BY jc.jobcard_id
            ORDER BY jc.jobcard_date DESC
        ", [$vehicle_id])->result();
    }
}



?> 
