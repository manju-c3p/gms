<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Inspection Items Master
        </h2>

        <a href="<?= base_url('index.php/inspection_master/add'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            + Add Item
        </a>
    </div>

    <!-- Table -->
    <table id="inspectionTable" class="stripe hover w-full text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th>#</th>
                <th>Inspection Item</th>
                <!-- <th>Category</th>
                <th>Status</th> -->
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach($items as $row): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td class="font-medium"><?= $row->item_name; ?></td>
                    
                    <td class="text-center space-x-2">
                        <a href="<?= base_url('index.php/inspection_master/edit/'.$row->item_id); ?>"
                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        <a href="<?= base_url('index.php/inspection_master/delete/'.$row->item_id); ?>"
                           onclick="return confirm('Delete this item?')"
                           class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- DataTable Init -->
<script>
$(document).ready(function () {
    $('#inspectionTable').DataTable({
        pageLength: 10,
        ordering: true,
        responsive: true
    });
});
</script>
