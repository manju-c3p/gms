<div class="mb-4 bg-white p-4 rounded shadow-sm">
	<a href="<?php echo base_url() . 'index.php/Accounts/view_profit_and_loss?from=' . $from . '&to=' . $to; ?>"
		class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded">
		← Back to Profit & Loss
	</a>
</div>

<div class="overflow-x-auto bg-white p-4 rounded shadow-sm">
	<table class="min-w-full border border-gray-300 bg-white">
		<tr class="bg-gray-100">
			<th class="border px-4 py-2 text-left">Date</th>
			<th class="border px-4 py-2 text-left">Ledger</th>
			<th class="border px-4 py-2 text-right">Amount</th>
		</tr>

		<?php foreach ($ledgers as $l) { ?>
			<tr class="hover:bg-gray-50">
				<td class="border px-4 py-2">
					<?= date('d-m-Y', strtotime($l->date)) ?>
				</td>
				<td class="border px-4 py-2">
					<?= $l->ledger_name ?>
				</td>
				<td class="border px-4 py-2 text-right font-medium <?= ($l->amount >= 0) ? 'text-green-600' : 'text-red-600'; ?>">
					<?= number_format(abs($l->amount), 2) ?>
				</td>
			</tr>

			<?php
			$total = array_sum(array_column($ledgers, 'amount'));
			?>
		<?php } ?>

		<tr class="bg-gray-100 font-semibold">
			<td colspan="2" class="border px-4 py-2">Total</td>
			<td class="border px-4 py-2 text-right">
				<?= number_format($total, 2) ?>
			</td>
		</tr>
	</table>
</div>
