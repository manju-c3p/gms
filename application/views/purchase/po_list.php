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

<!-- Header -->
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<!-- Left Caption -->
	<h1 class="text-xl font-medium text-gray-700">
		Purchase Order List
	</h1>

	<!-- Right Add Button add_purchase_order -->
	<a href="<?php echo base_url(); ?>index.php/Purchase/direct_po"
		class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">

		+ Add Purchase Order

	</a>

</div>


<!-- page content -->
<div class="bg-white shadow rounded-b-lg p-4 overflow-x-auto">

	<div class="overflow-x-auto">

		<div class="flex items-center gap-3 mb-4">


			<div>
				<label class="text-sm text-gray-600">From Date</label><br>
				<input type="date" id="from_date"
					class="border rounded px-2 py-1 text-sm">
			</div>

			<div>
				<label class="text-sm text-gray-600">To Date</label><br>
				<input type="date" id="to_date"
					class="border rounded px-2 py-1 text-sm">
			</div>

			<div class="mt-5">
				<button id="filterBtn"
					class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
					Filter
				</button>

				<button id="resetBtn"
					class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
					Reset
				</button>
			</div>


		</div>


		<table id="datatable"
			class="min-w-full divide-y divide-gray-200 text-sm">

			<thead class="bg-gray-100">

				<tr>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">#</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Sr.no</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">PO Code</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">PO Date</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Supplier</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Document</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Status</th>

					<th class="px-4 py-2 text-left font-semibold text-gray-700">Action</th>

				</tr>

			</thead>


			<tbody class="divide-y divide-gray-200 bg-white">

				<?php $i = 1;
				foreach ($records as $row) : ?>

					<tr class="hover:bg-gray-50 transition">

						<td class="px-4 py-2">

							<a href="javascript:confirmcancel(<?php echo $row->po_id; ?>)"
								title="Delete"
								class="text-red-600 hover:text-red-800">

								<i class="glyphicon glyphicon-trash"></i>

							</a>

						</td>


						<td class="px-4 py-2">
							<?php echo $i;
							$i++; ?>
						</td>


						<td class="px-4 py-2 font-medium text-gray-800">
							<?php echo $row->po_code; ?>
						</td>


						<td class="px-4 py-2 text-gray-700">
							<?php echo date('d-M-Y', strtotime($row->po_date)); ?>
						</td>


						<td class="px-4 py-2">

							<a title="View supplier details"
								target="blank"
								href="<?php echo base_url() . 'index.php/Users/edit_supplier/' . $row->supplier_id; ?>"
								class="text-blue-600 hover:text-blue-800 hover:underline">

								<?php echo $row->supplier_name; ?>

							</a>

						</td>


						<td class="px-4 py-2">

							<a title="View Document"
								href="<?php echo base_url('uploads/podocuments/' . $row->doc_path); ?>"
								target="_blank"
								class="text-blue-600 hover:text-blue-800 hover:underline">

								<?php echo $row->doc_path; ?>

							</a>

						</td>


						<td class="px-4 py-2">

							<?php if ($row->po_status == 1): ?>

								<span class="inline-block bg-gray-700 text-white text-xs px-3 py-1 rounded cursor-not-allowed">
									Approved
								</span>

							<?php else: ?>

								<a href="<?php echo base_url() . 'index.php/Purchase/approve_po/' . $row->po_id; ?>"
									class="inline-block bg-green-600 text-white text-xs px-3 py-1 rounded hover:bg-green-700">
									Approve
								</a>

							<?php endif; ?>

						</td>



						<td class="px-4 py-2">
							<div class="flex items-center gap-3">


								<a href="<?php echo base_url() . 'index.php/Purchase/edit_po/' . $row->po_id . '/0'; ?>"
									title="Edit"
									class="text-green-600 hover:text-green-800">

									<i class="fa fa-pencil"></i>

								</a>



								<a target="_blank"
									href="<?php echo base_url() . 'index.php/Purchase/print_po/' . $row->po_id . '/1'; ?>"
									title="Print"
									class="text-blue-600 hover:text-blue-800">

									<i class="fa fa-print"></i>

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
	function confirmcancel(po_id) {

		if (confirm("Are you sure you want to delete this Purchase Order?")) {

			window.location.href =
				"<?php echo base_url('Purchase/delete_purchase_order/'); ?>" + po_id;

		}

	}
</script>
<script>
	$(document).ready(function() {

		$('#datatable').DataTable({

			pageLength: 10,

			responsive: true,

			autoWidth: false,

			ordering: true,

			searching: true,

			paging: true,

			info: true,

			dom: '<"flex flex-col md:flex-row md:items-center md:justify-between mb-3"Bf>rt<"flex flex-col md:flex-row md:justify-between mt-3"lip>',

			buttons: [

				{
					extend: 'excel',
					text: 'Export Excel',
					className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6] // ✅ exclude delete + action column
					}
				},


					// {
					// 	extend: 'print',
					// 	text: 'Print',
					// 	className: 'bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700'
					// }

			],


			language: {

				search: "",

				searchPlaceholder: "Search Purchase Orders...",

				lengthMenu: "Show _MENU_ entries",

				info: "Showing _START_ to _END_ of _TOTAL_ Purchase Orders",

				paginate: {
					previous: "Prev",
					next: "Next"
				}

			}

		});

		// ======================================================================
		var table = $('#datatable').DataTable();

		$.fn.dataTable.ext.search.push(
			function(settings, data, dataIndex) {

				var from = $('#from_date').val();
				var to = $('#to_date').val();

				// PO Date column index = 3
				var dateStr = data[3]; // 13-Mar-2026

				if (!dateStr) return true;

				var parts = dateStr.split('-');
				var formatted = parts[2] + '-' + getMonth(parts[1]) + '-' + parts[0];

				if (from && formatted < from) return false;
				if (to && formatted > to) return false;

				return true;
			}


		);

		function getMonth(mon) {
			var m = {
				Jan: '01',
				Feb: '02',
				Mar: '03',
				Apr: '04',
				May: '05',
				Jun: '06',
				Jul: '07',
				Aug: '08',
				Sep: '09',
				Oct: '10',
				Nov: '11',
				Dec: '12'
			};
			return m[mon];
		}

		$('#filterBtn').click(function() {
			table.draw();
		});

		$('#resetBtn').click(function() {
			$('#from_date').val('');
			$('#to_date').val('');
			table.draw();
		});




		// ==============================================

	});
</script>
