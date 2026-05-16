<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-xl shadow p-4">
	<!-- Header -->
	<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
		<h2 class="text-lg font-semibold text-gray-800">Receipt List</h2>

		<span class="flex gap-2">
			<a href="<?php echo base_url('index.php/Accounts/add_receipt'); ?>"
				class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 hover:bg-blue-200 transition"
				title="Add New Record">
				Add New Record
			</a>

			<a href="<?php echo base_url('index.php/Accounts/view_receipt_list'); ?>"
				class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 hover:bg-blue-200 transition"
				title="List Records">
				List Records
			</a>
		</span>

	</div>


	<div class="overflow-x-auto">
		<table id="datatable" class="min-w-full text-sm border border-gray-200">
			<thead class="bg-gray-100 text-gray-700 uppercase text-xs">
				<tr>
					<th class="px-4 py-3 text-left">Sr. No</th>
					<th class="px-4 py-3 text-left">Trans Code</th>
					<th class="px-4 py-3 text-left">Date</th>
					<th class="px-4 py-3 text-right">Amount</th>
					<th class="px-4 py-3 text-left">Narration</th>
					<th class="px-4 py-3 text-center">Action</th>
				</tr>
			</thead>

			<tbody class="divide-y divide-gray-200">
				<?php $i = 1;
				foreach ($receipt as $row): ?>
					<tr class="<?= ($row->cancel == 1) ? 'bg-red-50 text-red-700' : 'hover:bg-gray-50' ?>">

						<!-- Sr No -->
						<td class="px-4 py-3">
							<?= $i++ ?>
						</td>

						<!-- Trans Code -->
						<td class="px-4 py-3 font-medium text-blue-600">
							<a target="_blank"
								href="<?= base_url('index.php/Accounts/view_account_transaction_details/' . $row->voucher_id) ?>"
								class="hover:underline">
								<?= $row->voucher_code ?>
							</a>
						</td>

						<!-- Date -->
						<td class="px-4 py-3 text-gray-700">
							<?= date('d-M-Y', strtotime($row->voucher_date)) ?>
						</td>

						<!-- Amount -->
						<td class="px-4 py-3 text-right font-semibold text-gray-800">
							<?= number_format($row->amount, 2) ?>
						</td>

						<!-- Narration -->
						<td class="px-4 py-3 text-gray-700">
							<?= $row->narration ?>
						</td>

						<!-- Action -->
						<td>
							<div class="flex items-center gap-3">

								<a target="_blank" href="<?php echo base_url('index.php/Accounts/print_receipt/' . $row->voucher_code); ?>"
									class="text-blue-600 hover:text-blue-800 font-medium">
									Print
								</a>

								<?php if ($row->cancel == 0): ?>
									<a href="javascript:confirmcancel('<?= $row->voucher_code ?>')"
										title="Delete"
										class="p-1 rounded-full hover:bg-red-100 text-red-600 hover:text-red-800 transition">

										<!-- Trash Icon -->
										<svg xmlns="http://www.w3.org/2000/svg"
											class="w-5 h-5"
											fill="none"
											viewBox="0 0 24 24"
											stroke="currentColor">
											<path stroke-linecap="round"
												stroke-linejoin="round"
												stroke-width="2"
												d="M19 7l-1 12a2 2 0 01-2 2H8a2 2 0 01-2-2L5 7m5-3h4a2 2 0 012 2v1H8V6a2 2 0 012-2z" />
										</svg>
									</a>
								<?php else: ?>
									<span class="text-red-500 font-semibold">Cancelled</span>
								<?php endif; ?>

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
