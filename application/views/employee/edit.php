<div class="bg-white rounded-xl shadow p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Edit Employee</h2>

        <a href="<?= base_url('index.php/employee') ?>"
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Employee List
        </a>
    </div>

    <form method="post"
          action="<?= base_url('index.php/Employee/update') ?>"
          enctype="multipart/form-data">

        <input type="hidden" name="employee_id"
               value="<?= $employee->employee_id ?>">

        <!-- BASIC DETAILS -->
        <h3 class="font-semibold text-gray-700 mb-2 border-b pb-1">
            Basic Details
        </h3>

        <div class="grid grid-cols-3 gap-4">

            <div>
                <label>Employee Name *</label>
                <input type="text" name="employee_name"
                       value="<?= $employee->employee_name ?>"
                       required class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Mobile</label>
                <input type="text" name="mobile"
                       value="<?= $employee->mobile ?>"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Email ID</label>
                <input type="email" name="email"
                       value="<?= $employee->email ?>"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Joining Date</label>
                <input type="date" name="joining_date"
                       value="<?= $employee->joining_date ?>"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Address</label>
                <textarea name="address"
                          class="w-full border p-2 rounded"><?= $employee->address ?></textarea>
            </div>

            <div>
                <label>Department *</label>
                <select name="department_id"
                        class="w-full border p-2 rounded" required>
                    <?php foreach($departments as $d): ?>
                        <option value="<?= $d->department_id ?>"
                            <?= $d->department_id == $employee->department_id ? 'selected' : '' ?>>
                            <?= $d->department_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>Designation *</label>
                <select name="designation_id"
                        class="w-full border p-2 rounded" required>
                    <?php foreach($designations as $ds): ?>
                        <option value="<?= $ds->designation_id ?>"
                            <?= $ds->designation_id == $employee->designation_id ? 'selected' : '' ?>>
                            <?= $ds->designation_name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>Role</label>
                <select name="role"
                        class="w-full border p-2 rounded">
                    <option value="Technician" <?= $employee->role=='Technician'?'selected':'' ?>>Technician</option>
                    <option value="Advisor" <?= $employee->role=='Advisor'?'selected':'' ?>>Advisor</option>
                    <option value="Admin" <?= $employee->role=='Admin'?'selected':'' ?>>Admin</option>
                </select>
            </div>

            <div>
                <label>Software Access</label>
                <select name="software_access"
                        class="w-full border p-2 rounded">
                    <option value="Yes" <?= $employee->software_access=='Yes'?'selected':'' ?>>Yes</option>
                    <option value="No" <?= $employee->software_access=='No'?'selected':'' ?>>No</option>
                </select>
            </div>

        </div>

        <!-- PASSPORT DETAILS -->
        <h3 class="font-semibold text-gray-700 mt-6 mb-2 border-b pb-1">
            Passport Details
        </h3>

        <div class="grid grid-cols-3 gap-4">

            <div>
                <label>Passport Number</label>
                <input type="text" name="passport_number"
                       value="<?= $employee->passport_number ?>"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Passport Issue Date</label>
                <input type="date" name="passport_issue_date"
                       value="<?= $employee->passport_issue_date ?>"
                       class="w-full border p-2 rounded">
            </div>

            <div>
                <label>Passport Expiry Date</label>
                <input type="date" name="passport_expiry_date"
                       value="<?= $employee->passport_expiry_date ?>"
                       class="w-full border p-2 rounded">
            </div>

        </div>

        <!-- BUTTONS -->
        <div class="mt-6 flex gap-3">
            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Update Employee
            </button>

            <a href="<?= base_url('index.php/employee') ?>"
               class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                Cancel
            </a>
        </div>

    </form>
</div>
