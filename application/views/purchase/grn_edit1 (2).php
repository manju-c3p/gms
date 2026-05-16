<?php $this->load->helper('account_helper.php'); ?>

<?php $grn = $grn ?? null; ?>

<div class="flex justify-between items-center bg-gray-200 px-4 py-3 rounded-t-lg">
	<h1 class="text-lg font-medium">Edit GRN</h1>
	<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_grn_list"
		class="bg-gray-600 text-white px-4 py-2 rounded-lg">List</a>
</div>

<form method="post"
	action="<?php echo base_url(); ?>index.php/Purchase/edit_grn_records"
	autocomplete="off">


	<div class="bg-white rounded-xl p-4 shadow-sm mb-4">

		<div class="grid grid-cols-5 gap-3">

			<div>
				<label class="text-sm font-medium text-gray-600 mb-1 block">Select PO</label>
				<select class="w-full h-9 text-sm border border-gray-300 rounded px-2" name="po_id" id="po_id">
					<!-- <option value="">Select</option> -->
					<?php foreach ($records as $s) {

						if (!is_object($s) || !isset($s->po_id)) continue;
						if ((int)($grn->po_id ?? 0) === (int)$s->po_id) {
					?>
							<option value="<?php echo $s->po_id; ?>"
								<?php echo ((int)($grn->po_id ?? 0) === (int)$s->po_id) ? 'selected' : ''; ?>>
								<?php echo $s->po_code; ?>
							</option>
					<?php }
					} ?>
				</select>
			</div>
			<div>
				<label class="text-sm font-medium text-gray-600 mb-1 block">GRN Code</label>
				<input type="text" class="w-full h-9 text-sm border border-gray-200 bg-gray-100 rounded px-2"
					value="<?php echo $grn->grn_code ?? ''; ?>" readonly>
			</div>

			<div>
				<label class="text-sm font-medium text-gray-600 mb-1 block">GRN Date</label>
				<input type="date" class="w-full h-9 text-sm border border-gray-300 rounded px-2"
					value="<?php echo isset($grn->grn_date) ? date('Y-m-d', strtotime($grn->grn_date)) : ''; ?>">
			</div>

			<div>
				<label class="text-sm font-medium text-gray-600 mb-1 block">Supplier</label>
				<input type="text" class="w-full h-9 text-sm border border-gray-200 bg-gray-100 rounded px-2"
					value="<?php echo $grn->supplier_name ?? ''; ?>" readonly>
				<input type="hidden" name="supplier_id" value="<?php echo $grn->supplier_id ?? ''; ?>">
			</div>

			<div>
				<label class="text-sm font-medium text-gray-600 mb-1 block">Reference</label>
				<input type="text" class="w-full h-9 text-sm border border-gray-300 rounded px-2" name="ref_no">
			</div>

		</div>

	</div>

	<div class="bg-white rounded-xl p-4 shadow-sm mb-4">

		<table id="datatable-responsive" class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
			<thead class="bg-gray-100 text-gray-700">
				<tr>
					<th class="px-3 py-2 text-left font-semibold">SR.NO</th>
					<th class="px-3 py-2 text-left font-semibold">PRODUCT</th>
					<th class="px-3 py-2 text-left font-semibold">QTY</th>
					<th class="px-3 py-2 text-left font-semibold">PRICE</th>
					<th class="px-3 py-2 text-left font-semibold">TOTAL</th>
				</tr>
			</thead>

			<tbody>

				<?php $i = 1;
				foreach ($grn_tr as $row) { ?>
					<tr class="border-t hover:bg-gray-50">

						<td class="px-3 py-2"><?php echo $i++; ?></td>

						<td class="px-3 py-2">
							<?php echo $row->part_name; ?>
							<input type="hidden" name="product_id[]" value="<?php echo $row->product_id; ?>">
						</td>

						<td class="px-3 py-2">
							Ordered:
							<input type="text" class="w-full h-8 text-sm border border-gray-300 rounded px-2"
								value="<?php echo $row->ord_quantity; ?>" readonly>

							Received:
							<input type="text" name="rec_quantity[]"
								class="w-full h-8 text-sm border border-gray-300 rounded px-2 mt-1  rec_quantity "
								value="<?php echo $row->rec_quantity; ?>">
						</td>

						<td class="px-3 py-2">
							<input type="text" name="price[]"
								class="w-full h-8 text-sm border border-gray-300 rounded px-2  unit_price"
								value="<?php echo $row->price; ?>">
						</td>

						<td class="px-3 py-2">
							<input type="text" class="w-full h-8 text-sm border border-gray-200 bg-gray-100 rounded px-2  total_price"
								value="<?php echo $row->total; ?>" readonly>
						</td>

					</tr>
				<?php } ?>

			</tbody>
		</table>

	</div>

	<div class="bg-white rounded-xl p-4 shadow-sm mb-4">

		<div class="grid grid-cols-12 gap-3">

			<div class="col-span-2">
				<label class="text-sm font-medium text-gray-600 mb-1 block">Sub Total</label>
				<input type="text" name="sub_total" id="sub_total"
					class="w-full h-9 text-sm border border-gray-200 bg-gray-100 rounded px-2 text-right"
					value="<?php echo $grn->sub_total; ?>" readonly>
			</div>

			<div class="col-span-2">
				<label class="text-sm font-medium text-gray-600 mb-1 block">Discount %</label>
				<input type="text" name="discount_per" id="discount_per"
					class="w-full h-9 text-sm border border-gray-300 rounded px-2 text-right"
					value="<?php echo $grn->discount_percent ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="text-sm font-medium text-gray-600 mb-1 block">Discount Amt</label>
				<input type="text" name="discount_amt" id="discount_amt"
					class="w-full h-9 text-sm border border-gray-300 rounded px-2 text-right"
					value="<?php echo $grn->discount ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="text-sm font-medium text-gray-600 mb-1 block">VAT %</label>
				<input type="text" name="vat_per" id="vat_per"
					class="w-full h-9 text-sm border border-gray-300 rounded px-2 text-right"
					value="<?php echo $grn->vat_percent ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="text-sm font-medium text-gray-600 mb-1 block">VAT Amt</label>
				<input type="text" name="vat_amount" id="vat_amount"
					class="w-full h-9 text-sm border border-gray-300 rounded px-2 text-right"
					value="<?php echo $grn->vat_amt ?? ''; ?>">
			</div>

			<div class="col-span-2">
				<label class="text-sm font-medium text-gray-600 mb-1 block">Grand Total</label>
				<input type="text" name="grand_total" id="grand_total"
					class="w-full h-9 text-sm border border-gray-300 rounded px-2 text-right font-semibold"
					value="<?php echo $grn->grand_total ?? ''; ?>">
			</div>

		</div>

	</div>

	<div class="bg-white rounded-xl p-4 shadow-sm mb-4">

		<div class="grid grid-cols-12 gap-3">

			<div class="col-span-6">
				<label class="text-sm font-medium text-gray-600 mb-1 block">Remarks</label>
				<textarea class="w-full border border-gray-300 rounded px-2 py-2 text-sm" name="remarks"><?php echo $grn->remark ?? ''; ?></textarea>
			</div>

			<div class="col-span-4">
				<label class="text-sm font-medium text-gray-600 mb-1 block">Prepared By</label>
				<input type="text"
					class="w-full h-9 text-sm border border-gray-200 bg-gray-100 rounded px-2"
					value="<?php echo $this->session->userdata('user_name'); ?>" readonly>
			</div>

		</div>

		<hr>
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
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 select2Width" id="inv_debtor0" name="inv_debtor[]" required>
									<option value="">Select <?php echo $grn->grn_id; ?></option>
									<?php foreach ($sundry_accounts1 as $r1) { ?>
										<option <?php if ($r1->account_id == 1120) echo 'selected'; ?> value="<?php echo $r1->account_id; ?>"><?php echo $r1->account_name; ?></option>
									<?php } ?>
								</select>
							</td>
							<td><input type="number" step='0.01' name="inv_dr_amount[]" id="inv_dr_amount0" class="border border-gray-300 px-3 py-2" required min=0 value="<?php echo $grn->sub_total; ?>">
							</td>
							<!--<td><a id='delete_row1' title="Delete" onclick='remove_row_inv_dr(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>-->
						</tr>
						<tr id="inv_dr_addr1" class="hover:bg-gray-50">
							<td class="border border-gray-300 px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 select2Width" id="inv_debtor1" name="inv_debtor[]" requird>
									<option value="">Select</option>
									<?php foreach ($sundry_accounts3 as $a2) { ?>
										<option <?php if ($a2->account_id == 1122) echo 'selected'; ?> value="<?php echo $a2->account_id; ?>"><?php echo $a2->account_name; ?></option>
									<?php } ?>
								</select>
							</td>
							<td><input type="number" step='0.01' name="inv_dr_amount[]" id="inv_dr_amount1" class="form-control form-control-sm debit_sum" requird min=0 value="<?php echo $grn->discount ?? ''; ?>">
							</td>
							<!--<td><a id='delete_row1' title="Delete" onclick='remove_row_inv_dr(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>-->
						</tr>
						<tr id="inv_dr_addr2" class="hover:bg-gray-50">
							<td class="border border-gray-300 px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 select2Width" id="inv_debtor2" name="inv_debtor[]" requird>
									<option value="">Select</option>
									<?php foreach ($sundry_accounts3 as $a3) { ?>
										<option <?php if ($a3->account_id == 226) echo 'selected'; ?> value="<?php echo $a3->account_id; ?>"><?php echo $a3->account_name; ?></option>
									<?php } ?>
								</select>
							</td>
							<td><input type="number" step='0.01' name="inv_dr_amount[]" id="inv_dr_amount2" class="form-control form-control-sm debit_sum" requird min=0 value="<?php echo $grn->vat_amt ?? ''; ?>">
							</td>
							<!--<td><a id='delete_row1' title="Delete" onclick='remove_row_inv_dr(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>-->
						</tr>
					</tbody>
				</table>
			</div>
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
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2Width" id="inv_creditor0" name="inv_creditor[]" required>
									<option value="">Select</option>
									<?php foreach ($sundry_accounts2 as $a4) { ?>
										<option <?php if ($a4->account_id == $grn->account_id) echo 'selected'; ?> value="<?php echo $a4->account_id; ?>"><?php echo $a4->account_name; ?></option>
									<?php } ?>
								</select>
								<!--<label id='set_balanceinv_cr0'>Balance</label>-->
							</td>
							<td><input type="number" step='0.01' name="inv_cr_amount[]" id="inv_cr_amount0" class="form-control form-control-sm credit_sum" required min=0 value="<?php echo get_voucher_by_trans_id($grn->grn_id, 'G', 'Cr', $grn->account_id); ?>">
							</td>
						</tr>

					</tbody>
				</table>
			</div>
		</div>

		<div class="mt-4">
			<button type="submit"
				class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-sm">
				Update
			</button>
		</div>

	</div>


</form>
<script>
document.getElementById("main").addEventListener("submit", function () {
    const btn = this.querySelector("button[type='submit']");
    btn.disabled = true;
    btn.innerText = "Updating...";
});
</script>

<script>
// function calculateRow(row) {
//     let qty = parseFloat(row.find('.rec_quantity').val()) || 0;
//     let price = parseFloat(row.find('.unit_price').val()) || 0;

//     let total = qty * price;
//     row.find('.total_price').val(total.toFixed(2));

//     return total;
// }

// function calculateTotals() {
//     let subTotal = 0;

//     // 1. Row totals
//     $('#datatable-responsive tbody tr').each(function () {
//         subTotal += calculateRow($(this));
//     });

//     $('#sub_total').val(subTotal.toFixed(2));

//     // 2. Discount
//     let discountPer = parseFloat($('#discount_per').val()) || 0;
//     let discountAmt = parseFloat($('#discount_amt').val()) || 0;

//     if (discountPer > 0) {
//         discountAmt = (subTotal * discountPer) / 100;
//         $('#discount_amt').val(discountAmt.toFixed(2));
//     } else {
//         discountPer = subTotal ? (discountAmt / subTotal) * 100 : 0;
//         $('#discount_per').val(discountPer.toFixed(2));
//     }

//     let afterDiscount = subTotal - discountAmt;

//     // 3. VAT
//     let vatPer = parseFloat($('#vat_per').val()) || 0;
//     let vatAmt = parseFloat($('#vat_amount').val()) || 0;

//     if (vatPer > 0) {
//         vatAmt = (afterDiscount * vatPer) / 100;
//         $('#vat_amount').val(vatAmt.toFixed(2));
//     } else {
//         vatPer = afterDiscount ? (vatAmt / afterDiscount) * 100 : 0;
//         $('#vat_per').val(vatPer.toFixed(2));
//     }

//     // 4. Grand Total
//     let grandTotal = afterDiscount + vatAmt;
//     $('#grand_total').val(grandTotal.toFixed(2));

//     // 5. ACCOUNT ENTRY AUTO SYNC (IMPORTANT)
//     $('#inv_dr_amount0').val(subTotal.toFixed(2));     // Purchase
//     $('#inv_dr_amount1').val(discountAmt.toFixed(2));  // Discount
//     $('#inv_dr_amount2').val(vatAmt.toFixed(2));       // VAT

//     $('#inv_cr_amount0').val(grandTotal.toFixed(2));   // Supplier
// }


// // 🔥 EVENTS (works for dynamic typing)
// $(document).on('input', '.rec_quantity, .unit_price', function () {
//     calculateTotals();
// });

// $(document).on('input', '#discount_per, #discount_amt, #vat_per, #vat_amount', function () {
//     calculateTotals();
// });

// // Initial load
// $(document).ready(function () {
//     calculateTotals();
// });
</script>

<script>
let lastEdited = '';

$(document).on('input', '#discount_per', function () {
    lastEdited = 'discount_per';
});
$(document).on('input', '#discount_amt', function () {
    lastEdited = 'discount_amt';
});
$(document).on('input', '#vat_per', function () {
    lastEdited = 'vat_per';
});
$(document).on('input', '#vat_amount', function () {
    lastEdited = 'vat_amount';
});

function calculateTotals() {
    let subTotal = 0;

    $('#datatable-responsive tbody tr').each(function () {
        let qty = parseFloat($(this).find('.rec_quantity').val()) || 0;
        let price = parseFloat($(this).find('.unit_price').val()) || 0;
        let total = qty * price;

        $(this).find('.total_price').val(total.toFixed(2));
        subTotal += total;
    });

    $('#sub_total').val(subTotal.toFixed(2));

   // ✅ DISCOUNT
let discountPer = parseFloat($('#discount_per').val()) || 0;
let discountAmt = parseFloat($('#discount_amt').val()) || 0;

// If user last edited amount → reverse calc %
if (lastEdited === 'discount_amt') {
    discountPer = subTotal ? (discountAmt / subTotal) * 100 : 0;
    $('#discount_per').val(discountPer.toFixed(2));
} 
// Otherwise ALWAYS treat % as source of truth
else {
    discountAmt = (subTotal * discountPer) / 100;
    $('#discount_amt').val(discountAmt.toFixed(2));
}

let afterDiscount = subTotal - discountAmt;


// ✅ VAT
let vatPer = parseFloat($('#vat_per').val()) || 0;
let vatAmt = parseFloat($('#vat_amount').val()) || 0;

// If user edited amount → reverse calc %
if (lastEdited === 'vat_amount') {
    vatPer = afterDiscount ? (vatAmt / afterDiscount) * 100 : 0;
    $('#vat_per').val(vatPer.toFixed(2));
} 
// Otherwise ALWAYS use %
else {
    vatAmt = (afterDiscount * vatPer) / 100;
    $('#vat_amount').val(vatAmt.toFixed(2));
}

    let grandTotal = afterDiscount + vatAmt;
    $('#grand_total').val(grandTotal.toFixed(2));

    // ACCOUNT ENTRY SYNC
    $('#inv_dr_amount0').val(subTotal.toFixed(2));
    $('#inv_dr_amount1').val(discountAmt.toFixed(2));
    $('#inv_dr_amount2').val(vatAmt.toFixed(2));
    $('#inv_cr_amount0').val(grandTotal.toFixed(2));
}

// triggers
$(document).on('input', '.rec_quantity, .unit_price', calculateTotals);
$(document).on('input', '#discount_per, #discount_amt, #vat_per, #vat_amount', calculateTotals);

$(document).ready(function () {
    calculateTotals();
});
</script>


