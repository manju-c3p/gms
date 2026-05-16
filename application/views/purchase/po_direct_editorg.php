<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<?php
$ptype = $records1[0]->purchase_type;
?>

<form id="main" method="post"
	action="<?php echo base_url('index.php/Purchase/update_purchase_order'); ?>"
	autocomplete="off" enctype="multipart/form-data"
	class="space-y-6">

	<div class="bg-white shadow rounded-xl p-6 space-y-6">

		<div class="flex items-center justify-between mb-6">
			<h1 class="text-xl font-semibold text-gray-800">Edit Purchase Order</h1>

			<a href="<?php echo base_url('index.php/Purchase/purchase_order_list'); ?>"
				class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
				← Back to List
			</a>
		</div>

		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">Purchase Type</label>

				<input type="text"
					id="purchase_type"
					class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?php echo $ptype; ?>"
					readonly>

				<input type="hidden"
					name="purchase_type"
					value="<?php echo $ptype; ?>">
				<input type="hidden"
					name="po_id"
					value="<?php echo $records1[0]->po_id; ?>">
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">Supplier</label>

				<select name="supplier_id"
					class="w-full border rounded px-3 py-2" required>

					<option value="">Select</option>

					<?php foreach ($supplier_records as $s) { ?>
						<option <?php if ($records1[0]->supplier_id == $s->supplier_id) echo 'selected'; ?>
							value="<?php echo $s->supplier_id; ?>">
							<?php echo $s->supplier_code . ' - ' . $s->supplier_name; ?>
						</option>
					<?php } ?>

				</select>
			</div>

			<div class="col-span-12 md:col-span-4">
				<label class="text-sm">PO Date</label>
				<input type="date"
					name="po_date"
					class="w-full border rounded px-3 py-2"
					value="<?php echo $records1[0]->po_date; ?>">
			</div>

		</div>
		<!-- Row 2 -->
		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Subject</label>
				<input type="text"
					class="w-full border rounded-lg px-3 py-2"
					name="subject"
					id="subject"
					value="<?php echo htmlspecialchars($records1[0]->subject); ?>">
			</div>

			<div class="col-span-12 md:col-span-3">
				<!-- <label class="block text-sm font-medium mb-1">Reference</label> -->
				<label class="block text-sm font-medium mb-1">Invoice No</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="ref_no" id="ref_no" value="<?php echo $records1[0]->supplier_ref; ?>">
			</div>
			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Jobcard No</label>
				<select class="w-full border rounded-lg px-3 py-2"
					name="jobcard_no" id="jobcard_no">
					<option value=""></option>
					<?php foreach ($jobcards as $job) { ?>
						<option value="<?php echo $job->jobcard_id;  ?>" <?php if ($job->jobcard_id == $records1[0]->jobcard_id) { ?> selected <?php } ?>>
							<?php echo $job->jobcard_no; ?>
						</option>
					<?php } ?>

				</select>
			</div>

			<div class="col-span-12 md:col-span-3">
				<label class="block text-sm font-medium mb-1">Freight Mode</label>
				<select class="w-full border rounded-lg px-3 py-2"
					name="freight_mode" id="freight_mode">
					<option value=""></option>
					<option value="Sea" <?php if ($records1[0]->freight_mode == "Sea") { ?> selected <?php } ?>>Sea</option>
					<option value="Air" <?php if ($records1[0]->freight_mode == "Air") { ?> selected <?php } ?>>Air</option>
					<option value="Road" <?php if ($records1[0]->freight_mode == "Road") { ?> selected <?php } ?>>Road</option>
					<option value="Courier" <?php if ($records1[0]->freight_mode == "Courier") { ?> selected <?php } ?>>Courier</option>
				</select>
			</div>
		</div>

		<!-- Row 3 -->
		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">Project Name</label>
				<input type="text" class="w-full border rounded-lg px-3 py-2"
					name="project" id="project" value="<?php echo $records1[0]->project; ?>">
			</div>

			<div class="col-span-12 md:col-span-6">
				<label class="block text-sm font-medium mb-1">Upload File</label>
				<input type="file" class="w-full border rounded-lg px-3 py-2"
					name="po_doc" id="po_doc">

				<?php if (!empty($po_doc) && !empty($po_doc[0]->doc_path)) { ?>

					<a title="View Document"
						href="<?= base_url('uploads/podocuments/' . $po_doc[0]->doc_path); ?>"
						target="_blank"
						class="text-blue-600 hover:text-blue-800 hover:underline">

						<?= htmlspecialchars($po_doc[0]->doc_path); ?>

					</a>

				<?php } else { ?>

					<span class="text-gray-400">No Document</span>

				<?php } ?>
			</div>
		</div>

	</div>


	<!-- PARTS TABLE -->
	<div id="parts_table_section"
		class="bg-white shadow rounded-xl p-6 overflow-x-auto">
		<a href="#" class="addRow text-green-600 hover:text-green-700 text-lg text-right">
			<i class="fa fa-plus-circle"></i>
		</a>
		<table id="item_table" class="w-full table-fixed text-sm border border-gray-300">

			<thead class="bg-gray-100">
				<tr>
					<th class="w-[30%] p-4 border text-left">Product Code</th>
					<th class="w-[15%] p-2 border text-left">Description</th>
					<th class="w-[13%] p-3 border text-left">Unit</th>
					<th class="w-[10%] p-3 border text-right">Quantity</th>
					<th class="w-[12%] p-3 border text-right">Price</th>
					<th class="w-[10%] p-3 border text-right">Dis 1(%)</th>
					<th class="w-[10%] p-3 border text-right">Dis</th>
					<th class="w-[10%] p-3 border text-right">Total</th>
					<th class="w-[8%] p-3 border text-center">Actions</th>
				</tr>
			</thead>

			<tbody>

				<?php $i = 0;
				foreach ($records2 as $r) { ?>

					<tr>

						<td class="border p-2">

							<input type="hidden" name="item_id5[]" value="<?php echo $r->part_id; ?>">

							<select class="w-full border rounded px-2 py-1 item-select2 select2 debtor-select"
								name="item_id[]" id="item<?= $i ?>"
								onchange="get_item_by_id(0)">
								<option value="">Select</option>
								<?php foreach ($active_items as $item) { ?>
									<option value="<?php echo $item->part_id ?>" <?php if ($r->part_id == $item->part_id) echo 'selected'; ?>>
										<?php echo $item->part_name . ' (' . $item->part_type . ')'; ?>
									</option>
								<?php } ?>
							</select>
						</td>

						<td class="border p-2">

							<input type="text" name="item_description[]" id="item_description<?= $i ?>" value="<?php echo $r->part_name; ?>">
						</td>

						<td class="p-2 border">
							<select class="w-full border rounded px-2 py-1"
								name="item_unit[]" id="unit<?= $i ?>">
								<option value="">Select</option>
								<?php foreach ($active_units as $u) { ?>
									<option value="<?php echo $u->unit_id ?>"
										<?php if ($r->unit_id == $u->unit_id) echo 'selected'; ?>>
										<?php echo $u->unit_name; ?>
									</option>
								<?php } ?>
							</select>
						</td>

						<td class="border p-2">
							<input type="number"
								class="quantity w-full border rounded px-2 py-1 text-right"
								name="item_quantity[]" id="quantity<?= $i ?>"
								value="<?php echo $r->quantity; ?>"  step="any">
						</td>

						<td class="border p-2">
							<input type="number"
								class="unit_price w-full border rounded px-2 py-1 text-right"
								name="unit_price[]" id="unit_price<?= $i ?>"
								value="<?php echo $r->price; ?>"  step="any">
						</td>

						<td class="border p-2">
							<input type="number"
								class="dis_per w-full border rounded px-2 py-1 text-right"
								name="dis_per[]" id="dis_per<?= $i ?>"
								value="<?php echo $r->dis_per; ?>"  step="any">
						</td>

						<td class="border p-2">
							<input type="number"
								class="dis_amt w-full border rounded px-2 py-1 text-right"
								name="dis_amt[]" id="dis_amt<?= $i ?>"
								value="<?php echo $r->dis_amt; ?>"  step="any">
						</td>

						<td class="border p-2">
							<input type="number"
								class="total_price w-full border rounded px-2 py-1 text-right"
								name="total_price[]" id="total_price<?= $i ?>"
								value="<?php echo $r->total; ?>"  step="any">
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

				<?php $i++;
				} ?>

			</tbody>
		</table>

	</div>


	<!-- SERVICE TABLE -->
	<div id="service_table_section"
		class="bg-white shadow rounded-xl p-6 overflow-x-auto hidden">
		<a href="#" class="addServiceRow text-green-600 text-lg"><i class="fa fa-plus-circle"></i></a>
		<table class="w-full table-fixed text-sm border border-gray-300" id="service_table">

			<thead class="bg-gray-100">
				<tr>
					<th class="w-[5%] border p-2">#</th>
					<th class="border p-2 text-left">Description</th>
					<th class="border p-2 text-right">Qty</th>
					<th class="border p-2 text-right">Price</th>
					<th class="border p-2 text-right">Dis%</th>
					<th class="border p-2 text-right">Vat%</th>
					<th class="border p-2 text-right">Total</th>
					<th class="w-[5%] p-3 border text-center">Action</th>
				</tr>
			</thead>

			<tbody>

				<?php
				$k = 1;
				foreach ($records2 as $s) { ?>

					<tr>

						<td class="border p-2 text-center"><?php echo $k++; ?></td>

						<td class="border p-2">
							<input type="text"
								name="service_description[]"
								class="w-full border rounded px-2 py-1"
								value="<?php echo $s->desc; ?>">
						</td>

						<td class="border p-2">
							<input type="number"
								class="service_qty w-full border rounded px-2 py-1 text-right"
								name="service_qty[]"
								value="<?php echo $s->quantity; ?>">
						</td>

						<td class="border p-2">
							<input type="number"
								class="service_price w-full border rounded px-2 py-1 text-right"
								name="service_price[]"
								value="<?php echo $s->price; ?>">
						</td>

						<td class="border p-2">
							<input type="number"
								class="service_dis w-full border rounded px-2 py-1 text-right"
								name="service_dis[]"
								value="<?php echo $s->dis_per; ?>">
						</td>


						<td class="border p-2">

							<select name="service_vat[]" class="service_vat w-full border rounded px-2 py-1 text-right">
								<option value="0" <?= (isset($s->service_vat_per) && $s->service_vat_per == 0) ? 'selected' : '' ?>>0%</option>
								<option value="5" <?= (isset($s->service_vat_per) && $s->service_vat_per == 5) ? 'selected' : '' ?>>5%</option>
							</select>
						</td>

						<td class="border p-2">
							<input type="number"
								readonly
								class="service_total w-full border rounded px-2 py-1 text-right"
								name="service_total[]"
								value="<?php echo $s->total; ?>">
						</td>
						<td class="p-2 border text-center">
							<a href="#" class="addServiceRow text-green-600 text-lg"><i class="fa fa-plus-circle"></i></a>
							<a href="#" class="deleteServiceRow text-red-600 text-lg"><i class="fa fa-trash"></i></a>
						</td>

					</tr>

				<?php }
				?>

			</tbody>
		</table>

	</div>

	<!-- Totals Section -->
	<div class="bg-white shadow rounded-xl p-6 space-y-6">
		<?php foreach ($records1 as $s) { ?>

			<!-- Row 1 -->
			<div class="grid grid-cols-12 gap-4 items-end">

				<div class="col-span-12 md:col-span-3">
					<label class="block text-sm font-medium mb-1">Sub Total</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2 bg-gray-100"
						name="sub_total" id="sub_total" value="<?php echo $s->sub_total; ?>" readonly>
				</div>

				<div class="col-span-6 md:col-span-2">
					<label class="block text-sm font-medium mb-1">Discount(%)</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="discount_per" id="discount_per" value="<?php echo $s->discount_percent; ?>">
				</div>

				<div class="col-span-6 md:col-span-2">
					<label class="block text-sm font-medium mb-1 invisible">Amount</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="discount_amt" id="discount_amt" value="<?php echo $s->discount; ?>">
				</div>

				<!-- <div class="col-span-6 md:col-span-2">
					<label class="block text-sm font-medium mb-1">VAT(%)</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="vat_per" id="vat_per" value="5">
				</div> -->
				<div class="col-span-6 md:col-span-2">
					<label class="block text-sm font-medium mb-1">VAT (%)</label>
					<select name="vat_per" id="vat_per"
						class="w-full border rounded-lg px-3 py-2">

						<option value="0" <?php if ($s->vat_percent == 0) { ?> selected <?php } ?>>0%</option>
						<option value="5" <?php if ($s->vat_percent == 5) { ?> selected <?php } ?>>5%</option>

					</select>
				</div>

				<div class="col-span-6 md:col-span-2">
					<label class="block text-sm font-medium mb-1 invisible">VAT Amount</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="vat_amount" id="vat_amount" value="<?php echo $s->vat_amt; ?>">
				</div>

				<div class="col-span-6 md:col-span-2">

					<label class="col-span-12 md:col-span-1">Round Off</label>

					<input type="text"
						class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
						name="roundoff"
						id="roundoff" oninput="allowOnlyNumbersDecimalNegative(this)"  value="<?php echo $s->currency_rate; ?>">
				</div>

				<div class="col-span-12 md:col-span-3">
					<label class="block text-sm font-semibold mb-1">Grand Total</label>
					<input type="text"
						class="w-full border rounded-lg px-3 py-2 bg-gray-100 font-semibold"
						name="grand_total" id="grand_total" value="<?php echo $s->grand_total; ?>">
				</div>

			</div>

			<!-- Charges Row -->
			<div class="grid grid-cols-12 gap-4">

				<div class="col-span-12 md:col-span-4">
					<label class="block text-sm font-medium mb-1">Transportation Charge</label>
					<input type="number" step="0.01" class="w-full border rounded-lg px-3 py-2"
						name="transportation_charge" id="transportation_charge" value="<?php echo $s->trans_charge; ?>">
				</div>

				<div class="col-span-12 md:col-span-4">
					<label class="block text-sm font-medium mb-1">Freight Charge</label>
					<input type="number" step="0.01" class="w-full border rounded-lg px-3 py-2"
						name="customs_charge" id="customs_charge" value="<?php echo $s->cust_charge; ?>">
				</div>

				<div class="col-span-12 md:col-span-4">
					<label class="block text-sm font-medium mb-1">Other Charges</label>
					<input type="number" step="0.01" class="w-full border rounded-lg px-3 py-2"
						name="other_charge" id="other_charge" value="<?php echo $s->add_charge; ?>">
				</div>

			</div>

			<!-- Terms Row 1 -->
			<div class="grid grid-cols-12 gap-4">

				<div class="col-span-12 md:col-span-6">
					<label class="block text-sm font-medium mb-1">Validity</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="validity" id="validity" value="<?php echo $s->validity; ?>">
				</div>

				<div class="col-span-12 md:col-span-6">
					<label class="block text-sm font-medium mb-1">Payment Terms</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="payment_terms" id="payment_terms" value="<?php echo $s->payment_term; ?>">
				</div>

			</div>

			<!-- Terms Row 2 -->
			<div class="grid grid-cols-12 gap-4">

				<div class="col-span-12 md:col-span-6">
					<label class="block text-sm font-medium mb-1">Delivery Terms</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="delivery_terms" id="delivery_terms" value="<?php echo $s->delivery_term; ?>">
				</div>

				<div class="col-span-12 md:col-span-6">
					<label class="block text-sm font-medium mb-1">General Terms</label>
					<input type="text" class="w-full border rounded-lg px-3 py-2"
						name="general_terms" id="general_terms" value="<?php echo $s->general_term; ?>">
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
						name="request_by" id="request_by" value="<?php echo $s->request_by; ?>">
				</div>

				<div class="col-span-12 md:col-span-4 flex gap-3 pt-5">
					<button type="button"
						onclick="window.location.href='<?= base_url('index.php/Purchase/purchase_order_list') ?>'"
						class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
						Cancel
					</button>

					<button type="submit"
						class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
						Submit
					</button>
				</div>

			</div>
		<?php } ?>
	</div>
</form>

<script>
	let lastDiscountEdited = 'per';
	$(document).ready(function() {

		let type = $('#purchase_type').val();

		if (type == 'PARTS') {
			$('#parts_table_section').show();
			$('#service_table_section').hide();
		} else {
			$('#parts_table_section').hide();
			$('#service_table_section').show();
		}

		// ======================================
		function toggleVatField123() {
			let type = $('#purchase_type').val();

			if (type === "SERVICE") {
				$('#vat_per')
					.prop('disabled', true)
					.css('background-color', '#e5e7eb');

				$('#vat_amount')
					.prop('readonly', true)
					.css('background-color', '#e5e7eb');
			} else {
				$('#vat_per')
					.prop('disabled', false)
					.css('background-color', '');

				$('#vat_amount')
					.prop('readonly', false)
					.css('background-color', '');
			}
		}

		function toggleVatField111() {
			let type = $('#purchase_type').val();

			if (type === "SERVICE") {
				$('#vat_per').prop('readonly', true).css('background-color', '#e5e7eb');
				$('#vat_amount').prop('readonly', true).css('background-color', '#e5e7eb');
			} else {
				$('#vat_per').prop('readonly', false).css('background-color', '');
				$('#vat_amount').prop('readonly', false).css('background-color', '');
			}
		}

		function toggleVatField() {
			let type = $('#purchase_type').val();

			if (type === "SERVICE") {
				// Hide VAT % dropdown
				$('#vat_per').closest('div').hide(); // adjust wrapper if needed

				// Also disable + gray VAT amount
				$('#vat_amount')
					.prop('readonly', true)
					.css('background-color', '#e5e7eb');
			} else {
				// Show VAT % dropdown
				$('#vat_per').closest('div').show();

				// Enable VAT amount
				$('#vat_amount')
					.prop('readonly', false)
					.css('background-color', '');
			}
		}

		// Run on page load
		toggleVatField();

		// Run when purchase type changes
		$('#purchase_type').on('change', function() {
			toggleVatField();
		});




		// =========================================================


		$('.item-search').select2({
			placeholder: "Search item...",
			width: '100%'
		});
		$('#supplier_id').select2({
			placeholder: "Select supplier",
			allowClear: true,
			width: '100%'
		});

		let rowIndex = <?= $i ?>; // Start from 1 because the first row uses index 0

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
										
										<?php echo $item->part_name . ' (' . $item->part_type . ')'; ?>
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
							<input class="w-full border rounded px-2 py-1  text-right quantity" 
								type="number" 
								name="item_quantity[]" 
								id="quantity${rowIndex}">
						</td>

						<td class="p-2 border">
							<input type="number" 
								class="w-full border rounded px-2 py-1 text-right unit_price" 
								name="unit_price[]" 
								step="any" 
								id="unit_price${rowIndex}" />
						</td>

						<td class="p-2 border">
							<input type="number" 
								class="w-full border rounded px-2 py-1 text-right dis_per" 
								name="dis_per[]" 
								step="any" 
								id="discount_per${rowIndex}" />
						</td>

						<td class="p-2 border">
							<input type="number" 
								class="w-full border rounded px-2 py-1 text-right dis_amt" 
								name="dis_amt[]" 
								step="any" 
								id="discount_amt${rowIndex}" />
						</td>

						<td class="p-2 border">
							<input type="number" 
								class="w-full border rounded px-2 py-1 text-right total_price" 
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
						</td> </tr>`;

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

	});

	$('#discount_per').on('input', function() {
			lastDiscountEdited = 'per';
			calculateAll();
		});

		$('#discount_amt').on('input', function() {
			lastDiscountEdited = 'amt';
			calculateAll();
		});


	// Recalculate when item-related fields change
	$(document).on('input change', '.quantity, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function() {

		var $row = $(this).closest('tr');

		calculateRow($row);
		calculateAll();
	});

	// Recalculate when global discount, VAT, or additional charges change #discount_per, #discount_amt,
	$('#vat_per, #transportation_charge, #customs_charge, #other_charge,#roundoff').on('input change', function() {
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

	function calculateAll() {
		// var subtotal = 0;


		// // ⭐ Detect visible table automatically (BEST METHOD)
		// $('.total_price:visible, .service_total:visible').each(function() {
		// 	subtotal += parseFloat($(this).val()) || 0;
		// });

		// $('#sub_total').val(subtotal.toFixed(2));

		var purchase_type = $('#purchase_type').val();
		var subtotal = 0;

		if (purchase_type === "PARTS") {

			// ✅ Existing logic (correct)
			$('.total_price:visible').each(function() {
				subtotal += parseFloat($(this).val()) || 0;
			});

		} else {

			// ✅ Service → exclude VAT from each row
			$('.service_vat:visible').each(function() {

				let row = $(this).closest('tr');

				let total = parseFloat(row.find('.service_total').val()) || 0;

				let qty = parseFloat(row.find('.service_qty').val()) || 0;
				let price = parseFloat(row.find('.service_price').val()) || 0;
				let dis = parseFloat(row.find('.service_dis').val()) || 0;
				let vat = parseFloat(row.find('.service_vat').val()) || 0;

				let amount = qty * price;
				let discountAmount = (amount * dis) / 100;
				let netAmount = amount - discountAmount;

				let vatAmount = (netAmount * vat) / 100;

				// 👉 Remove VAT from total
				subtotal += (total - vatAmount);
			});
		}

		$('#sub_total').val(subtotal.toFixed(2));

		// --- Global Discount ---
		var discountPer = parseFloat($('#discount_per').val()) || 0;
		var discountAmt = parseFloat($('#discount_amt').val()) || 0;

		// if ($('#discount_per').is(':focus')) {
		// 	discountAmt = (subtotal * discountPer) / 100;
		// 	$('#discount_amt').val(discountAmt.toFixed(2));
		// } else if ($('#discount_amt').is(':focus')) {
		// 	discountPer = (subtotal === 0) ? 0 : (discountAmt / subtotal) * 100;
		// 	$('#discount_per').val(discountPer.toFixed(2));
		// } else {
		// 	discountAmt = (subtotal * discountPer) / 100;
		// 	$('#discount_amt').val(discountAmt.toFixed(2));
		// }
		if (lastDiscountEdited === 'per') {

			discountAmt = (subtotal * discountPer) / 100;
			$('#discount_amt').val(discountAmt.toFixed(2));

		} else {

			discountPer = (subtotal === 0) ?
				0 :
				(discountAmt / subtotal) * 100;

			$('#discount_per').val(discountPer.toFixed(2));
		}

		var afterDiscount = subtotal - discountAmt;

		// // --- VAT ---
		// var vatPer = parseFloat($('#vat_per').val()) || 0;
		// var vatAmt = (afterDiscount * vatPer) / 100;
		// $('#vat_amount').val(vatAmt.toFixed(2));
		var purchase_type = $('#purchase_type').val();

		var vatAmt = 0;

		// --- VAT ---
		if (purchase_type == "PARTS") {
			// alert(purchase_type);

			// ✅ Global VAT (existing logic)
			var vatPer = parseFloat($('#vat_per').val()) || 0;
			vatAmt = (afterDiscount * vatPer) / 100;

		} else {

			// ✅ Non-Parts → Sum of row VAT
			$('.service_vat:visible').each(function() {

				let row = $(this).closest('tr');

				let qty = parseFloat(row.find('.service_qty').val()) || 0;
				let price = parseFloat(row.find('.service_price').val()) || 0;
				let dis = parseFloat(row.find('.service_dis').val()) || 0;
				let vat = parseFloat(row.find('.service_vat').val()) || 0;

				let amount = qty * price;

				let discountAmount = (amount * dis) / 100;
				let netAmount = amount - discountAmount;

				let rowVat = (netAmount * vat) / 100;

				vatAmt += rowVat;
			});
		}

		// ✅ Set VAT field (common)
		$('#vat_amount').val(vatAmt.toFixed(2));

		// --- Additional Charges ---
		var transportCharge = parseFloat($('#transportation_charge').val()) || 0;
		var freightCharge = parseFloat($('#customs_charge').val()) || 0;
		var otherCharge = parseFloat($('#other_charge').val()) || 0;
			var roundOff = parseFloat($('#roundoff').val()) || 0;

		// --- Grand Total ---
		var grandTotal = afterDiscount + vatAmt + transportCharge + freightCharge + otherCharge + roundOff;

		$('#grand_total').val(grandTotal.toFixed(2));


	}

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
					$('#item_description' + row_no).val(response.part_name);
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
			$('#item_description' + row_no).text('');
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

	// ========================non parts fucntions===============

	$(document).ready(function() {

		$('#purchase_type').change(function() {

			let type = $(this).val();

			if (type == 'Parts') {
				$('#parts_table_section').show();
				$('#service_table_section').hide();
			} else if (type == 'Non-Parts') {
				$('#parts_table_section').hide();
				$('#service_table_section').show();
			} else {
				$('#parts_table_section').hide();
				$('#service_table_section').hide();
			}

			calculateAll();

		});

	});
	$(document).on('click', '.addServiceRow', function(e) {

		e.preventDefault();

		let rowCount = $('#service_table tbody tr').length + 1;

		let row = `<tr>

        <td class="p-2 border text-center">${rowCount}</td>

        <td class="p-2 border">
            <input type="text" name="service_description[]" class="w-full border rounded px-2 py-1">
        </td>

        <td class="p-2 border">
            <input type="number" step="any" name="service_qty[]" class="service_qty w-full border rounded px-2 py-1 text-right">
        </td>

        <td class="p-2 border">
            <input type="number" step="any" name="service_price[]" class="service_price w-full border rounded px-2 py-1 text-right">
        </td>

        <td class="p-2 border">
            <input type="number" step="any" name="service_dis[]" class="service_dis w-full border rounded px-2 py-1 text-right">
        </td>

     	<td class="p-2 border">
			<select name="service_vat[]" class="service_vat w-full border rounded px-2 py-1 text-right">
				<option value="0">0%</option>
				<option value="5">5%</option>
			</select>
		</td>

        <td class="p-2 border">
            <input type="number" readonly step="any" name="service_total[]" class="service_total w-full border rounded px-2 py-1 text-right">
        </td>

        <td class="p-2 border text-center">
            <a href="#" class="addServiceRow text-green-600 text-lg"><i class="fa fa-plus-circle"></i></a>
            <a href="#" class="deleteServiceRow text-red-600 text-lg"><i class="fa fa-trash"></i></a>
        </td></tr>`;

		$('#service_table tbody').append(row);

	});
	$(document).on('click', '.deleteServiceRow', function(e) {

		e.preventDefault();

		if ($('#service_table tbody tr').length > 1) {
			$(this).closest('tr').remove();
			// calculate_all_totals();
			calculateAll();
		}

	});
	$(document).on('keyup change', '.service_qty, .service_price, .service_dis, .service_vat', function() {

		let row = $(this).closest('tr');

		let qty = parseFloat(row.find('.service_qty').val()) || 0;
		let price = parseFloat(row.find('.service_price').val()) || 0;
		let dis = parseFloat(row.find('.service_dis').val()) || 0;
		let vat = parseFloat(row.find('.service_vat').val()) || 0;

		let amount = qty * price;

		let discount_amt = (amount * dis) / 100;

		let net = amount - discount_amt;

		let vat_amt = (net * vat) / 100;

		let total = net + vat_amt;

		row.find('.service_total').val(total.toFixed(2));

		calculateAll();

	});

	function calculate_all_totalsold() {
		let subtotal = 0;

		if ($('#purchase_type').val() == 'Parts') {
			$('.total_price').each(function() {
				subtotal += parseFloat($(this).val()) || 0;
			});
		} else {
			$('.service_total').each(function() {
				subtotal += parseFloat($(this).val()) || 0;
			});
		}

		$('#sub_total').val(subtotal.toFixed(2));

		let dis_per = parseFloat($('#discount_per').val()) || 0;

		let dis_amt = (subtotal * dis_per) / 100;

		$('#discount_amt').val(dis_amt.toFixed(2));

		let after_dis = subtotal - dis_amt;

		let vat_per = parseFloat($('#vat_per').val()) || 0;

		let vat_amt = (after_dis * vat_per) / 100;

		$('#vat_amount').val(vat_amt.toFixed(2));

		let grand = after_dis + vat_amt;

		$('#grand_total').val(grand.toFixed(2));
	}



	function resetServiceSerial() {
		$('#service_table tbody tr').each(function(i) {
			$(this).find('td:first').text(i + 1);
		});
	}


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
