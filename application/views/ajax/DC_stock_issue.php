<tr id="tr_row<?php echo $rowId.$newcnt-1;?>">
        <td>
        	<?php echo $newcnt; ?>
	</td>
        <td>
        	<select class="form-select form-control-sm select2 billentry_cnt" name="bill_entry<?php echo $rowId;?>[]" id="bill_entry<?php echo $rowId;?>0" required >
		<option value="">Select</option>
		<?php  foreach($records1 as $s) {?>
		  <option value="<?php echo $s->stk_id; ?>"><?php echo 'stock Code: '.$s->model_code.' Bill: '.$s->bill_no.' Order Ref:'.$s->order_ref_no.' Box no:'.$s->box_no.' ('.$s->stock.')';?></option>
		<?php } ?>
       </select>
	</td>
	<td>Quantity<br><input type="number" name="qty<?php echo $rowId;?>[]" id="qty<?php echo $order_code;?>0" tabindex='14' class="form-control form-control-sm" placeholder=""  required>
	</td>
	<td>
	<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $rowId.$newcnt-1;?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
	</td>
</tr>

<tr id="stock_addr<?php echo $rowId.$newcnt;?>">
</tr>	

	

