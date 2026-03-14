<div class="bg-white shadow rounded-xl p-6">
	<div>
		<h5 class="text-lg font-semibold text-gray-700">
			Tax Details
			(<?php echo isset($from_date) ? date('d-M-Y', strtotime($from_date)) : ''; ?>
			to
			<?php echo isset($to_date) ? date('d-M-Y', strtotime($to_date)) : ''; ?>)
		</h5>

		<!-- ================= SALES VAT ================= -->
		<h6 class="mt-8 text-md font-semibold text-gray-700">Sales / Output VAT (Invoice Wise)</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2">Sr.No</th>
						<th class="border px-3 py-2">Date</th>
						<th class="border px-3 py-2">Invoice No</th>
						<th class="border px-3 py-2">Customer</th>
						<th class="border px-3 py-2 text-right">Taxable</th>
						<th class="border px-3 py-2 text-right">VAT</th>
						<th class="border px-3 py-2 text-right">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$sales_tax = 0; 
					$sales_vat = 0;
					if(!empty($sales_records)){
						$i=1;
						foreach($sales_records as $row){
							$total = $row->taxable + $row->vat;
							$sales_tax += $row->taxable;
							$sales_vat += $row->vat;
					?>
					<tr>
						<td class="border px-3 py-2"><?php echo $i++; ?></td>
						<td class="border px-3 py-2"><?php echo date('d-M-Y',strtotime($row->invoice_date)); ?></td>
						<td class="border px-3 py-2"><?php echo $row->invoice_no; ?></td>
						<td class="border px-3 py-2"><?php echo $row->customer_name; ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($row->taxable,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($row->vat,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($total,2); ?></td>
					</tr>
					<?php }} else { ?>
					<tr><td colspan="7" class="text-center py-4">No Sales VAT Records</td></tr>
					<?php } ?>
				</tbody>
				<tfoot class="bg-gray-100 font-semibold">
					<tr>
						<td colspan="4" class="border px-3 py-2">Total</td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($sales_tax,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($sales_vat,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($sales_tax+$sales_vat,2); ?></td>
					</tr>
				</tfoot>
			</table>
		</div>


		<!-- ================= PURCHASE VAT ================= -->
		<h6 class="mt-10 text-md font-semibold text-gray-700">Purchase / Input VAT (GRN Wise)</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2">Sr.No</th>
						<th class="border px-3 py-2">Date</th>
						<th class="border px-3 py-2">GRN No</th>
						<th class="border px-3 py-2">Supplier</th>
						<th class="border px-3 py-2 text-right">Taxable</th>
						<th class="border px-3 py-2 text-right">VAT</th>
						<th class="border px-3 py-2 text-right">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$pur_tax = 0; 
					$pur_vat = 0;
					if(!empty($purchase_records)){
						$i=1;
						foreach($purchase_records as $row){
							$total = $row->taxable + $row->vat;
							$pur_tax += $row->taxable;
							$pur_vat += $row->vat;
					?>
					<tr>
						<td class="border px-3 py-2"><?php echo $i++; ?></td>
						<td class="border px-3 py-2"><?php echo date('d-M-Y',strtotime($row->grn_date)); ?></td>
						<td class="border px-3 py-2"><?php echo $row->grn_code; ?></td>
						<td class="border px-3 py-2"><?php echo $row->supplier_name; ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($row->taxable,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($row->vat,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($total,2); ?></td>
					</tr>
					<?php }} else { ?>
					<tr><td colspan="7" class="text-center py-4">No Purchase VAT Records</td></tr>
					<?php } ?>
				</tbody>
				<tfoot class="bg-gray-100 font-semibold">
					<tr>
						<td colspan="4" class="border px-3 py-2">Total</td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($pur_tax,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($pur_vat,2); ?></td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($pur_tax+$pur_vat,2); ?></td>
					</tr>
				</tfoot>
			</table>
		</div>


		<!-- ================= VAT SUMMARY ================= -->
		<h6 class="mt-10 text-md font-semibold text-gray-700">VAT Computation Summary</h6>
		<div class="overflow-x-auto">
			<table class="min-w-full border border-gray-200 text-sm">
				<tbody>
					<tr>
						<td class="border px-3 py-2">Total Output VAT</td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($sales_vat,2); ?></td>
					</tr>
					<tr>
						<td class="border px-3 py-2">Less : Total Input VAT</td>
						<td class="border px-3 py-2 text-right"><?php echo number_format($pur_vat,2); ?></td>
					</tr>
					<tr class="bg-gray-100 font-semibold">
						<td class="border px-3 py-2">Net VAT Payable / Refundable</td>
						<td class="border px-3 py-2 text-right">
							<?php echo number_format($sales_vat - $pur_vat,2); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>
