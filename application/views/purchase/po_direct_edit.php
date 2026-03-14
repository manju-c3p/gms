<?php
$page_name2 = 'Purchase/purchase_order_list';
$user = $this->session->userdata('user_id');
?>


<form id="main" method="post"
	action="<?php echo base_url() . 'index.php/'; ?>Purchase/update_purchase_order"
	autocomplete="off" enctype="multipart/form-data"
	class="space-y-6">

	<div class="bg-white shadow rounded-xl p-6 space-y-6">
		<div class="flex items-center justify-between mb-6">

			<h1 class="text-xl font-semibold text-gray-800">
				Edit Purchase Order
			</h1>

			<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_order_list"
				class="px-4 py-2 border border-gray-300 rounded-lg
              text-gray-700 hover:bg-gray-100 text-sm">
				← Back to List
			</a>

		</div>

		<!-- Supplier / Code / Date -->
		<div class="grid grid-cols-12 gap-4 items-end">

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Supplier</label>
				<select class="w-full border rounded-lg px-3 py-2"
					name="supplier_id" id="supplier_id" required>
					<option value="">Select</option>
					<?php foreach ($supplier_records as $s) { ?>
						<option <?php if ($records1[0]->supplier_id == $s->supplier_id) echo 'selected' ?>
							value="<?php echo $s->supplier_id ?>">
							<?php echo $s->supplier_code; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">PO Code</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 bg-gray-100"
					name="po_code" id="po_code"
					value="<?php echo $records1[0]->po_code; ?>" readonly>
				<input type="hidden"
					name="po_id" id="po_id"
					value="<?php echo $records1[0]->po_id; ?>">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">PO Date</label>
				<input type="date"
					class="w-full border rounded-lg px-3 py-2"
					name="po_date" id="po_date"
					value="<?php echo $records1[0]->po_date; ?>">
			</div>

		</div>

		<!-- Subject / Ref / Freight -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Subject</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="subject" id="subject"
					value="<?php echo $records1[0]->subject; ?>">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Reference</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="ref_no" id="ref_no"
					value="<?php echo $records1[0]->supplier_ref; ?>">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Freight Mode</label>
				<select class="w-full border rounded-lg px-3 py-2"
					name="freight_mode" id="freight_mode">
					<option <?php if ($records1[0]->freight_mode == "Sea") echo "selected" ?> value="Sea">Sea</option>
					<option <?php if ($records1[0]->freight_mode == "Air") echo "selected" ?> value="Air">Air</option>
					<option <?php if ($records1[0]->freight_mode == "Road") echo "selected" ?> value="Road">Road</option>
					<option <?php if ($records1[0]->freight_mode == "Courier") echo "selected" ?> value="Courier">Courier</option>
				</select>
			</div>

		</div>

		<!-- Upload -->
		<div class="grid grid-cols-12 gap-4 items-center">

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Upload Document</label>
				<input type="file"
					class="w-full border rounded-lg px-3 py-2"
					name="po_doc" id="po_doc">
			</div>

			<div class="col-span-12 md:col-span-6">
				<?php if (!empty($po_doc[0]->doc_path)) { ?>
					<a class="text-blue-600 hover:underline"
						href="<?php echo base_url('public/uploaded_documents/' . $po_doc[0]->doc_path); ?>"
						target="_blank">
						<?php echo $po_doc[0]->doc_path; ?>
					</a>
				<?php } ?>
			</div>

		</div>

	</div>


	<!-- TABLE SECTION -->
	<div class="bg-white shadow rounded-xl p-6 overflow-x-auto">

		<table id="item_table"
			class="w-full table-fixed text-sm border border-gray-300">

			<thead class="bg-gray-100 text-gray-700">
				<tr>
					<th class="w-[12%] p-3 border">Product Code</th>
					<!-- <th class="w-[10%] p-3 border">Brand</th> -->
					<th class="w-[18%] p-3 border">Description</th>
					<th class="w-[8%] p-3 border text-right">Quantity</th>
					<th class="w-[8%] p-3 border">Unit</th>
					<th class="w-[10%] p-3 border text-right">Price</th>
					<th class="w-[8%] p-3 border text-right">Dis 1(%)</th>
					<th class="w-[8%] p-3 border text-right">Dis</th>
					<!-- <th class="w-[8%] p-3 border text-right">Dis 2(%)</th>
					<th class="w-[8%] p-3 border text-right">Dis</th>
					<th class="w-[10%] p-3 border text-right">Unit Price</th> -->
					<th class="w-[12%] p-3 border text-right">Total</th>
				</tr>
			</thead>

			<tbody>
				<?php $i = 5000;
				foreach ($records2 as $r) { ?>
					<tr class="hover:bg-gray-50">

						<td class="p-2 border">
							<input type="text"
								class="w-full border rounded px-2 py-1"
								name="item_model[]"
								value="<?php echo $r->part_name; ?>" />
							<input type="hidden"
								name="item_id[]"
								value="<?php echo $r->part_id; ?>" />
						</td>



						<td class="p-2 border">
							<input type="text"
								class="w-full border rounded px-2 py-1"
								name="item_description[]"
								value="<?php echo $r->part_name; ?>" />
						</td>

						<td class="p-2 border">
							<input type="number"
								class="w-full border rounded px-2 py-1 text-right qty"
								name="item_quantity[]"
								id="item_quantity<?php echo $i; ?>"
								value="<?php echo $r->quantity; ?>" />
						</td>

						<td class="p-2 border">
							<select class="w-full border rounded px-2 py-1"
								name="item_unit[]">
								<option value=''>Select</option>
								<?php foreach ($active_units as $unit) { ?>
									<option <?php if ($r->unit_id == $unit->unit_id) echo 'selected'; ?>
										value='<?php echo $unit->unit_id ?>'>
										<?php echo $unit->unit_name; ?>
									</option>
								<?php } ?>
							</select>
						</td>

						<td class="p-2 border">
							<input type="number"
								class="w-full border rounded px-2 py-1 text-right unit_price"
								name="unit_price[]"
								id="unit_price<?php echo $i; ?>"
								value="<?php echo $r->price; ?>" />
						</td>

						<td class="p-2 border">
							<input type="number"
								class="w-full border rounded px-2 py-1 text-right dis_per"
								id="discount_per<?php echo $i; ?>"
								name="dis_per[]"
								value="<?php echo $r->dis_per; ?>" />
						</td>

						<td class="p-2 border">
							<input type="number"
								class="w-full border rounded px-2 py-1 text-right dis_amt"
								id="discount_amt<?php echo $i; ?>"
								name="dis_amt[]"
								value="<?php echo $r->dis_amt; ?>" />
						</td>





						<td class="p-2 border">
							<input type="number"
								class="w-full border rounded px-2 py-1 text-right total_price"
								id="total_price<?php echo $i; ?>"
								name="total_price[]"
								value="<?php echo $r->total; ?>" />
						</td>

					</tr>
				<?php $i++;
				} ?>
			</tbody>
		</table>

	</div>

	<div class="bg-white shadow rounded-xl p-6 space-y-8 mt-6">

		<!-- Totals Row -->
		<div class="grid grid-cols-12 gap-4 items-end">

			<div class="col-span-12 md:col-span-2">
				<label class="block text-sm font-medium mb-1">Sub Total</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-right"
					name="sub_total" id="sub_total"
					value="<?php echo $records1[0]->sub_total; ?>" readonly>
			</div>

			<div class="col-span-6 md:col-span-1">
				<label class="block text-sm font-medium mb-1">Discount(%)</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 text-right"
					name="discount_per" id="discount_per"
					value="<?php echo $records1[0]->discount_percent; ?>">
			</div>

			<div class="col-span-6 md:col-span-1">
				<label class="block text-sm font-medium mb-1 invisible">Amount</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 text-right"
					name="discount_amt" id="discount_amt"
					value="<?php echo $records1[0]->discount; ?>">
			</div>

			<div class="col-span-6 md:col-span-1">
				<label class="block text-sm font-medium mb-1">VAT(%)</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 text-right"
					name="vat_per" id="vat_per"
					value="<?php echo $records1[0]->vat_percent; ?>">
			</div>

			<div class="col-span-6 md:col-span-1">
				<label class="block text-sm font-medium mb-1 invisible">VAT Amt</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 text-right"
					name="vat_amount" id="vat_amount"
					value="<?php echo $records1[0]->vat_amt; ?>">
			</div>

			<div class="col-span-12 md:col-span-2">
				<label class="block text-sm font-semibold mb-1">Grand Total</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 font-semibold bg-gray-100 text-right"
					name="grand_total" id="grand_total"
					value="<?php echo $records1[0]->grand_total; ?>">
			</div>

		</div>


		<!-- Charges Row -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Transportation Charge</label>
				<input type="number"
					class="w-full border rounded-lg px-3 py-2 text-right"
					name="transportation_charge" id="transportation_charge"
					value="<?php echo $records1[0]->trans_charge; ?>">
			</div>

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Freight Charge</label>
				<input type="number"
					class="w-full border rounded-lg px-3 py-2 text-right"
					name="customs_charge" id="customs_charge"
					value="<?php echo $records1[0]->cust_charge; ?>">
			</div>

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Other Charges</label>
				<input type="number"
					class="w-full border rounded-lg px-3 py-2 text-right"
					name="other_charge" id="other_charge"
					value="<?php echo $records1[0]->add_charge; ?>">
			</div>

		</div>


		<!-- Terms Row -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Validity</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="validity" id="validity"
					value="<?php echo $records1[0]->validity; ?>">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Payment Terms</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="payment_terms" id="payment_terms"
					value="<?php echo $records1[0]->payment_term; ?>">
			</div>

		</div>

		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Delivery Terms</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="delivery_terms" id="delivery_terms"
					value="<?php echo $records1[0]->delivery_term; ?>">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">General Terms</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="general_terms" id="general_terms"
					value="<?php echo $records1[0]->general_term; ?>">
			</div>

		</div>


		<!-- Prepared / Requested -->
		<div class="grid grid-cols-12 gap-4 items-end">

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Prepared By</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="sales_person" id="sales_person">
			</div>

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Requested By</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="request_by" id="request_by"
					value="<?php echo $records1[0]->request_by; ?>">
			</div>

			<div class="col-span-12 md:col-span-6 flex justify-end gap-3 pt-6">
				<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_order_list"
					class="inline-block px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-center">
					Cancel
				</a>

				<button type="submit"
					class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
					Submit
				</button>
			</div>

		</div>

	</div>






	<script>
		$(document).ready(function() {
			// Event listener for input changes
			$(document).on('input change', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function() {
				var row_id = $(this).closest('tr');

				calculateRow(row_id);
				calculateAll();
			});
			// Event listener for global discount, VAT, and extra charges
			$('#discount_per, #discount_amt, #vat_per, #transportation_charge, #customs_charge, #other_charge').on('input change', function() {
				calculateAll();
			});

			function calculateRow($row) {
				var qty = parseFloat($row.find('.qty').val()) || 0;
				var price = parseFloat($row.find('.unit_price').val()) || 0;

				var disPer1 = parseFloat($row.find('.dis_per').val()) || 0;
				var disAmt1 = parseFloat($row.find('.dis_amt').val()) || 0;

				var disPer2 = parseFloat($row.find('.dis_per2').val()) || 0;
				var disAmt2 = parseFloat($row.find('.dis_amt2').val()) || 0;

				var rowTotal = qty * price;

				// First Discount
				if ($row.find('.dis_per').is(':focus')) {
					disAmt1 = (rowTotal * disPer1) / 100;
					$row.find('.dis_amt').val(disAmt1.toFixed(2));
				} else if ($row.find('.dis_amt').is(':focus')) {
					disPer1 = rowTotal === 0 ? 0 : (disAmt1 / rowTotal) * 100;
					$row.find('.dis_per').val(disPer1.toFixed(2));
				} else {
					disAmt1 = (rowTotal * disPer1) / 100;
					$row.find('.dis_amt').val(disAmt1.toFixed(2));
				}

				var subtotalAfterFirst = rowTotal - disAmt1;

				// Second Discount
				if ($row.find('.dis_per2').is(':focus')) {
					disAmt2 = (subtotalAfterFirst * disPer2) / 100;
					$row.find('.dis_amt2').val(disAmt2.toFixed(2));
				} else if ($row.find('.dis_amt2').is(':focus')) {
					disPer2 = subtotalAfterFirst === 0 ? 0 : (disAmt2 / subtotalAfterFirst) * 100;
					$row.find('.dis_per2').val(disPer2.toFixed(2));
				} else {
					disAmt2 = (subtotalAfterFirst * disPer2) / 100;
					$row.find('.dis_amt2').val(disAmt2.toFixed(2));
				}

				var finalRowTotal = subtotalAfterFirst - disAmt2;

				// Final Unit Price
				var finalUnitPrice = (qty > 0) ? finalRowTotal / qty : 0;
				$row.find('.final_unit_price').val(finalUnitPrice.toFixed(2));

				$row.find('.total_price').val(finalRowTotal.toFixed(2));
			}

			function calculateAll() {
				var subtotal = 0;

				// Calculate subtotal from all rows
				$('tbody tr').each(function() {
					subtotal += parseFloat($(this).find('.total_price').val()) || 0;
				});

				$('#sub_total').val(subtotal.toFixed(2));

				// ----- Global Discount -----
				var discountPer = parseFloat($('#discount_per').val()) || 0;
				var discountAmt = parseFloat($('#discount_amt').val()) || 0;

				if ($('#discount_per').is(':focus')) {
					discountAmt = (subtotal * discountPer) / 100;
					$('#discount_amt').val(discountAmt.toFixed(2));
				} else if ($('#discount_amt').is(':focus')) {
					discountPer = (subtotal === 0) ? 0 : (discountAmt / subtotal) * 100;
					$('#discount_per').val(discountPer.toFixed(2));
				} else {
					discountAmt = (subtotal * discountPer) / 100;
					$('#discount_amt').val(discountAmt.toFixed(2));
				}

				var afterDiscount = subtotal - discountAmt;

				// ----- VAT -----
				var vatPer = parseFloat($('#vat_per').val()) || 0;
				var vatAmt = (afterDiscount * vatPer) / 100;
				$('#vat_amount').val(vatAmt.toFixed(2));

				var grandTotal = afterDiscount + vatAmt;

				// ----- Additional Charges -----
				var transportCharge = parseFloat($('#transportation_charge').val()) || 0;
				var freightCharge = parseFloat($('#customs_charge').val()) || 0;
				var otherCharge = parseFloat($('#other_charge').val()) || 0;

				grandTotal += transportCharge + freightCharge + otherCharge;

				// Update Grand Total
				$('#grand_total').val(grandTotal.toFixed(2));
			}
		});
	</script>
