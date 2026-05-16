<div class="bg-white shadow rounded-xl p-6">
	<!-- Header -->
	<div class="flex justify-between items-center mb-6 border-b pb-3">

		<!-- Caption -->
		<h2 class="text-xl font-semibold text-gray-800">
			Add Corporate Document
		</h2>

		<!-- Listing Button -->
		<a href="<?php echo base_url('index.php/Hr/view_corporate_file_list'); ?>"
			class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm shadow">
			← Document Listing
		</a>

	</div>


	<form id="main"
		method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/add_corporate_file_data"
		autocomplete="off"
		enctype="multipart/form-data">

		<!-- Document Name -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">
			<label class="col-span-12 md:col-span-3 font-medium">
				Document Name <span class="text-red-500">*</span>
			</label>
			<div class="col-span-12 md:col-span-4">
				<input tabindex="1"
					type="text"
					name="doc_name"
					id="doc_name"
					placeholder="enter document name"
					required
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200">


			</div>
		</div>

		<!-- Licence/Card No -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">
			<label class="col-span-12 md:col-span-3 font-medium">
				Licence/Card No <span class="text-red-500">*</span>
			</label>
			<div class="col-span-12 md:col-span-4">
				<input tabindex="2"
					type="text"
					name="card_no"
					id="card_no"
					placeholder="enter card number"
					required
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200">
			</div>
		</div>

		<!-- Expiry Date -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">
			<label class="col-span-12 md:col-span-3 font-medium">
				Expiry Date <span class="text-red-500">*</span>
			</label>
			<div class="col-span-12 md:col-span-4">
				<div class="flex">
					<input type="date" class="w-full border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none datepicker1"

						id="exp_date"
						name="exp_date"
						value="<?php echo date('Y-m-d'); ?>"
						required>
					<!-- <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 rounded-r-lg bg-gray-50">
						📅
					</span> -->
				</div>
			</div>
		</div>

		<!-- Upload Documents -->
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
					<table class="min-w-full border border-gray-200 rounded-lg" id="tab_logic">
						<tbody>
							<tr id="addr0" class="border-b">
								<td class="px-3 py-2 text-sm">1</td>

								<td class="px-3 py-2">
									<input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
										id="documents"
										name="documents[]"
										type="file"  accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">
								</td>

								<td class="px-3 py-2 whitespace-nowrap">

									<!-- <button type="button"
										id="add_row"
										title="Add"
										class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
										+
									</button> -->
									<button type="button"
											class="remove bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
											🗑
										</button>

									<!-- <button type="button"
										id="delete_row"
										title="Delete"
										class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
										🗑
									</button> -->

								</td>
							</tr>

							<tr id="addr1"></tr>

						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Remarks -->
		<div class="grid grid-cols-12 gap-4 mb-4">
			<label class="col-span-12 md:col-span-3 font-medium">
				Remarks
			</label>

			<div class="col-span-12 md:col-span-4">
				<textarea id="remark"
					name="remark"
					rows="2"
					placeholder="remark"
					tabindex="5"
					class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200"></textarea>
			</div>
		</div>

		<!-- Submit -->
		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-12 md:col-span-3"></div>

			<div class="col-span-12 md:col-span-9">
				<button type="submit"
					id="add"
					tabindex="6"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
					Submit
				</button>
			</div>
		</div>

	</form>

</div>



<script>
	// $(document).ready(function() {
	// 	var i = 1;
	// 	$("#add_row").click(function() {

	// 		$('#addr' + i).html(
	// 			"<td class='px-3 py-2 text-sm'>" + (i + 1) + "</td>" +

	// 			"<td class='px-3 py-2'>" +
	// 			"<input class='w-full border border-gray-300 rounded-lg px-3 py-2 text-sm' " +
	// 			"id='documents" + i + "' name='documents[]' type='file'>" +
	// 			"</td>" +

	// 			"<td class='px-3 py-2'></td>"
	// 		);

	// 		$('#tab_logic').append('<tr id="addr' + (i + 1) + '" class="border-b"></tr>');

	// 		i++;

	// 	});

	// 	$("#delete_row").click(function() {
	// 		if (i > 1) {
	// 			$("#addr" + (i - 1)).html('');
	// 			i--;
	// 		}
	// 	});

	// });

	$(document).ready(function() {

    var i = 1;

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

            <td class="px-3 py-2 whitespace-nowrap">
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

    // ✅ Delete specific row
    $("#tab_logic").on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

});

	$("#tab_logic").on('click', '.remove', function() {
		$(this).closest('tr').remove();
	});
</script>
