
<div class="card-body">
	<form class="form-horizontal" action="<?php echo base_url().'index.php/Accounts/view_bank_reconciliation'; ?>" id="receipt" method="post" name="receipt" >
	<div class="form-group row">

    <label class="col-xs-6 col-sm-2 col-md-2 col-lg-2 col-form-label">Select  Account:<span style="color: red;"> * </span></label>
		      	<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<select tabindex="1" class="form-select form-control-sm select2 select2" id="account_id" name="account_id" required onchange="get_doc_list()">
					<option value="">Select Code</option>
					<?php foreach($account_ledgers as $s) {?>
					  <option <?php if($s->account_id==$account_id) echo 'selected'; ?> value="<?php echo $s->account_id; ?>"><?php echo $s->account_name;?></option>
					<?php } ?>
				      </select>
                </div>	
                         
                <label  class="col-xs-12 col-sm-1 col-md-1 col-lg-1 col-form-label">From :</label>
                <div class="col-xs-12 col-sm-9 col-md-1 col-lg-2">
                <input type="date" class="form-control form-control-sm " id="from_date" name="from_date" onchange="get_doc_list()" >
                              
              </div>  
               <label  class="col-xs-12 col-sm-1 col-md-1 col-lg-1 col-form-label">To :</label>
                <div class="col-xs-12 col-sm-9 col-md-1 col-lg-2">
                <input type="date" class="form-control form-control-sm" id="to_date" name="to_date" onchange="get_doc_list()" />        
              </div>           


        <div class="form-group row" id="reco_list">

        </div>

        <div class="form-group row">

          <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Remarks:</label>
              <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
              <div class="input-group">
                      <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;" tabindex="5"></textarea>
                  </div>
              </div>           
        </div>



		    
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="6" id="add" class="btn btn-primary m-b-0">Submit</button>
            </div>
        </div>
        </form>
		</div>


<script>
function get_doc_list()
{
	var account_id=document.getElementById('account_id').value;

    var from_date=document.getElementById('from_date').value;
    var to_date=document.getElementById('to_date').value;
	if(account_id!='')
	{
		$.ajax
		({
			url: "<?php echo site_url('Ajax/get_reco_list'); ?>",
			type: 'POST',
			 data: {
                account_id: account_id,
                from_date: from_date,
                to_date: to_date
            },
			success: function(msg) {
				document.getElementById('reco_list').innerHTML=msg;
			}
		});
	}
	else
	{
		document.getElementById('reco_list').innerHTML='';
	}
}

</script>

































	</div>