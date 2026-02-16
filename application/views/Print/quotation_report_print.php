<?php
foreach ($comapny_records as $row) {
    $company_name = $row->company_name;
    $company_address = $row->company_address;
    $company_city = $row->company_city;
    $company_country = $row->company_country;
    $company_email_id = $row->company_email_id;
    $company_telephone = $row->company_telephone;
    $company_website = $row->company_website;
    $company_trn = $row->company_trn ?? '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quotation Report</title>
    <style>
          * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            background: white;
            margin: 0;
            padding: 0;
        }

        #printable {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
        }

        .report-title-bar {
            background-color: #d3d3d3;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: #000;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            margin-top: 20px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-weight: bold;
        }

        .meta-info {
            margin-top: 30px;
            font-size: 13px;
        }

        .footer {
            font-size: 12px;
            page-break-inside: avoid;
            margin-top: auto;
            padding-top: 20px;
        }

        .footer .bottom {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 8px;
        }

        .no-border td {
            border: none !important;
            padding: 2px 0;
        }

        @media print {
            html, body {
                height: 100%;
            }

            #printable {
                height: auto;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                page-break-after: auto;
            }

            .footer {
                position: relative;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div id="printable">

   <!-- Header -->
 <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="<?= base_url('public/logo/Logo-bsg.jpg'); ?>" width="90">
        <div style="text-align: left;">
            <div style="font-weight: bold; font-size: 16px;"><?= $company_name; ?></div>
            <div style="font-size: 13px; line-height: 1.5;">
                TRN: <?= $company_trn; ?><br>
                Tel: <?= $company_telephone; ?> | Email: <?= $company_email_id; ?> | Website: <?= $company_website; ?>
            </div>
        </div>
    </div>
  </div>

    <!-- Title -->
    <div class="report-title-bar">QUOTATION REPORT</div>

    <!-- Date Range -->
    <table>
        <tr>
            <th style="width: 33%;">Todays Date: <?= date('d-M-Y'); ?></th>
            <th style="width: 33%;">From Date: <?= $from; ?></th>
            <th style="width: 33%;">To Date: <?= $to; ?></th>
        </tr>
    </table>

    <!-- Table -->
    <table>
        <thead>
        <tr>
            <th>Sr. No</th>
            <th>Quotation Code</th>
            <th>Date</th>
            <th>Customer & Ref</th>
            <th>Grand Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; $grand_total = 0;
        foreach ($records as $row):
            $grand_total += $row->grand_total; ?>
            <tr>
                <td><?= $i++; ?></td>
                <td>
                    <?= $row->quotation_code; ?><br>
                    <?php for ($k = 1; $k <= $row->revision; $k++) {
                        echo "<a target='_blank' href='" . base_url("index.php/Sales/print_quotation/{$row->quote_id}/{$k}/0") . "'>Revision $k</a><br>";
                    } ?>
                </td>
                <td><?= date('d-M-Y', strtotime($row->quotation_date)); ?></td>
                <td>
                    <?= $row->cust_name; ?>
                    <?php if (!empty($row->client_ref)) echo '<br>' . $row->client_ref; ?>
                </td>
                <td><?= number_format($row->grand_total, 2); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary-row">
        <div>Records Total: <?= count($records); ?></div>
        <div>Total: <?= number_format($grand_total, 2); ?></div>
    </div>

    <!-- Meta Info -->
    <div class="meta-info">
        <strong>Report Dated</strong>: <?= date('d-M-Y'); ?><br>
        <strong>Report Generated By</strong>: <?= $this->session->userdata('user_name'); ?>
    </div>

    <!-- Footer -->
    <div class="footer" id="last-page-footer">
        <div class="bottom">
            <div>&copy;<?= date('Y'); ?> For <?= $company_name; ?>, Designed and developed by Concepts 360 Plus</div>
            <div>Page <span class="pageNumber">1</span> of <span class="totalPages">1</span></div>
        </div>
    </div>

</div>

<script>
    window.onload = function () {
        const totalPages = Math.ceil(document.body.scrollHeight / window.innerHeight);
        document.querySelectorAll('.pageNumber').forEach(el => el.textContent = '1');
        document.querySelectorAll('.totalPages').forEach(el => el.textContent = totalPages);
        window.print();
    };
</script>
</body>
</html>
