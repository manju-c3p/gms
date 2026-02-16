   <!-- page content -->
   <form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>Purchase/update_rfq" autocomplete="off" enctype="multipart/form-data">
	
        <div class="form-group" role="main">
          <div class="">
            <div class="page-title"></div>
             

            <div class="clearfix"></div>

            <div class="x_content">


              <div class="well" style="overflow: auto">
                <div class="col-md-6">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3">RFQ Code</label>
                  <div class="col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="rfq_code" id="rfq_code" readonly value="<?php echo $records1[0]->rfq_code;?>">  
                    <input type="hidden" class="form-control" name="rfq_id" id="rfq_id" value="<?php echo $records1[0]->rfq_id;?>">  
                    
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3">RFQ Date</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="date" class="form-control" data-inputmask="'mask' : '99/99/9999'" tabindex="1" name="rfq_date" id="rfq_date" value="<?php echo $records1[0]->rfq_date; ?>">
                  </div>
                </div>
               <br/> <br/> <br/>
                <div class="col-md-6">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3">Select Supplier</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                  <select name="supplier_id" id="supplier_id" class="form-control" required tabindex="2">             
                    <?php foreach($supplier_records as $g) { ?>
                        <option <?php if($g->supplier_id==$records1[0]->supplier_id) echo 'selected'; ?> value="<?php echo $g->supplier_id;?>" ><?php echo $g->supplier_code.' '.$g->supplier_name; ?> </option>
                        <?php } ?>
                    </select>  
                  </div>
                 
                </div>
               
                <div class="col-md-6">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3">Subject</label>
                  <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" class="form-control" name="subject" id="subject" value="<?php echo $records1[0]->subject; ?>">  
                  </div>
                 
                </div>
               <br/> <br/> <br/>
                 <div class="col-md-6">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3">Project Name</label>
                    <div class="col-md-9 col-sm-6 col-xs-6">
                      <input type="text" class="form-control" name="project" id="project" value="<?php echo $records1[0]->project; ?>">  
                    </div>
                </div>
                <div class="col-md-6">
                  <label class="control-label col-md-3 col-sm-3 col-xs-3">Reference</label>
                  <div class="col-md-9 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="ref" id="ref" value="<?php echo $records1[0]->ref; ?>">  
                  </div>
                </div>
               
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
                            <th>Product Code</th>
                            <th>Brand</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $i = 5000;
                            foreach($records2 as $r) { ?>
                              <tr>
                                <td>
                                  <select class="form-control select2" name="item[]" id="item<?php echo $i; ?>" onchange="get_item_by_id(<?php echo $i; ?>)">
                                    <?php foreach ($active_items as $item) { ?>
                                      <option value="<?php echo $item->item_id; ?>" <?php if ($r->product_id == $item->item_id) echo 'selected'; ?>>
                                        <?php echo $item->item_model; ?>
                                      </option>
                                    <?php } ?>
                                  </select>
                                </td>
                                <td><input class="form-control" type="text" name="brand[]" id="brand<?php echo $i; ?>" value="<?php echo $r->brand; ?>"></td>
                                <td><input class="form-control" type="text" name="description[]" id="description<?php echo $i; ?>" value="<?php echo $r->prod_desc; ?>"></td>
                                <td>
                                  <select class="form-control select2" name="unit[]" id="unit<?php echo $i; ?>">
                                    <option value="">Select</option>
                                    <?php foreach($active_units as $unit){ ?>
                                      <option <?php if ($r->unit == $unit->unit_id) echo 'selected'; ?> value="<?php echo $unit->unit_id ?>"><?php echo $unit->unit_name; ?></option>
                                    <?php } ?>
                                  </select>
                                </td>
                                <td><input class="form-control" type="number" name="quantity[]" id="quantity<?php echo $i; ?>" value="<?php echo $r->quantity; ?>"></td>
                                <td>
                                  <button type="button" class="addRow"><i class="fa fa-plus"></i></button>
                                  <button type="button" class="deleteRow"><i class="fa fa-search-minus"></i></button>
                                </td>
                              </tr>
                          <?php } ?>
                        </tbody>
                      </table>

                      
                    </div>
                  </div>
                 
            <br><br><br><br><br><br><br><br><br>
            <div class="x_content well">
           
           
            <div class="row col-md-12 col-sm-12">
            
              <label class="control-label col-md-2 col-sm-3 col-xs-3">Remarks</label>
              <div class="col-md-3 col-sm-9 col-xs-9">
                <textarea class="form-control" name="remarks" id="remarks"> <?php echo $records1[0]->remark; ?> </textarea>
              </div>
            </div> 
            <div class="row col-md-12 col-sm-12">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
  $(document).ready(function() {
    // Completely destroy any automatic DataTable initialization
    if ($.fn.DataTable.isDataTable('#datatable-responsive')) {
        $('#datatable-responsive').DataTable().destroy();
    }

    // Reinitialize manually WITHOUT pagination, search, or info
    $('#datatable-responsive').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        lengthChange: false,
        autoWidth: false,
        bSort: false,
        dom: 't' // this hides all DataTables controls (pagination, search bar, etc.)
    });
});
  function initializeSelect2(selectElement) {
    selectElement.select2({
      
    });
  }

  $(document).ready(function () {
    initializeSelect2($('.select2'));
  });

    // Row index base for unique IDs
    let rowIndexBase = Date.now();
    const getNextIndex = (() => {
        let counter = 0;
        return () => rowIndexBase + (++counter);
    })();

    // ADD ROW
    $(document).on('click', '.addRow', function(e) {
        e.preventDefault();
        const idx = getNextIndex();

        const newRow = `
            <tr>
                <td>
                    <select class="form-control select2" name="item[]" id="item${idx}" onchange="get_item_by_id(${idx})">
                        <option value="">Select</option>
                        <?php foreach($active_items as $item){ ?>
                            <option value="<?php echo $item->item_id ?>"><?php echo $item->item_model; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input class="form-control" type="text" name="brand[]" id="brand${idx}"></td>
                <td><input class="form-control" type="text" name="description[]" id="description${idx}"></td>
                <td>
                    <select class="form-control select2" name="unit[]" id="unit${idx}">
                        <option value="">Select</option>
                        <?php foreach($active_units as $unit){ ?>
                            <option value="<?php echo $unit->unit_id ?>"><?php echo $unit->unit_name; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input class="form-control" type="number" name="quantity[]" id="quantity${idx}"></td>
                <td>
                    <button type="button" class="addRow"><i class="fa fa-plus"></i></button>
                    <button type="button" class="deleteRow"><i class="fa fa-search-minus"></i></button>
                </td>
            </tr>
        `;

        $('#datatable-responsive tbody').append(newRow);

        // Reinitialize select2 for the new row
        $(`#item${idx}`).select2();
        $(`#unit${idx}`).select2();
    });

    // DELETE ROW
    $(document).on('click', '.deleteRow', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
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
                   // $('#actual_price'+row_no).val(response.mrp_aed);
                    $('#unit'+row_no).prop('required',true);
                    $('#quantity'+row_no).prop('required',true);
                   
                    var nextRow = document.getElementById('addr'+row_no).nextElementSibling;
                    
                    if(!nextRow ) 
                        add_row();
                    
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