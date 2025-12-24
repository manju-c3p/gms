<style>
	/* Main menu (parent items) */
	.sidebar nav .has-submenu>a {
		font-weight: 600;
		/* Bold */
		font-size: 0.9rem;
		/* One size smaller */
		/* font-weight: 600;          
    font-size: 1rem;             */
		color: #1f2937;
		/* Gray-800 */
		padding: 10px 16px;
		display: block;
		background-color: #f9fafb;
		/* subtle background */
		border-radius: 6px;
		margin: 4px 0;
	}

	/* Hover effect for parent menu */
	.sidebar nav .has-submenu>a:hover {
		background-color: #e5e7eb;
		/* Gray-200 */
	}

	/* Submenu container */
	.sidebar nav .submenu {
		padding-left: 18px;
		margin-top: 2px;
	}

	/* Submenu items */
	.sidebar nav .submenu a {
		font-size: 0.875rem;
		/* Smaller font */
		font-weight: 400;
		/* Normal weight */
		color: #4b5563;
		/* Gray-600 */
		padding: 6px 12px;
		display: block;
		border-radius: 4px;
	}

	/* Submenu hover */
	.sidebar nav .submenu a:hover {
		background-color: #f3f4f6;
		/* Gray-100 */
		color: #111827;
		/* Dark */
	}

	/* Dashboard link styling */
	.sidebar nav>a.active {
		font-weight: 700;
		background-color: #2563eb;
		/* Blue-600 */
		color: white;
		padding: 10px 16px;
		border-radius: 6px;
		margin-bottom: 8px;
	}
</style>

<!-- =============================================== -->
<aside id="sidebar" class="sidebar flex flex-col">
<div class="brand flex items-center gap-3 px-4 py-3">
    <img src="<?= base_url('public/images/car1.png') ?>"
         alt="GMS Logo"
         class="h-10 w-auto">

    <h2 class="text-xl font-semibold text-gray-800 whitespace-nowrap">
        Auto 360+
    </h2>
</div>


	<nav>
		<!-- 🧭 Fixed Dashboard Link -->
		<a href="<?php echo base_url('index.php/Dashboard'); ?>" class="active">Dashboard</a>
		<?php
		// ✅ Get user ID from session
		$user_id = $this->session->userdata('user_id');

		// ✅ Fetch menus user can access
		$this->db->select('m.*');
		$this->db->from('menus m');
		$this->db->join('user_menu_access uma', 'uma.menu_id = m.menu_id');
		$this->db->where('uma.user_id', $user_id);
		$this->db->where('m.is_active', 1);
		$this->db->order_by('m.sort_order', 'ASC');
		$menus = $this->db->get()->result();

		// ✅ Build parent → child tree
		$menu_tree = [];
		foreach ($menus as $menu) {
			$menu_tree[$menu->parent_id][] = $menu;
		}

		// ✅ Recursive renderer (keeps your HTML layout)
		function render_sidebar_menu($tree, $parent_id = 0)
		{
			if (!isset($tree[$parent_id])) return;

			foreach ($tree[$parent_id] as $menu) {
				$has_sub = isset($tree[$menu->menu_id]);
				$url = $menu->menu_url ? base_url('index.php/' . $menu->menu_url) : '#';

				if ($has_sub) {
					// 🌳 Parent menu with submenu
					echo '<div class="has-submenu">';
					echo '<a href="' . $url . '">' . htmlspecialchars($menu->menu_name) . ' </a>';
					echo '<div class="submenu">';
					render_sidebar_menu($tree, $menu->menu_id);
					echo '</div>';
					echo '</div>';
				} else {
					// 🌿 Simple menu item
					echo '<a href="' . $url . '">' . htmlspecialchars($menu->menu_name) . '</a>';
				}
			}
		}




		// ✅ Render all top-level menus (parent_id = 0 or NULL)
		if (isset($menu_tree[0])) {
			render_sidebar_menu($menu_tree, 0);
		} elseif (isset($menu_tree[null])) {
			render_sidebar_menu($menu_tree, null);
		} else {
			echo '<p class="text-gray-500 px-4 py-2">No menus assigned.</p>';
		}
		?>
	</nav>
</aside>

<!-- Main content -->
<div class="flex-1 flex flex-col overflow-auto md:ml-[260px]">
