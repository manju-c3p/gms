<div class="overflow-x-auto bg-white rounded-xl shadow">
	<table class="min-w-full border border-gray-200 text-sm">
		<thead class="bg-gray-100 text-gray-700 uppercase text-xs">
			<tr>
				<th class="px-4 py-3 w-[10%] text-center">Select</th>
				<th class="px-4 py-3 text-left">Invoice Date</th>
				<th class="px-4 py-3 text-left">Invoice No</th>
				<th class="px-4 py-3 text-right">Total Amount</th>
				<th class="px-4 py-3 text-right">Balance Amount</th>
				<th class="px-4 py-3 text-right">Debit Amount</th>
			</tr>
		</thead>

		<tbody id="dr_body" class="divide-y divide-gray-200">
			<tr>
				<td colspan="6">
					<input type="hidden" name="selected_tr" id="selected_tr">
				</td>
			</tr>

			<?php foreach ($records1 as $r): ?>
				<tr id="dr_addr<?= $r->invoice_id ?>" class="hover:bg-gray-50 transition">

					<!-- Select -->
					<td class="px-4 py-3 text-center">
						<input type="checkbox"
							id="invoiceID"
							class="case h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
							name="invoiceID[]"
							value="<?= $r->invoice_id ?>"
							data-invoice-code="<?= $r->invoice_no ?>"
							onclick="p_check();">
					</td>

					<!-- Invoice Date -->
					<td class="px-4 py-3 text-gray-700">
						<?= $r->invoice_date ?>
					</td>

					<!-- Invoice No -->
					<td class="px-4 py-3 font-medium text-gray-900">
						<?= $r->invoice_no ?>
						<input type="hidden"
							name="invoice_no[<?= $r->invoice_id ?>]"
							value="<?= htmlspecialchars($r->invoice_no) ?>">
					</td>

					<!-- Total -->
					<td class="px-4 py-3 text-right text-gray-800">
						<?= number_format($r->grand_total, 2) ?>
					</td>

					<!-- Balance -->
					<td class="px-4 py-3 text-right text-gray-800">
						<?= number_format($r->grand_total - $r->paid_amt, 2) ?>
					</td>

					<!-- Debit Amount -->

					<!-- Debit Amount -->
					<td class="px-4 py-3">
						<input type="number"
							step="0.01"
							min="0.01"
							name="dr_amount[<?= $r->invoice_id ?>]"
							id="dr_amount<?= $r->invoice_id ?>"
							class="w-full rounded-md border border-gray-300 px-2 py-1 text-right focus:border-blue-500 focus:ring focus:ring-blue-200 debit_sum"
							onkeyup="validateAmount(this); calculate_grand_total()"
							onblur="validateAmount(this)">

						<input type="hidden"
							name="customer_id"
							id="customer_id"
							value="<?= $r->customer_id ?>">
					</td>
					<!-- <td class="px-4 py-3">
                    <input type="number"
                        step="0.01"
                        min="0"
                        max="<?= ($r->grand_total - $r->paid_amt) ?>"
                        name="dr_amount[<?= $r->invoice_id ?>]"
                        id="dr_amount<?= $r->invoice_id ?>"
                        class="w-full rounded-md border border-gray-300 px-2 py-1 text-right focus:border-blue-500 focus:ring focus:ring-blue-200 debit_sum"
                        onkeyup="calculate_grand_total()">

                    <input type="hidden"
                        name="customer_id"
                        id="customer_id"
                        value="<?= $r->customer_id ?>">
                </td> -->

				</tr>
			<?php endforeach; ?>

			<tr id="dr_addr1"></tr>
		</tbody>
	</table>
</div>

<script>
	function calculate_grand_total() {
		let total = 0;
		alert('ddd');
		document.querySelectorAll('.debit_sum').forEach(function(input) {
			if (!input.disabled && input.value) {
				total += parseFloat(input.value) || 0;
			}
		});
		document.getElementById('debit_total').value = total.toFixed(2);
	}
</script>
