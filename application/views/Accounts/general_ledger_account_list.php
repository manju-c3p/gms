
<!-- DataTables -->
 <link rel="stylesheet"
 	href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

 <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<div class="p-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">
                General Ledger Accounts
            </h2>

            <div class="flex gap-3">
                <a href="<?= base_url('index.php/Accounts/view_general_ledger_account_form') ?>"
                   class="px-4 py-2 text-sm font-medium text-green-700 bg-green-100 rounded-full hover:bg-green-200">
                    + Add New Record
                </a>

                <a href="<?= base_url('index.php/Accounts/groups') ?>"
                   class="px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200">
                    Account Groups
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="p-4 overflow-x-auto">
            <table id="ledgerTable" class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Account Code</th>
                        <th class="px-4 py-3 text-left">Account Name</th>
                        <th class="px-4 py-3 text-left">Account Group</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($ledger_records as $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-medium">
                                <?= $row->account_id; ?>
                            </td>

                            <td class="px-4 py-2">
                                <?= $row->account_name; ?>
                            </td>

                            <td class="px-4 py-2">
                                <?= $row->group_name; ?>
                            </td>

                            <td class="px-4 py-2 text-center space-x-2">
                                <!-- Edit -->
                                <a href="<?= base_url('index.php/Accounts/edit_general_ledger_account_form/'.$row->account_id); ?>"
                                   class="inline-flex items-center justify-center
                                          w-8 h-8 rounded-full bg-green-100 text-green-700
                                          hover:bg-green-200"
                                   title="Edit">
                                    ✏️
                                </a>

                                <!-- Delete (restricted groups only) -->
                                <?php if ($row->group_name == 'Farmer' || $row->group_name == 'Vendors/Suppliers'): ?>
                                    <button onclick="delete_area(<?= $row->account_id; ?>)"
                                            class="inline-flex items-center justify-center
                                                   w-8 h-8 rounded-full bg-red-100 text-red-700
                                                   hover:bg-red-200"
                                            title="Delete">
                                        🗑️
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<script>
$(document).ready(function () {
    $('#ledgerTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        responsive: true,
        language: {
            search: "Search Ledger:",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });
});
</script>


<script>
	function delete_area(id) {

		var x;
		var r = bootbox.confirm("Are you sure you want to delete record?!", function(res) {
			if (res == true) {
				$.ajax({
					url: "<?php echo base_url() ?>index.php/accounts/delete_ledger_record",
					type: "POST",
					dataType: "json",
					data: {
						account_id: id
					},
					success: function(msg) {
						if (msg == 1) {
							alert("The record is deleted!");
							window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
						} else {
							bootbox.alert("The record is not deleted!");
						}

					},
					error: function(xhr, textStatus, errorThrown) {
						alert('Cannot deleted mater records');
					}
				});
			} else
				return false;

		})
	};
</script>
