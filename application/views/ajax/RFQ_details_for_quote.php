<?php $this->load->helper('sales_helper.php'); ?>
<?php foreach ($records1 as $row) { ?>

	<div class="form-group row">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Supplier<span style="color: red;"> *
			</span></label>
		<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4" role='group'>
			<select name="supplier_id" id="supplier_id" class="form-control select2" required tabindex='2'>
				<option value="">Please select name</option>
				<?php foreach ($supplier_records as $g) { ?>
					<option <?php if ($g->supplier_id == $row->supplier_id)
						echo 'selected' ?>
							value="<?php echo $g->supplier_id; ?>"><?php echo $g->supplier_code . ' ' . $g->supplier_name; ?>
					</option>
				<?php } ?>
			</select>
		</div>
		<label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Supplier Quotation Code <span
				style="color: red;"> * </span></label>
		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
			<input type="text" name="po_code" id="po_code" class="form-control form-control-sm" tabindex='4' required
				value="<?php echo $Code; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Supplier Ref No</label>
		<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4">
			<input type="text" name="ref_no" id="ref_no" class="form-control form-control-sm" tabindex='4'>
		</div>
	</div>
	<div class="form-group row">
		<table class="table table-bordered table-hover" id="tab_logic">
			<thead>
				<tr>
					<th title="Item">Sr </th>
					<th title="Item">Item Details</th>
					<th title="Item">Quantity</th>
					<th title="Item">Price</th>
					<th title="Item">Remark <br>
						<!--<a id="add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a>-->
					</th>
				</tr>
			</thead>

			<tbody id="mytrbody">
				<?php $i = 5000;
				foreach ($records2 as $r) { ?>
					<tr id="addr<?php echo $i; ?>">
						<td>
							<?php echo $i; ?>
						</td>
						<td>
							<select tabindex="11" class="form-select form-control-sm select2 select2Width"
								id="product_id<?php echo $i; ?>" name="product_id[]"
								onchange="get_product_info_old(<?php echo $i; ?>)">
								<option value="">Select Item</option>
								<?php foreach ($products as $s) { ?>
									<option <?php if ($s->item_id == $r->product_id)
										echo 'selected'; ?>
										value="<?php echo $s->item_id; ?>"><?php echo $s->item_code . ' ' . $s->item_name . ' ' . $s->part_code . ' ' . $s->make_model; ?></option>
								<?php } ?>
							</select>
							<textarea rows='2' cols='20' name="desc[]" id="desc<?php echo $i; ?>"
								style="font-size:11px; font-weight:bold;" class="form-control form-control-sm" tabindex='9'
								required><?php echo $r->item_desc; ?></textarea>
						</td>
						<td>
							<input type="number" name="trading_qty[]" id="trading_qty<?php echo $i; ?>" tabindex='10'
								class="form-control form-control-sm" value="<?php echo $r->quantity; ?>"
								onchange="calculate_total('<?php echo $i; ?>')" required>
						</td>
						<td>
							<input type="number" step='0.01' name="price[]" id="price<?php echo $i; ?>"
								class="form-control form-control-sm" onchange="calculate_total('<?php echo $i; ?>')" value=""
								required>
							<br>
							Total
							<input type="number" name="total[]" id="total<?php echo $i; ?>" value="0.00"
								class="form-control bg-soft-gray form-control-sm subItemAmt" readonly required><br>

						</td>
						<td>
							<input type="text" name="item_remark[]" id="item_remark<?php echo $i; ?>"
								class="form-control form-control-sm" placeholder="remark" value="<?php echo $r->comment; ?>">


							<input type="hidden" name="trans_id[]" value="<?php echo $r->rfq_trans_id; ?>">
							<br>
							<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i; ?>")'
								class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
						</td>
					</tr>
					<?php $i++;
				} ?>

			</tbody>
			<tbody id="mytbbody">
				<tr id='addr1'></tr>
			</tbody>
		</table>
	</div>

	<div class="form-group row">
		<label class="col-xs-12 col-sm-3 col-md-1 col-lg-1 col-form-label">SubTot</label>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="text" id='sub_total' name='sub_total' readonly class="form-control form-control-sm bg-soft-gray"
				value="0.00">
		</div>

		<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 col-form-label">Dis.%:</label>
		<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			<input type="number" name="discount" id="discount" class="form-control form-control-sm"
				onkeyup="calculate_grand_total()" value="0.00">
		</div>
		<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			<input step='0.01' type="number" name="discount_amt" id="discount_amt" class="form-control form-control-sm"
				onkeyup="calculate_grand_total()" value="0.00">
		</div>
		<label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 col-form-label">Total before VAT</label>
		<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			<input type="text" id='total_before_vat' name='total_before_vat' readonly
				class="form-control form-control-sm bg-soft-gray" value="0.00">
		</div>
	</div>
	<hr class='bg-primary'>
	</hr>
	<div class="form-group row">
		<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">VAT (
			<?php echo $vat_percent; ?>%)
			<input type='checkbox' id='vatbox' value='1' checked onclick='check_vat_option()' />
		</label>
		<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
			<input type="text" id='vat_amt' name='vat_amt' class="form-control form-control-sm bg-soft-gray" readonly
				value="0.00">
			<input type="hidden" id='vat_percent' name='vat_percent' value="">
			<input type="hidden" id='vat_percent1' name='vat_percent1' value="">
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="text" id='miscellaneous1' name='miscellaneous1' class="form-control form-control-sm"
				value="miscellaneous1">
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="number" step='0.01' id='miscellaneous_amt1' name='miscellaneous_amt1'
				class="form-control form-control-sm" value="0.00" onkeyup="calculate_grand_total()">
		</div>

		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="text" id='miscellaneous2' name='miscellaneous2' class="form-control form-control-sm"
				value="<?php echo 'miscellaneous2'; ?>">
		</div>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="number" step='0.01' id='miscellaneous_amt2' name='miscellaneous_amt2'
				class="form-control form-control-sm" value="0.00" onkeyup="calculate_grand_total()">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Currency Rate <span style="color: red;"> *
			</span></label>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<select tabindex="13" class="form-select form-control-sm select2" id="currency_id" name="currency_id"
				onchange="get_currency_conversion()" style='width:175px'>
				<option value="">Select</option>
				<?php foreach ($currency_list as $s) { ?>
					<option value="<?php echo $s->id . '@' . $s->rate . '@' . $s->currabrev; ?>"><?php echo $s->country . ' ' . $s->currabrev; ?></option>
				<?php } ?>
			</select>
			<input type="hidden" id='cid' name='cid' value="">
			<input type="hidden" id='crate' name='crate' class="form-control form-control-sm bg-soft-gray" readonly
				value="0">
		</div>
		<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Grand Total <span id='currabrev'></span><span
				style="color: red;"> * </span></label>
		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="text" id='grand_total' name='grand_total' class="form-control form-control-sm" value="0.00"
				required>
		</div>
	</div>
	<hr>




<?php } ?>