<html>
	<head>
		<title>
			Quotation
		</title>
	</head>
	<body style="margin-left: 5px; margin-top:5px; font-family:Arial;font-size: 12px;text-align:center">
	    <table width=100% style='border: 0'>
			<thead>	
                <tr>	
                    <th>					
                        <img align="left" src="<?php echo base_url() ?>public/header/logo.jpg" alt="Header Image" width='50%' >										
                    </th>
                   
                </tr>
			</thead>
			<tbody id="table-body">
                <tr  class='calc'>
                    <td>
                        <table cellpadding=5 width=95% style='font-size: 16px;text-align:center;border-top:1px solid #ccc;border-bottom:1px solid #ccc;'>
                            <tr height='22px' style="">
                                <td width=100% style="color:#000">Supplier Quotation</td>
                            </tr>
                        </table>
                    </td>
                </tr>
				<tr  class='calc'>
					<td>
                        <table cellpadding=5 border=0 width=95% style=' border-collapse: collapse;border:0'>
                            <tr>
                                <td width='60%'>
                                    <table width=100% style='font-size: 12px;'>
                                        <tr>
                                            <td width=30%>Name</td><td>:</td><td width=70%><?php echo $quote[0]->supplier_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width=30%>Address</td><td>:</td><td width=70%><?php echo $quote[0]->billing_address; ?></td>
                                        </tr>
                                        <tr>
                                            <td width=30%>Contact No</td><td>:</td><td width=70%><?php echo $quote[0]->contact_number; ?></td>
                                        </tr>
                                        <tr>
                                            <td width=30%>Email</td><td>:</td><td width=70%><?php echo $quote[0]->supplier_email; ?></td>
                                        </tr>						
                                    </table>
                                </td>
                                
                                <td width='40%'>
                                    <table width=100% style='font-size: 12px;'>
                                          
                                            <tr>
                                                <td width=30%>Date:</td><td>:</td><td width=70%><?php echo $quote[0]->quotation_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td width=30%>Doc No:</td><td>:</td><td width=70%><?php echo $quote[0]->quotation_code; ?></td>
                                            </tr>
                                            <tr>
                                                <td width=30%>Supplier ID:</td><td>:</td><td width=70%><?php echo $quote[0]->supplier_code; ?></td>
                                            </tr>
                                          
                                    </table>
                                </td>
                            </tr>
                        </table>						
					</td>
				</tr>
                <tr class='calc' height=5px style="background-color: #525453;"><td></td></tr>
                <tr class='calc'>
                <td>
                        <table cellpadding=5 border=0 width=95% style='font-size: 12px; border-collapse: collapse;border:0'>
                            <tr>
                                 <td colspan="5">Prepared by:<?php echo $quote[0]->sales_person;?></td>
                            </tr>
                        </table>
                    </td>
                    
                </tr>
				<tr>
					<td>
                        <table cellpadding=10 width=100% style='font-size: 12px; border-collapse:collapse;border:1px solid'>
                            <thead>
                                <tr class='calc' style="background-color: #525453;color:e8b41a">
                                    <td style='width:2%'>Sl No</td>
                                    <td style='width:10%'>Product Code</td>
                                    <td style='width:10%'>Model</td>
                                    <td style='width:18%'>Description</td>
                                    <td style='width:5%'>Qty</td>
                                    <td style='width:5%'>Unit</td>
                                    <td style='width:5%'>Price</td>
                                    <td style='width:5%'>Discount</td>
                                    <td style='width:5%'>Total</td>
                                </tr>
                            </thead>
                            <tbody style="background-color:#edebe4">
                            <?php 
                                $sl_no = 1;
                                $total_before_vat = 0;
                                $total_discount = 0;
                                $vat_amount = 0;
                                $grand_total = 0;

                                foreach ($quote_tr as $detail): 
                                    $total_before_vat += $detail->price * $detail->quantity;
                                    $total_discount += $detail->dis_amt;
                                    $grand_total += $detail->total;
                                endforeach;

                                // Example VAT Calculation (adjust if VAT is calculated differently)
                                $vat_amount = $grand_total - ($total_before_vat - $total_discount);
                               
                            foreach ($quote_tr as $detail): ?>
                                <tr class='calc' valign='top'>
                                    <td><?php echo $sl_no++; ?></td>
                                    <td><?php echo $detail->item_code; ?></td>
                                    <td><?php echo $detail->item_model; ?></td>
                                    <td><?php echo $detail->item_description; ?></td>
                                    <td><?php echo $detail->quantity; ?></td>
                                    <td><?php echo $detail->unit_name; ?></td>
                                    <td><?php echo $detail->price; ?></td>
                                    <td><?php echo $detail->dis_amt; ?></td>
                                    <td align="right"><?php echo $detail->total; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Totals Row -->
                        <tr style="font-weight:bold;">
                            <td colspan="8" align="right">Total Before VAT</td>
                            <td align="right"><?php echo number_format($total_before_vat, 2); ?></td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="8" align="right">Discount Amount</td>
                            <td align="right"><?php echo number_format($total_discount, 2); ?></td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="8" align="right">VAT Amount</td>
                            <td align="right"><?php echo number_format($vat_amount, 2); ?></td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="8" align="right">Total Amount</td>
                            <td align="right"><?php echo number_format($grand_total, 2); ?></td>
                        </tr>
                        </tbody>
                        </table>
					</td>
				</tr>
               <tr>
                <td>
                        <table cellpadding=15 width=100% style='border-collapse: collapse;border:0;font-weight:bold;font-size:11px;'>
                            
                            <tr>
                            <td width=30%>PAYMENT TERMS</td><td>:<?php echo $quote[0]->payment_term; ?></td>
                            </tr>
                            
                            <tr>
                            <td width=30%>DELIVERY TERMS</td><td>:<?php echo $quote[0]->delivery_term; ?></td>
                            </tr>

                             <tr>
                            <td width=30%>GENERAL TERMS</td><td>:<?php echo $quote[0]->general_term; ?></td>
                            </tr>
                            
                            <tr>
                            <td width=30%>VALIDITY</td><td>:<?php echo $quote[0]->validity; ?></td>
                            </tr>
                            
                            
                        </table>
                </td>
               </tr>
               
              
                
				
			</tbody>
			<tfoot class='footer'>		
				
			</tfoot>
		</table>
	</body>
</html>






