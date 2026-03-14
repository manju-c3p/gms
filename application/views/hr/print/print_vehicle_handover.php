<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Vehicle HandOver Form</title>
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
        margin: 10mm
        /* margin-bottom: 128px; */
        }

    @media print {
        thead {display: table-header-group;} 
        tfoot {display: table-footer-group;}
        
        button {display: none;}
        
        body {margin: 0;font-size:13px;}
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
        /* margin-bottom: 100px; */
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
                <h4 style="vertical-align: middle;width:100%;">Vehicle HandOver Form</h4>
            </td>
        </tr>
        <tr>
          <td style="border: none !important;">
              
                <div class="container1 page p-6">
                  
                  <?php if(!empty($record)){ ?>
                    
                    <table class="table table-bordered" >
                      <tbody>
                          <tr>
                              <td><strong>Driver Name :</strong><?php echo $record->user_name.' '.$record->middle_name.' '.$record->last_name;?></td>
                              <td><strong>Licence Plate :</strong><?php echo $record->licence_plate; ?></td>
                          </tr>
                          <tr>
                              <td><strong>Vehicle Model :</strong><?php echo $record->vehicle_model; ?></td>
                              <td><strong>Date of HandOver : </strong><?php echo $record->handover_date; ?></td>
                          </tr>
                          <tr>
                              <td colspan='2'><strong>Key Points:</strong></td>
                          </tr>
                          <tr>
                              <td colspan='2'><ul>
                                <li><strong>Authorized Use:</strong> Business use only, personal use requires approval.</li>
                                <li><strong>Traffic Laws:</strong> Drivers are responsible for fines and must report violations or accidents immediately.</li>
                                <li><strong>Vehicle Care:</strong> Perform basic checks before use, maintain the vehicle properly, and report issues promptly. Handle the vehicle safely.</li>
                                <li><strong>Fuel Use:</strong> Use the company fuel card for refueling during work hours.</li>
                                <li><strong>Return Condition:</strong> Return the vehicle in good condition, with all documents and keys.</li>
                              </ul>
                            </td>
                          </tr>
                          <tr>
                              <td colspan='2'><strong>Vehicle Condition (Inspection Notes):</strong></td>
                          </tr>
                          <tr>
                            <td colspan='2'><ul>
                              <li><strong>Exterior:</strong> <?php echo $record->exterior; ?></li>
                              <li><strong>Interior:</strong> <?php echo $record->interior; ?></li>
                              <li><strong>Pre-existing Damages (if any):</strong> <?php echo $record->pre_damages; ?></li>
                              <li><strong>Additional Comments:</strong> <?php echo $record->comments; ?></li>
                            </ul>
                          </td>
                        </tr>
                        <tr>
                              <td colspan='2'><strong>Documents Handover:</strong></td>
                        </tr>
                        <tr>
                          <td colspan='2'>
                            <?php 
                            $checked1="";$checked2="";$checked3="";
                            if($record->vehicle_key == 'yes')
                              $checked1="checked";?>
                            <label><input type="checkbox" name="vehicle_key" <?php echo $checked1;?>> Vehicle Key</label>
  
                            <?php if($record->mulkiya == 'yes')
                                $checked2="checked";?>
                            <label><input type="checkbox" name="mulkiya" <?php echo $checked2;?>> Mulkiya</label>
  
                            <?php if($record->vehicle_logbook == 'yes')
                                $checked3="checked";?>
                            <label><input type="checkbox" name="vehicle_logbook" <?php echo $checked3;?>> Vehicle logbook</label>

                          </td>
                        </tr>
                        
                      </tbody>
                    </table>
                    
                     <div class="section">
                        <strong>Acknowledgment:</strong>
                        <p>
                        I acknowledge receipt of the vehicle and agree to maintain it in good condition. I accept responsibility for its use and will report any issues or damages immediately. I also agree to comply with company policies and understand that any fines or damages incurred will be deducted from my salary.
                        </p>
                       
                        <div class="d-flex justify-content-between mt-2">
                          <div>
                            <label><strong>Driver Signature :</strong></label> <br/><br/> 
                            <div class="signature-line"></div>
                          </div>
                          <div>
                          <br/><br/> <label><strong>Date:</strong> ___/___/______</label>
                          </div>
                        </div>
                      </div>
                     
                      <div class="section1">
                        <strong>HR Department Acknowledgment:</strong>
                        <table class="table table-borderless mt-3">
                          <tbody>
                            <tr>
                              <td style="width: 150px;">Inspected By</td>
                              <td>:</td>
                              <td><?php echo $record->inspector_name.' '.$record->inspector_middle_name.' '.$record->inspector_last_name;?></td>
                            </tr>
                            <tr>
                              <td>HR & Admin</td>
                              <td>:</td>
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