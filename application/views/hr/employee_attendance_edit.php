<style type="text/css">
	.select2Width {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		max-width: 240px !important;
		min-width: 240px !important;
	}
</style>

<div class="bg-white shadow rounded-lg p-6">

	<!-- Header -->
	<div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
		<h2 class="text-lg font-semibold text-gray-800"> Edit Employee Attendance </h2> <a href="<?php echo base_url(); ?>index.php/Hr/view_emp_attendance_list" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm transition"> <!-- List Icon --> <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
			</svg> List </a>
	</div>


	<?php foreach ($record1 as $row) : ?>
		<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_emp_attendance" id="addform" autocomplete="off" enctype="multipart/form-data">


			<!-- Employee Name -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
				<label class="block text-sm font-medium text-gray-700">
					Employee Name:
				</label>

				<div class="md:col-span-2">
					<?php foreach ($records as $s) {
						if ($row->id == $s->id) { ?>
							<input type="text"
								class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
								id="employee_id"
								name="employee_id"
								value="<?php echo $s->username; ?>"
								tabindex="1"
								readonly />

							<input type="hidden"
								name="employee_id_hidden"
								value="<?php echo $row->id; ?>" />
					<?php }
					} ?>
				</div>
			</div>

			<!-- Date -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
				<label class="block text-sm font-medium text-gray-700">
					Date:
				</label>

				<div class="md:col-span-2">
					<div class="relative">
						<input type="text"
							class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 datepicker1"
							id="Attendance_date"
							name="Attendance_date"
							value="<?php echo date('d-m-Y', strtotime($row->Attendance_date) ?? '') ?>"
							tabindex="2">

						<div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
							<i class="fa fa-calendar text-gray-400"></i>
						</div>
					</div>
				</div>
			</div>

			<!-- Attendance -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
				<label class="block text-sm font-medium text-gray-700">
					Attendance<span class="text-red-500"> * </span>
				</label>

				<div class="md:col-span-2">
					<select tabindex="3"
						class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
						id="attendance"
						name="attendance"
						required
						onchange="showFields()">

						<option value="">Select</option>

						<option <?php if ($row->attendence == 'P') echo 'selected'; ?> value="P">
							Present
						</option>

						<option <?php if ($row->attendence == 'A') echo 'selected'; ?> value="A">
							Absent
						</option>

					</select>
				</div>
			</div>

			<!-- In Time -->
			<div id="inOutTimeFields" style="display: none;">

				<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
					<label class="block text-sm font-medium text-gray-700">
						In Time :
					</label>

					<div class="md:col-span-2">
						<input type="time"
							id="in_time"
							name="in_time"
							tabindex="4"
							class="w-full md:w-48 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
							value="<?php echo date('H:i', strtotime($row->in_time)); ?>"
							onblur="calculateTotalDuration(0)">
					</div>
				</div>

				<!-- Out Time -->
				<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
					<label class="block text-sm font-medium text-gray-700">
						Out Time :
					</label>

					<div class="md:col-span-2">
						<input type="time"
							id="out_time"
							name="out_time"
							tabindex="5"
							class="w-full md:w-48 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
							value="<?php echo date('H:i', strtotime($row->out_time)); ?>"
							onblur="calculateTotalDuration(0)">
					</div>
				</div>

			</div>

			<!-- Submit -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
				<div></div>

				<div class="md:col-span-2">
					<input type="hidden"
						name="id"
						value="<?php echo $row->emp_aId; ?>">

					<button type="submit"
						id="add"
						tabindex="7"
						class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md shadow-sm transition duration-150">
						Submit
					</button>

					<a href="<?php echo base_url(); ?>index.php/Hr/emp_attendance_list" class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-6 py-2 rounded-md shadow-sm transition"> Cancel </a>
				</div>
			</div>

		</form>

	<?php endforeach ?>


</div>


<script>
	//use because without select present that time avilable present automatically load function
	window.onload = function() {
		showFields();
	};

	function showFields() {
		var attendance = document.getElementById("attendance").value;
		var inOutTimeFields = document.getElementById("inOutTimeFields");
		if (attendance === "P") {
			inOutTimeFields.style.display = "block";
		} else {
			inOutTimeFields.style.display = "none";
		}
	}


	// function calculateTotalDuration(index) {
	//     var inTime = document.getElementById('in_time' + index).valueAsDate;
	//     var outTime = document.getElementById('out_time' + index).valueAsDate;

	//     if (inTime && outTime) {
	//         var totalTime = new Date(outTime - inTime);
	//         var hours = totalTime.getUTCHours();
	//         var minutes = totalTime.getUTCMinutes();

	//         // Format the total time
	//         var formattedTotalTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;

	//         // Set the value to the Total Time field
	//         document.getElementById('total_time' + index).value = formattedTotalTime;
	//     }
	// }
</script>
