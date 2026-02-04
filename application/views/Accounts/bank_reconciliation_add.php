<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<div class="bg-white rounded-xl shadow p-6">
	<form action="<?php echo base_url() . 'index.php/Accounts/view_bank_reconciliation'; ?>"
		  id="receipt"
		  method="post"
		  name="receipt"
		  class="space-y-6">

		<!-- Filters -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

			<!-- Account -->
			<div class="md:col-span-3">
				<label class="block text-sm font-medium mb-1">
					Select Account <span class="text-red-500">*</span>
				</label>
				<select id="account_id"
						name="account_id"
						tabindex="1"
						required
						onchange="get_doc_list()"
						class="w-full border rounded-lg px-3 py-2 text-sm select2">
					<option value="">Select Code</option>
					<?php foreach ($account_ledgers as $s) { ?>
						<option <?php if ($s->account_id == $account_id) echo 'selected'; ?>
							value="<?php echo $s->account_id; ?>">
							<?php echo $s->account_name; ?>
						</option>
					<?php } ?>
				</select>
			</div>

			<!-- From Date -->
			<div class="md:col-span-2">
				<label class="block text-sm font-medium mb-1">From</label>
				<input type="date"
					   id="from_date"
					   name="from_date"
					   onchange="get_doc_list()"
					   class="w-full border rounded-lg px-3 py-2 text-sm">
			</div>

			<!-- To Date -->
			<div class="md:col-span-2">
				<label class="block text-sm font-medium mb-1">To</label>
				<input type="date"
					   id="to_date"
					   name="to_date"
					   onchange="get_doc_list()"
					   class="w-full border rounded-lg px-3 py-2 text-sm">
			</div>
		</div>

		<!-- Reconciliation List -->
		<div id="reco_list"></div>

		<!-- Remarks -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-4">
			<label class="md:col-span-2 text-sm font-medium">
				Remarks
			</label>
			<div class="md:col-span-4">
				<textarea id="remark"
						  name="remark"
						  rows="2"
						  tabindex="5"
						  placeholder="remark"
						  class="w-full border rounded-lg px-3 py-2 text-sm"></textarea>
			</div>
		</div>

		<!-- Submit -->
		<div class="flex">
			<button type="submit"
					id="add"
					tabindex="6"
					class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
				Submit
			</button>
		</div>

	</form>
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
$(document).ready(function () {
	$('#datatable').DataTable({
		pageLength: 10,
		lengthMenu: [10, 25, 50, 100],
		order: [[0, 'asc']],   // Sr.no
		searching: true,
		paging: true,
		info: true,
		autoWidth: false,
		responsive: true,
		columnDefs: [
			{ orderable: false, targets: -1 } // Disable sorting on Action column
		]
	});
});
</script>

































</div>
