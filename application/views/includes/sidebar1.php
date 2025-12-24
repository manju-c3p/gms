<aside id="sidebar" class="sidebar flex flex-col">
  <div class="brand">DMS</div>
  <nav>
    <a href="<?php echo base_url().'index.php/Dashboard'; ?>" class="active">Dashboard</a>

    <div class="has-submenu">
      <a href="#">Features ▾</a>
      <div class="submenu">
        <a href="<?php echo base_url().'index.php/Setup/add_user'; ?>">User Management</a>
        <a href="features.html#file-management">File Management</a>
        <a href="features.html#search-files">Search Files</a>
        <a href="features.html#doc-update">Document Update Notifications</a>
      </div>
    </div>

    <div class="has-submenu">
      <a href="#">Collaboration ▾</a>
      <div class="submenu">
        <a href="collaboration.html#annotation">Document Annotation</a>
        <a href="collaboration.html#comments">Threaded Comments</a>
      </div>
    </div>

    <div class="has-submenu">
      <a href="#">UX & Mobility ▾</a>
      <div class="submenu">
        <a href="ux.html#responsive">Responsive Interface</a>
        <a href="ux.html#dashboard">Personalized Dashboards</a>
        <a href="ux.html#notifications">Smart Notifications & Alerts</a>
        <a href="ux.html#rbac">Role-Based Access Control</a>
        <a href="ux.html#approval">Automated Approval Workflows</a>
      </div>
    </div>
  </nav>
</aside>

<!-- Main content -->
<div class="flex-1 flex flex-col overflow-auto md:ml-[260px]">
