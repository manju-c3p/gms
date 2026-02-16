<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Unit_Master.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Unit Master</h4>
      </td>
    </tr>
    <tr>
      <td>Date : <?php echo date('d-M-Y'); ?></td>
    </tr>
  </table>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
  <thead>
  <tr>
					<th>Unit Name</th>
					<th>Abbrivation</th>
					<th>Type</th>
				</tr>
							</thead>

							<tbody>
								<?php foreach ($records as $row) : ?>
                  <tr>
					<td><?php echo  $row->unit_name;?></td>
					<td><?php echo  $row->unit_abbr;?></td>
					<td><?php echo  $row->unit_type;?></td>
					
				</tr>
								<?php endforeach; ?>
							</tbody>

  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
