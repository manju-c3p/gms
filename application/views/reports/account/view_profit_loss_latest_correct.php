<?php
$this->load->helper('account_helper.php');

$pnl = get_net_profit_loss($from, $to);

$opening_amt = 0;
$closing_amt = 0;

$net_profit = $pnl['net_profit'];
$net_loss   = $pnl['net_loss'];
$final_total = max($pnl['income'], $pnl['expense']);
?>

<div class="bg-white shadow-md rounded-xl p-6">

<form method="post"
    action="<?php echo base_url() . 'index.php/Accounts/get_profit_and_loss'; ?>"
    class="grid md:grid-cols-4 gap-4">

    <input type="text" name="from" value="<?php echo $from; ?>">
    <input type="text" name="to" value="<?php echo $to; ?>">

    <input type="submit" value="Go"
        class="bg-blue-600 text-white px-4 py-2 rounded">
</form>

<div class="grid md:grid-cols-2 gap-6 mt-6">

<!-- ================= LEFT SIDE (EXPENSE) ================= -->

<table class="w-full border text-sm">
<tr class="bg-gray-100">
    <th class="p-2">Particulars</th>
    <th class="p-2 text-right">Amount</th>
</tr>

<tr>
    <td class="p-2 font-semibold">Opening Stock</td>
    <td class="p-2 text-right"><?php echo $opening_amt; ?></td>
</tr>

<?php
$result = get_group_details(1, 4);

foreach ($result as $k) {
?>

<tr>
    <td class="p-2 font-semibold"><?php echo $k->group_name; ?></td>
    <td class="p-2 text-right">
        <?php
        $gno = $k->group_no;
        $gno1 = get_group_nos($k->group_no);

        if ($gno1 != '') {
            $gno2 = get_group_nos($gno1);
            if ($gno2 != '')
                $gno = $k->group_no . ',' . $gno1 . ',' . $gno2;
            else
                $gno = $k->group_no . ',' . $gno1;
        }

        echo get_group_total1($gno, $from, $to);
        ?>
    </td>
</tr>

<?php } ?>

<tr class="bg-green-100 font-semibold">
    <td class="p-2">Net Profit</td>
    <td class="p-2 text-right"><?php echo number_format($net_profit, 2); ?></td>
</tr>

<tr class="bg-gray-200 font-bold">
    <td class="p-2">Total</td>
    <td class="p-2 text-right"><?php echo number_format($final_total, 2); ?></td>
</tr>

</table>


<!-- ================= RIGHT SIDE (INCOME) ================= -->

<table class="w-full border text-sm">
<tr class="bg-gray-100">
    <th class="p-2">Particulars</th>
    <th class="p-2 text-right">Amount</th>
</tr>

<?php
$result = get_group_details(1, 3);

foreach ($result as $kk) {
?>

<tr>
    <td class="p-2 font-semibold"><?php echo $kk->group_name; ?></td>
    <td class="p-2 text-right">
        <?php
        $gno = $kk->group_no;
        $gno1 = get_group_nos($kk->group_no);

        if ($gno1 != '') {
            $gno2 = get_group_nos($gno1);
            if ($gno2 != '')
                $gno = $kk->group_no . ',' . $gno1 . ',' . $gno2;
            else
                $gno = $kk->group_no . ',' . $gno1;
        }

        echo get_group_total1($gno, $from, $to);
        ?>
    </td>
</tr>

<?php } ?>

<tr class="bg-red-100 font-semibold">
    <td class="p-2">Net Loss</td>
    <td class="p-2 text-right"><?php echo number_format($net_loss, 2); ?></td>
</tr>

<tr class="bg-gray-200 font-bold">
    <td class="p-2">Total</td>
    <td class="p-2 text-right"><?php echo number_format($final_total, 2); ?></td>
</tr>

</table>

</div>
</div>
