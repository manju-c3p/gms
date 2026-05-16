<div class="bg-white shadow rounded-lg p-6">
	<!-- Header -->

	<div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">

		<!-- Caption -->
		<h2 class="text-lg font-semibold text-gray-800">
			Edit Paid Leave
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



	<form onsubmit="return check_duplicate_exist();" id="main" method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/update_paid_leave"
		autocomplete="off" enctype="multipart/form-data">

		<?php foreach ($records as $row): ?>

			<!-- Employee Name -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">

				<label class="text-sm font-medium text-gray-700">
					Employee Name:
				</label>

				<div class="md:col-span-2">
					<?php foreach ($user_records as $s): ?>
						<?php if ($row->emp_id == $s->employee_id): ?>

							<input type="text"
								class="w-full md:w-96 border border-gray-300 rounded-md px-3 py-2 text-sm bg-gray-100 focus:outline-none"
								value="<?php echo $s->employee_name; ?>"
								readonly>

							<input type="hidden"
								name="employee_id_hidden"
								value="<?php echo $s->employee_id; ?>">

						<?php endif; ?>
					<?php endforeach; ?>
				</div>

			</div>


			<!-- Dates -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-6 gap-4 items-center">

				<label class="text-sm font-medium text-gray-700 md:col-span-1">
					Start Date:<span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-2">
					<input type="text"
						class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm datepicker1 focus:outline-none focus:ring-2 focus:ring-blue-500"
						id="paid_date"
						name="paid_date"
						value="<?php echo date('d-m-Y', strtotime($row->p_date)); ?>"
						required>
				</div>

				<label class="text-sm font-medium text-gray-700 md:col-span-1 md:text-right">
					End Date:<span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-2">
					<input type="text"
						class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm datepicker1 focus:outline-none focus:ring-2 focus:ring-blue-500"
						id="end_date"
						name="end_date"
						value="<?php echo date('d-m-Y', strtotime($row->p_end_date)); ?>"
						required>
				</div>

			</div>


			<!-- Leave Table -->
			<div class="mb-4">

				<div class="overflow-x-auto">

					<table class="min-w-full border border-gray-200 rounded-lg text-sm" id="tab_logic">

						<thead class="bg-gray-100 text-gray-700">

							<tr>

								<th class="border px-3 py-2 text-left w-[5%]">Sr</th>

								<th class="border px-3 py-2 text-left w-[35%]">Select Leave Type</th>

								<th class="border px-3 py-2 text-left w-[20%]">Leave Days</th>

								

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

							<?php
							$count = 1;
							foreach ($trans as $s): ?>

								<tr id="addr<?php echo $count - 1; ?>">

									<td class="border px-3 py-2">
										<?php echo $count; ?>
									</td>

									<td class="border px-3 py-2">

										<select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm select2 leave_type focus:outline-none focus:ring-2 focus:ring-blue-500"
											style="width:400px"
											name="leave_type_id[]"
											id="leave_type_id<?php echo $count - 1; ?>"
											required>

											<option value="">Select</option>

											<?php foreach ($category as $cat): ?>

												<option value="<?php echo $cat->leave_cat_id; ?>"
													data-days="<?php echo $cat->leave_days; ?>"
													<?php echo ($s->leave_type_id == $cat->leave_cat_id) ? 'selected' : ''; ?>>

													<?php echo $cat->category_name; ?>

												</option>

											<?php endforeach; ?>

										</select>

									</td>

									<td class="border px-3 py-2">

										<input type="number"
											name="leave_days[]"
											id="leave_days<?php echo $count - 1; ?>"
											class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm leave_days focus:outline-none focus:ring-2 focus:ring-blue-500"
											value="<?php echo $s->paid_days; ?>"
											placeholder="">

									</td>

								

									<td class="border px-3 py-2 text-center">

										<a title="Delete"
											class="inline-flex items-center justify-center w-8 h-8 bg-orange-500 hover:bg-orange-600 text-white rounded-md cursor-pointer remove1">

											<span class="fa fa-trash"></span>

										</a>

									</td>

								</tr>

							<?php
								$count++;
							endforeach; ?>

						</tbody>

					</table>

				</div>

			</div>


			<!-- Remark -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">

				<label class="text-sm font-medium text-gray-700">
					Remark<span class="text-red-500">*</span>
				</label>

				<div class="md:col-span-2">

					<textarea id="p_remark"
						name="p_remark"
						rows="2"
						class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
						required><?php echo $row->p_remark; ?></textarea>

				</div>

			</div>


			<!-- Submit -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

				<div></div>

				<div class="md:col-span-2">

					<input type="hidden"
						name="id"
						value="<?php echo $row->paid_id; ?>">

					<button type="submit"
						id="edit"
						class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md shadow-sm transition">

						Update

					</button>

				</div>

			</div>

		<?php endforeach; ?>

	</form>


</div>


<script>
	$(document).ready(function() {
		let i = $('#mytbbody tr').length; // continue numbering rows
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

		//  <td class="border px-3 py-2">
					// 	<input type="number" name="use_leave_days[]" id="use_leave_days${i}" 
					// 		class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm bg-soft-gray" readonly placeholder="">
					// </td>

		// ➕ Add new row
		$("#add_row3423").click(function() {
			const newRow = `
            <tr id="addr${i}">
                <td>${i + 1}</td>
                <td>
                    <select class="form-select form-control-sm select2 leave_type" 
                        name="leave_type_id[]" id="leave_type_id${i}" required>
                        <option value="">Select</option>
                        <?php foreach ($category as $cat) { ?>
                            <option value="<?php echo $cat->leave_cat_id ?>" 
                                    data-days="<?php echo $cat->leave_days ?>">
                                <?php echo $cat->category_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="number" name="leave_days[]" id="leave_days${i}" 
                        class="form-control form-control-sm leave_days" placeholder="">
                </td>
                <td>
                    <input type="number" name="use_leave_days[]" id="use_leave_days${i}" 
                        class="form-control form-control-sm bg-soft-gray" readonly placeholder="">
                </td>
                <td>
                    <a title="Delete" class="btn btn-xs bg-orange remove1">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>`;
			$('#mytbbody').append(newRow);
			i++;
		});

		// 🗑️ Delete row
		$(document).on("click", ".remove1", function() {
			$(this).closest('tr').remove();
			updateRowNumbers();
		});

		// 🔄 Auto-fill leave days when leave type changes
		$(document).on('change', '.leave_type', function() {
			const leaveDays = $(this).find(':selected').data('days') || '';
			$(this).closest('tr').find('.leave_days').val(leaveDays);
		});

		// 🔢 Update serial numbers dynamically
		function updateRowNumbers() {
			$('#mytbbody tr').each(function(index) {
				$(this).find('td:first').text(index + 1);
			});
		}
	});
</script>
