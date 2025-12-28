<div class="w-full bg-white p-6 rounded shadow">

	<h2 class="text-2xl font-bold mb-4">Edit Service</h2>

	<form method="post" action="<?= base_url('index.php/servicemaster/update/' . $service->master_service_id) ?>">

		<input type="text" name="service_name"
			value="<?= $service->service_name ?>"
			class="w-full border p-2 mb-3">
		<select name="service_type"
			class="w-full border p-2 mb-3" required>

			<option value="">-- Select Service Type --</option>

			<option value="SERVICE"
				<?= ($service->service_type == 'SERVICE') ? 'selected' : '' ?>>
				Service
			</option>

			<option value="LABOUR"
				<?= ($service->service_type == 'LABOUR') ? 'selected' : '' ?>>
				Labour
			</option>

			<option value="OTHER"
				<?= ($service->service_type == 'OTHER') ? 'selected' : '' ?>>
				Other
			</option>

		</select>



		<input type="number" step="0.01" name="estimated_cost"
			value="<?= $service->estimated_cost ?>"
			class="w-full border p-2 mb-3">

		<input type="number" name="estimated_time"
			value="<?= $service->estimated_time ?>"
			class="w-full border p-2 mb-3">

		<select name="status" class="w-full border p-2 mb-3">
			<option value="Active" <?= ($service->status == 'Active' ? 'selected' : '') ?>>Active</option>
			<option value="Inactive" <?= ($service->status == 'Inactive' ? 'selected' : '') ?>>Inactive</option>
		</select>

		<button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>

	</form>
</div>
