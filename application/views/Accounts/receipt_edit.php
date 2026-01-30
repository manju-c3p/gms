<?php
$this->load->helper('barcodedetails');
foreach($receipt_records as $row):
	$VoucherDate=$row->voucher_date;
	$account_name=$row->account_name;
	$occupier_id=$row->occupier_id;
	$cracc_name=$row->cracc_name;
	$voucher_id=$row->voucher_id;
	//$cracc_name=$row->cracc_name;
	$narration=$row->narration;
	$amount=$row->amount;
	$cheque_no=$row->cheque_no;
	$cheque_date=$row->cheque_date;
	$cheque_clearing_date=$row->cheque_clearing_date;
	$voucher_code=$row->voucher_code;
	//	$account_name=$row->account_name;
	$users = $row->collected_by;
	$collected_by = $row->collected_by;
	$tds_amount = $row->tds_amount;
	$receipt_type = $row->receipt_type;
	$GSTtds_amt= $row->GSTtds_amt;

	?>

	<section class="content-header">
		<h1>
			RECEIPT FROM OCCUPIER
			<small>Edit </small>
		</h1>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">

					<form class="form-horizontal" action="<?php echo base_url().'index.php/'; ?>accounts/update_pmc_receipt_data" id="receipt" method="post" name="receipt">
						<div class="box-body">

							<div class="form-group">
								<label class="col-sm-2 control-label"> Receipt No :</label>
								<div class="col-sm-2">
									<input id="receipt_no" name="receipt_no" type="text" class="form-control col-sm-2 input-sm"  value="<?php echo $voucher_code;?>" readonly />
								</div>
								<label class="col-sm-2 control-label">Date :</label>

								<div class="col-sm-2">
									<div class="input-group date datepicker1">
										<input type="text" class="form-control input-sm datepicker1" id="receipt_date" name="v_date" value="<?php echo date('d-m-Y',strtotime($VoucherDate)); ?>" required readonly>
										<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Receipt From :</label>
								<div class="col-sm-2">
									<input type="text" id="occupier_name" name="occupier_name" class="form-control col-sm-2 input-sm" value="<?php echo $account_name;?>" readonly required/>
								</div>

								<label class="col-sm-2 control-label"> Amount :</label>
								<div class="col-sm-2">
									<input type="text" id="amount" name="amount" class="form-control col-sm-2 input-sm" value="<?php echo $amount;?>" readonly >
								</div>

							</div>
							<!--<div class="form-group">
								<label class="col-sm-2 control-label">TDS :</label>
								<div class="col-sm-2">
									<input type="text" id="tds" name="tds" class="form-control col-sm-2 input-sm" value="<?php echo $tds_amount;?>" readonly >
								</div>
								<label class="col-sm-2 control-label">GST TDS :</label>
								<div class="col-sm-2">
									<input type="text" id="gst_tds" name="gst_tds" class="form-control col-sm-2 input-sm" value="<?php echo $GSTtds_amt;?>" readonly >
								</div>
							</div>-->
							<div class="form-group">
								<label class="col-sm-2 control-label">By:</label>
								<div class="col-sm-2">
									<!--<select id="payment_mode" onchange="cheque_call()" name="payment_mode" class="form-control col-sm-2 input-sm" readonly>
									<option <?php if($row->receipt_type=='cash') echo "selected";?> value="cash" >Cash</option>
									<option <?php if($row->receipt_type=='cheque') echo "selected";?> value="cheque">Cheque</option>
									<option <?php if($row->receipt_type=='other') echo "selected";?> value="other">Other</option>
								</select>-->
								<input id="payment_mode" name="payment_mode" type="text" class="form-control col-sm-2 input-sm" value="<?php if($receipt_type=='cash') { echo "Cash"; } elseif($receipt_type=='cheque' || $receipt_type=='Cheque' ) { echo "Cheque"; } else { echo "Other"; } ?>" readonly />
							</div>

							<div id="bank_name" <?php if($receipt_type!='cheque' || $receipt_type!='Cheque') ?> >
								<label  class="col-sm-2 control-label">Select Bank Name :</label>
								<div class="col-sm-2">
									<input type="text" id="account_id" name="account_id" class="form-control col-sm-2 input-sm" value="<?php echo $cracc_name ;?>" readonly>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div id="chqno1" <?php if($receipt_type!='cheque' || $receipt_type!='Cheque') {?>style="display: none"  <?php } ?> >
								<label class="col-sm-2 control-label">Cheque Details :</label>
								<div class="col-sm-2">
									<input id="cheque_no" name="cheque_no" type="text" class="form-control col-sm-2 input-sm" value="<?php echo $cheque_no;?>" required readonly />
								</div>
							</div>
							<?php if($receipt_type =='cheque' || $receipt_type =='Cheque') { ?>
							<div id="chqno12">
								<label class="col-sm-2 control-label">Cheque Date :</label>
								<div class="col-sm-2">
									<div class="input-group date datepicker1">
										<input type="text" class="form-control input-sm datepicker1" id="cheque_date" name="cheque_date" value="<?php if($cheque_date!='') echo date('d-m-Y',strtotime($cheque_date));?>" required >
										<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								<label class="col-sm-2 control-label">Cheque Clearing Date :</label>
								<div class="col-sm-2">
									<div class="input-group date datepicker1">
										<input type="text" class="form-control input-sm datepicker1" id="cheque_clearing_date" name="cheque_clearing_date" value="<?php if($cheque_clearing_date=='' || $cheque_clearing_date=='1970-01-01' ||  $cheque_clearing_date== '0000-00-00') echo ''; else echo date('d-m-Y',strtotime($cheque_clearing_date));?>"  >
										<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
							</div>
						<?php } ?>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Payment Collected By :</label>
							<div class="col-sm-2">
								<select name="users" id="users" class="form-control col-sm-2 input-sm" tabindex="12" required>
									<option value="">Select</option>
									<?php foreach($user_records as $row): ?>
										<!-- <option <?php if($users==($row->FirstName.' '.$row->LastName)) echo 'selected' ;?> value="<?php echo $row->FirstName.' '.$row->LastName; ?>"><?php echo $row->FirstName.' '.$row->LastName; ?></option> -->
										<option <?php if($collected_by==$row->user_name || $collected_by==($row->FirstName.' '.$row->LastName)) echo "selected"; ?> value="<?php echo $row->FirstName.' '.$row->LastName; ?>"><?php echo $row->FirstName.' '.$row->LastName; ?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>


						<div class="form-group">
							<label class="col-sm-2 control-label">Remark :</label>
							<div class="col-sm-6">
								<textarea id="remark" class="form-control col-sm-2 input-sm" name="remark" rows="3" ><?php echo $narration;?></textarea>
							</div>
						</div>
						<input type="hidden" name="voucher_id" value="<?php echo $voucher_id; ?> " />
						<input type="hidden" name="division_id" value="<?php echo $division_id; ?> " />
						<input type="hidden" name="from" value="<?php echo $from; ?> " />
						<input type="hidden" name="to" value="<?php echo $to; ?> " />
						<div class="col-sm-offset-4">
							<input type="submit"  id="edit" class="btn bg-red" value="Update" />

						</div>
					</div>
				</form>
			<?php endforeach ; ?>
		</div>
	</div>
</div>
</section>
<script language="javascript">

function cheque_call()
{
	var check=$('#payment_mode').val();
	// alert(check);
	if(check=="cheque")
	{

		document.getElementById('chqno1').style.display="block";
		document.getElementById('chqno12').style.display="block";
	}
	else
	{
		document.getElementById('chqno1').style.display="none";
		document.getElementById('chqno12').style.display="none";

	}
}
</script>

<script>
//Date picker
$('.datepicker1').datepicker({
	format:"dd-mm-yyyy",
	autoclose: true
});

$('#receipt').validate({
	rules : {

		receipt_date : {
			required : true,
		},

		ledger_id : {
			required : true,

		},

		amount : {
			required : true,

		},

	},

	messages : {

		receipt_date : {
			required : "Please Select Date ",
		},

		ledger_id : {
			required : "Please Select Ledger Account",
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

<script type="text/javascript">

function print_receipt()
{
	var a=$('#receipt_no').val();
	var b=$('#occupier').val();
	var c=$('#receipt_date').val();
	var d=$('#receipt_date').val();
	var e=$('input[name=payment_mode]:checked').val();
	var f=$('#remark').val();
	var g=$('#amount').val();

	$.ajax({
		type:"POST",
		url:"<?php echo base_url()?>index.php/accounts/print_pespl_receipt",
		data:{receipt_no:a,selected_date:b,occupier_display_name:c,occupier_address:d,payment_mode:e,amount:f,amount:g},
		success:function(data)
		{
			alert("Data Save Successfully "+data);
		}
	});

}

function delete_area(id) {
	var x;
	var a=$('#receipt_date').val();
	var b=$('#remark').val();
	var c=$('#amount').val();
	var d=$('#page_name').val();
	var f=$('#occupier_id').val();
	var g=$('#joint_receipt_code').val();

	if(f == 0)
	{
		alert("Please Select Occupier");
		return;
	}
	var r=confirm("Are you sure you want to cancel record?!");
	if (r==true)
	{


		$.ajax({
			url: "<?php echo base_url()?>index.php/accounts/cancel_receipt",
			type: "POST",
			dataType: "json",
			data: {cancel_id:id,receipt_date:a,remark:b,amount:c,page_name:d,occupier_id:f,joint_receipt_code:g} ,
			success: function(data) {

				var item=data[0];
				if(item='TRUE')
				alert("The record is Cancel!");
				window.location.href="<?php echo base_url()?>index.php/accounts/receipt_pmc_occupier"
			}
		});

	}
	else
	{
		x="You pressed Cancel!";
	}
};


</script>
