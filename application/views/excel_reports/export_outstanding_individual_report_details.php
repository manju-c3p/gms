<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=Outstanding report individual.xls");
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
        <p style="font-size:16px; font-weight:bold;">Outstanding Individual Report</p>
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
                        <th>Ref.No</th>
                        <th>Amount</th>
                        <th>Pending Amount</th>
                        <th>Due On</th>
                        <th>OverDue By Days</th>
                    </tr>
		</thead>
		
		<tbody>
                    <?php $i = 1; if (!empty($records)):
                    foreach ($records as $row) :
                        $due_date = strtotime('+3 months', strtotime($row->voucher_date));
                        $today = strtotime(date('d-M-Y'));
                        $overdue_days = max(0, floor(($today - $due_date) / (60 * 60 * 24)));
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo date('d-M-Y', strtotime($row->voucher_date)); ?></td>
                        <td><?php echo $row->voucher_code; ?></td>
                        <td><?php echo $row->amount; ?></td>
                        <td><?php echo $row->due_amount; ?></td>
                        <td><?php echo date('d-M-Y', $due_date); ?></td>
                        <td><?php echo $overdue_days > 0 ? $overdue_days : '-'; ?></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
	</table>
    <div class="header-title">
            <h4 class="card-title">Ageing Details</h4>
        </div>
	<table width='100%' border=1 cellspacing="0" colspacing="0">
	<thead>
	<tr>
                        <th>0-30 day(s)</th>
                        <th>31-60 day(s)</th>
                        <th>61-90 day(s)</th>
                        <th>91-120 day(s)</th>
                        <th>>120 day(s)</th>
                        <th>Total</th>
                    </tr>
		</thead>
		<tbody>
                    <?php 
                    $ageing = array_fill_keys(['0-30', '31-60', '61-90', '91-120', '>120', 'Total'], 0);
                    if (!empty($records)):
                        foreach ($records as $row) :
                            $overdue_days = max(0, floor((strtotime(date('d-M-Y')) - strtotime('+3 months', strtotime($row->voucher_date))) / (60 * 60 * 24)));
                            if ($overdue_days <= 30) {
                                $ageing['0-30'] += $row->due_amount;
                            } elseif ($overdue_days <= 60) {
                                $ageing['31-60'] += $row->due_amount;
                            } elseif ($overdue_days <= 90) {
                                $ageing['61-90'] += $row->due_amount;
                            } elseif ($overdue_days <= 120) {
                                $ageing['91-120'] += $row->due_amount;
                            } else {
                                $ageing['>120'] += $row->due_amount;
                            }
                            $ageing['Total'] += $row->due_amount;
                        endforeach;
                    endif; 
                    ?>
                    <tr>
                    <td><?php echo number_format($ageing['0-30'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['31-60'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['61-90'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['91-120'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['>120'], 3, '.', ''); ?></td>
                    <td><?php echo number_format($ageing['Total'], 3, '.', ''); ?></td>

                    </tr>
                </tbody>
	</table>
</body>
</html>
