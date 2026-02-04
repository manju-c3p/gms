<section class="mb-6">
	<h1 class="text-xl font-semibold">
		CREDIT NOTE
		<span class="text-sm text-gray-500 ml-2">Edit</span>
	</h1>
</section>

<section>
	<div class="bg-white rounded-xl shadow p-6">
		<form action="<?php echo base_url() . 'index.php/'; ?>accounts/update_credit_note"
			  id="credit_note"
			  method="post"
			  name="credit_note"
			  class="space-y-6">

			<?php foreach ($credit_note_edit as $row): ?>

				<!-- Voucher & Date -->
				<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
					<label class="md:col-span-1 text-sm font-medium">Voucher No</label>
					<div class="md:col-span-2">
						<input id="receipt_no"
							   name="receipt_no"
							   type="text"
							   readonly
							   value="<?php echo $row->voucher_code; ?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
					</div>

					<label class="md:col-span-1 text-sm font-medium">Date</label>
					<div class="md:col-span-2">
						<div class="flex items-center border rounded-lg px-2 py-1">
							<input type="text"
								   id="v_date"
								   name="v_date"
								   value="<?php echo date('d-m-Y', strtotime($row->voucher_date)); ?>"
								   class="w-full text-sm outline-none datepicker1">
							<i class="fa fa-calendar text-gray-500"></i>
						</div>
					</div>
				</div>

				<!-- Accounts -->
				<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
					<label class="md:col-span-1 text-sm font-medium">Credit Account</label>
					<div class="md:col-span-2">
						<input type="text"
							   id="occupier_name"
							   name="occupier_name"
							   readonly
							   value="<?php echo $row->account_name; ?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
					</div>

					<label class="md:col-span-1 text-sm font-medium">Debit Account</label>
					<div class="md:col-span-2">
						<input type="text"
							   id="occupier_name"
							   name="occupier_name"
							   readonly
							   value="<?php echo $row->cracc_name; ?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
					</div>

					<input type="hidden"
						   id="voucher_id"
						   name="voucher_id"
						   value="<?php echo $row->voucher_id; ?>">
				</div>

				<!-- Amount & Remark -->
				<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-start">
					<label class="md:col-span-1 text-sm font-medium">Paid Amount</label>
					<div class="md:col-span-2">
						<input type="text"
							   id="amount"
							   name="amount"
							   value="<?php echo $row->amount; ?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm">
					</div>

					<label class="md:col-span-1 text-sm font-medium">Remark</label>
					<div class="md:col-span-2">
						<textarea id="remark"
								  name="remark"
								  class="w-full border rounded-lg px-3 py-2 text-sm"><?php echo $row->narration; ?></textarea>
					</div>
				</div>

				<!-- Submit -->
				<div class="flex justify-center">
					<input type="submit"
						   id="edit"
						   value="Update"
						   class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg cursor-pointer">
				</div>

			<?php endforeach; ?>

		</form>
	</div>
</section>



<script>
	//Date picker
	$('.datepicker1').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true
	});

	$('#credit_note').validate({
		rules: {

			v_date: {
				required: true,

			},

			amount: {
				required: true,
				number: true,
			},

		},

		messages: {


			v_date: {
				required: "Please Select Date",
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
