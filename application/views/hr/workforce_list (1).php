<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>Requisition Code</th>
					<th>Position</th>
					<th>Department</th>
                    <th>Required Date</th>
					<th>Vacancy</th>
					<th>Requested BY</th>
					<th>HR Approval</th>
                    <th>CEO Approval</th>
                    <th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($records as $row) { 
                    
                    if($row->hr_approval == '0') 
                        $hr_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->hr_approval == '1') 
                        $hr_approval ="<span style='color:green;'>Approved</span>";
                    else if($row->hr_approval == '2') 
                        $hr_approval ="<span style='color:red;'>Not Approved</span>";
                    else
                        $hr_approval =" ";
                    
                    if($row->ceo_approval == '0') 
                        $ceo_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->ceo_approval == '1') 
                        $ceo_approval ="<span style='color:green;'>Approved</span>";
                    else if($row->ceo_approval == '2') 
                        $ceo_approval ="<span style='color:red;'>Not Approved</span>";
                    else
                        $ceo_approval =" ";?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						<td>
							<?php echo $row->emp_req_code; ?>
						</td>
						<td>
							<?php echo $row->designation_name; ?>
						</td>
						<td>
							<?php echo $row->dept_name; ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->required_date)); ?>
						</td>
					
						<td>
							<?php echo $row->vacancy_no; ?>
						</td>
                        <td>
							<?php echo $row->user_name; ?>
						</td>
                        <td>
							<?php echo $hr_approval; ?>
						</td>
                        <td>
							<?php echo $ceo_approval; ?>
						</td>
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_workforce_requisition/'.$row->emp_req_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>
							<a href="<?php echo base_url() . 'index.php/Hr/delete_workforce_requisition/'.$row->emp_req_id ; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->emp_req_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>
							<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_job_desc/'.$row->emp_req_id ; ?>"
								title="Download Job Description"><i class="fa fa-print" style="font-size:18px"></i></a>	

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
					table_name: 'employee_requisition',
					where_key: 'emp_req_id',
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
			return true;
		} else
			return false;

	}
</script>