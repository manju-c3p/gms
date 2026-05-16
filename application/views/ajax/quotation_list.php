<option value="">Select Quotation</option>

<?php foreach ($res as $row) { ?>
    <option value="<?php echo $row->quotation_id; ?>">
        <?php echo $row->quotation_no; ?> 
        (<?php echo date('d-M-Y', strtotime($row->quotation_date)); ?>)
        | Total: <?php echo number_format($row->subtotal, 2); ?>
        | Received: <?php echo number_format($row->received_amount, 2); ?>
        | Balance: <?php echo number_format($row->balance_amount, 2); ?>
    </option>
<?php } ?>
