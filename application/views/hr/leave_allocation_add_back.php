<!-- load jQuery and jQuery UI -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> -->

<!-- load jQuery UI CSS theme -->
<!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<style>
    /* Adjust the width of the datepicker input field */
    .datepicker-wrapper .datepicker {
        width: 200px;
        /* Adjust the width as needed */
    }

    /* Adjust the size of the calendar */
    .ui-datepicker {
        font-size: 14px;
        /* Adjust the font size of the calendar */
        width: 200px;
        /* Adjust the width of the calendar */
    }
</style> -->




<!-- the datepicker input -->
<div class="card-body">
    <form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_leave_application_data" autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
                <select tabindex="1" class="form-select form-control-sm select2" id="employee_id" name="employee_id" required>
                    <option value="">Select</option>
                    <?php foreach ($user_records as $s) { ?>
                        <option <?php if ($this->session->userdata('user_id') == $s->user_id) echo 'selected'; ?> value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- value="<?php echo date('d-m-Y') ?>" -->
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application date:</label>
            <div class="col-sm-4">
                <div class="input-group date">
                    <input type="date" class="form-control form-control-sm" id="application_date" name="application_date" value="<?php echo date('Y-m-d'); ?>" tabindex="2">
                    <div class="input-group-addon"></div>
                </div>
            </div>
        </div>




        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave Type :<span style="color: red;">*</span></label>
            <div class="col-sm-4">
                <select class="form-select form-control-sm" name="ltype_id" id="ltype_id" tabindex=3 required>
                    <option value="" selected disabled>Please select leave type</option>
                    <option value="Personal Leave">Personal Leave</option>
                    <option value="Annaul Leave">Annaul Leave</option>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Maternity Leave">Maternity Leave</option>
                    <option value="Compensatory Leave">Compensatory Leave</option>
                    <option value="Sick/Casaul Leave">Sick/Casaul Leave</option>
                    <option value="Emergency Leave">Emergency Leave</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave From - To :<span style="color: red;">*</span></label>
            <div class="col-sm-2">
                <div class="input-group date">
                    <input type="date" class="form-control form-control-sm" id="start_date" name="start_date" value="<?php echo date('Y-m-d') ?>" tabindex="4" required onchange="calculate_total_days()">
                    <label id="leave_exists" style="color: red;"></label>
                    <div class="input-group-addon"></div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group date ">
                    <input type="date" class="form-control form-control-sm " id="end_date" name="end_date" value="<?php echo date('Y-m-d') ?>" tabindex="5" required onchange="calculate_total_days()">
                    <div class="input-group-addon"></div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Total Days :</label>
            <div class="col-sm-2">
                <input type="text" class="form-control form-control-sm" id="total_date" name="total_date" type="text" readonly tabindex=6>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Contact & Address In leave :</label>
            <div class="col-sm-4">
                <textarea id="outside_contact" name="outside_contact" rows="2" placeholder="Contact & Address Outside Country" style="width: 100%;" tabindex=7></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Reason :</label>
            <div class="col-sm-4">
                <textarea id="reason" name="reason" rows="2" placeholder="Specify reason for leave" style="width: 100%;" tabindex=8></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining Date From Last Leave:<span style="color: red;">*</span></label>
            <div class="col-sm-4">
                <div class="input-group date">
                    <input type="date" class="form-control form-control-sm" id="last_date" name="last_date" value="<?php echo date('Y-m-d'); ?>" tabindex="9" required>
                    <div class="input-group-addon"></div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Charge Handed To : <span style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
                <select class="form-select form-control-sm select2" id="replcement" name="replcement" tabindex=10>
                    <option value="">Select</option>
                    <?php foreach ($user_records as $s) { ?>
                        <option <?php if ($this->session->userdata('user_id') == $s->user_id) echo 'selected'; ?> value="<?php echo $s->user_id ?>" required><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg","png","doc","pdf"):</label>
            <div class="col-sm-4">
                <table class="table table-bordered table-hover" id="tab_logic">
                    <tbody>
                        <tr id='addr0'>
                            <td>1</td>
                            <td>
                                <div class="col-sm-6">
                                <input class="form-select form-control-sm" id="documents" name="documents[]" type="file" style="font-size: 0.5rem; padding: 0.25rem 0.5rem; height: 30px;">
                                </div>
                            </td>
                            <td>
                                <a id="add_row" title="Add" class="btn btn-sm bg-blue"><span class="fa fa-plus"></span></a>
                                <a id='delete_row' title="Delete" class="btn btn-sm bg-blue"><span class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                        <tr id='addr1'></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- <div class="form-group row">
            
                    <input type="date" id="demo" >
                    
                </div>
            </div>
        </div> -->

        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Submit</button>
            </div>
        </div>
    </form>


</div>
</div>
</div>
</div>
</div>
</div>

<script>
    $(document).ready(function() {
        var i = 1;
        $("#add_row").click(function() {
            $('#addr' + i).html("<td>" + (i + 1) + "</td><td><div class='col-sm-6'><input class='form-control' id='documents" + i + "' name='documents[]' type='file'></div></td><td></td>");
            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
        });

        $("#delete_row").click(function() {
            if (i > 1) {
                $("#addr" + (i - 1)).html('');
                i--;
            }
        });

    });

    $("#tab_logic").on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });
    //this following function is calculate total days
    function calculate_total_days() {
        var startDateStr = document.getElementById('start_date').value;
        var endDateStr = document.getElementById('end_date').value;

        // Parse start date and end date in Y-m-d format
        var startDateArr = startDateStr.split('-');
        var endDateArr = endDateStr.split('-');

        var startDate = new Date(startDateArr[0], startDateArr[1] - 1, startDateArr[2]);
        var endDate = new Date(endDateArr[0], endDateArr[1] - 1, endDateArr[2]);

        const time = Math.abs(endDate - startDate);

        const days = Math.ceil(time / (1000 * 60 * 60 * 24));

        document.getElementById("total_date").value = days;

    }

    //add a calender to hide privious date thi functionality
    var date = new Date();
    var tdate = date.getDate();
    var month = date.getMonth() + 1;

    if (tdate < 10) {
        tdate = '0' + tdate;
    }
    if (month < 10) {
        month = '0' + month;
    }

    var year = date.getUTCFullYear();
    var mindate = year + "-" + month + "-" + tdate;

   // document.getElementById("application_date").setAttribute('min', mindate);
    document.getElementById("start_date").setAttribute('min', mindate);
    document.getElementById("end_date").setAttribute('min', mindate);
    document.getElementById("last_date").setAttribute('min', mindate);
    console.log(mindate);



    // function check_date_exist() {
    //     var startDate = $('#start_date').val();

    //     $.ajax({
    //         url: "<?php echo site_url('Ajax/check_exist_leave_application'); ?>",
    //         type: 'POST',
    //         data: {
    //             start_date: startDate
    //         },
    //         success: function(msg) {
    //             if (msg != 0) {
    //                 $('#leave_exists').text("Leave record already exists for the selected start date.");
    //             } else {
    //                 $('#leave_exists').text("");
    //             }
    //         }
    //     });
    // }
</script>



<!-- <script>
    function check_date_exist() {
        var empId = $('#employee_id').val();
        var appDate = $('#application_date').val();
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var leaveType = $('#ltype_id').val();
        $.ajax({
            url: "<?php echo site_url('Ajax/check_duplicate_exist2'); ?>",
            type: 'POST',
            data: {
                table_name: 'employee_leave',
                column_name1: 'employee_id',
                post_id1: empId,
                column_name2: 'application_date',
                post_id2: appDate,
                column_name3: 'start_date',
                post_id3: startDate,
                column_name4: 'end_date',
                post_id4: endDate,
                column_name5: 'leave_type',
                post_id5: leaveType,
            },
            success: function(msg) {
                if (msg != 0) {
                    $('#leave_exits').html("leave already exits from date");
                    $('#start_date').val('');
                } else {
                    $('#leave_exits').html("");
                }
            }
        });
    }



    ///new 
    // function check_date_exist() {
    //     var empId = $('#employee_id').val();
    //     var appDate = $('#application_date').val();
    //     var startDate = $('#start_date').val();
    //     var endDate = $('#end_date').val();
    //     var leaveType = $('#ltype_id').val();

    //     // Convert date format to YYYY-MM-DD
    //     appDate = formatDate(appDate);
    //     startDate = formatDate(startDate);
    //     endDate = formatDate(endDate);

    //     $.ajax({
    //         url: "<?php echo site_url('Ajax/check_exist_leave_application'); ?>",
    //         type: 'POST',
    //         data: {
    //             table_name: 'employee_leave',
    //             column_name1: 'employee_id',
    //             post_id1: empId,
    //             column_name2: 'application_date',
    //             post_id2: appDate,
    //             column_name3: 'start_date',
    //             post_id3: startDate,
    //             column_name4: 'end_date',
    //             post_id4: endDate,
    //             column_name5: 'leave_type',
    //             post_id5: leaveType,
    //         },
    //         success: function(response) {
    //             if (response != 0) {
    //                 $('#leave_exits').html("Leave already exists from this date");
    //                 $('#start_date').val('');
    //             } else {
    //                 $('#leave_exits').html("");
    //                 // calculate_total_days(); // Recalculate total days after successful check
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(xhr.responseText);
    //         }
    //     });
    // }

    // // Function to format date to YYYY-MM-DD
    // function formatDate(date) {
    //     var parts = date.split("-");
    //     retur n parts[2] + "-" + parts[1] + "-" + parts[0];
    // }
</script> -->