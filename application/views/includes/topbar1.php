<div class="topbar">
	<div class="flex items-center space-x-3">
		<button id="sidebar-toggle" class="md:hidden">☰</button>
		<h1 class="text-xl font-bold">Dashboard</h1>
	</div>
	<div class="flex items-center">
		<!-- <div class="dropdown ml-4 relative">
			<button class="dropdown-btn" id="notif-btn">
				🔔
				<span id="notif-count" class="badge hidden">0</span>
			</button>

			<div class="dropdown-content absolute left-0 mt-2 w-72 bg-white shadow-lg rounded-lg border hidden" id="notif-menu">
				<div id="notif-list" class="max-h-60 overflow-y-auto">
					<p class="text-center text-gray-500 p-2">Loading...</p>
				</div>
			</div>
		</div> -->

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
		<input type="text" placeholder="Search documents...">
		<div class="dropdown">
			<button class="dropdown-btn">Filters ▼</button>
			<div class="dropdown-content">
				<a href="#">All Documents</a>
				<a href="#">Recently Modified</a>
				<a href="#">Favorites</a>
			</div>
		</div>


		<div class="dropdown">
			<button class="dropdown-btn">Group By ▼</button>
			<div class="dropdown-content">
				<a href="#">Type</a>
				<a href="#">Date</a>
				<a href="#">Owner</a>
			</div>
		</div>

		<button class="favorite-btn ml-2">★ Favorite Filters</button>


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
