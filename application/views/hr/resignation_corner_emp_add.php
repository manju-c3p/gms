<div class="card-body">
    <form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_emp_regignation_corner_data" autocomplete="off" enctype="multipart/form-data">


        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:<span style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <?php
                // Get the current session user's ID and name
                $current_user_name = '';
                $current_user_id = $this->session->userdata('user_id');
                

                // Find the current user's name from the $user_records array
                foreach ($user_records as $s) {
                    if ($s->user_id == $current_user_id) {
                        $current_user_name = $s->user_name;
                        break;
                    }
                }
                ?>
                <input type="text" class="form-control form-control-sm bg-soft-gray" id="employee_name" name="employee_name" value="<?php echo $current_user_name; ?>" readonly>
                <input type="hidden" id="employee_id" name="employee_id" value="<?php echo $current_user_id; ?>">
            </div>
        </div>

        <!-- 
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
        </div> -->

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Resignation Date:<span style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="resignation_date" name="resignation_date" value="<?php echo date('d-m-Y') ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Effective Last Working Date:<span style="color: red;">*</span></label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="last_working_date" name="last_working_date" value="<?php echo date('d-m-Y') ?>" tabindex="3" required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Total Notice Period Days: <span style="color: red;">*</span></label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm" id="notice_days" name="notice_days" tabindex="4" type="text" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Resignation Reasons <span style="color: red;">*</span></label>
            <div class="col-sm-5">
                <textarea id="reason" tabindex="5" name="reason" rows="2" placeholder="Resignation Reasons" style="width: 100%;" required></textarea>
            </div>
        </div>
        <!-- <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Select Document</label>
            <div class="col-sm-3">
                <select class="form-select form-control-sm" name="documents" id="documents" type="file">
                    <option value="" selected disabled>Please select document type</option>
                    <option value="Resignation Letter">Resignation Letter</option>
                    <option value="Resignation Form">Resignation Form</option>
                    <option value="MOHRE Cancellation Paper">MOHRE Cancellation Paper</option>
                    <option value="Clearance Paper">Clearance Paper</option>
                    <option value="Final Settlement Letter">Final Settlement Letter</option>
                    <option value="Labor Cancellation">Labor Cancellation</option>
                    <option value="Visa Cancellation">Visa Cancellation</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div> -->
        <!-- <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Reason :</label>
            <div class="col-sm-5">
                <textarea id="reason" name="reason" rows="2" placeholder="Specify reason for leave" style="width: 100%;"></textarea>
            </div>
        </div> -->

        <!-- <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Joining Date From Last Leave:</label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="last_date" name="last_date" value="<?php echo date('d-m-Y') ?>" tabindex=14>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div> -->
        <!-- <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Charge Handed To :</label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <select tabindex="1" class="form-select form-control-sm select2" id="replcement" name="replcement">
                    <option value="">Select</option>
                    <?php foreach ($user_records as $s) { ?>
                        <option <?php if ($this->session->userdata('user_id') == $s->user_id) echo 'selected'; ?> value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div> -->

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg","png","doc","pdf"):</label>
            <div class="col-sm-8">
                <table class="table table-bordered table-hover" id="tab_logic">
                    <tbody>
                        <tr id='addr0'>
                            <td>1</td>

                            <td>
                                <div class="col-sm-8">
                                    <input class="form-select form-control-sm" id="documents_res" name="documents_res[]" tabindex="6" type="file">
                                </div>
                            </td>


                            <td>
                                <div class="form-group row">

                                    <div class="col-sm-10">
                                        <select class="form-select form-control-sm" name="document_types[]" id="document_types">
                                            <option value="" selected disabled>Please select document type</option>
                                            <option value="Resignation Letter">Resignation Letter</option>
                                            <option value="Resignation Form">Resignation Form</option>
                                            <option value="MOHRE Cancellation Paper">MOHRE Cancellation Paper</option>
                                            <option value="Clearance Paper">Clearance Paper</option>
                                            <option value="Final Settlement Letter">Final Settlement Letter</option>
                                            <option value="Labor Cancellation">Labor Cancellation</option>
                                            <option value="Visa Cancellation">Visa Cancellation</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </td>

                           <td>
                           <a id="add_row" title="Add" class="btn btn-sm bg-blue"><span class="fa fa-plus"></span></a>
                          </td>
                          <td>
                            <button type="button" class="btn btn-sm bg-blue remove_row"><span class="fa fa-trash"></span></button>
                           </td>

                        </tr>
                        <tr id='addr1'></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="7" id="add" class="btn btn-primary m-b-0">Submit</button>
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
        // Add new row
    $("#add_row").click(function() {
        $('#addr' + i).html(
            "<td>" + (i + 1) + "</td>" +
            "<td><div class='col-sm-8'><input class='form-control' id='documents_res" + i + "' name='documents_res[]' type='file'></div></td>" +
            "<td><div class='col-sm-10'>" +
                "<select class='form-select form-control-sm' name='document_types[]' id='document_types'>" +
                "<option value='' selected disabled>Please select document type</option>" +
                "<option value='Resignation Letter'>Resignation Letter</option>" +
                "<option value='Resignation Form'>Resignation Form</option>" +
                "<option value='MOHRE Cancellation Paper'>MOHRE Cancellation Paper</option>" +
                "<option value='Clearance Paper'>Clearance Paper</option>" +
                "<option value='Final Settlement Letter'>Final Settlement Letter</option>" +
                "<option value='Labor Cancellation'>Labor Cancellation</option>" +
                "<option value='Visa Cancellation'>Visa Cancellation</option>" +
                "<option value='Other'>Other</option>" +
                "</select>" +
            "</div></td>" +
            "<td><button type='button' class='btn btn-sm bg-blue remove_row' title='Delete row'><span class='fa fa-trash'></span></button></td>"
        );
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
    });

      // Row-wise delete on clicking trash icon
    $(document).on('click', '.remove_row', function() {
        if (confirm("Are you sure you want to delete this row?")) {
            $(this).closest('tr').remove();

            // Optional: Re-number rows after deletion
            $('#tab_logic tbody tr').each(function(index) {
                $(this).find('td:first').html(index + 1);
            });

            // Decrement row counter to keep adding rows correctly
            i = $('#tab_logic tbody tr').length - 1; // exclude last empty row
        }
    });

    // Initially hide the last empty row (addr1)
    $('#addr1').html('');
});

    function calculate_total_days() {
        var startDateStr = document.getElementById('start_date').value;
        var endDateStr = document.getElementById('end_date').value;

        // Parse start date and end date in d-m-Y format
        var startDateArr = startDateStr.split('-');
        var endDateArr = endDateStr.split('-');

        var startDate = new Date(startDateArr[2], startDateArr[1] - 1, startDateArr[0]);
        var endDate = new Date(endDateArr[2], endDateArr[1] - 1, endDateArr[0]);

        const time = Math.abs(endDate - startDate);

        const days = Math.ceil(time / (1000 * 60 * 60 * 24));

        document.getElementById("total_date").value = days;
    }

    // Call calculate_total_days() when there is a change in start_date or end_date fields
    document.getElementById('start_date').addEventListener('input', calculate_total_days);
    document.getElementById('end_date').addEventListener('input', calculate_total_days);
</script>