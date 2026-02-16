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
    $company_trn = $row->company_TRN;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GRN Report</title>
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

<body onload="window.print();">

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
    <div class="report-title-bar">GRN REPORT</div>

    <!-- Date Range -->
    <table>
        <tr>
            <th>Today's Date: <?= date('d-M-Y'); ?></th>
            <th>From Date: <?= $from; ?></th>
            <th>To Date: <?= $to; ?></th>
        </tr>
    </table>

    <!-- GRN Table -->
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>GRN Code</th>
                <th>PO Code</th>
                <th>Supplier Name</th>
                <th>Supplier Invoice</th>
                <th>Warehouse</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if (!empty($records)) :
                foreach ($records as $row) :
            ?>
            <tr>
                <td><?= $i++; ?></td>
                <td>
                    <?= $row->grn_code; ?><br>
                    <?= date('d-M-Y', strtotime($row->grn_date)); ?>
                </td>
                <td>
                    <?= $row->po_code; ?><br>
                    <?= date('d-M-Y', strtotime($row->po_date)); ?>
                </td>
                <td><?= $row->supplier_name; ?></td>
                <td>
                    <?= $row->invoice_no; ?><br>
                    <?= date('d-M-Y', strtotime($row->invoice_date)); ?>
                </td>
                <td><?= $row->warehouse_name; ?></td>
            </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary-row">
        Records Total: <?= is_array($records) || $records instanceof Countable ? count($records) : 0; ?>
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
