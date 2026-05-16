<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="bg-white shadow rounded-xl p-6">
	<div class="flex justify-between items-center mb-6 border-b pb-3">

		<!-- Caption -->
		<h2 class="text-xl font-semibold text-gray-800">
			Employee Attendance List
		</h2>

		<!-- Attendance List Button -->
		<a href="<?php echo base_url('index.php/Hr/add_emp_attendance'); ?>"
			class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm shadow">

			<!-- List Icon -->
			<svg xmlns="http://www.w3.org/2000/svg"
				class="w-4 h-4"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor">

				<path stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M4 6h16M4 12h16M4 18h16" />

			</svg>

			Add Attendance

		</a>

	</div>

	<!-- Filter Form -->
	<form id="main"
		method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/get_emp_attendance_list"
		autocomplete="off"
		enctype="multipart/form-data">

		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<!-- From Date -->
			<label class="col-span-12 md:col-span-2 font-medium">
				FROM <span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<div class="flex">

					<input type="date"
						id="from"
						name="from"
						value="<?php echo $from; ?>"
						class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm datepicker1">

					

				</div>

			</div>


			<!-- To Date -->
			<label class="col-span-12 md:col-span-2 font-medium">
				To <span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<div class="flex">

					<input type="date"
						id="to"
						name="to"
						value="<?php echo $to; ?>"
						class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm datepicker1">

					

				</div>

			</div>

		</div>



		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<!-- Employee -->
			<label class="col-span-12 md:col-span-2 font-medium">
				Select Employee
			</label>

			<div class="col-span-12 md:col-span-3">

				<select id="user_id"
					name="user_id"
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm select2 debtor-select">

					<option value="">Select</option>

					<?php foreach ($records1 as $s): ?>

						<option <?php if ($s->employee_id == $user_id) echo 'selected'; ?>
							value="<?php echo $s->employee_id ?>">

							<?php echo $s->employee_name; ?>

						</option>

					<?php endforeach; ?>

				</select>

			</div>



			<!-- Attendance Type -->
			<label class="col-span-12 md:col-span-2 font-medium">
				Select Type
			</label>

			<div class="col-span-12 md:col-span-3">

				<select id="attendance_type"
					name="attendance_type"
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm select2">

					<option value="">Select</option>

					<option value="I" <?= (isset($attendance_type) && $attendance_type == 'I') ? 'selected' : '' ?>>
						Biometric
					</option>

					<option value="O" <?= (isset($attendance_type) && $attendance_type == 'O') ? 'selected' : '' ?>>
						Onsite
					</option>

					<option value="M" <?= (isset($attendance_type) && $attendance_type == 'M') ? 'selected' : '' ?>>
						Manual
					</option>

				</select>

			</div>



			<!-- Go Button -->
			<div class="col-span-12 md:col-span-2">

				<button type="submit"
					id="view"
					name="go"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow text-sm">

					Go

				</button>

			</div>

		</div>

	</form>


</div>



<!-- Attendance Table -->
<div class="bg-white shadow rounded-xl p-6 mt-4">

	<div class="overflow-x-auto">

		<table id="datatable"
			class="min-w-full border border-gray-200 rounded-lg text-sm text-left">

			<thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">

				<tr>

					<th class="px-4 py-3 border">Sr No</th>

					<th class="px-4 py-3 border">Employee Name</th>

					<th class="px-4 py-3 border">Attendance</th>

					<th class="px-4 py-3 border">Type</th>

					<th class="px-4 py-3 border">IN Time</th>

					<th class="px-4 py-3 border">OUT Time</th>

					<th class="px-4 py-3 border">Attendance Date</th>

					<th class="px-4 py-3 border">Created By</th>

					<th class="px-4 py-3 border text-center">Action</th>

				</tr>

			</thead>



			<tbody class="divide-y">

				<?php $i = 1;
				foreach ($records as $row): ?>
					<?php if (!empty($row->employee_id)): ?>

						<tr class="hover:bg-gray-50">

							<td class="px-4 py-2 border">
								<?php echo $i++; ?>
							</td>

							<td class="px-4 py-2 border">
								<?php echo htmlspecialchars($row->name ?? ''); ?>
							</td>

							<td class="px-4 py-2 border">
								<?php echo htmlspecialchars($row->attendence ?? ''); ?>
							</td>

							<td class="px-4 py-2 border">
								<?php
								if ($row->type == 'I') echo "Biometric";
								elseif ($row->type == 'M') echo "Manual";
								elseif ($row->type == 'O') echo "Onsite";
								else echo "-";
								?>
							</td>

							<td class="px-4 py-2 border">
								<?php echo htmlspecialchars($row->in_time ?? ''); ?>
							</td>

							<td class="px-4 py-2 border">
								<?php echo htmlspecialchars($row->out_time ?? ''); ?>
							</td>

							<td class="px-4 py-2 border">
								<?php echo !empty($row->Attendance_date) ? date('d-M-Y', strtotime($row->Attendance_date)) : '-'; ?>
							</td>

							<td class="px-4 py-2 border">
								
								<?php echo !empty($row->created_date) ? htmlspecialchars($row->created_date ?? '') : '-'; ?>
							</td>

							<td class="px-4 py-2 border text-center whitespace-nowrap">



								<!-- Delete -->
								<a href="<?= base_url('index.php/Hr/delete_attendance_emp/' . $row->emp_aId); ?>"
									onclick="return confirmcancel(<?= $row->emp_aId; ?>);"
									class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg ml-2"
									title="Delete">
									🗑
								</a>

							</td>

						</tr>

					<?php endif; ?>
				<?php endforeach; ?>

			</tbody>

		</table>

	</div>

</div>


<!-- Static Table End -->



<script>
	function confirmcancel(tid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'employee_attendance',
					where_key: 'emp_aId',
					where_val: tid
				},
				success: function(msg) {
					if (msg == 1) {
						alert("Record deleted");
						window.location.reload();
					} else {
						alert("Can't Delete record. Data already exist!!!");
					}
				},
			});
			return true;
		} else
			return false;

	}

	$(document).ready(function() {

		$('.debtor-select').select2({
			width: '100%'
		});

		$('#datatable').DataTable({
			pageLength: 10,
			ordering: true,
			searching: true,
			lengthMenu: [10, 25, 50, 100],
			columnDefs: [{
					orderable: false,
					targets: [8]
				} // disable sorting for Action column
			]
		});

	});
</script>
