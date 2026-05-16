<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">
	<h1 class="text-xl font-medium text-gray-700">Expense List</h1>

	<a href="<?php echo base_url('index.php/Accounts/expense_entry'); ?>"
		class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
		+ New Expense
	</a>


</div>

<div class="bg-white shadow rounded-xl p-5 overflow-x-auto">

	<table id="invoiceTable" class="w-full text-sm border border-gray-300">

		<thead class="bg-gray-100">
			<tr>
				<th class="border p-2">Code & Date</th>
				<!-- <th class="border p-2">Date</th> -->
				<th class="border p-2">Ledger name</th>
				<th class="border p-2">Description</th>
				<th class="border p-2 text-right">Amount</th>
				<th class="border p-2">Payment</th>

				<th class="border p-2">Remarks</th>
				<th class="border p-2 text-center">Attachment</th>
				<th class="border p-2 text-center">Action</th>
			</tr>
		</thead>

		<tbody>

			<?php if (!empty($expenses)) {
				foreach ($expenses as $e) { ?>

					<tr class="hover:bg-gray-50">

						<td class="border p-2 "><b><?php echo $e->expense_code ?></b>
									<br>
							<span  style="font-size: 12px;"><?php echo date('d-M-Y', strtotime($e->expense_date)); ?></span>
						</td>

						
						<td class="border p-2"><?php echo $e->ledger_name ?></td>
						<td class="border p-2"><?php echo $e->description ?></td>

						<td class="border p-2 text-right">
							<?php echo number_format($e->amount, 2); ?>
						</td>

						<td class="border p-2"><?php echo $e->payment_mode ?></td>



						<td class="border p-2"><?php echo $e->remarks ?></td>

						<td class="border p-2 text-center">
							<?php
							$doc = $this->db->where('expense_id', $e->expense_id)
								->get('expense_documents')
								->row();
							if ($doc) {
							?>
								<a href="<?php echo base_url('uploads/expenses/' . $doc->doc_path); ?>"
									target="_blank"
									class="text-blue-600 underline">
									View
								</a>
							<?php } ?>
						</td>

						<td class="border p-2 text-center space-x-2">

							<a href="<?php echo base_url('index.php/Accounts/edit_expense/' . $e->expense_id); ?>"
								class="text-green-600 font-semibold">Edit</a>

							<a href="<?php echo base_url('index.php/Accounts/delete_expense/' . $e->expense_id); ?>"
								onclick="return confirm('Delete this expense?')"
								class="text-red-600 font-semibold">Delete</a>
							<a href="<?php echo base_url('index.php/Accounts/print_expense/' . $e->expense_id); ?>"
								target="_blank"
								class="text-blue-600 font-semibold">Print</a>

						</td>


					</tr>

			<?php }
			} ?>

		</tbody>

	</table>

</div>

<script>
	$(document).ready(function() {

		$('#invoiceTable').DataTable({
			pageLength: 10,
			lengthMenu: [
				[5, 10, 25, -1],
				[5, 10, 25, "All"]
			],
			responsive: true,

			// Move search box to the RIGHT
			dom: "<'flex justify-between items-center mb-3'l<f>>" +
				"t" +
				"<'flex justify-between items-center mt-3'p>",

			language: {
				search: "",
				searchPlaceholder: "Search ..."
			}
		});

	});
</script>
