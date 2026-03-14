<div class="p-6 max-w-xl">

    <h1 class="text-xl font-semibold text-gray-800 mb-6">
        <?= isset($department) ? 'Edit Department' : 'Add Department' ?>
    </h1>

    <form method="post" class="space-y-4">

        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Department Name
            </label>

            <input
                type="text"
                name="department_name"
                value="<?= isset($department)?$department->department_name:'' ?>"
                required
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">

        </div>

        <div class="flex gap-3 pt-3">

            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                Save
            </button>

            <a href="<?= base_url('org_structure/departments') ?>"
                class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600">
                Cancel
            </a>

        </div>

    </form>

</div>
