<html>
<head>
  <title><?= $title ?></title>

  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      background-color: white;
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

    .no-print {
      text-align: right;
      margin-bottom: 10px;
    }

    @media print {
      .no-print {
        display: none;
      }
    }

    /* Header */
    .invoice-header td {
      vertical-align: middle;
      padding: 10px;
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

<div class="no-print">
  <button onclick="window.print()">🖨️ Print</button>
</div>

<!-- 🔥 HEADER SAME AS INVOICE -->
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

<!-- 🔥 TITLE ROW LIKE INVOICE -->
<table style="margin-top:10px;">
  <tr>
    <td width="40%" style="border:none;">
      <b>Report:</b> <?= $title ?>
    </td>

    <td width="20%" style="border:none; text-align:center; font-size:16px;">
      <b>EMPLOYEE REPORT</b>
    </td>

    <td width="40%" style="border:none; text-align:right;">
      <b>Date:</b> <?= date('d-M-Y') ?>
    </td>
  </tr>
</table>

<br>

<!-- 🔥 EMPLOYEE TABLE -->
<table>
  <thead>
    <tr>
      <th width="5%">S.No</th>
      <th width="20%">Employee Name</th>
      <th width="15%">Designation</th>
      <th width="15%">Department</th>
      <th width="12%">Date of Join</th>
      <th width="13%">Contact Number</th>
      <th width="20%">Email ID</th>
      <th width="10%" class="right">Basic Salary</th>
    </tr>
  </thead>

  <tbody>
    <?php if (!empty($records)): $i = 1; ?>
      <?php foreach ($records as $row): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $row->employee_name ?></td>
          <td><?= $row->designation_name ?></td>
          <td><?= $row->department_name ?></td>
          <td><?= date('d-M-Y', strtotime($row->joining_date)) ?></td>
          <td><?= $row->mobile ?></td>
          <td><?= $row->email ?></td>
          <td class="right"><?= $row->basic_salary ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="8" style="text-align:center;">No records found.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>
