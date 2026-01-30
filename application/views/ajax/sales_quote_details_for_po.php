<?php $this->load->helper('sales_helper.php');?>
<?php foreach($records1 as $row) { ?>	
	
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">PO date <span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
				<div class="input-group date ">			                  
		    			<input type="text" class="form-control form-control-sm " id="podate" name="podate" value="<?php echo date('d-m-Y')?>" required tabindex='3' readonly>
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			      	</div>
    	     		 </div>

	     	    <label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label"></label>
	     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">PO Code <span style="color: red;"> * </span></label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
			      <input type="text" name="po_code" id="po_code" class="form-control form-control-sm"  tabindex='4' value="<?php echo $row->petrostar_ref; ?>" required>
		     </div>
		</div>
		<div class="form-group row">
	     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Supplier Ref No</label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
			      <input type="text" name="ref_no" id="ref_no" class="form-control form-control-sm"  tabindex='4' >
		     </div>
		</div>
	<div class="form-group row" >
	<table class="table table-bordered table-hover" id="tab_logic">
		<thead>
		<tr>
		    	<th title="Item">Sr </th> 
			<th title="Item">Order code</th>      
			<th title="Item">Size/Quantity</th>  
			<th title="Item">Price</th>   
			<th title="Item">Remark /Drawing <br>
			 	<!--<a id="add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a>-->
		       </th>   
		</tr>
		</thead>
		
		<tbody id="mytrbody"> 
		<?php $valstart_no=1; $valend_no=0; $i=5000; foreach($records2 as $r) { 
		$last_po_no = substr($row->petrostar_ref,-4);
		$last_po_no = (string)((int)($last_po_no));?>
		<tr id="addr<?php echo $i;?>">
			<td>						
				<input type="text" name="srn[]" id="srn<?php echo $i;?>" readonly class="form-control form-control-sm" placeholder="" value="<?php echo $r->srn;?>"><br>
				Valve Serial No
				<textarea rows='7' cols='30'  name="valve_serial_no[]" id="valve_serial_no<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm" required><?php echo substr($row->petrostar_ref,3,2).ltrim("$last_po_no").sprintf("%1$04d",$valstart_no).'~'.sprintf("%1$04d",($valstart_no+$r->quantity-1)); $valstart_no=$valstart_no+$r->quantity;?></textarea>
			</td>
			<td>
				<input type="text"  name="order_code[]" id="order_code<?php echo $i;?>" class="form-control  form-control-sm" placeholder="Enter Order Code Here"  readonly value="<?php echo $r->order_code;?>">
				<br><textarea rows='7' cols='30'  name="desc[]" id="desc<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm" required><?php echo $r->item_desc;?></textarea>
			</td>
			<td>	Size
				<input type="text" name="size[]" id="size<?php echo $i;?>" readonly class="form-control form-control-sm" placeholder="" value="<?php echo $r->size;?>"><br>
				Required Qty
				<input type="text" readonly class="form-control form-control-sm bg-soft-gray" name="ordered_qty[]"  value="<?php echo $r->quantity;?>"><br>
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
				<input type="text" name="item_remark[]" id="item_remark<?php echo $i;?>"  class="form-control form-control-sm" placeholder="remark" value="<?php echo $r->item_remark;?>">
				
				
				<input type="hidden"  name="product_id[]" value="<?php echo $r->product_id;?>" >
				<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
				<br>
				<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i;?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
			</td>
		</tr>	
<?php  $i++; } ?>
		
		</tbody>
		<tbody id="mytbbody"> 
			<tr id='addr1'></tr>
		</tbody>
	</table>
	</div>
	
	<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-1 col-lg-1 col-form-label">SubTot</label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		     	 <input type="text" id='sub_total' name='sub_total' readonly class="form-control form-control-sm bg-soft-gray" value="<?php echo $row->sub_total;?>" >
		    </div>

	     	     <label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 col-form-label">Dis.%:</label>
	    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="number" step="0.01" name="discount" id="discount" class="form-control form-control-sm"  oninput="calculate_grand_total()" value="<?php echo $row->discount_percent;?>" >
		      </div>
	    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="number" step="0.01" name="discount_amt" id="discount_amt" class="form-control form-control-sm"  oninput="calculate_grand_total();click_amount_reflect_percent();" value="<?php echo $row->discount;?>" >
		     </div>
		    <label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 col-form-label">Total before VAT</label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		       <input type="text" id='total_before_vat' name='total_before_vat' readonly class="form-control form-control-sm bg-soft-gray" value="<?php echo $row->sub_total-$row->discount;?>" >
		      </div>
		</div>
		<hr class='bg-primary'></hr>
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">VAT (<?php echo $row->vat_percent?>%) 
		    <input type='checkbox' id='vatbox' value='1' checked onclick='check_vat_option()' /></label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" id='vat_amt' name='vat_amt' class="form-control form-control-sm bg-soft-gray" readonly value="<?php echo $row->vat_amt;?>" readonly>
	     		  <input type="hidden" id='vat_percent' name='vat_percent'  value="<?php echo $row->vat_percent;?>" >
	     		  <input type="hidden" id='vat_percent1' name='vat_percent1' value="<?php echo $row->vat_percent;?>" >
		      </div>
		      <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='miscellaneous1' name='miscellaneous1' class="form-control form-control-sm"  value="<?php echo $row->other1;?>" >
		    </div>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="number" step='0.01' id='miscellaneous_amt1' name='miscellaneous_amt1' class="form-control form-control-sm" value="<?php echo $row->other1_amt;?>" onkeyup="calculate_grand_total()">	      		
		    </div>
		   
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='miscellaneous2' name='miscellaneous2' class="form-control form-control-sm" value="<?php echo $row->other2;?>" >
		    </div>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="number" step='0.01' id='miscellaneous_amt2' name='miscellaneous_amt2' class="form-control form-control-sm" value="<?php echo $row->other2_amt;?>"  onkeyup="calculate_grand_total()">	      		
		    </div>
		</div>
		<div class="form-group row">
		     <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='miscellaneous3' name='miscellaneous3' class="form-control form-control-sm" value="<?php echo $row->other3;?>" >
		    </div>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="number" step='0.01' id='miscellaneous_amt3' name='miscellaneous_amt3' class="form-control form-control-sm" value="<?php echo $row->other3_amt;?>" onkeyup="calculate_grand_total()" >	      		
		    </div>
		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Currency Rate <span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		    	<select tabindex="13" class="form-select form-control-sm select2" id="currency_id" name="currency_id" onchange="get_currency_conversion()" style='width:175px'>
				<option value="">Select</option>
				<?php foreach($currency_list as $s) {?>
				  <option value="<?php echo $s->id.'@'.$s->rate.'@'.$s->currabrev; ?>"><?php echo $s->country.' '.$s->currabrev;?></option>
				<?php } ?>
		      </select>
	      		<input type="hidden" id='cid' name='cid' value="<?php echo $row->currency_id;?>">
	      		<input type="hidden" id='crate' name='crate' class="form-control form-control-sm bg-soft-gray" readonly value="<?php echo $row->currency_rate;?>">
		      </div>
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Grand Total <span id='currabrev'></span><span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='grand_total' name='grand_total'  class="form-control form-control-sm"  value="<?php echo $row->grand_total;?>" required>
		      </div>
		</div>
		<hr>
		
		
		
		
<?php } ?>
