<!-- <div class="w-full max-w-5xl bg-white rounded-2xl shadow-md p-6 mx-auto"> -->
<div class="w-full bg-white rounded-2xl shadow-md p-6">
    <h2 class="text-2xl font-bold mb-4">Add Customer & Vehicles</h2>

    <form method="POST" action="<?= base_url('index.php/customer/save'); ?>">

        <!-- CUSTOMER SECTION -->
        <h3 class="text-xl font-semibold mb-3">Customer Details</h3>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="font-medium">Customer Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="font-medium">Phone</label>
                <input type="text" name="phone" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="font-medium">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="font-medium">Address</label>
                <textarea name="address" class="w-full border p-2 rounded"></textarea>
            </div>
        </div>

        <hr class="my-6">

        <!-- VEHICLE SECTION -->
        <h3 class="text-xl font-semibold mb-3">Vehicle Details</h3>

        <div id="vehicleRows">

            <!-- VEHICLE ROW -->
            <div class="vehicleRow grid grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">

                <!-- DELETE ROW BUTTON -->
                <button type="button"
                    onclick="removeVehicleRow(this)"
                    class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">
                    ✖
                </button>

                <div>
                    <label class="font-medium">Registration No</label>
                    <input name="vehicle_registration_no[]" class="border p-2 rounded w-full" placeholder="A 12345">
                </div>

                <div>
                    <label class="font-medium">Brand</label>
                    <input name="vehicle_brand[]" class="border p-2 rounded w-full" placeholder="Toyota">
                </div>

                <div>
                    <label class="font-medium">Model</label>
                    <input name="vehicle_model[]" class="border p-2 rounded w-full" placeholder="Innova">
                </div>

                <div>
                    <label class="font-medium">Variant</label>
                    <input name="vehicle_variant[]" class="border p-2 rounded w-full" placeholder="Diesel / ZX">
                </div>

                <div>
                    <label class="font-medium">Year</label>
                    <input name="vehicle_year[]" class="border p-2 rounded w-full" placeholder="2020">
                </div>

                <div>
                    <label class="font-medium">Color</label>
                    <input name="vehicle_color[]" class="border p-2 rounded w-full" placeholder="White">
                </div>

                <div>
                    <label class="font-medium">Chassis No (VIN)</label>
                    <input name="vehicle_chassis_no[]" class="border p-2 rounded w-full" placeholder="VIN Number">
                </div>

                <div>
                    <label class="font-medium">Engine No</label>
                    <input name="vehicle_engine_no[]" class="border p-2 rounded w-full" placeholder="Engine Number">
                </div>

            </div>

        </div>

        <!-- ADD VEHICLE BUTTON -->
        <button type="button" onclick="addVehicleRow()"
                class="px-4 py-2 bg-green-600 text-white rounded mt-2">
            + Add Another Vehicle
        </button>

        <br><br>

        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded">
            Save Customer & Vehicles
        </button>

    </form>
</div>

<script>

function addVehicleRow() {
    let html = `
        <div class="vehicleRow grid grid-cols-4 gap-3 mb-4 p-4 border rounded-lg bg-gray-50 relative">

            <button type="button"
                onclick="removeVehicleRow(this)"
                class="absolute top-2 right-2 px-2 py-1 bg-red-600 text-white text-xs rounded">
                ✖
            </button>

            <div>
                <label class="font-medium">Registration No</label>
                <input name="vehicle_registration_no[]" class="border p-2 rounded w-full" placeholder="A 12345">
            </div>

            <div>
                <label class="font-medium">Brand</label>
                <input name="vehicle_brand[]" class="border p-2 rounded w-full" placeholder="Toyota">
            </div>

            <div>
                <label class="font-medium">Model</label>
                <input name="vehicle_model[]" class="border p-2 rounded w-full" placeholder="Innova">
            </div>

            <div>
                <label class="font-medium">Variant</label>
                <input name="vehicle_variant[]" class="border p-2 rounded w-full" placeholder="Diesel / ZX">
            </div>

            <div>
                <label class="font-medium">Year</label>
                <input name="vehicle_year[]" class="border p-2 rounded w-full" placeholder="2020">
            </div>

            <div>
                <label class="font-medium">Color</label>
                <input name="vehicle_color[]" class="border p-2 rounded w-full" placeholder="White">
            </div>

            <div>
                <label class="font-medium">Chassis No (VIN)</label>
                <input name="vehicle_chassis_no[]" class="border p-2 rounded w-full" placeholder="VIN Number">
            </div>

            <div>
                <label class="font-medium">Engine No</label>
                <input name="vehicle_engine_no[]" class="border p-2 rounded w-full" placeholder="Engine Number">
            </div>

        </div>
    `;

    document.getElementById('vehicleRows').insertAdjacentHTML('beforeend', html);
}

function removeVehicleRow(btn) {
    let rows = document.querySelectorAll('.vehicleRow');
    if (rows.length <= 1) {
        alert("At least one vehicle is required.");
        return;
    }
    btn.parentElement.remove();
}

</script>
