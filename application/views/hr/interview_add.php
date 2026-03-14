<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_interview_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
    <div class="container my-4">    
    <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Form Code <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="form_code" required>
                    <option value="">Select Workforce requisition</option>
                    <?php foreach ($work_req_list as $req) { ?>
                        <option value="<?php echo $req->emp_req_id; ?>"><?php echo $req->emp_req_code; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Position <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="position" required>
                    <option value="">Select Designation</option>
                    <?php foreach ($desig_list as $desig) { ?>
                        <option value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Interview Date <span style="color: red;"> * </span></label>
                <input type="date" class="form-control" name="interview_date" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Name <span style="color: red;"> * </span></label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Source <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="source" required>
                    <option value="LinkedIn">LinkedIn</option>
                    <option value="Indeed">Indeed</option>
                    <option value="Employee Referral">Employee Referral</option>
                    <option value="Recruiter Contact">Recruiter Contact</option>
                    <option value="Job Fair">Job Fair</option>
                    <option value="Job Fair">Company Website</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">VISA Status <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="visa" required>
                    <option value="UAE National">UAE National</option>
                    <option value="Visit Visa">Visit Visa</option>
                    <option value="Resident Visa">Resident Visa</option>
                    <option value="Resident Visa Cancel">Resident Visa Cancel</option>
                    <option value="Freelance Visa">Freelance Visa</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">EID </label>
                <input type="text" class="form-control" name="eid" >
            </div>
            <div class="col-md-3">
                <label class="form-label">VISA Expiry <span style="color: red;"> * </span></label>
                <input type="date" class="form-control" name="eid_expiry" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quailification</label>
                <input type="text" class="form-control" name="qualification" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Experience <span style="color: red;"> * </span></label>
                <select class="form-control form-control-sm" name="experience" required>
                    <option value="1"> 0 - 1 </option>
                    <option value="2"> 1 - 2 </option>
                    <option value="3"> 2 - 5 </option>
                    <option value="4"> 5 - 10 </option>
                    <option value="5"> above 10 </option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Age <span style="color: red;"> * </span></label>
                <input type="number" class="form-control" name="age" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Mobile <span style="color: red;"> * </span></label>
                <input type="number" class="form-control" name="contact_no" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Notice Period <span style="color: red;"> * </span></label>
                <select name="notice_period" class="form-select" required>
                  <option value="">Select</option>
                  <option value="Immediate">Immediate</option>
                  <option value="7 Days">7 Days</option>
                  <option value="15 Days">15 Days</option>
                  <option value="30 Days">30 Days</option>
                  <option value="1 Month">1 Month</option>
                  <option value="2 Months">2 Months</option>
                  <option value="3 Months">3 Months</option>
              </select>            
            </div>
            <div class="col-md-3">
                <label class="form-label">Driving Licence Number</label>
                <input type="number" class="form-control" name="drive_licence">
            </div>
            <div class="col-md-3">
                <label class="form-label">Passport Number</label>
                <input type="text" class="form-control" name="passport_number">
            </div>
            <div class="col-md-3">
                <label class="form-label">Passport Expiry</label>
                <input type="date" class="form-control" name="pass_expiry">
            </div>
            <div class="col-md-3">
                <label class="form-label">Is short Listed</label>
                <select class="form-control form-control-sm" name="shortlisted" required>
                    <option value="No"> No </option>
                    <option value="Yes"> Yes </option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Resume Upload</label>
                <input type="file" class="form-control" name="resume">
            </div>
        </div>
        
        <br><h5 class="mt-2">Candidate Assessment</h5><br>
        <div class="mb-3">
            <label class="form-label">Strengths of the candidate</label>
            <textarea class="form-control" name="strengths" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Relevant Job Knowledge & Experience</label>
            <textarea class="form-control" name="job_knowledge" rows="3"></textarea>
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
                        <td><input type="number" class="form-control" name="communication" min="1" max="4" ></td>
                    </tr>
                    <tr>
                        <td>Knowledge & Experience</td>
                        <td><input type="number" class="form-control" name="knowledge" min="1" max="4" ></td>
                    </tr>
                    <tr>
                        <td>Confidence</td>
                        <td><input type="number" class="form-control" name="confidence" min="1" max="4" ></td>
                    </tr>
                    <tr>
                        <td>Approach to Work</td>
                        <td><input type="number" class="form-control" name="work_approach" min="1" max="4" ></td>
                    </tr>
                    <tr>
                        <td>Customer Orientation</td>
                        <td><input type="number" class="form-control" name="cust_orientation" min="1" max="4" ></td>
                    </tr>
                    <tr>
                        <td>Team Work</td>
                        <td><input type="number" class="form-control" name="team_work" min="1" max="4" ></td>
                    </tr>
                    <tr>
                        <td>Overall Rating</td>
                        <td><input type="number" class="form-control" name="overall_rating" min="1" max="4" ></td>
                    </tr>
                    <tr>
                        <td>Comment on Suitability/Reason for non-selection</td>
                        <td><textarea type="text" class="form-control" name="rejection_reason"></textarea>
                    </tr>
                    <tr>
                        <td>Recommendation</td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="recommendation" value="NR" id="nr">
                                <label class="form-check-label" for="nr">NR</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="recommendation" value="S" id="s">
                                <label class="form-check-label" for="s">S</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="recommendation" value="H" id="h">
                                <label class="form-check-label" for="h">H</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" checked name="recommendation" value="NS" id="ns">
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
                <input type="checkbox" name="edu_certificate" checked/>
            </div>
            <div class="mb-3">
                <label class="form-label">Every employment with start date and end date with reason for leaving (mark on the CV itself) </label>
                <input type="checkbox" name="exp_certificate" checked/>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">What is he / she looking for in the new job in the term of responsibilities/designation/Salary/career growth</label>
            <textarea class="form-control" name="expectation" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">What aspects did you like in your previous job, and why ?</label>
            <textarea class="form-control" name="past_job_likes" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">What aspects were you uncomfortable with in your previous job?</label>
            <textarea class="form-control" name="past_job_dislikes" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">How well the candidate fit?</label>
            <textarea class="form-control" name="job_fit" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Family Details - Parents,Spouse,Children</label>
            <textarea class="form-control" name="family" rows="3"></textarea>
        </div>
        <div class="row g-3">
            <div class="mb-3">
                <label class="form-label">Willingness to work late hours and weekends / to travel / to relocate (if required)</label>
                <input type="checkbox" name="work_agree" checked/>
            </div>
        </div>
        <br><h5 class="mt-4">Salary Details</h5><br/>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Current CTC (Monthly)</label>
                <input type="number" class="form-control" name="current_salary">
            </div>
            <div class="col-md-4">
                <label class="form-label">Expected Salary</label>
                <input type="number" class="form-control" name="expected_salary">
            </div>
            <div class="col-md-4">
                <label class="form-label">Offered Salary</label>
                <input type="number" class="form-control" name="offered_salary">
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
                        <td><input type="text" class="form-control" name="employer_1"></td>
                        <td><input type="text" class="form-control" name="employer_2"></td>
                    </tr>
                    <tr>
                        
                        <td>Organisation / designation</td>
                        <td><input type="text" class="form-control" name="desig_1"></td>
                        <td><input type="text" class="form-control" name="desig_2"></td>
                    </tr>
                    <tr>
                        
                        <td>Phone number and email id</td>
                        <td><input type="text" class="form-control" name="email_1"></td>
                        <td><input type="text" class="form-control" name="email_2"></td>
                    </tr>
                <tbody>
            </table>
        </div>
        <div class="row g-3">
            <div class="mb-3">
                <label class="form-label">Do you have any questions for us?</label>
                <textarea class="form-control" name="questions" rows="3"></textarea>
            </div>
        </div>
        
        </div>                
        <div class="text-center mt-4">
             
            <button type="submit" class="btn btn-success">Submit Form</button>
            <!-- <button type="button" class="btn btn-secondary" onclick="window.print()">Print Form</button> -->
        </div>
</div>
    </form>
</div>
