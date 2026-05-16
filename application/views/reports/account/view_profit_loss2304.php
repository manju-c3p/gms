<style id="pnl-style">
	.pnl-table {
		width: 100%;
		border-collapse: collapse;
		font-size: 14px;
	}

	.pnl-table th {
		background: #f1f5f9;
		text-align: left;
		padding: 10px;
		font-weight: 600;
	}

	.pnl-table td {
		padding: 8px 10px;
		border-bottom: 1px solid #eee;
	}

	.group-row {
		background: #f9fafb;
		font-weight: 600;
	}

	.ledger-row {
		color: #555;
	}

	.total-row {
		background: #e5e7eb;
		font-weight: bold;
	}

	.profit-row {
		background: #d1fae5;
		font-weight: bold;
		color: #065f46;
	}

	.loss-row {
		background: #fee2e2;
		font-weight: bold;
		color: #991b1b;
	}

	.section-highlight {
		background: #e0ecff;
		font-weight: 600;
	}

	.text-right {
		text-align: right;
	}
</style>
<?php
$this->load->helper('account_helper');

$pnl = get_net_profit_loss($from, $to);

$net_profit = $pnl['net_profit'];
$net_loss   = $pnl['net_loss'];
$final_total = max($pnl['income'], $pnl['expense']);


?>
<?php
$expense_groups = $this->db->query("
    SELECT * FROM account_group 
    WHERE sno = 4 AND pandl = 1 AND parent_group = sno
")->result();

$income_groups = $this->db->query("
    SELECT * FROM account_group 
    WHERE sno = 3 AND pandl = 1 AND parent_group = sno
")->result();
?>

<div class="bg-white rounded-xl shadow p-4">

	<form method="post"
		action="<?= base_url('index.php/Accounts/get_profit_and_loss'); ?>"
		class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

		<input type="text" name="from" value="<?= $from ?>" class="border p-2 rounded">
		<input type="text" name="to" value="<?= $to ?>" class="border p-2 rounded">

		<button class="bg-blue-600 text-white px-4 py-2 rounded">Go</button>
	</form>

	<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

		<?php
		// 🔁 RECURSIVE FUNCTION
		function render_group_tree($group_id, $from, $to, $level = 0)
		{
			$CI = &get_instance();

			// Sub Groups
			$groups = $CI->db->query("
				SELECT * FROM account_group 
				WHERE parent_group = $group_id
			")->result();

			foreach ($groups as $g) {

				$padding = $level * 20;

				$amount = get_group_total1($g->group_no, $from, $to);

				echo "<tr>";
				echo "<td style='padding-left: {$padding}px;' class='p-2 font-semibold'>{$g->group_name}</td>";
				echo "<td class='p-2 text-right'>" . number_format($amount, 2) . "</td>";
				echo "</tr>";

				// 🔁 recursion
				render_group_tree($g->group_no, $from, $to, $level + 1);
			}

			// Ledgers under this group
			$ledgers = $CI->db->query("
				SELECT * FROM general_ledger 
				WHERE group_no = $group_id
			")->result();

			foreach ($ledgers as $l) {

				$padding = $level * 20;

				$amount = get_ledger_total($l->account_id, $from, $to);

				echo "<tr>";
				echo "<td style='padding-left: {$padding}px;' class='p-2 text-gray-600'>- {$l->account_name}</td>";
				echo "<td class='p-2 text-right'>" . number_format($amount, 2) . "</td>";
				echo "</tr>";
			}
		}
		?>

		<!-- ================= LEFT SIDE (EXPENSE) ================= -->

		<table class="pnl-table">

			<tr>
				<th>Particulars</th>
				<th class="text-right">Amount</th>
			</tr>

			<tr>
				<td class="group-row">Opening Stock</td>
				<td class="text-right">0.00</td>
			</tr>

			<?php
			foreach ($expense_groups as $g) {
				echo "<tr class='group-row'>
            <td>{$g->group_name}</td>
            <td></td>
          </tr>";

				render_group_tree($g->group_no, $from, $to);
			}
			?>

			<tr class="profit-row">
				<td>Net Profit</td>
				<td class="text-right"><?= number_format($net_profit, 2) ?></td>
			</tr>

			<tr class="total-row">
				<td>Total</td>
				<td class="text-right"><?= number_format($final_total, 2) ?></td>
			</tr>

		</table>


		<!-- ================= RIGHT SIDE (INCOME) ================= -->

		<table class="pnl-table">

			<tr>
				<th>Particulars</th>
				<th class="text-right">Amount</th>
			</tr>

			<?php
			foreach ($income_groups as $g) {
				echo "<tr class='group-row'>
            <td>{$g->group_name}</td>
            <td></td>
          </tr>";

				render_group_tree($g->group_no, $from, $to);
			}
			?>

			<tr class="loss-row">
				<td>Net Loss</td>
				<td class="text-right"><?= number_format($net_loss, 2) ?></td>
			</tr>

			<tr class="total-row">
				<td>Total</td>
				<td class="text-right"><?= number_format($final_total, 2) ?></td>
			</tr>

		</table>

	</div>
</div>
