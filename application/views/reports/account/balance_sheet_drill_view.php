<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$this->load->helper('form');
?>

<div class="bg-white shadow-xl rounded-2xl p-6">

	<!-- FILTER -->
	<form action="<?php echo base_url('index.php/accounts/balance_sheet_bsg'); ?>"
		method="post"
		class="grid md:grid-cols-4 gap-4 items-end">

		<!-- From -->
		<div>
			<label class="block text-sm font-semibold mb-1">From</label>
			<input type="text"
				id="from_date"
				name="from_date"
				value="<?php echo date('d-M-Y', strtotime($from_date)); ?>"
				required
				class="w-full border rounded-lg px-3 py-2">
		</div>

		<!-- To -->
		<div>
			<label class="block text-sm font-semibold mb-1">To</label>
			<input type="text"
				id="to_date"
				name="to_date"
				value="<?php echo date('d-M-Y', strtotime($to_date)); ?>"
				required
				class="w-full border rounded-lg px-3 py-2">
		</div>

		<!-- Group -->
		<div>
			<label class="block text-sm font-semibold mb-1">Group</label>
			<select name="group_no"
				id="group_no"
				class="select2 w-full border rounded-lg px-3 py-2"
				required>

				<option value="">Select Group</option>

				<?php foreach ($groups as $group): ?>
					<option value="<?= $group->group_no ?>"
						<?= (isset($group_no) && $group_no == $group->group_no) ? 'selected' : '' ?>>
						<?= htmlspecialchars($group->group_name) ?>
					</option>
				<?php endforeach; ?>

			</select>
		</div>

		<!-- View -->
		<div>
			<button type="submit"
				class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
				View
			</button>
		</div>

	</form>



	<!-- ACTION BUTTONS -->
	<div class="flex gap-3 mt-4">

		<!-- Export -->
		<form method="post" action="<?php echo base_url('index.php/accounts/balance_sheet_export'); ?>">
			<input type="hidden" name="from_date" value="<?= $from_date ?>">
			<input type="hidden" name="to_date" value="<?= $to_date ?>">
			<input type="hidden" name="group_no" value="<?= $group_no ?>">

			<button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
				Export Excel
			</button>
		</form>

		<!-- Print -->
		<form method="post"
			action="<?php echo base_url('index.php/accounts/balance_sheet_print'); ?>"
			target="_blank">

			<input type="hidden" name="from_date" value="<?= $from_date ?>">
			<input type="hidden" name="to_date" value="<?= $to_date ?>">
			<input type="hidden" name="group_no" value="<?= $group_no ?>">

			<button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">
				Print
			</button>
		</form>

	</div>



	<!-- TABLE -->
	<div class="overflow-x-auto mt-6">

		<table id="balanceTable"
			class="display w-full text-sm">

			<thead class="bg-gray-100">
				<tr>
					<th>Group</th>
					<th>Ledger</th>
					<th class="text-right">Opening</th>
					<th class="text-right">Debit</th>
					<th class="text-right">Credit</th>
					<th class="text-right">Closing</th>
				</tr>
			</thead>

			<tbody>

				<?php if (!empty($balances)) :

					$prev_group = '';

					foreach ($balances as $row):

						if ($prev_group !== $row->group_name): ?>

							<tr class="bg-blue-50 font-semibold">
								<td colspan="6">
									<?= htmlspecialchars($row->group_name) ?>
								</td>
							</tr>

						<?php
							$prev_group = $row->group_name;
						endif;
						?>

						<tr>
							<td></td>
							<td><?= htmlspecialchars($row->account_name); ?></td>
							<td class="text-right"><?= number_format($row->opening_balance, 2); ?></td>
							<td class="text-right"><?= number_format($row->debit, 2); ?></td>
							<td class="text-right"><?= number_format($row->credit, 2); ?></td>
							<td class="text-right font-semibold"><?= number_format($row->closing_balance, 2); ?></td>
						</tr>

					<?php endforeach;

				else: ?>

					<!-- <tr class="bg-blue-50 font-semibold">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr> -->


				<?php endif; ?>

			</tbody>

		</table>

	</div>

</div>



<!-- Scripts -->
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script> -->
<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->
<!--  -->
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
	$(document).ready(function() {

		$('#balanceTable').DataTable({

			scrollX: true,
			paging: false,
			info: false,

			language: {
				emptyTable: "No balance data found for selected period",
				zeroRecords: "No matching records",
				search: "Search:"
			}

		});


		$('.select2').select2({
			width: '100%'
		});

		flatpickr("#from_date", {
			dateFormat: "d-M-Y"
		});
		flatpickr("#to_date", {
			dateFormat: "d-M-Y"
		});

	});
</script>
