<?php
	$this->load->helper('menu_helper.php');
	$this->load->helper('mybagopeningbalance_helper.php');

	 foreach($print_company_name as $row1)
	 {
		$company_name= $row1->company_name;
	 	$company_footer_pmc = $row1->print_header_pmc;
		$company_add1 = $row1->company_add1;
		$company_add2 = $row1->company_add2;
		$company_city = $row1->company_city;
		$company_pin = $row1->company_pin;
		$company_state = $row1->company_state;
		$company_website = $row1->company_website;
		$company_email = $row1->company_email;
		$company_gst_no =$row1->gst_number;
		$company_pan_no = $row1->pan_number;
        	$receipt_ref_detl = $row1->receipt_ref_detl;
	}

    foreach($receipt as $row)
	{
		$receipt_no = $row-> voucher_code;
		$receipt_date = $row-> voucher_date;
		$amount= $row-> amount;
		$voucher_type= $row->voucher_type;
		$remark= $row->narration;
		$receipt_type= $row->receipt_type;
		$cheque_no = $row->cheque_no;
		$cheque_date= $row->cheque_date;
		$cust_code='';
        	$occu_add1=$row->supp_add1;$occu_add2=$row->supp_add2;$occu_add3=$row->supp_city;$occu_add4=$row->supp_state;$occu_pin=$row->supp_pincode;
       		 $occu_name=$row->supp_name;
	}

    foreach($logo_details as $row):
   {  //  $company_name=$row->company_name;
     //   $certificate_note = $row->certificate_note;
    //   $company_code= $row->company_code;
        $company_header= $row->company_header;
        $company_footer= $row->company_footer;

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
          <?php if($company_header!=='') {?>
             <div id="logo_header" name="logo_header" style="width: 100%;>
               <div style="width: 150px;float: center;display:block">
                   <img src="<?php echo 'data:' .';base64,' . base64_encode($company_header);?>" height="120px" width="100%" />
               </div>
             <?php } else {?>
                 <div id="logo_header" name="logo_header" style="width: 100%; height: 120px">
                 </div>
         <?php }?>
     </table>

  <!--   <table width="100%">
         <tr>
             <td align="center"><img src="<?php echo 'data:' .';base64,' . base64_encode($company_header);?>" height="120px" width="100%" /></td>
         </tr>
     </table>-->
     <table>
         <tr height="30px"></tr>
     </table>

	<table width="100%">
     			<tr height="20px"></tr>
			  	<tr valign="top">
			 	<!--	<td align="left" rowspan="5"><img src="<?php echo 'data:' .';base64,' . base64_encode(get_company_logo());?>" height="65px";width="35px"; /></td> -->
			 	<!--	<td align="left"><b><?php echo $company_name;?></b></td>
			 		<td align="right">Receipt No. <?php echo $receipt_no;?></td>
			 	</tr>
			 	<tr>
			 		<td align="left"><?php echo $company_add1;?></td>
			 	</tr>
			 	<tr>
			 		<td align="left"><?php echo $company_add2;?></td>
			 	</tr>
			 	<tr>
			 		<td align="left"><?php echo $company_city.', '.$company_state.', '.$company_pin;?></td>
			 	</tr>-->
			 	<tr>
			 		<!--<td align="left"><?php echo $company_website.', '.$company_email;?></td>-->
			 		<td align="left">Receipt No. <?php echo $receipt_no;?></td>
			 		<td align="right">Receipt Date <?php echo date('d-M-Y', strtotime($receipt_date));?></td>
			 	</tr>
			 	<tr>
			 		<td colspan="3"><hr /><br /></td>
			 	</tr>
		  	</table>

	  		<table width="100%">
	  			<tr>
		  			<td>&nbsp;Received From :</td>
		  			<td><b><?php echo '['.$cust_code.']'.$occu_name ;?></b></td>
	  			</tr>
	  			<tr>
	  				<td></td>
	  				<td><?php echo $occu_add1.' '.$occu_add2.' '.$occu_add3.','.$occu_add4.'-'.$occu_pin ?></td>
	  			</tr>
	  			<tr>
	  				<td>&nbsp;RS :</td>
	  				<td><b><?php echo sprintf('%0.2f',$amount); ?></b></td>
	  			</tr>
	  			<tr>
	  				<td>&nbsp;For : </td>
	  				<td><?php
	  					if($voucher_type=='R')
	  					 echo 'Receipt For BMW Charges';
						else if($voucher_type=='P')
	  					 echo 'Cheque Return';
						else if($voucher_type=='SD')
	  					 echo 'Security Deposit';
						else if($voucher_type=='PSD')
	  					 echo 'Cheque Return Of Security Deposit';
						else if($voucher_type=='RSD')
	  					 echo 'Refund Security Deposit';
						else if($voucher_type=='PAY')
	  					 echo 'Payment Receipt';
						else if($voucher_type=='REG')
	  					 echo 'Registration Receipt';
						else if($voucher_type=='REG')
	  					 echo 'Registration Receipt';
						else if($voucher_type=='C')
	  					 echo 'Credit Note';
						else if($voucher_type=='D')
	  					 echo 'Debit Note';
  				   	  ?>
  					 </td>
	  			</tr>
	  			<tr>
	  				<td>&nbsp;By :</td>
	  				<td>
	  					<?php
	  					      if($receipt_type=='cheque') echo "Cheque".' Cheque No:'.$cheque_no.' Date:'. date('d-M-Y',strtotime($cheque_date));
							  else if ($receipt_type=='cash') echo "CASH" ;
							  else if($receipt_type=='other') echo "Other" ;
						?>
	  				</td>
	  			</tr>
	  			<tr>
	  				<td>&nbsp;Narration :</td>
	  				<td><?php echo $remark;	?></td>
	  			</tr>
	  			<tr>
	  				<td>&nbsp;Sum Of : </td>
	  				<td><?php echo convert_number_to_words($amount); ?></td>
	  			</tr>
	  			<tr>
	  				<td colspan="2" height="20px"></td>
	  			</tr>
	  			<tr>
	  				<td>&nbsp;Total Amount Rs.</td>
	  				<td>
	  					<b> <label style="border: 1px solid #000000; padding: 10px; "> <?php echo sprintf('%0.2f',$amount); ?> </label></b>
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
                <tr height="60px"></tr>
	  			<tr>
	  				<td align="right" colspan="2"><b>AUTHORISED SIGN.</b></td>
	  			</tr>
  			</table>
  			<table width="100%">
  			    <tr>
  			        <td align="center"><?php if($company_footer!=''){?><img src="<?php echo 'data:' .';base64,' . base64_encode($company_footer);?>" width="800px%"; /><?php }?></td>
  			    </tr>
  			</table>

       <!--     <?php if($header=='yes') { ?>
            <table width="100%" >
                <tr >
                    <td align="center">
                       <?php if($company_footer!=''){?><img src="<?php echo 'data:' .';base64,' . base64_encode($company_footer);?>" width="800px%"; /><?php }?>
                    </td>
                </tr>
            </table>
            <?php }?>   -->

</div>
</section>
</div>
</body>

<?php endforeach;?>
