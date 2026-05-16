<?php
$services = [];
$parts = [];
$sublets = [];

foreach ($items as $it) {
	if ($it->item_type == 'Service') $services[] = $it;
	if ($it->item_type == 'Part') $parts[] = $it;
	if ($it->item_type == 'Sublet') $sublets[] = $it;
}
?>
<div class="w-full mx-auto bg-white shadow-xl rounded-2xl p-6">

	<h2 class="text-2xl font-bold mb-6">
		Edit Invoice : <?= $invoice->invoice_no ?>
	</h2>

	<!-- HEADER -->
	<div class="grid grid-cols-2 gap-6 bg-gray-50 p-4 rounded mb-6">
		<div>
			<p><b>Customer :</b> <?= $invoice->name ?></p>
			<p><b>Phone :</b> <?= $invoice->phone ?></p>
		</div>

		<div>
			<p><b>Vehicle :</b> <?= $invoice->registration_no ?></p>
			<p><b>Job Card :</b> <?= $invoice->jobcard_no ?></p>
		</div>
	</div>

	<form method="post" action="<?= base_url('index.php/Invoice/update') ?>">

		<input type="hidden" name="invoice_id" value="<?= $invoice->invoice_id ?>">
		<input type="hidden" name="invoice_type" id="invoice_type" value="<?= $invoice->invoice_type  ?>">
		<input type="hidden" name="invoice_no" id="invoice_no" value="<?= $invoice->invoice_no  ?>">
		<input type="hidden" name="jobcard_id" id="jobcard_hidden" value="<?= $invoice->jobcard_id  ?>">
		<input type="hidden" name="quotation_id" id="quotation_hidden" value="<?= $invoice->quotation_id  ?>">
		<input type="hidden" name="customer_id" id="customer_id" value="<?= $invoice->customer_id  ?>">

		<!-- ================= SERVICES ================= -->
		<h3 class="font-semibold mb-2">Invoice Date</h3>
		<input type="date" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" name="invoice_date" id="invoice_date" value="<?= $invoice->invoice_date  ?>">
		<h3 class="font-semibold mb-2">Services</h3>

		<table class="w-full border text-sm mb-6" id="serviceTable">
			<thead class="bg-gray-100">
				<tr>
					<th class="border p-2"></th>
					<th class="border p-2">Service</th>
					<th class="border p-2 text-right">Cost</th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($services as $k =>  $s): ?>

					<tr>
						<td class="border p-2 text-center">
							<input type="checkbox" name="srv_check_open[<?= $k ?>]]" class="srv-check" checked>
						</td>

						<td class="border p-2">
							<?= $s->item_name ?>
							<input type="hidden" name="srv_name[]" value="<?= $s->item_name ?>">
						</td>

						<td class="border p-2">
							<input type="number" step="0.01"
								value="<?= $s->total_price ?>"
								class="srv-cost w-full border p-1 rounded"
								name="srv_cost[]">
						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

			<tfoot class="bg-gray-100 font-bold">
				<tr>
					<td colspan="2" class="text-right p-2">Total Services</td>
					<td class="text-right p-2" id="service_total">0.00</td>
				</tr>
			</tfoot>

		</table>


		<!-- ================= PARTS ================= -->
		<h3 class="font-semibold mb-2">Spare Parts</h3>

		<table class="w-full border text-sm mb-6" id="partsTable">
			<thead class="bg-gray-100">
				<tr>
					<th class="border p-2"></th>
					<th class="border p-2">Part</th>
					<th class="border p-2">Qty</th>
					<th class="border p-2">Unit</th>
					<th class="border p-2">Discount</th>
					<th class="border p-2 text-right">Total</th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($parts  as $k =>  $p): ?>

					<tr>
						<td class="border p-2 text-center">
							<input type="checkbox" name="part_check_open[<?= $k ?>]" value="1" class="part-check" checked>
						</td>

						<td class="border p-2">
							<?= $p->item_name ?>
							<input type="hidden" name="part_name[]" value="<?= $p->item_name ?>">
							<input type="hidden" name="part_id[]" value="<?= $p->source_jobcard_item_id ?>">
						</td>

						<td class="border p-2">
							<input type="number" value="<?= $p->quantity ?>"
								class="part-qty w-full border p-1 rounded" name="part_qty[]">
						</td>

						<td class="border p-2">
							<input type="number" value="<?= $p->unit_price ?>"
								class="part-price w-full border p-1 rounded" name="part_price[]">
						</td>

						<td class="border p-2">
							<input type="number" value="<?= $p->disamount ?>"
								class="part-dis w-full border p-1 rounded" name="part_dis[]">
						</td>

						<td class="border p-2">
							<input type="number" value="<?= $p->total_price ?>"
								class="part-total w-full border p-1 rounded" name="part_total[]" readonly>
						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

			<tfoot class="bg-gray-100 font-bold">
				<tr>
					<td colspan="5" class="text-right p-2">Total Parts</td>
					<td class="text-right p-2" id="parts_total">0.00</td>
				</tr>
			</tfoot>

		</table>


		<!-- ================= SUBLET ================= -->
		<h3 class="font-semibold mb-2">Sublet Service</h3>

		<table class="w-full border text-sm mb-6" id="subletTable">
			<thead class="bg-gray-100">
				<tr>
					<th class="border p-2"></th>
					<th class="border p-2">Description</th>
					<th class="border p-2 text-right">Amount</th>
				</tr>
			</thead>

			<tbody>

				<?php foreach ($sublets as $k => $d): ?>

					<tr>
						<td class="border p-2 text-center">
							<input type="checkbox" name="sub_check_open[<?= $k ?>]]" class="sub-check" checked>
						</td>

						<td class="border p-2">
							<?= $d->item_name ?>
							<input type="hidden" name="sub_name[]" value="<?= $d->item_name ?>">
						</td>

						<td class="border p-2">
							<input type="number" value="<?= $d->total_price ?>"
								class="sub-cost w-full border p-1 rounded" name="sub_cost[]">
						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

			<tfoot class="bg-gray-100 font-bold">
				<tr>
					<td colspan="2" class="text-right p-2">Total Description</td>
					<td class="text-right p-2" id="sub_total">0.00</td>
				</tr>
			</tfoot>

		</table>


		<!-- TOTAL PANEL -->
		<div class="grid grid-cols-2 gap-6">

			<textarea name="remarks"
				class="border rounded p-3 w-full"><?= $invoice->remarks ?></textarea>

			<div class="bg-gray-50 p-4 rounded">

				<div class="flex justify-between"><span>Subtotal</span><span id="subtotal">0</span></div>
				<div class="flex justify-between"><span>Discount</span><span id="discountamt"> <?= $invoice->discount_amount ?></span></div>
				<div class="flex justify-between items-start gap-4">

					<span class="pt-2">Additional Discount</span>

					<div class="flex items-center gap-3">

						<div class="flex flex-col">
							<label class="text-xs text-gray-500 mb-1">Percentage</label>

							<input type="number" step="0.01"
								class="w-24 text-right border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
								name="adddiscount_amount_per"
								id="adddiscount_amount_per" value="<?= $invoice->add_dis_percentage ?>">
						</div>

						<div class="flex flex-col">
							<label class="text-xs text-gray-500 mb-1">Amount</label>

							<input type="number" step="0.01"
								class="w-32 text-right border border-gray-300 rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
								name="adddiscount_amount"
								id="adddiscount_amount" value="<?= $invoice->add_dis_amount ?>">
						</div>

					</div>

				</div>


				<div class="flex justify-between"><span>Taxable Amount</span><span id="taxableamt">0</span></div>
				<div class="flex justify-between"><span>VAT</span><span id="vat">0</span></div>
				<div class="flex justify-between "><span>Grand</span><span id="grand">0</span></div>

				<div class="flex justify-between border-t pt-2 mt-2">
					<span>Advance Payment(if Any)</span>

					<input type="text" name="advance_paid" id="advance_paid" value="<?= $invoice->adv_paid ?>" readonly
						class="advance_paid text-right border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
				</div>
				<div class="flex justify-between border-t pt-2 mt-2">
					<span>Balance</span>
					<span id="balance">0.00</span>
				</div>
				<!-- ==================== advance entry====================== -->

				<input type="hidden" name="subtotal" id="subtotal_input">
				<input type="hidden" name="tax_amount" id="tax_input">
				<input type="hidden" name="discount_amount" id="discount_input">
				<input type="hidden" name="normal_discount_amount" id="normal_discount_amount" value="<?= $invoice->discount_amount ?>">

				<input type="hidden" name="grand_total" id="grand_input">

				<input type="hidden" name="adv_paid" id="adv_paid">
				<input type="hidden" name="balance_total" id="balance_total">

			</div>

		</div>

		<div id="account_entry">
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

		<a href="<?php echo base_url('index.php/Invoice'); ?>"
			class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-600">
			Cancel
		</a>
		<button class="mt-6 bg-green-600 text-white px-6 py-2 rounded">
			Update Invoice
		</button>

	</form>
</div>


<script>
	function calc() {

		let serviceTotal = 0;
		document.querySelectorAll('.srv-check:checked').forEach(c => {
			serviceTotal += parseFloat(c.closest('tr').querySelector('.srv-cost').value) || 0;
		});

		let partsTotal = 0;
		document.querySelectorAll('#partsTable tbody tr').forEach(r => {
			if (r.querySelector('.part-check').checked) {

				let qty = parseFloat(r.querySelector('.part-qty').value) || 0;
				let price = parseFloat(r.querySelector('.part-price').value) || 0;
				let dis = parseFloat(r.querySelector('.part-dis').value) || 0;

				let total = (qty * price) - dis;
				r.querySelector('.part-total').value = total.toFixed(2);

				partsTotal += total;
			}
		});

		let subTotal = 0;
		document.querySelectorAll('.sub-check:checked').forEach(c => {
			subTotal += parseFloat(c.closest('tr').querySelector('.sub-cost').value) || 0;
		});

		document.getElementById('service_total').innerText = serviceTotal.toFixed(2);
		document.getElementById('parts_total').innerText = partsTotal.toFixed(2);
		document.getElementById('sub_total').innerText = subTotal.toFixed(2);

		let totaldisamt = parseFloat(document.getElementById('discountamt').innerText) || 0;

		let totaladddisamt = parseFloat(document.getElementById('adddiscount_amount').value) || 0;

		let totinvdisamt = totaldisamt + totaladddisamt;

		let subtotal = serviceTotal + partsTotal + subTotal;
		let taxableamt = subtotal - totinvdisamt;
		// let taxableamt = subtotal - totaldisamt;
		let vat = taxableamt * 0.05;
		let grand = taxableamt + vat;

		/* ========= advance calculation ========= */

		let advpaid = parseFloat(document.getElementById('advance_paid').value) || 0;

		// prevent overpayment
		if (advpaid > grand) {
			advpaid = grand;
			document.getElementById('advance_paid').value = grand.toFixed(2);
		}

		let baltot = Math.round((grand - advpaid) * 100) / 100;

		document.getElementById('balance').innerText = baltot.toFixed(2);
		document.getElementById('balance_total').value = baltot.toFixed(2);

		/* ========= DISPLAY ========= */

		document.getElementById('subtotal').innerText = subtotal.toFixed(2);

		document.getElementById('vat').innerText = vat.toFixed(2);
		document.getElementById('grand').innerText = grand.toFixed(2);

		document.getElementById('taxableamt').innerText = taxableamt.toFixed(2);
		// =====================accounts fileds===================
		document.getElementById("inv_dr_amount0").value = grand.toFixed(2);
		document.getElementById("inv_cr_amount0").value = subtotal.toFixed(2);
		document.getElementById("inv_cr_amount2").value = totinvdisamt;
		// document.getElementById("inv_cr_amount2").value = totaldisamt;
		document.getElementById("inv_cr_amount1").value = vat.toFixed(2);
		/* ========= HIDDEN INPUTS ========= */
		document.getElementById('subtotal_input').value = subtotal.toFixed(2);
		document.getElementById('tax_input').value = vat.toFixed(2);
		document.getElementById('discount_input').value = totinvdisamt; // or calculated discount
		document.getElementById('grand_input').value = grand.toFixed(2);

		document.getElementById('adv_paid').value = advpaid.toFixed(2);
		document.getElementById('balance_total').value = baltot.toFixed(2);

	}

	document.querySelectorAll('input').forEach(i => i.addEventListener('input', calc));
	calc();

	$(document).ready(function() {

		var qid = document.getElementById('quotation_hidden').value;

		$.ajax({
			async: false,
			type: "POST",
			url: BASE_URL + "Ajax/ajax_get_cust_accountId_from_dc",
			data: {
				qid: qid
			},
			dataType: "json",
			success: function(data) {

				console.log("Account AJAX response:", data);

				if (!data || !data.accountId) {
					console.error("Invalid account data", data);
					return;
				}

				$('#inv_debtor0').val(data.accountId).trigger('change');

				var grand_total = parseFloat(
					document.getElementById('grand_input').value || 0
				);

				var sub_total = parseFloat(
					document.getElementById('subtotal_input').value || 0
				);

				var discount_amt = parseFloat(
					document.getElementById('discount_input').value || 0
				);

				var vat_amt = parseFloat(
					document.getElementById('tax_input').value || 0
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

	document.getElementById('advance_paid').addEventListener('input', function() {

		let grand = parseFloat(document.getElementById('grand_total').innerText) || 0;
		let advpaid = parseFloat(this.value) || 0;

		if (advpaid > grand) {
			advpaid = grand;
			this.value = grand.toFixed(2);
		}

		let balance = Math.round((grand - advpaid) * 100) / 100;

		document.getElementById('balance').innerText = balance.toFixed(2);
		document.getElementById('adv_paid').value = advpaid.toFixed(2);
		document.getElementById('balance_total').value = balance.toFixed(2);
	});



	document.addEventListener("DOMContentLoaded", function() {

		const subtotalEl = document.getElementById("subtotal");
		const ndisamtE = document.getElementById("discount_input");
		const addDiscountPer = document.getElementById("adddiscount_amount_per");
		const addDiscountAmt = document.getElementById("adddiscount_amount");

		// Percentage → Amount
		addDiscountPer.addEventListener("input", function() {

			let subtotal = parseFloat(subtotalEl.innerText) || 0;
			let ndisamt = parseFloat(ndisamtE.value) || 0;
			let per = parseFloat(this.value) || 0;

			let amount = ((subtotal - ndisamt) * per) / 100;

			addDiscountAmt.value = amount.toFixed(2);

			calc();
		});

		// Amount → Percentage
		addDiscountAmt.addEventListener("input", function() {

			let subtotal = parseFloat(subtotalEl.innerText) || 0;
			let ndisamt = parseFloat(ndisamtE.value) || 0;
			let amount = parseFloat(this.value) || 0;

			let per = 0;

			if (subtotal > 0) {
				per = (amount / (subtotal - ndisamt)) * 100;
			}

			addDiscountPer.value = per.toFixed(2);

			calc();
		});

	});
</script>
