<?php
$this->load->helper('myopeningbalance_helper.php');

$expense_code   = $header->expense_code ?? '';
$expense_date = $header->expense_date ?? '';
$ledger_name  = $header->account_name ?? '';
$supplier     = $header->supplier_name ?? '';
$amount       = $header->amount ?? 0;
$remarks      = $header->remarks ?? '';
$desc         = $header->description ?? '';
$pay_mode     = $header->payment_mode ?? '';
$bank_ledger  = $header->bank_ledger_name ?? '';
?>

<style>
	body {
		font-family: Arial;
		font-size: 14px;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	th,
	td {
		border: 1px solid #ddd;
		padding: 8px;
	}

	th {
		background: #f0f0f0;
	}

	.right {
		text-align: right;
	}

	.center {
		text-align: center;
	}

	.footer {
		margin-top: 70px;
	}
</style>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">

	<img src="<?= base_url('public/images/logocooling.png'); ?>" width="30%" style="height:70px;">

	<div style="text-align:right; font-size:13px; line-height:1.5;">
		<strong>Cool Runnings Garage Co LLC</strong><br>
		Al Quoz 3, Dubai, UAE<br>
		www.coolrunningsgarage.com<br>
		Tel: +971 4 265 4887<br>
		TRN: 104026094300003
	</div>

</div>

<h3 align="center">Expense Voucher</h3>

<table>
	<tr>
		<td><strong>No :</strong> <?= $expense_code ?></td>
		<td class="right"><strong>Date :</strong> <?= date('d-M-Y', strtotime($expense_date)) ?></td>
	</tr>

	<tr>
		<td colspan="2">
			<strong>Expense Ledger :</strong> <?= $ledger_name ?>
			<?php if ($supplier) { ?>
				<br><strong>Supplier :</strong> <?= $supplier ?>
			<?php } ?>
		</td>
	</tr>
</table>


<table style="margin-top:15px;">
	<thead>
		<tr>
			<th class="center">SL</th>
			<th>Particulars</th>
			<th class="right">Amount</th>
		</tr>
	</thead>

	<tbody>

		<tr>
			<td class="center">1</td>
			<td>
				<?= $desc ?>
			</td>
			<td class="right"><?= number_format($amount, 2) ?></td>
		</tr>

		<tr style="font-weight:bold;background:#eaeaea;">
			<td colspan="2" class="right">Total</td>
			<td class="right"><?= number_format($amount, 2) ?></td>
		</tr>

	</tbody>
</table>


<p style="margin-top:20px;">
	<strong>Payment Mode :</strong>
	<?= $pay_mode ?>

	<?php if ($pay_mode == 'BANK') { ?>
		- <?= $bank_ledger ?>
	<?php } ?>
</p>

<p>
	<strong>Amount in words :</strong>
	<?= function_exists('convert_number_to_words') ? convert_number_to_words($amount) : '' ?>
</p>

<p><strong>Remarks :</strong> <?= $remarks ?></p>


<?php if (!empty($documents)) { ?>

	<p><strong>Documents :</strong></p>

	<ul>
		<?php foreach ($documents as $doc) { ?>
			<li><?= $doc->doc_path ?></li>
		<?php } ?>
	</ul>

<?php } ?>


<div class="footer">
	<p>Receiver Signature : ____________________</p>
	<p style="text-align:right;">Authorised Signatory</p>
</div>

<script>
	window.onload = function() {
		window.print();
	}
</script>
