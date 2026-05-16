<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<div class="p-12 w-full">
	<div class="bg-white rounded-xl shadow p-6">
		<!-- Header -->
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-xl font-semibold text-gray-700"> Bank Reconciliation </h2>
			<div class="flex gap-3"> <a href="<?= base_url('index.php/Accounts/list_bank_reconciliation') ?>"
					class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-medium"> List Records </a> </div>
		</div>

		<form class="form-horizontal"
			action="<?php echo base_url() . 'index.php/Accounts/view_bank_reconciliation'; ?>"
			id="receipt"
			method="post"
			name="receipt">

			<!-- Account + Dates Row -->
			<!-- Filters -->
			<div class="flex flex-wrap items-end gap-4 mb-6"> <!-- Account -->
				<div class="w-72"> <label class="block text-sm font-medium text-gray-700 mb-1"> Select Account <span class="text-red-500">*</span> </label>
					<select tabindex="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 select2 account-select" id="account_id" name="account_id" required onchange="get_doc_list()">
						<option value="">Select Code</option> <?php foreach ($account_ledgers as $s) { ?> <option <?php if ($s->account_id == $account_id) echo 'selected'; ?> value="<?php echo $s->account_id; ?>"> <?php echo $s->account_name; ?> </option> <?php } ?>
					</select>
				</div> <!-- From -->
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">From</label>
					<input type="date" class="border border-gray-300 rounded-lg px-3 py-2" id="from_date" name="from_date" onchange="get_doc_list()">
				</div> <!-- To -->
				<div>
					<label class="block text-sm font-medium text-gray-700 mb-1">To</label>
					<input type="date" class="border border-gray-300 rounded-lg px-3 py-2" id="to_date" name="to_date" onchange="get_doc_list()">
				</div>
			</div> <!-- Reconciliation List -->
			<div id="reco_list" class="mb-6"> <!-- Ajax loaded reconciliation table --> </div> <!-- Remarks -->
			<div class="w-96 mb-6">
				<label class="block text-sm font-medium text-gray-700 mb-1"> Remarks </label>
				<textarea id="remark" name="remark" rows="2" tabindex="5" placeholder="remark" class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
			</div>
			<!-- Submit -->
			<button type="submit" tabindex="6" id="add" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow"> Submit </button>

		</form>

	</div>
</div>



<script>
	function get_doc_list() {
		var account_id = document.getElementById('account_id').value;

		var from_date = document.getElementById('from_date').value;
		var to_date = document.getElementById('to_date').value;
		if (account_id != '') {
			$.ajax({
				url: "<?php echo site_url('Ajax/get_reco_list'); ?>",
				type: 'POST',
				data: {
					account_id: account_id,
					from_date: from_date,
					to_date: to_date
				},
				success: function(msg) {
					document.getElementById('reco_list').innerHTML = msg;
				}
			});
		} else {
			document.getElementById('reco_list').innerHTML = '';
		}
	}
</script>
<script>
	$(document).ready(function() {


		$('.account-select').select2({
			width: '100%'
		});
	});
</script>
