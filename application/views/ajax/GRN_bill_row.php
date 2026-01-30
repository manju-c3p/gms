<tr id="tr_row<?php echo $rowId.($newcnt-1);?>">
        <td>
        	<?php echo $newcnt; ?>
	</td>
        <td>
        	<input type="text" name="bill_entry<?php echo $rowId;?>[]" id="bill_entry<?php echo $order_code;?>0" tabindex='14' class="form-control form-control-sm" placeholder=""  required>
	</td>
        <td>
        	<input type="text" name="order_no<?php echo $rowId;?>[]" id="order_no<?php echo $order_code;?>0" tabindex='14' class="form-control form-control-sm" placeholder=""  required>
	</td>
	<td>
		<input type="text" name="box_no<?php echo $rowId;?>[]" id="box_no<?php echo $order_code;?>0" tabindex='14' class="form-control form-control-sm" placeholder=""  required>
	</td>
	<td>
		<input type="number" step='0.01'  name="qty<?php echo $rowId;?>[]" id="qty<?php echo $order_code;?>0" tabindex='14' class="form-control form-control-sm" placeholder=""  required>
	</td>
	<td>
		<a id='delete_row' title="Delete" onclick='remove_bill_row("<?php echo $rowId.($newcnt-1);?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
	</td>
</tr>

<tr id="stock_addr<?php echo $rowId.$newcnt;?>">
</tr>	

	

