<?php $this->load->helper('myopeningbalance_helper'); ?>
<option value=''>Select</option>

<?php 
// ✅ total advance (same for all)
$total_advance = get_supplier_advance_balance($account_id ?? 0);

foreach($res as $r) {

    $paid = (float) get_paid_invoice_amount($r->utype, $r->inv_id, $account_id);
	$balance = max(0, ($r->gtot - $paid) - $total_advance);

    // $balance = max(0, $r->grand_total - $total_advance);
?>
<option value='<?php echo $r->inv_id . '#' . $balance . '#' . $r->gtot . '#' . $r->invoice_code; ?>'>

<?php 
echo $r->invoice_code . '(' . $r->ref_no . ') ' .
     (!empty($r->grn_date) ? date('Y-m-d', strtotime($r->grn_date)) : '-') .
     ' Total:' . $r->gtot .
     ' Paid:' . $paid .

     // ✅ show total advance (same for all rows)
     ' AdvAvailable:' . $total_advance .

     // ✅ show actual balance (not reduced yet)
     ' Bal:' . $balance;
?>

</option>
<?php } ?>
