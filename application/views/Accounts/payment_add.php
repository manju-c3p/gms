<div class="bg-white rounded-xl shadow p-6">
	<form action="<?php echo base_url() . 'index.php/accounts/add_payment_details'; ?>"
		  id="receipt"
		  method="post"
		  name="receipt"
		  class="space-y-6">

		<!-- Top Row -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

			<!-- Date -->
			<div>
				<label class="block text-sm font-medium mb-1">
					Date <span class="text-red-500">*</span>
				</label>
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

			<!-- Supplier -->
			<div>
				<label class="block text-sm font-medium mb-1">
					Select Supplier <span class="text-red-500">*</span>
				</label>
				<select name="debtor"
						id="debtor"
						tabindex="2"
						onchange="get_invoice_list()"
						required
						class="w-full border rounded-lg px-3 py-2 text-sm select2">
					<option value="">Select</option>
					<?php foreach ($sundry_detors_records as $s) { ?>
						<option value="<?php echo $s->account_id; ?>">
							<?php echo $s->account_name; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<!-- Transaction Type -->
			<div>
				<label class="block text-sm font-medium mb-1">
					Transaction Type <span class="text-red-500">*</span>
				</label>
				<select name="transaction_type"
						id="transaction_type"
						onchange="toggleTransactionFields()"
						required
						class="w-full border rounded-lg px-3 py-2 text-sm select2">
					<option value="">Select</option>
					<option value="cheque">Cheque</option>
					<option value="etransfer">E-Transfer</option>
					<option value="other">Other</option>
				</select>
			</div>
		</div>

		<!-- Conditional Transaction Fields -->
		<div id="transaction_fields" style="display:none;"
			 class="grid grid-cols-1 md:grid-cols-3 gap-4">

			<div>
				<label class="block text-sm font-medium mb-1" id="transaction_label">
					Transaction No
				</label>
				<input type="text"
					   name="transaction_no"
					   id="transaction_no"
					   placeholder="Enter Cheque No / Transaction ID"
					   class="w-full border rounded-lg px-3 py-2 text-sm">
			</div>

			<div id="bank_name_group" style="display:none;">
				<label class="block text-sm font-medium mb-1" id="bank_label">
					Bank Name
				</label>
				<input type="text"
					   name="bank_name"
					   id="bank_name"
					   placeholder="Enter Bank Name"
					   class="w-full border rounded-lg px-3 py-2 text-sm">
			</div>
		</div>

		<!-- Invoice Details -->
		<div>
			<label id="invoice_details" class="block text-sm font-semibold"></label>
		</div>

		<!-- Payment Details -->
		<div class="text-sm font-semibold">Payment Details :</div>

		<div id="debt_list"></div>

		<!-- Credit Table -->
		<div class="overflow-x-auto">
			<table class="w-full border border-gray-200 rounded-lg text-sm" id="cr_table">
				<thead class="bg-gray-100">
					<tr>
						<th class="border px-3 py-2 text-left">Debit Account (Cr)</th>
						<th class="border px-3 py-2 text-left">Debit Amount</th>
						<th class="border px-3 py-2 w-20 text-center">
							<button type="button"
									id="cr_add_row"
									class="bg-orange-500 text-white px-2 py-1 rounded">
								<i class="fa fa-plus"></i>
							</button>
						</th>
					</tr>
				</thead>
				<tbody id="cr_body">
					<tr id="cr_addr0">
						<td class="border px-3 py-2">
							<select id="creditor0"
									name="creditor[]"
									onchange="get_account_balance(0,'cr')"
									required
									class="w-full border rounded px-2 py-1 select2">
								<option value="">Select</option>
								<?php foreach ($receipt_Creditors as $row) { ?>
									<option value="<?php echo $row->account_id; ?>">
										<?php echo $row->account_name; ?>
									</option>
								<?php } ?>
							</select>
							<p class="text-xs mt-1" id="set_balancecr0">Balance</p>
						</td>

						<td class="border px-3 py-2">
							<input type="number"
								   step="0.01"
								   name="cr_amount[]"
								   id="cr_amount0"
								   min="0"
								   onkeyup="calculate_grand_total()"
								   required
								   class="w-full border rounded px-2 py-1 credit_sum">
						</td>

						<td class="border px-3 py-2 text-center">
							<button type="button"
									onclick="remove_row_cr(0)"
									class="bg-orange-500 text-white px-2 py-1 rounded">
								<i class="fa fa-trash"></i>
							</button>
						</td>
					</tr>
					<tr id="cr_addr1"></tr>
				</tbody>
			</table>
		</div>

		<!-- Totals -->
		<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
			<div class="font-medium">Debit Total</div>
			<input id="debit_total" name="debit_total" readonly
				   class="border rounded px-3 py-2 bg-gray-100">

			<div class="font-medium">Credit Total</div>
			<input id="credit_total" name="credit_total" readonly
				   class="border rounded px-3 py-2 bg-gray-100">
		</div>

		<!-- Narration -->
		<div>
			<label class="block text-sm font-medium mb-1">Narration</label>
			<textarea id="narration"
					  name="narration"
					  class="w-full border rounded-lg px-3 py-2"></textarea>
		</div>

		<!-- Hidden & Actions -->
		<div class="text-center space-x-3">
			<input type="hidden" id="vtime" name="vtime" value="<?php echo date('h:i:s'); ?>">
			<input type="hidden" id="selected_invoice_ids" name="selected_invoice_ids">
			<input type="hidden" id="filtered_invoice_codes" name="filtered_invoice_codes">
			<input type="hidden" id="selected_amounts" name="selected_amounts">
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
		// var i=1;
		// $("#dr_add_row").click(function()
		// {
		//      $('#dr_addr'+i).html("<td><select class='form-select form-control-sm select2 select2Width' id='debtor"+i+"' name='debtor[]' onchange=get_account_balance("+i+",'dr') requird><option value=''>Select Code</option><?php foreach ($sundry_detors_records as $s) { ?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name; ?></option><?php } ?></select><br><label id='set_balancedr"+i+"'>Balance</label></td><td><input type='number' step='0.01' name='dr_amount[]' id='dr_amount"+i+"' class='form-control form-control-sm debit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_dr("+i+");' id='delete_row1' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
		//     $('#dr_body tr:last').after('<tr id="dr_addr'+(i+1)+'"></tr>');
		//       i++; 	     	
		//      $('.select2').select2({ width: "220px" });
		// });
		// $("#delete_row1").click(function(){
		// 	 if(i>1){
		// 		 $("#dr_addr"+(i-1)).html('');
		// 		 i--;
		// 	 }
		//  });

		var k = 1;
		$("#cr_add_row").click(function() {
			$('#cr_addr' + k).html("<td><select class='form-select form-control-sm select2 select2Width' id='creditor" + k + "' name='creditor[]' onchange=get_account_balance(" + k + ",'cr') required><option value=''>Select</option><?php foreach ($receipt_Creditors as $s) { ?>  <option value='<?php echo $s->account_id; ?>'><?php echo $s->account_name; ?></option><?php } ?></select><br><label id='set_balancecr" + k + "'>Balance</label></td><td><input type='number' step='0.01' name='cr_amount[]' id='cr_amount" + k + "' class='form-control form-control-sm credit_sum' min='0' required onkeyup='calculate_grand_total()'></td><td><a onclick='remove_row_cr(" + k + ");' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
			$('#cr_body tr:last').after('<tr id="cr_addr' + (k + 1) + '"></tr>');
			k++;

			// initialize select2 on new element
			$('#creditor' + (k - 1)).select2({
				width: "220px"
			});
		});
		$("#delete_row2").click(function() {
			if (k > 1) {
				$("#cr_addr" + (k - 1)).html('');
				k--;
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

	function get_invoice_amount() {
		var invoice_id = document.getElementById('invoice_id').value;
		var today = "<?php echo date('Y-m-d') ?>";
		if (invoice_id != '') {
			$.ajax({
				url: "<?php echo site_url('Ajax/get_invoice_amount'); ?>",
				type: 'POST',
				data: {
					invoice_id: invoice_id
				},
				dataType: "json",

				success: function(msg) {
					if (msg) {
						//alert(msg);
						document.getElementById('invoice_details').innerHTML = '<h5>Invoice amount: ' + msg.grand_total + ' Paid amount: ' + msg.paid_total + ' Balance: ' + msg.balance_total + '</h5>';

					}
				}
			});
		} else {
			document.getElementById('invoice_details').innerHTML = '';
		}
	}
	// function get_grn_list() {
	// 		var supplier_id = document.getElementById('supplier_id').value;
	// 		alert("Selected Supplier ID: " + supplier_id);
	// 		if (supplier_id != '') {
	// 			$.ajax
	// 				({
	// 					url: "<?php echo site_url('Ajax/get_grn_list'); ?>",
	// 					type: 'POST',
	// 					data: { supplier_id: supplier_id },
	// 					success: function (msg) {
	// 						document.getElementById('debt_list').innerHTML = msg;
	// 					}
	// 				});
	// 		}
	// 		else {
	// 			document.getElementById('debt_list').innerHTML = '';
	// 		}
	// 	}
	function get_invoice_list() {
		var supplier_id = document.getElementById('debtor').value;
		console.log("Selected Supplier ID:", supplier_id);

		if (supplier_id != '') {
			$.ajax({
				url: "<?php echo site_url('Ajax/get_grn_list'); ?>",
				type: 'POST',
				data: {
					supplier_id: supplier_id
				},
				success: function(msg) {
					document.getElementById('debt_list').innerHTML = msg;
				},
				error: function(xhr, status, error) {
					console.error('AJAX error:', error);
					alert('Failed to load GRN list: ' + error);
				}
			});
		} else {
			document.getElementById('debt_list').innerHTML = '';
		}
	}
	// $('.datepicker1').datepicker({
	//   format: 'dd-mm-yyyy',
	//   autoclose: true,
	//   todayHighlight: true
	// });

	// function p_check() {
	// 	var checked= $('input[name="select_checkbox[]"]:checked').length;

	// 	var allVals = [];
	// 	$(".case:checked").each(function() {
	// 		allVals.push($(this).val());
	// 	});
	// 	document.getElementById("selected_tr").value=allVals;
	// }
	function p_check() {
		let selectedIds = [];
		let selectedCodes = [];
		let amountsObj = {};

		$('.case').each(function() {
			let invoiceId = $(this).val();
			let drInput = $('input[name="dr_amount[' + invoiceId + ']"]');
			let invoiceCode = $(this).data('invoice-code'); // get invoice code from data attribute

			if ($(this).is(':checked')) {
				drInput.prop('disabled', false);

				selectedIds.push(invoiceId);
				if (invoiceCode) selectedCodes.push(invoiceCode);

				let amountVal = drInput.val();
				if (amountVal === undefined || amountVal === '') amountVal = 0;
				amountsObj[invoiceId] = parseFloat(amountVal);
			} else {
				drInput.prop('disabled', true).val('');
			}
		});

		$('#selected_invoice_ids').val(selectedIds.join(','));
		$('#filtered_invoice_codes').val(selectedCodes.join(','));
		$('#selected_amounts').val(JSON.stringify(amountsObj)); // amounts as JSON object
	}



	function toggleTransactionFields() {
		const type = document.getElementById("transaction_type").value;
		const transRow = document.getElementById("transaction_fields");
		const label = document.getElementById("transaction_label");
		const bankLabel = document.getElementById("bank_label");

		if (type === 'cheque') {
			transRow.style.display = 'flex';
			label.innerHTML = 'Cheque Number <span style="color:red;">*</span>';
			bankLabel.style.display = 'block';
		} else if (type === 'etransfer') {
			transRow.style.display = 'flex';
			label.innerHTML = 'Transaction ID <span style="color:red;">*</span>';
			bankLabel.style.display = 'block';
		} else if (type === 'other') {
			transRow.style.display = 'flex';
			label.innerHTML = 'Remarks <span style="color:red;">*</span>';
			bankLabel.style.display = 'none';
			document.getElementById('bank_name').value = '';
		} else {
			transRow.style.display = 'none';
			document.getElementById('transaction_no').value = '';
			document.getElementById('bank_name').value = '';
		}
	}
</script>
