   <!-- page content -->
   <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_direct_rfq_records" autocomplete="off" enctype="multipart/form-data">

   	<div class="max-w-7xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-6">

   		<!-- Header -->
   		<div class="border-b pb-4 mb-8">
   			<h2 class="text-2xl font-semibold">Create RFQ</h2>
   		</div>

   		<!-- Top Fields -->
   		<div class="grid md:grid-cols-2 gap-6">

   			<!-- RFQ Code -->
   			<div class="grid grid-cols-4 items-center gap-4">
   				<label class="font-semibold text-gray-700">RFQ Code</label>

   				<input type="text"
   					class="col-span-3 border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
   					name="rfq_code"
   					id="rfq_code"
   					readonly
   					value="<?php echo $Code; ?>">
   			</div>

   			<!-- RFQ Date -->
   			<div class="grid grid-cols-4 items-center gap-4">
   				<label class="font-semibold text-gray-700">RFQ Date</label>

   				<input type="date"
   					class="col-span-3 border rounded-lg px-4 py-2"
   					name="rfq_date"
   					id="rfq_date"
   					value="<?php echo date('Y-m-d'); ?>">
   			</div>

   			<!-- Supplier -->
   			<div class="grid grid-cols-4 items-center gap-4">
   				<label class="font-semibold text-gray-700">Select Supplier</label>

   				<select name="supplier_id"
   					id="supplier_id"
   					class="col-span-3 border rounded-lg px-4 py-2 item-select2"
   					required>
   					<option value="">Please select name</option>
   					<option value="1">Supplier 1</option>

   					<?php foreach ($supplier_records as $g) { ?>
   						<option value="<?php echo $g->supplier_id; ?>">
   							<?php echo $g->supplier_code . ' ' . $g->supplier_name; ?>
   						</option>
   					<?php } ?>
   				</select>
   			</div>

   			<!-- Subject -->
   			<div class="grid grid-cols-4 items-center gap-4">
   				<label class="font-semibold text-gray-700">Subject</label>

   				<input type="text"
   					class="col-span-3 border rounded-lg px-4 py-2"
   					name="subject"
   					id="subject">
   			</div>

   			<!-- Project -->
   			<div class="grid grid-cols-4 items-center gap-4 hidden">
   				<label class="font-semibold text-gray-700">Project Name</label>

   				<input type="text"
   					class="col-span-3 border rounded-lg px-4 py-2"
   					name="project"
   					id="project">
   			</div>

   			<!-- Reference -->
   			<div class="grid grid-cols-4 items-center gap-4 hidden">
   				<label class="font-semibold text-gray-700">Reference</label>

   				<input type="text"
   					class="col-span-3 border rounded-lg px-4 py-2"
   					name="ref"
   					id="ref">
   			</div>

   		</div>

   		<!-- Items Table -->
   		<div class="mt-10">

   			<div class="flex justify-between items-center mb-4">
   				<h3 class="text-lg font-semibold">RFQ Items</h3>
   			</div>

   			<div class="overflow-x-auto border rounded-lg">
   				<table id="datatable-responsive" class="min-w-full">

   					<thead class="bg-gray-100">
   						<tr>
   							<th class="p-3 text-left">Product Code</th>
   							<th class="p-3 text-left hidden">Brand</th>
   							<th class="p-3 text-left">Description</th>
   							<th class="p-3 text-left">Unit</th>
   							<th class="p-3 text-left">Quantity</th>
   							<th class="p-3 text-center">Actions</th>
   						</tr>
   					</thead>

   					<tbody>
   						<tr>

   							<td class="p-2">
   								<select class="border rounded-lg px-3 py-2 w-full item-select2"
   									name="item[]"
   									id='item0'
   									onchange='get_item_by_id(0)'>

   									<option value=''>Select</option>

   									<?php foreach ($active_items as $item) { ?>
   										<option value='<?php echo $item->part_id ?>'>
   											<?php echo $item->part_name ?>
   										</option>
   									<?php } ?>

   								</select>
   							</td>

   							<td class="p-2 hidden">
   								<input class="border rounded-lg px-3 py-2 w-full"
   									type="text"
   									name="brand[]"
   									id="brand0">
   							</td>

   							<td class="p-2">
   								<input class="border rounded-lg px-3 py-2 w-full"
   									type="text"
   									name="description[]"
   									id="description0">
   							</td>

   						
   							<td class="p-2">
   								<input type="text"
   									class="border rounded-lg px-3 py-2 w-full bg-gray-100"
   									id="purchase_unit_text0"
   									readonly>

   								<input type="hidden"
   									name="purchase_unit_id[]"
   									id="purchase_unit_id0">
   							</td>

   							<td class="p-2">
   								<input class="border rounded-lg px-3 py-2 w-full"
   									type="number"
   									name="quantity[]"
   									id="quantity0">
   							</td>

   							<td class="p-2 text-center">
   								<button type="button" class="addRow bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">
   									+
   								</button>

   								<button type="button" class="deleteRow bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">
   									-
   								</button>
   							</td>

   						</tr>
   					</tbody>

   				</table>
   			</div>

   		</div>

   		<!-- Remarks -->
   		<div class="mt-10 grid grid-cols-4 gap-4 items-start">

   			<label class="font-semibold text-gray-700">
   				Remarks
   			</label>

   			<textarea class="col-span-3 border rounded-lg px-4 py-2 min-h-[120px]"
   				name="remarks"
   				id="remarks"></textarea>

   		</div>

   		<!-- Submit -->
   		<div class="flex justify-end mt-8 border-t pt-6">
   			<button type="submit"
   				class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow-sm">
   				Submit RFQ
   			</button>
   		</div>

   	</div>
   </form>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


   <script>
   	$(document).ready(function() {
   		$('#supplier_id').select2({
   			placeholder: "Select supplier",
   			allowClear: true,
   			width: '100%'
   		});
   	});

   	function initializeSelect2(selectElement) {
   		selectElement.select2({

   		});
   	}

   	$(document).ready(function() {
   		initializeSelect2($('.item-select2'));
   	});

   	$(document).ready(function() {
   		let rowIndex = 1; // Start from 1 since 0 is already present

   		// Add row
   		$(document).on('click', '.addRow', function(e) {
   			e.preventDefault();
   			const newRow = `
            <tr>
                <td>
                    <select class="form-control select2" name="item[]" id="item${rowIndex}" onchange="get_item_by_id(${rowIndex})">
                        <option value="">Select</option>
                        <?php foreach ($active_items as $item) { ?>
                            <option value="<?php echo $item->item_id ?>"><?php echo $item->item_model; ?></option>
                        <?php } ?>
                    </select>
                </td>
                 <td><input class="form-control" type="text" name="brand[]" id="brand${rowIndex}"></td>
                <td><input class="form-control" type="text" name="description[]" id="description${rowIndex}"></td>
                <td>
                 <select class="form-control select2" name="unit[]" id='unit${rowIndex}'>
                        <option value=''>Select</option><?php foreach ($active_units as $unit) { ?><option value='<?php echo $unit->unit_id ?>'><?php echo $unit->unit_name; ?></option><?php } ?>
                        </select>
                </td>
                <td><input class="form-control" type="number" name="quantity[]" id="quantity${rowIndex}"></td>
                <td>
                    <button class="addRow"><i class="fa fa-plus"></i></button>
                    <button class="deleteRow"><i class="fa fa-search-minus"></i></button>                        
                </td>
            </tr>`;

   			$('#datatable-responsive tbody').append(newRow);
   			$(`#item${rowIndex}`).select2(); // Reinitialize select2 for the new element
   			rowIndex++;
   		});

   		// Delete row
   		$(document).on('click', '.deleteRow', function(e) {
   			e.preventDefault();
   			$(this).closest('tr').remove();
   		});
   	});


   	function get_item_by_id(row_no) {
   		var item_id = $('#item' + row_no).val();
		// alert(item_id);
   		if (item_id != '') {
   			$.ajax({
   				url: '<?= base_url("index.php/SpareParts/get_part") ?>', // update with your controller path
   				type: 'POST',
   				data: {
   					item_id: item_id
   				},
   				dataType: "json",
   				success: function(response) {
// alert(response.purchase_unit_name);
   					// $('#brand' + row_no).val(response.brand_name);
   					$('#description' + row_no).val(response.item_description);
   					$('#unit' + row_no).val(response.purchase_unit_name);
   					// $('#actual_price' + row_no).val(response.mrp_aed);
   					// $('#unit' + row_no).prop('required', true);
   					// $('#quantity' + row_no).prop('required', true);
   					// $('#actual_price' + row_no).prop('required', true);
   					// $('#quantity' + row_no).prop('required', true);
   					var nextRow = document.getElementById('addr' + row_no).nextElementSibling;

   					if (!nextRow)
   						add_row();

   				}
   			});
   		} else {
   			$('#brand' + row_no).text('');
   			$('#description' + row_no).text('');
   			$('#unit' + row_no).val('').change();
   			$('#actual_price' + row_no).val('');
   			$('#unit' + row_no).prop('required', false);
   			$('#quantity' + row_no).prop('required', false);
   			$('#actual_price' + row_no).prop('required', false);
   			$('#quantity' + row_no).prop('required', false);
   		}
   	}
   </script>
