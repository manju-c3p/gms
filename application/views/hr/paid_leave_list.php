<div class="bg-white shadow rounded-lg p-6">
	<!-- Header -->


	<div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">

		<!-- Caption -->
		<h2 class="text-lg font-semibold text-gray-800">
			Paid Leave List
		</h2>

		<!-- Add Paid Leave Button -->
		<a href="<?php echo base_url(); ?>index.php/Hr/paid_leave"
			class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition">

			<!-- Plus Icon -->
			<svg xmlns="http://www.w3.org/2000/svg"
				class="w-4 h-4 mr-2"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor">

				<path stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M12 4v16m8-8H4" />

			</svg>

			Add Paid Leave

		</a>

	</div>





	<!-- Filter Form -->
	<form id="main"
		method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/filter_paid_leave_list"
		autocomplete="off"
		name="question"
		enctype="multipart/form-data">

		<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center mb-4">

			<!-- Year Label -->
			<label class="text-sm font-medium text-gray-700 md:col-span-1">
				Select Year :<span class="text-red-500">*</span>
			</label>

			<!-- Year Picker -->
			<div class="relative md:col-span-2">
				<input type="text"
					class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
					id="current_year"
					name="current_year"
					placeholder="Select Year"
					readonly
					value="<?php echo $current_year; ?>">

				<div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
					<i class="fa fa-calendar text-gray-400"></i>
				</div>
			</div>

			<!-- Spacer -->
			<div class="hidden md:block md:col-span-1"></div>

			<!-- Go Button -->
			<div class="md:col-span-2">
				<input type="submit"
					id="view"
					name="go"
					value="Go"
					class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md shadow-sm transition cursor-pointer" />
			</div>

		</div>

	</form>


	<!-- Table -->
	<div class="overflow-x-auto">

		<table id="datatable"
			class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">

			<thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">

				<tr>

					<th class="px-4 py-2 border">Sr No</th>

					<th class="px-4 py-2 border">Paid Leave Code</th>

					<th class="px-4 py-2 border">Employee Name</th>

					<th class="px-4 py-2 border">Date</th>

					<th class="px-4 py-2 border">Paid Leave Day</th>

					<th class="px-4 py-2 border text-center">Action</th>

				</tr>

			</thead>

			<tbody class="divide-y divide-gray-200">

				<?php $i = 1;
				foreach ($records as $row) { ?>

					<tr class="hover:bg-gray-50">

						<td class="px-4 py-2 border">
							<?php echo $i;
							$i++; ?>
						</td>

						<td class="px-4 py-2 border">
							<?php echo $row->paid_code; ?>
						</td>

						<td class="px-4 py-2 border">
							<?php echo $row->name; ?>
						</td>

						<td class="px-4 py-2 border">
							<?php echo date('d-M-Y', strtotime($row->p_date)); ?>
						</td>

						<td class="px-4 py-2 border">
							<?php echo $row->paid_days; ?>
						</td>

						<td class="px-4 py-2 border text-center whitespace-nowrap">

							<!-- Edit -->
							<a href="<?php echo base_url() . 'index.php/Hr/edit_paid_leave/' . $row->paid_id; ?>"
								title="Edit"
								class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg">

								<i class="fa fa-edit"></i>

							</a>

							<!-- Delete -->
							<a href="<?php echo base_url() . 'index.php/Hr/delete_paid_leave/' . $row->paid_id; ?>"
								title="Delete"
								onclick="return confirmcancel(<?php echo $row->paid_id; ?>);"
								class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg ml-2">

								<i class="fa fa-trash"></i>

							</a>

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
					table_name: 'paid_leave_master',
					where_key: 'paid_id',
					where_val: tid
				},
				success: function(msg) {
					if (msg == 1) {

						window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
					} else {
						alert("Can't Delete record. Data already exist!!!");
					}
				},
			});
			return true;
		} else
			return false;

	}
</script>
<script>
	$(document).ready(function() {
		$('#yearPicker').datepicker({
			format: "yyyy",
			viewMode: "years",
			minViewMode: "years",
			autoclose: true,
			defaultViewDate: {
				year: new Date().getFullYear(),
				month: 0,
				day: 1
			}
		}).datepicker('setDate', new Date()); // sets the current year as selected
	});
</script>
