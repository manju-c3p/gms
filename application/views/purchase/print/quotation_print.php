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
    .header-space { height: 130px; }

    /* SPACE RESERVED FOR FOOTER */
    .footer-space { height: 160px !important; }

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
    margin-top:115px;
    display: flex;
    gap: 18px;
}

.info .left { flex: 1; }
.info .right { width: 36%; }

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
            <span style="font-size:16px; font-weight:bold;">SUPPLIER QUOTATION</span>
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
 <div class="info">
        <div class="left">
            <table class="info-table">
                <tr>
                    <td class="label">Name</td>
                    <td><?= htmlspecialchars($quote[0]->supplier_name); ?></td>
                </tr>
                <tr>
                    <td class="label">Address</td>
                    <td><?= nl2br(htmlspecialchars($quote[0]->billing_address ?? '')); ?></td>
                </tr>
                <tr>
                    <td class="label">Contact No</td>
                    <td><?= htmlspecialchars($quote[0]->contact_number ?? ''); ?></td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td><?= htmlspecialchars($quote[0]->supplier_email ?? ''); ?></td>
                </tr>
            </table>
        </div>

        <div class="right">
            <table class="info-table">
                <tr>
                    <td class="label">Date</td>
                    <td><?= htmlspecialchars($quote[0]->quotation_date ?? ''); ?></td>
                </tr>
                <tr>
                    <td class="label">Doc No</td>
                    <td><?= htmlspecialchars($quote[0]->quotation_code); ?></td>
                </tr>
                <tr>
                    <td class="label">Supplier</td>
                    <td><?= htmlspecialchars($quote[0]->supplier_name); ?></td>
                </tr>
            </table>
        </div>
    </div>

        
        </td></tr>
    </thead>

    <tbody>
        <tr>
            <td>

                <!-- ======================================================
                     MAIN CONTENT AREA
                ======================================================= -->
                <div class="content-wrapper">

                   

                    <!-- ==================================================
                         PRODUCT TABLE
                    ==================================================== -->
                    <table class="items" aria-labelledby="items">
                    <thead>
                        <tr>
                            <th style="width:44px;">Sl No</th>
                            <th style="width:110px;">Product Code</th>
                            <th style="width:110px;">Model</th>
                            <th>Description</th>
                            <th style="width:56px;" class="c-center">Qty</th>
                            <th style="width:60px;" class="c-center">Unit</th>
                            <th style="width:90px;" class="c-right">Price</th>
                            <th style="width:80px;" class="c-right">Discount</th>
                            <th style="width:100px;" class="c-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1;
                        
                            $total_before_vat = $quote[0]->subtotal ?? 0;
                            $total_discount = 0;
                            $vat_amount = $quote[0]->vat_amt ?? 0;
                            $discount = $quote[0]->discount ?? 0;
                            $grand_total = $quote[0]->grand_total ?? 0;

                        
                                        
                        foreach ($quote_tr as $detail): 
                            // $total_before_vat += $detail->price * $detail->quantity;
                            $total_discount += $detail->dis_amt;
                            // $grand_total = ($total_before_vat - $total_discount) + $vat_amount;
                        ?>
                        <tr>
                            <td class="c-center"><?= $sl++; ?></td>
                            <td><?= htmlspecialchars($detail->item_code); ?></td>
                            <td><?= htmlspecialchars($detail->item_model); ?></td>
                            <td class="desc"><?= htmlspecialchars($detail->item_description); ?></td>
                            <td class="c-center"><?= htmlspecialchars($detail->quantity); ?></td>
                            <td class="c-center"><?= htmlspecialchars($detail->unit_name ?? ''); ?></td>
                            <td class="c-right"><?= number_format($detail->price, 2); ?></td>
                            <td class="c-right"><?= number_format($detail->dis_amt, 2); ?></td>
                            <td class="c-right"><?= number_format($detail->total, 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    
                        <!-- Totals -->
                        <tr>
                            <td colspan="8" align="right" style="border: 1px solid #ccc; padding-right:8px;">Total Before VAT</td>
                            <td style="border: 1px solid #ccc; text-align:right;"><?php echo number_format($total_before_vat, 2); ?></td>
                        </tr>
                        <tr >
                            <td colspan="8" align="right" style="border: 1px solid #ccc; padding-right:8px;">Discount Amount</td>
                            <td style="border: 1px solid #ccc; text-align:right;"><?php echo number_format($total_discount, 2); ?></td>
                        </tr>
                        <tr >
                            <td colspan="8" align="right" style="border: 1px solid #ccc; padding-right:8px;">VAT Amount</td>
                            <td style="border: 1px solid #ccc; text-align:right;"><?php echo number_format($vat_amount, 2); ?></td>
                        </tr>
                        <tr >
                            <td colspan="8" align="right" style="border: 1px solid #ccc; padding-right:8px;">Total Amount</td>
                            <td style="border: 1px solid #ccc; text-align:right;"><?php echo number_format($grand_total, 2); ?></td>
                        </tr>
                    </tbody>
                </table>

                  

            </td>
        </tr>
    </tbody>

    <tfoot>
        <tr><td class="footer-space">
			
		</td></tr>
    </tfoot>
</table>


</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>
