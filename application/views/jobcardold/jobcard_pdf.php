<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border:1px solid #444; padding:6px; text-align:left; }
        .header { font-size:18px; font-weight:bold; margin-bottom:10px; }
    </style>
</head>
<body>

<div class="header">Job Card #<?= $jobcard->jobcard_id ?></div>

<p><strong>Customer:</strong> <?= $jobcard->customer_name ?><br>
<strong>Vehicle:</strong> <?= $jobcard->registration_no ?><br>
<strong>Date:</strong> <?= $jobcard->jobcard_date ?></p>

<h3>Services</h3>
<table>
    <tr><th>Service</th><th>Cost</th></tr>
    <?php foreach ($jobcard->services as $s): ?>
    <tr>
        <td><?= $s->service_name ?></td>
        <td><?= $s->amount ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Parts Used</h3>
<table>
    <tr><th>Part</th><th>Qty</th><th>Price</th></tr>
    <?php foreach ($jobcard->parts as $p): ?>
    <tr>
        <td><?= $p->part_name ?></td>
        <td><?= $p->qty ?></td>
        <td><?= $p->unit_price ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
