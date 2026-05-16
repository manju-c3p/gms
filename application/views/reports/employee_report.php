<?php if (!isset($is_generated)) $is_generated = false; ?>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="bg-white shadow rounded-lg">

	<div class="p-6">

		<!-- Filter Form -->
		<form id="main" method="post" action="<?= base_url('index.php/Reports/employee_report') ?>">

			<div class="grid grid-cols-12 gap-4 mb-4 items-end">

				<!-- Department -->
				<div class="col-span-12 md:col-span-3">

					<label class="block text-sm font-medium text-gray-700 mb-1">
						Department
					</label>

					<select name="department_id"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 debtor-select">

						<option value="">All</option>

						<?php foreach ($departments as $dept): ?>

							<option value="<?= $dept->department_id  ?>"
								<?= ($selected_dept == $dept->department_id) ? 'selected' : '' ?>>

								<?= htmlspecialchars($dept->department_name) ?>

							</option>

						<?php endforeach; ?>

					</select>

				</div>


				<!-- Designation -->
				<div class="col-span-12 md:col-span-3">

					<label class="block text-sm font-medium text-gray-700 mb-1">
						Designation
					</label>

					<select name="designation_id"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2">

						<option value="">All</option>

						<?php foreach ($designations as $desig): ?>

							<option value="<?= $desig->designation_id  ?>"
								<?= ($selected_desig == $desig->designation_id) ? 'selected' : '' ?>>

								<?= htmlspecialchars($desig->designation_name) ?>

							</option>

						<?php endforeach; ?>

					</select>

				</div>


				<!-- Employee -->
				<div class="col-span-12 md:col-span-3">

					<label for="user_id"
						class="block text-sm font-medium text-gray-700 mb-1">

						Employee

					</label>

					<select id="user_id"
						name="user_id"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2">

						<option value="">All</option>

						<?php foreach ($user_records as $user): ?>

							<option value="<?= $user->employee_id ?>"
    <?= ($user->employee_id == $user_id) ? 'selected' : '' ?>>

								<?= htmlspecialchars($user->employee_name) ?>

							</option>

						<?php endforeach; ?>

					</select>

				</div>


				<!-- Buttons -->
				<div class="col-span-12 md:col-span-3">

					<div class="flex flex-wrap gap-2 md:justify-end items-center h-[40px]">

						<button type="submit"
							name="action"
							value="Go"
							class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">

							Go

						</button>


						<button type="button"
							id="printBtn"
							class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">

							Print

						</button>


						<button type="button"
							id="exportBtn"
							class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">

							Export to Excel

						</button>

					</div>

				</div>

			</div>


			<input type="hidden"
				name="is_generated"
				value="<?= $is_generated ? '1' : '' ?>">

		</form>


		<!-- Data Table -->
		<div class="w-full overflow-x-auto">

			<table id="datatable"
				class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700"
				width="100%">

				<thead class="bg-blue-100 text-xs font-semibold uppercase text-gray-700">

					<tr>

						<th class="px-3 py-2 border border-gray-200">Sr. No</th>

						<th class="px-3 py-2 border border-gray-200">
							Employee Name
						</th>

						<th class="px-3 py-2 border border-gray-200">
							Designation
						</th>

						<th class="px-3 py-2 border border-gray-200">
							Department
						</th>

						<th class="px-3 py-2 border border-gray-200">
							Date of Join
						</th>

						<th class="px-3 py-2 border border-gray-200">
							Contact Number
						</th>

						<th class="px-3 py-2 border border-gray-200">
							Email ID
						</th>

						<th class="px-3 py-2 border border-gray-200">
							Basic Salary
						</th>

					</tr>

				</thead>


				<tbody class="bg-white divide-y divide-gray-200">

					<?php if (!empty($records)): ?>

						<?php $i = 1;
						foreach ($records as $row): ?>

							<tr class="hover:bg-gray-50">

								<td class="px-3 py-2 border border-gray-200">
									<?= $i++ ?>
								</td>

								<td class="px-3 py-2 border border-gray-200">
									<?= htmlspecialchars($row->employee_name ?? '-') ?>
								</td>

								<td class="px-3 py-2 border border-gray-200">
									<?= htmlspecialchars($row->designation_name ?? '-') ?>
								</td>

								<td class="px-3 py-2 border border-gray-200">
									<?= htmlspecialchars($row->department_name ?? '-') ?>
								</td>

								<td class="px-3 py-2 border border-gray-200">
									<?= htmlspecialchars($row->joining_date ?? '-') ?>
								</td>

								<td class="px-3 py-2 border border-gray-200">
									<?= htmlspecialchars($row->mobile ?? '-') ?>
								</td>

								<td class="px-3 py-2 border border-gray-200">
									<?= htmlspecialchars($row->email ?? '-') ?>
								</td>

								<td class="px-3 py-2 border border-gray-200">
									<?= htmlspecialchars($row->basic_salary ?? '-') ?>
								</td>

							</tr>

						<?php endforeach; ?>

					<?php elseif ($is_generated): ?>

						

					<?php endif; ?>

				</tbody>

			</table>

		</div>

	</div>

</div>
<script>
	$(document).ready(function() {

		// Select2
		$('.debtor-select').select2({
			width: '100%'
		});

		$('#datatable').DataTable({
			language: {
				emptyTable: "No records found"
			}
		});




		// Print Action
		$('#printBtn').on('click', function() {
			const form = document.getElementById('main');
			form.action = '<?= base_url('index.php/Reports/print_employee_report') ?>';
			form.target = '_blank';
			form.submit();
			form.action = '<?= base_url('index.php/Reports/employee_report') ?>'; // revert
			form.target = '';
		});

		// Export Action
		$('#exportBtn').on('click', function() {
			const form = document.getElementById('main');
			form.action = '<?= base_url('index.php/Reports/export_employee_report') ?>';
			form.target = '_blank';
			form.submit();
			form.action = '<?= base_url('index.php/Reports/employee_report') ?>'; // revert
			form.target = '';
		});
	});

	
$('#user_id').on('change', function () {
    if ($(this).val() !== '') {
        $('select[name="department_id"]').val('').trigger('change');
        $('select[name="designation_id"]').val('').trigger('change');
    }
});
</script>
