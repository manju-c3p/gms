<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.3.1/js/dataTables.rowGroup.min.js"></script>

<style>
	.vehicle-group {
		font-size: 20px;
		font-weight: bold;
		background: #f8f9fa;
		padding: 10px;
	}

	.model-text {
		font-size: 14px;
		color: #777;
		margin-left: 8px;
	}
</style>

<div class="container mt-4">

	<table id="policyTable" class="display table table-striped" style="width:100%">
		<thead>
			<tr>
				<!-- <th>Vehicle</th>      -->
				<th>Company</th>
				<th>Policy Number</th>
				<th>Start</th>
				<th>Expiry</th>
				<th>Premium</th>
				<th>Document</th>
				<th>Actions</th>
			</tr>
		</thead>

		<tbody>

			<?php foreach ($vehicles as $v): ?>

				<!-- ADD POLICY ROW -->
				<tr>
					<!-- col 1: hidden vehicle column -->
					<td><?= $v->registration_no ?> (<?= $v->model ?>)</td>

					<!-- col 2–8 merged -->
					<td colspan="7">
						<button class="btn btn-primary btn-sm"
							onclick="addPolicy(<?= $v->vehicle_id ?>)">
							+ Add Policy
						</button>
					</td>
				</tr>

				<?php foreach ($v->policies as $p): ?>
					<tr>
						<!-- <td><?= $v->registration_no ?> (<?= $v->model ?>)</td> -->
						<td><?= $p->company_name ?></td>
						<td><?= $p->policy_number ?></td>
						<td><?= $p->start_date ?></td>
						<td><?= $p->expiry_date ?></td>
						<td>₹<?= number_format($p->premium_amount, 2) ?></td>
						<td>
							<?php if ($p->policy_document): ?>
								<a href="<?= base_url('uploads/policies/' . $p->policy_document) ?>" target="_blank">View</a>
							<?php else: ?>
								—
							<?php endif; ?>
						</td>
						<td>
							<button class="btn btn-warning btn-sm" onclick="editPolicy(<?= $p->policy_id ?>)">✏️</button>
							<button class="btn btn-danger btn-sm" onclick="deletePolicy(<?= $p->policy_id ?>)">🗑</button>
						</td>
					</tr>
				<?php endforeach; ?>

			<?php endforeach; ?>

		</tbody>

	</table>

</div>

<script>
	$(document).ready(function() {
		$('#policyTable').DataTable({
			pageLength: 10,
			order: [
				[0, 'asc']
			],
			rowGroup: {
				dataSrc: 0,
				startRender: function(rows, group) {
					return $('<tr/>')
						.append('<td colspan="8" class="vehicle-group">' + group + '</td>');
				}
			},
			columnDefs: [{
					"visible": false,
					"targets": 0
				} // hide Vehicle column
			]
		});
	});

	function addPolicy(vehicle_id) {
		window.location.href = "<?= base_url('insurance/add/') ?>" + vehicle_id;
	}

	function editPolicy(id) {
		window.location.href = "<?= base_url('insurance/edit/') ?>" + id;
	}

	function deletePolicy(id) {
		if (confirm("Delete this policy?")) {
			window.location.href = "<?= base_url('insurance/delete/') ?>" + id;
		}
	}
</script>
