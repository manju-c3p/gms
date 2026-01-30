<?php foreach($res as $row)
{
	$trans_date=$row->voucher_date;
	$narration=$row->narration;
	$voucher_id=$row->voucher_id;
}
?>
<div class="card-body">
	<form class="form-horizontal" action="<?php echo base_url().'index.php/'; ?>accounts/update_transaction_details" id="receipt" method="post" name="receipt" >
		<div class="form-group row">
			<label class="col-sm-2 control-label">Transaction Date :</label>
			<div class="col-sm-2">
				<div class="form-group data-custon-pick " id="data_1">
				    <input type="text" class="form-control bg-soft-gray datepicker1" id='v_date' name='v_date' value="<?php echo date('d-m-Y',strtotime($trans_date));?>" readonly>
				    <input type="hidden" name="voucherid" id="" value="<?php echo $voucher_id;?>" />
			</div>
			</div>
			<label class="col-sm-2 control-label">Narration :</label>
			<div class="col-sm-6">
				<textarea class="form-group" name='narration' cols='40' rows='2' ><?php echo $narration;?></textarea>
			</div>
		</div>
 		<div class="form-group row">
                    <div class="col-md-1"></div>
                     <div class="col-md-10">
                            	<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                               		    <th>Debit Account (Dr)</th> 
										<th>Credit Account (Cr)</th>  
										<th>Invoice Code</th>
										<th>Amount</th> 

                                    </tr>
                                 </thead>
                                    <tbody id="dr_body">
				     <?php foreach($res as $row)
				     {?>
		                            <tr>
		                       		    <td><?php if($row->drcr_type=='Dr') echo $row->account_name;?></td> 
					    	    <td><?php if($row->drcr_type=='Cr') echo $row->account_name;?></td>  
								<td><?php echo $row->invoice_code; ?></td>
					    	    <td>
					    	    	<input type="number" step='any' name="amount[]" id="" value="<?php echo $row->amount;?>" />
					    	    	<input type="hidden" name="voucher_id[]" id="" value="<?php echo $row->voucher_id;?>" />
				    	    	    </td> 

		                            </tr>
				     <?php }?>
                                    </tbody>
                             </table>
                     </div>
                 </div>
                 
                 <input type="submit" value="Update" id="add" name="submit"  class="btn btn-primary m-b-0" tabindex="39"/>
	      </form>

      	</div>
    </div>
</div>
</div>
</div>
</div>

