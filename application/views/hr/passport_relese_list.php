<div class="bg-white shadow rounded-lg p-6">
	<div class="flex items-center justify-between mb-6">

    <!-- Caption -->
    <h2 class="text-lg font-semibold text-gray-800">
        Passport Release List
    </h2>

    <!-- Add Button -->
    <a href="<?php echo base_url('index.php/Hr/add_passport_release'); ?>"
       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">

        <i class="fa-solid fa-plus"></i>
        Add Passport Release

    </a>

</div>

	<div class="w-full overflow-x-auto">

		<table id="datatable"
			class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700"
			data-toggle="data-table">

			<thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">

				<tr>

					<th class="px-3 py-2 border border-gray-200">Sr No</th>

					<th class="px-3 py-2 border border-gray-200">Employee Name</th>

					<th class="px-3 py-2 border border-gray-200">
						passport release date
					</th>

					<th class="px-3 py-2 border border-gray-200">
						Return date
					</th>

					<th class="px-3 py-2 border border-gray-200">
						Action
					</th>

				</tr>

			</thead>


			<tbody class="bg-white divide-y divide-gray-200">

				<?php $i = 1;
				foreach ($records as $row) { ?>

					<tr class="hover:bg-gray-50">

						<td class="px-3 py-2 border border-gray-200">
							<?php echo $i;
							$i++; ?>
						</td>

						<td class="px-3 py-2 border border-gray-200">
							<?php echo $row->username; ?>
						</td>

						<td class="px-3 py-2 border border-gray-200">
							<?php echo date('d-M-Y', strtotime($row->outdate)); ?>
						</td>

						<td class="px-3 py-2 border border-gray-200">
							<?php echo date('d-M-Y', strtotime($row->indate)); ?>
						</td>


						<td class="px-3 py-2 border border-gray-200 whitespace-nowrap">

						<a href="<?php echo base_url() . 'index.php/Hr/edit_passport_release/' . $row->emp_docId; ?>"
									class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>

								<a href="<?php echo base_url() . 'index.php/Hr/delete_passport_release/' . $row->emp_docId; ?>"
									onclick="return confirmcancel(<?php echo $row->emp_docId; ?>);" class="bg-red-500 text-white px-3 py-1 rounded">Delete</a>

								<a href="<?php echo base_url() . 'index.php/Hr/print_passport_release/' . $row->emp_docId; ?>"
									target="_blank"
									class="bg-blue-600 text-white px-3 py-1 rounded">Print</a>


							

							


							

						</td>
					</tr>

				<?php } ?>

			</tbody>

		</table>

	</div>

</div>

<!-- Static Table End -->



<script>
	function confirmcancel(tid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'employee_document_details',
					where_key: 'emp_docId',
					where_val: tid
				},
				success: function(msg) {
					if (msg == 1) {

						alert("Record Deleted");

						window.location.reload();
					} else {
						alert("Can't Delete record. Data already exist!!!");
					}
				},
			});
			return true;
		} else
			return false;

	}
</script>
