<div class="card-body">

    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_offer_letter_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
    <div class="container my-4">    
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Name:<span style="color:red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="user_name" value="<?php echo $records->user_name?>" id="user_name" required/>
                </div>
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Gender:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <select tabindex="1" class="form-select form-control-sm select2" id="gender" name="gender" required>
                            <option <?php if($records->gender == '') echo 'selected';?> value="">Gender</option>
                            <option <?php if($records->gender == 'Male') echo 'selected';?> value="Male">Male</option>
                            <option <?php if($records->gender == 'Female') echo 'selected';?> value="Female">Female</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Designation:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <select tabindex="1" class="form-select form-control-sm select2" id="desig_id" name="desig_id" required>
                            <option value="">Select</option>
                            <?php foreach ($desig_list as $desig) { ?>
                                <option  <?php if($records->desig_id == $desig->did) echo 'selected';?> value="<?php echo $desig->did ?>"><?php echo $desig->designation_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Offer Date:<span style="color: red;">*</span></label>
                    <input type="date" class="form-control form-control-sm" name="offer_date" value="<?php echo $records->offer_date?>" id="offer_date" required/>
                </div>           
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Reporting Manager:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <select class="form-control form-control-sm select2" id="manager_id" name="manager_id" required  ><!-- onchange="getEmployeeDetailsAjax(this.value);"-->
                            <option value="">Select User</option>
                            <?php foreach ($user_records as $user) { ?>
                                <option <?php if($records->manager_id == $user->user_id) echo 'selected';?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div> 
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Employee Address:</label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <textarea class="form-control form-control-sm" name="employee_address" id="employee_address" ><?php echo $records->employee_address;?></textarea>
                    </div>
                </div>  
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Office Address:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <textarea class="form-control form-control-sm" name="office_address" id="office_address" required><?php echo $records->office_address;?></textarea>
                    </div>
                </div>  
           </div>                    
            <!-- <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Offer Letter Body:</label>
                    <textarea class="form-control form-control-sm" name="offer_body"><?php echo $records->offer_body;?></textarea>
                </div> 
            </div> -->
            <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Salary Sructure:</div>
                <table class="table table-bordered" id="SalaryTable">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Monthly</th>
                        <th>Annual</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($salary as $row):?>
                        <tr>
                            <td>
                                <input type="hidden" name="salary_id[]" value="<?php echo $row->salary_id ;?>" />
                                <input typ="text" name="desc[]" class="form-control form-control-sm" value="<?php echo $row->description;?>"/>
                            </td>
                            <td>
                                <input typ="text" name="monthly[]" class="form-control form-control-sm" value="<?php echo $row->monthly;?>"/>
                            </td>
                            <td>
                                <input typ="text" name="annual[]" class="form-control form-control-sm" value="<?php echo $row->annual;?>"/>
                            </td>
                            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeSalaryRow(this)">Remove</button></td>
                        </tr>
                    <?php endforeach;?>
                    
                </tbody>
                <tfoot>
                    <tr>
                    <td colspan="3"></td>
                    <td ><button type="button" class="btn btn-primary" onclick="addSalaryRow()">Add Row</button></td>
                    </tr>
                </tfoot>
                </table>
                
            </div>
            <div class="row mb-3">                
                <!-- <div class="col-md-12">
                    <label class="form-label">Salary Structure:</label>
                    <textarea class="form-control form-control-sm" name="salary_stucture"></textarea>
                </div>  -->
            
                <!-- <div class="col-md-12">
                    <label class="form-label">Incentive Structure:</label>
                    <textarea class="form-control form-control-sm" name="incentive_stucture"><?php echo $records->incentive_stucture;?></textarea>
                </div> -->
            </div>  

             <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Incentive Sructure:</div>
                <table class="table table-bordered" id="incentiveTable">
                <thead>
                    <tr>
                        <th>Case</th>
                        <th>Salary</th>
                        <th>Target</th>
                        <th>Incentive 3%</th>
                        <th>Magic Figures</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($incentive as $row1):?>
                    <tr>
                        <td>
                            <input type="hidden" name="incent_id[]" value="<?php echo $row1->incent_id;?>" />
                            <input typ="text" name="case[]" class="form-control form-control-sm" value="<?php echo $row1->sal_case;?>"/>
                        </td>
                        <td>
                            <input typ="text" name="salary[]" class="form-control form-control-sm" value="<?php echo $row1->salary;?>"/>
                        </td>
                        <td>
                            <input typ="text" name="target_1[]" class="form-control form-control-sm" value="<?php echo $row1->target_1;?>"/>
                        </td>
                        <td>
                            <input typ="text" name="incentive_3_percent[]" class="form-control form-control-sm" value="<?php echo $row1->incentive_3_percent;?>"/>
                        </td>
                        <td>
                            <input typ="text" name="target_2[]" class="form-control form-control-sm" value="<?php echo $row1->target_2;?>"/>
                        </td>
                        <!-- <td>
                            <input typ="text" name="incentive_5_percent[]" class="form-control form-control-sm" value="<?php echo $row1->incentive_5_percent;?>"/>
                        </td> -->
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeIncentiveRow(this)">Remove</button></td>
                    </tr>
                <?php endforeach;?>
                    
                </tbody>
                <tfoot>
                    <tr>
                    <td colspan="6"></td>
                    <td ><button type="button" class="btn btn-primary" onclick="addIncentiveRow()">Add Row</button></td>
                    </tr>
                </tfoot>
                </table>
                
            </div>            
            <!-- <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Other Benefits:</label>
                    <textarea class="form-control form-control-sm" name="other_benefits"><?php echo $records->other_benefits;?></textarea>
                </div> 
            </div> -->
             <!-- <div class="row mb-3">    
            
                <div class="col-md-12">
                    <label class="form-label">Annexure B:</label>
                    <textarea class="form-control form-control-sm" name="annexure_b"><?php echo $records->annexure_b;?></textarea>
                </div>
            </div>  -->
            <input type="hidden" name="offer_id" value="<?php echo $records->offer_id;?>" />
            <button type="submit" class="btn btn-success">Update Request</button>
            
        </div>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // --- Salary Row Functions ---
    window.addSalaryRow = function() {
        const tableBody = document.getElementById("SalaryTable").getElementsByTagName('tbody')[0];
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="desc[]" class="form-control form-control-sm"/></td>
            <td><input type="number" name="monthly[]" class="form-control form-control-sm monthly" oninput="calculateAnnual(this)"/></td>
            <td><input type="number" name="annual[]" class="form-control form-control-sm annual" readonly/></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeSalaryRow(this)">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
    }

    window.removeSalaryRow = function(button) {
        const row = button.closest("tr");
        const tableBody = document.getElementById("SalaryTable").getElementsByTagName('tbody')[0];
        if (tableBody.rows.length > 1) row.remove();
        else alert("At least one row is required.");
    }

    window.calculateAnnual = function(input) {
        const monthlyValue = parseFloat(input.value) || 0;
        const annualInput = input.closest("tr").querySelector('input[name="annual[]"]');
        annualInput.value = (monthlyValue * 12).toFixed(2);
    }

    // --- Incentive Row Functions ---
    window.addIncentiveRow = function() {
        const tableBody = document.getElementById("incentiveTable").getElementsByTagName('tbody')[0];
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="case[]" class="form-control form-control-sm"/></td>
            <td><input type="number" name="salary[]" class="form-control form-control-sm salary" oninput="calculateIncentive(this)"/></td>
            <td><input type="number" name="target_1[]" class="form-control form-control-sm" readonly/></td>
            <td><input type="number" name="incentive_3_percent[]" class="form-control form-control-sm" readonly/></td>
            <td><input type="number" name="target_2[]" class="form-control form-control-sm" readonly/></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeIncentiveRow(this)">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
    }

    window.removeIncentiveRow = function(button) {
        const row = button.closest("tr");
        const tableBody = document.getElementById("incentiveTable").getElementsByTagName('tbody')[0];
        if (tableBody.rows.length > 1) row.remove();
        else alert("At least one row is required.");
    }

    window.calculateIncentive = function(input) {
        const salary = parseFloat(input.value) || 0;
        const row = input.closest("tr");
        const targetField = row.querySelector('input[name="target_1[]"]');
        const incentiveField = row.querySelector('input[name="incentive_3_percent[]"]');
        const magicFigureField = row.querySelector('input[name="target_2[]"]');

        const target = salary * 30;       // Target auto = Salary × 30
        const incentive = target * 0.03;  // Incentive 3% of target
        const magicFigure = salary * 40;  // Magic figure example

        targetField.value = target.toFixed(2);
        incentiveField.value = incentive.toFixed(2);
        magicFigureField.value = magicFigure.toFixed(2);
    }

    // --- Initialize Existing Rows ---
    document.querySelectorAll('#SalaryTable input[name="monthly[]"]').forEach(input => {
        calculateAnnual(input);
        input.addEventListener('input', function() {
            calculateAnnual(this);
        });
    });

    document.querySelectorAll('#incentiveTable input[name="salary[]"]').forEach(input => {
        calculateIncentive(input);
        input.addEventListener('input', function() {
            calculateIncentive(this);
        });
    });

    // --- Optional: AJAX function for user details ---
    window.getEmployeeDetailsAjax = function(user_id){
        if (!user_id) return;
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url() ?>index.php/Hr/get_user_details/" + user_id,
            data: { user_id: user_id },
            dataType: "json",
            success: function(msg) {
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
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }

});
</script>
