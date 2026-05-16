<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="bg-white min-h-screen p-5">
	<!-- PAGE HEADER -->
	<div class="flex items-center justify-between mb-4">
		<h2 class="text-2xl font-semibold text-gray-800">
			Monthly Salary List
		</h2>

		<a href="<?php echo base_url('index.php/Hr/add_monthly_salary'); ?>"
			class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium">
			+ Add Monthly Salary
		</a>
	</div>


	<!-- FILTER CARD -->
	<div class="bg-white shadow-md rounded-2xl p-5 mb-5">


		<div class="flex flex-wrap items-end gap-4">
			<form id="main" method="post"
				action="<?php echo base_url() . 'index.php/'; ?>Hr/view_emp_monthly_salary"
				autocomplete="off" enctype="multipart/form-data">
				<div class="flex flex-wrap items-end gap-4">

					<div>
						<label class="block text-sm font-medium text-gray-600 mb-1">
							Month Date
						</label>

						<div class="flex">
							<input type="month"
								class="border border-gray-300 rounded-l-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
								name="from"
								value="<?php echo !empty($from) ? date('Y-m', strtotime($from)) : ''; ?>">


						</div>
					</div>


					<div>
						<input type="submit" value="Go"
							class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow text-sm cursor-pointer">
					</div>
				</div>
			</form>

			<div class="ml-auto flex gap-3">
				<form target="_blank"
					action="<?php echo base_url() . 'index.php/Hr/print_monthly_record/' ?>"
					method="post">
					<input type="hidden" name="from" value="<?php echo $from; ?>">
					<button
						class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow text-sm">
						Print
					</button>
				</form>

				<form action="<?php echo base_url() . 'index.php/Hr/export_monthly_record/' ?>"
					method="post">
					<input type="hidden" name="from" value="<?php echo $from; ?>">
					<button
						class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg shadow text-sm">
						Export Excel
					</button>
				</form>
			</div>

		</div>

	</div>





	<!-- TABLE CARD -->
	<div class="bg-white border border-gray-300 rounded-lg overflow-hidden">


		<div class="overflow-x-auto">
			<table id="datatable" class="min-w-full text-sm border border-gray-300">

				<thead class="bg-gray-100 text-gray-700">
					<tr>
						<th class="px-4 py-3 border">Sr No</th>
						<th class="px-4 py-3 border">Employee Name</th>
						<th class="px-4 py-3 border">Salary Month</th>
						<th class="px-4 py-3 border text-right">Working Days</th>
						<th class="px-4 py-3 border text-right">Leave</th>
						<th class="px-4 py-3 border text-right">Present</th>
						<th class="px-4 py-3 border text-right">Paid Leave</th>
						<th class="px-4 py-3 border text-right">Payment Days</th>
						<th class="px-4 py-3 border text-right">Basic</th>
						<th class="px-4 py-3 border text-right">Allowance</th>
						<th class="px-4 py-3 border text-right">Deduction</th>
						<th class="px-4 py-3 border text-right">Gross</th>
						<th class="px-4 py-3 border text-right">Net</th>
						<th class="px-4 py-3 border">Remarks</th>
						<th class="px-4 py-3 border text-center">Action</th>
					</tr>
				</thead>

				<tbody>

					<?php $i = 1;
					foreach ($records as $row) { ?>

						<tr class="hover:bg-gray-50">

							<td class="px-4 py-3 border"><?php echo $i++; ?></td>

							<td class="px-4 py-3 border font-medium">
								<?php echo $row->employee_name; ?>
							</td>

							<td class="px-4 py-3 border">
								<?php echo date('M-Y', strtotime($row->salary_month)); ?>
							</td>

							<td class="px-4 py-3 border text-right"><?php echo $row->working_days; ?></td>
							<td class="px-4 py-3 border text-right"><?php echo $row->leave_days; ?></td>
							<td class="px-4 py-3 border text-right"><?php echo $row->present_days; ?></td>
							<td class="px-4 py-3 border text-right"><?php echo $row->paid_leave; ?></td>
							<td class="px-4 py-3 border text-right"><?php echo $row->payment_days; ?></td>

							<td class="px-4 py-3 border text-right"><?php echo number_format($row->basic_salary, 2); ?></td>
							<td class="px-4 py-3 border text-right"><?php echo number_format($row->total_allowance, 2); ?></td>
							<td class="px-4 py-3 border text-right"><?php echo number_format($row->total_deduction, 2); ?></td>

							<td class="px-4 py-3 border text-right font-medium">
								<?php echo number_format($row->gross_salary, 2); ?>
							</td>

							<td class="px-4 py-3 border text-right font-semibold <?php echo ($row->net_salary < 0 ? 'text-red-600' : 'text-blue-700'); ?>">
								<?php echo number_format($row->net_salary, 2); ?>
							</td>

							<td class="px-4 py-3 border"><?php echo $row->remark; ?></td>

							<td class="px-4 py-3 border text-center">
								<a href="<?php echo base_url() . 'index.php/Hr/print_monthly_payslip/' . $row->sid; ?>"
									target="_blank"
									class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
									Print
								</a>

								<button onclick="deleteSalary(<?php echo $row->sid; ?>)"
									class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs ml-2">
									Delete
								</button>
							</td>

						</tr>

					<?php } ?>

				</tbody>
			</table>

		</div>

	</div>
</div>




<script>
	function confirmcancel(sid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Hr/delete_emp_monthly_salary_record",
				type: "POST",
				data: {
					sid: sid
				},
				success: function(msg) {
					if (msg == 1) {
						alert("Record deleted");
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

	function deleteSalary(sid) {

		if (!confirm("Are you sure you want to delete this salary record?")) return;

		fetch("<?= base_url('index.php/Hr/delete_monthly_salary') ?>", {
				method: "POST",
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: "sid=" + sid
			})
			.then(res => res.json())
			.then(res => {
				alert(res.msg);
				location.reload();
			});
	}

	$(document).ready(function() {



		$('#datatable').DataTable({
			pageLength: 10,
			ordering: true,
			searching: true,
			lengthMenu: [10, 25, 50, 100],
			columnDefs: [{
					orderable: false,
					targets: [8]
				} // disable sorting for Action column
			]
		});

	});
</script>
