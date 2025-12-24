<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">
        Add Insurance Policy - <?= $vehicle->registration_no ?>
    </h2>

    <form method="POST" action="<?= base_url('index.php/policy/save'); ?>" enctype="multipart/form-data">

        <input type="hidden" name="vehicle_id" value="<?= $vehicle->vehicle_id ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Insurance Company -->
            <div class="col-span-2">
                <label class="font-medium">Insurance Company <span class="text-red-500">*</span></label>
                <select name="company_id" required class="w-full border p-2 rounded">
                    <option value="">Select Company</option>
                    <?php foreach ($companies as $c): ?>
                        <option value="<?= $c->company_id ?>"><?= $c->company_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Policy Number -->
            <div>
                <label class="font-medium">Policy Number</label>
                <input type="text" name="policy_number"
                       class="w-full border p-2 rounded"
                       placeholder="Enter policy number">
            </div>

            <!-- Premium -->
            <div>
                <label class="font-medium">Premium Amount</label>
                <input type="number" name="premium_amount" step="0.01"
                       class="w-full border p-2 rounded"
                       placeholder="0.00">
            </div>

            <!-- Start Date -->
            <div>
                <label class="font-medium">Start Date</label>
                <input type="date" name="start_date"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="font-medium">Expiry Date</label>
                <input type="date" name="expiry_date"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Coverage Details -->
            <div class="col-span-2">
                <label class="font-medium">Coverage Details</label>
                <textarea name="coverage_details"
                          class="w-full border p-2 rounded"
                          placeholder="What is covered by the policy?"></textarea>
            </div>

            <!-- Notes -->
            <div class="col-span-2">
                <label class="font-medium">Notes</label>
                <textarea name="notes"
                          class="w-full border p-2 rounded"
                          placeholder="Extra notes"></textarea>
            </div>

            <!-- Policy Document Upload -->
            <div class="col-span-2">
                <label class="font-medium">Policy Document (PDF / Image)</label>
                <input type="file" name="policy_document"
                       class="w-full border p-2 rounded bg-white">
            </div>

        </div>

        <br>

        <button class="px-6 py-2 bg-blue-600 text-white rounded">
            Save Policy
        </button>

        <a href="<?= base_url('index.php/policy/list/'.$vehicle->vehicle_id); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Cancel
        </a>

    </form>

</div>
