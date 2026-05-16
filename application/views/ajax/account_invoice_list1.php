
<?php $this->load->helper('myopeningbalance_helper'); ?>
<option value=''>Select</option>

<?php 
// ✅ total advance (constant for display)
$total_advance_display = get_supplier_advance_balance($account_id ?? 0);

// ✅ working copy for FIFO adjustment
$total_advance = $total_advance_display;

foreach($res as $r) {

    $paid = (float) get_paid_invoice_amount($r->utype, $r->inv_id, $account_id);

    $balance = $r->grand_total - $paid;

    // ✅ FIFO usage
    $used_adv = min($balance, $total_advance);

    $adjusted_balance = $balance - $total_advance;

    // reduce only working copy
    $total_advance -= $used_adv;
?>
<option value='<?php echo $r->inv_id . '#' . $adjusted_balance . '#' . $r->grand_total . '#' . $r->invoice_code; ?>'>

<?php 
echo $r->invoice_code . '(' . $r->ref_no . ') ' .
     (!empty($r->grn_date) ? date('Y-m-d', strtotime($r->grn_date)) : '-') .
     ' Total:' . $r->grand_total .
     ' Paid:' . $paid .

     // ✅ show full advance, not reduced one
     ' AdvGiven:' . $total_advance_display .

    //  ' AdvUsed:' . $used_adv .
     ' Bal:' . $adjusted_balance;
?>

</option>
<?php } ?>
