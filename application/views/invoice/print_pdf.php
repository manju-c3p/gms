<!DOCTYPE html>
<html>

<head>
	<title>Invoice View</title>
	<style>
		body {
			font-family: DejaVu Sans, sans-serif;
			font-size: 12px;
			background-color: white;
		}

		/* .header {
			text-align: center;
			margin-bottom: 20px;
		} */





		.title {
			font-size: 22px;
			font-weight: bold;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			border: 1px solid #000;
			padding: 6px;
		}

		th {
			background: #fefafaff;
		}

		.right {
			text-align: right;
		}

		.status {
			position: fixed;
			top: 40%;
			left: 25%;
			font-size: 60px;
			color: rgba(200, 0, 0, 0.15);
			transform: rotate(-30deg);
		}

		.invoice-header {
			border: 1px solid #000;
			border-collapse: collapse;
		}

		.invoice-header td {
			vertical-align: middle;
			/* 🔥 THIS FIXES YOUR ISSUE */
			padding: 10px;
		}

		.logo-cell {
			text-align: center;
		}

		.logo-cell img {
			max-height: 70px;
			width: auto;
		}

		.company-cell {
			font-size: 14px;
			line-height: 1.6;
			text-align: right;
		}
	</style>
</head>

<body>

	<?php if ($invoice->status == 'Paid'): ?>
		<div class="status">PAID</div>
	<?php endif; ?>
	<div class="container">
		<!-- <div class="header">
		<div class="title">TAX INVOICE</div>
		<p>Garage Management System<br>Dubai, UAE<br>TRN: 123456789</p>
	</div> -->
		<!-- HEADER -->
		<table width="100%" class="invoice-header" cellpadding="0" cellspacing="0">
			<tr>
				<td width="20%" class="logo-cell">

					<img src="<?= base_url('public/images/logocooling.png') ?>" alt="Logo">

				</td>

				<td width="80%" class="company-cell">
					<strong>Cool Runnings Garage Co LLC</strong><br>
					7 St, Al Quoz 3, Dubai, UAE<br>
					www.coolrunningsgarage.com<br>
					info@coolrunningsgarage.com<br>
					Tel: +971 4 265 4887<br>
					TRN: 104026094300003
				</td>
			</tr>
		</table>



	<table width="100%" style="border-collapse:collapse; margin-top:10px;">
    <tr>
        <td width="40%" style="border:none;">
            <b>Invoice No:</b> <?= $invoice->invoice_no ?><br>
            <b>QTN No:</b> <?= $invoice->quotation_no ?>
        </td>

        <td width="20%" style="border:none; text-align:center; font-size:16px;">
            <b>TAX INVOICE</b>
        </td>

        <td width="40%" style="border:none; text-align:right;">
            <b>Date:</b> <?= $invoice->invoice_date ?>
        </td>
    </tr>
</table>

<br>

<table width="100%" style="border-collapse:collapse;">
    <tr>

        <!-- CUSTOMER DETAILS -->
        <td width="50%" style="vertical-align:top;">
            <b>Customer Details</b><br>
            <?= $invoice->customer_name ?><br>
            <b>Phone:</b> <?= $invoice->phone ?><br>
            <b>Address:</b> <?= $invoice->address ?><br>
            <b>TRN:</b> <?= $invoice->trn ?><br>
            <b>Emirate:</b> <?= $invoice->emirates ?>
        </td>

        <!-- VEHICLE DETAILS -->
        <td width="50%" style="vertical-align:top;">
            <b>Vehicle Details</b><br>
            <b>Plate No:</b> <?= $invoice->registration_no ?><br>
            <b>Model:</b> <?= $invoice->brand ?> <?= $invoice->model ?><br>
            <b>VIN:</b> <?= $invoice->chassis_no ?>
        </td>

    </tr>
</table>

		<br>

		<!-- <table>
			<thead>
				<tr>
					<th>#</th>
					<th>Description</th>
					<th>Qty</th>
					<th class="right">Unit</th>
					<th class="right">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($parts as $it): ?>
					<tr>
						<td><?= $i++ ?></td>
						<td><?= $it->part_name ?> (<?= $it->part_type ?>)</td>
						<td><?= $it->quantity ?></td>
						<td class="right"><?= number_format($it->unit_price, 2) ?></td>
						<td class="right"><?= number_format($it->total_price, 2) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table> -->

	<!-- ================= SERVICES ================= -->

	<?php if (!empty($services)): ?>

		<?php
		$services_total = 0;
		foreach ($services as $srv) {
			$services_total += $srv->total_price;
		}
		?>

		<table style="margin-top:10px;">

			<tr>
				<th width="5%">#</th>
				<th>Description</th>
				<th width="10%">Qty</th>
				<th width="15%" class="right">Unit Price</th>
				<th width="15%" class="right">Amount</th>
			</tr>

			<tr>
				<td colspan="5"><b>SERVICES</b></td>
			</tr>

			<?php $i = 1;
			foreach ($services as $srv): ?>

				<tr>
					<td><?= $i++ ?></td>
					<td><?= $srv->item_name ?></td>
					<td><?= $srv->quantity ?></td>
					<td class="right"><?= number_format($srv->unit_price, 2) ?></td>
					<td class="right"><?= number_format($srv->total_price, 2) ?></td>
				</tr>

			<?php endforeach; ?>

			<!-- FOOTER -->
			<tr>
				<td colspan="4" class="right"><b>Services Total</b></td>
				<td class="right"><b><?= number_format($services_total, 2) ?></b></td>
			</tr>

		</table>

	<?php endif; ?>
	<!-- ================= PARTS ================= -->

	<?php if (!empty($parts)): ?>

		<?php
		$parts_total = 0;
		foreach ($parts as $p) {
			$parts_total += $p->total_price;
		}
		?>

		<table style="margin-top:10px;">

			<tr>
				<th width="5%">#</th>
				<th>Description</th>
				<th width="10%">Qty</th>
				<th width="15%" class="right">Unit Price</th>
				<th width="10%" class="right">Disc</th>
				<th width="15%" class="right">Amount</th>
			</tr>

			<tr>
				<td colspan="6"><b>SPARE PARTS</b></td>
			</tr>

			<?php $i = 1;
			foreach ($parts as $p): ?>

				<tr>
					<td><?= $i++ ?></td>
					<td><?= $p->part_name ?></td>
					<td><?= $p->quantity ?></td>
					<td class="right"><?= number_format($p->unit_price, 2) ?></td>
					<td class="right"><?= number_format($p->disamount ?? 0, 2) ?></td>
					<td class="right"><?= number_format($p->total_price, 2) ?></td>
				</tr>

			<?php endforeach; ?>

			<!-- FOOTER -->
			<tr>
				<td colspan="5" class="right"><b>Parts Total</b></td>
				<td class="right"><b><?= number_format($parts_total, 2) ?></b></td>
			</tr>

		</table>

	<?php endif; ?>


	<!-- ================= SUBLET ================= -->

	<?php if (!empty($sublets)): ?>

		<?php
		$sublet_total = 0;
		foreach ($sublets as $s) {
			$sublet_total += $s->total_price;
		}
		?>

		<table style="margin-top:10px;">

			<tr>
				<th width="5%">#</th>
				<th>Description</th>
				<th width="10%">Qty</th>
				<th width="15%" class="right">Unit Price</th>
				<th width="15%" class="right">Amount</th>
			</tr>

			<tr>
				<td colspan="5"><b>SUBLET</b></td>
			</tr>

			<?php $i = 1;
			foreach ($sublets as $s): ?>

				<tr>
					<td><?= $i++ ?></td>
					<td><?= $s->item_name ?></td>
					<td><?= $s->quantity ?></td>
					<td class="right"><?= number_format($s->unit_price, 2) ?></td>
					<td class="right"><?= number_format($s->total_price, 2) ?></td>
				</tr>

			<?php endforeach; ?>

			<!-- FOOTER -->
			<tr>
				<td colspan="4" class="right"><b>Sublet Total</b></td>
				<td class="right"><b><?= number_format($sublet_total, 2) ?></b></td>
			</tr>

		</table>

	<?php endif; ?>

		

	<?php if (!empty(trim($invoice->remarks))): ?>
		<br>
		<h3 class="font-semibold mb-2">Remarks</h3>

		<textarea name="remarks" class="remark-input" readonly><?= $invoice->remarks ?> </textarea>

		<style>
			.remark-input {
				width: 100%;
				height: 80px;
				border: 1px solid #000;
				padding: 6px;
				font-family: Arial, sans-serif;
				font-size: 12px;
			}

			/* On print, remove textarea look */
			@media print {
				.remark-input {
					border: none;
					resize: none;
					outline: none;
				}
			}
		</style>
		<?php endif; ?>
		<br>
		<table>
			<tr>
				<td class="right">Subtotal</td>
				<td class="right"><?= number_format($invoice->subtotal, 2) ?></td>
			</tr>
			<tr>
				<td class="right">VAT (5%)</td>
				<td class="right"><?= number_format($invoice->tax_amount, 2) ?></td>
			</tr>
			<tr>
				<td class="right">Discount</td>
				<td class="right"><?= number_format($invoice->discount_amount, 2) ?></td>
			</tr>
			<tr>
				<th class="right">Grand Total</th>
				<th class="right"><?= number_format($invoice->grand_total, 2) ?></th>
			</tr>
			<tr>
				<td class="right">Advance</td>
				<td class="right"><?= number_format($paid, 2) ?></td>
			</tr>
			<tr>
				<th class="right">Balance</th>
				<th class="right"><?= number_format($balance, 2) ?></th>
			</tr>
		</table>

		<br>
		<div style="display:none">
			<b>Payment History</b>
			<table>
				<tr>
					<th>Date</th>
					<th>Mode</th>
					<th class="right">Amount</th>
				</tr>
				<?php foreach ($payments as $p): ?>
					<tr>
						<td><?= $p->payment_date ?></td>
						<td><?= $p->payment_mode ?></td>
						<td class="right"><?= number_format($p->amount, 2) ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

		<table width="100%" style="border-collapse:collapse; margin-top:20px;">
		<tr>

			<!-- BANK DETAILS -->
			<td width="60%" style="border:none; vertical-align:top;">

				<table width="100%" style="border-collapse:collapse;">
					<tr>
						<td style="border:none; padding:2px;">
							<b>Bank:</b> ABU DHABI COMMERCIAL BANK
						</td>
					</tr>

					<tr>
						<td style="border:none; padding:2px;">
							<b>Account Name:</b> COOL RUNNINGS GARAGE CO. LLC
						</td>
					</tr>

					<tr>
						<td style="border:none; padding:2px;">
							<b>Account No:</b> 13339807920001
						</td>
					</tr>

					<tr>
						<td style="border:none; padding:2px;">
							<b>IBAN No:</b> AE920030013339807920001
						</td>
					</tr>
				</table>

			</td>


			<!-- SIGNATURE / STAMP -->
			<td width="40%" style="border:none; text-align:center; vertical-align:top;">

				<div style="height:80px;"></div>

				<div style="border-top:1px solid #000; width:80%; margin:auto; padding-top:5px;">
					<!-- Authorized Signatory / Company Stamp -->
					Cool Runnings Garage
				</div>

			</td>

		</tr>
	</table>
	</div>
</body>

</html>
