<div class="bg-white shadow rounded-xl p-6 w-full">


	
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-700">Edit Salary Advance</h2>

    <a href="<?= base_url('index.php/Hr/salary_advance_list') ?>"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg">
       + List
    </a>
</div>

<form method="post" action="<?= base_url('index.php/Hr/update_salary_advance') ?>">

    <input type="hidden" name="advance_id" value="<?= $advance->advance_id ?>">

    <div class="grid grid-cols-2 gap-4">

        <div>
            <label class="text-sm text-gray-600">Employee</label>
            <select name="emp_id" required class="w-full border rounded-lg px-3 py-2">

                <?php foreach($employees as $e){ ?>
                    <option value="<?= $e->employee_id ?>"
                        <?= ($e->employee_id == $advance->emp_id)?'selected':'' ?>>
                       <?= $e->employee_name ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600">Advance Date</label>
            <input type="date" name="advance_date"
                   value="<?= $advance->advance_date ?>"
                   class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <div>
            <label class="text-sm text-gray-600">Amount</label>
            <input type="number" step="0.01" name="amount"
                   value="<?= $advance->amount ?>"
                   class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <div>
            <label class="text-sm text-gray-600">Payment Mode</label>
            <select name="payment_mode"
                    class="w-full border rounded-lg px-3 py-2" required>

                <option value="CASH" <?= ($advance->payment_mode=='CASH')?'selected':'' ?>>
                    Cash
                </option>

                <option value="BANK" <?= ($advance->payment_mode=='BANK')?'selected':'' ?>>
                    Bank
                </option>

            </select>
        </div>

        <div>
            <label class="text-sm text-gray-600">Cash / Bank Ledger</label>
            <select name="pay_ledger_id"
                    class="w-full border rounded-lg px-3 py-2" required>

                <?php foreach($cash_bank_ledgers as $l){ ?>
                    <option value="<?= $l->account_id ?>"
                        <?= ($l->account_id == $advance->ledger_id)?'selected':'' ?>>
                        <?= $l->account_name ?>
                    </option>
                <?php } ?>

            </select>
        </div>

        <div class="col-span-2">
            <label class="text-sm text-gray-600">Remarks</label>
            <textarea name="remarks"
                      class="w-full border rounded-lg px-3 py-2"><?= htmlspecialchars($advance->remarks) ?></textarea>
        </div>

    </div>

    <div class="mt-6 flex gap-3">

        <button class="bg-green-600 text-white px-6 py-2 rounded-lg">
            Update Advance
        </button>

        <a href="<?= base_url('index.php/Hr/salary_advance_list') ?>"
           class="bg-gray-500 text-white px-6 py-2 rounded-lg">
           Cancel
        </a>

    </div>

</form>


</div>
