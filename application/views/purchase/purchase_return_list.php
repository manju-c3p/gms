<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6 border-b pb-3">
        <h2 class="text-xl font-semibold text-gray-800">
            Purchase Return List
        </h2>

        <a href="<?= base_url('index.php/Purchase/add_purchase_return') ?>"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
           + Add Purchase Return
        </a>
    </div>


    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table id="datatable-return" class="min-w-full text-sm text-left text-gray-700 border">

            <thead class="bg-gray-100 text-xs uppercase font-semibold text-gray-600">
                <tr>
                    <th class="px-4 py-3 border">#</th>
                    <th class="px-4 py-3 border">Return Code</th>
                    <th class="px-4 py-3 border">Date</th>
                    <th class="px-4 py-3 border">Supplier</th>
                    <th class="px-4 py-3 border text-right">Sub Total</th>
                    <th class="px-4 py-3 border text-right">VAT</th>
                    <th class="px-4 py-3 border text-right">Grand Total</th>
                    <th class="px-4 py-3 border text-center">Action</th>
                </tr>
            </thead>

            <tbody>

                <?php if(!empty($records)){ $i=1; foreach($records as $row){ ?>

                <tr class="hover:bg-gray-50">

                    <td class="px-4 py-2 border"><?= $i++ ?></td>

                    <td class="px-4 py-2 border font-semibold">
                        <?= $row->return_code ?>
                    </td>

                    <td class="px-4 py-2 border">
                        <?= date('d-m-Y', strtotime($row->return_date)) ?>
                    </td>

                    <td class="px-4 py-2 border">
                        <?= $row->supplier_name ?>
                    </td>

                    <td class="px-4 py-2 border text-right">
                        <?= number_format($row->sub_total,2) ?>
                    </td>

                    <td class="px-4 py-2 border text-right">
                        <?= number_format($row->vat_amount,2) ?>
                    </td>

                    <td class="px-4 py-2 border text-right font-semibold">
                        <?= number_format($row->grand_total,2) ?>
                    </td>

                    <td class="px-4 py-2 border text-center">

                        <a href="<?= base_url('index.php/Purchase/view_purchase_return/'.$row->return_id) ?>"
                           class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">
                           View
                        </a>

                    </td>

                </tr>

                <?php } } else { ?>

                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">
                        No purchase returns found
                    </td>
                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const table = document.querySelector("#datatable-return");

    if(table){
        new simpleDatatables.DataTable(table,{
            searchable: true,
            fixedHeight: false,
            perPage: 10,
            perPageSelect: [5,10,25,50,100]
        });
    }

});
</script>
