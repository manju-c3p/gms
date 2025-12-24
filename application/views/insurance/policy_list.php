<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">Insurance Policies</h2>


    <!-- VEHICLE GROUP CARDS -->
    <?php foreach ($vehicles as $v): ?>
        <div class="border rounded-xl p-5 mb-6 bg-gray-50">

            <!-- VEHICLE HEADER -->
            <h3 class="text-xl font-semibold mb-3 flex items-center gap-2">
                <?= $v->registration_no ?>
                <span class="text-sm text-gray-500">(<?= $v->brand ?> <?= $v->model ?>)</span>
            </h3>

            <!-- POLICY TABLE -->
            <table class="w-full border rounded overflow-hidden bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">Company</th>
                        <th class="p-3 text-left">Policy Number</th>
                        <th class="p-3 text-left">Start</th>
                        <th class="p-3 text-left">Expiry</th>
                        <th class="p-3 text-left">Premium</th>
                        <th class="p-3 text-left">Document</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (!empty($v->policies)): ?>
                    <?php foreach ($v->policies as $p): ?>
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3"><?= $p->company_name ?></td>

                            <td class="p-3"><?= $p->policy_number ?></td>

                            <td class="p-3"><?= $p->start_date ?></td>

                            <td class="p-3"><?= $p->expiry_date ?></td>

                            <td class="p-3">₹<?= $p->premium_amount ?></td>

                            <td class="p-3">
                                <?php if ($p->policy_document): ?>
                                    <a href="<?= base_url('uploads/policies/'.$p->policy_document); ?>"
                                       class="text-blue-600 underline"
                                       target="_blank">View</a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <!-- ACTION ICONS -->
                            <td class="p-3 text-center flex gap-3 justify-center">

                                <!-- Edit -->
                                <a href="<?= base_url('index.php/policy/edit/'.$p->policy_id); ?>"
                                   class="p-2 bg-yellow-100 rounded"
                                   title="Edit">✏️</a>

                                <!-- Delete -->
                                <a onclick="return confirm('Delete this policy?');"
                                   href="<?= base_url('index.php/policy/delete/'.$p->policy_id.'/'.$v->vehicle_id); ?>"
                                   class="p-2 bg-red-100 rounded"
                                   title="Delete">🗑️</a>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="p-3 text-center text-gray-500">
                            No insurance policies for this vehicle.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <!-- Add Policy for this vehicle -->
            <div class="mt-3">
                <a href="<?= base_url('index.php/policy/add/'.$v->vehicle_id); ?>"
                   class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
                   + Add Policy
                </a>
            </div>

        </div>
    <?php endforeach; ?>

</div>
