
<div class="card-body">
	<form class="form-horizontal" action="<?php echo base_url().'index.php/accounts/add_contra_entry_details'; ?>" id="receipt" method="post" name="receipt" >
	    <div class="form-group row">
	    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Date <span style="color: red;"> * </span></label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
				<div class="input-group date datepicker1">			                  
		    			<input type="text" class="form-control form-control-sm datepicker1" id="v_date" name="v_date" value="<?php echo date('d-m-Y')?>" required tabindex=1>
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			      	</div>
    	     		 </div>
	    </div>
            
	    <div class="form-group row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                            	<table class="table table-bordered table-hover" id="dr_table">
                                <thead>
                                    <tr>
                               		    <th title="Item">Debit Account (Dr)</th> 
				    	    <th title="Item">Debit Amount</th>  
				    	    <th title="Item">Balance</th>  
				    	   <!-- <th width='10%'><a id="dr_add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a></th>>-->

                                    </tr>
                                 </thead>
                                    <tbody id="dr_body">
				     <tr id='dr_addr0'>
					<td>
						<select class="form-select form-control-sm select2" id="debtor0" name="debtor[]" onchange="get_account_balance(0,'dr')" requird>
						<option value="">Select</option>
						<?php foreach($sundry_detors_records as $row) { ?>
			       	    		<option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
						<?php } ?>
					      </select>
					      
					   </td>   
					      <td><input type="number" step='0.01' name="dr_amount[]" id="dr_amount0" class="form-control form-control-sm debit_sum" requird min=0 onkeyup="calculate_grand_total()">
					</td>
					   </td>   
					      <td><label id='set_balancedr0'></label></td>
					<!-- <td><a id='delete_row1' title="Delete" onclick='remove_row_dr(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>-->
					</tr>
					<tr id='dr_addr1'></tr>
                                </tbody>
                             </table>
                     </div>
                 </div>
		<div class="form-group row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                            	<table class="table table-bordered table-hover" id="cr_table">
                                <thead>
                                    <tr>
                               		    <th title="Item">Credit Account (Cr)</th> 
				    	    <th title="Item">Credit Amount</th>    
				    	    <th title="Item">Balance</th>  
				    	    <!-- <th width='10%'><a id="cr_add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a></th>-->

                                    </tr>
                                 </thead>
                                    <tbody id="cr_body">
				     <tr id='cr_addr0'>
					<td>
						<select class="form-select form-control-sm select2" id="creditor0" name="creditor[]" onchange="get_account_balance(0,'cr')" requird>
						<option value="">Select</option>
					<?php foreach($credit_records as $row) { ?>
		       	    		<option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
					<?php } ?>
					      </select>
					   </td>   
					      <td><input type="number" step='0.01' name="cr_amount[]" id="cr_amount0" class="form-control form-control-sm credit_sum" requird min=0 onkeyup="calculate_grand_total()">
					</td>
					      <td><label id='set_balancecr0'></label></td>
					<!-- <td><a id='delete_row1' title="Delete" onclick='remove_row_cr(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>-->
					</tr>
					<tr id='cr_addr1'></tr>
                                </tbody>
                             </table>
                          </div>
		</div>
                  <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="col-sm-2 control-label">Debit Total</label>
                        <div class="col-sm-3">
                        <input class="form-control bg-soft-gray control-sm" id="debit_total" name="debit_total" type="text" value="" readonly>
                        </div>
                     <label class="col-sm-2 control-label">Credit Total</label>
                        <div class="col-sm-3">
                        <input class="form-control bg-soft-gray control-sm" id="credit_total" name="credit_total" type="text" value="" readonly>
                        </div>
                   </div>
                  <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="col-sm-2 control-label">Narration:</label>
                        <div class="col-sm-8">
                        <textarea class="form-control" id="narration"  name="narration"></textarea>
                        </div>
                   </div>
                  <div class="form-group row">
                    <div class="col-md-2"></div>
                    <div class="col-sm-4">
			    <input type="hidden" id="vtime" name="vtime" value="<?php echo date('h:i:s');?>" />
			    <input type="hidden" id="invoiceID" name="invoiceID"  />
	                    <button type="submit" class="btn btn-primary m-b-0" onclick="return check_total();"  >Save</button>&nbsp;&nbsp;&nbsp;&nbsp;
	                    <button type="reset" class="btn btn-primary m-b-0"  >Reset</button>
	                    <input id="check_dr_id" name="check_dr_id" type="hidden" value="" >
                    </div>
                  </div>

	      </form>

                </div>
    		</div>
	</div>
	</div>
	</div>
</div>



<script>
$(document).ready(function(){
	var i=1;
	$("#dr_add_row").click(function()
	{
	     $('#dr_addr'+i).html("<td><select class='form-select form-control-sm select2 select2Width' id='debtor"+i+"' name='debtor[]' onchange='get_account_balance("+i+",'dr')' requird><option value=''>Select Code</option><?php foreach($sundry_detors_records as $s) {?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name;?></option><?php } ?></select><br><label id='set_balancedr"+i+"'>Balance</label></td><td><input type='number' step='0.01' name='dr_amount[]' id='dr_amount"+i+"' class='form-control form-control-sm debit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_dr("+i+");' id='delete_row1' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
	    $('#dr_body tr:last').after('<tr id="dr_addr'+(i+1)+'"></tr>');
	      i++; 	     	
	     $('.select2').select2({ width: "220px" });
	});
	$("#delete_row1").click(function(){
		 if(i>1){
			 $("#dr_addr"+(i-1)).html('');
			 i--;
		 }
	 });
	 
	 var k=1;
	$("#cr_add_row").click(function()
	{
	     $('#cr_addr'+k).html("<td><select class='form-select form-control-sm select2 select2Width' id='debtor"+k+"' name='debtor[]' onchange='get_account_balance("+k+",'dr')' requird><option value=''>Select Code</option><?php foreach($sundry_detors_records as $s) {?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name;?></option><?php } ?></select><br><label id='set_balancedr"+k+"'>Balance</label></td><td><input type='number' step='0.01' name='dr_amount[]' id='dr_amount"+k+"' class='form-control form-control-sm credit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_cr("+k+");' id='delete_row2' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
	    $('#cr_body tr:last').after('<tr id="cr_addr'+(k+1)+'"></tr>');
	      k++; 	     	
	     $('.select2').select2({ width: "220px" });
	});
	$("#delete_row2").click(function(){
		 if(k>1){
			 $("#cr_addr"+(k-1)).html('');
			 i--;
		 }
	 });
});  


function remove_row_cr(append_id)
{    	 
$('#cr_addr'+append_id).attr("id","cr_addr"+append_id+"x");
$('#cr_addr'+append_id+"x").remove();
}

function get_account_balance(append_id,type)
{
	if(type=='dr')
		tmp='debtor';
	else
		tmp='creditor';

	var account_id=document.getElementById(tmp+append_id).value;
	var today="<?php echo date('Y-m-d')?>";
	$.ajax
	({
		url: "<?php echo site_url('Accounts/get_account_balance'); ?>",
		type: 'POST',
		data: {account_id: account_id, today:today },
		success: function(msg) {
			if(msg)
			{
				//alert(msg);
				document.getElementById('set_balance'+type+append_id).innerHTML='Balance: '+msg;
				
			}
		}
	});
}
function calculate_grand_total()
{
	var i_value=0;i_total=0;
	$('.debit_sum').each(function()
	{
		i_value=$(this).val();
		if(i_value=='')
			 i_value = 0;
		else
			i_total+=parseFloat(i_value);
	});
	if(isNaN(i_total)) var dr_total = 0;
	
	var k_value=0;k_total=0;
	$('.credit_sum').each(function()
	{
		k_value=$(this).val();
		if(k_value=='')
			 k_value = 0;
		else
			k_total+=parseFloat(k_value);
	});
	if(isNaN(k_total)) var cr_total = 0;

	document.getElementById("debit_total").value= parseFloat(i_total).toFixed(2);
	document.getElementById("credit_total").value= parseFloat(k_total).toFixed(2);
	//check_total();
}

function check_total()
{
 	var dr_total=$('#debit_total').val();
	var cr_total=$('#credit_total').val();

	 if(parseFloat(cr_total) != parseFloat(dr_total))
	{
	     alert("Both debit total and credit total must match");
	     return false;
	}
}
    
</script>
