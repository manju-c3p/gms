 <!-- Basic Form Start -->
<div class="p-6">
	<div class="bg-white rounded-xl shadow p-6">

		<form action="<?php echo base_url().'index.php/'; ?>accounts/update_debit_note"
			  id="debit_note"
			  method="post"
			  name="debit_note"
			  class="space-y-6">

			<?php foreach($debit_note_edit as $row):?>

				<!-- Voucher & Date -->
				<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
					<label class="md:col-span-1 text-sm font-medium">Voucher No</label>
					<div class="md:col-span-2">
						<input id="receipt_no"
							   name="receipt_no"
							   type="text"
							   readonly
							   value="<?php echo $row->voucher_code;?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
					</div>

					<label class="md:col-span-1 text-sm font-medium">Date</label>
					<div class="md:col-span-2">
						<div class="flex items-center border rounded-lg px-2 py-1">
							<i class="fa fa-calendar text-gray-500 mr-2"></i>
							<input type="text"
								   id="v_date"
								   name="v_date"
								   tabindex="1"
								   required
								   value="<?php echo date('d-m-Y',strtotime($row->voucher_date));?>"
								   class="w-full text-sm outline-none">
						</div>
					</div>
				</div>

				<!-- Accounts -->
				<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-center">
					<label class="md:col-span-1 text-sm font-medium">Debit Account</label>
					<div class="md:col-span-2">
						<input type="text"
							   id="occupier_name"
							   name="occupier_name"
							   readonly
							   required
							   value="<?php echo $row->account_name;?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
					</div>

					<label class="md:col-span-1 text-sm font-medium">Credit Account</label>
					<div class="md:col-span-2">
						<input type="text"
							   id="supp_name"
							   name="supp_name"
							   readonly
							   required
							   value="<?php echo $row->cracc_name;?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
					</div>
				</div>

				<!-- Amount & Narration -->
				<div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-start">
					<label class="md:col-span-1 text-sm font-medium">Amount</label>
					<div class="md:col-span-2">
						<input type="text"
							   id="amount"
							   name="amount"
							   readonly
							   value="<?php echo $row->amount;?>"
							   class="w-full border rounded-lg px-3 py-2 text-sm bg-gray-100">
					</div>

					<label class="md:col-span-1 text-sm font-medium">Narration</label>
					<div class="md:col-span-2">
						<textarea id="remark"
								  name="remark"
								  rows="3"
								  class="w-full border rounded-lg px-3 py-2 text-sm"><?php echo $row->narration;?></textarea>
					</div>
				</div>

				<!-- Submit -->
				<div class="flex justify-center gap-4">
					<input type="submit"
						   id="edit"
						   value="Update"
						   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg cursor-pointer">

					<input type="hidden"
						   id="voucher_id"
						   name="voucher_id"
						   value="<?php echo $row->voucher_id;?>">
				</div>

			<?php endforeach ;?>

		</form>

	</div>
</div>


