<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Job Card Print</title>

	<style>
		@page {
			size: A4;
			margin: 12mm;
		}

		body {
			margin: 0;
			padding: 0;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #000;
			background: #fff;
		}

		.print-wrapper {
			width: 100%;
			margin: 0 auto;
			box-sizing: border-box;
			padding: 0 2mm;
		}

		/* HEADER */
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
			height: 90px;
		}

		/* TITLE */
		.est-title-line {
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-weight: bold;
			border-top: 2px solid #000;
			border-bottom: 2px solid #000;
			padding: 6px 10px;
			margin: 10px 0;
		}

		.est-title-line .center {
			flex: 1;
			text-align: center;
		}

		/* TABLES */
		table {
			width: 100%;
			border-collapse: collapse;
		}

		table.data th,
		table.data td {
			border: 1px solid #000;
			padding: 4px;
		}

		table.data th {
			background: #f5f5f5;
		}

		.section-title {
			font-weight: bold;
			border-bottom: 1px solid #000;
			margin: 12px 0 6px;
		}

		.text-center {
			text-align: center;
		}

		.page-break {
			page-break-before: always;
			break-before: page;
		}

		@media print {

			button,
			.hide-on-print {
				display: none !important;
			}

			html,
			body,
			* {
				height: auto !important;
				overflow: visible !important;
				max-height: none !important;
			}

			thead {
				display: table-header-group;
			}
		}

		@media print {
    .hide-on-print,
    .topbar,
    .navbar,
    
    .sidebar,
    .dashboard,
    .app-header {
        display: none !important;
    }
}

	</style>
</head>

<body>

	<div class="print-wrapper">

		<!-- ACTIONS -->
		<div class="hide-on-print" style="margin-bottom:10px;">
			<button onclick="window.print()" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded">🖨 Print</button>
			<a href="<?= base_url('index.php/Jobcard/edit/' . $jobcard->jobcard_id) ?>" class="w-full sm:w-auto  ml-3 px-6 py-2 bg-gray-300 rounded print:hidden">Cancel</a>
		</div>

		<!-- HEADER -->
		<div class="header">
			<div class="logo">
				<img src="<?= base_url('public/images/logocooling.png') ?>" class="print-logo">
			</div>
			<div class="company-info">
				Cool Runnings Garage Co LLC<br>
				Al Quoz 3, Dubai, UAE<br>
				www.coolrunningsgarage.com<br>
				Tel: +971 4 265 4887<br>
				TRN: 104026094300003
			</div>
		</div>

		<!-- TITLE -->
		<div class="est-title-line">
			<span>Job Card # <?= $jobcard->jobcard_no ?></span>
			<span class="center">JOB CARD</span>
			<span>Date <?= date('d/m/Y', strtotime($jobcard->jobcard_date)) ?></span>
		</div>

		<!-- CUSTOMER / VEHICLE INFO -->
		<table class="data">
			<tr>
				<td width="50%">
					<strong>Name:</strong> <?= $jobcard->customer_name ?><br>
					<strong>Phone:</strong> <?= $jobcard->phone ?><br>
					<strong>Email:</strong> <?= $jobcard->email ?><br>
					<strong>Address:</strong> <?= $jobcard->address ?><br>
					<strong>TRN:</strong> <?= $jobcard->trn ?>
				</td>
				<td width="50%">
					<strong>Vehicle:</strong> <?= $jobcard->brand ?> <?= $jobcard->model ?> (<?= $jobcard->variant ?>)<br>
					<strong>Vin No:</strong> <?= $jobcard->chassis_no ?><br>
					<strong>Plate No:</strong> <?= $jobcard->registration_no ?><br>
					<strong>Colour:</strong> <?= $jobcard->color ?><br>
					<strong>Year:</strong> <?= $jobcard->year ?>
				</td>
			</tr>
		</table>

		<!-- SERVICES -->
		<div class="section-title">Services Performed</div>
		<table class="data">
			<tr>
				<th width="5%">#</th>
				<th>Service</th>
				<th width="30%">Technician</th>
			</tr>
			<?php $i = 1;
			foreach ($services as $s): ?>
				<tr>
					<td class="text-center"><?= $i++ ?></td>
					<td><?= $s->service_name ?></td>
					<td><?= $s->employee_name ?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<!-- PARTS -->
		<div class="section-title">Parts Used</div>
		<table class="data">
			<tr>
				<th width="5%">#</th>
				<th>Part Name</th>
				<th width="15%">Qty</th>
			</tr>
			<?php $i = 1;
			foreach ($parts as $p): ?>
				<tr>
					<td class="text-center"><?= $i++ ?></td>
					<td><?= $p->part_name ?>  ( <?= $p->part_type_label ?>)</td>
					<td class="text-center"><?= $p->qty ?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<!-- SUBLET -->
		<div class="section-title">Sublet Services</div>
		<table class="data">
			<tr>
				<th width="5%">#</th>
				<th>Description</th>
			</tr>
			<?php $i = 1;
			foreach ($job_descriptions as $j): ?>
				<tr>
					<td class="text-center"><?= $i++ ?></td>
					<td><?= $j->description ?></td>
				</tr>
			<?php endforeach; ?>
		</table>

		<div class="page-break"></div>

		<!-- QC CHECKLIST -->
		<div class="section-title text-center">QC DELIVERY CHECK LIST</div>
		<table class="data">
			<tr>
				<th>Check Point</th>
				<th width="10%">Yes</th>
				<th width="10%">No</th>
				<th>Remarks</th>
			</tr>
			<?php
			$qc_points = [
				'Engine Oil',
				'Coolant Water',
				'Windshield Washer Tank',
				'Brake Fluids',
				'Battery Voltage',
				'Wheels – Retighten',
				'Tire Pressure',
				'Body Condition',
				'Wiper Blade',
				'Old Parts',
				'Time / Date',
				'Oil Service Reset',
				'Service Stickers',
				'Floor Mattings',
				'All Lights',
				'Wiper Function',
				'Steering Fluids'
			];
			foreach ($qc_points as $q):
			?>
				<tr>
					<td><?= $q ?></td>
					<td class="text-center"><input type="checkbox"></td>
					<td class="text-center"><input type="checkbox"></td>
					<td class="py-2">
						<div class="border-b h-6"></div>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>

		<br><br>

		<table width="100%">
			<tr>
				<td width="50%">QC / Head Technician: _____________________</td>
				<td width="50%" class="text-right">Technician: _____________________</td>
			</tr>
		</table>

		<p style="margin-top:20px;">Printed By : <?= $username ?></p>

	</div>
</body>

</html>
