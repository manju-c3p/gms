<div class="card-body">

    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_clearance_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        <div class="container my-4">    
             <div class="row mb-3">
                <input type="hidden" name="user_id" value="<?= isset($user_id) ? $user_id : ''; ?>">

               <div class="col-md-6">
               <label class="form-label">Name:<span style="color:red;">*</span></label>
               <input type="text" class="form-control" name="employee_name" value="<?= isset($employee_name) ? $employee_name : ''; ?>" readonly>
            </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Resignation:</label>
                    <input type="date" name="resig_date" class="form-control" value='<?php echo date('Y-m-d'); ?>' />
                </div>            
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Emp CODE:</label>
                    <input type="text" class="form-control" id="user_code" name="user_code" value="" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Data of Relieving:</label>
                    <input type="date" name="relieving_date" id="relieving_date" class="form-control" value='<?php echo date('Y-m-d'); ?>' />
                </div> 
               
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Department:</label>
                    <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" readonly>
                        <option value="">Select Department</option>
                        <?php foreach ($dept_list as $dept) { ?>
                            <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">DOB:</label>
                    <input type="date" name="dob" id="dob" class="form-control" value='<?php echo date('Y-m-d'); ?>' readonly/>    
                </div>
                
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Designation:</label>
                    <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" readonly>
                        <option value="">Select Designation</option>
                        <?php foreach ($desig_list as $desig) { ?>
                            <option value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                        <?php } ?>
                    </select>
                </div> 
                <div class="col-md-6">
                    <label class="form-label">Passport No:</label>
                    <input type="text" name="passport_no" id="passport_no" class="form-control" value='' readonly/> 
                </div> 
                
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">DOJ:</label>
                    <input type="date" name="doj" id="doj" class="form-control" value='' readonly/>
                </div>
                <div class="col-md-3">
                    <label class="form-label">EID:</label>
                    <input type="text" name="eid" id="eid" class="form-control" value='' readonly/>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Expiry:</label>
                    <input type="date" name="eid_expiry" id="eid_expiry" class="form-control" value='<?php echo date('Y-m-d'); ?>' readonly/>
                </div>
                
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">VISA Status:</label>
                    <select  tabindex="18" class="select2 form-select form-control-sm " id="visa" name="visa">
                        <option value="">Select</option>
                        <option value="HM visa">HM visa</option>
                        <option value="HM visa-Outside">HM visa-Outside</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Visit Visa">Visit Visa</option>
				</select>   
                </div>
                <div class="col-md-3">
                    <label class="form-label">Expiry:</label>
                    <input type="date" name="visa_expiry" id="visa_expiry" class="form-control" value='' readonly/>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Notice Period (in Days):</label>
                    <input type="text" name="notice_period" id="notice_period" class="form-control" value=''/>    
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
                    <tr>
                    <td>
                        <select class="form-control form-control-sm select2" name="row_dept_id[]" id="row_dept_id1" width="80%">
                            <option value="">Select Department</option>
                            <?php foreach ($dept_list as $dept) { ?>
                                <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select  tabindex="18" class="select2 form-select form-control-sm " id="activity1" name="activity[]" width="80%">
                            <option value="">Select</option>
                            <option value="Handover Completed">Handover Completed</option>
                            <option value="Full Notice Period Served">Full Notice Period Served</option>
                            <option value="Tools and Equipments">Tools and Equipments</option>
                            <option value="Client Data">Client Data</option>
                            <option value="SIM ,Phone ,Laptop">SIM ,Phone ,Laptop</option>
                            <option value="Vehicle Inspection">Vehicle Inspection</option>
                            <option value="Company Mails">Company Mails</option>
                            <option value="Loan Advance">Loan Advance</option>
                            <option value="Other">Other</option>
                        </select> 
                    </td>
                   
                   
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                    <td colspan="3"></td>
                    <td ><button type="button" class="btn btn-primary" onclick="addRow()">Add Row</button></td>
                    </tr>
                </tfoot>
                </table>
                
            </div>

            <button type="submit" class="btn btn-success">Submit Request</button>
            
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

<?php if (!empty($user_id)) { ?>
        getEmployeeDetailsAjax('<?= $user_id; ?>');
    <?php } ?>
});

    let rowCount = 1;
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

   


    </script>