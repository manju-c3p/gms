<?php
	foreach($records1 as $row) { ?>	
	
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">PL date <span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
				<div class="input-group date ">			                  
		    			<input type="text" class="form-control form-control-sm " id="invdate" name="invdate" value="<?php echo date('d-m-Y')?>" required tabindex='3' readonly>
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			      	</div>
    	     		 </div>

	     	    <label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label"></label>
	     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">PL Code <span style="color: red;"> * </span></label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
			      <input type="text" name="pl_code" id="pl_code" class="form-control form-control-sm "  tabindex='4' value="<?php echo str_replace('DO','PL',$row->dc_code); ?>">
		     </div>
		</div>
		
	<div class="form-group row ">
	     	    <label class="col-xs-12 col-sm-1 col-md-3 col-lg-2 col-form-label">Case Required<span style="color: red;"> * </span></label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
			      <input type="number" name="case_no" id="case_no" class="form-control form-control-sm" tabindex='5' value="<?php echo $row->total_case; ?>" onkeyup="get_do_with_case()">
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
	foreach($records3 as $tr) { ?>	
	<div class="form-group row bg-soft-primary" >
		<label class="col-xs-12 col-sm-1 col-md-3 col-lg-2 col-form-label"><h6>For Case</h6></label> 
    	        <div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
			<input type="text"  name="case[]" value="<?php echo $tr->case_no; ?>" class="form-control form-control-sm">
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
		<tr id="addr<?php echo $tr->case_no.$i;?>">
			<td>
				<input type="text"  name="srn<?php echo $tr->case_no ?>[]" id="srn<?php echo $i;?>" class="form-control bg-soft-gray form-control-sm" required value="<?php echo $r->srn;?>" readonly>
			</td>
			<td>
				<input type="text"  name="order_code<?php echo $tr->case_no ?>[]" id="order_code<?php echo $i;?>" class="form-control bg-soft-gray form-control-sm" required value="<?php echo $r->order_code;?>" readonly>
				<br>
				<textarea rows='3' cols='100' name="desc<?php echo $tr->case_no ?>[]" id="desc<?php echo $i;?>"  class="form-control form-control-sm bg-soft-gray" style="font-size:10px; font-weight:bold;" readonly required><?php echo $r->item_desc;?></textarea>
			</td>
			<td width='100px'>
				<input type="number" name="qty<?php echo $tr->case_no ?>[]" id="qty<?php echo $i;?>"  class="form-control form-control-sm bg-soft-gray" value="<?php echo $r->quantity;?>" readonly>
				Size
				<input type="text" class="form-control form-control-sm bg-soft-gray" name="size<?php echo $tr->case_no ?>[]" value="<?php echo $r->size;?>" readonly>
			</td>
			<td width='100px'>
				<input type="number" name="delivered_qty<?php echo $tr->case_no ?>[]" id="delivered_qty<?php echo $i;?>"   class="form-control form-control-sm" value="<?php echo $r->quantity;?>" >	
			</td>
			<td>
				<a id='delete_row' title="Delete" onclick='remove_row(<?php echo $tr->case_no.$i;?>)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
						
			<input type="hidden"  name="trans_id<?php echo $tr->case_no;?>[]" value="<?php echo $r->tr_id;?>" >
			</td>			
		</tr>
		<?php  $i++;  
		}?>
	</table>
	</div>
	
	<input type="hidden"  name="invoice_id" value="<?php echo $row->invoice_id;?>" >
	<input type="hidden"  name="enq_id" value="<?php echo $row->enq_id;?>" >
	<input type="hidden"  name="quote_id" value="<?php echo $row->quote_id;?>" >
	<input type="hidden"  name="customer_id" value="<?php echo $row->customer_id;?>" >
	<input type="hidden"  name="stamp" value="<?php echo $row->stamp_id;?>" >
	
	<h6>Details For Case <?php echo $tr->case_no ?></h6>
	<div class="form-group row">
	    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Net Wt(Kgs)</label>
	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2" >         
		<input type="text" class="form-control form-control-sm " id="netwt<?php echo $tr->case_no ?>" name="netwt[]" value="<?php echo $tr->net_wt;?>" >
 	    </div>
     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Gross Wt (Kgs)</label>
    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" name="gramwt[]" id="gramwt<?php echo $tr->case_no ?>" class="form-control form-control-sm" value="<?php echo $tr->gross_wt;?>" >
	     </div>
     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Volume(cm)</label>
    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" name="volume[]" id="volume<?php echo $tr->case_no ?>" class="form-control form-control-sm"  value="<?php echo $tr->volume;?>" > 
		      
	     </div>
	</div>	
	
	<div class="form-group row">
	    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Diamentions</label>
	    <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4" >         
		<input type="text" class="form-control form-control-sm " id="diamentions<?php echo $tr->case_no ?>" name="diamentions[]" value="<?php echo $tr->diamention;?>" onblur="calculate_volume(<?php echo $tr->case_no ?>)">
	</div>
<?php } 
}?>


	

