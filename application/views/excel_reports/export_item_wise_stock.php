<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=Item_Wise_Stock_Details.xls");
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
        <p style="font-size:16px; font-weight:bold;">Item Wise Stock Details</p>
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
  
 	<table width='100%' border=1 cellspacing="0" colspacing="0">
                <thead>
		<tr>
			<th>Sr. No</th>
			<th>Stock Date</th>
			<th>Stock Code</th>
			<th>Order code</th>
			<th>Size</th>
			<th>Bill No</th>
			<th>Order ref</th>
			<th>Box no</th>
			<th>Quantity</th>
			<th>Strage Location</th>
		</tr>
		</thead>
		<tbody>
		<?php $i=1; foreach($records as $row) :?>
		<tr>
			<td><?php echo  $i; $i++;?></td>
			<td><?php echo date('d-m-Y',strtotime($row->stock_date)); ?></td>
			<td><?php echo $row->model_code; ?></td>
			<td><?php echo $row->order_code; ?></td>
			<td><?php echo $row->size.'"'; ?></td>
			<td><?php echo $row->bill_no; ?></td>
			<td><?php echo $row->order_ref_no; ?></td>
			<td><?php echo $row->box_no; ?></td>
			<td><?php echo $row->qty; ?></td>
			<td><?php echo $row->storage_location; ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
            </table>
</body>
</html>
