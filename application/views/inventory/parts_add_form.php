<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<style>
	/* Special option */
	option[data-special="true"] {
		font-weight: 600;
		color: #16a34a;
	}

	/* Disabled visual */
	.opacity-disabled {
		opacity: 0.45;
		pointer-events: none;
	}
</style>

<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<h2 class="text-2xl font-bold mb-6">Add Spare Part</h2>

	<form method="POST" action="<?= base_url('index.php/SpareParts/save'); ?>">

		<div class="grid grid-cols-2 gap-4">

			<!-- PART TYPE (FIRST) -->
			<div class="col-span-2">
				<label class="font-medium">Part Type <span class="text-red-500">*</span></label>
				<select name="parttype" id="partTypeSelect"
					class="w-full border p-2 rounded" required>
					<option value="">-- Select Part Type --</option>
					<option value="New Parts">New Parts</option>
					<option value="Aftermarket Parts">Aftermarket Parts</option>
					<option value="Used Parts">Used Parts</option>
				</select>
			</div>

			<!-- BRAND -->
			<div id="brandWrapper" class="opacity-disabled">
				<label class="font-medium">Brand</label>
				<select name="brand_id" id="brandSelect"
					class="w-full border p-2 rounded" disabled>
					<option value="">-- Select Brand --</option>
					<?php foreach ($brands as $b): ?>
						<option value="<?= $b->brand_id ?>">
							<?= $b->brand_name ?>
						</option>
					<?php endforeach; ?>
					<option value="add_brand" data-special="true">➕ Add New Brand</option>
				</select>
			</div>

			<!-- VEHICLE MODEL -->
			<div id="modelWrapper" class="opacity-disabled">
				<label class="font-medium">Vehicle Model</label>
				<select name="vehicle_model_id" id="modelSelect"
					class="w-full border p-2 rounded" disabled>
					<option value="">-- Select Model --</option>
				</select>
			</div>

			<!-- PART NAME -->
			<div class="col-span-2">
				<label class="font-medium">Part Name <span class="text-red-500">*</span></label>
				<input type="text" name="part_name" required
					class="w-full border p-2 rounded"
					placeholder="Brake Pad / Oil Filter / Battery">
			</div>

			<!-- PART CODE -->
			<div>
				<label class="font-medium">Part Code</label>
				<input type="text" name="part_code"
					class="w-full border p-2 rounded"
					placeholder="Optional SKU">
			</div>

			<!-- UNIT PRICE -->
			<div>
				<label class="font-medium">Unit Price (AED)</label>
				<input type="number" step="0.01" name="unit_price"
					class="w-full border p-2 rounded"
					placeholder="0.00">
			</div>

			<!-- MIN STOCK -->
			<div>
				<label class="font-medium">Minimum Stock</label>
				<input type="number" name="min_stock"
					class="w-full border p-2 rounded"
					placeholder="Low stock alert">
			</div>

			<!-- WARRANTY -->
			<div>
				<label class="font-medium">Warranty</label>
				<input type="text" name="warrenty"
					class="w-full border p-2 rounded"
					placeholder="Eg: 6 Months">
			</div>
			<div class="flex flex-col">
				<div class="flex items-center gap-2">
					<input
						type="checkbox"
						id="labeling"
						name="labeling"
						value="1"
						class="w-4 h-4 border rounded"
						checked>

					<label for="labeling" class="font-medium cursor-pointer">
						Labeled Part
					</label>
				</div>

				<p class="text-sm text-gray-500 ml-6 mt-1">
					Enable this checkbox if labeling needs to be applied to this spare part.
				</p>
			</div>





		</div>

		<br>

		<!-- ACTION BUTTONS -->
		<button class="px-6 py-2 bg-blue-600 text-white rounded">
			Save Part
		</button>

		<a href="<?= base_url('index.php/SpareParts'); ?>"
			class="ml-3 px-6 py-2 bg-gray-300 rounded">
			Cancel
		</a>

	</form>
</div>

<!-- ADD BRAND MODAL -->
<div id="brandModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center">
	<div class="bg-white p-6 rounded w-96">
		<h3 class="font-bold mb-3">Add Brand</h3>
		<input type="text" id="newBrandName" class="w-full border p-2 mb-4">
		<button onclick="saveBrand()" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
		<button onclick="closeBrandModal()" class="ml-2 px-4 py-2">Cancel</button>
	</div>
</div>

<!-- ADD MODEL MODAL -->
<div id="modelModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
	<div class="bg-white p-6 rounded w-96">
		<h3 class="text-lg font-bold mb-4">Add Vehicle Model</h3>

		<label class="font-medium">Brand</label>
		<select id="modelBrandSelect" class="w-full border p-2 rounded mb-3">
			<option value="">-- Select Brand --</option>
			<?php foreach ($brands as $b): ?>
				<option value="<?= $b->brand_id ?>">
					<?= $b->brand_name ?>
				</option>
			<?php endforeach; ?>
		</select>

		<label class="font-medium">Model Name</label>
		<input type="text" id="newModelName"
			class="w-full border p-2 rounded mb-4">

		<div class="text-right">
			<button onclick="saveModel()" class="bg-blue-600 text-white px-4 py-2 rounded">
				Save
			</button>
			<button onclick="closeModelModal()" class="ml-2 px-4 py-2">
				Cancel
			</button>
		</div>
	</div>
</div>

<script>
	$('#brandSelect, #modelSelect').select2({
		width: '100%'
	});

	// PART TYPE LOGIC
	$('#partTypeSelect').on('change', function() {
		let type = $(this).val();

		if (type === 'New Parts') {
			enableVehicleFields();
		} else {
			disableVehicleFields();
		}
	});

	function enableVehicleFields() {
		$('#brandWrapper, #modelWrapper').removeClass('opacity-disabled');
		$('#brandSelect, #modelSelect').prop('disabled', false);
	}

	function disableVehicleFields() {
		$('#brandWrapper, #modelWrapper').addClass('opacity-disabled');
		$('#brandSelect, #modelSelect').prop('disabled', true);
		$('#brandSelect').val('').trigger('change');
		$('#modelSelect').html('<option value="">-- Select Model --</option>');
	}

	// BRAND CHANGE → LOAD MODELS
	$('#brandSelect').on('change', function() {
		let val = $(this).val();

		if (val === 'add_brand') {
			$('#brandModal').removeClass('hidden');
			$(this).val('').trigger('change');
			return;
		}

		if (!val) return;

		$('#modelSelect').html('<option>Loading...</option>');

		$.get('<?= base_url("index.php/SpareParts/get_models_by_brand/") ?>' + val, function(res) {
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
		$.post('<?= base_url("index.php/SpareParts/save_model") ?>', {
				brand_id: $('#modelBrandSelect').val(),
				name: $('#newModelName').val()
			},
			function() {
				closeModelModal();
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

	// INITIAL STATE
	disableVehicleFields();
</script>
