<!-- page content -->
<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Purchase/update_rfq" autocomplete="off" enctype="multipart/form-data">

	<div class="w-full">

	
		<div class="bg-white shadow rounded-lg p-4 overflow-auto">
				<!-- Header -->
   		<div class="flex items-center justify-between border-b pb-4 mb-8">

   			<!-- Left Caption -->
   			<h2 class="text-2xl font-semibold">Edit RFQ</h2>

   			<!-- Right Add Button -->
   			<a href="<?php echo base_url(); ?>index.php/Purchase/list_direct_rfq"
   				class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">

   				+ List

   			</a>

   		</div>

			<!-- RFQ Code -->
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

				<div class="flex items-center">
					<label class="w-1/3 text-sm font-medium text-gray-700">RFQ Code</label>
					<div class="w-2/3">
						<input type="text" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
							name="rfq_code" id="rfq_code" readonly
							value="<?php echo $records1[0]->rfq_code; ?>">
						<input type="hidden" name="rfq_id" id="rfq_id"
							value="<?php echo $records1[0]->rfq_id; ?>">
					</div>
				</div>

				<!-- RFQ Date -->
				<div class="flex items-center">
					<label class="w-1/3 text-sm font-medium text-gray-700">RFQ Date</label>
					<div class="w-2/3">
						<input type="date"
							class="w-full border border-gray-300 rounded px-3 py-2"
							name="rfq_date" id="rfq_date"
							value="<?php echo $records1[0]->rfq_date; ?>">
					</div>
				</div>

				<!-- Supplier -->
				<div class="flex items-center">
					<label class="w-1/3 text-sm font-medium text-gray-700">Select Supplier</label>
					<div class="w-2/3">
						<select name="supplier_id" id="supplier_id"
							class="w-full border border-gray-300 rounded px-3 py-2 select2"
							required>
							<?php foreach ($supplier_records as $g) { ?>
								<option <?php if ($g->supplier_id == $records1[0]->supplier_id) echo 'selected'; ?>
									value="<?php echo $g->supplier_id; ?>">
									<?php echo $g->supplier_code . ' ' . $g->supplier_name; ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>

				<!-- Subject -->
				<div class="flex items-center">
					<label class="w-1/3 text-sm font-medium text-gray-700">Subject</label>
					<div class="w-2/3">
						<input type="text"
							class="w-full border border-gray-300 rounded px-3 py-2"
							name="subject" id="subject"
							value="<?php echo $records1[0]->subject; ?>">
					</div>
				</div>

				<!-- Project -->
				

				<!-- Reference -->
				

			</div>

		</div>
	</div>


	<!-- Table -->
	<div class="w-full mt-4 overflow-x-auto">
		<table id="datatable-responsive"
			class="min-w-full border border-gray-300 rounded-lg overflow-hidden">

			<thead class="bg-gray-100">
				<tr>
					<th class="border px-3 py-2 text-left text-sm font-semibold">Product Code</th>
				
					<th class="border px-3 py-2 text-left text-sm font-semibold">Description</th>
					<th class="border px-3 py-2 text-left text-sm font-semibold">Unit</th>
					<th class="border px-3 py-2 text-left text-sm font-semibold">Quantity</th>
					<th class="border px-3 py-2 text-center text-sm font-semibold">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 5000;
				foreach ($records2 as $r) { ?>
					<tr class="hover:bg-gray-50">

						<td class="border px-2 py-1">
							<select class="w-full border border-gray-300 rounded px-2 py-1 select2"
								name="item[]" id="item<?php echo $i; ?>"
								onchange="get_item_by_id(<?php echo $i; ?>)">

								<?php foreach ($active_items as $item) { ?>
									<option value="<?php echo $item->part_id ; ?>"
										<?php if ($r->product_id == $item->part_id) echo 'selected'; ?>>
										<?php echo $item->part_name; ?>
									</option>
								<?php } ?>
							</select>
						</td>

						

						<td class="border px-2 py-1">
							<input class="w-full border border-gray-300 rounded px-2 py-1"
								type="text" name="description[]"
								id="description<?php echo $i; ?>"
								value="<?php echo $r->prod_desc; ?>">
						</td>

						<td class="border px-2 py-1">
							<select class="w-full border border-gray-300 rounded px-2 py-1 select2"
								name="unit[]" id="unit<?php echo $i; ?>">
								<option value="">Select</option>
								<?php foreach ($active_units as $unit) { ?>
									<option <?php if ($r->purchase_unit_id == $unit->unit_id) echo 'selected'; ?>
										value="<?php echo $unit->unit_id ?>">
										<?php echo $unit->unit_name; ?>
									</option>
								<?php } ?>
							</select>
						</td>

						<td class="border px-2 py-1">
							<input class="w-full border border-gray-300 rounded px-2 py-1"
								type="number" name="quantity[]"
								id="quantity<?php echo $i; ?>"
								value="<?php echo $r->quantity; ?>">
						</td>

						<td class="border px-2 py-1 text-center space-x-2">

							<button type="button"
								class="addRow bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">
								<i class="fa fa-plus"></i>
							</button>

							<button type="button"
								class="deleteRow bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">
								<i class="fa fa-search-minus"></i>
							</button>

						</td>

					</tr>
				<?php } ?>
			</tbody>

		</table>
	</div>


	<!-- Remarks -->
	<div class="bg-white shadow rounded-lg p-4 mt-6">

		<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

			<div class="flex items-start">
				<label class="w-1/3 text-sm font-medium text-gray-700 pt-2">Remarks</label>
				<div class="w-2/3">
					<textarea
						class="w-full border border-gray-300 rounded px-3 py-2"
						name="remarks" id="remarks"><?php echo $records1[0]->remark; ?></textarea>
				</div>
			</div>

		</div>


		<!-- Buttons -->
		<div class="flex gap-3 mt-4">

			<a href="<?= base_url('index.php/Purchase/list_direct_rfq') ?>"
				class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded inline-block">
				Cancel
			</a>


			<button type="submit"
				class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
				Submit
			</button>

		</div>

	</div>

</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
	$(document).ready(function() {
		// Completely destroy any automatic DataTable initialization
		if ($.fn.DataTable.isDataTable('#datatable-responsive')) {
			$('#datatable-responsive').DataTable().destroy();
		}

		// Reinitialize manually WITHOUT pagination, search, or info
		$('#datatable-responsive').DataTable({
			paging: false,
			searching: false,
			info: false,
			ordering: false,
			lengthChange: false,
			autoWidth: false,
			bSort: false,
			dom: 't' // this hides all DataTables controls (pagination, search bar, etc.)
		});
	});

	function initializeSelect2(selectElement) {
		selectElement.select2({

		});
	}

	$(document).ready(function() {
		initializeSelect2($('.select2'));
	});

	// Row index base for unique IDs
	let rowIndexBase = Date.now();
	const getNextIndex = (() => {
		let counter = 0;
		return () => rowIndexBase + (++counter);
	})();

	// ADD ROW
	// ADD ROW
	$(document).on('click', '.addRow', function(e) {
		e.preventDefault();
		const idx = getNextIndex();

		const newRow = `
        <tr class="hover:bg-gray-50">

            <td class="border px-2 py-1">
                <select
                    class="w-full border border-gray-300 rounded px-2 py-1 select2"
                    name="item[]"
                    id="item${idx}"
                    onchange="get_item_by_id(${idx})">

                    <option value="">Select</option>

                    <?php foreach ($active_items as $item) { ?>
                        <option value="<?php echo $item->part_id ?>">
                            <?php echo $item->part_name; ?>
                        </option>
                    <?php } ?>

                </select>
            </td>


            


            <td class="border px-2 py-1">
                <input
                    type="text"
                    name="description[]"
                    id="description${idx}"
                    class="w-full border border-gray-300 rounded px-2 py-1">
            </td>


            <td class="border px-2 py-1">

                <select
                    name="unit[]"
                    id="unit${idx}"
                    class="w-full border border-gray-300 rounded px-2 py-1 select2">

                    <option value="">Select</option>

                    <?php foreach ($active_units as $unit) { ?>
                        <option value="<?php echo $unit->unit_id ?>">
                            <?php echo $unit->unit_name; ?>
                        </option>
                    <?php } ?>

                </select>

            </td>


            <td class="border px-2 py-1">

                <input
                    type="number"
                    name="quantity[]"
                    id="quantity${idx}"
                    class="w-full border border-gray-300 rounded px-2 py-1">

            </td>


            <td class="border px-2 py-1 text-center space-x-2">

                <button
                    type="button"
                    class="addRow bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">

                    <i class="fa fa-plus"></i>

                </button>


                <button
                    type="button"
                    class="deleteRow bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">

                    <i class="fa fa-search-minus"></i>

                </button>

            </td>

        </tr>
    `;

		$('#datatable-responsive tbody').append(newRow);

		$(`#item${idx}`).select2();
		$(`#unit${idx}`).select2();

	});

	// DELETE ROW
	$(document).on('click', '.deleteRow', function(e) {
		e.preventDefault();
		$(this).closest('tr').remove();
	});



	function get_item_by_id(row_no) {
		var item_id = $('#item' + row_no).val();

		if (item_id != '') {
			$.ajax({
				url: '<?= base_url("index.php/Item/get_item_by_id") ?>', // update with your controller path
				type: 'POST',
				data: {
					item_id: item_id
				},
				dataType: "json",
				success: function(response) {
					$('#brand' + row_no).val(response.brand_name);
					$('#description' + row_no).val(response.item_description);
					$('#unit' + row_no).val(response.item_unit).change();
					// $('#actual_price'+row_no).val(response.mrp_aed);
					$('#unit' + row_no).prop('required', true);
					$('#quantity' + row_no).prop('required', true);

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
