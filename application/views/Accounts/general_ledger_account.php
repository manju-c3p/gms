<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
 
 <!-- Basic Form Start -->
<div class="p-6 max-w-5xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">
                Add General Ledger Account
            </h2>

            <div class="flex gap-3">
                <a href="<?= base_url('index.php/Accounts/list_general_ledger_account_form') ?>"
                   class="px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-full hover:bg-blue-200">
                    List Records
                </a>
            </div>
        </div>

        <!-- Form -->
        <form method="post"
              action="<?= base_url('index.php/Accounts/add_general_ledger_records'); ?>"
              id="gen_ledger"
              class="p-6 space-y-6">

            <!-- Account Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Account Type <span class="text-red-500">*</span>
                </label>
                <select id="account_type"
                        name="account_type"
                        onchange="show_list_div(this.value);"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Please select account type</option>
                    <option value="CUS">Customer / Sundry Debtors</option>
                    <option value="SUPP">Vendor / Supplier / Sundry Creditors</option>
                    <option value="OTHER">Others</option>
                </select>
            </div>

            <!-- Account Name (Other) -->
            <div id="show_other" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Account Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="ac_name"
                       name="ac_name"
                       placeholder="Account Name"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Customer -->
            <div id="show_visitor" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Select Customer
                </label>
                <select name="CUS"
                        id="customer_select"
                        onchange="check_account_name_exist();"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 select2 debtor-select">
                    <option value="">Select</option>
                    <?php foreach ($customer_records as $row): ?>
                        <option value="<?= $row->occu_name . ',' . $row->occupier_id; ?>">
                            <?= $row->occu_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Vendor -->
            <div id="show_vendor" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Select Vendor / Supplier
                </label>
                <select name="SUPP"
                        id="supplier_select"
                        onchange="check_account_name_exist();"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 select2 credit-select">
                    <option value="">Select</option>
                    <?php foreach ($supplier_records as $row): ?>
                        <option value="<?= $row->supplier_name . ',' . $row->supplier_id; ?>">
                            <?= $row->supplier_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Account Group -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Account Group <span class="text-red-500">*</span>
                </label>
                <select name="ac_group"
                        id="ac_group"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2">
                    <option value="">Select</option>
                    <?php foreach ($account_records as $row): ?>
                        <option value="<?= $row->group_no; ?>">
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
                           id="opening_bal"
                           name="opening_bal"
                           placeholder="Opening Balance"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Opening Balance Type <span class="text-red-500">*</span>
                    </label>
                    <select id="dr_cr_type"
                            name="dr_cr_type"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2">
                        <option value="">Select Dr / Cr</option>
                        <option value="Dr">Dr</option>
                        <option value="Cr">Cr</option>
                    </select>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Submit
                </button>

                <a target="_blank"
                   href="<?= base_url('index.php/Accounts/view_account_group_form'); ?>"
                   class="px-6 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200">
                    Create Group
                </a>

                <button type="reset"
                        class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Reset
                </button>
            </div>

        </form>
    </div>
</div>



<script>

function check_acc_code_exist(post_value, table_name, column_name, input_name)
{
	//var ac_code = document.getElementById("ac_code").value;
	//alert(ac_code);
	if(post_value!='')
	{
		$.ajax({     	 	 	
	        'type': "POST",
	 	    'url':"<?php echo base_url()?>index.php/Ajax/check_record_exist",          
	        'data':{code:post_value, tb_name:table_name, column: column_name},
	        //'dataType':"json",
	        'success': function(msg)
	        { 
	        	if(msg==1)
	        	{
	        	 alert('Account Code already exist');
	        	 document.getElementById(input_name).value='';
	        	}
	       	}
		});
	}
}


// function show_list_div(acc_type) {
//     $('#show_visitor, #show_vendor, #show_other').addClass('hidden');

//     if (acc_type === 'CUS') $('#show_visitor').removeClass('hidden');
//     else if (acc_type === 'SUPP') $('#show_vendor').removeClass('hidden');
//     else if (acc_type === 'OTHER') $('#show_other').removeClass('hidden');
// }
function show_list_div(acc_type) {
    $('#show_visitor, #show_vendor, #show_other').addClass('hidden');

    if (acc_type === 'CUS') {
        $('#show_visitor').removeClass('hidden');

        // ✅ INIT AFTER SHOW
        $('.debtor-select').select2({
            width: '100%'
        });

    } else if (acc_type === 'SUPP') {
        $('#show_vendor').removeClass('hidden');

        // ✅ INIT AFTER SHOW
        $('.credit-select').select2({
            width: '100%'
        });

    } else if (acc_type === 'OTHER') {
        $('#show_other').removeClass('hidden');
    }
}


	$('#gen_ledger').validate({
    rules: {
        account_type: { required: true },
        ac_name: { required: true },
        ac_group: { required: true },
        opening_bal: { required: true, number: true },
        dr_cr_type: { required: true }
    },
    messages: {
        account_type: "Please select Account Type",
        ac_name: "Please enter Account Name",
        ac_group: "Please select Account Group",
        opening_bal: "Please enter Opening Balance",
        dr_cr_type: "Please select Dr / Cr type"
    },
    errorElement: 'p',
    errorClass: 'text-red-600 text-sm mt-1',
    highlight: function (el) {
        $(el).addClass('border-red-500');
    },
    unhighlight: function (el) {
        $(el).removeClass('border-red-500');
    }
});

	// function check_account_name_exist()
	// {
    //    var inward_from=document.getElementById('inward_from').value;
	//    inward_from_name=$("#inward_from option:selected").text();
	  
    //    $.ajax
    //    ({
	// 		url: "<?php echo site_url('ajax_validation/check_account_name_exist'); ?>",
	// 		type: 'POST',
	// 		dataType: "json",
	// 		data: {ac_name: inward_from_name},
	// 		success: function(msg) {
	// 			//alert(msg);
	// 			if(msg !=0)
	// 			{
	// 				alert("Account Name Already Exits");
	// 				$('#inward_from').val('');
	// 			}
				
	// 	}
	// 	});
	// }
function check_account_name_exist()
{
    let inward_from = '';
    let inward_from_name = '';

    // ✅ Check which dropdown is visible
    if (!$('#show_visitor').hasClass('hidden')) {
        inward_from = $('#customer_select').val();
        inward_from_name = $('#customer_select option:selected').text();
    } 
    else if (!$('#show_vendor').hasClass('hidden')) {
        inward_from = $('#supplier_select').val();
        inward_from_name = $('#supplier_select option:selected').text();
    }

    if (inward_from !== '') {
        $.ajax({
            url: "<?php echo site_url('ajax_validation/check_account_name_exist'); ?>",
            type: 'POST',
            dataType: "json",
            data: { ac_name: inward_from_name },
            success: function(msg) {
                if (msg != 0) {
                    alert("Account Name Already Exists");

                    // ✅ Reset correct field
                    if (!$('#show_visitor').hasClass('hidden')) {
                        $('#customer_select').val('').trigger('change');
                    } else {
                        $('#supplier_select').val('').trigger('change');
                    }
                }
            }
        });
    }
}

</script>

