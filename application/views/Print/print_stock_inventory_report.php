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
    $company_trn  = $row->company_TRN;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inventory Stock Report</title>
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
    <script>
        window.onload = function () {
            window.print();
        }
    </script>
</head>

<body>

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
    <!-- Report Title -->
    <div class="report-title-bar">INVENTORY STOCK REPORT</div>

    <!-- Report Table -->
    <table>
        <thead>
            <tr>
                <th>Srn</th>
                <th>Stock Code</th>
                <th>Size</th>
                <th>Stock Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Allocated Qty</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $tot1 = 0;
        $st = 0;
        foreach ($records as $row) :
            $total = $row->stock * $row->price;
            $tot1 += $total;
            $st += $row->stock;
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a href="<?php echo base_url().'index.php/Reports/export_stock_inventory_report1'; ?>">
                        <?php echo $row->model_code; ?>
                    </a>
                </td>
                <td><?php echo $row->size . '"'; ?></td>
                <td class="right-align"><?php echo $row->stock; ?></td>
                <td class="right-align"><?php echo number_format($row->price, 2); ?></td>
                <td class="right-align"><?php echo number_format($total, 2); ?></td>
                <td class="right-align"><?php echo $row->allocation; ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <th>Total</th>
                <th colspan="2"></th>
                <th class="right-align"><?php echo $st; ?></th>
                <th></th>
                <th class="right-align"><?php echo number_format($tot1, 2); ?></th>
                <th></th>
            </tr>
        </tbody>
    </table>

    <!-- Summary and Footer -->
    <div class="summary-row">
        <div>Records Total: <?php echo $i - 1; ?></div>
        <div>Total: <?php echo number_format($tot1, 2); ?></div>
    </div>
  <!-- Meta Info -->
    <div class="meta-info">
        <strong>Report Dated</strong>: <?= date('d-M-Y'); ?><br>
        <strong>Report Generated By</strong>: <?= $this->session->userdata('user_name'); ?>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <div class="bottom">
            <div>&copy;<?= date('Y'); ?> For <?= $company_name; ?>, Designed and developed by Concepts 360 Plus</div>
        <div id="page-number"></div>
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
