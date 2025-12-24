

<div class="min-h-screen bg-gray-100 p-6">
	<div class="w-full bg-white shadow-lg rounded-xl p-8">
		<div class="flex justify-between items-center mb-6">
			<h2 class="text-2xl font-bold">
				<?php echo isset($menu) ? 'Edit Menu' : 'Add New Menu'; ?>
			</h2>
			<a href="<?php echo base_url('index.php/MenuController'); ?>" 
				class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
				List Menus
			</a>
		</div>

		<form method="post" action="<?php echo site_url('MenuController/save'); ?>">
			<?php if (isset($menu)): ?>
				<input type="hidden" name="menu_id" value="<?php echo $menu->menu_id; ?>">
			<?php endif; ?>

			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<!-- Menu Name -->
				<div>
					<label class="block text-sm font-medium mb-1">Menu Name</label>
					<input type="text" 
						   name="menu_name" 
						   required 
						   value="<?php echo $menu->menu_name ?? ''; ?>" 
						   class="border rounded-lg px-4 py-2 w-full" 
						   placeholder="Enter menu name">
				</div>

				<!-- Menu URL -->
				<div>
					<label class="block text-sm font-medium mb-1">Menu URL (Controller/Function)</label>
					<input type="text" 
						   name="menu_url" 
						   value="<?php echo $menu->menu_url ?? ''; ?>" 
						   placeholder="e.g. dashboard/index"
						   class="border rounded-lg px-4 py-2 w-full">
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
				</div>

				<!-- Sort Order -->
				<div>
					<label class="block text-sm font-medium mb-1">Sort Order (leave blank for auto)</label>
					<input type="number" step="0.1" 
						   name="sort_order" 
						   value="<?php echo $menu->sort_order ?? ''; ?>" 
						   class="border rounded-lg px-4 py-2 w-full">
				</div>

				<!-- Active Status -->
				<div>
					<label class="block text-sm font-medium mb-1">Active</label>
					<div class="flex items-center space-x-2 mt-1">
						<input type="checkbox" name="is_active" id="is_active"
							<?php echo !empty($menu->is_active) ? 'checked' : ''; ?>
							class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
						<label for="is_active" class="text-gray-700">Enable this menu</label>
					</div>
				</div>
			</div>

			<!-- Action Buttons -->
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
</div>

