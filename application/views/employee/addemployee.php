<div class="bg-white rounded-xl shadow p-6">

	 <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Add Employee</h2>

        <a href="<?= base_url('index.php/employee') ?>"
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Employee List
        </a>
    </div>

	<form method="post"
		action="<?= base_url('index.php/employee/save') ?>"
		enctype="multipart/form-data">

		<!-- BASIC DETAILS -->
		<h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">Basic Details</h3>

		<div class="grid grid-cols-3 gap-4">

			<!-- Employee Name -->
			<div>
				<label>Employee Name *</label>
				<input type="text" name="employee_name" required
					class="w-full border p-2 rounded">
			</div>

			<!-- Mobile -->
			<div>
				<label>Mobile</label>
				<input type="text" name="mobile"
					class="w-full border p-2 rounded">
			</div>

			<!-- Email -->
			<div>
				<label>Email ID</label>
				<input type="email" name="email"
					class="w-full border p-2 rounded">
			</div>

			<!-- Joining Date -->
			<div>
				<label>Joining Date</label>
				<input type="date" name="joining_date"
					class="w-full border p-2 rounded">
			</div>

			<!-- Address -->
			<div>
				<label>Address</label>
				<textarea name="address" rows="2"
					class="w-full border p-2 rounded"></textarea>
			</div>

			<!-- Department -->
			<div>
				<label>Department *</label>
				<select name="department_id" id="deptSelect"
					class="w-full border p-2 rounded" required>
					<option value="">-- Select Department --</option>
					<?php foreach ($departments as $d): ?>
						<option value="<?= $d->department_id ?>">
							<?= $d->department_name ?>
						</option>
					<?php endforeach; ?>
					<option value="add_dept">+ Add Department</option>
				</select>
			</div>

			<!-- Designation -->
			<div>
				<label>Designation *</label>
				<select name="designation_id" id="desigSelect"
					class="w-full border p-2 rounded" required>
					<option value="">-- Select Designation --</option>
					<option value="add_desig">+ Add Designation</option>
				</select>
			</div>

			<!-- Role -->
			<div>
				<label>Role</label>
				<select name="role" class="w-full border p-2 rounded">
					<option value="Technician">Technician</option>
					<option value="Advisor">Advisor</option>
					<option value="Admin">Admin</option>
				</select>
			</div>
			<div>
				<label>Software Access</label>
				<select name="software_access" class="w-full border p-2 rounded">
					<option value="No">No</option>
					<option value="Yes">Yes</option>
				</select>
			</div>

		</div>


		<!-- PASSPORT DETAILS -->
		<h3 class="font-semibold text-gray-700 mt-6 mb-2 border-b pb-1">
			Passport Details
		</h3>

		<div class="grid grid-cols-3 gap-4">

			<!-- Passport Number -->
			<div>
				<label>Passport Number</label>
				<input type="text" name="passport_number"
					class="w-full border p-2 rounded">
			</div>

			<!-- Passport Issue Date -->
			<div>
				<label>Passport Issue Date</label>
				<input type="date" name="passport_issue_date"
					class="w-full border p-2 rounded">
			</div>

			<!-- Passport Expiry Date -->
			<div>
				<label>Passport Expiry Date</label>
				<input type="date" name="passport_expiry_date"
					class="w-full border p-2 rounded">
			</div>

			<!-- Passport Keeping Location -->
			<div>
				<label>Passport Keeping Location</label>
				<select name="passport_location"
					class="w-full border p-2 rounded">
					<option value="">Select</option>
					<option value="Employee">Employee</option>
					<option value="Office">Office</option>
					<option value="HR">HR Department</option>
				</select>
			</div>

			<!-- Expiry Reminder -->
			<div>
				<label>Passport Expiry Reminder</label>
				<select name="passport_expiry_reminder"
					class="w-full border p-2 rounded">
					<option value="">Select</option>
					<option value="1_month">1 Month Before</option>
					<option value="3_months">3 Months Before</option>
					<option value="6_months">6 Months Before</option>
				</select>
			</div>

			<!-- Upload Passport -->
			<div>
				<label>Upload Passport Copy</label>
				<input type="file" name="passport_file"
					class="w-full border p-2 rounded" accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">
			</div>

		</div>


		<!-- SAVE BUTTON -->
		<div class="mt-6 flex gap-3">

			<!-- Save Button -->
			<button type="submit"
				class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
				Save Employee
			</button>

			<!-- Cancel Button -->
			<a href="<?= base_url('index.php/employee') ?>"
				class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
				Cancel
			</a>

		</div>

	</form>
</div>
<!-- 
<div id="deptModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center">
	<div class="bg-white p-6 rounded w-96">
		<h3 class="font-bold mb-3">Add Department</h3>
		<input type="text" id="newDept" class="w-full border p-2 mb-4">
		<button onclick="saveDept()" class="bg-blue-600 text-white px-4 py-2 rounded">
			Save
		</button>
	</div>
</div> -->
<div id="deptModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center">
	<div class="bg-white p-6 rounded w-96">
		<h3 class="font-bold mb-3">Add Department</h3>

		<input type="text" id="newDept" class="w-full border p-2 mb-4">

		<div class="flex justify-end gap-2">
			<button onclick="closeDeptModal()" 
				class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
				Cancel
			</button>

			<button onclick="saveDept()" 
				class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
				Save
			</button>
		</div>
	</div>
</div>

<script>
	function closeDeptModal() {
		document.getElementById('deptModal').classList.add('hidden');
	}
</script>

<!-- <div id="desigModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center">
	<div class="bg-white p-6 rounded w-96">
		<h3 class="font-bold mb-3">Add Designation</h3>

		<select id="desigDept" class="w-full border p-2 mb-3">
			<?php foreach ($departments as $d): ?>
				<option value="<?= $d->department_id ?>">
					<?= $d->department_name ?>
				</option>
			<?php endforeach; ?>
		</select>

		<input type="text" id="newDesig" class="w-full border p-2 mb-4">

		<button onclick="saveDesig()" class="bg-blue-600 text-white px-4 py-2 rounded">
			Save
		</button>
	</div>
</div> -->

<div id="desigModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center">
	<div class="bg-white p-6 rounded w-96">
		<h3 class="font-bold mb-3">Add Designation</h3>

		<select id="desigDept" class="w-full border p-2 mb-3">
			<?php foreach ($departments as $d): ?>
				<option value="<?= $d->department_id ?>">
					<?= $d->department_name ?>
				</option>
			<?php endforeach; ?>
		</select>

		<input type="text" id="newDesig" class="w-full border p-2 mb-4">

		<div class="flex justify-end gap-2">
			<button onclick="closeDesigModal()" 
				class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
				Cancel
			</button>

			<button onclick="saveDesig()" 
				class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
				Save
			</button>
		</div>
	</div>
</div>

<script>
	function closeDesigModal() {
		document.getElementById('desigModal').classList.add('hidden');
	}
</script>

<script>
	$('#deptSelect').on('change', function() {

		let deptId = this.value;

		// Reset designation dropdown
		$('#desigSelect').html('<option value="">-- Select Designation --</option>');

		if (deptId === 'add_dept') {
			$('#deptModal').removeClass('hidden');
			this.value = '';
			return;
		}

		if (!deptId) return;

		// Load designations for selected department
		$.post(
			'<?= base_url("index.php/employee/get_designations_by_department") ?>', {
				department_id: deptId
			},
			function(res) {

				let options = '<option value="">-- Select Designation --</option>';

				JSON.parse(res).forEach(d => {
					options += `<option value="${d.designation_id}">
                                ${d.designation_name}
                            </option>`;
				});

				// IMPORTANT: Keep Add Designation option
				options += '<option value="add_desig">+ Add Designation</option>';

				$('#desigSelect').html(options);
			}
		);
	});


	$('#desigSelect').on('change', function() {
		if (this.value === 'add_desig') {
			$('#desigModal').removeClass('hidden');
			this.value = '';
		}
	});

	function saveDept() {
		$.post('<?= base_url("index.php/employee/save_department") ?>', {
				name: $('#newDept').val()
			},
			function() {
				location.reload();
			}
		);
	}

	function saveDesig() {
		$.post('<?= base_url("index.php/employee/save_designation") ?>', {
				department_id: $('#desigDept').val(),
				name: $('#newDesig').val()
			},
			function() {
				location.reload();
			}
		);
	}
</script>
