<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Appointment List</h2>

        <a href="<?= base_url('index.php/appointment/add'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded">
           + Add Appointment
        </a>
    </div>

    <!-- DataTable -->
    <table id="appointmentTable"
           class="w-full border rounded text-sm">

        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">SL</th>
                <th class="p-3 text-left">Customer</th>
                <th class="p-3 text-left">Vehicle</th>
                <th class="p-3 text-left">Date</th>
                <th class="p-3 text-left">Time</th>
                <th class="p-3 text-left">Service Type</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php $i = 1; foreach ($appointments as $a): ?>
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3"><?= $i++; ?></td>

                    <td class="p-3 font-medium"><?= $a->customer_name ?></td>

                    <td class="p-3"><?= $a->registration_no ?></td>

                    <td class="p-3"><?= $a->appointment_date ?></td>

                    <td class="p-3"><?= $a->appointment_time ?></td>

                    <td class="p-3"><?= $a->service_type ?></td>

                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-white text-xs
                            <?= $a->status == 'Pending' ? 'bg-yellow-500' : '' ?>
                            <?= $a->status == 'Confirmed' ? 'bg-blue-600' : '' ?>
                            <?= $a->status == 'Completed' ? 'bg-green-600' : '' ?>
                            <?= $a->status == 'Cancelled' ? 'bg-red-600' : '' ?>
                        ">
                            <?= $a->status ?>
                        </span>
                    </td>

                    <td class="p-3 text-center flex justify-center gap-3">

                        <!-- Edit -->
                        <a href="<?= base_url('index.php/appointment/edit/'.$a->appointment_id); ?>"
                           class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
                           title="Edit">
                            ✏️
                        </a>

                        <!-- Delete -->
                        <a onclick="return confirm('Delete this appointment?');"
                           href="<?= base_url('index.php/appointment/delete/'.$a->appointment_id); ?>"
                           class="p-2 rounded bg-red-100 hover:bg-red-200"
                           title="Delete">
                            🗑️
                        </a>

                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>

<!-- DATATABLE SCRIPTS -->
<link rel="stylesheet" 
href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script 
src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js">
</script>

<script>
$(document).ready(function() {
    $('#appointmentTable').DataTable({
        pageLength: 10,
        order: [[3, 'desc']],
        autoWidth: false,
        columnDefs: [
            { width: "40px", targets: 0 },
            { orderable: false, targets: 7 },
        ]
    });
});
</script>
