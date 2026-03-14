<div class="card-body">
    <form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_joining_application_data" autocomplete="off" enctype="multipart/form-data">
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
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining date:</label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="joining_date" name="joining_date" value="<?php echo date('d-m-Y') ?>" tabindex=2>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining Type :<span style="color: red;">*</span></label>
            <div class="col-sm-5">
                <select class="form-select form-control-sm" name="joining_type" id="joining_type" tabindex=3 required>
                    <option value="">Please select type</option>
                    <option value="Resuming After Leave">Resuming After Leave</option>
                    <option value="Observation Period ">Observation Period </option>
                    <option value="Newly Join">Newly Join</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>



        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Receive Offer Letter? : <span style="color: red;">*</span></label>
            <div class="col-sm-5">
                <select class="form-select form-control-sm" name="offer_letter" id="offer_letter" tabindex=4 required>
                    <option value="">Please select type</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
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
</div>
</div>
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