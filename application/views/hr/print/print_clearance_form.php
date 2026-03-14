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
        /* .container1 {
            padding-bottom: 128px; /* or more if needed */
        } */
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
                <h4 style="vertical-align: middle;width:100%;">Clearance Form</h4>
            </td>
        </tr>
        <tr>
          <td style="border: none !important;">
              
                <div class="container1 page p-6">
                  
                  <?php if(!empty($records)){ 
                    // $manager_name = '';
                    // if(!empty($manager_details)){
                    //   $manager_name = $manager_details[0]->user_name.' '.$manager_details[0]->last_name;
                    // }
                    $emirate_number = '';$emirate_expiry ="";
                    if(!empty($emirates)){
                      $emirate = $emirates[0];
                      $emirate_number = $emirate->document_number;
                      $emirate_expiry = $emirate->expiry_date;
                    }
                    $passport_document_number = '';
                    if(!empty($passport)){
                      $passport_details = $passport[0];
                      $passport_document_number = $passport_details->document_number;
                    }
                    $visa_document_number = '';$visa_expiry = "";
                    if(!empty($visa)){
                      $visa_details = $visa[0];
                      $visa_document_number = $visa_details->posession;
                      $visa_expiry = $visa_details->expiry_date;
                    }
                    ?>
                    <table class="table table-bordered" >
                      <tbody>
                          <tr>
                              <td><strong>Name :</strong><?php echo $records->user_name.' '.$records->middle_name.' '.$records->last_name;?></td>
                              <td><strong>Date of Resignation :</strong><?php echo $records->resignation_date; ?></td>
                          </tr>
                          <tr>
                              <td><strong>Emp. ID :</strong><?php echo $records->user_code; ?></td>
                              <td><strong>Date of Relieving : </strong><?php echo $records->relieving_date; ?></td>
                          </tr>
                          <tr>
                              <td><strong>Department : </strong><?php echo $records->dept_name; ?></td>
                              <td><strong>DOB : </strong><?php echo $records->bdate;?></td>
                          </tr>
                          <tr>
                              <td><strong>Designation : </strong><?php echo $records->designation_name;?></td>
                              <td><strong>Passport No :</strong> <?php echo $passport_document_number;?></td>
                          </tr>
                          <tr>
                              <td><strong>DOJ : </strong><?php echo $records->joining_date;?></td>
                              <td><strong>EID : </strong><?php echo $emirate_number;?> Expiry: <?php echo $emirate_expiry;?></td>
                          </tr>
                          <tr>
                              <td><strong>Visa Status :</strong> <?php echo $visa_document_number;?> Expiry: <?php echo $visa_expiry;?></td>
                              <td><strong>Notice Period Days : </strong><?php echo $records->notice_period_in_days;?></td>
                          </tr>
                      </tbody>
                    </table>
                    <table class="table table-bordered" id="clearancetTable">
                      <thead class="table-light">
                          <tr>
                              <th>Sl No</th>
                              <th>Department</th>
                              <th>Activity</th>
                              <th>Status</th>
                              <th>Signature</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $count = 1;foreach($record1 as $row):?>
                          <tr>
                              <td><?php echo $count;?></td>
                              <td><?php echo $row->dept_name;?></td>
                              <td><?php echo $row->activity;?></td>
                              <td><?php if($row->status == 0) 
                                          echo "pending";
                                        else if($row->status == 1)
                                          echo "Approved";
                                        else if($row->status == 2)
                                          echo "Not Approved";?>
                              </td>
                              <td></td>
                          </tr>
                          <?php  $count++; endforeach;?>
                      </tbody>
                    </table>
                    <div class="section">
                    <strong>Employee Acknowledgment:</strong>
                    <p>
                      I, the undersigned, confirm that I have returned all company property and cleared all dues. 
                      I understand that my final settlement will be processed once the clearance is completed.
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
                  </div>

                  <div class="section1">
                    <strong>HR Department Acknowledgment:</strong>
                    <table class="table table-borderless mt-3">
                      <tbody>
                        <tr>
                          <td style="width: 150px;">HR</td>
                          <td>:</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>Signature</td>
                          <td>:</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
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