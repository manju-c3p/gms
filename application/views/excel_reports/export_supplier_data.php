<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Supplier_List.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Supplier List</h4>
      </td>
    </tr>
    <tr>
      <td>Date : <?php echo date('d-M-Y'); ?></td>
    </tr>
  </table>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
  <thead>
								<tr>
                  <th>Supplier Code</th>
									<th>Supplier/Company Name</th>
                  <!-- <th>Address</th>                -->
									<th>Supplier type</th>
									<th>Company website </th>
                  <th>Email Id</th>
                  <th>Contact No</th>
                  <th>Contact Person Name</th> 
                  <th>Contact Person mobile no</th>     
                  <th>TRN No</th>   
                  <th>Bank Name</th>   
                  <th>Account No</th>   
                  <th>Bank Barnch</th>
                  <th>Bank IBAN No </th>    
                  <th> Bank SWIFT  </th>               
           
               
            
                          
								</tr>
							</thead>

							<tbody>
								<?php foreach ($records as $row) : ?>
									<tr>
                  <td><?php echo $row->supplier_code ; ?></td>
										<td><?php echo $row->supplier_name; ?></td>
										<!-- <td><?php echo $row->billing_address . '&nbsp;' . $row->billing_city . '  ' . $row->billing_state . ' ' . $row->billing_po_box . '  ' . $row->billing_country; ?></td> -->
                    <td>
                            <select name="supplier_type">
                                <option value="">Select</option>
                                <option <?php if($row->supplier_type=='Local') echo 'selected';?> value="Local">Local</option>
                                <option <?php if($row->supplier_type=='overseas') echo 'selected';?> value="overseas">Overseas</option>
                            </select>
                        </td>
                    <td><?php echo $row->website ; ?></td>
                    <td><?php echo $row->email_id ; ?></td>
                    <td><?php echo $row->contact_no; ?></td>                 
                    <td><?php echo $row->contact_person ; ?></td>
                    <td><?php echo $row->contact_person_number; ?></td> 
                    <td><?php echo $row->trn_no; ?></td>                 
                    <td><?php echo $row->bank_name; ?></td>  
                    <td><?php echo $row->bank_account; ?></td> 
                    <td><?php echo $row->bank_IBAN; ?></td>
                    <td><?php echo $row->bank_IBAN; ?></td>      
                    <td><?php echo $row->bank_swift; ?></td>                 
           
                 
                
               





                 
                  </tr>
								<?php endforeach; ?>
							</tbody>

  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
