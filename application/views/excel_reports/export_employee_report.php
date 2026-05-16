<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=employee_report_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1">
  <thead>
    <tr>
      <th colspan="7">
        <strong>Employee Master Report</strong>
      </th>
    </tr>
    <tr>
      <th>S.No</th>
      <th>Employee Name</th>
      <th>Designation</th>
      <th>Department</th>
      <th>Date of Join</th>
      <th>Contact Number</th>
      <th>Email ID</th>
      <th>Basic Salary</th>
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
          <td><?= $row->basic_salary ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="7" style="text-align:center;">No records found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
