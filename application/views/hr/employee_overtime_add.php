<style type="text/css">
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 240px !important;
        min-width: 240px !important;
    }
</style>

<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_emp_overtime_data" id="addform" autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <select tabindex="1" class="form-select form-control-sm select2" id="employee_id" name="employee_id" required>
                    <option value="">Select</option>
                    <?php foreach ($records as $s) { ?>
                        <option <?php if ($this->session->userdata('user_id') == $s->user_id) echo 'selected'; ?> value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date:</label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="overtime_date" name="overtime_date" value="<?php echo date('d-m-Y') ?>" tabindex=2>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Overtime in(Hours):</label>
            <div class="col-sm-5">
                <input type="number" step="0.01" class="form-control form-control-sm" id="ot" name="ot" tabindex="3" min='0'>
            </div>
        </div>


        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
            <div class="col-sm-5">
                <textarea id="remark" name="remark" tabindex="4" rows="2" placeholder="remark" style="width: 100%;"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" id='add' tabindex="5" class="btn btn-primary m-b-0">submit</button>
            </div>
        </div>
    </form>
</div>
</div>