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

	public function save_job_descriptions($jobcard_id, $descriptions, $employee_ids)
	{
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_descriptions');



		foreach ($descriptions as $i => $desc) {

			// Skip empty rows
			if (trim($desc) === '') {
				continue;
			}

			   // 🔹 Get service name from master
        $service = $this->db
            ->select('service_name')
            ->from('services_master')
            ->where('master_service_id', $desc)
            ->get()
            ->row();

        if (!$service) {
            continue;
        }

			$this->db->insert('jobcard_descriptions', [
				'jobcard_id' => $jobcard_id,
				'description'   => $service->service_name,
				'employee_id'   => $employee_ids[$i] ?? null,
				'service_id'=> $desc,
			]);
		}
	}

	public function save_parts($jobcard_id, $part_ids, $qtys)
	{
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_parts');

		foreach ($part_ids as $i => $part_id) {
			if (!$part_id) continue;

			$this->db->insert('jobcard_parts', [
				'jobcard_id' => $jobcard_id,
				'part_id'       => $part_id,
				'qty'           => $qtys[$i],

			]);
		}
	}

	public function save_services($jobcard_id, $service_names)
	{
		log_message('error', '--- save_services called ---');
		log_message('error', 'jobcard_id ID: ' . $jobcard_id);

		log_message('error', 'Service Names: ' . print_r($service_names, true));

		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_services');

		foreach ($service_names as $i => $service_name) {
			if (!$service_name) continue;

			$this->db->insert('jobcard_services', [
				'jobcard_id' => $jobcard_id,
				'service_id'    => $service_name, // optional: map later

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

	public function get_jobcard_status_by_id($id)
	{
		return $this->db
			->select('status')
			->where('jobcard_id', $id)
			->get('job_cards')
			->row();
	}


	public function get_jobcard_by_id($id)
	{
		return $this->db->where('jobcard_id ', $id)
			->get('job_cards')
			->row();
	}

	public function get_jobcard_by_qid($id)
	{
		return $this->db->where('quotation_id ', $id)
			->get('job_cards')
			->row();
	}
	public function get_job_descriptions123($jobcard_id)
	{
		return $this->db->where('jobcard_id', $jobcard_id)
			->get('jobcard_descriptions')
			->result();
	}

	public function get_job_descriptions($jobcard_id)
	{
		return $this->db
			->select('
            ejd.*,
            e.employee_name
        ')
			->from('jobcard_descriptions ejd')
			->join(
				'employees e',
				'e.employee_id = ejd.employee_id',
				'left'
			)
			->where('ejd.jobcard_id ', $jobcard_id)
			->order_by('ejd.jobcard_description_id ', 'ASC')
			->get()
			->result();
			echo $this->db->last_query();exit;
	}

	// public function get_job_descriptions($jobcard_id)
	// {
	// 	return $this->db
	// 		->select('
    //         ejd.*,
    //         e.employee_name
    //     ')
	// 		->from('jobcard_services ejd')
	// 		->join(
	// 			'employees e',
	// 			'e.employee_id = ejd.employee_id',
	// 			'left'
	// 		)
	// 		->where('ejd.jobcard_id ', $jobcard_id)
	// 		->order_by('ejd.jobcard_description_id ', 'ASC')
	// 		->get()
	// 		->result();
	// }


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


	public function get_jobcard($jobcard_id)
	{
		$this->db->select("
        job_cards.*,
        customers.name AS customer_name,
        customers.phone,
        customers.email,
        vehicles.registration_no,
        vehicles.brand,
        vehicles.model,
        vehicles.variant,
        vehicles.year,
        appointments.appointment_date
    ");

		$this->db->from("job_cards");
		$this->db->join("customers", "customers.customer_id = job_cards.customer_id");
		$this->db->join("vehicles", "vehicles.vehicle_id = job_cards.vehicle_id");
		$this->db->join("appointments", "appointments.appointment_id = job_cards.appointment_id", "left");
		$this->db->where("job_cards.jobcard_id", $jobcard_id);

		return $this->db->get()->row();
	}
	public function get_jobcard_services($jobcard_id)
	{
		return $this->db->where("jobcard_id", $jobcard_id)
			->get("jobcard_services")
			->result();
	}

	public function get_jobcard_parts($jobcard_id)
	{
		$this->db->select("
        jobcard_parts.*,
        spare_parts.part_name
    ");
		$this->db->from("jobcard_parts");
		$this->db->join("spare_parts", "spare_parts.part_id = jobcard_parts.part_id");
		$this->db->where("jobcard_parts.jobcard_id", $jobcard_id);

		return $this->db->get()->result();
	}


	public function get_jobcard_with_details($jobcard_id)
	{
		// =========================
		// MAIN JOBCARD DATA
		// =========================
		$this->db->select("job_cards.*, 
                       customers.name AS customer_name, customers.phone AS customer_phone,
                       vehicles.registration_no");
		$this->db->from("job_cards");
		$this->db->join("customers", "customers.customer_id = job_cards.customer_id");
		$this->db->join("vehicles", "vehicles.vehicle_id = job_cards.vehicle_id");
		$this->db->where("job_cards.jobcard_id", $jobcard_id);

		$jobcard = $this->db->get()->row();

		if ($jobcard) {

			// =========================
			// SERVICES
			// =========================
			$jobcard->services = $this->db
				->get_where('jobcard_services', ['jobcard_id' => $jobcard_id])
				->result();

			// =========================
			// PARTS + SPARE PART DETAILS ✅✅✅
			// =========================
			$this->db->select("jobcard_parts.*, 
                           spare_parts.part_name, 
                           spare_parts.part_code, 
                           spare_parts.unit_price");
			$this->db->from("jobcard_parts");
			$this->db->join("spare_parts", "spare_parts.part_id = jobcard_parts.part_id");
			$this->db->where("jobcard_parts.jobcard_id", $jobcard_id);

			$jobcard->parts = $this->db->get()->result();
		}

		return $jobcard;
	}

	public function get_all_jobcards()
	{
		return $this->db
			->select('
            jc.jobcard_id,
            jc.jobcard_no,
            jc.jobcard_date,
            jc.expected_delivery_date,
            jc.status,

            c.name AS customer_name,
            v.registration_no,
            v.brand,
            v.model,

            e.employee_name AS technician_name,

            COUNT(mi.issue_id) AS issue_count
        ')
			->from('job_cards jc')
			->join('customers c', 'c.customer_id = jc.customer_id')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
			->join('employees e', 'e.employee_id = jc.technician_id', 'left')
			->join(
				'material_issues mi',
				'mi.jobcard_id = jc.jobcard_id',
				'left'
			)
			->group_by('jc.jobcard_id')
			->order_by('jc.created_at', 'DESC')
			->get()
			->result();
	}
	public function get_all_jobcards_completed()
	{
		return $this->db
			->select('
            jc.jobcard_id,
            jc.jobcard_no,
            jc.jobcard_date,
            jc.expected_delivery_date,
            jc.status,

            q.quotation_id,
            q.quotation_no,

            c.name AS customer_name,
            v.registration_no,
            v.brand,
            v.model,

            e.employee_name AS technician_name,

            COUNT(mi.issue_id) AS issue_count
        ')
			->from('job_cards jc')
			->join('quotations q', 'q.quotation_id = jc.quotation_id', 'left') // ✅ added
			->join('customers c', 'c.customer_id = jc.customer_id')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
			->join('employees e', 'e.employee_id = jc.technician_id', 'left')
			->join(
				'material_issues mi',
				'mi.jobcard_id = jc.jobcard_id',
				'left'
			)
			->where('jc.status', 'Completed')
			->group_by('jc.jobcard_id')
			->order_by('jc.created_at', 'DESC')
			->get()
			->result();
	}


	public function delete_jobcard($jobcard_id)
	{
		return $this->db
			->where('jobcard_id', $jobcard_id)
			->delete('job_cards');
	}

	public function get_jobcard_full_details_estimation($jobcard_id)
	{
		/* =====================================================
       1. Get Jobcard + Estimation + Customer + Vehicle
       ===================================================== */
		$jobcard = $this->db
			->select('
            jc.*,

            e.estimation_no,
            e.estimation_date,
            e.subtotal AS est_subtotal,
            e.tax_amount AS est_tax,
            e.discount AS est_discount,
            e.grand_total AS est_grand_total,
            e.status AS estimation_status,

            c.name AS customer_name,
            c.phone AS customer_phone,
            c.email AS customer_email,

            v.registration_no,
            v.brand,
            v.model,
            v.variant,
            v.year,
            v.chassis_no,
            v.engine_no
        ')
			->from('job_cards jc')
			->join('estimations e', 'e.estimation_id = jc.estimation_id')
			->join('customers c', 'c.customer_id = e.customer_id')
			->join('vehicles v', 'v.vehicle_id = e.vehicle_id')
			->where('jc.jobcard_id', $jobcard_id)
			->get()
			->row();

		if (!$jobcard) {
			return null;
		}

		/* =====================================================
       2. Get Estimation Services
       ===================================================== */
		$jobcard->services = $this->db
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
			->where('es.estimation_id', $jobcard->estimation_id)
			->get()
			->result();

		/* =====================================================
       3. Get Estimation Parts
       ===================================================== */
		$jobcard->parts = $this->db
			->select('
            ep.*,
            sp.part_name,
            sp.part_code
        ')
			->from('estimation_parts ep')
			->join(
				'spare_parts sp',
				'sp.part_id = ep.part_id',
				'left'
			)
			->where('ep.estimation_id', $jobcard->estimation_id)
			->get()
			->result();

		return $jobcard;
	}


	public function get_jobcard_full_details_quotation($jobcard_id)
	{
		/* =====================================================
       1. Jobcard + Quotation + Customer + Vehicle
       ===================================================== */
		$jobcard = $this->db
			->select('
            jc.*,

            q.quotation_no,
            q.quotation_date,
            q.subtotal AS quotation_subtotal,
            q.tax_amount AS quotation_tax,
            q.discount AS quotation_discount,
            q.grand_total AS quotation_grand_total,
            q.status AS quotation_status,

            c.name  AS customer_name,
            c.phone AS customer_phone,
            c.email AS customer_email,

            v.registration_no,
            v.brand,
            v.model,
            v.variant,
            v.year,
            v.chassis_no,
            v.engine_no
        ')
			->from('job_cards jc')
			->join('quotations q', 'q.quotation_id = jc.quotation_id')
			->join('customers c', 'c.customer_id = q.customer_id')
			->join('vehicles v', 'v.vehicle_id = q.vehicle_id')
			->where('jc.jobcard_id', $jobcard_id)
			->get()
			->row();

		if (!$jobcard) {
			return null;
		}

		/* =====================================================
       2. Quotation Services (FOR INVOICE)
       ===================================================== */
		$jobcard->services = $this->db
			->select('
            qs.service_id,
            qs.estimated_time,
            qs.estimated_cost,
            qs.total_cost,

            s.service_name,
            s.service_type
        ')
			->from('quotation_services qs')
			->join(
				'services_master s',
				's.master_service_id  = qs.service_id',
				'left'
			)
			->where('qs.quotation_id', $jobcard->quotation_id)
			->get()
			->result();

		/* =====================================================
       3. Quotation Parts (FOR INVOICE)
       ===================================================== */
		$jobcard->parts = $this->db
			->select('
            qp.part_id,
            qp.qty,
            qp.unit_price,
            qp.selling_price,
            qp.total_price,

            p.part_name,
            p.part_code
        ')
			->from('quotation_parts qp')
			->join(
				'spare_parts p',
				'p.part_id = qp.part_id',
				'left'
			)
			->where('qp.quotation_id', $jobcard->quotation_id)
			// ->where('qp.selected', 1)
			->get()
			->result();

		return $jobcard;
	}



	public function get_jobcard_basic($jobcard_id)
	{
		return $this->db
			->select('j.jobcard_no,j.jobcard_id, c.name, v.registration_no')
			->from('job_cards j')
			->join('customers c', 'c.customer_id = j.customer_id')
			->join('vehicles v', 'v.vehicle_id = j.vehicle_id')
			->where('j.jobcard_id', $jobcard_id)
			->get()->row();
	}

	public function get_jobcard_descriptions_with_employee($jobcard_id)
	{
		// return $this->db
		// 	->select('jd.*, e.employee_name')
		// 	->from('jobcard_descriptions jd')
		// 	->join('employees e', 'e.employee_id = jd.employee_id')
		// 	->where('jd.jobcard_id', $jobcard_id)
		// 	->get()->result();

		return $this->db
			->select('jd.*')
			->from('jobcard_descriptions jd')

			->where('jd.jobcard_id', $jobcard_id)
			->get()->result();
	}

	public function get_latest_work_status($jobcard_id)
	{
		$subQuery = $this->db
			->select('jobcard_description_id, MAX(log_time) as last_time')
			->from('jobcard_work_logs')
			->where('jobcard_id', $jobcard_id)
			->group_by('jobcard_description_id')
			->get_compiled_select();

		return $this->db
			->select('w.jobcard_description_id, w.status')
			->from('jobcard_work_logs w')
			->join("($subQuery) t", 'w.jobcard_description_id = t.jobcard_description_id AND w.log_time = t.last_time')
			->get()
			->result();
	}

	public function get_jobcard_work_times($jobcard_id)
	{
		$rows = $this->db
			->select('jobcard_description_id, status, log_time')
			->from('jobcard_work_logs')
			->where('jobcard_id', $jobcard_id)
			->order_by('log_time', 'ASC')
			->get()
			->result();

		$times = [];

		foreach ($rows as $r) {
			if (!isset($times[$r->jobcard_description_id])) {
				$times[$r->jobcard_description_id] = [
					'START' => null,
					'PAUSE' => null,
					'STOP'  => null,
				];
			}

			// overwrite → latest time wins
			$times[$r->jobcard_description_id][$r->status] = $r->log_time;
		}

		return $times;
	}

	public function create_from_quotation($quotation_id)
	{
		
		$q = $this->db->get_where('quotations', [
			'quotation_id' => $quotation_id
		])->row();

		if (!$q) {
			show_error('Quotation not found');
		}

		// Job Card Header (FULL DATA COPY)
		$this->db->insert('job_cards', [
			'quotation_id'    => $q->quotation_id,
			'estimation_id'   => $q->estimation_id,
			'appointment_id' => $q->appointment_id,
			'customer_id'    => $q->customer_id,
			'vehicle_id'     => $q->vehicle_id,

			'jobcard_date'   => $q->quotation_date,
			'jobcard_time'   => $q->quotation_time,

			'subtotal'       => $q->subtotal,
			'tax_amount'     => $q->tax_amount,
			'discount'       => $q->discount,
			'grand_total'    => $q->grand_total,

			'status'         => 'Pending',
			'created_at'     => date('Y-m-d H:i:s'),
			'created_by'     => $this->session->userdata('user_id') ?? null
		]);

		$jobcard_id = $this->db->insert_id();

		// 2️⃣ Generate Job Card No
		$year = date('Y');
		$jobcard_no = 'JC-' . $year . '-' . str_pad($jobcard_id, 6, '0', STR_PAD_LEFT);

		// 3️⃣ Update job card with number
		$this->Jobcard_model->update_jobcard(
			$jobcard_id,
			['jobcard_no' => $jobcard_no]
		);
		
		// Copy jobs
		// $jobs = $this->db->get_where('quotation_job_descriptions', [
		// 	'quotation_id' => $quotation_id
		// ])->result();
		$jobs = $this->db->get_where('quotation_services', [
			'quotation_id' => $quotation_id
		])->result();

		foreach ($jobs as $j) {
			$this->db->insert('jobcard_descriptions', [
				'jobcard_id' => $jobcard_id,
				// 'description' => $j->description,
				'service_id' => $j->service_id,
				
			]);
		}

		// Copy parts
		$parts = $this->db->get_where('quotation_parts', [
			'quotation_id' => $quotation_id,
			
		])->result();

		foreach ($parts as $p) {
			$this->db->insert('jobcard_parts', [
				'jobcard_id'   => $jobcard_id,
				'part_id'      => $p->part_id,
				'qty'          => $p->qty,
				'unit_price'   => $p->unit_price,
				'selling_price' => $p->selling_price,
				'total_price'  => $p->total_price
			]);
		}

		// Copy services
		$services = $this->db->get_where('quotation_services', [
			'quotation_id' => $quotation_id
		])->result();

		foreach ($services as $s) {
			$this->db->insert('jobcard_services', [
				'jobcard_id' => $jobcard_id,
				'service_id' => $s->service_id,
				'estimated_time'       => $s->estimated_time,
				'estimated_cost'       => $s->estimated_cost,
				'total_cost'      => $s->total_cost
			]);
		}

		return $jobcard_id;
	}

	public function get_by_quotation($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->get('job_cards')
			->row();   // return single jobcard or NULL
	}
}
