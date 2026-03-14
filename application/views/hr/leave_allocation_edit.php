<?php
$logged_in_user = $this->session->userdata('user_id');
$user_dept_id   = $this->session->userdata('dept_id'); // 3 = HR


// Set HOD (reporting manager) info
$hod_id   = !empty($first_level_approver->reporting_mngr) ? $first_level_approver->reporting_mngr : '';
$hod_name = !empty($first_level_approver->reporting_mngr_name) ? $first_level_approver->reporting_mngr_name : '';

// Set HR info
$hr_id   = !empty($approval_record[0]->hr) ? $approval_record[0]->hr : '';
$hr_name = '';
foreach ($admin_hr as $h) {
	if ($h->hr_user_id == $hr_id) {
		$hr_name = $h->hr_user_name;
		break;
	}
}
// Get CEO name from users table
$ceo_name = '';
if (!empty($approval_record[0]->ceo)) {
	$ceo_user = $this->db->get_where('users', ['user_id' => $approval_record[0]->ceo])->row();
	if ($ceo_user) {
		$ceo_name = $ceo_user->user_name;
	}
}
?>
<!-- ===================================================================================== -->
<div class="bg-white shadow rounded-lg p-6">

	<?php foreach ($records as $row): ?>
		<form id="main" method="post" action="<?php echo base_url('index.php/Hr/update_leave_application'); ?>"
			autocomplete="off" enctype="multipart/form-data">

			<!-- Employee Info -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">Employee Name:</label>
				<div class="col-span-12 md:col-span-5">
					<?php foreach ($user_records as $s) {
						if ($row->employee_id == $s->id) { ?>
							<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
								value="<?php echo $s->username; ?>" readonly />
							<input type="hidden" name="employee_id_hidden" id="employee_id_hidden" value="<?php echo $s->id; ?>" />
							<input type="hidden" name="leave_id_hidden" value="<?php echo $row->leave_id; ?>" />
					<?php }
					} ?>
				</div>
			</div>

			<!-- Leave Code -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">Leave Code:</label>
				<div class="col-span-12 md:col-span-5">
					<input type="text" name="lv_code" class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
						value="<?php echo $row->leave_code; ?>" readonly>
				</div>
			</div>

			<div class="grid grid-cols-12 gap-4 mb-4 items-center">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
					Leave Type :<span class="text-red-500">*</span>
				</label>
				<div class="col-span-12 md:col-span-5">

					<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2"
						name="ltype_id" id="ltype_id" required onchange="data_for_leave_days();">
						<option value="">Select</option>
						<?php foreach ($category as $cat) { ?>
							<option
								value="<?php echo $cat->leave_cat_id; ?>"
								data-days="<?php echo $cat->leave_days; ?>"
								<?php if ($row->leave_type == $cat->leave_cat_id) echo 'selected'; ?>>
								<?php echo $cat->category_name; ?>
							</option>
						<?php } ?>
					</select>

				</div>
			</div>

			<div class="grid grid-cols-12 gap-4 mb-4 items-center">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
					Allocate Leave & Use Leave :<span class="text-red-500">*</span>
				</label>

				<div class="col-span-12 md:col-span-3">
					<div>
						<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
							id="allocated_leave" name="allocated_leave" tabindex="4" readonly>
					</div>
				</div>

				<div class="col-span-12 md:col-span-3">
					<div>
						<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
							id="avilable_leave" name="avilable_leave" value="" tabindex="5" readonly>
					</div>
				</div>
			</div>

			<!-- Leave Dates -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
					Leave From - To:
				</label>

				<div class="col-span-12 md:col-span-3">
					<input type="date" class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						name="start_date"
						value="<?php echo date('Y-m-d', strtotime($row->start_date)); ?>" readonly>
				</div>

				<div class="col-span-12 md:col-span-3">
					<input type="date" class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						name="end_date"
						value="<?php echo date('Y-m-d', strtotime($row->end_date)); ?>" readonly>
				</div>
			</div>

			<!-- Total Days -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
					Total Days:
				</label>

				<div class="col-span-12 md:col-span-2">
					<?php
					$start = new DateTime($row->start_date);
					$end = new DateTime($row->end_date);
					$diff = $start->diff($end);
					?>
					<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						name="total_date"
						value="<?php echo $diff->days + 1; ?>" readonly>
				</div>
			</div>

			<!-- Reason & Contact -->
			<div class="grid grid-cols-12 gap-4 mb-4">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
					Reason:
				</label>

				<div class="col-span-12 md:col-span-5">
					<textarea class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						name="reason"><?php echo $row->reason; ?></textarea>
				</div>
			</div>

			<div class="grid grid-cols-12 gap-4 mb-4">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
					Contact & Address During Leave:
				</label>

				<div class="col-span-12 md:col-span-5">
					<textarea class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						name="outside_contact"><?php echo $row->outside_contact; ?></textarea>
				</div>
			</div>

			<!-- Replacement -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">
				<label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
					Charge Handed To:
				</label>

				<div class="col-span-12 md:col-span-5">
					<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2"
						name="replcement">
						<option value="">Select</option>
						<?php foreach ($user_records as $s) { ?>
							<option value="<?php echo $s->id; ?>" <?php if ($row->replcement == $s->id) echo 'selected'; ?>>
								<?php echo $s->username; ?>
							</option>
						<?php } ?>
					</select>
				</div>
			</div>

		</form>
	<?php endforeach; ?>


	<?php
	// Approval Variables
	$application_date = date('d-m-Y');
	$approve_start_date = !empty($row->start_date) ? date('d-m-Y', strtotime($row->start_date)) : '';
	$approve_end_date = !empty($row->end_date) ? date('d-m-Y', strtotime($row->end_date)) : '';
	$hr_id = $this->session->userdata('user_id');
	$leave_approve_id = $row->leave_id;
	$approve_remark = '';
	$leave_type = $row->leave_type;
	$leave_status = 0;
	$avilable_leave = $row->use_paid_leave;

	foreach ($approval_record as $r) {
		if (!empty($r->approval_leave_id)) {
			$application_date = !empty($r->approved_date) ? date('d-m-Y', strtotime($r->approved_date)) : $application_date;
			$approve_start_date = !empty($r->approve_start_date) ? date('d-m-Y', strtotime($r->approve_start_date)) : $approve_start_date;
			$approve_end_date = !empty($r->approve_end_date) ? date('d-m-Y', strtotime($r->approve_end_date)) : $approve_end_date;
			$hr_id = $r->hr;
			$leave_approve_id = $r->approval_leave_id;
			$approve_remark = $r->remark;
			$leave_status = $r->leave_status;
		}
	}
	?>


	<!-- Leave Approval Form -->
	<form method="post" action="<?php echo base_url('index.php/Hr/add_leave_approval'); ?>" autocomplete="off">

		<h6 class="text-base font-semibold text-gray-700 mb-4">
			Leave Approval Details
		</h6>

		<!-- Approve Date & Approve From -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Approve Date:
			</label>

			<div class="col-span-12 md:col-span-4">
				<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
					name="approve_date"
					value="<?php echo $application_date; ?>" required>

				<input type="hidden" class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
					name="leave_type"
					value="<?php echo $leave_type; ?>" required>
			</div>

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Approve From:
			</label>

			<div class="col-span-12 md:col-span-4">
				<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
					name="approve_start_date"
					onchange="approve_calculate_total_days()" value="<?php echo $approve_start_date; ?>">
			</div>

		</div>

		<!-- Approve To & Total Leave Days -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Approve To:
			</label>

			<div class="col-span-12 md:col-span-4">
				<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
					name="approve_end_date"
					onchange="approve_calculate_total_days()" value="<?php echo $approve_end_date; ?>">
			</div>

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Total Leave Days:
			</label>

			<div class="col-span-12 md:col-span-4">

				<?php
				$start = new DateTime($approve_start_date);
				$end = new DateTime($approve_end_date);
				$diff = $start->diff($end);
				?>

				<input type="text" class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
					name="approve_total_date"
					value="<?php echo $diff->days; ?>" readonly>

			</div>

		</div>
		<!-- Leave Status & Approved HOD -->
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Leave Status:</label>
			<div class="col-sm-4">
				<select class="form-select form-control-sm" name="leave_status" required>
					<option value="" disabled selected>Please select</option>
					<option value="1" <?php if ($leave_status == 1) echo 'selected'; ?>>Approved</option>
					<option value="2" <?php if ($leave_status == 2) echo 'selected'; ?>>Rejected</option>
				</select>
			</div>

			<label class="col-sm-2 col-form-label">Approved HOD:</label>
			<div class="col-sm-4">
				<select class="form-select form-control-sm select2" name="approve_admin">
					<option value="">Select</option>
					<?php if (!empty($first_level_approver)) { ?>
						<option value="<?php echo $first_level_approver->reporting_mngr; ?>" selected>
							<?php echo $first_level_approver->reporting_mngr_name; ?>
						</option>
					<?php } ?>
				</select>
			</div>
		</div>

		<!-- Approved HR & Remark -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Approved HR:
			</label>

			<div class="col-span-12 md:col-span-4">
				<?php if ($user_dept_id == 3): // HR logged in 
				?>
					<input type="text"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						value="<?php echo $this->session->userdata('user_name'); ?>" readonly>

					<input type="hidden" name="approve_hr" value="<?php echo $logged_in_user; ?>">

				<?php else: // Manager or others 
				?>
					<input type="text"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						value="<?php echo !empty($hr_id) ? $hr_name : ''; ?>" readonly>

					<input type="hidden" name="approve_hr" value="<?php echo $hr_id ?? ''; ?>">
				<?php endif; ?>
			</div>


			<!-- Approved CEO -->
			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Approved CEO:
			</label>

			<div class="col-span-12 md:col-span-4">
				<?php if ($this->session->userdata('desig_id') == 60): // CEO logged in 
				?>
					<input type="text"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						value="<?php echo $this->session->userdata('user_name'); ?>" readonly>

					<input type="hidden" name="approve_ceo"
						value="<?php echo $this->session->userdata('user_id'); ?>">

				<?php else: ?>
					<input type="text"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						value="<?php echo $ceo_name; ?>" readonly>

					<input type="hidden" name="approve_ceo"
						value="<?php echo $approval_record[0]->ceo ?? ''; ?>">
				<?php endif; ?>
			</div>

		</div>


		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Remark:
			</label>

			<div class="col-span-12 md:col-span-4">
				<textarea class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
					name="approve_remark"><?php echo $approve_remark; ?></textarea>
			</div>

		</div>


		<?php
		$logged_in_user = $this->session->userdata('user_id');
		$user_dept_id = $this->session->userdata('dept_id'); // dept_id = 3 for HR
		$user_desig_id = $this->session->userdata('desig_id'); // desig_id = 60 for CEO
		$show_submit = false;

		// CEO can always approve
		if ($user_desig_id == 60) {
			$show_submit = true;
		}
		// HR can approve if applicant is not from HR
		elseif ($user_dept_id == 3 && $row->dept_id != 3) {
			$show_submit = true;
		}
		// Manager or other approvers can approve if leave not yet approved
		elseif ($leave_status != 1) {
			$show_submit = true;
		}

		if ($show_submit):
		?>

			<div class="grid grid-cols-12 gap-4 mb-4">
				<div class="col-span-12 md:col-span-4 md:col-start-3">

					<input type="hidden" name="hide_leave_id"
						value="<?php echo $leave_approve_id; ?>">

					<input type="hidden" name="emp_id"
						value="<?php echo $row->employee_id; ?>">

					<button type="submit"
						class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
						Submit
					</button>

				</div>
			</div>

		<?php endif; ?>
	</form>



	<!-- ============================================================== -->
	<div class="card-body">

		<?php foreach ($records as $row): ?>
			<form id="main" method="post" action="<?php echo base_url('index.php/Hr/update_leave_application'); ?>"
				autocomplete="off" enctype="multipart/form-data">

				<!-- Employee Info -->
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Employee Name:</label>
					<div class="col-sm-5">
						<?php foreach ($user_records as $s) {
							if ($row->employee_id == $s->id) { ?>
								<input type="text" class="form-control form-control-sm bg-soft-gray"
									value="<?php echo $s->username; ?>" readonly />
								<input type="hidden" name="employee_id_hidden" id="employee_id_hidden" value="<?php echo $s->id; ?>" />
								<input type="hidden" name="leave_id_hidden" value="<?php echo $row->leave_id; ?>" />
						<?php }
						} ?>
					</div>
				</div>

				<!-- Leave Code -->
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Leave Code:</label>
					<div class="col-sm-5">
						<input type="text" name="lv_code" class="form-control bg-soft-gray"
							value="<?php echo $row->leave_code; ?>" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Leave Type :<span style="color: red;">*</span></label>
					<div class="col-sm-5">

						<select class="form-select form-control-sm select2 "
							name="ltype_id" id="ltype_id" required onchange=data_for_leave_days();>
							<option value="">Select</option>
							<?php foreach ($category as $cat) { ?>
								<option
									value="<?php echo $cat->leave_cat_id; ?>"
									data-days="<?php echo $cat->leave_days; ?>"
									<?php if ($row->leave_type == $cat->leave_cat_id) echo 'selected'; ?>>
									<?php echo $cat->category_name; ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Allocate Leave & Use Leave :<span style="color: red;">*</span></label>
					<div class="col-sm-3">
						<div class="input-group ">
							<input type="text" class="form-control form-control-sm bg-soft-gray" id="allocated_leave" name="allocated_leave" tabindex="4" readonly>


						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group  ">
							<input type="text" class="form-control form-control-sm bg-soft-gray" id="avilable_leave" name="avilable_leave" value="" tabindex="5" readonly>

						</div>
					</div>
				</div>
				<!-- Leave Dates -->
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Leave From - To:</label>
					<div class="col-sm-3">
						<input type="date" class="form-control form-control-sm" name="start_date"
							value="<?php echo date('Y-m-d', strtotime($row->start_date)); ?>" readonly>
					</div>
					<div class="col-sm-3">
						<input type="date" class="form-control form-control-sm" name="end_date"
							value="<?php echo date('Y-m-d', strtotime($row->end_date)); ?>" readonly>
					</div>
				</div>

				<!-- Total Days -->
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Total Days:</label>
					<div class="col-sm-2">
						<?php
						$start = new DateTime($row->start_date);
						$end = new DateTime($row->end_date);
						$diff = $start->diff($end);
						?>
						<input type="text" class="form-control form-control-sm" name="total_date"
							value="<?php echo $diff->days + 1; ?>" readonly>
					</div>
				</div>

				<!-- Reason & Contact -->
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Reason:</label>
					<div class="col-sm-5">
						<textarea class="form-control form-control-sm" name="reason"><?php echo $row->reason; ?></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Contact & Address During Leave:</label>
					<div class="col-sm-5">
						<textarea class="form-control form-control-sm" name="outside_contact"><?php echo $row->outside_contact; ?></textarea>
					</div>
				</div>

				<!-- Replacement -->
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Charge Handed To:</label>
					<div class="col-sm-5">
						<select class="form-select form-control-sm select2" name="replcement">
							<option value="">Select</option>
							<?php foreach ($user_records as $s) { ?>
								<option value="<?php echo $s->id; ?>" <?php if ($row->replcement == $s->id) echo 'selected'; ?>>
									<?php echo $s->username; ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>


			</form>
		<?php endforeach; ?>

		<?php
		// Approval Variables
		$application_date = date('d-m-Y');
		$approve_start_date = !empty($row->start_date) ? date('d-m-Y', strtotime($row->start_date)) : '';
		$approve_end_date = !empty($row->end_date) ? date('d-m-Y', strtotime($row->end_date)) : '';
		$hr_id = $this->session->userdata('user_id');
		$leave_approve_id = $row->leave_id;
		$approve_remark = '';
		$leave_type = $row->leave_type;
		$leave_status = 0;
		$avilable_leave = $row->use_paid_leave;

		foreach ($approval_record as $r) {
			if (!empty($r->approval_leave_id)) {
				$application_date = !empty($r->approved_date) ? date('d-m-Y', strtotime($r->approved_date)) : $application_date;
				$approve_start_date = !empty($r->approve_start_date) ? date('d-m-Y', strtotime($r->approve_start_date)) : $approve_start_date;
				$approve_end_date = !empty($r->approve_end_date) ? date('d-m-Y', strtotime($r->approve_end_date)) : $approve_end_date;
				$hr_id = $r->hr;
				$leave_approve_id = $r->approval_leave_id;
				$approve_remark = $r->remark;
				$leave_status = $r->leave_status;
			}
		}
		?>
		<!-- Leave Approval Form -->
		<form method="post" action="<?php echo base_url('index.php/Hr/add_leave_approval'); ?>" autocomplete="off">
			<h6>Leave Approval Details</h6>

			<!-- Approve Date & Approve From -->
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Approve Date:</label>
				<div class="col-sm-4">
					<input type="text" class="form-control form-control-sm datepicker1" name="approve_date"
						value="<?php echo $application_date; ?>" required>

					<input type="hidden" class="form-control form-control-sm " name="leave_type"
						value="<?php echo $leave_type; ?>" required>
				</div>

				<label class="col-sm-2 col-form-label">Approve From:</label>
				<div class="col-sm-4">
					<input type="text" class="form-control form-control-sm datepicker1" name="approve_start_date"
						onchange="approve_calculate_total_days()" value="<?php echo $approve_start_date; ?>">
				</div>
			</div>

			<!-- Approve To & Total Leave Days -->
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Approve To:</label>
				<div class="col-sm-4">
					<input type="text" class="form-control form-control-sm datepicker1" name="approve_end_date"
						onchange="approve_calculate_total_days()" value="<?php echo $approve_end_date; ?>">
				</div>

				<label class="col-sm-2 col-form-label">Total Leave Days:</label>
				<div class="col-sm-4">
					<?php
					$start = new DateTime($approve_start_date);
					$end = new DateTime($approve_end_date);
					$diff = $start->diff($end);
					?>
					<input type="text" class="form-control form-control-sm" name="approve_total_date"
						value="<?php echo $diff->days; ?>" readonly>
				</div>
			</div>


			<!-- Leave Status & Approved HOD -->
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Leave Status:</label>
				<div class="col-sm-4">
					<select class="form-select form-control-sm" name="leave_status" required>
						<option value="" disabled selected>Please select</option>
						<option value="1" <?php if ($leave_status == 1) echo 'selected'; ?>>Approved</option>
						<option value="2" <?php if ($leave_status == 2) echo 'selected'; ?>>Rejected</option>
					</select>
				</div>

				<label class="col-sm-2 col-form-label">Approved HOD:</label>
				<div class="col-sm-4">
					<select class="form-select form-control-sm select2" name="approve_admin">
						<option value="">Select</option>
						<?php if (!empty($first_level_approver)) { ?>
							<option value="<?php echo $first_level_approver->reporting_mngr; ?>" selected>
								<?php echo $first_level_approver->reporting_mngr_name; ?>
							</option>
						<?php } ?>
					</select>
				</div>
			</div>

			<!-- Approved HR & Remark -->
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Approved HR:</label>
				<div class="col-sm-4">
					<?php if ($user_dept_id == 3): // HR logged in 
					?>
						<input type="text" class="form-control form-control-sm"
							value="<?php echo $this->session->userdata('user_name'); ?>" readonly>
						<input type="hidden" name="approve_hr" value="<?php echo $logged_in_user; ?>">
					<?php else: // Manager or others 
					?>
						<input type="text" class="form-control form-control-sm"
							value="<?php echo !empty($hr_id) ? $hr_name : ''; ?>" readonly>
						<input type="hidden" name="approve_hr" value="<?php echo $hr_id ?? ''; ?>">
					<?php endif; ?>
				</div>

				<!-- Approved CEO -->
				<label class="col-sm-2 col-form-label">Approved CEO:</label>
				<div class="col-sm-4">
					<?php if ($this->session->userdata('desig_id') == 60): // CEO logged in 
					?>
						<input type="text" class="form-control form-control-sm"
							value="<?php echo $this->session->userdata('user_name'); ?>" readonly>
						<input type="hidden" name="approve_ceo" value="<?php echo $this->session->userdata('user_id'); ?>">
					<?php else: ?>
						<input type="text" class="form-control form-control-sm"
							value="<?php echo $ceo_name; ?>" readonly>
						<input type="hidden" name="approve_ceo" value="<?php echo $approval_record[0]->ceo ?? ''; ?>">
					<?php endif; ?>
				</div>

				<div class="form-group row">

					<label class="col-sm-2 col-form-label">Remark:</label>
					<div class="col-sm-4">
						<textarea class="form-control form-control-sm" name="approve_remark"><?php echo $approve_remark; ?></textarea>
					</div>
				</div>
				<?php
				$logged_in_user = $this->session->userdata('user_id');
				$user_dept_id = $this->session->userdata('dept_id'); // dept_id = 3 for HR
				$user_desig_id = $this->session->userdata('desig_id'); // desig_id = 60 for CEO
				$show_submit = false;

				// CEO can always approve
				if ($user_desig_id == 60) {
					$show_submit = true;
				}
				// HR can approve if applicant is not from HR
				elseif ($user_dept_id == 3 && $row->dept_id != 3) {
					$show_submit = true;
				}
				// Manager or other approvers can approve if leave not yet approved
				elseif ($leave_status != 1) {
					$show_submit = true;
				}

				if ($show_submit):
				?>
					<div class="form-group row">
						<div class="col-sm-4 offset-sm-2">
							<input type="hidden" name="hide_leave_id" value="<?php echo $leave_approve_id; ?>">
							<input type="hidden" name="emp_id" value="<?php echo $row->employee_id; ?>">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				<?php endif; ?>

		</form>


	</div>


	<script>
		function approve_calculate_total_days() {
			const start = document.querySelector('[name="approve_start_date"]').value.split('-');
			const end = document.querySelector('[name="approve_end_date"]').value.split('-');

			const startDate = new Date(start[2], start[1] - 1, start[0]);
			const endDate = new Date(end[2], end[1] - 1, end[0]);

			const diff = Math.ceil(Math.abs(endDate - startDate) / (1000 * 60 * 60 * 24)) + 1; // Add 1 day
			document.querySelector('[name="approve_total_date"]').value = diff;
		}
		document.addEventListener('DOMContentLoaded', function() {
			approve_calculate_total_days();
		});

		const availableLeave = <?php echo (int)$avilable_leave; ?>;

		function updateRemainingLeave() {
			const input = document.querySelector('[name="use_paid_leave"]');
			let val = parseInt(input.value) || 0;
			if (val > availableLeave) {
				alert('Exceeds available leave');
				input.value = '';
				return;
			}
			document.getElementById('remaining_leave').textContent = availableLeave - val;
			document.getElementById('avilable_leave_rem').value = availableLeave - val;
		}

		window.onload = function() {
			data_for_leave_days();
		};

		function data_for_leave_days() {

			var ltype_id = document.getElementById('ltype_id').value;
			var employee_id = document.getElementById('employee_id_hidden').value;


			if (ltype_id != '') {
				$.ajax({
					async: "false",
					type: "POST",
					url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_paid_leave_info",
					data: {
						ltype_id: ltype_id,
						employee_id: employee_id
					},
					dataType: "json",
					success: function(msg) {


						document.getElementById("avilable_leave").value = msg.use_paid_leave;
						document.getElementById("allocated_leave").value = msg.paid_days;


					}
				});
			} else {
				document.getElementById("avilable_leave").value = '';
				document.getElementById("allocated_leave").value = '';



			}
		}
	</script>
