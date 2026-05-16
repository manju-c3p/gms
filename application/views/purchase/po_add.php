   <!-- page content -->
   <!-- Header -->
   <div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

   	<!-- Caption -->
   	<h1 class="text-xl font-medium text-gray-700">
   		Add Purchase Order
   	</h1>

   	<!-- List Button -->
   	<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_order_list"
   		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">

   		List

   	</a>

   </div>


   <form id="main"
   	method="post"
   	action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_po_records"
   	autocomplete="off"
   	enctype="multipart/form-data">


   	<div class="bg-white shadow rounded-b-lg p-4">


   		<!-- Row 1 -->
   		<div class="grid grid-cols-12 gap-4">

   			<label class="col-span-12 md:col-span-2 text-sm font-medium">
   				Select Quotation
   			</label>

   			<div class="col-span-12 md:col-span-3">

   				<select class="form-control w-full border border-gray-300 rounded px-3 py-2"
   					name="quotation_id"
   					id="quotation_id"
   					required
   					onchange="get_quotation_info()">

   					<option value="">Select</option>

   					<?php foreach ($records as $s) { ?>

   						<option value="<?php echo $s->quotation_id ?>">
   							<?php echo $s->quotation_code; ?>
   						</option>

   					<?php } ?>

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
   					value="<?php echo $Code; ?>">

   			</div>


   			<label class="col-span-12 md:col-span-1 text-sm font-medium">
   				PO Date
   			</label>

   			<div class="col-span-12 md:col-span-2">

   				<input type="date"
   					class="form-control w-full border border-gray-300 rounded px-3 py-2"
   					name="po_date"
   					id="po_date"
   					value="<?php echo date('Y-m-d'); ?>">

   			</div>

   		</div>


   		<!-- Row 2 -->
   		<div class="grid grid-cols-12 gap-4 mt-4">

   			<label class="col-span-12 md:col-span-2 text-sm font-medium">
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


   			<label class="col-span-12 md:col-span-1 text-sm font-medium">
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

   			<label class="col-span-12 md:col-span-2 text-sm font-medium">
   				Subject
   			</label>

   			<div class="col-span-12 md:col-span-7">

   				<input type="text"
   					class="form-control w-full border border-gray-300 rounded px-3 py-2"
   					name="subject"
   					id="subject">

   			</div>


   			<label class="col-span-12 md:col-span-1 text-sm font-medium">
   				Freight Mode
   			</label>

   			<div class="col-span-12 md:col-span-2">

   				<select class="form-control w-full border border-gray-300 rounded px-3 py-2"
   					name="freight_mode"
   					id="freight_mode">

   					<option value=""></option>
   					<option value="Sea">Sea</option>
   					<option value="Air">Air</option>
   					<option value="Road">Road</option>
   					<option value="Courier">Courier</option>

   				</select>

   			</div>

   		</div>


   		<!-- Row 4 -->
   		<div class="grid grid-cols-12 gap-4 mt-4">

   			<label class="col-span-12 md:col-span-2 text-sm font-medium">
   				Upload Document
   			</label>

   			<div class="col-span-12 md:col-span-4">

   				<input type="file"
   					class="form-control w-full border border-gray-300 rounded px-3 py-2"
   					name="po_doc"
   					id="po_doc">

   			</div>


   			<label class="col-span-12 md:col-span-1 text-sm font-medium">
   				Project Name
   			</label>

   			<div class="col-span-12 md:col-span-4">

   				<input type="text"
   					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
   					name="project"
   					id="project"
   					readonly>

   			</div>

   		</div>


   		<!-- Items -->
   		<div id="quote_items_list"
   			class="mt-6 overflow-x-auto border rounded p-3 bg-gray-50">

   		</div>


   		<!-- Totals -->
   		<div class="grid grid-cols-12 gap-4 mt-6">

   			<label class="col-span-12 md:col-span-1">Sub Total</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2 bg-gray-100"
   				name="sub_total"
   				id="sub_total"
   				readonly>


   			<label class="col-span-12 md:col-span-1">Discount (%)</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
   				name="discount_per"
   				id="discount_per"  oninput="allowOnlyNumbersDecimal(this)">


   			<input type="text"
   				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
   				name="discount_amt"
   				id="discount_amt"  oninput="allowOnlyNumbersDecimal(this)">


   			<label class="col-span-12 md:col-span-1">VAT (%)</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
   				name="vat_per"
   				id="vat_per"  oninput="allowOnlyNumbersDecimal(this)">


   			<input type="text"
   				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
   				name="vat_amount"
   				id="vat_amount"  oninput="allowOnlyNumbersDecimal(this)">

					<label class="col-span-12 md:col-span-1">Round Off</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
   				name="roundoff"
   				id="roundoff"  oninput="allowOnlyNumbersDecimal(this)">



   			<label class="col-span-12 md:col-span-1">Grand Total</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
   				name="grand_total"
   				id="grand_total"  oninput="allowOnlyNumbersDecimal(this)">

   		</div>


   		<!-- Charges -->
   		<div class="grid grid-cols-12 gap-4 mt-4">

   			<label class="col-span-12 md:col-span-2">Transportation Charge</label>

   			<input type="number"
   				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
   				name="transportation_charge"
   				id="transportation_charge">


   			<label class="col-span-12 md:col-span-2">Freight Charge</label>

   			<input type="number"
   				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
   				name="customs_charge"
   				id="customs_charge">


   			<label class="col-span-12 md:col-span-2">Other Charges</label>

   			<input type="number"
   				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
   				name="other_charge"
   				id="other_charge">

   		</div>


   		<!-- Terms -->
   		<div class="grid grid-cols-12 gap-4 mt-4">

   			<label class="col-span-12 md:col-span-2">Validity</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-3 border rounded px-3 py-2"
   				name="validity"
   				id="validity">


   			<label class="col-span-12 md:col-span-2">Payment Terms</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-3 border rounded px-3 py-2"
   				name="payment_terms"
   				id="payment_terms">

   		</div>


   		<!-- Prepared -->
   		<div class="grid grid-cols-12 gap-4 mt-4">

   			<label class="col-span-12 md:col-span-2">Prepared By</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-3 border rounded px-3 py-2 bg-gray-100"
   				name="sales_person"
   				id="sales_person"
   				readonly
   				value="<?php echo $this->session->userdata('user_name'); ?>">


   			<label class="col-span-12 md:col-span-2">Requested By</label>

   			<input type="text"
   				class="form-control col-span-12 md:col-span-3 border rounded px-3 py-2"
   				name="request_by"
   				id="request_by">

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
   					document.getElementById("ref_no").value = msg.reference;
   					document.getElementById("project").value = msg.project;
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
   		// Event listener for row-level changes
   		$(document).on('input change', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function() {
   			var $row = $(this).closest('tr');
   			calculateRow($row);
   			calculateAll();
   		});

   		// Event listener for global discount, VAT, and extra charges #discount_per, 
   		$('#discount_amt, #vat_per, #transportation_charge, #customs_charge, #other_charge').on('input change', function() {
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

	function allowOnlyNumbersDecimal(input) {
		alert("Cvdfgdf");
    // Remove everything except numbers and decimal point
    input.value = input.value.replace(/[^0-9.]/g, '');

    // Prevent multiple decimal points
    let parts = input.value.split('.');
    if (parts.length > 2) {
        input.value = parts[0] + '.' + parts.slice(1).join('');
    }
}
   </script>
