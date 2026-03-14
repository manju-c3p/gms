<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_workforce_requisition_data"
        class="form-horizontal" autocomplete="off" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Requesting Department<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="department" required>
                    <option value="">Select Department</option>
                    <?php foreach ($dept_list as $dept) { ?>
                        <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-form-label">Date of Request<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <input type="date" class="form-control form-control-sm" name="request_date" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Position Name<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="position_name" required>
                    <option value="">Select Position</option>
                    <?php foreach ($desig_list as $desig) { ?>
                        <option value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-form-label">Date of Required<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <input type="date" class="form-control form-control-sm" name="required_date" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Employee Type <span style="color: red;"> * </span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" checked type="radio" name="employee_type" value="1" id="permanent">
                    <label class="form-check-label" for="permanent">Permanent</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="employee_type" value="2" id="contract">
                    <label class="form-check-label" for="contract">Contract</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="employee_type" value="3" id="internship">
                    <label class="form-check-label" for="internship">Internship</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="employee_type" value="4" id="consultant">
                    <label class="form-check-label" for="consultant">Consultant</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="employee_type" value="5" id="other">
                    <label class="form-check-label" for="other">Other</label>
                </div>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Brief Description of Duties</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="job_description" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nature of Request<span style="color: red;"> * </span></label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" checked name="request_type" value="Replacement"
                        id="replacement">
                    <label class="form-check-label" for="replacement">Replacement</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="request_type" value="New Position"
                        id="new_position">
                    <label class="form-check-label" for="new_position">New Position</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Educational Requirement</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" name="education">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Preferred Qualifications/Experience</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="qualifications" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Roles and Responsibilities</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="roles_responsibility" rows="3"></textarea>
            </div>
        </div>

       <div class="form-group row">
    <label class="col-sm-2 col-form-label">Budgeted Salary</label>
    <div class="col-sm-3">   <!-- increased from col-sm-1 -->
        <input type="number" class="form-control form-control-sm" name="budgeted_salary">
    </div>

    <label class="col-sm-2 col-form-label">Budgeted Number</label>
    <div class="col-sm-1">
        <input type="number" class="form-control form-control-sm" name="budgeted_number">
    </div>

    <label class="col-sm-2 col-form-label">Existing Number</label>
    <div class="col-sm-1">
        <input type="number" class="form-control form-control-sm" name="existing_number">
    </div>

    <label class="col-sm-2 col-form-label">Vacancies</label>
    <div class="col-sm-1">
        <input type="number" class="form-control form-control-sm" name="vacancies">
    </div>
</div>

        <?php
        $all_approved_ids = array();
        $hr_flag = false;
        $hod_flag = false;
        $ceo_flag = false;
        $hr_readonly = "";
        $ceo_readonly = "";
        $login_user_id = $this->session->userdata('user_id');
        foreach ($comp_hr_hod_ceo as $allowed_users):
            $ceo_ids[] = $allowed_users->approve_ceo;
            $hr_ids[] = $allowed_users->approve_hr;
            $hod_ids[] = $allowed_users->approve_admin_md;
        endforeach;
        if (!empty($ceo_ids)) {
            $ceo_ids = array_unique($ceo_ids);
            if (in_array($login_user_id, $ceo_ids)) {
                $ceo_flag = true;
                $ceo_readonly = "";
            } else {
                $ceo_flag = false;
                $ceo_readonly = "disabled";
            }
        }
        if (!empty($hr_ids)) {
            $hr_ids = array_unique($hr_ids);
            if (in_array($login_user_id, $hr_ids)) {
                $hr_flag = true;
                $hr_readonly = "";
            } else {
                $hr_flag = false;
                $hr_readonly = "disabled";
            }
        }
        if (!empty($hod_ids)) {
            $hod_ids = array_unique($hod_ids);
            if (in_array($login_user_id, $hod_ids)) {
                $hod_flag = true;
            } else {
                $hod_flag = false;
            }
        }

        ?>
        <h3 class="mt-4">Approval</h3>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Requested By </label>
            <div class="col-sm-2">
           <select class="form-control form-control-sm" name="hod_sign" disabled>
        <?php foreach ($user_records as $user) {
        if ($user->user_id == $logged_user_id) { ?>
            <option value="<?php echo $user->user_id; ?>" selected>
                <?php echo $user->user_name; ?>
            </option>
       <?php }
      } ?>
   </select>
   <input type="hidden" name="hod_sign" value="<?php echo $logged_user_id; ?>">

    </div>
            <label class="col-sm-2 col-form-label">HR</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="hr_id" <?php echo $hr_readonly;?>>
                    <option value="">Select User</option>
                    <?php foreach ($comp_hr as $user) { ?>
                        <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">HR Approval</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="hr_approval" id="hr_approval" <?php echo $hr_readonly;?>>
                    <option value="0">Pending</option>
                    <option value="1">Approved</option>
                    <option value="2">Not Approved</option>
                </select>
                <?php if ($ceo_flag == true): ?>
                    <input type="hidden" name="hr_id" id="hr_id" value="" />
                    <input type="hidden" name="hr_approval" id="hr_approval" value="" />
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">CEO</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="ceo_id" <?php echo $ceo_readonly;?>>
                    <option value="">Select User</option>
                    <?php foreach ($comp_hr_hod_ceo as $user) { ?>
                        <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">Approved/Not Approved (CEO)</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="ceo_approval" id="ceo_approval" <?php echo $ceo_readonly; ?>>
                    <option value="0">Pending</option>
                    <option value="1">Approved</option>
                    <option value="2">Not Approved</option>
                </select>
                <?php if ($hr_flag == true): ?>
                    <input type="hidden" name="ceo_id" id="ceo_id" value="" />
                    <input type="hidden" name="ceo_approval" id="ceo_approval" value="0" />
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Notes</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="notes" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <input type="submit" class="btn btn-sm btn-primary" value="Submit">
            </div>
        </div>

    </form>
</div>