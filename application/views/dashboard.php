<div class="min-h-screen bg-gray-50 relative">

	<!-- Soft background -->
	<div class="absolute inset-0 bg-[url('<?= base_url("public/images/car1.png") ?>')]
                bg-center bg-no-repeat bg-contain opacity-5 pointer-events-none"></div>

	<div class="relative z-10 p-6">

		<!-- HEADER -->
		<div class="flex justify-between items-center mb-6">
			<div>
				<!-- <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1> -->
				<p class="text-gray-500">Welcome back, <b><?php echo $username; ?></b></p>
			</div>
		</div>

		<!-- KPI CARDS -->
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

			<!-- Revenue -->
			<div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-600">
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm text-gray-500">Total Revenue</p>
						<h2 class="text-2xl font-bold text-gray-800">AED 1,245,600</h2>
					</div>
					<div class="p-3 bg-blue-100 rounded-xl text-blue-600 text-xl">
						💰
					</div>
				</div>
			</div>

			<!-- Job Cards -->
			<div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-600">
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm text-gray-500">Job Cards</p>
						<h2 class="text-2xl font-bold text-gray-800">4</h2>
					</div>
					<div class="p-3 bg-green-100 rounded-xl text-green-600 text-xl">
						🛠
					</div>
				</div>
			</div>

			<!-- Pending -->
			<div class="bg-white rounded-2xl shadow p-5 border-l-4 border-yellow-500">
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm text-gray-500">Pending Jobs</p>
						<h2 class="text-2xl font-bold text-gray-800">1</h2>
					</div>
					<div class="p-3 bg-yellow-100 rounded-xl text-yellow-600 text-xl">
						⏳
					</div>
				</div>
			</div>

			<!-- Customers -->
			<div class="bg-white rounded-2xl shadow p-5 border-l-4 border-purple-600">
				<div class="flex justify-between items-center">
					<div>
						<p class="text-sm text-gray-500">Customers</p>
						<h2 class="text-2xl font-bold text-gray-800">10</h2>
					</div>
					<div class="p-3 bg-purple-100 rounded-xl text-purple-600 text-xl">
						👥
					</div>
				</div>
			</div>
		</div>

		<!-- MODULE SHORTCUT CARDS -->
		<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

			<?php
			$modules = [
				[
					'title' => 'Customer Management',
					'desc'  => 'Manage customers & history',
					'icon'  => '👤',
					'url'   => base_url('index.php/customer')
				],
				[
					'title' => 'Vehicle Management',
					'desc'  => 'Vehicle & documents',
					'icon'  => '🚗',
					'url'   => base_url('index.php/Vehicle/list')
				],
				[
					'title' => 'Appointments & Booking',
					'desc'  => 'Schedule & reminders',
					'icon'  => '📅',
					'url'   => base_url('index.php/Appointment/index')
				],
				[
					'title' => 'Inventory & Spare Parts',
					'desc'  => 'Stock & usage tracking',
					'icon'  => '📦',
					'url'   => base_url('index.php/spareparts')
				],
				[
					'title' => 'Job Cards / Work Orders',
					'desc'  => 'Service execution',
					'icon'  => '📝',
					'url'   => base_url('index.php/jobcard')
				],
				[
					'title' => 'Billing & Invoice',
					'desc'  => 'Invoices & payments',
					'icon'  => '💳',
					'url'   => base_url('index.php/invoice')
				]
			];
			?>

			<?php foreach ($modules as $m): ?>
				<a href="<?= $m['url'] ?>"
					class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6
              hover:ring-2 hover:ring-blue-200">

					<div class="flex items-start gap-4">
						<div class="text-3xl"><?= $m['icon'] ?></div>
						<div>
							<h3 class="font-semibold text-lg text-gray-800">
								<?= $m['title'] ?>
							</h3>
							<p class="text-sm text-gray-500"><?= $m['desc'] ?></p>
						</div>
					</div>

				</a>
			<?php endforeach; ?>

		</div>


		<div class="bg-white rounded-2xl shadow p-6">

			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-bold">Active Job Cards</h3>

				<a href="<?= base_url('index.php/jobcard'); ?>"
					class="text-sm text-blue-600 hover:underline">
					View All
				</a>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 text-sm">
					<thead class="bg-gray-100">
						<tr>
							<th class="border px-3 py-2 text-left">Job Card No</th>
							<th class="border px-3 py-2 text-left">Vehicle</th>
							<th class="border px-3 py-2 text-left">Customer</th>
							<th class="border px-3 py-2 text-left">Technician</th>
							<th class="border px-3 py-2 text-center">Status</th>
							<th class="border px-3 py-2 text-center">Expected Delivery</th>
							<th class="border px-3 py-2 text-center">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!empty($active_job_cards)): ?>
							<?php foreach ($active_job_cards as $jc): ?>
								<tr class="hover:bg-gray-50">
									<td class="border px-3 py-2 font-medium">
										<?= $jc->jobcard_no ?>
									</td>

									<td class="border px-3 py-2">
										<?= $jc->registration_no ?>
									</td>

									<td class="border px-3 py-2">
										<?= $jc->customer_name ?>
									</td>

									<td class="border px-3 py-2">
										<?= $jc->technician_name ?? '—' ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?php if ($jc->status == 'Pending'): ?>
											<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
												Pending
											</span>
										<?php else: ?>
											<span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
												In Progress
											</span>
										<?php endif; ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?= $jc->expected_delivery_date
											? date('d-m-Y', strtotime($jc->expected_delivery_date))
											: '—' ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<a href="<?= base_url('index.php/jobcard/view/' . $jc->jobcard_id); ?>"
											class="px-3 py-1 text-xs bg-green-600 text-white rounded">
											View
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="7"
									class="border px-3 py-6 text-center text-gray-500">
									No active job cards found
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

		</div>

		<div class="bg-white rounded-2xl shadow p-6 mt-6">

			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-bold">Recent Estimations</h3>

				<a href="<?= base_url('index.php/estimation'); ?>"
					class="text-sm text-blue-600 hover:underline">
					View All
				</a>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 text-sm">
					<thead class="bg-gray-100">
						<tr>
							<th class="border px-3 py-2">Estimation No</th>
							<th class="border px-3 py-2">Customer</th>
							<th class="border px-3 py-2">Vehicle</th>
							<th class="border px-3 py-2 text-right">Amount</th>
							<th class="border px-3 py-2 text-center">Approval Status</th>
							<th class="border px-3 py-2 text-center">Created Date</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!empty($recent_estimations)): ?>
							<?php foreach ($recent_estimations as $e): ?>
								<tr class="hover:bg-gray-50">

									<td class="border px-3 py-2 font-medium">
										<?= $e->estimation_no ?>
									</td>

									<td class="border px-3 py-2">
										<?= $e->customer_name ?>
									</td>

									<td class="border px-3 py-2">
										<?= $e->registration_no ?>
									</td>

									<td class="border px-3 py-2 text-right">
										₹<?= number_format($e->grand_total, 2) ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?php if ($e->status == 'Pending'): ?>
											<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
												Pending
											</span>
										<?php elseif ($e->status == 'Approved'): ?>
											<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
												Approved
											</span>
										<?php else: ?>
											<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
												Rejected
											</span>
										<?php endif; ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?= date('d-m-Y', strtotime($e->created_at)) ?>
									</td>

								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="6"
									class="border px-3 py-6 text-center text-gray-500">
									No estimations found
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

		</div>


		<div class="bg-white rounded-2xl shadow p-6 mt-6">

			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-bold text-red-600">
					Low Stock Items
				</h3>

				<a href="<?= base_url('index.php/spareparts'); ?>"
					class="text-sm text-blue-600 hover:underline">
					Manage Stock
				</a>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 text-sm">
					<thead class="bg-gray-100">
						<tr>
							<th class="border px-3 py-2">Part Name</th>
							<th class="border px-3 py-2">Brand</th>
							<th class="border px-3 py-2 text-center">Current Stock</th>
							<th class="border px-3 py-2 text-center">Min Stock</th>
							<th class="border px-3 py-2 text-center">Status</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!empty($low_stock_items)): ?>
							<?php foreach ($low_stock_items as $p): ?>
								<tr class="hover:bg-gray-50">

									<td class="border px-3 py-2 font-medium">
										<?= $p->part_name ?>
									</td>

									<td class="border px-3 py-2">
										<?= $p->brand_name ?? 'Universal' ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?= $p->current_stock ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?= $p->min_stock ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?php if ($p->current_stock == 0): ?>
											<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
												Out of Stock
											</span>
										<?php else: ?>
											<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
												Low Stock
											</span>
										<?php endif; ?>
									</td>

								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="5"
									class="border px-3 py-6 text-center text-gray-500">
									All items are sufficiently stocked 🎉
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

		</div>

		<div class="bg-white rounded-2xl shadow p-6 mt-6">

			<div class="flex items-center justify-between mb-4">
				<h3 class="text-lg font-bold">
					Recent Inspections
				</h3>

				<a href="<?= base_url('index.php/inspection'); ?>"
					class="text-sm text-blue-600 hover:underline">
					View All
				</a>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full border border-gray-200 text-sm">
					<thead class="bg-gray-100">
						<tr>
							<th class="border px-3 py-2">Inspection ID</th>
							<th class="border px-3 py-2">Vehicle</th>
							<th class="border px-3 py-2">Customer</th>
							<th class="border px-3 py-2 text-center">KM</th>
							<th class="border px-3 py-2 text-center">Status</th>
							<th class="border px-3 py-2 text-center">Date</th>
							<th class="border px-3 py-2 text-center">Action</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!empty($recent_inspections)): ?>
							<?php foreach ($recent_inspections as $i): ?>
								<tr class="hover:bg-gray-50">

									<td class="border px-3 py-2 font-medium">
										<?= $i->inspection_id ?>
									</td>

									<td class="border px-3 py-2">
										<?= $i->registration_no ?>
									</td>

									<td class="border px-3 py-2">
										<?= $i->customer_name ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?= number_format($i->km_reading) ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?php if ($i->status == 'Draft'): ?>
											<span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-700">
												Draft
											</span>
										<?php elseif ($i->status == 'Completed'): ?>
											<span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
												Completed
											</span>
										<?php else: ?>
											<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
												Approved
											</span>
										<?php endif; ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<?= date('d-m-Y', strtotime($i->inspection_date)) ?>
									</td>

									<td class="border px-3 py-2 text-center">
										<a href="<?= base_url('index.php/inspection/view/' . $i->inspection_id); ?>"
											class="px-3 py-1 text-xs bg-indigo-600 text-white rounded">
											View
										</a>
									</td>

								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="7"
									class="border px-3 py-6 text-center text-gray-500">
									No inspections found
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>

		</div>


		<?php foreach ($jobcardProgress as $row):
			$percent = ($row->total_jobs > 0)
				? round(($row->completed_jobs / $row->total_jobs) * 100)
				: 0;
		?>

			<div class="bg-white p-4 rounded shadow p-6 mt-6 mb-4">
				<div class="flex justify-between items-center mb-1">
					<div>
						<div class="font-semibold text-gray-800">
							<?= $row->jobcard_no ?>
						</div>
						<div class="text-sm text-gray-500">
							<?= $row->completed_jobs ?> / <?= $row->total_jobs ?> jobs completed
						</div>
					</div>

					<div class="text-right">
						<div class="text-sm font-semibold"><?= $percent ?>%</div>
					</div>
				</div>

				<div class="w-full bg-gray-200 rounded-full h-2">
					<div
						class="h-2 rounded-full transition-all"
						style="width: <?= $percent ?>%;
                   background-color:
                   <?= $percent == 100 ? '#22c55e' : ($percent >= 50 ? '#3b82f6' : '#facc15') ?>;">
					</div>
				</div>
			</div>

		<?php endforeach; ?>




		<!-- ===================================================== -->
	</div>
</div>
