<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Vat_Master.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Vat Master</h4>
      </td>
    </tr>
    <tr>
      <td>Date : <?php echo date('d-M-Y'); ?></td>
    </tr>
  </table>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
  <thead>
  <tr>
									<th>Sr.No</th>
									<th>VAT %</th>
									<th>Applicable From</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach ($records as $row) : ?>
                  <tr>
										<td><?php echo $i; $i++;?></td>
										<td><?php echo $row->vat_percent; ?></td>
										<td><?php echo date('d-M-Y',strtotime($row->applicable_date));?></td>
										
									</tr>
								<?php endforeach; ?>
							</tbody>

  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
