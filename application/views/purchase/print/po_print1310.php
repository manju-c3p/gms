<!DOCTYPE html>
<html>
<head>
    <title>Purchase Order</title>

    <style>
        body {
            margin: 10px;
            font-family: Arial;
            font-size: 12px;
            text-align: center;
            position: relative;
        }

        /* Header */
        .header-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .logo img {
            max-width: 220px;
            height: auto;
        }

        .company {
            width: 50%;
            text-align: right;
            font-size: 11px;
            line-height: 1.25;
            color: #333;
        }

        .company strong {
            font-size: 13px;
            color: #111;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 6px;
        }

        th {
            text-align: center;
            background: #f5f5f5;
            font-weight: bold;
        }

        .center-title {
            text-align: center;
            font-size: 20px;
            color: #e8b41a;
            font-weight: bold;
            margin: 10px auto;
        }

        .separator {
            width: 95%;
            height: 2px;
            background: #444;
            margin: 12px auto;
        }

        .prepared {
            width: 95%;
            margin: 20px auto;
            text-align: left;
            font-size: 12px;
        }
    </style>
</head>



<body>
<!-- HEADER TEMPLATE -->
<htmlpageheader name="myheader">
    <div class="header-row">
        <div class="logo">
            <img src="<?= base_url() ?>public/header/header.jpg">
        </div>
        <div class="company">
            <strong><?= $comp_details['company_name']; ?></strong>
            <?= nl2br($comp_details['company_address']); ?><br>
            <?= $comp_details['company_city']; ?>, <?= $comp_details['company_state']; ?><br>
            <?= $comp_details['company_country']; ?>
        </div>
    </div>

    <div class="center-title">Purchase Order</div>
</htmlpageheader>
    <!-- Watermark -->
    <div style="position: fixed;top: 45%;left: 50%;transform: translate(-50%, -50%); opacity: 0.06; z-index: 0; pointer-events: none;">
        <img src="<?= base_url() ?>public/header/header.jpg" style="width: 60%; height: auto;">
    </div>

    <!-- Main Content Wrapper -->
    <div style="position: relative; z-index: 10;">

        <table style="width: 98%; margin: auto;">
            <tr>

                <!-- Supplier Info -->
                <td style="width: 60%; vertical-align: top;">
                    <table  style="width: 100%; border-radius: 6px;border:1px solid #ccc;">
                        <tr>
                            <td align="left" width="30%"><b>Name</b></td><td>:</td>
							<td><?= $po[0]->supplier_name; ?></td>
                        </tr>
                        <tr>
                            <td align="left"><b>Address</b></td><td>:</td>
                            <td><?= $po[0]->billing_address; ?></td>
                        </tr>
                        <tr>
                            <td align="left"><b>Email</b></td><td>:</td>
                            <td></td>
                        </tr>
                    </table>
                </td>

                <!-- Document Info -->
                <td style="width: 40%; vertical-align: top;">
                    <table  style="width: 100%; border-radius: 6px;border:1px solid #ccc;">
                        <tr>
                            <td align="left"><b>Date</b></td><td>:</td>
                            <td><?= $po[0]->po_date; ?></td>
                        </tr>
                        <tr>
                            <td align="left"><b>Doc No</b></td><td>:</td>
                            <td><?= $po[0]->po_code; ?></td>
                        </tr>
                        <tr>
                            <td align="left"><b>Supplier</b></td><td>:</td>
                            <td><?= $po[0]->supplier_name; ?></td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>

        <!-- Separator -->
        <div class="separator"></div>

        <!-- Items Table -->
        <table border="1">
            <thead>
                <tr>
                    <th style="width: 4%;">Sl No</th>
                    <th style="width: 12%;">Model</th>
                    <th style="width: 28%;">Description</th>
                    <th style="width: 8%;">Qty</th>
                    <th style="width: 8%;">Unit</th>
                    <th style="width: 10%;">Price</th>
                    <th style="width: 10%;">Discount</th>
                    <th style="width: 10%;">Total</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sl_no = 1;
                $total_before_vat = $po[0]->sub_total ?? 0;
                $discount = $po[0]->discount ?? 0;
                $vat_amount = $po[0]->vat_amt ?? 0;
                $grand_total = $po[0]->grand_total;

                foreach ($po_tr as $detail):
                    // $total_before_vat += $detail->price * $detail->quantity;
                ?>
                <tr>
                    <td align="center"><?= $sl_no++; ?></td>
                    <td><?= htmlspecialchars($detail->item_model); ?></td>
                    <td><?= htmlspecialchars($detail->item_description); ?></td>
                    <td align="center"><?= $detail->quantity; ?></td>
                    <td align="center"><?= $detail->unit_name; ?></td>
                    <td align="right"><?= number_format($detail->price, 2); ?></td>
                    <td align="right"><?= number_format($detail->dis_amt, 2); ?></td>
                    <td align="right"><?= number_format($detail->total, 2); ?></td>
                </tr>
                <?php endforeach; ?>

                <!-- Summary Rows -->
                <tr>
                    <td colspan="7" align="right"><b>Total Before VAT</b></td>
                    <td align="right"><?= number_format($total_before_vat, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="7" align="right"><b>Discount Amount</b></td>
                    <td align="right"><?= number_format($discount, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="7" align="right"><b>VAT Amount</b></td>
                    <td align="right"><?= number_format($vat_amount, 2); ?></td>
                </tr>
                <tr style="background: #f7f7f7;">
                    <td colspan="7" align="right"><b>Grand Total</b></td>
                    <td align="right"><?= number_format($grand_total, 2); ?></td>
                </tr>

            </tbody>
        </table>

        <!-- Prepared By -->
        <div class="prepared">
            Prepared by: <?= $po[0]->user_name; ?>
        </div>

    </div>

</body>
</html>
