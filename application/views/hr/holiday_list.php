<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>Holidy Code</th>
					<th>Holiday Name</th>
					<th>Holiday Date:</th>

					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($records as $row) { ?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>
						<td>
							<?php echo $row->holiday_code; ?>
						</td>
						<td>
							<?php echo $row->holiday_name; ?>
						</td>
						<td>
							<?php echo date('d-M-Y', strtotime($row->h_date)); ?>
						</td>



						<td>

							<a href="<?php echo base_url() . 'index.php/Hr/edit_holiday_data/' . $row->holiday_id; ?>"
								title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url() . 'index.php/Hr/delete_holiday_data/' . $row->holiday_id; ?>"
								title="Delete" onclick="return confirmcancel(<?php echo $row->holiday_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>


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
					table_name: 'holiday_master',
					where_key: 'holiday_id',
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