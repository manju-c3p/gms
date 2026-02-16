<?php 
	$page_name2='Purchase/purchase_order_list';
	$user = $this->session->userdata('user_id');
?>
   <form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Purchase/update_purchase_order" autocomplete="off" enctype="multipart/form-data">
	
          <!-- page content -->
          <div class="form-group" role="main">
          <div class="">
            <div class="page-title">
             </div>
            <div class="clearfix"></div>

            <div class="x_content">



              <div class="well" style="overflow: auto">
                <div class="col-md-12">
                   <label class="control-label col-md-1 col-sm-3 col-xs-3">Supplier</label>
                  <div class="col-md-3">
                    <select class="form-control" name="supplier_id" id="supplier_id" required >
                    <option value="">Select</option>
                        <?php foreach ($supplier_records as $s) { ?>
                            <option <?php if($records1[0]->supplier_id == $s->supplier_id) echo 'selected' ?> value="<?php echo $s->supplier_id ?>"><?php echo $s->supplier_code; ?>
                            </option>
                        <?php } ?>
                    </select>  
                  </div>
                  <label class="control-label col-md-1">PO Code</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="po_code" id="po_code" readonly value="<?php echo $records1[0]->po_code;?>">  
                    <input type="hidden" class="form-control" name="po_id" id="po_id" readonly value="<?php echo $records1[0]->po_id;?>">  
                    
                  </div>
                  <label class="control-label col-md-1">PO Date</label>
                  <div class="col-md-2">
                    <input type="date" class="form-control" name="po_date" id="po_date" value="<?php echo $records1[0]->po_date; ?>">
                 
                  </div>
                 
                </div>
                <br/><br/><br/>
                <div class="col-md-12">   
                   <label class="control-label col-md-1 col-sm-3 col-xs-3">Subject</label>
                  <div class="col-md-3   col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="subject" id="subject" value="<?php echo $records1[0]->subject; ?>">  
                  </div>              
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Reference</label>
                  <div class="col-md-3 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="ref_no" id="ref_no" value="<?php echo $records1[0]->supplier_ref; ?>">  
                  </div>
                     
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Freight Mode</label>
                  <div class="col-md-2 col-sm-2 col-xs-2">
                    <select class="form-control" name="freight_mode" id="freight_mode" > 
                          <option <?php if ($records1[0]->freight_mode=="Sea") echo "selected" ?> value="Sea">Sea</option>
                          <option <?php if ($records1[0]->freight_mode=="Air") echo "selected" ?> value="Air">Air</option>
                          <option <?php if ($records1[0]->freight_mode=="Road") echo "selected" ?> value="Road">Road</option>
                          <option <?php if ($records1[0]->freight_mode=="Courier") echo "selected" ?> value="Courier">Courier</option>
                    </select>
                  </div>             
                </div>
               
                <br/><br/><br/>
                <div class="col-md-12">
                <label class="control-label col-md-2 col-sm-3 col-xs-3">Upload Document</label>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                    <input type="file" class="form-control" name="po_doc" id="po_doc" >  
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-6">
                  <?php if (!empty($po_doc[0]->doc_path)) { ?>
                        <a href="<?php echo base_url('public/uploaded_documents/' . $po_doc[0]->doc_path); ?>" target="_blank">
                            <?php echo $po_doc[0]->doc_path; ?>
                        </a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>


            <div class="row col-md-12 col-sm-12" style="overflow: scroll;">
                <div class="x_content" id="rfq_items_list">
                <table id="item_table" class="table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
                  <tbody>
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
                        <select class="form-control" name="item_unit[]">
                           <option value=''>Select</option>
                            <?php foreach($active_units as $unit){ ?>
                                <option <?php if ($r->unit_id == $unit->unit_id) echo 'selected'; ?> value='<?php echo $unit->unit_id ?>'><?php echo $unit->unit_name; ?></option>
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
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Sub Total</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="sub_total" id="sub_total" value="<?php echo $records1[0]->sub_total;?>" readonly>  
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Discount(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_per" id="discount_per" value="<?php echo $records1[0]->discount_percent;?>">
                    </div>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="discount_amt" id="discount_amt" value="<?php echo $records1[0]->discount;?>">
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">VAT(%)</label>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_per" id="vat_per" value="<?php echo $records1[0]->vat_percent;?>">
                    </div>
                    <div class="col-md-1 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="vat_amount" id="vat_amount" value="<?php echo $records1[0]->vat_amt;?>">
                    </div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-3">Grand Total</label>
                    <div class="col-md-2 col-sm-9 col-xs-9">
                      <input type="text" class="form-control" name="grand_total" id="grand_total" value="<?php echo $records1[0]->grand_total;?>">
                    </div>
                  
                </div>
                <br><br><br>
                <div class="row col-md-12 col-sm-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Transportation Charge</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <input type="number" class="form-control" name="transportation_charge" id="transportation_charge" value="<?php echo $records1[0]->trans_charge;?>">  
                  </div>
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Freight Charge</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <input type="number" class="form-control" name="customs_charge" id="customs_charge" value="<?php echo $records1[0]->cust_charge;?>">
                  </div>
                  
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Other Charges</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <input type="number" class="form-control" name="other_charge" id="other_charge" value="<?php echo $records1[0]->add_charge;?>">
                  </div>
                  
                
              </div><br><br><br>
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
                <input type="text" class="form-control" name="sales_person" id="sales_person">  
              </div>
               <label class="control-label col-md-2 col-sm-3 col-xs-3">Requested By</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="request_by" id="request_by" value="<?php echo $records1[0]->request_by;?>">  
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
  $(document).ready(function () {
    // Event listener for input changes
    $(document).on('input change', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function () {
        var row_id = $(this).closest('tr');
      
        calculateRow(row_id);
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