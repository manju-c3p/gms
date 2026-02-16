<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<!-- <title>Estimation Print</title> -->


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
	</style>
</head>

<body onload="window.print()">

	<div class="print-wrapper">
		<!-- ACTIONS -->
		<div class="hide-on-print" style="margin-bottom:10px;">
			<button onclick="window.print()" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded">🖨 Print</button>
			<a href="<?= base_url('index.php/Quotation/edit/' . $quotation->quotation_id) ?>" class="w-full sm:w-auto  ml-3 px-6 py-2 bg-gray-300 rounded print:hidden">Cancel</a>
		</div>

		<!-- HEADER -->
		<div class="header">
			<div class="logo">
				<div class="brand flex items-center gap-3 px-4 py-3">
					<img src="<?= base_url('public/images/logocooling.png') ?>"
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
							<td><?= $appointment->name ?? $customer->name  ?></td>
						</tr>
						<tr>
							<td>Contact</td>
							<td>:</td>
							<td><?= $appointment->phone ?? $customer->phone ?></td>
						</tr>
						<tr>
							<td>Address</td>
							<td>:</td>
							<td><?= $appointment->address ?? $customer->address ?></td>
						</tr>
						<tr>
							<td>TRN No</td>
							<td>:</td>
							<td><?= $appointment->trn_no ?? $customer->trn ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><?= $appointment->email ?? $customer->email ?></td>
						</tr>
					</table>
				</td>

				<!-- RIGHT SIDE : VEHICLE -->
				<td width="50%" class="info-right">
					<table>
						<tr>
							<td>Brand</td>
							<td>:</td>
							<td><?= $appointment->brand ?? $vehicle->brand ?></td>
						</tr>
						<tr>
							<td>Model</td>
							<td>:</td>
							<td><?= $appointment->model ?? $vehicle->model ?></td>
						</tr>
						<tr>
							<td>Vin No</td>
							<td>:</td>
							<td><?= $appointment->chassis_no ?? $vehicle->chassis_no ?></td>
						</tr>
						<tr>
							<td>Plate No</td>
							<td>:</td>
							<td><?= $appointment->registration_no ?? $vehicle->registration_no  ?></td>
						</tr>
						<tr>
							<td>Colour</td>
							<td>:</td>
							<td><?= $appointment->color  ?? $vehicle->color ?></td>
						</tr>
						<tr>
							<td>Mileage</td>
							<td>:</td>
							<td><?= $appointment->mileage ?? '' ?></td>
						</tr>
						<tr>
							<td>Year</td>
							<td>:</td>
							<td><?= $appointment->year ?? $vehicle->year  ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
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
				$fulldiscount=0;
		?>

		<!-- SERVICES -->
		<?php if ($total_services_used > 0) { ?>
			<div class="section-title">Services</div>
			<table class="data">
				<tr>
					<th width="5%">#</th>
					<th>Work Description</th>
					<th width="20%" class="text-right">Amount</th>
				</tr>
				<?php $i = 1;
				
				
				foreach ($services_used as $s): $service_total += $s->total_cost;
					$totaldiscount += $s->discount_amount; ?>
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

				<!-- =========================================================== -->

				<tr>
					<td colspan="2" class="text-right"><strong>Service Discount</strong></td>
					<td width="20%" class="text-right"><strong><?= number_format($totaldiscount, 2) ?></strong></td>
				</tr>
				<tr>
					<td colspan="2" class="text-right"><strong>Taxable Amount</strong></td>
					<td width="20%" class="text-right"><strong><?= number_format(($service_total - $totaldiscount), 2) ?></strong></td>
				</tr>
				<tr>
					<?php $totalvat = ($service_total - $totaldiscount) * 5 / 100; ?>
					<td colspan="2" class="text-right"><strong>Service VAT (5%)</strong></td>
					<td width="20%" class="text-right"><strong><?= number_format($totalvat, 2) ?></strong></td>
				</tr>
				<tr>

					<?php $totalservice = ($service_total - $totaldiscount) + $totalvat; ?>
					<td colspan="2" class="text-right"><strong>Service Total (Including VAT)</strong></td>
					<td width="20%" class="text-right"><strong><?= number_format($totalservice, 2) ?></strong></td>
				</tr>





				<!-- ====================================================================================== -->



			</table>
		<?php } ?>
		<!-- SPARE PARTS -->
		<?php if ($total_parts_count > 0) { $i = 1; ?>
			<div class="section-title">Spare Parts</div>
			<table class="data">
				<tr>
					<th>#</th>
					<th>Parts Description</th>
					<th>Unit Price</th>
					<th>Qty</th>
					<th>Dis Amt</th>
					<th width="20%" class="text-right">Amount</th>
				</tr>
				<?php 
				$parts_total = 0;

				foreach ($parts_used_new as $p):
					$parts_total += $p->total_price;
					$parts_discount_total += $p->dis_amount; ?>
					<tr>
						<td class="text-center"><?= $i++ ?></td>
						<td>

							<?php
							if (!empty($p->labeling) && $p->labeling == 1) {
								echo $p->part_name . ' - Original';
							} else {
								echo $p->part_name;
							}

							echo "<br>" . $p->partremarks;

							?>

						</td>
						<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
						<td class="text-center"><?= $p->qty ?></td>
						<td class="text-center"><?= $p->dis_amount ?></td>
						<td class="text-right"><?= number_format($p->total_price, 2) ?></td>
					</tr>
				<?php endforeach; ?>
				<?php 
				foreach ($parts_used_after as $p):
					$parts_total += $p->total_price;
					$parts_discount_total += $p->dis_amount; ?>
					<tr>
						<td class="text-center"><?= $i++ ?></td>
						<td>

							<?php
							if (!empty($p->labeling) && $p->labeling == 1) {
								echo $p->part_name . ' - Aftermarket';
							} else {
								echo $p->part_name;
							}
							echo "<br>" . $p->partremarks;
							?>


						</td>
						<td class="text-right"><?= number_format($p->selling_price, 2) ?></td>
						<td class="text-center"><?= $p->qty ?></td>
						<td class="text-center"><?= $p->dis_amount ?></td>
						<td class="text-right"><?= number_format($p->total_price, 2) ?></td>
					</tr>
				<?php endforeach; ?>
				<?php 

				foreach ($parts_used_used as $p):
					$parts_total += $p->total_price;
					$parts_discount_total += $p->dis_amount; ?>
					<tr>
						<td class="text-center"><?= $i++ ?></td>
						<td>
							<?php
							if (!empty($p->labeling) && $p->labeling == 1) {
								echo $p->part_name . ' - Used';
							} else {
								echo $p->part_name;
							}
							echo "<br>" . $p->partremarks;
							?>

						</td>
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
				<!-- ========================================================================== -->
				<tr>
					<td colspan="5" class="text-right"><strong>Total Discount</strong></td>
					<td width="20%" class="text-right"><strong><?= number_format($parts_discount_total, 2) ?></strong></td>
				</tr>
				<?php $taxamt = $parts_total -  $parts_discount_total; ?>
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


				<!-- =============================================================================================== -->
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
				<tr>
					<?php $totalvat3 = $jd_total * 5 / 100; ?>
					<td colspan="2" class="text-right"><strong>Service VAT (5%)</strong></td>
					<td width="20%" class="text-right"><strong><?= number_format($totalvat3 ?? 0, 2) ?></strong></td>
				</tr>
				<tr>

					<?php $totalservice3 = $jd_total + $totalvat3; ?>
					<td colspan="2" class="text-right"><strong>Service Total (Including VAT)</strong></td>
					<td width="20%" class="text-right"><strong><?= number_format($totalservice3, 2) ?></strong></td>
				</tr>


				<!-- ================================================================================= -->

			</table>
		<?php } ?>




		<?php
		$subtotal = $service_total + $parts_total + $jd_total;

		$taxable_amount = $subtotal - ($parts_discount_total + $totaldiscount);

		$fulldiscount = $parts_discount_total + $totaldiscount;
		$vat_amount = round($taxable_amount * 0.05, 2);

		$grand_total = round($taxable_amount + $vat_amount, 2);

		// ✅ convert calculated amount to words
		$amount_in_words = number_to_words_aed($grand_total);
		?>
		<br>
		<!-- TOTALS -->
		<table class="totals">
			<tr>
				<td>Subtotal AED</td>
				<td width="20%" class="text-right"><?= number_format($subtotal, 2) ?></td>
			</tr>

			<tr>
				<td>Discount AED</td>
				<td width="20%" class="text-right"><?= number_format($fulldiscount, 2) ?></td>
			</tr>
			<tr>
				<td>Taxable AED</td>
				<td width="20%" class="text-right"><?= number_format($taxable_amount, 2) ?></td>
			</tr>

			<tr>
				<td>VAT 5%</td>
				<td width="20%" class="text-right"><?= number_format($vat_amount, 2) ?></td>
			</tr>

			<tr>
				<td><strong>Net Total AED</strong></td>
				<td width="20%" class="text-right">
					<strong><?= number_format($grand_total, 2) ?></strong>
				</td>
			</tr>
		</table>


		<!-- <div style="clear:both"></div> -->
		<br><br><br>
		<!-- REMARKS -->
		<div class="remarks">
			<strong>Remarks:</strong><br>
			<?= nl2br($estimation->remarks) ?>
		</div><br>

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
		margin-bottom: 5px;
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
