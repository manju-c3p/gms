<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<div class="page-header">
		<h2 class="text-center text-xl font-bold mb-4">
			Job Card
		</h2>
	</div>

	<?php if ($this->session->flashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Error:</strong>
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <strong>Success:</strong>
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('index.php/materialissue/store') ?>">

    <!-- ===============================
         HIDDEN FIELDS
    ================================ -->
    <input type="hidden" name="jobcard_id" value="<?= $jobcard->jobcard_id ?>">

    <!-- ===============================
         PAGE HEADER
    ================================ -->
    <div class="bg-white rounded-2xl shadow-md mb-6 overflow-hidden">

        <div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
            Material Issue
        </div>

        <div class="p-6 grid grid-cols-4 gap-4 text-sm">

            <div>
                <label class="block text-gray-500">Job Card No</label>
                <input type="text"
                       class="w-full border rounded px-2 py-1 bg-gray-100"
                       value="<?= $jobcard->jobcard_no ?>"
                       readonly>
            </div>

            <div>
                <label class="block text-gray-500">Issue Date</label>
                <input type="date"
                       name="issue_date"
                       class="w-full border rounded px-2 py-1"
                       value="<?= date('Y-m-d') ?>">
            </div>

            <div>
                <label class="block text-gray-500">Customer</label>
                <input type="text"
                       class="w-full border rounded px-2 py-1 bg-gray-100"
                       value="<?= $jobcard->customer_name ?>"
                       readonly>
            </div>

            <div>
                <label class="block text-gray-500">Vehicle</label>
                <input type="text"
                       class="w-full border rounded px-2 py-1 bg-gray-100"
                       value="<?= $jobcard->registration_no ?>"
                       readonly>
            </div>

        </div>
    </div>

    <!-- ===============================
         SPARE PARTS ISSUE TABLE
    ================================ -->
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

        <div class="px-6 py-3 font-semibold bg-gray-100 border-b">
            Spare Parts Issue
        </div>

        <div class="p-4">

            <table class="w-full text-sm border-collapse" id="issueTable">

                <thead>
                    <tr class="bg-gray-50 border">
                        <th class="border px-3 py-2 w-[50px] text-center">Sl</th>
                        <th class="border px-3 py-2">Part</th>
                        <th class="border px-3 py-2 w-[100px] text-center">Planned Qty</th>
                        <th class="border px-3 py-2 w-[120px] text-center">Already Issued</th>
                        <th class="border px-3 py-2 w-[110px] text-center">Issue Now</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($jobcard_parts)): ?>
                        <?php foreach ($jobcard_parts as $i => $p): 
                            $issued = $p->issued_qty ?? 0;
                            $remaining = $p->qty - $issued;
                        ?>
                            <tr class="border hover:bg-gray-50">

                                <td class="border px-3 py-2 text-center font-medium">
                                    <?= $i + 1 ?>
                                </td>

                                <td class="border px-3 py-2">
                                    <?= $p->part_name ?>
                                    <input type="hidden" name="part_id[]" value="<?= $p->part_id ?>">
                                </td>

                                <td class="border px-3 py-2 text-center">
                                    <?= $p->qty ?>
                                </td>

                                <td class="border px-3 py-2 text-center text-gray-600">
                                    <?= $issued ?>
                                </td>

                                <td class="border px-3 py-2 text-center">
                                    <?php if ($remaining > 0): ?>
                                        <input type="number"
                                               name="issue_qty[]"
                                               min="0"
                                               max="<?= $remaining ?>"
                                               class="w-full border rounded px-2 py-1 text-center issueQty"
                                               placeholder="0">
                                    <?php else: ?>
                                        <span class="text-green-600 font-medium">
                                            Completed
                                        </span>
                                        <input type="hidden" name="issue_qty[]" value="0">
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">
                                No spare parts added to this Job Card
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>

    <!-- ===============================
         REMARKS
    ================================ -->
    <div class="bg-white rounded-2xl shadow-md mt-6 p-6">

        <label class="block font-medium mb-1">Remarks</label>
        <textarea name="remarks"
                  class="w-full border rounded px-3 py-2 h-20"
                  placeholder="Material issue remarks (optional)"></textarea>

    </div>

    <!-- ===============================
         ACTION BUTTONS
    ================================ -->
    <div class="flex justify-end gap-3 mt-6">

        <a href="<?= base_url('jobcard/view/'.$jobcard->jobcard_id) ?>"
           class="px-4 py-2 border rounded">
            Back
        </a>

        <button type="submit"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
            Save Material Issue
        </button>

    </div>

</form>
</div>
