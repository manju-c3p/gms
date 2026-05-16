<style type="text/css">
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 240px !important;
        min-width: 240px !important;
    }
</style>

<div class="bg-white rounded-xl shadow p-6">
	 <div class="flex justify-between items-center mb-4">
       <h2 class="text-xl font-semibold text-gray-700"> Allowances & Deductions Master </h2> <!-- List Button --> <a href="<?= base_url('index.php/Hr/view_allowances_list') ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-medium"> List </a>
    </div>

    <form id="main" method="post"
        action="<?php echo base_url() . 'index.php/'; ?>Hr/add_allowances_data"
        autocomplete="off" enctype="multipart/form-data">

        <!-- Allowance Type -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
            <label class="text-sm font-medium text-gray-700">
                Allowances Type <span class="text-red-500">*</span>
            </label>

            <div class="md:col-span-2">
                <select tabindex="1"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="allowance_type" name="allowance_type" required>

                    <option value="">Select</option>
                    <option value="A">Allowances</option>
                    <option value="D">Deductions</option>

                </select>
            </div>
        </div>

        <!-- Allowance Name -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-5">
            <label class="text-sm font-medium text-gray-700">
                Allowance Name <span class="text-red-500">*</span>
            </label>

            <div class="md:col-span-2">
                <input type="text"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="allowance_name"
                    name="allowance_name"
                    onblur="check_dept_exist();"
                    placeholder="Enter Allowance Name"
                    tabindex="2"
                    required>

                <label id="dept_exits" class="text-red-500 text-sm mt-1 block"></label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div></div>

            <div class="md:col-span-2">
                <button type="submit"
                    id="add"
                    tabindex="3"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow">
                    Submit
                </button>
            </div>
        </div>

    </form>

</div>



<script>

function check_dept_exist()
{
	var atype= $('#allowance_type').val();
	var aname= $('#allowance_name').val();
	$.ajax
	({
		url: "<?php echo site_url('Ajax/check_duplicate_exist2'); ?>",
		type: 'POST',
		data: {table_name:'allowance_master', column_name1:'allowance_type', post_id1: atype, column_name2:'allowance_name', post_id2: aname},
		success: function(msg) {
			if(msg!=0)
			{
				$('#dept_exits').html("Name already exits");
				$('#allowance_name').val('');
			}
			else
			{
				$('#dept_exits').html("");
			}
		}
	});
}
</script>
