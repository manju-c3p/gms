<?php
$totalItems = count($items);
$half = ceil($totalItems / 2);

$leftItems  = array_slice($items, 0, $half);
$rightItems = array_slice($items, $half);
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">


	<form method="post" enctype="multipart/form-data" action="<?= base_url('index.php/inspection/save'); ?>" class="p-6 bg-white">
		<input type="hidden" name="inspection_id" value="<?= $inspection_id ?>">

		<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">


			<h2 class="text-xl font-bold">
				VEHICLE HEALTH CHECK (Inventary)
			</h2>
			<div class="flex flex-col sm:flex-row gap-2">



				<a href="<?= base_url('index.php/Inspection/view/' . $inspection_id) ?>" class="px-6 py-2 bg-gray-400 text-white rounded">
					View & Print
				</a>
				<a href="<?= base_url('index.php/estimation/create/' . $appointment->appointment_id) ?>" class="px-6 py-2 bg-green-600 text-white rounded">
					Estimation
				</a>

				<!-- SAVE BUTTON -->
				<button type="submit"
					class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded">
					Update
				</button>

				<a href="<?= base_url('index.php/appointment'); ?>"
					class="w-full sm:w-auto px-6 py-2 bg-gray-300 rounded">Cancel</a>
			</div>
		</div>
		<hr class="border-gray-300 mb-6">
		<!-- CUSTOMER / VEHICLE INFO -->
		<div class="overflow-x-auto">
			<table class="w-full border mb-4 text-sm min-w-[600px]">

				<tr>
					<td class="border p-1 font-bold w-1/6">Doc. No</td>
					<td class="border p-1 w-2/6">
						<?= $appointment->doc_no ?? ('VIN-' . str_pad($inspection_id, 6, '0', STR_PAD_LEFT)) ?>
					</td>

					<td class="border p-1 font-bold w-1/6">Doc. Date</td>
					<td class="border p-1 w-2/6">
						<?= date('d/M/Y') ?>
					</td>
				</tr>

				<tr>
					<td class="border p-1 font-bold">Customer Name</td>
					<td class="border p-1">
						<?= $appointment->customer_name ?>
					</td>

					<td class="border p-1 font-bold">Reg. No.</td>
					<td class="border p-1">
						<?= $appointment->registration_no ?>
					</td>
				</tr>

				<tr>
					<td class="border p-1 font-bold">Contact No.</td>
					<td class="border p-1">
						<?= $appointment->phone ?? '-' ?>
					</td>

					<td class="border p-1 font-bold">Make</td>
					<td class="border p-1">
						<?= $appointment->model ?>
					</td>
				</tr>

				<tr>
					<td class="border p-1 font-bold">Driver Name</td>
					<td class="border p-1">
						<input type="text" name="driver_name" value="<?= $inspection->drivername ?>"
							class="w-full border px-2 py-1">
					</td>

					<td class="border p-1 font-bold">Veh. Type</td>
					<td class="border p-1">
						<?= $appointment->variant ?? '-' ?>
					</td>
				</tr>

				<tr>
					<td class="border p-1 font-bold">Driver Mobile</td>
					<td class="border p-1">
						<input type="number" name="driver_mobile" value="<?= $inspection->driverphno ?>"
							class="w-full border px-2 py-1">
					</td>

					<td class="border p-1 font-bold">Model</td>
					<td class="border p-1">
						<?= $appointment->year ?>
					</td>
				</tr>

				<tr>
					<td class="border p-1 font-bold">Service Advisor</td>
					<td class="border p-1">
						<?= $this->session->userdata('username') ?>
					</td>

					<td class="border p-1 font-bold">KM</td>
					<td class="border p-1">
						<input type="number" name="km_reading"
							value="<?= $inspection->km_reading ?>"
							class="w-full border px-2 py-1">
					</td>
				</tr>
			</table>
		</div>


		<!-- INSPECTION ITEMS -->

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-4 text-sm">


			<!-- LEFT TABLE -->
			<div class="overflow-x-auto">
				<table class="w-full border min-w-[400px]">
					<thead class="bg-gray-100">
						<tr>
							<th class="border p-1">Inspection Items</th>
							<th class="border p-1 w-8">A</th>
							<th class="border p-1 w-8">C</th>
							<th class="border p-1 w-8">S</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($leftItems as $index => $i): ?>
							<tr>
								<td class="border p-1">
									<?= ($index + 1) ?>. <?= $i->item_name ?>
								</td>
								<td class="border text-center">
									<input type="radio"
										name="item_status[<?= $i->item_id ?>]"
										value="A" <?= ($item_results[$i->item_id] ?? '') == 'A' ? 'checked' : '' ?>>
								</td>
								<td class="border text-center">
									<input type="radio"
										name="item_status[<?= $i->item_id ?>]"
										value="C" <?= ($item_results[$i->item_id] ?? '') == 'C' ? 'checked' : '' ?>>
								</td>
								<td class="border text-center">
									<input type="radio"
										name="item_status[<?= $i->item_id ?>]"
										value="S" <?= ($item_results[$i->item_id] ?? '') == 'S' ? 'checked' : '' ?>>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<!-- RIGHT TABLE -->
			<div class="overflow-x-auto">
				<table class="w-full border min-w-[400px]">
					<thead class="bg-gray-100">
						<tr>
							<th class="border p-1">Inspection Items</th>
							<th class="border p-1 w-8">A</th>
							<th class="border p-1 w-8">C</th>
							<th class="border p-1 w-8">S</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($rightItems as $index => $i): ?>
							<tr>
								<td class="border p-1">
									<?= ($half + $index + 1) ?>. <?= $i->item_name ?>
								</td>
								<td class="border text-center">
									<input type="radio"
										name="item_status[<?= $i->item_id ?>]"
										value="A">
								</td>
								<td class="border text-center">
									<input type="radio"
										name="item_status[<?= $i->item_id ?>]"
										value="C">
								</td>
								<td class="border text-center">
									<input type="radio"
										name="item_status[<?= $i->item_id ?>]"
										value="S">
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>





		</div>
		<div class="mt-3 text-sm flex flex-col sm:items-end sm:text-right">

			<p class="font-semibold mb-2">Legend:</p>

			<div class="flex flex-wrap justify-end gap-6">
				<div class="flex items-center gap-2">
					<span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
					<span><strong>A</strong> – Acceptable</span>
				</div>

				<div class="flex items-center gap-2">
					<span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
					<span><strong>C</strong> – Conditionally Acceptable</span>
				</div>

				<div class="flex items-center gap-2">
					<span class="inline-block w-3 h-3 rounded-full bg-red-500"></span>
					<span><strong>S</strong> – Service Needed</span>
				</div>
			</div>
		</div>

		<div class="bg-white rounded-xl shadow p-4">

			<h3 class="text-lg font-semibold mb-3">Service List</h3>

			<div class="overflow-x-auto">
				<table class="w-full border text-sm min-w-[500px]" id="serviceTable">

					<thead class="bg-blue-500 text-white">
						<tr>
							<th class="border px-2 py-2 w-20 text-center">Sl. No.</th>
							<th class="border px-2 py-2">Description / Service</th>
							<th class="border px-2 py-2 w-16 text-center">Action</th>
						</tr>
					</thead>

					<tbody>
						<!-- dynamic rows -->
						<?php foreach ($saved_services as $index => $srv): ?>
							<tr>
								<td><?= $index + 1 ?></td>
								<td>
									<?php if ($srv->service_id): ?>
										<?= $service_map[$srv->service_id] ?>
									<?php else: ?>
										<?= $srv->custom_text ?>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>
			</div>

			<button type="button"
				onclick="addServiceRow()"
				class="w-full sm:w-auto mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg">
				+ Add Service
			</button>
		</div>




		<!-- WORKS REQUESTED -->
		<!-- <h4 class="font-bold mb-1">WORKS REQUESTED</h4>
		<div class="grid grid-cols-5 gap-2 mb-4">
			<?php
			// foreach ($works as $w):
			?>
				<label><input type="checkbox" name="works_requested[]" value="<?= $w->work_id ?>" <?= in_array($w->work_id, $selected_works) ? 'checked' : '' ?>> <?= $w->work_name ?></label>
			<?php
			// endforeach;
			?>
		</div> -->

		<!-- INVENTORY STATUS -->
		<h4 class="font-bold mb-1">INVENTORY STATUS</h4>
		<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
			<?php foreach ($inventory as $inv): ?>
				<label><input type="checkbox" name="inventory_status[]" value="<?= $inv->inventory_status_id ?>" <?= in_array($inv->inventory_status_id, $selected_inventory) ? 'checked' : '' ?>> <?= $inv->status_name ?></label>
			<?php endforeach; ?>
		</div>

		<!-- FOOTER DETAILS -->
		<div class="border mt-6 p-3 text-sm">

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 mb-3">
				<div class="col-span-1">
					<label class="font-bold block">Fuel</label>
					<input name="fuel_level"
						placeholder="1/2" value="<?= $inspection->fuel_level ?>"
						class="border px-2 py-1 w-full">
				</div>

				<div class="col-span-1">
					<label class="font-bold block">Estimated Del. Date</label>
					<input name="delivery_date" type="date"
						placeholder="3.8.22, 14:17" value="<?= $inspection->deliverydate ?>"
						class="border px-2 py-1 w-full">
				</div>
				<div class="col-span-1">
					<label class="font-bold block">Estimated Del. Time</label>
					<input name="delivery_time" type="time"
						placeholder="3.8.22, 14:17" value="<?= $inspection->deliverytime ?>"
						class="border px-2 py-1 w-full">
				</div>


				<div class="col-span-4">
					<label class="font-bold block">Remarks</label>
					<input name="remarks" value="<?= $inspection->remarks ?>"
						class="border px-2 py-1 w-full">
				</div>
				<div class="col-span-5">
					<label class="font-bold block">Inspection Package</label>

					<select class="w-full border rounded px-2 py-1" name="inspackage">
						<option value="">-- Select Package --</option>

						<?php foreach ($packages as $pkg) : ?>
							<option value="<?= $pkg->id ?>"
								<?= (!empty($inspection) && $inspection->inspackage == $pkg->id) ? 'selected' : '' ?>>
								<?= $pkg->package_name ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<!-- VEHICLE PHOTOS -->
				<div class="col-span-12">
					<h4 class="font-bold mb-2">Vehicle Photos (Max 12)</h4>

					<!-- Upload new photos -->
					<input type="file"
						name="inspection_photos[]"
						id="photoInput"
						accept="image/*"
						capture="environment"
						multiple
						class="border p-2 rounded w-full">
					<hr>




					<!-- Preview Grid -->
					<div id="photoPreview"
						class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mt-3">


						<!-- EXISTING PHOTOS -->
						<?php foreach ($inspection_photos as $p): ?>
							<div class="relative group" id="photo_<?= $p->photo_id ?>">
								<img src="<?= base_url($p->image_path) ?>"
									onclick="openImageModal(this.src)"
									class="w-full h-24 object-cover rounded cursor-pointer border">

								<button type="button"
									onclick="deletePhoto(<?= $p->photo_id ?>)"
									class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-xs hidden group-hover:flex items-center justify-center">
									✕
								</button>
							</div>
						<?php endforeach; ?>

					</div>
				</div>

			</div>

			<!-- VEHICLE DAMAGE DIAGRAM -->
			<!-- VEHICLE DAMAGE MARKING -->
			<div class="mt-6">
				<h4 class="font-bold mb-2">Vehicle Damage Diagram</h4>

				<div id="damageContainer"
					class="relative inline-block border p-2 cursor-crosshair">

					<img src="<?= base_url('public/images/vehicle-diagram.jpg'); ?>"
						id="vehicleImage"
						class="w-full max-w-xs sm:max-w-sm""
						draggable=" false">

					<!-- Existing marks (edit/view) -->
					<?php if (!empty($damage_marks)): ?>
						<?php foreach ($damage_marks as $m): ?>
							<span class="damage-mark absolute text-red-600 font-bold text-lg cursor-pointer"
								data-id="<?= $m->id ?>"
								style="left:<?= $m->x_coordinate ?>px;
                             top:<?= $m->y_coordinate ?>px;">
								✖
							</span>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<p class="text-xs text-gray-500 mt-1">
					Click on vehicle to mark damage. Click ❌ again to remove.
				</p>


				<div class="col-span-3">
					<label class="font-bold block">Technician Remarks</label>
					<input name="tecremarks" value="<?= $inspection->techremarks ?>"
						class="border px-2 py-1 w-full">
				</div>
			</div>

		</div>





	</form>

</div>

<div id="imageModal"
	class="bg-white rounded-xl w-full max-w-md p-4">

	<button onclick="closeImageModal()"
		class="absolute top-4 right-4 text-white text-3xl font-bold">
		✕
	</button>

	<img id="modalImage"
		src=""
		class="max-h-[90vh] max-w-[90vw] rounded shadow-lg">
</div>
<div id="serviceModal"
	class="bg-white rounded-xl w-full max-w-md p-4">


	<h3 class="text-lg font-semibold mb-3">Add New Service</h3>

	<div class="mb-3">
		<label class="text-sm font-medium">Service Name</label>
		<input type="text" id="new_service_name"
			class="w-full border rounded px-2 py-1">
	</div>

	<div class="mb-3">
		<label class="text-sm font-medium">Service Type</label>
		<select id="new_service_type"
			class="w-full border rounded px-2 py-1">
			<option value="SERVICE">Service</option>
			<option value="LABOUR">Labour</option>
			<option value="OTHER">Other</option>
		</select>
	</div>

	<div class="mb-3">
		<label class="text-sm font-medium">Estimated Cost</label>
		<input type="number" step="0.01" id="new_service_cost"
			class="w-full border rounded px-2 py-1">
	</div>

	<div class="mb-3">
		<label class="text-sm font-medium">Estimated Time (mins)</label>
		<input type="number" id="new_service_time"
			class="w-full border rounded px-2 py-1">
	</div>

	<div class="flex justify-end gap-2">
		<button onclick="closeServiceModal()"
			class="px-3 py-1 border rounded">
			Cancel
		</button>
		<button onclick="saveNewService()"
			class="px-4 py-1 bg-blue-600 text-white rounded">
			Save
		</button>
	</div>
</div>


<style>
	input,
	select,
	textarea,
	table {
		max-width: 100%;
	}
</style>

<script>
	$(document).ready(function() {
		$('.service-select').select2({
			width: '100%'
		});
	});

	let serviceCount = 0;

	// services list from PHP
	const services = <?= json_encode($services); ?>;


	function addServiceRow() {
		serviceCount++;

		let options = `<option value="">-- Select Service --</option>
                   <option value="add_new">-- New Service --</option>`;

		services.forEach(s => {
			options += `<option value="${s.master_service_id}">
                        ${s.service_name}
                    </option>`;
		});

		const row = `
    		<tr id="srv_${serviceCount}">
        <td class="border px-2 py-2 text-center">${serviceCount}</td>

        <td class="border px-2 py-2">
            <select name="service_id[]"
                    class="service-select w-full">
                ${options}
            </select>
        </td>

        <td class="border px-2 py-2 text-center">
            <button type="button"
                    onclick="removeService(${serviceCount})"
                    class="bg-red-500 text-white px-3 py-1 rounded">
                X
            </button>
        </td>
    	</tr>`;

		// ✅ Append row first
		$('#serviceTable tbody').append(row);

		// ✅ NOW define $select (this was missing / misplaced earlier)
		const $select = $('#srv_' + serviceCount + ' .service-select');

		// ✅ Initialize Select2
		$select.select2({
			width: '100%'
		});

		// ✅ Handle "Add New Service"
		$select.on('select2:select', function(e) {
			if (e.params.data.id === 'add_new') {
				$(this).val('').trigger('change');
				openServiceModal(this);
			}
		});
	}

	function removeService(id) {
		document.getElementById('srv_' + id)?.remove();
		renumberRows();
	}

	function renumberRows() {
		let rows = document.querySelectorAll('#serviceTable tbody tr');
		rows.forEach((row, index) => {
			row.querySelector('td').innerText = index + 1;
		});
	}


	// function serviceChanged(select) {
	// 	const customInput = select.closest('td')
	// 		.querySelector('input[name="custom_service[]"]');

	// 	if (select.value === 'add_new') {
	// 		customInput.classList.remove('hidden');
	// 	} else {
	// 		customInput.classList.add('hidden');
	// 		customInput.value = '';
	// 	}
	// }



	let activeServiceSelect = null;

	/* Called when "-- New Service --" is selected */
	function openServiceModal(selectEl) {
		activeServiceSelect = selectEl;
		$('#serviceModal').removeClass('hidden').addClass('flex');
	}

	function closeServiceModal() {
		$('#serviceModal').addClass('hidden').removeClass('flex');

		// reset fields
		$('#new_service_name').val('');
		$('#new_service_type').val('SERVICE');
		$('#new_service_cost').val('');
		$('#new_service_time').val('');
	}

	/* SAVE NEW SERVICE */
	function saveNewService() {

		const serviceName = $('#new_service_name').val().trim();
		const serviceType = $('#new_service_type').val();
		const cost = $('#new_service_cost').val();
		const time = $('#new_service_time').val();

		if (serviceName === '') {
			alert('Service name is required');
			return;
		}

		$.ajax({
			url: "<?= base_url('index.php/ServiceMaster/save_ajax') ?>",
			type: "POST",
			dataType: "json",
			data: {
				service_name: serviceName,
				service_type: serviceType,
				estimated_cost: cost,
				estimated_time: time
			},
			success: function(res) {

				if (res.status === 'success') {

					const service = res.service;

					// ✅ Add to global services array
					services.push(service);

					// ✅ Add new option to ALL Select2 dropdowns
					$('.service-select').each(function() {

						const option = new Option(
							service.service_name,
							service.master_service_id,
							false,
							false
						);

						this.append(option);
					});

					// ✅ Auto-select in the active dropdown
					$(activeServiceSelect)
						.val(service.master_service_id)
						.trigger('change');

					closeServiceModal();

				} else {
					alert(res.message);
				}
			},
			error: function() {
				alert('Something went wrong while saving service');
			}
		});
	}
</script>

<script>
	const container = document.getElementById('damageContainer');
	const inspectionId = <?= $inspection_id ?>;

	// ADD DAMAGE MARK
	container.addEventListener('click', function(e) {

		// Prevent adding when clicking existing mark
		if (e.target.classList.contains('damage-mark')) return;

		const rect = container.getBoundingClientRect();
		const x = Math.round(e.clientX - rect.left);
		const y = Math.round(e.clientY - rect.top);

		// Create mark visually
		const mark = document.createElement('span');
		mark.innerHTML = '✖';
		mark.className = 'damage-mark absolute text-red-600 font-bold text-lg cursor-pointer';
		mark.style.left = x + 'px';
		mark.style.top = y + 'px';

		container.appendChild(mark);

		// Save to DB
		fetch("<?= base_url('index.php/inspection/saveDamageMark'); ?>", {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					inspection_id: inspectionId,
					x: x,
					y: y
				})
			})
			.then(res => res.json())
			.then(resp => {
				if (resp.id) {
					mark.dataset.id = resp.id;
				}
			});
	});

	// REMOVE DAMAGE MARK
	document.addEventListener('click', function(e) {
		if (!e.target.classList.contains('damage-mark')) return;

		const markId = e.target.dataset.id;
		e.stopPropagation();

		if (!markId) return;

		fetch("<?= base_url('index.php/inspection/deleteDamageMark'); ?>", {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					id: markId
				})
			})
			.then(res => res.json())
			.then(resp => {
				if (resp.success) {
					e.target.remove();
				}
			});
	});
</script>
<script>
	const photoInput = document.getElementById('photoInput');
	const previewContainer = document.getElementById('photoPreview');
	const imageModal = document.getElementById('imageModal');
	const modalImage = document.getElementById('modalImage');

	let selectedFiles = []; // 🔹 NEW: store newly added images only

	photoInput.addEventListener('change', function() {

		const newFiles = Array.from(this.files);

		// Count existing previews (saved + new)
		const existingCount = previewContainer.querySelectorAll('.preview-item').length;

		if (existingCount + newFiles.length > 50) {
			alert('Maximum 12 photos allowed');
			this.value = '';
			return;
		}

		newFiles.forEach(file => selectedFiles.push(file));
		this.value = ''; // 🔥 allow selecting same file again

		renderNewPreviews();
	});

	function renderNewPreviews() {

		// Remove only NEW previews before re-render
		document.querySelectorAll('.new-photo').forEach(el => el.remove());

		selectedFiles.forEach((file, index) => {
			const reader = new FileReader();

			reader.onload = function(e) {

				const wrap = document.createElement('div');
				wrap.className = 'relative preview-item new-photo group';

				wrap.innerHTML = `
					<img src="${e.target.result}"
						onclick="openImageModal(this.src)"
						class="w-full h-24 object-cover rounded border cursor-pointer hover:scale-105 transition">

					<button type="button"
						onclick="removeNewPhoto(${index})"
						class="absolute top-1 right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded hidden group-hover:block">
						✕
					</button>
				`;

				previewContainer.appendChild(wrap);
			};

			reader.readAsDataURL(file);
		});
	}

	function removeNewPhoto(index) {
		selectedFiles.splice(index, 1);
		renderNewPreviews();
	}

	/* MODAL */
	function openImageModal(src) {
		modalImage.src = src;
		imageModal.classList.remove('hidden');
		imageModal.classList.add('flex');
	}

	function closeImageModal() {
		imageModal.classList.add('hidden');
		imageModal.classList.remove('flex');
	}

	/* DELETE SAVED PHOTO (DB IMAGE) */
	function deletePhoto(photoId) {

		if (!confirm('Are you sure you want to delete this photo?')) {
			return;
		}

		fetch("<?= base_url('index.php/inspection/deletePhoto'); ?>", {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					photo_id: photoId
				})
			})
			.then(res => res.json())
			.then(resp => {
				if (resp.success) {
					document.getElementById('photo_' + photoId)?.remove();
				} else {
					alert('Failed to delete photo');
				}
			});
	}

	/* 🔥 IMPORTANT: Attach new files before submit */
	document.querySelector('form').addEventListener('submit', function() {
		const dt = new DataTransfer();
		selectedFiles.forEach(file => dt.items.add(file));
		photoInput.files = dt.files;
	});
</script>
