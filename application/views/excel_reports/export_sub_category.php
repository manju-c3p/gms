<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Item Sub_Category_List.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Item Sub Category List</h4>
      </td>
    </tr>
    <tr>
      <td>Date : <?php echo date('d-M-Y'); ?></td>
    </tr>
  </table>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
  <thead>
  <tr>
							<th>Sr.no</th>
							<th>Name</th>
							<th>Main category</th>
							<th>Type</th>
						</tr>
							</thead>

							<tbody>
								<?php foreach ($records as $row) : ?>
									<tr>
							<td><?php echo $i;$i++;?></td>
							<td><?php echo $row->category_name;?></td>
							<td><?php echo $row->pname;?></td>
							<td><?php echo $row->category_type;?></td>
							
						</tr>
								<?php endforeach; ?>
							</tbody>

  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
