<html>
	<head>
		<title>
			Purchase Order Report
		</title>
        <style>
        @page {
            margin: 10mm 10mm 25mm 10mm;

            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
            }

            @bottom-left {
                content: "©<?php echo date('Y'); ?> For Avenger Electronics LLC, Designed and developed by Concepts 360 Plus";
            }
        }
    </style>
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
                    <td style="background-color:rgb(5, 117, 61)">
                        <table cellpadding=5 width=95% style='font-size: 15px;border:0;text-align:center'>
                            <tr height='25px' >
                                <td width=100% style="color:e8b41a">Purchase Order Report (<?php echo $_GET["from_date"]; ?> to <?php echo $_GET["to_date"]; ?>)</td>
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
                                    <td style='width:10%'>PO Code</td>
                                    <td style='width:10%'>PO Date</td>
                                    <td style='width:35%'>Supplier</td>
                                    <td style='width:18%'>Grand Total</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $sl_no = 1;
                            $total_grand = 0;

                            foreach ($records as $detail): 
                                $total_grand += $detail->grand_total;
                            ?>
                                <tr valign='top'>
                                    <td><?php echo $sl_no++; ?></td>
                                    <td><?php echo $detail->po_code; ?></td>
                                    <td><?php echo $detail->po_date; ?></td>
                                    <td><?php echo $detail->supplier_name; ?></td>
                                    <td><?php echo number_format($detail->grand_total, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- Total row -->
                            <tr>
                                <td colspan="4" align="right"><strong>Total:</strong></td>
                                <td><strong><?php echo number_format($total_grand, 2); ?></strong></td>
                            </tr>
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






