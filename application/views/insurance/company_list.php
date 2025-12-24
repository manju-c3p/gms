<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">


	<div class="flex justify-between items-center mb-4">
		<h2 class="text-2xl font-bold">Insurance Companies</h2>

		<a href="<?= base_url('index.php/insurancecompany/add'); ?>"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ Add Company
		</a>
	</div>

	<hr><br>

	<table id="customerTable" class="w-full border rounded">
		<thead class="bg-gray-100">
			<tr>
				<th class="p-3 text-left">SL No</th>
				<th class="p-3 text-left">Name</th>
				<th class="p-3 text-left">Phone</th>
				<th class="p-3 text-left">Email</th>
				<th class="p-3 text-left">Address</th>
				<th class="p-3 text-center">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php $sl = 1; foreach ($companies as $c): ?>
				<tr class="border-b hover:bg-gray-50">
					<td class="p-3"><?= $sl++; ?></td>
					<td class="p-3"><?= $c->company_name ?></td>
					<td class="p-3"><?= $c->contact_no ?></td>
					<td class="p-3"><?= $c->email ?></td>
					<td class="p-3"><?= $c->address ?></td>

					<td class="p-3 text-center flex justify-center gap-3">

						<a href="<?= base_url('index.php/insurancecompany/edit/' . $c->company_id); ?>"
							class="p-2 bg-yellow-100 rounded" title="Edit">✏️</a>

						<a onclick="return confirm('Delete this company?');"
							href="<?= base_url('index.php/insurancecompany/delete/' . $c->company_id); ?>"
							class="p-2 bg-red-100 rounded" title="Delete">🗑️</a>

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
				searchPlaceholder: "Search Companies..."
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
