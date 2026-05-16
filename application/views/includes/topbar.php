<div class="topbar">

	<!-- LEFT -->
	<div class="flex items-center space-x-3">
		<button id="sidebar-toggle" class="md:hidden text-xl">☰</button>
		<h1 class="text-lg md:text-xl font-bold">Dashboard</h1>
	</div>

	<!-- RIGHT -->
	<div class="flex items-center space-x-3">

		<!-- DESKTOP ACTION BUTTONS hidden-->
		<div class="topbar-actions  md:flex items-center space-x-2">
			<a href="<?= base_url('index.php/Inspection'); ?>" class="topbar-btn inspection-btn">
				Inspection
			</a>
			<a href="<?= base_url('index.php/Estimation'); ?>" class="topbar-btn estimation-btn">
				Estimation
			</a>
			<a href="<?= base_url('index.php/Quotation'); ?>" class="topbar-btn quotation-btn">
				Quotation
			</a>
			<a href="<?= base_url('index.php/Jobcard'); ?>" class="topbar-btn jobcard-btn">
				Job Card
			</a>
		</div>

		<!-- MOBILE ACTION DROPDOWN -->
		<div class="relative md:hidden">
			<button id="mobile-actions-btn"
				class="border px-3 py-1 rounded text-sm font-semibold">
				Actions ▾
			</button>

			<div id="mobile-actions-menu"
				class="hidden absolute right-0 mt-2 bg-white shadow-lg rounded-lg border p-3 space-y-2 z-50">
				<a href="<?= base_url('index.php/Inspection'); ?>" class="topbar-btn inspection-btn block">
					Inspection
				</a>
				<a href="<?= base_url('index.php/Estimation'); ?>" class="topbar-btn estimation-btn block">
					Estimation
				</a>
				<a href="<?= base_url('index.php/Quotation'); ?>" class="topbar-btn quotation-btn block">
					Quotation
				</a>
				<a href="<?= base_url('index.php/Jobcard'); ?>" class="topbar-btn jobcard-btn block">
					Job Card
				</a>
			</div>
		</div>

		<!-- 🔔 NOTIFICATION -->
		<div class="relative ml-2">
			<button id="notif-btn" class="text-xl relative">
				🔔
				<span id="notif-count"
					class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1 rounded-full hidden">
					0
				</span>
			</button>

			<div id="notif-menu"
				class="hidden absolute right-0 mt-2 w-72 bg-white shadow-lg rounded-lg border z-50">
				<div id="notif-list" class="max-h-60 overflow-y-auto">
					<p class="text-center text-gray-500 p-2">Loading...</p>
				</div>
			</div>
		</div>

		<!-- 🔒 LOGOUT -->
		<p class="text-gray-500">Welcome, <b><?= $this->session->userdata('username'); ?></b></p>
		<a href="<?= site_url('Login/logout'); ?>"
			onclick="return confirm('Are you sure you want to log out?');"
			class="ml-2 text-gray-600 hover:text-red-500 transition"
			title="Logout">
			<i class="fas fa-sign-out-alt text-lg"></i>
		</a>

	</div>

</div>


<script>
	document.getElementById('mobile-actions-btn')?.addEventListener('click', function() {
		document.getElementById('mobile-actions-menu').classList.toggle('hidden');
	});

	document.getElementById('notif-btn')?.addEventListener('click', function() {
		document.getElementById('notif-menu').classList.toggle('hidden');
	});
</script>
<style>
	.topbar-actions {
		/* display: flex; */
		align-items: center;
	}

	.topbar-btn {
		padding: 6px 14px;
		border-radius: 6px;
		font-size: 13px;
		font-weight: 600;
		text-decoration: none;
		color: #fff;
		transition: all 0.2s ease;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
	}

	/* Button colors */
	.inspection-btn {
		background: #0dcaf0;
		/* blue */
	}

	.estimation-btn {
		background: #ffc107;
		/* yellow */
		color: #000;
	}

	.jobcard-btn {
		background: #198754;
		/* green */
	}

	.quotation-btn {
		background: #0d6efd;
		/* indigo / primary blue */
		color: #fff;
	}

	/* Hover effects */
	.topbar-btn:hover {
		transform: translateY(-1px);
		box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
		opacity: 0.95;
	}
</style>
