<!DOCTYPE html>
<html>

<head>
	<title>Invoice View</title>
	<style>
		body {
			font-family: DejaVu Sans, sans-serif;
			font-size: 12px;
			background-color: white;
		}

		.header {
			text-align: center;
			margin-bottom: 20px;
		}

		.title {
			font-size: 22px;
			font-weight: bold;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			border: 1px solid #000;
			padding: 6px;
		}

		th {
			background: #fefafaff;
		}

		.right {
			text-align: right;
		}

		.status {
			position: fixed;
			top: 40%;
			left: 25%;
			font-size: 60px;
			color: rgba(200, 0, 0, 0.15);
			transform: rotate(-30deg);
		}
	</style>
</head>

<body>

	<?php if ($invoice->status == 'Paid'): ?>
		<div class="status">PAID</div>
	<?php endif; ?>
	<div class="container">
	<div class="header">
		<div class="title">TAX INVOICE</div>
		<p>Garage Management System<br>Dubai, UAE<br>TRN: 123456789</p>
	</div>

	<table>
		<tr>
			<td><b>Invoice No:</b> <?= $invoice->invoice_no ?></td>
			<td><b>Date:</b> <?= $invoice->invoice_date ?></td>
		</tr>
		<tr>
			<td>
				<b>Customer:</b> <?= $invoice->customer_name ?><br>
				<b>Phone:</b> <?= $invoice->phone ?>
			</td>
			<td>
				<b>Vehicle:</b> <?= $invoice->registration_no ?><br>
				<?= $invoice->brand ?> <?= $invoice->model ?>
			</td>
		</tr>
	</table>

	<br>

	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Description</th>
				<th>Qty</th>
				<th class="right">Unit</th>
				<th class="right">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1;
			foreach ($items as $it): ?>
				<tr>
					<td><?= $i++ ?></td>
					<td><?= $it->item_name ?> (<?= $it->item_type ?>)</td>
					<td><?= $it->quantity ?></td>
					<td class="right"><?= number_format($it->unit_price, 2) ?></td>
					<td class="right"><?= number_format($it->total_price, 2) ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<br>

	<table>
		<tr>
			<td class="right">Subtotal</td>
			<td class="right"><?= number_format($invoice->subtotal, 2) ?></td>
		</tr>
		<tr>
			<td class="right">VAT (5%)</td>
			<td class="right"><?= number_format($invoice->tax_amount, 2) ?></td>
		</tr>
		<tr>
			<td class="right">Discount</td>
			<td class="right"><?= number_format($invoice->discount_amount, 2) ?></td>
		</tr>
		<tr>
			<th class="right">Grand Total</th>
			<th class="right"><?= number_format($invoice->grand_total, 2) ?></th>
		</tr>
		<tr>
			<td class="right">Paid</td>
			<td class="right"><?= number_format($paid, 2) ?></td>
		</tr>
		<tr>
			<th class="right">Balance</th>
			<th class="right"><?= number_format($balance, 2) ?></th>
		</tr>
	</table>

	<br>

	<b>Payment History</b>
	<table>
		<tr>
			<th>Date</th>
			<th>Mode</th>
			<th class="right">Amount</th>
		</tr>
		<?php foreach ($payments as $p): ?>
			<tr>
				<td><?= $p->payment_date ?></td>
				<td><?= $p->payment_mode ?></td>
				<td class="right"><?= number_format($p->amount, 2) ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
</body>

</html>
