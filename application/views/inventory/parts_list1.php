<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">Spare Parts Inventory</h2>

    <!-- Add Spare Part -->
    <div class="flex justify-end mb-4">
        <a href="<?= base_url('index.php/spareparts/add'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded">
            + Add Part
        </a>
    </div>

    <!-- Table -->
    <table class="w-full border rounded overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Part Name</th>
                <th class="p-3 text-left">Code</th>
                <th class="p-3 text-left">Price</th>
                <th class="p-3 text-left">Stock</th>
                <th class="p-3 text-left">Min Stock</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($parts as $p): ?>

            <?php
                // Low stock highlight
                $low = ($p->stock < $p->min_stock);
            ?>

            <tr class="border-b hover:bg-gray-50 <?= $low ? 'bg-red-50' : '' ?>">

                <td class="p-3 font-medium"><?= $p->part_name ?></td>

                <td class="p-3"><?= $p->part_code ?></td>

                <td class="p-3">₹<?= number_format($p->unit_price, 2) ?></td>

                <td class="p-3 font-bold <?= $low ? 'text-red-600' : 'text-green-700' ?>">
                    <?= $p->stock ?>
                </td>

                <td class="p-3"><?= $p->min_stock ?></td>

                <td class="p-3 text-center flex justify-center gap-3">

                    <!-- Stock In -->
                    <a href="<?= base_url('spareparts/stock_in_form/'.$p->part_id); ?>"
                       class="p-2 bg-blue-100 rounded"
                       title="Stock In">➕</a>

                    <!-- Stock Out -->
                    <a href="<?= base_url('spareparts/stock_out_form/'.$p->part_id); ?>"
                       class="p-2 bg-yellow-100 rounded"
                       title="Stock Out">➖</a>

                    <!-- Edit -->
                    <a href="<?= base_url('spareparts/edit/'.$p->part_id); ?>"
                       class="p-2 bg-green-100 rounded"
                       title="Edit">✏️</a>

                    <!-- Delete -->
                    <a onclick="return confirm('Delete this part?');"
                       href="<?= base_url('spareparts/delete/'.$p->part_id); ?>"
                       class="p-2 bg-red-100 rounded"
                       title="Delete">🗑️</a>

                </td>

            </tr>

            <?php endforeach; ?>
        </tbody>

    </table>

</div>
