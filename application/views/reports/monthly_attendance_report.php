<div class="bg-white shadow rounded-xl p-6">


	<form method="post" action="<?= base_url('index.php/Reports/monthly_attendance_report') ?>">
		<div class="flex flex-wrap gap-4 mb-4">

			<div class="w-full md:w-60">
				<label class="block text-sm font-medium mb-1">From Date</label>
				<input type="date" name="from_date"
					value="<?= htmlspecialchars($from_date ?? '') ?>"
					required
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200">
			</div>

			<div class="w-full md:w-60">
				<label class="block text-sm font-medium mb-1">To Date</label>
				<input type="date" name="to_date"
					value="<?= htmlspecialchars($to_date ?? '') ?>"
					required
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200">
			</div>

			<div class="w-full md:w-60">
				<label class="block text-sm font-medium mb-1">Department</label>
				<select name="department_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm select2">
					<option value="">All</option>
					<?php foreach ($departments as $dept): ?>
						<option value="<?= $dept->department_id  ?>" <?= ($selected_dept == $dept->department_id ) ? 'selected' : '' ?>>
							<?= $dept->department_name ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="flex items-end">
				<button type="submit"
					class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2 rounded-lg shadow">
					Generate
				</button>
			</div>

		</div>
	</form>

	<!-- Right Aligned Buttons -->
	<!-- <div class="flex justify-end gap-2 mb-4">

		<form action="<?= base_url('index.php/Reports/print_monthly_attendance_report') ?>" method="post" target="_blank">
			<input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date ?? '') ?>">
			<input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date ?? '') ?>">
			<input type="hidden" name="department_id" value="<?= htmlspecialchars($selected_dept) ?>">
			<button type="submit"
				class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded-lg shadow">
				Print
			</button>
		</form>

		<form action="<?= base_url('index.php/Reports/export_monthly_attendance_report') ?>" method="post">
			<input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date ?? '') ?>">
			<input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date ?? '') ?>">
			<input type="hidden" name="department_id" value="<?= htmlspecialchars($selected_dept) ?>">
			<button type="submit"
				class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-lg shadow">
				Export to Excel
			</button>
		</form>

	</div> -->


</div>

<div class="bg-white shadow rounded-xl p-6 mt-4">


	<div class="overflow-x-auto">
		<table id="datatable" class="min-w-full border border-gray-200 text-sm text-left">
			<thead class="bg-gray-100 text-gray-700">
				<tr>
					<th class="border px-3 py-2">Sr No</th>
					<!-- <th class="border px-3 py-2">Employee Code</th> -->
					<th class="border px-3 py-2">Employee Name</th>
					<th class="border px-3 py-2">Department</th>
					<th class="border px-3 py-2">Designation</th>
					<th class="border px-3 py-2">Attendance Date</th>
					<th class="border px-3 py-2">Status</th>
					<th class="border px-3 py-2">In-Time</th>
					<th class="border px-3 py-2">Out-Time</th>
				</tr>
			</thead>

			<tbody class="divide-y divide-gray-100">
				<?php if (!empty($records)): $i = 1; ?>
					<?php foreach ($records as $row): ?>
						<tr class="hover:bg-gray-50">
							<td class="border px-3 py-2"><?= $i++ ?></td>
							<!-- <td class="border px-3 py-2"><?= $row->employee_code ?></td> -->
							<td class="border px-3 py-2"><?= $row->employee_name ?></td>
							<td class="border px-3 py-2"><?= $row->department_name ?></td>
							<td class="border px-3 py-2"><?= $row->designation_name ?></td>
							<td class="border px-3 py-2"><?= date('d-M-Y', strtotime($row->Attendance_date)) ?></td>
							<td class="border px-3 py-2">
								<?= ($row->attendence == 'P') ? '<span class="text-green-600 font-semibold">Present</span>' : '<span class="text-red-600 font-semibold">Absent</span>' ?>
							</td>
							<td class="border px-3 py-2"><?= $row->in_time ?? '-' ?></td>
							<td class="border px-3 py-2"><?= $row->out_time ?? '-' ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>

		</table>
	</div>


</div>



<script>
	$(document).ready(function() {
		$('.select2').select2();

		$('#datatable').DataTable({
			responsive: true,
			language: {
				emptyTable: "No attendance records found."
			}
		});
	});
</script>
