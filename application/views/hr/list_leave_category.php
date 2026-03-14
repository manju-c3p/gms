<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Category Name</th>
					<th>Leave Days</th>
					<th>Remark</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($category as $row) :?>
				<tr>
					<td><?php echo  $row->category_name;?></td>
					<td><?php echo  $row->leave_days;?></td>
					<td><?php echo  $row->remark;?></td>
					<td>
						<a href="<?php echo base_url().'index.php/Hr/edit_leave_category/'.$row->leave_cat_id;?>" title="Edit"><?php echo $this->session->userdata('edit_icon');?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:confirmcancel(<?php echo $row->leave_cat_id;?>)" title="Delete" class='delete' id='delete'><?php echo $this->session->userdata('delete_icon');?></a>
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

    
<script>
function confirmcancel(id)
{   
	var r= confirm("Are you sure you want to Delete Record?");
	if(r == true) 
        {
      		$.ajax({
     		url: "<?php echo base_url()?>index.php/Ajax/delete_record",
     		type: "POST",
     		data: {table_name:'leave_category', where_key:'leave_cat_id', where_val:id} ,
     		success: function(msg) {
     			if(msg==1) 
     			{     	
			         alert("Record deleted"); 				
        			 window.location.href="<?php echo $_SERVER['PHP_SELF']?>";   		                    		  
			}
		        else {
			      	alert("Can't Delete record. Data already exist!!!");
		       }
		    },
		    error: function (error) {
			   alert("Can't Delete record. Data already exist!!!");
			}
		});
      		return true;
      	}
        else
        	return false;
	    	
}
</script>
