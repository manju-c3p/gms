<div class="card-body">
    <style>
        .form-section{
            margin-top:2%;
        }
    </style>
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_vehicle_handover_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        <div class="container my-4">    
            <div class="row form-section">
                <div class="col-md-3">
                    <label class="form-label">Driver Name:<span style="color:red;">*</span></label>
                    <select class="form-control form-control-sm select2" name="user_id" id="user_id" required>
                        <option value="">Select Driver</option>
                        <?php foreach ($user_records as $driver) { ?>
                                <option value="<?php echo $driver->user_id; ?>"><?php echo $driver->user_name.' '.$driver->middle_name.' '.$driver->last_name; ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">License Plate:<span style="color:red;">*</span></label>
                  <select class="form-control form-control-sm select2" name="licence_plate" id="licence_plate" required>
    <option value="">Select Number Plate</option>
    <?php foreach ($drivers as $driver) { ?>
        <option value="<?= $driver->traffic_no ?>">
            <?= $driver->traffic_no . ' - ' . $driver->vehicle_name ?>
        </option>
    <?php } ?>
</select>

                </div>  
                
                <div class="col-md-3">
                    <label class="form-label">Vehicle Model:<span style="color:red;">*</span></label>
                    <select class="form-control form-control-sm select2" name="vehicle_model" id="vehicle_model" required>
                        <option value="">Select Vehicle Model</option>
                        <?php foreach ($drivers as $driver) { ?>
                                <option value="<?php echo $driver->vehicle_name; ?>"><?php echo $driver->vehicle_name; ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date of Handover:<span style="color:red;">*</span></label>
                    <input type="date" class="form-control" name="handover_date" value="<?php echo date("Y-m-d")?>" required>
                </div>
            </div>
                        
            <div class="row form-section">
                <h6>Vehicle Condition (Inspection Notes):</h6> <br/>   
                <div class="col-md-6">
                    <label class="form-label">Interior:</label>
                    <textarea class="form-control" rows="2" name="interior"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Exterior:</label>
                    <textarea class="form-control" rows="2" name="exterior"></textarea>
                </div>
            </div>
            
            <div class="row form-section">
                <div class="col-md-6">
                    <label class="form-label">Pre-existing Damages (if any):</label>
                    <textarea class="form-control" rows="2" name="pre_damages"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Additional Comments:</label>
                    <textarea class="form-control" rows="2" name="comments"></textarea>
                </div>
            </div>
                                       
            <div class="form-section">
                <h6>Documents Handover:</h6> 
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="vehicle_key" type="checkbox" checked >
                    <label class="form-check-label">Vehicle Key</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="mulkiya" type="checkbox" checked >
                    <label class="form-check-label">Mulkiya</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="vehicle_logbook" type="checkbox" checked >
                    <label class="form-check-label">Vehicle logbook</label>
                </div>
            </div>
            <br/>           
           
            <div class="row">
                <div class="col-md-4">
                    <label>Inspected By:<span style="color:red;">*</span></label>
                    <select class="form-control form-control-sm select2" name="inspected_by" id="inspected_by" required>
                        <option value="">Select Inspector</option>
                        <?php foreach ($user_records as $record) { ?>
                                <option value="<?php echo $record->user_id; ?>"><?php echo $record->user_name.' '.$record->middle_name.''.$record->last_name; ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>HR & Admin:</label>
                    <select class="form-control form-control-sm select2" name="hr_admin" id="hr_admin" >
                        <option value="">Select HR / Admin</option>
                        <?php foreach ($user_records as $record) { ?>
                                <option value="<?php echo $record->user_id; ?>"><?php echo $record->user_name.' '.$record->middle_name.''.$record->last_name; ?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>HR & Admin:</label>
                    <select class="form-control form-control-sm select2" name="hr_approval" id="hr_approval" >
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                        <option value="2">Not Approved</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-4">Submit Request</button>
            
        </div>
    </form>
</div>

