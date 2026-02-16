<link rel="stylesheet" href="<?php echo base_url()?>public/expand_row/jquery.treegrid.css">
<script type="text/javascript" src="<?php echo base_url()?>public/expand_row/jquery.treegrid.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>public/expand_row/jquery.treegrid.bootstrap3.js"></script>

<?php $this->load->helper('Account_helper.php'); ?>
<div class="card-body">

	<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Accounts/get_balance_sheet" class="form-horizontal" autocomplete="off" name="question" id="question" enctype="multipart/form-data">
		<div class="form-group row">
			    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-1 col-form-label">From <span style="color: red;"> * </span></label>
			    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<div class="input-group date datepicker1">
				    <input type="text" class="form-control form-control-sm datepicker1" id="from" name="from" value="<?php echo $from; ?>">
				    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				</div>
			    </div>
			    <label class="col-xs-12 col-sm-2 col-md-1 col-lg-1 col-form-label">To <span style="color: red;"> * </span></label>
			    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<div class="input-group date datepicker1">
				    <input type="text" class="form-control form-control-sm datepicker1" id="to" name="to" value="<?php echo $to; ?>">
				    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				</div>
			    </div>
		            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
				 <input type="submit" id="view" name="go" value="Go" class="btn btn-sm btn-primary m-b-0" />
			    </div>
			</div>          
		    </form>
		    
	    	<div class="form-group row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 dt-responsive table-responsive">
				<table class="table tree-2 table-bordered table-condensed ">
				<tr>
				    <thead>
				    <td>Account Title</td>
				    <td>Amount</td>
				    <thead>
				</tr>
				<tbody>
				<tr class='treegrid-0'>
				    <td><b>Liabilities </b></td>
				    <td></td>
				</tr>

				<?php //$children_ids = fetch_children(2,$from,$to);
				$result=get_group_details(0,2);
				foreach($result as $k){ ?>
				<tr class='treegrid-0'>
				    <td><b><?php echo $k->group_name;?> </b></td>
				    <td align='right'>
					<?php     
					$gno="";
					$gno1 = get_group_nos($k->group_no);
					if($gno1!='')
					{
						$gno= $k->group_no;
						$gno2 = get_group_nos($gno1);
					
					 	if($gno2!='')
							$gno= $k->group_no.','.$gno1.','.$gno2;
						else
							$gno= $k->group_no.','.$gno1;
					
						echo get_group_total1($gno,$from,$to);
					}
					else 
						echo get_group_total1($k->group_no,$from,$to);
			    		?> 
			    	    </td>
				</tr>
				<?php } ?>      
				</tbody>
				<tfoot>
				<tr class='treegrid-0'>
				    <td>Opening Balance</td>
				    <td align='right'><?php echo sprintf("%0.2f",get_total_for_balance_sheet_with_date(2,$from)); ?></td>
				</tr>
				<tr>
				<td>Grand Total </td>
				<td align='right'>
				<?php 
				       	 /* use this to get debit total*/
					 $debit_total=get_total_for_balance_sheet(2);
					 echo sprintf("%0.2f",$debit_total);
				 ?>
				 </td>
				</tr>
				</tfoot>
			       </table>
				</div>
				
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 dt-responsive table-responsive">
				<table class="table tree-2 table-bordered table-condensed ">
				<tr>
				    <thead>
				    <td>Account Title</td>
				    <td>Amount</td>
				    <thead>
				</tr>
				<tbody>
				<tr class='treegrid-0'>
				    <td><b>Assets </b></td>
				    <td></td>
				</tr>

				<?php 
				$result=get_group_details(0,1);
				foreach($result as $kk){ ?>
				<tr class='treegrid-0'>
				    <td><b><?php echo $kk->group_name;?> </b></td>
				    <td align='right'>
					<?php     
					$gno="";
					$gno1 = get_group_nos($kk->group_no);
					if($gno1!='')
					{
						$gno= $k->group_no;
						$gno2 = get_group_nos($gno1);
					
					 	if($gno2!='')
							$gno= $k->group_no.','.$gno1.','.$gno2;
						else
							$gno= $k->group_no.','.$gno1;
					
						echo get_group_total1($gno,$from,$to);
					}
					else 
						echo get_group_total1($kk->group_no,$from,$to);
			    		?> 
			    	    </td>
				</tr>
				<?php } ?>      
				</tbody>
				<tfoot>
				<tr class='treegrid-0'>
				    <td>Opening Balance</td>
				    <td align='right'><?php echo sprintf("%0.2f",get_total_for_balance_sheet_with_date(1,$from)); ?></td>
				</tr>
				<tr>
				<td>Grand Total </td>
				<td align='right'>
				<?php 
				       	 /* use this to get debit total*/
					 $debit_total1=get_total_for_balance_sheet(1);
					 echo sprintf("%0.2f",$debit_total1);
				 ?>
				 </td>
				</tr>
				</tfoot>
			       </table>
				</div>
            	</div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Static Table End -->



 <script type="text/javascript">
            $(document).ready(function() {
                $('.tree').treegrid();
                $('.tree-2').treegrid({
                    expanderExpandedClass: 'glyphicon glyphicon-minus',
                    expanderCollapsedClass: 'glyphicon glyphicon-plus'
                });

            });
        </script>
