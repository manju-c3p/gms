<?php $i=50001; foreach($trans_records as $r) :?>
<table class="table">
				<?php if($i==50001){?>
				 <tr>
			    	    <th>Items</th> 
			    	    <th>Quantity</th>      
			    	    <th>Remark</th>  
			    	    <th width='10%'></th>
				</tr>
				<?php } ?>
				<tr id="addr<?php echo $i;?>">
					<td >
						<select tabindex="11" class="form-select form-control-sm select2 select2Width" id="product_id<?php echo $i;?>" name="product_id[]" onchange="get_product_info_old(<?php echo $i;?>)" >
						<option value="">Select Code</option>
						<?php foreach($products as $s) {?>
						  <option <?php if($s->item_id==$r->product_id) echo 'selected';?> value="<?php echo $s->item_id;?>"><?php echo $s->item_code.' '.$s->item_name.' '.$s->part_code.' '.$s->make_model;?></option>
						<?php } ?>
					      </select>
						<textarea rows='2' cols='20' name="desc[]" id="desc<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm" tabindex='9' required><?php echo $r->product_desc;?></textarea>
					</td>
					<td>
						<input type="number" name="trading_qty[]" id="trading_qty0" tabindex='10' class="form-control form-control-sm" value="<?php echo $r->quantity;?>" required>
					</td>
					<td>
						<textarea rows='2'  name="item_remark[]" id="item_remark0" tabindex='16' class="form-control form-control-sm" placeholder="remark"><?php echo $r->item_remark;?></textarea>
						<input type="hidden"  name="trans_id[]" id="trans_id0" value="<?php echo $r->trans_id;?>" >
						<input type="hidden"  name="trans_master_id[]" id="trans_master_id0" value="<?php echo $r->req_master_id;?>" >
					</td>
					<td>
						<a  href="javascript:remove_row(<?php echo $i;?>)" title="Delete" class="btn btn-xs bg-orange"><span class="fa fa-trash"></span></a>
					</td>
				</tr>
</table>
				<?php $i++; endforeach; ?>