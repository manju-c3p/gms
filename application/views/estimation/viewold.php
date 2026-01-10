<?php

?>

<div class="w-full bg-white rounded-2xl shadow-md p-6">



	<input type="hidden" name="estimation_id" value="<?= $estimation_id ?>">

	<!-- ================================ -->


	<div class="page-header flex items-center justify-between mb-4">

		<h2 class="text-center text-xl font-bold mb-4">
			Estimation
		</h2>
		<div class="text-right mt-6">
			<!-- SAVE BUTTON -->
			<button onclick="window.print()"
				class="px-4 py-2 bg-blue-600 text-white rounded">
				🖨 Print
			</button>
			<button >
				<a href="<?= base_url('index.php/appointment'); ?>"
					class="ml-3 px-6 py-2 bg-gray-300 rounded">Cancel</a></button>
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
						<input type="number" class="w-full border rounded px-2 py-1"  value="<?= $kms ?>">
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


		</div>

		<!-- Table -->
		<div class="overflow-x-auto">
			<table class="w-full border-collapse text-sm" id="jobDescTable">

				<thead>
					<tr class="bg-gray-100 text-gray-700">
						<th class="border px-4 py-2 w-16 text-center">#</th>
						<th class="border px-4 py-2">Job Description</th>
						<th class="border px-4 py-2 w-48">Technician</th>
						<!-- <th class="border px-4 py-2 w-24 text-center">Action</th> -->
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
								<!-- <td class="border px-3 py-2 text-center">
										<button type="button"
											class="remove-row inline-flex items-center justify-center 
                                           bg-red-100 text-red-600 
                                           hover:bg-red-500 hover:text-white 
                                           px-3 py-1 rounded-lg transition">
											✕
										</button>
									</td> -->
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>

			</table>
		</div>

		<!-- <p class="text-xs text-gray-500 mt-3">
				Assign a technician for each job description for better tracking.
			</p> -->

	</div>
	<!-- ================================================================== -->

	<div class="bg-white rounded-2xl shadow-md p-6 mt-8">

		<!-- Header -->
		<div class="flex items-center justify-between mb-4">
			<h3 class="text-lg font-semibold text-gray-800">
				Spare Parts Used
			</h3>


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
						<!-- <th class="border px-3 py-2 w-20 text-center">Action</th> -->
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
								<!-- <td class="border px-2 py-2 text-center">
										<button type="button"
											class="remove-row inline-flex items-center justify-center
                                       bg-red-100 text-red-600
                                       hover:bg-red-500 hover:text-white
                                       px-3 py-1 rounded-lg transition">
											✕
										</button>
									</td> -->
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>

			</table>
		</div>

		<!-- <p class="text-xs text-gray-500 mt-3">
				Markup and discounts are applied per item. Total updates automatically.
			</p> -->

	</div>


	<!-- ============================================= -->
	<div class="bg-white rounded-2xl shadow-md p-6 mt-8">

		<!-- Header -->
		<div class="flex items-center justify-between mb-4">
			<h3 class="text-lg font-semibold text-gray-800">
				Labour Charges
			</h3>


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
						<!-- <th class="border px-3 py-2 w-20 text-center">Action</th> -->
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
								<!-- <td class="border px-2 py-2 text-center">
										<button type="button"
											class="remove-row inline-flex items-center justify-center
                                       bg-red-100 text-red-600
                                       hover:bg-red-500 hover:text-white
                                       px-3 py-1 rounded-lg transition">
											✕
										</button>
									</td> -->
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>

			</table>
		</div>

		<!-- <p class="text-xs text-gray-500 mt-3">
				Labour cost is calculated automatically based on time and rate.
			</p> -->

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






</div>
<!-- ========================================= script fncs======================== -->
<style>
	@media print {
		.print\:hidden {
			display: none !important;
		}

		button,
		.print\:hidden {
			display: none !important;
		}

		.topbar {
			display: none;
		}

		html,
		body {
			height: auto !important;
			overflow: visible !important;
		}

		* {
			overflow: visible !important;
		}

		body {
			background: white;
		}

		div {
			box-shadow: none !important;
		}
	}
</style>
