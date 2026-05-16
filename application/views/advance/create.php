<div class="w-full px-6 mt-6">
	<div class="bg-white shadow-md rounded-2xl p-6">

		<h2 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-2">
			Advance Receipt
		</h2>

		<form method="post" action="<?= base_url('index.php/Advance/store') ?>">

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
				<!-- Receipt Date -->
				<div>
					<label class="block text-sm text-gray-600 mb-1">Receipt Date</label>
					<input type="date" name="date"
						value="<?= date('Y-m-d') ?>"
						class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
						required>
				</div>

				<!-- Jobcard -->
				<div>
					<label class="block text-sm text-gray-600 mb-1">Jobcard</label>
					<select name="jobcard_id" id="jobcard_id" class="w-full border rounded-lg px-3 py-2">
						<option value="">-- Select Quotation --</option>
						<?php foreach ($jobcards as $jc): ?>
							<option value="<?= $jc->jobcard_id ?>"
								data-quotation="<?= $jc->quotation_id ?>"
								data-customer="<?= $jc->customer_id ?>">
								
								<?= $jc->quotation_no ?> | <?= $jc->jobcard_no ?> | <?= $jc->registration_no ?>
							</option>
						<?php endforeach; ?>
					</select>

					<input type="hidden" name="quotation_id" id="quotation_id">
					<input type="hidden" name="customer_id" id="customer_id">
				</div>

			
				

				<!-- Amount -->
				<div>
					<label class="block text-sm text-gray-600 mb-1">Amount</label>
					<input type="number" name="amount"
						class="w-full border rounded-lg px-3 py-2"
						placeholder="Enter amount">
				</div>

				<!-- Payment -->
				<div>
					<label class="block text-sm text-gray-600 mb-1">Payment Mode</label>
					<select name="payment_mode" class="w-full border rounded-lg px-3 py-2">
						<option>Cash</option>
						<option>Bank</option>
						<option>UPI</option>
					</select>
				</div>

				<!-- Reference (full width row) -->
				<div class="lg:col-span-2">
					<label class="block text-sm text-gray-600 mb-1">Reference No</label>
					<input type="text" name="reference_no"
						class="w-full border rounded-lg px-3 py-2">
				</div>

				<!-- Notes full row -->
				<div class="lg:col-span-3">
					<label class="block text-sm text-gray-600 mb-1">Notes</label>
					<textarea name="notes"
						class="w-full border rounded-lg px-3 py-2"></textarea>
				</div>

			</div>

			<!-- Button right aligned -->
			<div class="mt-6 flex justify-end">
				<button class="bg-blue-600 text-white px-6 py-2 rounded-lg">
					Save Advance
				</button>
			</div>

		</form>

	</div>


	

</div>


<script>
	document.querySelectorAll('input[type=\"number\"]').forEach(function(input) {
		input.addEventListener('input', function() {
			let max = parseFloat(this.max);
			let val = parseFloat(this.value);

			if (val > max) {
				this.value = max;
			}
		});
	});

	
</script>
<script>
document.getElementById('jobcard_id').addEventListener('change', function() {
    let selected = this.options[this.selectedIndex];

    let quotation_id = selected.getAttribute('data-quotation');
    let customer_id = selected.getAttribute('data-customer');

    document.getElementById('quotation_id').value = quotation_id || '';
    document.getElementById('customer_id').value = customer_id || '';
});
</script>
