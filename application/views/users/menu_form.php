<div class="min-h-screen bg-gray-100 p-6">
	<div class="flex flex-row justify-between items-start gap-6">

		<!-- 🌟 Main Form Section -->
		<div class="flex-1 bg-white shadow-lg rounded-xl p-8">
			<div class="flex justify-between items-center mb-6">
				<h2 class="text-2xl font-bold">
					<?php echo isset($menu) ? 'Edit Menu' : 'Add New Menu'; ?>
				</h2>
				<a href="<?php echo base_url('index.php/MenuController'); ?>"
					class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
					List Menus
				</a>
			</div>

			<!-- 🧾 Menu Form -->
			<form method="post" action="<?php echo site_url('MenuController/save'); ?>">

				<?php if (isset($menu)): ?>
					<input type="hidden" name="menu_id" value="<?php echo $menu->menu_id; ?>">
				<?php endif; ?>

				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

					<!-- Menu Name -->
					<div>
						<label class="block text-sm font-medium mb-1">Menu Name <span class="text-red-500">*</span></label>
						<input type="text"
							name="menu_name"
							required
							value="<?php echo $menu->menu_name ?? ''; ?>"
							class="border rounded-lg px-4 py-2 w-full"
							placeholder="Enter menu name">
						<p class="text-xs text-gray-500 mt-1">Example: Dashboard, Sales, Reports, etc.</p>
					</div>

					<!-- Menu URL -->
					<div>
						<label class="block text-sm font-medium mb-1">Menu URL (Controller/Function)</label>
						<input type="text"
							name="menu_url"
							value="<?php echo $menu->menu_url ?? ''; ?>"
							placeholder="e.g. dashboard/index"
							class="border rounded-lg px-4 py-2 w-full">
						<p class="text-xs text-gray-500 mt-1">Leave blank if this is a <strong>Parent Menu</strong> (no direct link).</p>
					</div>

					<!-- Parent Menu -->
					<div>
						<label class="block text-sm font-medium mb-1">Parent Menu</label>
						<select name="parent_id" class="border rounded-lg px-4 py-2 w-full">
							<option value="">-- No Parent (Top-Level Menu) --</option>
							<?php foreach ($parents as $p): ?>
								<option value="<?php echo $p->menu_id; ?>"
									<?php echo (isset($menu) && $menu->parent_id == $p->menu_id) ? 'selected' : ''; ?>>
									<?php echo $p->menu_name; ?>
								</option>
							<?php endforeach; ?>
						</select>
						<p class="text-xs text-gray-500 mt-1">
							If this is a <strong>main parent menu</strong>, leave blank.<br>
							If this is a <strong>submenu</strong>, choose its parent.
						</p>
					</div>

					<!-- Sort Order -->
					<div>
						<label class="block text-sm font-medium mb-1">Sort Order (Optional)</label>
						<input type="number" step="0.1"
							name="sort_order"
							value="<?php echo $menu->sort_order ?? ''; ?>"
							class="border rounded-lg px-4 py-2 w-full">
						<p class="text-xs text-gray-500 mt-1">
							Determines display order. Use <strong>1, 2, 3</strong> for main menus,
							or <strong>1.1, 1.2</strong> for submenus.
						</p>
					</div>

					<!-- Active Status -->
					<div class="col-span-1 md:col-span-2">
						<label class="block text-sm font-medium mb-1">Active Status</label>
						<div class="flex items-center space-x-2 mt-1">
							<input type="checkbox" name="is_active" id="is_active"
								<?php echo !empty($menu->is_active) ? 'checked' : ''; ?>
								class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
							<label for="is_active" class="text-gray-700">Enable this menu</label>
						</div>
						<p class="text-xs text-gray-500 mt-1">
							Uncheck to deactivate (instead of deleting). Inactive menus won’t appear for users.
						</p>
					</div>
				</div>

				<!-- Buttons -->
				<div class="flex justify-center mt-8 space-x-4">
					<button type="submit"
						class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
						Save Menu
					</button>

					<a href="<?php echo base_url('index.php/MenuController'); ?>"
						class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition">
						Cancel
					</a>
				</div>
			</form>
		</div>

		<!-- 🧭 Developer Notes Sidebar -->
		<div class="w-72 bg-gray-50 border border-gray-200 rounded-lg shadow-md p-5 text-xs text-gray-700 leading-relaxed sticky top-8 self-start">
			<strong class="block text-sm text-gray-800 mb-2">🧭 Developer Notes</strong>

			<ul class="list-disc pl-4 mt-2 space-y-1">
				<li><strong>Menu Name:</strong> Required field for display name.</li>
				<li><strong>Menu URL:</strong> Leave blank if this is a <em>Parent Menu</em>.</li>
				<li><strong>Parent Menu:</strong> Select only for <em>Submenus</em>.</li>
				<li><strong>Sort Order:</strong> Controls display order visually.</li>
				<li><strong>Active:</strong> Acts as a soft delete toggle.</li>
				<li><strong>💡 Tip (Insert Between):</strong> Use decimal values to insert between menus (e.g. <code>2.5</code>).</li>
				<li><strong>📂 Tip (For Submenus):</strong> Use incremental decimals for submenus (e.g. <code>1.1, 1.2</code>).</li>
			</ul>

			<hr class="my-3 border-gray-300">

			<div class="mt-2 text-[11px] text-gray-500 leading-snug">
				<strong>Example:</strong><br>
				If you have:<br>
				<code>1. Dashboard</code><br>
				<code>2. Masters</code><br>
				<code>3. Reports</code><br><br>
				and you want “Transactions” between 2 and 3:<br>
				👉 Give it <code>2.5</code><br><br>
				For submenus under “Masters”:<br>
				<code>1.1 Customers</code><br>
				<code>1.2 Vendors</code>
			</div>
		</div>
	</div>
</div>

