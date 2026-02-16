<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<style>
	option[data-special="true"] {
		font-weight: 600;
		color: #16a34a;
	}

	.opacity-disabled {
		opacity: 0.45;
		pointer-events: none;
	}
</style>

<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<?php if ($this->session->flashdata('error')): ?>
		<div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-3">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>
	<h2 class="text-2xl font-bold mb-6">Edit Spare Part</h2>

	<form method="POST" action="<?= base_url('index.php/SpareParts/update'); ?>">

		<input type="hidden" name="part_id" value="<?= $part->part_id ?>">

		<div class="grid grid-cols-2 gap-4">

			<!-- PART TYPE (FIRST) -->
			<div class="col-span-2">
				<label class="font-medium">Part Type <span class="text-red-500">*</span></label>
				<select name="parttype"
					id="partTypeSelect"
					class="w-full border p-2 rounded"
					required>
					<option value="">-- Select Part Type --</option>
					<option value="New Parts" <?= $part->part_type == 'New Parts' ? 'selected' : '' ?>>
						New Parts
					</option>
					<option value="Aftermarket Parts" <?= $part->part_type == 'Aftermarket Parts' ? 'selected' : '' ?>>
						Aftermarket Parts
					</option>
					<option value="Used Parts" <?= $part->part_type == 'Used Parts' ? 'selected' : '' ?>>
						Used Parts
					</option>
				</select>
			</div>

			<!-- BRAND -->
			<div id="brandWrapper" style="display:none;">
				<label class="font-medium">Brand</label>
				<select name="brand_id"
					id="brandSelect"
					class="w-full border p-2 rounded">
					<option value="">-- Select Brand --</option>
					<?php foreach ($brands as $b): ?>
						<option value="<?= $b->brand_id ?>"
							<?= ($b->brand_id == $part->brand_id) ? 'selected' : '' ?>>
							<?= $b->brand_name ?>
						</option>
					<?php endforeach; ?>
					<option value="add_brand" data-special="true">➕ Add New Brand</option>
				</select>
			</div>

			<!-- VEHICLE MODEL -->
			<div id="modelWrapper" style="display:none;">
				<label class="font-medium">Vehicle Model</label>
				<select name="vehicle_model_id"
					id="modelSelect"
					class="w-full border p-2 rounded">
					<?php if ($part->model_id): ?>
						<option value="<?= $part->model_id ?>" selected>
							<?= $part->model_name ?>
						</option>
					<?php else: ?>
						<option value="">-- Select Model --</option>
					<?php endif; ?>
					<option value="add_model">+ Add Model</option>
				</select>
			</div>

			<!-- PART NAME -->
			<div>
				<label class="font-medium">Part Name <span class="text-red-500">*</span></label>
				<input type="text"
					name="part_name"
					value="<?= $part->part_name ?>"
					class="w-full border p-2 rounded"
					required>
			</div>

			<!-- PART CODE -->
			<div>
				<label class="font-medium">Part Code</label>
				<input type="text"
					name="part_code"
					value="<?= $part->part_code ?>"
					class="w-full border p-2 rounded">
			</div>

			<!-- UNIT PRICE -->
			<div>
				<label class="font-medium">Unit Price</label>
				<input type="number"
					step="0.01"
					name="unit_price"
					value="<?= $part->unit_price ?>"
					class="w-full border p-2 rounded">
			</div>

			<!-- PURCHASE UOM -->
			<div>
				<label class="font-medium">
					Purchase Unit
				</label>

				<select name="purchase_unit_id"
					class="w-full border p-2 rounded"
					<?= $has_stock ? 'disabled' : '' ?>>

					<?php foreach ($units as $u): ?>
						<option value="<?= $u->unit_id ?>"
							<?= ($u->unit_id == $part->purchase_unit_id) ? 'selected' : '' ?>>
							<?= $u->unit_name ?> (<?= $u->unit_abbr ?>)
						</option>
					<?php endforeach; ?>

				</select>
			</div>


			<!-- STOCK UOM -->
			<div>
				<label class="font-medium">
					Stock Unit
				</label>

				<select name="stock_unit_id"
					id="stockUnit"
					class="w-full border p-2 rounded"
					<?= $has_stock ? 'disabled' : '' ?>>

					<?php foreach ($units as $u): ?>
						<option value="<?= $u->unit_id ?>"
							<?= ($u->unit_id == $part->stock_unit_id) ? 'selected' : '' ?>>
							<?= $u->unit_name ?> (<?= $u->unit_abbr ?>)
						</option>
					<?php endforeach; ?>

				</select>
			</div>


			<!-- CONVERSION -->
			<div>
				<label class="font-medium">
					Stock Qty per Purchase Unit
				</label>

				<input type="number"
					step="0.01"
					name="qty_per_purchase_unit"
					id="conversionQty"
					value="<?= $part->qty_per_purchase_unit ?>"
					class="w-full border p-2 rounded"
					<?= $has_stock ? 'readonly' : '' ?>>
			</div>

			<?php if ($has_stock): ?>

				<div class="col-span-2">
					<div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded">
						⚠️ Units cannot be changed because stock already exists.
						Please perform a stock adjustment if conversion must change.
					</div>
				</div>

			<?php endif; ?>


			<!-- MIN STOCK -->
			<div>
				<label class="font-medium">Minimum Stock</label>
				<input type="number"
					name="min_stock"
					value="<?= $part->min_stock ?>"
					class="w-full border p-2 rounded">
			</div>

			<!-- WARRANTY -->
			<div>
				<label class="font-medium">Warranty</label>
				<input
					type="text"
					name="warrenty"
					value="<?= $part->warrenty ?? '' ?>"
					class="w-full border p-2 rounded"
					placeholder="Eg: 6 Months">
			</div>

			<div class="flex flex-col mt-3">
				<div class="flex items-center gap-2">
					<input
						type="checkbox"
						id="labeling"
						name="labeling"
						value="1"
						class="w-4 h-4 border rounded"
						<?= !empty($part->labeling) ? 'checked' : '' ?>>

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

	// ENABLE / DISABLE LOGIC
	function enableVehicleFields() {
		$('#brandWrapper, #modelWrapper').removeClass('opacity-disabled');
		$('#brandSelect, #modelSelect').prop('disabled', false);
	}

	function disableVehicleFields() {
		$('#brandWrapper, #modelWrapper').addClass('opacity-disabled');
		$('#brandSelect, #modelSelect').prop('disabled', true);
	}

	// PART TYPE CHANGE
	$('#partTypeSelect').on('change', function() {
		if ($(this).val() === 'New Parts') {
			enableVehicleFields();
		} else {
			disableVehicleFields();
		}
	});

	// INITIAL LOAD (EDIT PAGE)
	if ($('#partTypeSelect').val() === 'New Parts') {
		// enableVehicleFields();
	} else {
		// disableVehicleFields();
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


	$('#purchaseUnit').on('change', function() {

		let val = $(this).val();

		if (val) {
			$('#stockUnit').val(val);
			$('#conversionQty')
				.val(1);

		}

	});
	$('#stockUnit').on('change', function() {

		if ($(this).val() === $('#purchaseUnit').val()) {

			$('#conversionQty')
				.val(1)
				.prop('readonly', true);

		} else {

			$('#conversionQty')
				.prop('readonly', false)
				.val('');
		}

	});
</script>
