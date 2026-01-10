<?php defined('BASEPATH') or exit('No direct script access allowed');

class Estimation_model extends CI_Model
{

	public function get_by_appointment($appointment_id)
	{
		return $this->db
			->where('appointment_id', $appointment_id)
			->get('estimations')
			->row();
	}


	public function create_estimation($data)
	{
		$this->db->insert('estimations', $data);
		return $this->db->insert_id();
	}


	public function get_appointment_details($appointment_id)
	{
		$this->db->select("
        a.*,
        c.*,
        
        v.*,
      
    ");
		$this->db->from('appointments a');
		$this->db->join('customers c', 'c.customer_id = a.customer_id');
		$this->db->join('vehicles v', 'v.vehicle_id = a.vehicle_id');
		$this->db->where('a.appointment_id', $appointment_id);

		return $this->db->get()->row();
	}

	public function update_estimation($estimation_id, $data)
	{
		return $this->db
			->where('estimation_id', $estimation_id)
			->update('estimations', $data);
	}
public function save_job_descriptions($estimation_id, $descriptions, $jamt)
{
    // Remove existing records for this estimation
    $this->db->where('estimation_id', $estimation_id)
             ->delete('estimation_job_descriptions');

    foreach ($descriptions as $i => $desc) {

        // Skip empty rows
        if (trim($desc) === '') {
            continue;
        }

        $this->db->insert('estimation_job_descriptions', [
            'estimation_id' => $estimation_id,
            'description'   => $desc,
            'amount'        => isset($jamt[$i]) ? $jamt[$i] : 0
        ]);
    }
}


	public function save_parts($estimation_id, $part_ids, $qtys, $unit_prices, $sell_prices, $totals, $markup, $discount, $discountamt, $parttype, $brandid, $selected)
	{
		$this->db->where('estimation_id', $estimation_id)
			->delete('estimation_parts');

		foreach ($part_ids as $i => $part_id) {
			if (!$part_id) continue;

			// ✅ checkbox-safe logic
			$is_selected = in_array($part_id, $selected) ? 1 : 0;

			$this->db->insert('estimation_parts', [
				'estimation_id' => $estimation_id,
				'part_id'       => $part_id,
				'qty'           => $qtys[$i],
				'unit_price'    => $unit_prices[$i],
				'selling_price' => $sell_prices[$i],
				'total_price'   => $totals[$i],
				'markup_percentage' => $markup[$i],
				'discount' => $discount[$i],
				'dis_amount' => $discountamt[$i],
				'part_type' => $parttype[$i],
				'brand_id' => $brandid[$i],
				'selected' => $is_selected,
			]);
		}
	}
	public function save_services($estimation_id, $service_names, $times, $costs, $totals)
	{
		// log_message('error', '--- save_services called ---');
		// log_message('error', 'Estimation ID: ' . $estimation_id);

		// log_message('error', 'Service Names: ' . print_r($service_names, true));
		// log_message('error', 'Times: ' . print_r($times, true));
		// log_message('error', 'Costs: ' . print_r($costs, true));
		// log_message('error', 'Totals: ' . print_r($totals, true));
		$this->db->where('estimation_id', $estimation_id)
			->delete('estimation_services');

		foreach ($service_names as $i => $service_name) {
			if (!$service_name) continue;

			$this->db->insert('estimation_services', [
				'estimation_id' => $estimation_id,
				'service_id'    => $service_name, // optional: map later
				'estimated_time' => $times[$i],
				'estimated_cost' => $costs[$i],
				'total_cost'    => $totals[$i]
			]);

			log_message('error', $this->db->last_query());
			log_message('error', json_encode($this->db->error()));
		}
	}


	public function get_estimation_by_id($id)
	{
		return $this->db->where('estimation_id', $id)
			->get('estimations')
			->row();
	}
	public function get_job_descriptions111($estimation_id)
	{
		return $this->db->where('estimation_id', $estimation_id)
			->get('estimation_job_descriptions')
			->result();
	}
	public function get_job_descriptions($estimation_id)
	{
		return $this->db
			->select('
            ejd.*,
            e.employee_name
        ')
			->from('estimation_job_descriptions ejd')
			->join(
				'employees e',
				'e.employee_id = ejd.employee_id',
				'left'
			)
			->where('ejd.estimation_id', $estimation_id)
			->order_by('ejd.id', 'ASC')
			->get()
			->result();
	}



	public function get_parts($estimation_id)
	{
		$this->db->select('estimation_parts.*, spare_parts.part_name');
		$this->db->from('estimation_parts');
		$this->db->join('spare_parts', 'spare_parts.part_id = estimation_parts.part_id');
		$this->db->where('estimation_id', $estimation_id);
		return $this->db->get()->result();
	}
	public function get_parts_type($estimation_id, $parttype)
	{
		return $this->db
			->select('ep.*, sp.part_name')
			->from('estimation_parts ep')
			->join('spare_parts sp', 'sp.part_id = ep.part_id')
			->where('ep.estimation_id', $estimation_id)
			->where('ep.part_type', $parttype)
			->get()
			->result();
	}

	public function get_services($estimation_id)
	{
		return $this->db->where('estimation_id', $estimation_id)
			->get('estimation_services')
			->result();
	}

	public function get_services_print($estimation_id)
	{
		return $this->db
			->select('
            es.*,
            sm.service_name,
            sm.service_type
        ')
			->from('estimation_services es')
			->join(
				'services_master sm',
				'sm.master_service_id = es.service_id',
				'left'
			)
			->where('es.estimation_id', $estimation_id)
			->get()
			->result();
	}


	public function get_all_estimations()
	{
		return $this->db
			->select('
                e.*,
              

                c.name AS customer_name,
                c.phone AS customer_phone,

                v.registration_no,
                v.brand,
                v.model
            ')
			->from('estimations e')
			->join('customers c', 'c.customer_id = e.customer_id')
			->join('vehicles v', 'v.vehicle_id = e.vehicle_id')
			->order_by('e.created_at', 'DESC')
			->get()
			->result();
	}

	public function delete_estimation($estimation_id)
	{
		return $this->db
			->where('estimation_id', $estimation_id)
			->delete('estimations');
	}
}
