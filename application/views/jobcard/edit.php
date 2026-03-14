<div class="w-full bg-white rounded-2xl shadow-md p-6">




	<form method="post" action="<?= base_url('index.php/Jobcard/updatejobcard'); ?>" class="p-6 bg-white">
		<input type="hidden" name="jobcard_id" value="<?= $jobcard_id ?>">


		<div class="page-header flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">

			<!-- Title -->
			<h2 class="text-xl font-bold text-center lg:text-left">
				Job Card edit
			</h2>

			<!-- Action Buttons -->
			<div class="flex flex-col sm:flex-row sm:flex-wrap gap-2 justify-center lg:justify-end">

				<button type="submit"
					class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded">
					Save Job Card
				</button>

				<a href="<?= base_url('index.php/Jobcard/view/' . $jobcard_id); ?>"
					class="w-full sm:w-auto text-center px-6 py-2 bg-gray-300 rounded">
					View
				</a>
				<?php if ($jobcardstatus == "Scheduled") { ?>
					<a href="<?= base_url('index.php/Invoice/generate'); ?>"
						class="w-full sm:w-auto text-center px-6 py-2 bg-gray-300 rounded">
						Invoice
					</a>
				<?php } ?>

				<?php if ($jobcardstatus == "Scheduled") { ?>
					<a href="<?= base_url('index.php/MaterialIssue/create/' . $jobcard_id) ?>"
						class="w-full sm:w-auto text-center px-4 py-2 bg-indigo-600 text-white rounded">
						Spareparts Issue
					</a>
				<?php } ?>

				<a href="<?= base_url('index.php/Appointment'); ?>"
					class="w-full sm:w-auto text-center px-6 py-2 bg-gray-300 rounded">
					Cancel
				</a>

			</div>
		</div>

		<hr class="border-gray-300 mb-6">
		<!-- CUSTOMER / VEHICLE INFO -->
		<!-- VEHICLE & CUSTOMER DETAILS -->


		<div class="bg-white rounded-2xl shadow-md mb-6 overflow-hidden">

			<!-- Header -->
			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Vehicle & Customer Details
			</div>

			<!-- Table -->
			<div class="overflow-x-auto">
				<table class="w-full text-sm border-collapse min-w-[900px]">

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
									value="<?= $appointment->customer_name ?? $customer->name ?>" readonly>
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
									value="<?= $appointment->phone ?? $customer->phone ?>" readonly>
							</td>
						</tr>

						<!-- ROW 3 -->
						<tr class="border-b">
							<td class="px-3 py-1  font-medium bg-gray-50">Vehicle Model</td>
							<td class="px-3 py-1 ">
								<input type="text"
									class="w-full border rounded px-2 py-1 bg-gray-100"
									value="<?= $appointment->model ?? $vehicle->model ?>" readonly>
							</td>

							<td class="px-3 py-1  font-medium bg-gray-50">Email</td>
							<td class="px-3 py-1 ">
								<input type="email"
									class="w-full border rounded px-2 py-1 bg-gray-100"
									value="<?= $appointment->email ?? $customer->email ?>" readonly>
							</td>

							<td class="px-3 py-1  font-medium bg-gray-50">Registration No</td>
							<td class="px-3 py-1 ">
								<input type="text"
									class="w-full border rounded px-2 py-1 bg-gray-100"
									value="<?= $appointment->registration_no ?? $vehicle->registration_no ?>" readonly>
							</td>
						</tr>

						<!-- ROW 4 -->
						<tr class="border-b">
							<td class="px-3 py-1 font-medium bg-gray-50">Vehicle VIN No</td>
							<td class="px-3 py-1 ">
								<input type="text"
									class="w-full border rounded px-2 py-1 bg-gray-100"
									value="<?= $appointment->chassis_no ?? $vehicle->chassis_no  ?>" readonly>
							</td>

							<td class="px-3 py-1  font-medium bg-gray-50">KM's In</td>
							<td class="px-3 py-1 ">
								<input type="number" name="kmin"
									class="w-full border rounded px-2 py-1" value="<?= $kms ?>">
							</td>

							<td class="px-3 py-1  font-medium bg-gray-50">Estimated Delivery Date</td>
							<td class="px-3 py-1 ">
								<input type="date" name="estdate" value="<?= $estimation->est_delivery_date ?>"
									class="w-full border rounded px-2 py-1">
							</td>
						</tr>

						<!-- ROW 5 -->
						<tr>
							<td class="px-3 py-1  font-medium bg-gray-50">Completion Time</td>
							<td class="px-3 py-1 ">
								<input type="time" name="ctime" value="<?= $estimation->est_completion_time ?>"
									class="w-full border rounded px-2 py-1">
							</td>

							<!-- <td class="px-3 py-1  font-medium bg-gray-50">Check List Remark</td>
						<td class="px-3 py-1 ">
							<input type="text"
								class="w-full border rounded px-2 py-1">
						</td> -->

							<td class="px-3 py-1  font-medium bg-gray-50">Remark</td>
							<td class="px-3 py-1 ">
								<textarea name="remarks"
									class="w-full border rounded px-2 py-1 h-16"><?= $estimation->remarks ?></textarea>
							</td>
						</tr>

					</tbody>
				</table>
			</div>
		</div>
		<!-- ============================================== -->

		<div class="bg-white rounded-2xl shadow-md mt-6 overflow-hidden">

			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Services
			</div>

			<div class="p-4">
				<div class="overflow-x-auto">
					<table class="w-full text-sm border-collapse min-w-[900px]" id="serviceTable">

						<thead>
							<tr class="bg-gray-50 border">
								<th class="border px-3 py-2 w-[90px] text-center">Sl No</th>
								<th class="border px-3 py-2">Service</th>
								<th class="border px-3 py-2 text-center">Estimated Time</th>
								<th class="border px-3 py-2 text-center">Estimated Cost</th>
								<th class="border px-3 py-2 text-center">Total Cost</th>
								<th class="border px-3 py-2 text-center">Technician</th>
								<!-- <th class="border px-3 py-2 w-[90px] text-center">Actions</th> -->
							</tr>
						</thead>
						<tbody>
							<?php
							// foreach ($job_descriptions as $i => $s):
							$service_grand_total = 0;
							foreach ($services_used as $i => $s):
								$service_grand_total += (float) $s->total_cost;
							?>
								<tr class="border hover:bg-gray-50">
									<td class="border px-3 py-2 text-center font-medium"><?= $i + 1 ?></td>

									<td class="border px-3 py-2">
										<select name="service_name2242[]"
											class="w-full border rounded px-2 py-1 serviceSelect" disabled>
											<option value="">-- Select 345 --</option>
											<?php foreach ($services_master as $sm): ?>
												<option value="<?= $sm->master_service_id ?>"
													<?= $sm->master_service_id == $s->service_id ? 'selected' : '' ?>>
													<?= $sm->service_name ?>
												</option>
											<?php endforeach; ?>
										</select>

										<!-- Hidden field actually submitted -->
										<input type="hidden" name="service_name[]" value="<?= $s->service_id ?>">
									</td>

									<td class="border px-3 py-2">

										<input name="service_esttime[]" value="<?= $s->estimated_time ?>"
											class="w-full border rounded px-2 py-1 text-center partQty" readonly>
									</td>
									<td class="border px-3 py-2">

										<input name="service_estcost[]" value="<?= $s->estimated_cost ?>"
											class="w-full border rounded px-2 py-1 text-center partQty" readonly>
									</td>



									<td class="border px-3 py-2">

										<input name="service_amt[]" value="<?= $s->total_cost ?>"
											class="w-full border rounded px-2 py-1 text-center partQty" readonly>
									</td>

									<!-- Technician Dropdown -->
									<td class="border px-3 py-2">
										<select name="technician_id[]"
											class="w-full border rounded-lg px-2 py-2 focus:ring-2 focus:ring-blue-300">
											<option value="">-- Select Technician --</option>
											<?php foreach ($technicians as $t): ?>
												<option value="<?= $t->employee_id ?>"
													<?= isset($s->employee_id) && $s->employee_id == $t->employee_id ? 'selected' : '' ?>>
													<?= $t->employee_name ?>
												</option>
											<?php endforeach; ?>

										</select>


									</td>


									<!-- <td class="border px-3 py-2 text-center">
									<button type="button"
										class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
										✕
									</button>
								</td> -->
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr class="bg-gray-100 font-semibold border">
								<td class="border px-3 py-2 text-center" colspan="4">
									Total
								</td>

								<td class="border px-3 py-2 text-center">
									<?= number_format($service_grand_total, 2) ?>
								</td>

								<td class="border px-3 py-2"></td>
							</tr>
						</tfoot>

					</table>
				</div>

				<!-- <button type="button" id="addService"
					class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm">
					+ Add Service
				</button> -->
			</div>
		</div>
		<!-- ============================================  -->
		<div class="bg-white rounded-2xl shadow-md mt-6 overflow-hidden">

			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Spare Parts Used
			</div>

			<div class="overflow-x-auto">
				<table class="w-full text-sm border-collapse min-w-[900px]" id="partsTable">
					<thead>
						<tr class="bg-gray-50 border">
							<th class="border px-3 py-2 w-[50px] text-center">#</th>
							<th class="border px-3 py-2 w-[300px] text-center">Part</th>
							<th class="border px-3 py-2 w-[150px] text-center">Part Type</th>
							<th class="border px-3 py-2 w-[100px] text-center">Qty</th>
							<th class="border px-3 py-2 w-[100px] text-center">Unit Price</th>
							<th class="border px-3 py-2 w-[100px] text-center">Discount Amt</th>
							<th class="border px-3 py-2 w-[100px] text-center">Total Cost</th>
							<!-- <th class="border px-3 py-2 w-[70px] text-center">Action</th> -->
						</tr>
					</thead>
					<tbody>
						<?php
						$parts_grand_total = 0;
						foreach ($parts_used as $i => $p):
							$parts_grand_total += (float) $p->total_price;
						?>
							<tr class="border hover:bg-gray-50">
								<td class="border px-3 py-2 text-center font-medium"><?= $i + 1 ?></td>

								<td class="border px-3 py-2">
									<select name="part_id[]"
										class="w-full border rounded px-2 py-1" disabled>
										<?php foreach ($parts as $part): ?>
											<option value="<?= $part->part_id ?>"
												<?= $part->part_id == $p->part_id ? 'selected' : '' ?>>
												<?= $part->part_name ?>
											</option>
										<?php endforeach; ?>
									</select>
								</td>
								<td class="border px-3 py-2">
									<input name="part_type[]" value="<?= $p->part_type ?>"
										class="w-full border rounded px-2 py-1 text-center parttype" readonly>
								</td>

								<td class="border px-3 py-2">
									<input name="part_qty[]" value="<?= $p->qty ?>"
										class="w-full border rounded px-2 py-1 text-center partQty" readonly>
								</td>
								<td class="border px-3 py-2">
									<input name="part_sellprice[]" value="<?= $p->selling_price ?>"
										class="w-full border rounded px-2 py-1 text-center sellprice" readonly>
								</td>
								<td class="border px-3 py-2">
									<input name="part_disamt[]" value="<?= !empty($p->disamount) ? $p->disamount : '' ?>"

										class="w-full border rounded px-2 py-1 text-center disamt" readonly>
								</td>
								<td class="border px-3 py-2">
									<input name="part_totalprice[]" value="<?= $p->total_price ?>"
										class="w-full border rounded px-2 py-1 text-center totalprice" readonly>
								</td>



								<!-- <td class="border px-3 py-2 text-center">
									<button type="button"
										class="remove-row text-red-600 hover:bg-red-50 px-3 py-1 rounded">
										✕
									</button>
								</td> -->
							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr class="bg-gray-100 font-semibold border">
							<td class="border px-3 py-2 text-center" colspan="6">
								Total Parts Cost
							</td>

							<td class="border px-3 py-2 text-center">
								<?= number_format($parts_grand_total, 2) ?>
							</td>
						</tr>
					</tfoot>

				</table>
			</div>

			<!-- <button type="button" id="addPart"
					class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm">
					+ Add Part
				</button> -->
		</div>
		<!-- ========================================================================== -->
		<div class="bg-white rounded-2xl shadow-md mt-6 overflow-hidden">

			<div class="px-6 py-3 font-semibold text-lg bg-gray-100 border-b">
				Sublet Services
			</div>

			<div class="overflow-x-auto">
				<table class="w-full text-sm border-collapse min-w-[900px]" id="serviceTable">
					<thead>
						<tr class="bg-gray-50 border">
							<th class="border px-3 py-2 w-[90px] text-center">Sl No</th>
							<th class="border px-3 py-2">Description</th>

							<th class="border px-3 py-2 text-center">Amount</th>

						</tr>
					</thead>
					<tbody>
						<?php
						//
						$subletservice_grand_total = 0;
						foreach ($job_descriptions as $i => $s):
							$subletservice_grand_total += (float) $s->amount;
						?>
							<tr class="border hover:bg-gray-50">
								<td class="border px-3 py-2 text-center font-medium"><?= $i + 1 ?></td>

								<td class="border px-3 py-2">
									<input name="sublet[]" value="<?= $s->description ?>"
										class="w-full border rounded px-2 py-1 text-center partQty" readonly>
								</td>



								<td class="border px-3 py-2">

									<input name="jobservice_amt[]" value="<?= $s->amount ?>"
										class="w-full border rounded px-2 py-1 text-center partQty" readonly>
								</td>

							</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr class="bg-gray-100 font-semibold border">
							<td class="border px-3 py-2 text-center" colspan="2">
								Total
							</td>

							<td class="border px-3 py-2 text-center">
								<?= number_format($subletservice_grand_total, 2) ?>
							</td>


						</tr>
					</tfoot>

				</table>
			</div>
			<!-- <button type="button" id="addService"
					class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm">
					+ Add Service
				</button> -->
		</div>





	</form>

</div>
<!-- ========================================= script fncs======================== -->
