<?php $i=51; foreach($records2 as $r) { ?>
	<tr id="addr<?php echo $i;?>">
		<td width='100px' style="white-space: normal !important;">
			<?php echo $r->product_desc;?>
			<!--<textarea name="desc[]" id="desc<?php echo $i;?>" class="form-control form-control-sm bg-soft-gray" tabindex='9' readonly required></textarea>-->
			<input type="hidden"  name="trans_id[]" value="<?php echo $r->product_id;?>" >
		</td>
		<td>
			<input type="number" id="qty<?php echo $i;?>" name="qty[]" value="<?php echo $r->quantity;?>"  class="form-control form-control-sm qty_value" onchange="item_wise_calcualtion(<?php echo $i;?>);">
		</td>
		<td>
			<input type="number" step="any" id="price<?php echo $i;?>" name="price[]" value="0"  class="form-control form-control-sm price_value" onchange="item_wise_calcualtion(<?php echo $i;?>);">
		</td>
		<td>
			<input type="number" step="0.01" readonly  id="total<?php echo $i;?>" name="total[]" value="0" class="form-control form-control-sm bg-soft-gray itemtotal1" >
		</td>
		<td>
			<input type="number" step="any" readonly  id="landed_price<?php echo $i;?>" name="landed_price[]" value="0" class="form-control form-control-sm bg-soft-gray" >
		</td>
		<td>
			<input type="number" step="any" readonly  id="landed_cost<?php echo $i;?>" name="landed_cost[]" value="0" class="form-control form-control-sm bg-soft-gray" >
		</td>
		<td>
			<input type="number" step="any" readonly  id="sale_price<?php echo $i;?>" name="sale_price[]" value="0" class="form-control form-control-sm bg-soft-gray" >
		</td>
		<td>
			<input type="number" step="any" readonly  id="sale_cost<?php echo $i;?>" name="sale_cost[]" value="0" class="form-control form-control-sm bg-soft-gray" >
		</td>
		<td>
			<input type="number" step="any" readonly  id="margin<?php echo $i;?>" name="margin[]" value="0" class="form-control form-control-sm bg-soft-gray margin" >
		</td>
	</tr>
<?php  $i++; } ?>
	<tr style="background-color:#cccccc; font-weight:bold; color:balck;">
		<td align='center'>TOTAL</td>
		<td align='center'></td>
		<td align='center'></td>
		<td align='right' id='item_totalCost'></td>
		<td align='center'></td>
		<td align='right' id='item_totallandedCost'></td>
		<td align='center'></td>
		<td align='right' id='item_totalsalePrice'></td>
		<td align='right' id='item_totalmargin'></td>
	</tr>
