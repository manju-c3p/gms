<html>
<head>
    <title>Purchase Order Report</title>

    <style>
        @page {
            margin: 10mm 10mm 25mm 10mm;

            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
            }

            @bottom-left {
                content: "©<?php echo date('Y'); ?>";
            }
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f5f5f5;
        }

        .right {
            text-align: right;
        }

        /* HEADER */
        .invoice-header td {
            vertical-align: middle;
            padding: 10px;
            border: none;
        }

        .logo-cell {
            text-align: center;
        }

        .logo-cell img {
            max-height: 70px;
        }

        .company-cell {
            font-size: 14px;
            line-height: 1.6;
            text-align: right;
        }
    </style>
</head>

<body>

<!-- 🔥 HEADER -->
<table class="invoice-header">
    <tr>
        <td width="20%" class="logo-cell">
            <img src="<?= base_url('public/images/logocooling.png') ?>" alt="Logo">
        </td>

        <td width="80%" class="company-cell">
            <strong>Cool Runnings Garage Co LLC</strong><br>
            7 St, Al Quoz 3, Dubai, UAE<br>
            www.coolrunningsgarage.com<br>
            info@coolrunningsgarage.com<br>
            Tel: +971 4 265 4887<br>
            TRN: 104026094300003
        </td>
    </tr>
</table>

<!-- 🔥 TITLE ROW -->
<table style="margin-top:10px;">
    <tr>
        <td width="40%" style="border:none;">
            <b>Report:</b> GRN Report
        </td>

        <td width="20%" style="border:none; text-align:center; font-size:16px;">
            <b>GRN REPORT</b>
        </td>

        <td width="40%" style="border:none; text-align:right;">
            <b>Period:</b> <?= $_GET["from_date"]; ?> to <?= $_GET["to_date"]; ?>
        </td>
    </tr>
</table>

<br>

<!-- 🔥 PREPARED BY -->
<table style="border:none;">
    <tr>
        <td style="border:none;">
            Prepared by: <?= $this->session->userdata('username') ?? '' ?>
        </td>
    </tr>
</table>

<br>

<!-- 🔥 REPORT TABLE -->
<table>
    <thead>
        <tr style="font-weight:bold;">
            <th style='width:5%'>Sl No</th>
            <th style='width:15%'>GRN Code</th>
            <th style='width:15%'>GRN Date</th>
            <th style='width:40%'>Supplier</th>
            <th style='width:25%' class="right">Grand Total</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $sl_no = 1;
        $total_grand = 0;

        foreach ($records as $detail): 
            $total_grand += $detail->grand_total;
        ?>
            <tr>
                <td><?= $sl_no++; ?></td>
                <td><?= $detail->grn_code; ?></td>
                <td><?= $detail->grn_date; ?></td>
                <td><?= $detail->supplier_name; ?></td>
                <td class="right"><?= number_format($detail->grand_total, 2); ?></td>
            </tr>
        <?php endforeach; ?>

        <!-- TOTAL -->
        <tr>
            <td colspan="4" class="right"><strong>Total:</strong></td>
            <td class="right"><strong><?= number_format($total_grand, 2); ?></strong></td>
        </tr>
    </tbody>
</table>

</body>
</html>
