	<!-- DataTables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

	<div class="w-full bg-white rounded-2xl shadow-md p-6">

		<div class="bg-white rounded-xl shadow-sm p-4 mb-4">



			<!-- Title -->
			<div class="flex items-center gap-2 mb-4">
				<span class="text-xl">📜</span>
				<h2 class="text-xl font-semibold">
					Customer Billing History
				</h2>
			</div>
			<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
				<!-- Filters -->
				<form method="get" action="<?= base_url('index.php/billing_history') ?>"
					class="flex flex-wrap items-end gap-3">

					<input type="text" name="customer_name"
						value="<?= $_GET['customer_name'] ?? '' ?>"
						placeholder="Customer Name"
						class="border rounded-lg h-[43px] px-3 w-48">

					<input type="text" name="customer_phone"
						value="<?= $_GET['customer_phone'] ?? '' ?>"
						placeholder="Mobile No"
						class="border rounded-lg h-[43px] px-3 w-40">

					<input type="text" name="vin_no"
						value="<?= $_GET['vin_no'] ?? '' ?>"
						placeholder="Chassis / VIN No"
						class="border rounded-lg h-[43px] px-3 w-56">

					<input type="text" name="plate_no"
						value="<?= $_GET['plate_no'] ?? '' ?>"
						placeholder="Plate No"
						class="border rounded-lg h-[43px] px-3 w-40">

					<button type="submit"
						class="bg-blue-600 text-white px-5 h-[38px] rounded-lg">
						Filter
					</button>

					<button class="bg-green-600 text-white px-5 h-[38px] rounded-lg"><a href="<?= base_url('index.php/billing_history/export_excel?' . http_build_query($_GET)) ?>">
						⬇ Excel
					</a></button>

					<button class="bg-gray-500 text-white px-5 h-[38px] rounded-lg"><a href="<?= base_url('index.php/billing_history') ?>">
						Reset
					</a></button>
				</form>

			</div>
		</div>






		<table id="billingTable" class="w-full text-sm">
			<thead>
				<tr class="bg-gray-100 text-gray-700">
					<th class="p-3">Invoice No</th>
					<th class="p-3">Billing Date</th>
					<th class="p-3">Customer</th>
					<th class="p-3">Mobile</th>
					<th class="p-3">Plate No</th>
					<th class="p-3 text-right">Total Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($invoices as $inv): ?>
					<tr class="border-b hover:bg-gray-50">
						<td class="p-3 font-medium text-blue-600">
							<a href="<?= base_url('index.php/billing_history/view/' . $inv->invoice_id) ?>"
								class="hover:underline">
								<?= $inv->billing_no ?>
							</a>
						</td>
						<td class="p-3">
							<?= date('d-m-Y', strtotime($inv->billing_date)) ?>
						</td>
						<td class="p-3"><?= $inv->customer_name ?></td>
						<td class="p-3"><?= $inv->customer_phone ?></td>
						<td class="p-3"><?= $inv->plate_no ?></td>
						<td class="p-3 text-right font-semibold">
							<?= number_format($inv->total_amount, 2) ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	</div>

	<script>
		$(document).ready(function() {
			$('#billingTable').DataTable({
				pageLength: 10,
				order: [
					[1, 'desc']
				],
				language: {
					search: "Search:",
					lengthMenu: "Show _MENU_ entries"
				}
			});

			// ✅ Select2 init
			$('#customer_id').select2({
				width: '100%',
				placeholder: 'Select Customer',
				allowClear: true
			});
		});
	</script>
	<style>
		.select2-container .select2-selection--single {
			height: 38px;
		}

		.select2-selection__rendered {
			line-height: 38px !important;
		}

		.select2-selection__arrow {
			height: 38px;
		}
	</style>
