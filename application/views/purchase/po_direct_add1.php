<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<!-- Header -->
   <div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

   	<!-- Caption -->
   	<h1 class="text-xl font-medium text-gray-700">
   		Direct Purchase Order
   	</h1>

   	<!-- List Button -->
   	<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_order_list"
   		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">

   		List

   	</a>

   </div>
<form id="main" method="post"
	action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_po_records"
	autocomplete="off" enctype="multipart/form-data"
	class="space-y-6">

	<!-- Top Section -->
	<div class="bg-white shadow rounded-xl p-6 space-y-6">

		<!-- Row 1 -->
		<div class="grid grid-cols-12 gap-4 items-end">
			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Supplier</label>
				<select class="w-full border rounded-lg px-3 py-2 select2"
					name="supplier_id" id="supplier_id" required>
					<option value="">Select</option>
					<?php foreach ($supplier_records as $s) { ?>
						<option value="<?php echo $s->supplier_id ?>">
							<?php echo $s->supplier_code . "-" . $s->supplier_name; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">PO Code</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2 bg-gray-100"
					name="po_code" id="po_code" readonly
					value="<?php echo $Code; ?>">
			</div>

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">PO Date</label>
				<input type="date" class="w-full border rounded-lg px-3 py-2"
					name="po_date" id="po_date"
					value="<?php echo date('Y-m-d'); ?>">
			</div>
		</div>

		<!-- Row 2 -->
		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Subject</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="subject" id="subject">
			</div>

			<div class="col-span-12 md:col-span-4">
				<!-- <label class="block text-sm font-medium mb-1">Reference</label> -->
				 <label class="block text-sm font-medium mb-1">Invoice No</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="ref_no" id="ref_no">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Freight Mode</label>
				<select class="w-full border rounded-lg px-3 py-2"
					name="freight_mode" id="freight_mode">
					<option value=""></option>
					<option value="Sea">Sea</option>
					<option value="Air">Air</option>
					<option value="Road">Road</option>
					<option value="Courier">Courier</option>
				</select>
			</div>
		</div>

		<!-- Row 3 -->
		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">Project Name</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="project" id="project">
			</div>

			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">Upload File</label>
				<input type="file" class="w-full border rounded-lg px-3 py-2"
					name="po_doc" id="po_doc">
			</div>
		</div>
	</div>

	<!-- Item Table -->
	<div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
		<table id="item_table"
    class="w-full table-fixed text-sm border border-gray-300">

    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="w-[16%] p-3 border text-left">Product Code</th>
            <th class="w-[20%] p-3 border text-left">Description</th>
            <th class="w-[8%] p-3 border text-left">Unit</th>
            <th class="w-[10%] p-3 border text-right">Quantity</th>
            <th class="w-[12%] p-3 border text-right">Price</th>
            <th class="w-[10%] p-3 border text-right">Dis 1(%)</th>
            <th class="w-[10%] p-3 border text-right">Dis</th>
            <th class="w-[12%] p-3 border text-right">Total</th>
            <th class="w-[6%] p-3 border text-center">Actions</th>
        </tr>
    </thead>

    <tbody>
        <tr class="hover:bg-gray-50">

            <td class="p-2 border">
                <select class="w-full border rounded px-2 py-1 item-select2 select2 debtor-select"
                    name="item_id[]" id="item0"
                    onchange="get_item_by_id(0)">
                    <option value="">Select</option>
                    <?php foreach ($active_items as $item) { ?>
                        <option value="<?php echo $item->part_id ?>">
                            <?php echo $item->part_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>

            <td class="p-2 border">
                <input class="w-full border rounded px-2 py-1"
                    type="text" name="item_description[]" id="description0">
            </td>

            <td class="p-2 border">
                <select class="w-full border rounded px-2 py-1"
                    name="item_unit[]" id="unit0">
                    <option value="">Select</option>
                    <?php foreach ($active_units as $unit) { ?>
                        <option value="<?php echo $unit->unit_id ?>">
                            <?php echo $unit->unit_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>

            <td class="p-2 border">
                <input class="w-full border rounded px-2 py-1 quantity text-right"
                    type="number" name="item_quantity[]" id="quantity0">
            </td>

            <td class="p-2 border">
                <input type="number"
                    class="w-full border rounded px-2 py-1 unit_price text-right"
                    name="unit_price[]" id="unit_price0" step="any">
            </td>

            <td class="p-2 border">
                <input type="number"
                    class="w-full border rounded px-2 py-1 dis_per text-right"
                    id="discount_per0" name="dis_per[]" step="any">
            </td>

            <td class="p-2 border">
                <input type="number"
                    class="w-full border rounded px-2 py-1 dis_amt text-right"
                    id="discount_amt0" name="dis_amt[]" step="any">
            </td>

            <td class="p-2 border">
                <input type="number"
                    class="w-full border rounded px-2 py-1 total_price text-right"
                    id="total_price0" name="total_price[]" step="any">
            </td>

            <td class="p-2 border text-center">
                <div class="flex justify-center gap-2">
                    <a href="#" class="addRow text-green-600 hover:text-green-700 text-lg">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    <a href="#" class="deleteRow text-red-600 hover:text-red-700 text-lg">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>

        </tr>
    </tbody>
</table>
	</div>

	<!-- Totals Section -->
	<div class="bg-white shadow rounded-xl p-6 space-y-6">

		<!-- Row 1 -->
		<div class="grid grid-cols-12 gap-4 items-end">

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Sub Total</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2 bg-gray-100"
					name="sub_total" id="sub_total" readonly>
			</div>

			<div class="col-span-6 md:col-span-2">
				<label class="block text-sm font-medium mb-1">Discount(%)</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="discount_per" id="discount_per">
			</div>

			<div class="col-span-6 md:col-span-2">
				<label class="block text-sm font-medium mb-1 invisible">Amount</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="discount_amt" id="discount_amt">
			</div>

			<div class="col-span-6 md:col-span-2">
				<label class="block text-sm font-medium mb-1">VAT(%)</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="vat_per" id="vat_per">
			</div>

			<div class="col-span-6 md:col-span-2">
				<label class="block text-sm font-medium mb-1 invisible">VAT Amount</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="vat_amount" id="vat_amount">
			</div>

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-semibold mb-1">Grand Total</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 bg-gray-100 font-semibold"
					name="grand_total" id="grand_total">
			</div>

		</div>

		<!-- Charges Row -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Transportation Charge</label>
				<input type="number" class="w-full border rounded-lg px-3 py-2"
					name="transportation_charge" id="transportation_charge">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Freight Charge</label>
				<input type="number" class="w-full border rounded-lg px-3 py-2"
					name="customs_charge" id="customs_charge">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Other Charges</label>
				<input type="number" class="w-full border rounded-lg px-3 py-2"
					name="other_charge" id="other_charge">
			</div>

		</div>

		<!-- Terms Row 1 -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">Validity</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="validity" id="validity">
			</div>

			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">Payment Terms</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="payment_terms" id="payment_terms">
			</div>

		</div>

		<!-- Terms Row 2 -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">Delivery Terms</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="delivery_terms" id="delivery_terms">
			</div>

			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">General Terms</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="general_terms" id="general_terms">
			</div>

		</div>

		<!-- Prepared Section -->
		<div class="grid grid-cols-12 gap-4 items-end">

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Prepared By</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 bg-gray-100"
					name="sales_person" id="sales_person"
					value="<?php echo $this->session->userdata('user_name'); ?>"
					readonly>
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="block text-sm font-medium mb-1">Requested By</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="request_by" id="request_by">
			</div>

			<div class="col-span-12 md:col-span-4 flex gap-3 pt-5">
				<button type="submit"
					class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
					Cancel
				</button>

				<button type="submit"
					class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
					Submit
				</button>
			</div>

		</div>

	</div>

	<!-- Bottom Buttons
    <div class="flex justify-end gap-4">
        <button type="submit"
            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
            Cancel
        </button>

        <button type="submit"
            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Submit
        </button>
    </div> -->

</form>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->


<script>
	// $(document).ready(function() {
	// 	initializeSelect2($('#item0'));
	// });
	$(document).ready(function() {
		$('.item-search').select2({
			placeholder: "Search item...",
			width: '100%'
		});
		$('#supplier_id').select2({
			placeholder: "Select supplier",
			allowClear: true,
			width: '100%'
		});
	});

	$(document).ready(function() {
		let rowIndex = 1; // Start from 1 because the first row uses index 0

		// Add new row
		// $(document).on('click', '.addRow', function(e) {
		// 	e.preventDefault();

		// 	const newRow = `
    //         <tr>
    //             <td>
    //                 <select class="form-control item-select2" name="item_id[]" id="item${rowIndex}" onchange="get_item_by_id(${rowIndex})">
    //                     <option value="">Select</option>
    //                     <?php foreach ($active_items as $item) { ?>
    //                         <option value="<?php echo $item->part_id ?>"><?php echo $item->part_name; ?></option>
    //                     <?php } ?>
    //                 </select>
    //             </td>
             
    //             <td><input class="form-control" type="text" name="item_description[]" id="description${rowIndex}"></td>
    //             <td>
    //                 <select class="form-control" name="item_unit[]" id="unit${rowIndex}">
    //                     <option value="">Select</option>
    //                     <?php foreach ($active_units as $unit) { ?>
    //                         <option value="<?php echo $unit->unit_id ?>"><?php echo $unit->unit_name; ?></option>
    //                     <?php } ?>
    //                 </select>
    //             </td>
    //             <td><input class="form-control quantity" type="number" name="item_quantity[]" id="quantity${rowIndex}"></td>
    //             <td><input type="number" class="form-control unit_price" name="unit_price[]" step="any" id="unit_price${rowIndex}" /></td>
    //             <td><input type="number" class="form-control dis_per" name="dis_per[]" step="any" id="discount_per${rowIndex}" /></td>
    //             <td><input type="number" class="form-control dis_amt" name="dis_amt[]" step="any" id="discount_amt${rowIndex}" /></td>
    //             <td><input type="number" class="form-control total_price" name="total_price[]" step="any" id="total_pric${rowIndex}" /></td>
    //             <td>
    //             <a href="#" class="addRow" title="Add"><i class="fa fa-plus-circle text-success"></i></a>
    //             <a href="#" class="deleteRow" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                  
    //             </td>
    //         </tr>`;

		// 	$('#item_table tbody').append(newRow);

		// 	// Reinitialize select2 for new row
		// 	$(`#item${rowIndex}`).select2({
		// 		placeholder: "Search item...",
		// 		width: "100%"
		// 	});
		// 	rowIndex++;
		// });

		$(document).on('click', '.addRow', function(e) {
    e.preventDefault();

    const newRow = `
    <tr>
        <td class="p-2 border">
            <select class="w-full border rounded px-2 py-1 item-select2" 
                name="item_id[]" 
                id="item${rowIndex}" 
                onchange="get_item_by_id(${rowIndex})">
                <option value="">Select</option>
                <?php foreach ($active_items as $item) { ?>
                    <option value="<?php echo $item->part_id ?>">
                        <?php echo $item->part_name; ?>
                    </option>
                <?php } ?>
            </select>
        </td>

        <td class="p-2 border">
            <input class="w-full border rounded px-2 py-1" 
                type="text" 
                name="item_description[]" 
                id="description${rowIndex}">
        </td>

        <td class="p-2 border">
            <select class="w-full border rounded px-2 py-1" 
                name="item_unit[]" 
                id="unit${rowIndex}">
                <option value="">Select</option>
                <?php foreach ($active_units as $unit) { ?>
                    <option value="<?php echo $unit->unit_id ?>">
                        <?php echo $unit->unit_name; ?>
                    </option>
                <?php } ?>
            </select>
        </td>

        <td class="p-2 border">
            <input class="w-full border rounded px-2 py-1 quantity" 
                type="number" 
                name="item_quantity[]" 
                id="quantity${rowIndex}">
        </td>

        <td class="p-2 border">
            <input type="number" 
                class="w-full border rounded px-2 py-1 unit_price" 
                name="unit_price[]" 
                step="any" 
                id="unit_price${rowIndex}" />
        </td>

        <td class="p-2 border">
            <input type="number" 
                class="w-full border rounded px-2 py-1 dis_per" 
                name="dis_per[]" 
                step="any" 
                id="discount_per${rowIndex}" />
        </td>

        <td class="p-2 border">
            <input type="number" 
                class="w-full border rounded px-2 py-1 dis_amt" 
                name="dis_amt[]" 
                step="any" 
                id="discount_amt${rowIndex}" />
        </td>

        <td class="p-2 border">
            <input type="number" 
                class="w-full border rounded px-2 py-1 total_price" 
                name="total_price[]" 
                step="any" 
                id="total_pric${rowIndex}" />
        </td>

        <td class="p-2 border text-center space-x-2">
            <a href="#" class="addRow text-green-600 text-lg" title="Add">
                <i class="fa fa-plus-circle"></i>
            </a>
            <a href="#" class="deleteRow text-red-600 text-lg" title="Delete">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>`;

    $('#item_table tbody').append(newRow);

    // Reinitialize select2 for new row
    $(`#item${rowIndex}`).select2({
        placeholder: "Search item...",
        width: "100%"
    });

    rowIndex++;
});

		// Delete row
		$(document).on('click', '.deleteRow', function(e) {
			e.preventDefault();

			// Remove the row
			$(this).closest('tr').remove();

			// Recalculate totals after row deletion
			calculateAll();
		});

		// Event listener for row-level changes

		// Recalculate when item-related fields change
		$(document).on('input change', '.quantity, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function() {
			var $row = $(this).closest('tr');
			calculateRow($row);
			calculateAll();
		});

		// Recalculate when global discount, VAT, or additional charges change
		$('#discount_per, #discount_amt, #vat_per, #transportation_charge, #customs_charge, #other_charge').on('input change', function() {
			calculateAll();
		});

		// --- Calculate per row ---
		function calculateRow($row) {
			var qty = parseFloat($row.find('.quantity').val()) || 0;
			var price = parseFloat($row.find('.unit_price').val()) || 0;

			var disPer1 = parseFloat($row.find('.dis_per').val()) || 0;
			var disAmt1 = parseFloat($row.find('.dis_amt').val()) || 0;
			var disPer2 = parseFloat($row.find('.dis_per2').val()) || 0;
			var disAmt2 = parseFloat($row.find('.dis_amt2').val()) || 0;

			var rowTotal = qty * price;

			// --- First Discount ---
			if ($row.find('.dis_per').is(':focus')) {
				disAmt1 = (rowTotal * disPer1) / 100;
				$row.find('.dis_amt').val(disAmt1.toFixed(2));
			} else if ($row.find('.dis_amt').is(':focus')) {
				disPer1 = (rowTotal === 0) ? 0 : (disAmt1 / rowTotal) * 100;
				$row.find('.dis_per').val(disPer1.toFixed(2));
			} else {
				disAmt1 = (rowTotal * disPer1) / 100;
				$row.find('.dis_amt').val(disAmt1.toFixed(2));
			}

			var subtotalAfterFirst = rowTotal - disAmt1;

			// --- Second Discount ---
			if ($row.find('.dis_per2').is(':focus')) {
				disAmt2 = (subtotalAfterFirst * disPer2) / 100;
				$row.find('.dis_amt2').val(disAmt2.toFixed(2));
			} else if ($row.find('.dis_amt2').is(':focus')) {
				disPer2 = (subtotalAfterFirst === 0) ? 0 : (disAmt2 / subtotalAfterFirst) * 100;
				$row.find('.dis_per2').val(disPer2.toFixed(2));
			} else {
				disAmt2 = (subtotalAfterFirst * disPer2) / 100;
				$row.find('.dis_amt2').val(disAmt2.toFixed(2));
			}

			var finalRowTotal = subtotalAfterFirst - disAmt2;
			var finalUnitPrice = (qty > 0) ? finalRowTotal / qty : 0;

			$row.find('.final_unit_price').val(finalUnitPrice.toFixed(2));
			$row.find('.total_price').val(finalRowTotal.toFixed(2));
		}

		// --- Calculate overall totals ---
		function calculateAll() {
			var subtotal = 0;

			// Subtotal from all rows
			$('#item_table tbody tr').each(function() {
				subtotal += parseFloat($(this).find('.total_price').val()) || 0;
			});

			$('#sub_total').val(subtotal.toFixed(2));

			// --- Global Discount ---
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

			// --- VAT ---
			var vatPer = parseFloat($('#vat_per').val()) || 0;
			var vatAmt = (afterDiscount * vatPer) / 100;
			$('#vat_amount').val(vatAmt.toFixed(2));

			// --- Additional Charges ---
			var transportCharge = parseFloat($('#transportation_charge').val()) || 0;
			var freightCharge = parseFloat($('#customs_charge').val()) || 0;
			var otherCharge = parseFloat($('#other_charge').val()) || 0;

			// --- Grand Total ---
			var grandTotal = afterDiscount + vatAmt + transportCharge + freightCharge + otherCharge;

			$('#grand_total').val(grandTotal.toFixed(2));
		}

	});
	// ====== INITIALIZE SELECT2 ======
	// function initializeSelect2(element) {
	// 	alert("initialise");
	// 	// Destroy any previous initialization
	// 	if (element.hasClass("select2-hidden-accessible")) {
	// 		element.select2('destroy');
	// 	}

	// 	// Initialize Select2
	// 	element.select2({
	// 		ajax: {
	// 			url: '<?= base_url("index.php/Item/search_items") ?>',
	// 			type: 'POST',
	// 			dataType: 'json',
	// 			delay: 250,
	// 			data: function(params) {
	// 				return {
	// 					search: params.term
	// 				};
	// 			},
	// 			processResults: function(data) {
	// 				return {
	// 					results: data.map(item => ({
	// 						id: item.item_id,
	// 						text: item.item_model
	// 					}))
	// 				};
	// 			},
	// 			cache: true
	// 		},
	// 		placeholder: 'Select Item',
	// 		width: '100%',
	// 		allowClear: true
	// 	});
	// }


	function get_item_by_id(row_no) {
		var item_id = $('#item' + row_no).val();
		if (item_id != '') {
			$.ajax({
				url: '<?= base_url("index.php/SpareParts/get_part") ?>', // update with your controller path
				type: 'POST',
				data: {
					item_id: item_id
				},
				dataType: "json",
				success: function(response) {

					// $('#brand' + row_no).val(response.brand_name);
					$('#description' + row_no).val(response.part_name);
					$('#unit' + row_no).val(response.purchase_unit_id).change();
					$('#unit_price' + row_no).val(response.unit_price);
					$('#unit' + row_no).prop('required', true);
					$('#quantity' + row_no).prop('required', true);
					$('#unit_price' + row_no).prop('required', true);
					$('#quantity' + row_no).prop('required', true);
					// var nextRow = document.getElementById('addr'+row_no).nextElementSibling;

					// if(!nextRow ) 
					//     add_row();

				}
			});
		} else {
			// $('#brand' + row_no).text('');
			$('#description' + row_no).text('');
			$('#unit' + row_no).val('').change();
			$('#unit_price' + row_no).val('');
			$('#unit' + row_no).prop('required', false);
			$('#quantity' + row_no).prop('required', false);
			$('#unit_price' + row_no).prop('required', false);
			$('#quantity' + row_no).prop('required', false);
		}
	}

	$(document).ready(function() {
		$('.debtor-select').select2({
			width: '100%'
		});


	});
</script>
