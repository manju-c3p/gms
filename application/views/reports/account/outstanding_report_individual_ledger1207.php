<div class="card-body">
    <form class="form-horizontal" action="<?php echo base_url(); ?>" id="receipt" method="post" name="receipt">
        <div class="form-group row align-items-center">
            <label class="col-lg-1 col-form-label">As on date</label>
            <div class="col-lg-3">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" value="<?php echo date('d-M-Y'); ?>" required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <label class="col-lg-1 col-form-label">Type</label>
            <div class="col-lg-3">
                <select class="form-select form-control-sm select2" name="request_type" id="request_type" disabled>
                    <option value="">Please select type</option>
                    <option value="Sundry Creditors">Sundry Creditors</option>
                    <option value="Sundry Debtors" selected>Sundry Debtors</option>
                </select>
            </div>
            <label class="col-lg-1 col-form-label">Customer Name</label>
            <div class="col-lg-3">
                <?php if (!empty($records)) : ?>
                    <input type="text" class="form-control" name="cust_name" value="<?php echo $records[0]->cust_name; ?>" readonly style="font-weight: bold;">
                <?php endif; ?>
            </div>
        </div>

        <div class="dt-responsive table-responsive">
            <table class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>Srn</th>
                        <th>Date</th>
                        <th>Ref.No</th>
                        <th>Amount</th>
                        <th>Pending Amount</th>
                        <th>Due On</th>
                        <th>OverDue By Days</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; if (!empty($records)):
                    foreach ($records as $row) :
                        $due_date = strtotime('+3 months', strtotime($row->voucher_date));
                        $today = strtotime(date('d-M-Y'));
                        $overdue_days = max(0, floor(($today - $due_date) / (60 * 60 * 24)));
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo date('d-M-Y', strtotime($row->voucher_date)); ?></td>
                        <td><?php echo $row->voucher_code; ?></td>
                        <td><?php echo $row->amount; ?></td>
                        <td><?php echo $row->due_amount; ?></td>
                        <td><?php echo date('d-M-Y', $due_date); ?></td>
                        <td><?php echo $overdue_days > 0 ? $overdue_days : '-'; ?></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <div class="header-title">
            <h4 class="card-title">Ageing Details</h4>
        </div>
        <br>
        <div class="dt-responsive table-responsive">
            <table class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>0-30 day(s)</th>
                        <th>31-60 day(s)</th>
                        <th>61-90 day(s)</th>
                        <th>91-120 day(s)</th>
                        <th>>120 day(s)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $ageing = array_fill_keys(['0-30', '31-60', '61-90', '91-120', '>120', 'Total'], 0);
                    if (!empty($records)):
                        foreach ($records as $row) :
                            $overdue_days = max(0, floor((strtotime(date('d-M-Y')) - strtotime('+3 months', strtotime($row->voucher_date))) / (60 * 60 * 24)));
                            if ($overdue_days <= 30) {
                                $ageing['0-30'] += $row->due_amount;
                            } elseif ($overdue_days <= 60) {
                                $ageing['31-60'] += $row->due_amount;
                            } elseif ($overdue_days <= 90) {
                                $ageing['61-90'] += $row->due_amount;
                            } elseif ($overdue_days <= 120) {
                                $ageing['91-120'] += $row->due_amount;
                            } else {
                                $ageing['>120'] += $row->due_amount;
                            }
                            $ageing['Total'] += $row->due_amount;
                        endforeach;
                    endif; 
                    ?>
                    <tr>
                    <td><?php echo number_format($ageing['0-30'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['31-60'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['61-90'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['91-120'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['>120'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['Total'], 3, '.', ''); ?></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </form>
</div>
</div>

