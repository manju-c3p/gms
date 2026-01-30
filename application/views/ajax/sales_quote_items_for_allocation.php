<?php $this->load->helper('stock_helper.php');
 $this->load->helper('sales_helper.php');?>
<?php foreach($records1 as $row) { ?>	
	<h4>Allocate Stock</h4>
	<div class="form-group row" >
	<table class="table table-bordered table-hover" id="tab_logic">
		<thead>
		<tr>
		    	<th title="Item">select <input type="checkbox" class="selectall" name="selectall" id="selectall" value="select_all"></th> 
			<th title="Item">Order code</th>   
			<th title="Item">Description</th>      
			<th title="Item">Size</th>  
			<th title="Item">Quantity</th>   
		</tr>
		</thead>
		<?php $i=5000; foreach($records2 as $r) { ?>
		<tr id="addr<?php echo $i;?>" <?php if($r->allocation==1) echo 'class=bg-soft-success'; ?>>
			<td>						
				<input type="checkbox" id="select_checkbox" class="case" name="select_checkbox[]" value="<?php echo $i;?>" onclick="p_check();"  <?php if($r->allocation==1) echo 'disabled'; ?>/>
			</td>
			<td>
				<input type="text"  name="order_code<?php echo $i;?>" id="order_code<?php echo $i;?>" class="form-control  form-control-sm" placeholder="Enter Order Code Here"  readonly value="<?php echo $r->order_code;?>">
			</td>
			
			<td><textarea rows='5' cols='90'  name="desc<?php echo $i;?>" id="desc<?php echo $i;?>" style="font-size:10px; font-weight:bold;" class="form-control form-control-sm" readonly required><?php echo $r->item_desc;?></textarea>
			</td>
			<td>	
				<input type="text" name="size<?php echo $i;?>" id="size<?php echo $i;?>" readonly class="form-control form-control-sm" placeholder="" value="<?php echo $r->size;?>">
				
			</td>
			<td>
				<input type="number" name="qty<?php echo $i;?>" id="qty<?php echo $i;?>"  class="form-control form-control-sm" value="<?php echo $r->balance_qty;?>" onchange="calculate_total('<?php echo $i;?>')">
		</tr>
		
<?php  $i++; } ?>
	</table>
	</div>
	
	
<?php } ?>
