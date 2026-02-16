<html>
	<head>
		<title>
			Goods Received Note
		</title>
	</head>
	<body style="margin-left: 5px; margin-top:5px; font-family:Arial;font-size: 12px;text-align:center">
	    <table width=100% style='border: 0'>
			
			<tbody id="table-body">
               
				
               
				<tr>
					<td>
                        <table cellpadding=10 width=100% style='font-size: 12px; border-collapse:collapse;border:1px solid'>
                            <thead>
                                <tr class='calc' style="background-color:rgb(165, 201, 183);color:rgb(99, 7, 63)a">
                                    <td style='width:2%'>Sl No</td>
                                    <td style='width:10%'>Model</td>
                                    <td style='width:10%'>Barcode</td>
                                </tr>
                            </thead>
                            <tbody >
                            <?php 
                            $sl_no=1;
                               foreach ($grn_tr as $detail): ?>
                                <tr class='calc' valign='top'>
                                    <td><?php echo $sl_no++; ?></td>
                                    <td><?php echo $detail->item_model; ?></td>
                                    <td><img src="<?php echo $detail->barcode; ?>" alt="barcode" /></td>
                                </tr>
                            <?php endforeach; $sl_no++; ?>
                            <!-- Totals Row -->
                       
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






