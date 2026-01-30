<?php //$this->load->helper('myopeningbalance_helper');?>
<div class="card-body">
	<form class="form-horizontal" action="<?php echo base_url().'index.php/accounts/add_expense_details'; ?>" id="receipt" method="post" name="receipt" >
	    <div class="form-group row">
	    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Payment Date <span style="color: red;"> * </span></label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
				<div class="input-group date datepicker1">			                  
		    			<input type="text" class="form-control form-control-sm datepicker1" id="v_date" name="v_date" value="<?php echo date('d-m-Y')?>" required tabindex=1>
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			      	</div>
    	     		 </div>
	    </div>
	    
	    <div class="form-group row">
                           <div class="col-md-12">
                            	<table class="table table-bordered table-hover" id="dr_table">
                                <thead>
                                    <tr>
                               		    <th title="Item">Select Bank</th> 
										<th title="Item">Select Ledger Account</th>  
										<th title="Item">Select Type</th>  
										<th title="Item">Amount</th>  
                                    </tr>
                                 </thead>
                                    <tbody>
				     <tr>
					<td>
						<select class="form-select form-control-sm select2" id="group_first_party" name="group_first_party" requird onchange="get_ledger_from_group(this.value,'first','')" style='width:200px;'>
						<option value="">Select</option>
						<?php foreach($account_records as $row) { 
						 if($row->group_name=='Bank Accounts' || $row->group_name=='Cash-in-hand'){?>
						<option value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
						<?php }} ?>
						<option disabled value="">-------Other----------</option>
						<?php foreach($account_records as $row) { 
						 if($row->group_name!='Bank Accounts' || $row->group_name!='Cash-in-hand'){?>
						<option value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
						<?php }} ?>
					      </select>
					   </td> 
					<td>
						<select class="form-select form-control-sm select2" id="ledger_first_party" name="ledger_first_party" requird onchange="get_account_balance(1)" style='width:400px;'>
						
					        </select><br>
					        <label id='balance_ledger1'>Balance</label>
					   </td>   
					   <td>
					   	<select class="form-select form-control-sm select2" id="first_type" name="first_type" requird>
						    <option value="Cr">Credit(Cr)</option>
							<option value="Dr">Debit(Dr)</option>
						
					        </select>
					   </td> 
					   <td><input type="number" step='0.01' name="first_amount" id="first_amount" class="form-control form-control-sm credit_sum" requird min=0 onblur="calculate_grand_total()">
					   </td>
					</tr>
                                </tbody>
                             </table>
                     </div>
            </div>
            
	    <div class="form-group row">
                    <div class="col-md-12">
                            	<table class="table table-bordered table-hover" id="dr_table">
                                <thead>
                                    <tr>
                               		    <th title="Item">Select Group</th> 
										<th title="Item">Select Ledger Account</th>  
										<th title="Item">Select Type</th>  
										<th title="Item">Amount<a id="cr_add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a></th>  

                                    </tr>
                                 </thead>
                                    <tbody id="cr_body">
				     <tr id='cr_addr0'>
				     	<td>
						<select class="form-select form-control-sm select2" id="group_second_party0" name="group_second_party[]" requird onchange="get_ledger_from_group(this.value,'second',0)" style='width:200px;'>
						<option value="">Select</option>
						<?php foreach($account_records as $row) { ?>
						<option value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
						<?php } ?>
					      </select>
					   </td> 
					<td>
						<select class="form-select form-control-sm select2" id="ledger_second_party0" name="ledger_second_party[]" onchange="get_second_account_balance(0); get_invoice_list(0)" requird style='width:400px;'>
					      </select><br>
					      <label id='set_balancecr0'>Balance</label>
					      <br>
					     <select class="form-select form-control-sm select2" id='inv0' name='inv[]' onchange="get_invoice_amount(0); calculate_grand_total();">
					     </select>
					   </td>    
					   <td>
					   	<select class="form-select form-control-sm select2" id="second_type0" name="second_type[]" requird>
						
						<option value="Dr">Debit(Dr)</option>
						<option value="Cr">Credit(Cr)</option>
					        </select>
					   </td> 
					   <td><input type="number" step='0.01' name="second_amount[]" id="second_amount0" class="form-control form-control-sm debit_sum" requird min=0 onblur="calculate_grand_total()">
					</td>
					</tr>
					<tr id='cr_addr1'></tr>
                                </tbody>
                             </table>
                     </div>
                 </div>
                 
                  <div class="form-group row">
                    <label class="col-sm-9 control-label"></label>
                     <label class="col-sm-1 control-label"> Total</label>
                        <div class="col-sm-2">
                        <input class="form-control bg-soft-gray control-sm" id="debit_total" name="debit_total" type="text" value="" readonly>
                        </div>
                   </div>
                   
                  <div class="form-group row">
                    <label class="col-sm-2 control-label">Narration:</label>
                        <div class="col-sm-8">
                        <textarea class="form-control" id="narration"  name="narration"></textarea>
                        </div>
                   </div>
                  <div class="form-group row">
                    <div class="col-sm-offset-4">
			    <input type="hidden" id="vtime" name="vtime" value="<?php echo date('h:i:s');?>" />
			    <input type="hidden" id="invoiceID" name="invoiceID"  />
	                    <button type="submit" class="btn btn-primary m-b-0" onclick="return check_total();"  >Save</button>&nbsp;&nbsp;&nbsp;&nbsp;
	                    <button type="reset" class="btn btn-primary m-b-0"  >Reset</button>
	                    <a target='_blank' class="btn btn-primary m-b-0"  href="<?php echo base_url().'index.php/Accounts/journal'?>" title="details">Add Journal Voucher</a>
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

	 var k=1;
	$("#cr_add_row").click(function()
	{
	     $('#cr_addr'+k).html("<td><select class='form-select form-control-sm select2' id='group_second_party"+k+"' name='group_second_party[]' requird onchange=get_ledger_from_group(this.value,'second',"+k+") style='width:200px;'><option value=''>Select</option><?php foreach($account_records as $row) { ?><option value='<?php echo $row->group_no; ?>'><?php echo $row->group_name; ?></option><?php } ?></select></td><td><select class='form-select form-control-sm select2' id='ledger_second_party"+k+"' name='ledger_second_party[]' onchange='get_second_account_balance("+k+"); get_invoice_list("+k+")' requird style='width:400px;'></select><br><label id='set_balancecr"+k+"'>Balance</label><br><select class='form-select form-control-sm select2' id='inv"+k+"' name='inv[]' onchange='get_invoice_amount("+k+");'></select></td><td><select class='form-select form-control-sm select2' id='second_type"+k+"' name='second_type[]' requird><option value=''>Select</option><option value='Dr'>Debit(Dr)</option><option value='Cr'>Credit(Cr)</option></select></td><td><input type='number' step='0.01' name='second_amount[]' id='second_amount"+k+"' class='form-control form-control-sm debit_sum' requird min=0 onblur='calculate_grand_total()'><a onclick='remove_row_cr("+k+");' id='delete_row2' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
	    $('#cr_body tr:last').after('<tr id="cr_addr'+(k+1)+'"></tr>');
	      k++; 	     	
	     $('.select2').select2({ });
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
function get_ledger_from_group(account_id, type, append_id)
{
	if(type=='first')
		tmp='ledger_first_party';
	else
		tmp='ledger_second_party'+append_id;
		
	$.ajax
	({
		url: "<?php echo site_url('Accounts/ajax_get_ledger_group'); ?>",
		type: 'POST',
		data: {account_id: account_id,type:type},
		success: function(msg) {
			if(msg)
			{
				document.getElementById(tmp).innerHTML=msg;
				
			}
		}
	});
}

function get_account_balance(append_id)
{
	if(append_id=='1')
	{
		tmp='ledger_first_party';
		labelid='balance_ledger1';
	}
	else
	{
		tmp='ledger_second_party';
		labelid='balance_ledger2';
	}

	var account_id=document.getElementById(tmp).value;
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
				if(msg>=0)
					var res= msg+' Dr';
				else
					var res= (msg*-1)+' Cr';
				document.getElementById(labelid).innerHTML='Balance: '+res;
				
			}
		}
	});
	/*if(append_id=='2')
	{
		get_invoice_list();
	}*/
	
}
function get_second_account_balance(append_id)
{
	var account_id=document.getElementById("ledger_second_party"+append_id).value;
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
				document.getElementById('set_balancecr'+append_id).innerHTML='Balance: '+msg;
				get_invoice_list(append_id);
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
	//document.getElementById("credit_total").value= parseFloat(k_total).toFixed(2);
	//check_total();
}

function check_total()
{
	calculate_grand_total();
 	var dr_total=$('#first_amount').val();
	var cr_total=$('#debit_total').val();

 	var first_type=$('#first_type').val();
	var second_type=$('#second_type0').val();
	
	 if(parseFloat(cr_total) != parseFloat(dr_total))
	{
	     alert("Both debit total and credit total must match");
	     return false;
	}
	
	if(first_type==second_type)
	{
		
	     alert("Both Select Type should be diffrent");
	     return false;
	}
}

function get_invoice_list(append_id)
{
 	var group_second_party=$('#group_second_party'+append_id).val();
	var ledger_second_party=$('#ledger_second_party'+append_id).val();
	if(group_second_party==29 || group_second_party==30)
	{
		$.ajax
		({
			url: "<?php echo site_url('Accounts/ajax_get_invoice_list'); ?>",
			type: 'POST',
			data: {account_id: ledger_second_party},
			success: function(msg) {
				if(msg)
				{
					if(msg!='')
					document.getElementById('inv'+append_id).innerHTML=msg;
					else
					document.getElementById('inv'+append_id).innerHTML='';
				}
			}
		});
	}
}
function get_invoice_amount(append_id)
{
	var tmp= document.getElementById("inv"+append_id).value;
	const myArray = tmp.split("#");
	var invid = myArray[0];
	var amount = myArray[1];
	//allVals.push(amount);
	document.getElementById("second_amount"+append_id).value=amount;
	calculate_grand_total();
}
function p_check() {
	var checked= $('input[name="select_invoice[]"]:checked').length;

	if (checked > 0) {
		//alert('checked');
	}
	else {
		alert('not checked'); 
	}
	
	var allVals = [];
	$(".case:checked").each(function() {
		var tmp =$(this).val();
		const myArray = tmp.split("#");
		var invid = myArray[0];
		var amount = myArray[1];
		allVals.push(amount);
	});
	// Creating variable to store the sum
	let sum = 0;
	// Running the for loop
	for (let i = 0; i < allVals.length; i++) {
	    sum += parseFloat(allVals[i]).toFixed(2);
	}
	//alert(sum);
	document.getElementById("second_amount").value=sum;
	//document.getElementById("credit_total").value=sum;
	
	let length = allVals.length;
	if(length>1)
		document.getElementById("second_amount").readOnly = true;
	else
		document.getElementById("second_amount").readOnly = false;
}
</script>
