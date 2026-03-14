<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_checklist_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
        <?php 
			$emirate_number = '';
			if(!empty($emirates)){
			$emirate = $emirates[0];
			$emirate_number = $emirate->document_number;
			}
			$passport_document_number = '';
			if(!empty($passport)){
			$passport_details = $passport[0];
			$passport_document_number = $passport_details->document_number;
			}?>
    <div class="row mb-3">
    <div class="col-md-4">
      <label class="form-label">Name:</label>
      <select class="form-control form-control-sm select2" id="user_id" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" >
          <option value="">Select User</option>
          <?php foreach ($user_records as $user) { ?>
              <option <?php if($record->user_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Interview Date:</label>
      <input type="hidden" name="check_id" id="check_id" value="<?php echo $record->check_id;?>"/>
      <input type="text" class="form-control" id="interview_date" name="interview_date" value="<?php echo $record->interview_date;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Emp.CODE:</label>
      <input type="text" class="form-control" id="user_code" name="user_code" value="<?php echo $record->user_code;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Phone Number:</label>
      <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $record->contact_no;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Designation:</label>
      <select class="form-control form-control-sm select2" name="desig_id" id="desig_id" readonly>
          <option value="">Select Designation</option>
          <?php foreach ($desig_list as $desig) { ?>
              <option <?php if($record->desig_id == $desig->did) echo "selected";?> value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">DOB:</label>
      <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $record->bdate;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Department:</label>
      <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" readonly>
          <option value="">Select Department</option>
          <?php foreach ($dept_list as $dept) { ?>
              <option <?php if($record->dept_id == $dept->dept_id) echo "selected";?> value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Passport No:</label>
      <input type="text" class="form-control" name="passport_no" id="passport_no" value="<?php echo $passport_document_number;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">DOJ:</label>
      <input type="date" class="form-control" id="doj" name="doj" value="<?php echo $record->joining_date;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">EID:</label>
      <input type="text" class="form-control" id="eid" name="eid" value="<?php echo $emirate_number;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">Email ID:</label>
      <input type="email" class="form-control" name="email" id="email" value="<?php echo $record->email_id;?>" readonly>
    </div>
    <div class="col-md-4">
      <label class="form-label">HOD:</label>
      <select class="form-control form-control-sm select2" name="hod" id="hod" readonly>
          <option value="">Select User</option>
          <?php foreach ($user_records as $user) { ?>
              <option <?php if($record->reporting_mngr == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
          <?php } ?>
      </select>
    </div>
    <div class="col-md-4">
          <label for="checklist_file_upload" class="form-label">Upload Signed Checklist Form </label>
          <input type="file" name="checklist_file_upload" accept="image/*,application/pdf">
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
      <tbody><?php //print_r($record)?>
        <!-- Repeat this block for each item -->
        <!-- PHP or server-side logic can loop this -->
        <tr>
          <td>1</td>
          <td class="text-start">Application Form</td>
          <td><input type="radio" name="checklist1" value="yes" <?= ($record->application_form == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist1" value="no" <?= ($record->application_form == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>2</td><td class="text-start">Interview Assessment Form</td>
          <td><input type="radio" name="checklist2" value="yes" <?= ($record->interview_form == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist2" value="no" <?= ($record->interview_form == 'no') ? 'checked' : '' ?>></td>
      </tr>
        <tr>
          <td>3</td><td class="text-start">Joining Form</td>
          <td><input type="radio" name="checklist3" value="yes" <?= ($record->joining_form == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist3" value="no" <?= ($record->joining_form == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>4</td><td class="text-start">Curriculum Vitae</td>
          <td><input type="radio" name="checklist4" value="yes" <?= ($record->cv == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist4" value="no" <?= ($record->cv == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>5</td><td class="text-start">Passport Copy</td>
          <td><input type="radio" name="checklist5" value="yes" <?= ($record->passport_copy == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist5" value="no" <?= ($record->passport_copy == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>6</td><td class="text-start">Photo Copy</td>
          <td><input type="radio" name="checklist6" value="yes" <?= ($record->photo_copy == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist6" value="no" <?= ($record->photo_copy == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>7</td><td class="text-start">Offer Letter</td>
          <td><input type="radio" name="checklist7" value="yes" <?= ($record->offer_letter == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist7" value="no" <?= ($record->offer_letter == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>8</td><td class="text-start">Contract Form</td>
          <td><input type="radio" name="checklist8" value="yes" <?= ($record->contract_form == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist8" value="no" <?= ($record->contract_form == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>9</td><td class="text-start">Insurance Form</td>
          <td><input type="radio" name="checklist9" value="yes" <?= ($record->insurance_form == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist9" value="no" <?= ($record->insurance_form == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>10</td><td class="text-start">Labor Payment Form</td>
          <td><input type="radio" name="checklist10" value="yes" <?= ($record->labor_payment_form == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist10" value="no" <?= ($record->labor_payment_form == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>11</td><td class="text-start">Medical Fit Certificate</td>
          <td><input type="radio" name="checklist11" value="yes" <?= ($record->medical_fit_certificate == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist11" value="no" <?= ($record->medical_fit_certificate == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>12</td><td class="text-start">Emirates ID</td>
          <td><input type="radio" name="checklist12" value="yes" <?= ($record->emirates_id == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist12" value="no" <?= ($record->emirates_id == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>13</td><td class="text-start">Visa Copy</td>
          <td><input type="radio" name="checklist13" value="yes" <?= ($record->visa_copy == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist13" value="no" <?= ($record->visa_copy == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>14</td><td class="text-start">ILOE Insurance</td>
          <td><input type="radio" name="checklist14" value="yes" <?= ($record->iloe_insurance == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist14" value="no" <?= ($record->iloe_insurance == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>15</td><td class="text-start">Labor Card</td>
          <td><input type="radio" name="checklist15" value="yes" <?= ($record->labor_card == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist15" value="no" <?= ($record->labor_card == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>16</td><td class="text-start">Degree Certificate with Attestation</td>
          <td><input type="radio" name="checklist16" value="yes" <?= ($record->degree_certificate == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist16" value="no" <?= ($record->degree_certificate == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>17</td><td class="text-start">Induction</td>
          <td><input type="radio" name="checklist17" value="yes" <?= ($record->induction == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist17" value="no" <?= ($record->induction == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>18</td><td class="text-start">Job Description</td>
          <td><input type="radio" name="checklist18" value="yes" <?= ($record->job_description == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist18" value="no" <?= ($record->job_description == 'no') ? 'checked' : '' ?>></td>
        </tr>
        <tr>
          <td>19</td><td class="text-start">Driving License</td>
          <td><input type="radio" name="checklist19" value="yes" <?= ($record->driving_license == 'yes') ? 'checked' : '' ?>></td>
          <td><input type="radio" name="checklist19" value="no" <?= ($record->driving_license == 'no') ? 'checked' : '' ?>></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-4">
    
    <button type="submit" class="btn btn-primary w-auto">Update</button>
  </div>
        
    </form>
</div>
<script>

$(document).ready(function() {

  // Initialize Select2
  $('#hod').select2();
  $('#dept_id').select2();
  $('#desig_id').select2();

  // Lock it by disabling
  $('#dept_id').prop('disabled', true);
  $('#dept_id').trigger('change.select2');

  // Lock it by disabling
  $('#hod').prop('disabled', true);
  $('#hod').trigger('change.select2');

  // Lock it by disabling
  $('#desig_id').prop('disabled', true);
  $('#desig_id').trigger('change.select2');


  // // Set it to readonly by preventing opening
  // let readonly = true;
  // $('#hod').on('select2:opening', function(e) {
  //   if (readonly) e.preventDefault();
  // });

  // // Set it to readonly by preventing opening
  // let readonly = true;
  // $('#dept_id').on('select2:opening', function(e) {
  //   if (readonly) e.preventDefault();
  // });

  // // Set it to readonly by preventing opening
  // let readonly = true;
  // $('#desig_id').on('select2:opening', function(e) {
  //   if (readonly) e.preventDefault();
  // });

});
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