<div class="bg-white rounded-xl shadow p-6">
	<form action="<?php echo base_url() . 'index.php/accounts/add_credit_note'; ?>"
		  id="receipt"
		  method="post"
		  name="receipt"
		  class="space-y-6">

		<!-- Date -->
		<div class="grid grid-cols-1 md:grid-cols-5 items-center gap-4">
			<label class="md:col-span-1 text-sm font-medium">
				Select Date <span class="text-red-500">*</span>
			</label>

			<div class="md:col-span-2">
				<div class="flex items-center border rounded-lg px-2 py-1">
					<input type="text"
						   id="v_date"
						   name="v_date"
						   value="<?php echo date('d-m-Y') ?>"
						   required
						   tabindex="1"
						   class="w-full text-sm outline-none datepicker1">
					<i class="fa fa-calendar text-gray-500"></i>
				</div>
			</div>
		</div>

		<!-- Debit Table -->
		<div class="overflow-x-auto">
			<table id="dr_table"
				   class="w-full border border-gray-200 rounded-lg text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Debit Account (Dr)</th>
						<th class="border px-3 py-2 text-left">Debit Amount</th>
						<th class="border px-3 py-2 text-left">Balance</th>
					</tr>
				</thead>

				<tbody id="dr_body">
					<tr id="dr_addr0">
						<td class="border px-3 py-2">
							<select id="debtor0"
									name="debtor[]"
									onchange="get_account_balance(0,'dr')"
									class="w-full border rounded px-2 py-1 select2"
									requird>
								<option value="">Select</option>
								<?php foreach ($sundry_detors_records as $row) { ?>
									<option value="<?php echo $row->account_id; ?>">
										<?php echo $row->account_name; ?>
									</option>
								<?php } ?>
							</select>
						</td>

						<td class="border px-3 py-2">
							<input type="number"
								   step="0.01"
								   id="dr_amount0"
								   name="dr_amount[]"
								   min="0"
								   onkeyup="calculate_grand_total()"
								   class="w-full border rounded px-2 py-1 debit_sum"
								   requird>
						</td>

						<td class="border px-3 py-2">
							<label id="set_balancedr0"></label>
						</td>
					</tr>
					<tr id="dr_addr1"></tr>
				</tbody>
			</table>
		</div>

		<!-- Credit Table -->
		<div class="overflow-x-auto">
			<table id="cr_table"
				   class="w-full border border-gray-200 rounded-lg text-sm">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Credit Account (Cr)</th>
						<th class="border px-3 py-2 text-left">Credit Amount</th>
						<th class="border px-3 py-2 text-left">Balance</th>
					</tr>
				</thead>

				<tbody id="cr_body">
					<tr id="cr_addr0">
						<td class="border px-3 py-2">
							<select id="creditor0"
									name="creditor[]"
									onchange="get_account_balance(0,'cr')"
									class="w-full border rounded px-2 py-1 select2"
									requird>
								<option value="">Select</option>
								<?php foreach ($credit_records as $row) { ?>
									<option value="<?php echo $row->account_id; ?>">
										<?php echo $row->account_name; ?>
									</option>
								<?php } ?>
							</select>
						</td>

						<td class="border px-3 py-2">
							<input type="number"
								   step="0.01"
								   id="cr_amount0"
								   name="cr_amount[]"
								   min="0"
								   onkeyup="calculate_grand_total()"
								   class="w-full border rounded px-2 py-1 credit_sum"
								   requird>
						</td>

						<td class="border px-3 py-2">
							<label id="set_balancecr0"></label>
						</td>
					</tr>
					<tr id="cr_addr1"></tr>
				</tbody>
			</table>
		</div>

		<!-- Totals -->
		<div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
			<label class="font-medium">Debit Total</label>
			<input id="debit_total"
				   name="debit_total"
				   readonly
				   class="border rounded px-3 py-2 bg-gray-100">

			<label class="font-medium">Credit Total</label>
			<input id="credit_total"
				   name="credit_total"
				   readonly
				   class="border rounded px-3 py-2 bg-gray-100">
		</div>

		<!-- Narration -->
		<div class="grid grid-cols-1 md:grid-cols-5 gap-4">
			<label class="font-medium">Narration</label>
			<textarea id="narration"
					  name="narration"
					  class="md:col-span-4 border rounded-lg px-3 py-2"></textarea>
		</div>

		<!-- Actions -->
		<div class="flex gap-4">
			<input type="hidden" id="vtime" name="vtime" value="<?php echo date('h:i:s'); ?>">
			<input type="hidden" id="invoiceID" name="invoiceID">
			<input type="hidden" id="check_dr_id" name="check_dr_id">

			<button type="submit"
					onclick="return check_total();"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
				Save
			</button>

			<button type="reset"
					class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
				Reset
			</button>
		</div>

	</form>
</div>





<script>
	$(document).ready(function() {
		var i = 1;
		$("#dr_add_row").click(function() {
			$('#dr_addr' + i).html("<td><select class='form-select form-control-sm select2 select2Width' id='debtor" + i + "' name='debtor[]' onchange='get_account_balance(" + i + ",'dr')' requird><option value=''>Select Code</option><?php foreach ($sundry_detors_records as $s) { ?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name; ?></option><?php } ?></select><br><label id='set_balancedr" + i + "'>Balance</label></td><td><input type='number' step='0.01' name='dr_amount[]' id='dr_amount" + i + "' class='form-control form-control-sm debit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_dr(" + i + ");' id='delete_row1' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
			$('#dr_body tr:last').after('<tr id="dr_addr' + (i + 1) + '"></tr>');
			i++;
			$('.select2').select2({
				width: "220px"
			});
		});
		$("#delete_row1").click(function() {
			if (i > 1) {
				$("#dr_addr" + (i - 1)).html('');
				i--;
			}
		});

		var k = 1;
		$("#cr_add_row").click(function() {
			$('#cr_addr' + k).html("<td><select class='form-select form-control-sm select2 select2Width' id='debtor" + k + "' name='debtor[]' onchange='get_account_balance(" + k + ",'dr')' requird><option value=''>Select Code</option><?php foreach ($sundry_detors_records as $s) { ?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name; ?></option><?php } ?></select><br><label id='set_balancedr" + k + "'>Balance</label></td><td><input type='number' step='0.01' name='dr_amount[]' id='dr_amount" + k + "' class='form-control form-control-sm credit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_cr(" + k + ");' id='delete_row2' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
			$('#cr_body tr:last').after('<tr id="cr_addr' + (k + 1) + '"></tr>');
			k++;
			$('.select2').select2({
				width: "220px"
			});
		});
		$("#delete_row2").click(function() {
			if (k > 1) {
				$("#cr_addr" + (k - 1)).html('');
				i--;
			}
		});
	});


	function remove_row_cr(append_id) {
		$('#cr_addr' + append_id).attr("id", "cr_addr" + append_id + "x");
		$('#cr_addr' + append_id + "x").remove();
	}

	function get_account_balance(append_id, type) {
		if (type == 'dr')
			tmp = 'debtor';
		else
			tmp = 'creditor';

		var account_id = document.getElementById(tmp + append_id).value;
		var today = "<?php echo date('Y-m-d') ?>";
		$.ajax({
			url: "<?php echo site_url('Accounts/get_account_balance'); ?>",
			type: 'POST',
			data: {
				account_id: account_id,
				today: today
			},
			success: function(msg) {
				if (msg) {
					//alert(msg);
					document.getElementById('set_balance' + type + append_id).innerHTML = 'Balance: ' + msg;

				}
			}
		});
	}

	function calculate_grand_total() {
		var i_value = 0;
		i_total = 0;
		$('.debit_sum').each(function() {
			i_value = $(this).val();
			if (i_value == '')
				i_value = 0;
			else
				i_total += parseFloat(i_value);
		});
		if (isNaN(i_total)) var dr_total = 0;

		var k_value = 0;
		k_total = 0;
		$('.credit_sum').each(function() {
			k_value = $(this).val();
			if (k_value == '')
				k_value = 0;
			else
				k_total += parseFloat(k_value);
		});
		if (isNaN(k_total)) var cr_total = 0;

		document.getElementById("debit_total").value = parseFloat(i_total).toFixed(2);
		document.getElementById("credit_total").value = parseFloat(k_total).toFixed(2);
		//check_total();
	}

	function check_total() {
		var dr_total = $('#debit_total').val();
		var cr_total = $('#credit_total').val();

		if (parseFloat(cr_total) != parseFloat(dr_total)) {
			alert("Both debit total and credit total must match");
			return false;
		}
	}
</script>
