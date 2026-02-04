<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-xl shadow p-4">
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
							<?php echo $i; $i++; ?>
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

						<td class="px-3 py-2 border space-x-2">
							<a href="<?php echo base_url() . 'index.php/Accounts/edit_bank_reconciliation/' . $row->reconciliation_id; ?>"
							   title="Edit"
							   class="text-blue-600 hover:text-blue-800">
								<?php echo $this->session->userdata('edit_icon'); ?>
							</a>

							<a href="javascript:confirmcancel(<?php echo $row->reconciliation_id; ?>)"
							   title="Delete"
							   class="text-red-600 hover:text-red-800"
							   id="delete">
								<?php echo $this->session->userdata('delete_icon'); ?>
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
