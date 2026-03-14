<style>
.form-control{
  font-size:12px;
}
</style>

<form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Purchase/add_purchase_quotation_records" autocomplete="off" enctype="multipart/form-data">
	
 
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
                    <select tabindex="1" class="form-control" id="rfq_id" name="rfq_id" required onchange="get_enquiry_info()">
                        <option value="">Select</option>
                        <?php foreach ($records as $s) { ?>
                            <option value="<?php echo $s->rfq_id ?>"><?php echo $s->rfq_code; ?>
                            </option>
                        <?php } ?>
                    </select>
                  </div>
                  <label class="control-label col-md-1">Code</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="quotation_code" id="quotation_code" readonly value="<?php echo $Code; ?>">  
                    
                  </div>
                  <label class="control-label col-md-1">Date</label>
                  <div class="col-md-2">
                    <input type="date" class="form-control" data-inputmask="'mask' : '99/99/9999'" name="quotation_date" id="quotation_date" value="<?php echo date('Y-m-d'); ?>">
                  </div>
                 
                </div>
                <br/><br/><br/>
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Supplier</label>
                  <div class="col-md-4 col-sm-9 col-xs-9">
                  <input type="text" readonly name="supplier_name" id="supplier_name" class="form-control" />
                  <input type="hidden" readonly name="supplier_id" id="supplier_id" class="form-control" />
                
                </div>

                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Reference</label>
                  <div class="col-md-4 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="ref_no" id="ref_no">  
                  </div>
                  
                </div>

                <br/><br/><br/>
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Project Name</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="project" id="project"  >  
                  </div>
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Upload Document</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="file" class="form-control" name="quote_doc" id="quote_doc" >  
                  </div>
                </div>
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">RFQ Created By</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="rfq_by" id="rfq_by">  
                  </div>
                
                </div>
              </div>
            </div>


            <div class="row col-md-12 col-sm-12" style="overflow: scroll;">
                <div class="x_content" id="rfq_items_list">
                    
                
              </div>
            </div>
                 
            <br><br><br><br>
            
            <div class="x_content">
                  <div class="row col-md-12 col-sm-12">
                    <label class="control-label col-md-2 col-sm-3 col-xs-3">Taxable Amount</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="sub_total" id="sub_total" readonly>  
                    </div>
                    <!-- <label class="control-label col-md-1 col-sm-3 col-xs-3">Discount(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_per" id="discount_per" >
                    </div>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_amt" id="discount_amt" >
                    </div> -->
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">VAT(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_per" id="vat_per" value="5">
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Tax Amount</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_amount" id="vat_amount" >
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Grand Total</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="grand_total" id="grand_total">
                    </div>
                  
                </div>
                <br><br><br>
               <br><br>
              <div class="row col-md-12 col-sm-12">
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Validity</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="validity" id="validity">  
                </div>
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Payment Terms</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="payment_terms" id="payment_terms">  
                </div>
              </div>
              <br/><br/><br/>
              <div class="row col-md-12 col-sm-12">
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Delivery Terms</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="delivery_terms" id="delivery_terms">  
                </div>
                <label class="control-label col-md-2 col-sm-3 col-xs-3">General Terms</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <input type="text" class="form-control" name="general_terms" id="general_terms">  
                </div>
              </div>
            </div>
           
           
           
            <div class="row col-md-12 col-sm-12">
              <label class="control-label col-md-2 col-sm-3 col-xs-3">Prepared By</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="sales_person" id="sales_person" value="<?php echo $this->session->userdata('user_name'); ?>">  
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-3">Approved By</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="approved_by" id="approved_by">  
              </div> 
           

             
             
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success">Submit</button>
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
           document.getElementById("rfq_by").value = msg.rfq_created_by;
           document.getElementById("project").value = msg.project;
           document.getElementById("ref_no").value = msg.ref;
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

 function get_rfq_items_list(rfq_id) {
    $.ajax({
        type: "POST",
        url:"<?php echo base_url()?>index.php/Ajax/get_rfq_items_for_quote",
        data: { rfq_id: rfq_id },
        success: function(msg){	       	
            $('#rfq_items_list').html(msg);
            $('.select2').select2(); 

            // Calculate each row immediately
            $('#rfq_items_list').find('tr').each(function() {
                calculateRow($(this));
            });

            // Then calculate totals
            calculateAll();
        }
    });
}


function calculateRow($row) {
    var qty = parseFloat($row.find('.qty').val()) || 0;
    var price = parseFloat($row.find('.unit_price').val()) || 0;

    var disPer1 = parseFloat($row.find('.dis_per').val()) || 0;
    var disAmt1 = (qty * price * disPer1) / 100;
    $row.find('.dis_amt').val(disAmt1.toFixed(2));

    var subtotalAfterFirst = qty * price - disAmt1;

    var disPer2 = parseFloat($row.find('.dis_per2').val()) || 0;
    var disAmt2 = (subtotalAfterFirst * disPer2) / 100;
    $row.find('.dis_amt2').val(disAmt2.toFixed(2));

    var finalRowTotal = subtotalAfterFirst - disAmt2;

    var finalUnitPrice = qty > 0 ? finalRowTotal / qty : 0;
    $row.find('.final_unit_price').val(finalUnitPrice.toFixed(2));

    $row.find('.total_price').val(finalRowTotal.toFixed(2));
}


  $(document).ready(function () {
    // Event listener for input changes

  $(document).on('input change keyup', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function (e) {

    var $row = $(this).closest('tr');
    calculateRow($row);
    calculateAll();
});


    





    

    // Recalculate when VAT changes
    $('#vat_per').on('input change', function () {
        calculateAll();
    });
});
function calculateAll() {
    var total = 0;
    $('#rfq_items_list').find('tr').each(function() {
        var rowTotal = parseFloat($(this).find('.total_price').val()) || 0;
        total += rowTotal;
    });

    $('#sub_total').val(total.toFixed(2));

    var vatPer = parseFloat($('#vat_per').val()) || 0;
    var vatAmount = (total * vatPer) / 100;
    $('#vat_amount').val(vatAmount.toFixed(2));

    $('#grand_total').val((total + vatAmount).toFixed(2));
}


</script>
