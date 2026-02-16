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
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Supplier</label>
                  <div class="col-md-3">
                    <select class="form-control" name="supplier_id" id="supplier_id" required >
                    <option value="">Select</option>
                        <?php foreach ($supplier_records as $s) { ?>
                            <option value="<?php echo $s->supplier_id ?>"><?php echo $s->supplier_code; ?>
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
                <br/><br/>
                <div class="col-md-12">   
                   <label class="control-label col-md-1 col-sm-3 col-xs-3">Subject</label>
                  <div class="col-md-3   col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="subject" id="subject" >  
                  </div>              
                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Reference</label>
                  <div class="col-md-3 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="ref_no" id="ref_no">  
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
                <br/><br/>
               
                <div class="col-md-12">

                <label class="control-label col-md-1 col-sm-3 col-xs-3">Project Name</label>
                  <div class="col-md-3 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="project" id="project" >  
                  </div> 
                <label class="control-label col-md-1 col-sm-3 col-xs-3">Upload File</label>
                  <div class="col-md-3 col-sm-6 col-xs-6">
                    <input type="file" class="form-control" name="po_doc" id="po_doc" >  
                  </div>
                  

                </div>
              </div>
            </div>
                 <div class="row col-md-12 col-sm-12" style="overflow: scroll;">
                    <!-- form color picker -->
                      <div class="x_content">
                      <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th width="13%">Product Code</th>
                            <th>Brand</th>
                            <th>Description</th>
                            
                            <th>Unit</th>
                           <th>Quantity</th>
                            <th>Price</th>
                            <th>Dis 1(%)</th>
                            <th>Dis</th>
                            <th>Dis 2(%)</th>
                            <th>Dis</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                <select class="form-control item-select2" name="item_id[]" id='item0' onchange='get_item_by_id(0)'>
                                    <option value=''>Select</option>
                                    <?php foreach($active_items as $item){ ?>
                                        <option value='<?php echo $item->item_id ?>'><?php echo $item->item_model; ?></option>
                                    <?php } ?>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" name="item_brand[]" id="brand0"></td>
                                <td><input class="form-control" type="text" name="item_description[]" id="description0"></td>
                                <td>
                                    <select class="form-control" name="item_unit[]" id='unit0'>
                                    <option value=''>Select</option>
                                    <?php foreach($active_units as $unit){ ?>
                                        <option value='<?php echo $unit->unit_id ?>'><?php echo $unit->unit_name; ?></option>
                                    <?php } ?>
                                    </select>
                                </td>
                                
                                <td><input class="form-control quantity" type="number" name="item_quantity[]" id="quantity0"></td>
                                 <td><input type="number" class="form-control unit_price" name="unit_price[]" step='any' id="unit_price0" /></td>
                                <td><input type="number" class="form-control dis_per" id="discount_per0" step='any' name="dis_per[]" /></td>
                                <td><input type="number" class="form-control dis_amt" id="discount_amt0" step='any' name="dis_amt[]" /></td>
                                <td><input type="number" class="form-control dis_per2" id="discount_per20" step='any' name="dis_per2[]" /></td>
                                <td><input type="number" class="form-control dis_amt2" id="discount_amt20" step='any' name="dis_amt2[]" /></td>
                                <td><input type="number" class="form-control final_unit_price" name="final_unit_price[]" step='any' id="final_unit_price0" /></td>
                                <td><input type="number" class="form-control total_price" id="total_price0" step='any' name="total_price[]" /></td>      
                                <td>
                                     <a href="#" class="addRow" title="Add"><i class="fa fa-plus-circle text-success"></i></a>
                                     <a href="#" class="deleteRow" title="Delete"><i class="fa fa-trash text-danger"></i></a>              
                                </td>
                            </tr>
                        </tbody>
                        </table>
                      
                    </div>
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
 $(document).ready(function () {
    let rowIndex = 1; // Start from 1 because the first row uses index 0

    // Add new row
    $(document).on('click', '.addRow', function (e) {
        e.preventDefault();

        const newRow = `
            <tr>
                <td>
                    <select class="form-control item-select2" name="item_id[]" id="item${rowIndex}" onchange="get_item_by_id(${rowIndex})">
                        <option value="">Select</option>
                        <?php foreach($active_items as $item){ ?>
                            <option value="<?php echo $item->item_id ?>"><?php echo $item->item_model; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input class="form-control" type="text" name="item_brand[]" id="brand${rowIndex}"></td>
                <td><input class="form-control" type="text" name="item_description[]" id="description${rowIndex}"></td>
                <td>
                    <select class="form-control" name="item_unit[]" id="unit${rowIndex}">
                        <option value="">Select</option>
                        <?php foreach($active_units as $unit){ ?>
                            <option value="<?php echo $unit->unit_id ?>"><?php echo $unit->unit_name; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input class="form-control quantity" type="number" name="item_quantity[]" id="quantity${rowIndex}"></td>
                <td><input type="number" class="form-control unit_price" name="unit_price[]" step="any" id="unit_price${rowIndex}" /></td>
                <td><input type="number" class="form-control dis_per" name="dis_per[]" step="any" id="discount_per${rowIndex}" /></td>
                <td><input type="number" class="form-control dis_amt" name="dis_amt[]" step="any" id="discount_amt${rowIndex}" /></td>
                <td><input type="number" class="form-control dis_per2" name="dis_per2[]" step="any" id="discount_per2${rowIndex}" /></td>
                <td><input type="number" class="form-control dis_amt2" name="dis_amt2[]" step="any" id="discount_amt2${rowIndex}" /></td>
                <td><input type="number" class="form-control final_unit_price" name="final_unit_price[]" step="any" id="final_unit_price${rowIndex}" /></td>
                <td><input type="number" class="form-control total_price" name="total_price[]" step="any" id="total_pric${rowIndex}" /></td>
                <td>
                <a href="#" class="addRow" title="Add"><i class="fa fa-plus-circle text-success"></i></a>
                <a href="#" class="deleteRow" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                  
                </td>
            </tr>`;

        $('#datatable-responsive tbody').append(newRow);

        // Reinitialize select2 for new row
        $(`#item${rowIndex}`).select2();
        rowIndex++;
    });

    // Delete row
    $(document).on('click', '.deleteRow', function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });

// Event listener for row-level changes
$(document).on('input change', '.quantity, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function () {
    var $row = $(this).closest('tr');
    calculateRow($row);
    calculateAll();
});

// Event listener for global discount and VAT
$('#discount_per, #discount_amt, #vat_per').on('input change', function () {
    calculateAll();
});

function calculateRow($row) {
    let qty = parseFloat($row.find('.quantity').val()) || 0;
    let unitPrice = parseFloat($row.find('.unit_price').val()) || 0;

    let disPer1 = parseFloat($row.find('.dis_per').val()) || 0;
    let disAmt1 = parseFloat($row.find('.dis_amt').val()) || 0;

    let disPer2 = parseFloat($row.find('.dis_per2').val()) || 0;
    let disAmt2 = parseFloat($row.find('.dis_amt2').val()) || 0;

    let rowTotal = qty * unitPrice;

    // First Discount
    if ($row.find('.dis_per').is(':focus')) {
        disAmt1 = (rowTotal * disPer1) / 100;
        $row.find('.dis_amt').val(disAmt1.toFixed(2));
    } else if ($row.find('.dis_amt').is(':focus')) {
        disPer1 = (rowTotal === 0) ? 0 : (disAmt1 / rowTotal) * 100;
        $row.find('.dis_per').val(disPer1.toFixed(2));
    } else {
        disAmt1 = (rowTotal * disPer1) / 100;
        $row.find('.dis_amt').val(disAmt1.toFixed(2));
    }

    let subtotalAfterFirst = rowTotal - disAmt1;

    // Second Discount
    if ($row.find('.dis_per2').is(':focus')) {
        disAmt2 = (subtotalAfterFirst * disPer2) / 100;
        $row.find('.dis_amt2').val(disAmt2.toFixed(2));
    } else if ($row.find('.dis_amt2').is(':focus')) {
        disPer2 = (subtotalAfterFirst === 0) ? 0 : (disAmt2 / subtotalAfterFirst) * 100;
        $row.find('.dis_per2').val(disPer2.toFixed(2));
    } else {
        disAmt2 = (subtotalAfterFirst * disPer2) / 100;
        $row.find('.dis_amt2').val(disAmt2.toFixed(2));
    }

    let finalRowTotal = subtotalAfterFirst - disAmt2;

    // Final Unit Price
    let finalUnitPrice = (qty > 0) ? finalRowTotal / qty : 0;
    $row.find('.final_unit_price').val(finalUnitPrice.toFixed(2));

    // Total Price
    $row.find('.total_price').val(finalRowTotal.toFixed(2));
}

function calculateAll() {
    let subtotal = 0;

    // Sum total from all rows
    $('tbody tr').each(function () {
        subtotal += parseFloat($(this).find('.total_price').val()) || 0;
    });

    $('#sub_total').val(subtotal.toFixed(2));

    // Global Discount
    let discountPer = parseFloat($('#discount_per').val()) || 0;
    let discountAmt = parseFloat($('#discount_amt').val()) || 0;

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

    let afterDiscount = subtotal - discountAmt;

    // VAT Calculation
    let vatPer = parseFloat($('#vat_per').val()) || 0;
    let vatAmt = (afterDiscount * vatPer) / 100;
    $('#vat_amount').val(vatAmt.toFixed(2));

    let grandTotal = afterDiscount + vatAmt;
    $('#grand_total').val(grandTotal.toFixed(2));
}

});

function get_item_by_id(row_no){
        var item_id = $('#item'+row_no).val();
        if(item_id != ''){
            $.ajax({
                url: '<?= base_url("index.php/Item/get_item_by_id") ?>', // update with your controller path
                type: 'POST',
                data: { item_id: item_id },
                dataType:"json",
                success: function(response) {
                 
                    $('#brand'+row_no).val(response.brand_name);
                    $('#description'+row_no).val(response.item_description);
                    $('#unit'+row_no).val(response.item_unit).change();
                    $('#actual_price'+row_no).val(response.mrp_aed);
                    $('#unit'+row_no).prop('required',true);
                    $('#quantity'+row_no).prop('required',true);
                    $('#actual_price'+row_no).prop('required',true);
                    $('#quantity'+row_no).prop('required',true);
                    // var nextRow = document.getElementById('addr'+row_no).nextElementSibling;
                    
                    // if(!nextRow ) 
                    //     add_row();
                    
                }
            });
        }
        else{
            $('#brand'+row_no).text('');
            $('#description'+row_no).text('');
            $('#unit'+row_no).val('').change();
            $('#actual_price'+row_no).val('');
            $('#unit'+row_no).prop('required',false);
            $('#quantity'+row_no).prop('required',false);
            $('#actual_price'+row_no).prop('required',false);
            $('#quantity'+row_no).prop('required',false);
        }
    }
</script>