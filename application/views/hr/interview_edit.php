<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_interview_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
    <div class="container my-4">    
    <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Form Code <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="form_code" required>
                    <option value="">Select Workforce requisition</option>
                    <?php foreach ($work_req_list as $req) { ?>
                        <option <?php if($records->emp_req_id == $req->emp_req_id) echo "selected";?>  value="<?php echo $req->emp_req_id; ?>"><?php echo $req->emp_req_code; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Position <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="position" required>
                    <option value="">Select Designation</option>
                    <?php foreach ($desig_list as $desig) { ?>
                        <option <?php if($records->desig_id == $desig->did) echo "selected";?> value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Interview Date <span style="color: red;"> * </span></label>
                <input type="date" class="form-control" name="interview_date" value="<?php echo $req_date = date('Y-m-d', strtotime($records->interview_date));?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Name <span style="color: red;"> * </span></label>
                <input type="text" class="form-control" name="name" value="<?php echo $records->name; ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Source <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="source" required>
                    <option <?php if($records->source == "LinkedIn") echo "selected";?> value="LinkedIn">LinkedIn</option>
                    <option <?php if($records->source == "Indeed") echo "selected";?> value="Indeed">Indeed</option>
                    <option <?php if($records->source == "Employee Referral") echo "selected";?> value="Employee Referral">Employee Referral</option>
                    <option <?php if($records->source == "Recruiter Contact") echo "selected";?> value="Recruiter Contact">Recruiter Contact</option>
                    <option <?php if($records->source == "Job Fair") echo "selected";?> value="Job Fair">Job Fair</option>
                    <option <?php if($records->source == "Company Website") echo "selected";?> value="Company Website">Company Website</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">VISA Status <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="visa" required>
                    <option <?php if($records->visa == "UAE National") echo "selected";?> value="UAE National">UAE National</option>
                    <option <?php if($records->visa == "Visit Visa") echo "selected";?> value="Visit Visa">Visit Visa</option>
                    <option <?php if($records->visa == "Resident Visa") echo "selected";?> value="Resident Visa">Resident Visa</option>
                    <option <?php if($records->visa == "Resident Visa Cancel") echo "selected";?> value="Resident Visa Cancel">Resident Visa Cancel</option>
                    <option <?php if($records->visa == "Freelance Visa") echo "selected";?> value="Freelance Visa">Freelance Visa</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">EID </label>
                <input type="text" class="form-control" name="eid" value="<?php echo $records->eid;?>" >
            </div>
            <div class="col-md-3">
                <label class="form-label">VISA Expiry <span style="color: red;"> * </span></label>
                <input type="date" class="form-control" name="eid_expiry" value="<?php echo $eid_date = date('Y-m-d', strtotime($records->eid_expiry));?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quailification</label>
                <input type="text" class="form-control" name="qualification" value="<?php echo $records->qualification?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Experience <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="experience" required>
                    <option <?php if($records->experience == "1") echo "selected";?> value="1"> 0 - 1 </option>
                    <option <?php if($records->experience == "2") echo "selected";?> value="2"> 1 - 2 </option>
                    <option <?php if($records->experience == "3") echo "selected";?> value="3"> 2 - 5 </option>
                    <option <?php if($records->experience == "4") echo "selected";?> value="4"> 5 - 10 </option>
                    <option <?php if($records->experience == "5") echo "selected";?> value="5"> above 10 </option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Age <span style="color: red;"> * </span></label>
                <input type="number" class="form-control" name="age" value="<?php echo $records->age;?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mobile <span style="color: red;"> * </span></label>
                <input type="number" class="form-control" name="contact_no" value="<?php echo $records->contact_no;?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Notice Period <span style="color: red;"> * </span></label>
                <select name="notice_period" class="form-select" required>
                  <option value="">Select</option>
                  <option value="Immediate" <?= ($records->notice_period == 'Immediate') ? 'selected' : '' ?>>Immediate</option>
                  <option value="7" <?= ($records->notice_period == '7') ? 'selected' : '' ?>>7 Days</option>
                  <option value="15" <?= ($records->notice_period == '15') ? 'selected' : '' ?>>15 Days</option>
                  <option value="30" <?= ($records->notice_period == '30') ? 'selected' : '' ?>>30 Days</option>
                  <option value="60" <?= ($records->notice_period == '60') ? 'selected' : '' ?>>2 Months</option>
                  <option value="90" <?= ($records->notice_period == '90') ? 'selected' : '' ?>>3 Months</option>
               </select>            
            </div>
            <div class="col-md-3">
                <label class="form-label">Driving Licence Number</label>
                <input type="number" class="form-control" name="drive_licence" value="<?php echo $records->drive_licence;?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Passport Number</label>
                <input type="text" class="form-control" name="passport_number" value="<?php echo $records->passport_number;?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Passport Expiry</label>
                <input type="date" class="form-control" name="pass_expiry" value="<?php echo $eid_date = date('Y-m-d', strtotime($records->pass_expiry));?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Is short Listed</label>
                <select class="form-control form-control-sm" name="shortlisted" required>
                    <option <?php if($records->shortlisted == "No") echo "selected"; ?> value="No"> No </option>
                    <option <?php if($records->shortlisted == "Yes") echo "selected"; ?> value="Yes"> Yes </option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Resume Upload</label>
                <input type="file" class="form-control" name="resume">
                <?php if(!empty($records->resume)){?>
                    <a target="_blank" href="<?php echo base_url() . 'public/uploded_documents/' . $records->resume; ?>" >View Resume</a>
                <?php } ?>
            </div>
        </div>
        
        <br><h5 class="mt-2">Candidate Assessment</h5><br>
        <div class="mb-3">
            <label class="form-label">Strengths of the candidate</label>
            <textarea class="form-control" name="strengths" rows="3"> <?php echo $records->strengths;?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Relevant Job Knowledge & Experience</label>
            <textarea class="form-control" name="job_knowledge" rows="3"><?php echo $records->job_knowledge;?></textarea>
        </div>

        <p class="mt-1">Rating Scale (1 - Couldn't check, 2 - Low, 3 - Moderate, 4 - High)</p>
        <p class="mt-1">Legends NR- Next Round(shortlisted for another round of interview),S - Selected, H - Hold, NS - Not Suitable</p>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th width="30%">Parameters</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Communication Skills</td>
                        <td><input type="number" class="form-control" name="communication" min="1" max="4" value="<?php echo $records->communication;?>"></td>
                    </tr>
                    <tr>
                        <td>Knowledge & Experience</td>
                        <td><input type="number" class="form-control" name="knowledge" min="1" max="4" value="<?php echo $records->knowledge;?>"></td>
                    </tr>
                    <tr>
                        <td>Confidence</td>
                        <td><input type="number" class="form-control" name="confidence" min="1" max="4" value="<?php echo $records->confidence;?>"></td>
                    </tr>
                    <tr>
                        <td>Approach to Work</td>
                        <td><input type="number" class="form-control" name="work_approach" min="1" max="4" value="<?php echo $records->work_approach;?>"></td>
                    </tr>
                    <tr>
                        <td>Customer Orientation</td>
                        <td><input type="number" class="form-control" name="cust_orientation" min="1" max="4" value="<?php echo $records->cust_orientation;?>"></td>
                    </tr>
                    <tr>
                        <td>Team Work</td>
                        <td><input type="number" class="form-control" name="team_work" min="1" max="4" value="<?php echo $records->team_work;?>"></td>
                    </tr>
                    <tr>
                        <td>Overall Rating</td>
                        <td><input type="number" class="form-control" name="overall_rating" min="1" max="4" value="<?php echo $records->overall_rating;?>"></td>
                    </tr>
                    <tr>
                        <td>Comment on Suitability/Reason for non-selection</td>
                        <td><textarea type="text" class="form-control" name="rejection_reason"><?php echo $records->rejection_reason;?></textarea>
                    </tr>
                    <tr>
                        <td>Recommendation</td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input <?php if($records->recommendation == "NR") echo "checked";?> type="radio" class="form-check-input" name="recommendation" value="NR" id="nr">
                                <label class="form-check-label" for="nr">NR</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input <?php if($records->recommendation == "S") echo "checked";?> type="radio" class="form-check-input" name="recommendation" value="S" id="s">
                                <label class="form-check-label" for="s">S</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input <?php if($records->recommendation == "H") echo "checked";?> type="radio" class="form-check-input" name="recommendation" value="H" id="h">
                                <label class="form-check-label" for="h">H</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input <?php if($records->recommendation == "NS") echo "checked";?> type="radio" class="form-check-input" checked name="recommendation" value="NS" id="ns">
                                <label class="form-check-label" for="ns">NS</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="mt-1">checklist for HR round.HR has to check the following necessarily.</p>
        <div class="row g-3">
            <div class="mb-3">
                <label class="form-label">Every qualification with Month/Year of Completion (mark on the CV itself)</label>
                <input type="checkbox" name="edu_certificate" <?php if($records->edu_certificate == "yes") echo "checked";?>/>
            </div>
            <div class="mb-3">
                <label class="form-label">Every employment with start date and end date with reason for leaving (mark on the CV itself) </label>
                <input type="checkbox" name="exp_certificate" <?php if($records->exp_certificate == "yes") echo "checked";?>/>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">What is he / she looking for in the new job in the term of responsibilities/designation/Salary/career growth</label>
            <textarea class="form-control" name="expectation" rows="3"><?php echo $records->expectation;?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">What aspects did you like in your previous job, and why ?</label>
            <textarea class="form-control" name="past_job_likes" rows="3"><?php echo $records->past_job_likes;?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">What aspects were you uncomfortable with in your previous job?</label>
            <textarea class="form-control" name="past_job_dislikes" rows="3"><?php echo $records->past_job_dislikes;?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">How well the candidate fit?</label>
            <textarea class="form-control" name="job_fit" rows="3"><?php echo $records->job_fit;?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Family Details - Parents,Spouse,Children</label>
            <textarea class="form-control" name="family" rows="3"><?php echo $records->family;?></textarea>
        </div>
        <div class="row g-3">
            <div class="mb-3">
                <label class="form-label">Willingness to work late hours and weekends / to travel / to relocate (if required)</label>
                <input type="checkbox" name="work_agree" <?php if($records->work_agree == "yes") echo "checked";?>/>
            </div>
        </div>
        <br><h5 class="mt-4">Salary Details</h5><br/>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Current CTC (Monthly)</label>
                <input type="number" class="form-control" value="<?php echo $records->current_salary;?>" name="current_salary">
            </div>
            <div class="col-md-4">
                <label class="form-label">Expected Salary</label>
                <input type="number" class="form-control" value="<?php echo $records->expected_salary;?>" name="expected_salary">
            </div>
            <div class="col-md-4">
                <label class="form-label">Offered Salary</label>
                <input type="number" class="form-control" value="<?php echo $records->offered_salary;?>" name="offered_salary">
            </div>
        </div>
        <p class="mt-1">Two references - one from the last / latest employer and one from the previous employer - with name,designation,email-id and contact number of the person.Incase of fresher,educational contact details like principal and lecture.</p>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th width="30%">Particular</th>
                        <th>Refrence from the last latest employer</th>
                        <th>Refrence from the previous employer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" class="form-control" name="employer_1" value="<?php echo $records->employer_1;?>"></td>
                        <td><input type="text" class="form-control" name="employer_2" value="<?php echo $records->employer_2;?>"></td>
                    </tr>
                    <tr>
                        
                        <td>Organisation / designation</td>
                        <td><input type="text" class="form-control" name="desig_1" value="<?php echo $records->desig_1;?>"></td>
                        <td><input type="text" class="form-control" name="desig_2" value="<?php echo $records->desig_2;?>"></td>
                    </tr>
                    <tr>
                        
                        <td>Phone number and email id</td>
                        <td><input type="text" class="form-control" name="email_1" value="<?php echo $records->email_1;?>"></td>
                        <td><input type="text" class="form-control" name="email_2" value="<?php echo $records->email_2;?>"></td>
                    </tr>
                <tbody>
            </table>
        </div>
        <div class="row g-3">
            <div class="mb-3">
                <label class="form-label">Do you have any questions for us?</label>
                <textarea class="form-control" name="questions" rows="3"><?php echo $records->questions;?></textarea>
            </div>
        </div>
        <p class="mt-1">To be filled by HR for the selected candidates ( and signature obtained)</p>
        <?php 
                 $all_approved_ids = array();
                 $hr_flag = false;
                 $hod_flag = false;
                 $ceo_flag = false;
                 $hr_readonly = "";
                 $ceo_readonly = "";
                 $hod_readonly = "";
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
                         $hod_readonly="";
                     } else {
                         $hod_flag=false;
                         $hod_readonly="disabled";
                     }
                 }
            
                ?>
        <div class="row g-3">
            <?php //if($user_details[0]->desig_id == 61){?>
            <div class="col-md-3">
                <label class="form-label">Department</label>
                <select class="form-control form-control-sm" name="dept_id" >
                    <option value="">Select Department</option>
                    <?php foreach ($dept_list as $dept) { ?>
                        <option <?php if($records->dept_id == $dept->dept_id) echo "selected";?> value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">HOD</label>
                <select class="form-control form-control-sm" name="dept_hod_id" >
                    <option value="">Select User</option>
                    <?php foreach ($user_records as $user) { ?>
                        <option <?php if($records->dept_hod_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="col-sm-4 col-form-label">HOD Approval</label>
                <select class="form-control form-control-sm" name="dept_hod_approval" id="dept_hod_approval">
                    <option <?php if($records->dept_hod_approval == "0") echo "selected";?> value="0">Pending</option>
                    <option <?php if($records->dept_hod_approval == "1") echo "selected";?> value="1">Approved</option>
                    <option <?php if($records->dept_hod_approval == "2") echo "selected";?> value="2">Not Approved</option>
                </select>
            </div>
                <div class="col-md-3">
                    <label class="form-label">Signature by HR</label>
                    <select class="form-control form-control-sm" name="hr_id" <?php echo $hr_readonly;?>>
                        <option value="">Select User</option>
                        <?php foreach ($comp_hr as $user) { ?>
                            <option <?php if($records->hr_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="col-sm-4 col-form-label">HR Approval</label>
                    <select class="form-control form-control-sm" name="hr_approval" id="hr_approval" <?php echo $hr_readonly;?>>
                        <option <?php if($records->hr_approval == "0") echo "selected";?> value="0">Pending</option>
                        <option <?php if($records->hr_approval == "1") echo "selected";?> value="1">Approved</option>
                        <option <?php if($records->hr_approval == "2") echo "selected";?> value="2">Not Approved</option>
                    </select>
                    <?php if($hr_flag == false){?>
                        <input type="hidden" name="hr_id" id="hr_id" value="<?php echo $records->hr_id;?>"/>
                        <input type="hidden" name="hr_approval" id="hr_approval" value="<?php echo $records->hr_approval;?>"/>
                    <?php } ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Signature by CEO</label>
                    <select class="form-control form-control-sm" name="ceo_id" <?php echo $ceo_readonly;?>>
                        <option value="">Select User</option>
                        <?php foreach ($comp_ceo as $user) { ?>
                            <option <?php if($records->ceo_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="col-sm-4 col-form-label">CEO Approval</label>
                    <select class="form-control form-control-sm" name="ceo_approval" id="ceo_approval" <?php echo $ceo_readonly;?>>
                        <option <?php if($records->ceo_approval == "0") echo "selected";?> value="0">Pending</option>
                        <option <?php if($records->ceo_approval == "1") echo "selected";?> value="1">Approved</option>
                        <option <?php if($records->ceo_approval == "2") echo "selected";?> value="2">Not Approved</option>
                    </select>
                    <?php if($ceo_flag == false){?>
                        <input type="hidden" name="ceo_id" id="ceo_id" value="<?php echo $records->ceo_id;?>"/>
                        <input type="hidden" name="ceo_approval" id="ceo_approval" value="<?php echo $records->ceo_approval;?>"/>
                    <?php } ?>
                </div>
        </div>                
        <div class="text-center mt-4">
            <input type="hidden" name="int_id" id="int_id" value="<?php echo $records->int_id;?>" />
            <button type="submit" class="btn btn-success">Update Form</button>
            <!-- <button type="button" class="btn btn-secondary" onclick="window.print()">Print Form</button> -->
        </div>
</div>
    </form>
</div>
