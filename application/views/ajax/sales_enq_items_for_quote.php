<?php $this->load->helper('stock_helper.php');
foreach($records as $res1)
{
   if($res1->enq_type=='Treding')
   {?>
	<table class="table table-bordered table-hover" id="tab_logic">
		<thead>
		<tr>
		   <th>Sr </th> 
		    <th>Description</th>      
		    <th>Quantity</th>  
		    <th>Unit Price</th>     
		    <th>Total</th>   
		    <th><!--<a id="add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a>--></th>  
		</tr>
		</thead>	
 		<?php $i=5000; foreach($records2 as $r) { ?>
		<tr id="addr<?php echo $i;?>" style=" font-weight:bold">
			<td>			
				<input type="text" name="srn[]" id="srn<?php echo $i;?>" tabindex='10' class="form-control form-control-sm" placeholder="" value="<?php echo $r->srn;?>">
				
			</td>
			<td>
				<select tabindex="11" class="form-select form-control-sm select2" name="product_id[]" id="product_id<?php echo $i; ?>" style="width:250px;" onchange='get_treding_product_info(<?php echo $i; ?>)'>
				<option value="">Select</option>
				<?php foreach($products as $s) {?>
			  	<option <?php if($s->item_id==$r->product_id) echo 'selected';?> value="<?php echo $s->item_id; ?>"><?php echo $s->item_code.' '.$s->item_name.' '.$s->part_code.' '.$s->make_model;?></option>
				<?php } ?>
		      		</select>
				<textarea rows='4' cols='40'  name="desc[]" id="desc<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"  required><?php echo $r->product_desc;?></textarea>
			</td>
			<td>	
				<input type="number" name="qty[]" id="qty<?php echo $i;?>"  class="form-control bg-soft-gray form-control-sm" value="<?php echo $r->quantity;?>" onchange="calculate_total('<?php echo $i;?>')">
			</td>
			<td>
				<input type="number" step='0.01' name="price[]" id="price<?php echo $i;?>" class="form-control form-control-sm"  onchange="calculate_total('<?php echo $i;?>')" value="<?php echo $r->trading_sale_price;?>" tabindex='9' required><br>
			</td>
			<td>
				<input type="number" name="total[]" id="total<?php echo $i;?>" value="<?php echo $r->trading_sale_price*$r->quantity;?>"  class="form-control bg-soft-gray form-control-sm subItemAmt" readonly required><br>
				<textarea name="item_remark[]" id="item_remark<?php echo $i;?>" tabindex='16' class="form-control form-control-sm" placeholder="remark" ><?php echo $r->item_remark;?></textarea>
			</td>
			<td>
				<input type="hidden"  name="item_file_name[]" value="<?php echo $r->file_name;?>" >
				<input type="hidden"  name="product_id[]" value="<?php echo $r->product_id;?>" >
				<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
				<input type="hidden"  name="append_id[]" value="<?php echo $i;?>" >
				<br>
				<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i;?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
			</td>
		</tr>	
		<?php $i++; } ?>
	   	<tbody id="mytbbody"> 
			<tr id='addr1'></tr>
	        </tbody>	
		</table>
<?php }
else   //project enquiry
{?>
	<!--<a id="add_row1" title="Add" class="btn btn-sm bg-orange" >Add Main Heading<span class="fa fa-plus"></span></a>-->
	<?php $i=5000; foreach($records2 as $r) { ?>
	<div class="form-group row"  id='product_div<?php echo $i; ?>'>
	<table class="table table-bordered table-hover"  id="pdetails<?php echo $i; ?>">
    		<thead>
		<tr>
		   <th>Sr </th> 
		    <th>Description</th>      
		    <th>Quantity</th>  
		    <th>Unit Price</th>     
		    <th>Total</th>   
		    <th></th>  
		</tr>
		</thead>
		<tr id="addr<?php echo $i;?>" style="background-color:#94C973!important; font-weight:bold">
			<td>						
				<input type="text" name="srn[]" id="srn<?php echo $i;?>" tabindex='10' class="form-control form-control-sm" placeholder="" value="<?php echo $r->srn;?>">
				
			</td>
			<td>
				<br><textarea rows='4' cols='40'  name="desc[]" id="desc<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"  required><?php echo $r->product_desc;?></textarea>
			</td>
			<td>	
				<input type="number" name="qty[]" id="qty<?php echo $i;?>"  class="form-control bg-soft-gray form-control-sm" value="<?php echo $r->quantity;?>" onchange="calculate_total('<?php echo $i;?>')">
			</td>
			<td>
				<input type="number" step='0.01' name="price[]" id="price<?php echo $i;?>" class="form-control form-control-sm"  onchange="calculate_total('<?php echo $i;?>')" value="<?php echo $r->project_sale_price;?>" tabindex='9' required><br>
			</td>
			<td>
				<input type="number" name="total[]" id="total<?php echo $i;?>" value="<?php  echo $r->project_sale_price*$r->quantity;?>"  class="form-control bg-soft-gray form-control-sm subItemAmt" readonly required><br>
				<textarea name="item_remark[]" id="item_remark<?php echo $i;?>" tabindex='16' class="form-control form-control-sm" placeholder="remark" ><?php echo $r->item_remark;?></textarea>
			</td>
			<td>
				<input type="hidden"  name="item_file_name[]" value="<?php echo $r->file_name;?>" >
				<input type="hidden"  name="product_id[]" value="<?php echo $r->product_id;?>" >
				<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
				<input type="hidden"  name="append_id[]" value="<?php echo $i;?>" >
				<br>
				<?php 
				$apendid=0; foreach($trans_records2 as $t) { if($t->trans_id1==$r->trans_id) $apendid++; }?>
				<input type="hidden" id="row_id_d<?php echo $i; ?>"  value='<?php echo $apendid; ?>' />
				<input type="hidden" name="product_div_value[]"  value="<?php echo $i; ?>" />
				<a onclick="add_nxt_row('<?php echo "d".$i; ?>',<?php echo $apendid; ?>)" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a>
	    			<a  title="Delete" onclick="remove_product_div(<?php echo $i; ?>)" class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
    			</td>
		</tr>
		<?php $k=0; if($trans_records2){?>
		<tr>
			<td colspan='6'>
				<table width='100%'>
				<?php foreach($trans_records2 as $t) :
				if($t->trans_id1==$r->trans_id){?>
				<tr id="<?php echo 'd'.$i.'_ptr'.$k; ?>" >
					<td>
						<textarea rows='3' cols='10'  name="sub_details<?php echo $i;?>[]" id="sub_detailsd<?php echo $i.$k;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"  required><?php echo $t->sub_details;?></textarea>
					</td>
					<td align='center'>
						<input type="hidden" name="qty<?php echo $i;?>[]" id="qty<?php echo $i.$k;?>" tabindex='10' class="form-control form-control-sm" value="<?php echo $t->qty;?>">
					<a title="Delete" onclick="remove_subrow('<?php echo "d".$i; ?>',<?php echo $k; ?>)" class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
					</td>
				</tr>
				<?php  $k++;  } endforeach; ?>
		 		<tr id="<?php echo 'd'.$i.'_ptr'.$k; ?>" ></tr>
				</table>
			</td>
		</tr>
		<?php } 
		echo "</table></div>";
		$i++; } ?>
<?php }
}?>


