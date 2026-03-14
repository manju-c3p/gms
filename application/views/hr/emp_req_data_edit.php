
<?php $request = $records[0]; ?>
<div class="card-body">

    <?php foreach ($records as $row):
    ?>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Request Type: <spanstyle="color: red;">
                    *</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <select class="form-select form-control-sm select2 " id="requestType" name="requestType" tabindex="10"
                    disabled>
                    <option value="">Select</option>
                    <option value="compensatory_leave" <?php if ($row->emp_reqtype == 'compensatory_leave')
                                                            echo 'selected'; ?>>Compensatory Leave</option>
                    <option value="advance_salary" <?php if ($row->emp_reqtype == 'advance_salary')
                                                        echo 'selected'; ?>>
                        Advance Salary</option>
                    <option value="allowance" <?php if ($row->emp_reqtype == 'allowance')
                                                    echo 'selected'; ?>>Allowance
                    </option>
                    <option value="loan" <?php if ($row->emp_reqtype == 'loan')
                                                echo 'selected'; ?>>Loan</option>
                    <option value="attendance_mismatch" <?php if ($row->emp_reqtype == 'attendance_mismatch')
                                                            echo 'selected'; ?>>Attendance Mismatch</option>
                     <option value="ticket_allowance" <?php if ($row->emp_reqtype == 'ticket_allowance')
                         echo 'selected'; ?>>Ticket Allowance</option>
                 <option value="service_request" <?php if ($row->emp_reqtype == 'service_request')
                         echo 'selected'; ?>>Service Request</option>
            
            </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <?php foreach ($user_records as $s) {
                    if ($row->user_id == $s->user_id) { ?>
                        <input type='text' class="form-control form-control-sm  bg-soft-gray" id="employee_id" name="employee_id"
                            value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
                        <input type='hidden' name="employee_id_hidden" value="<?php echo $row->user_id; ?>" />
                <?php }
                } ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date ">
                    <input type="text" class="form-control form-control-sm bg-soft-gray " id="app_date" name="app_date"
                        readonly value="<?php echo date('d-m-Y', strtotime($row->app_date) ?? '') ?>" tabindex=2 required>
                </div>
            </div>
        </div>

        <?php if ($row->emp_reqtype == 'compensatory_leave') { ?>
            <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_comp_off_data_hr"
                autocomplete="off" enctype="multipart/form-data">

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Working:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date ">
                            <input type="text" class="form-control form-control-sm bg-soft-gray" id="work_date" name="work_date"
                                readonly value="<?php echo date('d-m-Y', strtotime($row->form_date) ?? '') ?>" tabindex=2
                                required>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Comp Off:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date ">
                            <input type="text" class="form-control form-control-sm bg-soft-gray" id="comp_date" name="comp_date"
                                value="<?php echo date('d-m-Y', strtotime($row->to_date) ?? '') ?>" tabindex=2 required
                                readonly>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="remark" name="remark" rows="2" placeholder="remark" readonly style="width: 100%;"
                            class="bg-soft-gray" tabindex=8><?php echo $row->remark; ?></textarea>
                    </div>
                </div>

                <!-- //////////////////////////////////approve details/////////////////////// -->

                <h6>Details of Comp Off Approval</h6>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="approve_date"
                                name="approve_date"
                                value="<?php if ($row->approved_date == '')
                                            echo date('d-m-Y');
                                        else
                                            echo date('d-m-Y', strtotime($row->approved_date) ?? '') ?>" required
                                tabindex="1">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Comp Off Date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date">
                            <input type="text" class="form-control form-control-sm" id="a_comp_date" name="a_comp_date"
                                value="<?php echo ($row->approved_form_date == '') ? date('d-m-Y', strtotime($row->to_date)) : date('d-m-Y', strtotime($row->approved_form_date)); ?>"
                                required tabindex="1">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Comp Off Status :<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <select class="form-select form-control-sm" name="comp_status" id="comp_status" required tabindex="4">
                            <option value="" disabled <?php echo !isset($row->approved_flag) || $row->approved_flag == 0 ? 'selected' : ''; ?>>
                                Please select Comp Off Status
                            </option>
                            <option value="1" <?php echo isset($row->approved_flag) && $row->approved_flag == 1 ? 'selected' : ''; ?>>
                                Approved
                            </option>
                            <option value="2" <?php echo isset($row->approved_flag) && $row->approved_flag == 2 ? 'selected' : ''; ?>>
                                Rejection
                            </option>
                        </select>


                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="approve_remark" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
                            tabindex="5"><?php echo $row->approve_remark; ?> </textarea>
                    </div>
                </div>
                <!-- //////////////////////////////////////////////////////end approval data//////////// -->
                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <input type='hidden' name="employee_id_hidden" value="<?php echo $row->user_id; ?>" />

                        <input type="hidden" name="id" value="<?php echo $row->emp_req_id; ?>">

                        <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Update Comp off
                            status</button>
                    </div>
                </div>
            </form>
        <?php } // end of comp_off_data_hr
        else if ($row->emp_reqtype == 'advance_salary') { ?>
            <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_advance_salary_data_hr"
                autocomplete="off" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Select Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <input type="month" class="form-control form-control-sm bg-soft-gray" id="a_month" name="a_month"
                            value="<?php echo date('Y-m', strtotime($row->form_date ?? '')) ?>" required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Salary Amount:</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control form-control-sm bg-soft-gray" id="advance_salary"
                            name="advance_salary" value="<?php echo $row->amount; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;" readonly
                            tabindex=8 class="bg-soft-gray">
                                                        <?php echo $row->remark; ?>
                                                                    </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">View Documents:</label>
                    <div class="col-sm-8">
                        <table class="table table-bordered table-hover" id="tab_logic_salary">
                            <tbody>
                                <?php if ($file_records1): ?>
                                    <?php $x = 1;
                                    $i = 1; ?>
                                    <?php foreach ($file_records1 as $k): ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><a href="<?php echo base_url() . 'public/uploded_documents/' . $k->document_path; ?>"
                                                    download>File <?php echo $x++; ?></a></td>
                                            <td><?php echo $k->document_name; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <!-- <tr id='addr_salary0'>
                                            <td>1</td>
                                            <td><input class="form-control form-control-sm" id="documents_salary" name="documents_salary[]" tabindex="6" type="file"></td>
                                            <td><input type='text' class="form-control form-control-sm" name="document_types_salary[]" id="document_types_salary" placeholder="enter doc name"></td>
                                            <td>
                                                <a id="add_row_salary" title="Add" class="btn btn-sm bg-blue"><span class="fa fa-plus"></span></a>
                                                <a id='delete_row_salary' title="Delete" class="btn btn-sm bg-blue"><span class="fa fa-trash"></span></a>
                                            </td>
                                        </tr>
                                        <tr id='addr_salary1'></tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <h6>Details of Advance Salary Approval</h6>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="approve_date"
                                name="approve_date"
                                value="<?php if ($row->approved_date == '')
                                            echo date('d-m-Y');
                                        else
                                            echo date('d-m-Y', strtotime($row->approved_date) ?? '') ?>" required
                                tabindex="1">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
                        Approve Advance Salary Month:<span style="color: red;">*</span>
                    </label>
                    <div class="col-sm-5">
                        <input type="month" class="form-control form-control-sm" id="ad_month" name="ad_month" required
                            value="<?php echo ($row->approved_form_date == '') ? date('Y-m', strtotime($row->form_date)) : date('Y-m', strtotime($row->approved_form_date)); ?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Advance Salary Amount:</label>
                    <div class="col-sm-5">
                        <input type="number" class="form-control form-control-sm" id="approve_advance_salary"
                            name="approve_advance_salary" value="<?php if ($row->approved_amount == '')
                                                                        echo $row->amount;
                                                                    else
                                                                        echo $row->approved_amount; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Salary Status :<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <select class="form-select form-control-sm" name="advance_status" id="advance_status" required
                            tabindex="4">
                            <option value="" disabled <?php echo !isset($row->approved_flag) || $row->approved_flag == 0 ? 'selected' : ''; ?>>
                                Please select Salary Status
                            </option>
                            <option value="1" <?php echo isset($row->approved_flag) && $row->approved_flag == 1 ? 'selected' : ''; ?>>
                                Approved
                            </option>
                            <option value="2" <?php echo isset($row->approved_flag) && $row->approved_flag == 2 ? 'selected' : ''; ?>>
                                Rejection
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="approve_remark" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
                            tabindex="5"> <?php echo $row->approve_remark; ?> </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="<?php echo $row->emp_req_id; ?>">
                        <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Update Advance Salary
                            Status</button>
                    </div>
                </div>
            </form>
        <?php } // end of advance
        else if ($row->emp_reqtype == 'allowance') { ?>
            <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_allowance_data_hr"
                autocomplete="off" enctype="multipart/form-data">

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Allowance:<span
                            style="color: red;">*</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                        <select tabindex="1" class="form-control-sm select2" id="allowance_id" name="allowance_id" disabled
                            style="width: 400px;" required>
                            <option value="">Select</option>
                            <?php foreach ($allowance as $s) {
                                if ($s->allowance_type == 'A') { ?>
                                    <option <?php if ($row->allowance_type == $s->sno)
                                                echo 'selected'; ?> value="<?php echo $s->sno; ?>">
                                        <?php echo $s->allowance_name; ?>
                                    </option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>



                <!-- From and To Date -->
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">From Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm bg-soft-gray" id="from_date" name="from_date"
                                readonly value="<?php echo date('Y-m', strtotime($row->form_date) ?? '') ?>" tabindex="3"
                                required>
                        </div>
                    </div>
                    <label class="col-xs-8 col-sm-2 col-md-2 col-lg-1 col-form-label">To Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm bg-soft-gray" id="to_date" name="to_date"
                                readonly value="<?php echo date('Y-m', strtotime($row->to_date) ?? '') ?>" tabindex="4"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Amount -->
                <div class="form-group row">
                    <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Amount<span
                            style="color: red;">*</span>:</label>
                    <div class="col-sm-5">
                        <input type="number" step="0.01" id="a_amount" name="a_amount" required readonly class="bg-soft-gray"
                            placeholder="Enter Allowance Amount" style="width: 100%;" tabindex="8"
                            value="<?php echo $row->amount; ?>">
                    </div>
                </div>

                <!-- Remark -->
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark:</label>
                    <div class="col-sm-5">
                        <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;" readonly
                            class="bg-soft-gray" tabindex="8"><?php echo $row->remark; ?></textarea>
                    </div>
                </div>

                <!-- Approval Details -->
                <h6>Details of Allowance Approval</h6>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="approve_date"
                                name="approve_date"
                                value="<?php if ($row->approved_date == '')
                                            echo date('d-m-Y');
                                        else
                                            echo date('d-m-Y', strtotime($row->approved_date) ?? '') ?>"
                                required tabindex="1">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="approve_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Allowance
                        Amount<span style="color: red;">*</span>:</label>
                    <div class="col-sm-5">
                        <input type="number" step="0.01" id="approve_amount" name="approve_amount" required
                            placeholder="Enter Approve Amount" style="width: 100%;" tabindex="8" value="<?php if ($row->approved_amount == '')
                                                                                                            echo $row->amount;
                                                                                                        else
                                                                                                            echo $row->approved_amount; ?>">
                    </div>
                </div>

                <!-- Allowance Status -->
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Allowance Status:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <select class="form-select form-control-sm" name="allowance_status" id="allowance_status" required
                            tabindex="4">
                            <option value="" disabled <?php echo !isset($row->approved_flag) || $row->approved_flag == 0 ? 'selected' : ''; ?>> Please select Allowance Status
                            </option>
                            <option value="1" <?php echo isset($row->approved_flag) && $row->approved_flag == 1 ? 'selected' : ''; ?>>
                                Approved
                            </option>
                            <option value="2" <?php echo isset($row->approved_flag) && $row->approved_flag == 2 ? 'selected' : ''; ?>>
                                Rejection
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">from Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm " id="a_start_month"
                                name="a_start_month"
                                value="<?php echo ($row->approved_form_date == '') ? date('Y-m', strtotime($row->form_date)) : date('Y-m', strtotime($row->approved_form_date)); ?>"
                                tabindex="3" required>
                        </div>
                    </div>
                    <label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">To Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm " id="a_end_month" name="a_end_month"
                                value="<?php echo ($row->approved_to_date == '') ? date('Y-m', strtotime($row->to_date)) : date('Y-m', strtotime($row->approved_to_date)); ?>"
                                tabindex="4" required>
                        </div>
                    </div>
                </div>
                <!-- Approval Remark -->
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark:</label>
                    <div class="col-sm-5">
                        <textarea id="approve_remark" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
                            tabindex="5"><?php echo $row->approve_remark; ?> </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <input type="hidden" name="id" value="<?php echo $row->emp_req_id; ?>">
                        <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Update
                            Allowance Status</button>
                    </div>
                </div>



            </form>
        <?php } // end of allowance
        else if ($row->emp_reqtype == 'loan') { ?>
            <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_loan_data_hr"
                autocomplete="off" enctype="multipart/form-data">
                <!-- #region -->
                <div class="form-group row">
                    <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Requested Amount<span
                            style="color: red;">*</span>:</label>
                    <div class="col-sm-5">
                        <input type="number" step="0.01" id="r_amount" name="r_amount" required
                            placeholder="Enter requested Amount" style="width: 100%;" tabindex="8" readonly
                            value="<?php echo $row->amount ?>" class="bg-soft-gray">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Start Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm bg-soft-gray" id="start_month" readonly
                                name="start_date" value="<?php echo date('Y-m', strtotime($row->form_date ?? '')) ?>"
                                tabindex="3" required>
                        </div>
                    </div>
                    <label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">End Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm bg-soft-gray" id="end_month" name="end_date"
                                readonly value="<?php echo date('Y-m', strtotime($row->to_date ?? '')) ?>" tabindex="4"
                                required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Month<span
                            style="color: red;">*</span>:</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" id="total_month" name="total_month" required placeholder="Total Month"
                            style="width: 100%;" tabindex="8" value="<?php echo $row->total_month ?>" readonly
                            class="bg-soft-gray">
                    </div>
                    <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-form-label">EMI Amount Per/Month<span
                            style="color: red;">*</span>:</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" id="emi_amount" name="emi_amount" required placeholder="EMI Amount"
                            style="width: 100%;" tabindex="8" readonly value="<?php echo $row->emi_amount ?>"
                            class="bg-soft-gray">
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
                            class="bg-soft-gray" readonly tabindex=8><?php echo $row->remark; ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">View Documents:</label>
                    <div class="col-sm-8">
                        <table class="table table-bordered table-hover" id="tab_logic_loan">
                            <tbody>
                                <?php if ($file_records3) {
                                    $x = 1;
                                    $i = 1;
                                    foreach ($file_records3 as $k) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $i;
                                                $i++; ?>
                                            </td>
                                            <td><a href="<?php echo base_url() . 'public/uploded_documents/' . $k->document_path; ?>"
                                                    download>File
                                                    <?php echo $x;
                                                    $x++; ?></a>
                                            </td>
                                            <td>
                                                <?php echo $k->document_name; ?>
                                            </td>
                                        </tr>
                                <?php }
                                } ?>
                                <!-- <tr id='addr_loan0'>
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
                                    </tr> -->
                                <!-- <tr id='addr_loan1'></tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <h6>Details of Loan Approval</h6>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="approve_date"
                                name="approve_date"
                                value="<?php if ($row->approved_date == '')
                                            echo date('d-m-Y');
                                        else
                                            echo date('d-m-Y', strtotime($row->approved_date) ?? '') ?>"
                                required tabindex="1">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Requested
                        Amount<span style="color: red;">*</span>:</label>
                    <div class="col-sm-5">
                        <input type="number" step="0.01" id="ar_amount" name="ar_amount" required
                            placeholder="Enter requested Amount" style="width: 100%;" tabindex="8" oninput="calculateEMI()"
                            value="<?php if ($row->approved_amount == '')
                                        echo $row->amount;
                                    else
                                        echo $row->approved_amount; ?>">
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Start Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm " id="a_start_month"
                                onchange="calculateTotalMonths()" name="a_start_month"
                                value="<?php echo ($row->approved_form_date == '') ? date('Y-m', strtotime($row->form_date)) : date('Y-m', strtotime($row->approved_form_date)); ?>"
                                tabindex="3" required>
                        </div>
                    </div>
                    <label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">Approve End Month:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-2">
                        <div class="input-group date ">
                            <input type="month" class="form-control form-control-sm " id="a_end_month" name="a_end_month"
                                value="<?php echo ($row->approved_to_date == '') ? date('Y-m', strtotime($row->to_date)) : date('Y-m', strtotime($row->approved_to_date)); ?>"
                                tabindex="4" required onchange="calculateTotalMonths()">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Month<span
                            style="color: red;">*</span>:</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" id="a_total_month" name="a_total_month" required
                            placeholder="Total Month" style="width: 100%;" tabindex="8" oninput="calculateEMI()" readonly value="<?php if ($row->approve_total_month == '')
                                                                                                                                        echo $row->total_month;
                                                                                                                                    else
                                                                                                                                        echo $row->approve_total_month; ?>">
                    </div>
                    <label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-form-label">EMI Amount Per/Month<span
                            style="color: red;">*</span>:</label>
                    <div class="col-sm-2">
                        <input type="number" step="0.01" id="a_emi_amount" name="a_emi_amount" required placeholder="EMI Amount"
                            style="width: 100%;" tabindex="8" readonly value="<?php if ($row->approve_emi == '')
                                                                                    echo $row->emi_amount;
                                                                                else
                                                                                    echo $row->approve_emi; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Loan Status :<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <select class="form-select form-control-sm" name="loan_status" id="loan_status" required tabindex="4">
                            <option value="" disabled <?php echo !isset($row->approved_flag) || $row->approved_flag == 0 ? 'selected' : ''; ?>> Please select Loan Stat </option>
                            <option value="1" <?php echo isset($row->approved_flag) && $row->approved_flag == 1 ? 'selected' : ''; ?>>
                                Approved
                            </option>
                            <option value="2" <?php echo isset($row->approved_flag) && $row->approved_flag == 2 ? 'selected' : ''; ?>>
                                Rejection
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="approve_remark" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
                            tabindex="5"><?php echo $row->approve_remark; ?> </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="<?php echo $row->emp_req_id; ?>">

                        <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Approval/Rejection For
                            Loan</button>
                    </div>
                </div>
            </form>

        <?php } // end of allowance
        else if ($row->emp_reqtype == 'attendance_mismatch') { ?>
            <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_missing_attendance_data_hr"
                autocomplete="off" enctype="multipart/form-data">


                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Missing Attendance Date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date ">
                            <input type="text" class="form-control form-control-sm  bg-soft-gray" id="request_miss_att_date"
                                name="request_miss_att_date"
                                value="<?php echo date('d-m-Y', strtotime($row->form_date ?? '')) ?>"
                                readonly tabindex="1">
                        </div>
                    </div>



                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
                        Recorded In Time:<span style="color: red;">*</span>
                    </label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm bg-soft-gray" id="record_in_time" name="record_in_time" readonly value="<?php echo $row->rec_in_time; ?>">
                    </div>

                    <label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">
                        Recorded Out Time:<span style="color: red;">*</span>
                    </label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm bg-soft-gray" id="record_out_time" name="record_out_time" readonly value="<?php echo $row->rec_out_time; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
                        Requested In Time:<span style="color: red;">*</span>
                    </label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm bg-soft-gray" id="requested_in_time" name="requested_out_time" readonly value="<?php echo $row->in_time; ?>">
                    </div>

                    <label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">
                        Requested Out Time:<span style="color: red;">*</span>
                    </label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm bg-soft-gray" id="requested_out_time" name="requested_out_time" readonly value="<?php echo $row->out_time; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
                            class="bg-soft-gray" readonly tabindex=8><?php echo $row->remark; ?></textarea>
                    </div>
                </div>


                <h6>Details of Missing Attendance Approval</h6>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="approve_date"
                                name="approve_date"
                                value="<?php if ($row->approved_date == '')
                                            echo date('d-m-Y');
                                        else
                                            echo date('d-m-Y', strtotime($row->approved_date) ?? '') ?>"
                                required tabindex="1">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
                        In Time:<span style="color: red;">*</span>
                    </label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm" id="req_in_time" name="req_in_time" required value="<?php echo $row->rec_in_time; ?>">
                    </div>

                    <label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">
                        Out Time:<span style="color: red;">*</span>
                    </label>
                    <div class="col-sm-2">
                        <input type="time" class="form-control form-control-sm" id="req_out_time" name="req_out_time" required value="<?php echo $row->rec_out_time; ?>">
                    </div>
                </div>





                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label"> Status :<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <select class="form-select form-control-sm" name="attendance_status" id="attendance_status" required tabindex="4">
                            <option value="" disabled <?php echo !isset($row->approved_flag) || $row->approved_flag == 0 ? 'selected' : ''; ?>> Please select atttndance Stat </option>
                            <option value="1" <?php echo isset($row->approved_flag) && $row->approved_flag == 1 ? 'selected' : ''; ?>>
                                Approved
                            </option>
                            <option value="2" <?php echo isset($row->approved_flag) && $row->approved_flag == 2 ? 'selected' : ''; ?>>
                                Rejection
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="approve_remark" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
                            tabindex="5"><?php echo $row->approve_remark; ?> </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="<?php echo $row->emp_req_id; ?>">
                        <input type='hidden' name="employee_id_hidden" value="<?php echo $row->user_id; ?>" />

                        <button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Approval/Rejection For
                            Missing Attendance</button>
                    </div>
                </div>
            </form>
        <?php } 

else if ($row->emp_reqtype == 'ticket_allowance') { ?>
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_ticket_allowance_data_hr"
    autocomplete="off" enctype="multipart/form-data">

    <?php
    // Get the user details
    $user = null;
    foreach ($user_records as $u) {
        if ($row->user_id == $u->user_id) {
            $user = $u; break;
        }
    }
    ?>

    <!-- Employee Info -->
    <div class="form-group row">
        

        <label class="col-sm-3 col-form-label">Employee ID:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                   value="<?= $user->user_code ?? '' ?>" readonly>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Department:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                   value="<?= $user->dept_name ?? '' ?>" readonly>
        </div>

        <label class="col-sm-3 col-form-label">Designation:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="designation"
                   value="<?= $user->designation_name ?? '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Joining Date:</label>
        <div class="col-sm-3">
            <input type="date" class="form-control form-control-sm" name="joining_date"
                   value="<?= $user->joining_date ?? '' ?>">
        </div>

        <label class="col-sm-3 col-form-label">Visa Expiry Date:</label>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="visa_expiry_date"
                   value="<?= $row->visa_expiry_date ?? '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Last Ticket Issued Date:</label>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="last_ticket_date"
                   value="<?= $row->form_date ?? '' ?>" onchange="setEligibilityRange()">
        </div>

        <label class="col-sm-3 col-form-label">Rejoin Date:</label>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="rejoin_date"
                   value="<?= $row->rejoin_date ?? '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Leave Request From:</label>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="leave_from"
                   value="<?= $row->form_date ?? '' ?>">
        </div>

        <label class="col-sm-3 col-form-label">Leave Request To:</label>
        <div class="col-sm-3">
            <input type="date" class="form-control" name="leave_to"
                   value="<?= $row->to_date ?? '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Remark:</label>
        <div class="col-sm-3">
            <textarea class="form-control" name="remark"><?= $row->remark ?? '' ?></textarea>
        </div>

        <label class="col-sm-3 col-form-label">Net Amount (AED):</label>
        <div class="col-sm-3">
            <input type="number" class="form-control form-control-sm" name="ticket_amount"
                   value="<?= $row->amount ?? '' ?>" required>
        </div>
    </div>

    <!-- Approval Section -->
    <h6>Details of Ticket Allowance Approval</h6>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Approve Date:<span style="color: red;">*</span></label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm datepicker1" name="approve_date"
                   value="<?= ($row->approved_date == '') ? date('d-m-Y') : date('d-m-Y', strtotime($row->approved_date)); ?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Approved Amount:<span style="color: red;">*</span></label>
        <div class="col-sm-5">
            <input type="number" step="0.01" class="form-control form-control-sm" name="approved_amount"
                   value="<?= ($row->approved_amount == '') ? $row->amount : $row->approved_amount; ?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Ticket Allowance Status:<span style="color: red;">*</span></label>
        <div class="col-sm-5">
            <select class="form-select form-control-sm" name="ticket_status" required>
                <option value="" disabled <?= !isset($row->approved_flag) || $row->approved_flag == 0 ? 'selected' : ''; ?>>Please select Status</option>
                <option value="1" <?= isset($row->approved_flag) && $row->approved_flag == 1 ? 'selected' : ''; ?>>Approved</option>
                <option value="2" <?= isset($row->approved_flag) && $row->approved_flag == 2 ? 'selected' : ''; ?>>Rejection</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Approval Remark :</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="approve_remark"><?= $row->approve_remark; ?></textarea>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <input type="hidden" name="id" value="<?= $row->emp_req_id; ?>">
            <button type="submit" class="btn btn-primary m-b-0">Update Ticket Allowance Status</button>
        </div>
    </div>

</form>
<?php }
 else if ($row->emp_reqtype == 'service_request') { ?>
<!-- Service Request Form -->
<form id="service_request" class="request-form" method="post"
      action="<?= base_url('index.php/Hr/update_service_request_data'); ?>" 
      autocomplete="off" enctype="multipart/form-data">

<input type="hidden" name="emp_req_id" value="<?php echo $records[0]->emp_req_id; ?>">

    <!-- EMPLOYEE NAME -->
    <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Employee Name:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                   value="<?= $user->user_name ?? '' ?>" readonly>
            <input type="hidden" name="employee_id" value="<?= $request->user_id ?? '' ?>">
        </div>
    </div> -->

    <!-- DEPARTMENT -->
    <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Department:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                   value="<?= $user->dept_name ?? '' ?>" readonly>
        </div>
    </div> -->

    <!-- DATE -->
    <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Date:</label>
        <div class="col-sm-5">
            <input type="date" class="form-control form-control-sm"
                   name="request_date" 
                   value="<?= $request->app_date ?? date('Y-m-d') ?>" required>
        </div>
    </div> -->

    <!-- PROJECT -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Project:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm"
                   name="project_name" value="<?= $request->project_name ?? '' ?>">
        </div>
    </div>

    <!-- URGENCY -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Urgency:</label>
        <div class="col-sm-5">
            <select class="form-control form-control-sm" name="urgency">
                <?php 
                $urgency = $request->urgency ?? '';
                ?>
                <option value="">Select</option>
                <option <?= ($urgency=='Low')?'selected':'' ?>>Low</option>
                <option <?= ($urgency=='Medium')?'selected':'' ?>>Medium</option>
                <option <?= ($urgency=='High')?'selected':'' ?>>High</option>
                <option <?= ($urgency=='Critical')?'selected':'' ?>>Critical</option>
            </select>
        </div>
    </div>

    <!-- SERVICE ITEMS -->
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
                    <?php if (!empty($items)) : ?>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><input type="text" name="item_name[]" class="form-control form-control-sm"
                                           value="<?= $item->item_name ?? '' ?>"></td>

                                <td><input type="text" name="item_purpose[]" class="form-control form-control-sm"
                                           value="<?= $item->item_purpose ?? '' ?>"></td>

                                <td><input type="text" name="supplier[]" class="form-control form-control-sm"
                                           value="<?= $item->supplier ?? '' ?>"></td>

                                <td><input type="number" step="0.01" name="net_amount[]" 
                                           class="form-control form-control-sm netAmount"
                                           value="<?= $item->net_amount ?? '' ?>" oninput="calculateTotal()"></td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">×</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Grand Total:</th>
                        <th>
                            <input type="text" id="grandTotal" 
                                   class="form-control form-control-sm" readonly>
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>

     <!-- Approval Section -->
    <h6>Details of Service Request Approval</h6>
    <div class="form-group row">
       <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="approve_date"
                                name="approve_date"
                                value="<?php if ($row->approved_date == '')
                                    echo date('d-m-Y');
                                else
                                    echo date('d-m-Y', strtotime($row->approved_date) ?? '') ?>" required
                                    tabindex="1">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
    <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Approved Amount:<span style="color: red;">*</span></label>
        <div class="col-sm-5">
            <input type="number" step="0.01" class="form-control form-control-sm" name="approved_amount"
                   value="<?= ($row->approved_amount == '') ? $row->amount : $row->approved_amount; ?>" required>
        </div>
    </div> -->

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Status:<span style="color: red;">*</span></label>
        <div class="col-sm-5">
            <select class="form-select form-control-sm" name="service_status" required>
                <option value="" disabled <?= !isset($row->approved_flag) || $row->approved_flag == 0 ? 'selected' : ''; ?>>Please select Status</option>
                <option value="1" <?= isset($row->approved_flag) && $row->approved_flag == 1 ? 'selected' : ''; ?>>Approved</option>
                <option value="2" <?= isset($row->approved_flag) && $row->approved_flag == 2 ? 'selected' : ''; ?>>Rejection</option>
            </select>
        </div>
    </div>

    <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Approval Remark :</label>
        <div class="col-sm-5">
            <textarea class="form-control" name="approve_remark"><?= $row->approve_remark; ?></textarea>
        </div>
    </div> -->

    <!-- SUBMIT -->
    <div class="form-group row">
        <label class="col-sm-3"></label>
        <div class="col-sm-5">
            <button type="submit" class="btn btn-primary">Update Service Request</button>
        </div>
    </div>

</form>


<?php } ?>



    <?php endforeach ?>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>

<script>
    function calculateTotalMonths() {
        const startMonth = document.getElementById("a_start_month").value;
        const endMonth = document.getElementById("a_end_month").value;

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
                document.getElementById("a_total_month").value = totalMonths + 1; // Include the start month
            } else {
                document.getElementById("a_total_month").value = '';
            }
        } else {
            document.getElementById("a_total_month").value = '';
        }
        calculateEMI()
    }


    function calculateEMI() {
        const rAmount = parseFloat(document.getElementById("ar_amount").value) || 0;
        const totalMonths = parseFloat(document.getElementById("a_total_month").value) || 0;

        // Calculate EMI if both values are entered
        if (totalMonths > 0 && rAmount > 0) {
            const emi = rAmount / totalMonths;
            document.getElementById("a_emi_amount").value = emi.toFixed(2);
        } else {
            document.getElementById("a_emi_amount").value = '';
        }
    }

    function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.netAmount').forEach(input => {
        let val = parseFloat(input.value) || 0;
        total += val;
    });
    document.getElementById('grandTotal').value = total.toFixed(2);
}

// Call on page load to populate total for existing items
window.addEventListener('DOMContentLoaded', (event) => {
    calculateTotal();
});
</script>