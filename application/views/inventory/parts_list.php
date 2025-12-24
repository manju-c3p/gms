<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">Spare Parts Inventory</h2>

    <div class="flex justify-end mb-4">
        <a href="<?= base_url('index.php/spareparts/add'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded">
            + Add Spare Part
        </a>
    </div>

    <table class="w-full border rounded overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Part Name</th>
                <th class="p-3 text-left">Part Code</th>
                <th class="p-3 text-left">Unit Price</th>
                <th class="p-3 text-left">Current Stock</th>
				<th class="p-3 text-left">Min Stock</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($parts as $p): ?>
                <?php 
                    $lowStock = ($p->stock < $p->min_stock);
                ?>

                <tr class="border-b hover:bg-gray-50 <?= $lowStock ? 'bg-red-50' : '' ?>">

                    <!-- Part Name -->
                    <td class="p-3">
                        <?= $p->part_name ?>
                        <?php if ($lowStock): ?>
                            <span class="text-xs text-red-600">(Low Stock)</span>
                        <?php endif; ?>
                    </td>

                    <!-- Code -->
                    <td class="p-3"><?= $p->part_code ?></td>

                    <!-- Price -->
                    <td class="p-3">₹<?= $p->unit_price ?></td>

                    <!-- Stock -->
                    <td class="p-3 font-bold <?= $lowStock ? 'text-red-600' : '' ?>">
                        <?= $p->stock ?>
                    </td>
 <td class="p-3"><?= $p->min_stock ?></td>

                    <!-- Actions -->
                    <td class="p-3 text-center">
                        <div class="flex justify-center gap-2">

                            <!-- Stock IN -->
                            <a href="<?= base_url('index.php/spareparts/stock_in_form/'.$p->part_id); ?>"
                               class="px-3 py-1 bg-blue-100 rounded text-blue-700"
                               title="Add Stock">
                                + Stock In
                            </a>

                            <!-- Stock OUT -->
                            <a href="<?= base_url('index.php/spareparts/stock_out_form/'.$p->part_id); ?>"
                               class="px-3 py-1 bg-yellow-100 rounded text-yellow-700"
                               title="Remove Stock">
                                − Stock Out
                            </a>

                            <!-- Edit -->
                            <a href="<?= base_url('index.php/spareparts/edit/'.$p->part_id); ?>"
                               class="px-3 py-1 bg-green-100 rounded text-green-700"
                               title="Edit">
                                ✏️
                            </a>

                            <!-- Delete -->
                            <a onclick="return confirm('Delete this part?');"
                               href="<?= base_url('index.php/spareparts/delete/'.$p->part_id); ?>"
                               class="px-3 py-1 bg-red-100 rounded text-red-700"
                               title="Delete">
                                🗑️
                            </a>

                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>
