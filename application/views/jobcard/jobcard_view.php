<!-- ================= JOB CARD PAGE ================= -->
<div class="jobcard-page w-full bg-white rounded-2xl shadow-md p-8">

	<!-- Header -->
	<div class="flex justify-between items-center mb-6 print:hidden">
		<h2 class="text-2xl font-bold">Job Card #<?= $jobcard->jobcard_id ?></h2>
		<div>
			<button onclick="window.print()"
				class="px-4 py-2 bg-blue-600 text-white rounded">
				🖨 Print
			</button>

			<a href="<?= base_url('index.php/jobcard/pdf/' . $jobcard->jobcard_id); ?>"
				class="px-4 py-2 bg-green-600 text-white rounded">
				Download PDF
			</a>
		</div>
	</div>

	<!-- Job Card Info -->
	<div class="grid grid-cols-2 gap-6 border p-5 bg-gray-50 rounded-xl mb-6">

		<div>
			<h3 class="text-lg font-bold mb-1">Customer Details</h3>
			<p><strong>Name:</strong> <?= $jobcard->customer_name ?></p>
			<p><strong>Phone:</strong> <?= $jobcard->phone ?></p>
			<p><strong>Email:</strong> <?= $jobcard->email ?></p>
		</div>

		<div>
			<h3 class="text-lg font-bold mb-1">Vehicle Details</h3>
			<p><strong>Reg No:</strong> <?= $jobcard->registration_no ?></p>
			<p><strong>Model:</strong> <?= $jobcard->brand ?> <?= $jobcard->model ?> (<?= $jobcard->variant ?>)</p>
			<p><strong>Year:</strong> <?= $jobcard->year ?></p>
		</div>

		<div>
			<h3 class="text-lg font-bold mb-1">Job Card Details</h3>
			<p><strong>Date:</strong> <?= $jobcard->jobcard_date ?></p>
		</div>

		<div>
			<h3 class="text-lg font-bold mb-1">Appointment Info</h3>
			<p><strong>Appointment Date:</strong> <?= $jobcard->appointment_date ?></p>
		</div>

	</div>

	<!-- Services -->
	<h3 class="text-xl font-bold mb-2">Services Performed</h3>
	<table class="w-full border rounded mb-6">
		<thead class="bg-gray-200">
			<tr>
				<th class="p-3">Service</th>
				<th class="p-3">Technician</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($job_descriptions as $s): ?>
				<tr class="border-b">
					<td class="p-3"><?= $s->description ?></td>
					<td class="p-3"><?= $s->employee_name ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Parts -->
	<h3 class="text-xl font-bold mb-2">Parts Used</h3>
	<table class="w-full border rounded mb-6">
		<thead class="bg-gray-200">
			<tr>
				<th class="p-3">Part</th>
				<th class="p-3">Qty</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($parts as $p): ?>
				<tr class="border-b">
					<td class="p-3"><?= $p->part_name ?></td>
					<td class="p-3"><?= $p->qty ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Remarks -->
	<h3 class="text-xl font-bold mt-6">Remarks</h3>
	<p class="border p-3 rounded bg-gray-50"></p>

</div>
<div class="page-break"></div>
<!-- ================= QC DELIVERY CHECKLIST ================= -->
<div class="qc-page w-full bg-white p-10">

	<div class="text-center mb-6">
		<h2 class="text-2xl font-bold uppercase">QC Delivery Check List</h2>
	</div>

	<table class="w-full border-collapse">
		<thead>
			<tr class="border-b">
				<th class="text-left py-2">Check Point</th>
				<th class="text-center py-2 w-20">Yes</th>
				<th class="text-center py-2 w-20">No</th>
				<th class="text-left py-2">Remarks</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$qc_points = [
				'Engine Oil','Coolant Water','Windshield Washer Tank','Brake Fluids',
				'Battery Voltage','Wheels – Retighten','Tire Pressure','Body Condition',
				'Wiper Blade','Old Parts','Time / Date','Oil Service Reset',
				'Service Stickers','Floor Mattings','All Lights',
				'Wiper Function','Steering Fluids'
			];
			foreach ($qc_points as $point):
			?>
				<tr class="border-b">
					<td class="py-2"><?= $point ?></td>
					<td class="text-center"><input type="checkbox"></td>
					<td class="text-center"><input type="checkbox"></td>
					<td class="py-2"><div class="border-b h-6"></div></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="flex justify-between mt-16">
		<div class="text-center w-1/3">
			<div class="border-t"></div>
			<p class="mt-2 text-sm">QC / Head Technician</p>
		</div>
		<div class="text-center w-1/3">
			<div class="border-t"></div>
			<p class="mt-2 text-sm">Technician</p>
		</div>
	</div>

</div>
<style>
@media print {

	/* hide UI */
	.print\:hidden, button, .topbar {
		display: none !important;
	}

	/* 🔥 VERY IMPORTANT: remove overflow */
	html, body, * {
		height: auto !important;
		overflow: visible !important;
		max-height: none !important;
	}

	body {
		background: white;
	}

	div {
		box-shadow: none !important;
	}

	/* single page break */
	.page-break {
		page-break-before: always;
		break-before: page;
	}

	table {
		page-break-inside: avoid;
	}

	input[type="checkbox"] {
		transform: scale(1.2);
	}
}
</style>
