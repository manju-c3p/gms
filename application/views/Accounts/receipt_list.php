<div class="bg-white rounded-xl shadow p-4">
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
                <?php $i = 1; foreach ($receipt as $row): ?>
                <tr class="<?= ($row->cancel == 1) ? 'bg-red-50 text-red-700' : 'hover:bg-gray-50' ?>">

                    <!-- Sr No -->
                    <td class="px-4 py-3">
                        <?= $i++ ?>
                    </td>

                    <!-- Trans Code -->
                    <td class="px-4 py-3 font-medium text-blue-600">
                        <a target="_blank"
                           href="<?= base_url('index.php/Accounts/view_account_transaction_details/'.$row->voucher_id) ?>"
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
                    <td class="px-4 py-3 text-center space-x-2">
                        <a target="_blank"
                           href="<?= base_url('index.php/Accounts/print_receipt/'.$row->voucher_code) ?>"
                           class="text-blue-600 hover:underline">
                            Print
                        </a>

                        <?php if ($row->cancel == 0): ?>
                            <a href="javascript:confirmcancel('<?= $row->voucher_code ?>')"
                               title="Delete"
                               class="text-red-600 hover:underline">
                                <?= $this->session->userdata('delete_icon'); ?>
                            </a>
                        <?php else: ?>
                            <span class="text-red-500 font-semibold">Cancelled</span>
                        <?php endif; ?>
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
