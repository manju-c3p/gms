<div class="min-h-screen bg-gray-100 p-6">

	<div class="w-full bg-white shadow-lg rounded-xl p-8">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-bold">Add New User</h2>
			<a href="<?php echo base_url('index.php/Setup/list_users'); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">List Records</a>
		</div>

		<form action="<?php echo base_url('index.php/Setup/add_user_data'); ?>" method="POST">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

				<div>
					<label class="block text-sm font-medium mb-1">First Name</label>
					<input type="text" name="first_name" class="border rounded-lg px-4 py-2 w-full" required>
				</div>

				<div>
					<label class="block text-sm font-medium mb-1">Last Name</label>
					<input type="text" name="last_name" class="border rounded-lg px-4 py-2 w-full" required>
				</div>

				<div>
					<label class="block text-sm font-medium mb-1">Email</label>
					<input type="email" name="email" class="border rounded-lg px-4 py-2 w-full" required>
				</div>

				<!-- Username -->
				<div>
					<label class="block text-sm font-medium mb-1">Username</label>
					<input type="text" name="username" class="w-full border rounded-lg px-3 py-2" required />
				</div>

				<!-- Password -->

				<div class="relative">
					<label class="block text-sm font-medium mb-1">Password</label>
					<div class="relative">
						<input type="password" name="password" id="passwordField" required class="w-full border rounded-lg px-3 py-2 pr-10" />
						<button type="button" id="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-gray-600">
							👁️
						</button>
					</div>
				</div>


				<!-- Role -->
				<div>
					<label class="block text-sm font-medium mb-1">Role</label>
					<select name="role" required
						class="w-full border rounded-lg px-3 py-2">
						<option value="">Select Role</option>
						<option value="Admin">Admin</option>
						<option value="Manager">Manager</option>
						<option value="Employee">Employee</option>
						<option value="Guest">Guest</option>
					</select>
				</div>

				<!-- Department -->
				<div>
					<label class="block text-sm font-medium mb-1">Department</label>
					<input type="text" name="department" class="w-full border rounded-lg px-3 py-2" />
				</div>

				<!-- Contact Number -->
				<div>
					<label class="block text-sm font-medium mb-1">Contact Number</label>
					<input type="number" name="contact_number"
						class="w-full border rounded-lg px-3 py-2" />
				</div>

				<!-- Status -->
				<div>
					<label class="block text-sm font-medium mb-1">Status</label>
					<select name="status"
						class="w-full border rounded-lg px-3 py-2">
						<option value="Active">Active</option>
						<option value="Inactive">Inactive</option>
					</select>
				</div>

				<!-- Submit Button -->
				<div class="col-span-1 md:col-span-2 text-center mt-4">
					<button type="submit"
						class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
						Save User
					</button>

					<button type="submit"
						class="bg-blue-600 text-white px-6 py-2 rounded-lg "><a href="<?php echo base_url('index.php/Setup/list_users'); ?>">
							Cancel
						</a></button>
				</div>


			</div>

		</form>

	</div>
</div>
<script>
	const toggleBtn = document.getElementById('togglePassword');
	const pwd = document.getElementById('passwordField');

	toggleBtn.addEventListener('click', () => {
		pwd.type = pwd.type === 'password' ? 'text' : 'password';
	});
</script>
