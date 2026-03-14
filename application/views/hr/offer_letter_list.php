<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>Offer CODE</th>
					<th>Emp. Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;//print_r($records);
				foreach ($records as $row) { 

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
							<?php echo $row->offer_code; ?>
						</td>
						<td>
							<?php echo $name; ?>
						</td>
                        
						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_offer_letter/'.$row->offer_id ; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url() . 'index.php/Hr/list_offer_letter' ; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->offer_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a target='_blank' href="<?php echo base_url() . 'index.php/Hr/print_offer_letter/'.$row->offer_id ; ?>"
							title="Download Offer Letter"><i class="fa fa-print" style="font-size:18px"></i></a>	
								
								
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
					table_name: 'employee_offer_letter',
					where_key: 'offer_id ',
					where_val: tid
				},
				success: function (msg) {
					if (msg == 1) {
						$.ajax({
							url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
							type: "POST",
							data: {
								table_name: 'employee_offer_salary',
								where_key: 'offer_id',
								where_val: tid
							},
							success: function (msg) {
								if (msg == 1) {
									$.ajax({
										url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
										type: "POST",
										data: {
											table_name: 'employee_offer_incentive',
											where_key: 'offer_id',
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