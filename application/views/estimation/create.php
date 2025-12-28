<?php

?>

<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<div class="page-header">
		<h2 class="text-center text-xl font-bold mb-4">
			Estimation
		</h2>
	</div>

	<form method="post" action="<?= base_url('index.php/estimation/save'); ?>" class="p-6 bg-white">
		<input type="hidden" name="estimation_id" value="<?= $estimation_id ?>">



		<!-- CUSTOMER / VEHICLE INFO -->
		<!-- VEHICLE & CUSTOMER DETAILS -->
		<div class="bg-white rounded-2xl shadow-md mb-6">

			<!-- Section Header -->
			<div class="rounded-t-2xl font-semibold">
				Vehicle & Customer Details
			</div>

			<!-- Content -->
			<div class="p-6 grid grid-cols-3 gap-6 text-sm">

				<!-- COLUMN 1 -->
				<div class="space-y-3">


					<div>
						<label class="font-medium block mb-1">Date</label>
						<input type="date" class="w-full border rounded px-2 py-1"
							value="<?= date('Y-m-d') ?>">

					</div>

					<div>
						<label class="font-medium block mb-1">Customer Name</label>
						<input type="text" class="w-full border rounded px-2 py-1" value="<?= $appointment->name ?>">
					</div>



					<div>
						<label class="font-medium block mb-1">Vehicle Model</label>
						<input type="text" class="w-full border rounded px-2 py-1" value="<?= $appointment->model ?>">
					</div>

					<div>
						<label class="font-medium block mb-1">Customer Approval</label>
						<select class="w-full border rounded px-2 py-1">
							<option>-- Select --</option>
						</select>
					</div>

					<div>
						<label class="font-medium block mb-1">Customer Estimated Price</label>
						<input type="text" class="w-full border rounded px-2 py-1">
					</div>
				</div>

				<!-- COLUMN 2 -->
				<div class="space-y-3">
					<div>
						<label class="font-medium block mb-1">Job Card No</label>
						<input type="text" class="w-full border rounded px-2 py-1">
					</div>

					<div>
						<label class="font-medium block mb-1">Time</label>
						<input type="time" class="w-full border rounded px-2 py-1"
							value="<?= date('H:i') ?>">

					</div>

					<div>
						<label class="font-medium block mb-1">Email</label>
						<input type="email" class="w-full border rounded px-2 py-1" value="<?= $appointment->email ?>">
					</div>

					<div>
						<label class="font-medium block mb-1">Vehicle VIN No</label>
						<input type="text" class="w-full border rounded px-2 py-1" value="<?= $appointment->chassis_no ?>">
					</div>



					<div>
						<label class=" font-medium block mb-1">Estimated Delivery Date</label>
						<input type="date" class="w-full border rounded px-2 py-1">
					</div>

					<div>
						<label class="font-medium block mb-1">Check List Remark</label>
						<input type="text" class="w-full border rounded px-2 py-1">
					</div>
				</div>

				<!-- COLUMN 3 -->
				<div class="space-y-3">
					<div>
						<label class="font-medium block mb-1">Estimation No</label>
						<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100" value="<?= $estimation_no; ?>">
					</div>

					<div>
						<label class="font-medium block mb-1">Customer Contact No</label>
						<input type="text" class="w-full border rounded px-2 py-1" value="<?= $appointment->phone ?? '-' ?>">
					</div>

					<div>
						<label class="font-medium block mb-1">Registration No</label>
						<input type="text" class="w-full border rounded px-2 py-1" value="<?= $appointment->registration_no ?>">
					</div>



					<div>
						<label class="font-medium block mb-1">KM's In</label>
						<input type="number" class="w-full border rounded px-2 py-1">
					</div>

					<div>
						<label class="font-medium block mb-1">Completion Time</label>
						<input type="time" class="w-full border rounded px-2 py-1">
					</div>

					<div>
						<label class="font-medium block mb-1">Remark</label>
						<textarea class="w-full border rounded px-2 py-1 h-20"></textarea>
					</div>
				</div>

			</div>
		</div>






		<div class="bg-white rounded-xl shadow p-4 mt-6">

			<h3 class="text-lg font-semibold mb-3">Job Description</h3>

			<table class="w-full border text-sm" id="jobDescTable">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 w-20 text-center">Sl. No</th>
						<th class="border px-3 py-2">Job Description</th>
						<th class="border px-3 py-2 w-24 text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<!-- rows will be added dynamically -->
					<?php if (!empty($job_descriptions)): ?>
						<?php foreach ($job_descriptions as $i => $j): ?>
							<tr>
								<td class="text-center"><?= $i + 1 ?></td>
								<td>
									<input type="text" name="job_description[]"
										value="<?= $j->description ?>"
										class="w-full border p-2 rounded">
								</td>
								<td class="text-center">
									<button type="button"
										class="remove-row bg-red-500 text-white px-2 py-1 rounded">
										X
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>

			<button type="button"
				onclick="addJobRow()"
				class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
				+ Add Row
			</button>
		</div>
		<div class="bg-white rounded-xl shadow p-4 mt-6">
			<h3 class="text-lg font-bold mt-5 mb-2">Spare Parts Used</h3>

			<table class="w-full mb-4" id="partsTable">
				<thead>
					<tr class="bg-gray-200">
						<th class="p-2">#</th>
						<th class="p-2">Part</th>
						<th class="p-2">Qty</th>
						<th class="p-2">Unit Price</th>
						<th class="p-2">Selling Price</th>
						<th class="p-2">Total Price</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($parts_used as $i => $p): ?>
						<tr>
							<td><?= $i + 1 ?></td>

							<td>
								<select name="part_id[]" class="partSelect w-full border p-2 rounded">
									<?php foreach ($parts as $part): ?>
										<option value="<?= $part->part_id ?>"
											<?= $part->part_id == $p->part_id ? 'selected' : '' ?>>
											<?= $part->part_name ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>

							<td><input name="part_qty[]" class="partQty" value="<?= $p->qty ?>"></td>
							<td><input name="part_price[]" class="unitPrice" value="<?= $p->unit_price ?>"></td>
							<td><input name="sell_price[]" class="sellPrice" value="<?= $p->selling_price ?>"></td>
							<td><input name="total_price[]" class="rowTotal" value="<?= $p->total_price ?>" readonly></td>

							<td>
								<button type="button" class="remove-row bg-red-500 text-white px-2 rounded">X</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>

			</table>

			<button type="button" id="addPart"
				class="px-3 py-1 bg-blue-600 text-white rounded mb-4">
				+ Add Part
			</button>

		</div>
		<div class="bg-white rounded-xl shadow p-4 mt-6">
			<h3 class="text-lg font-bold mt-5 mb-2">Labour Charges</h3>

			<table class="w-full mb-4 border" id="serviceTable">
				<thead>
					<tr class="bg-gray-200">
						<th class="p-2">Sl NO</th>
						<th class="p-2">Service</th>

						<th class="p-2">Time (Hr)</th>
						<th class="p-2">Estimated Cost</th>
						<th class="p-2">Total Cost</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($services_used as $i => $s): ?>
						<tr>
							<td><?= $i + 1 ?></td>

							<td>
								<select name="service_id[]" class="serviceSelect w-full border p-2 rounded">
									<option value="">-- Select --</option>
									<?php foreach ($services_master as $sm): ?>
										<option value="<?= $sm->master_service_id ?>"
											<?= $sm->master_service_id == $s->service_id ? 'selected' : '' ?>>
											<?= $sm->service_name ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>

							<td><input name="service_time[]" class="serviceTime" value="<?= $s->estimated_time ?>"></td>
							<td><input name="service_cost[]" class="serviceCost" value="<?= $s->estimated_cost ?>"></td>
							<td><input name="total_cost[]" class="totalCost" value="<?= $s->total_cost ?>" readonly></td>

							<td>
								<button type="button" class="remove-row bg-red-500 text-white px-2 rounded">X</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>

			</table>

			<button type="button" id="addService"
				class="px-3 py-1 bg-blue-600 text-white rounded mb-4">
				+ Add Service
			</button>

		</div>
		<!-- FOOTER DETAILS -->

		<div class="bg-white rounded-xl shadow p-4 mt-6 text-sm">
			<div class="grid grid-cols-4 gap-4">
				<div>
					<label class="font-semibold">Subtotal</label>
					<input id="subtotal" name="subtotal" value="<?= $estimation->subtotal ?>" readonly
						class="w-full border px-2 py-1 bg-gray-100">
				</div>

				<div>
					<label class="font-semibold">Tax (%)</label>
					<input id="tax_percent" value="5"
						class="w-full border px-2 py-1">
				</div>

				<div>
					<label class="font-semibold">Discount</label>
					<input id="discount" value="<?= $estimation->discount ?>"
						class="w-full border px-2 py-1">
				</div>

				<div>
					<label class="font-semibold">Grand Total</label>
					<input id="grand_total" name="grand_total" value="<?= $estimation->grand_total ?>" readonly
						class="w-full border px-2 py-1 bg-gray-100">
				</div>
			</div>
		</div>

		<!-- SAVE BUTTON -->
		<!-- SAVE BUTTON -->
		<div class="text-right mt-6">
			<button type="submit"
				class="px-6 py-2 bg-blue-600 text-white rounded">
				Save Inspection
			</button>
		</div>



	</form>

</div>
<!-- ========================================= script fncs======================== -->
<script>
	/* ===============================
  	 GLOBAL COUNTERS
		================================ */
	let jobRowCount = 0;
	let partCount = 0;
	let serviceCount = 0;

	/* ===============================
	   DATA FROM PHP
	================================ */
	let partsList = <?= json_encode($parts); ?>;
	let servicesMaster = <?= json_encode($services_master); ?>;

	/* ===============================
	   JOB DESCRIPTION
	================================ */
	function addJobRow() {
		jobRowCount++;

		const row = `
        <tr id="job_${jobRowCount}">
            <td class="border px-3 py-2 text-center">${jobRowCount}</td>
            <td class="border px-3 py-2">
                <input type="text" name="job_description[]"
                       class="w-full border px-2 py-1 rounded"
                       placeholder="Enter job description">
            </td>
            <td class="border px-3 py-2 text-center">
                <button type="button"
                        onclick="removeJobRow(${jobRowCount})"
                        class="bg-red-500 text-white px-3 py-1 rounded">
                    Delete
                </button>
            </td>
        </tr>    `;
		document.querySelector("#jobDescTable tbody")
			.insertAdjacentHTML("beforeend", row);
	}

	function removeJobRow(id) {
		document.getElementById("job_" + id)?.remove();
		renumber("#jobDescTable");
	}

	/* ===============================
	   PARTS SECTION
	================================ */
	document.getElementById("addPart").addEventListener("click", function() {
		partCount++;

		let options = `<option value="">-- Select Part --</option>`;
		partsList.forEach(p => {
			options += `<option value="${p.part_id}" data-price="${p.unit_price}">
                        ${p.part_name}
                    </option>`;
		});

		const row = `
        <tr>
            <td class="border px-3 py-2 text-center">${partCount}</td>

            <td>
                <select name="part_id[]" class="partSelect w-full border p-2 rounded">
                    ${options}
                </select>
            </td>

            <td>
                <input type="number" name="part_qty[]"
                       class="partQty w-full border p-2 rounded"
                       value="1" min="1">
            </td>

            <td>
                <input type="number" name="part_price[]"
                       class="unitPrice w-full border p-2 rounded"
                       placeholder="0.00">
            </td>

            <td>
                <input type="number" name="sell_price[]"
                       class="sellPrice w-full border p-2 rounded"
                       placeholder="0.00">
            </td>

            <td>
                <input type="number" name="total_price[]"
                       class="rowTotal w-full border p-2 rounded bg-gray-100"
                       value="0.00" readonly>
            </td>

            <td class="text-center">
                <button type="button"
                        class="remove-row bg-red-500 text-white px-2 py-1 rounded">
                    X
                </button>
            </td>
        </tr>    `;
		document.querySelector("#partsTable tbody").insertAdjacentHTML("beforeend", row);
	});

	/* ===============================
	   SERVICE / LABOUR SECTION
	================================ */
	document.getElementById("addService").addEventListener("click", function() {
		serviceCount++;

		let options = `<option value="">-- Custom Service --</option>`;
		servicesMaster.forEach(s => {
			options += `<option value="${s.master_service_id}"
                    data-price="${s.estimated_cost}"
                    data-time="${s.estimated_time}">
                    ${s.service_name}
                </option>`;
		});

		const row = `
        <tr>
            <td class="border px-3 py-2 text-center">${serviceCount}</td>

            <td>
                <select class="serviceSelect w-full border p-2 rounded" name="service_name[]">
                    ${options}
                </select>

              
            </td>

            <td>
                <input type="number" name="service_time[]"
                       class="serviceTime w-full border p-2 rounded"
                       value="1" min="1">
            </td>

            <td>
                <input type="number" name="service_cost[]"
                       class="serviceCost w-full border p-2 rounded"
                       placeholder="0.00">
            </td>

            <td>
                <input type="number" name="total_cost[]"
                       class="totalCost w-full border p-2 rounded bg-gray-100"
                       value="0.00" readonly>
            </td>

            <td class="text-center">
                <button type="button"
                        class="remove-row bg-red-500 text-white px-2 py-1 rounded">
                    X
                </button>
            </td>
        </tr>    `;
		document.querySelector("#serviceTable tbody").insertAdjacentHTML("beforeend", row);
	});

	/* ===============================
	   CHANGE HANDLERS
	================================ */
	document.addEventListener("change", function(e) {

		// Auto-fill part unit price
		if (e.target.classList.contains("partSelect")) {
			let row = e.target.closest("tr");
			let price = e.target.selectedOptions[0]?.dataset.price || 0;
			row.querySelector(".unitPrice").value = price;
			updatePartRow(row);
		}

		// Auto-fill service time & cost
		if (e.target.classList.contains("serviceSelect")) {
			let row = e.target.closest("tr");
			let opt = e.target.selectedOptions[0];

			let cost = opt?.dataset.price || 0;
			let time = opt?.dataset.time || 1;

			row.querySelector(".serviceCost").value = cost;
			row.querySelector(".serviceTime").value = time;



			updateServiceRow(row);
		}

		calculateGrandTotal();
	});

	/* ===============================
	   INPUT HANDLERS
	================================ */
	document.addEventListener("input", function(e) {

		if (e.target.closest("#partsTable")) {
			updatePartRow(e.target.closest("tr"));
		}

		if (e.target.closest("#serviceTable")) {
			updateServiceRow(e.target.closest("tr"));
		}

		calculateGrandTotal();
	});

	/* ===============================
	   ROW CALCULATIONS
	================================ */
	function updatePartRow(row) {
		let qty = parseFloat(row.querySelector(".partQty")?.value || 1);
		let unit = parseFloat(row.querySelector(".unitPrice")?.value || 0);
		let sell = parseFloat(row.querySelector(".sellPrice")?.value || 0);

		let price = sell > 0 ? sell : unit;
		row.querySelector(".rowTotal").value = (qty * price).toFixed(2);
	}

	function updateServiceRow(row) {
		let time = parseFloat(row.querySelector(".serviceTime")?.value || 1);
		let cost = parseFloat(row.querySelector(".serviceCost")?.value || 0);
		row.querySelector(".totalCost").value = (time * cost).toFixed(2);
	}

	/* ===============================
	   DELETE ROWS
	================================ */
	document.addEventListener("click", function(e) {
		if (e.target.classList.contains("remove-row")) {
			e.target.closest("tr").remove();
			renumber("#partsTable");
			renumber("#serviceTable");
			calculateGrandTotal();
		}
	});

	/* ===============================
	   GRAND TOTAL
	================================ */
	function calculateGrandTotal() {

		let serviceTotal = 0;
		document.querySelectorAll(".totalCost").forEach(el =>
			serviceTotal += parseFloat(el.value || 0)
		);

		let partsTotal = 0;
		document.querySelectorAll(".rowTotal").forEach(el =>
			partsTotal += parseFloat(el.value || 0)
		);

		let subtotal = serviceTotal + partsTotal;

		let taxPercent = parseFloat(document.getElementById("tax_percent")?.value || 0);
		let discount = parseFloat(document.getElementById("discount")?.value || 0);

		let taxAmount = subtotal * taxPercent / 100;
		let grandTotal = subtotal + taxAmount - discount;

		document.getElementById("subtotal").value = subtotal.toFixed(2);
		document.getElementById("grand_total").value = grandTotal.toFixed(2);
	}

	/* ===============================
	   RENUMBER UTILITY
	================================ */
	function renumber(tableId) {
		document.querySelectorAll(`${tableId} tbody tr`)
			.forEach((row, i) => row.querySelector("td").innerText = i + 1);
	}
</script>
