<div class="card-body">
    <?php foreach ($records as $row) : ?>
        <form onsubmit="return check_duplicate_exist();" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_emp_regignation_corner" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <?php foreach ($user_records as $s) {
                        if ($row->employee_id == $s->user_id) { ?>
                            <input type='text' class="form-control form-control-sm bg-soft-gray" id="employee_id" name="employee_id" value="<?php echo $s->user_name; ?>" tabindex="1" readonly />
                            <input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
                    <?php

                        }
                    } ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Resignation Code:</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <input tabindex="1" type="text" name="ra_code" id="ra_code" class="form-control bg-soft-gray" value="<?php echo $row->resign_code; ?>" readonly>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Resignation Date:</label>
                <div class="col-sm-5">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="resignation_date" name="resignation_date" value="<?php echo date('d-m-Y', strtotime($row->resignation_date) ?? '') ?>" tabindex=2>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Effective Last Working Date:</label>
                <div class="col-sm-5">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="last_working_date" name="last_working_date" value="<?php echo date('d-m-Y', strtotime($row->last_working_date) ?? '') ?>" tabindex="3">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Total Notice Period Days:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm" tabindex="4" id="notice_days" name="notice_days" value="<?php echo $row->notice_days; ?>" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Resignation Reasons</label>
                <div class="col-sm-5">
                    <textarea id="reason" name="reason" rows="2" placeholder="Resignation Reasons" style="width: 100%;" tabindex="5"><?php echo $row->reason; ?></textarea>
                </div>
            </div>
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
                                    <a id='delete_row' title="Delete" class="btn btn-sm bg-blue"><span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                            <?php
                      if ($file_records) {
                         $x = 1; $i = 1;
                         foreach ($file_records as $k): ?>
                        <tr id="doc_row_<?php echo $k->doc_id; ?>">
                           <td><?php echo $i++; ?></td>
                           <td><a href="<?php echo base_url('public/uploded_documents/' . $k->document_path); ?>" download>File <?php echo $x++; ?></a></td>
                           <td><?php echo $k->document_name; ?></td>
                           <td>
                                 <button type="button" class="btn btn-sm bg-blue" onclick="deleteDocument(<?php echo $k->doc_id; ?>)"><span class="fa fa-trash"></button>
                           </td>
                         </tr>
                   <?php endforeach; } ?>
                            <tr id='addr1'></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row->resig_id; ?>">
                    <button type="submit" tabindex="7" id="edit" class="btn btn-primary m-b-0">Submit</button>
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
   $(document).ready(function () {
    var i = 1;
    $("#add_row").click(function () {
        $('#addr' + i).html(
            "<td>" + (i + 1) + "</td>" +
            "<td><input class='form-control form-control-sm' name='documents_res[]' type='file'></td>" +
            "<td>" +
            "<select class='form-select form-control-sm' name='document_types[]'>" +
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
            "</td>" +
            "<td><button type='button' class='btn btn-sm bg-blue remove_row'><span class='fa fa-trash'></span></button></td>"
        );
        $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
    });

     // Confirmation before removing row
    $(document).on('click', '.remove_row', function () {
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