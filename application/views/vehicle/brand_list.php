<div class="p-6 bg-gray-100 min-h-screen">

    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-bold mb-4">Vehicle Brand Master</h2>

        <!-- Add Brand -->
        <form method="post" action="<?= base_url('index.php/Vehicle/save_brand'); ?>"
              class="flex gap-3 mb-6">
            <input type="hidden" name="brand_id">
            <input type="text" name="brand_name" required
                   class="border rounded-lg px-3 py-2 w-64"
                   placeholder="Brand Name">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                Save
            </button>
        </form>

        <!-- Brand Table -->
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">Brand Name</th>
                    <th class="border px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($brands as $b): ?>
                <tr>
                    <td class="border px-3 py-2"><?= $i++; ?></td>
                    <td class="border px-3 py-2"><?= $b->brand_name; ?></td>
                    <td class="border px-3 py-2 text-center">
                        <a href="<?= base_url('index.php/Vehicle/delete_brand/'.$b->brand_id); ?>"
                           onclick="return confirm('Delete this brand?')"
                           class="text-red-600 font-semibold">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>
