<div class="bg-white shadow rounded-xl p-6">
<div class="flex justify-between items-center mb-6 border-b pb-3">

    <!-- Caption -->
    <h2 class="text-xl font-semibold text-gray-800">
        Employee Attendance
    </h2>

    <!-- Attendance List Button -->
    <a href="<?php echo base_url('index.php/Hr/view_emp_attendance_list'); ?>"
       class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm shadow">

        <!-- List Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>

        </svg>

        Attendance List

    </a>

</div>

<!-- Date Selection Form -->
<form id="main"
      method="post"
      action="<?php echo base_url() . 'index.php/'; ?>Hr/get_emp_attendance"
      autocomplete="off"
      enctype="multipart/form-data">

    <div class="grid grid-cols-12 gap-4 mb-4 items-center">

        <label class="col-span-12 md:col-span-2 font-medium">
            Attendance Date <span class="text-red-500">*</span>
        </label>

        <div class="col-span-12 md:col-span-3">

            <div class="flex">

                <input type="text"
                       tabindex="1"
                       id="a_date"
                       name="a_date"
                       value="<?php echo $a_date; ?>"
                       class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm datepicker1">

                <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 rounded-r-lg bg-gray-50">
                    📅
                </span>

            </div>

        </div>

        <div class="col-span-12 md:col-span-3">

            <button type="submit"
                    tabindex="2"
                    id="view"
                    name="go"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm shadow">

                Go

            </button>

        </div>

    </div>

</form>



<!-- Attendance Entry Form -->
<form id="secondary"
      method="post"
      action="<?php echo base_url() . 'index.php/'; ?>Hr/add_emp_attendance_data"
      autocomplete="off"
      enctype="multipart/form-data">


    <!-- Attendance Type -->
    <div class="grid grid-cols-12 gap-4 mb-6 items-center">

        <label class="col-span-12 md:col-span-2 font-medium">
            Attendance: <span class="text-red-500">*</span>
        </label>

        <div class="col-span-12 md:col-span-3">

            <select tabindex="3"
                    id="attendance"
                    name="attendance"
                    required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">

                <option value="">Select</option>
                <option value="P">Present</option>
                <option value="A">Absent</option>

            </select>

        </div>

        <input type="hidden"
               id="attendance_date"
               name="attendance_date"
               value="<?php echo $a_date; ?>">

    </div>



    <!-- Attendance Table -->
    <div class="overflow-x-auto">

        <table id="datatable"
               class="min-w-full border border-gray-200 rounded-lg text-sm text-left">

            <thead class="bg-gray-100 font-semibold">

                <tr>

                    <th class="px-4 py-3 border">Sr No</th>

                    <th class="px-4 py-3 border">Employee Name</th>

                    <th class="px-4 py-3 border text-center">
                        <input type="checkbox"
                               id="header-checkbox"
                               onclick="toggleAllCheckbox()">
                    </th>

                    <th class="px-4 py-3 border text-center">

                        Present In Time<br>

                        <input type="time"
                               id="header_in_time"
                               onchange="in_header_time();"
                               class="mt-1 border border-gray-300 rounded px-2 py-1 text-sm">

                    </th>

                    <th class="px-4 py-3 border text-center">

                        Present Out Time<br>

                        <input type="time"
                               id="header_out_time"
                               onchange="out_header_time();"
                               class="mt-1 border border-gray-300 rounded px-2 py-1 text-sm">

                    </th>

                </tr>

            </thead>



            <tbody class="divide-y">

                <?php $i = 1;
                foreach ($records1 as $row) { ?>

                <tr class="hover:bg-gray-50">

                    <td class="px-4 py-2 border">
                        <?php echo $i++; ?>
                    </td>


                    <td class="px-4 py-2 border">

                        <?php echo $row->username; ?>

                        <input type="hidden"
                               id="user_id"
                               name="user_id[]"
                               value="<?php echo $row->id; ?>">

                    </td>


                    <td class="px-4 py-2 border text-center">

                        <input type="checkbox"
                               id="checkbox"
                               name="checkbox[]"
                               class="checkbox"
                               value="<?php echo $row->id; ?>">

                    </td>


                    <td class="px-4 py-2 border">

                        <div class="flex items-center gap-2">

                            <label class="text-xs text-gray-600">
                                In Time:
                            </label>

                            <input type="time"
                                   id="in_time"
                                   name="in_time[]"
                                   class="border border-gray-300 rounded px-2 py-1 text-sm in_time">

                        </div>

                    </td>


                    <td class="px-4 py-2 border">

                        <div class="flex items-center gap-2">

                            <label class="text-xs text-gray-600">
                                Out Time:
                            </label>

                            <input type="time"
                                   id="out_time"
                                   name="out_time[]"
                                   class="border border-gray-300 rounded px-2 py-1 text-sm out_time">

                        </div>

                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>



    <!-- Submit Button -->
    <div class="text-center mt-6">

        <button type="submit"
                tabindex="4"
                id="add"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg shadow">

            Submit

        </button>

    </div>


</form>


</div>


<!-- Static Table End -->

<script>
	let headerTimeAlertShown = false; // Prevent repeated header alerts
	let rowTimeAlertShown = false; // Prevent repeated row alerts

	// Toggle all checkboxes
	function toggleAllCheckbox() {
		const headerCheckbox = document.getElementById('header-checkbox');
		const checkboxes = document.querySelectorAll('.checkbox');

		checkboxes.forEach(cb => {
			cb.checked = headerCheckbox.checked;
			handleCheckUncheck(cb);

			if (cb.checked) applyHeaderTimesToRow(cb.closest("tr"));
		});
	}

	// Handle required + clear time when unchecked
	function handleCheckUncheck(checkbox) {
		const row = checkbox.closest("tr");
		const inTime = row.querySelector(".in_time");
		const outTime = row.querySelector(".out_time");

		if (checkbox.checked) {
			inTime.required = true;
			outTime.required = true;

			applyHeaderTimesToRow(row);
		} else {
			inTime.required = false;
			outTime.required = false;
			inTime.value = "";
			outTime.value = "";
		}
	}

	// Apply header times to each checked row
	function applyHeaderTimesToRow(row) {
		const headerIn = document.getElementById("header_in_time").value;
		const headerOut = document.getElementById("header_out_time").value;

		if (headerIn) row.querySelector(".in_time").value = headerIn;
		if (headerOut) row.querySelector(".out_time").value = headerOut;

		validateInOut(row);
	}

	// HEADER IN TIME APPLY
	function in_header_time() {
		const headerTime = document.getElementById("header_in_time").value;
		const checkboxes = document.querySelectorAll(".checkbox");

		checkboxes.forEach(cb => {
			if (cb.checked) {
				const row = cb.closest("tr");
				row.querySelector(".in_time").value = headerTime;
				validateInOut(row);
			}
		});

		validateHeaderTimes();
	}

	// HEADER OUT TIME APPLY
	function out_header_time() {
		const headerTime = document.getElementById("header_out_time").value;
		const checkboxes = document.querySelectorAll(".checkbox");

		checkboxes.forEach(cb => {
			if (cb.checked) {
				const row = cb.closest("tr");
				row.querySelector(".out_time").value = headerTime;
				validateInOut(row);
			}
		});

		validateHeaderTimes();
	}

	// Validate header in/out equality (alert only once)
	function validateHeaderTimes() {
		const headerIn = document.getElementById("header_in_time").value;
		const headerOut = document.getElementById("header_out_time").value;

		if (headerIn && headerOut && headerIn === headerOut) {

			if (!headerTimeAlertShown) {
				alert("Header In-Time and Out-Time cannot be the same!");
				headerTimeAlertShown = true;
			}

			document.getElementById("header_out_time").value = ""; // Clear out-time
		} else {
			headerTimeAlertShown = false;
		}
	}

	// Validation for each row
	function validateInOut(row) {
		const inTime = row.querySelector(".in_time").value;
		const outTime = row.querySelector(".out_time").value;

		if (inTime && outTime && inTime === outTime) {

			if (!rowTimeAlertShown) {
				alert("In Time and Out Time cannot be the same!");
				rowTimeAlertShown = true;
			}

			row.querySelector(".out_time").value = ""; // Clear out-time
		} else {
			rowTimeAlertShown = false;
		}
	}

	// Individual row checkbox behaviour
	document.querySelectorAll(".checkbox").forEach(cb => {
		cb.addEventListener("change", function() {
			handleCheckUncheck(cb);

			const allCheckboxes = document.querySelectorAll('.checkbox');
			const checkedCount = document.querySelectorAll('.checkbox:checked').length;
			const headerCheckbox = document.getElementById('header-checkbox');

			headerCheckbox.checked = (checkedCount === allCheckboxes.length);
		});
	});

	// Listen for manual changes
	document.addEventListener("change", function(e) {
		if (e.target.classList.contains("in_time") ||
			e.target.classList.contains("out_time")) {

			const row = e.target.closest("tr");
			validateInOut(row);
			validateHeaderTimes();
		}
	});
</script>
