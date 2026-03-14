<div class="card-body">
    <div class="form-group row">
        <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Select: <span
                style="color: red;">*</span></label>
        <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
            <select class="form-select form-control-sm select2" id="requestType" name="requestType" tabindex="10"
                onchange="showForm(); checkSelection()">
                <option value="">Select</option>
                <option value="compensatory_leave">Compensatory Allowance</option>
                <option value="advance_salary">Advance Salary</option>
                <option value="allowance">Allowance</option>
                <option value="loan">Loan</option>
                <option value="ticket_allowance">Annual Air Ticket</option>
                <option value="service_request">Service Request</option>


            </select>
        </div>
        <span id="tooltipMessage" style="color: black;"
            title="If you select any option, the corresponding form will show">
            If you select any option, the corresponding form will show..............
        </span>
    </div>


    <!-- Compensatory Leave Form -->
    <form id="compensatory_leave_form" class="request-form" method="post"
        action="<?php echo base_url() . 'index.php/Hr/add_comp_off_data'; ?>" style="display:none;" autocomplete="off"
        enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <?php
                $current_user_id = $this->session->userdata('user_id');
                $current_user_name = '';
                foreach ($user_records as $s) {
                    if ($s->user_id == $current_user_id) {
                        $current_user_name = $s->user_name;
                        break;
                    }
                }
                ?>
                <input type="text" class="form-control form-control-sm bg-soft-gray" id="employee_name"
                    name="employee_name" value="<?php echo $current_user_name; ?>" readonly>
                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $current_user_id; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="app_date" name="app_date"
                        value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Working:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="work_date" name="work_date"
                        value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>

        <!-- <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Comp Off:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="comp_date" name="comp_date"
                        value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div> -->


        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
            <div class="col-sm-5">
                <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
                    tabindex=8></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply for Comp Off</button>
            </div>
        </div>
    </form>

    <!-- Advance Salary Form -->
    <form id="advance_salary_form" class="request-form" method="post"
        action="<?php echo base_url() . 'index.php/Hr/add_advance_salary_data'; ?>" style="display:none;"
        autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <?php
                $current_user_id = $this->session->userdata('user_id');
                $current_user_name = '';
                foreach ($user_records as $s) {
                    if ($s->user_id == $current_user_id) {
                        $current_user_name = $s->user_name;
                        break;
                    }
                }
                ?>
                <input type="text" class="form-control form-control-sm bg-soft-gray" id="employee_name"
                    name="employee_name" value="<?php echo $current_user_name; ?>" readonly>
                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $current_user_id; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="app_date" name="app_date"
                        value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Select Month:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <input type="month" class="form-control form-control-sm" id="a_month" name="a_month" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Salary Amount:</label>
            <div class="col-sm-5">
                <input type="number" class="form-control form-control-sm" id="advance_salary" name="advance_salary" value="<?php echo $gross_salary; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
            <div class="col-sm-5">
                <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
                    tabindex=8></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label
                class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg",<br>"png","doc","pdf"):</label>
            <div class="col-sm-8">
                <table class="table table-bordered table-hover" id="tab_logic_salary">
                    <tbody>
                        <tr id='addr_salary0'>
                            <td>1</td>

                            <td>

                                <input class="form-control form-control-sm" id="documents_salary"
                                    name="documents_salary[]" tabindex="6" type="file">

                            </td>
                            <td>
                                <input type='text' class="form-control form-control-sm" name="document_types_salary[]"
                                    id="document_types_salary" placeholder="enter doc name">
                            </td>

                            <td>
                                <a id="add_row_salary" title="Add" class="btn btn-sm bg-blue"><span
                                        class="fa fa-plus"></span></a>
                                <a id='delete_row_salary' title="Delete" class="btn btn-sm bg-blue"><span
                                        class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                        <tr id='addr_salary1'></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply For Advance
                    Salary</button>
            </div>
        </div>
    </form>

    <!-- Allowance Form -->
    <form id="allowance_form" class="request-form" method="post"
        action="<?php echo base_url() . 'index.php/Hr/add_allowance_data'; ?>" style="display:none;" autocomplete="off"
        enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <?php
                $current_user_id = $this->session->userdata('user_id');
                $current_user_name = '';
                foreach ($user_records as $s) {
                    if ($s->user_id == $current_user_id) {
                        $current_user_name = $s->user_name;
                        break;
                    }
                }
                ?>
                <input type="text" class="form-control form-control-sm bg-soft-gray" id="employee_name"
                    name="employee_name" value="<?php echo $current_user_name; ?>" readonly>
                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $current_user_id; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Select Allowance:<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <select tabindex="1" class="form-control-sm select2" id="allowance_id" name="allowance_id"
                    style="width: 400px;" required>
                    <option value="">Select</option>
                    <?php foreach ($allowance as $s) { ?>
                        <?php if ($s->allowance_type == 'A'): ?>
                            <option value="<?php echo $s->sno ?>"><?php echo $s->allowance_name; ?></option>
                        <?php endif; ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="app_date" name="app_date"
                        value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">From Month:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-2">
                <div class="input-group date date">
                    <input type="month" class="form-control form-control-sm " id="from_date" name="from_date"
                        value="<?php echo date('d-m-Y'); ?>" tabindex="3" required>
                    <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                </div>
            </div>
            <label class="col-xs-8 col-sm-2 col-md-2 col-lg-1 col-form-label">To Month:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-2">
                <div class="input-group date date">
                    <input type="month" class="form-control form-control-sm" id="to_date" name="to_date"
                        value="<?php echo date('d-m-Y'); ?>" tabindex="4" required>
                    <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Amount<span
                    style="color: red;">*</span>:</label>
            <div class="col-sm-5">
                <input type="number" step="0.01" id="a_amount" name="a_amount" required
                    placeholder="Enter Allowance Amount" style="width: 100%;" tabindex="8">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
            <div class="col-sm-5">
                <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
                    tabindex=8></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label
                class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg",<br>"png","doc","pdf"):</label>
            <div class="col-sm-8">
                <table class="table table-bordered table-hover" id="tab_logic_allowance">
                    <tbody>
                        <tr id='addr_allowance0'>
                            <td>1</td>

                            <td>

                                <input class="form-control form-control-sm" id="documents_allowance"
                                    name="documents_allowance[]" tabindex="6" type="file">

                            </td>
                            <td>
                                <input type='text' class="form-control form-control-sm"
                                    name="document_types_allowance[]" id="document_types_allowance"
                                    placeholder="enter doc name">
                            </td>

                            <td>
                                <a id="add_row_allowance" title="Add" class="btn btn-sm bg-blue"><span
                                        class="fa fa-plus"></span></a>
                                <a id='delete_row_allowance' title="Delete" class="btn btn-sm bg-blue"><span
                                        class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                        <tr id='addr_allowance1'></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply For Allowance</button>
            </div>
        </div>
    </form>
    <!-- loan Form //////////////////////////////////////////////////////////////////////-->
    <form id="loan_form" class="request-form" method="post"
        action="<?php echo base_url() . 'index.php/Hr/add_loan_data'; ?>" style="display:none;" autocomplete="off"
        enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <?php
                $current_user_id = $this->session->userdata('user_id');
                $current_user_name = '';
                foreach ($user_records as $s) {
                    if ($s->user_id == $current_user_id) {
                        $current_user_name = $s->user_name;
                        break;
                    }
                }
                ?>
                <input type="text" class="form-control form-control-sm bg-soft-gray" id="employee_name"
                    name="employee_name" value="<?php echo $current_user_name; ?>" readonly>
                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $current_user_id; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="app_date" name="app_date"
                        value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Requested Amount<span
                    style="color: red;">*</span>:</label>
            <div class="col-sm-5">
                <input type="number" step="0.01" id="r_amount" name="r_amount" required
                    placeholder="Enter requested Amount" style="width: 100%;" tabindex="8" oninput="calculateEMI()">
            </div>

        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Start Month:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-2">
                <div class="input-group date ">
                    <input type="month" class="form-control form-control-sm " id="start_month"
                        onchange="calculateTotalMonths()" name="start_date" value="<?php echo date('d-m-Y'); ?>"
                        tabindex="3" required>
                </div>
            </div>
            <label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">End Month:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-2">
                <div class="input-group date ">
                    <input type="month" class="form-control form-control-sm " id="end_month" name="end_date"
                        value="<?php echo date('d-m-Y'); ?>" tabindex="4" required onchange="calculateTotalMonths()">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Month<span
                    style="color: red;">*</span>:</label>
            <div class="col-sm-2">
                <input type="number" step="0.01" id="total_month" name="total_month" required placeholder="Total Month"
                    style="width: 100%;" tabindex="8" oninput="calculateEMI()" readonly>
            </div>
            <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-form-label">EMI Amount Per/Month<span
                    style="color: red;">*</span>:</label>
            <div class="col-sm-2">
                <input type="number" step="0.01" id="emi_amount" name="emi_amount" required placeholder="EMI Amount"
                    style="width: 100%;" tabindex="8" readonly>
            </div>
        </div>


        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
            <div class="col-sm-5">
                <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
                    tabindex=8></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label
                class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg",<br>"png","doc","pdf"):</label>
            <div class="col-sm-8">
                <table class="table table-bordered table-hover" id="tab_logic_loan">
                    <tbody>
                        <tr id='addr_loan0'>
                            <td>1</td>

                            <td>

                                <input class="form-control form-control-sm" id="documents_loan" name="documents_loan[]"
                                    tabindex="6" type="file">

                            </td>
                            <td>
                                <input type='text' class="form-control form-control-sm" name="document_types_loan[]"
                                    id="document_types_loan">
                            </td>

                            <td>
                                <a id="add_row_loan" title="Add" class="btn btn-sm bg-blue"><span
                                        class="fa fa-plus"></span></a>
                                <a id='delete_row_loan' title="Delete" class="btn btn-sm bg-blue"><span
                                        class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                        <tr id='addr_loan1'></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply For Loan</button>
            </div>
        </div>
    </form>
  <!-- Annual Air ticket //////////////////////////////////////////////////////////////////////-->

 <form id="air_ticket_form" class="request-form" method="post"
        action="<?php echo base_url() . 'index.php/Hr/add_air_ticket_allowance_data'; ?>" style="display:none;" autocomplete="off"
        enctype="multipart/form-data">

 <!-- Employee Name -->
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
                Employee Name:<span style="color: red;">*</span>
            </label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
            
             <?php
                $current_user_id = $this->session->userdata('user_id');
                $current_user = null;

                foreach ($user_records as $u) {
                   if ($u->user_id == $current_user_id) {
                      $current_user = $u;
                      break;
                  }
                }    
                $employee_name = $current_user->user_name ?? '';
                $employee_id = $current_user->user_code?? '';
                $dept_name = $current_user->dept_name ?? '';
                 $designation = $current_user->designation_name ?? '';
                $joining_date = $current_user->joining_date ?? '';
                ?>           
                <input type="text" class="form-control form-control-sm bg-soft-gray" 
                       id="employee_name" name="employee_name" 
                       value="<?php echo $employee_name; ?>" readonly>
              
                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $current_user_id; ?>">
            </div>

             <!-- Department -->
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Department:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
               <input type="text" class="form-control form-control-sm bg-soft-gray" id="department" name="department"  value="<?php echo $dept_name; ?>" readonly>
             <input type="hidden" name="dept_id" value="<?php echo $current_user->dept_id ?? ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee ID:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="text" class="form-control form-control-sm bg-soft-gray" id="emp_code" name="emp_code" 
                       value="<?php echo $employee_id; ?>" readonly>
            </div>
       

        <!-- Designation & Joining Date -->
        
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Designation:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="text" class="form-control form-control-sm bg-soft-gray" id="designation" name="designation"  value="<?php echo $designation; ?>">
            <input type="hidden" name="desig_id" value="<?php echo $current_user->desig_id ?? ''; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining Date:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="date" class="form-control form-control-sm bg-soft-gray" id="joining_date" name="joining_date" value="<?php echo $joining_date; ?>">
            </div>
       

        <!-- Visa Expiry & Last Ticket Issued -->
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Visa Expiry Date:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="date" class="form-control form-control-sm" id="visa_expiry_date" name="visa_expiry_date">
            </div>
    </div>
    <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Last Ticket Issued Date:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="date" class="form-control form-control-sm" id="last_ticket_date" name="last_ticket_date"  onchange="setEligibilityRange()">
            </div>
       

        <!-- Last Work / Rejoin & Leave Dates -->
        
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Rejoin Date:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="date" class="form-control form-control-sm" id="rejoin_date" name="rejoin_date">
            </div>
       </div>
       
       <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave Request From:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="date" class="form-control form-control-sm" id="leave_from" name="leave_from">
            </div>
       

        <!-- Leave To & Remarks -->
        
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave Request To:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="date" class="form-control form-control-sm" id="leave_to" name="leave_to">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remarks:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <textarea class="form-control form-control-sm" id="remarks" name="remarks" rows="2"></textarea>
            </div>
        </div>
        
 <hr>

       <div class="row mt-3">
    <div class="col-md-12">
        <table class="table table-bordered table-sm" id="eligibility_table">
            <thead class="table-light">
                <tr>
                    <th style="width:50%;">Description</th>
                    <th style="width:50%;">Net Amount (AED)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="eligibility_desc">Eligible for — (Last Ticket Issued Date + 1 year)</td>
                    <td>
                        <input type="number" class="form-control form-control-sm net_amount" name="net_amount[]" 
                               value="600.00" placeholder="Enter amount" oninput="updateGrandTotal()">
                    </td>
                </tr>
                <!-- You can add more rows here dynamically if needed -->
            </tbody>
            <tfoot>
                <tr>
                    <th>Grand Total</th>
                    <th>
                        <input type="text" class="form-control form-control-sm" id="grand_total" value="600.00" readonly>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
      <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Submit</button>
            </div>
        </div>
    </form>
    <!-- Service Request Form -->
<form id="service_request_form" class="request-form" method="post"
    action="<?php echo base_url() . 'index.php/Hr/add_service_request_data'; ?>"
    style="display:none;" autocomplete="off" enctype="multipart/form-data">

    <!-- EMPLOYEE NAME -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Employee Name:<span style="color:red;">*</span></label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                name="employee_name" value="<?php echo $current_user_name; ?>" readonly>
            <input type="hidden" name="employee_id" value="<?php echo $current_user_id; ?>">
        </div>
    </div>

     <?php
                $current_user_id = $this->session->userdata('user_id');
                $current_user = null;

                foreach ($user_records as $u) {
                   if ($u->user_id == $current_user_id) {
                      $current_user = $u;
                      break;
                  }
                }    
               
                $dept_name = $current_user->dept_name ?? '';
                
                ?>  
    <!-- DEPARTMENT -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Department:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                value="<?php echo $dept_name; ?>" readonly>
             <input type="hidden" name="dept_id" value="<?php echo $current_user->dept_id ?? ''; ?>">
        </div>
    </div>

    <!-- DATE -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Date:<span style="color:red;">*</span></label>
        <div class="col-sm-5">
            <input type="date" class="form-control form-control-sm"
                name="app_date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
    </div>

    <!-- PROJECT -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Project:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm"
                name="project_name" placeholder="Enter project name">
        </div>
    </div>

    <!-- URGENCY -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Urgency:</label>
        <div class="col-sm-5">
            <select class="form-control form-control-sm" name="urgency" required>
                <option value="">Select</option>
                <option>Low</option>
                <option>Medium</option>
                <option>High</option>
                <option>Critical</option>
            </select>
        </div>
    </div>

    <!-- TABLE SECTION -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Service Items:</label>
        <div class="col-sm-8">

            <table class="table table-bordered" id="service_table">
                <thead class="table-secondary">
                    <tr>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Supplier</th>
                        <th>Net Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="serviceRows">
                    <tr>
                        <td><input type="text" name="item_name[]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="item_purpose[]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="supplier[]" class="form-control form-control-sm"></td>
                        <td><input type="number" step="0.01" name="net_amount[]" class="form-control form-control-sm netAmount" oninput="calculateTotal()"></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">×</button>
                        </td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Grand Total:</th>
                        <th><input type="text" id="grandTotal" class="form-control form-control-sm" readonly></th>
                        <th></th>
                    </tr>
                </tfoot>

            </table>

        </div>
    </div>

    <!-- SUBMIT -->
    <div class="form-group row">
        <label class="col-sm-3"></label>
        <div class="col-sm-5">
            <button type="submit" class="btn btn-primary">Submit Service Request</button>
        </div>
    </div>

</form>


</div>

            </form>
    
</div>
</div>
<script>
    ////////////////////start image for advance salary/////////////////////
    $(document).ready(function() {
        var i = 1;
        $("#add_row_salary").click(function() {
            $('#addr_salary' + i).html("<td>" + (i + 1) + "</td><td><input class='form-control' id='documents_salary" + i + "' name='documents_salary[]' type='file'></td><td><input type='text' class='form-control form-control-sm' name='document_types_salary[]' id='document_types_salary'></select></td><td></td>");
            $('#tab_logic_salary').append('<tr id="addr_salary' + (i + 1) + '"></tr>');
            i++;
        });

        $("#delete_row_salary").click(function() {
            if (i > 1) {
                $("#addr_salary" + (i - 1)).html('');
                i--;
            }
        });
    });

    ////////////////////////////////start loan///////////////////////
    $(document).ready(function() {
        var i = 1;
        $("#add_row_loan").click(function() {
            $('#addr_loan' + i).html("<td>" + (i + 1) + "</td><td><input class='form-control' id='documents_loan" + i + "' name='documents_loan[]' type='file'></td><td><input type='text' class='form-control form-control-sm' name='document_types_loan[]' id='document_types_loan'></select></td><td></td>");
            $('#tab_logic_loan').append('<tr id="addr_loan' + (i + 1) + '"></tr>');
            i++;
        });

        $("#delete_row_loan").click(function() {
            if (i > 1) {
                $("#addr_loan" + (i - 1)).html('');
                i--;
            }
        });
    });
    //////////////////////////strt allowance////////////
    $(document).ready(function() {
        var i = 1;
        $("#add_row_allowance").click(function() {
            $('#addr_allowance' + i).html("<td>" + (i + 1) + "</td><td><input class='form-control' id='documents_allowance" + i + "' name='documents_allowance[]' type='file'></td><td><input type='text' class='form-control form-control-sm' name='document_types_allowance[]' id='document_types_allowance'></select></td><td></td>");
            $('#tab_logic_allowance').append('<tr id="addr_allowance' + (i + 1) + '"></tr>');
            i++;
        });

        $("#delete_row_allowance").click(function() {
            if (i > 1) {
                $("#addr_allowance" + (i - 1)).html('');
                i--;
            }
        });
    });

    //////////////////////////
    function showForm() {
        // Hide all forms
        document.querySelectorAll('.request-form').forEach(form => form.style.display = 'none');

        // Get selected value
        const selectedValue = document.getElementById('requestType').value;

        // Show the form based on selected value
        if (selectedValue === 'compensatory_leave') {
            document.getElementById('compensatory_leave_form').style.display = 'block';
        } else if (selectedValue === 'advance_salary') {
            document.getElementById('advance_salary_form').style.display = 'block';
        } else if (selectedValue === 'allowance') {
            document.getElementById('allowance_form').style.display = 'block';
        } else if (selectedValue === 'loan') {
            document.getElementById('loan_form').style.display = 'block';
        } 

         else if (selectedValue === 'ticket_allowance') {
            document.getElementById('air_ticket_form').style.display = 'block';
        }

         else if (selectedValue === 'service_request') {
            document.getElementById('service_request_form').style.display = 'block';
        }
        
    }

    function checkSelection() {
        const selectBox = document.getElementById("requestType");
        const tooltipMessage = document.getElementById("tooltipMessage");


        if (selectBox.value) {
            tooltipMessage.style.display = "none";
        } else {
            tooltipMessage.style.display = "block";
        }
    }
    /////////////calculation loan/////////////////
    function calculateTotalMonths() {
        const startMonth = document.getElementById("start_month").value;
        const endMonth = document.getElementById("end_month").value;

        if (startMonth && endMonth) {
            // Extract year and month from the input values
            const [startYear, startMonthValue] = startMonth.split('-');
            const [endYear, endMonthValue] = endMonth.split('-');

            // Convert to integers for calculations
            const startYearInt = parseInt(startYear, 10);
            const startMonthInt = parseInt(startMonthValue, 10);
            const endYearInt = parseInt(endYear, 10);
            const endMonthInt = parseInt(endMonthValue, 10);

            // Calculate the months difference
            let totalMonths = (endYearInt - startYearInt) * 12 + (endMonthInt - startMonthInt);

            // If the total months is less than or equal to zero, set it to an empty value
            if (totalMonths >= 0) {
                document.getElementById("total_month").value = totalMonths + 1; // Include the start month
            } else {
                document.getElementById("total_month").value = '';
            }
        } else {
            document.getElementById("total_month").value = '';
        }
        calculateEMI();
    }


    function calculateEMI() {
        const rAmount = parseFloat(document.getElementById("r_amount").value) || 0;
        const totalMonths = parseFloat(document.getElementById("total_month").value) || 0;

        // Calculate EMI if both values are entered
        if (totalMonths > 0 && rAmount > 0) {
            const emi = rAmount / totalMonths;
            document.getElementById("emi_amount").value = emi.toFixed(2);
        } else {
            document.getElementById("emi_amount").value = '';
        }
    }

    function setEligibilityRange() {
    const last_ticket_date_Input = document.getElementById('last_ticket_date');
    const descCell = document.getElementById('eligibility_desc');

    if (last_ticket_date_Input.value) {
        const last_ticket_date = new Date(last_ticket_date_Input.value);
        const nextYearDate = new Date(last_ticket_date);
        nextYearDate.setFullYear(nextYearDate.getFullYear() + 1);
        const currentDate = new Date();

        // Format helper
        const formatDate = (d) => {
            const dd = String(d.getDate()).padStart(2, '0');
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const yyyy = d.getFullYear();
            return `${mm}/${dd}/${yyyy}`;
        };

        // Compare if current date >= nextYearDate
        if (currentDate >= nextYearDate) {
            descCell.textContent = `Eligible`;
            descCell.style.color = "green";
            descCell.style.fontWeight = "600";
        } else {
            descCell.textContent = `Not Eligible`;
            descCell.style.color = "red";
            descCell.style.fontWeight = "600";
        }
    } else {
        descCell.textContent = "Eligible for — (Last Ticket Date + 1 year)";
        descCell.style.color = "";
        descCell.style.fontWeight = "";
    }
}

// Update Grand Total dynamically
function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.net_amount').forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('grand_total').value = total.toFixed(2);
}
// Trigger on page load in case rejoin date is already set
document.addEventListener('DOMContentLoaded', setEligibilityRange);
document.addEventListener('DOMContentLoaded', updateGrandTotal);
function addRow() {
    let row = `
    <tr>
        <td><input type="text" name="item_name[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="item_purpose[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="supplier[]" class="form-control form-control-sm"></td>
        <td><input type="number" step="0.01" name="net_amount[]" class="form-control form-control-sm netAmount" oninput="calculateTotal()"></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">×</button></td>
    </tr>
    `;
    document.getElementById("serviceRows").insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest("tr").remove();
    calculateTotal();
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.netAmount').forEach(input => {
        if (input.value) total += parseFloat(input.value);
    });
    document.getElementById('grandTotal').value = total.toFixed(2);
}
</script>