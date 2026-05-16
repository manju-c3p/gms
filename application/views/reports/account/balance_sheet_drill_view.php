<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$this->load->helper('form');
?>

<div class="bg-white shadow-md rounded-lg p-6">

	<!-- Main form for View -->
	<form class="space-y-4" action="<?php echo base_url('index.php/Accounts/balance_sheet_bsg'); ?>" id="balance_sheet_form" method="post">

		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
			<label class="md:col-span-2 font-medium text-sm text-gray-700">From</label>
			<div class="md:col-span-3">
				<div class="relative">
					<input type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
						id="from_date" name="from_date"
						value="<?php echo date('d-M-Y', strtotime($from_date)); ?>" required tabindex='3'>
					<div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
						<i class="fa fa-calendar text-gray-400"></i>
					</div>
				</div>
			</div>

			<label class="md:col-span-2 font-medium text-sm text-gray-700">To</label>
			<div class="md:col-span-3">
				<div class="relative">
					<input type="text"
						class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
						id="to_date" name="to_date"
						value="<?php echo date('d-M-Y', strtotime($to_date)); ?>" required tabindex='3'>
					<div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
						<i class="fa fa-calendar text-gray-400"></i>
					</div>
				</div>
			</div>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
			<label class="md:col-span-2 font-medium text-sm text-gray-700">Group</label>
			<div class="md:col-span-3">
				<select name="group_no" id="group_no"
					class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm select2 focus:outline-none focus:ring-2 focus:ring-blue-500"
					required>
					<option value="">Select Group</option>
					<?php if (!empty($groups)): ?>
						<?php foreach ($groups as $group): ?>
							<option value="<?= $group->group_no ?>" <?= (isset($group_no) && $group_no == $group->group_no) ? 'selected' : '' ?>>
								<?= htmlspecialchars($group->group_name) ?>
							</option>
						<?php endforeach; ?>
					<?php else: ?>
						<option value="">No group found</option>
					<?php endif; ?>
				</select>
			</div>
		</div>
	</form>

	<!-- Print and Export buttons -->
	<div class="flex flex-wrap items-center gap-3 mt-6">

		<!-- View Button Form -->
		<form method="post" action="<?php echo base_url('index.php/Accounts/balance_sheet_bsg'); ?>">
			<input type="hidden" name="from_date" value="<?php echo isset($from_date) ? $from_date : ''; ?>">
			<input type="hidden" name="to_date" value="<?php echo isset($to_date) ? $to_date : ''; ?>">
			<input type="text" name="group_no" value="<?php echo isset($group_no) ? $group_no : ''; ?>">
			<button type="submit" name="action" value="view"
				class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
				View
			</button>
		</form>

		<!-- Export Form -->
		<form method="post" action="<?php echo base_url('index.php/Accounts/balance_sheet_export'); ?>">
			<input type="hidden" name="from_date" value="<?php echo isset($from_date) ? $from_date : ''; ?>">
			<input type="hidden" name="to_date" value="<?php echo isset($to_date) ? $to_date : ''; ?>">
			<input type="hidden" name="group_no" value="<?php echo isset($group_no) ? $group_no : ''; ?>">
			<button type="submit"
				class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
				Export to Excel
			</button>
		</form>

		<!-- Print Button Form -->
		<form method="post" action="<?php echo base_url('index.php/Accounts/balance_sheet_print'); ?>" target="_blank">
			<input type="hidden" name="from_date" value="<?php echo isset($from_date) ? $from_date : ''; ?>">
			<input type="hidden" name="to_date" value="<?php echo isset($to_date) ? $to_date : ''; ?>">
			<input type="hidden" name="group_no" value="<?php echo isset($group_no) ? $group_no : ''; ?>">
			<button type="submit"
				class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
				Print
			</button>
		</form>
	</div>

	<!-- Balance Sheet Table -->
	<div class="mt-8 overflow-x-auto">
		<table class="min-w-full border border-gray-300 text-sm">
			<thead class="bg-gray-100">
				<tr>
					<th class="border border-gray-300 px-3 py-2 text-left">Group</th>
					<th class="border border-gray-300 px-3 py-2 text-left">Ledger</th>
					<th class="border border-gray-300 px-3 py-2 text-right">Opening Balance</th>
					<th class="border border-gray-300 px-3 py-2 text-right">Debit</th>
					<th class="border border-gray-300 px-3 py-2 text-right">Credit</th>
					<th class="border border-gray-300 px-3 py-2 text-right">Closing Balance</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($balances)) :
					$prev_group = '';
					foreach ($balances as $row):
						if ($prev_group !== $row->group_name):
							echo "<tr class='bg-blue-100 font-semibold'><td colspan='6' class='border border-gray-300 px-3 py-2'>" . htmlspecialchars($row->group_name) . "</td></tr>";
							$prev_group = $row->group_name;
						endif;
				?>
						<tr class="hover:bg-gray-50">
							<td class="border border-gray-300 px-3 py-2"></td>
							<td class="border border-gray-300 px-3 py-2"><?php echo htmlspecialchars($row->account_name); ?></td>
							<td class="border border-gray-300 px-3 py-2 text-right"><?php echo number_format($row->opening_balance, 2); ?></td>
							<td class="border border-gray-300 px-3 py-2 text-right"><?php echo number_format($row->debit, 2); ?></td>
							<td class="border border-gray-300 px-3 py-2 text-right"><?php echo number_format($row->credit, 2); ?></td>
							<td class="border border-gray-300 px-3 py-2 text-right"><?php echo number_format($row->closing_balance, 2); ?></td>
						</tr>
					<?php endforeach;
				else: ?>
					<tr>
						<td colspan="6" class="text-center border border-gray-300 px-3 py-4">
							No data available for selected criteria.
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

</div>

<!-- Scripts -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
	$(document).ready(function() {
		$("#from_date, #to_date").datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true
		});

		$('.select2').select2({
			width: "100%"
		});
	});
</script>
