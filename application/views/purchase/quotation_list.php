<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons (optional export buttons) -->
<!-- <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script> -->

<!-- page content -->
<!-- Caption Header -->
<div class="flex items-center justify-between bg-white shadow rounded-lg px-4 py-3 mb-4">

	<!-- Left: Title -->
	<h2 class="text-lg font-semibold text-gray-800">
		Purchase Quotation
	</h2>

	<!-- Right: Add Button -->
	<a href="<?php echo base_url(); ?>index.php/Purchase/add_quote_from_supplier"
		class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">

		<svg xmlns="http://www.w3.org/2000/svg"
			class="h-4 w-4"
			fill="none"
			viewBox="0 0 24 24"
			stroke="currentColor">

			<path stroke-linecap="round"
				stroke-linejoin="round"
				stroke-width="2"
				d="M12 4v16m8-8H4" />

		</svg>

		Add Purchase Quotation

	</a>

</div>

<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_direct_rfq_records" autocomplete="off" enctype="multipart/form-data">

	<div class="w-full px-4 py-4" role="main">
		<div class="w-full">

			<div class="w-full">

				<div class="clear-both"></div>

				<div class="bg-white shadow rounded-lg p-4">

					<div class="overflow-x-auto">

						<div class="overflow-x-auto border border-gray-200 rounded-lg">

							<table id="datatable" class="min-w-full divide-y divide-gray-200 text-sm">
								<thead class="bg-gray-100">
									<tr>
										<th class="px-4 py-2 text-left font-semibold text-gray-700">Sr.no</th>
										<th class="px-4 py-2 text-left font-semibold text-gray-700">Quotation Code</th>
										<th class="px-4 py-2 text-left font-semibold text-gray-700">Date</th>
										<th class="px-4 py-2 text-left font-semibold text-gray-700">Supplier</th>
										<th class="px-4 py-2 text-left font-semibold text-gray-700">Action</th>
									</tr>
								</thead>

								<tbody class="divide-y divide-gray-200 bg-white">
									<?php $i = 1;
									foreach ($records as $row) : ?>
										<tr class="hover:bg-gray-50 transition">
											<td class="px-4 py-2"><?php echo $i;
																	$i++; ?></td>

											<td class="px-4 py-2 font-medium text-gray-800">
												<?php echo $row->quotation_code; ?>
											</td>

											<td class="px-4 py-2 text-gray-700">
												<?php echo date('d-M-Y', strtotime($row->quotation_date)); ?>
											</td>

											<td class="px-4 py-2">
												<a title="View customer details"
													target="blank"
													href="<?php echo base_url() . 'index.php/Users/edit_supplier/' . $row->supplier_id; ?>"
													class="text-blue-600 hover:text-blue-800 hover:underline">
													<?php echo $row->supplier_name; ?>
												</a>
											</td>



											<td class="px-4 py-2">
												<div class="flex items-center gap-3">

													<!-- Edit -->
													<a href="<?php echo base_url() . 'index.php/Purchase/edit_quotation/' . $row->quotation_id . '/0'; ?>"
														title="Edit"
														class="flex items-center gap-1 text-green-600 hover:text-green-800">
														<i class="fa fa-pencil"></i>
														<span>Edit</span>
													</a>

													<!-- Print -->
													<a target="_blank"
														href="<?php echo base_url() . 'index.php/Purchase/print_quote/' . $row->quotation_id . '/1'; ?>"
														class="flex items-center gap-1 text-blue-600 hover:text-blue-800">
														<i class="fa fa-print"></i>
														<span>Print</span>
													</a>

													<!-- Delete -->
													<a href="<?php echo base_url() . 'index.php/Purchase/delete_quote/' . $row->quotation_id; ?>"
														title="Delete"
														class="delete flex items-center gap-1 text-red-600 hover:text-red-800">
														<i class="fa fa-trash"></i>
														<span>Delete</span>
													</a>

												</div>
											</td>


										</tr>
									<?php endforeach; ?>
								</tbody>

							</table>

						</div>

					</div>

				</div>

			</div>

		</div>
	</div>

</form>
<!-- /page content -->

<script>
	$(document).ready(function() {

		// Add row
		$(document).on('click', '.addRow', function() {

			const newRow = `<tr class="hover:bg-gray-50 transition">
        <td class="px-4 py-2"><input type="text" name="product_name" value="" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-blue-200"></td>

        <td class="px-4 py-2"><input type="text" name="description" value="" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-blue-200"></td>

        <td class="px-4 py-2"><input type="number" name="quantity" value="" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-blue-200"></td>

        <td class="px-4 py-2"><input type="text" name="unit" value="" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-blue-200"></td>

        <td class="px-4 py-2"><input type="text" name="packing" value="" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring focus:ring-blue-200"></td>

        <td class="px-4 py-2 flex gap-2">

          <button type="button" class="addRow bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
            Add
          </button>

          <button type="button" class="deleteRow bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
            Delete
          </button>

        </td>

      </tr>`;

			$('#datatable-responsive tbody').append(newRow);

		});

		// Delete row
		$(document).on('click', '.deleteRow', function() {

			$(this).closest('tr').remove();

		});

	});


	function handleKeyPress(event, row) {

		var suggestionDiv = $('#display' + row);
		var selected = suggestionDiv.find('.selected');
		var suggestions = suggestionDiv.find('.suggestion');

		if (event.key === "ArrowUp" || event.key === "ArrowDown" || event.key === "Enter") {

			event.preventDefault();

			if (event.key === "ArrowUp") {

				if (selected.length === 0) {

					suggestions.eq(-1).addClass('selected');

				} else {

					var prev = selected.removeClass('selected').prev('.suggestion');

					if (prev.length > 0) {

						prev.addClass('selected');

					} else {

						suggestions.eq(-1).addClass('selected');

					}

				}

			} else if (event.key === "ArrowDown") {

				if (selected.length === 0) {

					suggestions.eq(0).addClass('selected');

				} else {

					var next = selected.removeClass('selected').next('.suggestion');

					if (next.length > 0) {

						next.addClass('selected');

					} else {

						suggestions.eq(0).addClass('selected');

					}

				}

			} else if (event.key === "Enter") {

				if (selected.length > 0) {

					var productName = selected.text();
					var productID = selected.data('productId');

					$('#search' + row).val(productName);
					$('#pro_id' + row).val(productID);

					suggestionDiv.hide();

					get_product_info(row);

				}

			}

		}

	}


	function showsugg(row, event) {

		var name = $('#search' + row).val();

		if (name.length > 4) {

			$.ajax({

				type: "POST",

				url: "<?php echo site_url('Product/ajax_product_search'); ?>",

				dataType: 'json',

				data: {
					search_key: name
				},

				success: function(data) {

					document.getElementById('display' + row).innerHTML = '';

					var parentDiv = document.getElementById('display' + row);

					if (data.length > 0) {

						data.forEach(function(product) {

							var option = document.createElement('div');

							option.textContent = product.product_name;

							option.classList.add(
								'suggestion',
								'px-3',
								'py-2',
								'cursor-pointer',
								'hover:bg-blue-100'
							);

							option.dataset.productId = product.product_id;

							option.addEventListener('click', function() {

								document.getElementById('search' + row).value = product.product_name;

								document.getElementById('pro_id' + row).value = product.product_id;

								parentDiv.innerHTML = '';

								get_product_info(row);

							});

							parentDiv.appendChild(option);

						});

					} else {

						var option = document.createElement('div');

						option.textContent = 'No products found';

						option.classList.add('px-3', 'py-2', 'text-gray-500');

						parentDiv.appendChild(option);

					}

					$('#display' + row).show();

				}

			});

		} else {

			document.getElementById('display' + row).innerHTML = '';

		}

	}
</script>
<script>
	$(document).ready(function() {

		$('#datatable').DataTable({

			pageLength: 10,

			responsive: true,

			autoWidth: false,

			processing: true,

			language: {
				search: "",
				searchPlaceholder: "Search PQ...",
				lengthMenu: "Show _MENU_ entries",
				info: "Showing _START_ to _END_ of _TOTAL_ RFQs",
				paginate: {
					previous: "Prev",
					next: "Next"
				}
			},

			dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-3"Bf>rt<"flex flex-col md:flex-row md:items-center md:justify-between mt-3"lip>',

			// buttons: [{
			// 		extend: 'excel',
			// 		text: 'Export Excel',
			// 		className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700'
			// 	},
			// 	{
			// 		extend: 'print',
			// 		text: 'Print',
			// 		className: 'bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700'
			// 	}
			// ]

		});

	});
</script>
