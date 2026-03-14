<div class="card-body">
    <?php foreach ($records as $row): ?>
        <form onsubmit="return check_duplicate_exist();" id="main" method="post"
            action="<?php echo base_url() . 'index.php/'; ?>Hr/update_holiday_data" autocomplete="off"
            enctype="multipart/form-data">



            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Holiday Code:</label>
                <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                    <input tabindex="1" type="text" name="paid_code" id="paid_code" class="form-control bg-soft-gray"
                        value="<?php echo $row->holiday_code; ?>" readonly>

                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Holiday Name:<span
                        style="color: red;">*</span></label>
                <div class="col-sm-5">
                    <abbr title="Enter Holiday Name"> <input type="text" class="form-control  bg-soft-gray"
                            id="holiday_name" name="holiday_name" tabindex="4" value="<?php echo $row->holiday_name; ?>"
                            required></abbr>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date:<span
                        style="color: red;">*</span></label>
                <div class="col-sm-5">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="holiday_date"
                            name="holiday_date" value="<?php echo date('d-m-Y', strtotime($row->h_date) ?? '') ?>"
                            tabindex=2 required>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Holiday Description</label>
                <div class="col-sm-5">
                    <textarea id="holl_desc" tabindex="5" name="holl_desc" rows="2" placeholder="holiday description"
                        style="width: 100%;" required><?php echo $row->holiday_des; ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row->holiday_id; ?>">
                    <button type="submit" tabindex="5" id="edit" class="btn btn-primary m-b-0">Update</button>
                </div>
            </div>
        </form>
    <?php endforeach ?>
</div>
</div>