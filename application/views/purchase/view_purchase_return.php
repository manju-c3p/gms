<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Purchase Return</title>

	<style>
		/* @page {
			size: A4;
			margin: 0;
		}

		body {
			font-family: Arial;
			font-size: 12px;
			background: #fff;
			
		}

		.print-wrapper {
			width: 100%;
			background: #fff;
			 padding:12mm;
			
		} */

		@page {
			size: A4;
			margin: 10mm;
		}

		html,
		body {
			font-family: Arial;
			font-size: 12px;
			margin: 0;
			padding: 0;
			background: #fff;
		}

		.print-wrapper {
			padding: 12mm;
			background: #fff;
		}

		/* HEADER */

		.header {
			border-bottom: 2px solid #000;
			padding-bottom: 8px;
			margin-bottom: 10px;
			display: table;
			width: 100%;
		}

		.logo {
			display: table-cell;
			width: 40%;
		}

		.company-info {
			display: table-cell;
			width: 60%;
			text-align: right;
			font-size: 11px;
		}

		.print-logo {
			height: 70px;
		}

		/* TITLE */

		.title-line {
			display: flex;
			justify-content: space-between;
			border-top: 2px solid #000;
			border-bottom: 2px solid #000;
			padding: 6px;
			margin-bottom: 10px;
			font-weight: bold;
		}

		/* TABLE */

		table {
			width: 100%;
			border-collapse: collapse;
		}

		/* th,
		td {
			border: 1px solid #000;
			padding: 4px;
		} */
		.print-wrapper td {
			border: none;
		}

		.items-table {
			border-collapse: collapse;
		}

		.items-table th,
		.items-table td {
			border: 1px solid #000;
		}

		.totals-table {
			border-collapse: collapse;
		}

		.totals-table td {
			border: 1px solid #000;
		}

		th {
			background: #f3f3f3;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		/* PRINT */

		@media print {

			/* Hide UI */
			button,
			.topbar,
			.sidebar,
			.navbar,
			.hide-on-print {
				display: none !important;
			}

			/* 🔥 THIS FIXES SINGLE-PAGE ISSUE */
			html,
			body,
			* {
				height: auto !important;
				overflow: visible !important;
				max-height: none !important;
			}

			body {
				background: #fff !important;
			}

			.print-wrapper {
				background: #fff !important;
			}

			button {
				display: none;
			}

			thead {
				display: table-header-group;
			}

			tr {
				page-break-inside: avoid;
			}

		}
	</style>
</head>

<body>

	<div class="hide-on-print" style="
    margin:10px 0;
    padding:10px;">
		<button onclick="window.print()" style="
        padding:8px 18px;
        background:#2563eb;
        color:#fff;
        border:none;
        border-radius:4px;
        cursor:pointer;
        font-size:14px;">
			🖨 Print
		</button>
		<a style="
        padding:8px 18px;
        background:#e5e7eb;
        color:#000;
        border-radius:4px;
        text-decoration:none;
        margin-left:10px;
        font-size:14px;
        display:inline-block;" href="<?= base_url('index.php/Purchase/purchase_return_list') ?>">Back</a>
	</div>


	<table class="print-wrapper">
		<!-- ================= REPEATING HEADER ================= -->
		<thead>
			<tr>
				<td>

					<div class="header">
						<img src="<?= base_url('public/images/logocooling.png') ?>" class="print-logo">

						<div class="company-info">
							Cool Runnings Garage Co LLC<br>
							7 St, Al Quoz 3, Dubai, UAE<br>
							www.coolrunningsgarage.com<br>
							info@coolrunningsgarage.com<br>
							Tel: +971 4 265 4887<br>
							TRN: 104026094300003
						</div>
					</div>

					<div class="title-line">
						<span>Return #: <?= $return->return_code ?></span>
						<span>PURCHASE RETURN</span>
						<span>Date : <?= date('d/m/Y', strtotime($return->return_date)) ?></span>
					</div>
				</td>
			</tr>
		</thead>


		<!-- ================= BODY ================= -->




		<tbody>
			<tr>
				<td>

					<!-- SUPPLIER INFO -->

					<table style="margin-bottom:10px;border:none">
						<tr>

							<td width="50%" style="border:none">
								<strong>Supplier :</strong> <?= $return->supplier_name ?><br>
								<strong>Reference :</strong> <?= $return->ref_no ?>
							</td>

							<td width="50%" style="border:none">
								<strong>Remarks :</strong><br>
								<?= $return->remarks ?>
							</td>

						</tr>
					</table>



					<!-- ITEMS -->

					<table class="items-table">

						<thead>

							<tr>
								<th>#</th>
								<th>Part</th>
								<th class="text-center">GRN Qty</th>
								<th class="text-center">Returned Before</th>
								<th class="text-center">Return Qty</th>
								<th class="text-right">Unit Price</th>
								<th class="text-right">Total</th>
							</tr>

						</thead>

						<tbody>

							<?php
							$i = 1;
							foreach ($items as $row) {
							?>

								<tr>

									<td class="text-center"><?= $i++ ?></td>

									<td><?= $row->part_name ?></td>

									<td class="text-center"><?= $row->grn_qty ?></td>

									<td class="text-center"><?= $row->returned_qty ?></td>

									<td class="text-center"><strong><?= $row->return_qty ?></strong></td>

									<td class="text-right"><?= number_format($row->unit_price, 2) ?></td>

									<td class="text-right"><strong><?= number_format($row->total, 2) ?></strong></td>

								</tr>

							<?php } ?>

						</tbody>

					</table>


					<!-- TOTALS -->

					<br>

					<table class="totals-table" style="width:40%;margin-left:auto">

						<tr>
							<td>Sub Total</td>
							<td class="text-right"><?= number_format($return->sub_total, 2) ?></td>
						</tr>

						<tr>
							<td>Discount (<?= $return->discount_per ?>%)</td>
							<td class="text-right"><?= number_format($return->discount_amt, 2) ?></td>
						</tr>

						<tr>
							<td>VAT (<?= $return->vat_per ?>%)</td>
							<td class="text-right"><?= number_format($return->vat_amount, 2) ?></td>
						</tr>

						<tr>
							<td><strong>Grand Total</strong></td>
							<td class="text-right"><strong><?= number_format($return->grand_total, 2) ?></strong></td>
						</tr>

					</table>


					<br><br>

					<table style="border:none;width:100%">
						<tr>

							<td style="border:none">
								Prepared By : <?= $username ?>
							</td>

							<td style="border:none;text-align:right">
								Authorized Signature
							</td>

						</tr>
					</table>


				</td>
			</tr>
		</tbody>

	</table>

</body>

</html>
