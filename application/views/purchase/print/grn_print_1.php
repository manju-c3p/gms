<html>
	<head>
		<title>
			Goods Received Note
		</title>
	</head>
	<body style="margin-left: 5px; margin-top:5px; font-family:Arial;font-size: 12px;text-align:center">
	    <table width=100% style='border: 0'>
			<thead>		
				<th>					
					<img src="<?php echo base_url() ?>public/header/logo.jpg" alt="Header Image" width='100%' >										
				</th>
			</thead>
			<tbody id="table-body">
                <tr  class='calc'>
                    <td>
                        <table cellpadding=5 width=95% style='font-size: 20px;border:0;text-align:center'>
                            <tr height='22px'>
                                <td width=100% style="color:e8b41a">Goods Received Note</td>
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
                                            <td width=30%>Name</td><td>:</td><td width=70%><?php echo $grn[0]->supplier_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width=30%>Address</td><td>:</td><td width=70%><?php echo $grn[0]->billing_address; ?></td>
                                        </tr>
                                        <tr>
                                            <td width=30%>Contact No</td><td>:</td><td width=70%><?php echo $grn[0]->contact_number; ?></td>
                                        </tr>
                                        <tr>
                                            <td width=30%>Email</td><td>:</td><td width=70%><?php echo $grn[0]->supplier_email; ?></td>
                                        </tr>						
                                    </table>
                                </td>
                                
                                <td width='40%'>
                                    <table width=100% style='font-size: 12px;'>
                                          
                                            <tr>
                                                <td width=30%>Date:</td><td>:</td><td width=70%><?php echo $grn[0]->grn_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td width=30%>Doc No:</td><td>:</td><td width=70%><?php echo $grn[0]->grn_code; ?></td>
                                            </tr>
                                            <tr>
                                                <td width=30%>Supplier ID:</td><td>:</td><td width=70%><?php echo $grn[0]->supplier_name; ?></td>
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
                                <td>Prepared by:<?php echo $grn[0]->created_by;?></td><td></td><td></td><td></td><td></td><td></td>
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
                                    <td style='width:10%'>Model</td>
                                    <td style='width:18%'>Description</td>
                                    <td style='width:5%'>Qty</td>
                                    <td style='width:5%'>Unit</td>
                                    <td style='width:5%'>Price</td>
                                   
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

                                foreach ($grn_tr as $detail): 
                                    $total_before_vat += $detail->price * $detail->rec_quantity;
                                    // $total_discount += $detail->discount_amt;
                                    $grand_total += $detail->total;
                                endforeach;

                                // Example VAT Calculation (adjust if VAT is calculated differently)
                                $vat_amount = $grand_total - ($total_before_vat - $total_discount);
                               
                            foreach ($grn_tr as $detail): ?>
                                <tr class='calc' style="font-weight:bold" valign='top'>
                                    <td><?php echo $sl_no++; ?></td>
                                    <td><?php echo $detail->item_model; ?></td>
                                    <td><?php echo $detail->item_description; ?></td>
                                    <td><?php echo $detail->rec_quantity; ?></td>
                                    <td><?php echo $detail->unit_name; ?></td>
                                    <td><?php echo $detail->price; ?></td>
                                   
                                    <td><?php echo $detail->total; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Totals Row -->
                        <tr style="font-weight:bold;">
                            <td colspan="6" align="right">Total Before VAT</td>
                            <td><?php echo number_format($total_before_vat, 2); ?></td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="6" align="right">Discount Amount</td>
                            <td><?php echo number_format($total_discount, 2); ?></td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="6" align="right">VAT Amount</td>
                            <td><?php echo number_format($vat_amount, 2); ?></td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="6" align="right">Total Amount</td>
                            <td><?php echo number_format($grand_total, 2); ?></td>
                        </tr>
                        </tbody>
                        </table>
					</td>
				</tr>
               
               
              
                
				
			</tbody>
		
		</table>
       
	</body>
</html>






