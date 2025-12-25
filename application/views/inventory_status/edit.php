<div class="w-full  mx-auto bg-white p-6 rounded-2xl shadow-md">

    <h2 class="text-2xl font-bold mb-6">Edit Inventory Status</h2>

    <form method="post" class="space-y-5">

        <div>
            <label class="block font-semibold mb-1">Status Name</label>
            <input type="text" name="status_name" required
                   value="<?= $status->status_name; ?>"
                   class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div>
            <label class="block font-semibold mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-2 border rounded-lg"><?= $status->description; ?></textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="<?= base_url('index.php/inventory_status'); ?>"
               class="px-4 py-2 border rounded-lg">
                Cancel
            </a>
            <button class="px-5 py-2 bg-blue-600 text-white rounded-lg">
                Update
            </button>
        </div>

    </form>
</div>
