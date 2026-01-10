<!-- DataTables (Tailwind) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="p-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            General Ledger Accounts
        </h2>

        <a href="<?= base_url('index.php/Accounts/view_general_ledger_account_form'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            + Add Ledger Account
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-md p-6">

        <div class="overflow-x-auto">
            <table id="ledgerTable"
                   class="min-w-full text-sm text-left text-gray-700">

                <!-- Table Head -->
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Account Code</th>
                        <th class="px-4 py-3">Account Name</th>
                        <th class="px-4 py-3">Account Group</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y">
                <?php if (!empty($ledger_records)) : ?>
                    <?php foreach ($ledger_records as $row) : ?>

                        <?php
                            $canDelete =
                                ($row->group_name === 'Farmer' ||
                                 $row->group_name === 'Vendors/Suppliers');
                        ?>

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3 font-medium">
                                <?= $row->account_id; ?>
                            </td>

                            <td class="px-4 py-3">
                                <?= $row->account_name; ?>
                            </td>

                            <td class="px-4 py-3">
                                <?= $row->group_name; ?>
                            </td>

                            <!-- Action column (ALWAYS SAME STRUCTURE) -->
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">

                                    <!-- Edit -->
                                    <a href="<?= base_url('index.php/Accounts/edit_general_ledger_account_form/' . $row->account_id); ?>"
                                       class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200"
                                       title="Edit">
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <button
                                        onclick="deleteLedger(<?= $row->account_id; ?>)"
                                        class="px-3 py-1 rounded
                                            <?= $canDelete
                                                ? 'bg-red-100 text-red-700 hover:bg-red-200'
                                                : 'bg-gray-200 text-gray-400 cursor-not-allowed' ?>"
                                        <?= !$canDelete ? 'disabled' : '' ?>
                                        title="<?= $canDelete ? 'Delete' : 'Delete not allowed' ?>">
                                        Delete
                                    </button>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            No ledger accounts found
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>
<script>
$(document).ready(function () {
    $('#ledgerTable').DataTable({
        pageLength: 10,
        order: [[0, 'DESC']],
        autoWidth: false
    });
});
</script>
<script>
function deleteLedger(id) {

    if (!confirm("Are you sure you want to delete this ledger record?")) {
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/accounts/delete_ledger_record'); ?>",
        type: "POST",
        dataType: "json",
        data: { account_id: id },
        success: function (res) {
            if (res == 1) {
                alert("The record is deleted!");
                location.reload();
            } else {
                alert("The record could not be deleted!");
            }
        },
        error: function () {
            alert("Cannot delete master records");
        }
    });
}
</script>
