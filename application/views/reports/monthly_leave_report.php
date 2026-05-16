<?php if (!isset($is_generated)) $is_generated = false; ?>

<?php
$status_labels = [
	0 => 'Pending',
	1 => 'Approved',
	2 => 'Rejected'
];
?>

<div class="bg-white shadow rounded-xl p-6">

	<div>


		<!-- Filter Form -->
		<form id="main" method="post" action="<?= base_url('index.php/Reports/monthly_leave_report') ?>">

			<div class="flex flex-wrap items-end gap-4 mb-4">

				<!-- Month -->
				<div class="w-full md:w-64">
					<label class="block text-sm font-medium mb-1">Month</label>
					<input type="month"
						name="month"
						required
						value="<?= isset($selected_month) ? $selected_month : '' ?>"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200">
				</div>

				<!-- Department -->
				<div class="w-full md:w-64">
					<label class="block text-sm font-medium mb-1">Department</label>
					<select name="department_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm select2">
						<option value="">All</option>
						<?php foreach ($departments as $dept): ?>
							<option value="<?= $dept->department_id  ?>" <?= ($selected_dept == $dept->department_id ) ? 'selected' : '' ?>>
								<?= htmlspecialchars($dept->department_name) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<!-- Buttons -->
				<div class="flex-1 flex justify-end items-center gap-2">
					<button type="submit"
						name="action"
						value="Go"
						class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg shadow">
						Generate
					</button>

					<!-- <button type="button"
						id="printBtn"
						class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded-lg shadow">
						Print
					</button>

					<button type="button"
						id="exportBtn"
						class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg shadow">
						Export to Excel
					</button> -->
				</div>

			</div>

			<input type="hidden" name="is_generated" value="<?= $is_generated ? '1' : '' ?>">

		</form>

		<!-- Data Table -->
		<div class="overflow-x-auto">
			<table id="datatable" class="min-w-full border border-gray-200 text-sm text-left">
				<thead class="bg-blue-50 text-blue-900">
					<tr>
						<th class="border px-3 py-2">Sr. No</th>
						<!-- <th class="border px-3 py-2">Emp Code</th> -->
						<th class="border px-3 py-2">Employee Name</th>
						<th class="border px-3 py-2">Department</th>
						<th class="border px-3 py-2">Designation</th>
						<th class="border px-3 py-2">Leave Type</th>
						<th class="border px-3 py-2">From</th>
						<th class="border px-3 py-2">To</th>
						<th class="border px-3 py-2">Status</th>
					</tr>
				</thead>

				<tbody class="divide-y divide-gray-100">
					<?php if (!empty($records)): ?>
						<?php $i = 1;
						foreach ($records as $r): ?>
							<tr class="hover:bg-gray-50">
								<td class="border px-3 py-2"><?= $i++ ?></td>
								<!-- <td class="border px-3 py-2"><?= htmlspecialchars($r->employee_code ?? '-') ?></td> -->
								<td class="border px-3 py-2"><?= htmlspecialchars($r->employee_name ?? '-') ?></td>
								<td class="border px-3 py-2"><?= htmlspecialchars($r->department_name ?? '-') ?></td>
								<td class="border px-3 py-2"><?= htmlspecialchars($r->designation_name ?? '-') ?></td>
								<td class="border px-3 py-2"><?= htmlspecialchars($r->leave_type ?? '-') ?></td>
								<td class="border px-3 py-2"><?= !empty($r->start_date) ? date('d-M-Y', strtotime($r->start_date)) : '-' ?></td>
								<td class="border px-3 py-2"><?= !empty($r->end_date) ? date('d-M-Y', strtotime($r->end_date)) : '-' ?></td>
								<td class="border px-3 py-2"><?= $status_labels[$r->leave_status] ?? 'Pending' ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>

			</table>
		</div>


	</div>

</div>


<script>
	$(document).ready(function() {
		$('.select2').select2();

		const table = $('#datatable');

		// Always initialize DataTable
		if (!$.fn.DataTable.isDataTable('#datatable')) {
			table.DataTable({
				responsive: true,
				language: {
					emptyTable: "No leave records found."
				}
			});
		}

		$('#printBtn').on('click', function() {
			const form = document.getElementById('main');
			form.action = '<?= base_url('index.php/Reports/print_monthly_leave_report') ?>';
			form.target = '_blank';
			form.submit();
			form.action = '<?= base_url('index.php/Reports/monthly_leave_report') ?>';
			form.target = '';
		});

		$('#exportBtn').on('click', function() {
			const form = document.getElementById('main');
			form.action = '<?= base_url('index.php/Reports/export_monthly_leave_report') ?>';
			form.target = '_blank';
			form.submit();
			form.action = '<?= base_url('index.php/Reports/monthly_leave_report') ?>';
			form.target = '';
		});
	});
</script>
