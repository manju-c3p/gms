<?php
$this->load->helper('myopeningbalance');

// foreach($comapny_records as $row) {
//     $company_name = $row->company_name;
//     $company_address = $row->company_address;
//     $company_city = $row->company_city;
//     $company_pincode = $row->company_pincode;
//     $company_country = $row->company_country;
//     $company_email_id = $row->company_email_id;
//     $company_telephone = $row->company_telephone;
//     $company_website = $row->company_website;
//     $company_trn = $row->company_TRN;
// }
?>

<!DOCTYPE html>
<html>

<head>
	<title>Individual Ledger Details</title>
	<style>
		* {
			box-sizing: border-box;
		}

		/* Force proper A4 print size */
		@page {
			size: A4 portrait;
			margin: 10mm;
		}

		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
			background: white;
			margin: 0;
			padding: 0;
		}

		/* Printable container */
		#printable {
			width: 100%;
			padding: 10px;
			
		}


		/* Title Bar */
		.report-title-bar {
			background-color: #d3d3d3;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
			color: #000;
			font-weight: bold;
			text-align: center;
			padding: 6px;
			margin-top: 15px;
			font-size: 15px;
		}

		/* Table settings */
		table {
			width: 100%;
			border-collapse: collapse;
			table-layout: fixed;
			/* prevents right overflow */
			margin-top: 10px;
		}

		th,
		td {
			border: 1px solid #000;
			padding: 5px;
			font-size: 12px;
			word-wrap: break-word;
			overflow-wrap: break-word;
		}

		th {
			background-color: #f2f2f2;
			font-weight: bold;
		}

		/* Column width control to prevent overflow */
		th:nth-child(1),
		td:nth-child(1) {
			width: 5%;
		}

		th:nth-child(2),
		td:nth-child(2) {
			width: 10%;
		}

		th:nth-child(3),
		td:nth-child(3) {
			width: 35%;
		}

		th:nth-child(4),
		td:nth-child(4) {
			width: 10%;
		}

		th:nth-child(5),
		td:nth-child(5) {
			width: 15%;
		}

		th:nth-child(6),
		td:nth-child(6) {
			width: 12.5%;
			text-align: right;
		}

		th:nth-child(7),
		td:nth-child(7) {
			width: 12.5%;
			text-align: right;
		}

		.summary-row {
			display: flex;
			justify-content: space-between;
			margin-top: 10px;
			font-weight: bold;
		}

		.meta-info {
			margin-top: 20px;
			font-size: 12px;
		}

		/* Footer */
		.footer {
			font-size: 11px;
			margin-top: 25px;
			page-break-inside: avoid;
		}

		.footer .bottom {
			display: flex;
			justify-content: space-between;
			font-weight: bold;
			border-top: 1px solid #000;
			padding-top: 6px;
		}

		.no-border td {
			border: none !important;
			padding: 2px 0;
		}

		/* Print adjustments */
		@media print {

			html,
			body {
				width: 100%;
				height: auto;
			}

			#printable {
				padding: 5px;
			}

			table {
				page-break-inside: auto;
			}

			tr {
				page-break-inside: avoid;
				page-break-after: auto;
			}

			thead {
				display: table-header-group;
				/* repeats header on each page */
			}

			tfoot {
				display: table-footer-group;
			}

			.footer {
				position: relative;
				bottom: 0;
				width: 100%;
			}
		}
	</style>
</head>

<body>
	<div class="container px-3 py-2">
		<!-- Header -->
		<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">

			<!-- Logo -->
			<img src="<?= base_url('public/images/logocooling.png'); ?>" width="30%" style="height:70px;">

			<!-- Company Details -->
			<div style="text-align:right; font-size:13px; line-height:1.5;">
				<strong>Cool Runnings Garage Co LLC</strong><br>
				Al Quoz 3, Dubai, UAE<br>
				www.coolrunningsgarage.com<br>
				Tel: +971 4 265 4887<br>
				TRN: 104026094300003
			</div>

		</div>

		<!-- Report Title Bar -->
		<div style="width: 100%; background: #e4e4e4; padding: 8px 0; text-align: center; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">
			Individual Ledger Details
		</div>

		<!-- Report Info -->
		<table class="info-table">
			<tr>
				<td><strong>Report Date:</strong> <?php echo date('d-M-Y'); ?></td>
				<td><strong>Ledger Account:</strong> <?php echo get_accountname_by_id($account_id); ?></td>
				<td><strong>Period:</strong> <?php echo date('d-M-Y', strtotime($from_date)) . ' to ' . date('d-M-Y', strtotime($to_date)); ?></td>
			</tr>
		</table>

		<!-- Ledger Table -->
		<table class="data-table">
			<thead>
				<tr>
					<th>Sr.No</th>
					<th>Txn Date</th>
					<th>Particulars</th>
					<th>Voucher Code</th>
					<th>Txn Type</th>
					<th>Debit</th>
					<th>Credit</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count = 0;
				$total = 0;
				$totalc = 0;
				$credit_amount = 0;
				$debit_amount = 0;
				$tamount = 0;
				$opening_bal = 0;
				$for_loop = 0;
				$j = 1;

				$opening_bal = calculate_opening_bal($from_date, $account_id);

				if ($for_loop == 0) {
					if ($opening_bal > 0) {
						echo "<tr><td colspan='5'>Dr. Opening Balance</td><td align='right'>" . sprintf("%0.2f", $opening_bal) . " Dr</td><td></td></tr>";
					} else {
						echo "<tr><td colspan='5'>Cr. Opening Balance</td><td></td><td align='right'>" . sprintf("%0.2f", abs($opening_bal)) . " Cr</td></tr>";
					}
				}

				if (!empty($ledger_transaction_records)) {
					foreach ($ledger_transaction_records as $row) {
						$for_loop++;
						if ($row->voucher_date > 0 && $row->amount > 0) {
							echo "<tr>";
							echo "<td>" . $j . "</td>";
							echo "<td>" . date('d-M-Y', strtotime($row->voucher_date)) . "</td>"; ?>
							<td>
								<?php
								if ($row->voucher_type == 'S') {
									echo 'Ref No: ' . $row->ref_no . '<br>';
									echo 'Invoice Date: ' . date('d-M-Y', strtotime($row->invoice_date)) . '<br>';
									echo 'Client PO: ' . $row->po_code;
								} elseif ($row->voucher_type == 'G') {
									echo 'Invoice No: ' . $row->ref_no . '<br>';
									echo 'Invoice Date: ' . date('d-M-Y', strtotime($row->invoice_date)) . '<br>';
									echo 'Ref No: ' . $row->po_code;
								} elseif ($row->voucher_type == 'P') {
									echo 'Invoice No: ' . $row->ref_no . '<br>';
									echo 'Invoice Date: ' . (!empty($row->invoice_date) ? date('d-M-Y', strtotime($row->invoice_date)) : '') . '<br>';
									echo 'Ref No: ' . $row->po_code . '<br>' . $row->narration;
								} else {
									echo $row->narration;
								}
								?>
							</td>
				<?php
							echo "<td>" . $row->voucher_code . "</td>";
							echo "<td>";
							switch ($row->voucher_type) {
								case 'S':
									echo 'Sales Invoice';
									break;
								case 'G':
									echo 'PO GRN Invoice';
									break;
								case 'R':
									echo 'Receipt';
									break;
								case 'P':
									echo 'Payment';
									break;
								case 'C':
									echo 'Credit Note';
									break;
								case 'D':
									echo 'Debit Note';
									break;
								case 'J':
									echo 'Journal';
									break;
								case 'N':
									echo 'Contra Entry';
									break;
							}
							echo "</td>";

							$tamount = $row->amount;
							if (strtoupper($row->drcr_type) == "DR") {
								echo "<td align='right'>" . sprintf("%0.2f", $tamount) . "</td><td></td>";
								$debit_amount += $tamount;
							} else {
								echo "<td></td><td align='right'>" . sprintf("%0.2f", $tamount) . "</td>";
								$credit_amount += $tamount;
							}
							echo "</tr>";
							$j++;
						}
					}
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5" align="right"><strong>Trans Total:</strong></td>
					<td align="right"><strong><?php echo sprintf("%0.2f", $debit_amount); ?></strong></td>
					<td align="right"><strong><?php echo sprintf("%0.2f", $credit_amount); ?></strong></td>
				</tr>
				<?php
				if ($opening_bal > 0) {
					$display_total_db = $debit_amount + $opening_bal;
					$display_total_cr = $credit_amount;
				} else {
					$display_total_cr = $credit_amount + abs($opening_bal);
					$display_total_db = $debit_amount;
				}

				$bal = $display_total_db - $display_total_cr;
				if ($bal > 0) {
					echo "<tr><td colspan='5'>Dr. Closing Balance</td><td align='right'><strong>" . sprintf("%0.2f", $bal) . " Dr</strong></td><td></td></tr>";
				} else {
					echo "<tr><td colspan='5'>Cr. Closing Balance</td><td></td><td align='right'><strong>" . sprintf("%0.2f", abs($bal)) . " Cr</strong></td></tr>";
				}
				?>
			</tfoot>
		</table>

		<!-- Meta Info -->
		<div class="meta-info">
			<strong>Report Dated</strong>: <?= date('d-M-Y'); ?><br>
			<strong>Report Generated By</strong>: <?= $this->session->userdata('user_name'); ?>
		</div>

		<!-- Footer Section -->
		<div class="footer">
			<div class="bottom">
				<div>&copy;<?= date('Y'); ?> For Cool Runnings Garage Co LLC, Designed and developed by Concepts 360 Plus</div>
				<div id="page-number"></div>
			</div>
		</div>

	</div>
	<script>
		window.onload = function() {
			window.print();
		};

		let totalPages = Math.ceil(document.body.scrollHeight / window.innerHeight);
		document.getElementById("page-number").innerText = "Page 1 of " + totalPages;
	</script>
</body>

</html>
