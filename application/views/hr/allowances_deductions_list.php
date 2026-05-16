<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-xl shadow p-6">


	<div class="bg-white rounded-xl shadow p-6">
 <div class="flex justify-between items-center mb-4">
       <h2 class="text-xl font-semibold text-gray-700"> Allowances & Deductions List </h2> 
	   <!-- List Button -->
		 <a href="<?= base_url('index.php/Hr/add_allowances') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium"> Add Allowances & Deductions </a>
    </div>

		<div class="overflow-x-auto">
			<table id="datatable" class="min-w-full border border-gray-200">

				<thead class="bg-gray-100">
					<tr>
						<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border">Sr No</th>
						<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border">Allowances Type</th>
						<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border">Allowance Name</th>
						<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border">Action</th>
					</tr>
				</thead>

				<tbody>

					<?php $i = 1;
					foreach ($records as $row) { ?>
						<tr class="hover:bg-gray-50">

							<td class="px-4 py-3 border"><?php echo $i;
															$i++; ?></td>

							<td class="px-4 py-3 border">
								<?php echo ($row->allowance_type == 'A') ? "Allowances" : (($row->allowance_type == 'D') ? "Deductions" : ""); ?>
							</td>

							<td class="px-4 py-3 border"><?php echo $row->allowance_name; ?></td>

							<td class="px-4 py-3 border">

								<a href="<?php echo base_url() . 'index.php/Hr/edit_allowances/' . $row->sno; ?>"
									class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
									Edit
								</a>

								<a href="<?php echo base_url() . 'index.php/Hr/delete_Allowances/' . $row->sno; ?>"
									onclick="return confirmcancel(<?php echo $row->sno; ?>);"
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



</div>


<!-- Static Table End -->

<script>
$(document).ready(function () {
    $('#datatable').DataTable({
        "pageLength": 10
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
					table_name: 'allowance_master',
					where_key: 'sno',
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
