<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-xl shadow p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Employee List</h2>

        <a href="<?= base_url('index.php/employee/add') ?>"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Add Employee
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="employeeTable" class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">#</th>
                    <!-- <th class="border p-2">Code</th> -->
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Mobile</th>
                    <th class="border p-2">Department</th>
                    <th class="border p-2">Designation</th>
                    <th class="border p-2">Role</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $i=1; foreach($employees as $emp): ?>
                <tr class="hover:bg-gray-50">
                    <td class="border p-2"><?= $i++ ?></td>
                    <!-- <td class="border p-2"><?= $emp->employee_code ?></td> -->
                    <td class="border p-2"><?= $emp->employee_name ?></td>
                    <td class="border p-2"><?= $emp->mobile ?></td>
                    <td class="border p-2"><?= $emp->department_name ?></td>
                    <td class="border p-2"><?= $emp->designation_name ?></td>
                    <td class="border p-2"><?= $emp->role ?></td>
                    <td class="border p-2">
                        <?php if($emp->status == 'Active'): ?>
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                Active
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                Inactive
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="border p-2 text-center">
                        <a href="<?= base_url('index.php/employee/edit/'.$emp->employee_id) ?>"
                           class="px-3 py-1 bg-yellow-500 text-white rounded text-sm">
                            Edit
                        </a>

                        <a href="<?= base_url('index.php/employee/delete/'.$emp->employee_id) ?>"
                           onclick="return confirm('Are you sure?')"
                           class="px-3 py-1 bg-red-600 text-white rounded text-sm">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>
<script>
$(document).ready(function() {
    $('#employeeTable').DataTable();
});
</script>
