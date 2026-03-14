<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">

	<style>
		/* =========================================================
		TAILWIND-LIKE BASE
		========================================================= */

		body {
			font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
			font-size: 12px;
			color: #111827;
			margin: 0;
			padding: 0;
			background: #ffffff;
		}

		.container {
			width: 100%;
			max-width: 780px;
			margin: 0 auto;
			padding: 0 10px;
			box-sizing: border-box;
		}

		.page-container {
			width: 100%;
			/* max-width: 780px; */
			/* A4 safe width */
			margin: 0 auto;
			padding: 0 10px;
			box-sizing: border-box;
		}

		.text-left {
			text-align: left;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.font-bold {
			font-weight: 600;
		}

		.text-sm {
			font-size: 12px;
		}

		.text-lg {
			font-size: 18px;
		}

		.text-gray {
			color: #374151;
		}

		.border {
			border: 1px solid #e5e7eb;
		}

		.border-gray {
			border: 1px solid #d1d5db;
		}

		.rounded {
			border-radius: 6px;
		}

		.bg-gray {
			background: #f9fafb;
		}

		.bg-light {
			background: #f3f4f6;
		}

		.p-1 {
			padding: 4px;
		}

		.p-2 {
			padding: 8px;
		}

		.p-3 {
			padding: 12px;
		}

		.mb-2 {
			margin-bottom: 8px;
		}

		.mb-3 {
			margin-bottom: 12px;
		}

		.mt-2 {
			margin-top: 8px;
		}

		.mt-3 {
			margin-top: 12px;
		}

		.flex {
			display: flex;
		}

		.justify-between {
			justify-content: space-between;
		}

		.items-center {
			align-items: center;
		}

		.w-full {
			width: 100%;
		}

		/* =========================================================
		PRINT HEADER
		========================================================= */

		/* .fixed-header {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			width: 100%;
			background: #ffffff;
			padding: 0 10px;
			z-index: 1000;
		} */

		.fixed-header {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			background: #ffffff;
			z-index: 1000;
		}

		.fixed-header-inner {
			max-width: 780px;
			margin: 0 auto;
			padding: 0 10px;
		}

		.header-space {
			height: 140px;
		}

		/* =========================================================
		COMPANY HEADER
		========================================================= */

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
			line-height: 1.5;
			color: #374151;
		}

		/* =========================================================
		TITLE LINE
		========================================================= */

		.title-line {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-top: 6px;
		}

		.title {
			font-size: 18px;
			font-weight: bold;
			letter-spacing: 1px;
		}

		/* =========================================================
		INFO TABLE
		========================================================= */

		.info-section {
			display: flex;
			gap: 10px;
			margin-top: 10px;
		}

		.info-box {
			width: 100%;
			border: 1px solid #d1d5db;
			border-radius: 6px;
		}

		.info-box td {
			padding: 6px 8px;
			border-bottom: 1px solid #f1f5f9;
		}

		.info-box tr:last-child td {
			border-bottom: none;
		}

		.label {
			font-weight: 600;
			width: 140px;
			color: #374151;
		}

		/* =========================================================
		ITEM TABLE
		========================================================= */

		.items {
			width: 100%;
			border-collapse: collapse;
			margin-top: 12px;
		}

		.items th {
			background: #f3f4f6;
			border: 1px solid #d1d5db;
			padding: 8px;
			font-weight: 600;
		}

		.items td {
			border: 1px solid #e5e7eb;
			padding: 8px;
		}

		/* =========================================================
		TOTAL ROWS
		========================================================= */

		.total-row td {
			font-weight: 600;
		}

		.grand-total {
			background: #f3f4f6;
			font-weight: bold;
		}

		/* =========================================================
			WATERMARK
			========================================================= */

		.watermark {
			position: fixed;
			top: 35%;
			left: 20%;
			width: 60%;
			opacity: 0.06;
			z-index: -1;
		}

		.watermark img {
			width: 100%;
		}

		/* =========================================================
			PRINT SETTINGS
			========================================================= */

		@media print {

			thead {
				display: table-header-group;
			}

			tfoot {
				display: table-footer-group;
			}

			tr {
				page-break-inside: avoid;
			}

			.content {
				margin-bottom: 120px;
			}

		}
	</style>
</head>

<body>
	<div class="watermark">
		<img src="<?= base_url(); ?>public/header/header.jpg" alt="">
	</div>

	<!-- ============================================================
     FIXED HEADER OUTSIDE TABLE STRUCTURE
=============================================================== -->
	<!-- ================= HEADER ================= -->
	<div class="fixed-header">
		<div class="container">

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

			<div class="title-line">
				<span>PO # : <?= $po[0]->po_code ?></span>
				<span class="title">PURCHASE ORDER</span>
				<span>Date : <?= date('d/m/Y', strtotime($po[0]->po_date)) ?></span>
			</div>

			<!-- <div class="text-center font-bold mt-2">
				SUPPLIER PURCHASE ORDER
			</div> -->

		</div>
	</div>

	<!-- ============================================================
     MAIN PAGE FRAME (reserves header & footer)
=============================================================== -->
	<div class="container">
		   <div class="header-space"></div>
	

						<!-- ======================================================
                     MAIN CONTENT AREA
                ======================================================= -->
						

							<div class="info-section">

								<table class="info-box">
									<tr>
										<td class="label">Name</td>
										<td><?= $po[0]->supplier_name ?></td>
									</tr>
									<tr>
										<td class="label">Address</td>
										<td><?= $po[0]->billing_address ?></td>
									</tr>
									<tr>
										<td class="label">Email</td>
										<td><?= $po[0]->email_id ?></td>
									</tr>
									<tr>
										<td class="label">TRN No</td>
										<td><?= $po[0]->trn_no ?></td>
									</tr>
								</table>

								<table class="info-box">
									<tr>
										<td class="label">Doc No</td>
										<td><?= $po[0]->po_code ?></td>
									</tr>
									<tr>
										<td class="label">Quote Ref</td>
										<td><?= $po[0]->quotation_code ?></td>
									</tr>
									<tr>
										<td class="label">Payment Terms</td>
										<td><?= $po[0]->payment_term ?></td>
									</tr>
								</table>

							</div>

							<!-- ==================================================
                         PRODUCT TABLE
                    ==================================================== -->
							<table class="items">

								<thead>
									<tr>
										<th>Sl No</th>
										<th>Model</th>
										<th>Description</th>
										<th>Qty</th>
										<th>Unit</th>
										<th class="text-right">Price</th>
										<th class="text-right">Discount</th>
										<th class="text-right">Total</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$sl_no = 1;
									$total_before_vat = $po[0]->sub_total ?? 0;
									$discount = $po[0]->discount ?? 0;
									$vat_amount = $po[0]->vat_amt ?? 0;
									$grand_total = $po[0]->grand_total;

									foreach ($po_tr as $detail):
										// $total_before_vat += $detail->price * $detail->quantity;
									?>
										<tr>
											<td align="center"><?= $sl_no++; ?></td>
											<td><?= htmlspecialchars($detail->part_name); ?></td>
											<td><?= htmlspecialchars($detail->part_name); ?></td>
											<td align="center"><?= $detail->quantity; ?></td>
											<td align="center"><?= $detail->unit_name; ?></td>
											<td align="right"><?= number_format($detail->price, 2); ?></td>
											<td align="right"><?= number_format($detail->dis_amt, 2); ?></td>
											<td align="right"><?= number_format($detail->total, 2); ?></td>
										</tr>
									<?php endforeach; ?>

									<!-- your PHP loop same -->

									<tr class="total-row">
										<td colspan="7" class="text-right">Total Before VAT</td>
										<td class="text-right"><?= number_format($total_before_vat, 2) ?></td>
									</tr>

									<tr class="total-row">
										<td colspan="7" class="text-right">VAT</td>
										<td class="text-right"><?= number_format($vat_amount, 2) ?></td>
									</tr>

									<tr class="grand-total">
										<td colspan="7" class="text-right">Grand Total</td>
										<td class="text-right"><?= number_format($grand_total, 2) ?></td>
									</tr>

								</tbody>
							</table>


					
	</div>

</body>

</html>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		window.print();
	});
</script>
