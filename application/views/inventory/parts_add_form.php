<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<h2 class="text-2xl font-bold mb-4">Add Spare Part</h2>

	<form method="POST" action="<?= base_url('index.php/spareparts/save'); ?>">

		<div class="grid grid-cols-2 gap-4">

			<!-- Brand -->
			<div>
				<label class="font-medium">Brand <span class="text-red-500">*</span></label>
				<select name="brand_id" id="brandSelect" class="w-full border p-2 rounded" required>
					<option value="">-- Select Brand --</option>
					<?php foreach ($brands as $b): ?>
						<option value="<?= $b->brand_id ?>"><?= $b->brand_name ?></option>
					<?php endforeach; ?>
					<option value="add_brand">+ Add Brand</option>
				</select>
			</div>

			<!-- Vehicle Model -->
			<div>
				<label class="font-medium">Vehicle Model <span class="text-red-500">*</span></label>
				<select name="vehicle_model_id" id="modelSelect" class="w-full border p-2 rounded" required>
					<option value="">-- Select Model --</option>
					<option value="add_model">+ Add Model</option>
				</select>
			</div>


			<!-- Part Name -->
			<div class="col-span-2">
				<label class="font-medium">Part Name <span class="text-red-500">*</span></label>
				<input type="text" name="part_name" required
					class="w-full border p-2 rounded"
					placeholder="Brake Pad / Oil Filter / Battery etc.">
			</div>

			<!-- Part Code -->
			<div>
				<label class="font-medium">Part Code</label>
				<input type="text" name="part_code"
					class="w-full border p-2 rounded"
					placeholder="Optional code / SKU">
			</div>

			<!-- Unit Price -->
			<div>
				<label class="font-medium">Unit Price (₹)</label>
				<input type="number" step="0.01" name="unit_price"
					class="w-full border p-2 rounded"
					placeholder="0.00">
			</div>

			<!-- Minimum Stock Alert -->
			<div>
				<label class="font-medium">Minimum Stock</label>
				<input type="number" name="min_stock"
					class="w-full border p-2 rounded"
					placeholder="Alert when stock is below this">
			</div>

		</div>

		<br>

		<!-- Buttons -->
		<button class="px-6 py-2 bg-blue-600 text-white rounded">
			Save Part
		</button>

		<a href="<?= base_url('index.php/spareparts'); ?>"
			class="ml-3 px-6 py-2 bg-gray-300 rounded">
			Cancel
		</a>

	</form>
</div>

<div id="brandModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
	<div class="bg-white p-6 rounded w-96">
		<h3 class="font-bold mb-3">Add Brand</h3>
		<input type="text" id="newBrandName" class="w-full border p-2 mb-4">
		<button onclick="saveBrand()" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
		<button onclick="closeBrandModal()" class="ml-2 px-4 py-2">Cancel</button>
	</div>
</div>

<div id="modelModal"
	class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

	<div class="bg-white p-6 rounded w-96">
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


<script>
	$('#brandSelect, #modelSelect').select2({
		width: '100%'
	});

	$('#brandSelect').on('change', function() {
		let val = $(this).val();

		if (val === 'add_brand') {
			$('#brandModal').removeClass('hidden');
			$(this).val('').trigger('change');
			return;
		}

		// Load models
		$('#modelSelect').html('<option value="">Loading...</option>');
		$.get('<?= base_url("index.php/spareparts/get_models_by_brand/") ?>' + val, function(res) {
			let options = '<option value="">-- Select Model --</option>';
			JSON.parse(res).forEach(m => {
				options += `<option value="${m.model_id}">${m.model_name}</option>`;
			});
			options += '<option value="add_model">+ Add Model</option>';
			$('#modelSelect').html(options);
		});
	});

	$('#modelSelect').on('change', function() {
		if ($(this).val() === 'add_model') {
			// Preselect brand from main form
			$('#modelBrandSelect').val($('#brandSelect').val());
			$('#modelModal').removeClass('hidden');
			$(this).val('');
		}
	});


	function saveBrand() {
		$.post('<?= base_url("index.php/spareparts/save_brand") ?>', {
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
        '<?= base_url("index.php/spareparts/save_model") ?>',
        {
            brand_id: brandId,
            name: modelName
        },
        function () {
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
