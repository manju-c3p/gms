<?php
// PHP variables from your data (adjust as needed)
$this->load->helper('menu_helper.php');
$this->load->helper('myopeningbalance_helper.php');

// foreach ($logo_details as $row1) {
//     $company_name    = $row1->company_name;
//     $company_add1    = $row1->company_address;
//     $company_city    = $row1->company_city;
//     $company_pin     = $row1->company_pincode;
//     $company_state   = $row1->company_state;
//     $company_website = $row1->company_website;
//     $company_email   = $row1->company_email_id;
// }

$receipt_no       = $header->voucher_code;
$receipt_date     = $header->voucher_date;
$supplier_name    = $header->particulars ?? ''; 
$credit_account   = $header->credit_account_name ?? ''; 
$total_amount     = $header->amount;
$transaction_type = $header->transaction_type ?? '';
$transaction_no   = $header->transaction_no ?? '';
$bank_name        = $header->bank_name ?? '';  
?>

<style>
  body {
    font-family: Arial, sans-serif;
    font-size: 12px;
    color: #000;
    margin: 30px;
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
  .company-info small {
    font-weight: normal;
    display: block;
    margin-top: 2px;
  }
  h3 {
    font-weight: 700;
    margin: 20px 0 10px 0;
    text-align: center;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
    font-size: 12px;
  }
  table th, table td {
    border: 1px solid #000;
    padding: 6px 8px;
  }
  thead th {
    font-weight: bold;
  }
  .no-border td {
    border: none !important;
  }
  .amount-right {
    text-align: right;
  }
  .total-row {
    font-weight: bold;
  }
  .footer-sign {
    margin-top: 60px;
    font-size: 12px;
  }
  .footer-sign div {
    display: inline-block;
    width: 40%;
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

<h3>Payment Voucher</h3>

<table class="no-border">
  <tr>
    <td><strong>No.:</strong> <?= $receipt_no; ?></td>
    <td style="text-align:right;"><strong>Dated:</strong> <?= date('d-M-y', strtotime($receipt_date)); ?></td>
  </tr>
    <tr>
    <td colspan="2"><strong> <?//= htmlspecialchars($supplier_name); ?></strong></td>
  </tr>
</table>

<table>
  <thead>
    <tr>
      <th>Particulars</th>
      <th style="width: 100px; text-align: right;">Amount</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $sl = 0; 
    $total_invoice_amount = 0;
    if (!empty($payment_details)) {
      foreach ($payment_details as $detail) {
        $sl++;
        $total_invoice_amount += $detail->invoice_amount;
        ?>
        <tr>
          <td> <?= htmlspecialchars($detail->party_name ?? $detail->account_name ?? ''); ?>
        <?= !empty($detail->invoice_no) ? ' - ' . htmlspecialchars($detail->invoice_no) : ''; ?></td>
          <td class="amount-right"><?= number_format($detail->invoice_amount, 2); ?></td>
        </tr>
      <?php }
    } ?>
    <tr class="total-row">
      <td>Total</td>
      <td class="amount-right"><?= number_format($total_invoice_amount, 2); ?></td>
    </tr>
  </tbody>
</table>

<div style="margin-top: 20px;">
  <strong>Through: </strong>
  <?= ucwords(htmlspecialchars($transaction_type)); ?>
  <?= !empty($transaction_no) ? ' - ' . htmlspecialchars($transaction_no) : ''; ?>
  <?= !empty($bank_name) ? ' (' . htmlspecialchars($bank_name) . ')' : ''; ?>
  <?= !empty($credit_account) ? ' via ' . htmlspecialchars($credit_account) : ''; ?>
</div>

<div style="margin-top: 20px; font-style: italic;">
  <strong>Amount (in words):</strong> 
  <?= function_exists('convert_number_to_words') ? convert_number_to_words($total_amount) : 'Function missing'; ?>
</div>

<div class="footer-sign">
  <div>Receiver's Signature: ____________________</div>
  <div style="text-align:right;">Authorised Signatory</div>
</div>

<script>
  window.onload = function() {
    window.print();
  };
</script>
