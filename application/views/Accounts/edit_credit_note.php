<section class="content-header">
	  <h1>
	CREDIT NOTE
	    <small>Edit</small>
	  </h1>     
</section>  

<section class="content">
	<div class="row">
		<div class="col-md-12">		 	 
		<div class="box box-info">			
	<form class="form-horizontal" action="<?php echo base_url().'index.php/'; ?>accounts/update_credit_note" id="credit_note" method="post" name="credit_note" >
	<div class="box-body">			 	 			
		<?php foreach($credit_note_edit as $row):?>
			<div class="form-group">
					<label class="col-sm-2 control-label">Voucher No :</label>
				<div class="col-sm-2">
					<input id="receipt_no" name="receipt_no" type="text" class="form-control col-sm-2 input-sm"  value="<?php echo $row->voucher_code ;?>" readonly />
				</div>
					<label class="col-sm-2 control-label">Date :</label>
				 <div class="col-sm-2">
					<div class="input-group date datepicker1">			                  
	 	    			<input type="text" class="form-control input-sm datepicker1" id="v_date" name="v_date" value="<?php echo  date('d-m-Y',strtotime($row->voucher_date)); ?>"  >
	 				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					</div> 
				</div>
			</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Credit Account :</label>
					<div class="col-sm-2">
						<input type="text" id="occupier_name" name="occupier_name" class="form-control col-sm-2 input-sm" value="<?php echo $row->account_name;?>" readonly />
					</div>
				
				<label class="col-sm-2 control-label">Debit Account :</label>
					<div class="col-sm-2">
						<input type="text" id="occupier_name" name="occupier_name" class="form-control col-sm-2 input-sm" value="<?php echo $row->cracc_name ;?>"  readonly />
					</div>
						<input type="hidden" id="voucher_id" name="voucher_id" value="<?php echo $row->voucher_id;?>" >
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Paid Amount :</label>
					<div class="col-sm-2">
						<input type="text" id="amount" name="amount"class="form-control col-sm-2 input-sm" value="<?php echo $row->amount; ?>" >					
					</div>
					
					<label class="col-sm-2 control-label">Remark :</label>
				<div class="col-sm-2">
					<textarea id="remark" class="form-control col-sm-2 input-sm"  name="remark" ><?php echo $row->narration;?></textarea>
				</div>
				</div>		
				<div class="col-sm-offset-4">
					<input type="submit" id="edit" value="Update" class="btn bg-red" />
				</div>
			</div>
			<?php endforeach ;?>
		</form
	</div>
</div>
</div>
</section>
</div>

<script>
	//Date picker
    $('.datepicker1').datepicker({
    	format:"dd-mm-yyyy",
      	autoclose: true
    });
    
    $('#credit_note').validate({
		rules : {

           v_date : {
				required : true,
			
			},
			
			amount : {
				required : true,
			    number : true,
			},
			
		},

		messages : {

			
			v_date : {
				required : "Please Select Date",
			},
			
			amount : {
				required : "Please Enter Amount",
				
			
			},
			
			
		},

		highlight : function(element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			$(id_attr).removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
		},
		unhighlight : function(element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			$(id_attr).removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
		},
		errorElement : 'span',
		errorClass : 'help-block',
		errorPlacement : function(error, element) {
			if (element.length) {
				error.insertAfter(element);
			} else {
				error.insertAfter(element);
			}
		}
	});
	
</script>