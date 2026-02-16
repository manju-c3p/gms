<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body {
    font-family: Arial, sans-serif;
    font-size: 12px;
    margin: 0;
    padding: 0;
}


/* -----------------------------------------------------------
   PRINT SETTINGS
------------------------------------------------------------- */
@media print {

    /* SPACE RESERVED FOR HEADER */
    .header-space { height: 90px; }

    /* FIXED HEADER */
    .fixed-header {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
    }

    /* FIXED FOOTER */
    .fixed-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 1000;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    th, td {
        padding: 6px;
        vertical-align: top;
    }

    /* Prevent row break */
    tr { 
        page-break-inside: avoid !important;
    }

    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }

    /* MAIN CONTENT AREA */
    .content-wrapper {
        margin-top: 20px;
        margin-bottom: 190px !important;
    }
    /* Items table */
.items {
    width:100%;
    border-collapse:collapse;
    border:1px solid #ccc;
    font-size:12px;
}

.items th {
    background:#f7f7f7;
    border:1px solid #ccc;
    padding:8px;
    text-align:center;
    font-weight:bold;
}

.items td {
    border:1px solid #ccc;
    padding:8px;
}
/* WATERMARK – works on all pages */
.watermark {
    position: fixed;
    top: 35%;
    left: 20%;
    width: 60%;
    opacity: 0.08;
    z-index: -1;
}
.watermark img { width: 100%; }
/* Info section */
.info {
    margin-bottom: 10px;
    display: flex;
    /* gap: 18px; */
}

.info .left { flex: 1; }
.info .right { width: 46%; }

.info-table {
    width: 100%;
    border: 1px solid #e0e0e0;
    border-collapse: collapse;
}

.info-table td {
    padding: 6px 8px;
    vertical-align: top;
    border-bottom: 1px solid #f0f0f0;
}

.info-table td.label {
    width: 28%;
    font-weight: 600;
    color: #444;
}

}

</style>
</head>

<body>
    <div class="watermark">
    <img src="<?= base_url(); ?>public/header/header.jpg" alt="">
</div>

<!-- ============================================================
     FIXED HEADER OUTSIDE TABLE STRUCTURE
=============================================================== -->
<div class="fixed-header">
    <table style="border:0;">
       <tr>
        <td width="50%">
            <img src="<?= base_url() ?>public/header/header.jpg" style="width:300px;height:70px;">
        </td>
        <td width="50%" align="right" style="line-height:1.3;">
            <strong style="font-size:13px;"><?= $comp_details['company_name']; ?></strong><br>
            <?= nl2br($comp_details['company_address']); ?><br>
            <?= $comp_details['company_city']; ?>, <?= $comp_details['company_state']; ?><br>
            <?= $comp_details['company_country']; ?><br/><?= $comp_details['company_po']; ?>
            <?= $comp_details['company_trn']; ?>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="center" style="padding-top:6px;">
            <span style="font-size:16px; font-weight:bold;">PURCHASE ORDER</span>
        </td>
    </tr>
    </table>
</div>


<!-- ============================================================
     MAIN PAGE FRAME (reserves header & footer)
=============================================================== -->
<table>
    <thead>
        <tr><td class="header-space">
 

        
        </td></tr>
    </thead>

    <tbody>
        <tr>
            <td>

                <!-- ======================================================
                     MAIN CONTENT AREA
                ======================================================= -->
                <div class="content-wrapper">

             <div class="info">
        <div class="left">
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
                            <td><?= $po[0]->supplier_email; ?></td>
                        </tr>
                        <tr>
                            <td align="left"><b>Contact Person</b></td><td>:</td>
                            <td><?= $po[0]->supplier_email; ?></td>
                        </tr>
                        <tr>
                            <td align="left"><b>TRN No</b></td><td>:</td>
                            <td><?= $po[0]->trn_no; ?></td>
                        </tr>
                        <tr>
                            <td align="left"><b>Shipment Mode</b></td><td>:</td>
                            <td><?= $po[0]->freight_mode; ?></td>
                        </tr>
                    </table>
        </div>

        <div class="right">
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
                          <tr>
                            <td align="left"><b>Quote Ref</b></td><td>:</td>
                            <td><?= $po[0]->quotation_code; ?></td>
                        </tr>
                          <tr>
                            <td align="left"><b>Payment Terms</b></td><td>:</td>
                            <td><?= $po[0]->payment_term; ?></td>
                        </tr>
                          <tr>
                            <td align="left"><b>Shipping Terms</b></td><td>:</td>
                            <td><?= $po[0]->shipping_term; ?></td>
                        </tr>
                    </table>
        </div>
    </div>      

                    <!-- ==================================================
                         PRODUCT TABLE
                    ==================================================== -->
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
                    <td colspan="7" align="right"><b>Additional Discount</b></td>
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
                  

            </td>
        </tr>
    </tbody>
</table>


</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>
