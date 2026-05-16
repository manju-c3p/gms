<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<?php
$user = $this->session->userdata('user_id');
?>
<style>
	.select2-container {
    width: 100% !important;
}

.select2-dropdown {
    width: 420px !important;
}

.select2-results__option {
    white-space: nowrap;
}

.select2-selection__rendered {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Reports/get_po_report" autocomplete="off" enctype="multipart/form-data">

	<!-- page content -->
	<div class="w-full bg-white" role="main">

		<!-- Title -->
		<div class="mb-4 border-b pb-3">
			<h1 class="text-xl font-semibold text-gray-800">PO Reports</h1>
			<p class="text-sm text-gray-500">Purchase Order report list and filters</p>
		</div>


		<!-- Filters -->
		<div class="bg-white shadow rounded-lg p-4 mb-4">

			<div class="flex flex-wrap items-end gap-6">

				<!-- Date From -->
				<div class="flex flex-col">
					<label class="text-sm font-medium mb-1">Date From</label>
					<input type="date" name="from_date"
						class="border border-gray-300 rounded px-3 py-2 w-44"
						value="<?php echo $from; ?>" />
				</div>

				<!-- Date To -->
				<div class="flex flex-col">
					<label class="text-sm font-medium mb-1">Date To</label>
					<input type="date" name="to_date"
						class="border border-gray-300 rounded px-3 py-2 w-44"
						value="<?php echo $to; ?>" />
				</div>

				<!-- Supplier -->
				<div class="flex flex-col">
					<label class="text-sm font-medium mb-1">Supplier</label>
					<select name="supplier_id" id="supplier_id"
						class="border border-gray-300 rounded px-3 py-2 w-96 select2 debtor-select">
						<option value="">-select-</option>

						<?php foreach ($supplier_records as $g) { ?>
							<option <?php if ($supplier_id == $g->supplier_id) echo 'selected'; ?>
								value="<?php echo $g->supplier_id; ?>">
								<?php echo $g->supplier_code . ' ' . $g->supplier_name; ?>
							</option>
						<?php } ?>

					</select>
				</div>

				<!-- Buttons -->
				<div class="flex flex-col justify-end">
					<label class="invisible mb-1">Actions</label>

					<div class="flex items-center gap-3">

						<!-- Go -->
						<button type="submit"
							class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
							Go
						</button>

						<!-- Print -->
						<a href="javascript:void(0)"
							onclick="printPOReport()"
							class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow flex items-center gap-2">
							<i class="fa fa-print"></i>
							Print
						</a>

						<!-- Export -->
						<a href="javascript:void(0)"
							onclick="exportPOExcel()"
							class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow flex items-center gap-2">
							📥 Export Excel
						</a>

					</div>
				</div>

			</div>

		</div>



		<!-- Table -->
		<div class="bg-white shadow rounded-lg p-4 overflow-x-auto">

			<table id="basic-btn"
				class="min-w-full border border-gray-200 rounded-lg overflow-hidden">

				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left text-sm font-semibold">Sr. No</th>
						<th class="border px-3 py-2 text-left text-sm font-semibold">PO Code</th>
						<th class="border px-3 py-2 text-left text-sm font-semibold">PO Date</th>
						<th class="border px-3 py-2 text-left text-sm font-semibold">Supplier</th>
						<th class="border px-3 py-2 text-left text-sm font-semibold">Grand Total</th>
						<th class="border px-3 py-2 text-left text-sm font-semibold">Created By</th>
					</tr>
				</thead>

				<tbody>
					<?php $i = 1;
					foreach ($records as $row) : ?>
						<tr class="hover:bg-gray-50">

							<td class="border px-3 py-2">
								<?php echo  $i;
								$i++; ?>
							</td>

							<td class="border px-3 py-2">
								<a target="blank"
									title="RFQ Details"
									href="<?php echo base_url() . 'index.php/Purchase/edit_po/' . $row->po_id; ?>"
									class="text-blue-600 hover:underline">
									<?php echo $row->po_code; ?>
								</a>
							</td>

							<td class="border px-3 py-2">
								<?php echo date('d-M-Y', strtotime($row->po_date)); ?>
							</td>

							<td class="border px-3 py-2">
								<?php echo $row->supplier_name; ?>
							</td>

							<td class="border px-3 py-2">
								<?php echo $row->grand_total; ?>
							</td>

							<td class="border px-3 py-2">
								<?php echo $row->rfq_created_by; ?>
							</td>

						</tr>
					<?php endforeach; ?>
				</tbody>



			</table>

		</div>

	</div>

</form>



<script>
	function printPOReport() {

		const fromDate = document.querySelector('input[name="from_date"]').value;
		const toDate = document.querySelector('input[name="to_date"]').value;
		const supplierId = document.querySelector('select[name="supplier_id"]').value;
		// const brandId = document.querySelector('select[name="brand_id"]').value;

		const baseUrl = "<?php echo base_url() . 'index.php/Reports/print_po_report'; ?>";

		const params = new URLSearchParams({
			from_date: fromDate,
			to_date: toDate,
			supplier_id: supplierId,
			// brand_id: brandId
		});

		window.open(`${baseUrl}?${params.toString()}`, '_blank');

	}

	function exportPOExcel() {
		const fromDate = document.querySelector('input[name="from_date"]').value;
		const toDate = document.querySelector('input[name="to_date"]').value;
		const supplierId = document.querySelector('select[name="supplier_id"]').value;

		const baseUrl = "<?php echo base_url() . 'index.php/Reports/export_po_excel'; ?>";

		const params = new URLSearchParams({
			from_date: fromDate,
			to_date: toDate,
			supplier: supplierId // ✅ match controller
		});

		window.location.href = baseUrl + '?' + params.toString();
	}
	$(document).ready(function() {
		$('.debtor-select').select2({
			width: '100%'
		});


	});
</script>
