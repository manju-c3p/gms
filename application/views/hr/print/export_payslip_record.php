<?php
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
$month = date('M_Y');
if (!empty($records)) {
    $month = date('M_Y', strtotime($records[0]->salary_month));
}

header("Content-Disposition: attachment;filename=salary_report_" . $month . ".xls");
// header("Content-Disposition: attachment;filename=monthly_salary_record.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<html>
<body>

<table width="100%" border="0">
    <tr align="center">
        <td>
            <b style="font-size:16px;">Monthly Salary Report</b>
        </td>
    </tr>
</table>

<table width="100%" border="0">
    <tr>
        <td><b>Date:</b> <?= date('d-M-Y'); ?></td>
    </tr>
</table>

<br>

<table width="100%" border="1" cellspacing="0">
    <thead>
        <tr style="background:#f2f2f2;">
            <th>Sr No</th>
            <th>Employee Name</th>
            <th>Salary Month</th>
            <th>Working Days</th>
            <th>Total Leave</th>
            <th>Present Days</th>
            <th>Paid Leave</th>
            <th>Payment Days</th>
            <th>Basic Salary</th>
            <th>Total Allowances</th>
            <th>Total Deduction</th>
            <th>Gross Pay</th>
            <th>Net Pay</th>
            <th>Remarks</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $i = 1;
        $total_net = 0;

        foreach ($records as $row) { 
            $total_net += $row->net_salary;
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $row->employee_name ?></td>
            <td><?= date('M-Y', strtotime($row->salary_month)); ?></td>
            <td><?= $row->working_days ?></td>
            <td><?= $row->leave_days ?></td>
            <td><?= $row->present_days ?></td>
            <td><?= $row->paid_leave ?></td>
            <td><?= $row->payment_days ?></td>

            <td><?= number_format($row->basic_salary, 2); ?></td>
            <td><?= number_format($row->total_allowance, 2); ?></td>
            <td><?= number_format($row->total_deduction, 2); ?></td>
            <td><?= number_format($row->gross_salary, 2); ?></td>

            <td style="mso-number-format:'0.00';">
                <?= number_format($row->net_salary, 2); ?>
            </td>

            <td><?= $row->remark ?></td>
        </tr>
        <?php } ?>

        <!-- TOTAL -->
        <tr>
            <td colspan="12" align="right"><b>Total Net Pay</b></td>
            <td><b><?= number_format($total_net, 2); ?></b></td>
            <td></td>
        </tr>

    </tbody>
</table>

</body>
</html>
