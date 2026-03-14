<div class="bg-white shadow rounded-lg p-6">
	  <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">
            Employee Passport Release
        </h2>

        <a href="<?php echo base_url('index.php/Hr/view_passport_release_list'); ?>"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
            <i class="fa-solid fa-list"></i>
            Passport Release List
        </a>
    </div>

	<form onsubmit="return check_selected_age();" id="main" method="post"
		action="<?php echo base_url() . 'index.php/'; ?>Hr/add_emp_passport_release"
		autocomplete="off"
		enctype="multipart/form-data">

		<!-- Row 1 -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Select employees <span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">
				<select tabindex="1"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2"
					id="user_id"
					name="user_id"
					required
					onchange="get_user_info()">

					<option value="">Select</option>

					<?php foreach ($records as $s) { ?>
						<option value="<?php echo $s->id ?>">
							<?php echo $s->username; ?>
						</option>
					<?php } ?>

				</select>
			</div>


			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Return date <span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<div class="flex items-center gap-2">

					<input type="text"
						name="indate"
						id="indate"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
						tabindex="4"
						value="<?php echo date('d-m-Y') ?>"
						required>

					<div class="px-3 py-1 border border-gray-300 rounded bg-gray-100">
						<i class="fa fa-calendar"></i>
					</div>

				</div>

			</div>

		</div>


		<!-- Row 2 -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Passport Issue Date
			</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
					id="issue_date"
					name="issue_date"
					value="<?php echo date('d-m-Y') ?>"
					readonly>

			</div>


			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Passport Expiry Date
			</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					name="exp_date"
					id="exp_date"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
					value="<?php echo date('d-m-Y') ?>"
					readonly>

			</div>

		</div>


		<!-- Row 3 -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Employee Number:
			</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
					id="user_code"
					name="user_code"
					value=""
					readonly>

			</div>


			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Passport No:
			</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					name="doc_no"
					id="doc_no"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
					value=""
					readonly>

			</div>

		</div>


		<!-- Row 4 -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				passport Keeping Location:<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<select tabindex="2"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
					id="location"
					name="location"
					required>

					<option value="">select</option>
					<option value="Company">Company</option>
					<option value="Their Own">Their Own</option>

				</select>

			</div>


			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				passport release date<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<div class="flex items-center gap-2">

					<input type="text"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
						id="outdate"
						name="outdate"
						value="<?php echo date('d-m-Y') ?>"
						required
						tabindex="3">

					<div class="px-3 py-1 border border-gray-300 rounded bg-gray-100">
						<i class="fa fa-calendar"></i>
					</div>

				</div>

			</div>

		</div>


		<!-- Row 5 -->
		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Passport Release Purpose<span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">

				<textarea id="reason"
					name="reason"
					tabindex="5"
					rows="3"
					placeholder="Passport Purpose"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
					required></textarea>

			</div>


			<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
				Remark
			</label>

			<div class="col-span-12 md:col-span-3">

				<textarea id="remark"
					name="remark"
					rows="3"
					placeholder="remark"
					tabindex="6"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm"></textarea>

			</div>

		</div>


		<!-- Submit -->
		<div class="grid grid-cols-12 gap-4 mb-4">

			<label class="col-span-12 md:col-span-2"></label>

			<div class="col-span-12 md:col-span-10">

				<button type="submit"
					tabindex="7"
					id="add"
					class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">

					Submit

				</button>

			</div>

		</div>


	</form>

</div>


<!-- <script type-"text/javascript">
    function get_user_info() {
        alert(data);
    }
    </script> -->
<script>
	function get_user_info() {
		var user_id = document.getElementById("user_id").value;
		//  alert(user_id);
		if (user_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_user_info",
				data: {
					user_id: user_id
				},
				dataType: "json",
				success: function(msg) {


					document.getElementById("issue_date").value = msg.issue_date;
					document.getElementById("exp_date").value = msg.expiry_date;
					document.getElementById("doc_no").value = msg.document_number;
					document.getElementById("location").value = msg.posession;

				}
			});
		} else {
			document.getElementById("issue_date").value = '';
			document.getElementById("exp_date").value = '';
			document.getElementById("doc_no").value = '';
			document.getElementById("location").value = '';


		}
	}
</script>
