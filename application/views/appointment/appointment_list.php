<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<div class="flex justify-between items-center mb-4">

		<h2 class="text-2xl font-bold">Appointment List</h2>

		<div class="flex gap-4 text-xs mb-3 mt-5">
			<h4 class="font-bold">WorkFlow Status</h4>
			<span class="flex items-center gap-1 text-gray-500">⬜ Not Started</span>
			<span class="flex items-center gap-1 text-yellow-600">🟨 In Progress</span>
			<span class="flex items-center gap-1 text-green-600">🟩 Completed</span>
		</div>

		<a href="<?= base_url('index.php/appointment/add'); ?>"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ Add Appointment
		</a>
	</div>

	<!-- DataTable -->
	<table id="appointmentTable"
		class="w-full border rounded text-sm">

		<thead class="bg-gray-200">
			<tr>
				<th class="p-3 text-center">SL</th>
				<th class="p-3 text-center">Customer & Vehicle No</th>

				<th class="p-3 text-center">Date & Time</th>

				<th class="p-3 text-center">Service Type</th>

				<th class="p-3 text-center">Workflow</th>
				<!-- <th class="p-3 text-center">Status</th> -->
				<th class="p-3 text-center">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php $i = 1;
			foreach ($appointments as $a): ?>
				<tr class="border-b hover:bg-gray-50">

					<td class="p-3"><?= $i++; ?></td>

					<td class="p-3 font-medium"><?= $a->customer_name ?><br><?= $a->registration_no ?></td>



					<td class="p-3"><?= $a->appointment_date ?><br><?= $a->appointment_time ?></td>



					<td class="p-3"><?= $a->service_type ?></td>



					<td class="p-3 text-center">
						<div class="flex items-center justify-center gap-2">

							<!-- INSPECTION -->
							<!-- <a href="<?= base_url('index.php/inspection/create/' . $a->appointment_id); ?>"
								title="Inspection"
								class="px-3 py-1 text-xs rounded-full flex items-center gap-1
								 <?= $a->inspection_id ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600 hover:bg-blue-100' ?>">
								🧾 <span>Inspection</span>
							</a> -->

							<a href="<?= base_url('index.php/inspection/create/' . $a->appointment_id); ?>"
								title="<?=
										!$a->inspection_id ? 'Create Inspection'
											: 'Inspection Status: ' . $a->inspection_status
										?>"

								class="px-3 py-1 text-xs rounded-full flex items-center gap-1
								<?php
								if (!$a->inspection_id) {
									echo 'bg-gray-200 text-gray-600 hover:bg-blue-100';
								} elseif ($a->inspection_status === 'Draft') {
									echo 'bg-yellow-100 text-yellow-700';
								} elseif ($a->inspection_status === 'Completed') {
									echo 'bg-green-100 text-green-700';
								} elseif ($a->inspection_status === 'Approved') {
									echo 'bg-blue-100 text-blue-700';
								}
								?>">
								🧾 <span>Inspection</span>
							</a>


							<!-- ESTIMATION -->
							<?php if ($a->inspection_id): ?>

								<a href="<?= base_url('index.php/estimation/create/' . $a->appointment_id); ?>"
									title="<?=
											!$a->estimation_id
												? 'Create Estimation'
												: 'Estimation Status: ' . $a->estimation_status
											?>"

									class="px-3 py-1 text-xs rounded-full flex items-center gap-1
										<?php
										if (!$a->estimation_id) {
											// Inspection done but estimation not created
											echo 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200';
										} elseif ($a->estimation_status === 'Draft') {
											echo 'bg-yellow-100 text-yellow-700';
										} elseif ($a->estimation_status === 'Approved') {
											echo 'bg-green-100 text-green-700';
										} elseif ($a->estimation_status === 'Converted') {
											echo 'bg-blue-100 text-blue-700';
										} elseif ($a->estimation_status === 'Rejected') {
											echo 'bg-red-100 text-red-700';
										}
										?>">
									💰 <span>Estimate</span>
								</a>

							<?php else: ?>

								<span title="Complete Inspection first"
									class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-400 cursor-not-allowed flex items-center gap-1">
									💰 <span>Estimate</span>
								</span>

							<?php endif; ?>


							<!-- JOBCARD -->
							<!-- JOBCARD -->
							<?php if ($a->estimation_id): ?>
								<?php
								// Title text
								if (!$a->jobcard_id) {
									$jobcardTitle = 'Create Job Card';
								} elseif ($a->jobcard_status === 'Pending') {
									$jobcardTitle = 'Job Card Pending';
								} elseif ($a->jobcard_status === 'In Progress') {
									$jobcardTitle = 'Job Card In Progress';
								} elseif ($a->jobcard_status === 'Completed') {
									$jobcardTitle = 'Job Card Completed';
								}

								// CSS class
								if (!$a->jobcard_id) {
									$jobcardClass = 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200';
								} elseif ($a->jobcard_status === 'Pending') {
									$jobcardClass = 'bg-yellow-100 text-yellow-700';
								} elseif ($a->jobcard_status === 'In Progress') {
									$jobcardClass = 'bg-blue-100 text-blue-700';
								} elseif ($a->jobcard_status === 'Completed') {
									$jobcardClass = 'bg-green-100 text-green-700';
								}
								?>

								<a href="<?= base_url('index.php/jobcard/create/' . $a->appointment_id); ?>"
									title="<?= $jobcardTitle ?>"
									class="px-3 py-1 text-xs rounded-full flex items-center gap-1
       								<?php
										if (!$a->jobcard_id) {
											// Estimation exists but job card not created
											echo 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200';
										} elseif ($a->jobcard_status === 'Pending') {
											echo 'bg-yellow-100 text-yellow-700';
										} elseif ($a->jobcard_status === 'In Progress') {
											echo 'bg-blue-100 text-blue-700';
										} elseif ($a->jobcard_status === 'Completed') {
											echo 'bg-green-100 text-green-700';
										}
										?>">
									🛠️ <span>Job Card</span>
								</a>

							<?php else: ?>

								<span title="Complete Estimation first"
									class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-400 cursor-not-allowed flex items-center gap-1">
									🛠️ <span>Job Card</span>
								</span>

							<?php endif; ?>

						</div>
					</td>
					<!-- <td class="p-3">
						<span class="px-2 py-1 rounded text-white text-xs
                            <?= $a->status == 'Pending' ? 'bg-yellow-500' : '' ?>
                            <?= $a->status == 'Confirmed' ? 'bg-blue-600' : '' ?>
                            <?= $a->status == 'Completed' ? 'bg-green-600' : '' ?>
                            <?= $a->status == 'Cancelled' ? 'bg-red-600' : '' ?>
                        ">
							<?= $a->status ?>
						</span>
					</td> -->

					<td class="p-3 text-center flex justify-center gap-3">



						<!-- Edit -->
						<a href="<?= base_url('index.php/appointment/edit/' . $a->appointment_id); ?>"
							class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
							title="Edit">
							✏️
						</a>

						<!-- Delete -->
						<a onclick="return confirm('Delete this appointment?');"
							href="<?= base_url('index.php/appointment/delete/' . $a->appointment_id); ?>"
							class="p-2 rounded bg-red-100 hover:bg-red-200"
							title="Delete">
							🗑️
						</a>

					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>



<script>
	$(document).ready(function() {



		$('#appointmentTable').DataTable({
			pageLength: 10,
			lengthMenu: [
				[5, 10, 25, -1],
				[5, 10, 25, "All"]
			],
			responsive: true,

			// Move search box to the RIGHT
			dom: "<'flex justify-between items-center mb-3'l<f>>" +
				"t" +
				"<'flex justify-between items-center mt-3'p>",

			language: {
				search: "",
				searchPlaceholder: "Search Appointments..."
			}
		});
	});
</script>
