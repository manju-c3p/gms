<div class="w-full bg-white rounded-2xl shadow-md p-6">
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Inventory Usage Report</h2>
            <p class="text-sm text-gray-500">
                From <b><?= date('d M Y', strtotime($from)) ?></b>
                to <b><?= date('d M Y', strtotime($to)) ?></b>
            </p>
        </div>

        <!-- DATE FILTER -->
        <form method="get" class="flex items-center gap-2">
            <input type="date" name="from" value="<?= $from ?>"
                   class="border rounded px-3 py-2 text-sm">
            <input type="date" name="to" value="<?= $to ?>"
                   class="border rounded px-3 py-2 text-sm">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Filter
            </button>
        </form>
    </div>

    <!-- SUMMARY -->
    <?php
        $totalQty = 0;
        foreach ($items as $i) {
            $totalQty += $i->qty;
        }
    ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Total Parts Used</p>
            <h3 class="text-2xl font-bold text-blue-700"><?= count($items) ?></h3>
        </div>

        <div class="bg-green-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Total Quantity Used</p>
            <h3 class="text-2xl font-bold text-green-700"><?= $totalQty ?></h3>
        </div>

        <div class="bg-purple-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Date Range</p>
            <h3 class="text-sm font-semibold text-purple-700">
                <?= date('d M', strtotime($from)) ?> – <?= date('d M', strtotime($to)) ?>
            </h3>
        </div>
    </div>

    <!-- TABLE -->
    <table id="inventoryUsageTable" class="w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th>#</th>
                <th>Date</th>
                <th>Part Code</th>
                <th>Part Name</th>
                <th>Qty Used</th>
                <th>Job Card</th>
                <th>Customer</th>
                <th>Vehicle</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($items)): ?>
                <?php $i=1; foreach ($items as $row): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= date('d-m-Y', strtotime($row->jobcard_date)) ?></td>
                    <td><?= $row->part_code ?></td>
                    <td><?= $row->part_name ?></td>
                    <td class="font-semibold text-center"><?= $row->qty ?></td>
                    <td><?= $row->jobcard_id ?></td>
                    <td><?= $row->customer_name ?></td>
                    <td><?= $row->registration_no ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        No inventory usage found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<!-- DATATABLE -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    new simpleDatatables.DataTable("#inventoryUsageTable", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Search parts, job card, vehicle...",
            noRows: "No inventory usage found",
            info: "Showing {start} to {end} of {rows} entries"
        }
    });
});
</script>
