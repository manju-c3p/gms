<div class="w-full bg-white rounded-2xl shadow-md p-6">


	<div class="flex justify-between items-center mb-4">
		<h2 class="text-2xl font-bold">Vehicle List (Grouped by Customer)</h2>

		<a href="<?= base_url('index.php/customer/add'); ?>"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ Add Customer & Vehicle
		</a>
	</div>
<hr><br>
	<!-- Datatable -->
	<table id="vehicleTable" class="display stripe hover row-border cell-border compact" style="width:100%;">
		<thead>
			<tr>

				<th>Customer</th>
				<th>SL No</th>
				<th>Phone</th>
				<th>Reg No</th>
				<th>Brand</th>
				<th>Model</th>
				<th>Variant</th>
				<th>Year</th>
				<th>Color</th>
				<th>Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php $sl = 1;
			foreach ($rows as $r): ?>
				<tr>

					<td><?= $r->customer_name ?></td>
					<td><?= $sl++; ?></td>
					<td><?= $r->phone ?></td>
					<td><?= $r->registration_no ?></td>
					<td><?= $r->brand ?></td>
					<td><?= $r->model ?></td>
					<td><?= $r->variant ?></td>
					<td><?= $r->year ?></td>
					<td><?= $r->color ?></td>

					<td class="flex gap-2">

						<!-- Edit -->
						<a href="<?= base_url('index.php/customer/edit/'.$r->customer_id); ?>"
							class="p-1 bg-yellow-100 rounded hover:bg-yellow-200"
							title="Edit">
							✏️
						</a>

						<!-- Delete -->
						<a onclick="return confirm('Delete this vehicle?');"
							href="<?= base_url('vehicle/delete/' . $r->vehicle_id); ?>"
							class="p-1 bg-red-100 rounded hover:bg-red-200"
							title="Delete">
							🗑️
						</a>

					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>

<!-- DATATABLE SCRIPTS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.4.1/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.4.1/js/dataTables.rowGroup.min.js"></script>

<script>
	$(document).ready(function() {
		$('#vehicleTable').DataTable({
			pageLength: 5,
			order: [
				[0, 'asc']
			], // group by Customer
			rowGroup: {
				dataSrc: 0 // customer name column
			},
			columnDefs: [{
					targets: 0,
					visible: false
				} // hide customer column (used only for grouping)
			]
		});
	});
</script>

<style>
	/* Tailwind-like table tweaks */
	table.dataTable tbody td {
		font-size: 0.85rem;
		padding: 8px 10px;
	}

	table.dataTable tbody tr:hover {
		background-color: #f9fafb !important;
	}

	.dtrg-group {
		background-color: #e5e7eb !important;
		font-weight: bold;
		padding: 8px !important;
		font-size: 0.95rem;
	}
</style>
