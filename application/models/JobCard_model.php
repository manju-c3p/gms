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

	public function save_job_descriptionsold($jobcard_id, $descriptions, $employee_ids)
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
				'service_id' => $desc,
			]);
		}
	}

	public function save_job_descriptions($jobcard_id, $descriptions, $amounts)
	{
		// Delete existing rows
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_descriptions');

		foreach ($descriptions as $i => $desc) {

			// Skip empty rows
			if (trim($desc) === '') {
				continue;
			}

			$this->db->insert('jobcard_descriptions', [
				'jobcard_id'  => $jobcard_id,
				'description' => $desc,
				'amount'      => isset($amounts[$i]) && $amounts[$i] !== ''
					? $amounts[$i]
					: null
			]);
		}
	}


	public function save_parts($jobcard_id, $part_ids, $part_type, $qtys, $unitprice, $sellprice, $totalprice, $disamt)
	{

		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_parts');

		foreach ($part_ids as $i => $part_id) {
			if (!$part_id) continue;

			$this->db->insert('jobcard_parts', [
				'jobcard_id' => $jobcard_id,
				'part_id'       => $part_id,
				'qty'           => $qtys[$i],
				'part_type'           => $part_type[$i],
				'unit_price'           => $unitprice[$i],
				'selling_price'           => $sellprice[$i],
				'total_price'           => $totalprice[$i],
				'disamount'           => $disamt[$i],

			]);
		}
	}

	public function save_services($jobcard_id, $service_names, $technician_id, $totalamt)
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
				'employee_id'    => $technician_id,
				'total_cost'    => $totalamt,
			]);

			log_message('error', $this->db->last_query());
			log_message('error', json_encode($this->db->error()));
		}
	}

	public function update_servicesold($jobcard_id, $service_ids, $technician_ids)
	{
		log_message('error', '--- update_services called ---');
		log_message('error', 'Jobcard ID: ' . $jobcard_id);
		log_message('error', 'Service IDs: ' . print_r($service_ids, true));
		log_message('error', 'Technician IDs: ' . print_r($technician_ids, true));

		foreach ($service_ids as $i => $service_id) {

			if (!$service_id) {
				continue;
			}

			$employee_id = $technician_ids[$i] ?? null;

			// Update only technician
			$this->db->where('jobcard_id', $jobcard_id)
				->where('service_id', $service_id)
				->update('jobcard_services', [
					'employee_id' => $employee_id
				]);

			log_message('error', $this->db->last_query());
			log_message('error', json_encode($this->db->error()));
		}
	}
	public function update_services($jobcard_id, $service_ids, $technician_ids, $esticost, $estitime, $totalcost)
	{
		// log_message('error', '--- update_services called ---');

		// 1️⃣ Get existing service IDs
		$existing = $this->db->select('service_id')
			->where('jobcard_id', $jobcard_id)
			->get('jobcard_services')
			->result_array();

		$existing_ids = array_column($existing, 'service_id');

		foreach ($service_ids as $i => $service_id) {

			if (empty($service_id)) {
				continue;
			}

			$employee_id    = $technician_ids[$i] ?? null;
			$estimated_time = $estitime[$i] ?? 0;
			$estimated_cost = $esticost[$i] ?? 0;
			$total_cost     = $totalcost[$i] ?? 0;

			$data = [
				'jobcard_id'    => $jobcard_id,
				'service_id'    => $service_id,
				'employee_id'   => $employee_id,
				'estimated_time' => $estimated_time,
				'estimated_cost' => $estimated_cost,
				'total_cost'    => $total_cost,
			];

			if (in_array($service_id, $existing_ids)) {

				// ✅ Update full row
				$this->db->where('jobcard_id', $jobcard_id)
					->where('service_id', $service_id)
					->update('jobcard_services', $data);

				log_message('error', 'UPDATED: ' . $this->db->last_query());
			} else {

				// ✅ Insert new row
				$this->db->insert('jobcard_services', $data);

				log_message('error', 'INSERTED: ' . $this->db->last_query());
			}

			log_message('error', json_encode($this->db->error()));
		}
	}
	public function update_sublet123($jobcard_id, $description, $amount)
	{
		// log_message('error', '--- update_services called ---');

		// 1️⃣ Get existing service IDs
		$existing = $this->db->select('description')
			->where('jobcard_id', $jobcard_id)
			->get('jobcard_descriptions')
			->result_array();

		$existing_ids = array_column($existing, 'description');

		foreach ($description as $i => $service_id) {

			if (empty($service_id)) {
				continue;
			}

			$description    = $description[$i] ?? null;
			$amount = $amount[$i] ?? 0;


			$data = [
				'jobcard_id'    => $jobcard_id,
				'description'    => $description,
				'amount'   => $amount,

			];

			if (in_array($service_id, $existing_ids)) {

				// ✅ Update full row
				$this->db->where('jobcard_id', $jobcard_id)
					->where('description', $description)
					->update('jobcard_descriptions', $data);

				log_message('error', 'UPDATED: ' . $this->db->last_query());
			} else {

				// ✅ Insert new row
				$this->db->insert('jobcard_descriptions', $data);

				log_message('error', 'INSERTED: ' . $this->db->last_query());
			}

			log_message('error', json_encode($this->db->error()));
		}
	}

	public function update_sublet($jobcard_id, $descriptions, $amounts)
{
    // ✅ Get existing descriptions from DB
    $existing = $this->db->select('description')
        ->where('jobcard_id', $jobcard_id)
        ->get('jobcard_descriptions')
        ->result_array();

    $existing_descriptions = array_column($existing, 'description');

    $submitted_descriptions = [];

    foreach ($descriptions as $i => $desc) {

        $desc   = trim($desc);
        $amount = $amounts[$i] ?? 0;

        if ($desc == '') {
            continue;
        }

        $submitted_descriptions[] = $desc;

        $data = [
            'jobcard_id' => $jobcard_id,
            'description'=> $desc,
            'amount'     => $amount,
           
        ];

        // ✅ UPDATE if exists
        if (in_array($desc, $existing_descriptions)) {

            $this->db->where('jobcard_id', $jobcard_id);
            $this->db->where('description', $desc);
            $this->db->update('jobcard_descriptions', [
                'amount' => $amount
            ]);

        } 
        // ✅ INSERT new
        else {

            $this->db->insert('jobcard_descriptions', $data);
        }
    }

    // ✅ DELETE removed rows (VERY IMPORTANT)
    if (!empty($submitted_descriptions)) {
        $this->db->where('jobcard_id', $jobcard_id);
        $this->db->where_not_in('description', $submitted_descriptions);
        $this->db->delete('jobcard_descriptions');
    }
}

	public function update_parts($jobcard_id, $part_ids, $part_type, $qtys, $unitprice, $sellprice, $totalprice, $disamt)
	{
		log_message('error', '--- update_parts called ---');
		log_message('error', 'Jobcard ID: ' . $jobcard_id);

		// 1️⃣ Get existing part IDs for this jobcard
		$existing = $this->db->select('part_id')
			->where('jobcard_id', $jobcard_id)
			->get('jobcard_parts')
			->result_array();

		$existing_ids = array_column($existing, 'part_id');

		foreach ($part_ids as $i => $part_id) {

			if (empty($part_id)) {
				continue;
			}

			$data = [
				'jobcard_id'   => $jobcard_id,
				'part_id'      => $part_id,
				'qty'          => $qtys[$i] ?? 0,
				'part_type'    => $part_type[$i] ?? null,
				'unit_price'   => $unitprice[$i] ?? 0,
				'selling_price' => $sellprice[$i] ?? 0,
				'total_price'  => $totalprice[$i] ?? 0,
				'disamount'    => $disamt[$i] ?? 0,
			];

			if (in_array($part_id, $existing_ids)) {

				// ✅ Update existing part
				$this->db->where('jobcard_id', $jobcard_id)
					->where('part_id', $part_id)
					->update('jobcard_parts', $data);

				log_message('error', 'UPDATED PART: ' . $this->db->last_query());
			} else {

				// ✅ Insert new part
				$this->db->insert('jobcard_parts', $data);

				log_message('error', 'INSERTED PART: ' . $this->db->last_query());
			}

			log_message('error', json_encode($this->db->error()));
		}

		// 2️⃣ Delete removed parts (optional but recommended)
		foreach ($existing_ids as $existing_id) {
			if (!in_array($existing_id, $part_ids)) {
				$this->db->where('jobcard_id', $jobcard_id)
					->where('part_id', $existing_id)
					->delete('jobcard_parts');

				log_message('error', 'DELETED PART ID: ' . $existing_id);
			}
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

	public function get_jobcard_by_eid($id)
	{
		return $this->db->where('estimation_id', $id)
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
		echo $this->db->last_query();
		exit;
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
		$this->db->select('jobcard_parts.*, spare_parts.*');
		$this->db->from('jobcard_parts');
		$this->db->join('spare_parts', 'spare_parts.part_id = jobcard_parts.part_id');
		$this->db->where('jobcard_id', $jobcard_id);

		// ✅ Custom sorting
		$this->db->order_by("
        CASE spare_parts.part_type
            WHEN 'New Parts' THEN 1
            WHEN 'Aftermarket Parts' THEN 2
            WHEN 'Used Parts' THEN 3
            ELSE 4
        END", 'ASC');
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
		customers.address,customers.trn,
        vehicles.registration_no,
        vehicles.brand,
        vehicles.model,
        vehicles.variant,
        vehicles.year,vehicles.chassis_no,vehicles.color,
        appointments.appointment_date");

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

	public function get_jobcard_servicesnew($jobcard_id)
	{
		return $this->db
			->select('
            js.*,
            sm.service_name,
            sm.service_type,
            sm.estimated_cost,
            sm.estimated_time,
            e.employee_name
        ')
			->from('jobcard_services js')
			->join(
				'services_master sm',
				'sm.master_service_id = js.service_id',
				'left'
			)
			->join(
				'employees e',
				'e.employee_id = js.employee_id',
				'left'
			)
			->where('js.jobcard_id', $jobcard_id)
			->get()
			->result();
	}


	public function get_jobcard_parts($jobcard_id)
	{
		$this->db->select("
        jobcard_parts.*,
        spare_parts.part_name,
        spare_parts.part_type,
        CASE spare_parts.part_type
            WHEN 'New Parts' THEN 'Original'
            WHEN 'Aftermarket Parts' THEN 'Aftermarket'
            WHEN 'Used Parts' THEN 'Used'
            ELSE spare_parts.part_type
        END AS part_type_label");
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

	// public function get_all_jobcards()
	// {
	// 	return $this->db
	// 		->select('
	//         jc.jobcard_id,
	//         jc.jobcard_no,
	//         jc.jobcard_date,
	//         jc.expected_delivery_date,
	//         jc.status,

	//         c.name AS customer_name,
	//         v.registration_no,
	//         v.brand,
	//         v.model,

	//         e.employee_name AS technician_name,

	//         COUNT(mi.issue_id) AS issue_count
	//     ')
	// 		->from('job_cards jc')
	// 		->join('customers c', 'c.customer_id = jc.customer_id')
	// 		->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
	// 		->join('employees e', 'e.employee_id = jc.technician_id', 'left')
	// 		->join(
	// 			'material_issues mi',
	// 			'mi.jobcard_id = jc.jobcard_id',
	// 			'left'
	// 		)
	// 		->group_by('jc.jobcard_id')
	// 		->order_by('jc.created_at', 'DESC')
	// 		->get()
	// 		->result();
	// }

	public function get_all_jobcards()
	{
		return $this->db
			->select("
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

            COUNT(DISTINCT jp.part_id) AS total_parts,

            COUNT(
                DISTINCT CASE 
                    WHEN IFNULL(issued.total_issued_qty, 0) >= jp.qty 
                    THEN jp.part_id 
                END
            ) AS fully_issued_parts
        ")
			->from('job_cards jc')
			->join('customers c', 'c.customer_id = jc.customer_id')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
			->join('employees e', 'e.employee_id = jc.technician_id', 'left')

			// Planned parts
			->join('jobcard_parts jp', 'jp.jobcard_id = jc.jobcard_id', 'left')

			// Issued qty per part
			->join("
            (
                SELECT 
                    jobcard_id,
                    part_id,
                    SUM(issued_qty) AS total_issued_qty
                FROM material_issue_items
                GROUP BY jobcard_id, part_id
            ) AS issued
        ", 'issued.jobcard_id = jc.jobcard_id AND issued.part_id = jp.part_id', 'left')

			->group_by('jc.jobcard_id')
			->order_by('jc.created_at', 'DESC')
			->get()
			->result();
	}

	public function get_all_jobcards_completed_oldfn()
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

			// quotation
			->join('quotations q', 'q.quotation_id = jc.quotation_id', 'left')

			// invoice join (IMPORTANT)
			->join('invoices i', 'i.jobcard_id = jc.jobcard_id', 'left')

			// masters
			->join('customers c', 'c.customer_id = jc.customer_id')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
			->join('employees e', 'e.employee_id = jc.technician_id', 'left')

			// material issues
			->join('material_issues mi', 'mi.jobcard_id = jc.jobcard_id', 'left')

			// conditions
			// ->where('jc.status', 'Scheduled')
			// ->where('i.jobcard_id IS NULL', null, false) // ✅ invoice not created

			->group_by('jc.jobcard_id')
			->order_by('jc.created_at', 'DESC')
			->get()
			->result();
	}



	public function delete_jobcard($jobcard_id)
	{
		$this->db->trans_start();

		// 1. Work logs (depends on jobcard_services)
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_work_logs');

		// 2. Jobcard services
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_services');

		// 3. Jobcard parts
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_parts');

		// 4. Jobcard descriptions
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('jobcard_descriptions');

		// 5. MAIN job card (LAST)
		$this->db->where('jobcard_id', $jobcard_id)
			->delete('job_cards');

		$this->db->trans_complete();

		return $this->db->trans_status();
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


	public function get_jobcard_full_details_quotationold($jobcard_id)
	{
		/* =====================================================
       1. Jobcard + Quotation + Customer + Vehicle
       ===================================================== */
		$jobcard = $this->db
			->select('
            jc.*,
 			q.quotation_id,
            q.quotation_no,
            q.quotation_date,
            q.subtotal AS quotation_subtotal,
            q.tax_amount AS quotation_tax,
            q.discount AS quotation_discount,
            q.grand_total AS quotation_grand_total,
            q.status AS quotation_status,
			q.srvice_discount as sdiscount,

            c.name  AS customer_name,
            c.phone AS customer_phone,
            c.email AS customer_email,
			c.trn as customer_trn,
			c.address as cistomer_address,
			c.emirates as customer_emirates,

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
			qs.discount_percentage,
			qs.discount_amount,
			qs.taxable_amount,

            s.service_name,
            s.service_type')
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
			qp.dis_amount,
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

		/* =====================================================
			4. Jobcard Services / Labour (FOR INVOICE)
			===================================================== */

		$jobcard->descriptions = $this->db
			->select('
        qjd.id AS quotation_job_description_id,
        qjd.description,
        qjd.amount,

        e.employee_id,
        e.employee_name    ')
			->from('quotation_job_descriptions qjd')
			->join(
				'employees e',
				'e.employee_id = qjd.employee_id',
				'left'
			)
			->where('qjd.quotation_id', $jobcard->quotation_id)
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
            q.quotation_id,
            q.quotation_no,
            q.srvice_discount as sdiscount,

            c.name  AS customer_name,
            c.phone AS customer_phone,

            v.registration_no,
            v.brand,
            v.model')
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

		$quotation_id = $jobcard->quotation_id;

		/* =====================================================
			2. SERVICES (Exclude Already Invoiced)
				===================================================== */

		$jobcard->services = $this->db
			->select('
            qs.service_id,
            qs.total_cost,
            qs.discount_amount,
            s.service_name,
            s.service_type
        ')
			->from('quotation_services qs')

			->join(
				'invoice_items ii',
				"ii.source_jobcard_item_id = qs.service_id
             AND ii.item_type='Service'",
				'left'
			)

			->join(
				'invoices inv',
				"inv.invoice_id = ii.invoice_id
             AND inv.quotation_id = {$quotation_id}",
				'left'
			)

			->join(
				'services_master s',
				's.master_service_id = qs.service_id',
				'left'
			)

			->where('qs.quotation_id', $quotation_id)
			->where('inv.invoice_id IS NULL', null, false)

			->get()
			->result();



		/* =====================================================
			3. PARTS (Exclude Already Invoiced)
			===================================================== */

		$jobcard->parts = $this->db
			->select('
            qp.part_id,
            qp.qty,
            qp.selling_price,
            qp.dis_amount,
            qp.total_price,
            p.part_name
        ')
			->from('quotation_parts qp')

			->join(
				'invoice_items ii',
				"ii.source_jobcard_item_id = qp.part_id
             AND ii.item_type='Part'",
				'left'
			)

			->join(
				'invoices inv',
				"inv.invoice_id = ii.invoice_id
             AND inv.quotation_id = {$quotation_id}",
				'left'
			)

			->join(
				'spare_parts p',
				'p.part_id = qp.part_id',
				'left'
			)

			->where('qp.quotation_id', $quotation_id)
			->where('inv.invoice_id IS NULL', null, false)

			->get()
			->result();



		/* =====================================================
			4. SUBLET / DESCRIPTIONS
			===================================================== */

		$jobcard->descriptions = $this->db
			->select('
            qjd.id,
            qjd.description,
            qjd.amount,
            e.employee_name
        ')
			->from('quotation_job_descriptions qjd')

			->join(
				'invoice_items ii',
				"ii.source_jobcard_item_id = qjd.id
             AND ii.item_type='Sublet'",
				'left'
			)

			->join(
				'invoices inv',
				"inv.invoice_id = ii.invoice_id
             AND inv.quotation_id = {$quotation_id}",
				'left'
			)

			->join(
				'employees e',
				'e.employee_id = qjd.employee_id',
				'left'
			)

			->where('qjd.quotation_id', $quotation_id)
			->where('inv.invoice_id IS NULL', null, false)

			->get()
			->result();



		/* =====================================================
			5. FULLY INVOICED CHECK
			===================================================== */

		$jobcard->fully_invoiced =
			empty($jobcard->services) &&
			empty($jobcard->parts) &&
			empty($jobcard->descriptions);


		return $jobcard;
	}




	public function get_jobcard_basic($jobcard_id)
	{
		return $this->db
			->select('j.jobcard_no,j.jobcard_id,j.status, c.name, v.registration_no')
			->from('job_cards j')
			->join('customers c', 'c.customer_id = j.customer_id')
			->join('vehicles v', 'v.vehicle_id = j.vehicle_id')
			->where('j.jobcard_id', $jobcard_id)
			->get()->row();
	}

	// public function get_jobcard_descriptions_with_employee($jobcard_id)
	// {
	// 	return $this->db
	// 		->select('jd.*, e.employee_name')
	// 		->from('jobcard_services jd')
	// 		->join('employees e', 'e.employee_id = jd.employee_id')
	// 		->where('jd.jobcard_id', $jobcard_id)
	// 		->get()->result();

	// 	// return $this->db
	// 	// 	->select('jd.*')
	// 	// 	->from('jobcard_descriptions jd')

	// 	// 	->where('jd.jobcard_id', $jobcard_id)
	// 	// 	->get()->result();
	// }

	public function get_jobcard_descriptions_with_employee($jobcard_id)
	{
		return $this->db
			->select('
            js.*,
            e.employee_name,
            sm.service_name,
            sm.service_type,
            sm.estimated_cost,
            sm.estimated_time
        ')
			->from('jobcard_services js')
			->join(
				'employees e',
				'e.employee_id = js.employee_id',
				'left'
			)
			->join(
				'services_master sm',
				'sm.master_service_id = js.service_id',
				'left'
			)
			->where('js.jobcard_id', $jobcard_id)
			->get()
			->result();
	}


	public function get_latest_work_status($jobcard_id)
	{
		$subQuery = $this->db
			->select('jobcard_service_id, MAX(log_time) as last_time')
			->from('jobcard_work_logs')
			->where('jobcard_id', $jobcard_id)
			->group_by('jobcard_service_id')
			->get_compiled_select();

		return $this->db
			->select('w.jobcard_service_id, w.status')
			->from('jobcard_work_logs w')
			->join(
				"($subQuery) t",
				'w.jobcard_service_id = t.jobcard_service_id AND w.log_time = t.last_time'
			)
			->get()
			->result();
	}


	public function get_jobcard_work_times($jobcard_id)
	{
		$rows = $this->db
			->select('jobcard_service_id, status, log_time')
			->from('jobcard_work_logs')
			->where('jobcard_id', $jobcard_id)
			->order_by('log_time', 'ASC')
			->get()
			->result();

		$times = [];

		foreach ($rows as $r) {
			if (!isset($times[$r->jobcard_service_id])) {
				$times[$r->jobcard_service_id] = [
					'START' => null,
					'PAUSE' => null,
					'STOP'  => null,
				];
			}

			// overwrite → latest time wins
			$times[$r->jobcard_service_id][$r->status] = $r->log_time;
		}

		return $times;
	}
	public function generate_jobcard_no_from_model123()
	{
		$year = date('Y');

		$last = $this->db
			->like('jobcard_no', "JC-$year-", 'after')
			->order_by('jobcard_id', 'DESC')
			->limit(1)
			->get('job_cards')
			->row();

		if ($last) {
			$last_no = intval(substr($last->jobcard_no, -4));
			$new_no  = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
		} else {
			$new_no = '0001';
		}

		return "JC-$year-$new_no";
	}
	public function generate_jobcard_no_from_model()
	{
		$year = date('Y');

		$last = $this->db
			->select('jobcard_no')
			->like('jobcard_no', "JC-$year-", 'after')
			->order_by('jobcard_id', 'DESC')
			// ->order_by("CAST(SUBSTRING_INDEX(jobcard_no,'-',-1) AS UNSIGNED)", "DESC")
			->limit(1)
			->get('job_cards')
			->row();

		if ($last) {

			$parts   = explode('-', $last->jobcard_no);
			$last_no = intval(end($parts));

			$new_no  = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
		} else {
			$new_no = '0001';
		}

		return "JC-$year-$new_no";
	}
	public function create_from_quotation($quotation_id)
	{

		$q = $this->db->get_where('quotations', [
			'quotation_id' => $quotation_id
		])->row();

		if (!$q) {
			show_error('Quotation not found');
		}

		$jobcard_no = $this->generate_jobcard_no_from_model(); // call function here

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
			'jobcard_no' => $jobcard_no,

			'status'         => 'Pending',
			'created_at'     => date('Y-m-d H:i:s'),
			'created_by'     => $this->session->userdata('user_id') ?? null
		]);

		$jobcard_id = $this->db->insert_id();

		// // 2️⃣ Generate Job Card No
		// $year = date('Y');
		// $jobcard_no = 'JC-' . $year . '-' . str_pad($jobcard_id, 6, '0', STR_PAD_LEFT);

		// // 3️⃣ Update job card with number
		// $this->Jobcard_model->update_jobcard(
		// 	$jobcard_id,
		// 	['jobcard_no' => $jobcard_no]
		// );

		// Copy jobs
		$jobs = $this->db->get_where('quotation_job_descriptions', [
			'quotation_id' => $quotation_id,
		])->result();

		// $jobs = $this->db->get_where('quotation_services', [
		// 	'quotation_id' => $quotation_id
		// ])->result();

		foreach ($jobs as $j) {
			$this->db->insert('jobcard_descriptions', [
				'jobcard_id' => $jobcard_id,
				'description' => $j->description,
				'amount' => $j->amount,
				// 'service_id' => $j->service_id,

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
				'total_price'  => $p->total_price,
				'disamount'  => $p->dis_amount
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


	public function get_jobcards_by_status($status)
	{
		return $this->db
			->select('
            jc.jobcard_id,
            jc.jobcard_no,
            jc.jobcard_date,
            jc.expected_delivery_date,
            jc.status,
            jc.grand_total,

            c.name AS customer_name,
            v.registration_no,
            e.employee_name AS technician_name
        ')
			->from('job_cards jc')
			->join('customers c', 'c.customer_id = jc.customer_id')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id')
			->join('employees e', 'e.employee_id = jc.technician_id', 'left')
			->where('jc.status', $status)
			->order_by('jc.created_at', 'DESC')
			->get()
			->result();
	}

	public function get_by_quotation_id($quotation_id)
	{
		return $this->db
			->where('quotation_id', $quotation_id)
			->get('job_cards')
			->row();
	}
}
