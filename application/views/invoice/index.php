<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<h2 class="text-2xl font-bold mb-4">Invoice List</h2>

	<table id="invoiceTable" class="stripe hover w-full text-sm">
		<thead>
			<tr>
				<th>#</th>
				<th>Invoice No</th>
				<th>Date</th>
				<th>Customer</th>
				<th>Vehicle</th>
				<th>Total</th>
				<th>Paid</th>
				<th>Balance</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1;
			foreach ($invoices as $inv):
				$balance = $inv->grand_total - $inv->paid_amount;

				// Dynamic status calculation
				if ($inv->paid_amount <= 0) {
					$status = 'Unpaid';
					$status_class = 'bg-red-600';
				} elseif ($inv->paid_amount < $inv->grand_total) {
					$status = 'Partially Paid';
					$status_class = 'bg-yellow-500';
				} else {
					$status = 'Paid';
					$status_class = 'bg-green-600';
				}
			?>
				<tr>
					<td><?= $i++ ?></td>
					<td><?= $inv->invoice_no ?></td>
					<td><?= $inv->invoice_date ?></td>
					<td><?= $inv->customer_name ?></td>
					<td><?= $inv->registration_no ?></td>
					<td><?= number_format($inv->grand_total, 2) ?></td>
					<td><?= number_format($inv->paid_amount, 2) ?></td>
					<td><?= number_format($balance, 2) ?></td>
					<td>
						<span class="px-2 py-1 rounded text-white text-xs <?= $status_class ?>">
							<?= $status ?>
						</span>
					</td>

					<td class="flex gap-2 justify-center">

						<!-- VIEW -->
						<a href="<?= base_url('index.php/invoice/view/' . $inv->invoice_id) ?>"
							class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
							title="View Invoice">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none"
								viewBox="0 0 24 24" stroke-width="1.5"
								stroke="currentColor"
								class="w-5 h-5 text-yellow-700">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M2.25 12s3.75-7.5 9.75-7.5
									9.75 7.5 9.75 7.5
									-3.75 7.5 -9.75 7.5
									S2.25 12 2.25 12z" />
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M15 12a3 3 0 11-6 0
                    				 3 3 0 016 0z" />
							</svg>
						</a>
						<?php if ($username == "Admin") { ?>
							<!-- EDIT -->
							<a href="<?= base_url('index.php/invoice/edit/' . $inv->invoice_id) ?>"
								class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
								title="Edit Invoice">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none"
									viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor"
									class="w-5 h-5 text-yellow-700">
									<path stroke-linecap="round" stroke-linejoin="round"
										d="M16.862 3.487l3.651 3.651
									M17.708 2.64a2.25 2.25 0 113.182 3.182
									L7.125 19.586a4.5 4.5 0 01-1.91 1.146
									L3 21l.268-2.215
									a4.5 4.5 0 011.146-1.91
									L17.708 2.64z" />
								</svg>
							</a>
							<!-- DELETE -->
							<a href="<?= base_url('index.php/invoice/delete/' . $inv->invoice_id) ?>"
								onclick="return confirm('Are you sure you want to delete this invoice?')"
								class="p-2 rounded bg-red-100 hover:bg-red-200"
								title="Delete Invoice">

								<svg xmlns="http://www.w3.org/2000/svg" fill="none"
									viewBox="0 0 24 24" stroke-width="1.5"
									stroke="currentColor"
									class="w-5 h-5 text-red-700">
									<path stroke-linecap="round" stroke-linejoin="round"
							
									d="M6 7.5h12M9.75 7.5V6a2.25 2.25 0 012.25-2.25h0A2.25 2.25 0 0114.25 6v1.5M18 7.5l-.663 9.947
               							A2.25 2.25 0 0115.092 19.5H8.908a2.25 2.25 0 01-2.245-2.053L6 7.5m3 3v6m6-6v6" />
								</svg>

							</a>

						<?php } ?>
					</td>

					<!-- <td class="space-x-1">
						<a href="<?= base_url('index.php/invoice/view/' . $inv->invoice_id) ?>"
							class="px-2 py-1 bg-gray-600 text-white rounded text-xs">View</a>

						<a href="<?= base_url('index.php/invoice/edit/' . $inv->invoice_id) ?>"
							class="px-2 py-1 bg-blue-600 text-white rounded text-xs">Edit</a>

						<?php if ($inv->status != 'Paid'): ?>
							<button onclick="openPaymentModal(
                        <?= $inv->invoice_id ?>,
                        '<?= $inv->invoice_no ?>',
                        <?= $balance ?>
                    )"
								class="px-2 py-1 bg-green-600 text-white rounded text-xs">
								Pay
							</button>
						<?php endif; ?>
					</td> -->
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div id="paymentModal"
	class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">

	<div class="bg-white w-96 p-6 rounded shadow">

		<h3 class="text-lg font-bold mb-2">Add Payment</h3>
		<p class="text-sm mb-4">
			Invoice: <span id="pm_invoice_no"></span><br>
			Balance: AED <span id="pm_balance"></span>
		</p>

		<form method="post" action="<?= base_url('index.php/invoice/save_payment') ?>">

			<input type="hidden" name="invoice_id" id="pm_invoice_id">

			<div class="mb-3">
				<label class="text-sm">Payment Mode</label>
				<select name="payment_mode" class="w-full border px-2 py-1 rounded" required>
					<option value="">Select</option>
					<option>Cash</option>
					<option>Card</option>
					<option>UPI</option>
					<option>Bank Transfer</option>
					<option>Cheque</option>
				</select>
			</div>

			<div class="mb-3">
				<label class="text-sm">Amount</label>
				<input type="number" step="0.01"
					name="amount"
					id="pm_amount"
					class="w-full border px-2 py-1 rounded"
					required>
			</div>

			<div class="mb-3">
				<label class="text-sm">Reference No</label>
				<input type="text" name="reference_no"
					class="w-full border px-2 py-1 rounded">
			</div>

			<div class="mb-4">
				<label class="text-sm">Notes</label>
				<textarea name="notes"
					class="w-full border px-2 py-1 rounded"></textarea>
			</div>

			<div class="flex justify-between">
				<button type="button"
					onclick="closePaymentModal()"
					class="px-4 py-2 border rounded">
					Cancel
				</button>
				<button class="bg-green-600 text-white px-4 py-2 rounded">
					Save Payment
				</button>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {

		$('#invoiceTable').DataTable({
			pageLength: 5,
			lengthMenu: [
				[5, 10, 25, -1],
				[5, 10, 25, "All"]
			],
			responsive: true,

			// Move search box to the RIGHT
			dom: "<'flex justify-between items-center mb-3'l<f>>" +
				"t" +
				"<'flex justify-between items-center mt-3'p>",

			language: {
				search: "",
				searchPlaceholder: "Search ..."
			}
		});

	});
</script>


<script>
	function openPaymentModal(invoiceId, invoiceNo, balance) {
		document.getElementById('paymentModal').classList.remove('hidden');
		document.getElementById('pm_invoice_id').value = invoiceId;
		document.getElementById('pm_invoice_no').innerText = invoiceNo;
		document.getElementById('pm_balance').innerText = balance.toFixed(2);
		document.getElementById('pm_amount').value = balance.toFixed(2);
	}

	function closePaymentModal() {
		document.getElementById('paymentModal').classList.add('hidden');
	}
</script>
