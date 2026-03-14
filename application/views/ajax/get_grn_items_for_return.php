<div class="w-full overflow-x-auto">

	<table id="datatable-responsive"
		class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">

		<thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">

			<tr>

				<th class="px-2 py-2 border">Sr.No</th>
				<th class="px-10 py-2 border">Product</th>
				<th class="px-2 py-2 border">Unit</th>

				<th class="px-2 py-2 border">GRN Qty</th>
				<th class="px-2 py-2 border">Returned</th>
				<th class="px-2 py-2 border">Return Qty</th>

				<th class="px-2 py-2 border">Price</th>
			
				<th class="px-2 py-2 border">Total</th>

			</tr>

		</thead>


		<tbody class="bg-white divide-y divide-gray-200">

			<?php

			$i = 0;
			$j = 1;

			foreach ($records2 as $r) {

				// $balance_qty = $r->quantity - $r->returned_qty;
				$balance_qty = $r->rec_quantity ;

			?>

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
							value="<?php echo $r->product_id; ?>" />

						<input type="hidden"
							name="grn_item_id[]"
							value="<?php echo $r->trans_id; ?>" />

					</td>


					<!-- Unit -->
					<td class="px-2 py-2 border">

						<select class="w-full border border-gray-300 rounded px-2 py-2 bg-gray-100"
							name="item_unit[]"
							readonly>

							<?php foreach ($active_units as $unit) { ?>

								<option <?php if ($r->unit == $unit->unit_id) echo 'selected'; ?>
									value="<?php echo $unit->unit_id ?>">

									<?php echo $unit->unit_name; ?>

								</option>

							<?php } ?>

						</select>

					</td>


					<!-- GRN Qty -->
					<td class="px-2 py-2 border">

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 grn_qty"
							name="grn_qty[]"
							id="grn_qty<?php echo $i; ?>"
							value="<?php echo $r->rec_quantity; ?>"
							readonly />

					</td>


					<!-- Returned Qty -->
					<td class="px-2 py-2 border">

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 returned_qty"
							name="returned_qty[]"
							id="returned_qty<?php echo $i; ?>"
							value=""
							readonly />

					</td>


					<!-- Return Qty -->
					<td class="px-2 py-2 border">

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 return_qty focus:ring-2 focus:ring-blue-500"
							name="return_qty[]"
							id="return_qty<?php echo $i; ?>"
							data-index="<?php echo $i; ?>"
							max="<?php echo $balance_qty; ?>" />

						<small class="text-gray-500">
							Balance: <?php echo $balance_qty; ?>
						</small>

					</td>


					<!-- Price -->
					<td class="px-2 py-2 border">

						<input type="number"
							class="w-full border border-gray-300 rounded px-2 py-1 unit_price text-right"
							name="unit_price[]"
							step="any"
							id="unit_price<?php echo $i; ?>"
							value="<?php echo $r->price; ?>" />

					</td>


					<!-- Discount % -->
					


					<!-- Discount Amount -->
				


					<!-- Total -->
					<td class="px-2 py-2 border">

						<input type="number"
							class="row_total w-full border border-gray-300 rounded px-2 py-1 total_price bg-gray-100 text-right font-semibold"
							name="total_price[]"
							id="total_price<?php echo $i; ?>"
							step="any"
							value="<?php echo $r->total; ?>"
							readonly />

					</td>


				</tr>

			<?php
				$i++;
				$j++;
			}
			?>

		</tbody>

	</table>

</div>
