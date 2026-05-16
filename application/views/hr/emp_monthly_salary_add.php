<?php $this->load->helper('hr_helper'); ?>

<style>
	/* keep your existing custom styles */
	#datatable th {
		padding: 10px;
		font-size: 13px;
		background-color: #f2f2f2;
		padding-left: 25px;
	}

	#datatable {
		width: 2200px !important;
	}

	table.dataTable {
		margin: 0 !important;
	}

	.dataTables_wrapper {
		width: 100%;
	}

	#datatable input[type="text"],
	#datatable input[type="number"] {
		padding: 6px;
		font-size: 12px;
		width: 140px;
		box-sizing: border-box;
	}

	#remark {
		width: 180px;
		padding: 6px;
		font-size: 12px;
		height: 28px;
	}

	.table-scroll {
		max-height: 400px;
		overflow-y: auto;
		overflow-x: auto;
	}

	#datatable {
		width: 100%;
		border-collapse: collapse;
	}

	#datatable th,
	#datatable td {
		border: 1px solid #ddd;
		padding: 6px;
		text-align: left;
	}
</style>


<div class="bg-white shadow rounded-lg p-4">

	<div class="flex justify-between items-center mb-4">

		<!-- Caption -->
		<h2 class="text-xl font-semibold text-gray-800">
			Add Monthly Salary
		</h2>

		<!-- Add Basic Salary Button -->
		<a href="<?php echo base_url('index.php/Hr/view_emp_monthly_salary_list'); ?>"
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
					d="M12 4v16m8-8H4" />

			</svg>

			List Basic Salary

		</a>

	</div>


	<!-- FORM 1 -->
	<form id="main" method="post"
		action="<?php echo base_url() . 'index.php/Hr/add_monthly_salary_data'; ?>"
		autocomplete="off"
		enctype="multipart/form-data">

		<div class="flex flex-wrap items-center gap-4 mb-4">

			<!-- Select Month -->
			<label class="w-full md:w-auto font-medium text-sm">
				Select Month <span class="text-red-500">*</span>
			</label>

			<div class="w-full md:w-48">
				<input type="month"
					id="effective_date"
					name="effective_date"
					value="<?php echo date('Y-m', strtotime($effective_date)); ?>"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:ring focus:ring-blue-200">
			</div>

			<!-- Go Button -->
			<div>
				<input type="submit"
					id="view"
					name="go"
					value="Go"
					class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-1 rounded shadow">
			</div>

		</div>

	</form>


	<!-- FORM 2 -->
	<form id="salaryForm" method="post"
		action="<?php echo base_url() . 'index.php/Hr/add_emp_monthly_salary'; ?>"
		autocomplete="off"
		enctype="multipart/form-data">

		<input type="hidden"
			id="effective_date_hidden"
			name="effective_date_hidden"
			value="<?php echo date('M-Y', strtotime($effective_date)); ?>">


		<!-- TABLE -->
		
		<!-- <div style="display:block; width:100%;"> -->
<div class="w-full overflow-x-auto">
			<table id="datatable" class="min-w-max border border-gray-200 text-sm text-left">
			<!-- <table id="datatable" class="border border-gray-200 text-sm text-left"> -->

				<thead class="bg-gray-100 text-gray-700">
					<tr>
						<th rowspan="2" class="border px-3 py-2">Sr No</th>
						<th rowspan="2" class="border px-3 py-2 w-5">
							<input type="checkbox" id="header-checkbox" onclick="toggleAllCheckbox()">&nbsp;
						</th>
						<th rowspan="2" class="border px-3 py-2">Employee Code</th>
						<th rowspan="2" class="border px-3 py-2">Employee Name</th>
						<!-- <th rowspan="2" class="border px-3 py-2">Designation</th> -->
						<th rowspan="2" class="border px-3 py-2">Department</th>
						<th rowspan="2" class="border px-3 py-2">Visa Status</th>
						<!-- <th rowspan="2" class="border px-3 py-2">Payment Mode</th> -->
						<th rowspan="2" class="border px-3 py-2">Basic Salary</th>
						<th rowspan="2" class="border px-3 py-2 w-20">Working Days<br>(Month)</th>
						<th rowspan="2" class="border px-3 py-2">Total Leave</th>
						<th rowspan="2" class="border px-3 py-2">Allowed<br>Paid Leave</th>
						<th rowspan="2" class="border px-3 py-2">Used Paid<br>Leave</th>
						<th rowspan="2" class="border px-3 py-2">Present Days</th>
						<th rowspan="2" class="border px-3 py-2">Company<br>Holiday</th>

						<th rowspan="2" class="border px-3 py-2">Payment Days</th>
						<th rowspan="2" class="border px-3 py-2">CompOff Days</th>

						<!-- <th colspan="3" class="border px-3 py-2 text-center">Overtime Earnings</th> -->

						<th rowspan="2" class="border px-3 py-2">Sales Incentve</th>
						<th rowspan="2" class="border px-3 py-2">Monthly Allowances</th>

						<th rowspan="2" class="border px-3 py-2">Gross Pay</th>

						<th rowspan="2" class="border px-3 py-2">Monthly Deduction</th>
						<th rowspan="2" class="border px-3 py-2 hidden">Earned Salary</th>

						<th rowspan="2" class="border px-3 py-2">Advance Taken</th>

						
						<th rowspan="2" class="border px-3 py-2">Net Pay</th>
						<th rowspan="2" class="border px-3 py-2">Remarks</th>
					</tr>

					<!-- <tr class="bg-gray-50">
							<th class="border px-3 py-2">OT Rate</th>
							<th class="border px-3 py-2">OT Hrs</th>
							<th class="border px-3 py-2">Over Time</th>
						</tr> -->
				</thead>

				<tbody class="text-gray-700">
					<?php if (!empty($records)): ?>
						<?php $i = 1;
						// $p_days = 0;
						// $a_days = 0;
						foreach ($records as $row) { ?>

							<tr>
								<td>
									<?php echo $i;
									?>
								</td>
								<td>
									<input type="checkbox" id="checkbox<?php echo $i ?>" name="checkbox[]" class="checkbox"
										value="<?php echo $row->employee_id; ?>" onclick="handleCheckboxClick(<?php echo $i; ?>)">
								</td>
								<td>
									<?php echo $row->employee_code; ?>
								</td>
								<td>

									<?php echo $row->employee_name; ?>
									<input type="hidden" id="nuser_id<?php echo $i ?>" name="nuser_id[]"
										value="<?php echo $row->employee_id; ?>">
								</td>

								<td>
									<?php echo $row->department_name; ?>
								</td>
								<td>
									<?php echo $row->posession; ?>
								</td>


								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="basic_salary[]" id="basic_salary<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3'
											value="<?php echo $row->basic_salary; ?>" style="width: 100px;" readonly>
									</div>
								</td>
								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="working_days[]" id="working_days<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3' style="width: 70px;"
											value="<?php echo $days_in_month; ?>" readonly>


									</div>
								</td>

								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="leave_days[]" id="leave_days<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3'
											value="<?php echo $row->absent_count ?>" style="width: 70px;" readonly>
									</div>
								</td>
								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="paid_leave[]" id="paid_leave<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3'
											value="<?php echo $row->paid_days - $row->use_paid_leave; ?>" style="width: 70px;"
											readonly>
									</div>
								</td>
								<td>
									<?php if ($row->paid_days > 0) { ?>
										<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
											<input type="number" name="usep_leave[]" id="usep_leave<?php echo $i; ?>"
												class="form-control form-control-sm bg-soft-gray" tabindex='3' readonly
												value="<?php echo $row->paid_leave_count; ?>" style="width: 70px;" min="0"
												onblur="validateInput(<?php echo $row->absent_count; ?>, <?php echo $i; ?>); calculate_amount(<?php echo $i; ?>)">

										</div>
									<?php } else { ?>
										<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
											<input type="number" name="usep_leave[]" id="usep_leave<?php echo $i; ?>"
												class="form-control form-control-sm bg-soft-gray" tabindex='3'
												value="<?php echo $row->paid_leave_count; ?>" style="width: 70px;" min="0"
												onblur="calculate_amount(<?php echo $i; ?>)" readonly>
										</div>
									<?php } ?>
								</td>


								<td>

									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" step="any" name="present_days[]" id="present_days<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3'
											value="<?php echo $row->present_count; ?>" readonly style="width: 70px;">
									</div>
								</td>
								<td>

									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="holiday_days[]" id="holiday_days<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3'
											value="<?php echo $holiday_count; ?>" readonly style="width: 70px;">
									</div>
								</td>
								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" step="any" name="payment_days[]" id="payment_days<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3' value="0"
											style="width: 90px;">

										<?php if ($row->compoff_count > 0) { ?>
											<span style="color:red;"><?php echo 'Comp Off:' . $row->compoff_count; ?></span>

										<?php } ?>
									</div>
								</td>



								<td>
									<input type="number" name="comp_off[]" id="comp_off<?php echo $i ?>"
										class="form-control form-control-sm bg-soft-gray" tabindex='3'
										value="<?php echo $row->compoff_count; ?>" style="width: 90px;">
								</td>



								<td>
									<?php echo "Incentive"; ?>
								</td>



								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="total_allowances[]" id="total_allowances<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3'
											value="<?php echo $row->total_allowances; ?>" onchange="calculate_amount(<?php echo $i; ?>)" readonly style="width: 100px;">
									</div>
								</td>

								<td>
									<!-- value="<?php echo $row->gross_salary; ?>" -->
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="gross_salary[]" id="gross_salary<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3' value="" readonly
											style="width: 100px;">
									</div>
								</td>


								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="total_deduction[]" id="total_deduction<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3'
											value="<?php echo $row->total_deductions; ?>" onchange="calculate_amount(<?php echo $i; ?>)" readonly style="width: 100px;">
									</div>
								</td>
								<td class="hidden">
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="earn_salary[]" id="earn_salary<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray" tabindex='3' readonly
											style="width: 100px;">
									</div>
								</td>
								<td>
									<input type="number" name="salary_advance[]" id="salary_advance<?php echo $i ?>"
										class="form-control form-control-sm bg-soft-gray" tabindex='3'
										value="<?php echo $row->advance_taken; ?>" style="width: 90px;">
										<input type="hidden" name="advance_taken[]" value="<?php echo $row->advance_taken; ?>">
								</td>

								
								<td>
									<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
										<input type="number" name="net_pay[]" id="net_pay<?php echo $i ?>"
											class="form-control form-control-sm bg-soft-gray avarage_total avarage_total<?php echo $i ?>"
											tabindex='3' value="0" readonly style="width: 100px;">
									</div>
								</td>
								<td>
									<div class="col-sm-6">
										<textarea id="remark<?php echo $i; ?>" name="remark[]" rows="1"
											placeholder="remark"></textarea>
									</div>
								</td>

							</tr>
						<?php $i++;
						} ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>


		<!-- ACCOUNT ENTRY -->
		<hr class="my-6 border-gray-300">

		<h6 class="bg-blue-50 text-blue-900 px-4 py-2 font-semibold border-l-4 border-blue-600 rounded shadow inline-block">
			Account Entry
		</h6>


		<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

			<!-- DEBIT -->
			<table class="w-full border border-gray-300 rounded">

				<thead class="bg-gray-100">

					<tr>
						<th class="border px-3 py-2 text-blue-800">Debit Entry (Dr)</th>
						<th class="border px-3 py-2 text-blue-800">Debit Amount (AED)</th>
					</tr>

				</thead>

				<tbody>

					<tr>

						<td class="border px-2 py-1">

							<select id="inv_debtor0"
								name="inv_debtor[]"
								class="w-full border border-gray-300 rounded px-2 py-1 text-sm">

								<option value="">Select</option>

								<?php foreach ($sundry_detors_records as $a): ?>
									<!--salary expenses account_id = 2887 -->
									<option value="<?php echo $a->account_id; ?>"

										<?php 
										// if ($a->account_id == 2887) echo 'selected';
										if ($a->account_id == 2947) echo 'selected';
										?>
										
										>
										<?php echo $a->account_name; ?>

									</option>

								<?php endforeach; ?>

							</select>

						</td>

						<td class="border px-2 py-1">

							<input type="number"
								id="inv_dr_amount0"
								name="inv_dr_amount[]"
								readonly
								class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-sm">

						</td>

					</tr>

				</tbody>

			</table>


			<!-- CREDIT -->
			<table class="w-full border border-gray-300 rounded">

				<thead class="bg-gray-100">

					<tr>
						<th class="border px-3 py-2 text-blue-800">Credit Entry (Cr)</th>
						<th class="border px-3 py-2 text-blue-800">Credit Amount (AED)</th>
					</tr>

				</thead>

				<tbody>

					<tr>

						<td class="border px-2 py-1">

							<select id="inv_creditor0"
								name="inv_creditor[]"
								class="w-full border border-gray-300 rounded px-2 py-1 text-sm">

								<option value="">Select</option>

								<?php foreach ($credit_records as $d): ?>
								<!--salary payables account_id == 2886 -->
									<option value="<?php echo $d->account_id; ?>"
										<?php 
										// if ($d->account_id == 2886) echo 'selected'; 
										if ($d->account_id == 2946) echo 'selected'; 
										?>
										>

										<?php echo $d->account_name; ?>

									</option>

								<?php endforeach; ?>

							</select>

						</td>

						<td class="border px-2 py-1">

							<input type="number"
								id="inv_cr_amount0"
								name="inv_cr_amount[]"
								readonly
								class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-sm">

						</td>

					</tr>
					<!-- ================================================= -->


					<tr>

						<td class="border px-2 py-1">

							<select id="inv_creditor1"
								name="inv_creditor[]"
								class="w-full border border-gray-300 rounded px-2 py-1 text-sm">

								<option value="">Select</option>

								<?php foreach ($credit_records as $d): ?>
								<!--salary payables account_id == 2886 -->
									<option value="<?php echo $d->account_id; ?>"
										<?php 
										// if ($d->account_id == 2899) echo 'selected'; 
										if ($d->account_id == 2952) echo 'selected'; 
										?>
										>

										<?php echo $d->account_name; ?>

									</option>

								<?php endforeach; ?>

							</select>

						</td>

						<td class="border px-2 py-1">

							<input type="number"
								id="inv_cr_amount1"
								name="inv_cr_amount[]"
								readonly
								class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-sm">

						</td>

					</tr>

					<!-- =================================================================== -->

				</tbody>

			</table>

		</div>


		<!-- SUBMIT -->
		<div class="mt-6">

			<input type="hidden" name="empid" value="<?php echo $user_id; ?>">
			<input type="hidden" name="effective_date" value="<?php echo $effective_date; ?>">

			<button type="submit"
				id="add"
				class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">

				Generate Monthly Salary

			</button>

		</div>

	</form>

</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
	$(document).ready(function() {

		if ($.fn.DataTable.isDataTable('#datatable')) {
			$('#datatable').DataTable().destroy();
		}

		$('#datatable').DataTable({
			scrollY: 400,
			scrollX: true,
			scrollCollapse: true,
			paging: false,
			searching: true,
			ordering: false,
			autoWidth: false
		});

	});


	// Function to toggle all checkboxes
	function toggleAllCheckbox() {
		const headerCheckbox = document.getElementById('header-checkbox');
		const isChecked = headerCheckbox.checked;

		document.querySelectorAll('.checkbox').forEach(checkbox => {
			checkbox.checked = isChecked;
			// Calculate amounts if the checkbox is checked
			if (isChecked) {
				calculateAmountForCheckbox(checkbox.id.replace('checkbox', '')); // Pass index
			} else {
				resetCalculation(checkbox.id.replace('checkbox', '')); // Reset if unchecked
			}
		});
	}

	// Handle individual checkbox click
	function handleCheckboxClick(index) {
		
		const checkbox = document.getElementById("checkbox" + index);
		const headerCheckbox = document.getElementById('header-checkbox');
		if (checkbox.checked) {
			calculateAmountForCheckbox(index); // Call calculation only if checked

		} else {
			resetCalculation(index); // Reset calculation if unchecked
			headerCheckbox.checked = false;
		}
	}

	// Function to calculate amount for a specific checkbox
	function calculateAmountForCheckbox(index) {
		// Call your calculation function here
		calculate_amount(index); // Assuming this function is defined elsewhere

	}

	// Function to reset calculation values for a specific index
	function resetCalculation(index) {
		// Reset any calculated values related to this index
		document.getElementById("payment_days" + index).value = 0; // Adjust according to your logic
		document.getElementById("gross_salary" + index).value = 0; // Adjust according to your logic
		document.getElementById("net_pay" + index).value = 0; // Adjust according to your logic
	}

	// Add event listener to handle the header-present checkbox
	document.getElementById('header-checkbox').addEventListener('change', toggleAllCheckbox);

	function calculate_amount123(append) {
		alert("erer");
		var working_days = parseFloat(document.getElementById("working_days" + append).value) || 0;
		var leave_days = parseFloat(document.getElementById("leave_days" + append).value) || 0;
		var present_days = parseFloat(document.getElementById("present_days" + append).value) || 0;
		var comp_off = parseFloat(document.getElementById("comp_off" + append).value) || 0;

		var holiday_days = parseFloat(document.getElementById("holiday_days" + append).value) || 0;

		var usep_leave = parseFloat(document.getElementById("usep_leave" + append).value) || 0;
		var basic_salary = parseFloat(document.getElementById("basic_salary" + append).value) || 0;
		var total_overtime = 0;
		var total_allowances = parseFloat(document.getElementById("total_allowances" + append).value) || 0;
		var extra_allowances = parseFloat(document.getElementById("extra_allowances" + append).value) || 0;


		var total_deduction = parseFloat(document.getElementById("total_deduction" + append).value) || 0;
		var extra_deduction = parseFloat(document.getElementById("extra_deduction" + append).value) || 0;

		// Calculate payment days
		if (present_days > 0 || comp_off > 0 || usep_leave > 0) {
			alert("loop");
			var pay_days = present_days + usep_leave + holiday_days + comp_off;


			// var p_d = pay_days - leave_days;


			document.getElementById("payment_days" + append).value = pay_days;



		}
		// Calculate salary
		var monthly_a = basic_salary + total_allowances;
		alert(monthly_a);

		var earn_sal = (monthly_a / working_days) * pay_days;
		alert(earn_sal);
		// var s_follow_n = working_days

		// var perday_salary = basic_salary / working_days;
		// var emp_salary = perday_salary * pay_days;

		var gross = earn_sal + total_overtime + extra_allowances;
		alert(gross);
		var netpay = (gross - extra_deduction - total_deduction).toFixed(2);
		alert(netpay);

		document.getElementById("earn_salary" + append).value = earn_sal;

		document.getElementById("gross_salary" + append).value = gross.toFixed(2);
		document.getElementById("net_pay" + append).value = netpay;
		updateTotal();

	}

	function gv(id) {
		let el = document.getElementById(id);
		return el ? parseFloat(el.value) || 0 : 0;
	}

	function calculate_amountold(i) {

		console.log("calc row", i);

		let working_days = gv("working_days" + i);
		let present_days = gv("present_days" + i);
		let comp_off = gv("comp_off" + i);
		let holiday_days = gv("holiday_days" + i);
		let usep_leave = gv("usep_leave" + i);

		let basic_salary = gv("basic_salary" + i);
		let allowances = gv("total_allowances" + i);
		let deductions = gv("total_deduction" + i);
		let salaryadvance = gv("salary_advance" + i);


		let pay_days = present_days + comp_off + holiday_days + usep_leave;

		let payEl = document.getElementById("payment_days" + i);
		if (payEl) payEl.value = pay_days;

		if (working_days === 0) return;

		let earned = ((basic_salary + allowances) / working_days) * pay_days;

		let gross = earned;
		let net = gross - deductions - salaryadvance;

		let e1 = document.getElementById("earn_salary" + i);
		if (e1) e1.value = earned.toFixed(2);

		let e2 = document.getElementById("gross_salary" + i);
		if (e2) e2.value = gross.toFixed(2);

		let e3 = document.getElementById("net_pay" + i);
		if (e3) e3.value = net.toFixed(2);

		updateTotal();


	}

	function calculate_amount(i) {

		console.log("calc row", i);

		let working_days = gv("working_days" + i);
		let present_days = gv("present_days" + i);
		let comp_off = gv("comp_off" + i);
		let holiday_days = gv("holiday_days" + i);
		let usep_leave = gv("usep_leave" + i);

		let basic_salary = gv("basic_salary" + i);
		let allowances = gv("total_allowances" + i);
		let deductions = gv("total_deduction" + i);
		let salaryadvance = gv("salary_advance" + i);

		// ✅ Payment days
		let pay_days = present_days + comp_off + holiday_days + usep_leave;

		let payEl = document.getElementById("payment_days" + i);
		if (payEl) payEl.value = pay_days;

		if (working_days === 0) return;

		// ✅ Earned Salary
		let earned = ((basic_salary + allowances) / working_days) * pay_days;

		// ✅ Gross
		let gross = earned;

		// ✅ Step 1: Available after deductions
		let available = gross - deductions;

		// ❗ Prevent negative
		if (available < 0) available = 0;

		// ✅ Step 2: Advance recovery (important)
		let advance_recovery = Math.min(salaryadvance, available);

		// ✅ Step 3: Net Pay
		let net = available - advance_recovery;

		// ✅ Set values
		let e1 = document.getElementById("earn_salary" + i);
		if (e1) e1.value = earned.toFixed(2);

		let e2 = document.getElementById("gross_salary" + i);
		if (e2) e2.value = gross.toFixed(2);

		let e3 = document.getElementById("net_pay" + i);
		if (e3) e3.value = net.toFixed(2);

		// ⭐ OPTIONAL (VERY USEFUL)
		let advRecEl = document.getElementById("advance_recovery" + i);
		if (advRecEl) advRecEl.value = advance_recovery.toFixed(2);

		updateTotal();
	}

	function validateInput(absentCount, index) {
		var inputField = document.getElementById("usep_leave" + index);
		var userValue = parseInt(inputField.value) || 0;

		if (userValue > absentCount) {

			alert("Please insert a value less than or equal to " + absentCount);


			inputField.value = 0;
		}
	}
</script>
<script>
	function searchTable() {
		// Get the value of the search input
		var input = document.getElementById('searchInput');
		var filter = input.value.toLowerCase();

		// Get the table and its rows
		var table = document.getElementById('datatable');
		var rows = table.getElementsByTagName('tr');

		// Loop through all table rows (except the first one, which is the header)
		for (var i = 1; i < rows.length; i++) {
			var cells = rows[i].getElementsByTagName('td');
			var found = false;

			// Loop through the cells in each row
			for (var j = 0; j < cells.length; j++) {
				if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
					found = true;
					break; // Exit the loop if a match is found
				}
			}

			// Toggle the row's visibility based on the search
			if (found) {
				rows[i].style.display = '';
			} else {
				rows[i].style.display = 'none';
			}
		}
	}
	///////////////////this tha javascript following cr dr total
	function updateTotal() {
    var total = 0;
	var totdiscount= 0;
	var gsal =0;
    var anyChecked = $('.checkbox:checked').length > 0;

    $('.checkbox').each(function() {

        let id = this.id.replace('checkbox', '');
        let amount = parseFloat($('#net_pay' + id).val()) || 0;
let gsalary = parseFloat($('#gross_salary' + id).val()) || 0;
		
		let disamt = parseFloat($('#salary_advance' + id).val()) || 0;
        if (anyChecked) {
            // ✅ Only checked rows
            if (this.checked) {
                total += amount;
				totdiscount += disamt;
				gsal += gsalary;

            }
        } else {
            // ✅ No checkbox selected → take all
            total += amount;
			totdiscount += disamt;
				gsal += gsalary;
        }

    });

    console.log("Corrected total:", total);

    $('#inv_dr_amount0').val(gsal.toFixed(2));
    $('#inv_cr_amount0').val(total.toFixed(2));
	 $('#inv_cr_amount1').val(totdiscount.toFixed(2));
}

	// function updateTotal() {
	// 	var total = 0;

	// 	$("input.avarage_total").each(function() {
	// 		var amount = parseFloat($(this).val());
	// 		if (!isNaN(amount)) {
	// 			total += amount;
	// 		}
	// 	});

	// 	console.log("Calculated total:", total);

	// 	$('#inv_dr_amount0').val(total.toFixed(2));
	// 	$('#inv_cr_amount0').val(total.toFixed(2));
	// }

	$(document).ready(function() {
		updateTotal();

		$(document).on('input', 'input.avarage_total', function() {
			updateTotal();
		});
	});
</script>
<script>
	$(window).on('load', function() {


		$('.checkbox').each(function() {
			let id = this.id.replace('checkbox', '');
			calculate_amount(id);
		});


	});
</script>
