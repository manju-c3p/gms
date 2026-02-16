<?php 
	$page_name2='Purchase/purchase_quotation_list';
	$user = $this->session->userdata('user_id');
?>
<form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Purchase/update_purchase_quotation" autocomplete="off" enctype="multipart/form-data">
	
 
 <!-- page content -->
 <div class="form-group" role="main">
          <div class="">
            <div class="page-title"></div>
            <div class="clearfix"></div>
            <div class="x_content">
              <div class="well" style="overflow: auto">
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Select RFQ</label>
                  <div class="col-md-3">
                    <select tabindex="1" class="form-control" id="rfq_id" name="rfq_id" readonly>
                            <option value="<?php echo $records1[0]->rfq_id ?>"><?php echo $records1[0]->rfq_code;?></option>
                      
                    </select>
                  </div>
                  <label class="control-label col-md-1">Code</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="quotation_code" id="quotation_code" readonly value="<?php echo $records1[0]->quotation_code;?>">  
                    <input type="hidden" class="form-control" name="quotation_id" id="quotation_id" readonly value="<?php echo $records1[0]->quotation_id;?>"> 
                  </div>
                  <label class="control-label col-md-1">Date</label>
                  <div class="col-md-2">
                  <input type="date" class="form-control" name="quotation_date" id="quotation_date" value="<?php echo  $records1[0]->quotation_date; ?>">  </div>
                 
                </div>
                <br/><br/><br/>
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Supplier</label>
                  <div class="col-md-4 col-sm-9 col-xs-9">
                  <input type="text" readonly name="supplier_name" id="supplier_name" class="form-control" value="<?php echo $records1[0]->supplier_name;?>"/>
                  <input type="hidden" readonly name="supplier_id" id="supplier_id" class="form-control" value="<?php echo $records1[0]->supplier_id;?>" />
                
                </div>

                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Reference</label>
                  <div class="col-md-4 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="ref_no" id="ref_no" value="<?php echo $records1[0]->reference;?>">  
                  </div>
                  
                </div>

                <br/><br/><br/>
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Project Name</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="project" id="project" value="<?php echo $records1[0]->project;?>">  
                  </div>
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Doc Upload</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="file" class="form-control" name="quote_doc" id="quote_doc" >  
                    <?php if (!empty($quote_doc[0]->doc_path)) { ?>
                        <a href="<?php echo base_url('public/uploaded_documents/' . $quote_doc[0]->doc_path); ?>" target="_blank">
                            <?php echo $quote_doc[0]->doc_path; ?>
                        </a>
                    <?php } ?>

                  </div>
                </div>
              </div>
            </div>


            <div class="row col-md-12 col-sm-12" style="overflow: scroll;">
                <div class="x_content" id="rfq_items_list">
                <table class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                      <th>Product Code</th>
                      <th>Brand</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Unit</th>
                      <th>Price</th>
                      <th>Dis 1(%)</th>
                      <th>Dis</th>
                      <th>Dis 2(%)</th>
                      <th>Dis</th>
                      <th>Unit Price</th>
                      <th>Total</th>
                      
                      </tr>
                  </thead>
                  <tbody style="font-size:12px;">
                  <?php 
                  $i=5000;$up=0;$itot=0;$subtot=0;$ivat=0; foreach($records2 as $r) { ?>
                      <tr>
                      <td>
                          <input type="text" class="form-control" name="item_model[]" value="<?php echo $r->item_model; ?>"/>
                          <input type="hidden" class="form-control" name="item_id[]" value="<?php echo $r->item_id; ?>"/>
                      </td>
                      <td><input type="text" class="form-control" name="item_brand[]" value="<?php echo $r->brand; ?>"/></td>
                      <td><input type="text" class="form-control" name="item_description[]" value="<?php echo $r->item_description; ?>"/></td>
                      <td><input type="number" class="form-control qty" name="item_quantity[]" id="item_quantity<?php echo $i; ?>" value="<?php echo $r->quantity; ?>"/></td>
                      <td> 
                        <select class="form-control select2" name="item_unit[]" >
                          <option value="">Select</option>
                          <?php foreach($active_units as $unit){ ?>
                            <option <?php if ($r->unit_id == $unit->unit_id) echo 'selected'; ?> value="<?php echo $unit->unit_id ?>"><?php echo $unit->unit_name; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                                         
                      <td><input type="number" class="form-control unit_price" name="unit_price[]" step='any' id="unit_price<?php echo $i; ?>" value="<?php echo $r->price; ?>"/></td>
                      <td><input type="number" class="form-control dis_per" id="discount_per<?php echo $i; ?>" step='any' name="dis_per[]" value="<?php echo $r->dis_per; ?>"/></td>
                      <td><input type="number" class="form-control dis_amt" id="discount_amt<?php echo $i; ?>" step='any' name="dis_amt[]" value="<?php echo $r->dis_amt; ?>"/></td>
                      <td><input type="number" class="form-control dis_per2" id="discount_per2<?php echo $i; ?>" step='any' name="dis_per2[]" value="<?php echo $r->dis_per2; ?>"/></td>
                      <td><input type="number" class="form-control dis_amt2" id="discount_amt2<?php echo $i; ?>" step='any' name="dis_amt2[]" value="<?php echo $r->dis_amt2; ?>"/></td>
                      <td><input type="number" class="form-control final_unit_price" name="final_unit_price[]" step='any' id="final_unit_price<?php echo $i; ?>" value="<?php echo $r->unit_price; ?>"/></td>
                      
                      <td><input type="number" class="form-control total_price" id="total_price<?php echo $i; ?>" step='any' name="total_price[]" value="<?php echo $r->total; ?>"/></td>
                      
                      </tr>
                  <?php  $i++; } ?> 
                  </tbody>
              </table>
                        
                
              </div>
            </div>
                 
            <br><br><br><br>
            
            <div class="x_content">
                  <div class="row col-md-12 col-sm-12">
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Taxable Amount</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="sub_total" id="sub_total" value="<?php echo $records1[0]->subtotal;?>" readonly>  
                    </div>
                    <!-- <label class="control-label col-md-1 col-sm-3 col-xs-3">Discount(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_per" id="discount_per" value="<?php // echo $records1[0]->discount_percent;?>">
                    </div>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_amt" id="discount_amt" value="<?php  //echo $records1[0]->discount;?>">
                    </div> -->
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">VAT(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_per" id="vat_per" value="<?php echo $records1[0]->vat_percent;?>">
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Tax Amount</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_amount" id="vat_amount" value="<?php echo $records1[0]->vat_amt;?>">
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Grand Total</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="grand_total" id="grand_total" value="<?php echo $records1[0]->grand_total;?>">
                    </div>
                  
                </div>
                <br><br><br>
               <br><br>
              <div class="row col-md-12 col-sm-12">
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Validity</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="validity" id="validity" value="<?php echo $records1[0]->validity;?>">  
                </div>
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Payment Terms</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="payment_terms" id="payment_terms" value="<?php echo $records1[0]->payment_term;?>">  
                </div>
              </div>
              <br/><br/><br/>
              <div class="row col-md-12 col-sm-12">
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Delivery Terms</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="delivery_terms" id="delivery_terms" value="<?php echo $records1[0]->delivery_term;?>">  
                </div>
                <label class="control-label col-md-2 col-sm-3 col-xs-3">General Terms</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="general_terms" id="general_terms" value="<?php echo $records1[0]->general_term;?>">  
                </div>
              </div>
            </div>
           
           
           
            <div class="row col-md-12 col-sm-12">
              <label class="control-label col-md-2 col-sm-3 col-xs-3">Prepared By</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="sales_person" id="sales_person" value="<?php echo $records1[0]->sales_person;?>">  
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-3">Approved By</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="approved_by" id="approved_by" value="<?php echo $records1[0]->approved_by;?>">  
              </div> 
           

             
             
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
             
            </div>
            </div>

           
            <!--  -->
              </div>
            </div>
            
          </div>
        </div>

</form>
<script>
function get_enquiry_info() {
		var rfq_id = document.getElementById("rfq_id").value;

		if (rfq_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_rfq_info",
				data: { rfq_id: rfq_id },
				dataType: "json",
				success: function (msg) {
					 document.getElementById("supplier_id").value = msg.supplier_id;
					 document.getElementById("supplier_name").value = msg.supplier_code + ' ' + msg.supplier_name;
					 get_rfq_items_list(rfq_id);
				}
			});
		}
		else {
			document.getElementById("enq_code").innerHTML = '';
			document.getElementById("enq_date").value = '';
			document.getElementById("customer_id").value = '';
			document.getElementById("cust_name").value = '';

			document.getElementById('item_list_id').innerHTML = '';
		}
	}

  function get_rfq_items_list(rfq_id)
  {
    
    $.ajax({
          type: "POST",
          url:"<?php echo base_url()?>index.php/Ajax/get_rfq_items_for_quote",
          data: {rfq_id:rfq_id} ,
          success: function(msg){	       	
              document.getElementById('rfq_items_list').innerHTML=msg;
        }
    });
    
  }


  $(document).ready(function () {
    // Event listener for input changes
    $(document).on('input change', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function () {
        var row_id = $(this).closest('tr');
      
        calculateRow(row_id);
        calculateAll();
    });

    // Function to calculate row total
    function calculateRow(row_id) {
        var qty = parseFloat(row_id.find('.qty').val()) || 0;
        var price = parseFloat(row_id.find('.unit_price').val()) || 0;

        // First discount
        var disPer1 = parseFloat(row_id.find('.dis_per').val()) || 0;
        var disAmt1 = parseFloat(row_id.find('.dis_amt').val()) || 0;

        // Second discount
        var disPer2 = parseFloat(row_id.find('.dis_per2').val()) || 0;
        var disAmt2 = parseFloat(row_id.find('.dis_amt2').val()) || 0;

        var rowTotal = qty * price;

        // Apply first discount
        if (row_id.find('.dis_per').is(':focus')) {
            disAmt1 = (rowTotal * disPer1) / 100;
            row_id.find('.dis_amt').val(disAmt1.toFixed(2));
        } else if (row_id.find('.dis_amt').is(':focus')) {
            disPer1 = (rowTotal === 0) ? 0 : (disAmt1 / rowTotal) * 100;
            row_id.find('.dis_per').val(disPer1.toFixed(2));
        } else {
            disAmt1 = (rowTotal * disPer1) / 100;
            row_id.find('.dis_amt').val(disAmt1.toFixed(2));
        }

        var subtotalAfterFirstDiscount = rowTotal - disAmt1;

        // Apply second discount
        if (row_id.find('.dis_per2').is(':focus')) {
            disAmt2 = (subtotalAfterFirstDiscount * disPer2) / 100;
            row_id.find('.dis_amt2').val(disAmt2.toFixed(2));
        } else if (row_id.find('.dis_amt2').is(':focus')) {
            disPer2 = (subtotalAfterFirstDiscount === 0) ? 0 : (disAmt2 / subtotalAfterFirstDiscount) * 100;
            row_id.find('.dis_per2').val(disPer2.toFixed(2));
        } else {
            disAmt2 = (subtotalAfterFirstDiscount * disPer2) / 100;
            row_id.find('.dis_amt2').val(disAmt2.toFixed(2));
        }

        var finalRowTotal = subtotalAfterFirstDiscount - disAmt2;
        row_id.find('.total_price').val(finalRowTotal.toFixed(2));
    }

    // Function to calculate all rows total
    function calculateAll() {
        var grandTotal = 0;
        $('tbody tr').each(function () {
            var rowTotal = parseFloat($(this).find('.total_price').val()) || 0;
            grandTotal += rowTotal;
        });

        // Apply VAT
        var vatPer = parseFloat($('#vat_per').val()) || 0;
        var vatAmount = (grandTotal * vatPer) / 100;

        // Calculate grand total
        var grandTotalWithVAT = grandTotal + vatAmount;
        $('#grand_total').val(grandTotalWithVAT.toFixed(2));
    }


});




	
</script>