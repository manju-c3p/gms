<!-- <div class="w-full max-w-5xl bg-white rounded-2xl shadow-md p-6 mx-auto"> -->
<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<h2 class="text-2xl font-bold mb-4">Edit Customer & Vehicles</h2>

	<form method="POST" action="<?= base_url('index.php/customer/update'); ?>">

		<input type="hidden" name="customer_id" value="<?= $customer->customer_id ?>">


		<!-- Hidden field for deleted vehicles -->
		<input type="hidden" id="vehiclesToDelete" name="vehicles_to_delete" value="">

		<!-- CUSTOMER SECTION -->
		<h3 class="text-xl font-semibold mb-3">Customer Details</h3>

		<div class="grid grid-cols-3 gap-4">

			<div>
				<label class="font-medium">Customer Name</label>
				<input type="text" name="name" value="<?= $customer->name ?>"
					required class="w-full border p-2 rounded">
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
				<textarea name="address" class="w-full border p-2 rounded"><?= $customer->address ?></textarea>
			</div>

		</div>

		<hr class="my-6">

		<!-- VEHICLE SECTION -->
		<h3 class="text-xl font-semibold mb-3">Vehicles</h3>

		<div id="vehicleRows">

			<?php foreach ($vehicles as $v): ?>
				<div class="vehicleRow grid grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">

					<!-- DELETE EXISTING VEHICLE BUTTON -->
					<button type="button"
						onclick="removeVehicleRow(this, <?= $v->vehicle_id ?>)"
						class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">
						✖
					</button>

					<!-- HIDDEN vehicle_id -->
					<input type="hidden" name="vehicle_id_existing[]" value="<?= $v->vehicle_id ?>">

					<div>
						<label class="font-medium">Registration No</label>
						<input name="vehicle_registration_no_existing[]" value="<?= $v->registration_no ?>"
							class="border p-2 rounded w-full">
					</div>

					<div>
						<label class="font-medium">Brand</label>
						<input name="vehicle_brand_existing[]" value="<?= $v->brand ?>"
							class="border p-2 rounded w-full">
					</div>

					<div>
						<label class="font-medium">Model</label>
						<input name="vehicle_model_existing[]" value="<?= $v->model ?>"
							class="border p-2 rounded w-full">
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
						<label class="font-medium">Chassis No</label>
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

		<!-- Add More Vehicles -->
		<button type="button" onclick="addVehicleRow()"
			class="px-4 py-2 bg-green-600 text-white rounded my-3">
			+ Add Another Vehicle
		</button>

		<br><br>

		<button type="submit"
			class="px-6 py-2 bg-blue-600 text-white rounded">
			Update Customer & Vehicles
		</button>

	</form>
</div>

<script>
	let vehiclesToDelete = [];



	function removeVehicleRow(btn, vehicleId = null) {

		// Track IDs of existing vehicles only
		if (vehicleId !== null) {
			vehiclesToDelete.push(vehicleId);
		}

		// Update hidden input value as JSON string
		document.getElementById("vehiclesToDelete").value = JSON.stringify(vehiclesToDelete);

		// Remove row from UI
		btn.closest(".vehicleRow").remove();
	}

	

	function addVehicleRow() {
		let html = `
    <div class="vehicleRow grid grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">
        <button type="button" onclick="this.parentElement.remove()"
                class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">✖</button>

        <input type="hidden" name="vehicle_id_new[]" value="">

        <div><label class="font-medium">Registration No</label>
             <input name="vehicle_registration_no_new[]" class="border p-2 rounded w-full"></div>

        <div><label class="font-medium">Brand</label>
             <input name="vehicle_brand_new[]" class="border p-2 rounded w-full"></div>

        <div><label class="font-medium">Model</label>
             <input name="vehicle_model_new[]" class="border p-2 rounded w-full"></div>

        <div><label class="font-medium">Variant</label>
             <input name="vehicle_variant_new[]" class="border p-2 rounded w-full"></div>

        <div><label class="font-medium">Year</label>
             <input name="vehicle_year_new[]" class="border p-2 rounded w-full"></div>

        <div><label class="font-medium">Color</label>
             <input name="vehicle_color_new[]" class="border p-2 rounded w-full"></div>

        <div><label class="font-medium">Chassis No</label>
             <input name="vehicle_chassis_no_new[]" class="border p-2 rounded w-full"></div>

        <div><label class="font-medium">Engine No</label>
             <input name="vehicle_engine_no_new[]" class="border p-2 rounded w-full"></div>
    </div>`;

		document.getElementById('vehicleRows').insertAdjacentHTML('beforeend', html);
	}
</script>
