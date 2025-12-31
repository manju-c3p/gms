<div class="bg-white rounded-xl shadow p-6">

<h2 class="text-xl font-bold mb-4">Add Employee</h2>

<form method="post" action="<?= base_url('index.php/employee/save') ?>">

<div class="grid grid-cols-2 gap-4">

    <!-- Name -->
    <div>
        <label>Employee Name *</label>
        <input type="text" name="employee_name" required class="w-full border p-2 rounded">
    </div>

    <!-- Mobile -->
    <div>
        <label>Mobile</label>
        <input type="text" name="mobile" class="w-full border p-2 rounded">
    </div>

    <!-- Department -->
    <div>
        <label>Department *</label>
        <select name="department_id" id="deptSelect"
                class="w-full border p-2 rounded" required>
            <option value="">-- Select Department --</option>
            <?php foreach($departments as $d): ?>
                <option value="<?= $d->department_id ?>">
                    <?= $d->department_name ?>
                </option>
            <?php endforeach; ?>
            <option value="add_dept">+ Add Department</option>
        </select>
    </div>

    <!-- Designation -->
    <div>
        <label>Designation *</label>
        <select name="designation_id" id="desigSelect"
                class="w-full border p-2 rounded" required>
            <option value="">-- Select Designation --</option>
            <option value="add_desig">+ Add Designation</option>
        </select>
    </div>

    <!-- Role -->
    <div>
        <label>Role</label>
        <select name="role" class="w-full border p-2 rounded">
            <option value="Technician">Technician</option>
            <option value="Advisor">Advisor</option>
            <option value="Admin">Admin</option>
        </select>
    </div>

    <!-- Joining Date -->
    <div>
        <label>Joining Date</label>
        <input type="date" name="joining_date"
               class="w-full border p-2 rounded">
    </div>

</div>

<div class="mt-6">
    <button class="px-6 py-2 bg-blue-600 text-white rounded">
        Save Employee
    </button>
</div>

</form>
</div>
<div id="deptModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center">
  <div class="bg-white p-6 rounded w-96">
    <h3 class="font-bold mb-3">Add Department</h3>
    <input type="text" id="newDept" class="w-full border p-2 mb-4">
    <button onclick="saveDept()" class="bg-blue-600 text-white px-4 py-2 rounded">
        Save
    </button>
  </div>
</div>
<div id="desigModal" class="hidden fixed inset-0 bg-black/40 flex justify-center items-center">
  <div class="bg-white p-6 rounded w-96">
    <h3 class="font-bold mb-3">Add Designation</h3>

    <select id="desigDept" class="w-full border p-2 mb-3">
        <?php foreach($departments as $d): ?>
            <option value="<?= $d->department_id ?>">
                <?= $d->department_name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="text" id="newDesig" class="w-full border p-2 mb-4">

    <button onclick="saveDesig()" class="bg-blue-600 text-white px-4 py-2 rounded">
        Save
    </button>
  </div>
</div>
<script>
	$('#deptSelect').on('change', function () {

    let deptId = this.value;

    // Reset designation dropdown
    $('#desigSelect').html('<option value="">-- Select Designation --</option>');

    if (deptId === 'add_dept') {
        $('#deptModal').removeClass('hidden');
        this.value = '';
        return;
    }

    if (!deptId) return;

    // Load designations for selected department
    $.post(
        '<?= base_url("index.php/employee/get_designations_by_department") ?>',
        { department_id: deptId },
        function (res) {

            let options = '<option value="">-- Select Designation --</option>';

            JSON.parse(res).forEach(d => {
                options += `<option value="${d.designation_id}">
                                ${d.designation_name}
                            </option>`;
            });

            // IMPORTANT: Keep Add Designation option
            options += '<option value="add_desig">+ Add Designation</option>';

            $('#desigSelect').html(options);
        }
    );
});


$('#desigSelect').on('change', function () {
    if (this.value === 'add_desig') {
        $('#desigModal').removeClass('hidden');
        this.value = '';
    }
});

function saveDept() {
    $.post('<?= base_url("index.php/employee/save_department") ?>',
        { name: $('#newDept').val() },
        function () { location.reload(); }
    );
}

function saveDesig() {
    $.post('<?= base_url("index.php/employee/save_designation") ?>',
        {
            department_id: $('#desigDept').val(),
            name: $('#newDesig').val()
        },
        function () { location.reload(); }
    );
}

</script>
