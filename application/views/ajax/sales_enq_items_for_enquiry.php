<?php $i=5000; foreach($records2 as $r) { ?>
		<tr id="addr<?php echo $i;?>">
			<td>						
				<input type="text" name="srn[]" id="srn<?php echo $i;?>" tabindex='10' class="form-control form-control-sm" placeholder="" value="<?php echo $r->srn;?>">
			</td>
			<td>
				<input type="text"  name="order_code[]" id="order_code<?php echo $i;?>" class="form-control  form-control-sm" placeholder="Enter Order Code Here"  required value="<?php echo $r->pcode;?>" >
				<input type="hidden"  name="pcode[]" id="pcode<?php echo $i;?>" class="form-control  form-control-sm" placeholder="Enter Order Code Here"  required value="<?php echo $r->pcode;?>" >
				<br><textarea rows='7' cols='30'  name="desc[]" id="desc<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"  required><?php echo $r->product_desc;?></textarea>
			</td>
			<td>	
				<input type="number" name="qty[]" id="qty<?php echo $i;?>"  class="form-control form-control-sm" value="<?php echo $r->quantity;?>" >
			</td>
			<td>
				<input type="text" name="size[]" id="size<?php echo $i;?>" tabindex='15' class="form-control form-control-sm" placeholder="" value="<?php echo $r->size;?>">
			</td>
			<td>
				<textarea name="item_remark[]" id="item_remark<?php echo $i;?>" tabindex='16' class="form-control form-control-sm" placeholder="remark" ><?php echo $r->item_remark;?></textarea><br>
				<input type="file" name="drawing[]" id="drawing<?php echo $i;?>" tabindex='17' class="form-control form-control-sm" ><br>(PDF file, max file size:500kb)
				
				<?php if($r->file_name!='')
				{?>
				<a download href="<?php echo base_url().'public/user_documents/'.$r->file_name;?>"><?php echo $r->file_name;?></a>
				<?php }?>
				<input type="hidden"  name="item_file_name[]" value="<?php echo $r->file_name;?>" >
				
				<input type="hidden"  name="product_id[]" value="<?php echo $r->product_id;?>" >
				<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
			</td>
			<td>
			<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i;?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
			</td>
		</tr>
		
<?php  $i++; } ?>

		<tr id='addr1'></tr>


