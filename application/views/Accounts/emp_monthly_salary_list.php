<div class="bg-white rounded-2xl shadow-sm p-6">

<!-- PAGE HEADER -->
	<div class="flex items-center justify-between mb-4">
		<h2 class="text-2xl font-semibold text-gray-800">
			Monthly Salary List
		</h2>

	
	</div>

	<div class="overflow-x-auto">
		<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Accounts/view_emp_monthly_salary"
			class="space-y-4" autocomplete="off" name="question" enctype="multipart/form-data">

			<div class="flex flex-wrap items-end gap-4">

				<div class="w-full md:w-64">
					<label class="block text-sm font-medium text-gray-700 mb-2">
						Month Date:
					</label>

					<div class="flex">
						<input type="month"
							class="w-full rounded-l-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 datepicker1"
							id="from" name="from"
							value="<?php echo date('Y-m', strtotime($from)); ?>">


					</div>
				</div>

				<div class="flex flex-wrap gap-2 ml-auto">

					<input type="submit" id="view" name="go" value="Go"
						onclick="return validate();"
						class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-medium cursor-pointer transition">

		</form>

		<form target="_blank"
			action="<?php echo base_url() . 'index.php/Hr/print_monthly_record/' ?>"
			id="ques1"
			method="post"
			name="ques1"
			class="inline-block">

			<input type="hidden" id="from" name="from"
				value="<?php echo $from; ?>">

			<input tabindex="6"
				type="submit"
				id="print"
				value="Print"
				class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl text-sm font-medium cursor-pointer transition" />
		</form>

		<form action="<?php echo base_url() . 'index.php/Hr/export_monthly_record/' ?>"
			id="ques1"
			method="post"
			name="ques1"
			class="inline-block">

			<input type="hidden" id="from" name="from"
				value="<?php echo $from; ?>">

			<input tabindex="7"
				type="submit"
				id="export"
				value="Export to excel"
				class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl text-sm font-medium cursor-pointer transition" />
		</form>

	</div>
</div>

</div>

<div class="mt-6 mb-4">
	<h4 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
		Select All
		<input type="checkbox"
			id="header-checkbox"
			onclick="toggleAllCheckbox()"
			class="w-4 h-4 rounded border-gray-300">
	</h4>
</div>

<form id="main"
	method="post"
	action="<?php echo base_url() . 'index.php/'; ?>Accounts/add_employee_payment_details"
	class="space-y-6"
	autocomplete="off"
	name="question"
	enctype="multipart/form-data">

	<div class="flex flex-wrap items-end gap-4">

		<div class="w-full md:w-72">
			<label class="block text-sm font-medium text-gray-700 mb-2">
				Payment Date
				<span class="text-red-500">*</span>
			</label>

			<div class="flex">
				<input type="date"
					class="w-full rounded-l-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 datepicker1"
					id="v_date"
					name="v_date"
					value="<?php echo date('Y-m-d') ?>"
					required
					tabindex=1>

				<!-- <div class="bg-gray-100 border border-l-0 border-gray-300 rounded-r-xl px-3 flex items-center">
					<i class="fa fa-calendar text-gray-500"></i>
				</div> -->
			</div>
		</div>

	</div>

	<div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">

		<table id="datatable"
			class="min-w-full divide-y divide-gray-200">

			<thead class="bg-gray-100">

				<tr class="text-sm font-semibold text-gray-700">

					<th class="px-4 py-3 text-left">Srn</th>
					<th class="px-4 py-3 text-left">Employee Name</th>
					<th class="px-4 py-3 text-left">Basic</th>
					<th class="px-4 py-3 text-left">Overtime</th>
					<th class="px-4 py-3 text-left">Allowances</th>
					<th class="px-4 py-3 text-left">Gross pay</th>
					<th class="px-4 py-3 text-left">Loans&Adv</th>
					<th class="px-4 py-3 text-left">Deductions</th>
					<th class="px-4 py-3 text-left">Net pay</th>
					<th class="px-4 py-3 text-left">Working Days</th>
					<th class="px-4 py-3 text-left">Total Leave</th>
					<th class="px-4 py-3 text-left">Present Days</th>
					<th class="px-4 py-3 text-left">Paid Leave</th>
					<th class="px-4 py-3 text-left">Payment Days</th>
					<th class="px-4 py-3 text-left">Total Overtime(hour)</th>
					<th class="px-4 py-3 text-left">Remarks</th>
					<th class="px-4 py-3 text-left">Action</th>

				</tr>

			</thead>

			<tbody class="divide-y divide-gray-100 bg-white text-sm text-gray-700">

				<?php
				$i = 1;
				$total_amount = 0;
				$total_deduction = 0;

				foreach ($records as $row) {

					if ($row->account_entry == 0) { ?>

						<tr class="hover:bg-gray-50 transition">

							<td class="px-4 py-3">
								<?php echo $i; ?>
							</td>

							<td class="px-4 py-3">

								<input type="checkbox"
									id="checkbox<?php echo $i ?>"
									name="checkbox[]"
									class="checkbox mr-2"
									value="<?php echo $i; ?>"
									onclick="handleCheckboxClick(<?php echo $i; ?>)">

								<?php echo $row->employee_name; ?>

								<input type='text'
									name='sid<?php echo $i ?>'
									value="<?php echo $row->sid; ?>" />

								<input type='text'
									name='user_id<?php echo $i ?>'
									value="<?php echo $row->employee_id; ?>" />

								<input type='text'
									name='account_id<?php echo $i ?>'
									value="<?php echo $row->account_id; ?>" />

								<!-- <input type='text'
									name='loan_amount<?php echo $i ?>'
									id="loan_amount<?php echo $i ?>"
									value="<?php echo $row->extra_deduction; ?>" /> -->

									<input type='text'
									name='loan_amount<?php echo $i ?>'
									id="loan_amount<?php echo $i ?>"
									value="<?php echo $row->net_salary; ?>" />

							</td>

							<td class="px-4 py-3">
								<?php
								echo $row->basic_salary;
								$salary_month = $row->salary_month;
								?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->overtime_amt; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->total_allowance; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->gross_salary; ?>
							</td>

							<td class="px-4 py-3">
								<?php
								echo $row->salary_advance_taken;
								$total_deduction += $row->salary_advance_taken;
								?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->total_deduction; ?>
							</td>

							<td class="px-4 py-3 font-semibold text-green-600">

								<?php
								echo $row->net_salary;
								$total_amount += $row->net_salary;
								?>

								<input type='hidden'
									name='tr_amount<?php echo $i ?>'
									id="tr_amount<?php echo $i ?>"
									value="<?php echo $row->net_salary; ?>"
									class="tr_amount" />

							</td>

							<td class="px-4 py-3">
								<?php echo $row->working_days; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->leave_days; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->present_days; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->paid_leave; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->payment_days; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->overtime; ?>
							</td>

							<td class="px-4 py-3">
								<?php echo $row->remark; ?>
							</td>

							<td class="px-4 py-3">

								<a href="<?php echo base_url() . 'index.php/Hr/print_monthly_payslip/' . $row->sid; ?>"
									title="Edit"
									target="_blank"
									class="text-blue-600 hover:text-blue-800 font-medium">
									Print Payslip
								</a>

							</td>

						</tr>

				<?php
						$i++;
					}
				}
				?>

			</tbody>

			<tfoot class="bg-gray-100">

				<tr class="font-semibold text-gray-800">

					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>

					<td class="px-4 py-3">
						<h5><?php echo $total_deduction; ?></h5>
					</td>

					<td class="px-4 py-3"></td>

					<td class="px-4 py-3 text-green-700">
						<h5><?php echo $total_amount; ?></h5>
					</td>

					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>
					<td class="px-4 py-3"></td>

				</tr>

			</tfoot>

		</table>

	</div>



	<div class="grid grid-cols-1 md:grid-cols-12 gap-4">

		<div class="md:col-span-1"></div>

		<div class="md:col-span-10">

			<div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">

				<table class="min-w-full divide-y divide-gray-200" id="dr_table">

					<thead class="bg-gray-100">

						<tr class="text-sm font-semibold text-gray-700">

							<th class="px-4 py-3 text-left" title="Item">
								Debit Account (Dr)
							</th>

							<th class="px-4 py-3 text-left" title="Item">
								Debit Amount
							</th>

							<th class="px-4 py-3 text-left w-[10%]">
								<!--<a id="dr_add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a>-->
							</th>

						</tr>

					</thead>

					<tbody id="dr_body" class="divide-y divide-gray-100 bg-white">

						<tr id='dr_addr0' class="hover:bg-gray-50 transition">

							<td class="px-4 py-3">

								<select class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 select2"
									id="debtor0"
									name="debtor[]"
									onchange="get_account_balance(0,'dr')"
									requird>

									<option value="">Select</option>

									<?php foreach ($sundry_detors_records as $row) {
										if ($row->group_no == 38) { ?>

											<option value="<?php echo $row->account_id; ?>"
												<?php 
												if ($row->account_id == 2886) echo 'selected'; 
												// if ($row->account_id == 2946) echo 'selected'; 
												?>

												>

												<?php echo $row->account_name; ?>


											</option>

									<?php
										}
									} ?>

								</select>

								<br>

								<label id='set_balancedr0' class="text-sm text-gray-600">
									Balance
								</label>

							</td>

							<td class="px-4 py-3">

								<input type="number"
									step='0.01'
									name="dr_amount[]"
									id="dr_amount0"
									class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 "
									requird
									min=0  onkeyup="calculate_grand_total()"
									>
									<!-- debit_sum -->

							</td>

							<td class="px-4 py-3">

								<!--<a id='delete_row1' title="Delete" onclick='remove_row_dr(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>-->

							</td>

						</tr>

						<tr id='dr_addr1'></tr>

					</tbody>

				</table>

			</div>

		</div>

	</div>


	<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-6">

		<div class="md:col-span-1"></div>

		<div class="md:col-span-10">

			<div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">

				<table class="min-w-full divide-y divide-gray-200" id="cr_table">

					<thead class="bg-gray-100">

						<tr class="text-sm font-semibold text-gray-700">

							<th class="px-4 py-3 text-left" title="Item">
								Credit Account (Cr)
							</th>

							<th class="px-4 py-3 text-left" title="Item">
								Credit Amount
							</th>

							<th class="px-4 py-3 text-left w-[10%]">
								<!--<a id="cr_add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a>-->
							</th>

						</tr>

					</thead>

					<tbody id="cr_body" class="divide-y divide-gray-100 bg-white">

						<tr id='cr_addr0' class="hover:bg-gray-50 transition">

							<td class="px-4 py-3">

								<select class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 select2"
									id="creditor0"
									name="creditor[]"
									onchange="get_account_balance(0,'cr')"
									requird>

									<option value="">Select</option>

									<?php foreach ($credit_records as $row) { ?>

										<option value="<?php echo $row->account_id; ?>">
											<?php echo $row->account_name; ?>
										</option>

									<?php } ?>

								</select>

								<br>

								<label id='set_balancecr0' class="text-sm text-gray-600">
									Balance
								</label>

							</td>

							<td class="px-4 py-3">

								<input type="number"
									step='0.01'
									name="cr_amount[]"
									id="cr_amount0"
									class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 credit_sum"
									requird
									min=0
									 onkeyup="calculate_grand_total()">

									 <!--  -->

							</td>

							<td class="px-4 py-3">

								<!--<a id='delete_row1' title="Delete" onclick='remove_row_cr(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>-->

							</td>

						</tr>

						<tr id='cr_addr1'></tr>

					</tbody>

				</table>

			</div>

		</div>

	</div>

	<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-6 items-center">

		<label class="md:col-span-2 text-sm font-medium text-gray-700">
			Credit Total
		</label>

		<div class="md:col-span-3">

			<input class="w-full rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm"
				id="debit_total"
				name="debit_total"
				type="text"
				value=""
				readonly>

		</div>

		<label class="md:col-span-2 text-sm font-medium text-gray-700">
			Debit Total
		</label>

		<div class="md:col-span-3">

			<input class="w-full rounded-xl border border-gray-300 bg-gray-100 px-3 py-2 text-sm"
				id="credit_total"
				name="credit_total"
				type="text"
				value=""
				readonly>

		</div>

	</div>

	<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-6">

		<label class="md:col-span-2 text-sm font-medium text-gray-700">
			Narration:
		</label>

		<div class="md:col-span-8">

			<textarea class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
				id="narration"
				name="narration">Salary for the month of <?php echo date('M-Y', strtotime($salary_month)); ?></textarea>

		</div>

	</div>

	<div class="mt-8 flex flex-wrap items-center gap-4">

		<input type="hidden"
			id="vtime"
			name="vtime"
			value="<?php echo date('h:i:s'); ?>" />

		<input type="hidden"
			id="invoiceID"
			name="invoiceID" />

		<button type="submit"
			class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl text-sm font-medium transition"
			onclick="return check_total();">

			Save

		</button>

		<button type="reset"
			class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-xl text-sm font-medium transition">

			Reset

		</button>

		<input id="check_dr_id"
			name="check_dr_id"
			type="hidden"
			value="">

	</div>
</form>


<script>
	$(document).ready(function() {
		get_account_balance(0, 'dr');
	});

	// Function to toggle all checkboxes
	function toggleAllCheckbox() {
		const headerCheckbox = document.getElementById('header-checkbox');
		const isChecked = headerCheckbox.checked;

		document.querySelectorAll('.checkbox').forEach(checkbox => {
			checkbox.checked = isChecked;
			// Calculate amounts if the checkbox is checked
			if (isChecked) {
				$(".tr_amount").addClass("debit_sum");
				calculate_grand_total(); // Pass index
			} else {
				$(".tr_amount").removeClass("debit_sum");
				calculate_grand_total(); // Reset if unchecked
			}
		});
	}

	// Handle individual checkbox click
	function handleCheckboxClick(index) {
		const checkbox = document.getElementById("checkbox" + index);
		if (checkbox.checked) {
			$("#tr_amount" + index).addClass("debit_sum");
			calculate_grand_total(index); // Call calculation only if checked
		} else {
			$("#tr_amount" + index).removeClass("debit_sum");
			calculate_grand_total(index); // Reset calculation if unchecked
		}
	}


	// Add event listener to handle the header-present checkbox
	document.getElementById('header-checkbox').addEventListener('change', toggleAllCheckbox);

	function get_account_balance(append_id, type) {
		if (type == 'dr')
			tmp = 'debtor';
		else
			tmp = 'creditor';

		var account_id = document.getElementById(tmp + append_id).value;
		var today = "<?php echo date('Y-m-d') ?>";
		$.ajax({
			url: "<?php echo site_url('Accounts/get_account_balance'); ?>",
			type: 'POST',
			data: {
				account_id: account_id,
				today: today
			},
			success: function(msg) {
				if (msg) {
					//alert(msg);
					document.getElementById('set_balance' + type + append_id).innerHTML = 'Balance: ' + msg;

				}
			}
		});
	}

	// function calculate_grand_total() {
	// 	// alert("dfjgd");
	// 	var i_value = 0;
	// 	i_total = 0;
	// 	$('.debit_sum').each(function() {
	// 		i_value = $(this).val();
	// 		if (i_value == '')
	// 			i_value = 0;
	// 		else
	// 			i_total += parseFloat(i_value);
	// 	});
	// 	if (isNaN(i_total)) var dr_total = 0;

	// 	document.getElementById("cr_amount0").value = parseFloat(i_total).toFixed(2);

	// 	var k_value = 0;
	// 	k_total = 0;
	// 	$('.credit_sum').each(function() {
	// 		k_value = $(this).val();
	// 		if (k_value == '')
	// 			k_value = 0;
	// 		else
	// 			k_total += parseFloat(k_value);
	// 	});
	// 	if (isNaN(k_total)) var cr_total = 0;

	// 	document.getElementById("dr_amount0").value = parseFloat(i_total).toFixed(2);
	// 	document.getElementById("debit_total").value = parseFloat(i_total).toFixed(2);
	// 	document.getElementById("credit_total").value = parseFloat(k_total).toFixed(2);
	// 	//check_total();
	// }

	function calculate_grand_total() {

	var i_value = 0;
	var i_total = 0;

	$('.debit_sum').each(function() {

		i_value = $(this).val();

		if (i_value == '')
			i_value = 0;
		else
			i_total += parseFloat(i_value);

	});

	if (isNaN(i_total))
		i_total = 0;

	// document.getElementById("cr_amount0").value =
	//  parseFloat(i_total).toFixed(2);

	var k_value = 0;
	var k_total = 0;

	$('.credit_sum').each(function() {

		k_value = $(this).val();

		if (k_value == '')
			k_value = 0;
		else
			k_total += parseFloat(k_value);

	});

	if (isNaN(k_total))
		k_total = 0;

	document.getElementById("debit_total").value = parseFloat(i_total).toFixed(2);
	document.getElementById("dr_amount0").value =	 parseFloat(i_total).toFixed(2);
	document.getElementById("credit_total").value = parseFloat(k_total).toFixed(2);
}

	function check_total() {
		var dr_total = $('#debit_total').val();
		var cr_total = $('#credit_total').val();

		if (parseFloat(cr_total) != parseFloat(dr_total)) {
			alert("Both debit total and credit total must match");
			return false;
		}
	}

	var i = 1;
	$("#dr_add_row").click(function() {
		$('#dr_addr' + i).html("<td><select class='form-select form-control-sm select2 select2Width' id='debtor" + i + "' name='debtor[]' onchange='get_account_balance(" + i + ",'dr')' requird><option value=''>Select Code</option><?php foreach ($sundry_detors_records as $s) {
																																																											if ($s->group_no == 37) { ?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name; ?></option><?php }
																																																																																						} ?></select><br><label id='set_balancedr" + i + "'>Balance</label></td><td><input type='number' step='0.01' name='dr_amount[]' id='dr_amount" + i + "' class='form-control form-control-sm debit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_dr(" + i + ");' id='delete_row1' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
		$('#dr_body tr:last').after('<tr id="dr_addr' + (i + 1) + '"></tr>');
		i++;
		$('.select2').select2({
			width: "220px"
		});
	});
	$("#delete_row1").click(function() {
		if (i > 1) {
			$("#dr_addr" + (i - 1)).html('');
			i--;
		}
	});

	var k = 1;
	$("#cr_add_row").click(function() {
		$('#cr_addr' + k).html("<td><select class='form-select form-control-sm select2 select2Width' id='creditor" + k + "' name='creditor[]'  onchange=get_account_balance(" + k + ",'cr') requird><option value=''>Select Code</option><?php foreach ($credit_records as $s) { ?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name; ?></option><?php } ?></select><br><label id='set_balancecr" + k + "'>Balance</label></td><td><input type='number' step='0.01' name='cr_amount[]' id='cr_amount" + k + "' class='form-control form-control-sm credit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_cr(" + k + ");' id='delete_row2' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
		$('#cr_body tr:last').after('<tr id="cr_addr' + (k + 1) + '"></tr>');
		k++;
		$('.select2').select2({
			width: "220px"
		});
	});
	$("#delete_row2").click(function() {
		if (k > 1) {
			$("#cr_addr" + (k - 1)).html('');
			i--;
		}
	});
</script>
