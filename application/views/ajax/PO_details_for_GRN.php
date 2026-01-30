<?php $this->load->helper('stock_helper.php'); ?>
<?php foreach ($records1 as $row): ?>
	<div class="form-group row">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">GRN Date<span style="color: red;"> *
			</span></label>
		<!-- <div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
			<input type="text" name="date" id="date" class="form-control date_today" value="<?php echo date('d-m-Y'); ?>"
				required>
		</div> -->

		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
			<div class="input-group date datepicker1">
				<input type="text" name="date" id="date" class="form-control form-control-sm datepicker1"
					value="<?php echo date('d-m-Y'); ?>">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			</div>
		</div>

		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">GRN Code<span style="color: red;"> *
			</span></label>
		<div class="col-xs-12 col-sm-2 col-md-32 col-lg-3">
			<input type="text" name="code" id="code" class="form-control" value="<?php echo $Code; ?>"
				onblur="check_duplicate_grncode();">
			<label id="g_code" style="color: red;"></label>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Supplier Name<span style="color: red;"> *
			</span></label>
		<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
			<select name="" id="" class="form-control" disabled required>
				<option value="">Please select name</option>
				<?php foreach ($supplier_records as $g) { ?>
					<option <?php if ($row->supplier_id == $g->supplier_id)
						echo 'selected'; ?>
						value="<?php echo $g->supplier_id; ?>"><?php echo $g->supplier_code . ' ' . $g->supplier_name; ?>
					</option>
				<?php } ?>
			</select>
			<input type="hidden" name="supplier_id" id="supplier_id" class="form-control"
				value="<?php echo $row->supplier_id; ?>" readonly>
		</div>
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Close PO<span style="color: red;"> *
			</span></label>
		<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
			<select name="po_status" id="po_status" class="form-control" required>
				<option value="">Please select </option>
				<option value="1">Yes (Close) </option>
				<option value="0">No (Item remaining)</option>

			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Supplier Invoice No</label>
		<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
			<input type="text" name="invoice_no" id="invoice_no" class="form-control">
		</div>
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Supplier Invoice Date</label>
		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
			<div class="input-group date datepicker1">
				<input type="text" name="inv_date" id="inv_date" class="form-control form-control-sm datepicker1"
					value="<?php echo date('d-m-Y'); ?>">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Deliverd By</label>
			<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
				<textarea name="deliverd_by" id="deliverd_by" class="form-control" rows="3" cols="2"></textarea>
			</div>
			<label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Delivery Comment/Details</label>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<textarea name="remark" id="remark" class="form-control" rows="3" cols="2"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Warehouse<span style="color: red;"> *
				</span></label>
			<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<select name="warehouse_id" id="warehouse_id" class="form-control" required>
					<option value="">Select warehouse</option>
					<?php foreach ($store_records as $g) { ?>
						<option value="<?php echo $g->warehouse_id; ?>"><?php echo $g->warehouse_name . ' ' . $g->city . ' ' . $g->person_incharge; ?> </option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<table class="table table-bordered table-hover" id="tab_logic">
				<thead>
					<tr>
						<th title="Item">Sr </th>
						<th title="Item">Item code</th>
						<th title="Item">Req Quantity</th>
						<th title="Item">Quantity/ Price</th>
						<th title="Item">Remark /Location <br>
							<!--<a id="add_row" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a>-->
						</th>
					</tr>
				</thead>

				<tbody id="mytrbody">
					<?php $i = 5000;
					$j = 1;
					foreach ($records2 as $r) {
						$prev_qty = get_last_grn_quantity($row->po_id, $r->order_code, $r->size);
						if ($prev_qty < $r->quantity) { ?>
							<tr id="addr<?php echo $i; ?>">
								<td>
									<?php echo $j;
									$j++; ?>
								</td>
								<td>
									<select tabindex="11" class="form-select form-control-sm select2 select2Width"
										id="product_id<?php echo $i; ?>" name="product_id[]"
										onchange="get_treding_product_info(<?php echo $i; ?>)" required>
										<option value="">Select Item</option>
										<?php foreach ($products as $s) { ?>
											<option <?php if ($s->item_id == $r->product_id)
												echo 'selected'; ?>
												value="<?php echo $s->item_id; ?>"><?php echo $s->item_code . ' ' . $s->item_name . ' ' . $s->part_code . ' ' . $s->make_model; ?></option>
										<?php } ?>
									</select>
									<br><textarea rows='7' cols='30' name="desc[]" id="desc<?php echo $i; ?>"
										style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"
										required><?php echo $r->item_desc; ?></textarea>
								</td>
								<td>
									Ordered Qty
									<input type="text" readonly class="form-control form-control-sm bg-soft-gray"
										name="ordered_qty[]" value="<?php echo $r->quantity; ?>"><br>
									Prev Rec Qty
									<input type="number" step='0.01' name="pre_qty[]" id="pre_qty<?php echo $i; ?>"
										class="form-control form-control-sm bg-soft-gray" value="<?php echo $prev_qty; ?>" readonly>
								</td>
								<td>
									Received Qty
									<input type="number" step='0.01' name="qty[]" id="qty<?php echo $i; ?>"
										class="form-control form-control-sm" value="<?php echo $r->quantity - $prev_qty; ?>"
										onchange="calculate_total('<?php echo $i; ?>')"><br>
									Price
									<input type="number" step='0.01' name="price[]" id="price<?php echo $i; ?>"
										class="form-control form-control-sm" onchange="calculate_total('<?php echo $i; ?>')"
										value="<?php echo $r->price; ?>" required><br>
									Total
									<input type="number" step='0.01' name="total[]" id="total<?php echo $i; ?>"
										class="form-control bg-soft-gray form-control-sm subItemAmt" readonly required
										value="<?php echo $r->total; ?>"><br>

								</td>
								<td>
									<input type="text" name="item_remark[]" id="item_remark<?php echo $i; ?>"
										class="form-control form-control-sm" placeholder="remark"
										value="<?php echo $r->item_remark; ?>">
									<br>Storage Location
									<textarea rows='5' cols='30' name="storage_location[]" id="valve_serial_no<?php echo $i; ?>"
										style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"
										placeholder="Enter Rack shell bin details"></textarea>

									<input type="hidden" name="trans_id[]" value="<?php echo $r->trans_id; ?>">
									<br>
									<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i; ?>")'
										class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
								</td>

								<input type="hidden" name="rowcount" id="rowcount<?php echo $i; ?>" value="0">
								<input type="hidden" name="append_trans_id[]" value="<?php echo $i; ?>">
							</tr>
							<tr class="bg-soft-primary">
								<td colspan='5'>
									<table class="table table-bordered table-hover" id="tab_logic">
										<thead>
											<tr>
												<td title="Item">Sr </td>
												<td title="Item">Bill of entry</td>
												<td title="Item">Order Ref No</td>
												<td title="Item">Box No</td>
												<td title="Item">Quantity</td>
												<td title="Item">
													<a onclick="add_new_row(<?php echo $i; ?>)" title="Add"
														class="btn btn-sm bg-orange"><span class="fa fa-plus"></span></a>
												</td>
											</tr>
										</thead>
										<tbody id="mytbbody<?php echo $i; ?>">

											<tr id='stock_addr<?php echo $i; ?>0'>

											</tr>
										</tbody>
									</table>
								</td>
							</tr>

							<?php $i++;
						}
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
				<input type="numbre" step='0.01' id='sub_total' name='sub_total' readonly
					class="form-control form-control-sm bg-soft-gray" value="<?php echo $row->sub_total; ?>">
			</div>

			<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 col-form-label">Dis.%:</label>
			<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
				<input type="number" step='0.01' name="discount" id="discount" class="form-control form-control-sm"
					oninput="calculate_grand_total()" value="<?php echo $row->discount_percent; ?>" tabindex=11>
			</div>
			<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
				<input type="number" step='0.01' name="discount_amt" id="discount_amt"
					class="form-control form-control-sm bg-soft-gray"
					oninput="calculate_grand_total();click_amount_reflect_percent();" readonly
					value="<?php echo $row->discount; ?>" tabindex=12>
			</div>
			<label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 col-form-label">Total before VAT</label>
			<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
				<input type="text" id='total_before_vat' name='total_before_vat' readonly
					class="form-control form-control-sm bg-soft-gray"
					value="<?php echo $row->sub_total - $row->discount; ?>">
			</div>
		</div>
		<hr class='bg-primary'>
		</hr>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">VAT (
				<?php echo $row->vat_percent ?>%)
				<input type='checkbox' id='vatbox' value='1' checked onclick='check_vat_option()' />
			</label>
			<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
				<input type="text" id='vat_amt' name='vat_amt' class="form-control form-control-sm bg-soft-gray" readonly
					value="<?php echo $row->vat_amt; ?>" readonly>
				<input type="hidden" id='vat_percent' name='vat_percent' value="<?php echo $row->vat_percent; ?>">
				<input type="hidden" id='vat_percent1' name='vat_percent1' value="<?php echo $row->vat_percent; ?>">
			</div>
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Currency Rate <span style="color: red;"> *
				</span></label>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				<select tabindex="13" class="form-select form-control-sm" id="currency_id" name="currency_id"
					onchange="get_currency_conversion()" style='width:175px'>
					<option value="">Select</option>
					<?php foreach ($currency_list as $s) { ?>
						<option value="<?php echo $s->id . '@' . $s->rate . '@' . $s->currabrev; ?>"><?php echo $s->country . ' ' . $s->currabrev; ?></option>
					<?php } ?>
				</select>
				<input type="hidden" id='cid' name='cid' value="<?php echo $row->currency_id; ?>">
				<input type="hidden" id='crate' name='crate' class="form-control form-control-sm bg-soft-gray" readonly
					value="<?php echo $row->currency_rate; ?>">
			</div>
			<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Grand Total <span id='currabrev'>
					<?php echo $row->currabrev; ?>
				</span><span style="color: red;"> * </span></label>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				<input type="text" id='grand_total' name='grand_total' readonly
					class="form-control form-control-sm bg-soft-gray" value="<?php echo $row->grand_total; ?>" required>
			</div>
		</div>
		<hr>

	<?php endforeach; ?>