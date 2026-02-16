   <!-- page content -->
   <form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Purchase/add_po_records" autocomplete="off" enctype="multipart/form-data">
	
          <!-- page content -->
          <div class="form-group" role="main">
          <div class="">
            <div class="page-title">
             
  </div>
            <div class="clearfix"></div>

            <div class="x_content">



              <div class="well" style="overflow: auto">
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Select Quotation</label>
                  <div class="col-md-3">
                    <select class="form-control" name="quotation_id" id="quotation_id" required onchange="get_quotation_info()">
                    <option value="">Select</option>
                        <?php foreach ($records as $s) { ?>
                            <option value="<?php echo $s->quotation_id ?>"><?php echo $s->quotation_code; ?>
                            </option>
                        <?php } ?>
                    </select>  
                  </div>
                  <label class="control-label col-md-1">PO Code</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="po_code" id="po_code" readonly value="<?php echo $Code; ?>">  
                    
                  </div>
                  <label class="control-label col-md-1">PO Date</label>
                  <div class="col-md-2">
                    <input type="date" class="form-control" data-inputmask="'mask' : '99/99/9999'" name="po_date" id="po_date" value="<?php echo date('Y-m-d'); ?>">
                 
                  </div>
                 
                </div>
                <br/><br/><br/>
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Supplier</label>
                  <div class="col-md-7 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="supplier_name" id="supplier_name" readonly> 
                    <input type="hidden" class="form-control" name="supplier_id" id="supplier_id" > 
                  </div>
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Reference</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="ref_no" id="ref_no">  
                  </div>
                 
                  
                </div>
                <br/><br/><br/>
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Subject</label>
                  <div class="col-md-7 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="subject" id="subject" >  
                  </div>
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Freight Mode</label>
                  <div class="col-md-2 col-sm-2 col-xs-2">
                    <select class="form-control" name="freight_mode" id="freight_mode" > 
                          <option value=""></option>
                          <option value="Sea">Sea</option>
                          <option value="Air">Air</option>
                          <option value="Road">Road</option>
                          <option value="Courier">Courier</option>
                    </select>
                  </div>

                </div>
                <br/><br/><br/>
                <div class="col-md-12">
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Upload Document</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="file" class="form-control" name="po_doc" id="po_doc" >  
                  </div>
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Project Name</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="project" id="project" readonly >  
                  </div> 

                </div>
              </div>
            </div>


                  <div class="row col-md-12 col-sm-12" style="overflow: scroll;" id="quote_items_list">
                
                      
                    </div>
                 
                 
            <br><br><br><br>
            
            <div class="x_content">
                  <div class="row col-md-12 col-sm-12">
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Sub Total</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="sub_total" id="sub_total" readonly>  
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Discount(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_per" id="discount_per" >
                    </div>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_amt" id="discount_amt" >
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">VAT(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_per" id="vat_per">
                    </div>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_amount" id="vat_amount" >
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Grand Total</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="grand_total" id="grand_total">
                    </div>
                  
                </div>
                <br><br><br>
                <div class="row col-md-12 col-sm-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Transportation Charge</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <input type="number" class="form-control" name="transportation_charge" id="transportation_charge">  
                  </div>
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Freight Charge</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <input type="number" class="form-control" name="customs_charge" id="customs_charge" >
                  </div>
                  
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Other Charges</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <input type="number" class="form-control" name="other_charge" id="other_charge">
                  </div>
                  
                
              </div><br><br><br>
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
                <input type="text" class="form-control" name="sales_person" id="sales_person">  
              </div>
              <label class="control-label col-md-2 col-sm-3 col-xs-3">Approved By</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="approved_by" id="approved_by">  
              </div> 
           

             
             
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary">Cancel</button>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
             
            </div>
            </div>
           

           
            <!--  -->
              </div>
            </div>
            
          </div>
        </div>
       
      

        <!-- /page content -->
</form>
<script>
 function get_quotation_info() {
		var quotation_id = document.getElementById("quotation_id").value;

		if (quotation_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_quote_info",
				data: { quotation_id: quotation_id },
				dataType: "json",
				success: function (msg) {
					 document.getElementById("supplier_id").value = msg.supplier_id;
					 document.getElementById("supplier_name").value = msg.supplier_code + ' ' + msg.supplier_name;
           document.getElementById("ref_no").value=msg.reference;
           document.getElementById("project").value=msg.project;
					 get_quote_items_list(quotation_id);
           document.getElementById("sub_total").value = msg.subtotal;
           document.getElementById("discount_per").value = msg.discount_percent;
           document.getElementById("discount_amt").value = msg.discount;
           document.getElementById("vat_per").value = msg.vat_percent;
           document.getElementById("vat_amount").value = msg.vat_amt;
           document.getElementById("grand_total").value = msg.grand_total;
           document.getElementById("validity").value = msg.validity;
           document.getElementById("payment_terms").value = msg.payment_term;
           document.getElementById("delivery_terms").value = msg.delivery_term;
           document.getElementById("general_terms").value = msg.general_term;
				}
			});
		}
		else {

			document.getElementById('quote_items_list').innerHTML = '';
		}
	}

  function get_quote_items_list(quotation_id)
  {
    
    $.ajax({
          type: "POST",
          url:"<?php echo base_url()?>index.php/Ajax/get_quote_items_for_po",
          data: {quotation_id:quotation_id} ,
          success: function(msg){	       	
              document.getElementById('quote_items_list').innerHTML=msg;
        }
    });
    
  }
  $(document).ready(function () {
    // Event listener for row-level changes
    $(document).on('input change', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function () {
        var $row = $(this).closest('tr');
        calculateRow($row);
        calculateAll();
    });

      // Event listener for global discount, VAT, and extra charges
    $('#discount_per, #discount_amt, #vat_per, #transportation_charge, #customs_charge, #other_charge').on('input change', function () {
        calculateAll();
    });

    function calculateRow($row) {
        var qty = parseFloat($row.find('.qty').val()) || 0;
        var price = parseFloat($row.find('.unit_price').val()) || 0;

        var disPer1 = parseFloat($row.find('.dis_per').val()) || 0;
        var disAmt1 = parseFloat($row.find('.dis_amt').val()) || 0;

        var disPer2 = parseFloat($row.find('.dis_per2').val()) || 0;
        var disAmt2 = parseFloat($row.find('.dis_amt2').val()) || 0;

        var rowTotal = qty * price;

        // First Discount
        if ($row.find('.dis_per').is(':focus')) {
            disAmt1 = (rowTotal * disPer1) / 100;
            $row.find('.dis_amt').val(disAmt1.toFixed(2));
        } else if ($row.find('.dis_amt').is(':focus')) {
            disPer1 = rowTotal === 0 ? 0 : (disAmt1 / rowTotal) * 100;
            $row.find('.dis_per').val(disPer1.toFixed(2));
        } else {
            disAmt1 = (rowTotal * disPer1) / 100;
            $row.find('.dis_amt').val(disAmt1.toFixed(2));
        }

        var subtotalAfterFirst = rowTotal - disAmt1;

        // Second Discount
        if ($row.find('.dis_per2').is(':focus')) {
            disAmt2 = (subtotalAfterFirst * disPer2) / 100;
            $row.find('.dis_amt2').val(disAmt2.toFixed(2));
        } else if ($row.find('.dis_amt2').is(':focus')) {
            disPer2 = subtotalAfterFirst === 0 ? 0 : (disAmt2 / subtotalAfterFirst) * 100;
            $row.find('.dis_per2').val(disPer2.toFixed(2));
        } else {
            disAmt2 = (subtotalAfterFirst * disPer2) / 100;
            $row.find('.dis_amt2').val(disAmt2.toFixed(2));
        }

        var finalRowTotal = subtotalAfterFirst - disAmt2;

        // Final Unit Price
        var finalUnitPrice = (qty > 0) ? finalRowTotal / qty : 0;
        $row.find('.final_unit_price').val(finalUnitPrice.toFixed(2));

        $row.find('.total_price').val(finalRowTotal.toFixed(2));
    }

    function calculateAll() {
        var subtotal = 0;

        // Calculate subtotal from all rows
        $('tbody tr').each(function () {
            subtotal += parseFloat($(this).find('.total_price').val()) || 0;
        });

        $('#sub_total').val(subtotal.toFixed(2));

        // ----- Global Discount -----
        var discountPer = parseFloat($('#discount_per').val()) || 0;
        var discountAmt = parseFloat($('#discount_amt').val()) || 0;

        if ($('#discount_per').is(':focus')) {
            discountAmt = (subtotal * discountPer) / 100;
            $('#discount_amt').val(discountAmt.toFixed(2));
        } else if ($('#discount_amt').is(':focus')) {
            discountPer = (subtotal === 0) ? 0 : (discountAmt / subtotal) * 100;
            $('#discount_per').val(discountPer.toFixed(2));
        } else {
            discountAmt = (subtotal * discountPer) / 100;
            $('#discount_amt').val(discountAmt.toFixed(2));
        }

        var afterDiscount = subtotal - discountAmt;

        // ----- VAT -----
        var vatPer = parseFloat($('#vat_per').val()) || 0;
        var vatAmt = (afterDiscount * vatPer) / 100;
        $('#vat_amount').val(vatAmt.toFixed(2));

        var grandTotal = afterDiscount + vatAmt;

        // ----- Additional Charges -----
        var transportCharge = parseFloat($('#transportation_charge').val()) || 0;
        var freightCharge = parseFloat($('#customs_charge').val()) || 0;
        var otherCharge = parseFloat($('#other_charge').val()) || 0;

        grandTotal += transportCharge + freightCharge + otherCharge;

        // Update Grand Total
        $('#grand_total').val(grandTotal.toFixed(2));
    }
});



</script>