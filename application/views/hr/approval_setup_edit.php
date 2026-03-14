<div class="card-body">
    <?php foreach ($records as $row): ?>
        <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_approval_data"
            autocomplete="off" enctype="multipart/form-data">




            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
                    Approve Type :<span style="color: red;">*</span>
                </label>
                <div class="col-sm-5">
                    <select class="form-control form-control-sm " name="approve_type" id="approve_type" tabindex="3"
                        required disabled>
                        <option value="" selected>Select Approve Type</option>
                        <option value="Leave" <?php if ($row->approve_type == 'Leave')
                            echo 'selected'; ?>>Leave</option>
                        <option value="Resignation" <?php if ($row->approve_type == 'Resignation')
                            echo 'selected'; ?>>
                            Resignation</option>
                        <option value="Quotation" <?php if ($row->approve_type == 'Quotation')
                            echo 'selected'; ?>>Quotation
                        </option>
                        <option value="Cost Estimation" <?php if ($row->approve_type == 'Cost Estimation')
                            echo 'selected'; ?>>
                            Cost Estimation</option>
                        <option value="Purchase Order" <?php if ($row->approve_type == 'Purchase Order')
                            echo 'selected'; ?>>
                            Purchase Order</option>
                        <option value="Project Operational Manager" <?php if ($row->approve_type == 'Project Operational Manager')
                            echo 'selected'; ?>>Project Operational Manager</option>
                        <option value="BOQ DIRECTOR" <?php if ($row->approve_type == 'BOQ DIRECTOR')
                            echo 'selected'; ?>>BOQ DIRECTOR</option>
                        <option value="Project Payment Approval" <?php if ($row->approve_type == 'Project Payment Approval')
                            echo 'selected'; ?>>Project Payment Approval</option>
                        <option value="Clearance Form" <?php if ($row->approve_type == 'Clearance Form')
                            echo 'selected'; ?>>Clearance Form</option>
                            <option value="Performance Review Form" <?php if ($row->approve_type == 'Performance Review Form')
                            echo 'selected'; ?>>Performance Review Form</option>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">HR/HOD/Accounts/Ope-Director(Level
                    One):</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_hr" name="approve_hr"
                        onchange="check_dept_exist();">
                        <option value="">Select HR</option>
                        <?php foreach ($user_records as $hr) { ?>
                            <option <?php if ($row->approve_hr == $hr->user_id)
                                echo 'selected'; ?>
                                value="<?php echo $hr->user_id ?>"><?php echo $hr->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>



            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">HOD/Sales Director(Level Two):</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_admin_md"
                        name="approve_admin_md" onchange="check_dept_exist2();">
                        <option value="">Select Admin/DM</option>
                        <?php foreach ($user_records as $ad) { ?>
                            <option <?php if ($row->approve_admin_md == $ad->user_id)
                                echo 'selected'; ?>
                                value="<?php echo $ad->user_id ?>"><?php echo $ad->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">CEO(Level Three)</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_ceo" name="approve_ceo"
                        onchange="check_dept_exist3();">
                        <option value="">Select CEO</option>
                        <?php foreach ($user_records as $ad) { ?>
                            <option <?php if ($row->approve_ceo == $ad->user_id)
                                echo 'selected'; ?>
                                value="<?php echo $ad->user_id ?>"><?php echo $ad->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row->approve_id; ?>">
                    <button type="submit" tabindex="5" id="edit" class="btn btn-primary m-b-0">Update</button>
                </div>
            </div>
        </form>
    <?php endforeach ?>
</div>
</div>


<script>

    function check_dept_exist() {
        var atype = $('#approve_hr').val();
        var type = $('#approve_type').val();

        if (!atype || !type) return; // Don't proceed if fields are empty

        $.ajax({
            url: "<?php echo site_url('Ajax/check_duplicate_exist3'); ?>",
            type: 'POST',
            data: {
                table_name: 'approval_setup',
                column_name1: 'approve_hr',
                post_id1: atype,
                column_name2: 'approve_type',
                post_id2: type
            },
            success: function (msg) {
                if (msg != 0) {
                    $('#dept_exits').html("This (HR/HOD/Accounts) already assigned");
                    $('#approve_hr').val('').trigger('change');
                } else {
                    $('#dept_exits').html("");
                }
            }
        });
    }

    function check_dept_exist2() {
        var atype = $('#approve_admin_md').val();
        var type = $('#approve_type').val();

        if (!atype || !type) return;

        $.ajax({
            url: "<?php echo site_url('Ajax/check_duplicate_exist3'); ?>",
            type: 'POST',
            data: {
                table_name: 'approval_setup',
                column_name1: 'approve_admin_md',
                post_id1: atype,
                column_name2: 'approve_type',
                post_id2: type
            },
            success: function (msg) {
                if (msg != 0) {
                    $('#dept_exits2').html("This (HOD) already assigned");
                    $('#approve_admin_md').val('').trigger('change');
                } else {
                    $('#dept_exits2').html("");
                }
            }
        });
    }

    function check_dept_exist3() {
        var atype = $('#approve_ceo').val();
        var type = $('#approve_type').val();

        if (!atype || !type) return;

        $.ajax({
            url: "<?php echo site_url('Ajax/check_duplicate_exist3'); ?>",
            type: 'POST',
            data: {
                table_name: 'approval_setup',
                column_name1: 'approve_ceo',
                post_id1: atype,
                column_name2: 'approve_type',
                post_id2: type
            },
            success: function (msg) {
                if (msg != 0) {
                    $('#dept_exits3').html("This (CEO) already assigned");
                    $('#approve_ceo').val('').trigger('change');
                } else {
                    $('#dept_exits3').html("");
                }
            }
        });
    }

</script>