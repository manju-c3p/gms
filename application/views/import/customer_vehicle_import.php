<!DOCTYPE html>
<html>

<head>
	<title>Customer & Vehicle CSV Import</title>
	<style>
		body {
			font-family: Arial;
			background: #f8f9fa;
		}

		.box {
			width: 1080px;
			margin: 80px auto;
			background: #fff;
			padding: 25px;
			border-radius: 8px;
			box-shadow: 0 0 10px rgba(0, 0, 0, .1);
		}

		button {
			background: #198754;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
		}

		.alert {
			padding: 10px;
			margin-bottom: 10px;
		}

		.success {
			background: #d1e7dd;
		}

		.error {
			background: #f8d7da;
		}
	</style>
</head>

<body>

	<div class="box">
		<h3>Import Customers & Vehicles (CSV)</h3>

		<?php if ($this->session->flashdata('success')): ?>
			<div class="alert success"><?= $this->session->flashdata('success') ?></div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('error')): ?>
			<div class="alert error"><?= $this->session->flashdata('error') ?></div>
		<?php endif; ?>
		<p>============ ********** import customers from rptcustomer excel sheet ************ ==========</p>
		<form method="post" enctype="multipart/form-data"
			action="<?= base_url('index.php/customer_vehicle_import/upload') ?>">

			<input type="file" name="csv_file" accept=".csv" required><br><br>

			<button type="submit">Upload CSV</button>
		</form>
		<br><br>

		<p>============ ********** import customers from invoice history excel sheet************ ==========</p>

		<form method="post" enctype="multipart/form-data"
			action="<?= base_url('index.php/customer_vehicle_import/import_invoice_history_csv') ?>">

			<input type="file" name="csv_file1" accept=".csv" required><br><br>

			<button type="submit">Upload CSV</button>
		</form>

		<p style="margin-top:15px;font-size:12px;color:#666;">
			CSV must contain header row.<br>
			Supported fields: Customer, Mobile, Plate No, Brand, Model, Year, VIN
		</p><br><br>

		<p>============ ********** import customers from invoice history excel sheet************  new function==========</p>

		<form method="post" enctype="multipart/form-data"
			action="<?= base_url('index.php/Customer_vehicle_import/import_history') ?>">

			<input type="file" name="csv_file2" accept=".csv" required><br><br>

			<button type="submit">Upload CSV</button>
		</form>

		<p style="margin-top:15px;font-size:12px;color:#666;">
			CSV must contain header row.<br>
			Supported fields: Customer, Mobile, Plate No, Brand, Model, Year, VIN
		</p><br><br>


		<p>=========== ************ update customer id from customer table on billing invoice table ********* ========</p>

		<a href="<?= base_url('index.php/customer_vehicle_import/map_invoice_customers') ?>"
			class="btn btn-primary"
			onclick="return confirm('Map customers to invoices?');">
			Update Invoice Customer IDs
		</a>
		<br>

		<!-- ⚠️ DELETE CUSTOMERS & VEHICLES -->
		<a href="<?= base_url('index.php/customer_vehicle_import/delete_customers_vehicles') ?>"
			class="btn btn-danger"
			onclick="return confirm(
       '⚠️ WARNING!\n\nThis will permanently DELETE:\n• All Customers\n• All Vehicles\n\nThis action CANNOT be undone.\n\nAre you sure?'
   );">
			🗑 Delete All Customers & Vehicles
		</a>

		<br>
		<!-- ⚠️ DELETE BILLING HISTORY -->
		<a href="<?= base_url('index.php/customer_vehicle_import/delete_billing_history') ?>"
			class="btn btn-danger ml-2"
			onclick="return confirm(
       '⚠️ WARNING!\n\nThis will permanently DELETE:\n• All Billing Invoices\n• All Billing Invoice Items\n\nThis action CANNOT be undone.\n\nAre you sure?'
   );">
			🗑 Delete Billing Invoices & Items
		</a>
		<br>

		<a href="<?= base_url('index.php/Customer_vehicle_import/map_brand_model_ids') ?>"
   class="btn btn-warning"
   onclick="return confirm(
       'Map vehicle brand & model IDs?\n\nThis will:\n• Create missing brands/models\n• Update vehicles table\n\nContinue?'
   );">
   🔄 Map Vehicle Brand & Model IDs
</a>



	</div>

</body>

</html>
