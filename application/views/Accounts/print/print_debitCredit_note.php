<?php
$accountName ="";
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
  $company_gst_no =$row1->company_GST;
  $company_pan_no = $row1->company_PAN;
 // $receipt_ref_detl = $row1->receipt_ref_detl;
}

foreach($receipt as $row)
{
  $receipt_no = $row->voucher_code;
  $receipt_date = $row->voucher_date;
  $amount= $row->amount;
  $voucher_type= $row->voucher_type;
  $remark= $row->narration;
 // $receipt_type= $row->receipt_type;
  $cheque_no = $row->cheque_no;
  $cheque_date= $row->cheque_date;
  $cust_code=$row->cust_code;
  $occu_add1=$row->address;
  $occu_add2=$row->taluka;$occu_add3=$row->district;$occu_add4=$row->state;$occu_pin=$row->country;
  $occu_name=$row->cust_name;
}


  if($voucher_type=='D')
  {
    $type="cr";
    $accountName = get_account_name($receipt_no,$type);
  }

  if($voucher_type=='C')
  {
    $type="dr";
    $accountName = get_account_name($receipt_no,$type);
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
          <div id="logo_header" name="logo_header" style="width: 100%;>
          <div style="width: 150px;float: center;display:block">
            <img width='150px' style='background-color:white' src="<?php echo base_url().'public/images/rise_shine_logo.png'?>" alt='logo.png' />
          </div>
        
      </table>
      <table width="100%">
        <tr>
          <td align="center"><h3><?php if($voucher_type=='D') echo 'DEBIT NOTE';?></h3> <h3><?php if($voucher_type=='C') echo 'CREDIT NOTE';?></h3></td>
        </tr>
      </table>

      <table width="100%">
        <tr height="10px"></tr>
        <tr valign="top">
          <tr>
            <td align="left"> <?php if($voucher_type=='D') echo 'DN / No.:'; if($voucher_type=='C') echo 'CN / No.:'; ?>  <?php echo $receipt_no;?></td>
              <td align="right"><?php if($voucher_type=='D') echo 'DN / Date:'; if($voucher_type=='C') echo 'CN / Date:'; ?>  <?php echo date('d-M-Y', strtotime($receipt_date));?></td>
              </tr>
              <tr>
                <td colspan="3"><hr /><br /></td>
              </tr>
            </table>

            <table width="100%">
              <tr>
                <td>&nbsp;<?php if($voucher_type=='D' || $voucher_type=='C') echo 'Occupier Name:'; ?> </td>
                  <td><b><?php echo '['.$cust_code.']'.$occu_name ;?></b></td>
                </tr>
                <tr>
                  <td></td>
                  <td><?php $occupier = $occu_add1.' '.$occu_add2.' '.$occu_add3.','.$occu_add4.'-'.$occu_pin; echo wordwrap($occupier,68,"<br>\n");  ?></td>
                </tr>

                <tr>
                  <td colspan="3" height="20px"></td>
                </tr>
                <tr>
                  <td>&nbsp;Amount Rs.:</td>
                  <td>
                    <b> <label style="border: 1px solid #000000; padding: 10px; "> <?php echo sprintf('%0.2f',$amount); ?> </label></b>
                  </td>
                </tr>

                <tr>
                  <td colspan="3" height="20px"></td>
                </tr>

                <tr>
                  <td>&nbsp;Amount in word :</td>
                  <td><?php echo convert_number_to_words($amount); ?></td>
                </tr>
                <tr>
                  <td colspan="3" height="10px"></td>
                </tr>

                <tr>
                  <td>&nbsp;<?php if($voucher_type=='D') echo "Debit Note For :"; if($voucher_type=='C') echo "Credit Note For :"; ?></td>
                    <td><?php echo $accountName; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" height="10px"></td>
                  </tr>

                  <tr>
                    <td>&nbsp;Narration :</td>
                    <td><?php echo wordwrap($remark,65,"<br>\n");  ?></td>
                  </tr>

                  <tr>
                    <td colspan="3" height="20px"></td>
                  </tr>
                  <tr>
                    <td><br /><br /><br /></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="2"><b><?php echo $company_name;?></b></td>
                  </tr>
                  <tr height="60px"></tr>
                  <tr>
                    <td align="right" colspan="2"><b>AUTHORISED SIGN.</b></td>
                  </tr>
                </table>
                <table width="100%">
                  <tr>
                    <td align="center"></td>
                    </tr>
                  </table>

                  </div>
                </section>
              </div>
            </body>
