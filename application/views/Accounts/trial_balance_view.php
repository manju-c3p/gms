<?php ini_set('display_errors', 1);
error_reporting(E_ALL); ?>
<?php $this->load->helper('form'); ?>

<div class="bg-white shadow-md rounded-xl p-6">

	<form class="grid md:grid-cols-12 gap-4 items-end"
		action="<?= base_url('index.php/accounts/trial_balance') ?>"
		method="post"
		id="receipt"
		name="receipt"
		onsubmit="return goToUrlWithDates()">

		<!-- From -->
		<div class="md:col-span-3">
			<label class="block text-sm font-medium mb-1" for="from_date">
				From
			</label>

			<div class="relative">
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 datepicker focus:ring-2 focus:ring-blue-500"
					name="from_date"
					id="from_date"
					value="<?= isset($from_date) ? $from_date : date('d-m-Y') ?>"
					required>

				<i class="fa fa-calendar absolute right-3 top-3 text-gray-400"></i>
			</div>
		</div>


		<!-- To -->
		<div class="md:col-span-3">
			<label class="block text-sm font-medium mb-1" for="to_date">
				To
			</label>

			<div class="relative">
				<input type="text"
					class="w-full border rounded-lg px-3 py-2 datepicker focus:ring-2 focus:ring-blue-500"
					name="to_date"
					id="to_date"
					value="<?= isset($to_date) ? $to_date : date('d-m-Y') ?>"
					required>

				<i class="fa fa-calendar absolute right-3 top-3 text-gray-400"></i>
			</div>
		</div>


		<!-- Button -->
		<div class="md:col-span-2">
			<button type="submit"
				class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow w-full">
				View
			</button>
		</div>

	</form>

	<!-- </div> -->


	<div class="flex items-center gap-3 mt-4">

		<form method="post" action="<?= base_url('index.php/Accounts/trial_balance_export') ?>">
			<input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date) ?>" />
			<input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date) ?>" />

			<button type="submit"
				class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow">
				Export to Excel
			</button>
		</form>

		<form method="post"
			action="<?= base_url('index.php/Accounts/trial_balance_print') ?>"
			target="_blank">

			<input type="hidden" name="from_date" value="<?= htmlspecialchars($from_date) ?>" />
			<input type="hidden" name="to_date" value="<?= htmlspecialchars($to_date) ?>" />

			<button type="submit"
				class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow">
				Print
			</button>
		</form>

	</div>


	<div class="mt-6">
		<div class="overflow-x-auto">

			<table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden">

				<thead class="bg-gray-100">
					<tr>
						<th class="p-3 border text-left">Group</th>
						<th class="p-3 border text-left">Ledger</th>
						<th class="p-3 border text-right">Debit</th>
						<th class="p-3 border text-right">Credit</th>
					</tr>
				</thead>

				<tbody class="divide-y">

					<?php
					if (!empty($accounts)) {

						$current_group = null;

						foreach ($accounts as $row):

							if ($current_group !== $row['group_name']):

								if ($current_group !== null && isset($group_totals[$current_group])):

									$gt = $group_totals[$current_group];
					?>

									<tr class="bg-gray-200 font-semibold">
										<td colspan="2" class="p-3">
											Total for <?= htmlspecialchars($current_group) ?>
										</td>

										<td class="p-3 text-right">
											<?= number_format($gt['debit'], 2) ?>
										</td>

										<td class="p-3 text-right">
											<?= number_format($gt['credit'], 2) ?>
										</td>
									</tr>

								<?php endif; ?>

								<tr class="bg-blue-100 font-bold">
									<td colspan="4" class="p-3">
										<?= htmlspecialchars($row['group_name']) ?>
									</td>
								</tr>

							<?php
								$current_group = $row['group_name'];

							endif;
							?>

							<tr class="hover:bg-gray-50">
								<td class="p-3"></td>

								<td class="p-3">
									<?= htmlspecialchars($row['account_name']) ?>
								</td>

								<td class="p-3 text-right">
									<?= number_format($row['debit'], 2) ?>
								</td>

								<td class="p-3 text-right">
									<?= number_format($row['credit'], 2) ?>
								</td>
							</tr>

						<?php endforeach;

						// Last group total
						if ($current_group !== null && isset($group_totals[$current_group])):

							$gt = $group_totals[$current_group];
						?>

							<tr class="bg-gray-200 font-semibold">
								<td colspan="2" class="p-3">
									Total for <?= htmlspecialchars($current_group) ?>
								</td>

								<td class="p-3 text-right">
									<?= number_format($gt['debit'], 2) ?>
								</td>

								<td class="p-3 text-right">
									<?= number_format($gt['credit'], 2) ?>
								</td>
							</tr>

						<?php endif;
					} else { ?>

						<tr>
							<td colspan="4" class="p-4 text-center text-gray-500">
								No data available.
							</td>
						</tr>

					<?php } ?>

				</tbody>

			</table>
		</div>
	</div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI JavaScript -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
	$(function() {
		$(".datepicker").datepicker({
			dateFormat: 'dd-mm-yy', // Must match the format in input
			changeMonth: true,
			changeYear: true
		}).each(function() {
			const val = $(this).val();
			if (val) {
				try {
					// Explicitly parse and set date
					const parsed = $.datepicker.parseDate('dd-mm-yy', val);
					$(this).datepicker('setDate', parsed);
				} catch (e) {
					console.warn("Invalid date format in input:", val);
				}
			}
		});
	});

	function goToUrlWithDates() {
		const fromDate = $("#from_date").datepicker("getDate");
		const toDate = $("#to_date").datepicker("getDate");

		if (!fromDate || !toDate) {
			alert('Please select both From and To dates.');
			return false;
		}

		if (fromDate > toDate) {
			alert('From date cannot be greater than To date.');
			return false;
		}

		function formatDate(d) {
			const dd = String(d.getDate()).padStart(2, '0');
			const mm = String(d.getMonth() + 1).padStart(2, '0');
			const yyyy = d.getFullYear();
			return dd + '-' + mm + '-' + yyyy;
		}

		const fromStr = formatDate(fromDate);
		const toStr = formatDate(toDate);
		const baseUrl = '<?= base_url("index.php/accounts/trial_balance") ?>';

		window.location.href = `${baseUrl}/${fromStr}/${toStr}`;
		return false;
	}
	// $("#from_date, #to_date").change(function() {
	//   let val = $(this).val();
	//   let date = $.datepicker.parseDate("dd-mm-yy", val);
	//   $(this).val($.datepicker.formatDate("dd-mm-yy", date));
	// });
</script>
