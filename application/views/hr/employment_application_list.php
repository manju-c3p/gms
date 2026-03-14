<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>APP CODE</th>
					<th>Application Date</th>
					<th>Employee Name</th>
                    <th>Notice Period</th>
					<th>Age</th>
                    <th>Contact No</th>
                    <th>Visa status</th>
					<th>Salary</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;//print_r($records);
				foreach ($records as $row) { ?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						<td>
							<?php echo $row->emp_app_code; ?>
						</td>
						<td>
							<?php echo $row->application_date; ?>
						</td>
						<td>
							<?php echo $row->applicant_name; ?>
						</td>
						<td>
							<?php echo $row->notice_period; ?>
						</td>
						
                        <td>
							<?php echo $row->age; ?>
						</td>
                        <td>
							<?php echo $row->contact_number; ?>
						</td>
						<td>
							<?php echo $row->visa_status; ?>
						</td>
						<td>
							<?php echo $row->curr_salary; ?>
						</td>
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_employment/'.$row->emp_app_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url() . 'index.php/Hr/list_employment/' ; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->emp_app_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php //if(empty($row->emp_app_id)){?>
								<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_employment/'.$row->emp_app_id ; ?>"
									title="Download Employment Application"><i class="fa fa-print" style="font-size:18px"></i></a>	
							<?php //}?>
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
					table_name: 'employment_application_master',
					where_key: 'emp_app_id',
					where_val: tid
				},
				success: function (msg) {
					if (msg == 1) {
						$.ajax({
							url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
							type: "POST",
							data: {
								table_name: 'employment_application_family',
								where_key: 'emp_app_id',
								where_val: tid
							},
							success: function (msg) {
								if (msg == 1) {

									$.ajax({
										url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
										type: "POST",
										data: {
											table_name: 'employment_application_work',
											where_key: 'emp_app_id',
											where_val: tid
										},
										success: function (msg) {
											if (msg == 1) {

												$.ajax({
													url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
													type: "POST",
													data: {
														table_name: 'employment_application_education',
														where_key: 'emp_app_id',
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
								} else {
									alert("Can't Delete record. Data already exist!!!");
								}
							},
						});
						//window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
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