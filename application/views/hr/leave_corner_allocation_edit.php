<div class="card-body">


    <?php foreach ($records as $row): ?>
        <form onsubmit="return check_duplicate_exist();" id="main" method="post"
            action="<?php echo base_url() . 'index.php/'; ?>Hr/update_leave_corner_application" autocomplete="off"
            enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <?php foreach ($user_records as $s) {
                        if ($row->employee_id == $s->user_id) { ?>
                            <input type='text' class="form-control form-control-sm  bg-soft-gray" id="employee_id"
                                name="employee_id" value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
                            <input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
                            <input type='hidden' name="leave_id_hidden" value="<?php echo $row->leave_id; ?>" />
                    <?php

                        }
                    } ?>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave Code:</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <input tabindex="1" type="text" name="lv_code" id="lv_code" class="form-control bg-soft-gray"
                        value="<?php echo $row->leave_code; ?>" readonly>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application date:</label>
                <div class="col-sm-5">
                    <div class="input-group date ">
                        <input type="text" class="form-control form-control-sm " id="application_date"
                            name="application_date"
                            value="<?php echo date('d-m-Y', strtotime($row->application_date) ?? '') ?>" tabindex=2
                            readonly>
                        <div class="input-group-addon"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave Type :</label>
                <div class="col-sm-5">
                    <select class="form-select form-control-sm" name="ltype_id" id="ltype_id" tabindex=3>
                        <option value="" selected disabled>Please select leave type</option>
                        <?php foreach ($category as $cat) { ?>
                            <option
                                value="<?php echo $cat->leave_cat_id; ?>"
                                data-days="<?php echo $cat->leave_days; ?>"
                                <?php if ($row->leave_type == $cat->leave_cat_id) echo 'selected'; ?>>
                                <?php echo $cat->category_name; ?>
                            </option>
                        <?php } ?>
                        <!-- <option <?php if ($row->leave_type == 'Annaul Leave')
                                            echo 'selected'; ?> value="Annaul Leave">Annaul
                            Leave</option>
                        <option <?php if ($row->leave_type == 'Sick Leave')
                                    echo 'selected'; ?> value="Sick Leave">Sick Leave
                        </option>
                        <option <?php if ($row->leave_type == 'Maternity Leave')
                                    echo 'selected'; ?> value="Maternity Leave">
                            Maternity Leave</option>
                        <option <?php if ($row->leave_type == 'Compensatory Leave')
                                    echo 'selected'; ?>
                            value="Compensatory Leave">Compensatory Leave</option>
                        <option <?php if ($row->leave_type == 'Casual Leave')
                                    echo 'selected'; ?>
                            value="Casual Leave">Casual Leave</option>
                        <option <?php if ($row->leave_type == 'Emergency Leave')
                                    echo 'selected'; ?> value="Emergency Leave">
                            Emergency Leave</option>
                        <option <?php if ($row->leave_type == 'Other')
                                    echo 'selected'; ?> value="Other">Other</option> -->

                    </select>
                </div>
            </div>
            <div id="normal_leave_group">
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave From - To :</label>
                    <div class="col-sm-3">
                        <div class="input-group date ">
                            <input type="date" class="form-control form-control-sm " id="start_date" name="start_date"
                                value="<?php echo date('Y-m-d', strtotime($row->start_date) ?? '') ?>" tabindex=4>
                            <div class="input-group-addon"></i></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group date ">
                            <input type="date" class="form-control form-control-sm " id="end_date" name="end_date"
                                value="<?php echo date('Y-m-d', strtotime($row->end_date) ?? '') ?>" tabindex=5>
                            <div class="input-group-addon"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Total Days :</label>
                    <div class="col-sm-2">
                        <?php
                        $start_date = new DateTime($row->start_date);
                        $end_date = new DateTime($row->end_date);
                        $diff = $start_date->diff($end_date);
                        ?>
                        <input type="text" class="form-control form-control-sm" id="total_date" name="total_date"
                            value="<?php echo $diff->days + 1; ?>" tabindex=6 readonly>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Contact & Address In leave :</label>
                    <div class="col-sm-5">
                        <textarea id="outside_contact" name="outside_contact" rows="2"
                            placeholder="Contact & Address Outside Country" style="width: 100%;"
                            tabindex=7><?php echo $row->outside_contact; ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Reason :</label>
                    <div class="col-sm-5">
                        <textarea id="reason" name="reason" rows="2" placeholder="Specify reason for leave" style="width: 100%;"
                            tabindex=8><?php echo $row->reason; ?></textarea>
                    </div>
                </div>
                <div class="form-group row" id="joining_date_group" style="display: none;">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining Date From Last Leave:</label>
                    <div class="col-sm-5">
                        <div class="input-group date ">
                            <input type="date" class="form-control form-control-sm " id="last_date" name="last_date"
                                value="<?php echo date('Y-m-d', strtotime($row->joindate_fromlastLeave) ?? '') ?>" tabindex=9>
                            <div class="input-group-addon"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Charge Handed To :</label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                        <select tabindex="10" class="form-select form-control-sm select2" id="replcement" name="replcement">
                            <option value="">Select</option>
                            <?php foreach ($user_records as $s) { ?>
                                <option <?php if ($row->replcement == $s->user_id)
                                            echo 'selected'; ?>
                                    value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div id="comp_leave_group" style="display:none;">
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Working:<span style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control form-control-sm" id="date_working" name="date_working">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Comp Off:<span style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control form-control-sm" id="date_compoff" name="date_compoff">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea class="form-control form-control-sm" id="comp_remark" name="comp_remark"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label
                    class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg","png","doc","pdf"):</label>
                <div class="col-sm-6">
                    <table class="table table-bordered table-hover" id="tab_logic" tabindex=11>
                        <tbody>

                            <tr id='addr0'>
                                <td>1</td>
                                <td>
                                    <div class="col-sm-6">
                                        <input class="form-select form-control-sm" id="documents" name="documents[]"
                                            type="file">
                                    </div>
                                </td>
                                <td>
                                    <a id="add_row" title="Add" class="btn btn-sm bg-blue"><span
                                            class="fa fa-plus"></span></a>
                                    <a id='delete_row' title="Delete" class="btn btn-sm bg-blue"><span
                                            class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                            <?php if ($file_records) {
                                $x = 1;
                                $i = 1;
                                foreach ($file_records as $k) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $i;
                                            $i++; ?>
                                        </td>
                                        <td><a href="<?php echo base_url() . 'public/uploded_documents/' . $k->document_path; ?>"
                                                download>File <?php echo $x;
                                                                $x++; ?></a></td>
                                        <td></td>
                                    </tr>
                            <?php }
                            } ?>
                            <tr id='addr1'></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if ($row->leave_status != 1): ?>
                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="<?php echo $row->leave_id; ?>">
                        <button type="submit" tabindex="12" id="add" class="btn btn-primary m-b-0">Submit</button>
                    </div>
                </div>
            <?php endif; ?>
        </form>


        <?php if ($row->leave_status == 1 || $row->leave_status == 1): ?>
            <h6>Details of Leave Approval</h6>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                        style="color: red;">*</span></label>
                <div class="col-sm-5">
                    <div class="input-group date ">
                        <input type="text" class="form-control form-control-sm bg-light text-dark font-weight-bold" id="approve_date"
                            name="approve_date" value="<?php echo date('d-m-Y', strtotime($row->approved_date)); ?>" required
                            tabindex="1">
                        <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Leave From - To :</label>
                <div class="col-sm-3">
                    <div class="input-group date ">
                        <input type="date" class="form-control form-control-sm bg-light text-dark font-weight-bold" id="approve_start_date"
                            name="approve_start_date" onchange="approve_calculate_total_days()"
                            value="<?php echo date('Y-m-d', strtotime($row->approve_start_date)); ?>" tabindex="2">
                        <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group date ">
                        <input type="date" class="form-control form-control-sm bg-light text-dark font-weight-bold" id="approve_end_date"
                            name="approve_end_date" onchange="approve_calculate_total_days()"
                            value="<?php echo date('Y-m-d', strtotime($row->approve_end_date)); ?>" tabindex="3">
                        <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <!-- Total Leave Days -->
                <label class="col-sm-3 col-form-label font-weight-bold">Total Leave Days:</label>
                <div class="col-sm-2">
                    <?php
                    $approve_start_date = new DateTime($row->approve_start_date);
                    $approve_end_date = new DateTime($row->approve_end_date);
                    $approve_diff = $approve_start_date->diff($approve_end_date);
                    ?>
                    <input type="text" class="form-control form-control-sm bg-light text-dark font-weight-bold"
                        id="approve_total_date" name="approve_total_date" value="<?php echo $approve_diff->days; ?>" readonly>
                </div>

                <!-- Paid Leave Input -->
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Remaining Paid Leave:</label>
                <div class="col-sm-2">
                    <input type="number" class="form-control form-control-sm bg-light text-dark font-weight-bold" id="use_paid_leave" name="use_paid_leave" min="0"
                        max="<?php echo $row->use_paid_leave; ?>" oninput="updateRemainingLeave()" placeholder="Enter days"
                        value="<?php echo $row->use_paid_leave; ?>">

                    <span class="text-info font-italic small">
                        <!-- Remaining Paid Leave:
                        <strong id="remaining_leave">
                            <?php echo $row->use_paid_leave; ?>
                        </strong> -->
                        <input type="hidden" name="avilable_leave_rem" id="avilable_leave_rem"
                            value="<?php echo $row->use_paid_leave; ?>">
                    </span>
                </div>

                <!-- Available Leave Info -->

            </div>



            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave Status :<span
                        style="color: red;">*</span></label>
                <div class="col-sm-5">
                    <select class="form-select form-control-sm" name="leave_status" id="leave_status" required tabindex="4" disabled>
                        <option value="" selected disabled>Please select leave Status</option>

                        <option value="1" <?php if ($row->leave_status == 1)
                                                echo 'selected'; ?>>Approved</option>
                        <option value="2" <?php if ($row->leave_status == 2)
                                                echo 'selected'; ?>>Rejection</option>
                    </select>
                </div>
            </div>





            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approved Admin / MD</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_admin" name="approve_admin" disabled>
                        <option value="">Select</option>
                        <?php foreach ($admin_hr as $s) { ?>
                            <option <?php if ($row->admin_md == $s->admin_md_user_id)
                                        echo 'selected'; ?>
                                value="<?php echo $s->admin_md_user_id ?>"><?php echo $s->admin_md_user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approved Hr</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_hr" name="approve_hr" disabled>
                        <option value="">Select</option>
                        <?php foreach ($admin_hr as $h) { ?>
                            <option <?php if ($row->hr == $h->hr_user_id)
                                        echo 'selected'; ?> value="<?php echo $h->hr_user_id ?>">
                                <?php echo $h->hr_user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>



            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                <div class="col-sm-5">
                    <textarea id="approve_remark" class="disable-textarea" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
                        tabindex="5"><?php echo $row->approve_remark; ?></textarea>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach ?>

</div>
</div>
</div>
</div>
</div>

</div>


<script>
    $(document).ready(function() {
        var i = <?php echo count($file_records) + 1; ?>; // Set initial value of i to the count of existing files plus 1

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

        function toggleLeaveFields() {
            var selected = $('#ltype_id').val();

            if (selected && selected.toLowerCase().includes("compensatory")) {
                $('#normal_leave_group').hide();
                $('#comp_leave_group').show();

                // remove required from normal fields
                $('#normal_leave_group :input').prop('required', false);

                // add required to comp leave fields
                $('#date_working, #date_compoff').prop('required', true);

            } else {
                $('#normal_leave_group').show();
                $('#comp_leave_group').hide();

                // add required back to normal fields
                $('#start_date, #end_date, #charge_handed_to').prop('required', true);

                // remove required from comp leave fields
                $('#date_working, #date_compoff').prop('required', false);
            }

            // also handle "Joining Date From Last Leave" visibility for Annual Leave
            if (selected && selected.toLowerCase().includes("annual")) {
                $('#joining_date_group').show();
                $('#last_date').prop('required', true);
            } else {
                $('#joining_date_group').hide();
                $('#last_date').prop('required', false);
            }
        }

        toggleLeaveFields(); // run on load
        $('#ltype_id').on('change', toggleLeaveFields);
    });

    function calculate_total_days() {
        var startDateStr = document.getElementById('start_date').value;
        var endDateStr = document.getElementById('end_date').value;

        if (!startDateStr || !endDateStr) {
            document.getElementById("total_date").value = 0;
            return;
        }

        // Parse start date and end date in Y-m-d format
        var startDateArr = startDateStr.split('-');
        var endDateArr = endDateStr.split('-');

        var startDate = new Date(startDateArr[0], startDateArr[1] - 1, startDateArr[2]);
        var endDate = new Date(endDateArr[0], endDateArr[1] - 1, endDateArr[2]);

        const time = endDate - startDate;

        if (time < 0) {
            document.getElementById("total_date").value = 0; // invalid range
            return;
        }

        // Add 1 to include both start and end date
        const days = Math.floor(time / (1000 * 60 * 60 * 24)) + 1;

        document.getElementById("total_date").value = days;
    }

    // Call calculate_total_days() when there is a change in start_date or end_date fields
    document.getElementById('start_date').addEventListener('change', calculate_total_days);
    document.getElementById('end_date').addEventListener('change', calculate_total_days);

    // Set minimum date to today's date for all date inputs
    var today = new Date().toISOString().split('T')[0];
    // document.getElementById("start_date").setAttribute('min', today);
    // document.getElementById("end_date").setAttribute('min', today);
    document.getElementById("last_date").setAttribute('min', today);



    // function approve_calculate_total_days() {

    //     var startDateStr = document.getElementById('approve_start_date').value;
    //     var endDateStr = document.getElementById('approve_end_date').value;

    //     // Parse start date and end date in d-m-Y format
    //     var startDateArr = startDateStr.split('-');
    //     var endDateArr = endDateStr.split('-');

    //     var startDate = new Date(startDateArr[2], startDateArr[1] - 1, startDateArr[0]);
    //     var endDate = new Date(endDateArr[2], endDateArr[1] - 1, endDateArr[0]);

    //     const time = Math.abs(endDate - startDate);

    //     const days = Math.ceil(time / (1000 * 60 * 60 * 24));

    //     document.getElementById("approve_total_date").value = days;

    // }

    // // Call calculate_total_days() when there is a change in start_date or end_date fields
    // document.getElementById('approve_start_date').addEventListener('change', approve_calculate_total_days);
    // document.getElementById('approve_end_date').addEventListener('change', approve_calculate_total_days);
    //  // Set minimum date to today's date for all date inputs
    //  var today = new Date().toISOString().split('T')[0];
    // document.getElementById("approve_start_date").setAttribute('min', today);
    // document.getElementById("approve_end_date").setAttribute('min', today);

    function approve_calculate_total_days() {
        var startDateStr = document.getElementById('approve_start_date').value;
        var endDateStr = document.getElementById('approve_end_date').value;

        // Log the values to check if they are correct
        console.log("Start Date:", startDateStr);
        console.log("End Date:", endDateStr);

        // Parse start date and end date in Y-m-d format
        var startDateArr = startDateStr.split('-');
        var endDateArr = endDateStr.split('-');

        var startDate = new Date(startDateArr[0], startDateArr[1] - 1, startDateArr[2]);
        var endDate = new Date(endDateArr[0], endDateArr[1] - 1, endDateArr[2]);

        // Calculate the difference in time
        const time = endDate - startDate;

        // Calculate the difference in days (including the end date)
        const days = Math.ceil(time / (1000 * 60 * 60 * 24)) + 1;

        document.getElementById("approve_total_date").value = days;
    }

    // Call calculate_total_days() when there is a change in start_date or end_date fields
    document.getElementById('approve_start_date').addEventListener('change', approve_calculate_total_days);
    document.getElementById('approve_end_date').addEventListener('change', approve_calculate_total_days);

    // Set minimum date to today's date for all date inputs
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("approve_start_date").setAttribute('min', today);
    document.getElementById("approve_end_date").setAttribute('min', today);
    document.getElementById("last_date").setAttribute('min', today);
</script>