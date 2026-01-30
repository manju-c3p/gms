<?php
foreach ($gen_ledger_records as $row) {
	$account_id = $row->account_id;
	$ac_no = $row->account_name;
	$ac_grp = $row->group_no;
	$op_bal = $row->opening_balance;
	$opening_balance = $row->opening_balance;
	$opening_bal_type = $row->opening_bal_type;
}

?>
<!-- Basic Form Start -->
<div class="p-6 max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                Edit General Ledger Account
            </h2>

            <a href="<?= base_url('index.php/Accounts/list_general_ledger_account_form') ?>"
               class="px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200">
                List Records
            </a>
        </div>

        <!-- Form -->
        <form method="post"
              action="<?= base_url('index.php/Accounts/update_general_ledger_records'); ?>"
              id="gen_ledger"
              class="p-6 space-y-6">

            <!-- Account Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Account Name
                </label>
                <input type="text"
                       name="ac_name"
                       value="<?= $ac_no; ?>"
                       readonly
                       class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 cursor-not-allowed">
            </div>

            <!-- Account Group -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Account Group
                </label>
                <select disabled
                        class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 cursor-not-allowed">
                    <?php foreach ($account_records as $row): ?>
                        <option <?= ($row->group_no == $ac_grp) ? 'selected' : ''; ?>>
                            <?= $row->group_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Opening Balance -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Opening Balance <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="opening_bal"
                           id="opening_bal"
                           value="<?= $opening_balance; ?>"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Opening Balance Type <span class="text-red-500">*</span>
                    </label>
                    <select name="dr_cr_type"
                            id="dr_cr_type"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Dr / Cr</option>
                        <option value="Dr" <?= ($opening_bal_type == 'Dr') ? 'selected' : ''; ?>>Dr</option>
                        <option value="Cr" <?= ($opening_bal_type == 'Cr') ? 'selected' : ''; ?>>Cr</option>
                    </select>
                </div>
            </div>

            <!-- Hidden -->
            <input type="hidden" name="account_id" value="<?= $account_id; ?>">

            <!-- Actions -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Update
                </button>

                <button type="reset"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Reset
                </button>
            </div>

        </form>
    </div>
</div>


<script>
	$('#gen_ledger').validate({
		rules: {

			opening_bal: {
				required: true,
				number: true,

			},

			dr_cr_type: {
				required: true,

			},

		},

		messages: {

			opening_bal: {
				required: "Please enter Opening Balance",
			},

			dr_cr_type: {
				required: "Please Select DR/CR Type",
			},

		},

		highlight: function(element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			$(id_attr).removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
		},
		unhighlight: function(element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			$(id_attr).removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
		},
		errorElement: 'span',
		errorClass: 'help-block',
		errorPlacement: function(error, element) {
			if (element.length) {
				error.insertAfter(element);
			} else {
				error.insertAfter(element);
			}
		}
	});
</script>
