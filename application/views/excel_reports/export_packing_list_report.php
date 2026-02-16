<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=Packing_report_List.xls");
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
        <tr>
            <td align="center">
                <p style="font-size:16px; font-weight:bold;">Print Packing Report List</p>
            </td>
        </tr>
    </table>
    <table width="100%" border=1 cellspacing="0" colspacing="0">
        <tr>
            <th align="center">Todays Date : <?php echo date('d-M-Y'); ?></th>
            <th> From Date : <?php echo $from; ?> </th>
            <th> To Date : <?php echo $to; ?> </th>
        </tr>
    </table>
    <br>
    <table width='100%' border=1 cellspacing="0" colspacing="0">
    <thead>
            <tr>
                <th>Sr.no</th>
                <th>PL Code</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Invoice</th>
               
            </tr>
        </thead>

        <tbody>
        <?php $sum = 0; if (!empty($records)) : ?>

            <?php $i = 1;
            foreach ($records as $row) : ?>
                <tr>
                    <td>
                        <?php echo $i;$i++; ?>
                    </td>
                    <td><?php echo $row->pl_code; ?></td>
                    <td><?php echo date('d-M-Y', strtotime($row->pl_date)); ?></td>
                    <td><?php echo $row->cust_name; ?></td>
                    <td><?php echo $row->grand_total; $sum += $row->grand_total; ?></td>
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
            <td style="text-align: right; width: 88%;">
							<?php
							echo "<b style='font-size: 23px;'>Total : " . $sum . "</b><br>";

							?>
			</td>
		</tr>
	</table>
</body>

</html>