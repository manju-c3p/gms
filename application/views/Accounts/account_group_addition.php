<div class="p-6 max-w-4xl">

	<div class="bg-white rounded-xl shadow-sm border border-gray-200">

		<!-- Header -->
		<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
			<h2 class="text-lg font-semibold text-gray-800">
				Add Account Group
			</h2>

			<a href="<?= base_url('index.php/Accounts/account_group_list') ?>"
				class="px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200">
				List Records
			</a>
		</div>

		<!-- Form -->
		<form method="post"
			action="<?= base_url('index.php/Accounts/add_account_group_records'); ?>"
			id="account"
			class="p-6 space-y-6">

			<!-- Account Group Name -->
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">
					Account Group Name <span class="text-red-500">*</span>
				</label>
				<input type="text"
					name="ac_group"
					id="ac_group"
					placeholder="Account Group Name"
					class="w-full rounded-lg border border-gray-300 px-4 py-2
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
			</div>

			<!-- Parent Group -->
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">
					Parent Group <span class="text-red-500">*</span>
				</label>
				<select name="p_group"
					id="p_group"
					class="w-full rounded-lg border border-gray-300 px-4 py-2
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
					<option value="0">Self</option>
					<?php foreach ($parent_records as $row): ?>
						<option value="<?= $row->group_no; ?>">
							<?= $row->group_name; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Section in Accounts -->
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">
					Section In Accounts
				</label>
				<select name="sec_in_account"
					id="sec_in_account"
					class="w-full rounded-lg border border-gray-300 px-4 py-2
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
					<option value="">Select</option>
					<?php foreach ($section_records as $row): ?>
						<option value="<?= $row->group_no; ?>">
							<?= $row->group_name; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Actions -->
			<div class="flex items-center gap-4 pt-4 border-t border-gray-200">
				<button type="submit"
					name="add"
					class="px-6 py-2 bg-green-600 text-white rounded-lg
                               hover:bg-green-700 transition">
					Submit
				</button>

				<a target="_blank"
					href="<?= base_url('index.php/Accounts/view_general_ledger_account_form'); ?>"
					class="px-6 py-2 bg-indigo-100 text-indigo-700 rounded-lg
                          hover:bg-indigo-200 transition">
					Create Ledger Account
				</a>

				<button type="reset"
					class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg
                               hover:bg-gray-200 transition">
					Reset
				</button>
			</div>

		</form>
	</div>
</div>




<script>
	$("#p_group").change(function() {
		var p_group = document.getElementById('p_group').value;
		$.ajax({
			'type': "POST",
			'url': "<?php echo base_url() ?>index.php/Ajax/get_parent_account_group",
			'data': {
				group_no: p_group
			},
			'success': function(msg) {
				$('#sec_in_account').val(msg);
			}
		});
	});


	$('#account').validate({
		rules: {
			ac_group: {
				required: true
			},
			p_group: {
				required: true
			}
		},
		messages: {
			ac_group: {
				required: "Please enter Account group"
			},
			p_group: {
				required: "Please select Parent group"
			}
		},
		errorElement: 'p',
		errorClass: 'text-red-600 text-sm mt-1',
		highlight: function(element) {
			$(element).addClass('border-red-500');
		},
		unhighlight: function(element) {
			$(element).removeClass('border-red-500');
		}
	});
</script>
