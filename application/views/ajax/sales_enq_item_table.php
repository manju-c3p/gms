<?php $i=51; foreach($records2 as $r) { ?>
	<tr id="addr<?php echo $i;?>">
		<td>
			<textarea name="desc[]" id="desc<?php echo $i;?>" class="form-control form-control-sm bg-soft-gray" tabindex='9' readonly required><?php echo $r->product_desc;?></textarea>
		</td>
		<td>
		<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
		</td>
		<td>
			<select class="form-select form-control-sm " id="feasibility" name="feasibility[]" required>
				<option value="">Select</option>
				<option selected value="1">Feasible</option>
				<option value="2">Not Feasible</option>
	     		 </select>
	     		 <br>
	     		 <textarea rows='7' cols='10' name="fremark[]" id="fremark<?php echo $i;?>" class="form-control form-control-sm" placeholder="Enter Remark for feasible/Not" ></textarea>
		</td>
	</tr>
<?php  $i++; } ?>
