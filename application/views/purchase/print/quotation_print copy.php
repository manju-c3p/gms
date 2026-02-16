<html>

<head>
	<style>
		/* --- Centered Watermark on all pages --- */
		.watermark {
			position: fixed;
			top: 35%;
			left: 25%;
			width: 50%;
			text-align: center;
			opacity: 0.08;
			z-index: -1;
			pointer-events: none;
			transform: rotate(-20deg);
		}

		.watermark img {
			width: 100%;
			opacity: 0.1;
		}

		/* Ensure watermark appears on every page in PDF */
		@page {
			margin: 10mm;
		}
		body {
			position: relative;
			font-family: Arial;
			font-size: 12px;
			margin: 5px;
			text-align: center;
		}
	</style>
	<title>
		Supplier Quotation
	</title>
</head>

<body style="margin-left: 5px; margin-top:5px; font-family:Arial;font-size: 12px;text-align:center">
		<!-- Watermark (will appear on all pages) -->
	<div class="watermark">
		<img src="<?php echo base_url(); ?>public/header/header.jpg" alt="Watermark">
	</div>
	<table width=100% style='border: 0'>
		<thead>
			<th>
				<img src="<?php echo base_url() ?>public/header/header.jpg" alt="Header Image" width='80%'>
			</th>
		</thead>
		
		<tbody id="table-body">
			
			<tr class='calc'>
				<td>
					<table cellpadding=5 width=95% style='font-size: 20px;border:0;text-align:center'>
						<tr height='22px'>
							<td width=100% style="color:e8b41a">Supplier Quotation</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class='calc'>
				<td>
					<table width="95%" style="font-size: 12px; ">
						<tr>
							<td width="60%" style=" padding: 6px;">
								<table width="100%" style="border-collapse: collapse; font-size: 12px; border: 1px solid black;">
									<tr>
										<td width="30%" style= padding: 6px;"><b>Name</b></td>
										<!-- <td width="5%" style="border: 1px solid black; padding: 6px;">:</td> -->
										<td width="65%" style=" padding: 6px;"><?php echo $quote[0]->supplier_name; ?></td>
									</tr>
									<tr>
										<td style=" padding: 6px;"><b>Address</b></td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;"><?php echo $quote[0]->billing_address; ?></td>
									</tr>
									<tr>
										<td style=" padding: 6px;"><b>Contact No</b></td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;"><?php echo $quote[0]->contact_number; ?></td>
									</tr>
									<tr>
										<td style=" padding: 6px;"><b>Email</b></td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;"><?php echo $quote[0]->supplier_email; ?></td>
									</tr>
								</table>
							</td>
							<td width="40%" style="padding: 6px;">
								<table width="100%" style="border-collapse: collapse; font-size: 12px; border: 1px solid black;">
									<tr>
										<td width="30%" style=" padding: 6px;"><b>Date</b></td>
										<!-- <td width="5%" style="border: 1px solid black; padding: 6px;">:</td> -->
										<td width="65%" style=" padding: 6px;"><?php echo $quote[0]->quotation_date; ?></td>
									</tr>
									<tr>
										<td style=" padding: 6px;"><b>Doc No</b></td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style="padding: 6px;"><?php echo $quote[0]->quotation_code; ?></td>
									</tr>
									<tr>
										<td style=" padding: 6px;"><b>Supplier ID</b></td>
										<!-- <td style="border: 1px solid black; padding: 6px;">:</td> -->
										<td style=" padding: 6px;"><?php echo $quote[0]->supplier_code; ?></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>


				</td>
			</tr>
			<tr class='calc' height=3px style="background-color: #525453;">
				<td></td>
			</tr>
			<tr class='calc'>
				<td>
					<table cellpadding=5 border=0 width=95% style='font-size: 12px; border-collapse: collapse;border:0'>
						<tr>
							<td colspan="6">Prepared by:<?php echo $quote[0]->sales_person; ?></td>
							
						</tr>
					</table>
				</td>

			</tr>
			<tr>
				<td>
					<table cellpadding="8" width="100%" style="font-size: 12px; border-collapse: collapse; border: 1px solid black;">
						<thead>
							<tr style="background-color: white; color: black; border: 1px solid black;">
								<th style="border: 1px solid black; width:2%;">Sl No</th>
								<th style="border: 1px solid black; width:10%;">Product Code</th>
								<th style="border: 1px solid black; width:10%;">Model</th>
								<th style="border: 1px solid black; width:18%;">Description</th>
								<th style="border: 1px solid black; width:5%;">Qty</th>
								<th style="border: 1px solid black; width:5%;">Unit</th>
								<th style="border: 1px solid black; width:5%;">Price</th>
								<th style="border: 1px solid black; width:5%;">Discount</th>
								<th style="border: 1px solid black; width:5%;">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sl_no = 1;
							$total_before_vat = 0;
							$total_discount = 0;
							$vat_amount = 0;
							$grand_total = 0;

							foreach ($quote_tr as $detail):
								$total_before_vat += $detail->price * $detail->quantity;
								$total_discount += $detail->dis_amt;
								$grand_total += $detail->total;
							endforeach;

							// Example VAT Calculation
							$vat_amount = $grand_total - ($total_before_vat - $total_discount);

							foreach ($quote_tr as $detail): ?>
								<tr valign="top" style="border: 1px solid black;">
									<td style="border: 1px solid black; text-align:center;"><?php echo $sl_no++; ?></td>
									<td style="border: 1px solid black;"><?php echo $detail->item_code; ?></td>
									<td style="border: 1px solid black;"><?php echo $detail->item_model; ?></td>
									<td style="border: 1px solid black;"><?php echo $detail->item_description; ?></td>
									<td style="border: 1px solid black; text-align:center;"><?php echo $detail->quantity; ?></td>
									<td style="border: 1px solid black; text-align:center;"><?php echo $detail->unit_name; ?></td>
									<td style="border: 1px solid black; text-align:right;"><?php echo number_format($detail->price, 2); ?></td>
									<td style="border: 1px solid black; text-align:right;"><?php echo number_format($detail->dis_amt, 2); ?></td>
									<td style="border: 1px solid black; text-align:right;"><?php echo number_format($detail->total, 2); ?></td>
								</tr>
							<?php endforeach; ?>

							<!-- Totals -->
							<tr style="font-weight:bold;">
								<td colspan="8" align="right" style="border: 1px solid black; padding-right:8px;">Total Before VAT</td>
								<td style="border: 1px solid black; text-align:right;"><?php echo number_format($total_before_vat, 2); ?></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="8" align="right" style="border: 1px solid black; padding-right:8px;">Discount Amount</td>
								<td style="border: 1px solid black; text-align:right;"><?php echo number_format($total_discount, 2); ?></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="8" align="right" style="border: 1px solid black; padding-right:8px;">VAT Amount</td>
								<td style="border: 1px solid black; text-align:right;"><?php echo number_format($vat_amount, 2); ?></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="8" align="right" style="border: 1px solid black; padding-right:8px;">Total Amount</td>
								<td style="border: 1px solid black; text-align:right;"><?php echo number_format($grand_total, 2); ?></td>
							</tr>
						</tbody>
					</table>

				</td>
			</tr>





		</tbody>
		<tfoot class='footer'>

		</tfoot>
	</table>
</body>

</html>
