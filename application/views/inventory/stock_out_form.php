<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">Stock Out - <?= $part->part_name ?></h2>

    <div class="text-gray-600 mb-4">
        Part Code: <strong><?= $part->part_code ?></strong><br>
        Current Stock: 
        <strong>
            <?= $this->SpareParts_model->get_stock($part->part_id); ?>
        </strong>
    </div>

    <form method="POST" action="<?= base_url('index.php/spareparts/stock_out_save'); ?>">

        <input type="hidden" name="part_id" value="<?= $part->part_id ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Qty -->
            <div>
                <label class="font-medium">Quantity</label>
                <input type="number" name="qty" required min="1"
                       class="w-full border p-2 rounded"
                       placeholder="Enter stock out quantity">
            </div>

            <!-- Date -->
            <div>
                <label class="font-medium">Date</label>
                <input type="date" name="date_out" 
                       value="<?= date('Y-m-d') ?>"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Notes -->
            <div class="col-span-2">
                <label class="font-medium">Notes (optional)</label>
                <textarea name="notes" class="w-full border p-2 rounded"
                          placeholder="Reason for stock-out (optional)"></textarea>
            </div>

        </div>

        <br>

        <button class="px-6 py-2 bg-red-600 text-white rounded">
            Stock Out
        </button>

        <a href="<?= base_url('index.php/spareparts'); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Cancel
        </a>

    </form>

</div>
