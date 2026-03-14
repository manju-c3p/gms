<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>Employee Name</th>
					<th>Application Date</th>
					<th>Reqtype Type</th>
					<th>Application Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				<?php foreach ($records as $row) { ?>
					<tr>
						<td>
							<?php echo $i++; ?>
						</td>

						<td>
							<?php echo $row->name; ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->app_date)); ?>
						</td>
						<td>
							<?php echo $row->emp_reqtype; ?>
						</td>
						<td>
							<?php
							$latest_status = 'Pending';

							if ($row->approved_flag == 0) {
								$latest_status = 'Pending';
								$status_color = 'yellow'; // Pending
							} else if ($row->approved_flag == 1) {
								$latest_status = 'Approved';
								$status_color = 'green'; // Approved
							} else if ($row->approved_flag == 2) {
								$latest_status = 'Rejected';
								$status_color = 'red'; // Rejected
							} else if ($row->approved_flag == 3) {
								$latest_status = 'Cancel';
								$status_color = '#ff8c00'; // Orange - Cancel
							} else if ($row->approved_flag == 4) {
								$latest_status = 'Cancel By Hr';
								$status_color = '#800080'; // Purple - Cancel By HR
							}


							echo '<span style="color:' . $status_color . '; font-weight: bold;">' . $latest_status . '</span>';
							?>
						</td>



						<td>
							<a href="<?php echo base_url() . 'index.php/Hr/view_emp_request_edit_data/' . $row->emp_req_id; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <a href="<?php echo base_url() . 'index.php/Hr/delete_leave_application/' . $row->emp_req_id; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->emp_req_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a> <br> -->
							
								<a href="<?php echo base_url(); ?>" title="employee requested to cancel request"
									onclick="return confirmCancel(<?php echo $row->emp_req_id; ?>);">Cancel Request</a>
							
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
</div>

<!-- Static Table End -->

<script>
	// function confirmcancel(tid) {
	// 	var r = confirm("Are you sure you want to Delete Record?");
	// 	if (r == true) {
	// 		$.ajax({
	// 			url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
	// 			type: "POST",
	// 			data: {
	// 				table_name: 'employee_request_data',
	// 				where_key: 'emp_req_id',
	// 				where_val: tid
	// 			},
	// 			success: function (msg) {
	// 				if (msg == 1) {
	// 					window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
	// 				} else {
	// 					alert("Can't Delete record. Data already exist!!!");
	// 				}
	// 			},
	// 		});
	// 		return true;
	// 	} else
	// 		return false;
	// }


	function confirmCancel(tid) {
		var r = confirm("Are you sure you want to Cancel Employee Request?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/cancel_emp_request",
				type: "POST",
				data: {
					table_name: 'employee_request_data',
					where_key: 'emp_req_id',
					where_val: tid,
					column: 'approved_flag',
					value: 4
				},
				success: function (msg) {
					if (msg == 1) {
						window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
					} else {
						alert("Unable to update the request status.");
					}
				},
				error: function () {
					alert("An error occurred while processing the request.");
				}
			});
			return true;
		} else {
			return false;
		}
	}
</script>