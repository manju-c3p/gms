<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="p-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Departments</h1>

        <a href="<?= base_url('org_structure/add_department') ?>"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 transition">
            + Add Department
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">

        <div class="overflow-x-auto">
            <table  id="departmentTable"  class="min-w-full divide-y divide-gray-200">

                <!-- Table Head -->
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Department
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">

                    <?php foreach($departments as $d){ ?>

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-6 py-4 text-sm text-gray-700">
                            <?= $d->department_id ?>
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                            <?= $d->department_name ?>
                        </td>

                        <td class="px-6 py-4 text-sm">

                            <a href="<?= base_url('org_structure/edit_department/'.$d->department_id) ?>"
                                class="text-blue-600 hover:text-blue-800 font-medium">
                                Edit
                            </a>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>
        </div>

    </div>

</div>
<script>
$(document).ready(function () {

    $('#departmentTable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true
    });

});
</script>

