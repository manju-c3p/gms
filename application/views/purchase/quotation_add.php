<style>
	.form-control {
		font-size: 12px;
	}
</style>
<!-- Header -->
<div class="flex items-center justify-between bg-gray-200 px-4 py-3 rounded-t-lg">

	<!-- Title -->
	<h1 class="text-xl font-medium text-gray-600">
		Quote From Supplier
	</h1>

	<!-- Right Button -->
	<a href="<?php echo base_url(); ?>index.php/Purchase/purchase_quotation_list"
		class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
		List
	</a>

</div>

<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_purchase_quotation_records" autocomplete="off" enctype="multipart/form-data">

	<!-- page content -->
	<div class="w-full px-4 py-4" role="main">

		<div class="bg-white shadow rounded-lg p-4 overflow-x-auto">

			<!-- Row 1 -->
			<div class="grid grid-cols-12 gap-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">Select RFQ</label>

				<div class="col-span-12 md:col-span-3">
					<select tabindex="1"
						class="form-control w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
						id="rfq_id"
						name="rfq_id"
						required
						onchange="get_enquiry_info()">

						<option value="">Select</option>

						<?php foreach ($records as $s) { ?>
							<option value="<?php echo $s->rfq_id ?>">
								<?php echo $s->rfq_code; ?>
							</option>
						<?php } ?>

					</select>
				</div>

				<label class="col-span-12 md:col-span-1 text-sm font-medium text-gray-700">Code</label>

				<div class="col-span-12 md:col-span-3">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
						name="quotation_code"
						id="quotation_code"
						readonly
						value="<?php echo $Code; ?>">
				</div>

				<label class="col-span-12 md:col-span-1 text-sm font-medium text-gray-700">Date</label>

				<div class="col-span-12 md:col-span-2">
					<input type="date"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="quotation_date"
						id="quotation_date"
						value="<?php echo date('Y-m-d'); ?>">
				</div>

			</div>

			<!-- Row 2 -->
			<div class="grid grid-cols-12 gap-4 mt-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">Supplier</label>

				<div class="col-span-12 md:col-span-4">
					<input type="text"
						readonly
						name="supplier_name"
						id="supplier_name"
						class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100">

					<input type="hidden"
						readonly
						name="supplier_id"
						id="supplier_id"
						class="form-control">
				</div>

				<label class="col-span-12 md:col-span-1 text-sm font-medium text-gray-700">Reference</label>

				<div class="col-span-12 md:col-span-4">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="ref_no"
						id="ref_no">
				</div>

			</div>

			<!-- Row 3 -->
			<div class="grid grid-cols-12 gap-4 mt-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">Project Name</label>

				<div class="col-span-12 md:col-span-4">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="project"
						id="project">
				</div>

				<label class="col-span-12 md:col-span-1 text-sm font-medium text-gray-700">Upload Document</label>

				<div class="col-span-12 md:col-span-4">
					<input type="file"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="quote_doc"
						id="quote_doc">
				</div>

			</div>

			<!-- Row 4 -->
			<div class="grid grid-cols-12 gap-4 mt-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium text-gray-700">RFQ Created By</label>

				<div class="col-span-12 md:col-span-4">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="rfq_by"
						id="rfq_by">
				</div>

			</div>

		</div>

		<!-- Items -->
		<div class="w-full overflow-x-auto mt-4">
			<div id="rfq_items_list" class="bg-white shadow rounded-lg p-4"></div>
		</div>

		<!-- Totals -->
		<div class="bg-white shadow rounded-lg p-4 mt-4">

			<div class="grid grid-cols-12 gap-4 items-center">

				<label class="col-span-12 md:col-span-2 text-sm font-medium">Taxable Amount</label>

				<div class="col-span-12 md:col-span-2">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
						name="sub_total"
						id="sub_total"
						readonly>
				</div>

				<label class="col-span-12 md:col-span-1 text-sm font-medium">VAT(%)</label>

				<div class="col-span-12 md:col-span-1">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="vat_per"
						id="vat_per"
						value="5">
				</div>

				<label class="col-span-12 md:col-span-1 text-sm font-medium">Tax Amount</label>

				<div class="col-span-12 md:col-span-1">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
						name="vat_amount"
						id="vat_amount">
				</div>

				<label class="col-span-12 md:col-span-1 text-sm font-medium">Grand Total</label>

				<div class="col-span-12 md:col-span-2">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
						name="grand_total"
						id="grand_total">
				</div>

			</div>

			<!-- Terms -->
			<div class="grid grid-cols-12 gap-4 mt-4">

				<label class="col-span-12 md:col-span-2 text-sm font-medium">Validity</label>

				<div class="col-span-12 md:col-span-3">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="validity"
						id="validity">
				</div>

				<label class="col-span-12 md:col-span-2 text-sm font-medium">Payment Terms</label>

				<div class="col-span-12 md:col-span-3">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="payment_terms"
						id="payment_terms">
				</div>

			</div>

			<div class="grid grid-cols-12 gap-4 mt-4">

				<label class="col-span-12 md:col-span-2 text-sm font-medium">Delivery Terms</label>

				<div class="col-span-12 md:col-span-3">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="delivery_terms"
						id="delivery_terms">
				</div>

				<label class="col-span-12 md:col-span-2 text-sm font-medium">General Terms</label>

				<div class="col-span-12 md:col-span-3">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="general_terms"
						id="general_terms">
				</div>

			</div>

		</div>

		<!-- Prepared / Approved -->
		<div class="bg-white shadow rounded-lg p-4 mt-4">

			<div class="grid grid-cols-12 gap-4">

				<label class="col-span-12 md:col-span-2 text-sm font-medium">Prepared By</label>

				<div class="col-span-12 md:col-span-3">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2 bg-gray-100"
						name="sales_person"
						id="sales_person"
						value="<?php echo $this->session->userdata('user_name'); ?>">
				</div>

				<label class="col-span-12 md:col-span-2 text-sm font-medium">Approved By</label>

				<div class="col-span-12 md:col-span-3">
					<input type="text"
						class="form-control w-full border border-gray-300 rounded px-3 py-2"
						name="approved_by"
						id="approved_by">
				</div>

			</div>

			<!-- Submit Button -->
			<div class="mt-6">

				<button type="submit"
					class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">

					Submit

				</button>

			</div>

		</div>

	</div>

</form>

<script>
function get_enquiry_info() {
		var rfq_id = document.getElementById("rfq_id").value;

		if (rfq_id != '') {
			$.ajax({
				async: "false",
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_rfq_info",
				data: { rfq_id: rfq_id },
				dataType: "json",
				success: function (msg) {
					 document.getElementById("supplier_id").value = msg.supplier_id;
					 document.getElementById("supplier_name").value = msg.supplier_code + ' ' + msg.supplier_name;
           document.getElementById("rfq_by").value = msg.rfq_created_by;
           document.getElementById("project").value = msg.project;
           document.getElementById("ref_no").value = msg.ref;
					 get_rfq_items_list(rfq_id);
            
				}
			});
		}
		else {
			document.getElementById("enq_code").innerHTML = '';
			document.getElementById("enq_date").value = '';
			document.getElementById("customer_id").value = '';
			document.getElementById("cust_name").value = '';

			document.getElementById('item_list_id').innerHTML = '';
		}
	}

 function get_rfq_items_list(rfq_id) {
    $.ajax({
        type: "POST",
        url:"<?php echo base_url()?>index.php/Ajax/get_rfq_items_for_quote",
        data: { rfq_id: rfq_id },
        success: function(msg){	       	
            $('#rfq_items_list').html(msg);
            $('.select2').select2(); 

            // Calculate each row immediately
            $('#rfq_items_list').find('tr').each(function() {
                calculateRow($(this));
            });

            // Then calculate totals
            calculateAll();
        }
    });
}


function calculateRow($row) {
    var qty = parseFloat($row.find('.qty').val()) || 0;
    var price = parseFloat($row.find('.unit_price').val()) || 0;

    var disPer1 = parseFloat($row.find('.dis_per').val()) || 0;
    var disAmt1 = (qty * price * disPer1) / 100;
    $row.find('.dis_amt').val(disAmt1.toFixed(2));

    var subtotalAfterFirst = qty * price - disAmt1;

    var disPer2 = parseFloat($row.find('.dis_per2').val()) || 0;
    var disAmt2 = (subtotalAfterFirst * disPer2) / 100;
    $row.find('.dis_amt2').val(disAmt2.toFixed(2));

    var finalRowTotal = subtotalAfterFirst - disAmt2;

    var finalUnitPrice = qty > 0 ? finalRowTotal / qty : 0;
    $row.find('.final_unit_price').val(finalUnitPrice.toFixed(2));

    $row.find('.total_price').val(finalRowTotal.toFixed(2));
}


  $(document).ready(function () {
    // Event listener for input changes

  $(document).on('input change keyup', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function (e) {

    var $row = $(this).closest('tr');
    calculateRow($row);
    calculateAll();
});


    





    

    // Recalculate when VAT changes
    $('#vat_per').on('input change', function () {
        calculateAll();
    });
});
function calculateAll() {
    var total = 0;
    $('#rfq_items_list').find('tr').each(function() {
        var rowTotal = parseFloat($(this).find('.total_price').val()) || 0;
        total += rowTotal;
    });

    $('#sub_total').val(total.toFixed(2));

    var vatPer = parseFloat($('#vat_per').val()) || 0;
    var vatAmount = (total * vatPer) / 100;
    $('#vat_amount').val(vatAmount.toFixed(2));

    $('#grand_total').val((total + vatAmount).toFixed(2));
}


</script>
