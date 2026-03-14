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
    <?php foreach ($records as $row): ?>
        <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_vehicles" id="addform"
            autocomplete="off" enctype="multipart/form-data">

            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Driver Name:<span
                        style="color: red;">*</span></label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <select class="form-control form-control-sm select2" name="driver_name" id="driver_name" >
                        <option value="">Select Driver</option>
                        <?php foreach ($user_records as $user) { ?>
                                <option <?php if($row->driver_name == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name.' '.$user->last_name; ?></option>
                            <?php } ?>
                    </select>
                    <!-- <input tabindex="2" type="text" name="driver_name" id="driver_name" placeholder="Driver Name"
                        class="form-control form-control-sm" value="<?php echo htmlspecialchars($row->driver_name); ?>"
                        required> -->
                </div>

                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Edit Vehicle Type:<span
                        style="color: red;">*</span></label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <select tabindex="1" name="vehicle_type" id="vehicle_type"
                        class="form-control form-control-sm select2" required>
                        <option value="" disabled>Select</option>
                        <option <?php if ($row->vehicle_type == 'vehicle_assets')
                            echo 'selected'; ?> value="vehicle_assets">
                            Vehicle Assets</option>
                        <option <?php if ($row->vehicle_type == 'vehicle_maintenance')
                            echo 'selected'; ?>
                            value="vehicle_maintenance">Vehicle Maintenance</option>
                            <option value="Car"
            <?php if ($row->vehicle_type == 'Car') echo 'selected'; ?>>
            Car
        </option>

        <option value="Van"
            <?php if ($row->vehicle_type == 'Van') echo 'selected'; ?>>
            Van
        </option>

        <option value="Pick up"
            <?php if ($row->vehicle_type == 'Pick up') echo 'selected'; ?>>
            Pick up
        </option>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Vehicle Name :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <input tabindex="1" type="text" name="vehicle_name" id="vehicle_name" placeholder="enter Name"
                        class="form-control form-control-sm" value="<?php echo $row->vehicle_name; ?>" readonly>
                </div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Traffic Plate Number :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <input tabindex="2" type="text" name="vehicle_no" id="vehicle_no" placeholder="enter number"
                        class="form-control form-control-sm" value="<?php echo $row->traffic_no; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Mulkiya Expiry Date :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="vl_exp" name="vl_exp"
                            value="<?php echo date('d-m-Y', strtotime($row->license_expdate) ?? ''); ?>" tabindex="3">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">License Expiry Reminder :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <select tabindex="4" class="form-select form-control-sm" id="exp_reminder" name="exp_reminder">
                        <option value="">Select</option>
                        <option <?php if ($row->exp_reminder == 'Yes')
                            echo 'selected'; ?> value="Yes">Yes</option>
                        <option <?php if ($row->exp_reminder == 'No')
                            echo 'selected'; ?> value="No">No</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Vehicle Insurance Issue Date</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="insurance_date"
                            name="insurance_date"
                            value="<?php echo date('d-m-Y', strtotime($row->insurance_date) ?? ''); ?>" required
                            tabindex=24>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Vehicle Insurance Expiry Date</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="insurance_expdate"
                            name="insurance_expdate"
                            value="<?php echo date('d-m-Y', strtotime($row->insurance_expdate) ?? ''); ?>" required
                            tabindex=25>
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Insurance No.</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <input tabindex="47" type="text" name="insurance_no" id="insurance_no"
                        class="form-control form-control-sm " value="<?php echo $row->insurance_no; ?>">
                </div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Remark : </label>
                <div class="col-sm-3">
                    <textarea id="remark" tabindex="5" name="remark" rows="1" placeholder="remark"
                        style="width: 100%;"><?php echo $row->remark; ?></textarea>
                </div>
            </div>
           <div class="form-group row">
    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label text-right">Upload Document:</label>
    <div class="col-xs-12 col-sm-9 col-md-10 col-lg-10">
        <input tabindex="6" type="file" name="file_doc" id="file_doc" class="form-control-sm">

        <?php if (!empty($row->document)) : ?>
            <a href="<?php echo base_url('public/uploded_documents/' . $row->document); ?>" 
               download 
               class="ml-2" 
               target="_blank">
               View Vehicle Document
            </a>
        <?php endif; ?>
    </div>
</div>


            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" name="id" value="<?php echo $row->v_id; ?>">
                    <button type="submit" id="add" tabindex="7" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>
        </form>
    <?php endforeach; ?>
</div>
</div>
</div>