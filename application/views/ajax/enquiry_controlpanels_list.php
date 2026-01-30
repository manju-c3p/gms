<?php $k=1; $i=1; $j = 1; foreach($records as $r) { ?>
	
	<table class="bg-soft-green" width="100%" border="1" style="font-size:15px; font-weight:bold;color:white;" bgcolor="#34934E">
	<tr>
		 <th><?php echo $k; ?></th>
		 <th><?php echo $r->product_desc; ?></th>
		 <th><?php echo $r->quantity; ?></th>
		 <input type="hidden"  name="enq_trsna_id[]" value="<?php echo $r->trans_id; ?>" />
	</tr>
	</table>
	<table class="bg-soft-green" width="100%" border="1" id="tab_logic">
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Main Categories</th>
                    <th>Description</th>
                    <th>Make</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //$i = 1;  
                $j = 1;
                $lastCategory = null; 

                foreach ($records1 as $row): ?>
                    <tr>
                        <td>
                            <?php if ($lastCategory !== $row->category_name): ?>
                                <?php echo $i++; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                        <?php 
                            if ($lastCategory !== $row->category_name) {
                            echo $row->category_name;
                                        $lastCategory = $row->category_name; 
                            }?>
                            <input type="hidden" class="bg-soft-gray form-control" readonly  class="bg-soft-gray" name="category_name<?php echo $r->trans_id; ?>[]"  value="<?php echo $row->category_name;?>" readonly /> 
                        </td>
                        <td><input type="text" class='form-control' name="item_name<?php echo $r->trans_id; ?>[]"  value="<?php echo $row->item_name; ?>" /></td>
                        <td><input type="text" class='form-control' name="make_model<?php echo $r->trans_id; ?>[]"  value="<?php echo $row->make_model; ?>" /></td>         
                        <td><input type="number" step='any' id="qty<?php echo $k.$j;?>" name="qty<?php echo $r->trans_id; ?>[]" class="form-control form-control" min="0" value="0" onchange="calculate_total(<?php echo $k.$j;?>,<?php echo $k;?>)" /></td>
                        <td>
                        	<input type="text" class="bg-soft-gray form-control" readonly  name="unit_abbr<?php echo $r->trans_id; ?>[]"  value="<?php echo $row->unit_abbr; ?>" />
                        	<input type="hidden" class="bg-soft-gray form-control" readonly  name="unit_id<?php echo $r->trans_id; ?>[]"  value="<?php echo $row->unit_id; ?>" />	
                        </td>
                        <td><input type="number" step='any' id="unit_price<?php echo $k.$j;?>" name="unit_price<?php echo $r->trans_id; ?>[]"  min="0" value="0" onchange="calculate_total(<?php echo $k.$j;?>,<?php echo $k;?>)" class='form-control' /></td>
                        <td><input type="text" id="total<?php echo $k.$j;?>" name="total<?php echo $r->trans_id; ?>[]" class="bg-soft-gray form-control subItemAmt<?php echo $k;?>" readonly />
                         </td>
                    </tr>
                <?php $j++; endforeach; ?>
            </tbody>
        </table>
        </div>
        </div>
	
	<div class="form-group row">
	 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
    	<table class="bg-soft-green" width="100%" border="1" id="total_summary" name="total_summary<?php echo $r->trans_id;?>" style="font-size:14px;font-weight:bold;">
	    	<tbody>
			<tr>
				<td style="width: 550px;"></td>
				<th colspan="3">Total</th>
				<td><input type="text" name="total_amt<?php echo $r->trans_id; ?>" id='total_amt<?php echo $k;?>' readonly class='bg-soft-gray totalvalue<?php echo $k;?>' /></td>
			</tr>	    
			<tr>
				<td style="width: 300px;"></td>
				<td>Control Panel Accessories</td>
				<td width='100px'><input type="number" step='any' style="width: 100px;" id="cp_acce_percent<?php echo $k;?>" name="cp_acce_percent<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)'  /> %</td>
				<td style="width: 100px;"></td>
				<td><input type="number" step='any' id='cp_acce_amt<?php echo $k;?>' name="cp_acce_amt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>
			</tr>	    
			<tr>
				<td style="width: 300px;"></td>
				<td>Control Panel Assembling</td>
				<td width='100px'><input type="number" step='any' style="width: 100px;" id="assembling<?php echo $k;?>" name="assembling<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)'  /> %</td>
				<td style="width: 100px;"></td>
				<td><input type="number" step='any' id='assembling_amt<?php echo $k;?>' name="assembling_amt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>
			</tr>
			<tr>
				<td style="width: 100px;"></td>
				<td>Overheads</td>
				<td><input type="number" step='any' style="width: 100px;" id="overheads<?php echo $k;?>" name="overheads<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)' /> %</td>
				<td style="width: 100px;"></td>
				<td><input type="number" step='any' id='overheads_amt<?php echo $k;?>' name="overheads_amt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>
			</tr>
			<tr>
			<td style="width: 100px;"></td>
			<td>Auto CAD Drawing</td>
			<td><input type="number" step='any' style="width: 100px;" id="auto_cad<?php echo $k;?>" name="auto_cad<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)' /> %</td>
			<td style="width: 100px;"></td>
			<td><input type="number" step='any' id='auto_cad_amt<?php echo $k;?>' name="auto_cad_amt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>

			</tr>
			<tr>
			<td style="width: 100px;"></td>

			<td>Programming (PLC & HMI)</td>
			<td><input type="number" step='any' style="width: 100px;" id="programming<?php echo $k;?>" name="programming<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)' /> %</td>
			<td style="width: 100px;"></td>
			<td><input type="number" step='any' id='pamt<?php echo $k;?>' name="pamt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>

			</tr>
			<tr>
			<td style="width: 100px;"></td>
			<td>Site Commissioning</td>
			<td><input type="number" step='any' style="width: 100px;" id="site_commissioning<?php echo $k;?>" name="site_commissioning<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)' /> %</td>
			<td style="width: 100px;"></td>
			<td><input type="number" step='any' id='site_amt<?php echo $k;?>' name="site_amt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>

			</tr>
			<tr>
			<td style="width: 100px;"></td>

			<td>Documentation Charges</td>
			<td><input type="number" step='any' style="width: 100px;" id="documentation<?php echo $k;?>" name="documentation<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)' /> %</td>
			<td style="width: 100px;"></td>
			<td><input type="number" step='any' id='damt<?php echo $k;?>' name="damt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>

			</tr>
			<tr>
			<td style="width: 100px;"></td>

			<td>Transport Charges</td>
			<td><input type="number" step='any' style="width: 100px;" id="transport<?php echo $k;?>" name="transport<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)' /> %</td>
			<td style="width: 100px;"></td>
			<td><input type="number" step='any' id='tr_amt<?php echo $k;?>' name="transport_amt<?php echo $r->trans_id; ?>" class='totalvalue<?php echo $k;?>' /></td>

			</tr>
			<tr>
			<td style="width: 100px;"></td>

			<td colspan="2"> SUB TOTAL</td>
			<td style="width: 100px;"></td>
			<td><input type="text" name="subtot<?php echo $r->trans_id; ?>" id="subtot<?php echo $k;?>" readonly class='bg-soft-gray' /></td>

			</tr>
			<tr>
			<td style="width: 100px;"></td>

			<td> Margin</td>
			<td><input type="number" step='any' style="width: 100px;" id="margin<?php echo $k;?>" name="margin<?php echo $r->trans_id; ?>" onblur='calculate_grand_total(<?php echo $k;?>)' /> %</td>
			<td style="width: 100px;"></td>
			<td><input type="number" step='any' name="margin_amt<?php echo $r->trans_id; ?>" id="margin_amt<?php echo $k;?>" /></td>

			</tr>
			<tr>
			<td style="width: 100px;"></td>

			<td colspan="2">GRAND TOTAL </td>
			<td style="width: 100px;"></td>
			<td><input type="text" name="grand_total<?php echo $r->trans_id; ?>" id="grand_total<?php echo $k;?>" readonly class='bg-soft-gray' /></td>

			</tr>
		</tbody>
   	</table>
	</div>
	</div>
<?php  $k++; } ?>
