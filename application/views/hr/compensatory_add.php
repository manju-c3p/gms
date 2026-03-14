<div class="card-body">

    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_compensatory_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        <div class="container my-4">    
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Name:<span style="color:red;">*</span></label>
                    <select class="form-control form-control-sm select2" id="user_id" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" >
                        <option value="">Select User</option>
                        <?php foreach ($user_records as $user) { ?>
                            <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                        <?php } ?>
                    </select>
            </div>
                <div class="col-md-6">
                    <label>Date of Request:</label>
                    <input type="date" name="requestDate" class="form-control" value='<?php echo date('Y-m-d'); ?>'/>
                </div>
                
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Emp.CODE:</label>
                    <input type="text" class="form-control" id="user_code" name="user_code" value="" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Designation:</label>
                    <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" >
                        <option value="">Select Designation</option>
                        <?php foreach ($desig_list as $desig) { ?>
                            <option value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                        <?php } ?>
                    </select>
                </div>           
                
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                <label class="form-label">Department:</label>
                <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" >
                    <option value="">Select Department</option>
                    <?php foreach ($dept_list as $dept) { ?>
                        <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                    <?php } ?>
                </select>
                </div>
                <div class="col-md-6">
                <label class="form-label">HOD:</label>
                <select class="form-control form-control-sm select2" name="hod" id="hod" >
                    <option value="">Select User</option>
                    <?php foreach ($user_records as $user) { ?>
                        <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

            <!-- Dynamic Table -->
            <div class="form-section">
                <div class="section-title">Comp-off Details:</div>
                <table class="table table-bordered" id="compOffTable">
                <thead>
                    <tr>
                    <th>Dates Worked</th>
                    <th>Explanation</th>
                    <th>Hrs Worked</th>
                    <th>Compo Off Taken Date</th>
                    <th>Pending Comp Off</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td><input type="date" name="workedDate[]" class="form-control" /></td>
                    <td><textarea name="explanation[]" class="form-control" ></textarea></td>
                    <td><input type="number" name="hoursWorked[]" step="0.1" class="form-control" /></td>
                    <td><input type="date" name="offTakenDate[]" class="form-control" onchange="validateTakenDate(this)"/></td>
                    <td><input type="text" name="pendingCompOff[]" class="form-control" readonly/></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                    <td colspan="4" class="text-end"><strong>Total Pending Comp Off for Reimbursement</strong></td>
                    <td><input type="text" name="totalPending" class="form-control" /></td>
                    <td><button type="button" class="btn btn-primary" onclick="addRow()">Add Row</button></td>
                    </tr>
                </tfoot>
                </table>
                
            </div>

            <!-- Footer Section -->
            <div class="form-section">
                <!-- <label>Employee Sign:</label>
                <input type="text" name="employeeSign" class="form-control mb-3" /> -->

                <div class="section-title">Reason for Work on Off Day <small>(To be filled by Department Head)</small></div>
                <textarea name="reasonByHead" class="form-control mb-3" rows="3"></textarea>
                
            </div>

            <button type="submit" class="btn btn-success">Submit Request</button>
            
        </div>
    </form>
</div>
<script>
    function addRow() {
        const table = document.getElementById("compOffTable").getElementsByTagName('tbody')[0];
        const newRow = table.rows[0].cloneNode(true);
        Array.from(newRow.querySelectorAll("input, textarea")).forEach(input => {
            input.value = "";
            input.readonly = false;
        });

        attachPendingUpdate(newRow);
        enforceSingleDateSelection(newRow);
        table.appendChild(newRow);
    }

    function removeRow(button) {
        const row = button.closest("tr");
        const table = row.closest("tbody");
        if (table.rows.length > 1) {
        row.remove();
        updateTotalPending();
        }
    }

    /*function attachPendingUpdate(row) {
        const hrsWorkedInput = row.querySelector("input[name='hoursWorked[]']");
        const pendingInput = row.querySelector("input[name='pendingCompOff[]']");
        const workedDateInput = row.querySelector("input[name='workedDate[]']");
        const offTakenDateInput = row.querySelector("input[name='offTakenDate[]']");

        // Handle workedDate + hoursWorked
        hrsWorkedInput.addEventListener("input", () => {
            if (workedDateInput.value) {
                const hours = parseFloat(hrsWorkedInput.value) || 0;
                const pending = (hours / 8).toFixed(2);
                pendingInput.value = pending > 0 ? pending : '';
                offTakenDateInput.value = ""; // mutually exclusive
                updateTotalPending();
            }
        });

        // Handle workedDate change
        workedDateInput.addEventListener("change", () => {
            if (workedDateInput.value) {
                const hours = parseFloat(hrsWorkedInput.value) || 0;
                const pending = (hours / 8).toFixed(2);
                pendingInput.value = pending > 0 ? pending : '';
                offTakenDateInput.value = ""; // clear opposite
            } else {
                hrsWorkedInput.value = "";
                pendingInput.value = "";
            }
            updateTotalPending();
        });

        
        // Handle offTakenDate selection
        offTakenDateInput.addEventListener("change", () => {
            const totalField = document.querySelector("input[name='totalPending']");
            const currentTotal = parseFloat(totalField.value) || 0;

            if (offTakenDateInput.value) {
                if (currentTotal < 1) {
                    alert("Not eligible for Comp Off.");
                    offTakenDateInput.value = "";
                    return;
                }

                // Clear worked-related fields
                workedDateInput.value = "";
                hrsWorkedInput.value = "";
                pendingInput.value = "1"; // fixed for comp off taken
            } else {
                pendingInput.value = "";
            }

            updateTotalPending();
        });

        pendingInput.addEventListener("input", updateTotalPending); // fallback
    }*/

    function attachPendingUpdate(row) {
        const hrsWorkedInput = row.querySelector("input[name='hoursWorked[]']");
        const pendingInput = row.querySelector("input[name='pendingCompOff[]']");

        if (hrsWorkedInput && pendingInput) {
            hrsWorkedInput.addEventListener("keyup", () => {
                const hours = parseFloat(hrsWorkedInput.value) || 0;
                const pending = (hours / 8).toFixed(2);
                pendingInput.value = pending > 0 ? pending : '';
                updateTotalPending();
            });

            pendingInput.addEventListener("keyup", updateTotalPending);
        }

        enforceSingleDateSelection(row); //  ADD THIS LINE
    }


    function updateTotalPending() {
        let total = 0;

        const rows = document.querySelectorAll("#compOffTable tbody tr");
        rows.forEach(row => {
            const pendingInput = row.querySelector("input[name='pendingCompOff[]']");
            const workedDate = row.querySelector("input[name='workedDate[]']").value;
            const offTakenDate = row.querySelector("input[name='offTakenDate[]']").value;

            const pending = parseFloat(pendingInput.value) || 0;

            if (workedDate) {
                total += pending;
            } else if (offTakenDate) {
                total -= pending;
            }
        });

        document.querySelector("input[name='totalPending']").value = total.toFixed(2);
    }
    

    // Attach event on initial row
    document.addEventListener("DOMContentLoaded", () => {
        const firstRow = document.querySelector("#compOffTable tbody tr");
        attachPendingUpdate(firstRow);
        updateTotalPending(); // initialize total
    });

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
              $('#hod').val(msg.reporting_mngr).trigger('change');
              $('#desig_id').val(msg.desig_id).trigger('change');
              $('#dept_id').val(msg.dept_id).trigger('change');
            },
            error: function (xhr, status, error) {
              console.error("AJAX Error:", error);
            }
          });
        }
  
    }

    function enforceSingleDateSelection(row) {
        const workedInput = row.querySelector("input[name='workedDate[]']");
        const offInput = row.querySelector("input[name='offTakenDate[]']");
        const pendingInput = row.querySelector("input[name='pendingCompOff[]']");
        const hrsWorkedInput = row.querySelector("input[name='hoursWorked[]']");

        workedInput.addEventListener("change", () => {
            if (workedInput.value) {
                offInput.value = "";
                offInput.readonly = true;
                hrsWorkedInput.readOnly = false;

                const hours = parseFloat(hrsWorkedInput.value) || 0;
                pendingInput.value = (hours / 8).toFixed(2);
                updateTotalPending();
            } else {
                offInput.readonly = false;
            }
        });

        offInput.addEventListener("change", () => {
            if (offInput.value) {
                pendingInput.value = "1.00";  // SET pending first here

                if (getAvailablePending() < 0) {  // Should be < 0 because we just added 1 now
                    alert("Not eligible for Comp Off - insufficient pending balance.");
                    offInput.value = "";
                    pendingInput.value = "";   // Clear the pending back if not eligible
                    return;
                }

                workedInput.value = "";
                workedInput.readonly = true;
                hrsWorkedInput.value = "";
                hrsWorkedInput.readOnly = true;
                updateTotalPending();
            } else {
                workedInput.readonly = false;
                hrsWorkedInput.readOnly = false;
                pendingInput.value = "";
                updateTotalPending();
            }
        });

    }

    function calculateBasePending() {
        const pendingInputs = document.querySelectorAll("input[name='pendingCompOff[]']");
        let total = 0;
        pendingInputs.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) total += val;
        });
        return total;
    }

    function validateTakenDate(input) {
        const totalField = document.querySelector("input[name='totalPending']");
        let baseTotal = calculateBasePending(); // always start from current sum of pendingCompOff[]
        const takenDates = document.querySelectorAll("input[name='offTakenDate[]']");

        let takenCount = 0;
        takenDates.forEach(dateInput => {
            if (dateInput.value) takenCount++;
        });

        // Check if this field is newly selected
        if (input.value && baseTotal - takenCount < 0) {
            alert("Not enough Pending Comp Offs available.");
            input.value = "";
            return;
        }

        // Update the displayed total after deduction
        const finalTotal = baseTotal - takenCount;
        totalField.value = finalTotal.toFixed(2);
    }

    function getAvailablePending() {
        let totalPending = 0;

        const rows = document.querySelectorAll("#compOffTable tbody tr");
        rows.forEach(row => {
            const pendingInput = row.querySelector("input[name='pendingCompOff[]']");
            const workedDate = row.querySelector("input[name='workedDate[]']").value;
            const offTakenDate = row.querySelector("input[name='offTakenDate[]']").value;

            const pending = parseFloat(pendingInput.value) || 0;

            if (workedDate) {
                totalPending += pending;
            } else if (offTakenDate) {
                totalPending -= 1;
            }
        });

        return totalPending;
    }


    </script>