<div class="card-body">
		<div class="dt-responsive table-responsive">
			<table id="datatable" class="table table-striped" data-toggle="data-table">
                                        <thead>
                                            <tr>
							<th>Sr.no</th>
                            <th>Instrument Number</th>
							<th>Instrument Date</th>
							<th>Amount Number</th>
							<th>Type</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
					<?php $i=1; foreach($records as $row) :?>
						<tr>
							<td><?php echo $i;$i++;?></td>
                            <td><?php echo $row->instrument_no; ?></td>

							<td><?php echo date('d-M-Y',strtotime($row->instrument_date));?></td>
							<td><?php echo $row->amount_no; ?></td>
							<td><?php echo $row->instrument_type; ?></td>							
							<td>
                            <a href="<?php echo base_url() . 'index.php/Accounts/edit_bank_reconciliation/' . $row->reconciliation_id; ?>" title="Edit"><?php echo $this->session->userdata('edit_icon'); ?></a>
							<a href="javascript:confirmcancel(<?php echo $row->reconciliation_id;?>)" title="Delete" class='delete' id='delete'><?php echo $this->session->userdata('delete_icon');?></a>

                        </td>
						</tr>
					<?php endforeach; ?>
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
                    table_name: 'bank_reconciliation',
                    where_key: 'reconciliation_id',
                    where_val: tid
                },
                success: function(msg) {
                    if (msg == 1) {
                        // alert("Record deleted");
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