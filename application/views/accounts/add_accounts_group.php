<div class="p-6">

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-md p-6">

        <!-- Title -->
        <h2 class="text-xl font-bold text-gray-800 mb-6">
            Add Account Group
        </h2>

        <!-- Form -->
        <form method="post"
              action="<?= base_url('index.php/Accounts/add_account_group_records'); ?>"
              id="account"
              class="space-y-6">

            <!-- Account Group Name -->
            <div>
                <label for="ac_group"
                       class="block text-sm font-semibold text-gray-700 mb-1">
                    Account Group Name <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       name="ac_group"
                       id="ac_group"
                       placeholder="Account Group Name"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Parent Group -->
            <div>
                <label for="p_group"
                       class="block text-sm font-semibold text-gray-700 mb-1">
                    Parent Group <span class="text-red-500">*</span>
                </label>

                <select name="p_group"
                        id="p_group"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="0">Self</option>
                    <?php foreach ($parent_records as $row): ?>
                        <option value="<?= $row->group_no; ?>">
                            <?= $row->group_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Section In Accounts -->
            <div>
                <label for="sec_in_account"
                       class="block text-sm font-semibold text-gray-700 mb-1">
                    Section In Accounts
                </label>

                <select name="sec_in_account"
                        id="sec_in_account"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select</option>
                    <?php foreach ($section_records as $row): ?>
                        <option value="<?= $row->group_no; ?>">
                            <?= $row->group_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex flex-wrap gap-3 pt-4">

                <button type="submit"
                        name="add"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Save Group
                </button>

                <a href="<?= base_url('index.php/Accounts/view_general_ledger_account_form'); ?>"
                   target="_blank"
                   class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Create Ledger Account
                </a>

                <button type="reset"
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                    Reset
                </button>

            </div>

        </form>
    </div>
</div>
<script>
    $('#p_group').on('change', function () {
        let p_group = $(this).val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('index.php/Ajax/get_parent_account_group'); ?>",
            data: { group_no: p_group },
            success: function (msg) {
                $('#sec_in_account').val(msg);
            }
        });
    });
</script>
<script>
    $('#account').validate({
        rules: {
            ac_group: { required: true },
            p_group: { required: true }
        },
        messages: {
            ac_group: { required: "Please enter Account group" },
            p_group: { required: "Please select Parent group" }
        },
        errorClass: "text-red-500 text-sm mt-1",
        highlight: function (element) {
            $(element).addClass('border-red-500');
        },
        unhighlight: function (element) {
            $(element).removeClass('border-red-500');
        }
    });
</script>
