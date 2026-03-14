<table id="datatable-responsive" 
       class="min-w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg overflow-hidden">
    
    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
        <tr>
            <th class="px-3 py-2 border">Product Code</th>
            <!-- <th class="px-3 py-2 border">Brand</th> -->
            <th class="px-3 py-2 border">Description</th>
            <th class="px-3 py-2 border">Quantity</th>
            <th class="px-3 py-2 border">Unit</th>
            <th class="px-3 py-2 border">Price</th>
            <th class="px-3 py-2 border">Dis 1(%)</th>
            <th class="px-3 py-2 border">Dis</th>
            <th class="px-3 py-2 border hidden">Dis 2(%)</th>
            <th class="px-3 py-2 border hidden">Dis</th>
            <th class="px-3 py-2 border">Unit Price</th>
            <th class="px-3 py-2 border">Total</th>
        </tr>
    </thead>

    <tbody class="divide-y divide-gray-200 bg-white">
    <?php 
    $i=5000;$up=0;$itot=0;$subtot=0;$ivat=0; 
    foreach($records2 as $r) { ?>
        
        <tr id="<?php echo $i; ?>" class="hover:bg-gray-50">
            
            <td class="px-2 py-1 border">
                <input type="text" 
                       class="form-control w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       name="item_model[]" 
                       value="<?php echo $r->item_description; ?>"/>
                
                <input type="hidden" 
                       class="form-control"
                       name="item_id[]" 
                       value="<?php echo $r->item_id ; ?>"/>
            </td>

            <!-- <td class="px-2 py-1 border">
                <input type="text" class="form-control w-full border border-gray-300 rounded-md px-2 py-1"/>
            </td> -->

            <td class="px-2 py-1 border">
                <input type="text" 
                       class="form-control w-full border border-gray-300 rounded-md px-2 py-1 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       name="item_description[]" 
                       value="<?php echo $r->item_description; ?>"/>
            </td>

            <td class="px-2 py-1 border">
                <input type="number" 
                       class="form-control qty w-full border border-gray-300 rounded-md px-2 py-1"
                       name="item_quantity[]" 
                       id="item_quantity<?php echo $i; ?>" 
                       value="<?php echo $r->quantity; ?>"/>
            </td>

            <td class="px-2 py-1 border">
                <select class="form-control w-full border border-gray-300 rounded-md px-2 py-1"
                        name="item_unit[]">
                    <?php foreach($active_units as $unit){ ?>
                        <option <?php if ($r->purchase_unit_id == $unit->unit_id) echo 'selected'; ?> 
                                value='<?php echo $unit->unit_id ?>'>
                            <?php echo $unit->unit_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>

            <td class="px-2 py-1 border">
                <input type="number" 
                       class="form-control unit_price w-full border border-gray-300 rounded-md px-2 py-1"
                       name="unit_price[]" 
                       step="any"
                       id="unit_price<?php echo $i; ?>" 
                       value="<?php echo $r->mrp_aed; ?>"/>
            </td>

            <td class="px-2 py-1 border">
                <input type="number" 
                       class="form-control dis_per w-full border border-gray-300 rounded-md px-2 py-1"
                       id="discount_per<?php echo $i; ?>" 
                       step="any" 
                       name="dis_per[]"/>
            </td>

            <td class="px-2 py-1 border">
                <input type="number" 
                       class="form-control dis_amt w-full border border-gray-300 rounded-md px-2 py-1"
                       id="discount_amt<?php echo $i; ?>" 
                       step="any" 
                       name="dis_amt[]"/>
            </td>

            <td class="px-2 py-1 border hidden">
                <input type="number" 
                       class="form-control dis_per2 w-full border border-gray-300 rounded-md px-2 py-1"
                       id="discount_per2<?php echo $i; ?>" 
                       step="any" 
                       name="dis_per2[]"/>
            </td>

            <td class="px-2 py-1 border hidden">
                <input type="number" 
                       class="form-control dis_amt2 w-full border border-gray-300 rounded-md px-2 py-1"
                       id="discount_amt2<?php echo $i; ?>" 
                       step="any" 
                       name="dis_amt2[]"/>
            </td>

            <td class="px-2 py-1 border">
                <input type="number" 
                       class="form-control final_unit_price w-full border border-gray-300 rounded-md px-2 py-1"
                       name="final_unit_price[]" 
                       step="any"
                       id="final_unit_price<?php echo $i; ?>"/>
            </td>

            <td class="px-2 py-1 border">
                <input type="number" 
                       class="form-control total_price w-full border border-gray-300 rounded-md px-2 py-1"
                       id="total_price<?php echo $i; ?>" 
                       step="any" 
                       name="total_price[]" 
                       value="<?php echo $r->total; ?>"/>
            </td>

        </tr>
    <?php  $i++; } ?> 
    </tbody>
</table>
