<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">
        Edit Insurance Policy - <?= $policy->policy_number ?>
    </h2>

    <form method="POST" action="<?= base_url('index.php/policy/update'); ?>" enctype="multipart/form-data">

        <input type="hidden" name="policy_id" value="<?= $policy->policy_id ?>">
        <input type="hidden" name="vehicle_id" value="<?= $policy->vehicle_id ?>">

        <!-- Keep existing file name -->
        <input type="hidden" name="existing_file" value="<?= $policy->policy_document ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Insurance Company -->
            <div class="col-span-2">
                <label class="font-medium">Insurance Company <span class="text-red-500">*</span></label>
                <select name="company_id" required class="w-full border p-2 rounded">
                    <option value="">Select Company</option>
                    <?php foreach ($companies as $c): ?>
                        <option value="<?= $c->company_id ?>"
                            <?= ($policy->company_id == $c->company_id) ? 'selected' : '' ?>>
                            <?= $c->company_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Policy Number -->
            <div>
                <label class="font-medium">Policy Number</label>
                <input type="text" name="policy_number"
                       value="<?= $policy->policy_number ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Premium -->
            <div>
                <label class="font-medium">Premium Amount</label>
                <input type="number" name="premium_amount" step="0.01"
                       value="<?= $policy->premium_amount ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Start Date -->
            <div>
                <label class="font-medium">Start Date</label>
                <input type="date" name="start_date"
                       value="<?= $policy->start_date ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="font-medium">Expiry Date</label>
                <input type="date" name="expiry_date"
                       value="<?= $policy->expiry_date ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Coverage Details -->
            <div class="col-span-2">
                <label class="font-medium">Coverage Details</label>
                <textarea name="coverage_details"
                          class="w-full border p-2 rounded"><?= $policy->coverage_details ?></textarea>
            </div>

            <!-- Notes -->
            <div class="col-span-2">
                <label class="font-medium">Notes</label>
                <textarea name="notes"
                          class="w-full border p-2 rounded"><?= $policy->notes ?></textarea>
            </div>

            <!-- Current Document -->
            <div class="col-span-2">
                <label class="font-medium">Existing Document</label><br>

                <?php if ($policy->policy_document): ?>
                    <a href="<?= base_url('uploads/policies/'.$policy->policy_document); ?>"
                       class="text-blue-600 underline"
                       target="_blank">View Current File</a>
                <?php else: ?>
                    <span class="text-gray-500">No document uploaded</span>
                <?php endif; ?>
            </div>

            <!-- Upload New Document -->
            <div class="col-span-2">
                <label class="font-medium">Upload New Document (optional)</label>
                <input type="file" name="policy_document"
                       class="w-full border p-2 rounded bg-white">
            </div>

        </div>

        <br>

        <button class="px-6 py-2 bg-blue-600 text-white rounded">
            Update Policy
        </button>

        <a href="<?= base_url('index.php/policy/list/'.$policy->vehicle_id); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Cancel
        </a>

    </form>

</div>
