<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<!-- Header -->
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<!-- Caption -->
	<h1 class="text-xl font-medium text-gray-700">
		GRN List
	</h1>

	<!-- Add Button -->
	<a href="<?php echo base_url(); ?>index.php/Purchase/add_grn"
		class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">

		+ Add GRN

	</a>

</div>


<!-- page content -->
<div class="bg-white shadow rounded-b-lg p-4 overflow-x-auto">

	<div class="overflow-x-auto">

		<table id="datatable"
			class="min-w-full divide-y divide-gray-200 text-sm">

			<thead class="bg-gray-100">

				<tr>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">#</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Sr.No</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">GRN Code</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">GRN Date</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Supplier</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Amount</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Action</th>

				</tr>

			</thead>


			<tbody class="divide-y divide-gray-200 bg-white">

				<?php $i = 1;
				foreach ($records as $row) : ?>

					<tr class="hover:bg-gray-50 transition">

						<td class="px-4 py-2">

							<a href="#"
								class="delete-grn text-red-600 hover:text-red-800"
								data-grn-id="<?php echo $row->grn_id; ?>"
								title="Delete">

								<i class="glyphicon glyphicon-trash"></i>

							</a>

						</td>


						<td class="px-4 py-2">
							<?php echo $i;
							$i++; ?>
						</td>


						<td class="px-4 py-2 font-medium text-gray-800">
							<?php echo $row->grn_code; ?>
						</td>


						<td class="px-4 py-2 text-gray-700">
							<?php echo date('d-M-Y', strtotime($row->grn_date)); ?>
						</td>


						<td class="px-4 py-2">

							<a title="View supplier details"
								target="blank"
								href="<?php echo base_url() . 'index.php/Users/edit_supplier/' . $row->supplier_id; ?>"
								class="text-blue-600 hover:text-blue-800 hover:underline">

								<?php echo $row->supplier_name; ?>

							</a>

						</td>


						<td class="px-4 py-2 text-gray-700 font-medium">
							<?php echo $row->grand_total; ?>
						</td>


						<td class="px-4 py-2">

							<a
								href="<?php echo base_url() . 'index.php/Purchase/print_grn/' . $row->grn_id . '/1'; ?>"
								class="text-blue-600 hover:text-blue-800">

								<i class="fa fa-print"></i>

							</a>

							<!-- Edit Button -->
							<!-- <a
								href="<?php echo base_url() . 'index.php/Purchase/edit_grn/' . $row->grn_id; ?>"
								class="text-green-600 hover:text-green-800">
								<i class="fa fa-edit"></i>
							</a> -->

							<?php
							$grn_date = strtotime($row->grn_date);
							$today = strtotime(date('Y-m-d'));
							$days_diff = ($today - $grn_date) / (60 * 60 * 24);
							?>

							<?php if ($days_diff <= 15) { ?>
								<!-- Editable -->
								<a href="<?php echo base_url() . 'index.php/Purchase/edit_grn/' . $row->grn_id; ?>"
									class="text-green-600 hover:text-green-800"
									title="Edit GRN">
									<i class="fa fa-edit"></i>
								</a>
							<?php } else { ?>
								<!-- View only -->
								<a href="<?php echo base_url() . 'index.php/Purchase/view_grn/' . $row->grn_id; ?>"
									class="text-yellow-600 hover:text-blue-800"
									title="View GRN">
									<i class="fa fa-eye"></i>
								</a>
							<?php } ?>

						</td>

					</tr>

				<?php endforeach; ?>

			</tbody>

		</table>

	</div>

</div>


<!-- DataTables Initialization -->
<script>
	$(document).ready(function() {

		// $('#datatable').DataTable({

		// 	pageLength: 10,

		// 	responsive: true,

		// 	autoWidth: false,

		// 	ordering: true,

		// 	paging: true,

		// 	searching: true,

		// 	info: true,

		// 	dom: '<"flex flex-col md:flex-row md:items-center md:justify-between mb-3"Bf>rt<"flex flex-col md:flex-row md:justify-between mt-3"lip>',

		// 	buttons: [

		// 		{
		// 			extend: 'excel',
		// 			text: 'Export Excel',
		// 			className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700'
		// 		},

		// 		{
		// 			extend: 'print',
		// 			text: 'Print',
		// 			className: 'bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700'
		// 		}

		// 	],

		// 	language: {

		// 		search: "",
		// 		searchPlaceholder: "Search GRN...",

		// 		paginate: {
		// 			previous: "Prev",
		// 			next: "Next"
		// 		}

		// 	}

		// });
		$('#datatable').DataTable({
			pageLength: 10,
			lengthMenu: [
				[5, 10, 25, -1],
				[5, 10, 25, "All"]
			],
			responsive: true,

			// Move search box to the RIGHT
			dom: "<'flex justify-between items-center mb-3'l<f>>" +
				"t" +
				"<'flex justify-between items-center mt-3'p>",

			language: {
				search: "",
				searchPlaceholder: "Search ..."
			}
		});


		$('.delete-grn').click(function(e) {

			e.preventDefault();

			let grn_id = $(this).data('grn-id');

			if (confirm('Are you sure you want to delete this GRN?')) {

				$.ajax({

					url: "<?php echo base_url() ?>index.php/Purchase/delete_grn",

					type: 'POST',

					data: {
						grn_id: grn_id
					},

					success: function(response) {

						let res = JSON.parse(response);

						if (res.success) {

							alert('GRN deleted successfully.');

							location.reload();

						} else {

							alert('Error: ' + res.message);

						}

					},

					error: function() {

						alert('An error occurred while processing the request.');

					}

				});

			}

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

							option.classList.add('suggestion');

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

						option.classList.add('suggestion');

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
