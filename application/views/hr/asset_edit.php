<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_asset_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        
    <div class="row mb-3">
        <div class="col-md-6">
          <label for="user_id" class="form-label">Name <span style="color: red;">* </span></label>
          <select class="form-control form-control-sm select2" id="user_id" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" required>
                <option value="">Select User</option>
                <?php foreach ($user_records as $user) { ?>
                    <option <?php if($records->user_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
          <label for="user_code" class="form-label">Employee Code <span style="color: red;">* </span></label>
          <input type="text" class="form-control" name="user_code" id="user_code" value="<?php echo $records->user_code; ?>" readonly>
        </div>
        <div class="col-md-6 mt-3">
            <label for="desig_id" class="form-label">Designation <span style="color: red;">* </span></label>
            <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" required>
                <option value="">Select Designation</option>
                <?php foreach ($desig_list as $desig) { ?>
                    <option <?php if($records->desig_id == $desig->did) echo "selected";?> value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6 mt-3">
          <label for="dept_id" class="form-label">Department <span style="color: red;">* </span></label>
          <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" required>
                <option value="">Select Department</option>
                <?php foreach ($dept_list as $dept) { ?>
                    <option <?php if($records->dept_id == $dept->dept_id) echo "selected";?> value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6 mt-3">
          <label for="dept_id" class="form-label">Upload Signed Asset Form <span style="color: red;">* </span></label>
          <input type="file" name="asset_file_upload" accept="image/*,application/pdf">
        </div>
      </div>

      <h5 class="mt-4">Asset Details</h5>
      <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Serial Number/IMEI</th>
            <th>Issued Date</th>
            <th>Return Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>SIM Card</td>
            <td><input type="text" name="sim_desc" class="form-control" value="<?php echo $records->sim_description?>"></td>
            <td><input type="text" name="sim_num" class="form-control" value="<?php echo $records->sim_serial_number?>"></td>
            <td><input type="date" name="sim_issue" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->sim_issued) ?? '') ?>"></td>
            <td><input type="date" name="sim_return" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->sim_return) ?? '') ?>"></td>
          </tr>
          <tr>
            <td>Laptop</td>
            <td><input type="text" name="lap_desc" class="form-control" value="<?php echo $records->laptop_description?>"></td>
            <td><input type="text" name="lap_num" class="form-control" value="<?php echo $records->laptop_serial_number?>"></td>
            <td><input type="date" name="lap_issue" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->laptop_issued) ?? '') ?>"></td>
            <td><input type="date" name="lap_return" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->laptop_return) ?? '') ?>"></td>
          </tr>
          <tr>
            <td>Mobile</td>
            <td><input type="text" name="mob_desc" class="form-control" value="<?php echo $records->mobile_description?>"></td>
            <td><input type="text" name="mob_num" class="form-control" value="<?php echo $records->mobile_serial_number?>"></td>
            <td><input type="date" name="mob_issue" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->mobile_issued) ?? '') ?>"></td>
            <td><input type="date" name="mob_return" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->mobile_return) ?? '') ?>"></td>
          </tr>
          <tr>
            <td>Vehicle</td>
            <td><input type="text" name="veh_desc" class="form-control" value="<?php echo $records->vehicle_description?>"></td>
            <td><input type="text" name="veh_num" class="form-control" value="<?php echo $records->vehicle_serial_number?>"></td>
            <td><input type="date" name="veh_issue" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->vehicle_issued) ?? '') ?>"></td>
            <td><input type="date" name="veh_return" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->vehicle_return) ?? '') ?>"></td>
          </tr>
          <tr>
            <td>Other</td>
            <td><input type="text" name="oth_desc" class="form-control" value="<?php echo $records->other_description?>"></td>
            <td><input type="text" name="oth_num" class="form-control" value="<?php echo $records->other_serial_number?>"></td>
            <td><input type="date" name="oth_issue" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->other_issued) ?? '') ?>"></td>
            <td><input type="date" name="oth_return" class="form-control" value="<?php echo date('Y-m-d', strtotime($records->other_return) ?? '') ?>"></td>
          </tr>
        </tbody>
      </table>

      
      <div class="row mb-5">
            <!-- Signature Dropdown - Half width -->
            <div class="col-md-2">
                <label class="form-label">Employee Signature</label>
                <select class="form-control form-control-sm select2" name="emp_signature" id="emp_signature" required>
                <option <?php if($records->emp_signature == 'no') echo "selected";?> value="no">No</option>
                <option <?php if($records->emp_signature == 'yes') echo "selected";?> value="yes">Yes</option>
                </select>
            </div>

            <!-- Date Field - Half width -->
            <div class="col-md-2">
                <label class="form-label">Date</label>
                <input type="date" class="form-control form-control-sm" name="emp_signature_date" id="emp_signature_date" value="<?php echo date('Y-m-d', strtotime($records->emp_signature_date) ?? '') ?>">
            </div>
            <div class="col-md-2">
            <label class="form-label">HOD Signature</label>
            <select class="form-control form-control-sm select2" name="hod_signature" id="hod_signature" required>
                    <option <?php if($records->	dept_head_signature == 'no') echo "selected";?> value="no">No</option>
                    <option <?php if($records->	dept_head_signature == 'yes') echo "selected";?> value="yes">Yes</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date</label>
                <input type="date" class="form-control form-control-sm" name="hod_signature_date" id="hod_signature_date" value="<?php echo date('Y-m-d', strtotime($records->dept_head_signature_date	) ?? '') ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">HR Rep Signature</label>
                <select class="form-control form-control-sm select2" name="hr_signature" id="hr_signature" required>
                    <option <?php if($records->	hr_signature == 'no') echo "selected";?> value="no">No</option>
                    <option <?php if($records->	hr_signature == 'yes') echo "selected";?> value="yes">Yes</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date</label>
                <input type="date" class="form-control form-control-sm" name="hr_signature_date" id="hr_signature_date" value="<?php echo date('Y-m-d', strtotime($records->hr_signature_date) ?? '') ?>">
            </div>
      </div>
      <div class="d-flex justify-content-center align-items-center" >
        <button type="submit" class="btn btn-primary w-auto">Update</button>
        <input type="hidden" name="asset_id" id="asset_id" value="<?php echo $records->asset_id?>"/>
      </div>
        
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#user_id').select2();
        setUserName(); 
    });
    function setUserName(){
        var selectedData = $('#user_id').select2('data');
        document.getElementById('emp_ack_name').textContent  = selectedData[0].text;
    }

    function getEmployeeDetailsAjax(user_id){
        
		if (user_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Hr/get_user_details/"+user_id,
				data: { user_id: user_id },
				success: function (msg) {
					document.getElementById('user_code').value = msg.user_code;
          var name = '';
          if(msg.user_name != null && msg.middle_name != null && msg.last_name != null)
              var name =  msg.user_name+' '+msg.middle_name+' '+msg.last_name;
          else if(msg.user_name != null && msg.middle_name != null && msg.last_name == null)
              var name =  msg.user_name+' '+msg.middle_name;
          else if(msg.user_name != null && msg.middle_name == null && msg.last_name == null)
              var name =  msg.user_name;
          $('#desig_id').select2();
          $('#desig_id').val(msg.desig_id).trigger('change');
          $('#dept_id').select2();
          $('#dept_id').val(msg.dept_id).trigger('change');
          document.getElementById('emp_ack_name').textContent  = name;
          
				}
			});
		}
    }
</script>