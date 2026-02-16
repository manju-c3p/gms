<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=stock_code_ledger_Details.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php $this->load->helper('stock_helper.php');?>
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
        <p style="font-size:16px; font-weight:bold;">Stock Code Wise Ledger Details</p>
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
				<th rowspan=2 width='40%'>Particulars</th>
				<th colspan=2 align='center'>Inward</th>
				<th colspan=2 align='center'>Outward</th>
				<th colspan=2 align='center'>Closing</th>
			   </tr>
                            <tr>
				<th>Quantity</th>
				<th>Value</th>
				<th>Quantity</th>
				<th>Value</th>
				<th>Quantity</th>
				<th>Value</th>
			   </tr>
		</thead>

		<tbody>
			<tr>
				<?php  $opening_rec= get_product_opening_stock($model_code,$from_date,$warehouse_id);
				$opening_stock=0; $opening_price=0;
				foreach($opening_rec as $op)
				{
					$opening_stock= $op->stock;
					$opening_price= $op->total_price;
				}
				
				 ?>
				<td>Opening</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo $opening_stock;?></td>
				<td><?php echo sprintf("%0.2f",$opening_price);?></td>
			</tr>
			<?php $total_out=0; $total_outPrice=0; $total_closing_qty=0; $total_closing_price=0;
			$total_inward=0;  $total_inward_price=0; 
			foreach($records as $r)
			{ ?>
			<tr>
				<td><?php echo $r->month_name;?></td>
				<td><?php echo $r->inward; $total_inward=$total_inward+$r->inward;?></td>
				<td><?php echo $r->inward_price; $total_inward_price=$total_inward_price+$r->inward_price;?></td>
				<td><?php echo $r->outward; $total_out=$total_out+$r->outward;?></td>
				<td><?php echo $r->outward_price; $total_outPrice=$total_outPrice+$r->outward_price;?></td>
				<td><?php echo $r->inward-$r->outward; $total_closing_qty=$total_closing_qty+ ($r->inward-$r->outward);?></td>
				<td><?php echo $r->inward_price-$r->outward_price; $total_closing_price=$total_closing_price+($r->inward_price-$r->outward_price); ?></td>
			</tr>
			<?php } ?>
			<tr>
				<th>Grand Total</th>
				<td><?php echo $total_inward;?></td>
				<td><?php echo $total_inward_price;?></td>
				<td><?php echo $total_out;?></td>
				<td><?php echo $total_outPrice;?></td>
				<td><?php echo $total_closing_qty;?></td>
				<td><?php echo $total_closing_price;?></td>
			</tr>
		
		</tbody>
            </table>
</body>
</html>
