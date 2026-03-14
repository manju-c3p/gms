
<div class="card-body">
<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_emp_attendance_data" id="addform" autocomplete="off" enctype="multipart/form-data">

    <div class="form-group row">
        <label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-form-label "> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b> Date: </b></label>
        <div class="col-sm-3">
            <div class="input-group date datepicker1">
                <input type="text" class="form-control form-control-sm datepicker1" tabindex="1" id="Attendance_date" name="Attendance_date" value="<?php echo date('d-m-Y') ?>">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>

    <br><br>

    <div class="dt-responsive table-responsive">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th><input type="checkbox" id="header-present">&nbsp;Present</th>
                    <th>Present In Time</th>
                    <th>Present Out Time</th>
                    <th><input type="checkbox" id="header-absent">&nbsp;Absent</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td>
                            <?php echo $row->user_code; ?>&nbsp;&nbsp;&nbsp;<?php echo $row->user_name; ?>
                        </td>
                        <td>
                            <input type="checkbox" class="present-checkbox" <?php echo $row->present ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <div id="inOutTimeFields">
                                <div class="form-group row">
                                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label" style=" font-size:11px; ">In Time : </label>
                                    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                                        <input type='time' id='in_time' name='in_time' class="form-control form-control-sm " style="width: 110px; font-size:11px; " value='<?php echo date('H:i'); ?>'>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                           <div id="inOutTimeFields">
                                <div class="form-group row">
                                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label" style=" font-size:11px; ">Out Time:</label>
                                    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                                        <input type='time' id='out_time' name='out_time' class="form-control form-control-sm" style="width: 110px; font-size:11px; " value='<?php echo date('H:i'); ?>'>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td style="width: 10px;">
                            <input type="checkbox" class="absent-checkbox" <?php echo $row->absent ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                <?php  } ?>

            </tbody>
        </table>

    </div>
    <div class="form-group row">
        <label class="col-sm-4"></label>
        <div class="col-sm-10 text-center">
            <button type="submit" id='add' class="btn btn-primary m-b-0 ">submit</button>
        </div>
    </div>
    </form>


</div>

</div>
</div>
</div>
</div>
</div>
</div>

<!-- Static Table End -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle the 'Present' header checkbox
        document.getElementById('header-present').addEventListener('change', function() {
            const checked = this.checked;
            const checkboxes = document.querySelectorAll('.present-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = checked;
            });
        });

        // Handle the 'Absent' header checkbox
        document.getElementById('header-absent').addEventListener('change', function() {
            const checked = this.checked;
            const checkboxes = document.querySelectorAll('.absent-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = checked;
            });
        });
    });


    function showFields() {
        var attendance = document.getElementById("attendance").value;
        var inOutTimeFields = document.getElementById("inOutTimeFields");
        if (attendance === "present") {
            inOutTimeFields.style.display = "block";
        } else {
            inOutTimeFields.style.display = "none";
        }
    }

    // function calculateTotalDuration(index) {
    //     var inTime = document.getElementById('in_time' + index).valueAsDate;
    //     var outTime = document.getElementById('out_time' + index).valueAsDate;

    //     if (inTime && outTime) {
    //         var totalTime = new Date(outTime - inTime);
    //         var hours = totalTime.getUTCHours();
    //         var minutes = totalTime.getUTCMinutes();

    //         // Format the total time
    //         var formattedTotalTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;

    //         // Set the value to the Total Time field
    //         document.getElementById('total_time' + index).value = formattedTotalTime;
    //     }
    // }
</script>