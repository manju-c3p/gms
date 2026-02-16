<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Item_List.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Item List</h4>
      </td>
    </tr>
    <tr>
      <td>Date : <?php echo date('d-M-Y'); ?></td>
    </tr>
  </table>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
  <thead>
								<tr>
                  <th>Item Code</th>
									<th>Item Name</th>
									<th>Part Code </th>
									<th>Make/Model </th>
                  <th>Manufacture</th>
                  <th>Unit Price</th> 
                  <th>Item Details</th>         
      
              
                 
								</tr>
							</thead>

							<tbody>
								<?php foreach ($records as $row) : ?>
									<tr>
                  <td><?php echo $row->item_code ; ?></td>
										<td><?php echo $row->item_name; ?></td>
                    <td><?php echo $row->part_code ; ?></td>
                    <td><?php echo $row->make_model ; ?></td>
                    <td><?php echo $row->manufacture ; ?></td>
                   
                    <td><?php echo $row->unit_price ; ?></td>
                    <td><?php echo $row->item_desc ; ?></td>



                 
                  </tr>
								<?php endforeach; ?>
							</tbody>

  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
