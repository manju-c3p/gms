<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">

	<style>
		/* ============================================================
   BASE STYLING (Tailwind-like Clean Layout)
============================================================ */
		body {
			font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
			font-size: 12px;
			margin: 0;
			padding: 0;
			color: #111827;
			background: #ffffff;
		}

		@page {
			margin: 20mm 12mm 20mm 12mm;
		}

		/* ============================================================
   HEADER SECTION
============================================================ */
		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 2px solid #e5e7eb;
			padding-bottom: 10px;
			width: 100%;
		}

		.print-logo {
			height: 60px;
		}

		.company-info {
			text-align: right;
			font-size: 11px;
			line-height: 1.5;
			color: #374151;
		}

		.est-title-line {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-top: 8px;
			font-size: 13px;
		}

		.est-title {
			font-weight: bold;
			font-size: 18px;
			letter-spacing: 1px;
		}

		/* ============================================================
   PRINT SETTINGS
============================================================ */
		@media print {

			.header-space {
				height: 120px;
			}

			.fixed-header {
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				width: 100%;
				background: #ffffff;
				z-index: 1000;
				padding: 0 10px;
				box-sizing: border-box;
			}

			.header-space {
				height: 90px;
			}



			.info {
				margin-top: 10px;
			}

			.content-wrapper {
				margin-top: 20px;
				margin-bottom: 100px;
			}

			tr {
				page-break-inside: avoid !important;
			}

			thead {
				display: table-header-group;
			}

			tfoot {
				display: table-footer-group;
			}
		}

		/* ============================================================
   INFO SECTION
============================================================ */
		.info {
			margin-top: 10px;
		}

		.info .left {
			flex: 1;
		}

		.info .right {
			width: 36%;
		}

		.info-table {
			width: 100%;
			border: 1px solid #e5e7eb;
			border-collapse: collapse;
			border-radius: 6px;
		}

		.info-table td {
			padding: 7px 8px;
			border-bottom: 1px solid #f3f4f6;
		}

		.info-table tr:last-child td {
			border-bottom: none;
		}

		.info-table td.label {
			font-weight: 600;
			width: 30%;
			color: #374151;
		}

		/* ============================================================
   ITEMS TABLE
============================================================ */
		.items {
			width: 100%;
			border-collapse: collapse;
			border: 1px solid #e5e7eb;
			font-size: 12px;
		}

		.items th {
			background: #f9fafb;
			border: 1px solid #e5e7eb;
			padding: 8px;
			text-align: center;
			font-weight: 600;
			color: #374151;
		}

		.items td {
			border: 1px solid #e5e7eb;
			padding: 8px;
		}

		.c-center {
			text-align: center;
		}

		.c-right {
			text-align: right;
		}

		/* Highlight totals */
		.items tr:nth-last-child(-n+4) td {
			font-weight: 600;
		}

		/* ============================================================
   WATERMARK
============================================================ */
		.watermark {
			position: fixed;
			top: 35%;
			left: 20%;
			width: 60%;
			opacity: 0.05;
			z-index: -1;
		}

		.watermark img {
			width: 100%;
		}
	</style>
</head>

<body>

	<div class="watermark">
		<img src="<?= base_url(); ?>public/header/header.jpg" alt="">
	</div>

	<!-- ================= HEADER ================= -->
	<div class="fixed-header">

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

		<div class="est-title-line">
			<span>QTN # : <?= $quote[0]->quotation_code ?></span>
			<span class="est-title">SUPPLIER QUOTATION</span>
			<span>Date : <?= date('d/m/Y', strtotime($quote[0]->quotation_date)) ?></span>
		</div>

	

	</div><hr><br>
	<!-- ================= PAGE FRAME ================= -->
	<table>
		<thead>
			<tr>
				<td class="header-space">

					<div class="info">
						<div class="left">
							<table class="info-table">
								<tr>
									<td class="label">Name</td>
									<td><?= htmlspecialchars($quote[0]->supplier_name); ?></td>
								</tr>
								<tr>
									<td class="label">Address</td>
									<td><?= nl2br(htmlspecialchars($quote[0]->billing_address ?? '')); ?></td>
								</tr>
								<tr>
									<td class="label">Contact No</td>
									<td><?= htmlspecialchars($quote[0]->contact_number ?? ''); ?></td>
								</tr>
								<tr>
									<td class="label">Email</td>
									<td><?= htmlspecialchars($quote[0]->supplier_email ?? ''); ?></td>
								</tr>
							</table>
						</div>

						<div class="right">
							<table class="info-table">
								<tr>
									<td class="label">Date</td>
									<td><?= htmlspecialchars($quote[0]->quotation_date ?? ''); ?></td>
								</tr>
								<tr>
									<td class="label">Doc No</td>
									<td><?= htmlspecialchars($quote[0]->quotation_code); ?></td>
								</tr>
								<tr>
									<td class="label">Supplier</td>
									<td><?= htmlspecialchars($quote[0]->supplier_name); ?></td>
								</tr>
							</table>
						</div>
					</div>

				</td>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>

					<div class="content-wrapper">

						<table class="items">
							<thead>
								<tr>
									<th style="width:44px;">Sl No</th>
									<th style="width:110px;">Product Code</th>
									<th style="width:110px;">Model</th>
									<th>Description</th>
									<th style="width:56px;">Qty</th>
									<th style="width:60px;">Unit</th>
									<th style="width:90px;">Price</th>
									<th style="width:80px;">Discount</th>
									<th style="width:100px;">Total</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$sl = 1;
								$total_before_vat = $quote[0]->subtotal ?? 0;
								$total_discount = 0;
								$vat_amount = $quote[0]->vat_amt ?? 0;
								$discount = $quote[0]->discount ?? 0;
								$grand_total = $quote[0]->grand_total ?? 0;

								foreach ($quote_tr as $detail):
									$total_discount += $detail->dis_amt;
								?>
									<tr>
										<td class="c-center"><?= $sl++; ?></td>
										<td><?= htmlspecialchars($detail->part_id); ?></td>
										<td><?= htmlspecialchars($detail->part_name); ?></td>
										<td><?= htmlspecialchars($detail->part_name); ?></td>
										<td class="c-center"><?= htmlspecialchars($detail->quantity); ?></td>
										<td class="c-center"><?= htmlspecialchars($detail->unit_name ?? ''); ?></td>
										<td class="c-right"><?= number_format($detail->price, 2); ?></td>
										<td class="c-right"><?= number_format($detail->dis_amt, 2); ?></td>
										<td class="c-right"><?= number_format($detail->total, 2); ?></td>
									</tr>
								<?php endforeach; ?>

								<tr>
									<td colspan="8" class="c-right">Total Before VAT</td>
									<td class="c-right"><?= number_format($total_before_vat, 2); ?></td>
								</tr>
								<tr>
									<td colspan="8" class="c-right">Discount Amount</td>
									<td class="c-right"><?= number_format($total_discount, 2); ?></td>
								</tr>
								<tr>
									<td colspan="8" class="c-right">VAT Amount</td>
									<td class="c-right"><?= number_format($vat_amount, 2); ?></td>
								</tr>
								<tr>
									<td colspan="8" class="c-right">Total Amount</td>
									<td class="c-right"><?= number_format($grand_total, 2); ?></td>
								</tr>

							</tbody>
						</table>

					</div>

				</td>
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<td class="footer-space"></td>
			</tr>
		</tfoot>
	</table>

</body>

</html>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		window.print();
	});
</script>
