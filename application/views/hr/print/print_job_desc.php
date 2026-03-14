<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Description - Financial Accountant</title>
  <style>
    body {
      margin: 40px;
      font-family: Arial, sans-serif;
    }

    .container {
      width: 80%;
      margin: auto;
      padding: 20px;
    }

    h2,
    h3 {
      color: #333;
    }

    ul {
      list-style-type: square;
    }

    .logo {
      text-align: left; /* center logo */
      margin-bottom: 20px;
    }

    .logo img {
      width: 160px; /* increase size */
      height: auto; /* keep proportions */
    }
  </style>
</head>

<body onload="window.print();">

  <div class="container">
    <div class="logo">
      <img src="<?php echo base_url();?>public/logo/logo.png" alt="Hundred Media Logo">
    </div>

    <?php if(!empty($records)){ ?>
        <br>
      <h2 style="text-align:center;">Job Description</h2>
      <p><strong>Name:</strong> <?php echo $records->user_name;?></p>
      <p><strong>Job Title:</strong> <?php echo $records->designation_name;?></p>
      <p><strong>Departments:</strong> <?php echo $records->dept_name;?></p>
      <p><strong>Reports to:</strong> <?php echo $records->hr_name;?> (<?php echo $records->hr_dept;?>)</p>
      <p><strong>Budgeted Salary:</strong> <?php echo $records->budgeted_salary;?></p>

      <h3>Job Summary:</h3>
      <p><?php echo $records->job_desc;?></p>

      <h3>Preferred Qualification / Experience:</h3>
      <?php if ($records->preferred_qualification) {
          $text_content = nl2br(htmlspecialchars($records->preferred_qualification));
          $lines = explode("<br />", $text_content);
          echo "<ul>";
          foreach ($lines as $line) {
              if (!empty(trim($line))) {
                  echo "<li>" . trim($line) . "</li>";
              }
          }
          echo "</ul>";
      } ?>
      
      <h3>Roles and Responsibilities:</h3>
      <?php if ($records->roles_responsibilities) {
          $text_content1 = nl2br(htmlspecialchars($records->roles_responsibilities));
          $lines1 = explode("<br />", $text_content1);
          echo "<ul>";
          foreach ($lines1 as $line) {
              if (!empty(trim($line))) {
                  echo "<li>" . trim($line) . "</li>";
              }
          }
          echo "</ul>";
      } ?>
    <?php } ?>
  </div>
</body>

</html>
