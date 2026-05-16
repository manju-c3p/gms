<div class="bg-white shadow rounded-xl p-6 w-full">


	<div class="flex justify-between items-center mb-4">
		<h2 class="text-xl font-semibold text-gray-700">Salary Advances</h2>

		<a href="<?= base_url('index.php/Hr/salary_advance') ?>"
			class="bg-blue-600 text-white px-4 py-2 rounded-lg">
			+ Add Advance
		</a>
	</div>

	<div class="overflow-x-auto">
		<table class="w-full border border-gray-200 text-sm">

			<thead class="bg-gray-100">
				<tr>
					<th class="p-2 border">#</th>
					<th class="p-2 border">Employee</th>
					<th class="p-2 border">Date</th>
					<th class="p-2 border">Voucher Code</th>
					<th class="p-2 border text-right">Amount</th>
					<th class="p-2 border text-right">Adjusted</th>
					<th class="p-2 border text-right">Balance</th>
					<!-- <th class="p-2 border">Status</th> -->
					<th class="p-2 border">Actions</th>
				</tr>
			</thead>

			<tbody>

				<?php if (!empty($advances)) {
					$i = 1;
					foreach ($advances as $a) { ?>

						<tr class="hover:bg-gray-50">
							<td class="p-2 border"><?= $i++ ?></td>
							<td class="p-2 border">
								<?= $a->employee_name ?><br>
								<span class="text-xs text-gray-500"><?= $a->employee_code ?></span>
							</td>
							<td class="p-2 border"><?= date('d-m-Y', strtotime($a->advance_date)) ?></td>

							<td class="p-2 border text-right font-medium">
								<?=  $a->voucher_code ?>
							</td>

							<td class="p-2 border text-right font-medium">
								<?= number_format($a->amount, 2) ?>
							</td>

							<td class="p-2 border text-right text-green-600">
								<?= number_format($a->adjusted_amount, 2) ?>
							</td>

							<td class="p-2 border text-right text-red-600 font-semibold">
								<?= number_format($a->balance_amount, 2) ?>
							</td>



							<td class="p-2 border">



								<a href="<?= base_url('index.php/Hr/edit_salary_advance/' . $a->advance_id) ?>"
									class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>

								<a href="<?= base_url('index.php/Hr/delete_salary_advance/' . $a->advance_id) ?>"
									class="bg-red-500 text-white px-3 py-1 rounded">Delete</a>

								<a href="<?= base_url('index.php/Hr/print_salary_advance/' . $a->advance_id) ?>"
									target="_blank"
									class="bg-blue-600 text-white px-3 py-1 rounded">Print</a>

							</td>
						</tr>

					<?php }
				} else { ?>

					<tr>
						<td colspan="8" class="text-center p-4 text-gray-500">
							No Records Found
						</td>
					</tr>

				<?php } ?>

			</tbody>

		</table>
	</div>


</div>
