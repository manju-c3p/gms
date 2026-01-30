<?php
$this->load->helper('menu_helper.php');
$this->load->helper('myopeningbalance_helper.php');

foreach($logo_details as $row1)
{
  $company_name= $row1->company_name;
  //$company_footer_pmc = $row1->print_header_pmc;
  $company_add1 = $row1->company_address;
  $company_city = $row1->company_city;
  $company_pin = $row1->company_pincode;
  $company_state = $row1->company_state;
  $company_website = $row1->company_website;
  $company_email = $row1->company_email_id;
 
}

foreach($payment as $row)
{
	$receipt_no = $row-> voucher_code;
	$receipt_date = $row-> voucher_date;
	$amount= $row-> amount;
	$voucher_type= $row->voucher_type;
	$remark= $row->narration;
	//$receipt_type= $row->receipt_type;
	// $cheque_no = $row->cheque_no;
	// $cheque_date= $row->cheque_date;
	$cust_code=$row->supplier_code;
  	$occu_add1=$row->billing_address;
	// $occu_add2=$row->taluka;$occu_add3=$row->district;$occu_add4=$row->state;$occu_pin=$row->country;
  $occu_name=$row->supplier_name;
}
?>

<style>
body {
	font-family:Arial, Helvetica, sans-serif;
}
table {
	border-collapse: collapse;
	font-size: 14px;
}
table, th, td {
	/*border: 1px solid #cccccc;*/
}
</style>
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
		
				</tr>
			<tr>
				<td align="center"><b><?php if($voucher_type=='D') echo 'DEBIT NOTE'; 	if($voucher_type=='C') echo 'CREDIT NOTE'; 	if($voucher_type=='R') echo 'RECEIPT VOUCHER';?></b></td>
			</tr>
			</table>

			<table>
				<tr height="10px"></tr>
			</table>

			<table width="100%">
				<tr height="20px"></tr>
				<tr valign="top">
					<tr>
						<td align="left"> <?php if($voucher_type=='R') echo 'Receipt No:'; if($voucher_type=='D') echo 'DN / No.:'; if($voucher_type=='C') echo 'CN / No.:'; ?>  <?php echo $receipt_no;?></td>
						<td align="right"><?php if($voucher_type=='R') echo 'Receipt Date:'; if($voucher_type=='D') echo 'DN / Date:'; if($voucher_type=='C') echo 'CN / Date:'; ?>  <?php echo date('d-M-Y', strtotime($receipt_date));?></td>
					</tr>
					<tr>
						<td><?php echo '['.$cust_code.']'.$occu_name ;?></td>
					</tr>
				</table>
				<table border='1' width='90%' cellpadding='0' cellspacing=0 style=" border-radius: 10px;
							border-color:#34934E;font-family:Arial; ">
				
				<tr height='30px' style=" font-size: 13px; center;color:white;" bgcolor="#34934E">
							<th>SL.No</th>
							<th>Invoice</th>
							<th>Dr/Cr</th>
							<th>Amount</th>
							
							
							
				</tr>

				<tbody style="font-family:Arial; font-size: 11px;">
    <?php 
    $i = 1;
    $total_amount = 0;
    foreach ($payment as $r) { ?>
        <tr height="23px" style=" font-size: 13px; center;">
            <td align="center">
                <?php echo $i; ?>
            </td>
            <td>
                <?php echo $r->grn_code; ?>
            </td>
            <td align="center">
                <?php echo $r->drcr_type; ?>
            </td>
            <td align="center"> 
                <?php 
                if ($r->drcr_type == 'Cr') {
                    echo $r->amount; 
                    $total_amount += $r->amount; // Accumulate only Cr amounts
                } else {
                    echo $r->amount; // If it's a Dr (Debit), leave it blank
                }
                ?>
            </td>
        </tr>
        <?php $i++; ?>
    <?php } ?>

    <!-- Display total amount after the loop -->
    <tr>
        <td colspan="3" align="right"><strong>Total Credit Amount :</strong></td>
        <td align="center"><b><?php echo sprintf('%0.2f', $total_amount); ?></b></td>
    </tr>
</tbody>

				</tbody>
					</table>
				<table width="100%">
				
				<tr>
					<td width="25%">Narration</td>
					<td><?php echo $remark;	?></td>
				</tr>
				<tr>
					<td>Amount in Words</td>
					<td><?php echo convert_number_to_words($total_amount); ?></td>
				</tr>
				<tr>
					<td colspan="3" height="20px"></td>
				</tr>
				<tr>
					<td>Total Received Amount</td>
					<td>
						<b> <label style="border: 1px solid #000000; padding: 10px; "> <?php echo sprintf('%0.2f',$total_amount); ?> </label></b>
					</td>
				</tr>
				<tr>
					<td><br /><br /><br /></td>
				</tr>
				<!--<tr>
					<td colspan="2"><?php echo $receipt_ref_detl ?></td>
				</tr>-->
				<tr>
					<td align="right" colspan="2"><b>For <?php echo $company_name;?></b></td>
				</tr>
				<tr height="40px"></tr>
				<tr>
					<td align="right" colspan="2"><b>AUTHORISED SIGN.</b></td>
				</tr>
			</table>
						

				</div>
			</section>
		</div>
	</body>

