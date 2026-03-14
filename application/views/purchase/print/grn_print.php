<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Goods Received Note</title>

	<style>
		/* ===============================
PAGE SETUP
=============================== */

		@page {
			size: A4;
			margin: 15mm 12mm;
		}

		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
			margin: 0;
			padding: 0;
			color: #111;
		}

		/* ===============================
COMMON CONTAINER
=============================== */

		.container {
			width: 100%;
			max-width: 780px;
			margin: 0 auto;
			padding: 0 10px;
			box-sizing: border-box;
		}

		/* ===============================
FIXED HEADER
=============================== */

		.fixed-header {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			background: #fff;
			z-index: 1000;
		}

		.header-inner {
			width: 100%;
			max-width: 780px;
			margin: 0 auto;
			padding: 0 10px;
			box-sizing: border-box;
		}

		.header-space {
			height: 130px;
		}

		/* ===============================
HEADER CONTENT
=============================== */

		.company-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 2px solid #e5e7eb;
			padding-bottom: 8px;
		}

		.logo {
			height: 60px;
		}

		.company-info {
			text-align: right;
			font-size: 11px;
			line-height: 1.4;
		}

		/* ===============================
TITLE
=============================== */

		.title {
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			margin: 10px 0;
		}

		/* ===============================
INFO BOX
=============================== */

		.info-section {
			display: flex;
			gap: 10px;
		}

		.info-box {
			width: 100%;
			border: 1px solid #ccc;
			border-radius: 6px;
		}

		.info-box td {
			padding: 6px;
		}

		/* ===============================
ITEM TABLE
=============================== */

		.items {
			width: 100%;
			border-collapse: collapse;
			margin-top: 15px;
		}

		.items th {
			border: 1px solid #ccc;
			background: #f3f4f6;
			padding: 8px;
		}

		.items td {
			border: 1px solid #ccc;
			padding: 8px;
		}

		/* ===============================
TOTAL ROWS
=============================== */

		.total-row {
			font-weight: bold;
		}

		/* ===============================
WATERMARK
=============================== */

		.watermark {
			position: fixed;
			top: 40%;
			left: 50%;
			transform: translate(-50%, -50%);
			opacity: 0.06;
			z-index: -1;
		}

		.watermark img {
			width: 60%;
		}

		@media print {
			.no-print {
				display: none !important;
			}
		}
	</style>
</head>

<body>

	<!-- WATERMARK -->
	<div class="watermark">
		<img src="<?= base_url() ?>public/header/header.jpg">
	</div>

		

	<!-- FIXED HEADER -->
	<div class="fixed-header">
		<div class="no-print">
		<button onclick="window.print()"
			class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded">
			🖨 Print
		</button>
		<a href="<?= base_url('index.php/Purchase/purchase_grn_list'); ?>"
			class="w-full sm:w-auto  ml-3 px-6 py-2 bg-gray-300 rounded print:hidden">Cancel</a>


	</div>

		<div class="header-inner">

			<div class="company-header">

				<img src="<?= base_url('public/images/logocooling.png') ?>" class="logo">

				<div class="company-info">
					Cool Runnings Garage Co LLC<br>
					7 St, Al Quoz 3, Dubai, UAE<br>
					www.coolrunningsgarage.com<br>
					info@coolrunningsgarage.com<br>
					Tel: +971 4 265 4887<br>
					TRN: 104026094300003
				</div>

			</div>

		</div>
	</div>


	<!-- PAGE CONTAINER -->
	<div class="container">


		<div class="header-space"></div>

		<div class="title">GOODS RECEIVED NOTE</div>


		<!-- INFO SECTION -->
		<div class="info-section">

			<table class="info-box">
				<tr>
					<td width="35%"><b>Name</b></td>
					<td><?= $grn[0]->supplier_name ?></td>
				</tr>

				<tr>
					<td><b>Address</b></td>
					<td><?= $grn[0]->billing_address ?></td>
				</tr>

				<tr>
					<td><b>Contact</b></td>
					<td><?= $grn[0]->contact_no ?></td>
				</tr>

				<tr>
					<td><b>Email</b></td>
					<td><?= $grn[0]->email_id ?></td>
				</tr>

			</table>


			<table class="info-box">

				<tr>
					<td width="35%"><b>Date</b></td>
					<td><?= $grn[0]->grn_date ?></td>
				</tr>

				<tr>
					<td><b>Doc No</b></td>
					<td><?= $grn[0]->grn_code ?></td>
				</tr>

				<tr>
					<td><b>Supplier</b></td>
					<td><?= $grn[0]->supplier_name ?></td>
				</tr>

			</table>

		</div>


		<!-- ITEMS TABLE -->
		<table class="items">

			<thead>

				<tr>
					<th>Sl No</th>
					<th>Model</th>
					<th>Description</th>
					<th>Qty</th>
					<th>Unit</th>
					<th style="text-align:right;">Price</th>
					<th style="text-align:right;">Total</th>
				</tr>

			</thead>

			<tbody>

				<?php
				$sl = 1;
				foreach ($grn_tr as $row):
				?>

					<tr>

						<td align="center"><?= $sl++ ?></td>

						<td><?= $row->part_code ?></td>

						<td><?= $row->part_name ?></td>

						<td align="center"><?= $row->rec_quantity ?></td>

						<td align="center"><?= $row->unit_name ?></td>

						<td align="right"><?= number_format($row->price, 2) ?></td>

						<td align="right"><?= number_format($row->total, 2) ?></td>

					</tr>

				<?php endforeach; ?>


				<tr class="total-row">
					<td colspan="6" align="right">Total Before VAT</td>
					<td align="right"><?= number_format($grn[0]->sub_total, 2) ?></td>
				</tr>

				<tr class="total-row">
					<td colspan="6" align="right">Discount</td>
					<td align="right"><?= number_format($grn[0]->discount, 2) ?></td>
				</tr>

				<tr class="total-row">
					<td colspan="6" align="right">VAT</td>
					<td align="right"><?= number_format($grn[0]->vat_amt, 2) ?></td>
				</tr>

				<tr class="total-row">
					<td colspan="6" align="right">Grand Total</td>
					<td align="right"><?= number_format($grn[0]->grand_total, 2) ?></td>
				</tr>

			</tbody>

		</table>


		<br><br>

		Prepared By: <?= $grn[0]->username ?>


	</div>

</body>

</html>
