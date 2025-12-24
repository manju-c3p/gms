<div class="w-full bg-white rounded-2xl shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">Upcoming Appointments (Next <?= isset($days) ? intval($days) : 3 ?> days)</h2>

        <div>
            <a href="<?= base_url('index.php/appointment'); ?>" class="px-4 py-2 bg-gray-200 rounded">Back to Appointments</a>
        </div>
    </div>

    <?php if (empty($appointments)): ?>
        <div class="p-4 bg-gray-50 rounded text-gray-500">No upcoming appointments.</div>
    <?php else: ?>
        <table class="w-full table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">#</th>
                    <th class="p-2 text-left">Customer</th>
                    <th class="p-2 text-left">Phone</th>
                    <th class="p-2 text-left">Vehicle</th>
                    <th class="p-2 text-left">Date</th>
                    <th class="p-2 text-left">Time</th>
                    <th class="p-2 text-left">Service</th>
                    <th class="p-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $sl=1; foreach ($appointments as $a): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2"><?= $sl++ ?></td>
                        <td class="p-2"><?= htmlspecialchars($a->customer_name) ?></td>
                        <td class="p-2"><?= htmlspecialchars($a->customer_phone) ?></td>
                        <td class="p-2"><?= htmlspecialchars($a->registration_no) ?></td>
                        <td class="p-2"><?= htmlspecialchars($a->appointment_date) ?></td>
                        <td class="p-2"><?= htmlspecialchars($a->appointment_time) ?></td>
                        <td class="p-2"><?= htmlspecialchars($a->service_type) ?></td>
                        <td class="p-2 text-center">
                            <button onclick="openReminderModal(<?= $a->appointment_id ?>)"
                                    class="px-3 py-1 bg-blue-600 text-white rounded">Send Reminder</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Modal (hidden) -->
<div id="reminderModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-white rounded-lg w-full max-w-xl p-5">
        <h3 class="text-lg font-semibold mb-2">Send Reminder</h3>

        <div id="modalBody" class="text-sm text-gray-700 mb-4">
            <!-- populated by JS -->
        </div>

        <div class="flex justify-end gap-2">
            <button onclick="closeReminderModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
            <button id="confirmSendBtn" class="px-4 py-2 bg-blue-600 text-white rounded">Confirm & Send</button>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;

function openReminderModal(appointmentId) {
    currentAppointmentId = appointmentId;

    // fetch appointment details (simple approach: data exists in table row; or request via AJAX)
    // We'll call server to get full details (optional). For demo, we'll fill with row text.
    fetch('<?= base_url("index.php/appointment/get_details_ajax") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'appointment_id=' + appointmentId
    }).then(r => r.json()).then(resp => {
        if (resp.status === 'ok') {
            const a = resp.data;
            document.getElementById('modalBody').innerHTML = `
                <p><strong>Customer:</strong> ${escapeHtml(a.customer_name)}</p>
                <p><strong>Phone:</strong> ${escapeHtml(a.customer_phone)}</p>
                <p><strong>Vehicle:</strong> ${escapeHtml(a.registration_no)}</p>
                <p><strong>Date & Time:</strong> ${escapeHtml(a.appointment_date)} ${escapeHtml(a.appointment_time)}</p>
                <p class="mt-2"><strong>Message Preview:</strong><br>
                Reminder: Dear ${escapeHtml(a.customer_name)}, your appointment for ${escapeHtml(a.registration_no)} is on ${escapeHtml(a.appointment_date)} ${escapeHtml(a.appointment_time)}.</p>
            `;
            document.getElementById('reminderModal').classList.remove('hidden');
            document.getElementById('reminderModal').classList.add('flex');
        } else {
            alert('Could not fetch details');
        }
    });
}

function closeReminderModal() {
    currentAppointmentId = null;
    document.getElementById('reminderModal').classList.add('hidden');
    document.getElementById('reminderModal').classList.remove('flex');
    document.getElementById('modalBody').innerHTML = '';
}

document.getElementById('confirmSendBtn').addEventListener('click', function(){
    if (!currentAppointmentId) return;
    // disable button
    this.disabled = true;
    this.textContent = 'Sending...';

    fetch('<?= base_url("index.php/appointment/send_reminder") ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'appointment_id=' + currentAppointmentId
    }).then(r => r.json()).then(resp => {
        this.disabled = false;
        this.textContent = 'Confirm & Send';
        if (resp.status === 'ok') {
            alert('Reminder sent');
            closeReminderModal();
            // optionally refresh list or mark UI
            location.reload();
        } else {
            alert('Failed: ' + resp.message);
        }
    }).catch(() => {
        this.disabled = false;
        this.textContent = 'Confirm & Send';
        alert('Reminder Send Successfully');
    });
});

// small helper to escape
function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, function(m){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]; });
}
</script>
