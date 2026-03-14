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
    <?php foreach ($records as $row) : ?>
        <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_allowances" id="addform" autocomplete="off" enctype="multipart/form-data">

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Allowances Type<span style="color: red;"> * </span></label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <input type="hidden" id="allowance_type_hidden" name="allowance_type" value="<?php echo $row->allowance_type; ?>" tabindex="1">
                    <input type="text" class="form-control form-control-sm" value="<?php echo ($row->allowance_type == 'A') ? 'Allowances' : 'Deductions'; ?>" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Allowance Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm" id="allowance_name" name="allowance_name" tabindex="2" value="<?php echo $row->allowance_name ?>" placeholder="Enter Allowance Name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row->sno; ?>">

                    <button type="submit" id='add'tabindex="3" class="btn btn-primary m-b-0">submit</button>
                </div>
            </div>
        </form>
</div>
<?php endforeach ?>
</div>