<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_workforce_requisition_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Requesting Department<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="department" required>
                    <option value="">Select Department</option>
                    <?php foreach ($dept_list as $dept) { ?>
                        <option <?php if($records->dept_id == $dept->dept_id) echo "selected";?> value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-form-label">Date of Request<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <input type="date" value="<?php echo $req_date = date('Y-m-d', strtotime($records->request_date));?>" class="form-control form-control-sm" name="request_date" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Position Name<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="position_name" required>
                    <option value="">Select Position</option>
                    <?php foreach ($desig_list as $desig) { ?>
                        <option <?php if($records->desig_id == $desig->did) echo "selected";?> value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-sm-2 col-form-label">Date of Required<span style="color: red;"> * </span></label>
            <div class="col-sm-4">
                <input type="date" value="<?php echo $required_date = date('Y-m-d', strtotime($records->required_date));?>" class="form-control form-control-sm" name="required_date" required>
            </div>
        </div>

        <div class="form-group row">
        <label class="col-sm-2 col-form-label">Employee Type</label>
        <div class="col-sm-10">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if($records->emp_type == "1") echo "checked";?> name="employee_type" value="1" id="permanent">
                <label class="form-check-label" for="permanent">Permanent</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if($records->emp_type == "2") echo "checked";?> name="employee_type" value="2" id="contract">
                <label class="form-check-label" for="contract">Contract</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if($records->emp_type == "3") echo "checked";?> name="employee_type" value="3" id="internship">
                <label class="form-check-label" for="internship">Internship</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if($records->emp_type == "4") echo "checked";?> name="employee_type" value="4" id="consultant">
                <label class="form-check-label" for="consultant">Consultant</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if($records->emp_type == "5") echo "checked";?> name="employee_type" value="5" id="other">
                <label class="form-check-label" for="other">Other</label>
            </div>
        </div>

        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Brief Description of Duties</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="job_description" rows="3"><?php echo $records->job_desc; ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nature of Request</label>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" <?php if($records->request_type == "1") echo "checked";?> name="request_type" value="1" id="replacement">
                    <label class="form-check-label" for="replacement">Replacement</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" <?php if($records->request_type == "2") echo "checked";?> name="request_type" value="2" id="new_position">
                    <label class="form-check-label" for="new_position">New Position</label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Educational Requirement</label>
            <div class="col-sm-10">
                <input type="text" value="<?php echo $records->education_requirement; ?>" class="form-control form-control-sm" name="education">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Preferred Qualifications/Experience</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="qualifications" rows="3"><?php echo $records->preferred_qualification; ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Roles and Responsibilities</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="roles_responsibility" rows="3"> <?php echo $records->roles_responsibilities; ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Budgeted Salary</label>
            <div class="col-sm-3">
                <input type="number" class="form-control form-control-sm" name="budgeted_salary" value="<?php echo $records->budgeted_salary; ?>">
            </div>
            <label class="col-sm-2 col-form-label">Budgeted Number</label>
            <div class="col-sm-1">
                <input type="number" value="<?php echo $records->budgeted_no; ?>" class="form-control form-control-sm" name="budgeted_number">
            </div>

            <label class="col-sm-2 col-form-label">Existing Number</label>
            <div class="col-sm-1">
                <input type="number" value="<?php echo $records->existing_no; ?>" class="form-control form-control-sm" name="existing_number">
            </div>

            <label class="col-sm-2 col-form-label">Vacancies</label>
            <div class="col-sm-1">
                <input type="number" value="<?php echo $records->vacancy_no; ?>" class="form-control form-control-sm" name="vacancies">
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
                 foreach($comp_hr_hod_ceo as $allowed_users):
                     $ceo_ids[] = $allowed_users->approve_ceo;
                     $hr_ids[] = $allowed_users->approve_hr;
                     $hod_ids[] = $allowed_users->approve_admin_md;
                 endforeach;
                 if(!empty($ceo_ids)){
                     $ceo_ids = array_unique($ceo_ids);
                     if (in_array($login_user_id, $ceo_ids)) {
                         $ceo_flag=true;
                         $ceo_readonly ="";
                     } else {
                         $ceo_flag=false;
                         $ceo_readonly ="disabled";
                     }
                 }
                 if(!empty($hr_ids)){
                     $hr_ids = array_unique($hr_ids);
                     if (in_array($login_user_id, $hr_ids)) {
                         $hr_flag=true;
                         $hr_readonly="";
                     } else {
                         $hr_flag=false;
                         $hr_readonly="disabled";
                     }
                 }
                 if(!empty($hod_ids)){
                     $hod_ids = array_unique($hod_ids);
                     if (in_array($login_user_id, $hod_ids)) {
                         $hod_flag=true;
                     } else {
                         $hod_flag=false;
                     }
                 }
                
                ?>

        <h3 class="mt-4">Approval</h3>

        <div class="form-group row">
            
             <label class="col-sm-2 col-form-label">Requested By (HOD Sign)</label>
  <div class="col-sm-2">
    <?php
        // Find requested_by user name
        $requested_by_name = '';
        foreach ($user_records as $user) {
            if ($user->user_id == $records->requested_by) {
                $requested_by_name = $user->user_name;
                break;
            }
        }
    ?>
     <input type="text" class="form-control form-control-sm" value="<?php echo htmlspecialchars($requested_by_name); ?>" disabled>
     <input type="hidden" name="hod_sign" value="<?php echo $records->requested_by; ?>">
   </div>
           
            <label class="col-sm-2 col-form-label">HR</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="hr_id" <?php echo $hr_readonly;?>>
                    <option value="">Select User</option>
                    <?php foreach ($comp_hr as $user) { ?>
                        <option <?php if($records->hr_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
                <?php if($ceo_flag == true):?>   
                    <input type="hidden" name="hr_id" id="hr_id" value="<?php echo $records->hr_id;?>"/>
                    <input type="hidden" name="hr_approval" id="hr_approval" value="<?php echo $records->hr_approval;?>"/>
                <?php endif; ?>
            </div> 
                   
            <label class="col-sm-2 col-form-label">HR Approval</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="hr_approval" id="hr_approval" <?php echo $hr_readonly;?>>
                    <option <?php if($records->hr_approval == "0") echo "selected";?> value="0">Pending</option>
                    <option <?php if($records->hr_approval == "1") echo "selected";?> value="1">Approved</option>
                    <option <?php if($records->hr_approval == "2") echo "selected";?> value="2">Not Approved</option>
                </select>
                
            </div>
        </div>
                
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">CEO</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="ceo_id" <?php echo $ceo_readonly;?>>
                    <option value="">Select User</option>
                    <?php foreach ($comp_hr_hod_ceo as $user) { ?>
                        <option <?php if($records->ceo_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
                <?php if($hr_flag == true):?>
                    <input type="hidden" name="ceo_id" id="ceo_id" value="<?php echo $records->ceo_id;?>"/>
                    <input type="hidden" name="ceo_approval" id="ceo_approval" value="<?php echo $records->ceo_approval;?>"/>
                <?php endif; ?>
            </div>
            <label class="col-sm-3 col-form-label">Approved/Not Approved (CEO)</label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm" name="ceo_approval" id="ceo_approval" <?php echo $ceo_readonly;?>>
                    <option <?php if($records->ceo_approval == "0") echo "selected";?> value="0">Pending</option>
                    <option <?php if($records->ceo_approval == "1") echo "selected";?> value="1">Approved</option>
                    <option <?php if($records->ceo_approval == "2") echo "selected";?> value="2">Not Approved</option>
                </select>
                
            </div>
        </div>
                   
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Notes</label>
            <div class="col-sm-10">
                <textarea class="form-control form-control-sm" name="notes" rows="3"><?php echo $records->notes; ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <input type="hidden" name="emp_req_id" id="emp_req_id" value="<?php echo $records->emp_req_id;?>" /> 
                <input type="submit" class="btn btn-sm btn-primary" value="Submit">
            </div>
        </div>
        
    </form>
</div>
