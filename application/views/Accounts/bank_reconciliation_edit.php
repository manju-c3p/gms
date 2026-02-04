<div class="bg-white rounded-xl shadow p-6">
	<form action="<?php echo base_url() . 'index.php/Accounts/update_bank_reconciliation'; ?>"
		  id="receipt"
		  method="post"
		  name="receipt"
		  class="space-y-6">

		<?php foreach ($records as $row) : ?>

			<!-- Instrument Number -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
				<label class="md:col-span-2 text-sm font-medium">
					Instrument Number
				</label>
				<div class="md:col-span-3">
					<input type="text"
						   id="instrument_no"
						   name="instrument_no"
						   value="<?php echo $row->instrument_no; ?>"
						   tabindex="1"
						   class="w-full border rounded-lg px-3 py-2 text-sm">
				</div>
			</div>

			<!-- Instrument Date -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
				<label class="md:col-span-2 text-sm font-medium">
					Instrument Date
				</label>
				<div class="md:col-span-3">
					<div class="flex items-center border rounded-lg px-2 py-1">
						<input type="text"
							   id="date"
							   name="date"
							   value="<?php echo date('d-m-Y'); ?>"
							   tabindex="2"
							   class="w-full text-sm outline-none datepicker1">
						<i class="fa fa-calendar text-gray-500"></i>
					</div>
				</div>
			</div>

			<!-- Amount -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
				<label class="md:col-span-2 text-sm font-medium">
					Amount Number
				</label>
				<div class="md:col-span-3">
					<input type="number"
						   id="amount_no"
						   name="amount_no"
						   min="0"
						   value="<?php echo $row->amount_no; ?>"
						   tabindex="3"
						   class="w-full border rounded-lg px-3 py-2 text-sm">
				</div>
			</div>

			<!-- Type -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
				<label class="md:col-span-2 text-sm font-medium">
					Type
				</label>
				<div class="md:col-span-3">
					<select id="instrument_type"
							name="instrument_type"
							tabindex="4"
							class="w-full border rounded-lg px-3 py-2 text-sm select2">
						<option value="">Please select Type</option>
						<option <?php if ($row->instrument_type == 'Dr/Cr') echo 'selected'; ?> value="Dr/Cr">Dr/Cr</option>
						<option <?php if ($row->instrument_type == 'Distribution') echo 'selected'; ?> value="Distribution">Distribution</option>
					</select>
				</div>
			</div>

			<!-- Remark -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4">
				<label class="md:col-span-2 text-sm font-medium">
					Remark
				</label>
				<div class="md:col-span-4">
					<textarea id="remark"
							  name="remark"
							  rows="2"
							  tabindex="5"
							  placeholder="remark"
							  class="w-full border rounded-lg px-3 py-2 text-sm"><?php echo ($row->remark); ?></textarea>
				</div>
			</div>

		<?php endforeach; ?>

		<!-- Submit -->
		<div class="flex items-center gap-4">
			<input type="hidden"
				   name="reconciliation_id"
				   value="<?php echo $row->reconciliation_id; ?>">

			<button type="submit"
					id="add"
					tabindex="6"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
				Update
			</button>
		</div>

	</form>
</div>








































</div>
