<?php  
	foreach ($acc_grp_records as $row ) {
   		$account_grp = $row->group_name;
		$p_grp = $row->parent_group;
		$ag_id = $row->group_no;
		$section_id = $row->sno;
		
	}
?>   

<section class="content-header">
	  <h1>
	   Account Group Addition
	    <small>Edit</small>
	  </h1>     
  </section>        
  <section class="content">
	<div class="row">
		<div class="col-md-12">
         		<div class="box box-info">
         			<form class="form-horizontal" method="post" action="<?php echo base_url() . 'index.php/'; ?>Accounts/update_account_grp_records" id="account">
         				<div class="box-body">         				
	         					         				
							<div class="form-group">						
								<label class="col-sm-2 control-label">Account Group Name</label>
								<div class="col-sm-4">
									<input type="text" class="form-control col-sm-2 input-sm" id="ac_group" name="ac_group" value="<?php echo $account_grp;?>">
								</div>			 
	         			</div>		
	         			      				
	         				<div class="form-group">
								<label  class="col-sm-2 control-label">Parent Group</label>
								<div class="col-sm-4">
									<select name="p_group" id="p_group" class="form-control">
										 	<option value="0">Top Level Group</option>
											<?php foreach($parent_records as $row) { ?>
	                   	    				<option <?php if($row->group_no == $p_grp) echo 'selected'; ?> value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
											<?php } ?>
									</select>	
								</div>
							</div>
							<div class="form-group">
								<label  class="col-sm-2 control-label">Section In Accounts</label>
								<div class="col-sm-4">
									<select name="sec_in_account" id="sec_in_account" class="form-control">
										<option value="">Select</option>
											<?php foreach($section_records as $row) { ?>
	                   	    				<option <?php if($row->group_no == $section_id) echo 'selected'; ?>  value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
											<?php } ?>
									</select>
								</div>
	         				</div>	
	         			<input type="hidden" id="ag_id" name="ag_id"  value="<?php echo $ag_id;?>">	
	         				
         				<div class="col-sm-offset-3">								
								<button type="submit" name="add" class="btn bg-red ">Update</button>
								<button type="reset" class="btn bg-red ">Reset</button>
						</div>
						
         			</form> <!-- End form -->
          		</div> <!-- End box -->
        	</div> <!-- End col-md -->
   		</div> <!-- End Row -->	
  </section> <!-- End Section -->	
  </div>
  <!-- /.content-wrapper -->

<script>
$("#p_group").change(function()
{  	
  	var p_group =document.getElementById('p_group').value; 
  	 $.ajax({     	 	 	
        'type': "POST",
 	    'url':"<?php echo base_url()?>index.php/Ajax/get_parent_account_group",          
        'data':{group_no:p_group},
        'success': function(msg){   
       		$('#sec_in_account').val(msg);	
       	}
	});
});
$('#account').validate({
		rules : {

			 ac_group: {
				required : true,

		        	},
			 p_group: {
				required : true,

			},
			 sec_in_account: {
				required : true,

			},
		},

		messages : {

			ac_group : {
				required : "Please enter Account group",
			},
			 
			 p_group: {
				required : "Please Select Parent group",
			},
			
			sec_in_account : {
				required : "Please Select Section ",
			},
		},

		highlight : function(element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			$(id_attr).removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
		},
		unhighlight : function(element) {
			var id_attr = "#" + $(element).attr("id") + "1";
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			$(id_attr).removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
		},
		errorElement : 'span',
		errorClass : 'help-block',
		errorPlacement : function(error, element) {
			if (element.length) {
				error.insertAfter(element);
			} else {
				error.insertAfter(element);
			}
		}
	});

</script>