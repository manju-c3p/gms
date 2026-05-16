<?php
$this->load->helper('myopeningbalance_helper.php'); // for convert_number_to_words() 
?>

<style>
body {
    font-family: Arial, sans-serif;
    font-size: 14px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

table, th, td {
    border: 1px solid #ddd;
}

th {
    background-color: #f0f0f0;
    text-align: center;
    padding: 8px;
}

td {
    padding: 8px;
}

.right-align {
    text-align: right;
}

.center-align {
    text-align: center;
}

.title {
    text-align: center;
    font-weight: bold;
    font-size: 18px;
    margin-top: 10px;
}

.footer {
    margin-top: 60px;
}
</style>

<body onload="window.print();">

<!-- HEADER -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">

    <img src="<?= base_url('public/images/logocooling.png'); ?>" width="30%" style="height:70px;">

    <div style="text-align:right; font-size:13px; line-height:1.5;">
        <strong>Cool Runnings Garage Co LLC</strong><br>
        Al Quoz 3, Dubai, UAE<br>
        www.coolrunningsgarage.com<br>
        Tel: +971 4 265 4887<br>
        TRN: 104026094300003
    </div>

</div>

<h3 class="title">Salary Advance Voucher</h3>

<!-- BASIC INFO -->
<table style="margin-top:10px;">
    <tr>
        <!-- <td><strong>Advance No:</strong> ADV<?= str_pad($advance->advvoucher_codeance_id,5,'0',STR_PAD_LEFT); ?></td> -->

		<td><strong>Advance No:</strong> <?= $advance->voucher_code ?></td>
        <td class="right-align"><strong>Dated:</strong> <?= date('d-M-Y', strtotime($advance->advance_date)); ?></td>
    </tr>

    <tr>
        <td colspan="2">
            <strong>[<?= $advance->employee_code ?>] <?= $advance->employee_name ?></strong>
        </td>
    </tr>
</table>

<!-- ADVANCE DETAILS -->
<table style="margin-top:15px;">
    <thead>
        <tr>
            <th style="width:10%">SL.No</th>
            <th>Particulars</th>
            <th style="width:20%">Amount (AED)</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td class="center-align">1</td>
            <td>Salary Advance Paid</td>
            <td class="right-align"><?= number_format($advance->amount,2) ?></td>
        </tr>

        <tr style="font-weight:bold; background:#eaeaea;">
            <td colspan="2" class="right-align">Total</td>
            <td class="right-align"><?= number_format($advance->amount,2) ?></td>
        </tr>
    </tbody>
</table>

<!-- PAYMENT INFO -->
<p style="margin-top:20px;">
<strong>Through:</strong>
<?= ucfirst($advance->payment_mode); ?>
</p>



<p>
<strong>Remarks:</strong>
<?= $advance->remarks; ?>
</p>

<!-- FOOTER -->
<div class="footer">
    <p>Receiver's Signature: ____________________</p>
    <p class="right-align">Authorised Signatory</p>
</div>

</body>
