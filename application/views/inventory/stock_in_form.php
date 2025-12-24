<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">
        Stock In - <?= $part->part_name ?>
    </h2>

    <div class="text-gray-600 mb-4">
        Part Code: <strong><?= $part->part_code ?></strong><br>
        Current Price: <strong>₹<?= $part->unit_price ?></strong>
    </div>

    <form method="POST" action="<?= base_url('index.php/spareparts/stock_in_save'); ?>">

        <input type="hidden" name="part_id" value="<?= $part->part_id ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Quantity -->
            <div>
                <label class="font-medium">Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="qty" required
                       class="w-full border p-2 rounded"
                       placeholder="Enter quantity received">
            </div>

            <!-- Date In -->
            <div>
                <label class="font-medium">Date Received</label>
                <input type="date" name="date_in"
                       value="<?= date('Y-m-d'); ?>"
                       class="w-full border p-2 rounded">
            </div>

        </div>

        <br>

        <button class="px-6 py-2 bg-blue-600 text-white rounded">
            Save Stock In
        </button>

        <a href="<?= base_url('index.php/spareparts'); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Cancel
        </a>

    </form>

</div>
