<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=export_monthly_salary_record.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<html>

<body>
    <table width="100%" border=0 cellspacing="0" colspacing="0">
        <tr align="center">
            <td>
                <p style="font-size:16px; font-weight:bold;">Monthly Salary Record</p>
            </td>

        </tr>
    </table>
    <table width="100%" border=1 cellspacing="0" colspacing="0">
        <tr align="left">
            <th>Todays Date : <?php echo date('d-M-Y'); ?></th>
        </tr>
    </table>
    <br>
    <table width='100%' border=1 cellspacing="0" colspacing="0">
        <thead>
            <tr>
            <th>Sr No</th>
                    <th>Employee Name</th>
                    <th>Salary Month</th>
                    <th>Working Days</th>
                    <th>Total Leave</th>
                    <th>Present Days</th>
                    <th>Paid Leave</th>
                    <th>Payment Days</th>
                    <th>Total Overtime(hour)</th>
                    <th>Overtime Amt</th>
                    <th>Basic Salary</th>
                    <th>Total Allowances</th>
                    <th>Total Deduction</th>
                    <th>Gross pay</th>
                    <th>Net pay</th>
                    <th>Remarks</th>
                    <th>Action</th>

            </tr>
        </thead>

        <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td><?php echo $row->user_name; ?></td>
                        <td><?php echo date('M-Y', strtotime($row->salary_month)); ?></td>
                		<td><?php echo $row->working_days; ?></td>
                		<td><?php echo $row->leave_days; ?></td>
                		<td><?php echo $row->present_days; ?></td>
                		<td><?php echo $row->paid_leave; ?></td>
                		<td><?php echo $row->payment_days; ?></td>
                		<td><?php echo $row->overtime; ?></td>
                        <td><?php echo $row->overtime_amt; ?></td>
                		<td><?php echo $row->basic_salary; ?></td>
                        <td><?php echo $row->total_allowance; ?></td>
                        <td><?php echo $row->total_deduction; ?></td>
                        <td><?php echo $row->gross_salary; ?></td>
                        <td><?php echo $row->net_salary; ?></td>
                        <td><?php echo $row->remark; ?></td>
                        
                    </tr>
                <?php  } ?>
            </tbody>
    </table>
</body>

</html>