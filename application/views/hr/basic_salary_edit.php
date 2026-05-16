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
       Edit Basic Salary Structure 
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

	<?php foreach ($records as $row) : ?>

		<form id="main"
			method="post"
			action="<?php echo base_url() . 'index.php/'; ?>Hr/update_salary_structure"
			autocomplete="off"
			enctype="multipart/form-data">


			<!-- Employee + Effective Date -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-2 font-medium">
					Employee Name :
				</label>

				<div class="col-span-12 md:col-span-3">

					<?php foreach ($user_records as $s) {
						if ($row->emp_id == $s->employee_id) { ?>

							<input type="text"
								class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100"
								id="employee_id"
								name="employee_id"
								value="<?php echo $s->employee_name; ?>"
								tabindex="1"
								readonly />

							<input type="hidden"
								name="employee_id_hidden"
								value="<?php echo $s->employee_id ; ?>" />

					<?php }
					} ?>

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
						value="<?php echo date('Y-m-d', strtotime($row->effective_date) ?? '') ?>"
						tabindex="2">

						

						<input type="hidden"
							name="old_date"
							value="<?php echo date('d-m-Y', strtotime($row->effective_date) ?? '') ?>" />

						

					</div>

				</div>

			</div>



			<!-- Basic Salary -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-2 font-medium">
					Basic Salary :
				</label>

				<div class="col-span-12 md:col-span-3">

					<input tabindex="3"
						type="number"
						step="0.01"
						name="bsalary"
						id="bsalary"
						placeholder="enter basic salary"
						oninput="calculateGrossSalary()"
						value="<?php echo $row->basic_salary; ?>"
						min="0"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

				</div>

			</div>



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



							<!-- Existing Allowances -->
							<?php $i = 1;
							foreach ($details as $r) {
								if ($r->allowance_type == 'A') { ?>

									<tr id="allowance_row" class="border-b">

										<td class="px-3 py-2 border"><?php echo $i++; ?></td>

										<td class="px-3 py-2 border">

											<select tabindex="4"
												class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
												name="allowance_type[]"
												id="allowance_type">

												<option value="">Select</option>

												<?php foreach ($record1 as $a) {
													if ($a->allowance_type == 'A') { ?>

														<option <?php if ($r->allowance_id == $a->sno) echo 'selected'; ?>
															value="<?php echo $a->sno ?>">
															<?php echo $a->allowance_name; ?>
														</option>

												<?php }
												} ?>

											</select>

										</td>


										<td class="px-3 py-2 border">

											<input type="number"
												tabindex="5"
												step="0.01"
												id="a_amount"
												name="a_amount[]"
												oninput="calculate_a()"
												value="<?php echo $r->amount; ?>"
												class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

										</td>


										<td class="px-3 py-2 border">

											<button type="button"
												class="delete_row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
												🗑
											</button>

										</td>

									</tr>

							<?php }
							} ?>





						</tbody>
						<tfoot>
							<!-- Total Allowance -->
							<tr>

								<td colspan="3"
									class="px-3 py-2 border text-right font-medium">

									Total Allowance:

								</td>

								<td class="px-3 py-2 border">

									<input type="number"
										step="0.01"
										id="t_allowance"
										name="t_allowance"
										readonly
										value="<?php echo $row->total_allowances; ?>"
										class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">

								</td>

							</tr>


						</tfoot>

					</table>

				</div>

			</div>



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



							<!-- Existing Deductions -->
							<?php $j = 1;
							foreach ($details as $res) {
								if ($res->allowance_type == 'D') { ?>

									<tr id="deduction_row" class="border-b">

										<td class="px-3 py-2 border"><?php echo $j++; ?></td>

										<td class="px-3 py-2 border">

											<select tabindex="6"
												class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
												name="deduction_type[]"
												id="deduction_type">

												<option value="">Select</option>

												<?php foreach ($record1 as $d) {
													if ($d->allowance_type == 'D') { ?>

														<option <?php if ($res->allowance_id == $d->sno) echo 'selected'; ?>
															value="<?php echo $d->sno ?>">
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
												oninput="calculate_d()"
												value="<?php echo $res->amount ?>"
												class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

										</td>


										<td class="px-3 py-2 border">

											<button type="button"
												class="delete_row bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
												🗑
											</button>

										</td>

									</tr>

							<?php }
							} ?>






						</tbody>
						<tfoot>
							<!-- Total Deduction -->
							<tr>

								<td colspan="3"
									class="px-3 py-2 border text-right font-medium">

									Total Deduction:

								</td>

								<td class="px-3 py-2 border">

									<input type="number"
										step="0.01"
										id="t_deduction"
										name="t_deduction"
										readonly
										value="<?php echo $row->total_deductions; ?>"
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
						class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100"
						id="gross_salary"
						name="gross_salary"
						readonly
						value="<?php echo $row->gross_salary; ?>">

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
						class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><?php echo $row->rem; ?></textarea>

				</div>

			</div>



			<!-- Submit -->
			<div class="grid grid-cols-12 gap-4">

				<div class="col-span-12 md:col-span-2"></div>

				<div class="col-span-12 md:col-span-10">

					<input type="hidden" name="id" value="<?php echo $row->sid; ?>">

					<button type="submit"
						id="add"
						tabindex="9"
						class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">

						Submit

					</button>

				</div>

			</div>


		</form>

	<?php endforeach ?>

</div>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
	$(document).ready(function() {
		var allowance_i = <?php echo $i++; ?>;
		var deduction_i = <?php echo $j++; ?>;
		$(".add_row_allowance").click(function() {

			var newRow = "<tr class='border-b'>" +

				"<td class='px-3 py-2 border'>" + allowance_i + "</td>" +

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

				"<td class='px-3 py-2 border'>" + deduction_i + "</td>" +

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
