<?php 
	$user = $this->session->userdata('user_id');
?>
   <form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Reports/get_pr_report" autocomplete="off" enctype="multipart/form-data">
	
          <!-- page content -->
          <div class="form-group" role="main">
          <div class="">
            <div class="page-title"></div>
            <div class="clearfix"></div>

            <div class="x_content">



              <div class="well" style="overflow: auto">
                <div class="col-md-12">
                  <label class="control-label col-md-1 col-sm-3 col-xs-3"> From Date:</label>
                  <div class="col-md-2">
                    <input type="date" name ="from_date" class="form-control" value="<?php echo $from; ?>"/>
                  </div>
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">To Date:</label>
                  <div class="col-md-2">
                    <input type="date" name ="to_date" class="form-control" value="<?php echo $to; ?>"/>
                  </div>
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Supplier:</label>
                  <div class="col-md-2">
                  <select name="supplier_id" id="supplier_id" class="form-control select2" tabindex="2">
                  <option value="">-select-</option>
                 
                    <?php foreach($supplier_records as $g) { ?>
                        <option <?php if($supplier_id==$g->supplier_id) echo 'selected'; ?> value="<?php echo $g->supplier_id;?>" ><?php echo $g->supplier_code.' '.$g->supplier_name; ?> </option>
                        <?php } ?>
                    </select>  
                  </div>
                  
               
              
                <div class="col-md-2">
                  
                  <button type="submit" class="btn btn-success">Go</button>
                  ,<a href="" onclick="printPRReport()"><i class="fa fa-print" ></i></a>
                </div>
                </div>
              </div>
            </div>


            <div class="dt-responsive table-responsive">
              <table id="basic-btn" class="table table-striped table-bordered nowrap">
                <thead>
                  <tr>
										<th>Sr. No</th>
                    <th>Supplier Name</th>
										<th>Model Code</th>
										<th>Description</th>
										<th>Price</th>
                    <th>Landing Price</th>
                    <th>Date</th>
										
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach($records as $row) :?>
                    <tr>
											<td><?php echo  $i; $i++;?></td>
                      <td><?php echo $row->supplier_name; ?></td>
											<td><?php echo $row->item_model; ?></td>
                      <td><?php echo $row->item_description; ?></td>
											<td><?php echo $row->price; ?></td>
                      <td><?php echo $row->landing_price; ?></td>
											<td><?php echo $row->grn_date; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <th>Sr. No</th>
                    <th>Supplier Name</th>
										<th>Model Code</th>
										<th>Description</th>
										<th>Price</th>
                    <th>Landing Price</th>
                    <th>Date</th>
                </tfoot>
              </table>
            </div>
           
            <!--  -->
              </div>
            </div>
            
          </div>
        </div>
       
</form>
<script>
  function printPRReport() {
    const fromDate = document.querySelector('input[name="from_date"]').value;
    const toDate = document.querySelector('input[name="to_date"]').value;
    const supplierId = document.querySelector('select[name="supplier_id"]').value;

    const baseUrl = "<?php echo base_url().'index.php/Reports/print_pr_report'; ?>";
    const params = new URLSearchParams({
      from_date: fromDate,
      to_date: toDate,
      supplier_id: supplierId
    });

    const printUrl = `${baseUrl}?${params.toString()}`;
    window.open(printUrl, '_blank');
  }
</script>
