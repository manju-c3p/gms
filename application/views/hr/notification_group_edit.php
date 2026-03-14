<form id="secondary" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_notification_group"
    id="addform" autocomplete="off" enctype="multipart/form-data">

    <div class="form-group row align-items-center">
        <!-- Group Name -->
        <?php $i = 1;
        foreach ($records as $r) { ?>
            <label class="col-form-label col-auto"><b>Group Name </b></label>
            <div class="col-auto">
                <input type="text" class="form-control form-control-sm bg-soft-gray" tabindex="1" id="group_name"
                    name="group_name" value="<?php echo $r->group_name; ?>" readonly>
            </div>


            <!-- Designation -->
            <label class="col-form-label col-auto"><b>Select Designation:</b></label>
            <div class="col-sm-3">
                <select tabindex="3" class="form-select form-control-sm select2" id="designation_id" name="designation_id">
                    <option value="">Select</option>
                    <?php foreach ($designation_list as $s): ?>
                        <option value="<?php echo $s->did; ?>" <?php if ($s->did == $r->design_id)
                               echo 'selected'; ?>>
                            <?php echo htmlspecialchars($s->designation_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>


            </div>
        <?php } ?>

    </div>


    <p style="color: red;">
        If you want to remove users from the
        <strong style="color: #007bff;"><u><?php echo $r->group_name; ?></u></strong>
        group, please unselect the users you want to remove and click "Update" to apply the changes.
    </p>


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
                <?php
                // Extract user_ids from matched list
                $matched_ids = array_column($record1, 'user_id');

                // Split users from $record1 into two groups: matched and unmatched
                $matched_users = [];
                $unmatched_users = [];

                foreach ($record3 as $row) {
                    if (in_array($row->user_id, $matched_ids)) {
                        $matched_users[] = $row;
                    } else {
                        $unmatched_users[] = $row;
                    }
                }

                // Merge so matched users show first, then unmatched
                $all_users = array_merge($matched_users, $unmatched_users);

                // Now display the table rows
                $i = 1;
                foreach ($all_users as $row): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <input type="checkbox" class="checkbox" name="checkbox[]" value="<?php echo $row->user_id; ?>"
                                <?php echo in_array($row->user_id, $matched_ids) ? 'checked' : ''; ?>>
                        </td>
                        <td>
                            <?php echo $row->user_code . ' ' . $row->user_name; ?>
                            <input type="hidden" name="user_id[]" value="<?php echo $row->user_id; ?>">
                        </td>
                        <td>
                            <?php echo $row->designation_name . '<br>' . $row->dept_name; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

    </div>
    <div class="form-group row">
        <label class="col-sm-4"></label>
        <div class="col-sm-10 text-center">
            <input type="hidden" class="form-control form-control-sm" tabindex="1" id="group_id" name="group_id"
                value="<?php echo $r->group_id; ?>">
            <button type="submit" tabindex="4" id='add' class="btn btn-primary m-b-0 ">Update</button>
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
    function toggleAllCheckbox() {
        const headerCheckbox = document.getElementById('header-checkbox');
        const checkboxes = document.querySelectorAll('.checkbox');
        checkboxes.forEach(cb => cb.checked = headerCheckbox.checked);
    }

    function updateHeaderCheckbox() {
        const checkboxes = document.querySelectorAll('.checkbox');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        document.getElementById('header-checkbox').checked = allChecked;
    }

    window.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.checkbox');
        const headerCheckbox = document.getElementById('header-checkbox');

        updateHeaderCheckbox();

        headerCheckbox.addEventListener('change', toggleAllCheckbox);
        checkboxes.forEach(cb => cb.addEventListener('change', updateHeaderCheckbox));
    });
</script>