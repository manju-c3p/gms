<style type="text/css">
	.select2Width {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		max-width: 240px !important;
		min-width: 240px !important;
	}
</style>

<div class="bg-white shadow rounded-xl p-6">

<div class="flex justify-between items-center mb-4">

    <!-- Caption -->
    <h2 class="text-xl font-semibold text-gray-800">
       Add Basic Salary Structure 
    </h2>

    <!-- Add Basic Salary Button -->
    <a href="<?php echo base_url('index.php/Hr/view_salary_structure_list'); ?>"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow">

        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4"/>

        </svg>

       List Basic Salary

    </a>

</div>

	<form id="main"
		method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/add_salary_structure_data"
		autocomplete="off"
		enctype="multipart/form-data">


		<!-- Employee + Effective Date -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 font-medium">
				Employee Name <span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<select tabindex="1"
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm select2"
					id="employee_id"
					name="employee_id"
					required>

					<option value="">Select</option>

					
					<?php foreach ($user_records as $s) { ?>

						<option  value="<?php echo $s->employee_id  ?>">
							<?php echo $s->employee_name; ?>
						</option>

						

					<?php } ?>

				</select>

			</div>


			<label class="col-span-12 md:col-span-2 font-medium">
				Effective Date :
			</label>

			<div class="col-span-12 md:col-span-3">

				<div class="flex">

					<input type="date"
						class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm datepicker1"
						id="effctive_date"
						name="effctive_date"
						value="<?php echo date('Y-m-d') ?>"
						tabindex="2">

					<!--  -->

				</div>

			</div>

		</div>


		<!-- Basic Salary -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 font-medium">
				Basic Salary : <span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<input tabindex="3"
					type="number"
					step="0.01"
					name="bsalary"
					id="bsalary"
					placeholder="Enter basic salary"
					oninput="calculateGrossSalary()"
					min="0"
					required
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

			</div>

		</div>


		<!-- Allowance Divider -->
		<hr class="my-6 border-gray-300">


		<!-- Allowance Table -->
		<div class="mb-6">

			<label class="block font-medium mb-2">
				Allowance:
			</label>

			<div class="overflow-x-auto">

				<table class="min-w-full border border-gray-200 rounded-lg text-sm" id="allowance">

					<tbody>

						<tr class="bg-gray-100 font-semibold">
							<th class="px-3 py-2 border">Sr.no</th>
							<th class="px-3 py-2 border">Allowance Type</th>
							<th class="px-3 py-2 border">Amount</th>
							<th class="px-3 py-2 border">
								Action
								<button type="button"
									class="add_row_allowance bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs ml-2">
									+
								</button>
							</th>
						</tr>


						<tr id="allowance_row">

							<td class="px-3 py-2 border">1</td>

							<td class="px-3 py-2 border">

								<select tabindex="4"
									class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm allowance_type"
									name="allowance_type[]"
									id="allowance_type">

									<option value="">Select</option>

									<?php foreach ($record1 as $a) {
										if ($a->allowance_type == 'A') { ?>

											<option value="<?php echo $a->sno ?>">
												<?php echo $a->allowance_name; ?>
											</option>

									<?php }
									} ?>

								</select>

							</td>

							<td class="px-3 py-2 border">

								<input type="number"
									step="0.01"
									id="a_amount"
									name="a_amount[]"
									tabindex="5"
									oninput="calculate_a()"
									min="0"
									class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

							</td>

							<td class="px-3 py-2 border">

								<button type="button"
									class="delete_row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
									🗑
								</button>

							</td>

						</tr>


						


					</tbody>
					<tfoot>

					<!-- Total Allowance -->
						<tr>

							<td colspan="3" class="px-3 py-2 border text-right font-medium">
								Total Allowance:
							</td>

							<td class="px-3 py-2 border">

								<input type="number"
									step="0.01"
									id="t_allowance"
									name="t_allowance"
									readonly
									class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">

							</td>

						</tr>

					</tfoot>

				</table>

			</div>

		</div>



		<!-- Deduction Divider -->
		<hr class="my-6 border-gray-300">


		<!-- Deduction Table -->
		<div class="mb-6">

			<label class="block font-medium mb-2">
				Deduction:
			</label>

			<div class="overflow-x-auto">

				<table class="min-w-full border border-gray-200 rounded-lg text-sm" id="deduction">

					<tbody>

						<tr class="bg-gray-100 font-semibold">

							<th class="px-3 py-2 border">Sr.no</th>
							<th class="px-3 py-2 border">Deduction Type</th>
							<th class="px-3 py-2 border">Amount</th>
							<th class="px-3 py-2 border">
								Action
								<button type="button"
									class="add_row_deduction bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs ml-2">
									+
								</button>
							</th>

						</tr>


						<tr id="deduction_row">

							<td class="px-3 py-2 border">1</td>

							<td class="px-3 py-2 border">

								<select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm deduction_type"
									name="deduction_type[]"
									id="deduction_type"
									tabindex="6">

									<option value="">Select</option>

									<?php foreach ($record1 as $d) {
										if ($d->allowance_type == 'D') { ?>

											<option value="<?php echo $d->sno ?>">
												<?php echo $d->allowance_name; ?>
											</option>

									<?php }
									} ?>

								</select>

							</td>


							<td class="px-3 py-2 border">

								<input type="number"
									step="0.01"
									id="d_amount"
									name="d_amount[]"
									tabindex="7"
									oninput="calculate_d()"
									min="0"
									class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

							</td>


							<td class="px-3 py-2 border">

								<button type="button"
									class="delete_row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
									🗑
								</button>

							</td>

						</tr>



					</tbody>
					<tfoot>
						
						<!-- Total Deduction -->
						<tr>

							<td colspan="3" class="px-3 py-2 border text-right font-medium">
								Total Deduction:
							</td>

							<td class="px-3 py-2 border">

								<input type="number"
									step="0.01"
									id="t_deduction"
									name="t_deduction"
									readonly
									class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">

							</td>

						</tr>



					</tfoot>

				</table>

			</div>

		</div>



		<!-- Gross Salary -->
		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-2 font-medium">
				Gross Salary :
			</label>

			<div class="col-span-12 md:col-span-4">

				<input type="text"
					id="gross_salary"
					name="gross_salary"
					readonly
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">

			</div>

		</div>



		<!-- Remarks -->
		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-2 font-medium">
				Remarks :
			</label>

			<div class="col-span-12 md:col-span-6">

				<textarea id="remark"
					tabindex="8"
					name="remark"
					rows="2"
					placeholder="remark"
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></textarea>

			</div>

		</div>



		<!-- Submit -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-2"></div>

			<div class="col-span-12 md:col-span-10">

				<button type="submit"
					tabindex="9"
					id="add"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">

					Submit

				</button>

			</div>

		</div>


	</form>

</div>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
	$(document).ready(function() {
		var allowance_i = 1;
		var deduction_i = 1;

		$(".add_row_allowance").click(function() {

			var newRow = "<tr class='border-b'>" +

				"<td class='px-3 py-2 border'>" + (allowance_i + 1) + "</td>" +

				"<td class='px-3 py-2 border'>" +

				"<select tabindex='4' class='w-full border border-gray-300 rounded-lg px-3 py-2 text-sm allowance_type' name='allowance_type[]' required>" +

				"<option value=''>Select</option>";

			<?php foreach ($record1 as $a) {
				if ($a->allowance_type == 'A') { ?>

					newRow += "<option value='<?php echo $a->sno ?>'><?php echo $a->allowance_name; ?></option>";

			<?php }
			} ?>

			newRow += "</select></td>" +

				"<td class='px-3 py-2 border'>" +

				"<input type='number' step='0.01' id='a_amount_" + allowance_i + "' name='a_amount[]' oninput='calculate_a()' min='0' class='w-full border border-gray-300 rounded-lg px-3 py-2 text-sm'>" +

				"</td>" +

				"<td class='px-3 py-2 border'>" +

				"<button type='button' class='delete_row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs' title='Delete'>🗑</button>" +

				"</td>" +

				"</tr>";

			$('#allowance tbody').append(newRow);

			allowance_i++;

			// Recalculate Total allowances
			updateTotalAllowance();

			calculateGrossSalary();

		});



		$(".add_row_deduction").click(function() {

			var newRow = "<tr class='border-b'>" +

				"<td class='px-3 py-2 border'>" + (deduction_i + 1) + "</td>" +

				"<td class='px-3 py-2 border'>" +

				"<select tabindex='6' class='w-full border border-gray-300 rounded-lg px-3 py-2 text-sm deduction_type' name='deduction_type[]' required>" +

				"<option value=''>Select</option>";

			<?php foreach ($record1 as $d) {
				if ($d->allowance_type == 'D') { ?>

					newRow += "<option value='<?php echo $d->sno ?>'><?php echo $d->allowance_name; ?></option>";

			<?php }
			} ?>

			newRow += "</select></td>" +

				"<td class='px-3 py-2 border'>" +

				"<input type='number' step='0.01' id='d_amount_" + deduction_i + "' name='d_amount[]' oninput='calculate_d()' min='0' class='w-full border border-gray-300 rounded-lg px-3 py-2 text-sm'>" +

				"</td>" +

				"<td class='px-3 py-2 border'>" +

				"<button type='button' class='delete_row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs' title='Delete'>🗑</button>" +

				"</td>" +

				"</tr>";

			$('#deduction tbody').append(newRow);

			deduction_i++;

			// Recalculate total deduction
			updateTotalDeduction();

			calculateGrossSalary();

		});

		

		$(document).on('click', '.delete_row', function() {
			var table_id = $(this).closest('table').attr('id');
			var rowCount = $('#' + table_id + ' tbody tr').length;
			if (rowCount > 1) {
				$(this).closest('tr').remove();
				if (table_id == 'allowance') {
					allowance_i--;
					updateTotalAllowance();
				} else if (table_id == 'deduction') {
					deduction_i--;
					updateTotalDeduction();
				}
			} else {
				alert("At least one row is required.");
			}
			calculateGrossSalary(); // Call the function to recalculate gross salary
		});

		function updateTotalAllowance() {
			var totalAllowance = 0;
			$('#allowance tbody tr').each(function() {
				var amount = parseFloat($(this).find('td:eq(2) input').val()) || 0;
				totalAllowance += amount;
			});
			$('#t_allowance').val(totalAllowance.toFixed(2));
			calculateGrossSalary(); // Call the function to recalculate gross salary
		}

		function updateTotalDeduction() {
			var totalDeduction = 0;
			$('#deduction tbody tr').each(function() {
				var amount = parseFloat($(this).find('td:eq(2) input').val()) || 0;
				totalDeduction += amount;
			});
			$('#t_deduction').val(totalDeduction.toFixed(2));
			calculateGrossSalary(); // Call the function to recalculate gross salary
		}

	});

	function calculate_d() {
		var totalDeduction = 0;
		$("input[name='d_amount[]']").each(function() {
			totalDeduction += parseFloat($(this).val()) || 0;
		});
		$('#t_deduction').val(totalDeduction.toFixed(2));
		calculateGrossSalary(); // Call the function to recalculate gross salary
	}

	function calculate_a() {
		var totalAllowance = 0;
		$("input[name='a_amount[]']").each(function() {
			totalAllowance += parseFloat($(this).val()) || 0;
		});
		$('#t_allowance').val(totalAllowance.toFixed(2));
		calculateGrossSalary(); // Call the function to recalculate gross salary
	}

	function calculateGrossSalary() {
		
		var basicSalary = parseFloat(document.getElementById("bsalary").value);
		var totalAllowance = parseFloat($('#t_allowance').val()) || 0;
		var totalDeduction = parseFloat($('#t_deduction').val()) || 0;

		var grossSalary = basicSalary + totalAllowance - totalDeduction;

		document.getElementById("gross_salary").value = grossSalary.toFixed(2);
	}
</script>
