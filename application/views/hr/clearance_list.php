<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>CLearance CODE</th>
					<th>Emp. Name</th>
					<th>Notice Period</th>
					<th>Resignation Date</th>
					<th>Relieving Date</th>
                    <th>Overall Status</th>
                    <th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;//print_r($records);
				foreach ($records as $row) { 
                    $overall_app = '';
                    if($row->overall_approval == '0' || $row->overall_approval == ' ' || empty($row->overall_approval)) 
						$overall_app ="<span style='color:orange;'>Pending</span>";
                    else if($row->overall_approval == '1'){
						$overall_app ="<span style='color:green;'>Approved</span>";
					} 
                    

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
							<?php echo $row->clearance_code; ?>
						</td>
						<td>
							<?php echo $name; ?>
						</td>
						<td>
							<?php echo $row->notice_period_in_days; ?>
						</td>
						<td>
							<?php echo $row->resignation_date; ?>
						</td>
						<td>
							<?php echo $row->relieving_date; ?>
						</td>
                        <td>
							<?php echo $overall_app; ?>
						</td>
                        
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_clearance/'.$row->clearance_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url();?>index.php/Hr/list_clearance"
								title="Delete" onclick="return confirmcancel(<?php echo $row->clearance_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php if($row->overall_approval == 1 ){
								 if(empty($row->document_name)){?>
									<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_clearance_form/'.$row->clearance_id ; ?>"
									title="Download Clearance Form"><i class="fa fa-print" style="font-size:18px"></i></a>	
								<?php }else{?>
									<a href="<?php echo base_url() . 'public/uploded_documents/' . $row->document_name; ?>" title="Print Clearance Form" target="_blank"><i class="fa fa-print" style="font-size:18px"></i></a>
							<?php } ?>
								
							<?php }?>
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
					table_name: 'employee_clearance_master',
					where_key: 'clearance_id ',
					where_val: tid
				},
				success: function (msg) {
					if (msg == 1) {
						$.ajax({
							url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
							type: "POST",
							data: {
								table_name: 'employee_clearance_entries',
								where_key: 'clearance_id',
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