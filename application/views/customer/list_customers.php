<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

<div class="w-full bg-white rounded-2xl shadow-md p-6">
  <!-- Soft background -->
    <div class="absolute inset-0 bg-[url('<?= base_url("public/images/car3.png") ?>')]
                bg-center bg-no-repeat bg-contain opacity-5 pointer-events-none"></div>


	<div class="flex justify-between items-center mb-4">
		<h2 class="text-2xl font-bold">Customer List</h2>

		<a href="<?= base_url('index.php/customer/add'); ?>"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ Add Customer
		</a>
	</div>

<hr><br>
	<!-- Flash Messages -->
	<?php if ($this->session->flashdata('success')) : ?>
		<div class="p-3 mb-4 bg-green-100 text-green-700 border border-green-300 rounded">
			<?= $this->session->flashdata('success'); ?>
		</div>
	<?php endif; ?>

	<?php if ($this->session->flashdata('error')) : ?>
		<div class="p-3 mb-4 bg-red-100 text-red-700 border border-red-300 rounded">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>



	<!-- Table -->
	<table id="customerTable" class="stripe hover w-full text-sm">
		<thead>
			<tr class="bg-gray-100 text-gray-700">
				<th class="p-3 text-left">SL No</th>
				<th class="p-3 text-left">Name</th>
				<th class="p-3 text-left">Phone</th>
				<th class="p-3 text-left">Email</th>
				<th class="p-3 text-left">Address</th>
				<th class="p-3 text-center">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php $sl = 1;
			foreach ($customers as $c): ?>
				<tr class="border-b hover:bg-gray-50 text-sm">

					<td class="p-3"><?= $sl++; ?></td>

					<td class="p-3 font-medium"><?= $c->name ?></td>

					<td class="p-3"><?= $c->phone ?></td>

					<td class="p-3"><?= $c->email ?></td>

					<td class="p-3"><?= $c->address ?></td>

					<td class="p-3 text-center flex justify-center gap-3">

						<!-- EDIT -->
						<a href="<?= base_url('index.php/customer/edit/' . $c->customer_id); ?>"
							class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
							title="Edit">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none"
								viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
								class="w-5 h-5 text-yellow-700">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M16.862 3.487l3.651 3.651M17.708 
                                    2.64a2.25 2.25 0 113.182 3.182L7.125 
                                    19.586a4.5 4.5 0 01-1.91 1.146L3 
                                    21l.268-2.214a4.5 4.5 0 011.146-1.91L17.708 2.64z" />
							</svg>
						</a>

						<!-- DELETE -->
						<a onclick="return confirm('Delete this customer?');"
							href="<?= base_url('index.php/customer/delete/' . $c->customer_id); ?>"
							class="p-2 rounded bg-red-100 hover:bg-red-200"
							title="Delete">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none"
								viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
								class="w-5 h-5 text-red-700">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M6 7.5h12M9.75 7.5V4.5h4.5V7.5M10.5 
                                    10.5v6M13.5 10.5v6M4.5 7.5l1.5 
                                    12h12l1.5-12" />
							</svg>
						</a>

					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</div>

<script>
	$(document).ready(function() {

		$('#customerTable').DataTable({
			pageLength: 5,
			lengthMenu: [
				[5, 10, 25, -1],
				[5, 10, 25, "All"]
			],
			responsive: true,

			// Move search box to the RIGHT
			dom: "<'flex justify-between items-center mb-3'l<f>>" +
				"t" +
				"<'flex justify-between items-center mt-3'p>",

			language: {
				search: "",
				searchPlaceholder: "Search customers..."
			}
		});

	});
</script>

<style>
	#customerTable_wrapper .dataTables_filter {
		text-align: right !important;
	}

	#customerTable_wrapper .dataTables_length label {
		font-size: 0.875rem;
	}

	#customerTable_wrapper .dataTables_paginate {
		margin-top: 10px;
	}

	/* Table font smaller */
	#customerTable tbody td {
		font-size: 0.875rem !important;
	}
</style>
