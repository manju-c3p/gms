<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<style>
	option[data-special="true"] {
		font-weight: 600;
		color: #16a34a;
	}
</style>

<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<h2 class="text-2xl font-bold mb-4">Edit Spare Part</h2>

	<form method="POST"
		action="<?= base_url('index.php/SpareParts/update'); ?>">

		<input type="hidden" name="part_id" value="<?= $part->part_id ?>">

		<div class="grid grid-cols-2 gap-4">

			<!-- Brand -->
			<div>
				<label class="font-medium">Brand <span class="text-red-500">*</span></label>
				<select name="brand_id"
					id="brandSelect"
					class="w-full border p-2 rounded"
					>

					<option value="">-- Select Brand --</option>

					<?php foreach ($brands as $b): ?>
						<option value="<?= $b->brand_id ?>"
							<?= ($b->brand_id == $part->brand_id) ? 'selected' : '' ?>>
							<?= $b->brand_name ?>
						</option>
					<?php endforeach; ?>

					<option value="add_brand" data-special="true">
						➕ Add New Brand
					</option>
				</select>
			</div>

			<!-- Vehicle Model -->
			<div>
				<label class="font-medium">Vehicle Model <span class="text-red-500">*</span></label>
				<select name="vehicle_model_id"
					id="modelSelect"
					class="w-full border p-2 rounded"
					>

					
						<option value="<?= $part->model_id ?>" selected>
							<?= $part->model_name ?>
						</option>
					<?php echo "<option value='add_model'>+ Add Model</option>" ?>
				</select>
			</div>

			<!-- Part Name -->
			<div class="col-span-2">
				<label class="font-medium">Part Name <span class="text-red-500">*</span></label>
				<input type="text"
					name="part_name"
					value="<?= $part->part_name ?>"
					class="w-full border p-2 rounded"
					required>
			</div>

			<!-- Part Code -->
			<div>
				<label class="font-medium">Part Code</label>
				<input type="text"
					name="part_code"
					value="<?= $part->part_code ?>"
					class="w-full border p-2 rounded">
			</div>

			<!-- Unit Price -->
			<div>
				<label class="font-medium">Unit Price</label>
				<input type="number"
					step="0.01"
					name="unit_price"
					value="<?= $part->unit_price ?>"
					class="w-full border p-2 rounded">
			</div>

			<!-- Minimum Stock -->
			<div>
				<label class="font-medium">Minimum Stock</label>
				<input type="number"
					name="min_stock"
					value="<?= $part->min_stock ?>"
					class="w-full border p-2 rounded">
			</div>

			<!-- Part Type -->
			<div>
				<label class="font-medium">Part Type <span class="text-red-500">*</span></label>
				<select name="parttype"
					class="w-full border p-2 rounded"
					required>
					<option value="">-- Select Part Type --</option>
					<option value="New Parts"
						<?= $part->part_type == 'New Parts' ? 'selected' : '' ?>>
						New Parts
					</option>
					<option value="Aftermarket Parts"
						<?= $part->part_type == 'Aftermarket Parts' ? 'selected' : '' ?>>
						Aftermarket Parts
					</option>
					<option value="Used Parts"
						<?= $part->part_type == 'Used Parts' ? 'selected' : '' ?>>
						Used Parts
					</option>
				</select>
			</div>

			<div>
				<label class="font-medium">Warrenty</label>
				<input type="text" name="warrenty"
				value="<?= $part->warrenty ?>"
					class="w-full border p-2 rounded"
					placeholder="">
			</div>

		</div>

		<br>

		<!-- Buttons -->
		<button class="px-6 py-2 bg-blue-600 text-white rounded">
			Update Part
		</button>

		<a href="<?= base_url('index.php/SpareParts'); ?>"
			class="ml-3 px-6 py-2 bg-gray-300 rounded">
			Cancel
		</a>

	</form>
</div>
<script>
	$('#brandSelect, #modelSelect').select2({
		width: '100%'
	});


		$('#brandSelect').on('change', function() {
			// alert('hi');

			let val = $(this).val();

			if (val === 'add_brand') {
				$('#brandModal').removeClass('hidden');
				$(this).val('').trigger('change');
				return;
			}

			$('#modelSelect').html('<option>Loading...</option>');

			$.get('<?= base_url("index.php/SpareParts/get_models_by_brand/") ?>' + val,
				function(res) {

					let options = '<option value="">-- Select Model --</option>';

					JSON.parse(res).forEach(m => {
						options += `<option value="${m.model_id}">${m.model_name}</option>`;
					});

					options += '<option value="add_model">+ Add Model</option>';

					$('#modelSelect').html(options).trigger('change');
				}
			);
		});

	$('#modelSelect').on('change', function() {
		if ($(this).val() === 'add_model') {
			$('#modelBrandSelect').val($('#brandSelect').val());
			$('#modelModal').removeClass('hidden');
			$(this).val('');
		}
	});
</script>
