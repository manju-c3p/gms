<div class="w-full bg-white rounded-2xl shadow-md p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daily Job Report</h2>
            <p class="text-sm text-gray-500">
                Showing job cards for
                <span class="font-semibold"><?= date('d M Y', strtotime($date)) ?></span>
            </p>
        </div>

        <!-- DATE FILTER -->
        <form method="get" class="flex items-center gap-2">
            <input type="date"
                   name="date"
                   value="<?= $date ?>"
                   class="border rounded px-3 py-2 text-sm">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                Filter
            </button>
        </form>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        <?php
        $total = count($jobs);
        $completed = 0;
        $pending = 0;
        $inprogress = 0;

        foreach ($jobs as $j) {
            if ($j->status == 'Completed') $completed++;
            elseif ($j->status == 'In Progress') $inprogress++;
            else $pending++;
        }
        ?>

        <div class="bg-blue-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Total Jobs</p>
            <h3 class="text-2xl font-bold text-blue-700"><?= $total ?></h3>
        </div>

        <div class="bg-green-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Completed</p>
            <h3 class="text-2xl font-bold text-green-700"><?= $completed ?></h3>
        </div>

        <div class="bg-yellow-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">In Progress</p>
            <h3 class="text-2xl font-bold text-yellow-700"><?= $inprogress ?></h3>
        </div>

        <div class="bg-red-50 p-4 rounded-xl">
            <p class="text-sm text-gray-500">Pending</p>
            <h3 class="text-2xl font-bold text-red-700"><?= $pending ?></h3>
        </div>

    </div>

    <!-- JOB LIST TABLE -->
    <table id="dailyJobTable" class="w-full text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th>#</th>
                <th>Job Card No</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Vehicle</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($jobs)): ?>
                <?php $i = 1; foreach ($jobs as $job): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $job->jobcard_id ?></td>
                    <td><?= date('d-m-Y', strtotime($job->jobcard_date)) ?></td>
                    <td><?= $job->customer_name ?></td>
                    <td><?= $job->registration_no ?> (<?= $job->brand ?>)</td>
                    <td>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            <?= $job->status == 'Completed' ? 'bg-green-100 text-green-700' :
                                ($job->status == 'In Progress' ? 'bg-yellow-100 text-yellow-700' :
                                'bg-red-100 text-red-700') ?>">
                            <?= $job->status ?>
                        </span>
                    </td>
                    <td class="flex gap-2 justify-center">

                        <!-- VIEW JOB CARD -->
                        <a href="<?= base_url('index.php/jobcard/view/'.$job->jobcard_id) ?>"
                           class="p-2 rounded bg-yellow-100 hover:bg-yellow-200"
                           title="View Job Card">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-4 h-4 text-yellow-700">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 12s3.75-7.5 9.75-7.5
                                         9.75 7.5 9.75 7.5
                                         -3.75 7.5 -9.75 7.5
                                         S2.25 12 2.25 12z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0
                                         3 3 0 016 0z"/>
                            </svg>
                        </a>

                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        No job cards found for this date
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<!-- DATATABLE -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    new simpleDatatables.DataTable("#dailyJobTable", {
        searchable: true,
        fixedHeight: true,
        perPage: 10,
        labels: {
            placeholder: "Search jobs...",
            noRows: "No job cards found",
            info: "Showing {start} to {end} of {rows} jobs"
        }
    });
});
</script>
