<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Salary</title>
</head>

<body>
    <div class="card-body">
        <?php foreach ($records as $row) : ?>
            <form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_advance_salary" autocomplete="off" enctype="multipart/form-data">
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                        <?php foreach ($user_records as $s) {
                            if ($row->emp_id == $s->user_id) { ?>
                                <input type='text' class="form-control form-control-sm" id="employee_id" name="employee_id" value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
                                <input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
                        <?php

                            }
                        } ?>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Salary Code:</label>
                    <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                        <input tabindex="1" type="hidden" name="as_code" id="as_code" class="form-control bg-soft-gray" value="<?php echo $row->as_code; ?>" readonly >

                    </div>
                </div> -->

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">From date:</label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="from_date" name="from_date" value="<?php echo date('d-m-Y', strtotime($row->form_date) ?? '') ?>" tabindex=2 required>
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">To date:</label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="to_date" name="to_date" value="<?php echo date('d-m-Y', strtotime($row->to_date) ?? '') ?>" tabindex=2 required>
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Deduction Amount:</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control form-control-sm" id="deduction_amount" name="deduction_amount" tabindex=4 value="<?php echo $row->deduction_amount; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                    <div class="col-sm-5">
                        <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;" tabindex="5"><?php echo isset($row->remark) ? htmlspecialchars($row->remark) : ''; ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="<?php echo $row->as_id; ?>">
                        <button type="submit" id='add' tabindex="9" class="btn btn-primary m-b-0">submit</button>
                    </div>
                </div>

            </form>
        <?php endforeach ?>
    </div>
    </div>
    </div>
</body>

</html>