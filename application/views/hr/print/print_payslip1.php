<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payslip</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 40px;
      font-size: 16px;
    }

    table {
      border: 1px solid black;
      border-collapse: collapse;
      font-size: 14px;
    }

    th, td {
      padding: 1px;
    }

    /* footer for print */
    /* footer for print */
@media print {
  body {
    margin: 0;
  }
  .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
  }
  .footer img {
    width: 100% !important;   /* make full width */
    max-height: 120px;        /* keep it neat */
    object-fit: contain;      /* keep proportions */
  }
}

  </style>
</head>

<body onload="window.print();">
  <?php if (!empty($records)) : ?>
    <?php foreach ($records as $row) : ?>
      <div class="border-all">
        <!-- header -->
        <table border="0" width="100%">
          <tr>
            <td>
              <img src="<?php echo base_url() . 'public/logo/logo.png'; ?>" alt='logo.png'>
            </td>
            <td align='right'>
              <br>
              <h5><u><b>كشف الراتب الشهري</b></u></h5>
              Date: <?php echo date('d-m-Y'); ?>
            </td>
          </tr>
        </table>

        <br><br>

        <!-- title -->
        <table border="0" style="font-size: 18px;" width="100%">
          <tr style="font-size: 15px; font-weight: bold; text-align: center; background-image: linear-gradient(to right, purple, red); color:white;">
            <td align="center" style="font-size: 25px;">Payslip</td>
          </tr>
        </table>

        <!-- general info -->
        <table border="0" style="font-size: 18px;" width="100%">
          <tr>
            <td colspan="2">
              <div class="border-all">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <th>General Information</th>
                  </tr>
                </table>
              </div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="border-all">
                <table cellspacing="4" cellpadding="0" width="100%" height="80px" class="table-bordered" style="border: 1px solid black;">
                  <tbody>
                    <tr>
                      <th>Employee Name:</th>
                      <td><?php echo $row->user_name; ?></td>
                      <th>Joining Date:</th>
                      <td><?php echo date('d-M-Y', strtotime($row->joining_date)); ?></td>
                    </tr>
                    <tr>
                      <th>Employee Number:</th>
                      <td><?php echo $row->user_code; ?></td>
                      <th>Payment Month:</th>
                      <td><b><?php echo date('M-Y', strtotime($row->salary_month)); ?></b></td>
                    </tr>
                    <tr>
                      <th>Designation:</th>
                      <td><?php echo $row->designation_name; ?></td>
                      <th>Department:</th>
                      <td><?php echo $row->dept_name; ?></td>
                    </tr>
                    <tr>
                      <th>Mobile No:</th>
                      <td><?php echo $row->contact_no; ?></td>
                      <th>Email Id:</th>
                      <td><?php echo ''; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="border-all">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr style="background-color:#d9d9d9;">
                    <td align="center"><b>Salary Details</b></td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
        </table>

        <!-- salary details -->
        <table width='100%' border="1" cellspacing="4" cellpadding="0">
          <tr>
            <td>Working Days</td>
            <td><?php echo $row->working_days; ?></td>
            <td>Leaves</td>
            <td><?php echo $row->leave_days; ?></td>
          </tr>
          <tr>
            <td>Present Days</td>
            <td><?php echo $row->present_days; ?></td>
            <td>Paid Leaves</td>
            <td><?php echo $row->paid_leave; ?></td>
          </tr>
          <tr>
            <td>Company Holiday Day</td>
            <td><?php echo $row->company_holiday; ?></td>
            <td>Paid Days</td>
            <td><?php echo $row->payment_days; ?></td>
          </tr>
          <tr>
            <td>Overtime Amount</td>
            <td><?php echo $row->overtime_amt; ?></td>
            <td>Basic Salary</td>
            <td><?php echo $row->basic_salary; ?></td>
          </tr>
        </table>
        <br>

        <!-- allowances and deductions -->
        <div class="form-group row">
          <div class="col-sm-6">
            <table border='1' width='100%' cellspacing="4" cellpadding="0">
              <thead>
                <tr style="background-color:#d9d9d9;">
                  <th scope="col">Allowance Type</th>
                  <th scope="col">Allowance Value</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($record2 as $r) {
                  if ($r->allowance_type == 'A') { ?>
                    <tr>
                      <td><?php echo $r->allowance_name; ?></td>
                      <td align='right'><?php echo $r->amount; ?> </td>
                    </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
          <div class="col-sm-6">
            <table border='1' width='100%' cellspacing="4" cellpadding="0">
              <thead>
                <tr style="background-color:#d9d9d9;">
                  <th scope="col">Deduction Type</th>
                  <th scope="col">Deduction Value</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($record2 as $r) {
                  if ($r->allowance_type == 'D') { ?>
                    <tr>
                      <td><?php echo $r->allowance_name; ?></td>
                      <td align='right'><?php echo $r->amount; ?></td>
                    </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- totals -->
        <table width='100%' border="1" cellspacing="4" cellpadding="0">
          <tr>
            <td>Total Allowances</td>
            <td align='right'><?php echo $row->total_allowance; ?></td>
            <td>Total Deductions</td>
            <td align='right'><?php echo $row->total_deduction; ?></td>
          </tr>
          <tr>
            <td>Extra Allowances</td>
            <td align='right'><?php echo $row->extra_allowances; ?></td>
            <td>Extra Deductions</td>
            <td align='right'><?php echo $row->extra_deduction; ?></td>
          </tr>
          <tr>
            <td>Gross Amount</td>
            <td align='right'><?php echo $row->gross_salary; ?></td>
            <td>Net Salary</td>
            <td align='right'><?php echo $row->net_salary; ?></td>
          </tr>
        </table>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <!-- footer section -->
  <div class="footer">
  <img src="<?php echo base_url() . 'public/logo/footer1.png'; ?>" 
       alt='footer-logo' 
       style="width:150%; max-height:120px; object-fit:contain;">
</div>
</body>
</html>
