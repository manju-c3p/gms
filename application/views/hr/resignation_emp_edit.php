


<div class="bg-white shadow rounded-lg p-6">



    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">
            Edit Employee Resignation
        </h2>

        <a href="<?php echo base_url('index.php/Hr/view_emp_regignation_list'); ?>"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
            <i class="fa-solid fa-list"></i>
            Resignation List
        </a>
    </div>

    <!-- Your form here -->



    <?php foreach ($records as $row): ?>
        <form onsubmit="return check_duplicate_exist();" method="post"
            action="<?php echo base_url('index.php/Hr/update_emp_regignation'); ?>" autocomplete="off"
            enctype="multipart/form-data">

            <!-- Employee Name -->
            <div class="grid grid-cols-12 gap-4 mb-4 items-center">
                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Employee Name:
                </label>

                <div class="col-span-12 md:col-span-5">
                    <?php foreach ($user_records as $s): ?>
                        <?php if ($row->employee_id == $s->id): ?>

                            <input type="text"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
                                value="<?php echo $s->username; ?>" readonly>

                            <input type="hidden" name="employee_id_hidden"
                                value="<?php echo $s->id; ?>">

                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>


            <!-- Resignation Code -->
            <div class="grid grid-cols-12 gap-4 mb-4 items-center">

                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Resignation Code:
                </label>

                <div class="col-span-12 md:col-span-5">

                    <input type="text"
                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm bg-gray-100"
                        name="ra_code"
                        value="<?php echo $row->resign_code; ?>"
                        readonly>

                </div>

            </div>


            <!-- Resignation Date -->
            <div class="grid grid-cols-12 gap-4 mb-4 items-center">

                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Resignation Date:
                </label>

                <div class="col-span-12 md:col-span-5">

                    <input type="text"
                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
                        name="resignation_date"
                        value="<?php echo date('d-m-Y', strtotime($row->resignation_date) ?? '') ?>">

                </div>

            </div>


            <!-- Last Working Date -->
            <div class="grid grid-cols-12 gap-4 mb-4 items-center">

                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Effective Last Working Date:
                </label>

                <div class="col-span-12 md:col-span-5">

                    <input type="text"
                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm datepicker1"
                        name="last_working_date"
                        value="<?php echo date('d-m-Y', strtotime($row->last_working_date) ?? '') ?>">

                </div>

            </div>


            <!-- Notice Days -->
            <div class="grid grid-cols-12 gap-4 mb-4 items-center">

                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Total Notice Period Days:
                </label>

                <div class="col-span-12 md:col-span-5">

                    <input type="text"
                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                        name="notice_days"
                        value="<?php echo $row->notice_days; ?>">

                </div>

            </div>


            <!-- Resignation Reason -->
            <div class="grid grid-cols-12 gap-4 mb-4">

                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Resignation Reasons:
                </label>

                <div class="col-span-12 md:col-span-5">

                    <textarea name="reason"
                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm"><?php echo $row->reason; ?></textarea>

                </div>

            </div>


            <!-- Document Upload -->
            <div class="grid grid-cols-12 gap-4 mb-4">

                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Upload (jpeg, jpg, png, doc, pdf):
                </label>

                <div class="col-span-12 md:col-span-8">

                    <table class="min-w-full border border-gray-300 rounded text-sm"
                        id="tab_logic">

                        <tbody>

                            <tr id='addr0' class="border-b">

                                <td class="border border-gray-300 px-2 py-1">1</td>

                                <td class="border border-gray-300 px-2 py-1">

                                    <input
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                                        name="documents_res[]"
                                        type="file">

                                </td>

                                <td class="border border-gray-300 px-2 py-1">

                                    <select
                                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                                        name="document_types[]">

                                        <option value="" selected disabled>
                                            Please select document type
                                        </option>

                                        <option value="Resignation Letter">Resignation Letter</option>
                                        <option value="Resignation Form">Resignation Form</option>
                                        <option value="MOHRE Cancellation Paper">MOHRE Cancellation Paper</option>
                                        <option value="Clearance Paper">Clearance Paper</option>
                                        <option value="Final Settlement Letter">Final Settlement Letter</option>
                                        <option value="Labor Cancellation">Labor Cancellation</option>
                                        <option value="Visa Cancellation">Visa Cancellation</option>
                                        <option value="Other">Other</option>

                                    </select>

                                </td>

                                <td class="border border-gray-300 px-2 py-1">

                                    <a id="add_row"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded bg-blue-100 text-blue-600 hover:bg-blue-200 cursor-pointer">

                                        <span class="fa fa-plus"></span>

                                    </a>

                                    <a id="delete_row"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-100 text-red-600 hover:bg-red-200 cursor-pointer ml-2">

                                        <span class="fa fa-trash"></span>

                                    </a>

                                </td>

                            </tr>


                            <?php
                            if ($file_records) {
                                $x = 1;
                                $i = 1;
                                foreach ($file_records as $k): ?>

                                    <tr id="doc_row_<?php echo $k->doc_id; ?>" class="border-b">

                                        <td class="border border-gray-300 px-2 py-1">
                                            <?php echo $i++; ?>
                                        </td>

                                        <td class="border border-gray-300 px-2 py-1">

                                            <a href="<?php echo base_url('public/uploded_documents/' . $k->document_path); ?>"
                                                download
                                                class="text-blue-600 hover:underline">

                                                File <?php echo $x++; ?>

                                            </a>

                                        </td>

                                        <td class="border border-gray-300 px-2 py-1">
                                            <?php echo $k->document_name; ?>
                                        </td>

                                        <td class="border border-gray-300 px-2 py-1">

                                            <button type="button"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-100 text-red-600 hover:bg-red-200"
                                                onclick="deleteDocument(<?php echo $k->doc_id; ?>)">

                                                <span class="fa fa-trash"></span>

                                            </button>

                                        </td>

                                    </tr>

                                <?php endforeach;
                            } ?>

                            <tr id='addr1'></tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- Buttons -->
            <div class="grid grid-cols-12 gap-4 mb-4">

                <div class="col-span-12">

                    <input type="hidden"
                        name="id"
                        value="<?php echo $row->resig_id; ?>">


                    <?php if ($row->approve_flag == 0): ?>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">

                            Update

                        </button>

                    <?php else: ?>

                        <button type="button"
                            class="px-4 py-2 bg-blue-400 text-white text-sm rounded cursor-not-allowed"
                            disabled>

                            Update

                        </button>

                    <?php endif; ?>


                    <?php $login_ids = $this->session->userdata('user_id'); ?>

                    <?php foreach ($admin_hr as $s): ?>

                        <?php if (($login_ids == $s->approve_hr || $login_ids == $s->approve_admin_md) && $s->approve_type == 'Resignation' && $row->approve_flag == 0): ?>

                            <button type="button"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 ml-2"
                                onclick="confirmCancel(<?php echo $row->resig_id; ?>)">

                                Approve Resignation

                            </button>

                            <button type="button"
                                class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 ml-2"
                                onclick="showRejectRemark(<?php echo $row->resig_id; ?>)">

                                Reject Resignation

                            </button>

                        <?php endif; ?>

                    <?php endforeach; ?>


                    <?php if ($row->approve_flag == 1): ?>

                        <a href="<?php echo base_url('index.php/Hr/print_experience_certificate/' . $row->resig_id); ?>"
                            target="_blank"
                            class="inline-block px-4 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700 ml-2">

                            Print Experience Certificate

                        </a>

                    <?php endif; ?>

                </div>

            </div>


            <!-- Rejection Remark Section -->
            <div class="grid grid-cols-12 gap-4 mb-4 mt-3"
                id="remark_section_<?php echo $row->resig_id; ?>"
                style="display:none;">

                <label class="col-span-12 md:col-span-3 text-sm font-medium text-gray-700">
                    Rejection Remark:
                </label>

                <div class="col-span-12 md:col-span-5">

                    <textarea
                        id="reject_remark_<?php echo $row->resig_id; ?>"
                        class="w-full border border-gray-300 rounded px-2 py-1 text-sm"
                        placeholder="Enter rejection remark"></textarea>

                </div>

                <div class="col-span-12 md:col-span-4 mt-2">

                    <button type="button"
                        class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                        onclick="confirmReject(<?php echo $row->resig_id; ?>)">

                        Confirm Reject

                    </button>

                </div>

            </div>

        </form>

    <?php endforeach; ?>

</div>

<script>
    $(document).ready(function () {
        var i = 1;
        $("#add_row").click(function () {
            $('#addr' + i).html(
                "<td>" + (i + 1) + "</td>" +
                "<td><input class='form-control form-control-sm' name='documents_res[]' type='file'></td>" +
                "<td>" +
                "<select class='form-select form-control-sm' name='document_types[]'>" +
                "<option value='' selected disabled>Please select document type</option>" +
                "<option value='Resignation Letter'>Resignation Letter</option>" +
                "<option value='Resignation Form'>Resignation Form</option>" +
                "<option value='MOHRE Cancellation Paper'>MOHRE Cancellation Paper</option>" +
                "<option value='Clearance Paper'>Clearance Paper</option>" +
                "<option value='Final Settlement Letter'>Final Settlement Letter</option>" +
                "<option value='Labor Cancellation'>Labor Cancellation</option>" +
                "<option value='Visa Cancellation'>Visa Cancellation</option>" +
                "<option value='Other'>Other</option>" +
                "</select>" +
                "</td>" +
                "<td><button type='button' class='btn btn-sm bg-blue remove_row'><span class='fa fa-trash'></span></button></td>"
            );
            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
        });

        // Confirmation before removing row
        $(document).on('click', '.remove_row', function () {
            if (confirm("Are you sure you want to delete this row?")) {
                $(this).closest('tr').remove();

                // Optional: Re-number rows after deletion
                $('#tab_logic tbody tr').each(function (index) {
                    $(this).find('td:first').html(index + 1);
                });

                // Decrement row counter to keep adding rows correctly
                i = $('#tab_logic tbody tr').length - 1; // exclude last empty row
            }
        });

        // Initially hide the last empty row (addr1)
        $('#addr1').html('');
    });


    // Approval
    function confirmCancel(resig_id) {

        var u_id = document.getElementById('employee_id_hidden');
        if (confirm("Are you sure you want to Approve this Resignation?")) {
            $.ajax({
                url: "<?php echo base_url('index.php/Ajax/update_resign_flag'); ?>",
                type: "POST",
                data: {
                    table_name: 'employee_resignation',
                    where_key: 'resig_id',
                    where_val: resig_id,
                    column: 'approve_flag',
                    value: 1,
                    user_id : u_id,

                },
                success: function (response) {
                    if (response == 1) {
                        alert("Resignation approved successfully.");
                        location.reload();
                    } else {
                        alert("Failed to approve resignation.");
                    }
                }
            });
        }
    }

    // Show Reject Remark
    function showRejectRemark(resig_id) {
        $('#remark_section_' + resig_id).show();
    }

    function confirmReject(resig_id) {
        var remark = $('#reject_remark_' + resig_id).val().trim();
        var u_id = document.getElementById('employee_id_hidden');
        if (remark === '') {
            alert("Please provide a rejection remark.");
            return;
        }

        if (confirm("Are you sure you want to Reject this Resignation?")) {
            $.ajax({
                url: "<?php echo base_url('index.php/Ajax/reject_emp_resignation'); ?>",
                type: "POST",
                data: {
                    resig_id: resig_id,
                    reject_remark: remark,
                    user_id : u_id,
                },
                success: function (response) {
                    if (response == 1) {
                        alert("Resignation rejected successfully.");
                        location.reload();
                    } else {
                        alert("Failed to reject resignation.");
                    }
                },
                error: function () {
                    alert("Error occurred while rejecting resignation.");
                }
            });
        }
    }

    function deleteDocument(doc_id) {
        if (confirm("Are you sure you want to delete this document?")) {
            $.ajax({
                url: "<?php echo base_url('index.php/Ajax/delete_resignation_document'); ?>",
                type: "POST",
                data: { doc_id: doc_id },
                success: function (response) {
                    if (response == 1) {
                        alert("Document deleted successfully.");
                        $('#doc_row_' + doc_id).remove(); // Remove the row from DOM
                    } else {
                        alert("Failed to delete document.");
                    }
                },
                error: function () {
                    alert("Error occurred while deleting the document.");
                }
            });
        }
    }


</script>
