<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_review_data" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
      <div class="container mt-4"> 
        <!-- Review Info -->
        <div class="form-row form-section">
          <div class="row">
              <div class="col-lg-3">
                <label>Review Period - From: <span style="color:red;">*</span></label>
                <select class="form-control" name="from_month" required>
                  <option value="">-- Select Month --</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>

              </div>
              <div class="col-lg-3">
                <label> To: <span style="color:red;">*</span></label>
                <select class="form-control" name="to_month" required>
                  <option value="">-- Select Month --</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
              </div>
              <div class="col-lg-6">
                <label>Review Date:<span style="color:red;">*</span></label>
                <input type="date" name="review_date" class="form-control" value="<?php echo date('Y-m-d');?>" >
              </div>
          </div>
        </div>

        <!-- Employee Details -->
        <div class="form-row form-section">
          <div class="row">
            <div class="col-md-6">
              <label>Name: <span style="color:red;">*</span></label>
              <select class="form-control form-control-sm select2" id="user_id" name="user_id" required onchange="getEmployeeDetailsAjax(this.value);" >
                  <option value="">Select User</option>
                  <?php foreach ($user_records as $user) { ?>
                      <option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name; ?></option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-md-6">
              <label>Employee ID:</label>
              <input type="text" name="user_code" id="user_code" class="form-control" value="">
            </div>
            <div class="col-md-6 mt-3">
              <label>Designation:</label>
              <select class="form-control form-control-sm select2" name="desig_id" id="desig_id">
                  <option value="">Select Designation</option>
                  <?php foreach ($desig_list as $desig) { ?>
                      <option value="<?php echo $desig->did; ?>"><?php echo $desig->designation_name; ?></option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-md-6 mt-3">
              <label>Department:</label>
              <select class="form-control form-control-sm select2" name="dept_id" id="dept_id" readonly>
                  <option value="">Select Department</option>
                  <?php foreach ($dept_list as $dept) { ?>
                      <option value="<?php echo $dept->dept_id; ?>"><?php echo $dept->dept_name; ?></option>
                  <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <!-- Evaluation Table -->
        <p><strong>Performance Evaluation Criteria:</strong><br>
          Please rate the employee’s performance in the following areas on a scale of 1 to 5:<br>
          1 = Poor, 2 = Fair, 3 = Satisfactory, 4 = Good, 5 = Excellent
        </p>

        <?php
            $criteria_list = [
                "Approach to Work",
                "Work Culture Alignment",
                "Systems & Processes Compliance",
                "Reporting & Transparency",
                "Time Management",
                "Responsibility & Accountability",
                "Ownership & Leadership",
                "Vision Knowledge & Alignment",
                "Dependability & Reliability",
                "Teamwork & Coordination",
                "Problem-Solving & Decision-Making"
            ];
            
            ?>

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
                foreach ($criteria_list as $index => $criteria): ?>
                  <tr>
                    <td><?= $criteria ?>
                    <input type="hidden" name="criteria_<?php echo $total_count; ?>_label" value="<?php echo $criteria;?>" />
                    </td>
                    <td class="text-center">
                      <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label class="mr-2">
                          <input type="radio" name="criteria_<?php echo $total_count; ?>" value="<?= $i ?>"> <?= $i ?>
                        </label>
                      <?php endfor; ?>
                    </td>
                    <td>
                      <input type="text" class="form-control" name="criteria_<?php echo $total_count; ?>_comment">
                    </td>
                  </tr>
                <?php 
              $total_count++; 
              endforeach; ?>
              </tbody>
            </table>

        <?php
            $departments = [
                "Sales and Marketing" => [
                    "Client Relationship Management",
                    "Marketing Campaign Execution",
                    "Sales Target Achievement"
                ],
                "Operations" => [
                    "Project Management & Coordination",
                    "Production Quality & Timeliness",
                    "Cross-Department Collaboration"
                ],
                "HR and Admin" => [
                    "Employee Relations & Engagement",
                    "Recruitment & Onboarding",
                    "Compliance & Policy Enforcement"
                ],
                "Accounts and Finance" => [
                    "Financial Accuracy & Reporting",
                    "Budget Management & Cost Control",
                    "Audit & Compliance"
                ]
            ];
            ?>

            <?php foreach ($departments as $dept => $criteria_list): ?>
              <div class="mt-3">
                <h6><?= $dept ?></h6>
                <table class="table table-bordered">
                  
                  <tbody>
                    <?php foreach ($criteria_list as $index => $criteria): ?>
                      <?php $field_name = strtolower(str_replace([' ', '&'], '_', $dept)) . "_$index"; ?>
                      <tr>
                        <td><?= $criteria ?>
                        <input type="hidden" name="criteria_<?php echo $total_count; ?>_label" value="<?php echo $criteria;?>" />
                      </td>
                        <td class="text-center">
                          <?php for ($i = 1; $i <= 5; $i++): ?>
                            <label class="mr-2">
                              <input type="radio" name="criteria_<?php echo $total_count; ?>" value="<?= $i ?>"> <?= $i ?>
                            </label>
                          <?php endfor; ?>
                        </td>
                        <td><input type="text" class="form-control" name="criteria_<?php echo $total_count; ?>_comment"></td>
                      </tr>
                    <?php 
                  $total_count++;
                  endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endforeach; ?>

            <div class="mt-3">
                <h6>Overall Strategic Performance Rating</h6>
                <table class="table table-borderless">
                  
                  <tbody>
                    <tr>
                      <td>Rating</td>
                      <td class="text-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                          <label class="mr-2">
                            <input type="radio" name="overall_rating" value="<?= $i ?>"> <?= $i ?>
                          </label>
                        <?php endfor; ?>
                      </td>
                      <td></td>
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Comments</td>
                      <td colspan='3' width='70%'><textarea name="comments" class="form-control w-100" rows="3" placeholder="Enter your comments here..."></textarea></td>
                      <td></td>   
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Areas for Improvement</td>
                      <td colspan='3' width='70%'><textarea name="improvements" class="form-control w-100" rows="3" placeholder="Enter your comments here..."></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Goals For Next Review Period</td>
                      <td colspan='3' width='70%'><textarea name="goals" class="form-control w-100" rows="3" placeholder="Enter your comments here..."></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Employee Self-Assessment<br/>What do you think you did well in this review period ?</td>
                      <td colspan='3' width='70%'><textarea name="self_assessment_good" class="form-control w-100" rows="3" placeholder="Enter your comments here..."></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>What areas would you like to improve on ?</td>
                      <td colspan='3' width='70%'><textarea name="self_assessment_improve" class="form-control w-100" rows="3" placeholder="Enter your comments here..."></textarea></td>
                      <td></td>  
                    </tr>
                    <tr>
                      <td colspan='' width='20%'>Manager's Comment </td>
                      <td colspan='3' width='70%'><textarea name="manager_comment" class="form-control w-100" rows="3" placeholder="Enter your comments here..."></textarea></td>
                      <td></td>  
                    </tr>
                  </tbody>
                </table>
              </div>

        <!-- Submit -->
        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary">Submit Review</button>
        </div>
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
            $('#user_code').val(msg.user_code);
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
<style>
  .form-section {
      margin-bottom: 20px;
    }
    .rating label {
      margin-right: 10px;
    }
    th, td {
      vertical-align: middle !important;
    }
</style>