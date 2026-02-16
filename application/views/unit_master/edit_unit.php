<div class="bg-white rounded-lg shadow p-6">
	<h2 class="text-lg font-semibold text-gray-800 mb-4">Unit Master</h2>

<form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Supplier/update_unit_data" id="addform" autocomplete="off"   enctype="multipart/form-data">

	<?php  foreach($records as $row) :?>
	

 <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
		<label class="md:col-span-2 font-medium">Unit Name <span class="text-red-500">*</span></label>
		<div class="md:col-span-4">
			<input type="text" name="uname" id="uname"
				class="w-full border rounded px-3 py-2" value="<?php echo $row->unit_name;?>" required>
		</div>

		<label class="md:col-span-2 font-medium">Unit Abbreviation <span class="text-red-500">*</span></label>
		<div class="md:col-span-4">
			<input type="text" name="uabbr" id="uabbr"
				class="w-full border rounded px-3 py-2" value="<?php echo $row->unit_abbr;?>"
				 required>
		</div>
	</div>

	
		

	<input type="hidden" name="id" value="<?php echo $row->unit_id; ?>">

	<div class="flex justify-end">
		<button type="submit"
			class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
			Update
		</button>
	</div>
<?php endforeach; ?>
	
	</form>
</div>
<script>
	$(document).ready(function() {
		var i = 1;
		$("#add_row").click(function() {
			$('#addr' + i).html("<td><input type='text' name='bname[]' id='bname' tabindex='2' class='form-control' placeholder=''  required></td><td><input type='text' name='bacc[]' id='bacc' tabindex='3' class='form-control' placeholder='' ></td><td><input type='text' name='bbranch[]' id='bbranch' tabindex='3' class='form-control' placeholder='' ></td><td><input type='text' name='biban[]' id='biban' tabindex='3' class='form-control' placeholder='' ></td><td><input type='text' name='bswift[]' id='bswift' tabindex='3' class='form-control' placeholder='' ></td><td><a onclick='remove_row(" + i + ");' id='delete_row' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
			$('#mytbbody tr:last').after('<tr id="addr' + (i + 1) + '"></tr>');
			i++;
		});
		$("#delete_row").click(function() {
			if (i > 1) {
				$("#addr" + (i - 1)).html('');
				i--;
			}
		});

		var j = 1;
		$("#add_new_row").click(function() {
			$('#new_addr' + j).html("<td><input type='text' name='image_name[]' id='image_name' class='form-control' required></td><td><input type='file' name='stamp_image[]' id='stamp_image' class='form-control' ></td><td><a onclick='remove_stamp_row(" + j + ");' id='delete_row1' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
			$('#mystamp tr:last').after('<tr id="new_addr' + (j + 1) + '"></tr>');
			j++;
		});
		$("#delete_row1").click(function() {

			if (i > 1) {
				$("#new_addr" + (j - 1)).html('');
				j--;
			}
		});
	});

	function remove_row(append_id) {
		$('#addr' + append_id).attr("id", "addr" + append_id + "x");

		$('#addr' + append_id + "x").remove();
	}

	function remove_stamp_row(append_id) {
		$('#new_addr' + append_id).attr("id", "new_addr" + append_id + "x");

		$('#new_addr' + append_id + "x").remove();
	}
</script>

<script>
	function confirmcancel(id) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'company_bank_details',
					where_key: 'bid',
					where_val: id
				},
				success: function(msg) {
					if (msg == 1) {
						alert("Record deleted");
						window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
					} else {
						alert("Can't Delete record. Data already used!!!");
					}
				},
			});
			return true;
		} else
			return false;

	}

	function confirmcancel_image(id) {
		var r = confirm("Are you sure you want to Delete Record?");

		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",

				type: "POST",
				data: {
					table_name: 'company_stamp_image',
					where_key: 'img_id',
					where_val: id
				},
				success: function(msg) {
					if (msg == 1) {

						alert("Record deleted");

						window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
					} else {
						alert("Can't Delete record. Data already used!!!");
					}
				},
			});
			return true;

		} else
			return false;

	}
</script>
