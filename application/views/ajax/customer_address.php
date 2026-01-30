<?php $i=51; foreach($records as $row) { ?>
		<h6>Customer Billing Address</h6>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Address:</label>
			<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
				<input type="text" id="billing_addr1" name="billing_addr1"  class="form-control col-sm-2 form-control-sm"  placeholder="write billing address" tabindex="6" value="<?php echo $row->billing_address;?>">
			</div>
	       </div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">City:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input id="billing_city" name="billing_city" type="text" class="form-control col-sm-2 form-control-sm" tabindex="8" value="<?php echo $row->billing_city;?>"/>
			</div>
			<label class="col-sm-2 control-label">State:</label>
			<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input pattern="[a-zA-Z ]+" id="billing_state" name="billing_state" type="text" class="form-control col-sm-2 form-control-sm" tabindex="9" value="<?php echo $row->billing_state;?>"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">PO Box:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input  id="billing_po" name="billing_po" type="text" tabindex="10" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->billing_po_box;?>"/>
			</div>
			<label class="col-sm-2 control-label">Country:</label>
			 <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input pattern="[a-zA-Z ]+" id="billing_country" name="billing_country" type="text" tabindex="11" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->billing_country;?>"/>
			</div>
		</div>    		
		<h6>Customer Shipping Address  <input type='checkbox' id='copy_address' value='1'  onclick='copy_billing_address()' />Same As Billing</h6>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Address:</label>
			<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
				<input type="text" id="shipping_addr1" name="shipping_addr1"  tabindex="12" class="form-control col-sm-2 form-control-sm"  placeholder="write shipping address" value="<?php echo $row->shipping_address;?>">
			</div>
	       </div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">City:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input id="shipping_city" name="shipping_city" tabindex="14" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_city;?>"/>
			</div>
			<label class="col-sm-2 control-label">State:</label>
			<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input pattern="[a-zA-Z ]+" id="shipping_state" name="shipping_state" tabindex="15" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_state;?>"/>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 control-label">PO Box:</label>
		  	<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input id="shipping_po" name="shipping_po" tabindex="16" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_po_box;?>"/>
			</div>
			<label class="col-sm-2 control-label">Country:</label>
			 <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input pattern="[a-zA-Z ]+" id="shipping_country" name="shipping_country" tabindex="17" type="text" class="form-control col-sm-2 form-control-sm" value="<?php echo $row->shipping_country;?>"/>
			</div>
		</div>	
		
		<div class="form-group row">
		  	<table class="table table-bordered table-hover" id="tab_logic">
				   <thead>
				    <tr>
				    	    <th title="Item">Select</th>
				    	    <th title="Item">Customer Contact Person</th>
				    	    <th title="Item">Mobile Number</th>    
				    	    <th title="Item">Email Id</th>   
					</tr>
				    </thead>		 
				    <tbody >
					<?php  if(!empty($cp_list)){
					 foreach($cp_list as $r) {?>
					<tr>
						<td>
							<input type='radio' name='cp_select' value='<?php echo $r->cp_id;?>' checked />
							<input type="hidden"  name="cp_new<?php echo $r->cp_id;?>" value='0' /> 
						</td>
						<td><input type="text" name="cp_name<?php echo $r->cp_id;?>" id="cp_name" tabindex='2' class="form-control" placeholder="" value="<?php echo $r->cp_name;?>" ></td>
						<td><input type="text" name="cp_mobile<?php echo $r->cp_id;?>" id="cp_mobile" tabindex='3' class="form-control" placeholder="" value="<?php echo $r->cp_mobile;?>"></td>
						<td><input type="email" name="cp_email<?php echo $r->cp_id;?>" id="cp_email" tabindex='3' class="form-control" placeholder="" value="<?php echo $r->cp_email;?>">
						<input type="hidden"  name="trans_id[]" value="<?php echo $r->cp_id;?>" ></td>
						<!--<td>
						<a  href="javascript:confirmcancel(<?php echo $r->cp_id;?>)" title="Delete" class="btn btn-xs bg-orange"><span class="fa fa-trash"></span></a></td>-->
					</tr>
					<?php  } ?>
					
					<tr>
						<td>
							<input type='radio' name='cp_select' value='0'  />
							<input type="hidden"  name="cp_new0" value='1' /> 
						</td>
						<td><input type="text"  name="cp_name0" id="cp_name" tabindex='2' class="form-control" placeholder="" ></td>
						<td><input type="text" name="cp_mobile0" id="cp_mobile" tabindex='3' class="form-control" placeholder="" ></td>
						<td><input type="email" name="cp_email0" id="cp_email" tabindex='3' class="form-control" placeholder="" ></td>
					</tr>
					<?php
					} else { ?>
					<tr>
						<td>
							<input type='radio' name='cp_select' value='0'  />
							<input type="hidden"  name="cp_new0" value='1' /> 
						</td>
						<td><input type="text"  name="cp_name0" id="cp_name" tabindex='2' class="form-control" placeholder="" ></td>
						<td><input type="text" name="cp_mobile0" id="cp_mobile" tabindex='3' class="form-control" placeholder="" ></td>
						<td><input type="email" name="cp_email0" id="cp_email" tabindex='3' class="form-control" placeholder="" ></td>
					</tr>
					<?php  } ?>
				</tbody>
			</table>
		</div>
		
<?php  $i++; } ?>


