<?php
$this->load->helper('myopeningbalance_helper.php'); // for convert_number_to_words()

// Company info from logo_details
// $company = $logo_details[0] ?? null;
// $company_name    = $company->company_name ?? '';
// $company_add1    = $company->company_address ?? '';
// $company_city    = $company->company_city ?? '';
// $company_pin     = $company->company_pincode ?? '';
// $company_state   = $company->company_state ?? '';
// $company_website = $company->company_website ?? '';
// $company_email   = $company->company_email_id ?? '';

// Receipt header info
$receipt_no       = $header->voucher_code ?? '';
$receipt_date     = $header->voucher_date ?? '';
$voucher_type     = $header->voucher_type ?? '';
$cust_code        = $header->customer_id ?? '';
$customer_name    = $header->customer_name ?? '';
$total_amount     = $header->amount ?? 0;
$transaction_type = $header->transaction_type ?? '';
$transaction_no   = $header->transaction_no ?? '';
$bank_name        = $header->bank_name ?? '';
$credit_account   = $header->credit_account_name ?? '';
$remark           = $header->narration ?? '';
?>

<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 14px;
  }
  .header-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }
  .logo {
    width: 120px;
  }
  .logo img {
    width: 100%;
    height: auto;
  }
  .company-info {
    flex-grow: 1;
    text-align: center;
    font-size: 12px;
    line-height: 1.2;
    font-weight: 600;
  }
  .logo-container {
    text-align: center;
    margin-bottom: 10px;
  }
  .logo-container img {
    max-width: 150px;
    height: auto;
    display: inline-block;
  }
  table {
    border-collapse: collapse;
    width: 100%;
  }
  table, th, td {
    border: 1px solid #ddd;
  }
  th {
    background-color: #f0f0f0;
    text-align: center;
    padding: 8px;
  }
  td {
    padding: 8px;
  }
  .right-align {
    text-align: right;
  }
  .center-align {
    text-align: center;
  }
  .title {
    text-align: center;
    font-weight: bold;
    font-size: 18px;
    margin-top: 10px;
  }
  .footer {
    margin-top: 60px;
  }
  .center-align {
    text-align: center;
  }
  .right-align {
    text-align: right;
  }
</style>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">

			<!-- Logo -->
			<img src="<?= base_url('public/images/logocooling.png'); ?>" width="30%" style="height:70px;">

			<!-- Company Details -->
			<div style="text-align:right; font-size:13px; line-height:1.5;">
				<strong>Cool Runnings Garage Co LLC</strong><br>
				Al Quoz 3, Dubai, UAE<br>
				www.coolrunningsgarage.com<br>
				Tel: +971 4 265 4887<br>
				TRN: 104026094300003
			</div>

		</div>
<h3 align="center"> <?php 
      if ($voucher_type == 'R') echo "Receipt Voucher";
      elseif ($voucher_type == 'D') echo "Debit Note";
      elseif ($voucher_type == 'C') echo "Credit Note";
      else echo "Receipt Voucher";
      ?></h3>


<table style="margin-top: 10px;">
  <tr>
    <td><strong>No.:</strong> <?= htmlspecialchars($receipt_no); ?></td>
    <td class="right-align"><strong>Dated:</strong> <?= date('d-M-Y', strtotime($receipt_date)); ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>[<?= htmlspecialchars($cust_code); ?>] <?= htmlspecialchars($customer_name); ?></strong></td>
  </tr>
</table>

<?php
//echo "<pre>";print_r($header); 
$invoice_codes = isset($header->invoice_codes) ? explode(',', $header->invoice_codes) : [];
$invoice_amounts = isset($header->invoice_amounts) ? explode(',', $header->invoice_amounts) : [];

// Calculate total
$total_amount = 0;
foreach ($invoice_amounts as $amt) {
    $total_amount += floatval(trim($amt));
}
?>

<?php if (!empty($invoice_codes) && count($invoice_codes) > 0) { ?>
  <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
    <thead>
      <tr style="background-color: #f0f0f0; border: 1px solid #ddd;">
        <th style="border: 1px solid #ddd; padding: 8px; text-align: center;">SL.No</th>
        <th style="border: 1px solid #ddd; padding: 8px;">Particulars</th>
        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">Amount (AED)</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($invoice_codes as $i => $inv_code): ?>
        <tr>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: center;"><?= $i + 1 ?></td>
          <td style="border: 1px solid #ddd; padding: 8px;"><?= htmlspecialchars(trim($inv_code)) ?></td>
          <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
            <?= number_format(floatval(trim($invoice_amounts[$i] ?? 0)), 2) ?>
          </td>
        </tr>
      <?php endforeach; ?>

      <!-- Total Row -->
      <tr style="font-weight: bold; background-color: #eaeaea;">
        <td colspan="2" style="border: 1px solid #ddd; padding: 8px; text-align: right;">Total</td>
        <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">
          <?= number_format($total_amount, 2) ?>
        </td>
      </tr>
    </tbody>
  </table>
<?php } else { ?>
  <p>No linked invoices found.</p>
<?php } ?>  


<p style="margin-top: 20px;">
  <strong>Through:</strong>
  <?= ucwords(htmlspecialchars($transaction_type)); ?>
  <?= !empty($transaction_no) ? ' - ' . htmlspecialchars($transaction_no) : ''; ?>
  <?= !empty($bank_name) ? ' (' . htmlspecialchars($bank_name) . ')' : ''; ?>
  <?= !empty($credit_account) ? ' via ' . htmlspecialchars($credit_account) : ''; ?>
</p>

<p>
  <strong>Amount in words:</strong>
  <?= function_exists('convert_number_to_words') ? convert_number_to_words($total_amount) : 'Function missing'; ?>
</p>

<div class="footer">
  <p>Receiver's Signature: ____________________</p>
  <p class="right-align">Authorised Signatory</p>
</div>

<script>
  window.onload = function() {
    window.print();
  };
</script>
