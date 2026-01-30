<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_vehicle_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_vehicle_import_model');
		$this->load->model('Customer_model');
		$this->load->model('Vehicle_model');
		$this->load->model('Vehicle_master_fix_model');
	}

	public function index()
	{
		$this->load->view('import/customer_vehicle_import');
	}

	public function upload()
	{
		if (empty($_FILES['csv_file']['name'])) {
			$this->session->set_flashdata('error', 'Please select a CSV file');
			redirect('customer_vehicle_import');
		}

		$file = $_FILES['csv_file']['tmp_name'];

		if (($handle = fopen($file, "r")) === FALSE) {
			$this->session->set_flashdata('error', 'Unable to open CSV file');
			redirect('customer_vehicle_import');
		}

		$header = fgetcsv($handle); // skip header row

		$this->db->trans_start();

		while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {

			// Map CSV columns by index
			$data = [
				'customer'      => trim($row[0] ?? ''),
				'mobile'        => trim($row[1] ?? ''),
				'bill_number'   => trim($row[2] ?? ''),
				'date'          => trim($row[3] ?? ''),
				'plate_no'      => trim($row[4] ?? ''),
				'brand'         => trim($row[5] ?? ''),
				'model'         => trim($row[6] ?? ''),
				'year'          => trim($row[7] ?? ''),
				'vin_no'        => trim($row[8] ?? ''),
				'opening_date'  => trim($row[9] ?? ''),
				'remarks'       => trim($row[10] ?? '')
			];

			// skip empty customer or phone
			if ($data['customer'] === '' && $data['mobile'] === '') {
				continue;
			}

			$this->Customer_vehicle_import_model
				->import_customer_vehicle($data);
		}

		fclose($handle);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Import failed');
		} else {
			$this->session->set_flashdata('success', 'CSV imported successfully');
		}

		redirect('customer_vehicle_import');
	}

	public function import_customers_from_csv()
	{
		if (empty($_FILES['csv_file1']['name'])) {
			$this->session->set_flashdata('error', 'Please select a CSV file');
			redirect('customer_vehicle_import');
		}

		$file_path = $_FILES['csv_file1']['tmp_name'];

		if (!file_exists($file_path)) {
			show_error('CSV file not found');
		}

		$handle = fopen($file_path, 'r');

		$row = 0;
		$total_rows = 0;
		$customers_added = 0;
		$added_list = [];

		// invalid plates list
		$invalid_plates = ['NOPLATE', '-', 'SOLD', '000', ''];

		while (($data = fgetcsv($handle, 2000, ',')) !== FALSE) {

			$row++;

			/* ========= SKIP HEADER ========= */
			if ($row === 1) {
				continue;
			}

			$customer_name = trim($data[0] ?? '');
			$mobile_raw    = trim($data[1] ?? '');
			$plate_no      = strtoupper(trim($data[2] ?? ''));
			$brand         = trim($data[3] ?? '');
			$model         = trim($data[4] ?? '');
			$vin_no        = trim($data[5] ?? '');

			/* ========= SKIP TOTAL ROW ========= */
			if (strtoupper($customer_name) === 'TOTAL') {
				continue;
			}

			/* ========= SKIP SERVICE / ITEM ROWS =========
           Service rows have no customer identity columns
        */
			if ($customer_name === '' && $plate_no === '' && $brand === '' && $model === '') {
				continue;
			}

			/* ========= VALID CUSTOMER ROW ========= */
			if ($customer_name === '') {
				continue;
			}

			$total_rows++;

			// normalize mobile (duplicates allowed)
			$mobile = preg_replace('/\D/', '', $mobile_raw);

			/* ========= INSERT CUSTOMER ========= */
			$customer_id = $this->Customer_model->create_customer([
				'name'       => $customer_name,
				'phone'      => $mobile,
				'created_at' => date('Y-m-d H:i:s')
			]);

			if ($customer_id) {
				$customers_added++;
				$added_list[] = [
					'name'   => $customer_name,
					'mobile' => $mobile
				];
			}

			/* ========= INSERT VEHICLE ========= */
			if (!in_array($plate_no, $invalid_plates)) {

				$this->Vehicle_model->create_vehicle([
					'customer_id'     => $customer_id,
					'registration_no' => $plate_no,
					'brand'           => $brand ?: null,
					'model'           => $model ?: null,
					'chassis_no'      => $vin_no ?: null,
					'created_at'      => date('Y-m-d H:i:s')
				]);
			}
		}

		fclose($handle);

		/* ========= SUMMARY ========= */

		echo "<h3>CSV Import Summary</h3>";
		echo "<p><strong>Total Customer Rows Imported:</strong> {$total_rows}</p>";
		echo "<p><strong>Customers Added:</strong> {$customers_added}</p>";

		if (!empty($added_list)) {
			echo "<h4>Added Customers</h4>";
			echo "<table border='1' cellpadding='6'>";
			echo "<tr><th>#</th><th>Name</th><th>Mobile</th></tr>";

			$i = 1;
			foreach ($added_list as $cust) {
				echo "<tr>
                    <td>{$i}</td>
                    <td>{$cust['name']}</td>
                    <td>{$cust['mobile']}</td>
                  </tr>";
				$i++;
			}
			echo "</table>";
		}

		echo "<br><strong>Customer & Vehicle import completed successfully.</strong>";
	}


	public function import_invoice_history_csv()
	{
		if (empty($_FILES['csv_file1']['tmp_name'])) {
			die('CSV file not uploaded');
		}

		$handle = fopen($_FILES['csv_file1']['tmp_name'], 'r');

		if (!$handle) {
			die('Unable to open CSV file');
		}

		$row = 0;

		$summary = [
			'customers_added'  => 0,
			'customers_used'   => 0,
			'vehicles_added'   => 0,
			'vehicles_skipped' => 0,
			'logs'             => []
		];

		while (($data = fgetcsv($handle, 2000, ',')) !== false) {

			$row++;

			/* ========= SKIP HEADER ========= */
			if ($row === 1) {
				continue;
			}

			/* ========= COLUMN MAPPING (BY INDEX) ========= */
			$customer_name = trim($data[0] ?? '');
			$mobile_raw    = trim($data[1] ?? '');
			$plate_no      = strtoupper(trim($data[2] ?? ''));
			$brand         = trim($data[3] ?? '');
			$model         = trim($data[4] ?? '');
			$vin_no        = trim($data[5] ?? '');

			/* ========= SKIP TOTAL ROW ========= */
			if (strtoupper($customer_name) === 'TOTAL') {
				continue;
			}

			/* ========= SKIP SERVICE / ITEM ROWS ========= */
			if ($customer_name === '' && $plate_no === '' && $brand === '' && $model === '') {
				continue;
			}

			/* ========= PREPARE ROW FOR MODEL ========= */
			$row_data = [
				'customer_name' => $customer_name,
				'mobile'        => $mobile_raw,
				'plate_no'      => $plate_no,
				'brand'         => $brand,
				'model'         => $model,
				'vin_no'        => $vin_no
			];

			/* ========= CALL MODEL ========= */
			$res = $this->Customer_vehicle_import_model
				->import_customer_vehicle_from_invoice_row($row_data);

			/* ========= COLLECT SUMMARY ========= */
			if ($res['customer_added']) {
				$summary['customers_added']++;
				$summary['logs'][] = "Customer added: {$res['customer_name']}";
			}

			if ($res['customer_used']) {
				$summary['customers_used']++;
			}

			if ($res['vehicle_added']) {
				$summary['vehicles_added']++;
				$summary['logs'][] =
					"Vehicle added: {$res['plate']} ({$res['customer_name']})";
			}

			if ($res['vehicle_skipped']) {
				$summary['vehicles_skipped']++;
				$summary['logs'][] =
					"Vehicle skipped: {$res['plate']} ({$res['reason']})";
			}
		}

		fclose($handle);

		/* ========= OUTPUT ========= */
		echo "<h3>Import Summary</h3>";
		echo "<p>Customers Added: {$summary['customers_added']}</p>";
		echo "<p>Customers Used: {$summary['customers_used']}</p>";
		echo "<p>Vehicles Added: {$summary['vehicles_added']}</p>";
		echo "<p>Vehicles Skipped: {$summary['vehicles_skipped']}</p>";

		echo "<h4>Details</h4><ul>";
		foreach ($summary['logs'] as $log) {
			echo "<li>{$log}</li>";
		}
		echo "</ul>";
	}


	public function map_invoice_customers()
	{
		// Counters
		$total_checked = 0;
		$updated = 0;
		$skipped = 0;

		// Fetch invoices without customer_id
		$invoices = $this->db
			->select('invoice_id, customer_name')
			->from('billing_invoices')
			->where('customer_id IS NULL', null, false)
			->where('customer_name IS NOT NULL', null, false)
			->where('customer_name !=', '')
			->get()
			->result();

		foreach ($invoices as $inv) {

			$total_checked++;

			// Exact name match in customers table
			$customer = $this->db
				->select('customer_id')
				->from('customers')
				->where('name', trim($inv->customer_name))
				->limit(1)
				->get()
				->row();

			if ($customer) {

				// Update invoice with customer_id
				$this->db
					->where('invoice_id', $inv->invoice_id)
					->update('billing_invoices', [
						'customer_id' => $customer->customer_id
					]);

				$updated++;
			} else {
				// No matching customer
				$skipped++;
			}
		}

		// Output summary
		echo "<h3>Invoice → Customer Mapping Completed</h3>";
		echo "<p><b>Total Invoices Checked:</b> {$total_checked}</p>";
		echo "<p><b>Invoices Updated:</b> {$updated}</p>";
		echo "<p><b>Invoices Skipped (No customer match):</b> {$skipped}</p>";
	}

	/* =========================================================
   		DELETE ALL CUSTOMERS & VEHICLES
		========================================================= */
	public function delete_customers_vehicles()
	{
		// ⚠️ Safety: only allow admin (optional)
		// if ($this->session->userdata('role') !== 'Admin') show_404();

		$this->db->trans_start();

		// Order is important (child → parent)
		$this->db->empty_table('vehicles');
		$this->db->empty_table('customers');

		$this->db->trans_complete();

		$this->session->set_flashdata(
			'success',
			'All customers and vehicles deleted successfully.'
		);

		redirect($_SERVER['HTTP_REFERER']);
	}


	/* =========================================================
   		DELETE ALL BILLING INVOICES & ITEMS
		========================================================= */
	public function delete_billing_history()
	{
		// ⚠️ Safety: only allow admin (optional)
		// if ($this->session->userdata('role') !== 'Admin') show_404();

		$this->db->trans_start();

		// Child table first
		$this->db->empty_table('billing_invoice_items');
		$this->db->empty_table('billing_invoices');

		$this->db->trans_complete();

		$this->session->set_flashdata(
			'success',
			'All billing invoices and items deleted successfully.'
		);

		redirect($_SERVER['HTTP_REFERER']);
	}




	  public function map_brand_model_ids()
    {
        log_message('error', 'Entered map_brand_model_ids');

        $updated = $this->Vehicle_master_fix_model
                        ->update_vehicle_brand_model_ids();

        echo "Updated vehicles: " . $updated;
        exit;
    }

		public function test()
{
    echo "Controller is working";
}
}
