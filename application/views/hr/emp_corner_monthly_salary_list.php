<div class="card-body">
    <div class="dt-responsive table-responsive">
        <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/view_emp_year_wise_salary"
            class="form-horizontal" autocomplete="off" name="question" id="question" enctype="multipart/form-data">

            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Year:</label>
                <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                    <div class="input-group date yearpicker">
                        <input type="text" class="form-control form-control-sm" id="from" name="from"
                            value="<?php echo isset($from) ? $from : date('Y'); ?>" placeholder="YYYY" maxlength="4">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7 text-right">
                    <input type="submit" id="view" name="go" value="Go" onclick="return validate();"
                        class="btn btn-sm btn-primary m-b-0" />
        </form>
        <!-- <form target="_blank" action="<?php echo base_url() . 'index.php/Hr/print_monthly_record/' ?>" id="ques1"
            method="post" name="ques1" class="d-inline">
            <input type="hidden" id="from" name="from" value="<?php echo $from; ?>">
            <input tabindex="6" type="submit" id="print" value="Print" class="btn btn-warning btn-sm" />
        </form>
        <form action="<?php echo base_url() . 'index.php/Hr/export_monthly_record/' ?>" id="ques1" method="post"
            name="ques1" class="d-inline">
            <input type="hidden" id="from" name="from" value="<?php echo $from; ?>">
            <input tabindex="7" type="submit" id="export" value="Export to excel" class="btn btn-warning btn-sm " />
        </form> -->

    </div>
</div>






<table id="datatable" class="table table-striped" data-toggle="data-table">
    <thead>
        <tr>
            <th>Sr No</th>
            <!-- <th>Employee Name</th> -->
            <th>Salary Month</th>
            <th>Working Days</th>
            <th>Total Leave</th>
            <th>Present Days</th>
            <th>Paid Leave</th>
            <th>Payment Days</th>
            <th>Total Overtime(hour)</th>
            <th>Overtime Amt</th>
            <th>Basic Salary</th>
            <th>Total Allowances</th>
            <th>Total Deduction</th>
            <th>Gross pay</th>
            <th>Net pay</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1;
        foreach ($records as $row) { ?>
            <tr>
                <td>
                    <?php echo $i;
                    $i++; ?>
                </td>
                <!-- <td>
                    <?php echo $row->user_name; ?>
                </td> -->
                <td>
                    <?php echo date('M-Y', strtotime($row->salary_month)); ?>
                </td>
                <td>
                    <?php echo $row->working_days; ?>
                </td>
                <td>
                    <?php echo $row->leave_days; ?>
                </td>
                <td>
                    <?php echo $row->present_days; ?>
                </td>
                <td>
                    <?php echo $row->paid_leave; ?>
                </td>
                <td>
                    <?php echo $row->payment_days; ?>
                </td>
                <td>
                    <?php echo $row->overtime; ?>
                </td>
                <td>
                    <?php echo $row->overtime_amt; ?>
                </td>
                <td>
                    <?php echo $row->basic_salary; ?>
                </td>
                <td>
                    <?php echo $row->total_allowance; ?>
                </td>
                <td>
                    <?php echo $row->total_deduction; ?>
                </td>
                <td>
                    <?php echo $row->gross_salary; ?>
                </td>
                <td>
                    <?php echo $row->net_salary; ?>
                </td>
                <td>
                    <?php echo $row->remark; ?>
                </td>
                <td>
                    <!-- <a href="<?php echo base_url() . 'index.php/Hr/edit_emp_monthly_salary/' . $row->sid; ?>"
                            title="Edit">
                            <?php echo $this->session->userdata('edit_icon'); ?>
                        </a> -->
                    <a href="<?php echo base_url() . 'index.php/Hr/print_monthly_payslip/' . $row->sid; ?>" title="Edit"
                        target="_blank">Print Payslip</a>
                    <!-- <a href="javascript:confirmcancel(<?php echo $row->sid; ?>)" title="Delete" class='delete'
                        id='delete'><?php echo $this->session->userdata('delete_icon'); ?></a> -->


                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>
</div>
</div>

<script>

    function confirmcancel(sid) {
        var r = confirm("Are you sure you want to Delete Record?");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Hr/delete_emp_monthly_salary_record",
                type: "POST",
                data: { sid: sid },
                success: function (msg) {
                    if (msg == 1) {
                        alert("Record deleted");
                        window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
                    }
                    else {
                        alert("Can't Delete record. Data already exist!!!");
                    }
                },
            });
            return true;
        }
        else
            return false;

    }
</script>
<script>
    $(document).ready(function () {
        $('.yearpicker').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
    });
</script>