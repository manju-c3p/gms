<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="w-full  mx-auto bg-white p-6 rounded-2xl shadow-md">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Works Requested – Master
        </h2>

        <a href="<?= base_url('index.php/works_requested/add'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            + Add Work
        </a>
    </div>

    <table id="worksTable" class="stripe hover w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th>#</th>
                <th>Work Name</th>
                <th>Description</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($works as $w): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td class="font-medium"><?= $w->work_name; ?></td>
                    <td><?= $w->description ?: '-'; ?></td>
                    <td class="text-center space-x-2">
                        <a href="<?= base_url('index.php/works_requested/edit/'.$w->work_id); ?>"
                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Edit
                        </a>

                        <a href="<?= base_url('index.php/works_requested/delete/'.$w->work_id); ?>"
                           onclick="return confirm('Delete this work?')"
                           class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    $('#worksTable').DataTable({
        pageLength: 10,
        ordering: true,
        responsive: true
    });
});
</script>
