<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=PO_Report.xls");
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
                <p style="font-size:16px; font-weight:bold;">PO Report</p>
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
                <th>Sr.no</th>
                <th>PO Code</th>
                <th>PO Date</th>
                <th>Supplier & Ref No</th>
                <th>Grand total</th>

            </tr>
        </thead>

        <tbody>
        <?php $sum = 0; if (!empty($records)) : ?>
            <?php $i = 1;
            foreach ($records as $row) : ?>
                <tr>
                    <td><?php echo $i;
                        $i++; ?></td>
                    <td>
                        <?php echo $row->po_code; ?><br>
                        <?php $ev = $row->revision;
                        if ($row->revision > 0) {
                            for ($k = 1; $k <= $ev; $k++) { ?>
                                <u><a target='_blank' href="<?php echo base_url() . 'index.php/Purchase/PO_print/' . $row->po_id . '/' . $k . '/0'; ?>" title="View Revision">Revision <?php echo $k; ?></a></u><br>
                        <?php }
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo date('d-M-Y', strtotime($row->po_date)); ?>
                    </td>
                    </td>
                    <td>

                        <?php echo $row->supplier_name; ?>

                        <br>
                        <?php echo $row->supplier_ref; ?>
                    </td>
                    <td><?php echo $row->grand_total; $sum += $row->grand_total; ?>

                    </td>

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