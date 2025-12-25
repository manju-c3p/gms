<div class="max-w-5xl mx-auto bg-white p-6 text-sm">

    <!-- HEADER -->
    <h2 class="text-center text-xl font-bold mb-4">
        VEHICLE HEALTH CHECK (Inventory)
    </h2>

    <!-- CUSTOMER / VEHICLE INFO -->
    <table class="w-full border mb-4">
        <tr>
            <td class="border p-1">Customer</td>
            <td class="border p-1"><?= $header->customer_name ?></td>
            <td class="border p-1">Reg No</td>
            <td class="border p-1"><?= $header->registration_no ?></td>
        </tr>
        <tr>
            <td class="border p-1">VIN</td>
            <td class="border p-1"><?= $header->vin ?></td>
            <td class="border p-1">KM</td>
            <td class="border p-1"><?= $header->km ?></td>
        </tr>
    </table>

    <!-- INSPECTION ITEMS -->
    <table class="w-full border mb-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-1">Inspection Item</th>
                <th class="border p-1">A</th>
                <th class="border p-1">C</th>
                <th class="border p-1">S</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $i): ?>
            <tr>
                <td class="border p-1"><?= $i->item_name ?></td>
                <td class="border text-center"><?= $i->status=='A'?'✔':'' ?></td>
                <td class="border text-center"><?= $i->status=='C'?'✔':'' ?></td>
                <td class="border text-center"><?= $i->status=='S'?'✔':'' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- WORKS REQUESTED -->
    <div class="mb-4">
        <h4 class="font-bold mb-1">WORKS REQUESTED</h4>
        <?php foreach($works as $w): ?>
            <span class="inline-block mr-4">✔ <?= $w->work_name ?></span>
        <?php endforeach; ?>
    </div>

    <!-- INVENTORY STATUS -->
    <div class="mb-4">
        <h4 class="font-bold mb-1">INVENTORY STATUS</h4>
        <?php foreach($inventory as $inv): ?>
            <span class="inline-block mr-4">✔ <?= $inv->status_name ?></span>
        <?php endforeach; ?>
    </div>

    <!-- DAMAGE DIAGRAM -->
    <div class="relative mt-6">
        <img src="<?= base_url('assets/images/vehicle-diagram.png') ?>" class="w-96">

        <?php foreach($marks as $m): ?>
            <span class="absolute text-red-600 font-bold"
                  style="left:<?= $m->x_coordinate ?>px; top:<?= $m->y_coordinate ?>px;">
                ✖
            </span>
        <?php endforeach; ?>
    </div>

    <div class="text-right mt-6 text-xs text-gray-500">
        Created on <?= date('d-M-Y') ?>
    </div>
</div>
