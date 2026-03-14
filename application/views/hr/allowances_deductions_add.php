<style type="text/css">
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 240px !important;
        min-width: 240px !important;
    }
</style>

<div class="card-body">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Hr/add_allowances_data" id="addform" autocomplete="off" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Allowances Type<span style="color: red;"> * </span></label>
            <div class="col-xs-12 col-sm-9 col-md-5 col-lg-5">
                <select tabindex="1" class="form-select form-control-sm" id="allowance_type" name="allowance_type" required>
                    <option value="">Select</option>
                    <option value="A">Allowances </option>
                    <option value="D">Deductions </option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Allowance Name<span style="color: red;">*</span></label>
            <div class="col-sm-5">
                <input type="text" class="form-control form-control-sm" id="allowance_name" name="allowance_name" onblur="check_dept_exist();"  placeholder="Enter Allowance Name" tabindex="2" required>
	      <label id="dept_exits" style="color: red;"></label>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" id='add' tabindex="3"class="btn btn-primary m-b-0">submit</button>
            </div>
        </div>
    </form>
</div>
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
