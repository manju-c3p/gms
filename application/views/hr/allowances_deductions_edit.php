<style type="text/css">
	.select2Width {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		max-width: 240px !important;
		min-width: 240px !important;
	}
</style>

<div class="bg-white rounded-xl shadow p-6">
	 <div class="flex justify-between items-center mb-4">
       <h2 class="text-xl font-semibold text-gray-700"> Allowances & Deductions Edit </h2> <!-- List Button --> <a href="<?= base_url('index.php/Hr/view_allowances_list') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium"> List </a>
    </div>

	<?php foreach ($records as $row) : ?>
		<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_allowances" id="addform" autocomplete="off" enctype="multipart/form-data">

			<!-- Allowance Type -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
				<label class="text-sm font-medium text-gray-700">
					Allowances Type <span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-2">
					<input type="hidden" id="allowance_type_hidden" name="allowance_type" value="<?php echo $row->allowance_type; ?>" tabindex="1">

					<input type="text"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100"
						value="<?php echo ($row->allowance_type == 'A') ? 'Allowances' : 'Deductions'; ?>"
						readonly>
				</div>
			</div>

			<!-- Allowance Name -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
				<label class="text-sm font-medium text-gray-700">
					Allowance Name
				</label>

				<div class="md:col-span-2">
					<input type="text"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
						id="allowance_name"
						name="allowance_name"
						tabindex="2"
						value="<?php echo $row->allowance_name ?>"
						placeholder="Enter Allowance Name">
				</div>
			</div>

			<!-- Submit -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
				<div></div>

				<div class="md:col-span-2">
					<input type="hidden" name="id" value="<?php echo $row->sno; ?>">

					<button type="submit"
						id="add"
						tabindex="3"
						class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow">
						Submit
					</button>
				</div>
			</div>

		</form>

	<?php endforeach ?>

</div>
