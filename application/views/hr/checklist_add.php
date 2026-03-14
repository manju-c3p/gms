<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_checklist_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        
    <div class="row mb-3">
    <div class="col-md-4">
      <label class="form-label">Name:</label>
      <select class="form-control form-control-sm select2" id="user_id" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" >
          <option value="">Select User</option>
          <?php foreach ($user_records as $user) { ?>
              <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Interview Date:</label>
      <input type="text" class="form-control" id="interview_date" name="interview_date" value="" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Emp.CODE:</label>
      <input type="text" class="form-control" id="user_code" name="user_code" value="" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Phone Number:</label>
      <input type="text" class="form-control" id="phone_number" name="phone_number" value="" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Designation:</label>
      <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" >
          <option value="">Select Designation</option>
          <?php foreach ($desig_list as $desig) { ?>
              <option value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">DOB:</label>
      <input type="date" class="form-control" name="dob" id="dob">
    </div>
    <div class="col-md-4">
      <label class="form-label">Department:</label>
      <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" >
          <option value="">Select Department</option>
          <?php foreach ($dept_list as $dept) { ?>
              <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Passport No:</label>
      <input type="text" class="form-control" name="passport_no" id="passport_no">
    </div>
    <div class="col-md-4">
      <label class="form-label">DOJ:</label>
      <input type="date" class="form-control" id="doj" name="doj">
    </div>
    <div class="col-md-4">
      <label class="form-label">EID:</label>
      <input type="text" class="form-control" id="eid" name="eid">
    </div>
    <div class="col-md-4">
      <label class="form-label">Email ID:</label>
      <input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="col-md-4">
      <label class="form-label">HOD:</label>
      <select class="form-control form-control-sm select2" name="hod" id="hod" >
          <option value="">Select User</option>
          <?php foreach ($user_records as $user) { ?>
              <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
          <?php } ?>
      </select>
    </div>
  </div>

  <!-- Checklist Table -->
  <div class="table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead class="table-secondary">
        <tr>
          <th>S No</th>
          <th>Description</th>
          <th>Yes</th>
          <th>No</th>
        </tr>
      </thead>
      <tbody>
        <!-- Repeat this block for each item -->
        <!-- PHP or server-side logic can loop this -->
        <tr>
          <td>1</td>
          <td class="text-start">Application Form</td>
          <td><input type="radio" name="checklist1" value="yes"></td>
          <td><input type="radio" name="checklist1" value="no"></td>
        </tr>
        <tr>
          <td>2</td><td class="text-start">Interview Assessment Form</td>
          <td><input type="radio" name="checklist2" value="yes"></td>
          <td><input type="radio" name="checklist2" value="no"></td>
      </tr>
        <tr>
          <td>3</td><td class="text-start">Joining Form</td>
          <td><input type="radio" name="checklist3" value="yes"></td>
          <td><input type="radio" name="checklist3" value="no"></td>
        </tr>
        <tr>
          <td>4</td><td class="text-start">Curriculum Vitae</td>
          <td><input type="radio" name="checklist4" value="yes"></td>
          <td><input type="radio" name="checklist4" value="no"></td>
        </tr>
        <tr>
          <td>5</td><td class="text-start">Passport Copy</td>
          <td><input type="radio" name="checklist5" value="yes"></td>
          <td><input type="radio" name="checklist5" value="no"></td>
        </tr>
        <tr>
          <td>6</td><td class="text-start">Photo Copy</td>
          <td><input type="radio" name="checklist6" value="yes"></td>
          <td><input type="radio" name="checklist6" value="no"></td>
        </tr>
        <tr>
          <td>7</td><td class="text-start">Offer Letter</td>
          <td><input type="radio" name="checklist7" value="yes"></td>
          <td><input type="radio" name="checklist7" value="no"></td>
        </tr>
        <tr>
          <td>8</td><td class="text-start">Contract Form</td>
          <td><input type="radio" name="checklist8" value="yes"></td>
          <td><input type="radio" name="checklist8" value="no"></td>
        </tr>
        <tr>
          <td>9</td><td class="text-start">Insurance Form</td>
          <td><input type="radio" name="checklist9" value="yes"></td>
          <td><input type="radio" name="checklist9" value="no"></td>
        </tr>
        <tr>
          <td>10</td><td class="text-start">Labor Payment Form</td>
          <td><input type="radio" name="checklist10" value="yes"></td>
          <td><input type="radio" name="checklist10" value="no"></td>
        </tr>
        <tr>
          <td>11</td><td class="text-start">Medical Fit Certificate</td>
          <td><input type="radio" name="checklist11" value="yes"></td>
          <td><input type="radio" name="checklist11" value="no"></td>
        </tr>
        <tr>
          <td>12</td><td class="text-start">Emirates ID</td>
          <td><input type="radio" name="checklist12" value="yes"></td>
          <td><input type="radio" name="checklist12" value="no"></td>
        </tr>
        <tr>
          <td>13</td><td class="text-start">Visa Copy</td>
          <td><input type="radio" name="checklist13" value="yes"></td>
          <td><input type="radio" name="checklist13" value="no"></td>
        </tr>
        <tr>
          <td>14</td><td class="text-start">ILOE Insurance</td>
          <td><input type="radio" name="checklist14" value="yes"></td>
          <td><input type="radio" name="checklist14" value="no"></td>
        </tr>
        <tr>
          <td>15</td><td class="text-start">Labor Card</td>
          <td><input type="radio" name="checklist15" value="yes"></td>
          <td><input type="radio" name="checklist15" value="no"></td>
        </tr>
        <tr>
          <td>16</td><td class="text-start">Degree Certificate with Attestation</td>
          <td><input type="radio" name="checklist16" value="yes"></td>
          <td><input type="radio" name="checklist16" value="no"></td>
        </tr>
        <tr>
          <td>17</td><td class="text-start">Induction</td>
          <td><input type="radio" name="checklist17" value="yes"></td>
          <td><input type="radio" name="checklist17" value="no"></td>
        </tr>
        <tr>
          <td>18</td><td class="text-start">Job Description</td>
          <td><input type="radio" name="checklist18" value="yes"></td>
          <td><input type="radio" name="checklist18" value="no"></td>
        </tr>
        <tr>
          <td>19</td><td class="text-start">Driving License</td>
          <td><input type="radio" name="checklist19" value="yes"></td>
          <td><input type="radio" name="checklist19" value="no"></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-4">
    <button type="submit" class="btn btn-primary w-auto">Submit</button>
  </div>
        
    </form>
</div>
<script>


    function getEmployeeDetailsAjax(user_id){
        
      if (user_id !== '') {
        $.ajax({
          async: false,
          type: "POST",
          url: "<?php echo base_url() ?>index.php/Hr/get_user_details/" + user_id,
          data: { user_id: user_id },
          dataType: "json", // ensure the response is treated as JSON
          success: function (msg) {
            document.getElementById('user_code').value = msg.user_code;
            document.getElementById('interview_date').value = msg.interview_date;
            document.getElementById('phone_number').value = msg.contact_no;
            document.getElementById('dob').value = msg.bdate;
            document.getElementById('passport_no').value = msg.passport_no;
            document.getElementById('doj').value = msg.joining_date;
            document.getElementById('eid').value = msg.emirate_no;
            document.getElementById('email').value = msg.email_id;

            $('#hod').val(msg.reporting_mngr).trigger('change');
            $('#desig_id').val(msg.desig_id).trigger('change');
            $('#dept_id').val(msg.dept_id).trigger('change');
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
          }
        });
      }

    }
		
</script>
