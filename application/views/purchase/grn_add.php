<style>
	.form-control {
		font-size: 13px !important;
	}
</style>


<!-- Header -->
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<h1 class="text-xl font-medium text-gray-700">
		Add GRN
	</h1>

	<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_grn_list"
		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">

		List

	</a>

</div>


<form id="main"
	method="post"
	action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_grn_records"
	autocomplete="off"
	enctype="multipart/form-data">


	<div class="bg-white shadow rounded-b-lg p-4">


		<!-- Row 1 -->
		<div class="grid grid-cols-12 gap-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium">
				Select PO
			</label>

			<div class="col-span-12 md:col-span-3">

				<select class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="po_id"
					id="po_id"
					required
					onchange="get_po_info()">

					<option value="">Select</option>

					<?php foreach ($records as $s) { ?>

						<option value="<?php echo $s->po_id ?>">
							<?php echo $s->po_code; ?>
						</option>

					<?php } ?>

				</select>

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">
				GRN Code
			</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					name="grn_code"
					id="grn_code"
					readonly
					value="<?php echo $Code; ?>">

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">
				GRN Date
			</label>

			<div class="col-span-12 md:col-span-2">

				<input type="date"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="grn_date"
					id="grn_date"
					value="">

				<input type="hidden"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="grndate"
					id="grndate">

			</div>

		</div>



		<!-- Row 2 -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2">
				Supplier
			</label>

			<div class="col-span-12 md:col-span-7">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					name="supplier_name"
					id="supplier_name"
					readonly>

				<input type="hidden"
					name="supplier_id"
					id="supplier_id">

			</div>


			<label class="col-span-12 md:col-span-1">
				Reference
			</label>

			<div class="col-span-12 md:col-span-2">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="ref_no"
					id="ref_no">

			</div>

		</div>



		<!-- Row 3 -->
		<div class="grid grid-cols-12 gap-4 mt-4">




			<label class="col-span-12 md:col-span-1">
				Close PO
			</label>

			<div class="col-span-12 md:col-span-2">

				<select class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="po_status"
					id="po_status">

					<option value="1">Yes</option>
					<option value="0">No</option>

				</select>

			</div>

		</div>



		<!-- Items -->
		<div id="po_items_list"
			class="mt-6 border rounded p-3 bg-gray-50 overflow-x-auto">

		</div>



		<!-- Totals -->
		<div class="grid grid-cols-12 gap-4 mt-6">

			<label class="col-span-12 md:col-span-1">
				Sub Total
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2 bg-gray-100"
				name="sub_total"
				id="sub_total"
				readonly>


			<label class="col-span-12 md:col-span-1">
				Discount (%)
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="discount_per"
				id="discount_per" oninput="allowOnlyNumbersDecimal(this)">


			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="discount_amt"
				id="discount_amt" oninput="allowOnlyNumbersDecimal(this)">


			<label class="col-span-12 md:col-span-1">
				VAT (%)
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="vat_per"
				id="vat_per" oninput="allowOnlyNumbersDecimal(this)">


			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="vat_amount"
				id="vat_amount" oninput="allowOnlyNumbersDecimal(this)">



			<label class="col-span-12 md:col-span-1">Round Off</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
				name="roundoff"
				id="roundoff" oninput="allowOnlyNumbersDecimalNegative(this)">



			<label class="col-span-12 md:col-span-1">
				Grand Total
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
				name="grand_total"
				id="grand_total" oninput="allowOnlyNumbersDecimal(this)">

		</div>



		<!-- Remarks -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2">
				Remarks
			</label>

			<textarea class="form-control col-span-12 md:col-span-4 border rounded px-3 py-2"
				name="remarks"
				id="remarks"></textarea>


			<label class="col-span-12 md:col-span-2">
				Prepared By
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-3 border rounded px-3 py-2 bg-gray-100"
				name="sales_person"
				id="sales_person"
				readonly
				value="<?php echo $this->session->userdata('user_name'); ?>">

		</div>
		<br>
		Purchase Invoice Account Entry :
		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

			<!-- Debit Table -->
			<div>
				<table class="min-w-full border border-gray-300 rounded-lg text-sm">

					<thead class="bg-gray-100 text-gray-700">
						<tr>
							<th class="border border-gray-300 px-3 py-2 text-left">
								Debit Purchase (Dr)
							</th>
							<th class="border border-gray-300 px-3 py-2 text-left">
								Debit Amount (AED)
							</th>
						</tr>
					</thead>

					<tbody id="inv_dr_body" class="divide-y divide-gray-200">

						<!-- Row 0 -->
						<tr id="inv_dr_addr0" class="hover:bg-gray-50">

							<td class="border border-gray-300 px-3 py-2">
								<select
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 select2Width"
									id="inv_debtor0"
									name="inv_debtor[]">

									<option value="">Select</option>

									<?php foreach ($sundry_accounts1 as $row) { ?>
										<option
											<?php if ($row->account_id == 1120) echo 'selected'; ?>
											value="<?php echo $row->account_id; ?>">

											<?php echo $row->account_name; ?>

										</option>
									<?php } ?>

								</select>
							</td>

							<td class="border border-gray-300 px-3 py-2">
								<input
									type="number"
									step="0.001"
									name="inv_dr_amount[]"
									id="inv_dr_amount0"
									min="0"
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm debit_sum">
							</td>

						</tr>

						<!-- Row 1 -->
						<tr id="inv_dr_addr1" class="hover:bg-gray-50">

							<td class="border border-gray-300 px-3 py-2">
								<select
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 select2Width"
									id="inv_debtor1"
									name="inv_debtor[]">

									<option value="">Select</option>

									<?php foreach ($sundry_accounts3 as $row) { ?>
										<option
											<?php if ($row->account_id == 1122) echo 'selected'; ?>
											value="<?php echo $row->account_id; ?>">

											<?php echo $row->account_name; ?>

										</option>
									<?php } ?>

								</select>
							</td>

							<td class="border border-gray-300 px-3 py-2">
								<input
									type="number"
									step="0.001"
									name="inv_dr_amount[]"
									id="inv_dr_amount1"
									onkeyup="calculate_grand_total()"
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm debit_sum">
							</td>

						</tr>

						<!-- Row 2 -->
						<tr id="inv_dr_addr2" class="hover:bg-gray-50">

							<td class="border border-gray-300 px-3 py-2">
								<select
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 select2Width"
									id="inv_debtor2"
									name="inv_debtor[]">

									<option value="">Select</option>

									<?php foreach ($sundry_accounts3 as $row) { ?>
										<option
											<?php if ($row->account_id == 226) echo 'selected'; ?>
											value="<?php echo $row->account_id; ?>">

											<?php echo $row->account_name; ?>

										</option>
									<?php } ?>

								</select>
							</td>

							<td class="border border-gray-300 px-3 py-2">
								<input
									type="number"
									step="0.001"
									name="inv_dr_amount[]"
									id="inv_dr_amount2"
									min="0"
									onkeyup="calculate_grand_total()"
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm debit_sum">
							</td>

						</tr>

					</tbody>

				</table>
			</div>


			<!-- Credit Table -->
			<div>
				<table class="min-w-full border border-gray-300 rounded-lg text-sm">

					<thead class="bg-gray-100 text-gray-700">
						<tr>
							<th class="border border-gray-300 px-3 py-2 text-left">
								Credit Supplier (Cr)
							</th>
							<th class="border border-gray-300 px-3 py-2 text-left">
								Credit Amount (AED)
							</th>
						</tr>
					</thead>

					<tbody id="inv_cr_body" class="divide-y divide-gray-200">

						<tr id="inv_cr_addr0" class="hover:bg-gray-50">

							<td class="border border-gray-300 px-3 py-2">

								<select
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2Width"
									id="inv_creditor0"
									name="inv_creditor[]">

									<option value="">Select</option>

									<?php foreach ($sundry_accounts2 as $row) { ?>
										<option
											<?php if ($row->account_id == 228) echo 'selected'; ?>
											value="<?php echo $row->account_id; ?>">

											<?php echo $row->account_name; ?>

										</option>
									<?php } ?>

								</select>

							</td>

							<td class="border border-gray-300 px-3 py-2">

								<input
									type="number"
									step="0.001"
									name="inv_cr_amount[]"
									id="inv_cr_amount0"
									required
									min="0"
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm credit_sum">

							</td>

						</tr>

					</tbody>

				</table>
			</div>

		</div>



		<!-- Submit -->
		<div class="mt-6">

			<button type="submit"
				class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">

				Submit

			</button>

		</div>


	</div>

</form>
<script>
	document.getElementById("main").addEventListener("submit", function() {
		const btn = this.querySelector("button[type='submit']");
		btn.disabled = true;
		btn.innerText = "Submitting...";
	});
</script>

<script>
	// document.addEventListener('DOMContentLoaded', function() {
	// 	setTimeout(function() {
	// 		calculateAll();
	// 	}, 200);
	// });

	let lastDiscountEdited = 'per';

	function get_po_info() {
		var po_id = document.getElementById("po_id").value;

		if (po_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_po_info",
				data: {
					po_id: po_id
				},
				dataType: "json",
				success: function(msg) {
					console.log(msg.po_date);
					document.getElementById("supplier_id").value = msg.supplier_id;
					document.getElementById("supplier_name").value = msg.supplier_code + ' ' + msg.supplier_name;

					// document.getElementById("grn_date").value = msg.po_date;
					$('#grn_date').val(msg.po_date);
					$('#grndate').val(msg.po_date);
					console.log(document.getElementById("grn_date").value);
					get_po_items_list(po_id);
					document.getElementById("sub_total").value = msg.subtotal;
					document.getElementById("discount_per").value = msg.discount_percent;
					document.getElementById("discount_amt").value = msg.discount;
					document.getElementById("vat_per").value = msg.vat_percent;
					document.getElementById("vat_amount").value = msg.vat_amt;
					document.getElementById("grand_total").value = msg.grand_total;
document.getElementById("roundoff").value = msg.currency_rate;
					$.ajax({
						type: "POST",
						url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_supplier_accountId_from_po",
						data: {
							po_id: po_id
						},
						success: function(accid) {

							document.getElementById('inv_creditor0').value = accid;
							var grand_total = document.getElementById("grand_total").value;
							var sub_total = document.getElementById("sub_total").value;
							var discount_amt = document.getElementById("discount_amt").value;
							var vat_amt = document.getElementById("vat_amount").value;
							// alert(grand_total);

							var x = grand_total;
							// alert(x);
							document.getElementById("inv_cr_amount0").value = x;
							document.getElementById("inv_dr_amount0").value = sub_total;
							document.getElementById("inv_dr_amount1").value = discount_amt;
							document.getElementById("inv_dr_amount2").value = vat_amt;
						}
					});

				}
			});
		} else {

			document.getElementById('po_items_list').innerHTML = '';
		}
	}

	function get_po_items_list(po_id) {

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/Ajax/get_po_items_for_grn",
			data: {
				po_id: po_id
			},
			success: function(msg) {
				document.getElementById('po_items_list').innerHTML = msg;
				// setTimeout(() => {
				//   document.querySelectorAll("img.barcode").forEach(img => {
				//     const value = img.getAttribute("data-barcode");

				//     if (value && img instanceof HTMLImageElement) {
				//       // Create a temporary canvas
				//       const canvas = document.createElement("canvas");

				//       JsBarcode(canvas, value, {
				//         format: "CODE128",
				//         width: 2,
				//         height: 40,
				//         displayValue: true
				//       });

				//       // Set barcode image source to the generated canvas data URL
				//       const pngDataUrl = canvas.toDataURL("image/png");
				//       img.src = pngDataUrl;

				//       // Save the PNG base64 to hidden input if exists
				//       const index = img.id.replace("barcode", "");
				//       const input = document.getElementById("barcode_input" + index);
				//       if (input) {
				//         input.value = pngDataUrl;
				//         console.log("Saved PNG to input:", input.id);
				//       }
				//     }
				//   });
				// }, 50);
			}
		});
	}




	$(document).ready(function() {
		function triggerWhenReady() {

			let inputs = document.querySelectorAll('.rec_quantity');

			if (inputs.length > 0) {
				calculateAll();
			} else {
				setTimeout(triggerWhenReady, 200);
			}
		}

		triggerWhenReady();

		function calculateRow($row) {
			// alert("ld");
			// ordered qty (class .qty)
			const orderedQty = parseFloat($row.find('.qty').val()) || 0;

			// received qty (class .rec_quantity) - use received if provided, else ordered
			const recInput = $row.find('.rec_quantity');
			const recVal = parseFloat(recInput.val());
			const receivedQty = !isNaN(recVal) ? recVal : 0;

			const qty = (receivedQty > 0) ? receivedQty : orderedQty;

			// price
			const price = parseFloat($row.find('.unit_price').val()) || 0;

			// per-row discount (optional)
			let disPer = parseFloat($row.find('.dis_percentage').val()) || 0;
			let disAmt = parseFloat($row.find('.dis_amount').val()) || 0;

			// locate the error small element - prefer id="error_msg{index}" if present (your markup has that)
			let errorMsgElem = null;
			// look for a small with id error_msg{data-index}
			const dataIndex = recInput.attr('data-index');
			if (typeof dataIndex !== 'undefined') {
				const idSel = '#error_msg' + dataIndex;
				if ($(idSel).length) errorMsgElem = $(idSel);
			}
			// fallback: element with class .error-msg inside row
			if (!errorMsgElem || errorMsgElem.length === 0) {
				errorMsgElem = $row.find('.error-msg');
			}

			// Validation: received should not exceed ordered
			if (!isNaN(recVal) && recVal > orderedQty) {
				// show error message
				if (errorMsgElem.length) {
					errorMsgElem.text('❌ Received quantity cannot exceed ordered quantity.').show();
				} else {
					// insert dynamic small after rec input if no place exists
					if ($row.find('.error-msg-dyn').length === 0) {
						recInput.after('<small class="text-danger error-msg-dyn" style="display:block;">❌ Received quantity cannot exceed ordered quantity.</small>');
					} else {
						$row.find('.error-msg-dyn').show();
					}
				}
				// mark invalid visually
				recInput.addClass('is-invalid');
				return 0;
			} else {
				// hide any error messages
				if (errorMsgElem.length) errorMsgElem.hide();
				$row.find('.error-msg-dyn').hide();
				recInput.removeClass('is-invalid');
			}

			// compute row total (before per-row discount)
			const rowBase = qty * price;

			// Determine whether user is editing percent or amount (if fields present)
			const isEditingPer = $row.find('.dis_percentage').is(':focus');
			const isEditingAmt = $row.find('.dis_amount').is(':focus');

			if ($row.find('.dis_percentage').length === 0 && $row.find('.dis_amount').length === 0) {
				// no per-row discount fields -> disPer/disAmt = 0
				disPer = 0;
				disAmt = 0;
			} else {
				// if percent field exists but amount empty, compute amount
				if ($row.find('.dis_percentage').length && !isEditingAmt) {
					disAmt = (rowBase * (disPer || 0)) / 100;
					$row.find('.dis_amount').val(disAmt.toFixed(2));
				} else if ($row.find('.dis_amount').length && !isEditingPer) {
					// percent based on amount
					disPer = (rowBase === 0) ? 0 : ((disAmt || 0) / rowBase) * 100;
					$row.find('.dis_percentage').val(disPer.toFixed(2));
				}
			}

			const finalRowTotal = Math.max(0, rowBase - (disAmt || 0)); // avoid negative
			// update UI
			$row.find('.total_price').val(finalRowTotal.toFixed(2));

			return finalRowTotal;
		}

		function calculateAll() {
			let rowSubtotal = 0;

			// iterate only rows in tbody of your items table
			$('#datatable-responsive tbody tr').each(function() {
				const rowTotal = calculateRow($(this)) || 0;
				rowSubtotal += rowTotal;
			});

			// update subtotal field
			$('#sub_total').val(rowSubtotal.toFixed(2));

			// Global discount handling (either percent or amount)

			let globalDiscountPer = parseFloat($('#discount_per').val()) || 0;
			let globalDiscountAmt = parseFloat($('#discount_amt').val()) || 0;

			if (lastDiscountEdited === 'per') {

				globalDiscountAmt = (rowSubtotal * globalDiscountPer) / 100;
				$('#discount_amt').val(globalDiscountAmt.toFixed(2));

			} else {

				globalDiscountPer = (rowSubtotal === 0) ?
					0 :
					(globalDiscountAmt / rowSubtotal) * 100;

				$('#discount_per').val(globalDiscountPer.toFixed(2));
			}
			// const isGlobalPerEditing = $('#discount_per').is(':focus');
			// const isGlobalAmtEditing = $('#discount_amt').is(':focus');

			// let globalDiscountPer = parseFloat($('#discount_per').val()) || 0;
			// let globalDiscountAmt = parseFloat($('#discount_amt').val()) || 0;

			// if (isGlobalPerEditing) {
			// 	globalDiscountAmt = (rowSubtotal * globalDiscountPer) / 100;
			// 	$('#discount_amt').val(globalDiscountAmt.toFixed(2));
			// } else if (isGlobalAmtEditing) {
			// 	globalDiscountPer = (rowSubtotal === 0) ? 0 : (globalDiscountAmt / rowSubtotal) * 100;
			// 	$('#discount_per').val(globalDiscountPer.toFixed(2));
			// } else {
			// 	// neither focused: keep consistency (compute amount from percent)
			// 	globalDiscountAmt = (rowSubtotal * globalDiscountPer) / 100;
			// 	$('#discount_amt').val(globalDiscountAmt.toFixed(2));
			// }

			const afterDiscount = Math.max(0, rowSubtotal - (globalDiscountAmt || 0));

			// VAT
			const vatPer = parseFloat($('#vat_per').val()) || 0;
			const vatAmt = (afterDiscount * vatPer) / 100;
			$('#vat_amount').val(vatAmt.toFixed(2));

			// const grandTotal = afterDiscount + vatAmt;
			// $('#grand_total').val(grandTotal.toFixed(2));

			// Round Off
			const roundOff = parseFloat($('#roundoff').val()) || 0;

			// Grand Total
			const grandTotal = afterDiscount + vatAmt + roundOff;

			$('#grand_total').val(grandTotal.toFixed(2));

			// ====================accounts entry=====================
			var po_id = document.getElementById("po_id").value;

			$.ajax({
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_supplier_accountId_from_po",
				data: {
					po_id: po_id
				},
				success: function(accid) {

					document.getElementById('inv_creditor0').value = accid;
					var grand_total = document.getElementById("grand_total").value;
					var sub_total = document.getElementById("sub_total").value;
					var discount_amt = document.getElementById("discount_amt").value;
					var vat_amt = document.getElementById("vat_amount").value;
					// alert(grand_total);

					var x = grand_total;
					// alert(x);
					document.getElementById("inv_cr_amount0").value = x;
					document.getElementById("inv_dr_amount0").value = sub_total;
					document.getElementById("inv_dr_amount1").value = discount_amt;
					document.getElementById("inv_dr_amount2").value = vat_amt;
				}
			});


		}
		$(document).ready(function() {
			// Bind events on relevant inputs (use event delegation to support dynamic rows)
			$(document).on('input change', '#datatable-responsive tbody .rec_quantity, #datatable-responsive tbody .qty, #datatable-responsive tbody .unit_price, #datatable-responsive tbody .dis_per, #datatable-responsive tbody .dis_amt', function() {
				// calculate only that row first (for responsiveness), then totals

				const $row = $(this).closest('tr');
				calculateRow($row);
				calculateAll();
			});

			// Global discount and VAT handlers
			$(document).on('input change', '#vat_per ,#roundoff', function() {
				calculateAll();
			});

			$('#discount_per').on('input', function() {
				lastDiscountEdited = 'per';
				calculateAll();
			});

			$('#discount_amt').on('input', function() {
				lastDiscountEdited = 'amt';
				calculateAll();
			});

			// Also recalc all on page load
			calculateAll();
		});
	});
	$(document).ready(function() {

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.rec_quantity').forEach(function(recInput) {
				recInput.addEventListener('keyup', function() {
					const idSuffix = this.id.replace('rec_quantity', '');
					const orderedInput = document.getElementById('item_quantity' + idSuffix);
					const errorMsg = document.getElementById('error_msg' + idSuffix);

					const orderedQty = parseFloat(orderedInput?.value) || 0;
					const receivedQty = parseFloat(this.value) || 0;

					if (receivedQty > orderedQty) {
						errorMsg.textContent = "❌ Received quantity cannot be more than ordered.";
						errorMsg.style.display = "block";
						this.classList.add('is-invalid'); // Optional Bootstrap styling
					} else {
						errorMsg.textContent = "";
						errorMsg.style.display = "none";
						this.classList.remove('is-invalid');
					}
				});
			});
		});
	});

	// function test(event) {
	// 	var input = event.target;
	// 	var qty = parseInt(input.value);
	// 	var index = input.getAttribute('data-index');
	// 	var container = document.getElementById('serial_container' + index);

	// 	console.log("Generating", qty, "serial fields for index", index);

	// 	if (!container) {
	// 		console.error('Serial container not found for index', index);
	// 		return;
	// 	}

	// 	container.innerHTML = ''; // Clear previous inputs

	// 	if (!isNaN(qty) && qty > 0) {
	// 		for (let i = 0; i < qty; i++) {
	// 			const inputEl = document.createElement('input');
	// 			inputEl.type = 'text';
	// 			inputEl.name = `serial[${i}][]`;
	// 			inputEl.className = 'form-control serial-input mt-1';
	// 			inputEl.placeholder = `Serial ${i + 1}`;
	// 			inputEl.autocomplete = 'off';
	// 			container.appendChild(inputEl);
	// 		}

	// 		// Focus on the first serial input
	// 		const firstInput = container.querySelector('.serial-input');
	// 		if (firstInput) firstInput.focus();
	// 	}
	// }

	// Handle Enter key navigation
	document.addEventListener('keypress', function(e) {
		if (e.target.classList.contains('serial-input') && e.key === 'Enter') {
			e.preventDefault();

			const container = e.target.closest('.serial-container');
			const inputs = container.querySelectorAll('.serial-input');

			for (let input of inputs) {
				if (!input.value.trim()) {
					input.focus();
					break;
				}
			}
		}
	});
</script>

<script>
	document.addEventListener("change", function(e) {

		if (e.target.classList.contains("stock_unit")) {

			const index = e.target.dataset.index;

			const qtyInput = document.getElementById("qty_per_purchase" + index);

			if (!qtyInput) return;

			const selectedValue = e.target.value;

			if (selectedValue !== "") {

				qtyInput.removeAttribute("readonly");
				qtyInput.classList.remove("bg-gray-100");
				qtyInput.classList.add("bg-white");

			} else {

				qtyInput.setAttribute("readonly", true);
				qtyInput.classList.add("bg-gray-100");
				qtyInput.classList.remove("bg-white");

				qtyInput.value = 1;

			}

		}

	});

	function allowOnlyNumbersDecimal(input) {
		// alert("Cvdfgdf");
		// Remove everything except numbers and decimal point
		input.value = input.value.replace(/[^0-9.]/g, '');

		// Prevent multiple decimal points
		let parts = input.value.split('.');
		if (parts.length > 2) {
			input.value = parts[0] + '.' + parts.slice(1).join('');
		}
	}

	function allowOnlyNumbersDecimalNegative(input) {

		// Remove everything except numbers, decimal point, and minus
		input.value = input.value.replace(/[^0-9.-]/g, '');

		// Allow only one minus sign at beginning
		input.value = input.value.replace(/(?!^)-/g, '');

		// Prevent multiple decimal points
		let parts = input.value.split('.');
		if (parts.length > 2) {
			input.value = parts[0] + '.' + parts.slice(1).join('');
		}
	}
</script>
