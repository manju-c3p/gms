<?php if($type=='first') { ?>
<option value="">Select</option>
<?php foreach($ledger_records as $row) { ?>
<option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
<?php } ?>
<?php } 
else
{?>

<option value="">Select</option>
<?php foreach($ledger_records as $row) { ?>
<option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
<?php } }?>
