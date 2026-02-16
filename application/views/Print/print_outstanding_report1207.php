<?php
//echo "<pre>"; print_r($request_type ); exit;
foreach ($comapny_records as $row1) {
    $company_name = $row1->company_name;
    $company_add1 = $row1->company_address;
    $company_city = $row1->company_city;
    $company_pin = $row1->company_pincode;
    $company_state = $row1->company_state;
    $company_website = $row1->company_website;
    $company_email = $row1->company_email_id;
    $company_telephone = $row1->company_telephone;
	$company_trn = $row1->company_TRN;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Outstanding Report</title>
    <style>
       * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            background: white;
            margin: 0;
            padding: 0;
        }

        #printable {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
        }

        .report-title-bar {
            background-color: #d3d3d3;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: #000;
            font-weight: bold;
            text-align: center;
            padding: 8px;
            margin-top: 20px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-weight: bold;
        }

        .meta-info {
            margin-top: 30px;
            font-size: 13px;
        }

        .footer {
            font-size: 12px;
            page-break-inside: avoid;
            margin-top: auto;
            padding-top: 20px;
        }

        .footer .bottom {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 8px;
        }

        .no-border td {
            border: none !important;
            padding: 2px 0;
        }

        @media print {
            html, body {
                height: 100%;
            }

            #printable {
                height: auto;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                page-break-after: auto;
            }

            .footer {
                position: relative;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

  <!-- Header -->
 <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="<?= base_url('public/logo/Logo-bsg.jpg'); ?>" width="90">
        <div style="text-align: left;">
            <div style="font-weight: bold; font-size: 16px;"><?= $company_name; ?></div>
            <div style="font-size: 13px; line-height: 1.5;">
                TRN: <?= $company_trn; ?><br>
                Tel: <?= $company_telephone; ?> | Email: <?= $company_email; ?> | Website: <?= $company_website; ?>
            </div>
        </div>
    </div>
  </div>



<!-- Report Title -->
<div class="report-title-bar">
    <?php
        if ($request_type == 'Sundry Debtors') {
            echo 'OUTSTANDING REPORT - SUNDRY DEBTORS';
        } elseif ($request_type == 'Sundry Creditors') {
            echo 'OUTSTANDING REPORT - SUNDRY CREDITORS';
        } else {
            echo 'OUTSTANDING REPORT';
        }
    ?>
</div><!-- Date Info -->
<table class="sub-table">
    <tr>
        <td><strong>Today's Date:</strong> <?php echo date('d-M-Y'); ?></td>
        <td><strong>As on Date:</strong> <?php echo date('d-M-Y', strtotime($voucher_date)); ?></td>
    </tr>
</table>

<!-- Data Table -->
<table style="margin-top:10px;">
    <thead style="background:#f2f2f2;">
        <tr>
            <th>Srn</th>
            <th style="white-space: nowrap;">Date</th>
            <th>
            <?php 
            if ($request_type == 'Sundry Debtors') {
                echo 'Customer Name';
            } elseif ($request_type == 'Sundry Creditors') {
                echo 'Supplier Name';
            } else {
                echo 'Name';
            }
            ?>
        </th>
            <th>Ref.No</th>
            <th>Amount</th>
            <th>Pending Amount</th>
            <th>Due On</th>
            <th>Overdue By Days</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 1;
        $total_due_amt = 0;
        $ct = 0;

        if (!empty($records)):
            $ct = count($records);
            foreach($records as $row): 

           // echo "<pre>";    print_r($records); exit;
                $due_date = strtotime('+3 months', strtotime($row->voucher_date));
                $today = strtotime(date('d-M-Y'));
                $overdue_days = ($today > $due_date) ? floor(($today - $due_date) / (60 * 60 * 24)) : '-';
                $total_due_amt += $row->sum_due_amt;
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
             <td style="white-space: nowrap;"><?php echo date('d-M-Y', strtotime($row->voucher_date)); ?></td>
            <td>
            <?php 
            if ($request_type == 'Sundry Debtors') {
                echo $row->cust_name ?? 'N/A';
            } elseif ($request_type == 'Sundry Creditors') {
                echo $row->supplier_name ?? 'N/A';
            } else {
                echo 'N/A';
            }
            ?>
            </td>           
             <td><?php echo $row->voucher_code; ?></td>
            <td style="text-align:right;"><?php echo number_format($row->sum_amt, 2); ?></td>
            <td style="text-align:right;"><?php echo number_format($row->sum_due_amt, 2); ?></td>
            <td style="white-space: nowrap;"><?php echo date('d-M-Y', $due_date); ?></td>
            <td style="text-align:right;"><?php echo is_numeric($overdue_days) ? $overdue_days : '-'; ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>

<!-- Footer Totals -->
<!-- <table class="footer-table" style="margin-top: 15px;">
    <tr>
        <td class="record-total">Records Total: <?php// echo $ct; ?></td>
        <td class="record-total">Total Pending Amount: <?php// echo number_format($total_due_amt, 2); ?></td>
        <td align="right"><strong>Printed on:</strong> <?php //echo date('d-M-Y h:i A'); ?></td>
    </tr>
</table> -->

	<!-- Totals Summary -->
	<div class="summary-row">
		<div><strong>Records Total: <?php echo $i - 1; ?></strong></div>
		<div><strong>Total Pending amount: <?php echo number_format($total_due_amt, 2); ?></strong></div>
	</div>
	<!-- Meta Info -->
    <div class="meta-info">
        <strong>Report Dated</strong>: <?= date('d-M-Y'); ?><br>
        <strong>Report Generated By</strong>: <?= $this->session->userdata('user_name'); ?>
    </div>
<!-- Footer Section -->
	<div class="footer">
		
		<div class="bottom">
			<div>&copy;<?php echo date('Y'); ?> For Bangalore Elect Switchgear, Designed and developed by Concepts 360 Plus</div>
		        <div id="page-number"></div>

		</div>
	</div>
	<script>
    window.onload = function () {
        window.print();
    };

      let totalPages = Math.ceil(document.body.scrollHeight / window.innerHeight);
        document.getElementById("page-number").innerText = "Page 1 of " + totalPages;
</script>
</body>
</html>
