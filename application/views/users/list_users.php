 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
 <!-- DataTables -->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

 <div class="container bg-white p-4 rounded shadow">

 	<div class="d-flex justify-content-between align-items-center mb-3">
 		<h2>User Records</h2>
 		<a href="<?= base_url('index.php/Setup/add_user'); ?>" class="btn btn-success">+ Add User</a>
 	</div>

	<div class="d-flex justify-content-end align-items-center mb-3 gap-3">

    <div>
        <span class="d-inline-block rounded-circle" 
              style="width:12px; height:12px; background:#3b82f6;"></span>
        <span class="ms-1">Active Users</span>
    </div>

    <div>
        <span class="d-inline-block rounded-circle" 
              style="width:12px; height:12px; background:#ef4444;"></span>
        <span class="ms-1">Inactive Users</span>
    </div>

</div>

<div class="table-responsive">
 	<table id="userTable" class="table table-striped table-bordered">
 		<thead class="">
 			<tr>
 				<th>ID</th>
 				<th>Name</th>

 				<th>Email</th>
 				<th>Username</th>
 				<th>Role</th>
 				<th>Department</th>
 				<th>Contact</th>
 				<th>Status</th>
 				<th>Action</th>
 			</tr>
 		</thead>

 		<tbody>
 			<?php foreach ($users as $u): ?>
 				<tr>
 					<td><?= $u->id ?></td>
 					<td><?= $u->first_name . ' ' . $u->last_name ?></td>

 					<td><?= $u->email ?></td>
 					<td><?= $u->username ?></td>
 					<td><?= $u->role ?></td>
 					<td><?= $u->department ?></td>
 					<td><?= $u->contact_no ?></td>
 					<td class="text-center">
 						<?php if ($u->status == "Active"): ?>
 							<span class="inline-block w-3 h-3 bg-blue-500 rounded-full"></span>
 						<?php else: ?>
 							<span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
 						<?php endif; ?>
 					</td>



 					<td>
 						<a href="<?= base_url('index.php/Setup/edit_user/' . $u->id); ?>"
 							class="btn btn-sm btn-primary">Edit</a>

 						<a href="<?= base_url('index.php/Setup/delete_user/' . $u->id); ?>"
 							class="btn btn-sm btn-danger"
 							onclick="return confirm('Are you sure you want to delete this user?');">
 							Delete
 						</a>
 					</td>
 				</tr>
 			<?php endforeach; ?>
 		</tbody>

 	</table>
</div>
 </div>

 <!-- JS -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

 <script>
 	$(document).ready(function() {
 		$('#userTable').DataTable();
 	});
 </script>
