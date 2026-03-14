<?php
$page_name2 = 'Purchase/purchase_order_list';
$user = $this->session->userdata('user_id');
?>

<!-- Header -->
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<h1 class="text-xl font-medium text-gray-700">
		Edit Purchase Order
	</h1>

	<a href="<?php echo base_url() . 'index.php/' . $page_name2; ?>"
		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
		List
	</a>

</div>


<form id="main"
	method="post"
	action="<?php echo base_url() . 'index.php/'; ?>Purchase/update_purchase_order"
	autocomplete="off"
	enctype="multipart/form-data">


	<div class="bg-white shadow rounded-b-lg p-4">


		<!-- Row 1 -->
		<div class="grid grid-cols-12 gap-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium">
				Quotation
			</label>

			<div class="col-span-12 md:col-span-3">

				<select class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					name="quotation_id"
					id="quotation_id"
					required
					onchange="get_quotation_info()">

					<option value="<?php echo $records1[0]->qtn_id ?>">
						<?php echo $records1[0]->quotation_code; ?>
					</option>

				</select>

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">
				PO Code
			</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					name="po_code"
					id="po_code"
					readonly
					value="<?php echo $records1[0]->po_code; ?>">

				<input type="hidden"
					name="po_id"
					id="po_id"
					value="<?php echo $records1[0]->po_id; ?>">

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">
				PO Date
			</label>

			<div class="col-span-12 md:col-span-2">

				<input type="date"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="po_date"
					id="po_date"
					value="<?php echo $records1[0]->po_date; ?>">

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
					value="<?php echo $records1[0]->supplier_name; ?>"
					readonly>

				<input type="hidden"
					name="supplier_id"
					id="supplier_id"
					value="<?php echo $records1[0]->supplier_id; ?>">

			</div>


			<label class="col-span-12 md:col-span-1">
				Reference
			</label>

			<div class="col-span-12 md:col-span-2">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="ref_no"
					id="ref_no"
					value="<?php echo $records1[0]->supplier_ref; ?>">

			</div>

		</div>


		<!-- Row 3 -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2">
				Subject
			</label>

			<div class="col-span-12 md:col-span-7">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="subject"
					id="subject"
					value="<?php echo $records1[0]->subject; ?>">

			</div>


			<label class="col-span-12 md:col-span-1">
				Freight Mode
			</label>

			<div class="col-span-12 md:col-span-2">

				<select class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="freight_mode"
					id="freight_mode">

					<option <?php if ($records1[0]->freight_mode == "Sea") echo "selected" ?> value="Sea">Sea</option>
					<option <?php if ($records1[0]->freight_mode == "Air") echo "selected" ?> value="Air">Air</option>
					<option <?php if ($records1[0]->freight_mode == "Road") echo "selected" ?> value="Road">Road</option>
					<option <?php if ($records1[0]->freight_mode == "Courier") echo "selected" ?> value="Courier">Courier</option>

				</select>

			</div>

		</div>


		<!-- Upload -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2">
				Upload Document
			</label>

			<div class="col-span-12 md:col-span-4">

				<input type="file"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="po_doc"
					id="po_doc">

			</div>


			<div class="col-span-12 md:col-span-4">

				<?php if (!empty($po_doc[0]->doc_path)) { ?>

					<a href="<?php echo base_url('public/uploaded_documents/' . $po_doc[0]->doc_path); ?>"
						class="text-blue-600 hover:underline"
						target="_blank">

						<?php echo $po_doc[0]->doc_path; ?>

					</a>

				<?php } ?>

			</div>

		</div>


		<!-- Items Table -->
		<div class="mt-6 overflow-x-auto">

			<div id="rfq_items_list">

				<table id="datatable-responsive"
					class="min-w-full border border-gray-200 text-sm">

					<thead class="bg-gray-100">

						<tr>

							<th class="border px-3 py-2">Product Code</th>

							<th class="border px-3 py-2">Description</th>
							<th class="border px-3 py-2">Quantity</th>
							<th class="border px-3 py-2">Unit</th>
							<th class="border px-3 py-2">Price</th>
							<th class="border px-3 py-2">Dis 1(%)</th>
							<th class="border px-3 py-2">Dis</th>
							<th class="border px-3 py-2">Dis 2(%)</th>
							<th class="border px-3 py-2">Dis</th>
							<th class="border px-3 py-2">Unit Price</th>
							<th class="border px-3 py-2">Total</th>

						</tr>

					</thead>

					<tbody>

						<?php
						$i = 5000;
						foreach ($records2 as $r) { ?>

							<tr>

								<td class="border p-1">
									<input type="text"
										class="form-control w-full border rounded px-2 py-1"
										name="item_model[]"
										value="<?php echo $r->part_name; ?>">
									<input type="hidden"
										name="item_id[]"
										value="<?php echo $r->part_id; ?>">
								</td>



								<td class="border p-1">
									<input type="text"
										class="form-control w-full border rounded px-2 py-1"
										name="item_description[]"
										value="<?php echo $r->part_name; ?>">
								</td>

								<td class="border p-1">
									<input type="number"
										class="form-control qty w-full border rounded px-2 py-1"
										name="item_quantity[]"
										value="<?php echo $r->quantity; ?>">
								</td>

								<td class="border p-1">

									<select class="form-control w-full border rounded px-2 py-1"
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

								<td class="border p-1">
									<input type="number"
										class="form-control unit_price w-full border rounded px-2 py-1"
										name="unit_price[]"
										value="<?php echo $r->price; ?>">
								</td>

								<td class="border p-1">
									<input type="number"
										class="form-control dis_per w-full border rounded px-2 py-1"
										name="dis_per[]"
										value="<?php echo $r->dis_per; ?>">
								</td>

								<td class="border p-1">
									<input type="number"
										class="form-control dis_amt w-full border rounded px-2 py-1"
										name="dis_amt[]"
										value="<?php echo $r->dis_amt; ?>">
								</td>

								<td class="border p-1">
									<input type="number"
										class="form-control dis_per2 w-full border rounded px-2 py-1"
										name="dis_per2[]"
										value="<?php echo $r->dis_per2; ?>">
								</td>

								<td class="border p-1">
									<input type="number"
										class="form-control dis_amt2 w-full border rounded px-2 py-1"
										name="dis_amt2[]"
										value="<?php echo $r->dis_amt2; ?>">
								</td>

								<td class="border p-1">
									<input type="number"
										class="form-control final_unit_price w-full border rounded px-2 py-1"
										name="final_unit_price[]"
										value="<?php echo $r->unit_price; ?>">
								</td>

								<td class="border p-1">
									<input type="number"
										class="form-control total_price w-full border rounded px-2 py-1"
										name="total_price[]"
										value="<?php echo $r->total; ?>">
								</td>

							</tr>

						<?php } ?>

					</tbody>

				</table>

			</div>

		</div>

		<!-- <br><br><br><br> -->

		<div class="bg-white rounded-lg shadow p-4 space-y-6">

			<!-- Row 1 -->
			<div class="grid grid-cols-12 gap-4 items-center">

				<label class="col-span-2 text-sm font-medium text-gray-700">Sub Total</label>
				<div class="col-span-2">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none"
						name="sub_total"
						id="sub_total"
						value="<?php echo $records1[0]->sub_total; ?>"
						readonly>
				</div>

				<label class="col-span-2 text-sm font-medium text-gray-700">Discount(%)</label>
				<div class="col-span-1">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="discount_per"
						id="discount_per"
						value="<?php echo $records1[0]->discount_percent; ?>">
				</div>

				<div class="col-span-1">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="discount_amt"
						id="discount_amt"
						value="<?php echo $records1[0]->discount; ?>">
				</div>

				<label class="col-span-1 text-sm font-medium text-gray-700">VAT(%)</label>
				<div class="col-span-1">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="vat_per"
						id="vat_per"
						value="<?php echo $records1[0]->vat_percent; ?>">
				</div>

				<div class="col-span-1">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="vat_amount"
						id="vat_amount"
						value="<?php echo $records1[0]->vat_amt; ?>">
				</div>

				<label class="col-span-1 text-sm font-medium text-gray-700">Grand Total</label>
				<div class="col-span-2">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 font-semibold bg-green-50 focus:ring-2 focus:ring-green-500"
						name="grand_total"
						id="grand_total"
						value="<?php echo $records1[0]->grand_total; ?>">
				</div>

			</div>

			<!-- Row 2 -->
			<div class="grid grid-cols-12 gap-4 items-center">

				<label class="col-span-2 text-sm font-medium text-gray-700">Transportation Charge</label>
				<div class="col-span-2">
					<input type="number"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="transportation_charge"
						id="transportation_charge"
						value="<?php echo $records1[0]->trans_charge; ?>">
				</div>

				<label class="col-span-2 text-sm font-medium text-gray-700">Freight Charge</label>
				<div class="col-span-2">
					<input type="number"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="customs_charge"
						id="customs_charge"
						value="<?php echo $records1[0]->cust_charge; ?>">
				</div>

				<label class="col-span-2 text-sm font-medium text-gray-700">Other Charges</label>
				<div class="col-span-2">
					<input type="number"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="other_charge"
						id="other_charge"
						value="<?php echo $records1[0]->add_charge; ?>">
				</div>

			</div>

			<!-- Row 3 -->
			<div class="grid grid-cols-12 gap-4 items-center">

				<label class="col-span-2 text-sm font-medium text-gray-700">Validity</label>
				<div class="col-span-4">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="validity"
						id="validity"
						value="<?php echo $records1[0]->validity; ?>">
				</div>

				<label class="col-span-2 text-sm font-medium text-gray-700">Payment Terms</label>
				<div class="col-span-4">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="payment_terms"
						id="payment_terms"
						value="<?php echo $records1[0]->payment_term; ?>">
				</div>

			</div>

			<!-- Row 4 -->
			<div class="grid grid-cols-12 gap-4 items-center">

				<label class="col-span-2 text-sm font-medium text-gray-700">Delivery Terms</label>
				<div class="col-span-4">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="delivery_terms"
						id="delivery_terms"
						value="<?php echo $records1[0]->delivery_term; ?>">
				</div>

				<label class="col-span-2 text-sm font-medium text-gray-700">General Terms</label>
				<div class="col-span-4">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
						name="general_terms"
						id="general_terms"
						value="<?php echo $records1[0]->general_term; ?>">
				</div>

			</div>

		</div>



		<!-- Submit -->
		<div class="mt-6 flex gap-3">

			<div class="grid grid-cols-12 gap-4 items-center">

				<!-- Prepared By -->
				<label class="col-span-2 text-sm font-medium text-gray-700">
					Prepared By
				</label>

				<div class="col-span-4">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 text-gray-700 focus:outline-none"
						name="sales_person"
						id="sales_person"
						value="<?php echo $this->session->userdata('user_name'); ?>"
						readonly>
				</div>

				<!-- Requested By -->
				<label class="col-span-2 text-sm font-medium text-gray-700">
					Requested By
				</label>

				<div class="col-span-4">
					<input type="text"
						class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
						name="request_by"
						id="request_by"
						value="<?php echo $records1[0]->request_by; ?>">
				</div>

			</div>

			<button type="button"
				onclick="window.history.back();"
				class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">

				Cancel

			</button>

			<button type="submit"
				class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">

				Submit

			</button>

		</div>


	</div>

</form>


<!-- SCRIPT PORTION (UNCHANGED) -->
<script>
	function get_quotation_info() {
		var quotation_id = document.getElementById("quotation_id").value;

		if (quotation_id != '') {

			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_quote_info",
				data: {
					quotation_id: quotation_id
				},
				dataType: "json",

				success: function(msg) {

					document.getElementById("supplier_id").value = msg.supplier_id;
					document.getElementById("supplier_name").value = msg.supplier_code + ' ' + msg.supplier_name;

					get_quote_items_list(quotation_id);

					document.getElementById("sub_total").value = msg.subtotal;
					document.getElementById("discount_per").value = msg.discount_percent;
					document.getElementById("discount_amt").value = msg.discount;
					document.getElementById("vat_per").value = msg.vat_percent;
					document.getElementById("vat_amount").value = msg.vat_amt;
					document.getElementById("grand_total").value = msg.grand_total;

					document.getElementById("validity").value = msg.validity;
					document.getElementById("payment_terms").value = msg.payment_term;
					document.getElementById("delivery_terms").value = msg.delivery_term;
					document.getElementById("general_terms").value = msg.general_term;

				}

			});

		} else {

			document.getElementById('quote_items_list').innerHTML = '';

		}

	}

	function get_quote_items_list(quotation_id) {

		$.ajax({

			type: "POST",

			url: "<?php echo base_url() ?>index.php/Ajax/get_quote_items_for_po",

			data: {
				quotation_id: quotation_id
			},

			success: function(msg) {

				document.getElementById('quote_items_list').innerHTML = msg;

			}

		});

	}

	$(document).ready(function() {

		// Event listener for input changes

		$(document).on('input change',
			'.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2',
			function() {

				var row_id = $(this).closest('tr');

				calculateRow(row_id);

				calculateAll();

			});

		// Event listener for global discount, VAT, and extra charges

		$('#discount_per, #discount_amt, #vat_per, #transportation_charge, #customs_charge, #other_charge')
			.on('input change', function() {

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

			$('tbody tr').each(function() {

				subtotal += parseFloat($(this).find('.total_price').val()) || 0;

			});

			$('#sub_total').val(subtotal.toFixed(2));

			// Discount

			var discountPer = parseFloat($('#discount_per').val()) || 0;

			var discountAmt = parseFloat($('#discount_amt').val()) || 0;

			if ($('#discount_per').is(':focus')) {

				discountAmt = (subtotal * discountPer) / 100;

				$('#discount_amt').val(discountAmt.toFixed(2));

			} else if ($('#discount_amt').is(':focus')) {

				discountPer = subtotal === 0 ? 0 : (discountAmt / subtotal) * 100;

				$('#discount_per').val(discountPer.toFixed(2));

			} else {

				discountAmt = (subtotal * discountPer) / 100;

				$('#discount_amt').val(discountAmt.toFixed(2));

			}

			var afterDiscount = subtotal - discountAmt;

			// VAT

			var vatPer = parseFloat($('#vat_per').val()) || 0;

			var vatAmt = (afterDiscount * vatPer) / 100;

			$('#vat_amount').val(vatAmt.toFixed(2));

			var grandTotal = afterDiscount + vatAmt;

			// Additional Charges

			var transportCharge = parseFloat($('#transportation_charge').val()) || 0;

			var freightCharge = parseFloat($('#customs_charge').val()) || 0;

			var otherCharge = parseFloat($('#other_charge').val()) || 0;

			grandTotal += transportCharge + freightCharge + otherCharge;

			$('#grand_total').val(grandTotal.toFixed(2));

		}

	});
</script>
