<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Performance Review Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    .page-header, .page-header-space {
        height: 100px;
        }

        .page-footer, .page-footer-space {
        height: 30px;

        }

        .page-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        border-top: 1px solid white; /* for demo */
        background: white; /* for demo */
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            border-bottom: 1px solid white; /* for demo */
            background: white; /* for demo */
        }
        .container1 {
            padding-bottom: 128px; /* or more if needed */
        }
    @page {
        margin: 20mm
        margin-bottom: 128px;
        }

    @media print {
        thead {display: table-header-group;} 
        tfoot {display: table-footer-group;}
        
        button {display: none;}
        
        body {margin: 0;}
        .page-break {
            page-break-after: always;
        }
    }
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-bottom: 30px;
    }

       
    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background: #fff;
      border-top: 1px solid #ccc;
      text-align: center;
      padding: 10px;
      font-size: 12px;
      z-index: 2;
      page-break-after: avoid;
    }

    @media print {
      body {
        margin-bottom: 100px;
        font-size:14px;
      }
      .col-md-6 {
        float: left;
        width: 50%;
      }
    }
    .noborders{
       border-color: transparent;
        border-bottom-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
    }
    /* #clearancetTable td, th {
        padding: 12px 8px !important; 
        height: 70px;                 
    } */
    .signature-line {
      border-bottom: 1px solid #6c0a25;
      margin-top: 10px;
      width: 300px;
    }
    .section {
      margin-top: 20px;
    }

    @media print {
  input[type="radio"] {
    -webkit-appearance: auto !important;
    appearance: auto !important;
    print-color-adjust: exact;
  }

  input[type="radio"]::before {
    content: "";
  }

  input[type="radio"]:checked::before {
    /* content: "●";  */
    /* font-size: 25px; */
    /* display: inline-block; */
    /* color: black; */
    /* margin-right: 4px; */
    /* margin-top: -10px; */
  }

  input[type="radio"] {
    width: 18px;
    height: 18px;
  }

  label {
    display: inline-flex;
    align-items: center;
  }
}
            
    </style>
</head>
<body>

    <div class="page-header">
        <div class="text-center mb-4">
            <img style="float:left;" src="<?php echo base_url();?>public/logo/print_logo.png" alt="Company Logo" class="logo">
        </div>
    </div>
    <table class="noborders">

    <thead>
      <tr>
        <td style="border: none !important;">
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>
    <tbody>
        <tr>
            <td class="d-flex align-items-center justify-content-left" style="border:none !important;">
                <h4 style="vertical-align: middle;width:100%;">Performance Review Form</h4>
            </td>
        </tr>
        <tr>
          <td style="border: none !important;">
              
                <div class="container1 page p-6">
                  
                  <?php if(!empty($records)){ 
                    
                    ?>
                    <table class="table table-bordered" >
                      <tbody>
                          <tr>
                              <td><strong>Name :</strong><?php echo $records->user_name.' '.$records->middle_name.' '.$records->last_name;?></td>
                              <td><strong>Employee ID : </strong><?php echo $records->user_code; ?></td>
                              
                          </tr>
                          <tr>
                              <td><strong>Review Date :</strong><?php echo $records->review_date; ?></td>
                              <td><strong>Review From - To :</strong><?php echo $records->review_period_from.'-'.$records->review_period_to; ?></td>
                          </tr>
                          <tr>
                              <td><strong>Department : </strong><?php echo $records->dept_name;?></td>
                              <td><strong>Designation : </strong><?php echo $records->designation_name;?></td>
                              
                          </tr>
                          
                      </tbody>
                    </table>
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Criteria</th>
                        <th>Rating (1–5)</th>
                        <th>Comments/Examples</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($record1 as $row):
                        $criteria_list = [
                          'Approach to Work',
                          'Work Culture Alignment',
                          'Systems & Processes Compliance',
                          'Reporting & Transparency',
                          'Time Management',
                          'Responsibility & Accountability',
                          'Ownership & Leadership',
                          'Vision Knowledge & Alignment',
                          'Dependability & Reliability',
                          'Teamwork & Coordination',
                          'Problem-Solving & Decision-Making'
                        ];
                        $i = 1;
                        foreach ($criteria_list as $criteria): 
                          
                            if($criteria == $row->criteria){

                              $selected_rating = isset($row->rating) ? $row->rating : null;?>
                              <tr>
                                <td width='30%' ><?= $criteria ?></td>
                                <td width='30%' class="text-center">
                                  <div class="radio-group">
                                    <?php for ($j = 1; $j <= 5; $j++): ?>
                                      <label>
                                        <input type="radio" name="criteria_<?= $i ?>" value="<?= $j ?>" <?= ($selected_rating == $j) ? 'checked' : '' ?>> <?= $j ?>
                                      </label>
                                    <?php endfor; ?>
                                  </div>
                                </td>
                                <td><p><?php echo $row->comments;?></p></td>
                              </tr>
                            <?php }
                          
                          $i++; 
                          endforeach; 
                        endforeach; ?>
                    </tbody>
                  </table>
                  <br/><br/><br/> <br/> <br/>     
                  <h6 class="section-title mt-2"><strong>Department-Specific Evaluation:</strong></h6>

                  <!-- Sales and Marketing -->
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th colspan="3">Sales and Marketing</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($record1 as $row):
                        $criteria_list = [
                          'Client Relationship Management',
                          'Marketing Campaign Execution',
                          'Sales Target Achievement',
                        ];
                        $i = 1;
                        foreach ($criteria_list as $criteria): 
                          if($criteria == $row->criteria){

                            $selected_rating = isset($row->rating) ? $row->rating : null;?>

                              <tr>
                                <td width='30%' ><?= $criteria ?></td>
                                <td width='30%' class="text-center">
                                  <div class="radio-group">
                                    <?php for ($j = 1; $j <= 5; $j++): ?>
                                      <label>
                                        <input type="radio" name="sales_<?= $i ?>" value="<?= $j ?>" <?= ($selected_rating == $j) ? 'checked' : '' ?>> <?= $j ?>
                                      </label>
                                    <?php endfor; ?>
                                  </div>
                                </td>
                                <td><p><?php echo $row->comments;?></p></td>
                              </tr>
                            <?php }
                          
                          $i++; 
                          endforeach; 
                        endforeach; ?>
                      
                    </tbody>
                  </table>

                  <!-- Repeat block below for each department -->

                  <!-- Operations -->
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th colspan="3">Operations</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($record1 as $row):
                        $criteria_list = [
                          'Project Management & Coordination',
                          'Production Quality & Timeliness',
                          'Cross-Department Collaboration',
                        ];
                        $i = 1;
                        foreach ($criteria_list as $criteria): 
                          if($criteria == $row->criteria){

                            $selected_rating = isset($row->rating) ? $row->rating : null;?>

<tr>
                                <td width='30%' ><?= $criteria ?></td>
                                <td width='30%' class="text-center">
                                  <div class="radio-group">
                                    <?php for ($j = 1; $j <= 5; $j++): ?>
                                      <label>
                                        <input type="radio" name="ops_<?= $i ?>" value="<?= $j ?>" <?= ($selected_rating == $j) ? 'checked' : '' ?>> <?= $j ?>
                                      </label>
                                    <?php endfor; ?>
                                  </div>
                                </td>
                                <td width='40%'><p><?php echo $row->comments;?></p></td>
                              </tr>
                            <?php }
                          
                          $i++; 
                          endforeach; 
                        endforeach; ?>
                      
                    </tbody>
                  </table>

                  <!-- HR -->
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th colspan="3">HR & Admin</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($record1 as $row):
                        $criteria_list = [
                          'Employee Relations & Engagement',
                          'Recruitment & Onboarding',
                          'Compliance & Policy Enforcement',
                        ];
                        $i = 1;
                        foreach ($criteria_list as $criteria): 
                          if($criteria == $row->criteria){

                            $selected_rating = isset($row->rating) ? $row->rating : null;?>

<tr>
                                <td width='30%' ><?= $criteria ?></td>
                                <td width='30%' class="text-center">
                                  <div class="radio-group">
                                    <?php for ($j = 1; $j <= 5; $j++): ?>
                                      <label>
                                        <input type="radio" name="hr_<?= $i ?>" value="<?= $j ?>" <?= ($selected_rating == $j) ? 'checked' : '' ?>> <?= $j ?>
                                      </label>
                                    <?php endfor; ?>
                                  </div>
                                </td>
                                <td width='40%'><p><?php echo $row->comments;?></p></td>
                              </tr>
                            <?php }
                          
                          $i++; 
                          endforeach; 
                        endforeach; ?>
                      
                    </tbody>
                  </table>

                  <!-- HR -->
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th colspan="3">Accounts and Finance</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($record1 as $row):
                        $criteria_list = [
                          'Financial Accuracy & Reporting',
                          'Budget Management & Cost Control',
                          'Audit & Compliance',
                        ];
                        $i = 1;
                        foreach ($criteria_list as $criteria): 
                          if($criteria == $row->criteria){

                            $selected_rating = isset($row->rating) ? $row->rating : null;?>

<tr>
                                <td width='30%' ><?= $criteria ?></td>
                                <td width='30%' class="text-center">
                                  <div class="radio-group">
                                    <?php for ($j = 1; $j <= 5; $j++): ?>
                                      <label>
                                        <input type="radio" name="acc_<?= $i ?>" value="<?= $j ?>" <?= ($selected_rating == $j) ? 'checked' : '' ?>> <?= $j ?>
                                      </label>
                                    <?php endfor; ?>
                                  </div>
                                </td>
                                <td width='40%'><p><?php echo $row->comments;?></p></td>
                              </tr>
                            <?php }
                          
                          $i++; 
                          endforeach; 
                        endforeach; ?>
                      
                    </tbody>
                  </table>

                                    

                  <div class="mt-3">
                    <h6><strong>Overall Strategic Performance Rating</strong></h6>
                    <table class="table table-borderless">
                      
                      <tbody>
                        <tr style='height:4px;'>
                          <td style='padding:0px;'>Rating</td>
                          <td style='padding:0px;' class="text-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <label class="mr-2">
                                <input <?php if($records->overall_rating == $i) echo "checked";?> type="radio" name="overall_rating" value="<?= $i ?>"> <?= $i ?>
                              </label>
                            <?php endfor; ?>
                          </td>
                          <td></td>
                        </tr>
                        <tr style='height:4px;'>
                          <td style='padding:0px;' width='70%'>Comments</td>
                          <td style='padding:0px;'></td> 
                        </tr>
                        <tr style='height:4px;'>
                          <td style='padding:0px;' colspan='3' width='70%'><p name="comments" class="form-control w-100" ><?php echo $records->comments?></p></td>
                          <td style='padding:0px;'></td>   
                        </tr>
                        <tr style='height:4px;'><td style='padding:0px;' colspan='' width='70%'>Areas for Improvement</td><td style='padding:0px;'></td> </tr>
                        <tr style='height:4px;'>
                          <td style='padding:0px;' colspan='3' width='70%'><p name="improvements" class="form-control w-100" ><?php echo $records->improvements?></p></td>
                          <td style='padding:0px;'></td>  
                        </tr>
                        <tr style='height:4px;'><td style='padding:0px;' colspan='' width='70%'>Goals For Next Review Period</td><td style='padding:0px;'></td></tr>
                        <tr style='height:4px;'>
                          <td style='padding:0px;' colspan='3' width='70%'><p name="goals" class="form-control w-100" ><?php echo $records->goals?></p></td>
                          <td style='padding:0px;'></td>  
                        </tr>
                        <tr style='height:4px;'><td style='padding:0px;' colspan='' width='70%'>Employee Self-Assessment<br/><br/>What do you think you did well in this review period ?</td><td style='padding:0px;'></td></tr>
                        <tr style='height:4px;'>
                          <td style='padding:0px;' colspan='3' width='70%'><p name="self_assessment_good" class="form-control w-100" ><?php echo $records->self_assessment_good?></p></td>
                          <td style='padding:0px;'></td>  
                        </tr>
                        <tr style='height:4px;'><td style='padding:0px;' colspan='' width='70%'>What areas would you like to improve on ?</td><td style='padding:0px;'></td></tr>
                        <tr style='height:4px;'>
                          <td style='padding:0px;' colspan='3' width='70%'><p name="self_assessment_improve" class="form-control w-100" ><?php echo $records->self_assessment_improve?></p></td>
                          <td style='padding:0px;'></td>  
                        </tr>
                        <tr style='height:4px;'><td style='padding:0px;' colspan='' width='70%'>Manager's Comment </td><td style='padding:0px;'></td></tr>
                        <tr style='height:4px;'>
                          <td style='padding:0px;' colspan='3' width='70%'><p name="manager_comment" class="form-control w-100" ><?php echo $records->manager_comment?></p></td>
                          <td style='padding:0px;'></td>  
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  
                  <div class="section">
                    <strong>Employee Acknowledgment:</strong>
                    <p>
                    I acknowledge that I have reviewed this performance evaluation and discussed it with my manager.
                    </p>

                    <div class="d-flex justify-content-between mt-4">
                      <div>
                        <label><strong>Employee Signature:</strong></label><br/><br/><br/>
                        <div class="signature-line"></div>
                      </div>
                      <div><br/><br/><br/>
                        <label><strong>Date:</strong> ___/___/______</label>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                      <div>
                        <label><strong>Manager's Signature:</strong></label><br/><br/><br/>
                        <div class="signature-line"></div>
                      </div>
                      <div><br/><br/><br/>
                        <label><strong>Date:</strong> ___/___/______</label>
                      </div>
                    </div>

                  </div>
                      
                </div>
                
            <?php } ?>
          </td>
        </tr>
    </tbody>

    <!-- <tfoot style="border-color: white !important;">
      <tr>
        <td style="border:none !important;">
            <div class="page-footer">
            <div class="text-center mb-4">
                <img  src="<?php echo base_url();?>public/logo/print_footer.png" alt="Company Logo" class="logo">
            </div>
            </div>
            </td>
      </tr>
    </tfoot> -->

  </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>