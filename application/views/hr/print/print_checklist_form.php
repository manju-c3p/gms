<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Checklist Form</title>
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

    td, th {
      border: 1px solid #aaa;
      padding: 8px;
      vertical-align: top;
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
                <h4 style="vertical-align: middle;width:100%;">Checklist Form</h4>
            </td>
        </tr>
        <tr>
            <td style="border: none !important;">
                
                  <div class="container1 page p-6">
                    
                    <?php if(!empty($records)){ 
                      $manager_name = '';
                      if(!empty($manager_details)){
                        $manager_name = $manager_details[0]->user_name.' '.$manager_details[0]->last_name;
                      }
                      $emirate_number = '';
                      if(!empty($emirates)){
                        $emirate = $emirates[0];
                        $emirate_number = $emirate->document_number;
                      }
                      $passport_document_number = '';
                      if(!empty($passport)){
                        $passport_details = $passport[0];
                        $passport_document_number = $passport_details->document_number;
                      }
                      ?>
                      <!-- Employee Details -->
                      <div class="row g-3 mb-4">
                        <div class="col-md-6">
                          <strong>Name:</strong> <?php echo $records->user_name.' '.$records->middle_name.' '.$records->last_name;?>
                        </div>
                        <div class="col-md-6">
                          <strong>Interview Date:</strong> <?php echo $records->interview_date;?>
                        </div>
                        <div class="col-md-6">
                          <strong>Emp. ID:</strong> <?php echo $records->user_code;?>
                        </div>
                        <div class="col-md-6">
                          <strong>Phone Number:</strong> <?php echo $records->contact_no;?>
                        </div>
                        <div class="col-md-6">
                          <strong>Department:</strong> <?php echo $records->dept_name;?>
                        </div>
                        <div class="col-md-6">
                          <strong>DOB:</strong> <?php echo $records->bdate;?>
                        </div>
                        <div class="col-md-6">
                          <strong>Designation:</strong> <?php echo $records->designation_name;?>
                        </div>
                        <div class="col-md-6">
                          <strong>Passport No:</strong> <?php echo $passport_document_number;?>
                        </div>
                        <div class="col-md-6">
                          <strong>DOJ:</strong> <?php echo $records->joining_date;?>
                        </div>
                        <div class="col-md-6">
                          <strong>EID:</strong> <?php echo $emirate_number;?>
                        </div>
                        <div class="col-md-6">
                          <strong>Email ID:</strong> <?php echo $records->email_id;?>
                        </div>
                        <div class="col-md-6">
                          <strong>HOD:</strong> <?php echo $manager_name;?>
                        </div>

                        <table class="table table-bordered">
                          <thead class="table-secondary">
                            <tr>
                              <th style="width: 5%;">S No</th>
                              <th style="width: 60%;">Description</th>
                              <th style="width: 15%;">Yes</th>
                              <th style="width: 15%;">No</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                            
                            // This maps your DB keys to display labels
                            $checklist_items = [
                              "application_form" => "Application Form",
                              "interview_form" => "Interview Assessment Form",
                              "joining_form" => "Joining Form",
                              "cv" => "Curriculum Vitae",
                              "passport_copy" => "Passport Copy",
                              "photo_copy" => "Photo Copy",
                              "offer_letter" => "Offer Letter",
                              "contract_form" => "Contract Form",
                              "insurance_form" => "Insurance Form",
                              "labor_payment_form" => "Labor Payment Form",
                              "medical_fit_certificate" => "Medical Fit Certificate",
                              "emirates_id" => "Emirates ID",
                              "visa_copy" => "Visa Copy",
                              "iloe_insurance" => "ILOE Insurance",
                              "labor_card" => "Labor Card",
                              "degree_certificate" => "Degree Certificate with Attestation",
                              "induction" => "Induction",
                              "job_description" => "Job Description",
                              "driving_license" => "Driving License"
                            ];

                            $i = 1;
                            foreach ($checklist_items as $field => $label) {
                              // Get value from object
                              $status = strtolower($records->$field ?? 'no'); // Use strtolower just in case
                              $yes = $status === 'yes' ? '✔️' : '';
                              $no = $status === 'no' ? '❌' : '';
                              echo "<tr>
                                      <td>{$i}</td>
                                      <td class='text-start'>{$label}</td>
                                      <td>{$yes}</td>
                                      <td>{$no}</td>
                                    </tr>";
                              $i++;
                            }
                            
                            ?>

                            
                          </tbody>
                        </table>
                      </div>
                    <?php }else {?>
                        <!-- Employee Details -->
                      <div class="row g-3 mb-4">
                        <div class="col-md-6">
                          <strong>Name:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>Interview Date:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>Emp. ID:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>Phone Number:</strong>
                        </div>
                        <div class="col-md-6">
                          <strong>Department:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>DOB:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>Designation:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>Passport No:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>DOJ:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>EID:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>Email ID:</strong> 
                        </div>
                        <div class="col-md-6">
                          <strong>HOD:</strong> 
                        </div>

                        <table class="table table-bordered">
                          <thead class="table-secondary">
                            <tr>
                              <th style="width: 5%;">S No</th>
                              <th style="width: 60%;">Description</th>
                              <th style="width: 15%;">Yes</th>
                              <th style="width: 15%;">No</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                            
                            // This maps your DB keys to display labels
                            $checklist_items = [
                              "application_form" => "Application Form",
                              "interview_form" => "Interview Assessment Form",
                              "joining_form" => "Joining Form",
                              "cv" => "Curriculum Vitae",
                              "passport_copy" => "Passport Copy",
                              "photo_copy" => "Photo Copy",
                              "offer_letter" => "Offer Letter",
                              "contract_form" => "Contract Form",
                              "insurance_form" => "Insurance Form",
                              "labor_payment_form" => "Labor Payment Form",
                              "medical_fit_certificate" => "Medical Fit Certificate",
                              "emirates_id" => "Emirates ID",
                              "visa_copy" => "Visa Copy",
                              "iloe_insurance" => "ILOE Insurance",
                              "labor_card" => "Labor Card",
                              "degree_certificate" => "Degree Certificate with Attestation",
                              "induction" => "Induction",
                              "job_description" => "Job Description",
                              "driving_license" => "Driving License"
                            ];

                            $i = 1;
                            foreach ($checklist_items as $field => $label) {
                              
                              echo "<tr>
                                      <td>{$i}</td>
                                      <td class='text-start'>{$label}</td>
                                      <td></td>
                                      <td></td>
                                    </tr>";
                              $i++;
                            }
                            
                            ?>

                            
                          </tbody>
                        </table>
                      </div>
                   <?php } ?>
                  </div>
                  
                <!-- </div> -->
                <!-- <div class="page-break"></div> -->
                
                
                </td>
        </tr>
    </tbody>

    <tfoot style="border-color: white !important;">
      <tr>
        <td style="border:none !important;">
            <div class="page-footer">
            <div class="text-center mb-4">
                <img  src="<?php echo base_url();?>public/logo/print_footer.png" alt="Company Logo" class="logo">
            </div>
            </div>
            </td>
      </tr>
    </tfoot>

  </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>