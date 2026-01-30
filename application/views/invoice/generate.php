<!-- <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow"> -->
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

		<input type="text" name="jobcard_id" id="jobcard_hidden">
		<input type="text" name="quotation_id" id="quotation_hidden">
		<input type="text" name="customer_id" id="customer_id">
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
					<th class="border p-2">Unit Price</th>
					<th class="border p-2">Discount Amt</th>
					<th class="border p-2 text-right">Total</th>
				</tr>
			</thead>
			<tbody id="partsBody"></tbody>
		</table>

		<!-- PARTS -->
		<h3 class="font-semibold mb-2">Sublet Service</h3>
		<table class="w-full border mb-4 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th class="border p-2">Description</th>
					<th class="border p-2 text-right">Amount</th>

				</tr>
			</thead>
			<tbody id="descpBody"></tbody>
		</table>
		<!-- Remarks -->
		<h3 class="font-semibold mb-2">Remarks</h3>

		<textarea name="remarks" class="remark-input"></textarea>

		<style>
			.remark-input {
				width: 100%;
				height: 80px;
				border: 1px solid #000;
				padding: 6px;
				font-family: Arial, sans-serif;
				font-size: 12px;
			}

			/* On print, remove textarea look */
			@media print {
				.remark-input {
					border: none;
					resize: none;
					outline: none;
				}
			}
		</style>



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




		<!-- ## Sales Invoice Account Entry -->
		<div id="account_entry" class="hidden">
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
									<a id="inv_dr_add_row" title="Add"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-plus"></span>
									</a>
								</th>
							</tr>
						</thead>

						<tbody id="inv_dr_body">
							<tr id="inv_dr_addr0">
								<td class="border px-2 py-2">
									<select class="w-full border rounded px-2 py-1 text-sm select3 select2Width"
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
									<a id="inv_cr_add_row" title="Add"
										class="inline-flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded cursor-pointer">
										<span class="fa fa-plus"></span>
									</a>
								</th>
							</tr>
						</thead>

						<tbody id="inv_cr_body">

							<tr id="inv_cr_addr0">
								<td class="border px-2 py-2">
									<select class="w-full border rounded px-2 py-1 text-sm select3"
										id="inv_creditor0" name="inv_creditor[]">
										<option value="">Select</option>
										<?php foreach ($sundry_accounts2 as $row) { ?>
											<option <?php if ($row->account_id == 27) echo 'selected'; ?>
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
											<option <?php if ($row->account_id == 24) echo 'selected'; ?>
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
											<option <?php if ($row->account_id == 23) echo 'selected'; ?>
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
		<input type="hidden" name="tax_amount" id="tax_input">
		<input type="hidden" name="grand_total" id="grand_input">

		<button class="mt-6 bg-green-600 text-white px-6 py-2 rounded" id="saveInvoiceBtn">
			Save Invoice
		</button>
	</form>
</div>
<script>
	// document.getElementById('jobcard_id').addEventListener('change', function() {

	// 	let jobcardId = this.value;
	// 	if (!jobcardId) return;
	// 	const invoiceType = $('#invoice_type').val();

	// 	fetch(BASE_URL + 'invoice/get_jobcard_details/' + jobcardId)
	// 		.then(res => res.json())
	// 		.then(data => {

	// 			// Show form
	// 			document.getElementById('invoiceForm').classList.remove('hidden');
	// 			document.getElementById('jobcard_hidden').value = jobcardId;

	// 			// CUSTOMER & VEHICLE
	// 			document.getElementById('customer_name').innerText = data.customer_name || '';
	// 			document.getElementById('customer_phone').innerText = data.customer_phone || '';
	// 			document.getElementById('vehicle_no').innerText = data.registration_no || '';
	// 			document.getElementById('jobcard_no').innerText = data.jobcard_no || '';

	// 			/* =========================
	// 			   SERVICES
	// 			========================= */
	// 			let serviceHTML = '';
	// 			data.services.forEach(s => {
	// 				serviceHTML += `
	//                 <tr>
	//                     <td class="border p-2">${s.service_name}</td>
	//                     <td class="border p-2 text-right service-cost"
	//                         data-amount="${parseFloat(s.total_cost)}">
	//                         ${parseFloat(s.total_cost).toFixed(2)}
	//                     </td>
	//                 </tr>`;
	// 			});
	// 			document.getElementById('serviceBody').innerHTML = serviceHTML;

	// 			/* =========================
	// 			   PARTS
	// 			========================= */
	// 			let partsHTML = '';
	// 			data.parts.forEach(p => {
	// 				partsHTML += `
	//                 <tr>
	//                     <td class="border p-2">${p.part_name}</td>
	//                     <td class="border p-2 text-center">${p.qty}</td>
	// 					<td class="border p-2 text-center">${p.selling_price}</td>
	// 					<td class="border p-2 text-center">${p.dis_amount}</td>
	//                     <td class="border p-2 text-right part-cost"
	//                         data-amount="${parseFloat(p.total_price)}">
	//                         ${parseFloat(p.total_price).toFixed(2)}
	//                     </td>
	//                 </tr>`;
	// 			});
	// 			document.getElementById('partsBody').innerHTML = partsHTML;

	// 			/* =========================
	//            description
	//         ========================= */
	// 			let descpHTML = '';
	// 			data.descriptions.forEach(d => {
	// 				descpHTML += `
	//                 <tr>
	//                     <td class="border p-2">${d.description}</td>

	//                     <td class="border p-2 text-right desc-cost"
	//                         data-amount="${parseFloat(d.amount)}">
	//                         ${parseFloat(d.amount).toFixed(2)}
	//                     </td>
	//                 </tr>`;
	// 			});
	// 			document.getElementById('descpBody').innerHTML = descpHTML;

	// 			calculateTotals();
	// 		});
	// });
	$(document).ready(function() {
		var i = 1;

		$("#inv_dr_add_row").click(function() {

			$('#inv_dr_addr' + i).html(`
			<td class="border px-2 py-2">
				<select
					class="w-full border rounded px-2 py-1 text-sm select2"
					id="inv_debtor${i}"
					name="receipt_debtor[]"
					required
				>
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
		// calculateTotals()
	});



	/* =========================
	   TOTAL CALCULATION
	========================= */
	// function calculateTotals() {

	// 	let subtotal = 0;
	// 	const checks = document.querySelectorAll('.item-check');

	// 	// TAX invoice (checkbox based)
	// 	if (checks.length > 0) {
	// 		checks.forEach(chk => {
	// 			if (chk.checked) {
	// 				subtotal += parseFloat(chk.dataset.amount);
	// 			}
	// 		});
	// 	}
	// 	// PROFORMA (no checkboxes → full amount)
	// 	else {
	// 		document.querySelectorAll('[data-amount]').forEach(el => {
	// 			subtotal += parseFloat(el.dataset.amount);
	// 		});
	// 	}

	// 	document.getElementById('subtotal').innerText = subtotal.toFixed(2);

	// 	// VAT & discount calculation (if you already have it)
	// 	let discount = parseFloat(document.getElementById('discount')?.value || 0);
	// 	let vat = subtotal * 0.05;
	// 	let grand = subtotal + vat - discount;

	// 	document.getElementById('tax_amount').innerText = vat.toFixed(2);
	// 	document.getElementById('grand_total').innerText = grand.toFixed(2);
	// }


	/* =========================
	   RECALCULATE ON CHANGE
	========================= */
	// document.addEventListener('change', function(e) {
	// 	if (e.target.classList.contains('item-check') ||
	// 		e.target.id === 'discount') {
	// 		calculateTotals();
	// 	}
	// });




	function calculateTotals() {

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
				document.getElementById('quotation_hidden').value =  data.quotation_id;
				document.getElementById('customer_id').value =  data.customer_id;

				/* CUSTOMER & VEHICLE */
				document.getElementById('customer_name').innerText = data.customer_name || '';
				document.getElementById('customer_phone').innerText = data.customer_phone || '';
				document.getElementById('vehicle_no').innerText = data.registration_no || '';
				document.getElementById('jobcard_no').innerText = data.jobcard_no || '';

				/* SERVICES */
				let serviceHTML = '';
				data.services.forEach(s => {
					serviceHTML += `
                <tr>
                   

                    <td class="border p-2">${s.service_name}</td>
	
                    <td class="border p-2 text-right service-cost"
                        data-amount="${parseFloat(s.total_cost)}">
                        ${parseFloat(s.total_cost).toFixed(2)}
                    </td>
                </tr>`;
				});
				document.getElementById('serviceBody').innerHTML = serviceHTML;

				/* PARTS */
				let partsHTML = '';
				data.parts.forEach(p => {
					partsHTML += `
                <tr>
                  

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
				document.getElementById('partsBody').innerHTML = partsHTML;

				/* DESCRIPTION */
				let descpHTML = '';
				data.descriptions.forEach(d => {
					descpHTML += `
                <tr>
                    

                    <td class="border p-2">${d.description}</td>
                    <td class="border p-2 text-right desc-cost"
                        data-amount="${parseFloat(d.amount)}">
                        ${parseFloat(d.amount).toFixed(2)}
                    </td>
                </tr>`;
				});
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
					success: function (data) {

						console.log("Account AJAX response:", data);

						if (!data || !data.accountId) {
							console.error("Invalid account data", data);
							return;
						}

						document.getElementById('inv_debtor0').value = data.accountId;

						var grand_total  = parseFloat(
    document.getElementById("grand_total").innerText || 0
);

var sub_total    = parseFloat(
    document.getElementById("subtotal").innerText || 0
);

var discount_amt = parseFloat(
    document.getElementById("discount").value || 0
);

var vat_amt      = parseFloat(
    document.getElementById("tax").innerText || 0
);

document.getElementById("inv_dr_amount0").value = grand_total.toFixed(2);
document.getElementById("inv_cr_amount0").value = sub_total.toFixed(2);
document.getElementById("inv_cr_amount2").value = discount_amt.toFixed(2);
document.getElementById("inv_cr_amount1").value = vat_amt.toFixed(2);


						
					},
					error: function (xhr) {
						console.error("Account AJAX error:", xhr.responseText);
					}
				});


				// $.ajax({
				// 		async: "false",
				// 		type: "POST",
				// 		url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_cust_accountId_from_dc",
				// 		data: {
				// 			qid: quotationId
				// 		},
				// 		success: function(data) {
				// 			// data = JSON.parse(data);
				// 			     console.log(data);
				// 			document.getElementById('inv_debtor0').value = data.accountId;
						

				// 			// var grand_total = document.getElementById("grand_total").value;
				// 			// var sub_total = document.getElementById("sub_total").value;
				// 			// var discount_amt = document.getElementById("discount_amt").value;
				// 			// var vat_amt = document.getElementById("vat_amt").value;
				// 			// var crate = document.getElementById('crate').value;
				// 			// var x = (grand_total * crate).toFixed(2);
				// 			// document.getElementById("inv_dr_amount0").value = x;
				// 			// document.getElementById("inv_cr_amount0").value = (sub_total * crate).toFixed(2);
				// 			// document.getElementById("inv_cr_amount2").value = (discount_amt * crate).toFixed(2);
				// 			// document.getElementById("inv_cr_amount1").value = (vat_amt * crate).toFixed(2);
				// 		}
				// });
			});
	}

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
</script>
