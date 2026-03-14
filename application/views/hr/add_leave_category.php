<div class="card-body">
	<form id="main" method="post" action="<?php echo base_url(); ?>index.php/Hr/add_category_records" autocomplete="off">
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Category Name <span style="color: red;">*</span></label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" required>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Leave Days <span style="color: red;">*</span></label>
			<div class="col-sm-4">
				<input type="number" class="form-control" id="leave_days" name="leave_days" placeholder="Enter Leave Days" required>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Remark</label>
			<div class="col-sm-4">
				<textarea class="form-control" id="remark" name="remark" placeholder="" rows="2"></textarea>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-sm-2"></label>
			<div class="col-sm-4">
				<button type="submit" id="add" class="btn btn-primary m-b-0">Submit</button>
			</div>
		</div>
	</form>
</div>
</div>
</div>