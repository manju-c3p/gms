<style>
	.form-control {
		font-size: 13px;
		height: 36px;
	}

	.section-card {
		background: #fff;
		border-radius: 10px;
		padding: 18px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
		margin-bottom: 15px;
	}

	.label {
		font-size: 13px;
		font-weight: 500;
		color: #555;
		margin-bottom: 4px;
		display: block;
	}

	.grid-gap {
		gap: 12px;
	}

	table th {
		background: #f1f5f9;
		font-size: 13px;
		font-weight: 600;
	}

	table td {
		vertical-align: middle;
	}

	.table input {
		height: 32px;
		font-size: 13px;
	}

	.totals input {
		text-align: right;
	}
</style>

<?php $grn = $grn ?? null; ?>

<div class="flex justify-between items-center bg-gray-200 px-4 py-3 rounded-t-lg">
	<h1 class="text-lg font-medium">Edit GRN</h1>
	<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_grn_list"
		class="bg-gray-600 text-white px-4 py-2 rounded">List</a>
</div>

<form method="post"
	action="<?php echo base_url(); ?>index.php/Purchase/edit_grn_records"
	autocomplete="off">

	<!-- ================= TOP SECTION ================= -->
	<div class="section-card">

		<div class="grid grid-cols-12 grid-gap">

			<div class="col-span-3">
				<label class="label">Select PO</label>
				<select class="form-control w-full" name="po_id" id="po_id">
					<option value="">Select</option>
					<?php foreach ($records as $s) { ?>
						<option value="<?php echo $s->po_id ?>"
							<?php if (isset($grn->po_id) && $grn->po_id == $s->po_id) echo 'selected'; ?>>
							<?php echo $s->po_code; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-span-3">
				<label class="label">GRN Code</label>
				<input type="text" class="form-control w-full bg-gray-100"
					value="<?php echo $grn->grn_code ?? ''; ?>" readonly>
			</div>

			<div class="col-span-3">
				<label class="label">GRN Date</label>
				<input type="date" class="form-control w-full"
					value="<?php echo isset($grn->grn_date) ? date('Y-m-d', strtotime($grn->grn_date)) : ''; ?>">
			</div>

		</div>

		<div class="grid grid-cols-12 grid-gap mt-3">

			<div class="col-span-6">
				<label class="label">Supplier</label>
				<input type="text" class="form-control w-full bg-gray-100"
					value="<?php echo $grn->supplier_name ?? ''; ?>" readonly>
				<input type="hidden" name="supplier_id" value="<?php echo $grn->supplier_id ?? ''; ?>">
			</div>

			<div class="col-span-3">
				<label class="label">Reference</label>
				<input type="text" class="form-control w-full" name="ref_no">
			</div>

		</div>

	</div>

	<!-- ================= ITEMS ================= -->
	<div class="section-card">

		<table class="table w-full border rounded overflow-hidden">
			<thead>
				<tr>
					<th class="px-3 py-2">SR.NO</th>
					<th class="px-3 py-2">PRODUCT</th>
					<th class="px-3 py-2">QTY</th>
					<th class="px-3 py-2">PRICE</th>
					<th class="px-3 py-2">TOTAL</th>
				</tr>
			</thead>

			<tbody id="datatable-responsive">

				<?php $i = 1;
				foreach ($grn_tr as $row) { ?>
					<tr class="border-t">

						<td class="px-3 py-2"><?php echo $i++; ?></td>

						<td class="px-3 py-2">
							<?php echo $row->part_name; ?>
							<input type="hidden" name="product_id[]" value="<?php echo $row->product_id; ?>">
						</td>

						<td class="px-3 py-2">
							Ordered:
							<input type="text" class="qty w-full"
								value="<?php echo $row->ord_quantity; ?>" readonly>

							Received:
							<input type="text" name="rec_quantity[]"
								class="rec_quantity w-full mt-1"
								value="<?php echo $row->rec_quantity; ?>">
						</td>

						<td class="px-3 py-2">
							<input type="text" name="price[]"
								class="unit_price w-full"
								value="<?php echo $row->price; ?>">
						</td>

						<td class="px-3 py-2">
							<input type="text" class="total_price w-full"
								value="<?php echo $row->total; ?>" readonly>
						</td>

					</tr>
				<?php } ?>

			</tbody>
		</table>

	</div>

	<!-- ================= TOTALS ================= -->
	<div class="section-card totals">

		<div class="grid grid-cols-12 grid-gap">

			<div class="col-span-2">
				<label class="label">Sub Total</label>
				<input type="text" name="sub_total" id="sub_total"
					class="form-control bg-gray-100"
					value="<?php echo $grn->sub_total ?? ''; ?>" readonly>
			</div>

			<div class="col-span-2">
				<label class="label">Discount %</label>
				<input type="text" name="discount_per" id="discount_per"
					class="form-control"
					value="<?php echo $grn->discount_percent ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="label">Discount Amt</label>
				<input type="text" name="discount_amt" id="discount_amt"
					class="form-control"
					value="<?php echo $grn->discount ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="label">VAT %</label>
				<input type="text" name="vat_per" id="vat_per"
					class="form-control"
					value="<?php echo $grn->vat_percent ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="label">VAT Amt</label>
				<input type="text" name="vat_amount" id="vat_amount"
					class="form-control"
					value="<?php echo $grn->vat_amt ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="label">Grand Total</label>
				<input type="text" name="grand_total" id="grand_total"
					class="form-control font-bold"
					value="<?php echo $grn->grand_total ?? ''; ?>">
			</div>

		</div>

	</div>

	<!-- ================= REMARKS ================= -->
	<div class="section-card">

		<div class="grid grid-cols-12 grid-gap">

			<div class="col-span-6">
				<label class="label">Remarks</label>
				<textarea class="form-control w-full" name="remarks"><?php echo $grn->remark ?? ''; ?></textarea>
			</div>

			<div class="col-span-4">
				<label class="label">Prepared By</label>
				<input type="text"
					class="form-control bg-gray-100"
					value="<?php echo $this->session->userdata('user_name'); ?>" readonly>
			</div>

		</div>

		<div class="mt-4">
			<button type="submit"
				class="bg-green-600 text-white px-6 py-2 rounded">
				Submit
			</button>
		</div>

	</div>

</form>

<script>
	$(document).ready(function() {
		setTimeout(function() {
			calculateAll();
		}, 300);
	});
</script>


<script>
	$(document).ready(function() {

		setTimeout(function() {
			calculateAll();
		}, 300);

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
			const isGlobalPerEditing = $('#discount_per').is(':focus');
			const isGlobalAmtEditing = $('#discount_amt').is(':focus');

			let globalDiscountPer = parseFloat($('#discount_per').val()) || 0;
			let globalDiscountAmt = parseFloat($('#discount_amt').val()) || 0;

			if (isGlobalPerEditing) {
				globalDiscountAmt = (rowSubtotal * globalDiscountPer) / 100;
				$('#discount_amt').val(globalDiscountAmt.toFixed(2));
			} else if (isGlobalAmtEditing) {
				globalDiscountPer = (rowSubtotal === 0) ? 0 : (globalDiscountAmt / rowSubtotal) * 100;
				$('#discount_per').val(globalDiscountPer.toFixed(2));
			} else {
				// neither focused: keep consistency (compute amount from percent)
				globalDiscountAmt = (rowSubtotal * globalDiscountPer) / 100;
				$('#discount_amt').val(globalDiscountAmt.toFixed(2));
			}

			const afterDiscount = Math.max(0, rowSubtotal - (globalDiscountAmt || 0));

			// VAT
			const vatPer = parseFloat($('#vat_per').val()) || 0;
			const vatAmt = (afterDiscount * vatPer) / 100;
			$('#vat_amount').val(vatAmt.toFixed(2));

			const grandTotal = afterDiscount + vatAmt;
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

		// Bind events on relevant inputs (use event delegation to support dynamic rows)
		$(document).on('input change', '#datatable-responsive tbody .rec_quantity, #datatable-responsive tbody .qty, #datatable-responsive tbody .unit_price, #datatable-responsive tbody .dis_per, #datatable-responsive tbody .dis_amt', function() {
			// calculate only that row first (for responsiveness), then totals

			const $row = $(this).closest('tr');
			calculateRow($row);
			calculateAll();
		});

		// Global discount and VAT handlers
		$(document).on('input change', '#discount_per, #discount_amt, #vat_per', function() {
			calculateAll();
		});

		// Also recalc all on page load
		calculateAll();

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
</script>
