<div class="p-6 bg-gray-100 min-h-screen">

    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-2xl font-bold mb-4">Vehicle Model Master</h2>

        <!-- Add Model -->
        <form method="post" action="<?= base_url('index.php/Vehicle/save_model'); ?>"
              class="grid grid-cols-4 gap-4 mb-6">
            <input type="hidden" name="model_id">

            <select name="brand_id" required class="border rounded-lg px-3 py-2">
                <option value="">Select Brand</option>
                <?php foreach($brands as $b): ?>
                    <option value="<?= $b->brand_id ?>"><?= $b->brand_name ?></option>
                <?php endforeach; ?>
            </select>

            <input type="text" name="model_name" required
                   class="border rounded-lg px-3 py-2"
                   placeholder="Model Name">

            <button class="bg-green-600 text-white px-4 py-2 rounded-lg col-span-1">
                Save
            </button>
        </form>

        <!-- Model Table -->
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">#</th>
                    <th class="border px-3 py-2">Brand</th>
                    <th class="border px-3 py-2">Model</th>
                    <th class="border px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($models as $m): ?>
                <tr>
                    <td class="border px-3 py-2"><?= $i++; ?></td>
                    <td class="border px-3 py-2"><?= $m->brand_name ?></td>
                    <td class="border px-3 py-2"><?= $m->model_name ?></td>
                    <td class="border px-3 py-2 text-center">
                        <a href="<?= base_url('index.php/Vehicle/delete_model/'.$m->model_id); ?>"
                           onclick="return confirm('Delete this model?')"
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
