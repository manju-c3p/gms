<div class="bg-white shadow rounded-xl p-6">
	<div>
		<h5 class="text-lg font-semibold text-gray-700">
			Tax Details
			(<?php echo isset($from_date) ? date('d-M-Y', strtotime($from_date)) : ''; ?>
			to
			<?php echo isset($to_date) ? date('d-M-Y', strtotime($to_date)) : ''; ?>)
		</h5>

		<!-- Output VAT (CR) -->
		<h6 class="mt-10 text-md font-semibold text-gray-700">Voucher / Journal Output VAT (CR)</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2">Sr.No</th>
						<th class="border px-3 py-2">Date</th>
						<th class="border px-3 py-2">Voucher Code</th>
						<th class="border px-3 py-2">Voucher Type</th>
						<th class="border px-3 py-2">Customer/Supplier</th>
						<th class="border px-3 py-2 text-right">Taxable Amount</th>
						<th class="border px-3 py-2 text-right">VAT</th>
						<th class="border px-3 py-2 text-right">Total</th>
					</tr>
				</thead>
				<tbody class="divide-y">
					<?php
					if (!empty($voucher_records->output)) {
						$i = 1;
						$grand_tax = 0;
						$grand_vat  = 0;

						foreach ($voucher_records->output as $row) {
							$taxable = $row->taxable_amount;
							$vat     = $row->vat_amount;
							$total   = $row->total;

							$grand_tax += $taxable;
							$grand_vat  += $vat;
					?>
							<tr class="hover:bg-gray-50">
								<td class="border px-3 py-2"><?php echo $i++; ?></td>
								<td class="border px-3 py-2"><?php echo date('d-M-Y', strtotime($row->voucher_date)); ?></td>
								<td class="border px-3 py-2"><?php echo $row->voucher_code; ?></td>
								<td class="border px-3 py-2"><?php echo $row->voucher_type; ?></td>
								<td class="border px-3 py-2">-</td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($taxable, 2); ?></td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($vat, 2); ?></td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($total, 2); ?></td>
							</tr>
						<?php
						}
					} else {
						?>
						<tr>
							<td colspan="8" class="border px-3 py-4 text-center text-gray-400">No Output (CR) vouchers found.</td>
						</tr>
					<?php } ?>
				</tbody>
				<?php if (!empty($voucher_records->output)) { ?>
					<tfoot class="bg-gray-100 font-semibold">
						<tr>
							<td colspan="5" class="border px-3 py-2">Total</td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_tax, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_vat, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_tax + $grand_vat, 2); ?></td>
						</tr>
					</tfoot>
				<?php } ?>
			</table>
		</div>

		<!-- Input VAT (DR) -->
		<h6 class="mt-10 text-md font-semibold text-gray-700">Voucher / Journal Input VAT (DR)</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2">Sr.No</th>
						<th class="border px-3 py-2">Date</th>
						<th class="border px-3 py-2">Voucher Code</th>
						<th class="border px-3 py-2">Voucher Type</th>
						<th class="border px-3 py-2">Customer/Supplier</th>
						<th class="border px-3 py-2 text-right">Taxable Amount</th>
						<th class="border px-3 py-2 text-right">VAT</th>
						<th class="border px-3 py-2 text-right">Total</th>
					</tr>
				</thead>
				<tbody class="divide-y">
					<?php
					if (!empty($voucher_records->input)) {
						$i = 1;
						$grand_tax = 0;
						$grand_vat  = 0;

						foreach ($voucher_records->input as $row) {
							$taxable = $row->taxable_amount;
							$vat     = $row->vat_amount;
							$total   = $row->total;

							$grand_tax += $taxable;
							$grand_vat  += $vat;
					?>
							<tr class="hover:bg-gray-50">
								<td class="border px-3 py-2"><?php echo $i++; ?></td>
								<td class="border px-3 py-2"><?php echo date('d-M-Y', strtotime($row->voucher_date)); ?></td>
								<td class="border px-3 py-2"><?php echo $row->voucher_code; ?></td>
								<td class="border px-3 py-2"><?php echo $row->voucher_type; ?></td>
								<td class="border px-3 py-2">-</td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($taxable, 2); ?></td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($vat, 2); ?></td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($total, 2); ?></td>
							</tr>
						<?php
						}
					} else {
						?>
						<tr>
							<td colspan="8" class="border px-3 py-4 text-center text-gray-400">No Input (DR) vouchers found.</td>
						</tr>
					<?php } ?>
				</tbody>
				<?php if (!empty($voucher_records->input)) { ?>
					<tfoot class="bg-gray-100 font-semibold">
						<tr>
							<td colspan="5" class="border px-3 py-2">Total</td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_tax, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_vat, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_tax + $grand_vat, 2); ?></td>
						</tr>
					</tfoot>
				<?php } ?>
			</table>
		</div>

		<!-- Sales / Output VAT -->
		<h6 class="mt-6 text-md font-semibold text-gray-700">Sales / Output VAT</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2">Sr.No</th>
						<th class="border px-3 py-2">Date</th>
						<th class="border px-3 py-2">Invoice No</th>
						<th class="border px-3 py-2">Customer</th>
						<th class="border px-3 py-2 text-right">Taxable Amount</th>
						<th class="border px-3 py-2 text-right">VAT</th>
						<th class="border px-3 py-2 text-right">Total</th>
					</tr>
				</thead>
				<tbody class="divide-y">
					<?php
					if (isset($purchase_records) && !empty($purchase_records)) {
						$i = 1;
						$grand_tax = 0;
						$grand_vat = 0;

						foreach ($purchase_records as $row) {
							$taxable = isset($row->taxable) ? $row->taxable : 0;
							$vat = isset($row->vat) ? $row->vat : 0;
							$total = $taxable + $vat;

							$grand_tax += $taxable;
							$grand_vat += $vat;
					?>
							<tr class="hover:bg-gray-50">
								<td class="border px-3 py-2"><?php echo $i++; ?></td>
								<td class="border px-3 py-2"><?php echo isset($row->grn_date) ? date('d-M-Y', strtotime($row->grn_date)) : ''; ?></td>
								<td class="border px-3 py-2"><?php echo isset($row->grn_code) ? $row->grn_code : ''; ?></td>
								<td class="border px-3 py-2"><?php echo isset($row->supplier_name) ? $row->supplier_name : ''; ?></td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($taxable, 2); ?></td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($vat, 2); ?></td>
								<td class="border px-3 py-2 text-right"><?php echo number_format($total, 2); ?></td>
							</tr>
						<?php
						}
					} else {
						?>
						<tr>
							<td colspan="7" class="border px-3 py-4 text-center text-gray-400">No purchase records found for selected date range.</td>
						</tr>
					<?php } ?>
				</tbody>
				<?php if (isset($purchase_summary) && !empty($purchase_summary)) { ?>
					<tfoot class="bg-gray-100 font-semibold">
						<tr>
							<td colspan="4" class="border px-3 py-2">Total</td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_tax, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_vat, 2); ?></td>
							<td class="border px-3 py-2 text-right"><?php echo number_format($grand_tax + $grand_vat, 2); ?></td>
						</tr>
					</tfoot>
				<?php } ?>
			</table>
		</div>

		
	</div>
</div>
