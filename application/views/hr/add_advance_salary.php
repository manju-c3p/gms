<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Salary</title>
</head>

<body>
    <div class="card-body">
        <form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_advance_salary_details" autocomplete="off" enctype="multipart/form-data" tabindex=1>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span style="color: red;">*</span></label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <select tabindex="1" class="form-select form-control-sm select2" id="employee_id" name="employee_id" required>
                        <option value="">Select</option>
                        <?php foreach ($user_records as $s) { ?>
                            <option <?php if ($this->session->userdata('user_id') == $s->user_id) echo 'selected'; ?> value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">From date:<span style="color: red;">*</span></label>
                <div class="col-sm-5">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="from_date" name="from_date" value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">To date: <span style="color: red;">*</span></label>
                <div class="col-sm-5">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="to_date" name="to_date" value="<?php echo date('d-m-Y') ?>" tabindex=3 required>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Deduction Amount: <span style="color: red;">*</span></label>
                <div class="col-sm-3">
                    <input type="number" class="form-control form-control-sm" id="deduction_amount" name="deduction_amount" tabindex=4 required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                <div class="col-sm-5">
                    <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;" tabindex=5></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <button type="submit" tabindex="6" id="add" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
</body>

</html>