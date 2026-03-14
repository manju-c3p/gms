<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_asset_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        
    <div class="row mb-3">
        <div class="col-md-6">
          <label for="user_id" class="form-label">Name <span style="color: red;">* </span></label>
          <select class="form-control form-control-sm select2" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" required>
                <option value="">Select User</option>
                <?php foreach ($user_records as $user) { ?>
                    <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6">
          <label for="user_code" class="form-label">Employee Code <span style="color: red;">* </span></label>
          <input type="text" class="form-control" name="user_code" id="user_code" value="" readonly>
        </div>
        <div class="col-md-6 mt-3">
            <label for="desig_id" class="form-label">Designation <span style="color: red;">* </span></label>
            <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" required>
                <option value="">Select Designation</option>
                <?php foreach ($desig_list as $desig) { ?>
                    <option value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-6 mt-3">
          <label for="dept_id" class="form-label">Department <span style="color: red;">* </span></label>
          <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" required>
                <option value="">Select Department</option>
                <?php foreach ($dept_list as $dept) { ?>
                    <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                <?php } ?>
            </select>
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
            <td><input type="text" name="sim_desc" class="form-control"></td>
            <td><input type="text" name="sim_num" class="form-control"></td>
            <td><input type="date" name="sim_issue" class="form-control"></td>
            <td><input type="date" name="sim_return" class="form-control"></td>
          </tr>
          <tr>
            <td>Laptop</td>
            <td><input type="text" name="lap_desc" class="form-control"></td>
            <td><input type="text" name="lap_num" class="form-control"></td>
            <td><input type="date" name="lap_issue" class="form-control"></td>
            <td><input type="date" name="lap_return" class="form-control"></td>
          </tr>
          <tr>
            <td>Mobile</td>
            <td><input type="text" name="mob_desc" class="form-control"></td>
            <td><input type="text" name="mob_num" class="form-control"></td>
            <td><input type="date" name="mob_issue" class="form-control"></td>
            <td><input type="date" name="mob_return" class="form-control"></td>
          </tr>
          <tr>
            <td>Vehicle</td>
            <td><input type="text" name="veh_desc" class="form-control"></td>
            <td><input type="text" name="veh_num" class="form-control"></td>
            <td><input type="date" name="veh_issue" class="form-control"></td>
            <td><input type="date" name="veh_return" class="form-control"></td>
          </tr>
          <tr>
            <td>Other</td>
            <td><input type="text" name="oth_desc" class="form-control"></td>
            <td><input type="text" name="oth_num" class="form-control"></td>
            <td><input type="date" name="oth_issue" class="form-control"></td>
            <td><input type="date" name="oth_return" class="form-control"></td>
          </tr>
        </tbody>
      </table>

          

      <button type="submit" class="btn btn-primary">Submit</button>
        
    </form>
</div>
<script>
    function getEmployeeDetailsAjax(user_id){
        
		if (user_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Hr/get_user_details/"+user_id,
				data: { user_id: user_id },
				success: function (msg) {
					document.getElementById('user_code').value = msg.user_code;
          $('#desig_id').select2();
          $('#desig_id').val(msg.desig_id).trigger('change');
          $('#dept_id').select2();
          $('#dept_id').val(msg.dept_id).trigger('change');
          
				}
			});
		}
    }
</script>
