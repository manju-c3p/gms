<?php

?>
<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<!-- ================= HEADER ================= -->
	<div class="bg-white rounded-2xl shadow p-6">

		<!-- Title -->
		<h2 class="text-xl sm:text-2xl font-bold mb-4 flex items-center gap-2
	           justify-center md:justify-start text-center md:text-left">
			🕒 Technician Time Sheet
		</h2>

		<!-- Info grid -->
		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm">

			<div>
				<p class="text-gray-500">Job Card No</p>
				<p class="font-semibold break-all">
					<?= $jobcard->jobcard_no ?>
				</p>
			</div>

			<div>
				<p class="text-gray-500">Customer</p>
				<p class="font-semibold">
					<?= $jobcard->name ?>
				</p>
			</div>

			<div>
				<p class="text-gray-500">Vehicle</p>
				<p class="font-semibold">
					<?= $jobcard->registration_no ?>
				</p>
			</div>

			<div>
				<p class="text-gray-500">Status</p>
				<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
			             bg-blue-100 text-blue-700">
					<?= $jobcard->status ?? 'Scheduled' ?>
				</span>
			</div>

		</div>
	</div>


	<!-- ================= TABLE ================= -->
	<div class="bg-white rounded-2xl shadow p-6 overflow-x-auto">
		<table class="w-full text-sm min-w-[1000px]">

			<thead>
				<tr class="border-b bg-gray-50">
					<th class="px-3 py-2 text-left">#</th>
					<th class="px-3 py-2 text-left">Job Description</th>
					<th class="px-3 py-2 text-left">Technician</th>
					<th class="px-3 py-2 text-center">Current Status</th>
					<th class="px-3 py-2 text-center">Start Time</th>
					<th class="px-3 py-2 text-center">Pause Time</th>
					<th class="px-3 py-2 text-center">Stop Time</th>
					<th class="px-3 py-2 text-center">Actions</th>
				</tr>
			</thead>

			<tbody class="divide-y">
				<?php $i = 1;
				foreach ($descriptions as $d):
					$times = $timeMap[$d->jobcard_service_id] ?? [
						'START' => null,
						'PAUSE' => null,
						'STOP' => null
					];
					$hasStarted = isset($timeMap[$d->jobcard_service_id]['START']);

				?>

					<tr>
						<td class="px-3 py-3"><?= $i++ ?></td>

						<td class="px-3 py-3">
							<?= $d->service_name ?>
						</td>

						<td class="px-3 py-3 font-medium">
							<?= $d->employee_name ?>
						</td>

						<td class="px-3 py-3 text-center">
							<?php
							$currentStatus = $statusMap[$d->jobcard_service_id] ?? 'IDLE';
							$isStopped = ($currentStatus === 'STOP');
							$badgeClass = 'bg-gray-100 text-gray-700';

							if ($currentStatus === 'START')
								$badgeClass = 'bg-green-100 text-green-700';
							elseif ($currentStatus === 'PAUSE')
								$badgeClass = 'bg-yellow-100 text-yellow-700';
							elseif ($currentStatus === 'STOP')
								$badgeClass = 'bg-red-100 text-red-700';
							?>

							<span id="status-<?= $d->jobcard_service_id ?>"
								class="px-3 py-1 rounded-full text-xs font-semibold <?= $badgeClass ?>">
								<?= $currentStatus ?>
							</span>




						</td>

						<td class="px-3 py-3 text-center">
							<?= $times['START'] ? date('H:i:s', strtotime($times['START'])) : '-' ?>
						</td>

						<td class="px-3 py-3 text-center">
							<?= $times['PAUSE'] ? date('H:i:s', strtotime($times['PAUSE'])) : '-' ?>
						</td>

						<td class="px-3 py-3 text-center">
							<?= $times['STOP'] ? date('H:i:s', strtotime($times['STOP'])) : '-' ?>
						</td>
						<td class="px-3 py-3 text-center">
							<div class="flex flex-col sm:flex-row gap-2 justify-center">


								<!-- START (ONLY ONCE) -->
								<button
									onclick="logTime(<?= $d->jobcard_service_id ?>, <?= $d->employee_id ?>, 'START', <?= $jobcard->jobcard_id ?>)"
									<?= $hasStarted ? 'disabled' : '' ?>
									class="px-3 py-1 rounded bg-green-600 text-white <?= $hasStarted ? 'opacity-50 cursor-not-allowed' : '' ?>">
									Start
								</button>

								<!-- PAUSE / RESUME TOGGLE -->
								<?php if ($currentStatus === 'START' || $currentStatus === 'RESUME'): ?>
									<button
										onclick="logTime(<?= $d->jobcard_service_id ?>, <?= $d->employee_id ?>, 'PAUSE', <?= $jobcard->jobcard_id ?>)"
										class="px-3 py-1 rounded bg-yellow-500 text-white">
										Pause
									</button>

								<?php elseif ($currentStatus === 'PAUSE'): ?>
									<button
										onclick="logTime(<?= $d->jobcard_service_id ?>, <?= $d->employee_id ?>, 'RESUME', <?= $jobcard->jobcard_id ?>)"
										class="px-3 py-1 rounded bg-blue-500 text-white">
										Resume
									</button>
								<?php endif; ?>

								<!-- STOP -->
								<!-- STOP (ONLY ONCE) -->
								<button
									onclick="logTime(<?= $d->jobcard_service_id ?>, <?= $d->employee_id ?>, 'STOP', <?= $jobcard->jobcard_id ?>)"
									<?= $isStopped ? 'disabled' : '' ?> class="px-3 py-1 rounded bg-red-600 text-white <?= $isStopped ? 'opacity-50 cursor-not-allowed' : '' ?>">
									Stop
								</button>

							</div>
						</td>



					<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>

<!-- ================= JS ================= -->
<!-- <script>
	function logTime(descriptionId, employeeId, status, jobcard_id) {

		console.log("logTime() called with:");
		console.log({
			descriptionId: descriptionId,
			employeeId: employeeId,
			status: status,
			jobcard_id: jobcard_id
		});

		const payload =
			"jobcard_id=" + encodeURIComponent(jobcard_id) +
			"&description_id=" + encodeURIComponent(descriptionId) +
			"&employee_id=" + encodeURIComponent(employeeId) +
			"&status=" + encodeURIComponent(status);

		console.log("Payload being sent:", payload);

		fetch("<?= base_url('index.php/jobcard/log_work_time') ?>", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "jobcard_id=" + jobcard_id +
					"&description_id=" + descriptionId +
					"&employee_id=" + employeeId +
					"&status=" + status
			})
			.then(res => res.json())
			.then(data => {
				const badge = document.getElementById('status-' + descriptionId);

				badge.textContent = status;
				badge.className = "px-3 py-1 rounded-full text-xs font-semibold";

				if (status === 'START')
					badge.classList.add('bg-green-100', 'text-green-700');
				if (status === 'PAUSE')
					badge.classList.add('bg-yellow-100', 'text-yellow-700');
				if (status === 'STOP')
					badge.classList.add('bg-red-100', 'text-red-700');
			});
	}
</script> -->

<script>
	function logTime(descriptionId, employeeId, status, jobcard_id) {

		fetch("<?= base_url('index.php/Jobcard/log_work_time') ?>", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: "jobcard_id=" + encodeURIComponent(jobcard_id) +
					"&description_id=" + encodeURIComponent(descriptionId) +
					"&employee_id=" + encodeURIComponent(employeeId) +
					"&status=" + encodeURIComponent(status)
			})
			.then(res => res.json())
			.then(data => {
				if (data.status === 'success') {
					// ✅ Reload page to reflect updated DB state
					location.reload();
				}
			})
			.catch(err => {
				console.error("Error logging time:", err);
			});
	}
</script>
