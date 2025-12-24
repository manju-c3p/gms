<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <h2 class="text-2xl font-bold mb-4">Add Insurance Company</h2>

    <form method="POST" action="<?= base_url('index.php/insurancecompany/save'); ?>">

        <div class="grid grid-cols-2 gap-4">

            <!-- Company Name -->
            <div class="col-span-2">
                <label class="font-medium">Company Name <span class="text-red-500">*</span></label>
                <input type="text" name="company_name" required
                       class="w-full border p-2 rounded" placeholder="New India Assurance">
            </div>

            <!-- Phone -->
            <div>
                <label class="font-medium">Contact Number</label>
                <input type="text" name="contact_no"
                       class="w-full border p-2 rounded" placeholder="9876543210">
            </div>

            <!-- Email -->
            <div>
                <label class="font-medium">Email</label>
                <input type="email" name="email"
                       class="w-full border p-2 rounded" placeholder="support@company.com">
            </div>

            <!-- Address -->
            <div class="col-span-2">
                <label class="font-medium">Address</label>
                <textarea name="address"
                          class="w-full border p-2 rounded"
                          placeholder="Company full address"></textarea>
            </div>

        </div>

        <br>

        <button class="px-6 py-2 bg-blue-600 text-white rounded">
            Save Company
        </button>

        <a href="<?= base_url('index.php/insurancecompany/list'); ?>"
           class="ml-3 px-6 py-2 bg-gray-300 rounded">
            Cancel
        </a>

    </form>
</div>
