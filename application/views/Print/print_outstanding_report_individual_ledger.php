<?php
foreach ($comapny_records as $row1) {

	$company_name= $row1->company_name;
	//$company_footer_pmc = $row1->print_header_pmc;
	$company_add1 = $row1->company_address;
	$company_city = $row1->company_city;
	$company_pin = $row1->company_pincode;
	$company_state = $row1->company_state;
	$company_website = $row1->company_website;
	$company_email = $row1->company_email_id;
}
?>
<html>
<body>


<section class="content">
		<div class="row" style="border: 0px solid black;">
			<table width="100%" >
			  <div id="logo_header" name="logo_header" style="width: 100%;">
			  <div style="width: 150px;float: center;display:block">
			    <img width='150px' style='background-color:white' src="<?php echo base_url().'public/logo/Logo-bsg.jpg'?>" alt='logo.png' />
			  </div>
			
		      </table>
			<table width="100%">
				<tr>
				<td align="center"><?php echo $company_name;?>
				<br/><?php echo $company_add1;?>
				<br/><?php echo $company_city." ".$company_pin;?>
				
				<br/><?php echo "Emirate: ".$company_state;?>
				<br/><?php echo "Website: ".$company_website;?>
				<br/><?php echo "E-mail: ".$company_email;?>
				<br/><br/><br/>
			</td>
		
			<tr>
			<td align="center">
				<p style="font-size:16px; font-weight:bold;">Print Outstanding Report Individual Ledger</p>
			</td>
			
		</tr>
			</table>


	<table width="100%" border=0 cellspacing="0" colspacing="0">
		<tr>
			<td align="center">
			</td>
			
		</tr>
	</table>

	<table width="100%" border=1 cellspacing="0" colspacing="0">
		<tr>
			<th>As on date: <?php echo date('d-M-Y'); ?></th>

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
                        <td style="text-align: right;"><?php echo $row->amount; ?></td>
                        <td style="text-align: right;"><?php echo $row->due_amount; ?></td>
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
                    <td style="text-align: right;"><?php echo number_format($ageing['0-30'], 3, '.', ''); ?></td>
                    <td style="text-align: right;"><?php echo number_format($ageing['31-60'], 3, '.', ''); ?></td>
                    <td style="text-align: right;"><?php echo number_format($ageing['61-90'], 3, '.', ''); ?></td>
                    <td style="text-align: right;"><?php echo number_format($ageing['91-120'], 3, '.', ''); ?></td>
                    <td style="text-align: right;"><?php echo number_format($ageing['>120'], 3, '.', ''); ?></td>
                    <td style="text-align: right;"><?php echo number_format($ageing['Total'], 3, '.', ''); ?></td>

                    </tr>
                </tbody>
	</table>




	
</body>

</html>
