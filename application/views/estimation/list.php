<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<div class="bg-white rounded-2xl shadow p-6">

	<div class="flex items-center justify-between mb-4">
		<h2 class="text-2xl font-bold">Estimations</h2>

		<button onclick="openDirectInspectionModal()"
			class="inline-flex items-center gap-2 px-5 py-2.5
               bg-emerald-600 hover:bg-emerald-700
               text-white text-sm font-semibold
               rounded-lg shadow transition">


			<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
				viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M3 5h18M3 10h18M3 15h18M3 20h18" />
			</svg>

			Direct Estimation
		</button>
	</div>

	<div class="overflow-x-auto">
		<table id="estimationTable"
			class="min-w-full border border-gray-200 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th class="border px-3 py-2 text-center">#</th>
					<th class="border px-3 py-2">Estimation No</th>
					<th class="border px-3 py-2">Customer</th>
					<th class="border px-3 py-2">Vehicle</th>
					<th class="border px-3 py-2 text-right">Amount</th>
					<th class="border px-3 py-2 text-center">Status</th>
					<th class="border px-3 py-2 text-center">Quotation</th>
					<th class="border px-3 py-2 text-center">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($estimations)): ?>
					<?php $sl = 1;
					foreach ($estimations as $e): ?>
						<tr class="hover:bg-gray-50">

							<!-- SL -->
							<td class="border px-3 py-2 text-center font-medium">
								<?= $sl++ ?>
							</td>

							<!-- Estimation No -->
							<td class="border px-3 py-2 font-medium">
								<?= $e->estimation_no ?><br>
								<span class="text-xs text-gray-500">
									<?= date('d-m-Y', strtotime($e->estimation_date)) ?>
								</span>
							</td>

							<!-- Customer -->
							<td class="border px-3 py-2">
								<div class="font-medium"><?= $e->customer_name ?></div>
								<div class="text-xs text-gray-500"><?= $e->customer_phone ?></div>
							</td>

							<!-- Vehicle -->
							<td class="border px-3 py-2">
								<div class="font-medium"><?= $e->registration_no ?></div>
								<div class="text-xs text-gray-500">
									<?= $e->brand ?> <?= $e->model ?>
								</div>
							</td>

							<!-- Amount -->
							<td class="border px-3 py-2 text-right">
								₹<?= number_format($e->grand_total, 2) ?>
							</td>

							<!-- Status -->
							<td class="border px-3 py-2 text-center">
								<?php if ($e->status == 'Draft'): ?>
									<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
										Draft
									</span>
								<?php elseif ($e->status == 'Approved'): ?>
									<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
										Approved
									</span>
								<?php elseif ($e->status == 'Rejected'): ?>
									<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
										Rejected
									</span>
								<?php else: ?>
									<span class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-700">
										Converted
									</span>
								<?php endif; ?>
							</td>

							<!-- Job Card -->
							<td class="border px-3 py-2 text-center">
								<?php if ($e->status == 'Approved'): ?>
									<a href="<?= base_url('index.php/Quotation/create_from_estimation/' . $e->estimation_id); ?>"
										class="px-3 py-1 text-xs bg-indigo-600 text-white rounded">
										Create
									</a>
								<?php else: ?>
									<span class="px-3 py-1 text-xs bg-gray-200 text-gray-500 rounded">
										Not Allowed
									</span>
								<?php endif; ?>
							</td>

							<!-- Actions -->
							<td class="border px-3 py-2 text-center space-x-1">
								<a href="<?= base_url('index.php/Estimation/edit/' . $e->estimation_id); ?>"
									class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
									Edit
								</a>

								<a href="<?= base_url('index.php/Estimation/delete/' . $e->estimation_id); ?>"
									onclick="return confirm('Delete this estimation?');"
									class="px-2 py-1 bg-red-100 text-red-700 rounded">
									Delete
								</a>
							</td>

						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<!-- <tr>
                    <td colspan="8"
                        class="border px-3 py-6 text-center text-gray-500">
                        No estimations found
                    </td>
                </tr> -->
				<?php endif; ?>
			</tbody>
		</table>
	</div>



</div>
<!-- ========================================================== -->
<!-- DIRECT INSPECTION MODAL -->
<div id="directInspectionModal"
	class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">

	<div class="bg-white rounded-2xl shadow-xl w-full max-w-xl p-6">

		<h2 class="text-xl font-bold mb-4">Direct Estimation</h2>

			<div class="mb-4">
			<label class="block text-sm font-medium mb-1">
				Vin No
			</label>

			<select id="chassisSelect" class="w-full border rounded-lg px-3 py-2">
				<option value="">-- Select Vin No --</option>
				<option value="new">➕ New Vehicle / Customer</option>

				<?php foreach ($vehicles as $v): ?>
					<option value="<?= $v->chassis_no ?>">
						<?= $v->chassis_no ?>
						(<?= $v->registration_no ?>)
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<!-- CUSTOMER SELECT -->
		<div class="mb-4">
			<label class="block text-sm font-medium mb-1">Customer</label>

			<select id="customerSelect"
				class="w-full border rounded-lg px-3 py-2">
				<option value="">-- Select Customer --</option>
				<?php foreach ($customers as $c): ?>
					<option value="<?= $c->customer_id ?>">
						<?= $c->name ?> (<?= $c->phone ?>)
					</option>
				<?php endforeach; ?>
				<option value="new">➕ Add New Customer</option>
			</select>
		</div>

		<!-- NEW CUSTOMER FORM -->
		<div id="newCustomerForm" class="hidden space-y-3 mb-4">

			<input type="text" id="cust_name"
				placeholder="Customer Name"
				class="w-full border rounded-lg px-3 py-2">

			<input type="text" id="cust_phone"
				placeholder="Mobile"
				class="w-full border rounded-lg px-3 py-2">

			<input type="email" id="cust_email"
				placeholder="Email"
				class="w-full border rounded-lg px-3 py-2">

			<textarea id="cust_address"
				placeholder="Address"
				class="w-full border rounded-lg px-3 py-2"></textarea>
		</div>

		<!-- VEHICLE SECTION -->
		<div id="vehicleSection" class="hidden mb-4">

			<!-- EXISTING VEHICLE DROPDOWN -->
			<div id="existingVehicleDiv" class="hidden mb-3">
				<label class="block text-sm font-medium mb-1">Vehicle</label>

				<select id="vehicleSelect"
					class="w-full border rounded-lg px-3 py-2">
					<option value="">-- Select Vehicle --</option>
				</select>
			</div>

			<!-- NEW VEHICLE FORM -->
			<div id="newVehicleForm" class="hidden space-y-3">

				<input type="text" id="plate_no"
					placeholder="Plate No"
					class="w-full border rounded-lg px-3 py-2">

				<input type="text" id="brand"
					placeholder="Brand"
					class="w-full border rounded-lg px-3 py-2">

				<input type="text" id="model"
					placeholder="Model"
					class="w-full border rounded-lg px-3 py-2">

				<input type="text" id="vin_no"
					placeholder="VIN No"
					class="w-full border rounded-lg px-3 py-2">
			</div>
		</div>

		<!-- ACTION BUTTONS -->
		<div class="flex justify-end gap-3 mt-6">

			<button onclick="closeDirectInspectionModal()"
				class="px-4 py-2 rounded bg-gray-200">
				Cancel
			</button>

			<button onclick="createDirectEstimation()"
				class="px-4 py-2 rounded bg-green-600 text-white">
				Proceed
			</button>
		</div>

	</div>
</div>



<!-- =============================================== -->
<script>
	let fromChassisSelection = false;
	$(document).ready(function () {

    // ✅ assign to variable
    var table = $('#estimationTable').DataTable({
        pageLength: 10,
        language: {
            emptyTable: "No Estimation found"
        },
        order: [[1, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 6, 7] }
        ]
    });

    // ✅ SL auto numbering
    table.on('order.dt search.dt draw.dt', function () {
        let pageInfo = table.page.info();

        table.column(0, { search: 'applied', order: 'applied' })
            .nodes()
            .each(function (cell, i) {
                cell.innerHTML = pageInfo.start + i + 1;
            });
    });

    $('#customerSelect').select2({
        width: '100%'
    });
	$('#chassisSelect').select2({
			width: '100%'
		});
		$('#vehicleSelect').select2({
			width: '100%'
		});

});

</script>

<script>
	const customers = <?= json_encode($customers) ?>;
	const base_url = "<?= base_url(); ?>";

	function openDirectInspectionModal() {
		$('#directInspectionModal').removeClass('hidden');

		let options = `<option value="">-- Select Customer --</option>
                       <option value="new">➕ Add New Customer</option>`;

		customers.forEach(c => {
			options += `<option value="${c.customer_id}">
                ${c.name} (${c.phone})
            </option>`;
		});

		$('#customerSelect').html(options);
	}

	function closeDirectInspectionModal() {
		$('#directInspectionModal').addClass('hidden');

		// Reset all fields
		$('#customerSelect').val('');
		$('#vehicleSelect').html('<option value="">-- Select Vehicle --</option>');

		$('#newCustomerForm').addClass('hidden');
		$('#vehicleSection').addClass('hidden');
		$('#existingVehicleDiv').addClass('hidden');
		$('#newVehicleForm').addClass('hidden');
	}

	/* ===============================
	   CUSTOMER CHANGE
	   =============================== */
	$('#customerSelect').on('change', function() {

	// 🔴 Skip reset if coming from chassis
		if (fromChassisSelection) {
			return;
		}

		const customerId = $(this).val();

		// Reset
		$('#newCustomerForm').addClass('hidden');
		$('#vehicleSection').addClass('hidden');
		$('#existingVehicleDiv').addClass('hidden');
		$('#newVehicleForm').addClass('hidden');

		// ➕ New Customer
		if (customerId === 'new') {
			$('#newCustomerForm').removeClass('hidden');
			$('#vehicleSection').removeClass('hidden');
			$('#newVehicleForm').removeClass('hidden');
			return;
		}

		// Existing Customer
		if (customerId !== '') {
			$('#vehicleSection').removeClass('hidden');
			$('#existingVehicleDiv').removeClass('hidden');

			// Load vehicles
			$.ajax({
				url: base_url + 'index.php/inspection/get_customer_vehicles',
				type: 'POST',
				data: {
					customer_id: customerId
				},
				dataType: 'json',
				success: function(res) {

					let vehicleOptions =
						'<option value="">-- Select Vehicle --</option>';

					if (res.length > 0) {
						res.forEach(v => {
							vehicleOptions += `<option value="${v.vehicle_id}">
                                ${v.registration_no} - ${v.brand} ${v.model}
                            </option>`;
						});
						$('#vehicleSelect').html(vehicleOptions);
					} else {
						// No vehicles → show new vehicle form
						$('#existingVehicleDiv').addClass('hidden');
						$('#newVehicleForm').removeClass('hidden');
					}
				}
			});
		}
	});

	/* ===============================
	   CREATE DIRECT INSPECTION
	   =============================== */
	function createDirectEstimation() {

		const customerId = $('#customerSelect').val();
		const vehicleId = $('#vehicleSelect').val();

		let data = {
			customer_id: customerId,
			vehicle_id: vehicleId,

			// New customer fields
			cust_name: $('#cust_name').val(),
			cust_phone: $('#cust_phone').val(),
			cust_email: $('#cust_email').val(),
			cust_address: $('#cust_address').val(),

			// New vehicle fields
			plate_no: $('#plate_no').val(),
			brand: $('#brand').val(),
			model: $('#model').val(),
			vin_no: $('#vin_no').val()
		};

		$.post(
			base_url + 'index.php/Estimation/create_direct_estimation',
			data,
			function(res) {
				if (res.status === 'success') {
					window.location.href =
						base_url + 'index.php/Estimation/edit/' + res.estimation_id;
				} else {
					alert(res.message);
				}
			},
			'json'
		);
	}

	$('#chassisSelect').on('change', function() {

		const chassis = $(this).val();

		if (!chassis) return;

		if (chassis === 'new') {
			$('#newCustomerForm').removeClass('hidden');
			$('#vehicleSection').removeClass('hidden');
			$('#newVehicleForm').removeClass('hidden');
			return;
		}

		fromChassisSelection = true; // 🔥 SET FLAG

		$.ajax({
			url: base_url + 'index.php/Inspection/get_by_chassis',
			type: 'POST',
			dataType: 'json',
			data: {
				chassis_no: chassis
			},
			success: function(res) {

				if (!res || !res.vehicle_id) {
					alert('Vehicle not found');
					fromChassisSelection = false;
					return;
				}

				// CUSTOMER
				$('#customerSelect')
					.val(res.customer_id)
					.trigger('change.select2');

				// VEHICLE
				const vehicleSelect = $('#vehicleSelect');

				vehicleSelect.empty();

				const option = new Option(
					`${res.registration_no} - ${res.brand} ${res.model}`,
					res.vehicle_id,
					true,
					true
				);

				vehicleSelect.append(option);
				vehicleSelect.val(res.vehicle_id).trigger('change');

				$('#vehicleSection').removeClass('hidden');
				$('#existingVehicleDiv').removeClass('hidden');

				fromChassisSelection = false; // 🔥 RESET FLAG
			}
		});
	});
</script>
