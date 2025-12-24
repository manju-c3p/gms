<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Claim Details</h2>

        <button onclick="window.print()"
                class="px-4 py-2 bg-blue-600 text-white rounded">
            🖨 Print
        </button>
    </div>

    <!-- CLAIM INFO CARD -->
    <div class="border rounded-xl p-5 bg-gray-50 mb-6">

        <!-- Basic Info -->
        <h3 class="text-xl font-semibold mb-3">Claim Information</h3>

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="font-medium text-gray-600">Claim Number</label>
                <div class="font-bold"><?= $claim->claim_number ?></div>
            </div>

            <div>
                <label class="font-medium text-gray-600">Claim Date</label>
                <div class="font-bold"><?= $claim->claim_date ?></div>
            </div>

            <div>
                <label class="font-medium text-gray-600">Claim Amount</label>
                <div class="font-bold">₹<?= $claim->claim_amount ?></div>
            </div>

            <div>
                <label class="font-medium text-gray-600">Status</label>
                <div class="font-bold"><?= $claim->status ?></div>
            </div>

            <div class="col-span-2">
                <label class="font-medium text-gray-600">Description</label>
                <div class="bg-white border rounded p-3 mt-1">
                    <?= nl2br($claim->description) ?>
                </div>
            </div>

            <div class="col-span-2">
                <label class="font-medium text-gray-600">Notes</label>
                <div class="bg-white border rounded p-3 mt-1">
                    <?= nl2br($claim->notes) ?>
                </div>
            </div>

        </div>

    </div>

    <!-- POLICY & VEHICLE INFO -->
    <div class="border rounded-xl p-5 bg-gray-50 mb-6">

        <h3 class="text-xl font-semibold mb-3">Policy & Vehicle Information</h3>

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="font-medium text-gray-600">Policy Number</label>
                <div class="font-bold"><?= $claim->policy_number ?></div>
            </div>

            <div>
                <label class="font-medium text-gray-600">Insurance Company</label>
                <div class="font-bold"><?= $claim->company_name ?></div>
            </div>

            <div>
                <label class="font-medium text-gray-600">Vehicle Number</label>
                <div class="font-bold"><?= $claim->registration_no ?></div>
            </div>

            <div>
                <label class="font-medium text-gray-600">Vehicle Model</label>
                <div class="font-bold"><?= $claim->brand ?> <?= $claim->model ?></div>
            </div>

        </div>

    </div>

    <!-- DOCUMENTS SECTION -->
    <div class="border rounded-xl p-5 bg-gray-50">

        <h3 class="text-xl font-semibold mb-3">Uploaded Documents</h3>

        <?php if (!empty($documents)): ?>
            <div class="grid grid-cols-3 gap-4">

                <?php foreach ($documents as $d): ?>
                    <div class="border rounded p-3 bg-white flex items-center justify-between">

                        <span class="truncate text-sm text-gray-700">
                            <?= $d->document_path ?>
                        </span>

                        <a href="<?= base_url('uploads/claims/'.$d->document_path) ?>"
                           target="_blank"
                           class="px-2 py-1 text-blue-600 underline text-sm">
                           View
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php else: ?>
            <div class="text-gray-500">No documents uploaded.</div>
        <?php endif; ?>

    </div>

</div>

<!-- PRINT CSS -->
<style>
@media print {
    button { display: none !important; }
    body { background: white; }
    div { box-shadow: none !important; }
}
</style>
