<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">

	<style>
		/* ================= PAGE ================= */

		@page {
			size: A4;
			margin: 12mm;
			/* equal margin on all sides */
		}

		body {
			margin: 0;
			padding: 0;
		}

		.print-wrapper {
			width: 100%;
			/* max-width: 190mm; */
			/* A4 width minus margins */
			margin: 0 auto;
			/* 🔥 centers content */
			box-sizing: border-box;
			font-family: Arial, sans-serif;
			font-size: 12px;
			background: #fff;
			padding: 0 2mm;
		}


		/* ================= LAYOUT ================= */
		.container {
			width: 100%;
			background: #fff;
		}

		/* ================= HEADER ================= */
		.header {
			border-bottom: 2px solid #000;
			padding-bottom: 8px;
			margin-bottom: 10px;
			display: table;
			width: 100%;
		}

		.logo,
		.company-info {
			display: table-cell;
			vertical-align: middle;
		}

		.logo {
			width: 40%;
		}

		.company-info {
			width: 60%;
			text-align: right;
			font-size: 11px;
		}

		.print-logo {
			height: 100px;
			width: auto;
		}

		/* ================= TITLE ================= */
		.est-title-line {
			display: flex;
			align-items: center;
			justify-content: space-between;
			/* 🔥 left & right */
			font-weight: bold;
			border-top: 2px solid #000;
			border-bottom: 2px solid #000;
			padding: 6px 10px;
			margin: 10px 0;
		}

		.est-title-line .center {
			flex: 1;
			text-align: center;
			/* ESTIMATION in center */
		}

		.est-title-line .left,
		.est-title-line .right {
			white-space: nowrap;
		}


		/* ================= TABLES ================= */
		table {
			width: 100%;
			max-width: 100%;
			box-sizing: border-box;
			/* 🔥 MOST IMPORTANT */
			border-collapse: collapse;
		}

		table.data th,
		table.data td,
		table.totals td {
			border: 1px solid #000;
			padding: 3px 4px;
			/* not more than this */
			box-sizing: border-box;
		}


		.est-info td {
			padding: 2px 2px;
		}

		.section-title {
			font-weight: bold;
			border-bottom: 1px solid #000;
			margin: 12px 0 6px;
		}

		table.data th,
		table.data td,
		table.totals td {
			border: 1px solid #000;
			padding: 4px;
		}

		table.data th {
			background: #f5f5f5;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		/* ================= FOOTER ================= */
		.footer {
			font-size: 10px;
			page-break-inside: avoid;
		}

		.terms-list {
			font-size: 11px;
			padding-left: 18px;
		}

		.terms-list li {
			margin-bottom: 4px;
			line-height: 1.4;
		}

		/* ================= PAGE BREAK ================= */
		.page-break {
			page-break-before: always;
			break-before: page;
		}

		/* ================= PRINT (🔥 CRITICAL FIX) ================= */
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

			div {
				box-shadow: none !important;
			}

			table {
				page-break-inside: auto;
			}

			tr {
				page-break-inside: avoid;
			}

			thead {
				display: table-header-group;
			}
		}
	</style>
</head>

<body onload="window.print()">

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

					<div class="est-title-line">
						<span>QTN # : <?= $quotation->quotation_no ?></span>
						<span class="est-title">QUOTATION</span>
						<span>Date : <?= date('d/m/Y', strtotime($quotation->quotation_date)) ?></span>
					</div>

				</td>
			</tr>
		</thead>

		<!-- ================= BODY ================= -->

		<tbody>
			<tr>
				<td>

					<!-- CUSTOMER + VEHICLE -->

					<table class="est-info">
						<tr>

							<td width="40%">
								<table>
									<tr>
										<td style="font-weight: bold;">Name</td>
										<td><?= $appointment->name ?? $customer->name ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Contact</td>
										<td><?= $appointment->phone ?? $customer->phone ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Address</td>
										<td><?= $appointment->address ?? $customer->address ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">TRN</td>
										<td><?= $appointment->trn_no ?? $customer->trn ?></td>
									</tr>
								</table>
							</td>

							<td width="30%">
								<table>
									<tr>
										<td style="font-weight: bold;">Email</td>
										<td><?= $appointment->email ?? $customer->email ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Brand</td>
										<td><?= $appointment->brand ?? $vehicle->brand ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Model</td>
										<td><?= $appointment->model ?? $vehicle->model ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">VIN</td>
										<td><?= $appointment->chassis_no ?? $vehicle->chassis_no ?></td>
									</tr>
								</table>
							</td>

							<td width="30%">
								<table>
									<tr>
										<td style="font-weight: bold;">Plate No</td>
										<td><?= $appointment->registration_no ?? $vehicle->registration_no ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Colour</td>
										<td><?= $appointment->color ?? $vehicle->color ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Mileage</td>
										<td><?= $appointment->mileage ?? '' ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Year</td>
										<td><?= $appointment->year ?? $vehicle->year ?></td>
									</tr>
								</table>
							</td>

						</tr>
					</table>


					<!-- ================= SERVICES ================= -->
					<?php
					$service_total       = 0;
					$parts_total         = 0;
					$parts_discount_total = 0;
					$sublet_total        = 0;
					$jd_total = 0;

					$taxamt = 0;
					$vatamt = 0;
					$totalparts = 0;
					$totalvat3 = 0;
					$totalservice3 = 0;
					$totaldiscount = 0;
					$service_total = 0;
					$totalvat = 0;
					$fulldiscount = 0;
					?>
					<?php if ($total_services_used > 0) { ?>

						<div class="section-title">Services</div>

						<table class="data">
							<thead>
								<tr>
									<th width="5%">#</th>
									<th>Description</th>
									<th width="20%">Amount</th>
								</tr>
							</thead>

							<tbody>

								<?php
								$i = 1;
								$service_total = 0;
								$totaldiscount = 0;

								foreach ($services_used as $s):
									$service_total += $s->total_cost;
									$totaldiscount += $s->discount_amount;
								?>

									<tr>
										<td class="text-center"><?= $i++ ?></td>
										<td><?= $s->service_name ?></td>
										<td class="text-right"><?= number_format($s->total_cost, 2) ?></td>
									</tr>

								<?php endforeach; ?>

							</tbody>
						</table>

					<?php } ?>


					<!-- ================= PARTS ================= -->

					<?php if ($total_parts_count > 0) { ?>

						<div class="section-title">Spare Parts</div>

						<table class="data">
							<thead>
								<tr>
									<th>#</th>
									<th>Description</th>
									<th>Unit</th>
									<th>Qty</th>
									<th>Dis</th>
									<th width="20%">Amount</th>
								</tr>
							</thead>

							<tbody>

								<?php
								$i = 1;
								$parts_total = 0;
								$parts_discount_total = 0;

								$allParts = array_merge($parts_used_new, $parts_used_after, $parts_used_used);

								foreach ($allParts as $p):

									$parts_total += $p->total_price;
									$parts_discount_total += $p->dis_amount;
								?>

									<tr>
										<td class="text-center"><?= $i++ ?></td>
										<td><?= $p->part_name ?><br><?= $p->partremarks ?></td>
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
							</tbody>
						</table>

					<?php } ?>

					<?php if ($total_job_descriptions > 0) { ?>
						<div class="section-title">Sublet Services</div>
						<table class="data">
							<tr>
								<th width="5%">#</th>
								<th>Work Description</th>
								<th width="20%" class="text-right">Amount</th>
							</tr>
							<?php $i = 1;
							$jd_total = 0;
							foreach ($job_descriptions as $s): $jd_total += $s->amount; ?>
								<tr>
									<td class="text-center"><?= $i++ ?></td>
									<td><?= $s->description ?></td>
									<td class="text-right"><?= number_format($s->amount, 2) ?></td>
								</tr>
							<?php endforeach; ?>
							<tr>
								<td colspan="2" class="text-right"><strong>Total Services</strong></td>
								<td class="text-right"><strong><?= number_format($jd_total, 2) ?></strong></td>
							</tr>
							<!-- ================================================================ -->

							<?php $totalvat3 = $jd_total * 5 / 100; ?>


							<?php $totalservice3 = $jd_total + $totalvat3; ?>



							<!-- ================================================================================= -->

						</table>
					<?php } ?>
					<!-- ================= TOTALS ================= -->

					<?php
					$subtotal = $service_total + $parts_total;
					$fulldiscount = $parts_discount_total + $totaldiscount;
					$taxable_amount = $subtotal - $fulldiscount;
					$vat_amount = round($taxable_amount * .05, 2);
					$grand_total = round($taxable_amount + $vat_amount, 2);
					$amount_in_words = number_to_words_aed($grand_total);
					?>

					<table class="totals">
						<tr>
							<td>Subtotal</td>
							<td class="text-right"><?= number_format($subtotal, 2) ?></td>
						</tr>
						<tr>
							<td>Discount</td>
							<td class="text-right"><?= number_format($fulldiscount, 2) ?></td>
						</tr>
						<tr>
							<td>Taxable</td>
							<td class="text-right"><?= number_format($taxable_amount, 2) ?></td>
						</tr>
						<tr>
							<td>VAT 5%</td>
							<td class="text-right"><?= number_format($vat_amount, 2) ?></td>
						</tr>
						<tr>
							<td><strong>Net Total AED</strong></td>
							<td class="text-right"><strong><?= number_format($grand_total, 2) ?></strong></td>
						</tr>
					</table>


					<!-- ================= FOOTER ================= -->

					<div class="footer">

						<strong>Total Amount in Words:</strong><br>
						<?= $amount_in_words ?>

						<br><br>

						1. Additional repairs will be informed.<br>
						2. Prices subject to spare parts availability.<br>
						3. Quotation valid for 15 days.

						<br><br>

						Name: ____________________
						Signature: ____________________

					</div>


				</td>
			</tr>
		</tbody>

	</table>

</body>

</html>
