<div class="bg-white shadow rounded-xl p-6">
	<div>
		<h5 class="text-lg font-semibold text-gray-700">
			Tax Summary
			(<?php echo isset($from_date) ? date('d-M-Y', strtotime($from_date)) : ''; ?>
			to
			<?php echo isset($to_date) ? date('d-M-Y', strtotime($to_date)) : ''; ?>)
		</h5>

		<!-- Voucher VAT Summary -->
		<h6 class="mt-6 text-md font-semibold text-gray-700">Voucher VAT Summary</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Type</th>
						<th class="border px-3 py-2 text-right">Taxable Amount</th>
						<th class="border px-3 py-2 text-right">VAT</th>
						<th class="border px-3 py-2 text-right">Total (Taxable + VAT)</th>
					</tr>
				</thead>
				<tbody class="divide-y">
					<?php if (isset($voucher_summary) && !empty($voucher_summary)) { ?>
						<tr class="hover:bg-gray-50">
							<td class="border px-3 py-2">Input VAT (Dr)</td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($voucher_summary->input['taxable'], 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($voucher_summary->input['vat'], 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($voucher_summary->input['total'], 2); ?></td>
						</tr>
						<tr class="hover:bg-gray-50">
							<td class="border px-3 py-2">Output VAT (Cr)</td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($voucher_summary->output['taxable'], 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($voucher_summary->output['vat'], 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($voucher_summary->output['total'], 2); ?></td>
						</tr>
					<?php } else { ?>
						<tr>
							<td colspan="4" class="border px-3 py-4 text-center text-gray-400">No voucher VAT data found.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

		<!-- Output VAT (Sales) -->
		<h6 class="mt-6 text-md font-semibold text-gray-700">Output VAT (Sales)</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Sr.No</th>
						<th class="border px-3 py-2 text-right">Taxable Amount</th>
						<th class="border px-3 py-2 text-right">VAT</th>
					</tr>
				</thead>
				<tbody class="divide-y">

					<?php
					if (isset($sales_records) && !empty($sales_records)) {

						$i = 1;
						$gt_taxable = 0;
						$gt_vat = 0;

						foreach ($sales_records as $row) {

							$taxable = $row->taxable ?? 0;
							$vat     = $row->vat ?? 0;

							$gt_taxable += $taxable;
							$gt_vat     += $vat;
					?>

							<tr class="hover:bg-gray-50">
								<td class="border px-3 py-2">
									<?php echo $i++ . '. ' . ($row->emirates ?: 'Unknown'); ?>
								</td>

								<td class="border px-3 py-2 text-right">
									<?php echo number_format($taxable, 2); ?>
								</td>

								<td class="border px-3 py-2 text-right">
									<?php echo number_format($vat, 2); ?>
								</td>
							</tr>

						<?php } ?>

						<!-- GRAND TOTAL -->
						<tr class="bg-gray-100 font-semibold">
							<td class="border px-3 py-2">Total</td>
							<td class="border px-3 py-2 text-right">
								<?php echo number_format($gt_taxable, 2); ?>
							</td>
							<td class="border px-3 py-2 text-right">
								<?php echo number_format($gt_vat, 2); ?>
							</td>
						</tr>

					<?php
					} else {
					?>
						<tr>
							<td colspan="3" class="border px-3 py-4 text-center text-gray-400">
								No sales records found.
							</td>
						</tr>
					<?php } ?>

				</tbody>
				<!-- <tbody class="divide-y"> -->
				<?php
				// if (isset($sales_records) && !empty($sales_records)) {
				// 	$taxable = isset($sales_records->taxable) ? $sales_records->taxable : 0;
				// 	$vat = isset($sales_records->vat) ? $sales_records->vat : 0;
				// 
				?>
				<!-- <tr class="hover:bg-gray-50">
							<td class="border px-3 py-2">1</td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($taxable, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($vat, 2); ?></td>
						</tr> -->
				<?php
				// } else {
				?>
				<!-- <tr>
							<td colspan="3" class="border px-3 py-4 text-center text-gray-400">No sales records found.</td>
						</tr> -->
				<?php
				// } 
				?>
				<!-- </tbody> -->
			</table>
		</div>

		<!-- Input VAT (Purchases / GRN) -->
		<h6 class="mt-6 text-md font-semibold text-gray-700">Input VAT (Purchases)</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Sr.No</th>
						<th class="border px-3 py-2 text-right">Taxable Amount</th>
						<th class="border px-3 py-2 text-right">VAT</th>
						<th class="border px-3 py-2 text-right">Total (Taxable + VAT)</th>
					</tr>
				</thead>
				<tbody class="divide-y">
					<?php
					if (isset($purchase_summary) && !empty($purchase_summary)) {
						$i = 1;
						$taxable = isset($purchase_summary->taxable) ? $purchase_summary->taxable : 0;
						$vat     = isset($purchase_summary->vat) ? $purchase_summary->vat : 0;
						$total   = isset($purchase_summary->total) ? $purchase_summary->total : ($taxable + $vat);
					?>
						<tr class="hover:bg-gray-50">
							<td class="border px-3 py-2"><?php echo $i++; ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($taxable, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($vat, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($total, 2); ?></td>
						</tr>
					<?php
					} else {
					?>
						<tr>
							<td colspan="4" class="border px-3 py-4 text-center text-gray-400">No purchase records found.</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>


		<!-- Final VAT Payable Summary -->
		<h6 class="mt-8 text-md font-semibold text-gray-700">VAT Payable Summary</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Description</th>
						<th class="border px-3 py-2 text-right">Amount</th>
					</tr>
				</thead>
				<tbody class="divide-y">

					<?php
					$output_vat = 0;
					$input_vat = 0;

					// Sales Output VAT
					// if (isset($sales_records) && !empty($sales_records)) {
					// 	$output_vat += $sales_records->vat;
					// }

					// Voucher Output VAT
					if (isset($voucher_summary) && !empty($voucher_summary)) {
						$output_vat += $voucher_summary->output['vat'];
						$input_vat += $voucher_summary->input['vat'];
					}

					// Purchase Input VAT
					// if (isset($purchase_summary) && !empty($purchase_summary)) {
					// 	$input_vat += $purchase_summary->vat;
					// }

					$net_vat = $output_vat - $input_vat;
					?>

					<tr class="hover:bg-gray-50">
						<td class="border px-3 py-2">Total Output VAT</td>
						<td class="border px-3 py-2 text-right font-medium">
							<?php echo number_format($output_vat, 2); ?>
						</td>
					</tr>

					<tr class="hover:bg-gray-50">
						<td class="border px-3 py-2">Less : Total Input VAT</td>
						<td class="border px-3 py-2 text-right font-medium">
							<?php echo number_format($input_vat, 2); ?>
						</td>
					</tr>

					<tr class="bg-gray-100 font-semibold">
						<td class="border px-3 py-2">Net VAT Payable / Refundable</td>
						<td class="border px-3 py-2 text-right text-lg">
							<?php echo number_format($net_vat, 2); ?>
						</td>
					</tr>

				</tbody>
			</table>
		</div>

	</div>
</div>
