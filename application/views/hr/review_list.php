<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>SR No</th>
					<th>User Name</th>
					<th>Department</th>
					<th>Position</th>
					<th>Review Date</th>
					<th>Review From</th>
					<th>Review From</th>
					<th>Overall Rating</th>
					<th>Requested BY</th>
					<th>HR Approval</th>
					<th>CEO Approval</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($records as $row) {

					if ($row->hr_approval == '0')
						$hr_approval = "<span style='color:orange;'>Pending</span>";
					else if ($row->hr_approval == '1')
						$hr_approval = "<span style='color:green;'>Approved</span>";
					else if ($row->hr_approval == '2')
						$hr_approval = "<span style='color:red;'>Not Approved</span>";
					else
						$hr_approval = " ";

					if ($row->ceo_approval == '0')
						$ceo_approval = "<span style='color:orange;'>Pending</span>";
					else if ($row->ceo_approval == '1')
						$ceo_approval = "<span style='color:green;'>Approved</span>";
					else if ($row->ceo_approval == '2')
						$ceo_approval = "<span style='color:red;'>Not Approved</span>";
					else
						$ceo_approval = " ";
					if ($row->hr_approval == '1' && $row->ceo_approval == '1')
						$app = 1;
					else
						$app = 0;
					?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>

						<td>
							<?php echo $row->user_name . ' ' . $row->middle_name . ' ' . $row->last_name; ?>
						</td>
						<td>
							<?php echo $row->dept_name; ?>
						</td>
						<td>
							<?php echo $row->designation_name; ?>
						</td>

						<td>
							<?php echo $row->review_date; ?>
						</td>
						<td>
							<?php echo $row->review_period_from; ?>
						</td>
						<td>
							<?php echo $row->review_period_to; ?>
						</td>
						<td>
							<?php echo $row->overall_rating; ?>
						</td>
						<td>
							<?php echo $row->created_by_name; ?>
						</td>
						<td>
							<?php echo $hr_approval; ?>
						</td>
						<td>
							<?php echo $ceo_approval; ?>
						</td>
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_review/' . $row->review_id; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>
							<a href="<?php echo base_url(); ?>index.php/Hr/list_review" title="Delete"
								onclick="return confirmcancel(<?php echo $row->review_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>
							<?php if (empty($row->review_doc_path)) { ?>
								<a target='_blank'
									href="<?php echo base_url() . 'index.php/Hr/print_review_form/' . $row->review_id; ?>"
									title="Download Review Form"><i class="fa fa-print" style="font-size:18px"></i></a>
							<?php } else { ?>
								<a href="<?php echo base_url() . 'public/uploded_documents/' . $row->review_doc_path; ?>"
									title="Print Review Form" target="_blank"><i class="fa fa-print"
										style="font-size:18px"></i></a>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Static Table End -->



<script>
	function confirmcancel(tid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'employee_review_master',
					where_key: 'review_id',
					where_val: tid
				},
				success: function (msg) {
					if (msg == 1) {

						$.ajax({
							url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
							type: "POST",
							data: {
								table_name: 'employee_clearance_entries',
								where_key: 'review_id',
								where_val: tid
							},
							success: function (msg) {
								if (msg == 1) {

									window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
								} else {
									alert("Can't Delete record. Data already exist!!!");
								}
							},
						});
					} else {
						alert("Can't Delete record. Data already exist!!!");
					}
				},
			});
			return true;
		} else
			return false;

	}
</script>