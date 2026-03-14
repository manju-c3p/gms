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
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_vehicles_details" id="addform"
        autocomplete="off" enctype="multipart/form-data">


        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Driver Name :<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <select class="form-control form-control-sm select2" name="driver_name" id="driver_name" >
                    <option value="">Select Driver</option>
                    <?php foreach ($user_records as $user) { ?>
                            <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name.' '.$user->last_name; ?></option>
                        <?php } ?>
                </select>
                <!-- <input tabindex="2" type="text" name="driver_name" id="driver_name" placeholder="driver name"
                    class="form-control form-control-sm " required> -->
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Add Vehicle Type:<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <select tabindex="1" name="vehicle_type" id="vehicle_type"
                    class="form-control form-control-sm select2" required>
                    <option value="" disabled selected>Select Vehicle Type</option>
                    <option value="vehicle_assets">Vehicle Assets</option>
                    <option value="vehicle_maintenance">Vehicle Maintenance</option>
                    <option value="Car">Car</option>
                    <option value="Van">Van</option>
                    <option value="Pick up">Pick up</option>
                </select>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Vehicle Name :<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input tabindex="1" type="text" name="vehicle_name" id="vehicle_name" placeholder="enter Name"
                    class="form-control form-control-sm " required>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Trafic Plate Number :<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input tabindex="2" type="text" name="vehicle_no" id="vehicle_no" placeholder="enter number"
                    class="form-control form-control-sm " required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Mulkiya Expiry Date:<span
                    style="color: red;">*</span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="vl_exp" name="vl_exp"
                        value="<?php echo date('d-m-Y') ?>" tabindex=3 required>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">License Expiry Reminder :</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <select tabindex="4" class="form-select form-control-sm " id="exp_reminder" name="exp_reminder">
                    <option value="">Select</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
        <!-- <h6>Insurance Details</h6><br> -->

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Vehicle Insurance Issue Date</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="insurance_date"
                        name="insurance_date" value="<?php echo date('d-m-Y') ?>" required tabindex=24>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Vehicle Insurance Expiry Date</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <div class="input-group date datepicker1">
                    <input type="text" class="form-control form-control-sm datepicker1" id="insurance_expdate"
                        name="insurance_expdate" value="<?php echo date('d-m-Y') ?>" required tabindex=25>
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Insurance No.</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input tabindex="47" type="text" name="insurance_no" id="insurance_no"
                    class="form-control form-control-sm ">
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Remark : </label>
            <div class="col-sm-3">
                <textarea id="remark" tabindex="5" name="remark" rows="1" placeholder="remark"
                    style="width: 100%;"></textarea>
            </div>
        </div>



        <div class="form-group row">


            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Upload Document :</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input tabindex="6" type="file" name="file_doc" id="file_doc" class="form-control-sm">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="7" id='add' class="btn btn-primary m-b-0">submit</button>
            </div>
        </div>
    </form>
</div>
</div>