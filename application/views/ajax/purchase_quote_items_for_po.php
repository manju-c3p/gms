<div class="w-full overflow-x-auto">
<table id="datatable-responsive"
       class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">
    
    <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">
        <tr>
            <th class="px-3 py-2 border">Product Code</th>
         
            <th class="px-3 py-2 border">Description</th>
            <th class="px-3 py-2 border">Quantity</th>
            <th class="px-3 py-2 border">Unit</th>
            <th class="px-3 py-2 border">Price</th>
            <th class="px-3 py-2 border">Dis 1(%)</th>
            <th class="px-3 py-2 border">Dis</th>
            <th class="px-3 py-2 border hidden">Dis 2(%)</th>
            <th class="px-3 py-2 border hidden">Dis</th>
            <th class="px-3 py-2 border hidden">Unit Price</th>
            <th class="px-3 py-2 border">Total</th>
        </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200">
    <?php 
    $i=5000;$up=0;$itot=0;$subtot=0;$ivat=0; 
    foreach($records2 as $r) { ?>
        
        <tr class="hover:bg-gray-50">

            <!-- Product Code -->
            <td class="px-3 py-2 border">
                <input type="text"
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       name="item_model[]"
                       value="<?php echo $r->part_name; ?>"/>

                <input type="hidden"
                       name="item_id[]"
                       value="<?php echo $r->part_id; ?>"/>
            </td>

      

            <!-- Description -->
            <td class="px-3 py-2 border">
                <input type="text"
                       class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-blue-500"
                       name="item_description[]"
                       value="<?php echo $r->part_name; ?>"/>
            </td>

            <!-- Quantity -->
            <td class="px-3 py-2 border">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 qty focus:ring-2 focus:ring-blue-500"
                       name="item_quantity[]"
                       id="item_quantity<?php echo $i; ?>"
                       value="<?php echo $r->quantity; ?>"/>
            </td>

            <!-- Unit -->
            <td class="px-3 py-2 border">
                <select class="w-full border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-blue-500"
                        name="item_unit[]"
                        id="unit0">
                    <option value="">Select</option>
                    <?php foreach($active_units as $unit){ ?>
                        <option <?php if ($r->unit_id == $unit->unit_id) echo 'selected'; ?>
                                value="<?php echo $unit->unit_id ?>">
                            <?php echo $unit->unit_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>

            <!-- Price -->
            <td class="px-3 py-2 border">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 unit_price focus:ring-2 focus:ring-blue-500"
                       name="unit_price[]"
                       step="any"
                       id="unit_price<?php echo $i; ?>"
                       value="<?php echo $r->price; ?>"/>
            </td>

            <!-- Discount 1 % -->
            <td class="px-3 py-2 border">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 dis_per focus:ring-2 focus:ring-blue-500"
                       name="dis_per[]"
                       id="discount_per<?php echo $i; ?>"
                       step="any"
                       value="<?php echo $r->dis_per; ?>"/>
            </td>

            <!-- Discount 1 Amt -->
            <td class="px-3 py-2 border">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 dis_amt focus:ring-2 focus:ring-blue-500"
                       name="dis_amt[]"
                       id="discount_amt<?php echo $i; ?>"
                       step="any"
                       value="<?php echo $r->dis_amt; ?>"/>
            </td>

            <!-- Discount 2 % -->
            <td class="px-3 py-2 border hidden">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 dis_per2 focus:ring-2 focus:ring-blue-500"
                       name="dis_per2[]"
                       id="discount_per2<?php echo $i; ?>"
                       step="any"
                       value="<?php echo $r->dis_per2; ?>"/>
            </td>

            <!-- Discount 2 Amt -->
            <td class="px-3 py-2 border hidden">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 dis_amt2 focus:ring-2 focus:ring-blue-500"
                       name="dis_amt2[]"
                       id="discount_amt2<?php echo $i; ?>"
                       step="any"
                       value="<?php echo $r->dis_amt2; ?>"/>
            </td>

            <!-- Final Unit Price -->
            <td class="px-3 py-2 border hidden">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 final_unit_price focus:ring-2 focus:ring-blue-500"
                       name="final_unit_price[]"
                       id="final_unit_price<?php echo $i; ?>"
                       step="any"
                       value="<?php echo $r->unit_price; ?>"/>
            </td>

            <!-- Total -->
            <td class="px-3 py-2 border">
                <input type="number"
                       class="w-full border border-gray-300 rounded px-2 py-1 total_price focus:ring-2 focus:ring-blue-500"
                       name="total_price[]"
                       id="total_price<?php echo $i; ?>"
                       step="any"
                       value="<?php echo $r->total; ?>"/>
            </td>

        </tr>

    <?php $i++; } ?> 

    </tbody>

</table>
</div>
