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
		<!-- Services -->
		<h3 class="text-lg font-bold mt-5 mb-2">Service List</h3>

		<table class="w-full mb-4 border" id="serviceTable">
			<thead>
				<tr class="bg-gray-200">
					<th class="p-2">Service</th>
					<th class="p-2">Cost</th>
					<th class="p-2">Time (Min)</th>
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

		<!-- ✅ Grand Total -->
<div class="mt-4 text-right">
	<h3 class="text-xl font-bold">
		Total Amount: ₹<span id="grandTotal">0.00</span>
	</h3>

	<input type="hidden" name="grand_total" id="grand_total_input">
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
		calculateTotal();
	});

	// =========================
	// DELETE ROW (SERVICE + PART)
	// =========================
	document.addEventListener("click", function(e) {
		if (e.target.classList.contains("remove-row")) {
			e.target.closest("tr").remove();
			calculateTotal();
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
			calculateTotal();
		}
	});
</script>

<script>
	// ✅ Preload predefined services from PHP
	let servicesMaster = <?= json_encode($services_master); ?>;

	// =========================
	// ADD SERVICE ROW (PREDEFINED + CUSTOM)
	// =========================
	document.getElementById("addService").addEventListener("click", function() {
		let table = document.querySelector("#serviceTable tbody");

		let options = `<option value="">-- Custom Service --</option>`;
		servicesMaster.forEach(s => {
			options += `<option value="${s.service_name}"
                        data-price="${s.estimated_cost}"
                        data-time="${s.estimated_time}">
                        ${s.service_name}
                    </option>`;
		});

		let row = document.createElement("tr");

		row.innerHTML = `
        <td class="p-2">
            <select name="service_name[]" class="serviceSelect w-full border p-2 rounded">
                ${options}
            </select>

            <input type="text" name="custom_service_name[]" 
                   class="customService w-full border p-2 rounded mt-1 hidden"
                   placeholder="Enter custom service">
        </td>

        <td class="p-2">
            <input type="number" name="service_cost[]" 
                   class="serviceCost w-full border p-2 rounded"
                   placeholder="0.00" step="0.01" required>
        </td>

        <td class="p-2">
            <input type="number" name="service_time[]" 
                   class="serviceTime w-full border p-2 rounded"
                   placeholder="0">
        </td>

        <td class="p-2 text-center">
            <button type="button" class="remove-row px-2 py-1 bg-red-500 text-white rounded">X</button>
        </td>
    `;

		table.appendChild(row);
		calculateTotal();
	});

	// =========================
	// AUTO-FILL COST & TIME (PREDEFINED)
	// =========================
	document.addEventListener("change", function(e) {
		if (e.target.classList.contains("serviceSelect")) {
			let selected = e.target;
			let row = selected.closest("tr");

			let cost = selected.selectedOptions[0].getAttribute("data-price");
			let time = selected.selectedOptions[0].getAttribute("data-time");

			let costInput = row.querySelector(".serviceCost");
			let timeInput = row.querySelector(".serviceTime");
			let customInput = row.querySelector(".customService");

			if (selected.value === "") {
				// Custom service
				customInput.classList.remove("hidden");
				costInput.value = "";
				timeInput.value = "";
			} else {
				customInput.classList.add("hidden");
				costInput.value = cost;
				timeInput.value = time;
			}

			calculateTotal();
		}
	});

	// =========================
	// AUTO TOTAL FOR SERVICES + PARTS
	// =========================
	document.addEventListener("input", function(e) {
		if (
			e.target.classList.contains("serviceCost") ||
			e.target.name === "part_qty[]" ||
			e.target.name === "part_price[]"
		) {
			calculateTotal();
		}
	});

	function calculateTotal() {
		let total = 0;

		// ✅ Services Total
		document.querySelectorAll(".serviceCost").forEach(input => {
			let val = parseFloat(input.value || 0);
			total += val;
		});

		// ✅ Parts Total
		document.querySelectorAll("#partsTable tbody tr").forEach(row => {
			let qty = parseFloat(row.querySelector('[name="part_qty[]"]')?.value || 0);
			let price = parseFloat(row.querySelector('[name="part_price[]"]')?.value || 0);
			total += (qty * price);
		});

		document.getElementById("grandTotal").innerText = total.toFixed(2);
		document.getElementById("grand_total_input").value = total.toFixed(2);
	}
</script>

