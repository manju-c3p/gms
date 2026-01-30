<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<style>
@media print {

    /* Allow full page height */
    html, body {
        height: auto !important;
        overflow: visible !important;
    }

    /* Make all containers expand naturally */
    div, table {
        height: auto !important;
        max-height: none !important;
        overflow: visible !important;
    }

    /* Hide buttons & links */
    button, a {
        display: none !important;
    }

    /* Remove UI styling */
    .shadow, .rounded-2xl {
        box-shadow: none !important;
        border-radius: 0 !important;
    }

    body {
        background: #fff !important;
        padding: 0 !important;
    }
}

@media print {
    table {
        page-break-inside: auto;
    }
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    thead {
        display: table-header-group;
    }
}


@media print {

    /* Hide dashboard / top UI */
    .topbar,
    .navbar,
    .header,
    .page-header,
    .breadcrumb,
    .sidebar,
    .dashboard {
        display: none !important;
    }

    /* Hide buttons & links */
    button, a {
        display: none !important;
    }

    body {
        background: #fff !important;
        padding: 0 !important;
        margin: 0 !important;
    }
}
@media print {

    /* Force side-by-side layout */
    .customer-vehicle-print {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 20px !important;
        margin-top: 10px;
        margin-bottom: 15px;
    }

    /* Remove card styling in print */
    .customer-vehicle-print > div {
        box-shadow: none !important;
        border: 1px solid #ccc;
        border-radius: 0 !important;
        padding: 10px !important;
    }
}

</style>




</head>

<body class="bg-gray-100 p-6">

<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <!-- HEADER -->
    <div class="bg-white shadow rounded-2xl p-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold">Invoice #<?= $invoice->billing_no ?></h2>
        <p class="text-sm text-gray-500">
            Billing Date: <?= date('d-m-Y', strtotime($invoice->billing_date)) ?>
        </p>
    </div>

    <div class="flex gap-2">
        <!-- Export Excel -->
        <a href="<?= base_url('index.php/billing_history/export_invoice_excel/'.$invoice->invoice_id) ?>"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
            ⬇ Export Excel
        </a>

        <!-- Print -->
        <!-- <button onclick="window.print()"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
            🖨 Print
        </button> -->

        <!-- Back -->
        <a href="<?= base_url('index.php/billing_history') ?>"
           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">
            ← Back
        </a>
    </div>
</div>


    <!-- CUSTOMER INFO -->
   <div class="customer-vehicle-print grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Customer Details -->
    <div class="bg-white shadow rounded-2xl p-6">
        <h3 class="font-bold mb-2">Customer Details</h3>
        <p><strong>Name:</strong> <?= $invoice->customer_name ?></p>
        <p><strong>Mobile:</strong> <?= $invoice->customer_phone ?></p>
        <p><strong>Warranty:</strong> <?= $invoice->warranty ?></p>
    </div>

    <!-- Vehicle Details -->
    <div class="bg-white shadow rounded-2xl p-6">
        <h3 class="font-bold mb-2">Vehicle Details</h3>
        <p><strong>Plate No:</strong> <?= $invoice->plate_no ?></p>
        <p><strong>Vehicle:</strong> <?= $invoice->brand ?> <?= $invoice->model ?></p>
        <p><strong>VIN:</strong> <?= $invoice->vin_no ?></p>
    </div>
</div>


    <!-- SERVICES TABLE -->
    <div class="bg-white shadow rounded-2xl p-6">
        <h3 class="font-bold mb-4">Service / Item Details</h3>

        <table id="itemsTable" class="w-full text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3">#</th>
                    <th class="p-3">Description</th>
                    <th class="p-3 text-right">Unit Price</th>
                    <th class="p-3 text-right">Discount</th>
                    <th class="p-3 text-right">Gross</th>
                    <th class="p-3 text-right">VAT</th>
                    <th class="p-3 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach ($items as $item): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3"><?= $i++ ?></td>
                        <td class="p-3"><?= $item->description ?></td>
                        <td class="p-3 text-right"><?= number_format($item->unit_price,2) ?></td>
                        <td class="p-3 text-right"><?= number_format($item->discount,2) ?></td>
                        <td class="p-3 text-right"><?= number_format($item->gross_amount,2) ?></td>
                        <td class="p-3 text-right"><?= number_format($item->vat_amount,2) ?></td>
                        <td class="p-3 text-right font-semibold"><?= number_format($item->total_amount,2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- TOTALS -->
    <div class="bg-white shadow rounded-2xl p-6 w-full md:w-1/3 ml-auto">
        <table class="w-full text-sm">
            <tr>
                <td>Gross Amount</td>
                <td class="text-right"><?= number_format($invoice->gross_amount,2) ?></td>
            </tr>
            <tr>
                <td>Discount</td>
                <td class="text-right"><?= number_format($invoice->discount_amount,2) ?></td>
            </tr>
            <tr>
                <td>VAT</td>
                <td class="text-right"><?= number_format($invoice->vat_amount,2) ?></td>
            </tr>
            <tr class="font-bold border-t">
                <td>Total</td>
                <td class="text-right"><?= number_format($invoice->total_amount,2) ?></td>
            </tr>
        </table>
    </div>

</div>

<script>
$(document).ready(function () {
    $('#itemsTable').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false
    });
});
</script>

</body>
</html>
