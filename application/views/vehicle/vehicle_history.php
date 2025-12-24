<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
<div class="w-full bg-white rounded-2xl shadow-md p-6">

	<div class="flex justify-between items-center mb-4">
		<h2 class="text-2xl font-bold mb-4">Vehicle Service History</h2>

		
	</div>


<table id="historyTable"  class="stripe hover w-full text-sm">
    <thead>
        <tr class="bg-gray-100 text-gray-700">
            <th  class="p-3 text-left">#</th>
            <th class="p-3 text-left">Job Card</th>
            <th class="p-3 text-left">Date</th>
            <th class="p-3 text-left">Customer</th>
            <th class="p-3 text-left">Technician</th>
            <th class="p-3 text-left">Service Total</th>
            <th class="p-3 text-left">Parts Total</th>
            <th class="p-3 text-left">Grand Total</th>
            <th class="p-3 text-left">Status</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($history as $i => $h): 
            $grand = $h->service_total + $h->parts_total;
        ?>
        <tr class="border-b hover:bg-gray-50 text-sm">
            <td class="p-3"><?= $i+1 ?></td>
            <td class="p-3">#<?= $h->jobcard_id ?></td>
            <td class="p-3"><?= date('d-m-Y', strtotime($h->jobcard_date)) ?></td>
            <td class="p-3"><?= $h->customer_name ?></td>
            <td class="p-3"><?= $h->technician ?></td>
            <td class="p-3">₹<?= number_format($h->service_total,2) ?></td>
            <td class="p-3">₹<?= number_format($h->parts_total,2) ?></td>
            <td class="p-3">₹<?= number_format($grand,2) ?></td>
            <td class="p-3"><?= $h->status ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<script>
$(document).ready(function () {
    $('#historyTable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true
    });
});
</script>
