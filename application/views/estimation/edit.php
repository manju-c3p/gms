<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<style>
	.modal-overlay {
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, 0.6);
		display: none;
		align-items: center;
		justify-content: center;
		z-index: 9999;
	}

	.modal-overlay.show {
		display: flex;
	}

	.modal-box {
		background: white;
		border-radius: 12px;
		padding: 16px;
		position: relative;
	}

	html,
	body {
		height: 100%;
		margin: 0;
		overflow-x: hidden;
	}

	.content-wrapper,
	.main-content,
	.page-content {
		height: auto !important;
		overflow-y: visible !important;
	}
</style>
<div class="w-full mx-0">

	<form method="post" action="<?= base_url('index.php/Estimation/update'); ?>" class="p-6 bg-white">
		<input type="hidden" name="estimation_id" value="<?= $estimation_id ?>">

		<!-- ================================ -->

		<?php if ($this->session->flashdata('error')): ?>
			<div class="bg-red-100 text-red-700 p-3 rounded mb-3">
				<?= $this->session->flashdata('error'); ?>
			</div>
		<?php endif; ?>


		<div class="page-header flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">

			<!-- Title -->
			<h2 class="text-xl font-bold text-center lg:text-left">
				Estimation
			</h2>

			<!-- Action Buttons -->
			<div class="flex flex-col sm:flex-row sm:flex-wrap gap-2 justify-center lg:justify-end">

				<button type="submit"
					class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded">
					Update
				</button>

				<a href="<?= base_url('index.php/Estimation/view/' . $estimation_id) ?>"
					class="w-full sm:w-auto text-center px-6 py-2 bg-gray-400 text-white rounded">
					View &amp; Print
				</a>

				<a href="<?= base_url('index.php/Quotation/edit_by_estimation/' . $estimation_id) ?>"
					class="w-full sm:w-auto text-center px-6 py-2 bg-blue-400 text-white rounded">
					Quotation
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
		<!-- <div class="bg-white rounded-2xl shadow-md mb-6 p-2"> -->
		<div class="w-full mx-0">
			<h3 class="font-semibold mb-4">Vehicle & Customer Details</h3>

			<div class="relative w-full overflow-x-auto overflow-y-visible">

				<table class="w-full border mb-4 text-sm min-w-[600px]">
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
									value="<?= $appointment->customer_name ?? $customer->name ?>">
							</td>

							<td class="border p-2 font-medium">Contact No</td>
							<td class="border p-2">
								<input type="text" class="w-full border rounded px-2 py-1"
									value="<?= $appointment->phone ?? $customer->phone ?>">
							</td>

							<td class="border p-2 font-medium">Email</td>
							<td class="border p-2">
								<input type="email" class="w-full border rounded px-2 py-1"
									value="<?= $appointment->email ?? $customer->email ?>">
							</td>
						</tr>

						<!-- ROW 3 -->
						<tr>
							<td class="border p-2 font-medium">Vehicle Model</td>
							<td class="border p-2">
								<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
									value="<?= $appointment->model ?? $vehicle->model ?>" readonly>
							</td>

							<td class="border p-2 font-medium">Registration No</td>
							<td class="border p-2">
								<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
									value="<?= $appointment->registration_no ?? $vehicle->registration_no ?>" readonly>
							</td>

							<td class="border p-2 font-medium">VIN No</td>
							<td class="border p-2">
								<input type="text" class="w-full border rounded px-2 py-1 bg-gray-100"
									value="<?= $appointment->chassis_no ?? $vehicle->chassis_no  ?>" readonly>
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
								<input type="number" name="kmin" class="w-full border rounded px-2 py-1" value="<?= $kms ?>">
							</td>

							<td class="border p-2 font-medium">Customer Approval</td>
							<td class="border p-2">
								<select class="w-full border rounded px-2 py-1" name="custapproval">
									<option value="">-- Select --</option>
									<option value="APPROVED" selected>Approved</option>
									<option value="PENDING">Pending</option>
									<option value="REJECTED">Rejected</option>
								</select>
							</td>

							<td class="border p-2 font-medium">Estimated Price</td>
							<td class="border p-2">
								<input type="number"
									step="0.01"
									class="w-full border rounded px-2 py-1"
									name="estimatedprice"
									value="<?= $estimation->customer_estimated_price ?? '' ?>">
							</td>
						</tr>

						<!-- ROW 5 -->
						<tr>


							<td class="border p-2 font-medium">Estimated Delivery Date</td>
							<td class="border p-2">
								<input type="date" class="w-full border rounded px-2 py-1" name="estdeldate" value="<?= $estimation->est_delivery_date ?? '' ?>">
							</td>

							<td class="border p-2 font-medium">Completion Time</td>
							<td class="border p-2">
								<input type="time" class="w-full border rounded px-2 py-1" name="completiontime" value="<?= $estimation->est_completion_time ?? '' ?>">
							</td>

							<td class="border p-2 font-medium">Remark</td>
							<td class="border p-2" colspan="5">
								<textarea class="w-full border rounded px-2 py-1 h-20" name="remarks"><?= $estimation->remarks ?? '' ?></textarea>
							</td>
						</tr>



					</tbody>
				</table>
			</div>
		</div>
		<hr class="border-gray-300 mb-6">
		<!-- ====================services table========================================= -->
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
		<!-- <div class="relative w-full overflow-x-auto overflow-y-visible">
 -->
		<div>
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
									<select name="service_id[]" id="serviceSelect"
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
								readonly>
						</td>
						<td></td>
					</tr>
					<!-- ================================================= -->
					<tr class="bg-gray-50">
						<td colspan="4" class="text-right px-3 py-2">Discount Amount</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_discount" name="service_discount" value="<?= $service_discount ?>"
								class="w-full text-right bg-gray-100">
						</td>
						<td></td>
					</tr>
					<tr class="bg-gray-100">
						<td colspan="4" class="text-right px-3 py-2">Taxable Amount</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_taxable_amt"
								class="w-full text-right bg-gray-100"
								readonly>
						</td>
						<td></td>
					</tr>



					<!-- ================================================================== -->

					<!-- VAT Amount (5%) -->
					<tr class="bg-gray-50">
						<td colspan="4" class="text-right px-3 py-2">Service VAT (5%)</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="service_vat"
								class="w-full text-right bg-gray-100"
								readonly>
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
								readonly>
						</td>
						<td></td>
					</tr>
				</tfoot>


			</table>
		</div>

		<p class="text-xs text-gray-500 mt-3">
			Labour cost is calculated automatically based on time and rate.
		</p>
		<hr class="border-gray-300 mb-6">
		<!-- ==========================sapre parts======================================== -->

		<!-- <div class="bg-white rounded-xl shadow p-3 mt-4"> -->

		<h3 class="text-xl font-semibold text-gray-800 mb-6">
			Spare Parts Used
		</h3>

		<!-- New Parts -->
		<div class="mb-10">
			<h4 class="text-lg font-semibold text-blue-700 mb-3">
				Original Parts / Consumables
			</h4>
			<button type="button" id="addNewPart"
				class="mb-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
				+ Add Original Part
			</button>

			<div class="relative w-full overflow-x-auto overflow-y-visible">

				<table class="w-full border-collapse text-sm" id="newPartsTable">
					<thead class="bg-blue-50">
						<tr>
							<th class="border px-3 py-2 w-12 text-center">✓</th>

							<th class="border px-3 py-2 text-center w-12">SL</th>
							<th class="border px-3 py-2 w-32 hidden">Brand</th>
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
											class="w-4 h-4 accent-green-600" <?= ($p->selected == 1) ? 'checked' : '' ?>>
									</td>

									<!-- SL -->
									<td class="border px-2 py-2 text-center font-medium">
										<?= $i + 1 ?>
									</td>

									<!-- Brand -->
									<td class="border px-2 py-2 hidden">
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
											<!-- <option value="">-- Select Brand First --</option> -->
											<option value="<?= $p->part_id ?>"><?= $p->part_name ?></option>
										</select>

										<textarea name="part_warrenty[]" rows="3" class="partWarrenty w-full border rounded-lg px-2 py-1"><?= $p->partremarks ?? null ?></textarea>
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
											value="<?= $p->markup_percentage ?? 0 ?>" oninput="calculateSellingPrice(this)">
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
										<input type="text" step="0.01" name="discountamt[]"
											class="discountamt w-20 border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->dis_amount ?? 0 ?>" readonly>
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
											class="rowTotal w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->part_type ?>" readonly>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
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

			<div class="relative w-full overflow-x-auto overflow-y-visible">

				<table class="w-full border-collapse text-sm" id="aftermarketPartsTable">
					<thead class="bg-green-50">
						<tr>
							<th class="border px-3 py-2 w-12 text-center">✓</th>

							<th class="border px-3 py-2 text-center w-12">SL</th>
							<th class="border px-3 py-2 w-32 hidden">Brand</th>
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
						<?php if (!empty($parts_used_after)): ?>
							<?php foreach ($parts_used_after as $i => $p): ?>
								<tr class="hover:bg-gray-50 transition">
									<td class="border px-2 py-2 text-center">
										<input type="checkbox"
											name="customer_selected[]"
											value="<?= $p->part_id ?>"
											class="w-4 h-4 accent-green-600" <?= ($p->selected == 1) ? 'checked' : '' ?>>
									</td>
									<!-- SL -->
									<td class="border px-2 py-2 text-center font-medium">
										<?= $i + 1 ?>
									</td>

									<!-- Brand -->
									<td class="border px-2 py-2 hidden">
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
											<option value="<?= $p->part_id ?>"><?= $p->part_name ?></option>
										</select>
										<textarea name="part_warrenty[]" rows="3" class="partWarrenty w-full border rounded-lg px-2 py-1"><?= $p->partremarks ?? null ?></textarea>

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
											value="<?= $p->markup_percentage ?? 0 ?>" oninput="calculateSellingPrice(this)">
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
										<input type="text" step="0.01" name="discountamt[]"
											class="discountamt w-20 border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->dis_amount ?? 0 ?>" readonly>
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
											class="rowTotal w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->part_type ?>" readonly>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
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
									data-table="aftermarketPartsTable"
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

			<div class="relative w-full overflow-x-auto overflow-y-visible">

				<table class="w-full border-collapse text-sm" id="usedPartsTable">
					<thead class="bg-orange-50">
						<tr>
							<th class="border px-3 py-2 w-12 text-center">✓</th>

							<th class="border px-3 py-2 text-center w-12">SL</th>
							<th class="border px-3 py-2 w-32 hidden">Brand</th>
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
						<?php if (!empty($parts_used_used)): ?>
							<?php foreach ($parts_used_used as $i => $p): ?>
								<tr class="hover:bg-gray-50 transition">
									<td class="border px-2 py-2 text-center">
										<input type="checkbox"
											name="customer_selected[]"
											value="<?= $p->part_id ?>"
											class="w-4 h-4 accent-green-600" <?= ($p->selected == 1) ? 'checked' : '' ?>>
									</td>
									<!-- SL -->
									<td class="border px-2 py-2 text-center font-medium">
										<?= $i + 1 ?>
									</td>

									<!-- Brand -->
									<td class="border px-2 py-2 hidden">
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
											<option value="<?= $p->part_id ?>"><?= $p->part_name ?></option>
										</select>
										<textarea name="part_warrenty[]" rows="3" class="partWarrenty w-full border rounded-lg px-2 py-1"><?= $p->partremarks ?? null ?></textarea>

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
											value="<?= $p->markup_percentage ?? 0 ?>" oninput="calculateSellingPrice(this)">
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
										<input type="text" name="discountamt[]"
											class="discountamt w-20 border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->dis_amount ?? 0 ?>" readonly>
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
											class="rowTotal w-full border rounded-lg px-2 py-1 text-right bg-gray-100"
											value="<?= $p->part_type ?>" readonly>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
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
									data-table="usedPartsTable"
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
		<!-- </div> -->
		<hr class="border-gray-300 mb-6">

		<!-- ================sublet services============================= -->

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
		<div class="relative w-full overflow-x-auto overflow-y-visible">

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

								<td class="border px-3 py-2">
									<input type="text"
										name="job_amount[]"
										value="<?= $j->amount ?>"
										placeholder="Enter job description..."
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
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
				<tfoot>
					<!-- Job Sub Total -->
					<tr class="bg-gray-100 font-semibold">
						<td colspan="2" class="text-right px-3 py-2">Job Sub Total</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="job_subtotal"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>

					<!-- Taxable Amount (same as subtotal, no discount here) -->
					<tr class="bg-gray-50">
						<td colspan="2" class="text-right px-3 py-2">Taxable Amount</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="job_taxable"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>

					<!-- VAT 5% -->
					<tr class="bg-gray-50">
						<td colspan="2" class="text-right px-3 py-2">VAT (5%)</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="job_vat"
								class="w-full text-right bg-gray-100"
								readonly
								value="0.00">
						</td>
						<td></td>
					</tr>

					<!-- Job Total Including VAT -->
					<tr class="bg-gray-200 font-semibold">
						<td colspan="2" class="text-right px-3 py-2">Job Total (Including VAT)</td>
						<td class="px-3 py-2 text-right">
							<input type="text"
								id="job_total"
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
					<label class="block text-gray-600 font-medium mb-1">Other Discount</label>
					<input id="tdiscount" name="tdiscount"

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

<!-- SERVICE MODAL -->
<!-- <div id="serviceModal"
	class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center"> -->

<div id="serviceModal"
	class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center">

	<!-- fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center -->
	<div class="bg-white rounded-xl w-full max-w-md p-4 relative">
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
</div>
<!-- Add Part Modal -->
<div id="addPartModal"
	class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">

	<div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6">

		<!-- Header -->
		<div class="flex justify-between items-center mb-4">
			<h2 id="addPartModalTitle"
				class="text-lg font-semibold text-gray-800">
				Add New Part
			</h2>
			<button type="button"
				onclick="closeAddPartModal()"
				class="text-gray-500 hover:text-red-600 text-xl">
				✕
			</button>
		</div>

		<!-- Body -->
		<div class="space-y-4">

			<!-- Part Name -->
			<div>
				<label class="block text-sm font-medium mb-1">
					Part Name <span class="text-red-500">*</span>
				</label>
				<input type="text"
					id="new_part_name"
					class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-300"
					placeholder="Enter part name">
			</div>

			<!-- Unit Price -->
			<div>
				<label class="block text-sm font-medium mb-1">
					Unit Price
				</label>
				<input type="number"
					step="0.01"
					id="new_part_price"
					class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-300"
					placeholder="0.00">
			</div>

			<!-- Labeling -->
			<div class="flex items-center gap-2">
				<input
					type="checkbox"
					id="labeling"
					name="labeling"
					value="1"
					class="w-4 h-4 border rounded"
					checked>
				<label for="labeling" class="font-medium cursor-pointer">
					Labeled Part
				</label>
			</div>

			<!-- Hidden Part Type -->
			<input type="hidden" id="new_part_type">
		</div>

		<!-- Footer -->
		<div class="flex justify-end gap-3 mt-6">
			<button type="button"
				onclick="closeAddPartModal()"
				class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
				Cancel
			</button>

			<button type="button"
				onclick="submitAddPart()"
				class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
				Save Part
			</button>
		</div>
	</div>
</div>

<!-- ========================================= script fncs======================== -->
<script>
	let partCounters = {
		newPartsTable: 0,
		aftermarketPartsTable: 0,
		usedPartsTable: 0
	};
	document.addEventListener("DOMContentLoaded", function() {

		// ✅ Initialize counters from existing rows (EDIT page fix)
		partCounters.newPartsTable =
			document.querySelectorAll('#newPartsTable tbody tr').length;

		partCounters.aftermarketPartsTable =
			document.querySelectorAll('#aftermarketPartsTable tbody tr').length;

		partCounters.usedPartsTable =
			document.querySelectorAll('#usedPartsTable tbody tr').length;

		// Initial calculations on page load
		initAllCalculations();

	});

	function initAllCalculations() {

		// 1️⃣ Update all PART rows
		document.querySelectorAll(
			"#newPartsTable tbody tr, #aftermarketPartsTable tbody tr, #usedPartsTable tbody tr"
		).forEach(row => {
			updatePartRow(row);
		});

		// 2️⃣ Calculate PARTS table totals
		calculatePartsTotals();

		// 3️⃣ Update all SERVICE rows
		document.querySelectorAll("#serviceTable tbody tr").forEach(row => {
			updateServiceRow(row);
		});

		// 4️⃣ Calculate service totals + VAT
		calculateServiceTotals();

		// 5️⃣ Calculate job totals + VAT
		calculateJobTotals();

		// 6️⃣ Final GRAND TOTAL
		calculateGrandTotal();
	}
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


	function addPartRow(tableId, parttype) {

		partCounters[tableId]++;
		let brandOptions = '<option value="">-- Select Brand --</option>';
		let partsOptions = '<option value="">-- Select Part --</option>';
		if (parttype === "New Parts") {

			brandOptions += `
        <?php foreach ($newbrands as $brand): ?>
            <option value="<?= $brand->brand_id ?>">
                <?= $brand->brand_name ?>
            </option>
        <?php endforeach; ?>`;
			partsOptions += `<option value="add_new_parts" data-addtype="new">➕ Add New Part</option>
        <?php foreach ($Newparts as $newpart): ?>
            <option value="<?= $newpart->part_id ?>" data-price="<?= $newpart->unit_price ?>">
                <?= $newpart->part_name ?> 
            </option>
        <?php endforeach; ?>`;

		} else if (parttype === "Aftermarket Parts") {

			brandOptions += `
        <?php foreach ($afterbrands as $brand): ?>
            <option value="<?= $brand->brand_id ?>">
                <?= $brand->brand_name ?>
            </option>
        <?php endforeach; ?>`;

			partsOptions += `<option value="add_after_parts" data-addtype="after">➕ Add Aftermarket Part</option>
        <?php foreach ($afterparts as $afterpart): ?>
            <option value="<?= $afterpart->part_id ?>" data-price="<?= $afterpart->unit_price ?>">
                <?= $afterpart->part_name ?> 
            </option>
        <?php endforeach; ?>`;

		} else if (parttype === "Used Parts") {

			brandOptions += `
        <?php foreach ($usedbrands as $brand): ?>
            <option value="<?= $brand->brand_id ?>">
                <?= $brand->brand_name ?>
            </option>
        <?php endforeach; ?>`;

			partsOptions += `<option value="add_used_parts" data-addtype="used">➕ Add Used Part</option>
        <?php foreach ($usedparts as $usedpart): ?>
            <option value="<?= $usedpart->part_id ?>"  data-price="<?= $usedpart->unit_price ?>">
                <?= $usedpart->part_name ?>
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
        <td class="border px-2 py-2 hidden">
            <select name="brand_id[]"
                    class="brandSelect w-full border rounded-lg px-2 py-1">
                ${brandOptions}
            </select>
        </td>

        <!-- Part -->
        <td class="border px-2 py-2">
            <select name="part_id[]"
                    class="partSelect w-full border rounded-lg px-2 py-1">
                ${partsOptions}
            </select>
			<textarea name="part_warrenty[]" rows="3"  class="partWarrenty w-full border rounded-lg px-2 py-1"></textarea>
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
                   value="0"
                   onkeydown="allowNumberAndPercent(event)"
                   oninput="this.value=this.value.replace(/[^0-9%]/g,'');calculateDiscount(this);">
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

		$('.partSelect').select2({
			width: '100%'
		});
	}

	document.getElementById("addNewPart")
		.addEventListener("click", () => addPartRow("newPartsTable", "New Parts"));

	document.getElementById("addAftermarketPart")
		.addEventListener("click", () => addPartRow("aftermarketPartsTable", "Aftermarket Parts"));

	document.getElementById("addUsedPart")
		.addEventListener("click", () => addPartRow("usedPartsTable", "Used Parts"));


	document.addEventListener('change', function(e) {

		if (e.target.classList.contains("jobAmount")) {
			calculateJobTotals();
			debounceGrandTotal();
		}


		function calculateJobTotals() {

			let subtotal = 0;

			document.querySelectorAll("#jobDescTable .jobAmount").forEach(el => {
				subtotal += num(el.value);
			});

			const vat = subtotal * 0.05;
			const totalWithVat = subtotal + vat;

			document.getElementById("job_subtotal").value = subtotal.toFixed(2);
			document.getElementById("job_taxable").value = subtotal.toFixed(2);
			document.getElementById("job_vat").value = vat.toFixed(2);
			document.getElementById("job_total").value = totalWithVat.toFixed(2);
		}

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

			fetch('<?= base_url("index.php/Estimation/get_parts_by_brand") ?>', {
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
		// alert("gh");
		if (!btn) return;

		const table = btn.closest("table");
		const tableId = table.id;

		btn.closest("tr").remove();
		debounceGrandTotal();
		updateSlNo(tableId);
	});



	function updateSlNo(tableId) {

		const rows = document.querySelectorAll(`#${tableId} tbody tr`);

		rows.forEach((row, index) => {
			// ✅ target SL column (2nd td)
			row.querySelector("td:nth-child(2)").innerText = index + 1;
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
			  <option value="add_new" data-special="1">➕ Add New Service</option>
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

		// 🔥 IMPORTANT: init Select2 AFTER append
		$('.serviceSelect').select2({
			width: '100%'
		});



	});

	$(document).on('select2:select', '.serviceSelect', function(e) {


		const selectedValue = e.params.data.id;
		const select = this; // real <select>
		const row = select.closest('tr');


		// 🔹 If "Add New Service" selected
		if (selectedValue === 'add_new') {

			// Reset selection so row stays clean
			$(select).val('').trigger('change.select2');

			// Save reference to row (important)
			window.activeServiceSelect = select;
			// Open modal
			//$('#serviceModal').removeClass('hidden');
			openServiceModal();

			return; // stop further processing
		}

		// 🔹 Normal service selection



		// 🔥 Selected option element
		const option = e.params.data.element;

		row.querySelector(".serviceCost").value = option.dataset.price || 0;
		row.querySelector(".serviceTime").value = option.dataset.time || 1;

		updateServiceRow(row);
		debounceGrandTotal();


	});


	let activeServiceSelect = null;

	/* Called when "-- New Service --" is selected */
	// function openServiceModal(selectEl) {
	// 	activeServiceSelect = selectEl;
	// 	$('#serviceModal').removeClass('hidden').addClass('flex');
	// }

	function openServiceModal() {
		const modal = document.getElementById('serviceModal');
		modal.classList.remove('hidden');
	}

	function closeServiceModal() {
		const modal = document.getElementById('serviceModal');
		modal.classList.add('hidden');

		$('#new_service_name').val('');
		$('#new_service_type').val('SERVICE');
		$('#new_service_cost').val('');
		$('#new_service_time').val('');
	}

	// function closeServiceModal() {
	// 	// alert("close");
	// 	$('#serviceModal').addClass('hidden').removeClass('flex');

	// 	$('#new_service_name').val('');
	// 	$('#new_service_type').val('SERVICE');
	// 	$('#new_service_cost').val('');
	// 	$('#new_service_time').val('');
	// }


	/* SAVE NEW SERVICE */
	function saveNewService() {

		const serviceName = $('#new_service_name').val().trim();
		const serviceType = $('#new_service_type').val();
		const cost = $('#new_service_cost').val();
		const time = $('#new_service_time').val();

		if (!serviceName) {
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

					const $option = $('<option>', {
						value: service.master_service_id,
						text: service.service_name,
						'data-price': service.estimated_cost,
						'data-time': service.estimated_time
					});

					$('.serviceSelect').append($option);

					if (window.activeServiceSelect) {

						// $(window.activeServiceSelect)
						// 	.val(service.master_service_id)
						// 	.trigger('change.select2');


						const selectEl = window.activeServiceSelect;

						// Set value
						$(selectEl).val(service.master_service_id).trigger('change');

						// 🔥 Manually trigger select2:select
						$(selectEl).trigger({
							type: 'select2:select',
							params: {
								data: {
									id: service.master_service_id,
									text: service.service_name,
									element: $(selectEl)
										.find('option[value="' + service.master_service_id + '"]')[0]
								}
							}
						});


						const row = window.activeServiceSelect.closest('tr');
						updateServiceRow(row);
						debounceGrandTotal();
					}

					closeServiceModal();
					window.activeServiceSelect = null;
				} else {
					alert(res.message);
				}
			},
			error: function() {
				alert('Error saving service');
			}
		});
	}


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

		if (e.target.classList.contains("tdiscount")) {
			alert("gh");
			// const row = e.target.closest("tr");
			// const opt = e.target.selectedOptions[0];
			// alert(opt?.dataset.price);
			// row.querySelector(".serviceCost").value = opt?.dataset.price || 0;
			// row.querySelector(".serviceTime").value = opt?.dataset.time || 1;

			// updateServiceRow(row);
			// debounceGrandTotal();
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
			calculatePartsTotals()
			debounceGrandTotal();
		}
		if (e.target.classList.contains("unitPrice")) {
			const row = e.target.closest("tr");

			const price = parseFloat(e.target.value) || 0;
			row.querySelector(".sellPrice").value = price;

			updatePartRow(row);
			calculatePartsTotals();
			debounceGrandTotal();
		}
		if (e.target.classList.contains("sellPrice")) {
			const row = e.target.closest("tr");

			const price = parseFloat(e.target.value) || 0;
			row.querySelector(".sellPrice").value = price;

			updatePartRow(row);
			calculatePartsTotals();
			debounceGrandTotal();
		}

		if (e.target.classList.contains("partQty")) {
			const row = e.target.closest("tr");


			updatePartRow(row);
			calculatePartsTotals();
			debounceGrandTotal();
		}



		// Auto-fill service values
		if (e.target.classList.contains("serviceSelect")) {
			const row = e.target.closest("tr");
			const opt = e.target.selectedOptions[0];
			alert(opt?.dataset.price);
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

	/* ===============================
	   SERVICE ROW CALCULATION
	================================ */

	/* ===============================
	   DELETE ROWS
	================================ */
	document.addEventListener("click", function(e) {
		if (e.target.classList.contains("remove-row")) {
			e.target.closest("tr").remove();
			renumber("#partsTable");
			renumber("#serviceTable");
			renumber("#jobDescTable");
			calculatePartsTotals();
			calculateGrandTotal();
		}
	});



	/* ===============================
	   GRAND TOTAL
	================================ */



	function calculateGrandTotal() {

		const jobTotal = num(document.getElementById("job_total")?.value);
		const serviceTotalWithVat = num(document.getElementById("service_total_with_vat")?.value);
		const partsTotalWithVat = num(document.getElementById("parts_total_with_vat")?.value);
		const afterpartsTotalWithVat = num(document.getElementById("afterparts_total_with_vat")?.value);
		const usedpartsTotalWithVat = num(document.getElementById("usedparts_total_with_vat")?.value);

		const subtotal = jobTotal + serviceTotalWithVat + partsTotalWithVat + afterpartsTotalWithVat + usedpartsTotalWithVat;

		const taxPercent = num(document.getElementById("tax_percent")?.value);
		const discount = num(document.getElementById("tdiscount")?.value);

		const taxableamt = subtotal - discount;

		const taxAmount = taxableamt * taxPercent / 100;
		const grandTotal = taxAmount + taxableamt;
		// const taxAmount = subtotal * taxPercent / 100;
		// const grandTotal = subtotal + taxAmount - discount;

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
		calculatePartsTotals();
		debounceGrandTotal();
	}



	function calculateJobTotals() {

		let subtotal = 0;
		document.querySelectorAll("#jobDescTable .jobAmount").forEach(el => {
			subtotal += num(el.value);
		});

		const vat = subtotal * 0.05;

		document.getElementById("job_subtotal").value = subtotal.toFixed(2);
		document.getElementById("job_taxable").value = subtotal.toFixed(2);
		document.getElementById("job_vat").value = vat.toFixed(2);
		document.getElementById("job_total").value = (subtotal + vat).toFixed(2);
	}
	// ============================== service total calculations===========================

	// function calculateServiceTotals() {

	// 	let subtotal = 0;
	// 	document.querySelectorAll("#serviceTable .totalCost").forEach(el => {
	// 		subtotal += num(el.value);
	// 	});

	// 	const vat = subtotal * 0.05;

	// 	document.getElementById("service_total").value = subtotal.toFixed(2);
	// 	document.getElementById("service_taxable_amt").value = subtotal.toFixed(2);
	// 	document.getElementById("service_vat").value = vat.toFixed(2);
	// 	document.getElementById("service_total_with_vat").value = (subtotal + vat).toFixed(2);
	// }
	function calculateServiceTotals() {

		let serviceSubtotal = 0;

		document.querySelectorAll("#serviceTable .totalCost").forEach(el => {
			serviceSubtotal += num(el.value);
		});
		const distotal = document.getElementById("service_discount").value;
		const taxablevalue = serviceSubtotal - distotal;
		const vat = taxablevalue * 0.05;

		const totalWithVat = taxablevalue + vat;
		// const vat = serviceSubtotal * 0.05;

		// const totalWithVat = serviceSubtotal + vat;

		document.getElementById("service_total").value = serviceSubtotal.toFixed(2);
		document.getElementById("service_taxable_amt").value = taxablevalue.toFixed(2);

		document.getElementById("service_vat").value = vat.toFixed(2);
		document.getElementById("service_total_with_vat").value = totalWithVat.toFixed(2);
	}

	// function calculateServiceTotals() {

	// 	let subtotal = 0;
	// 	document.querySelectorAll("#serviceTable .totalCost").forEach(el => {
	// 		subtotal += num(el.value);
	// 	});

	// 	const vat = subtotal * 0.05;

	// 	document.getElementById("service_total").value = subtotal.toFixed(2);
	// 	document.getElementById("service_vat").value = vat.toFixed(2);
	// 	document.getElementById("service_total_with_vat").value = (subtotal + vat).toFixed(2);
	// }

	// ============================== service total calculations===========================
	function updateServiceRow(row) {
		const time = num(row.querySelector(".serviceTime")?.value);
		const cost = num(row.querySelector(".serviceCost")?.value);

		row.querySelector(".totalCost").value = (time * cost).toFixed(2);

		calculateServiceTotals();
	}

	// function calculatePartsTableTotal(tableId) {
	// 	let total = 0;

	// 	document.querySelectorAll(`#${tableId} .rowTotal`).forEach(el => {
	// 		total += num(el.value);
	// 	});

	// 	document
	// 		.querySelector(`.tablePartTotal[data-table="${tableId}"]`)
	// 		.value = total.toFixed(2);
	// }

	function updatePartRow(row) {
		const qty = num(row.querySelector(".partQty")?.value);
		const unit = num(row.querySelector(".unitPrice")?.value);
		const sell = num(row.querySelector(".sellPrice")?.value);
		const disc = num(row.querySelector(".discountamt")?.value);

		const price = sell > 0 ? sell : unit;
		let total = (qty * price) - disc;
		if (total < 0) total = 0;

		row.querySelector(".rowTotal").value = total.toFixed(2);

		// const tableId = row.closest("table").id;
		// calculatePartsTableTotal(tableId);


	}


	document.addEventListener("DOMContentLoaded", function() {


	 const discountInput = document.getElementById("service_discount");

    if (discountInput) {
        discountInput.addEventListener("input", function () {
            calculateServiceTotals();
			calculateGrandTotal();
        });
    }

		// Job totals
		calculateJobTotals();

		// Service totals
		calculateServiceTotals();

		// Parts totals (all tables)
		// ["newPartsTable", "aftermarketPartsTable", "usedPartsTable"]
		// .forEach(tid => {
		// 	if (document.getElementById(tid)) {
		// 		calculatePartsTableTotal(tid);
		// 	}
		// });

		// Grand total
		calculateGrandTotal();


	});






	function calculatesubletServiceTotals() {

		let serviceSubtotal = 0;

		document.querySelectorAll("#jobDescTable .totalCost").forEach(el => {
			serviceSubtotal += num(el.value);
		});

		const vat = serviceSubtotal * 0.05;
		const totalWithVat = serviceSubtotal + vat;

		document.getElementById("subletservice_total").value = serviceSubtotal.toFixed(2);
		document.getElementById("subletservice_vat").value = vat.toFixed(2);
		document.getElementById("subletservice_total_with_vat").value = totalWithVat.toFixed(2);
	}


	function calculatePartsTotals() {

		let subTotal = 0;
		let discountTotal = 0;

		// alert("DSF");

		document.querySelectorAll("#newPartsTable tbody tr").forEach(row => {

			const qty = num(row.querySelector(".partQty")?.value || 1);
			const sell = num(row.querySelector(".sellPrice")?.value);
			const disc = num(row.querySelector(".discountamt")?.value);

			subTotal += qty * sell;
			discountTotal += disc;
		});

		const taxable = subTotal - discountTotal;
		const vat = taxable * 0.05;
		const totalWithVat = taxable + vat;

		// alert(taxable);alert(vat);alert(totalWithVat);

		document.getElementById("parts_subtotal").value = subTotal.toFixed(2);
		document.getElementById("parts_discount_total").value = discountTotal.toFixed(2);
		document.getElementById("parts_taxable").value = taxable.toFixed(2);
		document.getElementById("parts_vat").value = vat.toFixed(2);
		document.getElementById("parts_total_with_vat").value = totalWithVat.toFixed(2);

		let subTotal1 = 0;
		let discountTotal1 = 0;

		document.querySelectorAll("#aftermarketPartsTable tbody tr").forEach(row => {

			const qty = num(row.querySelector(".partQty")?.value || 1);
			const sell = num(row.querySelector(".sellPrice")?.value);
			const disc = num(row.querySelector(".discountamt")?.value);

			subTotal1 += qty * sell;
			discountTotal1 += disc;
		});

		const taxable1 = subTotal1 - discountTotal1;
		const vat1 = taxable1 * 0.05;
		const totalWithVat1 = taxable1 + vat1;

		// alert(taxable1);alert(vat1);alert(totalWithVat1);

		document.getElementById("afterparts_subtotal").value = subTotal1.toFixed(2);
		document.getElementById("afterparts_discount_total").value = discountTotal1.toFixed(2);
		document.getElementById("afterparts_taxable").value = taxable1.toFixed(2);
		document.getElementById("afterparts_vat").value = vat1.toFixed(2);
		document.getElementById("afterparts_total_with_vat").value = totalWithVat1.toFixed(2);

		let subTotal2 = 0;
		let discountTotal2 = 0;

		document.querySelectorAll("#usedPartsTable tbody tr").forEach(row => {

			const qty = num(row.querySelector(".partQty")?.value || 1);
			const sell = num(row.querySelector(".sellPrice")?.value);
			const disc = num(row.querySelector(".discountamt")?.value);

			subTotal2 += qty * sell;
			discountTotal2 += disc;
		});

		const taxable2 = subTotal2 - discountTotal2;
		const vat2 = taxable2 * 0.05;
		const totalWithVat2 = taxable2 + vat2;

		// alert(taxable2);alert(vat2);alert(totalWithVat2);

		document.getElementById("usedparts_subtotal").value = subTotal2.toFixed(2);
		document.getElementById("usedparts_discount_total").value = discountTotal2.toFixed(2);
		document.getElementById("usedparts_taxable").value = taxable2.toFixed(2);
		document.getElementById("usedparts_vat").value = vat2.toFixed(2);
		document.getElementById("usedparts_total_with_vat").value = totalWithVat2.toFixed(2);
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


	function calculateJobTotals() {

		let subtotal = 0;
		document.querySelectorAll("#jobDescTable .jobAmount").forEach(el => {
			subtotal += num(el.value);
		});

		const vat = subtotal * 0.05;

		document.getElementById("job_subtotal").value = subtotal.toFixed(2);
		document.getElementById("job_taxable").value = subtotal.toFixed(2);
		document.getElementById("job_vat").value = vat.toFixed(2);
		document.getElementById("job_total").value = (subtotal + vat).toFixed(2);
	}
	// ==============================================


	$('.serviceSelect').select2({
		width: '100%'
	});

	function serviceOptionTemplate(option) {

		if (!option.id) return option.text;

		// Highlight "Add New Service"
		if ($(option.element).data('special')) {
			return $(
				`<span class="text-green-600 font-semibold">
                ➕ ${option.text}
            </span>`
			);
		}

		return option.text;
	}


	$('.partSelect').select2({
		width: '100%'
	});

	// $(document).on('select2:select', '.partSelect', function(e) {

	// 	if (e.params.data.id.startsWith('add_')) {
	// 		$(this).data('addtype', e.params.data.element.dataset.addtype);
	// 		$(this).val(null).trigger('change');
	// 		openAddPartModal(this);
	// 		return;
	// 	}

	// 	const row = this.closest("tr");

	// 	// ✅ ALWAYS read from Select2 event
	// 	const optionEl = e.params.data.element;
	// 	const price = optionEl?.dataset.price || 0;

	// 	row.querySelector(".unitPrice").value = price;
	// 	row.querySelector(".sellPrice").value = price;

	// 	updatePartRow(row);
	// 	calculatePartsTotals();
	// 	debounceGrandTotal();
	// });

	$(document).on('select2:select', '.partSelect', function(e) {

		const selectedId = e.params.data.id;
		const selectedText = e.params.data.text || '';
		const currentSelect = this;

		// =================================================
		// 1️⃣ ADD NEW PART OPTION (existing logic)
		// =================================================
		if (selectedId.startsWith('add_')) {
			$(this).data('addtype', e.params.data.element.dataset.addtype);
			$(this).val(null).trigger('change');
			openAddPartModal(this);
			return;
		}

		// =================================================
		// 2️⃣ DUPLICATE PREVENTION (ALLOW CONSUMABLES)
		// =================================================
		const isConsumable = selectedText.toLowerCase().includes('consumable');

		if (!isConsumable) {

			const table = $(this).closest('table');
			let duplicateFound = false;

			table.find('.partSelect').not(currentSelect).each(function() {
				if ($(this).val() === selectedId) {
					duplicateFound = true;
					return false; // break loop
				}
			});

			if (duplicateFound) {
				alert('This part is already added. You can change the quantity instead.');

				// reset selection
				$(currentSelect).val(null).trigger('change');

				// reset row values
				const row = currentSelect.closest("tr");
				row.querySelector(".unitPrice").value = 0;
				row.querySelector(".sellPrice").value = 0;
				row.querySelector(".totalPrice").value = 0;

				return;
			}
		}

		// =================================================
		// 3️⃣ PRICE SETTING (existing logic)
		// =================================================
		const row = currentSelect.closest("tr");

		const optionEl = e.params.data.element;
		const price = optionEl?.dataset.price || 0;

		row.querySelector(".unitPrice").value = price;
		row.querySelector(".sellPrice").value = price;

		updatePartRow(row);
		calculatePartsTotals();
		debounceGrandTotal();
	});



	$(document).on('select2:clear', '.partSelect', function() {

		const row = this.closest("tr");

		row.querySelector(".unitPrice").value = 0;
		row.querySelector(".sellPrice").value = 0;

		updatePartRow(row);
		calculatePartsTotals();
		debounceGrandTotal();
	});



	// =============================================================


	function saveNewPart(partType) {

		const partName = $('#new_part_name').val().trim();
		const unitPrice = $('#new_part_price').val();

		if (partName === '') {
			alert('Part name required');
			return;
		}

		$.ajax({
			url: "<?= base_url('index.php/Spare_parts/save_ajax') ?>",
			type: "POST",
			dataType: "json",
			data: {
				part_name: partName,
				unit_price: unitPrice,
				part_type: partType
			},
			success: function(res) {

				if (res.status === 'success') {

					const part = res.part;

					// 🔥 Add option dynamically
					const option = new Option(
						part.part_name,
						part.part_id,
						true,
						true
					);

					option.dataset.price = part.unit_price;

					// add ONLY to current select
					$(activePartSelect)
						.append(option)
						.trigger('change.select2');

					// 🎯 highlight effect
					highlightSelect2Option(activePartSelect, part.part_id);

					closeAddPartModal();

				} else {
					alert(res.message);
				}
			}
		});
	}
	let activePartSelect = null;

	$(document).on('focus', '.partSelect', function() {
		activePartSelect = this;
	});

	function highlightSelect2Option(selectEl, value) {

		setTimeout(() => {
			const $container = $(selectEl)
				.next('.select2-container')
				.find('.select2-selection');

			$container.addClass('ring-2 ring-green-500');

			setTimeout(() => {
				$container.removeClass('ring-2 ring-green-500');
			}, 1200);
		}, 200);
	}
	// ===================================
	function openAddPartModal(selectEl) {

		activePartSelect = selectEl;

		const selectedVal = $(selectEl).data('addtype');

		let partType = '';
		let title = 'Add New Part';

		if (selectedVal === 'new') {
			partType = 'New Parts';
			title = 'Add New Part';
		}
		if (selectedVal === 'after') {
			partType = 'Aftermarket Parts';
			title = 'Add Aftermarket Part';
		}
		if (selectedVal === 'used') {
			partType = 'Used Parts';
			title = 'Add Used Part';
		}

		$('#addPartModalTitle').text(title);
		$('#new_part_type').val(partType);

		$('#new_part_name').val('');
		$('#new_part_price').val('');

		$('#addPartModal').removeClass('hidden');
	}

	function closeAddPartModal() {
		$('#addPartModal').addClass('hidden');
	}

	function submitAddPart() {

		const partName = $('#new_part_name').val().trim();
		const unitPrice = $('#new_part_price').val();
		const partType = $('#new_part_type').val();
		const labeling = $('#labeling').is(':checked') ? 1 : 0; // ✅ added


		if (partName === '') {
			alert('Part name is required');
			return;
		}

		$.ajax({
			url: "<?= base_url('index.php/SpareParts/save_ajax') ?>",
			type: "POST",
			dataType: "json",
			data: {
				part_name: partName,
				unit_price: unitPrice,
				part_type: partType,
				labeling: labeling
			},
			success: function(res) {

				if (res.status === 'success') {

					const part = res.part;

					const option = new Option(
						part.part_name,
						part.part_id,
						true,
						true
					);

					option.dataset.price = part.unit_price;

					$(activePartSelect).append(option).val(part.part_id).trigger('change');

					// 🔥 Manually trigger select2 event with element reference
					$(activePartSelect).trigger({
						type: 'select2:select',
						params: {
							data: {
								id: part.part_id,
								text: part.part_name,
								element: option
							}
						}
					});


					highlightSelect2Option(activePartSelect, part.part_id);

					closeAddPartModal();

				} else {
					alert(res.message);
				}
			}
		});
	}
</script>
<script>
	function calculateCostSummary() {
		let subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
		let taxPercent = parseFloat(document.getElementById('tax_percent').value) || 0;
		let discount = parseFloat(document.getElementById('tdiscount').value) || 0;

		// Prevent discount > subtotal
		if (discount > subtotal) {
			discount = subtotal;
			document.getElementById('tdiscount').value = subtotal.toFixed(2);
		}

		let taxableAmount = subtotal - discount;
		let taxAmount = (taxableAmount * taxPercent) / 100;
		let grandTotal = taxableAmount + taxAmount;

		document.getElementById('tax_amount').value = taxAmount.toFixed(2);
		document.getElementById('grand_total').value = grandTotal.toFixed(2);
	}

	// Auto calculate on input change
	document.getElementById('tax_percent').addEventListener('input', calculateCostSummary);
	document.getElementById('tdiscount').addEventListener('input', calculateCostSummary);

	// Run once on page load
	window.addEventListener('load', calculateCostSummary);
</script>
