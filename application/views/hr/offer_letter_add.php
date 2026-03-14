<div class="card-body">

    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_offer_letter_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        <div class="container my-4">  
              
            <div class="row mb-3">
                 <div class="col-md-3">
                    <label class="form-label">Name:<span style="color:red;">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="user_name" value="" id="user_name" required/>
                </div>
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Gender:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <select tabindex="1" class="form-select form-control-sm select2" id="gender" name="gender" required>
                            <option value="">Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
               
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Designation:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <select tabindex="1" class="form-select form-control-sm select2" id="desig_id" name="desig_id" required>
                            <option value="">Select</option>
                            <?php foreach ($desig_list as $desig) { ?>
                                <option  value="<?php echo $desig->did ?>"><?php echo $desig->designation_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Offer Date:<span style="color: red;">*</span></label>
                    <input type="date" class="form-control form-control-sm" name="offer_date" value="" id="offer_date" required/>
                </div> 
                           
            </div>
           <div class="row mb-3">
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Reporting Manager:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <select class="form-control form-control-sm select2" id="manager_id" name="manager_id" required  ><!-- onchange="getEmployeeDetailsAjax(this.value);"-->
                            <option value="">Select User</option>
                            <?php foreach ($user_records as $user) { ?>
                                <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div> 
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Employee Address:</label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <textarea class="form-control form-control-sm" name="employee_address" id="employee_address" ></textarea>
                    </div>
                </div>  
                <div class="col-md-3">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-12 col-form-label">Office Address:<span style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-12">
                        <textarea class="form-control form-control-sm" name="office_address" id="office_address" required>Al Quoz Industrial Area 4, Dubai - UAE</textarea>
                    </div>
                </div>  
           </div>                     
            <!-- <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Offer Letter Body:</label>
                    <textarea class="form-control form-control-sm" name="offer_body"></textarea>
                </div> 
            </div> -->
            <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Salary Structure:</div>
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
                    <tr>
                        <td>
                            <input typ="text" name="desc[]" class="form-control form-control-sm"/>
                        </td>
                        <td>
                            <input typ="text" name="monthly[]" class="form-control form-control-sm"/>
                        </td>
                        <td>
                            <input typ="text" name="annual[]" class="form-control form-control-sm"/>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeSalaryRow(this)">Remove</button></td>
                    </tr>
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
                    <textarea class="form-control form-control-sm" name="incentive_stucture"></textarea>
                </div> -->
            </div>  

             <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Incentive Structure:</div>
                <table class="table table-bordered" id="incentiveTable">
                <thead>
                    <tr>
                        <th>Case</th>
                        <th>Salary</th>
                        <th>Target</th>
                        <th>Incentive 3%</th>
                        <th>Magical Figures</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input typ="text" name="case[]" class="form-control form-control-sm"/>
                        </td>
                        <td>
            <input type="number" name="salary[]" class="form-control form-control-sm salary" oninput="calculateIncentive(this)"/>
                        </td>
                        <td>
                            <input typ="text" name="target_1[]" class="form-control form-control-sm"/>
                        </td>
                        <td>
                            <input typ="text" name="incentive_3_percent[]" class="form-control form-control-sm"/>
                        </td>
                        <td>
                            <input typ="text" name="target_2[]" class="form-control form-control-sm"/>
                        </td>
                        <!-- <td>
                            <input typ="text" name="incentive_5_percent[]" class="form-control form-control-sm"/>
                        </td> -->
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeIncentiveRow(this)">Remove</button></td>
                    </tr>
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
                    <textarea class="form-control form-control-sm" name="other_benefits"></textarea>
                </div> 
            </div> 
            <div class="row mb-3">    
            
                <div class="col-md-12">
                    <label class="form-label">Annexure B:</label>
                    <textarea class="form-control form-control-sm" name="annexure_b"></textarea>
                </div>
            </div>  -->
            <button type="submit" class="btn btn-success">Submit Request</button>
            
        </div>
    </form>
</div>
<script>
    let rowCount = 1;

    // --- Add Salary Row ---
    function addSalaryRow() {
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

    // --- Remove Salary Row ---
    function removeSalaryRow(button) {
        const row = button.closest("tr");
        const tableBody = document.getElementById("SalaryTable").getElementsByTagName('tbody')[0];

        if (tableBody.rows.length > 1) {
            row.remove();
        } else {
            alert("At least one row is required.");
        }
    }

    // --- Auto Calculate Annual = Monthly × 12 ---
    function calculateAnnual(input) {
        const monthlyValue = parseFloat(input.value) || 0;
        const annualInput = input.closest("tr").querySelector('input[name="annual[]"]');
        annualInput.value = (monthlyValue * 12).toFixed(2);
    }

    // --- Add Incentive Row ---
    function addIncentiveRow() {
        const tableBody = document.getElementById("incentiveTable").getElementsByTagName('tbody')[0];

        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="case[]" class="form-control form-control-sm"/></td>
        <td><input type="number" name="salary[]" class="form-control form-control-sm salary" oninput="calculateIncentive(this)"/></td>
            <td><input type="number" name="target_1[]" class="form-control form-control-sm"/></td>
            <td><input type="number" name="incentive_3_percent[]" class="form-control form-control-sm"/></td>
            <td><input type="number" name="target_2[]" class="form-control form-control-sm"/></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeIncentiveRow(this)">Remove</button></td>
        `;

        tableBody.appendChild(newRow);
    }

    // --- Remove Incentive Row ---
    function removeIncentiveRow(button) {
        const row = button.closest("tr");
        const tableBody = document.getElementById("incentiveTable").getElementsByTagName('tbody')[0];

        if (tableBody.rows.length > 1) {
            row.remove();
        } else {
            alert("At least one row is required.");
        }
    }

    // --- AJAX Function (unchanged) ---
    function getEmployeeDetailsAjax(user_id){
        if (user_id !== '') {
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo base_url() ?>index.php/Hr/get_user_details/" + user_id,
                data: { user_id: user_id },
                dataType: "json",
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
    
    // Auto-calculate Target & Incentive
function calculateIncentive(input) {
    const salary = parseFloat(input.value) || 0;
    const row = input.closest("tr");
    const targetField = row.querySelector('input[name="target_1[]"]');
    const incentiveField = row.querySelector('input[name="incentive_3_percent[]"]');
    const magicFigureField = row.querySelector('input[name="target_2[]"]');

    const target = salary * 30;
    const incentive = target * 0.03;
    const magicFigure = salary * 40;

    targetField.value = target.toFixed(2);
    incentiveField.value = incentive.toFixed(2);
    magicFigureField.value = magicFigure.toFixed(2);
}

    // --- Enable calculation for existing rows on load ---
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('#SalaryTable input[name="monthly[]"]').forEach(input => {
            input.addEventListener('input', function() {
                calculateAnnual(this);
            });
        });
    });
</script>
