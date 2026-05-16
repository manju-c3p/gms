<!-- the datepicker input -->
<div class="bg-white shadow rounded-lg p-6">
	<!-- Header -->
	<div class="flex items-center justify-between bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 mb-4">

		<!-- Caption / Title -->
		<h2 class="text-lg font-semibold text-gray-800">
			Leave Application
		</h2>

		<!-- List Button -->
		<a href="<?php echo base_url(); ?>index.php/Hr/view_leave_application_list"
			class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded shadow">

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

			List

		</a>

	</div>

	<form onsubmit="return check_duplicate_exist();"
		id="main"
		method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/add_leave_application_data"
		autocomplete="off"
		enctype="multipart/form-data">

		<!-- Employee Name -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

			<label class="md:col-span-3 text-sm font-medium">
				Select Employee:<span class="text-red-500">*</span>
			</label>

			<div class="md:col-span-5">

				<select id="employee_dropdown"
					class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">

					<option value="">Select Employee</option>

					<?php foreach ($user_records as $s) { ?>
						<option value="<?php echo $s->employee_id; ?>"
							data-name="<?php echo $s->employee_name; ?>">
							<?php echo $s->employee_name; ?>
						</option>
					<?php } ?>

				</select>

			</div>

		</div>



		<!-- Employee Name & ID -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

			<label class="md:col-span-3 text-sm font-medium">
				Employee Name & ID :
			</label>

			<div class="md:col-span-5 grid grid-cols-2 gap-3">

				<input type="text"
					id="employee_name"
					name="employee_name"
					placeholder="Employee Name"
					readonly
					class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100">

				<input type="text"
					id="employee_id"
					name="employee_id"
					placeholder="Employee ID"
					readonly
					class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100">

			</div>

		</div>






		<!-- Application Date -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

			<label class="md:col-span-3 text-sm font-medium">
				Application date:
			</label>

			<div class="md:col-span-5">

				<input type="date"
					id="application_date"
					name="application_date"
					value="<?php echo date('Y-m-d'); ?>"
					tabindex="2"
					class="w-full border border-gray-300 rounded px-3 py-1 text-sm">

			</div>

		</div>


		<!-- Leave Type -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

			<label class="md:col-span-3 text-sm font-medium">
				Leave Type :<span class="text-red-500">*</span>
			</label>

			<div class="md:col-span-5">

				<select
					name="ltype_id"
					id="ltype_id"
					required
					onchange="data_for_leave_days();"
					class="w-full border border-gray-300 rounded px-3 py-1 text-sm">

					<option value="">Select</option>

					<?php foreach ($category as $cat) { ?>

						<option value="<?php echo $cat->leave_cat_id ?>"
							data-days="<?php echo $cat->leave_days ?>">

							<?php echo $cat->category_name; ?>

						</option>

					<?php } ?>

				</select>

			</div>

		</div>


		<!-- Allocate Leave -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

			<label class="md:col-span-3 text-sm font-medium">
				Allocate Leave & Use Leave :<span class="text-red-500">*</span>
			</label>

			<div class="md:col-span-3">

				<input type="text"
					id="allocated_leave"
					name="allocated_leave"
					readonly
					class="w-full border border-gray-300 rounded px-3 py-1 text-sm bg-gray-100">

			</div>

			<div class="md:col-span-3">

				<input type="text"
					id="avilable_leave"
					name="avilable_leave"
					readonly
					class="w-full border border-gray-300 rounded px-3 py-1 text-sm bg-gray-100">

			</div>

		</div>


		<!-- Normal Leave Group -->
		<div id="normal_leave_group">

			<!-- Leave From To -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

				<label class="md:col-span-3 text-sm font-medium">
					Leave From - To :<span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-3">

					<input type="date"
						id="start_date"
						name="start_date"
						value="<?php echo date('Y-m-d') ?>"
						required
						onchange="calculate_total_days()"
						class="w-full border border-gray-300 rounded px-3 py-1 text-sm">

					<label id="leave_exists" class="text-red-500 text-sm"></label>

				</div>

				<div class="md:col-span-3">

					<input type="date"
						id="end_date"
						name="end_date"
						value="<?php echo date('Y-m-d') ?>"
						required
						onchange="calculate_total_days()"
						class="w-full border border-gray-300 rounded px-3 py-1 text-sm">

				</div>

			</div>


			<!-- Total Days -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

				<label class="md:col-span-3 text-sm font-medium">
					Total Days :
				</label>

				<div class="md:col-span-2">

					<input type="text"
						id="total_date"
						name="total_date"
						readonly
						class="w-full border border-gray-300 rounded px-3 py-1 text-sm">

				</div>

			</div>


			<!-- Contact -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">

				<label class="md:col-span-3 text-sm font-medium">
					Contact & Address In leave :
				</label>

				<div class="md:col-span-5">

					<textarea
						id="outside_contact"
						name="outside_contact"
						rows="2"
						placeholder="Contact & Address Outside Country"
						class="w-full border border-gray-300 rounded px-3 py-1 text-sm"></textarea>

				</div>

			</div>


			<!-- Reason -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">

				<label class="md:col-span-3 text-sm font-medium">
					Reason :
				</label>

				<div class="md:col-span-5">

					<textarea
						id="reason"
						name="reason"
						rows="2"
						placeholder="Specify reason for leave"
						class="w-full border border-gray-300 rounded px-3 py-1 text-sm"></textarea>

				</div>

			</div>


			<!-- Joining Date -->
			<div id="joining_date_group"
				style="display:none;"
				class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

				<label class="md:col-span-3 text-sm font-medium">
					Joining Date From Last Leave:<span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-5">

					<input type="date"
						id="last_date"
						name="last_date"
						value="<?php echo date('Y-m-d'); ?>"
						class="w-full border border-gray-300 rounded px-3 py-1 text-sm">

				</div>

			</div>


			<!-- Replacement -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

				<label class="md:col-span-3 text-sm font-medium">
					Charge Handed To :<span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-5">

					<select id="replcement"
						name="replcement"
						class="w-full border border-gray-300 rounded px-3 py-1 text-sm">

						<option value="">Select</option>

						<?php foreach ($user_records as $s) { ?>

							<option
								value="<?php echo $s->employee_id ?>">

								<?php echo $s->employee_name; ?>

							</option>

						<?php } ?>

					</select>

				</div>

			</div>

		</div>


		<!-- File Upload -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">

			<label class="md:col-span-3 text-sm font-medium">
				Upload("jpeg","jpg","png","doc","pdf"):
			</label>

			<div class="md:col-span-6">

				<table class="w-full border border-gray-300 rounded">

					<tbody>

						<tr id="addr0">

							<td class="border px-2 py-1">1</td>

							<td class="border px-2 py-1">

								<input type="file"
									id="documents"
									name="documents[]"
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm" accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">

							</td>

							<td class="border px-2 py-1 space-x-2">

								<a id="add_row"
									class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm cursor-pointer">

									+

								</a>

								<a id="delete_row"
									class="inline-block bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm cursor-pointer">

									🗑

								</a>

							</td>

						</tr>

						<tr id="addr1"></tr>

					</tbody>

				</table>

			</div>

		</div>


		<!-- Submit -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4">

			<div class="md:col-span-3"></div>

			<div class="md:col-span-5">

				<button type="submit"
					id="add"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">

					Submit

				</button>

			</div>

		</div>

	</form>

</div>


<script>
	$(document).ready(function() {
		var i = 1;
		$("#add_row").click(function() {
			$('#addr' + i).html("<td>" + (i + 1) + "</td><td><div class='col-sm-6'><input class='form-control' id='documents" + i + "' name='documents[]' type='file'></div></td><td></td>");
			$('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
			i++;
		});

		$("#delete_row").click(function() {
			if (i > 1) {
				$("#addr" + (i - 1)).html('');
				i--;
			}
		});

		function toggleLeaveFields() {
			var selected = $('#ltype_id').val();

			if (selected && selected.toLowerCase().includes("compensatory")) {
				$('#normal_leave_group').hide();
				$('#comp_leave_group').show();

				// remove required from normal fields
				$('#normal_leave_group :input').prop('required', false);

				// add required to comp leave fields
				$('#date_working, #date_compoff').prop('required', true);

			} else {
				$('#normal_leave_group').show();
				$('#comp_leave_group').hide();

				// add required back to normal fields
				$('#start_date, #end_date, #charge_handed_to').prop('required', true);

				// remove required from comp leave fields
				$('#date_working, #date_compoff').prop('required', false);
			}

			// also handle "Joining Date From Last Leave" visibility for Annual Leave
			if (selected && selected.toLowerCase().includes("annual")) {
				$('#joining_date_group').show();
				$('#last_date').prop('required', true);
			} else {
				$('#joining_date_group').hide();
				$('#last_date').prop('required', false);
			}
		}

		toggleLeaveFields(); // run on load
		$('#ltype_id').on('change', toggleLeaveFields);
	});

	$("#tab_logic").on('click', '.remove', function() {
		$(this).closest('tr').remove();
	});
	//this following function is calculate total days
	function calculate_total_days() {
		var startDateStr = document.getElementById('start_date').value;
		var endDateStr = document.getElementById('end_date').value;

		if (!startDateStr || !endDateStr) {
			document.getElementById("total_date").value = 0;
			return;
		}

		// Parse start date and end date in Y-m-d format
		var startDateArr = startDateStr.split('-');
		var endDateArr = endDateStr.split('-');

		var startDate = new Date(startDateArr[0], startDateArr[1] - 1, startDateArr[2]);
		var endDate = new Date(endDateArr[0], endDateArr[1] - 1, endDateArr[2]);

		const time = endDate - startDate;

		if (time < 0) {
			document.getElementById("total_date").value = 0; // invalid range
			return;
		}

		// Add 1 to include both start and end date
		const days = Math.floor(time / (1000 * 60 * 60 * 24)) + 1;

		document.getElementById("total_date").value = days;
	}


	//add a calender to hide privious date thi functionality
	var date = new Date();
	var tdate = date.getDate();
	var month = date.getMonth() + 1;

	if (tdate < 10) {
		tdate = '0' + tdate;
	}
	if (month < 10) {
		month = '0' + month;
	}

	var year = date.getUTCFullYear();
	var mindate = year + "-" + month + "-" + tdate;

	// document.getElementById("application_date").setAttribute('min', mindate);
	document.getElementById("start_date").setAttribute('min', mindate);
	document.getElementById("end_date").setAttribute('min', mindate);
	document.getElementById("last_date").setAttribute('min', mindate);
	console.log(mindate);

	window.onload = function() {
		calculate_total_days();
	};

	function data_for_leave_days() {

		var ltype_id = document.getElementById('ltype_id').value;
		var employee_id = document.getElementById('employee_id').value;


		if (ltype_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_paid_leave_info",
				data: {
					ltype_id: ltype_id,
					employee_id: employee_id
				},
				dataType: "json",
				success: function(msg) {


					document.getElementById("avilable_leave").value = msg.use_paid_leave;
					document.getElementById("allocated_leave").value = msg.paid_days;


				}
			});
		} else {
			document.getElementById("avilable_leave").value = '';
			document.getElementById("allocated_leave").value = '';



		}
	}
	// function check_date_exist() {
	//     var startDate = $('#start_date').val();

	//     $.ajax({
	//         url: "<?php echo site_url('Ajax/check_exist_leave_application'); ?>",
	//         type: 'POST',
	//         data: {
	//             start_date: startDate
	//         },
	//         success: function(msg) {
	//             if (msg != 0) {
	//                 $('#leave_exists').text("Leave record already exists for the selected start date.");
	//             } else {
	//                 $('#leave_exists').text("");
	//             }
	//         }
	//     });
	// }
</script>



<!-- <script>
    function check_date_exist() {
        var empId = $('#employee_id').val();
        var appDate = $('#application_date').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var leaveType = $('#ltype_id').val();
        $.ajax({
            url: "<?php echo site_url('Ajax/check_duplicate_exist2'); ?>",
            type: 'POST',
            data: {
                table_name: 'employee_leave',
                column_name1: 'employee_id',
                post_id1: empId,
                column_name2: 'application_date',
                post_id2: appDate,
                column_name3: 'start_date',
                post_id3: startDate,
                column_name4: 'end_date',
                post_id4: endDate,
                column_name5: 'leave_type',
                post_id5: leaveType,
            },
            success: function(msg) {
                if (msg != 0) {
                    $('#leave_exits').html("leave already exits from date");
                    $('#start_date').val('');
                } else {
                    $('#leave_exits').html("");
                }
            }
        });
    }



    ///new 
    // function check_date_exist() {
    //     var empId = $('#employee_id').val();
    //     var appDate = $('#application_date').val();
    //     var startDate = $('#start_date').val();
    //     var endDate = $('#end_date').val();
    //     var leaveType = $('#ltype_id').val();

    //     // Convert date format to YYYY-MM-DD
    //     appDate = formatDate(appDate);
    //     startDate = formatDate(startDate);
    //     endDate = formatDate(endDate);

    //     $.ajax({
    //         url: "<?php echo site_url('Ajax/check_exist_leave_application'); ?>",
    //         type: 'POST',
    //         data: {
    //             table_name: 'employee_leave',
    //             column_name1: 'employee_id',
    //             post_id1: empId,
    //             column_name2: 'application_date',
    //             post_id2: appDate,
    //             column_name3: 'start_date',
    //             post_id3: startDate,
    //             column_name4: 'end_date',
    //             post_id4: endDate,
    //             column_name5: 'leave_type',
    //             post_id5: leaveType,
    //         },
    //         success: function(response) {
    //             if (response != 0) {
    //                 $('#leave_exits').html("Leave already exists from this date");
    //                 $('#start_date').val('');
    //             } else {
    //                 $('#leave_exits').html("");
    //                 // calculate_total_days(); // Recalculate total days after successful check
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(xhr.responseText);
    //         }
    //     });
    // }

    // // Function to format date to YYYY-MM-DD
    // function formatDate(date) {
    //     var parts = date.split("-");
    //     retur n parts[2] + "-" + parts[1] + "-" + parts[0];
    // }
</script> -->


<script>
	document.getElementById('employee_dropdown').addEventListener('change', function() {

		let selected = this.options[this.selectedIndex];

		let empId = this.value;
		let empName = selected.getAttribute('data-name');

		document.getElementById('employee_id').value = empId ? empId : '';
		document.getElementById('employee_name').value = empName ? empName : '';

	});
</script>
