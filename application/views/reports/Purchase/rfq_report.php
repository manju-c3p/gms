<?php
$user = $this->session->userdata('user_id');
?>
<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Reports/get_rfq_report" autocomplete="off" enctype="multipart/form-data">

	<!-- page content -->
	<div class="w-full bg-white" role="main">
		<div class="w-full">
			<!-- Title -->
			<div class="mb-4 bg-white">
				<h1 class="text-2xl font-bold text-gray-800">RFQ Reports</h1>
				<p class="text-sm text-gray-500">Request for Quotation report list and filters</p>
			</div>
			<div class="bg-white shadow rounded-lg p-4 mb-4">

				<div class="flex flex-wrap items-end gap-4">

					<!-- Date From -->
					<div class="flex items-center gap-2">
						<label class="text-sm font-medium whitespace-nowrap">Date From:</label>
						<input type="date" name="from_date"
							class="border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
							value="<?php echo $from; ?>" />
					</div>

					<!-- Date To -->
					<div class="flex items-center gap-2">
						<label class="text-sm font-medium whitespace-nowrap">Date To:</label>
						<input type="date" name="to_date"
							class="border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400"
							value="<?php echo $to; ?>" />
					</div>

					<!-- Supplier -->
					<div class="flex items-center gap-2">
						<label class="text-sm font-medium whitespace-nowrap">Supplier:</label>
						<select name="supplier_id" id="supplier_id"
							class="border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:border-blue-400 select2"
							tabindex="2">
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
					<div class="flex items-center gap-2">
						<button type="submit"
							class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
							Go
						</button>

						<a href=""
							onclick="printRFQReport()"
							class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
							Print
						</a>
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
							<th class="border px-3 py-2 text-left text-sm font-semibold">RFQ Code</th>
							<th class="border px-3 py-2 text-left text-sm font-semibold">RFQ Date</th>
							<th class="border px-3 py-2 text-left text-sm font-semibold">Supplier</th>
							<th class="border px-3 py-2 text-left text-sm font-semibold">Created By</th>
						</tr>
					</thead>

					<tbody>
						<?php $i = 1;
						foreach ($records as $row) : ?>
							<tr class="hover:bg-gray-50">
								<td class="border px-3 py-2"><?php echo  $i;
																							$i++; ?></td>

								<td class="border px-3 py-2">
									<a target="blank"
										title="RFQ Details"
										href="<?php echo base_url() . 'index.php/Purchase/edit_rfq/' . $row->rfq_id . '/' . $row->rev_version; ?>"
										class="text-blue-600 hover:underline">
										<?php echo $row->rfq_code; ?>
									</a>
								</td>

								<td class="border px-3 py-2">
									<?php echo date('d-M-Y', strtotime($row->rfq_date)); ?>
								</td>

								<td class="border px-3 py-2">
									<?php echo $row->supplier_name; ?>
								</td>

								<td class="border px-3 py-2">
									<?php echo $row->rfq_created_by; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>

					<tfoot class="bg-gray-100">
						<!-- <tr>
                            <th class="border px-3 py-2 text-left text-sm font-semibold">Sr. No</th>
                            <th class="border px-3 py-2 text-left text-sm font-semibold">RFQ Code</th>
                            <th class="border px-3 py-2 text-left text-sm font-semibold">RFQ Date</th>
                            <th class="border px-3 py-2 text-left text-sm font-semibold">Supplier</th>
                            <th class="border px-3 py-2 text-left text-sm font-semibold">Created By</th>
                        </tr> -->
					</tfoot>

				</table>

			</div>

		</div>
	</div>

</form>


<script>
	function printRFQReport() {

		const fromDate = document.querySelector('input[name="from_date"]').value;
		const toDate = document.querySelector('input[name="to_date"]').value;
		const supplierId = document.querySelector('select[name="supplier_id"]').value;

		const baseUrl = "<?php echo base_url() . 'index.php/Reports/print_rfq_report'; ?>";

		const params = new URLSearchParams({
			from_date: fromDate,
			to_date: toDate,
			supplier_id: supplierId
		});

		const printUrl = `${baseUrl}?${params.toString()}`;

		window.open(printUrl, '_blank');

	}
</script>
