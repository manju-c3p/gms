<?php
$today = new DateTime();
$startDate = (new DateTime())->modify('-44 days');

$attendanceMap = [];
if (!empty($records) && is_array($records)) {
    foreach ($records as $rec) {
        $attendanceMap[$rec->Attendance_date] = $rec;
    }
}
?>
<?php
$statusMap = [];
foreach ($status as $row) {
    $statusMap[$row->form_date] = $row->approved_flag;
} ?>


<style>
    #datatable th {
        padding: 10px;
        font-size: 13px;
        background-color: #f2f2f2;
        padding-left: 25px;
    }

    #datatable input[type="text"],
    #datatable input[type="time"],
    #datatable textarea {
        font-size: 12px;
        width: 140px;
        box-sizing: border-box;
    }

    #datatable textarea {
        height: 30px;
        width: 180px;
        resize: vertical;
    }

    .table-scroll {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: auto;
        border: 1px solid #ccc;
    }

    #datatable {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    #datatable th,
    #datatable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .present {
        color: green;
        font-weight: bold;
    }

    .absent {
        color: red;
        font-weight: bold;
    }
</style>

<div class="card-body">
    <?php $name = $this->session->userdata('user_name'); ?>
    <?php $user_id = $this->session->userdata('user_id'); ?>


    <!-- Attendance Table -->
    <div class="dt-responsive table-responsive table-scroll">
        <table id="datatable" class="table table-striped">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Date</th>
                    <th>Attendance</th>
                    <th>Recorde In Time</th>
                    <th>Recorded Out Time</th>
                    <th>Requested In Time</th>
                    <th>Requested Out Time</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $sr = 1;
                for ($date = clone $today; $date >= $startDate; $date->modify('-1 day')):
                    $dateStr = $date->format('Y-m-d');
                    $record = $attendanceMap[$dateStr] ?? null;
                    $displayDate = $date->format('d-m-Y');
                ?>

                    <tr>
                        <td><?= $sr++ ?></td>
                        <td><?= $displayDate ?></td>
                        <td>
                            <?php
                            if ($record) {
                                if ($record->attendence == 'P') echo '<span class="present">Present</span>';
                                elseif ($record->attendence == 'A') echo '<span class="absent">Absent</span>';
                                else echo htmlspecialchars($record->attendence);
                            } else {
                                echo '<span class="absent">Missing</span>';
                            }
                            ?>
                        </td>
                        <td><?= $record->in_time ?? '—' ?></td>
                        <td><?= $record->out_time ?? '—' ?></td>

                        <td>
                            <input type="hidden" class="form-control form-control-sm"
                                id="ivms_id<?= $dateStr ?>"
                                name="ivms_id[<?= $dateStr ?>]"
                                value="<?= $record->ivms_id ?? '' ?>">



                            <input type="hidden" class="form-control form-control-sm"
                                id="rec_in_time_<?= $dateStr ?>"
                                name="rec_in_time_[<?= $dateStr ?>]"
                                value="<?= $record->in_time ?? '' ?>">

                            <input type="time" class="form-control form-control-sm"
                                id="in_time_<?= $dateStr ?>"
                                name="in_time[<?= $dateStr ?>]"
                                value="<?= $record->in_time ?? '' ?>">
                        </td>
                        <td>
                            <input type="hidden" class="form-control form-control-sm"
                                id="rec_out_time_<?= $dateStr ?>"
                                name="rec_out_time[<?= $dateStr ?>]"
                                value="<?= $record->out_time ?? '' ?>">

                            <input type="time" class="form-control form-control-sm"
                                id="out_time_<?= $dateStr ?>"
                                name="out_time[<?= $dateStr ?>]"
                                value="<?= $record->out_time ?? '' ?>">
                        </td>
                        <td>
                            <textarea name="remark_<?= $dateStr ?>" id="remark_<?= $dateStr ?>" placeholder="Remark"><?= $record->remark ?? '' ?></textarea>
                        </td>
                        <td>
                            <?php
                            // Default values
                            $latest_status = 'Request Not <br> Send';
                            $status_color = 'gray';

                            // Check if there is a matching status for this date
                            $approved_flag = $statusMap[$dateStr] ?? null;

                            if ($approved_flag === '0' || $approved_flag === 0) {
                                $latest_status = 'Pending';
                                $status_color = 'yellow';
                            } elseif ($approved_flag === '1' || $approved_flag === 1) {
                                $latest_status = 'Approved';
                                $status_color = 'green';
                            } elseif ($approved_flag === '2' || $approved_flag === 2) {
                                $latest_status = 'Rejected';
                                $status_color = 'red';
                            } elseif ($approved_flag === '3' || $approved_flag === 3) {
                                $latest_status = 'Cancelled';
                                $status_color = '#ff8c00';
                            } elseif ($approved_flag === '4' || $approved_flag === 4) {
                                $latest_status = 'Cancelled by HR';
                                $status_color = '#800080';
                            }

                            echo '<span style="color:' . $status_color . '; font-weight: bold;">' . $latest_status . '</span>';
                            ?> </td>
                        <td>
                            <input type="button" class="btn btn-primary btn-sm" value="Submit"
                                onclick="submit_data_mismatch_request(<?= $user_id ?>, '<?= $dateStr ?>')"> <br>
                            <!-- <a href="<?php echo base_url(); ?>" title="cancel request"
                                onclick="return confirmCancel(<?php echo $user_id; ?>,'<?= $dateStr ?>');">Cancel Request</a> -->

                        </td>
                    </tr>
                <?php endfor; ?>

            </tbody>
        </table>
    </div>
</div>
</div>
<script>
    function submit_data_mismatch_request(user_id, date) {
        const inTimeEl = document.getElementById(`in_time_${date}`);
        const outTimeEl = document.getElementById(`out_time_${date}`);


        const rec_inTimeEl = document.getElementById(`rec_in_time_${date}`);
        const rec_outTimeEl = document.getElementById(`rec_out_time_${date}`);


        const remarkEl = document.getElementById(`remark_${date}`);

        const ivms_idl = document.getElementById(`ivms_id${date}`);

        if (!inTimeEl || !outTimeEl || !remarkEl) {
            alert('Required input elements not found.');
            return;
        }

        const inTime = inTimeEl.value;
        const outTime = outTimeEl.value;

        const rec_inTime = rec_inTimeEl.value;
        const rec_outTime = rec_outTimeEl.value;

        const remark = remarkEl.value;
        const ivms_id = ivms_idl.value;

        const application_date = new Date().toISOString().slice(0, 10); // Today's date

        if (!inTime || !outTime || !remark) {
            alert('Please fill in all fields.');
            return;
        }

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Ajax/ajax_get_mismatch_attendance_info",
            type: "POST",
            dataType: "json",
            data: {
                user_id: user_id,
                date: date,
                inTime: inTime,
                outTime: outTime,
                remark: remark,
                ivms_id: ivms_id,
                rec_inTime: rec_inTime,
                rec_outTime: rec_outTime


            },
            success: function(response) {
                if (response.success) {
                    alert("Request Send Successfully!");
                } else {
                    alert("Data update failed!");
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert("Something went wrong!");
            }
        });
    }




    function confirmCancel(tid , date) {
        var r = confirm("Are you sure you want to Cancel Employee Request?");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Ajax/cancel_emp_request",
                type: "POST",
                data: {
                    table_name: 'employee_request_data',
                    where_key: 'emp_req_id',
                    where_val: tid,
                    column: 'approved_flag',
                    value: 4
                },
                success: function(msg) {
                    if (msg == 1) {
                        window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
                    } else {
                        alert("Unable to update the request status.");
                    }
                },
                error: function() {
                    alert("An error occurred while processing the request.");
                }
            });
            return true;
        } else {
            return false;
        }
    }
</script>