<style>
	.form-control {
		font-size: 13px !important;
	}
</style>


<!-- Header -->
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<h1 class="text-xl font-medium text-gray-700">
		Add Purchase Return
	</h1>

	<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_return_list"
		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
		List
	</a>

</div>


<form id="main"
	method="post"
	action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_purchase_return_records"
	autocomplete="off"
	enctype="multipart/form-data">

	<div class="bg-white shadow rounded-b-lg p-4">


		<!-- Row 1 -->
		<div class="grid grid-cols-12 gap-4">

			<label class="col-span-12 md:col-span-2 text-sm font-medium">
				Select GRN
			</label>

			<div class="col-span-12 md:col-span-3">

				<select class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="grn_id"
					id="grn_id"
					required
					onchange="get_grn_info()">

					<option value="">Select</option>

					<?php foreach ($grn_records as $g) { ?>

						<option value="<?php echo $g->grn_id ?>">
							<?php echo $g->grn_code; ?>
						</option>

					<?php } ?>

				</select>

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">
				Return Code
			</label>

			<div class="col-span-12 md:col-span-3">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					name="return_code"
					id="return_code"
					readonly
					value="<?php echo $Code; ?>">

			</div>


			<label class="col-span-12 md:col-span-1 text-sm font-medium">
				Return Date
			</label>

			<div class="col-span-12 md:col-span-2">

				<input type="date"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="return_date"
					id="return_date"
					value="<?php echo date('Y-m-d'); ?>">

			</div>

		</div>



		<!-- Row 2 -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2">
				Supplier
			</label>

			<div class="col-span-12 md:col-span-7">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
					name="supplier_name"
					id="supplier_name"
					readonly>

				<input type="hidden"
					name="supplier_id"
					id="supplier_id">

			</div>


			<label class="col-span-12 md:col-span-1">
				Reference
			</label>

			<div class="col-span-12 md:col-span-2">

				<input type="text"
					class="form-control w-full border border-gray-300 rounded px-3 py-2"
					name="ref_no"
					id="ref_no">

			</div>

		</div>



		<!-- Items -->
		<div id="grn_items_list"
			class="mt-6 border rounded p-3 bg-gray-50 overflow-x-auto">

		</div>



		<!-- Totals -->
		<div class="grid grid-cols-12 gap-4 mt-6">

			<label class="col-span-12 md:col-span-1">
				Sub Total
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2 bg-gray-100"
				name="sub_total"
				id="sub_total"
				readonly>


			<label class="col-span-12 md:col-span-1">
				Discount (%)
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="discount_per"
				id="discount_per">


			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="discount_amt"
				id="discount_amt">


			<label class="col-span-12 md:col-span-1">
				VAT (%)
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="vat_per"
				id="vat_per">


			<input type="text"
				class="form-control col-span-12 md:col-span-1 border rounded px-3 py-2"
				name="vat_amount"
				id="vat_amount">


			<label class="col-span-12 md:col-span-1">
				Grand Total
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-2 border rounded px-3 py-2"
				name="grand_total"
				id="grand_total">

		</div>



		<!-- Remarks -->
		<div class="grid grid-cols-12 gap-4 mt-4">

			<label class="col-span-12 md:col-span-2">
				Remarks
			</label>

			<textarea class="form-control col-span-12 md:col-span-4 border rounded px-3 py-2"
				name="remarks"
				id="remarks"></textarea>


			<label class="col-span-12 md:col-span-2">
				Prepared By
			</label>

			<input type="text"
				class="form-control col-span-12 md:col-span-3 border rounded px-3 py-2 bg-gray-100"
				name="sales_person"
				id="sales_person"
				readonly
				value="<?php echo $this->session->userdata('user_name'); ?>">

		</div>


		<!-- Submit -->
		<div class="mt-6">

			<button type="submit"
				class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
				Submit
			</button>

		</div>

	</div>

</form>

<script>

	function get_grn_info()
{
	var grn_id = document.getElementById("grn_id").value;

	if(grn_id!='')
	{
		$.ajax({
			type:"POST",
			url:"<?php echo base_url()?>index.php/Ajax/ajax_get_grn_info",
			data:{grn_id:grn_id},
			dataType:"json",
			success:function(msg)
			{
				$("#supplier_id").val(msg.supplier_id);
				$("#supplier_name").val(msg.supplier_code+" "+msg.supplier_name);

				$("#sub_total").val(msg.subtotal);
				$("#discount_per").val(msg.discount_percent);
				$("#discount_amt").val(msg.discount);
				$("#vat_per").val(msg.vat_percent);
				$("#vat_amount").val(msg.vat_amt);
				$("#grand_total").val(msg.grand_total);

				get_grn_items_list(grn_id);
			}
		});
	}
}
function get_grn_items_list(grn_id)
{
	$.ajax({
		type:"POST",
		url:"<?php echo base_url()?>index.php/Ajax/get_grn_items_for_return",
		data:{grn_id:grn_id},
		success:function(msg)
		{
			$("#grn_items_list").html(msg);
		}
	});
}
// $(document).on("keyup change",".return_qty",function(){

// 	let row = $(this).data("index");

// 	let grnQty = parseFloat($("#grn_qty"+row).val()) || 0;
// 	let returnedQty = parseFloat($("#returned_qty"+row).val()) || 0;
// 	let returnQty = parseFloat($(this).val()) || 0;

// 	let balance = grnQty - returnedQty;

// 	if(returnQty > balance)
// 	{
// 		alert("Return qty cannot exceed balance qty");

// 		$(this).val(balance);
// 	}

// });
$(document).on("keyup change", ".return_qty", function(){

    let row = $(this).data("index");

    let grnQty = parseFloat($("#grn_qty"+row).val()) || 0;
    let returnedQty = parseFloat($("#returned_qty"+row).val()) || 0;
    let returnQty = parseFloat($(this).val()) || 0;
    let rate = parseFloat($("#unit_price"+row).val()) || 0;

    let balance = grnQty - returnedQty;

    if(returnQty > balance){
        alert("Return qty cannot exceed balance qty");
        returnQty = balance;
        $(this).val(balance);
    }

    // Row total
    let rowTotal = returnQty * rate;

    $("#total_price"+row).val(rowTotal.toFixed(2));

    calculate_totals();
});


function calculate_totals(){

    let subTotal = 0;

    $(".row_total").each(function(){
        subTotal += parseFloat($(this).val()) || 0;
    });

    $("#sub_total").val(subTotal.toFixed(2));

    let discountPer = parseFloat($("#discount_per").val()) || 0;
    let discountAmt = (subTotal * discountPer) / 100;

    $("#discount_amt").val(discountAmt.toFixed(2));

    let vatPer = parseFloat($("#vat_per").val()) || 0;
    let vatAmount = ((subTotal - discountAmt) * vatPer) / 100;

    $("#vat_amount").val(vatAmount.toFixed(2));

    let grandTotal = subTotal - discountAmt + vatAmount;

    $("#grand_total").val(grandTotal.toFixed(2));
}


$(document).on("keyup change", "#discount_per,#vat_per", function(){
    calculate_totals();
});
</script>
