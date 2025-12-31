<?php

?>

<div class="w-full bg-white rounded-2xl shadow-md p-6">


	<form method="post" action="<?= base_url('index.php/estimation/save'); ?>" class="p-6 bg-white">
		<input type="hidden" name="estimation_id" value="<?= $estimation_id ?>">

		<!-- ================================ -->


		<div class="page-header flex items-center justify-between mb-4">

			<h2 class="text-center text-xl font-bold mb-4">
				Estimation
			</h2>
			<div class="text-right mt-6">
				<!-- SAVE BUTTON -->
				<button type="submit"
					class="ml-3 px-6 py-2 bg-blue-600 text-white rounded">
					Save Estimation
				</button>
				<a href="<?= base_url('index.php/appointment'); ?>"
					class="ml-3 px-6 py-2 bg-gray-300 rounded">Cancel</a>
			</div>
		</div>
		<hr class="border-gray-300 mb-6">


		<!-- ============================================= -->





		<!-- CUSTOMER / VEHICLE INFO -->
		<!-- VEHICLE & CUSTOMER DETAILS -->
		<div class="bg-white rounded-2xl shadow-md mb-6 p-4">

			<h3 class="font-semibold mb-4">Vehicle & Customer Details</h3>

			<table class="w-full border-collapse text-sm">
				<tbody>

					<!-- ROW 1 -->
					<tr>
						<td class="border p-2 font-medium">Date</td>
						<td class="border p-2">
							<input type="date" class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= date('Y-m-d') ?>">
						</td>

						<td class="border p-2 font-medium">Time</td>
						<td class="border p-2">
							<input type="time" class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= date('H:i') ?>" readonly>
						</td>

						<td class="border p-2 font-medium">Estimation No</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $estimation_no ?>" readonly>
						</td>
					</tr>

					<!-- ROW 2 -->
					<tr>
						<td class="border p-2 font-medium">Customer Name</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1"
								value="<?= $appointment->name ?>">
						</td>

						<td class="border p-2 font-medium">Contact No</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1"
								value="<?= $appointment->phone ?? '-' ?>">
						</td>

						<td class="border p-2 font-medium">Email</td>
						<td class="border p-2">
							<input type="email" class="w-full border rounded px-2 py-1"
								value="<?= $appointment->email ?>">
						</td>
					</tr>

					<!-- ROW 3 -->
					<tr>
						<td class="border p-2 font-medium">Vehicle Model</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->model ?>" readonly>
						</td>

						<td class="border p-2 font-medium">Registration No</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->registration_no ?>" readonly>
						</td>

						<td class="border p-2 font-medium">VIN / Chassis No</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->chassis_no ?>" readonly>
						</td>
					</tr>

					<!-- ROW 4 -->
					<tr>
						<td class="border p-2 font-medium">Job Card No</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1">
						</td>

						<td class="border p-2 font-medium">KM In</td>
						<td class="border p-2">
							<input type="number" class="w-full border rounded px-2 py-1">
						</td>

						<td class="border p-2 font-medium">Customer Approval</td>
						<td class="border p-2">
							<select class="w-full border rounded px-2 py-1">
								<option value="">-- Select --</option>
								<option value="APPROVED">Approved</option>
								<option value="PENDING">Pending</option>
								<option value="REJECTED">Rejected</option>
							</select>
						</td>
					</tr>

					<!-- ROW 5 -->
					<tr>
						<td class="border p-2 font-medium">Estimated Price</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1">
						</td>

						<td class="border p-2 font-medium">Estimated Delivery Date</td>
						<td class="border p-2">
							<input type="date" class="w-full border rounded px-2 py-1">
						</td>

						<td class="border p-2 font-medium">Completion Time</td>
						<td class="border p-2">
							<input type="time" class="w-full border rounded px-2 py-1">
						</td>
					</tr>

					<!-- ROW 6 -->
					<tr>
						<td class="border p-2 font-medium">Remark</td>
						<td class="border p-2" colspan="5">
							<textarea class="w-full border rounded px-2 py-1 h-20"></textarea>
						</td>
					</tr>

				</tbody>
			</table>
		</div>

		<!-- ============================================================= -->


		<div class="bg-white rounded-2xl shadow-md p-6 mt-8">

			<!-- Header -->
			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-semibold text-gray-800">
					Job Description
				</h3>

				<button type="button"
					onclick="addJobRow()"
					class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
					<span class="text-lg">+</span> Add Job
				</button>
			</div>

			<!-- Table -->
			<div class="overflow-x-auto">
				<table class="w-full border-collapse text-sm" id="jobDescTable">

					<thead>
						<tr class="bg-gray-100 text-gray-700">
							<th class="border px-4 py-2 w-16 text-center">#</th>
							<th class="border px-4 py-2">Job Description</th>
							<th class="border px-4 py-2 w-48">Technician</th>
							<th class="border px-4 py-2 w-24 text-center">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!empty($job_descriptions)): ?>
							<?php foreach ($job_descriptions as $i => $j): ?>
								<tr class="hover:bg-gray-50 transition" id="job_1">
									<td class="border px-3 py-2 text-center font-medium">
										<?= $i + 1 ?>
									</td>

									<!-- Job Description -->
									<td class="border px-3 py-2">
										<input type="text"
											name="job_description[]"
											value="<?= $j->description ?>"
											placeholder="Enter job description..."
											class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
									</td>

									<!-- Technician Dropdown -->
									<td class="border px-3 py-2">
										<select name="technician_id[]"
											class="w-full border rounded-lg px-2 py-2 focus:ring-2 focus:ring-blue-300">
											<option value="">-- Select Technician --</option>
											<?php foreach ($technicians as $t): ?>
												<option value="<?= $t->employee_id ?>"
													<?= isset($j->employee_id) && $j->employee_id == $t->employee_id ? 'selected' : '' ?>>
													<?= $t->employee_name ?>
												</option>
											<?php endforeach; ?>

										</select>
									</td>

									<!-- Action -->
									<td class="border px-3 py-2 text-center">
										<button type="button"
											class="remove-row inline-flex items-center justify-center 
                                           bg-red-100 text-red-600 
                                           hover:bg-red-500 hover:text-white 
                                           px-3 py-1 rounded-lg transition">
											✕
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>

				</table>
			</div>

			<p class="text-xs text-gray-500 mt-3">
				Assign a technician for each job description for better tracking.
			</p>

		</div>
		<!-- ================================================================== -->

		<div class="bg-white rounded-2xl shadow-md p-6 mt-8">

			<!-- Header -->
			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-semibold text-gray-800">
					Spare Parts Used
				</h3>

				<button type="button" id="addPart"
					class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
					<span class="text-lg">+</span> Add Part
				</button>
			</div>

			<!-- Table -->
			<div class="overflow-x-auto">
				<table class="w-full border-collapse text-sm" id="partsTable">

					<thead>
						<tr class="bg-gray-100 text-gray-700">
							<th class="border px-3 py-2 w-14 text-center">#</th>
							<th class="border px-3 py-2 w-32">Brand</th>
							<th class="border px-3 py-2">Part</th>
							<th class="border px-3 py-2 w-20 text-center">Qty</th>
							<th class="border px-3 py-2 w-28 text-right">Unit Price</th>
							<th class="border px-3 py-2 w-24 text-center">Markup %</th>
							<th class="border px-3 py-2 w-28 text-right">Selling Price</th>
							<th class="border px-3 py-2 w-24 text-center">Discount</th>
							<th class="border px-3 py-2 w-24 text-center">Dis-Amount</th>
							<th class="border px-3 py-2 w-32 text-right">Total Price</th>
							<th class="border px-3 py-2 w-20 text-center">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!empty($parts_used)): ?>
							<?php foreach ($parts_used as $i => $p): ?>
								<tr class="hover:bg-gray-50 transition">
									<!-- SL -->
									<td class="border px-2 py-2 text-center font-medium">
										<?= $i + 1 ?>
									</td>

									<!-- Brand -->
									<td class="border px-2 py-2">
										<select name="brand_id[]"
											class="brandSelect w-full border rounded-lg px-2 py-1">
											<option value="">-- Select Brand --</option>
											<?php foreach ($brands as $b): ?>
												<option value="<?= $b->brand_id ?>"
													<?= isset($p->brand_id) && $p->brand_id == $b->brand_id ? 'selected' : '' ?>>
													<?= $b->brand_name ?>
												</option>
											<?php endforeach; ?>
										</select>
									</td>


									<!-- Part -->
									<td class="border px-2 py-2">
										<select name="part_id[]"
											class="partSelect w-full border rounded-lg px-2 py-1">
											<option value="">-- Select Brand First --</option>
										</select>
									</td>

									<!-- Qty -->
									<td class="border px-2 py-2 text-center">
										<input type="number" name="part_qty[]"
											class="partQty w-20 border rounded-lg px-2 py-1 text-center"
											value="<?= $p->qty ?>">
									</td>

									<!-- Unit Price -->
									<td class="border px-2 py-2 text-right">
										<input type="number" step="0.01" name="unit_price[]"
											class="unitPrice w-full border rounded-lg px-2 py-1 text-right"
											value="<?= $p->unit_price ?>">
									</td>

									<!-- Markup % -->
									<td class="border px-2 py-2 text-center">
										<input type="number" step="0.01" name="markup[]"
											class="markup w-20 border rounded-lg px-2 py-1 text-center"
											value="<?= $p->markup ?? 0 ?>" oninput="calculateSellingPrice(this)">
									</td>

									<!-- Selling Price -->
									<td class="border px-2 py-2 text-right">
										<input type="number" step="0.01" name="selling_price[]"
											class="sellPrice w-full border rounded-lg px-2 py-1 text-right"
											value="<?= $p->selling_price ?>">
									</td>

									<!-- Discount -->
									<td class="border px-2 py-2 text-center">
										<input type="text" name="discount[]"
											onkeydown="allowNumberAndPercent(event)"
											oninput="this.value = this.value.replace(/[^0-9%]/g, ''); calculateDiscount(this);"
											class="discount w-20 border rounded-lg px-2 py-1 text-right"
											value="<?= $p->discount ?? 0 ?>">
									</td>
									<!-- Discount amt-->
									<td class="border px-2 py-2 text-center">
										<input type="number" step="0.01" name="discountamt[]"
											class="discountamt w-20 border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->discount ?? 0 ?>" readonly>
									</td>

									<!-- Total -->
									<td class="border px-2 py-2 text-right">
										<input type="number" step="0.01" name="total_price[]"
											class="rowTotal w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->total_price ?>" readonly>
									</td>

									<!-- Action -->
									<td class="border px-2 py-2 text-center">
										<button type="button"
											class="remove-row inline-flex items-center justify-center
                                       bg-red-100 text-red-600
                                       hover:bg-red-500 hover:text-white
                                       px-3 py-1 rounded-lg transition">
											✕
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>

				</table>
			</div>

			<p class="text-xs text-gray-500 mt-3">
				Markup and discounts are applied per item. Total updates automatically.
			</p>

		</div>


		<!-- ============================================= -->
		<div class="bg-white rounded-2xl shadow-md p-6 mt-8">

			<!-- Header -->
			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-semibold text-gray-800">
					Labour Charges
				</h3>

				<button type="button" id="addService"
					class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
					<span class="text-lg">+</span> Add Service
				</button>
			</div>

			<!-- Table -->
			<div class="overflow-x-auto">
				<table class="w-full border-collapse text-sm" id="serviceTable">

					<thead>
						<tr class="bg-gray-100 text-gray-700">
							<th class="border px-3 py-2 w-16 text-center">#</th>
							<th class="border px-3 py-2">Service</th>
							<th class="border px-3 py-2 w-24 text-center">Time (Hr)</th>
							<th class="border px-3 py-2 w-32 text-right">Estimated Cost</th>
							<th class="border px-3 py-2 w-32 text-right">Total Cost</th>
							<th class="border px-3 py-2 w-20 text-center">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!empty($parts_used)): ?>
							<?php foreach ($services_used as $i => $s): ?>
								<tr class="hover:bg-gray-50 transition">
									<!-- SL -->
									<td class="border px-2 py-2 text-center font-medium">
										<?= $i + 1 ?>
									</td>

									<!-- Service -->
									<td class="border px-2 py-2">
										<select name="service_id[]"
											class="serviceSelect w-full border rounded-lg px-2 py-1 focus:ring-2 focus:ring-blue-300">
											<option value="">-- Select Service --</option>
											<?php foreach ($services_master as $sm): ?>
												<option value="<?= $sm->master_service_id ?>"
													<?= $sm->master_service_id == $s->service_id ? 'selected' : '' ?>>
													<?= $sm->service_name ?>
												</option>
											<?php endforeach; ?>
										</select>
									</td>

									<!-- Time -->
									<td class="border px-2 py-2 text-center">
										<input type="number" step="0.1"
											name="service_time[]"
											class="serviceTime w-20 border rounded-lg px-2 py-1 text-center"
											value="<?= $s->estimated_time ?>">
									</td>

									<!-- Estimated Cost -->
									<td class="border px-2 py-2 text-right">
										<input type="number" step="0.01"
											name="service_cost[]"
											class="serviceCost w-full border rounded-lg px-2 py-1 text-right"
											value="<?= $s->estimated_cost ?>">
									</td>

									<!-- Total -->
									<td class="border px-2 py-2 text-right">
										<input type="number" step="0.01"
											name="total_cost[]"
											class="totalCost w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $s->total_cost ?>" readonly>
									</td>

									<!-- Action -->
									<td class="border px-2 py-2 text-center">
										<button type="button"
											class="remove-row inline-flex items-center justify-center
                                       bg-red-100 text-red-600
                                       hover:bg-red-500 hover:text-white
                                       px-3 py-1 rounded-lg transition">
											✕
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>

				</table>
			</div>

			<p class="text-xs text-gray-500 mt-3">
				Labour cost is calculated automatically based on time and rate.
			</p>

		</div>

		<!-- FOOTER DETAILS -->

		<div class="bg-white rounded-2xl shadow-md p-6 mt-8 text-sm">

			<h3 class="text-lg font-semibold text-gray-800 mb-4">
				Cost Summary
			</h3>

			<div class="grid grid-cols-5 gap-4 items-end">

				<!-- Subtotal -->
				<div>
					<label class="block text-gray-600 font-medium mb-1">Subtotal</label>
					<input id="subtotal" name="subtotal"
						value="<?= isset($estimation) && $estimation ? $estimation->subtotal : '0.00' ?>"

						readonly
						class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-right font-medium">
				</div>

				<!-- Tax % -->
				<div>
					<label class="block text-gray-600 font-medium mb-1">Tax (%)</label>
					<input id="tax_percent" name="tax_percent"
						value="5"
						class="w-full border rounded-lg px-3 py-2 text-right">
				</div>

				<!-- Tax Amount -->
				<div>
					<label class="block text-gray-600 font-medium mb-1">Tax Amount</label>
					<input id="tax_amount" name="tax_amount"

						value="<?= isset($estimation) && $estimation ? $estimation->tax_amount : '0.00' ?>"
						readonly
						class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-right">
				</div>

				<!-- Discount -->
				<div>
					<label class="block text-gray-600 font-medium mb-1">Discount</label>
					<input id="discount" name="discount"

						value="<?= isset($estimation) && $estimation ? $estimation->discount : '0.00' ?>"
						class="w-full border rounded-lg px-3 py-2 text-right">
				</div>

				<!-- Grand Total -->
				<div>
					<label class="block text-gray-600 font-semibold mb-1 text-green-700">
						Grand Total
					</label>
					<input id="grand_total" name="grand_total"

						value="<?= isset($estimation) && $estimation ? $estimation->grand_total : '0.00' ?>"
						readonly
						class="w-full border-2 border-green-600 rounded-lg px-3 py-2 
                       bg-green-50 text-right text-lg font-bold text-green-800">
				</div>

			</div>

		</div>


		<!-- SAVE BUTTON -->
		<!-- SAVE BUTTON -->




	</form>

</div>
<!-- ========================================= script fncs======================== -->
<script>
	/* ===============================
  	 GLOBAL COUNTERS
		================================ */
	let jobRowCount =
		document.querySelectorAll("#jobDescTable tbody tr").length;
	let partCount =
		document.querySelectorAll("#partsTable tbody tr").length;
	let serviceCount =
		document.querySelectorAll("#serviceTable tbody tr").length;

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

		const techOptions = `
            <option value="">-- Select Technician --</option>
            <?php foreach ($technicians as $t): ?>
                <option value="<?= $t->employee_id ?>">
                    <?= $t->employee_name ?>
                </option>
            <?php endforeach; ?>
        `;

		const row = `
            <tr class="hover:bg-gray-50 transition" id="job_${jobRowCount}">
                <td class="border px-3 py-2 text-center font-medium">
                    ${jobRowCount}
                </td>

                <!-- Job Description -->
                <td class="border px-3 py-2">
                    <input type="text"
                        name="job_description[]"
                        placeholder="Enter job description..."
                        class="w-full border rounded-lg px-3 py-2 
                               focus:ring-2 focus:ring-blue-300 focus:outline-none">
                </td>

                <!-- Technician -->
                <td class="border px-3 py-2">
                    <select name="technician_id[]"
                        class="w-full border rounded-lg px-2 py-2 
                               focus:ring-2 focus:ring-blue-300">
                        ${techOptions}
                    </select>
                </td>

                <!-- Action -->
                <td class="border px-3 py-2 text-center">
                    <button type="button"
                       
                        class="remove-row inline-flex items-center justify-center
                               bg-red-100 text-red-600
                               hover:bg-red-500 hover:text-white
                               px-3 py-1 rounded-lg transition">
                        ✕
                    </button>
                </td>
            </tr>
        `;

		document
			.querySelector("#jobDescTable tbody")
			.insertAdjacentHTML("beforeend", row);
	}

	function removeJobRow(btn) {
		btn.closest("tr").remove();
		updateJobSlNo();
	}

	function updateJobSlNo() {
		document
			.querySelectorAll("#jobDescTable tbody tr")
			.forEach((row, index) => {
				row.querySelector("td").innerText = index + 1;
			});

		jobRowCount =
			document.querySelectorAll("#jobDescTable tbody tr").length;
	}


	/* ===============================
	   PARTS SECTION
	================================ */
	document.getElementById("addPart").addEventListener("click", function() {

		partCount++;

		// Brand options (from PHP)
		const brandOptions = `
        <option value="">-- Select Brand --</option>
        <?php foreach ($brands as $brand): ?>
            <option value="<?= $brand->brand_id ?>">
                <?= $brand->brand_name ?>
            </option>
        <?php endforeach; ?>
    `;

		const row = `
        <tr class="hover:bg-gray-50 transition">

            <td class="border px-2 py-2 text-center font-medium">${partCount}</td>

            <!-- Brand -->
            <td class="border px-2 py-2">
                <select name="brand_id[]"
                        class="brandSelect w-full border rounded-lg px-2 py-1">
                    ${brandOptions}
                </select>
            </td>

            <!-- Part (EMPTY INITIALLY) -->
            <td class="border px-2 py-2">
                <select name="part_id[]"
                        class="partSelect w-full border rounded-lg px-2 py-1">
                    <option value="">-- Select Brand First --</option>
                </select>
            </td>

            <!-- Qty -->
            <td class="border px-2 py-2 text-center">
                <input type="number" name="part_qty[]"
                       class="partQty w-20 border rounded-lg px-2 py-1 text-center"
                       value="1" min="1">
            </td>

            <!-- Unit Price -->
            <td class="border px-2 py-2 text-right">
                <input type="number" step="0.01" name="unit_price[]"
                       class="unitPrice w-full border rounded-lg px-2 py-1 text-right"
                       value="0.00">
            </td>

            <!-- Markup % -->
            <td class="border px-2 py-2 text-center">
                <input type="number" step="0.01" name="markup[]"
                       oninput="calculateSellingPrice(this)"
                       class="markup w-20 border rounded-lg px-2 py-1 text-center"
                       value="0">
            </td>

            <!-- Selling Price -->
            <td class="border px-2 py-2 text-right">
                <input type="number" step="0.01" name="selling_price[]"
                       class="sellPrice w-full border rounded-lg px-2 py-1 text-right"
                       value="0.00">
            </td>

            <!-- Discount -->
            <td class="border px-2 py-2 text-center">
                <input type="text" name="discount[]"
                       onkeydown="allowNumberAndPercent(event)"
                       oninput="this.value=this.value.replace(/[^0-9%]/g,'');calculateDiscount(this);"
                       class="discount w-20 border rounded-lg px-2 py-1 text-center"
                       value="0">
            </td>

            <!-- Discount Amount -->
            <td class="border px-2 py-2 text-center">
                <input type="number" step="0.01" name="discountamt[]"
                       class="discountamt w-20 border rounded-lg px-2 py-1 text-right bg-gray-100"
                       value="0.00" readonly>
            </td>

            <!-- Total -->
            <td class="border px-2 py-2 text-right">
                <input type="number" step="0.01" name="total_price[]"
                       class="rowTotal w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
                       value="0.00" readonly>
            </td>

            <!-- Action -->
            <td class="border px-2 py-2 text-center">
                <button type="button"
                        class="remove-row bg-red-100 text-red-600
                               hover:bg-red-500 hover:text-white
                               px-3 py-1 rounded-lg transition">
                    ✕
                </button>
            </td>

        </tr>
    `;

		document.querySelector("#partsTable tbody")
			.insertAdjacentHTML("beforeend", row);
	});


	document.addEventListener('change', function(e) {

		if (!e.target.classList.contains('brandSelect')) return;

		const brandId = e.target.value;
		const row = e.target.closest('tr');
		const partSelect = row.querySelector('.partSelect');

		if (!brandId) {
			partSelect.innerHTML = '<option value="">-- Select Brand First --</option>';
			return;
		}

		partSelect.innerHTML = '<option value="">Loading...</option>';

		fetch('<?= base_url("index.php/estimation/get_parts_by_brand") ?>', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: 'brand_id=' + brandId
			})
			.then(res => res.json())
			.then(parts => {

				let options = '<option value="">-- Select Part --</option>';

				parts.forEach(p => {
					options += `
                <option value="${p.part_id}"
                        data-price="${p.unit_price}">
                    ${p.part_name}
                </option>
            `;
				});

				partSelect.innerHTML = options;
			});
	});


	// Remove row + reindex
	document.addEventListener("click", function(e) {
		if (e.target.closest(".remove-row")) {
			e.target.closest("tr").remove();
			updatePartSlNo();
		}
	});

	function updatePartSlNo() {
		document
			.querySelectorAll("#partsTable tbody tr")
			.forEach((row, index) => {
				row.querySelector("td").innerText = index + 1;
			});

		partCount =
			document.querySelectorAll("#partsTable tbody tr").length;
	}
	/* ===============================
	   SERVICE / LABOUR SECTION
	================================ */
	document.getElementById("addService").addEventListener("click", function() {
		serviceCount++;

		// Service options from PHP
		const serviceOptions = `
            <option value="">-- Select Service --</option>
            <?php foreach ($services_master as $sm): ?>
                <option value="<?= $sm->master_service_id ?>"
                    data-price="<?= $sm->estimated_cost ?>"
                    data-time="<?= $sm->estimated_time ?>">
                    <?= $sm->service_name ?>
                </option>
            <?php endforeach; ?>
        `;

		const row = `
            <tr class="hover:bg-gray-50 transition">
                <!-- SL -->
                <td class="border px-2 py-2 text-center font-medium">
                    ${serviceCount}
                </td>

                <!-- Service -->
                <td class="border px-2 py-2">
                    <select name="service_id[]"
                        class="serviceSelect w-full border rounded-lg px-2 py-1 
                               focus:ring-2 focus:ring-blue-300">
                        ${serviceOptions}
                    </select>
                </td>

                <!-- Time -->
                <td class="border px-2 py-2 text-center">
                    <input type="number" step="0.1"
                        name="service_time[]"
                        class="serviceTime w-20 border rounded-lg px-2 py-1 text-center"
                        value="1">
                </td>

                <!-- Estimated Cost -->
                <td class="border px-2 py-2 text-right">
                    <input type="number" step="0.01"
                        name="service_cost[]"
                        class="serviceCost w-full border rounded-lg px-2 py-1 text-right"
                        value="0.00">
                </td>

                <!-- Total -->
                <td class="border px-2 py-2 text-right">
                    <input type="number" step="0.01"
                        name="total_cost[]"
                        class="totalCost w-full border rounded-lg px-2 py-1 
                               text-right bg-gray-100"
                        value="0.00" readonly>
                </td>

                <!-- Action -->
                <td class="border px-2 py-2 text-center">
                    <button type="button"
                        class="remove-row inline-flex items-center justify-center
                               bg-red-100 text-red-600
                               hover:bg-red-500 hover:text-white
                               px-3 py-1 rounded-lg transition">
                        ✕
                    </button>
                </td>
            </tr>
        `;

		document
			.querySelector("#serviceTable tbody")
			.insertAdjacentHTML("beforeend", row);
	});

	// Remove row + reindex
	document.addEventListener("click", function(e) {
		if (e.target.closest(".remove-row")) {
			e.target.closest("tr").remove();
			updateServiceSlNo();
		}
	});

	function updateServiceSlNo() {
		document
			.querySelectorAll("#serviceTable tbody tr")
			.forEach((row, index) => {
				row.querySelector("td").innerText = index + 1;
			});

		serviceCount =
			document.querySelectorAll("#serviceTable tbody tr").length;
	}

	/* ===============================
	   CHANGE HANDLERS
	================================ */
	document.addEventListener("change", function(e) {

		// Auto-fill part unit price
		if (e.target.classList.contains("partSelect")) {
			let row = e.target.closest("tr");
			let price = e.target.selectedOptions[0]?.dataset.price || 0;
			row.querySelector(".unitPrice").value = price;
			row.querySelector(".sellPrice").value = price;
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
		let disc = parseFloat(row.querySelector(".discountamt")?.value || 0);

		let price = sell > 0 ? sell : unit;

		// Total = (Qty × Price) − Discount Amount
		let total = (qty * price) - disc;

		// Prevent negative total
		if (total < 0) total = 0;
		row.querySelector(".rowTotal").value = total.toFixed(2);
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
			renumber("#jobDescTable");
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
		document.getElementById("tax_amount").value = taxAmount.toFixed(2);
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

<script>
	function allowNumberAndPercent(e) {
		const key = e.key;

		// Allow numbers
		if (key >= '0' && key <= '9') return true;

		// Allow %
		if (key === '%') return true;

		// Allow control keys
		if (
			key === 'Backspace' ||
			key === 'Delete' ||
			key === 'ArrowLeft' ||
			key === 'ArrowRight' ||
			key === 'Tab'
		) {
			return true;
		}

		// Block everything else
		e.preventDefault();
		return false;
	}


	function calculateDiscount(input) {

		const row = input.closest("tr");

		const qty = parseFloat(row.querySelector(".partQty")?.value || 1);
		const sellPrice = parseFloat(row.querySelector(".sellPrice")?.value || 0);
		const discountAmtInput = row.querySelector(".discountamt");

		let discountValue = input.value.trim();
		let discountAmount = 0;

		// If percentage
		if (discountValue.endsWith("%")) {
			let percent = parseFloat(discountValue.replace("%", ""));
			if (!isNaN(percent)) {
				discountAmount = (qty * sellPrice) * (percent / 100);
			}
		}
		// Flat discount
		else {
			let flat = parseFloat(discountValue);
			if (!isNaN(flat)) {
				discountAmount = flat;
			}
		}

		discountAmtInput.value = discountAmount.toFixed(2);
	}


	function calculateSellingPrice(input) {

		const row = input.closest("tr");

		const unitPriceInput = row.querySelector(".unitPrice");
		const markupInput = row.querySelector(".markup");
		const sellPriceInput = row.querySelector(".sellPrice");

		const unitPrice = parseFloat(unitPriceInput.value) || 0;
		const markup = parseFloat(markupInput.value) || 0;

		// Selling Price = Unit Price + (Unit Price × Markup %)
		const sellingPrice = unitPrice + (unitPrice * markup / 100);

		sellPriceInput.value = sellingPrice.toFixed(2);
	}
</script>
