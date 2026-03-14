<!DOCTYPE html>
<html>
<head>
    <title>Billing History Import</title>
    <style>
        body { font-family: Arial; background:#f4f6f8; }
        .box {
            width: 450px;
            margin: 80px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
        }
        button {
            background: #0d6efd;
            color: #fff;
            padding: 10px 20px;
            border: none;
        }
    </style>
</head>
<body>

<div class="box">
    <h3>Import Customer Billing History using cvs file</h3>

    <?php if ($this->session->flashdata('success')): ?>
        <p style="color:green"><?= $this->session->flashdata('success') ?></p>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red"><?= $this->session->flashdata('error') ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data"
          action="<?= base_url('index.php/billing_history_import/upload') ?>">
        <input type="file" name="csv_file" accept=".csv" required><br><br>
        <button type="submit">Upload CSV</button>
    </form>

    <p style="font-size:12px;color:#666;margin-top:10px;">
        Upload CSV converted from Excel.<br>
        One invoice with multiple service rows.
    </p>
</div>

</body>
</html>
