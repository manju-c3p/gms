<div class="bg-white shadow rounded-xl p-6 w-full ">

	
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-700">Salary Advance Payment</h2>

    <a href="<?= base_url('index.php/Hr/salary_advance_list') ?>"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg">
       + List
    </a>
</div>
	<form method="post" action="<?= base_url('index.php/Hr/save_salary_advance') ?>">

		<div class="grid grid-cols-2 gap-4">

			<div>
				<label class="text-sm text-gray-600">Employee</label>
				<select name="emp_id" required
					class="w-full border rounded-lg px-3 py-2">
					<option value="">Select Employee</option>
					<?php foreach($employees as $e){ ?>
						<option value="<?= $e->employee_id ?>">
							<?= $e->employee_name ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div>
				<label class="text-sm text-gray-600">Advance Date</label>
				<input type="date" name="advance_date"
					class="w-full border rounded-lg px-3 py-2"
					value="<?= date('Y-m-d') ?>" required>
			</div>

			<div>
				<label class="text-sm text-gray-600">Amount</label>
				<input type="number" step="0.01" name="amount"
					class="w-full border rounded-lg px-3 py-2" required>
			</div>

			<div>
				<label class="text-sm text-gray-600">Payment Mode</label>
				<select name="payment_mode"
					class="w-full border rounded-lg px-3 py-2" required>
					<option value="CASH">Cash</option>
					<option value="BANK">Bank</option>
				</select>
			</div>

			<div>
				<label class="text-sm text-gray-600">Cash / Bank Ledger</label>
				<select name="pay_ledger_id"
					class="w-full border rounded-lg px-3 py-2" required>
					<?php foreach($cash_bank_ledgers as $l){ ?>
						<option value="<?= $l->account_id ?>">
							<?= $l->account_name ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-span-2">
				<label class="text-sm text-gray-600">Remarks</label>
				<textarea name="remarks"
					class="w-full border rounded-lg px-3 py-2"></textarea>
			</div>

		</div>

		<div class="mt-6">
			<button class="bg-blue-600 text-white px-6 py-2 rounded-lg">
				Save Advance
			</button>
		</div>

	</form>

</div>
