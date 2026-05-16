<div class="bg-white shadow rounded-xl p-6">
	<!-- Header -->
	<div class="flex justify-between items-center mb-4">

		<!-- Heading -->
		<h2 class="text-xl font-semibold text-gray-800">
			Corporate Document List
		</h2>

		<!-- Add Document Button -->
		<a href="<?= base_url('index.php/Hr/add_corporate_file') ?>"
			class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow">

			<!-- Plus Icon -->
			<svg xmlns="http://www.w3.org/2000/svg"
				class="w-4 h-4"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor">
				<path stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M12 4v16m8-8H4" />
			</svg>

			Add Document
		</a>

	</div>

	<div class="overflow-x-auto">

		<table id="datatable"
			class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">

			<!-- Header -->
			<thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
				<tr>
					<th class="px-4 py-3 border">Sr No</th>
					<th class="px-4 py-3 border">Document Name</th>
					<th class="px-4 py-3 border">Document No</th>
					<th class="px-4 py-3 border">Expiry Date</th>
					<th class="px-4 py-3 border text-center">Action</th>
				</tr>
			</thead>

			<!-- Body -->
			<tbody class="divide-y divide-gray-200">

				<?php $i = 1;
				foreach ($records as $row) { ?>

					<tr class="hover:bg-gray-50">

						<!-- Sr No -->
						<td class="px-4 py-2 border">
							<?php echo $i;
							$i++; ?>
						</td>

						<!-- Document Name -->
						<td class="px-4 py-2 border">
							<?php echo $row->document_name; ?>
						</td>

						<!-- Document No -->
						<td class="px-4 py-2 border">
							<?php echo $row->card_no; ?>
						</td>

						<!-- Expiry Date -->
						<td class="px-4 py-2 border">
							<?php echo date('d-M-Y', strtotime($row->expiry_date)); ?>
						</td>

						<!-- Action -->
						<!-- Action Column -->
						<td class="px-4 py-2 border text-center whitespace-nowrap">

						<a href="<?= base_url('index.php/Hr/edit_corporate_file/' . $row->cop_id); ?>"
									class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
									Edit
								</a>

								<a href="<?= base_url('index.php/Hr/delete_corporate_file/' . $row->cop_id); ?>"
									onclick="return confirmcancel(<?php echo $row->cop_id; ?>);"
									class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2">
									Delete
								</a>

							<!-- Edit Button -->
							

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
					table_name: 'corporate_file',
					where_key: 'cop_id',
					where_val: tid
				},
				success: function(msg) {
					if (msg == 1) {
						alert("Record deleted");
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
