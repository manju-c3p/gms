<div class="w-full overflow-x-auto">
	<table id="datatable-responsive"
		class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">

		<thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
			<tr>
				<th class="px-2 py-2 border">Sr.No</th>
				<th class="px-10 py-2 border">Product Code</th>
				<th class="px-2 py-2 border">Unit</th>
				<th class="px-2 py-2 border">Quantity</th>

				<th class="px-2 py-2 border">Price</th>
				<th class="px-2 py-2 border">Discount %</th>
				<th class="px-2 py-2 border">Discount</th>
				<th class="px-2 py-2 border">Total</th>

			</tr>
		</thead>

		<tbody class="bg-white divide-y divide-gray-200">

			<?php
			$i = 0;
			$up = 0;
			$itot = 0;
			$subtot = 0;
			$ivat = 0;
			$j = 1;
			foreach ($records2 as $r) { ?>

				<tr class="hover:bg-gray-50">

					<!-- Sr No -->
					<td class="px-2 py-2 border">
						<?php echo $j; ?>
					</td>

					<!-- Product -->
					<td class="px-3 py-2 border">

						<input type="text"
							class="w-full border border-gray-300 rounded px-3 py-1 bg-gray-100"
							name="item_model[]"
							value="<?php echo $r->part_name; ?>"
							readonly />

						<input type="hidden"
							name="item_id[]"
							value="<?php echo $r->part_id; ?>" />



						<input type="text"
							class="w-full border border-gray-300 rounded px-8 py-1 bg-gray-100 hidden"
							name="item_description[]"
							value="<?php echo $r->part_name; ?>"
							readonly />

					</td>

					<!-- Unit -->
					<td class="px-2 py-2 border">

						<div class="text-xs text-gray-500">Purchase Unit:</div>

						<select class="w-full border border-gray-300 rounded px-2 py-2 mb-2 bg-gray-100"
							name="item_unit[]"
							readonly>

							<option value="">Select</option>

							<?php foreach ($active_units as $unit) { ?>

								<option <?php if ($r->unit_id == $unit->unit_id) echo 'selected'; ?>
									value="<?php echo $unit->unit_id ?>">
									<?php echo $unit->unit_name; ?>
								</option>

							<?php } ?>

						</select>
						<div class="text-xs text-gray-500">Stock Unit:</div>

						<select class="w-full border border-gray-300 rounded px-2 py-2 mb-2 bg-gray-100 stock_unit"
							name="stock_unit[]"
							data-index="<?php echo $i; ?>">

							<option value="">Select</option>

							<?php foreach ($active_units as $unit) { ?>

								<option <?php if ($r->stock_unit_id == $unit->unit_id) echo 'selected'; ?>
									value="<?php echo $unit->unit_id ?>">
									<?php echo $unit->unit_name; ?>
								</option>

							<?php } ?>

						</select>
						<div class="text-xs text-gray-500">qty_per_purchase_unit:</div>

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 qty_per_purchase"
							name="qty_per_purchase[]"
							id="qty_per_purchase<?php echo $i; ?>"
							value="<?= (!empty($r->qty_per_purchase_unit)) ? $r->qty_per_purchase_unit : 1 ?>"
							/>
					</td>

					<!-- Quantity -->
					<td class="px-2 py-2 border space-y-1">

						<div class="text-xs text-gray-500">Ordered:</div>

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 qty"
							name="item_quantity[]"
							id="item_quantity<?php echo $i; ?>"
							value="<?php echo $r->quantity; ?>"
							readonly />

						<div class="text-xs text-gray-500">Received:</div>

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 rec_quantity focus:ring-2 focus:ring-blue-500"
							onchange="test(event);"
							name="rec_quantity[]"
							id="rec_quantity<?php echo $i; ?>"
							data-index="<?php echo $i; ?>" />

						<small id="error_msg<?php echo $i; ?>"
							class="text-red-600 hidden"></small>

					</td>


					<!-- Price -->
					<td class="px-2 py-2 border space-y-1">

					

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 unit_price text-right"
							name="unit_price[]"
							step="any"
							id="unit_price<?php echo $i; ?>"
							value="<?php echo $r->unit_price; ?>" />

						

					</td>
					<td class="px-2 py-2 border space-y-1">

					

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 dis_percentage text-right"
							name="dis_percentage[]"
							step="any"
							id="dis_percentage<?php echo $i; ?>"
							value="<?php echo $r->dis_per; ?>" />

					</td>

					<td class="px-2 py-2 border space-y-1">

						

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 dis_amount bg-gray-100 text-right"
							name="dis_amount[]"
							step="any"
							id="dis_amount<?php echo $i; ?>"
							value="<?php echo $r->dis_amt; ?>" readonly/>

					</td>

					<!-- Total -->
					<td class="px-2 py-2 border">

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 total_price bg-gray-100 text-right font-semibold"
							id="total_price<?php echo $i; ?>"
							step="any"
							name="total_price[]"
							value="<?php echo $r->total; ?>" readonly/>

					</td>







				</tr>

			<?php $i++;
				$j++;
			} ?>

		</tbody>
	</table>
</div>


