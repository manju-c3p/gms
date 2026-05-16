<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Payslip</title>

	<!-- Tailwind CSS -->
	<script src="https://cdn.tailwindcss.com"></script>

	<style>
		body {
			margin: 40px;
			font-size: 16px;
		}

		table {
			border: 1px solid black;
			border-collapse: collapse;
			font-size: 14px;
		}

		th,
		td {
			padding: 1px;
		}

		.header-line-thick {
			border-top: 4px solid #000;
		}

		.header-line-thin {
			border-top: 2px solid #000;
		}

		@media print {
			body {
				margin: 0;
			}

			.footer {
				position: fixed;
				bottom: 0;
				left: 0;
				right: 0;
				text-align: center;
			}

			.footer img {
				width: 100% !important;
				max-height: 120px;
				object-fit: contain;
			}
		}
	</style>
</head>

<body onload="window.print();" class="text-gray-900">

	<?php if (!empty($records)) : ?>
		<?php foreach ($records as $row) : ?>

			<div class="w-full">

				<!-- header -->
				<!-- PROFESSIONAL PRINT HEADER -->
				<!-- HEADER -->
				<div class="w-full border border-gray-300 p-4">


					<!-- ========================================== -->

					<!-- HEADER -->
					<div class="w-full p-4">

						<div class="flex justify-between items-center">

							<!-- LOGO LEFT -->
							<div class="w-1/4">
								<img src="<?= base_url('public/images/logocooling.png') ?>" class="h-16">
							</div>

							<!-- ADDRESS RIGHT -->
							<div class="w-3/4 text-sm leading-6 text-gray-800 text-right">
								<div class="font-semibold text-base">
									Cool Runnings Garage Co LLC
								</div>
								7 St, Al Quoz 3, Dubai, UAE <br>
								<span class="text-blue-700">www.coolrunningsgarage.com</span><br>
								info@coolrunningsgarage.com <br>
								Tel: +971 4 265 4887 <br>
								TRN: 104026094300003
							</div>

						</div>

					</div>


					<div class="header-line-thin"></div>
					<!-- PAYSLIP CAPTION -->
					<div class="w-full text-center">
						<div class="text-lg font-semibold ">
							Payslip
						</div>
					</div>
					<div class="header-line-thin"></div>
					<!-- CENTER HR -->

					<br>

					<!-- title -->


					<!-- general info -->
					<table border="0" style="font-size:18px;" width="100%" class="w-full">
						<tr>
							<td colspan="2">
								<div class="w-full">
									<table cellspacing="0" cellpadding="0" width="100%" class="w-full">
										<tr>
											<th class="text-left font-semibold text-gray-800 bg-gray-100 px-3 py-2 border border-gray-400">
												General Information
											</th>
										</tr>
									</table>
								</div>
							</td>
						</tr>

						<tr>
							<td>
								<div class="w-full">
									<table cellspacing="4" cellpadding="0" width="100%" height="80px"
										class="w-full border border-gray-500 text-[13px]">
										<tbody>

											<tr>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Employee Name:</th>
												<td class="px-3 py-1 text-gray-900"><?php echo $row->employee_name; ?></td>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Joining Date:</th>
												<td class="px-3 py-1 text-gray-900"><?php echo date('d-M-Y', strtotime($row->joining_date)); ?></td>
											</tr>

											<tr>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Employee Number:</th>
												<td class="px-3 py-1 text-gray-900"><?php echo $row->employee_code; ?></td>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Payment Month:</th>
												<td class="px-3 py-1 font-semibold text-gray-900"><?php echo date('M-Y', strtotime($row->salary_month)); ?></td>
											</tr>

											<tr>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Designation:</th>
												<td class="px-3 py-1 text-gray-900"><?php echo $row->designation_name; ?></td>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Department:</th>
												<td class="px-3 py-1 text-gray-900"><?php echo $row->department_name; ?></td>
											</tr>

											<tr>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Mobile No:</th>
												<td class="px-3 py-1 text-gray-900"><?php echo $row->mobile; ?></td>
												<th class="text-left font-medium text-gray-700 px-3 py-1">Email Id:</th>
												<td class="px-3 py-1 text-gray-900"><?php echo ''; ?></td>
											</tr>

										</tbody>
									</table>
								</div>
							</td>
						</tr>

						<tr>
							<td>
								<div class="w-full">
									<table cellspacing="0" cellpadding="0" width="100%" class="w-full">
										<tr>
											<td align="center"
												class="text-center font-semibold text-gray-800 bg-gray-100 border-x border-b border-gray-500 py-2">
												Salary Details
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>

					</table>

					<!-- salary details -->
					<table width="100%" border="1" cellspacing="4" cellpadding="0"
						class="w-full border border-gray-500 text-[13px]">
						<tr>
							<td class="px-3 py-1">Working Days</td>
							<td class="px-3 py-1 text-right"><?php echo $row->working_days; ?></td>
							<td class="px-3 py-1">Leaves</td>
							<td class="px-3 py-1 text-right"><?php echo $row->leave_days; ?></td>
						</tr>

						<tr>
							<td class="px-3 py-1">Present Days</td>
							<td class="px-3 py-1 text-right"><?php echo $row->present_days; ?></td>
							<td class="px-3 py-1">Paid Leaves</td>
							<td class="px-3 py-1 text-right"><?php echo $row->paid_leave; ?></td>
						</tr>

						<tr>
							<td class="px-3 py-1">Company Holiday Day</td>
							<td class="px-3 py-1 text-right"><?php echo $row->company_holiday; ?></td>
							<td class="px-3 py-1">Paid Days</td>
							<td class="px-3 py-1 text-right"><?php echo $row->payment_days; ?></td>
						</tr>

						<tr>
							<td class="px-3 py-1">Overtime Amount</td>
							<td class="px-3 py-1 text-right"><?php echo $row->overtime_amt; ?></td>
							<td class="px-3 py-1">Basic Salary</td>
							<td class="px-3 py-1 text-right font-medium"><?php echo $row->basic_salary; ?></td>
						</tr>
					</table>

					<br>

					<!-- allowances and deductions -->
					<div class="flex w-full gap-3">

						<div class="w-1/2">
							<table border="1" width="100%" cellspacing="4" cellpadding="0"
								class="w-full border border-gray-500 text-[13px]">
								<thead>
									<tr class="bg-gray-100 border-b border-gray-500">
										<th class="px-3 py-2 text-left font-semibold">Allowance Type</th>
										<th class="px-3 py-2 text-right font-semibold">Allowance Value</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($record2 as $r) {
										if ($r->allowance_type == 'A') { ?>
											<tr>
												<td class="px-3 py-1"><?php echo $r->allowance_name; ?></td>
												<td class="px-3 py-1 text-right"><?php echo $r->amount; ?></td>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>

						<div class="w-1/2">
							<table border="1" width="100%" cellspacing="4" cellpadding="0"
								class="w-full border border-gray-500 text-[13px]">
								<thead>
									<tr class="bg-gray-100 border-b border-gray-500">
										<th class="px-3 py-2 text-left font-semibold">Deduction Type</th>
										<th class="px-3 py-2 text-right font-semibold">Deduction Value</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($record2 as $r) {
										if ($r->allowance_type == 'D') { ?>
											<tr>
												<td class="px-3 py-1"><?php echo $r->allowance_name; ?></td>
												<td class="px-3 py-1 text-right"><?php echo $r->amount; ?></td>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>

					</div>

					<!-- totals -->
					<table width="100%" border="1" cellspacing="4" cellpadding="0"
						class="w-full border border-gray-600 text-[13px] mt-3">
						<tr>
							<td class="px-3 py-2 font-medium">Total Allowances</td>
							<td class="px-3 py-2 text-right"><?php echo $row->total_allowance; ?></td>
							<td class="px-3 py-2 font-medium">Total Deductions</td>
							<td class="px-3 py-2 text-right"><?php echo $row->total_deduction; ?></td>
						</tr>

						<tr>
							<td class="px-3 py-2">Extra Allowances</td>
							<td class="px-3 py-2 text-right"><?php echo $row->extra_allowances; ?></td>
							<td class="px-3 py-2">Extra Deductions</td>
							<td class="px-3 py-2 text-right"><?php echo $row->extra_deduction; ?></td>
						</tr>

						<tr class="bg-gray-100">
							<td class="px-3 py-2 font-semibold text-base">Gross Amount</td>
							<td class="px-3 py-2 text-right font-semibold"><?php echo $row->gross_salary; ?></td>
							<td class="px-3 py-2 font-bold text-base">Net Salary</td>
							<td class="px-3 py-2 text-right font-bold text-base">
								<?php echo $row->net_salary; ?>
							</td>
						</tr>
					</table>


				</div>

			<?php endforeach; ?>
		<?php endif; ?>


</body>

</html>
