<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/update_review_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
    <div class="container mt-4"> 
        <!-- Review Info -->
        <div class="form-row form-section">
          <div class="row">
              <div class="col-lg-3 mt-3">
                <label>Review Period - From: <span style="color:red;">*</span></label>
                <select class="form-control" name="from_month" required>
                  <option <?php if($record->review_period_from == " ") echo "selected";?> value="">-- Select Month --</option>
                  <option <?php if($record->review_period_from == "1") echo "selected";?> value="1">January</option>
                  <option <?php if($record->review_period_from == "2") echo "selected";?> value="2">February</option>
                  <option <?php if($record->review_period_from == "3") echo "selected";?> value="3">March</option>
                  <option <?php if($record->review_period_from == "4") echo "selected";?> value="4">April</option>
                  <option <?php if($record->review_period_from == "5") echo "selected";?> value="5">May</option>
                  <option <?php if($record->review_period_from == "6") echo "selected";?> value="6">June</option>
                  <option <?php if($record->review_period_from == "7") echo "selected";?> value="7">July</option>
                  <option <?php if($record->review_period_from == "8") echo "selected";?> value="8">August</option>
                  <option <?php if($record->review_period_from == "9") echo "selected";?> value="9">September</option>
                  <option <?php if($record->review_period_from == "10") echo "selected";?> value="10">October</option>
                  <option <?php if($record->review_period_from == "11") echo "selected";?> value="11">November</option>
                  <option <?php if($record->review_period_from == "12") echo "selected";?> value="12">December</option>
                </select>

              </div>
              <div class="col-lg-3 mt-3">
                <label> To: <span style="color:red;">*</span></label>
                <select class="form-control" name="to_month" required>
                  <option <?php if($record->review_period_to == " ") echo "selected";?> value="">-- Select Month --</option>
                  <option <?php if($record->review_period_to == "1") echo "selected";?> value="1">January</option>
                  <option <?php if($record->review_period_to == "2") echo "selected";?> value="2">February</option>
                  <option <?php if($record->review_period_to == "3") echo "selected";?> value="3">March</option>
                  <option <?php if($record->review_period_to == "4") echo "selected";?> value="4">April</option>
                  <option <?php if($record->review_period_to == "5") echo "selected";?> value="5">May</option>
                  <option <?php if($record->review_period_to == "6") echo "selected";?> value="6">June</option>
                  <option <?php if($record->review_period_to == "7") echo "selected";?> value="7">July</option>
                  <option <?php if($record->review_period_to == "8") echo "selected";?> value="8">August</option>
                  <option <?php if($record->review_period_to == "9") echo "selected";?> value="9">September</option>
                  <option <?php if($record->review_period_to == "10") echo "selected";?> value="10">October</option>
                  <option <?php if($record->review_period_to == "11") echo "selected";?> value="11">November</option>
                  <option <?php if($record->review_period_to == "12") echo "selected";?> value="12">December</option>
                </select>
              </div>
              <div class="col-lg-6 mt-3">
                <label>Review Date:<span style="color:red;">*</span></label>
                <input type="date" name="review_date" class="form-control" value="<?php echo $record->review_date;?>" >
              </div>
          </div>
        </div>

        <!-- Employee Details -->
        <div class="form-row form-section">
          <div class="row">
            <div class="col-md-6 mt-3">
              <label>Name: <span style="color:red;">*</span></label>
              <select class="form-control form-control-sm select2" id="user_id" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" disabled>
                  <option value="">Select User</option>
                  <?php foreach ($user_records as $user) { ?>
                      <option <?php if($record->user_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-md-6">
              <label>Employee ID:</label>
              <input type="text" name="user_code" id="user_code" class="form-control" value="<?php echo $user->user_code; ?>">
            </div>
            <div class="col-md-6 mt-3">
              <label>Designation:</label>
              <select class="form-control form-control-sm select2" name="desig_id" id="desig_id">
                  <option value="">Select Designation</option>
                  <?php foreach ($desig_list as $desig) { ?>
                      <option <?php if($record->dept_id == $desig->did) echo "selected";?> value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mt-3">
              <label>Department:</label>
              <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" readonly>
                  <option value="">Select Department</option>
                  <?php foreach ($dept_list as $dept) { ?>
                      <option <?php if($record->desig_id == $dept->dept_id) echo "selected";?> value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mt-3">
                <label class="form-label">Signed Review Form:</label>
                <input type="file" name="review_form_upld" class="form-control"/> 
                <?php if(!empty($record->review_doc_path)):?>  
                <a href="<?php echo base_url(). 'public/uploded_documents/' . $record->review_doc_path;?>">View Document</a>
                <?php endif;?>
            </div>
          </div>
        </div>

        <!-- Evaluation Table -->
        <p><strong>Performance Evaluation Criteria:</strong><br>
          Please rate the employee’s performance in the following areas on a scale of 1 to 5:<br>
          1 = Poor, 2 = Fair, 3 = Satisfactory, 4 = Good, 5 = Excellent
        </p>
        <?php //print_r($record1); ?>
       

            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>Criteria</th>
                  <th class="text-center">Rating (1–5)</th>
                  <th>Comments/Examples</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $total_count = 1;
                foreach ($record1 as $index => $row):
                  if($index <= 10): ?>
                    <tr>
                      <td><?= $row->criteria ?>
                      <input type="hidden" name="entry_id[<?= $total_count ?>]" value="<?php echo $row->entry_id;?>" />
                      </td>
                      <td class="text-center">
                          <?php for ($i = 1; $i <= 5; $i++): ?>
                            <label class="mr-2">
                              <input type="radio" name="criteria_<?= $total_count ?>" value="<?= $i ?>" <?= ($row->rating == $i) ? 'checked' : '' ?>>
                              <?= $i ?>
                            </label>
                          <?php endfor; ?>
                        </td>

                      <td>
                        <input type="text" class="form-control" name="criteria_<?php echo $total_count; ?>_comment" value="<?php echo $row->comments;?>" >
                      </td>
                    </tr>
                    <?php 
                    $total_count++; 
                  endif;
              endforeach; ?>
              </tbody>
            </table>

              <div class="mt-3">
                <h6>Sales and Marketing</h6>
                <table class="table table-bordered">
                  <tbody>
                    <?php
                    // Initialize this before the loop
                    foreach ($record1 as $index => $row):
                      if ($index > 10 && $index <= 13):
                        $field_name = "criteria_" . $total_count;
                    ?>
                        <tr>
                          <td>
                            <?= htmlspecialchars($row->criteria) ?>
                            <input type="hidden" name="entry_id[<?= $total_count ?>]" value="<?= htmlspecialchars($row->entry_id) ?>" />
                          </td>
                          <td class="text-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <label class="mr-2">
                                <input type="radio" name="<?= $field_name ?>" value="<?= $i ?>" <?= ($row->rating == $i) ? 'checked' : '' ?>> <?= $i ?>
                              </label>
                            <?php endfor; ?>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="<?= $field_name ?>_comment" value="<?php echo $row->comments;?>">
                          </td>
                        </tr>
                    <?php
                        $total_count++;
                      endif;
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>

              <div class="mt-3">
                <h6>Operations</h6>
                <table class="table table-bordered">
                  <tbody>
                    <?php
                    // Initialize this before the loop
                    foreach ($record1 as $index => $row):
                      if ($index > 13 && $index <= 16):
                        $field_name = "criteria_" . $total_count;
                    ?>
                        <tr>
                          <td>
                            <?= htmlspecialchars($row->criteria) ?>
                            <input type="hidden" name="entry_id[<?= $total_count ?>]" value="<?= htmlspecialchars($row->entry_id) ?>" />
                          </td>
                          <td class="text-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <label class="mr-2">
                                <input type="radio" name="<?= $field_name ?>" value="<?= $i ?>" <?= ($row->rating == $i) ? 'checked' : '' ?>> <?= $i ?>
                              </label>
                            <?php endfor; ?>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="<?= $field_name ?>_comment" value="<?php echo $row->comments;?>">
                          </td>
                        </tr>
                    <?php
                        $total_count++;
                      endif;
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>

              <div class="mt-3">
                <h6>HR & Admin</h6>
                <table class="table table-bordered">
                  <tbody>
                    <?php
                    // Initialize this before the loop
                    foreach ($record1 as $index => $row):
                      if ($index > 16 && $index <= 19):
                        $field_name = "criteria_" . $total_count;
                    ?>
                        <tr>
                          <td>
                            <?= htmlspecialchars($row->criteria) ?>
                            <input type="hidden" name="entry_id[<?= $total_count ?>]" value="<?= htmlspecialchars($row->entry_id) ?>" />
                          </td>
                          <td class="text-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <label class="mr-2">
                                <input type="radio" name="<?= $field_name ?>" value="<?= $i ?>" <?= ($row->rating == $i) ? 'checked' : '' ?>> <?= $i ?>
                              </label>
                            <?php endfor; ?>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="<?= $field_name ?>_comment" value="<?php echo $row->comments;?>">
                          </td>
                        </tr>
                    <?php
                        $total_count++;
                      endif;
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>

              <div class="mt-3">
                <h6>Accounts and Finance</h6>
                <table class="table table-bordered">
                  <tbody>
                    <?php
                    // Initialize this before the loop
                    foreach ($record1 as $index => $row):
                      if ($index > 19 && $index <= 22):
                        $field_name = "criteria_" . $total_count;
                    ?>
                        <tr>
                          <td>
                            <?= htmlspecialchars($row->criteria) ?>
                            <input type="hidden" name="entry_id[<?= $total_count ?>]" value="<?= htmlspecialchars($row->entry_id) ?>" />
                          </td>
                          <td class="text-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <label class="mr-2">
                                <input type="radio" name="<?= $field_name ?>" value="<?= $i ?>" <?= ($row->rating == $i) ? 'checked' : '' ?>> <?= $i ?>
                              </label>
                            <?php endfor; ?>
                          </td>
                          <td>
                            <input type="text" class="form-control" name="<?= $field_name ?>_comment" value="<?php echo $row->comments;?>">
                          </td>
                        </tr>
                    <?php
                        $total_count++;
                      endif;
                    endforeach;
                    ?>
                  </tbody>
                </table>
              </div>

            <div class="mt-3">
                <h6>Overall Strategic Performance Rating</h6>
                <table class="table table-borderless">
                  
                  <tbody>
                    <tr>
                      <td>Rating</td>
                      <td class="text-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                          <label class="mr-2">
                            <input <?= ($record->overall_rating == $i) ? 'checked' : '' ?> type="radio" name="overall_rating" value="<?= $i ?>"> <?= $i ?>
                          </label>
                        <?php endfor; ?>
                      </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Comments</td>
                      <td colspan='3' width='70%'><textarea name="comments" class="form-control w-100" rows="3" placeholder="Enter your comments here..."><?php echo $record->comments;?></textarea></td>
                      <td></td>   
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Areas for Improvement</td>
                      <td colspan='3' width='70%'><textarea name="improvements" class="form-control w-100" rows="3" placeholder="Enter your comments here..."><?php echo $record->improvements;?></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Goals For Next Review Period</td>
                      <td colspan='3' width='70%'><textarea name="goals" class="form-control w-100" rows="3" placeholder="Enter your comments here..."><?php echo $record->goals;?></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Employee Self-Assessment<br/>What do you think you did well in this review period ?</td>
                      <td colspan='3' width='70%'><textarea name="self_assessment_good" class="form-control w-100" rows="3" placeholder="Enter your comments here..."><?php echo $record->self_assessment_good;?></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>What areas would you like to improve on ?</td>
                      <td colspan='3' width='70%'><textarea name="self_assessment_improve" class="form-control w-100" rows="3" placeholder="Enter your comments here..."><?php echo $record->self_assessment_improve;?></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Manager's Comment </td>
                      <td colspan='3' width='70%'><textarea name="manager_comment" class="form-control w-100" rows="3" placeholder="Enter your comments here..."><?php echo $record->manager_comment;?></textarea></td>
                      <td></td>  
                    </tr>
                  </tbody>
                </table>
              </div>
<?php 
                $all_approved_ids = array();
                 $hr_flag = false;
                 $hod_flag = false;
                 $ceo_flag = false;
                 $hr_readonly = "";
                 $ceo_readonly = "";
                 $login_user_id = $this->session->userdata('user_id');
                 foreach($comp_hr_hod_ceo as $allowed_users):
                     $ceo_ids[] = $allowed_users->approve_ceo;
                     $hr_ids[] = $allowed_users->approve_hr;
                     $hod_ids[] = $allowed_users->approve_admin_md;
                 endforeach;
                 if(!empty($ceo_ids)){
                     $ceo_ids = array_unique($ceo_ids);
                     if (in_array($login_user_id, $ceo_ids)) {
                         $ceo_flag=true;
                         $ceo_readonly ="";
                     } else {
                         $ceo_flag=false;
                         $ceo_readonly ="disabled";
                     }
                 }
                 if(!empty($hr_ids)){
                     $hr_ids = array_unique($hr_ids);
                     if (in_array($login_user_id, $hr_ids)) {
                         $hr_flag=true;
                         $hr_readonly="";
                     } else {
                         $hr_flag=false;
                         $hr_readonly="disabled";
                     }
                 }
                 if(!empty($hod_ids)){
                     $hod_ids = array_unique($hod_ids);
                     if (in_array($login_user_id, $hod_ids)) {
                         $hod_flag=true;
                     } else {
                         $hod_flag=false;
                     }
                 }
                
                ?>

        <h3 class="mt-4">Approval</h3>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Requested By (HOD Sign)</label>
  <div class="col-sm-2">
    <?php
        // Find requested_by user name (optional if you already have it in $record)
        $requested_by_name = '';
        foreach ($user_records as $user) {
            if ($user->user_id == $record->created_by) {
                $requested_by_name = $user->user_name;
                break;
            }
        }
    ?>
    <input type="text" class="form-control form-control-sm" 
      value="<?php echo htmlspecialchars($record->created_by_name); ?>" disabled>
    <input type="hidden" name="hod_sign" value="<?php echo $record->created_by; ?>">
</div>

           
            <label class="col-sm-2 col-form-label">HR</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="hr_id" <?php echo $hr_readonly;?>>
                    <option value="">Select User</option>
                    <?php foreach ($comp_hr as $user) { ?>
                        <option <?php if($record->hr_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
                <?php if($ceo_flag == true):?>   
                    <input type="hidden" name="hr_id" id="hr_id" value="<?php echo $record->hr_id;?>"/>
                    <input type="hidden" name="hr_approval" id="hr_approval" value="<?php echo $record->hr_approval;?>"/>
                <?php endif; ?>
            </div> 
                   
            <label class="col-sm-2 col-form-label">HR Approval</label>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" name="hr_approval" id="hr_approval" <?php echo $hr_readonly;?>>
                    <option <?php if($record->hr_approval == "0") echo "selected";?> value="0">Pending</option>
                    <option <?php if($record->hr_approval == "1") echo "selected";?> value="1">Approved</option>
                    <option <?php if($record->hr_approval == "2") echo "selected";?> value="2">Not Approved</option>
                </select>
                
            </div>
        </div>
                
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">CEO</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="ceo_id" <?php echo $ceo_readonly;?>>
                    <option value="">Select User</option>
                    <?php foreach ($comp_hr_hod_ceo as $user) { ?>
                        <option <?php if($record->ceo_id == $user->user_id) echo "selected";?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                    <?php } ?>
                </select>
                <?php if($hr_flag == true):?>
                    <input type="hidden" name="ceo_id" id="ceo_id" value="<?php echo $record->ceo_id;?>"/>
                    <input type="hidden" name="ceo_approval" id="ceo_approval" value="<?php echo $record->ceo_approval;?>"/>
                <?php endif; ?>
            </div>
            <label class="col-sm-3 col-form-label">Approved/Not Approved (CEO)</label>
            <div class="col-sm-3">
                <select class="form-control form-control-sm" name="ceo_approval" id="ceo_approval" <?php echo $ceo_readonly;?>>
                    <option <?php if($record->ceo_approval == "0") echo "selected";?> value="0">Pending</option>
                    <option <?php if($record->ceo_approval == "1") echo "selected";?> value="1">Approved</option>
                    <option <?php if($record->ceo_approval == "2") echo "selected";?> value="2">Not Approved</option>
                </select>
                
            </div>
        </div>
        <!-- Submit -->
        <div class="text-center mt-4">
        <input type="hidden" name="review_id" value="<?= $record->review_id ?>" />
          <button type="submit" class="btn btn-primary">Update Review</button>
        </div>
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