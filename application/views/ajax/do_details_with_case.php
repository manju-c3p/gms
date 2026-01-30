<?php
	foreach($records1 as $row) { ?>	
	<div class="form-group row ">
	     	    <label class="col-xs-12 col-sm-1 col-md-3 col-lg-2 col-form-label">Case Required<span style="color: red;"> * </span></label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
			      <input type="number" name="case_no" id="case_no" class="form-control form-control-sm" onblur="get_invoice_info()" tabindex='5' value="<?php echo $case_no; ?>">
		     </div>
	     	    <label class="col-xs-12 col-sm-1 col-md-3 col-lg-2 col-form-label">Packing Type<span style="color: red;"> * </span></label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
			      <select tabindex="1" class="form-select form-control-sm select2" id="ptype" name="ptype" required >
				<option value="">Select</option>
				<?php foreach($packing_list as $s) {?>
				  <option <?php if($row->packing_id==$s->sno) echo 'selected'; ?> value="<?php echo $s->sno; ?>"><?php echo $s->ptype;?></option>
				<?php } ?>
			      </select>
		     </div>
	     	    <label class="col-xs-12 col-sm-1 col-md-3 col-lg-2 col-form-label">Volume Unit<span style="color: red;"> * </span></label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
			      <select tabindex="1" class="form-select form-control-sm select2" id="unit" name="unit" required >
				<option value="">Select</option>
				<option <?php if($row->volume_unit=='CM') echo 'selected'; ?> value="CM">CM</option>
				<option <?php if($row->volume_unit=='CBM') echo 'selected'; ?> value="CBM">CBM</option>
			      </select>
		     </div>
		</div>
<?php
	for($c=1;$c<=$case_no;$c++) 
{?>
	<div class="form-group row bg-soft-primary" >
		<label class="col-xs-12 col-sm-1 col-md-3 col-lg-2 col-form-label"><h6>For Case</h6></label> 
    	        <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
			<input type="text"  name="case[]" value="<?php echo $c; ?>" class="form-control form-control-sm">
		</div>
	</div>
	<div class="form-group row" >
	<table class="table table-bordered table-hover" id="tab_logic">
		<thead>
		<tr>
		    <th title="Item">Srn</th>   
		    <th title="Item">Order code</th>   
		    <th title="Item">Ordered Quantity</th>     
		    <th title="Item">Packed Quantity</th> 
		    <th title="Item">Delete</th>  
		</tr>
		</thead>
		<?php $i=5000; foreach($records2 as $r) { ?>
		<tr id="addr<?php echo $c.$i;?>">
			<td><input type="text"  name="srn<?php echo $c ?>[]" id="srn<?php echo $i;?>" class="form-control bg-soft-gray form-control-sm" required value="<?php echo $r->srn;?>" readonly>
			<td><input type="text"  name="order_code<?php echo $c ?>[]" id="order_code<?php echo $i;?>" class="form-control bg-soft-gray form-control-sm" required value="<?php echo $r->order_code;?>" readonly>
			<br><textarea rows='7' cols='30' name="desc<?php echo $c ?>[]" id="desc<?php echo $i;?>"  class="form-control form-control-sm bg-soft-gray" readonly required><?php echo $r->item_desc;?></textarea></td>
			<td width='100px'><input type="number" name="qty<?php echo $c; ?>[]" id="qty<?php echo $i;?>"  class="form-control form-control-sm bg-soft-gray" value="<?php echo $r->quantity;?>" readonly>
			<td width='100px'><input type="number" name="delivered_qty<?php echo $c; ?>[]" id="delivered_qty<?php echo $i;?>"   class="form-control form-control-sm" value="<?php echo $r->quantity;?>" >			
			<td>
				<a id='delete_row' title="Delete" onclick='remove_row(<?php echo $c.$i;?>)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
			</td>			
			<input type="hidden"  name="size<?php echo $c; ?>[]" value="<?php echo $r->size;?>" >			
			<input type="hidden"  name="trans_id<?php echo $c; ?>[]" value="<?php echo $r->tr_id;?>" >
		</tr>
		<?php  $i++;  
		}?>
	</table>
	</div>
	
	<input type="hidden"  name="invoice_id" value="<?php echo $row->invoice_id;?>" >
	<input type="hidden"  name="enq_id" value="<?php echo $row->enq_id;?>" >
	<input type="hidden"  name="quote_id" value="<?php echo $row->quote_id;?>" >
	<input type="hidden"  name="customer_id" value="<?php echo $row->customer_id;?>" >
	
	<h6>Details For Case <?php echo $c; ?></h6>
	<div class="form-group row">
	    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Net Wt(Kgs)</label>
	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2" >         
		<input type="text" class="form-control form-control-sm " id="netwt" name="netwt[]" required>
 	    </div>
     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Gross Wt (Kgs)</label>
    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" name="gramwt[]" id="gramwt" class="form-control form-control-sm" required>
	     </div>
     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Volume(cm)</label>
    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" name="volume[]" id="volume" class="form-control form-control-sm"  required> 
		      
	     </div>
	</div>		
	<div class="form-group row">
	    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Diamentions</label>
	    <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4" >         
		<input type="text" class="form-control form-control-sm " id="diamentions" name="diamentions[]" >
	</div>
<?php } 
}?>


	

