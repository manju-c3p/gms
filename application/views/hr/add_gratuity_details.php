<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gratunity</title>
    <!-- Bootstrap CSS -->


    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 11px;
            width: 100%;
        }

        th {
            padding: 3px;
            width: 20%;
        }

        td {
            padding: 3px;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            margin-right: 20px;
        }

        textarea {
            width: calc(100% - 20px);
            margin-right: 20px;
        }

        select {
            width: calc(100% - 20px);
            margin-right: 20px;
        }

        .fa-calendar {
            position: absolute;
            right: 5px;
            top: calc(50% - 7px);
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="card-body">
        <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_allowances_data" id="addform" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span style="color: red;">*</span></label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="user_id" name="user_id" required onchange="get_gratuity_info()">
                        <option value="">Select</option>
                        <?php foreach ($user_records as $s) { ?>
                            <option <?php if ($this->session->userdata('user_id') == $s->user_id) echo 'selected'; ?> value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <h6>Gratuity Calculations</h6>
            <div class="form-group">
                <table cellspacing="0px" cellpadding="0px" class="table-bordered">
                    <thead>
                        <th>Year</th>

                        <th>Add Manually Days/Annum</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>0-1 year</th>

                            <td><input type="text" name="venue" tabindex="3" value="0"></td>
                        </tr>
                        <tr>
                            <th>1-3 year</th>

                            <td><input type="text" name="venue" tabindex="3" value="7"></td>
                        </tr>
                        <tr>
                            <th>3-5 year</th>

                            <td><input type="text" name="previously_allocated_designer" tabindex="5" value="14"></td>
                        </tr>
                        <tr>
                            <th>5 year above</th>

                            <td><input type="text" name="venue" tabindex="3" value="21"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">

                <h6>Attachment - 1</h6>
                <div class="form-group">
                    <table cellspacing="0px" cellpadding="0px" class="table-bordered">
                        <tbody>
                            <tr>
                                <th>Date of Joining</th>
                                <td class="input-group ">
                                    <input type="text" name="joining_date" id="joining_date" tabindex="2" value="<?php echo date('d-M-Y'); ?>" readonly>
                                    <!-- <i class="fa fa-calendar"></i> -->
                                </td>
                            </tr>
                            <tr>
                                <th>Last Day of Work</th>
                                <td class="input-group date datepicker1">
                                    <input type="text" name="last_date" id="last_date" tabindex="2" value="<?php echo date('d-M-Y'); ?>" onchange="calculateYearMonth()">

                                    <i class="fa fa-calendar"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>No. of years/months</th>
                                <td><input type="text" name="calculate_year_month" id="calculate_year_month" tabindex="5"></td>
                            </tr>
                            <tr>
                                <th>No. of days of basic</th>
                                <td><input type="text" name="no_basic_days" tabindex="3"></td>
                            </tr>
                            <tr>
                                <th>Basic Salary</th>
                                <td><input type="text" name="basic_salary" tabindex="3"></td>
                            </tr>
                            <tr>
                                <th style="text-align:right; font-weight: bold; color: black;">Total</th>
                                <td><input type="text" name="total" tabindex="3"></td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <h6>Attachment - 2</h6>
                <div class="form-group">
                    <table cellspacing="0px" cellpadding="0px" class="table-bordered">
                        <thead>
                            <tr>
                                <th>Annual Leave Calculation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Balance Days of Annual Leave</th>
                                <td><input type="text" name="annual_leave_days" tabindex="5"></td>
                            </tr>
                            <tr>
                                <th>Gross Salary</th>
                                <td><input type="text" name="gross_salary" tabindex="3"></td>
                            </tr>
                            <tr>
                                <th style="text-align:right; font-weight: bold; color: black;">Total</th>
                                <td><input type="text" name="total_salary" tabindex="3"></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>



            <div class="form-group">
                <table cellspacing="0px" cellpadding="0px" class="table-bordered">
                    <thead>
                        <tr>
                            <th style=" font-weight: bold; color: black;">Work Sheet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                                <th>Date ot Joint</th>
                                <td class="input-group date datepicker1">
                                    <input type="text" name="event_date" tabindex="2" value="<?php echo date('d-M-Y'); ?>">
                                    <i class="fa fa-calendar"></i>
                                </td>
                            </tr>
                            <tr>
                                <th>Date of Termination/Resignation </th>
                                <td class="input-group date datepicker1">
                                    <input type="text" name="event_date" tabindex="2" value="<?php echo date('d-M-Y'); ?>">
                                    <i class="fa fa-calendar"></i>
                                </td>
                            </tr> -->

                        <tr>
                            <th>No of Years / Months</th>
                            <td><input type="text" name="no_of_year_mont" tabindex="3"></td>
                        </tr>
                        <tr>
                            <th>No of days working </th>
                            <td><input type="text" name="no_day_working" tabindex="3"></td>
                        </tr>
                        <tr>
                            <th>Leaves taken </th>
                            <td><input type="text" name="leave_takes" tabindex="3"></td>
                        </tr>
                        <tr>
                            <th>Balance leavess</th>
                            <td><input type="text" name="leave_balance" tabindex="3"></td>
                        </tr>
                    </tbody>
                </table>

            </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2"></label>
        <div class="col-sm-10">
            <button type="submit" tabindex="105" id="add" class="btn btn-primary m-b-0">Submit</button>
        </div>
    </div>
    </form>
    </div>
</body>

</html>

<script>
    function get_gratuity_info() {
        var user_id = document.getElementById("user_id").value;
        if (user_id != '') {
            $.ajax({
                async: "false",
                type: "POST",
                url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_gratuity_info",
                data: {
                    user_id: user_id
                },
                dataType: "json",
                success: function(msg) {
                    document.getElementById("joining_date").value = msg.joining_date;
                    calculateYearMonth();
                }
            });
        } else {
            document.getElementById("joining_date").value = '';
            document.getElementById("calculate_year_month").value = '';
        }
    }

    function calculateYearMonth() {
        var joiningDate = new Date(document.getElementById("joining_date").value);
        var lastDayOfWork = new Date(document.getElementById("last_date").value);
        var diffInMonths = (lastDayOfWork.getFullYear() - joiningDate.getFullYear()) * 12 + lastDayOfWork.getMonth() - joiningDate.getMonth();
        var years = Math.floor(diffInMonths / 12);
        var months = diffInMonths % 12;
        document.getElementById("calculate_year_month").value = years + ' years, ' + months + ' months';
    }
</script>