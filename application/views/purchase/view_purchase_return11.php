<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6 border-b pb-3">

        <h2 class="text-xl font-semibold text-gray-800">
            Purchase Return Details
        </h2>

        <div class="flex gap-2">

            <a href="<?= base_url('index.php/Purchase/purchase_return_list') ?>"
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
               Back
            </a>

            <button onclick="window.print()"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               Print
            </button>

        </div>

    </div>


    <!-- Return Info -->
    <div class="grid grid-cols-12 gap-4 mb-6 bg-white shadow rounded-lg p-4">

        <div class="col-span-12 md:col-span-4">
            <label class="text-sm text-gray-500">Return Code</label>
            <p class="font-semibold"><?= $return->return_code ?></p>
        </div>

        <div class="col-span-12 md:col-span-4">
            <label class="text-sm text-gray-500">Return Date</label>
            <p><?= date('d-m-Y',strtotime($return->return_date)) ?></p>
        </div>

        <div class="col-span-12 md:col-span-4">
            <label class="text-sm text-gray-500">Reference</label>
            <p><?= $return->ref_no ?></p>
        </div>

        <div class="col-span-12 md:col-span-6">
            <label class="text-sm text-gray-500">Supplier</label>
            <p class="font-semibold"><?= $return->supplier_name ?></p>
        </div>

        <div class="col-span-12 md:col-span-6">
            <label class="text-sm text-gray-500">Remarks</label>
            <p><?= $return->remarks ?></p>
        </div>

    </div>


    <!-- Items Table -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table class="min-w-full text-sm border">

            <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                <tr>
                    <th class="px-3 py-2 border">#</th>
                    <th class="px-3 py-2 border">Part</th>
                    <th class="px-3 py-2 border text-center">GRN Qty</th>
                    <th class="px-3 py-2 border text-center">Returned Before</th>
                    <th class="px-3 py-2 border text-center">Return Qty</th>
                    <th class="px-3 py-2 border text-right">Unit Price</th>
                    <th class="px-3 py-2 border text-right">Total</th>
                </tr>
            </thead>

            <tbody>

                <?php 
                $i=1;
                foreach($items as $row){
                ?>

                <tr class="hover:bg-gray-50">

                    <td class="px-3 py-2 border"><?= $i++ ?></td>

                    <td class="px-3 py-2 border">
                        <?= $row->part_name ?>
                    </td>

                    <td class="px-3 py-2 border text-center">
                        <?= $row->grn_qty ?>
                    </td>

                    <td class="px-3 py-2 border text-center">
                        <?= $row->returned_qty ?>
                    </td>

                    <td class="px-3 py-2 border text-center font-semibold">
                        <?= $row->return_qty ?>
                    </td>

                    <td class="px-3 py-2 border text-right">
                        <?= number_format($row->unit_price,2) ?>
                    </td>

                    <td class="px-3 py-2 border text-right font-semibold">
                        <?= number_format($row->total,2) ?>
                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>


    <!-- Totals -->
    <div class="grid grid-cols-12 gap-4 mt-6">

        <div class="col-span-12 md:col-span-6"></div>

        <div class="col-span-12 md:col-span-6 bg-white shadow rounded-lg p-4">

            <div class="flex justify-between py-1">
                <span>Sub Total</span>
                <span><?= number_format($return->sub_total,2) ?></span>
            </div>

            <div class="flex justify-between py-1">
                <span>Discount (<?= $return->discount_per ?>%)</span>
                <span><?= number_format($return->discount_amt,2) ?></span>
            </div>

            <div class="flex justify-between py-1">
                <span>VAT (<?= $return->vat_per ?>%)</span>
                <span><?= number_format($return->vat_amount,2) ?></span>
            </div>

            <div class="flex justify-between py-2 border-t mt-2 font-semibold text-lg">
                <span>Grand Total</span>
                <span><?= number_format($return->grand_total,2) ?></span>
            </div>

        </div>

    </div>

</div>
