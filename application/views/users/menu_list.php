<div class="min-h-screen bg-gray-100 p-6 flex flex-row items-start space-x-4">

	<!-- ===== Main Container ===== -->

	<div class="flex-1 bg-white shadow-lg rounded-xl p-6 overflow-auto">

		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-bold text-gray-800">All Menus</h2>
			<div>
				<a href="<?php echo site_url('MenuController/add'); ?>"
					class="bg-blue-100 text-blue-800 px-4 py-2 mr-4 rounded-lg text-sm font-medium hover:bg-blue-200 transition">
					+ Add New Menu
				</a>
				<a href="<?php echo site_url('MenuController/access_control'); ?>"
					class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-200 transition">
					+ Add Menu Access
				</a>
			</div>
		</div>

		<hr class="mb-6">

		<?php
		// Recursive menu rendering function
		function render_menu($tree, $parent_id = null)
		{
			if (isset($tree[$parent_id])) {
				echo "<ul class='ml-4'>";
				foreach ($tree[$parent_id] as $menu) {
					$isInactive = empty($menu->is_active);

					// Card background colors
					$bgColor = $isInactive
						? 'bg-gray-100'
						: ($menu->parent_id == null ? 'bg-blue-50' : 'bg-gray-50');

					echo "<li class='border border-blue-100 rounded-lg p-3 mb-2 {$bgColor}'>";

					// Menu Name
					echo "<div class='flex justify-between items-center'>";
					echo "<div>";
					echo "<strong class='text-gray-900 " . ($isInactive ? 'line-through' : '') . "'>{$menu->menu_name}</strong>";
					if (!empty($menu->menu_url)) {
						echo " <span class='text-gray-500 text-sm'>({$menu->menu_url})</span>";
					}
					echo "</div>";

					// Action Buttons
					echo "<div>";

					// Edit Button
					echo "<a href='" . site_url('MenuController/edit/' . $menu->menu_id) . "'
                            class='btn btn-sm'
                            style='background:#cce5ff; color:#004085; border:1px solid #b8daff; padding:4px 10px; border-radius:6px; font-size:13px; margin-right:5px;'>
                            Edit
                          </a>";

					if ($isInactive) {
						echo "<a href='" . site_url('MenuController/reactivate/' . $menu->menu_id) . "'
								onclick=\"return confirm('Reactivate this menu?')\"
                                class='btn btn-sm'
                                style='background:#d4edda; color:#155724; border:1px solid #c3e6cb; padding:4px 10px; border-radius:6px; font-size:13px;'>
                                Reactivate
                              </a>";
					} else {
						echo "<a href='" . site_url('MenuController/deactivate/' . $menu->menu_id) . "'
								onclick=\"return confirm('Deactivate this menu?')\"
                                class='btn btn-sm'
                                style='background:#fff3cd; color:#856404; border:1px solid #ffeeba; padding:4px 10px; border-radius:6px; font-size:13px;'>
                                Deactivate
                              </a>";
					}

					echo "</div>";
					echo "</div>";

					// Recursive call
					render_menu($tree, $menu->menu_id);

					echo "</li>";
				}
				echo "</ul>";
			}
		}

		render_menu($menu_tree);
		?>
	</div>

	<!-- ===== Legend Sidebar ===== -->
	<div class="w-1/5 ml-4">
		<div class="bg-white shadow-md rounded-xl p-4 text-sm border border-gray-200">
			<h3 class="font-semibold text-gray-700 mb-2">🎨 Legend</h3>
			<ul class="space-y-1">
				<li><span class="inline-block w-4 h-4 bg-blue-50 border border-blue-200 mr-2 align-middle"></span> Parent Menu</li>
				<li><span class="inline-block w-4 h-4 bg-gray-50 border border-gray-200 mr-2 align-middle"></span> Child Menu</li>
				<li><span class="inline-block w-4 h-4 bg-gray-100 border border-gray-300 mr-2 align-middle"></span> Inactive Menu</li>
			</ul>
			<p class="text-xs text-gray-400 mt-3 italic">For developer reference only</p>
		</div>
	</div>
</div>

<!-- Hover effect -->
<style>
	.btn-sm {
		transition: all 0.2s ease-in-out;
		text-decoration: none;
	}

	.btn-sm:hover {
		filter: brightness(95%);
	}
</style>
