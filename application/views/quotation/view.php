<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Estimation Print</title>
	<style>
		@page {
			size: A4;
			margin: 10mm;
		}

		html,
		body {
			background: #ffffff !important;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #000;
		}

		.container {
			width: 100%;
		}

		.header {
			display: flex;
			justify-content: space-between;
			border-bottom: 2px solid #000;
			padding-bottom: 8px;
			margin-bottom: 10px;
		}

		.logo {
			font-weight: bold;
			font-size: 16px;
		}

		.company-info {
			text-align: right;
			font-size: 11px;
		}

		.title {
			text-align: center;
			font-size: 18px;
			font-weight: bold;
			margin: 8px 0;
		}

		.info-table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 10px;
		}

		.info-table td {
			padding: 4px;
			vertical-align: top;
		}

		.section-title {
			font-weight: bold;
			border-bottom: 1px solid #000;
			margin-top: 10px;
			margin-bottom: 5px;
		}

		table.data {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 8px;
		}

		table.data th,
		table.data td {
			border: 1px solid #000;
			padding: 4px;
			font-size: 11px;
		}

		table.data th {
			background: #f0f0f0;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.totals {
			width: 40%;
			float: right;
			border-collapse: collapse;
		}

		.totals td {
			border: 1px solid #000;
			padding: 5px;
			font-size: 12px;
		}

		.remarks {
			margin-top: 10px;
			font-size: 11px;
		}

		.footer {
			margin-top: 20px;
			font-size: 10px;
		}
	</style>
</head>

<body onload="window.print()">

	<div class="container">

		<!-- HEADER -->
		<div class="header">
			<div class="logo">
				<div class="brand flex items-center gap-3 px-4 py-3">
					<img src="<?= base_url('public/images/logoauto1.png') ?>"
						alt="GMS Logo"
						class="h-10 w-auto">


				</div>
			</div>
			<div class="company-info">
				Cool Runnings Garage Co LLC<br>
				7 St, Al Quoz 3, Dubai, UAE<br>
				www.coolrunningsgarage.com<br>
				info@coolrunningsgarage.com<br>
				Tel: +971 4 265 4887<br>
				TRN: 104026094300003
			</div>
		</div>

		<div class="est-title-line">
			<span>QTN # : <?= $quotation->quotation_no ?></span>
			<span class="est-title">Quotation</span>
			<span>Date : <?= date('d/m/Y', strtotime($quotation->quotation_date)) ?></span>
		</div>


		<!-- CUSTOMER & VEHICLE INFO -->
		<table class="est-info">
			<tr>
				<!-- LEFT SIDE : CUSTOMER -->
				<td width="50%" class="info-left">
					<table>
						<tr>
							<td>Name</td>
							<td>:</td>
							<td><?= $appointment->name ?></td>
						</tr>
						<tr>
							<td>Contact</td>
							<td>:</td>
							<td><?= $appointment->phone ?></td>
						</tr>
						<tr>
							<td>Address</td>
							<td>:</td>
							<td><?= $appointment->address ?></td>
						</tr>
						<tr>
							<td>TRN No</td>
							<td>:</td>
							<td><?= $appointment->trn_no ?? '' ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><?= $appointment->email ?? '' ?></td>
						</tr>
					</table>
				</td>

				<!-- RIGHT SIDE : VEHICLE -->
				<td width="50%" class="info-right">
					<table>
						<tr>
							<td>Brand</td>
							<td>:</td>
							<td><?= $appointment->brand ?></td>
						</tr>
						<tr>
							<td>Model</td>
							<td>:</td>
							<td><?= $appointment->model ?></td>
						</tr>
						<tr>
							<td>Vin No</td>
							<td>:</td>
							<td><?= $appointment->chassis_no ?></td>
						</tr>
						<tr>
							<td>Plate No</td>
							<td>:</td>
							<td><?= $appointment->registration_no ?></td>
						</tr>
						<tr>
							<td>Colour</td>
							<td>:</td>
							<td><?= $appointment->color ?? '' ?></td>
						</tr>
						<tr>
							<td>Mileage</td>
							<td>:</td>
							<td><?= $appointment->mileage ?? '' ?></td>
						</tr>
						<tr>
							<td>Year</td>
							<td>:</td>
							<td><?= $appointment->year ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<!-- SERVICES -->
		<div class="section-title">Services</div>
		<table class="data">
			<tr>
				<th width="5%">#</th>
				<th>Work Description</th>
				<th width="20%" class="text-right">Amount</th>
			</tr>
			<?php $i = 1;
			$service_total = 0;
			foreach ($services_used as $s): $service_total += $s->total_cost; ?>
				<tr>
					<td class="text-center"><?= $i++ ?></td>
					<td><?= $s->service_name ?></td>
					<td class="text-right"><?= number_format($s->total_cost, 2) ?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="2" class="text-right"><strong>Total Services</strong></td>
				<td class="text-right"><strong><?= number_format($service_total, 2) ?></strong></td>
			</tr>
		</table>

		<!-- SPARE PARTS -->
		<div class="section-title">Spare Parts</div>
		<table class="data">
			<tr>
				<th>#</th>
				<th>Parts Description</th>
				<th>Unit Price</th>
				<th>Qty</th>
				<th>Dis Amt</th>
				<th class="text-right">Amount</th>
			</tr>
			<?php $i = 1;
			$parts_total = 0;
			foreach ($parts_used_new as $p): $parts_total += $p->total_price; ?>
				<tr>
					<td class="text-center"><?= $i++ ?></td>
					<td><?= $p->part_name ?> - New parts</td>
					<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
					<td class="text-center"><?= $p->qty ?></td>
					<td class="text-center"><?= $p->dis_amount ?></td>
					<td class="text-right"><?= number_format($p->total_price, 2) ?></td>
				</tr>
			<?php endforeach; ?>
			<?php $i = 1;
			$parts_total = 0;
			foreach ($parts_used_after as $p): $parts_total += $p->total_price; ?>
				<tr>
					<td class="text-center"><?= $i++ ?></td>
					<td><?= $p->part_name ?> - Aftermarket parts</td>
					<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
					<td class="text-center"><?= $p->qty ?></td>
					<td class="text-center"><?= $p->dis_amount ?></td>
					<td class="text-right"><?= number_format($p->total_price, 2) ?></td>
				</tr>
			<?php endforeach; ?>
			<?php $i = 1;
			$parts_total = 0;
			foreach ($parts_used_used as $p): $parts_total += $p->total_price; ?>
				<tr>
					<td class="text-center"><?= $i++ ?></td>
					<td><?= $p->part_name ?> - Used parts</td>
					<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
					<td class="text-center"><?= $p->qty ?></td>
					<td class="text-center"><?= $p->dis_amount ?></td>
					<td class="text-right"><?= number_format($p->total_price, 2) ?></td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="5" class="text-right"><strong>Total Spare Parts</strong></td>
				<td class="text-right"><strong><?= number_format($parts_total, 2) ?></strong></td>
			</tr>
		</table>

		<!-- TOTALS -->
		<table class="totals">
			<tr>
				<td>Amount AED</td>
				<td class="text-right"><?= number_format($estimation->subtotal, 2) ?></td>
			</tr>
			<tr>
				<td>Discount AED</td>
				<td class="text-right"><?= number_format($estimation->discount, 2) ?></td>
			</tr>
			<tr>
				<td>VAT 5%</td>
				<td class="text-right"><?= number_format($estimation->tax_amount, 2) ?></td>
			</tr>
			<tr>
				<td><strong>Net Total AED</strong></td>
				<td class="text-right"><strong><?= number_format($estimation->grand_total, 2) ?></strong></td>
			</tr>
		</table>

		<div style="clear:both"></div>

		<!-- REMARKS -->
		<div class="remarks">
			<strong>Remarks:</strong><br>
			<?= nl2br($estimation->remarks) ?>
		</div>

		<!-- FOOTER -->
		<div class="footer">
			<p>Total Amount in Words:<br><strong><?= $amount_in_words ?></strong></p>
			<p>1. Additional repairs if any will be informed.<br>
				2. Prices subject to availability of spare parts.<br>
				3. Quotation valid for 15 days.</p>
			<br>
			<p>Name: _______________________ &nbsp;&nbsp; Signature: _______________________</p>
		</div>

	</div>
</body>

</html>
<style>
	@media print {

		/* Hide app UI */
		.topbar,
		.navbar,
		.sidebar,
		.page-header,
		.page-title,
		.breadcrumb .no-print {
			display: none !important;
		}

		/* Remove page margins added by layout */
		body {
			margin-top: 0 !important;
			padding-top: 0 !important;
		}

		/* Make estimation full width */
		.print-container {
			width: 100%;
			margin: 0;
			padding: 0;
		}
	}

	.est-title-line {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-weight: bold;
		border-top: 2px solid #000;
		border-bottom: 2px solid #000;
		padding: 6px 4px;
		margin: 8px 0;
		font-size: 13px;
	}

	.est-title {
		font-size: 18px;
		letter-spacing: 1px;
	}

	.est-info {
		width: 100%;
		border-collapse: collapse;
		margin-bottom: 10px;
	}

	.est-info table {
		width: 100%;
		font-size: 12px;
	}

	.est-info td {
		padding: 2px 4px;
		vertical-align: top;
	}

	.info-left td:first-child,
	.info-right td:first-child {
		width: 90px;
		font-weight: bold;
	}

	.info-left td:nth-child(2),
	.info-right td:nth-child(2) {
		width: 10px;
	}
</style>
