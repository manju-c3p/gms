<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-gray-200">

	<table id="dr_table" class="min-w-full divide-y divide-gray-200">

		<!-- Header -->
		<thead class="bg-gray-50">
			<tr>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Select</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Account</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Instrument Date</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Instrument Number</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Bank Date</th>
			</tr>
		</thead>

		<!-- Body -->
		<tbody class="divide-y divide-gray-100">
			<tr>
				<td colspan="7">
					<input type="hidden" name="selected_tr" id="selected_tr">
				</td>
			</tr>

			<?php foreach ($records as $r) { ?>
				<tr class="hover:bg-gray-50 transition">

					<td class="px-4 py-2">
						<input type="checkbox"
							class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
							name="inv_id[]"
							value="<?php echo $r->voucher_id; ?>"
							onclick="p_check();" />
					</td>

					<td class="px-4 py-2"><?php echo $r->voucher_date ?></td>
					<td class="px-4 py-2 font-medium text-gray-700"><?php echo $r->account_name ?></td>
					<td class="px-4 py-2"><?php echo $r->voucher_date ?>
						<input type="hidden"
							name="voucher_date"
							value="<?php echo $r->voucher_date; ?>">
					</td>
					<td class="px-4 py-2"><?php echo $r->transaction_no ?>
						<input type="hidden"
							name="transaction_no"
							value="<?php echo $r->transaction_no; ?>">
					</td>
					<td class="px-4 py-2 font-semibold"><?php echo $r->amount ?>
						<input type="hidden"
							name="amount"
							value="<?php echo $r->amount; ?>">
					</td>

					<td class="px-4 py-2">
						<input type="date"
							name="bank_date[]"
							value="<?php echo $r->bank_date; ?>"
							class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">

						<input type="hidden"
							name="customer_id"
							value="<?php echo $r->customer_id; ?>">
					</td>

				</tr>
			<?php } ?>
		</tbody>

	</table>
</div>
<script>
	$(document).ready(function() {
		$('#dr_table').DataTable({
			pageLength: 10,
			responsive: true,
			ordering: true
		});
	});
</script>
