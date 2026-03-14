<div class="card-body">

    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_clearance_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
    <div class="container my-4">    
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Name:<span style="color:red;">*</span></label>
                    <select class="form-control form-control-sm select2" id="user_id" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" disabled>
                        <option value="">Select User</option>
                        <?php foreach ($user_records as $user) { ?>
                            <option <?php if($user->user_id == $record->user_id) echo "selected"; ?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Resignation:</label>
                    <input type="date" name="resig_date" class="form-control" value='<?php echo $record->resignation_date; ?>' />
                </div>            
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Emp CODE:</label>
                    <input type="text" class="form-control" id="user_code" name="user_code" value="<?php echo $record->user_code; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Data of Relieving:</label>
                    <input type="date" name="relieving_date" id="relieving_date" class="form-control" value='<?php echo $record->relieving_date; ?>' />
                </div> 
               
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Department:</label>
                    <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" disabled>
                        <option value="">Select Department</option>
                        <?php foreach ($dept_list as $dept) { ?>
    <option value="<?php echo $dept->dept_id; ?>" 
      <?= ($record->dept_id == $dept->dept_id) ? 'selected' : '' ?>>
      <?php echo $dept->dept_name; ?>
    </option>
<?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">DOB:</label>
                    <input type="date" name="dob" id="dob" class="form-control" value='<?php echo $record->bdate; ?>' readonly/>    
                </div>
                
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Designation:</label>
                    <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" disabled>
                        <option value="">Select Designation</option>
                        <?php foreach ($desig_list as $desig) { ?>
    <option value="<?php echo $desig->did; ?>" 
      <?= ($record->desig_id == $desig->did) ? 'selected' : '' ?>>
      <?php echo $desig->designation_name; ?>
    </option>
<?php } ?>
                    </select>
                </div> 
                
                <div class="col-md-6">
                    <label class="form-label">Passport No:</label>
                    <input type="text" name="passport_no" id="passport_no" class="form-control"
                        value='<?php echo !empty($passport) ? $passport[0]->document_number : ""; ?>' readonly/>
                </div>

                
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">DOJ:</label>
                    <input type="date" name="doj" id="doj" class="form-control" value='<?php echo $record->joining_date; ?>' readonly/>
                </div>
                <div class="col-md-3">
                    <label class="form-label">EID:</label>
                    <input type="text" name="eid" id="eid" class="form-control" 
                    value='<?php echo !empty($emirates) ? $emirates[0]->document_number : ""; ?>' readonly/>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Expiry:</label>
                    <input type="date" name="eid_expiry" id="eid_expiry" class="form-control" 
                    value='<?php echo !empty($emirates) ? $emirates[0]->expiry_date : ""; ?>' readonly/>
                </div>
                
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">VISA Status:</label>
                    <?php $visa_posession = !empty($visa) ? $visa[0]->posession : ""; ?>
                    <select tabindex="18" class="select2 form-select form-control-sm" id="visa" name="visa" disabled>
                        <option <?php if($visa_posession == "") echo "selected"; ?> value="">Select</option>
                        <option <?php if($visa_posession == "HM visa") echo "selected"; ?> value="HM visa">HM visa</option>
                        <option <?php if($visa_posession == "HM visa-Outside") echo "selected"; ?> value="HM visa-Outside">HM visa-Outside</option>
                        <option <?php if($visa_posession == "Freelance") echo "selected"; ?> value="Freelance">Freelance</option>
                        <option <?php if($visa_posession == "Visit Visa") echo "selected"; ?> value="Visit Visa">Visit Visa</option>
                    </select>  
                </div>
                <div class="col-md-3">
                    <label class="form-label">Expiry:</label>
                    <input type="date" name="visa_expiry" id="visa_expiry" class="form-control" 
                    value='<?php echo !empty($visa) ? $visa[0]->expiry_date : ""; ?>' readonly/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Notice Period (in Days):</label>
                    <input type="text" name="notice_period" id="notice_period" class="form-control" value='<?php echo $record->notice_period_in_days; ?>'/>    
                </div>
                
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Signed Clearance Form:</label>
                    <input type="file" name="clearance_form_upld" class="form-control"/> 
                    <?php if(!empty($record->document_name)):?>  
                    <a href="<?php echo base_url(). 'public/uploded_documents/' . $record->document_name;?>">View Document</a>
                    <?php endif;?>
                </div>
            </div>

            <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Clearance Details:</div>
                <table class="table table-bordered" id="clearanceTable">
                <thead>
                    <tr>
                    <th>Department</th>
                    <th>Activity</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $index = 1;
                    foreach($record1 as $row):?>
                    <tr>
                    <td>
                        <input type="hidden" name="clearance_entry_id[]" value="<?php echo $row->clearance_entry_id;?>"/>
                        <select class="form-control form-control-sm select2" name="row_dept_id[]" id="row_dept_id<?php echo $index;?>" width="80%">
                            <option value="">Select Department</option>
                            <?php foreach ($dept_list as $dept) { ?>
                                <option <?php if($row->dept_id == $dept->dept_id) echo "selected"; ?> value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select  tabindex="18" class="select2 form-select form-control-sm " id="activity<?php echo $index;?>" name="activity[]" width="80%">
                            <option <?php if($row->activity == "") echo "selected"; ?> value="">Select</option>
                            <option <?php if($row->activity == "Handover Completed") echo "selected"; ?> value="Handover Completed">Handover Completed</option>
                            <option <?php if($row->activity == "Full Notice Period Served") echo "selected"; ?> value="Full Notice Period Served">Full Notice Period Served</option>
                            <option <?php if($row->activity == "Tools and Equipments") echo "selected"; ?> value="Tools and Equipments">Tools and Equipments</option>
                            <option <?php if($row->activity == "Client Data") echo "selected"; ?> value="Client Data">Client Data</option>
                            <option <?php if($row->activity == "SIM ,Phone ,Laptop") echo "selected"; ?> value="SIM ,Phone ,Laptop">SIM ,Phone ,Laptop</option>
                            <option <?php if($row->activity == "Vehicle Inspection") echo "selected"; ?> value="Vehicle Inspection">Vehicle Inspection</option>
                            <option <?php if($row->activity == "Company Mails") echo "selected"; ?> value="Company Mails">Company Mails</option>
                            <option <?php if($row->activity == "Loan Advance") echo "selected"; ?> value="Loan Advance">Loan Advance</option>
                            <option <?php if($row->activity == "Other") echo "selected"; ?> value="Other">Other</option>
                        </select> 
                    </td>
                    
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                    </tr>
                    <?php $index++;
                endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                    <td colspan="3"></td>
                    <td ><button type="button" class="btn btn-primary" onclick="addRow()">Add Row</button></td>
                    </tr>
                </tfoot>
                </table>
                
            </div>
            <input type="hidden" name="clearance_id" value="<?php echo $record->clearance_id;?>"/> 
            
            <?php if ($can_edit): ?>
    <button type="submit" class="btn btn-success">Update Request</button>
<?php else: ?>
    <div class="alert alert-info">This clearance form has been approved and cannot be edited.</div>
<?php endif; ?>

           <?php $login_ids = $this->session->userdata('user_id'); ?>
<?php foreach ($admin_hr as $s): ?>
    <?php if (($login_ids == $s->approve_hr || $login_ids == $s->approve_admin_md) 
        && $s->approve_type == 'Clearance Form' 
        && $record->overall_approval == 0): ?>
        
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="button" id="approve_clearance" class="btn btn-primary m-b-0"
                    onclick="approveClearance(<?php echo $record->clearance_id; ?>)">Approve Clearance</button>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
            
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
    $('#visa').select2({
        placeholder: "Select Visa Type",
        allowClear: true
    });

    const table = document.getElementById("clearanceTable").getElementsByTagName('tbody')[0];
    rowTemplateHTML = table.rows[0].innerHTML;  // Save original content
});

    let rowCount = document.querySelectorAll('#clearanceTable tbody tr').length;
    let rowTemplateHTML;
    function addRow() {
        rowCount++;
        const table = document.getElementById("clearanceTable").getElementsByTagName('tbody')[0];
        const newRow = document.createElement("tr");
        newRow.innerHTML = rowTemplateHTML;

        // Update IDs and clear values
        newRow.querySelectorAll("select").forEach(select => {
            const name = select.getAttribute("name");
            if (name === "row_dept_id[]") {
                select.id = "row_dept_id" + rowCount;
            } else if (name === "activity[]") {
                select.id = "activity" + rowCount;
            } else if (name === "status[]") {
                select.id = "status" + rowCount;
            }

            $(select).val('').trigger('change');
        });
        Array.from(newRow.querySelectorAll("input")).forEach(input => {
            input.value = "";
        });
        table.appendChild(newRow);

        // Re-initialize Select2
        $(newRow).find('.select2').select2();
    }

    function removeRow(button) {
        const row = button.closest("tr");
        const table = document.getElementById("clearanceTable").getElementsByTagName('tbody')[0];

        if (table.rows.length > 1) {
            row.remove();
        } else {
            alert("At least one row is required.");
        }
    }

    

    function getEmployeeDetailsAjax(user_id){
        
        if (user_id !== '') {
          $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url() ?>index.php/Hr/get_user_details/" + user_id,
            data: { user_id: user_id },
            dataType: "json", // ensure the response is treated as JSON
            success: function (msg) {
              document.getElementById('user_code').value = msg.user_code;
              document.getElementById('dob').value = msg.bdate;
              document.getElementById('passport_no').value = msg.passport_no;
              document.getElementById('doj').value = msg.joining_date;
              document.getElementById('eid').value = msg.emirate_no;
              document.getElementById('eid_expiry').value = msg.emirate_expiry;
              document.getElementById('visa_expiry').value = msg.visa_expiry;
              $('#hod').val(msg.reporting_mngr).trigger('change');
              $('#desig_id').val(msg.desig_id).trigger('change');
              $('#dept_id').val(msg.dept_id).trigger('change');
              $('#visa').val(msg.visa_no).trigger('change');
            },
            error: function (xhr, status, error) {
              console.error("AJAX Error:", error);
            }
          });
        }
  
    }
    function approveClearance(clearanceId) {
    if(confirm('Are you sure you want to approve this clearance?')) {
        $.ajax({
            url: "<?php echo base_url('index.php/Hr/approve_clearance'); ?>",
            type: "POST",
            data: { clearance_id: clearanceId },
            success: function(response) {
                alert('Clearance Approved Successfully');
                location.reload();
            },
            error: function() {
                alert('Failed to approve clearance.');
            }
        });
    }
}

  </script>