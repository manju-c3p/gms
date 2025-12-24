<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<!-- HEADER -->
	<div class="flex justify-between items-center mb-6">
		<div>
			<h2 class="text-2xl font-bold">Invoice</h2>
			<p class="text-sm text-gray-500">
				Invoice No: <b><?= $invoice->invoice_no ?></b><br>
				Date: <?= date('d-m-Y', strtotime($invoice->invoice_date)) ?>
			</p>
		</div>

		<!-- <div class="flex items-center gap-2">
		
			<span class="px-3 py-1 rounded text-white text-sm
                <?= $invoice->status == 'Paid' ? 'bg-green-600' : ($invoice->status == 'Partially Paid' ? 'bg-yellow-500' : 'bg-red-600') ?>">
				<?= $invoice->status ?>
			</span>

			
			<a href="<?= base_url('index.php/invoice/print_invoice/' . $invoice->invoice_id) ?>"
				target="_blank"
				class="p-2 rounded bg-gray-200 hover:bg-gray-300"
				title="Print Invoice">
				🖨
			</a>
			<a href="<?= base_url('index.php/invoice/download_invoice/' . $invoice->invoice_id) ?>"
				target="_blank"
				class="p-2 rounded bg-gray-200 hover:bg-gray-300"
				title="Download Invoice PDF">
				📄
			</a>
			
			<a href="<?= base_url('index.php/invoice/download_invoice/' . $invoice->invoice_id) ?>"
				class="p-2 rounded bg-green-200 hover:bg-green-300"
				title="Export Excel">
				📊
			</a>
		</div> -->

		<div class="flex items-center gap-2">

			<!-- STATUS -->
			<span class="px-3 py-1 rounded-full text-sm font-semibold
        <?= $invoice->status == 'Paid' ? 'bg-green-100 text-green-700' : ($invoice->status == 'Partially Paid' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
				<?= $invoice->status ?>
			</span>

			<!-- PRINT -->
			<a href="<?= base_url('index.php/invoice/print_invoice/' . $invoice->invoice_id) ?>"
				target="_blank"
				class="p-3 rounded-lg bg-slate-100 hover:bg-slate-200 transition"
				title="Print Invoice">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-700"
					fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
					<path stroke-linecap="round" stroke-linejoin="round"
						d="M6 9V2h12v7M6 18h12v4H6v-4M6 14H5a3 3 0 01-3-3v-1a3 3 0 013-3h14a3 3 0 013 3v1a3 3 0 01-3 3h-1" />
				</svg>
			</a>

			<!-- PDF -->
			<a href="<?= base_url('index.php/invoice/download_invoice/' . $invoice->invoice_id) ?>"
				class="p-3 rounded-lg bg-red-100 hover:bg-red-200 transition"
				title="Download PDF">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-700"
					fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
					<path stroke-linecap="round" stroke-linejoin="round"
						d="M12 16v-8m0 8l-3-3m3 3l3-3M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H8l-2 2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
				</svg>
			</a>

			<!-- EXCEL -->
			<a href="<?= base_url('index.php/invoice/export_excel/' . $invoice->invoice_id) ?>"
				class="p-3 rounded-lg bg-green-100 hover:bg-green-200 transition"
				title="Export Excel">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700"
					viewBox="0 0 24 24" fill="currentColor">
					<path d="M4 3h10l6 6v12a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2z" />
					<path d="M8 17l2-3-2-3h2l1 2 1-2h2l-2 3 2 3h-2l-1-2-1 2z" fill="#fff" />
				</svg>

			</a>


		</div>

	</div>

	<!-- CUSTOMER & VEHICLE -->
	<div class="grid grid-cols-2 gap-4 mb-6 bg-gray-50 p-4 rounded text-sm">
		<div>
			<p><b>Customer Name:</b> <?= $invoice->customer_name ?></p>
			<p><b>Phone:</b> <?= $invoice->phone ?></p>
		</div>
		<div>
			<p><b>Vehicle No:</b> <?= $invoice->registration_no ?></p>
			<p><b>Vehicle:</b> <?= $invoice->brand ?> <?= $invoice->model ?></p>
		</div>
	</div>

	<!-- ITEMS TABLE -->
	<h3 class="font-semibold mb-2">Invoice Items</h3>

	<table class="w-full border text-sm mb-6">
		<thead class="bg-gray-100">
			<tr>
				<th class="border p-2 w-10">#</th>
				<th class="border p-2">Description</th>
				<th class="border p-2 w-20">Qty</th>
				<th class="border p-2 w-28 text-right">Unit Price</th>
				<th class="border p-2 w-32 text-right">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($items)): ?>
				<?php $i = 1;
				foreach ($items as $item): ?>
					<tr>
						<td class="border p-2 text-center"><?= $i++ ?></td>
						<td class="border p-2">
							<?= $item->item_name ?>
							<span class="text-xs text-gray-500">
								(<?= $item->item_type ?>)
							</span>
						</td>
						<td class="border p-2 text-center"><?= $item->quantity ?></td>
						<td class="border p-2 text-right">
							<?= number_format($item->unit_price, 2) ?>
						</td>
						<td class="border p-2 text-right">
							<?= number_format($item->total_price, 2) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="5" class="border p-3 text-center text-gray-500">
						No items found
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<!-- TOTALS -->
	<div class="grid grid-cols-2 gap-4 text-sm mb-6">
		<div></div>
		<div class="space-y-1">
			<div class="flex justify-between">
				<span>Subtotal</span>
				<span><?= number_format($invoice->subtotal, 2) ?></span>
			</div>
			<div class="flex justify-between">
				<span>VAT (5%)</span>
				<span><?= number_format($invoice->tax_amount, 2) ?></span>
			</div>
			<div class="flex justify-between">
				<span>Discount</span>
				<span><?= number_format($invoice->discount_amount, 2) ?></span>
			</div>
			<div class="flex justify-between font-bold text-lg border-t pt-2">
				<span>Grand Total</span>
				<span><?= number_format($invoice->grand_total, 2) ?></span>
			</div>
			<div class="flex justify-between text-green-700">
				<span>Paid Amount</span>
				<span><?= number_format($paid_amount, 2) ?></span>
			</div>
			<div class="flex justify-between text-red-700 font-semibold">
				<span>Balance Amount</span>
				<span><?= number_format($balance_amount, 2) ?></span>
			</div>
		</div>
	</div>

	<!-- PAYMENT HISTORY -->
	<h3 class="font-semibold mb-2">Payment History</h3>

	<table class="w-full border text-sm">
		<thead class="bg-gray-100">
			<tr>
				<th class="border p-2">Date</th>
				<th class="border p-2">Mode</th>
				<th class="border p-2 text-right">Amount</th>
				<th class="border p-2">Reference</th>
				<th class="border p-2">Notes</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($payments)): ?>
				<?php foreach ($payments as $p): ?>
					<tr>
						<td class="border p-2"><?= date('d-m-Y', strtotime($p->payment_date)) ?></td>
						<td class="border p-2"><?= $p->payment_mode ?></td>
						<td class="border p-2 text-right">
							<?= number_format($p->amount, 2) ?>
						</td>
						<td class="border p-2"><?= $p->reference_no ?></td>
						<td class="border p-2"><?= $p->notes ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="5" class="border p-3 text-center text-gray-500">
						No payments recorded
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

</div>
