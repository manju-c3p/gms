   <!-- page content -->

        <div class="form-group" role="main">
          <div class="">
            <div class="page-title">
             

            <div class="clearfix"></div>

            <div class="x_content">


              <div class="well" style="overflow: auto">
               
                
              <div class="dt-responsive table-responsive">
			<table id="datatable" class="table table-striped" data-toggle="data-table">
          <thead>
              <tr>
              <th>#</th>
							<th>Sr.no</th>
							<th>PO Code</th>
							<th>PO Date</th>
							<th>Supplier</th>
              <th>Document</th>
              <th>Status</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>

					<?php $i=1; foreach($records as $row) :?>
						<tr>
              <td>
                  <a href="javascript:confirmcancel(<?php echo $row->po_id;?>)" title="Delete" class="delete" id="delete">
                  <i class="glyphicon glyphicon-trash"></i>
              </a>
              </td>
							<td><?php echo $i;$i++;?></td>
							<td>
								<?php echo $row->po_code;?>
							
							</td>
							<td><?php echo date('d-M-Y',strtotime($row->po_date));?></td>
							<td>
								<a title="View supplier details" target='blank' href="<?php echo base_url().'index.php/Users/edit_supplier/'.$row->supplier_id;?>" >
								<?php echo $row->supplier_name;?>
								</a>
							</td>
              <td>

                 <a title="View Document" href="<?php echo base_url('public/uploaded_documents/' . $row->doc_path); ?>" target="_blank">
								<?php echo $row->doc_path;?>
								</a>
              </td>
							<td>
              <?php if ($row->po_status == 1): ?>
                <span class="badge badge-dark" style="margin-right:10px; cursor: not-allowed;">Approved</span>    <br/>
                  
              <?php else: if (has_access_id(2)){ ?> 
                <a href="<?php echo base_url().'index.php/Purchase/approve_po/'.$row->po_id;?>" class="badge badge-success" style="margin-right:10px;">Approve</a> 
              <?php } endif; ?>
              

              </td>
              <td>
                 <?php if (($row->po_status != 1) || (has_access_id(1))){ ?>
                <a href="<?php echo base_url().'index.php/Purchase/edit_po/'.$row->po_id.'/0';?>" title="Edit" style="margin-right:10px;">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
              <?php } ?>
              <a target="_blank" href="<?php echo base_url().'index.php/Purchase/print_po/'.$row->po_id.'/1';?>" style="margin-right:10px;">
                  <i class="fa fa-print"></i>
              </a>

            
			</td>
						</tr>
					<?php endforeach; ?>
					</tbody>

				</table>
      </div>
               
               
               
               
              </div>
            </div>

              </div>
            </div>
            
          </div>
        </div>
       
 <script>
function confirmcancel(po_id)
{
    if(confirm("Are you sure you want to delete this Purchase Order?"))
    {
        window.location.href = "<?php echo base_url('Purchase/delete_purchase_order/'); ?>" + po_id;
    }
}
</script>
  