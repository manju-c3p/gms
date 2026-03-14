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

							<!-- Edit -->
							<a href="<?php echo base_url() . 'index.php/Hr/edit_passport_release/' . $row->emp_docId; ?>"
								title="Edit"
								class="inline-flex items-center justify-center w-8 h-8 rounded bg-blue-100 text-blue-600 hover:bg-blue-200 mr-2">

								<i class="fa-solid fa-pen-to-square"></i>

							</a>


							<!-- Delete -->
							<a href="<?php echo base_url() . 'index.php/Hr/delete_passport_release/' . $row->emp_docId; ?>"
								title="Delete"
								onclick="return confirmcancel(<?php echo $row->emp_docId; ?>);"
								class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-100 text-red-600 hover:bg-red-200 mr-2">

								<i class="fa-solid fa-trash"></i>

							</a>


							<!-- Print -->
							<a href="<?php echo base_url() . 'index.php/Hr/print_passport_release/' . $row->emp_docId; ?>"
								title="Print"
								target="_blank"
								class="inline-flex items-center justify-center w-8 h-8 rounded bg-gray-100 text-gray-600 hover:bg-gray-200">

								<i class="fa-solid fa-print"></i>

							</a>

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

						window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
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
