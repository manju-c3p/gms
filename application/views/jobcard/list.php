<link rel="stylesheet"
	href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-2xl shadow p-6">

	<div class="flex items-center justify-between mb-4">
		<h2 class="text-2xl font-bold">Job Cards</h2>

		<select id="statusFilter" class="border px-3 py-2 rounded text-sm">
			<option value="Scheduled" selected>Scheduled</option>
			<option value="In Progress">In Progress</option>
			<option value="Finished">Finished</option>
			<option value="">All</option>
		</select>
	</div>



	<div class="overflow-x-auto">
		<table id="jobcardTable"
			class="min-w-full border border-gray-200 text-sm">

			<thead class="bg-gray-100">
				<tr>
					<th class="border px-3 py-2 text-center">#</th>
					<th class="border px-3 py-2">Job Card No</th>
					<th class="border px-3 py-2">Customer</th>
					<th class="border px-3 py-2">Vehicle</th>
					<th class="border px-3 py-2">Technician</th>
					<th class="border px-3 py-2 text-center">Status</th>
					<th class="border px-3 py-2 text-center">Spare Parts</th>
					<th class="border px-3 py-2 text-center">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($jobcards)): ?>
					<?php $sl = 1;
					foreach ($jobcards as $jc):
						if ($jc->status !== 'Draft'):
					?>
							<tr class="hover:bg-gray-50">

								<!-- SL -->
								<td class="border px-3 py-2 text-center font-medium">
									<?= $sl++ ?>
								</td>

								<!-- Jobcard -->
								<td class="border px-3 py-2 font-medium">
									<?= $jc->jobcard_no ?><br>
									<span class="text-xs text-gray-500">
										<?= date('d-m-Y', strtotime($jc->jobcard_date)) ?>
									</span>
								</td>

								<!-- Customer -->
								<td class="border px-3 py-2">
									<?= $jc->customer_name ?>
								</td>

								<!-- Vehicle -->
								<td class="border px-3 py-2">
									<div class="font-medium"><?= $jc->registration_no ?></div>
									<div class="text-xs text-gray-500">
										<?= $jc->brand ?> <?= $jc->model ?>
									</div>
								</td>

								<!-- Technician -->
								<td class="border px-3 py-2">
									<!-- <?= $jc->technician_name ?? '—' ?> -->

									<?= $jc->service_technicians ?: '-' ?>
								</td>

								<!-- Status -->
								<td class="border px-3 py-2 text-center">
									<?php if ($jc->status == 'Scheduled'): ?>
										<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
											Scheduled
										</span>
									<?php elseif ($jc->status == 'In Progress'): ?>
										<span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
											In Progress
										</span>
									<?php else: ?>
										<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
											Finished
										</span>
									<?php endif; ?>
								</td>

								<!-- Material Issue -->
								<td class="border px-3 py-2 text-center">

									<?php if ((int)$jc->total_parts === 0): ?>

										<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
											No Spare Parts
										</span>

									<?php elseif ((int)$jc->fully_issued_parts === 0): ?>

										<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
											Not Issued
										</span>
										<br>
										<a href="<?= base_url('index.php/MaterialIssue/create/' . $jc->jobcard_id); ?>"
											class="mt-1 inline-block px-3 py-1 text-xs bg-indigo-600 text-white rounded">
											Issue Spareparts
										</a>

									<?php elseif ((int)$jc->fully_issued_parts < (int)$jc->total_parts): ?>

										<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
											Partially Issued (<?= $jc->fully_issued_parts ?>)
										</span>
										<br>
										<a href="<?= base_url('index.php/MaterialIssue/create/' . $jc->jobcard_id); ?>"
											class="mt-1 inline-block px-3 py-1 text-xs bg-indigo-600 text-white rounded">
											Issue More
										</a>

									<?php else: ?>

										<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
											Fully Issued
										</span>
										<br>
										<a href="<?= base_url('index.php/MaterialIssue/create/' . $jc->jobcard_id); ?>"
											class="mt-1 inline-block px-3 py-1 text-xs bg-blue-600 text-white rounded">
											View Issues
										</a>

									<?php endif; ?>

									<br>

									<a href="<?= base_url('index.php/Jobcard/timesheet/' . $jc->jobcard_id); ?>"
										class="mt-1 inline-block px-3 py-1 text-xs bg-blue-300 text-white rounded">
										Time Sheet
									</a>

								</td>





								<!-- Actions -->
								<td class="border px-3 py-2 text-center">
									<div class="flex flex-col items-center gap-2">

										<a href="<?= base_url('index.php/Jobcard/view/' . $jc->jobcard_id); ?>"
											class="w-20 text-center px-2 py-1 bg-blue-100 text-blue-700 rounded">
											View
										</a>

										<a href="<?= base_url('index.php/Jobcard/edit/' . $jc->jobcard_id); ?>"
											class="w-20 text-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
											Edit
										</a>

										<a href="<?= base_url('index.php/Jobcard/delete/' . $jc->jobcard_id); ?>"
											onclick="return confirm('Delete this job card?');"
											class="w-20 text-center px-2 py-1 bg-red-100 text-red-700 rounded">
											Delete
										</a>

									</div>
								</td>

							</tr>
					<?php endif;
					endforeach; ?>
				<?php else: ?>
					<!-- <tr>
						<td colspan="8"
							class="border px-3 py-6 text-center text-gray-500">
							No job cards found
						</td>
					</tr> -->
				<?php endif; ?>
			</tbody>
		</table>
	</div>

</div>
<script>
	$(document).ready(function() {

		var table = $('#jobcardTable').DataTable({
			pageLength: 10,
			language: {
				emptyTable: "No Jobcard found"
			},
			order: [
				[0, 'asc']
			],
			columnDefs: [{
				orderable: false,
				targets: [0, 6, 7]
			}]
		});

		// ✅ Custom filter by Status (column index = 5)
		$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
			var selected = $('#statusFilter').val();
			var status = data[5]; // Status column

			if (selected === "" || status.includes(selected)) {
				return true;
			}
			return false;
		});

		// ✅ Trigger filter on change
		$('#statusFilter').on('change', function() {
			table.draw();
		});

		// ✅ Default filter = Scheduled
		table.draw();
	});
</script>
