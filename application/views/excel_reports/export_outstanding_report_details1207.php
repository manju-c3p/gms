<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=Outstanding report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php
$this->load->helper('myopeningbalance');

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
      
      <td align="center"> <?php echo $company_name;?></td>
      <td valign="top" align="right"><img src="<?php echo base_url().'public/logo/Logo-fzc.jpg'?>" alt='logo.png' width='60px'></td>
    </tr>
    <tr>
      <td align="center">
        <p style="font-size:16px; font-weight:bold;">Outstanding report</p>
      </td>
    </tr>
  </table>

  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
	<th>As on date:<?php echo date('d-M-Y',strtotime($voucher_date));?></th>
	<td></td>
    </tr>
  </table>
  <br>
  
 	<table width='100%' border=1 cellspacing="0" colspacing="0">
	        		<thead>
					<tr>
				<th>Srn</th>
				<th>Date</th>
				<th>
                <?php 
                if ($request_type == 'Sundry Debtors') {
                    echo 'Customer Name';
                } elseif ($request_type == 'Sundry Creditors') {
                    echo 'Supplier Name';
                } else {
                    echo 'Name';
                }
                ?>
            </th>
				<th>Ref.No</th>
				<th>Amount</th>
				<th>Pending Amount</th>
				<th>Due On</th>
				<th>OverDue By Days</th>

		</tr>
				</thead>
				<tbody>
		<?php $i = 1; 
	if (!empty($records)):
	foreach($records as $row) : ?>
		
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo date('d-M-Y',strtotime($row->voucher_date));?></td>
			<td>
			<?php 
			if ($request_type == 'Sundry Debtors') {
				echo $row->cust_name ?? 'N/A';
			} elseif ($request_type == 'Sundry Creditors') {
				echo $row->supplier_name ?? 'N/A';
			} else {
				echo 'N/A';
			}
			?>
			</td> 
            <td><?php echo $row->voucher_code; ?></td>	
            <td><?php echo $row->sum_amt ?></td>	
            <td><?php echo $row->sum_due_amt; ?></td>	
			<td><?php echo date('d-M-Y', strtotime('+3 months', strtotime($row->voucher_date))); ?></td>
			<td>
				<?php 
					$due_date = strtotime('+3 months', strtotime($row->voucher_date));
					$today = strtotime(date('d-M-Y'));
					
					$overdue_days = ($today > $due_date) ? floor(($today - $due_date) / (60 * 60 * 24)) : 0;
					
					echo $overdue_days > 0 ? $overdue_days : '-';
				?>
			</td>
        </tr>
    <?php endforeach; 
	endif; ?>
		</tbody>
			</table>
</body>
</html>
