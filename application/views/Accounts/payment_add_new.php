<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="bg-white shadow rounded-xl px-6 py-4 mb-4">

	<div class="flex items-center justify-between">

		<!-- Left: Title -->
		<h1 class="text-xl font-semibold text-gray-800">
			Payment Entry Credit
		</h1>

		<!-- Right: Buttons -->
		<div class="flex gap-2">

			<a href="<?php echo base_url('index.php/Accounts/add_payment_new'); ?>"
				class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-200">
				Add New Record
			</a>

			<a href="<?php echo base_url('index.php/Accounts/view_payment_list_new'); ?>"
				class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-200">
				List Records
			</a>

		</div>

	</div>

</div>
<div class="bg-white shadow rounded-xl p-6">


	<form class="w-full" action="<?php echo base_url() . 'index.php/Accounts/add_payment_details_new'; ?>" id="receipt" method="post" name="receipt">

		<!-- Payment Date -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">
			<label class="col-span-12 md:col-span-3 font-medium">
				Payment Date <span class="text-red-500">*</span>
			</label>

			<div class="col-span-12 md:col-span-3">
				<div class="flex">
					<input type="date"
						class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm datepicker1"
						id="v_date"
						name="v_date"
						value="<?php echo date('Y-m-d') ?>"
						required>

					
				</div>
			</div>
		</div>

		<!-- Debit Table -->
		<div class="mb-6">
			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 rounded-lg text-sm">
					<thead class="bg-gray-100">
						<tr>
							<th class="px-3 py-2 text-left">Select Bank (Cr)</th>
							<th class="px-3 py-2 text-left">Select Ledger Account</th>
							<th class="px-3 py-2 text-left">Select Type</th>
							<th class="px-3 py-2 text-left">
								Amount
								<a id="dr_add_row" class="ml-2 bg-blue-600 text-white px-2 py-1 rounded text-xs cursor-pointer">
									+
								</a>
							</th>
						</tr>
					</thead>

					<tbody id="dr_body">
						<tr id="dr_addr0" class="border-t">
							<td class="px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2  debtor-select"
									id="group_first_party0" name="group_first_party[]" onchange="get_ledger_from_group(this.value,'first',0)">
									<option value="">Select</option>
									<?php foreach ($account_records as $row) {
										if ($row->group_name == 'Bank Accounts' || $row->group_name == 'Cash-in-hand') { ?>
											<option value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
									<?php }
									} ?>
									<option disabled>-------Other----------</option>
									<?php foreach ($account_records as $row) {
										if ($row->group_name != 'Bank Accounts' || $row->group_name != 'Cash-in-hand') { ?>
											<option value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
									<?php }
									} ?>
								</select>
							</td>

							<td class="px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2  debtor-select-ledger"
									id="ledger_first_party0" name="ledger_first_party[]" onchange="get_account_balance(0)">
								</select>
								<label id='set_balancedr0' class="text-xs text-gray-500">Balance</label>
							</td>

							<td class="px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
									id="first_type0" name="first_type[]">
									<option value="">Select</option>
									<option value="Dr">Debit(Dr)</option>
									<option value="Cr">Credit(Cr)</option>
								</select>
							</td>

							<td class="px-3 py-2">
								<input type="number" step="0.01"
									name="first_amount[]" id="first_amount0"
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm credit_sum"
									onblur="calculate_grand_total()">
							</td>
						</tr>

						<tr id="dr_addr1"></tr>
					</tbody>
				</table>
			</div>
		</div>
		<input type="hidden" name="supplier_id" id="supplier_id">
		<input type="hidden" name="supplier_amt" id="supplier_amt">
		<!-- Credit Table -->
		<div class="mb-6">
			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 rounded-lg text-sm">
					<thead class="bg-gray-100">
						<tr>
							<th class="px-3 py-2 text-left">Select Group (Dr)</th>
							<th class="px-3 py-2 text-left">Select Ledger Account</th>
							<th class="px-3 py-2 text-left">Select Type</th>
							<th class="px-3 py-2 text-left">
								Amount
								<a id="cr_add_row" class="ml-2 bg-blue-600 text-white px-2 py-1 rounded text-xs cursor-pointer">
									+
								</a>
							</th>
						</tr>
					</thead>

					<tbody id="cr_body">
						<tr id="cr_addr0" class="border-t">
							<td class="px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2  credit_select"
									id="group_second_party0" name="group_second_party[]" onchange="get_ledger_from_group(this.value,'second',0)">
									<option value="">Select</option>
									<?php foreach ($account_records as $row) { ?>
										<option value="<?php echo $row->group_no; ?>"><?php echo $row->group_name; ?></option>
									<?php } ?>
								</select>
							</td>

							<td class="px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm select2 credit_select_ledger"
									id="ledger_second_party0" name="ledger_second_party[]"
									onchange="get_second_account_balance(0); get_invoice_list(0); setSupplierId(0)">
								</select>

								<label id='set_balancecr0' class="text-xs text-gray-500">Balance</label>

								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm mt-1 select2"
									id="inv0" name="inv[]" onchange="get_invoice_amount(0); calculate_grand_total();">
								</select>
							</td>

							<td class="px-3 py-2">
								<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
									id="second_type0" name="second_type[]">
									<option value="">Select</option>
									<option value="Dr">Debit(Dr)</option>
									<option value="Cr">Credit(Cr)</option>
								</select>
							</td>

							<td class="px-3 py-2">
								<input type="number" step="0.01"
									name="second_amount[]" id="second_amount0"
									class="w-full border border-gray-300 rounded px-2 py-1 text-sm debit_sum"
									onblur="calculate_grand_total()">
							</td>
						</tr>

						<tr id="cr_addr1"></tr>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Total -->
		<div class="grid grid-cols-12 gap-4 mb-4 items-center">
			<div class="col-span-12 md:col-span-8"></div>

			<label class="col-span-6 md:col-span-2 font-medium text-right">
				Total
			</label>

			<div class="col-span-6 md:col-span-2">
				<input id="debit_total" name="debit_total"
					class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-sm"
					readonly>
			</div>
		</div>

		<!-- Narration -->
		<div class="grid grid-cols-12 gap-4 mb-4">
			<label class="col-span-12 md:col-span-3 font-medium">
				Narration:
			</label>

			<div class="col-span-12 md:col-span-6">
				<textarea id="narration" name="narration"
					class="w-full border border-gray-300 rounded px-2 py-1 text-sm"></textarea>
			</div>
		</div>

		<!-- Buttons -->
		<div class="flex gap-3">
			<input type="hidden" id="vtime" name="vtime" value="<?php echo date('h:i:s'); ?>" />
			<input type="hidden" id="invoiceID" name="invoiceID" />

			<button type="submit"
				class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"
				onclick="return check_total();">
				Save
			</button>

			<button type="reset"
				class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
				Reset
			</button>

			<a target="_blank"
				class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm"
				href="<?php echo base_url() . 'index.php/Accounts/journal' ?>">
				Add Journal Voucher
			</a>

			<input id="check_dr_id" name="check_dr_id" type="hidden">
		</div>

	</form>
</div>



<script>
	// $(document).ready(function() {

	// 	var k = 1;
	// 	$("#cr_add_row").click(function() {
	// 		$('#cr_addr' + k).html("<td><select class='form-select form-control-sm select2' id='group_second_party" + k + "' name='group_second_party[]' requird onchange=get_ledger_from_group(this.value,'second'," + k + ") style='width:200px;'><option value=''>Select</option><?php foreach ($account_records as $row) { ?><option value='<?php echo $row->group_no; ?>'><?php echo $row->group_name; ?></option><?php } ?></select></td><td><select class='form-select form-control-sm select2' id='ledger_second_party" + k + "' name='ledger_second_party[]' onchange='get_second_account_balance(" + k + "); get_invoice_list(" + k + ")' requird style='width:400px;'></select><br><label id='set_balancecr" + k + "'>Balance</label><br><select class='form-select form-control-sm select2' id='inv" + k + "' name='inv[]' onchange='get_invoice_amount(" + k + ");'></select></td><td><select class='form-select form-control-sm select2' id='second_type" + k + "' name='second_type[]' requird><option value=''>Select</option><option value='Dr'>Debit(Dr)</option><option value='Cr'>Credit(Cr)</option></select></td><td><input type='number' step='0.01' name='second_amount[]' id='second_amount" + k + "' class='form-control form-control-sm debit_sum' requird min=0 onblur='calculate_grand_total()'><a onclick='remove_row_cr(" + k + ");' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
	// 		$('#cr_body tr:last').after('<tr id="cr_addr' + (k + 1) + '"></tr>');
	// 		k++;
	// 		$('.select2').select2({});
	// 	});

	// 	var m = 1;
	// 	$("#dr_add_row").click(function() {
	// 		$('#dr_addr' + m).html("<td><select class='form-select form-control-sm select2' id='group_first_party" + m + "' name='group_first_party[]' requird onchange=get_ledger_from_group(this.value,'first'," + m + ") style='width:200px;'><option value=''>Select</option><?php foreach ($account_records as $row) {
																																																																						// 																																																																					if ($row->group_name == 'Bank Accounts' || $row->group_name == 'Cash-in-hand') { 
																																																																					?><option value='<?php echo $row->group_no; ?>'><?php echo $row->group_name; ?></option><?php }
																																																																																																																// 																																																																																																																					} 
																																																																																																																	?><option disabled value=''>-------Other----------</option><?php foreach ($account_records as $row) {
																																																																																																																																							// 																																																																																																																																									if ($row->group_name != 'Bank Accounts' || $row->group_name != 'Cash-in-hand') { 
																																																																																																																																						?><option value='<?php echo $row->group_no; ?>'><?php echo $row->group_name; ?></option><?php }
																																																																																																																																																																																				// 																																																																																																																																																																																									} 
																																																																																																																																																																																					?></select></td><td><select class='form-select form-control-sm select2' id='ledger_first_party" + m + "' name='ledger_first_party[]' requird onchange='get_account_balance(" + m + ")' style='width:400px;'></select><br><label id='set_balancedr" + m + "'>Balance</label></td><td><select class='form-select form-control-sm select2' id='first_type" + m + "' name='first_type[]' requird><option value=''>Select</option><option value='Dr'>Debit(Dr)</option><option value='Cr'>Credit(Cr)</option></select></td><td><input type='number' step='0.01' name='first_amount[]' id='first_amount" + m + "0' class='form-control form-control-sm credit_sum' requird min=0 onblur='calculate_grand_total()'><a onclick='remove_row_dr(" + m + ");' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
	// 		$('#dr_body tr:last').after('<tr id="dr_addr' + (m + 1) + '"></tr>');
	// 		m++;
	// 		$('.select2').select2({});
	// 	});
	// });
	$(document).ready(function() {
		$('.debtor-select').select2({
			width: '100%'
		});
		$('.debtor-select-ledger').select2({
			width: '100%'
		});
		$('.credit_select').select2({
			width: '100%'
		});

		$('.credit_select_ledger').select2({
			width: '100%'
		});


	});

	$(document).ready(function() {

		var k = 1;
		$("#cr_add_row").click(function() {

			$('#cr_addr' + k).html(`
            <td>
                <select class="select2 w-full border border-gray-300 rounded px-2 py-1 text-sm"
                    id="group_second_party${k}"
                    name="group_second_party[]"
                    onchange="get_ledger_from_group(this.value,'second',${k})">

                    <option value="">Select</option>
                    <?php foreach ($account_records as $row) { ?>
                        <option value="<?php echo $row->group_no; ?>">
                            <?php echo $row->group_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>

            <td>
                <select class="select2 w-full border border-gray-300 rounded px-2 py-1 text-sm"
                    id="ledger_second_party${k}"
                    name="ledger_second_party[]"
                    onchange="get_second_account_balance(${k}); get_invoice_list(${k})">
                </select>

                <label id="set_balancecr${k}" class="text-xs text-gray-600 block mt-1">Balance</label>

                <select class="select2 w-full border border-gray-300 rounded px-2 py-1 text-sm mt-1"
                    id="inv${k}"
                    name="inv[]"
                    onchange="get_invoice_amount(${k});">
                </select>
            </td>

            <td>
                <select class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                    id="second_type${k}"
                    name="second_type[]">

                    <option value="">Select</option>
                    <option value="Dr">Debit (Dr)</option>
                    <option value="Cr">Credit (Cr)</option>
                </select>
            </td>

            <td class="flex items-center gap-2">
                <input type="number"
                    step="0.01"
                    min="0"
                    name="second_amount[]"
                    id="second_amount${k}"
                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm debit_sum"
                    onblur="calculate_grand_total()">

                <button onclick="remove_row_cr(${k})"
                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                    🗑
                </button>
            </td>
        `);

			$('#cr_body tr:last').after(`<tr id="cr_addr${k + 1}"></tr>`);
			k++;

			$('.select2').select2({
				width: '100%'
			});
		});


		var m = 1;
		$("#dr_add_row").click(function() {

			$('#dr_addr' + m).html(`
				<td colspan="4">
					<div class="grid grid-cols-12 gap-3 items-end">

						<!-- Bank -->
						<div class="col-span-2">
							<label class="text-xs text-gray-600">Bank</label>
							<select class="select2 w-full border border-gray-300 rounded px-2 py-1 text-sm"
								id="group_first_party${m}"
								name="group_first_party[]"
								onchange="get_ledger_from_group(this.value,'first',${m})">
								<option value="">Select</option>
								<?php foreach ($account_records as $row) { ?>
									<option value="<?php echo $row->group_no; ?>">
										<?php echo $row->group_name; ?>
									</option>
								<?php } ?>
							</select>
						</div>

						<!-- Ledger -->
						<div class="col-span-4">
							<label class="text-xs text-gray-600">Ledger</label>
							<select class="select2 w-full border border-gray-300 rounded px-2 py-1 text-sm"
								id="ledger_first_party${m}"
								name="ledger_first_party[]"
								onchange="get_account_balance(${m})">
							</select>
							<span id="set_balancedr${m}" class="text-xs text-gray-500">Balance</span>
						</div>

						<!-- Type -->
						<div class="col-span-2">
							<label class="text-xs text-gray-600">Type</label>
							<select class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
								id="first_type${m}"
								name="first_type[]">
								<option value="">Select</option>
								<option value="Dr">Debit</option>
								<option value="Cr">Credit</option>
							</select>
						</div>

						<!-- Amount -->
						<div class="col-span-3">
							<label class="text-xs text-gray-600">Amount</label>
							<input type="number"
								step="0.01"
								min="0"
								name="first_amount[]"
								id="first_amount${m}"
								class="w-full border border-gray-300 rounded px-2 py-1 text-sm credit_sum"
								onblur="calculate_grand_total()">
						</div>

						<!-- Delete -->
						<div class="col-span-1 flex justify-end">
							<button onclick="remove_row_dr(${m})"
								class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
								🗑
							</button>
						</div>

					</div>
				</td>
				`);

			$('#dr_body tr:last').after(`<tr id="dr_addr${m + 1}"></tr>`);
			m++;

			$('.select2').select2({
				width: '100%'
			});
		});

	});


	function remove_row_cr(append_id) {
		$('#cr_addr' + append_id).attr("id", "cr_addr" + append_id + "x");
		$('#cr_addr' + append_id + "x").remove();
	}

	function remove_row_dr(append_id) {
		$('#dr_addr' + append_id).attr("id", "dr_addr" + append_id + "x");
		$('#dr_addr' + append_id + "x").remove();
	}

	function get_ledger_from_group(account_id, type, append_id) {

		if (type == 'first')
			tmp = 'ledger_first_party' + append_id;
		else
			tmp = 'ledger_second_party' + append_id;

		$.ajax({
			url: "<?php echo site_url('Accounts/ajax_get_ledger_group'); ?>",
			type: 'POST',
			data: {
				account_id: account_id,
				type: type
			},
			success: function(msg) {
				if (msg) {
					document.getElementById(tmp).innerHTML = msg;

				}
			}
		});
	}

	function get_account_balance(append_id) {
		var account_id = document.getElementById("ledger_first_party" + append_id).value;
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
					if (msg >= 0)
						var res = msg + ' Dr';
					else
						var res = (msg * -1) + ' Cr';
					document.getElementById('set_balancedr' + append_id).innerHTML = 'Balance: ' + res;

				}
			}
		});

	}

	function get_second_account_balance(append_id) {
		var account_id = document.getElementById("ledger_second_party" + append_id).value;
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
					document.getElementById('set_balancecr' + append_id).innerHTML = 'Balance: ' + msg;
					get_invoice_list(append_id);
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
		//document.getElementById("credit_total").value= parseFloat(k_total).toFixed(2);
		//check_total();
	}

	function check_total() {
		calculate_grand_total();
		//var dr_total=$('#first_amount').val();

		var k_value = 0;
		k_total = 0;
		$('.credit_sum').each(function() {
			k_value = $(this).val();
			if (k_value == '')
				k_value = 0;
			else
				k_total += parseFloat(k_value);
		});
		if (isNaN(k_total)) var k_total = 0;

		var cr_total = $('#debit_total').val();

		var first_type = $('#first_type').val();
		var second_type = $('#second_type0').val();

		if (parseFloat(cr_total) != parseFloat(k_total)) {
			alert("Both debit total and credit total must match");
			return false;
		}

		if (first_type == second_type) {

			alert("Both Select Type should be diffrent");
			return false;
		}
	}

	function get_invoice_list(append_id) {
		var group_second_party = $('#group_second_party' + append_id).val();
		var ledger_second_party = $('#ledger_second_party' + append_id).val();
		
		console.log("Ledger:", ledger_second_party);

		if (group_second_party == 29 || group_second_party == 30) {
			$.ajax({
				url: "<?php echo site_url('Accounts/ajax_get_invoice_list'); ?>",
				type: 'POST',
				data: {
					account_id: ledger_second_party
				},
				success: function(msg) {
					if (msg) {
						if (msg != '')
							document.getElementById('inv' + append_id).innerHTML = msg;
						else
							document.getElementById('inv' + append_id).innerHTML = '';
					}
				}
			});
		}
	}

	function get_invoice_amount(append_id) {
		var tmp = document.getElementById("inv" + append_id).value;
		const myArray = tmp.split("#");
		var invid = myArray[0];
		var amount = myArray[1];
		//allVals.push(amount);
		document.getElementById("second_amount" + append_id).value = amount;
		document.getElementById("supplier_amt").value = amount;
		calculate_grand_total();
	}

	function p_check() {
		var checked = $('input[name="select_invoice[]"]:checked').length;

		if (checked > 0) {
			//alert('checked');
		} else {
			alert('not checked');
		}

		var allVals = [];
		$(".case:checked").each(function() {
			var tmp = $(this).val();
			const myArray = tmp.split("#");
			var invid = myArray[0];
			var amount = myArray[1];
			allVals.push(amount);
		});
		// Creating variable to store the sum
		let sum = 0;
		// Running the for loop
		for (let i = 0; i < allVals.length; i++) {
			sum += parseFloat(allVals[i]).toFixed(2);
		}
		//alert(sum);
		document.getElementById("second_amount").value = sum;
		//document.getElementById("credit_total").value=sum;

		let length = allVals.length;
		if (length > 1)
			document.getElementById("second_amount").readOnly = true;
		else
			document.getElementById("second_amount").readOnly = false;
	}

	function setSupplierId(append_id) {
		let group = $('#group_second_party' + append_id).val();

		// 29 = Sundry Creditors (Supplier)
		if (group == 29) {
			let supplierId = $('#ledger_second_party' + append_id).val();
			$('#supplier_id').val(supplierId);
		}
	}
</script>
