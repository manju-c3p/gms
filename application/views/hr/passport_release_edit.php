<div class="bg-white shadow rounded-lg p-6">
	<div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">
            Edit Employee Passport Release
        </h2>

        <a href="<?php echo base_url('index.php/Hr/view_passport_release_list'); ?>"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
            <i class="fa-solid fa-list"></i>
            Passport Release List
        </a>
    </div>

	<?php foreach ($record1 as $row) : ?>

		<form id="main" method="post"
			action="<?php echo base_url() . 'index.php/'; ?>Hr/update_passport_release"
			id="addform"
			autocomplete="off"
			enctype="multipart/form-data">

			<!-- Row 1 -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
					Select employees <span class="text-red-500">*</span>
				</label>

				<div class="col-span-12 md:col-span-3">

					<?php foreach ($records as $s) {
						if ($row->emp_id == $s->employee_id) { ?>

							<input type="text"
								class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
								id="employee_id"
								name="employee_id"
								value="<?php echo $s->employee_name; ?>"
								tabindex="1"
								readonly />

							<input type="hidden"
								name="employee_id_hidden"
								value="<?php echo $s->employee_id; ?>" />

					<?php }
					} ?>

				</div>


				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
					Return date
				</label>

				<div class="col-span-12 md:col-span-3">

					<div class="flex items-center gap-2">

						<input type="date"
							name="indate"
							id="indate"
							class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
							tabindex="4"
							value="<?php echo date('Y-m-d', strtotime($row->indate) ?? '') ?>"
							required>

						<!-- <div class="px-3 py-1 border border-gray-300 rounded bg-gray-100">
							<i class="fa fa-calendar"></i>
						</div> -->

					</div>

				</div>

			</div>


			<!-- Row 2 -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
					Passport Issue Date
				</label>

				<div class="col-span-12 md:col-span-3">

					<input type="date"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
						id="issue_date"
						name="issue_date"
						value="<?php echo date('Y-m-d', strtotime($row->issue_date) ?? '') ?>"
						readonly>

				</div>


				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
					Passport Expiry Date
				</label>

				<div class="col-span-12 md:col-span-3">

					<input type="date"
						name="exp_date"
						id="exp_date"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
						value="<?php echo date('Y-m-d', strtotime($row->expiry_date) ?? '') ?>"
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
						value="<?php echo $row->document_number; ?>"
						readonly>

				</div>

			</div>


			<!-- Row 4 -->
			<div class="grid grid-cols-12 gap-4 mb-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
					passport Keeping Location:
				</label>

				<div class="col-span-12 md:col-span-3">

					<select tabindex="2"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
						id="location"
						name="location">

						<option value="">Select</option>

						<option <?php if ($row->posession == 'Company') echo 'selected'; ?>
							value="Company">
							Company
						</option>

						<option <?php if ($row->posession == 'Their Own') echo 'selected'; ?>
							value="Their Own">
							Their Own
						</option>

					</select>

				</div>


				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
					passport release date
				</label>

				<div class="col-span-12 md:col-span-3">

					<div class="flex items-center gap-2">

						<input type="date"
							class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
							id="outdate"
							name="outdate"
							value="<?php echo date('Y-m-d', strtotime($row->outdate) ?? '') ?>"
							required
							tabindex="3">

						<!-- <div class="px-3 py-1 border border-gray-300 rounded bg-gray-100">
							<i class="fa fa-calendar"></i>
						</div> -->

					</div>

				</div>

			</div>


			<!-- Row 5 -->
			<div class="grid grid-cols-12 gap-4 mb-4">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">
					Passport Release Purpose
				</label>

				<div class="col-span-12 md:col-span-3">

					<textarea id="reason"
						name="reason"
						rows="3"
						placeholder="Passport Purpose"
						tabindex="5"
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm"><?php echo $row->reason; ?></textarea>

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
						class="w-full border border-gray-300 rounded px-2 py-1 text-sm"><?php echo $row->rem; ?></textarea>

				</div>

			</div>


			<!-- Submit -->
			<div class="grid grid-cols-12 gap-4 mb-4">

				<label class="col-span-12 md:col-span-2"></label>

				<div class="col-span-12 md:col-span-10">

					<input type="hidden"
						name="id"
						value="<?php echo $row->emp_docId; ?>">

					<button type="submit"
						tabindex="7"
						id="edit"
						class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">

						Submit

					</button>

				</div>

			</div>

		</form>

	<?php endforeach ?>

</div>


<script>
	function get_user_info() {
		var user_id = document.getElementById("user_id").value;
		// alert(user_id);
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
