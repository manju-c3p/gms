<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Customer Visit History</h2>
            <p class="text-sm text-gray-500">
                From <b><?= date('d M Y', strtotime($from)) ?></b>
                to <b><?= date('d M Y', strtotime($to)) ?></b>
            </p>
        </div>

        <!-- FILTERS -->
        <form method="get" class="flex flex-wrap items-center gap-2">
            <input type="date" name="from" value="<?= $from ?>"
                   class="border rounded px-3 py-2 text-sm">

            <input type="date" name="to" value="<?= $to ?>"
                   class="border rounded px-3 py-2 text-sm">

            <select name="customer_id"
                    class="border rounded px-3 py-2 text-sm">
                <option value="">All Customers</option>
                <?php foreach ($customers as $c): ?>
                    <option value="<?= $c->customer_id ?>"
                        <?= ($this->input->get('customer_id') == $c->customer_id) ? 'selected' : '' ?>>
                        <?= $c->name ?> (<?= $c->phone ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Filter
            </button>
        </form>
    </div>

    <!-- SUMMARY -->
    <?php
        $visitCount = count($visits);
        $customerVisits = [];

        foreach ($visits as $v) {
            $customerVisits[$v->customer_id][] = $v;
        }
    ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Total Visits</p>
            <h3 class="text-2xl font-bold text-blue-700"><?= $visitCount ?></h3>
        </div>

        <div class="bg-green-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Unique Customers</p>
            <h3 class="text-2xl font-bold text-green-700">
                <?= count($customerVisits) ?>
            </h3>
        </div>

        <div class="bg-purple-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Repeat Customers</p>
            <h3 class="text-2xl font-bold text-purple-700">
                <?= count(array_filter($customerVisits, fn($v) => count($v) > 1)) ?>
            </h3>
        </div>
    </div>

    <!-- TABLE -->
    <table id="customerVisitTable" class="w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th>#</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Vehicle</th>
                <th>Job Card</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($visits)): ?>
                <?php $i=1; foreach ($visits as $row): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= date('d-m-Y', strtotime($row->jobcard_date)) ?></td>
                    <td><?= $row->customer_name ?></td>
                    <td><?= $row->phone ?></td>
                    <td>
                        <?= $row->registration_no ?><br>
                        <span class="text-xs text-gray-500">
                            <?= $row->brand ?> <?= $row->model ?>
                        </span>
                    </td>
                    <td><?= $row->jobcard_id ?></td>
                    <td>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            <?= $row->status == 'Completed' ? 'bg-green-100 text-green-700' :
                                ($row->status == 'In Progress' ? 'bg-yellow-100 text-yellow-700' :
                                'bg-red-100 text-red-700') ?>">
                            <?= $row->status ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        No customer visits found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<!-- DATATABLE -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    new simpleDatatables.DataTable("#customerVisitTable", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Search customer, vehicle, job card...",
            noRows: "No visits found",
            info: "Showing {start} to {end} of {rows} visits"
        }
    });
});
</script>
