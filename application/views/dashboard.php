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


	</div>
</div>
