 <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<!-- Buttons (optional but recommended) -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>  
   <!-- page content -->
   <div class="w-full mx-auto bg-white shadow-md rounded-2xl p-6 mt-6">

   	<!-- Header -->
   	<div class="flex justify-between items-center mb-6 border-b pb-4">
   		<h2 class="text-2xl font-semibold">RFQ List</h2>

   		<a href="<?php echo base_url() . 'index.php/Purchase/add_direct_rfq'; ?>"
   			class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-sm">
   			+ Create RFQ
   		</a>
   	</div>

   	<!-- Table -->
   	<div class="overflow-x-auto">
   		<table id="rfqTable" class="min-w-full border border-gray-200 rounded-lg overflow-hidden">

   			<thead class="bg-gray-100">
   				<tr>
   					<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Sr.No</th>
   					<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">RFQ Code</th>
   					<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
   					<th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Supplier</th>
   					<th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
   				</tr>
   			</thead>

   			<tbody class="divide-y divide-gray-200">
   				<?php $i = 1;
					foreach ($records as $row): ?>
   					<tr class="hover:bg-gray-50 transition">

   						<td class="px-4 py-3"><?php echo $i++; ?></td>

   						<td class="px-4 py-3 font-medium text-blue-600 hover:underline">
   							<a href="<?php echo base_url() . 'index.php/Purchase/edit_rfq/' . $row->rfq_id . '/' . $row->rev_version . '/1'; ?>">
   								<?php echo $row->rfq_code; ?>
   							</a>
   						</td>

   						<td class="px-4 py-3">
   							<?php echo date('d-M-Y', strtotime($row->rfq_date)); ?>
   						</td>

   						<td class="px-4 py-3 ">
   							
   								<?php echo $row->supplier_name; ?>
   							
   						</td>

   						<td class="px-4 py-3">
   							<div class="flex justify-center gap-2">

   								<!-- Edit -->
   								<a href="<?php echo base_url() . 'index.php/Purchase/edit_rfq/' . $row->rfq_id . '/0'; ?>"
   									class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
   									Edit
   								</a>

   								<!-- Delete -->
   								<a href="<?php echo base_url() . 'index.php/Purchase/delete_rfq/' . $row->rfq_id; ?>"
   									onclick="return confirm('Delete this RFQ?')"
   									class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
   									Delete
   								</a>

   							</div>
   						</td>

   					</tr>
   				<?php endforeach; ?>
   			</tbody>

   		</table>
   	</div>

   </div>

   <script>
   
   	function handleKeyPress(event, row) {
   		var suggestionDiv = $('#display' + row);
   		var selected = suggestionDiv.find('.selected');
   		var suggestions = suggestionDiv.find('.suggestion');

   		if (event.key === "ArrowUp" || event.key === "ArrowDown" || event.key === "Enter") {

   			event.preventDefault();

   			if (event.key === "ArrowUp") {
   				if (selected.length === 0) {
   					suggestions.eq(-1).addClass('selected');
   				} else {
   					var prev = selected.removeClass('selected').prev('.suggestion');
   					if (prev.length > 0) {
   						prev.addClass('selected');
   					} else {
   						suggestions.eq(-1).addClass('selected');
   					}
   				}
   				// console.log("Up arrow key pressed");
   			} else if (event.key === "ArrowDown") {

   				if (selected.length === 0) {
   					suggestions.eq(0).addClass('selected');
   				} else {
   					var next = selected.removeClass('selected').next('.suggestion');
   					if (next.length > 0) {
   						next.addClass('selected');
   					} else {
   						suggestions.eq(0).addClass('selected');
   					}
   				}
   				// console.log("Down arrow key pressed");
   			} else if (event.key === "Enter") {

   				if (selected.length > 0) {
   					var productName = selected.text();
   					var productID = selected.data('productId');
   					$('#search' + row).val(productName);
   					$('#pro_id' + row).val(productID);
   					suggestionDiv.hide();
   					get_product_info(row);
   				}
   			}
   		}
   	}



  
   </script>

   <script>
   	$(document).ready(function() {
   		$('#rfqTable').DataTable({
   			pageLength: 10,
   			responsive: true,
   			autoWidth: false
   		});
   	});
   </script>
