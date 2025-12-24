<div class="w-full  mx-auto bg-white p-6 rounded-2xl shadow-md">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        Edit Inspection Item
    </h2>

    <form method="post" class="space-y-5">

        <div>
            <label class="block text-sm font-semibold mb-1">
                Inspection Item
            </label>
            <input type="text" name="item_name" required
                   value="<?= $item->item_name; ?>"
                   class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
        </div>

        <!-- <div>
            <label class="block text-sm font-semibold mb-1">
                Category
            </label>
            <input type="text" name="category"
                   value=""
                   class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200">
        </div> -->

        <div class="flex justify-end space-x-3">
            <a href="<?= base_url('index.php/inspection_master'); ?>"
               class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Cancel
            </a>

            <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update
            </button>
        </div>

    </form>
</div>
