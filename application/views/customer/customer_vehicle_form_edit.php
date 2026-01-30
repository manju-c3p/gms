<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<h2 class="text-2xl font-bold mb-4">Edit Customer & Vehicles</h2>

	<form method="POST" action="<?= base_url('index.php/customer/update'); ?>">

		<input type="hidden" name="customer_id" value="<?= $customer->customer_id ?>">
		<input type="hidden" id="vehiclesToDelete" name="vehicles_to_delete" value="">

		<!-- CUSTOMER DETAILS -->
		<h3 class="text-xl font-semibold mb-3">Customer Details</h3>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

			<div>
				<label class="font-medium">Customer Name</label>
				<input type="text" name="name" value="<?= $customer->name ?>"
					class="w-full border p-2 rounded" required>
			</div>

			<div>
				<label class="font-medium">Phone</label>
				<input type="text" name="phone" value="<?= $customer->phone ?>"
					class="w-full border p-2 rounded">
			</div>

			<div>
				<label class="font-medium">Email</label>
				<input type="email" name="email" value="<?= $customer->email ?>"
					class="w-full border p-2 rounded">
			</div>

			<div>
				<label class="font-medium">Address</label>
				<textarea name="address"
					class="w-full border p-2 rounded"><?= $customer->address ?></textarea>
			</div>

			<div>
				<label class="font-medium">Emirate</label>
				<select name="emirate" class="w-full border p-2 rounded">
					<option value="">-- Select Emirate --</option>

					<option value="Abu Dhabi"
						<?= ($customer->emirates == 'Abu Dhabi') ? 'selected' : '' ?>>
						Abu Dhabi
					</option>

					<option value="Dubai"
						<?= ($customer->emirates == 'Dubai') ? 'selected' : '' ?>>
						Dubai
					</option>

					<option value="Sharjah"
						<?= ($customer->emirates == 'Sharjah') ? 'selected' : '' ?>>
						Sharjah
					</option>

					<option value="Ajman"
						<?= ($customer->emirates == 'Ajman') ? 'selected' : '' ?>>
						Ajman
					</option>

					<option value="Umm Al Quwain"
						<?= ($customer->emirates == 'Umm Al Quwain') ? 'selected' : '' ?>>
						Umm Al Quwain
					</option>

					<option value="Ras Al Khaimah"
						<?= ($customer->emirates == 'Ras Al Khaimah') ? 'selected' : '' ?>>
						Ras Al Khaimah
					</option>

					<option value="Fujairah"
						<?= ($customer->emirates == 'Fujairah') ? 'selected' : '' ?>>
						Fujairah
					</option>
				</select>

			</div>
			<div>
				<label class="font-medium">TRN</label>
				<input type="text" name="trn" class="w-full border p-2 rounded"  value="<?= $customer->trn ?>">
			</div>
		</div>

		<hr class="my-6">

		<!-- VEHICLES -->
		<h3 class="text-xl font-semibold mb-3">Vehicles</h3>

		<div id="vehicleRows">

			<?php foreach ($vehicles as $v): ?>
				<!-- <div class="vehicleRow grid grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative"> -->
			<div class="vehicleRow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">

					<button type="button"
						onclick="removeVehicleRow(this, <?= $v->vehicle_id ?>)"
						class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">
						✖
					</button>

					<input type="hidden" name="vehicle_id_existing[]" value="<?= $v->vehicle_id ?>">

					<div>
						<label class="font-medium">Registration No</label>
						<input name="vehicle_registration_no_existing[]"
							value="<?= $v->registration_no ?>"
							class="border p-2 rounded w-full">
					</div>

					<!-- BRAND -->
					<div>
						<label class="font-medium">Brand</label>
						<select name="brand_id_existing[]"
							class="brandSelect border p-2 rounded w-full" required>
							<option value="">-- Select Brand --</option>
							<?php foreach ($brands as $b): ?>
								<option value="<?= $b->brand_id ?>"
									<?= $b->brand_id == $v->brand_id ? 'selected' : '' ?>>
									<?= $b->brand_name ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<!-- MODEL -->
					<div>
						<label class="font-medium">Model</label>
						<select name="model_id_existing[]"
							class="modelSelect border p-2 rounded w-full"
							required>

							<?php echo "m" . $v->model_id;
							echo "name" . $v->model;
							if (!empty($v->model_id) && !empty($v->model)): ?>
								<option value="<?= $v->model_id ?>" selected>
									<?= $v->model ?>
								</option>
							<?php else: ?>
								<option value="">-- Select Model --</option>
							<?php endif; ?>

						</select>

					</div>

					<div>
						<label class="font-medium">Variant</label>
						<input name="vehicle_variant_existing[]" value="<?= $v->variant ?>"
							class="border p-2 rounded w-full">
					</div>

					<div>
						<label class="font-medium">Year</label>
						<input name="vehicle_year_existing[]" value="<?= $v->year ?>"
							class="border p-2 rounded w-full">
					</div>

					<div>
						<label class="font-medium">Color</label>
						<input name="vehicle_color_existing[]" value="<?= $v->color ?>"
							class="border p-2 rounded w-full">
					</div>

					<div>
						<label class="font-medium">Vin No</label>
						<input name="vehicle_chassis_no_existing[]" value="<?= $v->chassis_no ?>"
							class="border p-2 rounded w-full">
					</div>

					<div>
						<label class="font-medium">Engine No</label>
						<input name="vehicle_engine_no_existing[]" value="<?= $v->engine_no ?>"
							class="border p-2 rounded w-full">
					</div>

				</div>
			<?php endforeach; ?>

		</div>

		<!-- ADD VEHICLE -->
		<button type="button" onclick="addVehicleRow()"
			class="px-4 py-2 bg-green-600 text-white rounded my-3">
			+ Add Another Vehicle
		</button>

		<br><br>

		<button type="submit"
			class="px-6 py-2 bg-blue-600 text-white rounded">
			Update Customer & Vehicles
		</button>
		<a href="<?= base_url('index.php/Customer') ?>"
		class="px-6 py-2 bg-gray-500 text-white rounded inline-flex items-center">
		Cancel
	</a>

	</form>
</div>
<script>
	let vehiclesToDelete = [];

	function removeVehicleRow(btn, vehicleId = null) {
		if (vehicleId !== null) {
			vehiclesToDelete.push(vehicleId);
		}
		$('#vehiclesToDelete').val(JSON.stringify(vehiclesToDelete));
		btn.closest('.vehicleRow').remove();
	}

	// ADD NEW VEHICLE ROW
	function addVehicleRow() {
		let html = `
    
			<div class="vehicleRow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">

        <button type="button"
                onclick="this.closest('.vehicleRow').remove()"
                class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">
            ✖
        </button>

        <div>
            <label class="font-medium">Registration No</label>
            <input name="vehicle_registration_no_new[]" class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-medium">Brand</label>
            <select name="brand_id_new[]" class="brandSelect border p-2 rounded w-full" required>
                <option value="">-- Select Brand --</option>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= $b->brand_id ?>"><?= $b->brand_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="font-medium">Model</label>
            <select name="model_id_new[]" class="modelSelect border p-2 rounded w-full" required>
                <option value="">-- Select Model --</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Variant</label>
            <input name="vehicle_variant_new[]" class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-medium">Year</label>
            <input name="vehicle_year_new[]" class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-medium">Color</label>
            <input name="vehicle_color_new[]" class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-medium">Vin No</label>
            <input name="vehicle_chassis_no_new[]" class="border p-2 rounded w-full">
        </div>

        <div>
            <label class="font-medium">Engine No</label>
            <input name="vehicle_engine_no_new[]" class="border p-2 rounded w-full">
        </div>

    </div>`;
		$('#vehicleRows').append(html);
	}

	// BRAND → MODEL (EVENT DELEGATION)
	$(document).on('change', '.brandSelect', function() {

		let brandId = $(this).val();
		let row = $(this).closest('.vehicleRow');
		let modelSelect = row.find('.modelSelect');

		modelSelect.html('<option>Loading...</option>');

		if (!brandId) {
			modelSelect.html('<option value="">-- Select Model --</option>');
			return;
		}

		fetch("<?= base_url('index.php/customer/get_models_by_brand/'); ?>" + brandId)
			.then(res => res.json())
			.then(data => {
				let options = '<option value="">-- Select Model --</option>';
				data.forEach(m => {
					options += `<option value="${m.model_id}">${m.model_name}</option>`;
				});
				modelSelect.html(options);
			});
	});
</script>
