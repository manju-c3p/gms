<?php
$page_name2 = 'Purchase/purchase_quotation_list';
$user = $this->session->userdata('user_id');
?>

<!-- Header -->
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<h1 class="text-xl font-medium text-gray-700">
		Edit Purchase Quotation
	</h1>

	<a href="<?php echo base_url() . 'index.php/' . $page_name2; ?>"
		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
		List
	</a>

</div>


<form id="main" method="post"
	action="<?php echo base_url() . 'index.php/'; ?>Purchase/update_purchase_quotation"
	autocomplete="off"
	enctype="multipart/form-data">


	<div class="bg-white shadow rounded-b-lg p-4">

		<!-- Row 1 -->
		<div class="grid grid-cols-12 gap-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium">Select RFQ</label>

			<div class="col-span-12 md:col-span-3">
				<select tabindex="1"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					id="rfq_id"
					name="rfq_id"
					readonly>

					<option value="<?php echo $records1[0]->rfq_id ?>">
						<?php echo $records1[0]->rfq_code; ?>
					</option>

				</select>
			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">Code</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					name="quotation_code"
					id="quotation_code"
					readonly
					value="<?php echo $records1[0]->quotation_code; ?>">

				<input type="hidden"
					name="quotation_id"
					id="quotation_id"
					value="<?php echo $records1[0]->quotation_id; ?>">

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">Date</label>

			<div class="col-span-12 md:col-span-2">

				<input type="date"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="quotation_date"
					id="quotation_date"
					value="<?php echo  $records1[0]->quotation_date; ?>">

			</div>

		</div>


		<!-- Row 2 -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium">Supplier</label>

			<div class="col-span-12 md:col-span-4">

				<input type="text"
					readonly
					name="supplier_name"
					id="supplier_name"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					value="<?php echo $records1[0]->supplier_name; ?>">

				<input type="hidden"
					name="supplier_id"
					id="supplier_id"
					value="<?php echo $records1[0]->supplier_id; ?>">

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">Reference</label>

			<div class="col-span-12 md:col-span-4">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="ref_no"
					id="ref_no"
					value="<?php echo $records1[0]->reference; ?>">

			</div>

		</div>


		<!-- Row 3 -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium">Project Name</label>

			<div class="col-span-12 md:col-span-4">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="project"
					id="project"
					value="<?php echo $records1[0]->project; ?>">

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">Doc Upload</label>

			<div class="col-span-12 md:col-span-4">

				<input type="file"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="quote_doc"
					id="quote_doc">

				<?php if (!empty($quote_doc[0]->doc_path)) { ?>

					<a class="text-blue-600 hover:underline text-sm"
						href="<?php echo base_url('public/uploaded_documents/' . $quote_doc[0]->doc_path); ?>"
						target="_blank">

						<?php echo $quote_doc[0]->doc_path; ?>

					</a>

				<?php } ?>

			</div>

		</div>


		<!-- Items Table -->
		<div class="mt-6 overflow-x-auto">

			<div id="rfq_items_list">

				<table class="min-w-full border border-gray-200 text-sm">

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


					<tbody class="text-sm">

						<?php $i = 5000;
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

									<select class="form-control select2 w-full border rounded px-2 py-1"
										name="item_unit[]">

										<option value="">Select</option>

										<?php foreach ($active_units as $unit) { ?>

											<option <?php if ($r->unit_id == $unit->unit_id) echo 'selected'; ?>
												value="<?php echo $unit->unit_id ?>">

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

						<?php $i++;
						} ?>

					</tbody>

				</table>

			</div>

		</div>


		<!-- Totals -->
		<div class="grid grid-cols-12 gap-4 mt-6">

			<label class="col-span-12 md:col-span-2">Taxable Amount</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2 bg-gray-100"
				name="sub_total"
				id="sub_total"
				value="<?php echo $records1[0]->subtotal; ?>">


			<label class="col-span-12 md:col-span-1">VAT(%)</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="vat_per"
				id="vat_per"
				value="<?php echo $records1[0]->vat_percent; ?>">


			<label class="col-span-12 md:col-span-1">Tax Amount</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="vat_amount"
				id="vat_amount"
				value="<?php echo $records1[0]->vat_amt; ?>">


			<label class="col-span-12 md:col-span-1">Grand Total</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
				name="grand_total"
				id="grand_total"
				value="<?php echo $records1[0]->grand_total; ?>">

		</div>


		<!-- Submit -->
		<div class="mt-6">

			<button type="submit"
				class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">

				Update

			</button>

		</div>


	</div>

</form>

<script>
	function get_enquiry_info() {
		var rfq_id = document.getElementById("rfq_id").value;

		if (rfq_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_rfq_info",
				data: {
					rfq_id: rfq_id
				},
				dataType: "json",
				success: function(msg) {
					document.getElementById("supplier_id").value = msg.supplier_id;
					document.getElementById("supplier_name").value = msg.supplier_code + ' ' + msg.supplier_name;
					get_rfq_items_list(rfq_id);
				}
			});
		} else {
			document.getElementById("enq_code").innerHTML = '';
			document.getElementById("enq_date").value = '';
			document.getElementById("customer_id").value = '';
			document.getElementById("cust_name").value = '';

			document.getElementById('item_list_id').innerHTML = '';
		}
	}

	function get_rfq_items_list(rfq_id) {

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>index.php/Ajax/get_rfq_items_for_quote",
			data: {
				rfq_id: rfq_id
			},
			success: function(msg) {
				document.getElementById('rfq_items_list').innerHTML = msg;
			}
		});

	}


	$(document).ready(function() {
		// Event listener for input changes
		$(document).on('input change', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function() {
			var row_id = $(this).closest('tr');

			calculateRow(row_id);
			calculateAll();
		});

		// Function to calculate row total
		function calculateRow(row_id) {
			var qty = parseFloat(row_id.find('.qty').val()) || 0;
			var price = parseFloat(row_id.find('.unit_price').val()) || 0;

			// First discount
			var disPer1 = parseFloat(row_id.find('.dis_per').val()) || 0;
			var disAmt1 = parseFloat(row_id.find('.dis_amt').val()) || 0;

			// Second discount
			var disPer2 = parseFloat(row_id.find('.dis_per2').val()) || 0;
			var disAmt2 = parseFloat(row_id.find('.dis_amt2').val()) || 0;

			var rowTotal = qty * price;

			// Apply first discount
			if (row_id.find('.dis_per').is(':focus')) {
				disAmt1 = (rowTotal * disPer1) / 100;
				row_id.find('.dis_amt').val(disAmt1.toFixed(2));
			} else if (row_id.find('.dis_amt').is(':focus')) {
				disPer1 = (rowTotal === 0) ? 0 : (disAmt1 / rowTotal) * 100;
				row_id.find('.dis_per').val(disPer1.toFixed(2));
			} else {
				disAmt1 = (rowTotal * disPer1) / 100;
				row_id.find('.dis_amt').val(disAmt1.toFixed(2));
			}

			var subtotalAfterFirstDiscount = rowTotal - disAmt1;

			// Apply second discount
			if (row_id.find('.dis_per2').is(':focus')) {
				disAmt2 = (subtotalAfterFirstDiscount * disPer2) / 100;
				row_id.find('.dis_amt2').val(disAmt2.toFixed(2));
			} else if (row_id.find('.dis_amt2').is(':focus')) {
				disPer2 = (subtotalAfterFirstDiscount === 0) ? 0 : (disAmt2 / subtotalAfterFirstDiscount) * 100;
				row_id.find('.dis_per2').val(disPer2.toFixed(2));
			} else {
				disAmt2 = (subtotalAfterFirstDiscount * disPer2) / 100;
				row_id.find('.dis_amt2').val(disAmt2.toFixed(2));
			}

			var finalRowTotal = subtotalAfterFirstDiscount - disAmt2;
			row_id.find('.total_price').val(finalRowTotal.toFixed(2));
		}

		// Function to calculate all rows total
		function calculateAll() {
			var grandTotal = 0;
			$('tbody tr').each(function() {
				var rowTotal = parseFloat($(this).find('.total_price').val()) || 0;
				grandTotal += rowTotal;
			});

			// Apply VAT
			var vatPer = parseFloat($('#vat_per').val()) || 0;
			var vatAmount = (grandTotal * vatPer) / 100;

			// Calculate grand total
			var grandTotalWithVAT = grandTotal + vatAmount;
			$('#grand_total').val(grandTotalWithVAT.toFixed(2));
		}


	});
</script>
