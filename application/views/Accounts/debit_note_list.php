<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<div class="bg-white rounded-xl shadow p-4">
	<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
		<h2 class="text-lg font-semibold text-gray-800">Debit Note List</h2>

		<span class="flex gap-2">
			<a href="<?php echo base_url('index.php/Accounts/add_debit_note'); ?>"
				class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 hover:bg-blue-200 transition"
				title="Add New Record">
				Add New Record
			</a>

			<a href="<?php echo base_url('index.php/Accounts/view_debit_note_list'); ?>"
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
					<th class="px-3 py-2 border text-left">Trans Code</th>
					<th class="px-3 py-2 border text-left">Date</th>
					<th class="px-3 py-2 border text-left">Amount</th>
					<th class="px-3 py-2 border text-left">Narration</th>
					<th class="px-3 py-2 border text-left">Action</th>
				</tr>
			</thead>

			<tbody class="divide-y divide-gray-200">
				<?php $i = 1;
				foreach ($debit_note as $row) : ?>
					<tr <?php if ($row->cancel == 1) {
							echo "class='bg-red-100'";
						} ?>>

						<td class="px-3 py-2 border">
							<?php echo $i;
							$i++; ?>
						</td>

						<td class="px-3 py-2 border text-blue-600 hover:underline">
							<a target="_blank"
								href="<?php echo base_url() . 'index.php/Accounts/view_account_transaction_details/' . $row->voucher_id; ?>"
								title="details">
								<?php echo $row->voucher_code; ?>
							</a>
						</td>

						<td class="px-3 py-2 border">
							<?php echo date('d-M-Y', strtotime($row->voucher_date)); ?>
						</td>

						<td class="px-3 py-2 border font-medium">
							<?php echo $row->amount; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php echo $row->narration; ?>
						</td>

						<td class="px-3 py-2 border">
							<?php if ($row->cancel == 0) { ?>
								<a href="javascript:confirmcancel('<?php echo $row->voucher_code; ?>')"
									title="Delete"
									class="inline-flex items-center justify-center w-8 h-8 rounded-md 
                  					text-red-600 hover:bg-red-100 hover:text-red-700 transition">

									<!-- Delete / Trash Icon -->
									<svg xmlns="http://www.w3.org/2000/svg"
										class="w-5 h-5"
										viewBox="0 0 24 24"
										fill="none"
										stroke="currentColor"
										stroke-width="2">
										<polyline points="3 6 5 6 21 6" />
										<path d="M19 6l-1 14H6L5 6" />
										<path d="M10 11v6" />
										<path d="M14 11v6" />
										<path d="M9 6V4h6v2" />
									</svg>

								</a>
							<?php } else { ?>
								<span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded">
									Cancelled
								</span>
							<?php } ?>
						</td>


					</tr>
				<?php endforeach; ?>
			</tbody>

		</table>
	</div>
</div>


<!-- Static Table End -->



<script>
	function confirmcancel(voucher_code) {
		var r = confirm("Are you sure you want to Cancel Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Accounts/delete_trans_entry",
				type: "POST",
				data: {
					voucher_code: voucher_code
				},
				success: function(msg) {
					if (msg == 1) {
						alert("Record Cancelled");
						window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
					} else {
						alert("Can't Cancel record. Data already exist!!!");
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
