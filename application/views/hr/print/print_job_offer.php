<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employment Offer Letter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /*@media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                border: none;
            }
            .page-break {
                page-break-before: always;
            }
            .header {
                position: fixed;
                top: 0;
            }
            .footer {
                position: fixed;
                bottom: 0;
            }
            
        }
        .logo {
            max-width: 150px;
            display: block;
        }*/
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
                /* padding-bottom: 15px; /*or more if needed */
            }


            @media print {
                .page-break {
                    page-break-after: always;
                }

                body::before {
                    content: "";
                    background: url('http://localhost/hm/public/logo/print_watermark.png') no-repeat center center;
                    background-size: 80%; /* Adjust size as needed */
                    opacity: 0.2; /* Adjust transparency */
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: -1;
                    mix-blend-mode: multiply;
                }

                
            }

            @page {
            margin: 20mm
            font-size:10px;
            }

            .container1 {
                position: relative;
            }

            .container1::before {
                content: "";
                /* background: url('http://localhost/hm/public/logo/print_watermark.png') no-repeat center center; */
                background-size: 75%;
                opacity: 0.5;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }


            @media print {
                thead {display: table-header-group;} 
                tfoot {display: table-footer-group;}
                
                button {display: none;}
                
                body {margin: 0;}

            }
            @media print {
                
                .sm-table {
                    background: transparent !important;
                    position: relative;
                    z-index: 1 !important; /* make sure it stays above the watermark but below footer */
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
    <table>

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
            <div class="container1 page p-6">
                
                <div class="text-center mb-4">
                    <h5>Employment Offer Letter</h5>
                </div>
                <?php if(!empty($records)) {
                    $manager_name=$records->manager_name.''.$records->middle_name.''.$records->last_name;
                    //$record = $records[0];//print_r($record);?>
                <div class="mb-3 mt-3">
                    <p><strong><?php echo $records->offer_code; ?></strong></p>
                    <p><strong>Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> <?php echo date('Y-M-d');?></p><br/>
                    <p><?php $gender=''; if($records->user_name == 'Male') $gender="Mr";else $gender="Ms";?><?php echo $gender;?> <?php echo $records->user_name; ?></p>
                    <p><strong>Address:</strong> <?php echo $records->employee_address; ?></p>
                    <p>Dear <?php echo $gender;?>. <?php echo $records->user_name; ?>,</p>
                    <p>We are pleased to offer you the position of <strong>(<?php echo $records->designation_name; ?>)</strong> at <strong>Hundred Media Advertising LLC</strong>, based in Dubai, UAE with effect from <strong><?php echo $records->offer_date; ?></strong>.</p>
                    <?php //echo $records->offer_body;?>
                    <p>You will be paid gross emoluments as detailed in <strong>Annexure - A</strong>.</p>
                    <p>Your employment with us will be governed by the terms & conditions as detailed in <strong>Annexure - B</strong>.</p>
                    <p>Your offer has been made based on the information furnished by you. However, if there is a discrepancy in the copies of documents or certificates given by you as proof of the above, we retain the right to review our offer of employment.</p>
                    <p>Employment as per this offer is subject to you being medically fit. Please sign and return a duplicate copy of this letter as a token of your acceptance.</p>
                    <p><em>“We congratulate you on your appointment and wish you a long and successful career with us. We are confident that your contribution will take us further in our journey towards becoming world leaders. We assure you of our support for your professional development and growth.”</em></p>
                    <div class="mt-4">
                    <p>Yours truly,</p>
                    <p><strong>Musammil Ghani</strong></p>
                    <p>CEO & Managing Director</p>
                    </div>
                </div>
                
                <?php } ?>
            </div><br/><br/><br/><br/><br/><br/>
            <!-- <div class="page-break"></div> -->
            <div class="container1 page p-6">
                
                <div class="content">
                    <p><b><u>Annexure - A</u></b></p>
                    <p>Salary Structure :</p>
                    <table class="table table-bordered sm-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Monthly</th>
                                <th>Annual</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($salary as $row):?>
                            <tr>
                                <td><?php echo $row->description;?></td>
                                <td><?php echo $row->monthly;?></td>
                                <td><?php echo $row->annual;?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
<?php if (!empty($incentive) && count($incentive) > 0) { ?>
    <p><b>Incentive Structure</b></p>
    <p>Incentives are based on two performance tiers</p>
    <ul>
        <li><b>3% Incentive:</b> Awarded on all fully paid sales amounts monthly.</li>
        <li><b>Magical Figures:</b> Awarded upon reaching a higher monthly sales target ("Magic Figures").</li>
    </ul>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Case</th>
                <th>Salary</th>
                <th>Target</th>
                <th>Incentive 3%</th>
                <th>Magic Figures</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incentive as $row1): ?>
                <tr>
                    <td><?= htmlspecialchars($row1->sal_case); ?></td>
                    <td style="text-align:left;"><?= number_format($row1->salary, 2); ?></td>
                    <td style="text-align:left;"><?= number_format($row1->target_1, 2); ?></td>
                    <td style="text-align:left;"><?= number_format($row1->incentive_3_percent, 2); ?></td>
                    <td style="text-align:left;"><?= number_format($row1->target_2, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>
                    <p>Other Benefits<p>
                    <p><?php //echo $records->other_benefits;?>
                        <ul>
                            <li><strong>Annual Return Ticket:</strong> You will receive a return ticket to your home country every two years. You will be reimbursed 1200 AED for a round-trip ticket (for each two-year period) or 600 AED for a one-way ticket (each year), after completing 11 months of employment.</li>

                            <li><strong>Visa:</strong> Resident visa will be provided.</li>
                        </ul>
                    </p>
                    
                    <p><b><u>Annexure - B</u></b></p>
                    <?php //echo $records->annexure_b;?>
                    <ol>
                        <li><b>Position and Reporting:</b><br>You will be employed as a Sales Executive and will report to <strong><?php echo $manager_name;?></strong>. Your work location will be based at our office in <?php echo $records->office_address;?>, although occasional travel or remote work may be required, depending on business needs.</li>
                        <li><b>Probation:</b><br/>You will be subject to a probationary period of up to 2-6 months, as per UAE Labor Law, during which either party can terminate the contract with a notice period not less than 30 days, as per Article 43 of the UAE Labor Law. After successful completion of the probationary period, your employment will be confirmed, and you will be entitled to all benefits outlined in this offer. Probation period can be cut short or extended based on your performance and at the discretion of the management.</li>
                        <li><b>Termination:</b><br/>Your employment with the company is "at will" and is not for a specified term. The company or you can terminate the employment by giving a written notice of 30 working days. However, release from the services of the Company will be subject to a satisfactory handover of the responsibilities assigned to you. In the event of gross misconduct or breach of the terms and conditions, the company is entitled to terminate your employment with immediate effect. In this case, the company may offset and/or withhold any payment made or due to you.</li>
                        <li><b>Work Place Ethics:</b><br/>You are required to adhere to the company's Code of Business Conduct (COBC) and comply with all policies and procedures established by the company, in accordance with UAE Labor Law. This includes, but is not limited to, guidelines on dual employment (as per Article 18), insider trading. workplace harassment (covered under Article 88), and maintaining a professional work environment. You will maintain professionalism in the workplace, including appropriate attire, proper use and maintenance of company property, and respectful behavior toward colleagues. Any violations of the company's policies or the UAE Labor Law may result in disciplinary action, as outlined in Article 120 of the UAE Labor Law.</li>
                        <li><b>Conflict of Interest:</b><br/>Your position with the company requires your full-time employment, and you will devote yourself exclusively to the business of the company. You are prohibited from taking up any other work for remuneration (part-time or otherwise), working in an advisory capacity, or being directly or indirectly involved in any other trade or business, without prior written consent from the company, in accordance with Article 18 of the UAE Labor Law. Any conflict of interest, including engaging in external business activities that may interfere with your duties to the company, must be disclosed to the company. Failure to comply may result in disciplinary action, as per the provisions of the UAE Labor Law.</li>
                        <li><b>Secrecy/Confidentiality:</b><br/>During your employment with the company, and at any time thereafter, you will not disclose or divulge any information or knowledge obtained during your employment regarding the company's business or affairs-including developments, processes, reports, and reporting systems-to any person, including competitors and former employees. You may not use this information for your own purposes or for any purpose other than that of the company. You are also required to make your best efforts to prevent others from doing so. Failure to comply may result in legal action against you and the individual to whom the information was disclosed</li>
                        <li><b>Leave:</b><br/>You will be covered by leave, holidays, and the working hour's policy of the Company.<br/>Vacation Planning: Plan your vacations at least one month in advance. All leave requests must be approved by your Department Head and HR.</li>
                        <li><b>Hours of Work:</b><br/>Standard hours are Monday to Saturday, 8:00 AM to 6:00 PM.<br/>Specific work hours apply to non-office locations, warehouse staff are eligible for overtime pay.</li>
                        <li><b>General Conditions:</b><br/>
                            1) Your working hours, weekly off, periods of work, public holidays, leave rules, etc. will be governed by the rules and regulations applicable to the Business unit to which you will be attached.<br/>
                            2) You will be governed by all the company's rules and regulations that are in force now and also those, which may come into, force from time to time even if they are not individually notified to you in writing. The Company has the sole and absolute right to change any of its rules and regulations at any time to meet the exigencies of business.<br/>
                            3) You will be covered by the Employee's Intellectual Property Policy, the Company's Standards of Business Conduct, other policies, procedures, and other rules as applicable from time to time.<br/>

                            4) You will be solely responsible for the safekeeping and return, in condition and order, of all the Company's property that may be in your use, custody or charge.</li>
                        <li><b>Change of terms & conditions:</b><br/>The above terms & conditions of employment are subject to change and you will be communicated as and when the changes are affected.Please confirm that the above terms and conditions are acceptable to you by signing and returning a copy of this letter of appointment.</li>
                    </ol>
                    <hr>
                <p>Acceptance of Offer</p>
                <p>I understand and accept the offer along with the terms and conditions set forth in the letter of appointment, compensation details, and all annexures attached.</p>
                <br/><br/>
                <span>Signature</span>
                <br/><span><?php echo $gender;?>. <?php echo $records->user_name; ?></span><span style="float:right;">Date</span>
                </div>
            </div>
            
            </td>
      </tr>
    </tbody>

    <!-- <tfoot>
      <tr>
        <td>
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