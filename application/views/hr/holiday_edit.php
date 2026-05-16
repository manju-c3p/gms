<div class="bg-white rounded-xl shadow p-6">
	<div class="flex justify-between items-center mb-4">
		<h2 class="text-xl font-semibold text-gray-700"> Holiday Edit </h2>
		<!-- List Button -->
		<a href="<?= base_url('index.php/Hr/view_holiday_list') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium"> List </a>
	</div>

	<?php foreach ($records as $row): ?>
		<form onsubmit="return check_duplicate_exist();" id="main" method="post"
			action="<?php echo base_url() . 'index.php/'; ?>Hr/update_holiday_data"
			autocomplete="off"
			enctype="multipart/form-data">

			<!-- Holiday Code -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
				<label class="text-sm font-medium text-gray-700">
					Holiday Code:
				</label>

				<div class="md:col-span-2">
					<input tabindex="1"
						type="text"
						name="paid_code"
						id="paid_code"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100"
						value="<?php echo $row->holiday_code; ?>"
						readonly>
				</div>
			</div>

			<!-- Holiday Name -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
				<label class="text-sm font-medium text-gray-700">
					Holiday Name: <span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-2">
					<abbr title="Enter Holiday Name">
						<input type="text"
							class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none"
							id="holiday_name"
							name="holiday_name"
							tabindex="4"
							value="<?php echo $row->holiday_name; ?>"
							required>
					</abbr>
				</div>
			</div>

			<!-- Date -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
				<label class="text-sm font-medium text-gray-700">
					Date: <span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-2">
					<div class="flex">
						<input type="text"
							class="w-full border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none datepicker1"
							id="holiday_date"
							name="holiday_date"
							value="<?php echo date('d-m-Y', strtotime($row->h_date) ?? '') ?>"
							tabindex="2"
							required>

						<div class="bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg px-3 flex items-center">
							<i class="fa fa-calendar"></i>
						</div>
					</div>
				</div>
			</div>

			<!-- Description -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
				<label class="text-sm font-medium text-gray-700">
					Holiday Description
				</label>

				<div class="md:col-span-2">
					<textarea id="holl_desc"
						tabindex="5"
						name="holl_desc"
						rows="2"
						placeholder="holiday description"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
						required><?php echo $row->holiday_des; ?></textarea>
				</div>
			</div>

			<!-- Submit -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
				<div></div>

				<div class="md:col-span-2">
					<input type="hidden" name="id" value="<?php echo $row->holiday_id; ?>">

					<button type="submit"
						tabindex="5"
						id="edit"
						class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow">
						Update
					</button>
				</div>
			</div>

		</form>
	<?php endforeach ?>

</div>
