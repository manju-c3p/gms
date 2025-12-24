<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">
        Edit Claim - <?= $claim->claim_number ?>
    </h2>

    <!-- Policy + Vehicle Info -->
    <div class="text-gray-600 mb-4 leading-relaxed">
        <div>Policy: <strong><?= $claim->policy_number ?></strong></div>
        <div>Vehicle: <strong><?= $claim->registration_no ?></strong></div>
    </div>

    <form method="POST" action="<?= base_url('index.php/claim/update'); ?>" enctype="multipart/form-data">

        <input type="hidden" name="claim_id" value="<?= $claim->claim_id ?>">
        <input type="hidden" name="policy_id" value="<?= $claim->policy_id ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Claim Date -->
            <div>
                <label class="font-medium">Claim Date</label>
                <input type="date" name="claim_date"
                       value="<?= $claim->claim_date ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Claim Number -->
            <div>
                <label class="font-medium">Claim Number</label>
                <input type="text" name="claim_number"
                       value="<?= $claim->claim_number ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Claim Amount -->
            <div>
                <label class="font-medium">Claim Amount</label>
                <input type="number" step="0.01" name="claim_amount"
                       value="<?= $claim->claim_amount ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Status -->
            <div>
                <label class="font-medium">Status</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Pending"      <?= $claim->status == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress"  <?= $claim->status == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Approved"     <?= $claim->status == 'Approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="Rejected"     <?= $claim->status == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    <option value="Settled"      <?= $claim->status == 'Settled' ? 'selected' : '' ?>>Settled</option>
                </select>
            </div>

            <!-- Description -->
            <div class="col-span-2">
                <label class="font-medium">Description</label>
                <textarea name="description"
                          class="w-full border p-2 rounded"
                          placeholder="Accident / damage / case summary"><?= $claim->description ?></textarea>
            </div>

            <!-- Notes -->
            <div class="col-span-2">
                <label class="font-medium">Notes</label>
                <textarea name="notes"
                          class="w-full border p-2 rounded"
                          placeholder="Additional notes"><?= $claim->notes ?></textarea>
            </div>

            <!-- Existing Documents -->
            <div class="col-span-2">
                <label class="font-medium">Existing Documents</label>

                <?php if (!empty($documents)): ?>
                    <div class="mt-2 grid grid-cols-3 gap-3">

                        <?php foreach ($documents as $d): ?>

                            <div class="border p-3 rounded bg-gray-100 flex items-center justify-between">
                                <div class="text-sm truncate">
                                    <?= $d->document_path ?>
                                </div>

                                <a href="<?= base_url('uploads/claims/'.$d->document_path) ?>"
                                   target="_blank"
                                   class="px-2 py-1 text-blue-600 underline text-sm">
                                   View
                                </a>
                            </div>

                        <?php endforeach; ?>

                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-sm mt-1">No documents uploaded.</p>
                <?php endif; ?>
            </div>

            <!-- Upload New Documents -->
            <div class="col-span-2">
                <label class="font-medium">Upload New Documents (optional)</label>
                <input type="file" name="documents[]" multiple
                       class="w-full border p-2 rounded bg-white">

                <p class="text-sm text-gray-500 mt-1">
                    You can upload multiple new documents (JPG, PNG, PDF).
                </p>
            </div>

        </div>

        <br>

        <button class="px-6 py-2 bg-blue-600 text-white rounded">
            Update Claim
        </button>

        <a href="<?= base_url('index.php/claim/list/'.$claim->policy_id); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Back
        </a>

    </form>

</div>
