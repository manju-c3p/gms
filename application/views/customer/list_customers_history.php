<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<div class="flex justify-between items-center mb-4">
		<h2 class="text-2xl font-bold">Customers Service History</h2>

		
	</div>

	<hr><br>



	<!-- Table -->
	<table id="customerTable" class="stripe hover w-full text-sm">
		<thead>
			<tr class="bg-gray-100 text-gray-700">
				<th class="p-3 text-left">SL No</th>
				<th class="p-3 text-left">Name</th>
				<th class="p-3 text-left">Phone</th>
				<th class="p-3 text-left">Email</th>
				<th class="p-3 text-left">Address</th>
				<th class="p-3 text-center">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php $sl = 1;
			foreach ($customers as $c): ?>
				<tr class="border-b hover:bg-gray-50 text-sm">

					<td class="p-3"><?= $sl++; ?></td>

					<td class="p-3 font-medium"><?= $c->name ?></td>

					<td class="p-3"><?= $c->phone ?></td>

					<td class="p-3"><?= $c->email ?></td>

					<td class="p-3"><?= $c->address ?></td>

					<td class="p-3 text-center flex justify-center gap-3">

						<!-- EDIT -->
						<a href="<?= base_url('index.php/servicehistory/customer/' . $c->customer_id); ?>"
							class="p-2 rounded bg-blue-100 hover:bg-blue-200"
							title="Service History">

							<svg xmlns="http://www.w3.org/2000/svg" fill="none"
								viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
								class="w-5 h-5 text-blue-700">

								<path stroke-linecap="round" stroke-linejoin="round"
									d="M11.35 3.836c-.123.397-.293.766-.503 1.105
                m-.909 1.159c-.38.34-.814.618-1.285.82
                M12 6.75V12m0 0l3 3m-3-3H9
                m6.364 5.636l.707.707M4.93 19.07l.707-.707
                M19.07 4.93l-.707.707M4.93 4.93l.707.707" />
							</svg>
						</a>




					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>

<script>
	$(document).ready(function() {

		$('#customerTable').DataTable({
			pageLength: 5,
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
				searchPlaceholder: "Search customers..."
			}
		});

	});
</script>

<style>
	#customerTable_wrapper .dataTables_filter {
		text-align: right !important;
	}

	#customerTable_wrapper .dataTables_length label {
		font-size: 0.875rem;
	}

	#customerTable_wrapper .dataTables_paginate {
		margin-top: 10px;
	}

	/* Table font smaller */
	#customerTable tbody td {
		font-size: 0.875rem !important;
	}
</style>
