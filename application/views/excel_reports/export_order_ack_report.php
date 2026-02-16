<?php
header("Content-type: application/octet-stream");
header("Content-Disposition:attachment;filename=order_Ack_report.xls");
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
                <p style="font-size:16px; font-weight:bold;">Print Order Ack report</p>
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
                <th>Sno</th>
                <th>Quotation</th>
                <th>Date </th>
                <th>Customer</th>
                <th>Enquiry Type</th>

                <!-- <th>Petrostar NO</th>
                <th>Client PO</th> -->
                <!-- <th>Start Date</th>
                <th>Deliveyr Date</th> -->
            </tr>
        </thead>
        <tbody style="font-size:12px; font-weight:700px;">
        <?php if (!empty($records)) : ?>

            <?php $i = 1;
            foreach ($records as $row) : ?>
                <tr>
                    <td><?php echo $i;
                        $i++; ?></td>
                    <td>
                        <?php echo $row->quotation_code; ?><br>
                    </td>
                    <td><?php echo date('d-M-Y', strtotime($row->quotation_date)); ?></td>
                    <td><?php echo $row->cust_name; ?></td>
                    <td><?php echo $row->enq_type; ?></td>

                    <!-- <td><?php echo $row->petrostar_ref; ?></td>
                    <td><?php echo $row->po_number; ?></td> -->
                    <!-- <td><?php echo date('d-M-Y', strtotime($row->created_date)); ?></td>
                    <td><?php echo date('d-M-Y', strtotime($row->delivery_date)); ?></td> -->
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>