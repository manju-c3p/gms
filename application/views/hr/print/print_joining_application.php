<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joining Application</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 17px;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 11px;
        }

        th,
        td {
            padding: 1px;
        }
    </style>


</head>

<body onload="window.print();">
    <?php if (!empty($records)) :
        $j = 0;
        foreach ($records as $row) :
            // print_r($row);
            // die;
    ?>
            <div class="border-all">
                <table border="0px" style="font-size: 18px;" width="100%">
                    <tr>
                        <td></td>
                        <td>
                            <table style="margin-top: 0%;" width="100%">
                                <tr>
                                    <td align="Left">
                                        <img style="width: 50%; height: 100px;" src="<?php echo base_url() ?>public/logo/logo.png" />
                                    </td>
                                    <td align="right">
                                        <img style="width: 25%; height: 100px;" src="<?php echo base_url() ?>public/logo/logoold.png" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="border-all">
                                <table cellspacing="0px" cellpadding="0px" width="100%" class="text_font" style=" background-color: #ff0080;">
                                    <tr>
                                        <td align="center" style="font-size:25px;">Joining Application</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="border-all">
                                <table cellspacing="0px" cellpadding="0px" width="100%" class="text_font">
                                    <tr>
                                        <th>General Information</th>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <!-- Proper nesting of the last table within the structure -->
                            <div class="border-all">
                                <table cellspacing="0px" cellpadding="0px" width="100%" height="80px" class="table-bordered" style="border: 1px solid black;">
                                    <tbody>
                                        <tr>
                                            <th>Employee Name:</th>
                                            <td><?php echo $row->user_name; ?></td>
                                            <th>Direct Manager</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>Employee Number:</th>
                                            <td><?php echo $row->user_code; ?></td>
                                            <th>Department/Project:</th>
                                            <?php foreach ($dept_list as $s) { ?>
                                                <?php if ($s->dept_id == $row->dept_id) { ?>
                                                    <td><?php echo $s->dept_name; ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <th>Designation:</th>
                                            <td></td>
                                            <th>Passport No:</th>
                                            <?php foreach ($record1 as $d) : ?>
                                                <td><?php echo $d->document_number; ?></td>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <th>Mobile No:</th>
                                            <td><?php echo $row->contact_no; ?></td>
                                            <th>Accommodation:</th>
                                            <td><?php echo $row->Accomodation_provided; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Application Date:</th>
                                            <td><?php echo date('d-M-Y', strtotime($row->joind)); ?></td>
                                            <th>Receive Offer Letter?</th>
                                            <td <?php if ($row->offer_letter == '1') : ?>value="Yes">Yes</td>
                                        <?php else : ?>
                                            value="No">No
                        </td>
                    <?php endif; ?>
                    </tr>
                    </tbody>
                </table>
            </div>
            </td>
            </tr>

            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>

            <tr>
                <td colspan="2">
                    <div class="border-all">
                        <table cellspacing="0px" cellpadding="0px" width="100%" class="text_font">
                            <tr>
                                <th>Joining Type</th>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <!-- Proper nesting of the last table within the structure -->
                    <div class="border-all">
                        <table cellspacing="0px" cellpadding="0px" width="100%" height="80px" class="table-bordered" style="border: 1px solid black;">
                            <tbody>
                                <tr>
                                    <th>Resuming After Leave</th>
                                    <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->joining_type == 'Resuming After Leave') echo 'selected'; ?>>
                                        <?php echo ($row->joining_type == 'Resuming After Leave') ? '&#10003;' : ''; ?>
                                    </td>
                                    <th>Observation Period</th>
                                    <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->joining_type == 'Observation Period') echo 'selected'; ?>>
                                        <?php echo ($row->joining_type == 'Observation Period') ? '&#10003;' : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Newly Join</th>
                                    <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->joining_type == 'Newly Join') echo 'selected'; ?>>
                                        <?php echo ($row->joining_type == 'Newly Join') ? '&#10003;' : ''; ?>
                                    </td>
                                    <th>Other</th>
                                    <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->joining_type == 'Other') echo 'selected'; ?>>
                                        <?php echo ($row->joining_type == 'Other') ? '&#10003;' : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                <th style="font-size: 13px;"><b>If Other, Please Specify:</b></th>
                <td></td>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <div class="border-all">
                        <table cellspacing="0px" cellpadding="0px" width="100%" class="text_font">
                            <tr>
                                <th>Actual First Joining Date:</th>
                                <td> <?php echo date('d-M-Y', strtotime($row->joind)); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <!-- Proper nesting of the last table within the structure -->
                    <div class="border-all">
                        <table cellspacing="0px" cellpadding="0px" width="100%" height="80px" class="table-bordered" style="border: 1px solid black;">
                            <tbody>
                                <tr>
                                    <th>Employee Signature:</th>
                                    <td></td>
                                    <th>PM Signature:</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>HR Signature:</th>
                                    <td></td>
                                    <th>MD Signature:</th>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </table>
            <img style="width: 20%; height: 20px; display: block; margin: 0 auto;" src="<?php echo base_url() ?>public/logo/print_footer.png" />
            <img style="width: auto; height: 20px; display: block; margin: 0 auto;" src="<?php echo base_url() ?>public/logo/print_footer_detils.png" />
            </div>
    <?php $j++;
        endforeach;
    endif; ?>
</body>

</html>