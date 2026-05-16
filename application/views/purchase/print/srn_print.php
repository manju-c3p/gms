<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Service Received Note</title>

    <style>
        @page {
            size: A4;
            margin: 15mm 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #111;
        }

        .container {
            width: 100%;
            max-width: 780px;
            margin: 0 auto;
            padding: 0 10px;
            box-sizing: border-box;
        }

        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #fff;
            z-index: 1000;
        }

        .header-inner {
            width: 100%;
            max-width: 780px;
            margin: 0 auto;
            padding: 0 10px;
            box-sizing: border-box;
        }

        .header-space {
            height: 130px;
        }

        .company-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }

        .logo {
            height: 60px;
        }

        .company-info {
            text-align: right;
            font-size: 11px;
            line-height: 1.4;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .info-section {
            display: flex;
            gap: 10px;
        }

        .info-box {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .info-box td {
            padding: 6px;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .items th {
            border: 1px solid #ccc;
            background: #f3f4f6;
            padding: 8px;
        }

        .items td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .total-row {
            font-weight: bold;
        }

        .watermark {
            position: fixed;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.06;
            z-index: -1;
        }

        .watermark img {
            width: 60%;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- WATERMARK -->
    <div class="watermark">
        <img src="<?= base_url() ?>public/header/header.jpg">
    </div>

    <!-- HEADER -->
    <div class="fixed-header">

        <div class="no-print">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded">
                🖨 Print
            </button>

            <a href="<?= base_url('index.php/Purchase/purchase_srn_list'); ?>"
               class="ml-3 px-6 py-2 bg-gray-300 rounded">
               Cancel
            </a>
        </div>

        <div class="header-inner">

            <div class="company-header">

                <img src="<?= base_url('public/images/logocooling.png') ?>" class="logo">

                <div class="company-info">
                    Cool Runnings Garage Co LLC<br>
                    7 St, Al Quoz 3, Dubai, UAE<br>
                    www.coolrunningsgarage.com<br>
                    info@coolrunningsgarage.com<br>
                    Tel: +971 4 265 4887<br>
                    TRN: 104026094300003
                </div>

            </div>

        </div>
    </div>

    <!-- BODY -->
    <div class="container">

        <div class="header-space"></div>

        <div class="title">SERVICE RECEIVED NOTE</div>

        <!-- INFO -->
        <div class="info-section">

            <table class="info-box">
                <tr>
                    <td width="35%"><b>Name</b></td>
                    <td><?= $srn[0]->supplier_name ?></td>
                </tr>
                <tr>
                    <td><b>Address</b></td>
                    <td><?= $srn[0]->billing_address ?></td>
                </tr>
                <tr>
                    <td><b>Contact</b></td>
                    <td><?= $srn[0]->contact_no ?></td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td><?= $srn[0]->email_id ?></td>
                </tr>
            </table>

            <table class="info-box">
                <tr>
                    <td width="35%"><b>Date</b></td>
                    <td><?= date('d-M-Y', strtotime($srn[0]->srn_date)) ?></td>
                </tr>
                <tr>
                    <td><b>Doc No</b></td>
                    <td><?= $srn[0]->srn_no ?></td>
                </tr>
                <tr>
                    <td><b>Supplier</b></td>
                    <td><?= $srn[0]->supplier_name ?></td>
                </tr>
            </table>

        </div>

        <!-- TABLE -->
        <table class="items">

            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Description</th>
                    <th style="text-align:right;">Amount</th>
                </tr>
            </thead>

            <tbody>

                <?php $sl = 1; foreach ($srn_tr as $row): ?>

                    <tr>
                        <td align="center"><?= $sl++ ?></td>
                        <td><?= $row->desc ?></td>
                        <td align="right"><?= number_format($row->received_amount, 2) ?></td>
                    </tr>

                <?php endforeach; ?>

                <tr class="total-row">
					<td colspan="2" align="right">Sub Total Amount</td>
                    <td align="right"><?= number_format($srn[0]->subtotal, 2) ?></td>
					
                </tr>
				<tr class="total-row">
					
					<td colspan="2" align="right">Vat Amount</td>
                    <td align="right"><?= number_format($srn[0]->vatamt, 2) ?></td>
					
                </tr>
				<tr class="total-row">
				
					<td colspan="2" align="right">Discount Amount</td>
                    <td align="right"><?= number_format($srn[0]->disamt, 2) ?></td>
                   
                </tr>
				<tr class="total-row">
					
                    <td colspan="2" align="right">Total Amount</td>
                    <td align="right"><?= number_format($srn[0]->total_amount, 2) ?></td>
                </tr>

            </tbody>

        </table>

        <br><br>

        <!-- REMARKS -->
        <?php if (!empty($srn[0]->remarks)) { ?>
            <b>Remarks:</b> <?= $srn[0]->remarks ?>
            <br><br>
        <?php } ?>

        <!-- SIGN -->
        Prepared By: <?= $srn[0]->username ?>

    </div>

</body>

</html>
