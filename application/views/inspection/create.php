<?php
$totalItems = count($items);
$half = ceil($totalItems / 2);

$leftItems  = array_slice($items, 0, $half);
$rightItems = array_slice($items, $half);
?>

<form method="post" action="<?= base_url('inspection/save'); ?>" class="p-6 bg-white">
	<input type="hidden" name="inspection_id" value="<?= $inspection_id ?>">

	<h2 class="text-center text-xl font-bold mb-4">
		VEHICLE HEALTH CHECK (Inventory)
	</h2>

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
					value=""
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
			</tbody>
		</table>

		<button type="button"
			onclick="addServiceRow()"
			class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg">
			+ Add Service
		</button>
	</div>




	<!-- WORKS REQUESTED -->
	<h4 class="font-bold mb-1">WORKS REQUESTED</h4>
	<div class="grid grid-cols-5 gap-2 mb-4">
		<?php foreach ($works as $w): ?>
			<label><input type="checkbox" name="works_requested[]" value="<?= $w->work_id ?>"> <?= $w->work_name ?></label>
		<?php endforeach; ?>
	</div>

	<!-- INVENTORY STATUS -->
	<h4 class="font-bold mb-1">INVENTORY STATUS</h4>
	<div class="grid grid-cols-5 gap-2 mb-4">
		<?php foreach ($inventory as $inv): ?>
			<label><input type="checkbox" name="inventory_status[]" value="<?= $inv->inventory_status_id ?>"> <?= $inv->status_name ?></label>
		<?php endforeach; ?>
	</div>

	<!-- FOOTER DETAILS -->
	<div class="border mt-6 p-3 text-sm">

		<div class="grid grid-cols-6 gap-3 mb-3">
			<div class="col-span-1">
				<label class="font-bold block">Fuel</label>
				<input name="fuel_level"
					placeholder="1/2"
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
				<input name="remarks"
					class="border px-2 py-1 w-full">
			</div>
		</div>

		<!-- VEHICLE DAMAGE DIAGRAM -->
		<div class="flex gap-6 items-start">

			<!-- IMAGE + MARKS -->
			<div id="damage-container" class="relative border p-2">
				<img src="<?= base_url('public/images/vehicle-diagram.jpg'); ?>"
					id="vehicle-image"
					class="w-64">

				<!-- EXISTING DAMAGE MARKS (for edit/view) -->
				<?php if (!empty($damage_marks)): ?>
					<?php foreach ($damage_marks as $m): ?>
						<span class="absolute text-red-600 font-bold text-lg"
							style="left:<?= $m->x_coordinate ?>px;
                                 top:<?= $m->y_coordinate ?>px;">
							✖
						</span>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<!-- NOTE -->
			<div class="text-xs text-gray-600 mt-2">
				<p><b>Note:</b> Click on the vehicle image to mark damages.</p>
				<p>Click ❌ again to remove.</p>
			</div>

		</div>
	</div>

	<!-- SAVE BUTTON -->
	<div class="text-right mt-6">
		<button type="submit"
			class="px-6 py-2 bg-blue-600 text-white rounded">
			Save Inspection
		</button>
	</div>



</form>


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

