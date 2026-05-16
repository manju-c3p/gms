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
	public function get_pending_job_cards()
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

	public function get_Scheduled_job_cards_count()
	{
		return $this->db
			->from('job_cards')
			->where_in('status', ['Scheduled'])
			->count_all_results();
	}
	public function get_inprogress_job_cards_count()
	{
		return $this->db
			->from('job_cards')
			->where_in('status', ['In Progress'])
			->count_all_results();
	}
	public function get_finished_job_cards_count()
	{
		return $this->db
			->from('job_cards')
			->where_in('status', ['Finished', ''])
			->count_all_results();
	}

	public function get_active_job_cards_count()
	{
		return $this->db
			->from('job_cards')
			->where_in('status', ['Scheduled', 'In Progress', 'Finished', ''])
			->count_all_results();
	}
	public function get_customers_count()
	{
		return $this->db
			->from('customers')
			->count_all_results();
	}
	public function get_vehicles_count()
	{
		return $this->db
			->from('vehicles')
			->count_all_results();
	}
	public function get_total_revenue()
	{
		return (float) $this->db
			->select('COALESCE(SUM(grand_total), 0) AS total_revenue')
			->from('invoices')
			// ->where('status', 'Paid')
			->get()
			->row()
			->total_revenue;
	}
	public function get_grn_count()
	{
		return $this->db
			->from('purchase_grn_master')
			->count_all_results();
	}
	public function get_purchase_order_count()
	{
		return $this->db
			->from('purchase_order_master')
			->count_all_results();
	}
	public function get_purchase_return_count()
	{
		return $this->db
			->from('purchase_return')
			->count_all_results();
	}

	public function get_total_purchase_amount()
	{
		return $this->db
			->select('SUM(grand_total) as total')
			->from('purchase_order_master')
			->where('cancelled', 0) // important
			->get()
			->row()
			->total ?? 0;
	}
	public function get_parts_po_summary()
	{
		return $this->db
			->select('COUNT(po_id) as count, SUM(grand_total) as total')
			->from('purchase_order_master')
			->where('purchase_type', 'PARTS')
			->where('cancelled', 0)
			->get()
			->row();
	}
	public function get_service_po_summary()
	{
		return $this->db
			->select('COUNT(po_id) as count, SUM(grand_total) as total')
			->from('purchase_order_master')
			->where('purchase_type', 'SERVICE')
			->where('cancelled', 0)
			->get()
			->row();
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

	public function get_low_stock_items_old()
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

	public function get_low_stock_items()
	{
		return $this->db
			->select('
            sp.part_id,
            sp.part_name,
            sp.min_stock,
            vb.brand_name,
            IFNULL(ss.current_stock, 0) AS current_stock
        ')
			->from('spare_parts sp')

			// Brand
			->join('vehicle_brands vb', 'vb.brand_id = sp.brand_id', 'left')

			// ✅ Use stock_summary (NO calculations)
			->join('stock_summary ss', 'ss.part_id = sp.part_id', 'left')

			// Low stock condition
			->where('IFNULL(ss.current_stock, 0) <= sp.min_stock')

			->order_by('ss.current_stock', 'ASC')
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

	public function get_jobcard_time_report()
	{
		// Get jobcards with description count & employee
		$sql = "
			SELECT 
				j.jobcard_id,
				j.jobcard_no,
				e.employee_name AS employee_name,
				COUNT(d.jobcard_description_id) AS total_jobs
			FROM job_cards j
			JOIN jobcard_descriptions d ON d.jobcard_id = j.jobcard_id
			JOIN employees e ON e.employee_id = d.employee_id
			WHERE j.status != 'COMPLETED'
			GROUP BY j.jobcard_id, e.employee_id
			";

		$rows = $this->db->query($sql)->result();

		foreach ($rows as &$row) {
			$row->worked_hours = $this->calculate_worked_hours($row->jobcard_id);
			$row->completed_jobs = $this->get_completed_jobs($row->jobcard_id);

			$row->progress = $row->total_jobs > 0
				? round(($row->completed_jobs / $row->total_jobs) * 100)
				: 0;
		}

		return $rows;
	}
	private function calculate_worked_hours($jobcard_id)
	{
		$logs = $this->db
			->where('jobcard_id', $jobcard_id)
			->order_by('jobcard_description_id, log_time')
			->get('jobcard_work_logs')
			->result();

		$totalSeconds = 0;
		$lastStart = [];

		foreach ($logs as $log) {

			$key = $log->jobcard_description_id;

			if (in_array($log->status, ['START', 'RESUME'])) {
				$lastStart[$key] = strtotime($log->log_time);
			}

			if (in_array($log->status, ['PAUSE', 'STOP']) && isset($lastStart[$key])) {
				$totalSeconds += strtotime($log->log_time) - $lastStart[$key];
				unset($lastStart[$key]);
			}
		}

		return round($totalSeconds / 3600, 2); // hours
	}

	private function get_completed_jobs($jobcard_id)
	{
		return $this->db
			->select('COUNT(DISTINCT jobcard_description_id) AS completed')
			->where('jobcard_id', $jobcard_id)
			->where('status', 'STOP')
			->get('jobcard_work_logs')
			->row()
			->completed ?? 0;
	}


	public function get_jobcard_job_completion123()
	{
		return $this->db
			->select('
            jc.jobcard_id,
            jc.jobcard_no,

            COUNT(DISTINCT jd.jobcard_description_id) AS total_jobs,

            COUNT(DISTINCT CASE 
                WHEN wl.status = "STOP" 
                THEN wl.jobcard_description_id 
            END) AS completed_jobs
        ')
			->from('job_cards jc')
			->join(
				'jobcard_descriptions jd',
				'jd.jobcard_id = jc.jobcard_id',
				'left'
			)
			->join(
				'jobcard_work_logs wl',
				'wl.jobcard_description_id = jd.jobcard_description_id',
				'left'
			)
			->group_by('jc.jobcard_id')
			->order_by('jc.created_at', 'DESC')
			->get()
			->result();
	}

	public function get_jobcard_job_completionold()
	{
		return $this->db
			->select('
            jc.jobcard_id,
            jc.jobcard_no,

            COUNT(DISTINCT js.jobcard_service_id) AS total_jobs,

            COUNT(DISTINCT CASE
                WHEN wl.status = "STOP"
                THEN wl.jobcard_service_id
            END) AS completed_jobs
        ')
			->from('job_cards jc')
			->join(
				'jobcard_services js',
				'js.jobcard_id = jc.jobcard_id',
				'left'
			)
			->join(
				'jobcard_work_logs wl',
				'wl.jobcard_service_id = js.jobcard_service_id',
				'left'
			)
			->group_by('jc.jobcard_id')
			->order_by('jc.created_at', 'DESC')
			->get()
			->result();
	}
	public function get_jobcard_job_completion()
	{
		return $this->db
			->select('
            jc.jobcard_id,
            jc.jobcard_no,
            jc.jobcard_date,

            c.name AS customer_name,
            v.registration_no,
            v.model,

            COUNT(DISTINCT js.jobcard_service_id) AS total_jobs,

            COUNT(DISTINCT CASE
                WHEN wl.status = "STOP"
                THEN wl.jobcard_service_id
            END) AS completed_jobs
        ')
			->from('job_cards jc')

			->join('customers c', 'c.customer_id = jc.customer_id', 'left')
			->join('vehicles v', 'v.vehicle_id = jc.vehicle_id', 'left')

			->join('jobcard_services js', 'js.jobcard_id = jc.jobcard_id', 'left')

			->join(
				'jobcard_work_logs wl',
				'wl.jobcard_service_id = js.jobcard_service_id',
				'left'
			)

			->group_by('jc.jobcard_id')
			->order_by('jc.created_at', 'DESC')
			->limit(10)   // Limit to 10 records
			->get()
			->result();
	}


	public function get_jobcard_job_progress()
	{
		$standardMinutes = 60; // 1 hour per job (configurable)

		$sql = "
    SELECT
        jc.jobcard_id,
        jc.jobcard_no,

        COUNT(DISTINCT jd.jobcard_description_id) AS total_jobs,

        SUM(
            CASE
                -- COMPLETED JOB
                WHEN stop_log.jobcard_description_id IS NOT NULL THEN 100

                -- RUNNING JOB
                WHEN start_log.jobcard_description_id IS NOT NULL THEN
                    LEAST(
                        (IFNULL(running_minutes.minutes, 0) / {$standardMinutes}) * 100,
                        99
                    )

                -- NOT STARTED
                ELSE 0
            END
        ) AS total_progress
    FROM job_cards jc
    LEFT JOIN jobcard_descriptions jd
        ON jd.jobcard_id = jc.jobcard_id

    -- STOP LOG
    LEFT JOIN (
        SELECT DISTINCT jobcard_description_id
        FROM jobcard_work_logs
        WHERE status = 'STOP'
    ) stop_log
        ON stop_log.jobcard_description_id = jd.jobcard_description_id

    -- START / RESUME EXISTENCE
    LEFT JOIN (
        SELECT DISTINCT jobcard_description_id
        FROM jobcard_work_logs
        WHERE status IN ('START','RESUME')
    ) start_log
        ON start_log.jobcard_description_id = jd.jobcard_description_id

    -- RUNNING TIME (no STOP yet)
    LEFT JOIN (
        SELECT
            wl.jobcard_description_id,
            SUM(
                TIMESTAMPDIFF(
                    MINUTE,
                    wl.log_time,
                    NOW()
                )
            ) AS minutes
        FROM jobcard_work_logs wl
        WHERE wl.status IN ('START','RESUME')
          AND NOT EXISTS (
              SELECT 1 FROM jobcard_work_logs s
              WHERE s.jobcard_description_id = wl.jobcard_description_id
                AND s.status = 'STOP'
          )
        GROUP BY wl.jobcard_description_id
    ) running_minutes
        ON running_minutes.jobcard_description_id = jd.jobcard_description_id

    GROUP BY jc.jobcard_id
    ORDER BY jc.created_at DESC
    ";

		return $this->db->query($sql)->result();
	}

	public function get_revenue_summary()
	{
		$query = $this->db->query("
        SELECT
            IFNULL(SUM(i.grand_total),0) AS total_invoice_amount,

            IFNULL((
                SELECT SUM(v.amount)
                FROM voucher_transaction v
                WHERE v.voucher_type = 'R'
                AND v.drcr_type = 'Cr'
                AND v.cancel = 0
            ),0) AS total_collected_amount

        FROM invoices i
        WHERE i.invoice_type = 'TI'
    ");

		$row = $query->row();

		$row->pending_amount = $row->total_invoice_amount - $row->total_collected_amount;

		return $row;
	}

	public function get_cash_bank_balances11()
	{
		$sql = "SELECT 
                gl.account_id,
                gl.account_name,
                ag.group_name,

                IFNULL(SUM(
                    CASE 
                        WHEN vt.drcr_type = 'Dr' THEN vt.amount
                        WHEN vt.drcr_type = 'Cr' THEN -vt.amount
                    END
                ),0) AS balance

            FROM general_ledger gl

            LEFT JOIN account_group ag 
                ON ag.group_no = gl.group_no

            LEFT JOIN voucher_transaction vt 
                ON vt.account_id = gl.account_id
                AND vt.cancel = 0

            -- WHERE ag.group_name IN ('Cash', 'Bank')
			WHERE ag.group_name IN ('Cash-in-hand', 'Bank Accounts')

            GROUP BY gl.account_id
            ORDER BY ag.group_name, gl.account_name";

		return $this->db->query($sql)->result();
	}

	public function get_cash_bank_balances()
	{
		$sql = "SELECT 
            gl.account_id,
            gl.account_name,
            ag.group_name,

            (
                IFNULL(
                    CASE 
                        WHEN gl.opening_bal_type = 'Dr' THEN gl.opening_balance
                        WHEN gl.opening_bal_type = 'Cr' THEN -gl.opening_balance
                        ELSE 0
                    END
                ,0)

                +

                IFNULL(SUM(
                    CASE 
                        WHEN vt.drcr_type = 'Dr' THEN vt.amount
                        WHEN vt.drcr_type = 'Cr' THEN -vt.amount
                    END
                ),0)

            ) AS balance

        FROM general_ledger gl

        LEFT JOIN account_group ag 
            ON ag.group_no = gl.group_no

        LEFT JOIN voucher_transaction vt 
            ON vt.account_id = gl.account_id
            AND vt.cancel = 0

        WHERE ag.group_name IN ('Cash-in-hand', 'Bank Accounts')

        GROUP BY gl.account_id
        ORDER BY ag.group_name, gl.account_name";

		return $this->db->query($sql)->result();
	}
}
