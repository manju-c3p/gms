<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Tailwind Overrides for DataTable -->
<style>
    /* Table head */
    table.dataTable thead th {
        background-color: #f3f4f6 !important; /* gray-100 */
        color: #111827; /* gray-900 */
        /* font-weight: 500; */
		font-size:15px;
        padding: 12px;
        border-bottom: 2px solid #e5e7eb;
    }

    /* Table cells */
    table.dataTable tbody td {
        padding: 12px;
		font-size:14px;
        color: #374151; /* gray-700 */
    }

    /* Row hover */
    table.dataTable tbody tr:hover {
        background-color: #f9fafb !important;
    }

    /* Pagination */
    .dataTables_paginate .paginate_button {
        padding: 6px 12px !important;
        border-radius: 6px;
        margin: 0 3px;
        border: 1px solid #d1d5db !important;
        background: white !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: #2563eb !important; /* blue-600 */
        color: #fff !important;
        border-color: #2563eb !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: #e5e7eb !important; /* gray-200 */
        color: #111827 !important;
    }

    /* Search box */
    .dataTables_filter input {
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        margin-left: 8px;
        outline: none;
    }

    /* Page length dropdown */
    .dataTables_length select {
        padding: 6px 8px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        margin-right: 6px;
    }

    /* Bottom info */
    .dataTables_info {
        margin-top: 10px;
        color: #6b7280; /* gray-500 */
    }
</style>

<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<h2 class="text-2xl font-bold mb-4">Customer List</h2>

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

	<!-- Search & Add -->
	<div class="flex justify-between items-center mb-4">

		<!-- Search -->
		<form method="get" class="flex items-center">
			<input type="text" name="search"
				value="<?= $this->input->get('search'); ?>"
				placeholder="Search customers..."
				class="border p-2 rounded w-64">

			<button class="px-4 py-2 bg-blue-600 text-white rounded ml-2">
				Search
			</button>
		</form>

		<!-- Add Customer -->
		<a href="<?= base_url('index.php/customer/add'); ?>"
			class="px-4 py-2 bg-green-600 text-white rounded">
			+ Add Customer
		</a>
	</div>

	<!-- Table -->
	<table id="customerTable" class="display w-full">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($customers as $c): ?>
            <tr>
                <td class="font-semibold"><?= $c->name ?></td>
                <td><?= $c->phone ?></td>
                <td><?= $c->email ?></td>
                <td><?= $c->address ?></td>

                <td class="text-center">
                    <div class="flex justify-center gap-3">

                        <!-- Edit -->
                        <a href="<?= base_url('index.php/customer/edit/' . $c->customer_id); ?>"
                           class="p-2 bg-yellow-100 hover:bg-yellow-200 rounded">
                           ✏️
                        </a>

                        <!-- Delete -->
                        <a onclick="return confirm('Delete this customer?');"
                           href="<?= base_url('index.php/customer/delete/' . $c->customer_id); ?>"
                           class="p-2 bg-red-100 hover:bg-red-200 rounded">
                           🗑️
                        </a>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>





</div>
<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#customerTable').DataTable({
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            ordering: true,
            searching: true,
            info: true,
        });
    });
</script>



