<?php foreach ($res as $row) {
	$trans_date = $row->voucher_date;
	$narration = $row->narration;
	$voucher_id = $row->voucher_id;
}
?>
<div class="bg-white rounded-xl shadow p-6">

	<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
		<h2 class="text-lg font-semibold text-gray-800">Transaction Details</h2>



	</div>

	<form action="<?php echo base_url() . 'index.php/'; ?>accounts/update_transaction_details"
		id="receipt"
		method="post"
		name="receipt"
		class="space-y-6">

		<!-- Date & Narration -->
		<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-start">

			<label class="md:col-span-1 text-sm font-medium">
				Transaction Date
			</label>
			<div class="md:col-span-1">
				<input type="text"
					id="v_date"
					name="v_date"
					readonly
					value="<?php echo date('d-m-Y', strtotime($trans_date)); ?>"
					class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100 datepicker1">
				<input type="hidden"
					name="voucherid"
					value="<?php echo $voucher_id; ?>">
			</div>

			<label class="md:col-span-1 text-sm font-medium">
				Narration
			</label>
			<div class="md:col-span-3">
				<textarea name="narration"
					rows="2"
					class="w-full border rounded-lg px-3 py-2 text-sm"><?php echo $narration; ?></textarea>
			</div>

		</div>

		<!-- Transaction Table -->
		<div class="overflow-x-auto">
			<table class="w-full border border-gray-200 rounded-lg text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Debit Account (Dr)</th>
						<th class="border px-3 py-2 text-left">Credit Account (Cr)</th>
						<th class="border px-3 py-2 text-left">Invoice Code</th>
						<th class="border px-3 py-2 text-left">Amount</th>
					</tr>
				</thead>

				<tbody id="dr_body">
					<?php foreach ($res as $row) { ?>
						<tr>
							<td class="border px-3 py-2">
								<?php if ($row->drcr_type == 'Dr') echo $row->account_name; ?>
							</td>

							<td class="border px-3 py-2">
								<?php if ($row->drcr_type == 'Cr') echo $row->account_name; ?>
							</td>

							<td class="border px-3 py-2">
								<?php echo $row->invoice_no; ?>
							</td>

							<td class="border px-3 py-2">
								<input type="number"
									step="any"
									name="amount[]"
									value="<?php echo $row->amount; ?>"
									class="w-full border rounded px-2 py-1 text-sm">

								<input type="hidden"
									name="voucher_id[]"
									value="<?php echo $row->voucher_id; ?>">
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

		<!-- Submit -->
		<div class="flex justify-end">
			<input type="submit"
				id="add"
				name="submit"
				tabindex="39"
				value="Update"
				class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg cursor-pointer">
		</div>

	</form>
</div>
