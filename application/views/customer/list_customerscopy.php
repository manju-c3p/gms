
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
	<table  class="w-full border rounded overflow-hidden">
		<thead class="bg-gray-100">
			<tr>
				<th class="p-3 text-left">Name</th>
				<th class="p-3 text-left">Phone</th>
				<th class="p-3 text-left">Email</th>
				<th class="p-3 text-left">Address</th>
				<th class="p-3 text-center">Actions</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($customers as $c): ?>
				<tr class="border-b hover:bg-gray-50">

					<td class="p-3 font-semibold"><?= $c->name ?></td>

					<td class="p-3"><?= $c->phone ?></td>

					<td class="p-3"><?= $c->email ?></td>

					<td class="p-3"><?= $c->address ?></td>

					<td class="p-3 text-center flex justify-center gap-3">

						<!-- VIEW -->
						<!-- <a href="<?= base_url('index.php/customer/view/' . $c->customer_id); ?>"
							class="p-2 rounded bg-blue-100 hover:bg-blue-200"
							title="View">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none"
								viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
								class="w-5 h-5 text-blue-700">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M2.036 12.322a1 1 0 010-.644C3.423 7.727 
                     7.36 4.5 12 4.5c4.64 0 8.577 3.227 
                     9.964 7.178a1 1 0 010 .644C20.577 16.273 
                     16.64 19.5 12 19.5c-4.64 0-8.577-3.227-9.964-7.178z" />
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
							</svg>
						</a> -->

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



