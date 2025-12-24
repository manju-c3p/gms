
<!-- <div class="w-full max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow"> -->
<div class="w-full bg-white rounded-2xl shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Add Appointment</h2>

    <form method="POST" action="<?= base_url('index.php/appointment/save'); ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Customer -->
            <div class="col-span-2">
                <label class="font-medium">Customer</label>
                <select name="customer_id" id="customerSelect"
                        class="w-full border p-2 rounded" required>
                    <option value="">-- Select Customer --</option>

                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c->customer_id ?>">
                            <?= $c->name ?> (<?= $c->phone ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Vehicle -->
            <div class="col-span-2">
                <label class="font-medium">Vehicle</label>
                <select name="vehicle_id" id="vehicleSelect"
                        class="w-full border p-2 rounded" required>
                    <option value="">-- Select Vehicle --</option>
                </select>
            </div>

            <!-- Appointment Date -->
            <div>
                <label class="font-medium">Appointment Date</label>
                <input type="date" name="appointment_date"
                       class="w-full border p-2 rounded" required>
            </div>

            <!-- Time -->
            <div>
                <label class="font-medium">Time</label>
                <input type="time" name="appointment_time"
                       class="w-full border p-2 rounded" required>
            </div>

            <!-- Type -->
            <div class="col-span-2">
                <label class="font-medium">Appointment Type</label>
                <select name="appointment_type"
                        class="w-full border p-2 rounded" required>
                    <option value="General Service">General Service</option>
                    <option value="Repair">Repair</option>
                    <option value="Inspection">Inspection</option>
                    <option value="Custom">Custom</option>
                </select>
            </div>

            <!-- Notes -->
            <div class="col-span-2">
                <label class="font-medium">Notes (Optional)</label>
                <textarea name="notes" rows="3" 
                          class="w-full border p-2 rounded"
                          placeholder="Describe the issue or request..."></textarea>
            </div>

        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="<?= base_url('index.php/appointment'); ?>"
               class="px-4 py-2 bg-gray-300 rounded">Cancel</a>

            <button class="px-6 py-2 bg-blue-600 text-white rounded">
                Save Appointment
            </button>
        </div>

    </form>
</div>

<!-- 🔄 Auto-load vehicles based on selected customer -->
<script>
document.getElementById("customerSelect").addEventListener("change", function() {
    let cid = this.value;

    if (!cid) {
        document.getElementById("vehicleSelect").innerHTML =
            '<option value="">-- Select Vehicle --</option>';
        return;
    }

    fetch("<?= base_url('index.php/appointment/getVehiclesByCustomer/'); ?>" + cid)
        .then(res => res.json())
        .then(data => {
            let html = '<option value="">-- Select Vehicle --</option>';
            data.forEach(v => {
                html += `<option value="${v.vehicle_id}">
                            ${v.registration_no} (${v.brand} ${v.model})
                         </option>`;
            });
            document.getElementById("vehicleSelect").innerHTML = html;
        });
});
</script>



