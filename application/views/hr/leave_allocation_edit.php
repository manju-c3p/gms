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
<div class="bg-gray-100 min-h-screen py-6 px-4">

	<div class="max-w-6xl mx-auto">

		<div class="bg-white rounded-2xl shadow-md p-6">

			<div class="bg-white border-b border-gray-200 px-6 py-4 mb-5">

				<div class="flex items-center justify-between">

					<!-- Caption -->
					<h2 class="text-2xl font-semibold text-gray-800">
						Leave Approval
					</h2>

					<!-- List Button -->
					<a href="<?php echo base_url('index.php/Hr/view_leave_application_list'); ?>"
						class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow text-sm font-medium">
						+ List Leave Applications
					</a>

				</div>

			</div>


			<?php foreach ($records as $row): ?>
				<form id="main" method="post" action="<?php echo base_url('index.php/Hr/update_leave_application'); ?>"
					autocomplete="off" enctype="multipart/form-data">

					<!-- Employee Info -->
					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
						<label class="md:col-span-3 text-sm font-medium">Employee Name:</label>
						<div class="md:col-span-5">
							<?php foreach ($user_records as $s) {
								if ($row->employee_id == $s->employee_id) { ?>
									<input type="text"
										class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
										value="<?php echo $s->employee_name; ?>" readonly />

									<input type="hidden" name="employee_id_hidden" id="employee_id_hidden"
										value="<?php echo $s->employee_id; ?>" />

									<input type="hidden" name="leave_id_hidden"
										value="<?php echo $row->leave_id; ?>" />
							<?php }
							} ?>
						</div>
					</div>

					<!-- Leave Code -->
					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
						<label class="md:col-span-3 text-sm font-medium">Leave Code:</label>
						<div class="md:col-span-5">
							<input type="text" name="lv_code"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
								value="<?php echo $row->leave_code; ?>" readonly>
						</div>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
						<label class="md:col-span-3 text-sm font-medium">
							Leave Type :<span class="text-red-500">*</span>
						</label>
						<div class="md:col-span-5">

							<select class="w-full border border-gray-300 rounded px-3 py-2 text-sm select2"
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

					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
						<label class="md:col-span-3 text-sm font-medium">
							Allocate Leave & Use Leave :<span class="text-red-500">*</span>
						</label>

						<div class="md:col-span-2">
							<input type="text"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
								id="allocated_leave" name="allocated_leave" readonly>
						</div>

						<div class="md:col-span-2">
							<input type="text"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
								id="avilable_leave" name="avilable_leave" value="" readonly>
						</div>
					</div>

					<!-- Leave Dates -->
					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
						<label class="md:col-span-3 text-sm font-medium">Leave From - To:</label>

						<div class="md:col-span-2">
							<input type="date"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
								name="start_date"
								value="<?php echo date('Y-m-d', strtotime($row->start_date)); ?>" readonly>
						</div>

						<div class="md:col-span-2">
							<input type="date"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
								name="end_date"
								value="<?php echo date('Y-m-d', strtotime($row->end_date)); ?>" readonly>
						</div>
					</div>

					<!-- Total Days -->
					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
						<label class="md:col-span-3 text-sm font-medium">Total Days:</label>

						<div class="md:col-span-1">
							<?php
							$start = new DateTime($row->start_date);
							$end = new DateTime($row->end_date);
							$diff = $start->diff($end);
							?>
							<input type="text"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
								name="total_date"
								value="<?php echo $diff->days + 1; ?>" readonly>
						</div>
					</div>

					<!-- Reason -->
					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">
						<label class="md:col-span-3 text-sm font-medium">Reason:</label>

						<div class="md:col-span-5">
							<textarea
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
								name="reason"><?php echo $row->reason; ?></textarea>
						</div>
					</div>

					<!-- Contact -->
					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">
						<label class="md:col-span-3 text-sm font-medium">
							Contact & Address During Leave:
						</label>

						<div class="md:col-span-5">
							<textarea
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
								name="outside_contact"><?php echo $row->outside_contact; ?></textarea>
						</div>
					</div>

					<!-- Replacement -->
					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
						<label class="md:col-span-3 text-sm font-medium">Charge Handed To:</label>

						<div class="md:col-span-5">
							<select class="w-full border border-gray-300 rounded px-3 py-2 text-sm select2"
								name="replcement">

								<option value="">Select</option>

								<?php foreach ($user_records as $s) { ?>
									<option value="<?php echo $s->employee_id; ?>"
										<?php if ($row->replcement == $s->employee_id) echo 'selected'; ?>>
										<?php echo $s->employee_name; ?>
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

				<h6 class="text-lg font-semibold mb-4">Leave Approval Details</h6>

				<!-- Approve Date & Approve From -->
				<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

					<label class="md:col-span-2 text-sm font-medium">Approve Date:</label>
					<div class="md:col-span-4">
						<input type="text"
							class="w-full border border-gray-300 rounded px-3 py-2 text-sm datepicker1"
							name="approve_date"
							value="<?php echo $application_date; ?>" required>

						<input type="hidden"
							class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
							name="leave_type"
							value="<?php echo $leave_type; ?>" required>
					</div>

					<label class="md:col-span-2 text-sm font-medium">Approve From:</label>
					<div class="md:col-span-4">
						<input type="text"
							class="w-full border border-gray-300 rounded px-3 py-2 text-sm datepicker1"
							name="approve_start_date"
							onchange="approve_calculate_total_days()"
							value="<?php echo $approve_start_date; ?>">
					</div>

				</div>

				<!-- Approve To & Total Leave Days -->
				<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

					<label class="md:col-span-2 text-sm font-medium">Approve To:</label>
					<div class="md:col-span-4">
						<input type="text"
							class="w-full border border-gray-300 rounded px-3 py-2 text-sm datepicker1"
							name="approve_end_date"
							onchange="approve_calculate_total_days()"
							value="<?php echo $approve_end_date; ?>">
					</div>

					<label class="md:col-span-2 text-sm font-medium">Total Leave Days:</label>
					<div class="md:col-span-4">
						<?php
						$start = new DateTime($approve_start_date);
						$end = new DateTime($approve_end_date);
						$diff = $start->diff($end);
						?>
						<input type="text"
							class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
							name="approve_total_date"
							value="<?php echo $diff->days; ?>" readonly>
					</div>

				</div>

				<!-- Leave Status & Approved HOD -->
				<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

					<label class="md:col-span-2 text-sm font-medium">Leave Status:</label>
					<div class="md:col-span-4">
						<select class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
							name="leave_status" required>
							<option value="" disabled selected>Please select</option>
							<option value="1" <?php if ($leave_status == 1) echo 'selected'; ?>>Approved</option>
							<option value="2" <?php if ($leave_status == 2) echo 'selected'; ?>>Rejected</option>
						</select>
					</div>

					<label class="md:col-span-2 text-sm font-medium">Approved HOD:</label>
					<div class="md:col-span-4">
						<select class="w-full border border-gray-300 rounded px-3 py-2 text-sm select2"
							name="approve_admin">
							<option value="">Select</option>
							<?php if (!empty($first_level_approver)) { ?>
								<option value="<?php echo $first_level_approver->reporting_mngr; ?>" selected>
									<?php echo $first_level_approver->reporting_mngr_name; ?>
								</option>
							<?php } ?>
						</select>
					</div>

				</div>

				<!-- Approved HR & Approved CEO -->
				<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">

					<label class="md:col-span-2 text-sm font-medium">Approved HR:</label>
					<div class="md:col-span-4">

						<?php if ($user_dept_id == 3): ?>
							<input type="text"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
								value="<?php echo $this->session->userdata('user_name'); ?>" readonly>

							<input type="hidden" name="approve_hr"
								value="<?php echo $logged_in_user; ?>">

						<?php else: ?>

							<input type="text"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
								value="<?php echo !empty($hr_id) ? $hr_name : ''; ?>" readonly>

							<input type="hidden" name="approve_hr"
								value="<?php echo $hr_id ?? ''; ?>">

						<?php endif; ?>

					</div>

					<label class="md:col-span-2 text-sm font-medium">Approved CEO:</label>
					<div class="md:col-span-4">

						<?php if ($this->session->userdata('desig_id') == 60): ?>

							<input type="text"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
								value="<?php echo $this->session->userdata('user_name'); ?>" readonly>

							<input type="hidden" name="approve_ceo"
								value="<?php echo $this->session->userdata('user_id'); ?>">

						<?php else: ?>

							<input type="text"
								class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100"
								value="<?php echo $ceo_name; ?>" readonly>

							<input type="hidden" name="approve_ceo"
								value="<?php echo $approval_record[0]->ceo ?? ''; ?>">

						<?php endif; ?>

					</div>

				</div>

				<!-- Remark -->
				<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4">

					<label class="md:col-span-2 text-sm font-medium">Remark:</label>
					<div class="md:col-span-4">
						<textarea
							class="w-full border border-gray-300 rounded px-3 py-2 text-sm"
							name="approve_remark"><?php echo $approve_remark; ?></textarea>
					</div>

				</div>

				<?php
				$logged_in_user = $this->session->userdata('user_id');
				$user_dept_id = $this->session->userdata('dept_id');
				$user_desig_id = $this->session->userdata('desig_id');
				$show_submit = false;

				if ($user_desig_id == 60) {
					$show_submit = true;
				} elseif ($user_dept_id == 3 && $row->dept_id != 3) {
					$show_submit = true;
				} elseif ($leave_status != 1) {
					$show_submit = true;
				}

				if ($show_submit):
				?>

					<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-6">
						<div class="md:col-span-4 md:col-start-3">
							<input type="hidden" name="hide_leave_id"
								value="<?php echo $leave_approve_id; ?>">
							<input type="hidden" name="emp_id"
								value="<?php echo $row->employee_id; ?>">

							<button type="submit"
								class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow text-sm">
								Submit
							</button>
						</div>
					</div>

				<?php endif; ?>

			</form>


		</div>

	</div>

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
