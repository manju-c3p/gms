<?php
foreach ($comapny_records as $row) {
    $company_name = $row->company_name;
    $company_address = $row->company_address;
    $company_city = $row->company_city;
    $company_pincode = $row->company_pincode;
    $company_country = $row->company_country;
    $company_email_id = $row->company_email_id;
    $company_telephone = $row->company_telephone;
    $company_website = $row->company_website;
    $company_TRN = $row->company_TRN;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PO Report</title>
    <style>
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
                TRN: <?= $company_TRN; ?><br>
                Tel: <?= $company_telephone; ?> | Email: <?= $company_email_id; ?> | Website: <?= $company_website; ?>
            </div>
        </div>
    </div>
  </div>

    <!-- Title -->
    <div class="report-title-bar">PURCHASE ORDER REPORT</div>

    <!-- Date Range -->
    <table>
        <tr>
            <th style="width: 33.33%;">Today's Date: <?= date('d-M-Y'); ?></th>
            <th style="width: 33.33%;">From Date: <?= $from; ?></th>
            <th style="width: 33.33%;">To Date: <?= $to; ?></th>
        </tr>
    </table>

    <!-- PO Table -->
    <table>
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>PO Code & Revisions</th>
                <th>PO Date</th>
                <th>Supplier & Ref No</th>
                <th style="text-align: right;">Grand Total</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $sum = 0;
        if (!empty($records)) :
            foreach ($records as $row) :
                $sum += $row->grand_total;
                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td>
                        <?= $row->po_code; ?><br>
                        <?php
                        $rev = $row->revision;
                        for ($k = 1; $k <= $rev; $k++) {
                            echo "<u><a target='_blank' href='" . base_url() . "index.php/Purchase/PO_print/{$row->po_id}/{$k}/0' title='View Revision'>Revision $k</a></u><br>";
                        }
                        ?>
                    </td>
                    <td><?= date('d-M-Y', strtotime($row->po_date)); ?></td>
                    <td><?= $row->supplier_name; ?><br><?= $row->supplier_ref; ?></td>
                    <td style="text-align: right;"><?= number_format($row->grand_total, 2); ?></td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table>

    <!-- Totals -->
    <div class="summary-row">
        <div>Total Records: <?= count($records); ?></div>
        <div>Total Amount: <?= number_format($sum, 2); ?></div>
    </div>
  <!-- Meta Info -->
    <div class="meta-info">
        <strong>Report Dated</strong>: <?= date('d-M-Y'); ?><br>
        <strong>Report Generated By</strong>: <?= $this->session->userdata('user_name'); ?>
    </div>
   <!-- Footer -->
    <div class="footer">
        <div class="bottom">
            <div>&copy;<?= date('Y'); ?> For Bangalore Elect Switchgear, Designed and developed by Concepts 360 Plus</div>
             <div id="page-number"></div>
        </div>
    </div>

</div>
<script>
    window.onload = function () {
        window.print();
    };

      let totalPages = Math.ceil(document.body.scrollHeight / window.innerHeight);
        document.getElementById("page-number").innerText = "Page 1 of " + totalPages;
</script>
</body>
</html>
