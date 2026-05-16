<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Estimation Print</title>

	<style>
		/* ================= PAGE ================= */
		/* @page {
			margin: 10mm;
		} */

		/* html,
		body {
			margin: 0;
			padding: 0;
			background: #fff;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #000;
		} */

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
			height: 70px;
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
			padding: 2px 4px;
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


		@media print {

			.keep-together {
				page-break-inside: avoid;
				break-inside: avoid;
			}

			table.totals {
				page-break-inside: avoid;
			}

			tr {
				page-break-inside: avoid;
			}

			.section-title {
				page-break-after: avoid;
			}
		}
	</style>
</head>

<body>

	<!-- ACTION BUTTONS (WILL NOT PRINT) -->
	<div class="hide-on-print" style="
    margin:10px 0;
    padding:10px;
    border-bottom:1px solid #ccc;">

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

		<a href="<?= base_url('index.php/Estimation/edit/' . $estimation->estimation_id) ?>"
			style="
        padding:8px 18px;
        background:#e5e7eb;
        color:#000;
        border-radius:4px;
        text-decoration:none;
        margin-left:10px;
        font-size:14px;
        display:inline-block;">
			Cancel
		</a>

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

					<div class="est-title-line">
						<span>Est # : <?= $estimation->estimation_no ?></span>
						<span class="center">ESTIMATION</span>
						<span>Date : <?= date('d/m/Y', strtotime($estimation->estimation_date)) ?></span>
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
										<td><strong>Name</strong></td>
										<td><?= $appointment->customer_name ?? $customer->name ?></td>
									</tr>
									<tr>
										<td><strong>Phone</strong></td>
										<td><?= $appointment->phone ?? $customer->phone ?></td>
									</tr>
									<tr>
										<td><strong>Email</strong></td>
										<td><?= $appointment->email ?? $customer->email ?></td>
									</tr>
									<tr>
										<td><strong>TRN</strong></td>
										<td><?= $customer->trn ?? '' ?></td>
									</tr>
								</table>
							</td>

							<td width="30%">
								<table>
									<tr>
										<td><strong>Brand</strong></td>
										<td><?= $appointment->brand ?? $vehicle->brand ?></td>
									</tr>
									<tr>
										<td><strong>Model</strong></td>
										<td><?= $appointment->model ?? $vehicle->model ?></td>
									</tr>
									<tr>
										<td><strong>Year</strong></td>
										<td><?= $appointment->year ?? $vehicle->year ?></td>
									</tr>
									<tr>
										<td><strong>VIN</strong></td>
										<td><?= $vehicle->chassis_no ?? '' ?></td>
									</tr>
								</table>
							</td>

							<td width="30%">
								<table>
									<tr>
										<td><strong>Plate No</strong></td>
										<td><?= $appointment->registration_no ?? $vehicle->registration_no ?></td>
									</tr>
									<tr>
										<td><strong>Colour</strong></td>
										<td><?= $vehicle->color ?? '' ?></td>
									</tr>
									<tr>
										<td><strong>Mileage</strong></td>
										<td><?= $appointment->mileage ?? '' ?></td>
									</tr>
								</table>
							</td>

						</tr>
					</table>


					<!-- ================= SERVICES ================= -->
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

								<?php $i = 1;
								$total = 0;
								$totalvat = 0;
								$totaldiscount = 0;
								foreach ($services_used as $s): $total += $s->total_cost;
									$totaldiscount += $s->discount_amount;
								?>
									<tr>
										<td class="text-center"><?= $i++ ?></td>
										<td><?= $s->service_name ?></td>
										<td width="20%" class="text-right"><?= number_format($s->total_cost, 2) ?></td>
									</tr>
								<?php endforeach;
								?>
								<tr>
									<td colspan="2" class="text-right"><strong>Service Total</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($total, 2) ?></strong></td>
								</tr>
								<tr>
									<td colspan="2" class="text-right"><strong>Service Discount</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($totaldiscount, 2) ?></strong></td>
								</tr>
								<tr>
									<td colspan="2" class="text-right"><strong>Taxable Amount</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format(($total - $totaldiscount), 2) ?></strong></td>
								</tr>
								<tr>
									<?php $totalvat = ($total - $totaldiscount) * 5 / 100; ?>
									<td colspan="2" class="text-right"><strong>Service VAT (5%)</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($totalvat, 2) ?></strong></td>
								</tr>
								<tr>

									<?php $totalservice = ($total - $totaldiscount) + $totalvat; ?>
									<td colspan="2" class="text-right"><strong>Service Total (Including VAT)</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($totalservice, 2) ?></strong></td>
								</tr>


							</tbody>
						</table>

					<?php } ?>


					<!-- ================= SPARE PARTS ================= -->

					<?php if ($total_parts_count > 0) { ?>
						<?php
						$new_total = 0;
						$i = 1;
						$rowtotal_new = 0;
						$discount = 0;
						$taxamt = 0;
						$vatamt = 0;
						$totalparts = 0;

						?>
						<?php if (!empty($parts_used_new)) { ?>
							<div class="section-title">New Spare Parts</div>

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

									<?php foreach ($parts_used_new as $p):
										$rowtotal_new = $p->total_price + $p->dis_amount;
										$new_total += $p->total_price + $p->dis_amount;
										$discount += $p->dis_amount;
									?>
										<tr>
											<td class="text-center"><?= $i++ ?></td>
											<td><?= $p->part_name ?><br><?= $p->partremarks ?></td>
											<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
											<td class="text-center"><?= $p->qty ?></td>
											<td class="text-center"><?= number_format($p->dis_amount, 2) ?></td>
											<td width="20%" class="text-right"><?= number_format($rowtotal_new, 2) ?></td>
										</tr>
									<?php endforeach; ?>

									<tr>
										<td colspan="5" class="text-right"><strong>Parts Sub Total</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($new_total, 2) ?></strong></td>
									</tr>
									<tr>
										<td colspan="5" class="text-right"><strong>Total Discount</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($discount, 2) ?></strong></td>
									</tr>
									<?php $taxamt = $new_total -  $discount; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>Taxable Amount</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($taxamt, 2) ?></strong></td>
									</tr>
									<?php $vatamt = $taxamt * 5 / 100;; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>VAT (5%)</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($vatamt, 2) ?></strong></td>
									</tr>
									<?php $totalparts = $taxamt + $vatamt; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>Parts Total (Including VAT)</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($totalparts, 2) ?></strong></td>
									</tr>


								</tbody>

							</table>
						<?php } ?>
						<!-- ======================================= -->
						<?php
						$after_total = 0;
						$i = 1;
						$rowtotal_after = 0;

						$discount1 = 0;
						$taxamt1 = 0;
						$vatamt1 = 0;
						$totalparts1 = 0;
						?>
						<?php if (!empty($parts_used_after)) { ?>
							<div class="section-title">Aftermarket Spare Parts</div>

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

									<?php foreach ($parts_used_after as $p):
										$rowtotal_after = $p->total_price + $p->dis_amount;
										$after_total += $p->total_price + $p->dis_amount;
										$discount1 += $p->dis_amount; ?>
										<tr>
											<td class="text-center"><?= $i++ ?></td>
											<td><?= $p->part_name ?><br><?= $p->partremarks ?></td>
											<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
											<td class="text-center"><?= $p->qty ?></td>
											<td class="text-center"><?= number_format($p->dis_amount, 2) ?></td>
											<td width="20%" class="text-right"><?= number_format($rowtotal_after, 2) ?></td>
										</tr>
									<?php endforeach; ?>

									<tr>
										<td colspan="5" class="text-right"><strong>Total Aftermarket Parts</strong></td>
										<td class="text-right"><strong><?= number_format($after_total, 2) ?></strong></td>
									</tr>
									<tr>
										<td colspan="5" class="text-right"><strong>Total Discount</strong></td>
										<td class="text-right"><strong><?= number_format($discount1, 2) ?></strong></td>
									</tr>
									<?php $taxamt1 = $after_total -  $discount1; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>Taxable Amount</strong></td>
										<td class="text-right"><strong><?= number_format($taxamt1, 2) ?></strong></td>
									</tr>
									<?php $vatamt1 = $taxamt1 * 5 / 100;; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>VAT (5%)</strong></td>
										<td class="text-right"><strong><?= number_format($vatamt1, 2) ?></strong></td>
									</tr>
									<?php $totalparts1 = $taxamt1 + $vatamt1; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>Parts Total (Including VAT)</strong></td>
										<td class="text-right"><strong><?= number_format($totalparts1, 2) ?></strong></td>
									</tr>

								</tbody>

							</table>
						<?php } ?>
						<!-- ================================================= -->
						<?php
						$used_total = 0;
						$i = 1;

						$rowtotal_used = 0;
						$discount2 = 0;
						$taxamt2 = 0;
						$vatamt2 = 0;
						$totalparts2 = 0;
						?>
						<?php if (!empty($parts_used_used)) { ?>
							<div class="section-title">Used Spare Parts</div>

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

									<?php foreach ($parts_used_used as $p):
										$rowtotal_used = $p->total_price + $p->dis_amount;
										$used_total += $p->total_price + $p->dis_amount;
										$discount2 += $p->dis_amount;
									?>
										<tr>
											<td class="text-center"><?= $i++ ?></td>
											<td><?= $p->part_name ?><br><?= $p->partremarks ?></td>
											<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
											<td class="text-center"><?= $p->qty ?></td>
											<td class="text-center"><?= number_format($p->dis_amount, 2) ?></td>
											<td width="20%" class="text-right"><?= number_format($rowtotal_used, 2) ?></td>
										</tr>
									<?php endforeach; ?>

									<tr>
										<td colspan="5" class="text-right"><strong>Total Used Parts</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($used_total, 2) ?></strong></td>
									</tr>
									<tr>
										<td colspan="5" class="text-right"><strong>Total Discount</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($discount2, 2) ?></strong></td>
									</tr>
									<?php $taxamt2 = $used_total -  $discount2; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>Taxable Amount</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($taxamt2, 2) ?></strong></td>
									</tr>
									<?php $vatamt2 = $taxamt2 * 5 / 100;; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>VAT (5%)</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($vatamt2, 2) ?></strong></td>
									</tr>
									<?php $totalparts2 = $taxamt2 + $vatamt2; ?>
									<tr>
										<td colspan="5" class="text-right"><strong>Parts Total (Including VAT)</strong></td>
										<td width="20%" class="text-right"><strong><?= number_format($totalparts2, 2) ?></strong></td>
									</tr>

								</tbody>

							</table>
						<?php } ?>

					<?php } ?>


					<!-- ================= SUBLET ================= -->

					<?php if ($total_job_descriptions > 0) { ?>

						<div class="section-title">Sublet Services</div>

						<table class="data">

							<thead>
								<tr>
									<th>#</th>
									<th>Description</th>
									<th width="20%">Amount</th>
								</tr>
							</thead>

							<tbody>

								<?php $i = 1;
								$jd_total = 0;

								$totalvat3 = 0;
								$totalservice3 = 0;
								$totaldiscount3 = 0;
								foreach ($job_descriptions as $s): $jd_total += $s->amount;
									$totaldiscount3 += $s->discount_amount;

								?>
									<tr>
										<td class="text-center"><?= $i++ ?></td>
										<td><?= $s->description ?></td>
										<td width="20%" class="text-right"><?= number_format($s->amount, 2) ?></td>
									</tr>
								<?php endforeach; ?>
								<tr>
									<td colspan="2" class="text-right"><strong>Total Services</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($jd_total, 2) ?></strong></td>
								</tr>
								<tr>
									<td colspan="2" class="text-right"><strong>Sublet Discount</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($totaldiscount3, 2) ?></strong></td>
								</tr>
								<tr>
									<td colspan="2" class="text-right"><strong>Taxable Amount</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format(($jd_total - $totaldiscount3), 2) ?></strong></td>
								</tr>

								<tr>
									<?php $totalvat3 = ($jd_total - $totaldiscount3) * 5 / 100; ?>
									<td colspan="2" class="text-right"><strong>Service VAT (5%)</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($totalvat3 ?? 0, 2) ?></strong></td>
								</tr>
								<tr>

									<?php $totalservice3 = ($jd_total - $totaldiscount3) + $totalvat3; ?>
									<td colspan="2" class="text-right"><strong>Service Total (Including VAT)</strong></td>
									<td width="20%" class="text-right"><strong><?= number_format($totalservice3, 2) ?></strong></td>
								</tr>

							</tbody>

						</table>

					<?php } ?>


					<!-- ================= FOOTER ================= -->

					<div class="footer">

						<strong>Remarks:</strong><br>
						<?= nl2br($estimation->remarks) ?>

						<br><br>

						<strong>Conditions:</strong>

						<ul class="list-disc list-outside pl-5 space-y-1 text-sm text-gray-700">
							<li>After dismantling, if any additional work or spare parts not covered in this estimate are required, a supplementary estimate will be provided.</li>
							<li>All deliveries are subject to availability of spare parts.</li>
							<li>Spare parts prices are subject to change without prior notice. Prices prevailing at the time of actual delivery shall be charged.</li>
							<li>This estimate is valid for <strong>15 days</strong> from the date of issue.</li>
							<li>Payment can only be made by cash or card. Cheque payments are not accepted.</li>
							<li>Used parts are not covered under warranty.</li>
							<li>Brand new electronic parts are not covered under warranty.</li>
							<li>The client authorizes Cool Runnings Garage to test drive the serviced vehicle.</li>
							<li>The company will not be held liable for any missing items inside the client’s vehicle.</li>
							<li>The client is responsible for removing all personal belongings from the vehicle before service or repair.</li>
							<li>A minimum of <strong>50%</strong> of the total estimate value is required as a down payment for any service.</li>
							<li>Once the client approves and confirms the estimate, it cannot be withdrawn.</li>
							<li>All approved estimates are subject to change or revision as per specialist advice during the course of work.</li>
							<li>The company will not be responsible for damage to other vehicle parts due to brittleness or friability.</li>
							<li>Free parking for <strong>7 days</strong> will be provided after completion of repairs. Thereafter, parking will be charged at <strong>AED 100 per day</strong>.</li>
							<li>The company is not liable for any loss or damage to vehicles parked outside the garage.</li>
							<li>The vehicle will not be released until full payment is received.</li>
							<li>Replaced parts must be collected by the client within <strong>2–3 days</strong>, failing which they will be treated as scrap.</li>
							<li>The company may take photographs of the vehicle and repair process for marketing purposes only.</li>
						</ul>

						<br>

						Name: ____________________

						<span style="float:right">
							Signature: ____________________
						</span>

						<br><br>

						Printed By : <?= $username ?>

					</div>


				</td>
			</tr>
		</tbody>

	</table>

</body>


</html>
