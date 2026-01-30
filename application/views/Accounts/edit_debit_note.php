 <!-- Basic Form Start -->
<div class="basic-form-area mg-tb-15" >
    <div class="container-fluid">
        <div class="row">                   
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline9-list responsive-mg-b-30">
                    <!--<div class="sparkline9-hd">
                        <div class="main-sparkline9-hd">
                            <h1>Company Details <span class="basic-ds-n">add</span></h1>
                            <br>
                        </div>
                    </div>-->
                    <div class="sparkline9-graph">
                        <div class="basic-login-form-ad">                                    
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">			
		<form class="form-horizontal" action="<?php echo base_url().'index.php/'; ?>accounts/update_debit_note" id="debit_note" method="post" name="debit_note" >
			<div class="box-body">
				<?php foreach($debit_note_edit as $row):?>			 	 			
				<div class="form-group row">
					<label class="col-sm-2 control-label">Voucher No :</label>
					<div class="col-sm-2">
						<input id="receipt_no" name="receipt_no" type="text" class="form-control col-sm-2 input-sm"  value="<?php echo $row->voucher_code ;?>"readonly />
					</div>
					<label class="col-sm-2 control-label">Date :</label>
					 <div class="col-sm-2">
						 <div class="form-group data-custon-pick" id="data_1">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="text" class="form-control" id='v_date' name='v_date' tabindex='1' value="<?php echo date('d-m-Y',strtotime($row->voucher_date));?>" required>
                                        </div>
                                    </div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label">Debit Account :</label>
					<div class="col-sm-2">
						<input type="text" id="occupier_name" name="occupier_name" class="form-control col-sm-2 input-sm" value="<?php echo $row->account_name;?>" readonly required/>
					</div>
				
					<label class="col-sm-2 control-label">Credit Account :</label>
					<div class="col-sm-2">
						<input type="text" id="supp_name" name="supp_name" class="form-control col-sm-2 input-sm" value="<?php echo $row->cracc_name ;?>" readonly required/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label"> Amount :</label>
					<div class="col-sm-2">
						<input type="text" id="amount" name="amount" class="form-control col-sm-2 input-sm" value="<?php echo $row->amount;?>" readonly >
					</div>
					
					<label class="col-sm-2 control-label">Narration :</label>
					<div class="col-sm-2">	
						<textarea id="remark" class="form-control col-sm-2 input-sm" rows="3"  name="remark" ><?php echo $row->narration;?></textarea>
					</div>
				</div>
				<div class="col-sm-offset-4">
					<input type="submit" id="edit" class="btn btn-primary" value="Update" />
					<input type="hidden" id="voucher_id" name="voucher_id" value="<?php echo $row->voucher_id;?>" >
					
				</div>
			 <?php endforeach ;?>	
			</div>
		</form>		
		 </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
               
    </div>
</div>

