<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Accounts Group
        </h2>

        <a href="<?= base_url('index.php/Accounts/view_account_group_form'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            + Add Group
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-md p-6">

        <div class="overflow-x-auto">
            <table id="accountGroupTable"
                   class="min-w-full text-sm text-left text-gray-700">

                <!-- Table Head -->
                <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Account Code</th>
                        <th class="px-4 py-3">Group Name</th>
                        <th class="px-4 py-3">Account Type</th>
                        <th class="px-4 py-3">Parent Group</th>
                        <!-- <th class="px-4 py-3 text-center">Action</th> -->
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y">
                    <?php if (!empty($account_records)) : ?>
                        <?php foreach ($account_records as $row) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">
                                    <?= $row->group_code; ?>
                                </td>

                                <td class="px-4 py-3">
                                    <?= $row->group_name; ?>
                                </td>

                                <td class="px-4 py-3">
                                    <?php if ($row->pandl == 0): ?>
                                        <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs font-semibold">
                                            Balance Sheet
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-semibold">
                                            Profit &amp; Loss
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-4 py-3">
                                    <?= $row->parent ?: '-'; ?>
                                </td>

                                <!-- Action column (optional – keep commented for now) -->
                                <!--
                                <td class="px-4 py-3 text-center">
                                    <a href="<?= base_url('index.php/accounts/edit_account_group_form/' . $row->group_no); ?>"
                                       class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">
                                        Edit
                                    </a>

                                    <button onclick="deleteGroup(<?= $row->group_no; ?>)"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 ml-2">
                                        Delete
                                    </button>
                                </td>
                                -->
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                No account groups found
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
        $('#accountGroupTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']]
        });
    });
</script>
