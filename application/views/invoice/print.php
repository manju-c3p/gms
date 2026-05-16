<!DOCTYPE html>
<html>

<head>
	<title>Tax Invoice</title>

	<style>
		body {
			font-family: DejaVu Sans, sans-serif;
			font-size: 12px;
			color: #000;
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

		.right {
			text-align: right;
		}

		.center {
			text-align: center;
		}

		.no-border td {
			border: none;
		}

		.header-line-thick {
			border-top: 4px solid #000;
		}

		.header-line-thin {
			border-top: 2px solid #000;
		}

		.caption {
			font-size: 18px;
			font-weight: bold;
		}

		.status {
			position: fixed;
			top: 40%;
			left: 25%;
			font-size: 60px;
			color: rgba(200, 0, 0, 0.15);
			transform: rotate(-30deg);
		}

		.remark-box {
			/* border: 1px solid #000; */
			/* height: 80px; */
			padding: 5px;
		}

		@media print {
			.no-print {
				display: none !important;
			}
		}
	</style>

</head>

<body onload="window.print()">

	<?php if ($invoice->status == 'Paid'): ?>
		<div class="status">PAID</div>
	<?php endif; ?>

	<div class="no-print">
		<button onclick="window.print()"
			class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded">
			🖨 Print
		</button>
		<a href="<?= base_url('index.php/Invoice'); ?>"
			class="w-full sm:w-auto  ml-3 px-6 py-2 bg-gray-300 rounded print:hidden">Cancel</a>


	</div>


	<!-- COMPANY HEADER -->
	<table class="no-border">
		<tr>

			<td width="20%">
				<img src="<?= base_url('public/images/logocooling.png') ?>" height="70">
			</td>

			<td width="80%" class="right">
				<b>Cool Runnings Garage Co LLC</b><br>
				7 St, Al Quoz 3, Dubai, UAE<br>
				www.coolrunningsgarage.com<br>
				info@coolrunningsgarage.com<br>
				Tel: +971 4 265 4887<br>
				TRN: 104026094300003
			</td>

		</tr>
	</table>


	<!-- HEADER DOUBLE LINE -->
	<!-- <div class="header-line-thick"></div> -->
	<div class="header-line-thin"></div>


	<table class="no-border">

		<tr>

			<td width="33%">
				<b>INV # : <?= $invoice->invoice_no ?></b><br>

				<?php if (!empty($invoice->quotation_no)): ?>
					<b>QTN # : <?= $invoice->quotation_no ?></b>
				<?php endif; ?>

			</td>

			<td width="34%" class="center caption">
				TAX INVOICE
			</td>

			<td width="33%" class="right">
				<b>Date : <?= date('d/m/Y', strtotime($invoice->invoice_date)) ?></b>
			</td>

		</tr>

	</table>


	<div class="header-line-thin"></div>
	<!-- <div class="header-line-thick"></div> -->


	<!-- CUSTOMER / VEHICLE -->
	<table>

		<tr>

			<td width="50%">

				<b>Customer Details</b><br>

				<?= $invoice->customer_name ?><br>
				Phone : <?= $invoice->phone ?><br>
				Address : <?= $invoice->address ?><br>
				TRN : <?= $invoice->trn ?><br>
				Emirate : <?= $invoice->emirates ?>

			</td>

			<td width="50%">

				<b>Vehicle Details</b><br>

				Plate No : <?= $invoice->registration_no ?><br>
				Model : <?= $invoice->brand ?> <?= $invoice->model ?><br>
				VIN : <?= $invoice->chassis_no ?> <br>
				Mileage : <?= $invoice->km_in ?> <br>
				Year : <?= $invoice->year ?> <br>
				KM's : <?= $invoice->km_in ?>
			</td>

		</tr>

	</table>


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
					<!-- <td><?= $srv->quantity ?></td> -->
					 <td>
	<?= (floor($srv->quantity) == $srv->quantity) 
		? number_format($srv->quantity, 0) 
		: rtrim(rtrim(number_format($srv->quantity, 2), '0'), '.') ?>
</td>
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


			foreach ($parts as $p):
				$patype = "";
				if ($p->labeling == "1") {
					if ($p->part_type == "New Parts") {
						$patype = "Original";
					} else if ($p->part_type == "Aftermarket Parts") {
						$patype = "Aftermarket";
					} else if ($p->part_type == "Used Parts") {
						$patype = "Used";
					}
				}

			?>

				<tr>
					<td><?= $i++ ?></td>
					<td>
						<?= $p->part_name ?>
						
						<?= !empty($patype) ? "($patype)" : "" ?><br>
						<?= !empty($p->partremarks) ? $p->partremarks : "" ?>
					</td>
					<td>
	<?= (floor($p->quantity) == $p->quantity) 
		? number_format($p->quantity, 0) 
		: rtrim(rtrim(number_format($p->quantity, 2), '0'), '.') ?>
</td>
					<td class="right"><?= number_format($p->invoiceprice, 2) ?></td>
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
					<!-- <td><?= $s->quantity ?></td> -->

					<td>
	<?= (floor($s->quantity) == $s->quantity) 
		? number_format($s->quantity, 0) 
		: rtrim(rtrim(number_format($s->quantity, 2), '0'), '.') ?>
</td>
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


	<!-- TOTAL -->
	<!-- <table style="margin-top:10px; width:40%; margin-left:auto;">

		<tr>
			<td class="right">Subtotal</td>
			<td class="right"><?= number_format($invoice->subtotal, 2) ?></td>
		</tr>

		<tr>
			<td class="right">VAT 5%</td>
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
			<td class="right">Paid</td>
			<td class="right"><?= number_format($paid, 2) ?></td>
		</tr>

		<tr>
			<th class="right">Balance</th>
			<th class="right"><?= number_format($balance, 2) ?></th>
		</tr>

	</table> -->
	<table width="100%" style="margin-top:15px;">
		<tr>

			<!-- LEFT SIDE : BANK DETAILS -->
			<td width="60%" valign="top" style="border:none;">



				<table width="100%" style="border-collapse:collapse;">
					<tr>
						<td style="border:none; padding:2px;">
							<b>Amount in Words: </b> <?= $amount_in_words = number_to_words_aed($balance); ?>
						</td>
					</tr>





				</table>

			</td>


			<!-- RIGHT SIDE : TOTALS -->
			<td width="40%" valign="top">

				<table width="100%" style="border-collapse:collapse;">

					<tr>
						<td class="right">Subtotal</td>
						<td class="right"><?= number_format($invoice->subtotal, 2) ?></td>
					</tr>

					<tr>
						<td class="right">VAT 5%</td>
						<td class="right"><?= number_format($invoice->tax_amount, 2) ?></td>
					</tr>

					<tr>
						<td class="right">Discount</td>
					<td class="right"><?= number_format($invoice->discount_amount ?? 0, 2) ?></td>
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

			</td>

		</tr>
	</table>


	<!-- REMARKS -->
	<?php if (!empty(trim($invoice->remarks))): ?>

		<h4>Remarks</h4>

		<div class="remark-box">
			<?= $invoice->remarks ?>


		</div>

	<?php endif; ?>


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

</body>

</html>
