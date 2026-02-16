<!-- <link rel="stylesheet" href="<?php echo base_url() ?>public/expand_row/jquery.treegrid.css"> -->
<!-- <script type="text/javascript" src="<?php echo base_url() ?>public/expand_row/jquery.treegrid.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url() ?>public/expand_row/jquery.treegrid.bootstrap3.js"></script> -->

<?php $this->load->helper('Account_helper.php'); ?>

<div class="bg-white shadow-lg rounded-2xl p-6">
	<h2 class="text-lg font-semibold text-gray-800">Balance Sheet</h2>
	<!--  -->
	<!-- Filter -->
	<form method="post"
		action="<?php echo base_url() . 'index.php/Accounts/get_balance_sheet'; ?>"
		class="grid md:grid-cols-4 gap-4 items-end mb-6">

		<!-- From -->
		<div>
			<label class="block text-sm font-semibold mb-1">
				From <span class="text-red-500">*</span>
			</label>
			<input type="text"
				id="from"
				name="from"
				value="<?php echo $from; ?>"
				class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
		</div>

		<!-- To -->
		<div>
			<label class="block text-sm font-semibold mb-1">
				To <span class="text-red-500">*</span>
			</label>
			<input type="text"
				id="to"
				name="to"
				value="<?php echo $to; ?>"
				class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
		</div>

		<!-- Button -->
		<div>
			<button type="submit"
				class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
				Go
			</button>
		</div>

	</form>


	<!-- Balance Sheet Tables -->
	<div class="grid md:grid-cols-2 gap-6">

		<!-- Liabilities -->
		<div class="overflow-x-auto">
			<table class="min-w-full border rounded-xl overflow-hidden text-sm">

				<thead class="bg-gray-100">
					<tr>
						<th class="text-left p-3 border">Account Title</th>
						<th class="text-right p-3 border">Amount</th>
					</tr>
				</thead>

				<tbody class="divide-y">

					<tr class="bg-gray-50 font-semibold">
						<td class="p-3">Liabilities</td>
						<td></td>
					</tr>

					<?php
					$result = get_group_details(0, 2);
					foreach ($result as $k) { ?>
						<tr>
							<td class="p-3">
								<?php echo anchor(
									"Accounts/drill_balance_sheetw/{$k->group_no}/{$from}/{$to}",
									"<b>" . html_escape($k->group_name) . "</b>"
								); ?>
							</td>

							<td class="p-3 text-right">
								<?php
								$gno = "";
								$gno1 = get_group_nos($k->group_no);

								if ($gno1 != '') {
									$gno = $k->group_no;
									$gno2 = get_group_nos($gno1);

									$gno = $gno2 != ''
										? $k->group_no . ',' . $gno1 . ',' . $gno2
										: $k->group_no . ',' . $gno1;

									echo get_group_total1($gno, $from, $to);
								} else {
									echo get_group_total1($k->group_no, $from, $to);
								}
								?>
							</td>
						</tr>
					<?php } ?>

				</tbody>

				<tfoot class="bg-gray-50 font-semibold">
					<tr>
						<td class="p-3">Opening Balance</td>
						<td class="p-3 text-right">
							<?php echo sprintf("%0.2f", get_total_for_balance_sheet_with_date(2, $from)); ?>
						</td>
					</tr>

					<tr class="bg-gray-100">
						<td class="p-3">Grand Total</td>
						<td class="p-3 text-right">
							<?php
							$debit_total = get_total_for_balance_sheet(2);
							echo sprintf("%0.2f", $debit_total);
							?>
						</td>
					</tr>
				</tfoot>

			</table>
		</div>


		<!-- Assets -->
		<div class="overflow-x-auto">
			<table class="min-w-full border rounded-xl overflow-hidden text-sm">

				<thead class="bg-gray-100">
					<tr>
						<th class="text-left p-3 border">Account Title</th>
						<th class="text-right p-3 border">Amount</th>
					</tr>
				</thead>

				<tbody class="divide-y">

					<tr class="bg-gray-50 font-semibold">
						<td class="p-3">Assets</td>
						<td></td>
					</tr>

					<?php
					$result = get_group_details(0, 1);
					foreach ($result as $kk) { ?>
						<tr>
							<td class="p-3">
								<?php echo anchor(
									"Accounts/drill_balance_sheetw/{$kk->group_no}/{$from}/{$to}",
									"<b>" . html_escape($kk->group_name) . "</b>"
								); ?>
							</td>

							<td class="p-3 text-right">
								<?php
								$gno = "";
								$gno1 = get_group_nos($kk->group_no);

								if ($gno1 != '') {
									$gno = $kk->group_no;
									$gno2 = get_group_nos($gno1);

									$gno = $gno2 != ''
										? $kk->group_no . ',' . $gno1 . ',' . $gno2
										: $kk->group_no . ',' . $gno1;

									echo get_group_total1($gno, $from, $to);
								} else {
									echo get_group_total1($kk->group_no, $from, $to);
								}
								?>
							</td>
						</tr>
					<?php } ?>

				</tbody>

				<tfoot class="bg-gray-50 font-semibold">
					<tr>
						<td class="p-3">Opening Balance</td>
						<td class="p-3 text-right">
							<?php echo sprintf("%0.2f", get_total_for_balance_sheet_with_date(1, $from)); ?>
						</td>
					</tr>

					<tr class="bg-gray-100">
						<td class="p-3">Grand Total</td>
						<td class="p-3 text-right">
							<?php
							$debit_total1 = get_total_for_balance_sheet(1);
							echo sprintf("%0.2f", $debit_total1);
							?>
						</td>
					</tr>
				</tfoot>

			</table>
		</div>

	</div>

</div>

<!-- Static Table End -->



<script type="text/javascript">
	// $(document).ready(function() {
	// 	$('.tree').treegrid();
	// 	$('.tree-2').treegrid({
	// 		expanderExpandedClass: 'glyphicon glyphicon-minus',
	// 		expanderCollapsedClass: 'glyphicon glyphicon-plus'
	// 	});

	// });
	// $(document).ready(function() {

	// 	$('.tree-2').treegrid({
	// 		expanderExpandedClass: 'text-blue-600 font-bold',
	// 		expanderCollapsedClass: 'text-gray-600'
	// 	});

	// });
</script>
