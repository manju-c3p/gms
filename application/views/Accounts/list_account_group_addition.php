 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

 <!-- DataTables -->
 <link rel="stylesheet"
 	href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

 <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


 <!-- Static Table Start -->
 <div class="p-6">
 	<div class="bg-white rounded-xl shadow-sm border border-gray-200">

 		<!-- Header -->
 		<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
 			<h2 class="text-lg font-semibold text-gray-800">
 				Account Groups
 			</h2>

 			<div class="flex gap-3">
 				<a href="<?= base_url('index.php/Accounts/view_account_group_form') ?>"
 					class="inline-flex items-center px-4 py-2 text-sm font-medium
                  text-green-700 bg-green-100 hover:bg-green-200
                  rounded-full transition">
 					+ Add New Record
 				</a>

 				<a href="<?= base_url('index.php/Accounts/account_group_list') ?>"
 					class="inline-flex items-center px-4 py-2 text-sm font-medium
                  text-blue-700 bg-blue-100 hover:bg-blue-200
                  rounded-full transition">
 					List Records
 				</a>
 			</div>
 		</div>


 		<!-- Table -->
 		<div class="p-4 overflow-x-auto">
 			<table id="accountGroupTable"
 				class="min-w-full text-sm stripe hover">
 				<thead class="bg-gray-50 text-gray-600 uppercase text-xs">
 					<tr>
 						<th class="px-4 py-3 text-left">Account Code</th>
 						<th class="px-4 py-3 text-left">Group Name</th>
 						<th class="px-4 py-3 text-left">Account Type</th>
 						<th class="px-4 py-3 text-left">Parent Group</th>
 					</tr>
 				</thead>

 				<tbody class="divide-y divide-gray-200">
 					<?php foreach ($account_records as $row): ?>
 						<tr>
 							<td class="px-4 py-2 font-medium">
 								<?= $row->group_code; ?>
 							</td>

 							<td class="px-4 py-2">
 								<?= $row->group_name; ?>
 							</td>

 							<td class="px-4 py-2">
 								<?php if ($row->pandl == 0): ?>
 									<span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
 										Balance Sheet
 									</span>
 								<?php else: ?>
 									<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
 										Profit &amp; Loss
 									</span>
 								<?php endif; ?>
 							</td>

 							<td class="px-4 py-2">
 								<?= $row->parent; ?>
 							</td>
 						</tr>
 					<?php endforeach; ?>
 				</tbody>
 			</table>
 		</div>

 	</div>
 </div>

 <!-- Static Table End -->

 <script>
 	$(document).ready(function() {
 		$('#accountGroupTable').DataTable({
 			pageLength: 10,
 			lengthChange: false,
 			ordering: true,
 			responsive: true,
 			language: {
 				search: "Search Groups:",
 				paginate: {
 					previous: "‹",
 					next: "›"
 				}
 			}
 		});
 	});
 </script>


 <style>
 	.dataTables_filter input {
 		border: 1px solid #d1d5db;
 		border-radius: 0.5rem;
 		padding: 6px 10px;
 		margin-left: 6px;
 	}

 	.dataTables_paginate a {
 		padding: 4px 10px !important;
 		margin: 0 2px;
 		border-radius: 6px;
 	}

 	.dataTables_wrapper .dataTables_info {
 		padding-top: 0.75rem;
 		font-size: 0.875rem;
 		color: #6b7280;
 	}
 </style>
