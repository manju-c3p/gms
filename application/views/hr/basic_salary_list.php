<div class="bg-white shadow rounded-xl p-6">


	<div class="flex justify-between items-center mb-4">

    <!-- Caption -->
    <h2 class="text-xl font-semibold text-gray-800">
        Salary Structure List
    </h2>

    <!-- Add Basic Salary Button -->
    <a href="<?php echo base_url('index.php/Hr/add_emp_salary_structure'); ?>"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow">

        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4"/>

        </svg>

        Add Basic Salary

    </a>

</div>

    <div class="overflow-x-auto">

        <table id="datatable"
               class="min-w-full border border-gray-200 rounded-lg text-sm text-left text-gray-700">

            <!-- Header -->
            <thead class="bg-gray-100 text-xs font-semibold uppercase text-gray-600">

                <tr>

                    <th class="px-4 py-3 border">Sr No</th>

                    <th class="px-4 py-3 border">Employee Name</th>

                    <th class="px-4 py-3 border">Gross Salary</th>

                    <th class="px-4 py-3 border">Date</th>

                    <th class="px-4 py-3 border text-center">Action</th>

                </tr>

            </thead>



            <!-- Body -->
            <tbody class="divide-y divide-gray-200">

                <?php $i = 1;
                foreach ($records as $row) { ?>

                    <tr class="hover:bg-gray-50">

                        <!-- Sr No -->
                        <td class="px-4 py-2 border">
                            <?php echo $i; $i++; ?>
                        </td>


                        <!-- Employee Name -->
                        <td class="px-4 py-2 border">
                            <?php echo $row->name; ?>
                        </td>


                        <!-- Gross Salary -->
                        <td class="px-4 py-2 border">
                            <?php echo $row->gross_salary; ?>
                        </td>


                        <!-- Date -->
                        <td class="px-4 py-2 border">
                            <?php echo date('d-M-Y', strtotime($row->effective_date)); ?>
                        </td>


                        <!-- Action -->
                        <td class="px-4 py-2 border text-center whitespace-nowrap">

                            <!-- Edit -->
                            <a href="<?php echo base_url() . 'index.php/Hr/edit_salary_structure/' . $row->sid; ?>"
                               title="Edit"
                               class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg">

                                <!-- Pencil Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-4 h-4"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5h2m-1-1v2m-7.293 9.293l9-9a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414l-9 9L7 17l-1.707-1.707z"/>

                                </svg>

                            </a>


                            <!-- Delete -->
                            <a href="<?php echo base_url() . 'index.php/Hr/delete_basic_salary/' . $row->sid; ?>"
                               title="Delete"
                               onclick="return confirmcancel(<?php echo $row->sid;?>);"
                               class="inline-flex items-center justify-center w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg ml-2">

                                <!-- Trash Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-4 h-4"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M6 7h12M9 7v12m6-12v12M4 7h16l-1 14H5L4 7zm3-3h10l1 3H6l1-3z"/>

                                </svg>

                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>


<!-- Static Table End -->



<script>
    function confirmcancel(tid) {
        var r = confirm("Are you sure you want to Delete Record?");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
                type: "POST",
                data: {
                    table_name: 'salary_structure',
                    where_key: 'sid',
                    where_val: tid
                },
                success: function(msg) {
                    if (msg == 1) {
                        // alert("Record deleted");
                        window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
                    } else {
                        alert("Can't Delete record. Data already exist!!!");
                    }
                },
            });
            return true;
        } else
            return false;

    }
</script>
