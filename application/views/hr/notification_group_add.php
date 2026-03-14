<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/Hr/get_notification_group'; ?>"
        autocomplete="off" enctype="multipart/form-data">

        <div class="form-group row align-items-center">
            <!-- Group Name -->
            <label class="col-form-label col-auto"><b>Group Name<span style="color:red">*</span></b></label>
            <div class="col-auto">
                <input type="text" required class="form-control form-control-sm" tabindex="1" id="group_name"
                    name="group_name" value="<?php echo $group_name; ?>" onblur="check_dept_exist();">
                <label id="dept_exits" style="color: red;"></label>
            </div>


            <!-- Designation -->
            <label class="col-form-label col-auto"><b>Select Designation:</b></label>
            <div class="col-sm-3">
                <select tabindex="3" class="form-select form-control-sm select2" id="designation_id"
                    name="designation_id">
                    <option value="">Select</option>
                    <?php foreach ($designation_list as $s): ?>
                        <option value="<?php echo $s->did; ?>" <?php if ($s->did == $designation_id)
                               echo 'selected'; ?>>
                            <?php echo htmlspecialchars($s->designation_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>


            </div>

            <!-- Submit Button -->
            <div class="col-auto">
                <input type="submit" id="view" name="go" value="Go" class="btn btn-sm btn-primary m-b-0" />
            </div>
        </div>
    </form>
</div>
<form id="secondary" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_notification_group_data"
    id="addform" autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" class="form-control form-control-sm" tabindex="1" id="group_name" name="group_name"
        value="<?php echo $group_name; ?>">

    <input type="hidden" class="form-control form-control-sm" tabindex="1" id="designation_id" name="designation_id"
        value="<?php echo $designation_id; ?>">



    <div class="dt-responsive table-responsive">
        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th><input type="checkbox" id="header-checkbox" onclick="toggleAllCheckbox()">&nbsp;</th>
                    <th>Employee Name</th>
                    <th>Designation Name<br>Department Name</th>


                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td><?php echo $i;
                        $i++; ?></td>
                        <td>
                            <input type="checkbox" id="checkbox" name="checkbox[]" class="checkbox"
                                value="<?php echo $row->user_id; ?>">
                        </td>
                        <td>
                            <?php echo $row->user_code; ?>&nbsp;&nbsp;&nbsp;<?php echo $row->user_name; ?>
                            <input type="hidden" id="user_id" name="user_id[]" value="<?php echo $row->user_id; ?>">
                        </td>
                        <td>
                            <?php echo $row->designation_name; ?><br><?php echo $row->dept_name; ?>

                        </td>






                    </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>
    <div class="form-group row">
        <label class="col-sm-4"></label>
        <div class="col-sm-10 text-center">
            <button type="submit" tabindex="4" id='add' class="btn btn-primary m-b-0 ">submit</button>
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




    // Function to toggle all checkboxes
    function toggleAllCheckbox() {
        const headerCheckbox = document.getElementById('header-checkbox');

        if (headerCheckbox.checked) {
            document.querySelectorAll('.checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
        } else {
            document.querySelectorAll('.checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    }

    // Add event listener to handle the header-present checkbox
    document.getElementById('header-checkbox').addEventListener('change', toggleAllCheckbox);
</script>
<script>

    function check_dept_exist() {
        var aname = $('#group_name').val();
        $.ajax
            ({
                url: "<?php echo site_url('Ajax/check_duplicate_exist'); ?>",
                type: 'POST',
                data: { table_name: 'notification_group', column_name: 'group_name', post_id: aname },
                success: function (msg) {
                    if (msg != 0) {
                        $('#dept_exits').html("Group already exits");
                        $('#group_name').val('');
                    }
                    else {
                        $('#dept_exits').html("");
                    }
                }
            });
    }
</script>
</div>
</div>