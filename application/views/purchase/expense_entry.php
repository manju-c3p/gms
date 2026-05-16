<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<h1 class="text-xl font-medium text-gray-700">
		Expense Entry
	</h1>

	<a href="<?php echo base_url('index.php/Accounts/expense_list'); ?>"
		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
		← Back to List
	</a>


</div>

<form method="post" action="<?php echo base_url('index.php/Accounts/save_expense'); ?>" enctype="multipart/form-data">
	<div class="bg-white shadow rounded-xl p-6 space-y-6">
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">Date</label>
				<input type="date" name="expense_date" class="w-full border rounded px-3 py-2"
					value="<?php echo date('Y-m-d'); ?>" required>
			</div>
			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">Expense Ledger</label>

				<select name="expense_ledger_id" id="expense_ledger_id"
					class="w-full border rounded px-3 py-2 select2" >

					<option value="">Select Expense Ledger</option>

					<?php foreach ($expense_ledgers as $l) { ?>
						<option value="<?php echo $l->ledger_id; ?>" <?php if($l->ledger_name == 'Other Expenses'){ ?> selected <?php } ?>>
							<?php echo $l->ledger_name; ?>
						</option>
					<?php } ?>

				</select>
			</div>


			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">Description</label>
				<input type="text" name="desp"
					class="w-full border rounded px-3 py-2" required>
				
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">Amount</label>
				<input type="number" step="any" name="amount"
					class="w-full border rounded px-3 py-2" required>
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">Paid Through</label>
				<select name="payment_mode" id="payment_mode" class="w-full border rounded px-3 py-2" required>
					<option value="CASH">Cash</option>
					<option value="BANK">Bank</option>
					<option value="CREDIT">Credit</option>
				</select>
			</div>
			<div class="col-span-12 md:col-span-4 hidden" id="bank_ledger_div">
				<label class="text-sm">Bank Account</label>
				<select name="bank_ledger_id" id="bank_ledger_id"
					class="w-full border rounded px-3 py-2 select2">
					<option value="">Select Bank</option>
				</select>
			</div>

		</div>

		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-6">
				<label class="text-sm">Remarks</label>
				<input type="text" name="remarks" class="w-full border rounded px-3 py-2">
			</div>

			<div class="col-span-12 md:col-span-6">
				<label class="text-sm">Attachment</label>
				<input type="file" name="expense_doc" class="w-full border rounded px-3 py-2">
			</div>

		</div>

		<div class="flex justify-end gap-3 pt-4">

			<a href="<?php echo base_url('index.php/Accounts/expense_list'); ?>"
				class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
				Cancel
			</a>

			<button type="submit"
				class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
				Save Expense
			</button>


		</div>

	</div>
</form>

<script>
	$(document).ready(function() {

		$('#payment_mode').change(function() {

			var mode = $(this).val();

			if (mode === 'BANK') {
				$('#bank_ledger_div').removeClass('hidden');

				$.ajax({
					url: "<?php echo base_url('index.php/Accounts/get_bank_ledgers'); ?>",
					type: "GET",
					dataType: "json",
					success: function(res) {
						var options = '<option value="">Select Bank</option>';

						$.each(res, function(i, obj) {
							options += '<option value="' + obj.account_id + '">' + obj.account_name + '</option>';
						});

						$('#bank_ledger_id').html(options).trigger('change');
					}
				});

			} else {
				$('#bank_ledger_div').addClass('hidden');
				$('#bank_ledger_id').html('<option value="">Select Bank</option>');
			}

		});

		$('#expense_ledger_id').select2({
			placeholder: "Search item...",
			width: '100%'
		});

		$('#bank_ledger_id').select2({
			placeholder: "Search item...",
			width: '100%'
		});
		
	
	});
</script>
