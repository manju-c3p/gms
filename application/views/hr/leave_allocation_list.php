<!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Header -->
<div class="flex items-center justify-between bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 mb-4">

	<!-- Caption -->
	<h2 class="text-lg font-semibold text-gray-800">
		Leave Application List
	</h2>

	<!-- Add Button -->
	<a href="<?php echo base_url(); ?>index.php/Hr/add_leave_application"
		class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded shadow">

		<!-- Plus Icon -->
		<svg xmlns="http://www.w3.org/2000/svg"
			class="w-4 h-4"
			fill="none"
			viewBox="0 0 24 24"
			stroke="currentColor">

			<path stroke-linecap="round"
				stroke-linejoin="round"
				stroke-width="2"
				d="M12 4v16m8-8H4" />

		</svg>

		Add Leave

	</a>

</div>


<!-- Table Container -->
<div class="bg-white shadow rounded-lg p-4">

	<div class="overflow-x-auto">

		<table id="datatable"
			class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">

			<!-- Table Head -->
			<thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">

				<tr>

					<th class="px-3 py-2 border">Sr No</th>
					<th class="px-3 py-2 border">Leave Code</th>
					<th class="px-3 py-2 border">Employee Name</th>
					<th class="px-3 py-2 border">Leave Type</th>
					<th class="px-3 py-2 border">Leave From / To</th>
					<th class="px-3 py-2 border">Applied On</th>
					<th class="px-3 py-2 border">Leave Status</th>
					<th class="px-3 py-2 border">Approved HOD</th>
					<th class="px-3 py-2 border">Approved Hr</th>
					<th class="px-3 py-2 border text-center">Action</th>

				</tr>

			</thead>


			<!-- Table Body -->
			<tbody class="divide-y divide-gray-200">

				<?php $i = 1; ?>
				<?php foreach ($records as $row) { ?>

					<tr class="hover:bg-gray-50">

						<td class="px-3 py-2 border"><?php echo $i++; ?></td>

						<td class="px-3 py-2 border font-medium text-gray-800">
							<?php echo $row->leave_code; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo $row->employee_name; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo $row->leave_type; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo date('d-M-Y', strtotime($row->start_date)); ?>
							<br>
							<?php echo date('d-M-Y', strtotime($row->e_date)); ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo date('d-M-Y', strtotime($row->application_date)); ?>
						</td>


						<!-- Status -->
						<td class="px-3 py-2 border">

							<?php
							$latest_status = 'Pending';

							foreach ($record1 as $app) {
								if ($row->leave_id == $app->approval_leave_id) {

									if ($app->leave_status == 0) {
										$latest_status = 'Pending';
									} else if ($app->leave_status == 1) {
										$latest_status = 'Approved';
									} else if ($app->leave_status == 2) {
										$latest_status = 'Rejected';
									}
								}
							}

							if ($latest_status == 'Pending') {
								echo '<span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded">Pending</span>';
							} else if ($latest_status == 'Approved') {
								echo '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded">Approved</span>';
							} else {
								echo '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">Rejected</span>';
							}

							?>

						</td>


						<?php
						$admin_md_name = '';
						$hr_name = '';

						foreach ($record2 as $a) {

							if ($row->admin_md == $a->id) {
								$admin_md_name = $a->username;
							}

							if ($row->hr == $a->id) {
								$hr_name = $a->username;
							}
						}
						?>


						<td class="px-3 py-2 border">
							<?php echo $admin_md_name; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo $hr_name; ?>
						</td>



						<td class="px-3 py-2 border text-center whitespace-nowrap">

						<a href="<?php echo base_url() . 'index.php/Hr/edit_leave_application/' . $row->leave_id; ?>"
									class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>

								<a href="<?php echo base_url() . 'index.php/Hr/delete_leave_application/' . $row->leave_id; ?>"
									onclick="return confirmcancel(<?php echo $row->leave_id; ?>);" class="bg-red-500 text-white px-3 py-1 rounded">Delete</a>

								<a href="<?php echo base_url() . 'index.php/Hr/print_leave_application/' . $row->leave_id; ?>"
									target="_blank"
									class="bg-blue-600 text-white px-3 py-1 rounded">Print</a>

							


							


							

						</td>

					</tr>

				<?php } ?>

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
					table_name: 'employee_leave',
					where_key: 'leave_id',
					where_val: tid
				},
				success: function(msg) {
					if (msg == 1) {
						alert("Record Deleted");
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

	$(document).ready(function () {
	$('#datatable').DataTable({
		"pageLength": 10,
		"ordering": true,
		"searching": true,
		"lengthChange": true,
		"columnDefs": [
			{ "orderable": false, "targets": [9] } // disable sorting for Action column
		]
	});
});
</script>
