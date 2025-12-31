<div class="w-full bg-white rounded-2xl shadow-md p-8">

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

	<!-- Service Table -->
	<h3 class="text-xl font-bold mb-2">Services Performed</h3>
	<table class="w-full border rounded mb-6">
		<thead class="bg-gray-200">
			<tr>
				<th class="p-3">Service</th>
				<th class="p-3">Cost</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$service_total = 0;
			foreach ($services as $s):
				$service_total += $s->amount;
			?>
				<tr class="border-b">
					<td class="p-3"><?= $s->service_name ?></td>
					<td class="p-3">₹<?= number_format($s->amount, 2) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Parts Table -->
	<h3 class="text-xl font-bold mb-2">Parts Used</h3>
	<table class="w-full border rounded mb-6">
		<thead class="bg-gray-200">
			<tr>
				<th class="p-3">Part</th>
				<th class="p-3">Qty</th>
				
			</tr>
		</thead>
		<tbody>
			<?php
			$parts_total = 0;
			foreach ($parts as $p):
				
			?>
				<tr class="border-b">
					<td class="p-3"><?= $p->part_name ?></td>
					<td class="p-3"><?= $p->qty ?></td>
				
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<!-- Totals -->
	

	<!-- Remarks -->
	<h3 class="text-xl font-bold mt-6">Remarks</h3>
	<p class="border p-3 rounded bg-gray-50"><?= nl2br($jobcard->remarks) ?></p>

</div>

<style>
	@media print {
		.print\:hidden {
			display: none !important;
		}

		button,
		.print\:hidden {
			display: none !important;
		}

		body {
			background: white;
		}

		div {
			box-shadow: none !important;
		}
	}
</style>
