<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="bg-white shadow-md rounded-xl p-6">

	<form class="grid md:grid-cols-12 gap-4 items-end"
		action="<?php echo base_url('index.php/accounts/search_outstanding_report'); ?>"
		method="post"
		id="receipt"
		name="receipt">

		<!-- From -->
		<div class="md:col-span-2">
			<label class="block text-sm font-medium mb-1">From</label>

			<div class="relative">
				<input type="date"
					class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
					name="from"
					id="from"
					value="<?= !empty($from) ? date('Y-m-d', strtotime($from)) : date('Y-m-d'); ?>"
					required>
			</div>
		</div>


		<!-- To -->
		<div class="md:col-span-2">
			<label class="block text-sm font-medium mb-1">To</label>

			<div class="relative">
				<input type="date"
					class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
					name="to"
					id="to"
					value="<?= !empty($to) ? date('Y-m-d', strtotime($to)) : date('Y-m-d'); ?>"
					required>
			</div>
		</div>

		<!-- Type -->
		<div class="md:col-span-3">
			<label class="block text-sm font-medium mb-1">Type</label>

			<select class="w-full border rounded-lg px-3 py-2 select2 focus:ring-2 focus:ring-blue-500 request_type_select"
				name="request_type"
				id="request_type"
				onchange="handleRequestTypeChange()">

				<option value="">Please select type</option>

				<option value="Sundry Creditors"
					<?= ($request_type == 'Sundry Creditors') ? 'selected' : '' ?>>
					Sundry Creditors
				</option>

				<option value="Sundry Debtors"
					<?= ($request_type == 'Sundry Debtors') ? 'selected' : '' ?>>
					Sundry Debtors
				</option>

			</select>
		</div>


		<!-- Ledger Dropdown -->
		<div class="md:col-span-3"
			id="ledgerDropdownContainer"
			<?= empty($ledgers) ? 'style="display:none;"' : '' ?>>

			<label class="block text-sm font-medium mb-1">
				Select Ledger
			</label>

			<?php if (!empty($ledgers)) : ?>

				<select class="w-full border rounded-lg px-3 py-2 select2 focus:ring-2 focus:ring-blue-500 ledger_select"
					name="ledger_id"
					id="ledger_id"
					onchange="submitForm()">

					<option value="">Select Ledger</option>

					<?php foreach ($ledgers as $ledger): ?>

						<option value="<?= $ledger->account_id ?>"
							<?= ($ledger_id == $ledger->account_id) ? 'selected' : '' ?>>

							<?= htmlspecialchars($ledger->account_name) ?>

						</option>

					<?php endforeach; ?>

				</select>

			<?php endif; ?>
		</div>


		<!-- Buttons -->
		<div class="md:col-span-12 flex gap-3 mt-2">

			<button type="submit"
				class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
				Go
			</button>

			<button type="button"
				class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow"
				onclick="submitPrint()">
				Print
			</button>

			<button type="button"
				class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow"
				onclick="submitExport()">
				Export to Excel
			</button>

		</div>

	</form>




	<div class="overflow-x-auto">
		<table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden">

			<thead class="bg-gray-100">
				<tr>
					<th class="p-3 border text-left">S.No</th>
					<th class="p-3 border text-left">Date</th>
					<th class="p-3 border text-left">
						<?php echo ($request_type == 'Sundry Creditors') ? 'Supplier Name' : 'Customer Name'; ?>
					</th>
					<th class="p-3 border text-left">Ref. No</th>
					<th class="p-3 border text-right">Total Amount</th>
					<th class="p-3 border text-right">Amount Paid</th>
					<th class="p-3 border text-right">Outstanding</th>
					<th class="p-3 border text-left">Due On</th>
					<th class="p-3 border text-left">Overdue Days</th>
				</tr>
			</thead>

			<tbody class="divide-y">

				<?php
				$i = 1;

				if (!empty($records)) {

					foreach ($records as $row) {  ?>

						<tr class="hover:bg-gray-50">
							<td class="p-3"><?php echo $i++; ?></td>

							<td class="p-3">
								<?php echo date('d-M-Y', strtotime($row->voucher_date)); ?>
							</td>

							<td class="p-3">
								<?php
								echo ($request_type == 'Sundry Creditors')
									? (!empty($row->account_name) ? $row->account_name : 'N/A')
									: (!empty($row->cust_name) ? $row->cust_name : 'N/A');
								?>
							</td>

							<td class="p-3"><?php echo $row->voucher_code; ?></td>

							<td class="p-3 text-right font-medium">
								<?php echo number_format($row->sum_amt, 2); ?>
							</td>

							<td class="p-3 text-right">
								<?php echo number_format($row->sum_paid_amt ?? $row->sum_received_amt ?? 0, 2); ?>
							</td>

							<td class="p-3 text-right font-semibold text-red-600">
								<?php echo number_format($row->sum_due_amt, 2); ?>
							</td>

							<td class="p-3">
								<?php echo date('d-M-Y', strtotime('+3 months', strtotime($row->voucher_date))); ?>
							</td>

							<td class="p-3">
								<?php
								$due_date = strtotime('+3 months', strtotime($row->voucher_date));
								$today = strtotime(date('Y-m-d'));
								echo ($today > $due_date) ? floor(($today - $due_date) / 86400) : '-';
								?>
							</td>
						</tr>

					<?php }
				} else { ?>

					<tr>
						<td colspan="9" class="p-4 text-center text-gray-500">
							No records found.
						</td>
					</tr>

				<?php } ?>

			</tbody>

		</table>
	</div>

</div>
<script>
	$(document).ready(function() {

		$('.request_type_select').select2({
			width: '100%'
		});

		$('.ledger_select').select2({
			width: '100%'
		});

	});

	function handleRequestTypeChange() {
		var requestType = document.getElementById('request_type').value;
		var ledgerDropdown = document.getElementById('ledgerDropdownContainer');

		if (requestType === 'Sundry Creditors' || requestType === 'Sundry Debtors') {
			ledgerDropdown.style.display = 'block';
		} else {
			ledgerDropdown.style.display = 'none';
			document.getElementById('ledger_id').value = '';
		}

		// Submit form when type changes
		submitForm();
	}

	function submitForm() {
		document.getElementById('receipt').submit();
	}


	function submitPrint() {
		const form = document.createElement('form');
		form.method = 'post';
		form.action = "<?php echo base_url('index.php/Accounts/print_outstanding_report'); ?>";
		form.target = '_blank';
		form.innerHTML = `
        <input type="hidden" name="from" value="<?php echo isset($from) ? $from : ''; ?>">
        <input type="hidden" name="to" value="<?php echo isset($to) ? $to : ''; ?>">
         <input type="hidden" name="ledger_id" value="<?php echo isset($ledger_id) ? $ledger_id : ''; ?>">
        <input type="hidden" name="request_type" value="<?php echo isset($request_type) ? $request_type : ''; ?>">
    `;
		document.body.appendChild(form);
		form.submit();
	}

	function submitExport() {
		const form = document.createElement('form');
		form.method = 'post';
		form.action = "<?php echo base_url('index.php/Accounts/export_outstanding_report_details'); ?>";
		form.innerHTML = `
        <input type="hidden" name="from" value="<?php echo isset($from) ? $from : ''; ?>">
        <input type="hidden" name="to" value="<?php echo isset($to) ? $to : ''; ?>">
		  <input type="hidden" name="ledger_id" value="<?php echo isset($ledger_id) ? $ledger_id : ''; ?>">
        <input type="hidden" name="request_type" value="<?php echo isset($request_type) ? $request_type : ''; ?>">
    `;
		document.body.appendChild(form);
		form.submit();
	}
</script>
