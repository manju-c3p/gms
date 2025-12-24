
  <!-- Dashboard Cards with clickable links -->
  <main class="p-6 space-y-6">

	<h3>Welcome, <?php echo $username; ?>! <?php 
	// echo $userid;
	 ?></h3>
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

      <!-- Navigation Cards -->
      <a href="#" class="card hover:shadow-lg cursor-pointer">
        <h3>Customer Management</h3>
        <p>User Management, File Management, Search, and Update Notifications.</p>
      </a>

      <a href="#" class="card hover:shadow-lg cursor-pointer">
        <h3>Vehicle Management</h3>
        <p>Document Annotation and Threaded Comments for team collaboration.</p>
      </a>

      <a href="#" class="card hover:shadow-lg cursor-pointer">
        <h3>Appointments & Booking System</h3>
        <p>Responsive Interface, Dashboards, Notifications, RBAC, and Workflows.</p>
      </a>

      <!-- Info Cards -->
      <div class="card">
        <h3>Inventory & Spare Parts Management</h3>
        <!-- <ul>
          <li>Project Proposal.pdf</li>
          <li>Budget Report.xlsx</li>
          <li>Meeting Notes.docx</li>
        </ul> -->
      </div>

      <div class="card">
        <h3>Job Card / Work Order Management</h3>
        <ul>
          <li>Approve Q3 Budget</li>
          <li>Review Legal Docs</li>
        </ul>
      </div>

      <div class="card">
        <h3>Service Management</h3>
        <ul>
          <li>Document "Contract.docx" updated</li>
          <li>User "John Doe" added a comment</li>
        </ul>
      </div>

    </div>
  </main>

	



