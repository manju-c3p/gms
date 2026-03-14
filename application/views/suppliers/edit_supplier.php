<div class="w-full mx-auto bg-white shadow-md rounded-2xl p-8 mt-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <h2 class="text-2xl font-semibold">Edit Supplier</h2>

        <a href="<?php echo base_url().'index.php/Supplier/list_suppliers'; ?>"
           class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium shadow-sm">
            ← List Suppliers
        </a>
    </div>

    <form action="<?php echo base_url().'index.php/Supplier/update_supplier'; ?>" method="post" class="space-y-8">

        <input type="hidden" name="supplier_id" value="<?php echo $supplier->supplier_id; ?>">

        <!-- Supplier Code -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <label class="font-semibold text-gray-700">
                Supplier Code <span class="text-red-500">*</span>
            </label>

            <input type="text"
                   value="<?php echo $supplier->supplier_code; ?>"
                   readonly
                   class="md:col-span-3 border rounded-lg px-4 py-2 bg-gray-100 text-gray-500 cursor-not-allowed">
        </div>

        <!-- Supplier Name -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <label class="font-semibold text-gray-700">
                Supplier Name <span class="text-red-500">*</span>
            </label>

            <input type="text"
                   name="supplier_name"
                   required
                   value="<?php echo $supplier->supplier_name; ?>"
                   class="md:col-span-3 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Email -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <label class="font-semibold text-gray-700">Email</label>

            <input type="email"
                   name="supplier_email"
                   value="<?php echo $supplier->email_id; ?>"
                   class="md:col-span-3 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Contact Number -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <label class="font-semibold text-gray-700">Contact Number</label>

            <input type="number"
                   name="contact_number"
                   value="<?php echo $supplier->contact_no; ?>"
                   class="md:col-span-3 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Address -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <label class="font-semibold text-gray-700">Address</label>

            <textarea name="supplier_address"
                      class="md:col-span-3 border rounded-lg px-4 py-2 min-h-[100px] focus:ring-2 focus:ring-blue-500 focus:outline-none"><?php echo $supplier->billing_address; ?></textarea>
        </div>

        <!-- TRN -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">
            <label class="font-semibold text-gray-700">TRN No</label>

            <input type="text"
                   name="trn_no"
                   value="<?php echo $supplier->trn_no; ?>"
                   class="md:col-span-3 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <!-- Divider -->
        <div class="border-t pt-6"></div>

        <!-- Contact Persons -->
        <div class="hidden grid grid-cols-1 md:grid-cols-4 gap-6 items-start">

            <label class="font-semibold text-gray-700">
                Contact Persons
            </label>

            <div class="md:col-span-3 overflow-x-auto">
                <table class="w-full border rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Name</th>
                            <th class="p-3 text-left">Phone</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 w-20"></th>
                        </tr>
                    </thead>

                    <tbody id="contact_table">
                        <?php
                        $rowCount = 0;
                        if (!empty($contacts)) {
                            foreach ($contacts as $c) { ?>
                                <tr id="row<?php echo $rowCount; ?>">
                                    <td class="p-2">
                                        <input type="text" name="contact_name[]"
                                               value="<?php echo $c->contact_name; ?>"
                                               class="w-full border rounded-lg px-3 py-2">
                                    </td>

                                    <td class="p-2">
                                        <input type="number" name="contact_phone[]"
                                               value="<?php echo $c->contact_phone; ?>"
                                               class="w-full border rounded-lg px-3 py-2">
                                    </td>

                                    <td class="p-2">
                                        <input type="email" name="contact_email[]"
                                               value="<?php echo $c->contact_email; ?>"
                                               class="w-full border rounded-lg px-3 py-2">
                                    </td>

                                    <td class="p-2 flex gap-2 justify-center">
                                        <button type="button" onclick="addRow()"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">+</button>

                                        <button type="button" onclick="removeRow(<?php echo $rowCount; ?>)"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">-</button>
                                    </td>
                                </tr>
                        <?php $rowCount++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4 pt-6 border-t">
            <a href="<?php echo base_url().'index.php/Supplier/list_suppliers'; ?>"
               class="px-6 py-2 border rounded-lg hover:bg-gray-100">
                Cancel
            </a>

            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Update Supplier
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
