<table class="table table-bordered table-hover" id="dr_table">
    <thead>
        <tr>
            <th width='10%'>Select</th>
            <th title="Item">Date</th> 
           
            <th title="Item">Account</th> 
            <th title="Item">Instument Date</th> 
             <th title="Item">Instument Number</th> 
             <th title="Item">Amount</th> 
            <th title="Item">Bank Date</th> 
            
           
            

        </tr>
        </thead>
        <tbody>
        <tr><td colspan="6"><input type="hidden"  name="selected_tr" id="selected_tr"  ></td></tr>
        <?php 
        foreach($records as $r) { ?>
                <tr id='dr_addr0'>
                <td><input type="checkbox" id="inv_id" class="case" name="inv_id[]" value="<?php echo $r->voucher_id; ?>" onclick="p_check();"/></td>
                <td><?php echo $r->voucher_date ?></td>   
                
                <td><?php echo $r->account_name ?></td>   
                <td><?php echo $r->voucher_date ?></td>   
                <td><?php echo $r->transaction_no ?></td>   
                <td><?php echo $r->amount ?></td>   
                <td><input type="date" name="bank_date[]" class="form-control form-control-sm" value="<?php echo $r->bank_date;?>"/>
                <input type='hidden' name='customer_id' id='customer_id' value="<?php echo $r->customer_id; ?>">
                </td>   
                   
        </tr>
        <?php  } ?>
        
    </tbody>
    </table>
