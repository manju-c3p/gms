<style>
	.page-header {
		display: flex;
		justify-content: space-between;
		/* left & right */
		align-items: center;
		margin-bottom: 24px;
	}

	.page-title {
		font-size: 24px;
		font-weight: 700;
		margin: 0;
	}
</style>
<!-- <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow"> -->
<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<div class="page-header">
		<h2 class="page-title">Add Appointment</h2>

		
	</div>


	<form method="POST" action="<?= base_url('index.php/appointment/save'); ?>">

		<div class="grid grid-cols-2 gap-4">





			<!-- Customer -->
			<div class="col-span-2">
				<label class="font-medium">Customer</label>
				<select name="customer_id" id="customerSelect"
					class="w-full border p-2 rounded" required>
					<option value="">-- Select Customer --</option>

					<?php foreach ($customers as $c): ?>
						<option value="<?= $c->customer_id ?>">
							<?= $c->name ?> (<?= $c->phone ?>)
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Vehicle -->
			<div class="col-span-2">
				<label class="font-medium">Vehicle</label>
				<select name="vehicle_id" id="vehicleSelect"
					class="w-full border p-2 rounded" required>
					<option value="">-- Select Vehicle -- Reg No (Brand , Model, Chassis No, Engine No)</option>
				</select>
			</div>

			<!-- Appointment Date -->
			<div>
				<label class="font-medium">Appointment Date</label>
				<input type="date" name="appointment_date" value="<?= $today_date ?>"
					class="w-full border p-2 rounded" required>
			</div>

			<!-- Time -->
			<div>
				<label class="font-medium">Time</label>
				<input type="time" name="appointment_time"  value="<?= $current_time ?>"
					class="w-full border p-2 rounded" required>
			</div>

			<!-- Type -->
			<div class="col-span-2">
				<label class="font-medium">Appointment Type</label>
				<select name="appointment_type"
					class="w-full border p-2 rounded" required>
					<option value="General Service">General Service</option>
					<option value="Repair">Repair</option>
					<option value="Inspection">Inspection</option>
					<option value="Custom">Custom</option>
				</select>
			</div>

			<!-- Notes -->
			<div class="col-span-2">
				<label class="font-medium">Notes (Optional)</label>
				<textarea name="notes" rows="3"
					class="w-full border p-2 rounded"
					placeholder="Describe the issue or request..."></textarea>
			</div>

		</div>

		<div class="mt-6 flex justify-end gap-3">
			<a href="<?= base_url('index.php/appointment'); ?>"
				class="px-4 py-2 bg-gray-300 rounded">Cancel</a>

			<button class="px-6 py-2 bg-blue-600 text-white rounded">
				Save Appointment
			</button>
		</div>

	</form>
</div>




<script>
	$(document).ready(function() {
		$('#customerSelect').select2({
			placeholder: 'Select Customer',
			allowClear: true,
			width: '100%'
		});
		$('#vehicleSelect').select2({
			placeholder: '-- Select Vehicle -- Reg No (Brand , Model, Chassis No, Engine No)',
			allowClear: true,
			width: '100%'
		});

		// <!-- 🔄 Auto-load vehicles based on selected customer -->

		$('#customerSelect').on('change', function() {

			let cid = $(this).val();
			// alert(cid);

			if (!cid) {
				$('#vehicleSelect')
					.html('<option value="">-- Select Vehicle -- Reg No (Brand , Model, Chassis No, Engine No)</option>')
					.trigger('change');
				return;
			}

			fetch("<?= base_url('index.php/appointment/getVehiclesByCustomer/'); ?>" + cid)
				.then(res => res.json())
				.then(data => {

					let html = '<option value="">-- Select Vehicle -- Reg No (Brand , Model, Chassis No, Engine No)</option>';

					data.forEach(v => {
						html += `<option value="${v.vehicle_id}">
                        ${v.registration_no} (${v.brand}, ${v.model}, ${v.chassis_no}, ${v.engine_no})
                    </option>`;
					});

					$('#vehicleSelect')
						.html(html)
						.trigger('change'); // VERY IMPORTANT
				});
		});

	});
</script>
