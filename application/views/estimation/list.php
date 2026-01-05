<div class="bg-white rounded-2xl shadow p-6">

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">Estimations</h2>

        <a href="<?= base_url('index.php/estimation/add'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded">
            + New Estimation
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="estimationTable"
               class="min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-center">#</th>
                    <th class="border px-3 py-2">Estimation No</th>
                    <th class="border px-3 py-2">Customer</th>
                    <th class="border px-3 py-2">Vehicle</th>
                    <th class="border px-3 py-2 text-right">Amount</th>
                    <th class="border px-3 py-2 text-center">Status</th>
                    <th class="border px-3 py-2 text-center">Job Card</th>
                    <th class="border px-3 py-2 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($estimations)): ?>
                <?php $sl = 1; foreach ($estimations as $e): ?>
                    <tr class="hover:bg-gray-50">

                        <!-- SL -->
                        <td class="border px-3 py-2 text-center font-medium">
                            <?= $sl++ ?>
                        </td>

                        <!-- Estimation No -->
                        <td class="border px-3 py-2 font-medium">
                            <?= $e->estimation_no ?><br>
                            <span class="text-xs text-gray-500">
                                <?= date('d-m-Y', strtotime($e->estimation_date)) ?>
                            </span>
                        </td>

                        <!-- Customer -->
                        <td class="border px-3 py-2">
                            <div class="font-medium"><?= $e->customer_name ?></div>
                            <div class="text-xs text-gray-500"><?= $e->customer_phone ?></div>
                        </td>

                        <!-- Vehicle -->
                        <td class="border px-3 py-2">
                            <div class="font-medium"><?= $e->registration_no ?></div>
                            <div class="text-xs text-gray-500">
                                <?= $e->brand ?> <?= $e->model ?>
                            </div>
                        </td>

                        <!-- Amount -->
                        <td class="border px-3 py-2 text-right">
                            ₹<?= number_format($e->grand_total, 2) ?>
                        </td>

                        <!-- Status -->
                        <td class="border px-3 py-2 text-center">
                            <?php if ($e->status == 'Draft'): ?>
                                <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                    Draft
                                </span>
                            <?php elseif ($e->status == 'Approved'): ?>
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Approved
                                </span>
                            <?php elseif ($e->status == 'Rejected'): ?>
                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                    Rejected
                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-700">
                                    Converted
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Job Card -->
                        <td class="border px-3 py-2 text-center">
                            <?php if ($e->status == 'Approved'): ?>
                                <a href="<?= base_url('index.php/jobcard/create/'.$e->appointment_id); ?>"
                                   class="px-3 py-1 text-xs bg-indigo-600 text-white rounded">
                                    Create
                                </a>
                            <?php else: ?>
                                <span class="px-3 py-1 text-xs bg-gray-200 text-gray-500 rounded">
                                    Not Allowed
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Actions -->
                        <td class="border px-3 py-2 text-center space-x-1">
                            <a href="<?= base_url('index.php/estimation/edit/'.$e->estimation_id); ?>"
                               class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
                                Edit
                            </a>

                            <a href="<?= base_url('index.php/estimation/delete/'.$e->estimation_id); ?>"
                               onclick="return confirm('Delete this estimation?');"
                               class="px-2 py-1 bg-red-100 text-red-700 rounded">
                                Delete
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8"
                        class="border px-3 py-6 text-center text-gray-500">
                        No estimations found
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<script>
$(document).ready(function () {
    $('#estimationTable').DataTable({
        pageLength: 10,
        order: [[1, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 6, 7] }
        ]
    });
});
</script>
