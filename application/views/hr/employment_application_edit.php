<div class="card-body">
    <style>
        .form-section{
            margin-top:2%;
        }
    </style>
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_employment_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        
            <div class="container my-4">    
                <div class="row form-section">
                    <div class="col-md-4">
                        <label class="form-label">Position Applied for:</label>
                        <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" >
                            <option value="">Select Designation</option>
                            <?php foreach ($desig_list as $desig) { ?>
                                <option <?php if($record->position_applied == $desig->did) echo "selected";?> value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Passport Size Photo:</label>
                        <input type="file" name="profile_pic" class="form-control" /> 
                        <?php if(!empty($record->profile_pic)){?>
                            <a target="_blank" href="<?php echo base_url() . 'public/uploded_documents/' . $record->profile_pic; ?>" >View Profile Picture</a>
                        <?php }?>
                    </div>  
                    
                    <div class="col-md-4">
                        <label class="form-label">Applicant Name:</label>
                        <input type="text" class="form-control" name="applicant_name" value="<?php echo $record->applicant_name; ?>">
                    </div>
                    
                </div>

                <div class="row form-section">
                    <div class="col-md-2">
                        <label class="form-label">Date:</label>
                        <input type="date" class="form-control" name="application_date" value="<?php echo $record->application_date; ?>">
                    </div>  
                    <div class="col-md-2"> 
                        <label class="form-label">Notice period Required:</label>
                        <input type="text" class="form-control" name="notice_period" value="<?php echo $record->notice_period; ?>">   
                    </div> 
                    <div class="col-md-2">
                        <label class="form-label">Date of Birth:</label>
                        <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $record->date_of_birth; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Age:</label>
                        <input type="number" class="form-control" name="age" id="age" value="<?php echo $record->age; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Contact Number:</label>
                        <input type="text" class="form-control" name="contact_number" value="<?php echo $record->contact_number; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label d-block">Driving License:</label>
                        <div class="form-check form-check-inline">
                        <input <?php if($record->driving_license == 'Yes') echo "checked";?> class="form-check-input" type="radio" name="driving_license" value="Yes">
                        <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input <?php if($record->driving_license == 'No') echo "checked";?> class="form-check-input" type="radio" name="driving_license" value="No" checked>
                        <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <div class="row form-section">
                    <div class="col-md-2">
                        <label class="form-label">Passport No:</label>
                        <input type="text" class="form-control" name="passport_no" value="<?php echo $record->passport_no; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Expiry:</label>
                        <input type="date" class="form-control" name="passport_expiry" value="<?php echo $record->passport_expiry; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Visa Status:</label>
                        <select  tabindex="18" class="select2 form-select form-control-sm " id="visa" name="visa">
                            <option <?php if($record->visa_status == '') echo "selected";?> value="">Select</option>
                            <option <?php if($record->visa_status == 'HM visa') echo "selected";?> value="HM visa">HM visa</option>
                            <option <?php if($record->visa_status == 'HM visa-Outside') echo "selected";?> value="HM visa-Outside">HM visa-Outside</option>
                            <option <?php if($record->visa_status == 'Freelance') echo "selected";?> value="Freelance">Freelance</option>
                            <option <?php if($record->visa_status == 'Visit Visa') echo "selected";?> value="Visit Visa">Visit Visa</option>
                        </select>  
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Expiry:</label>
                        <input type="date" class="form-control" name="visa_expiry" value="<?php echo $record->visa_expiry; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">EID No:</label>
                        <input type="text" class="form-control" name="eid_no" value="<?php echo $record->eid_no; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Expiry:</label>
                        <input type="date" class="form-control" name="eid_expiry" value="<?php echo $record->eid_expiry; ?>">
                    </div>
                </div>
                <div class="row form-section">
                    <div class="col-md-2">
                        <label class="form-label">Current employer</label>
                        <input type="text" class="form-control" name="curr_employer" value="<?php echo $record->curr_employer; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Current Position:</label>
                        <input type="text" class="form-control" name="curr_designation" value="<?php echo $record->curr_designation; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Current Employment From:</label>
                        <input type="date" name="curr_work_from" class="form-control" value="<?php echo $record->curr_work_from; ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">To:</label>
                        <input type="date" name="curr_work_to" class="form-control" value="<?php echo $record->curr_work_to; ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Current Salary(provide proof,before made the offer letter):</label>
                        <input type="text" class="form-control" name="curr_salary" value="<?php echo $record->curr_salary; ?>">
                    </div>
                    
                </div>
                            
                <div class="form-section">
                    <label class="form-label">Current Job Major Responsibilities</label>
                    <textarea class="form-control" rows="2" name="curr_responsibilities"><?php echo $record->curr_responsibilities; ?></textarea>
                </div> 

                <div class="form-section">
                    <label class="form-label">Reason for Seeking Change:</label>
                    <textarea class="form-control" rows="2" name="reason_change"><?php echo $record->reason_change; ?></textarea>
                </div>

                <div class="form-section">
                    <label class="form-label">Major Achievements:</label>
                    <textarea class="form-control" rows="2" name="achievements"><?php echo $record->achievements; ?></textarea>
                </div>
                            
                <div class="form-section">
                    <label class="form-label">Are you undertaking any course or studies at the present? If so, please mention.</label>
                    <textarea class="form-control" rows="2" name="curr_course"><?php echo $record->curr_course; ?></textarea>
                </div> 
                <div class="form-section">
                    <label class="form-label">Please provide information on any illeness or medical condition that you have have in the past 3 years.(Including ongoing medical treatment, if  any)</label>
                    <textarea class="form-control" rows="2" name="curr_medication"><?php echo $record->curr_medication; ?></textarea>
                </div> 
                 
            <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Education/Skills:</div>
                <p class="small text-muted">(Please list your qualification starting with the latest/professional qualification up to your 12th)</p>
                <table class="table table-bordered" id="educationTable">
                <thead>
                    <tr>
                        <th>Qualification/Skills</th>
                        <th>University/College/Institution</th>
                        <th>Grade/Percentage</th>
                        <th>Month & Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($education as $edu):?>
                        <tr>
                            <td width='20%'>
                                <input type="hidden" name="ed_id[]" value="<?php echo $edu->ed_id; ?>"/>
                                <input type="text" name="qualification[]" class="form-control" value="<?php echo $edu->qualification; ?>"></td>
                            <td width='30%'><input type="text" name="institute[]" class="form-control" value="<?php echo $edu->institute; ?>"></td>
                            <td width='10%'> <input type="text" name="grade[]" class="form-control" value="<?php echo $edu->grade; ?>"></td>
                            <td width='30%'>
                                <div class="d-flex gap-2">
                                    <select class="form-select" name="passout_month[]" required>
                                        <option <?php if($edu->passout_month == '') echo "selected";?> value="">Month</option>
                                        <option <?php if($edu->passout_month == 'January') echo "selected";?> value="January">January</option>
                                        <option <?php if($edu->passout_month == 'February') echo "selected";?> value="February">February</option>
                                        <option <?php if($edu->passout_month == 'March') echo "selected";?> value="March">March</option>
                                        <option <?php if($edu->passout_month == 'April') echo "selected";?> value="April">April</option>
                                        <option <?php if($edu->passout_month == 'May') echo "selected";?> value="May">May</option>
                                        <option <?php if($edu->passout_month == 'June') echo "selected";?> value="June">June</option>
                                        <option <?php if($edu->passout_month == 'July') echo "selected";?> value="July">July</option>
                                        <option <?php if($edu->passout_month == 'August') echo "selected";?> value="August">August</option>
                                        <option <?php if($edu->passout_month == 'September') echo "selected";?> value="September">September</option>
                                        <option <?php if($edu->passout_month == 'October') echo "selected";?> value="October">October</option>
                                        <option <?php if($edu->passout_month == 'November') echo "selected";?> value="November">November</option>
                                        <option <?php if($edu->passout_month == 'December') echo "selected";?> value="December">December</option>
                                    </select>
                                    <?php
                                    $startYear = 2000;
                                    $currentYear = date("Y");?>
                                    <select name="passout_year[]" class="form-select">
                                        <option value="">Year</option>
                                        <?php for ($year = $currentYear; $year >= $startYear; $year--) {?>
                                            <option <?php if($edu->passout_year == $year) echo "selected";?> value=<?php echo $year;?> ><?php echo $year;?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>  
                            </td>
                            <td width='10%'><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                    <td colspan='4'></td>
                    <td ><button type="button" class="btn btn-primary" onclick="addRow()">Add Row</button></td>
                    </tr>
                </tfoot>
                </table>
                
            </div>

            <!-- Dynamic Table -->
            <?php $family_details = [
                          'Father',
                          'Mother',
                          'Spouse',
                          ' ',
                        ];?>
            <div class="form-section">
                <div class="section-title">Family Details:</div>
                <table class="table table-bordered" id="familyTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Relationship</th>
                            <th>Occupation</th>
                            <th>Contact Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($family as $fam): ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="fam_id[]" value="<?php echo $fam->fam_id; ?>"/>
                                    <input type="text" name="name[]" class="form-control" value="<?php echo $fam->name;?>"></td>
                                <td><input type="text" name="relationship[]" class="form-control" value="<?php echo $fam->relation;?>"></td>
                                <td><input type="text" name="occupation[]" class="form-control" value="<?php echo $fam->occupation;?>"></td>
                                <td><input type="text" name="contact[]" class="form-control" value="<?php echo $fam->contact_no;?>"></td>
                                <!-- <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td> -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                      
            
            <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Employment History:</div>
                <table class="table table-bordered" id="companyTable">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Period From - To</th>
                        <th>Position</th>
                        <th>Responsibilities</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($works as $work): ?>
                <tr>
                    <td>
                        <input type="hidden" name="work_id[]" value="<?php echo $work->work_id; ?>"/>
                        <input type="text" name="company_worked[]" class="form-control" value="<?php echo $work->company_name;?>"></td>
                    <td><input type="date" name="worked_from[]" class="form-control" value="<?php echo $work->work_from;?>">
                    -
                    <input type="date" name="worked_to[]" class="form-control" value="<?php echo $work->work_to;?>"></td>
                    <td><input type="text" name="position[]" class="form-control" value="<?php echo $work->position;?>"></td>
                    <td><input type="text" name="responsibilities[]" class="form-control" value="<?php echo $work->responsibilities;?>"></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeCompanyRow(this)">Remove</button></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><label>Upload Signature</label></td>
                        <td colspan='3'>
                            <input type="file" name="emp_sign" class="form-control"/>
                            <?php if(!empty($record->candidate_sign)){?>
                                <a target="_blank" href="<?php echo base_url() . 'public/uploded_documents/' . $record->candidate_sign; ?>" >View Signature</a>
                            <?php }?>
                        </td>
                        <td ><button type="button" class="btn btn-primary" onclick="addCompanyRow()">Add Row</button></td>
                    </tr>
                </tfoot>
                </table>
                
            </div>

            

            <input type="hidden" name="emp_app_id" value="<?php echo $record->emp_app_id; ?>"/>
            <button type="submit" class="btn btn-success mt-2">Update Request</button>
            
        </div>
    </form>
</div>
<script>
    function addRow() {
        const table = document.getElementById("educationTable").getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);
        Array.from(newRow.querySelectorAll("input, textarea")).forEach(input => {
            input.value = "";
            input.readonly = false;
        });

        table.appendChild(newRow);
    }

    function addCompanyRow() {
        const table = document.getElementById("companyTable").getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);
        Array.from(newRow.querySelectorAll("input, textarea")).forEach(input => {
            input.value = "";
            input.readonly = false;
        });

        table.appendChild(newRow);
    }

    function removeRow(button) {
        const row = button.closest("tr");
        const table = row.closest("tbody");
        if (table.rows.length > 1) {
        row.remove();
        }
    }

    function removeCompanyRow(button) {
        const row = button.closest("tr");
        const table = row.closest("tbody");
        if (table.rows.length > 1) {
        row.remove();
        }
    }

    document.getElementById('dob').addEventListener('change', function () {
        const dob = new Date(this.value);
        const today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        document.getElementById('age').value = age >= 0 ? age : '';
    });

  
    </script>