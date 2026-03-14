<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Application For Employment</title>
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
    .photo-box {
            border: 1px solid #000;
            width: 150px;
            height: 180px;
            text-align: center;
            font-size: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
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
                <h4 style="vertical-align: middle;width:100%;">APPLICATION FOR EMPLOYMENT</h4>
            </td>
        </tr>
        <tr>
          <td style="border: none !important;">
              
                <div class="container1 page p-6">
                  
                  <?php if(!empty($record)){ 
                    
                    ?>
                    <table class="table table-bordered" >
                      <tbody>
                          <tr>
                              <td><strong>Position Applied for :</strong><?php echo $record->designation_name;?></td>
                              <td><strong>Date :</strong><?php echo $record->application_date; ?></td>
                          </tr>
                          <tr>
                              <td><strong>Applicant Name :</strong><?php echo $record->applicant_name; ?></td>
                              <td><strong>Date of Birth : </strong><?php echo $record->date_of_birth; ?></td>
                          </tr>
                          <tr>
                              <td><strong>Age : </strong><?php echo $record->age; ?></td>
                              <td><strong>Contact Number : </strong><?php echo $record->contact_number;?></td>
                          </tr>
                          <tr>
                              <td><strong>Driving License : </strong><?php echo $record->driving_license;?></td>
                              <td><strong>Passport No :</strong> <?php echo $record->passport_no;?> Expiry: <?php echo $record->passport_expiry;?></td>
                          </tr>
                          <tr>
                              <td><strong>EID No :</strong> <?php echo $record->eid_no;?> Expiry: <?php echo $record->eid_expiry;?></td>
                              <td><strong>Visa Status : </strong><?php echo $record->visa_status;?> Expiry: <?php echo $record->visa_expiry;?></td>
                          </tr>
                          <tr>
                              <td><strong>Notice period : </strong><?php echo $record->notice_period;?></td>
                              <td><strong>Present Employer:</strong> <?php echo $record->curr_employer;?> Position : <?php echo $record->curr_designation;?></td>
                          </tr>
                          <tr>
                              <td><strong>Date of Employment From - To : </strong><?php echo $record->curr_work_from.' - '.$record->curr_work_to;?></td>
                              <td><strong>Current Salary :</strong> <?php echo $record->curr_salary;?> </td>
                          </tr>
                          <tr>
                            <td colspan='2'><strong>Reason For Seeking Change :</strong> <br/><?php echo $record->reason_change;?> </td>
                              
                          </tr>
                          <tr>
                              <td colspan='2'><strong>Major Responsibilities : </strong><br/><?php echo $record->curr_responsibilities;?></td>
                          </tr>
                          <tr>
                            <td colspan='2'><strong>Major Achievements : </strong><br/><?php echo $record->achievements;?></td>
                             
                          </tr>
                          <tr>
                            <td colspan='2'><strong>Are You Undertaking any course or study at the present? If so, please provide details : </strong><br/><?php echo $record->curr_course;?></td>
                          </tr>
                          <tr>
                              <td colspan='2'><strong>Please Provide Information on any Illnesses / medical condition that you have had in the past 3 years: (Including ongoing medication / treatment, if any) : </strong><br/><?php echo $record->curr_medication;?></td>
                          </tr>
                      </tbody>
                    </table>
                    <h6>Education/Skills:</h6>
                    <table class="table table-bordered" id="clearancetTable">
                      <thead class="table-light">
                          <tr>
                              <th Width="25%" >Qualification</th>
                              <th Width="25%">University/College/Institution</th>
                              <th Width="25%">Grade/Percenage</th>
                              <th Width="25%">Month & Year</th>

                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($education as $edu):?>
                          <tr>
                              <td><?php echo $edu->qualification;?></td>
                              <td><?php echo $edu->institute;?></td>
                              <td><?php echo $edu->grade;?>
                              <td><?php echo $edu->passout_month.'-'.$edu->passout_year;?></td>
                          </tr>
                          <?php endforeach;?>
                      </tbody>
                    </table>
                    <h6>Family Details:</h6>
                    <table class="table table-bordered" id="clearancetTable">
                      <thead class="table-light">
                          <tr>
                              <th Width="25%">Name</th>
                              <th Width="25%">Relationship</th>
                              <th Width="25%">Occupation</th>
                              <th Width="25%">Contact Details</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($family as $fam):
                          if(!empty($fam->name)){?>
                          <tr>
                              <td><?php echo $fam->name;?></td>
                              <td><?php echo $fam->relation;?></td>
                              <td><?php echo $fam->occupation;?>
                              <td><?php echo $fam->contact_no;?></td>
                          </tr>
                          <?php } endforeach;?>
                      </tbody>
                    </table>

                    <h6>Employment History:</h6>
                    <table class="table table-bordered" id="clearancetTable">
                      <thead class="table-light">
                          <tr>
                              <th Width="25%">Company Name</th>
                              <th Width="25%">Period From - To</th>
                              <th Width="25%">Position</th>
                              <th Width="25%">Responsibilities</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php foreach($works as $work):?>
                          <tr>
                              <td><?php echo $work->company_name	;?></td>
                              <td><?php echo $work->work_from.'   -   '.$work->work_to;?></td>
                              <td><?php echo $work->position;?>
                              <td><?php echo $work->responsibilities;?></td>
                          </tr>
                          <?php endforeach;?>
                      </tbody>
                    </table>
                    <div class="section">
                    <strong>Employee Acknowledgment:</strong>
                    <p>
                    I declare that the information given by me in this form is to the best of my knowledge, complete and correct.


                    </p>

                    <div class="d-flex justify-content-between mt-4">
                      <div>
                        <label><strong>Candidate Signature:</strong></label><br/><br/><br/>
                        <label><?php echo $record->applicant_name; ?></label>
                        <!-- <div class="signature-line"><img width="50%" src="<?php echo base_url().'public/uploded_documents/'.$record->candidate_sign;?>" /></div> -->
                      </div>
                      <div><br/><br/><br/>
                        <label><strong>Date:</strong> <?php echo $record->application_date; ?></label>
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