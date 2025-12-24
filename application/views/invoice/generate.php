<!-- <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow"> -->
<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<h2 class="text-2xl font-bold mb-6">Generate Invoice</h2>

	<!-- STEP 1: JOB CARD SELECT -->
	<div class="mb-6">
		<label class="block text-sm font-medium mb-1">Select Job Card</label>
		<select id="jobcard_id"
			class="w-72 border rounded px-3 py-2">
			<option value="">-- Select Job Card --</option>
			<?php foreach ($jobcards as $jc): ?>
				<option value="<?= $jc->jobcard_id ?>">
					JC-<?= $jc->jobcard_id ?> | <?= $jc->registration_no ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>

	<!-- INVOICE FORM -->
	<form method="post" action="<?= base_url('index.php/invoice/save') ?>" id="invoiceForm" class="hidden">

		<input type="hidden" name="jobcard_id" id="jobcard_hidden">

		<!-- CUSTOMER + VEHICLE -->
		<div class="grid grid-cols-2 gap-4 mb-6 text-sm bg-gray-50 p-4 rounded">
			<div>
				<p><b>Customer:</b> <span id="customer_name"></span></p>
				<p><b>Phone:</b> <span id="customer_phone"></span></p>
			</div>
			<div>
				<p><b>Vehicle:</b> <span id="vehicle_no"></span></p>
				<p><b>Job Card:</b> <span id="jobcard_no"></span></p>
			</div>
		</div>

		<!-- SERVICES -->
		<h3 class="font-semibold mb-2">Services</h3>
		<table class="w-full border mb-4 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th class="border p-2">Service</th>
					<th class="border p-2 text-right">Cost</th>
				</tr>
			</thead>
			<tbody id="serviceBody"></tbody>
		</table>

		<!-- PARTS -->
		<h3 class="font-semibold mb-2">Spare Parts</h3>
		<table class="w-full border mb-4 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th class="border p-2">Part</th>
					<th class="border p-2">Qty</th>
					<th class="border p-2 text-right">Total</th>
				</tr>
			</thead>
			<tbody id="partsBody"></tbody>
		</table>

		<!-- TOTALS -->
		<div class="grid grid-cols-2 gap-4 text-sm">
			<div></div>
			<div class="space-y-2">
				<div class="flex justify-between">
					<span>Subtotal</span>
					<span id="subtotal">0.00</span>
				</div>
				<div class="flex justify-between items-center">
					<span>Discount</span>
					<input type="number" id="discount"
						name="discount_amount"
						class="border w-24 px-2 text-right"
						value="0">
				</div>
				<div class="flex justify-between">
					<span>VAT (5%)</span>
					<span id="tax">0.00</span>
				</div>

			

				

				<div class="flex justify-between font-bold text-lg">
					<span>Grand Total</span>
					<span id="grand_total">0.00</span>
				</div>
			</div>
		</div>

		<!-- HIDDEN FIELDS -->
		<input type="hidden" name="subtotal" id="subtotal_input">
		<input type="hidden" name="tax_amount" id="tax_input">
		<input type="hidden" name="grand_total" id="grand_input">

		<button class="mt-6 bg-green-600 text-white px-6 py-2 rounded">
			Save Invoice
		</button>
	</form>
</div>
<script>
	document.getElementById('jobcard_id').addEventListener('change', function() {

		let jobcardId = this.value;
		if (!jobcardId) return;

		fetch(BASE_URL + 'invoice/get_jobcard_details/' + jobcardId)
			.then(res => res.json())
			.then(data => {

				document.getElementById('invoiceForm').classList.remove('hidden');
				document.getElementById('jobcard_hidden').value = jobcardId;

				// CUSTOMER & VEHICLE
				document.getElementById('customer_name').innerText = data.customer_name;
				document.getElementById('customer_phone').innerText = data.customer_phone;
				document.getElementById('vehicle_no').innerText = data.registration_no;
				document.getElementById('jobcard_no').innerText = 'JC-' + jobcardId;

				// SERVICES
				let serviceHTML = '';
				data.services.forEach(s => {
					serviceHTML += `
                    <tr>
                        <td class="border p-2">${s.service_name}</td>
                        <td class="border p-2 text-right service-cost">${s.amount}</td>
                    </tr>`;
				});
				document.getElementById('serviceBody').innerHTML = serviceHTML;

				// PARTS
				let partsHTML = '';
				data.parts.forEach(p => {
					let total = p.qty * p.rate;
					partsHTML += `
                    <tr>
                        <td class="border p-2">${p.part_name}</td>
                        <td class="border p-2">${p.qty}</td>
                        <td class="border p-2 text-right part-cost">${total}</td>
                    </tr>`;
				});
				document.getElementById('partsBody').innerHTML = partsHTML;

				calculateTotals();
			});
	});

	document.getElementById('discount').addEventListener('keyup', calculateTotals);

	function calculateTotals() {
		let subtotal = 0;

		document.querySelectorAll('.service-cost, .part-cost').forEach(el => {
			subtotal += parseFloat(el.innerText);
		});

		let tax = subtotal * 0.05;
		let discount = parseFloat(document.getElementById('discount').value || 0);
		let grand = subtotal + tax - discount;

		document.getElementById('subtotal').innerText = subtotal.toFixed(2);
		document.getElementById('tax').innerText = tax.toFixed(2);
		document.getElementById('grand_total').innerText = grand.toFixed(2);

		document.getElementById('subtotal_input').value = subtotal;
		document.getElementById('tax_input').value = tax;
		document.getElementById('grand_input').value = grand;
	}
</script>
