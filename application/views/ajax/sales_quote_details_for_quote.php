
<?php $i=5000; foreach($records2 as $r) { ?>
	<tr id="addr<?php echo $i;?>">
		<td>						
			<input type="text" name="srn[]" id="srn<?php echo $i;?>" readonly class="form-control form-control-sm" placeholder="" value="<?php echo $r->srn;?>">
		</td>
		<td>
			<input type="text"  name="order_code[]" id="order_code<?php echo $i;?>" class="form-control  form-control-sm" placeholder="Enter Order Code Here"  readonly value="<?php echo $r->order_code;?>">
			<br><textarea rows='7' cols='30'  name="desc[]" id="desc<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm" readonly required><?php echo $r->item_desc;?></textarea>
		</td>
		<td>	Size
			<input type="text" name="size[]" id="size<?php echo $i;?>" readonly class="form-control form-control-sm" placeholder="" value="<?php echo $r->size;?>"><br>
			Delivery
			<input type="text" readonly class="form-control form-control-sm bg-soft-gray" name="delivery[]"  value="<?php echo $r->delivery;?>"><br>
			Quantity
			<input type="number" name="qty[]" id="qty<?php echo $i;?>"  class="form-control form-control-sm" value="<?php echo $r->quantity;?>" onchange="calculate_total('<?php echo $i;?>')">
		</td>
		<td>
			<input type="number" step='0.01' name="price[]" id="price<?php echo $i;?>" class="form-control form-control-sm"  onchange="calculate_total('<?php echo $i;?>')" value="<?php echo $r->price;?>"  required><br><br>
		<br>
			Total
			<input type="number" name="total[]" id="total<?php echo $i;?>" value="<?php echo $r->total;?>" class="form-control bg-soft-gray form-control-sm subItemAmt" readonly required><br>
			
		</td>
		<td>
			<input type="text" name="item_remark[]" id="item_remark<?php echo $i;?>" readonly class="form-control form-control-sm" placeholder="remark" value="<?php echo $r->item_remark;?>">
			
			
			<input type="hidden"  name="product_id[]" value="<?php echo $r->product_id;?>" >
			<br>
			<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i;?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
		</td>
	</tr>
		
<?php  $i++; } ?>
	
	
