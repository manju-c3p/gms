   <style>
    .form-control{
      font-size:13px !important;
    }
  </style>
   <!-- page content -->
   <form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Purchase/add_grn_records" autocomplete="off" enctype="multipart/form-data">
	
          <!-- page content -->
          <div class="form-group" role="main">
          <div class="">
            <div class="page-title"></div>
            <div class="clearfix"></div>
            <div class="x_content">
              <div class="well" style="overflow: auto">
                <div class="col-md-12">
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Select PO</label>
                  <div class="col-md-3">
                    <select class="form-control" name="po_id" id="po_id" required onchange="get_po_info()">
                    <option value="">Select</option>
                        <?php foreach ($records as $s) { ?>
                            <option value="<?php echo $s->po_id ?>"><?php echo $s->po_code; ?>
                            </option>
                        <?php } ?>
                    </select>  
                  </div>
                  <label class="control-label col-md-1">GRN Code</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="grn_code" id="grn_code" readonly value="<?php echo $Code; ?>">  
                    
                  </div>
                  <label class="control-label col-md-1">GRN Date</label>
                  <div class="col-md-2">
                    <input type="date" class="form-control" data-inputmask="'mask' : '99/99/9999'" name="grn_date" id="grn_date" value="<?php echo date('Y-m-d'); ?>">
                 
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
                  <label class="control-label col-md-2 col-sm-3 col-xs-3">Select Warehouse</label>
                  <div class="col-md-4 col-sm-9 col-xs-9">
                    <select class="form-control" name="warehouse_id" id="warehouse_id">
                       <option value="">Select warehouse</option>
                        <?php foreach($warehouse_list as $g) { ?>
                          <option selected value="<?php echo $g->warehouse_id;?>"><?php echo $g->warehouse_name; ?></option>
                        <?php } ?>
                    </select>   
                  </div>

                  <label class="control-label col-md-1 col-sm-3 col-xs-3">Close PO</label>
                  <div class="col-md-2 col-sm-9 col-xs-9">
                    <select class="form-control" name="po_status" id="po_status">
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>   
                  </div>
                  
                </div>
                <br/><br/><br/>
              </div>
            </div>


                  <div class="row col-md-12 col-sm-12" style="overflow: scroll;" id="po_items_list">
                
                      
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
               
                  
            <br/></br/><br/>
              <div class="row col-md-12 col-sm-12">
                <label class="control-label col-md-2 col-sm-1 col-xs-3">Remarks</label>
                <div class="col-md-3 col-sm-9 col-xs-9">
                  <textarea class="form-control" name="remarks" id="remarks">  </textarea>
                </div>
               
             
          
              <label class="control-label col-md-1 col-sm-3 col-xs-3">Prepared By</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <input type="text" class="form-control" name="sales_person" id="sales_person" value="<?php echo $this->session->userdata('user_name');?>" readonly>  
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
       
      

        <!-- /page content -->
</form>

<script>
 
 function get_po_info() {
		var po_id = document.getElementById("po_id").value;

		if (po_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_po_info",
				data: { po_id: po_id },
				dataType: "json",
				success: function (msg) {
					 document.getElementById("supplier_id").value = msg.supplier_id;
					 document.getElementById("supplier_name").value = msg.supplier_code + ' ' + msg.supplier_name;
					 get_po_items_list(po_id);
           document.getElementById("sub_total").value = msg.subtotal;
           document.getElementById("discount_per").value = msg.discount_percent;
           document.getElementById("discount_amt").value = msg.discount;
           document.getElementById("vat_per").value = msg.vat_percent;
           document.getElementById("vat_amount").value = msg.vat_amt;
           document.getElementById("grand_total").value = msg.grand_total;
          
				}
			});
		}
		else {

			document.getElementById('po_items_list').innerHTML = '';
		}
	}

  function get_po_items_list(po_id) {
    
  $.ajax({
    type: "POST",
    url: "<?php echo base_url() ?>index.php/Ajax/get_po_items_for_grn",
    data: { po_id: po_id },
    success: function (msg) {
      document.getElementById('po_items_list').innerHTML = msg;
      // setTimeout(() => {
      //   document.querySelectorAll("img.barcode").forEach(img => {
      //     const value = img.getAttribute("data-barcode");

      //     if (value && img instanceof HTMLImageElement) {
      //       // Create a temporary canvas
      //       const canvas = document.createElement("canvas");

      //       JsBarcode(canvas, value, {
      //         format: "CODE128",
      //         width: 2,
      //         height: 40,
      //         displayValue: true
      //       });

      //       // Set barcode image source to the generated canvas data URL
      //       const pngDataUrl = canvas.toDataURL("image/png");
      //       img.src = pngDataUrl;

      //       // Save the PNG base64 to hidden input if exists
      //       const index = img.id.replace("barcode", "");
      //       const input = document.getElementById("barcode_input" + index);
      //       if (input) {
      //         input.value = pngDataUrl;
      //         console.log("Saved PNG to input:", input.id);
      //       }
      //     }
      //   });
      // }, 50);
    }
  });
}

$(document).ready(function () {
   
    $('.barcode-input').on('keypress', function (e) {
        if (e.which === 13) { 
            e.preventDefault(); 
            const next = $(this).closest('tr').next().find('.barcode-input');
            if (next.length) {
                next.focus();
            }
        }
    });

    // auto-fetch item info
    $('.barcode-input').on('change', function () {
        const scannedCode = $(this).val().trim();
        console.log("Scanned Barcode:", scannedCode);

    });
});

function handleBarcodeScan(inputElement) {
    let barcode = inputElement.value.trim();

    // Optional: check if barcode is a specific length before acting
    if (barcode.length >= 8) { // adjust as per your barcode format
        fetchSerialFromBarcode(barcode, inputElement);
    }
}

function fetchSerialFromBarcode(barcode, inputElement) {
    // Example AJAX call to PHP to get serial number
    fetch('get_serial.php?barcode=' + encodeURIComponent(barcode))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Find matching serial input next to this barcode input
                let serialInput = inputElement.closest('div').querySelector('.serial-input');
                if (serialInput) {
                    serialInput.value = data.serial;
                }
            } else {
                alert("Serial not found for barcode: " + barcode);
            }
        })
        .catch(error => {
            console.error('Error fetching serial:', error);
        });
}


// function downloadBarcode(imgId) {
//   const img = document.getElementById(imgId);

//   if (img && img instanceof HTMLImageElement && img.src.startsWith("data:image")) {
//     const link = document.createElement('a');
//     link.href = img.src;
//     link.download = imgId + '.png';  // filename
//     document.body.appendChild(link); // required for Firefox
//     link.click();
//     document.body.removeChild(link);
//   } else {
//     alert("Barcode image not found or not ready.");
//   }
// }

// function convertSvgToPng(svg, callback) {
//   const serializer = new XMLSerializer();
//   const svgString = serializer.serializeToString(svg);
//   const blob = new Blob([svgString], { type: "image/svg+xml;charset=utf-8" });
//   const url = URL.createObjectURL(blob);

//   const image = new Image();
//   image.onload = () => {
//     const canvas = document.createElement("canvas");
//     canvas.width = image.width;
//     canvas.height = image.height;
//     const ctx = canvas.getContext("2d");
//     ctx.drawImage(image, 0, 0);
//     URL.revokeObjectURL(url);

//     const pngDataUrl = canvas.toDataURL("image/png");
//     callback(pngDataUrl);
//   };
//   image.onerror = () => {
//     URL.revokeObjectURL(url);
//     console.error("Failed to load SVG image for conversion");
//   };

//   image.src = url;
// }
$(document).ready(function () {

function calculateRow($row) {
    // ordered qty (class .qty)
    const orderedQty = parseFloat($row.find('.qty').val()) || 0;

    // received qty (class .rec_quantity) - use received if provided, else ordered
    const recInput = $row.find('.rec_quantity');
    const recVal = parseFloat(recInput.val());
    const receivedQty = !isNaN(recVal) ? recVal : 0;

    const qty = (receivedQty > 0) ? receivedQty : orderedQty;

    // price
    const price = parseFloat($row.find('.unit_price').val()) || 0;

    // per-row discount (optional)
    let disPer = parseFloat($row.find('.dis_per').val()) || 0;
    let disAmt = parseFloat($row.find('.dis_amt').val()) || 0;

    // locate the error small element - prefer id="error_msg{index}" if present (your markup has that)
    let errorMsgElem = null;
    // look for a small with id error_msg{data-index}
    const dataIndex = recInput.attr('data-index');
    if (typeof dataIndex !== 'undefined') {
        const idSel = '#error_msg' + dataIndex;
        if ($(idSel).length) errorMsgElem = $(idSel);
    }
    // fallback: element with class .error-msg inside row
    if (!errorMsgElem || errorMsgElem.length === 0) {
        errorMsgElem = $row.find('.error-msg');
    }

    // Validation: received should not exceed ordered
    if (!isNaN(recVal) && recVal > orderedQty) {
        // show error message
        if (errorMsgElem.length) {
            errorMsgElem.text('❌ Received quantity cannot exceed ordered quantity.').show();
        } else {
            // insert dynamic small after rec input if no place exists
            if ($row.find('.error-msg-dyn').length === 0) {
                recInput.after('<small class="text-danger error-msg-dyn" style="display:block;">❌ Received quantity cannot exceed ordered quantity.</small>');
            } else {
                $row.find('.error-msg-dyn').show();
            }
        }
        // mark invalid visually
        recInput.addClass('is-invalid');
        return 0;
    } else {
        // hide any error messages
        if (errorMsgElem.length) errorMsgElem.hide();
        $row.find('.error-msg-dyn').hide();
        recInput.removeClass('is-invalid');
    }

    // compute row total (before per-row discount)
    const rowBase = qty * price;

    // Determine whether user is editing percent or amount (if fields present)
    const isEditingPer = $row.find('.dis_per').is(':focus');
    const isEditingAmt = $row.find('.dis_amt').is(':focus');

    if ($row.find('.dis_per').length === 0 && $row.find('.dis_amt').length === 0) {
        // no per-row discount fields -> disPer/disAmt = 0
        disPer = 0;
        disAmt = 0;
    } else {
        // if percent field exists but amount empty, compute amount
        if ($row.find('.dis_per').length && !isEditingAmt) {
            disAmt = (rowBase * (disPer || 0)) / 100;
            $row.find('.dis_amt').val(disAmt.toFixed(2));
        } else if ($row.find('.dis_amt').length && !isEditingPer) {
            // percent based on amount
            disPer = (rowBase === 0) ? 0 : ((disAmt || 0) / rowBase) * 100;
            $row.find('.dis_per').val(disPer.toFixed(2));
        }
    }

    const finalRowTotal = Math.max(0, rowBase - (disAmt || 0)); // avoid negative
    // update UI
    $row.find('.total_price').val(finalRowTotal.toFixed(2));

    return finalRowTotal;
}

function calculateAll() {
    let rowSubtotal = 0;

    // iterate only rows in tbody of your items table
    $('#datatable-responsive tbody tr').each(function () {
        const rowTotal = calculateRow($(this)) || 0;
        rowSubtotal += rowTotal;
    });

    // update subtotal field
    $('#sub_total').val(rowSubtotal.toFixed(2));

    // Global discount handling (either percent or amount)
    const isGlobalPerEditing = $('#discount_per').is(':focus');
    const isGlobalAmtEditing = $('#discount_amt').is(':focus');

    let globalDiscountPer = parseFloat($('#discount_per').val()) || 0;
    let globalDiscountAmt = parseFloat($('#discount_amt').val()) || 0;

    if (isGlobalPerEditing) {
        globalDiscountAmt = (rowSubtotal * globalDiscountPer) / 100;
        $('#discount_amt').val(globalDiscountAmt.toFixed(2));
    } else if (isGlobalAmtEditing) {
        globalDiscountPer = (rowSubtotal === 0) ? 0 : (globalDiscountAmt / rowSubtotal) * 100;
        $('#discount_per').val(globalDiscountPer.toFixed(2));
    } else {
        // neither focused: keep consistency (compute amount from percent)
        globalDiscountAmt = (rowSubtotal * globalDiscountPer) / 100;
        $('#discount_amt').val(globalDiscountAmt.toFixed(2));
    }

    const afterDiscount = Math.max(0, rowSubtotal - (globalDiscountAmt || 0));

    // VAT
    const vatPer = parseFloat($('#vat_per').val()) || 0;
    const vatAmt = (afterDiscount * vatPer) / 100;
    $('#vat_amount').val(vatAmt.toFixed(2));

    const grandTotal = afterDiscount + vatAmt;
    $('#grand_total').val(grandTotal.toFixed(2));
}
$(document).ready(function () {
    // Bind events on relevant inputs (use event delegation to support dynamic rows)
    $(document).on('input change', '#datatable-responsive tbody .rec_quantity, #datatable-responsive tbody .qty, #datatable-responsive tbody .unit_price, #datatable-responsive tbody .dis_per, #datatable-responsive tbody .dis_amt', function () {
        // calculate only that row first (for responsiveness), then totals
        const $row = $(this).closest('tr');
        calculateRow($row);
        calculateAll();
    });

    // Global discount and VAT handlers
    $(document).on('input change', '#discount_per, #discount_amt, #vat_per', function () {
        calculateAll();
    });

    // Also recalc all on page load
    calculateAll();
});
});
$(document).ready(function () {
 
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rec_quantity').forEach(function(recInput) {
        recInput.addEventListener('keyup', function () {
            const idSuffix = this.id.replace('rec_quantity', '');
            const orderedInput = document.getElementById('item_quantity' + idSuffix);
            const errorMsg = document.getElementById('error_msg' + idSuffix);

            const orderedQty = parseFloat(orderedInput?.value) || 0;
            const receivedQty = parseFloat(this.value) || 0;

            if (receivedQty > orderedQty) {
                errorMsg.textContent = "❌ Received quantity cannot be more than ordered.";
                errorMsg.style.display = "block";
                this.classList.add('is-invalid'); // Optional Bootstrap styling
            } else {
                errorMsg.textContent = "";
                errorMsg.style.display = "none";
                this.classList.remove('is-invalid');
            }
        });
    });
}); });

function test(event) {
  var input = event.target;
  var qty = parseInt(input.value);
  var index = input.getAttribute('data-index');
  var container = document.getElementById('serial_container' + index);

  console.log("Generating", qty, "serial fields for index", index);

  if (!container) {
    console.error('Serial container not found for index', index);
    return;
  }

  container.innerHTML = ''; // Clear previous inputs

  if (!isNaN(qty) && qty > 0) {
    for (let i = 0; i < qty; i++) {
      const inputEl = document.createElement('input');
      inputEl.type = 'text';
      inputEl.name = `serial[${i}][]`;
      inputEl.className = 'form-control serial-input mt-1';
      inputEl.placeholder = `Serial ${i + 1}`;
      inputEl.autocomplete = 'off';
      container.appendChild(inputEl);
    }

    // Focus on the first serial input
    const firstInput = container.querySelector('.serial-input');
    if (firstInput) firstInput.focus();
  }
}

// Handle Enter key navigation
document.addEventListener('keypress', function (e) {
  if (e.target.classList.contains('serial-input') && e.key === 'Enter') {
    e.preventDefault();

    const container = e.target.closest('.serial-container');
    const inputs = container.querySelectorAll('.serial-input');

    for (let input of inputs) {
      if (!input.value.trim()) {
        input.focus();
        break;
      }
    }
  }
});


</script>

