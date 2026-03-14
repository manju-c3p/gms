
<!-- ===================================== -->
 <div class="bg-white shadow rounded-lg p-6">
	
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Employee Resignation
        </h2>

        <a href="<?php echo base_url('index.php/Hr/view_emp_regignation_list'); ?>"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
            <i class="fa fa-list"></i>
            List
        </a>
    </div>

    <!-- Your form here -->


	<form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_emp_regignation_data" autocomplete="off" enctype="multipart/form-data">

		<div class="grid grid-cols-12 gap-4 mb-4 items-center">
			<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
				Employee Name:<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-5">
				<select tabindex="1"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2"
					id="employee_id" name="employee_id" required>

					<option value="">Select</option>

					<?php foreach ($user_records as $s) { ?>
						<option <?php if ($this->session->userdata('id') == $s->id) echo 'selected'; ?>
							value="<?php echo $s->id ?>">
							<?php echo $s->username; ?>
						</option>
					<?php } ?>

				</select>
			</div>
		</div>


		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
				Resignation Date:<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-5">
				<div class="flex items-center gap-2">

					<input type="date"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
						id="resignation_date"
						name="resignation_date"
						value="<?php echo date('d-m-Y') ?>"
						tabindex="2"
						required>

					

				</div>
			</div>

		</div>


		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
				Effective Last Working Date:<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-5">

				<div class="flex items-center gap-2">

					<input type="date"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
						id="last_working_date"
						name="last_working_date"
						value="<?php echo date('d-m-Y') ?>"
						tabindex="3"
						required>

				

				</div>

			</div>

		</div>


		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
				Total Notice Period Days:
				<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-5">

				<input type="text"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
					id="notice_days"
					name="notice_days"
					tabindex="4"
					required>

			</div>

		</div>


		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
				Resignation Reasons
				<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-5">

				<textarea id="reason"
					tabindex="5"
					name="reason"
					rows="2"
					placeholder="Resignation Reasons"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
					required></textarea>

			</div>

		</div>



		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
				Upload("jpeg","jpg","png","doc","pdf"):
			</label>

			<div class="col-span-12 md:col-span-8">

				<table class="min-w-full border border-gray-300 rounded text-sm" id="tab_logic">

					<tbody>

						<tr id="addr0" class="border-b">

							<td class="border border-gray-300 px-2 py-1">1</td>

							<td class="border border-gray-300 px-2 py-1">

								<div class="col-span-12 md:col-span-8">

									<input
										class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
										id="documents_res"
										name="documents_res[]"
										tabindex="6"
										type="file">

								</div>

							</td>


							<td class="border border-gray-300 px-2 py-1">

								<div class="grid grid-cols-12 gap-2">

									<div class="col-span-12 md:col-span-10">

										<select
											class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
											name="document_types[]"
											id="document_types">

											<option value="" selected disabled>
												Please select document type
											</option>

											<option value="Resignation Letter">Resignation Letter</option>
											<option value="Resignation Form">Resignation Form</option>
											<option value="MOHRE Cancellation Paper">MOHRE Cancellation Paper</option>
											<option value="Clearance Paper">Clearance Paper</option>
											<option value="Final Settlement Letter">Final Settlement Letter</option>
											<option value="Labor Cancellation">Labor Cancellation</option>
											<option value="Visa Cancellation">Visa Cancellation</option>
											<option value="Other">Other</option>

										</select>

									</div>

								</div>

							</td>


							<td class="border border-gray-300 px-2 py-1">

								<a id="add_row"
									title="Add"
									class="inline-flex items-center px-2 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer">

									<span class="fa fa-plus"></span>

								</a>


								<a id="delete_row"
									title="Delete"
									class="inline-flex items-center px-2 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700 cursor-pointer">

									<span class="fa fa-trash"></span>

								</a>

							</td>

						</tr>

						<tr id="addr1"></tr>

					</tbody>

				</table>

			</div>

		</div>



		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-2"></label>

			<div class="col-span-12 md:col-span-10">

				<button type="submit"
					tabindex="7"
					id="add"
					class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">

					Submit

				</button>

			</div>

		</div>


	</form>

</div>

<script>
	$(document).ready(function() {
		var i = 1;
		// Add new row
		$("#add_row").click(function() {
			$('#addr' + i).html(
				"<td>" + (i + 1) + "</td>" +
				"<td><div class='col-sm-8'><input class='form-control' id='documents_res" + i + "' name='documents_res[]' type='file'></div></td>" +
				"<td><div class='col-sm-10'>" +
				"<select class='form-select form-control-sm' name='document_types[]' id='document_types'>" +
				"<option value='' selected disabled>Please select document type</option>" +
				"<option value='Resignation Letter'>Resignation Letter</option>" +
				"<option value='Resignation Form'>Resignation Form</option>" +
				"<option value='MOHRE Cancellation Paper'>MOHRE Cancellation Paper</option>" +
				"<option value='Clearance Paper'>Clearance Paper</option>" +
				"<option value='Final Settlement Letter'>Final Settlement Letter</option>" +
				"<option value='Labor Cancellation'>Labor Cancellation</option>" +
				"<option value='Visa Cancellation'>Visa Cancellation</option>" +
				"<option value='Other'>Other</option>" +
				"</select>" +
				"</div></td>" +
				"<td><button type='button' class='btn btn-sm bg-blue remove_row' title='Delete row'><span class='fa fa-trash'></span></button></td>"
			);
			$('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
			i++;
		});

		// Row-wise delete on clicking trash icon
		$(document).on('click', '.remove_row', function() {
			if (confirm("Are you sure you want to delete this row?")) {
				$(this).closest('tr').remove();

				// Optional: Re-number rows after deletion
				$('#tab_logic tbody tr').each(function(index) {
					$(this).find('td:first').html(index + 1);
				});

				// Decrement row counter to keep adding rows correctly
				i = $('#tab_logic tbody tr').length - 1; // exclude last empty row
			}
		});

		// Initially hide the last empty row (addr1)
		$('#addr1').html('');
	});


	function calculate_total_days() {
		var startDateStr = document.getElementById('start_date').value;
		var endDateStr = document.getElementById('end_date').value;

		// Parse start date and end date in d-m-Y format
		var startDateArr = startDateStr.split('-');
		var endDateArr = endDateStr.split('-');

		var startDate = new Date(startDateArr[2], startDateArr[1] - 1, startDateArr[0]);
		var endDate = new Date(endDateArr[2], endDateArr[1] - 1, endDateArr[0]);

		const time = Math.abs(endDate - startDate);

		const days = Math.ceil(time / (1000 * 60 * 60 * 24));

		document.getElementById("total_date").value = days;
	}

	// Call calculate_total_days() when there is a change in start_date or end_date fields
	document.getElementById('start_date').addEventListener('input', calculate_total_days);
	document.getElementById('end_date').addEventListener('input', calculate_total_days);
</script>
