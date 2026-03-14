<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Asset Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    .page-header, .page-header-space {
        height: 100px;
        }

        .page-footer, .page-footer-space {
        /* height: 30px; */

        }

      .page-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        border-top: 1px solid white; 
        background: white; 
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
        margin: 10mm;
        /* margin-bottom: 128px; */
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
      /* margin-bottom: 30px; */
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
      /* margin-bottom: 100px; */
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
        /* margin-bottom: 100px; */
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
                <h4 style="vertical-align: middle;width:100%;">Asset HandOver Form</h4>
            </td>
        </tr>
        <tr>
            <td style="border: none !important;">
                
                  <div class="container1 page p-6">
                    
                    <?php if(!empty($records)){ //print_r($records); ?>
                    <!-- Employee Details -->
                    <div class="mb-4">
                      <h5>Employee Details</h5>
                      <div class="row">
                        <div class="col-md-6"><strong>Name:</strong><?php echo $records->user_name.' '.$records->middle_name.' '.$records->last_name;?> </div>
                        <div class="col-md-6"><strong>Employee ID:</strong> <?php echo $records->user_code;?></div>
                        <div class="col-md-6"><strong>Designation:</strong> <?php echo $records->designation_name;?></div>
                        <div class="col-md-6"><strong>Department:</strong> <?php echo $records->dept_name;?></div>
                      </div>
                    </div>

                    <!-- Asset Table -->
                    <div class="mb-4">
                      <h5>Asset Details</h5>
                      <table class="table table-bordered">
                        <thead class="table-light">
                          <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Serial No./IMEI</th>
                            <th>Issued Date</th>
                            <th>Return Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>SIM Card</td>
                            <td><?php echo $records->sim_description;?></td>
                            <td><?php echo $records->sim_serial_number;?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->sim_issued) ?? '') ?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->sim_return) ?? '') ?></td>
                          </tr>
                          <tr>
                            <td>Laptop</td>
                            <td><?php echo $records->laptop_description?></td>
                            <td><?php echo $records->laptop_serial_number?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->laptop_issued) ?? '') ?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->laptop_return) ?? '') ?></td>
                          </tr>
                          <tr>
                            <td>Mobile</td>
                            <td><?php echo $records->mobile_description?></td>
                            <td><?php echo $records->mobile_serial_number?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->mobile_issued) ?? '') ?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->mobile_return) ?? '') ?></td>
                          </tr>
                          <tr>
                            <td>Vehicle</td>
                            <td><?php echo $records->vehicle_description?></td>
                            <td><?php echo $records->vehicle_serial_number?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->vehicle_issued) ?? '') ?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->vehicle_return) ?? '') ?></td>
                          </tr>
                          <tr>
                            <td>Other</td>
                            <td><?php echo $records->other_description?></td>
                            <td><?php echo $records->other_serial_number?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->other_issued) ?? '') ?></td>
                            <td><?php echo date('Y-m-d', strtotime($records->other_return) ?? '') ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-4">
                      <h5>Terms and Conditions</h5>
                      <ul>
                        <li>The assets are the property of the company and must be used for official purposes only.</li>
                        <li>The employee is responsible for safekeeping and maintenance of the assets.</li>
                        <li>Loss or damage must be reported immediately to HR.</li>
                        <li>All assets must be returned in good condition upon resignation/termination or upon request.</li>
                        <li>Failure to return/damaging the asset may lead to deductions or disciplinary action.</li>
                      </ul>
                    </div>

                    <!-- Acknowledgement -->
                    <div class="mb-4">
                      <h5>Acknowledgement</h5>
                      <p>
                        I, <span id="emp_ack_name"><?php echo $records->user_name.' '.$records->middle_name.' '.$records->last_name; ?></span> , acknowledge the receipt of the above-listed items and agree to the terms and conditions mentioned above.
                      </p>
                    </div>
                   
                    <!-- Signatures -->
                    <div class="d-flex justify-content-between text-center " >
                      <div class="flex-fill">
                        <p><strong>Employee Signature</strong><br><br>____________________<br>Date: ___________</p>
                      </div>
                      <div class="flex-fill">
                        <p><strong>Department Head Signature</strong><br><br>____________________<br>Date: ___________</p>
                      </div>
                      <div class="flex-fill">
                        <p><strong>HR Representative Signature</strong><br><br>____________________<br>Date: ___________</p>
                      </div>
                    </div>
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