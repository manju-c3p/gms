<html>
	<head>
		<title>
			Request FOr Quotation Report
		</title>
	</head>
	<body style="margin-left: 5px; margin-top:5px; font-family:Arial;font-size: 12px;text-align:center">
	    <table width=100% style='border: 0'>
			
			<tbody id="table-body">
                <tr  class='calc'>
                    <td>
                        <table cellpadding=5 width=95% style='font-size: 20px;border:0;text-align:center'>
                            <tr height='22px'>
                                <td width=100% style="color:e8b41a">Request for Quotation Report</td>
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
                                            <td align="center">RFQ Report from <?php echo $_GET["from_date"]; ?> to <?php echo $_GET["to_date"]; ?></td>
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
                                <td>Prepared by:<?php ?></td>
                            </tr>
                        </table>
                    </td>   
                </tr>
				<tr>
					<td>
                        <table cellpadding=10 width=100% style='font-size: 12px; border-collapse:collapse;border:1px solid'>
                            <thead>
                                <tr class='calc' style="border:1px solid #000;font-weight:bold;">
                                    <td style='width:2%'>Sl No</td>
                                    <td style='width:10%'>RFQ Code</td>
                                    <td style='width:3%'>RFQ Date</td>
                                    <td style='width:18%'>Supplier</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $sl_no = 1;
                            foreach ($records as $detail): ?>
                                <tr valign='top'>
                                    <td><?php echo $sl_no++; ?></td>
                                    <td><?php echo $detail->rfq_code; ?></td>
                                    <td><?php echo $detail->rfq_date; ?></td>
                                    <td><?php echo $detail->supplier_name; ?></td>
                                   
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






