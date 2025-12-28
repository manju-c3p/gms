<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<h2 class="text-2xl font-bold mb-4">Add Job Card</h2>

	<form action="<?= base_url('index.php/jobcard/save'); ?>" method="POST">

		<!-- Appointment -->
		<div class="mb-4">
			<label class="font-medium">Select Appointment</label>
			<select name="appointment_id" id="appointmentSelect"
				class="w-full border p-2 rounded" required>
				<option value="">-- Select --</option>
				<?php foreach ($appointments as $a): ?>
					<option value="<?= $a->appointment_id ?>"
						data-customer="<?= $a->customer_id ?>"
						data-vehicle="<?= $a->vehicle_id ?>">
						<?= $a->appointment_date ?> →
						<?= $a->customer_name ?> (<?= $a->registration_no ?>)
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<!-- Auto-filled fields -->
		<div class="grid grid-cols-2 gap-4">

			<div>
				<label class="font-medium">Customer</label>
				<input type="text" id="customerName" class="w-full p-2 border rounded bg-gray-100" readonly>
				<input type="hidden" name="customer_id" id="customerId">
			</div>

			<div>
				<label class="font-medium">Vehicle</label>
				<input type="text" id="vehicleName" class="w-full p-2 border rounded bg-gray-100" readonly>
				<input type="hidden" name="vehicle_id" id="vehicleId">
			</div>

		</div>

		<br>

		<!-- Jobcard Date -->
		<div class="mb-4">
			<label class="font-medium">Job Card Date</label>
			<input type="date" name="jobcard_date" value="<?= date('Y-m-d') ?>"
				class="w-full border p-2 rounded" required>
		</div>

		<!-- Technician -->
		<div class="mb-4">
			<label class="font-medium">Technician</label>
			<input type="text" name="technician" class="w-full border p-2 rounded"
				placeholder="Assigned technician">
		</div>

		<!-- Services -->
		<h3 class="text-lg font-bold mt-5 mb-2">Service List</h3>

		<table class="w-full mb-4" id="serviceTable">
			<thead>
				<tr class="bg-gray-200">
					<th class="p-2">Service</th>
					<th class="p-2">Cost</th>
					<th></th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>

		<button type="button" id="addService"
			class="px-3 py-1 bg-blue-600 text-white rounded mb-4">
			+ Add Service
		</button>

		<!-- Parts -->
		<h3 class="text-lg font-bold mt-5 mb-2">Parts Used</h3>

		<table class="w-full mb-4" id="partsTable">
			<thead>
				<tr class="bg-gray-200">
					<th class="p-2">Part</th>
					<th class="p-2">Qty</th>
					<th class="p-2">Unit Price</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($parts as $p): ?>
				<?php endforeach; ?>
			</tbody>
		</table>

		<button type="button" id="addPart"
			class="px-3 py-1 bg-blue-600 text-white rounded mb-4">
			+ Add Part
		</button>

		<!-- Remarks -->
		<div class="mb-4">
			<label class="font-medium">Remarks</label>
			<textarea name="remarks" class="w-full border p-2 rounded"
				placeholder="Notes / Issues"></textarea>
		</div>

		<button class="px-6 py-2 bg-green-600 text-white rounded">
			Save Job Card
		</button>

	</form>
</div>

<script>
	document.getElementById("appointmentSelect").addEventListener("change", function() {
		let opt = this.options[this.selectedIndex];
		document.getElementById("customerId").value = opt.getAttribute("data-customer");
		document.getElementById("vehicleId").value = opt.getAttribute("data-vehicle");
		document.getElementById("customerName").value = opt.textContent.split("→")[1].split("(")[0].trim();
		document.getElementById("vehicleName").value = opt.textContent.match(/\((.*?)\)/)[1];
	});
</script>

<script>
	// =========================
	// ADD SERVICE ROW
	// =========================
	document.getElementById("addService").addEventListener("click", function() {
		let table = document.querySelector("#serviceTable tbody");

		let row = document.createElement("tr");

		row.innerHTML = `
        <td class="p-2">
            <input type="text" name="service_name[]" class="w-full border p-2 rounded" placeholder="Service Name" required>
        </td>
        <td class="p-2">
            <input type="number" name="service_cost[]" class="w-full border p-2 rounded" placeholder="0.00" step="0.01" required>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row px-2 py-1 bg-red-500 text-white rounded">X</button>
        </td>
    `;

		table.appendChild(row);
	});

	// =========================
	// ADD PART ROW
	// =========================

	// PRELOAD PARTS FROM PHP (makes JS easy)
	let partsList = <?= json_encode($parts); ?>;

	document.getElementById("addPart").addEventListener("click", function() {
		let table = document.querySelector("#partsTable tbody");

		let row = document.createElement("tr");

		// Build dropdown options
		let options = "";
		partsList.forEach(p => {
			options += `<option value="${p.part_id}" data-price="${p.unit_price}">
                        ${p.part_name}
                    </option>`;
		});

		row.innerHTML = `
        <td class="p-2">
            <select name="part_id[]" class="partSelect w-full border p-2 rounded" required>
                <option value="">-- Select Part --</option>
                ${options}
            </select>
        </td>

        <td class="p-2">
            <input type="number" name="part_qty[]" class="w-full border p-2 rounded" placeholder="Qty" min="1" required>
        </td>

        <td class="p-2">
            <input type="number" name="part_price[]" class="partPrice w-full border p-2 rounded" placeholder="0.00" step="0.01" required>
        </td>

        <td class="p-2 text-center">
            <button type="button" class="remove-row px-2 py-1 bg-red-500 text-white rounded">X</button>
        </td>
    `;

		table.appendChild(row);
	});

	// =========================
	// DELETE ROW (SERVICE + PART)
	// =========================
	document.addEventListener("click", function(e) {
		if (e.target.classList.contains("remove-row")) {
			e.target.closest("tr").remove();
		}
	});

	// =========================
	// AUTO-FILL UNIT PRICE FOR PART
	// =========================
	document.addEventListener("change", function(e) {
		if (e.target.classList.contains("partSelect")) {
			let price = e.target.selectedOptions[0].getAttribute("data-price");
			let priceInput = e.target.closest("tr").querySelector(".partPrice");
			priceInput.value = price;
		}
	});
</script>
