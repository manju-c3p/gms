<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>HandOver CODE</th>
					<th>HandOver Date</th>
					<th>Driver Name</th>
					<th>VehicleName</th>
                    <th>Number Plate</th>
                    <th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;//print_r($records);
				foreach ($records as $row) { 
					$hr_app = 0;$hr_approval =" ";
                    if($row->approval_status == '0' || $row->approval_status == ' ' || empty($row->approval_status)) 
						$hr_approval ="<span style='color:orange;'>Pending</span>";
                    else if($row->approval_status == '1'){
						$hr_approval ="<span style='color:green;'>Approved</span>";
						$hr_app = 1;
					} 
                    else if($row->approval_status == '2') 
                        $hr_approval ="<span style='color:red;'>Not Approved</span>";
                    
                    ?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						<td>
							<?php echo $row->veh_hndovr_code; ?>
						</td>
						<td>
							<?php echo $row->handover_date; ?>
						</td>
						<td>
							<?php echo $row->user_name.' '.$row->middle_name.' '.$row->last_name; ?>
						</td>
						<td>
							<?php echo $row->vehicle_model; ?>
						</td>
						
                        <td>
							<?php echo $row->licence_plate; ?>
						</td>
                        <td>
							<?php echo $hr_approval; ?>
						</td>
						
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_vehicle_handover/'.$row->veh_hndovr_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url() . 'index.php/Hr/list_vehicle_handover' ; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->veh_hndovr_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<?php if($hr_app == 1){?>
								<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_vehicle_handover/'.$row->veh_hndovr_id ; ?>"
									title="Download Vehicle Handover"><i class="fa fa-print" style="font-size:18px"></i></a>	
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
					table_name: 'employee_vehicle_handover',
					where_key: 'veh_hndovr_id',
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