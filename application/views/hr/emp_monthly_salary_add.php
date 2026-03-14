<?php $this->load->helper('hr_helper'); ?>

<style>
    /* keep your existing custom styles */
    #datatable th {
        padding: 10px;
        font-size: 13px;
        background-color: #f2f2f2;
        padding-left: 25px;
    }

    #datatable input[type="text"],
    #datatable input[type="number"] {
        padding: 6px;
        font-size: 12px;
        width: 140px;
        box-sizing: border-box;
    }

    #remark {
        width: 180px;
        padding: 6px;
        font-size: 12px;
        height: 28px;
    }

    .table-scroll {
        max-height: 400px;
        overflow-y: auto;
        overflow-x: auto;
    }

    #datatable {
        width: 100%;
        border-collapse: collapse;
    }

    #datatable th,
    #datatable td {
        border: 1px solid #ddd;
        padding: 6px;
        text-align: left;
    }
</style>


<div class="bg-white shadow rounded-lg p-4">

    <!-- FORM 1 -->
    <form id="main" method="post"
        action="<?php echo base_url() . 'index.php/Hr/add_monthly_salary_data'; ?>"
        autocomplete="off"
        enctype="multipart/form-data">

        <div class="flex flex-wrap items-center gap-4 mb-4">

            <!-- Select Month -->
            <label class="w-full md:w-auto font-medium text-sm">
                Select Month <span class="text-red-500">*</span>
            </label>

            <div class="w-full md:w-48">
                <input type="month"
                    id="effective_date"
                    name="effective_date"
                    value="<?php echo date('Y-m', strtotime($effective_date)); ?>"
                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:ring focus:ring-blue-200">
            </div>

            <!-- Go Button -->
            <div>
                <input type="submit"
                    id="view"
                    name="go"
                    value="Go"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-1 rounded shadow">
            </div>

        </div>

    </form>


    <!-- FORM 2 -->
    <form id="main" method="post"
        action="<?php echo base_url() . 'index.php/Hr/add_emp_monthly_salary'; ?>"
        autocomplete="off"
        enctype="multipart/form-data">

        <input type="hidden"
            id="effective_date_hidden"
            name="effective_date_hidden"
            value="<?php echo date('M-Y', strtotime($effective_date)); ?>">


        <!-- TABLE -->
        <div class="table-scroll border rounded-lg">

            <table id="datatable" class="min-w-full text-sm">

                <thead class="bg-gray-100">

                    <tr class="text-gray-700 font-semibold">

                        <th rowspan="2">Sr No</th>

                        <th rowspan="2">
                            <input type="checkbox"
                                id="header-checkbox"
                                onclick="toggleAllCheckbox()">
                        </th>

                        <th rowspan="2">Employee Code</th>
                        <th rowspan="2">Employee Name</th>
                        <th rowspan="2">Designation</th>
                        <th rowspan="2">Department</th>
                        <th rowspan="2">Visa Status</th>
                        <th rowspan="2">Payment Mode</th>
                        <th rowspan="2">Basic Salary</th>
                        <th rowspan="2">Working Days<br>(Month)</th>
                        <th rowspan="2">Total Leave</th>
                        <th rowspan="2">Allowed Paid Leave</th>
                        <th rowspan="2">Used Paid Leave</th>
                        <th rowspan="2">Present Days</th>
                        <th rowspan="2">Company Holiday</th>
                        <th rowspan="2">Payment Days</th>
                        <th rowspan="2">CompOff Days</th>

                        <th colspan="3" class="text-center">
                            Overtime Earnings
                        </th>

                        <th rowspan="2">Sales Incentive</th>
                        <th rowspan="2">Monthly Allowances</th>
                        <th rowspan="2">Monthly Deduction</th>
                        <th rowspan="2">Earned Salary</th>
                        <th rowspan="2">Extra Allowances</th>
                        <th rowspan="2">Extra Deduction</th>
                        <th rowspan="2">Gross Pay</th>
                        <th rowspan="2">Net Pay</th>
                        <th rowspan="2">Remarks</th>

                    </tr>

                    <tr class="bg-gray-50 text-gray-700">

                        <th>OT Rate</th>
                        <th>OT Hrs</th>
                        <th>Over Time</th>

                    </tr>

                </thead>


                <tbody>

                    <?php if (!empty($records)): ?>
                        <?php $i = 1; foreach ($records as $row): ?>

                            <tr class="hover:bg-gray-50">

                                <td><?php echo $i; ?></td>

                                <td>
                                    <input type="checkbox"
                                        id="checkbox<?php echo $i ?>"
                                        name="checkbox[]"
                                        class="checkbox"
                                        value="<?php echo $row->id; ?>"
                                        onclick="handleCheckboxClick(<?php echo $i; ?>)">
                                </td>

                                <td></td>

                                <td>
                                    <?php echo $row->username; ?>
                                    <input type="hidden"
                                        id="nuser_id<?php echo $i ?>"
                                        name="nuser_id[]"
                                        value="<?php echo $row->id; ?>">
                                </td>

                                <td></td>
                                <td><?php echo $row->department_name; ?></td>
                                <td><?php echo $row->posession; ?></td>
                                <td></td>


                                <!-- INPUT STYLE -->
                                <td>
                                    <input type="number"
                                        name="basic_salary[]"
                                        id="basic_salary<?php echo $i ?>"
                                        value="<?php echo $row->basic_salary; ?>"
                                        readonly
                                        class="border border-gray-300 rounded px-2 py-1 w-24 bg-gray-100 text-sm">
                                </td>


                                <td>
                                    <input type="number"
                                        name="working_days[]"
                                        id="working_days<?php echo $i ?>"
                                        value="<?php echo $days_in_month; ?>"
                                        readonly
                                        class="border border-gray-300 rounded px-2 py-1 w-20 bg-gray-100 text-sm">
                                </td>


                                <!-- continue same pattern for all inputs -->

                                <td>
                                    <textarea
                                        id="remark<?php echo $i; ?>"
                                        name="remark[]"
                                        rows="1"
                                        placeholder="remark"
                                        class="border border-gray-300 rounded px-2 py-1 text-sm"></textarea>
                                </td>

                            </tr>

                        <?php $i++; endforeach; ?>
                    <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- ACCOUNT ENTRY -->
        <hr class="my-6 border-gray-300">

        <h6 class="bg-blue-50 text-blue-900 px-4 py-2 font-semibold border-l-4 border-blue-600 rounded shadow inline-block">
            Account Entry
        </h6>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

            <!-- DEBIT -->
            <table class="w-full border border-gray-300 rounded">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="border px-3 py-2 text-blue-800">Debit Entry (Dr)</th>
                        <th class="border px-3 py-2 text-blue-800">Debit Amount (AED)</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td class="border px-2 py-1">

                            <select id="inv_debtor0"
                                name="inv_debtor[]"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm">

                                <option value="">Select</option>

                                <?php foreach ($sundry_detors_records as $a): ?>

                                    <option value="<?php echo $a->account_id; ?>"
                                        <?php if ($a->account_id == 226) echo 'selected'; ?>>

                                        <?php echo $a->account_name; ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </td>

                        <td class="border px-2 py-1">

                            <input type="number"
                                id="inv_dr_amount0"
                                name="inv_dr_amount[]"
                                readonly
                                class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-sm">

                        </td>

                    </tr>

                </tbody>

            </table>


            <!-- CREDIT -->
            <table class="w-full border border-gray-300 rounded">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="border px-3 py-2 text-blue-800">Credit Entry (Cr)</th>
                        <th class="border px-3 py-2 text-blue-800">Credit Amount (AED)</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td class="border px-2 py-1">

                            <select id="inv_creditor0"
                                name="inv_creditor[]"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm">

                                <option value="">Select</option>

                                <?php foreach ($credit_records as $d): ?>

                                    <option value="<?php echo $d->account_id; ?>"
                                        <?php if ($d->account_id == 267) echo 'selected'; ?>>

                                        <?php echo $d->account_name; ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </td>

                        <td class="border px-2 py-1">

                            <input type="number"
                                id="inv_cr_amount0"
                                name="inv_cr_amount[]"
                                readonly
                                class="w-full border border-gray-300 rounded px-2 py-1 bg-gray-100 text-sm">

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- SUBMIT -->
        <div class="mt-6">

            <input type="hidden" name="empid" value="<?php echo $user_id; ?>">
            <input type="hidden" name="effective_date" value="<?php echo $effective_date; ?>">

            <button type="submit"
                id="add"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">

                Generate Monthly Salary

            </button>

        </div>

    </form>

</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            // "paging": true,
            "searching": true,
            // "ordering": true,
            // "order": [], // optional: default no ordering
            // "scrollY": "400px",
            // "scrollX": true
        });
    });


    // Function to toggle all checkboxes
    function toggleAllCheckbox() {
        const headerCheckbox = document.getElementById('header-checkbox');
        const isChecked = headerCheckbox.checked;

        document.querySelectorAll('.checkbox').forEach(checkbox => {
            checkbox.checked = isChecked;
            // Calculate amounts if the checkbox is checked
            if (isChecked) {
                calculateAmountForCheckbox(checkbox.id.replace('checkbox', '')); // Pass index
            } else {
                resetCalculation(checkbox.id.replace('checkbox', '')); // Reset if unchecked
            }
        });
    }

    // Handle individual checkbox click
    function handleCheckboxClick(index) {
        const checkbox = document.getElementById("checkbox" + index);
         const headerCheckbox = document.getElementById('header-checkbox');
        if (checkbox.checked) {
            calculateAmountForCheckbox(index); // Call calculation only if checked
             
        } else {
            resetCalculation(index); // Reset calculation if unchecked
             headerCheckbox.checked = false;
        }
    }

    // Function to calculate amount for a specific checkbox
    function calculateAmountForCheckbox(index) {
        // Call your calculation function here
        calculate_amount(index); // Assuming this function is defined elsewhere

    }

    // Function to reset calculation values for a specific index
    function resetCalculation(index) {
        // Reset any calculated values related to this index
        document.getElementById("payment_days" + index).value = 0; // Adjust according to your logic
        document.getElementById("gross_salary" + index).value = 0; // Adjust according to your logic
        document.getElementById("net_pay" + index).value = 0; // Adjust according to your logic
    }

    // Add event listener to handle the header-present checkbox
    document.getElementById('header-checkbox').addEventListener('change', toggleAllCheckbox);

    function calculate_amount(append) {
        var working_days = parseFloat(document.getElementById("working_days" + append).value) || 0;
        var leave_days = parseFloat(document.getElementById("leave_days" + append).value) || 0;
        var present_days = parseFloat(document.getElementById("present_days" + append).value) || 0;
        var comp_off = parseFloat(document.getElementById("comp_off" + append).value) || 0;

        var holiday_days = parseFloat(document.getElementById("holiday_days" + append).value) || 0;

        var usep_leave = parseFloat(document.getElementById("usep_leave" + append).value) || 0;
        var basic_salary = parseFloat(document.getElementById("basic_salary" + append).value) || 0;
        var total_overtime = parseFloat(document.getElementById("t_amt_overtime" + append).value) || 0;
        var total_allowances = parseFloat(document.getElementById("total_allowances" + append).value) || 0;
        var extra_allowances = parseFloat(document.getElementById("extra_allowances" + append).value) || 0;


        var total_deduction = parseFloat(document.getElementById("total_deduction" + append).value) || 0;
        var extra_deduction = parseFloat(document.getElementById("extra_deduction" + append).value) || 0;

        // Calculate payment days
        if (present_days > 0 || comp_off > 0 || usep_leave > 0) {

            var pay_days = present_days + usep_leave + holiday_days + comp_off;


            // var p_d = pay_days - leave_days;


            document.getElementById("payment_days" + append).value = pay_days;



        }
        // Calculate salary
        var monthly_a = basic_salary + total_allowances;


        var earn_sal = (monthly_a / working_days) * pay_days;

        // var s_follow_n = working_days

        // var perday_salary = basic_salary / working_days;
        // var emp_salary = perday_salary * pay_days;

        var gross = earn_sal + total_overtime + extra_allowances;

        var netpay = (gross - extra_deduction - total_deduction).toFixed(2);


        document.getElementById("earn_salary" + append).value = earn_sal;

        document.getElementById("gross_salary" + append).value = gross.toFixed(2);
        document.getElementById("net_pay" + append).value = netpay;
        updateTotal();

    }


    function validateInput(absentCount, index) {
        var inputField = document.getElementById("usep_leave" + index);
        var userValue = parseInt(inputField.value) || 0;

        if (userValue > absentCount) {

            alert("Please insert a value less than or equal to " + absentCount);


            inputField.value = 0;
        }
    }
</script>
<script>
    function searchTable() {
        // Get the value of the search input
        var input = document.getElementById('searchInput');
        var filter = input.value.toLowerCase();

        // Get the table and its rows
        var table = document.getElementById('datatable');
        var rows = table.getElementsByTagName('tr');

        // Loop through all table rows (except the first one, which is the header)
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var found = false;

            // Loop through the cells in each row
            for (var j = 0; j < cells.length; j++) {
                if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break; // Exit the loop if a match is found
                }
            }

            // Toggle the row's visibility based on the search
            if (found) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
    ///////////////////this tha javascript following cr dr total

    function updateTotal() {
        var total = 0;

        $("input.avarage_total").each(function() {
            var amount = parseFloat($(this).val());
            if (!isNaN(amount)) {
                total += amount;
            }
        });

        console.log("Calculated total:", total);

        $('#inv_dr_amount0').val(total.toFixed(2));
        $('#inv_cr_amount0').val(total.toFixed(2));
    }

    $(document).ready(function() {
        updateTotal();

        $(document).on('input', 'input.avarage_total', function() {
            updateTotal();
        });
    });
</script>
