<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passport Release</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 17px;
            font-size: 12px;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 11px;
            width: 100%;
        }

        th,
        td {
            padding: 4px;
            border: 1px solid black;
        }

        .section-title {
            background-color: #ff0080;
            color: #fff;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            padding: 6px;
        }

        .sub-title {
            background-color: #f0f0f0;
            font-weight: bold;
            padding: 4px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .footer img {
            width: 100%;
            height: 25px;
        }
        @media print {
  body {
    margin: 0;
  }
  .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
  }
 .footer img {
    width: 100% !important;   /* always full page width */
    height: 60px;             /* fixed height */
    object-fit: cover;        /* stretch/crop if needed */
}
}
    </style>
</head>

<body onload="window.print();">

    <?php if (!empty($record1)) :
        $j = 0;
        foreach ($record1 as $row) :
    ?>
        <div class="border-all">

            <!-- Header Logo -->
            <table border="0" style="margin-bottom:10px;">
                <tr>
                    <td align="left">
                        <img style="width:180px; height:80px;" src="<?php echo base_url() ?>public/logo/logo.png" />
                    </td>
                </tr>
            </table>

            <!-- Title -->
            <div class="section-title">Passport Release Application</div>

            <!-- General Information -->
            <div class="sub-title">General Information</div>
            <table>
                <tr>
                    <th>Employee Name:</th>
                    <td><?php echo $row->user_name; ?></td>
                    <th>Passport No:</th>
                    <td><?php echo $row->document_number; ?></td>
                </tr>
                <tr>
                    <th>Employee Number:</th>
                    <td><?php echo $row->user_code; ?></td>
                    <th>Accommodation:</th>
                    <td><?php echo $row->Accomodation_provided; ?></td>
                </tr>
                <tr>
                    <th>Mobile No:</th>
                    <td><?php echo $row->contact_no; ?></td>
                    <th>Department/Project:</th>
                    <td>
                        <?php foreach ($dept_list as $s) {
                            if ($s->dept_id == $row->dept_id) {
                                echo $s->dept_name;
                            }
                        } ?>
                    </td>
                </tr>
            </table>

            <!-- Purpose -->
            <div class="sub-title">Passport Release Purpose</div>
            <table>
                <tr>
                    <th>Please Specify:</th>
                    <td><?php echo $row->reason; ?></td>
                </tr>
            </table>

            <!-- Release Details -->
            <div class="sub-title">Passport Release Details</div>
            <table>
                <tr>
                    <th>Release Date:</th>
                    <td><?php echo date('d-M-Y', strtotime($row->outdate)); ?></td>
                    <th>Return Date:</th>
                    <td><?php echo date('d-M-Y', strtotime($row->indate)); ?></td>
                </tr>
            </table>

            <!-- Total Days -->
            <table>
                <tr>
                    <?php
                    $outdate = new DateTime($row->outdate);
                    $indate = new DateTime($row->indate);
                    $diff = $outdate->diff($indate);
                    ?>
                    <th>Total Days:</th>
                    <td><?php echo $diff->days; ?></td>
                </tr>
            </table>

            <!-- Signatures -->
            <table>
                <tr>
                    <th>Employee Signature:</th>
                    <td></td>
                    <th>Camp In Charge Signature:</th>
                    <td></td>
                </tr>
                <tr>
                    <th>HR Signature:</th>
                    <td></td>
                    <th>MD Signature:</th>
                    <td></td>
                </tr>
            </table>

            <!-- <div class="footer">
  <img src="<?php echo base_url() . 'public/logo/footer1.png'; ?>" 
       alt='footer-logo' 
       style="width:200%; max-height:120px; object-fit:contain;">
</div> -->

        </div>
    <?php
        $j++;
        endforeach;
    endif; ?>

</body>
</html>
