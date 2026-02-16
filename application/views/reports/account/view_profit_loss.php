<?php $this->load->helper('account_helper.php');
// $opening_amt = sprintf("%0.2f", get_pnl_opening_stock_amt($from)) ?? 0;
// $closing_amt = sprintf("%0.2f", get_pnl_closing_stock_amt($from, $to)) ?? 0;
$opening_amt =  0;
$closing_amt =  0;
$mid_income_total = 0;
$last_income_total = 0;
$result = get_group_details(1, 3);
foreach ($result as $kk) {
	if ($kk->group_no == 14) {
		$gno = "";
		$gno1 = get_group_nos($kk->group_no);
		if ($gno1 != '') {
			$gno = $k->group_no;
			$gno2 = get_group_nos($gno1);

			if ($gno2 != '')
				$gno = $k->group_no . ',' . $gno1 . ',' . $gno2;
			else
				$gno = $k->group_no . ',' . $gno1;

			//echo $gno;
			$gtot2 = get_group_total1($gno, $from, $to);
			$mid_income_total = $gtot2 + $mid_income_total;
		} else
			$gtot2 = get_group_total1($kk->group_no, $from, $to);
		$mid_income_total = $gtot2 + $mid_income_total;
	}
	$income_calculation = $mid_income_total + $closing_amt;

	if ($kk->group_no == 12 || $kk->group_no == 10) {
		$gno = "";
		$gno1 = get_group_nos($kk->group_no);
		if ($gno1 != '') {
			$gno = $k->group_no;
			$gno2 = get_group_nos($gno1);

			if ($gno2 != '')
				$gno = $k->group_no . ',' . $gno1 . ',' . $gno2;
			else
				$gno = $k->group_no . ',' . $gno1;

			//echo $gno;
			$gtot2 = get_group_total1($gno, $from, $to);
			$last_income_total = $gtot2 + $last_income_total;
		} else
			$gtot2 = get_group_total1($kk->group_no, $from, $to);
		$last_income_total = $gtot2 + $last_income_total;
	}
}
$total = 0.00;
$gross_loss = 0.00;
$gross_profit = 0.00;
?>
<div class="bg-white shadow-md rounded-xl p-6">

	<form id="main"
		method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Accounts/get_profit_and_loss"
		autocomplete="off"
		name="question"
		enctype="multipart/form-data"
		class="grid md:grid-cols-4 gap-4 items-end">

		<!-- From -->
		<div>
			<label class="block text-sm font-medium mb-1">
				From <span class="text-red-500">*</span>
			</label>

			<div class="relative">
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
					id="from"
					name="from"
					value="<?php echo $from; ?>">

				<!-- Calendar Icon -->
				<span class="absolute right-3 top-2.5 text-gray-400">
					<i class="fa fa-calendar"></i>
				</span>
			</div>
		</div>


		<!-- To -->
		<div>
			<label class="block text-sm font-medium mb-1">
				To <span class="text-red-500">*</span>
			</label>

			<div class="relative">
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
					id="to"
					name="to"
					value="<?php echo $to; ?>">

				<span class="absolute right-3 top-2.5 text-gray-400">
					<i class="fa fa-calendar"></i>
				</span>
			</div>
		</div>


		<!-- Button -->
		<div>
			<input type="submit"
				id="view"
				name="go"
				value="Go"
				class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow cursor-pointer">
		</div>

	</form>



	<div class="grid md:grid-cols-2 gap-6">

		<div class="overflow-x-auto">
			<table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden tree-2">

				<thead class="bg-gray-100">
					<tr>
						<td class="p-3 font-semibold border">Particulars</td>
						<td class="p-3 font-semibold border text-right">Amount</td>
						<td class="p-3 font-semibold border text-right">Group Total</td>
					</tr>
				</thead>

				<tbody class="divide-y">

					<tr class='treegrid-0'>
						<td class="p-3 font-semibold">Opening Stock</td>
						<td class="p-3"></td>
						<td class="p-3 text-right"><?php echo $opening_amt; ?></td>
					</tr>

					<tr class='treegrid-0'>
						<td class="p-3 font-semibold"></td>
						<td class="p-3"></td>
						<td class="p-3"></td>
					</tr>

					<?php
					$mid_total = 0;
					$result = get_group_details(1, 4);

					foreach ($result as $k) {

						if ($k->group_no == 11) {
							echo "
						<tr class='bg-blue-100'>
							<td class='p-3'></td>
							<td class='p-3'></td>
							<td class='p-3'></td>
						</tr>

						<tr class='bg-blue-100 font-semibold'>
							<td class='p-3'>Gross Profit c/o</td>
							<td></td>
							<td class='p-3 text-right'>$gross_profit</td>
						</tr>

						<tr class='bg-yellow-100 font-bold'>
							<td class='p-3'>Total</td>
							<td></td>
							<td class='p-3 text-right'>$total</td>
						</tr>

						<tr class='bg-blue-100 font-semibold'>
							<td class='p-3'>Gross loss c/o</td>
							<td></td>
							<td class='p-3 text-right'>$gross_loss</td>
						</tr>
						";
						}
					?>

						<tr class='treegrid-0'>
							<td class="p-3 font-semibold"><?php echo $k->group_name; ?></td>
							<td class="p-3"></td>
							<td class="p-3 text-right">
								<?php
								$gno = "";
								$gno1 = get_group_nos($k->group_no);

								if ($gno1 != '') {
									$gno = $k->group_no;
									$gno2 = get_group_nos($gno1);

									if ($gno2 != '')
										$gno = $k->group_no . ',' . $gno1 . ',' . $gno2;
									else
										$gno = $k->group_no . ',' . $gno1;

									echo $gtot1 = get_group_total1($gno, $from, $to);
									$mid_total = $gtot1 + $mid_total;
								} else {
									echo $gtot1 = get_group_total1($k->group_no, $from, $to);
									$mid_total = $gtot1 + $mid_total;
								}

								$expence_calculation = $opening_amt + $mid_total;

								if ($expence_calculation > $income_calculation) {
									$total = $expence_calculation;
									$gross_profit = 0.00;
									$gross_loss = $expence_calculation - $income_calculation;
								} else {
									$total = $income_calculation;
									$gross_loss = 0.00;
									$gross_profit = $income_calculation - $expence_calculation;
								}

								$income_sum = $last_income_total + $gross_profit;
								$expance_sum = $mid_total + $gross_loss;

								if ($expance_sum > $income_sum) {
									$last_total = $expance_sum;
									$nett_profit = $expance_sum - $income_sum;
									$nett_loss = 0.00;
								} else {
									$last_total = $income_sum;
									$nett_loss = $income_sum - $expance_sum;
									$nett_profit = 0.00;
								}
								?>
							</td>
						</tr>

						<?php
						if ($k->group_no != '') {

							$gno2 = get_group_nos($k->group_no);

							if ($gno2 == '') {
								$gno2 = $k->group_no;
							}

							$sub_result = get_subgroup_details($gno2);

							foreach ($sub_result as $sk) { ?>

								<tr class='treegrid-0 text-gray-600'>
									<td class="p-2 pl-10 text-xs">
										<b>
											<a class="hover:text-blue-600"
												href="<?php echo base_url('index.php/accounts/search_individual_ledger_details/' . $sk->account_id . "/" . $from . '/' . $to); ?>"
												target="_blank">
												<?php echo $sk->account_name; ?>
											</a>

											<input type="hidden" name="from_date" value="<?php echo $from; ?>" />
											<input type="hidden" name="to_date" value="<?php echo $to; ?>" />
											<input type="hidden" name="account_id" value="<?php echo $sk->account_id; ?>" />
										</b>
									</td>

									<td class="p-2 text-right text-xs">
										<?php echo get_ledger_total1($sk->account_id, $from, $to); ?>
									</td>

									<td class="p-2"></td>
								</tr>

					<?php }
						}
					} ?>

					<tr class='bg-green-100 font-semibold'>
						<td class="p-3">Net Profit</td>
						<td class="p-3 text-right">
							<?php echo sprintf("%0.2f", $nett_profit); ?>
						</td>
						<td></td>
					</tr>

					<tr class='bg-gray-200 font-bold text-lg'>
						<td class="p-3">Total</td>
						<td></td>
						<td class="p-3 text-right">
							<?php echo sprintf("%0.2f", $last_total); ?>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		


		<div class="overflow-x-auto">
			<table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden tree-2">

				<thead class="bg-gray-100">
					<tr>
						<td class="p-3 font-semibold border">Particulars</td>
						<td class="p-3 font-semibold border text-right">Ledger Amount</td>
						<td class="p-3 font-semibold border text-right">Group Total</td>
					</tr>
				</thead>

				<tbody class="divide-y">

					<?php
					$result = get_group_details(1, 3);
					foreach ($result as $kk) {

						if ($kk->group_no == 12) {

							echo "
					<tr>
						<td class='p-3'></td>
						<td class='p-3'></td>
						<td class='p-3'></td>
					</tr>
					<tr>
						<td class='p-3'></td>
						<td class='p-3'></td>
						<td class='p-3'></td>
					</tr>
					<tr>
						<td class='p-3'></td>
						<td class='p-3'></td>
						<td class='p-3'></td>
					</tr>
					<tr>
						<td class='p-3'></td>
						<td class='p-3'></td>
						<td class='p-3'></td>
					</tr>

					<tr class='bg-blue-100 font-semibold'>
						<td class='p-3'>Closing Stock</td>
						<td></td>
						<td class='p-3 text-right'>$closing_amt</td>
					</tr>

					<tr class='bg-blue-100 font-semibold'>
						<td class='p-3'>Gross loss c/o</td>
						<td></td>
						<td class='p-3 text-right'>$gross_loss</td>
					</tr>

					<tr class='bg-yellow-100 font-bold'>
						<td class='p-3'>Total</td>
						<td></td>
						<td class='p-3 text-right'>$total</td>
					</tr>

					<tr class='bg-blue-100 font-semibold'>
						<td class='p-3'>Gross Profit c/o</td>
						<td></td>
						<td class='p-3 text-right'>$gross_profit</td>
					</tr>
					";
						}
					?>

						<tr class='treegrid-0'>
							<td class="p-3 font-semibold"><b><?php echo $kk->group_name; ?></b></td>
							<td class="p-3"></td>
							<td class="p-3 text-right">
								<?php
								$gno = "";
								$gno1 = get_group_nos($kk->group_no);

								if ($gno1 != '') {
									$gno = $k->group_no;
									$gno2 = get_group_nos($gno1);

									if ($gno2 != '')
										$gno = $k->group_no . ',' . $gno1 . ',' . $gno2;
									else
										$gno = $k->group_no . ',' . $gno1;

									echo $gno;
									echo get_group_total1($gno, $from, $to);
								} else
									echo get_group_total1($kk->group_no, $from, $to);
								?>
							</td>
						</tr>

						<?php
						if ($k->group_no != '') {

							$gno2 = get_group_nos($kk->group_no);

							if ($gno2 == '') {
								$gno2 = $kk->group_no;
							}

							$sub_result = get_subgroup_details($gno2);

							foreach ($sub_result as $sk) { ?>

								<tr class='treegrid-0 text-gray-600'>
									<td class="pl-10 p-2 text-xs">
										<b>
											<a class="hover:text-blue-600"
												href="<?php echo base_url('index.php/accounts/search_individual_ledger_details/' . $sk->account_id . "/" . $from . '/' . $to); ?>"
												target="_blank">
												<?php echo $sk->account_name; ?>
											</a>

											<input type="hidden" name="from_date" value="<?php echo $from; ?>" />
											<input type="hidden" name="to_date" value="<?php echo $to; ?>" />
											<input type="hidden" name="account_id" value="<?php echo $sk->account_id; ?>" />
										</b>
									</td>

									<td class="p-2 text-right text-xs">
										<?php echo get_ledger_total1($sk->account_id, $from, $to); ?>
									</td>

									<td class="p-2"></td>
								</tr>

						<?php }
						} ?>

					<?php } ?>

					<tr>
						<td class="p-3"></td>
						<td class="p-3"></td>
						<td class="p-3"></td>
					</tr>

					<tr class='bg-red-100 font-semibold'>
						<td class="p-3">Net Loss</td>
						<td></td>
						<td class="p-3 text-right">
							<?php echo sprintf("%0.2f", $nett_loss); ?>
						</td>
					</tr>

					<tr class='bg-gray-200 font-bold text-lg'>
						<td class="p-3">Total</td>
						<td></td>
						<td class="p-3 text-right">
							<?php echo sprintf("%0.2f", $last_total); ?>
						</td>
					</tr>

				</tbody>
			</table>
		</div>

	</div>
</div>

<!-- Static Table End -->
