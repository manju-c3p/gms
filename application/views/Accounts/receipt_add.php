<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="p-6">
	<div class="bg-white rounded-xl shadow-sm border border-gray-200">

		<!-- Header -->
		<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
			<h2 class="text-lg font-semibold text-gray-800">Receipt Voucher</h2>

			<span class="flex gap-2">
				<a href="<?php echo base_url('index.php/accounts/add_receipt'); ?>"
					class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 hover:bg-blue-200 transition"
					title="Add New Record">
					Add New Record
				</a>

				<a href="<?php echo base_url('index.php/accounts/view_receipt_list'); ?>"
					class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 text-xs font-medium px-3 py-1 hover:bg-blue-200 transition"
					title="List Records">
					List Records
				</a>
			</span>

		</div>

		<!-- Form -->
		<form action="<?= base_url('index.php/Accounts/add_receipt_details'); ?>"
			id="receipt"
			method="post"
			class="p-6 space-y-8">


			<!-- ======================================================================== -->
			<div class="bg-white p-6 rounded-xl shadow">

				<!-- ================= ROW 1 ================= -->
				<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">

					<!-- Date -->
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">
							Date <span class="text-red-500">*</span>
						</label>
						<input type="date"
							id="v_date"
							name="v_date"
							value="<?= date('Y-m-d') ?>"
							class="w-full h-[38px] rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-blue-500">
					</div>

					<!-- Customer -->
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">
							Select Customer <span class="text-red-500">*</span>
						</label>
						<select name="debtor"
							id="debtor"
							class="w-full h-[38px] rounded-lg border border-gray-300 px-3 text-sm select2 debtor-select">

							<option value="">Select</option>

							<?php foreach ($receipt_Creditors as $s): ?>
								<option value="<?= $s->account_id ?>"
									data-customer-id="<?= $s->customer_id ?>">
									<?= $s->account_name ?>
								</option>
							<?php endforeach; ?>

						</select>
						<input type="hidden" name="customer_org_id" id="customer_org_id">
					</div>

					<!-- Transaction Type -->
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">
							Transaction Type <span class="text-red-500">*</span>
						</label>
						<select name="transaction_type"
							id="transaction_type"
							onchange="toggleTransactionFields()"
							class="w-full h-[38px] rounded-lg border border-gray-300 px-3 text-sm select2">

							<option value="">Select</option>
							<option value="Cash">Cash</option>
							<option value="cheque">Cheque</option>
							<option value="etransfer">Card/Transfer</option>
							<option value="other">Other</option>
						</select>
					</div>

					<!-- Transaction No -->
					<div id="transaction_fields" class="hidden">
						<label class="block text-sm font-medium text-gray-700 mb-1" id="transaction_label">
							Transaction No
						</label>

						<input type="text"
							id="transaction_no"
							name="transaction_no"
							placeholder="Cheque / Txn ID"
							class="w-full h-[38px] rounded-lg border border-gray-300 px-3 text-sm focus:ring-2 focus:ring-blue-500">
					</div>

				</div>


				<!-- ================= ROW 2 ================= -->
				<div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">

					<!-- Instrument Date -->
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">
							Instrument Date <span class="text-red-500">*</span>
						</label>
						<input type="date"
							id="instrument_bank_date"
							name="instrument_bank_date"
							value="<?= date('Y-m-d') ?>"
							class="w-full h-[38px] rounded-lg border border-gray-300 px-3 text-sm">
					</div>

					<!-- Receipt Mode -->
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">
							Receipt Against
						</label>

						<div class="flex gap-6 items-center h-[38px]">
							<label class="flex items-center gap-1">
								<input type="radio" name="receipt_mode" value="invoice" checked>
								Invoice
							</label>

							<label class="flex items-center gap-1">
								<input type="radio" name="receipt_mode" value="quotation">
								Quotation(Advance)
							</label>
						</div>
					</div>

					<!-- Quotation -->
					<!-- <div  class="hidden"> -->



					<!-- Quotation -->
					<div id="quotation_section" class="hidden">
						<label class="block text-sm font-medium text-gray-700 mb-1">
							Select Quotation
						</label>

						<select id="quotation_id"
							name="quotation_id"
							class="w-full h-[38px] border border-gray-300 rounded px-3 text-sm select2">
						</select>

						<!-- <span class="text-xs text-gray-500">
							Balance will show here
						</span> -->
					</div>

					<!-- Advance -->
					<div id="quotation_section1" class="hidden">
						<label class="block text-sm font-medium text-gray-700 mb-1">
							Advance Amount
						</label>

						<input type="number"
							step="0.01"
							id="quotation_amount"
							class="w-full h-[38px] border border-gray-300 rounded px-3 text-sm"
							placeholder="Enter amount">
					</div>





				</div>

			</div>




			<!-- =========================================================================================== -->

			<!-- Invoice List -->
			<div id="invoice_section">
				<h3 class="text-sm font-semibold text-gray-700 mb-2">Invoice Details</h3>
				<div id="debt_list"></div>
			</div>



			<!-- Credit Table -->
			<div>
				<h3 class="text-sm font-semibold text-gray-700 mb-3">Credit Details</h3>

				<div class="overflow-x-auto">
					<table id="cr_table" class="min-w-full border border-gray-200 rounded-lg">
						<thead class="bg-gray-50 text-xs uppercase text-gray-600">
							<tr>
								<th class="px-4 py-2 text-left">Credit Account (Cr)</th>
								<th class="px-4 py-2 text-left">Amount</th>
								<th class="px-4 py-2 text-center">
									<button type="button"
										id="cr_add_row"
										class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 hover:bg-orange-200">
										+
									</button>
								</th>
							</tr>
						</thead>
						<tbody id="cr_body">
							<tr id="cr_addr0">
								<td class="px-4 py-2">
									<select name="creditor[]"
										id="creditor0"
										onchange="get_account_balance(0,'cr')"
										class="w-full rounded-lg border border-gray-300 px-3 py-2 select2 credit_select">
										<option value="">Select</option>
										<?php foreach ($sundry_detors_records as $row): ?>
											<option value="<?= $row->account_id ?>">
												<?= $row->account_name ?>
											</option>
										<?php endforeach; ?>
									</select>
									<p class="text-xs text-gray-500 mt-1" id="set_balancecr0">Balance</p>
								</td>
								<td class="px-4 py-2">
									<input type="number"
										step="0.01"
										name="cr_amount[]"
										id="cr_amount0"
										class="w-full rounded-lg border border-gray-300 px-3 py-2 credit_sum"
										onkeyup="calculate_grand_total()">
								</td>
								<td class="px-4 py-2 text-center">
									<button type="button"
										onclick="remove_row_cr(0)"
										class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200">
										🗑
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Totals -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
				<!-- Narration -->
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Narration</label>
					<textarea name="narration" id="narration"
						class="w-full rounded-lg border border-gray-300 px-4 py-2"
						rows="3"></textarea>
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Debit Total</label>
					<input id="debit_total" readonly
						class="w-full rounded-lg bg-gray-100 border border-gray-300 px-4 py-2">
				</div>
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">Credit Total</label>
					<input id="credit_total" readonly
						class="w-full rounded-lg bg-gray-100 border border-gray-300 px-4 py-2">
				</div>
			</div>



			<!-- Hidden -->
			<input type="hidden" id="vtime" name="vtime" value="<?= date('h:i:s'); ?>">
			<input type="hidden" id="selected_invoice_ids" name="selected_invoice_ids">
			<input type="hidden" id="filtered_invoice_codes" name="filtered_invoice_codes">
			<input type="hidden" id="check_dr_id" name="check_dr_id">

			<!-- Actions -->
			<div class="flex justify-center gap-4 pt-6 border-t border-gray-200">
				<button type="submit"
					onclick="return check_total();"
					class="px-8 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
					Save
				</button>
				<button type="reset"
					class="px-8 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
					Reset
				</button>
			</div>

		</form>
	</div>
</div>


<script>
	function updateSelectedInvoiceIds() {
		let selected = [];
		document.querySelectorAll('input[name="invoiceID[]"]:checked').forEach(function(cb) {
			selected.push(cb.value);
		});
		document.getElementById('selected_invoice_ids').value = selected.join(',');
	}

	function toggleTransactionFields() {
		const type = document.getElementById("transaction_type").value;
		const transactionFields = document.getElementById("transaction_fields");
		//const bankField = document.getElementById("bank_field"); // Uncomment if using bank field
		const label = document.getElementById("transaction_label");

		// Close select2 dropdown
		// $('#transaction_type').select2('close');

		if (type === 'cheque') {
			transactionFields.style.display = 'flex';
			//bankField.style.display = 'block'; // Uncomment if using bank field
			label.innerHTML = 'Cheque Number <span class="text-danger">*</span>';
		} else if (type === 'etransfer') {
			transactionFields.style.display = 'flex';
			//bankField.style.display = 'block'; // Uncomment if using bank field
			label.innerHTML = 'Transaction ID <span class="text-danger">*</span>';
		} else if (type === 'other') {
			transactionFields.style.display = 'flex';
			//bankField.style.display = 'none'; // Uncomment if using bank field
			label.innerHTML = 'Remarks <span class="text-danger">*</span>';
			//document.getElementById("bank_name").value = '';
		} else {
			transactionFields.style.display = 'none';
			document.getElementById("transaction_no").value = '';
			//document.getElementById("bank_name").value = '';
		}
	}

	$(document).ready(function() {
		var k = 1; // credit row counter (0 exists)

		$('#cr_add_row123').click(function() {
			let newRow = `
        <tr id="cr_addr${k}">
          <td>
            <select class="form-select form-control-sm select2" id="creditor${k}" name="creditor[]" onchange="get_account_balance(${k},'cr')" required>
              <option value="">Select</option>
              <?php foreach ($sundry_detors_records as $row) { ?>
                <option value="<?php echo $row->account_id; ?>"><?php echo $row->account_name; ?></option>
              <?php } ?>
            </select>
            <br><label id="set_balancecr${k}">Balance</label>
          </td>
          <td>
            <input type="number" step="0.01" name="cr_amount[]" id="cr_amount${k}" class="form-control form-control-sm credit_sum" min="0" required onkeyup="calculate_grand_total()">
          </td>
          <td>
            <a onclick="remove_row_cr(${k})" class="btn btn-xs bg-orange remove1" title="Delete" style="cursor:pointer;">
              <span class="fa fa-trash"></span>
            </a>
          </td>
        </tr>`;
			$('#cr_body').append(newRow);
			// Initialize select2 for new row
			$('#creditor' + k).select2({
				width: "220px"
			});
			k++;
		});

		$('#cr_add_row').click(function() {

			let newRow = `
			<tr id="cr_addr${k}">
				<td class="px-4 py-2">
					<select name="creditor[]"
						id="creditor${k}"
						onchange="get_account_balance(${k},'cr')"
						class="w-full rounded-lg border border-gray-300 px-3 py-2 select2 credit_select">
						<option value="">Select</option>
						<?php foreach ($sundry_detors_records as $row): ?>
							<option value="<?= $row->account_id ?>">
								<?= $row->account_name ?>
							</option>
						<?php endforeach; ?>
					</select>
					<p class="text-xs text-gray-500 mt-1" id="set_balancecr${k}">Balance</p>
				</td>

				<td class="px-4 py-2">
					<input type="number"
						step="0.01"
						name="cr_amount[]"
						id="cr_amount${k}"
						class="w-full rounded-lg border border-gray-300 px-3 py-2 credit_sum"
						onkeyup="calculate_grand_total()">
				</td>

				<td class="px-4 py-2 text-center">
					<button type="button"
						onclick="remove_row_cr(${k})"
						class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200">
						🗑
					</button>
				</td>
			</tr>`;

			$('#cr_body').append(newRow);

			// Reinitialize select2
			$('#creditor' + k).select2({
				width: '100%'
			});

			k++;
		});


	});

	function remove_row_cr(id) {
		$('#cr_addr' + id).remove();
		calculate_grand_total();
	}

	function get_account_balance(append_id, type) {
		var tmp = (type == 'dr') ? 'debtor' : 'creditor';
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
					document.getElementById('set_balance' + type + append_id).innerHTML = 'Balance: ' + msg;
				}
			}
		});
	}

	function calculate_grand_total() {
		var i_total = 0;
		$('.debit_sum').each(function() {
			var val = parseFloat($(this).val()) || 0;
			i_total += val;
		});

		var k_total = 0;
		$('.credit_sum').each(function() {
			var val = parseFloat($(this).val()) || 0;
			k_total += val;
		});

		$('#debit_total').val(i_total.toFixed(2));
		$('#credit_total').val(k_total.toFixed(2));
	}

	function check_total() {

		// Check whether at least one invoice checkbox is selected
		let checkedInvoices = $('input[name="invoiceID[]"]:checked').length;

		// Only for invoice mode
		let mode = $('input[name="receipt_mode"]:checked').val();

		if (mode === 'invoice' && checkedInvoices === 0) {
			alert('Please select at least one invoice');
			return false;
		}
		var dr_total = parseFloat($('#debit_total').val()) || 0;
		var cr_total = parseFloat($('#credit_total').val()) || 0;
		if (dr_total !== cr_total) {
			alert("Both debit total and credit total must match");
			return false;
		}
		return true;
	}

	$('#debtor').on('select2:select', function(e) {

		var customerId = e.params.data.element.dataset.customerId;

		$('#customer_org_id').val(customerId);

		get_invoice_list();
	});


	function get_invoice_list() {

		var debtorSelect = document.getElementById('debtor');
		var account_id = debtorSelect.value;
		// alert(account_id);
		// Get customer_id from selected option data attribute
		var customer_id = debtorSelect.options[debtorSelect.selectedIndex]?.getAttribute('data-customer-id');
		// alert(customer_id);
		// document.getElementById('customer_id').value = customer_id || '';

		if (account_id != '') {
			$.ajax({
				url: "<?php echo site_url('Ajax/get_invoice_list'); ?>",
				type: 'POST',
				data: {
					account_id: account_id
				},
				success: function(msg) {
					document.getElementById('debt_list').innerHTML = msg;
				}
			});
		} else {
			document.getElementById('debt_list').innerHTML = '';
		}
	}

	// Call this on checkbox invoiceID[] click to update selected_invoice_ids hidden input
	// function p_check() {
	//   let selected = [];
	//   document.querySelectorAll('input[name="invoiceID[]"]:checked').forEach(function(cb) {
	//     selected.push(cb.value);
	//   });
	//   document.getElementById('selected_invoice_ids').value = selected.join(',');
	// }

	function p_check() {
		let selectedIds = [];
		let selectedCodes = [];

		$('.case').each(function() {
			let invoiceId = $(this).val();
			let drInput = $('input[name="dr_amount[' + invoiceId + ']"]');
			let invoiceCode = $(this).data('invoice-code'); // get invoice code from data attribute

			if ($(this).is(':checked')) {
				drInput.prop('disabled', false);
				selectedIds.push(invoiceId);
				if (invoiceCode) selectedCodes.push(invoiceCode);
			} else {
				drInput.prop('disabled', true).val('');
			}
		});

		$('#selected_invoice_ids').val(selectedIds.join(','));
		$('#filtered_invoice_codes').val(selectedCodes.join(','));
	}

	$(document).ready(function() {
		$('.debtor-select').select2({
			width: '100%'
		});
		$('.credit_select').select2({
			width: '100%'
		});


	});

	$('input[name="receipt_mode"]').on('change', function() {

		let mode = $(this).val();

		if (mode === 'invoice') {
			$('#invoice_section').show();
			$('#quotation_section').hide();
			$('#quotation_section1').hide();
		} else {

			$('#invoice_section').hide();
			$('#quotation_section').show();
			$('#quotation_section1').show();
			loadQuotationList();
		}
	});

	function loadQuotationList() {
		let customer_id = $('#customer_org_id').val();

		if (!customer_id) return;

		$.ajax({
			url: "<?php echo site_url('Accounts/ajax_get_quotation_list'); ?>",
			type: "POST",
			data: {
				customer_id: customer_id
			},
			success: function(res) {

				$('#quotation_id').html(res);
			}
		});
	}
	$('#quotation_amount').on('keyup change', function() {
		let amt = parseFloat($(this).val()) || 0;

		// Fill credit (bank)
		$('#cr_amount0').val(amt);

		// 🔹 Set debit total manually (since no invoice rows)
		$('#debit_total').val(amt.toFixed(2));

		// 🔹 Set credit total
		$('#credit_total').val(amt.toFixed(2));
	});

	function validateAmount(input) {
		let value = parseFloat(input.value);

		// Prevent negative or zero values
		if (input.value !== '' && (isNaN(value) || value <= 0)) {
			alert('Amount should be greater than 0');
			input.value = '';
			input.focus();
		}
	}
</script>
