<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employment Offer Letter</title>
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
        /* .container1 {
            padding-bottom: 128px; 
        } */
    @page {
        margin: 20mm;
        font-size:10px;
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

    .container {
      padding: 30px;
      position: relative;
      z-index: 1;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-title {
      font-weight: bold;
      font-size: 24px;
      margin-top: 20px;
      margin-bottom: 10px;
    }

    .section-title {
      background: #c10058;
      color: white;
      font-weight: bold;
      padding: 8px;
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

    .sm-table {
      background: transparent;
      position: relative;
      z-index: 1;
      margin-bottom: 100px;
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
    }

    @media print {
      body {
        margin-bottom: 100px;
      }

      .footer {
        position: fixed;
        bottom: 0;
        page-break-after: avoid;
      }

      
    }
    .noborders{
       border-color: transparent;
        border-bottom-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
    }
    .photo-box {
      width: 120px;
      height: 120px;
      border: 2px solid #800040;
      float: right;
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
                <h4 style="vertical-align: middle;width:100%;">Employment Joining Form</h4>
                <div class="photo-box "></div>
            </td>
        </tr>
        <tr>
            <td style="border: none !important;">
                
                  <div class="container1 page p-6">
                    
                    
                    <?php if(!empty($records)) {

                        $record = $records[0];//print_r($record);print_r($pass[0]);print_r($visa[0]);
                        $passport_document_number = '';
                        $passport_expiry = '';
                        if(!empty($pass)){
                          $passport_details = $pass[0];
                          $passport_document_number = $passport_details->document_number;
                          $passport_expiry = $passport_details->expiry_date;
                        }
                        
                        $visa_num = '';$visa_status = '';$visa_expiry = '';
                        if(!empty($visa)){
                          $visa_details = $visa[0];  
                          $visa_num = $visa_details->posession;
                          $visa_status = $visa_details->status;
                          $visa_expiry = $visa_details->expiry_date;
                        }
                          
                        $emirate_number = '';
                        $emirate_expiry = '';
                        
                        if(!empty($emirates)){
                          $emirate = $emirates[0];
                          $emirate_number = $emirate->document_number;
                          $emirate_expiry = $emirate->expiry_date;
                        }
                         
                        $prefix = "";
                        if($record->gender == 'Male'){
                          $prefix =  "Mr." ;
                        }
                        else{
                          if($record->maritial_status == 'Married')
                            $prefix =  "Mrs.";
                          else
                            $prefix =  "Ms.";
                        }
                        $manager_name = '';
                        if(!empty($manager_details)){
                          $manager_name = $manager_details[0]->user_name.' '.$manager_details[0]->last_name;
                        }
                      
                        ?>
                        <div class="section-title">Personal Profile</div>
                        <table>
                            <tr><td width="30%">Prefix</td><td width="20%"><?php echo $prefix; ?></td><td width="30%">Residential address UAE</td><td width="20%"><?php echo $record->address?></td></tr>
                            <tr><td width="30%">First Name</td><td width="20%"><?php echo $record->user_name?></td><td width="30%">Address line 2</td><td width="20%"></td></tr>
                            <tr><td width="30%">Middle Name</td><td width="20%"><?php echo $record->middle_name?></td><td width="30%">City and State</td><td width="20%"><?php echo $record->city.' '.$record->state?></td></tr>
                            <tr><td width="30%">Last Name</td><td width="20%"><?php echo $record->last_name?></td><td width="30%">Zip code</td><td width="20%"><?php echo $record->zip_code?></td></tr>
                            <tr><td>Date of Birth</td><td><?php echo $record->bdate;?></td><td>Country</td><td><?php echo $record->country;?></td></tr>
                            <tr><td width="30%">Gender</td><td width="20%"><?php echo $record->gender;?></td><td width="30%">Permanent Address In-Home Country</td><td width="20%"><?php echo $record->p_address;?></td></tr>
                            <tr><td width="30%">Contact Number</td><td width="20%"><?php echo $record->contact_no;?></td><td width="30%">Address line 2</td><td width="20%"></td></tr>
                            <tr><td width="30%">Email Address</td><td width="20%"><?php echo $record->email_id;?></td><td width="30%">City and State</td><td width="20%"><?php echo $record->p_city;?> <?php echo $record->state;?></td></tr>
                            <tr><td width="30%">Marital Status</td><td width="20%"><?= $record->maritial_status === 'Single' ? '☑' : '☐' ?> Single
                            <?=  $record->maritial_status  === 'Married' ? '☑' : '☐' ?> Married</td><td width="30%">Zip Code</td><td width="20%"><?php echo $record->p_zip_code;?></td></tr>
                            <tr><td width="30%">Nationality</td><td width="20%"><?php echo $record->nationality;?></td><td width="30%">Country</td><td width="20%"><?php echo $record->nationality;?></td></tr>
                            <tr><td width="30%">Passport No</td><td width="20%"><?php echo $passport_document_number;?></td><td width="30%">Expiry</td><td width="30%"><?php echo $passport_expiry;?></td></tr>
                            <tr><td width="30%">Emirates ID Number <br>(If Applicable)</td><td width="20%"><?php echo $emirate_number;?></td><td width="30%">Expiry</td><td width="20%"><?php echo $emirate_expiry;?></td></tr>
                            <tr><td width="30%">Visa Type<br><small>(Employment, Freelance, Family)</small></td><td width="20%"><?php echo $visa_num;?></td><td width="30%">Current Visa Status</td><td width="20%"><?php echo $visa_status;?></td></tr>
                            <tr><td width="30%">Driving License</td><td width="20%"><?php //echo $emirate->document_name;?></td><td width="30%">Date of Visa Expiry</td><td width="20%"><?php echo $visa_expiry;?></td></tr>
                            <tr><td width="30%">Years of Experience</td><td width="20%"><?php echo $record->exp_years;?></td><td width="30%">Relevant Experience</td><td width="20%"></td></tr>
                            <tr><td width="30%" >Skills</td><td colspan="3"><?php echo $record->skills;?></td></tr>
                            <tr><td width="30%" >Languages Known</td><td colspan="3"><?php echo $record->language;?></td></tr>
                        </table>

                        <div class="section-title">Emergency Contact Details </div>
                        <table>
                            <tr><td width="40%">Name of Emergency Contact Person</td><td><?php echo $record->contact_name;?></td></tr>
                            <tr><td width="40%">Relationship</td><td><?php echo $record->contact_relation;?></td></tr>
                            <tr><td width="40%">Contact Number</td><td><?php echo $record->contact_emirat;?></td></tr>
                            <tr><td width="40%">Alternate Contact Number</td><td><?php echo $record->contact_no2;?></td></tr>
                            <tr><td width="40%">Email Address</td><td><?php echo $record->email_id;?></td></tr>
                            <tr><td width="40%">Address</td><td><?php echo $record->contact_address;?></td></tr>
                            <tr><td width="40%">Address 2</td><td></td></tr>
                            <tr><td width="40%">City / State</td><td><?php echo $record->contact_city;?></td></tr>
                        </table>

                        <div class="section-title">Employment Details <span style="font-size:10px;">(to be filled by HR)</span></div>
                        <table>
                            <tr><td width="40%">Designation</td><td><?php echo $record->designation_name;?></td></tr>
                            <tr><td width="40%">Department</td><td><?php echo $record->dept_name;?></td></tr>
                            <tr><td width="40%">Date of Joining</td><td><?php echo $record->joining_date;?></td></tr>
                            <tr><td width="40%">Employee ID</td><td><?php echo $record->user_code;?></td></tr>
                            <tr><td width="40%">Employment Type</td><td><?php echo $record->emp_type;?></td></tr>
                            <tr><td width="40%">Reporting Manager</td><td><?php echo $manager_name?></td></tr>
                            <tr><td width="40%">Probation Period</td><td>from - <?php echo $record->start_probation;?> To - <?php echo $record->end_probation;?></td></tr>
                            <tr><td width="40%">Work Location</td><td><?php echo $record->work_loc;?></td></tr>
                        </table>

                        <div class="section-title">Educational Background</div>
                        <table>
                            <tr><td width="30%">Highest Qualification</td><td width="20%"><?php echo $record->high_degree;?></td><td width="20%">Institution Name</td><td width="20%"><?php echo $record->institute_name;?></td></tr>
                            <tr><td width="40%">Year of Passing</td><td><?php echo $record->year_passing;?></td><td width="20%">Specialization</td><td width="20%"><?php echo $record->specialization;?></td></tr>
                        </table>

                        <div class="section-title">previous Employment Details</div>
                        <table>
                            <tr><td width="40%">Last Company Name</td><td><?php echo $record->last_company; ?></td></tr>
                            <tr><td width="40%">Designation Held</td><td><?php echo $record->last_desig; ?></td></tr>
                            <tr><td width="40%">Duration of employment</td><td><?php echo $record->working_period; ?></td></tr>
                            <tr><td width="40%">Reason for leaving</td><td><?php echo $record->resig_reason; ?></td></tr>
                            <tr><td width="40%">Referance Contact</td><td><?php echo $record->ref_contact; ?></td></tr>
                        </table>

                        <div class="section-title">Banking Information Details</div>
                            <table>
                                <tr><td width="40%">Bank Name</td><td><?php echo $record->bank_name; ?></td></tr>
                                <tr><td width="40%">Account Number</td><td><?php echo $record->acc_no; ?></td></tr>
                                <tr><td width="40%">IBAN Number</td><td><?php echo $record->iban_no; ?></td></tr>
                                <tr><td width="40%">Bank Branch</td><td><?php echo $record->branch_name; ?></td></tr>
                            </table>
                    

                    
                    <p>Declarations</p>
                    <p>I hereby declare that the information provided above is true and correct to the best of my knowledge. I understand that any false information provided can lead to termination of employment.</p>
                    
                    <span>Employee Name and Signature</span><span style="float:right;">Date</span>
                    <hr>
                    <span>HR</span>
                    <br/><br/><span>Signature</span>
                    <?php }else{?>
                      <div class="section-title">Personal Profile</div>
                        <table>
                            <tr><td width="30%">Prefix</td><td width="20%"></td><td width="30%">Residential address UAE</td><td width="20%"></td></tr>
                            <tr><td width="30%">First Name</td><td width="20%"></td><td width="30%">Address line 2</td><td width="20%"></td></tr>
                            <tr><td width="30%">Middle Name</td><td width="20%"></td><td width="30%">City and State</td><td width="20%"></td></tr>
                            <tr><td width="30%">Last Name</td><td width="20%"></td><td width="30%">Zip code</td><td width="20%"></td></tr>
                            <tr><td>Date of Birth</td><td></td><td>Country</td><td></td></tr>
                            <tr><td width="30%">Gender</td><td width="20%"></td><td width="30%">Permanent Address In-Home Country</td><td width="20%"></td></tr>
                            <tr><td width="30%">Contact Number</td><td width="20%"></td><td width="30%">Address line 2</td><td width="20%"></td></tr>
                            <tr><td width="30%">Email Address</td><td width="20%"></td><td width="30%">City and State</td><td width="20%"></td></tr>
                            <tr><td width="30%">Marital Status</td><td width="20%">Single  ☐ Married ☐ </td><td width="30%">Zip Code</td><td width="20%"></td></tr>
                            <tr><td width="30%">Nationality</td><td width="20%"></td><td width="30%">Country</td><td width="20%"></td></tr>
                            <tr><td width="30%">Passport No</td><td width="20%"></td><td width="30%">Expiry</td><td width="30%"></td></tr>
                            <tr><td width="30%">Emirates ID Number <br>(If Applicable)</td><td width="20%"></td><td width="30%">Expiry</td><td width="20%"></td></tr>
                            <tr><td width="30%">Visa Type<br><small>(Employment, Freelance, Family)</small></td><td width="20%"></td><td width="30%">Current Visa Status</td><td width="20%"></td></tr>
                            <tr><td width="30%">Driving License</td><td width="20%"></td><td width="30%">Date of Visa Expiry</td><td width="20%"></td></tr>
                            <tr><td width="30%">Years of Experience</td><td width="20%"></td><td width="30%">Relevant Experience</td><td width="20%"></td></tr>
                            <tr><td width="30%" colspan="4">Skills</td></tr>
                            <tr><td width="30%" colspan="4">Languages Known</td></tr>
                        </table>

                        <div class="section-title">Emergency Contact Details </div>
                        <table>
                            <tr><td width="40%">Name of Emergency Contact Person</td><td></td></tr>
                            <tr><td width="40%">Relationship</td><td></td></tr>
                            <tr><td width="40%">Contact Number</td><td></td></tr>
                            <tr><td width="40%">Alternate Contact Number</td><td></td></tr>
                            <tr><td width="40%">Email Address</td><td></td></tr>
                            <tr><td width="40%">Address</td><td></td></tr>
                            <tr><td width="40%">Address 2</td><td></td></tr>
                            <tr><td width="40%">City / State</td><td></td></tr>
                        </table>

                        <div class="section-title">Employment Details <span style="font-size:10px;">(to be filled by HR)</span></div>
                        <table>
                            <tr><td width="40%">Designation</td><td></td></tr>
                            <tr><td width="40%">Department</td><td></td></tr>
                            <tr><td width="40%">Date of Joining</td><td></td></tr>
                            <tr><td width="40%">Employee ID</td><td></td></tr>
                            <tr><td width="40%">Employment Type</td><td></td></tr>
                            <tr><td width="40%">Reporting Manager</td><td></td></tr>
                            <tr><td width="40%">Probation Period</td><td></td></tr>
                            <tr><td width="40%">Work Location</td><td></td></tr>
                        </table>

                        <div class="section-title">Educational Background</div>
                        <table>
                            <tr><td width="30%">Highest Qualification</td><td width="20%"></td><td width="20%">Institution Name</td><td width="20%"></td></tr>
                            <tr><td width="40%">Year of Passing</td><td></td><td width="20%">Specialization</td><td width="20%"></td></tr>
                        </table>

                        <div class="section-title">previous Employment Details</div>
                        <table>
                            <tr><td width="40%">Last Company Name</td><td></td></tr>
                            <tr><td width="40%">Designation Held</td><td></td></tr>
                            <tr><td width="40%">Duration of employment</td><td></td></tr>
                            <tr><td width="40%">Reason for leaving</td><td></td></tr>
                            <tr><td width="40%">Referance Contact</td><td></td></tr>
                        </table>

                        <div class="section-title">Banking Information Details</div>
                            <table>
                                <tr><td width="40%">Bank Name</td><td></td></tr>
                                <tr><td width="40%">Account Number</td><td></td></tr>
                                <tr><td width="40%">IBAN Number</td><td></td></tr>
                                <tr><td width="40%">Bank Branch</td><td></td></tr>
                            </table>
                    

                    
                    <p>Declarations</p>
                    <p>I hereby declare that the information provided above is true and correct to the best of my knowledge. I understand that any false information provided can lead to termination of employment.</p>
                    
                    <span>Employee Name and Signature</span><span style="float:right;">Date</span>
                    <hr>
                    <span>HR</span>
                    <br/><br/><span>Signature</span>
                   <?php } ?>
                  </div>
                  
                <!-- </div> -->
                <!-- <div class="page-break"></div> -->
                
                
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