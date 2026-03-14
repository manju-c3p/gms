<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>COMP CODE</th>
					<th>Application Date</th>
					<th>Employee Name</th>
                    <th>Total Pending Hours</th>
					<th>HR Approval</th>
                    <th>HOD Approval</th>
                    <th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;//print_r($records);
				foreach ($records as $row) { 
                    $hr_app = 0;$hod_app = 0; $hr_approval =" ";$dept_hod_approval =" ";
                    if($row->hr_approved == '0' || $row->hr_approved == ' ' || empty($row->hr_approved)) 
						$hr_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->hr_approved == '1'){
						$hr_approval ="<span style='color:green;'>Approved</span>";
						$hr_app = 1;
					} 
                    else if($row->hr_approved == '2') 
                        $hr_approval ="<span style='color:red;'>Not Approved</span>";
                    
                    if($row->hod_approved == '0' || $row->hod_approved == ' ' || empty($row->hod_approved)) 
                        $dept_hod_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->hod_approved == '1'){
						$dept_hod_approval ="<span style='color:green;'>Approved</span>";
						$hod_app = 1;
					} 
                    else if($row->hod_approved == '2') 
                        $dept_hod_approval ="<span style='color:red;'>Not Approved</span>";

                    if(!empty($row->user_name) && !empty($row->middle_name) && !empty($row->last_name))
						$name = $row->user_name.' '.$row->middle_name.' '.$row->last_name;
					else if(!empty($row->user_name) && !empty($row->middle_name))
						$name = $row->user_name.' '.$row->middle_name;
					else
						$name = $row->user_name;?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						<td>
							<?php echo $row->comp_code; ?>
						</td>
						<td>
							<?php echo $row->request_date; ?>
						</td>
						<td>
							<?php echo $name; ?>
						</td>
						<td>
							<?php echo $row->total_pending_comp_off; ?>
						</td>
						
                        <td>
							<?php echo $hr_approval; ?>
						</td>
                        <td>
							<?php echo $dept_hod_approval; ?>
						</td>
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_compensatory/'.$row->id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>
							<a href="<?php echo base_url() . 'index.php/Hr/delete_compensatory/'.$row->id ; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>
							<?php /*if($hod_app == 1 && $hr_app == 1){?>
								<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_offerletter/'.$row->int_id ; ?>"
									title="Download Job Description"><i class="fa fa-print" style="font-size:18px"></i></a>	
							<?php }*/?>
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
					table_name: 'employee_compensation_master',
					where_key: 'id',
					where_val: tid
				},
				success: function (msg) {
					if (msg == 1) {
						$.ajax({
							url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
							type: "POST",
							data: {
								table_name: 'employee_compensation_entries',
								where_key: 'compensation_id',
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