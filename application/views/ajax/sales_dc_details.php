
<?php foreach($records1 as $row) { ?>	

	<div class="form-group row" >
	<table class="table table-bordered table-hover" id="tab_logic">
		<thead>
		<tr>
		    <th title="Item">Order code</th>   
		    <th title="Item">Ordered/Bal Qty</th>    
		    <th title="Item">Delivered Qty</th>       
		    <th title="Item">Status</th>           
		    <th title="Item">Net Wet<br>(kg)</th>           
		    <th title="Item">Gross Wt<br>(kg)</th>           
		    <th title="Item">Volume<br>(cm*cm*cm)</th>     
		    
		</tr>
		</thead>
		<?php $i=51; foreach($records2 as $r) { ?>
		<tr id="addr<?php echo $i;?>">
			<td><input type="text"  name="order_code[]" id="order_code<?php echo $i;?>" class="form-control bg-soft-gray form-control-sm" required value="<?php echo $r->order_code;?>" readonly>
			<br><textarea rows='7' cols='30' name="desc[]" id="desc<?php echo $i;?>"  class="form-control form-control-sm bg-soft-gray" readonly required><?php echo $r->desc;?></textarea></td>
			<td width='100px'><input type="number" name="qty[]" id="qty<?php echo $i;?>"  class="form-control form-control-sm" value="<?php echo $r->quantity;?>" readonly>
			<td width='100px'><input type="number" name="delivered_qty[]" id="delivered_qty<?php echo $i;?>"  max="<?php echo $r->quantity;?>" class="form-control form-control-sm" value="<?php echo $r->quantity;?>" readonly>
			<td>
			<select name="type" id="type" class="form-control form-control-sm">
				<option value='F'>Full Delivered</option>
				<option value='P'>Partial Delivered</option>
			</select>
			<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
			</td>
			
			
		</tr>
		<?php  $i++; } ?>
	</table>
	</div>
	
	<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Sub Total</label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		     	 <input type="text" id='sub_total' name='sub_total' readonly class="form-control form-control-sm" value="<?php echo $row->sub_total;?>" >
		    </div>

	     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Discount Amt:</label>
	    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="number" name="discount" id="discount" class="form-control form-control-sm"  <?php echo $row->discount;?>  readonly>
		     </div>
		    <label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 col-form-label">Total before VAT</label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		       <input type="text" id='total_before_vat' name='total_before_vat' readonly class="form-control form-control-sm" value="<?php echo $row->sub_total-$row->discount;?>" >
		      </div>
		</div>
		<hr class='bg-primary'></hr>
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">VAT (<?php echo $row->vat_percent?>%) </label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" id='vat_amt' name='vat_amt' class="form-control form-control-sm" readonly="TRUE" value="<?php echo $row->vat_amt;?>" readonly>
		      </div>
		    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Currency Rate <span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		    	<input type="text" id='crate' name='crate' class="form-control form-control-sm" value="<?php echo $row->currency_rate;?>" readonly>
		      </div>
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Grand Total(AED)<span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='grand_total' name='grand_total' readonly class="form-control form-control-sm"  value="<?php echo $row->grand_total;?>" required>
		      </div>
		</div>
		<hr>
		
		<div class="form-group row">
		     	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Payment Terms1:</label>
		    	<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="text" name="term1" id="term1" class="form-control form-control-sm"  readonly value="<?php echo $row->payment_term1;?>" >
		       </div>
		     	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Payment Terms2:</label>
		    	<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="text" name="term2" id="term2" class="form-control form-control-sm"  readonly value="<?php echo $row->payment_term2;?>">
		       </div>
		     	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Payment Terms3:</label>
		    	<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="text" name="term3" id="term3" class="form-control form-control-sm"  readonly value="<?php echo $row->payment_term3;?>">
		       </div>
		</div>
		<div class="form-group row">
		     	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Client Ref. :</label>
		    	<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="text" name="client_ref" id="client_ref" class="form-control form-control-sm"  value="<?php echo $row->client_ref;?>" readonly >
		       </div>
		     	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Validity:</label>
		    	<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			      <input type="text" name="validity" id="validity" class="form-control form-control-sm"    value='<?php echo $row->payment_term3;?>' readonly>
		       </div>
		</div>
		<div class="form-group row">
		   <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Terms & Condition:</label>
		    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	   		 <textarea  cols='50' rows='4' name="terms" id="terms" class="form-control form-control-sm" ><?php echo $row->terms;?></textarea>		     
		    </div>
		   <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Certificate details:</label>
		    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	   		 <textarea  cols='50' rows='4' name="certificate_details" id="certificate_details"  class="form-control form-control-sm" ><?php echo $row->certificate_details;?></textarea>		     
		    </div>
		</div>

<?php } ?>
