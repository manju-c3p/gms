<?php $this->load->helper('account_helper.php'); ?>
<div class="p-4 bg-white rounded-lg shadow">

	<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Accounts/view_profit_and_loss" class="space-y-4" autocomplete="off" name="question" id="question" enctype="multipart/form-data">
		
		<div class="flex flex-wrap items-end gap-4">
			
			<label class="w-full sm:w-auto text-sm font-medium">
				From <span class="text-red-500">*</span>
			</label>
			<div class="w-full sm:w-48">
				<input type="date" class="w-full border rounded-md px-3 py-2 text-sm" id="from" name="from" value="<?php echo $from; ?>">
			</div>

			<label class="w-full sm:w-auto text-sm font-medium">
				To <span class="text-red-500">*</span>
			</label>
			<div class="w-full sm:w-48">
				<input type="date" class="w-full border rounded-md px-3 py-2 text-sm" id="to" name="to" value="<?php echo $to; ?>">
			</div>

			<div class="w-full sm:w-auto">
				<input type="submit" id="view" name="go" value="Go" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 cursor-pointer" />
			</div>

		</div>
	</form>

	<div class="mt-6">
		<div class="w-full lg:w-1/2 overflow-x-auto">
			
			<h3 class="text-xl font-semibold mb-3">Profit & Loss Statement</h3>

			<table class="w-full border border-gray-300 text-sm">
				<tr class="bg-gray-100">
					<th class="border px-3 py-2 text-left">Income</th>
					<th class="border px-3 py-2 text-right">Amount</th>
				</tr>

				<?php foreach ($income as $i) { ?>
					<tr>
						<td class="border px-3 py-2">
							<a class="text-blue-600 hover:underline"
								href="<?php echo base_url() . 'index.php/Accounts/drilldown?account_id=' . $i->account_id . '&from=' . $from . '&to=' . $to; ?>">
								<?php echo $i->account_name; ?>
							</a>
						</td>
						<td class="border px-3 py-2 text-right"><?= number_format($i->total, 2) ?></td>
					</tr>
				<?php } ?>

				<tr class="font-semibold bg-gray-50">
					<td class="border px-3 py-2">Total Income</td>
					<td class="border px-3 py-2 text-right"><?= number_format($total_income, 2) ?></td>
				</tr>
			</table>

			<br>

			<table class="w-full border border-gray-300 text-sm">
				<tr class="bg-gray-100">
					<th class="border px-3 py-2 text-left">Expenses</th>
					<th class="border px-3 py-2 text-right">Amount</th>
				</tr>

				<?php foreach ($expense as $e) { ?>
					<tr>
						<td class="border px-3 py-2">
							<a class="text-blue-600 hover:underline"
								href="<?php echo base_url() . 'index.php/Accounts/drilldown?account_id=' . $e->account_id . '&from=' . $from . '&to=' . $to; ?>">
								<?php echo $e->account_name; ?>
							</a>
						</td>
						<td class="border px-3 py-2 text-right"><?= number_format(abs($e->total), 2) ?></td>
					</tr>
				<?php } ?>

				<tr class="font-semibold bg-gray-50">
					<td class="border px-3 py-2">Total Expense</td>
					<td class="border px-3 py-2 text-right"><?= number_format($total_expense, 2) ?></td>
				</tr>
			</table>

			<hr class="my-4">

			<h3 class="text-right text-lg font-bold <?= ($net_profit >= 0) ? 'text-green-600' : 'text-red-600'; ?>">
				<?php if ($net_profit >= 0) { ?>
					Net Profit: <?= number_format($net_profit, 2) ?>
				<?php } else { ?>
					Net Loss: <?= number_format(abs($net_profit), 2) ?>
				<?php } ?>
			</h3>

		</div>
	</div>
</div>

<!-- Static Table End -->
