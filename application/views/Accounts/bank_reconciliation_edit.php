
<div class="card-body">
	<form class="form-horizontal" action="<?php echo base_url().'index.php/Accounts/update_bank_reconciliation'; ?>" id="receipt" method="post" name="receipt" >
    <?php  foreach($records as $row) :?>

	<div class="form-group row">
          <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Instrument Number:</label>
              <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
              <div class="input-group">
                      <input type="text" class="form-control form-control-sm" id="instrument_no" name="instrument_no" value="<?php echo $row->instrument_no;?>" tabindex="1">
                  </div>
              </div>           
        </div>

		<div class="form-group row">

                        <label  class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Instrument Date:</label>
                        <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                            <div class="input-group date datepicker1">
                                <input type="text" class="form-control form-control-sm datepicker1" value="<?php echo date('d-m-Y') ?>" id="date" name="date" tabindex="2" >
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								</div>
              </div>           
        </div>


		<div class="form-group row">
          <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label"> Amount Number:</label>
              <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
              <div class="input-group">
                      <input type="number" class="form-control form-control-sm" id="amount_no" name="amount_no" min="0" value="<?php echo $row->amount_no;?>" tabindex="3">
                  </div>
              </div>           
        </div>

		<div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Type:</span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                <select class="form-select form-control-sm select2" name="instrument_type" id="instrument_type" value="<?php echo $row->instrument_type;?>"  tabindex="4">
                <option value="">Please select Type</option>
                <option <?php if ($row->instrument_type == 'Dr/Cr') echo 'selected'; ?> value="Dr/Cr">Dr/Cr</option>
                    <option <?php if ($row->instrument_type == 'Distribution') echo 'selected'; ?> value="Distribution">Distribution</option>
                </select>
            </div>


			<div class="form-group row">
        </div>

           
                <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Remark:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
            <div class="input-group">

                <textarea id="remark" name="remark" rows="2" placeholder="remark" style="width: 100%;" tabindex="5"><?php echo ($row->remark); ?></textarea>
            </div>

        </div>
        <?php endforeach; ?>


		</div>       
        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
            <input type="hidden" name="reconciliation_id" value="<?php echo $row->reconciliation_id; ?>">

                <button type="submit" tabindex="6" id="add" class="btn btn-primary m-b-0">Update</button>
            </div>
        </div>
        </form>
		</div>







































	</div>