<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Invoice_model');
		$this->load->model('Jobcard_model');
		$this->load->model('Accounts_model');
	}
	public function generate()
	{
		$data['title'] = 'Invoice List';

		// Get all invoices with customer & vehicle details
		$data['invoices'] = $this->Invoice_model->get_all_invoices();
		$data['jobcards'] = $this->Jobcard_model->get_all_jobcards_completed();



		$data['sundry_accounts1'] = $this->Accounts_model->get_gen_ledger_detors_records();
		$data['sundry_accounts2'] = $this->Accounts_model->get_general_ledger_by_group('Sales Accounts');
		$data['sundry_accounts3'] = $this->Accounts_model->get_all_general_ledger_accounts();

		// log_message('error', 'Sundry Accounts 1 (Debtors): ' . print_r($data['sundry_accounts1'], true));
		// log_message('error', 'Sundry Accounts 2 (Sales Accounts): ' . print_r($data['sundry_accounts2'], true));
		// log_message('error', 'Sundry Accounts 3 (All GL Accounts): ' . print_r($data['sundry_accounts3'], true));


		

		$data['main_content'] = 'invoice/generate';
		$this->load->view('includes/template', $data);
	}

	public function index()
	{
		$data['title'] = 'Invoice List';

		$data['invoices'] = $this->Invoice_model->get_all_invoices_with_payment();

		$data['main_content'] = 'invoice/index';
		$this->load->view('includes/template', $data);
	}


	public function save()
	{

		$jobcard_id = $this->input->post('jobcard_id');

		$jobcard = $this->db
			->select('quotation_id')
			->from('job_cards')
			->where('jobcard_id', $jobcard_id)
			->get()
			->row();

		if (!$jobcard || !$jobcard->quotation_id) {
			show_error('Quotation not linked with Jobcard');
		}

		$quotation_id = $jobcard->quotation_id;



		$invoice_type = $this->input->post('invoice_type'); // Proforma / Tax
		// log_message('error', $invoice_type);
		// if ($invoice_type === 'Proforma') {
		// 	if ($this->Invoice_model->has_proforma($quotation_id)) {

		// 		$this->session->set_flashdata(
		// 			'error',
		// 			'Proforma invoice already exists for this quotation'
		// 		);

		// 		redirect('invoice/generate'); // go back to same page
		// 		return;
		// 	}
		// }

		$invoice_no = $this->generate_invoice_no($invoice_type);
		
		$invoice_id = $this->Invoice_model->create_invoice([
			'jobcard_id'      => $this->input->post('jobcard_id'),
			'quotation_id'    => $quotation_id,
			'invoice_type'    => $this->input->post('invoice_type'),
			'invoice_date'    => date('Y-m-d'),
			'subtotal'        => $this->input->post('subtotal'),
			'tax_amount'      => $this->input->post('tax_amount'),
			'discount_amount' => $this->input->post('discount_amount'),
			'grand_total'     => $this->input->post('grand_total'),
			'status'          => 'Unpaid',
			'remarks'         => $this->input->post('remarks'),
			 'invoice_no'      => $invoice_no,    
			'customer_id'     => $this->input->post('customer_id'), // used only in model
		]);

		// 2. Save invoice items from jobcard
		// $this->Invoice_model->insert_invoice_items($invoice_id, $this->input->post('jobcard_id'));
			$this->Invoice_model->insert_invoice_items_from_post($invoice_id);

		// 3. Redirect to view page
		redirect('invoice/view/' . $invoice_id);
	}


	public function download($invoice_id)
	{
		$this->load->library('pdf');
		$data['invoice'] = $this->Invoice_model->get_full_invoice($invoice_id);

		$html = $this->load->view('invoice/pdf', $data, true);

		$this->pdf->createPDF($html, 'invoice_' . $invoice_id, false);
	}

	public function get_jobcard_details($jobcard_id)
	{
		// $jobcard = $this->Jobcard_model->get_jobcard_with_details($jobcard_id);
		$jobcard = $this->Jobcard_model->get_jobcard_full_details_quotation($jobcard_id);
		echo json_encode($jobcard);
	}


	public function save_payment()
	{
		$invoice_id = $this->input->post('invoice_id');
		$amount     = (float) $this->input->post('amount');

		// Basic validation
		if (!$invoice_id || $amount <= 0) {
			show_error('Invalid payment data');
		}

		// 1. Save payment
		$paymentData = [
			'invoice_id'   => $invoice_id,
			'payment_date' => date('Y-m-d'),
			'payment_mode' => $this->input->post('payment_mode'),
			'amount'       => $amount,
			'reference_no' => $this->input->post('reference_no'),
			'notes'        => $this->input->post('notes')
		];

		$this->Invoice_model->insert_payment($paymentData);

		// 2. Update invoice status
		$this->Invoice_model->update_invoice_payment_status($invoice_id);

		// 3. Redirect back to invoice list
		redirect('invoice');
	}

	public function view($invoice_id)
	{
		$data['title'] = 'Invoice View';

		$data['invoice']  = $this->Invoice_model->get_invoice($invoice_id);
		$data['items']    = $this->Invoice_model->get_invoice_items($invoice_id);
		$data['payments'] = $this->Invoice_model->get_invoice_payments($invoice_id);

		// Calculate paid & balance
		$paid = 0;
		foreach ($data['payments'] as $p) {
			$paid += $p->amount;
		}

		$data['paid_amount']    = $paid;
		$data['balance_amount'] = $data['invoice']->grand_total - $paid;


		$data['main_content'] = 'invoice/view';
		$this->load->view('includes/template', $data);
	}
	public function print_invoice($invoice_id)
	{
		$data['title'] = 'Invoice View';
		$data = $this->Invoice_model->get_invoice_full($invoice_id);

		// $data['main_content'] = 'invoice/print';
		$this->load->view('invoice/print', $data);
	}


	public function download_invoice($invoice_id)
	{
		$this->load->library('pdf');

		$data = $this->Invoice_model->get_invoice_full($invoice_id);

		$html = $this->load->view('invoice/print_pdf', $data, true);

		$this->pdf->createPDF(
			$html,
			'Invoice_' . $data['invoice']->invoice_no,
			true
		);
	}


	// use PhpOffice\PhpSpreadsheet\Spreadsheet;
	// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	// use PhpOffice\PhpSpreadsheet\Style\Alignment;
	// use PhpOffice\PhpSpreadsheet\Style\Border;

	public function export_excel($invoice_id)
	{
		$this->load->model('Invoice_model');

		$data = $this->Invoice_model->get_invoice_full($invoice_id);

		$invoice  = $data['invoice'];
		$items    = $data['items'];
		$payments = $data['payments'];

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Invoice');

		/* ------------------------------
			GLOBAL STYLES
					------------------------------ */
		foreach (range('A', 'F') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		$bold = ['font' => ['bold' => true]];
		$center = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]];
		$border = [
			'borders' => [
				'allBorders' => ['borderStyle' => Border::BORDER_THIN]
			]
		];

		/* ------------------------------
			TITLE
				------------------------------ */
		$sheet->mergeCells('A1:F1');
		$sheet->setCellValue('A1', 'TAX INVOICE');
		$sheet->getStyle('A1')->applyFromArray([
			'font' => ['bold' => true, 'size' => 16],
			'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
		]);

		/* ------------------------------
			INVOICE INFO
			------------------------------ */
		$sheet->setCellValue('A3', 'Invoice No');
		$sheet->setCellValue('B3', $invoice->invoice_no);
		$sheet->setCellValue('D3', 'Invoice Date');
		$sheet->setCellValue('E3', $invoice->invoice_date);

		$sheet->setCellValue('A4', 'Status');
		$sheet->setCellValue('B4', $invoice->status);

		$sheet->getStyle('A3:A4')->applyFromArray($bold);
		$sheet->getStyle('D3')->applyFromArray($bold);

		/* ------------------------------
			CUSTOMER & VEHICLE
			------------------------------ */
		$sheet->setCellValue('A6', 'Customer Name');
		$sheet->setCellValue('B6', $invoice->customer_name);
		$sheet->setCellValue('A7', 'Phone');
		$sheet->setCellValueExplicit('B7', $invoice->phone, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

		$sheet->setCellValue('D6', 'Vehicle No');
		$sheet->setCellValue('E6', $invoice->registration_no);
		$sheet->setCellValue('D7', 'Vehicle');
		$sheet->setCellValue('E7', $invoice->brand . ' ' . $invoice->model);

		$sheet->getStyle('A6:A7')->applyFromArray($bold);
		$sheet->getStyle('D6:D7')->applyFromArray($bold);

		/* ------------------------------
				ITEMS HEADER
				------------------------------ */
		$row = 9;
		$sheet->setCellValue("A{$row}", 'Item Type');
		$sheet->setCellValue("B{$row}", 'Description');
		$sheet->setCellValue("C{$row}", 'Qty');
		$sheet->setCellValue("D{$row}", 'Unit Price');
		$sheet->setCellValue("E{$row}", 'Total');

		$sheet->getStyle("A{$row}:E{$row}")->applyFromArray($bold);
		$sheet->getStyle("A{$row}:E{$row}")->applyFromArray($border);
		$sheet->getStyle("C{$row}:E{$row}")->applyFromArray($center);

		/* ------------------------------
			ITEMS DATA
			------------------------------ */
		$row++;
		foreach ($items as $it) {
			$sheet->setCellValue("A{$row}", $it->item_type);
			$sheet->setCellValue("B{$row}", $it->item_name);
			$sheet->setCellValue("C{$row}", $it->quantity);
			$sheet->setCellValue("D{$row}", $it->unit_price);
			$sheet->setCellValue("E{$row}", $it->total_price);

			$sheet->getStyle("A{$row}:E{$row}")->applyFromArray($border);
			$sheet->getStyle("C{$row}:E{$row}")->applyFromArray($center);
			$row++;
		}

		/* ------------------------------
			SUMMARY
			------------------------------ */
		$row += 1;

		$summary = [
			'Subtotal'       => $invoice->subtotal,
			'VAT (5%)'       => $invoice->tax_amount,
			'Discount'       => $invoice->discount_amount,
			'Grand Total'    => $invoice->grand_total,
			'Paid Amount'    => $data['paid'],
			'Balance Amount' => $data['balance']
		];

		foreach ($summary as $label => $value) {
			$sheet->setCellValue("D{$row}", $label);
			$sheet->setCellValue("E{$row}", $value);
			$sheet->getStyle("D{$row}:E{$row}")->applyFromArray($border);
			$sheet->getStyle("D{$row}")->applyFromArray($bold);
			$row++;
		}

		/* ------------------------------
			DOWNLOAD
			------------------------------ */
		$filename = 'Invoice_' . $invoice->invoice_no . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}


	public function generate_invoice_no($invoice_type)
	{
		$year = date('Y');
		// log_message('error', $invoice_type);
		// Prefix based on invoice type
		$prefix = ($invoice_type === 'PI') ? 'PI' : 'TI';

		$last = $this->db
			->like('invoice_no', "$prefix-$year-", 'after')
			->order_by('invoice_id', 'DESC')
			->limit(1)
			->get('invoices')
			->row();

		if ($last) {
			$last_no = intval(substr($last->invoice_no, -4));
			$new_no  = str_pad($last_no + 1, 4, '0', STR_PAD_LEFT);
		} else {
			$new_no = '0001';
		}

		return "$prefix-$year-$new_no";
	}
}
