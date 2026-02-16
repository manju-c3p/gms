<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Customer_List.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<html>

<body>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
    <tr>
      <td colspan="2" align="center">
        <h4>Customer List</h4>
      </td>
    </tr>
    <tr>
      <td>Date : <?php echo date('d-M-Y'); ?></td>
    </tr>
  </table>
  <table width="100%" border=1 cellspacing="0" colspacing="0">
  <thead>
								<tr>
                  <th>Customer/Company</th>
									<th>Customer Code</th>
                  <th>Address</th>               
									<th>Company Email Id:</th>
									<th>Email</th>
                  <th>Contact No</th>
                  <th>TRN No</th>
                  <th>Business Type</th> 
                  <th>Type</th>         
                  <th>Address</th>               
      
              
                 
								</tr>
							</thead>

							<tbody>
								<?php foreach ($records as $row) : ?>
									<tr>
                  <td><?php echo $row->cust_name ; ?></td>
										<td><?php echo $row->cust_code; ?></td>
										<td><?php echo $row->billing_address . '&nbsp;' . $row->billing_city . '  ' . $row->billing_state . ' ' . $row->billing_po_box . '  ' . $row->billing_country; ?></td>
                    <td><?php echo $row->email_id ; ?></td>
                    <td><?php echo $row->contact_no ; ?></td>
                    <td><?php echo $row->trn_no ; ?></td>
                    <td><?php echo $row->btype; ?></td>
                    <td>
                        <select id='ctype' name='ctype' class="form-control col-sm-2 form-control-sm">
                            <option value=''>Select</option>
                            <option <?php if($row->ctype=="System Supplies") echo 'selected';?> value="System Supplies">
                                System Supplies (Actual work automation projects - OEM)
                            </option>
                            <option <?php if($row->ctype=="Traders") echo 'selected';?> value='Traders'>Traders</option>
                        </select>
                    </td>
                    <td><?php echo $row->contact_no ; ?></td>


                 
                  </tr>
								<?php endforeach; ?>
							</tbody>

  </table>


</body>

</html>
<style>
.pagenum:before { content: counter(page); }
</style>
