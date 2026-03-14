<?php
$this->load->helper('barcodedetails');
foreach ($receipt_records as $row):
	$VoucherDate = $row->voucher_date;
	$account_name = $row->account_name;
	$occupier_id = $row->occupier_id;
	$cracc_name = $row->cracc_name;
	$voucher_id = $row->voucher_id;
	//$cracc_name=$row->cracc_name;
	$narration = $row->narration;
	$amount = $row->amount;
	$cheque_no = $row->cheque_no;
	$cheque_date = $row->cheque_date;
	$cheque_clearing_date = $row->cheque_clearing_date;
	$voucher_code = $row->voucher_code;
	//	$account_name=$row->account_name;
	$users = $row->collected_by;
	$collected_by = $row->collected_by;
	$tds_amount = $row->tds_amount;
	$receipt_type = $row->receipt_type;
	$GSTtds_amt = $row->GSTtds_amt;

?>

<section class="mb-6">
	<h1 class="text-xl font-semibold">
		RECEIPT FROM OCCUPIER
		<span class="text-sm text-gray-500 ml-2">Edit</span>
	</h1>
</section>

<section>
	<div class="bg-white rounded-xl shadow p-6">

		<form action="<?php echo base_url() . 'index.php/'; ?>accounts/update_pmc_receipt_data"
			  id="receipt"
			  method="post"
			  name="receipt"
			  class="space-y-6">

			<!-- Receipt No & Date -->
			<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
				<label class="md:col-span-1 text-sm font-medium">Receipt No</label>
				<div class="md:col-span-2">
					<input id="receipt_no"
						   name="receipt_no"
						   type="text"
						   readonly
						   value="<?php echo $voucher_code; ?>"
						   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
				</div>

				<label class="md:col-span-1 text-sm font-medium">Date</label>
				<div class="md:col-span-2">
					<div class="flex items-center border rounded-lg px-2 py-1">
						<input type="text"
							   id="receipt_date"
							   name="v_date"
							   readonly
							   required
							   value="<?php echo date('d-m-Y', strtotime($VoucherDate)); ?>"
							   class="w-full text-sm outline-none datepicker1">
						<i class="fa fa-calendar text-gray-500"></i>
					</div>
				</div>
			</div>

			<!-- Receipt From & Amount -->
			<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
				<label class="md:col-span-1 text-sm font-medium">Receipt From</label>
				<div class="md:col-span-2">
					<input type="text"
						   id="occupier_name"
						   name="occupier_name"
						   readonly
						   required
						   value="<?php echo $account_name; ?>"
						   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
				</div>

				<label class="md:col-span-1 text-sm font-medium">Amount</label>
				<div class="md:col-span-2">
					<input type="text"
						   id="amount"
						   name="amount"
						   readonly
						   value="<?php echo $amount; ?>"
						   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
				</div>
			</div>

			<!-- Payment Mode & Bank -->
			<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
				<label class="md:col-span-1 text-sm font-medium">By</label>
				<div class="md:col-span-2">
					<input id="payment_mode"
						   name="payment_mode"
						   type="text"
						   readonly
						   value="<?php
								if ($receipt_type == 'cash') {
									echo 'Cash';
								} elseif ($receipt_type == 'cheque' || $receipt_type == 'Cheque') {
									echo 'Cheque';
								} elseif ($receipt_type == 'Cash' || $receipt_type == 'cash') {
									echo 'Cash';
								} else {
									echo 'Other';
								}
						   ?>"
						   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
				</div>

				<div id="bank_name" class="md:col-span-3">
					<label class="block text-sm font-medium mb-1">Select Bank Name</label>
					<input type="text"
						   id="account_id"
						   name="account_id"
						   readonly
						   value="<?php echo $cracc_name; ?>"
						   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
				</div>
			</div>

			<!-- Cheque Details -->
			<div class="space-y-4">
				<div id="chqno1" <?php if ($receipt_type != 'cheque' && $receipt_type != 'Cheque') { ?>style="display:none"<?php } ?>>
					<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
						<label class="md:col-span-1 text-sm font-medium">Cheque Details</label>
						<div class="md:col-span-2">
							<input id="cheque_no"
								   name="cheque_no"
								   readonly
								   required
								   value="<?php echo $cheque_no; ?>"
								   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
						</div>
					</div>
				</div>

				<?php if ($receipt_type == 'cheque' || $receipt_type == 'Cheque') { ?>
					<div id="chqno12" class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
						<label class="md:col-span-1 text-sm font-medium">Cheque Date</label>
						<div class="md:col-span-2">
							<div class="flex items-center border rounded-lg px-2 py-1">
								<input type="text"
									   id="cheque_date"
									   name="cheque_date"
									   value="<?php if ($cheque_date != '') echo date('d-m-Y', strtotime($cheque_date)); ?>"
									   class="w-full text-sm outline-none datepicker1">
								<i class="fa fa-calendar text-gray-500"></i>
							</div>
						</div>

						<label class="md:col-span-1 text-sm font-medium">Clearing Date</label>
						<div class="md:col-span-2">
							<div class="flex items-center border rounded-lg px-2 py-1">
								<input type="text"
									   id="cheque_clearing_date"
									   name="cheque_clearing_date"
									   value="<?php
											if ($cheque_clearing_date == '' || $cheque_clearing_date == '1970-01-01' || $cheque_clearing_date == '0000-00-00')
												echo '';
											else
												echo date('d-m-Y', strtotime($cheque_clearing_date));
									   ?>"
									   class="w-full text-sm outline-none datepicker1">
								<i class="fa fa-calendar text-gray-500"></i>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<!-- Collected By -->
			<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
				<label class="md:col-span-1 text-sm font-medium">Payment Collected By</label>
				<div class="md:col-span-2">
					<select id="users"
							name="users"
							required
							tabindex="12"
							class="w-full border rounded-lg px-3 py-2 text-sm">
						<option value="">Select</option>
						<?php foreach ($user_records as $row): ?>
							<option <?php if ($collected_by == $row->user_name || $collected_by == ($row->FirstName . ' ' . $row->LastName)) echo 'selected'; ?>
								value="<?php echo $row->FirstName . ' ' . $row->LastName; ?>">
								<?php echo $row->FirstName . ' ' . $row->LastName; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<!-- Remark -->
			<div class="grid grid-cols-1 md:grid-cols-6 gap-4">
				<label class="md:col-span-1 text-sm font-medium">Remark</label>
				<div class="md:col-span-4">
					<textarea id="remark"
							  name="remark"
							  rows="3"
							  class="w-full border rounded-lg px-3 py-2 text-sm"><?php echo $narration; ?></textarea>
				</div>
			</div>

			<!-- Hidden -->
			<input type="hidden" name="voucher_id" value="<?php echo $voucher_id; ?>">
			<input type="hidden" name="division_id" value="<?php echo $division_id; ?>">
			<input type="hidden" name="from" value="<?php echo $from; ?>">
			<input type="hidden" name="to" value="<?php echo $to; ?>">

			<!-- Submit -->
			<div class="flex justify-center">
				<input type="submit"
					   id="edit"
					   value="Update"
					   class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg cursor-pointer">
			</div>

		</form>

	</div>
</section>

	<script language="javascript">
		function cheque_call() {
			var check = $('#payment_mode').val();
			// alert(check);
			if (check == "cheque") {

				document.getElementById('chqno1').style.display = "block";
				document.getElementById('chqno12').style.display = "block";
			} else {
				document.getElementById('chqno1').style.display = "none";
				document.getElementById('chqno12').style.display = "none";

			}
		}
	</script>

	<script>
		//Date picker
		$('.datepicker1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true
		});

		$('#receipt').validate({
			rules: {

				receipt_date: {
					required: true,
				},

				ledger_id: {
					required: true,

				},

				amount: {
					required: true,

				},

			},

			messages: {

				receipt_date: {
					required: "Please Select Date ",
				},

				ledger_id: {
					required: "Please Select Ledger Account",
				},

				amount: {
					required: "Please Enter Amount",
				},
			},

			highlight: function(element) {
				var id_attr = "#" + $(element).attr("id") + "1";
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				$(id_attr).removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
			},
			unhighlight: function(element) {
				var id_attr = "#" + $(element).attr("id") + "1";
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
				$(id_attr).removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
			},
			errorElement: 'span',
			errorClass: 'help-block',
			errorPlacement: function(error, element) {
				if (element.length) {
					error.insertAfter(element);
				} else {
					error.insertAfter(element);
				}
			}
		});
	</script>

	<script type="text/javascript">
		function print_receipt() {
			var a = $('#receipt_no').val();
			var b = $('#occupier').val();
			var c = $('#receipt_date').val();
			var d = $('#receipt_date').val();
			var e = $('input[name=payment_mode]:checked').val();
			var f = $('#remark').val();
			var g = $('#amount').val();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url() ?>index.php/accounts/print_pespl_receipt",
				data: {
					receipt_no: a,
					selected_date: b,
					occupier_display_name: c,
					occupier_address: d,
					payment_mode: e,
					amount: f,
					amount: g
				},
				success: function(data) {
					alert("Data Save Successfully " + data);
				}
			});

		}

		function delete_area(id) {
			var x;
			var a = $('#receipt_date').val();
			var b = $('#remark').val();
			var c = $('#amount').val();
			var d = $('#page_name').val();
			var f = $('#occupier_id').val();
			var g = $('#joint_receipt_code').val();

			if (f == 0) {
				alert("Please Select Occupier");
				return;
			}
			var r = confirm("Are you sure you want to cancel record?!");
			if (r == true) {


				$.ajax({
					url: "<?php echo base_url() ?>index.php/accounts/cancel_receipt",
					type: "POST",
					dataType: "json",
					data: {
						cancel_id: id,
						receipt_date: a,
						remark: b,
						amount: c,
						page_name: d,
						occupier_id: f,
						joint_receipt_code: g
					},
					success: function(data) {

						var item = data[0];
						if (item = 'TRUE')
							alert("The record is Cancel!");
						window.location.href = "<?php echo base_url() ?>index.php/accounts/receipt_pmc_occupier"
					}
				});

			} else {
				x = "You pressed Cancel!";
			}
		};
	</script>
