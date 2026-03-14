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
    <?php foreach ($record1 as $row) : ?>
        <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_emp_overtime" id="addform" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name :</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <?php foreach ($records as $s) {
                        if ($row->employee_id == $s->user_id) { ?>
                            <input type='text' class="form-control form-control-sm" id="employee_id" name="employee_id" value="<?php echo $s->user_name; ?>" tabindex="1" readonly />
                            <input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
                    <?php

                        }
                    } ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date:</label>
                <div class="col-sm-5">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="overtime_date" name="overtime_date" value="<?php echo date('d-m-Y', strtotime($row->date_ot) ?? '') ?>" tabindex=2>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Overtime in(Hours):</label>
                <div class="col-sm-5">
                    <input type="number" step="0.01" class="form-control form-control-sm" id="ot" name="ot" tabindex="3" min='0' value="<?php echo $row->overtime; ?>">
                </div>
            </div>


            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                <div class="col-sm-5">
                    <textarea id="remark" name="remark" rows="2" tabindex="4" placeholder="remark" style="width: 100%;"><?php echo $row->rem; ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row->emp_oid; ?>">

                    <button type="submit" id='add' tabindex="5" class="btn btn-primary m-b-0">submit</button>
                </div>
            </div>
        </form>
</div>
<?php endforeach ?>
</div>



<!-- <script>
    function get_stock_code() {
        //var order_code= document.getElementById("order_code0").value;
        //var size= document.getElementById("size").value;
        //var x= size+order_code;
        var x = document.getElementById("stock_code").value;

        $.ajax({
            url: "<?php echo site_url('Ajax/ajax_get_min_stock_qty'); ?>",
            type: 'POST',
            data: {
                stock_code: x
            },
            success: function(msg) {
                document.getElementById("min_stock_qty").value = msg;
            }
        });
    }
</script> -->