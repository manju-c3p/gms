<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Billing_history extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Billing_history_model');
		$this->load->model('Customer_model');
	}

	/* ================= LIST PAGE ================= */



	public function indexold()
	{

		$search = null;
		$customer_id = $this->input->get('customer_id');

		// Dropdown data
		// $data['customers'] = $this->Customer_model->get_all_customers($search);

		// Dropdown customers (can be from customer table OR DISTINCT from invoices)
		$data['customers'] = $this->db
			->select('customer_id, customer_name, customer_phone')
			->from('billing_invoices')
			->where('customer_id IS NOT NULL', null, false)
			->group_by('customer_id')
			->order_by('customer_name', 'ASC')
			->get()
			->result();

		// Billing history query (ONLY billing_invoices table)
		$this->db->select('
        invoice_id,
        billing_no,
        billing_date,
        customer_name,
        customer_phone,
        plate_no,
        total_amount ');
		$this->db->from('billing_invoices');

		if (!empty($customer_id)) {
			$this->db->where('customer_id', $customer_id);
		}

		$this->db->order_by('billing_date', 'DESC');

		$data['invoices'] = $this->db->get()->result();

		$data['title'] = 'Customer Billing History';

		// $this->load->view('billing_history/index', $data);

		$data['main_content'] = 'billing_history/index';

		$this->load->view('includes/template', $data);
	}
	public function index()
	{
		$filters = [
			'customer_name'  => $this->input->get('customer_name'),
			'customer_phone' => $this->input->get('customer_phone'),
			'vin_no'         => $this->input->get('vin_no'),
			'plate_no'       => $this->input->get('plate_no'),
		];
		// log_message('error', print_r($filters, true));


		$data['invoices'] = $this->Billing_history_model->get_billing_history($filters);

		$data['title'] = 'Customer Billing History';

		$data['main_content'] = 'billing_history/index';

		$this->load->view('includes/template', $data);
	}

	public function filter()
	{
		$customer_id = $this->input->post('customer_id');

		redirect('billing_history?customer_id=' . $customer_id);
	}


	/* ================= DETAIL PAGE ================= */
	public function view($invoice_id)
	{
		$invoice = $this->Billing_history_model->get_invoice($invoice_id);

		if (!$invoice) {
			show_404();
		}

		$data['invoice'] = $invoice;
		$data['items']   = $this->Billing_history_model->get_invoice_items($invoice_id);
		$data['title']   = 'Invoice Details';

		$data['main_content'] = 'billing_history/view';
		$this->load->view('includes/template', $data);
	}
	// public function export_excelold()
	// {
	// 	$customer_id = $this->input->get('customer_id');

	// 	$rows = $this->Billing_history_model
	// 		->get_all_invoices_new($customer_id, true);

	// 	header("Content-Type: application/vnd.ms-excel");
	// 	header("Content-Disposition: attachment; filename=customer_billing_history.xls");

	// 	echo "Invoice No\tBilling Date\tCustomer\tMobile\tPlate No\tTotal Amount\n";

	// 	foreach ($rows as $r) {
	// 		echo $r['billing_no'] . "\t";
	// 		echo date('d-m-Y', strtotime($r['billing_date'])) . "\t";
	// 		echo $r['customer_name'] . "\t";
	// 		echo $r['customer_phone'] . "\t";
	// 		echo $r['plate_no'] . "\t";
	// 		echo number_format($r['total_amount'], 2) . "\n";
	// 	}
	// 	exit;
	// }


	// public function export_excel_old()
	// {
	// 	$this->load->model('Billing_history_model');

	// 	$invoices = $this->Billing_history_model->get_all_billing_invoices();

	// 	header("Content-Type: application/vnd.ms-excel");
	// 	header("Content-Disposition: attachment; filename=Billing_Invoices_" . date('d-m-Y') . ".xls");
	// 	header("Pragma: no-cache");
	// 	header("Expires: 0");

	// 	echo "<table border='1'>";
	// 	echo "<tr>
	//         <th>Invoice No</th>
	//         <th>Billing Date</th>
	//         <th>Customer Name</th>
	//         <th>Mobile</th>
	//         <th>Plate No</th>
	//         <th>Brand</th>
	//         <th>Model</th>
	//         <th>VIN No</th>
	//         <th>Gross Amount</th>
	//         <th>Discount</th>
	//         <th>VAT</th>
	//         <th>Total Amount</th>
	//         <th>Warranty</th>
	//       </tr>";

	// 	foreach ($invoices as $inv) {
	// 		echo "<tr>
	//             <td>{$inv->billing_no}</td>
	//             <td>" . date('d-m-Y', strtotime($inv->billing_date)) . "</td>
	//             <td>{$inv->customer_name}</td>
	//             <td>{$inv->customer_phone}</td>
	//             <td>{$inv->plate_no}</td>
	//             <td>{$inv->brand}</td>
	//             <td>{$inv->model}</td>
	//             <td>{$inv->vin_no}</td>
	//             <td>{$inv->gross_amount}</td>
	//             <td>{$inv->discount_amount}</td>
	//             <td>{$inv->vat_amount}</td>
	//             <td>{$inv->total_amount}</td>
	//             <td>{$inv->warranty}</td>
	//           </tr>";
	// 	}

	// 	echo "</table>";
	// 	exit;
	// }

	public function export_invoice_excel($invoice_id)
	{
		$this->load->model('Billing_history_model');

		$invoice = $this->Billing_history_model->get_invoice($invoice_id);
		$items   = $this->Billing_history_model->get_invoice_items($invoice_id);

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Invoice_{$invoice->billing_no}.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "<table border='1' cellpadding='5'>";

		/* ================= HEADER ================= */
		echo "<tr>
            <th colspan='7' style='font-size:16px;'>INVOICE</th>
          </tr>";
		echo "<tr>
            <td colspan='7'><strong>Invoice No:</strong> {$invoice->billing_no}</td>
          </tr>";
		echo "<tr>
            <td colspan='7'><strong>Billing Date:</strong> {$invoice->billing_date}</td>
          </tr>";

		echo "<tr><td colspan='7'></td></tr>";

		/* ================= CUSTOMER & VEHICLE ================= */
		echo "<tr>
            <th colspan='3'>Customer Details</th>
            <th colspan='4'>Vehicle Details</th>
          </tr>";

		echo "<tr>
            <td colspan='3'>
                Name: {$invoice->customer_name}<br>
                Mobile: {$invoice->customer_phone}<br>
                Warranty: {$invoice->warranty}
            </td>
            <td colspan='4'>
                Plate No: {$invoice->plate_no}<br>
                Vehicle: {$invoice->brand} {$invoice->model}<br>
                VIN: {$invoice->vin_no}
            </td>
          </tr>";

		echo "<tr><td colspan='7'></td></tr>";

		/* ================= ITEMS TABLE ================= */
		echo "<tr>
            <th>#</th>
            <th>Description</th>
            <th>Unit Price</th>
            <th>Discount</th>
            <th>Gross</th>
            <th>VAT</th>
            <th>Total</th>
          </tr>";

		$i = 1;
		foreach ($items as $item) {
			echo "<tr>
                <td>{$i}</td>
                <td>{$item->description}</td>
                <td>{$item->unit_price}</td>
                <td>{$item->discount}</td>
                <td>{$item->gross_amount}</td>
                <td>{$item->vat_amount}</td>
                <td>{$item->total_amount}</td>
              </tr>";
			$i++;
		}

		/* ================= TOTALS ================= */
		echo "<tr>
            <td colspan='6'><strong>Gross Amount</strong></td>
            <td>{$invoice->gross_amount}</td>
          </tr>";
		echo "<tr>
            <td colspan='6'><strong>Discount</strong></td>
            <td>{$invoice->discount_amount}</td>
          </tr>";
		echo "<tr>
            <td colspan='6'><strong>VAT</strong></td>
            <td>{$invoice->vat_amount}</td>
          </tr>";
		echo "<tr>
            <td colspan='6'><strong>Grand Total</strong></td>
            <td><strong>{$invoice->total_amount}</strong></td>
          </tr>";

		echo "</table>";
		exit;
	}



	// public function export_excel()
	// {
	// 	$filters = $this->input->get();
	// 	$data = $this->Billing_history_model->get_billing_history_grouped($filters);

	// 	$customerName = $this->input->get('customer_name') ?: 'Customer';
	// 	$customerName = preg_replace('/[^A-Za-z0-9]/', '_', $customerName);

	// 	$filename = "Billing_History_{$customerName}.xls";


	// 	header("Content-Type: application/vnd.ms-excel");
	// 	header("Content-Disposition: attachment; filename={$filename}");


	// 	echo "<table border='1' cellpadding='5'>";

	// 	foreach ($data as $row) {

	// 		$inv = $row['invoice'];

	// 		/* ================= HEADER ================= */
	// 		echo "
	// 	<tr style='background:#e5e5e5;font-weight:bold'>
	// 		<td>Customer Name</td>
	// 		<td>Cust Mobile</td>
	// 		<td>Plate No</td>
	// 		<td>Brand</td>
	// 		<td>Model</td>
	// 		<td colspan='3'>Vin No</td>
	// 		<td>Billing Date</td>
	// 		<td>Billing No</td>
	// 	</tr>
	// 	<tr>
	// 		<td>{$inv->customer_name}</td>
	// 		<td>{$inv->customer_phone}</td>
	// 		<td>{$inv->plate_no}</td>
	// 		<td>{$inv->brand}</td>
	// 		<td>{$inv->model}</td>
	// 		<td colspan='3'>{$inv->vin_no}</td>
	// 		<td>{$inv->billing_date}</td>
	// 			<td>{$inv->billing_no}</td>
	// 	</tr>";

	// 		/* ================= ITEM TABLE HEADER ================= */
	// 		echo "
	// 	<tr style='background:#f3f3f3;font-weight:bold'>
	// 		<td colspan='5'>Service</td>

	// 		<td>Unit Price</td>
	// 		<td>Discount</td>
	// 		<td>Gross Amt</td>
	// 		<td>VAT Amt</td>
	// 		<td>Total Amt</td>
	// 	</tr>";

	// 		/* ================= ITEMS ================= */
	// 		foreach ($row['items'] as $item) {
	// 			echo "
	// 		<tr>
	// 			<td colspan='5'>{$item->description}</td>

	// 			<td>{$item->unit_price}</td>
	// 			<td>{$item->discount}</td>
	// 			<td>{$item->gross_amount}</td>
	// 			<td>{$item->vat_amount}</td>
	// 			<td>{$item->item_total}</td>
	// 		</tr>";
	// 		}

	// 		/* ================= TOTAL ROW ================= */
	// 		echo "
	// 	<tr style='font-weight:bold;background:#ddd'>
	// 		<td colspan='5' align='right'>TOTAL</td>
	// 		<td>{$inv->gross_amount}</td>
	// 		<td>{$inv->discount_amount}</td>
	// 		<td>{$inv->gross_amount}</td>
	// 		<td>{$inv->vat_amount}</td>
	// 		<td>{$inv->total_amount}</td>
	// 	</tr>";

	// 		/* ================= SPACE ================= */
	// 		echo "<tr><td colspan='9'>&nbsp;</td></tr>";
	// 	}

	// 	echo "</table>";
	// }

	public function export_excel()
	{
		$filters = $this->input->get();
		$data = $this->Billing_history_model->get_billing_history_grouped($filters);

		$customerName = $this->input->get('customer_name') ?: 'Customer';
		$customerName = preg_replace('/[^A-Za-z0-9]/', '_', $customerName);

		$filename = "Billing_History_{$customerName}.xls";

		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$filename}");

		echo "<table border='1' cellpadding='5'>";

		foreach ($data as $row) {

			$inv = $row['invoice'];

			/* ================= HEADER ================= */
			echo "
        <tr style='background:#e5e5e5;font-weight:bold'>
            <td>Customer Name</td>
            <td>Cust Mobile</td>
            <td>Plate No</td>
            <td>Brand</td>
            <td>Model</td>
            <td colspan='3'>Vin No</td>
            <td>Billing Date</td>
            <td>Billing No</td>
        </tr>
        <tr>
            <td>{$inv->customer_name}</td>
            <td>{$inv->customer_phone}</td>
            <td>{$inv->plate_no}</td>
            <td>{$inv->brand}</td>
            <td>{$inv->model}</td>
            <td colspan='3'>{$inv->vin_no}</td>
            <td>{$inv->billing_date}</td>
            <td>{$inv->billing_no}</td>
        </tr>";

			/* ================= ITEM TABLE HEADER ================= */
			echo "
        <tr style='background:#f3f3f3;font-weight:bold'>
            <td colspan='5'>Service</td>
            <td>Unit Price</td>
            <td>Discount</td>
            <td>Gross Amt</td>
            <td>VAT Amt</td>
            <td>Total Amt</td>
        </tr>";

			/* ================= ITEMS + TOTAL CALC ================= */
			$totalGross    = 0;
			$totalDiscount = 0;
			$totalVat      = 0;
			$totalAmount   = 0;

			foreach ($row['items'] as $item) {

				$gross    = (float) $item->gross_amount;
				$discount = (float) $item->discount;
				$vat      = (float) $item->vat_amount;
				$total    = (float) $item->item_total;

				$totalGross    += $gross;
				$totalDiscount += $discount;
				$totalVat      += $vat;
				$totalAmount   += $total;

				echo "
            <tr>
                <td colspan='5'>{$item->description}</td>
                <td>{$item->unit_price}</td>
                <td>{$discount}</td>
                <td>{$gross}</td>
                <td>{$vat}</td>
                <td>{$total}</td>
            </tr>";
			}

			/* ================= TOTAL ROW ================= */
			echo "
        <tr style='font-weight:bold;background:#ddd'>
            <td colspan='5' align='right'>TOTAL</td>
            <td></td>
            <td>{$totalDiscount}</td>
            <td>{$totalGross}</td>
            <td>{$totalVat}</td>
            <td>{$totalAmount}</td>
        </tr>";

			/* ================= SPACE ================= */
			echo "<tr><td colspan='10'>&nbsp;</td></tr>";
		}

		echo "</table>";
	}
}
