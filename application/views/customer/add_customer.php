<style>
	/* Works in most modern browsers */
	option[data-special="true"] {
		font-weight: 600;
		color: #16a34a;
		/* green-600 */
	}
</style>

<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<h2 class="text-2xl font-bold mb-4">Add Customer & Vehicles</h2>

	<form method="POST" action="<?= base_url('index.php/Customer/save'); ?>"  onsubmit="return preventDoubleSubmit(this);">

		<!-- CUSTOMER SECTION -->
		<h3 class="text-xl font-semibold mb-3">Customer Details</h3>

		<!-- <div class="grid grid-cols-3 gap-4"> -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

			<div>
				<label class="font-medium">Customer Name <span class="text-red-500">*</span></label>
				<input type="text" name="name" required class="w-full border p-2 rounded">
			</div>

			<div>
				<label class="font-medium">Phone</label>
				<input type="number" name="phone" class="w-full border p-2 rounded" >
			</div>

			<div>
				<label class="font-medium">Email</label>
				<input type="email" name="email" class="w-full border p-2 rounded">
			</div>

			<div>
				<label class="font-medium">Address</label>
				<textarea name="address" class="w-full border p-2 rounded"></textarea>
			</div>
			<div>
				<label class="font-medium">Emirate</label>
				<select name="emirate" class="w-full border p-2 rounded">
					<option value="">-- Select Emirate --</option>
					<option value="Abu Dhabi">Abu Dhabi</option>
					<option value="Dubai">Dubai</option>
					<option value="Sharjah">Sharjah</option>
					<option value="Ajman">Ajman</option>
					<option value="Umm Al Quwain">Umm Al Quwain</option>
					<option value="Ras Al Khaimah">Ras Al Khaimah</option>
					<option value="Fujairah">Fujairah</option>
				</select>

			</div>
			<div>
				<label class="font-medium">TRN</label>
				<input type="text" name="trn" class="w-full border p-2 rounded">
			</div>
		</div>

		<hr class="my-6">

		<!-- VEHICLE SECTION -->
		<h3 class="text-xl font-semibold mb-3">Vehicle Details</h3>

		<div id="vehicleRows">

			<!-- VEHICLE ROW -->
			<!-- <div class="vehicleRow grid grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative"> -->
			<div class="vehicleRow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">

				<!-- DELETE ROW BUTTON -->
				<button type="button"
					onclick="removeVehicleRow(this)"
					class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">
					✖
				</button>

				<div>
					<label class="font-medium">Registration No</label>
					<input name="vehicle_registration_no[]" class="border p-2 rounded w-full" placeholder="A 12345">
				</div>

				<div>
					<label class="font-medium">Brand</label>
					<!-- <input name="vehicle_brand[]" class="border p-2 rounded w-full" placeholder="Toyota"> -->

					<select name="brand_id[]"
						class="brandSelect w-full border p-2 rounded" required>
						<option value="">-- Select Brand --</option>
						<?php foreach ($brands as $b): ?>
							<option value="<?= $b->brand_id ?>">
								<?= $b->brand_name ?>
							</option>
						<?php endforeach; ?>
						<option disabled>────────────────</option>
						<option value="add_brand" data-special="true">+ Add New Brand</option>
					</select>
				</div>

				<div>
					<label class="font-medium">Model</label>
					<!-- <input name="vehicle_model[]" class="border p-2 rounded w-full" placeholder="Innova"> -->
					<select name="model_id[]"
						class="modelSelect w-full border p-2 rounded" required>
						<option value="">-- Select Model --</option>
						<option disabled>────────────────</option>
						<option value="add_model" data-special="true">+ Add Model</option>
					</select>
				</div>

				<div>
					<label class="font-medium">Variant</label>
					<input name="vehicle_variant[]" class="border p-2 rounded w-full" placeholder="Diesel / ZX">
				</div>

				<div>
					<label class="font-medium">Year</label>
					<input type="number" name="vehicle_year[]" class="border p-2 rounded w-full" placeholder="2020">
				</div>

				<div>
					<label class="font-medium">Color</label>
					<input name="vehicle_color[]" class="border p-2 rounded w-full" placeholder="White">
				</div>

				<div>
					<label class="font-medium">Vin No</label>
					<input name="vehicle_chassis_no[]" class="border p-2 rounded w-full" placeholder="VIN Number" required>
				</div>

				<div>
					<label class="font-medium">Engine No</label>
					<input name="vehicle_engine_no[]" class="border p-2 rounded w-full" placeholder="Engine Number">
				</div>

			</div>

		</div>

		<!-- ADD VEHICLE BUTTON -->
		<button type="button" onclick="addVehicleRow()"
			class="px-4 py-2 bg-green-600 text-white rounded mt-2">
			+ Add Another Vehicle
		</button>

		<br><br>

		<button type="submit" id="saveBtn"
			class="px-6 py-2 bg-blue-600 text-white rounded">
			Save Customer & Vehicles
		</button>

	</form>
</div>
<!-- ====================================================== -->


<div id="brandModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
	<div class="bg-white p-6 rounded w-[90%] max-w-md">
		<h3 class="font-bold mb-3">Add Brand</h3>
		<input type="text" id="newBrandName" class="w-full border p-2 mb-4">
		<button onclick="saveBrand()" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
		<button onclick="closeBrandModal()" class="ml-2 px-4 py-2">Cancel</button>
	</div>
</div>

<div id="modelModal"
	class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

	<div class="bg-white p-6 rounded w-[90%] max-w-md">
		<h3 class="text-lg font-bold mb-4">Add Vehicle Model</h3>

		<!-- Brand Select -->
		<label class="font-medium">Brand <span class="text-red-500">*</span></label>
		<select id="modelBrandSelect"
			class="w-full border p-2 rounded mb-3" required>
			<option value="">-- Select Brand --</option>
			<?php foreach ($brands as $b): ?>
				<option value="<?= $b->brand_id ?>">
					<?= $b->brand_name ?>
				</option>
			<?php endforeach; ?>
		</select>

		<!-- Model Name -->
		<label class="font-medium">Model Name <span class="text-red-500">*</span></label>
		<input type="text" id="newModelName"
			class="w-full border p-2 rounded mb-4"
			placeholder="Eg: Corolla, City, Creta">

		<!-- Buttons -->
		<div class="text-right">
			<button onclick="saveModel()"
				class="bg-blue-600 text-white px-4 py-2 rounded">
				Save
			</button>
			<button onclick="closeModelModal()"
				class="ml-2 px-4 py-2">
				Cancel
			</button>
		</div>
	</div>
</div>

<!-- ================================================= -->

<script>
	function addVehicleRow() {
		let html = `
      
			<div class="vehicleRow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">

            <button type="button"
                onclick="removeVehicleRow(this)"
                class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">
                ✖
            </button>

            <div>
                <label class="font-medium">Registration No</label>
                <input name="vehicle_registration_no[]" class="border p-2 rounded w-full" placeholder="A 12345">
			
            </div>

            <div>
                <label class="font-medium">Brand</label>
             
					<select name="brand_id[]" 
						class="brandSelect w-full border p-2 rounded" required>
						<option value="">-- Select Brand --</option>
						<?php foreach ($brands as $b): ?>
							<option value="<?= $b->brand_id ?>">
								<?= $b->brand_name ?>
							</option>
						<?php endforeach; ?>
						<option disabled>────────────────</option>
						<option value="add_brand" data-special="true">+ Add New Brand</option>
					</select>
            </div>

            <div>
                <label class="font-medium">Model</label>
               
				<select name="model_id[]"
						class="modelSelect w-full border p-2 rounded" required>
						<option value="">-- Select Model --</option>
						<option disabled>────────────────</option>
						<option value="add_model" data-special="true">+ Add Model</option>
					</select>
            </div>

            <div>
                <label class="font-medium">Variant</label>
                <input name="vehicle_variant[]" class="border p-2 rounded w-full" placeholder="Diesel / ZX">
            </div>

            <div>
                <label class="font-medium">Year</label>
                <input name="vehicle_year[]" class="border p-2 rounded w-full" placeholder="2020">
            </div>

            <div>
                <label class="font-medium">Color</label>
                <input name="vehicle_color[]" class="border p-2 rounded w-full" placeholder="White">
            </div>

            <div>
                <label class="font-medium">VIN No</label>
                <input name="vehicle_chassis_no[]" class="border p-2 rounded w-full" placeholder="VIN Number" required>
            </div>

            <div>
                <label class="font-medium">Engine No</label>
                <input name="vehicle_engine_no[]" class="border p-2 rounded w-full" placeholder="Engine Number">
            </div>

        </div>
    `;

		document.getElementById('vehicleRows').insertAdjacentHTML('beforeend', html);
	}

	function removeVehicleRow(btn) {
		let rows = document.querySelectorAll('.vehicleRow');
		if (rows.length <= 1) {
			alert("At least one vehicle is required.");
			return;
		}
		btn.parentElement.remove();
	}
	// <input name="vehicle_brand[]" class="border p-2 rounded w-full" placeholder="Toyota">
	// <input name="vehicle_model[]" class="border p-2 rounded w-full" placeholder="Innova">
	// =================================================6-1-26======================

	// $('#brandSelect').on('change', function() {

	// 	let brandId = $(this).val();
	// 	$('#modelSelect').html('<option value="">Loading...</option>');

	// 	if (!brandId) {
	// 		$('#modelSelect').html('<option value="">-- Select Model --</option>');
	// 		return;
	// 	}

	// 	fetch("<?= base_url('index.php/customer/get_models_by_brand/'); ?>" + brandId)
	// 		.then(res => res.json())
	// 		.then(data => {

	// 			let options = '<option value="">-- Select Model --</option>';

	// 			data.forEach(m => {
	// 				options += `<option value="${m.model_id}">
	//                             ${m.model_name}
	//                         </option>`;
	// 			});

	// 			$('#modelSelect').html(options);
	// 		});
	// });
	$(document).on('change', '.brandSelect', function() {

		let brandId = $(this).val();
		let val = $(this).val();

		if (val === 'add_brand') {
			$('#brandModal').removeClass('hidden');
			$(this).val('').trigger('change');
			return;
		}


		let row = $(this).closest('.vehicleRow');
		let modelSelect = row.find('.modelSelect');

		modelSelect.html('<option value="">Loading...</option>');

		if (!brandId) {
			modelSelect.html('<option value="">-- Select Model --</option>');
			return;
		}

		fetch("<?= base_url('index.php/customer/get_models_by_brand/'); ?>" + brandId)
			.then(res => res.json())
			.then(data => {

				let options = '<option value="">-- Select Model --</option>';

				data.forEach(m => {
					options += `<option value="${m.model_id}">
                                ${m.model_name}
                            </option>`;
				});

				modelSelect.html(options);
			});
	});

	$('.modelSelect').on('change', function() {
		if ($(this).val() === 'add_model') {
			// Preselect brand from main form
			$('#modelBrandSelect').val($('#brandSelect').val());
			$('#modelModal').removeClass('hidden');
			$(this).val('');
		}
	});

	function saveBrand() {
		$.post('<?= base_url("index.php/SpareParts/save_brand") ?>', {
				name: $('#newBrandName').val()
			},
			function() {
				location.reload();
			}
		);
	}

	function saveModel() {

		let brandId = $('#modelBrandSelect').val();
		let modelName = $('#newModelName').val();

		if (!brandId || !modelName) {
			alert('Brand and Model Name are required');
			return;
		}

		$.post(
			'<?= base_url("index.php/SpareParts/save_model") ?>', {
				brand_id: brandId,
				name: modelName
			},
			function() {
				closeModelModal();

				// Reload models for selected brand
				$('#brandSelect').trigger('change');
			}
		);
	}


	function closeBrandModal() {
		$('#brandModal').addClass('hidden');
	}

	function closeModelModal() {
		$('#modelModal').addClass('hidden');
	}
</script>
<script>
document.getElementById('saveBtn').addEventListener('click', function () {

    this.disabled = true;
    this.innerText = 'Saving...';

    this.form.submit();

});
</script>
<script>

var isSubmitting = false;

function preventDoubleSubmit(form)
{
    if(isSubmitting)
    {
        return false;
    }

    isSubmitting = true;

    document.getElementById('saveBtn').disabled = true;
    document.getElementById('saveBtn').innerText = 'Saving...';

    return true;
}

</script>

