<div class="bg-white rounded-lg shadow p-6">
	<h2 class="text-lg font-semibold text-gray-800 mb-4">Company Details</h2>

	<form id="main" method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Admin/add_company_records"
		id="addform" autocomplete="off" enctype="multipart/form-data">

		<?php foreach ($company_details as $row) { ?>

			<!-- Name -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
				<label class="md:col-span-2 font-medium">Name <span class="text-red-500">*</span></label>
				<div class="md:col-span-5">
					<input type="text" name="company_name" id="company_name"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_name; ?>" required>
				</div>
			</div>

			<!-- Address / City -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
				<label class="md:col-span-2 font-medium">Address <span class="text-red-500">*</span></label>
				<div class="md:col-span-4">
					<input type="text" name="company_address" id="company_address"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_address; ?>" required>
				</div>

				<label class="md:col-span-2 font-medium">City <span class="text-red-500">*</span></label>
				<div class="md:col-span-4">
					<input type="text" name="company_city" id="company_city"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_city; ?>" required>
				</div>
			</div>

			<!-- PO Box / Country -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
				<label class="md:col-span-2 font-medium">PO Box <span class="text-red-500"></span></label>
				<div class="md:col-span-4">
					<input type="text" name="company_pincode" id="company_pincode"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_pincode; ?>">
				</div>

				<label class="md:col-span-2 font-medium">Country <span class="text-red-500">*</span></label>
				<div class="md:col-span-4">
					<input type="text" name="company_country" id="company_country"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_country; ?>" required>
				</div>
			</div>

			<!-- Email / Telephone -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-4 items-center">
				<label class="md:col-span-2 font-medium">Email</label>
				<div class="md:col-span-4">
					<input type="text" name="company_email_id" id="company_email_id"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_email_id; ?>">
				</div>

				<label class="md:col-span-2 font-medium">Telephone</label>
				<div class="md:col-span-4">
					<input type="text" name="company_telephone" id="company_telephone"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_telephone; ?>">
				</div>
			</div>

			<!-- TRN / Website -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6 items-center">
				<label class="md:col-span-2 font-medium">TRN No</label>
				<div class="md:col-span-4">
					<input type="text" name="company_trn" id="company_trn"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_TRN; ?>">
				</div>

				<label class="md:col-span-2 font-medium">Website</label>
				<div class="md:col-span-4">
					<input type="text" name="website" id="website"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->company_website; ?>">
				</div>
			</div>
			<!-- corporate tax -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-6 items-center">
				<label class="md:col-span-2 font-medium">Corporate Tax Percentage</label>
				<div class="md:col-span-2">
					<input type="text" name="corporate_tax" id="corporate_tax"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->corporate_tax_per; ?>">
				</div>

				<label class="md:col-span-2 font-medium">Threshold Value</label>
				<div class="md:col-span-2">
					<input type="text" name="threshold" id="threshold"
						class="w-full border rounded px-3 py-2"
						value="<?php echo $row->threshold_value; ?>">
				</div>

				<label class="md:col-span-1 font-medium">Excemption</label>
				<div class="md:col-span-1">
					<input type="hidden" name="excemption" value="0">

					<input type="checkbox"
						name="excemption"
						id="excemption"
						value="1"
						class="w-full border rounded px-3 py-2"
						<?php echo (isset($row->excemptions) && $row->excemptions == 1) ? 'checked' : ''; ?>>
				</div>
			</div>

			<!-- BANK TABLE (structure untouched) -->
			<div class="overflow-x-auto mb-6">
				<table class="w-full border border-gray-300 text-sm" id="tab_logic">
					<thead class="bg-gray-100">
						<tr>
							<th class="border px-2 py-2">Bank Name</th>
							<th class="border px-2 py-2">Account</th>
							<th class="border px-2 py-2">Branch</th>
							<th class="border px-2 py-2">IBAN</th>
							<th class="border px-2 py-2">SWIFT</th>
							<th class="border px-2 py-2">
								<a id="add_row"
									class="bg-orange-500 text-white px-2 py-1 rounded text-xs cursor-pointer">
									+
								</a>
							</th>
						</tr>
					</thead>
					<tbody id="mytbbody">
						<?php foreach ($bank_details as $r) { ?>
							<tr class="text-[13px]">
								<td class="border px-2 py-1">
									<input type="text" name="bname_old[]" id="bname" tabindex="2"
										class="w-full border rounded px-2 py-1 text-sm"
										value="<?php echo $r->bank_name; ?>" >
								</td>
								<td class="border px-2 py-1">
									<input type="text" name="bacc_old[]" id="bacc" tabindex="3"
										class="w-full border rounded px-2 py-1 text-sm"
										value="<?php echo $r->bank_account; ?>">
								</td>
								<td class="border px-2 py-1">
									<input type="text" name="bbranch_old[]" id="bbranch" tabindex="3"
										class="w-full border rounded px-2 py-1 text-sm"
										value="<?php echo $r->bank_branch; ?>">
								</td>
								<td class="border px-2 py-1">
									<input type="text" name="biban_old[]" id="biban" tabindex="3"
										class="w-full border rounded px-2 py-1 text-sm"
										value="<?php echo $r->bank_iban; ?>">
								</td>
								<td class="border px-2 py-1">
									<input type="text" name="bswift_old[]" id="bswift" tabindex="3"
										class="w-full border rounded px-2 py-1 text-sm"
										value="<?php echo $r->bank_swift; ?>">
								</td>
								<td class="border px-2 py-1 text-center">
									<input type="hidden" name="trans_id[]" value="<?php echo $r->bid; ?>">
									<a href="javascript:confirmcancel(<?php echo $r->bid; ?>)"
										class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
										🗑
									</a>
								</td>
							</tr>
						<?php } ?>

						<tr id="addr0" class="text-[13px]">
							<td class="border px-2 py-1">
								<input type="text" name="bname[]" id="bname"
									class="w-full border rounded px-2 py-1 text-sm">
							</td>
							<td class="border px-2 py-1">
								<input type="text" name="bacc[]" id="bacc"
									class="w-full border rounded px-2 py-1 text-sm">
							</td>
							<td class="border px-2 py-1">
								<input type="text" name="bbranch[]" id="bbranch"
									class="w-full border rounded px-2 py-1 text-sm">
							</td>
							<td class="border px-2 py-1">
								<input type="text" name="biban[]" id="biban"
									class="w-full border rounded px-2 py-1 text-sm">
							</td>
							<td class="border px-2 py-1">
								<input type="text" name="bswift[]" id="bswift"
									class="w-full border rounded px-2 py-1 text-sm">
							</td>
							<td class="border px-2 py-1 text-center">
								<a id="delete_row" onclick="remove_row(0)"
									class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs cursor-pointer">
									🗑
								</a>
							</td>
						</tr>
						<tr id="addr1"></tr>
					</tbody>

				</table>
			</div>

			<!-- STAMP TABLE -->
			<div class="overflow-x-auto mb-6">
				<table class="w-full border border-gray-300 text-sm" id="tab_stamp">
					<thead class="bg-gray-100">
						<tr>
							<th class="border px-2 py-2">Name</th>
							<th class="border px-2 py-2">Upload Stamp</th>
							<th class="border px-2 py-2">
								<a id="add_new_row"
									class="bg-orange-500 text-white px-2 py-1 rounded text-xs cursor-pointer">
									+
								</a>
							</th>
						</tr>
					</thead>
					<tbody id="mystamp">
						<?php foreach ($stamp_details as $r) { ?>
							<tr class="text-[13px]">
								<td class="border px-2 py-1">
									<input type="text" name="image_name_old[]"
										class="w-full border rounded px-2 py-1 text-sm"
										value="<?php echo $r->stamp_name; ?>" >
								</td>
								<td class="border px-2 py-1 text-center">
									<?php
									$binary = base64_decode(str_replace(" ", "+", $r->stamp_image));
									?>
									<img class="mx-auto h-24 w-24 object-contain"
										src="<?php if ($binary != '') echo 'data:;base64,' . base64_encode($binary); ?>">
								</td>
								<td class="border px-2 py-1 text-center">
									<input type="hidden" name="img_id[]" value="<?php echo $r->img_id; ?>">
									<a href="javascript:confirmcancel_image(<?php echo $r->img_id; ?>)"
										class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
										🗑
									</a>
								</td>
							</tr>
						<?php } ?>

						<tr id="new_addr0" class="text-[13px]">
							<td class="border px-2 py-1">
								<input type="text" name="image_name[]" id="image_name"
									class="w-full border rounded px-2 py-1 text-sm" >
							</td>
							<td class="border px-2 py-1">
								<input type="file" name="stamp_image[]"
									class="w-full border rounded px-2 py-1 text-sm">
							</td>
							<td class="border px-2 py-1 text-center">
								<a id="delete_row1" onclick="remove_stamp_row(0)"
									class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs cursor-pointer">
									🗑
								</a>
							</td>
						</tr>
						<tr id="new_addr1"></tr>
					</tbody>

				</table>
			</div>

			<!-- SUBMIT -->
			<div class="flex justify-end">
				<input type="hidden" name="company_id" value="<?php echo $row->company_id; ?>">
				<button type="submit"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
					Submit
				</button>
			</div>

		<?php } ?>
	</form>
</div>



<script>
	$(document).ready(function() {
		var i = 1;
		$("#add_row").click(function() {
			$('#addr' + i).html("<td><input type='text' name='bname[]' id='bname' tabindex='2' class='form-control' placeholder=''  ></td><td><input type='text' name='bacc[]' id='bacc' tabindex='3' class='form-control' placeholder='' ></td><td><input type='text' name='bbranch[]' id='bbranch' tabindex='3' class='form-control' placeholder='' ></td><td><input type='text' name='biban[]' id='biban' tabindex='3' class='form-control' placeholder='' ></td><td><input type='text' name='bswift[]' id='bswift' tabindex='3' class='form-control' placeholder='' ></td><td><a onclick='remove_row(" + i + ");' id='delete_row' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
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
			$('#new_addr' + j).html("<td><input type='text' name='image_name[]' id='image_name' class='form-control' ></td><td><input type='file' name='stamp_image[]' id='stamp_image' class='form-control' ></td><td><a onclick='remove_stamp_row(" + j + ");' id='delete_row1' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
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
