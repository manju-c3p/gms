<html>

<head>
	<title>
		Goods Received Note
	</title>
	<style>
/* Header */
        .header-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .logo img {
            max-width: 220px;
            height: auto;
        }

        .company {
            width: 50%;
            text-align: right;
            font-size: 11px;
            line-height: 1.25;
            color: #333;
        }

        .company strong {
            font-size: 13px;
            color: #111;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 6px;
        }

	</style>
</head>

<body style="margin-left: 5px; margin-top:5px; font-family:Arial;font-size: 12px;text-align:center">
	<!-- HEADER TEMPLATE -->
<htmlpageheader name="myheader">
    <div class="header-row">
        <div class="logo">
            <img src="<?= base_url() ?>public/header/header.jpg" style="width:300px;height:70px;">
        </div>
        <div class="company">
            <strong style="font-size:13px;"><?= $comp_details['company_name']; ?></strong><br>
            <?= nl2br($comp_details['company_address']); ?><br>
            <?= $comp_details['company_city']; ?>, <?= $comp_details['company_state']; ?><br>
            <?= $comp_details['company_country']; ?><br/><?= $comp_details['company_po']; ?>
            <?= $comp_details['company_trn']; ?>
        </div>
    </div>

</htmlpageheader>
    <!-- Watermark -->
    <div style="position: fixed;top: 45%;left: 50%;transform: translate(-50%, -50%); opacity: 0.06; z-index: 0; pointer-events: none;">
        <img src="<?= base_url() ?>public/header/header.jpg" style="width: 60%; height: auto;">
    </div>
	<table width=100% style='border: 0'>
		
		<tbody id="table-body">
			<tr class='calc'>
				<td>
					<table cellpadding=5 width=95% style='font-size: 20px;border:0;text-align:center'>
						<tr height='22px'>
							<td width=100% style="color:e8b41a">Goods Received Note</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class='calc'>
				<td>
					<table width="98%" cellpadding="6"
						style="font-size: 12px;">
						<tr>
							<!-- Left Section -->
							<td width="60%" style="border: 1px solid black; vertical-align: top; padding: 8px;">
								<table width="100%" style="border-collapse: collapse; font-size: 12px;">
									<tr>
										<td width="30%" style=" padding: 6px;">Name</td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td width="70%" style=" padding: 6px;">
											<?php echo $grn[0]->supplier_name; ?>
										</td>
									</tr>
									<tr>
										<td style=" padding: 6px;">Address</td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;">
											<?php echo $grn[0]->billing_address; ?>
										</td>
									</tr>
									<tr>
										<td style=" padding: 6px;">Contact No</td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;">
											<?php echo $grn[0]->contact_number; ?>
										</td>
									</tr>
									<tr>
										<td style=" padding: 6px;">Email</td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;">
											<?php echo $grn[0]->supplier_email; ?>
										</td>
									</tr>
								</table>
							</td>

							<!-- Right Section -->
							<td width="40%" style="border: 1px solid black; vertical-align: top; padding: 8px;">
								<table width="100%" style="border-collapse: collapse; font-size: 12px;">
									<tr>
										<td width="30%" style=" padding: 6px;">Date</td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td width="70%" style=" padding: 6px;">
											<?php echo $grn[0]->grn_date; ?>
										</td>
									</tr>
									<tr>
										<td style="padding: 6px;">Doc No</td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;">
											<?php echo $grn[0]->grn_code; ?>
										</td>
									</tr>
									<tr>
										<td style=" padding: 6px;">Supplier ID</td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;">
											<?php echo $grn[0]->supplier_name; ?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>


				</td>
			</tr>
			
		
			<tr>
				<td>
					<table cellpadding="8" width="100%" border="1" style="font-size: 12px;border-collapse:collapse">
						<thead>
							<tr style="background-color: #f9f9f9; color: black; border: 1px solid black; text-align: center;">
								<th style="width: 2%; ">Sl No</th>
								<th style="width: 10%; ">Model</th>
								<th style="width: 18%; ">Description</th>
								<th style="width: 5%; ">Qty</th>
								<th style="width: 5%; ">Unit</th>
								<th style="width: 5%; ">Price</th>
								<th style="width: 5%; ">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sl_no = 1;
							$total_before_vat = $grn[0]->sub_total ?? 0;
							 $discount = $grn[0]->discount ?? 0;
							$vat_amount = $grn[0]->vat_amt ?? 0;
							$grand_total = $grn[0]->grand_total;

							// foreach ($grn_tr as $detail):
							// 	$total_before_vat += $detail->price * $detail->rec_quantity;
							// 	$grand_total += $detail->total;
							// endforeach;

							//$vat_amount = $grand_total - ($total_before_vat - $total_discount);

							foreach ($grn_tr as $detail): ?>
								<tr valign="top">
									<td style=" text-align: center;"><?php echo $sl_no++; ?></td>
									<td style=" padding: 6px;"><?php echo $detail->item_model; ?></td>
									<td style=" padding: 6px;"><?php echo $detail->item_description; ?></td>
									<td style=" text-align: center;"><?php echo $detail->rec_quantity; ?></td>
									<td style=" text-align: center;"><?php echo $detail->unit_name; ?></td>
									<td style=" text-align: right;"><?php echo number_format($detail->price, 2); ?></td>
									<td style=" text-align: right;"><?php echo number_format($detail->total, 2); ?></td>
								</tr>
							<?php endforeach; ?>

							<!-- Totals Rows -->
							<tr style="font-weight: bold;">
								<td colspan="6" align="right" style="border: 1px solid black; padding: 6px;">Total Before VAT</td>
								<td style="border: 1px solid black; text-align: right;"><?php echo number_format($total_before_vat, 2); ?></td>
							</tr>
							<tr style="font-weight: bold;">
								<td colspan="6" align="right" style="border: 1px solid black; padding: 6px;">Discount Amount</td>
								<td style="border: 1px solid black; text-align: right;"><?php echo number_format($discount, 2); ?></td>
							</tr>
							<tr style="font-weight: bold;">
								<td colspan="6" align="right" style="border: 1px solid black; padding: 6px;">VAT Amount</td>
								<td style="border: 1px solid black; text-align: right;"><?php echo number_format($vat_amount, 2); ?></td>
							</tr>
							<tr style="font-weight: bold;">
								<td colspan="6" align="right" style="border: 1px solid black; padding: 6px;">Total Amount</td>
								<td style="border: 1px solid black; text-align: right;"><?php echo number_format($grand_total, 2); ?></td>
							</tr>
						</tbody>
					</table>

				</td>
			</tr>
			<tr class='calc'>
				<td>
					<table cellpadding=5 border=0 width=95% style='font-size: 12px; border-collapse: collapse;border:0'>
						<tr>
							<td>Prepared by:<?php echo $grn[0]->user_name; ?></td>
							<td></td>
							
						</tr>
					</table>
				</td>

			</tr>




		</tbody>

	</table>

</body>

</html>
