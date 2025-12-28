<?php
$totalItems = count($items);
$half = ceil($totalItems / 2);

$leftItems  = array_slice($items, 0, $half);
$rightItems = array_slice($items, $half);
?>

<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<div class="page-header">
		<h2 class="text-center text-xl font-bold mb-4">
			VEHICLE HEALTH CHECK (Inventory)
		</h2>
	</div>

	<form method="post" action="<?= base_url('index.php/inspection/save'); ?>" class="p-6 bg-white">
		<input type="text" name="inspection_id" value="<?= $inspection_id ?>">



		<!-- CUSTOMER / VEHICLE INFO -->
		<table class="w-full border mb-4 text-sm">
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
					<input type="text" name="driver_name"
						class="w-full border px-2 py-1">
				</td>

				<td class="border p-1 font-bold">Veh. Type</td>
				<td class="border p-1">
					<?= $appointment->vehicle_type ?? '-' ?>
				</td>
			</tr>

			<tr>
				<td class="border p-1 font-bold">Driver Mobile</td>
				<td class="border p-1">
					<input type="text" name="driver_mobile"
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


		<!-- INSPECTION ITEMS -->
		<!-- INSPECTION ITEMS (TWO COLUMN LAYOUT) -->
		<div class="grid grid-cols-2 gap-6 mb-4 text-sm">

			<!-- LEFT TABLE -->
			<table class="w-full border">
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

			<!-- RIGHT TABLE -->
			<table class="w-full border">
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

		<div class="bg-white rounded-xl shadow p-4">

			<h3 class="text-lg font-semibold mb-3">Service List</h3>

			<table class="w-full border text-sm" id="serviceTable">
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




		<!-- WORKS REQUESTED -->
		<h4 class="font-bold mb-1">WORKS REQUESTED</h4>
		<div class="grid grid-cols-5 gap-2 mb-4">
			<?php foreach ($works as $w): ?>
				<label><input type="checkbox" name="works_requested[]" value="<?= $w->work_id ?>"  <?= in_array($w->work_id, $selected_works) ? 'checked' : '' ?>> <?= $w->work_name ?></label>
			<?php endforeach; ?>
		</div>

		<!-- INVENTORY STATUS -->
		<h4 class="font-bold mb-1">INVENTORY STATUS</h4>
		<div class="grid grid-cols-5 gap-2 mb-4">
			<?php foreach ($inventory as $inv): ?>
				<label><input type="checkbox" name="inventory_status[]" value="<?= $inv->inventory_status_id ?>" <?= in_array($inv->inventory_status_id, $selected_inventory) ? 'checked' : '' ?>> <?= $inv->status_name ?></label>
			<?php endforeach; ?>
		</div>

		<!-- FOOTER DETAILS -->
		<div class="border mt-6 p-3 text-sm">

			<div class="grid grid-cols-6 gap-3 mb-3">
				<div class="col-span-1">
					<label class="font-bold block">Fuel</label>
					<input name="fuel_level"
						placeholder="1/2" value="<?= $inspection->fuel_level ?>"
						class="border px-2 py-1 w-full">
				</div>

				<div class="col-span-2">
					<label class="font-bold block">Del. Time</label>
					<input name="delivery_time"
						placeholder="3.8.22, 14:17"
						class="border px-2 py-1 w-full">
				</div>

				<div class="col-span-3">
					<label class="font-bold block">Remarks</label>
					<input name="remarks" value= "<?= $inspection->remarks ?>"
						class="border px-2 py-1 w-full">
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
             class="w-64"
             draggable="false">

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
</div>

		</div>

		<!-- SAVE BUTTON -->
	



	</form>

</div>
<script>
	let serviceCount = 0;

	// services list from PHP
	const services = <?= json_encode($services); ?>;

	function addServiceRow() {
		serviceCount++;

		let options = `<option value="">-- Select Service --</option>
                   <option value="custom">-- Custom Service --</option>`;

		services.forEach(s => {
			options += `<option value="${s.master_service_id}">
                        ${s.service_name}
                    </option>`;
		});

		const row = `
        <tr id="srv_${serviceCount}">
            <td class="border px-2 py-2 text-center">
                ${serviceCount}
            </td>

            <td class="border px-2 py-2">
                <select name="service_id[]"
                        onchange="serviceChanged(this)"
                        class="w-full border px-2 py-1 rounded">
                    ${options}
                </select>

                <input type="text"
                       name="custom_service[]"
                       placeholder="Enter custom service description"
                       class="w-full border px-2 py-1 rounded mt-1 hidden">
            </td>

            <td class="border px-2 py-2 text-center">
                <button type="button"
                        onclick="removeService(${serviceCount})"
                        class="bg-red-500 text-white px-3 py-1 rounded">
                    X
                </button>
            </td>
        </tr>
    `;

		document.querySelector('#serviceTable tbody')
			.insertAdjacentHTML('beforeend', row);
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

	function serviceChanged(select) {
		const customInput = select.closest('td')
			.querySelector('input[name="custom_service[]"]');

		if (select.value === 'custom') {
			customInput.classList.remove('hidden');
		} else {
			customInput.classList.add('hidden');
			customInput.value = '';
		}
	}
</script>

<script>
const container = document.getElementById('damageContainer');
const inspectionId = <?= $inspection_id ?>;

// ADD DAMAGE MARK
container.addEventListener('click', function (e) {

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
        headers: {'Content-Type': 'application/json'},
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
document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('damage-mark')) return;

    const markId = e.target.dataset.id;
    e.stopPropagation();

    if (!markId) return;

    fetch("<?= base_url('index.php/inspection/deleteDamageMark'); ?>", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ id: markId })
    })
    .then(res => res.json())
    .then(resp => {
        if (resp.success) {
            e.target.remove();
        }
    });
});
</script>

