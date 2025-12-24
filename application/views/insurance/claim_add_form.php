<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">
        Add Claim - Policy <?= $policy->policy_number ?>
    </h2>

    <div class="text-gray-600 mb-4">
        Vehicle: <strong><?= $policy->registration_no ?></strong><br>
        Company: <strong><?= $policy->company_name ?></strong>
    </div>

    <form method="POST" action="<?= base_url('index.php/claim/save'); ?>" enctype="multipart/form-data">

        <input type="hidden" name="policy_id" value="<?= $policy->policy_id ?>">

        <div class="grid grid-cols-2 gap-4">


            <!-- Claim Date -->
            <div>
                <label class="font-medium">Claim Date</label>
                <input type="date" name="claim_date"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Claim Number -->
            <div>
                <label class="font-medium">Claim Number</label>
                <input type="text" name="claim_number"
                       class="w-full border p-2 rounded"
                       placeholder="Enter claim ID / reference number">
            </div>

            <!-- Claim Amount -->
            <div>
                <label class="font-medium">Claim Amount</label>
                <input type="number" step="0.01" name="claim_amount"
                       class="w-full border p-2 rounded"
                       placeholder="0.00">
            </div>

            <!-- Claim Status -->
            <div>
                <label class="font-medium">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Settled">Settled</option>
                </select>
            </div>

            <!-- Description -->
            <div class="col-span-2">
                <label class="font-medium">Description (Issue / Accident Summary)</label>
                <textarea name="description" class="w-full border p-2 rounded"
                          placeholder="Describe accident, damage, report etc."></textarea>
            </div>

            <!-- Notes -->
            <div class="col-span-2">
                <label class="font-medium">Notes</label>
                <textarea name="notes" class="w-full border p-2 rounded"
                          placeholder="Extra notes, surveyor details, reminders"></textarea>
            </div>

            <!-- Upload Documents -->
            <div class="col-span-2">
                <label class="font-medium">Upload Documents (Multiple Allowed)</label>
                <input type="file" name="documents[]" multiple
                       class="w-full border p-2 rounded bg-white">
                <p class="text-sm text-gray-500 mt-1">
                    Allowed: PDF, JPG, PNG | You can upload multiple images/files.
                </p>
            </div>

        </div>

        <br>

        <button class="px-6 py-2 bg-blue-600 text-white rounded">
            Save Claim
        </button>

        <a href="<?= base_url('index.php/claim/list/'.$policy->policy_id); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Cancel
        </a>

    </form>
</div>
