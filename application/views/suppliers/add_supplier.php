<div class="w-full mx-auto bg-white shadow-md rounded-2xl p-8 mt-6">
	<div class="flex justify-between items-center mb-6">

		<h2 class="text-2xl font-semibold">Add Supplier</h2>

		<a href="<?php echo base_url() . 'index.php/Supplier/list_suppliers'; ?>"
			class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
			← List Suppliers
		</a>

	</div>

	<form action="<?php echo base_url() . 'index.php/'; ?>Supplier/add_supplier_data" method="post" autocomplete="off" class="space-y-6">

		<!-- Supplier Code -->
		<div class="grid md:grid-cols-3 gap-4 items-center">
			<label class="font-medium">Supplier Code <span class="text-red-500">*</span></label>
			<input type="text"
				name="supplier_code"
				required
				value="<?php echo $supplier_code; ?>"
				readonly
				class="md:col-span-2 border rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed focus:outline-none">
		</div>

		<!-- Supplier Name -->
		<div class="grid md:grid-cols-3 gap-4 items-center">
			<label class="font-medium">Supplier Name <span class="text-red-500">*</span></label>
			<input type="text" name="supplier_name" required
				class="md:col-span-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
		</div>



		<!-- Email -->
		<div class="grid md:grid-cols-3 gap-4 items-center">
			<label class="font-medium">Email</label>
			<input type="email" name="supplier_email"
				class="md:col-span-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
		</div>

		<!-- Contact Number -->
		<div class="grid md:grid-cols-3 gap-4 items-center">
			<label class="font-medium">Contact Number</label>
			<input type="number" name="contact_number"
				class="md:col-span-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
		</div>

		<!-- Address -->
		<div class="grid md:grid-cols-3 gap-4">
			<label class="font-medium">Address</label>
			<textarea name="supplier_address"
				class="md:col-span-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
		</div>

		<!-- TRN -->
		<div class="grid md:grid-cols-3 gap-4 items-center">
			<label class="font-medium">TRN No</label>
			<input type="text" name="trn_no"
				class="md:col-span-2 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
		</div>

		<!-- Contact Persons -->
		<div class="hidden">
			<label class="font-medium block mb-2">Contact Persons</label>

			<div class="overflow-x-auto">
				<table class="w-full border rounded-lg" id="contact_table">
					<thead class="bg-gray-100">
						<tr>
							<th class="p-2 text-left">Name</th>
							<th class="p-2 text-left">Phone</th>
							<th class="p-2 text-left">Email</th>
							<th class="p-2 w-16"></th>
						</tr>
					</thead>

					<tbody>
						<tr id="row0">
							<td class="p-2">
								<input type="text" name="contact_name[]" 
									class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
							</td>
							<td class="p-2">
								<input type="number" name="contact_phone[]" 
									class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
							</td>
							<td class="p-2">
								<input type="email" name="contact_email[]" 
									class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
							</td>
							<td class="p-2">
								<button type="button" onclick="addRow()"
									class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">
									+
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<input type="hidden" id="num_rows" name="num_rows" value="0">
		</div>

		<!-- Buttons -->
		<div class="flex justify-end gap-4 pt-4">
			<button type="reset"
				class="px-6 py-2 border rounded-lg hover:bg-gray-100">
				Reset
			</button>

			<button type="submit"
				class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
				Submit
			</button>
		</div>

	</form>
</div>

<!-- Dynamic Row Script -->
<script>
	let rowCount = 0;

	function addRow() {
		rowCount++;

		const table = document.querySelector("#contact_table tbody");

		const row = `
        <tr id="row${rowCount}">
            <td class="p-2">
                <input type="text" name="contact_name[]" required
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </td>
            <td class="p-2">
                <input type="number" name="contact_phone[]" required
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </td>
            <td class="p-2">
                <input type="email" name="contact_email[]" required
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </td>
            <td class="p-2 flex gap-2">
                <button type="button" onclick="addRow()"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">+</button>

                <button type="button" onclick="removeRow(${rowCount})"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">-</button>
            </td>
        </tr>
    `;

		table.insertAdjacentHTML('beforeend', row);
		document.getElementById('num_rows').value = rowCount;
	}

	function removeRow(id) {
		document.getElementById(`row${id}`).remove();
	}
</script>


<script>
	// function add_row() {
	// 	var num_rows = $('#num_rows').val();
	// 	var i = num_rows + 1;
	// 	var new_row = "<tr id='addr" + i + "'><td><input class='form-control' id='contact_name" + i + "' name='contact_name[]' type='text' placeholder='Enter Name'></td><td><input class='form-control' id='contact_number" + i + "' name='contact_number[]' type='text' pattern='[0-9]' title='Enter a valid phone number' placeholder='Enter Contact Number'></td><td><input class='form-control' id='contact_email" + i + "' name='contact_email[]' type='text' placeholder='Enter Email ID'></td><td> <a onclick='delete_row(" + i + ")' title='Delete' class='btn btn-sm bg-blue'><span class='glyphicon glyphicon-trash'></span></a></td></tr>";
	// 	$("#addr" + num_rows).after(new_row);
	// 	$('#num_rows').val(i);
	// }
</script>
