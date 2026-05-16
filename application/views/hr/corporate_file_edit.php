<div class="bg-white shadow rounded-xl p-6">
	<!-- Header -->
	<div class="flex justify-between items-center mb-6 border-b pb-3">

		<!-- Caption -->
		<h2 class="text-xl font-semibold text-gray-800">
			Edit Corporate Document
		</h2>

		<!-- Listing Button -->
		<a href="<?php echo base_url('index.php/Hr/view_corporate_file_list'); ?>"
			class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm shadow">
			← Document Listing
		</a>

	</div>

	<?php foreach ($records as $row) : ?>

		<form id="main"
			method="post"
			action="<?php echo base_url() . 'index.php/'; ?>Hr/update_corporate_file"
			autocomplete="off"
			enctype="multipart/form-data">


			<!-- Document Name -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-3 font-medium">
					Document Name:
				</label>

				<div class="col-span-12 md:col-span-4">

					<input tabindex="1"
						type="text"
						name="doc_name"
						id="doc_name"
						placeholder="enter document name"
						readonly
						value="<?php echo $row->document_name; ?>"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">

				</div>

			</div>



			<!-- Licence/Card No -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-3 font-medium">
					Licence/Card No :
				</label>

				<div class="col-span-12 md:col-span-4">

					<input tabindex="2"
						type="text"
						name="card_no"
						id="card_no"
						placeholder="enter card number"
						value="<?php echo $row->card_no; ?>"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

				</div>

			</div>



			<!-- Expiry Date -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-3 font-medium">
					Expiry Date :
				</label>

				<div class="col-span-12 md:col-span-4">

					<div class="flex">


						<input type="date" class="w-full border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none datepicker1"

							id="exp_date"
							name="exp_date"
							value="<?php echo date('Y-m-d', strtotime($row->expiry_date) ?? ''); ?>"
							required>



					</div>

				</div>

			</div>



			<!-- Upload -->
			<div class="grid grid-cols-12 gap-4 mb-4">

				<div class="col-span-12 md:col-span-3 font-medium">
					<label class="col-span-12 md:col-span-3 font-medium">
						Upload ("jpeg","jpg","png","doc","pdf"):
					</label>
					<button type="button"
						id="add_row"
						class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
						+ Add File
					</button>
				</div>

				<div class="col-span-12 md:col-span-6">

					<div class="overflow-x-auto">

						<table class="min-w-full border border-gray-200 rounded-lg text-sm" id="tab_logic" tabindex="11">

							<tbody>

								<!-- Upload Row -->
								<tr id="addr0" class="border-b">

									<td class="px-3 py-2">1</td>

									<td class="px-3 py-2">

										<input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
											id="documents"
											name="documents[]"
											type="file" accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">

									</td>

									<td class="px-3 py-2 whitespace-nowrap">

										<!-- <button type="button"
                                        id="add_row"
                                        title="Add"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                    +
                                </button> -->
										<button type="button"
											class="remove bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm ml-2">
											🗑
										</button>

										<!-- <button type="button"
                                        id="delete_row"
                                        title="Delete"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm ml-2">
                                    🗑
                                </button> -->

									</td>

								</tr>



								<!-- Existing Files -->
								<?php if ($file_records) {

									$x = 1;
									$i = 0;

									foreach ($file_records as $k) { 	$i++;?>
									
										<tr class="border-b">
											<td><?php echo $i; ?></td>

											<td>
												<a href="<?php echo base_url() . 'uploads/corporatefiles/' . $k->document_path; ?>"
													download
													class="text-blue-600 hover:text-blue-800 underline font-medium">

													File - <?php echo $k->document_path; ?>
												</a>

												<input type="hidden" name="existing_files[]" value="<?php echo $k->doc_id; ?>">
											</td>

											<td>
												<button type="button" class="remove bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded">
													🗑
												</button>
											</td>
										</tr>

								<?php }
								} ?>

								<tr id="addr1"></tr>

							</tbody>

						</table>

					</div>

				</div>

			</div>



			<!-- Remarks -->
			<div class="grid grid-cols-12 gap-4 mb-4">

				<label class="col-span-12 md:col-span-3 font-medium">
					Remarks :
				</label>

				<div class="col-span-12 md:col-span-4">

					<textarea id="remark"
						name="remark"
						rows="2"
						placeholder="remark"
						tabindex="5"
						class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"><?php echo $row->remark; ?></textarea>

				</div>

			</div>



			<!-- Submit -->
			<div class="grid grid-cols-12 gap-4">

				<div class="col-span-12 md:col-span-3"></div>

				<div class="col-span-12 md:col-span-9">

					<input type="hidden" name="id" value="<?php echo $row->cop_id; ?>">

					<button type="submit"
						id="add"
						tabindex="6"
						class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">

						Submit

					</button>

				</div>

			</div>


		</form>

	<?php endforeach; ?>

</div>




<script>
	// $(document).ready(function() {
	//     var i = <?php echo count($file_records) + 1; ?>; // Set initial value of i to the count of existing files plus 1

	//     $("#add_row").click(function() {
	//         $('#addr' + i).html("<td>" + (i + 1) + "</td><td><div class='col-sm-6'><input class='form-control' id='documents" + i + "' name='documents[]' type='file'></div></td><td></td>");
	//         $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
	//         i++;
	//     });

	//     $("#delete_row").click(function() {
	//         if (i > 1) {
	//             $("#addr" + (i - 1)).html('');
	//             i--;
	//         }
	//     });
	// });

	$(document).ready(function() {

		var i = <?php echo count($file_records) + 1; ?>;

		$("#add_row").click(function() {

			var row = `
        <tr id="addr${i}" class="border-b">
            <td class="px-3 py-2 text-sm">${i + 1}</td>

            <td class="px-3 py-2">
                <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    name="documents[]"
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">
            </td>

            <td class="px-3 py-2">
                <button type="button"
                    class="remove bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                    🗑
                </button>
            </td>
        </tr>
        `;

			$("#tab_logic tbody").append(row);

			i++;
		});

		// ✅ Remove specific row (works for all rows)
		$("#tab_logic").on('click', '.remove', function() {
			$(this).closest('tr').remove();
		});

	});
</script>
