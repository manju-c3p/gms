<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<!-- Header -->
<div class="flex justify-between items-center mb-4">
	<h2 class="text-2xl font-semibold text-gray-700">
		Bank Reconciliation List
	</h2>

	<a href="<?= base_url('index.php/Accounts/add_bank_reconciliation') ?>"
		class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
		Add
	</a>
</div>

<div class="bg-white shadow-md rounded-2xl p-4">
	<div class="overflow-x-auto">
		<table id="datatable" class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-100">
				<tr>
					<th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sr.no</th>
					<th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Instrument Number</th>
					<th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Instrument Date</th>
					<th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Amount Number</th>
					<th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Type</th>
					<th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Action</th>
				</tr>
			</thead>

			<tbody class="divide-y divide-gray-200 bg-white">
				<?php $i = 1;
				foreach ($records as $row) : ?>
					<tr class="hover:bg-gray-50 transition">
						<td class="px-4 py-2 text-sm text-gray-700"><?php echo $i;
																	$i++; ?></td>
						<td class="px-4 py-2 text-sm text-gray-700"><?php echo $row->instrument_no; ?></td>
						<td class="px-4 py-2 text-sm text-gray-700"><?php echo date('d-M-Y', strtotime($row->instrument_date)); ?></td>
						<td class="px-4 py-2 text-sm text-gray-700"><?php echo $row->amount_no; ?></td>
						<td class="px-4 py-2 text-sm text-gray-700"><?php echo $row->instrument_type; ?></td>
						<td class="px-4 py-2 text-sm text-gray-700 flex items-center gap-3">

							<!-- <a href="<?php echo base_url('index.php/Accounts/edit_bank_reconciliation/' . $row->reconciliation_id); ?>"
								title="Edit"
								class="text-blue-600 hover:text-blue-800 mr-3 inline-flex items-center">

								
								<svg xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									class="w-5 h-5">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 20.25l1.037-4.5 12.825-12.263z" />
								</svg>
							</a> -->

							<a href="javascript:confirmcancel(<?php echo $row->reconciliation_id; ?>)"
								title="Delete"
								class="text-red-600 hover:text-red-800 inline-flex items-center">

								<!-- Delete Icon -->
								<svg xmlns="http://www.w3.org/2000/svg"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									class="w-5 h-5">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M6 7.5h12M9.75 7.5v9m4.5-9v9M5.25 7.5l.375 12A2.25 2.25 0 007.875 21h8.25a2.25 2.25 0 002.25-2.25l.375-12M9 4.5h6a1.5 1.5 0 011.5 1.5v1.5h-9V6A1.5 1.5 0 019 4.5z" />
								</svg>
							</a>

						</td>
					</tr>
				<?php endforeach; ?>
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
					table_name: 'bank_reconciliation',
					where_key: 'reconciliation_id',
					where_val: tid
				},
				success: function(msg) {
					if (msg == 1) {
						// alert("Record deleted");
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
