<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="bg-white rounded-2xl shadow p-6">

	<div class="flex items-center justify-between mb-4">
		<h2 class="text-2xl font-bold">Inspections</h2>

		<a href="<?= base_url('index.php/inspection/add'); ?>"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ New Inspection
		</a>
	</div>

	<div class="overflow-x-auto">
		<table class="min-w-full border border-gray-200 text-sm" id="inspectionTable">
			<thead class="bg-gray-100">
				<tr>
					<th class="border px-3 py-2 text-center">#</th>
					<th class="border px-3 py-2">Date</th>
					<th class="border px-3 py-2">Customer</th>
					<th class="border px-3 py-2">Vehicle</th>
					<th class="border px-3 py-2 text-center">KM</th>
					<th class="border px-3 py-2 text-center">Fuel</th>
					<th class="border px-3 py-2 text-center">Status</th>
					<th class="border px-3 py-2 text-center">Estimation</th>
					<th class="border px-3 py-2 text-center">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($inspections)): ?>
					<?php $sl = 1;
					foreach ($inspections as $i): ?>
						<tr class="hover:bg-gray-50">

							<!-- SL NO -->
							<td class="border px-3 py-2 text-center font-medium">
								<?= $sl++ ?>
							</td>

							<!-- Date -->
							<td class="border px-3 py-2">
								<?= date('d-m-Y', strtotime($i->inspection_date)) ?>
							</td>

							<!-- Customer -->
							<td class="border px-3 py-2">
								<div class="font-medium"><?= $i->customer_name ?></div>
								<div class="text-xs text-gray-500"><?= $i->customer_phone ?></div>
							</td>

							<!-- Vehicle -->
							<td class="border px-3 py-2">
								<div class="font-medium"><?= $i->registration_no ?></div>
								<div class="text-xs text-gray-500">
									<?= $i->brand ?> <?= $i->model ?>
								</div>
							</td>

							<!-- KM -->
							<td class="border px-3 py-2 text-center">
								<?= number_format($i->km_reading) ?>
							</td>

							<!-- Fuel -->
							<td class="border px-3 py-2 text-center">
								<?= $i->fuel_level ?>
							</td>

							<!-- Status -->
							<td class="border px-3 py-2 text-center">
								<?php if ($i->status == 'Draft'): ?>
									<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">Draft</span>
								<?php elseif ($i->status == 'Completed'): ?>
									<span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">Completed</span>
								<?php else: ?>
									<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">Approved</span>
								<?php endif; ?>
							</td>

							<!-- Estimation -->
							<td class="border px-3 py-2 text-center">
								<?php if ($i->status == 'Completed'): ?>
									<a href="<?= base_url('index.php/estimation/create/' . $i->inspection_id); ?>"
										class="px-3 py-1 text-xs bg-indigo-600 text-white rounded">
										Create
									</a>
								<?php else: ?>
									<span class="px-3 py-1 text-xs bg-gray-200 text-gray-500 rounded">
										Not Allowed
									</span>
								<?php endif; ?>
							</td>

							<!-- Actions -->
							<td class="border px-3 py-2 text-center space-x-1">
								<a href="<?= base_url('index.php/inspection/edit/' . $i->inspection_id); ?>"
									class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
									Edit
								</a>
								<a href="<?= base_url('index.php/inspection/delete/' . $i->inspection_id); ?>"
									onclick="return confirm('Are you sure?');"
									class="px-2 py-1 bg-red-100 text-red-700 rounded">
									Delete
								</a>
							</td>

						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="9" class="border px-3 py-6 text-center text-gray-500">
							No inspections found
						</td>
					</tr>
				<?php endif; ?>
			</tbody>

		</table>
	</div>

</div>

<script>
$(document).ready(function () {
    $('#inspectionTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[1, 'desc']], // Order by Date
        columnDefs: [
            { orderable: false, targets: [0, 7, 8] } // SL, Estimation, Actions
        ]
    });
});
</script>

