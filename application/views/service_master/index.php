<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="w-full bg-white rounded-xl shadow p-6">

	<div class="flex justify-between mb-4">
		<h2 class="text-2xl font-bold">Service Master</h2>

		<button onclick="openModal()"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ Add Service
		</button>
	</div>

	<div class="overflow-x-auto">
		<table id="serviceTable" class="display w-full border">
			<thead>
				<tr>
					<th>#</th>
					<th>Service Name</th>
					<th>Service Type</th>
					<th>Estimated Cost</th>
					<th>Estimated Time (Min)</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($services as $i => $s) { ?>
					<tr>
						<td><?= $i + 1 ?></td>
						<td><?= $s->service_name ?></td>
						<td><?= $s->service_type ?></td>
						<td><?= number_format($s->estimated_cost, 2) ?></td>
						<td><?= $s->estimated_time ?></td>
						<td>
							<span class="px-2 py-1 rounded text-sm font-semibold
                            <?= ($s->status == 'Active') ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' ?>">
								<?= $s->status ?>
							</span>
						</td>
						<td>
							<a href="<?= base_url('index.php/servicemaster/edit/' . $s->master_service_id) ?>"
								class="px-2 py-1 bg-blue-600 text-white rounded text-sm">
								Edit
							</a>

							<a href="<?= base_url('index.php/servicemaster/toggle_status/' . $s->master_service_id) ?>"
								class="px-2 py-1 bg-orange-500 text-white rounded text-sm">
								Toggle
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>

		</table>
	</div>
</div>

<!-- ✅ Add Service Modal -->
<div id="addModal" class="modal-backdrop-custom">
	<div class="modal-box-custom">

		<h3 class="text-xl font-bold mb-4">Add Service</h3>

		<form method="post" action="<?= base_url('index.php/
		servicemaster/store') ?>">

			<input type="text" name="service_name"
				class="w-full border p-2 mb-3"
				placeholder="Service Name" required>

			<!-- Service Type -->
			<select name="service_type"
				class="w-full border p-2 mb-3" required>
				<option value="">-- Select Service Type --</option>
				<option value="SERVICE">Service</option>
				<option value="LABOUR">Labour</option>
				<option value="OTHER">Other</option>
			</select>

			<input type="number" step="0.01" name="estimated_cost"
				class="w-full border p-2 mb-3"
				placeholder="Estimated Cost">

			<input type="number" name="estimated_time"
				class="w-full border p-2 mb-3"
				placeholder="Estimated Time (Minutes)">

			<select name="status" class="w-full border p-2 mb-4">
				<option value="Active">Active</option>
				<option value="Inactive">Inactive</option>
			</select>

			<div class="flex justify-end gap-2">
				<button type="button" onclick="closeModal()"
					class="px-4 py-2 bg-gray-400 text-white rounded">
					Cancel
				</button>

				<button type="submit"
					class="px-4 py-2 bg-green-600 text-white rounded">
					Save
				</button>
			</div>

		</form>
	</div>
</div>
<style>
	/* ✅ Modal Background */
	.modal-backdrop-custom {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.4);
		display: none;
		align-items: center;
		justify-content: center;
		z-index: 9999;
	}

	/* ✅ Modal Box */
	.modal-box-custom {
		background: #fff;
		width: 400px;
		padding: 24px;
		border-radius: 8px;
		box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
	}
</style>
<script>
	function openModal() {
		document.getElementById('addModal').style.display = 'flex';
	}

	function closeModal() {
		document.getElementById('addModal').style.display = 'none';
	}
</script>
<script>
	$(document).ready(function() {
		$('#serviceTable').DataTable({
			pageLength: 10,
			lengthMenu: [10, 25, 50, 100],
			ordering: true,
			searching: true,
			responsive: true
		});
	});
</script>
