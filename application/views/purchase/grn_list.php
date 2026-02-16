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
                            <th>Sr.No</th>
							<th>GRN Code</th>
							<th>GRN Date</th>
							<th>Supplier</th>
                            <th>Amount</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
					<?php $i=1; foreach($records as $row) :?>
						<tr>
							<td>
                                  <a href="#" class="delete-grn" data-grn-id="<?php echo $row->grn_id; ?>" title="Delete">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>   
                            </td>
                            <td>
                            <?php echo $i;$i++;?></td>
							<td>
								<?php echo $row->grn_code;?>
							
							</td>
							<td><?php echo date('d-M-Y',strtotime($row->grn_date));?></td>
							<td>
								<a title="View customer details" target='blank' href="<?php echo base_url().'index.php/Users/edit_supplier/'.$row->supplier_id;?>" >
								<?php echo $row->supplier_name;?>
								</a>
							</td>
              <td><?php echo $row->grand_total;?></td>
							<td>
              
              <a target="_blank" href="<?php echo base_url().'index.php/Purchase/print_grn/'.$row->grn_id.'/1';?>" style="margin-right:10px;">
                  <i class="fa fa-print"></i>&nbsp; 
              </a>
              <!-- <a target="_blank" href="<?php // echo base_url().'index.php/Purchase/print_grn_barcode/'.$row->grn_id.'/1';?>" style="margin-right:10px;">
                 <i class="fa fa-image"></i>
              </a> -->
             
            
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
       
        <!-- /page content -->

<script>
  $(document).ready(function() {
   
    $('.delete-grn').click(function(e) {
        e.preventDefault();

        let grn_id = $(this).data('grn-id');

        if(confirm('Are you sure you want to delete this GRN?')) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Purchase/delete_grn",
                type: 'POST',
                data: { grn_id: grn_id },
                success: function(response) {
                    let res = JSON.parse(response);
                    if(res.success) {
                        alert('GRN deleted successfully.');
                        location.reload();
                    } else {
                        alert('Error: ' + res.message);
                    }
                },
                error: function() {
                    alert('An error occurred while processing the request.');
                }
            });
        }
    });
  });

  function handleKeyPress(event,row) {
	var suggestionDiv = $('#display'+row);
    var selected = suggestionDiv.find('.selected');
    var suggestions = suggestionDiv.find('.suggestion');
   
    if (event.key === "ArrowUp" || event.key === "ArrowDown"|| event.key === "Enter") {
       
        event.preventDefault();
		
        if (event.key === "ArrowUp") {
			if (selected.length === 0) {
                suggestions.eq(-1).addClass('selected');
            } else {
                var prev = selected.removeClass('selected').prev('.suggestion');
                if (prev.length > 0) {
                    prev.addClass('selected');
                } else {
                    suggestions.eq(-1).addClass('selected');
                }
            }
           // console.log("Up arrow key pressed");
        } else if (event.key === "ArrowDown") {
			
            if (selected.length === 0) {
                suggestions.eq(0).addClass('selected');
            } else {
                var next = selected.removeClass('selected').next('.suggestion');
                if (next.length > 0) {
                    next.addClass('selected');
                } else {
                    suggestions.eq(0).addClass('selected');
                }
            }
           // console.log("Down arrow key pressed");
        } else if (event.key === "Enter") {
           
			if (selected.length > 0) {
                var productName = selected.text();
                var productID = selected.data('productId');
                $('#search'+row).val(productName);
                $('#pro_id'+row).val(productID);
                suggestionDiv.hide();
                get_product_info(row);
            }
	   }
	}
	}



	function showsugg(row,event){
	var name = $('#search'+row).val();
	if(name.length > 4){
		$.ajax({
               type: "POST",
               url: "<?php echo site_url('Product/ajax_product_search'); ?>",
			   dataType: 'json',
               data: {
                   search_key: name
               },
               success: function(data) {
				
				document.getElementById('display'+row).innerHTML = '';
				var parentDiv = document.getElementById('display'+row);
                        if (data.length > 0) {
                            data.forEach(function(product){
								var option = document.createElement('div');
        						option.textContent = product.product_name;
								option.classList.add('suggestion');
								option.dataset.productId = product.product_id;
								option.addEventListener('click', function() {
            						document.getElementById('search'+row).value = product.product_name;
            						document.getElementById('pro_id'+row).value = product.product_id;
            						parentDiv.innerHTML = ''; // Clear search results
									get_product_info(row);

        						});
								parentDiv.appendChild(option);
                                
                            });
                        } 
						else {
							var option = document.createElement('div');
        					option.textContent = 'No products found';
							option.classList.add('suggestion');
							parentDiv.appendChild(option);
							
               			}
						$('#display'+row).show();
			}
           });

	}
	else{
		document.getElementById('display'+row).innerHTML = '';
	}
	
}
</script>