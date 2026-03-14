<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<!-- STEP 1: JOB CARD SELECT -->
	<div class="bg-white rounded-xl shadow-md p-6 max-w-3xl">
		<h2 class="text-xl font-semibold mb-6 text-gray-800">
			Generate Invoice
		</h2>
		<?php if ($this->session->flashdata('error')): ?>
			<div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
				<?= $this->session->flashdata('error'); ?>
			</div>
		<?php endif; ?>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<!-- Invoice Type -->
			<div>
				<label class="block text-sm font-medium text-gray-600 mb-2">
					Invoice Type
				</label>
				<select name="invoice_type_select" id="invoice_type_select"
					class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
					<option value="" disabled selected>Select Invoice Type</option>
					<option value="PI">Proforma Invoice</option>
					<option value="TI">Tax Invoice</option>
				</select>
			</div>
			<!-- Select Quotation -->
			<div>
				<label class="block text-sm font-medium text-gray-600 mb-2">
					Select Quotation
				</label>
				<select id="jobcard_id"
					class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
					<!-- onchange='get_dc_info()' -->
					<option value="">-- Select Quotation --</option>
					<?php foreach ($jobcards as $jc): ?>
						<option value="<?= $jc->jobcard_id ?>">
							<?= $jc->quotation_no ?> | <?= $jc->jobcard_no ?> | <?= $jc->registration_no ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>


		</div>
	</div>



	<!-- INVOICE FORM -->
	<form method="post" action="<?= base_url('index.php/Invoice/save') ?>" id="invoiceForm" class="hidden">


		<input type="hidden" name="invoice_type" id="invoice_type">

		<input type="hidden" name="jobcard_id" id="jobcard_hidden">
		<input type="hidden" name="quotation_id" id="quotation_hidden">
		<input type="hidden" name="customer_id" id="customer_id">
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
					<th width="5%">
						<input type="checkbox" id="selectAllServices" checked>
					</th>
					<th class="border p-2">Service</th>
					<th width="20%" class="border p-2 text-right">Cost</th>
					<th class="hidden">dis amt</th>
				</tr>
			</thead>
			<tbody id="serviceBody"></tbody>
		</table>

		<!-- PARTS -->
		<h3 class="font-semibold mb-2">Spare Parts</h3>
		<table class="w-full border mb-4 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th width="5%">
						<input type="checkbox" id="selectAllParts" checked>
					</th>
					<th class="border p-2">Part</th>
					<th class="border p-2">Qty</th>
					<th class="border p-2">Unit Price</th>
					<th class="border p-2">Discount Amt</th>
					<th width="20%" class="border p-2 text-right">Total</th>
				</tr>
			</thead>
			<tbody id="partsBody"></tbody>
		</table>

		<!-- PARTS -->
		<h3 class="font-semibold mb-2">Sublet Service</h3>
		<table class="w-full border mb-4 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th width="5%">
						<input type="checkbox" id="selectAllDesc" checked>
					</th>
					<th class="border p-2">Description</th>
					<th width="20%" class="border p-2 text-right">Amount</th>

				</tr>
			</thead>
			<tbody id="descpBody"></tbody>
		</table>
		<!-- Remarks -->







		<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">


			<!-- LEFT : Remarks -->
			<div>
				<label class="block text-sm font-medium mb-1">Remarks</label>
				<textarea name="remarks" rows="4" class="remark-input w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
			</div>

			<!-- RIGHT : Totals -->
			<!-- <div class="space-y-2 text-sm"> -->
			<div class="bg-gray-50 p-4 rounded-lg border">

				<div class="flex justify-between">
					<span>Subtotal</span>
					<span id="subtotal">0.00</span>
				</div>

				<div class="flex justify-between items-center">
					<span>Discount</span>
					<span id="discount"></span>
					<input type="hidden" name="discount_amount" id="discount_amount" readonly>
				</div>
				<div class="flex justify-between items-center">
					<span>Taxable Amount</span>
					<span id="taxamt"
						name="taxamt"></span>
				</div>

				<div class="flex justify-between">
					<span>VAT (5%)</span>
					<span id="tax">0.00</span>
				</div>

				<div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
					<span>Grand Total</span>
					<span id="grand_total">0.00</span>
				</div>
			</div>

		</div>




		<!-- ## Sales Invoice Account Entry -->
		<div id="account_entry" class="hidden">
			<br>
			<hr>
			<hr><br>
			<p class="font-semibold mb-3">Sales Invoice Account Entry :</p>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

				<!-- Debit Table -->
				<div>
					<table class="w-full border border-gray-300 text-sm" id="inv_dr_table">
						<thead class="bg-gray-100">
							<tr>
								<th class="border px-2 py-2 text-left">Debit Customer (Dr)</th>
								<th class="border px-2 py-2 text-left">Debit Amount (AED)</th>
								<th class="border px-2 py-2 text-center w-[10%]">
									<!-- <a id="inv_dr_add_row" title="Add"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-plus"></span>
									</a> -->
								</th>
							</tr>
						</thead>

						<tbody id="inv_dr_body">
							<tr id="inv_dr_addr0">
								<td class="border px-2 py-2">
									<select class="w-full border rounded px-2 py-1 text-sm select2 select2Width debtor-select"
										id="inv_debtor0" name="inv_debtor[]">
										<option value="">Select</option>
										<?php foreach ($sundry_accounts1 as $row) { ?>
											<option value="<?php echo $row->account_id; ?>">
												<?php echo $row->account_name; ?>
											</option>
										<?php } ?>
									</select>
								</td>

								<td class="border px-2 py-2">
									<input type="number" step="0.01" name="inv_dr_amount[]"
										id="inv_dr_amount0"
										class="w-full border rounded px-2 py-1 text-sm debit_sum"
										min="0">
								</td>

								<td class="border px-2 py-2 text-center">
									<a title="Delete" onclick="remove_row_inv_dr(0)"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-trash"></span>
									</a>
								</td>
							</tr>

							<tr id="inv_dr_addr1"></tr>
						</tbody>
					</table>
				</div>

				<!-- Credit Table -->
				<div>
					<table class="w-full border border-gray-300 text-sm" id="inv_cr_table">
						<thead class="bg-gray-100">
							<tr>
								<th class="border px-2 py-2 text-left">Credit Account (Cr)</th>
								<th class="border px-2 py-2 text-left">Credit Amount (AED)</th>
								<th class="border px-2 py-2 text-center w-[10%]">
									<!-- <a id="inv_cr_add_row" title="Add"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-plus"></span>
									</a> -->
								</th>
							</tr>
						</thead>

						<tbody id="inv_cr_body">

							<tr id="inv_cr_addr0">
								<td class="border px-2 py-2">
									<select class="w-full border rounded px-2 py-1 text-sm select2 credit_select"
										id="inv_creditor0" name="inv_creditor[]">
										<option value="">Select</option>
										<?php foreach ($sundry_accounts2 as $row) { ?>
											<option <?php if ($row->account_id == 1125) echo 'selected'; ?>
												value="<?php echo $row->account_id; ?>">
												<?php echo $row->account_name; ?>
											</option>
										<?php } ?>
									</select>
									<label id="set_balanceinv_cr0" class="text-xs text-gray-500">Balance</label>
								</td>

								<td class="border px-2 py-2">
									<input type="number" step="0.01" name="inv_cr_amount[]"
										id="inv_cr_amount0"
										class="w-full border rounded px-2 py-1 text-sm credit_sum"
										min="0">
								</td>

								<td class="border px-2 py-2 text-center">
									<a title="Delete" onclick="remove_row_inv_cr(0)"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-trash"></span>
									</a>
								</td>
							</tr>

							<tr id="inv_cr_addr1">
								<td class="border px-2 py-2">
									<select class="w-full border rounded px-2 py-1 text-sm select3"
										id="inv_creditor1" name="inv_creditor[]">
										<option value="">Select</option>
										<?php foreach ($sundry_accounts3 as $row) { ?>
											<option <?php if ($row->account_id == 228) echo 'selected'; ?>
												value="<?php echo $row->account_id; ?>">
												<?php echo $row->account_name; ?>
											</option>
										<?php } ?>
									</select>
									<label class="text-xs text-gray-500">Balance</label>
								</td>

								<td class="border px-2 py-2">
									<input type="number" step="0.01" name="inv_cr_amount[]"
										id="inv_cr_amount1"
										class="w-full border rounded px-2 py-1 text-sm credit_sum"
										min="0">
								</td>

								<td class="border px-2 py-2 text-center">
									<a title="Delete" onclick="remove_row_inv_cr(1)"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-trash"></span>
									</a>
								</td>
							</tr>

							<tr id="inv_cr_addr2">
								<td class="border px-2 py-2">
									<select class="w-full border rounded px-2 py-1 text-sm select3"
										id="inv_creditor2" name="inv_creditor[]">
										<option value="">Select</option>
										<?php foreach ($sundry_accounts3 as $row) { ?>

											<!-- $row->account_id == 23 -->

											<option <?php if ($row->account_id == 1122) echo 'selected'; ?>
												value="<?php echo $row->account_id; ?>">
												<?php echo $row->account_name; ?>
											</option>
										<?php } ?>
									</select>
									<label class="text-xs text-gray-500">Balance</label>
								</td>

								<td class="border px-2 py-2">
									<input type="number" step="0.01" name="inv_cr_amount[]"
										id="inv_cr_amount2"
										class="w-full border rounded px-2 py-1 text-sm credit_sum1"
										min="0">
								</td>

								<td class="border px-2 py-2 text-center">
									<a title="Delete" onclick="remove_row_inv_cr(2)"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-trash"></span>
									</a>
								</td>
							</tr>

							<tr id="inv_cr_addr3">
								<td class="border px-2 py-2">
									<select class="w-full border rounded px-2 py-1 text-sm select3"
										id="inv_creditor3" name="inv_creditor[]">
										<option value="">Select</option>
										<?php foreach ($sundry_accounts3 as $row) { ?>
											<option value="<?php echo $row->account_id; ?>">
												<?php echo $row->account_name; ?>
											</option>
										<?php } ?>
									</select>
									<label class="text-xs text-gray-500">Balance</label>
								</td>

								<td class="border px-2 py-2">
									<input type="number" step="0.01" name="inv_cr_amount[]"
										id="inv_cr_amount3"
										class="w-full border rounded px-2 py-1 text-sm credit_sum"
										min="0" value="0">
								</td>

								<td class="border px-2 py-2 text-center">
									<a title="Delete" onclick="remove_row_inv_cr(3)"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-trash"></span>
									</a>
								</td>
							</tr>

						</tbody>
					</table>
				</div>

			</div>
		</div>


		<!-- HIDDEN FIELDS -->
		<input type="hidden" name="subtotal" id="subtotal_input">
		<input type="hidden" name="sdiscount" id="sdiscount">
		<input type="hidden" name="taxableamt" id="taxableamt">
		<input type="hidden" name="tax_amount" id="tax_input">
		<input type="hidden" name="grand_total" id="grand_input">

		<button class="mt-6 bg-green-600 text-white px-6 py-2 rounded" id="saveInvoiceBtn">
			Save Invoice
		</button>
	</form>
</div>
<script>
	$(document).ready(function() {
		var i = 1;

		$("#inv_dr_add_row").click(function() {

			$('#inv_dr_addr' + i).html(`
			<td class="border px-2 py-2">
				<select
					class="w-full border rounded px-2 py-1 text-sm select2"
					id="inv_debtor${i}"
					name="receipt_debtor[]"
					required>
					<option value="">Select</option>
					<?php foreach ($sundry_accounts2 as $row) { ?>
						<option value="<?php echo $row->account_id; ?>">
							<?php echo $row->account_name; ?>
						</option>
					<?php } ?>
				</select>
			</td>

			<td class="border px-2 py-2"></td>
			<td class="border px-2 py-2"></td>
		`);

			$('#inv_dr_body tr:last').after(
				'<tr id="inv_dr_addr' + (i + 1) + '"></tr>'
			);

			i++;

			$('.select2').select2({
				width: "220px" // keep this for select2
			});
		});
	});



	document.getElementById('jobcard_id').addEventListener('change', function() {
		loadJobcardDetails(this.value);

	});



	function calculateTotalsold() {

		let subtotal = 0;

		document.querySelectorAll('.service-cost, .part-cost, .desc-cost').forEach(el => {
			subtotal += parseFloat(el.dataset.amount || 0);
		});
		// alert(subtotal);
		let tax = subtotal * 0.05;
		let discount = parseFloat(document.getElementById('discount').value || 0);

		let grand = subtotal + tax - discount;
		if (grand < 0) grand = 0;

		// DISPLAY
		document.getElementById('subtotal').innerText = subtotal.toFixed(2);
		document.getElementById('tax').innerText = tax.toFixed(2);
		document.getElementById('grand_total').innerText = grand.toFixed(2);

		// HIDDEN INPUTS
		document.getElementById('subtotal_input').value = subtotal.toFixed(2);
		document.getElementById('tax_input').value = tax.toFixed(2);
		document.getElementById('grand_input').value = grand.toFixed(2);
	}

	// function calculateTotals() {

	// 	let subtotal = 0;
	// 	let serviceTotal = 0;
	// 	let partsTotal = 0;
	// 	let descTotal = 0;


	// 	/* ========= SERVICES ========= */

	// 	document.querySelectorAll('.service-check:checked').forEach(cb => {

	// 		const amount = parseFloat(
	// 			cb.closest('tr')
	// 			.querySelector('.service-cost')
	// 			?.dataset.amount || 0
	// 		);

	// 		serviceTotal += amount;
	// 		subtotal += amount;
	// 	});

	// 	// update table total
	// 	const serviceEl = document.getElementById('service_total');
	// 	if (serviceEl) serviceEl.innerText = serviceTotal.toFixed(2);



	// 	/* ========= PARTS ========= */

	// 	document.querySelectorAll('.part-check:checked').forEach(cb => {

	// 		const amount = parseFloat(
	// 			cb.closest('tr')
	// 			.querySelector('.part-cost')
	// 			?.dataset.amount || 0
	// 		);

	// 		partsTotal += amount;
	// 		subtotal += amount;
	// 	});

	// 	const partsEl = document.getElementById('parts_total');
	// 	if (partsEl) partsEl.innerText = partsTotal.toFixed(2);



	// 	/* ========= DESCRIPTION ========= */

	// 	document.querySelectorAll('.desc-check:checked').forEach(cb => {

	// 		const amount = parseFloat(
	// 			cb.closest('tr')
	// 			.querySelector('.desc-cost')
	// 			?.dataset.amount || 0
	// 		);

	// 		descTotal += amount;
	// 		subtotal += amount;
	// 	});

	// 	const descEl = document.getElementById('desc_total');
	// 	if (descEl) descEl.innerText = descTotal.toFixed(2);





	// 	/* ========= DISCOUNT ========= */

	// 	let discount = parseFloat(
	// 		document.getElementById('discount')?.innerHTML || 0
	// 	);

	// 	/* ========= GRAND ========= */
	// 	let taxamt = subtotal - discount;

	// 	/* ========= TAX ========= */

	// 	let tax = taxamt * 0.05;

	// 	let grand = taxamt + tax;
	// 	if (grand < 0) grand = 0;



	// 	/* ========= DISPLAY ========= */

	// 	document.getElementById('subtotal').innerText = subtotal.toFixed(2);
	// 	document.getElementById('taxamt').innerText = taxamt.toFixed(2);
	// 	document.getElementById('tax').innerText = tax.toFixed(2);
	// 	document.getElementById('grand_total').innerText = grand.toFixed(2);



	// 	/* ========= HIDDEN INPUTS ========= */

	// 	document.getElementById('subtotal_input').value = subtotal.toFixed(2);

	// 	document.getElementById('sdiscount').value = discount.toFixed(2);
	// 	document.getElementById('taxableamt').value = taxamt.toFixed(2);
	// 	document.getElementById('tax_input').value = tax.toFixed(2);
	// 	document.getElementById('grand_input').value = grand.toFixed(2);
	// }

	function calculateTotals() {

		let subtotal = 0;
		let serviceTotal = 0;
		let partsTotal = 0;
		let descTotal = 0;
		let totalDiscount = 0; // 🔥 IMPORTANT



		/* ========= SERVICES ========= */

		document.querySelectorAll('.service-check:checked').forEach(cb => {

			const row = cb.closest('tr');

			const amount = parseFloat(
				row.querySelector('.service-cost')?.dataset.amount || 0
			);

			const discount = parseFloat(
				row.querySelector('.service-discount')?.dataset.discount || 0
			);

			serviceTotal += amount;
			subtotal += amount;

			totalDiscount += discount; // 🔥 ADD DISCOUNT
		});

		document.getElementById('service_total') &&
			(document.getElementById('service_total').innerText =
				serviceTotal.toFixed(2));



		/* ========= PARTS ========= */

		document.querySelectorAll('.part-check:checked').forEach(cb => {

			const amount = parseFloat(
				cb.closest('tr')
				.querySelector('.part-cost')
				?.dataset.amount || 0
			);

			partsTotal += amount;
			subtotal += amount;
		});

		document.getElementById('parts_total') &&
			(document.getElementById('parts_total').innerText =
				partsTotal.toFixed(2));



		/* ========= DESCRIPTION ========= */

		document.querySelectorAll('.desc-check:checked').forEach(cb => {

			const amount = parseFloat(
				cb.closest('tr')
				.querySelector('.desc-cost')
				?.dataset.amount || 0
			);

			descTotal += amount;
			subtotal += amount;
		});

		document.getElementById('desc_total') &&
			(document.getElementById('desc_total').innerText =
				descTotal.toFixed(2));



		/* ========= TAXABLE ========= */

		let taxable = subtotal - totalDiscount;
		if (taxable < 0) taxable = 0;



		/* ========= TAX ========= */

		let tax = taxable * 0.05;



		/* ========= GRAND ========= */

		let grand = taxable + tax;



		/* ========= DISPLAY ========= */

		document.getElementById('subtotal').innerText = subtotal.toFixed(2);

		document.getElementById('discount').innerText =
			totalDiscount.toFixed(2); // 🔥 span updated

		document.getElementById('discount_amount').value =
			totalDiscount.toFixed(2);
		document.getElementById('taxamt').innerText =
			taxable.toFixed(2);

		document.getElementById('tax').innerText =
			tax.toFixed(2);

		document.getElementById('grand_total').innerText =
			grand.toFixed(2);
		// =====================accounts fileds===================
		document.getElementById("inv_dr_amount0").value = grand.toFixed(2);
		document.getElementById("inv_cr_amount0").value = subtotal.toFixed(2);
		document.getElementById("inv_cr_amount2").value = totalDiscount.toFixed(2);
		document.getElementById("inv_cr_amount1").value = tax.toFixed(2);



		/* ========= HIDDEN INPUTS ========= */

		document.getElementById('subtotal_input').value =
			subtotal.toFixed(2);

		document.getElementById('sdiscount').value =
			totalDiscount.toFixed(2);

		document.getElementById('taxableamt').value =
			taxable.toFixed(2);

		document.getElementById('tax_input').value =
			tax.toFixed(2);

		document.getElementById('grand_input').value =
			grand.toFixed(2);
	}


	$('#invoice_type_select').on('change', function() {
		const type = $(this).val();

		$('#invoice_type').val(type);
		$('#saveInvoiceBtn').text(
			type === 'PI' ? 'Create Proforma Invoice' : 'Create Tax Invoice'
		);

		const jobcardId = $('#jobcard_id').val();
		const quotationId = $('#quotation_hidden').val();


		if (jobcardId) {
			loadJobcardDetails(jobcardId); // ✅ direct call
		}
	});

	function loadJobcardDetails(jobcardId) {
		if (!jobcardId) return;

		const invoiceType = document.getElementById('invoice_type_select').value;
		if (!invoiceType) {
			alert('Please select Invoice Type first');
			document.getElementById('jobcard_id').value = '';
			return;
		}

		// Show / hide account entry
		if (invoiceType === 'TI') {
			document.getElementById('account_entry').style.display = 'block';
		} else {
			document.getElementById('account_entry').style.display = 'none';
		}

		const isProforma = (invoiceType === 'PI');



		fetch(BASE_URL + 'invoice/get_jobcard_details/' + jobcardId)
			.then(res => res.json())
			.then(data => {

				document.getElementById('invoiceForm').classList.remove('hidden');
				document.getElementById('jobcard_hidden').value = jobcardId;
				document.getElementById('quotation_hidden').value = data.quotation_id;
				document.getElementById('customer_id').value = data.customer_id;

				/* CUSTOMER & VEHICLE */
				document.getElementById('customer_name').innerText = data.customer_name || '';
				document.getElementById('customer_phone').innerText = data.customer_phone || '';
				document.getElementById('vehicle_no').innerText = data.registration_no || '';
				document.getElementById('jobcard_no').innerText = data.jobcard_no || '';

				// document.getElementById('discount').innerText = data.sdiscount || '';

				let discount = data.sdiscount || 0;

				document.getElementById('discount').innerText = discount;
				document.getElementById('discount_amount').value = discount;

				/* SERVICES */
				let serviceHTML = '';
				let serviceTotal = 0;
				data.services.forEach(s => {

					let amount = parseFloat(s.total_cost) || 0;
					serviceTotal += amount;
					serviceHTML += `
                <tr>
                   <td class="border p-2 text-center">
						<input type="checkbox"
						  name="services[]"
       						value="${s.service_id}"
							class="service-check"
							checked
							onchange="calculateTotals()">

							<input type="hidden" name="service_ids[]" value="${s.service_id}">
					<input type="hidden" name="service_name[]" value="${s.service_name}">
					<input type="hidden" name="service_price[]" value="${s.total_cost}">
					<input type="hidden" name="service_discount[]" value="${s.discount_amount}">
					</td>

                    <td class="border p-2">${s.service_name}</td>
	
                    <td class="border p-2 text-right service-cost"
                        data-amount="${parseFloat(s.total_cost)}">
                        ${parseFloat(s.total_cost).toFixed(2)}
                    </td>
					 <td class="hidden border p-2 service-discount"
						data-discount="${parseFloat(s.discount_amount) || 0}">
						${parseFloat(s.discount_amount || 0).toFixed(2)}
					</td>
                </tr>`;
				});

				// ✅ TOTAL ROW
				serviceHTML += `
					<tr class="bg-gray-100 font-bold">
						<td colspan="2" class="border p-2 text-right">
							Total Services
						</td>

						<td class="border p-2 text-right" id="service_total">
							${serviceTotal.toFixed(2)}
						</td>
					</tr>`;

				document.getElementById('serviceBody').innerHTML = serviceHTML;



				/* PARTS */
				let partsHTML = '';
				let partsTotal = 0;
				data.parts.forEach(p => {

					let amount = parseFloat(p.total_price) || 0;
					partsTotal += amount;

					partsHTML += `
                <tr>
				 <td class="border p-2 text-center">
					<input type="checkbox"
						name="parts[]"
      					value="${p.part_id}"
						class="part-check"
						checked
						onchange="calculateTotals()">

						 <input type="hidden" name="part_id[]" value="${p.part_id}">
						<input type="hidden" name="part_name[]" value="${p.part_name}">
						<input type="hidden" name="part_qty[]" value="${p.qty}">
						<input type="hidden" name="part_price[]" value="${p.selling_price}">
						<input type="hidden" name="part_total[]" value="${p.total_price}">
						<input type="hidden" name="part_discount[]" value="${p.dis_amount || 0}">
				</td>
                  

                    <td class="border p-2">${p.part_name}</td>
                    <td class="border p-2 text-center">${p.qty}</td>
                    <td class="border p-2 text-center">${p.selling_price}</td>
                    <td class="border p-2 text-center">${p.dis_amount}</td>
                    <td class="border p-2 text-right  part-cost"
                        data-amount="${parseFloat(p.total_price)}">
                        ${parseFloat(p.total_price).toFixed(2)}
                    </td>
                </tr>`;
				});

				// ✅ TOTAL ROW
				partsHTML += `
				<tr class="bg-gray-100 font-bold">
					<td colspan="5" class="border p-2 text-right">
						Total Parts
					</td>

					<td class="border p-2 text-right" id="parts_total">
						${partsTotal.toFixed(2)}
					</td>
				</tr>`;
				document.getElementById('partsBody').innerHTML = partsHTML;

				/* DESCRIPTION */
				let descpHTML = '';
				let descTotal = 0;
				data.descriptions.forEach(d => {
					let amount = parseFloat(d.amount) || 0;
					descTotal += amount;
					descpHTML += `
                	<tr>
                            <td class="border p-2 text-center">
								<input type="checkbox"
								 	name="descs[]"
       								value="${d.id}"
									class="desc-check"
									checked
									onchange="calculateTotals()">

									<input type="hidden" name="desc_id[]" value="${d.id}">
									<input type="hidden" name="desc_name[]" value="${d.description}">
									<input type="hidden" name="desc_amount[]" value="${d.amount}">
							</td>

                    <td class="border p-2">${d.description}</td>
                    <td class="border p-2 text-right desc-cost"
                        data-amount="${parseFloat(d.amount)}">
                        ${parseFloat(d.amount).toFixed(2)}
                    </td>
                </tr>`;
				});

				// ✅ TOTAL ROW
				descpHTML += `
				<tr class="bg-gray-100 font-bold">
					<td colspan="2" class="border p-2 text-right">
						Total Description
					</td>

					<td class="border p-2 text-right" id="desc_total">
						${descTotal.toFixed(2)}
					</td>
				</tr>`;
				document.getElementById('descpBody').innerHTML = descpHTML;

				calculateTotals();

				var qid = document.getElementById('quotation_hidden').value;
				// alert (qid);
				// alert (jobcardId);

				$.ajax({
					async: false, // ✅ boolean
					type: "POST",
					url: BASE_URL + "Ajax/ajax_get_cust_accountId_from_dc",
					data: {
						qid: qid
					},
					dataType: "json", // ✅ IMPORTANT
					success: function(data) {

						console.log("Account AJAX response:", data);

						if (!data || !data.accountId) {
							console.error("Invalid account data", data);
							return;
						}

						// document.getElementById('inv_debtor0').value = data.accountId;
						$('#inv_debtor0').val(data.accountId).trigger('change');
						console.log(document.getElementById('inv_debtor0').value);
						var grand_total = parseFloat(
							document.getElementById("grand_total").innerText || 0
						);

						var sub_total = parseFloat(
							document.getElementById("subtotal").innerText || 0
						);

						var discount_amt = parseFloat(
							document.getElementById("discount_amount").value || 0
						);

						var vat_amt = parseFloat(
							document.getElementById("tax").innerText || 0
						);

						document.getElementById("inv_dr_amount0").value = grand_total.toFixed(2);
						document.getElementById("inv_cr_amount0").value = sub_total.toFixed(2);
						document.getElementById("inv_cr_amount2").value = discount_amt.toFixed(2);
						document.getElementById("inv_cr_amount1").value = vat_amt.toFixed(2);



					},
					error: function(xhr) {
						console.error("Account AJAX error:", xhr.responseText);
					}
				});



			});
	}


	document.addEventListener('change', function(e) {

		if (e.target.classList.contains('service-check')) {

			const row = e.target.closest('tr');

			row.querySelectorAll('input[type="hidden"]')
				.forEach(input => {
					input.disabled = !e.target.checked;
				});
		}
		if (e.target.classList.contains('part-check')) {

			const row = e.target.closest('tr');

			row.querySelectorAll('input[type="hidden"]')
				.forEach(input => {
					input.disabled = !e.target.checked;
				});
		}
		if (e.target.classList.contains('desc-check')) {

			const row = e.target.closest('tr');

			row.querySelectorAll('input[type="hidden"]')
				.forEach(input => {
					input.disabled = !e.target.checked;
				});
		}

	});

	// function loadJobcardDetails(jobcardId) {
	// 	if (!jobcardId) return;

	// 	const invoiceType = document.getElementById('invoice_type_select').value;
	// 	if (!invoiceType) {
	// 		alert('Please select Invoice Type first');
	// 		document.getElementById('jobcard_id').value = '';
	// 		return;
	// 	}

	// 	// Show / hide account entry
	// 	if (invoiceType === 'TI') {
	// 		document.getElementById('account_entry').style.display = 'block';
	// 	} else {
	// 		document.getElementById('account_entry').style.display = 'none';
	// 	}

	// 	const isProforma = (invoiceType === 'PI');

	// 	fetch(BASE_URL + 'invoice/get_jobcard_details/' + jobcardId)
	// 		.then(res => res.json())
	// 		.then(data => {

	// 			document.getElementById('invoiceForm').classList.remove('hidden');
	// 			document.getElementById('jobcard_hidden').value = jobcardId;

	// 			/* CUSTOMER & VEHICLE */
	// 			document.getElementById('customer_name').innerText = data.customer_name || '';
	// 			document.getElementById('customer_phone').innerText = data.customer_phone || '';
	// 			document.getElementById('vehicle_no').innerText = data.registration_no || '';
	// 			document.getElementById('jobcard_no').innerText = data.jobcard_no || '';

	// 			/* SERVICES */
	// 			let serviceHTML = '';
	// 			data.services.forEach(s => {
	// 				serviceHTML += `
	//             <tr>
	//                 ${!isProforma ? `
	//                 <td class="border p-2 text-center">
	//                     <input type="checkbox" class="item-check"
	//                            data-amount="${parseFloat(s.total_cost)}" checked>
	//                 </td>
	// 				` : ''}

	//                 <td class="border p-2">${s.service_name}</td>
	//                 <td class="border p-2 text-right"
	//                     data-amount="${parseFloat(s.total_cost)}">
	//                     ${parseFloat(s.total_cost).toFixed(2)}
	//                 </td>
	//             </tr>`;
	// 			});
	// 			document.getElementById('serviceBody').innerHTML = serviceHTML;

	// 			/* PARTS */
	// 			let partsHTML = '';
	// 			data.parts.forEach(p => {
	// 				partsHTML += `
	//             <tr>
	//                 ${!isProforma ? `
	//                 <td class="border p-2 text-center">
	//                     <input type="checkbox" class="item-check"
	//                            data-amount="${parseFloat(p.total_price)}" checked>
	//                 </td>` : ''}

	//                 <td class="border p-2">${p.part_name}</td>
	//                 <td class="border p-2 text-center">${p.qty}</td>
	//                 <td class="border p-2 text-center">${p.selling_price}</td>
	//                 <td class="border p-2 text-center">${p.dis_amount}</td>
	//                 <td class="border p-2 text-right"
	//                     data-amount="${parseFloat(p.total_price)}">
	//                     ${parseFloat(p.total_price).toFixed(2)}
	//                 </td>
	//             </tr>`;
	// 			});
	// 			document.getElementById('partsBody').innerHTML = partsHTML;

	// 			/* DESCRIPTION */
	// 			let descpHTML = '';
	// 			data.descriptions.forEach(d => {
	// 				descpHTML += `
	//             <tr>
	//                 ${!isProforma ? `
	//                 <td class="border p-2 text-center">
	//                     <input type="checkbox" class="item-check"
	//                            data-amount="${parseFloat(d.amount)}" checked>
	//                 </td>` : ''}

	//                 <td class="border p-2">${d.description}</td>
	//                 <td class="border p-2 text-right"
	//                     data-amount="${parseFloat(d.amount)}">
	//                     ${parseFloat(d.amount).toFixed(2)}
	//                 </td>
	//             </tr>`;
	// 			});
	// 			document.getElementById('descpBody').innerHTML = descpHTML;

	// 			calculateTotals();
	// 		});
	// }


	// function get_dc_info() {

	// 	var selected = $('#qid option:selected');
	// 	// var poNumber = selected.data('ponumber');

	// 	// Put it into the input box
	// 	$('#pocode').val(poNumber);

	// 	var qid = document.getElementById("quotation_hidden").value;
	// 	if (qid != '') {




	// 		$.ajax({
	// 			async: "false",
	// 			type: "POST",
	// 			url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_quotation_info",
	// 			data: {
	// 				qid: qid
	// 			},
	// 			success: function(msg) {
	// 				document.getElementById('item_list_id').innerHTML = msg;
	// 				get_inv_code();

	// 				$.ajax({
	// 					async: "false",
	// 					type: "POST",
	// 					url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_cust_accountId_from_dc",
	// 					data: {
	// 						qid: qid
	// 					},
	// 					success: function(data) {
	// 						data = JSON.parse(data);
	// 						// alert(data.accountId);
	// 						// document.getElementById('inv_debtor0').value = accid;
	// 						document.getElementById('inv_debtor0').value = data.accountId;
	// 						// ==========================================================

	// 						// Populate TRN dropdown
	// 						var trnSelect = document.getElementById("cust_trnno");
	// 						trnSelect.innerHTML = ""; // Clear previous options

	// 						if (Array.isArray(data.trnno)) {
	// 							data.trnno.forEach(function(item) {
	// 								var option = document.createElement("option");
	// 								option.value = item.trn_no || item; // depending on your model return
	// 								option.text = item.trn_no || item;
	// 								trnSelect.appendChild(option);
	// 							});
	// 						} else if (data.trnno) {
	// 							// if only one trnno
	// 							var option = document.createElement("option");
	// 							option.value = data.trnno;
	// 							option.text = data.trnno;
	// 							trnSelect.appendChild(option);
	// 						}

	// 						// =======================================================================

	// 						var grand_total = document.getElementById("grand_total").value;
	// 						var sub_total = document.getElementById("sub_total").value;
	// 						var discount_amt = document.getElementById("discount_amt").value;
	// 						var vat_amt = document.getElementById("vat_amt").value;
	// 						var crate = document.getElementById('crate').value;
	// 						var x = (grand_total * crate).toFixed(2);
	// 						document.getElementById("inv_dr_amount0").value = x;
	// 						document.getElementById("inv_cr_amount0").value = (sub_total * crate).toFixed(2);
	// 						document.getElementById("inv_cr_amount2").value = (discount_amt * crate).toFixed(2);
	// 						document.getElementById("inv_cr_amount1").value = (vat_amt * crate).toFixed(2);
	// 					}
	// 				});
	// 			}
	// 		});


	// 	}
	// }

	$(document).ready(function() {
		$('.debtor-select').select2({
			width: '100%'
		});
		$('.credit_select').select2({
			width: '100%'
		});


	});
</script>
