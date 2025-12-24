<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">Add Spare Part</h2>

    <form method="POST" action="<?= base_url('index.php/spareparts/save'); ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Part Name -->
            <div class="col-span-2">
                <label class="font-medium">Part Name <span class="text-red-500">*</span></label>
                <input type="text" name="part_name" required
                       class="w-full border p-2 rounded"
                       placeholder="Brake Pad / Oil Filter / Battery etc.">
            </div>

            <!-- Part Code -->
            <div>
                <label class="font-medium">Part Code</label>
                <input type="text" name="part_code"
                       class="w-full border p-2 rounded"
                       placeholder="Optional code / SKU">
            </div>

            <!-- Unit Price -->
            <div>
                <label class="font-medium">Unit Price (₹)</label>
                <input type="number" step="0.01" name="unit_price"
                       class="w-full border p-2 rounded"
                       placeholder="0.00">
            </div>

            <!-- Minimum Stock Alert -->
            <div>
                <label class="font-medium">Minimum Stock</label>
                <input type="number" name="min_stock"
                       class="w-full border p-2 rounded"
                       placeholder="Alert when stock is below this">
            </div>

        </div>

        <br>

        <!-- Buttons -->
        <button class="px-6 py-2 bg-blue-600 text-white rounded">
            Save Part
        </button>

        <a href="<?= base_url('index.php/spareparts'); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Cancel
        </a>

    </form>
</div>
