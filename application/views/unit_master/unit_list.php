<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="w-full bg-white rounded-xl shadow p-6">

	<div class="flex justify-between items-center mb-4">
		<h2 class="text-2xl font-bold">Supplier List</h2>

		<a href="<?= base_url('index.php/Supplier/add_unit'); ?>"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ Add Units
		</a>
	</div>


	<div class="overflow-x-auto">
		<table id="serviceTable" class="display w-full border">
			<thead>
				<tr>
					<th>#</th>					
	                <th>Unit Name</th>
					<th>Abbrivation</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
			
				<?php 
				
				foreach ($units as $i => $row) { ?>
					<tr>
						<td><?= $i + 1 ?></td>
						<td><?php echo  $row->unit_name;?></td>
						<td><?php echo  $row->unit_abbr;?></td>
						<td>
							<div class="flex space-x-3">
  <a href="<?= base_url('index.php/Supplier/edit_unit/' . $row->unit_id) ?>"
     class="px-2 py-1 bg-blue-600 text-white rounded text-sm">
     Edit
  </a>

  <a href="javascript:confirmcancel(<?php echo $row->unit_id;?>)" 
     title="Delete" class="delete text-red-600" id="delete">
     <i class="fa fa-trash"></i>
  </a>
</div>

						</td>
					</tr>
				<?php } ?>
			</tbody>

		</table>
	</div>
</div>

<!-- ✅ Add Service Modal -->
<div id="addModal" class="modal-backdrop-custom">
	<div class="modal-box-custom">

		<h3 class="text-xl font-bold mb-4">Add Service</h3>

		<form method="post" action="<?= base_url('index.php/
		ServiceMaster/store') ?>">

			<input type="text" name="service_name"
				class="w-full border p-2 mb-3"
				placeholder="Service Name" required>

			<!-- Service Type -->
			<select name="service_type"
				class="w-full border p-2 mb-3" required>
				<option value="">-- Select Service Type --</option>
				<option value="SERVICE">Service</option>
				<option value="LABOUR">Labour</option>
				<option value="OTHER">Other</option>
			</select>

			<input type="number" step="0.01" name="estimated_cost"
				class="w-full border p-2 mb-3"
				placeholder="Estimated Cost">

			<input type="number" name="estimated_time"
				class="w-full border p-2 mb-3"
				placeholder="Estimated Time (Minutes)">

			<select name="status" class="w-full border p-2 mb-4">
				<option value="Active">Active</option>
				<option value="Inactive">Inactive</option>
			</select>

			<div class="flex justify-end gap-2">
				<button type="button" onclick="closeModal()"
					class="px-4 py-2 bg-gray-400 text-white rounded">
					Cancel
				</button>

				<button type="submit"
					class="px-4 py-2 bg-green-600 text-white rounded">
					Save
				</button>
			</div>

		</form>
	</div>
</div>
<style>
	/* ✅ Modal Background */
	.modal-backdrop-custom {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.4);
		display: none;
		align-items: center;
		justify-content: center;
		z-index: 9999;
	}

	/* ✅ Modal Box */
	.modal-box-custom {
		background: #fff;
		width: 400px;
		padding: 24px;
		border-radius: 8px;
		box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
	}
</style>
<script>
	function openModal() {
		document.getElementById('addModal').style.display = 'flex';
	}

	function closeModal() {
		document.getElementById('addModal').style.display = 'none';
	}

    function confirmcancel(id)
{   
	var r= confirm("Are you sure you want to Delete Record?");
	if(r == true) 
        {
      		$.ajax({
     		url: "<?php echo base_url()?>index.php/Ajax/delete_record",
     		type: "POST",
     		data: {table_name:'unit_master', where_key:'unit_id', where_val:id} ,
     		success: function(msg) {
     			if(msg==1) 
     			{     	
			         alert("Record deleted"); 				
        			 window.location.href="<?php echo base_url('index.php/Supplier/view_unit_list');?>";   		                    		  
			}
		        else {
			      	alert("Can't Delete record. Data already exist!!!");
		       }
		    },
		});
      		return true;
      	}
        else
        	return false;
	    	
}
</script>
<script>
	$(document).ready(function() {
		$('#serviceTable').DataTable({
			pageLength: 10,
			lengthMenu: [10, 25, 50, 100],
			ordering: true,
			searching: true,
			responsive: true
		});
	});
</script>
