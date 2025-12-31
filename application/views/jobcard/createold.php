<?php

?>

<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<div class="page-header">
		<h2 class="text-center text-xl font-bold mb-4">
			Job Card
		</h2>
	</div>

	<form method="post" action="<?= base_url('index.php/jobcard/save'); ?>" class="p-6 bg-white">
		<input type="hidden" name="jobcard_id" value="<?= $jobcard_id ?>">



		<!-- CUSTOMER / VEHICLE INFO -->
		<!-- VEHICLE & CUSTOMER DETAILS -->


		<div class="bg-white rounded-2xl shadow-md mb-6 overflow-hidden">

			<!-- Header -->
			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Vehicle & Customer Details
			</div>

			<!-- Table -->
			<table class="w-full text-sm border-collapse">
				<tbody>

					<!-- ROW 1 -->
					<tr class="border-b">
						<td class="w-[13%] px-3 py-1 font-medium bg-gray-50">Date</td>
						<td class="w-[20%] px-3 py-1">
							<input type="date" class="w-full border rounded px-2 py-1"
								value="<?= date('Y-m-d') ?>">
						</td>

						<td class="w-[13%] px-3 py-1  font-medium bg-gray-50">Job Card No</td>
						<td class="w-[20%] px-3 py-1 ">
							<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100" value="<?= $jobcard_no ?>" readonly>
						</td>

						<td class="w-[13%] px-3 py-1 font-medium bg-gray-50">Estimation No</td>
						<td class="w-[20%] px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $estimation_no ?>" readonly>
						</td>
					</tr>

					<!-- ROW 2 -->
					<tr class="border-b">
						<td class="w-[13%] px-3 py-1 font-medium bg-gray-50">Customer Name</td>
						<td class="w-[20%] px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->name ?>" readonly>
						</td>

						<td class="px-3 py-1 font-medium bg-gray-50">Time</td>
						<td class="px-3 py-1 ">
							<input type="time"
								class="w-full border rounded px-2 py-1"
								value="<?= date('H:i') ?>">
						</td>

						<td class="px-3 py-1 font-medium bg-gray-50">Customer Contact No</td>
						<td class="px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->phone ?? '-' ?>" readonly>
						</td>
					</tr>

					<!-- ROW 3 -->
					<tr class="border-b">
						<td class="px-3 py-1  font-medium bg-gray-50">Vehicle Model</td>
						<td class="px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->model ?>" readonly>
						</td>

						<td class="px-3 py-1  font-medium bg-gray-50">Email</td>
						<td class="px-3 py-1 ">
							<input type="email"
								class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->email ?>" readonly>
						</td>

						<td class="px-3 py-1  font-medium bg-gray-50">Registration No</td>
						<td class="px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->registration_no ?>" readonly>
						</td>
					</tr>

					<!-- ROW 4 -->
					<tr class="border-b">
						<td class="px-3 py-1 font-medium bg-gray-50">Vehicle VIN No</td>
						<td class="px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->chassis_no ?>" readonly>
						</td>

						<td class="px-3 py-1  font-medium bg-gray-50">KM's In</td>
						<td class="px-3 py-1 ">
							<input type="number"
								class="w-full border rounded px-2 py-1">
						</td>

						<td class="px-3 py-1  font-medium bg-gray-50">Estimated Delivery Date</td>
						<td class="px-3 py-1 ">
							<input type="date"
								class="w-full border rounded px-2 py-1">
						</td>
					</tr>

					<!-- ROW 5 -->
					<tr>
						<td class="px-3 py-1  font-medium bg-gray-50">Completion Time</td>
						<td class="px-3 py-1 ">
							<input type="time"
								class="w-full border rounded px-2 py-1">
						</td>

						<td class="px-3 py-1  font-medium bg-gray-50">Check List Remark</td>
						<td class="px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1">
						</td>

						<td class="px-3 py-1  font-medium bg-gray-50">Remark</td>
						<td class="px-3 py-1 ">
							<textarea
								class="w-full border rounded px-2 py-1 h-16"></textarea>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		<!-- ============================================== -->

		<div class="bg-white rounded-2xl shadow-md mt-6 overflow-hidden">

			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Job Description
			</div>

			<div class="p-4">
				<table class="w-full text-sm border-collapse" id="jobDescTable">
					<thead>
						<tr class="bg-gray-50 border">
							<th class="border px-3 py-2 w-[60px] text-center">Sl. No</th>
							<th class="border px-3 py-2 text-left">Job Description</th>
							<th class="border px-3 py-2 text-left">Technician</th>
							<th class="border px-3 py-2 w-[80px] text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($job_descriptions)): ?>
							<?php foreach ($job_descriptions as $i => $j): ?>
								<tr class="border hover:bg-gray-50">
									<td class="border px-3 py-2 text-center font-medium">
										<?= $i + 1 ?>
									</td>
									<td class="border px-3 py-2">
										<input type="text" name="job_description[]"
											value="<?= $j->description ?>"
											class="w-full border rounded px-3 py-1.5 focus:ring-2 focus:ring-blue-500">
									</td>
									<td class="border px-3 py-2">
										<input type="text" name="technician[]"
											value=""
											class="w-full border rounded px-3 py-1.5 focus:ring-2 focus:ring-blue-500">
									</td>
									<td class="border px-3 py-2 text-center">
										<button type="button"
											class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
											✕
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>

				<button type="button"
					onclick="addJobRow()"
					class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm">
					+ Add Job Description
				</button>
			</div>
		</div>
		<!-- ============================================  -->
		<div class="bg-white rounded-2xl shadow-md mt-6 overflow-hidden">

			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Spare Parts Used
			</div>

			<div class="p-4">
				<table class="w-full text-sm border-collapse" id="partsTable">
					<thead>
						<tr class="bg-gray-50 border">
							<th class="border px-3 py-2 w-[50px] text-center">#</th>
							<th class="border px-3 py-2">Part</th>
							<th class="border px-3 py-2 w-[80px] text-center">Qty</th>
							<th class="border px-3 py-2 w-[110px] text-right">Unit Price</th>
							<th class="border px-3 py-2 w-[110px] text-right">Selling Price</th>
							<th class="border px-3 py-2 w-[120px] text-right">Total</th>
							<th class="border px-3 py-2 w-[70px] text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($parts_used as $i => $p): ?>
							<tr class="border hover:bg-gray-50">
								<td class="border px-3 py-2 text-center font-medium"><?= $i + 1 ?></td>

								<td class="border px-3 py-2">
									<select name="part_id[]"
										class="w-full border rounded px-2 py-1">
										<?php foreach ($parts as $part): ?>
											<option value="<?= $part->part_id ?>"
												<?= $part->part_id == $p->part_id ? 'selected' : '' ?>>
												<?= $part->part_name ?>
											</option>
										<?php endforeach; ?>
									</select>
								</td>

								<td class="border px-3 py-2">
									<input name="part_qty[]" value="<?= $p->qty ?>"
										class="w-full border rounded px-2 py-1 text-center partQty">
								</td>

								<td class="border px-3 py-2">
									<input name="part_price[]" value="<?= $p->unit_price ?>"
										class="w-full border rounded px-2 py-1 text-right unitPrice">
								</td>

								<td class="border px-3 py-2">
									<input name="sell_price[]" value="<?= $p->selling_price ?>"
										class="w-full border rounded px-2 py-1 text-right sellPrice">
								</td>

								<td class="border px-3 py-2">
									<input name="total_price[]" value="<?= $p->total_price ?>"
										class="w-full border rounded px-2 py-1 text-right bg-gray-100 rowTotal" readonly>
								</td>

								<td class="border px-3 py-2 text-center">
									<button type="button"
										class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
										✕
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<button type="button" id="addPart"
					class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm">
					+ Add Part
				</button>
			</div>
		</div>
		<!-- ========================================================================== -->
		<div class="bg-white rounded-2xl shadow-md mt-6 overflow-hidden">

			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Labour Charges
			</div>

			<div class="p-4">
				<table class="w-full text-sm border-collapse" id="serviceTable">
					<thead>
						<tr class="bg-gray-50 border">
							<th class="border px-3 py-2 w-[60px] text-center">Sl No</th>
							<th class="border px-3 py-2">Service</th>
							<th class="border px-3 py-2 w-[90px] text-center">Time (Hr)</th>
							<th class="border px-3 py-2 w-[120px] text-right">Est. Cost</th>
							<th class="border px-3 py-2 w-[120px] text-right">Total</th>
							<th class="border px-3 py-2 w-[70px] text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($services_used as $i => $s): ?>
							<tr class="border hover:bg-gray-50">
								<td class="border px-3 py-2 text-center font-medium"><?= $i + 1 ?></td>

								<td class="border px-3 py-2">
									<select name="service_name[]"
										class="w-full border rounded px-2 py-1 serviceSelect">
										<option value="">-- Select --</option>
										<?php foreach ($services_master as $sm): ?>
											<option value="<?= $sm->master_service_id ?>"
												<?= $sm->master_service_id == $s->service_id ? 'selected' : '' ?>>
												<?= $sm->service_name ?>
											</option>
										<?php endforeach; ?>
									</select>
								</td>

								<td class="border px-3 py-2">
									<input name="service_time[]" value="<?= $s->estimated_time ?>"
										class="w-full border rounded px-2 py-1 text-center serviceTime">
								</td>

								<td class="border px-3 py-2">
									<input name="service_cost[]" value="<?= $s->estimated_cost ?>"
										class="w-full border rounded px-2 py-1 text-right serviceCost">
								</td>

								<td class="border px-3 py-2">
									<input name="total_cost[]" value="<?= $s->total_cost ?>"
										class="w-full border rounded px-2 py-1 text-right bg-gray-100 totalCost" readonly>
								</td>

								<td class="border px-3 py-2 text-center">
									<button type="button"
										class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
										✕
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<button type="button" id="addService"
					class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm">
					+ Add Service
				</button>
			</div>
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
				Save Job Card
			</button>
			<?php if ($jobcardstatus == "In Progress") { ?>
				<a href="<?= base_url('index.php/materialissue/create/' . $jobcard_id) ?>"
					class="px-4 py-2 bg-indigo-600 text-white rounded">
					Material Issue
				</a>
			<?php } ?>
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

		const tbody = document.querySelector("#jobDescTable tbody");
		const slNo = tbody.querySelectorAll("tr").length + 1;

		const row = `
        <tr class="border hover:bg-gray-50">
            <td class="border px-3 py-2 text-center font-medium">
                ${slNo}
            </td>

            <td class="border px-3 py-2">
                <input type="text" name="job_description[]"
                    class="w-full border rounded px-3 py-1.5 focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter job description">
            </td>

            <td class="border px-3 py-2 text-center">
                <button type="button"
                    class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
                    ✕
                </button>
            </td>
        </tr>
    `;

		tbody.insertAdjacentHTML("beforeend", row);
	}


	function removeJobRow(id) {
		document.getElementById("job_" + id)?.remove();
		renumber("#jobDescTable");
	}

	/* ===============================
	   PARTS SECTION
	================================ */
	document.getElementById("addPart").addEventListener("click", function() {

		const tbody = document.querySelector("#partsTable tbody");
		const slNo = tbody.querySelectorAll("tr").length + 1;

		let options = `<option value="">-- Select Part --</option>`;
		partsList.forEach(p => {
			options += `<option value="${p.part_id}" data-price="${p.unit_price}">
                        ${p.part_name}
                    </option>`;
		});

		const row = `
        <tr class="border hover:bg-gray-50">
            <td class="border px-3 py-2 text-center font-medium">${slNo}</td>

            <td class="border px-3 py-2">
                <select name="part_id[]" class="partSelect w-full border rounded px-2 py-1">
                    ${options}
                </select>
            </td>

            <td class="border px-3 py-2">
                <input name="part_qty[]" value="1"
                    class="partQty w-full border rounded px-2 py-1 text-center">
            </td>

            <td class="border px-3 py-2">
                <input name="part_price[]"
                    class="unitPrice w-full border rounded px-2 py-1 text-right">
            </td>

            <td class="border px-3 py-2">
                <input name="sell_price[]"
                    class="sellPrice w-full border rounded px-2 py-1 text-right">
            </td>

            <td class="border px-3 py-2">
                <input name="total_price[]"
                    class="rowTotal w-full border rounded px-2 py-1 text-right bg-gray-100"
                    value="0.00" readonly>
            </td>

            <td class="border px-3 py-2 text-center">
                <button type="button"
                    class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
                    ✕
                </button>
            </td>
        </tr>
    `;

		tbody.insertAdjacentHTML("beforeend", row);
	});


	/* ===============================
	   SERVICE / LABOUR SECTION
	================================ */
	document.getElementById("addService").addEventListener("click", function() {

		const tbody = document.querySelector("#serviceTable tbody");
		const slNo = tbody.querySelectorAll("tr").length + 1;

		let options = `<option value="">-- Custom Service --</option>`;
		servicesMaster.forEach(s => {
			options += `<option value="${s.master_service_id}"
                    data-price="${s.estimated_cost}"
                    data-time="${s.estimated_time}">
                    ${s.service_name}
                </option>`;
		});

		const row = `
        <tr class="border hover:bg-gray-50">
            <td class="border px-3 py-2 text-center font-medium">${slNo}</td>

            <td class="border px-3 py-2">
                <select class="serviceSelect w-full border rounded px-2 py-1"
                    name="service_name[]">
                    ${options}
                </select>
            </td>

            <td class="border px-3 py-2">
                <input name="service_time[]" value="1"
                    class="serviceTime w-full border rounded px-2 py-1 text-center">
            </td>

            <td class="border px-3 py-2">
                <input name="service_cost[]"
                    class="serviceCost w-full border rounded px-2 py-1 text-right">
            </td>

            <td class="border px-3 py-2">
                <input name="total_cost[]"
                    class="totalCost w-full border rounded px-2 py-1 text-right bg-gray-100"
                    value="0.00" readonly>
            </td>

            <td class="border px-3 py-2 text-center">
                <button type="button"
                    class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
                    ✕
                </button>
            </td>
        </tr>
    `;

		tbody.insertAdjacentHTML("beforeend", row);
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
