<?php foreach ($comapny_records as $row) {
    $company_name = $row->company_name;
    $company_address = $row->company_address;
    $company_city = $row->company_city;
    $company_pincode = $row->company_pincode;
    $company_country = $row->company_country;
    $company_email_id = $row->company_email_id;
    $company_telephone = $row->company_telephone;
    $company_website = $row->company_website;
}
foreach ($user_records as $r) {
    $user_name = $r->user_name;
    $user_code = $r->user_code;
    $designation_name = $r->designation_name;
    $joining_date = date('d-M-Y', strtotime($r->joining_date));
    $last_working_date = date('d-M-Y', strtotime($r->last_working_date));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experience Certificate</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;

        }


        header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 15px;
        }

        .company-details {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        .company-details p {
            margin: 4px 0;
            font-weight: normal;
        }

        .certificate-header {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #2C3E50;
        }

        .certificate-body {
            font-size: 14px;
            margin: 20px 0;
            color: #555;
        }

        .certificate-body p {
            margin: 12px 0;
            line-height: 1.8;
        }

        .certificate-body ul {
            margin: 12px 0;
            padding-left: 20px;
        }

        .certificate-body ul li {
            margin: 6px 0;
        }

        .signature {
            text-align: right;
            margin-top: 40px;
            font-size: 14px;
            color: #555;
        }

        .signature p {
            margin: 4px 0;
        }

   
        @media screen and (max-width: 768px) {
        

            .logo {
                width: 150px;
            }

            .certificate-header {
                font-size: 20px;
            }

            .certificate-body {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

       
        <header>
            <img src="<?php echo base_url() . 'public/logo/logo.png' ?>" alt="<?php echo $company_name ?>" class="logo">
            <div class="company-details">
                <p><strong>
                        <?php echo $company_name ?>
                    </strong></p>
                <p>
                    <?php echo $company_address . ', ' . $company_city . ', ' . $company_country . ' - ' . $company_pincode; ?>
                </p>
                <p>Phone:
                    <?php echo $company_telephone ?> | Email:
                    <?php echo $company_email_id ?>
                </p>
                <p>Website:
                    <?php echo $company_website ?>
                </p>
            </div>
        </header>

    
        <div class="certificate-header">
            <p>EXPERIENCE CERTIFICATE</p>
            <p>Date:
                <?php echo date('d-M-Y'); ?>
            </p>
        </div>

       
        <div class="certificate-body">
            <p>To Whom It May Concern,</p>
            <p>This is to certify that <strong>
                    <?php echo $user_name ?>
                </strong>, holding the position of <strong>
                    <?php echo $designation_name ?>
                </strong>, was employed with <strong>
                    <?php echo $company_name ?>
                </strong> from <strong>
                    <?php echo $joining_date ?>
                </strong> to <strong>
                    <?php echo $last_working_date ?>
                </strong>.

                During the tenure of employment,</p>
            <p><strong>
                    <?php echo $user_name ?>
                </strong> was an integral part of our team, contributing significantly to various projects. His key
                responsibilities included:</p>

            <ul>
                <li>Designing and developing software applications.</li>
                <li>Leading a team of developers in project execution.</li>
                <li>Coordinating with cross-functional teams for feature integration.</li>
                <li>Resolving complex technical issues and providing solutions.</li>
            </ul>

            <p><strong>
                    <?php echo $user_name ?>
                </strong> demonstrated excellent technical skills, leadership, and dedication. He was a reliable and
                valued member of our team.</p>
            <p>We wish him the best in his future endeavors. For further inquiries, feel free to contact us at <strong>
                    <?php echo $company_email_id ?>
                </strong> or call <strong>
                    <?php echo $company_telephone ?>
                </strong>.</p>
        </div>

       

        <div class="signature">
            <p>Sincerely,</p>
            <p><strong>
                    <p>Signature</p>
                </strong></p>
            <p>HR Manager</p>
            <p>
                <?php echo $company_name ?>
            </p>
        </div>


        <footer>
            <table border=0 width='90%' style=" margin-top: 40px;">
                <tr>
                    <td width="100%" align="center">
                        <img src="<?php echo base_url() . 'public/logo/footer1.png' ?>" alt='logo.png'>
                    </td>
                </tr>
            </table>
            <p style="  text-align: center;font-size: 12px;  color: #888;">©
                <?php echo date('Y'); ?>
                <?php echo $company_name ?>. All Rights Reserved.
            </p>
        </footer>

    </div>

</body>

</html>