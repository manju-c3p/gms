<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-xl font-semibold text-gray-800">
            Designations
        </h1>

        <a href="<?= base_url('org_structure/add_designation') ?>"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            + Add Designation
        </a>

    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="min-w-full border border-gray-200">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>

                    <th class="px-4 py-3 text-left text-sm font-semibold">
                        Department
                    </th>

                    <th class="px-4 py-3 text-left text-sm font-semibold">
                        Designation
                    </th>

                    <th class="px-4 py-3 text-left text-sm font-semibold">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y">

                <?php foreach($designations as $d){ ?>

                <tr class="hover:bg-gray-50">

                    <td class="px-4 py-3">
                        <?= $d->designation_id ?>
                    </td>

                    <td class="px-4 py-3">
                        <?= $d->department_name ?>
                    </td>

                    <td class="px-4 py-3">
                        <?= $d->designation_name ?>
                    </td>

                    <td class="px-4 py-3">

                        <a href="<?= base_url('org_structure/edit_designation/'.$d->designation_id) ?>"
                            class="text-blue-600 hover:underline">
                            Edit
                        </a>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>
