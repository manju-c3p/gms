<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Cost_Sheet_Category_List.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Cost Sheet Category List</h4>
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
							<th>Category Name</th>
							<th>Sequence No</th>
						</tr>
							</thead>

              <tbody>
					<?php $i=1; foreach($records as $row) :?>
						<tr>
							<td><?php echo $i;$i++;?></td>
							<td><?php echo $row->category_name;?></td>
							<td><?php echo $row->sequence_no;?></td>
							
						</tr>
					<?php endforeach; ?>
					</tbody>


  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
