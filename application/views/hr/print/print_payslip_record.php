<html>
<head>
    <title>Monthly Salary Report</title>

    <style>
        @page {
            margin: 10mm 10mm 25mm 10mm;

            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
            }

            @bottom-left {
                content: "©<?php echo date('Y'); ?>";
            }
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f5f5f5;
        }

        .right {
            text-align: right;
        }

        /* HEADER */
        .invoice-header td {
            vertical-align: middle;
            padding: 10px;
            border: none;
        }

        .logo-cell {
            text-align: center;
        }

        .logo-cell img {
            max-height: 70px;
        }

        .company-cell {
            font-size: 14px;
            line-height: 1.6;
            text-align: right;
        }
    </style>
</head>

<body>

<!-- 🔥 HEADER -->
<table class="invoice-header">
    <tr>
        <td width="20%" class="logo-cell">
            <img src="<?= base_url('public/images/logocooling.png') ?>" alt="Logo">
        </td>

        <td width="80%" class="company-cell">
            <strong>Cool Runnings Garage Co LLC</strong><br>
            7 St, Al Quoz 3, Dubai, UAE<br>
            www.coolrunningsgarage.com<br>
            info@coolrunningsgarage.com<br>
            Tel: +971 4 265 4887<br>
            TRN: 104026094300003
        </td>
    </tr>
</table>

<!-- 🔥 TITLE ROW -->
<table style="margin-top:10px;">
    <tr>
        <td width="40%" style="border:none;">
            <b>Report:</b> Monthly Salary
        </td>

        <td width="20%" style="border:none; text-align:center; font-size:16px;">
            <b>MONTHLY SALARY REPORT</b>
        </td>

        <td width="40%" style="border:none; text-align:right;">
            <b>Date:</b> <?= date('d-M-Y'); ?>
        </td>
    </tr>
</table>

<br>

<!-- 🔥 MAIN TABLE -->
<table>
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

        foreach ($records as $row): 
            $total_net += $row->net_salary;
        ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row->employee_name ?></td>
                <td><?= date('M-Y', strtotime($row->salary_month)) ?></td>
                <td><?= $row->working_days ?></td>
                <td><?= $row->leave_days ?></td>
                <td><?= $row->present_days ?></td>
                <td><?= $row->paid_leave ?></td>
                <td><?= $row->payment_days ?></td>
                <td><?= $row->basic_salary ?></td>
                <td><?= $row->total_allowance ?></td>
                <td><?= $row->total_deduction ?></td>
                <td><?= $row->gross_salary ?></td>
                <td class="right"><?= $row->net_salary ?></td>
                <td><?= $row->remark ?></td>
            </tr>
        <?php endforeach; ?>

        <!-- 🔥 TOTAL -->
        <tr>
            <td colspan="12" class="right"><strong>Total Net Pay:</strong></td>
            <td class="right"><strong><?= number_format($total_net, 2); ?></strong></td>
            <td></td>
        </tr>
    </tbody>
</table>

</body>
</html>
