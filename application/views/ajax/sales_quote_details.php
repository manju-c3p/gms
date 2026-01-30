<?php //$this->load->helper('stock_helper.php');
 //$this->load->helper('sales_helper.php');?>
<?php foreach($records1 as $row) { ?>	
	<div class="form-group row" >
	    	<div class="col-md-12">
			<div class="dt-responsive">
			<table class='bg-soft-green' width='100%' cellspacing="0" colspacing="0" border='1' >
				<tr>
					<th  style="background-color:#cccccc!important;">Enquiry Code</th>
					<th  style="background-color:#cccccc!important;">Enquiry Date</th>
					<th  style="background-color:#cccccc!important;">Customer</th>
					<th  style="background-color:#cccccc!important;">Client Ref</th>
				</tr>
				<tr>
					<th  style="background-color:#cccccc!important;" >
					<label id='enq_code'><?php echo $row->enquiry_code;?></label>
					<input type="hidden" id='enq_id' name='enq_id' value='<?php echo $row->enq_master_id;?>'> 
					<input type="hidden" id='enquiry_code' name='enquiry_code' value='<?php echo $row->enquiry_code;?>'> 
					</th>
					<th  style="background-color:#cccccc!important;">
					<input type="text" id='enq_date' class="form-control" value="<?php echo $row->enq_date;?>" readonly="TRUE">
					<input type="hidden" id='customer_id' name='customer_id' class="form-control" value="<?php echo $row->customer_id;?>" readonly="TRUE"></th>
					<th  style="background-color:#cccccc!important;" id='cust_name'><?php echo $row->cust_name;?></th>
					<th  style="background-color:#cccccc!important;">
					<input type="text" id='delivery_date' name='delivery_date' class="form-control" value="<?php echo $row->client_ref;?>" readonly="TRUE"></th>
				</tr>
			</table>
			</div>
	   	</div>
	</div>
	<div class="form-group row" >
		<table class="table table-bordered table-hover" id="tab_logic">
		<thead>
		<tr>
	    	    	<th>Description</th>      
	    	    	<th>Quantity</th>  
	    	    	<th>Unit Price</th>     
	    	    	<th>Total
				<!-- <a id="add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a> -->
			</th> 
		</tr>
		</thead>
	        <tbody>
		<?php $i=5000; foreach($records2 as $r) { ?>
		<tr id="addr<?php echo $i;?>" style="background-color:#94C973!important; font-weight:bold">
			<td>
				<textarea rows='4' cols='40' name="desc[]" id="desc<?php echo $i;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm" tabindex='5' required><?php echo $r->product_desc;?></textarea>
			</td>
			<td>	
				<input type="number" name="qty[]" id="qty<?php echo $i;?>"  class="form-control bg-soft-gray form-control-sm" value="<?php echo $r->quantity;?>" onkeyup="calculate_total('<?php echo $i;?>')" tabindex='8'>
			</td>
			<td>
				<input type="number" step='0.01' name="price[]" id="price<?php echo $i;?>" class="form-control form-control-sm"  onkeyup="calculate_total('<?php echo $i;?>')" value="<?php echo $r->price;?>" tabindex='9' required>
				
			</td>
			<td>
				<input type="number" name="total[]" id="total<?php echo $i;?>" value="<?php echo $r->total;?>" class="form-control bg-soft-gray form-control-sm subItemAmt" readonly required>
				<input type="text" name="item_remark[]" id="item_remark<?php echo $i;?>" tabindex='10' class="form-control form-control-sm" placeholder="remark" value="<?php echo $r->item_remark;?>">
				
				<input type="hidden"  name="mainqty[]" value="<?php echo $r->quantity;?>" >
				<input type="hidden"  name="product_id[]" value="<?php echo $r->product_id;?>" >
				<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
				<input type="hidden"  name="append_id[]" value="<?php echo $i;?>" >
				<br>
				<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i;?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
			</td>
		</tr>
		<?php $k=1; if($records3){?>
		<tr>
			<td colspan='4'>
				<table width='100%'>
				<tr>
					<td width='70%'>Sub Heading</td>
					<td width='30%'></td>
				</tr>
				<?php foreach($records3 as $t) :
				if($t->trans_id1==$r->trans_id){?>
				<tr>
					<td>
						<textarea rows='3' cols='10'  name="sub_details<?php echo $i;?>[]" id="sub_detailsd<?php echo $i.$k;?>" style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"  required><?php echo $t->sub_details;?></textarea>
					</td>
					<td><input type="hidden" name="qty<?php echo $i;?>[]" id="qty<?php echo $i.$k;?>" tabindex='10' class="form-control form-control-sm" value="<?php echo $t->qty;?>"></td>
				</tr>
				<?php } endforeach; ?>
				</table>
			</td>
		</tr>
		
		<?php $k++; }  $i++; } ?>
		<!-- <tr id='addr1'></tr> -->
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
			      <input type="number"  step="0.01" name="discount" id="discount" class="form-control form-control-sm"  oninput="calculate_grand_total()" value="<?php echo $row->discount_percent;?>" >
		      </div>
	    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="number" step='0.01' name="discount_amt" id="discount_amt" class="form-control form-control-sm"  oninput="calculate_grand_total();click_amount_reflect_percent();"  value="<?php echo $row->discount;?>" >
		     </div>
		    <label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 col-form-label">Total before VAT</label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		       <input type="text" id='total_before_vat' name='total_before_vat' readonly class="form-control form-control-sm bg-soft-gray" value="<?php echo $row->sub_total-$row->discount;?>" >
		      </div>
		</div>
		<hr class='bg-primary'></hr>
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">VAT (<?php echo $row->vat_percent?>%) </label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" id='vat_amt' name='vat_amt' class="form-control form-control-sm bg-soft-gray" readonly value="<?php echo $row->vat_amt;?>" readonly>
	     		  <input type="hidden" id='vat_percent' name='vat_percent'  value="<?php echo $row->vat_percent;?>" >
	     		  <input type="hidden" id='vat_percent1' name='vat_percent1' value="<?php echo $row->vat_percent;?>" >
		      </div>
		      <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		       <input type="text" id='miscellaneous1' name='miscellaneous1' class="form-control form-control-sm"  value="<?php echo $row->other1;?>" placeholder='miscellaneous1'>
		    </div>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="number" step='0.01' id='miscellaneous_amt1' name='miscellaneous_amt1' class="form-control form-control-sm" value="<?php echo $row->other1_amt;?>" oninput="calculate_grand_total()" placeholder="miscel amt">	      		
		    </div>
		   
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='miscellaneous2' name='miscellaneous2' class="form-control form-control-sm" value="<?php echo $row->other2;?>" placeholder='miscellaneous2'>
		    </div>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="number" step='0.01' id='miscellaneous_amt2' name='miscellaneous_amt2' class="form-control form-control-sm" value="<?php echo $row->other2_amt;?>"  oninput="calculate_grand_total()" placeholder="miscel amt2">	      		
		    </div>
		</div>
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Currency Rate <span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		    	<select tabindex="13" class="form-select form-control-sm" id="currency_id" name="currency_id" onchange="get_currency_conversion()" style='width:175px'>
				<option value="">Select</option>
				<?php foreach($currency_list as $s) {?>
				  <option value="<?php echo $s->id.'@'.$s->rate.'@'.$s->currabrev; ?>"><?php echo $s->country.' '.$s->currabrev;?></option>
				<?php } ?>
		      </select>
	      		<input type="hidden" id='cid' name='cid' value="<?php echo $row->currency_id;?>">
	      		<input type="hidden" id='crate' name='crate' class="form-control form-control-sm bg-soft-gray" readonly value="<?php echo $row->currency_rate;?>">
		      </div>
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Grand Total <span id='currabrev'><?php echo $row->currabrev;?></span><span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='grand_total' name='grand_total'  class="form-control form-control-sm"  value="<?php echo $row->grand_total;?>" required>
		      </div>
		</div>
		<hr>
		<input type="hidden" name="validity" id="validity" value='<?php echo $row->validity;?>' >
		
		<input type="hidden" name="validity" id="term2" value='<?php echo $row->delivery_term;?>' >
		<input type="hidden" name="revision" id="revision" value='<?php echo $row->revision;?>' >
		
		<div class="form-group row">
		   <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Client PO No:</label>
		    <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
	   		  <input type='text' name="po_number" id="po_number"  tabindex=5 class="form-control form-control-sm" value='<?php echo $row->po_number?>' />		     
		    </div>	
		   <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label"> PO Date</label>
		   <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2" role='group'>
		    <div class="input-group date datepicker1">			                  
		    <input type="text" class="form-control form-control-sm datepicker1" id="po_date" name="po_date" value="<?php echo date('d-m-Y', !empty($row->po_date) ? strtotime($row->po_date) : time()); ?>" required tabindex=1>
    		    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
	            </div>
    	     		 </div>
	         	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Job Code:</label>
		    	<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="text" name="hs_code" id="hs_code" class="form-control form-control-sm" value="<?php if($row->hs_code!='') echo $row->hs_code; else echo ''; ?>" >
		       </div>	     	     
		   	     
	         </div>	
	            
		 <h6>Billing Address</h6>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Address:</label>
			<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
				<input type="text" id="billing_addr1" name="billing_addr1"  class="form-control col-sm-2 form-control-sm"  placeholder="write billing address" tabindex="18" value="<?php echo $row->billing_addr;?>">
			</div>
	       </div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">City:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="billing_city" name="billing_city" type="text" class="form-control col-sm-2 form-control-sm" tabindex="19" value="<?php echo $row->billing_city;?>"/>
			</div>
			<label class="col-sm-2 control-label">State:</label>
			<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="billing_state" name="billing_state" type="text" class="form-control col-sm-2 form-control-sm" tabindex="20" value="<?php echo $row->billing_state;?>"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">PO Box:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="billing_po" name="billing_po" type="text" tabindex="21" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->billing_pincode;?>"/>
			</div>
			<label class="col-sm-2 control-label">Country:</label>
			 <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="billing_country" name="billing_country" type="text" tabindex="22" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->billing_country;?>"/>
			</div>
		</div>    		
		<h6>Shipping Address</h6>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Address:</label>
			<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
				<input type="text" id="shipping_addr1" name="shipping_addr1"  tabindex="23" class="form-control col-sm-2 form-control-sm"  placeholder="write shipping address" value="<?php echo $row->shipping_addr;?>">
			</div>
	       </div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">City:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="shipping_city" name="shipping_city" tabindex="24" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_city;?>"/>
			</div>
			<label class="col-sm-2 control-label">State:</label>
			<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="shipping_state" name="shipping_state" tabindex="25" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_state;?>"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">PO Box:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input id="shipping_po" name="shipping_po" tabindex="26" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_pincode;?>"/>
			</div>
			<label class="col-sm-2 control-label">Country:</label>
			 <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="shipping_country" name="shipping_country" tabindex="27" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_country;?>"/>
			</div>
		</div>	
		
		<h6>Contact Person Details</h6>
		<div class="form-group row">
			<label class="col-sm-2 control-label">CP Name:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			<input id="cp_name" name="cp_name" tabindex="28" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->cp_name;?>"/>
			</div>
			<label class="col-sm-2 control-label">CP Mobile:</label>
			 <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			<input  id="cp_mobile" name="cp_mobile" tabindex="29" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->cp_mobile;?>"/>
			</div>
			<label class="col-sm-2 control-label">CP Email:</label>
			 <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			<input id="cp_email" name="cp_email" tabindex="30" type="email" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->cp_email;?>"/>
			</div>
		</div>	   
		<div class="form-group row">
		   <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Payment Term:</label>
		    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
	   		<textarea style='font-size:12px'  cols='50' rows='3' name="term1" id="term1"  tabindex=14 class="form-control form-control-sm" ><?php echo $row->payment_term1?></textarea>	     
		    </div>
		</div>
		<div class="form-group row">
		   <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Payment Mode:</label>
		    <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2">
	   		  <select tabindex="6" class="form-select form-control-sm" id="payment_mode" name="payment_mode" required>
				<option value="">Select</option>
				<option value="1" selected>Cash</option>
				<option value="2">Cheque</option>
				<option value="3">Online</option>
				<option value="4">Credit</option>
			      </select>		     
		    </div>
    		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label" style='font-size:13px;'>Payment/Advance Received</label>
    		    <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
	      		<input type="text" id='received_percent' name='received_percent' placeholder='%' class="form-control"  onkeyup="calculate_percent();">
      		   </div>
    		  <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
	    		<?php  //$x= get_quotation_wise_invamt_received($row->quote_id);?>
	      		<input type="text" id='received_amt' name='received_amt' step="0.001" class="form-control"  onkeyup="calculate_advance();">
      		    </div>
    		    <label class="col-xs-12 col-sm-2 col-md-1 col-lg-1 col-form-label" style='font-size:15px;'>Balance</label>
		   <div class="col-xs-12 col-sm-10 col-md-2 col-lg-2">
		      		<input type="text"   tabindex="8" name="balance" id="balance" class="form-control" readonly>
		      
    		   </div>
		</div>
<?php } ?>
