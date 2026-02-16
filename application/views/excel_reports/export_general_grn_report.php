<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=GRN_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php
foreach ($comapny_records as $row) {
    $company_name = $row->company_name;
    $company_address = $row->company_address;
    $company_city = $row->company_city;

    $company_pincode = $row->company_pincode;
    $company_country = $row->company_country;
    $company_email_id = $row->company_email_id;
    $company_telephone = $row->company_telephone;
    $company_website = $row->company_website;
    $company_TRN = $row->company_TRN;
}
?>
<html>

<body>
    <table width="100%" border=0 cellspacing="0" colspacing="0">
        <tr align="center">
            <td>
                <p style="font-size:16px; font-weight:bold;">GRN Report</p>
            </td>

        </tr>
    </table>
    <table width="100%" border=1 cellspacing="0" colspacing="0">
        <tr align="center">
            <th>Todays Date : <?php echo date('d-M-Y'); ?></th>
            <th> From Date : <?php echo $from; ?> </th>
            <th> To Date : <?php echo $to; ?> </th>
        </tr>
    </table>
    <br>
    <table width='100%' border=1 cellspacing="0" colspacing="0">
    <thead>
            <tr>
                <th>Srn</th>
                <th>GRN Code</th>
                <th>PO Code</th>
                <th>Supplier Name</th>
                <th>Supplier Invoice</th>
                <th>Warehouse</th>
                
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($records)) : ?>
            <?php $i = 1;
            foreach ($records as $row) : ?>
                <tr>
                    <td><?php echo  $i;
                        $i++; ?></td>
                    <td>
                        <?php echo $row->grn_code; ?></a><br>
                        <?php echo date('d-M-Y', strtotime($row->grn_date)); ?>
                    </td>
                    <td>
                    <?php echo $row->po_code; ?></a><br>
                        <?php echo date('d-M-Y', strtotime($row->po_date)); ?>
                    </td>
                    <td><?php echo $row->supplier_name; ?></td>
                    <td><?php echo $row->invoice_no . '<br>' . date('d-M-Y', strtotime($row->invoice_date)); ?></td>
                    <td><?php echo $row->warehouse_name; ?></td>
        
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>

    </table>


    <table>
		<tr>
			<td style="text-align: left; width: 88%;">
				<!-- <?php
				$ct = '';
				$ct = count($records);
				echo "<b>Records Total:</b> $ct";
				?> -->
					<?php
				$ct = 0; 

				if (is_array($records) || $records instanceof Countable) {
					$ct = count($records);
				} elseif ($records !== null) { 
					$ct = 0; 
				}

				echo "<b style='font-size: 23px;'>Records Total :</b> <b style='font-size: 23px;'>$ct</b>";

				?>
			</td> &nbsp;&nbsp;&nbsp;
           
		</tr>
	</table>

</body>

</html>