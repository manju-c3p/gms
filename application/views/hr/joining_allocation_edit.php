<div class="card-body">
    <?php foreach ($records as $row) : ?>
        <form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_joining_application" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <?php foreach ($user_records as $s) {
                        if ($row->employee_id == $s->user_id) { ?>
                            <input type='text' class="form-control form-control-sm bg-soft-gray" id="employee_id" name="employee_id" value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
                            <input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
                    <?php

                        }
                    } ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining Code:</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <input tabindex="1" type="text" name="ja_code" id="ja_code" class="form-control bg-soft-gray" value="<?php echo $row->joining_code; ?>" readonly>

                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining date:</label>
                <div class="col-sm-5">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="joining_date" name="joining_date" value="<?php echo date('d-m-Y', strtotime($row->joind) ?? '') ?>" tabindex=2>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining Type :</label>
                <div class="col-sm-5">
                    <select class="form-select form-control-sm" name="joining_type" id="joining_type" tabindex=3>
                        <option value="">Please select type</option>
                        <option <?php if ($row->joining_type == 'Resuming After Leave') echo 'selected'; ?> value="Resuming After Leave">Resuming After Leave</option>
                        <option <?php if ($row->joining_type == 'Observation Period') echo 'selected'; ?> value="Observation Period">Observation Period</option>
                        <option <?php if ($row->joining_type == 'Newly Join') echo 'selected'; ?> value="Newly Join">Newly Join</option>
                        <option <?php if ($row->joining_type == 'Other') echo 'selected'; ?> value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Receive Offer Letter? :</label>
                <div class="col-sm-5">
                    <select class="form-select form-control-sm" name="offer_letter" id="offer_letter" tabindex=4>
                        <option value="">Please select type</option>
                        <option <?php if ($row->offer_letter == '1') echo 'selected'; ?> value="Yes">Yes</option>
                        <option <?php if ($row->offer_letter == '0') echo 'selected'; ?> value="No">No</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
                <div class="col-sm-5">
                    <textarea id="remark" name="remark" rows="2" placeholder="remark" tabindex=5 style="width: 100%;"><?php echo $row->remark; ?></textarea>

                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row->jid; ?>">
                    <button type="submit" tabindex="6" id="add" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>
        </form>

</div>
</div>
</div>
</div>
</div>
<?php endforeach ?>
</div>

<script>
    $(document).ready(function() {
        var i = 1;
        $("#add_row").click(function() {
            $('#addr' + i).html("<td>" + (i + 1) + "</td><td><div class='col-sm-6'><input class='form-control' id='documents" + i + "' name='documents[]' type='file'></div></td><td></td>");
            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
        });

        $("#delete_row").click(function() {
            if (i > 1) {
                $("#addr" + (i - 1)).html('');
                i--;
            }
        });

    });
    $("#tab_logic").on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

    function calculate_total_days() {}
</script>