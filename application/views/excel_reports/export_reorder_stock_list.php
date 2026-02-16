<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=Reorder_stock_list.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<?php
foreach($comapny_records as $row) {
	$company_name=$row->company_name;
	$company_address=$row->company_address;
	$company_city= $row->company_city;

	$company_pincode= $row->company_pincode;
	$company_country= $row->company_country;
	$company_email_id= $row->company_email_id;
	$company_telephone= $row->company_telephone;
	$company_website= $row->company_website;
	$company_TRN= $row->company_TRN;
}
?>
<html>
<body>
  <table width="100%" border=0 cellspacing="0" colspacing="0">
    <tr>
      <td align="center">
        <p style="font-size:16px; font-weight:bold;">Reorder Stock Report</p>
      </td>
      <td align="center"> <?php echo $company_name;?></td>
    </tr>
  </table>

  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td>Date : <?php echo date('d-M-Y');?></td>
    </tr>
  </table>
  <br>
  
 	<table width='100%' border=1>
                  <thead>
                   	 <tr>
				<th>Srn</th>
				<th>Stock Code</th>
				<th>Desc</th>
				<th>Inventory Qty</th>
				<th>PO Qty</th>
				<th>Total Stock</th>
				<th>Min Qty</th>
			</tr>
		</thead>

		<tbody>
		<?php $i=1; foreach($records as $row) :?>
			<tr>
				<td><?php echo $i;$i++;?></td>
				<td>
					<?php echo $row->stock_code;?>
				</td>
				<td>
					<?php echo $row->item_desc;?>
				</td>
				<td>
					<?php echo $row->invstock;?>
				</td>
				<td>
					<?php echo $row->postock;?>
				</td>
				<td>
					<?php echo $row->total_stock;?>
				</td>
				<td><?php echo $row->min_qty;?></td>
				
			</tr>
		<?php endforeach; ?>
		</tbody>
            </table>
</body>
</html>
