<form id="spotCustomerForm">

    <!-- CUSTOMER -->
    <h3 class="text-lg font-semibold mb-3">Customer Details</h3>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="font-medium">Customer Name *</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="font-medium">Phone *</label>
            <input type="text" name="phone" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="font-medium">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="font-medium">Address</label>
            <input type="text" name="address" class="w-full border p-2 rounded">
        </div>
		 <div>
           <label class="font-medium">Emirate</label>
				<select name="emirate" class="w-full border p-2 rounded">
					<option value="">-- Select Emirate --</option>
					<option value="Abu Dhabi">Abu Dhabi</option>
					<option value="Dubai">Dubai</option>
					<option value="Sharjah">Sharjah</option>
					<option value="Ajman">Ajman</option>
					<option value="Umm Al Quwain">Umm Al Quwain</option>
					<option value="Ras Al Khaimah">Ras Al Khaimah</option>
					<option value="Fujairah">Fujairah</option>
				</select>
        </div>
    </div>

    <hr class="my-4">

    <!-- VEHICLE -->
    <h3 class="text-lg font-semibold mb-3">Vehicle Details</h3>

    <div class="grid grid-cols-2 gap-4">

        <div>
            <label class="font-medium">Registration No *</label>
            <input type="text" name="registration_no"
                   class="w-full border p-2 rounded"
                   placeholder="KL 01 AB 1234" required>
        </div>

        <!-- BRAND -->
        <div>
            <label class="font-medium">Brand *</label>
            <select name="brand_id" id="brandSelect"
                    class="w-full border p-2 rounded" required>
                <option value="">-- Select Brand --</option>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= $b->brand_id ?>">
                        <?= $b->brand_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- MODEL -->
        <div>
            <label class="font-medium">Model *</label>
            <select name="model_id" id="modelSelect"
                    class="w-full border p-2 rounded" required>
                <option value="">-- Select Model --</option>
            </select>
        </div>

     
    </div>

    <div class="mt-5 flex justify-end gap-3">
        <button type="button"
                onclick="$('#customerModal').addClass('hidden')"
                class="px-4 py-2 bg-gray-300 rounded">
            Cancel
        </button>

        <button type="submit"
                class="px-5 py-2 bg-blue-600 text-white rounded">
            Save
        </button>
    </div>

</form>
<script>
$('#brandSelect').on('change', function () {

    let brandId = $(this).val();
    $('#modelSelect').html('<option value="">Loading...</option>');

    if (!brandId) {
        $('#modelSelect').html('<option value="">-- Select Model --</option>');
        return;
    }

    fetch("<?= base_url('index.php/customer/get_models_by_brand/'); ?>" + brandId)
        .then(res => res.json())
        .then(data => {

            let options = '<option value="">-- Select Model --</option>';

            data.forEach(m => {
                options += `<option value="${m.model_id}">
                                ${m.model_name}
                            </option>`;
            });

            $('#modelSelect').html(options);
        });
});

	

	$(document).on('submit', '#spotCustomerForm', function (e) {
    e.preventDefault();

    $.ajax({
        url: "<?= base_url('index.php/Customer/save_spot_ajax'); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",

        success: function (res) {

            if (res.status !== 'success') return;

            /* ADD CUSTOMER */
            let custOption = new Option(
                res.customer.name + " (" + res.customer.phone + ")",
                res.customer.customer_id,
                true,
                true
            );

            $('#customerSelect')
                .append(custOption)
                .trigger('change.select2'); // IMPORTANT

            /* ADD VEHICLE */
            let vehicleText =
                `${res.vehicle.registration_no}
                (${res.vehicle.brand_name}, ${res.vehicle.model_name},
                 ${res.vehicle.chassis_no}, ${res.vehicle.engine_no})`;

            let vehOption = new Option(
                vehicleText,
                res.vehicle.vehicle_id,
                true,
                true
            );

            $('#vehicleSelect')
                .empty()
                .append(vehOption)
                .trigger('change.select2'); // IMPORTANT

            /* CLOSE MODAL */
            $('#customerModal').addClass('hidden');
        }
    });
});

</script>
