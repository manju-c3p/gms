<form method="post" action="<?= site_url('Purchase/save_srn') ?>" class="space-y-6">

	<div class="bg-white shadow rounded-xl p-6 space-y-6">

		<div class="flex justify-between">
			<h1 class="text-xl font-semibold">Create SRN</h1>

			<a href="<?= site_url('Purchase/purchase_order_list') ?>"
				class="px-4 py-2 border rounded text-sm">← Back</a>
		</div>

		<input type="hidden" name="po_id" value="<?= $po->po_id ?>">

		<!-- HEADER -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-3">
				<label>Purchase Type</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->purchase_type ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>Supplier</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->supplier_code . ' - ' . $po->supplier_name ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>PO Date</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->po_date ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>SRN Date</label>
				<input type="date" id="srndate" name="srndate"
					class="w-full border rounded px-3 py-2 bg-white-100"
					value="<?= date('Y-m-d') ?>">
			</div>

		</div>

		<!-- EXTRA FIELDS -->
		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-3">
				<label>Subject</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->subject ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>Invoice No</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->supplier_ref ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>Jobcard No</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->jobcard_no ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>Freight Mode</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->freight_mode ?>" readonly>
			</div>

		</div>

		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-6">
				<label>Project</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"
					value="<?= $po->project ?>" readonly>
			</div>
		</div>

	</div>

	<!-- SERVICE TABLE -->
	<div class="bg-white shadow rounded-xl p-6">

		<table class="w-full border text-sm">

			<thead class="bg-gray-100">
				<tr>
					<th>#</th>
					<th>Description</th>
					<th>Qty</th>
					<th>Price</th>
					<th>Dis%</th>
					<th>Vat%</th>
					<th>Total</th>
				</tr>
			</thead>

			<tbody>

				<?php $i = 1;
				foreach ($po_details as $r) { ?>
					<tr>
						<td class="border p-2 text-center"><?= $i++ ?></td>

						<td class="border p-2">
							<input class="w-full border rounded px-2 py-1 bg-gray-100"
								value="<?= $r->desc ?>" readonly>
						</td>

						<td class="border p-2">
							<input class="w-full border rounded px-2 py-1 text-right bg-gray-100"
								value="<?= $r->quantity ?>" readonly>
						</td>

						<td class="border p-2">
							<input class="w-full border rounded px-2 py-1 text-right bg-gray-100"
								value="<?= $r->price ?>" readonly>
						</td>

						<td class="border p-2">
							<input class="w-full border rounded px-2 py-1 text-right bg-gray-100"
								value="<?= $r->dis_per ?>" readonly>
						</td>

						<td class="border p-2">
							<input class="w-full border rounded px-2 py-1 text-right bg-gray-100"
								value="<?= $r->service_vat_per ?>" readonly>
						</td>

						<td class="border p-2">
							<input class="w-full border rounded px-2 py-1 text-right bg-gray-100"
								value="<?= $r->total ?>" readonly>
						</td>

						<input type="hidden" name="trans_id[]" value="<?= $r->trans_id ?>">
						<input type="hidden" name="amount[]" value="<?= $r->total ?>">

					</tr>
				<?php } ?>

			</tbody>
		</table>

	</div>

	<!-- TOTAL SECTION -->
	<div class="bg-white shadow rounded-xl p-6">

		<div class="grid grid-cols-12 gap-4">

			<div class="col-span-3">
				<label>Sub Total</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100"  name="subtot"
					value="<?= $po->sub_total ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>VAT</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100" name="vatamt"
					value="<?= $po->vat_amt ?>" readonly>
			</div>

			<div class="col-span-3">
				<label>Discount</label> 
				<input class="w-full border rounded px-3 py-2 bg-gray-100"  name="disamt"
					value="<?= $po->discount ?>" readonly>
			</div>

			<div class="col-span-3">
				<label class="font-semibold">Grand Total</label>
				<input class="w-full border rounded px-3 py-2 bg-gray-100 font-semibold" name="gtotal"
					value="<?= $po->grand_total ?>" readonly>
			</div>

		</div>

	</div>

	<!-- NARRATION -->
	<div class="bg-white shadow rounded-xl p-6">
		<label>Narration</label>
		<textarea name="narration" class="w-full border rounded px-3 py-2"></textarea>
	</div>

	<!-- BUTTONS -->
	<div class="flex justify-end gap-3">

		<button type="button"
			onclick="window.location.href='<?= site_url('Purchase/purchase_order_list') ?>'"
			class="px-5 py-2 bg-gray-500 text-white rounded">
			Cancel
		</button>

		<button type="submit"
			class="px-5 py-2 bg-green-600 text-white rounded">
			Submit SRN
		</button>

	</div>

</form>
