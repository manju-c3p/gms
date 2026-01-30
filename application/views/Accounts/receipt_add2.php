
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
  integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
  integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>
<div class="card-body">
	<form class="form-horizontal" action="<?php echo base_url().'index.php/accounts/add_receipt_details'; ?>" id="receipt" method="post" name="receipt" >
	    <div class="form-group row">
	    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Receipt Date <span style="color: red;"> * </span></label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
				<div class="input-group date datepicker1">			                  
		    			<input type="text" class="form-control form-control-sm datepicker1" id="v_date" name="v_date" value="<?php echo date('d-m-Y')?>" required tabindex=1>
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			      	</div>
    	     		 </div>
		      <label  class="col-sm-3 control-label">Select Invoice</label>
		      <div class="col-sm-4">
			<select name="invoice_id" id="invoice_id" class="form-control select2" tabindex="2">
			  <option value="">Select</option>
			  <?php foreach($records as $s) {?>
				  <option value="<?php echo $s->invoice_id; ?>"><?php echo $s->invoice_code.' '.$s->cust_name.' '.$s->grand_total*$s->currency_rate ;?></option>
				<?php } ?>
			</select>
		      </div>
	    </div>
	    
	    <div class="form-group row">
                            <label class="col-sm-2 control-label">Receipt Details :</label>
            </div>
            
	    <div class="form-group row">
                            <div class="col-md-8">
                            <div class="box box-default">
                            <table id="display" class="table table-bordered  ">
                                <thead>
                                    <tr><th title="Dr"> Dr &nbsp; <button type="button" data-toggle="modal"  onclick="return click_dr();" class="btn btn-sm  btn-primary btn-xs" >+</button></th>
                                        <th title="Debit">Debit</th>
                                        <th title="Cr">Cr &nbsp;<button type="button" data-toggle="modal" onclick="return click_cr();" class="btn btn-sm  btn-primary btn-xs" >+</button> </th>
                                        <th title="Credit">Credit</th>


                                    </tr>
                                 </thead>

                                <tbody>
                                </tbody>
                                <tfoot>
                               <!--<tr><td><a href="#" title="Add debtor" data-toggle="modal" data-target="#drModal" >Add Dr</a></td>
                                   <td></td>
                                   <td><a href="#" title="Add creditor" data-toggle="modal" onclick="return click_cr();" >Add Cr</a></td>
                                 </tr>
				-->
                                 </tfoot>
                                <tr height="100"></tr>
                             </table>

                          </div>

                         </div>

                         </div><!-- end div row -->

                          <div class="form-group row">
                            <label class="col-sm-2 control-label">Debit Total</label>
                                <div class="col-sm-3">
                                <input class="form-control" id="debit_total" name="debit_total" type="text" value="" readonly>
                                </div>
                             <label class="col-sm-2 control-label">Credit Total</label>
                                <div class="col-sm-3">
                                <input class="form-control" id="credit_total" name="credit_total" type="text" value="" readonly>
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


<!-- modal start >

    <!-- start of Dr modal -->
<div class="modal fade" id="drModal" role="dialog"  aria-labelledby="drModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>-->
            <h4 class="modal-title" id="myModalLabel">Receipt Details</h4>
            </div>
            <div class="modal-body">
                 <form class="form-horizontal" id="ajaxadd">
                  <div class="form-group row">
                          <label class="col-sm-3 control-label">Dr:</label>
                          <div class="col-md-9">
                          	<select name="debtor" id="debtor" class="form-control" required>
					<option value="">Select</option>
					<?php foreach($sundry_detors_records as $row) { ?>
		       	    		<option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
					<?php } ?>
				 </select>
                          </div>
                          <label id="set_balance" class="col-sm-2 control-label"></label>
                  </div>
                  <div class="form-group row">
                           <label class="col-sm-3 control-label">Debit :</label>
                            <div class="col-md-9">
                            <input class="form-control" id="dr_amount" name="dr_amount" type="number" step='0.01'  value="" required>
                            </div>
                  </div>
                  
                  <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-7">
                     <button type="button" class="btn btn-sm btn-primary" onclick="add_dr();" >Add</button>&nbsp;&nbsp;&nbsp;&nbsp;
                     <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" onclick="close_dr();">Close</button>
                     <input id="unid" name="unid" type="hidden" value="1" >
                     </div>
                  </div>
                  </form>
                </div>
                </div>
                </div>
                </div>

            <!--
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Add</button>
            </div>-->

            <!-- start of Cr modal -->
<div class="modal fade" id="crModal" role="dialog" aria-labelledby="crModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>-->
            <h4 class="modal-title" id="myModalLabel">Receipt Details</h4>
            </div>
            <div class="modal-body">
                 <form class="form-horizontal" id="ajaxadd1">
                  <div class="form-group row">
                          <label class="col-sm-3 control-label">Cr :</label>
                          <div class="col-md-9">
                            	<select name="creditor" id="creditor" class="form-control" required>
					<option value="">Select</option>
					<?php foreach($receipt_Creditors as $row) { ?>
		       	    		<option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
					<?php } ?>
				 </select>
                          </div>
                          <label id="set_balance1" class="col-sm-2 control-label"></label>
                  </div>
                  <div class="form-group row">
                           <label class="col-sm-3 control-label">Credit :</label>
                            <div class="col-md-9">
                            <input class="form-control" id="cr_amount" name="cr_amount[]" type="number" step='0.01'  value="" required>
                            </div>
                  </div>
                  
                  <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-5">
                     <button type="button" class="btn btn-sm  btn-primary" onclick="add_cr();" >Add</button>&nbsp;&nbsp;&nbsp;&nbsp;
                     <button type="button" class="btn btn-sm  btn-primary" data-dismiss="modal" onclick="close_cr();">Close</button>
                     <input id="unid" name="unid" type="hidden" value="1" >
                     </div>
                  </div>
                  </form>
                </div>
                </div>
                </div>
                </div>



<!-- end of modal -->

<script>

  $(function () {
    $("#debtor").selectize();
  });
  
  
var dr_total=0.0;
var cr_total=0;
var cr_a = [];
var dr_a = [];
var i;
function add_dr()
{
        debtor_id=document.getElementById('debtor').value;
        debtor=$("#debtor option:selected").text();
        dr_amount=document.getElementById('dr_amount').value;
        creditor_id=document.getElementById('creditor').value;
        creditor=$("#creditor option:selected").text();
        cr_amount=document.getElementById('cr_amount').value;
       // drcenter_id=document.getElementById('drcenter_id').value;
       
        if(debtor_id=='' && dr_amount=='')
        {
        	alert('Please select Debit account and Amount');
        	return false;
        }
        else
        {

        for(i=0;i<dr_a.length;i++)
        {
            if(dr_a[i]==debtor_id)
              {
                  //alert(dr_a[i])
                  alert('Detor already exist');
                  document.getElementById('debtor').value="";
                  document.getElementById('dr_amount').value="";
                  return false;
              }

        }

        for(i=0;i<cr_a.length;i++)
        {
            if(cr_a[i]==debtor_id)
              {
                  //alert(cr_a[i]);
                  alert('Alreay used in credtor');
                  document.getElementById('debtor').value="";
                  document.getElementById('dr_amount').value="";
                  return false;
              }

        }

        dr_a.push(debtor_id);
            var txt='';
        // set table data
        txt +="<tr><td><input type=hidden name='debtor[]' value=\'"+debtor_id+"\' >"+debtor+"</td><td><input type=hidden name='dr_amount[]' value=\'"+dr_amount+"\' >"+dr_amount + "</td><td class='text-center'>-</td><td class='text-center'>-</td></tr>";

        $("#display").append(txt);
        $("#drModal").modal('hide');
        document.getElementById('debtor').value="";
        cmp=debtor_id;
        dr_total=parseFloat(dr_total)+parseFloat(dr_amount);
        $('#debit_total').val(dr_total.toFixed(2));
        document.getElementById('creditor').value="";
        document.getElementById('dr_amount').value="";
        document.getElementById('check_dr_id').value=debtor_id;
        }
                
}

function add_cr()
{
        debtor_id=document.getElementById('debtor').value;

        debitor=$("#debtor option:selected").text();
        dr_amount=document.getElementById('dr_amount').value;
        creditor_id=document.getElementById('creditor').value;
        creditor=$("#creditor option:selected").text();
        cr_amount=document.getElementById('cr_amount').value;
        //crcenter_id=document.getElementById('crcenter_id').value;
	if(creditor_id=='' && cr_amount=='')
        {
        	alert('Please select Credit account and Amount');
        	return false;
        }
        else
        {

		for(i=0;i<dr_a.length;i++)
		{
		    if(dr_a[i]==creditor_id)
		      {
		          //alert(dr_a[i])
		          alert('Already used in debtor');
		          document.getElementById('creditor_id').value="";
		          document.getElementById('cr_amount').value="";
		          return false;
		      }

		}

		for(i=0;i<cr_a.length;i++)
		{
		    if(cr_a[i]==creditor_id)
		      {
		          //alert(cr_a[i])
		          alert('Creditor already exist');
		          document.getElementById('creditor_id').value="";
		          document.getElementById('cr_amount').value="";
		          return false;
		      }

		}

		cr_a.push(creditor_id);


		    var txt='';
		// set table data
		txt +="<tr><td class='text-center'>-</td><td class='text-center'>-</td><td><input type=hidden name='creditor[]' value=\'"+creditor_id+"\' >"+creditor+"</td><td><input type=hidden name='cr_amount[]' value=\'"+cr_amount+"\' >"+cr_amount + "</td></tr>";

		$("#display").append(txt);
		$("#crModal").modal('hide');
		document.getElementById('debtor').value="";
		document.getElementById('dr_amount').value="";
		cr_total=parseFloat(cr_total)+parseFloat(cr_amount);
		document.getElementById('credit_total').value=cr_total;
		$('#credit_total').val(cr_total.toFixed(2));
		document.getElementById('creditor').value="";
		document.getElementById('cr_amount').value="";
	}
}
	function click_dr()
	{
		$('#drModal').modal('show');
	}
    
	function click_cr()
	{
		var check_dr=document.getElementById('check_dr_id').value;
		if (check_dr==0){
		     alert("Please first add the debtor");
		     return false;
		}
		else
		{
			$('#crModal').modal('show');
		}
	}
	function close_cr()
	{
		$('#crModal').modal('hide');
	}
	function close_dr()
	{
		$('#drModal').modal('hide');
	}
	
</script>
<script>


$("#display").on('click','.remove1',function(){
        $(this).parent().parent().remove();
    });

    function check_total()
    {
         if($('#addform').valid())
       {

        var dr_total=$('#debit_total').val();
        var cr_total=$('#credit_total').val();

         if(parseFloat(cr_total) != parseFloat(dr_total))
        {
             alert("Both debit total and credit total must match");
             return false;
        }
       }
    }

    function get_account_balance()
    {
       var dr_id=document.getElementById('debtor').value;
       var cr_id=document.getElementById('creditor').value;
       if(dr_id !='')
       {
            var account_id=dr_id;
       }
       if(cr_id !='')
       {
            var account_id=cr_id;


       }
        $.ajax(
               {

                  type: "POST",
                  url: "ajax/get_account_balance.php",
                  data: { ac_id: account_id },
                  success: function( response )
                  {
                    $( "#set_balance").html(response);
                    $( "#set_balance1").html(response);
                  },
                  error: function( error )
                  {
                     console.log(error);
                     alert( error );

                  }

               } );
    }
    </script>
