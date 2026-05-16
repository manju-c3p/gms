<table class="table table-bordered">
<tr>
    <th>Date</th>
    <th>Ledger</th>
    <th>Amount</th>
</tr>

<?php 
$total = 0;
foreach($ledgers as $l){ 
$total += $l->amount;
?>
<tr>
    <td><?= date('d-m-Y', strtotime($l->date)) ?></td>
    <td><?= $l->ledger_name ?></td>
    <td align="right" style="color: <?= ($l->amount >= 0) ? 'green' : 'red'; ?>">
        <?= number_format(abs($l->amount), 2) ?>
    </td>
</tr>
<?php } ?>

<tr>
    <td colspan="2"><b>Total</b></td>
    <td align="right"><b><?= number_format($total,2) ?></b></td>
</tr>
</table>