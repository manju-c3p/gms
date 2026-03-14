<style>
	/* Keep your existing custom styles */
	#tab_logic {
		margin-top: 15px;
		background: white;
		border-radius: 6px;
		overflow: hidden;
	}

	#tab_logic td {
		vertical-align: middle;
	}

	textarea {
		border-radius: 4px;
		border: 1px solid #ccc;
		padding: 6px;
	}
</style>

<div class="bg-white shadow rounded-lg p-6">
	<!-- Header -->


	<div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">

		<!-- Caption -->
		<h2 class="text-lg font-semibold text-gray-800">
			Add Paid Leave
		</h2>

		<!-- List Button -->
		<a href="<?php echo base_url(); ?>index.php/Hr/view_paid_leave_list"
			class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm transition">

			<!-- List Icon -->
			<svg xmlns="http://www.w3.org/2000/svg"
				class="w-4 h-4 mr-2"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor">

				<path stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M4 6h16M4 12h16M4 18h16" />

			</svg>

			List

		</a>

	</div>



	<form id="main" method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/add_paid_leave_data"
		autocomplete="off" enctype="multipart/form-data">

		<!-- Employee -->
		<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
			<label class="text-sm font-medium text-gray-700">
				Employee Name:<span class="text-red-500">*</span>
			</label>

			<div class="md:col-span-2">
				<select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm select2 focus:outline-none focus:ring-2 focus:ring-blue-500"
					id="employee_id" name="employee_id" required>

					<option value="">Select</option>

					<?php foreach ($user_records as $s) { ?>
						<option <?php if ($this->session->userdata('user_id') == $s->id) echo 'selected'; ?>
							value="<?php echo $s->id ?>">
							<?php echo $s->username; ?>
						</option>
					<?php } ?>

				</select>
			</div>
		</div>

		<!-- Dates -->
		<div class="mb-4 grid grid-cols-1 md:grid-cols-6 gap-4 items-center">

			<label class="text-sm font-medium text-gray-700 md:col-span-1">
				Start Date:<span class="text-red-500">*</span>
			</label>

			<div class="relative md:col-span-2">
				<input type="text"
					class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm datepicker1 focus:outline-none focus:ring-2 focus:ring-blue-500"
					id="paid_date"
					name="paid_date"
					value="<?php echo date('d-m-Y') ?>"
					required>

				<div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
					<i class="fa fa-calendar text-gray-400"></i>
				</div>
			</div>

			<label class="text-sm font-medium text-gray-700 md:col-span-1 text-left md:text-right">
				End Date:<span class="text-red-500">*</span>
			</label>

			<div class="relative md:col-span-2">
				<input type="text"
					class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm datepicker1 focus:outline-none focus:ring-2 focus:ring-blue-500"
					id="end_date"
					name="end_date"
					value="<?php echo date('d-m-Y') ?>"
					required>

				<div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
					<i class="fa fa-calendar text-gray-400"></i>
				</div>
			</div>

		</div>

		<!-- Leave Table -->
		<div class="mb-4">
			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 rounded-md" id="tab_logic">

					<thead class="bg-gray-100 text-gray-700 text-sm">
						<tr>
							<th class="border px-3 py-2 text-left w-[5%]">Sr</th>
							<th class="border px-3 py-2 text-left w-[45%]">Select Leave Type</th>
							<th class="border px-3 py-2 text-left w-[30%]">Leave Days</th>
							<th class="border px-3 py-2 text-center w-[10%]">
								<a id="add_row"
									title="Add"
									class="inline-flex items-center justify-center w-8 h-8 bg-orange-500 hover:bg-orange-600 text-white rounded-md cursor-pointer">

									<span class="fa fa-plus"></span>

								</a>
							</th>
						</tr>
					</thead>

					<tbody id="mytbbody">

						<tr id="addr0">

							<td class="border px-3 py-2">1</td>

							<td class="border px-3 py-2">
								<select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm select2 leave_type"
									name="leave_type_id[]"
									id="leave_type_id0"
									required>

									<option value="">Select</option>

									<?php foreach ($category as $cat) { ?>
										<option value="<?php echo $cat->leave_cat_id ?>"
											data-days="<?php echo $cat->leave_days ?>">
											<?php echo $cat->category_name; ?>
										</option>
									<?php } ?>

								</select>
							</td>

							<td class="border px-3 py-2">
								<input type="number"
									name="leave_days[]"
									id="leave_days0"
									class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm leave_days focus:outline-none focus:ring-2 focus:ring-blue-500"
									placeholder="">
							</td>

							<td class="border px-3 py-2 text-center">
								<a title="Delete"
									class="inline-flex items-center justify-center w-8 h-8 bg-orange-500 hover:bg-orange-600 text-white rounded-md cursor-pointer remove1">

									<span class="fa fa-trash"></span>

								</a>
							</td>

						</tr>

					</tbody>

				</table>
			</div>
		</div>

		<!-- Remark -->
		<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-start">

			<label class="text-sm font-medium text-gray-700">
				Remark
			</label>

			<div class="md:col-span-2">
				<textarea id="p_remark"
					name="p_remark"
					rows="2"
					class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
					placeholder="Remark"
					required></textarea>
			</div>

		</div>

		<!-- Submit -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

			<div></div>

			<div class="md:col-span-2">
				<button type="submit"
					id="add"
					class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md shadow-sm transition">

					Submit

				</button>
			</div>

		</div>

	</form>


</div>


<script>
	$(document).ready(function() {
		var i = 1;

		// Add new row
		$("#add_row").click(function() {

			var newRow = `
        <tr id="addr${i}">

            <td class="border px-3 py-2">
                ${i + 1}
            </td>

            <td class="border px-3 py-2">
                <select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm select2 leave_type focus:outline-none focus:ring-2 focus:ring-blue-500"
                    name="leave_type_id[]"
                    id="leave_type_id${i}"
                    required>

                    <option value="">Select</option>

                    <?php foreach ($category as $cat) { ?>
                        <option value="<?php echo $cat->leave_cat_id ?>"
                            data-days="<?php echo $cat->leave_days ?>">
                            <?php echo $cat->category_name; ?>
                        </option>
                    <?php } ?>

                </select>
            </td>

            <td class="border px-3 py-2">
                <input type="number"
                    name="leave_days[]"
                    id="leave_days${i}"
                    class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm leave_days focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="">
            </td>

            <td class="border px-3 py-2 text-center">
                <a title="Delete"
                    class="inline-flex items-center justify-center w-8 h-8 bg-orange-500 hover:bg-orange-600 text-white rounded-md cursor-pointer remove1">

                    <span class="fa fa-trash"></span>

                </a>
            </td>

        </tr>`;

			$('#mytbbody').append(newRow);

			// reinitialize select2 for new row
			$('#leave_type_id' + i).select2();

			i++;

		});

		// Delete row
		$(document).on("click", ".remove1", function() {
			$(this).closest('tr').remove();
		});

		// Auto-fill leave days
		$(document).on('change', '.leave_type', function() {
			var leaveDays = $(this).find(':selected').data('days') || '';
			$(this).closest('tr').find('.leave_days').val(leaveDays);
		});
	});
</script>
