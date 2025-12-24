<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<h2 class="text-2xl font-bold mb-6">Insurance Claims </h2>

	<!-- Group by Policy -->
	<?php foreach ($policies as $p): ?>

		<div class="border rounded-xl p-5 mb-6 bg-gray-50">

			<!-- POLICY HEADER -->
			<h3 class="text-xl font-semibold mb-2 flex items-center justify-between">

				<!-- Left side (policy label) -->
				<span>
					Policy: <span class="text-blue-700 font-bold"><?= $p->policy_number ?></span>
					<span class="text-gray-600 text-sm">
						(<?= $p->company_name ?>)
					</span>
				</span>

				<!-- Vehicle Info -->
				<span class="text-gray-700 text-sm">
					Vehicle: <?= $p->registration_no ?>
					(<?= $p->brand ?> <?= $p->model ?>)
				</span>
			</h3>

			<!-- CLAIMS TABLE -->
			<table class="w-full border rounded bg-white">
				<thead class="bg-gray-200">
					<tr>
						<th class="p-3 text-left">Claim Date</th>
						<th class="p-3 text-left">Claim No</th>
						<th class="p-3 text-left">Amount</th>
						<th class="p-3 text-left">Status</th>
						<th class="p-3 text-center">Actions</th>
					</tr>
				</thead>

				<tbody>
					<?php if (!empty($p->claims)): ?>
						<?php foreach ($p->claims as $c): ?>
							<tr class="border-b hover:bg-gray-50">

								<td class="p-3"><?= $c->claim_date ?></td>
								<td class="p-3"><?= $c->claim_number ?></td>
								<td class="p-3">₹<?= $c->claim_amount ?></td>
								<td class="p-3"><?= $c->status ?></td>

								<td class="p-3 text-center flex justify-center gap-3">
									<!-- View -->
									<a href="<?= base_url('index.php/claim/view/' . $c->claim_id); ?>"
										class="p-2 bg-blue-100 rounded"
										title="View Claim">
										👁️
									</a>

									<!-- Edit -->
									<a href="<?= base_url('index.php/claim/edit/' . $c->claim_id); ?>"
										class="p-2 bg-yellow-100 rounded"
										title="Edit Claim">
										✏️
									</a>

									<!-- Delete -->
									<a onclick="return confirm('Delete this claim?')"
										href="<?= base_url('index.php/claim/delete/' . $c->claim_id . '/' . $p->policy_id); ?>"
										class="p-2 bg-red-100 rounded"
										title="Delete Claim">
										🗑️
									</a>

								</td>

							</tr>
						<?php endforeach; ?>

					<?php else: ?>

						<tr>
							<td colspan="5" class="p-3 text-center text-gray-500">
								No claims recorded for this policy.
							</td>
						</tr>

					<?php endif; ?>
				</tbody>
			</table>

			<!-- ADD CLAIM BUTTON -->
			<div class="mt-3">
				<a href="<?= base_url('index.php/claim/add/' . $p->policy_id); ?>"
					class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
					+ Add Claim
				</a>
			</div>

		</div>

	<?php endforeach; ?>

</div>
