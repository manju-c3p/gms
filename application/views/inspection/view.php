<?php
$totalItems = count($items);
$half = ceil($totalItems / 2);

$leftItems  = array_slice($items, 0, $half);
$rightItems = array_slice($items, $half);
// echo $inspection_id;
?>


<div class="w-full bg-white rounded-2xl shadow-md p-6">
	<table class="w-full mb-4 border-collapse">
		<tr>
			<!-- LOGO (LEFT) -->
			<td class="align-top" style="width:40%;">
				<img src="<?= base_url('public/images/logocooling.png') ?>"
					style="height:70px;">
			</td>

			<!-- COMPANY INFO (RIGHT) -->
			<td class="align-top text-right text-sm leading-snug" style="width:65%;">
				<strong>Cool Runnings Garage Co LLC</strong><br>
				Al Quoz 3, Dubai, UAE<br>
				www.coolrunningsgarage.com<br>
				Tel: +971 4 265 4887<br>
				TRN: 104026094300003
			</td>
		</tr>
	</table>

	<hr>


	<!-- ============================================================ -->
	<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">

		<h2 class="text-center text-xl font-bold mb-4">
			VEHICLE HEALTH CHECK (Inventory)
		</h2>
	</div>

	<div>
		<button onclick="window.print()"
			class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded">
			🖨 Print
		</button>
		<a href="<?= base_url('index.php/Inspection/edit/' . $inspection_id); ?>"
			class="w-full sm:w-auto  ml-3 px-6 py-2 bg-gray-300 rounded print:hidden">Cancel</a>


	</div>


	<input type="hidden" name="inspection_id" value="<?= $inspection_id ?>">



	<!-- CUSTOMER / VEHICLE INFO -->
	<div class="overflow-x-auto">
		<table class="w-full border mb-4 text-sm min-w-[600px]">

			<tr>
				<td class="border p-1 font-bold w-1/6">Doc. No</td>
				<td class="border p-1 w-2/6">
					<?= $appointment->doc_no ?? ('VIN-' . str_pad($inspection_id, 6, '0', STR_PAD_LEFT)) ?>
				</td>

				<td class="border p-1 font-bold w-1/6">Doc. Date</td>
				<td class="border p-1 w-2/6">
					<?= date('d/M/Y') ?>
				</td>
			</tr>

			<tr>
				<td class="border p-1 font-bold">Customer Name</td>
				<td class="border p-1">
					<?= $appointment->customer_name ?? $customer->name ?>
				</td>

				<td class="border p-1 font-bold">Reg. No.</td>
				<td class="border p-1">
					<?= $appointment->registration_no ?? $vehicle->registration_no ?>
				</td>
			</tr>

			<tr>
				<td class="border p-1 font-bold">Contact No.</td>
				<td class="border p-1">
					<?= $appointment->phone ?? $customer->phone ?>
				</td>

				<td class="border p-1 font-bold">Make</td>
				<td class="border p-1">
					<?= $appointment->model ?? $vehicle->model ?>
				</td>
			</tr>

			<tr>
				<td class="border p-1 font-bold">Driver Name</td>
				<td class="border p-1">
					<?= $inspection->drivername ?>
				</td>

				<td class="border p-1 font-bold">Veh. Type</td>
				<td class="border p-1">
					<?= $appointment->variant ?? $vehicle->variant ?>
				</td>
			</tr>

			<tr>
				<td class="border p-1 font-bold">Driver Mobile</td>
				<td class="border p-1">
					<?= $inspection->driverphno ?>
				</td>

				<td class="border p-1 font-bold">Model</td>
				<td class="border p-1">
					<?= $appointment->year ?? $vehicle->year ?>
				</td>
			</tr>

			<tr>
				<td class="border p-1 font-bold">Service Advisor</td>
				<td class="border p-1">
					<?= $this->session->userdata('username') ?>
				</td>

				<td class="border p-1 font-bold">KM</td>
				<td class="border p-1">
					<?= $inspection->km_reading ?>
				</td>
			</tr>
		</table>
	</div>


	<!-- INSPECTION ITEMS -->
	<!-- INSPECTION ITEMS (TWO COLUMN LAYOUT) -->
	<!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-4 text-sm"> -->

	<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-4 text-sm print-two-cols">

		<!-- LEFT TABLE -->

		<table class="w-full border">

			<thead class="bg-gray-100">
				<tr>
					<th class="border p-1">Inspection Items</th>
					<th class="border p-1 w-8">A</th>
					<th class="border p-1 w-8">C</th>
					<th class="border p-1 w-8">S</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($leftItems as $index => $i): ?>
					<tr>
						<td class="border p-1">
							<?= ($index + 1) ?>. <?= $i->item_name ?>
						</td>
						<td class="border text-center">
							<input type="radio"
								name="item_status[<?= $i->item_id ?>]"
								value="A" <?= ($item_results[$i->item_id] ?? '') == 'A' ? 'checked' : '' ?>>
						</td>
						<td class="border text-center">
							<input type="radio"
								name="item_status[<?= $i->item_id ?>]"
								value="C" <?= ($item_results[$i->item_id] ?? '') == 'C' ? 'checked' : '' ?>>
						</td>
						<td class="border text-center">
							<input type="radio"
								name="item_status[<?= $i->item_id ?>]"
								value="S" <?= ($item_results[$i->item_id] ?? '') == 'S' ? 'checked' : '' ?>>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>


		<!-- RIGHT TABLE -->

		<table class="w-full border">

			<thead class="bg-gray-100">
				<tr>
					<th class="border p-1">Inspection Items</th>
					<th class="border p-1 w-8">A</th>
					<th class="border p-1 w-8">C</th>
					<th class="border p-1 w-8">S</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rightItems as $index => $i): ?>
					<tr>
						<td class="border p-1">
							<?= ($half + $index + 1) ?>. <?= $i->item_name ?>
						</td>
						<td class="border text-center">
							<input type="radio"
								name="item_status[<?= $i->item_id ?>]"
								value="A" <?= ($item_results[$i->item_id] ?? '') == 'A' ? 'checked' : '' ?>>
						</td>
						<td class="border text-center">
							<input type="radio"
								name="item_status[<?= $i->item_id ?>]"
								value="C" <?= ($item_results[$i->item_id] ?? '') == 'C' ? 'checked' : '' ?>>
						</td>
						<td class="border text-center">
							<input type="radio"
								name="item_status[<?= $i->item_id ?>]"
								value="S" <?= ($item_results[$i->item_id] ?? '') == 'S' ? 'checked' : '' ?>>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>


	</div>
	<div class="mt-3 text-sm flex flex-col sm:items-end sm:text-right">

		<!-- <p class="font-semibold mb-2">Legend:</p> -->

		<div class="flex flex-wrap justify-end gap-6">
			<div class="flex items-center gap-2">
				<span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
				<span><strong>A</strong> – Acceptable</span>
			</div>

			<div class="flex items-center gap-2">
				<span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
				<span><strong>C</strong> – Conditionally Acceptable</span>
			</div>

			<div class="flex items-center gap-2">
				<span class="inline-block w-3 h-3 rounded-full bg-red-500"></span>
				<span><strong>S</strong> – Service Needed</span>
			</div>
		</div>
	</div>

	<div class="bg-white rounded-xl shadow p-4">

		<h3 class="text-lg font-semibold mb-3">Service List</h3>

		<div class="overflow-x-auto">
			<!-- <table class="w-full border text-sm min-w-[500px]" id="serviceTable"> -->
			<table class="w-full border" id="serviceTable">
				<thead class="bg-blue-500 text-white">
					<tr>
						<th class="border px-2 py-2 w-20 text-center">Sl. No.</th>
						<th class="border px-2 py-2">Description / Service</th>
						<!-- <th class="border px-2 py-2 w-16 text-center">Action</th> -->
					</tr>
				</thead>

				<tbody>
					<!-- dynamic rows -->
					<?php foreach ($saved_services as $index => $srv): ?>
						<tr>
							<td class="border px-2 py-2 w-20 text-center"><?= $index + 1 ?></td>
							<td class="border  px-2">
								<?php if ($srv->service_id): ?>
									<?= $service_map[$srv->service_id] ?>
								<?php else: ?>
									<?= $srv->custom_text ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>

				</tbody>
			</table>
		</div>


	</div>





	

	<!-- INVENTORY STATUS -->
	<h4 class="font-bold mb-1 mt-4">INVENTORY STATUS</h4>
	<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 p-4 mt-1">
		

		<?php foreach ($inventory as $inv): ?>
			<label><input type="checkbox" name="inventory_status[]" value="<?= $inv->inventory_status_id ?>" <?= in_array($inv->inventory_status_id, $selected_inventory) ? 'checked' : '' ?>> <?= $inv->status_name ?></label>
		<?php endforeach; ?>
	</div>
<div class="page-break"></div>
	<!-- FOOTER DETAILS -->
	<div class="border mt-6 p-3 text-sm">

		<div class="bg-white rounded-xl shadow p-4 mb-4">
			<h3 class="font-bold text-lg mb-3">Inspection Summary</h3>

			<table class="w-full text-sm border border-gray-300">
				<tbody>
					<tr class="border-b">
						<th class="bg-gray-100 px-3 py-2 text-left w-1/4">Fuel Level</th>
						<td class="px-3 py-2"><?= $inspection->fuel_level ?></td>

						<th class="bg-gray-100 px-3 py-2 text-left w-1/4">Inspection Package</th>
						<td class="px-3 py-2">
							<?php foreach ($packages as $pkg): ?>
								<?= ($inspection->inspackage == $pkg->id) ? $pkg->package_name : '' ?>
							<?php endforeach; ?>
						</td>
					</tr>

					<tr class="border-b">
						<th class="bg-gray-100 px-3 py-2 text-left">Est. Delivery Date</th>
						<td class="px-3 py-2"><?= date('d-m-Y', strtotime($inspection->deliverydate)) ?></td>

						<th class="bg-gray-100 px-3 py-2 text-left">Est. Delivery Time</th>
						<td class="px-3 py-2"><?= $inspection->deliverytime ?></td>
					</tr>

					<tr>
						<th class="bg-gray-100 px-3 py-2 text-left align-top">Remarks</th>
						<td colspan="3" class="px-3 py-2">
							<?= $inspection->remarks ?: '-' ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="bg-white rounded-xl shadow p-4">
			<h3 class="font-bold text-lg mb-3">Vehicle Photos</h3>

			<div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
				<?php foreach ($inspection_photos as $p): ?>
					<div class="relative group">
						<img src="<?= base_url($p->image_path) ?>"
							onclick="openImageModal(this.src)"
							class="w-full h-24 object-cover rounded border cursor-pointer">

						<!-- Optional: remove delete button for pure view page -->
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- ======================================== -->



		<!-- VEHICLE DAMAGE DIAGRAM -->
		<!-- VEHICLE DAMAGE MARKING -->
		<div class="mt-6">
			<h4 class="font-bold mb-2">Vehicle Damage Diagram</h4>

			<div id="damageContainer"
				class="relative inline-block border p-2 cursor-crosshair">

				<img src="<?= base_url('public/images/vehicle-diagram.jpg'); ?>"
					id="vehicleImage"
					class="w-full max-w-xs sm:max-w-sm"
					draggable="false">

				<!-- Existing marks (edit/view) -->
				<?php if (!empty($damage_marks)): ?>
					<?php foreach ($damage_marks as $m): ?>
						<span class="damage-mark absolute text-red-600 font-bold text-lg cursor-pointer"
							data-id="<?= $m->id ?>"
							style="left:<?= $m->x_coordinate ?>px;
                             top:<?= $m->y_coordinate ?>px;">
							✖
						</span>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<p class="text-xs text-gray-500 mt-1">
				Click on vehicle to mark damage. Click ❌ again to remove.
			</p>

			<div class="col-span-3">
				<label class="font-bold block">Technician Remarks</label>
				<input name="tecremarks" value="<?= $inspection->techremarks ?>"
					class="border px-2 py-1 w-full" readonly>
			</div>
		</div>

	</div>
	<p>Printed By : <?php echo $username; ?></p>
	<!-- SAVE BUTTON -->






</div>




<style>
	@media print {
		.print\:hidden {
			display: none !important;
		}

		button,
		.print\:hidden {
			display: none !important;
		}

		.topbar {
			display: none;
		}

		html,
		body {
			height: auto !important;
			overflow: visible !important;
		}

		* {
			overflow: visible !important;
		}

		body {
			background: white;
		}

		div {
			box-shadow: none !important;
		}

		.page-break {
			page-break-before: always;
			/* legacy */
			break-before: page;
			/* modern */
		}
	}
</style>
<style>
	@media print {

		/* Force two-column layout for inspection tables */
		.print-two-cols {
			display: grid !important;
			grid-template-columns: 1fr 1fr !important;
			gap: 16px !important;
		}

		/* Prevent table breaking across pages */
		table {
			page-break-inside: avoid;
		}

		tr {
			page-break-inside: avoid;
		}
	}
</style>
<style>
@media print {

    /* Reduce overall font size */
    body {
        font-size: 10px !important;
        line-height: 1.2 !important;
    }

    /* Reduce heading sizes */
    h1 { font-size: 16px !important; }
    h2 { font-size: 14px !important; }
    h3 { font-size: 12px !important; }
    h4 { font-size: 11px !important; }

    /* Reduce table font and padding */
    table {
        font-size: 10px !important;
    }

    th, td {
        padding: 2px 4px !important;
    }

    /* Reduce section spacing */
    .mb-4 { margin-bottom: 6px !important; }
    .mb-3 { margin-bottom: 4px !important; }
    .mt-6 { margin-top: 6px !important; }
    .p-4  { padding: 6px !important; }
    .p-3  { padding: 4px !important; }
    .p-2  { padding: 2px !important; }
    .p-1  { padding: 1px !important; }

    /* Reduce grid gaps */
    .gap-6 { gap: 6px !important; }
    .gap-3 { gap: 4px !important; }
    .gap-2 { gap: 3px !important; }

    /* Reduce logo size */
    /* img {
        max-height: 55px !important;
    } */

    /* Reduce page margins */
    @page {
        size: A4;
        margin: 8mm !important;
    }

}
</style>

