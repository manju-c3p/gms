<table class="table table-bordered table-hover" id="dr_table">
    <thead>
        <tr>
            <th width='10%'>Select</th>
            <th title="Item">GRN Date</th>
            <th title="Item">GRN No</th>
            <th title="Item">Amount</th>
            <th title="Item">Balance</th>
            <th title="Item"> Credit Amount </th>
        </tr>
    </thead>
    <tbody id="dr_body">
        <tr>
            <td colspan="6"><input type="hidden" name="selected_tr" id="selected_tr"></td>
        </tr>
        <?php foreach ($records1 as $r) { ?>
            <tr id='dr_addr0'>
                <td>
                    <input 
                        type="checkbox" 
                        id="invoiceID" 
                        class="case" 
                        name="invoiceID[]" 
                        data-invoice-code="<?= htmlspecialchars($r->grn_code) ?>" 
                        value="<?= $r->grn_id ?>" 
                        onclick="p_check();" 
                    />
                </td>
                <td><?= htmlspecialchars($r->grn_date) ?></td>
                <td>
                    <?= htmlspecialchars($r->grn_code) ?>
                    <input type="hidden" name="grn_code[<?= $r->grn_id ?>]" value="<?= htmlspecialchars($r->grn_code) ?>" />
                </td>
                <td><?= number_format($r->grand_total, 2) ?></td>
                <td><?= number_format(($r->pending_amount), 2) ?></td>
                <td>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="dr_amount[<?php echo $r->grn_id; ?>]"
                        id="dr_amount<?= $r->grn_id ?>" 
                        class="form-control form-control-sm debit_sum" 
                        required 
                        min="0" 
                        max="<?= ($r->grand_total - $r->paid_amt) ?>" 
                        onkeyup="calculate_grand_total()" 
                    >
                    <input type="hidden" name="customer_id" id="customer_id" value="<?= $r->supplier_id ?>" > 
                </td>
            </tr>
        <?php } ?>
        <tr id='dr_addr1'></tr>
    </tbody>
</table>
