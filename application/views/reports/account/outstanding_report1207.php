<div class="card-body">
    <form class="form-horizontal" action="<?php echo base_url('index.php/accounts/search_outstanding_report'); ?>" method="post" id="receipt" name="receipt">
        <div class="form-group row align-items-center">
            <label class="col-form-label col-lg-1">As on date</label>
            <div class="col-lg-3">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm datepicker1" name="voucher_date" id="voucher_date"
                           value="<?php echo isset($voucher_date) ? $voucher_date : date('d-M-Y'); ?>" required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <label class="col-form-label col-lg-1">Type</label>
            <div class="col-lg-3">
                <select class="form-select form-control-sm select2" name="request_type" id="request_type" onchange="submitForm()">
                    <option value="">Please select type</option>
                    <option value="Sundry Creditors" <?php if ($request_type == 'Sundry Creditors') echo 'selected'; ?>>Sundry Creditors</option>
                    <option value="Sundry Debtors" <?php if ($request_type == 'Sundry Debtors') echo 'selected'; ?>>Sundry Debtors</option>
                </select>
            </div>
            <div class="col-lg-4">
                <button type="submit" class="btn btn-sm btn-primary">Go</button>
                <button type="button" class="btn btn-sm btn-warning" onclick="submitPrint()">Print</button>
                <button type="button" class="btn btn-sm btn-warning" onclick="submitExport()">Export to Excel</button>
            </div>
        </div>
    </form>
</div>

<div class="dt-responsive table-responsive">
    <table class="table table-bordered nowrap">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>
                    <?php echo ($request_type == 'Sundry Creditors') ? 'Supplier Name' : 'Customer Name'; ?>
                </th>
                <th>Ref. No</th>
                <th>Amount</th>
                <th>Pending</th>
                <th>Due On</th>
                <th>Overdue Days</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        if (!empty($records)) {
            foreach ($records as $row) { ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo date('d-M-Y', strtotime($row->voucher_date)); ?></td>
                    <td>
                        <a target="_blank" href="<?php echo base_url('index.php/accounts/outstanding_report_by_individual_ledger/' . $row->account_id); ?>">
                            <?php 
                            // Display appropriate name
                            echo ($request_type == 'Sundry Creditors') ? $row->account_name : $row->cust_name; 
                            ?>
                        </a>
                    </td>
                    <td><?php echo $row->voucher_code; ?></td>
                    <td><?php echo number_format($row->sum_amt, 2); ?></td>
                    <td><?php echo number_format($row->sum_due_amt, 2); ?></td>
                    <td><?php echo date('d-M-Y', strtotime('+3 months', strtotime($row->voucher_date))); ?></td>
                    <td>
                        <?php 
                        $due_date = strtotime('+3 months', strtotime($row->voucher_date));
                        $today = strtotime(date('Y-m-d'));
                        echo ($today > $due_date) ? floor(($today - $due_date) / 86400) : '-';
                        ?>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="8">No records found.</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
function submitForm() {
    document.getElementById('receipt').submit();
}

function submitPrint() {
    const form = document.createElement('form');
    form.method = 'post';
    form.action = "<?php echo base_url('index.php/Accounts/print_outstanding_report'); ?>";
    form.target = '_blank';
    form.innerHTML = `
        <input type="hidden" name="voucher_date" value="<?php echo $voucher_date; ?>">
        <input type="hidden" name="request_type" value="<?php echo $request_type; ?>">
    `;
    document.body.appendChild(form);
    form.submit();
}

function submitExport() {
    const form = document.createElement('form');
    form.method = 'post';
    form.action = "<?php echo base_url('index.php/Accounts/export_outstanding_report_details'); ?>";
    form.innerHTML = `
        <input type="hidden" name="voucher_date" value="<?php echo $voucher_date; ?>">
        <input type="hidden" name="request_type" value="<?php echo $request_type; ?>">
    `;
    document.body.appendChild(form);
    form.submit();
}
</script>
