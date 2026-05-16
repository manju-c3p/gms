<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-2xl shadow p-6">

	<div class="flex items-center justify-between mb-4">
		<h2 class="text-2xl font-bold">Quotations</h2>
	</div>

	<div class="overflow-x-auto">
		<table id="quotationTable"
			class="min-w-full border border-gray-200 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th class="border px-3 py-2 text-center">#</th>
					<th class="border px-3 py-2">Quotation No</th>
					<th class="border px-3 py-2">Customer</th>
					<th class="border px-3 py-2">Vehicle</th>
					<th class="border px-3 py-2 text-right">Amount</th>
					<th class="border px-3 py-2 text-center">Status</th>
					<th class="border px-3 py-2 text-center">Job Card</th>
					<th class="border px-3 py-2 text-center">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php if (!empty($quotations)): ?>
					<?php $sl = 1;
					foreach ($quotations as $q): 
					if ($q->status !== "Draft"){
					?>
						<tr class="hover:bg-gray-50">

							<!-- SL -->
							<td class="border px-3 py-2 text-center font-medium">
								<?= $sl++ ?>
							</td>

							<!-- Quotation No -->
							<td class="border px-3 py-2 font-medium">
								<?= $q->quotation_no ?><br>
								<span class="text-xs text-gray-500">
									<?= date('d-m-Y', strtotime($q->quotation_date)) ?>
								</span>
							</td>

							<!-- Customer -->
							<td class="border px-3 py-2">
								<div class="font-medium"><?= $q->customer_name ?></div>
								<div class="text-xs text-gray-500"><?= $q->customer_phone ?></div>
							</td>

							<!-- Vehicle -->
							<td class="border px-3 py-2">
								<div class="font-medium"><?= $q->registration_no ?></div>
								<div class="text-xs text-gray-500">
									<?= $q->brand ?> <?= $q->model ?>
								</div>
							</td>

							<!-- Amount -->
							<td class="border px-3 py-2 text-right">
								AED <?= number_format($q->subtotal, 2) ?>
							</td>

							<!-- Status -->
							<td class="border px-3 py-2 text-center">
								<?php if ($q->status == 'Draft'): ?>
									<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
										Draft
									</span>
								<?php elseif ($q->status == 'Approved'): ?>
									<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
										Approved
									</span>
								<?php elseif ($q->status == 'Rejected'): ?>
									<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
										Rejected
									</span>
								<?php else: ?>
									<span class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-700">
										Converted
									</span>
								<?php endif; ?>
							</td>

							<!-- Job Card -->
							<td class="border px-3 py-2 text-center">
								<?php if ($q->status == 'Approved' && empty($q->jobcard_id)): ?>
									<a href="<?= base_url('index.php/Jobcard/create_from_quotation/' . $q->quotation_id); ?>"
										class="quotation-btn px-3 py-1 text-xs rounded text-white">
										Create Job Card
									</a>
								<?php elseif (!empty($q->jobcard_id)): ?>
									<a href="<?= base_url('index.php/jobcard/view/' . $q->jobcard_id); ?>"
										class="jobcard-btn px-3 py-1 text-xs rounded text-white">
										View Job Card
									</a>

								<?php else: ?>
									<span class="px-3 py-1 text-xs bg-gray-200 text-gray-500 rounded">
										Not Allowed
									</span>
								<?php endif; ?>
							</td>

							<!-- Actions -->
							<td class="border px-3 py-2 text-center space-x-1">
								<a href="<?= base_url('index.php/Quotation/edit/' . $q->quotation_id); ?>"
									class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
									Edit
								</a>

								<a href="<?= base_url('index.php/Quotation/view/' . $q->quotation_id); ?>"
									class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
									View
								</a>

								<a href="<?= base_url('index.php/Quotation/delete/' . $q->quotation_id); ?>"
									class="px-2 py-1 bg-blue-100 text-red-700 rounded">
									Delete
								</a>
							</td>

						</tr>
					<?php 
					}	
				endforeach;
					?>
				<?php else: ?>
					<!-- <tr>
						<td colspan="8"
							class="border px-3 py-6 text-center text-gray-500">
							No quotations found
						</td>
					</tr> -->
				<?php endif; ?>
			</tbody>
		</table>
	</div>

</div>
<script>
	$(document).ready(function() {
		$('#quotationTable').DataTable({
			pageLength: 10,
				language: {
				emptyTable: "No Quotation found"
			},
			// order: [
			// 	[0, 'desc']
			// ],
			columnDefs: [{
				orderable: false,
				targets: [0, 6, 7]
			}]
		});
	});
</script>
