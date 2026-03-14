
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
            </td>
        </tr>
        <tr>
            <td style="border: none !important;">

            
                
  <form method="POST" action="<?php echo base_url() . 'index.php/'; ?>Client/add_joining_application" enctype="multipart/form-data">

  <div class="section-title">Personal Profile</div>

  <div class="row mb-3 mt-4">
    <div class="col-md-2">
      <label for="prefix">Prefix<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <select name="prefix" id="prefix" class="form-select" required>
      <option value="">--Select--</option>

      <option value="Mr." <?= ($prefix ?? '') == "Mr." ? "selected" : "" ?>>Mr.</option>
      <option value="Mrs." <?= ($prefix ?? '') == "Mrs." ? "selected" : "" ?>>Mrs.</option>
      <option value="Ms." <?= ($prefix ?? '') == "Ms." ? "selected" : "" ?>>Ms.</option>
    </select>
     </div>
    <div class="col-md-2">
      <label for="address">Residential Address (UAE) <span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <textarea name="address" id="address" class="form-control" required><?= htmlspecialchars($record->address ?? '') ?></textarea>
    </div>
</div>
<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">First Name <span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
      <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($record->first_name ?? '') ?>" required/>
  </div>
      <div class="col-md-2">
      <label for="address2">Address Line 2<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="address2" id="address2" class="form-control" value="<?= htmlspecialchars($record->address2 ?? '') ?>" required/>
    </div>
</div>
<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Middle Name</label>
  </div>
  <div class="col-md-3">
      <input type="text" name="middle_name" class="form-control" value="<?= htmlspecialchars($record->middle_name ?? '') ?>" />
  </div>
      <div class="col-md-2">
      <label for="city_and_state">City and State <span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="city_and_state" id="city_and_state" class="form-control" value="<?= htmlspecialchars($record->city_and_state ?? '') ?>" required/>
    </div>
</div>


<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Last Name<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
      <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($record->last_name ?? '') ?>" required/>
  </div>
      <div class="col-md-2">
      <label for="zip_code">Zip Code</label>
    </div>
    <div class="col-md-3">
    <input type="text" name="zip_code" id="zip_code" class="form-control" value="<?= htmlspecialchars($record->zip_code ?? '') ?>" />
    </div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Date of Birth<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
<input type="date" name="bdate" class="form-control" value="<?= htmlspecialchars($record->bdate ?? '') ?>" required/>
  </div>
      <div class="col-md-2">
      <label for="country">Country <span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
         <select name="country_id" id="country_id" class="form-select form-control-sm" required>
					<option value="">Select Country</option> <!-- Default empty option -->
					<?php foreach ($country as $c) { ?>
						<option value="<?php echo $c->country_id; ?>"><?php echo $c->country_name; ?></option>
					<?php } ?>
				</select>    </div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Gender<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
  <select class="form-select" name="gender" required>
  <option value="">--Select--</option>
      <option value="Male" <?= ($record->gender ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= ($record->gender ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
      <option value="Other" <?= ($record->gender ?? '') === 'Other' ? 'selected' : '' ?>>Other</option>
    </select>  
  </div>
     <div class="col-md-2">
    <label for="p_address">Permanent Address In-Home Country<span style="color: red;"> * </span></label>
</div>
<div class="col-md-3">
    <textarea name="p_address" id="p_address" class="form-control" required><?= htmlspecialchars($record->p_address ?? '') ?></textarea>
</div>

</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Contact Number<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">

<input
  type="text"
  name="contact_no"
  id="contact_no" class="form-control"
  required
  pattern="\d{7,15}"
  title="Please enter a valid primary contact number (7 to 15 digits)."
/>

 </div>
  <div class="col-md-2">
      <label for="p_address_line">Address Line 2</label>
    </div>
    <div class="col-md-3">
<input type="text" name="p_address_line" class="form-control" value="<?= htmlspecialchars($record->p_address_line ?? '') ?>" />
    </div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Email Address<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
<input
  type="email"
  name="email_address" class="form-control"
  id="email_address"
  required
  title="Please enter a valid email address (e.g., user@example.com)."
/>
 </div>
  <div class="col-md-2">
      <label for="P_city_and_state">City and State</label>
    </div>
    <div class="col-md-3">
<input type="text" name="P_city_and_state" class="form-control" value="<?= htmlspecialchars($record->P_city_and_state ?? '') ?>" />    </div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Marital Status</label>
  </div>
  <div class="col-md-3">
   <select class="form-select form-control-sm " id="marital_status" name="marital_status">
					<option value="">Select</option>
					<option value="Married">Married</option>
					<option value="Single">Single</option>
	</select>
  </div>
  <div class="col-md-2">
      <label for="p_zip_code">Zip Code</label>
    </div>
    <div class="col-md-3">
<input type="text" name="p_zip_code" class="form-control" value="<?= htmlspecialchars($record->p_zip_code ?? '') ?>" />
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Nationality<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
<input type="text" name="nationality" id="nationality" class="form-control" value="<?= htmlspecialchars($record->nationality ?? '') ?>" required/>
 </div>
  <div class="col-md-2">
      <label for="p_country">Country<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
<input type="text" name="p_country" class="form-control" value="<?= htmlspecialchars($record->p_country ?? '') ?>" required/>    
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Passport No <span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
<input
  type="text"
  name="passport_number"
  class="form-control"
  value="<?= htmlspecialchars($record->passport_number ?? '') ?>"
  required
  pattern="\d+"
  title="Please enter numbers only for the passport number."
/> </div>
  <div class="col-md-2">
      <label for="passport_expiry">Passport Expiry<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
<input type="date" name="passport_expiry" class="form-control" value="<?= htmlspecialchars($record->passport_expiry ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Emirates ID Number <br>(If Applicable)</label>
  </div>
  <div class="col-md-3">
    <input type="text" name="emirate_number" class="form-control" value="<?= htmlspecialchars($record->emirate_number ?? '') ?>">
 </div>
  <div class="col-md-2">
      <label for="emirate_expiry">EID Expiry</label>
    </div>
    <div class="col-md-3">
    <input type="date" name="emirate_expiry" class="form-control" value="<?= htmlspecialchars($record->emirate_expiry ?? '') ?>">
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Visa Type<br><small>(Employment, Freelance, Family)</small><span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
    <input type="text" name="visa_type" class="form-control" value="<?= htmlspecialchars($record->visa_type ?? '') ?>" required>
 </div>
  <div class="col-md-2">
      <label for="visa_status">Current Visa Status<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="visa_status" class="form-control" value="<?= htmlspecialchars($record->visa_status ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Driving License</label>
  </div>
  <div class="col-md-3">
    <input type="text" name="driving_license" class="form-control" value="<?= htmlspecialchars($record->driving_license ?? '') ?>">
 </div>
  <div class="col-md-2">
      <label for="visa_expiry">Date of Visa Expiry<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="date" name="visa_expiry" class="form-control" value="<?= htmlspecialchars($record->visa_expiry ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Years of Experience<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
    <input type="text" name="exp_years" class="form-control" value="<?= htmlspecialchars($record->exp_years ?? '') ?>" required>
 </div>
  <div class="col-md-2">
      <label for="relevant_experience">Relevant Experience<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="relevant_experience" class="form-control" value="<?= htmlspecialchars($record->relevant_experience ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Skills</label>
  </div>
  <div class="col-md-3">
<textarea name="skills" class="form-control"><?= htmlspecialchars($record->skills ?? '') ?></textarea> </div>
  <div class="col-md-2">
      <label for="photo_path">Upload Photo</label>
    </div>
    <div class="col-md-3">
<input type="file" name="photo_path" accept="image/*" class="form-control">

<?php if (!empty($record->photo_path)): ?>
    <img src="<?= base_url($record->photo_path) ?>" alt="Uploaded Photo" height="100">
<?php endif; ?>
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Languages Known</label>
  </div>
  <div class="col-md-3">
<textarea name="language" class="form-control"><?= htmlspecialchars($record->language ?? '') ?></textarea>
    </div>
  </div>
  <div class="section-title">Emergency Contact Details </div>

<div class="row mb-3 mt-4">
  <div class="col-md-2">
    <label class="form-label">Name of Emergency Contact Person <span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
    <input type="text" name="contact_name" id="contact_name" class="form-control" value="<?= htmlspecialchars($record->contact_name ?? '') ?>" required>
 </div>
  <div class="col-md-2">
      <label for="contact_relation">Relationship<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="contact_relation"  id="contact_relation" class="form-control" value="<?= htmlspecialchars($record->contact_relation ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Contact Number<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
<input
  type="text"
  name="r_contact_number" class="form-control"
  id="r_contact_number"
  pattern="\d{7,15}"
  title="Please enter a valid alternate contact number (7 to 15 digits)."
/>
 </div>
  <div class="col-md-2">
      <label for="r_contact_number2">Alternate Contact Number</label>
    </div>
    <div class="col-md-3">
<input
  type="text"
  name="r_contact_number2" class="form-control"
  id="r_contact_number2"
  pattern="\d{7,15}"
  title="Please enter a valid alternate contact number (7 to 15 digits)."
/></div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Email Address</label>
  </div>
  <div class="col-md-3">
    <input type="email" name="email_id" class="form-control" value="<?= htmlspecialchars($record->email_id ?? '') ?>">
 </div>
  <div class="col-md-2">
      <label for="contact_address">Address<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="contact_address" class="form-control" value="<?= htmlspecialchars($record->contact_address ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Address 2</label>
  </div>
  <div class="col-md-3">
    <input type="text" name="contact_address_2" class="form-control" value="<?= htmlspecialchars($record->contact_address_2 ?? '') ?>">
 </div>
  <div class="col-md-2">
      <label for="contact_city">City / State</label>
    </div>
    <div class="col-md-3">
    <input type="text" name="contact_city" class="form-control" value="<?= htmlspecialchars($record->contact_city ?? '') ?>">
</div>
</div>


 <div class="section-title">Educational Background</div>
<div class="row mb-3 mt-4">
  <div class="col-md-2">
    <label class="form-label">Highest Qualification<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
    <input type="text" name="high_degree" class="form-control" value="<?= htmlspecialchars($record->high_degree ?? '') ?>" required>
 </div>
  <div class="col-md-2">
      <label for="institute_name">Institution Name<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="institute_name" class="form-control" value="<?= htmlspecialchars($record->institute_name ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Year of Passing<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
    <input type="text" name="year_passing" class="form-control" value="<?= htmlspecialchars($record->year_passing ?? '') ?>" required>
 </div>
  <div class="col-md-2">
      <label for="specialization">Specialization</label>
    </div>
    <div class="col-md-3">
    <input type="text" name="specialization" class="form-control" value="<?= htmlspecialchars($record->specialization ?? '') ?>">
</div>
</div>
 <div class="section-title">Previous Employment Details</div>

<div class="row mb-3 mt-4">
  <div class="col-md-2">
    <label class="form-label">Last Company Name</label>
  </div>
  <div class="col-md-3">
    <input type="text" name="last_company" class="form-control" value="<?= htmlspecialchars($record->last_company ?? '') ?>">
 </div>
  <div class="col-md-2">
      <label for="last_desig">Designation Held</label>
    </div>
    <div class="col-md-3">
    <input type="text" name="last_desig" class="form-control" value="<?= htmlspecialchars($record->last_desig ?? '') ?>">
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Duration of employment</label>
  </div>
  <div class="col-md-3">
    <input type="text" name="working_period" class="form-control" value="<?= htmlspecialchars($record->working_period ?? '') ?>">
 </div>
  <div class="col-md-2">
      <label for="resig_reason">Reason for leaving</label>
    </div>
    <div class="col-md-3">
    <input type="text" name="resig_reason" class="form-control" value="<?= htmlspecialchars($record->resig_reason ?? '') ?>">
</div>
</div>
<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">Reference Contact</label>
  </div>
  <div class="col-md-3">
    <input type="text" name="ref_contact" class="form-control" value="<?= htmlspecialchars($record->ref_contact ?? '') ?>">
 </div>
  </div>

   <div class="section-title">Banking Information Details</div>

<div class="row mb-3 mt-4">
  <div class="col-md-2">
    <label class="form-label">Bank Name<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
    <input type="text" name="bank_name" class="form-control" value="<?= htmlspecialchars($record->bank_name ?? '') ?>" required>
 </div>
  <div class="col-md-2">
      <label for="acc_no">Account Number<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="acc_no" class="form-control" value="<?= htmlspecialchars($record->acc_no ?? '') ?>" required>
</div>
</div>

<div class="row mb-3">
  <div class="col-md-2">
    <label class="form-label">IBAN Number<span style="color: red;"> * </span></label>
  </div>
  <div class="col-md-3">
    <input type="text" name="iban_no" class="form-control" value="<?= htmlspecialchars($record->iban_no ?? '') ?>" required>
 </div>
  <div class="col-md-2">
      <label for="branch_name">Bank Branch<span style="color: red;"> * </span></label>
    </div>
    <div class="col-md-3">
    <input type="text" name="branch_name" class="form-control" value="<?= htmlspecialchars($record->branch_name ?? '') ?>" required>
</div>
</div>
<input type="hidden" name="encoded_id" value="<?php echo $this->uri->segment(3); ?>">

 <div class="text-center mt-4">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>

</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Primary Contact Number Validation
  var contactField = document.getElementById('contact_no');
  if (contactField) {
    contactField.addEventListener('invalid', function() {
      if (this.validity.valueMissing) {
        this.setCustomValidity('Primary contact number is required.');
      } else if (this.validity.patternMismatch) {
        this.setCustomValidity('Please enter a valid primary contact number (7 to 15 digits).');
      } else {
        this.setCustomValidity('');
      }
    });
    contactField.addEventListener('input', function() {
      this.setCustomValidity('');
    });
  }

  // Alternate Contact Number Validation
  var altContactField = document.getElementById('r_contact_number');
  if (altContactField) {
    altContactField.addEventListener('invalid', function() {
      if (this.validity.patternMismatch) {
        this.setCustomValidity('Please enter a valid alternate contact number (7 to 15 digits).');
      } else {
        this.setCustomValidity('');
      }
    });
    altContactField.addEventListener('input', function() {
      this.setCustomValidity('');
    });
  }

  // Email Address Validation
  var emailField = document.getElementById('email_address');
  if (emailField) {
    emailField.addEventListener('invalid', function() {
      if (this.validity.valueMissing) {
        this.setCustomValidity('Email address is required.');
      } else if (this.validity.typeMismatch) {
        this.setCustomValidity('Please enter a valid email address (e.g., user@example.com).');
      } else {
        this.setCustomValidity('');
      }
    });
    emailField.addEventListener('input', function() {
      this.setCustomValidity('');
    });
  }
});


</script>
