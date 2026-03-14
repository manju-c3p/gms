<div class="card-body">
    <form onsubmit="return" id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_holiday_data"
        autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Holiday Name:<span
                    style="color: red;">*</span></label>
            <div class="col-sm-5">
                <abbr title="Enter Holiday Name"> <input type="text" class="form-control form-control-sm"
                        id="holiday_name" name="holiday_name" tabindex="4" required></abbr>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
                Date:<span style="color: red;">*</span>
            </label>
            <div class="col-sm-5">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="holiday_date"
                        name="holiday_date" value="<?php echo date('d-m-Y'); ?>" tabindex=2 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
               
                </div>
                <label id="date_exits" style="color: red;"></label>
            </div>
            
        </div>



        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Holiday Description</label>
            <div class="col-sm-5">
                <textarea id="holl_desc" tabindex="5" name="holl_desc" rows="2" placeholder="holiday description"
                    style="width: 100%;" required></textarea>
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

<script>

    $(document).ready(function () {
        $('#holiday_date').on('change', function () {
            check_dept_exist();
        });

        function check_dept_exist() {
            var atype = $('#holiday_date').val(); // Get the date in DD-MM-YYYY format
            var dateParts = atype.split('-');
            if (dateParts.length === 3) {
                var formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0]; // YYYY-MM-DD


                $.ajax({
                    url: "<?php echo site_url('Ajax/check_duplicate_exist5'); ?>",
                    type: 'POST',
                    data: {
                        table_name: 'holiday_master',
                        column_name1: 'h_date',
                        post_id1: formattedDate // Send the date in the correct format
                    },
                    success: function (msg) {

                        if (msg != 0) {
                            $('#date_exits').html("This holiday date already exists. Please choose another date.");
                           // $('#holiday_date').val(''); // Clear the input
                        } else {
                            $('#date_exits').html("");
                        }
                    },
                    error: function () {
                        $('#date_exits').html("An error occurred. Please try again.");
                    }
                });
            } else {
                $('#date_exits').html("Invalid date format. Please use DD-MM-YYYY.");
            }
        }
    });
</script>