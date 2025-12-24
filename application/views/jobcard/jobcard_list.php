<!-- DATATABLE CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DATATABLE JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<div class="flex justify-between items-center mb-6">
		<h2 class="text-2xl font-bold">Job Card List</h2>

		<a href="<?= base_url('index.php/jobcard/add'); ?>"
			class="px-4 py-2 bg-green-600 hover:bg-green-700 transition text-white rounded-lg shadow">
			+ Create Job Card
		</a>
	</div>

	<table id="jobcardTable"
		class="stripe hover cell-border order-column w-full text-sm display">
		<thead class="bg-gray-100 text-gray-700 text-sm">
			<tr>
				<th>SL</th>
				<th>Job Card No</th>
				<th>Date</th>
				<th>Customer</th>
				<th>Vehicle</th>
				<th>Technician</th>
				<th>Status</th>
				<th>Status Updation</th>

				<th class="text-center">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php $sl = 1;
			foreach ($jobcards as $jc): ?>
				<tr class="hover:bg-gray-50">
					<td><?= $sl++ ?></td>
					<td class="font-semibold"><?= $jc->jobcard_id ?></td>
					<td><?= date('d-m-Y', strtotime($jc->jobcard_date)) ?></td>

					<td>
						<span class="font-medium"><?= $jc->customer_name ?></span><br>
						<span class="text-gray-500 text-xs"><?= $jc->phone ?></span>
					</td>

					<td>
						<span class="font-medium"><?= $jc->registration_no ?></span><br>
						<span class="text-gray-500 text-xs"><?= $jc->brand ?> <?= $jc->model ?></span>
					</td>

					<td><?= $jc->technician ?></td>

					<td class="p-2 text-center">
						<?php if ($jc->status == 'Pending'): ?>
							<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Pending</span>
						<?php elseif ($jc->status == 'In-Progress'): ?>
							<span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">In-Progress</span>
						<?php else: ?>
							<span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Completed</span>
						<?php endif; ?>
					</td>
					<!-- STATUS BUTTONS -->
					<td class="text-center">
						<div class="flex justify-center gap-2">
						<a href="<?= base_url('index.php/jobcard/update_status/' . $jc->jobcard_id . '/Pending'); ?>"
							class="p-2 bg-yellow-500 text-white text-xs rounded " style="padding-bottom: 4px;">
							Pending
						</a>

						<a href="<?= base_url('index.php/jobcard/update_status/' . $jc->jobcard_id . '/In-Progress'); ?>"
							class="p-2 bg-blue-500 text-white text-xs rounded"  style="padding-bottom: 4px;">
							In-Progress
						</a>

						<a href="<?= base_url('index.php/jobcard/update_status/' . $jc->jobcard_id . '/Completed'); ?>"
							class="p-2 bg-green-500 text-white text-xs rounded">
							Completed
						</a>
						</div>
					</td>



					<td class="text-center">
						<div class="flex justify-center gap-2">

							<!-- View -->
							<a href="<?= base_url('index.php/jobcard/view/' . $jc->jobcard_id); ?>"
								class="p-2 bg-blue-100 hover:bg-blue-200 rounded-lg"
								title="View">
								👁️
							</a>

							<!-- Edit -->
							<a href="<?= base_url('index.php/jobcard/edit/' . $jc->jobcard_id); ?>"
								class="p-2 bg-yellow-100 hover:bg-yellow-200 rounded-lg"
								title="Edit">
								✏️
							</a>

							<!-- Delete -->
							<a onclick="return confirm('Delete this Job Card?');"
								href="<?= base_url('index.php/jobcard/delete/' . $jc->jobcard_id); ?>"
								class="p-2 bg-red-100 hover:bg-red-200 rounded-lg"
								title="Delete">
								🗑️
							</a>

						</div>
					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<!-- DATATABLE -->
<script>
	$(document).ready(function() {
		$('#jobcardTable').DataTable({
			pageLength: 10,
			responsive: true,
			order: [
				[1, "desc"]
			],
			autoWidth: false
		});
	});
</script>
