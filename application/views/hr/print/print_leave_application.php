<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Application</title>
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
                             <!-- Header Logo -->
            <table border="0" style="margin-bottom:10px;">
                <tr>
                    <td align="left">
                        <img style="width:180px; height:80px;" src="<?php echo base_url() ?>public/logo/logo.png" />
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
                                        <td align="center" style="font-size: 25px;">Leave Application</td>
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
                                            <th>Joining Date:</th>
                                            <td><?php echo date('d-M-Y', strtotime($row->joining_date)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Employee Number:</th>
                                            <td><?php echo $row->user_code; ?></td>
                                            <th>Joining Date From Last Leave:</th>
                                            <td><?php echo date('d-M-Y', strtotime($row->joindate_fromlastLeave)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Designation:</th>
                                            <?php foreach ($desig_list as $ds) { ?>
                                                <?php if ($ds->did == $row->desig_id) { ?>
                                                    <td><?php echo $ds->designation_name; ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                            <th>Department/Project:</th>

                                            <?php foreach ($dept_list as $s) { ?>
                                                <?php if ($s->dept_id == $row->dept_id) { ?>
                                                    <td><?php echo $s->dept_name; ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <th>Mobile No:</th>
                                            <td><?php echo $row->contact_no; ?></td>
                                            <th>Passport No:</th>
                                            <?php foreach ($record1 as $d) : ?>
                                                <td><?php echo $d->document_number; ?></td>
                                            <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <th>Application Date:</th>
                                            <td><?php echo date('d-M-Y', strtotime($row->application_date)); ?></td>
                                            <th>Accommodation:</th>
                                            <td><?php echo $row->Accomodation_provided; ?></td>
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
                                        <th>Leave Purpose </th>
                                        <td><?php echo $row->reason; ?></td>

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
                                        <th>Leave Type </th>
                                        <td><?php echo $row->leave_type; ?></td>

                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- <tr>
                        <td colspan="2"> -->
                    <!-- Proper nesting of the last table within the structure -->
                    <!-- <div class="border-all">
                                <table cellspacing="0px" cellpadding="0px" width="100%" height="80px" class="table-bordered" style="border: 1px solid black;">
                                    <tbody>

                                        <tr>
                                            <th>Annual Leave</th>
                                            <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->leave_type == 'Annaul Leave') echo 'selected'; ?>>
                                                <?php echo ($row->leave_type == 'Annaul Leave') ? '&#10003;' : ''; ?>
                                            </td>
                                            <th>Emergency Leave</th>
                                            <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->leave_type == 'Emergency Leave') echo 'selected'; ?>>
                                                <?php echo ($row->leave_type == 'Emergency Leave') ? '&#10003;' : ''; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sick Leave</th>
                                            <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->leave_type == 'Sick Leave') echo 'selected'; ?>>
                                                <?php echo ($row->leave_type == 'Sick Leave') ? '&#10003;' : ''; ?>
                                            </td>
                                            <th>Other</th>
                                            <td style="text-align: center; font-size: 15px; vertical-align: middle;" <?php if ($row->leave_type == 'Other') echo 'selected'; ?>>
                                                <?php echo ($row->leave_type == 'Other') ? '&#10003;' : ''; ?>
                                            </td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr> -->
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
                                        <th>Leave Details </th>
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
                                            <th>Leave From Date:</th>
                                            <!-- <td id="form_date"></td> -->
                                            <td><?php echo date('d-M-Y', strtotime($row->start_date)); ?></td>
                                            <th>To Date:</th>
                                            <!-- <td id="end_date"></td> -->
                                            <td><?php echo date('d-M-Y', strtotime($row->end_date)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mobile No During Leave: </th>
                                            <td><?php echo $row->contact_no; ?></td>
                                            <th>Replaement If Any: </th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <!-- Total days-->
                            <div class="border-all">
                                <table cellspacing="0px" cellpadding="0px" width="100%" height="30px" class="table-bordered" style="border: 1px solid black;">
                                    <tbody>

                                        <tr>
                                            <?php
                                            $start_date = new DateTime($row->start_date);
                                            $end_date = new DateTime($row->end_date);
                                            $diff = $start_date->diff($end_date);
                                            ?>
                                            <th>Total Leave Days: </th>
                                            <td><?php echo $diff->days; ?></td>
                                        </tr>


                                    </tbody>
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
                                            <th>PM Signature: </th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>HR Signature: </th>
                                            <td></td>
                                            <th>MD Signature: </th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>


                </table>
                <!-- <img style="width: 20%; height: 20px; display: block; margin: 0 auto;" src="<?php echo base_url() ?>public/logo/print_footer.png" />
                <img style="width: auto; height: 20px; display: block; margin: 0 auto;" src="<?php echo base_url() ?>public/logo/print_footer_detils.png" /> -->

            </div>
    <?php $j++;
        endforeach;
    endif; ?>
</body>

</html>


<!-- <script>
    // Get release date and return date elements
    var formDateElement = document.getElementById("form_date");
    var endDateElement = document.getElementById("end_date");

    // Replace placeholders with actual release and return dates
    var formDate = new Date("<?php echo date('d-M-Y', strtotime($row->start_date)); ?>");
    var endDate = new Date("<?php echo date('d-M-Y', strtotime($row->end_date)); ?>");
    formDateElement.textContent = formDate.toDateString();
    endDateElement.textContent = endDate.toDateString();

    // Calculate total days
    var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
    var totalDays = Math.round(Math.abs((formDate - endDate) / oneDay));
    document.getElementById("total_days").textContent = totalDays;
</script> -->