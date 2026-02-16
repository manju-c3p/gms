<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Currency_List.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Currency List</h4>
      </td>
    </tr>
    <tr>
      <td>Date : <?php echo date('d-M-Y'); ?></td>
    </tr>
  </table>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
  <thead>
								<tr>
                  <th>Country</th>
									<th>Currency</th>
                  <th>Currency Abbreviation</th>               
									<th>Rate</th>
									<th>Status</th>
                  <th>Inactive Date</th>
                          
      
              
                 
								</tr>
							</thead>

							<tbody>
								<?php foreach ($records as $row) : ?>
									<tr>
                    <td><?php echo $row->country ; ?></td>
										<td><?php echo $row->currency; ?></td>
                    <td><?php echo $row->currabrev ; ?></td>
                    <td><?php  echo sprintf("%0.6f",$row->rate); ?></td>
                    <td><?php echo ($row->status == 0) ? 'Active' : 'Inactive'; ?></td>
                    <td><?php echo date('d-M-Y'); ?></td>
                   


                 
                  </tr>
								<?php endforeach; ?>
							</tbody>

  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
