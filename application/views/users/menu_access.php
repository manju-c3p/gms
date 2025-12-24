<div class="min-h-screen bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">User Access Control</h2>
      <a href="<?php echo base_url('index.php/MenuController'); ?>"
         class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        Back to Menu List
      </a>
    </div>

    <!-- User Dropdown -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-1">Select User</label>
      <select id="userSelect"
              class="border rounded-lg px-4 py-2 w-full"
              onchange="loadUserAccess(this.value)">
        <option value="">-- Select User --</option>
        <?php foreach ($users as $u): ?>
          <option value="<?php echo $u->id; ?>"><?php echo $u->username; ?></option>
        <?php endforeach; ?>
      </select>
      <p class="text-xs text-gray-500 mt-1">Choose a user to view and modify menu access.</p>
    </div>

    <!-- Menu Tree -->
    <div id="menuTree" class="border rounded-lg p-4 bg-gray-50 text-sm text-gray-800">
      <p class="text-gray-500 italic">Select a user to load menus...</p>
    </div>

    <!-- Save Button -->
    <div class="mt-6 text-center">
      <button onclick="saveAccess()"
              class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
        Save Access Rights
      </button>
    </div>
  </div>

  <!-- 🧭 Developer Help Sidebar -->
  <!-- <div class="fixed right-6 top-20 w-64 bg-gray-50 border border-gray-200 rounded-lg shadow-sm p-4 text-xs text-gray-600 leading-relaxed">
    <strong>🧭 Developer Notes:</strong>
    <ul class="list-disc pl-4 mt-2 space-y-1">
      <li>Select user → system loads menus.</li>
      <li>Parent check → auto selects submenus.</li>
      <li>Uncheck parent → removes submenu selections.</li>
      <li>Access saved in <code>user_menu_access</code> table.</li>
      <li>AJAX-based saving for smoother UX.</li>
    </ul>
  </div> -->
</div>

<script>
function loadUserAccess(userId) {
  if (!userId) {
    document.getElementById('menuTree').innerHTML = '<p class="text-gray-500 italic">Select a user to load menus...</p>';
    return;
  }

  fetch('<?php echo site_url("MenuController/get_user_access/"); ?>' + userId)
    .then(res => res.text())
    .then(html => document.getElementById('menuTree').innerHTML = html);
}

// Handle parent-child checkbox behavior
document.addEventListener('change', function(e) {
  if (e.target.classList.contains('parent-menu')) {
    let parentId = e.target.dataset.id;
    document.querySelectorAll('.submenu[data-parent="' + parentId + '"]').forEach(cb => {
      cb.checked = e.target.checked;
    });
  }
});

// Save Access

function saveAccess() {
  const userId = document.getElementById('userSelect').value;
  if (!userId) {
    alert('Please select a user first.');
    return;
  }

  const checkedMenus = Array.from(document.querySelectorAll('.menu-checkbox:checked'))
                            .map(cb => cb.value);

  fetch('<?php echo site_url("MenuController/save_user_access"); ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ user_id: userId, menu_ids: checkedMenus })
  })
  .then(res => res.json())
  .then(resp => {
    alert(resp.message || 'Access rights saved successfully!');

    // ✅ Refresh page after 1 second to load fresh data
    setTimeout(() => {
      window.location.reload();
    }, 1000);
  })
  .catch(err => {
    console.error(err);
    alert('Error saving access. Please try again.');
  });
}


</script>
