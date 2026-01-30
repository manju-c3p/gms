<div class="card-body">
		<div class="dt-responsive table-responsive">
			<table id="datatable" class="table table-striped" data-toggle="data-table">
                                        <thead>
                                            <tr>
						<th>Sr.no</th>
						<th>Trans Code</th>
						<th>Date</th>
						<th>Amount</th>
						<th>Narration</th>
						<th>Action</th>
					   </tr>
					</thead>

					<tbody>
					<?php $i=1; foreach($credit_note as $row) :?>
						<tr <?php if($row->cancel==1){ echo "class='bg-soft-danger'"; } ?> >
							<td><?php echo $i;$i++;?></td>
							<td>
								<a target='_blank' href="<?php echo base_url().'index.php/Accounts/view_account_transaction_details/'.$row->voucher_id;?>" title="details">
								<?php echo $row->voucher_code;?>
								</a>
							</td>
							<td>
								<?php echo date('d-M-Y',strtotime($row->voucher_date));?><br>
								
							</td>
							<td>
								<?php echo $row->amount;?>
							</td>
							<td>
								<?php echo $row->narration;?>
							</td>
							<td>
							<?php if($row->cancel==0){?>
							<a href="javascript:confirmcancel('<?php echo $row->voucher_code;?>')" title="Delete" class='delete' id='delete'><?php echo $this->session->userdata('delete_icon');?></a>
							<?php } else echo 'Cancelled'; ?>
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

function confirmcancel(voucher_code)
{   
	var r= confirm("Are you sure you want to Cancel Record?");
	if(r == true) 
        {
      		$.ajax({
     		url: "<?php echo base_url()?>index.php/Accounts/delete_trans_entry",
     		type: "POST",
     		data: {voucher_code:voucher_code} ,
     		success: function(msg) {
     			if(msg==1) 
     			{     	
			         alert("Record Cancelled"); 				
        			 window.location.href="<?php echo $_SERVER['PHP_SELF']?>";   		                    		  
			}
		        else {
			      	alert("Can't Cancel record. Data already exist!!!");
		       }
		    },
		});
      		return true;
      	}
        else
        	return false;
	    	
}
</script>
