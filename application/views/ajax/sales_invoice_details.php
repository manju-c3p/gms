
<?php for($c=1;$c<=$case_no;$c++) 
{?>
	<h6>Details For Case <?php echo $c ?></h6>
	<div class="form-group row">
	    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Net Wt(Kgs)</label>
	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2" >         
		<input type="text" class="form-control form-control-sm " id="netwt" name="netwt[]" >
 	    </div>
     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Gross Wt (Kgs)</label>
    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" name="gramwt[]" id="gramwt" class="form-control form-control-sm"  >
	     </div>
     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Volume(cm)</label>
    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" name="volume[]" id="volume" class="form-control form-control-sm"  >
			<input type="hidden"  name="case[]" value="<?php echo $c;?>" >
	     </div>
	</div>
	
	<div class="form-group row">
	    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Diamentions</label>
	    <div class="col-xs-12 col-sm-9 col-md-4 col-lg-4" >         
		<input type="text" class="form-control form-control-sm " id="diamentions" name="diamentions[]" >
	</div>
<?php } ?>
