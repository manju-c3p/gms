<html>
	<head>
		<title>
			Quotation
		</title>
	</head>
	<body style="margin-left: 5px; margin-top:5px; font-family:Arial;font-size: 12px;text-align:center">
	    <table width=100% style='border: 0'>
			<thead>		
				<th>					
					<img src="<?php echo base_url() ?>public/header/header.jpg" alt="Header Image" width='100%' >										
				</th>
			</thead>
			<tbody id="table-body">
                <tr  class='calc'>
                    <td>
                        <table cellpadding=5 width=95% style='font-size: 20px;border:0;text-align:center'>
                            <tr height='22px'>
                                <td width=100% style="color:e8b41a">Request for Quotation</td>
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
                                            <td width=30%>Name</td><td>:</td><td width=70%><?php echo $rfq_details[0]->supplier_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width=30%>Address</td><td>:</td><td width=70%><?php echo $rfq_details[0]->billing_address; ?></td>
                                        </tr>
                                        <tr>
                                            <td width=30%>Contact No</td><td>:</td><td width=70%><?php echo $rfq_details[0]->contact_no; ?></td>
                                        </tr>
                                        <tr>
                                            <td width=30%>Email</td><td>:</td><td width=70%><?php echo $rfq_details[0]->email_id; ?></td>
                                        </tr>						
                                    </table>
                                </td>
                                
                                <td width='40%'>
                                    <table width=100% style='font-size: 12px;'>
                                          
                                            <tr>
                                                <td width=30%>Date:</td><td>:</td><td width=70%><?php echo $rfq_details[0]->rfq_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td width=30%>Doc No:</td><td>:</td><td width=70%><?php echo $rfq_details[0]->rfq_code; ?></td>
                                            </tr>
                                            <tr>
                                                <td width=30%>Supplier ID:</td><td>:</td><td width=70%><?php echo $rfq_details[0]->supplier_code; ?></td>
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
                                <td>Prepared by:<?php echo $rfq_details[0]->rfq_created_by;?></td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                        </table>
                    </td>
                    
                </tr>
				<tr>
					<td>
                        <table cellpadding=10 width=100% style='font-size: 12px; border-collapse:collapse;border:2px solid'>
                            <thead>
                                <tr class='calc' style="background-color: #525453;color:e8b41a">
                                    <td style='width:2%'>Sl No</td>
                                    <td style='width:10%'>Model</td>
                                    <td style='width:3%'>Brand</td>
                                    <td style='width:18%'>Description</td>
                                    <td style='width:5%'>Qty</td>
                                    <td style='width:5%'>Unit</td>
                                    
                                </tr>
                            </thead>
                            <tbody style="background-color:#edebe4">
                            <?php 
                            $sl_no = 1;
                            foreach ($rfq as $detail): ?>
                                <tr class='calc' style="font-weight:bold" valign='top'>
                                    <td><?php echo $sl_no++; ?></td>
                                    <td><?php echo $detail->item_model; ?></td>
                                    <td><?php echo $detail->brand_name; ?></td>
                                    <td><?php echo $detail->item_description; ?></td>
                                    <td><?php echo $detail->quantity; ?></td>
                                    <td><?php echo $detail->unit_name; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
					</td>
				</tr>
               
               
              
                
				
			</tbody>
			<tfoot class='footer'>		
				
			</tfoot>
		</table>
	</body>
</html>






