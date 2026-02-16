<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-xl shadow p-4">
	<!-- Header -->
	<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
		<h2 class="text-lg font-semibold text-gray-800">Bank Reconciliation</h2>

		<span class="flex gap-2">
			<a href="<?php echo base_url('index.php/accounts/add_bank_reconciliation'); ?>"
				class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 hover:bg-blue-200 transition"
				title="Add New Record">
				Add New Record
			</a>

			<a href="<?php echo base_url('index.php/accounts/list_bank_reconciliation'); ?>"
				class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 hover:bg-blue-200 transition"
				title="List Records">
				List Records
			</a>
		</span>

	</div><br>
	<div class="overflow-x-auto">
		<table id="datatable"
			data-toggle="data-table"
			class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">

			<thead class="bg-gray-100 text-gray-700">
				<tr>
					<th class="px-3 py-2 border text-left">Sr.no</th>
					<th class="px-3 py-2 border text-left">Instrument Number</th>
					<th class="px-3 py-2 border text-left">Instrument Date</th>
					<th class="px-3 py-2 border text-left">Amount Number</th>
					<th class="px-3 py-2 border text-left">Type</th>
					<th class="px-3 py-2 border text-left">Action</th>
				</tr>
			</thead>

			<tbody class="divide-y divide-gray-200">
				<?php $i = 1;
				foreach ($records as $row) : ?>
					<tr>

						<td class="px-3 py-2 border">
							<?php echo $i;
							$i++; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo $row->instrument_no; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo date('d-M-Y', strtotime($row->instrument_date)); ?>
						</td>

						<td class="px-3 py-2 border font-medium">
							<?php echo $row->amount_no; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo $row->instrument_type; ?>
						</td>

						<td class="px-3 py-2 border">
							<div class="flex items-center gap-2">

								<!-- Edit Button -->
								<a href="<?php echo base_url('index.php/Accounts/edit_bank_reconciliation/' . $row->reconciliation_id); ?>"
									title="Edit"
									class="inline-flex items-center justify-center w-8 h-8 
                  rounded-md bg-blue-50 text-blue-600 
                  hover:bg-blue-100 hover:text-blue-700 
                  transition">

									<!-- Pencil Icon -->
									<svg xmlns="http://www.w3.org/2000/svg"
										class="w-4 h-4"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="M11 5h2M12 20h9" />
										<path stroke-linecap="round" stroke-linejoin="round"
											d="M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
									</svg>

								</a>


								<!-- Delete Button -->
								<button onclick="confirmcancel(<?php echo $row->reconciliation_id; ?>)"
									title="Delete"
									class="inline-flex items-center justify-center w-8 h-8 
                       rounded-md bg-red-50 text-red-600 
                       hover:bg-red-100 hover:text-red-700 
                       transition">

									<!-- Trash Icon -->
									<svg xmlns="http://www.w3.org/2000/svg"
										class="w-4 h-4"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
										stroke-width="2">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="M3 6h18M9 6V4h6v2m-7 0l1 14h8l1-14M10 11v6M14 11v6" />
									</svg>

								</button>

							</div>
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
<script>
	$(document).ready(function() {
		$('#datatable').DataTable({
			pageLength: 10,
			lengthMenu: [10, 25, 50, 100],
			order: [
				[0, 'asc']
			], // Sr.no
			searching: true,
			paging: true,
			info: true,
			autoWidth: false,
			responsive: true,
			columnDefs: [{
					orderable: false,
					targets: -1
				} // Disable sorting on Action column
			]
		});
	});
</script>
