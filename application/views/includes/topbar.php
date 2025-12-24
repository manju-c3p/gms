<div class="topbar">
	<div class="flex items-center space-x-3">
		<button id="sidebar-toggle" class="md:hidden">☰</button>
		<h1 class="text-xl font-bold">Dashboard</h1>
	</div>
	<div class="flex items-center">


		<!-- 🔔 Notification dropdown -->
		<div class="dropdown ml-4 relative">
			<button class="dropdown-btn" id="notif-btn">
				🔔
				<span id="notif-count" class="badge hidden">0</span>
			</button>
			<div class="dropdown-content absolute right-0 mt-2 w-72 bg-white shadow-lg rounded-lg border hidden" id="notif-menu">
				<div id="notif-list" class="max-h-60 overflow-y-auto">
					<p class="text-center text-gray-500 p-2">Loading...</p>
				</div>
			</div>
		</div>

		<!-- ================================================================ -->

<div class="topbar-actions flex items-center space-x-2 ml-6">
    <a href="<?= base_url('index.php/inspection'); ?>" class="topbar-btn inspection-btn">
        Inspection
    </a>
    <a href="<?= base_url('index.php/estimation'); ?>" class="topbar-btn estimation-btn">
        Estimation
    </a>
    <a href="<?= base_url('index.php/jobcard'); ?>" class="topbar-btn jobcard-btn">
        Job Card
    </a>
</div>



		<!-- ================================================================================= -->



		<!-- 🔒 Logout button -->
		<!-- Logout icon button -->
		<a href="<?php echo site_url('Login/logout'); ?>"
			onclick="return confirm('Are you sure you want to log out?');"
			class="ml-4 text-gray-600 hover:text-red-500 transition"
			title="Logout">
			<i class="fas fa-sign-out-alt text-lg"></i>
		</a>




	</div>
</div>
<style>
	.topbar-actions {
    display: flex;
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
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

/* Button colors */
.inspection-btn {
    background: #0dcaf0; /* blue */
}

.estimation-btn {
    background: #ffc107; /* yellow */
    color: #000;
}

.jobcard-btn {
    background: #198754; /* green */
}

/* Hover effects */
.topbar-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    opacity: 0.95;
}

</style>
