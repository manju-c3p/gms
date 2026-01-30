<div class="p-6 bg-gray-100 min-h-screen">

    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-800">
            <?= $page_title ?>
        </h1>
    </div>

    <div class="bg-white rounded-xl shadow p-4">
        <table id="jobcardTable" class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Jobcard No</th>
                    <th class="border px-3 py-2">Customer</th>
                    <th class="border px-3 py-2">Vehicle</th>
                    <th class="border px-3 py-2">Technician</th>
                    <th class="border px-3 py-2">Job Date</th>
                    <th class="border px-3 py-2">Delivery Date</th>
                    <th class="border px-3 py-2">Amount</th>
                    <th class="border px-3 py-2">Status</th>
                    <!-- <th class="border px-3 py-2">Action</th> -->
                </tr>
            </thead>

            <tbody>
                <?php foreach ($jobcards as $jc): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-3 py-2 font-semibold text-blue-600">
                            <a href="<?= base_url('index.php/Jobcard/edit/' . $jc->jobcard_id) ?>">
                                <?= $jc->jobcard_no ?>
                            </a>
                        </td>
                        <td class="border px-3 py-2"><?= $jc->customer_name ?></td>
                        <td class="border px-3 py-2"><?= $jc->registration_no ?></td>
                        <td class="border px-3 py-2"><?= $jc->technician_name ?? '-' ?></td>
                        <td class="border px-3 py-2"><?= date('d-m-Y', strtotime($jc->jobcard_date)) ?></td>
                        <td class="border px-3 py-2"><?= date('d-m-Y', strtotime($jc->expected_delivery_date)) ?></td>
                        <td class="border px-3 py-2 text-right">
                            <?= number_format($jc->grand_total, 2) ?>
                        </td>
                        <td class="border px-3 py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                <?= $jc->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                                <?= $jc->status == 'In Progress' ? 'bg-blue-100 text-blue-800' : '' ?>
                                <?= $jc->status == 'Completed' ? 'bg-green-100 text-green-800' : '' ?>">
                                <?= $jc->status ?>
                            </span>
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#jobcardTable').DataTable({
        order: [[0, 'desc']]
    });
});
</script>
