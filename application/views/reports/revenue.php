<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Revenue Report</h2>
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

    <!-- KPI SUMMARY -->
    <?php
        $invoiceCount = count($reports);
        $paidTotal = 0;
        $unpaidTotal = 0;

        foreach ($reports as $r) {
            if ($r->status == 'Paid') {
                $paidTotal += $r->grand_total;
            } else {
                $unpaidTotal += $r->grand_total;
            }
        }
    ?>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <div class="bg-blue-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <h3 class="text-2xl font-bold text-blue-700">
                AED <?= number_format($total_revenue,2) ?>
            </h3>
        </div>

        <div class="bg-green-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Paid Amount</p>
            <h3 class="text-2xl font-bold text-green-700">
                AED <?= number_format($paidTotal,2) ?>
            </h3>
        </div>

        <div class="bg-red-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Unpaid Amount</p>
            <h3 class="text-2xl font-bold text-red-700">
                AED <?= number_format($unpaidTotal,2) ?>
            </h3>
        </div>

        <div class="bg-purple-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">VAT Collected</p>
            <h3 class="text-2xl font-bold text-purple-700">
                AED <?= number_format($total_tax,2) ?>
            </h3>
        </div>

    </div>

    <!-- REVENUE TABLE -->
    <table id="revenueTable" class="w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th>#</th>
                <th>Invoice No</th>
                <th>Date</th>
                <th>Subtotal</th>
                <th>VAT</th>
                <th>Discount</th>
                <th>Grand Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reports)): ?>
                <?php $i=1; foreach ($reports as $r): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $r->invoice_no ?></td>
                    <td><?= date('d-m-Y', strtotime($r->invoice_date)) ?></td>
                    <td><?= number_format($r->subtotal,2) ?></td>
                    <td><?= number_format($r->tax_amount,2) ?></td>
                    <td><?= number_format($r->discount_amount,2) ?></td>
                    <td class="font-semibold">
                        <?= number_format($r->grand_total,2) ?>
                    </td>
                    <td>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            <?= $r->status == 'Paid' ? 'bg-green-100 text-green-700' :
                                ($r->status == 'Partially Paid' ? 'bg-yellow-100 text-yellow-700' :
                                'bg-red-100 text-red-700') ?>">
                            <?= $r->status ?>
                        </span>
                    </td>
                    <td class="flex gap-2 justify-center">

                        <!-- VIEW INVOICE -->
                        <a href="<?= base_url('index.php/invoice/view/'.$r->invoice_id) ?>"
                           class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
                           title="View Invoice">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-4 h-4 text-yellow-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 12s3.75-7.5 9.75-7.5
                                         9.75 7.5 9.75 7.5
                                         -3.75 7.5 -9.75 7.5
                                         S2.25 12 2.25 12z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0
                                         3 3 0 016 0z"/>
                            </svg>
                        </a>

                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-500">
                        No invoices found for selected date range
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<!-- DATATABLE -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    new simpleDatatables.DataTable("#revenueTable", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Search invoices...",
            noRows: "No invoices found",
            info: "Showing {start} to {end} of {rows} invoices"
        }
    });
});
</script>
