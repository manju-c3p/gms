<div class="p-6 ">

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-md p-8">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-800 mb-8">
            Add General Ledger Account
        </h2>

        <form method="post"
              action="<?= base_url('index.php/Accounts/add_general_ledger_records'); ?>"
              id="gen_ledger"
              class="space-y-6">

            <!-- Account Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Account Type <span class="text-red-500">*</span>
                </label>

                <select name="account_type"
                        id="account_type"
                        onchange="show_list_div(this.value);"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Please select account type</option>
                    <option value="CUS">Customer / Sundry Debtors</option>
                    <option value="SUPP">Vendor / Supplier / Sundry Creditors</option>
                    <option value="OTHER">Others</option>
                </select>
            </div>

            <!-- Account Name (OTHER) -->
            <div id="show_other" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Account Name
                </label>

                <input type="text"
                       name="ac_name"
                       id="ac_name"
                       placeholder="Account Name"
                       class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Customer -->
            <div id="show_visitor" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Select Customer
                </label>

                <select name="CUS"
                        id="inward_from_customer"
                        onchange="check_account_name_exist();"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <?php foreach ($customer_records as $row): ?>
                        <option value="<?= $row->occu_name . ',' . $row->occupier_id; ?>">
                            <?= $row->occu_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Supplier -->
            <div id="show_vendor" class="hidden">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Select Vendor / Supplier
                </label>

                <select name="SUPP"
                        id="inward_from_supplier"
                        onchange="check_account_name_exist();"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <?php foreach ($supplier_records as $row): ?>
                        <option value="<?= $row->supp_name . ',' . $row->supp_id; ?>">
                            <?= $row->supp_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Account Group -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Account Group <span class="text-red-500">*</span>
                </label>

                <select name="ac_group"
                        id="ac_group"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Select</option>
                    <?php foreach ($account_records as $row): ?>
                        <option value="<?= $row->group_no; ?>">
                            <?= $row->group_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Opening Balance -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Opening Balance <span class="text-red-500">*</span>
                </label>

                <input type="number"
                       step="0.01"
                       name="opening_bal"
                       id="opening_bal"
                       placeholder="Opening Balance"
                       class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Opening Balance Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Opening Balance Type <span class="text-red-500">*</span>
                </label>

                <select name="dr_cr_type"
                        id="dr_cr_type"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Dr / Cr Type</option>
                    <option value="Dr">Debit (Dr)</option>
                    <option value="Cr">Credit (Cr)</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6">

                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Submit
                </button>

                <a href="<?= base_url('index.php/Accounts/view_account_group_form'); ?>"
                   target="_blank"
                   class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Create Group
                </a>

                <button type="reset"
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Reset
                </button>

            </div>

        </form>
    </div>
</div>
<script>
function show_list_div(acc_type) {

    $('#show_other, #show_visitor, #show_vendor').addClass('hidden');

    if (acc_type === 'CUS') {
        $('#show_visitor').removeClass('hidden');
    }
    else if (acc_type === 'SUPP') {
        $('#show_vendor').removeClass('hidden');
    }
    else if (acc_type === 'OTHER') {
        $('#show_other').removeClass('hidden');
    }
}
</script>
<script>
$('#gen_ledger').validate({
    rules: {
        account_type: { required: true },
        ac_name: { required: true },
        ac_group: { required: true },
        opening_bal: { required: true, number: true },
        dr_cr_type: { required: true }
    },
    messages: {
        account_type: "Please select account type",
        ac_name: "Please enter account name",
        ac_group: "Please select account group",
        opening_bal: "Please enter opening balance",
        dr_cr_type: "Please select Dr/Cr type"
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
<script>
function check_account_name_exist() {

    let name = '';

    if ($('#account_type').val() === 'CUS') {
        name = $('#inward_from_customer option:selected').text();
    } else if ($('#account_type').val() === 'SUPP') {
        name = $('#inward_from_supplier option:selected').text();
    }

    if (!name) return;

    $.ajax({
        url: "<?= site_url('ajax_validation/check_account_name_exist'); ?>",
        type: 'POST',
        dataType: "json",
        data: { ac_name: name },
        success: function (msg) {
            if (msg != 0) {
                alert("Account Name already exists");
            }
        }
    });
}
</script>
