<div class="card-body">
	<div class="form-group row">
		<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Select: <span
				style="color: red;">*</span></label>

		<?php foreach ($records as $r): ?>
			<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
				<select class="form-select form-control-sm select2 " id="requestType" name="requestType" tabindex="10" disabled
					onchange="showForm();">
					<option value="">Select</option>
					<option value="compensatory_leave" <?php if ($r->emp_reqtype == 'compensatory_leave')
						echo 'selected'; ?>>
						Compensatory Leave</option>
					<option value="advance_salary" <?php if ($r->emp_reqtype == 'advance_salary')
						echo 'selected'; ?>>Advance
						Salary</option>
					<option value="allowance" <?php if ($r->emp_reqtype == 'allowance')
						echo 'selected'; ?>>Allowance</option>
					<option value="loan" <?php if ($r->emp_reqtype == 'loan')
						echo 'selected'; ?>>Loan</option>
					<option value="ticket_allowance" <?php if ($r->emp_reqtype == 'ticket_allowance')
					    echo 'selected'; ?>>Annual Ticket Allowance</option>
                     <option value="service_request" <?php if ($r->emp_reqtype == 'service_request')
					    echo 'selected'; ?>>Service Request</option>
				</select>
			</div>
		<?php endforeach; ?>
		<!-- <span id="tooltipMessage" style="color: black;"
			title="If you select any option, the corresponding form will show">
			If you select any option, the corresponding form will show..............
		</span> -->
	</div>


	<!-- Compensatory Leave Form -->
	<form id="compensatory_leave_form" class="request-form" method="post"
		action="<?php echo base_url() . 'index.php/Hr/update_comp_off_data'; ?>" style="display:none;"
		autocomplete="off" enctype="multipart/form-data">
		<?php foreach ($records1 as $c): ?>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
				<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
					<?php foreach ($user_records as $s) {
						if ($c->user_id == $s->user_id) { ?>
							<input type='text' class="form-control form-control-sm  bg-soft-gray" id="employee_id"
								name="employee_id" value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
							<input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
							<?php

						}
					} ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
						style="color: red;">*</span></label>
				<div class="col-sm-5">
					<div class="input-group date ">
						<input type="text" class="form-control form-control-sm bg-soft-gray" id="app_date" name="app_date" readonly
							value="<?php echo date('d-m-Y', strtotime($c->app_date) ?? '') ?>" tabindex=2 required>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Working:<span
						style="color: red;">*</span></label>
				<div class="col-sm-5">
					<div class="input-group date datepicker1">
						<input type="text" class="form-control form-control-sm datepicker1" id="work_date" name="work_date"
							value="<?php echo date('d-m-Y', strtotime($c->form_date) ?? '') ?>" tabindex=2 required>
						<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Date For Comp Off:<span
						style="color: red;">*</span></label>
				<div class="col-sm-5">
					<div class="input-group date datepicker1">
						<input type="text" class="form-control form-control-sm datepicker1" id="comp_date" name="comp_date"
							value="<?php echo date('d-m-Y', strtotime($c->to_date) ?? '') ?>" tabindex=2 required>
						<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					</div>
				</div>
			</div>


			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
				<div class="col-sm-5">
					<textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
						tabindex=8><?php echo $c->remark; ?></textarea>
				</div>
			</div>

			<!-- /////////////////////////////////comp approval details -->
			<?php if ($c->approved_flag == 1 || $c->approved_flag == 2): ?>
				<h6>Details of Comp Off Approval</h6>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<div class="input-group date ">
							<input type="text" class="form-control form-control-sm bg-soft-gray" id="approve_date"
								name="approve_date" value="<?php echo date('d-m-Y', strtotime($c->approved_date) ?? '') ?>"
								required tabindex="1">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Comp Off Date:<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<div class="input-group date">
							<input type="text" class="form-control form-control-sm bg-soft-gray" id="a_comp_date"
								name="a_comp_date" value="<?php echo date('d-m-Y', strtotime($c->approved_form_date)); ?>"
								required tabindex="1">
						</div>
					</div>
				</div>


				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Comp Off Status :<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<select class="form-select form-control-sm" name="comp_status" id="comp_status" required tabindex="4"
							disabled>
							<option value="" disabled <?php echo !isset($c->approved_flag) || $c->approved_flag == 0 ? 'selected' : ''; ?>>
								Please select Comp Off Status
							</option>
							<option value="1" <?php echo isset($c->approved_flag) && $c->approved_flag == 1 ? 'selected' : ''; ?>>
								Approved
							</option>
							<option value="2" <?php echo isset($c->approved_flag) && $c->approved_flag == 2 ? 'selected' : ''; ?>>
								Rejection
							</option>
						</select>


					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
					<div class="col-sm-5">
						<textarea id="approve_remark" name="approve_remark" class="bg-soft-gray" rows="2" placeholder="remark"
							style="width: 100%;" tabindex="5"><?php echo $c->approve_remark; ?> </textarea>
					</div>
				</div>


				<!-- end comp approval detailsss/////////////////////////////////////// -->
			<?php elseif ($c->approved_flag == 0): ?>
				<div class="form-group row">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<input type="hidden" name="id" value="<?php echo $c->emp_req_id; ?>">

						<button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply for Comp Off</button>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</form>

	<!-- Advance Salary Form -->
	<form id="advance_salary_form" class="request-form" method="post"
		action="<?php echo base_url() . 'index.php/Hr/update_advance_salary_data'; ?>" style="display:none;"
		autocomplete="off" enctype="multipart/form-data">
		<?php foreach ($records2 as $a): ?>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
				<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
					<?php foreach ($user_records as $s) {
						if ($a->user_id == $s->user_id) { ?>
							<input type='text' class="form-control form-control-sm  bg-soft-gray" id="employee_id"
								name="employee_id" value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
							<input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
							<?php

						}
					} ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
						style="color: red;">*</span></label>
				<div class="col-sm-5">
					<div class="input-group date ">
						<input type="text" class="form-control form-control-sm bg-soft-gray" id="app_date" name="app_date" readonly
							value="<?php echo date('d-m-Y', strtotime($a->app_date) ?? '') ?>" tabindex=2 required>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
					Select Month:<span style="color: red;">*</span>
				</label>
				<div class="col-sm-5">
					<input type="month" class="form-control form-control-sm" id="a_month" name="a_month"
						value="<?php echo date('Y-m', strtotime($a->form_date ?? '')) ?>" required>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Salary Amount:</label>
				<div class="col-sm-5">
					<input type="number" class="form-control form-control-sm" id="advance_salary" name="advance_salary"
						value="<?php echo $a->amount; ?>" readonly>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
				<div class="col-sm-5">
					<textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
						tabindex=8><?php echo $a->remark; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label
					class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg",<br>"png","doc","pdf"):</label>
				<div class="col-sm-8">
					<table class="table table-bordered table-hover" id="tab_logic_salary">
						<tbody>
							<?php if ($file_records1) {
								$x = 1;
								$i = 1;
								foreach ($file_records1 as $k) { ?>
									<tr>
										<td>
											<?php echo $i;
											$i++; ?>
										</td>
										<td><a href="<?php echo base_url() . 'public/uploded_documents/' . $k->document_path; ?>"
												download>File <?php echo $x;
												$x++; ?></a></td>
										<td>
											<?php echo $k->document_name; ?>
										</td>
									</tr>
								<?php }
							} ?>
							<tr id='addr_salary0'>
								<td>1</td>

								<td>

									<input class="form-control form-control-sm" id="documents_salary"
										name="documents_salary[]" tabindex="6" type="file">

								</td>
								<td>
									<input type='text' class="form-control form-control-sm" name="document_types_salary[]"
										id="document_types_salary" placeholder="enter doc name">
								</td>

								<td>
									<a id="add_row_salary" title="Add" class="btn btn-sm bg-blue"><span
											class="fa fa-plus"></span></a>
									<a id='delete_row_salary' title="Delete" class="btn btn-sm bg-blue"><span
											class="fa fa-trash"></span></a>
								</td>
							</tr>
							<tr id='addr_salary1'></tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- //////////////////////////approval detailssssssss -->
			<?php if ($a->approved_flag == 1 || $a->approved_flag == 2): ?>

				<h6>Details of Advance Salary Approval</h6>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<div class="input-group date ">
							<input type="text" class="form-control form-control-sm bg-soft-gray" id="approve_date"
								name="approve_date" value="<?php echo date('d-m-Y', strtotime($a->approved_date) ?? '') ?>"
								required tabindex="1">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">
						Approve Advance Salary Month:<span style="color: red;">*</span>
					</label>
					<div class="col-sm-5">
						<input type="month" class="form-control form-control-sm bg-soft-gray" id="ad_month" name="ad_month"
							required value="<?php echo date('Y-m', strtotime($a->approved_form_date)); ?>" />
					</div>
				</div>


				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Salary Status :<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<select class="form-select form-control-sm" name="advance_status" id="advance_status" required
							tabindex="4" disabled>
							<option value="" disabled <?php echo !isset($a->approved_flag) || $a->approved_flag == 0 ? 'selected' : ''; ?>>
								Please select Salary Status
							</option>
							<option value="1" <?php echo isset($a->approved_flag) && $a->approved_flag == 1 ? 'selected' : ''; ?>>
								Approved
							</option>
							<option value="2" <?php echo isset($a->approved_flag) && $a->approved_flag == 2 ? 'selected' : ''; ?>>
								Rejection
							</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
					<div class="col-sm-5">
						<textarea id="approve_remark" name="approve_remark" class="bg-soft-gray" rows="2" placeholder="remark"
							style="width: 100%;" tabindex="5"> <?php echo $a->approve_remark; ?> </textarea>
					</div>
				</div>


				<!-- //////////////////////////end approval details////////// -->
			<?php elseif ($a->approved_flag == 0): ?>
				<div class="form-group row">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<input type="hidden" name="id" value="<?php echo $a->emp_req_id; ?>">

						<button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply For Advance
							Salary</button>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</form>

	<!-- Allowance Form -->
	<form id="allowance_form" class="request-form" method="post"
		action="<?php echo base_url() . 'index.php/Hr/update_allowance_data'; ?>" style="display:none;"
		autocomplete="off" enctype="multipart/form-data">
		<?php foreach ($records3 as $al): ?>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
				<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
					<?php foreach ($user_records as $s) {
						if ($al->user_id == $s->user_id) { ?>
							<input type='text' class="form-control form-control-sm  bg-soft-gray" id="employee_id"
								name="employee_id" value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
							<input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
							<?php

						}
					} ?>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Select Allowance:<span
						style="color: red;">*</span></label>
				<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
					<select tabindex="1" class="form-control-sm select2" id="allowance_id" name="allowance_id" disabled
						style="width: 400px;" required>
						<option value="">Select</option>
						<?php foreach ($allowance as $s) { ?>
							<?php if ($s->allowance_type == 'A'): ?>
								<option <?php if ($al->allowance_type == $s->sno)
									echo 'selected'; ?> value="<?php echo $s->sno; ?>">
									<?php echo $s->allowance_name; ?>
								</option>
							<?php endif; ?>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
						style="color: red;">*</span></label>
				<div class="col-sm-5">
					<div class="input-group date ">
						<input type="text" class="form-control form-control-sm bg-soft-gray" id="app_date" name="app_date"  readonly
							value="<?php echo date('d-m-Y', strtotime($al->app_date) ?? '') ?>" tabindex=2 required>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">From Month:<span
						style="color: red;">*</span></label>
				<div class="col-sm-2">
					<div class="input-group date date">
						<input type="month" class="form-control form-control-sm " id="from_date" name="from_date"
							value="<?php echo date('Y-m', strtotime($al->form_date) ?? '') ?>" tabindex="3" required>
						<!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
					</div>
				</div>
				<label class="col-xs-8 col-sm-2 col-md-2 col-lg-1 col-form-label">To Month:<span
						style="color: red;">*</span></label>
				<div class="col-sm-2">
					<div class="input-group date date">
						<input type="month" class="form-control form-control-sm " id="to_date" name="to_date"
							value="<?php echo date('Y-m', strtotime($al->to_date) ?? '') ?>" tabindex="4" required>
						<!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Amount<span
						style="color: red;">*</span>:</label>
				<div class="col-sm-5">
					<input type="number" step="0.01" id="a_amount" name="a_amount" required
						placeholder="Enter Allowance Amount" style="width: 100%;" tabindex="8"
						value="<?php echo $al->amount; ?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
				<div class="col-sm-5">
					<textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
						tabindex=8><?php echo $al->remark; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label
					class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg",<br>"png","doc","pdf"):</label>
				<div class="col-sm-8">
					<table class="table table-bordered table-hover" id="tab_logic_allowance">
						<tbody>
							<?php if ($file_records2) {
								$x = 1;
								$i = 1;
								foreach ($file_records2 as $k) { ?>
									<tr>
										<td>
											<?php echo $i;
											$i++; ?>
										</td>
										<td><a href="<?php echo base_url() . 'public/uploded_documents/' . $k->document_path; ?>"
												download>File <?php echo $x;
												$x++; ?></a></td>
										<td>
											<?php echo $k->document_name; ?>
										</td>
									</tr>
								<?php }
							} ?>
							<tr id='addr_allowance0'>
								<td>1</td>

								<td>

									<input class="form-control form-control-sm" id="documents_allowance"
										name="documents_allowance[]" tabindex="6" type="file">

								</td>
								<td>
									<input type='text' class="form-control form-control-sm"
										name="document_types_allowance[]" id="document_types_allowance"
										placeholder="enter doc name">
								</td>

								<td>
									<a id="add_row_allowance" title="Add" class="btn btn-sm bg-blue"><span
											class="fa fa-plus"></span></a>
									<a id='delete_row_allowance' title="Delete" class="btn btn-sm bg-blue"><span
											class="fa fa-trash"></span></a>
								</td>
							</tr>
							<tr id='addr_allowance1'></tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- ///////////////////////////////////start allowance approve details details -->
			<?php if ($al->approved_flag == 1 || $al->approved_flag == 2): ?>

				<h6>Details of Allowance Approval</h6>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<div class="input-group date ">
							<input type="text" class="form-control form-control-sm bg-soft-gray" id="approve_date"
								name="approve_date" value="<?php echo date('d-m-Y', strtotime($al->approved_date) ?? '') ?>"
								required tabindex="1">
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">From Month:<span
							style="color: red;">*</span></label>
					<div class="col-sm-2">
						<div class="input-group date ">
							<input type="month" class="form-control form-control-sm bg-soft-gray" id="a_start_month"
								name="a_start_month" value="<?php echo date('Y-m', strtotime($lo->approved_form_date)); ?>"
								tabindex="3" required>
						</div>
					</div>
					<label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">To Month:<span
							style="color: red;">*</span></label>
					<div class="col-sm-2">
						<div class="input-group date ">
							<input type="month" class="form-control form-control-sm bg-soft-gray" id="a_end_month"
								name="a_end_month" value="<?php echo date('Y-m', strtotime($lo->approved_to_date)); ?>"
								tabindex="4" required>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="approve_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Allowance
						Amount<span style="color: red;">*</span>:</label>
					<div class="col-sm-5">
						<input type="number" step="0.01" id="approve_amount" name="approve_amount" required class="bg-soft-gray"
							placeholder="Enter Approve Amount" style="width: 100%;" tabindex="8"
							value="<?php echo $al->approved_amount; ?>">
					</div>
				</div>

				<!-- Allowance Status -->
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Advance Allowance Status:<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<select class="form-select form-control-sm" name="allowance_status" id="allowance_status" required
							disabled tabindex="4">
							<option value="" disabled <?php echo !isset($al->approved_flag) || $al->approved_flag == 0 ? 'selected' : ''; ?>> Please select Allowance Status
							</option>
							<option value="1" <?php echo isset($al->approved_flag) && $al->approved_flag == 1 ? 'selected' : ''; ?>>
								Approved
							</option>
							<option value="2" <?php echo isset($al->approved_flag) && $al->approved_flag == 2 ? 'selected' : ''; ?>>
								Rejection
							</option>
						</select>
					</div>
				</div>

				<!-- Approval Remark -->
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark:</label>
					<div class="col-sm-5">
						<textarea id="approve_remark" class="bg-soft-gray" name="approve_remark" rows="2" placeholder="remark"
							style="width: 100%;" tabindex="5"><?php echo $al->approve_remark; ?> </textarea>
					</div>
				</div>



				<!-- ///////////////////////////////////////end allowance details;/////////// -->
			<?php elseif ($al->approved_flag == 0): ?>
				<div class="form-group row">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<input type="hidden" name="id" value="<?php echo $al->emp_req_id; ?>">

						<button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply For Allowance</button>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</form>
	<!-- loan Form //////////////////////////////////////////////////////////////////////-->
	<form id="loan_form" class="request-form" method="post"
		action="<?php echo base_url() . 'index.php/Hr/update_loan_data'; ?>" style="display:none;" autocomplete="off"
		enctype="multipart/form-data">
		<?php foreach ($records as $lo): ?>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Employee Name:</label>
				<div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
					<?php foreach ($user_records as $s) {
						if ($lo->user_id == $s->user_id) { ?>
							<input type='text' class="form-control form-control-sm  bg-soft-gray" id="employee_id"
								name="employee_id" value="<?php echo $s->user_name; ?>" tabindex=1 readonly />
							<input type='hidden' name="employee_id_hidden" value="<?php echo $s->user_id; ?>" />
							<?php

						}
					} ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Application Date:<span
						style="color: red;">*</span></label>
				<div class="col-sm-5">
					<div class="input-group date ">
						<input type="text" class="form-control form-control-sm bg-soft-gray" id="app_date" name="app_date" readonly
							value="<?php echo date('d-m-Y', strtotime($lo->app_date) ?? '') ?>" tabindex=2 required>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Requested Amount<span
						style="color: red;">*</span>:</label>
				<div class="col-sm-5">
					<input type="number" step="0.01" id="r_amount" name="r_amount" required
						placeholder="Enter requested Amount" style="width: 100%;" tabindex="8" oninput="calculateEMI()"
						value="<?php echo $lo->amount ?>">
				</div>
				
			</div>
			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Start Month:<span
						style="color: red;">*</span></label>
				<div class="col-sm-2">
					<div class="input-group date ">
						<input type="month" class="form-control form-control-sm " id="start_month"
							onchange="calculateTotalMonths()" name="start_date"
							value="<?php echo date('Y-m', strtotime($lo->form_date ?? '')) ?>" tabindex="3" required>
					</div>
				</div>
				<label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">End Month:<span
						style="color: red;">*</span></label>
				<div class="col-sm-2">
					<div class="input-group date ">
						<input type="month" class="form-control form-control-sm " id="end_month" name="end_date"
							value="<?php echo date('Y-m', strtotime($lo->to_date ?? '')) ?>" tabindex="4" required
							onchange="calculateTotalMonths()">
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Month<span
						style="color: red;">*</span>:</label>
				<div class="col-sm-2">
					<input type="number" step="0.01" id="total_month" name="total_month" required placeholder="Total Month"
						style="width: 100%;" tabindex="8" oninput="calculateEMI()" value="<?php echo $lo->total_month ?>"
						readonly>
				</div>
				<label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-form-label">EMI Amount Per/Month<span
						style="color: red;">*</span>:</label>
				<div class="col-sm-2">
					<input type="number" step="0.01" id="emi_amount" name="emi_amount" required placeholder="EMI Amount"
						style="width: 100%;" tabindex="8" readonly value="<?php echo $lo->emi_amount ?>">
				</div>
			</div>
		

			<div class="form-group row">
				<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
				<div class="col-sm-5">
					<textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;"
						tabindex=8><?php echo $lo->remark; ?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label
					class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg",<br>"png","doc","pdf"):</label>
				<div class="col-sm-8">
					<table class="table table-bordered table-hover" id="tab_logic_loan">
						<tbody>
							<?php if ($file_records3) {
								$x = 1;
								$i = 1;
								foreach ($file_records3 as $k) { ?>
									<tr>
										<td>
											<?php echo $i;
											$i++; ?>
										</td>
										<td><a href="<?php echo base_url() . 'public/uploded_documents/' . $k->document_path; ?>"
												download>File <?php echo $x;
												$x++; ?></a></td>
										<td>
											<?php echo $k->document_name; ?>
										</td>
									</tr>
								<?php }
							} ?>
							<tr id='addr_loan0'>
								<td>1</td>

								<td>

									<input class="form-control form-control-sm" id="documents_loan" name="documents_loan[]"
										tabindex="6" type="file">

								</td>
								<td>
									<input type='text' class="form-control form-control-sm" name="document_types_loan[]"
										id="document_types_loan">
								</td>

								<td>
									<a id="add_row_loan" title="Add" class="btn btn-sm bg-blue"><span
											class="fa fa-plus"></span></a>
									<a id='delete_row_loan' title="Delete" class="btn btn-sm bg-blue"><span
											class="fa fa-trash"></span></a>
								</td>
							</tr>
							<tr id='addr_loan1'></tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- /////////////////////////////////////////////start loan approval details//////// -->
			<?php if ($lo->approved_flag == 1 || $lo->approved_flag == 2): ?>

				<h6>Details of Loan Approval</h6>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<div class="input-group date ">
							<input type="text" class="form-control form-control-sm bg-soft-gray" id="approve_date"
								name="approve_date" value="<?php echo date('d-m-Y', strtotime($lo->approved_date) ?? '') ?>"
								required tabindex="1">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Requested
						Amount<span style="color: red;">*</span>:</label>
					<div class="col-sm-5">
						<input type="number" step="0.01" id="ar_amount" name="ar_amount" required
							placeholder="Enter requested Amount" style="width: 100%;" tabindex="8" class="bg-soft-gray"
							value="<?php echo $lo->approved_amount; ?>">
					</div>

				</div>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve Start Month:<span
							style="color: red;">*</span></label>
					<div class="col-sm-2">
						<div class="input-group date ">
							<input type="month" class="form-control form-control-sm bg-soft-gray" id="a_start_month"
								name="a_start_month" value="<?php echo date('Y-m', strtotime($lo->approved_form_date)); ?>"
								tabindex="3" required>
						</div>
					</div>
					<label class="col-xs-8 col-sm-2 col-md-2 col-lg-2 col-form-label">Approve End Month:<span
							style="color: red;">*</span></label>
					<div class="col-sm-2">
						<div class="input-group date ">
							<input type="month" class="form-control form-control-sm bg-soft-gray" id="a_end_month"
								name="a_end_month" value="<?php echo date('Y-m', strtotime($lo->approved_to_date)); ?>"
								tabindex="4" required>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Month<span
							style="color: red;">*</span>:</label>
					<div class="col-sm-2">
						<input type="number" step="0.01" id="a_total_month" name="a_total_month" required
							placeholder="Total Month" style="width: 100%;" tabindex="8" readonly class="bg-soft-gray"
							value="<?php echo $lo->approve_total_month; ?>">
					</div>
					<label for="a_amount" class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-form-label">EMI Amount Per/Month<span
							style="color: red;">*</span>:</label>
					<div class="col-sm-2">
						<input type="number" step="0.01" id="a_emi_amount" name="a_emi_amount" required placeholder="EMI Amount"
							class="bg-soft-gray" style="width: 100%;" tabindex="8" readonly
							value="<?php echo $lo->approve_emi; ?>">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Loan Status :<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<select class="form-select form-control-sm" name="loan_status" id="loan_status" required tabindex="4"
							disabled>
							<option value="" disabled <?php echo !isset($lo->approved_flag) || $lo->approved_flag == 0 ? 'selected' : ''; ?>> Please select Loan Stat </option>
							<option value="1" <?php echo isset($lo->approved_flag) && $lo->approved_flag == 1 ? 'selected' : ''; ?>>
								Approved
							</option>
							<option value="2" <?php echo isset($lo->approved_flag) && $lo->approved_flag == 2 ? 'selected' : ''; ?>>
								Rejection
							</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
					<div class="col-sm-5">
						<textarea id="approve_remark" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
							class="bg-soft-gray" tabindex="5"><?php echo $lo->approve_remark; ?> </textarea>
					</div>
				</div>
				<!-- ////////////////////////////////end approval details///////////// -->
			<?php elseif ($lo->approved_flag == 0): ?>

				<div class="form-group row">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<input type="hidden" name="id" value="<?php echo $lo->emp_req_id; ?>">

						<button type="submit" tabindex="11" id="add" class="btn btn-primary m-b-0">Apply For Loan</button>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</form>

	<!-- Annual Air ticket //////////////////////////////////////////////////////////////////////-->

<form id="ticket_form" class="request-form" method="post"
      action="<?php echo base_url('index.php/Hr/update_ticket_allowance_data'); ?>"
      autocomplete="off" enctype="multipart/form-data">

    <?php foreach ($records as $row): ?>
        <!-- Employee Info -->
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Employee Name:</label>
            <div class="col-sm-3">
                <?php
                $user = null;
                foreach ($user_records as $u) {
                    if ($row->user_id == $u->user_id) {
                        $user = $u; break;
                    }
                }
                ?>
                <input type="text" class="form-control form-control-sm bg-soft-gray"
                       value="<?= $user->user_name ?? '' ?>" readonly>
                <input type="hidden" name="employee_id" value="<?= $user->user_id ?? '' ?>">
            </div>
			</div>
			<div class="form-group row">
            <label class="col-sm-3 col-form-label">Employee ID:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm bg-soft-gray"
                       value="<?= $user->user_code ?? '' ?>" readonly>
            </div>

       
            <label class="col-sm-3 col-form-label">Department:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm bg-soft-gray"
                       value="<?= $user->dept_name ?? '' ?>" readonly>
           
        </div>
 </div>
 <div class="form-group row">
        <!-- Designation & Joining Date -->
            <label class="col-sm-3 col-form-label">Designation:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" name="designation"
                       value="<?= $user->designation_name ?? '' ?>">
            </div>
			
            <label class="col-sm-3 col-form-label">Joining Date:</label>
            <div class="col-sm-3">
                <input type="date" class="form-control form-control-sm" name="joining_date"
                       value="<?= $user->joining_date ?? '' ?>">
            </div>
        </div>

        <!-- Ticket-specific Fields -->
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Visa Expiry Date:</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="visa_expiry_date"
                       value="<?= $row->visa_expiry_date ?? '' ?>">
            </div>

            <label class="col-sm-3 col-form-label">Last Ticket Issued Date:</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="last_ticket_date"
                       value="<?= $row->form_date ?? '' ?>" onchange="setEligibilityRange()">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Rejoin Date:</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="rejoin_date"
                       value="<?= $row->rejoin_date ?? '' ?>">
            </div>

            <label class="col-sm-3 col-form-label">Leave Request From:</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="leave_from"
                       value="<?= $row->form_date ?? '' ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Leave Request To:</label>
            <div class="col-sm-3">
                <input type="date" class="form-control" name="leave_to"
                       value="<?= $row->to_date ?? '' ?>">
            </div>

            <label class="col-sm-3 col-form-label">Remarks:</label>
            <div class="col-sm-3">
                <textarea class="form-control" name="remarks"><?= $row->remark ?? '' ?></textarea>
            </div>
        </div>

        <!-- Net Amount Table -->
        <div class="form-group row">
            <div class="col-sm-12">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Net Amount (AED)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Eligible for — (Last Ticket Issued Date + 1 year)</td>
                            <td>
                                <input type="number" class="form-control form-control-sm" name="net_amount[]"
                                       value="<?= $row->amount ?? '' ?>">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <input type="hidden" name="id" value="<?= $row->emp_req_id ?>">
		 

        <!-- Submit -->
        <div class="form-group row">
            <div class="col-sm-12 text-right">
                <button type="submit" class="btn btn-primary">Update Ticket Allowance</button>
            </div>
        </div>
    <?php endforeach; ?>
</form>

<!-- Service Request Form -->
<form id="service_request" class="request-form" method="post"
      action="<?= base_url('index.php/Hr/update_service_request_data'); ?>" 
      autocomplete="off" enctype="multipart/form-data">

    <input type="hidden" name="req_id" value="<?= $request->req_id ?? '' ?>">

    <!-- EMPLOYEE NAME -->
    <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Employee Name:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                   value="<?= $user->user_name ?? '' ?>" readonly>
            <input type="hidden" name="employee_id" value="<?= $request->user_id ?? '' ?>">
        </div>
    </div> -->

    <!-- DEPARTMENT -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Department:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm bg-soft-gray"
                   value="<?= $user->dept_name ?? '' ?>" readonly>
        </div>
    </div>

    <!-- DATE -->
    <!-- <div class="form-group row">
        <label class="col-sm-3 col-form-label">Date:</label>
        <div class="col-sm-5">
            <input type="date" class="form-control form-control-sm"
                   name="request_date" 
                   value="<?= $request->app_date ?? date('Y-m-d') ?>" required>
        </div>
    </div> -->

    <!-- PROJECT -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Project:</label>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-sm"
                   name="project_name" value="<?= $request->project_name ?? '' ?>">
        </div>
    </div>

    <!-- URGENCY -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Urgency:</label>
        <div class="col-sm-5">
            <select class="form-control form-control-sm" name="urgency">
                <?php 
                $urgency = $request->urgency ?? '';
                ?>
                <option value="">Select</option>
                <option <?= ($urgency=='Low')?'selected':'' ?>>Low</option>
                <option <?= ($urgency=='Medium')?'selected':'' ?>>Medium</option>
                <option <?= ($urgency=='High')?'selected':'' ?>>High</option>
                <option <?= ($urgency=='Critical')?'selected':'' ?>>Critical</option>
            </select>
        </div>
    </div>

    <!-- SERVICE ITEMS -->
    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Service Items:</label>
        <div class="col-sm-8">

            <table class="table table-bordered" id="service_table">
                <thead class="table-secondary">
                    <tr>
                        <th>Name</th>
                        <th>Purpose</th>
                        <th>Supplier</th>
                        <th>Net Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="serviceRows">
                    <?php if (!empty($items)) : ?>
                        <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><input type="text" name="item_name[]" class="form-control form-control-sm"
                                           value="<?= $item->item_name ?? '' ?>"></td>

                                <td><input type="text" name="item_purpose[]" class="form-control form-control-sm"
                                           value="<?= $item->item_purpose ?? '' ?>"></td>

                                <td><input type="text" name="supplier[]" class="form-control form-control-sm"
                                           value="<?= $item->supplier ?? '' ?>"></td>

                                <td><input type="number" step="0.01" name="net_amount[]" 
                                           class="form-control form-control-sm netAmount"
                                           value="<?= $item->net_amount ?? '' ?>" oninput="calculateTotal()"></td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">×</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Grand Total:</th>
                        <th>
                            <input type="text" id="grandTotal" 
                                   class="form-control form-control-sm" readonly>
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>

				<h6>Details of Approval</h6>
				<div class="form-group row">
					 <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Approve date:<span
                            style="color: red;">*</span></label>
                    <div class="col-sm-5">
                        <div class="input-group date datepicker1">
                            <input type="text" class="form-control form-control-sm datepicker1" id="approve_date"
                                name="approve_date"
                                value="<?php if ($request->approved_date == '')
                                    echo date('d-m-Y');
                                else
                                    echo date('d-m-Y', strtotime($request->approved_date) ?? '') ?>" required
                                    tabindex="1">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Status :<span
							style="color: red;">*</span></label>
					<div class="col-sm-5">
						<select class="form-select form-control-sm" name="status" id="status" required tabindex="4">
							<option value="" disabled <?php echo !isset($request->approved_flag) || $request->approved_flag == 0 ? 'selected' : ''; ?>> Please select Status </option>
							<option value="1" <?php echo isset($request->approved_flag) && $request->approved_flag == 1 ? 'selected' : ''; ?>>
								Approved
							</option>
							<option value="2" <?php echo isset($request->approved_flag) && $request->approved_flag == 2 ? 'selected' : ''; ?>>
								Rejection
							</option>
						</select>
					</div>
				</div>

				<!-- <div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Remark :</label>
					<div class="col-sm-5">
						<textarea id="approve_remark" name="approve_remark" rows="2" placeholder="remark" style="width: 100%;"
							class="bg-soft-gray" tabindex="5"><?php echo $lo->approve_remark; ?> </textarea>
					</div>
				</div> -->
    <!-- SUBMIT -->
    <div class="form-group row">
        <label class="col-sm-3"></label>
        <div class="col-sm-5">
            <button type="submit" class="btn btn-primary">Update Service Request</button>
        </div>
    </div>

</form>

</div>
</div>
<script>

	////////////////////start image for advance salary/////////////////////
	$(document).ready(function () {
		var i = 1;
		$("#add_row_salary").click(function () {
			$('#addr_salary' + i).html("<td>" + (i + 1) + "</td><td><input class='form-control' id='documents_salary" + i + "' name='documents_salary[]' type='file'></td><td><input type='text' class='form-control form-control-sm' name='document_types_salary[]' id='document_types_salary'></select></td><td></td>");
			$('#tab_logic_salary').append('<tr id="addr_salary' + (i + 1) + '"></tr>');
			i++;
		});

		$("#delete_row_salary").click(function () {
			if (i > 1) {
				$("#addr_salary" + (i - 1)).html('');
				i--;
			}
		});
	});

	////////////////////////////////start loan///////////////////////
	$(document).ready(function () {
		var i = 1;
		$("#add_row_loan").click(function () {
			$('#addr_loan' + i).html("<td>" + (i + 1) + "</td><td><input class='form-control' id='documents_loan" + i + "' name='documents_loan[]' type='file'></td><td><input type='text' class='form-control form-control-sm' name='document_types_loan[]' id='document_types_loan'></select></td><td></td>");
			$('#tab_logic_loan').append('<tr id="addr_loan' + (i + 1) + '"></tr>');
			i++;
		});

		$("#delete_row_loan").click(function () {
			if (i > 1) {
				$("#addr_loan" + (i - 1)).html('');
				i--;
			}
		});
	});
	//////////////////////////strt allowance////////////
	$(document).ready(function () {
		var i = 1;
		$("#add_row_allowance").click(function () {
			$('#addr_allowance' + i).html("<td>" + (i + 1) + "</td><td><input class='form-control' id='documents_allowance" + i + "' name='documents_allowance[]' type='file'></td><td><input type='text' class='form-control form-control-sm' name='document_types_allowance[]' id='document_types_allowance'></select></td><td></td>");
			$('#tab_logic_allowance').append('<tr id="addr_allowance' + (i + 1) + '"></tr>');
			i++;
		});

		$("#delete_row_allowance").click(function () {
			if (i > 1) {
				$("#addr_allowance" + (i - 1)).html('');
				i--;
			}
		});
	});

	//////////////////////////
	function showForm() {
		// Hide all forms
		document.querySelectorAll('.request-form').forEach(form => form.style.display = 'none');

		// Get selected value
		const selectedValue = document.getElementById('requestType').value;

		// Show the form based on selected value
		if (selectedValue === 'compensatory_leave') {
			document.getElementById('compensatory_leave_form').style.display = 'block';
		} else if (selectedValue === 'advance_salary') {
			document.getElementById('advance_salary_form').style.display = 'block';
		} else if (selectedValue === 'allowance') {
			document.getElementById('allowance_form').style.display = 'block';
		}
		else if (selectedValue === 'loan') {
			document.getElementById('loan_form').style.display = 'block';
		}

		else if (selectedValue === 'ticket_allowance') {
			document.getElementById('ticket_form').style.display = 'block';
		}
		else if (selectedValue === 'service_request') {
			document.getElementById('service_request').style.display = 'block';
		}
	}

	// Initialize the form based on selected value (in case of page reload or pre-selection)
	window.onload = function () {
		showForm();
	}
	/////////////calculation loan/////////////////
	function calculateTotalMonths() {
		const startMonth = document.getElementById("start_month").value;
		const endMonth = document.getElementById("end_month").value;

		if (startMonth && endMonth) {
			// Extract year and month from the input values
			const [startYear, startMonthValue] = startMonth.split('-');
			const [endYear, endMonthValue] = endMonth.split('-');

			// Convert to integers for calculations
			const startYearInt = parseInt(startYear, 10);
			const startMonthInt = parseInt(startMonthValue, 10);
			const endYearInt = parseInt(endYear, 10);
			const endMonthInt = parseInt(endMonthValue, 10);

			// Calculate the months difference
			let totalMonths = (endYearInt - startYearInt) * 12 + (endMonthInt - startMonthInt);

			// If the total months is less than or equal to zero, set it to an empty value
			if (totalMonths >= 0) {
				document.getElementById("total_month").value = totalMonths + 1; // Include the start month
			} else {
				document.getElementById("total_month").value = '';
			}
		} else {
			document.getElementById("total_month").value = '';
		}
	}


	function calculateEMI() {
		const rAmount = parseFloat(document.getElementById("r_amount").value) || 0;
		const totalMonths = parseFloat(document.getElementById("total_month").value) || 0;

		// Calculate EMI if both values are entered
		if (totalMonths > 0 && rAmount > 0) {
			const emi = rAmount / totalMonths;
			document.getElementById("emi_amount").value = emi.toFixed(2);
		} else {
			document.getElementById("emi_amount").value = '';
		}
	}

	function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.netAmount').forEach(input => {
        let val = parseFloat(input.value) || 0;
        total += val;
    });
    document.getElementById('grandTotal').value = total.toFixed(2);
}

// Call on page load to populate total for existing items
window.addEventListener('DOMContentLoaded', (event) => {
    calculateTotal();
});


</script>