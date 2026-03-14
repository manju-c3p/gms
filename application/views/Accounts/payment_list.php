
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<div class="bg-white rounded-2xl shadow-lg p-6">
	<div class="overflow-x-auto">
		<table id="datatable"
			   data-toggle="data-table"
			   class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-xl">

			<thead class="bg-gray-50 text-gray-800 uppercase text-xs tracking-wider">
				<tr>
					<th class="px-4 py-3 border-b text-left font-semibold">Sr.no</th>
					<th class="px-4 py-3 border-b text-left font-semibold">Trans Code</th>
					<th class="px-4 py-3 border-b text-left font-semibold">Date</th>
					<th class="px-4 py-3 border-b text-left font-semibold">Amount</th>
					<th class="px-4 py-3 border-b text-left font-semibold">Narration</th>
					<th class="px-4 py-3 border-b text-left font-semibold">Action</th>
				</tr>
			</thead>

			<tbody class="divide-y divide-gray-100 bg-white">
				<?php $i = 1;
				foreach ($receipt as $row) : ?>
					<tr class="<?php echo ($row->cancel == 1) ? 'bg-red-50' : 'hover:bg-gray-50 transition duration-150'; ?>">

						<td class="px-4 py-3 whitespace-nowrap">
							<?php echo $i; $i++; ?>
						</td>

						<td class="px-4 py-3 whitespace-nowrap">
							<a target="_blank"
							   href="<?php echo base_url() . 'index.php/Accounts/view_account_transaction_details/' . $row->voucher_id; ?>"
							   title="details"
							   class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
								<?php echo $row->voucher_code; ?>
							</a>
						</td>

						<td class="px-4 py-3 whitespace-nowrap">
							<?php echo date('d-M-Y', strtotime($row->voucher_date)); ?>
						</td>

						<td class="px-4 py-3 whitespace-nowrap font-semibold text-gray-900">
							<?php echo $row->amount; ?>
						</td>

						<td class="px-4 py-3">
							<?php echo $row->narration; ?>
						</td>

						<td class="px-4 py-3 whitespace-nowrap space-x-4">
							<a target="_blank"
							   href="<?php echo base_url() . 'index.php/Accounts/printpayment/' . $row->voucher_code; ?>"
							   class="text-indigo-600 hover:text-indigo-800 font-medium hover:underline">
								Print
							</a>

							<?php if ($row->cancel == 0) { ?>
								<a href="javascript:confirmcancel('<?php echo $row->voucher_code; ?>')"
								   title="Delete"
								   class="text-red-600 hover:text-red-800 font-medium"
								   id="delete">
									<?php echo $this->session->userdata('delete_icon'); ?>
								</a>
							<?php } else { ?>
								<span class="text-red-600 font-semibold">Cancelled</span>
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
$(document).ready(function () {
	$('#datatable').DataTable({
		pageLength: 10,
		lengthMenu: [10, 25, 50, 100],
		order: [[0, 'asc']],   // Sr.no
		searching: true,
		paging: true,
		info: true,
		autoWidth: false,
		responsive: true,
		columnDefs: [
			{ orderable: false, targets: -1 } // Disable sorting on Action column
		]
	});
});
</script>

