<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="bg-white rounded-2xl shadow-md border border-gray-200 p-4 mt-4">

    <div class="overflow-x-auto">
        <table id="dr_table" class="min-w-full text-sm">

            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <th class="px-4 py-3 text-left">Select</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Account</th>
                    <th class="px-4 py-3 text-left">Instrument Date</th>
                    <th class="px-4 py-3 text-left">Instrument No</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                    <th class="px-4 py-3 text-left">Bank Date</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                <?php foreach ($records as $r) { ?>
                    <tr class="hover:bg-gray-50 transition">

                        <!-- Checkbox -->
                        <td class="px-4 py-3">
                            <input type="checkbox"
                                name="inv_id[]"
                                value="<?php echo $r->voucher_id; ?>"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                        </td>

                        <!-- Date -->
                        <td class="px-4 py-3 text-gray-700">
                            <?php echo date('d-m-Y', strtotime($r->voucher_date)); ?>
                        </td>

                        <!-- Account -->
                        <td class="px-4 py-3 font-medium text-gray-800">
                            <?php echo $r->account_name; ?>
                        </td>

                        <!-- Instrument Date -->
                        <td class="px-4 py-3 text-gray-600">
                            <?php echo date('d-m-Y', strtotime($r->voucher_date)); ?>
                            <input type="hidden"
                                name="instrument_dates[<?php echo $r->voucher_id; ?>]"
                                value="<?php echo $r->voucher_date; ?>">
                        </td>

                        <!-- Instrument Number -->
                        <td class="px-4 py-3 text-gray-600">
                            <?php echo $r->transaction_no; ?>
                            <input type="hidden"
                                name="instrument_nos[<?php echo $r->voucher_id; ?>]"
                                value="<?php echo $r->transaction_no; ?>">
                        </td>

                        <!-- Amount -->
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">
                            ₹ <?php echo number_format($r->amount, 2); ?>
                            <input type="hidden"
                                name="deposit_amounts[<?php echo $r->voucher_id; ?>]"
                                value="<?php echo $r->amount; ?>">
                        </td>

                        <!-- Bank Date -->
                        <td class="px-4 py-2">
                            <input type="date"
                                name="bank_dates[<?php echo $r->voucher_id; ?>]"
                                value="<?php echo $r->bank_date; ?>"
                                class="border border-gray-300 rounded-lg px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none w-full">
                        </td>

                    </tr>
                <?php } ?>

            </tbody>

        </table>
    </div>

</div>

<script>
	$(document).ready(function() {
		$('#dr_table').DataTable({
			pageLength: 10
		});
	});
</script>
