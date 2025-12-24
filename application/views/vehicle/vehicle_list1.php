<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">Vehicle List (Grouped by Customer)</h2>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="p-3 mb-4 bg-green-100 text-green-700 border border-green-300 rounded">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Add Customer (with vehicles) -->
    <div class="flex justify-end mb-4">
        <a href="<?= base_url('index.php/customer/add'); ?>"
           class="px-4 py-2 bg-green-600 text-white rounded">
           + Add Customer & Vehicle
        </a>
    </div>

    <!-- Grouped List -->
    <?php foreach ($customers as $c): ?>

        <div class="border rounded-lg p-4 mb-6 bg-gray-50">

            <!-- CUSTOMER NAME -->
            <h3 class="text-xl font-semibold mb-3">
                <?= $c->name ?>
                <span class="text-sm text-gray-500">(<?= $c->phone ?>)</span>
            </h3>

            <!-- VEHICLE TABLE -->
            <table class="w-full border rounded overflow-hidden bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">Reg. No</th>
                        <th class="p-3 text-left">Brand</th>
                        <th class="p-3 text-left">Model</th>
                        <th class="p-3 text-left">Variant</th>
                        <th class="p-3 text-left">Year</th>
                        <th class="p-3 text-left">Color</th>
                        <th class="p-3 text-left">Chassis No</th>
                        <th class="p-3 text-left">Engine No</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($c->vehicles)): ?>
                    <?php foreach ($c->vehicles as $v): ?>
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3"><?= $v->registration_no ?></td>
                            <td class="p-3"><?= $v->brand ?></td>
                            <td class="p-3"><?= $v->model ?></td>
                            <td class="p-3"><?= $v->variant ?></td>
                            <td class="p-3"><?= $v->year ?></td>
                            <td class="p-3"><?= $v->color ?></td>
                            <td class="p-3"><?= $v->chassis_no ?></td>
                            <td class="p-3"><?= $v->engine_no ?></td>

                            <!-- ACTION ICONS -->
                            <td class="p-3 text-center flex justify-center gap-3">

                                <!-- View -->
                                <!-- <a href="<?= base_url('vehicle/view/'.$v->vehicle_id); ?>"
                                   class="p-2 rounded bg-blue-100 hover:bg-blue-200"
                                   title="View">
                                    👁️
                                </a> -->

                                <!-- Edit -->
                                <a href="<?= base_url('vehicle/edit/'.$v->vehicle_id); ?>"
                                   class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
                                   title="Edit">
                                    ✏️
                                </a>

                                <!-- Delete -->
                                <a onclick="return confirm('Delete this vehicle?');"
                                   href="<?= base_url('vehicle/delete/'.$v->vehicle_id); ?>"
                                   class="p-2 rounded bg-red-100 hover:bg-red-200"
                                   title="Delete">
                                    🗑️
                                </a>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="p-3 text-center text-gray-500">
                            No vehicles added for this customer.
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>

        </div>

    <?php endforeach; ?>

</div>
