<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-xl shadow p-6">

	<div class="flex justify-between items-center mb-4">
		<h2 class="text-xl font-semibold text-gray-700"> Holiday List </h2>
		<!-- List Button -->
		<a href="<?= base_url('index.php/Hr/holiday') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium"> Add Holidays </a>
	</div>

	<div class="overflow-x-auto">
		<table id="datatable" class="min-w-full border border-gray-200">

			<thead class="bg-gray-100">
				<tr>
					<th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Sr No</th>
					<th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Holiday Code</th>
					<th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Holiday Name</th>
					<th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Holiday Date</th>
					<th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Action</th>
				</tr>
			</thead>

			<tbody>

				<?php $i = 1;
				foreach ($records as $row) { ?>
					<tr class="hover:bg-gray-50">

						<td class="px-4 py-3 border">
							<?php echo $i;
							$i++; ?>
						</td>

						<td class="px-4 py-3 border">
							<?php echo $row->holiday_code; ?>
						</td>

						<td class="px-4 py-3 border">
							<?php echo $row->holiday_name; ?>
						</td>

						<td class="px-4 py-3 border">
							<?php echo date('d-M-Y', strtotime($row->h_date)); ?>
						</td>

						<td class="px-4 py-3 border">

							<a href="<?php echo base_url() . 'index.php/Hr/edit_holiday_data/' . $row->holiday_id; ?>"
								class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
								Edit
							</a>

							<a href="<?php echo base_url() . 'index.php/Hr/delete_holiday_data/' . $row->holiday_id; ?>"
								onclick="return confirmcancel(<?php echo $row->holiday_id; ?>);"
								class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-2">
								Delete
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
	$(document).ready(function() {
		$('#datatable').DataTable({
			pageLength: 10
		});
	});
</script>

<script>
	function confirmcancel(tid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'holiday_master',
					where_key: 'holiday_id',
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
