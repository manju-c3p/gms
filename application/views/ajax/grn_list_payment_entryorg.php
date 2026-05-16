<div class="w-full overflow-x-auto">
    <table id="dr_table" class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">

        <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
            <tr>
                <th class="px-3 py-2 border w-[10%]">Select</th>
                <th class="px-3 py-2 border">GRN Date</th>
                <th class="px-3 py-2 border">GRN No</th>
                <th class="px-3 py-2 border text-right">Amount</th>
                <th class="px-3 py-2 border text-right">Balance</th>
                <th class="px-3 py-2 border">Credit Amount</th>
            </tr>
        </thead>

        <tbody id="dr_body" class="divide-y divide-gray-200">

            <tr>
                <td colspan="6" class="px-3 py-2">
                    <input type="hidden" name="selected_tr" id="selected_tr">
                </td>
            </tr>

            <?php foreach ($records1 as $r) { ?>
            <tr id="dr_addr0" class="hover:bg-gray-50 transition">

                <!-- Checkbox -->
                <td class="px-3 py-2 border text-center">
                    <input 
                        type="checkbox"
                        id="invoiceID"
                        class="case h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        name="invoiceID[]"
                        data-invoice-code="<?= htmlspecialchars($r->grn_code) ?>"
                        value="<?= $r->grn_id ?>"
                        onclick="p_check();"
                    />
                </td>

                <!-- GRN Date -->
                <td class="px-3 py-2 border">
                    <?= htmlspecialchars($r->grn_date) ?>
                </td>

                <!-- GRN Code -->
                <td class="px-3 py-2 border font-medium text-gray-800">
                    <?= htmlspecialchars($r->grn_code) ?>
                    <input type="hidden" name="grn_code[<?= $r->grn_id ?>]" value="<?= htmlspecialchars($r->grn_code) ?>">
                </td>

                <!-- Amount -->
                <td class="px-3 py-2 border text-right font-medium">
                    <?= number_format($r->grand_total, 2) ?>
                </td>

                <!-- Balance -->
                <td class="px-3 py-2 border text-right font-semibold text-red-600">
                    <?= number_format($r->pending_amount, 2) ?>
                </td>

                <!-- Credit Amount -->
                <td class="px-3 py-2 border">
                    <input 
                        type="number"
                        step="0.01"
                        name="dr_amount[<?= $r->grn_id ?>]"
                        id="dr_amount<?= $r->grn_id ?>"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 debit_sum"
                        required
                        min="0"
                        max="<?= ($r->grand_total - $r->paid_amt) ?>"
                        onkeyup="calculate_grand_total()"
                    >

                    <input type="hidden" name="customer_id" id="customer_id" value="<?= $r->supplier_id ?>">
                </td>

            </tr>
            <?php } ?>

            <tr id="dr_addr1"></tr>

        </tbody>

    </table>
</div>
