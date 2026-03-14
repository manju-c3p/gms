<div>
    <div class="card-body">

        <form onsubmit="return check_duplicate_exist();" id="main" method="post"
            action="<?php echo base_url() . 'index.php/'; ?>Hr/add_approve_data" autocomplete="off"
            enctype="multipart/form-data">

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Type :<span
                        style="color: red;">*</span></label>
                <div class="col-sm-5">
                    <select class="form-select form-control-sm select2" name="approve_type" id="approve_type" tabindex=3
                        required>
                        <option value="" selected>Select Approve Type</option>
                        <option value="Leave">Leave</option>
                        <option value="Resignation">Resignation</option>
                        <option value="Quotation">Quotation</option>
                        <option value="Cost Estimation">Cost Estimation</option>
                        <option value="Purchase Order">Purchase Order</option>
                        <option value="Project Operationa Manager">Project Operational Manager</option>
                        <option value="Work Requisition Form">Work Requisition Form</option>
                        <option value="Interview Assessment">Interview Assessment</option>
                        <option value="Employee Compensatory Off Reimbursement">Employee Compensatory Off Reimbursement
                        </option>
                        <option value="BOQ DIRECTOR">BOQ DIRECTOR</option>
                        <option value="Project Payment Approval">Project Payment Approval</option>
                        <option value="Clearance Form">Clearance Form</option>
                        <option value="Performance Review Form">Performance Review Form</option>

                    </select>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">HR/HOD/Accounts/Ope-Director(Level One):</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_hr" name="approve_hr"
                        onchange="check_dept_exist();">
                        <option value="">Select HR</option>
                        <?php foreach ($user_records as $hr) { ?>
                            <option value="<?php echo $hr->user_id ?>"><?php echo $hr->user_name; ?></option>
                        <?php } ?>
                    </select>
                    <span id="dept_exits" style="color: red;"></span>
                </div>
            </div>



            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">HOD/Sales Director(Level Two):</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_admin_md"
                        name="approve_admin_md" onchange="check_dept_exist2();">
                        <option value="">Select Admin/DM</option>
                        <?php foreach ($user_records as $ad) { ?>
                            <option value="<?php echo $ad->user_id ?>"><?php echo $ad->user_name; ?></option>
                        <?php } ?>
                    </select>
                    <span id="dept_exits2" style="color: red;"></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">CEO(Level Three)</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="approve_ceo" name="approve_ceo"
                        onchange="check_dept_exist3();">
                        <option value="">Select CEO</option>
                        <?php foreach ($user_records as $ad) { ?>
                            <option value="<?php echo $ad->user_id ?>"><?php echo $ad->user_name; ?></option>
                        <?php } ?>
                    </select>
                    <span id="dept_exits3" style="color: red;"></span>
                </div>
            </div>


            <div class="form-group row justify-content-center">
                <div class="col-sm-8 text-center">
                    <!-- <input type="hidden" name="id" value="<?php echo $row->approve_id; ?>"> -->
                    <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>

        </form>


    </div>
    <!-- <div class="card-body">
        <div class="dt-responsive table-responsive">
            <table id="datatable" class="table table-striped" data-toggle="data-table">
                <thead>
                    <tr>

                        <th>Approve Type </th>
                        <th>Level One(HR/Manager)</th>
                        <th>Level Two(Admin /MD)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($records as $row) { ?>
                        <tr>
                            <td>
                                <?php echo $row->approve_type; ?>
                            </td>




                            <td><?php foreach ($user_records as $hr) { ?><?php if ($hr->user_id == $row->approve_hr) { ?><?php echo $hr->user_name; ?><?php } ?>
                                <?php } ?></td>


                            <td><?php foreach ($user_records as $hr) { ?><?php if ($hr->user_id == $row->approve_admin_md) { ?><?php echo $hr->user_name; ?><?php } ?>
                                <?php } ?></td>


                            <td>
                                <a href="#" title="Delete" onclick="return confirmCancel(<?php echo $row->approve_id; ?>);">
                                    <?php echo $this->session->userdata('delete_icon'); ?>
                                </a>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div> -->
</div>

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