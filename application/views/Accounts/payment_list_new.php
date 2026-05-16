<div class="bg-white shadow rounded-xl px-6 py-4 mb-4">

	<div class="flex items-center justify-between">

		<!-- Left: Title -->
		<h1 class="text-xl font-semibold text-gray-800">
			Payment Entry
		</h1>

		<!-- Right: Buttons -->
		<div class="flex gap-2">

			<a href="<?php echo base_url('index.php/accounts/add_payment_new'); ?>"
				class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-200">
				Add New Record
			</a>

			<a href="<?php echo base_url('index.php/accounts/view_payment_list_new'); ?>"
				class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-200">
				List Records
			</a>

		</div>

	</div>

</div>
<div class="bg-white shadow rounded-xl p-6">

	<div class="overflow-x-auto">
		<table id="datatable" class="min-w-full border border-gray-200 rounded-lg text-sm">

			<thead class="bg-gray-100">
				<tr>
					<th class="px-3 py-2 text-left">Sr.no</th>
					<th class="px-3 py-2 text-left">Trans Code</th>
					<th class="px-3 py-2 text-left">Date</th>
					<th class="px-3 py-2 text-left">Amount</th>
					<th class="px-3 py-2 text-left">Narration</th>
					<th class="px-3 py-2 text-left">Action</th>
				</tr>
			</thead>

			<tbody>
				<?php $i = 1;
				foreach ($receipt as $row) : ?>

					<tr class="border-t <?php if ($row->cancel == 1) {
											echo 'bg-red-100';
										} ?> hover:bg-gray-50">

						<td class="px-3 py-2">
							<?php echo $i;
							$i++; ?>
						</td>

						<td class="px-3 py-2">
							<a target="_blank"
								href="<?php echo base_url() . 'index.php/Accounts/view_account_transaction_details/' . $row->voucher_id; ?>"
								class="text-blue-600 hover:underline">
								<?php echo $row->voucher_code; ?>
							</a>
						</td>

						<td class="px-3 py-2">
							<?php echo date('d-M-Y', strtotime($row->voucher_date)); ?>
						</td>

						<td class="px-3 py-2">
							<?php echo $row->amount; ?>
						</td>

						<td class="px-3 py-2">
							<?php echo $row->narration; ?>
						</td>

						<td class="px-3 py-2">

							<?php if ($row->cancel == 0) { ?>

								<a href="javascript:confirmcancel('<?php echo $row->voucher_code; ?>')"
									title="Delete"
									class="text-red-600 hover:text-red-800 text-lg">

									<i class="fa fa-trash"></i>

								</a>

							<?php } else { ?>
								<span class="text-red-500 font-medium">Cancelled</span>
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