<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-6 text-red-700 flex items-center gap-2">
        ⚠️ Low Stock Alerts
    </h2>

    <?php if (empty($low_stock)): ?>
        <div class="p-4 bg-green-100 text-green-700 rounded">
            All spare parts have sufficient stock. 👍
        </div>
    <?php else: ?>

        <table class="w-full border rounded overflow-hidden">
            <thead class="bg-red-100 text-red-800">
                <tr>
                    <th class="p-3 text-left">Part Name</th>
                    <th class="p-3 text-left">Code</th>
                    <th class="p-3 text-left">Current Stock</th>
                    <th class="p-3 text-left">Minimum Stock</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($low_stock as $p): ?>
                    <tr class="border-b hover:bg-red-50">

                        <td class="p-3 font-semibold text-red-700">
                            <?= $p->part_name ?>
                        </td>

                        <td class="p-3">
                            <?= $p->part_code ?: '-' ?>
                        </td>

                        <td class="p-3 font-bold text-red-600">
                            <?= $p->current_stock ?>
                        </td>

                        <td class="p-3 font-bold">
                            <?= $p->min_stock ?>
                        </td>

                        <td class="p-3 text-center flex justify-center gap-3">

                            <!-- Stock In -->
                            <a href="<?= base_url('spareparts/stock_in_form/'.$p->part_id); ?>"
                               class="p-2 bg-blue-100 rounded"
                               title="Add Stock">
                                ➕
                            </a>

                            <!-- Edit Part -->
                            <a href="<?= base_url('spareparts/edit/'.$p->part_id); ?>"
                               class="p-2 bg-yellow-100 rounded"
                               title="Edit Part">
                                ✏️
                            </a>

                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>
