<?php

?>

<!-- <div class="w-full bg-white rounded-2xl shadow-md p-6"> -->
<div class="w-full mx-0">

	<form method="post" action="<?= base_url('index.php/estimation/save'); ?>" class="p-6 bg-white">
		<input type="hidden" name="estimation_id" value="<?= $estimation_id ?>">

		<!-- ================================ -->



		<div class="page-header flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">

			<!-- Title -->
			<h2 class="text-xl font-bold text-center lg:text-left">
				Estimation
			</h2>

			<!-- Actions -->
			<div class="flex flex-col sm:flex-row sm:flex-wrap gap-2 justify-center lg:justify-end">

				<button type="submit"
					class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded">
					Save Estimation
				</button>

				<a href="<?= base_url('index.php/Estimation/view/' . $estimation_id) ?>"
					class="w-full sm:w-auto text-center px-6 py-2 bg-gray-400 text-white rounded">
					View Estimation
				</a>

				<a href="<?= base_url('index.php/appointment'); ?>"
					class="w-full sm:w-auto text-center px-6 py-2 bg-gray-300 rounded">
					Cancel
				</a>

			</div>
		</div>

		<hr class="border-gray-300 mb-6">


		<!-- ============================================= -->





		<!-- CUSTOMER / VEHICLE INFO -->
		<!-- VEHICLE & CUSTOMER DETAILS -->

		<div class="w-full mx-0">
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

						<td class="border p-2 font-medium">VIN No</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $appointment->chassis_no ?>" readonly>
						</td>
					</tr>

					<!-- ROW 4 -->
					<tr>
						<!-- <td class="border p-2 font-medium">Job Card No</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1">
						</td> -->

						<td class="border p-2 font-medium">KM In</td>
						<td class="border p-2">
							<input type="number" class="w-full border rounded px-2 py-1" value="<?= $kms ?>">
						</td>

						<td class="border p-2 font-medium">Customer Approval</td>
						<td class="border p-2">
							<select class="w-full border rounded px-2 py-1" name="custapproval">
								<option value="">-- Select --</option>
								<option value="APPROVED" <?= (isset($estimation) && $estimation->customer_approval === 'APPROVED') ? 'selected' : '' ?>>Approved</option>
								<option value="PENDING" <?= (isset($estimation) && $estimation->customer_approval === 'PENDING') ? 'selected' : '' ?>>Pending</option>
								<option value="REJECTED" <?= (isset($estimation) && $estimation->customer_approval === 'REJECTED') ? 'selected' : '' ?>>Rejected</option>
							</select>
						</td>

						<td class="border p-2 font-medium">Estimated Price</td>
						<td class="border p-2">
							<input type="text" class="w-full border rounded px-2 py-1" name="estimatedprice" value="<?= $estimation->customer_estimated_price ?? '' ?>">
						</td>
					</tr>

					<!-- ROW 5 -->
					<tr>


						<td class="border p-2 font-medium">Estimated Delivery Date</td>
						<td class="border p-2">
							<input type="date" class="w-full border rounded px-2 py-1" name="estdeldate" value="<?= $inspection->deliverydate ?? '' ?>">
						</td>

						<td class="border p-2 font-medium">Completion Time</td>
						<td class="border p-2">
							<input type="time" class="w-full border rounded px-2 py-1" name="completiontime" value="<?= $inspection->deliverytime ?? '' ?>">
						</td>

						<td class="border p-2 font-medium">Remark</td>
						<td class="border p-2" colspan="5">
							<textarea class="w-full border rounded px-2 py-1 h-20" name="remarks"><?= $estimation->remarks ?? '' ?></textarea>
						</td>
					</tr>



				</tbody>
			</table>
		</div>
		<hr class="border-gray-300 mb-6">
		<!-- ============================================================= -->
		<!-- Header -->
		<div class="flex items-center justify-between mb-4">
			<h3 class="text-lg font-semibold text-gray-800">
				Services
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
					<?php if (!empty($services_used)): ?>
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

				<tfoot>
					<!-- Service Total -->
					<tr class="bg-gray-100 font-semibold">
						<td colspan="4" class="text-right px-3 py-2">Service Total</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_total"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>

					<!-- VAT Amount (5%) -->
					<tr class="bg-gray-50">
						<td colspan="4" class="text-right px-3 py-2">Service VAT (5%)</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_vat"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>

					<!-- Total Including VAT -->
					<tr class="bg-gray-200 font-semibold">
						<td colspan="4" class="text-right px-3 py-2">Service Total (Including VAT)</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_total_with_vat"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>
				</tfoot>


			</table>
		</div>

		<p class="text-xs text-gray-500 mt-3">
			Service cost is calculated automatically based on time and rate.
		</p>
		<hr class="border-gray-300 mb-6">
		<!-- ============================================================== -->






		<h3 class="text-xl font-semibold text-gray-800 mb-6">
			Spare Parts Used
		</h3>

		<!-- New Parts -->
		<div class="mb-10">
			<h4 class="text-lg font-semibold text-blue-700 mb-3">
				New Parts
			</h4>
			<button type="button" id="addNewPart"
				class="mb-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
				+ Add New Part
			</button>

			<div class="overflow-x-auto">
				<table class="w-full border-collapse text-sm" id="newPartsTable">
					<thead class="bg-blue-50">
						<tr>
							<th class="border px-3 py-2 w-12 text-center">✓</th>

							<th class="border px-3 py-2 text-center w-12">SL</th>
							<th class="border px-3 py-2 w-32">Brand</th>
							<th class="border px-3 py-2">Part</th>
							<th class="border px-3 py-2 text-center w-20">Qty</th>
							<th class="border px-3 py-2 text-right w-28">Unit Price</th>
							<th class="border px-3 py-2 text-center w-24">Markup %</th>
							<th class="border px-3 py-2 text-right w-28">Selling Price</th>
							<th class="border px-3 py-2 text-center w-24">Discount</th>
							<th class="border px-3 py-2 text-center w-24">Dis-Amount</th>
							<th class="border px-3 py-2 text-right w-32">Total Price</th>
							<th class="border px-3 py-2 text-center w-20">Action</th>
							<!-- <th></th> -->
						</tr>
					</thead>
					<tbody>
						<!-- Rows will come here -->
						<?php if (!empty($parts_used_new)): ?>
							<?php foreach ($parts_used_new as $i => $p): ?>
								<tr class="hover:bg-gray-50 transition">
									<td class="border px-2 py-2 text-center">
										<input type="checkbox"
											name="customer_selected[]"
											value="<?= $p->part_id ?>"
											class="w-4 h-4 accent-green-600">
									</td>

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
											oninput="this.value = this.value.replace(/[^0-9.%]/g,''); calculateDiscount(this);"
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

									<td class="hidden border px-2 py-2 text-right">
										<input type="hidden" name="part_type[]"
											class="parttype w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->part_type ?>" readonly>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>

					<!-- <tfoot>
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Total</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									class="tablePartTotal w-full text-right bg-gray-100"
									data-table="newPartsTable"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>
					</tfoot> -->
					<tfoot>
						<!-- Parts Sub Total -->
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Sub Total</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="parts_subtotal"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Total Discount -->
						<tr class="bg-gray-50">
							<td colspan="10" class="text-right px-3 py-2">Total Discount</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="parts_discount_total"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Taxable Amount -->
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Taxable Amount</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="parts_taxable"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- VAT 5% -->
						<tr class="bg-gray-50">
							<td colspan="10" class="text-right px-3 py-2">VAT (5%)</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="parts_vat"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Total Including VAT -->
						<tr class="bg-gray-200 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Total (Including VAT)</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="parts_total_with_vat"
									class="tablePartTotal w-full text-right bg-gray-100"
									data-table="newPartsTable"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>
					</tfoot>



				</table>
			</div>
		</div>
		<hr class="border-gray-300 mb-6">
		<!-- Aftermarket Parts -->
		<div class="mb-10">
			<h4 class="text-lg font-semibold text-green-700 mb-3">
				Aftermarket Parts
			</h4>
			<button type="button" id="addAftermarketPart"
				class="mb-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
				+ Add Aftermarket Part
			</button>

			<div class="overflow-x-auto">
				<table class="w-full border-collapse text-sm" id="aftermarketPartsTable">
					<thead class="bg-green-50">
						<tr>
							<th class="border px-3 py-2 w-12 text-center">✓</th>

							<th class="border px-3 py-2 text-center w-12">SL</th>
							<th class="border px-3 py-2 w-32">Brand</th>
							<th class="border px-3 py-2">Part</th>
							<th class="border px-3 py-2 text-center w-20">Qty</th>
							<th class="border px-3 py-2 text-right w-28">Unit Price</th>
							<th class="border px-3 py-2 text-center w-24">Markup %</th>
							<th class="border px-3 py-2 text-right w-28">Selling Price</th>
							<th class="border px-3 py-2 text-center w-24">Discount</th>
							<th class="border px-3 py-2 text-center w-24">Dis-Amount</th>
							<th class="border px-3 py-2 text-right w-32">Total Price</th>
							<th class="border px-3 py-2 text-center w-20">Action</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<!-- Rows will come here -->
						<?php if (!empty($parts_used_after)): ?>
							<?php foreach ($parts_used_after as $i => $p): ?>
								<tr class="hover:bg-gray-50 transition">
									<td class="border px-2 py-2 text-center">
										<input type="checkbox"
											name="customer_selected[]"
											value="<?= $p->part_id ?>"
											class="w-4 h-4 accent-green-600">
									</td>
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
											oninput="this.value = this.value.replace(/[^0-9.%]/g,''); calculateDiscount(this);"
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
									<td class="hidden border px-2 py-2 text-right">
										<input type="hidden" name="part_type[]"
											class="parttype w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->part_type ?>" readonly>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
					<!-- <tfoot>
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Total</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									class="tablePartTotal w-full text-right bg-gray-100"
									data-table="aftermarketPartsTable"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>
					</tfoot> -->

					<tfoot>
						<!-- Parts Sub Total -->
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Sub Total</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="afterparts_subtotal"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Total Discount -->
						<tr class="bg-gray-50">
							<td colspan="10" class="text-right px-3 py-2">Total Discount</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="afterparts_discount_total"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Taxable Amount -->
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Taxable Amount</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="afterparts_taxable"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- VAT 5% -->
						<tr class="bg-gray-50">
							<td colspan="10" class="text-right px-3 py-2">VAT (5%)</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="afterparts_vat"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Total Including VAT -->
						<tr class="bg-gray-200 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Total (Including VAT)</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="afterparts_total_with_vat"
									class="tablePartTotal w-full text-right bg-gray-100"
									data-table="newPartsTable"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>
					</tfoot>


				</table>
			</div>
		</div>
		<hr class="border-gray-300 mb-6">
		<!-- Used Parts -->
		<div>
			<h4 class="text-lg font-semibold text-orange-700 mb-3">
				Used Parts
			</h4>
			<button type="button" id="addUsedPart"
				class="mb-3 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
				+ Add Used Part
			</button>

			<div class="overflow-x-auto">
				<table class="w-full border-collapse text-sm" id="usedPartsTable">
					<thead class="bg-orange-50">
						<tr>
							<th class="border px-3 py-2 w-12 text-center">✓</th>

							<th class="border px-3 py-2 text-center w-12">SL</th>
							<th class="border px-3 py-2 w-32">Brand</th>
							<th class="border px-3 py-2">Part</th>
							<th class="border px-3 py-2 text-center w-20">Qty</th>
							<th class="border px-3 py-2 text-right w-28">Unit Price</th>
							<th class="border px-3 py-2 text-center w-24">Markup %</th>
							<th class="border px-3 py-2 text-right w-28">Selling Price</th>
							<th class="border px-3 py-2 text-center w-24">Discount</th>
							<th class="border px-3 py-2 text-center w-24">Dis-Amount</th>
							<th class="border px-3 py-2 text-right w-32">Total Price</th>
							<th class="border px-3 py-2 text-center w-20">Action</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<!-- Rows will come here -->
						<?php if (!empty($parts_used_used)): ?>
							<?php foreach ($parts_used_used as $i => $p): ?>
								<tr class="hover:bg-gray-50 transition">
									<td class="border px-2 py-2 text-center">
										<input type="checkbox"
											name="customer_selected[]"
											value="<?= $p->part_id ?>"
											class="w-4 h-4 accent-green-600">
									</td>
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
											oninput="this.value = this.value.replace(/[^0-9.%]/g,''); calculateDiscount(this);"
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
									<td class="hidden border px-2 py-2 text-right">
										<input type="hidden" name="part_type[]"
											class="parttype w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->part_type ?>" readonly>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>

					<!-- <tfoot>
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Total</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									class="tablePartTotal w-full text-right bg-gray-100"
									data-table="usedPartsTable"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>
					</tfoot> -->

					<tfoot>
						<!-- Parts Sub Total -->
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Sub Total</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="usedparts_subtotal"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Total Discount -->
						<tr class="bg-gray-50">
							<td colspan="10" class="text-right px-3 py-2">Total Discount</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="usedparts_discount_total"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Taxable Amount -->
						<tr class="bg-gray-100 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Taxable Amount</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="usedparts_taxable"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- VAT 5% -->
						<tr class="bg-gray-50">
							<td colspan="10" class="text-right px-3 py-2">VAT (5%)</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="usedparts_vat"
									class="w-full text-right bg-gray-100"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>

						<!-- Total Including VAT -->
						<tr class="bg-gray-200 font-semibold">
							<td colspan="10" class="text-right px-3 py-2">Parts Total (Including VAT)</td>
							<td class="px-3 py-2 text-right">
								<input type="text"
									id="usedparts_total_with_vat"
									class="tablePartTotal w-full text-right bg-gray-100"
									data-table="newPartsTable"
									readonly
									value="0.00">
							</td>
							<td></td>
						</tr>
					</tfoot>

				</table>
			</div>
		</div>

		<p class="text-xs text-gray-500 mt-6">
			Parts are grouped by inventory type: New, Aftermarket, and Used.
			Pricing, markup, and discounts are calculated per item.
		</p>

		<hr class="border-gray-300 mb-6">

		<!-- ============================================= -->
		<div class="flex items-center justify-between mb-4">
			<h3 class="text-lg font-semibold text-gray-800">
				Sublet Services
			</h3>

			<button type="button"
				onclick="addJobRow()"
				class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
				<span class="text-lg">+</span> Add Services
			</button>
		</div>

		<!-- Table -->
		<div class="overflow-x-auto">
			<table class="w-full border-collapse text-sm" id="jobDescTable">

				<thead>
					<tr class="bg-gray-100 text-gray-700">
						<th class="border px-4 py-2 w-16 text-center">#</th>
						<th class="border px-4 py-2">Job Description</th>
						<th class="border px-4 py-2">Amount</th>
						<th class="border px-4 py-2 w-24 text-center">Action</th>
					</tr>
				</thead>

				<tbody>

					<tr class="hover:bg-gray-50 transition" id="job_1">
						<td class="border px-3 py-2 text-center font-medium">
							1
						</td>

						<!-- Job Description -->
						<td class="border px-3 py-2">
							<input type="text"
								name="job_description[]"
								value=""
								placeholder="Enter job description..."
								class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none">
						</td>
						<td class="border px-3 py-2">
							<input type="number"
								name="job_amount[]"
								value=""
								placeholder="Enter job amount..."
								class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none jobAmount">
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

				</tbody>

				<!-- <tfoot>
					<tr class="bg-gray-100 font-semibold">
						<td colspan="2" class="text-right px-3 py-2">Job Total</td>
						<td class="px-3 py-2 text-right">
							<input type="text" id="job_total" class="w-full text-right bg-gray-100" readonly value="0.00">
						</td>
						<td></td>
					</tr>
				</tfoot> -->

				
				<tfoot>
					<!-- Service Total -->
					<tr class="bg-gray-100 font-semibold">
						<td colspan="4" class="text-right px-3 py-2">Service Total</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_total"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>

					<!-- VAT Amount (5%) -->
					<tr class="bg-gray-50">
						<td colspan="4" class="text-right px-3 py-2">Service VAT (5%)</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_vat"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>

					<!-- Total Including VAT -->
					<tr class="bg-gray-200 font-semibold">
						<td colspan="4" class="text-right px-3 py-2">Service Total (Including VAT)</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_total_with_vat"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<p class="text-xs text-gray-500 mt-3">
			Assign sublet services for better tracking.
		</p>
		<hr class="border-gray-300 mb-6">


		<!-- ================================================================== -->




		<!-- FOOTER DETAILS -->

		<div class="bg-white rounded-2xl shadow-md p-6 mt-8 text-sm" style="display:none">

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
   	UTILITIES
	================================ */

	// Safe number parser (prevents NaN)
	function num(val) {
		val = parseFloat(val);
		return isNaN(val) ? 0 : val;
	}

	// Debounce helper (performance)
	let gtTimer = null;

	function debounceGrandTotal() {
		clearTimeout(gtTimer);
		gtTimer = setTimeout(calculateGrandTotal, 200);
	}

	/* ===============================
	   JOB DESCRIPTION
	================================ */
	/* ===============================
		   JOB DESCRIPTION
		================================ */



	function addJobRow() {
		jobRowCount++;



		const row = `
            <tr class="hover:bg-gray-50 transition" id="job_${jobRowCount}">
                <td class="border px-3 py-2 text-center font-medium">
                    ${jobRowCount}
                </td>

               
                <td class="border px-3 py-2">
                    <input type="text"
                        name="job_description[]"
                        placeholder="Enter job description..."
                        class="w-full border rounded-lg px-3 py-2 
                               focus:ring-2 focus:ring-blue-300 focus:outline-none">
                </td>
				<td class="border px-3 py-2">
									<input type="number"
										name="job_amount[]"
										value=""
										placeholder="Enter job amount..."
										class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none jobAmount">
								</td>

                
                
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
	let partCounters = {
		newPartsTable: 0,
		aftermarketPartsTable: 0,
		usedPartsTable: 0
	};

	function addPartRow(tableId, parttype) {

		partCounters[tableId]++;
		let brandOptions = '<option value="">-- Select Brand --</option>';

		if (parttype === "New Parts") {

			brandOptions += `
        <?php foreach ($newbrands as $brand): ?>
            <option value="<?= $brand->brand_id ?>" data-parttype="New Parts">
                <?= $brand->brand_name ?>
            </option>
        <?php endforeach; ?>`;

		} else if (parttype === "Aftermarket Parts") {

			brandOptions += `
        <?php foreach ($afterbrands as $brand): ?>
            <option value="<?= $brand->brand_id ?>">
                <?= $brand->brand_name ?>
            </option>
        <?php endforeach; ?>`;

		} else if (parttype === "Used Parts") {

			brandOptions += `
        <?php foreach ($usedbrands as $brand): ?>
            <option value="<?= $brand->brand_id ?>">
                <?= $brand->brand_name ?>
            </option>
        <?php endforeach; ?>`;
		}
		const row = `
   		 <tr class="hover:bg-gray-50 transition">
		<td class="border px-2 py-2 text-center">
			<input type="checkbox"
				name="customer_selected[]"
				value=""
				class="customerSelected w-4 h-4 accent-green-600"
				 >
		</td>


        <td class="border px-2 py-2 text-center font-medium">
            ${partCounters[tableId]}
        </td>

        <!-- Brand -->
        <td class="border px-2 py-2">
            <select name="brand_id[]"
                    class="brandSelect w-full border rounded-lg px-2 py-1">
                ${brandOptions}
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
                   value="1" min="1">
        </td>

        <!-- Unit Price -->
        <td class="border px-2 py-2 text-right">
            <input type="number" step="0.01" name="unit_price[]"
                   class="unitPrice w-full border rounded-lg px-2 py-1 text-right"
                   value="0.00">
        </td>

        <!-- Markup -->
        <td class="border px-2 py-2 text-center">
            <input type="number" step="0.01" name="markup[]"
                   class="markup w-20 border rounded-lg px-2 py-1 text-center"
                   value="0"
                   oninput="calculateSellingPrice(this)">
        </td>

        <!-- Selling -->
        <td class="border px-2 py-2 text-right">
            <input type="number" step="0.01" name="selling_price[]"
                   class="sellPrice w-full border rounded-lg px-2 py-1 text-right"
                   value="0.00">
        </td>

        <!-- Discount -->
        <td class="border px-2 py-2 text-center">
            <input type="text" name="discount[]"
                   class="discount w-20 border rounded-lg px-2 py-1 text-center"
                
                   onkeydown="allowNumberAndPercent(event)"
                   oninput="this.value = this.value.replace(/[^0-9.%]/g,'');calculateDiscount(this);">
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
		<td class="hidden border px-2 py-2 text-center">
             <input type="hidden" name="part_type[]"
                   class="parttype w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
                   value="${parttype}" readonly>
        </td>
    	</tr>`;

		document.querySelector(`#${tableId} tbody`)
			.insertAdjacentHTML("beforeend", row);
	}

	document.getElementById("addNewPart")
		.addEventListener("click", () => addPartRow("newPartsTable", "New Parts"));

	document.getElementById("addAftermarketPart")
		.addEventListener("click", () => addPartRow("aftermarketPartsTable", "Aftermarket Parts"));

	document.getElementById("addUsedPart")
		.addEventListener("click", () => addPartRow("usedPartsTable", "Used Parts"));


	document.addEventListener('change', function(e) {

		/* ===============================
		   BRAND CHANGE → LOAD PARTS
		   =============================== */
		if (e.target.classList.contains('brandSelect')) {

			const brandId = e.target.value;
			const row = e.target.closest('tr');
			const partSelect = row.querySelector('.partSelect');

			if (!brandId) {
				partSelect.innerHTML = '<option value="">-- Select Brand First --</option>';
				return;
			}

			partSelect.innerHTML = '<option value="">Loading...</option>';

			fetch('<?= base_url("index.php/estimation/get_parts_by_brand/1") ?>', {
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
                    <option value="${p.part_id}" data-price="${p.unit_price}">
                        ${p.part_name}
                    </option>`;
					});

					partSelect.innerHTML = options;
				});
		}

		/* ===============================
		   PART CHANGE → CHECKBOX SYNC
		   =============================== */
		if (e.target.classList.contains('partSelect')) {

			const row = e.target.closest('tr');
			const checkbox = row.querySelector('.customerSelected');
			const partId = e.target.value;

			if (!checkbox) return;

			if (partId) {
				checkbox.value = partId;
				checkbox.disabled = false;
			} else {
				checkbox.value = '';
				checkbox.checked = false;
				checkbox.disabled = true;
			}
		}

	});
	document.addEventListener("click", function(e) {

		const btn = e.target.closest(".remove-row");
		if (!btn) return;

		const table = btn.closest("table");
		const tableId = table.id;

		btn.closest("tr").remove();
		updateSlNo(tableId);
	});

	function updateSlNo(tableId) {

		const rows = document.querySelectorAll(`#${tableId} tbody tr`);

		rows.forEach((row, index) => {
			row.querySelector("td").innerText = index + 1;
		});

		partCounters[tableId] = rows.length;
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
            <?php endforeach; ?>`;

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
	/* ===============================
	   GLOBAL EVENT HANDLING
	================================ */
	document.addEventListener("input", function(e) {

		// Part table changes
		if (e.target.closest("#partsTable")) {

			const row = e.target.closest("tr");

			if (e.target.classList.contains("discount")) {
				e.target.value = e.target.value.replace(/[^0-9%]/g, '');
				calculateDiscount(e.target);
				return;
			}

			updatePartRow(row);
			debounceGrandTotal();
		}

		// Service table changes
		if (e.target.closest("#serviceTable")) {
			updateServiceRow(e.target.closest("tr"));
			debounceGrandTotal();
		}

		if (e.target.classList.contains("jobAmount")) {
			calculateJobTotal();
			debounceGrandTotal();
		}
	});

	document.addEventListener("change", function(e) {

		// Auto-fill unit price on part select
		if (e.target.classList.contains("partSelect")) {
			const row = e.target.closest("tr");
			const price = e.target.selectedOptions[0]?.dataset.price || 0;

			row.querySelector(".unitPrice").value = price;
			row.querySelector(".sellPrice").value = price;

			updatePartRow(row);
			debounceGrandTotal();
		}

		// Auto-fill service values
		if (e.target.classList.contains("serviceSelect")) {
			const row = e.target.closest("tr");
			const opt = e.target.selectedOptions[0];

			row.querySelector(".serviceCost").value = opt?.dataset.price || 0;
			row.querySelector(".serviceTime").value = opt?.dataset.time || 1;

			updateServiceRow(row);
			debounceGrandTotal();
		}
	});
	/* ===============================
	   ROW CALCULATIONS
	================================ */
	/* ===============================
	   PART ROW CALCULATION
	================================ */
	function updatePartRow(row) {

		const qty = num(row.querySelector(".partQty")?.value || 1);
		const unit = num(row.querySelector(".unitPrice")?.value);
		const sell = num(row.querySelector(".sellPrice")?.value);
		const disc = num(row.querySelector(".discountamt")?.value);

		const price = sell > 0 ? sell : unit;

		let total = (qty * price) - disc;
		if (total < 0) total = 0;

		row.querySelector(".rowTotal").value = total.toFixed(2);
	}

	/* ===============================
	   SERVICE ROW CALCULATION
	================================ */
	// function updateServiceRow(row) {

	// 	const time = num(row.querySelector(".serviceTime")?.value || 1);
	// 	const cost = num(row.querySelector(".serviceCost")?.value);

	// 	row.querySelector(".totalCost").value = (time * cost).toFixed(2);
	// }

	/* ===============================
	   DELETE ROWS
	================================ */
	document.addEventListener("click", function(e) {
		if (e.target.classList.contains("remove-row")) {
			e.target.closest("tr").remove();

			if (table.id === "jobDescTable") calculateJobTotal();
			if (table.id === "serviceTable") calculateServiceTotal();
			if (table.id.includes("PartsTable")) calculatePartsTableTotal(table.id);

			renumber("#partsTable");
			renumber("#serviceTable");
			renumber("#jobDescTable");
			calculateGrandTotal();
		}
	});



	/* ===============================
	   GRAND TOTAL
	================================ */


	// function calculateGrandTotal() {

	// 	const jobTotal = num(document.getElementById("job_total")?.value);
	// 	const serviceTotal = num(document.getElementById("service_total")?.value);

	// 	let partsTotal = 0;
	// 	document.querySelectorAll(".tablePartTotal").forEach(el => {
	// 		partsTotal += num(el.value);
	// 	});

	// 	const subtotal = jobTotal + serviceTotal + partsTotal;

	// 	const taxPercent = num(document.getElementById("tax_percent")?.value);
	// 	const discount = num(document.getElementById("discount")?.value);

	// 	const taxAmount = subtotal * taxPercent / 100;
	// 	const grandTotal = subtotal + taxAmount - discount;

	// 	document.getElementById("subtotal").value = subtotal.toFixed(2);
	// 	document.getElementById("tax_amount").value = taxAmount.toFixed(2);
	// 	document.getElementById("grand_total").value = grandTotal.toFixed(2);
	// }

	// function calculateGrandTotal() {

	// 	const jobTotal = num(document.getElementById("job_total")?.value);
	// 	const serviceTotal = num(document.getElementById("service_total")?.value);

	// 	// 🔹 Service VAT (5%)
	// 	const serviceVatPercent = 5;
	// 	const serviceVatAmount = serviceTotal * serviceVatPercent / 100;
	// 	const serviceTotalWithVat = serviceTotal + serviceVatAmount;

	// 	document.getElementById("service_vat").value = serviceVatAmount.toFixed(2);
	// 	document.getElementById("service_total_with_vat").value = serviceTotalWithVat.toFixed(2);

	// 	let partsTotal = 0;
	// 	document.querySelectorAll(".tablePartTotal").forEach(el => {
	// 		partsTotal += num(el.value);
	// 	});

	// 	// 🔹 Use service total INCLUDING VAT
	// 	const subtotal = jobTotal + serviceTotalWithVat + partsTotal;

	// 	const taxPercent = num(document.getElementById("tax_percent")?.value);
	// 	const discount = num(document.getElementById("discount")?.value);

	// 	const taxAmount = subtotal * taxPercent / 100;
	// 	const grandTotal = subtotal + taxAmount - discount;

	// 	document.getElementById("subtotal").value = subtotal.toFixed(2);
	// 	document.getElementById("tax_amount").value = taxAmount.toFixed(2);
	// 	document.getElementById("grand_total").value = grandTotal.toFixed(2);
	// }

	function calculateGrandTotal() {

		const jobTotal = num(document.getElementById("job_total")?.value);
		const serviceTotalWithVat = num(document.getElementById("service_total_with_vat")?.value);
		const partsTotalWithVat = num(document.getElementById("parts_total_with_vat")?.value);

		const subtotal = jobTotal + serviceTotalWithVat + partsTotalWithVat;

		const taxPercent = num(document.getElementById("tax_percent")?.value);
		const discount = num(document.getElementById("discount")?.value);

		const taxAmount = subtotal * taxPercent / 100;
		const grandTotal = subtotal + taxAmount - discount;

		document.getElementById("subtotal").value = subtotal.toFixed(2);
		document.getElementById("tax_amount").value = taxAmount.toFixed(2);
		document.getElementById("grand_total").value = grandTotal.toFixed(2);
	}
	/* ===============================
	   RENUMBER UTILITY
	================================ */
	function renumber(tableId) {
		document.querySelectorAll(`${tableId} tbody tr`)
			.forEach((row, i) => row.querySelector("td").innerText = i + 1);
	}

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


	/* ===============================
   DISCOUNT CALCULATION
		================================ */
	function calculateDiscount(input) {

		const row = input.closest("tr");

		const qty = num(row.querySelector(".partQty")?.value || 1);
		const sellPrice = num(row.querySelector(".sellPrice")?.value);
		const discOut = row.querySelector(".discountamt");

		let val = input.value.trim();
		let discAmt = 0;

		// Percentage discount
		if (val.endsWith("%")) {
			const percent = num(val.replace("%", ""));
			discAmt = (qty * sellPrice) * (percent / 100);
		}
		// Flat discount
		else {
			discAmt = num(val);
		}

		discOut.value = discAmt.toFixed(2);

		updatePartRow(row);
		debounceGrandTotal();
	}


	/* ===============================
   	SELLING PRICE CALCULATION
		================================ */
	function calculateSellingPrice(input) {

		const row = input.closest("tr");

		const unit = num(row.querySelector(".unitPrice").value);
		const mark = num(input.value);
		const qty = num(row.querySelector(".partQty").value);

		const selling = unit + (unit * mark / 100);

		row.querySelector(".sellPrice").value = selling.toFixed(2);
		row.querySelector(".rowTotal").value = (selling * qty).toFixed(2);

		debounceGrandTotal();
	}


	function calculateJobTotal() {
		let total = 0;
		document.querySelectorAll("#jobDescTable .jobAmount").forEach(el => {
			total += num(el.value);
		});
		document.getElementById("job_total").value = total.toFixed(2);
	}

	function calculateServiceTotal() {
		let total = 0;
		document.querySelectorAll("#serviceTable .totalCost").forEach(el => {
			total += num(el.value);
		});

		document.getElementById("service_total").value = total.toFixed(2);

	}

	function updateServiceRow(row) {
		const time = num(row.querySelector(".serviceTime")?.value);
		const cost = num(row.querySelector(".serviceCost")?.value);

		row.querySelector(".totalCost").value = (time * cost).toFixed(2);

		calculateServiceTotal();
	}

	function calculatePartsTableTotal(tableId) {
		let total = 0;

		document.querySelectorAll(`#${tableId} .rowTotal`).forEach(el => {
			total += num(el.value);
		});

		document
			.querySelector(`.tablePartTotal[data-table="${tableId}"]`)
			.value = total.toFixed(2);
	}

	function updatePartRow(row) {
		const qty = num(row.querySelector(".partQty")?.value);
		const unit = num(row.querySelector(".unitPrice")?.value);
		const sell = num(row.querySelector(".sellPrice")?.value);
		const disc = num(row.querySelector(".discountamt")?.value);

		const price = sell > 0 ? sell : unit;
		let total = (qty * price) - disc;
		if (total < 0) total = 0;

		row.querySelector(".rowTotal").value = total.toFixed(2);

		const tableId = row.closest("table").id;
		calculatePartsTableTotal(tableId);
	}



	// =======================================================


	function calculatePartsTotals() {

		let subTotal = 0;
		let discountTotal = 0;

		document.querySelectorAll("#newPartsTable tbody tr").forEach(row => {
			const qty = num(row.querySelector(".partQty")?.value);
			const sell = num(row.querySelector(".sellPrice")?.value);
			const disc = num(row.querySelector(".discountamt")?.value);

			const rowAmount = qty * sell;

			subTotal += rowAmount;
			discountTotal += disc;
		});

		const taxable = subTotal - discountTotal;
		const vat = taxable * 0.05;
		const totalWithVat = taxable + vat;

		document.getElementById("parts_subtotal").value = subTotal.toFixed(2);
		document.getElementById("parts_discount_total").value = discountTotal.toFixed(2);
		document.getElementById("parts_taxable").value = taxable.toFixed(2);
		document.getElementById("parts_vat").value = vat.toFixed(2);
		document.getElementById("parts_total_with_vat").value = totalWithVat.toFixed(2);
	}

	function calculateDiscount(input) {

		const row = input.closest("tr");

		const qty = num(row.querySelector(".partQty")?.value || 1);
		const sellPrice = num(row.querySelector(".sellPrice")?.value);
		const discOut = row.querySelector(".discountamt");

		let val = input.value.trim();
		let discAmt = 0;

		if (val.endsWith("%")) {
			const percent = num(val.replace("%", ""));
			discAmt = (qty * sellPrice) * (percent / 100);
		} else {
			discAmt = num(val);
		}

		discOut.value = discAmt.toFixed(2);

		updatePartRow(row);
		calculatePartsTotals(); // ✅ ADD THIS
		debounceGrandTotal();
	}
</script>
