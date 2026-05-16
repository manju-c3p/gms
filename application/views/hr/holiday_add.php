<div class="bg-white rounded-xl shadow p-6">

	<div class="flex justify-between items-center mb-4">
		<h2 class="text-xl font-semibold text-gray-700"> Holiday Master </h2>
		<!-- List Button -->
		<a href="<?= base_url('index.php/Hr/view_holiday_list') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium"> List </a>
	</div>

	<form onsubmit="return" id="main" method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/add_holiday_data"
		autocomplete="off" enctype="multipart/form-data">

		<!-- Holiday Name -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
			<label class="text-sm font-medium text-gray-700">
				Holiday Name: <span class="text-red-500">*</span>
			</label>

			<div class="md:col-span-2">
				<abbr title="Enter Holiday Name">
					<input type="text"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
						id="holiday_name"
						name="holiday_name"
						tabindex="4"
						required>
				</abbr>
			</div>
		</div>

		<!-- Date -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
			<label class="text-sm font-medium text-gray-700">
				Date: <span class="text-red-500">*</span>
			</label>

			<div class="md:col-span-2">
				<div class="flex">

					<input type="date" class="w-full border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none datepicker1"

						id="holiday_date"
						name="holiday_date"
						value="<?php echo date('Y-m-d'); ?>"
						required>

					<!-- <div class="bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg px-3 flex items-center">
						<i class="fa fa-calendar"></i>
					</div> -->
				</div>

				<label id="date_exits" class="text-red-500 text-sm mt-1 block"></label>
			</div>
		</div>

		<!-- Description -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
			<label class="text-sm font-medium text-gray-700">
				Holiday Description
			</label>

			<div class="md:col-span-2">
				<textarea id="holl_desc"
					tabindex="5"
					name="holl_desc"
					rows="2"
					placeholder="holiday description"
					class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
					required></textarea>
			</div>
		</div>

		<!-- Submit -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<div></div>

			<div class="md:col-span-2">
				<button type="submit"
					tabindex="7"
					id="add"
					class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow">
					Submit
				</button>
			</div>
		</div>

	</form>

</div>


<script>
	$(document).ready(function() {
		$('#holiday_date').on('change', function() {
			check_dept_exist();
		});

		function check_dept_exist() {
			var formattedDate = $('#holiday_date').val(); // already YYYY-MM-DD

			if (formattedDate) {
				$.ajax({
					url: "<?php echo site_url('Ajax/check_duplicate_exist5'); ?>",
					type: 'POST',
					data: {
						table_name: 'holiday_master',
						column_name1: 'h_date',
						post_id1: formattedDate
					},
					success: function(msg) {
						if (msg != 0) {
							$('#date_exits').html("This holiday date already exists. Please choose another date.");
						} else {
							$('#date_exits').html("");
						}
					},
					error: function() {
						$('#date_exits').html("An error occurred. Please try again.");
					}
				});
			} else {
				$('#date_exits').html("Please select a valid date.");
			}
		}
	});
</script>
