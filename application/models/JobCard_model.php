<?php
class Jobcard_model extends CI_Model
{

	public function create_jobcard($data)
	{
		$this->db->insert('job_cards', $data);
		return $this->db->insert_id();
	}

	public function update_jobcard($jobcard_id, $data)
	{
		return $this->db
			->where('jobcard_id', $jobcard_id)
			->update('job_cards', $data);
	}

	public function get_by_appointment($appointment_id)
	{
		return $this->db
			->where('appointment_id', $appointment_id)
			->get('job_cards')
			->row();
	}

	public function save_job_descriptions($jobcard_id, $descriptions)
	{
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_descriptions');

		foreach ($descriptions as $desc) {
			if (trim($desc) == '') continue;

			$this->db->insert('jobcard_descriptions', [
				'jobcard_id' => $jobcard_id,
				'description'   => $desc
			]);
		}
	}

	public function save_parts($jobcard_id, $part_ids, $qtys, $unit_prices, $sell_prices, $totals)
	{
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_parts');

		foreach ($part_ids as $i => $part_id) {
			if (!$part_id) continue;

			$this->db->insert('jobcard_parts', [
				'jobcard_id' => $jobcard_id,
				'part_id'       => $part_id,
				'qty'           => $qtys[$i],
				'unit_price'    => $unit_prices[$i],
				'selling_price' => $sell_prices[$i],
				'total_price'   => $totals[$i]
			]);
		}
	}

	public function save_services($jobcard_id, $service_names, $times, $costs, $totals)
	{
		log_message('error', '--- save_services called ---');
		log_message('error', 'jobcard_id ID: ' . $jobcard_id);

		log_message('error', 'Service Names: ' . print_r($service_names, true));
		log_message('error', 'Times: ' . print_r($times, true));
		log_message('error', 'Costs: ' . print_r($costs, true));
		log_message('error', 'Totals: ' . print_r($totals, true));
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_services');

		foreach ($service_names as $i => $service_name) {
			if (!$service_name) continue;

			$this->db->insert('jobcard_services', [
				'jobcard_id' => $jobcard_id,
				'service_id'    => $service_name, // optional: map later
				'estimated_time' => $times[$i],
				'estimated_cost' => $costs[$i],
				'total_cost'    => $totals[$i]
			]);

			log_message('error', $this->db->last_query());
			log_message('error', json_encode($this->db->error()));
		}
	}

	public function get_jobcard_with_basic_details($jobcard_id)
	{
		return $this->db
			->select('
            jc.*,
            c.name AS customer_name,
            v.registration_no
        ')
			->from('job_cards jc')
			->join('customers c', 'c.customer_id = jc.customer_id')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
			->where('jc.jobcard_id', $jobcard_id)
			->get()
			->row();
	}


	public function get_jobcard_by_id($id)
	{
		return $this->db->where('jobcard_id ', $id)
			->get('job_cards')
			->row();
	}
	public function get_job_descriptions($jobcard_id)
	{
		return $this->db->where('jobcard_id', $jobcard_id)
			->get('jobcard_descriptions')
			->result();
	}


	public function get_parts($jobcard_id)
	{
		$this->db->select('jobcard_parts.*, spare_parts.part_name');
		$this->db->from('jobcard_parts');
		$this->db->join('spare_parts', 'spare_parts.part_id = jobcard_parts.part_id');
		$this->db->where('jobcard_id', $jobcard_id);
		return $this->db->get()->result();
	}
	public function get_services($jobcard_id)
	{
		return $this->db->where('jobcard_id', $jobcard_id)
			->get('jobcard_services')
			->result();
	}
	
}
