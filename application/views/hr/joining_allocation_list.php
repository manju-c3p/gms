<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>Joining Code</th>
					<th>Employee Name</th>
					<th>Joining Type</th>
					<th>Joining Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;
				foreach ($records as $row) { ?>
					<tr>
						<td><?php echo $i;
							$i++; ?></td>
						<td><?php echo $row->joining_code; ?></td>
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->joining_type; ?></td>
						<td><?php echo date('d-M-Y', strtotime($row->joining_date)); ?></td>

						<td>
							<a href="<?php echo base_url() . 'index.php/Hr/edit_joining_application/' . $row->jid; ?>" title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo base_url() . 'index.php/Hr/delete_joining_application/' . $row->jid; ?>" title="Delete" onclick="return confirmcancel(<?php echo $row->jid; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							<a href="<?php echo base_url() . 'index.php/Hr/print_joining_application/' . $row->jid; ?>" title="Print" target="_blank"><i class="fa fa-print" style="font-size:18px"></i></a>

							<!-- <a href="javascript:confirmcancel(<?php echo $row->jid; ?>)" title="Delete" class='delete' id='delete'><?php echo $this->session->userdata('delete_icon'); ?></a> -->

						</td>
					</tr>
				<?php  } ?>
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
					table_name: 'employee_joining',
					where_key: 'jid',
					where_val: tid
				},
				success: function(msg) {
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