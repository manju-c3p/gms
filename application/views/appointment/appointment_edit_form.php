<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<h2 class="text-2xl font-bold mb-5">Edit Appointment</h2>

	<form method="POST" onsubmit="return confirm('Are you sure you want to update this appointment?')" action="<?= base_url('index.php/appointment/update'); ?>">

		<input type="hidden" name="appointment_id" value="<?= $appointment->appointment_id ?>">

		<div class="grid grid-cols-2 gap-4">

			<!-- Customer -->
			<div>
				<label class="font-medium">Customer</label>
				<select name="customer_id" class="w-full border p-2 rounded edit-field" disabled>
					<option value="">Select Customer</option>
					<?php foreach ($customers as $c): ?>
						<option value="<?= $c->customer_id ?>"
							<?= $appointment->customer_id == $c->customer_id ? "selected" : "" ?>>
							<?= $c->name ?> (<?= $c->phone ?>)
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Vehicle -->
			<div>
				<label class="font-medium">Vehicle</label>
				<select name="vehicle_id" class="w-full border p-2 rounded edit-field" disabled>
					<option value="">Select Vehicle</option>
					<?php foreach ($vehicles as $v): ?>
						<option value="<?= $v->vehicle_id ?>"
							<?= $appointment->vehicle_id == $v->vehicle_id ? "selected" : "" ?>>
							<?= $v->registration_no ?> - <?= $v->brand ?> <?= $v->model ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Appointment Date -->
			<div>
				<label class="font-medium">Appointment Date</label>
				<input type="date" name="appointment_date"
					value="<?= $appointment->appointment_date ?>"
					class="w-full border p-2 rounded edit-field" disabled>
			</div>

			<!-- Appointment Time -->
			<div>
				<label class="font-medium">Appointment Time</label>
				<input type="time" name="appointment_time"
					value="<?= $appointment->appointment_time ?>"
					class="w-full border p-2 rounded edit-field" disabled>
			</div>

			<!-- Service Type -->
			<div class="col-span-2">
				<label class="font-medium">Service Type</label>
				<input type="text" name="service_type"
					value="<?= $appointment->service_type ?>"
					class="w-full border p-2 rounded edit-field" disabled
					placeholder="Eg: General Service, Oil Change, AC Check">
			</div>

			<!-- Notes -->
			<div class="col-span-2">
				<label class="font-medium">Notes</label>
				<textarea name="notes" class="w-full border p-2 rounded edit-field" disabled
					placeholder="Additional notes..."><?= $appointment->notes ?></textarea>
			</div>

			<!-- Status -->
			<div class="col-span-2" style="display:none">
				<label class="font-medium">Status</label>
				<select name="status" class="w-full border p-2 rounded edit-field" disabled>

					<option value="Confirmed" selected>Confirmed</option>


				</select>
			</div>

		</div>

		<br>

		<button type="button"
			id="editBtn"
			class="px-6 py-2 bg-blue-600 text-white rounded">
			Edit Appointment
		</button>

		<button type="submit"
			id="updateBtn"
			class="px-6 py-2 bg-green-600 text-white rounded hidden">
			Update Appointment
		</button>

		<button type="button"
			id="cancelEditBtn"
			class="px-6 py-2 bg-gray-500 text-white rounded hidden">
			Cancel Edit
		</button>

		<a href="<?= base_url('index.php/Inspection/create/' . $appointment->appointment_id) ?>" class="px-6 py-2 bg-green-600 text-white rounded">
			Inspection
		</a>
		


		<a href="<?= base_url('index.php/appointment'); ?>"
			class="ml-3 px-6 py-2 bg-gray-300 rounded">Cancel</a>

	</form>

</div>

<script>

const editBtn = document.getElementById("editBtn");
const updateBtn = document.getElementById("updateBtn");
const cancelEditBtn = document.getElementById("cancelEditBtn");

const fields = document.querySelectorAll(".edit-field");


// Enable edit mode
editBtn.addEventListener("click", function(){

	fields.forEach(field => field.disabled = false);

	editBtn.classList.add("hidden");
	updateBtn.classList.remove("hidden");
	cancelEditBtn.classList.remove("hidden");

});


// Cancel edit mode
cancelEditBtn.addEventListener("click", function(){

	fields.forEach(field => field.disabled = true);

	editBtn.classList.remove("hidden");
	updateBtn.classList.add("hidden");
	cancelEditBtn.classList.add("hidden");

});

</script>
