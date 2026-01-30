<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_history_import extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Billing_history_import_model');
	}

	public function index()
	{
		$this->load->view('import/billing_history_import');
	}

	public function upload123()
	{
		if (empty($_FILES['csv_file']['name'])) {
			$this->session->set_flashdata('error', 'Please select a CSV file');
			redirect('billing_history_import');
		}

		$handle = fopen($_FILES['csv_file']['tmp_name'], 'r');

		$currentInvoiceId = null;

		$this->db->trans_start();

		while (($row = fgetcsv($handle, 10000, ",")) !== false) {

			// ---- SKIP EMPTY ROWS ----
			if (count(array_filter($row)) === 0) {
				continue;
			}

			// ---- SKIP HEADER ROW ----
			if (strtolower(trim($row[0])) === 'customer') {
				continue;
			}

			$customer  = trim($row[0]);
			$mobile    = trim($row[1]);
			$plate     = trim($row[2]);
			$brand     = trim($row[3]);
			$model     = trim($row[4]);
			$vin       = trim($row[5]);
			$service   = trim($row[6]);
			$billDate  = trim($row[7]);
			$billNo    = trim($row[8]);

			$unit      = (float)$row[9];
			$discount  = (float)$row[10];
			$gross     = (float)$row[11];
			$vat       = (float)$row[12];
			$total     = (float)$row[13];
			$warranty  = trim($row[14] ?? '');

			// ================= CUSTOMER ROW (NEW INVOICE) =================
			if (!empty($customer) && !empty($billNo)) {

				$currentInvoiceId =
					$this->Billing_history_import_model
					->create_or_get_invoice([
						'customer_name'  => $customer,
						'customer_phone' => $mobile,
						'plate_no'       => $plate,
						'brand'          => $brand,
						'model'          => $model,
						'vin_no'         => $vin,
						'billing_no'     => $billNo,
						'billing_date'   => date('Y-m-d', strtotime($billDate)),
						'warranty'       => $warranty
					]);

				continue;
			}

			// ================= TOTAL ROW =================
			if (strtolower($service) === 'total' && $currentInvoiceId) {

				$this->Billing_history_import_model
					->update_invoice_totals($currentInvoiceId, [
						'gross_amount'    => $gross,
						'discount_amount' => $discount,
						'vat_amount'      => $vat,
						'total_amount'    => $total
					]);

				continue;
			}

			// ================= SERVICE ROW =================
			if ($currentInvoiceId && !empty($service)) {

				$this->Billing_history_import_model
					->insert_invoice_item($currentInvoiceId, [
						'description'  => $service,
						'unit_price'   => $unit,
						'discount'     => $discount,
						'gross_amount' => $gross,
						'vat_amount'   => $vat,
						'total_amount' => $total
					]);
			}
		}

		fclose($handle);

		$this->db->trans_complete();

		$this->session->set_flashdata('success', 'Customer billing history imported successfully');
		redirect('billing_history_import');
	}

	public function upload()
	{
		if (empty($_FILES['csv_file']['name'])) {
			$this->session->set_flashdata('error', 'Please select a CSV file');
			redirect('billing_history_import');
		}

		$handle = fopen($_FILES['csv_file']['tmp_name'], 'r');

		// ✅ SKIP HEADER ROW (VERY IMPORTANT)
		fgetcsv($handle);

		$currentInvoiceId = null;

		$this->db->trans_start();

		while (($row = fgetcsv($handle, 10000, ",")) !== false) {

			// ---- SKIP EMPTY ROWS ----
			if (count(array_filter($row)) === 0) {
				continue;
			}

			// Normalize row indexes
			$customer  = trim($row[0] ?? '');
			$mobile    = trim($row[1] ?? '');
			$plate     = trim($row[2] ?? '');
			$brand     = trim($row[3] ?? '');
			$model     = trim($row[4] ?? '');
			$vin       = trim($row[5] ?? '');
			$service   = trim($row[6] ?? '');
			$billDate  = trim($row[7] ?? '');
			$billNo    = trim($row[8] ?? '');

			$unit      = (float)($row[9] ?? 0);
			$discount  = (float)($row[10] ?? 0);
			$gross     = (float)($row[11] ?? 0);
			$vat       = (float)($row[12] ?? 0);
			$total     = (float)($row[13] ?? 0);
			$warranty  = trim($row[14] ?? '');

			// ================= TOTAL ROW =================
			if (strtolower($customer) === 'total' && $currentInvoiceId) {

				$this->Billing_history_import_model
					->update_invoice_totals($currentInvoiceId, [
						'gross_amount'    => $gross,
						'discount_amount' => $discount,
						'vat_amount'      => $vat,
						'total_amount'    => $total
					]);

				continue;
			}

			// ================= CUSTOMER ROW =================
			if (!empty($customer) && !empty($billNo)) {

				$currentInvoiceId =
					$this->Billing_history_import_model
					->create_or_get_invoice([
						'customer_name'  => $customer,
						'customer_phone' => $mobile,
						'plate_no'       => $plate,
						'brand'          => $brand,
						'model'          => $model,
						'vin_no'         => $vin,
						'billing_no'     => $billNo,
						'billing_date'   => !empty($billDate)
							? date('Y-m-d', strtotime($billDate))
							: null,
						'warranty'       => $warranty
					]);

				continue;
			}

			// ================= SERVICE ROW =================
			if ($currentInvoiceId && !empty($service)) {

				$this->Billing_history_import_model
					->insert_invoice_item($currentInvoiceId, [
						'description'  => $service,
						'unit_price'   => $unit,
						'discount'     => $discount,
						'gross_amount' => $gross,
						'vat_amount'   => $vat,
						'total_amount' => $total
					]);
			}
		}

		fclose($handle);

		$this->db->trans_complete();

		$this->session->set_flashdata(
			'success',
			'Customer billing history imported successfully'
		);

		redirect('billing_history_import');
	}
}
