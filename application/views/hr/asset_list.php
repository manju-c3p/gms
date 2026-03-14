<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>SR No</th>
					<th>User Name</th>
					<th>Department</th>
					<th>Position</th>
					<th>SIM Issue Date</th>
                    <th>SIM Return Date</th>
					<th>Laptop Issue Date</th>
                    <th>Laptop Return Date</th>
					<th>Mobile Issue Date</th>
                    <th>Mobile Return Date</th>
					<th>Vehicle Issue Date</th>
                    <th>Vehicle Return Date</th>
					<th>Other Issue Date</th>
                    <th>Other Return Date</th>
                    <th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($records as $row) { 
                    
                    ?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						
						<td>
							<?php echo $row->user_name.' '.$row->middle_name.' '.$row->last_name; ?>
						</td>
						<td>
							<?php echo $row->dept_name; ?>
						</td>
						<td>
							<?php echo $row->designation_name; ?>
						</td>
						
						<td>
							<?php echo date('d-M-Y', strtotime($row->sim_issued)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->sim_return)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->laptop_issued)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->laptop_return)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->mobile_issued)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->mobile_return)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->vehicle_issued)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->vehicle_return)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->other_issued)); ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->other_return)); ?>
						</td>
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_asset/'.$row->asset_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <a href="<?php echo base_url() . 'index.php/Hr/delete_workforce_requisition/'.$row->emp_req_id ; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->emp_req_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a> -->
							<?php if(empty($row->asset_doc_path)){?>
								<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_asset_form/'.$row->asset_id ; ?>"
								title="Download Asset Form"><i class="fa fa-print" style="font-size:18px"></i></a>	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php }else{?>
								<a href="<?php echo base_url() . 'public/uploded_documents/' . $row->asset_doc_path; ?>" title="Print Asset Form" target="_blank"><i class="fa fa-print" style="font-size:18px"></i></a>
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