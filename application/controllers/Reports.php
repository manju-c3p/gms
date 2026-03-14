<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		$this->load->model('Supplier_model');
		$this->load->model('Setup_model');
		$this->load->model('Reports_model');
		$this->load->model('SpareParts_model');

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}
	public function daily_jobs()
	{
		$this->load->model('Reports_model');

		$date = $this->input->get('date') ?? date('Y-m-d');

		$data['title'] = 'Daily Job Report';
		$data['date']  = $date;
		$data['jobs']  = $this->Reports_model->get_daily_job_report($date);


		$data['main_content'] = 'reports/daily_jobs';
		$this->load->view('includes/template', $data);
	}
	public function revenue()
	{
		$this->load->model('Reports_model');

		$from = $this->input->get('from') ?? date('Y-m-01');
		$to   = $this->input->get('to') ?? date('Y-m-d');

		$data['title'] = 'Revenue Report';
		$data['from']  = $from;
		$data['to']    = $to;

		$data['reports'] = $this->Reports_model->get_revenue_report($from, $to);

		// Totals
		$data['total_revenue'] = array_sum(array_column($data['reports'], 'grand_total'));
		$data['total_tax']     = array_sum(array_column($data['reports'], 'tax_amount'));



		$data['main_content'] = 'reports/revenue';
		$this->load->view('includes/template', $data);
	}

	public function inventory_usage()
	{
		$this->load->model('Reports_model');

		$from = $this->input->get('from') ?? date('Y-m-01');
		$to   = $this->input->get('to') ?? date('Y-m-d');

		$data['title'] = 'Inventory Usage Report';
		$data['from']  = $from;
		$data['to']    = $to;

		$data['items'] = $this->Reports_model->get_inventory_usage_report($from, $to);


		$data['main_content'] = 'reports/inventory_usage';
		$this->load->view('includes/template', $data);
	}

	public function customer_visits()
	{
		$this->load->model('Reports_model');
		$this->load->model('Customer_model');

		$from = $this->input->get('from') ?? date('Y-m-01');
		$to   = $this->input->get('to') ?? date('Y-m-d');
		$customer_id = $this->input->get('customer_id');

		$data['title'] = 'Customer Visit History';
		$data['from']  = $from;
		$data['to']    = $to;

		$data['customers'] = $this->Customer_model->get_all_customers();
		$data['visits'] = $this->Reports_model
			->get_customer_visit_history($from, $to, $customer_id);


		$data['main_content'] = 'reports/customer_visits';
		$this->load->view('includes/template', $data);
	}
	// ============================================
	///////////////  RFQ Report ////////////////////
	function rfq_report()
	{
		$data['from'] = date('Y-m-01');
		$data['to'] = date('Y-m-d');
		$data['status'] = "";
		$data['title'] = "RFQ Report";
		$data['records'] = array();
		$data['supplier_id'] = "";
		$data['user_list'] = $this->Setup_model->get_all_users();
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['main_content'] = 'reports/Purchase/rfq_report.php';
		$this->load->view('includes/template.php', $data);
	}
	function get_rfq_report()
	{
		$data['from'] = $this->input->post('from_date');
		$data['to'] = $this->input->post('to_date');
		$data['title'] = "RFQ Report";
		$data['created_by'] = $this->input->post('created_by');
		$data['supplier_id'] = $this->input->post('supplier_id');

		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['records'] = $this->Reports_model->get_rfq_report_records();
		$data['main_content'] = 'reports/Purchase/rfq_report.php';
		$this->load->view('includes/template.php', $data);
	}
	public function print_rfq_report()
	{
		$from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');
		$supplier_id = $this->input->get('supplier_id');
		$data['from'] = $from_date;
		$data['to'] = $to_date;
		$data['supplier_id'] = $supplier_id;
		// Fetch filtered records again
		$data['records'] = $this->Reports_model->get_rfq_report_records();

		$data['supplier_id'] = $supplier_id;

		$this->load->view('reports/Purchase/Print/print_rfq_report', $data);
	}


	///////////////  PO Report ////////////////////
	function po_report()
	{
		$data['from'] = date('Y-m-01');
		$data['to'] = date('Y-m-d');
		$data['status'] = "";
		$data['title'] = "Purchase Order Report";
		$data['supplier_id'] = "";
		$data['brand_id'] = "";
		$data['records'] = array();
		$data['user_list'] = $this->Setup_model->get_all_users();
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['all_brands'] = $this->SpareParts_model->get_all_parts();
		$data['main_content'] = 'reports/Purchase/po_report.php';
		$this->load->view('includes/template.php', $data);
	}
	function get_po_report()
	{
		$data['from'] = $this->input->post('from_date');
		$data['to'] = $this->input->post('to_date');
		$data['title'] = "Purchase Order Report";
		$data['brand_id'] = $this->input->post('brand_id');
		$data['created_by'] = $this->input->post('created_by');
		$data['supplier_id'] = $this->input->post('supplier_id');
		$data['all_brands'] = $this->SpareParts_model->get_all_parts();
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['records'] = $this->Reports_model->get_po_report_records();
		$data['main_content'] = 'reports/Purchase/po_report.php';
		$this->load->view('includes/template.php', $data);
	}

	public function export_po_excel()
	{
		$from_date = $this->input->get('from_date');
		$to_date   = $this->input->get('to_date');
		$supplier  = $this->input->get('supplier');


		$po_list = $this->Reports_model->get_po_report($from_date, $to_date, $supplier);

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=PO_Report_" . date('Ymd') . ".xls");

		echo "<table border='1'>";
		echo "<tr>
            <th>Sr No</th>
            <th>PO Code</th>
            <th>PO Date</th>
            <th>Supplier</th>
            <th>Grand Total</th>
          </tr>";

		$i = 1;
		foreach ($po_list as $row) {
			echo "<tr>
                <td>" . $i++ . "</td>
                <td>" . $row->po_code . "</td>
                <td>" . date('d-M-Y', strtotime($row->po_date)) . "</td>
                <td>" . $row->supplier_name . "</td>
                <td>" . $row->grand_total . "</td>
              </tr>";
		}

		echo "</table>";
	}

	public function print_po_report()
	{
		$from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');
		$supplier_id = $this->input->get('supplier_id');
		// $brand_id = $this->input->get('brand_id');
		$data['from'] = $from_date;
		$data['to'] = $to_date;
		$data['supplier_id'] = $supplier_id;
		// $data['brand_id'] = $brand_id;
		// Fetch filtered records again
		$data['records'] = $this->Reports_model->get_po_report_records();

		$data['supplier_id'] = $supplier_id;

		$this->load->view('Reports/Purchase/Print/print_po_report', $data);
	}
	///////////////  GRN Report ////////////////////
	function grn_report()
	{
		$data['from'] = date('Y-m-01');
		$data['to'] = date('Y-m-d');
		$data['status'] = "";
		$data['title'] = "Goods Received Note Report";
		$data['supplier_id'] = "";
		$data['records'] = array();
		$data['user_list'] = $this->Setup_model->get_all_users();
		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['main_content'] = 'reports/Purchase/grn_report.php';
		$this->load->view('includes/template.php', $data);
	}
	function get_grn_report()
	{
		$data['from'] = $this->input->post('from_date');
		$data['to'] = $this->input->post('to_date');
		$data['title'] = "Goods Received Note Report";
		$data['created_by'] = $this->input->post('created_by');
		$data['supplier_id'] = $this->input->post('supplier_id');

		$data['supplier_records'] = $this->Supplier_model->get_active_supplier_list();
		$data['records'] = $this->Reports_model->get_grn_report_records();
		$data['main_content'] = 'reports/Purchase/grn_report.php';
		$this->load->view('includes/template.php', $data);
	}
	public function print_grn_report()
	{
		$from_date = $this->input->get('from_date');
		$to_date = $this->input->get('to_date');
		$supplier_id = $this->input->get('supplier_id');
		$data['from'] = $from_date;
		$data['to'] = $to_date;
		$data['supplier_id'] = $supplier_id;
		// Fetch filtered records again
		$data['records'] = $this->Reports_model->get_grn_report_records();

		$data['supplier_id'] = $supplier_id;

		$this->load->view('reports/Purchase/Print/print_grn_report', $data);
	}

	// ================================================

	public function employee_report()
	{
		$this->load->model('Employee_model');
		$this->load->model('Setup_model');

		// Dropdowns
		$data['user_records'] = $this->Setup_model->get_all_users();
		$data['departments'] = $this->Employee_model->get_departments();
		$data['designations'] = $this->Employee_model->get_designations_with_department();

		// Initialize filters and records
		$data['user_id'] = '';
		$data['selected_dept'] = '';
		$data['selected_desig'] = '';
		$data['records'] = [];
		$data['is_generated'] = false;  // Initialize flag

		// Check if form is submitted
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$user_id = $this->input->post('user_id');
			$dept_id = $this->input->post('department_id');
			$desig_id = $this->input->post('designation_id');

			$filters = [
				'user_id' => $user_id,
				'department_id' => $dept_id,
				'designation_id' => $desig_id
			];

			// Fetch filtered data
			$data['records'] = $this->Employee_model->get_filtered_employees($filters);
			$data['user_id'] = $user_id;
			$data['selected_dept'] = $dept_id;
			$data['selected_desig'] = $desig_id;
			$data['is_generated'] = true;
		}

		$data['title'] = 'Employee Master Report';
		$data['main_content'] = 'reports/employee_report.php';
		$this->load->view('includes/template.php', $data);
	}


	public function print_employee_report()
	{
		// $this->load->model('Users_model');
		$this->load->model('Setup_model');

		// Fetch filters from POST
		$user_id = $this->input->post('user_id');
		$dept_id = $this->input->post('department_id');
		$desig_id = $this->input->post('designation_id');
		$is_generated = $this->input->post('is_generated');

		// Set filters array
		$filters = [
			'user_id' => $user_id,
			'department_id' => $dept_id,
			'designation_id' => $desig_id,
		];

		// Ensure print only if report was generated
		if ($is_generated !== '1') {
			$data['records'] = [];  // Show "No records found"
		} else {
			$data['records'] = $this->Users_model->get_filtered_employees($filters);
		}

		// Other data
		$data['title'] = 'Employee Master Report';
		$data['filters'] = $filters;
		$data['user_id'] = $user_id;
		$data['departments'] = $this->Setup_model->get_department_list();
		$data['designations'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Setup_model->get_all_users();

		// Load print view
		$this->load->view('Print/print_employee_report', $data);
	}

	public function export_employee_report()
	{

		$this->load->model('Users_model');
		$this->load->model('Setup_model');

		// Fetch filters from POST
		$user_id = $this->input->post('user_id');
		$dept_id = $this->input->post('department_id');
		$desig_id = $this->input->post('designation_id');
		$is_generated = $this->input->post('is_generated');

		// Set filters array
		$filters = [
			'user_id' => $user_id,
			'department_id' => $dept_id,
			'designation_id' => $desig_id,
		];
		// Only load data if report was generated
		if ($is_generated !== '1') {
			$data['records'] = [];
		} else {
			$data['records'] = $this->Users_model->get_filtered_employees($filters);
		}
		// Pass data to view
		$data['title'] = 'Employee Master Report';
		$data['filters'] = $filters;
		$data['user_id'] = $user_id;
		$data['departments'] = $this->Setup_model->get_department_list();
		$data['designations'] = $this->Setup_model->get_designation_list();
		$data['user_records'] = $this->Users_model->get_active_user_list();

		$this->load->view('excel_reports/export_employee_report', $data);
	}


	public function monthly_leave_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');

		// Default filters
		$month = $this->input->post('month') ?? date('Y-m');
		$dept_id = $this->input->post('department_id') ?? '';

		// Fetch dropdown data
		$data['departments'] = $this->Setup_model->get_department_list();

		// Fetch leave report
		$data['records'] = $this->Hr_model->get_monthly_leave_report($month, $dept_id);

		// Filters for reuse in view
		$data['selected_month'] = $month;
		$data['selected_dept'] = $dept_id;

		// Page details
		$data['title'] = 'Monthly Leave Report';
		$data['main_content'] = 'Reports/monthly_leave_report';
		$this->load->view('includes/template', $data); // Corrected template load
	}


	public function print_monthly_leave_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');

		$month = $this->input->post('month');
		$dept_id = $this->input->post('department_id');

		$data['records'] = $this->Hr_model->get_monthly_leave_report($month, $dept_id);
		$data['selected_month'] = $month;
		$data['selected_dept'] = $dept_id;
		$data['departments'] = $this->Setup_model->get_department_list();

		$this->load->view('Print/print_monthly_leave_report', $data);
	}

	public function export_monthly_leave_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');

		$month = $this->input->post('month');
		$dept_id = $this->input->post('department_id');

		$data['records'] = $this->Hr_model->get_monthly_leave_report($month, $dept_id);
		$data['selected_month'] = $month;

		if (!empty($dept_id)) {
			$dept = $this->Setup_model->get_department_by_id($dept_id);
			$data['selected_dept_name'] = $dept->dept_name ?? 'Unknown';
		} else {
			$data['selected_dept_name'] = 'All';
		}

		$this->load->view('excel_reports/export_monthly_leave_report', $data);
	}

	public function monthly_attendance_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');

		$data['departments'] = $this->Setup_model->get_department_list();

		$data['records'] = [];
		$data['from_date'] = '';
		$data['to_date'] = '';
		$data['selected_dept'] = '';

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$from_date = $this->input->post('from_date');
			$to_date   = $this->input->post('to_date');
			$dept_id = $this->input->post('department_id');



			$data['records'] = $this->Hr_model->get_monthly_attendance_summary($from_date, $to_date, $dept_id);
			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
			$data['selected_dept'] = $dept_id;
		}

		$data['title'] = 'Monthly Attendance Report';
		$data['main_content'] = 'Reports/monthly_attendance_report.php';
		$this->load->view('includes/template.php', $data);
	}


	public function print_monthly_attendance_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');

		// Accept POST or GET
		$from_date = $this->input->post('from_date') ?? $this->input->get('from_date');
		$to_date   = $this->input->post('to_date') ?? $this->input->get('to_date');
		$dept_id   = $this->input->post('department_id') ?? $this->input->get('department_id');

		$data['records'] = [];
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['selected_dept'] = $dept_id;
		$data['departments'] = $this->Setup_model->get_department_list();

		if (!empty($from_date) && !empty($to_date)) {
			$data['records'] = $this->Hr_model->get_monthly_attendance_summary(
				$from_date,
				$to_date,
				$dept_id
			);
		}

		$this->load->view('Print/print_monthly_attendance_report', $data);
	}


	public function export_monthly_attendance_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Setup_model');

		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		$dept_id = $this->input->post('department_id');
		// Set basic data
		$data['records'] = [];
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['selected_dept'] = $dept_id;
		$data['departments'] = $this->Setup_model->get_department_list();

		// Fetch only if month is posted (i.e., report was generated)
		if (!empty($from_date) && !empty($to_date)) {
			$data['records'] = $this->Hr_model->get_monthly_attendance_summary($from_date, $to_date, $dept_id);
		}


		$this->load->view('excel_reports/export_monthly_attendance_report', $data);
	}

	public function monthly_payroll_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$this->load->model('Setup_model');

		$selected_month = $this->input->post('month') ?? date('Y-m');
		$selected_dept = $this->input->post('department_id') ?? '';
		$user_id = $this->input->post('user_id') ?? '';
		$generate = (int) ($this->input->post('generate') ?? 0);

		// Clear session when page is loaded without Generate
		if ($this->input->server('REQUEST_METHOD') === 'GET' || $generate !== 1) {
			$this->session->unset_userdata('payroll_filters');
		}

		$data = [
			'selected_month' => $selected_month,
			'selected_dept' => $selected_dept,
			'user_id' => $user_id,
			'departments' => $this->Setup_model->get_department_list(),
			'user_records' => $this->Users_model->get_user_list(),
			'records' => null,
			'days_in_month' => null,
			'holiday_count' => null,
			'generate' => $generate,
			'title' => 'Monthly Payroll Report',
			'main_content' => 'Reports/monthly_payroll_report.php',
		];

		if ($generate === 1 && !empty($selected_month)) {
			$days_in_month = date('t', strtotime($selected_month));

			// Store to session when generated
			$this->session->set_userdata('payroll_filters', [
				'month' => $selected_month,
				'department_id' => $selected_dept,
				'user_id' => $user_id,
				'generate' => true
			]);

			$data['days_in_month'] = $days_in_month;
			$filters = [
				'month' => $selected_month,
				'department_id' => $selected_dept,
				'user_id' => $user_id,
			];
			$data['records'] = $this->Hr_model->get_monthly_payroll_report($filters);
			$data['holiday_count'] = $this->Hr_model->get_emp_holiday_count();

			foreach ($data['records'] as &$record) {
				$record->days_in_month = $days_in_month;
				$record->selected_month = $selected_month;
				$record->holiday_count = $data['holiday_count'];
			}
		}

		$this->load->view('includes/template', $data);
	}


	public function print_monthly_payroll_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$this->load->model('Setup_model');

		// Get filters from session
		$filters = $this->session->userdata('payroll_filters');

		$selected_month = $filters['month'] ?? '';
		$selected_dept = $filters['department_id'] ?? '';
		$user_id = $filters['user_id'] ?? '';
		$is_generated = isset($filters['generate']) && $filters['generate'] === true;

		$data = [
			'selected_month' => $selected_month,
			'selected_dept' => $selected_dept,
			'user_id' => $user_id,
			'departments' => $this->Setup_model->get_department_list(),
			'user_records' => $this->Users_model->get_user_list(),
			'days_in_month' => 0,
			'records' => [],
			'holiday_count' => $this->Hr_model->get_emp_holiday_count(),
			'generate_flag' => $is_generated,
		];

		if ($is_generated && !empty($selected_month)) {
			$data['days_in_month'] = date('t', strtotime($selected_month));
			$filter_data = [
				'month' => $selected_month,
				'department_id' => $selected_dept,
				'user_id' => $user_id,
			];
			$data['records'] = $this->Hr_model->get_monthly_payroll_report($filter_data);
		}

		$this->load->view('Print/print_monthly_payroll_report', $data);
	}


	public function export_monthly_payroll_report()
	{
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$this->load->model('Setup_model');

		$filters = $this->session->userdata('payroll_filters') ?? [];

		$selected_month = $filters['month'] ?? '';
		$selected_dept = $filters['department_id'] ?? '';
		$user_id = $filters['user_id'] ?? '';
		$is_generated = !empty($filters['generate']);

		$data = [
			'selected_month' => $selected_month,
			'selected_dept' => $selected_dept,
			'user_id' => $user_id,
			'departments' => $this->Setup_model->get_department_list(),
			'user_records' => $this->Users_model->get_user_list(),
			'days_in_month' => 0,
			'records' => [],
			'holiday_count' => $this->Hr_model->get_emp_holiday_count(),
			'generate_flag' => $is_generated,
		];

		if ($is_generated && !empty($selected_month) && strtotime($selected_month) !== false) {
			$data['days_in_month'] = date('t', strtotime($selected_month));
			$filter_data = [
				'month' => $selected_month,
				'department_id' => $selected_dept,
				'user_id' => $user_id,
			];
			$data['records'] = $this->Hr_model->get_monthly_payroll_report($filter_data);
		}

		$this->load->view('excel_reports/export_monthly_payroll_report', $data);
	}
}
