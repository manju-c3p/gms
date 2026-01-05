<?php
class Dashboard_model extends CI_Model
{
	/**
	 * Get active job cards for dashboard
	 */
	public function get_active_job_cards()
	{
		return $this->db
			->select('
                jc.jobcard_id,
                jc.jobcard_no,
                jc.status,
                jc.expected_delivery_date,
                c.name AS customer_name,
                v.registration_no,
                e.employee_name AS technician_name
            ')
			->from('job_cards jc')
			->join('customers c', 'c.customer_id = jc.customer_id')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
			->join('employees e', 'e.employee_id = jc.technician_id', 'left')
			->where_in('jc.status', ['Pending', 'In Progress'])
			->order_by('jc.created_at', 'DESC')
			->limit(10) // dashboard-friendly
			->get()
			->result();
	}

	public function get_recent_estimations()
	{
		return $this->db
			->select('
            e.estimation_id,
            e.estimation_no,
            e.grand_total,
            e.status,
            e.created_at,
            c.name AS customer_name,
            v.registration_no
        ')
			->from('estimations e')
			->join('customers c', 'c.customer_id = e.customer_id')
			->join('vehicles v', 'v.vehicle_id = e.vehicle_id')
			->order_by('e.created_at', 'DESC')
			->limit(10) // dashboard friendly
			->get()
			->result();
	}

	public function get_low_stock_items()
	{
		return $this->db
			->select('
            sp.part_id,
            sp.part_name,
            sp.min_stock,
            vb.brand_name,

            IFNULL(SUM(si.qty), 0) AS stock_in_qty,
            IFNULL(SUM(so.qty), 0) AS stock_out_qty,

            (IFNULL(SUM(si.qty), 0) - IFNULL(SUM(so.qty), 0)) AS current_stock
        ')
			->from('spare_parts sp')

			// Brand (optional)
			->join(
				'vehicle_brands vb',
				'vb.brand_id = sp.brand_id',
				'left'
			)

			// Stock In
			->join(
				'stock_in si',
				'si.part_id = sp.part_id',
				'left'
			)

			// Stock Out
			->join(
				'stock_out so',
				'so.part_id = sp.part_id',
				'left'
			)

			->group_by('sp.part_id')

			// Low / Out stock condition
			->having('current_stock <= sp.min_stock')

			->order_by('current_stock', 'ASC')

			->limit(10)
			->get()
			->result();
	}

	public function get_recent_inspections()
	{
		return $this->db
			->select('
            i.inspection_id,
            i.status,
            i.km_reading,
            i.inspection_date,
            c.name AS customer_name,
            v.registration_no
        ')
			->from('inspections i')
			->join('customers c', 'c.customer_id = i.customer_id')
			->join('vehicles v', 'v.vehicle_id = i.vehicle_id')
			->order_by('i.created_at', 'DESC')
			->limit(10) // dashboard friendly
			->get()
			->result();
	}
}
